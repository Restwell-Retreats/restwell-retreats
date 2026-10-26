<?php
/**
 * Site hardening the theme carries itself (26 Oct 2026 review of live):
 * the admin login name was public through author pages and oEmbed data,
 * XML-RPC still listed its methods, the feed named the WordPress version,
 * and nothing limited failed logins. The file-editor lock also lived only in
 * a must-use plugin outside the theme zip.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Theme and plugin file editors stay off outside local and development sites,
// so a stolen admin login can't be used to edit PHP from wp-admin. The
// must-use plugin restwell-hardening.php does the same when it's installed.
if ( ! defined( 'DISALLOW_FILE_EDIT' ) && ! in_array( function_exists( 'wp_get_environment_type' ) ? wp_get_environment_type() : 'production', array( 'local', 'development' ), true ) ) {
	define( 'DISALLOW_FILE_EDIT', true );
}

/**
 * Turn author archives and `?author=N` lookups into a 404.
 *
 * The site has no author pages, and WordPress answers `?author=1` with a
 * redirect to /author/{login}/, which hands out the admin login name.
 *
 * @param array $query_vars Parsed query vars.
 * @return array
 */
function restwell_block_author_enumeration( $query_vars ) {
	if ( is_admin() || ! is_array( $query_vars ) ) {
		return $query_vars;
	}
	if ( isset( $query_vars['author'] ) || isset( $query_vars['author_name'] ) ) {
		return array( 'error' => '404' );
	}
	return $query_vars;
}
add_filter( 'request', 'restwell_block_author_enumeration' );

/**
 * Keep the author's login name out of oEmbed data.
 *
 * @param array $data oEmbed response data.
 * @return array
 */
function restwell_oembed_hide_author( $data ) {
	if ( is_array( $data ) ) {
		unset( $data['author_name'], $data['author_url'] );
	}
	return $data;
}
add_filter( 'oembed_response_data', 'restwell_oembed_hide_author' );

// No WordPress version in feeds or anywhere else the generator tag appears.
add_filter( 'the_generator', '__return_empty_string' );

// XML-RPC is off (functions.php); answer with no methods at all, and stop
// advertising the endpoint in the page head and response headers.
add_filter( 'xmlrpc_methods', '__return_empty_array' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );

/**
 * Drop the X-Pingback header that points at xmlrpc.php.
 *
 * @param array $headers Response headers.
 * @return array
 */
function restwell_remove_pingback_header( $headers ) {
	unset( $headers['X-Pingback'] );
	return $headers;
}
add_filter( 'wp_headers', 'restwell_remove_pingback_header' );

/**
 * Transient key for failed logins from the current connection.
 *
 * @return string
 */
function restwell_login_fail_key() {
	$ip = function_exists( 'restwell_form_client_ip' )
		? restwell_form_client_ip()
		: ( isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'unknown' );
	return 'restwell_login_fail_' . md5( $ip );
}

/**
 * Refuse logins from a connection with 10 failures in the last 15 minutes.
 *
 * Runs after the password check, so a locked-out connection is refused even
 * with the right password until the 15 minutes pass.
 *
 * @param WP_User|WP_Error|null $user Result so far.
 * @return WP_User|WP_Error|null
 */
function restwell_login_throttle( $user ) {
	if ( (int) get_transient( restwell_login_fail_key() ) >= 10 ) {
		return new WP_Error( 'restwell_login_locked', __( 'Too many failed logins from your connection. Wait 15 minutes, then try again.', 'restwell-retreats' ) );
	}
	return $user;
}
add_filter( 'authenticate', 'restwell_login_throttle', 30 );

/**
 * Count a failed login against the connection.
 */
function restwell_login_count_failure() {
	$key = restwell_login_fail_key();
	set_transient( $key, (int) get_transient( $key ) + 1, 15 * MINUTE_IN_SECONDS );
}
add_action( 'wp_login_failed', 'restwell_login_count_failure' );

/**
 * Clear the count after a successful login.
 */
function restwell_login_clear_failures() {
	delete_transient( restwell_login_fail_key() );
}
add_action( 'wp_login', 'restwell_login_clear_failures' );

/**
 * One login error for every failure, so the form doesn't confirm which
 * usernames exist. The lockout message still shows.
 *
 * @param string $message Error message HTML.
 * @return string
 */
function restwell_generic_login_error( $message ) {
	if ( false !== strpos( (string) $message, __( 'Too many failed logins', 'restwell-retreats' ) ) ) {
		return $message;
	}
	return esc_html__( 'Those login details didn’t work. Check them and try again.', 'restwell-retreats' );
}
add_filter( 'login_errors', 'restwell_generic_login_error' );
