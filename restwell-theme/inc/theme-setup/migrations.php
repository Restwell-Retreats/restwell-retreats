<?php
/**
 * Theme setup: one-time content migrations on init/admin.
 *
 * Bootstrap: hooks are registered only while restwell_schema_version is below
 * RESTWELL_SCHEMA_VERSION. v1–v28 bodies live in migrations-archive-v1-v28.php
 * and are loaded only when schema is below 29.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Current content-migration schema generation.
 *
 * Bump when adding new restwell_migrate_* callbacks that must run on existing sites.
 */
const RESTWELL_SCHEMA_VERSION = 32;


/**
 * Load frozen v1–v28 migration bodies when this site has not reached schema 29.
 */
function restwell_maybe_load_legacy_content_migrations(): void {
	static $loaded = false;
	if ( $loaded ) {
		return;
	}
	if ( (int) get_option( 'restwell_schema_version', 0 ) >= 29 ) {
		return;
	}
	$loaded = true;
	require_once __DIR__ . '/migrations-archive-v1-v28.php';
}


/**
 * Align stored privacy HTML and analytics load mode with enquiry consent + first-party CMP.
 */
function restwell_migrate_privacy_consent_v29() {
	if ( get_option( 'restwell_privacy_consent_v29', '' ) === '1' ) {
		return;
	}

	$mode    = (string) get_option( 'restwell_analytics_load_mode', '' );
	$allowed = array( 'head', 'footer_deferred', 'consent_gated' );
	if ( '' === $mode || ! in_array( $mode, $allowed, true ) || 'consent_gated' !== $mode ) {
		update_option( 'restwell_analytics_load_mode', 'consent_gated', false );
	}

	$page_by_path_or_template = static function ( $slug, $template ) {
		$page = get_page_by_path( $slug, OBJECT, 'page' );
		if ( $page instanceof WP_Post ) {
			return $page;
		}
		$found = get_pages(
			array(
				'meta_key'   => '_wp_page_template',
				'meta_value' => $template,
				'number'     => 1,
			)
		);
		return ( ! empty( $found ) && $found[0] instanceof WP_Post ) ? $found[0] : null;
	};

	$privacy = $page_by_path_or_template( 'privacy-policy', 'template-privacy-policy.php' );
	if ( $privacy instanceof WP_Post ) {
		$pid  = (int) $privacy->ID;
		$html = (string) get_post_meta( $pid, 'legal_body_html', true );
		if ( $html !== '' && (
			false !== strpos( $html, 'legitimate interests to respond to your enquiry' )
			|| false !== strpos( $html, 'cookie controls shown on your first visit' )
		) ) {
			delete_post_meta( $pid, 'legal_body_html' );
		}

		$intro     = trim( (string) get_post_meta( $pid, 'legal_intro', true ) );
		$old_intro = 'Who is responsible for your data, what we collect when you enquire or book, cookies, retention, and your UK GDPR rights (including contacting the ICO).';
		$new_intro = 'Who is responsible for your data, what we collect on the enquiry form (including optional care notes), cookie choices, retention, and your UK GDPR rights (including contacting the ICO).';
		if ( $intro === $old_intro ) {
			update_post_meta( $pid, 'legal_intro', $new_intro );
		}
	}

	update_option( 'restwell_privacy_consent_v29', '1' );
}

/**
 * Re-assert consent_gated analytics and drop stale privacy HTML the v29 string match missed.
 */
