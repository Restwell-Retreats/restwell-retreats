<?php
/**
 * CRM: enquiry source (where an enquiry came from).
 *
 * assets/js/enquiry-source.js fills hidden enq_src_* fields on both enquiry
 * forms (the /enquire/ page and the Pricing calendar dialog). Everything posted
 * is untrusted: these helpers clean each value, then work out the readable
 * Source label here on the server. A label is never accepted from the browser.
 *
 * Rows saved before CRM DB 3.11, and enquiries sent without the script running,
 * have an empty source_label and show as "Unknown".
 *
 * @package Restwell_CRM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Hidden form field name for each stored source column.
 *
 * enq_src_v is the capture flag: the script sets it to 1 only when it ran.
 *
 * @return array<string, string> Column => POST field name.
 */
function restwell_enquiry_source_post_fields(): array {
	return array(
		'utm_source'      => 'enq_src_utm_source',
		'utm_medium'      => 'enq_src_utm_medium',
		'utm_campaign'    => 'enq_src_utm_campaign',
		'utm_content'     => 'enq_src_utm_content',
		'utm_term'        => 'enq_src_utm_term',
		'has_fbclid'      => 'enq_src_fbclid',
		'has_gclid'       => 'enq_src_gclid',
		'landing_path'    => 'enq_src_landing',
		'referrer_domain' => 'enq_src_referrer',
	);
}

/**
 * Empty source record (what legacy rows and script-less enquiries store).
 *
 * @return array<string, string|int>
 */
function restwell_enquiry_source_empty(): array {
	return array(
		'utm_source'      => '',
		'utm_medium'      => '',
		'utm_campaign'    => '',
		'utm_content'     => '',
		'utm_term'        => '',
		'has_fbclid'      => 0,
		'has_gclid'       => 0,
		'landing_path'    => '',
		'referrer_domain' => '',
		'source_label'    => '',
	);
}

/**
 * Cut a string to a maximum number of characters (multibyte-safe).
 *
 * @param string $value Value.
 * @param int    $max   Maximum characters.
 * @return string
 */
function restwell_enquiry_source_truncate( string $value, int $max ): string {
	if ( function_exists( 'mb_substr' ) ) {
		return (string) mb_substr( $value, 0, $max, 'UTF-8' );
	}
	return substr( $value, 0, $max );
}

/**
 * Clean one UTM value.
 *
 * Strips tags and control characters, and strips leading = + - @ so the value
 * can never start a spreadsheet formula in the CSV export.
 *
 * @param string $raw       Posted value.
 * @param int    $max       Maximum characters (matches the column).
 * @param bool   $lowercase True for utm_source / utm_medium.
 * @return string
 */
function restwell_enquiry_source_clean_text( string $raw, int $max, bool $lowercase = false ): string {
	$value = (string) preg_replace( '/[\x00-\x1F\x7F]+/u', ' ', $raw );
	$value = sanitize_text_field( $value );
	$value = (string) preg_replace( '/\s+/u', ' ', $value );
	$value = ltrim( $value, "=+-@ \t" );
	if ( $lowercase ) {
		$value = function_exists( 'mb_strtolower' ) ? mb_strtolower( $value, 'UTF-8' ) : strtolower( $value );
	}
	return trim( restwell_enquiry_source_truncate( $value, $max ) );
}

/**
 * Clean the landing page path: path only, no query string or fragment.
 *
 * @param string $raw Posted value (expected to start with /).
 * @return string Path, or empty when it does not look like one.
 */
function restwell_enquiry_source_clean_path( string $raw ): string {
	$raw = trim( $raw );
	if ( '' === $raw || '/' !== $raw[0] || 0 === strpos( $raw, '//' ) ) {
		return '';
	}
	$path = (string) wp_parse_url( 'https://example.invalid' . $raw, PHP_URL_PATH );
	if ( '' === $path || ! preg_match( '#^/[A-Za-z0-9\-._~/%]*$#', $path ) ) {
		return '';
	}
	return restwell_enquiry_source_truncate( $path, 255 );
}

/**
 * This site's own host, lowercased and without www.
 *
 * @return string
 */
function restwell_enquiry_source_own_host(): string {
	$host = strtolower( (string) wp_parse_url( home_url( '/' ), PHP_URL_HOST ) );
	return (string) preg_replace( '/^www\./', '', $host );
}

