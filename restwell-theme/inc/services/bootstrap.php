<?php
/**
 * Theme ops service layer bootstrap.
 *
 * Boundary: register CRM/enquiry service singletons for templates and hooks.
 * Business logic remains in inc/crm/* and mu-plugin handlers; services are the
 * stable entry surface for cross-layer calls from the theme. The events feed
 * (Whitstable guide "What's on") is registered here too.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/class-restwell-crm-gateway.php';
require_once __DIR__ . '/class-restwell-enquiry-service.php';
require_once __DIR__ . '/class-restwell-events-feed.php';

/**
 * Lazy service registry (single instance per request).
 */
final class Restwell_Services {

	/**
	 * @var Restwell_Crm_Gateway|null
	 */
	private static $crm_gateway = null;

	/**
	 * @var Restwell_Enquiry_Service|null
	 */
	private static $enquiry = null;

	/**
	 * @var Restwell_Events_Feed|null
	 */
	private static $events_feed = null;

	/**
	 * CRM persistence and lifecycle adapter.
	 *
	 * @return Restwell_Crm_Gateway
	 */
	public static function crm_gateway(): Restwell_Crm_Gateway {
		if ( null === self::$crm_gateway ) {
			self::$crm_gateway = new Restwell_Crm_Gateway();
		}
		return self::$crm_gateway;
	}

	/**
	 * Public enquiry write orchestration.
	 *
	 * @return Restwell_Enquiry_Service
	 */
	public static function enquiry(): Restwell_Enquiry_Service {
		if ( null === self::$enquiry ) {
			self::$enquiry = new Restwell_Enquiry_Service( self::crm_gateway() );
		}
		return self::$enquiry;
	}

	/**
	 * Upcoming events near the bungalow (Data Thistle).
	 *
	 * @return Restwell_Events_Feed
	 */
	public static function events_feed(): Restwell_Events_Feed {
		if ( null === self::$events_feed ) {
			self::$events_feed = new Restwell_Events_Feed();
		}
		return self::$events_feed;
	}
}

/**
 * @return Restwell_Crm_Gateway
 */
function restwell_service_crm_gateway(): Restwell_Crm_Gateway {
	return Restwell_Services::crm_gateway();
}

/**
 * @return Restwell_Enquiry_Service
 */
function restwell_service_enquiry(): Restwell_Enquiry_Service {
	return Restwell_Services::enquiry();
}

/**
 * @return Restwell_Events_Feed
 */
function restwell_service_events_feed(): Restwell_Events_Feed {
	return Restwell_Services::events_feed();
}

/**
 * Back-compat ops wrappers (route through gateway).
 *
 * @param array<string, mixed> $data Sanitised enquiry fields.
 * @return array{id: int|false, is_duplicate: bool}
 */
function restwell_crm_ops_save_enquiry( array $data ): array {
	return restwell_service_crm_gateway()->save_enquiry( $data );
}

/**
 * @param array<string, mixed> $data Sanitised FAQ fields.
 * @return int|false
 */
function restwell_crm_ops_save_faq_submission( array $data ) {
	return restwell_service_crm_gateway()->save_faq_submission( $data );
}

/**
 * @param int    $enquiry_id Enquiry ID.
 * @param string $new_status Status key.
 * @param string $context    detail|ajax|bulk.
 * @return bool
 */
function restwell_crm_ops_apply_status_change( int $enquiry_id, string $new_status, string $context = 'detail' ): bool {
	return restwell_service_crm_gateway()->apply_status_change( $enquiry_id, $new_status, $context );
}
