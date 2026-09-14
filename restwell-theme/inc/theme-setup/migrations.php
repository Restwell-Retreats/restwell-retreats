<?php
/**
 * Theme setup: one-time content migrations on init/admin.
 *
 * Bootstrap: hooks are registered only while restwell_schema_version is below
 * RESTWELL_SCHEMA_VERSION. v1–v28 live in migrations-archive-v1-v28.php
 * (loaded when schema < 29). v29–v31 live in migrations-archive-v29-v31.php
 * (loaded when schema < 32).
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
const RESTWELL_SCHEMA_VERSION = 61;


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
 * Load frozen v29–v31 migration bodies when this site has not reached schema 32.
 */
function restwell_maybe_load_spent_migrations_v29_v31(): void {
	static $loaded = false;
	if ( $loaded ) {
		return;
	}
	if ( (int) get_option( 'restwell_schema_version', 0 ) >= 32 ) {
		return;
	}
	$loaded = true;
	require_once __DIR__ . '/migrations-archive-v29-v31.php';
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
 * Public name for /pricing/ is now Pricing & dates (nav, WP title, hero label).
 */
function restwell_migrate_pricing_dates_label_v33() {
	if ( get_option( 'restwell_pricing_dates_label_v33', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'pricing', OBJECT, 'page' );
	if ( $page instanceof WP_Post ) {
		if ( 'Pricing' === $page->post_title ) {
			wp_update_post(
				array(
					'ID'         => (int) $page->ID,
					'post_title' => 'Pricing & dates',
				)
			);
		}
		$label = (string) get_post_meta( (int) $page->ID, 'pricing_label', true );
		if ( '' === $label || 'Pricing' === $label ) {
			update_post_meta( (int) $page->ID, 'pricing_label', 'Pricing & dates' );
		}
	}

	update_option( 'restwell_pricing_dates_label_v33', '1', false );
}

/**
 * Refresh How It Works step/care/FAQ/CTA meta from the live template copy.
 *
 * Wiring those fields previously left short seed strings in post meta while the
 * PHP template had richer hardcoded copy. Replace known stale values only.
 */
function restwell_migrate_hiw_wired_copy_v34() {
	if ( get_option( 'restwell_hiw_wired_copy_v34', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'how-it-works', OBJECT, 'page' );
	if ( ! $page instanceof WP_Post ) {
		update_option( 'restwell_hiw_wired_copy_v34', '1', false );
		return;
	}

	$page_id  = (int) $page->ID;
	$defaults = function_exists( 'restwell_get_how_it_works_page_defaults' )
		? restwell_get_how_it_works_page_defaults()
		: array();

	$stale_map = array(
		'hiw_steps_label'        => array( 'THREE-STEP PROCESS', 'FOUR-STEP PROCESS' ),
		'hiw_steps_intro'        => array( '' ),
		'hiw_step1_body'         => array( 'Tell us your dates and what you need. Nothing to pay at this stage.' ),
		'hiw_step2_body'         => array( 'We set the house up around you. A 50% deposit reserves the dates.' ),
		'hiw_step3_body'         => array( 'From 3pm, through a key safe. The address comes with your confirmation.' ),
		'hiw_care_cta_label'     => array( 'CARE SUPPORT' ),
		'hiw_care_cta_heading'   => array( 'Care fits around your routine' ),
		'hiw_care_cta_body'      => array(
			'Care is entirely optional. If you want it, Continuity of Care Services (CQC-regulated and experienced) will work to your schedule, not theirs. Morning check-ins, personal care, or more comprehensive support: you decide.',
		),
		'hiw_care_cta_btn'       => array( 'Ask about care options' ),
		'hiw_care_cta_url'       => array( '/enquire/' ),
		'hiw_faq_label'          => array( 'Common questions' ),
		'hiw_faq_heading'        => array( 'Things people often ask.' ),
		'hiw_faq_intro'          => array( '' ),
		'hiw_cta_heading'        => array( 'Start with a conversation.', 'Ready to plan your break?' ),
		'hiw_cta_body'           => array(
			'No commitment, no lengthy forms. Just get in touch and we\'ll take it from there.',
			'No commitment, no lengthy forms. Just get in touch and we&apos;ll take it from there.',
		),
	);

	foreach ( $stale_map as $key => $stale_values ) {
		if ( ! isset( $defaults[ $key ] ) ) {
			continue;
		}
		$current = trim( (string) get_post_meta( $page_id, $key, true ) );
		$next    = (string) $defaults[ $key ];
		if ( $current === $next ) {
			continue;
		}
		// Empty stored intro/label: always prefer the rich default when wiring went live.
		if ( '' === $current || in_array( $current, $stale_values, true ) ) {
			update_post_meta( $page_id, $key, $next );
		}
	}

	update_option( 'restwell_hiw_wired_copy_v34', '1', false );
}

/**
 * Align FAQ + How It Works mid-CTA meta with the concept-template copy.
 *
 * After those CTAs were wired to Page Content, older seed strings stayed in
 * post meta ("Still have a question?", "Start with a conversation."). Replace
 * known stale values only so editor-customised wording is preserved.
 */
function restwell_migrate_mid_cta_concept_copy_v35() {
	if ( get_option( 'restwell_mid_cta_concept_copy_v35', '' ) === '1' ) {
		return;
	}

	$targets = array(
		array(
			'path'     => 'faq',
			'defaults' => function_exists( 'restwell_get_faq_page_defaults' ) ? restwell_get_faq_page_defaults() : array(),
			'stale'    => array(
				'faq_cta_heading' => array( 'Still have a question?', 'Still have questions?' ),
				'faq_cta_body'    => array(
					'If your question isn’t here, ring us on 01622 809881 and just ask it. We keep a note of the ones that come up repeatedly and add them to this page.',
					"If your question isn't here, ring us on 01622 809881 and just ask it. We keep a note of the ones that come up repeatedly and add them to this page.",
				),
				'faq_cta_btn'     => array( 'Enquire now', 'Get in touch' ),
				'faq_cta_url'     => array( '/enquire/', 'enquire' ),
			),
		),
		array(
			'path'     => 'how-it-works',
			'defaults' => function_exists( 'restwell_get_how_it_works_page_defaults' ) ? restwell_get_how_it_works_page_defaults() : array(),
			'stale'    => array(
				'hiw_cta_heading'         => array( 'Start with a conversation.', 'Ready to plan your break?' ),
				'hiw_cta_body'            => array(
					'No commitment, no lengthy forms. Just get in touch and we\'ll take it from there.',
					'No commitment, no lengthy forms. Just get in touch and we&apos;ll take it from there.',
				),
				'hiw_cta_primary_label'   => array( 'Enquire now', 'Get in touch' ),
				'hiw_cta_primary_url'     => array( '/enquire/' ),
				'hiw_cta_secondary_label' => array( 'See the property', 'Tour the property' ),
				'hiw_cta_secondary_url'   => array( '/the-property/' ),
			),
		),
	);

	foreach ( $targets as $target ) {
		$page = get_page_by_path( $target['path'], OBJECT, 'page' );
		if ( ! $page instanceof WP_Post ) {
			continue;
		}
		$page_id  = (int) $page->ID;
		$defaults = is_array( $target['defaults'] ) ? $target['defaults'] : array();
		foreach ( $target['stale'] as $key => $stale_values ) {
			if ( ! isset( $defaults[ $key ] ) ) {
				continue;
			}
			$current = trim( (string) get_post_meta( $page_id, $key, true ) );
			$next    = (string) $defaults[ $key ];
			if ( $current === $next ) {
				continue;
			}
			if ( '' === $current || in_array( $current, $stale_values, true ) ) {
				update_post_meta( $page_id, $key, $next );
			}
		}
	}

	update_option( 'restwell_mid_cta_concept_copy_v35', '1', false );
}

/**
 * Seed empty mid-page Page Content keys for Care, Our Story, and How It Works.
 *
 * New arrival/care-type/care/story fields ship with PHP fallbacks; this only
 * writes defaults into empty post meta so editors see the live copy in WP Admin.
 * Non-empty meta is never overwritten.
 */
function restwell_migrate_midpage_meta_seed_v36() {
	if ( get_option( 'restwell_midpage_meta_seed_v36', '' ) === '1' ) {
		return;
	}

	$targets = array(
		array(
			'path'     => 'how-it-works',
			'defaults' => function_exists( 'restwell_get_how_it_works_page_defaults' ) ? restwell_get_how_it_works_page_defaults() : array(),
			'prefixes' => array( 'hiw_arrival_', 'hiw_care_type', 'hiw_care_note', 'hiw_care_rates_', 'hiw_faq_4_' ),
		),
		array(
			'path'     => 'optional-care',
			'defaults' => function_exists( 'restwell_get_care_page_defaults' ) ? restwell_get_care_page_defaults() : array(),
			'prefixes' => array(
				'care_sister_',
				'care_support_',
				'care_own_',
				'care_how_',
				'care_cqc_',
				'care_pro_',
				'care_faq_',
			),
		),
		array(
			'path'     => 'our-story',
			'defaults' => function_exists( 'restwell_get_our_story_page_defaults' ) ? restwell_get_our_story_page_defaults() : array(),
			'prefixes' => array(
				'story_origin_',
				'story_month_',
				'story_host_',
				'story_companies_',
				'story_shaped_',
				'story_specialists_',
				'story_next_',
			),
		),
	);

	foreach ( $targets as $target ) {
		$page = get_page_by_path( $target['path'], OBJECT, 'page' );
		if ( ! $page instanceof WP_Post ) {
			continue;
		}
		$page_id  = (int) $page->ID;
		$defaults = is_array( $target['defaults'] ) ? $target['defaults'] : array();
		foreach ( $defaults as $key => $value ) {
			$match = false;
			foreach ( $target['prefixes'] as $prefix ) {
				if ( 0 === strpos( (string) $key, $prefix ) ) {
					$match = true;
					break;
				}
			}
			if ( ! $match ) {
				continue;
			}
			$current = (string) get_post_meta( $page_id, $key, true );
			if ( '' !== trim( $current ) ) {
				continue;
			}
			update_post_meta( $page_id, $key, (string) $value );
		}
	}

	update_option( 'restwell_midpage_meta_seed_v36', '1', false );
}

/**
 * Seed empty Accessibility mid-page meta and Care how-step fields (empty keys only).
 *
 * Room/gallery/destination and care payment-step fields ship with PHP fallbacks;
 * this only writes defaults into empty post meta so editors see the live copy in WP Admin.
 * Non-empty meta is never overwritten.
 */
function restwell_migrate_acc_care_steps_seed_v37() {
	if ( get_option( 'restwell_acc_care_steps_seed_v37', '' ) === '1' ) {
		return;
	}

	$targets = array(
		array(
			'path'     => 'accessibility',
			'defaults' => function_exists( 'restwell_get_accessibility_page_defaults' ) ? restwell_get_accessibility_page_defaults() : array(),
			'prefixes' => array(
				'acc_gallery_',
				'acc_room_',
				'acc_arrival_',
				'acc_inside_',
				'acc_bedroom_',
				'acc_bathroom_',
				'acc_kitchen_',
				'acc_outdoor_',
				'acc_dest_',
			),
		),
		array(
			'path'     => 'optional-care',
			'defaults' => function_exists( 'restwell_get_care_page_defaults' ) ? restwell_get_care_page_defaults() : array(),
			'prefixes' => array( 'care_how_step' ),
		),
	);

	foreach ( $targets as $target ) {
		$page = get_page_by_path( $target['path'], OBJECT, 'page' );
		if ( ! $page instanceof WP_Post ) {
			continue;
		}
		$page_id  = (int) $page->ID;
		$defaults = is_array( $target['defaults'] ) ? $target['defaults'] : array();
		foreach ( $defaults as $key => $value ) {
			$match = false;
			foreach ( $target['prefixes'] as $prefix ) {
				if ( 0 === strpos( (string) $key, $prefix ) ) {
					$match = true;
					break;
				}
			}
			if ( ! $match ) {
				continue;
			}
			$current = (string) get_post_meta( $page_id, $key, true );
			if ( '' !== trim( $current ) ) {
				continue;
			}
			update_post_meta( $page_id, $key, (string) $value );
		}
	}

	update_option( 'restwell_acc_care_steps_seed_v37', '1', false );
}

/**
 * Seed empty Accessibility Access FAQ meta (empty keys only).
 *
 * FAQ fields ship with PHP fallbacks; this only writes defaults into empty
 * post meta so editors see the live copy in WP Admin. Non-empty meta is never overwritten.
 */
function restwell_migrate_acc_faq_seed_v38() {
	if ( get_option( 'restwell_acc_faq_seed_v38', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'accessibility', OBJECT, 'page' );
	if ( ! $page instanceof WP_Post ) {
		update_option( 'restwell_acc_faq_seed_v38', '1', false );
		return;
	}

	$page_id  = (int) $page->ID;
	$defaults = function_exists( 'restwell_get_accessibility_page_defaults' )
		? restwell_get_accessibility_page_defaults()
		: array();
	$prefix   = 'acc_faq_';

	foreach ( $defaults as $key => $value ) {
		if ( 0 !== strpos( (string) $key, $prefix ) ) {
			continue;
		}
		$current = (string) get_post_meta( $page_id, $key, true );
		if ( '' !== trim( $current ) ) {
			continue;
		}
		update_post_meta( $page_id, $key, (string) $value );
	}

	update_option( 'restwell_acc_faq_seed_v38', '1', false );
}

/**
 * Seed empty Who It's For mid-body Page Content meta (empty keys only).
 *
 * Audience, kit captions, funding routes, and CTA fields ship with PHP
 * fallbacks; this only writes defaults into empty post meta so editors see
 * the live copy in WP Admin. Non-empty meta is never overwritten.
 */
function restwell_migrate_wif_midbody_seed_v39() {
	if ( get_option( 'restwell_wif_midbody_seed_v39', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'who-its-for', OBJECT, 'page' );
	if ( ! $page instanceof WP_Post ) {
		update_option( 'restwell_wif_midbody_seed_v39', '1', false );
		return;
	}

	$page_id  = (int) $page->ID;
	$defaults = function_exists( 'restwell_get_who_its_for_page_defaults' )
		? restwell_get_who_its_for_page_defaults()
		: array();

	foreach ( $defaults as $key => $value ) {
		$key = (string) $key;
		if ( 0 !== strpos( $key, 'wif_' ) ) {
			continue;
		}
		// Hero fields already seeded by earlier migrations / copy-overwrites.
		if ( in_array( $key, array( 'wif_heading', 'wif_intro', 'wif_label', 'wif_hero_image_id' ), true ) ) {
			continue;
		}
		$current = (string) get_post_meta( $page_id, $key, true );
		if ( '' !== trim( $current ) ) {
			continue;
		}
		update_post_meta( $page_id, $key, (string) $value );
	}

	update_option( 'restwell_wif_midbody_seed_v39', '1', false );
}

/**
 * Seed empty Property room-tour / care / location / gallery / CTA meta (empty keys only).
 *
 * Room bands now read from Page Content; this only writes defaults into empty
 * post meta so editors see the live copy in WP Admin. Non-empty meta is never overwritten.
 */
function restwell_migrate_property_room_tour_seed_v40() {
	if ( get_option( 'restwell_property_room_tour_seed_v40', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'the-property', OBJECT, 'page' );
	if ( ! $page instanceof WP_Post ) {
		update_option( 'restwell_property_room_tour_seed_v40', '1', false );
		return;
	}

	$page_id  = (int) $page->ID;
	$defaults = function_exists( 'restwell_get_property_page_defaults' )
		? restwell_get_property_page_defaults()
		: array();

	$prefixes = array(
		'prop_bedrooms_section_',
		'prop_wetroom_',
		'prop_living_',
		'prop_kitchen_',
		'prop_conservatory_',
		'prop_garden_',
		'prop_throughout_',
		'prop_tour_',
		'prop_care_',
		'prop_location_',
		'prop_gallery_',
		'prop_cta_',
	);

	foreach ( $defaults as $key => $value ) {
		$match = false;
		foreach ( $prefixes as $prefix ) {
			if ( 0 === strpos( (string) $key, $prefix ) ) {
				$match = true;
				break;
			}
		}
		if ( ! $match ) {
			continue;
		}
		$current = (string) get_post_meta( $page_id, $key, true );
		if ( '' !== trim( $current ) ) {
			continue;
		}
		update_post_meta( $page_id, $key, (string) $value );
	}

	update_option( 'restwell_property_room_tour_seed_v40', '1', false );
}

/**
 * Seed empty Whitstable guide + Funding & support mid-page meta (empty keys only).
 *
 * Section heads, bodies, spotlight slots, related guides, and funding route
 * fields ship with PHP fallbacks; this only writes defaults into empty post
 * meta so editors see the live copy in WP Admin. Non-empty meta is never overwritten.
 */
function restwell_migrate_wg_resources_seed_v41() {
	if ( get_option( 'restwell_wg_resources_seed_v41', '' ) === '1' ) {
		return;
	}

	$targets = array(
		array(
			'path'     => 'whitstable-area-guide',
			'defaults' => function_exists( 'restwell_get_whitstable_guide_page_defaults' )
				? restwell_get_whitstable_guide_page_defaults()
				: array(),
			'skip'     => array( 'wg_heading', 'wg_intro', 'wg_label', 'wg_hero_image_id' ),
			'prefix'   => 'wg_',
		),
		array(
			'path'     => 'funding-and-support',
			'defaults' => function_exists( 'restwell_get_resources_page_defaults' )
				? restwell_get_resources_page_defaults()
				: array(),
			'skip'     => array( 'res_heading', 'res_intro', 'res_label', 'res_hero_image_id' ),
			'prefix'   => 'res_',
		),
	);

	foreach ( $targets as $target ) {
		$page = get_page_by_path( $target['path'], OBJECT, 'page' );
		if ( ! $page instanceof WP_Post ) {
			continue;
		}
		$page_id  = (int) $page->ID;
		$defaults = is_array( $target['defaults'] ) ? $target['defaults'] : array();
		$skip     = is_array( $target['skip'] ) ? $target['skip'] : array();
		$prefix   = (string) $target['prefix'];

		foreach ( $defaults as $key => $value ) {
			$key = (string) $key;
			if ( 0 !== strpos( $key, $prefix ) ) {
				continue;
			}
			if ( in_array( $key, $skip, true ) ) {
				continue;
			}
			$current = (string) get_post_meta( $page_id, $key, true );
			if ( '' !== trim( $current ) ) {
				continue;
			}
			update_post_meta( $page_id, $key, (string) $value );
		}
	}

	update_option( 'restwell_wg_resources_seed_v41', '1', false );
}

/**
 * Seed empty homepage care/FAQ chrome and pricing narrative section meta (empty keys only).
 *
 * Care band, FAQ chrome, and pricing rates/payment/care-rates intros ship with
 * PHP fallbacks; this only writes defaults into empty post meta so editors see
 * the live copy in WP Admin. Non-empty meta is never overwritten.
 */
function restwell_migrate_home_pricing_chrome_seed_v42() {
	if ( get_option( 'restwell_home_pricing_chrome_seed_v42', '' ) === '1' ) {
		return;
	}

	$front_id = (int) get_option( 'page_on_front', 0 );
	if ( $front_id <= 0 ) {
		$home = get_page_by_path( 'home', OBJECT, 'page' );
		if ( $home instanceof WP_Post ) {
			$front_id = (int) $home->ID;
		}
	}

	if ( $front_id > 0 ) {
		$home_defaults = function_exists( 'restwell_get_theme_setup_defaults' )
			? restwell_get_theme_setup_defaults()
			: array();
		$home_keys     = array(
			'home_care_label',
			'home_care_heading',
			'home_care_intro',
			'home_care_item1_title',
			'home_care_item1_body',
			'home_care_item2_title',
			'home_care_item2_body',
			'home_care_note',
			'home_care_cta_label',
			'home_care_cta_url',
			'home_faq_label',
			'home_faq_heading',
		);
		foreach ( $home_keys as $key ) {
			if ( ! array_key_exists( $key, $home_defaults ) ) {
				continue;
			}
			$current = (string) get_post_meta( $front_id, $key, true );
			if ( '' !== trim( $current ) ) {
				continue;
			}
			update_post_meta( $front_id, $key, (string) $home_defaults[ $key ] );
		}
	}

	$pricing = get_page_by_path( 'pricing', OBJECT, 'page' );
	if ( $pricing instanceof WP_Post ) {
		$pricing_id       = (int) $pricing->ID;
		$pricing_defaults = function_exists( 'restwell_get_pricing_page_defaults' )
			? restwell_get_pricing_page_defaults()
			: array();
		$pricing_keys     = array(
			'pricing_rates_label',
			'pricing_rates_heading',
			'pricing_rates_intro',
			'pricing_payment_label',
			'pricing_payment_heading',
			'pricing_payment_intro',
			'pricing_care_rates_label',
			'pricing_care_rates_heading',
			'pricing_care_rates_intro',
		);
		foreach ( $pricing_keys as $key ) {
			if ( ! array_key_exists( $key, $pricing_defaults ) ) {
				continue;
			}
			$current = (string) get_post_meta( $pricing_id, $key, true );
			if ( '' !== trim( $current ) ) {
				continue;
			}
			update_post_meta( $pricing_id, $key, (string) $pricing_defaults[ $key ] );
		}
	}

	update_option( 'restwell_home_pricing_chrome_seed_v42', '1', false );
}

/**
 * Seed empty Accessibility key-measurement and fit-checker chrome (empty keys only).
 *
 * Door gauge millimetre values stay in the template (JS data attributes); this
 * only seeds the visitor-facing labels/copy editors change most often.
 */
function restwell_migrate_acc_fit_stats_seed_v43() {
	if ( get_option( 'restwell_acc_fit_stats_seed_v43', '' ) === '1' ) {
		return;
	}

	$acc = get_page_by_path( 'accessibility', OBJECT, 'page' );
	if ( $acc instanceof WP_Post ) {
		$acc_id       = (int) $acc->ID;
		$acc_defaults = function_exists( 'restwell_get_accessibility_page_defaults' )
			? restwell_get_accessibility_page_defaults()
			: array();
		$acc_keys     = array(
			'acc_stat_1_label',
			'acc_stat_1_value',
			'acc_stat_2_label',
			'acc_stat_2_value',
			'acc_stat_3_label',
			'acc_stat_3_value',
			'acc_fit_label',
			'acc_fit_heading',
			'acc_fit_intro',
			'acc_fit_note',
			'acc_fit_guide_heading',
			'acc_fit_guide_intro',
		);
		foreach ( $acc_keys as $key ) {
			if ( ! array_key_exists( $key, $acc_defaults ) ) {
				continue;
			}
			$current = (string) get_post_meta( $acc_id, $key, true );
			if ( '' !== trim( $current ) ) {
				continue;
			}
			update_post_meta( $acc_id, $key, (string) $acc_defaults[ $key ] );
		}
	}

	update_option( 'restwell_acc_fit_stats_seed_v43', '1', false );
}

/**
 * Replace Funding page plain-text fields that still hold raw HTML blobs.
 *
 * Older seeds stored markup (lists/anchors) in `res_grants_body` /
 * `res_complaints_body`. The template renders those with esc_html(), so visitors
 * saw literal tags. Reset only when the stored value still contains tags.
 */
function restwell_migrate_resources_html_plain_v44() {
	if ( get_option( 'restwell_resources_html_plain_v44', '' ) === '1' ) {
		return;
	}

	$resources = get_page_by_path( 'funding-and-support', OBJECT, 'page' );
	if ( ! ( $resources instanceof WP_Post ) ) {
		$resources = get_page_by_path( 'resources', OBJECT, 'page' );
	}
	if ( $resources instanceof WP_Post ) {
		$res_id       = (int) $resources->ID;
		$res_defaults = function_exists( 'restwell_get_resources_page_defaults' )
			? restwell_get_resources_page_defaults()
			: array();
		$keys         = array( 'res_grants_body', 'res_complaints_body' );
		foreach ( $keys as $key ) {
			if ( ! array_key_exists( $key, $res_defaults ) ) {
				continue;
			}
			$current = (string) get_post_meta( $res_id, $key, true );
			if ( '' === trim( $current ) ) {
				continue;
			}
			if ( false === strpos( $current, '<' ) ) {
				continue;
			}
			update_post_meta( $res_id, $key, (string) $res_defaults[ $key ] );
		}
	}

	update_option( 'restwell_resources_html_plain_v44', '1', false );
}

/**
 * Push Accessibility room-by-room bodies from the equipment register brief.
 *
 * Overwrites the six room body keys (and intro) so live WP meta picks up
 * Geberit WC, Oxford Midi, AAL RS4, NEFF oven, and outdoor door widths.
 * Headings are left alone if already set.
 */
function restwell_migrate_acc_room_register_v45() {
	if ( get_option( 'restwell_acc_room_register_v45', '' ) === '1' ) {
		return;
	}

	$acc = get_page_by_path( 'accessibility', OBJECT, 'page' );
	if ( $acc instanceof WP_Post ) {
		$acc_id       = (int) $acc->ID;
		$acc_defaults = function_exists( 'restwell_get_accessibility_page_defaults' )
			? restwell_get_accessibility_page_defaults()
			: array();
		$keys         = array(
			'acc_room_intro',
			'acc_arrival_body',
			'acc_inside_body',
			'acc_bedroom_body',
			'acc_bathroom_body',
			'acc_kitchen_body',
			'acc_outdoor_body',
		);
		foreach ( $keys as $key ) {
			if ( ! array_key_exists( $key, $acc_defaults ) ) {
				continue;
			}
			update_post_meta( $acc_id, $key, (string) $acc_defaults[ $key ] );
		}
	}

	update_option( 'restwell_acc_room_register_v45', '1', false );
}

/**
 * Trim Accessibility bedroom/wet-room bodies and reset the room eyebrow.
 *
 * Summary bullets sit above a --- separator; kit detail renders in a
 * disclosure. Eyebrow becomes "Access statement" (not "The property").
 */
function restwell_migrate_acc_room_trim_v46() {
	if ( get_option( 'restwell_acc_room_trim_v46', '' ) === '1' ) {
		return;
	}

	$acc = get_page_by_path( 'accessibility', OBJECT, 'page' );
	if ( $acc instanceof WP_Post ) {
		$acc_id       = (int) $acc->ID;
		$acc_defaults = function_exists( 'restwell_get_accessibility_page_defaults' )
			? restwell_get_accessibility_page_defaults()
			: array();
		$keys         = array(
			'acc_room_label',
			'acc_bedroom_body',
			'acc_bathroom_body',
		);
		foreach ( $keys as $key ) {
			if ( ! array_key_exists( $key, $acc_defaults ) ) {
				continue;
			}
			update_post_meta( $acc_id, $key, (string) $acc_defaults[ $key ] );
		}
	}

	update_option( 'restwell_acc_room_trim_v46', '1', false );
}

/**
 * Design-audit P1: hero USP lede + unify primary CTA to Enquire.
 *
 * Also strips trailing period from pricing mid-CTA and points secondary
 * at #availability.
 */
function restwell_migrate_design_audit_cta_usp_v47() {
	if ( get_option( 'restwell_design_audit_cta_usp_v47', '' ) === '1' ) {
		return;
	}

	$home = (int) get_option( 'page_on_front', 0 );
	if ( $home <= 0 ) {
		$front = get_page_by_path( 'home', OBJECT, 'page' );
		if ( $front instanceof WP_Post ) {
			$home = (int) $front->ID;
		}
	}
	if ( $home > 0 && function_exists( 'restwell_get_theme_setup_defaults' ) ) {
		$defaults = restwell_get_theme_setup_defaults();
		$keys     = array(
			'hero_subheading',
			'hero_cta_primary_label',
			'cta_primary_label',
		);
		foreach ( $keys as $key ) {
			if ( ! array_key_exists( $key, $defaults ) ) {
				continue;
			}
			update_post_meta( $home, $key, (string) $defaults[ $key ] );
		}
	}

	$pricing = get_page_by_path( 'pricing', OBJECT, 'page' );
	if ( $pricing instanceof WP_Post && function_exists( 'restwell_get_pricing_page_defaults' ) ) {
		$pricing_id = (int) $pricing->ID;
		$defaults   = restwell_get_pricing_page_defaults();
		$keys       = array(
			'pricing_cta_heading',
			'pricing_cta_primary_label',
			'pricing_cta_secondary_label',
			'pricing_cta_secondary_url',
		);
		foreach ( $keys as $key ) {
			if ( ! array_key_exists( $key, $defaults ) ) {
				continue;
			}
			update_post_meta( $pricing_id, $key, (string) $defaults[ $key ] );
		}
	}

	update_option( 'restwell_design_audit_cta_usp_v47', '1', false );
}

/**
 * Hero lede: owner line, no em dash, SEO kit nouns retained.
 */
function restwell_migrate_home_hero_lede_v48() {
	if ( get_option( 'restwell_home_hero_lede_v48', '' ) === '1' ) {
		return;
	}

	$home = (int) get_option( 'page_on_front', 0 );
	if ( $home <= 0 ) {
		$front = get_page_by_path( 'home', OBJECT, 'page' );
		if ( $front instanceof WP_Post ) {
			$home = (int) $front->ID;
		}
	}
	if ( $home > 0 && function_exists( 'restwell_get_theme_setup_defaults' ) ) {
		$defaults = restwell_get_theme_setup_defaults();
		if ( isset( $defaults['hero_subheading'] ) ) {
			update_post_meta( $home, 'hero_subheading', (string) $defaults['hero_subheading'] );
		}
	}

	update_option( 'restwell_home_hero_lede_v48', '1', false );
}

/**
 * Strip em dash from home hero lede (owner: no em dash in on-page copy).
 */
function restwell_migrate_home_hero_lede_no_emdash_v49() {
	if ( get_option( 'restwell_home_hero_lede_no_emdash_v49', '' ) === '1' ) {
		return;
	}

	$home = (int) get_option( 'page_on_front', 0 );
	if ( $home <= 0 ) {
		$front = get_page_by_path( 'home', OBJECT, 'page' );
		if ( $front instanceof WP_Post ) {
			$home = (int) $front->ID;
		}
	}
	if ( $home > 0 && function_exists( 'restwell_get_theme_setup_defaults' ) ) {
		$defaults = restwell_get_theme_setup_defaults();
		if ( isset( $defaults['hero_subheading'] ) ) {
			update_post_meta( $home, 'hero_subheading', (string) $defaults['hero_subheading'] );
		}
	}

	update_option( 'restwell_home_hero_lede_no_emdash_v49', '1', false );
}

/**
 * Clarify home care is arranged/quoted separately (not free / not in bungalow rate).
 */
function restwell_migrate_care_not_free_copy_v50() {
	if ( get_option( 'restwell_care_not_free_copy_v50', '' ) === '1' ) {
		return;
	}

	$home = (int) get_option( 'page_on_front', 0 );
	if ( $home <= 0 ) {
		$front = get_page_by_path( 'home', OBJECT, 'page' );
		if ( $front instanceof WP_Post ) {
			$home = (int) $front->ID;
		}
	}
	if ( $home > 0 && function_exists( 'restwell_get_theme_setup_defaults' ) ) {
		$defaults = restwell_get_theme_setup_defaults();
		foreach ( array( 'hero_subheading', 'home_care_heading' ) as $key ) {
			if ( isset( $defaults[ $key ] ) ) {
				update_post_meta( $home, $key, (string) $defaults[ $key ] );
			}
		}
	}

	update_option( 'restwell_care_not_free_copy_v50', '1', false );
}

/**
 * Hero composition copy + mid-CTA labels (Enquire; strip trailing periods on H2s).
 */
function restwell_migrate_hero_midcta_craft_v51() {
	if ( get_option( 'restwell_hero_midcta_craft_v51', '' ) === '1' ) {
		return;
	}

	if ( ! function_exists( 'restwell_get_theme_setup_defaults' ) ) {
		update_option( 'restwell_hero_midcta_craft_v51', '1', false );
		return;
	}

	$defaults = restwell_get_theme_setup_defaults();
	$home     = (int) get_option( 'page_on_front', 0 );
	if ( $home <= 0 ) {
		$front = get_page_by_path( 'home', OBJECT, 'page' );
		if ( $front instanceof WP_Post ) {
			$home = (int) $front->ID;
		}
	}
	if ( $home > 0 ) {
		foreach ( array( 'hero_heading', 'hero_subheading' ) as $key ) {
			if ( isset( $defaults[ $key ] ) ) {
				update_post_meta( $home, $key, (string) $defaults[ $key ] );
			}
		}
	}

	$cta_map = array(
		'the-property'           => array( 'prop_cta_heading', 'prop_cta_btn' ),
		'how-it-works'           => array( 'hiw_cta_heading', 'hiw_cta_primary_label' ),
		'accessibility'          => array( 'acc_cta_heading', 'acc_cta_btn' ),
		'faq'                    => array( 'faq_cta_btn' ),
		'funding-and-support'    => array( 'res_cta_heading', 'res_cta_btn' ),
		'who-its-for'            => array( 'wif_cta_primary_label' ),
		'whitstable-area-guide'  => array( 'wg_cta_primary_label' ),
		'optional-care'          => array( 'care_cta_primary_label' ),
		'our-story'              => array( 'story_cta_heading', 'story_cta_primary_label' ),
	);

	foreach ( $cta_map as $slug => $keys ) {
		$page = get_page_by_path( $slug, OBJECT, 'page' );
		if ( ! ( $page instanceof WP_Post ) ) {
			continue;
		}
		foreach ( $keys as $key ) {
			if ( isset( $defaults[ $key ] ) ) {
				update_post_meta( (int) $page->ID, $key, (string) $defaults[ $key ] );
			}
		}
	}

	update_option( 'restwell_hero_midcta_craft_v51', '1', false );
}

/**
 * Design-audit: SEO H1 (accessible holidays Whitstable) + care-panel tease copy.
 */
function restwell_migrate_hero_seo_h1_v52() {
	if ( get_option( 'restwell_hero_seo_h1_v52', '' ) === '1' ) {
		return;
	}

	if ( ! function_exists( 'restwell_get_theme_setup_defaults' ) ) {
		update_option( 'restwell_hero_seo_h1_v52', '1', false );
		return;
	}

	$defaults = restwell_get_theme_setup_defaults();
	$home     = (int) get_option( 'page_on_front', 0 );
	if ( $home <= 0 ) {
		$front = get_page_by_path( 'home', OBJECT, 'page' );
		if ( $front instanceof WP_Post ) {
			$home = (int) $front->ID;
		}
	}
	if ( $home > 0 ) {
		foreach ( array( 'hero_heading', 'hero_subheading' ) as $key ) {
			if ( isset( $defaults[ $key ] ) ) {
				update_post_meta( $home, $key, (string) $defaults[ $key ] );
			}
		}
	}

	$prop = get_page_by_path( 'the-property', OBJECT, 'page' );
	if ( $prop instanceof WP_Post ) {
		foreach ( array( 'prop_care_heading', 'prop_care_body' ) as $key ) {
			if ( isset( $defaults[ $key ] ) ) {
				update_post_meta( (int) $prop->ID, $key, (string) $defaults[ $key ] );
			}
		}
	}

	$hiw = get_page_by_path( 'how-it-works', OBJECT, 'page' );
	if ( $hiw instanceof WP_Post && isset( $defaults['hiw_care_cta_body'] ) ) {
		update_post_meta( (int) $hiw->ID, 'hiw_care_cta_body', (string) $defaults['hiw_care_cta_body'] );
	}

	update_option( 'restwell_hero_seo_h1_v52', '1', false );
}

/**
 * Continuity wording: “home care from Continuity”, not “Optional Continuity care”.
 */
function restwell_migrate_continuity_wording_v53() {
	if ( get_option( 'restwell_continuity_wording_v53', '' ) === '1' ) {
		return;
	}

	if ( ! function_exists( 'restwell_get_theme_setup_defaults' ) ) {
		update_option( 'restwell_continuity_wording_v53', '1', false );
		return;
	}

	$defaults = restwell_get_theme_setup_defaults();
	$home     = (int) get_option( 'page_on_front', 0 );
	if ( $home <= 0 ) {
		$front = get_page_by_path( 'home', OBJECT, 'page' );
		if ( $front instanceof WP_Post ) {
			$home = (int) $front->ID;
		}
	}
	if ( $home > 0 && isset( $defaults['hero_subheading'] ) ) {
		update_post_meta( $home, 'hero_subheading', (string) $defaults['hero_subheading'] );
	}

	$prop = get_page_by_path( 'the-property', OBJECT, 'page' );
	if ( $prop instanceof WP_Post ) {
		foreach ( array( 'prop_care_heading', 'prop_care_body' ) as $key ) {
			if ( isset( $defaults[ $key ] ) ) {
				update_post_meta( (int) $prop->ID, $key, (string) $defaults[ $key ] );
			}
		}
	}

	$hiw = get_page_by_path( 'how-it-works', OBJECT, 'page' );
	if ( $hiw instanceof WP_Post && isset( $defaults['hiw_care_cta_body'] ) ) {
		update_post_meta( (int) $hiw->ID, 'hiw_care_cta_body', (string) $defaults['hiw_care_cta_body'] );
	}

	update_option( 'restwell_continuity_wording_v53', '1', false );
}

/**
 * Design/IA: de-duplicate the access page.
 *
 * /accessibility/ was repeating itself — door widths in four places, hoist and
 * bed specs in three, "ask us for a measurement" in six — and its room-by-room
 * photo walk was a second copy of the /the-property/ tour. The tour and the
 * feature gallery are gone and their route facts live once in the equipment
 * register, so their meta is retired here. FAQ 10 -> 4: the generic "what
 * should I check" questions were near-duplicates of each other and belong in
 * the planned blog master guide, not on the property's own access page.
 */
function restwell_migrate_acc_deduplicate_v54() {
	if ( get_option( 'restwell_acc_deduplicate_v54', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'accessibility', OBJECT, 'page' );
	if ( ! ( $page instanceof WP_Post ) ) {
		// Page may be created later by Theme Setup — retry on a later request.
		return;
	}
	$page_id = (int) $page->ID;

	// Nothing renders these any more and no admin field edits them.
	$retired = array(
		'acc_room_label',
		'acc_room_heading',
		'acc_room_intro',
		'acc_gallery_label',
		'acc_gallery_heading',
		'acc_gallery_intro',
		'acc_gallery_image_ids',
	);
	foreach ( array( 'arrival', 'inside', 'bedroom', 'bathroom', 'kitchen', 'outdoor' ) as $room ) {
		$retired[] = 'acc_' . $room . '_heading';
		$retired[] = 'acc_' . $room . '_body';
	}
	foreach ( $retired as $key ) {
		delete_post_meta( $page_id, $key );
	}

	$faq = array(
		1 => array(
			'q' => 'Do you provide hoist slings?',
			'a' => 'No. Slings are prescribed items of personal care, fitted to the individual and to the hoist mechanism, so it would not be safe for us to supply one. Both hoists here take loop-style slings on a two-point spreader bar. Please bring the sling the person already uses.',
		),
		2 => array(
			'q' => 'What is a ceiling track hoist in holiday accommodation?',
			'a' => 'It is fixed to the ceiling and moves a person in a sling along a rail, so it takes no floor space and needs no turning circle — unlike a mobile hoist, which has to be wheeled into position. Ours runs over the bed in the main bedroom. Full coverage, capacity and attachment details are in the equipment register above.',
		),
		3 => array(
			'q' => 'Why does a profiling bed matter in an accessible bedroom?',
			'a' => 'It helps with positioning, pressure care and safer transfers, and it sets a working height that protects the back of whoever is providing care. A fixed divan gives you none of that, and a mobile hoist often cannot get its legs underneath one. We have two profiling beds and lay the bedrooms out around your party.',
		),
		4 => array(
			'q' => 'What should “wheelchair friendly” actually mean?',
			'a' => 'It should mean published numbers you can check against your own chair and your own equipment: clear door openings, step-free routes, safe working loads, turning circles. If a listing says “wheelchair friendly” and will not give you a measurement when you ask, that tells you what you need to know. Everything we have is on this page.',
		),
	);
	foreach ( $faq as $n => $pair ) {
		$q_key = 'acc_faq_' . $n . '_q';
		$a_key = 'acc_faq_' . $n . '_a';
		$existing_q = (string) get_post_meta( $page_id, $q_key, true );
		$existing_a = (string) get_post_meta( $page_id, $a_key, true );
		// Seed empty slots; replace known pre-dedupe SEO copy; leave editor customisations.
		if ( '' === trim( $existing_q ) || restwell_migrate_acc_faq_is_legacy_v54( $existing_q ) ) {
			update_post_meta( $page_id, $q_key, $pair['q'] );
		}
		if ( '' === trim( $existing_a ) || restwell_migrate_acc_faq_is_legacy_v54( $existing_a ) ) {
			update_post_meta( $page_id, $a_key, $pair['a'] );
		}
	}

	// The retired questions would otherwise sit in the database as orphans.
	for ( $n = 5; $n <= 10; $n++ ) {
		delete_post_meta( $page_id, 'acc_faq_' . $n . '_q' );
		delete_post_meta( $page_id, 'acc_faq_' . $n . '_a' );
	}

	update_option( 'restwell_acc_deduplicate_v54', '1', false );
}

/**
 * Whether accessibility FAQ meta still holds the pre-v54 SEO-style copy.
 *
 * @param string $text Question or answer text.
 * @return bool
 */
function restwell_migrate_acc_faq_is_legacy_v54( string $text ): bool {
	$text = trim( $text );
	if ( '' === $text ) {
		return false;
	}
	// Question/answer openings from the old 10-item SEO set only.
	// Do not list strings that are also the post-v54 FAQ copy (e.g. FAQ 2’s question).
	$legacy_starts = array(
		'Can I find a holiday cottage with a ceiling hoist',
		'What should I check before booking a hoist-equipped',
		'Can I find a holiday cottage with a profiling bed',
		'Can I find a holiday cottage with a hospital-style',
		'Why does an adjustable or profiling bed matter',
		'What accessible equipment should I expect',
		'What should “wheelchair friendly holiday cottage” mean?',
		'What should "wheelchair friendly holiday cottage" mean?',
		'What do I need to check before booking an accessible holiday',
		'What makes an accessible bungalow in the UK suitable',
		'A ceiling track hoist is fixed to the ceiling and moves a person in a sling along a rail. It’s less bulky',
		'A ceiling track hoist is fixed to the ceiling and moves a person in a sling along a rail. It\'s less bulky',
		'Yes, they are uncommon. Confirm fixed ceiling track',
		'Yes, but make sure the bed is actually on site',
		'People searching for a “hospital bed holiday cottage”',
		'People searching for a "hospital bed holiday cottage"',
		'Profiling beds help with positioning, pressure care, safer transfers, and overnight care routines',
		'Ask for a published equipment list. Restwell includes a profiling bed',
		'Look for step-free routes, door widths that fit your chair',
		'Check for clear door openings, a step-free route from parking',
		'Being single-storey helps, but accessibility varies a lot',
		'Check the hoist type and safe working load, whether the bed is under the track',
	);
	foreach ( $legacy_starts as $start ) {
		if ( 0 === strpos( $text, $start ) ) {
			return true;
		}
	}
	return false;
}

/**
 * Refresh stored privacy policy HTML so it matches current GDPR wording
 * (FAQ collection, email-handled rights, no automated full-record wipe).
 */
function restwell_migrate_privacy_gdpr_align_v55() {
	if ( get_option( 'restwell_privacy_gdpr_align_v55', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'privacy-policy', OBJECT, 'page' );
	if ( ! ( $page instanceof WP_Post ) ) {
		return;
	}

	$html = (string) get_post_meta( $page->ID, 'legal_body_html', true );
	if ( '' !== trim( $html ) && false !== strpos( $html, 'We keep enquiry and booking-related records for up to three years' ) ) {
		delete_post_meta( $page->ID, 'legal_body_html' );
	}

	$intro = (string) get_post_meta( $page->ID, 'legal_intro', true );
	if ( false !== strpos( $intro, 'what we collect on the enquiry form' ) ) {
		update_post_meta(
			$page->ID,
			'legal_intro',
			'Who is responsible for your data, what we collect on enquiry, FAQ, booking and guest-guide records (including optional care notes), cookie choices, who we share data with, how long we keep records, and your UK GDPR rights (including contacting the ICO).'
		);
	}

	update_option( 'restwell_privacy_gdpr_align_v55', '1', false );
}

/**
 * Our Story copy: pick the clearer guest-facing beats from the 2026-09-11 draft
 * without flattening the Welcome Guide voice (hook line, “don’t have to trust us”).
 */
function restwell_migrate_our_story_copy_v56() {
	if ( get_option( 'restwell_our_story_copy_v56', '' ) === '1' ) {
		return;
	}

	if ( ! function_exists( 'restwell_get_our_story_page_defaults' ) ) {
		update_option( 'restwell_our_story_copy_v56', '1', false );
		return;
	}

	$page = get_page_by_path( 'our-story', OBJECT, 'page' );
	if ( ! ( $page instanceof WP_Post ) ) {
		return;
	}

	$defaults = restwell_get_our_story_page_defaults();
	if ( ! is_array( $defaults ) ) {
		update_option( 'restwell_our_story_copy_v56', '1', false );
		return;
	}

	$page_id = (int) $page->ID;
	foreach ( $defaults as $key => $value ) {
		if ( ! is_string( $value ) || '' === $value ) {
			continue;
		}
		update_post_meta( $page_id, $key, $value );
	}

	update_option( 'restwell_our_story_copy_v56', '1', false );
}

/**
 * Drop stored privacy HTML that predates processor / transfer wording so the
 * theme fallback (current UK GDPR notice) is used.
 */
function restwell_migrate_privacy_gdpr_processors_v57() {
	if ( get_option( 'restwell_privacy_gdpr_processors_v57', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'privacy-policy', OBJECT, 'page' );
	if ( ! ( $page instanceof WP_Post ) ) {
		return;
	}

	$html = (string) get_post_meta( $page->ID, 'legal_body_html', true );
	if ( '' !== trim( $html ) && false === strpos( $html, 'Who we share data with' ) ) {
		delete_post_meta( $page->ID, 'legal_body_html' );
	}

	$intro = (string) get_post_meta( $page->ID, 'legal_intro', true );
	if ( '' !== $intro && false === strpos( $intro, 'who we share data with' ) ) {
		update_post_meta(
			$page->ID,
			'legal_intro',
			'Who is responsible for your data, what we collect on enquiry, FAQ, booking and guest-guide records (including optional care notes), cookie choices, who we share data with, how long we keep records, and your UK GDPR rights (including contacting the ICO).'
		);
	}

	$terms = get_page_by_path( 'terms-and-conditions', OBJECT, 'page' );
	if ( $terms instanceof WP_Post ) {
		$terms_html = (string) get_post_meta( $terms->ID, 'legal_body_html', true );
		if ( '' !== trim( $terms_html ) && false !== strpos( $terms_html, '<h2>Your data</h2>' ) && false === strpos( $terms_html, 'Your data and cookies' ) ) {
			delete_post_meta( $terms->ID, 'legal_body_html' );
		}
	}

	update_option( 'restwell_privacy_gdpr_processors_v57', '1', false );
}

/**
 * Our Story build lede: OTs viewed the house; profiling bed was one of the changes.
 */
function restwell_migrate_our_story_ot_bed_v58() {
	if ( get_option( 'restwell_our_story_ot_bed_v58', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'our-story', OBJECT, 'page' );
	if ( ! ( $page instanceof WP_Post ) ) {
		return;
	}

	$lede = '';
	if ( function_exists( 'restwell_get_our_story_page_defaults' ) ) {
		$defaults = restwell_get_our_story_page_defaults();
		if ( is_array( $defaults ) && isset( $defaults['story_month_lede'] ) && is_string( $defaults['story_month_lede'] ) ) {
			$lede = $defaults['story_month_lede'];
		}
	}

	if ( '' === $lede ) {
		update_option( 'restwell_our_story_ot_bed_v58', '1', false );
		return;
	}

	update_post_meta( (int) $page->ID, 'story_month_lede', $lede );
	update_option( 'restwell_our_story_ot_bed_v58', '1', false );
}

/**
 * Our Story companies note: drop the sarcastic “doesn’t pretend / we’re a house” line.
 */
function restwell_migrate_our_story_cqc_note_v59() {
	if ( get_option( 'restwell_our_story_cqc_note_v59', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'our-story', OBJECT, 'page' );
	if ( ! ( $page instanceof WP_Post ) ) {
		return;
	}

	$note = '';
	if ( function_exists( 'restwell_get_our_story_page_defaults' ) ) {
		$defaults = restwell_get_our_story_page_defaults();
		if ( is_array( $defaults ) && isset( $defaults['story_companies_note'] ) && is_string( $defaults['story_companies_note'] ) ) {
			$note = $defaults['story_companies_note'];
		}
	}

	if ( '' === $note ) {
		update_option( 'restwell_our_story_cqc_note_v59', '1', false );
		return;
	}

	update_post_meta( (int) $page->ID, 'story_companies_note', $note );
	update_option( 'restwell_our_story_cqc_note_v59', '1', false );
}

/**
 * Re-apply the companies note after v59 wrote a stale string.
 */
function restwell_migrate_our_story_cqc_note_v60() {
	if ( get_option( 'restwell_our_story_cqc_note_v60', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'our-story', OBJECT, 'page' );
	if ( ! ( $page instanceof WP_Post ) ) {
		return;
	}

	if ( ! function_exists( 'restwell_get_our_story_page_defaults' ) ) {
		return;
	}

	$defaults = restwell_get_our_story_page_defaults();
	$note     = ( is_array( $defaults ) && isset( $defaults['story_companies_note'] ) && is_string( $defaults['story_companies_note'] ) )
		? $defaults['story_companies_note']
		: '';

	if ( '' === $note ) {
		return;
	}

	update_post_meta( (int) $page->ID, 'story_companies_note', $note );
	update_option( 'restwell_our_story_cqc_note_v60', '1', false );
}

/**
 * Shorten accessibility FAQ sling answer — full explanation lives in #equip-slings.
 */
function restwell_migrate_acc_sling_faq_v61() {
	if ( get_option( 'restwell_acc_sling_faq_v61', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'accessibility', OBJECT, 'page' );
	if ( ! ( $page instanceof WP_Post ) ) {
		return;
	}

	$old_answers = array(
		'No. Slings are prescribed items of personal care, fitted to the individual and to the hoist mechanism, so it would not be safe for us to supply one. Both hoists here take loop-style slings on a two-point spreader bar. Please bring the sling the person already uses.',
	);
	$new_answer = 'No. Bring the sling the person already uses — both hoists take loop-style slings on a two-point spreader bar. The note above the equipment register explains why we cannot supply one.';

	$current = (string) get_post_meta( (int) $page->ID, 'acc_faq_1_a', true );
	if ( '' === $current || in_array( $current, $old_answers, true ) ) {
		update_post_meta( (int) $page->ID, 'acc_faq_1_a', $new_answer );
	}

	update_option( 'restwell_acc_sling_faq_v61', '1', false );
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
		'restwell_pricing_dates_label_v33',
		'restwell_hiw_wired_copy_v34',
		'restwell_mid_cta_concept_copy_v35',
		'restwell_midpage_meta_seed_v36',
		'restwell_acc_care_steps_seed_v37',
		'restwell_acc_faq_seed_v38',
		'restwell_wif_midbody_seed_v39',
		'restwell_property_room_tour_seed_v40',
		'restwell_wg_resources_seed_v41',
		'restwell_home_pricing_chrome_seed_v42',
		'restwell_acc_fit_stats_seed_v43',
		'restwell_resources_html_plain_v44',
		'restwell_acc_room_register_v45',
		'restwell_acc_room_trim_v46',
		'restwell_design_audit_cta_usp_v47',
		'restwell_home_hero_lede_v48',
		'restwell_home_hero_lede_no_emdash_v49',
		'restwell_care_not_free_copy_v50',
		'restwell_hero_midcta_craft_v51',
		'restwell_hero_seo_h1_v52',
		'restwell_continuity_wording_v53',
		'restwell_acc_deduplicate_v54',
		'restwell_privacy_gdpr_align_v55',
		'restwell_our_story_copy_v56',
		'restwell_privacy_gdpr_processors_v57',
		'restwell_our_story_ot_bed_v58',
		'restwell_our_story_cqc_note_v59',
		'restwell_our_story_cqc_note_v60',
		'restwell_acc_sling_faq_v61',
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

	if ( (int) get_option( 'restwell_schema_version', 0 ) < 32 ) {
		restwell_maybe_load_spent_migrations_v29_v31();
		if ( function_exists( 'restwell_register_spent_migrations_v29_v31' ) ) {
			restwell_register_spent_migrations_v29_v31();
		}
	}

	add_action( 'init', 'restwell_migrate_guest_guide_meta_v32', 81 );
	add_action( 'after_switch_theme', 'restwell_migrate_guest_guide_meta_v32', 72 );
	add_action( 'init', 'restwell_migrate_pricing_dates_label_v33', 82 );
	add_action( 'after_switch_theme', 'restwell_migrate_pricing_dates_label_v33', 73 );
	add_action( 'init', 'restwell_migrate_hiw_wired_copy_v34', 83 );
	add_action( 'after_switch_theme', 'restwell_migrate_hiw_wired_copy_v34', 74 );
	add_action( 'init', 'restwell_migrate_mid_cta_concept_copy_v35', 84 );
	add_action( 'after_switch_theme', 'restwell_migrate_mid_cta_concept_copy_v35', 75 );
	add_action( 'init', 'restwell_migrate_midpage_meta_seed_v36', 85 );
	add_action( 'after_switch_theme', 'restwell_migrate_midpage_meta_seed_v36', 76 );
	add_action( 'init', 'restwell_migrate_acc_care_steps_seed_v37', 86 );
	add_action( 'after_switch_theme', 'restwell_migrate_acc_care_steps_seed_v37', 77 );
	add_action( 'init', 'restwell_migrate_acc_faq_seed_v38', 87 );
	add_action( 'after_switch_theme', 'restwell_migrate_acc_faq_seed_v38', 78 );
	add_action( 'init', 'restwell_migrate_wif_midbody_seed_v39', 88 );
	add_action( 'after_switch_theme', 'restwell_migrate_wif_midbody_seed_v39', 79 );
	add_action( 'init', 'restwell_migrate_property_room_tour_seed_v40', 89 );
	add_action( 'after_switch_theme', 'restwell_migrate_property_room_tour_seed_v40', 80 );
	add_action( 'init', 'restwell_migrate_wg_resources_seed_v41', 90 );
	add_action( 'after_switch_theme', 'restwell_migrate_wg_resources_seed_v41', 81 );
	add_action( 'init', 'restwell_migrate_home_pricing_chrome_seed_v42', 91 );
	add_action( 'after_switch_theme', 'restwell_migrate_home_pricing_chrome_seed_v42', 82 );
	add_action( 'init', 'restwell_migrate_acc_fit_stats_seed_v43', 92 );
	add_action( 'after_switch_theme', 'restwell_migrate_acc_fit_stats_seed_v43', 83 );
	add_action( 'init', 'restwell_migrate_resources_html_plain_v44', 93 );
	add_action( 'after_switch_theme', 'restwell_migrate_resources_html_plain_v44', 84 );
	add_action( 'init', 'restwell_migrate_acc_room_register_v45', 94 );
	add_action( 'after_switch_theme', 'restwell_migrate_acc_room_register_v45', 85 );
	add_action( 'init', 'restwell_migrate_acc_room_trim_v46', 95 );
	add_action( 'after_switch_theme', 'restwell_migrate_acc_room_trim_v46', 86 );
	add_action( 'init', 'restwell_migrate_design_audit_cta_usp_v47', 96 );
	add_action( 'after_switch_theme', 'restwell_migrate_design_audit_cta_usp_v47', 87 );
	add_action( 'init', 'restwell_migrate_home_hero_lede_v48', 97 );
	add_action( 'after_switch_theme', 'restwell_migrate_home_hero_lede_v48', 88 );
	add_action( 'init', 'restwell_migrate_home_hero_lede_no_emdash_v49', 98 );
	add_action( 'after_switch_theme', 'restwell_migrate_home_hero_lede_no_emdash_v49', 89 );
	add_action( 'init', 'restwell_migrate_care_not_free_copy_v50', 99 );
	add_action( 'after_switch_theme', 'restwell_migrate_care_not_free_copy_v50', 90 );
	add_action( 'init', 'restwell_migrate_hero_midcta_craft_v51', 99 );
	add_action( 'after_switch_theme', 'restwell_migrate_hero_midcta_craft_v51', 91 );
	add_action( 'init', 'restwell_migrate_hero_seo_h1_v52', 99 );
	add_action( 'after_switch_theme', 'restwell_migrate_hero_seo_h1_v52', 92 );
	add_action( 'init', 'restwell_migrate_continuity_wording_v53', 99 );
	add_action( 'after_switch_theme', 'restwell_migrate_continuity_wording_v53', 93 );
	add_action( 'init', 'restwell_migrate_acc_deduplicate_v54', 100 );
	add_action( 'after_switch_theme', 'restwell_migrate_acc_deduplicate_v54', 94 );
	add_action( 'init', 'restwell_migrate_privacy_gdpr_align_v55', 101 );
	add_action( 'after_switch_theme', 'restwell_migrate_privacy_gdpr_align_v55', 95 );
	add_action( 'init', 'restwell_migrate_our_story_copy_v56', 102 );
	add_action( 'after_switch_theme', 'restwell_migrate_our_story_copy_v56', 96 );
	add_action( 'init', 'restwell_migrate_privacy_gdpr_processors_v57', 103 );
	add_action( 'after_switch_theme', 'restwell_migrate_privacy_gdpr_processors_v57', 97 );
	add_action( 'init', 'restwell_migrate_our_story_ot_bed_v58', 104 );
	add_action( 'after_switch_theme', 'restwell_migrate_our_story_ot_bed_v58', 98 );
	add_action( 'init', 'restwell_migrate_our_story_cqc_note_v59', 105 );
	add_action( 'after_switch_theme', 'restwell_migrate_our_story_cqc_note_v59', 99 );
	add_action( 'init', 'restwell_migrate_our_story_cqc_note_v60', 90 );
	add_action( 'after_switch_theme', 'restwell_migrate_our_story_cqc_note_v60', 100 );
	add_action( 'init', 'restwell_migrate_acc_sling_faq_v61', 106 );
	add_action( 'after_switch_theme', 'restwell_migrate_acc_sling_faq_v61', 101 );

	add_action( 'init', 'restwell_maybe_mark_schema_current', 100 );
	add_action( 'admin_init', 'restwell_maybe_mark_schema_current', 100 );
	add_action( 'after_switch_theme', 'restwell_maybe_mark_schema_current', 100 );
}
restwell_register_content_migrations();
