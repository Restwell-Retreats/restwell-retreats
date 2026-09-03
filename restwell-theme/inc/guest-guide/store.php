<?php
/**
 * Guest Guide guest list, cron dispatch, and admin-post handlers.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// =============================================================================
// Session
// =============================================================================

/**
 * Start a PHP session only when the Guest Arrival Guide template is active.
 *
 * Using `template_redirect` (fires after query resolution, before template
 * output) allows us to check the page template slug before starting the
 * session, avoiding unnecessary sessions on every page of the site.
 * Priority 1 keeps it ahead of any other template_redirect callbacks.
 */
function restwell_guest_guide_start_session() {
	if ( is_admin() || PHP_SESSION_NONE !== session_status() ) {
		return;
	}
	$page = get_queried_object();
	if (
		$page instanceof WP_Post &&
		'page-guest-guide.php' === get_page_template_slug( $page->ID )
	) {
		$path   = ( defined( 'COOKIEPATH' ) && COOKIEPATH ) ? COOKIEPATH : '/';
		$domain = ( defined( 'COOKIE_DOMAIN' ) && COOKIE_DOMAIN ) ? COOKIE_DOMAIN : '';
		session_set_cookie_params(
			array(
				'lifetime' => 0,
				'path'     => $path,
				'domain'   => $domain,
				'secure'   => is_ssl(),
				'httponly' => true,
				'samesite' => 'Lax',
			)
		);
		session_start();
	}
}
add_action( 'template_redirect', 'restwell_guest_guide_start_session', 1 );

// =============================================================================
// Guest data helpers
// =============================================================================

/**
 * Return the full guest list from the database, ordered by creation date.
 *
 * Each entry is an associative array:
 *  - id         int     Row ID.
 *  - enquiry_id int     Linked enquiry ID, or 0 if none.
 *  - name       string  Guest display name.
 *  - email      string  Guest email address.
 *  - send_date  string  Scheduled send datetime (MySQL format), or empty.
 *  - sent_at    string  Datetime when invitation was sent (MySQL format), or empty.
 *  - created_at string  Row creation datetime.
 *
 * @return array<int, array<string, mixed>>
 */
function restwell_gg_get_guests(): array {
	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_GUESTS_TABLE;
	$rows = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM %i ORDER BY created_at ASC', $table ), ARRAY_A );
	return is_array( $rows ) ? $rows : array();
}

/**
 * Add a guest to the database.
 *
 * @param string $name        Guest display name.
 * @param string $email       Guest email address.
 * @param string $send_date   Scheduled send in 'Y-m-d H:i' or 'Y-m-d H:i:s' format (site local).
 * @param int    $enquiry_id  Linked enquiry ID (0 if none).
 */
function restwell_gg_add_guest( string $name, string $email, string $send_date, int $enquiry_id = 0 ): void {
	global $wpdb;
	// Normalise datetime-local format to MySQL datetime.
	$send_date_mysql = $send_date ? wp_date( 'Y-m-d H:i:s', strtotime( str_replace( 'T', ' ', $send_date ) ) ) : null;

	$wpdb->insert(
		$wpdb->prefix . RESTWELL_GUESTS_TABLE,
		array(
			'enquiry_id' => $enquiry_id > 0 ? $enquiry_id : null,
			'name'       => $name,
			'email'      => $email,
			'send_date'  => $send_date_mysql,
			'created_at' => current_time( 'mysql' ),
		),
		array( '%d', '%s', '%s', '%s', '%s' )
	);
}

/**
 * Remove a guest by integer ID.
 *
 * @param int $id Guest row ID.
 */
function restwell_gg_delete_guest( int $id ): void {
	global $wpdb;
	$wpdb->delete(
		$wpdb->prefix . RESTWELL_GUESTS_TABLE,
		array( 'id' => $id ),
		array( '%d' )
	);
}

/**
 * Mark a guest's invitation as sent (sets sent_at to now).
 *
 * @param int $id Guest row ID.
 */
