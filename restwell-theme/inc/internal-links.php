<?php
/**
 * Pillar ↔ cluster internal linking map (single source of truth).
 *
 * Relationships are derived from post categories (see inc/blog-categories.php).
 * Do not hardcode post IDs here.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Pillar page slug => cluster category slug.
 *
 * - The Property → accessible-holidays (Property & suitability)
 * - Resources → funding-care (Care funding & respite)
 * - Whitstable Area Guide → kent-coast (Kent & coast)
 * - news-updates (News & sector updates) links up to The Property (see restwell_get_pillar_for_category).
 *
 * @return array<string, string>
 */
function restwell_get_pillar_cluster_map() {
	return array(
		'the-property'          => 'accessible-holidays',
		'funding-and-support'   => 'funding-care',
		'whitstable-area-guide' => 'kent-coast',
	);
}

/**
 * Display titles for pillar hubs.
 *
 * @return array<string, string>
 */
function restwell_get_pillar_titles() {
	return array(
		'the-property'          => __( 'The Property', 'restwell-retreats' ),
		'funding-and-support'   => __( 'Funding & Support', 'restwell-retreats' ),
		'whitstable-area-guide' => __( 'Whitstable Area Guide', 'restwell-retreats' ),
	);
}

/**
 * Resolve which pillar owns a blog category.
 *
 * @param string $category_slug Category slug.
 * @return string Pillar page slug, or empty string when unmapped.
 */
function restwell_get_pillar_for_category( $category_slug ) {
	$category_slug = sanitize_title( (string) $category_slug );
	if ( '' === $category_slug ) {
		return '';
	}

	// News & sector updates (Revitalise alternatives) link up to The Property.
	if ( 'news-updates' === $category_slug ) {
		return 'the-property';
	}

	$map = restwell_get_pillar_cluster_map();
	foreach ( $map as $pillar_slug => $cluster_slug ) {
		if ( $cluster_slug === $category_slug ) {
			return $pillar_slug;
		}
	}

	return '';
}

/**
 * Category slug owned by a pillar (empty when unknown).
 *
 * @param string $pillar_slug Pillar page slug.
 * @return string
 */
function restwell_get_cluster_category_for_pillar( $pillar_slug ) {
	$pillar_slug = sanitize_title( (string) $pillar_slug );
	if ( 'resources' === $pillar_slug ) {
		$pillar_slug = 'funding-and-support';
	}
	$map = restwell_get_pillar_cluster_map();
	return isset( $map[ $pillar_slug ] ) ? $map[ $pillar_slug ] : '';
}

/**
 * Permalink for a published page by path slug, or empty when missing.
 *
 * @param string $slug Page path slug.
 * @return string
 */
function restwell_get_published_page_url( $slug ) {
	$slug = sanitize_title( (string) $slug );
	if ( '' === $slug ) {
		return '';
	}

	$page = function_exists( 'restwell_get_page_by_nav_slug' )
		? restwell_get_page_by_nav_slug( $slug )
		: get_page_by_path( $slug, OBJECT, 'page' );
	if ( $page && 'publish' === $page->post_status ) {
		return (string) get_permalink( $page );
	}
	return '';
}

/**
 * Pillar permalink (falls back to home_url path when the page is not yet seeded).
 *
 * @param string $pillar_slug Pillar page slug.
 * @return string
 */
function restwell_get_pillar_url( $pillar_slug ) {
	$pillar_slug = sanitize_title( (string) $pillar_slug );
	$url         = restwell_get_published_page_url( $pillar_slug );
	if ( $url !== '' ) {
		return $url;
	}
	if ( isset( restwell_get_pillar_cluster_map()[ $pillar_slug ] ) ) {
		return home_url( '/' . $pillar_slug . '/' );
	}
	return '';
}

/**
 * Published posts in a pillar's cluster category.
 *
 * @param string $pillar_slug Pillar page slug (e.g. the-property).
 * @param int    $limit       Max posts (0 = no limit).
 * @return WP_Post[]
 */
