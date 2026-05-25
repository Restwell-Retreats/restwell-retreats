<?php
/**
 * Mailchimp sync helpers for marketing opt-ins.
 *
 * @package Restwell_CRM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Read Mailchimp API key from constant or environment.
 *
 * @return string
 */
function restwell_mailchimp_api_key(): string {
	$key = '';
	if ( defined( 'RESTWELL_MAILCHIMP_API_KEY' ) ) {
		$key = (string) RESTWELL_MAILCHIMP_API_KEY;
	}
	if ( '' === $key ) {
		$key = (string) get_option( 'restwell_mailchimp_api_key', '' );
	}
	if ( '' === $key ) {
		$env = getenv( 'RESTWELL_MAILCHIMP_API_KEY' );
		$key = is_string( $env ) ? $env : '';
	}
	return trim( $key );
}

/**
 * Return Mailchimp audience/list ID.
 *
 * @return string
 */
function restwell_mailchimp_audience_id(): string {
	if ( defined( 'RESTWELL_MAILCHIMP_AUDIENCE_ID' ) ) {
		return sanitize_text_field( (string) RESTWELL_MAILCHIMP_AUDIENCE_ID );
	}
	return sanitize_text_field( (string) get_option( 'restwell_mailchimp_audience_id', '' ) );
}

/**
 * Return Mailchimp API server prefix (example: "us15").
 *
 * @return string
 */
function restwell_mailchimp_server_prefix(): string {
	$prefix = '';
	if ( defined( 'RESTWELL_MAILCHIMP_SERVER_PREFIX' ) ) {
		$prefix = sanitize_key( (string) RESTWELL_MAILCHIMP_SERVER_PREFIX );
	}
	if ( '' === $prefix ) {
		$prefix = sanitize_key( (string) get_option( 'restwell_mailchimp_server_prefix', '' ) );
	}
	if ( '' !== $prefix ) {
		return $prefix;
	}
	$key = restwell_mailchimp_api_key();
	if ( str_contains( $key, '-' ) ) {
		$parts = explode( '-', $key );
		return sanitize_key( (string) end( $parts ) );
	}
	return '';
}

/**
 * Whether Mailchimp sync is configured.
 *
 * @return bool
 */
function restwell_mailchimp_is_configured(): bool {
	return (
		'' !== restwell_mailchimp_api_key()
		&& '' !== restwell_mailchimp_audience_id()
		&& '' !== restwell_mailchimp_server_prefix()
	);
}

/**
 * Build member hash from email.
 *
 * @param string $email Email address.
 * @return string
 */
function restwell_mailchimp_member_hash( string $email ): string {
	return md5( strtolower( trim( $email ) ) );
}

/**
 * Send a request to Mailchimp v3 API.
 *
 * @param string     $method HTTP method.
 * @param string     $path   API path beginning with "/".
 * @param array|null $body   Optional request body.
 * @return array<string, mixed>
 */
function restwell_mailchimp_request( string $method, string $path, ?array $body = null ): array {
	$api_key = restwell_mailchimp_api_key();
	$server  = restwell_mailchimp_server_prefix();
	$url     = 'https://' . $server . '.api.mailchimp.com/3.0' . $path;

	$args = array(
		'method'  => strtoupper( $method ),
		'timeout' => 15,
		'headers' => array(
			'Authorization' => 'Basic ' . base64_encode( 'restwell:' . $api_key ),
			'Content-Type'  => 'application/json',
		),
	);
	if ( null !== $body ) {
		$args['body'] = wp_json_encode( $body );
	}

	$response = wp_remote_request( esc_url_raw( $url ), $args );
	if ( is_wp_error( $response ) ) {
		return array(
			'ok'      => false,
			'code'    => 0,
			'body'    => '',
			'message' => $response->get_error_message(),
		);
	}

	$code = (int) wp_remote_retrieve_response_code( $response );
	$resp = (string) wp_remote_retrieve_body( $response );
	return array(
		'ok'      => ( $code >= 200 && $code < 300 ),
		'code'    => $code,
		'body'    => $resp,
		'message' => '',
	);
}

/**
 * Add or update a marketing contact in Mailchimp and apply tags.
 *
 * @param string      $email  Email address.
 * @param string      $name   Full name.
 * @param string      $phone  Phone number.
 * @param string      $source Internal source label (e.g. "enquire", "faq").
 * @param string[]    $tags   Tag names to activate.
 * @return bool True when contact upsert succeeded.
 */
function restwell_mailchimp_upsert_marketing_contact( string $email, string $name = '', string $phone = '', string $source = '', array $tags = array() ): bool {
	if ( ! is_email( $email ) || ! restwell_mailchimp_is_configured() ) {
		return false;
	}

	$audience_id = restwell_mailchimp_audience_id();
	$hash        = restwell_mailchimp_member_hash( $email );

	$name  = trim( $name );
	$parts = preg_split( '/\s+/', $name );
	if ( ! is_array( $parts ) ) {
		$parts = array();
	}
	$fname = ! empty( $parts ) ? sanitize_text_field( (string) array_shift( $parts ) ) : '';
	$lname = ! empty( $parts ) ? sanitize_text_field( trim( implode( ' ', $parts ) ) ) : '';

	$merge_fields = array();
	if ( '' !== $fname ) {
		$merge_fields['FNAME'] = $fname;
	}
	if ( '' !== $lname ) {
		$merge_fields['LNAME'] = $lname;
	}

	$payload = array(
		'email_address' => sanitize_email( $email ),
		'status_if_new' => 'pending',
	);
	if ( ! empty( $merge_fields ) ) {
		$payload['merge_fields'] = $merge_fields;
	}

	$upsert = restwell_mailchimp_request(
		'PUT',
		'/lists/' . rawurlencode( $audience_id ) . '/members/' . rawurlencode( $hash ),
		$payload
	);

	if ( ! $upsert['ok'] ) {
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
			error_log( '[Restwell] Mailchimp upsert failed: code=' . (string) $upsert['code'] . ' body=' . (string) $upsert['body'] );
		}
		return false;
	}

	$tag_list = array_values(
		array_filter(
			array_map(
				static function ( $tag ): string {
					return sanitize_text_field( (string) $tag );
				},
				$tags
			)
		)
	);
	$tag_list[] = 'restwell';
	$tag_list[] = 'marketing-optin';
	if ( '' !== $source ) {
		$tag_list[] = sanitize_text_field( $source );
	}
	$tag_list = array_values( array_unique( $tag_list ) );

	if ( ! empty( $tag_list ) ) {
		$tag_payload = array(
			'tags' => array_map(
				static function ( string $tag ): array {
					return array(
						'name'   => $tag,
						'status' => 'active',
					);
				},
				$tag_list
			),
		);
		$tag_req     = restwell_mailchimp_request(
			'POST',
			'/lists/' . rawurlencode( $audience_id ) . '/members/' . rawurlencode( $hash ) . '/tags',
			$tag_payload
		);
		if ( ! $tag_req['ok'] && defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
			error_log( '[Restwell] Mailchimp tag update failed: code=' . (string) $tag_req['code'] . ' body=' . (string) $tag_req['body'] );
		}
	}

	return true;
}
