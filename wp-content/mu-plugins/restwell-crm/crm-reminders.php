<?php
/**
 * CRM auto-reminders for stale "new" enquiries.
 *
 * Why this file exists:
 *   The CRM dashboard relies on someone actually opening it. If an enquiry
 *   lands at 5pm on a Friday and nobody opens wp-admin until Monday, it
 *   silently rots. This module nudges the team by email when an enquiry
 *   has sat in the "new" status for too long, without ever sending more
 *   than one reminder per 24h per enquiry.
 *
 * Behaviour at a glance:
 *   - WP-Cron runs hourly via the `restwell_crm_reminder_check` event.
 *   - For every enquiry where status = 'new' AND submitted >= STALE_HOURS
 *     ago AND we have not reminded in REMINDER_REPEAT_HOURS, we email the
 *     team submission notify inbox (`restwell_get_submission_notify_email()`),
 *     stamp `last_reminder_at`, and append an audit-log note.
 *   - All thresholds are filterable so they can be tuned in production
 *     without touching code.
 *   - A `restwell_crm_reminder_dry_run` filter (or the `RESTWELL_CRM_REMINDER_DRY_RUN`
 *     constant) lets us preview matches without sending mail or writing
 *     to the database — useful for validating after a content backfill
 *     or schema change.
 *
 * @package Restwell_CRM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * How many hours an enquiry must sit in `status = 'new'` before it counts
 * as stale. 18h is intentional: it bridges Friday-evening submits to
 * Monday-morning triage without spamming for "this morning's" enquiries.
 */
const RESTWELL_CRM_REMINDER_STALE_HOURS = 18;

/**
 * Minimum gap between two reminders for the same enquiry. 24h prevents the
 * hourly cron from re-pinging the same row every single hour after the
 * stale threshold is crossed — staff get one nudge per day, no more.
 */
const RESTWELL_CRM_REMINDER_REPEAT_HOURS = 24;

/**
 * Cron hook name. Kept distinct from `restwell_gg_dispatch_scheduled` so
 * each subsystem can be toggled or rescheduled independently.
 */
const RESTWELL_CRM_REMINDER_HOOK = 'restwell_crm_reminder_check';

// =============================================================================
// Cron registration
// =============================================================================

/**
 * Register the hourly cron event on `init` if it is not already scheduled.
 *
 * Mirrors the guest-guide pattern in inc/guest-guide.php so that operations
 * staff have a single mental model for "where do scheduled jobs live".
 */
function restwell_crm_reminder_schedule_cron(): void {
	if ( ! wp_next_scheduled( RESTWELL_CRM_REMINDER_HOOK ) ) {
		wp_schedule_event( time() + HOUR_IN_SECONDS, 'hourly', RESTWELL_CRM_REMINDER_HOOK );
	}
}
add_action( 'init', 'restwell_crm_reminder_schedule_cron' );

/**
 * Clear the scheduled cron event when the active theme changes.
 *
 * CRM lives in a must-use plugin, but this hook still prevents a stale
 * `restwell_crm_reminder_check` event if the theme (or whole stack) is replaced.
 */
function restwell_crm_reminder_clear_cron(): void {
	$timestamp = wp_next_scheduled( RESTWELL_CRM_REMINDER_HOOK );
	if ( $timestamp ) {
		wp_unschedule_event( $timestamp, RESTWELL_CRM_REMINDER_HOOK );
	}
	wp_clear_scheduled_hook( RESTWELL_CRM_REMINDER_HOOK );
}
add_action( 'switch_theme', 'restwell_crm_reminder_clear_cron' );

// =============================================================================
// Cron callback
// =============================================================================

add_action( RESTWELL_CRM_REMINDER_HOOK, 'restwell_crm_reminder_run' );

/**
 * Find stale enquiries, email a reminder, and record the nudge.
 *
 * Designed to be safely re-runnable: the SQL guard on `last_reminder_at`
 * means firing the cron twice in the same hour is a no-op for already
 * reminded enquiries.
 */
