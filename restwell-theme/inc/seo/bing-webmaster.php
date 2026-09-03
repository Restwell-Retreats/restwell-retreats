<?php
/**
 * Bing Webmaster REST (JSON) client.
 *
 * SOAP and POX were retired 31 August 2026. Restwell only calls
 * https://ssl.bing.com/webmaster/api.svc/json/{Operation}
 *
 * @package Restwell_Retreats
 * @see https://www.bing.com/webmasters/help/soap-pox-api-deprecation-s0appox01
 * @see https://learn.microsoft.com/en-us/bingwebmaster/api-protocols
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * JSON REST base. Do not use /soap or /pox.
 */
const RESTWELL_BING_WEBMASTER_JSON_BASE = 'https://ssl.bing.com/webmaster/api.svc/json/';

/**
 * Sanitize a Bing Webmaster API key (user-level, not the msvalidate.01 token).
 *
 * @param mixed $key Raw key.
 * @return string
 */
function restwell_bing_webmaster_sanitize_api_key( $key ) {
	$key = is_string( $key ) ? $key : '';
	$clean = preg_replace( '/[^0-9A-Za-z]/', '', $key );
	return is_string( $clean ) ? $clean : '';
}

/**
 * API key from wp-config, environment, or non-autoloaded option.
 *
 * @return string
 */
function restwell_bing_webmaster_api_key() {
	$key = '';
	if ( defined( 'RESTWELL_BING_WEBMASTER_API_KEY' ) ) {
		$key = (string) RESTWELL_BING_WEBMASTER_API_KEY;
	}
	if ( '' === $key ) {
		$key = (string) get_option( 'restwell_bing_webmaster_api_key', '' );
	}
	if ( '' === $key ) {
		$env = getenv( 'RESTWELL_BING_WEBMASTER_API_KEY' );
		$key = is_string( $env ) ? $env : '';
	}
	return restwell_bing_webmaster_sanitize_api_key( $key );
}

/**
 * Whether a Bing Webmaster API key is available.
 *
 * @return bool
 */
function restwell_bing_webmaster_is_configured() {
	return restwell_bing_webmaster_api_key() !== '';
}

/**
 * Build a JSON REST URL. Operation names are letters only (GetUserSites, SubmitUrlBatch).
 *
 * @param string               $operation Method name.
 * @param array<string,string> $query     Extra query args (siteUrl, etc). apikey is appended.
 * @return string
 */
function restwell_bing_webmaster_build_url( $operation, $query = array() ) {
	$operation = preg_replace( '/[^A-Za-z]/', '', (string) $operation );
	$url       = RESTWELL_BING_WEBMASTER_JSON_BASE . $operation;
	$params    = array();
	if ( is_array( $query ) ) {
		foreach ( $query as $name => $value ) {
			$name = preg_replace( '/[^A-Za-z]/', '', (string) $name );
			if ( $name === '' || 'apikey' === strtolower( $name ) ) {
				continue;
			}
			$params[ $name ] = (string) $value;
		}
	}
	$params['apikey'] = restwell_bing_webmaster_api_key();
	return $url . '?' . http_build_query( $params, '', '&', PHP_QUERY_RFC3986 );
}

/**
 * Unwrap WCF JSON `{ "d": ... }` and ignore `__type` metadata.
 *
 * @param mixed $decoded Decoded JSON.
 * @return mixed
 */
function restwell_bing_webmaster_unwrap_payload( $decoded ) {
	if ( ! is_array( $decoded ) ) {
		return $decoded;
	}
	if ( array_key_exists( 'd', $decoded ) ) {
		$decoded = $decoded['d'];
	}
	if ( is_array( $decoded ) && isset( $decoded['results'] ) && is_array( $decoded['results'] ) ) {
		return $decoded['results'];
	}
	return $decoded;
}

/**
 * Site URLs from GetUserSites payload.
 *
 * @param mixed $payload Unwrapped payload.
 * @return string[]
 */
