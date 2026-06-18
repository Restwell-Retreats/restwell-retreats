<?php
/**
 * CRM: enquiry activity log read/write.
 *
 * @package Restwell_CRM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
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

