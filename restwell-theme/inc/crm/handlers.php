<?php
/**
 * CRM: admin-post and AJAX request handlers.
 *
 * @package Restwell_CRM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ─────────────────────────────────────────────────────────────────────────────
// 6. ADMIN POST HANDLERS
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Blank care and accessibility columns unless a privileged sensitive export was requested.
 *
 * @param array<int, array<string, mixed>> $rows Enquiry rows as associative arrays.
 * @param bool                             $include_sensitive True when the operator opted in and is allowed to.
 * @return array<int, array<string, mixed>>
 */
function restwell_crm_redact_sensitive_export_rows( array $rows, bool $include_sensitive ): array {
	if ( $include_sensitive ) {
		return $rows;
	}
	foreach ( $rows as &$row ) {
		if ( isset( $row['care_requirements'] ) ) {
			$row['care_requirements'] = '';
		}
		if ( isset( $row['accessibility'] ) ) {
			$row['accessibility'] = '';
		}
	}
	unset( $row );
	return $rows;
}

/**
 * Accept a Y-m-d date from an export form field.
 *
 * @param mixed $raw Posted value.
 * @return string Valid Y-m-d or empty string.
 */
function restwell_crm_sanitize_export_ymd( $raw ): string {
	$raw = sanitize_text_field( (string) wp_unslash( $raw ) );
	$dt  = DateTimeImmutable::createFromFormat( '!Y-m-d', $raw );
	if ( ! $dt || $dt->format( 'Y-m-d' ) !== $raw ) {
		return '';
	}
	return $raw;
}

/**
 * Stream enquiries as a UTF-8 CSV download.
 *
 * Optional submitted_from / submitted_to (Y-m-d, inclusive, site timezone)
 * limit rows by submitted_at. Blank dates export every enquiry.
 */
function restwell_crm_handle_export_csv() {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'Insufficient permissions.', 'restwell-retreats' ) );
	}
	check_admin_referer( 'restwell_crm_export_csv' );

	$include_sensitive = restwell_crm_can_export_sensitive()
		&& isset( $_POST['include_sensitive'] )
		&& '1' === (string) wp_unslash( $_POST['include_sensitive'] );

	$from = isset( $_POST['submitted_from'] ) ? restwell_crm_sanitize_export_ymd( $_POST['submitted_from'] ) : '';
	$to   = isset( $_POST['submitted_to'] ) ? restwell_crm_sanitize_export_ymd( $_POST['submitted_to'] ) : '';
	if ( $from && $to && $from > $to ) {
		$swap = $from;
		$from = $to;
		$to   = $swap;
	}

	global $wpdb;
	$table       = $wpdb->prefix . RESTWELL_CRM_TABLE;
	$where_parts = array();
	if ( $from ) {
		$where_parts[] = $wpdb->prepare( 'submitted_at >= %s', $from . ' 00:00:00' );
	}
	if ( $to ) {
		$next_day = ( new DateTimeImmutable( $to ) )->modify( '+1 day' )->format( 'Y-m-d' );
		$where_parts[] = $wpdb->prepare( 'submitted_at < %s', $next_day . ' 00:00:00' );
	}
	$where_sql = $where_parts ? ( ' WHERE ' . implode( ' AND ', $where_parts ) ) : '';

	// Explicit column list — avoids pulling unexpected columns added by future migrations.
	// phpcs:disable WordPress.DB.PreparedSQL -- $where_sql is built solely from $wpdb->prepare() fragments; table via %i.
	$rows = $wpdb->get_results(
		$wpdb->prepare(
			'SELECT id, submitted_at, name, email, phone,
			        preferred_dates, date_from, date_to, num_guests,
			        care_requirements, accessibility, funding_type,
			        contact_preference, preferred_time, heard_about, message,
			        is_urgent, marketing_optin, marketing_optin_at,
			        privacy_consented_at, privacy_policy_version,
			        health_data_consent, health_data_consented_at,
			        status, staff_notes, follow_up_at,
			        last_reminder_at, contacted_at, qualified_at, booked_at, closed_at,
			        anonymised_at
			 FROM %i' . $where_sql . ' ORDER BY submitted_at DESC',
			$table
		),
		ARRAY_A
	);
	// phpcs:enable WordPress.DB.PreparedSQL
	if ( ! is_array( $rows ) ) {
		$rows = array();
	}

	$rows = restwell_crm_redact_sensitive_export_rows( $rows, $include_sensitive );

	// Append to audit log before streaming headers (headers cannot be sent before update_option).
	$export_log_entry = array(
		'user_id'            => get_current_user_id(),
		'exported_at'        => gmdate( 'Y-m-d H:i:s' ),
		'row_count'          => count( $rows ),
		'include_sensitive'  => $include_sensitive ? 1 : 0,
		'submitted_from'     => $from,
		'submitted_to'       => $to,
	);
	$export_log = get_option( 'restwell_crm_export_log', array() );
	if ( ! is_array( $export_log ) ) {
		$export_log = array();
	}
	$export_log[] = $export_log_entry;
	update_option( 'restwell_crm_export_log', array_slice( $export_log, -200 ) ); // keep last 200 entries

	$filename = 'restwell-enquiries';
	if ( $from && $to && $from === $to ) {
		$filename .= '-' . $from;
	} elseif ( $from && $to ) {
		$filename .= '-' . $from . '-to-' . $to;
	} elseif ( $from ) {
		$filename .= '-from-' . $from;
	} elseif ( $to ) {
		$filename .= '-to-' . $to;
	} else {
		$filename .= '-' . gmdate( 'Y-m-d' );
	}
	$filename .= '.csv';

	header( 'Content-Type: text/csv; charset=UTF-8' );
	header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
	header( 'Pragma: no-cache' );
	header( 'Expires: 0' );

	$out = fopen( 'php://output', 'w' );
	// BOM for Excel UTF-8 compatibility.
	fprintf( $out, chr( 0xEF ) . chr( 0xBB ) . chr( 0xBF ) );

	if ( ! empty( $rows ) ) {
		fputcsv( $out, array_keys( $rows[0] ) );
		foreach ( $rows as $row ) {
			fputcsv( $out, $row );
		}
	}

	fclose( $out ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fclose
	exit;
}
add_action( 'admin_post_restwell_crm_export_csv', 'restwell_crm_handle_export_csv' );