/**
 * Clean the referrer domain. Our own domain counts as no referrer.
 *
 * @param string $raw Posted host name.
 * @return string Lowercase host without www., or empty.
 */
function restwell_enquiry_source_clean_domain( string $raw ): string {
	$host = strtolower( trim( $raw ) );
	$host = (string) preg_replace( '/^www\./', '', $host );
	if ( strlen( $host ) > 190 ) {
		return '';
	}
	$label = '[a-z0-9](?:[a-z0-9-]*[a-z0-9])?';
	if ( ! preg_match( '/^' . $label . '(?:\.' . $label . ')+$/', $host ) ) {
		return '';
	}
	if ( restwell_enquiry_source_own_host() === $host ) {
		return '';
	}
	return $host;
}

/**
 * True when $host is one of $domains or a subdomain of one.
 *
 * @param string   $host    Clean host.
 * @param string[] $domains Domains to match.
 * @return bool
 */
function restwell_enquiry_source_host_matches( string $host, array $domains ): bool {
	if ( '' === $host ) {
		return false;
	}
	foreach ( $domains as $domain ) {
		if ( $host === $domain || substr( $host, -strlen( '.' . $domain ) ) === '.' . $domain ) {
			return true;
		}
	}
	return false;
}

/**
 * True for a Google search referrer (any country domain, or the Android app).
 *
 * Gmail on the web (mail.google.com) is not search, so it stays a referral.
 *
 * @param string $host Clean host.
 * @return bool
 */
function restwell_enquiry_source_is_google_search( string $host ): bool {
	if ( 'com.google.android.googlequicksearchbox' === $host ) {
		return true;
	}
	if ( 0 === strpos( $host, 'mail.' ) ) {
		return false;
	}
	return 1 === preg_match( '/(^|\.)google\.(com|[a-z]{2,3}|com?\.[a-z]{2})$/', $host );
}

/**
 * Readable Source label from cleaned values. First matching rule wins.
 *
 * @param array<string, string|int> $src Cleaned source values (see restwell_enquiry_source_empty()).
 * @return string
 */
function restwell_enquiry_source_label( array $src ): string {
	$source   = (string) ( $src['utm_source'] ?? '' );
	$medium   = (string) ( $src['utm_medium'] ?? '' );
	$referrer = (string) ( $src['referrer_domain'] ?? '' );
	$fbclid   = ! empty( $src['has_fbclid'] );
	$gclid    = ! empty( $src['has_gclid'] );

	$paid_mediums   = array( 'paid_social', 'paid-social', 'paidsocial', 'social_paid', 'paid', 'cpc', 'ppc', 'cpm', 'ads', 'ad', 'paid_search', 'display', 'sponsored' );
	$meta_sources   = array( 'facebook', 'fb', 'instagram', 'ig', 'meta', 'messenger' );
	$meta_domains   = array( 'facebook.com', 'fb.com', 'fb.me', 'instagram.com', 'messenger.com', 'threads.net' );
	$google_sources = array( 'google', 'googleads', 'google_ads', 'adwords' );
	$search_sources = array( 'bing', 'duckduckgo', 'yahoo', 'ecosia' );
	$search_domains = array( 'bing.com', 'duckduckgo.com', 'yahoo.com', 'yahoo.co.uk', 'ecosia.org' );
	$is_paid        = in_array( $medium, $paid_mediums, true );

	if ( $gclid || ( in_array( $source, $google_sources, true ) && $is_paid ) ) {
		return 'Google ads';
	}
	if ( in_array( $source, $meta_sources, true ) && $is_paid ) {
		return 'Meta ad';
	}
	// fbclid is also added to clicks on ordinary posts, so on its own it means organic.
	if ( in_array( $source, $meta_sources, true ) || restwell_enquiry_source_host_matches( $referrer, $meta_domains ) || $fbclid ) {
		return 'Facebook or Instagram organic';
	}
	if ( 'email' === $medium ) {
		return 'Email';
	}
	if ( in_array( $source, $google_sources, true ) || restwell_enquiry_source_is_google_search( $referrer ) ) {
		return 'Google organic';
	}
	if ( in_array( $source, $search_sources, true ) || restwell_enquiry_source_host_matches( $referrer, $search_domains ) ) {
		return 'Other search';
	}
	if ( '' !== $source ) {
		return 'Other campaign (' . restwell_enquiry_source_truncate( $source, 60 ) . ')';
	}
	if ( '' !== $referrer ) {
		return 'Referral (' . restwell_enquiry_source_truncate( $referrer, 60 ) . ')';
	}
	return 'Direct';
}

