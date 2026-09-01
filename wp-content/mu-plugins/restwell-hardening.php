<?php
/**
 * Plugin Name: Restwell hardening
 * Description: DISALLOW_FILE_EDIT on non-local environments. Do not enable on disposable Local boxes.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
	$restwell_env = function_exists( 'wp_get_environment_type' )
		? wp_get_environment_type()
		: ( defined( 'WP_ENVIRONMENT_TYPE' ) ? (string) WP_ENVIRONMENT_TYPE : 'production' );
	if ( ! in_array( $restwell_env, array( 'local', 'development' ), true ) ) {
		define( 'DISALLOW_FILE_EDIT', true );
	}
}
