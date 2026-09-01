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
	foreach ( $agents as $agent ) {
		$output .= "User-agent: {$agent}\nAllow: /\n\n";
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
	}

	$noindex_ids = array();
	$paged       = 1;
	$per_page    = 200;
	do {
		$batch = get_posts(
			array(
				'post_type'        => $post_type,
				'post_status'      => 'publish',
				'posts_per_page'   => $per_page,
				'paged'            => $paged,
				'fields'           => 'ids',
				'no_found_rows'    => true,
				'suppress_filters' => true,
				'meta_key'         => 'meta_noindex',
				'meta_value'       => '1',
			)
		);
		if ( ! is_array( $batch ) || array() === $batch ) {
			break;
		}
		$noindex_ids = array_merge( $noindex_ids, array_map( 'intval', $batch ) );
		++$paged;
	} while ( count( $batch ) === $per_page );
	if ( array() !== $noindex_ids ) {
		$exclude_ids = array_merge( $exclude_ids, $noindex_ids );
	}

	$exclude_ids = array_values( array_unique( array_filter( $exclude_ids ) ) );
	if ( empty( $exclude_ids ) ) {
		return $args;
	}

	$args['post__not_in'] = $exclude_ids;
	return $args;
}
add_filter( 'wp_sitemaps_posts_query_args', 'restwell_sitemap_exclude_demo_and_noindex_pages', 10, 2 );
