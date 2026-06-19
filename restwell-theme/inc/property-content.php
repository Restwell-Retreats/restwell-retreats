<?php
/**
 * Property page content helpers (sections, room tour, glance summary).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Trim prose to a word count for room-tour blurbs.
 *
 * @param string $text Source text.
 * @param int    $max  Maximum words.
 * @return string
 */
function restwell_trim_words_prose( $text, $max = 55 ) {
	$text = trim( preg_replace( '/\s+/', ' ', wp_strip_all_tags( (string) $text ) ) );
	if ( $text === '' ) {
		return '';
	}
	$words = preg_split( '/\s+/', $text );
	if ( ! is_array( $words ) || count( $words ) <= $max ) {
		return $text;
	}
	return implode( ' ', array_slice( $words, 0, $max ) ) . '…';
}

/**
 * Room-by-room tour blocks (image + short blurb), drawn from verified section copy.
 *
 * @param int   $post_id     Property page ID.
 * @param array $gallery_ids Ordered gallery attachment IDs.
 * @return array<int, array{key:string, heading:string, body:string, image_id:int}>
 */
function restwell_get_property_room_tour_blocks( $post_id = 0, $gallery_ids = array() ) {
	$post_id     = (int) $post_id;
	$gallery_ids = array_values( array_filter( array_map( 'absint', (array) $gallery_ids ) ) );

	$d = restwell_get_property_page_defaults();
	$m = function ( $key ) use ( $post_id, $d ) {
		return restwell_post_meta_or_default( $post_id, $key, $d );
	};

	$tour_meta = array(
		array(
			'key'          => 'living',
			'heading_key'  => 'prop_living_heading',
			'body_key'     => 'prop_living_body',
			'image_key'    => 'prop_tour_living_image_id',
			'gallery_idx'  => 0,
		),
		array(
			'key'          => 'bedrooms',
			'heading_key'  => 'prop_bedrooms_section_heading',
			'body_key'     => 'prop_bedrooms_section_body',
			'image_key'    => 'prop_tour_bedroom_image_id',
			'gallery_idx'  => 1,
		),
		array(
			'key'          => 'wetroom',
			'heading_key'  => 'prop_wetroom_heading',
			'body_key'     => 'prop_wetroom_body',
			'image_key'    => 'prop_tour_wetroom_image_id',
			'gallery_idx'  => 2,
		),
		array(
			'key'          => 'garden',
			'heading_key'  => 'prop_garden_heading',
			'body_key'     => 'prop_garden_body',
			'image_key'    => 'prop_tour_garden_image_id',
			'gallery_idx'  => 3,
		),
	);

	$blocks = array();
	foreach ( $tour_meta as $slot ) {
		$heading = trim( (string) $m( $slot['heading_key'] ) );
		$body    = restwell_trim_words_prose( (string) $m( $slot['body_key'] ), 55 );
		if ( $heading === '' || $body === '' ) {
			continue;
		}
		$blocks[] = array(
			'key'      => $slot['key'],
			'heading'  => $heading,
			'body'     => $body,
			'image_id' => restwell_property_tour_image_id(
				(int) $m( $slot['image_key'] ),
				$gallery_ids,
				(int) $slot['gallery_idx']
			),
		);
	}

	return $blocks;
}

/**
 * Resolve a gallery image ID for a tour block (explicit ID or indexed fallback).
 *
 * @param int   $explicit_id Preferred attachment ID.
 * @param array $gallery_ids Full gallery set.
 * @param int   $index       Fallback index.
 * @return int
 */
function restwell_property_tour_image_id( $explicit_id, $gallery_ids, $index ) {
	$explicit_id = (int) $explicit_id;
	if ( $explicit_id > 0 && wp_attachment_is_image( $explicit_id ) ) {
		return $explicit_id;
	}
	$gallery_ids = array_values( array_filter( array_map( 'absint', (array) $gallery_ids ) ) );
	if ( isset( $gallery_ids[ $index ] ) ) {
		return (int) $gallery_ids[ $index ];
	}
	return 0;
}

/**
 * Build the practical "At a glance" summary from meta defaults.
 *
 * @param int $post_id Property page ID.
 * @return string
 */
function restwell_get_property_glance_summary( $post_id = 0 ) {
	$post_id = (int) $post_id;
	if ( $post_id <= 0 ) {
		$post_id = (int) get_the_ID();
	}

	$d = restwell_get_property_page_defaults();
	$m = function ( $key ) use ( $post_id, $d ) {
		return restwell_post_meta_or_default( $post_id, $key, $d );
	};

	$parts = array();
	for ( $fi = 1; $fi <= 8; $fi++ ) {
		$title = trim( (string) $m( "prop_feature_{$fi}" ) );
		$desc  = trim( (string) $m( "prop_feature_{$fi}_desc" ) );
		if ( $title === '' ) {
			continue;
		}
		$parts[] = $desc !== '' ? $title . ' (' . $desc . ')' : $title;
	}

	return implode( ', ', $parts );
}
