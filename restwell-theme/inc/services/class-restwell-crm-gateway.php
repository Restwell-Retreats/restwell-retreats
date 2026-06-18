<?php
/**
 * CRM gateway — theme-side adapter to mu-plugin persistence and lifecycle ops.
 *
 * Boundary: templates, form handlers, and admin hooks should call this class
 * (via restwell_service_crm_gateway()) instead of invoking CRM table helpers
 * directly. Implementation delegates to existing restwell_crm_* functions.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adapter for CRM write paths and enquiry lifecycle transitions.
 */
final class Restwell_Crm_Gateway {

	/**
	 * Persist an enquiry submission (duplicate guard included).
	 *
	 * @param array<string, mixed> $data Sanitised CRM row fields.
	 * @return array{id: int|false, is_duplicate: bool}
	 */
	public function save_enquiry( array $data ): array {
		if ( ! function_exists( 'restwell_crm_save_enquiry' ) ) {
			return array(
				'id'           => false,
				'is_duplicate' => false,
			);
		}
		return restwell_crm_save_enquiry( $data );
	}

	/**
	 * Persist an FAQ question submission.
	 *
	 * @param array<string, mixed> $data Sanitised FAQ row fields.
	 * @return int|false Inserted row ID.
	 */
	public function save_faq_submission( array $data ) {
		if ( ! function_exists( 'restwell_faq_save_submission' ) ) {
			return false;
		}
		return restwell_faq_save_submission( $data );
	}

	/**
	 * Mark FAQ staff notification as sent.
	 *
	 * @param int $id Submission row ID.
	 */
	public function mark_faq_notify_sent( int $id ): void {
		if ( function_exists( 'restwell_faq_mark_notify_sent' ) ) {
			restwell_faq_mark_notify_sent( $id );
		}
	}

	/**
	 * Append an activity note to an enquiry.
	 *
	 * @param int    $enquiry_id Enquiry row ID.
	 * @param string $note       Note text (caller sanitises).
	 */
	public function add_enquiry_note( int $enquiry_id, string $note ): void {
		if ( function_exists( 'restwell_crm_add_note' ) ) {
			restwell_crm_add_note( $enquiry_id, $note );
		}
	}

	/**
	 * Apply a canonical status transition for one enquiry.
	 *
	 * @param int    $id         Enquiry ID.
	 * @param string $new_status Target status key.
	 * @param string $context    Caller context: detail|ajax|bulk.
	 * @return bool
	 */
	public function apply_status_change( int $id, string $new_status, string $context = 'detail' ): bool {
		if ( ! function_exists( 'restwell_crm_apply_status_change' ) ) {
			return false;
		}
		return restwell_crm_apply_status_change( $id, $new_status, $context );
	}

	/**
	 * Flag a FAQ row when Mailchimp sync failed after opt-in.
	 *
	 * @param int $row_id FAQ submission ID.
	 */
	public function mark_faq_marketing_sync_failed( int $row_id ): void {
		if ( $row_id < 1 ) {
			return;
		}
		global $wpdb;
		if ( ! defined( 'RESTWELL_FAQ_TABLE' ) ) {
			return;
		}
		$faq_table = $wpdb->prefix . RESTWELL_FAQ_TABLE;
		$wpdb->update(
			$faq_table,
			array( 'marketing_sync_failed' => 1 ),
			array( 'id' => $row_id ),
			array( '%d' ),
			array( '%d' )
		);
	}
}
