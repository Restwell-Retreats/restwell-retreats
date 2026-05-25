<?php
/**
 * Template redirect handlers (301 consolidations, canonical host, legacy slugs).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 301 redirect legacy /contact/ to the enquire page (single contact surface).
 */
function restwell_redirect_contact_to_enquire() {
	if ( is_admin() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}

	$target = restwell_nav_resolve_page_url( 'enquire' );

	if ( is_page( 'contact' ) ) {
		wp_safe_redirect( $target, 301 );
		exit;
	}

	// When no WP page exists, /contact/ may 404 — still consolidate to enquire.
	global $wp;
	if ( is_404() && isset( $wp->request ) && is_string( $wp->request ) && preg_match( '#^contact/?$#', $wp->request ) ) {
		wp_safe_redirect( $target, 301 );
		exit;
	}
}
add_action( 'template_redirect', 'restwell_redirect_contact_to_enquire', 20 );

/**
 * 301 redirect legacy carers guide slug to canonical post URL (theme + seed use carers-respite-holiday-guide).
 */
function restwell_redirect_legacy_carers_guide_slug() {
	if ( is_admin() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	global $wp;
	if ( ! isset( $wp->request ) || ! is_string( $wp->request ) ) {
		return;
	}
	if ( preg_match( '#^carers-holiday-respite-funding/?$#', $wp->request ) ) {
		wp_safe_redirect( home_url( '/carers-respite-holiday-guide/' ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'restwell_redirect_legacy_carers_guide_slug', 21 );

/**
 * 301 redirect any ?page_id=3 request (orphaned WP sample content) to the homepage.
 * The link source is stored in the WP database (menu/post content) and cannot be removed
 * from the theme, but this redirect prevents the 404 from appearing in crawlers.
 */
function restwell_redirect_page_id_orphan() {
	if ( is_admin() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$pid = isset( $_GET['page_id'] ) ? absint( $_GET['page_id'] ) : 0;
	if ( 3 === $pid ) {
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'restwell_redirect_page_id_orphan', 5 );

/**
 * 301 redirect the defunct /accessible-beaches-kent-coast/ slug to the canonical slug.
 * Theme templates were updated to use the correct slug; this covers any external/cached links.
 */
function restwell_redirect_accessible_beaches_old_slug() {
	if ( is_admin() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	global $wp;
	if ( ! isset( $wp->request ) || ! is_string( $wp->request ) ) {
		return;
	}
	if ( preg_match( '#^accessible-beaches-kent-coast/?$#', $wp->request ) ) {
		wp_safe_redirect( home_url( '/accessible-beaches-coastal-walks-kent/' ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'restwell_redirect_accessible_beaches_old_slug', 22 );

/**
 * Enforce the canonical host (www vs apex) by 301-redirecting the alternate variant.
 *
 * Reads the WP home URL to determine the canonical host. If the current request uses
 * the other variant (e.g. www when home is apex, or apex when home is www) it issues
 * a 301 to the canonical host, preserving path and query string.
 *
 * Note: a server-level redirect (nginx/Apache) is preferred for performance; this
 * acts as a PHP-level safety net when the server configuration cannot be changed.
 */
function restwell_redirect_to_canonical_host() {
	if ( is_admin() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}

	$home    = (string) home_url( '/' );
	$home_parts = wp_parse_url( $home );
	$canonical_host = isset( $home_parts['host'] ) ? strtolower( $home_parts['host'] ) : '';
	if ( $canonical_host === '' ) {
		return;
	}

	// Detect the current request host.
	$current_host = isset( $_SERVER['HTTP_HOST'] ) ? strtolower( sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) ) : '';
	if ( $current_host === '' || $current_host === $canonical_host ) {
		return; // already on the canonical host.
	}

	// Only act when the difference is purely www vs no-www.
	$canonical_no_www = preg_replace( '/^www./', '', $canonical_host );
	$current_no_www   = preg_replace( '/^www./', '', $current_host );
	if ( $canonical_no_www !== $current_no_www ) {
		return; // different domain altogether — don't touch.
	}

	$scheme  = ( isset( $_SERVER['HTTPS'] ) && 'off' !== $_SERVER['HTTPS'] ) ? 'https' : 'http';
	$request = isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : '/';
	// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	$redirect = $scheme . '://' . $canonical_host . $request;

	wp_redirect( esc_url_raw( $redirect ), 301 );
	exit;
}
add_action( 'template_redirect', 'restwell_redirect_to_canonical_host', 1 );

/**
 * Redirect legacy /privacy-policy/ to the configured privacy policy page when needed.
 *
 * Uses the queried privacy policy page ID instead of comparing URL strings (which could
 * mismatch scheme, trailing slashes, or subdirectory home URLs and cause endless 301s).
 */
function restwell_redirect_privacy_policy_to_configured_page() {
	if ( is_admin() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	$policy_page_id = (int) get_option( 'wp_page_for_privacy_policy', 0 );
	if ( $policy_page_id <= 0 ) {
		return;
	}

	// Already displaying the policy page — no redirect (avoids 301 loops vs string URL compares).
	if ( is_page( $policy_page_id ) ) {
		return;
	}

	$policy_permalink = get_permalink( $policy_page_id );
	if ( ! $policy_permalink ) {
		return;
	}

	global $wp;
	$is_privacy_request = is_page( 'privacy-policy' );
	if ( ! $is_privacy_request && isset( $wp->request ) && is_string( $wp->request ) ) {
		$is_privacy_request = preg_match( '#^privacy-policy/?$#', $wp->request ) === 1;
	}
	if ( ! $is_privacy_request ) {
		return;
	}

	wp_safe_redirect( $policy_permalink, 301 );
	exit;
}
add_action( 'template_redirect', 'restwell_redirect_privacy_policy_to_configured_page', 23 );

/**
 * Redirect public author archives to home to reduce user-enumeration surface.
 */
function restwell_redirect_author_archives() {
	if ( is_admin() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	if ( is_author() ) {
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'restwell_redirect_author_archives', 22 );