function restwell_gg_mark_sent( int $id ): void {
	global $wpdb;
	$wpdb->update(
		$wpdb->prefix . RESTWELL_GUESTS_TABLE,
		array( 'sent_at' => current_time( 'mysql' ) ),
		array( 'id'      => $id ),
		array( '%s' ),
		array( '%d' )
	);
}

/**
 * Return a guest row object by email address, or null if not found.
 *
 * @param string $email Guest email address.
 * @return object|null
 */
function restwell_get_guest_by_email( string $email ): ?object {
	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_GUESTS_TABLE;
	return $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM %i WHERE email = %s ORDER BY id DESC LIMIT 1', $table, $email ) );
}

/**
 * Record that a guest has read the arrival guide and notify the admin.
 *
 * Sets `confirmed_at` on the guest row (first time only) and sends a brief
 * admin notification email.
 *
 * @param string $email Verified guest email address.
 */
function restwell_guest_guide_confirm_read( string $email ): void {
	global $wpdb;
	$table  = $wpdb->prefix . RESTWELL_GUESTS_TABLE;
	$guest  = restwell_get_guest_by_email( $email );

	if ( ! $guest ) {
		return;
	}

	// Only set confirmed_at once (idempotent).
	if ( empty( $guest->confirmed_at ) ) {
		$wpdb->update(
			$table,
			array( 'confirmed_at' => current_time( 'mysql' ) ),
			array( 'id' => (int) $guest->id ),
			array( '%s' ),
			array( '%d' )
		);
	}

	// Notify the admin.
	$notify = (string) get_option( 'restwell_enquiry_notify_email', 'hello@restwellretreats.co.uk' );
	$site   = wp_strip_all_tags( (string) get_bloginfo( 'name' ) );
	wp_mail(
		$notify,
		/* translators: %s: guest display name */
		sprintf( __( '[%s] Guest confirmed reading the arrival guide', 'restwell-retreats' ), $site ),
		sprintf(
			/* translators: 1: guest name, 2: guest email */
			__( '%1$s (%2$s) confirmed they have read the guest arrival guide.', 'restwell-retreats' ),
			esc_html( $guest->name ),
			esc_html( $email )
		),
		array( 'Content-Type: text/plain; charset=UTF-8' )
	);
}

/**
 * Return a guest row as an associative array by integer ID, or null if not found.
 *
 * @param int $id Guest row ID.
 * @return array<string, mixed>|null
 */
function restwell_gg_find_guest( int $id ): ?array {
	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_GUESTS_TABLE;
	$row = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM %i WHERE id = %d', $table, $id ), ARRAY_A );
	return is_array( $row ) ? $row : null;
}

// =============================================================================
// Invitation email
// =============================================================================

/**
 * Return the published URL of the page using the Guest Arrival Guide template.
 * Falls back to /guest-guide/ if no such page is found.
 *
 * @return string
 */
function restwell_gg_get_guide_url() {
	$pages = get_pages(
		array(
			'meta_key'    => '_wp_page_template',
			'meta_value'  => 'page-guest-guide.php',
			'number'      => 1,
			'post_status' => 'publish',
		)
	);
	return ! empty( $pages ) ? get_permalink( $pages[0]->ID ) : home_url( '/guest-guide/' );
}

/**
 * Send the "your arrival guide is ready" invitation email to a single guest.
 *
 * CC addresses are taken from the `restwell_guide_cc_emails` option (one per line).
 *
 * @param string $email Guest email address.
 * @param string $name  Guest display name (optional).
 * @return bool Whether wp_mail reported success.
 */
function restwell_gg_send_invitation( $email, $name = '' ) {
	$guide_url = restwell_gg_get_guide_url();

	// Build CC list from option.
	$raw_cc  = (string) get_option( 'restwell_guide_cc_emails', 'hello@restwellretreats.co.uk' );
	$cc_list = array_filter( array_map( 'trim', explode( "\n", $raw_cc ) ) );

	$mail = function_exists( 'restwell_theme_email_guest_guide_invite' )
		? restwell_theme_email_guest_guide_invite( $email, $name, $guide_url, $cc_list )
		: restwell_email_guest_guide_invite( $email, $name, $guide_url, $cc_list );

	return wp_mail( $email, $mail['subject'], $mail['body'], $mail['headers'] );
}

