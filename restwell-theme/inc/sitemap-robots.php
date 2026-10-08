<?php
/**
 * Robots.txt and XML sitemap discovery helpers.
 *
 * WordPress 5.5+ exposes HTML sitemaps at /wp-sitemap.xml (index). This file
 * ensures the sitemap URL is declared in robots.txt and avoids blocking assets.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Append sitemap index URL to virtual robots.txt output.
 *
 * @param string $output robots.txt content.
 * @param bool   $public Whether the site is public.
 * @return string
 */
function restwell_robots_txt_sitemap_line( $output, $public ) {
	if ( '0' === (string) get_option( 'blog_public' ) ) {
		return $output;
	}
	$sitemap = home_url( '/wp-sitemap.xml' );
	if ( strpos( $output, 'wp-sitemap.xml' ) !== false ) {
		return $output;
	}
	$output .= "\nSitemap: " . esc_url( $sitemap ) . "\n";
	return $output;
}
add_filter( 'robots_txt', 'restwell_robots_txt_sitemap_line', 10, 2 );

/**
 * Append explicit Allow rules for common AI / LLM crawlers (GEO).
 *
 * @param string $output robots.txt content.
 * @param bool   $public Whether the site is public.
 * @return string
 */
function restwell_robots_txt_allow_ai_crawlers( $output, $public ) {
	if ( '0' === (string) get_option( 'blog_public' ) ) {
		return $output;
	}
	$output .= "\n# AI / LLM crawlers (explicit allow for public site)\n";
	$agents   = array(
		'GPTBot',
		'ChatGPT-User',
		'ClaudeBot',
		'PerplexityBot',
		'Google-Extended',
	);
	// A named group replaces the * group for that crawler, so repeat the
	// admin rules here or these bots would be allowed into /wp-admin/.
	foreach ( $agents as $agent ) {
		$output .= "User-agent: {$agent}\nDisallow: /wp-admin/\nAllow: /wp-admin/admin-ajax.php\nAllow: /\n\n";
	}
	return $output;
}
add_filter( 'robots_txt', 'restwell_robots_txt_allow_ai_crawlers', 20, 2 );

/**
 * Remove attachment URLs from WordPress XML sitemap post-type providers.
 *
 * @param array<string, WP_Post_Type> $post_types Registered sitemap post types.
 * @return array<string, WP_Post_Type>
 */
function restwell_sitemap_exclude_attachment_post_type( $post_types ) {
	if ( isset( $post_types['attachment'] ) ) {
		unset( $post_types['attachment'] );
	}
	return $post_types;
}
add_filter( 'wp_sitemaps_post_types', 'restwell_sitemap_exclude_attachment_post_type' );

/**
 * Keep WP demo / retired / noindex utility pages out of the XML sitemap.
 *
 * @param array<string, mixed> $args  WP_Query args for sitemap entries.
 * @param string               $post_type Post type.
 * @return array<string, mixed>
 */
function restwell_sitemap_exclude_demo_and_noindex_pages( $args, $post_type ) {
	if ( ! in_array( $post_type, array( 'page', 'post' ), true ) ) {
		return $args;
	}

	$exclude_ids = isset( $args['post__not_in'] ) ? array_map( 'intval', (array) $args['post__not_in'] ) : array();

	if ( 'page' === $post_type ) {
		foreach ( array( 'sample-page', 'contact', 'guest-guide' ) as $slug ) {
			$page = get_page_by_path( $slug, OBJECT, 'page' );
			if ( $page && (int) $page->ID > 0 ) {
				$exclude_ids[] = (int) $page->ID;
			}
		}
	}

	if ( 'post' === $post_type ) {
		$old_beaches = get_page_by_path( 'accessible-beaches-kent-coast', OBJECT, 'post' );
		if ( $old_beaches instanceof WP_Post ) {
			$exclude_ids[] = (int) $old_beaches->ID;
		}
		// The fourteen noindex mill posts (inc/seo/canonical.php).
		foreach ( restwell_get_noindex_post_slugs() as $slug ) {
			$mill = get_page_by_path( $slug, OBJECT, 'post' );
			if ( $mill instanceof WP_Post ) {
				$exclude_ids[] = (int) $mill->ID;
			}
		}
	}

	$exclude_ids = array_values( array_unique( array_filter( $exclude_ids ) ) );
	if ( ! empty( $exclude_ids ) ) {
		$args['post__not_in'] = $exclude_ids;
	}

	// Exclude meta_noindex=1 without a posts_per_page cap (a 51st noindex URL
	// used to leak into wp-sitemap). NOT EXISTS keeps ordinary posts in.
	$noindex_clause = array(
		'relation' => 'OR',
		array(
			'key'     => 'meta_noindex',
			'compare' => 'NOT EXISTS',
		),
		array(
			'key'     => 'meta_noindex',
			'value'   => '1',
			'compare' => '!=',
		),
	);
	$existing_meta = ( isset( $args['meta_query'] ) && is_array( $args['meta_query'] ) )
		? $args['meta_query']
		: array();
	if ( array() === $existing_meta ) {
		$args['meta_query'] = $noindex_clause;
	} else {
		$args['meta_query'] = array(
			'relation' => 'AND',
			$existing_meta,
			$noindex_clause,
		);
	}

	return $args;
}
add_filter( 'wp_sitemaps_posts_query_args', 'restwell_sitemap_exclude_demo_and_noindex_pages', 10, 2 );

/**
 * Keep thin and empty category archives out of the sitemap: an archive needs
 * RESTWELL_MIN_INDEXABLE_TERM_POSTS indexable posts to be listed (audit I31).
 *
 * @param array<string, mixed> $args     get_terms() args.
 * @param string               $taxonomy Taxonomy.
 * @return array<string, mixed>
 */
function restwell_sitemap_exclude_thin_terms( $args, $taxonomy ) {
	$terms = get_terms(
		array(
			'taxonomy'   => $taxonomy,
			'hide_empty' => false,
			'fields'     => 'all',
		)
	);
	if ( is_wp_error( $terms ) ) {
		return $args;
	}
	$exclude = isset( $args['exclude'] ) ? array_map( 'intval', (array) $args['exclude'] ) : array();
	foreach ( $terms as $term ) {
		if ( restwell_count_indexable_posts_in_term( $term ) < RESTWELL_MIN_INDEXABLE_TERM_POSTS ) {
			$exclude[] = (int) $term->term_id;
		}
	}
	if ( $exclude ) {
		$args['exclude'] = array_values( array_unique( $exclude ) );
	}
	return $args;
}
add_filter( 'wp_sitemaps_taxonomies_query_args', 'restwell_sitemap_exclude_thin_terms', 10, 2 );

/**
 * Empty category archives (e.g. Uncategorized with no posts) return a real 404
 * rather than a 200 page with nothing on it (audit I31).
 */
function restwell_404_empty_term_archives() {
	if ( ! ( is_category() || is_tag() ) || is_paged() ) {
		return;
	}
	$term = get_queried_object();
	if ( $term instanceof WP_Term && 0 === (int) $term->count ) {
		global $wp_query;
		$wp_query->set_404();
		status_header( 404 );
		nocache_headers();
	}
}
add_action( 'template_redirect', 'restwell_404_empty_term_archives', 1 );