function restwell_migrate_privacy_consent_v31() {
	if ( get_option( 'restwell_privacy_consent_v31', '' ) === '1' ) {
		return;
	}

	update_option( 'restwell_analytics_load_mode', 'consent_gated', false );

	$page = get_page_by_path( 'privacy-policy', OBJECT, 'page' );
	if ( ! ( $page instanceof WP_Post ) ) {
		$found = get_pages(
			array(
				'meta_key'   => '_wp_page_template',
				'meta_value' => 'template-privacy-policy.php',
				'number'     => 1,
			)
		);
		$page = ( ! empty( $found ) && $found[0] instanceof WP_Post ) ? $found[0] : null;
	}

	if ( $page instanceof WP_Post ) {
		$html = (string) get_post_meta( (int) $page->ID, 'legal_body_html', true );
		if ( $html !== '' ) {
			$lower = strtolower( $html );
			$stale = false !== strpos( $lower, 'legitimate interest' )
				|| false !== strpos( $lower, 'cookie controls shown on your first visit' )
				|| false !== strpos( $lower, 'care or accessibility information you choose to share' );
			if ( $stale ) {
				delete_post_meta( (int) $page->ID, 'legal_body_html' );
			}
		}
	}

	update_option( 'restwell_privacy_consent_v31', '1' );
}

/**
 * Site title, Funding & Support slug, homepage Partners/Testimonials seeds.
 */
function restwell_migrate_site_identity_v30() {
	if ( get_option( 'restwell_site_identity_v30', '' ) === '1' ) {
		return;
	}

	$blogname = trim( (string) get_option( 'blogname', '' ) );
	if ( '' === $blogname || 0 === strcasecmp( $blogname, 'restwell' ) ) {
		update_option( 'blogname', 'Restwell Retreats' );
	}

	$funding = get_page_by_path( 'funding-and-support', OBJECT, 'page' );
	$res     = get_page_by_path( 'resources', OBJECT, 'page' );
	if ( $res instanceof WP_Post && ! ( $funding instanceof WP_Post ) ) {
		$update = array(
			'ID'        => (int) $res->ID,
			'post_name' => 'funding-and-support',
		);
		if ( 'Resources' === $res->post_title ) {
			$update['post_title'] = 'Funding & Support';
		}
		wp_update_post( $update );
	}

	$blog_id = (int) get_option( 'page_for_posts', 0 );
	if ( $blog_id > 0 ) {
		$blog = get_post( $blog_id );
		if ( $blog instanceof WP_Post && in_array( $blog->post_name, array( 'news', 'uncategorized' ), true ) ) {
			wp_update_post(
				array(
					'ID'        => $blog_id,
					'post_name' => 'blog',
				)
			);
		}
	}

	$privacy = get_page_by_path( 'privacy-policy', OBJECT, 'page' );
	if ( $privacy instanceof WP_Post ) {
		$html = (string) get_post_meta( (int) $privacy->ID, 'legal_body_html', true );
		$old  = 'We keep enquiry and booking-related records for up to three years so we can answer follow-up questions and meet regulatory and insurance expectations. You can ask us to delete your data sooner where the law allows.';
		$new  = 'We keep enquiry and booking-related records for up to three years so we can answer follow-up questions and meet regulatory and insurance expectations. Optional care and accessibility notes are kept for a shorter period: 12 months if the enquiry does not become a booking, or 90 days after the stay if it does. You can ask us to delete your data sooner where the law allows.';
		if ( '' !== $html && false !== strpos( $html, $old ) ) {
			update_post_meta( (int) $privacy->ID, 'legal_body_html', str_replace( $old, $new, $html ) );
		}
	}

	$front_id = (int) get_option( 'page_on_front', 0 );
	if ( $front_id > 0 ) {
		$partner_swaps = array(
			'home_partners_label'    => array(
				'Trusted partners' => 'Behind Restwell',
			),
			'home_partners_heading'  => array(
				'Specialist Partners' => 'Who built it, and who we work with',
			),
			'home_partners_intro'    => array(
				'The full story of how we adapted Restwell, who built it, and who supports guests today.' => 'Specialist firms adapted the house.',
			),
			'home_partners_cta_text' => array(
				'See our journey' => 'Read the full story',
			),
			'home_partners_cta_url'  => array(
				'/how-it-works/' => '/our-story/',
			),
		);
		foreach ( $partner_swaps as $key => $map ) {
			$current = (string) get_post_meta( $front_id, $key, true );
			if ( isset( $map[ $current ] ) ) {
				update_post_meta( $front_id, $key, $map[ $current ] );
			}
		}

		$quote_1 = trim( (string) get_post_meta( $front_id, 'testimonial_1_quote', true ) );
		if ( '' === $quote_1 && function_exists( 'restwell_homepage_testimonial_hard_fallbacks' ) ) {
			$i = 1;
			foreach ( restwell_homepage_testimonial_hard_fallbacks() as $item ) {
				update_post_meta( $front_id, 'testimonial_' . $i . '_quote', $item['quote'] );
				update_post_meta( $front_id, 'testimonial_' . $i . '_name', $item['name'] );
				update_post_meta( $front_id, 'testimonial_' . $i . '_role', $item['role'] );
				++$i;
			}
			if ( '' === trim( (string) get_post_meta( $front_id, 'testimonial_label', true ) ) ) {
				update_post_meta( $front_id, 'testimonial_label', 'What guests say' );
			}
			if ( '' === trim( (string) get_post_meta( $front_id, 'testimonial_heading', true ) ) ) {
				update_post_meta( $front_id, 'testimonial_heading', 'What guests wrote after staying' );
			}
		}
	}

	flush_rewrite_rules( false );
	update_option( 'restwell_site_identity_v30', '1' );
}

