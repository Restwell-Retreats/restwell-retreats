<?php
/**
 * Restwell CRM: enquiry leads store and admin centre.
 *
 * Registers custom DB tables for enquiry storage, notes, and guests.
 * Provides a top-level "Restwell" admin menu with Dashboard, Enquiries
 * list/detail view, and exposes helpers used by the enquiry form handler.
 *
 * @package Restwell_CRM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'RESTWELL_CRM_DB_VERSION', '3.5' );
define( 'RESTWELL_CRM_TABLE',    'rw_enquiries' );
define( 'RESTWELL_NOTES_TABLE',  'rw_enquiry_notes' );
define( 'RESTWELL_GUESTS_TABLE', 'rw_guests' );
define( 'RESTWELL_FAQ_TABLE',    'rw_faq_submissions' );
define( 'RESTWELL_CRM_CAP',      'restwell_manage_enquiries' );

/**
 * Return the CRM capability key.
 *
 * @return string
 */
function restwell_crm_capability(): string {
	return RESTWELL_CRM_CAP;
}

/**
 * Check current-user CRM access.
 *
 * @return bool
 */
function restwell_crm_can_manage(): bool {
	return current_user_can( restwell_crm_capability() );
}

/**
 * Roles granted CRM access.
 *
 * @return array<int, string>
 */
function restwell_crm_get_cap_roles(): array {
	$roles = get_option( 'restwell_crm_cap_roles', array( 'administrator', 'editor' ) );
	if ( ! is_array( $roles ) ) {
		return array( 'administrator', 'editor' );
	}
	return array_values( array_filter( array_map( 'sanitize_key', $roles ) ) );
}

/**
 * Re-apply CRM capability mapping on init.
 */
function restwell_crm_apply_role_caps(): void {
	$wp_roles = wp_roles();
	if ( ! $wp_roles ) {
		return;
	}

	$allowed_roles = array_flip( restwell_crm_get_cap_roles() );
	foreach ( $wp_roles->roles as $role_slug => $_role_data ) {
		$role = get_role( $role_slug );
		if ( ! $role ) {
			continue;
		}
		if ( isset( $allowed_roles[ $role_slug ] ) ) {
			$role->add_cap( restwell_crm_capability() );
		} else {
			$role->remove_cap( restwell_crm_capability() );
		}
	}
}
add_action( 'init', 'restwell_crm_apply_role_caps', 20 );

// ─────────────────────────────────────────────────────────────────────────────
// 1. DATABASE SETUP
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Create or upgrade all CRM tables when the DB version changes.
 * Also runs a one-time migration of Guest Guide data from wp_options → rw_guests.
 */
function restwell_crm_maybe_create_table() {
	if ( get_option( 'restwell_crm_db_version' ) === RESTWELL_CRM_DB_VERSION ) {
		return;
	}

	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';

	// ── rw_enquiries ─────────────────────────────────────────────────────────
	$enq_table = $wpdb->prefix . RESTWELL_CRM_TABLE;
	dbDelta( "CREATE TABLE {$enq_table} (
		id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
		submitted_at datetime NOT NULL,
		name varchar(200) NOT NULL DEFAULT '',
		email varchar(200) NOT NULL DEFAULT '',
		phone varchar(100) NOT NULL DEFAULT '',
		preferred_dates varchar(200) NOT NULL DEFAULT '',
		date_from date DEFAULT NULL,
		date_to date DEFAULT NULL,
		num_guests varchar(100) NOT NULL DEFAULT '',
		care_requirements text NOT NULL,
		accessibility text NOT NULL,
		funding_type varchar(100) NOT NULL DEFAULT '',
		contact_preference varchar(100) NOT NULL DEFAULT '',
		preferred_time varchar(100) NOT NULL DEFAULT '',
		message text NOT NULL,
		is_urgent tinyint(1) NOT NULL DEFAULT 0,
		marketing_optin tinyint(1) NOT NULL DEFAULT 0,
		marketing_optin_at datetime DEFAULT NULL,
		status varchar(50) NOT NULL DEFAULT 'new',
		assigned_to bigint(20) UNSIGNED DEFAULT NULL,
		staff_notes text NOT NULL,
		follow_up_at datetime DEFAULT NULL,
		last_reminder_at datetime DEFAULT NULL,
		contacted_at datetime DEFAULT NULL,
		qualified_at datetime DEFAULT NULL,
		booked_at datetime DEFAULT NULL,
		closed_at datetime DEFAULT NULL,
		PRIMARY KEY  (id),
		KEY status_submitted (status, submitted_at),
		KEY email_submitted (email, submitted_at),
		KEY follow_up_status (follow_up_at, status),
		KEY urgent_status (is_urgent, status)
	) {$charset_collate};" );

	// ── rw_enquiry_notes ─────────────────────────────────────────────────────
	$notes_table = $wpdb->prefix . RESTWELL_NOTES_TABLE;
	dbDelta( "CREATE TABLE {$notes_table} (
		id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
		enquiry_id bigint(20) UNSIGNED NOT NULL,
		note text NOT NULL,
		created_at datetime NOT NULL,
		created_by bigint(20) UNSIGNED NOT NULL DEFAULT 0,
		PRIMARY KEY  (id),
		KEY enquiry_id (enquiry_id)
	) {$charset_collate};" );

	// ── rw_guests ────────────────────────────────────────────────────────────
	$guests_table = $wpdb->prefix . RESTWELL_GUESTS_TABLE;
	dbDelta( "CREATE TABLE {$guests_table} (
		id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
		enquiry_id bigint(20) UNSIGNED DEFAULT NULL,
		name varchar(200) NOT NULL DEFAULT '',
		email varchar(200) NOT NULL DEFAULT '',
		send_date datetime DEFAULT NULL,
		sent_at datetime DEFAULT NULL,
		confirmed_at datetime DEFAULT NULL,
		created_at datetime NOT NULL,
		PRIMARY KEY  (id),
		KEY email (email)
	) {$charset_collate};" );

	// ── rw_faq_submissions (FAQ page questions; survives email failures) ─────
	$faq_table = $wpdb->prefix . RESTWELL_FAQ_TABLE;
	dbDelta( "CREATE TABLE {$faq_table} (
		id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
		submitted_at datetime NOT NULL,
		name varchar(200) NOT NULL DEFAULT '',
		email varchar(200) NOT NULL DEFAULT '',
		question text NOT NULL,
		notify_sent tinyint(1) NOT NULL DEFAULT 0,
		marketing_optin tinyint(1) NOT NULL DEFAULT 0,
		marketing_optin_at datetime DEFAULT NULL,
		marketing_sync_failed tinyint(1) NOT NULL DEFAULT 0,
		source_url varchar(500) NOT NULL DEFAULT '',
		PRIMARY KEY  (id),
		KEY submitted_at (submitted_at),
		KEY email (email)
	) {$charset_collate};" );

	// Backfill legacy enquiry consent stored in staff_notes.
	// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	$wpdb->query(
		"UPDATE {$enq_table}
		SET marketing_optin = 1,
			marketing_optin_at = COALESCE(marketing_optin_at, submitted_at)
		WHERE marketing_optin = 0
		AND staff_notes LIKE '%Marketing updates consent: Yes%'"
	);

	// ── One-time migration: restwell_guests option → rw_guests ───────────────
	$legacy_guests = get_option( 'restwell_guests', array() );
	if ( is_array( $legacy_guests ) && ! empty( $legacy_guests ) ) {
		foreach ( $legacy_guests as $g ) {
			$email = isset( $g['email'] ) ? sanitize_email( (string) $g['email'] ) : '';
			if ( ! $email ) {
				continue;
			}
			$send_date = null;
			if ( ! empty( $g['send_date'] ) ) {
				$ts = strtotime( (string) $g['send_date'] );
				if ( $ts ) {
					$send_date = gmdate( 'Y-m-d H:i:s', $ts );
				}
			}
			$sent_at = null;
			if ( ! empty( $g['sent'] ) ) {
				$sent_at = gmdate( 'Y-m-d H:i:s', (int) $g['sent'] );
			}
			$wpdb->insert(
				$guests_table,
				array(
					'name'       => isset( $g['name'] ) ? sanitize_text_field( (string) $g['name'] ) : '',
					'email'      => $email,
					'send_date'  => $send_date,
					'sent_at'    => $sent_at,
					'created_at' => current_time( 'mysql' ),
				),
				array( '%s', '%s', '%s', '%s', '%s' )
			);
		}
		delete_option( 'restwell_guests' );
	}

	update_option( 'restwell_crm_db_version', RESTWELL_CRM_DB_VERSION );
}
add_action( 'init', 'restwell_crm_maybe_create_table', 5 );

// ─────────────────────────────────────────────────────────────────────────────
// 2. SAVE ENQUIRY (called from enquire-handler.php)
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Persist an enquiry submission to the database.
 *
 * Runs a lightweight duplicate check first: if the same email submitted
 * within the last 30 minutes we skip the insert and return the existing
 * row ID, preventing accidental double-submissions.
 *
 * @param array $data Sanitised form values keyed by short name.
 * @return array{id: int|false, is_duplicate: bool}
 *   'id'           — Inserted or existing row ID (false on DB failure).
 *   'is_duplicate' — true when the insert was skipped due to deduplication.
 */
function restwell_crm_save_enquiry( array $data ): array {
	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_CRM_TABLE;
	$email = $data['email'] ?? '';

	// Duplicate guard: same email, submitted in the last 30 minutes.
	if ( $email ) {
		$cutoff  = gmdate( 'Y-m-d H:i:s', time() - 30 * MINUTE_IN_SECONDS );
		$dup_id  = (int) $wpdb->get_var(
			$wpdb->prepare(
				// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
				"SELECT id FROM {$table} WHERE email = %s AND submitted_at >= %s ORDER BY id DESC LIMIT 1",
				$email,
				$cutoff
			)
		);
		if ( $dup_id ) {
			return array( 'id' => $dup_id, 'is_duplicate' => true );
		}
	}

	// Normalise optional date columns; store NULL when blank.
	$date_from = ! empty( $data['date_from'] ) ? $data['date_from'] : null;
	$date_to   = ! empty( $data['date_to'] )   ? $data['date_to']   : null;
	$marketing_optin    = ! empty( $data['marketing_optin'] ) ? 1 : 0;
	$marketing_optin_at = $marketing_optin ? current_time( 'mysql' ) : null;
	$staff_notes = '';
	if ( array_key_exists( 'marketing_optin', $data ) ) {
		$staff_notes = ! empty( $data['marketing_optin'] )
			? __( 'Marketing updates consent: Yes (opted in).', 'restwell-retreats' )
			: __( 'Marketing updates consent: No (not opted in).', 'restwell-retreats' );
	}

	$result = $wpdb->insert(
		$table,
		array(
			'submitted_at'       => current_time( 'mysql' ),
			'name'               => $data['name'] ?? '',
			'email'              => $email,
			'phone'              => $data['phone'] ?? '',
			'preferred_dates'    => $data['dates'] ?? '',
			'date_from'          => $date_from,
			'date_to'            => $date_to,
			'num_guests'         => $data['guests'] ?? '',
			'care_requirements'  => $data['care'] ?? '',
			'accessibility'      => $data['access'] ?? '',
			'funding_type'       => $data['funding'] ?? '',
			'contact_preference' => $data['contact_pref'] ?? '',
			'preferred_time'     => $data['pref_time'] ?? '',
			'message'            => $data['message'] ?? '',
			'is_urgent'          => ! empty( $data['urgent'] ) ? 1 : 0,
			'marketing_optin'    => $marketing_optin,
			'marketing_optin_at' => $marketing_optin_at,
			'status'             => 'new',
			'staff_notes'        => $staff_notes,
		),
		array( '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%d', '%s', '%s', '%s' )
	);

	if ( $result ) {
		return array( 'id' => (int) $wpdb->insert_id, 'is_duplicate' => false );
	}
	return array( 'id' => false, 'is_duplicate' => false );
}

/**
 * Persist an FAQ page question (always store before attempting email).
 *
 * @param array{name:string,email:string,question:string,source_url?:string,marketing_optin?:bool|int|string} $data Sanitised fields.
 * @return int|false Inserted row ID, or false on failure.
 */
function restwell_faq_save_submission( array $data ) {
	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_FAQ_TABLE;
	$marketing_optin    = ! empty( $data['marketing_optin'] ) ? 1 : 0;
	$marketing_optin_at = $marketing_optin ? current_time( 'mysql' ) : null;
	$result = $wpdb->insert(
		$table,
		array(
			'submitted_at' => current_time( 'mysql' ),
			'name'         => $data['name'] ?? '',
			'email'        => $data['email'] ?? '',
			'question'     => $data['question'] ?? '',
			'notify_sent'  => 0,
			'marketing_optin' => $marketing_optin,
			'marketing_optin_at' => $marketing_optin_at,
			'source_url'   => $data['source_url'] ?? '',
		),
		array( '%s', '%s', '%s', '%s', '%d', '%d', '%s', '%s' )
	);
	return $result ? (int) $wpdb->insert_id : false;
}

/**
 * Mark FAQ staff notification as sent.
 *
 * @param int $id Submission row ID.
 */
function restwell_faq_mark_notify_sent( int $id ): void {
	global $wpdb;
	$wpdb->update(
		$wpdb->prefix . RESTWELL_FAQ_TABLE,
		array( 'notify_sent' => 1 ),
		array( 'id' => $id ),
		array( '%d' ),
		array( '%d' )
	);
}

// ─────────────────────────────────────────────────────────────────────────────
// 3. ADMIN MENU  (priority 5 so Guest Guide submenu can safely attach later)
// ─────────────────────────────────────────────────────────────────────────────

add_action( 'admin_menu', 'restwell_crm_register_menu', 5 );