function restwell_bing_webmaster_extract_site_urls( $payload ) {
	$urls = array();
	if ( is_array( $payload ) && isset( $payload['Url'] ) ) {
		$payload = array( $payload );
	}
	if ( ! is_array( $payload ) ) {
		return $urls;
	}
	foreach ( $payload as $row ) {
		if ( is_string( $row ) && $row !== '' ) {
			$urls[] = $row;
			continue;
		}
		if ( ! is_array( $row ) ) {
			continue;
		}
		if ( ! empty( $row['Url'] ) && is_string( $row['Url'] ) ) {
			$urls[] = $row['Url'];
		} elseif ( ! empty( $row['url'] ) && is_string( $row['url'] ) ) {
			$urls[] = $row['url'];
		}
	}
	return array_values( array_unique( $urls ) );
}

/**
 * Origin URL with trailing slash (Bing’s usual siteUrl form).
 *
 * @param string $url Raw URL.
 * @return string
 */
function restwell_bing_webmaster_normalize_site_url( $url ) {
	$url   = trim( (string) $url );
	$parts = restwell_bing_webmaster_parse_url( $url );
	if ( ! is_array( $parts ) || empty( $parts['host'] ) ) {
		return '';
	}
	$scheme = isset( $parts['scheme'] ) ? strtolower( (string) $parts['scheme'] ) : 'https';
	if ( 'http' !== $scheme && 'https' !== $scheme ) {
		$scheme = 'https';
	}
	$host = strtolower( (string) $parts['host'] );
	$path = isset( $parts['path'] ) ? (string) $parts['path'] : '/';
	if ( $path === '' || $path === '/' ) {
		return $scheme . '://' . $host . '/';
	}
	return $scheme . '://' . $host . rtrim( $path, '/' ) . '/';
}

/**
 * Parse a URL (wp_parse_url in WordPress, parse_url in unit tests).
 *
 * @param string $url URL.
 * @return array<string,mixed>|false
 */
function restwell_bing_webmaster_parse_url( $url ) {
	if ( function_exists( 'wp_parse_url' ) ) {
		return wp_parse_url( $url );
	}
	return parse_url( $url );
}

/**
 * Host without a leading www.
 *
 * @param string $host Host.
 * @return string
 */
function restwell_bing_webmaster_bare_host( $host ) {
	$host = strtolower( (string) $host );
	if ( strpos( $host, 'www.' ) === 0 ) {
		return substr( $host, 4 );
	}
	return $host;
}

/**
 * Pick the Bing-verified site URL that matches this WordPress home URL.
 *
 * @param string   $home      home_url().
 * @param string[] $site_urls Verified site URLs from Bing (use their spelling).
 * @return string Empty if none match.
 */
function restwell_bing_webmaster_match_verified_site( $home, $site_urls ) {
	$home_n = restwell_bing_webmaster_normalize_site_url( $home );
	if ( $home_n === '' || ! is_array( $site_urls ) ) {
		return '';
	}
	$home_parts = restwell_bing_webmaster_parse_url( $home_n );
	$home_host  = ( is_array( $home_parts ) && isset( $home_parts['host'] ) )
		? restwell_bing_webmaster_bare_host( (string) $home_parts['host'] )
		: '';

	foreach ( $site_urls as $candidate ) {
		if ( restwell_bing_webmaster_normalize_site_url( $candidate ) === $home_n ) {
			return $candidate;
		}
	}

	foreach ( $site_urls as $candidate ) {
		$cand_n     = restwell_bing_webmaster_normalize_site_url( $candidate );
		$cand_parts = restwell_bing_webmaster_parse_url( $cand_n );
		$cand_host  = ( is_array( $cand_parts ) && isset( $cand_parts['host'] ) )
			? restwell_bing_webmaster_bare_host( (string) $cand_parts['host'] )
			: '';
		if ( $home_host !== '' && $cand_host === $home_host ) {
			return $candidate;
		}
	}

	return '';
}

/**
 * JSON-encode a REST body.
 *
 * @param array<string,mixed> $data Data.
 * @return string
 */
function restwell_bing_webmaster_json_encode( $data ) {
	if ( function_exists( 'wp_json_encode' ) ) {
		$json = wp_json_encode( $data );
		return is_string( $json ) ? $json : '{}';
	}
	$json = json_encode( $data );
	return is_string( $json ) ? $json : '{}';
}