function restwell_get_cluster_posts( $pillar_slug, $limit = 0 ) {
	$pillar_slug = sanitize_title( (string) $pillar_slug );
	$cat_slug    = restwell_get_cluster_category_for_pillar( $pillar_slug );
	if ( '' === $cat_slug ) {
		return array();
	}

	$term = get_term_by( 'slug', $cat_slug, 'category' );
	if ( ! $term || is_wp_error( $term ) ) {
		return array();
	}

	$args = array(
		'post_type'              => 'post',
		'post_status'            => 'publish',
		'posts_per_page'         => $limit > 0 ? absint( $limit ) : -1,
		'orderby'                => 'title',
		'order'                  => 'ASC',
		'no_found_rows'          => true,
		'update_post_meta_cache' => false,
		'update_post_term_cache' => false,
		'tax_query'              => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query -- intentional category filter.
			array(
				'taxonomy' => 'category',
				'field'    => 'term_id',
				'terms'    => array( (int) $term->term_id ),
			),
		),
	);

	$query = new WP_Query( $args );
	$posts = $query->posts ? $query->posts : array();
	wp_reset_postdata();

	return is_array( $posts ) ? $posts : array();
}

/**
 * Primary (non-Uncategorized) category for a post.
 *
 * @param int $post_id Post ID.
 * @return WP_Term|null
 */
function restwell_get_post_cluster_term( $post_id ) {
	$post_id = absint( $post_id );
	if ( ! $post_id ) {
		return null;
	}
	$cats = get_the_category( $post_id );
	if ( empty( $cats ) ) {
		return null;
	}
	foreach ( $cats as $cat ) {
		if ( 'uncategorized' !== $cat->slug ) {
			return $cat;
		}
	}
	return null;
}

/**
 * Sibling posts in the same cluster (exclude current).
 *
 * @param int $post_id Post ID.
 * @param int $limit   Number of siblings (default 3).
 * @return WP_Post[]
 */
function restwell_get_cluster_sibling_posts( $post_id, $limit = 3 ) {
	$post_id = absint( $post_id );
	$limit   = max( 1, absint( $limit ) );
	$term    = restwell_get_post_cluster_term( $post_id );
	if ( ! $term ) {
		return array();
	}

	$query = new WP_Query(
		array(
			'post_type'              => 'post',
			'post_status'            => 'publish',
			'posts_per_page'         => $limit,
			'post__not_in'           => array( $post_id ),
			'orderby'                => 'date',
			'order'                  => 'DESC',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			'tax_query'              => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
				array(
					'taxonomy' => 'category',
					'field'    => 'term_id',
					'terms'    => array( (int) $term->term_id ),
				),
			),
		)
	);

	$posts = $query->posts ? $query->posts : array();
	wp_reset_postdata();

	return is_array( $posts ) ? $posts : array();
}

/**
 * Conversion page link rows (pricing / dates / enquire) when the page is published.
 *
 * @return array<int, array{url: string, label: string, slug: string}>
 */
function restwell_get_conversion_link_items() {
	$defs = array(
		array(
			'slug'  => 'pricing',
			'label' => __( 'Accessible holiday pricing in Whitstable', 'restwell-retreats' ),
		),
		// TODO(dates): re-enable when /dates/ ships. Until then restwell_get_published_page_url() skips it.
		array(
			'slug'  => 'dates',
			'label' => __( 'Check stay dates and availability', 'restwell-retreats' ),
		),
		array(
			'slug'  => 'enquire',
			'label' => __( 'Enquire about a Restwell stay', 'restwell-retreats' ),
		),
	);

	$items = array();
	foreach ( $defs as $def ) {
		$url = restwell_get_published_page_url( $def['slug'] );
		if ( '' === $url && 'enquire' === $def['slug'] ) {
			$url = function_exists( 'restwell_nav_resolve_page_url' )
				? restwell_nav_resolve_page_url( 'enquire' )
				: home_url( '/enquire/' );
		}
		// Keep reserved Job 11 / dates destinations discoverable once published;
		// until then only emit enquire so we do not invent pages or soft-404 links.
		if ( '' === $url ) {
			continue;
		}
		$items[] = array(
			'slug'  => $def['slug'],
			'url'   => $url,
			'label' => $def['label'],
		);
	}

	return $items;
}

