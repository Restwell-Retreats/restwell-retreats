<?php
/**
 * Content-Security-Policy (Report-Only) for the public front end.
 *
 * Run in report-only for at least a week; watch the browser console and optional
 * report-uri endpoint before enabling enforcement via restwell_enable_csp_enforce.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Per-request CSP nonce (base64). Generated once per request when CSP is active.
 *
 * @return string Empty when CSP report-only is disabled.
 */
function restwell_get_csp_nonce() {
	static $nonce = null;

	if ( null === $nonce ) {
		$nonce = '';
		if ( restwell_csp_report_only_enabled() ) {
			$nonce = rtrim( strtr( base64_encode( random_bytes( 18 ) ), '+/', '-_' ), '=' );
		}
	}

	return $nonce;
}

/**
 * HTML attribute fragment for executable inline scripts (nonce="…").
 *
 * @return string Space-prefixed attribute or empty string.
 */
function restwell_csp_script_nonce_attr() {
	$nonce = restwell_get_csp_nonce();
	if ( '' === $nonce ) {
		return '';
	}
	return ' nonce="' . esc_attr( $nonce ) . '"';
}

/**
 * Whether CSP Report-Only should be sent on front-end HTTPS responses.
 *
 * Disable with: add_filter( 'restwell_enable_csp_report_only', '__return_false' );
 *
 * @return bool
 */
function restwell_csp_report_only_enabled() {
	if ( is_admin() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return false;
	}
	return (bool) apply_filters( 'restwell_enable_csp_report_only', true );
}

/**
 * Build the CSP directive list (report-only or enforce).
 *
 * @return string[] Directive strings without joining semicolons.
 */
function restwell_build_csp_directives() {
	$nonce = restwell_get_csp_nonce();
	$script_src = array(
		"'self'",
		'https://www.googletagmanager.com',
		'https://tracker.metricool.com',
	);
	if ( '' !== $nonce ) {
		$script_src[] = "'nonce-" . $nonce . "'";
	}

	$connect_src = array(
		"'self'",
		'https://www.google-analytics.com',
		'https://analytics.google.com',
		'https://region1.google-analytics.com',
		'https://www.googletagmanager.com',
		'https://tracker.metricool.com',
	);

	$directives = array(
		"default-src 'self'",
		'script-src ' . implode( ' ', $script_src ),
		"style-src 'self' 'unsafe-inline'",
		"img-src 'self' data: https:",
		"font-src 'self'",
		'connect-src ' . implode( ' ', $connect_src ),
		"frame-ancestors 'none'",
		"base-uri 'self'",
		"form-action 'self'",
		'object-src \'none\'',
	);

	$report_uri = apply_filters( 'restwell_csp_report_uri', '' );
	if ( is_string( $report_uri ) && '' !== trim( $report_uri ) ) {
		$directives[] = 'report-uri ' . esc_url_raw( trim( $report_uri ) );
	}

	/**
	 * Adjust CSP directives before the header is sent.
	 *
	 * @param string[] $directives Directive strings.
	 */
	return (array) apply_filters( 'restwell_csp_directives', $directives );
}

/**
 * Send Content-Security-Policy-Report-Only (or enforced when opted in).
 */
function restwell_send_content_security_policy() {
	if ( ! is_ssl() || ! restwell_csp_report_only_enabled() ) {
		return;
	}

	// Ensure nonce exists for this request.
	restwell_get_csp_nonce();

	$value = implode( '; ', restwell_build_csp_directives() );
	$header_name = 'Content-Security-Policy-Report-Only';

	if ( apply_filters( 'restwell_enable_csp_enforce', false ) ) {
		$header_name = 'Content-Security-Policy';
	}

	header( $header_name . ': ' . $value );
}
add_action( 'send_headers', 'restwell_send_content_security_policy', 11 );