function restwell_crm_register_menu() {
	// Top-level Restwell menu points to Dashboard.
	add_menu_page(
		__( 'Restwell', 'restwell-retreats' ),
		__( 'Restwell', 'restwell-retreats' ),
		restwell_crm_capability(),
		'restwell-crm',
		'restwell_crm_dashboard_page',
		'dashicons-groups',
		25
	);

	// Dashboard submenu (same slug replaces the auto-generated parent label).
	add_submenu_page(
		'restwell-crm',
		__( 'Dashboard', 'restwell-retreats' ),
		__( 'Dashboard', 'restwell-retreats' ),
		restwell_crm_capability(),
		'restwell-crm',
		'restwell_crm_dashboard_page'
	);

	// Enquiries submenu (new slug).
	add_submenu_page(
		'restwell-crm',
		__( 'Enquiries', 'restwell-retreats' ),
		__( 'Enquiries', 'restwell-retreats' ),
		restwell_crm_capability(),
		'restwell-enquiries',
		'restwell_crm_enquiries_page'
	);

	add_submenu_page(
		'restwell-crm',
		__( 'Mailing list', 'restwell-retreats' ),
		__( 'Mailing list', 'restwell-retreats' ),
		restwell_crm_capability(),
		'restwell-mailing-list',
		'restwell_crm_mailing_list_page'
	);

	// Guest Guide submenu: callback defined in inc/guest-guide.php.
	add_submenu_page(
		'restwell-crm',
		__( 'Guest Guide', 'restwell-retreats' ),
		__( 'Guest Guide', 'restwell-retreats' ),
		restwell_crm_capability(),
		'restwell-guest-guide',
		'restwell_guest_guide_settings_page'
	);
}

// ─────────────────────────────────────────────────────────────────────────────
// 4. STATUS HELPERS
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Return the defined lead statuses with label and badge colour.
 *
 * @return array<string, array{label: string, color: string}>
 */
function restwell_crm_statuses(): array {
	return array(
		'new'       => array( 'label' => 'New',        'color' => '#2271b1' ),
		'contacted' => array( 'label' => 'Contacted',  'color' => '#996800' ),
		'qualified' => array( 'label' => 'Qualified',  'color' => '#6f41c1' ),
		'booked'    => array( 'label' => 'Booked',     'color' => '#007a3d' ),
		'closed'    => array( 'label' => 'Closed',     'color' => '#787c82' ),
	);
}

/**
 * Render a coloured status badge.
 *
 * @param string $status Status slug.
 * @return string HTML span.
 */
function restwell_crm_status_badge( string $status ): string {
	$statuses = restwell_crm_statuses();
	$label    = $statuses[ $status ]['label'] ?? ucfirst( $status );
	$color    = $statuses[ $status ]['color'] ?? '#787c82';

	return sprintf(
		'<span class="rw-status-pill" style="background:%1$s;">%2$s</span>',
		esc_attr( $color ),
		esc_html( $label )
	);
}

/**
 * Return SLA badge HTML for stale "new" leads.
 *
 * @param object $row Enquiry row.
 * @return string
 */
function restwell_crm_sla_badge( object $row ): string {
	if ( 'new' !== (string) $row->status || empty( $row->submitted_at ) ) {
		return '';
	}

	$submitted_ts = strtotime( (string) $row->submitted_at );
	if ( ! $submitted_ts ) {
		return '';
	}

	$age_hours = floor( ( current_time( 'timestamp' ) - $submitted_ts ) / HOUR_IN_SECONDS );
	if ( $age_hours < 2 ) {
		return '';
	}

	$is_critical = $age_hours >= 18;
	$label       = $is_critical ? __( 'New >18h', 'restwell-retreats' ) : __( 'New >2h', 'restwell-retreats' );

	$class = $is_critical ? 'rw-sla-pill rw-sla-pill--critical' : 'rw-sla-pill rw-sla-pill--warn';

	return sprintf(
		'<span class="%1$s">%2$s</span>',
		esc_attr( $class ),
		esc_html( $label )
	);
}

// ─────────────────────────────────────────────────────────────────────────────
// 5. NOTES HELPERS
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Add an entry to the activity log for an enquiry.
 *
 * @param int    $enquiry_id Enquiry row ID.
 * @param string $note       Note text (already sanitised by caller).
 */
function restwell_crm_add_note( int $enquiry_id, string $note ): void {
	global $wpdb;
	$wpdb->insert(
		$wpdb->prefix . RESTWELL_NOTES_TABLE,
		array(
			'enquiry_id' => $enquiry_id,
			'note'       => $note,
			'created_at' => current_time( 'mysql' ),
			'created_by' => get_current_user_id(),
		),
		array( '%d', '%s', '%s', '%d' )
	);
}

/**
 * Return all notes for an enquiry, oldest first.
 *
 * @param int $enquiry_id Enquiry row ID.
 * @return array
 */
function restwell_crm_get_notes( int $enquiry_id ): array {
	global $wpdb;
	$notes_table = $wpdb->prefix . RESTWELL_NOTES_TABLE;
	// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	return (array) $wpdb->get_results(
		$wpdb->prepare( "SELECT * FROM {$notes_table} WHERE enquiry_id = %d ORDER BY created_at ASC", $enquiry_id )
	);
}

// ─────────────────────────────────────────────────────────────────────────────
// 6. ADMIN POST HANDLERS
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Stream all enquiries as a UTF-8 CSV download.
 */
function restwell_crm_handle_export_csv() {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'Insufficient permissions.', 'restwell-retreats' ) );
	}
	check_admin_referer( 'restwell_crm_export_csv' );

	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_CRM_TABLE;
	// Explicit column list — avoids pulling unexpected columns added by future migrations.
	// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	$rows = $wpdb->get_results(
		"SELECT id, submitted_at, name, email, phone,
		        preferred_dates, date_from, date_to, num_guests,
		        care_requirements, accessibility, funding_type,
		        contact_preference, preferred_time, message,
		        is_urgent, marketing_optin, marketing_optin_at,
		        status, staff_notes, follow_up_at,
		        last_reminder_at, contacted_at, qualified_at, booked_at, closed_at
		 FROM {$table} ORDER BY submitted_at DESC",
		ARRAY_A
	);

	// Append to audit log before streaming headers (headers cannot be sent before update_option).
	$export_log_entry = array(
		'user_id'     => get_current_user_id(),
		'exported_at' => gmdate( 'Y-m-d H:i:s' ),
		'row_count'   => count( (array) $rows ),
	);
	$export_log = get_option( 'restwell_crm_export_log', array() );
	if ( ! is_array( $export_log ) ) {
		$export_log = array();
	}
	$export_log[] = $export_log_entry;
	update_option( 'restwell_crm_export_log', array_slice( $export_log, -200 ) ); // keep last 200 entries

	$filename = 'restwell-enquiries-' . gmdate( 'Y-m-d' ) . '.csv';

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
	// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	$row = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$table} WHERE id = %d", $id ) );

	if ( $row && function_exists( 'restwell_email_post_stay' ) ) {
		$email_data = restwell_email_post_stay( $row->email, $row->name );
		wp_mail( $row->email, $email_data['subject'], $email_data['body'], $email_data['headers'] );
		restwell_crm_add_note( $id, __( 'Post-stay email sent.', 'restwell-retreats' ) );
	}

	wp_safe_redirect(
		add_query_arg( array( 'page' => 'restwell-enquiries', 'view' => $id, 'updated' => '1' ), admin_url( 'admin.php' ) )
	);
	exit;
}
add_action( 'admin_post_restwell_crm_send_post_stay', 'restwell_crm_handle_send_post_stay' );

/**
 * Save the notification email setting.
 */