/**
 * Send a one-line test to the notify address (or admin email) so SMTP / Mailpit can be proved.
 */
function restwell_crm_handle_send_test_mail(): void {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'Insufficient permissions.', 'restwell-retreats' ) );
	}
	check_admin_referer( 'restwell_crm_send_test_mail' );

	$redirect = static function ( string $status ): void {
		wp_safe_redirect(
			add_query_arg(
				array(
					'page'      => 'restwell-crm',
					'smtp_test' => $status,
				),
				admin_url( 'admin.php' )
			)
		);
		exit;
	};

	if ( false !== get_transient( 'restwell_crm_smtp_test_lock' ) ) {
		$redirect( 'rate' );
	}

	$to = restwell_get_submission_notify_email();
	if ( ! is_email( $to ) ) {
		$redirect( 'no_recipient' );
	}

	$transport = ( function_exists( 'restwell_smtp_is_configured' ) && restwell_smtp_is_configured() )
		? 'SMTP'
		: 'PHP mail';
	$subject   = '[Restwell] Test email from CRM';
	$body      = restwell_email_staff_body(
		array(
			'label'   => __( 'Delivery test', 'restwell-retreats' ),
			'heading' => __( 'Your mail settings are working', 'restwell-retreats' ),
			'intro'   => __( 'This was sent from the Restwell CRM dashboard. If it looks right here, notification emails will look right too.', 'restwell-retreats' ),
			'rows'    => array(
				__( 'Transport', 'restwell-retreats' ) => $transport,
				__( 'Sent', 'restwell-retreats' )      => wp_date( 'D j M Y \a\t H:i' ),
			),
			'note'    => __( 'Delivery to your inbox proves wp_mail() works. It does not prove SPF, DKIM or DMARC are set up for the sending domain.', 'restwell-retreats' ),
			'preview' => __( 'CRM delivery test', 'restwell-retreats' ),
		)
	);
	$headers   = restwell_email_staff_headers();

	$ok = function_exists( 'restwell_wp_mail_with_retry' )
		? restwell_wp_mail_with_retry( $to, $subject, $body, $headers )
		: wp_mail( $to, $subject, $body, $headers );

	set_transient( 'restwell_crm_smtp_test_lock', 1, 5 * MINUTE_IN_SECONDS );
	$redirect( $ok ? 'ok' : 'fail' );
}
add_action( 'admin_post_restwell_crm_send_test_mail', 'restwell_crm_handle_send_test_mail' );

