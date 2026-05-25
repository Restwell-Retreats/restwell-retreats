<?php
/**
 * LiteSpeed Cache compatibility: keep theme CSS/JS on stable URLs.
 *
 * When Page Optimization combines/minifies resources, Google Rich Results Test and some
 * crawlers intermittently fail to fetch generated bundles. Excluding this theme’s /assets/
 * tree from JS/CSS optimization preserves standard enqueue URLs (still cacheable by LSCache).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Path fragment for this theme’s asset directory (matches LiteSpeed “JS/CSS Excludes” format).
 *
 * @return string
 */
function restwell_litespeed_theme_assets_uri_fragment() {
	$dir         = wp_normalize_path( get_template_directory() );
	$content_dir = wp_normalize_path( WP_CONTENT_DIR );
	if ( strpos( $dir, $content_dir ) === 0 ) {
		$rel = substr( $dir, strlen( $content_dir ) );
		return '/wp-content' . ( $rel ? $rel : '' ) . '/assets/';
	}
	return '/wp-content/themes/' . get_template() . '/assets/';
}

/**
 * @param string|string[] $excludes Existing excludes from plugin settings.
 * @return string|string[]
 */
function restwell_litespeed_optimize_js_excludes( $excludes ) {
	if ( ! is_array( $excludes ) ) {
		$excludes = array_filter( array( (string) $excludes ) );
	}
	$frag = restwell_litespeed_theme_assets_uri_fragment();
	if ( $frag && ! in_array( $frag, $excludes, true ) ) {
		$excludes[] = $frag;
	}
	return $excludes;
}

/**
 * @param string|string[] $excludes Existing excludes from plugin settings.
 * @return string|string[]
 */
function restwell_litespeed_optimize_css_excludes( $excludes ) {
	return restwell_litespeed_optimize_js_excludes( $excludes );
}

if ( defined( 'LSCWP_V' ) ) {
	add_filter( 'litespeed_optimize_js_excludes', 'restwell_litespeed_optimize_js_excludes' );
	add_filter( 'litespeed_optimize_css_excludes', 'restwell_litespeed_optimize_css_excludes' );
}