/**
 * Cross-links shown on the pricing page (Job 11) once that page exists.
 *
 * @return array<int, array{url: string, label: string}>
 */
function restwell_get_pricing_cross_link_items() {
	$rows = array(
		array(
			'slug'  => 'the-property',
			'label' => __( 'Tour the adapted Whitstable bungalow', 'restwell-retreats' ),
		),
		array(
			'slug'  => 'accessibility',
			'label' => __( 'Read the accessibility measurements and equipment', 'restwell-retreats' ),
		),
		array(
			'slug'  => 'how-it-works',
			'label' => __( 'See how booking an accessible stay works', 'restwell-retreats' ),
		),
		array(
			'slug'  => 'funding-and-support',
			'label' => __( 'Explore care funding and respite routes', 'restwell-retreats' ),
		),
		// TODO(dates): restore when /dates/ ships (currently unpublished; skipped below).
		array(
			'slug'  => 'dates',
			'label' => __( 'Check stay dates and availability', 'restwell-retreats' ),
		),
		array(
			'slug'  => 'enquire',
			'label' => __( 'Send an enquiry about your stay', 'restwell-retreats' ),
		),
	);

	// Funding cluster guides also belong on the pricing hub.
	$funding_posts = restwell_get_cluster_posts( 'funding-and-support' );
	foreach ( $funding_posts as $post ) {
		if ( ! $post instanceof WP_Post ) {
			continue;
		}
		$rows[] = array(
			'url'   => get_permalink( $post ),
			'label' => get_the_title( $post ),
		);
	}

	$items = array();
	foreach ( $rows as $row ) {
		if ( isset( $row['url'] ) ) {
			$url = (string) $row['url'];
		} else {
			$url = restwell_get_published_page_url( $row['slug'] );
			if ( '' === $url && ! empty( $row['slug'] ) ) {
				// Known pillars / conversion: allow path fallback for seeded hubs.
				$known = array( 'the-property', 'accessibility', 'how-it-works', 'funding-and-support', 'resources', 'enquire' );
				if ( in_array( $row['slug'], $known, true ) ) {
					$url = function_exists( 'restwell_nav_resolve_page_url' )
						? restwell_nav_resolve_page_url( $row['slug'] )
						: home_url( '/' . $row['slug'] . '/' );
				}
			}
		}
		if ( '' === $url ) {
			continue;
		}
		$items[] = array(
			'url'   => $url,
			'label' => $row['label'],
		);
	}

	return $items;
}

/**
 * Sibling pillar link rows with varied anchors (exclude current pillar).
 *
 * @param string $current_pillar_slug Current pillar slug.
 * @return array<int, array{url: string, label: string}>
 */
function restwell_get_sibling_pillar_link_items( $current_pillar_slug = '' ) {
	$current_pillar_slug = sanitize_title( (string) $current_pillar_slug );
	$titles              = restwell_get_pillar_titles();

	$anchors = array(
		'the-property'          => __( 'See the adapted bungalow and how the stay works', 'restwell-retreats' ),
		'funding-and-support'   => __( 'Find care funding and respite routes for a short break', 'restwell-retreats' ),
		'whitstable-area-guide' => __( 'Plan around Whitstable and the Kent coast', 'restwell-retreats' ),
	);

	$items = array();
	foreach ( array_keys( restwell_get_pillar_cluster_map() ) as $slug ) {
		if ( $slug === $current_pillar_slug ) {
			continue;
		}
		$url = restwell_get_pillar_url( $slug );
		if ( '' === $url ) {
			continue;
		}
		$items[] = array(
			'url'   => $url,
			'label' => isset( $anchors[ $slug ] ) ? $anchors[ $slug ] : ( isset( $titles[ $slug ] ) ? $titles[ $slug ] : $slug ),
		);
	}

	return $items;
}

/**
 * Echo the Related guides module for a pillar page.
 *
 * @param string               $pillar_slug Pillar page slug.
 * @param array<string, mixed> $args        Optional: heading, intro, show_siblings, show_conversion.
 * @return void
 */
