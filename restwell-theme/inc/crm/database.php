<?php
/**
 * CRM: custom table creation and schema migrations.
 *
 * @package Restwell_CRM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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