/**
 * Clean the posted enq_src_* fields into a record ready to store.
 *
 * Without the capture flag the script did not run, so nothing is kept and the
 * enquiry shows as "Unknown" rather than a guessed "Direct".
 *
 * @param array<string, mixed> $post Unslashed POST data.
 * @return array<string, string|int> Column => value, including source_label.
 */
function restwell_enquiry_source_from_post( array $post ): array {
	$src = restwell_enquiry_source_empty();
	if ( ! isset( $post['enq_src_v'] ) || '1' !== (string) $post['enq_src_v'] ) {
		return $src;
	}
	$fields = restwell_enquiry_source_post_fields();
	$raw    = static function ( string $column ) use ( $post, $fields ): string {
		$value = $post[ $fields[ $column ] ] ?? '';
		return is_scalar( $value ) ? (string) $value : '';
	};

	$src['utm_source']      = restwell_enquiry_source_clean_text( $raw( 'utm_source' ), 100, true );
	$src['utm_medium']      = restwell_enquiry_source_clean_text( $raw( 'utm_medium' ), 100, true );
	$src['utm_campaign']    = restwell_enquiry_source_clean_text( $raw( 'utm_campaign' ), 150 );
	$src['utm_content']     = restwell_enquiry_source_clean_text( $raw( 'utm_content' ), 150 );
	$src['utm_term']        = restwell_enquiry_source_clean_text( $raw( 'utm_term' ), 150 );
	$src['has_fbclid']      = '1' === $raw( 'has_fbclid' ) ? 1 : 0;
	$src['has_gclid']       = '1' === $raw( 'has_gclid' ) ? 1 : 0;
	$src['landing_path']    = restwell_enquiry_source_clean_path( $raw( 'landing_path' ) );
	$src['referrer_domain'] = restwell_enquiry_source_clean_domain( $raw( 'referrer_domain' ) );
	$src['source_label']    = restwell_enquiry_source_label( $src );
	return $src;
}

/**
 * Rows for the "Source" section of the single enquiry view.
 *
 * The label is always shown; the details only when they hold something.
 *
 * @param object $row Enquiry row.
 * @return array<string, string> Plain-text label => plain-text value.
 */
function restwell_enquiry_source_detail_fields( $row ): array {
	$get    = static function ( string $key ) use ( $row ): string {
		return isset( $row->$key ) ? trim( (string) $row->$key ) : '';
	};
	$fields = array(
		__( 'Source', 'restwell-retreats' ) => restwell_enquiry_source_display_label( $row ),
	);
	$text   = array(
		'utm_source'      => __( 'UTM source', 'restwell-retreats' ),
		'utm_medium'      => __( 'UTM medium', 'restwell-retreats' ),
		'utm_campaign'    => __( 'UTM campaign', 'restwell-retreats' ),
		'utm_content'     => __( 'UTM content', 'restwell-retreats' ),
		'utm_term'        => __( 'UTM term', 'restwell-retreats' ),
		'landing_path'    => __( 'First page they saw', 'restwell-retreats' ),
		'referrer_domain' => __( 'Sent by website', 'restwell-retreats' ),
	);
	foreach ( $text as $key => $label ) {
		if ( '' !== $get( $key ) ) {
			$fields[ $label ] = $get( $key );
		}
	}
	if ( '' !== $get( 'source_label' ) ) {
		$fields[ __( 'Facebook click ID (fbclid)', 'restwell-retreats' ) ] = '1' === $get( 'has_fbclid' ) ? __( 'Yes', 'restwell-retreats' ) : __( 'No', 'restwell-retreats' );
		$fields[ __( 'Google click ID (gclid)', 'restwell-retreats' ) ]    = '1' === $get( 'has_gclid' ) ? __( 'Yes', 'restwell-retreats' ) : __( 'No', 'restwell-retreats' );
	}
	return $fields;
}

/**
 * Source label to show for a stored row ("Unknown" when none was recorded).
 *
 * @param object|array<string, mixed> $row Enquiry row.
 * @return string
 */
function restwell_enquiry_source_display_label( $row ): string {
	$label = is_array( $row ) ? ( $row['source_label'] ?? '' ) : ( $row->source_label ?? '' );
	$label = trim( (string) $label );
	return '' === $label ? __( 'Unknown', 'restwell-retreats' ) : $label;
}