/**
 * Send the post-stay follow-up email for a closed enquiry.
 */
function restwell_crm_handle_send_post_stay() {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'Insufficient permissions.', 'restwell-retreats' ) );
	}

	$id = absint( $_POST['rw_enquiry_id'] ?? 0 );
	check_admin_referer( 'restwell_crm_send_post_stay_' . $id );

	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_CRM_TABLE;
	$row = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM %i WHERE id = %d', $table, $id ) );

	if ( $row && function_exists( 'restwell_email_post_stay' ) ) {
		$email_data = restwell_email_post_stay( $row->email, $row->name );
		$sent       = function_exists( 'restwell_wp_mail_with_retry' )
			? restwell_wp_mail_with_retry( $row->email, $email_data['subject'], $email_data['body'], $email_data['headers'] )
			: wp_mail( $row->email, $email_data['subject'], $email_data['body'], $email_data['headers'] );
		restwell_service_crm_gateway()->add_enquiry_note(
			$id,
			$sent
				? __( 'Post-stay email sent.', 'restwell-retreats' )
				: __( 'Automated note: post-stay email did not send (SMTP/mail transport). Please follow up from CRM or resend manually.', 'restwell-retreats' )
		);
	}

	wp_safe_redirect(
		add_query_arg(
			array(
				'page' => 'restwell-enquiries',
				'view' => $id,
				'updated' => '1',
			),
			admin_url( 'admin.php' )
		)
	);
	exit;
}
add_action( 'admin_post_restwell_crm_send_post_stay', 'restwell_crm_handle_send_post_stay' );

/**
 * Resend one enquiry’s staff notification to the shared notify inbox.
 */
function restwell_crm_handle_resend_enquiry_notification(): void {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'Insufficient permissions.', 'restwell-retreats' ) );
	}

	$id = absint( $_POST['rw_enquiry_id'] ?? 0 );
	check_admin_referer( 'restwell_crm_resend_notification_' . $id );

	$redirect = static function ( int $enquiry_id, string $status ): void {
		wp_safe_redirect(
			add_query_arg(
				array(
					'page'        => 'restwell-enquiries',
					'view'        => $enquiry_id,
					'notify_mail' => $status,
				),
				admin_url( 'admin.php' )
			)
		);
		exit;
	};

	if ( $id < 1 ) {
		$redirect( 0, 'missing' );
	}

	$lock_key = 'restwell_crm_resend_lock_' . $id;
	if ( false !== get_transient( $lock_key ) ) {
		$redirect( $id, 'rate' );
	}

	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_CRM_TABLE;
	$row   = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM %i WHERE id = %d', $table, $id ) );

	if ( ! $row ) {
		$redirect( $id, 'missing' );
	}

	if ( ! empty( $row->anonymised_at ) ) {
		$redirect( $id, 'anonymised' );
	}

	$to = restwell_get_submission_notify_email();
	if ( ! is_email( $to ) ) {
		$redirect( $id, 'no_recipient' );
	}

	if ( ! function_exists( 'restwell_send_enquiry_staff_notification' ) ) {
		$redirect( $id, 'fail' );
	}

	$data           = restwell_enquiry_notification_data_from_row( $row );
	$data['resent'] = true;
	$sent           = restwell_send_enquiry_staff_notification( $data );

	if ( $sent ) {
		set_transient( $lock_key, 1, 20 );
		restwell_service_crm_gateway()->add_enquiry_note(
			$id,
			sprintf(
				/* translators: %s: staff notify email address. */
				__( 'Staff notification resent to %s.', 'restwell-retreats' ),
				$to
			)
		);
		$redirect( $id, 'ok' );
	}

	restwell_service_crm_gateway()->add_enquiry_note(
		$id,
		sprintf(
			/* translators: %s: staff notify email address. */
			__( 'Tried to resend the staff notification to %s but the mailer returned false. Check SMTP and try again.', 'restwell-retreats' ),
			$to
		)
	);
	$redirect( $id, 'fail' );
}
add_action( 'admin_post_restwell_crm_resend_enquiry_notification', 'restwell_crm_handle_resend_enquiry_notification' );

