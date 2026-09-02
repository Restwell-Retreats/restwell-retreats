<?php
/**
 * Theme setup: orchestration and page meta seeding.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create pages, seed content, and optionally upload theme media.
 *
 * @param bool $force            If true, re-seed Home and page content where supported, and refresh seeded blog posts.
 * @param bool $skip_image_regen If true, skip regenerating image subsizes when media seed is enabled.
 * @param bool $seed_media       If true, upload logos and partner images and optionally regenerate image subsizes.
 * @param bool $overwrite_seo    If true, overwrite existing SEO title, meta description, and focus keyphrase from theme defaults. Empty SEO fields are filled either way.
 * @return array<string, mixed> Setup result.
 */
function restwell_run_theme_setup( $force = false, $skip_image_regen = false, $seed_media = false, $overwrite_seo = false ) {
	$result = array(
		'created'                => array(),
		'skipped'                => array(),
		'front_page_set'         => false,
		'posts_page_set'         => false,
		'home_seeded'            => false,
		'home_meta_keys_written' => 0,
		'home_additive_only'     => false,
		'pages_seeded'           => array(),
		'pages_seed_skipped'     => array(),
		'hub_seeded'             => array(),
		'seo_meta_applied'       => false,
		'seo_meta_forced'        => false,
		'blog_posts_seeded'      => array(),
		'blog_posts_failed'      => array(),
		'media_seed_skipped'     => ! $seed_media,
		'logos_uploaded'         => array(),
		'logos_skipped'          => array(),
		'logos_missing'          => array(),
		'logos_failed'           => array(),
		'partner_logos_uploaded' => array(),
		'partner_logos_skipped'  => array(),
		'partner_logos_missing'  => array(),
		'partner_logos_failed'   => array(),
		'image_regen_skipped'    => false,
		'image_regen'            => null,
	);

	$pages = restwell_get_theme_setup_pages();
	$created_ids = array();

	$page_templates = function_exists( 'restwell_get_theme_setup_page_templates' )
		? restwell_get_theme_setup_page_templates()
		: array();

	foreach ( $pages as $title => $slug ) {
		$existing = restwell_get_page_by_nav_slug( $slug );
		if ( $existing ) {
			$result['skipped'][] = $title;
			$created_ids[ $title ] = $existing->ID;
		} else {
			$id = wp_insert_post(
				array(
					'post_title'   => $title,
					'post_name'    => $slug,
					'post_status'  => 'publish',
					'post_type'    => 'page',
					'post_author'  => get_current_user_id(),
				),
				true
			);
			if ( ! is_wp_error( $id ) ) {
				$result['created'][] = $title;
				$created_ids[ $title ] = $id;
			}
		}
		// Assign page template so custom templates and meta fields are used.
		if ( isset( $created_ids[ $title ] ) && isset( $page_templates[ $title ] ) ) {
			update_post_meta( $created_ids[ $title ], '_wp_page_template', $page_templates[ $title ] );
		}
	}

	$home_id = isset( $created_ids['Home'] ) ? (int) $created_ids['Home'] : 0;
	if ( $home_id < 1 ) {
		$home_page = get_page_by_path( 'home', OBJECT, 'page' );
		$home_id   = $home_page ? (int) $home_page->ID : 0;
	}

	if ( $home_id > 0 ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home_id );
		$result['front_page_set'] = true;

		$home_was_seeded = get_post_meta( $home_id, 'restwell_fields_seeded', true ) === '1';

		$home_defaults           = restwell_get_theme_setup_defaults();
		$home_meta_keys_written  = restwell_merge_theme_defaults_into_post_meta( $home_id, $home_defaults, $force );
		$result['home_meta_keys_written'] = $home_meta_keys_written;
		$result['home_additive_only']     = $home_was_seeded && ! $force && $home_meta_keys_written > 0;
		if ( $home_meta_keys_written > 0 ) {
			update_post_meta( $home_id, 'restwell_fields_seeded', '1' );
			$result['home_seeded'] = true;
		}
	}

	// Seed meta defaults for all non-Home template pages.
	restwell_seed_all_pages_meta( $created_ids, $force, $result );

	// Hub pages (Who it's for, Whitstable guide) + blog archive excerpt.
	restwell_seed_hub_pages_content( $created_ids, $force, $result );

	// Posts page: blog archive at /blog/.
	$blog_id = isset( $created_ids['Blog'] ) ? (int) $created_ids['Blog'] : 0;
	if ( $blog_id < 1 ) {
		$blog_page = get_page_by_path( 'blog', OBJECT, 'page' );
		$blog_id   = $blog_page ? (int) $blog_page->ID : 0;
	}
	if ( $blog_id > 0 ) {
		update_option( 'page_for_posts', $blog_id );
		$result['posts_page_set'] = true;
	}

	// SEO defaults: fill empty fields always; overwrite existing only when $overwrite_seo is true.
	restwell_apply_seo_meta_to_pages( $overwrite_seo );
	$result['seo_meta_applied'] = true;
	$result['seo_meta_forced']  = (bool) $overwrite_seo;

	if ( function_exists( 'restwell_apply_copy_overwrites' ) ) {
		$result['copy_overwrites'] = restwell_apply_copy_overwrites( $overwrite_seo );
	}

	// Priority blog posts (idempotent; pass $force so re-run updates content).
	restwell_seed_priority_blog_posts( $result, $force );

	// Media seed: logos, partner images, and responsive sizes (opt-in via Theme Setup checkbox).
	if ( $seed_media ) {
		restwell_upload_theme_logos( $result );
		restwell_upload_partner_logos( $home_id, $result, $force );
		if ( function_exists( 'restwell_seed_page_hero_stock_images' ) ) {
			$result['page_hero_stock'] = restwell_seed_page_hero_stock_images();
		}

		$run_regen = ! $skip_image_regen && apply_filters( 'restwell_theme_setup_run_image_subsize_regen', true, $force, $seed_media );
		$result['image_regen_skipped'] = ! $run_regen;
		if ( $run_regen && function_exists( 'restwell_regenerate_all_image_subsizes' ) ) {
			$result['image_regen'] = restwell_regenerate_all_image_subsizes();
		}
	} else {
		$result['image_regen_skipped'] = true;
	}

	return $result;
}