/**
 * Call one JSON REST operation. Never logs the full URL (it contains the key).
 *
 * @param string               $operation Method name.
 * @param array<string,string> $query     GET params besides apikey.
 * @param array<string,mixed>|null $body  POST body, or null for GET.
 * @return mixed|WP_Error Unwrapped payload.
 */
function restwell_bing_webmaster_request( $operation, $query = array(), $body = null ) {
	if ( ! restwell_bing_webmaster_is_configured() ) {
		return new WP_Error(
			'bing_webmaster_no_key',
			__( 'Bing Webmaster API key is not set.', 'restwell-retreats' )
		);
	}

	$url  = restwell_bing_webmaster_build_url( $operation, $query );
	$args = array(
		'timeout'     => 15,
		'redirection' => 0,
		'headers'     => array(
			'Accept'       => 'application/json',
			'Content-Type' => 'application/json; charset=utf-8',
		),
	);

	if ( null === $body ) {
		$response = wp_remote_get( $url, $args );
	} else {
		$args['body'] = restwell_bing_webmaster_json_encode( $body );
		$response     = wp_remote_post( $url, $args );
	}

	if ( is_wp_error( $response ) ) {
		return new WP_Error(
			'bing_webmaster_http',
			sprintf(
				/* translators: %s: transport error */
				__( 'Bing Webmaster request failed: %s', 'restwell-retreats' ),
				$response->get_error_message()
			)
		);
	}

	$code = (int) wp_remote_retrieve_response_code( $response );
	$raw  = (string) wp_remote_retrieve_body( $response );
	$data = json_decode( $raw, true );

	if ( ! is_array( $data ) ) {
		return new WP_Error(
			'bing_webmaster_parse',
			__( 'Bing Webmaster returned a non-JSON response.', 'restwell-retreats' )
		);
	}

	if ( isset( $data['ErrorCode'] ) || ( isset( $data['Message'] ) && ! array_key_exists( 'd', $data ) ) ) {
		$message = isset( $data['Message'] ) ? (string) $data['Message'] : 'Error';
		return new WP_Error(
			'bing_webmaster_api',
			sprintf(
				/* translators: 1: HTTP status, 2: API message */
				__( 'Bing Webmaster API error (%1$d): %2$s', 'restwell-retreats' ),
				$code,
				$message
			)
		);
	}

	if ( $code < 200 || $code >= 300 ) {
		return new WP_Error(
			'bing_webmaster_status',
			sprintf(
				/* translators: %d: HTTP status */
				__( 'Bing Webmaster HTTP %d.', 'restwell-retreats' ),
				$code
			)
		);
	}

	return restwell_bing_webmaster_unwrap_payload( $data );
}

/**
 * Last connection / sitemap status (no secrets).
 *
 * @return array{ok:bool,key_ok:bool,site_url:string,checked_at:int,message:string}
 */
function restwell_bing_webmaster_get_status() {
	$stored = get_option( 'restwell_bing_webmaster_status', array() );
	$out    = array(
		'ok'         => false,
		'key_ok'     => false,
		'site_url'   => '',
		'checked_at' => 0,
		'message'    => '',
	);
	if ( ! is_array( $stored ) ) {
		return $out;
	}
	$out['ok']         = ! empty( $stored['ok'] );
	$out['key_ok']     = ! empty( $stored['key_ok'] );
	$out['site_url']   = isset( $stored['site_url'] ) ? (string) $stored['site_url'] : '';
	$out['checked_at'] = isset( $stored['checked_at'] ) ? absint( $stored['checked_at'] ) : 0;
	$out['message']    = isset( $stored['message'] ) ? (string) $stored['message'] : '';
	return $out;
}

/**
 * Persist status without autoload.
 *
 * @param array{ok:bool,key_ok:bool,site_url:string,checked_at:int,message:string} $status Status.
 */
function restwell_bing_webmaster_store_status( $status ) {
	update_option( 'restwell_bing_webmaster_status', $status, false );
}