function restwell_crm_reminder_run(): void {
	$stale_hours  = (int) apply_filters( 'restwell_crm_reminder_stale_hours',  RESTWELL_CRM_REMINDER_STALE_HOURS );
	$repeat_hours = (int) apply_filters( 'restwell_crm_reminder_repeat_hours', RESTWELL_CRM_REMINDER_REPEAT_HOURS );

	// Defensive clamping — a misconfigured filter must not turn this cron
	// into a per-minute spam cannon or wedge the threshold to "never".
	$stale_hours  = max( 1, min( 168, $stale_hours ) );   // 1h … 7d
	$repeat_hours = max( 1, min( 168, $repeat_hours ) );  // 1h … 7d

	$dry_run = restwell_crm_reminder_is_dry_run();

	$rows = restwell_crm_reminder_fetch_stale( $stale_hours, $repeat_hours );
	if ( empty( $rows ) ) {
		return;
	}

	foreach ( $rows as $row ) {
		$recipient = restwell_get_submission_notify_email();
		if ( '' === $recipient ) {
			// Misconfigured notify address — skip rather than wp_mail to empty.
			continue;
		}

		$mail = restwell_crm_reminder_build_email( $row, $stale_hours );

		if ( $dry_run ) {
			restwell_crm_reminder_log_dry_run( (int) $row->id, $recipient, $mail['subject'] );
			continue;
		}

		$sent = restwell_wp_mail_with_retry( $recipient, $mail['subject'], $mail['body'], $mail['headers'] );

		// Always stamp `last_reminder_at` on attempt — even on send failure.
		// Otherwise a broken SMTP would cause the cron to re-attempt every
		// hour for every stale enquiry. Activity log records the outcome
		// so staff can manually retry from the CRM if needed.
		restwell_crm_reminder_mark_reminded( (int) $row->id );

		if ( function_exists( 'restwell_crm_add_note' ) ) {
			$note = $sent
				? sprintf(
					/* translators: 1: number of hours the enquiry has been "new"; 2: recipient email address. */
					__( 'Automated reminder: enquiry has been in "new" for %1$d hours; reminder email sent to %2$s.', 'restwell-retreats' ),
					(int) round( restwell_crm_reminder_age_hours( (string) $row->submitted_at ) ),
					$recipient
				)
				: sprintf(
					/* translators: %s: recipient email address that wp_mail rejected. */
					__( 'Automated reminder: tried to nudge %s but wp_mail returned false (SMTP/transport issue). Please follow up manually or check the mail log.', 'restwell-retreats' ),
					$recipient
				);
			restwell_crm_add_note( (int) $row->id, $note );
		}
	}
}

// =============================================================================
// Query helpers
// =============================================================================

/**
 * Fetch all enquiries that need a reminder right now.
 *
 * One SQL query keeps the cron O(1) regardless of inbox size. The composite
 * `status_submitted` index defined on the table makes the WHERE on
 * (status, submitted_at) cheap.
 *
 * @param int $stale_hours  Minimum age (in hours) for an enquiry to count as stale.
 * @param int $repeat_hours Minimum gap (in hours) between two reminders for the same enquiry.
 * @return object[]         Array of enquiry rows (subset of columns we need to send mail).
 */
function restwell_crm_reminder_fetch_stale( int $stale_hours, int $repeat_hours ): array {
	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_CRM_TABLE;

	$now            = current_time( 'mysql' );
	$stale_cutoff   = gmdate( 'Y-m-d H:i:s', strtotime( $now ) - ( $stale_hours  * HOUR_IN_SECONDS ) );
	$repeat_cutoff  = gmdate( 'Y-m-d H:i:s', strtotime( $now ) - ( $repeat_hours * HOUR_IN_SECONDS ) );

	// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	$results = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT id, name, email, phone, preferred_dates, num_guests, message,
			        is_urgent, submitted_at, last_reminder_at
			 FROM {$table}
			 WHERE status = 'new'
			   AND submitted_at <= %s
			   AND ( last_reminder_at IS NULL OR last_reminder_at <= %s )
			 ORDER BY is_urgent DESC, submitted_at ASC
			 LIMIT 50",
			$stale_cutoff,
			$repeat_cutoff
		)
	);

	return is_array( $results ) ? $results : array();
}