function restwell_crm_handle_save_settings() {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'Insufficient permissions.', 'restwell-retreats' ) );
	}
	check_admin_referer( 'restwell_crm_settings' );

	// Always persist these values — including empty string — so editors can intentionally clear stale data.
	$email = isset( $_POST['restwell_enquiry_notify_email'] )
		? sanitize_email( wp_unslash( $_POST['restwell_enquiry_notify_email'] ) )
		: '';
	update_option( 'restwell_enquiry_notify_email', $email );

	$phone = isset( $_POST['restwell_phone_number'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_phone_number'] ) )
		: '';
	update_option( 'restwell_phone_number', $phone );

	$address = isset( $_POST['restwell_property_address'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_property_address'] ) )
		: '';
	update_option( 'restwell_property_address', $address );

	$postcode = isset( $_POST['restwell_property_postcode'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_property_postcode'] ) )
		: '';
	update_option( 'restwell_property_postcode', $postcode );

	$business_street = isset( $_POST['restwell_business_street'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_business_street'] ) )
		: '';
	update_option( 'restwell_business_street', $business_street );

	$business_locality = isset( $_POST['restwell_business_locality'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_business_locality'] ) )
		: '';
	update_option( 'restwell_business_locality', $business_locality );

	$business_region = isset( $_POST['restwell_business_region'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_business_region'] ) )
		: '';
	update_option( 'restwell_business_region', $business_region );

	$business_postcode = isset( $_POST['restwell_business_postcode'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_business_postcode'] ) )
		: '';
	update_option( 'restwell_business_postcode', $business_postcode );

	$business_geo_lat = isset( $_POST['restwell_business_geo_lat'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_business_geo_lat'] ) )
		: '';
	update_option( 'restwell_business_geo_lat', $business_geo_lat );

	$business_geo_lon = isset( $_POST['restwell_business_geo_lon'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_business_geo_lon'] ) )
		: '';
	update_option( 'restwell_business_geo_lon', $business_geo_lon );

	$footer_heading = isset( $_POST['restwell_footer_cta_heading'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_footer_cta_heading'] ) )
		: '';
	update_option( 'restwell_footer_cta_heading', $footer_heading );

	$footer_btn = isset( $_POST['restwell_footer_cta_btn'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_footer_cta_btn'] ) )
		: '';
	update_option( 'restwell_footer_cta_btn', $footer_btn );

	$footer_intro = isset( $_POST['restwell_footer_cta_intro'] )
		? sanitize_textarea_field( wp_unslash( $_POST['restwell_footer_cta_intro'] ) )
		: '';
	update_option( 'restwell_footer_cta_intro', $footer_intro );

	$footer_primary_label = isset( $_POST['restwell_footer_cta_primary_label'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_footer_cta_primary_label'] ) )
		: '';
	update_option( 'restwell_footer_cta_primary_label', $footer_primary_label );

	$footer_primary_url = isset( $_POST['restwell_footer_cta_primary_url'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_footer_cta_primary_url'] ) )
		: '';
	update_option( 'restwell_footer_cta_primary_url', $footer_primary_url );

	$footer_note = isset( $_POST['restwell_footer_cta_note'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_footer_cta_note'] ) )
		: '';
	update_option( 'restwell_footer_cta_note', $footer_note );

	$gsc = isset( $_POST['restwell_gsc_verification'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_gsc_verification'] ) )
		: '';
	update_option( 'restwell_gsc_verification', $gsc );

	$ga4 = isset( $_POST['restwell_ga4_measurement_id'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_ga4_measurement_id'] ) )
		: '';
	$ga4 = preg_replace( '/\s+/', '', $ga4 );
	update_option( 'restwell_ga4_measurement_id', $ga4 );

	$mailchimp_api_key = isset( $_POST['restwell_mailchimp_api_key'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_mailchimp_api_key'] ) )
		: '';
	$mailchimp_api_key = preg_replace( '/[^A-Za-z0-9\-]/', '', trim( $mailchimp_api_key ) );
	if ( '' !== $mailchimp_api_key ) {
		update_option( 'restwell_mailchimp_api_key', $mailchimp_api_key );
	} elseif ( ! empty( $_POST['restwell_mailchimp_api_key_clear'] ) ) {
		update_option( 'restwell_mailchimp_api_key', '' );
	}

	$mailchimp_audience_id = isset( $_POST['restwell_mailchimp_audience_id'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_mailchimp_audience_id'] ) )
		: '';
	$mailchimp_audience_id = preg_replace( '/[^0-9A-Za-z]/', '', $mailchimp_audience_id );
	update_option( 'restwell_mailchimp_audience_id', $mailchimp_audience_id );

	$mailchimp_server_prefix = isset( $_POST['restwell_mailchimp_server_prefix'] )
		? sanitize_key( wp_unslash( $_POST['restwell_mailchimp_server_prefix'] ) )
		: '';
	update_option( 'restwell_mailchimp_server_prefix', $mailchimp_server_prefix );

	$metricool_hash = isset( $_POST['restwell_metricool_hash'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_metricool_hash'] ) )
		: '';
	$metricool_hash = preg_replace( '/[^0-9A-Za-z]/', '', $metricool_hash );
	$metricool_hash = strtolower( $metricool_hash );
	update_option( 'restwell_metricool_hash', $metricool_hash );

	$analytics_mode = isset( $_POST['restwell_analytics_load_mode'] )
		? sanitize_key( wp_unslash( $_POST['restwell_analytics_load_mode'] ) )
		: 'head';
	if ( ! in_array( $analytics_mode, array( 'head', 'footer_deferred', 'consent_gated' ), true ) ) {
		$analytics_mode = 'head';
	}
	update_option( 'restwell_analytics_load_mode', $analytics_mode );

	$bing = isset( $_POST['restwell_bing_verification'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_bing_verification'] ) )
		: '';
	update_option( 'restwell_bing_verification', preg_replace( '/[^0-9A-Za-z]/', '', $bing ) );

	$access_pdf = isset( $_POST['restwell_access_statement_url'] )
		? esc_url_raw( wp_unslash( $_POST['restwell_access_statement_url'] ) )
		: '';
	update_option( 'restwell_access_statement_url', $access_pdf );

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

	wp_safe_redirect(
		add_query_arg( array( 'page' => 'restwell-crm', 'settings_saved' => '1' ), admin_url( 'admin.php' ) )
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
		restwell_crm_add_note( $enquiry_id, $note );
	}

	wp_safe_redirect(
		add_query_arg(
			array( 'page' => 'restwell-enquiries', 'view' => $enquiry_id, 'note_added' => '1' ),
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
	$date_to    = sanitize_text_field( wp_unslash( $_POST['rw_date_to']   ?? '' ) );

	if ( ! $enquiry_id ) {
		wp_die( esc_html__( 'Missing enquiry ID.', 'restwell-retreats' ) );
	}

	$redirect_base = add_query_arg(
		array( 'page' => 'restwell-enquiries', 'view' => $enquiry_id ),
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
		$wpdb->prepare( "SELECT date_from, date_to FROM {$table} WHERE id = %d", $enquiry_id )
	);
	if ( ! $existing ) {
		wp_die( esc_html__( 'Enquiry not found.', 'restwell-retreats' ) );
	}
	$old_from = $existing->date_from ?: '';
	$old_to   = $existing->date_to   ?: '';

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
			'date_to'         => '' === $date_to   ? null : $date_to,
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
		restwell_format_enquiry_date_range( $old_from, $old_to ) ?: $none_label,
		restwell_format_enquiry_date_range( $date_from, $date_to ) ?: $none_label
	);
	restwell_crm_add_note( $enquiry_id, $note );

	wp_safe_redirect( add_query_arg( 'stay_dates_updated', '1', $redirect_base ) );
	exit;
}
add_action( 'admin_post_restwell_crm_update_stay_dates', 'restwell_crm_handle_update_stay_dates' );

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
	// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	$row = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$table} WHERE id = %d", $lead_id ) );

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
		$ok = restwell_crm_apply_status_change( $lead_id, $new_status, 'ajax' );

		if ( ! $ok ) {
			wp_send_json_error( array( 'message' => __( 'Status update failed.', 'restwell-retreats' ) ), 500 );
		}

		// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		$fresh_row = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$table} WHERE id = %d", $lead_id ) );

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

	restwell_crm_add_note( $lead_id, $note_text );

	wp_send_json_success(
		array(
			'message'   => __( 'Note added.', 'restwell-retreats' ),
			'timestamp' => current_time( 'mysql' ),
		)
	);
}
add_action( 'wp_ajax_restwell_lead_action', 'restwell_crm_handle_lead_action' );

// ─────────────────────────────────────────────────────────────────────────────
// UNIFIED STATUS TRANSITION
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Apply a status change to a single enquiry.
 *
 * This is the canonical implementation of "what does it mean to transition
 * status X to Y?" — timestamps, activity note, and booking email all live here.
 * Every entry point (detail form, bulk, AJAX) must delegate to this function
 * rather than re-implementing the rules.
 *
 * @param int    $id         Enquiry ID.
 * @param string $new_status Target status key (must exist in restwell_crm_statuses()).
 * @param string $context    Caller context: 'detail', 'ajax', or 'bulk'.
 *                           Booking confirmation email is suppressed when context = 'bulk'.
 * @return bool True if the update succeeded, false otherwise.
 */
function restwell_crm_apply_status_change( int $id, string $new_status, string $context = 'detail' ): bool {
	$statuses = restwell_crm_statuses();
	if ( ! isset( $statuses[ $new_status ] ) ) {
		return false;
	}

	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_CRM_TABLE;
	// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	$current = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$table} WHERE id = %d", $id ) );

	if ( ! $current ) {
		return false;
	}

	$update_data    = array( 'status' => $new_status );
	$update_formats = array( '%s' );

	// Set first-touch lifecycle timestamps only when the column is still NULL.
	if ( 'contacted' === $new_status && empty( $current->contacted_at ) ) {
		$update_data['contacted_at'] = current_time( 'mysql' );
		$update_formats[]            = '%s';
	}
	if ( 'qualified' === $new_status && empty( $current->qualified_at ) ) {
		$update_data['qualified_at'] = current_time( 'mysql' );
		$update_formats[]            = '%s';
	}
	if ( 'booked' === $new_status && empty( $current->booked_at ) ) {
		$update_data['booked_at'] = current_time( 'mysql' );
		$update_formats[]         = '%s';
	}
	if ( 'closed' === $new_status && empty( $current->closed_at ) ) {
		$update_data['closed_at'] = current_time( 'mysql' );
		$update_formats[]         = '%s';
	}

	$result = $wpdb->update( $table, $update_data, array( 'id' => $id ), $update_formats, array( '%d' ) );

	if ( false === $result ) {
		return false;
	}

	// Auto-log to activity log when status actually changed.
	if ( $current->status !== $new_status ) {
		$old_label = $statuses[ $current->status ]['label'] ?? ucfirst( $current->status );
		$new_label = $statuses[ $new_status ]['label'] ?? ucfirst( $new_status );
		restwell_crm_add_note(
			$id,
			sprintf(
				/* translators: 1: old status label, 2: new status label, 3: context (detail/ajax/bulk) */
				__( 'Status changed from "%1$s" to "%2$s" (via %3$s).', 'restwell-retreats' ),
				$old_label,
				$new_label,
				$context
			)
		);

		// Send booking confirmation email on first 'booked' transition.
		// Suppressed in bulk context to avoid accidental mass email.
		if (
			'booked' === $new_status
			&& empty( $current->booked_at )
			&& 'bulk' !== $context
			&& function_exists( 'restwell_email_booking_confirmed' )
		) {
			$email_data = restwell_email_booking_confirmed( $current->name, $current->email );
			wp_mail( $current->email, $email_data['subject'], $email_data['body'], $email_data['headers'] );
		}
	}

	return true;
}

/**
 * Render opted-in marketing contacts from site forms.
 */
function restwell_crm_mailing_list_page(): void {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'You do not have permission to view this page.', 'restwell-retreats' ) );
	}

	global $wpdb;
	$enq_table = $wpdb->prefix . RESTWELL_CRM_TABLE;
	$faq_table = $wpdb->prefix . RESTWELL_FAQ_TABLE;

	// phpcs:disable WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	$rows = $wpdb->get_results(
		"
		SELECT
			email,
			MAX(name) AS name,
			MAX(last_opted_in_at) AS last_opted_in_at,
			GROUP_CONCAT(DISTINCT source ORDER BY source SEPARATOR ', ') AS sources
		FROM (
			SELECT
				email,
				name,
				COALESCE(marketing_optin_at, submitted_at) AS last_opted_in_at,
				'Enquiry form' AS source
			FROM {$enq_table}
			WHERE marketing_optin = 1 AND email <> ''
			UNION ALL
			SELECT
				email,
				name,
				COALESCE(marketing_optin_at, submitted_at) AS last_opted_in_at,
				'FAQ question form' AS source
			FROM {$faq_table}
			WHERE marketing_optin = 1 AND email <> ''
		) all_optins
		GROUP BY email
		ORDER BY last_opted_in_at DESC
		",
		ARRAY_A
	);
	// phpcs:enable WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Mailing list', 'restwell-retreats' ); ?></h1>
		<p class="description">
			<?php esc_html_e( 'Contacts who explicitly opted in to marketing emails from enquiry and FAQ forms.', 'restwell-retreats' ); ?>
		</p>
		<?php if ( empty( $rows ) ) : ?>
			<p><?php esc_html_e( 'No opted-in contacts yet.', 'restwell-retreats' ); ?></p>
		<?php else : ?>
			<p><strong><?php echo esc_html( sprintf( __( 'Total subscribers: %d', 'restwell-retreats' ), count( $rows ) ) ); ?></strong></p>
			<table class="widefat striped">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Name', 'restwell-retreats' ); ?></th>
						<th><?php esc_html_e( 'Email', 'restwell-retreats' ); ?></th>
						<th><?php esc_html_e( 'Source', 'restwell-retreats' ); ?></th>
						<th><?php esc_html_e( 'Most recent opt-in', 'restwell-retreats' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $rows as $row ) : ?>
						<tr>
							<td><?php echo esc_html( (string) ( $row['name'] ?? '' ) ); ?></td>
							<td><a href="mailto:<?php echo esc_attr( (string) ( $row['email'] ?? '' ) ); ?>"><?php echo esc_html( (string) ( $row['email'] ?? '' ) ); ?></a></td>
							<td><?php echo esc_html( (string) ( $row['sources'] ?? '' ) ); ?></td>
							<td><?php echo esc_html( (string) ( $row['last_opted_in_at'] ?? '' ) ); ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php endif; ?>
	</div>
	<?php
}

// ─────────────────────────────────────────────────────────────────────────────
// 7. DASHBOARD PAGE
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Render the Restwell CRM dashboard.
 */
function restwell_crm_dashboard_page() {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'You do not have permission to access this page.', 'restwell-retreats' ), '', array( 'response' => 403 ) );
	}

	global $wpdb;
	$enq_table    = $wpdb->prefix . RESTWELL_CRM_TABLE;
	$guests_table = $wpdb->prefix . RESTWELL_GUESTS_TABLE;
	$now_mysql    = current_time( 'mysql' );
	$week_ago     = gmdate( 'Y-m-d H:i:s', strtotime( '-7 days' ) );

	// ── Stats ────────────────────────────────────────────────────────────────
	// phpcs:disable WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	$stat_new_week   = (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$enq_table} WHERE submitted_at >= %s", $week_ago ) );
	$stat_total      = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$enq_table}" );
	$stat_urgent     = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$enq_table} WHERE is_urgent = 1 AND status = 'new'" );
	$stat_follow_ups = (int) $wpdb->get_var(
		$wpdb->prepare( "SELECT COUNT(*) FROM {$enq_table} WHERE follow_up_at IS NOT NULL AND follow_up_at <= %s AND status != 'closed'", $now_mysql )
	);

	// Follow-ups due today or overdue.
	$follow_up_rows = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT id, name, email, status, follow_up_at FROM {$enq_table}
			 WHERE follow_up_at IS NOT NULL AND follow_up_at <= %s AND status != 'closed'
			 ORDER BY follow_up_at ASC LIMIT 20",
			$now_mysql
		)
	);

	// Booked enquiries not yet added to the Guest Guide.
	// NOTE: LOWER() on both sides prevents index use on email columns; revisit with a normalised
	// stored column (e.g. email_lower GENERATED ALWAYS AS (LOWER(email)) STORED + index) if this
	// query appears in the MySQL slow log.
	$booked_without_guide = $wpdb->get_results(
		"SELECT e.id, e.name, e.email, e.preferred_dates, e.booked_at
		 FROM {$enq_table} e
		 LEFT JOIN {$guests_table} g ON LOWER(g.email) = LOWER(e.email)
		 WHERE e.status = 'booked' AND g.id IS NULL
		 ORDER BY e.booked_at ASC"
	);
	// phpcs:enable

	$enquiries_url = admin_url( 'admin.php?page=restwell-enquiries' );
	?>
	<div class="wrap restwell-admin restwell-admin-dashboard">
		<h1 class="rw-page-title"><?php esc_html_e( 'Restwell Dashboard', 'restwell-retreats' ); ?></h1>

		<?php if ( isset( $_GET['settings_saved'] ) ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Settings saved.', 'restwell-retreats' ); ?></p></div>
		<?php endif; ?>

		<!-- Stat tiles -->
		<div class="rw-stat-grid" role="list" aria-label="<?php esc_attr_e( 'Dashboard summary metrics', 'restwell-retreats' ); ?>">
			<?php
			$tiles = array(
				array(
					'label' => __( 'New this week', 'restwell-retreats' ),
					'value' => $stat_new_week,
					'color' => '#2271b1',
					// Links to all enquiries submitted in the last 7 days, matching the count's SQL.
					'url'   => add_query_arg( 'submitted_since', $week_ago, $enquiries_url ),
				),
				array(
					'label' => __( 'Total enquiries', 'restwell-retreats' ),
					'value' => $stat_total,
					'color' => '#3c434a',
					'url'   => $enquiries_url,
				),
				array(
					'label' => __( 'Urgent & uncontacted', 'restwell-retreats' ),
					'value' => $stat_urgent,
					'color' => '#d63638',
					// Both filters must match the SQL: is_urgent = 1 AND status = 'new'.
					'url'   => add_query_arg( array( 'status_filter' => 'new', 'urgent_filter' => '1' ), $enquiries_url ),
				),
				array(
					'label' => __( 'Follow-ups overdue', 'restwell-retreats' ),
					'value' => $stat_follow_ups,
					'color' => '#996800',
					// Filter matches the SQL: follow_up_at <= now AND status != 'closed'.
					'url'   => add_query_arg( 'follow_up_filter', 'overdue', $enquiries_url ),
				),
			);
			foreach ( $tiles as $tile ) :
			?>
			<a href="<?php echo esc_url( $tile['url'] ); ?>" class="rw-stat-tile" role="listitem" style="--rw-tile-accent:<?php echo esc_attr( $tile['color'] ); ?>;">
				<div class="rw-stat-value"><?php echo esc_html( $tile['value'] ); ?></div>
				<div class="rw-stat-label"><?php echo esc_html( $tile['label'] ); ?></div>
			</a>
			<?php endforeach; ?>
		</div>

		<div class="rw-dashboard-grid">

			<!-- Follow-ups due -->
			<div class="postbox">
				<div class="postbox-header">
					<h2 class="hndle">
						<span class="rw-panel-title">
							<span class="rw-panel-title__icon" aria-hidden="true">&#9201;</span>
							<span><?php esc_html_e( 'Follow-ups due', 'restwell-retreats' ); ?></span>
						</span>
					</h2>
				</div>
				<div class="inside">
					<?php if ( empty( $follow_up_rows ) ) : ?>
						<p class="rw-empty"><?php esc_html_e( 'No overdue follow-ups. Nice work.', 'restwell-retreats' ); ?></p>
					<?php else : ?>
						<table class="widefat striped rw-dashboard-table">
							<thead>
								<tr>
									<th><?php esc_html_e( 'Name', 'restwell-retreats' ); ?></th>
									<th><?php esc_html_e( 'Status', 'restwell-retreats' ); ?></th>
									<th><?php esc_html_e( 'Due', 'restwell-retreats' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ( $follow_up_rows as $r ) : ?>
									<tr>
										<td>
											<a href="<?php echo esc_url( add_query_arg( array( 'page' => 'restwell-enquiries', 'view' => $r->id ), admin_url( 'admin.php' ) ) ); ?>">
												<?php echo esc_html( $r->name ); ?>
											</a>
										</td>
										<td><?php echo restwell_crm_status_badge( $r->status ); // phpcs:ignore WordPress.Security.EscapeOutput ?></td>
										<td class="rw-table-meta">
											<?php echo esc_html( date_i18n( 'j M Y', strtotime( $r->follow_up_at ) ) ); ?>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					<?php endif; ?>
				</div>
			</div>

			<!-- Booked without guide -->
			<div class="postbox">
				<div class="postbox-header">
					<h2 class="hndle">
						<span class="rw-panel-title">
							<span class="rw-panel-title__icon" aria-hidden="true">&#128203;</span>
							<span><?php esc_html_e( 'Booked; guide not sent', 'restwell-retreats' ); ?></span>
						</span>
					</h2>
				</div>
				<div class="inside">
					<?php if ( empty( $booked_without_guide ) ) : ?>
						<p class="rw-empty"><?php esc_html_e( 'All booked guests have a guide invitation.', 'restwell-retreats' ); ?></p>
					<?php else : ?>
						<table class="widefat striped rw-dashboard-table">
							<thead>
								<tr>
									<th><?php esc_html_e( 'Name', 'restwell-retreats' ); ?></th>
									<th><?php esc_html_e( 'Dates', 'restwell-retreats' ); ?></th>
									<th><?php esc_html_e( 'Action', 'restwell-retreats' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ( $booked_without_guide as $r ) : ?>
									<?php
									$promote_url = add_query_arg(
										array(
											'page'               => 'restwell-guest-guide',
											'prefill_name'       => rawurlencode( $r->name ),
											'prefill_email'      => rawurlencode( $r->email ),
											'prefill_enquiry_id' => $r->id,
										),
										admin_url( 'admin.php' )
									);
									?>
									<tr>
										<td>
											<a href="<?php echo esc_url( add_query_arg( array( 'page' => 'restwell-enquiries', 'view' => $r->id ), admin_url( 'admin.php' ) ) ); ?>">
												<?php echo esc_html( $r->name ); ?>
											</a>
										</td>
										<td class="rw-table-meta"><?php echo esc_html( $r->preferred_dates ?: '-' ); ?></td>
										<td>
											<a href="<?php echo esc_url( $promote_url ); ?>" class="button button-small">
												<?php esc_html_e( 'Add to Guide', 'restwell-retreats' ); ?>
											</a>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					<?php endif; ?>
				</div>
			</div>

	</div><!-- grid -->

	<!-- Where-to-edit-what orientation panel -->
	<div class="rw-settings-wrap rw-orientation-wrap">
		<div class="postbox">
			<div class="postbox-header">
				<h2 class="hndle">
					<span class="rw-panel-title">
						<span class="rw-panel-title__icon" aria-hidden="true">&#128196;</span>
						<span><?php esc_html_e( 'Where to edit what', 'restwell-retreats' ); ?></span>
					</span>
				</h2>
			</div>
			<div class="inside">
				<p class="description rw-description--tight-top">
					<?php esc_html_e( 'Quick reference — every piece of content and where it lives.', 'restwell-retreats' ); ?>
				</p>
				<table class="widefat rw-orientation-table">
					<thead>
						<tr>
							<th><?php esc_html_e( 'What you want to change', 'restwell-retreats' ); ?></th>
							<th><?php esc_html_e( 'Where to go', 'restwell-retreats' ); ?></th>
							<th><?php esc_html_e( 'Notes', 'restwell-retreats' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$base_url = admin_url( 'admin.php' );
						$pages_url = admin_url( 'edit.php?post_type=page' );
						$rows = array(
							array(
								__( 'Hero text, images, body copy on any page', 'restwell-retreats' ),
								'<a href="' . esc_url( $pages_url ) . '">' . __( 'Pages → edit page → Page Content Fields metabox', 'restwell-retreats' ) . '</a>',
								__( 'Use the tabbed sections in the "Page Content Fields" panel. Changes here update the live site immediately on save.', 'restwell-retreats' ),
							),
							array(
								__( 'FAQ questions &amp; answers', 'restwell-retreats' ),
								'<a href="' . esc_url( admin_url( 'post.php?post=' . (int) get_option( 'page_on_front' ) . '&action=edit' ) ) . '">' . __( 'Front Page → Page Content Fields → FAQ tab', 'restwell-retreats' ) . '</a>',
								__( 'Up to 14 items. The same data renders on the FAQ page, How It Works page, and homepage. Categories: about | booking | care | local | funding.', 'restwell-retreats' ),
							),
							array(
								__( 'SEO title &amp; meta description for a page', 'restwell-retreats' ),
								__( 'Pages → edit page → Page Content Fields → SEO tab', 'restwell-retreats' ),
								__( 'Focus keyphrase and meta description are set per-page here, not in a separate plugin.', 'restwell-retreats' ),
							),
							array(
								__( 'GA4 Measurement ID', 'restwell-retreats' ),
								'<a href="' . esc_url( add_query_arg( 'page', 'restwell-crm', $base_url ) ) . '">' . __( 'Dashboard → Settings (bottom of this page)', 'restwell-retreats' ) . '</a>',
								__( 'Paste your G-XXXXXXXX ID. Analytics loads site-wide once saved.', 'restwell-retreats' ),
							),
							array(
								__( 'Notification email / phone / address', 'restwell-retreats' ),
								'<a href="' . esc_url( add_query_arg( 'page', 'restwell-crm', $base_url ) ) . '">' . __( 'Dashboard → Notification &amp; Site Settings', 'restwell-retreats' ) . '</a>',
								__( 'Property line is for internal copy and the 404 page (not public JSON-LD). Business address fields power Organization / LocalBusiness schema and should match Google Business Profile.', 'restwell-retreats' ),
							),
							array(
								__( 'Enquiries (contact form submissions)', 'restwell-retreats' ),
								'<a href="' . esc_url( add_query_arg( 'page', 'restwell-enquiries', $base_url ) ) . '">' . __( 'Restwell → Enquiries', 'restwell-retreats' ) . '</a>',
								__( 'View, reply, update status, add follow-up notes, and mark urgent.', 'restwell-retreats' ),
							),
							array(
								__( 'Guest guide (pre-stay info sent to bookers)', 'restwell-retreats' ),
								'<a href="' . esc_url( add_query_arg( 'page', 'restwell-guest-guide', $base_url ) ) . '">' . __( 'Restwell → Guest Guide', 'restwell-retreats' ) . '</a>',
								__( 'Create a personalised guide link. Guests receive a private URL with their arrival details.', 'restwell-retreats' ),
							),
							array(
								__( 'Partner logos on the homepage trust strip', 'restwell-retreats' ),
								__( 'Pages → Front Page → Page Content Fields → Partners tab', 'restwell-retreats' ),
								__( 'Upload a PNG for each partner. Leave empty to hide that slot.', 'restwell-retreats' ),
							),
							array(
								__( 'Legal pages (Privacy Policy, Terms etc.)', 'restwell-retreats' ),
								__( 'Pages → edit the relevant legal page → Page Content Fields', 'restwell-retreats' ),
								__( 'Body accepts full HTML via the wp_kses_post sanitiser.', 'restwell-retreats' ),
							),
						);
						foreach ( $rows as $row ) :
						?>
							<tr>
								<td class="rw-orient-what"><strong><?php echo wp_kses_post( $row[0] ); ?></strong></td>
								<td class="rw-orient-where"><?php echo wp_kses_post( $row[1] ); ?></td>
								<td class="rw-orient-notes rw-table-meta"><?php echo wp_kses_post( $row[2] ); ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- Notification settings -->
		<div class="rw-settings-wrap">
			<div class="postbox">
				<div class="postbox-header">
					<h2 class="hndle"><span><?php esc_html_e( 'Notification Settings', 'restwell-retreats' ); ?></span></h2>
				</div>
				<div class="inside">
					<p class="description rw-description--tight-top">
						<?php esc_html_e( 'New enquiry notification emails are sent to this address.', 'restwell-retreats' ); ?>
					</p>
					<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
						<?php wp_nonce_field( 'restwell_crm_settings' ); ?>
						<input type="hidden" name="action" value="restwell_save_settings" />
						<table class="form-table" role="presentation">
							<tr>
								<th scope="row">
									<label for="restwell_enquiry_notify_email">
										<?php esc_html_e( 'Notify email', 'restwell-retreats' ); ?>
									</label>
								</th>
								<td>
									<input
										type="email"
										id="restwell_enquiry_notify_email"
										name="restwell_enquiry_notify_email"
										value="<?php echo esc_attr( (string) get_option( 'restwell_enquiry_notify_email', 'hello@restwellretreats.co.uk' ) ); ?>"
										class="regular-text"
									/>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_phone_number">
										<?php esc_html_e( 'Phone number', 'restwell-retreats' ); ?>
									</label>
								</th>
								<td>
									<input
										type="tel"
										id="restwell_phone_number"
										name="restwell_phone_number"
										value="<?php echo esc_attr( (string) get_option( 'restwell_phone_number', '01622 809881' ) ); ?>"
										class="regular-text"
									/>
									<p class="description">
										<?php esc_html_e( 'Used in email templates and the site footer.', 'restwell-retreats' ); ?>
									</p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_property_address">
										<?php esc_html_e( 'Property street address', 'restwell-retreats' ); ?>
									</label>
								</th>
								<td>
									<input
										type="text"
										id="restwell_property_address"
										name="restwell_property_address"
										value="<?php echo esc_attr( (string) get_option( 'restwell_property_address', '101 Russell Drive' ) ); ?>"
										class="regular-text"
									/>
									<p class="description">
										<?php esc_html_e( 'Shown in on-site copy and the 404 page. Not used in public JSON-LD (use Business address below for Organization / LocalBusiness).', 'restwell-retreats' ); ?>
									</p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_property_postcode">
										<?php esc_html_e( 'Property postcode', 'restwell-retreats' ); ?>
									</label>
								</th>
								<td>
									<input
										type="text"
										id="restwell_property_postcode"
										name="restwell_property_postcode"
										value="<?php echo esc_attr( (string) get_option( 'restwell_property_postcode', 'CT5 2RQ' ) ); ?>"
										class="regular-text"
									/>
									<p class="description">
										<?php esc_html_e( 'Matches the property line above for internal copy; not output in public schema.', 'restwell-retreats' ); ?>
									</p>
								</td>
							</tr>
							<tr>
								<th scope="row" colspan="2">
									<strong><?php esc_html_e( 'Business address (JSON-LD)', 'restwell-retreats' ); ?></strong>
									<p class="description rw-description--tight-top">
										<?php esc_html_e( 'Used for Organization and LocalBusiness structured data. Keep aligned with your Google Business Profile (default: Vinters Business Park, Maidstone).', 'restwell-retreats' ); ?>
									</p>
								</th>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_business_street"><?php esc_html_e( 'Business street', 'restwell-retreats' ); ?></label>
								</th>
								<td>
									<input type="text" id="restwell_business_street" name="restwell_business_street" class="regular-text" value="<?php echo esc_attr( (string) get_option( 'restwell_business_street', 'Vinters Business Park' ) ); ?>" />
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_business_locality"><?php esc_html_e( 'Business town / city', 'restwell-retreats' ); ?></label>
								</th>
								<td>
									<input type="text" id="restwell_business_locality" name="restwell_business_locality" class="regular-text" value="<?php echo esc_attr( (string) get_option( 'restwell_business_locality', 'Maidstone' ) ); ?>" />
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_business_region"><?php esc_html_e( 'Business county / region', 'restwell-retreats' ); ?></label>
								</th>
								<td>
									<input type="text" id="restwell_business_region" name="restwell_business_region" class="regular-text" value="<?php echo esc_attr( (string) get_option( 'restwell_business_region', 'Kent' ) ); ?>" />
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_business_postcode"><?php esc_html_e( 'Business postcode', 'restwell-retreats' ); ?></label>
								</th>
								<td>
									<input type="text" id="restwell_business_postcode" name="restwell_business_postcode" class="regular-text" value="<?php echo esc_attr( (string) get_option( 'restwell_business_postcode', 'ME14 5NZ' ) ); ?>" />
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_business_geo_lat"><?php esc_html_e( 'Business latitude (optional)', 'restwell-retreats' ); ?></label>
								</th>
								<td>
									<input type="text" id="restwell_business_geo_lat" name="restwell_business_geo_lat" class="regular-text" value="<?php echo esc_attr( (string) get_option( 'restwell_business_geo_lat', '51.2707' ) ); ?>" />
									<p class="description"><?php esc_html_e( 'Decimal degrees; used for LocalBusiness geo.', 'restwell-retreats' ); ?></p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_business_geo_lon"><?php esc_html_e( 'Business longitude (optional)', 'restwell-retreats' ); ?></label>
								</th>
								<td>
									<input type="text" id="restwell_business_geo_lon" name="restwell_business_geo_lon" class="regular-text" value="<?php echo esc_attr( (string) get_option( 'restwell_business_geo_lon', '0.5207' ) ); ?>" />
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_footer_cta_heading">
										<?php esc_html_e( 'Footer CTA heading', 'restwell-retreats' ); ?>
									</label>
								</th>
								<td>
									<input
										type="text"
										id="restwell_footer_cta_heading"
										name="restwell_footer_cta_heading"
										value="<?php echo esc_attr( (string) get_option( 'restwell_footer_cta_heading', '' ) ); ?>"
										class="regular-text"
										placeholder="<?php esc_attr_e( 'Ready to plan your break?', 'restwell-retreats' ); ?>"
									/>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_footer_cta_intro">
										<?php esc_html_e( 'Footer CTA intro', 'restwell-retreats' ); ?>
									</label>
								</th>
								<td>
									<textarea
										id="restwell_footer_cta_intro"
										name="restwell_footer_cta_intro"
										rows="3"
										class="large-text"
									><?php echo esc_textarea( (string) get_option( 'restwell_footer_cta_intro', '' ) ); ?></textarea>
									<p class="description">
										<?php esc_html_e( 'Short paragraph below the heading. Leave empty to use the theme default.', 'restwell-retreats' ); ?>
									</p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_footer_cta_primary_label">
										<?php esc_html_e( 'Footer CTA primary button', 'restwell-retreats' ); ?>
									</label>
								</th>
								<td>
									<input
										type="text"
										id="restwell_footer_cta_primary_label"
										name="restwell_footer_cta_primary_label"
										value="<?php echo esc_attr( (string) get_option( 'restwell_footer_cta_primary_label', '' ) ); ?>"
										class="regular-text"
										placeholder="<?php esc_attr_e( 'See the property', 'restwell-retreats' ); ?>"
									/>
									<p class="description">
										<label for="restwell_footer_cta_primary_url"><?php esc_html_e( 'URL path or full link', 'restwell-retreats' ); ?></label><br />
										<input
											type="text"
											id="restwell_footer_cta_primary_url"
											name="restwell_footer_cta_primary_url"
											value="<?php echo esc_attr( (string) get_option( 'restwell_footer_cta_primary_url', '' ) ); ?>"
											class="regular-text"
											placeholder="<?php echo esc_attr( home_url( '/the-property/' ) ); ?>"
										/>
									</p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_footer_cta_btn">
										<?php esc_html_e( 'Footer CTA secondary button', 'restwell-retreats' ); ?>
									</label>
								</th>
								<td>
									<input
										type="text"
										id="restwell_footer_cta_btn"
										name="restwell_footer_cta_btn"
										value="<?php echo esc_attr( (string) get_option( 'restwell_footer_cta_btn', '' ) ); ?>"
										class="regular-text"
										placeholder="<?php esc_attr_e( 'Ask about your dates', 'restwell-retreats' ); ?>"
									/>
									<p class="description">
										<?php esc_html_e( 'Usually links to the Enquire page.', 'restwell-retreats' ); ?>
									</p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_footer_cta_note">
										<?php esc_html_e( 'Footer CTA reassurance line', 'restwell-retreats' ); ?>
									</label>
								</th>
								<td>
									<input
										type="text"
										id="restwell_footer_cta_note"
										name="restwell_footer_cta_note"
										value="<?php echo esc_attr( (string) get_option( 'restwell_footer_cta_note', '' ) ); ?>"
										class="regular-text"
										placeholder="<?php esc_attr_e( 'No booking commitment. Just a conversation.', 'restwell-retreats' ); ?>"
									/>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_gsc_verification">
										<?php esc_html_e( 'Google Search Console verification', 'restwell-retreats' ); ?>
									</label>
								</th>
								<td>
									<input
										type="text"
										id="restwell_gsc_verification"
										name="restwell_gsc_verification"
										value="<?php echo esc_attr( (string) get_option( 'restwell_gsc_verification', '' ) ); ?>"
										class="regular-text"
										placeholder="ABC123..."
									/>
									<p class="description">
										<?php esc_html_e( 'Paste the content value from the Google Search Console HTML meta tag verification method.', 'restwell-retreats' ); ?>
									</p>
								</td>
							</tr>
						<tr>
							<th scope="row">
								<label for="restwell_ga4_measurement_id">
									<?php esc_html_e( 'Google Analytics 4 Measurement ID', 'restwell-retreats' ); ?>
								</label>
							</th>
							<td>
								<?php
								$ga4_current = (string) get_option( 'restwell_ga4_measurement_id', '' );
								if ( $ga4_current === '' ) {
									$ga4_badge_class = 'rw-ga4-badge rw-ga4-badge--unset';
									$ga4_badge_text  = __( 'Not set — analytics inactive', 'restwell-retreats' );
								} elseif ( preg_match( '/^G-[A-Z0-9]+$/i', $ga4_current ) ) {
									$ga4_badge_class = 'rw-ga4-badge rw-ga4-badge--active';
									$ga4_badge_text  = __( 'Active', 'restwell-retreats' );
								} else {
									$ga4_badge_class = 'rw-ga4-badge rw-ga4-badge--invalid';
									$ga4_badge_text  = __( 'Wrong format — should be G-XXXXXXXXXX', 'restwell-retreats' );
								}
								?>
								<div class="rw-ga4-field-wrap">
									<input
										type="text"
										id="restwell_ga4_measurement_id"
										name="restwell_ga4_measurement_id"
										value="<?php echo esc_attr( $ga4_current ); ?>"
										class="regular-text"
										placeholder="G-XXXXXXXXXX"
									/>
									<span class="<?php echo esc_attr( $ga4_badge_class ); ?>" aria-live="polite">
										<?php echo esc_html( $ga4_badge_text ); ?>
									</span>
								</div>
								<p class="description">
									<?php esc_html_e( 'Optional. When set, GA4 is loaded according to “Analytics script placement” below (head, deferred footer, or consent-gated).', 'restwell-retreats' ); ?>
								</p>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="restwell_mailchimp_api_key">
									<?php esc_html_e( 'Mailchimp API key', 'restwell-retreats' ); ?>
								</label>
							</th>
							<td>
								<?php
								$mailchimp_key_stored = (string) get_option( 'restwell_mailchimp_api_key', '' );
								$mailchimp_key_masked = '';
								if ( '' !== $mailchimp_key_stored ) {
									$masked_tail         = substr( $mailchimp_key_stored, -4 );
									$mailchimp_key_masked = '************' . $masked_tail;
								}
								$mailchimp_audience_current = (string) get_option( 'restwell_mailchimp_audience_id', '' );
								$mailchimp_server_current   = (string) get_option( 'restwell_mailchimp_server_prefix', '' );
								if ( restwell_mailchimp_is_configured() ) {
									$mailchimp_badge_class = 'rw-ga4-badge rw-ga4-badge--active';
									$mailchimp_badge_text  = __( 'Configured', 'restwell-retreats' );
								} else {
									$mailchimp_badge_class = 'rw-ga4-badge rw-ga4-badge--unset';
									$mailchimp_badge_text  = __( 'Not configured', 'restwell-retreats' );
								}
								?>
								<div class="rw-ga4-field-wrap">
									<input
										type="password"
										id="restwell_mailchimp_api_key"
										name="restwell_mailchimp_api_key"
										value=""
										class="regular-text"
										autocomplete="new-password"
										placeholder="<?php echo esc_attr( $mailchimp_key_masked ); ?>"
									/>
									<span class="<?php echo esc_attr( $mailchimp_badge_class ); ?>" aria-live="polite">
										<?php echo esc_html( $mailchimp_badge_text ); ?>
									</span>
								</div>
								<p class="description">
									<?php esc_html_e( 'Leave blank to keep your existing API key. Add a new key to replace it.', 'restwell-retreats' ); ?>
								</p>
								<p class="description">
									<label>
										<input type="checkbox" name="restwell_mailchimp_api_key_clear" value="1" />
										<?php esc_html_e( 'Clear stored API key on save', 'restwell-retreats' ); ?>
									</label>
								</p>
								<p class="description">
									<label for="restwell_mailchimp_audience_id"><?php esc_html_e( 'Audience ID', 'restwell-retreats' ); ?></label><br />
									<input
										type="text"
										id="restwell_mailchimp_audience_id"
										name="restwell_mailchimp_audience_id"
										value="<?php echo esc_attr( $mailchimp_audience_current ); ?>"
										class="regular-text"
										placeholder="3ad6ed993b"
									/>
								</p>
								<p class="description">
									<label for="restwell_mailchimp_server_prefix"><?php esc_html_e( 'Server prefix', 'restwell-retreats' ); ?></label><br />
									<input
										type="text"
										id="restwell_mailchimp_server_prefix"
										name="restwell_mailchimp_server_prefix"
										value="<?php echo esc_attr( $mailchimp_server_current ); ?>"
										class="small-text"
										placeholder="us15"
									/>
								</p>
								<p class="description">
									<?php esc_html_e( 'Tip: you can still override these with constants in wp-config.php.', 'restwell-retreats' ); ?>
								</p>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="restwell_metricool_hash">
									<?php esc_html_e( 'Metricool tracking hash', 'restwell-retreats' ); ?>
								</label>
							</th>
							<td>
								<?php
								$metricool_current = (string) get_option( 'restwell_metricool_hash', '' );
								if ( $metricool_current === '' ) {
									$metricool_badge_class = 'rw-ga4-badge rw-ga4-badge--unset';
									$metricool_badge_text  = __( 'Not set — tracking inactive', 'restwell-retreats' );
								} elseif ( preg_match( '/^[a-f0-9]{32}$/i', $metricool_current ) ) {
									$metricool_badge_class = 'rw-ga4-badge rw-ga4-badge--active';
									$metricool_badge_text  = __( 'Active', 'restwell-retreats' );
								} else {
									$metricool_badge_class = 'rw-ga4-badge rw-ga4-badge--invalid';
									$metricool_badge_text  = __( 'Wrong format — should be a 32-character hash', 'restwell-retreats' );
								}
								?>
								<div class="rw-ga4-field-wrap">
								<input
									type="text"
									id="restwell_metricool_hash"
									name="restwell_metricool_hash"
									value="<?php echo esc_attr( $metricool_current ); ?>"
									class="regular-text"
									placeholder="0123456789abcdef0123456789abcdef"
								/>
									<span class="<?php echo esc_attr( $metricool_badge_class ); ?>" aria-live="polite">
										<?php echo esc_html( $metricool_badge_text ); ?>
									</span>
								</div>
								<p class="description">
									<?php esc_html_e( 'Optional. Paste your Metricool 32-character website tracking hash. When valid, tracking loads according to “Analytics script placement”.', 'restwell-retreats' ); ?>
								</p>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="restwell_analytics_load_mode">
									<?php esc_html_e( 'Analytics script placement', 'restwell-retreats' ); ?>
								</label>
							</th>
							<td>
								<?php
								$analytics_mode_current = (string) get_option( 'restwell_analytics_load_mode', 'head' );
								if ( ! in_array( $analytics_mode_current, array( 'head', 'footer_deferred', 'consent_gated' ), true ) ) {
									$analytics_mode_current = 'head';
								}
								?>
								<select name="restwell_analytics_load_mode" id="restwell_analytics_load_mode">
									<option value="head" <?php selected( $analytics_mode_current, 'head' ); ?>>
										<?php esc_html_e( 'Head — load immediately (default)', 'restwell-retreats' ); ?>
									</option>
									<option value="footer_deferred" <?php selected( $analytics_mode_current, 'footer_deferred' ); ?>>
										<?php esc_html_e( 'Footer — deferred loader (better for Core Web Vitals)', 'restwell-retreats' ); ?>
									</option>
									<option value="consent_gated" <?php selected( $analytics_mode_current, 'consent_gated' ); ?>>
										<?php esc_html_e( 'Consent-gated — load only after CMP / consent (recommended with a cookie banner)', 'restwell-retreats' ); ?>
									</option>
								</select>
								<p class="description">
									<?php esc_html_e( 'Consent-gated mode outputs Google Consent Mode defaults in the head and loads GA4 and Metricool only after consent — you do not need CookieAdmin Pro; the free plugin is enough. With CookieAdmin (free), the theme reads the cookieadmin_consent cookie (Accept all or Analytics). Other CMPs can call window.restwellGrantAnalyticsConsent() or dispatch document event restwell-analytics-allow. Cookiebot and CookieYes listeners are included; Complianz often works via cmplz_fire_categories when statistics cookies are allowed.', 'restwell-retreats' ); ?>
								</p>
								<p class="description">
									<?php esc_html_e( 'Verify Search Console using the meta tag above or DNS — GA placement no longer affects verification when using deferred or consent modes.', 'restwell-retreats' ); ?>
								</p>
							</td>
						</tr>
							<tr>
								<th scope="row">
									<label for="restwell_bing_verification">
										<?php esc_html_e( 'Bing Webmaster verification', 'restwell-retreats' ); ?>
									</label>
								</th>
								<td>
									<input
										type="text"
										id="restwell_bing_verification"
										name="restwell_bing_verification"
										value="<?php echo esc_attr( (string) get_option( 'restwell_bing_verification', '' ) ); ?>"
										class="regular-text"
									/>
									<p class="description">
										<?php esc_html_e( 'Paste the content value from Bing’s msvalidate.01 meta tag.', 'restwell-retreats' ); ?>
									</p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_access_statement_url">
										<?php esc_html_e( 'Access statement PDF URL', 'restwell-retreats' ); ?>
									</label>
								</th>
								<td>
									<input
										type="url"
										id="restwell_access_statement_url"
										name="restwell_access_statement_url"
										value="<?php echo esc_attr( (string) get_option( 'restwell_access_statement_url', '' ) ); ?>"
										class="regular-text"
										placeholder="https://"
									/>
									<p class="description">
										<?php esc_html_e( 'Upload the PDF to Media Library, then paste the file URL here. Linked from the footer and Accessibility page.', 'restwell-retreats' ); ?>
									</p>
								</td>
							</tr>
							<tr>
								<th scope="row"><?php esc_html_e( 'CRM role access', 'restwell-retreats' ); ?></th>
								<td>
									<?php
									$cap_roles = restwell_crm_get_cap_roles();
									$role_choices = array(
										'administrator' => __( 'Administrator', 'restwell-retreats' ),
										'editor'        => __( 'Editor', 'restwell-retreats' ),
										'author'        => __( 'Author', 'restwell-retreats' ),
									);
									?>
									<div class="rw-checkbox-stack">
									<?php foreach ( $role_choices as $role_slug => $role_label ) : ?>
										<label>
											<input type="checkbox" name="restwell_crm_cap_roles[]" value="<?php echo esc_attr( $role_slug ); ?>" <?php checked( in_array( $role_slug, $cap_roles, true ) ); ?> />
											<?php echo esc_html( $role_label ); ?>
										</label>
									<?php endforeach; ?>
									</div>
									<p class="description"><?php esc_html_e( 'Selected roles can access and edit CRM enquiries.', 'restwell-retreats' ); ?></p>
								</td>
							</tr>
						</table>
					<?php submit_button( __( 'Save', 'restwell-retreats' ), 'secondary', 'submit', false ); ?>
				</form>
			</div>
		</div>
	</div>

	<!-- Export audit log -->
	<div class="rw-settings-wrap">
		<div class="postbox">
			<div class="postbox-header">
				<h2 class="hndle">
					<span class="rw-panel-title">
						<span class="rw-panel-title__icon" aria-hidden="true">&#128196;</span>
						<span><?php esc_html_e( 'Export Audit Log', 'restwell-retreats' ); ?></span>
					</span>
				</h2>
			</div>
			<div class="inside">
				<?php
				$export_log     = get_option( 'restwell_crm_export_log', array() );
				$export_log     = is_array( $export_log ) ? $export_log : array();
				$recent_exports = array_slice( array_reverse( $export_log ), 0, 10 );
				if ( empty( $recent_exports ) ) :
				?>
					<p class="rw-empty"><?php esc_html_e( 'No exports have been run yet.', 'restwell-retreats' ); ?></p>
				<?php else : ?>
					<table class="widefat striped rw-dashboard-table">
						<thead>
							<tr>
								<th><?php esc_html_e( 'User', 'restwell-retreats' ); ?></th>
								<th><?php esc_html_e( 'Exported at (UTC)', 'restwell-retreats' ); ?></th>
								<th><?php esc_html_e( 'Rows', 'restwell-retreats' ); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ( $recent_exports as $entry ) :
								$exporter    = isset( $entry['user_id'] ) ? get_userdata( (int) $entry['user_id'] ) : false;
								$display     = $exporter ? esc_html( $exporter->display_name ) : esc_html__( 'Unknown', 'restwell-retreats' );
								$exported_at = isset( $entry['exported_at'] ) ? esc_html( $entry['exported_at'] ) : '—';
								$row_count   = isset( $entry['row_count'] ) ? absint( $entry['row_count'] ) : '—';
							?>
							<tr>
								<td><?php echo $display; // phpcs:ignore WordPress.Security.EscapeOutput — already escaped above ?></td>
								<td class="rw-table-meta"><?php echo $exported_at; // phpcs:ignore WordPress.Security.EscapeOutput — already escaped above ?></td>
								<td class="rw-table-meta"><?php echo esc_html( (string) $row_count ); ?></td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				<?php endif; ?>
			</div>
		</div>
	</div>

</div><!-- .wrap -->
	<?php
}

// ─────────────────────────────────────────────────────────────────────────────
// 8. ENQUIRIES LIST PAGE
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Render the Enquiries admin page (list and detail views).
 */
function restwell_crm_enquiries_page() {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'You do not have permission to access this page.', 'restwell-retreats' ), '', array( 'response' => 403 ) );
	}

	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_CRM_TABLE;

	// ── Handle status + notes update from detail view ────────────────────────
	if (
		isset( $_POST['rw_crm_nonce'], $_POST['rw_enquiry_id'], $_POST['rw_status'] )
		&& wp_verify_nonce( sanitize_key( $_POST['rw_crm_nonce'] ), 'restwell_crm_action' )
	) {
		$id         = absint( $_POST['rw_enquiry_id'] );
		$new_status = sanitize_key( $_POST['rw_status'] );
		$notes      = isset( $_POST['rw_notes'] ) ? sanitize_textarea_field( wp_unslash( $_POST['rw_notes'] ) ) : '';

		// Parse follow-up date from datetime-local format (YYYY-MM-DDTHH:MM).
		$follow_up_raw = isset( $_POST['rw_follow_up'] ) ? sanitize_text_field( wp_unslash( $_POST['rw_follow_up'] ) ) : '';
		$follow_up_at  = $follow_up_raw ? str_replace( 'T', ' ', $follow_up_raw ) . ':00' : null;

		if ( array_key_exists( $new_status, restwell_crm_statuses() ) ) {
			// Status transition (timestamps, status-change note, booking email) is
			// handled entirely by the unified function.
			restwell_crm_apply_status_change( $id, $new_status, 'detail' );

			// Detail-view-only fields: notes, follow-up date.
			$wpdb->update(
				$table,
				array(
					'staff_notes'  => $notes,
					'follow_up_at' => $follow_up_at,
				),
				array( 'id' => $id ),
				array( '%s', '%s' ),
				array( '%d' )
			);
		}

		wp_safe_redirect(
			add_query_arg( array( 'page' => 'restwell-enquiries', 'view' => $id, 'updated' => '1' ), admin_url( 'admin.php' ) )
		);
		exit;
	}

	// ── Handle bulk status update ────────────────────────────────────────────
	if (
		isset( $_POST['rw_bulk_nonce'], $_POST['rw_bulk_action'], $_POST['rw_bulk_ids'] )
		&& wp_verify_nonce( sanitize_key( $_POST['rw_bulk_nonce'] ), 'restwell_crm_bulk' )
	) {
		$bulk_action = sanitize_key( $_POST['rw_bulk_action'] );
		$ids         = array_filter( array_map( 'absint', (array) $_POST['rw_bulk_ids'] ) );

		if ( array_key_exists( $bulk_action, restwell_crm_statuses() ) && $ids ) {
			foreach ( $ids as $id ) {
				// Booking confirmation email is suppressed in bulk context (context = 'bulk').
				restwell_crm_apply_status_change( $id, $bulk_action, 'bulk' );
			}
		}

		wp_safe_redirect( add_query_arg( array( 'page' => 'restwell-enquiries', 'updated' => '1' ), admin_url( 'admin.php' ) ) );
		exit;
	}

	// ── Single enquiry detail view ───────────────────────────────────────────
	if ( isset( $_GET['view'] ) ) {
		restwell_crm_enquiry_detail( absint( $_GET['view'] ) );
		return;
	}

	// ── Build WHERE clause safely ────────────────────────────────────────────
	// SAFETY: only append fragments returned by $wpdb->prepare() — never raw $_GET strings.
	$status_filter      = isset( $_GET['status_filter'] ) ? sanitize_key( $_GET['status_filter'] ) : '';
	$search             = isset( $_GET['s'] ) ? sanitize_text_field( wp_unslash( $_GET['s'] ) ) : '';
	$urgent_filter      = isset( $_GET['urgent_filter'] ) ? absint( $_GET['urgent_filter'] ) : 0;
	$follow_up_filter   = isset( $_GET['follow_up_filter'] ) ? sanitize_key( $_GET['follow_up_filter'] ) : '';
	$submitted_since_raw = isset( $_GET['submitted_since'] ) ? sanitize_text_field( wp_unslash( $_GET['submitted_since'] ) ) : '';
	$per_page           = 25;
	$current_page       = max( 1, isset( $_GET['paged'] ) ? absint( $_GET['paged'] ) : 1 );
	$offset             = ( $current_page - 1 ) * $per_page;

	// Sortable columns.
	$allowed_orderby = array( 'submitted_at', 'status', 'name' );
	$orderby_raw     = isset( $_GET['orderby'] ) ? sanitize_key( $_GET['orderby'] ) : 'submitted_at';
	$orderby         = in_array( $orderby_raw, $allowed_orderby, true ) ? $orderby_raw : 'submitted_at';
	$order_raw       = isset( $_GET['order'] ) ? strtoupper( sanitize_key( $_GET['order'] ) ) : 'DESC';
	$order           = ( 'ASC' === $order_raw ) ? 'ASC' : 'DESC';

	$where_parts = array( '1=1' );

	if ( $status_filter && array_key_exists( $status_filter, restwell_crm_statuses() ) ) {
		$where_parts[] = $wpdb->prepare( 'status = %s', $status_filter );
	}
	if ( $search ) {
		$like          = '%' . $wpdb->esc_like( $search ) . '%';
		$where_parts[] = $wpdb->prepare( '(name LIKE %s OR email LIKE %s OR phone LIKE %s)', $like, $like, $like );
	}
	if ( $urgent_filter ) {
		$where_parts[] = 'is_urgent = 1';
	}
	if ( 'overdue' === $follow_up_filter ) {
		$where_parts[] = $wpdb->prepare(
			'follow_up_at IS NOT NULL AND follow_up_at <= %s AND status != %s',
			current_time( 'mysql' ),
			'closed'
		);
	}
	if ( $submitted_since_raw ) {
		$submitted_since_ts = strtotime( $submitted_since_raw );
		if ( $submitted_since_ts ) {
			$where_parts[] = $wpdb->prepare( 'submitted_at >= %s', gmdate( 'Y-m-d H:i:s', $submitted_since_ts ) );
		}
	}

	$where = implode( ' AND ', $where_parts );

	// phpcs:disable WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	$total = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$table} WHERE {$where}" );
	$rows  = $wpdb->get_results(
		$wpdb->prepare( "SELECT * FROM {$table} WHERE {$where} ORDER BY {$orderby} {$order} LIMIT %d OFFSET %d", $per_page, $offset )
	);
	// phpcs:enable

	$total_pages = (int) ceil( $total / $per_page );
	$statuses    = restwell_crm_statuses();
	$base_url    = admin_url( 'admin.php?page=restwell-enquiries' );
	$now_mysql   = current_time( 'mysql' );

	// Status counts for tabs.
	$counts = array();
	foreach ( array_keys( $statuses ) as $s ) {
		// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		$counts[ $s ] = (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$table} WHERE status = %s", $s ) );
	}
	// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	$counts['all'] = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$table}" );

	?>
	<div class="wrap restwell-admin restwell-admin-enquiries">
		<div class="rw-page-toolbar">
			<h1 class="wp-heading-inline"><?php esc_html_e( 'Enquiries', 'restwell-retreats' ); ?></h1>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="rw-export-form">
				<?php wp_nonce_field( 'restwell_crm_export_csv' ); ?>
				<input type="hidden" name="action" value="restwell_crm_export_csv" />
				<button type="submit" class="page-title-action">
					&#8659; <?php esc_html_e( 'Export CSV', 'restwell-retreats' ); ?>
				</button>
			</form>
		</div>

		<?php if ( isset( $_GET['updated'] ) ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Changes saved.', 'restwell-retreats' ); ?></p></div>
		<?php endif; ?>

		<div class="rw-enquiries-panel">
		<div class="rw-enquiries-controls">
			<div class="rw-enquiries-controls__primary">
			<!-- Status filter tabs -->
			<div class="rw-filter-group">
				<span class="rw-filter-group__label" id="rw-enquiries-status-label"><?php esc_html_e( 'Status', 'restwell-retreats' ); ?></span>
				<ul class="subsubsub rw-subsubsub--status rw-filter-pills" role="list" aria-labelledby="rw-enquiries-status-label">
					<li>
						<a href="<?php echo esc_url( $base_url ); ?>" <?php if ( ! $status_filter ) echo 'class="current"'; ?>>
							<?php esc_html_e( 'All', 'restwell-retreats' ); ?> <span class="count">(<?php echo esc_html( $counts['all'] ); ?>)</span>
						</a>
					</li>
					<?php foreach ( $statuses as $slug => $info ) : ?>
						<li>
							<a href="<?php echo esc_url( add_query_arg( 'status_filter', $slug, $base_url ) ); ?>"
							   <?php if ( $status_filter === $slug ) echo 'class="current"'; ?>>
								<?php echo esc_html( $info['label'] ); ?> <span class="count">(<?php echo esc_html( $counts[ $slug ] ); ?>)</span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
			</div><!-- .rw-enquiries-controls__primary -->

			<!-- Search (sibling of __primary: second column of .rw-enquiries-controls grid) -->
			<div class="rw-enquiries-search">
				<span class="rw-filter-group__label" id="rw-enquiries-search-label"><?php esc_html_e( 'Search', 'restwell-retreats' ); ?></span>
				<form method="get" action="<?php echo esc_url( admin_url( 'admin.php' ) ); ?>" aria-labelledby="rw-enquiries-search-label">
					<input type="hidden" name="page" value="restwell-enquiries">
					<?php if ( $status_filter ) : ?>
						<input type="hidden" name="status_filter" value="<?php echo esc_attr( $status_filter ); ?>">
					<?php endif; ?>
					<p class="search-box">
						<label class="screen-reader-text" for="rw-crm-search"><?php esc_html_e( 'Search enquiries', 'restwell-retreats' ); ?></label>
						<input type="search" id="rw-crm-search" name="s"
							   value="<?php echo esc_attr( $search ); ?>"
							   placeholder="<?php esc_attr_e( 'Name, email or phone…', 'restwell-retreats' ); ?>">
						<input type="submit" class="button" value="<?php esc_attr_e( 'Search', 'restwell-retreats' ); ?>">
						<?php if ( $search ) : ?>
							<a class="button" href="<?php echo esc_url( $base_url ); ?>"><?php esc_html_e( 'Clear', 'restwell-retreats' ); ?></a>
						<?php endif; ?>
					</p>
				</form>
			</div>
		</div><!-- .rw-enquiries-controls -->

		<?php if ( empty( $rows ) ) : ?>
			<div class="rw-enquiries-empty">
				<div class="rw-enquiries-empty__inner">
					<div class="rw-enquiries-empty__figure" aria-hidden="true">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80" fill="none" focusable="false">
							<circle cx="40" cy="40" r="38" stroke="currentColor" stroke-width="1.5" opacity="0.2"/>
							<path d="M24 32h32a4 4 0 014 4v16a4 4 0 01-4 4H24a4 4 0 01-4-4V36a4 4 0 014-4z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
							<path d="M22 36l18 12 18-12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</div>
					<p class="rw-enquiries-empty__title"><?php esc_html_e( 'No enquiries yet', 'restwell-retreats' ); ?></p>
					<p class="rw-enquiries-empty__text"><?php esc_html_e( 'When visitors submit the enquiry form on your site, they will show up here. You can filter by status and search by name or contact details.', 'restwell-retreats' ); ?></p>
				</div>
			</div>
		<?php else : ?>

		<!-- Bulk action + list -->
		<form method="post" action="">
			<?php wp_nonce_field( 'restwell_crm_bulk', 'rw_bulk_nonce' ); ?>

			<div class="rw-table-shell rw-table-shell--enquiries">
			<div class="tablenav top">
				<div class="alignleft actions bulkactions">
					<label for="rw-bulk-action" class="screen-reader-text"><?php esc_html_e( 'Select bulk action', 'restwell-retreats' ); ?></label>
					<select name="rw_bulk_action" id="rw-bulk-action">
						<option value=""><?php esc_html_e( '- Bulk action -', 'restwell-retreats' ); ?></option>
						<?php foreach ( $statuses as $slug => $info ) : ?>
							<option value="<?php echo esc_attr( $slug ); ?>">
								<?php
								/* translators: %s: status label */
								printf( esc_html__( 'Mark as %s', 'restwell-retreats' ), esc_html( $info['label'] ) );
								?>
							</option>
						<?php endforeach; ?>
					</select>
					<input type="submit" class="button action" value="<?php esc_attr_e( 'Apply', 'restwell-retreats' ); ?>">
				</div>

				<?php if ( $total_pages > 1 ) : ?>
					<div class="tablenav-pages">
						<span class="displaying-num">
							<?php
							/* translators: %d: number of items */
							printf( esc_html__( '%d items', 'restwell-retreats' ), esc_html( $total ) );
							?>
						</span>
						<?php for ( $p = 1; $p <= $total_pages; $p++ ) : ?>
							<a class="button<?php echo $p === $current_page ? ' button-primary' : ''; ?>"
							   href="<?php echo esc_url( add_query_arg( array( 'paged' => $p, 'status_filter' => $status_filter, 's' => $search ), $base_url ) ); ?>">
								<?php echo esc_html( $p ); ?>
							</a>
						<?php endfor; ?>
					</div>
				<?php endif; ?>
			</div>

			<table class="wp-list-table widefat striped rw-enquiries-table">
			<?php
			/**
			 * Build a sortable column header link.
			 *
			 * @param string $col     Column key (must be in $allowed_orderby).
			 * @param string $label   Display label.
			 * @param string $current Current $orderby value.
			 * @param string $current_order Current $order value.
			 * @param string $base    Base URL.
			 * @param array  $extras  Extra query args to preserve.
			 * @return string HTML.
			 */
			$sort_link = function( string $col, string $label, string $current, string $current_order, string $base, array $extras ): string {
				$is_active  = ( $col === $current );
				$next_order = $is_active && 'ASC' === $current_order ? 'DESC' : 'ASC';
				$arrow      = '';
				if ( $is_active ) {
					$arrow = 'ASC' === $current_order
						? ' <span aria-hidden="true">&#9650;</span>'
						: ' <span aria-hidden="true">&#9660;</span>';
				}
				$href = add_query_arg( array_merge( $extras, array( 'orderby' => $col, 'order' => $next_order ) ), $base );
				return sprintf(
					'<a href="%s" class="%s">%s%s</a>',
					esc_url( $href ),
					$is_active ? 'rw-sort-link rw-sort-link--active' : 'rw-sort-link',
					esc_html( $label ),
					$arrow
				);
			};
			$sort_extras = array_filter( array(
				'page'          => 'restwell-enquiries',
				'status_filter' => $status_filter,
				's'             => $search,
			) );
			?>
			<thead>
				<tr>
					<td class="manage-column check-column">
						<input id="cb-select-all" type="checkbox">
					</td>
					<th scope="col" class="column-rw-flag"><span class="screen-reader-text"><?php esc_html_e( 'Flags', 'restwell-retreats' ); ?></span></th>
					<th scope="col" class="column-rw-name sortable <?php echo 'name' === $orderby ? 'sorted' : ''; ?>">
						<?php echo $sort_link( 'name', __( 'Name', 'restwell-retreats' ), $orderby, $order, admin_url( 'admin.php' ), $sort_extras ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
					</th>
					<th scope="col" class="column-rw-contact"><?php esc_html_e( 'Contact', 'restwell-retreats' ); ?></th>
					<th scope="col" class="column-rw-marketing"><?php esc_html_e( 'Marketing', 'restwell-retreats' ); ?></th>
					<th scope="col" class="column-rw-dates"><?php esc_html_e( 'Dates / Guests', 'restwell-retreats' ); ?></th>
					<th scope="col" class="column-rw-status sortable <?php echo 'status' === $orderby ? 'sorted' : ''; ?>">
						<?php echo $sort_link( 'status', __( 'Status', 'restwell-retreats' ), $orderby, $order, admin_url( 'admin.php' ), $sort_extras ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
					</th>
					<th scope="col" class="column-rw-received sortable <?php echo 'submitted_at' === $orderby ? 'sorted' : ''; ?>">
						<?php echo $sort_link( 'submitted_at', __( 'Received', 'restwell-retreats' ), $orderby, $order, admin_url( 'admin.php' ), $sort_extras ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
					</th>
				</tr>
			</thead>
				<tbody>
					<?php foreach ( $rows as $row ) : ?>
						<?php
					$detail_url    = add_query_arg( array( 'page' => 'restwell-enquiries', 'view' => $row->id ), admin_url( 'admin.php' ) );
					$is_overdue    = ! empty( $row->follow_up_at ) && $row->follow_up_at <= $now_mysql && 'closed' !== $row->status;
					$sla_badge     = restwell_crm_sla_badge( $row );
						?>
						<tr<?php echo $row->is_urgent ? ' class="rw-row--urgent"' : ''; ?>>
							<th scope="row" class="check-column">
								<input type="checkbox" name="rw_bulk_ids[]" value="<?php echo esc_attr( $row->id ); ?>">
							</th>
							<td class="column-rw-flag">
								<?php if ( $row->is_urgent ) : ?>
									<span class="rw-badge rw-badge--urgent" title="<?php esc_attr_e( 'Urgent', 'restwell-retreats' ); ?>"><?php esc_html_e( 'Urgent', 'restwell-retreats' ); ?></span>
								<?php elseif ( $is_overdue ) : ?>
									<span class="rw-badge rw-badge--overdue" title="<?php esc_attr_e( 'Follow-up overdue', 'restwell-retreats' ); ?>"><?php esc_html_e( 'Overdue', 'restwell-retreats' ); ?></span>
								<?php endif; ?>
							</td>
							<td class="column-rw-name">
								<strong><a href="<?php echo esc_url( $detail_url ); ?>"><?php echo esc_html( $row->name ); ?></a></strong>
								<?php if ( $sla_badge ) : ?>
									<div class="rw-sla-badge"><?php echo $sla_badge; // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
								<?php endif; ?>
								<?php if ( $row->staff_notes ) : ?>
									<br><span class="rw-staff-note-preview">
										&#128221; <?php echo esc_html( wp_trim_words( $row->staff_notes, 10 ) ); ?>
									</span>
								<?php endif; ?>
							</td>
							<td class="column-rw-contact">
								<a href="mailto:<?php echo esc_attr( $row->email ); ?>"><?php echo esc_html( $row->email ); ?></a>
								<?php if ( $row->phone ) : ?>
									<br>
									<a href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', $row->phone ) ); ?>">
										<?php echo esc_html( $row->phone ); ?>
									</a>
								<?php endif; ?>
							</td>
							<td class="column-rw-marketing rw-text-meta">
								<?php if ( ! empty( $row->marketing_optin ) ) : ?>
									<span class="rw-badge rw-badge--booked"><?php esc_html_e( 'Opted in', 'restwell-retreats' ); ?></span>
									<?php if ( ! empty( $row->marketing_optin_at ) ) : ?>
										<br><span class="rw-text-muted-sm"><?php echo esc_html( date_i18n( 'j M Y', strtotime( $row->marketing_optin_at ) ) ); ?></span>
									<?php endif; ?>
								<?php else : ?>
									<span class="rw-text-dim"><?php esc_html_e( 'No', 'restwell-retreats' ); ?></span>
								<?php endif; ?>
							</td>
							<td class="column-rw-dates">
								<?php if ( $row->preferred_dates ) : ?>
									<span class="rw-text-meta"><?php echo esc_html( $row->preferred_dates ); ?></span>
								<?php endif; ?>
								<?php if ( $row->num_guests ) : ?>
									<br><span class="rw-text-muted-sm"><?php echo esc_html( $row->num_guests ); ?> guests</span>
								<?php endif; ?>
								<?php if ( ! $row->preferred_dates && ! $row->num_guests ) : ?>
									<span class="rw-text-dim">-</span>
								<?php endif; ?>
							</td>
							<td class="column-rw-status">
							<div class="rw-status-badge" data-enquiry-id="<?php echo esc_attr( $row->id ); ?>"><?php echo restwell_crm_status_badge( $row->status ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
								<div class="rw-status-actions">
									<a class="rw-details-link" href="<?php echo esc_url( $detail_url ); ?>">
										<?php esc_html_e( 'Open details', 'restwell-retreats' ); ?>
									</a>
								</div>
							</td>
							<td class="column-rw-received rw-text-meta">
								<?php echo esc_html( date_i18n( 'j M Y', strtotime( $row->submitted_at ) ) ); ?>
								<br><?php echo esc_html( date_i18n( 'H:i', strtotime( $row->submitted_at ) ) ); ?>
								<?php if ( $is_overdue ) : ?>
									<br><span class="rw-follow-up-hint">
										&#9201; <?php echo esc_html( date_i18n( 'j M', strtotime( $row->follow_up_at ) ) ); ?>
									</span>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			</div><!-- .rw-table-shell--enquiries -->
		</form>

		<?php endif; ?>
		</div><!-- .rw-enquiries-panel -->
	</div>

	<script>
	( function() {
		var selectAll = document.getElementById( 'cb-select-all' );
		if ( selectAll ) {
			selectAll.addEventListener( 'change', function() {
				document.querySelectorAll( '[name="rw_bulk_ids[]"]' ).forEach( function( cb ) {
					cb.checked = selectAll.checked;
				} );
			} );
		}
	} )();
	</script>
	<?php
}

// ─────────────────────────────────────────────────────────────────────────────
// 9. ENQUIRY DETAIL / EDIT VIEW
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Render the single-enquiry detail page.
 *
 * @param int $id Enquiry row ID.
 */
function restwell_crm_enquiry_detail( int $id ) {
	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_CRM_TABLE;
	// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	$row = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$table} WHERE id = %d", $id ) );

	if ( ! $row ) {
		echo '<div class="wrap"><div class="notice notice-error"><p>' . esc_html__( 'Enquiry not found.', 'restwell-retreats' ) . '</p></div></div>';
		return;
	}

	$statuses = restwell_crm_statuses();
	$back_url = admin_url( 'admin.php?page=restwell-enquiries' );
	$notes    = restwell_crm_get_notes( $id );

	// Build mailto with subject pre-filled.
	$mailto = 'mailto:' . rawurlencode( $row->email ) . '?subject=' . rawurlencode( 'Re: Your Restwell Retreats Enquiry' );

	// Format follow-up datetime for the datetime-local input (YYYY-MM-DDTHH:MM).
	$follow_up_value = '';
	if ( ! empty( $row->follow_up_at ) ) {
		$follow_up_value = date( 'Y-m-d\TH:i', strtotime( $row->follow_up_at ) );
	}

	// Promote-to-guest URL.
	$promote_url = add_query_arg(
		array(
			'page'               => 'restwell-guest-guide',
			'prefill_name'       => rawurlencode( $row->name ),
			'prefill_email'      => rawurlencode( $row->email ),
			'prefill_enquiry_id' => $row->id,
		),
		admin_url( 'admin.php' )
	);
	?>
	<div class="wrap restwell-admin restwell-admin-enquiry-detail">
		<h1 class="rw-detail-title-row">
			<a href="<?php echo esc_url( $back_url ); ?>" class="rw-back-link">
				&larr; <?php esc_html_e( 'All Enquiries', 'restwell-retreats' ); ?>
			</a>
			<span class="rw-title-sep" aria-hidden="true">|</span>
			<?php if ( $row->is_urgent ) : ?>
				<span class="rw-urgent-flag" title="<?php esc_attr_e( 'Urgent', 'restwell-retreats' ); ?>">&#9873; <?php esc_html_e( 'URGENT', 'restwell-retreats' ); ?>:</span>
			<?php endif; ?>
			<?php echo esc_html( $row->name ); ?>
			<?php echo restwell_crm_status_badge( $row->status ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		</h1>

		<?php if ( isset( $_GET['updated'] ) ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Changes saved.', 'restwell-retreats' ); ?></p></div>
		<?php endif; ?>
		<?php if ( isset( $_GET['note_added'] ) ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Note added.', 'restwell-retreats' ); ?></p></div>
		<?php endif; ?>
		<?php if ( isset( $_GET['stay_dates_updated'] ) ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Stay dates updated. The change has been recorded in the activity log.', 'restwell-retreats' ); ?></p></div>
		<?php endif; ?>
		<?php if ( isset( $_GET['stay_dates_unchanged'] ) ) : ?>
			<div class="notice notice-info is-dismissible"><p><?php esc_html_e( 'Stay dates were already set to those values — nothing to update.', 'restwell-retreats' ); ?></p></div>
		<?php endif; ?>
		<?php if ( isset( $_GET['stay_dates_error'] ) ) : ?>
			<div class="notice notice-error is-dismissible">
				<p>
					<?php
					// Two distinct error reasons get two distinct messages so staff
					// know exactly what to fix without guessing.
					if ( 'order' === $_GET['stay_dates_error'] ) {
						esc_html_e( 'End date must be on or after the start date.', 'restwell-retreats' );
					} else {
						esc_html_e( 'One of the dates was not in a valid format. Please use the date pickers to enter a date.', 'restwell-retreats' );
					}
					?>
				</p>
			</div>
		<?php endif; ?>

		<div class="rw-detail-layout">

			<!-- ── Left: enquiry details ─────────────────────────────────── -->
			<div class="rw-detail-layout__main">
				<div class="postbox">
					<div class="postbox-header">
						<h2 class="hndle"><span><?php esc_html_e( 'Enquiry Details', 'restwell-retreats' ); ?></span></h2>
					</div>
					<div class="inside">

						<?php
						$contact_fields = array(
							__( 'Name', 'restwell-retreats' )              => esc_html( $row->name ),
							__( 'Email', 'restwell-retreats' )             => '<a href="mailto:' . esc_attr( $row->email ) . '">' . esc_html( $row->email ) . '</a>',
							__( 'Phone', 'restwell-retreats' )             => $row->phone
								? '<a href="tel:' . esc_attr( preg_replace( '/[^\d+]/', '', $row->phone ) ) . '">' . esc_html( $row->phone ) . '</a>'
								: '',
							__( 'Preferred contact', 'restwell-retreats' ) => esc_html( $row->contact_preference ),
							__( 'Best time to call', 'restwell-retreats' ) => esc_html( $row->preferred_time ),
							__( 'Marketing preference', 'restwell-retreats' ) => ! empty( $row->marketing_optin )
								? esc_html__( 'Opted in', 'restwell-retreats' )
								: esc_html__( 'Not opted in', 'restwell-retreats' ),
						);
						if ( ! empty( $row->marketing_optin ) && ! empty( $row->marketing_optin_at ) ) {
							$contact_fields[ __( 'Marketing opted in at', 'restwell-retreats' ) ] = esc_html(
								date_i18n( 'j M Y, H:i', strtotime( $row->marketing_optin_at ) )
							);
						}
						// Preferred dates moved out of this read-only block — they get
						// their own editable panel below so staff can update them without
						// needing a separate edit screen. Guests and funding stay read-only:
						// guest count edits are rare and would warrant their own UX, and
						// funding type drives downstream comms so we don't want it changing
						// silently from the detail page.
						$booking_fields = array(
							__( 'Number of guests', 'restwell-retreats' ) => esc_html( $row->num_guests ),
							__( 'Funding type', 'restwell-retreats' )    => esc_html( function_exists( 'restwell_enquiry_funding_label' ) ? restwell_enquiry_funding_label( (string) $row->funding_type ) : $row->funding_type ),
						);
						?>

						<h3 class="rw-detail-section-title"><?php esc_html_e( 'Contact', 'restwell-retreats' ); ?></h3>
						<table class="form-table rw-readonly-table" role="presentation">
							<?php foreach ( $contact_fields as $label => $value ) : ?>
								<?php if ( $value ) : ?>
									<tr>
										<th scope="row"><?php echo esc_html( $label ); ?></th>
										<td><?php echo wp_kses_post( $value ); ?></td>
									</tr>
								<?php endif; ?>
							<?php endforeach; ?>
						</table>

						<h3 class="rw-detail-section-title"><?php esc_html_e( 'Booking', 'restwell-retreats' ); ?></h3>
						<table class="form-table rw-readonly-table" role="presentation">
							<?php foreach ( $booking_fields as $label => $value ) : ?>
								<?php if ( $value ) : ?>
									<tr>
										<th scope="row"><?php echo esc_html( $label ); ?></th>
										<td><?php echo wp_kses_post( $value ); ?></td>
									</tr>
								<?php endif; ?>
							<?php endforeach; ?>
						</table>

						<?php
						/*
						 * Editable stay-dates panel.
						 *
						 * Standalone form with native HTML5 date inputs (the device's own
						 * picker — no JS-driven calendar widget to fight with screen readers
						 * or break on mobile). Empty inputs are valid and clear the dates.
						 *
						 * The handler `restwell_crm_handle_update_stay_dates()` writes a
						 * "Stay dates updated: {old} → {new}" entry to the activity log on
						 * every change, so this is auditable without staff having to
						 * remember to leave a note.
						 */
						$stay_from = $row->date_from ? esc_attr( $row->date_from ) : '';
						$stay_to   = $row->date_to   ? esc_attr( $row->date_to )   : '';
						?>
						<h3 class="rw-detail-section-title">
							<?php esc_html_e( 'Stay dates', 'restwell-retreats' ); ?>
						</h3>
						<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="rw-stay-dates-form">
							<?php wp_nonce_field( 'restwell_crm_update_stay_dates' ); ?>
							<input type="hidden" name="action" value="restwell_crm_update_stay_dates" />
							<input type="hidden" name="rw_enquiry_id" value="<?php echo esc_attr( (string) $row->id ); ?>" />

							<div class="rw-stay-dates-grid">
								<p class="rw-stay-dates-field">
									<label for="rw_date_from">
										<?php esc_html_e( 'Arriving', 'restwell-retreats' ); ?>
									</label>
									<input
										type="date"
										id="rw_date_from"
										name="rw_date_from"
										value="<?php echo esc_attr( $stay_from ); ?>"
									/>
								</p>
								<p class="rw-stay-dates-field">
									<label for="rw_date_to">
										<?php esc_html_e( 'Leaving', 'restwell-retreats' ); ?>
									</label>
									<input
										type="date"
										id="rw_date_to"
										name="rw_date_to"
										value="<?php echo esc_attr( $stay_to ); ?>"
									/>
								</p>
							</div>

							<p class="rw-stay-dates-actions">
								<button type="submit" class="button button-primary">
									<?php esc_html_e( 'Save stay dates', 'restwell-retreats' ); ?>
								</button>
								<span class="description rw-stay-dates-help">
									<?php
									if ( '' !== (string) $row->preferred_dates ) {
										printf(
											/* translators: %s: current preferred-dates value as the guest entered or last edited it */
											esc_html__( 'Currently shown as: %s. Leave both empty to clear. Changes are recorded in the activity log.', 'restwell-retreats' ),
											esc_html( $row->preferred_dates )
										);
									} else {
										esc_html_e( 'No stay dates set yet. Changes are recorded in the activity log.', 'restwell-retreats' );
									}
									?>
								</span>
							</p>
						</form>

						<?php if ( $row->care_requirements ) : ?>
							<h3 class="rw-detail-section-title"><?php esc_html_e( 'Care Requirements', 'restwell-retreats' ); ?></h3>
							<p class="rw-prose-block">
								<?php echo esc_html( $row->care_requirements ); ?>
							</p>
						<?php endif; ?>

						<?php if ( $row->accessibility ) : ?>
							<h3 class="rw-detail-section-title"><?php esc_html_e( 'Accessibility Needs', 'restwell-retreats' ); ?></h3>
							<p class="rw-prose-block">
								<?php echo esc_html( $row->accessibility ); ?>
							</p>
						<?php endif; ?>

						<h3 class="rw-detail-section-title"><?php esc_html_e( 'Message', 'restwell-retreats' ); ?></h3>
						<p class="rw-prose-block rw-prose-block--message">
							<?php echo esc_html( $row->message ); ?>
						</p>

						<p class="rw-submitted-meta">
							<?php
							/* translators: %s: formatted date */
							printf(
								esc_html__( 'Submitted %s', 'restwell-retreats' ),
								esc_html( date_i18n( 'j F Y \a\t H:i', strtotime( $row->submitted_at ) ) )
							);
							?>
						</p>

					</div><!-- .inside -->
				</div><!-- .postbox -->
			</div>

			<!-- ── Right: status, notes, actions ────────────────────────── -->
			<div class="rw-detail-layout__sidebar">
				<!-- Status + follow-up form -->
				<form method="post" action="">
					<?php wp_nonce_field( 'restwell_crm_action', 'rw_crm_nonce' ); ?>
					<input type="hidden" name="rw_enquiry_id" value="<?php echo esc_attr( $row->id ); ?>">

					<div class="postbox">
						<div class="postbox-header">
							<h2 class="hndle"><span><?php esc_html_e( 'Status', 'restwell-retreats' ); ?></span></h2>
						</div>
						<div class="inside">
							<label class="screen-reader-text" for="rw-status-select"><?php esc_html_e( 'Status', 'restwell-retreats' ); ?></label>
							<select name="rw_status" id="rw-status-select" class="rw-sidebar-field">
								<?php foreach ( $statuses as $slug => $info ) : ?>
									<option value="<?php echo esc_attr( $slug ); ?>" <?php selected( $row->status, $slug ); ?>>
										<?php echo esc_html( $info['label'] ); ?>
									</option>
								<?php endforeach; ?>
							</select>

							<!-- Status timestamps -->
							<?php
						$ts_fields = array(
							'contacted_at'  => __( 'Contacted', 'restwell-retreats' ),
							'qualified_at'  => __( 'Qualified', 'restwell-retreats' ),
							'booked_at'     => __( 'Booked', 'restwell-retreats' ),
							'closed_at'     => __( 'Closed', 'restwell-retreats' ),
						);
							foreach ( $ts_fields as $col => $label ) :
								if ( ! empty( $row->$col ) ) :
							?>
							<p class="rw-ts-line">
								<?php
								printf(
									/* translators: 1: status label, 2: formatted date */
									esc_html__( '%1$s: %2$s', 'restwell-retreats' ),
									esc_html( $label ),
									esc_html( date_i18n( 'j M Y, H:i', strtotime( $row->$col ) ) )
								);
								?>
							</p>
							<?php
								endif;
							endforeach;
							?>

							<hr class="rw-divider-compact" />

							<label for="rw-follow-up" class="rw-sidebar-label rw-sidebar-label--tight">
								<?php esc_html_e( 'Follow-up date', 'restwell-retreats' ); ?>
							</label>
							<input
								type="datetime-local"
								id="rw-follow-up"
								name="rw_follow_up"
								value="<?php echo esc_attr( $follow_up_value ); ?>"
								class="rw-sidebar-field"
							/>
							<p class="description rw-description-tiny">
								<?php esc_html_e( 'Appears on the dashboard when due.', 'restwell-retreats' ); ?>
							</p>
						</div>
					</div>

					<div class="postbox">
						<div class="postbox-header">
							<h2 class="hndle"><span><?php esc_html_e( 'Staff Notes', 'restwell-retreats' ); ?></span></h2>
						</div>
						<div class="inside">
							<label class="screen-reader-text" for="rw-staff-notes"><?php esc_html_e( 'Staff notes', 'restwell-retreats' ); ?></label>
							<textarea name="rw_notes" id="rw-staff-notes" rows="5"
							          class="rw-sidebar-field"
							          placeholder="<?php esc_attr_e( 'Pinned summary (not visible to the enquirer).', 'restwell-retreats' ); ?>"
							><?php echo esc_textarea( $row->staff_notes ); ?></textarea>
						</div>
					</div>

					<input type="submit" class="button button-primary button-large rw-btn-block"
					       value="<?php esc_attr_e( 'Save Changes', 'restwell-retreats' ); ?>">

				</form>

				<!-- Activity log (append-only notes) -->
				<div class="postbox">
					<div class="postbox-header">
						<h2 class="hndle"><span><?php esc_html_e( 'Activity Log', 'restwell-retreats' ); ?></span></h2>
					</div>
					<div class="inside rw-activity-inside">

						<?php if ( ! empty( $notes ) ) : ?>
							<div class="rw-activity-list">
								<?php foreach ( $notes as $note ) :
									$author = get_userdata( (int) $note->created_by );
									$author_name = $author ? $author->display_name : __( 'Staff', 'restwell-retreats' );
									$initial     = mb_strtoupper( mb_substr( $author_name, 0, 1 ) );
								?>
								<div class="rw-activity-row">
									<div class="rw-activity-avatar" aria-hidden="true">
										<?php echo esc_html( $initial ); ?>
									</div>
									<div class="rw-activity-body">
										<div class="rw-activity-meta">
											<strong><?php echo esc_html( $author_name ); ?></strong>
											&middot; <?php echo esc_html( date_i18n( 'j M Y, H:i', strtotime( $note->created_at ) ) ); ?>
										</div>
										<div class="rw-activity-bubble">
											<?php echo esc_html( $note->note ); ?>
										</div>
									</div>
								</div>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>

						<!-- Add note form -->
						<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="rw-add-note-form">
							<?php wp_nonce_field( 'restwell_crm_add_note' ); ?>
							<input type="hidden" name="action" value="restwell_crm_add_note" />
							<input type="hidden" name="rw_enquiry_id" value="<?php echo esc_attr( $row->id ); ?>" />
							<label class="screen-reader-text" for="rw-new-note-<?php echo esc_attr( $row->id ); ?>">
								<?php esc_html_e( 'Add a note', 'restwell-retreats' ); ?>
							</label>
							<textarea
								id="rw-new-note-<?php echo esc_attr( $row->id ); ?>"
								name="rw_note_text"
								rows="3"
								placeholder="<?php esc_attr_e( 'Add a note…', 'restwell-retreats' ); ?>"
							></textarea>
							<input type="submit" class="button button-secondary" value="<?php esc_attr_e( 'Add note', 'restwell-retreats' ); ?>" />
						</form>

					</div>
				</div><!-- .postbox activity log -->

				<!-- Quick-contact buttons (outside form so they don't submit) -->
				<a href="<?php echo esc_url( $mailto ); ?>" class="button button-large rw-btn-block">
					&#9993; <?php esc_html_e( 'Reply by Email', 'restwell-retreats' ); ?>
				</a>
				<?php if ( $row->phone ) : ?>
					<a href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', $row->phone ) ); ?>"
					   class="button button-large rw-btn-block">
						&#128222; <?php echo esc_html( $row->phone ); ?>
					</a>
				<?php endif; ?>

			<?php if ( 'booked' === $row->status ) : ?>
				<a href="<?php echo esc_url( $promote_url ); ?>"
				   class="button button-primary button-large rw-btn-block">
					&#10133; <?php esc_html_e( 'Add to Guest Guide', 'restwell-retreats' ); ?>
				</a>
			<?php endif; ?>

			<?php if ( 'closed' === $row->status && function_exists( 'restwell_email_post_stay' ) ) : ?>
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="rw-post-stay-form">
					<?php wp_nonce_field( 'restwell_crm_send_post_stay_' . $row->id ); ?>
					<input type="hidden" name="action" value="restwell_crm_send_post_stay" />
					<input type="hidden" name="rw_enquiry_id" value="<?php echo esc_attr( $row->id ); ?>" />
					<button type="submit" class="button button-large rw-btn-block"
					        onclick="return confirm('<?php esc_attr_e( 'Send post-stay email to this guest?', 'restwell-retreats' ); ?>');">
						&#9993; <?php esc_html_e( 'Send Post-Stay Email', 'restwell-retreats' ); ?>
					</button>
				</form>
			<?php endif; ?>

			</div><!-- right column -->

		</div><!-- grid -->
	</div><!-- .wrap -->
	<?php
}
