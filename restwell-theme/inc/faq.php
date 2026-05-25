<?php
/**
 * FAQ helpers.
 *
 * Homepage scope: Git-managed defaults in inc/homepage-faq.php (see
 * restwell_get_homepage_faq_defaults()).
 *
 * FAQ page and How It Works scopes: canonical FAQ template page meta
 * `faq_{N}_q`, `faq_{N}_a`, and `faq_{N}_cat` (up to 14 items).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return the post ID of the page using template-faq.php, or 0 if not found.
 *
 * Result is cached in a static variable to avoid repeated DB queries per
 * request.
 *
 * @return int
 */
function restwell_get_faq_page_id(): int {
	static $faq_page_id = null;
	if ( null !== $faq_page_id ) {
		return $faq_page_id;
	}

	$pages = get_pages(
		array(
			'meta_key'   => '_wp_page_template',
			'meta_value' => 'template-faq.php',
			'number'     => 1,
		)
	);

	$faq_page_id = ( ! empty( $pages ) ) ? (int) $pages[0]->ID : 0;
	return $faq_page_id;
}

/**
 * Retrieve FAQ items for a given scope.
 *
 * @param string $scope  One of 'faq-page', 'homepage', 'how-it-works'.
 * @return array<int, array{q: string, a: string, cat: string, answer_text?: string}>
 *         Each item has 'q' (question), 'a' (answer HTML for templates),
 *         'cat' (category slug), and optional 'answer_text' (plain text for JSON-LD).
 */
function restwell_get_faq_items( string $scope = 'faq-page' ): array {
	if ( 'homepage' === $scope && function_exists( 'restwell_get_homepage_faq_defaults' ) ) {
		$items = array();
		foreach ( restwell_get_homepage_faq_defaults() as $row ) {
			$items[] = array(
				'q'           => $row['question'],
				'a'           => $row['answer_html'],
				'answer_text' => $row['answer_text'],
				'cat'         => isset( $row['cat'] ) ? $row['cat'] : 'about',
			);
		}

		/**
		 * Filter homepage FAQ items (code defaults).
		 *
		 * @param array<int, array{q:string,a:string,cat:string,answer_text:string}> $items  Items.
		 * @param string                                                             $scope  Scope key.
		 * @param int                                                                $pid    FAQ page ID (0 for homepage).
		 */
		return apply_filters( 'restwell_faq_items', $items, $scope, 0 );
	}

	$pid = restwell_get_faq_page_id();

	$items = array();

	if ( $pid > 0 ) {
		for ( $i = 1; $i <= 14; $i++ ) {
			$q   = (string) get_post_meta( $pid, "faq_{$i}_q", true );
			$a   = (string) get_post_meta( $pid, "faq_{$i}_a", true );
			$cat = (string) get_post_meta( $pid, "faq_{$i}_cat", true );
			if ( $q !== '' && $a !== '' ) {
				$items[] = array(
					'q'   => $q,
					'a'   => $a,
					'cat' => $cat !== '' ? $cat : 'about',
				);
			}
		}
	}

	// Fall back to static defaults if the FAQ page has no saved content yet.
	if ( empty( $items ) && function_exists( 'restwell_get_faq_page_default_pairs' ) ) {
		foreach ( restwell_get_faq_page_default_pairs() as $row ) {
			$items[] = array(
				'q'   => $row['q'],
				'a'   => $row['a'],
				'cat' => isset( $row['cat'] ) ? $row['cat'] : 'about',
			);
		}
	}

	if ( 'how-it-works' === $scope ) {
		// How It Works shows the first 7 items from the FAQ page.
		$items = array_slice( $items, 0, 7 );
	}

	/**
	 * Filter FAQ items returned for a given scope.
	 *
	 * @param array<int, array{q:string,a:string,cat:string,answer_text?:string}> $items  Items.
	 * @param string                                                             $scope  Scope key.
	 * @param int                                                                $pid    FAQ page ID.
	 */
	return apply_filters( 'restwell_faq_items', $items, $scope, $pid );
}
