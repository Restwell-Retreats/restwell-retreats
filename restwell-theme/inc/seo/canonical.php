<?php
/**
 * SEO: canonical URL, robots noindex, and verification meta tags.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The fourteen supporting "mill" posts that stay noindex, follow.
 *
 * Source of truth: copy-overwrites/mill-posts.md and docs/seo/LANES.md (five
 * keep-guides indexable, fourteen noindex, no new mill). Enforced in code so a
 * re-seed or a fresh database cannot quietly make them indexable.
 *
 * @return string[]
 */
function restwell_get_noindex_post_slugs() {
	return array(
		'accessible-parking-whitstable-tankerton',
		'accessible-train-travel-whitstable-kent',
		'accessible-eating-out-whitstable-kent',
		'changing-places-toilets-kent-coast-days-out',
		'quieter-times-whitstable-low-crowd-access',
		'fatigue-friendly-whitstable-coastal-day',
		'chc-respite-holiday-accommodation-uk',
		'personal-budget-short-break-care-act',
		'commissioner-checklist-accessible-respite-stay',
		'what-to-pack-accessible-self-catering-uk',
		'hire-mobility-scooter-equipment-uk-holiday',
		'travel-insurance-disability-uk-self-catering',
		'holiday-backup-plan-care-worker-change',
		'carers-respite-holiday-guide',
	);
}

/**
 * Whether a post is one of the fourteen noindex mill posts.
 *
 * @param int|WP_Post $post Post or ID.
 * @return bool
 */
function restwell_is_noindex_post( $post ) {
	$post = get_post( $post );
	return $post instanceof WP_Post
		&& 'post' === $post->post_type
		&& in_array( $post->post_name, restwell_get_noindex_post_slugs(), true );
}

/**
 * Indexable published posts in a category (excludes the noindex mill).
 *
 * @param WP_Term $term Category.
 * @return int
 */
function restwell_count_indexable_posts_in_term( $term ) {
	static $cache = array();
	if ( ! $term instanceof WP_Term ) {
		return 0;
	}
	if ( isset( $cache[ $term->term_id ] ) ) {
		return $cache[ $term->term_id ];
	}
	$slugs = get_posts(
		array(
			'post_type'        => 'post',
			'post_status'      => 'publish',
			'posts_per_page'   => -1,
			'fields'           => 'ids',
			'tax_query'        => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
				array(
					'taxonomy' => $term->taxonomy,
					'terms'    => (int) $term->term_id,
				),
			),
			'suppress_filters' => true,
		)
	);
	$count = 0;
	foreach ( $slugs as $id ) {
		if ( ! restwell_is_noindex_post( $id ) && ! get_post_meta( $id, 'meta_noindex', true ) ) {
			++$count;
		}
	}
	$cache[ $term->term_id ] = $count;
	return $count;
}

/**
 * Category archives need at least this many indexable posts to be indexed
 * (decided 1 Oct 2026, audit I31).
 */
const RESTWELL_MIN_INDEXABLE_TERM_POSTS = 3;