/**
 * Save the notification email setting.
 */
function restwell_crm_handle_save_settings() {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'Insufficient permissions.', 'restwell-retreats' ) );
	}
	check_admin_referer( 'restwell_crm_settings' );

	// Notify inbox is fixed to hello@ (see restwell_get_submission_notify_email).
	// Keep the option in sync so older readers still show the correct address.
	update_option( 'restwell_enquiry_notify_email', 'hello@restwellretreats.co.uk', false );

	// Phone, schema address, verification, analytics, property line, footer CTA, access PDF:
	// managed under SEO → Site-wide (restwell_seo_sitewide_handle_save).

	if ( function_exists( 'restwell_crm_reminder_clamp_hours' ) ) {
		$reminder_enabled = ! empty( $_POST['restwell_crm_reminder_enabled'] ) ? '1' : '0';
		update_option( 'restwell_crm_reminder_enabled', $reminder_enabled, false );

		$stale_hours = isset( $_POST['restwell_crm_reminder_stale_hours'] )
			? absint( wp_unslash( $_POST['restwell_crm_reminder_stale_hours'] ) )
			: 18;
		update_option( 'restwell_crm_reminder_stale_hours', restwell_crm_reminder_clamp_hours( $stale_hours ), false );

		$repeat_hours = isset( $_POST['restwell_crm_reminder_repeat_hours'] )
			? absint( wp_unslash( $_POST['restwell_crm_reminder_repeat_hours'] ) )
			: 24;
		update_option( 'restwell_crm_reminder_repeat_hours', restwell_crm_reminder_clamp_hours( $repeat_hours ), false );
	}

	$mailchimp_api_key = isset( $_POST['restwell_mailchimp_api_key'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_mailchimp_api_key'] ) )
		: '';
	$mailchimp_api_key = preg_replace( '/[^A-Za-z0-9\-]/', '', trim( $mailchimp_api_key ) );
	$mailchimp_key_blocked = false;
	$is_production         = function_exists( 'wp_get_environment_type' ) && 'production' === wp_get_environment_type();
	if ( ! $is_production && function_exists( 'restwell_is_production_environment' ) ) {
		$is_production = restwell_is_production_environment();
	}

	// ICS feed URL is managed on Restwell → Availability (restwell_crm_handle_save_availability).

	// Prefer RESTWELL_MAILCHIMP_API_KEY in wp-config; option is fallback only and must not autoload.
	// Never persist the key in wp_options when WP_ENVIRONMENT_TYPE is production.
	if ( $is_production ) {
		if ( '' !== $mailchimp_api_key || ! empty( $_POST['restwell_mailchimp_api_key_clear'] ) ) {
			$mailchimp_key_blocked = true;
		}
	} elseif ( '' !== $mailchimp_api_key ) {
		update_option( 'restwell_mailchimp_api_key', $mailchimp_api_key, false );
	} elseif ( ! empty( $_POST['restwell_mailchimp_api_key_clear'] ) ) {
		update_option( 'restwell_mailchimp_api_key', '', false );
	}

	$mailchimp_audience_id = isset( $_POST['restwell_mailchimp_audience_id'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_mailchimp_audience_id'] ) )
		: '';
	$mailchimp_audience_id = preg_replace( '/[^0-9A-Za-z]/', '', $mailchimp_audience_id );
	update_option( 'restwell_mailchimp_audience_id', $mailchimp_audience_id, false );

	$mailchimp_server_prefix = isset( $_POST['restwell_mailchimp_server_prefix'] )
		? sanitize_key( wp_unslash( $_POST['restwell_mailchimp_server_prefix'] ) )
		: '';
	update_option( 'restwell_mailchimp_server_prefix', $mailchimp_server_prefix, false );

	// Role grants broaden PII access — administrators only.
	if ( current_user_can( 'manage_options' ) ) {
		$raw_cap_roles = isset( $_POST['restwell_crm_cap_roles'] ) ? (array) wp_unslash( $_POST['restwell_crm_cap_roles'] ) : array();
		$cap_roles     = array_values(
			array_intersect(
				array_map( 'sanitize_key', $raw_cap_roles ),
				array( 'administrator', 'editor', 'author' )
			)
		);
		if ( empty( $cap_roles ) ) {
			$cap_roles = array( 'administrator' );
		}
		update_option( 'restwell_crm_cap_roles', $cap_roles );
	}

	$redirect_args = array(
		'page'           => 'restwell-crm',
		'settings_saved' => '1',
	);
	if ( ! empty( $mailchimp_key_blocked ) ) {
		$redirect_args['mailchimp_key_blocked'] = '1';
	}
	wp_safe_redirect(
		add_query_arg(
			$redirect_args,
			admin_url( 'admin.php' )
		)
	);
	exit;
}
add_action( 'admin_post_restwell_save_settings', 'restwell_crm_handle_save_settings' );

/**
 * Add a note to the enquiry activity log.
 */
function restwell_crm_handle_add_note() {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'Insufficient permissions.', 'restwell-retreats' ) );
	}
	check_admin_referer( 'restwell_crm_add_note' );

	$enquiry_id = absint( $_POST['rw_enquiry_id'] ?? 0 );
	$note       = sanitize_textarea_field( wp_unslash( $_POST['rw_note_text'] ?? '' ) );

	if ( $enquiry_id && $note ) {
		restwell_service_crm_gateway()->add_enquiry_note( $enquiry_id, $note );
	}

	wp_safe_redirect(
		add_query_arg(
			array(
				'page' => 'restwell-enquiries',
				'view' => $enquiry_id,
				'note_added' => '1',
			),
			admin_url( 'admin.php' )
		)
	);
	exit;
}
add_action( 'admin_post_restwell_crm_add_note', 'restwell_crm_handle_add_note' );