/**
 * Ensure the Blog page is the posts index and Home is the static front.
 *
 * front-page.php is the marketing homepage. index.php / home.php is the blog
 * archive. If show_on_front is "posts", /blog/ is a normal page and uses
 * page.php (wrong H1). Static front + page_for_posts routes /blog/ correctly.
 */
function restwell_ensure_blog_posts_page() {
	if ( wp_installing() ) {
		return;
	}

	$blog = get_page_by_path( 'blog', OBJECT, 'page' );
	if ( ! $blog || (int) $blog->ID < 1 ) {
		return;
	}
	$blog_id = (int) $blog->ID;

	$home = get_page_by_path( 'home', OBJECT, 'page' );
	$home_id = $home ? (int) $home->ID : 0;
	if ( $home_id < 1 ) {
		$front_id = (int) get_option( 'page_on_front', 0 );
		if ( $front_id > 0 && $front_id !== $blog_id ) {
			$home_id = $front_id;
		}
	}
	if ( $home_id < 1 ) {
		$home_id = (int) wp_insert_post(
			array(
				'post_title'  => __( 'Home', 'restwell-retreats' ),
				'post_name'   => 'home',
				'post_status' => 'publish',
				'post_type'   => 'page',
				'post_content'=> '',
			),
			true
		);
		if ( $home_id < 1 ) {
			return;
		}
	}

	$show       = (string) get_option( 'show_on_front', 'posts' );
	$front      = (int) get_option( 'page_on_front', 0 );
	$posts_page = (int) get_option( 'page_for_posts', 0 );

	$needs_update = ( 'page' !== $show )
		|| ( $front !== $home_id )
		|| ( $posts_page !== $blog_id );

	if ( ! $needs_update ) {
		return;
	}

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $home_id );
	update_option( 'page_for_posts', $blog_id );
	flush_rewrite_rules( false );
}
add_action( 'init', 'restwell_ensure_blog_posts_page', 4 );