/**
 * Stamp the row's `last_reminder_at` to "now" so the next cron tick skips it.
 *
 * @param int $enquiry_id Enquiry row ID.
 */
function restwell_crm_reminder_mark_reminded( int $enquiry_id ): void {
	global $wpdb;
	$wpdb->update(
		$wpdb->prefix . RESTWELL_CRM_TABLE,
		array( 'last_reminder_at' => current_time( 'mysql' ) ),
		array( 'id' => $enquiry_id ),
		array( '%s' ),
		array( '%d' )
	);
}

// =============================================================================
// Email composition
// =============================================================================

/**
 * Build the staff-facing reminder email payload for a single enquiry.
 *
 * Plain text matches the existing staff-notification style in
 * enquire-handler.php so reminders sit comfortably alongside fresh
 * enquiry alerts in the team inbox.
 *
 * @param object $row         Enquiry row from the database.
 * @param int    $stale_hours Threshold the enquiry tripped, used for friendlier copy.
 * @return array{subject:string, body:string, headers:string[]}
 */
function restwell_crm_reminder_build_email( object $row, int $stale_hours ): array {
	$age_hours = (int) round( restwell_crm_reminder_age_hours( (string) $row->submitted_at ) );
	$urgent    = (int) $row->is_urgent === 1;

	$subject_prefix = $urgent ? '[URGENT] ' : '';
	$subject        = sprintf(
		/* translators: 1: optional "[URGENT] " prefix, 2: enquirer name, 3: number of hours stale. */
		'%1$s[Restwell Retreats] Reminder: %2$s enquiry waiting %3$dh — please follow up',
		$subject_prefix,
		(string) $row->name,
		$age_hours
	);

	$crm_url = add_query_arg(
		array(
			'page' => 'restwell-enquiries',
			'view' => (int) $row->id,
		),
		admin_url( 'admin.php' )
	);

	$lines   = array();
	$lines[] = sprintf(
		/* translators: %d: number of hours since the enquiry was submitted. */
		__( 'This enquiry has been sitting in "new" for about %d hours. Please follow up or reassign.', 'restwell-retreats' ),
		$age_hours
	);
	$lines[] = '';
	$lines[] = '— Enquiry summary —';
	$lines[] = 'Name:    ' . (string) $row->name;
	$lines[] = 'Email:   ' . (string) $row->email;
	if ( '' !== (string) $row->phone ) {
		$lines[] = 'Phone:   ' . (string) $row->phone;
	}
	if ( '' !== (string) $row->preferred_dates ) {
		$lines[] = 'Dates:   ' . (string) $row->preferred_dates;
	}
	if ( '' !== (string) $row->num_guests ) {
		$lines[] = 'Guests:  ' . (string) $row->num_guests;
	}
	$lines[] = 'Submitted: ' . mysql2date( 'D j M Y \a\t H:i', (string) $row->submitted_at );
	if ( $urgent ) {
		$lines[] = 'Urgent:  yes (flagged by guest at submission)';
	}
	if ( '' !== (string) $row->message ) {
		$lines[] = '';
		$lines[] = '— Their message —';
		$lines[] = wp_strip_all_tags( (string) $row->message );
	}
	$lines[] = '';
	$lines[] = __( 'Open in CRM:', 'restwell-retreats' );
	$lines[] = $crm_url;
	$lines[] = '';
	$lines[] = sprintf(
		/* translators: %d: stale-threshold hours. */
		__( '(Auto-sent because the enquiry crossed the %dh stale threshold. You will not be reminded again about this enquiry for at least 24 hours.)', 'restwell-retreats' ),
		$stale_hours
	);

	$body    = implode( "\n", $lines );
	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		// Replying goes straight to the guest, not back into the cron job.
		'Reply-To: ' . (string) $row->name . ' <' . (string) $row->email . '>',
	);

	return array(
		'subject' => $subject,
		'body'    => $body,
		'headers' => $headers,
	);
}