/**
 * Update an enquiry's stay dates from the detail page.
 *
 * Why this exists separately from the public enquiry form's validation:
 * - Admins are allowed to set dates in the past (cleaning up historical records,
 *   logging arrival info after the fact, etc.). The public-form rule that
 *   "preferred dates can't be in the past" doesn't apply to staff.
 * - Admins are allowed to clear dates entirely (a guest changes their mind,
 *   or the original submission was a typo). Empty string → NULL in the DB,
 *   and `preferred_dates` gets recomputed to "" in lockstep.
 * - Every change is recorded as an automated note ("Stay dates updated:
 *   {old} → {new}") so the activity log stays an honest audit trail.
 *
 * Re-uses `restwell_format_enquiry_date_range()` so the human-readable
 * `preferred_dates` string the rest of the CRM displays stays byte-identical
 * to what the public form would have written.
 */
function restwell_crm_handle_update_stay_dates(): void {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'Insufficient permissions.', 'restwell-retreats' ) );
	}
	check_admin_referer( 'restwell_crm_update_stay_dates' );

	$enquiry_id = absint( $_POST['rw_enquiry_id'] ?? 0 );
	$date_from  = sanitize_text_field( wp_unslash( $_POST['rw_date_from'] ?? '' ) );
	$date_to    = sanitize_text_field( wp_unslash( $_POST['rw_date_to'] ?? '' ) );

	if ( ! $enquiry_id ) {
		wp_die( esc_html__( 'Missing enquiry ID.', 'restwell-retreats' ) );
	}

	$redirect_base = add_query_arg(
		array(
			'page' => 'restwell-enquiries',
			'view' => $enquiry_id,
		),
		admin_url( 'admin.php' )
	);

	// Format check: empty is fine (= clear the field), but anything non-empty
	// must be a valid Y-m-d. We deliberately *don't* reject past dates here —
	// see the docblock above.
	$valid_ymd = static function ( string $d ): bool {
		return '' === $d || (bool) preg_match( '/^\d{4}-\d{2}-\d{2}$/', $d );
	};
	if ( ! $valid_ymd( $date_from ) || ! $valid_ymd( $date_to ) ) {
		wp_safe_redirect( add_query_arg( 'stay_dates_error', 'invalid', $redirect_base ) );
		exit;
	}
	if ( '' !== $date_from && '' !== $date_to && $date_to < $date_from ) {
		wp_safe_redirect( add_query_arg( 'stay_dates_error', 'order', $redirect_base ) );
		exit;
	}

	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_CRM_TABLE;

	// Read current values so we can (a) skip a no-op write, and (b) write a
	// "before → after" entry in the activity log.
	$existing = $wpdb->get_row(
		$wpdb->prepare( 'SELECT date_from, date_to FROM %i WHERE id = %d', $table, $enquiry_id )
	);
	if ( ! $existing ) {
		wp_die( esc_html__( 'Enquiry not found.', 'restwell-retreats' ) );
	}
	$old_from = (string) $existing->date_from;
	$old_to   = (string) $existing->date_to;

	if ( $old_from === $date_from && $old_to === $date_to ) {
		// Nothing changed — don't pollute the activity log with empty diffs.
		wp_safe_redirect( add_query_arg( 'stay_dates_unchanged', '1', $redirect_base ) );
		exit;
	}

	$wpdb->update(
		$table,
		array(
			// Empty becomes NULL in the column (it's `date DEFAULT NULL`); $wpdb
			// passes NULL through regardless of the format string for that slot.
			'date_from'       => '' === $date_from ? null : $date_from,
			'date_to'         => '' === $date_to ? null : $date_to,
			'preferred_dates' => restwell_format_enquiry_date_range( $date_from, $date_to ),
		),
		array( 'id' => $enquiry_id ),
		array( '%s', '%s', '%s' ),
		array( '%d' )
	);

	$none_label = __( '(none)', 'restwell-retreats' );
	$note       = sprintf(
		/* translators: 1: previous stay-date range or "(none)", 2: new stay-date range or "(none)" */
		__( 'Stay dates updated: %1$s → %2$s', 'restwell-retreats' ),
		restwell_first_nonempty_string( restwell_format_enquiry_date_range( $old_from, $old_to ), $none_label ),
		restwell_first_nonempty_string( restwell_format_enquiry_date_range( $date_from, $date_to ), $none_label )
	);
	restwell_service_crm_gateway()->add_enquiry_note( $enquiry_id, $note );

	wp_safe_redirect( add_query_arg( 'stay_dates_updated', '1', $redirect_base ) );
	exit;
}
add_action( 'admin_post_restwell_crm_update_stay_dates', 'restwell_crm_handle_update_stay_dates' );

