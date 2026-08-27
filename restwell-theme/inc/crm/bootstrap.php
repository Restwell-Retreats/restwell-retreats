<?php
/**
 * CRM module loader (theme-side).
 *
 * Business logic modules live here; the mu-plugin entry `crm.php` requires this
 * bootstrap so CRM code stays colocated with the theme in the monorepo.
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
	'status-helpers.php',
	'notes.php',
	'handlers.php',
	'status-transition.php',
	'mailing-list.php',
	'dashboard.php',
	'enquiries.php',
);

// Public form pipeline. In production the mu-plugin (wp-content/mu-plugins/
// restwell-crm) loads its own copies first; these theme copies are the fallback
// for theme-only installs (Local, Playground) so the enquiry form works there.
if ( ! defined( 'RESTWELL_CRM_VERSION' ) ) {
	$restwell_crm_modules[] = 'form-notify.php';
	$restwell_crm_modules[] = 'emails.php';
	$restwell_crm_modules[] = 'mailchimp.php';
	$restwell_crm_modules[] = 'crm-reminders.php';
	$restwell_crm_modules[] = 'enquire-handler.php';
}

foreach ( $restwell_crm_modules as $restwell_crm_module ) {
	require_once __DIR__ . '/' . $restwell_crm_module;
}
