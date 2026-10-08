<?php
/**
 * Post display helpers (category label, read time).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return the name of the primary category for display (archive, single hero, schema).
 * Returns an empty string if none is set or only the default "Uncategorized" is assigned.
 *
 * @param int|null $post_id Optional post ID; defaults to current post in the loop.
 * @return string
 */
function restwell_get_primary_category( $post_id = null ) {
	$post_id = $post_id ? absint( $post_id ) : 0;
	$cats    = $post_id ? get_the_category( $post_id ) : get_the_category();
	if ( empty( $cats ) ) {
		return '';
	}
	foreach ( $cats as $cat ) {
		if ( $cat->slug !== 'uncategorized' ) {
			return $cat->name;
		}
	}
	return '';
}

/**
 * Primary category term ID for related-post queries (skips Uncategorized when possible).
 *
 * @param int|null $post_id Post ID or null for current post in the loop.
 * @return int Term ID, or 0 when none.
 */
function restwell_get_primary_category_id( $post_id = null ) {
	$post_id = $post_id ? absint( $post_id ) : 0;
	$cats    = $post_id ? get_the_category( $post_id ) : get_the_category();
	if ( empty( $cats ) ) {
		return 0;
	}
	foreach ( $cats as $cat ) {
		if ( $cat->slug !== 'uncategorized' ) {
			return (int) $cat->term_id;
		}
	}
	return (int) $cats[0]->term_id;
}

/**
 * Estimate reading time in minutes for a block of post content.
 * Based on ~200 words per minute (comfortable for accessibility).
 *
 * @param string $content Raw post content.
 * @return int Minutes, minimum 1.
 */
function restwell_estimate_read_time( $content ) {
	$word_count = str_word_count( wp_strip_all_tags( $content ) );
	return max( 1, (int) ceil( $word_count / 200 ) );
}

/**
 * Default H1 for the blog index (posts page).
 *
 * Broader than “travel guides” alone: tips, stories, Whitstable notes, updates.
 *
 * @return string
 */
function restwell_get_blog_index_heading() {
	$posts_id = (int) get_option( 'page_for_posts', 0 );
	if ( $posts_id > 0 ) {
		$title = trim( (string) get_the_title( $posts_id ) );
		if ( $title !== '' && strcasecmp( $title, 'Blog' ) !== 0 ) {
			return $title;
		}
	}

	return __( 'Notes for planning a trip', 'restwell-retreats' );
}

/**
 * Default lede under the blog index H1.
 *
 * Uses the posts-page excerpt when editors have set one.
 *
 * @return string
 */
function restwell_get_blog_index_lede() {
	$posts_id = (int) get_option( 'page_for_posts', 0 );
	if ( $posts_id > 0 ) {
		$excerpt = trim( (string) get_post_field( 'post_excerpt', $posts_id ) );
		if ( $excerpt !== '' ) {
			return $excerpt;
		}
	}

	return __(
		'Guides about accessible travel written from one adapted bungalow in Whitstable: the Kent coast in a wheelchair, how funding for a break usually works, and how to read an access statement so a listing can’t catch you out.',
		'restwell-retreats'
	);
}

/**
 * A small pool of already-optimised Whitstable stock photos (all pre-existing,
 * already used elsewhere on the site, with mapped alt text) used to vary the
 * fallback image on post cards when a post has no featured image set.
 *
 * @return string[] Paths relative to assets/images/.
 */
function restwell_get_blog_fallback_pool() {
	return array(
		'stock/restwell-whitstable-coastline-panorama.webp',
		'stock/restwell-whitstable-coastal-pathway.webp',
		'stock/restwell-whitstable-marina-sunset.webp',
		'stock/restwell-whitstable-drone-aerial-view.webp',
		'stock/restwell-whitstable-beach-huts.webp',
		'stock/restwell-whitstable-sunset-pier.webp',
		'stock/restwell-whitstable-coastal-walk.webp',
		'stock/whitstable-days-out.webp',
		'stock/restwell-whitstable-beach-relaxation.webp',
	);
}

/**
 * Featured image URL + alt text for a post card, falling back to a rotating
 * pool of on-brand stock photos (so a grid of un-illustrated posts doesn't
 * all show the same picture) when no thumbnail is set.
 *
 * @param int    $post_id Post ID.
 * @param string $size    Registered image size.
 * @return array{0:string,1:string} URL and alt text.
 */
/**
 * One distinct image per seeded guide (audit I20): every post used to share
 * the coastline panorama as its social image, and the rotating pool repeated
 * on the blog grid. Real bungalow photos where the topic is the house.
 *
 * @return array<string, string> post slug => theme image path
 */