/**
 * Fill empty guest-guide SEO title and meta description from copy-overwrites/guest-guide.md.
 *
 * The page stays noindex; this is for the SEO admin fields and social fallbacks, not ranking.
 */
function restwell_migrate_guest_guide_meta_v32() {
	if ( get_option( 'restwell_guest_guide_meta_v32', '' ) === '1' ) {
		return;
	}

	if ( function_exists( 'restwell_parse_copy_overwrite_file' ) && function_exists( 'restwell_copy_overwrite_maybe_write_meta' ) ) {
		$page = get_page_by_path( 'guest-guide', OBJECT, 'page' );
		if ( $page instanceof WP_Post ) {
			$parsed = restwell_parse_copy_overwrite_file( get_template_directory() . '/copy-overwrites/guest-guide.md' );
			restwell_copy_overwrite_maybe_write_meta( (int) $page->ID, 'meta_title', $parsed['title'], false );
			restwell_copy_overwrite_maybe_write_meta( (int) $page->ID, 'meta_description', $parsed['meta_description'], false );
		}
	}

	update_option( 'restwell_guest_guide_meta_v32', '1', false );
}

/**
 * Migration option flags that must be complete before the schema gate closes.
 *
 * @return string[]
 */
function restwell_content_migration_flag_keys(): array {
	return array(
		'restwell_home_faq_meta_migrated_v1',
		'restwell_property_practical_meta_v1',
		'restwell_property_sleeps_five_v1',
		'restwell_property_parking_short_v1',
		'restwell_property_bedrooms_parking_v2',
		'restwell_property_parking_detail_v3',
		'restwell_property_headings_v4',
		'restwell_property_labels_v5',
		'restwell_property_wetroom_stat_v6',
		'restwell_property_wetroom_walkthrough_v7',
		'restwell_homepage_cta_testword_v8',
		'restwell_property_wetroom_stat_copy_v9',
		'restwell_faq_access_parking_bedrooms_v1',
		'restwell_property_feature_copy_balance_v1',
		'restwell_home_hiw_card_copy_balance_v1',
		'restwell_legal_policy_templates_v1',
		'restwell_accessibility_headings_v1',
		'restwell_accessibility_intro_v2',
		'restwell_who_its_for_headings_v1',
		'restwell_property_headings_v1',
		'restwell_how_it_works_headings_v1',
		'restwell_home_lede_v1',
		'restwell_property_lede_v1',
		'restwell_wif_lede_v1',
		'restwell_hiw_lede_v1',
		'restwell_faq_lede_v1',
		'restwell_resources_lede_v1',
		'restwell_wg_lede_v1',
		'restwell_enq_lede_v1',
		'restwell_blog_lede_v1',
		'restwell_blog_index_copy_v2',
		'restwell_seo_titles_meta_v3',
		'restwell_seo_titles_meta_v4',
		'restwell_seo_home_title_v5',
		'restwell_seo_a11y_policy_meta_v6',
		'restwell_seo_cannibal_lanes_v7',
		'restwell_seo_cannibal_medium_v8',
		'restwell_seo_cannibal_low_v9',
		'restwell_sample_page_demo_v10',
		'restwell_retire_demo_content_v11',
		'restwell_keyword_lanes_v1',
		'restwell_guest_guide_checkin_v1',
		'restwell_terms_balance_one_week_v1',
		'restwell_pricing_hero_copy_v1',
		'restwell_pricing_equipment_hire_copy_v1',
		'restwell_seo_kp_titles_v12',
		'restwell_page_hero_stock_v13',
		'restwell_page_hero_stock_v14',
		'restwell_terms_title_hero_quality_v15',
		'restwell_page_hero_stock_v16',
		'restwell_page_hero_stock_v17',
		'restwell_seo_meta_tips_v18',
		'restwell_lanes_home_v22',
		'restwell_home_hero_intro_v23',
		'restwell_copy_overhaul_v24',
		'restwell_victoria_registered_manager_v25',
		'restwell_strip_em_dashes_v26',
		'restwell_audit_copy_fixes_v27',
		'restwell_audit_copy_fixes_v28',
		'restwell_privacy_consent_v29',
		'restwell_site_identity_v30',
		'restwell_privacy_consent_v31',
		'restwell_guest_guide_meta_v32',
	);
}

