<?php
/**
 * Blog (post) categories: Restwell-specific labels and editor-facing descriptions.
 *
 * Used when seeding posts and when ensuring default terms exist. Keeps copy aligned
 * with accessible travel, Kent, funding, and the property, not generic “blog” buckets.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Canonical category definitions (slug => data).
 *
 * Slugs are stable for URLs and imports; names are shown in the theme and admin.
 *
 * @return array<string, array{name: string, description: string}>
 */
function restwell_get_blog_category_definitions() {
	/*
	 * Editorial split (avoid two “planning” buckets):
	 * - Care funding & respite = money, LA/CHC routes, DP/PHB, carer assessments (statutory / budgets).
	 * - Property & suitability = access specs, checklists, choosing a place (place quality, not funding).
	 * Legacy terms such as “Planning” or “Funding & planning” in the database can be merged or
	 * retitled in Posts → Categories; new installs only get these four.
	 */
	return array(
		'kent-coast' => array(
			'name'        => __( 'Kent & coast', 'restwell-retreats' ),
			'description' => __( 'Practical guides to Whitstable, Herne Bay, Broadstairs, and the wider Kent coast — written with wheelchair users and carers in mind. Covers accessible beaches and promenades, getting around by car and bus, day trips to Canterbury and Faversham, and what to know about tide times, terrain, and parking before you travel.', 'restwell-retreats' ),
		),
		'funding-care' => array(
			'name'        => __( 'Care funding & respite', 'restwell-retreats' ),
			'description' => __( 'Plain-English guides to funding a supported break: direct payments, personal health budgets, Continuing Healthcare (CHC), local authority respite routes, and carer assessments under the Care Act. Explains what counts as care versus accommodation, what to discuss with your social worker, and how to plan a short break that your budget can cover.', 'restwell-retreats' ),
		),
		'accessible-holidays' => array(
			'name'        => __( 'Property & suitability', 'restwell-retreats' ),
			'description' => __( 'How to choose and verify an accessible self-catering property before you book. Covers ceiling track hoist specifications, wet room dimensions, door widths, turning circles, bedroom layouts, and the red flags to look for in listings. Includes checklists and questions to put to operators so you can assess a property honestly against your needs.', 'restwell-retreats' ),
		),
		'news-updates' => array(
			'name'        => __( 'News & sector updates', 'restwell-retreats' ),
			'description' => __( 'Accessible travel and care sector news: charity closures and what they mean for people planning breaks, policy changes affecting respite and short-break funding, and updates on organisations relevant to disabled travellers and unpaid carers in the UK.', 'restwell-retreats' ),
		),
	);
}

/**
 * Resolve a category slug to its display name, or pass through unknown strings (legacy).
 *
 * @param string $slug_or_name Category slug from definitions, or legacy full name.
 * @return string
 */
function restwell_get_blog_category_name( $slug_or_name ) {
	$slug_or_name = (string) $slug_or_name;
	$defs         = restwell_get_blog_category_definitions();
	if ( isset( $defs[ $slug_or_name ]['name'] ) ) {
		return $defs[ $slug_or_name ]['name'];
	}
	return $slug_or_name;
}

/**
 * Return footer-friendly blog categories:
 * - Use canonical Restwell categories only (show all configured categories).
 *
 * @param int $limit Maximum number of categories.
 * @return array<int, WP_Term>
 */
function restwell_get_footer_blog_categories( $limit = 4 ) {
	$limit      = max( 1, (int) $limit );
	$defs       = restwell_get_blog_category_definitions();
	$categories = array();

	foreach ( array_keys( $defs ) as $slug ) {
		$term = get_term_by( 'slug', $slug, 'category' );
		if ( ! $term || is_wp_error( $term ) ) {
			continue;
		}
		$term = get_term( (int) $term->term_id, 'category' );
		if ( ! $term || is_wp_error( $term ) ) {
			continue;
		}
		$categories[] = $term;
		if ( count( $categories ) >= $limit ) {
			break;
		}
	}

	return $categories;
}

