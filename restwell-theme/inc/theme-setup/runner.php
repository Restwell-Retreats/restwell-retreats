<?php
/**
 * Theme setup: orchestration and page meta seeding.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function restwell_run_theme_setup( $force = false, $skip_image_regen = false ) {
	$result = array(
		'created'            => array(),
		'skipped'            => array(),
		'front_page_set'     => false,
		'posts_page_set'     => false,
		'home_seeded'           => false,
		'home_meta_keys_written'  => 0,
		'home_additive_only'      => false,
		'pages_seeded'       => array(),
		'pages_seed_skipped' => array(),
		'hub_seeded'         => array(),
		'seo_meta_applied'   => false,
		'seo_meta_forced'    => false,
		'blog_posts_seeded'  => array(),
		'blog_posts_failed'  => array(),
		'logos_uploaded'     => array(),
		'logos_skipped'      => array(),
		'logos_missing'      => array(),
		'logos_failed'         => array(),
		'partner_logos_uploaded' => array(),
		'partner_logos_skipped'  => array(),
		'partner_logos_missing'  => array(),
		'partner_logos_failed'   => array(),
		'image_regen_skipped'  => false,
		'image_regen'          => null,
	);

	$pages = restwell_get_theme_setup_pages();
	$created_ids = array();

	$page_templates = array(
		'The Property'       => 'template-property.php',
		'How It Works'       => 'template-how-it-works.php',
		'Accessibility'      => 'template-accessibility.php',
		'Who It\'s For'      => 'template-who-its-for.php',
		'Whitstable Guide'   => 'template-whitstable-guide.php',
		'FAQ'                => 'template-faq.php',
		'Enquire'            => 'template-enquire.php',
		'Resources'          => 'template-resources.php',
		'Guest Guide'          => 'page-guest-guide.php',
		'Privacy Policy'       => 'template-privacy-policy.php',
		'Terms & Conditions'   => 'template-terms-and-conditions.php',
		'Accessibility Policy' => 'template-accessibility-policy.php',
	);

	foreach ( $pages as $title => $slug ) {
		$existing = get_page_by_path( $slug, OBJECT, 'page' );
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

	// SEO defaults: fill empty fields always; overwrite when $force (re-run setup) is true.
	restwell_apply_seo_meta_to_pages( $force );
	$result['seo_meta_applied'] = true;
	$result['seo_meta_forced']  = $force;

	// Priority blog posts (idempotent; pass $force so re-run updates content).
	restwell_seed_priority_blog_posts( $result, $force );

	// Upload logos to Media Library so templates can use stable attachment URLs.
	restwell_upload_theme_logos( $result );
	restwell_upload_partner_logos( $home_id, $result, $force );

	// Build restwell-hero / restwell-cta-bg (and other registered sizes) for every image; runs on Theme Setup unless skipped.
	$run_regen = ! $skip_image_regen && apply_filters( 'restwell_theme_setup_run_image_subsize_regen', true, $force );
	$result['image_regen_skipped'] = ! $run_regen;
	if ( $run_regen && function_exists( 'restwell_regenerate_all_image_subsizes' ) ) {
		$result['image_regen'] = restwell_regenerate_all_image_subsizes();
	}

	return $result;
}

/**
 * Public contact email for policies and footers (matches enquiry notify default).
 *
 * @return string Valid email address.
 */
