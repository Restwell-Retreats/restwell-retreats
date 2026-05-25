<?php
/**
 * Privacy policy page bootstrap on theme activation.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ensure a published shell page exists at /privacy-policy/ when missing.
 *
 * Runs on theme activation (after_switch_theme), not on every request.
 */
function restwell_ensure_privacy_policy_page_exists() {
	if ( get_page_by_path( 'privacy-policy', OBJECT, 'page' ) ) {
		return;
	}
	$inserted = wp_insert_post(
		array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => __( 'Privacy Policy', 'restwell-retreats' ),
			'post_name'    => 'privacy-policy',
			'post_content' => '',
		),
		true
	);
	if ( ! is_wp_error( $inserted ) && $inserted > 0 ) {
		update_option( 'wp_page_for_privacy_policy', (int) $inserted );
	}
}
add_action( 'after_switch_theme', 'restwell_ensure_privacy_policy_page_exists' );