/**
 * Build the invitation email payload for admin preview (does not send).
 *
 * @param string $email Guest email.
 * @param string $name  Guest name.
 * @return array{ subject: string, body: string, headers: string[] }|null
 */
function restwell_gg_build_invitation_preview( string $email, string $name = '' ): ?array {
	if ( ! function_exists( 'restwell_theme_email_guest_guide_invite' ) && ! function_exists( 'restwell_email_guest_guide_invite' ) ) {
		return null;
	}

	$guide_url = restwell_gg_get_guide_url();
	$raw_cc    = (string) get_option( 'restwell_guide_cc_emails', 'hello@restwellretreats.co.uk' );
	$cc_list   = array_filter( array_map( 'trim', explode( "\n", $raw_cc ) ) );

	if ( function_exists( 'restwell_theme_email_guest_guide_invite' ) ) {
		return restwell_theme_email_guest_guide_invite( $email, $name, $guide_url, $cc_list );
	}

	return restwell_email_guest_guide_invite( $email, $name, $guide_url, $cc_list );
}

/**
 * Resolve which guest (or sample) to show in the invitation email preview.
 *
 * @param array<int, array<string, mixed>> $guests Guest list.
 * @return array{ email: string, name: string, label: string, is_sample: bool }
 */
function restwell_gg_preview_guest_context( array $guests ): array {
	$preview_id = isset( $_GET['preview_guest'] ) ? sanitize_text_field( wp_unslash( $_GET['preview_guest'] ) ) : '';

	if ( $preview_id !== '' ) {
		foreach ( $guests as $guest ) {
			if ( isset( $guest['id'] ) && (string) $guest['id'] === $preview_id ) {
				return array(
					'email'     => (string) $guest['email'],
					'name'      => (string) ( $guest['name'] ?? '' ),
					'label'     => $guest['name'] ? (string) $guest['name'] : (string) $guest['email'],
					'is_sample' => false,
				);
			}
		}
	}

	if ( ! empty( $guests[0]['email'] ) ) {
		return array(
			'email'     => (string) $guests[0]['email'],
			'name'      => (string) ( $guests[0]['name'] ?? '' ),
			'label'     => ! empty( $guests[0]['name'] ) ? (string) $guests[0]['name'] : (string) $guests[0]['email'],
			'is_sample' => false,
		);
	}

	return array(
		'email'     => 'jane@example.com',
		'name'      => 'Jane Smith',
		'label'     => __( 'Sample guest', 'restwell-retreats' ),
		'is_sample' => true,
	);
}

// =============================================================================
// WP-Cron: scheduled invitation dispatch
// =============================================================================

/**
 * Register the hourly cron event on `init` if it is not already scheduled.
 */
function restwell_gg_schedule_cron() {
	if ( ! wp_next_scheduled( 'restwell_gg_dispatch_scheduled' ) ) {
		wp_schedule_event( time(), 'hourly', 'restwell_gg_dispatch_scheduled' );
	}
}
add_action( 'init', 'restwell_gg_schedule_cron' );

/**
 * Cron callback: send invitation emails for any guest whose scheduled send time
 * has arrived and who has not yet been sent an invitation.
 */
function restwell_gg_process_scheduled_dispatch() {
	global $wpdb;
	$table     = $wpdb->prefix . RESTWELL_GUESTS_TABLE;
	// Use site local time so the comparison respects the configured timezone.
	$now_local = current_time( 'mysql' );

	$pending = $wpdb->get_results(
		$wpdb->prepare(
			'SELECT * FROM %i WHERE send_date <= %s AND sent_at IS NULL',
			$table,
			$now_local
		),
		ARRAY_A
	);

	foreach ( $pending as $guest ) {
		restwell_gg_send_invitation( $guest['email'], $guest['name'] );
		restwell_gg_mark_sent( (int) $guest['id'] );
	}
}
add_action( 'restwell_gg_dispatch_scheduled', 'restwell_gg_process_scheduled_dispatch' );