/**
 * Explain a valid key on a host Bing does not list (typical on restwell.local).
 *
 * @param string   $home      home_url().
 * @param string[] $site_urls Bing properties.
 * @return string
 */
function restwell_bing_webmaster_host_mismatch_message( $home, $site_urls ) {
	$listed = implode( ', ', array_slice( (array) $site_urls, 0, 3 ) );
	return sprintf(
		/* translators: 1: this WordPress home URL, 2: Bing property URL(s) */
		__( 'API key is valid. This WordPress site (%1$s) is not a Bing property (%2$s), so sitemap and URL pings are skipped here.', 'restwell-retreats' ),
		restwell_bing_webmaster_normalize_site_url( $home ),
		$listed
	);
}

/**
 * GetUserSites, match this home URL, submit wp-sitemap.xml.
 *
 * @param bool $submit_sitemap Whether to SubmitFeed after a match.
 * @return array{ok:bool,key_ok:bool,site_url:string,checked_at:int,message:string}
 */
function restwell_bing_webmaster_refresh_status( $submit_sitemap = true ) {
	$now = time();
	if ( ! restwell_bing_webmaster_is_configured() ) {
		$status = array(
			'ok'         => false,
			'key_ok'     => false,
			'site_url'   => '',
			'checked_at' => $now,
			'message'    => __( 'No Bing Webmaster API key.', 'restwell-retreats' ),
		);
		restwell_bing_webmaster_store_status( $status );
		return $status;
	}

	$payload = restwell_bing_webmaster_request( 'GetUserSites' );
	if ( is_wp_error( $payload ) ) {
		$status = array(
			'ok'         => false,
			'key_ok'     => false,
			'site_url'   => '',
			'checked_at' => $now,
			'message'    => $payload->get_error_message(),
		);
		restwell_bing_webmaster_store_status( $status );
		return $status;
	}

	$sites    = restwell_bing_webmaster_extract_site_urls( $payload );
	$site_url = restwell_bing_webmaster_match_verified_site( home_url( '/' ), $sites );
	if ( $site_url === '' ) {
		$status = array(
			'ok'         => false,
			'key_ok'     => true,
			'site_url'   => '',
			'checked_at' => $now,
			'message'    => restwell_bing_webmaster_host_mismatch_message( home_url( '/' ), $sites ),
		);
		restwell_bing_webmaster_store_status( $status );
		return $status;
	}

	$message = sprintf(
		/* translators: %s: verified site URL */
		__( 'Connected to %s via Bing REST JSON.', 'restwell-retreats' ),
		$site_url
	);

	if ( $submit_sitemap ) {
		$feed = restwell_bing_webmaster_submit_sitemap( $site_url );
		if ( is_wp_error( $feed ) ) {
			$message = sprintf(
				/* translators: 1: site URL, 2: error */
				__( 'Connected to %1$s, but sitemap submit failed: %2$s', 'restwell-retreats' ),
				$site_url,
				$feed->get_error_message()
			);
		} else {
			$message = sprintf(
				/* translators: %s: site URL */
				__( 'Connected to %s. XML sitemap submitted to Bing.', 'restwell-retreats' ),
				$site_url
			);
		}
	}

	$status = array(
		'ok'         => true,
		'key_ok'     => true,
		'site_url'   => $site_url,
		'checked_at' => $now,
		'message'    => $message,
	);
	restwell_bing_webmaster_store_status( $status );
	return $status;
}

/**
 * Submit the WordPress sitemap index as a Bing feed.
 *
 * @param string $site_url Optional verified site URL.
 * @return true|WP_Error
 */
function restwell_bing_webmaster_submit_sitemap( $site_url = '' ) {
	if ( $site_url === '' ) {
		$site_url = restwell_bing_webmaster_get_status()['site_url'];
	}
	if ( $site_url === '' ) {
		return new WP_Error( 'bing_webmaster_no_site', __( 'No matched Bing site URL.', 'restwell-retreats' ) );
	}

	$result = restwell_bing_webmaster_request(
		'SubmitFeed',
		array(),
		array(
			'siteUrl' => $site_url,
			'feedUrl' => home_url( '/wp-sitemap.xml' ),
		)
	);

	if ( is_wp_error( $result ) ) {
		return $result;
	}
	return true;
}

