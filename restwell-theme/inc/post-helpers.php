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

	return __( 'Tips, stories and Whitstable updates', 'restwell-retreats' );
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
		'Accessible holiday tips, guest stories, what’s on around Whitstable, and practical updates for wheelchair users, carers and anyone planning a respite break.',
		'restwell-retreats'
	);
}

