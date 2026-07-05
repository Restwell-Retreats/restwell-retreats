<?php
/**
 * CRM: Restwell admin menu registration.
 *
 * @package Restwell_CRM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
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
