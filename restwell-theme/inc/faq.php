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
		$items_out = function_exists( 'restwell_apply_property_facts_to_faq_items' )
			? restwell_apply_property_facts_to_faq_items( $items )
			: $items;
		return apply_filters( 'restwell_faq_items', $items_out, $scope, 0 );
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
		// How It Works uses its own distinct FAQ set to avoid duplicate content with the FAQ page.
		$hiw_items = array();
		foreach ( restwell_get_how_it_works_faq_defaults() as $row ) {
			$hiw_items[] = array(
				'q'   => $row['q'],
				'a'   => $row['a'],
				'cat' => isset( $row['cat'] ) ? $row['cat'] : 'booking',
			);
		}
		$items = $hiw_items;
	}

	/**
	 * Filter FAQ items returned for a given scope.
	 *
	 * @param array<int, array{q:string,a:string,cat:string,answer_text?:string}> $items  Items.
	 * @param string                                                             $scope  Scope key.
	 * @param int                                                                $pid    FAQ page ID.
	 */
	$items_out = function_exists( 'restwell_apply_property_facts_to_faq_items' )
		? restwell_apply_property_facts_to_faq_items( $items )
		: $items;
	return apply_filters( 'restwell_faq_items', $items_out, $scope, $pid );
}

/**
 * Default FAQ items for the How It Works page.
 *
 * Distinct from the FAQ page set to prevent duplicate-content cannibalisation.
 * Both template rendering and JSON-LD must read from this same function.
 *
 * @return array<int, array{q: string, a: string, cat: string}>
 */
function restwell_get_how_it_works_faq_defaults(): array {
	return array(
		array(
			'q'   => __( 'How do I book a stay?', 'restwell-retreats' ),
			'a'   => __( 'Start with an enquiry through the website or by phone. We confirm availability and what you need, then hold your dates.', 'restwell-retreats' ),
			'cat' => 'booking',
		),
		array(
			'q'   => __( 'When can care be added?', 'restwell-retreats' ),
			// Confirm in WP: how far ahead to request care.
			'a'   => __( 'Care can be arranged when you book or added later, subject to availability.', 'restwell-retreats' ),
			'cat' => 'care',
		),
		array(
			'q'   => __( 'How can I pay?', 'restwell-retreats' ),
			'a'   => __( 'Many guests use direct payments or a personal budget. See the Funding and Support page for the options.', 'restwell-retreats' ),
			'cat' => 'funding',
		),
		array(
			'q'   => __( 'Can a local authority, case manager or NHS team book for me?', 'restwell-retreats' ),
			'a'   => __( 'Yes. Funded bookings are welcome, and funders can confirm a booking with a purchase order on the same payment timeline as every guest.', 'restwell-retreats' ),
			'cat' => 'funding',
		),
	);
}
