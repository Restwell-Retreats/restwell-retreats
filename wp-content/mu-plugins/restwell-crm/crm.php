<?php
/**
 * Restwell CRM: enquiry leads store and admin centre.
 *
 * Loads split modules from the active theme inc/crm/ directory (monorepo layout).
 *
 * @package Restwell_CRM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$restwell_crm_bootstrap = function_exists( 'get_template_directory' )
	? get_template_directory() . '/inc/crm/bootstrap.php'
	: '';

if ( ! $restwell_crm_bootstrap || ! is_readable( $restwell_crm_bootstrap ) ) {
	return;
}

require_once $restwell_crm_bootstrap;