/**
 * Whether every known migration flag is marked complete.
 *
 * @return bool
 */
function restwell_content_migrations_are_complete(): bool {
	foreach ( restwell_content_migration_flag_keys() as $option_name ) {
		if ( get_option( $option_name, '' ) !== '1' ) {
			return false;
		}
	}
	return true;
}

/**
 * Mark the schema current once all migration flags are complete.
 */
function restwell_maybe_mark_schema_current(): void {
	if ( (int) get_option( 'restwell_schema_version', 0 ) >= RESTWELL_SCHEMA_VERSION ) {
		return;
	}
	if ( ! restwell_content_migrations_are_complete() ) {
		return;
	}
	update_option( 'restwell_schema_version', RESTWELL_SCHEMA_VERSION, false );
}

/**
 * Register content-migration hooks only when the schema is behind.
 */
function restwell_register_content_migrations(): void {
	if ( (int) get_option( 'restwell_schema_version', 0 ) >= RESTWELL_SCHEMA_VERSION ) {
		return;
	}

	if ( (int) get_option( 'restwell_schema_version', 0 ) < 29 ) {
		restwell_maybe_load_legacy_content_migrations();
		if ( function_exists( 'restwell_register_legacy_content_migration_hooks' ) ) {
			restwell_register_legacy_content_migration_hooks();
		}
	}

	add_action( 'init', 'restwell_migrate_privacy_consent_v29', 78 );
	add_action( 'after_switch_theme', 'restwell_migrate_privacy_consent_v29', 69 );
	add_action( 'init', 'restwell_migrate_site_identity_v30', 79 );
	add_action( 'after_switch_theme', 'restwell_migrate_site_identity_v30', 70 );
	add_action( 'init', 'restwell_migrate_privacy_consent_v31', 80 );
	add_action( 'after_switch_theme', 'restwell_migrate_privacy_consent_v31', 71 );
	add_action( 'init', 'restwell_migrate_guest_guide_meta_v32', 81 );
	add_action( 'after_switch_theme', 'restwell_migrate_guest_guide_meta_v32', 72 );

	add_action( 'init', 'restwell_maybe_mark_schema_current', 100 );
	add_action( 'admin_init', 'restwell_maybe_mark_schema_current', 100 );
	add_action( 'after_switch_theme', 'restwell_maybe_mark_schema_current', 100 );
}
restwell_register_content_migrations();
