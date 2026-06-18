<?php
/**
 * Enquiry service — orchestrates public enquiry persistence via the CRM gateway.
 *
 * Boundary: enquiry form handlers call this service for lead writes and automated
 * notes; email/redirect UX remains in the handler layer.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Public enquiry write operations.
 */
final class Restwell_Enquiry_Service {

	/**
	 * CRM gateway dependency.
	 *
	 * @var Restwell_Crm_Gateway
	 */
	private $gateway;

	/**
	 * @param Restwell_Crm_Gateway $gateway CRM adapter.
	 */
	public function __construct( Restwell_Crm_Gateway $gateway ) {
		$this->gateway = $gateway;
	}

	/**
	 * Persist a sanitised enquiry payload.
	 *
	 * @param array<string, mixed> $crm_data Row fields keyed for restwell_crm_save_enquiry().
	 * @return array{id: int|false, is_duplicate: bool}
	 */
	public function persist_lead( array $crm_data ): array {
		return $this->gateway->save_enquiry( $crm_data );
	}

	/**
	 * Record a duplicate-submit suppression note (no emails sent).
	 *
	 * @param int $enquiry_id Existing enquiry row ID.
	 */
	public function record_duplicate_submit( int $enquiry_id ): void {
		if ( $enquiry_id < 1 ) {
			return;
		}
		$this->gateway->add_enquiry_note(
			$enquiry_id,
			__( 'Automated note: duplicate submit suppressed (same email within 30 minutes). No emails sent.', 'restwell-retreats' )
		);
	}

	/**
	 * Record a Mailchimp sync failure after marketing opt-in.
	 *
	 * @param int $enquiry_id Enquiry row ID.
	 */
	public function record_marketing_sync_failure( int $enquiry_id ): void {
		if ( $enquiry_id < 1 ) {
			return;
		}
		$this->gateway->add_enquiry_note(
			$enquiry_id,
			__( 'Automated note: marketing opt-in was recorded, but Mailchimp sync failed. Please retry from CRM if needed.', 'restwell-retreats' )
		);
	}
}
