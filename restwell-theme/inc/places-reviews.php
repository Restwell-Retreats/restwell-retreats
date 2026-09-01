<?php
/**
 * Google Places (New) reviews for the front page testimonials.
 *
 * Fetches live reviews server-side from Place Details (New) and caches them
 * for 24 hours. Falls back to the static on-page quotes whenever the API is
 * unconfigured, erroring, or empty — the section never renders empty.
 *
 * Setup:
 *   1. Define RESTWELL_GOOGLE_PLACES_KEY in wp-config.php and restrict the
 *      key to the Places API (New) in Cloud Console.
 *   2. Place ID ships as a coded default (owner-provided, cross-checked
 *      against the listing's g.page/Maps links); option or constant overrides
 *      it. First successful fetch caches reviews for 24h.
 *
 * Schema note: deliberately no AggregateRating/reviewRating JSON-LD from this
 * data — self-serving review markup is ineligible for rich results.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const RESTWELL_PLACES_REVIEWS_CACHE_KEY = 'restwell_places_reviews_v1';
const RESTWELL_PLACES_REVIEWS_CACHE_TTL = DAY_IN_SECONDS;

/**
 * Configured Places API key.
 *
 * @return string Empty when unset.
 */
function restwell_places_api_key(): string {
	return defined( 'RESTWELL_GOOGLE_PLACES_KEY' ) ? (string) constant( 'RESTWELL_GOOGLE_PLACES_KEY' ) : '';
}

/**
 * Configured Google Place ID (option first, then constant).
 *
 * @return string Empty when unset.
 */
function restwell_google_place_id(): string {
	$place_id = trim( (string) get_option( 'restwell_google_place_id', '' ) );
	if ( '' === $place_id && defined( 'RESTWELL_GOOGLE_PLACE_ID' ) ) {
		$place_id = trim( (string) constant( 'RESTWELL_GOOGLE_PLACE_ID' ) );
	}
	// Owner-supplied, cross-checked against the listing links (g.page + Maps
	// short link both resolve to feature 0x47df33293579d851:0x92eb2d2097255cc4).
	if ( '' === $place_id ) {
		$place_id = 'ChIJUdh5NSkz30cRxFwllyAt65I';
	}
	return $place_id;
}

/**
 * Normalised review fields consumed by template-parts/google-reviews.php.
 *
 * @param array<string, mixed> $review Raw Review object from the API.
 * @return array{name:string,text:string,relative_time:string,rating:int|null,author_uri:string}|array{} Empty array when unusable.
 */
function restwell_places_normalize_review( array $review ): array {
	$name = isset( $review['authorAttribution']['displayName'] )
		? sanitize_text_field( (string) $review['authorAttribution']['displayName'] )
		: '';

	$text = isset( $review['text']['text'] )
		? sanitize_textarea_field( (string) $review['text']['text'] )
		: '';

	if ( '' === $name || '' === $text ) {
		return array();
	}

	return array(
		'name'           => $name,
		'text'           => $text,
		'relative_time'  => isset( $review['relativePublishTimeDescription'] )
			? sanitize_text_field( (string) $review['relativePublishTimeDescription'] )
			: '',
		'rating'         => isset( $review['rating'] ) ? max( 1, min( 5, (int) $review['rating'] ) ) : null,
		'author_uri'     => isset( $review['authorAttribution']['uri'] ) ? esc_url_raw( (string) $review['authorAttribution']['uri'] ) : '',
	);
}

/**
 * Fetch and cache reviews. Public entry point.
 *
 * Returns array( 'reviews' => array<int, array>, 'reviews_uri' => string ).
 * Cached payloads carry the same shape; an API failure returns
 * array( 'reviews' => array(), 'reviews_uri' => '' ).
 *
 * @return array{reviews: array<int, array{name:string,text:string,relative_time:string,rating:int|null,author_uri:string}>, reviews_uri: string}
 */
function restwell_get_google_reviews(): array {
	$cached = get_transient( RESTWELL_PLACES_REVIEWS_CACHE_KEY );
	if ( is_array( $cached ) ) {
		return $cached;
	}

	$empty = array(
		'reviews'     => array(),
		'reviews_uri' => '',
	);

	$key      = restwell_places_api_key();
	$place_id = restwell_google_place_id();

	if ( '' === $key || '' === $place_id || ! function_exists( 'wp_remote_get' ) ) {
		set_transient( RESTWELL_PLACES_REVIEWS_CACHE_KEY, $empty, 15 * MINUTE_IN_SECONDS );
		return $empty;
	}

	$response = wp_remote_get(
		'https://places.googleapis.com/v1/places/' . rawurlencode( $place_id ),
		array(
			'timeout' => 8,
			'headers' => array(
				'X-Goog-Api-Key'  => $key,
				// Reviews + their Google Maps URI. Keep minimal: field mask drives billing class.
				'X-Goog-FieldMask' => 'reviews,googleMapsLinks.reviewsUri',
			),
		)
	);

	if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
		// Back off briefly so a broken key doesn't hammer the API every request.
		set_transient( RESTWELL_PLACES_REVIEWS_CACHE_KEY, $empty, 15 * MINUTE_IN_SECONDS );
		return $empty;
	}

	$body = json_decode( wp_remote_retrieve_body( $response ), true );
	if ( ! is_array( $body ) ) {
		set_transient( RESTWELL_PLACES_REVIEWS_CACHE_KEY, $empty, 15 * MINUTE_IN_SECONDS );
		return $empty;
	}

	$reviews = array();
	foreach ( (array) ( $body['reviews'] ?? array() ) as $raw_review ) {
		if ( ! is_array( $raw_review ) ) {
			continue;
		}
		$normalized = restwell_places_normalize_review( $raw_review );
		if ( $normalized ) {
			$reviews[] = $normalized;
		}
	}

	$payload = array(
		'reviews'     => $reviews,
		'reviews_uri' => isset( $body['googleMapsLinks']['reviewsUri'] )
			? esc_url_raw( (string) $body['googleMapsLinks']['reviewsUri'] )
			: '',
	);

	// Google's ToS allows caching place data up to 30 days; we take one day.
	set_transient( RESTWELL_PLACES_REVIEWS_CACHE_KEY, $payload, RESTWELL_PLACES_REVIEWS_CACHE_TTL );

	return $payload;
}
