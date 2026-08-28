<?php
/**
 * SEO: canonical URL, robots noindex, and verification meta tags.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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
 * Output <meta name="robots"> noindex tag when the field is set (singular).
 * Output <link rel="canonical"> for all indexable views.
 */
function restwell_output_canonical_and_robots() {
	if ( is_singular() ) {
		$pid = get_queried_object_id();
		$noindex = (bool) get_post_meta( $pid, 'meta_noindex', true );
		// Guest guide is session-gated private content; always keep it out of index.
		if ( is_page_template( 'page-guest-guide.php' ) ) {
			$noindex = true;
		}
		// WordPress install stub — not a Restwell marketing URL.
		if ( is_page( 'sample-page' ) ) {
			$noindex = true;
		}
		if ( $noindex ) {
			// noindex keeps URLs out of the index; follow allows normal link discovery on private/marketing-off URLs.
			echo '<meta name="robots" content="noindex, follow">' . "\n";
		}
	}

	$canonical = restwell_get_canonical_url_for_request();
	if ( $canonical !== '' ) {
		echo '<link rel="canonical" href="' . esc_url( $canonical ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'restwell_output_canonical_and_robots', 2 );

/**
 * Keep utility views out of the index.
 *
 * @param array $robots Directive map.
 * @return array
 */
function restwell_robots_noindex_utility_views( $robots ) {
	if ( is_search() || is_404() ) {
		$robots['noindex'] = true;
	}
	return $robots;
}
add_filter( 'wp_robots', 'restwell_robots_noindex_utility_views' );
