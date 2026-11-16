<?php
/**
 * When a page's words last really changed.
 *
 * Most page copy lives in page-content fields (post meta), and the copy
 * migrations write those fields without touching the page itself. WordPress's
 * "last modified" date therefore stayed in April or May for pages rewritten in
 * October, and the sitemap told Google nothing had changed. This file stamps a
 * page whenever one of its visible fields changes, and the sitemap and the
 * home page's Open Graph tags and JSON-LD use the later of that stamp and
 * WordPress's own date.
 *
 * Blog posts keep WordPress's date: their words live in the post body, so the
 * date already moves when they change, and it matches the "Updated" date shown
 * under each post.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Meta key holding the GMT time ('Y-m-d H:i:s') a visible field last changed.
 */
const RESTWELL_CONTENT_MODIFIED_META = '_restwell_content_modified';

/**
 * Whether a change to this field counts as a change to the page.
 *
 * Visible copy is stored under plain keys (acc_intro, meta_title, wg_event_1_name).
 * Keys starting with an underscore are WordPress bookkeeping (edit locks, old
 * slugs) or our own stamp, so they don't count, except the two that change
 * what a visitor sees: the page template and the featured image.
 *
 * @param string $meta_key Meta key that changed.
 * @return bool
 */
function restwell_content_modified_tracks_key( string $meta_key ): bool {
	if ( '' === $meta_key ) {
		return false;
	}
	if ( '_' !== $meta_key[0] ) {
		return true;
	}
	return in_array( $meta_key, array( '_wp_page_template', '_thumbnail_id' ), true );
}

/**
 * The later of two GMT 'Y-m-d H:i:s' times; a blank or zero time loses.
 *
 * @param string $post_modified_gmt WordPress's own modified time.
 * @param string $stamped_gmt       Our stamp, or ''.
 * @return string
 */
function restwell_content_modified_latest_gmt( string $post_modified_gmt, string $stamped_gmt ): string {
	$valid = static function ( string $gmt ): bool {
		return 1 === preg_match( '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $gmt ) && '0000-00-00 00:00:00' !== $gmt;
	};
	if ( ! $valid( $stamped_gmt ) ) {
		return $post_modified_gmt;
	}
	if ( ! $valid( $post_modified_gmt ) ) {
		return $stamped_gmt;
	}
	// Same fixed-width format, so string order is time order.
	return strcmp( $stamped_gmt, $post_modified_gmt ) > 0 ? $stamped_gmt : $post_modified_gmt;
}

/**
 * Stamp a published page when one of its visible fields changes.
 *
 * Hooked to added/updated/deleted_post_meta. WordPress skips those hooks when
 * a field is saved with the value it already had, so only real changes count.
 *
 * @param int|int[] $meta_id   Meta ID(s); unused.
 * @param int       $object_id Post ID.
 * @param string    $meta_key  Meta key.
 */
function restwell_note_content_change( $meta_id, $object_id, $meta_key ): void {
	unset( $meta_id );
	static $stamped = array();

	$post_id = (int) $object_id;
	if ( $post_id < 1 || isset( $stamped[ $post_id ] ) || ! restwell_content_modified_tracks_key( (string) $meta_key ) ) {
		return;
	}
	if ( 'page' !== get_post_type( $post_id ) || 'publish' !== get_post_status( $post_id ) ) {
		return;
	}
	$stamped[ $post_id ] = true;
	update_post_meta( $post_id, RESTWELL_CONTENT_MODIFIED_META, gmdate( 'Y-m-d H:i:s' ) );
}
add_action( 'added_post_meta', 'restwell_note_content_change', 10, 3 );
add_action( 'updated_post_meta', 'restwell_note_content_change', 10, 3 );
add_action( 'deleted_post_meta', 'restwell_note_content_change', 10, 3 );

/**
 * When a page's content last changed (other post types: WordPress's date), as a GMT 'Y-m-d H:i:s' time.
 *
 * @param int|WP_Post $post Post or ID.
 * @return string '' when the post doesn't exist.
 */
function restwell_content_modified_gmt( $post ): string {
	$post = get_post( $post );
	if ( ! $post instanceof WP_Post ) {
		return '';
	}
	if ( 'page' !== $post->post_type ) {
		return (string) $post->post_modified_gmt;
	}
	return restwell_content_modified_latest_gmt(
		(string) $post->post_modified_gmt,
		(string) get_post_meta( $post->ID, RESTWELL_CONTENT_MODIFIED_META, true )
	);
}

/**
 * When a page's content last changed, as an ISO 8601 date in UK time.
 *
 * Drop-in for get_the_modified_date( 'c', $post ).
 *
 * @param int|WP_Post $post Post or ID.
 * @return string '' when the post doesn't exist.
 */
function restwell_content_modified_iso( $post ): string {
	$gmt = restwell_content_modified_gmt( $post );
	if ( '' === $gmt ) {
		return '';
	}
	$timestamp = strtotime( $gmt . ' UTC' );
	return false === $timestamp ? '' : wp_date( DATE_W3C, $timestamp );
}

/**
 * Sitemap entries carry the date the page's words last changed.
 *
 * @param array<string, string> $entry Sitemap entry (loc, lastmod).
 * @param WP_Post               $post  Post in the entry.
 * @return array<string, string>
 */
function restwell_sitemap_entry_content_lastmod( $entry, $post ) {
	if ( is_array( $entry ) && $post instanceof WP_Post ) {
		$lastmod = restwell_content_modified_iso( $post );
		if ( '' !== $lastmod ) {
			$entry['lastmod'] = $lastmod;
		}
	}
	return $entry;
}
add_filter( 'wp_sitemaps_posts_entry', 'restwell_sitemap_entry_content_lastmod', 10, 2 );