/**
 * Keep a linked guest-guide row in step with enquiry contact edits.
 *
 * @param int    $enquiry_id Enquiry ID.
 * @param string $old_email  Email stored before the edit.
 * @param string $name       New name.
 * @param string $email      New email.
 * @return string '' if none or updated, 'conflict' if the new email belongs to another guest.
 */
function restwell_crm_sync_guest_guide_contact( int $enquiry_id, string $old_email, string $name, string $email ): string {
	if ( ! defined( 'RESTWELL_GUESTS_TABLE' ) ) {
		return '';
	}

	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_GUESTS_TABLE;

	$guest = $wpdb->get_row(
		$wpdb->prepare(
			'SELECT id, email FROM %i WHERE enquiry_id = %d ORDER BY id DESC LIMIT 1',
			$table,
			$enquiry_id
		)
	);
	if ( ! $guest && '' !== $old_email ) {
		$guest = $wpdb->get_row(
			$wpdb->prepare(
				'SELECT id, email FROM %i WHERE LOWER(email) = LOWER(%s) ORDER BY id DESC LIMIT 1',
				$table,
				$old_email
			)
		);
	}
	if ( ! $guest ) {
		return '';
	}

	$taken = (int) $wpdb->get_var(
		$wpdb->prepare(
			'SELECT id FROM %i WHERE LOWER(email) = LOWER(%s) AND id <> %d LIMIT 1',
			$table,
			$email,
			(int) $guest->id
		)
	);
	if ( $taken > 0 ) {
		return 'conflict';
	}

	$wpdb->update(
		$table,
		array(
			'name'  => $name,
			'email' => $email,
		),
		array( 'id' => (int) $guest->id ),
		array( '%s', '%s' ),
		array( '%d' )
	);

	return '';
}

/**
 * Save name, email, and phone from the enquiry detail screen.
 *
 * Typos (ggmail.co.uk, missing digits) are the usual reason. Each change is
 * written to the activity log. A linked guest-guide row is updated to match
 * unless the new email is already used on another guest.
 */
