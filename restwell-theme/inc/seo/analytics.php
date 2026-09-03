<?php
/**
 * SEO: GA4, Metricool, Bing verification, and analytics loader enqueue.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function restwell_get_analytics_load_mode() {
	$mode = (string) get_option( 'restwell_analytics_load_mode', 'consent_gated' );
	$allowed = array( 'head', 'footer_deferred', 'consent_gated' );
	return in_array( $mode, $allowed, true ) ? $mode : 'consent_gated';
}

/**
 * Sanitized GA4 measurement ID or empty.
 *
 * @return string
 */
function restwell_analytics_ga4_measurement_id_sanitized() {
	$mid = (string) get_option( 'restwell_ga4_measurement_id', '' );
	$mid = preg_replace( '/[^G0-9A-Za-z\-]/', '', $mid );
	if ( $mid === '' || strpos( $mid, 'G-' ) !== 0 ) {
		return '';
	}
	return $mid;
}

/**
 * Sanitized Metricool hash or empty.
 *
 * @return string
 */
function restwell_analytics_metricool_hash_sanitized() {
	$hash = (string) get_option( 'restwell_metricool_hash', '' );
	$hash = preg_replace( '/[^0-9A-Za-z]/', '', strtolower( $hash ) );
	return preg_match( '/^[a-f0-9]{32}$/i', $hash ) ? $hash : '';
}

/**
 * Whether analytics scripts are routed through the footer loader (defer / CMP).
 *
 * @return bool
 */
function restwell_analytics_use_footer_loader() {
	if ( 'head' === restwell_get_analytics_load_mode() ) {
		return false;
	}
	return restwell_analytics_ga4_measurement_id_sanitized() !== '' || restwell_analytics_metricool_hash_sanitized() !== '';
}

/**
 * Consent Mode defaults before gtag loads (consent_gated + GA4 only).
 */
function restwell_output_ga4_consent_default() {
	return;
}
add_action( 'wp_head', 'restwell_output_ga4_consent_default', 1 );

/**
 * Enqueue deferred / consent-gated analytics loader (GA4 + Metricool).
 */
function restwell_enqueue_analytics_loader() {
	if ( is_admin() || ! restwell_analytics_use_footer_loader() ) {
		return;
	}

	$theme_uri = get_template_directory_uri();
	$use_min   = ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG );
	$loader_js = $use_min ? '/assets/js/analytics-loader.min.js' : '/assets/js/analytics-loader.js';
	$loader_ver = function_exists( 'restwell_theme_asset_version' )
		? restwell_theme_asset_version( $loader_js )
		: (string) wp_get_theme()->get( 'Version' );

	wp_enqueue_script(
		'restwell-analytics-loader',
		$theme_uri . $loader_js,
		array(),
		$loader_ver,
		true
	);

	$mode = restwell_get_analytics_load_mode();
	wp_localize_script(
		'restwell-analytics-loader',
		'restwellAnalytics',
		array(
			'loadMode'      => 'footer_deferred' === $mode ? 'footer_deferred' : 'consent_gated',
			'consentGated'  => ( 'consent_gated' === $mode ),
			'gaId'          => restwell_analytics_ga4_measurement_id_sanitized(),
			'metricoolHash' => restwell_analytics_metricool_hash_sanitized(),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'restwell_enqueue_analytics_loader', 25 );

function restwell_enqueue_head_analytics() {
	if ( is_admin() || restwell_analytics_use_footer_loader() ) {
		return;
	}

	$ga_id          = restwell_analytics_ga4_measurement_id_sanitized();
	$metricool_hash = restwell_analytics_metricool_hash_sanitized();
	if ( $ga_id === '' && $metricool_hash === '' ) {
		return;
	}

	$version = (string) wp_get_theme()->get( 'Version' );
	if ( 'consent_gated' === restwell_get_analytics_load_mode() && $ga_id !== '' ) {
		wp_enqueue_script( 'restwell-analytics-consent', get_template_directory_uri() . '/assets/js/analytics-consent.js', array(), $version, false );
	}
	wp_enqueue_script( 'restwell-analytics-head', get_template_directory_uri() . '/assets/js/analytics-head.js', array(), $version, false );
	wp_localize_script(
		'restwell-analytics-head',
		'restwellAnalytics',
		array(
			'gaId'          => $ga_id,
			'metricoolHash' => $metricool_hash,
		)
	);
}
add_action( 'wp_enqueue_scripts', 'restwell_enqueue_head_analytics', 25 );

/**
 * Output Google Analytics 4 gtag when measurement ID is set (head mode only).
 */
function restwell_output_ga4() {
	return;
}
add_action( 'wp_head', 'restwell_output_ga4', 20 );

/**
 * Output Metricool tracking snippet when a hash is set (head mode only).
 */
function restwell_output_metricool_tracker() {
	return;
}
add_action( 'wp_head', 'restwell_output_metricool_tracker', 20 );

/**
 * Bing Webmaster Tools verification meta tag.
 */
function restwell_output_bing_verification() {
	$token = (string) get_option( 'restwell_bing_verification', '' );
	$token = preg_replace( '/[^0-9A-Za-z]/', '', $token );
	if ( $token === '' ) {
		return;
	}
	echo '<meta name="msvalidate.01" content="' . esc_attr( $token ) . '">' . "\n";
}
add_action( 'wp_head', 'restwell_output_bing_verification', 1 );

// ---------------------------------------------------------------------------
// 2. OG + Twitter Card meta tags
// ---------------------------------------------------------------------------
// Moved to inc/seo-social-meta.php to keep this file focused on canonical + JSON-LD.

// ---------------------------------------------------------------------------
// 3. JSON-LD structured data
// ---------------------------------------------------------------------------

/**
 * Stable @id for the Organization entity (matches GBP / registered address).
 *
 * @return string Absolute URL with fragment.
 */
