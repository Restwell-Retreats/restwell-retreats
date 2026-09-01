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
 * Directory for the five public CRM modules (canonical copies live in the theme).
 *
 * @return string Trailing slash.
 */
function restwell_crm_public_module_dir(): string {
	if ( function_exists( 'get_template_directory' ) ) {
		$dir = get_template_directory() . '/inc/crm/';
		if ( is_dir( $dir ) ) {
			return $dir;
		}
	}
	return RESTWELL_CRM_PLUGIN_DIR;
}

/**
 * Load CRM modules in dependency order (matches former theme functions.php sequence).
 */
function restwell_crm_load_modules(): void {
	$theme_crm = restwell_crm_public_module_dir();
	$files     = array(
		$theme_crm . 'form-notify.php',
		$theme_crm . 'emails.php',
		$theme_crm . 'mailchimp.php',
		RESTWELL_CRM_PLUGIN_DIR . 'crm.php',
		$theme_crm . 'crm-reminders.php',
		$theme_crm . 'enquire-handler.php',
	);
	foreach ( $files as $path ) {
		if ( is_readable( $path ) ) {
			require_once $path;
		}
	}
}
restwell_crm_load_modules();