function restwell_crm_handle_update_contact(): void {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'Insufficient permissions.', 'restwell-retreats' ) );
	}
	check_admin_referer( 'restwell_crm_update_contact' );

	$enquiry_id = absint( $_POST['rw_enquiry_id'] ?? 0 );
	$name       = sanitize_text_field( wp_unslash( $_POST['rw_contact_name'] ?? '' ) );
	$email      = sanitize_email( wp_unslash( $_POST['rw_contact_email'] ?? '' ) );
	$phone_check = function_exists( 'restwell_validate_submission_phone' )
		? restwell_validate_submission_phone( isset( $_POST['rw_contact_phone'] ) ? (string) wp_unslash( $_POST['rw_contact_phone'] ) : '' )
		: array(
			'phone' => sanitize_text_field( wp_unslash( $_POST['rw_contact_phone'] ?? '' ) ),
			'error' => '',
		);

	if ( ! $enquiry_id ) {
		wp_die( esc_html__( 'Missing enquiry ID.', 'restwell-retreats' ) );
	}

	$redirect_base = add_query_arg(
		array(
			'page' => 'restwell-enquiries',
			'view' => $enquiry_id,
		),
		admin_url( 'admin.php' )
	);

	if ( '' === $name ) {
		wp_safe_redirect( add_query_arg( 'contact_error', 'name', $redirect_base ) );
		exit;
	}
	if ( ! is_email( $email ) ) {
		wp_safe_redirect( add_query_arg( 'contact_error', 'email', $redirect_base ) );
		exit;
	}
	if ( '' !== ( $phone_check['error'] ?? '' ) ) {
		wp_safe_redirect( add_query_arg( 'contact_error', 'phone', $redirect_base ) );
		exit;
	}

	$phone = (string) ( $phone_check['phone'] ?? '' );
	if ( strlen( $name ) > 200 ) {
		$name = substr( $name, 0, 200 );
	}
	if ( strlen( $phone ) > 100 ) {
		$phone = substr( $phone, 0, 100 );
	}

	global $wpdb;
	$table    = $wpdb->prefix . RESTWELL_CRM_TABLE;
	$existing = $wpdb->get_row(
		$wpdb->prepare( 'SELECT name, email, phone FROM %i WHERE id = %d', $table, $enquiry_id )
	);
	if ( ! $existing ) {
		wp_die( esc_html__( 'Enquiry not found.', 'restwell-retreats' ) );
	}

	$old_name  = (string) $existing->name;
	$old_email = (string) $existing->email;
	$old_phone = (string) $existing->phone;

	if ( $old_name === $name && strtolower( $old_email ) === strtolower( $email ) && $old_phone === $phone ) {
		wp_safe_redirect( add_query_arg( 'contact_unchanged', '1', $redirect_base ) );
		exit;
	}

	$wpdb->update(
		$table,
		array(
			'name'  => $name,
			'email' => $email,
			'phone' => $phone,
		),
		array( 'id' => $enquiry_id ),
		array( '%s', '%s', '%s' ),
		array( '%d' )
	);

	$parts = array();
	if ( $old_name !== $name ) {
		$parts[] = sprintf(
			/* translators: 1: previous name, 2: new name */
			__( 'name %1$s → %2$s', 'restwell-retreats' ),
			$old_name,
			$name
		);
	}
	if ( strtolower( $old_email ) !== strtolower( $email ) ) {
		$parts[] = sprintf(
			/* translators: 1: previous email, 2: new email */
			__( 'email %1$s → %2$s', 'restwell-retreats' ),
			$old_email,
			$email
		);
	}
	if ( $old_phone !== $phone ) {
		$parts[] = sprintf(
			/* translators: 1: previous phone, 2: new phone */
			__( 'phone %1$s → %2$s', 'restwell-retreats' ),
			$old_phone,
			$phone
		);
	}
	if ( $parts ) {
		restwell_service_crm_gateway()->add_enquiry_note(
			$enquiry_id,
			sprintf(
				/* translators: %s: comma-separated field diffs */
				__( 'Contact details updated: %s', 'restwell-retreats' ),
				implode( '; ', $parts )
			)
		);
	}

	$guest_status = restwell_crm_sync_guest_guide_contact( $enquiry_id, $old_email, $name, $email );
	$args         = array( 'contact_updated' => '1' );
	if ( 'conflict' === $guest_status ) {
		$args['contact_guest'] = 'conflict';
	}

	wp_safe_redirect( add_query_arg( $args, $redirect_base ) );
	exit;
}
add_action( 'admin_post_restwell_crm_update_contact', 'restwell_crm_handle_update_contact' );