function restwell_render_pillar_related_guides( $pillar_slug, $args = array() ) {
	$pillar_slug = sanitize_title( (string) $pillar_slug );
	$posts       = restwell_get_cluster_posts( $pillar_slug );

	// News & sector updates (e.g. Revitalise alternatives) also list on The Property.
	if ( 'the-property' === $pillar_slug ) {
		$seen = array();
		foreach ( $posts as $p ) {
			if ( $p instanceof WP_Post ) {
				$seen[ (int) $p->ID ] = true;
			}
		}
		foreach ( restwell_get_news_updates_posts_for_property() as $news_post ) {
			if ( ! $news_post instanceof WP_Post ) {
				continue;
			}
			if ( isset( $seen[ (int) $news_post->ID ] ) ) {
				continue;
			}
			$posts[] = $news_post;
		}
	}

	$siblings   = ! empty( $args['show_siblings'] ) ? restwell_get_sibling_pillar_link_items( $pillar_slug ) : array();
	$conversion = ! empty( $args['show_conversion'] ) ? restwell_get_conversion_link_items() : array();

	if ( empty( $posts ) && empty( $siblings ) && empty( $conversion ) ) {
		return;
	}

	$heading = isset( $args['heading'] ) ? (string) $args['heading'] : __( 'Related guides', 'restwell-retreats' );
	$intro   = isset( $args['intro'] ) ? (string) $args['intro'] : '';
	$hid     = isset( $args['heading_id'] ) ? (string) $args['heading_id'] : 'restwell-related-guides-heading';

	$cat_slug = restwell_get_cluster_category_for_pillar( $pillar_slug );
	$cat_term = $cat_slug ? get_term_by( 'slug', $cat_slug, 'category' ) : null;
	$cat_url  = ( $cat_term && ! is_wp_error( $cat_term ) ) ? get_category_link( (int) $cat_term->term_id ) : '';

	set_query_var(
		'restwell_related_guides',
		array(
			'heading'     => $heading,
			'intro'       => $intro,
			'heading_id'  => $hid,
			'posts'       => $posts,
			'siblings'    => $siblings,
			'conversion'  => $conversion,
			'category_url'=> ( ! is_wp_error( $cat_url ) ) ? (string) $cat_url : '',
			'category_name' => ( $cat_term && ! is_wp_error( $cat_term ) ) ? $cat_term->name : '',
		)
	);
	get_template_part( 'template-parts/related-guides' );
}

/**
 * Echo Part of + sibling cluster links on a single post.
 *
 * @param int $post_id Post ID.
 * @return void
 */
function restwell_render_post_cluster_links( $post_id ) {
	$post_id = absint( $post_id );
	if ( ! $post_id ) {
		return;
	}

	$term        = restwell_get_post_cluster_term( $post_id );
	$pillar_slug = $term ? restwell_get_pillar_for_category( $term->slug ) : '';
	$pillar_url  = $pillar_slug ? restwell_get_pillar_url( $pillar_slug ) : '';
	$pillar_title = '';
	if ( $pillar_slug ) {
		$titles       = restwell_get_pillar_titles();
		$pillar_title = isset( $titles[ $pillar_slug ] ) ? $titles[ $pillar_slug ] : $pillar_slug;
	}

	$siblings = restwell_get_cluster_sibling_posts( $post_id, 3 );

	// Funding cluster posts also need conversion reachability.
	$conversion = array();
	if ( $term && 'funding-care' === $term->slug ) {
		$conversion = restwell_get_conversion_link_items();
	}

	if ( '' === $pillar_url && empty( $siblings ) && empty( $conversion ) ) {
		return;
	}

	set_query_var(
		'restwell_post_cluster_links',
		array(
			'pillar_url'   => $pillar_url,
			'pillar_title' => $pillar_title,
			'siblings'     => $siblings,
			'conversion'   => $conversion,
		)
	);
	get_template_part( 'template-parts/post-cluster-links' );
}

/**
 * Echo pricing page cross-links (for Job 11 template or page.php injection).
 *
 * @return void
 */
