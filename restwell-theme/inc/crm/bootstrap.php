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
foreach ( $restwell_crm_modules as $restwell_crm_module ) {
	require_once __DIR__ . '/' . $restwell_crm_module;
}
