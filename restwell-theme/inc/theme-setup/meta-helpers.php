<?php
/**
 * Theme setup: post meta merge helpers.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Merge theme default post meta into a page: overwrite all keys when $force; otherwise only set keys that are not stored yet.
 *
 * Preserves intentional edits and empty values; fills gaps when new defaults are added to the theme.
 *
 * @param int   $post_id  Post ID.
 * @param array $defaults Key => value from a restwell_get_*_defaults() map.
 * @param bool  $force    When true, replace every listed key from defaults.
 * @return int Number of meta keys written.
 */
function restwell_merge_theme_defaults_into_post_meta( $post_id, array $defaults, $force ) {
	$post_id = (int) $post_id;
	if ( $post_id < 1 || empty( $defaults ) ) {
		return 0;
	}

	$written = 0;
	foreach ( $defaults as $key => $value ) {
		if ( $force || ! metadata_exists( 'post', $post_id, $key ) ) {
			update_post_meta( $post_id, $key, $value );
			++$written;
		}
	}

	return $written;
}

/**
 * Post meta value, or the default from a theme defaults map when the key has never been saved.
 *
 * Uses metadata_exists so intentionally saved empty strings are preserved. Unseeded pages get
 * the same copy as Theme Setup / restwell_get_*_page_defaults().
 *
 * @param int    $post_id  Post ID.
 * @param string $key      Meta key.
 * @param array  $defaults Key => default from restwell_get_*_page_defaults().
 * @return mixed Stored value or default.
 */
function restwell_post_meta_or_default( $post_id, $key, array $defaults ) {
	$post_id = (int) $post_id;
	if ( $post_id < 1 ) {
		$value = $defaults[ $key ] ?? '';
	} elseif ( metadata_exists( 'post', $post_id, $key ) ) {
		$value = get_post_meta( $post_id, $key, true );
	} else {
		$value = $defaults[ $key ] ?? '';
	}

	if ( is_string( $value ) && strncmp( $key, 'prop_', 5 ) === 0 && function_exists( 'restwell_normalize_editorial_dashes' ) ) {
		$value = restwell_normalize_editorial_dashes( $value );
	}

	return $value;
}

/**
 * Resolve a stored URL or path; empty stored values fall back to the theme default (same as old `?:` for URLs).
 *
 * @param int    $post_id  Post ID.
 * @param string $key      Meta key.
 * @param array  $defaults Map from restwell_get_*_page_defaults().
 * @return string Absolute URL (not escaped).
 */
function restwell_post_meta_url( $post_id, $key, array $defaults ) {
	$post_id = (int) $post_id;
	$def     = trim( (string) ( $defaults[ $key ] ?? '' ) );
	if ( $post_id < 1 ) {
		$raw = $def;
	} elseif ( metadata_exists( 'post', $post_id, $key ) ) {
		$raw = trim( (string) get_post_meta( $post_id, $key, true ) );
	} else {
		$raw = $def;
	}
	if ( $raw === '' ) {
		$raw = $def;
	}
	if ( $raw === '' ) {
		return home_url( '/' );
	}
	if ( preg_match( '#^https?://#i', $raw ) ) {
		return $raw;
	}
	return home_url( $raw );
}

/**
 * Default meta for The Property page.
 */