function restwell_render_pricing_cross_links() {
	$items = restwell_get_pricing_cross_link_items();
	if ( empty( $items ) ) {
		return;
	}
	set_query_var( 'restwell_pricing_cross_links', $items );
	get_template_part( 'template-parts/pricing-cross-links' );
}

/**
 * Inject pricing cross-links when viewing a published /pricing/ page that does
 * not use template-pricing.php (legacy fallback).
 *
 * @param string $content Post content.
 * @return string
 */
function restwell_append_pricing_cross_links( $content ) {
	if ( is_admin() || ! is_singular( 'page' ) || ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}
	$page = get_queried_object();
	if ( ! $page instanceof WP_Post || 'pricing' !== $page->post_name ) {
		return $content;
	}
	if ( 'template-pricing.php' === get_page_template_slug( $page ) ) {
		return $content;
	}
	ob_start();
	restwell_render_pricing_cross_links();
	$extra = ob_get_clean();
	return $content . $extra;
}
add_filter( 'the_content', 'restwell_append_pricing_cross_links', 25 );

/**
 * Whether a published page/post should be excluded from the orphan audit.
 *
 * Guest Guide stays noindex by design; deliberately hidden URLs are not orphans.
 *
 * @param WP_Post $post Post object.
 * @return bool
 */
function restwell_orphan_audit_exclude_post( $post ) {
	if ( ! $post instanceof WP_Post ) {
		return true;
	}
	if ( (bool) get_post_meta( $post->ID, 'meta_noindex', true ) ) {
		return true;
	}
	if ( 'page' === $post->post_type && 'page-guest-guide.php' === get_page_template_slug( $post ) ) {
		return true;
	}
	return false;
}

/**
 * Normalise an internal URL to a comparable path key (trailing slash, no query/hash).
 *
 * @param string $url Absolute or root-relative URL.
 * @return string Path with trailing slash, or empty when external/invalid.
 */
function restwell_orphan_audit_path_key( $url ) {
	$url = trim( (string) $url );
	if ( '' === $url || 0 === strpos( $url, '#' ) || 0 === strpos( $url, 'mailto:' ) || 0 === strpos( $url, 'tel:' ) ) {
		return '';
	}

	$home = home_url( '/' );
	$home_host = wp_parse_url( $home, PHP_URL_HOST );
	$home_path = (string) wp_parse_url( $home, PHP_URL_PATH );
	$home_path = untrailingslashit( $home_path );

	if ( 0 === strpos( $url, '/' ) && 0 !== strpos( $url, '//' ) ) {
		$path = $url;
	} else {
		$parts = wp_parse_url( $url );
		if ( empty( $parts['host'] ) ) {
			return '';
		}
		if ( strtolower( (string) $parts['host'] ) !== strtolower( (string) $home_host ) ) {
			return '';
		}
		$path = isset( $parts['path'] ) ? (string) $parts['path'] : '/';
	}

	$path = preg_replace( '#\?.*$#', '', $path );
	$path = preg_replace( '/#.*$/', '', $path );
	if ( $home_path !== '' && 0 === strpos( $path, $home_path ) ) {
		$path = substr( $path, strlen( $home_path ) );
		if ( '' === $path ) {
			$path = '/';
		}
	}
	if ( '' === $path || '/' !== $path[0] ) {
		$path = '/' . ltrim( (string) $path, '/' );
	}

	return trailingslashit( $path );
}

/**
 * Collect inbound path keys from a blob of HTML.
 *
 * @param string               $html HTML.
 * @param array<string, bool>  $into Map path => true (by reference).
 * @return void
 */
function restwell_orphan_audit_collect_hrefs( $html, &$into ) {
	if ( ! is_string( $html ) || '' === $html ) {
		return;
	}
	if ( ! preg_match_all( '/<a\s[^>]*href\s*=\s*([\"\'])(.*?)\1/i', $html, $matches ) ) {
		return;
	}
	foreach ( $matches[2] as $href ) {
		$key = restwell_orphan_audit_path_key( $href );
		if ( '' !== $key ) {
			$into[ $key ] = true;
		}
	}
}