/**
 * Handle inline lead quick-actions from the enquiries list.
 */
function restwell_crm_handle_lead_action() {
	if ( ! restwell_crm_can_manage() ) {
		wp_send_json_error(
			array(
				'message' => __( 'You do not have permission to manage enquiries.', 'restwell-retreats' ),
			),
			403
		);
	}

	check_ajax_referer( 'restwell_crm_lead_action', 'nonce' );

	$lead_id      = absint( $_POST['lead_id'] ?? 0 );
	$action_type  = sanitize_key( $_POST['action_type'] ?? '' );

	if ( ! $lead_id || ! in_array( $action_type, array( 'set_status', 'add_note' ), true ) ) {
		wp_send_json_error(
			array(
				'message' => __( 'Invalid lead action request.', 'restwell-retreats' ),
			),
			400
		);
	}

	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_CRM_TABLE;
	$row = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM %i WHERE id = %d', $table, $lead_id ) );

	if ( ! $row ) {
		wp_send_json_error(
			array(
				'message' => __( 'Lead not found.', 'restwell-retreats' ),
			),
			404
		);
	}

	if ( 'set_status' === $action_type ) {
		$new_status = sanitize_key( $_POST['new_status'] ?? '' );
		if ( ! isset( restwell_crm_statuses()[ $new_status ] ) ) {
			wp_send_json_error(
				array(
					'message' => __( 'Invalid status.', 'restwell-retreats' ),
				),
				400
			);
		}

		// Delegate to the unified function — it handles timestamps, note, and booking email.
		$ok = restwell_crm_ops_apply_status_change( $lead_id, $new_status, 'ajax' );

		if ( ! $ok ) {
			wp_send_json_error( array( 'message' => __( 'Status update failed.', 'restwell-retreats' ) ), 500 );
		}

		$fresh_row = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM %i WHERE id = %d', $table, $lead_id ) );

		wp_send_json_success(
			array(
				'message'             => __( 'Status updated.', 'restwell-retreats' ),
				'updated_status'      => $new_status,
				'updated_status_html' => restwell_crm_status_badge( $new_status ),
				'sla_html'            => $fresh_row ? restwell_crm_sla_badge( $fresh_row ) : '',
				'timestamp'           => current_time( 'mysql' ),
			)
		);
	}

	$note_text = sanitize_textarea_field( wp_unslash( $_POST['note_text'] ?? '' ) );
	if ( '' === $note_text ) {
		wp_send_json_error(
			array(
				'message' => __( 'Note is empty.', 'restwell-retreats' ),
			),
			400
		);
	}

	restwell_service_crm_gateway()->add_enquiry_note( $lead_id, $note_text );

	wp_send_json_success(
		array(
			'message'   => __( 'Note added.', 'restwell-retreats' ),
			'timestamp' => current_time( 'mysql' ),
		)
	);
}
add_action( 'wp_ajax_restwell_lead_action', 'restwell_crm_handle_lead_action' );

/**
 * One-time: stop autoloading Mailchimp credentials already stored in the DB.
 */
function restwell_crm_disable_mailchimp_option_autoload() {
	if ( get_option( 'restwell_mailchimp_autoload_fixed_v1', '' ) === '1' ) {
		return;
	}

	$keys = array(
		'restwell_mailchimp_api_key',
		'restwell_mailchimp_audience_id',
		'restwell_mailchimp_server_prefix',
	);

	foreach ( $keys as $option_name ) {
		$value = get_option( $option_name, null );
		if ( null === $value || false === $value ) {
			continue;
		}
		update_option( $option_name, $value, false );
	}

	update_option( 'restwell_mailchimp_autoload_fixed_v1', '1', false );
}
add_action( 'admin_init', 'restwell_crm_disable_mailchimp_option_autoload', 5 );
