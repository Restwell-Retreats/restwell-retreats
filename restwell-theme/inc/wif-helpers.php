<?php
/**
 * Who It's For page copy helpers (bullets, paragraph reflow).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Parse newline-separated bullet list from post meta with fallback defaults.
 *
 * @param int    $post_id Post ID.
 * @param string $meta_key Meta key.
 * @param array  $default_bullets Default bullets.
 * @return array<int, string>
 */
function restwell_wif_bullet_list( $post_id, $meta_key, array $default_bullets ) {
	$raw = get_post_meta( $post_id, $meta_key, true );
	if ( ! is_string( $raw ) || '' === trim( $raw ) ) {
		return $default_bullets;
	}
	$lines = array_filter( array_map( 'trim', explode( "\n", str_replace( "\r\n", "\n", $raw ) ) ) );
	return ! empty( $lines ) ? array_values( $lines ) : $default_bullets;
}

/**
 * Who It's For: main intro paragraph, with optional fallback to legacy detail_body meta.
 *
 * @param int    $post_id     Post ID.
 * @param string $primary_key Main body field.
 * @param string $legacy_key  Former detail_body field (used only when primary is empty).
 * @param string $default     Default copy when both are empty.
 */
function restwell_wif_persona_intro_body( $post_id, $primary_key, $legacy_key, $default ) {
	$primary = get_post_meta( $post_id, $primary_key, true );
	if ( is_string( $primary ) && '' !== trim( $primary ) ) {
		return $primary;
	}
	$legacy = get_post_meta( $post_id, $legacy_key, true );
	if ( is_string( $legacy ) && '' !== trim( $legacy ) ) {
		return $legacy;
	}
	return $default;
}

/**
 * Split English prose into sentences (period / ? / ! followed by space and new sentence).
 *
 * @param string $text Paragraph text.
 * @return array<int, string>
 */
function restwell_wif_split_sentences( $text ) {
	$text = trim( $text );
	if ( '' === $text ) {
		return array();
	}
	// Split after . ? ! when followed by whitespace and a typical sentence start.
	$parts = preg_split( '/(?<=[.!?])\s+(?=[A-Z"\'])/u', $text, -1, PREG_SPLIT_NO_EMPTY );
	if ( ! is_array( $parts ) || count( $parts ) <= 1 ) {
		return array( $text );
	}
	return array_values( array_map( 'trim', $parts ) );
}

/**
 * Group sentences into short paragraphs for mobile readability (2 sentences each).
 *
 * @param array<int, string> $sentences Sentence strings.
 * @param int                $per_block Max sentences per block.
 * @return array<int, string>
 */
function restwell_wif_group_sentences_into_blocks( array $sentences, $per_block = 2 ) {
	if ( empty( $sentences ) ) {
		return array();
	}
	$per_block = max( 1, (int) $per_block );
	$out       = array();
	$buffer    = array();
	foreach ( $sentences as $s ) {
		$buffer[] = $s;
		if ( count( $buffer ) >= $per_block ) {
			$out[]  = implode( ' ', $buffer );
			$buffer = array();
		}
	}
	if ( ! empty( $buffer ) ) {
		$out[] = implode( ' ', $buffer );
	}
	return $out;
}

/**
 * If a block is still one long string, break it into smaller paragraphs for scanning.
 *
 * @param string $block Single paragraph.
 * @param int    $max_chars Reflow when longer than this (UTF-8 safe via mbstring if available).
 * @return array<int, string>
 */
function restwell_wif_reflow_dense_paragraph( $block, $max_chars = 280 ) {
	$block = trim( $block );
	if ( '' === $block ) {
		return array();
	}
	$len = function_exists( 'mb_strlen' ) ? mb_strlen( $block ) : strlen( $block );
	if ( $len <= $max_chars ) {
		return array( $block );
	}
	$sentences = restwell_wif_split_sentences( $block );
	if ( count( $sentences ) <= 1 ) {
		return array( $block );
	}
	return restwell_wif_group_sentences_into_blocks( $sentences, 2 );
}

/**
 * Split persona body copy into paragraphs (blank line in editor / meta), then reflow very long blocks.
 *
 * @param string $text Raw body text.
 * @return array<int, string>
 */
function restwell_wif_split_body_paragraphs( $text ) {
	if ( ! is_string( $text ) || '' === trim( $text ) ) {
		return array();
	}
	$normalized = str_replace( array( "\r\n", "\r" ), "\n", $text );
	$parts      = preg_split( '/\n\s*\n/', $normalized );
	if ( ! is_array( $parts ) ) {
		$parts = array( $text );
	}
	$parts = array_map( 'trim', $parts );
	$parts = array_filter( $parts );
	$parts = array_values( $parts );

	$out = array();
	foreach ( $parts as $part ) {
		$chunked = restwell_wif_reflow_dense_paragraph( $part );
		foreach ( $chunked as $c ) {
			$out[] = $c;
		}
	}
	return $out;
}