/**
 * Structural inbound links declared by the pillar/cluster architecture and nav.
 *
 * These count as non-orphan sources (home, nav, pillars). Sitemap alone does not.
 *
 * @return array<string, bool> path key => true
 */
function restwell_orphan_audit_structural_inbound() {
	$inbound = array();

	// Primary navigation + footer explore list.
	if ( function_exists( 'restwell_get_primary_nav_links' ) ) {
		foreach ( restwell_get_primary_nav_links() as $item ) {
			if ( empty( $item['url'] ) ) {
				continue;
			}
			$key = restwell_orphan_audit_path_key( $item['url'] );
			if ( '' !== $key ) {
				$inbound[ $key ] = true;
			}
		}
	}

	// Legal footer destinations (real links in footer.php).
	foreach ( array( 'faq', 'privacy-policy', 'terms-and-conditions', 'accessibility-policy' ) as $slug ) {
		$url = '';
		if ( function_exists( 'restwell_nav_resolve_page_url' ) ) {
			$page = get_page_by_path( $slug, OBJECT, 'page' );
			if ( $page && 'publish' === $page->post_status ) {
				$url = (string) get_permalink( $page );
			} elseif ( 'privacy-policy' === $slug ) {
				$url = restwell_nav_resolve_page_url( 'privacy-policy' );
			}
		} else {
			$url = restwell_get_published_page_url( $slug );
		}
		$key = restwell_orphan_audit_path_key( $url );
		if ( '' !== $key ) {
			$inbound[ $key ] = true;
		}
	}

	// Home → three pillars (and conversion when published).
	foreach ( array_keys( restwell_get_pillar_cluster_map() ) as $pillar_slug ) {
		$key = restwell_orphan_audit_path_key( restwell_get_pillar_url( $pillar_slug ) );
		if ( '' !== $key ) {
			$inbound[ $key ] = true;
		}
	}
	foreach ( restwell_get_conversion_link_items() as $item ) {
		$key = restwell_orphan_audit_path_key( $item['url'] );
		if ( '' !== $key ) {
			$inbound[ $key ] = true;
		}
	}

	// Pillar → cluster posts + category archive + sibling pillars + conversion.
	foreach ( array_keys( restwell_get_pillar_cluster_map() ) as $pillar_slug ) {
		foreach ( restwell_get_cluster_posts( $pillar_slug ) as $post ) {
			if ( ! $post instanceof WP_Post ) {
				continue;
			}
			$key = restwell_orphan_audit_path_key( get_permalink( $post ) );
			if ( '' !== $key ) {
				$inbound[ $key ] = true;
			}
		}
		$cat_slug = restwell_get_cluster_category_for_pillar( $pillar_slug );
		$term     = $cat_slug ? get_term_by( 'slug', $cat_slug, 'category' ) : null;
		if ( $term && ! is_wp_error( $term ) ) {
			$key = restwell_orphan_audit_path_key( get_category_link( (int) $term->term_id ) );
			if ( '' !== $key ) {
				$inbound[ $key ] = true;
			}
		}
	}

	// news-updates posts → linked from The Property related module via explicit list.
	$news = get_term_by( 'slug', 'news-updates', 'category' );
	if ( $news && ! is_wp_error( $news ) ) {
		$news_q = new WP_Query(
			array(
				'post_type'              => 'post',
				'post_status'            => 'publish',
				'posts_per_page'         => -1,
				'no_found_rows'          => true,
				'update_post_meta_cache' => false,
				'update_post_term_cache' => false,
				'tax_query'              => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
					array(
						'taxonomy' => 'category',
						'field'    => 'term_id',
						'terms'    => array( (int) $news->term_id ),
					),
				),
			)
		);
		foreach ( $news_q->posts as $post ) {
			if ( $post instanceof WP_Post ) {
				$key = restwell_orphan_audit_path_key( get_permalink( $post ) );
				if ( '' !== $key ) {
					$inbound[ $key ] = true;
				}
			}
		}
		wp_reset_postdata();
		$key = restwell_orphan_audit_path_key( get_category_link( (int) $news->term_id ) );
		if ( '' !== $key ) {
			$inbound[ $key ] = true;
		}
	}

	// Footer blog category links (archives are non-orphan sources for posts in the loop).
	if ( function_exists( 'restwell_get_footer_blog_categories' ) ) {
		foreach ( restwell_get_footer_blog_categories( 10 ) as $term ) {
			if ( ! $term instanceof WP_Term ) {
				continue;
			}
			$key = restwell_orphan_audit_path_key( get_category_link( (int) $term->term_id ) );
			if ( '' !== $key ) {
				$inbound[ $key ] = true;
			}
		}
	}

	// Blog index.
	$posts_page_id = (int) get_option( 'page_for_posts' );
	if ( $posts_page_id ) {
		$key = restwell_orphan_audit_path_key( get_permalink( $posts_page_id ) );
		if ( '' !== $key ) {
			$inbound[ $key ] = true;
		}
	} else {
		$key = restwell_orphan_audit_path_key( get_post_type_archive_link( 'post' ) );
		if ( '' !== $key ) {
			$inbound[ $key ] = true;
		}
	}

	// Pricing cross-links when that page exists.
	$pricing = get_page_by_path( 'pricing', OBJECT, 'page' );
	if ( $pricing && 'publish' === $pricing->post_status ) {
		foreach ( restwell_get_pricing_cross_link_items() as $item ) {
			$key = restwell_orphan_audit_path_key( $item['url'] );
			if ( '' !== $key ) {
				$inbound[ $key ] = true;
			}
		}
	}

	return $inbound;
}