/**
 * Ensure the Guest Arrival Guide page exists with the OTP template.
 */
function restwell_ensure_guest_guide_page() {
	if ( wp_installing() ) {
		return;
	}

	$page = get_page_by_path( 'guest-guide', OBJECT, 'page' );
	$created = false;

	if ( ! $page || (int) $page->ID < 1 ) {
		$page_id = (int) wp_insert_post(
			array(
				'post_title'   => __( 'Guest Guide', 'restwell-retreats' ),
				'post_name'    => 'guest-guide',
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => '',
			),
			true
		);
		if ( $page_id < 1 ) {
			return;
		}
		$created = true;
	} else {
		$page_id = (int) $page->ID;
	}

	$template = (string) get_post_meta( $page_id, '_wp_page_template', true );
	if ( 'page-guest-guide.php' !== $template ) {
		update_post_meta( $page_id, '_wp_page_template', 'page-guest-guide.php' );
		$created = true;
	}

	if ( $created ) {
		flush_rewrite_rules( false );
	}
}
add_action( 'init', 'restwell_ensure_guest_guide_page', 5 );

/**
 * Create any Theme Setup pages that are missing (templates exist; the WP page may not).
 *
 * Nav falls back to /{slug}/ even when get_page_by_path() is empty, so missing
 * pages 404 behind a real-looking link. Guest Guide already has its own ensure.
 */
function restwell_ensure_registered_theme_pages() {
	if ( wp_installing() ) {
		return;
	}
	if ( ! function_exists( 'restwell_get_theme_setup_pages' ) ) {
		return;
	}

	$pages     = restwell_get_theme_setup_pages();
	$templates = function_exists( 'restwell_get_theme_setup_page_templates' )
		? restwell_get_theme_setup_page_templates()
		: array();
	$created_ids = array();
	$created_any = false;

	foreach ( $pages as $title => $slug ) {
		$page = function_exists( 'restwell_get_page_by_nav_slug' )
			? restwell_get_page_by_nav_slug( $slug )
			: get_page_by_path( $slug, OBJECT, 'page' );
		if ( $page instanceof WP_Post ) {
			$created_ids[ $title ] = (int) $page->ID;
		} else {
			$page_id = wp_insert_post(
				array(
					'post_title'   => $title,
					'post_name'    => $slug,
					'post_status'  => 'publish',
					'post_type'    => 'page',
					'post_content' => '',
					'post_author'  => get_current_user_id(),
				),
				true
			);
			if ( is_wp_error( $page_id ) || (int) $page_id < 1 ) {
				continue;
			}
			$page_id = (int) $page_id;
			$created_ids[ $title ] = $page_id;
			$created_any           = true;
		}

		if ( ! isset( $templates[ $title ], $created_ids[ $title ] ) ) {
			continue;
		}
		$pid      = (int) $created_ids[ $title ];
		$current  = (string) get_post_meta( $pid, '_wp_page_template', true );
		$expected = $templates[ $title ];
		if ( $current !== $expected ) {
			update_post_meta( $pid, '_wp_page_template', $expected );
			$created_any = true;
		}
	}

	if ( ! $created_any ) {
		return;
	}

	$result = array(
		'pages_seeded'       => array(),
		'pages_seed_skipped' => array(),
	);
	if ( function_exists( 'restwell_seed_all_pages_meta' ) ) {
		restwell_seed_all_pages_meta( $created_ids, false, $result );
	}
	if ( function_exists( 'restwell_apply_seo_meta_to_pages' ) ) {
		restwell_apply_seo_meta_to_pages( false );
	}
	flush_rewrite_rules( false );
}
add_action( 'init', 'restwell_ensure_registered_theme_pages', 6 );
