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
 * Ensure a published page exists at /privacy-policy/.
 *
 * WordPress core auto-creates a default "Privacy Policy" page on every fresh
 * install and leaves it as a draft (post ID 3 in a clean database). A draft
 * page has no public permalink, so footer/nav links to it silently fall back
 * to the `?page_id=` query-string format and 404 for signed-out visitors.
 * This publishes that page (or creates one) so the link always resolves.
 *
 * Runs on theme activation (after_switch_theme) and on init as a safety net,
 * since Playground/staging environments can seed content after activation.
 */
function restwell_ensure_privacy_policy_page_exists() {
	if ( get_option( 'restwell_privacy_page_published_v1', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'privacy-policy', OBJECT, 'page' );

	if ( $page ) {
		if ( 'publish' !== $page->post_status ) {
			wp_update_post(
				array(
					'ID'          => $page->ID,
					'post_status' => 'publish',
				)
			);
		}
		if ( (int) get_option( 'wp_page_for_privacy_policy', 0 ) !== (int) $page->ID ) {
			update_option( 'wp_page_for_privacy_policy', (int) $page->ID );
		}
		update_option( 'restwell_privacy_page_published_v1', '1' );
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
		update_option( 'restwell_privacy_page_published_v1', '1' );
	}
}
add_action( 'after_switch_theme', 'restwell_ensure_privacy_policy_page_exists' );
add_action( 'admin_init', 'restwell_ensure_privacy_policy_page_exists' );