// =============================================================================
// Admin: form action handlers
// =============================================================================

/**
 * Handle "Add guest" form submission.
 */
function restwell_gg_handle_add_guest() {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'Insufficient permissions.', 'restwell-retreats' ) );
	}
	check_admin_referer( 'restwell_gg_add_guest' );

	$name        = isset( $_POST['gg_name'] ) ? sanitize_text_field( wp_unslash( $_POST['gg_name'] ) ) : '';
	$email       = isset( $_POST['gg_email'] ) ? sanitize_email( wp_unslash( $_POST['gg_email'] ) ) : '';
	$send_date   = isset( $_POST['gg_send_date'] ) ? sanitize_text_field( wp_unslash( $_POST['gg_send_date'] ) ) : '';
	$enquiry_id  = isset( $_POST['gg_enquiry_id'] ) ? absint( $_POST['gg_enquiry_id'] ) : 0;

	if ( is_email( $email ) && $send_date ) {
		restwell_gg_add_guest( $name, $email, $send_date, $enquiry_id );
		$status = 'added';
	} else {
		$status = 'invalid';
	}

	wp_safe_redirect(
		add_query_arg(
			array(
				'page' => 'restwell-guest-guide',
				'gg_status' => $status,
			),
			admin_url( 'admin.php' )
		)
	);
	exit;
}
add_action( 'admin_post_restwell_gg_add_guest', 'restwell_gg_handle_add_guest' );

/**
 * Handle "Delete guest" form submission.
 */
function restwell_gg_handle_delete_guest() {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'Insufficient permissions.', 'restwell-retreats' ) );
	}
	check_admin_referer( 'restwell_gg_delete_guest' );

	$id = isset( $_POST['gg_guest_id'] ) ? absint( $_POST['gg_guest_id'] ) : 0;
	if ( $id ) {
		restwell_gg_delete_guest( $id );
	}

	wp_safe_redirect(
		add_query_arg(
			array(
				'page' => 'restwell-guest-guide',
				'gg_status' => 'deleted',
			),
			admin_url( 'admin.php' )
		)
	);
	exit;
}
add_action( 'admin_post_restwell_gg_delete_guest', 'restwell_gg_handle_delete_guest' );

/**
 * Handle "Send now" / "Resend" form submission.
 */
function restwell_gg_handle_send_now() {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'Insufficient permissions.', 'restwell-retreats' ) );
	}
	check_admin_referer( 'restwell_gg_send_now' );

	$id    = isset( $_POST['gg_guest_id'] ) ? absint( $_POST['gg_guest_id'] ) : 0;
	$guest = $id ? restwell_gg_find_guest( $id ) : null;

	if ( $guest ) {
		restwell_gg_send_invitation( $guest['email'], $guest['name'] );
		restwell_gg_mark_sent( $id );
		$status = 'sent';
	} else {
		$status = 'not_found';
	}

	wp_safe_redirect(
		add_query_arg(
			array(
				'page' => 'restwell-guest-guide',
				'gg_status' => $status,
			),
			admin_url( 'admin.php' )
		)
	);
	exit;
}
add_action( 'admin_post_restwell_gg_send_now', 'restwell_gg_handle_send_now' );

/**
 * Handle "Save CC emails" form submission.
 */
function restwell_gg_handle_save_cc() {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'Insufficient permissions.', 'restwell-retreats' ) );
	}
	check_admin_referer( 'restwell_gg_save_cc' );

	$raw = isset( $_POST['restwell_guide_cc_emails'] )
		? sanitize_textarea_field( wp_unslash( $_POST['restwell_guide_cc_emails'] ) )
		: '';

	update_option( 'restwell_guide_cc_emails', $raw );

	wp_safe_redirect(
		add_query_arg(
			array(
				'page' => 'restwell-guest-guide',
				'gg_status' => 'cc_saved',
			),
			admin_url( 'admin.php' )
		)
	);
	exit;
}
add_action( 'admin_post_restwell_gg_save_cc', 'restwell_gg_handle_save_cc' );

// =============================================================================
// Admin: Settings → Guest Guide menu + page
// =============================================================================