function restwell_get_canonical_url_for_request() {
	if ( is_404() || is_search() ) {
		return '';
	}

	if ( is_singular() ) {
		$post = get_queried_object();
		if ( ! $post instanceof WP_Post ) {
			return '';
		}
		$custom = (string) get_post_meta( $post->ID, 'meta_canonical', true );
		if ( $custom !== '' ) {
			// Editors may only point the canonical at this site — a cross-domain
			// canonical would silently merge the page into someone else's URL.
			$custom_host = (string) wp_parse_url( $custom, PHP_URL_HOST );
			$home_host   = (string) wp_parse_url( home_url(), PHP_URL_HOST );
			if ( '' !== $custom_host && 0 === strcasecmp( $custom_host, $home_host ) ) {
				return esc_url( $custom );
			}
		}
		if ( function_exists( 'wp_get_canonical_url' ) ) {
			$core = wp_get_canonical_url( $post );
			if ( $core ) {
				return $core;
			}
		}
		return get_permalink( $post );
	}

	if ( is_front_page() ) {
		return home_url( '/' );
	}

	if ( is_home() && ! is_front_page() ) {
		$posts_page = (int) get_option( 'page_for_posts' );
		if ( ! $posts_page ) {
			return home_url( '/' );
		}
		global $wp_query;
		$paged_home = max( 1, (int) $wp_query->get( 'paged' ), (int) $wp_query->get( 'page' ) );
		if ( $paged_home > 1 ) {
			return get_pagenum_link( $paged_home, false );
		}
		return get_permalink( $posts_page );
	}

	global $wp_query;
	$paged = max( 1, (int) $wp_query->get( 'paged' ), (int) $wp_query->get( 'page' ) );

	if ( is_category() || is_tag() || is_tax() ) {
		$term = get_queried_object();
		if ( ! $term || is_wp_error( get_term_link( $term ) ) ) {
			return '';
		}
		$link = get_term_link( $term );
		if ( is_wp_error( $link ) ) {
			return '';
		}
		if ( $paged > 1 ) {
			return get_pagenum_link( $paged, false );
		}
		return $link;
	}

	if ( is_post_type_archive() ) {
		$pt = get_query_var( 'post_type' );
		if ( is_array( $pt ) ) {
			$pt = reset( $pt );
		}
		$link = $pt ? get_post_type_archive_link( $pt ) : '';
		if ( ! $link ) {
			return '';
		}
		if ( $paged > 1 ) {
			return get_pagenum_link( $paged, false );
		}
		return $link;
	}

	if ( is_author() ) {
		$link = get_author_posts_url( get_queried_object_id() );
		if ( $paged > 1 ) {
			return get_pagenum_link( $paged, false );
		}
		return $link;
	}

	if ( is_date() ) {
		$y = (int) get_query_var( 'year' );
		$m = (int) get_query_var( 'monthnum' );
		$d = (int) get_query_var( 'day' );
		if ( $d && $m && $y ) {
			return get_day_link( $y, $m, $d );
		}
		if ( $m && $y ) {
			return get_month_link( $y, $m );
		}
		if ( $y ) {
			return get_year_link( $y );
		}
	}

	return '';
}

/**
 * Whether the current singular view should carry noindex.
 *
 * @return bool
 */
function restwell_is_noindex_singular_request() {
	if ( ! is_singular() ) {
		return false;
	}
	$pid = get_queried_object_id();
	// Guest guide is session-gated private content; always keep it out of index.
	if ( is_page_template( 'page-guest-guide.php' ) || is_page( 'sample-page' ) ) {
		return true;
	}
	if ( (bool) get_post_meta( $pid, 'meta_noindex', true ) ) {
		return true;
	}
	return restwell_is_noindex_post( $pid );
}

/**
 * Output <link rel="canonical"> for all indexable views.
 *
 * Core's rel_canonical is removed below so this is the only canonical tag; it
 * also honours meta_canonical, which core's would not.
 */
function restwell_output_canonical_and_robots() {
	$canonical = restwell_get_canonical_url_for_request();
	if ( $canonical !== '' ) {
		echo '<link rel="canonical" href="' . esc_url( $canonical ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'restwell_output_canonical_and_robots', 2 );
remove_action( 'wp_head', 'rel_canonical' );

/**
 * One robots meta tag per page: fold the theme's noindex rules into core's
 * wp_robots output instead of printing a second tag.
 *
 * noindex keeps URLs out of the index; follow allows normal link discovery.
 *
 * @param array $robots Directive map.
 * @return array
 */
function restwell_robots_noindex_utility_views( $robots ) {
	$thin_term = ( is_category() || is_tag() ) && restwell_count_indexable_posts_in_term( get_queried_object() ) < RESTWELL_MIN_INDEXABLE_TERM_POSTS;
	if ( is_search() || is_404() || $thin_term || restwell_is_noindex_singular_request() ) {
		$robots['noindex'] = true;
		$robots['follow']  = true;
		unset( $robots['index'], $robots['nofollow'] );
	}
	return $robots;
}
add_filter( 'wp_robots', 'restwell_robots_noindex_utility_views' );
