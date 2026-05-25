<?php
/**
 * Plugin Name: Restwell CRM
 * Description: Enquiry CRM, form handling, transactional emails, Mailchimp sync, and stale-lead reminders for Restwell Retreats.
 * Version: 1.0.0
 * Author: Restwell Retreats
 * Requires at least: 6.0
 * Requires PHP: 8.0
 *
 * @package Restwell_CRM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( defined( 'RESTWELL_CRM_VERSION' ) ) {
	return;
}

define( 'RESTWELL_CRM_VERSION', '1.0.0' );
define( 'RESTWELL_CRM_PLUGIN_FILE', __FILE__ );
define( 'RESTWELL_CRM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

/**
 * Base URI for theme assets used by branded emails (fonts live in the active theme).
 *
 * @return string
 */
function restwell_crm_theme_asset_uri(): string {
	if ( function_exists( 'get_template_directory_uri' ) ) {
		$uri = get_template_directory_uri();
		if ( is_string( $uri ) && '' !== $uri ) {
			return $uri;
		}
	}
	return '';
}

/**
 * Load CRM modules in dependency order (matches former theme functions.php sequence).
 */
function restwell_crm_load_modules(): void {
	$dir = RESTWELL_CRM_PLUGIN_DIR;
	$files = array(
		'form-notify.php',
		'emails.php',
		'mailchimp.php',
		'crm.php',
		'crm-reminders.php',
		'enquire-handler.php',
	);
	foreach ( $files as $file ) {
		require_once $dir . $file;
	}
}
restwell_crm_load_modules();
