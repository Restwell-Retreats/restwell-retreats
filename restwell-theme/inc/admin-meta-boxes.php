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
 * Whether this page is built from Page Content Fields (not the classic editor).
 *
 * @param int $post_id Page ID.
 * @return bool
 */
function restwell_page_uses_structured_content_fields( $post_id ) {
	$post_id = absint( $post_id );
	if ( ! $post_id ) {
		return false;
	}

	$front_id = (int) get_option( 'page_on_front', 0 );
	if ( $front_id > 0 && $post_id === $front_id ) {
		return true;
	}

	$template = (string) get_page_template_slug( $post_id );
	if ( $template === '' ) {
		return false;
	}

	// Custom theme templates (template-*.php, page-guest-guide.php) ignore post_content.
	return ( 0 === strpos( $template, 'template-' ) )
		|| ( 'page-guest-guide.php' === $template );
}

/**
 * Hide the classic big text editor on pages that use Page Content Fields.
 *
 * WordPress always offers that top editor by default. Restwell's designed pages
 * do not read it — visitors see the tabbed fields instead — so showing both is confusing.
 */
function restwell_maybe_remove_classic_editor_for_structured_pages() {
	if ( ! is_admin() ) {
		return;
	}

	$post_id = 0;
	if ( isset( $_GET['post'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$post_id = absint( wp_unslash( $_GET['post'] ) );
	} elseif ( isset( $_POST['post_ID'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		$post_id = absint( wp_unslash( $_POST['post_ID'] ) );
	}

	if ( ! $post_id || 'page' !== get_post_type( $post_id ) ) {
		return;
	}

	if ( restwell_page_uses_structured_content_fields( $post_id ) ) {
		remove_post_type_support( 'page', 'editor' );
	}
}
add_action( 'admin_init', 'restwell_maybe_remove_classic_editor_for_structured_pages' );

/**
 * Hide noisy default metaboxes on page edit screens.
 *
 * The native "Custom Fields" box lists every post meta key/value — on Restwell
 * pages that is 100+ rows and looks like a broken form. Content is edited via
 * "Page Content Fields" instead.
 */
function restwell_hide_noisy_page_meta_boxes() {
	remove_meta_box( 'postcustom', 'page', 'normal' );
	remove_meta_box( 'commentstatusdiv', 'page', 'normal' );
	remove_meta_box( 'commentsdiv', 'page', 'normal' );
	remove_meta_box( 'trackbacksdiv', 'page', 'normal' );
	remove_meta_box( 'authordiv', 'page', 'normal' );
}
add_action( 'add_meta_boxes_page', 'restwell_hide_noisy_page_meta_boxes', 99 );

/**
 * Hide native Custom Fields on posts too (same wall-of-meta problem).
 */
function restwell_hide_noisy_post_meta_boxes() {
	remove_meta_box( 'postcustom', 'post', 'normal' );
}
add_action( 'add_meta_boxes_post', 'restwell_hide_noisy_post_meta_boxes', 99 );

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