/**
 * Return canonical Restwell category term IDs.
 *
 * @return array<int>
 */
function restwell_get_canonical_blog_category_ids() {
	$ids = array();
	foreach ( array_keys( restwell_get_blog_category_definitions() ) as $slug ) {
		$term = get_term_by( 'slug', $slug, 'category' );
		if ( ! $term || is_wp_error( $term ) ) {
			continue;
		}
		$ids[] = (int) $term->term_id;
	}
	return $ids;
}

/**
 * Ensure all contextual categories exist (idempotent; safe to run on init).
 *
 * @return void
 */
function restwell_ensure_default_blog_categories() {
	if ( ! is_blog_installed() ) {
		return;
	}
	if ( ! function_exists( 'term_exists' ) || ! function_exists( 'wp_insert_term' ) ) {
		return;
	}
	foreach ( restwell_get_blog_category_definitions() as $slug => $data ) {
		$existing = get_term_by( 'slug', $slug, 'category' );
		if ( $existing && ! is_wp_error( $existing ) ) {
			if ( $existing->name !== $data['name'] || $existing->description !== $data['description'] ) {
				wp_update_term(
					(int) $existing->term_id,
					'category',
					array(
						'name'        => $data['name'],
						'description' => $data['description'],
					)
				);
			}
			continue;
		}
		$insert = wp_insert_term(
			$data['name'],
			'category',
			array(
				'slug'        => $slug,
				'description' => $data['description'],
			)
		);
		if ( is_wp_error( $insert ) && 'term_exists' === $insert->get_error_code() ) {
			continue;
		}
	}
}

/**
 * Explicit category mapping for pre-populated seeded blog posts.
 *
 * We do NOT auto-classify new posts. This only assigns known seeded slugs once.
 *
 * @return array<string, string> post_slug => category_slug
 */
function restwell_get_seeded_post_category_map() {
	return array(
		'accessible-beaches-coastal-walks-kent'      => 'kent-coast',
		'direct-payment-holiday-accommodation'       => 'funding-care',
		'revitalise-alternatives-accessible-holidays' => 'news-updates',
		'how-to-choose-accessible-self-catering-holiday' => 'accessible-holidays',
		'carers-respite-holiday-guide'               => 'funding-care',
	);
}

/**
 * One-time assignment for seeded posts only.
 *
 * @return void
 */
function restwell_assign_seeded_posts_to_categories_once() {
	if ( ! is_admin() ) {
		return;
	}
	if ( get_option( 'restwell_seeded_posts_categorised', '' ) === '1' ) {
		return;
	}

	$defs = restwell_get_blog_category_definitions();
	foreach ( restwell_get_seeded_post_category_map() as $post_slug => $category_slug ) {
		$post = get_page_by_path( $post_slug, OBJECT, 'post' );
		if ( ! $post || empty( $defs[ $category_slug ] ) ) {
			continue;
		}

		$term = get_term_by( 'slug', $category_slug, 'category' );
		if ( ! $term || is_wp_error( $term ) ) {
			continue;
		}

		$current_ids = wp_get_post_categories( (int) $post->ID );
		if ( empty( $current_ids ) ) {
			$current_ids = array();
		}
		$current_ids = array_map( 'intval', $current_ids );
		$current_ids = array_values( array_diff( $current_ids, array( 1 ) ) ); // Remove Uncategorized only.

		if ( ! in_array( (int) $term->term_id, $current_ids, true ) ) {
			$current_ids[] = (int) $term->term_id;
		}
		wp_set_post_categories( (int) $post->ID, array_values( array_unique( $current_ids ) ), false );
	}

	update_option( 'restwell_seeded_posts_categorised', '1' );
}

add_action( 'init', 'restwell_ensure_default_blog_categories', 20 );
add_action( 'admin_init', 'restwell_assign_seeded_posts_to_categories_once', 25 );
