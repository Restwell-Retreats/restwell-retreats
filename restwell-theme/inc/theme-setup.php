<?php
/**
 * Theme setup: WP Admin page to create pages and seed front page meta.
 *
 * Loads focused modules in dependency order (no behaviour change).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/seo-content-seed.php';

const RESTWELL_SETUP_NONCE_ACTION = 'restwell_theme_setup_run';
const RESTWELL_SETUP_NONCE_NAME   = 'restwell_theme_setup_nonce';

$restwell_theme_setup_modules = array(
	'meta-helpers.php',
	'page-defaults.php',
	'admin.php',
	'logos.php',
	'runner.php',
	'legal-content.php',
	'migrations.php',
);
foreach ( $restwell_theme_setup_modules as $restwell_theme_setup_module ) {
	require_once __DIR__ . '/theme-setup/' . $restwell_theme_setup_module;
}
