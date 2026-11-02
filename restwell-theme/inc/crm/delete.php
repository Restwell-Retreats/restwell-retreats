<?php
/**
 * CRM: delete enquiries for good.
 *
 * Deleting removes the enquiry row and its activity log. A linked Guest Guide
 * row is kept, but its enquiry link is cleared so it does not point at
 * nothing. Single deletes post here from the detail screen; bulk deletes run
 * from the list's bulk-action form (see restwell_crm_handle_bulk_status_post).
 *
 * @package Restwell_CRM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Turn posted enquiry IDs into a clean list of positive, unique integers.
 *
 * @param mixed $raw Posted value: one ID or an array of IDs.
 * @return array<int, int>
 */
function restwell_crm_sanitize_enquiry_ids( $raw ): array {
	$ids = array_map( 'absint', (array) $raw );
	$ids = array_filter(
		$ids,
		static function ( int $id ): bool {
			return $id > 0;
		}
	);
	return array_values( array_unique( $ids ) );
}

/**
 * Delete enquiries and their activity logs.
 *
 * @param array<int, int> $ids Enquiry IDs (already sanitised).
 * @return int Number of enquiry rows deleted.
 */
function restwell_crm_delete_enquiries( array $ids ): int {
	global $wpdb;
	$enquiries = $wpdb->prefix . RESTWELL_CRM_TABLE;
	$notes     = $wpdb->prefix . RESTWELL_NOTES_TABLE;
	$guests    = $wpdb->prefix . RESTWELL_GUESTS_TABLE;

	$deleted = 0;
	foreach ( $ids as $id ) {
		$removed = $wpdb->delete( $enquiries, array( 'id' => $id ), array( '%d' ) );
		if ( false === $removed ) {
			continue;
		}
		$deleted += (int) $removed;
		$wpdb->delete( $notes, array( 'enquiry_id' => $id ), array( '%d' ) );
		$wpdb->update(
			$guests,
			array( 'enquiry_id' => null ),
			array( 'enquiry_id' => $id ),
			array( '%d' ),
			array( '%d' )
		);
	}
	return $deleted;
}

/**
 * The notice shown on the enquiries list after a delete.
 *
 * @param int $count Number of enquiries deleted.
 * @return string
 */
function restwell_crm_deleted_notice_text( int $count ): string {
	if ( $count < 1 ) {
		return __( 'Nothing was deleted. The enquiry may have been deleted already.', 'restwell-retreats' );
	}
	if ( 1 === $count ) {
		return __( 'Enquiry deleted.', 'restwell-retreats' );
	}
	return sprintf(
		/* translators: %d: number of enquiries deleted. */
		_n( '%d enquiry deleted.', '%d enquiries deleted.', $count, 'restwell-retreats' ),
		$count
	);
}

/**
 * Redirect to the enquiries list with the deleted count.
 *
 * @param int $count Number of enquiries deleted.
 */
function restwell_crm_redirect_after_delete( int $count ): void {
	wp_safe_redirect(
		add_query_arg(
			array(
				'page'    => 'restwell-enquiries',
				'deleted' => $count,
			),
			admin_url( 'admin.php' )
		)
	);
	exit;
}

/**
 * Delete one enquiry from its detail screen.
 */
function restwell_crm_handle_delete_enquiry(): void {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'Insufficient permissions.', 'restwell-retreats' ) );
	}

	$id = absint( $_POST['rw_enquiry_id'] ?? 0 );
	check_admin_referer( 'restwell_crm_delete_enquiry_' . $id );

	restwell_crm_redirect_after_delete( restwell_crm_delete_enquiries( restwell_crm_sanitize_enquiry_ids( $id ) ) );
}
add_action( 'admin_post_restwell_crm_delete_enquiry', 'restwell_crm_handle_delete_enquiry' );