function restwell_get_post_image_map() {
	return array(
		'accessible-beaches-coastal-walks-kent'          => 'stock/restwell-whitstable-coastal-walk.webp',
		'direct-payment-holiday-accommodation'           => 'stock/restwell-whitstable-beach-huts-promenade-sunset.jpg',
		'revitalise-alternatives-accessible-holidays'    => 'stock/restwell-whitstable-beach-relaxation.webp',
		'how-to-choose-accessible-self-catering-holiday' => 'bungalow/LR-1-LS.jpg',
		'how-to-read-holiday-cottage-access-statement'   => 'bungalow/WR-1-LS.jpg',
		'carers-respite-holiday-guide'                   => 'stock/restwell-whitstable-sunset-pier.webp',
		'what-to-pack-accessible-self-catering-uk'       => 'bungalow/BD1-1-LS.jpg',
		'accessible-parking-whitstable-tankerton'        => 'bungalow/EX-1-LS.jpg',
		'chc-respite-holiday-accommodation-uk'           => 'stock/restwell-whitstable-beach-huts-sunset-slope.jpg',
		'hire-mobility-scooter-equipment-uk-holiday'     => 'bungalow/EQU-2-LS.jpg',
		'accessible-train-travel-whitstable-kent'        => 'stock/restwell-whitstable-drone-aerial-view.webp',
		'travel-insurance-disability-uk-self-catering'   => 'stock/restwell-whitstable-pebble-beach-groynes.jpg',
		'commissioner-checklist-accessible-respite-stay' => 'bungalow/BD2-6-LS.jpg',
		'personal-budget-short-break-care-act'           => 'stock/restwell-whitstable-painted-beach-huts.jpg',
		'accessible-eating-out-whitstable-kent'          => 'stock/restwell-whitstable-marina-sunset.webp',
		'changing-places-toilets-kent-coast-days-out'    => 'bungalow/WR-3-LS.jpg',
		'quieter-times-whitstable-low-crowd-access'      => 'stock/restwell-whitstable-shingle-beach-sunset.jpg',
		'holiday-backup-plan-care-worker-change'         => 'stock/restwell-kent-nursery-hedgerow-path.jpg',
		'fatigue-friendly-whitstable-coastal-day'        => 'stock/restwell-whitstable-coastal-pathway.webp',
	);
}

/**
 * Theme image path for a post without a featured image, or ''.
 *
 * @param int $post_id Post ID.
 * @return string
 */
function restwell_get_post_fallback_image( $post_id ) {
	$map  = restwell_get_post_image_map();
	$slug = (string) get_post_field( 'post_name', $post_id );
	if ( isset( $map[ $slug ] ) ) {
		return $map[ $slug ];
	}
	$pool = restwell_get_blog_fallback_pool();
	return $pool ? $pool[ absint( $post_id ) % count( $pool ) ] : '';
}

function restwell_get_post_card_thumb( $post_id, $size ) {
	$post_id  = absint( $post_id );
	$thumb_id = (int) get_post_thumbnail_id( $post_id );
	$thumb    = $thumb_id ? get_the_post_thumbnail_url( $post_id, $size ) : '';
	$alt      = '';

	if ( $thumb_id > 0 && function_exists( 'restwell_attachment_image_alt' ) ) {
		$alt = restwell_attachment_image_alt( $thumb_id );
	}

	if ( ! $thumb && function_exists( 'restwell_theme_image_url' ) ) {
		$pick  = restwell_get_post_fallback_image( $post_id );
		$thumb = restwell_theme_image_url( $pick );
		if ( $alt === '' && function_exists( 'restwell_theme_image_alt' ) ) {
			$alt = restwell_theme_image_alt( $pick );
		}
	}

	if ( $alt === '' ) {
		$alt = get_the_title( $post_id );
	}

	return array( $thumb, $alt );
}

/**
 * Trimmed string, or $fallback when empty.
 *
 * @param mixed  $value    Candidate value.
 * @param string $fallback Used when trim( (string) $value ) is empty.
 * @return string
 */
function restwell_first_nonempty_string( $value, $fallback ) {
	$value = trim( (string) $value );
	return $value !== '' ? $value : (string) $fallback;
}

/**
 * Archive H1s read "Kent & coast", not "Category: Kent & coast" (audit I31).
 */
add_filter( 'get_the_archive_title_prefix', '__return_empty_string' );

/**
 * Post byline: who wrote the guides (decided 1 Oct 2026, audit I19).
 * The visible byline and the BlogPosting author Person both read from here.
 *
 * @return array{name:string,url:string}
 */
function restwell_get_post_byline() {
	return array(
		'name' => (string) get_option( 'restwell_post_byline_name', 'Ellie Smith' ),
		'url'  => (string) get_option( 'restwell_post_byline_url', 'https://www.linkedin.com/in/ellie-smith-me/' ),
	);
}

/**
 * Post dates in UK format ("1 October 2026"), whatever the site date setting.
 */
const RESTWELL_POST_DATE_FORMAT = 'j F Y';
