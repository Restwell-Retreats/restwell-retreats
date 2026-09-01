<?php
/**
 * First-party cookie consent (PECR): banner, preference cookie, script enqueue.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const RESTWELL_COOKIE_CONSENT_NAME    = 'restwell_cookie_consent';
const RESTWELL_COOKIE_CONSENT_VERSION = 1;
const RESTWELL_COOKIE_CONSENT_MAX_AGE = 15552000; // 180 days.

/**
 * Whether analytics should wait for the first-party cookie banner.
 *
 * @return bool
 */
function restwell_cookie_consent_is_gated(): bool {
	return function_exists( 'restwell_get_analytics_load_mode' )
		&& 'consent_gated' === restwell_get_analytics_load_mode();
}

/**
 * Parsed first-party consent cookie, or null when unset / invalid.
 *
 * @return array{v: int, analytics: bool}|null
 */
function restwell_get_cookie_consent_choice(): ?array {
	if ( ! isset( $_COOKIE[ RESTWELL_COOKIE_CONSENT_NAME ] ) ) { // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		return null;
	}
	$raw = wp_unslash( $_COOKIE[ RESTWELL_COOKIE_CONSENT_NAME ] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	if ( ! is_string( $raw ) || '' === $raw ) {
		return null;
	}
	$data = json_decode( $raw, true );
	if ( ! is_array( $data ) || ! array_key_exists( 'analytics', $data ) ) {
		return null;
	}
	return array(
		'v'         => isset( $data['v'] ) ? absint( $data['v'] ) : RESTWELL_COOKIE_CONSENT_VERSION,
		'analytics' => (bool) $data['analytics'],
	);
}

/**
 * Whether the visitor has already recorded a cookie choice.
 *
 * @return bool
 */
function restwell_cookie_consent_has_choice(): bool {
	return null !== restwell_get_cookie_consent_choice();
}

/**
 * Enqueue cookie-banner script on the public front end when consent-gated.
 */
function restwell_enqueue_cookie_consent_script(): void {
	if ( is_admin() || ! restwell_cookie_consent_is_gated() ) {
		return;
	}

	$theme_uri = get_template_directory_uri();
	$use_min   = ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG );
	$rel       = $use_min ? '/assets/js/cookie-consent.min.js' : '/assets/js/cookie-consent.js';
	if ( $use_min && ! is_readable( get_template_directory() . $rel ) ) {
		$rel = '/assets/js/cookie-consent.js';
	}

	wp_enqueue_script(
		'restwell-cookie-consent',
		$theme_uri . $rel,
		array(),
		function_exists( 'restwell_theme_asset_version' )
			? restwell_theme_asset_version( $rel )
			: (string) wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'restwell_enqueue_cookie_consent_script', 20 );

/**
 * Defer cookie-consent.js (same pattern as shared/main).
 *
 * @param string $tag    Script HTML.
 * @param string $handle Handle.
 * @param string $src    Src (unused).
 * @return string
 */
function restwell_defer_cookie_consent_script( $tag, $handle, $src ) {
	unset( $src );
	if ( 'restwell-cookie-consent' !== $handle ) {
		return $tag;
	}
	if ( false !== strpos( $tag, ' defer' ) ) {
		return $tag;
	}
	return str_replace( '<script ', '<script defer ', $tag );
}
add_filter( 'script_loader_tag', 'restwell_defer_cookie_consent_script', 10, 3 );
