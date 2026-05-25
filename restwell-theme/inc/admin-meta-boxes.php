<?php
/**
 * Post editor meta box visibility and ordering.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ensure the Excerpt meta box is always visible on the post edit screen.
 * Without this, editors need to find it under Screen Options.
 */
function restwell_show_excerpt_meta_box() {
	add_meta_box(
		'postexcerpt',
		__( 'Excerpt (archive summary)', 'restwell-retreats' ),
		'post_excerpt_meta_box',
		'post',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes_post', 'restwell_show_excerpt_meta_box' );

/**
 * Keep Categories and Tags high in the post sidebar so editors see them above the fold.
 * Classic editor + a large SEO meta box in "normal" often pushes the sidebar below the scroll.
 *
 * @return void
 */
function restwell_promote_post_taxonomy_meta_boxes() {
	remove_meta_box( 'categorydiv', 'post', 'side' );
	remove_meta_box( 'tagsdiv-post_tag', 'post', 'side' );

	add_meta_box(
		'categorydiv',
		__( 'Categories' ),
		'post_categories_meta_box',
		'post',
		'side',
		'high'
	);
	add_meta_box(
		'tagsdiv-post_tag',
		__( 'Tags' ),
		'post_tags_meta_box',
		'post',
		'side',
		'high'
	);
}
add_action( 'add_meta_boxes_post', 'restwell_promote_post_taxonomy_meta_boxes', 20 );
