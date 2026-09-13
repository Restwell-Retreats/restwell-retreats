<?php
/**
 * CRM module loader (theme-side).
 *
 * Business logic modules live here and load with the theme.
 *
 * @package Restwell_CRM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$restwell_crm_modules = array(
	'capabilities.php',
	'database.php',
	'persistence.php',
	'admin-menu.php',
	'availability-admin.php',
	'status-helpers.php',
	'notes.php',
	'handlers.php',
	'status-transition.php',
	'mailing-list.php',
	'retention.php',
	'privacy.php',
	'dashboard.php',
	'enquiries.php',
	'form-notify.php',
	'emails.php',
	'email-staff.php',
	'mailchimp.php',
	'crm-reminders.php',
	'enquire-handler.php',
);

foreach ( $restwell_crm_modules as $restwell_crm_module ) {
	require_once __DIR__ . '/' . $restwell_crm_module;
}