/**
 * Notify Bing that a URL changed (JSON SubmitUrl).
 *
 * @param string $url Absolute URL.
 * @return true|WP_Error
 */
function restwell_bing_webmaster_submit_url( $url ) {
	$url = function_exists( 'esc_url_raw' ) ? esc_url_raw( $url ) : $url;
	if ( $url === '' || ! restwell_bing_webmaster_is_configured() ) {
		return new WP_Error( 'bing_webmaster_skip', __( 'URL submit skipped.', 'restwell-retreats' ) );
	}

	$status   = restwell_bing_webmaster_get_status();
	$site_url = $status['site_url'];
	if ( $site_url === '' || ! $status['ok'] ) {
		$refreshed = restwell_bing_webmaster_refresh_status( false );
		$site_url  = $refreshed['site_url'];
		if ( $site_url === '' ) {
			return new WP_Error( 'bing_webmaster_no_site', __( 'No matched Bing site URL.', 'restwell-retreats' ) );
		}
	}

	$throttle_key = 'restwell_bing_url_' . md5( $url );
	if ( function_exists( 'get_transient' ) && false !== get_transient( $throttle_key ) ) {
		return true;
	}

	$result = restwell_bing_webmaster_request(
		'SubmitUrl',
		array(),
		array(
			'siteUrl' => $site_url,
			'url'     => $url,
		)
	);

	if ( is_wp_error( $result ) ) {
		return $result;
	}

	if ( function_exists( 'set_transient' ) ) {
		$ttl = defined( 'HOUR_IN_SECONDS' ) ? HOUR_IN_SECONDS : 3600;
		set_transient( $throttle_key, 1, $ttl );
	}

	return true;
}

/**
 * Ping Bing when a public page or post is published or updated while live.
 *
 * @param string  $new_status New status.
 * @param string  $old_status Old status.
 * @param WP_Post $post       Post.
 */
function restwell_bing_webmaster_on_status( $new_status, $old_status, $post ) {
	unset( $old_status );
	if ( 'publish' !== $new_status || ! restwell_bing_webmaster_is_configured() ) {
		return;
	}
	if ( ! $post instanceof WP_Post ) {
		return;
	}
	if ( ! in_array( $post->post_type, array( 'post', 'page' ), true ) ) {
		return;
	}
	if ( function_exists( 'get_option' ) && '0' === (string) get_option( 'blog_public' ) ) {
		return;
	}
	if ( get_post_meta( $post->ID, 'meta_noindex', true ) ) {
		return;
	}

	$permalink = get_permalink( $post );
	if ( ! is_string( $permalink ) || $permalink === '' ) {
		return;
	}

	restwell_bing_webmaster_submit_url( $permalink );
}

/**
 * Daily sitemap resubmit.
 */
function restwell_bing_webmaster_daily() {
	if ( ! restwell_bing_webmaster_is_configured() ) {
		return;
	}
	restwell_bing_webmaster_refresh_status( true );
}

/**
 * Schedule the daily Bing REST sync.
 */
function restwell_bing_webmaster_schedule_cron() {
	if ( ! function_exists( 'wp_next_scheduled' ) || ! function_exists( 'wp_schedule_event' ) ) {
		return;
	}
	if ( ! restwell_bing_webmaster_is_configured() ) {
		return;
	}
	if ( ! wp_next_scheduled( 'restwell_bing_webmaster_daily' ) ) {
		$delay = defined( 'HOUR_IN_SECONDS' ) ? HOUR_IN_SECONDS : 3600;
		wp_schedule_event( time() + $delay, 'daily', 'restwell_bing_webmaster_daily' );
	}
}

add_action( 'init', 'restwell_bing_webmaster_schedule_cron' );
add_action( 'restwell_bing_webmaster_daily', 'restwell_bing_webmaster_daily' );
add_action( 'transition_post_status', 'restwell_bing_webmaster_on_status', 20, 3 );