// =============================================================================
// Dry-run support
// =============================================================================

/**
 * Whether the cron should run in dry-run mode (no mail, no DB writes).
 *
 * Two ways to enable, in order of precedence:
 *   - Define `RESTWELL_CRM_REMINDER_DRY_RUN` to true in wp-config.php.
 *   - Hook the `restwell_crm_reminder_dry_run` filter and return true.
 *
 * Dry-run still runs the SELECT, so `error_log` will show exactly which
 * enquiries would have been mailed and to whom — perfect for verifying
 * threshold tuning before flipping the switch in production.
 *
 * @return bool
 */
function restwell_crm_reminder_is_dry_run(): bool {
	if ( defined( 'RESTWELL_CRM_REMINDER_DRY_RUN' ) && RESTWELL_CRM_REMINDER_DRY_RUN ) {
		return true;
	}
	return (bool) apply_filters( 'restwell_crm_reminder_dry_run', false );
}

/**
 * Write a single dry-run line to the PHP error log when WP_DEBUG is on.
 *
 * @param int    $enquiry_id Enquiry row ID.
 * @param string $recipient  Resolved recipient email address.
 * @param string $subject    Subject line that would have been sent.
 */
function restwell_crm_reminder_log_dry_run( int $enquiry_id, string $recipient, string $subject ): void {
	if ( ! defined( 'WP_DEBUG' ) || ! WP_DEBUG ) {
		return;
	}
	// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
	error_log( sprintf(
		'[Restwell CRM Reminder][dry-run] enquiry #%d → %s | %s',
		$enquiry_id,
		$recipient,
		$subject
	) );
}

// =============================================================================
// Small numeric helper
// =============================================================================

/**
 * Hours elapsed since `$submitted_at` (interpreted in site local time).
 *
 * Returns 0.0 when the timestamp can't be parsed so callers always get a
 * sane number to feed into `round()`.
 *
 * @param string $submitted_at MySQL DATETIME string from `wp_rw_enquiries`.
 * @return float
 */
function restwell_crm_reminder_age_hours( string $submitted_at ): float {
	$submitted_ts = strtotime( $submitted_at );
	if ( ! $submitted_ts ) {
		return 0.0;
	}
	$now_ts = strtotime( current_time( 'mysql' ) );
	if ( ! $now_ts ) {
		return 0.0;
	}
	return max( 0.0, ( $now_ts - $submitted_ts ) / HOUR_IN_SECONDS );
}

// =============================================================================
// WP-CLI: optional manual trigger for ops
// =============================================================================

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	/**
	 * Manually run the stale-enquiry reminder check from the command line.
	 *
	 * ## OPTIONS
	 *
	 * [--dry-run]
	 * : Preview matches without sending email or stamping `last_reminder_at`.
	 *
	 * ## EXAMPLES
	 *
	 *   wp restwell crm-reminders run
	 *   wp restwell crm-reminders run --dry-run
	 */
	WP_CLI::add_command(
		'restwell crm-reminders run',
		static function ( array $args, array $assoc_args ): void {
			unset( $args );
			if ( ! empty( $assoc_args['dry-run'] ) ) {
				add_filter( 'restwell_crm_reminder_dry_run', '__return_true' );
				WP_CLI::log( 'Dry-run mode: no mail will be sent, no DB writes will happen.' );
			}
			restwell_crm_reminder_run();
			WP_CLI::success( 'Reminder check complete. Inspect debug.log for dry-run output.' );
		}
	);
}