/**
 * Dev-only orphan audit: published pages/posts with zero inbound internal links.
 *
 * A URL in wp-sitemap.xml with no inbound link is still an orphan. Guest Guide
 * (noindex) is excluded. Sources include navigation, pillar modules, and body HTML.
 *
 * @return array{ok: bool, orphans: array<int, array{id: int, type: string, path: string, title: string}>, checked: int}
 */
function restwell_orphan_audit() {
	$inbound = restwell_orphan_audit_structural_inbound();

	$posts = get_posts(
		array(
			'post_type'              => array( 'post', 'page' ),
			'post_status'            => 'publish',
			'posts_per_page'         => -1,
			'orderby'                => 'ID',
			'order'                  => 'ASC',
			'no_found_rows'          => true,
			'update_post_meta_cache' => true,
			'update_post_term_cache' => false,
		)
	);

	foreach ( $posts as $post ) {
		if ( ! $post instanceof WP_Post ) {
			continue;
		}
		restwell_orphan_audit_collect_hrefs( (string) $post->post_content, $inbound );
	}

	// Front page is never an orphan.
	$inbound[ restwell_orphan_audit_path_key( home_url( '/' ) ) ] = true;

	$orphans = array();
	foreach ( $posts as $post ) {
		if ( ! $post instanceof WP_Post ) {
			continue;
		}
		if ( restwell_orphan_audit_exclude_post( $post ) ) {
			continue;
		}
		// Front page.
		if ( (int) get_option( 'page_on_front' ) === (int) $post->ID ) {
			continue;
		}

		$path = restwell_orphan_audit_path_key( get_permalink( $post ) );
		if ( '' === $path ) {
			continue;
		}
		if ( ! empty( $inbound[ $path ] ) ) {
			continue;
		}

		$orphans[] = array(
			'id'    => (int) $post->ID,
			'type'  => $post->post_type,
			'path'  => $path,
			'title' => get_the_title( $post ),
		);
	}

	return array(
		'ok'      => empty( $orphans ),
		'orphans' => $orphans,
		'checked' => count( $posts ),
	);
}

/**
 * Whether the orphan audit may run (WP_DEBUG or administrators only).
 *
 * @return bool
 */
function restwell_orphan_audit_may_run() {
	if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		return true;
	}
	return is_user_logged_in() && current_user_can( 'manage_options' );
}

/**
 * Cache and log orphan audit results for admins / WP_DEBUG.
 *
 * @return void
 */
