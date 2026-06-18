<?php
/**
 * CRM: canonical enquiry status transition logic.
 *
 * @package Restwell_CRM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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