function restwell_orphan_audit_maybe_report() {
	if ( ! restwell_orphan_audit_may_run() ) {
		return;
	}
	if ( wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}

	static $ran = false;
	if ( $ran ) {
		return;
	}
	$ran = true;

	$cached = get_transient( 'restwell_orphan_audit' );
	if ( is_array( $cached ) && isset( $cached['ok'], $cached['orphans'] ) ) {
		$result = $cached;
	} else {
		$result = restwell_orphan_audit();
		set_transient( 'restwell_orphan_audit', $result, 5 * MINUTE_IN_SECONDS );
	}

	if ( empty( $result['orphans'] ) ) {
		return;
	}

	foreach ( $result['orphans'] as $orphan ) {
		$path = isset( $orphan['path'] ) ? (string) $orphan['path'] : '';
		if ( '' === $path ) {
			continue;
		}
		// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log -- intentional SEO audit signal.
		error_log( 'Restwell orphan page (no inbound internal link): ' . $path );
	}
}
add_action( 'admin_init', 'restwell_orphan_audit_maybe_report', 45 );
add_action( 'wp', 'restwell_orphan_audit_maybe_report', 45 );

/**
 * Admin-bar summary for the orphan audit.
 *
 * @param WP_Admin_Bar $wp_admin_bar Admin bar.
 * @return void
 */
function restwell_orphan_audit_admin_bar( $wp_admin_bar ) {
	if ( ! restwell_orphan_audit_may_run() ) {
		return;
	}
	if ( ! $wp_admin_bar instanceof WP_Admin_Bar ) {
		return;
	}

	$result = get_transient( 'restwell_orphan_audit' );
	if ( ! is_array( $result ) ) {
		$result = restwell_orphan_audit();
		set_transient( 'restwell_orphan_audit', $result, 5 * MINUTE_IN_SECONDS );
	}

	$count = isset( $result['orphans'] ) ? count( (array) $result['orphans'] ) : 0;
	if ( $count < 1 ) {
		$title = __( 'SEO orphans: OK', 'restwell-retreats' );
		$meta  = array( 'class' => 'restwell-orphan-audit-ok' );
	} else {
		$title = sprintf(
			/* translators: %d: orphan count */
			__( 'SEO orphans: %d', 'restwell-retreats' ),
			$count
		);
		$meta = array( 'class' => 'restwell-orphan-audit-bad' );
	}

	$wp_admin_bar->add_node(
		array(
			'id'    => 'restwell-orphan-audit',
			'title' => esc_html( $title ),
			'href'  => admin_url( 'admin.php?page=restwell-seo' ),
			'meta'  => $meta,
		)
	);

	if ( $count < 1 || empty( $result['orphans'] ) ) {
		return;
	}

	foreach ( array_slice( (array) $result['orphans'], 0, 10 ) as $i => $orphan ) {
		$path = isset( $orphan['path'] ) ? (string) $orphan['path'] : '';
		if ( '' === $path ) {
			continue;
		}
		$wp_admin_bar->add_node(
			array(
				'id'     => 'restwell-orphan-audit-' . $i,
				'parent' => 'restwell-orphan-audit',
				'title'  => esc_html( $path ),
			)
		);
	}
}
add_action( 'admin_bar_menu', 'restwell_orphan_audit_admin_bar', 101 );

/**
 * News & updates posts to surface on The Property (Revitalise alternatives cluster).
 *
 * @return WP_Post[]
 */
function restwell_get_news_updates_posts_for_property() {
	$term = get_term_by( 'slug', 'news-updates', 'category' );
	if ( ! $term || is_wp_error( $term ) ) {
		return array();
	}
	$query = new WP_Query(
		array(
			'post_type'              => 'post',
			'post_status'            => 'publish',
			'posts_per_page'         => -1,
			'orderby'                => 'date',
			'order'                  => 'DESC',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			'tax_query'              => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
				array(
					'taxonomy' => 'category',
					'field'    => 'term_id',
					'terms'    => array( (int) $term->term_id ),
				),
			),
		)
	);
	$posts = $query->posts ? $query->posts : array();
	wp_reset_postdata();
	return is_array( $posts ) ? $posts : array();
}
