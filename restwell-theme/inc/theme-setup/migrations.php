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
const RESTWELL_SCHEMA_VERSION = 102;


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
 * Give the funding/resources page the same SEO baseline as the other public
 * templates. Its legacy slug is funding-and-support, while the editor title
 * is intentionally “Resources”.
 */
function restwell_migrate_resources_seo_v63() {
	if ( get_option( 'restwell_resources_seo_v63', '' ) === '1' ) {
		return;
	}
	$page = get_page_by_path( 'funding-and-support', OBJECT, 'page' );
	if ( $page instanceof WP_Post ) {
		update_post_meta( $page->ID, 'meta_title', 'Funding an accessible holiday | Restwell Retreats' );
		update_post_meta( $page->ID, 'meta_description', 'How Restwell handles funding, invoices and care costs for an accessible holiday. Clear information before you commit to dates or a deposit.' );
		update_post_meta( $page->ID, 'focus_keyphrase', 'funding an accessible holiday' );
	}
	update_option( 'restwell_resources_seo_v63', '1', false );
}

/**
 * Refresh stored privacy HTML so the TikTok Pixel page-view wording is used.
 */
function restwell_migrate_privacy_tiktok_pixel_v64() {
	if ( get_option( 'restwell_privacy_tiktok_pixel_v64', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'privacy-policy', OBJECT, 'page' );
	if ( $page instanceof WP_Post ) {
		$html = (string) get_post_meta( $page->ID, 'legal_body_html', true );
		if ( '' !== trim( $html )
			&& false !== strpos( $html, 'Google Analytics 4' )
			&& false === strpos( $html, 'TikTok Pixel records that a page' ) ) {
			delete_post_meta( $page->ID, 'legal_body_html' );
		}
	}

	$terms = get_page_by_path( 'terms-and-conditions', OBJECT, 'page' );
	if ( $terms instanceof WP_Post ) {
		$terms_html = (string) get_post_meta( $terms->ID, 'legal_body_html', true );
		if ( '' !== trim( $terms_html )
			&& false !== strpos( $terms_html, 'Optional analytics cookies stay off' )
			&& false === strpos( $terms_html, 'advertising measurement cookies' ) ) {
			delete_post_meta( $terms->ID, 'legal_body_html' );
		}
	}

	update_option( 'restwell_privacy_tiktok_pixel_v64', '1', false );
}

/**
 * Refresh stored privacy HTML so TikTok SubmitForm wording is used.
 */
function restwell_migrate_privacy_tiktok_submitform_v65() {
	if ( get_option( 'restwell_privacy_tiktok_submitform_v65', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'privacy-policy', OBJECT, 'page' );
	if ( $page instanceof WP_Post ) {
		$html = (string) get_post_meta( $page->ID, 'legal_body_html', true );
		if ( '' !== trim( $html )
			&& false !== strpos( $html, 'Google Analytics 4' )
			&& false === strpos( $html, 'enquiry was sent' ) ) {
			delete_post_meta( $page->ID, 'legal_body_html' );
		}
	}

	update_option( 'restwell_privacy_tiktok_submitform_v65', '1', false );
}

/**
 * Trash empty duplicate Theme Setup pages left by the old init race
 * (a second /accessibility/, terms-and-conditions-2). Only a page that shares
 * the template, carries the same slug or a "-N" suffix of it, has no body
 * content, and is not the page get_page_by_path() resolves is trashed, so
 * nothing with real content is touched. Trash, not delete: it can be restored.
 */
function restwell_migrate_dedupe_theme_pages_v66() {
	if ( get_option( 'restwell_dedupe_theme_pages_v66', '' ) === '1' ) {
		return;
	}
	if ( ! function_exists( 'restwell_get_theme_setup_pages' ) || ! function_exists( 'restwell_get_theme_setup_page_templates' ) ) {
		return;
	}
	$templates = restwell_get_theme_setup_page_templates();
	$protected = array_map(
		'intval',
		array( get_option( 'page_on_front' ), get_option( 'page_for_posts' ), get_option( 'wp_page_for_privacy_policy' ) )
	);
	foreach ( restwell_get_theme_setup_pages() as $title => $slug ) {
		if ( empty( $templates[ $title ] ) ) {
			continue;
		}
		$keep = get_page_by_path( $slug, OBJECT, 'page' );
		if ( ! $keep instanceof WP_Post ) {
			continue;
		}
		$dupes = get_posts(
			array(
				'post_type'        => 'page',
				'post_status'      => 'publish',
				'posts_per_page'   => 20,
				'post__not_in'     => array( (int) $keep->ID ),
				'meta_key'         => '_wp_page_template', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				'meta_value'       => $templates[ $title ], // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
				'suppress_filters' => true,
			)
		);
		foreach ( $dupes as $dupe ) {
			if ( in_array( (int) $dupe->ID, $protected, true )
				|| '' !== trim( (string) $dupe->post_content )
				|| ! preg_match( '/^' . preg_quote( $slug, '/' ) . '(-\d+)?$/', (string) $dupe->post_name ) ) {
				continue;
			}
			wp_trash_post( (int) $dupe->ID );
		}
	}
	update_option( 'restwell_dedupe_theme_pages_v66', '1', false );
}

/**
 * Replace stored page descriptions longer than 160 characters with the
 * shortened copy-overwrites text, so the head tag is never trimmed mid-sentence
 * (audit I10). Shorter stored values are left alone.
 */
function restwell_migrate_meta_description_length_v67() {
	if ( get_option( 'restwell_meta_description_length_v67', '' ) === '1' ) {
		return;
	}
	if ( function_exists( 'restwell_copy_overwrite_slug_map' ) && function_exists( 'restwell_parse_copy_overwrite_file' ) ) {
		$dir = get_template_directory() . '/copy-overwrites';
		foreach ( restwell_copy_overwrite_slug_map() as $stem => $slug ) {
			$page = get_page_by_path( $slug, OBJECT, 'page' );
			if ( ! $page instanceof WP_Post ) {
				continue;
			}
			$stored = (string) get_post_meta( $page->ID, 'meta_description', true );
			$parsed = restwell_parse_copy_overwrite_file( $dir . '/' . $stem . '.md' );
			$fresh  = $parsed['meta_description'];
			if ( '' !== $fresh && mb_strlen( $fresh, 'UTF-8' ) <= 160 && mb_strlen( $stored, 'UTF-8' ) > 160 ) {
				update_post_meta( $page->ID, 'meta_description', $fresh );
			}
		}
	}
	update_option( 'restwell_meta_description_length_v67', '1', false );
}

/**
 * Stored legal HTML: drop the street address from the Terms (audit I02) and
 * replace generated "Last updated: <Month Year>" stamps with the fixed dates
 * (audit I40). Edits in place, so any other wording an editor changed survives.
 */
function restwell_migrate_legal_address_dates_v68() {
	if ( get_option( 'restwell_legal_address_dates_v68', '' ) === '1' ) {
		return;
	}
	$targets = array(
		'terms-and-conditions' => function_exists( 'restwell_terms_updated_label' ) ? restwell_terms_updated_label() : '17 September 2026',
		'accessibility-policy' => function_exists( 'restwell_accessibility_statement_updated_label' ) ? restwell_accessibility_statement_updated_label() : '17 September 2026',
	);
	foreach ( $targets as $slug => $date ) {
		$page = get_page_by_path( $slug, OBJECT, 'page' );
		if ( ! $page instanceof WP_Post ) {
			continue;
		}
		$html = (string) get_post_meta( $page->ID, 'legal_body_html', true );
		if ( '' === trim( $html ) ) {
			continue;
		}
		$new = preg_replace(
			'/the adapted self-catering bungalow at [^,<]*Russell Drive, Whitstable, Kent,?\s*(?:CT5\s*2RQ\s*)?with ([^.<]+)\./',
			'the adapted self-catering bungalow in Whitstable, Kent, with $1. We send the full address with your booking confirmation.',
			$html
		);
		$new = preg_replace( '/Last updated: (?:January|February|March|April|May|June|July|August|September|October|November|December) \d{4}\./', 'Last updated: ' . $date . '.', (string) $new );
		if ( $new !== $html ) {
			update_post_meta( $page->ID, 'legal_body_html', $new );
		}
	}
	update_option( 'restwell_legal_address_dates_v68', '1', false );
}

/**
 * House-style punctuation (decided 1 Oct 2026, audit I38): sentence dashes in
 * Restwell copy become colons, commas or full stops; wording otherwise
 * unchanged. Source files carry the same pairs; this updates stored copies.
 *
 * @return array<string, string>
 */
function restwell_house_style_dash_pairs(): array {
	return array(
		'you rent as a holiday — the whole house is yours' => 'you rent as a holiday: the whole house is yours',
		'published on the Accessibility page — including the ones that aren’t flattering' => 'published on the Accessibility page, including the ones that aren’t flattering',
		'published the details — including the ones that aren’t flattering' => 'published the details, including the ones that aren’t flattering',
		'for your party alone — not a care home.' => 'for your party alone, not a care home.',
		'Bring the sling the person already uses — both hoists take' => 'Bring the sling the person already uses. Both hoists take',
		'needs no turning circle — unlike a mobile hoist' => 'needs no turning circle, unlike a mobile hoist',
		'Amico GoLift 400 — ceiling track hoist' => 'Amico GoLift 400: ceiling track hoist',
		'or Roma Medical MATT 1 — both pressure-relieving' => 'or Roma Medical MATT 1, both pressure-relieving',
		'Joerns Oxford Midi 180 — mobile hoist' => 'Joerns Oxford Midi 180: mobile hoist',
		'AAL RS4 — transfer and standing aid' => 'AAL RS4: transfer and standing aid',
		'in a handling plan — please check your care plan' => 'in a handling plan. Please check your care plan',
		'Drive DeVilbiss — shower stool' => 'Drive DeVilbiss: shower stool',
		'Geberit AquaClean Mera Care — wash-dry WC' => 'Geberit AquaClean Mera Care: wash-dry WC',
		'Ropox Swing — height-adjustable washbasin' => 'Ropox Swing: height-adjustable washbasin',
		'NEFF Slide & Hide — oven' => 'NEFF Slide & Hide: oven',
		'NEFF Slide & Hide — the door folds away' => 'NEFF Slide & Hide: the door folds away',
		'Gas, not induction — no electromagnetic field' => 'Gas, not induction: no electromagnetic field',
		'This register is the spec sheet — makes, models' => 'This register is the spec sheet: makes, models',
		'What is Restwell, exactly — bungalow, care home, or respite centre?' => 'What is Restwell, exactly: bungalow, care home, or respite centre?',
		'contact preferences, and — if you choose to tell us — how you heard about us' => 'contact preferences, and, if you choose to tell us, how you heard about us',
		'and kitchen access — plus what to verify' => 'and kitchen access, plus what to verify',
		'level promenade walks — without pretending' => 'level promenade walks, without pretending',
		'broker questions — practical guidance, not legal advice.' => 'broker questions. Practical guidance, not legal advice.',
		'mobility equipment - covering Whitstable' => 'mobility equipment, covering Whitstable',
		'not accommodation - but that distinction matters.' => 'not accommodation, but that distinction matters.',
		'What happened to Revitalise - and where to find accessible holidays now' => 'What happened to Revitalise, and where to find accessible holidays now',
		'before booking - from door widths' => 'before booking, from door widths',
		'on a short break - PA hours, transport, accommodation - and' => 'on a short break (PA hours, transport, accommodation) and',
		'involves a slope - some sections' => 'involves a slope; some sections',
		'congested at weekends - weekday mornings' => 'congested at weekends; weekday mornings',
		'at lower tide - more navigable' => 'at lower tide, more navigable',
		'has a sandy beach - a significant practical advantage' => 'has a sandy beach, a significant practical advantage',
		'An access statement is available - worth requesting' => 'An access statement is available: worth requesting',
		'rather than shingle - a difference' => 'rather than shingle, a difference',
		'Bay Inspectors office - contact 07432' => 'Bay Inspectors office: contact 07432',
		'are less consistent - check specific sections' => 'are less consistent; check specific sections',
		'40 minutes by car - practical for day trips' => '40 minutes by car: practical for day trips',
		'width of the front door - the actual measurement' => 'width of the front door: the actual measurement',
		'in the main bedroom - ideally 1500mm' => 'in the main bedroom, ideally 1500mm',
		'in the shower - on both sides' => 'in the shower, on both sides',
		'the floor surface - wet room drainage' => 'the floor surface: wet room drainage',
		'bags cannot fix it — verify specs' => 'bags cannot fix it. Verify specs',
		'Rough guide only — verify event calendars yearly' => 'Rough guide only: verify event calendars yearly',
		'This is a real holiday - a comfortable' => 'This is a real holiday: a comfortable',
		'room for you to stay - tell us' => 'room for you to stay; tell us',
		'practical guide to the area - with accessibility' => 'practical guide to the area, with accessibility',
		'level walk with sea views - one of the more' => 'level walk with sea views, one of the more',
		'(about eight miles) - cathedral' => '(about eight miles): cathedral',
		'the wider Kent coast — written with wheelchair users' => 'the wider Kent coast, written with wheelchair users',
		'RAZ-AT — tilt-in-space shower commode chair' => 'RAZ-AT: tilt-in-space shower commode chair',
		'Mira Select Flex EV — shower valve' => 'Mira Select Flex EV: shower valve',
		'ramped access" - is the route completely level' => 'ramped access": is the route completely level',
		'</a> — door widths, hoist, wet room, and parking' => '</a>: door widths, hoist, wet room, and parking',
	);
}

/**
 * Apply restwell_house_style_dash_pairs() to stored page/post meta, post
 * titles, excerpts and content, and category descriptions. Exact phrases
 * only, and serialised meta is skipped so lengths never break.
 */
function restwell_migrate_house_style_dashes_v70() {
	if ( get_option( 'restwell_house_style_dashes_v70', '' ) === '1' ) {
		return;
	}
	global $wpdb;
	$pairs = restwell_house_style_dash_pairs();
	$from  = array_keys( $pairs );
	$to    = array_values( $pairs );

	// phpcs:disable WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
	$meta = $wpdb->get_results( "SELECT meta_id, post_id, meta_key, meta_value FROM {$wpdb->postmeta} WHERE meta_value LIKE '%—%' OR meta_value LIKE '% - %'" );
	foreach ( (array) $meta as $row ) {
		if ( is_serialized( $row->meta_value ) ) {
			continue;
		}
		$new = str_replace( $from, $to, (string) $row->meta_value );
		if ( $new !== $row->meta_value ) {
			update_metadata_by_mid( 'post', (int) $row->meta_id, $new );
		}
	}

	$posts = $wpdb->get_results( "SELECT ID, post_title, post_excerpt, post_content FROM {$wpdb->posts} WHERE post_type IN ('post','page') AND ( post_content LIKE '%—%' OR post_content LIKE '% - %' OR post_excerpt LIKE '%—%' OR post_excerpt LIKE '% - %' OR post_title LIKE '% - %' )" );
	// phpcs:enable
	foreach ( (array) $posts as $row ) {
		$update = array( 'ID' => (int) $row->ID );
		foreach ( array( 'post_title', 'post_excerpt', 'post_content' ) as $field ) {
			$new = str_replace( $from, $to, (string) $row->$field );
			if ( $new !== $row->$field ) {
				$update[ $field ] = $new;
			}
		}
		if ( count( $update ) > 1 ) {
			wp_update_post( wp_slash( $update ) );
		}
	}

	$terms = get_terms(
		array(
			'taxonomy'   => 'category',
			'hide_empty' => false,
		)
	);
	foreach ( is_wp_error( $terms ) ? array() : $terms as $term ) {
		$new = str_replace( $from, $to, (string) $term->description );
		if ( $new !== $term->description ) {
			wp_update_term( $term->term_id, 'category', array( 'description' => $new ) );
		}
	}
	update_option( 'restwell_house_style_dashes_v70', '1', false );
}

/**
 * Human post title tags (drafted 2 Oct 2026 for approval, audit I18; record in
 * copy-overwrites/post-titles.md). Replaces a stored meta_title only while it
 * still holds the old keyword string, with or without a brand suffix.
 */
function restwell_migrate_post_title_tags_v71() {
	if ( get_option( 'restwell_post_title_tags_v71', '' ) === '1' ) {
		return;
	}
	$titles = array(
		'accessible-beaches-coastal-walks-kent' => array( 'Accessible Beaches Kent | Coast Walks', 'Accessible beaches and coastal walks in Kent' ),
		'direct-payment-holiday-accommodation' => array( 'Direct Payment for Holiday | Funding', 'Using direct payments for a holiday: what they cover' ),
		'revitalise-alternatives-accessible-holidays' => array( 'Revitalise Centres Closed | What Next', 'What happened to Revitalise, and where to go now' ),
		'how-to-choose-accessible-self-catering-holiday' => array( 'Accessible Self-Catering Holiday Guide', 'How to choose an accessible self-catering holiday' ),
		'carers-respite-holiday-guide' => array( 'Carer Assessment & Respite Rights Guide', 'Carer’s assessments and your right to a respite break' ),
		'what-to-pack-accessible-self-catering-uk' => array( 'Accessible Holiday Packing List UK | Self-Catering', 'What to pack for an accessible self-catering break' ),
		'accessible-parking-whitstable-tankerton' => array( 'Accessible Parking Whitstable | Tankerton', 'Accessible parking in Whitstable and Tankerton' ),
		'chc-respite-holiday-accommodation-uk' => array( 'CHC Respite Holiday Accommodation UK', 'CHC funding and respite holiday accommodation' ),
		'hire-mobility-scooter-equipment-uk-holiday' => array( 'Hire Mobility Equipment UK Holiday | Self-Catering', 'Hiring mobility equipment for a UK holiday' ),
		'accessible-train-travel-whitstable-kent' => array( 'Accessible Train Travel Whitstable Kent', 'Accessible train travel to Whitstable and Kent' ),
		'travel-insurance-disability-uk-self-catering' => array( 'Travel Insurance Disability UK Self-Catering', 'Travel insurance for disabled travellers in the UK' ),
		'commissioner-checklist-accessible-respite-stay' => array( 'Commissioner Checklist Accessible Respite Stay', 'A commissioner’s checklist for an accessible respite stay' ),
		'personal-budget-short-break-care-act' => array( 'Personal Budget Short Break Care Act', 'Using a personal budget for a short break' ),
		'accessible-eating-out-whitstable-kent' => array( 'Accessible Eating Out Whitstable Kent', 'Accessible places to eat in Whitstable and Kent' ),
		'changing-places-toilets-kent-coast-days-out' => array( 'Changing Places Toilets Kent Coast | Days Out', 'Changing Places toilets for Kent coast days out' ),
		'quieter-times-whitstable-low-crowd-access' => array( 'Quieter Times Whitstable Visit | Low Crowd Access', 'When Whitstable is quieter: a guide to low-crowd days' ),
		'holiday-backup-plan-care-worker-change' => array( 'Holiday Backup Plan Care Worker Change', 'A holiday backup plan if your care worker changes' ),
		'how-to-read-holiday-cottage-access-statement' => array( 'How to Read Holiday Cottage Access Statement', 'How to read a holiday cottage access statement' ),
		'fatigue-friendly-whitstable-coastal-day' => array( 'Fatigue Friendly Whitstable Coastal Day', 'A fatigue-friendly day out on the Whitstable coast' ),
	);
	$norm = static function ( $t ) {
		$t = html_entity_decode( (string) $t, ENT_QUOTES, 'UTF-8' );
		$t = (string) preg_replace( '/\s*\|\s*Restwell( Retreats)?\s*$/i', '', $t );
		return strtolower( trim( $t, " \t|" ) );
	};
	foreach ( $titles as $slug => $pair ) {
		$post = get_page_by_path( $slug, OBJECT, 'post' );
		if ( ! $post instanceof WP_Post ) {
			continue;
		}
		$stored = (string) get_post_meta( $post->ID, 'meta_title', true );
		if ( '' === $stored || $norm( $stored ) === $norm( $pair[0] ) ) {
			update_post_meta( $post->ID, 'meta_title', $pair[1] );
		}
	}
	update_option( 'restwell_post_title_tags_v71', '1', false );
}

/**
 * Approved meta descriptions (owner sign-off 3 Oct 2026, audit I10). Swaps a
 * stored description only while it still holds the old seeded wording, so a
 * hand-edited value is left alone. Source: copy-overwrites/<page>.md.
 */
function restwell_migrate_approved_meta_descriptions_v72() {
	if ( get_option( 'restwell_approved_meta_descriptions_v72', '' ) === '1' ) {
		return;
	}
	$old_by_slug = array(
		'home' => array(
			'One private bungalow by the sea, with the wet room and ceiling hoist already fitted. The whole house is yours, and you can add home care if you’d like it.',
		),
	);
	if ( function_exists( 'restwell_copy_overwrite_slug_map' ) && function_exists( 'restwell_parse_copy_overwrite_file' ) ) {
		$dir = get_template_directory() . '/copy-overwrites';
		foreach ( restwell_copy_overwrite_slug_map() as $stem => $slug ) {
			if ( ! isset( $old_by_slug[ $stem ] ) ) {
				continue;
			}
			$page = get_page_by_path( $slug, OBJECT, 'page' );
			if ( 'home' === $stem && ! $page instanceof WP_Post ) {
				$front = (int) get_option( 'page_on_front', 0 );
				$page  = $front ? get_post( $front ) : null;
			}
			if ( ! $page instanceof WP_Post ) {
				continue;
			}
			$stored = (string) get_post_meta( $page->ID, 'meta_description', true );
			$parsed = restwell_parse_copy_overwrite_file( $dir . '/' . $stem . '.md' );
			$fresh  = (string) $parsed['meta_description'];
			if ( '' !== $fresh && in_array( $stored, $old_by_slug[ $stem ], true ) ) {
				update_post_meta( $page->ID, 'meta_description', $fresh );
			}
		}
	}
	update_option( 'restwell_approved_meta_descriptions_v72', '1', false );
}

/**
 * Post title tags approved 3 Oct 2026 (audit I18). The blog seeder wrote the
 * old keyword titles back after v71 had run, so run the v71 swap again now
 * that the seed carries the approved titles. Hand-edited tags are still kept.
 */
function restwell_migrate_post_title_tags_v73() {
	if ( get_option( 'restwell_post_title_tags_v73', '' ) === '1' ) {
		return;
	}
	delete_option( 'restwell_post_title_tags_v71' );
	restwell_migrate_post_title_tags_v71();
	update_option( 'restwell_post_title_tags_v73', '1', false );
}

/**
 * Our Story "Who does what" section: stop saying the same three things twice.
 * Invoicing, Victoria's role and the CQC link were each repeated across the
 * lede, the points and the note. Swaps a stored value only while it still holds
 * the old seeded wording, so a hand-edited value is left alone.
 */
function restwell_migrate_our_story_companies_dedupe_v74() {
	if ( get_option( 'restwell_our_story_companies_dedupe_v74', '' ) === '1' ) {
		return;
	}
	$page = get_page_by_path( 'our-story', OBJECT, 'page' );
	if ( ! ( $page instanceof WP_Post ) || ! function_exists( 'restwell_get_our_story_page_defaults' ) ) {
		return;
	}
	$defaults = restwell_get_our_story_page_defaults();
	$old      = array(
		'story_companies_label'  => 'Two companies',
		'story_companies_1_body' => 'A private adapted bungalow in Whitstable, not a care home or respite centre. Invoiced separately from any care you arrange.',
		'story_companies_2_body' => 'Optional home care during your stay, invoiced separately. Victoria is Continuity’s registered manager.',
		'story_companies_3_body' => 'You can discuss the bungalow and any care you may need through the same office and number.',
		'story_companies_note'   => 'Restwell is not a registered care provider. Continuity of Care Services is, and their CQC inspection report is linked below.',
	);
	foreach ( $old as $key => $old_value ) {
		$fresh = isset( $defaults[ $key ] ) && is_string( $defaults[ $key ] ) ? $defaults[ $key ] : '';
		if ( '' === $fresh || ! metadata_exists( 'post', (int) $page->ID, $key ) ) {
			continue;
		}
		if ( (string) get_post_meta( (int) $page->ID, $key, true ) === $old_value ) {
			update_post_meta( (int) $page->ID, $key, $fresh );
		}
	}
	update_option( 'restwell_our_story_companies_dedupe_v74', '1', false );
}

/**
 * Daylight heroes for Who It's For and How It Works (13 Oct 2026). The dusk
 * beach-hut slope and the patterned bedroom went near-black under the hero
 * scrim; the garden shots from the photoshoot read as the house in the sun.
 * Replaces a Featured image only while it is still the photo the theme seeded,
 * so a hero the owner picked by hand is left alone.
 */
function restwell_migrate_daylight_heroes_v75() {
	if ( get_option( 'restwell_daylight_heroes_v75', '' ) === '1' ) {
		return;
	}
	// Wait for the photo (23 Oct 2026): in a two-zip deploy the theme can go
	// live minutes before its images, and a swap skipped then never retries.
	if ( function_exists( 'restwell_theme_image_abs_path' ) && ( '' === restwell_theme_image_abs_path( 'bungalow/GRDEN-3-LS.jpg' ) || '' === restwell_theme_image_abs_path( 'bungalow/GRDEN-4-LS.jpg' ) ) ) {
		return;
	}
	// Mark first: a sideload timeout still leaves the theme-file fallback working.
	update_option( 'restwell_daylight_heroes_v75', '1', false );
	if ( ! function_exists( 'restwell_sideload_stock_image' ) || ! function_exists( 'restwell_page_id_for_stock_slug' ) ) {
		return;
	}
	$swaps = array(
		'who-its-for'  => array( 'stock/restwell-whitstable-beach-huts-sunset-slope.jpg', 'bungalow/GRDEN-3-LS.jpg' ),
		'how-it-works' => array( 'bungalow/BD1-2-LS.jpg', 'bungalow/GRDEN-4-LS.jpg' ),
	);
	foreach ( $swaps as $slug => $paths ) {
		$page_id = restwell_page_id_for_stock_slug( $slug );
		if ( $page_id < 1 ) {
			continue;
		}
		$thumb = (int) get_post_thumbnail_id( $page_id );
		if ( $thumb > 0 && ! restwell_page_featured_matches_stock_rel( $page_id, $paths[0] ) ) {
			continue;
		}
		$att_id = restwell_sideload_stock_image( $paths[1] );
		if ( $att_id < 1 ) {
			continue;
		}
		set_post_thumbnail( $page_id, $att_id );
		if ( function_exists( 'restwell_sync_page_hero_image_trio' ) ) {
			restwell_sync_page_hero_image_trio( $page_id );
		}
	}
}

/**
 * Care copy corrected by the owner (13 Oct 2026): Continuity quote the care, and
 * the site must not claim care is invoiced, quoted or arranged "separately", or
 * describe split invoices. Swaps those exact sentences inside any stored page
 * field, so the rest of a hand-edited value is kept.
 */
function restwell_migrate_care_quote_wording_v76() {
	if ( get_option( 'restwell_care_quote_wording_v76', '' ) === '1' ) {
		return;
	}
	$pairs = array(
		'Home care from Continuity, quoted separately.' => 'Optional home care from Continuity, who quote for it.',
		'Home care from Continuity can be added on the same enquiry, quoted separately from the bungalow.' => 'Home care from Continuity can be added on the same enquiry, and they’ll quote for it.',
		'Home care from Continuity can go on the same enquiry, quoted separately.' => 'Home care from Continuity can go on the same enquiry, and they’ll quote for it.',
		'Home care from Continuity can be added on the same enquiry, quoted separately.' => 'Home care from Continuity can be added on the same enquiry, and they’ll quote for it.',
		'Continuity home care can be added on the same enquiry, quoted separately.' => 'Continuity home care can be added on the same enquiry, and they’ll quote for it.',
		'Care is quoted separately from the bungalow.' => 'Continuity quote for the care once you’ve talked through what you need.',
		', and is arranged separately if you want it.' => ', if you want it.',
		'Optional home care from Continuity of Care Services, our sister company, arranged separately from the bungalow.' => 'Optional home care from Continuity of Care Services, our sister company.',
		'They invoice separately, and that is deliberate: funders usually treat accommodation and care as two different budgets, so keeping them apart makes your paperwork simpler, not harder.' => 'They quote for it once you’ve talked through what you need.',
		'The bungalow rent is rarely part of that, which is why we keep it on a separate invoice.' => 'The bungalow rent is rarely part of that.',
		' If it only covers part, we can split the invoices.' => '',
		'Tell us the dates, the funding route, and who should receive which invoice.' => 'Tell us the dates and who’s funding the stay.',
		'Invoices set up for the house, and for Continuity if you want care' => 'A care quote from Continuity, if you want care',
		' We’ll send the access statement; you agree who receives which invoice.' => ' We’ll send the access statement.',
		'Care is optional and arranged separately from your stay. Tell us what you need when you enquire and we will put together a clear quote.' => 'Care is optional. Tell us what you need when you enquire and Continuity will put together a clear quote.',
		'our sister company, invoice that separately.' => 'our sister company, will quote for it.',
		'Home care from Continuity of Care Services, if you’d like it, is invoiced separately by them.' => 'Home care from Continuity of Care Services, if you’d like it, is quoted by them.',
		' Home care from Continuity of Care Services is invoiced separately by them.' => ' Home care from Continuity of Care Services is quoted by them.',
		'Restwell is the accommodation; Continuity provide and invoice the care.' => 'Restwell is the accommodation; Continuity provide the care.',
		'Continuity invoice their care separately from the bungalow, so the house rate stays the house rate whatever you decide.' => 'Continuity quote for care themselves, and the house rate stays the house rate whatever you decide.',
		'Restwell invoices the accommodation; Continuity of Care Services invoice any care separately and hold the CQC registration.' => 'Restwell provides the accommodation; Continuity of Care Services provide any care and hold the CQC registration.',
		'Continuity is a separate company that invoices the care and holds the CQC rating;' => 'Continuity quote for the care and hold the CQC rating;',
		'If you’d like professional care while you’re here, that comes separately from our sister company.' => 'If you’d like professional care while you’re here, that comes from our sister company, Continuity.',
		'Split invoices, if a grant only covers part' => '',
		// Guests gave input; they did not design it.
		'Shaped by guests'                            => 'Shaped with guests',
	);
	$pages = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'any',
			'posts_per_page' => -1,
			'fields'         => 'ids',
		)
	);
	foreach ( $pages as $page_id ) {
		foreach ( (array) get_post_meta( (int) $page_id ) as $key => $values ) {
			if ( '' === $key || '_' === $key[0] || ! isset( $values[0] ) || ! is_string( $values[0] ) || is_serialized( $values[0] ) ) {
				continue;
			}
			$fresh = strtr( $values[0], $pairs );
			if ( $fresh !== $values[0] ) {
				update_post_meta( (int) $page_id, $key, $fresh );
			}
		}
	}
	update_option( 'restwell_care_quote_wording_v76', '1', false );
}

/**
 * The NEFF oven door slides in under the oven; it doesn't fold (owner, 13 Oct
 * 2026). "Tucks away" says so without repeating "Slide & Hide".
 */
function restwell_migrate_oven_door_wording_v77() {
	if ( get_option( 'restwell_oven_door_wording_v77', '' ) === '1' ) {
		return;
	}
	$pairs = array(
		'with a door that folds away underneath' => 'with a door that tucks away underneath',
		'the door folds away underneath'         => 'the door tucks away underneath',
	);
	$pages = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'any',
			'posts_per_page' => -1,
			'fields'         => 'ids',
		)
	);
	foreach ( $pages as $page_id ) {
		foreach ( (array) get_post_meta( (int) $page_id ) as $key => $values ) {
			if ( '' === $key || '_' === $key[0] || ! isset( $values[0] ) || ! is_string( $values[0] ) || is_serialized( $values[0] ) ) {
				continue;
			}
			$fresh = strtr( $values[0], $pairs );
			if ( $fresh !== $values[0] ) {
				update_post_meta( (int) $page_id, $key, $fresh );
			}
		}
	}
	update_option( 'restwell_oven_door_wording_v77', '1', false );
}

/**
 * Optional care rewritten in the Welcome Guide voice (14 Oct 2026, owner: "the
 * copywriting could undergo desperate improvement"), its hero moved from the
 * living room to the accessible bedroom, and lines that implied care is free
 * ("the bungalow costs the same either way") removed site-wide. Each field is replaced only while
 * it still holds the theme's previous default, so hand-edited copy is kept;
 * the Featured image only while it is still the photo the theme seeded.
 */
function restwell_migrate_care_copy_v78() {
	if ( get_option( 'restwell_care_copy_v78', '' ) === '1' ) {
		return;
	}
	// Wait for the photo (23 Oct 2026): in a two-zip deploy the theme can go
	// live minutes before its images, and a swap skipped then never retries.
	if ( function_exists( 'restwell_theme_image_abs_path' ) && ( '' === restwell_theme_image_abs_path( 'bungalow/BD2-2-LS.jpg' ) ) ) {
		return;
	}
	update_option( 'restwell_care_copy_v78', '1', false );
	if ( ! function_exists( 'restwell_page_id_for_stock_slug' ) ) {
		return;
	}
	$page_id = restwell_page_id_for_stock_slug( 'optional-care' );
	if ( $page_id < 1 ) {
		return;
	}
	$fields = array(
		'care_intro' => array(
			'Optional home care from Continuity of Care Services, our CQC-rated sister company, arranged on the same enquiry.',
			'Our sister company, Continuity of Care Services, can come into the bungalow while you stay. Ask on the same enquiry as the house.',
		),
		'care_sister_heading' => array(
			'One conversation if you need both the bungalow and care',
			'We’re the house. Continuity are the care.',
		),
		'care_sister_lede' => array(
			'Victoria Walker owns Restwell and is Continuity’s CQC registered manager. That’s why one call can cover the house and the care, without a handover to somebody else.',
			'You don’t have to use them. Plenty of guests bring their own carer or PA, or manage the way they do at home. But if someone coming in would turn a hard week into a good one, that’s what Continuity are here for.',
		),
		'care_sister_note' => array(
			'We add nothing until you agree the support package.',
			'Nothing is added to your stay until you’ve agreed it.',
		),
		'care_support_heading' => array(
			'What support looks like',
			'You choose how much, and it isn’t a package',
		),
		'care_support_1_body' => array(
			'Support with washing, dressing and daily routines on your schedule.',
			'Help getting up, washed and dressed, at the times you keep at home.',
		),
		'care_support_2_title' => array(
			'Visiting care',
			'A few hours off',
		),
		'care_support_2_body' => array(
			'Short daytime visits, or support for a promenade or town trip.',
			'Time here and there, so whoever normally does the caring can walk down to Tankerton and look at the water without watching the clock.',
		),
		'care_support_3_title' => array(
			'Overnight cover',
			'Overnight',
		),
		'care_support_3_body' => array(
			'Sleep-in or waking night support when daytime visits are not enough.',
			'A sleep-in or a waking night, when daytime visits aren’t enough.',
		),
		'care_support_4_title' => array(
			'Mobility and hoisting',
			'Hoisting and transfers',
		),
		'care_support_4_body' => array(
			'Transfers with trained carers, using the ceiling track and wet-room kit already in the house.',
			'The hoist is over the bed and the chair is in the wet room, so Continuity aren’t improvising around a standard holiday let.',
		),
		'care_own_1_title' => array(
			'No extra fee',
			'Use of the kit',
		),
		'care_own_1_body' => array(
			'Bring your own carer or PA at no extra charge; the bungalow rate is the same either way.',
			'The ceiling hoist, profiling beds and shower chair are here for your carer to use as well.',
		),
		'care_own_2_title' => array(
			'Separate sleeping space',
			'A room of their own',
		),
		'care_own_2_body' => array(
			'The second double bedroom, or the conservatory’s double sofa bed, keeps your carer’s sleeping space away from yours.',
			'Your carer can have the second double bedroom, or the double sofa bed in the conservatory. We can think it through with you if that’s easier.',
		),
		'care_own_3_body' => array(
			'The driveway holds two cars, so a carer’s vehicle can park alongside yours.',
			'The driveway holds two cars, so a carer’s car can park alongside yours.',
		),
		'care_how_heading' => array(
			'How care is arranged',
			'Sooner if you ask sooner, and we won’t pretend otherwise',
		),
		'care_how_lede' => array(
			'This is the care conversation specifically; see How It Works for the full booking journey from enquiry to arrival.',
			'We don’t publish a lead time, because we’d only be making it up: it depends on what you need and who’s working that week. What we will do is give you a straight answer quickly.',
		),
		'care_how_step1_title' => array(
			'Enquire as usual',
			'Mention it when you enquire',
		),
		'care_how_step1_body' => array(
			'Share dates, access needs, and any support you think would help. Call 01622 809881 or use the enquire form. No separate care booking maze.',
			'Say what you’re thinking when you first write or ring 01622 809881, even if your dates are vague. There’s no separate form for care.',
		),
		'care_how_step2_title' => array(
			'Agree tasks and hours',
			'Talk it through with Continuity',
		),
		'care_how_step2_body' => array(
			'If care is needed, Continuity confirms what is possible and what it costs. Many packages settle on the first call; a short follow-up covers overnight or complex rotas.',
			'They’ll ask about hours and tasks and tell you plainly what’s possible. Many people settle it on the first call; overnight or complex rotas can take a short follow-up.',
		),
		'care_how_step3_title' => array(
			'Guide rates, then your figure',
			'They quote, you decide',
		),
		'care_how_step3_body' => array(
			'Guide rates live on Pricing & dates. Continuity quotes your care cost once hours and tasks are agreed.',
			'Continuity quote your care once hours and tasks are agreed. Their guide rates are on Pricing & dates.',
		),
		'care_pro_lede' => array(
			'Restwell and Continuity can support a funded short break with care alongside it: here’s what each side provides. See Who It’s For for guest, carer and professional-referrer suitability at a glance.',
			'What each of us can give you when you’re planning a funded break with care. Who It’s For has suitability at a glance.',
		),
		'care_pro_1_body' => array(
			'Published door widths, hoist and wet-room specs; we’ll measure unpublished clearances on request.',
			'Door widths, hoist and wet-room specs are published, and we’ll measure anything that isn’t.',
		),
		'care_pro_2_title' => array(
			'Care documentation',
			'The care plan and cost',
		),
		'care_pro_2_body' => array(
			'Continuity confirms the care plan and cost once hours and tasks are agreed: the detail a funding panel needs to approve a break.',
			'Continuity confirm the care plan and the cost once hours and tasks are agreed.',
		),
		'care_pro_3_body' => array(
			'Care Act short breaks, direct payments, personal health budgets or NHS CHC: the bungalow rate is the same whoever we invoice.',
			'Care Act short breaks, direct payments, personal health budgets or NHS CHC.',
		),
		'care_pro_4_body' => array(
			'Restwell and Continuity share 01622 809881, so access needs and a care conversation can happen in one call.',
			'Restwell and Continuity share 01622 809881, so access and care can be one call.',
		),
		'care_faq_intro' => array(
			'Whether care is required, who Continuity is, and where guide rates live.',
			'The questions people ask most before they mention care.',
		),
		'care_cta_heading' => array(
			'Ask about care with your enquiry',
			'Tell us what you need, and we’ll work it out with you',
		),
		'care_cta_body' => array(
			'Share your dates and what support would help.',
			'Ring 01622 809881 or send a note. There’s no such thing as a silly question.',
		),
	);
	foreach ( $fields as $key => $pair ) {
		if ( metadata_exists( 'post', $page_id, $key ) && get_post_meta( $page_id, $key, true ) === $pair[0] ) {
			update_post_meta( $page_id, $key, $pair[1] );
		}
	}
	// Care is never implied free (owner, 14 Oct 2026): price-sameness lines
	// beside care or carers come out of any stored page field.
	$sentences = array(
		'How you manage your care is entirely up to you. The bungalow rate stays exactly the same whichever you choose:' => 'How you manage your care is entirely up to you:',
		'How you manage care is up to you, and the bungalow rate stays the same whichever you choose:' => 'How you manage care is up to you:',
		'Of course, and the price doesn’t change. A support worker' => 'Of course. A support worker',
		'Bringing your own carer or PA? Lovely. The rate doesn’t change and there’s nothing extra to arrange.' => 'Bringing your own carer or PA? Lovely. Just tell us who’s coming.',
		'They’re very welcome, and the bungalow rate doesn’t change.' => 'They’re very welcome.',
	);
	$pages     = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'any',
			'posts_per_page' => -1,
			'fields'         => 'ids',
		)
	);
	foreach ( $pages as $any_page_id ) {
		foreach ( (array) get_post_meta( (int) $any_page_id ) as $key => $values ) {
			if ( '' === $key || '_' === $key[0] || ! isset( $values[0] ) || ! is_string( $values[0] ) || is_serialized( $values[0] ) ) {
				continue;
			}
			$fresh = strtr( $values[0], $sentences );
			if ( $fresh !== $values[0] ) {
				update_post_meta( (int) $any_page_id, $key, $fresh );
			}
		}
	}
	if ( ! function_exists( 'restwell_sideload_stock_image' ) || ! function_exists( 'restwell_page_featured_matches_stock_rel' ) ) {
		return;
	}
	$thumb = (int) get_post_thumbnail_id( $page_id );
	if ( $thumb > 0 && ! restwell_page_featured_matches_stock_rel( $page_id, 'bungalow/LR-1-LS.jpg' ) ) {
		return;
	}
	$att_id = restwell_sideload_stock_image( 'bungalow/BD2-2-LS.jpg' );
	if ( $att_id > 0 ) {
		set_post_thumbnail( $page_id, $att_id );
		if ( function_exists( 'restwell_sync_page_hero_image_trio' ) ) {
			restwell_sync_page_hero_image_trio( $page_id );
		}
	}
}

/**
 * Optional care rebuilt from the site's own sections (14 Oct 2026): the fields
 * the page keeps take their new copy, each only while it still holds the
 * previous default (the v78 copy, or the original heading), so hand-edited
 * copy is kept. New fields read their theme defaults.
 */
function restwell_migrate_care_copy_v79() {
	if ( get_option( 'restwell_care_copy_v79', '' ) === '1' ) {
		return;
	}
	update_option( 'restwell_care_copy_v79', '1', false );
	if ( ! function_exists( 'restwell_page_id_for_stock_slug' ) ) {
		return;
	}
	$page_id = restwell_page_id_for_stock_slug( 'optional-care' );
	if ( $page_id < 1 ) {
		return;
	}
	$fields = array(
		'care_heading' => array(
			'Care during your stay, arranged in the same conversation',
			'Care that comes to your holiday',
		),
		'care_intro' => array(
			'Our sister company, Continuity of Care Services, can come into the bungalow while you stay. Ask on the same enquiry as the house.',
			'Our sister company, Continuity of Care Services, can come into the bungalow while you’re here. As much or as little as you’d like, and only if you ask.',
		),
		'care_own_lede' => array(
			'You’re very welcome to. Just tell us who’s coming.',
			'Plenty of guests do. They can have the second double bedroom or the sofa bed in the conservatory, use the hoist and shower chair, and park on the drive.',
		),
		'care_how_heading' => array(
			'Sooner if you ask sooner, and we won’t pretend otherwise',
			'Asking for care',
		),
		'care_how_step1_body' => array(
			'Say what you’re thinking when you first write or ring 01622 809881, even if your dates are vague. There’s no separate form for care.',
			'Even if your dates are vague.',
		),
		'care_how_step2_title' => array(
			'Talk it through with Continuity',
			'Talk it through',
		),
		'care_how_step2_body' => array(
			'They’ll ask about hours and tasks and tell you plainly what’s possible. Many people settle it on the first call; overnight or complex rotas can take a short follow-up.',
			'Continuity ask about hours and tasks.',
		),
		'care_how_step3_body' => array(
			'Continuity quote your care once hours and tasks are agreed. Their guide rates are on Pricing & dates.',
			'Nothing is booked until you say yes.',
		),
		'care_pro_lede' => array(
			'What each of us can give you when you’re planning a funded break with care. Who It’s For has suitability at a glance.',
			'Door widths and kit are published, and Continuity confirm the care plan and cost once hours and tasks are agreed.',
		),
	);
	foreach ( $fields as $key => $pair ) {
		if ( metadata_exists( 'post', $page_id, $key ) && get_post_meta( $page_id, $key, true ) === $pair[0] ) {
			update_post_meta( $page_id, $key, $pair[1] );
		}
	}
}

/**
 * Replace stored page copy that still equals an old seed.
 *
 * Both sides are compared on normalised line endings (wp-admin saves textarea
 * paragraphs with \r\n), and a value Victoria or Ellie has edited is left alone.
 *
 * @param array<string, array<string, array{0: string, 1: string}>> $pages Page slug => meta key => [ old, new ].
 */
function restwell_replace_stale_page_copy( array $pages ): void {
	if ( ! function_exists( 'restwell_page_id_for_stock_slug' ) ) {
		return;
	}
	foreach ( $pages as $slug => $fields ) {
		$page_id = restwell_page_id_for_stock_slug( $slug );
		if ( $page_id < 1 ) {
			continue;
		}
		foreach ( $fields as $key => $pair ) {
			if ( ! metadata_exists( 'post', $page_id, $key ) ) {
				continue;
			}
			$stored = trim( str_replace( array( "\r\n", "\r" ), "\n", (string) get_post_meta( $page_id, $key, true ) ) );
			if ( $stored === trim( $pair[0] ) ) {
				update_post_meta( $page_id, $key, $pair[1] );
			}
		}
	}
}

/**
 * 15 Oct 2026 copy pass: shorter wording where a page was saying too much
 * (the door checker's lede, the property's bedroom paragraphs). A stored value
 * is replaced only while it still equals the old seed, so a line Victoria or
 * Ellie has edited in wp-admin is left alone.
 */
function restwell_migrate_page_copy_v80() {
	if ( get_option( 'restwell_page_copy_v80', '' ) === '1' ) {
		return;
	}
	update_option( 'restwell_page_copy_v80', '1', false );
	if ( ! function_exists( 'restwell_page_id_for_stock_slug' ) ) {
		return;
	}
	$pages = array(
		'the-property' => array(
			'prop_bedrooms_section_body' => array(
				"The accessible bedroom has a ceiling-track hoist that reaches the whole room and can have one or two adjustable profiling beds, depending on what your group needs. There’s a second double bedroom next door, and the conservatory has a double sofa bed for extra guests. We also have a mobile hoist and a standing aid (an AAL RS4, rated to 185kg).\n\nThe bungalow can sleep up to five people using the accessible bedroom, the second double, and the conservatory sofa bed. Hoists, profiling beds, and wet-room equipment are all included in the price, unless you need something very specific that we don’t have. When you get in touch, we’ll ask about your group and accessibility needs so we can set up the room for you, with one or two profiling beds as needed. For example, a guest once asked us to match her mum’s bedroom layout from home, and we were happy to help.",
				"The accessible bedroom has a ceiling-track hoist that reaches the whole room, with one or two profiling beds set up around what you tell us when you book.\n\nA second double is next door and the conservatory has a double sofa bed, so up to five can stay. Hoists, a standing aid and profiling beds are included in the price.",
			),
			'prop_wetroom_body' => array(
				"The step-free wet room includes a roll-in shower, grab rails, shower and commode chairs, a tilt-in-space chair, a height-adjustable 180° spin wash basin, and a Geberit AquaClean wash-dry WC.\n\nThe wet room is arranged to make washing, using the toilet, and transfers easier while you’re here.\n\nAll the equipment mentioned is already installed in the bungalow, so you don’t need to hire or set up anything before you arrive.",
				"The step-free wet room includes a roll-in shower, grab rails, shower and commode chairs, a tilt-in-space chair, a height-adjustable 180° spin wash basin, and a Geberit AquaClean wash-dry WC.\n\nAll the equipment mentioned is already installed in the bungalow, so you don’t need to hire or set up anything before you arrive.",
			),
			'prop_kitchen_body' => array(
				"The kitchen features a lowered wheel-under counter, a slide-under oven, microwave, fridge, dishwasher, and all the plates, cutlery, utensils, and cooking basics you’ll need.\n\nIt’s set up for easy breakfasts, family meals, and relaxed evenings at home.\n\nThe hob is gas, not induction, which might be useful to know for your cooking plans.",
				"The kitchen features a lowered wheel-under counter, a slide-under oven, microwave, fridge, dishwasher, and all the plates, cutlery, utensils, and cooking basics you’ll need.\n\nThe hob is gas, not induction, which might be useful to know for your cooking plans.",
			),
		),
		'who-its-for' => array(
			'wif_ot_detail_bullets' => array(
				"Doorway widths, turning circles, hoist specs, and wet room measurements on request.\nTransfer clearances and equipment positioning confirmed if not already published.\nReferral conversations welcomed before any booking commitment.",
				"Doorway widths, turning circles, hoist specs, and wet room measurements on request.\nIf a transfer clearance or equipment position isn’t published, we’ll confirm it.\nYou’re welcome to talk to us about a referral before you commit to a booking.",
			),
			'wif_commissioners_detail_bullets' => array(
				"Short breaks at a private adapted setting can form part of a care and support plan under the Care Act 2014.\nDocumentation provided: property spec, access measurements, and CQC-registered care provider confirmation.\nDirect payments, personal health budgets, and CHC pathways all supported.",
				"Short breaks at a private adapted setting can form part of a care and support plan under the Care Act 2014.\nWe can send the property spec, the access measurements, and confirmation that the care provider is CQC registered.\nDirect payments, personal health budgets, and CHC pathways all supported.",
			),
			'wif_fund_phb_bullets' => array(
				"Available for people with continuing healthcare needs, subject to eligibility assessment.\nYour ICB or NHS continuing healthcare team manages the application.\nA private adapted setting can be written into a care and support plan where clinically appropriate.",
				"Available if you have continuing healthcare needs and are assessed as eligible.\nYour ICB or NHS continuing healthcare team manages the application.\nA private adapted house can be written into a care and support plan where it’s clinically appropriate.",
			),
			'wif_fund_private_bullets' => array(
				"The same clear accessibility information and direct answers as for funded guests.\nDocumentation for insurers or employers if you need it.\nNo pressure: we tell you plainly whether the property is a good fit.",
				"You get the same clear access information and straight answers as funded guests.\nPaperwork for insurers or employers, if you need it.\nNo pressure: we tell you plainly whether the property is a good fit.",
			),
		),
		'accessibility' => array(
			'acc_faq_2_a' => array(
				'It is fixed to the ceiling and moves a person in a sling along a rail, so it takes no floor space and needs no turning circle, unlike a mobile hoist, which has to be wheeled into position. Ours runs over the bed in the main bedroom. Full coverage, capacity and attachment details are in the equipment register above.',
				'It is fixed to the ceiling and moves a person in a sling along a rail. It takes no floor space and needs no turning circle, unlike a mobile hoist, which has to be wheeled into position. Ours runs over the bed in the main bedroom. Full coverage, capacity and attachment details are in the equipment register above.',
			),
			'acc_fit_intro' => array(
				'Enter the overall width of the chair you travel with (widest point, including hand rims). We’ll show the clearance at each doorway so you can judge the numbers before you enquire.',
				'Type in your chair’s width and see the clearance at each doorway before you enquire.',
			),
		),
	);
	restwell_replace_stale_page_copy( $pages );
}

/**
 * 15 Oct 2026, readability pass two (Flesch 70 across the pages): long
 * sentences split and long words swapped on the homepage, property and Our
 * Story. Same rule as v80: only a value that still equals the old seed.
 */
function restwell_migrate_page_copy_v81() {
	if ( get_option( 'restwell_page_copy_v81', '' ) === '1' ) {
		return;
	}
	update_option( 'restwell_page_copy_v81', '1', false );
	$pages = array(
		'home' => array(
			'property_body' => array(
				'It sits on a quiet residential street in Whitstable, about ten minutes from the seafront. The driveway is private and level, takes two cars including an adapted vehicle, and the front door is straight ahead of you when you park. We’ll send you the address and directions once your stay is confirmed.',
				'It sits on a quiet residential street in Whitstable, about ten minutes from the seafront. The driveway is private and level. It takes two cars, including an adapted vehicle, and the front door is straight ahead when you park. We’ll send the address and directions once your stay is confirmed.',
			),
			'home_care_item2_body' => array(
				'If you\'d like professional home care, our sister company Continuity of Care Services can come to you. They\'re rated Good by the CQC, and because we share an office and phone number, one conversation covers everything.',
				'If you\'d like professional home care, our sister company Continuity of Care Services can come to you. They\'re rated Good by the CQC. We share an office and phone number, so one conversation covers everything.',
			),
		),
		'the-property' => array(
			'prop_wetroom_body' => array(
				"The step-free wet room includes a roll-in shower, grab rails, shower and commode chairs, a tilt-in-space chair, a height-adjustable 180° spin wash basin, and a Geberit AquaClean wash-dry WC.\n\nAll the equipment mentioned is already installed in the bungalow, so you don’t need to hire or set up anything before you arrive.",
				"The step-free wet room includes a roll-in shower, grab rails, shower and commode chairs, a tilt-in-space chair, a height-adjustable 180° spin wash basin, and a Geberit AquaClean wash-dry WC.\n\nAll of this is already installed, so there’s nothing to hire or set up before you arrive.",
			),
			'prop_living_body' => array(
				"After time by the sea, the living room gives everyone space to settle in.\n\nYou’ll find a rise-and-recline armchair, a sofa with pull-out footrests, and a TV with Netflix. The open-plan layout makes it easy for wheelchair users, families, and carers to move around comfortably.\n\nThere’s enough seating for everyone, and we keep the space between the sofa and armchair clear so wheelchairs can turn easily.",
				"After time by the sea, the living room gives everyone space to settle in.\n\nThere’s a rise-and-recline armchair, a sofa with pull-out footrests and a TV with Netflix. The open-plan layout leaves plenty of room for wheelchair users, families and carers to move around.\n\nThere’s seating for everyone. We keep the space between the sofa and armchair clear, so wheelchairs can turn.",
			),
			'prop_conservatory_body' => array(
				"The conservatory is a bright space where you can eat, read, or enjoy the garden view.\n\nIt has a fold-out dining table, a double sofa bed, level access to the patio, and laundry cupboards with a washing machine and tumble dryer.",
				"The conservatory is a bright space where you can eat, read, or enjoy the garden view.\n\nThere’s a fold-out dining table, a double sofa bed and level access to the patio. The laundry cupboards hold a washing machine and a tumble dryer.",
			),
			'prop_garden_body' => array(
				"French doors open onto a level patio with a non-slip ramp at the threshold.\n\nThe garden is fully enclosed and dog-friendly, with outdoor seating, a BBQ, and fairy lights. You can eat outside or let your dog out safely. Please let us know ahead of time so we can do a quick risk assessment.\n\nAt the front, there’s a resin-bound, level-access driveway with space for two cars. It’s been tested with two wheelchair-accessible vehicles. Portable ramps are kept in the outdoor box by the front door, ready for you to use around the property or take with you during your stay.",
				"French doors open onto a level patio with a non-slip ramp at the threshold.\n\nThe garden is fully enclosed and dog-friendly, with outdoor seating, a BBQ, and fairy lights. You can eat outside or let your dog out safely. Please let us know ahead of time so we can do a quick risk assessment.\n\nAt the front there’s a level, resin-bound driveway with space for two cars. We’ve tested it with two wheelchair-accessible vehicles. Portable ramps are kept in the outdoor box by the front door, to use around the property or take with you.",
			),
			'prop_cta_body' => array(
				'Tell us your preferred dates, group size, and any access or equipment needs. We’ll reply with availability, measurements, equipment details, and your next steps.',
				'Tell us your dates, your group size and any access or equipment needs. We’ll reply with availability, measurements and your next steps.',
			),
		),
		'funding-and-support' => array(
			'res_complaints_body' => array(
				'You can ask for a review. For a local authority decision, that’s your council first (Kent County Council if they funded the assessment), then the Local Government Ombudsman. For NHS CHC, follow the ICB appeals process, then the Parliamentary and Health Service Ombudsman. Scope and Beacon can advise either way, and we’re happy to resend the paperwork.',
				'You can ask for a review. For a council decision, go to your council first (Kent County Council if they funded the assessment), then the Local Government Ombudsman. For NHS CHC, follow the ICB appeals process, then the Parliamentary and Health Service Ombudsman. Scope and Beacon can advise either way, and we’re happy to resend the paperwork.',
			),
		),
		'who-its-for' => array(
			'wif_family_body' => array(
				'Hoist and wet room already fitted; measurements published; a private home, not a hotel room.',
				'Hoist and wet room already fitted. Measurements published. A private home, not a hotel room.',
			),
			'wif_family_detail_bullets' => array(
				"Ceiling track hoist in the accessible bedroom, profiling bed, and wet room with roll-in shower.\nPublished access measurements before you commit.\nA private self-catering layout: your daily routines run on your schedule.",
				"Ceiling track hoist in the accessible bedroom, profiling bed, and wet room with roll-in shower.\nPublished access measurements before you commit.\nA private, self-catering house, so your routines run to your own schedule.",
			),
			'wif_carers_detail_bullets' => array(
				"Separate sleeping area for the support worker or carer.\nWet room designed for assisted personal care on the same level.\nYou have a legal right to a Carer's Assessment under the Care Act 2014.",
				"A separate place to sleep for the support worker or carer.\nWet room designed for assisted personal care on the same level.\nYou have a legal right to a Carer's Assessment under the Care Act 2014.",
			),
			'wif_ot_body' => array(
				'Published doorway widths, hoist and wet-room specs. Ask for unpublished clearances; we’ll measure.',
				'Door widths, hoist and wet-room specs are published. If you need one that isn’t, ask and we’ll measure it.',
			),
			'wif_ot_detail_bullets' => array(
				"Doorway widths, turning circles, hoist specs, and wet room measurements on request.\nIf a transfer clearance or equipment position isn’t published, we’ll confirm it.\nYou’re welcome to talk to us about a referral before you commit to a booking.",
				'You’re welcome to talk to us about a referral before you commit to a booking.',
			),
			'wif_commissioners_body' => array(
				'Care Act short breaks; documentation for direct payments, PHB or CHC. Same rates regardless of who we invoice.',
				'Care Act short breaks, with paperwork for direct payments, PHB or CHC. Same rates regardless of who we invoice.',
			),
			'wif_commissioners_detail_bullets' => array(
				"Short breaks at a private adapted setting can form part of a care and support plan under the Care Act 2014.\nWe can send the property spec, the access measurements, and confirmation that the care provider is CQC registered.\nDirect payments, personal health budgets, and CHC pathways all supported.",
				"Short breaks at a private adapted setting can form part of a care and support plan under the Care Act 2014.\nWe can send the property spec, the measurements and the care provider’s CQC registration.\nWe support direct payments, personal health budgets and CHC.",
			),
			'wif_fund_la_bullets' => array(
				"Begins with a Care and Support Assessment. Unpaid carers can request a Carer's Assessment too (Care Act 2014).\nDirect payments: you receive the funding and choose your provider.\nCapital limits in England (2026/27): above £23,250 you generally pay in full; below £14,250 is usually ignored. Councils can set their own limits for care at home, so check yours.",
				"It starts with a Care and Support Assessment. Unpaid carers can ask for a Carer's Assessment too (Care Act 2014).\nDirect payments: you receive the funding and choose your provider.\nCapital limits in England (2026/27): above £23,250 you generally pay in full; below £14,250 is usually ignored. Councils can set their own limits for care at home, so check yours.",
			),
			'wif_fund_phb_bullets' => array(
				"Available if you have continuing healthcare needs and are assessed as eligible.\nYour ICB or NHS continuing healthcare team manages the application.\nA private adapted house can be written into a care and support plan where it’s clinically appropriate.",
				"For people with continuing healthcare needs who are found eligible.\nYour ICB or NHS continuing healthcare team handles the application.\nA private adapted house can go into a care and support plan where it suits your clinical needs.",
			),
		),
		'whitstable-area-guide' => array(
			'wg_planning_before_bullets' => array(
				"Behind the sailing club at the foot of the slopes\nBy the Marine Parade cafe at the top\nUnder the promenade cafe near the castle\nChanging Places: Whitstable Harbour WC, Harbour Road\nJoJo’s Tankerton and Marine Hotel (venue accessible loos)",
				"Behind the sailing club at the foot of the slopes\nBy the Marine Parade cafe at the top\nUnder the promenade cafe near the castle\nChanging Places: Whitstable Harbour WC, Harbour Road\nJoJo’s Tankerton and the Marine Hotel, both with accessible loos",
			),
		),
		'our-story' => array(
			'story_origin_body' => array(
				'Somebody would travel for three hours, only to find a doorway they couldn’t get through. So we bought a bungalow in Whitstable that needed a lot of work, and we adapted it properly. Then we measured everything and published the details, including the ones that aren’t flattering. Guests can check the bungalow will work for them before they set off, and arrange optional care through the same office.',
				'Somebody would travel for three hours, only to find a doorway they couldn’t get through. So we bought a bungalow in Whitstable that needed a lot of work, and we adapted it properly. Then we measured everything and published the details, flattering or not. Guests can check the bungalow will work for them before they set off. They can arrange optional care through the same office.',
			),
			'story_month_2_body' => array(
				'The accessible bedroom and wet room were built by Care Spaces by Wealden Rehab and Thor Carpentry, with the occupational therapists’ advice. Family and friends filled the rest.',
				'The accessible bedroom and wet room were built by Care Spaces by Wealden Rehab and Thor Carpentry, with the occupational therapists’ advice. Family and friends did the rest.',
			),
			'story_companies_2_body' => array(
				'Optional home care during your stay, always from Continuity’s own team.',
				'Home care during your stay is optional, and always from Continuity’s own team.',
			),
			'story_specialists_lede' => array(
				'Every measurement is on the Accessibility page, including the ones that aren’t flattering. Compare the door widths, spaces, and equipment limits with your own chair, hoist, or other kit before you book. If you’re unsure whether something will work, please ask.',
				'Every measurement is on the Accessibility page, flattering or not. Compare the door widths, spaces and limits with your own chair or hoist before you book. If you’re unsure, please ask.',
			),
			'story_next_lede' => array(
				'Publish the numbers. Say what the house can’t do as clearly as what it can. Make it possible to arrange a week away, and the support to enjoy it, in a single conversation, without anyone having to explain their situation four times to four different people.',
				'Publish the numbers. Say what the house can’t do as clearly as what it can. Make it possible to arrange a week away, and the support to enjoy it, in one conversation. Nobody should have to explain their situation four times to four people.',
			),
		),
	);
	restwell_replace_stale_page_copy( $pages );
}

/**
 * 15 Oct 2026: Our Story opens on the finished bungalow, not the generic Kent
 * brick house it was seeded with.
 *
 * Only an untouched seed is replaced: the page's Featured image must still be
 * the sideloaded stock brick house (its _restwell_stock_source says so), and
 * the hero field must be empty or already equal to it. A photograph Victoria
 * or Ellie chose in wp-admin is left alone.
 */
function restwell_migrate_our_story_hero_v82() {
	if ( get_option( 'restwell_our_story_hero_v82', '' ) === '1' ) {
		return;
	}
	// Wait for the photo (23 Oct 2026): in a two-zip deploy the theme can go
	// live minutes before its images, and a swap skipped then never retries.
	if ( function_exists( 'restwell_theme_image_abs_path' ) && ( '' === restwell_theme_image_abs_path( 'bungalow/accessible-holiday-whitstable.png' ) ) ) {
		return;
	}
	update_option( 'restwell_our_story_hero_v82', '1', false );
	if ( ! function_exists( 'restwell_page_id_for_stock_slug' )
		|| ! function_exists( 'restwell_sideload_stock_image' )
		|| ! function_exists( 'restwell_sync_page_hero_image_trio' )
		|| ! function_exists( 'restwell_normalise_stock_rel' ) ) {
		return;
	}
	$page_id = restwell_page_id_for_stock_slug( 'our-story' );
	if ( $page_id < 1 ) {
		return;
	}
	$thumb = (int) get_post_thumbnail_id( $page_id );
	if ( $thumb < 1 ) {
		// No Featured image: the theme default (now the bungalow) already applies.
		return;
	}
	$source = restwell_normalise_stock_rel( (string) get_post_meta( $thumb, '_restwell_stock_source', true ) );
	if ( 'stock/restwell-kent-riverside-brick-house.jpg' !== $source ) {
		return;
	}
	$hero = absint( get_post_meta( $page_id, 'story_hero_image_id', true ) );
	if ( $hero > 0 && $hero !== $thumb ) {
		return;
	}
	$att_id = restwell_sideload_stock_image( 'bungalow/accessible-holiday-whitstable.png' );
	if ( $att_id < 1 ) {
		return;
	}
	set_post_thumbnail( $page_id, $att_id );
	restwell_sync_page_hero_image_trio( $page_id );
}

/**
 * 16 Oct 2026: trash empty duplicate Home and Blog pages.
 *
 * The first-request race that v66 cleaned up also made a second /home/ and a
 * /blog-2/, and v66 skips pages without a template, which is exactly these
 * two. They showed in the SEO admin bar as an identical H1, a near-duplicate
 * title and two orphans. The page set as the front page or the posts page is
 * always kept; another published page is trashed only if its slug is "home"
 * or "blog" (or that with a "-N" suffix), it has the same title, no body
 * content and no page template. Trash, not delete, so it can be restored.
 */
function restwell_migrate_dedupe_home_blog_v83() {
	if ( get_option( 'restwell_dedupe_home_blog_v83', '' ) === '1' ) {
		return;
	}
	update_option( 'restwell_dedupe_home_blog_v83', '1', false );
	$keep = array(
		'home' => (int) get_option( 'page_on_front', 0 ),
		'blog' => (int) get_option( 'page_for_posts', 0 ),
	);
	$protected = array_filter( array_merge( array_values( $keep ), array( (int) get_option( 'wp_page_for_privacy_policy', 0 ) ) ) );
	$trashed   = false;
	foreach ( $keep as $slug => $keep_id ) {
		$keeper = $keep_id > 0 ? get_post( $keep_id ) : null;
		if ( ! $keeper instanceof WP_Post ) {
			continue;
		}
		$candidates = get_posts(
			array(
				'post_type'        => 'page',
				'post_status'      => 'publish',
				'posts_per_page'   => 20,
				'post__not_in'     => $protected,
				'title'            => $keeper->post_title,
				'suppress_filters' => true,
			)
		);
		foreach ( $candidates as $dupe ) {
			$template = (string) get_post_meta( (int) $dupe->ID, '_wp_page_template', true );
			if ( ! preg_match( '/^' . preg_quote( $slug, '/' ) . '(-\d+)?$/', (string) $dupe->post_name )
				|| '' !== trim( (string) $dupe->post_content )
				|| ( '' !== $template && 'default' !== $template ) ) {
				continue;
			}
			wp_trash_post( (int) $dupe->ID );
			$trashed = true;
		}
	}
	if ( $trashed ) {
		delete_transient( 'restwell_keyword_cannibalisation_audit' );
		delete_transient( 'restwell_orphan_audit' );
	}
}

/**
 * 17 Oct 2026, copy brief batch 1 (Home, The Property, Accessibility), as
 * approved by Ellie: plainer headings that name what is in each room, flowing
 * sentences, the missing bedroom count on Home, the wet room photo described
 * correctly (no fold-down seat), the hoist's full-room coverage stated once and
 * consistently, the destination block's unverifiable claims softened, and the
 * three titles and meta descriptions. Same rule as v80 and v81: a stored value
 * is replaced only while it still equals the shipped seed.
 */
function restwell_migrate_batch1_copy_v84() {
	if ( get_option( 'restwell_batch1_copy_v84', '' ) === '1' ) {
		return;
	}
	update_option( 'restwell_batch1_copy_v84', '1', false );
	$pages = array(
		'home' => array(
			'hero_subheading' => array(
				'Private bungalow with a level wet room and ceiling track hoist. Optional home care from Continuity, who quote for it.',
				'A private, single-storey bungalow a short walk from the sea, with a level wet room and a ceiling track hoist already fitted. Home care from our sister company is there if you’d like it.',
			),
			'property_heading' => array(
				'One bungalow, and it’s all yours',
				'A private bungalow that sleeps five',
			),
			'property_body' => array(
				'It sits on a quiet residential street in Whitstable, about ten minutes from the seafront. The driveway is private and level. It takes two cars, including an adapted vehicle, and the front door is straight ahead when you park. We’ll send the address and directions once your stay is confirmed.',
				"It sits on a quiet residential street in Whitstable, about ten minutes from the seafront. The driveway is private and level. It takes two cars, including an adapted vehicle, and the front door is straight ahead when you park.\n\nInside there are two bedrooms and a double sofa bed in the conservatory, so up to five people can stay. You can book from a single night, and we’ll set the bedroom up around what you tell us before you arrive. We’ll send the address and directions once your stay is confirmed.",
			),
			'home_care_intro' => array(
				'How you manage your care is entirely up to you:',
				'How you handle care on holiday is up to you, and most guests do one of two things.',
			),
			'home_care_item1_body' => array(
				'Plenty of guests bring their own carer or manage just like they do at home.',
				'Plenty of guests bring their own carer or PA, or simply manage the way they do at home, and the second bedroom gives a carer somewhere proper to sleep.',
			),
			'home_care_item2_title' => array(
				'Use our care team',
				'Add care from Continuity',
			),
			'home_care_item2_body' => array(
				'If you\'d like professional home care, our sister company Continuity of Care Services can come to you. They\'re rated Good by the CQC. We share an office and phone number, so one conversation covers everything.',
				'Our sister company, Continuity of Care Services, can come into the bungalow while you’re here. They’re rated Good by the CQC, and because we share an office and a phone number, one call covers the house and the care.',
			),
			'cta_body' => array(
				'Tell us your dates and what you need from the house. We aim to reply within 48 hours, and there’s no deposit until you’ve decided it fits.',
				'Tell us your dates and what you need from the house, and we’ll aim to reply within 48 hours. There’s no deposit to pay until we’ve talked it through and you’re happy it fits.',
			),
			'meta_description' => array(
				'One private bungalow by the sea, with the wet room and ceiling hoist already fitted. The whole house is yours, and home care can be arranged if you’d like it.',
				'A private bungalow in Whitstable with a level wet room and ceiling hoist. It sleeps five, and you can add home care from our sister company if you’d like.',
			),
			'hero_cta_reassurance' => array(
				'We aim to reply within 48 hours, and there’s no deposit until you’ve decided the house fits.',
				'We aim to reply within 48 hours, and there’s no deposit to pay until we’ve talked it through and you’re sure the house fits.',
			),
			'home_faq_heading' => array(
				'The questions that stop an enquiry',
				'Common questions before booking',
			),
		),
		'the-property' => array(
			'prop_hero_heading' => array(
				'A proper look round the bungalow',
				'Inside the bungalow, room by room',
			),
			'prop_hero_subtitle' => array(
				'A room-by-room look round Restwell: a single-storey adapted bungalow in Whitstable that sleeps up to five.',
				'Here’s a walk round Restwell, room by room. It’s a single-storey adapted bungalow on a quiet street in Whitstable, with two bedrooms and space for up to five people.',
			),
			'prop_bedrooms_section_heading' => array(
				'The room with the hoist, and room for everyone else',
				'Two bedrooms and a sofa bed, for up to five',
			),
			'prop_bedrooms_section_body' => array(
				"The accessible bedroom has a ceiling-track hoist that reaches the whole room, with one or two profiling beds set up around what you tell us when you book.\n\nA second double is next door and the conservatory has a double sofa bed, so up to five can stay. Hoists, a standing aid and profiling beds are included in the price.",
				"The accessible bedroom has a ceiling track hoist that covers the whole room, and we set it up with one or two profiling beds, depending on what you tell us when you book. If you’d like the furniture moved to match the way things are at home, just say, and it’ll be ready when you arrive.\n\nThe second bedroom next door has a double bed, and the conservatory has a double sofa bed, so up to five people can stay. The hoists, the standing aid and the profiling beds are all included in the price.",
			),
			'prop_wetroom_heading' => array(
				'Roll-in shower and accessible washroom',
				'Level-access wet room',
			),
			'prop_wetroom_body' => array(
				"The step-free wet room includes a roll-in shower, grab rails, shower and commode chairs, a tilt-in-space chair, a height-adjustable 180° spin wash basin, and a Geberit AquaClean wash-dry WC.\n\nAll of this is already installed, so there’s nothing to hire or set up before you arrive.",
				"The wet room is step-free from the door to the shower. It has grab rails, a shower stool and a tilt-in-space shower chair, a basin that swings round and moves up and down to the height you need, and a wash-and-dry toilet.\n\nIt’s all fitted already, so there’s nothing to hire or set up before you arrive. If you’d like the makes, models and safe working loads, you’ll find them on the Accessibility page.",
			),
			'prop_living_heading' => array(
				'A comfortable place to come back to',
				'Open-plan living room',
			),
			'prop_living_body' => array(
				"After time by the sea, the living room gives everyone space to settle in.\n\nThere’s a rise-and-recline armchair, a sofa with pull-out footrests and a TV with Netflix. The open-plan layout leaves plenty of room for wheelchair users, families and carers to move around.\n\nThere’s seating for everyone. We keep the space between the sofa and armchair clear, so wheelchairs can turn.",
				"The living room is open-plan, with a rise-and-recline armchair, a sofa with pull-out footrests and a TV with Netflix. There’s room for wheelchairs, carers and family to get past each other.\n\nWe keep the floor between the sofa and the armchair clear so a wheelchair can turn. There’s free high-speed WiFi throughout, which matters more than people admit when someone needs to keep an eye on work or a hospital app.",
			),
			'prop_kitchen_heading' => array(
				'Wheel-under kitchen, ready for everyday meals',
				'Kitchen with a wheel-under worktop',
			),
			'prop_kitchen_body' => array(
				"The kitchen features a lowered wheel-under counter, a slide-under oven, microwave, fridge, dishwasher, and all the plates, cutlery, utensils, and cooking basics you’ll need.\n\nThe hob is gas, not induction, which might be useful to know for your cooking plans.",
				"The kitchen has a lowered worktop you can wheel under, an oven with a door that slides away underneath, a microwave, a fridge and a dishwasher. You’ll also find plates, pans, cutlery and the cooking basics.\n\nThe hob is gas rather than induction, which is worth knowing when you plan what to cook.",
			),
			'prop_conservatory_heading' => array(
				'Sunny dining space with level garden access',
				'Conservatory with level access to the patio',
			),
			'prop_conservatory_body' => array(
				"The conservatory is a bright space where you can eat, read, or enjoy the garden view.\n\nThere’s a fold-out dining table, a double sofa bed and level access to the patio. The laundry cupboards hold a washing machine and a tumble dryer.",
				"The conservatory has a fold-out table to eat at and a double sofa bed, and its doors open out level onto the patio.\n\nThe laundry cupboards are in here too, with a washing machine and a tumble dryer.",
			),
			'prop_garden_body' => array(
				"French doors open onto a level patio with a non-slip ramp at the threshold.\n\nThe garden is fully enclosed and dog-friendly, with outdoor seating, a BBQ, and fairy lights. You can eat outside or let your dog out safely. Please let us know ahead of time so we can do a quick risk assessment.\n\nAt the front there’s a level, resin-bound driveway with space for two cars. We’ve tested it with two wheelchair-accessible vehicles. Portable ramps are kept in the outdoor box by the front door, to use around the property or take with you.",
				"French doors open onto a level patio, with a non-slip ramp over the threshold. The garden is fully enclosed, with outdoor seating, a barbecue and fairy lights.\n\nDogs are welcome, and we just ask you to let us know before you arrive so we can do a quick risk assessment.\n\nAt the front there’s a level, resin-bound driveway with space for two cars, and we’ve tested it with two wheelchair-accessible vehicles. Portable ramps are kept in the outdoor box by the front door, for use around the house or on days out.",
			),
			'prop_care_body' => array(
				'Home care from Continuity can go on the same enquiry, and they’ll quote for it. Or bring your own team. There’s no pressure either way.',
				'If someone in your group needs help with personal care, our sister company, Continuity, can come into the bungalow, and they’ll quote once you’ve talked through what’s needed. Plenty of guests bring their own carer instead, and the second bedroom is there for them.',
			),
			'prop_location_heading' => array(
				'A quiet street in Whitstable, close to the coast path',
				'On a quiet street, ten minutes from the seafront',
			),
			'prop_location_body' => array(
				"The bungalow sits on a quiet residential street, a short walk from The Plough pub and about ten minutes on foot from the seafront.\n\nThe beach is shingle, but the wide, paved promenade offers a step-free route along the coast and forms part of the King Charles III England Coast Path.\n\nJoJo’s is about twenty minutes on foot: ten minutes down to the sea, then west along Tankerton promenade. The Marine Hotel sits on that same stretch. A short drive if you’d rather save your energy for lunch.",
				"The bungalow is on a quiet residential street, a short walk from The Plough pub and about ten minutes on foot from the seafront. Down there, the wide, paved promenade gives you a step-free route along the coast.\n\nThe beach is shingle, so the paved promenade is the step-free way along the seafront.",
			),
			'prop_gallery_heading' => array(
				'See more of the bungalow.',
				'More photos of the bungalow',
			),
			'prop_cta_body' => array(
				'Tell us your dates, your group size and any access or equipment needs. We’ll reply with availability, measurements and your next steps.',
				'Tell us your dates, who’s coming and any access or equipment needs, and we’ll come back with availability and an honest answer on whether the house will work for you.',
			),
			'meta_title' => array(
				'Look inside the accessible holiday bungalow',
				'Inside the accessible holiday bungalow in Whitstable',
			),
			'meta_description' => array(
				'A room-by-room look round the bungalow: two bedrooms, a level-access wet room, an open kitchen and French doors to the garden. Sleeps five, and it’s all yours.',
				'A room-by-room look round the bungalow: two bedrooms, a level-access wet room, a kitchen you can wheel under and a level garden. It sleeps up to five.',
			),
		),
		'accessibility' => array(
			'acc_intro' => array(
				'This is the access statement for Restwell, a single-storey adapted bungalow in Whitstable.',
				'This is the full access statement for Restwell, our single-storey adapted bungalow in Whitstable, so you can check it against your own needs before you book.',
			),
			'acc_fit_note' => array(
				'This is a guide only. Aim for at least 50mm of clearance where you can, and we’re happy to talk through your measurements before you book.',
				'This is a guide only. Aim for at least 50mm of clearance where you can, and we’re happy to talk your measurements through before you book.',
			),
			'acc_dest_heading' => array(
				'The destination, honestly.',
				'Getting around Whitstable',
			),
			'acc_dest_intro' => array(
				'Whitstable is a genuinely lovely town, but like most historic coastal places, it has its challenges. Here is the honest picture.',
				'Whitstable is an old seaside town, so some parts are easier to get around than others. Here’s what we’ve found.',
			),
			'acc_dest_good_body' => array(
				'The Tankerton promenade is a long, flat, surfaced path along the seafront, one of the most wheelchair-friendly coastal routes in Kent. Free parking at Marine Parade. Accessible toilets at the harbour end. The streets around the property are flat and paved with dropped kerbs.',
				'Tankerton promenade is a long, level, surfaced path along the seafront, and it’s the route most of our guests use. There’s free Blue Badge parking along Marine Parade. There are accessible toilets along the promenade, and a Changing Places toilet at the harbour. The streets around the bungalow are level and paved, with dropped kerbs.',
			),
			'acc_dest_challenge_body' => array(
				'Harbour Street and the old town have narrow pavements that get crowded at weekends and in summer. Some shops and cafes have stepped entrances with no ramp. The harbour itself has some uneven surfaces near the fish market. Weekday mornings are the easiest time to visit.',
				'Harbour Street and the old town have narrow pavements that get crowded at weekends and in summer. Some shops and cafes have a step at the door and no ramp. The ground around the harbour and the fish market can be uneven. Weekday mornings are the easiest time to visit.',
			),
			'acc_dest_reality_body' => array(
				'Whitstable is more accessible than most UK coastal towns. With a little planning and our local knowledge, we can point you to the best accessible routes, cafes, and experiences. We will share everything we know in your welcome pack.',
				'Our Whitstable guide lists the routes, cafes and accessible toilets we know work, and we send the same notes in your welcome pack.',
			),
			'acc_faq_intro' => array(
				'Questions about ceiling hoist safe working loads, profiling beds, and the details that make a place truly “wheelchair friendly.”',
				'The questions people ask most about the hoists, the beds and what wheelchair friendly should really mean.',
			),
			'acc_faq_1_a' => array(
				'No. Bring the sling the person already uses. Both hoists take loop-style slings on a two-point spreader bar. The note above the equipment register explains why we cannot supply one.',
				'No. Please bring the sling the person already uses. Both hoists take loop-style slings on a two-point spreader bar, and the note above the equipment register explains why we can’t supply one.',
			),
			'acc_faq_2_a' => array(
				'It is fixed to the ceiling and moves a person in a sling along a rail. It takes no floor space and needs no turning circle, unlike a mobile hoist, which has to be wheeled into position. Ours runs over the bed in the main bedroom. Full coverage, capacity and attachment details are in the equipment register above.',
				'It’s fixed to the ceiling and moves a person in a sling along a rail, so it takes up no floor space and needs no turning circle, unlike a mobile hoist, which has to be wheeled into place. Ours covers the whole of the accessible bedroom, and the details are in the equipment register above.',
			),
			'acc_faq_3_a' => array(
				'It helps with positioning, pressure care and safer transfers, and it sets a working height that protects the back of whoever is providing care. A fixed divan gives you none of that, and a mobile hoist often cannot get its legs underneath one. We have two profiling beds; the accessible bedroom takes one or two.',
				'It helps with positioning, pressure care and safer transfers, and it sets a working height that protects the back of whoever is giving care. A fixed divan gives you none of that, and a mobile hoist often can’t get its legs under one. We have two profiling beds, and the accessible bedroom takes one or both.',
			),
			'acc_faq_4_q' => array(
				'What should “wheelchair friendly” actually mean?',
				'What should wheelchair friendly actually mean?',
			),
			'acc_faq_4_a' => array(
				'It should mean published numbers you can check against your own chair and your own equipment: clear door openings, step-free routes, safe working loads, turning circles. If a listing says “wheelchair friendly” and will not give you a measurement when you ask, that tells you what you need to know. Everything we have is on this page.',
				'It should mean published numbers you can check against your own chair and your own kit, like clear door openings, step-free routes, safe working loads and turning circles. If a listing says wheelchair friendly but won’t give you a measurement when you ask, that tells you what you need to know. Everything we have is on this page.',
			),
			'acc_cta_body' => array(
				'If you have questions about door widths, hoist limits, wet-room equipment, or care, we will answer them clearly.',
				'If you’ve a question about door widths, hoist limits, the wet room or care, ask us and we’ll give you a clear answer.',
			),
			'meta_description' => array(
				'The access statement in full: a 965mm front door, 926mm inside, a ceiling hoist rated to 180kg, a height-adjustable basin and a tilt-in-space shower chair.',
				'The full access statement: a 965mm front door, 926mm internal doors, a ceiling hoist rated to 180kg, a level wet room and a tilt-in-space shower chair.',
			),
		),
	);
	restwell_replace_stale_page_copy( $pages );
}

/**
 * 19 Oct 2026, copy brief batch 2 (Pricing, How It Works, FAQ, Enquire), as
 * approved by Ellie: plain headings, one "We aim to reply within 48 hours"
 * promise, the one-night minimum stay on Pricing and the FAQ, the FAQ's first
 * answer no longer saying Restwell is "both" a bungalow and a respite centre,
 * the duplicate respite question swapped for the minimum stay, full-room hoist
 * coverage, care described as optional with a Continuity quote (never
 * "separately"), "Ask us about a stay" on Enquire, and the four titles and
 * meta descriptions. Same rule as v84: a stored value is replaced only while
 * it still equals the shipped seed.
 */
function restwell_migrate_batch2_copy_v85() {
	if ( get_option( 'restwell_batch2_copy_v85', '' ) === '1' ) {
		return;
	}
	update_option( 'restwell_batch2_copy_v85', '1', false );
	$pages = array(
		'pricing' => array(
			'pricing_intro' => array(
				'Weekly and nightly rates, the deposit, and what’s included, at the same price whoever pays.',
				'Here are the weekly and nightly rates, the nights that are free and how the deposit works. You can stay for one night or a whole week, and the access equipment is included.',
			),
			'pricing_rates_heading' => array(
				'Published bungalow rates',
				'Weekly and nightly rates',
			),
			'pricing_rates_intro' => array(
				'The bungalow sleeps five people. Prices vary for midweek (Monday to Thursday) and weekend (Friday to Sunday) nights. Care is optional and has a separate charge.',
				'You book the whole bungalow, which sleeps up to five. Weekend nights (Friday to Sunday) cost a little more than midweek nights (Monday to Thursday), and the minimum stay is one night. Care from Continuity is optional, and they’ll give you a quote for it.',
			),
			'pricing_payment_intro' => array(
				'You can pay by bank transfer or card. For information about invoicing different funders, see Funding & Support.',
				'You can pay by bank transfer or card. If a council, the NHS or a charity is paying, the price is the same, and Funding & Support explains how the invoice works.',
			),
			'pricing_care_rates_heading' => array(
				'Optional care while you stay',
				'Guide rates for optional care',
			),
			'pricing_care_rates_intro' => array(
				'Guide rates for care from Continuity depend on the hours and tasks you need. Continuity will give you a quote after you speak with them.',
				'If you’d like home care during your stay, these are Continuity’s guide rates. What you pay depends on the hours and tasks you need, and Continuity will give you a quote once you’ve talked it through with them.',
			),
			'pricing_cta_heading' => array(
				'Enquire about dates and care',
				'Ask about dates and care',
			),
			'pricing_cta_body' => array(
				'Let us know your arrival dates, access needs, and if you want support from Continuity. You do not need to pay a deposit until you decide.',
				'Tell us when you’d like to come, what you need from the house and whether you’d like care from Continuity. We aim to reply within 48 hours, and there’s no deposit to pay until you’re happy the house fits.',
			),
			'meta_title' => array(
				'Prices for the bungalow, and what’s included',
				'Accessible holiday prices for the Whitstable bungalow',
			),
			'meta_description' => array(
				'A week in the bungalow is £1,300 off-peak and £1,400 in peak season, with all the access equipment included. The rate is the same whoever pays the invoice.',
				'A week in the bungalow is £1,300 off-peak and £1,400 in peak season, and you can book a single night. The access equipment is included in the price.',
			),
		),
		'how-it-works' => array(
			'hiw_heading' => array(
				'The bookends of a holiday should be the easy bit',
				'How booking a stay works',
			),
			'hiw_intro' => array(
				'Booking Restwell is three steps: enquire, confirm with a deposit, and arrive from 3pm using a key safe.',
				'There’s no online checkout. You tell us your dates and what you need, we check the house will work for you, and only then do you pay a deposit.',
			),
			'hiw_steps_intro' => array(
				'Three steps from your first message to the front door. There is no online checkout, and you only pay a deposit after we’ve both agreed the bungalow fits.',
				'There are three steps between your first message and the front door, and you don’t pay anything until we’ve agreed the house fits.',
			),
			'hiw_step1_body' => array(
				'Send us your dates, who’s coming, and anything that would make the house work better for you. We aim to reply within 48 hours. Nothing to pay at this stage.',
				'Send us your dates, who’s coming and anything that would help the house work for you, like how you’d like the bedroom set up. We aim to reply within 48 hours, and there’s nothing to pay at this stage.',
			),
			'hiw_step2_body' => array(
				'We set the house up around what you’ve told us. A 50% deposit reserves the dates; the balance is due a week before you arrive. Care from Continuity stays in the same conversation.',
				'Once we’ve agreed the house fits, a 50% deposit holds your dates and the rest is due a week before you arrive. In the meantime, we set the furniture and equipment up around what you’ve told us.',
			),
			'hiw_step3_body' => array(
				'Check-in is from 3pm, through a key safe. We send the code and the address with your confirmation, never on the website.',
				'Check-in is from 3pm, and you let yourselves in with a key safe. We send the code and the address with your confirmation, and we never put them on the website.',
			),
			'hiw_arrival_heading' => array(
				'Key-safe from 3pm',
				'What happens on arrival day',
			),
			'hiw_arrival_lede' => array(
				'There is no reception desk. Park in the driveway, open the key safe, and settle into a house that is already set up for your group.',
				'There’s no reception desk to queue at. You park on the level driveway, open the key safe and let yourselves into a house that’s already set up for your group.',
			),
			'hiw_arrival_1_dd' => array(
				'From 3pm via the key-safe · departure by 11am',
				'From 3pm, using the key safe. Check-out is by 11am.',
			),
			'hiw_arrival_2_dd' => array(
				'Level driveway for two cars, including accessible vehicles',
				'A level driveway for two cars, including an adapted vehicle',
			),
			'hiw_arrival_3_dd' => array(
				'Step-free routes and kit set from your enquiry · guest notes after dates are confirmed',
				'Beds and equipment set up as we agreed, with a guest guide sent once your dates are confirmed',
			),
			'hiw_arrival_link2_label' => array(
				'Door widths and kit notes',
				'Door widths and the hoist',
			),
			'hiw_care_cta_heading' => array(
				'If you’d like care while you’re here',
				'Adding care to your stay',
			),
			'hiw_care_cta_body' => array(
				'Home care from Continuity can go on the same enquiry, and they’ll quote for it. Or bring your own team. There’s no pressure either way.',
				'If you’d like home care while you’re here, mention it in your first message. Continuity, our sister company, will talk it through with you and give you a quote. You’re just as welcome to bring your own carer or PA.',
			),
			'hiw_faq_heading' => array(
				'Before you enquire',
				'Questions about booking',
			),
			'hiw_faq_intro' => array(
				'We will explain when to pay the deposit, who we invoice, arrival details, and how optional care works with a self-catering stay.',
				'When the deposit is due, who we can invoice, and how care fits around a self-catering stay.',
			),
			'hiw_faq_1_a' => array(
				'Three steps: send us your dates and what you need, we confirm the bungalow and take a 50% deposit, then you arrive from 3pm using a key safe. Care can go on the same enquiry.',
				'Send us your dates and what you need, using the form, by email or on 01622 809881. Once we’ve checked the house fits, a 50% deposit holds your dates, and you arrive from 3pm on the day.',
			),
			'hiw_faq_2_a' => array(
				'Mention it when you first write, even if the dates are still vague. We don’t publish a lead time because it depends on what you need and who’s available that week. We’ll give you a real answer quickly.',
				'It’s best to mention it in your first message, even if your dates aren’t fixed yet. We don’t publish a lead time, because it depends on what you need and who’s free that week. We’ll give you a straight answer as soon as we can.',
			),
			'hiw_faq_3_a' => array(
				'We can invoice you, a council, the NHS or a grant body, at the same bungalow rate. Who we invoice doesn’t change the price. See Funding and support for the paperwork.',
				'You can pay by bank transfer or card, and we can also invoice a council, the NHS or a grant body directly. The deposit and balance are set out on <a href="/pricing/#payment">Prices and dates</a>, and <a href="/funding-and-support/">Funding and support</a> explains the paperwork.',
			),
			'hiw_faq_4_q' => array(
				'Can a local authority, case manager or NHS team book for me?',
				'Can a council, case manager or NHS team book for me?',
			),
			'hiw_faq_4_a' => array(
				'Yes. Funded bookings are welcome, and funders can confirm a booking with a purchase order on the same payment timeline as every guest.',
				'Yes, and funded bookings are very welcome. A funder can confirm the booking with a purchase order, and the deposit and balance follow the same timings as any other stay.',
			),
			'hiw_cta_heading' => array(
				'Send dates and access needs',
				'Tell us your dates',
			),
			'hiw_cta_body' => array(
				'We will reply with measurements, equipment notes, and your next steps.',
				'Let us know when you’d like to come and what you need from the house. We’ll reply with the measurements, equipment details and what happens next.',
			),
			'meta_title' => array(
				'Booking a stay, from first email to front door',
				'How to book a stay at Restwell, step by step',
			),
			'meta_description' => array(
				'Tell us your dates and who’s coming. We confirm the bungalow, you pay a deposit, and you arrive to a house set up for you. Care can go on the same note.',
				'From your first message to the front door: how we check the bungalow fits, when the deposit is due and what happens when you arrive on the day.',
			),
		),
		'faq' => array(
			'faq_intro' => array(
				'Short answers to what people ask before booking: what Restwell is, whether it fits, and what it costs.',
				'These are the things people ask us most before they book. Each answer is short and links to the page with more detail.',
			),
			'faq_cta_heading' => array(
				'Send dates and access needs',
				'Ask about your dates',
			),
			'faq_cta_body' => array(
				'We reply within 48 hours on most enquiries; phone 01622 809881 if you need to talk it through.',
				'Tell us when you’d like to come and what you need. We aim to reply within 48 hours, or you can call 01622 809881 if you’d rather talk it through.',
			),
			'faq_1_q' => array(
				'What is Restwell, exactly: bungalow, care home, or respite centre?',
				'Is Restwell a care home or a respite centre?',
			),
			'faq_1_a' => array(
				'Both, in the way that helps you plan: it’s a private adapted bungalow that you rent as a holiday, with no staff on site, and optional care from Continuity if you want it. It’s not a registered respite centre, though your funder may use the word respite on paperwork, and that’s fine.',
				'No. Restwell is a private bungalow that you rent as a holiday, so the house is yours and there are no staff on site. If you’d like home care while you’re here, our sister company, Continuity of Care Services, can provide it. Your funder may call the break respite on their paperwork, and that’s fine.',
			),
			'faq_2_q' => array(
				'Is it a respite centre?',
				'Can we book just one night?',
			),
			'faq_2_a' => array(
				'No, though your funder may well use the word respite, and that’s fine. It’s often how a break like this gets described on paperwork. It’s still a private house rather than a registered respite service.',
				'Yes. The minimum stay is one night, so you can book anything from a single night to a full week or more. The nightly and weekly rates are on <a href="/pricing/">Prices and dates</a>.',
			),
			'faq_2_cat' => array(
				'about',
				'booking',
			),
			'faq_3_q' => array(
				'What are the doorway widths, and will my wheelchair fit?',
				'What are the door widths, and will my wheelchair fit?',
			),
			'faq_3_a' => array(
				'The house is single-storey and step-free throughout. The front door has a 965mm clear opening, the internal doorways are 926mm, the wet room is level-access, and there’s a ceiling track hoist over the profiling bed. If you need a measurement we haven’t published, ask and we’ll go and take it. See the <a href="/accessibility/">access statement</a>.',
				'The bungalow is all on one level and step-free throughout. The front door has a 965mm clear opening and the doors inside are 926mm, so you can check those against your own chair. If you need a measurement we haven’t published, ask and we’ll go and measure it. Every figure is in the <a href="/accessibility/">access statement</a>.',
			),
			'faq_4_a' => array(
				'There’s a ceiling track hoist rated to 180kg, and an electric mobile hoist also rated to 180kg. Both are subject to a LOLER thorough examination every six months. Guests bring their own slings, because a sling needs to fit the person.',
				'Yes. There’s a ceiling track hoist that covers the whole of the main bedroom, and a mobile hoist you can use in any room. Both have a safe working load of 180kg and are examined under LOLER every six months. Please bring your own slings, because a sling needs to fit the person using it.',
			),
			'faq_5_a' => array(
				'Yes. We arrange the accessible bedroom around each guest: one profiling bed if that’s what you need, two if it isn’t. Tell us when you book so it’s set up before you arrive.',
				'Yes. We have two profiling beds, and we set the accessible bedroom up with one or both, depending on who needs them. Tell us when you book and it’ll be ready when you arrive.',
			),
			'faq_6_a' => array(
				'Five. There are two bedrooms and a double sofa bed in the conservatory. Five is what our safety checks are based on, so we do have to hold to it.',
				'Up to five. There are two bedrooms and a double sofa bed in the conservatory. Our safety checks are based on five people, so we can’t go above that.',
			),
			'faq_7_a' => array(
				'Yes. Continuity of Care Services, our sister company, can come into the bungalow, anything from a morning visit to nurse-led support. Continuity quote for the care once you’ve talked through what you need. Mention it on the same enquiry as the house and we’ll work it out together. See <a href="/optional-care/">Optional care</a>.',
				'Yes. Continuity of Care Services, our sister company, can come into the bungalow during your stay, from a morning visit to nurse-led support. Mention it on the same enquiry as the house, and Continuity will give you a quote once you’ve talked through what you need. There’s more on the <a href="/optional-care/">Optional care</a> page.',
			),
			'faq_8_q' => array(
				'How far ahead do we need to arrange the care?',
				'How far ahead do we need to arrange care?',
			),
			'faq_8_a' => array(
				'The sooner you ask, the more likely we can say yes. We don’t publish a lead time because it honestly depends on what you need and who’s available that week, and we’d rather give you a real answer quickly than a number we’ve invented.',
				'The sooner you ask, the more likely it is that we can say yes. We don’t publish a lead time, because it depends on what you need and who’s free that week. We’d rather give you a real answer quickly than a number we’ve made up.',
			),
			'faq_9_a' => array(
				'Of course. A support worker can use the second bedroom, or we can think through the sleeping arrangements with you.',
				'Of course. Plenty of guests bring their own carer or PA, and the second bedroom gives them somewhere proper to sleep. If you’d like to talk through who sleeps where, we’re happy to help.',
			),
			'faq_10_a' => array(
				'About ten minutes on foot from the driveway. Places along Tankerton promenade take longer, because you walk down to the sea first and then head west along the prom. JoJo’s is roughly twenty minutes all in. See the <a href="/whitstable-area-guide/">Whitstable guide</a>.',
				'It’s about ten minutes on foot from the driveway to the seafront. Places along Tankerton promenade take a bit longer, because you head down to the sea first and then west along the prom. JoJo’s is about twenty minutes in all. The <a href="/whitstable-area-guide/">Whitstable guide</a> has the step-free routes.',
			),
			'faq_11_a' => array(
				'A week is £1,300 off-peak and £1,400 in peak season, with all the access equipment, linen, towels and parking included. A 50% deposit reserves your dates and the balance follows a week before arrival. See <a href="/pricing/">Pricing & dates</a>.',
				'A week is £1,300 off-peak and £1,400 in peak season, and the access equipment, linen, towels and parking are all included. A 50% deposit holds your dates and the rest is due a week before you arrive. Every rate is on <a href="/pricing/">Prices and dates</a>.',
			),
			'faq_12_a' => array(
				'We can invoice you, a local authority, the NHS or a grant body, and the rate is identical either way. What we can’t do is promise your package will cover a holiday. That decision sits with your social worker or case manager. See <a href="/funding-and-support/">Funding and support</a>.',
				'We can invoice you, a local authority, the NHS or a grant body. What we can’t do is promise that your care package will cover a holiday, because that decision sits with your social worker or case manager. <a href="/funding-and-support/">Funding and support</a> explains how it usually works.',
			),
			'faq_13_a' => array(
				'Some guests do, for the accommodation or for a PA’s time. The rules vary by area, so start with your own care team. See <a href="/direct-payment-holiday-accommodation/">direct payments</a>.',
				'Some guests do, either for the stay or for a PA’s time. The rules vary from area to area, so it’s best to start with your own care team. Our <a href="/direct-payment-holiday-accommodation/">guide to direct payments</a> explains more.',
			),
			'faq_14_a' => array(
				'Yes, with a bit of notice so we can run a quick risk assessment. Assistance dogs are welcome on the same terms.',
				'Yes, with a little notice so we can do a quick risk assessment first. Assistance dogs are welcome on the same terms.',
			),
			'faq_15_a' => array(
				'From 3pm, through a key safe, with the code sent to you beforehand. Check-out is by 11am, and if you need longer for personal care or transport, tell us a few days ahead and we’ll do our best. See <a href="/how-it-works/">How it works</a>.',
				'Check-in is from 3pm, using a key safe, and we send you the code beforehand. Check-out is by 11am. If you need longer for personal care or transport, let us know a few days ahead and we’ll do our best. <a href="/how-it-works/">How it works</a> covers arrival day in full.',
			),
			'meta_title' => array(
				'The questions guests ask us before booking',
				'Restwell FAQ: the questions guests ask before booking',
			),
			'meta_description' => array(
				'Straight answers about the house, the access equipment, optional home care, deposits and who we can invoice. Then a link to the page that covers it properly.',
				'Straight answers to what people ask before booking, from door widths and hoists to home care, prices and who can pay, each linked to the page with more.',
			),
		),
		'enquire' => array(
			'enq_heading' => array(
				'Get in touch whenever you’re ready',
				'Ask us about a stay',
			),
			'enq_intro' => array(
				'Send your dates and what you need, and we’ll reply within 48 hours. There’s no deposit until you’ve decided it fits.',
				'Tell us your dates and what you need from the house, and ask about care on the same form if you’d like it. We aim to reply within 48 hours, and there’s no deposit to pay until we’ve talked it through and you’re sure it fits.',
			),
			'enq_success_body' => array(
				'We’ve emailed you an acknowledgement. Next: a team member reviews your details and replies, usually within 48 hours. Call 01622 809881 if you’d rather talk it through.',
				'Thank you, we’ve got your enquiry. We’ve emailed you to confirm, and one of us will read your details and aim to reply within 48 hours. If you’d rather talk it through, call 01622 809881.',
			),
			'enq_success_urgent_body' => array(
				'We’ve flagged this for a priority callback and aim to contact you sooner than our usual 48-hour window. If you need to speak now, call 01622 809881.',
				'We’ve marked this as urgent and will try to call you back sooner than our usual 48 hours. If you need to speak to someone now, call 01622 809881.',
			),
			'meta_title' => array(
				'Ask us anything about a stay at Restwell',
				'Contact Restwell about a stay in Whitstable',
			),
			'meta_description' => array(
				'Call, email or fill in the form. Tell us your dates and what you need from the house, with any care questions on the same note. Nothing to pay until it fits.',
				'Call 01622 809881, email or use the form to ask about dates, access or care. We aim to reply within 48 hours, and there’s no deposit until it fits.',
			),
		),
	);
	restwell_replace_stale_page_copy( $pages );
}

/**
 * 19 Oct 2026, blog index readability, as approved by Ellie: each post summary
 * rewritten as one plain sentence or two (the index read at Flesch 52), a
 * shorter blog intro and meta description, and the FAQ's direct payments
 * answer corrected to match the funding guidance (they usually pay for care,
 * and whether they cover the stay is up to the council). Each value is
 * replaced only while it still equals the shipped seed, so wp-admin edits stay.
 */
function restwell_migrate_blog_summaries_v86() {
	if ( get_option( 'restwell_blog_summaries_v86', '' ) === '1' ) {
		return;
	}
	update_option( 'restwell_blog_summaries_v86', '1', false );

	$normalise = static function ( $text ) {
		return trim( str_replace( array( "\r\n", "\r" ), "\n", (string) $text ) );
	};

	$excerpts = array(
		'fatigue-friendly-whitstable-coastal-day' => array(
			'Plan a manageable outing with places to pause, a route that suits you, and an easy way back.',
			'How to plan a day by the sea with places to rest, a route that suits you and an easy way home.',
		),
		'how-to-read-holiday-cottage-access-statement' => array(
			'Measurements that matter, hoist proof, and the red-flag phrases that should stop you booking.',
			'The sizes to check, the hoist details to ask for, and the words in a listing that should make you think twice.',
		),
		'holiday-backup-plan-care-worker-change' => array(
			'What to arrange in case a carer falls ill mid-break: backup carers, contingency notes, and when cutting a trip short beats unsafe nights.',
			'What to do if a carer falls ill during your break, from backup cover to knowing when it’s safer to come home early.',
		),
		'quieter-times-whitstable-low-crowd-access' => array(
			'Weekday patterns, festival pitfalls, and why parking turnover matters as much as tide times for low-energy travellers.',
			'When Whitstable is at its quietest, which events to plan around, and why parking can matter as much as the tide.',
		),
		'changing-places-toilets-kent-coast-days-out' => array(
			'Why Changing Places matter, how standard accessible loos differ, and how to map toilet stops before you commit miles of promenade.',
			'Where to find Changing Places and accessible toilets on the Kent coast, and how to plan your stops before a long walk by the sea.',
		),
		'accessible-eating-out-whitstable-kent' => array(
			'Step-free routes, toilet reality, quieter tables, and why harbour weekends punish wheelchair circulation.',
			'Places to eat with step-free access and an accessible toilet, how to get a quieter table, and why the harbour gets so busy at weekends.',
		),
		'personal-budget-short-break-care-act' => array(
			'What a direct payment will and won\'t pay for on a short break (PA hours, transport, accommodation) and how to keep the paperwork clean for your council.',
			'What a direct payment can and can’t cover on a short break, such as PA hours and a PA’s travel. It also shows how to keep your council’s paperwork tidy.',
		),
		'commissioner-checklist-accessible-respite-stay' => array(
			'The evidence a funding panel expects before approving nights away: hoist paperwork, sleep-in safeguarding, and insurance certificates.',
			'The proof a funding panel usually wants before it agrees to nights away, from hoist paperwork to sleep-in plans and insurance.',
		),
		'travel-insurance-disability-uk-self-catering' => array(
			'Equipment limits, pre-existing conditions, cancellation clauses, and broker questions. Practical guidance, not legal advice.',
			'What to ask an insurer about your kit, your health and cancelling before a break in the UK. This is practical help, not legal advice.',
		),
		'accessible-train-travel-whitstable-kent' => array(
			'Passenger Assist, platform gaps, onward taxis, and why seaside rail hops still need backup plans when buses replace trains.',
			'How Passenger Assist works, what to know about platform gaps and taxis, and why it’s worth having a backup plan if buses replace the trains.',
		),
		'hire-mobility-scooter-equipment-uk-holiday' => array(
			'Scooters, profiling beds, and shower chairs: how to match hire stock to door widths, insurance small-print, delivery slots, and handover photos before you sign.',
			'How to hire a scooter, profiling bed or shower chair for your trip. It covers door widths, insurance and delivery, so you know what to check before you sign.',
		),
		'chc-respite-holiday-accommodation-uk' => array(
			'What NHS Continuing Healthcare can and cannot pay for on a break, how to split care invoices from cottage rent, and the paperwork panels expect before they sign off.',
			'What NHS Continuing Healthcare can and can’t pay for on a break. It covers how the care and the rent are billed, and what a panel needs to see.',
		),
		'accessible-parking-whitstable-tankerton' => array(
			'Blue Badge basics, where seaside crowds pinch space, and how to pair parking with level promenade walks, without pretending every bay is always empty.',
			'Blue Badge basics, where parking gets tight by the sea, and how to park close to the level seafront path. We won’t pretend a space is always free.',
		),
		'what-to-pack-accessible-self-catering-uk' => array(
			'A room-by-room packing list for hoist users, continence care, medication routines, and kitchen access, plus what to verify with the owner before you zip the case.',
			'A room-by-room packing list for hoist users, continence care, medicines and the kitchen, and what to check with the owner before you go.',
		),
		'carers-respite-holiday-guide' => array(
			'A practical guide for unpaid carers: what you\'re entitled to under the Care Act, how to get a carer\'s assessment in Kent, the funding routes available, and what makes a supported break actually restful.',
			'A guide for unpaid carers who need a break. It covers your rights under the Care Act and getting a carer’s assessment in Kent, and it explains how a break is paid for.',
		),
		'how-to-choose-accessible-self-catering-holiday' => array(
			'The word "accessible" on a property listing can mean almost anything. A practical checklist covering what to ask before booking, from door widths and hoist specifications to what red flags look like in listings.',
			'The word accessible on a listing can mean almost anything. This checklist shows what to ask before you book, from door widths and hoists to the warning signs.',
		),
		'revitalise-alternatives-accessible-holidays' => array(
			'Revitalise closed its holiday centres in November 2024 after 60 years. Here\'s what happened, what Revitalise now offers, and where to find accessible holidays in the UK.',
			'Revitalise closed its holiday centres in November 2024 after 60 years. Here’s what happened, what Revitalise offers now, and where else to find accessible holidays in the UK.',
		),
		'direct-payment-holiday-accommodation' => array(
			'Direct payments fund care, not accommodation, but that distinction matters. A plain-English guide to what direct payments can cover, how personal health budgets work, and what to discuss with your social worker before booking.',
			'Direct payments are mainly for care rather than the cost of a holiday, though some councils allow more. This guide explains what they can cover, how personal health budgets work, and what to ask your social worker.',
		),
		'accessible-beaches-coastal-walks-kent' => array(
			'Level promenades, shingle realities, and where to plan a seaside day if you use a wheelchair or mobility equipment, covering Whitstable, Herne Bay, Broadstairs, and Margate.',
			'A guide to level promenades and shingle beaches if you use a wheelchair or mobility equipment, covering Whitstable, Herne Bay, Broadstairs and Margate.',
		),
	);
	foreach ( $excerpts as $slug => $pair ) {
		$post = get_page_by_path( $slug, OBJECT, 'post' );
		if ( ! $post || $normalise( $post->post_excerpt ) !== $normalise( $pair[0] ) ) {
			continue;
		}
		wp_update_post(
			array(
				'ID'           => (int) $post->ID,
				'post_excerpt' => wp_slash( $pair[1] ),
			)
		);
	}

	$blog_id = (int) get_option( 'page_for_posts', 0 );
	if ( $blog_id > 0 && $normalise( get_post_field( 'post_excerpt', $blog_id ) ) === $normalise( 'Guides about accessible travel written from one adapted bungalow in Whitstable: the Kent coast in a wheelchair, how funding for a break usually works, and how to read an access statement so a listing can’t catch you out.' ) ) {
		wp_update_post(
			array(
				'ID'           => $blog_id,
				'post_excerpt' => wp_slash( 'Our guides are written from one adapted bungalow in Whitstable. They cover days out on the Kent coast, how to pay for a break, and how to check an access statement before you book.' ),
			)
		);
	}

	restwell_replace_stale_page_copy(
		array(
			'blog' => array(
				'meta_description' => array(
					'Guides written from one adapted house on the Kent coast: days out that work, funding explained, and how to read an access statement without getting caught out.',
					'Guides written from one adapted bungalow in Whitstable: Kent coast days out, how to pay for a break, and how to check an access statement before you book.',
				),
			),
			'faq'  => array(
				'faq_13_a' => array(
					'Some guests do, either for the stay or for a PA’s time. The rules vary from area to area, so it’s best to start with your own care team. Our <a href="/direct-payment-holiday-accommodation/">guide to direct payments</a> explains more.',
					'Sometimes. A direct payment has to meet the needs in your care and support plan. That usually means care while you’re away, like a PA’s hours. Some councils also cover a PA’s travel and room. Whether it can go towards the stay itself is up to your council, so ask your social worker before you book. Our <a href="/direct-payment-holiday-accommodation/">guide to direct payments</a> explains more.',
				),
			),
		)
	);
}

/**
 * 19 Oct 2026, copy brief batch 3 (Who It's For, Optional Care, Funding &
 * Support). Ellie asked for these to be decided and applied without a
 * separate sign-off, under the same rules as batches 1 and 2: no staccato
 * fragments, no soft headings, the hoist described as covering the whole
 * bedroom, the funding detail (capital limits, "same rate") left to the
 * Funding and Pricing pages, the unverified "councils can't ban holidays"
 * line replaced with what the guidance says, and care described as optional
 * with a Continuity quote. Same rule as v84: a stored value is replaced only
 * while it still equals the shipped seed.
 */
function restwell_migrate_batch3_copy_v87() {
	if ( get_option( 'restwell_batch3_copy_v87', '' ) === '1' ) {
		return;
	}
	update_option( 'restwell_batch3_copy_v87', '1', false );
	restwell_replace_stale_page_copy(
		array(
			'who-its-for' => array(
				'wif_intro' => array(
					'Built for disabled adults, families and carers, in parties of up to five. A holiday let, not a care home or respite centre.',
					'Restwell is built for disabled adults, their families and the people who care for them, in groups of up to five. It’s a holiday let you have to yourselves, not a care home or a respite centre.',
				),
				'wif_audience_intro' => array(
					'Families, carers, OTs and commissioners use the same published door widths and kit list, then decide if this bungalow fits before they travel.',
					'Families, carers, occupational therapists and commissioners all work from the same published door widths and equipment list. That way you can decide whether the bungalow fits before anyone travels.',
				),
				'wif_family_body' => array(
					'Hoist and wet room already fitted. Measurements published. A private home, not a hotel room.',
					'The hoist and the wet room are already fitted, and every measurement is published. It’s a private house, so your routines run on your own time rather than a hotel’s.',
				),
				'wif_family_detail_bullets' => array(
					"Ceiling track hoist in the accessible bedroom, profiling bed, and wet room with roll-in shower.\nPublished access measurements before you commit.\nA private, self-catering house, so your routines run to your own schedule.",
					"A ceiling track hoist across the whole bedroom, two profiling beds and a level wet room.\nEvery door width and safe working load published before you book.\nA private, self-catering house, so you keep your own routines.",
				),
				'wif_family_inline_cta_label' => array(
					'Read accessibility specification',
					'Door widths and the hoist',
				),
				'wif_carers_body' => array(
					'Separate sleeping and space to assist without blocking hall routes. Ask your council about a Carer’s Assessment under the Care Act 2014 if you need funding for a break.',
					'There’s a separate bedroom for a carer or support worker, and room to help with transfers and personal care. If you look after someone, you can ask your council for a carer’s assessment.',
				),
				'wif_carers_detail_bullets' => array(
					"A separate place to sleep for the support worker or carer.\nWet room designed for assisted personal care on the same level.\nYou have a legal right to a Carer's Assessment under the Care Act 2014.",
					"A separate bedroom for the support worker or carer.\nA level-access wet room with space to help with personal care.\nA legal right to a carer’s assessment under the Care Act 2014.",
				),
				'wif_ot_body' => array(
					'Door widths, hoist and wet-room specs are published. If you need one that isn’t, ask and we’ll measure it.',
					'Door widths, hoist details and wet room measurements are all published. If you need one we haven’t listed, ask and we’ll go and measure it.',
				),
				'wif_ot_detail_bullets' => array(
					'You’re welcome to talk to us about a referral before you commit to a booking.',
					'You’re welcome to talk a referral through with us before anyone commits to a booking.',
				),
				'wif_ot_inline_cta_label' => array(
					'Review accessibility details',
					'Door widths and the hoist',
				),
				'wif_commissioners_body' => array(
					'Care Act short breaks, with paperwork for direct payments, PHB or CHC. Same rates regardless of who we invoice.',
					'A stay here can form part of a Care Act short break. We can supply the paperwork for direct payments, personal health budgets or CHC.',
				),
				'wif_commissioners_detail_bullets' => array(
					"Short breaks at a private adapted setting can form part of a care and support plan under the Care Act 2014.\nWe can send the property spec, the measurements and the care provider’s CQC registration.\nWe support direct payments, personal health budgets and CHC.",
					"A short break in a private adapted house can be part of a care and support plan under the Care Act 2014.\nWe can send you the house details, the measurements and Continuity’s CQC rating.\nWe can work with direct payments, personal health budgets and CHC funding.",
				),
				'wif_visual_intro' => array(
					'These three items are on site before arrival, not hired for the week.',
					'All three are in the bungalow before you arrive, so there’s nothing to hire for the week.',
				),
				'wif_funding_body' => array(
					'If a stay is funded through a local authority, CHC, direct payments or a personal budget, the bungalow rate stays the same. Funding only changes who we invoice.',
					'We can invoice you, a council, an NHS team or a grant body. Our funding page explains how each route usually works and what to ask before you book.',
				),
				'wif_fund_la_bullets' => array(
					"It starts with a Care and Support Assessment. Unpaid carers can ask for a Carer's Assessment too (Care Act 2014).\nDirect payments: you receive the funding and choose your provider.\nCapital limits in England (2026/27): above £23,250 you generally pay in full; below £14,250 is usually ignored. Councils can set their own limits for care at home, so check yours.",
					"It starts with an assessment of your care needs, and unpaid carers can ask for their own assessment too.\nWith direct payments, you hold the money and choose who provides the support.\nWhether a direct payment covers the stay is up to your council, so ask before you book.",
				),
				'wif_fund_phb_bullets' => array(
					"For people with continuing healthcare needs who are found eligible.\nYour ICB or NHS continuing healthcare team handles the application.\nA private adapted house can go into a care and support plan where it suits your clinical needs.",
					"For people found eligible for NHS Continuing Healthcare.\nYour ICB or continuing healthcare team handles the application.\nA stay in a private adapted house can be written into the plan where it meets the person’s needs.",
				),
				'wif_fund_phb_cta_label' => array(
					'PHB and funding overview',
					'How NHS funding usually works',
				),
				'wif_fund_private_bullets' => array(
					"You get the same clear access information and straight answers as funded guests.\nPaperwork for insurers or employers, if you need it.\nNo pressure: we tell you plainly whether the property is a good fit.",
					"You get the same access information and straight answers as funded guests.\nWe can send paperwork for your insurer or employer if you need it.\nWe’ll tell you plainly if the bungalow isn’t the right fit.",
				),
				'wif_cta_heading' => array(
					'Describe the party and equipment',
					'Tell us who’s coming and what you use',
				),
				'wif_cta_body' => array(
					'We’ll say straight whether the bungalow fits, or where it doesn’t.',
					'We’ll tell you plainly whether the bungalow fits, and where it doesn’t.',
				),
				'wif_cta_secondary_label' => array(
					'Read accessibility',
					'Door widths and the hoist',
				),
				'meta_description' => array(
					'A private adapted bungalow that sleeps five, for disabled adults, families and the people who care for them. A holiday, not a placement. See whether it fits.',
					'A private adapted bungalow in Whitstable for disabled adults, their families and carers, in groups of up to five. Check the measurements before you book.',
				),
			),
			'optional-care' => array(
				'care_heading' => array(
					'Care that comes to your holiday',
					'Optional home care during your stay',
				),
				'care_intro' => array(
					'Our sister company, Continuity of Care Services, can come into the bungalow while you’re here. As much or as little as you’d like, and only if you ask.',
					'Our sister company, Continuity of Care Services, can come into the bungalow while you’re here, but only if you ask. How much help they can give depends on what you need and who’s free, so we’ll talk it through with you first.',
				),
				'care_day_heading' => array(
					'A day, with as much help as you like',
					'Morning, daytime and overnight help',
				),
				'care_day_lede' => array(
					'Tell us what a good day looks like at home and we’ll work backwards from there.',
					'Tell us what a normal day looks like at home, and Continuity will plan the help around it.',
				),
				'care_day_1_body' => array(
					'Help up, washed and dressed, at the time you’d get up at home. The shower chair is already in the wet room.',
					'Help getting up, washed and dressed at the time you’d get up at home. The shower chair is already in the wet room.',
				),
				'care_day_2_body' => array(
					'Company along the promenade or into town. Or a few hours so whoever usually does the caring can look at the water without watching the clock.',
					'Someone to come along the promenade or into town, or a few hours of cover so the usual carer can have some time off.',
				),
				'care_day_3_body' => array(
					'A sleep-in, or a waking night if someone needs to be up, so the person who usually lies awake listening gets to sleep.',
					'A sleep-in, or a waking night if someone needs help during the night, so the person who usually cares can get some sleep.',
				),
				'care_how_lede' => array(
					'Mention it on the same enquiry as the house. Nothing is booked until you say yes.',
					'Mention it on the same enquiry as the house, and nothing is booked until you say yes.',
				),
				'care_how_step1_body' => array(
					'Even if your dates are vague.',
					'Mention it in your first message, even if your dates aren’t fixed yet.',
				),
				'care_how_step2_body' => array(
					'Continuity ask about hours and tasks.',
					'Continuity will ask about the hours and the tasks you need help with.',
				),
				'care_how_step3_body' => array(
					'Nothing is booked until you say yes.',
					'Continuity give you a quote, and nothing is booked until you’re happy with it.',
				),
				'care_pro_lede' => array(
					'Door widths and kit are published, and Continuity confirm the care plan and cost once hours and tasks are agreed.',
					'Door widths and equipment are published, and Continuity confirm the care plan and the cost once the hours and tasks are agreed.',
				),
				'care_faq_1_a' => array(
					'No. Many guests book the house as a self-catering holiday and need no additional support. Continuity care is optional.',
					'No. Plenty of guests book the house as a self-catering holiday and don’t need any extra support. Care from Continuity is there if you’d like it.',
				),
				'care_faq_2_a' => array(
					'No. Restwell is a private holiday bungalow. Continuity of Care Services (our sister company) is the CQC-regulated provider if you want professional care during your stay.',
					'No. Restwell is a private holiday bungalow. Continuity of Care Services, our sister company, is the CQC-registered provider if you’d like professional care during your stay.',
				),
				'care_faq_3_q' => array(
					'Do I book care separately?',
					'Do I need to book care on its own?',
				),
				'care_faq_3_a' => array(
					'No. Ask when you enquire about the bungalow. Restwell and Continuity share 01622 809881, so house and care can start in one conversation when you want both.',
					'No. Just mention it when you enquire about the bungalow. Restwell and Continuity share 01622 809881, so the house and the care can start in one conversation.',
				),
				'care_faq_4_a' => array(
					'Yes. The layout supports familiar routines, with separate sleeping and space to assist. Tell us your party layout when you enquire.',
					'Yes. A carer can have the second bedroom, and there’s space to help with transfers and personal care. Tell us who’s coming when you enquire, and we’ll set the rooms up to suit.',
				),
				'care_faq_5_a' => array(
					'On Pricing & dates. They are Continuity guide rates only. Continuity quotes your care cost once hours and tasks are agreed.',
					'On Pricing & dates. They’re Continuity’s guide rates, and Continuity give you a quote once the hours and tasks are agreed.',
				),
				'care_cta_body' => array(
					'Ring 01622 809881 or send a note. There’s no such thing as a silly question.',
					'Ring 01622 809881 or send us a note, and we’ll talk through what would help.',
				),
				'meta_description' => array(
					'Continuity of Care Services, our sister company, can come into the bungalow while you stay. Same conversation as the house. Ring 01622 809881 or send us a note.',
					'Continuity of Care Services, our sister company, can come into the bungalow while you stay. Ask on the same enquiry as the house, or call 01622 809881.',
				),
			),
			'funding-and-support' => array(
				'res_heading' => array(
					'Paying for a break, without the guesswork',
					'Funding an accessible holiday',
				),
				'res_intro' => array(
					'Who can pay for a stay: direct, a council, the NHS or a grant body, and how funding for a break usually works.',
					'A stay can be paid for by you, a council, the NHS or a grant body. Here’s how each route usually works, and what to ask before you book.',
				),
				'meta_description' => array(
					'How Restwell handles funding, invoices and care costs for an accessible holiday. Clear information before you commit to dates or a deposit.',
					'How a break at Restwell can be paid for: direct payments, NHS Continuing Healthcare, charity grants or paying yourself, and the paperwork we can send.',
				),
			),
		)
	);
}

/**
 * 19 Oct 2026, copy brief batch 4 (Our Story, Whitstable), decided and applied
 * under the same rules as batches 1 to 3: plain headings in place of clever
 * ones ("Nothing very complicated", "...what to expect underfoot"), full
 * sentences in place of fragments, no SEO notes in visible copy, Dreamland
 * described by its access schemes rather than "a park you can use in a
 * wheelchair", and the banned words "bespoke" and "unlocks" taken out of the
 * direct payments guide. Page copy is replaced only while it still equals the
 * shipped seed; the post's phrases are swapped only where the exact old phrase
 * is still present, so any other edits to the post are kept.
 */
function restwell_migrate_batch4_copy_v88() {
	if ( get_option( 'restwell_batch4_copy_v88', '' ) === '1' ) {
		return;
	}
	update_option( 'restwell_batch4_copy_v88', '1', false );

	restwell_replace_stale_page_copy(
		array(
			'our-story' => array(
				'story_companies_1_body' => array(
					'The bungalow: a private adapted house in Whitstable. Not a care home, and not a respite centre.',
					'The bungalow is a private adapted house in Whitstable. It isn’t a care home or a respite centre.',
				),
				'story_shaped_heading' => array(
					'Designed with the people who’d actually stay',
					'Planned with disabled people before it opened',
				),
				'story_specialists_heading' => array(
					'The numbers are published so you don’t have to trust us',
					'Every measurement is published',
				),
				'story_specialists_btn1_label' => array(
					'Read the access specs',
					'Door widths and the hoist',
				),
				'story_next_heading' => array(
					'Nothing very complicated',
					'What we hold ourselves to',
				),
				'story_next_lede' => array(
					'Publish the numbers. Say what the house can’t do as clearly as what it can. Make it possible to arrange a week away, and the support to enjoy it, in one conversation. Nobody should have to explain their situation four times to four people.',
					'We publish every measurement. We say what the house can’t do as clearly as what it can. You can arrange a week away, and the support to enjoy it, in one conversation. Nobody should have to explain their situation four times to four different people.',
				),
				'meta_description' => array(
					'Restwell is a private adapted bungalow in Whitstable. Continuity of Care Services is our sister company for home care. Two companies, one family, one phone.',
					'Why we built Restwell, a private adapted bungalow in Whitstable. Our sister company, Continuity of Care Services, can add home care to your stay.',
				),
			),
			'whitstable-area-guide' => array(
				'wg_heading' => array(
					'Days out from the bungalow, and what to expect underfoot',
					'Accessible days out in Whitstable and Tankerton',
				),
				'wg_about_body' => array(
					'About two miles of paved route from Tankerton Slopes toward the castle and harbour. Beach slopes to the shingle are steep, stick to the promenade for level sea air.',
					'About two miles of paved path runs from Tankerton Slopes towards the castle and harbour. The slopes down to the shingle are steep, so stay on the promenade for the level route.',
				),
				'wg_getting_here_body' => array(
					'Start from the driveway when you can. Harbour ANPR is the one that catches people out.',
					'Park on the driveway when you can. In town, the harbour car parks are the ones that catch people out, because they use number-plate cameras.',
				),
				'wg_getting_around_body' => array(
					'Travel times from London are in the strip above. Below: how to move around Whitstable once you’ve arrived.',
					'Travel times from London are in the strip at the top of the page. Here’s how to get around Whitstable once you’ve arrived.',
				),
				'wg_access_intro' => array(
					'Level stops on the promenade route, with access notes and links so you can check opening times before you set out.',
					'These are level stops on the promenade route, with access notes and links so you can check opening times before you set out.',
				),
				'wg_related_intro' => array(
					'Long-tail notes on parking, trains, eating out, beaches and quieter timing. This page stays the Whitstable Kent coast overview.',
					'Longer guides on parking, trains, eating out, beaches and the quieter times to visit.',
				),
				'wg_planning_intro' => array(
					'Public and venue loos on the promenade route. Changing Places at the harbour needs a RADAR key.',
					'These are the public and venue toilets on the promenade route. The Changing Places toilet at the harbour needs a RADAR key.',
				),
				'wg_eating_intro' => array(
					'The Plough is around the corner; JoJo’s and the Marine Hotel sit on Tankerton. Most Whitstable venues are older buildings, call ahead if access is critical.',
					'The Plough is around the corner, and JoJo’s and the Marine Hotel are on Tankerton. Most Whitstable venues are in older buildings, so call ahead if access is critical.',
				),
				'wg_cta_body' => array(
					'Tell us chair size and energy levels, then look inside the bungalow.',
					'Tell us your chair size and how far you like to go in a day, and we’ll point you to the routes that suit.',
				),
			),
		)
	);

	$post = get_page_by_path( 'direct-payment-holiday-accommodation', OBJECT, 'post' );
	if ( ! $post ) {
		return;
	}
	$content = (string) $post->post_content;
	$phrases = array(
		array(
			'Self-funded, grants, or bespoke short-break funding',
			'Self-funded, grants, or a short-break package agreed for the person',
		),
		array(
			'Care duties yes; room charges typically stay separate unless a bespoke NHS package states otherwise.',
			'Care, yes. Room charges usually aren’t covered unless an individual NHS package says otherwise.',
		),
		array(
			'What question unlocks short-break funding?',
			'What should you ask to get short-break funding?',
		),
	);
	$updated = $content;
	foreach ( $phrases as $pair ) {
		$updated = str_replace( $pair[0], $pair[1], $updated );
	}
	if ( $updated !== $content ) {
		wp_update_post(
			array(
				'ID'           => (int) $post->ID,
				'post_content' => wp_slash( $updated ),
			)
		);
	}
}

/**
 * 19 Oct 2026: the Pricing FAQ now renders the pricing_faq_{N} fields, so an
 * edit in wp-admin reaches the page. Those fields still held the five
 * questions seeded in August, one of them saying "the rate is identical" next
 * to care. Each slot moves to the four questions the page has shown since
 * Batch 2, and the old deposit question is cleared. A question and its answer
 * move together, and only while both still equal the old seed, so a pair
 * Victoria or Ellie has edited is never split.
 */
function restwell_migrate_pricing_faq_v89() {
	if ( get_option( 'restwell_pricing_faq_v89', '' ) === '1' ) {
		return;
	}
	update_option( 'restwell_pricing_faq_v89', '1', false );
	if ( ! function_exists( 'restwell_page_id_for_stock_slug' ) ) {
		return;
	}
	$page_id = restwell_page_id_for_stock_slug( 'pricing' );
	if ( $page_id < 1 ) {
		return;
	}
	$slots = array(
		1 => array(
			'q' => array(
				'What does the bungalow price include?',
				'Is care included in the bungalow price?',
			),
			'a' => array(
				'You book the whole house, with all the access equipment included. A week is £1,300 off-peak and £1,400 in peak season; midweek nights are £185 and £200. A 50% deposit reserves your dates, and the balance is due a week before arrival.',
				'No. The bungalow price covers the house and the access equipment that’s already there. Care from Continuity is optional, and they’ll give you a quote once you’ve talked through what you need. Their guide rates are above.',
			),
		),
		2 => array(
			'q' => array(
				'Is care included in the price?',
				'Are there extra charges for equipment?',
			),
			'a' => array(
				'No. Restwell is the accommodation. If you’d like home care, Continuity of Care Services, our sister company, will quote for it.',
				'The hoists, the profiling beds and the wet room equipment are all included. If you need something specialist that isn’t on our list, there’s a charge to hire it, so let us know when you enquire. Please bring your own slings, because a sling needs to fit the person using it.',
			),
		),
		3 => array(
			'q' => array(
				'Are there extra charges for the equipment?',
				'Does the price change if a council or the NHS pays?',
			),
			'a' => array(
				'No. The hoist, the profiling bed and the wet room kit listed on the access statement are all included in the house rate.',
				'No. The price is the same whoever pays, and the only thing that changes is who we send the invoice to. <a class="text-link" href="/funding-and-support/">Funding & Support</a> explains how that works.',
			),
		),
		4 => array(
			'q' => array(
				'Does the price change depending on who’s funding it?',
				'When do care guide rates go up?',
			),
			'a' => array(
				'No. The rate is identical whether you pay, a council pays, the NHS pays, or a grant body pays. All that changes is who receives the invoice.',
				'Care costs more at weekends, on bank holidays and for complex care. Continuity review their rates regularly, and the next review date is shown above. They’ll give you a quote once you’ve agreed the hours and tasks with them.',
			),
		),
		5 => array(
			'q' => array( 'How much deposit do I pay?', '' ),
			'a' => array( '50%, once we’ve confirmed the house fits. The remaining balance is due no later than one week before you arrive.', '' ),
		),
	);
	$fields = array();
	foreach ( $slots as $i => $slot ) {
		foreach ( $slot as $part => $pair ) {
			$stored = trim( str_replace( array( "\r\n", "\r" ), "\n", (string) get_post_meta( $page_id, "pricing_faq_{$i}_{$part}", true ) ) );
			if ( $stored !== $pair[0] ) {
				continue 2;
			}
		}
		$fields[ "pricing_faq_{$i}_q" ] = $slot['q'];
		$fields[ "pricing_faq_{$i}_a" ] = $slot['a'];
	}
	restwell_replace_stale_page_copy( array( 'pricing' => $fields ) );
}

/**
 * 19 Oct 2026: the Pricing FAQ eyebrow and heading now read their wp-admin
 * fields. Those still held the July seeds, "FAQ" and "Common questions about
 * pricing", so they move to the "Money questions" and "Questions about
 * prices" the page has shown since Batch 2. Same rule as v85: a stored value
 * is replaced only while it still equals the old seed.
 */
function restwell_migrate_pricing_faq_heading_v90() {
	if ( get_option( 'restwell_pricing_faq_heading_v90', '' ) === '1' ) {
		return;
	}
	update_option( 'restwell_pricing_faq_heading_v90', '1', false );
	restwell_replace_stale_page_copy(
		array(
			'pricing' => array(
				'pricing_faq_label'   => array( 'FAQ', 'Money questions' ),
				'pricing_faq_heading' => array( 'Common questions about pricing', 'Questions about prices' ),
			),
		)
	);
}

/**
 * Home call-to-action labels, shorter (19 Oct 2026): the owner asked for
 * shorter buttons. "Look inside the bungalow" (hero and closing band),
 * "Have a proper look round the rooms" (the bungalow section) and "What home
 * care here actually looks like" (the care card). Same rule as
 * v85: a stored value is replaced only while it still equals the old seed.
 */
function restwell_migrate_home_cta_labels_v91() {
	if ( get_option( 'restwell_home_cta_labels_v91', '' ) === '1' ) {
		return;
	}
	update_option( 'restwell_home_cta_labels_v91', '1', false );
	restwell_replace_stale_page_copy(
		array(
			'home' => array(
				'hero_cta_secondary_label' => array( 'Look inside the bungalow', 'Look inside' ),
				'cta_secondary_label'      => array( 'Look inside the bungalow', 'Look inside' ),
				'property_cta_label'       => array( 'Have a proper look round the rooms', 'See the rooms' ),
				'home_care_cta_label'      => array( 'What home care here actually looks like', 'How home care works' ),
			),
		)
	);
}

/**
 * Pricing rates intro, shorter (21 Oct 2026): the owner asked for a shorter
 * line. The day ranges are already in the rates, and care has its own
 * section further down the page. Same rule as v85: a stored value is replaced
 * only while it still equals the old seed.
 */
function restwell_migrate_pricing_rates_intro_v92() {
	if ( get_option( 'restwell_pricing_rates_intro_v92', '' ) === '1' ) {
		return;
	}
	update_option( 'restwell_pricing_rates_intro_v92', '1', false );
	restwell_replace_stale_page_copy(
		array(
			'pricing' => array(
				'pricing_rates_intro' => array(
					'You book the whole bungalow, which sleeps up to five. Weekend nights (Friday to Sunday) cost a little more than midweek nights (Monday to Thursday), and the minimum stay is one night. Care from Continuity is optional, and they’ll give you a quote for it.',
					'You book the whole bungalow, for up to five people. Weekend nights cost a little more than midweek nights, and you can stay for just one night.',
				),
			),
		)
	);
}

/**
 * Our Story, plainer words (21 Oct 2026): the two-company redesign cut the
 * page's shortest sentences and left it at Flesch 69.6, under the 70 aim.
 * "Accommodation" becomes "the bungalow" and "is accountable for" becomes
 * "answers for". Same rule as v85: a stored value is replaced only while it
 * still equals the old seed.
 */
function restwell_migrate_our_story_plain_words_v93() {
	if ( get_option( 'restwell_our_story_plain_words_v93', '' ) === '1' ) {
		return;
	}
	update_option( 'restwell_our_story_plain_words_v93', '1', false );
	restwell_replace_stale_page_copy(
		array(
			'our-story' => array(
				'story_host_lede'      => array(
					'Victoria owns Restwell and is Continuity’s registered manager, so one person is accountable for the house and for the care. Day to day, you’re more likely to speak with someone else in the office. They work across both companies too, so you won’t need to start from the beginning each time you call.',
					'Victoria owns Restwell and is Continuity’s registered manager, so one person answers for the house and for the care. Day to day, you’re more likely to speak with someone else in the office. They work across both companies too, so you won’t need to start from the beginning each time you call.',
				),
				'story_companies_lede' => array(
					'Restwell provides the accommodation. Continuity of Care Services provides the optional care. They quote for it once you’ve talked through what you need.',
					'Restwell runs the bungalow. Continuity of Care Services provides the optional care. They quote for it once you’ve talked through what you need.',
				),
			),
		)
	);
}

/**
 * Our Story, how the bungalow was built (22 Oct 2026): the owner picked the
 * teal card with shorter words. The intro loses its last sentence and each
 * date gets one short line. Same rule as v85: a stored value is replaced
 * only while it still equals the old seed.
 */
function restwell_migrate_our_story_build_card_v94() {
	if ( get_option( 'restwell_our_story_build_card_v94', '' ) === '1' ) {
		return;
	}
	update_option( 'restwell_our_story_build_card_v94', '1', false );
	restwell_replace_stale_page_copy(
		array(
			'our-story' => array(
				'story_month_lede'    => array(
					'Family, friends and three specialist teams brought the bungalow together in a month. Before anyone stayed, occupational therapists from Kent Community Health NHS Trust walked the bedroom and wet room. We changed what they flagged, down to the profiling bed.',
					'Family, friends and three specialist teams brought it together in a month. Before anyone stayed, occupational therapists from Kent Community Health NHS Trust checked the bedroom and wet room.',
				),
				'story_month_1_body'  => array(
					'The bungalow needed more than a lick of paint.',
					'It needed more than a lick of paint.',
				),
				'story_month_2_body'  => array(
					'The accessible bedroom and wet room were built by Care Spaces by Wealden Rehab and Thor Carpentry, with the occupational therapists’ advice. Family and friends did the rest.',
					'Care Spaces and Thor Carpentry built the bedroom and wet room.',
				),
				'story_month_3_title' => array(
					'The bungalow was ready',
					'It was ready',
				),
				'story_month_3_body'  => array(
					'Once the work was finished, we measured everything and wrote the numbers down.',
					'We measured everything and wrote it down.',
				),
			),
		)
	);
}

/**
 * Shorter intros (22 Oct 2026, owner's notes): Who It's For's audience intro
 * ran to three lines at the intro width, and the Whitstable days-out intro
 * left three words on a second line. Same rule as v85: a stored value is
 * replaced only while it still equals the old seed.
 */
function restwell_migrate_short_intros_v95() {
	if ( get_option( 'restwell_short_intros_v95', '' ) === '1' ) {
		return;
	}
	update_option( 'restwell_short_intros_v95', '1', false );
	restwell_replace_stale_page_copy(
		array(
			'who-its-for'           => array(
				'wif_audience_intro' => array(
					'Families, carers, occupational therapists and commissioners all work from the same published door widths and equipment list. That way you can decide whether the bungalow fits before anyone travels.',
					'Everyone works from the same door widths and kit list, so you can check the bungalow fits before anyone travels.',
				),
			),
			'whitstable-area-guide' => array(
				'wg_towns_body' => array(
					'Check each venue’s site for scooter hire, companion tickets and parking for your dates.',
					'Check each venue for scooter hire, companion tickets and parking.',
				),
			),
		)
	);
}

/**
 * Optional Care, shorter hero and day intro (22 Oct 2026, owner's notes): the
 * hero ran to four lines, and the day intro left three words on a second
 * line. Same rule as v85: a stored value is replaced only while it still
 * equals the old seed.
 */
function restwell_migrate_care_intros_v96() {
	if ( get_option( 'restwell_care_intros_v96', '' ) === '1' ) {
		return;
	}
	update_option( 'restwell_care_intros_v96', '1', false );
	restwell_replace_stale_page_copy(
		array(
			'optional-care' => array(
				'care_intro'    => array(
					'Our sister company, Continuity of Care Services, can come into the bungalow while you’re here, but only if you ask. How much help they can give depends on what you need and who’s free, so we’ll talk it through with you first.',
					'Our sister company, Continuity of Care Services, can come in while you’re here if you ask. Tell us what you need and we’ll check who’s free.',
				),
				'care_day_lede' => array(
					'Tell us what a normal day looks like at home, and Continuity will plan the help around it.',
					'Tell us what a normal day looks like, and Continuity will plan around it.',
				),
			),
		)
	);
}

/**
 * A post body's text, normalised for comparison: tags stripped, entities
 * decoded, curly quotes straightened and whitespace collapsed. Two bodies with
 * the same fingerprint read the same, whatever their links point to.
 *
 * @param string $html Post content.
 * @return string md5 of the normalised text.
 */
function restwell_post_text_fingerprint( $html ) {
	$text = html_entity_decode( wp_strip_all_tags( (string) $html ), ENT_QUOTES | ENT_HTML5, 'UTF-8' );
	$text = str_replace( array( "\u{2019}", "\u{2018}", "\u{201C}", "\u{201D}", "\r\n", "\r" ), array( "'", "'", '"', '"', "\n", "\n" ), $text );
	return md5( trim( (string) preg_replace( '/\s+/u', ' ', $text ) ) );
}

/**
 * Batch A (23 Oct 2026): the five kept guides rewritten to the October SEO
 * blueprint (docs/seo-blueprint-2026-10-22.md), with new titles, excerpts and
 * SEO meta. A body is replaced only while its text still matches the shipped
 * seed (the fingerprints below), and each other field only while it still
 * equals its old seeded value, so anything edited in wp-admin is kept.
 */
function restwell_migrate_batch_a_posts_v97() {
	if ( get_option( 'restwell_batch_a_posts_v97', '' ) === '1' ) {
		return;
	}
	update_option( 'restwell_batch_a_posts_v97', '1', false );

	$was = array(
		'accessible-beaches-coastal-walks-kent'          => array(
			'text'             => 'db923f3e7c095fc32e17d74507092911',
			'title'            => 'A guide to accessible beaches and coastal walks in Kent',
			'excerpt'          => 'A guide to level promenades and shingle beaches if you use a wheelchair or mobility equipment, covering Whitstable, Herne Bay, Broadstairs and Margate.',
			'meta_title'       => 'Accessible beaches and coastal walks in Kent',
			'meta_description' => 'Accessible beaches Kent: level promenades, Beach Within Reach, Herne Bay, Viking Bay, Margate. Plan a seaside day with realistic access notes.',
			'focus_keyphrase'  => 'accessible beaches kent',
		),
		'direct-payment-holiday-accommodation'           => array(
			'text'             => 'da6dbd43fd8b8b7d7f28508910d68b01',
			'title'            => 'How to use your direct payment for a holiday',
			'excerpt'          => 'Direct payments are mainly for care rather than the cost of a holiday, though some councils allow more. This guide explains what they can cover, how personal health budgets work, and what to ask your social worker.',
			'meta_title'       => 'Using direct payments for a holiday: what they cover',
			'meta_description' => 'Direct payment for holiday stays: what counts as care vs accommodation, personal budgets, short breaks, and questions for your social worker.',
			'focus_keyphrase'  => 'direct payment for holiday',
		),
		'revitalise-alternatives-accessible-holidays'    => array(
			'text'             => 'dbdf9afd9a64a35ecc0692404705b360',
			'title'            => 'What happened to Revitalise, and where to find accessible holidays now',
			'excerpt'          => 'Revitalise closed its holiday centres in November 2024 after 60 years. Here’s what happened, what Revitalise offers now, and where else to find accessible holidays in the UK.',
			'meta_title'       => 'What happened to Revitalise, and where to go now',
			'meta_description' => 'Revitalise closed its holiday centres in 2024: why, what the charity funds now, and where to find accessible UK holidays and respite alternatives.',
			'focus_keyphrase'  => 'revitalise',
		),
		'how-to-choose-accessible-self-catering-holiday' => array(
			'text'             => '423d4cce55c37c1f0fa9ca7955019319',
			'title'            => 'How to choose an accessible self-catering holiday property',
			'excerpt'          => 'The word accessible on a listing can mean almost anything. This checklist shows what to ask before you book, from door widths and hoists to the warning signs.',
			'meta_title'       => 'How to choose an accessible self-catering holiday',
			'meta_description' => 'Choose an accessible self-catering holiday: verify hoist specs, door widths, wet rooms, and red flags in listings before you pay a deposit.',
			'focus_keyphrase'  => 'accessible self-catering holiday',
		),
		'how-to-read-holiday-cottage-access-statement'   => array(
			'text'             => '22cb7f5a5f20e37e3a7c521ac5dafc0f',
			'title'            => 'How to read a holiday cottage access statement before you book',
			'excerpt'          => 'The sizes to check, the hoist details to ask for, and the words in a listing that should make you think twice.',
			'meta_title'       => 'How to read a holiday cottage access statement',
			'meta_description' => 'How to read a holiday cottage access statement: measurements that matter, hoist proof, red-flag phrases, and questions OTs and families should ask.',
			'focus_keyphrase'  => 'holiday cottage access statement',
		),
	);

	$articles = array();
	foreach ( restwell_get_priority_blog_post_articles() as $article ) {
		$articles[ $article['slug'] ] = $article;
	}
	$seo = restwell_get_seo_meta_defaults_by_slug();

	foreach ( $was as $slug => $old ) {
		$post = get_page_by_path( $slug, OBJECT, 'post' );
		if ( ! $post || empty( $articles[ $slug ] ) ) {
			continue;
		}
		$new    = $articles[ $slug ];
		$update = array();
		if ( restwell_post_text_fingerprint( $post->post_content ) === $old['text'] ) {
			$update['post_content'] = wp_kses_post( $new['content'] );
		}
		if ( $post->post_title === $old['title'] ) {
			$update['post_title'] = $new['title'];
		}
		if ( trim( $post->post_excerpt ) === $old['excerpt'] ) {
			$update['post_excerpt'] = $new['excerpt'];
		}
		if ( $update ) {
			$update['ID'] = (int) $post->ID;
			wp_update_post( wp_slash( $update ) );
		}
		foreach ( array( 'meta_title', 'meta_description' ) as $key ) {
			if ( (string) get_post_meta( $post->ID, $key, true ) === $old[ $key ] ) {
				update_post_meta( $post->ID, $key, $new[ $key ] );
			}
		}
		if ( (string) get_post_meta( $post->ID, 'focus_keyphrase', true ) === $old['focus_keyphrase'] && ! empty( $seo[ $slug ]['focus_keyphrase'] ) ) {
			update_post_meta( $post->ID, 'focus_keyphrase', $seo[ $slug ]['focus_keyphrase'] );
		}
	}
}

/**
 * Publish the five kept guides where they don't exist yet (23 Oct 2026). The
 * live site never ran Theme Setup, so it had no posts at all. Only these five
 * are created (the other seeded guides stay off live), and a guide is skipped
 * if a post with its slug exists in any state, trash included, so one that
 * was deliberately removed isn't brought back.
 */
function restwell_migrate_publish_kept_guides_v98() {
	if ( get_option( 'restwell_publish_kept_guides_v98', '' ) === '1' ) {
		return;
	}
	update_option( 'restwell_publish_kept_guides_v98', '1', false );

	$keep    = array( 'accessible-beaches-coastal-walks-kent', 'direct-payment-holiday-accommodation', 'revitalise-alternatives-accessible-holidays', 'how-to-choose-accessible-self-catering-holiday', 'how-to-read-holiday-cottage-access-statement' );
	$defs    = function_exists( 'restwell_get_blog_category_definitions' ) ? restwell_get_blog_category_definitions() : array();
	$seo     = restwell_get_seo_meta_defaults_by_slug();
	$admins  = get_users(
		array(
			'role'    => 'administrator',
			'number'  => 1,
			'orderby' => 'ID',
			'fields'  => 'ID',
		)
	);
	$author  = $admins ? (int) $admins[0] : 1;

	foreach ( restwell_get_priority_blog_post_articles() as $article ) {
		if ( ! in_array( $article['slug'], $keep, true ) ) {
			continue;
		}
		// WordPress renames a binned post to "{slug}__trashed", so look for both.
		$existing = get_posts(
			array(
				'post_name__in'  => array( $article['slug'], $article['slug'] . '__trashed' ),
				'post_type'      => 'post',
				'post_status'    => array( 'publish', 'draft', 'pending', 'private', 'future', 'trash' ),
				'posts_per_page' => 1,
				'fields'         => 'ids',
			)
		);
		if ( $existing ) {
			continue;
		}
		$args = array(
			'post_title'   => $article['title'],
			'post_name'    => $article['slug'],
			'post_status'  => 'publish',
			'post_type'    => 'post',
			'post_content' => wp_kses_post( $article['content'] ),
			'post_excerpt' => $article['excerpt'],
			'post_author'  => $author,
		);
		$slug = isset( $article['category_slug'] ) ? sanitize_title( $article['category_slug'] ) : '';
		if ( $slug && isset( $defs[ $slug ] ) ) {
			$term = term_exists( $slug, 'category' );
			if ( ! $term ) {
				$term = wp_insert_term(
					$defs[ $slug ]['name'],
					'category',
					array(
						'slug' => $slug,
						'description' => $defs[ $slug ]['description'],
					)
				);
			}
			if ( $term && ! is_wp_error( $term ) ) {
				$args['post_category'] = array( (int) ( is_array( $term ) ? $term['term_id'] : $term ) );
			}
		}
		$post_id = wp_insert_post( wp_slash( $args ), true );
		if ( is_wp_error( $post_id ) || ! $post_id ) {
			continue;
		}
		update_post_meta( $post_id, 'meta_title', $article['meta_title'] );
		update_post_meta( $post_id, 'meta_description', $article['meta_description'] );
		if ( ! empty( $seo[ $article['slug'] ]['focus_keyphrase'] ) ) {
			update_post_meta( $post_id, 'focus_keyphrase', $seo[ $article['slug'] ]['focus_keyphrase'] );
		}
	}
}

/**
 * Batch B (23 Oct 2026): the core pages rewritten to the October SEO blueprint
 * (docs/seo-blueprint-2026-10-22.md). It brings in the section 4 titles, metas
 * and H1s, the H2 fixes, plain words on Home, The Property, Optional Care, Our
 * Story and Funding, and no sentence over 20 words on any main page. Each field
 * lists every older value it may still hold (the fresh-install seeds as well as
 * earlier migrations), and a stored value is replaced only while it equals one
 * of them, so anything edited in wp-admin is kept.
 */
function restwell_migrate_page_copy_batch_b_v99() {
	if ( get_option( 'restwell_page_copy_batch_b_v99', '' ) === '1' ) {
		return;
	}
	update_option( 'restwell_page_copy_batch_b_v99', '1', false );
	$changes = array(
		'home' => array(
			'meta_title' => array(
				array(
					'Accessible holiday cottage in Whitstable, sleeps five',
				),
				'Accessible holiday cottage in Whitstable, Kent, sleeps five',
			),
			'meta_description' => array(
				array(
					'One private bungalow by the sea, with the wet room and ceiling hoist already fitted. The whole house is yours, and home care can be arranged if you’d like it.',
					'A private bungalow in Whitstable with a level wet room and ceiling hoist. It sleeps five, and you can add home care from our sister company if you’d like.',
				),
				'A private bungalow by the sea in Whitstable, Kent, with a level wet room and ceiling hoist fitted. It sleeps five, and our sister company can add care.',
			),
			'home_care_heading' => array(
				array(
					'Optional home care',
				),
				'Home care from our sister company',
			),
			'home_care_item1_body' => array(
				array(
					'Plenty of guests bring their own carer or PA, or simply manage the way they do at home, and the second bedroom gives a carer somewhere proper to sleep.',
				),
				'Plenty of guests bring their own carer or PA, or manage the way they do at home. The second bedroom gives a carer somewhere proper to sleep.',
			),
			'hero_subheading' => array(
				array(
					'A private, single-storey bungalow a short walk from the sea, with a level wet room and a ceiling track hoist already fitted. Home care from our sister company is there if you’d like it.',
					'A private, single-storey bungalow a short walk from the sea. The level wet room and ceiling track hoist are already fitted. Home care from our sister company is there if you’d like it.',
				),
				'A private, single-storey bungalow a short walk from the sea. The level wet room and ceiling track hoist are already fitted. Home care from our sister company is there if you’d like it.',
			),
			'property_body' => array(
				array(
					"It sits on a quiet residential street in Whitstable, about ten minutes from the seafront. The driveway is private and level. It takes two cars, including an adapted vehicle, and the front door is straight ahead when you park.\n\nInside there are two bedrooms and a double sofa bed in the conservatory, so up to five people can stay. You can book from a single night, and we’ll set the bedroom up around what you tell us before you arrive. We’ll send the address and directions once your stay is confirmed.",
					"It sits on a quiet residential street in Whitstable, about ten minutes from the seafront. The driveway is private and level. It takes two cars, including an adapted vehicle, and the front door is straight ahead when you park.\n\nInside there are two bedrooms and a double sofa bed in the conservatory, so up to five can stay. You can book from a single night, and we’ll set the bedroom up for you. We’ll send the address once your stay is confirmed.",
				),
				"It sits on a quiet residential street in Whitstable, about ten minutes from the seafront. The driveway is private and level. It takes two cars, including an adapted vehicle, and the front door is straight ahead when you park.\n\nInside there are two bedrooms and a double sofa bed in the conservatory, so up to five can stay. You can book from a single night, and we’ll set the bedroom up for you. We’ll send the address once your stay is confirmed.",
			),
			'home_faq_1_a' => array(
				array(
					'<p>No. It’s a private bungalow you rent as a holiday, so the whole house is yours and there are no staff on site. If you’d like home care while you’re here, our sister company, Continuity, can arrange it.</p>',
				),
				'<p>No, it’s a private bungalow you rent as a holiday. The whole house is yours, and there are no staff on site. If you’d like home care while you’re here, our sister company, Continuity, can arrange it.</p>',
			),
			'home_faq_2_a' => array(
				array(
					'<p>The bungalow is on one level and step-free throughout. The front door has a 965mm clear opening and the doors inside are 926mm. Every measurement is on the Accessibility page, including the ones that aren’t flattering, so you can check your own chair before you book.</p>',
				),
				'<p>The bungalow is on one level and step-free throughout. The front door has a 965mm clear opening and the doors inside are 926mm. Every measurement is on the Accessibility page, flattering or not, so you can check your own chair first.</p>',
			),
			'home_faq_3_a' => array(
				array(
					'<p>Yes. Continuity of Care Services can come in while you’re staying, and they’ll give you a quote once you’ve talked through what you need. Just mention it when you enquire, or ring us on 01622 809881.</p>',
				),
				'<p>Yes, Continuity of Care Services can come in while you’re staying. They’ll give you a quote once you’ve talked through what you need. Just mention it when you enquire, or ring us on 01622 809881.</p>',
			),
			'home_care_item2_body' => array(
				array(
					'Our sister company, Continuity of Care Services, can come into the bungalow while you’re here. They’re rated Good by the CQC, and because we share an office and a phone number, one call covers the house and the care.',
					'Our sister company, Continuity of Care Services, can come into the bungalow while you’re here. They’re rated Good by the CQC. We share an office and a phone number, so one call covers the house and the care.',
				),
				'Our sister company, Continuity of Care Services, can come into the bungalow while you’re here. They’re rated Good by the CQC. We share an office and a phone number, so one call covers the house and the care.',
			),
		),
		'the-property' => array(
			'prop_hero_heading' => array(
				array(
					'Inside the bungalow, room by room',
				),
				'Inside the accessible bungalow, room by room',
			),
			'prop_care_heading' => array(
				array(
					'Optional home care',
				),
				'Care in the bungalow, if you need it',
			),
			'prop_hero_subtitle' => array(
				array(
					'Here’s a walk round Restwell, room by room. It’s a single-storey adapted bungalow on a quiet street in Whitstable, with two bedrooms and space for up to five people.',
				),
				'Here’s a walk round Restwell, room by room. It’s a single-storey adapted bungalow on a quiet street in Whitstable. It has two bedrooms and space for up to five people.',
			),
			'prop_bedrooms_section_body' => array(
				array(
					"The accessible bedroom has a ceiling track hoist that covers the whole room, and we set it up with one or two profiling beds, depending on what you tell us when you book. If you’d like the furniture moved to match the way things are at home, just say, and it’ll be ready when you arrive.\n\nThe second bedroom next door has a double bed, and the conservatory has a double sofa bed, so up to five people can stay. The hoists, the standing aid and the profiling beds are all included in the price.",
				),
				"The accessible bedroom has a ceiling track hoist that covers the whole room. We set it up with one or two profiling beds, depending on what you tell us when you book.\n\nIf you’d like the furniture arranged like your room at home, just say, and we’ll have it ready.\n\nThe second bedroom next door has a double bed. The conservatory has a double sofa bed, so up to five people can stay. The hoists, the standing aid and the profiling beds are all included in the price.",
			),
			'prop_wetroom_body' => array(
				array(
					"The wet room is step-free from the door to the shower. It has grab rails, a shower stool and a tilt-in-space shower chair, a basin that swings round and moves up and down to the height you need, and a wash-and-dry toilet.\n\nIt’s all fitted already, so there’s nothing to hire or set up before you arrive. If you’d like the makes, models and safe working loads, you’ll find them on the Accessibility page.",
				),
				"The wet room is step-free from the door to the shower. It has grab rails, a shower stool and a tilt-in-space shower chair. There’s also a wash-and-dry toilet, and a basin that swings round and moves up and down.\n\nIt’s all fitted already, so there’s nothing to hire or set up before you arrive. You’ll find the makes, models and safe working loads on the Accessibility page.",
			),
			'prop_living_body' => array(
				array(
					"The living room is open-plan, with a rise-and-recline armchair, a sofa with pull-out footrests and a TV with Netflix. There’s room for wheelchairs, carers and family to get past each other.\n\nWe keep the floor between the sofa and the armchair clear so a wheelchair can turn. There’s free high-speed WiFi throughout, which matters more than people admit when someone needs to keep an eye on work or a hospital app.",
				),
				"The living room is open-plan, with a rise-and-recline armchair, a sofa with pull-out footrests and a TV with Netflix. There’s room for wheelchairs, carers and family to get past each other.\n\nWe keep the floor between the sofa and the armchair clear, so a wheelchair can turn. There’s free high-speed WiFi throughout. That matters more than people admit if you need to keep an eye on work or a hospital app.",
			),
			'prop_kitchen_body' => array(
				array(
					"The kitchen has a lowered worktop you can wheel under, an oven with a door that slides away underneath, a microwave, a fridge and a dishwasher. You’ll also find plates, pans, cutlery and the cooking basics.\n\nThe hob is gas rather than induction, which is worth knowing when you plan what to cook.",
				),
				"The kitchen has a lowered worktop you can wheel under, and an oven whose door slides away underneath. There’s also a microwave, a fridge and a dishwasher, plus plates, pans, cutlery and the cooking basics.\n\nThe hob is gas rather than induction, which is worth knowing when you plan what to cook.",
			),
			'prop_conservatory_body' => array(
				array(
					"The conservatory has a fold-out table to eat at and a double sofa bed, and its doors open out level onto the patio.\n\nThe laundry cupboards are in here too, with a washing machine and a tumble dryer.",
				),
				"The conservatory has a fold-out table to eat at and a double sofa bed. Its doors open out level onto the patio.\n\nThe laundry cupboards are in here too, with a washing machine and a tumble dryer.",
			),
			'prop_garden_body' => array(
				array(
					"French doors open onto a level patio, with a non-slip ramp over the threshold. The garden is fully enclosed, with outdoor seating, a barbecue and fairy lights.\n\nDogs are welcome, and we just ask you to let us know before you arrive so we can do a quick risk assessment.\n\nAt the front there’s a level, resin-bound driveway with space for two cars, and we’ve tested it with two wheelchair-accessible vehicles. Portable ramps are kept in the outdoor box by the front door, for use around the house or on days out.",
				),
				"French doors open onto a level patio, with a non-slip ramp over the threshold. The garden is fully enclosed, with outdoor seating, a barbecue and fairy lights.\n\nDogs are welcome. Please let us know before you arrive, so we can do a quick risk assessment.\n\nAt the front there’s a level, resin-bound driveway with space for two cars. We’ve tested it with two wheelchair-accessible vehicles. Portable ramps are kept in the outdoor box by the front door, for the house or for days out.",
			),
			'prop_location_body' => array(
				array(
					"The bungalow is on a quiet residential street, a short walk from The Plough pub and about ten minutes on foot from the seafront. Down there, the wide, paved promenade gives you a step-free route along the coast.\n\nThe beach is shingle, so the paved promenade is the step-free way along the seafront.",
				),
				"The bungalow is on a quiet residential street, a short walk from The Plough pub. The seafront is about ten minutes away on foot.\n\nThe beach there is shingle, but the wide, paved promenade gives you a step-free route along the coast.",
			),
			'prop_care_body' => array(
				array(
					'If someone in your group needs help with personal care, our sister company, Continuity, can come into the bungalow, and they’ll quote once you’ve talked through what’s needed. Plenty of guests bring their own carer instead, and the second bedroom is there for them.',
				),
				'If someone in your group needs help with personal care, our sister company, Continuity, can come into the bungalow. They’ll give you a quote once you’ve talked through what’s needed. Plenty of guests bring their own carer, and the second bedroom is there for them.',
			),
			'prop_cta_body' => array(
				array(
					'Tell us your dates, who’s coming and any access or equipment needs, and we’ll come back with availability and an honest answer on whether the house will work for you.',
				),
				'Tell us your dates, who’s coming and any access or equipment needs. We’ll come back with availability and an honest answer on whether the house will work for you.',
			),
		),
		'accessibility' => array(
			'meta_description' => array(
				array(
					'The full access statement: a 965mm front door, 926mm internal doors, a ceiling hoist rated to 180kg, a level wet room and a tilt-in-space shower chair.',
					'The access statement in full: a 965mm front door, 926mm inside, a ceiling hoist rated to 180kg, a height-adjustable basin and a tilt-in-space shower chair.',
				),
				'Exact access details: a 965mm front door, 926mm inside doors, and hoists rated to 180kg. There’s also a profiling bed and a level wet room.',
			),
			'acc_faq_heading' => array(
				array(
					'Access FAQ',
				),
				'Questions about access',
			),
			'acc_intro' => array(
				array(
					'This is the full access statement for Restwell, our single-storey adapted bungalow in Whitstable, so you can check it against your own needs before you book.',
					'This is the full access statement for Restwell, our single-storey adapted bungalow in Whitstable. Check it against your own needs before you book.',
				),
				'This is the full access statement for Restwell, our single-storey adapted bungalow in Whitstable. Check it against your own needs before you book.',
			),
			'acc_fit_note' => array(
				array(
					'This is a guide only. Aim for at least 50mm of clearance where you can, and we’re happy to talk your measurements through before you book.',
					'This is a guide only, so aim for at least 50mm of clearance where you can. We’re happy to talk your measurements through before you book.',
				),
				'This is a guide only, so aim for at least 50mm of clearance where you can. We’re happy to talk your measurements through before you book.',
			),
			'acc_dest_reality_body' => array(
				array(
					'Our Whitstable guide lists the routes, cafes and accessible toilets we know work, and we send the same notes in your welcome pack.',
					'Our Whitstable guide lists the routes, cafes and accessible toilets we know work. We send the same notes in your welcome pack.',
				),
				'Our Whitstable guide lists the routes, cafes and accessible toilets we know work. We send the same notes in your welcome pack.',
			),
			'acc_faq_1_a' => array(
				array(
					'No. Please bring the sling the person already uses. Both hoists take loop-style slings on a two-point spreader bar, and the note above the equipment register explains why we can’t supply one.',
					'No, please bring the sling the person already uses. Both hoists take loop-style slings on a two-point spreader bar. The note above the equipment register explains why we can’t supply one.',
				),
				'No, please bring the sling the person already uses. Both hoists take loop-style slings on a two-point spreader bar. The note above the equipment register explains why we can’t supply one.',
			),
			'acc_faq_2_a' => array(
				array(
					'It’s fixed to the ceiling and moves a person in a sling along a rail, so it takes up no floor space and needs no turning circle, unlike a mobile hoist, which has to be wheeled into place. Ours covers the whole of the accessible bedroom, and the details are in the equipment register above.',
					'It’s fixed to the ceiling and moves a person in a sling along a rail. Unlike a mobile hoist, it takes up no floor space and needs no turning circle. Ours covers the whole accessible bedroom, and its details are in the register above.',
				),
				'It’s fixed to the ceiling and moves a person in a sling along a rail. Unlike a mobile hoist, it takes up no floor space and needs no turning circle. Ours covers the whole accessible bedroom, and its details are in the register above.',
			),
			'acc_faq_3_a' => array(
				array(
					'It helps with positioning, pressure care and safer transfers, and it sets a working height that protects the back of whoever is giving care. A fixed divan gives you none of that, and a mobile hoist often can’t get its legs under one. We have two profiling beds, and the accessible bedroom takes one or both.',
					'It helps with positioning, pressure care and safer transfers, and it protects the carer’s back. A fixed divan gives you none of that, and a mobile hoist often can’t get under one. We have two profiling beds, and the accessible bedroom takes one or both.',
				),
				'It helps with positioning, pressure care and safer transfers, and it protects the carer’s back. A fixed divan gives you none of that, and a mobile hoist often can’t get under one. We have two profiling beds, and the accessible bedroom takes one or both.',
			),
			'acc_faq_4_a' => array(
				array(
					'It should mean published numbers you can check against your own chair and your own kit, like clear door openings, step-free routes, safe working loads and turning circles. If a listing says wheelchair friendly but won’t give you a measurement when you ask, that tells you what you need to know. Everything we have is on this page.',
					'It should mean published numbers you can check against your own chair and kit. Look for clear door openings, step-free routes, safe working loads and turning circles. If a listing says wheelchair friendly but can’t give you a measurement, that tells you enough.',
				),
				'It should mean published numbers you can check against your own chair and kit. Look for clear door openings, step-free routes, safe working loads and turning circles. If a listing says wheelchair friendly but can’t give you a measurement, that tells you enough.',
			),
			'acc_cta_body' => array(
				array(
					'If you’ve a question about door widths, hoist limits, the wet room or care, ask us and we’ll give you a clear answer.',
					'If you’ve a question about door widths, hoist limits, the wet room or care, just ask. We’ll give you a clear answer.',
				),
				'If you’ve a question about door widths, hoist limits, the wet room or care, just ask. We’ll give you a clear answer.',
			),
		),
		'who-its-for' => array(
			'wif_intro' => array(
				array(
					'Restwell is built for disabled adults, their families and the people who care for them, in groups of up to five. It’s a holiday let you have to yourselves, not a care home or a respite centre.',
				),
				'Restwell is a private holiday home for disabled adults, their families and friends. Wheelchair users, people with learning disabilities, and guests with or without a PA are all welcome. It sleeps five, and it isn’t a care home or respite centre.',
			),
			'wif_ot_detail_bullets' => array(
				array(
					'You’re welcome to talk a referral through with us before anyone commits to a booking.',
					'You’re welcome to talk a referral through with us before anyone books.',
				),
				'You’re welcome to talk a referral through with us before anyone books.',
			),
			'wif_commissioners_detail_bullets' => array(
				array(
					"A short break in a private adapted house can be part of a care and support plan under the Care Act 2014.\nWe can send you the house details, the measurements and Continuity’s CQC rating.\nWe can work with direct payments, personal health budgets and CHC funding.",
					"A care and support plan under the Care Act 2014 can include a short break in an adapted house.\nWe can send you the house details, the measurements and Continuity’s CQC rating.\nWe can work with direct payments, personal health budgets and CHC funding.",
				),
				"A care and support plan under the Care Act 2014 can include a short break in an adapted house.\nWe can send you the house details, the measurements and Continuity’s CQC rating.\nWe can work with direct payments, personal health budgets and CHC funding.",
			),
			'wif_fund_phb_bullets' => array(
				array(
					"For people found eligible for NHS Continuing Healthcare.\nYour ICB or continuing healthcare team handles the application.\nA stay in a private adapted house can be written into the plan where it meets the person’s needs.",
					"For people who qualify for NHS Continuing Healthcare.\nYour ICB or CHC team deals with the forms.\nA stay in a private adapted house can be written into the plan where it meets the person’s needs.",
				),
				"For people who qualify for NHS Continuing Healthcare.\nYour ICB or CHC team deals with the forms.\nA stay in a private adapted house can be written into the plan where it meets the person’s needs.",
			),
			'wif_fund_private_bullets' => array(
				array(
					"You get the same access information and straight answers as funded guests.\nWe can send paperwork for your insurer or employer if you need it.\nWe’ll tell you plainly if the bungalow isn’t the right fit.",
					"You get the same access details and straight answers as funded guests.\nWe can send paperwork for your insurer or employer if you need it.\nWe’ll tell you plainly if the bungalow isn’t the right fit.",
				),
				"You get the same access details and straight answers as funded guests.\nWe can send paperwork for your insurer or employer if you need it.\nWe’ll tell you plainly if the bungalow isn’t the right fit.",
			),
		),
		'optional-care' => array(
			'meta_title' => array(
				array(
					'Home care in the bungalow, if you’d like it',
				),
				'A holiday with care provided in Whitstable, if you want it',
			),
			'care_faq_heading' => array(
				array(
					'Optional care FAQ',
				),
				'Questions about care',
			),
			'care_faq_2_a' => array(
				array(
					'No. Restwell is a private holiday bungalow. Continuity of Care Services, our sister company, is the CQC-registered provider if you’d like professional care during your stay.',
				),
				'No. Restwell is a private holiday home, not a care service. Any care during your stay comes from our sister company, Continuity of Care Services, which is registered with the CQC.',
			),
			'care_faq_5_a' => array(
				array(
					'On Pricing & dates. They’re Continuity’s guide rates, and Continuity give you a quote once the hours and tasks are agreed.',
				),
				'You’ll find them on the Pricing page. Continuity will give you a quote once the hours and tasks are agreed.',
			),
			'care_pro_lede' => array(
				array(
					'Door widths and equipment are published, and Continuity confirm the care plan and the cost once the hours and tasks are agreed.',
				),
				'Door widths and equipment are all published. Continuity confirm the care plan and the cost once the hours and tasks are agreed.',
			),
			'care_day_1_body' => array(
				array(
					'Help getting up, washed and dressed at the time you’d get up at home. The shower chair is already in the wet room.',
				),
				'Someone can help you get up, washed and dressed at the time you’d get up at home. The shower chair is already in the wet room.',
			),
			'care_day_2_body' => array(
				array(
					'Someone to come along the promenade or into town, or a few hours of cover so the usual carer can have some time off.',
				),
				'Someone can come with you along the promenade or into town. They can also cover a few hours, so you and your usual carer get time to yourselves.',
			),
			'care_day_3_body' => array(
				array(
					'A sleep-in, or a waking night if someone needs help during the night, so the person who usually cares can get some sleep.',
				),
				'A carer can sleep in, or stay awake if you need help during the night. That way, everyone gets a proper night’s sleep.',
			),
			'care_own_lede' => array(
				array(
					'Plenty of guests do. They can have the second double bedroom or the sofa bed in the conservatory, use the hoist and shower chair, and park on the drive.',
					'Plenty of guests do. They can have the second double bedroom or the conservatory sofa bed. They can use the hoist and shower chair, and park on the drive.',
				),
				'Plenty of guests do. They can have the second double bedroom or the conservatory sofa bed. They can use the hoist and shower chair, and park on the drive.',
			),
		),
		'our-story' => array(
			'story_companies_note' => array(
				array(
					'Restwell is not a registered care provider. Continuity of Care Services is.',
				),
				'Restwell is not a registered care provider, but Continuity of Care Services is.',
			),
			'story_companies_2_body' => array(
				array(
					'Home care during your stay is optional, and always from Continuity’s own team.',
				),
				'Care while you stay is up to you. If you want it, it comes from Continuity’s own team.',
			),
			'story_month_lede' => array(
				array(
					'Family, friends and three specialist teams brought it together in a month. Before anyone stayed, occupational therapists from Kent Community Health NHS Trust checked the bedroom and wet room.',
				),
				'Family, friends and three teams of experts got it ready in a month. Before anyone stayed, occupational therapists from Kent Community Health NHS Trust checked the bedroom and wet room.',
			),
			'story_next_lede' => array(
				array(
					'We publish every measurement. We say what the house can’t do as clearly as what it can. You can arrange a week away, and the support to enjoy it, in one conversation. Nobody should have to explain their situation four times to four different people.',
				),
				'We publish every measurement. We say what the house can’t do as clearly as what it can. You can plan a week away, and the support to enjoy it, in one call. Nobody should have to explain their needs four times to four different people.',
			),
			'story_origin_body' => array(
				array(
					'Somebody would travel for three hours, only to find a doorway they couldn’t get through. So we bought a bungalow in Whitstable that needed a lot of work, and we adapted it properly. Then we measured everything and published the details, flattering or not. Guests can check the bungalow will work for them before they set off. They can arrange optional care through the same office.',
				),
				'People would travel three hours, only to find a door they couldn’t get through. So we bought a bungalow in Whitstable, adapted it properly and published every measurement. Now guests can check the fit first, and ask about care through the same office.',
			),
			'story_companies_1_body' => array(
				array(
					'The bungalow is a private adapted house in Whitstable. It isn’t a care home or a respite centre.',
					'It’s a private holiday home in Whitstable, not a care home or a respite centre.',
				),
				'It’s a private holiday home in Whitstable, not a care home or a respite centre.',
			),
			'story_specialists_lede' => array(
				array(
					'Every measurement is on the Accessibility page, flattering or not. Compare the door widths, spaces and limits with your own chair or hoist before you book. If you’re unsure, please ask.',
					'Every measurement is on the Accessibility page, good or bad. Check the doors and spaces against your own chair or hoist before you book. If you’re not sure, just ask.',
				),
				'Every measurement is on the Accessibility page, good or bad. Check the doors and spaces against your own chair or hoist before you book. If you’re not sure, just ask.',
			),
			'story_cta_body' => array(
				array(
					'You can check door widths, hoist details, and photographs of each room before you contact us. Compare them with what you need, and ask about anything that isn’t clear.',
					'You can check door widths, hoist details and photos of each room before you get in touch. Compare them with what you need, and ask about anything that isn’t clear.',
				),
				'You can check door widths, hoist details and photos of each room before you get in touch. Compare them with what you need, and ask about anything that isn’t clear.',
			),
		),
		'funding-and-support' => array(
			'meta_title' => array(
				array(
					'Funding an accessible holiday | Restwell Retreats',
					'Funding an accessible holiday',
					'Funding an accessible holiday, and who we invoice',
				),
				'Funding and grants for a disabled holiday',
			),
			'meta_description' => array(
				array(
					'How a break at Restwell can be paid for: direct payments, NHS Continuing Healthcare, charity grants or paying yourself, and the paperwork we can send.',
					'We can invoice you, a council, the NHS or a grant body, and the bungalow rate is the same either way. What we can’t do is promise your package will cover it.',
				),
				'Holiday grants for disabled adults and carers, plus council and NHS funding. Here’s what each covers, and the paperwork we can send your funder.',
			),
			'res_heading' => array(
				array(
					'Funding an accessible holiday',
				),
				'Grants and funding for your accessible holiday',
			),
			'res_complaints_body' => array(
				array(
					'You can ask for a review. For a council decision, go to your council first (Kent County Council if they funded the assessment), then the Local Government Ombudsman. For NHS CHC, follow the ICB appeals process, then the Parliamentary and Health Service Ombudsman. Scope and Beacon can advise either way, and we’re happy to resend the paperwork.',
				),
				'You can ask for a review, and Scope and Beacon can advise. For a council decision, ask your council first, then the Local Government and Social Care Ombudsman. For NHS Continuing Healthcare, use your ICB’s appeals process, then the Parliamentary and Health Service Ombudsman.',
			),
			'res_cta_body' => array(
				array(
					'We’ll reply with a bungalow quote at the published rates, the access statement, and Continuity care on the same thread if you asked for it. Just let us know the dates.',
					'We’ll reply with a bungalow quote at the published rates and the access statement. If you asked about care, Continuity’s quote comes on the same thread. Just let us know the dates.',
				),
				'We’ll reply with a bungalow quote at the published rates and the access statement. If you asked about care, Continuity’s quote comes on the same thread. Just let us know the dates.',
			),
		),
		'whitstable-area-guide' => array(
			'meta_title' => array(
				array(
					'Accessible days out in Whitstable and Tankerton',
				),
				'Is Whitstable wheelchair friendly? A local access guide',
			),
			'meta_description' => array(
				array(
					'Which bits of Whitstable work in a wheelchair: Tankerton promenade is level, the harbour beach is shingle, and we name the venues with an accessible loo.',
				),
				'In parts, and we’ll tell you which. Tankerton’s promenade is level, the harbour is step-free with a Changing Places toilet, and the main beach is shingle.',
			),
			'wg_heading' => array(
				array(
					'Accessible days out in Whitstable and Tankerton',
				),
				'Is Whitstable wheelchair friendly?',
			),
			'wg_intro' => array(
				array(
					'What we know about getting around Whitstable and Tankerton: the level routes, the ones that aren’t, and where to eat.',
				),
				'Parts of it are. Tankerton’s promenade and the harbour are level and step-free, but the beach is shingle and some older streets are uneven. Here are the routes we know well, and where to eat.',
			),
			'wg_cta_body' => array(
				array(
					'Tell us your chair size and how far you like to go in a day, and we’ll point you to the routes that suit.',
					'Tell us your chair size and how far you like to go in a day. We’ll point you to the routes that suit.',
				),
				'Tell us your chair size and how far you like to go in a day. We’ll point you to the routes that suit.',
			),
		),
		'blog' => array(
			'meta_title' => array(
				array(
					'Accessible travel notes from one bungalow',
				),
				'Accessible travel guides from a Whitstable bungalow',
			),
		),
		'how-it-works' => array(
			'hiw_intro' => array(
				array(
					'There’s no online checkout. You tell us your dates and what you need, we check the house will work for you, and only then do you pay a deposit.',
					'There’s no online checkout. You tell us your dates and what you need, and we check the house will work for you. Only then do you pay a deposit.',
				),
				'There’s no online checkout. You tell us your dates and what you need, and we check the house will work for you. Only then do you pay a deposit.',
			),
			'hiw_step1_body' => array(
				array(
					'Send us your dates, who’s coming and anything that would help the house work for you, like how you’d like the bedroom set up. We aim to reply within 48 hours, and there’s nothing to pay at this stage.',
					'Send us your dates, who’s coming and anything that would help the house work for you. That could be how you’d like the bedroom set up. We aim to reply within 48 hours, and there’s nothing to pay at this stage.',
				),
				'Send us your dates, who’s coming and anything that would help the house work for you. That could be how you’d like the bedroom set up. We aim to reply within 48 hours, and there’s nothing to pay at this stage.',
			),
			'hiw_step2_body' => array(
				array(
					'Once we’ve agreed the house fits, a 50% deposit holds your dates and the rest is due a week before you arrive. In the meantime, we set the furniture and equipment up around what you’ve told us.',
					'Once we’ve agreed the house fits, a 50% deposit holds your dates. The rest is due a week before you arrive. In the meantime, we set the furniture and equipment up around what you’ve told us.',
				),
				'Once we’ve agreed the house fits, a 50% deposit holds your dates. The rest is due a week before you arrive. In the meantime, we set the furniture and equipment up around what you’ve told us.',
			),
			'hiw_faq_3_a' => array(
				array(
					'You can pay by bank transfer or card, and we can also invoice a council, the NHS or a grant body directly. The deposit and balance are set out on <a href="/pricing/#payment">Prices and dates</a>, and <a href="/funding-and-support/">Funding and support</a> explains the paperwork.',
					'You can pay by bank transfer or card. We can also invoice a council, the NHS or a grant body directly. The deposit and balance are set out on <a href="/pricing/#payment">Prices and dates</a>, and <a href="/funding-and-support/">Funding and support</a> explains the paperwork.',
				),
				'You can pay by bank transfer or card. We can also invoice a council, the NHS or a grant body directly. The deposit and balance are set out on <a href="/pricing/#payment">Prices and dates</a>, and <a href="/funding-and-support/">Funding and support</a> explains the paperwork.',
			),
			'hiw_faq_4_a' => array(
				array(
					'Yes, and funded bookings are very welcome. A funder can confirm the booking with a purchase order, and the deposit and balance follow the same timings as any other stay.',
					'Yes, and funded bookings are very welcome. A funder can confirm the booking with a purchase order. The deposit and balance follow the same timings as any other stay.',
				),
				'Yes, and funded bookings are very welcome. A funder can confirm the booking with a purchase order. The deposit and balance follow the same timings as any other stay.',
			),
		),
		'pricing' => array(
			'pricing_payment_intro' => array(
				array(
					'You can pay by bank transfer or card. If a council, the NHS or a charity is paying, the price is the same, and Funding & Support explains how the invoice works.',
					'You can pay by bank transfer or card. If a council, the NHS or a charity is paying, the price is the same. Funding & Support explains how the invoice works.',
				),
				'You can pay by bank transfer or card. If a council, the NHS or a charity is paying, the price is the same. Funding & Support explains how the invoice works.',
			),
			'pricing_faq_1_a' => array(
				array(
					'No. The bungalow price covers the house and the access equipment that’s already there. Care from Continuity is optional, and they’ll give you a quote once you’ve talked through what you need. Their guide rates are above.',
				),
				'No, the bungalow price covers the house and the access equipment that’s already there. Care from Continuity is optional, and they’ll give you a quote once you’ve talked through what you need. Their guide rates are above.',
			),
			'pricing_faq_2_a' => array(
				array(
					'The hoists, the profiling beds and the wet room equipment are all included. If you need something specialist that isn’t on our list, there’s a charge to hire it, so let us know when you enquire. Please bring your own slings, because a sling needs to fit the person using it.',
				),
				'The hoists, the profiling beds and the wet room equipment are all included. Anything specialist that isn’t on our list costs extra to hire, so tell us when you enquire. Please bring your own slings, because a sling needs to fit the person using it.',
			),
		),
		'faq' => array(
			'faq_1_a' => array(
				array(
					'No. Restwell is a private bungalow that you rent as a holiday, so the house is yours and there are no staff on site. If you’d like home care while you’re here, our sister company, Continuity of Care Services, can provide it. Your funder may call the break respite on their paperwork, and that’s fine.',
				),
				'No, Restwell is a private bungalow that you rent as a holiday, with no staff on site. If you’d like home care, our sister company, Continuity of Care Services, can provide it. Your funder may call the break respite on their paperwork, and that’s fine.',
			),
			'faq_2_a' => array(
				array(
					'Yes. The minimum stay is one night, so you can book anything from a single night to a full week or more. The nightly and weekly rates are on <a href="/pricing/">Prices and dates</a>.',
				),
				'Yes, the minimum stay is one night. You can book anything from a single night to a full week or more. The nightly and weekly rates are on <a href="/pricing/">Prices and dates</a>.',
			),
			'faq_3_a' => array(
				array(
					'The bungalow is all on one level and step-free throughout. The front door has a 965mm clear opening and the doors inside are 926mm, so you can check those against your own chair. If you need a measurement we haven’t published, ask and we’ll go and measure it. Every figure is in the <a href="/accessibility/">access statement</a>.',
				),
				'The bungalow is all on one level and step-free throughout. The front door has a 965mm clear opening, and the doors inside are 926mm. Every figure is in the <a href="/accessibility/">access statement</a>, and we’ll measure anything that isn’t.',
			),
			'faq_4_a' => array(
				array(
					'Yes. There’s a ceiling track hoist that covers the whole of the main bedroom, and a mobile hoist you can use in any room. Both have a safe working load of 180kg and are examined under LOLER every six months. Please bring your own slings, because a sling needs to fit the person using it.',
				),
				'Yes, a ceiling track hoist covers the main bedroom, and a mobile hoist works in any room. Both are rated to 180kg and examined under LOLER every six months. Please bring your own slings, because a sling needs to fit the person using it.',
			),
			'faq_5_a' => array(
				array(
					'Yes. We have two profiling beds, and we set the accessible bedroom up with one or both, depending on who needs them. Tell us when you book and it’ll be ready when you arrive.',
				),
				'Yes, we have two profiling beds. We set the accessible bedroom up with one or both, depending on who needs them. Tell us when you book and it’ll be ready when you arrive.',
			),
			'faq_7_a' => array(
				array(
					'Yes. Continuity of Care Services, our sister company, can come into the bungalow during your stay, from a morning visit to nurse-led support. Mention it on the same enquiry as the house, and Continuity will give you a quote once you’ve talked through what you need. There’s more on the <a href="/optional-care/">Optional care</a> page.',
				),
				'Yes, our sister company, Continuity of Care Services, can come in during your stay, from morning visits to nurse-led support. Mention it on your enquiry, and they’ll quote once you’ve talked it through. There’s more on the <a href="/optional-care/">Optional care</a> page.',
			),
			'faq_8_a' => array(
				array(
					'The sooner you ask, the more likely it is that we can say yes. We don’t publish a lead time, because it depends on what you need and who’s free that week. We’d rather give you a real answer quickly than a number we’ve made up.',
				),
				'The sooner you ask, the more likely we can say yes. We don’t publish a lead time, because it depends on what you need and who’s free that week. We’d rather give you a real answer quickly than a number we’ve made up.',
			),
			'faq_10_a' => array(
				array(
					'It’s about ten minutes on foot from the driveway to the seafront. Places along Tankerton promenade take a bit longer, because you head down to the sea first and then west along the prom. JoJo’s is about twenty minutes in all. The <a href="/whitstable-area-guide/">Whitstable guide</a> has the step-free routes.',
				),
				'It’s about ten minutes on foot from the driveway to the seafront. Tankerton promenade takes longer: JoJo’s is about twenty minutes, as you head down to the sea and then west. The <a href="/whitstable-area-guide/">Whitstable guide</a> has the step-free routes.',
			),
			'faq_11_a' => array(
				array(
					'A week is £1,300 off-peak and £1,400 in peak season, and the access equipment, linen, towels and parking are all included. A 50% deposit holds your dates and the rest is due a week before you arrive. Every rate is on <a href="/pricing/">Prices and dates</a>.',
				),
				'A week is £1,300 off-peak and £1,400 in peak season, with the access equipment, linen, towels and parking included. A 50% deposit holds your dates and the rest is due a week before you arrive. Every rate is on <a href="/pricing/">Prices and dates</a>.',
			),
			'faq_12_a' => array(
				array(
					'We can invoice you, a local authority, the NHS or a grant body. What we can’t do is promise that your care package will cover a holiday, because that decision sits with your social worker or case manager. <a href="/funding-and-support/">Funding and support</a> explains how it usually works.',
				),
				'We can invoice you, a local authority, the NHS or a grant body. We can’t promise your care package will cover a holiday, because that’s for your social worker or case manager. <a href="/funding-and-support/">Funding and support</a> explains how it usually works.',
			),
			'faq_13_a' => array(
				array(
					'Sometimes. A direct payment has to meet the needs in your care and support plan. That usually means care while you’re away, like a PA’s hours. Some councils also cover a PA’s travel and room. Whether it can go towards the stay itself is up to your council, so ask your social worker before you book. Our <a href="/direct-payment-holiday-accommodation/">guide to direct payments</a> explains more.',
				),
				'Sometimes, if it meets the needs in your care and support plan, such as a PA’s hours while you’re away. Whether it covers the stay itself is up to your council, so ask your social worker first. Our <a href="/direct-payment-holiday-accommodation/">guide to direct payments</a> explains more.',
			),
			'faq_15_a' => array(
				array(
					'Check-in is from 3pm, using a key safe, and we send you the code beforehand. Check-out is by 11am. If you need longer for personal care or transport, let us know a few days ahead and we’ll do our best. <a href="/how-it-works/">How it works</a> covers arrival day in full.',
				),
				'Check-in is from 3pm, check-out is by 11am, and we send the key safe code beforehand. If you need longer for personal care or transport, let us know a few days ahead. <a href="/how-it-works/">How it works</a> covers arrival day in full.',
			),
		),
		'enquire' => array(
			'enq_intro' => array(
				array(
					'Tell us your dates and what you need from the house, and ask about care on the same form if you’d like it. We aim to reply within 48 hours, and there’s no deposit to pay until we’ve talked it through and you’re sure it fits.',
					'Tell us your dates and what you need from the house. You can ask about care on the same form, too. We aim to reply within 48 hours, and there’s no deposit until you’re sure it fits.',
				),
				'Tell us your dates and what you need from the house. You can ask about care on the same form, too. We aim to reply within 48 hours, and there’s no deposit until you’re sure it fits.',
			),
		),
	);
	foreach ( $changes as $slug => $fields ) {
		foreach ( $fields as $key => $change ) {
			foreach ( $change[0] as $old ) {
				restwell_replace_stale_page_copy( array( $slug => array( $key => array( $old, $change[1] ) ) ) );
			}
		}
	}

	// The blog index lede is the posts page's excerpt.
	$blog_id = (int) get_option( 'page_for_posts', 0 );
	if ( $blog_id > 0 ) {
		$excerpt = trim( str_replace( array( "\r\n", "\r" ), "\n", (string) get_post_field( 'post_excerpt', $blog_id ) ) );
		$old     = array(
			'Guides about accessible travel written from one adapted bungalow in Whitstable: the Kent coast in a wheelchair, how funding for a break usually works, and how to read an access statement so a listing can’t catch you out.',
			'Our guides are written from one adapted bungalow in Whitstable. They cover days out on the Kent coast, how to pay for a break, and how to check an access statement before you book.',
		);
		if ( in_array( $excerpt, $old, true ) ) {
			wp_update_post(
				array(
					'ID'           => $blog_id,
					'post_excerpt' => wp_slash( 'Our guides are written from one adapted bungalow in Whitstable. They cover Kent coast days out, paying for a break, and checking an access statement.' ),
				)
			);
		}
	}
}

/**
 * Batch B SEO pass (23 Oct 2026): each main page's intro now carries its
 * blueprint keyword in plain words, and the admin focus keyphrases match the
 * blueprint primaries (docs/seo-blueprint-2026-10-22.md, section 1). As in
 * v99, a stored value is replaced only while it equals the old one.
 */
function restwell_migrate_page_seo_batch_b_v100() {
	if ( get_option( 'restwell_page_seo_batch_b_v100', '' ) === '1' ) {
		return;
	}
	update_option( 'restwell_page_seo_batch_b_v100', '1', false );
	$changes = array(
		'home' => array(
			'hero_subheading' => array( 'A private, single-storey bungalow a short walk from the sea. The level wet room and ceiling track hoist are already fitted. Home care from our sister company is there if you’d like it.', 'A private, single-storey bungalow in Kent, a short walk from the sea. The level wet room and ceiling track hoist are already fitted. Home care from our sister company is there if you’d like it.' ),
			'focus_keyphrase' => array( 'accessible holiday cottages by the sea', 'accessible holiday cottages kent' ),
		),
		'the-property' => array(
			'prop_hero_subtitle' => array( 'Here’s a walk round Restwell, room by room. It’s a single-storey adapted bungalow on a quiet street in Whitstable. It has two bedrooms and space for up to five people.', 'Here’s a walk round Restwell, room by room. It’s a single-storey accessible holiday bungalow on a quiet street in Whitstable. It has two bedrooms and space for up to five people.' ),
		),
		'accessibility' => array(
			'acc_intro' => array( 'This is the full access statement for Restwell, our single-storey adapted bungalow in Whitstable. Check it against your own needs before you book.', 'This is the full access statement for Restwell, our adapted holiday bungalow in Whitstable with a wet room and hoists. Check it against your own needs before you book.' ),
			'focus_keyphrase' => array( 'disabled holiday cottages with wet room', 'disabled holiday cottage with wet room and hoists' ),
		),
		'who-its-for' => array(
			'wif_intro' => array( 'Restwell is a private holiday home for disabled adults, their families and friends. Wheelchair users, people with learning disabilities, and guests with or without a PA are all welcome. It sleeps five, and it isn’t a care home or respite centre.', 'Restwell is a private holiday home for disabled adults, their carers, families and friends. Wheelchair users, people with learning disabilities, and guests with or without a PA are all welcome. It sleeps five, and it isn’t a care home or respite centre.' ),
		),
		'optional-care' => array(
			'care_intro' => array( 'Our sister company, Continuity of Care Services, can come in while you’re here if you ask. Tell us what you need and we’ll check who’s free.', 'If you’d like a holiday with care provided, our sister company, Continuity of Care Services, can come in while you’re here. Tell us what you need and we’ll check who’s free.' ),
			'focus_keyphrase' => array( 'adding home care during a self-catering stay', 'holidays with care provided' ),
		),
		'how-it-works' => array(
			'focus_keyphrase' => array( 'how a restwell stay is booked', 'how to book a stay at restwell' ),
		),
		'our-story' => array(
			'focus_keyphrase' => array( 'restwell our story', 'restwell retreats' ),
		),
		'funding-and-support' => array(
			'focus_keyphrase' => array( 'funding an accessible holiday', 'funding and grants for disabled holidays' ),
		),
		'pricing' => array(
			'focus_keyphrase' => array( 'accessible holiday prices', 'restwell retreats prices' ),
		),
		'enquire' => array(
			'focus_keyphrase' => array( 'contact restwell', 'contact restwell retreats' ),
		),
		'whitstable-area-guide' => array(
			'focus_keyphrase' => array( 'whitstable accessible days out', 'is whitstable wheelchair friendly' ),
		),
		'blog' => array(
			'focus_keyphrase' => array( 'accessible travel', 'accessible travel guides' ),
		),
	);
	restwell_replace_stale_page_copy( $changes );
}

/**
 * Batch C (23 Oct 2026): the three legal pages in plain English, with the SEO
 * blueprint's titles, metas and H1s (docs/seo-blueprint-2026-10-22.md). The
 * bodies live in inc/theme-setup/legal-content.php; a stored copy is dropped
 * only while it is still built from our September wording, as v55 and v64 did,
 * so the new text shows. Other fields move only while they hold the shipped
 * value, so anything edited in wp-admin is kept.
 */
function restwell_migrate_legal_plain_english_v101() {
	if ( get_option( 'restwell_legal_plain_english_v101', '' ) === '1' ) {
		return;
	}
	update_option( 'restwell_legal_plain_english_v101', '1', false );

	$bodies = array(
		'privacy-policy'       => array( 'The data controller for personal information collected through this site is', 'That means we decide how your information is used' ),
		'terms-and-conditions' => array( 'These terms apply when you book the adapted self-catering bungalow', 'In these terms, “we” and “us” mean' ),
		'accessibility-policy' => array( 'Our accessibility target is the Web Content Accessibility Guidelines', 'What you can do on this site' ),
	);
	foreach ( $bodies as $slug => $markers ) {
		$page = get_page_by_path( $slug, OBJECT, 'page' );
		if ( ! $page instanceof WP_Post ) {
			continue;
		}
		$html = (string) get_post_meta( $page->ID, 'legal_body_html', true );
		if ( '' !== trim( $html ) && false !== strpos( $html, $markers[0] ) && false === strpos( $html, $markers[1] ) ) {
			delete_post_meta( $page->ID, 'legal_body_html' );
		}
	}

	restwell_replace_stale_page_copy(
		array(
			'privacy-policy'       => array(
				'legal_heading'    => array( 'Privacy Policy', 'Privacy policy: how we look after your details' ),
				'legal_intro'      => array(
					'Who is responsible for your data, what we collect on enquiry, FAQ, booking and guest-guide records (including optional care notes), cookie choices, who we share data with, how long we keep records, and your UK GDPR rights (including contacting the ICO).',
					'This explains what we collect when you contact us or book, and how long we keep it. It also sets out your rights under UK GDPR, including how to complain.',
				),
				'meta_title'       => array( 'Privacy Policy for Restwell Guests', 'Restwell Retreats privacy policy' ),
				'meta_description' => array(
					'Restwell privacy policy: what we collect on forms and bookings, cookies, retention periods, your rights under UK GDPR, and how to request changes or deletion.',
					'What we collect when you enquire or book, and how long we keep it. We also cover cookies and your rights under UK GDPR.',
				),
				'focus_keyphrase'  => array( 'restwell privacy', 'restwell retreats privacy policy' ),
			),
			'terms-and-conditions' => array(
				'legal_heading'    => array( 'Terms & Conditions', 'Terms and conditions for booking a stay' ),
				'legal_intro'      => array(
					'Booking confirmation, payment, cancellation terms, accessibility and exceptional circumstances, house rules, optional care via Continuity of Care Services, liability, and how we handle personal data and cookies.',
					'These are the terms for booking the bungalow. They cover payment, cancelling, changing dates, the house rules and optional care.',
				),
				'meta_title'       => array( 'Restwell Terms: Booking & Payment Rules', 'Restwell Retreats booking terms and conditions' ),
				'meta_description' => array(
					'Restwell terms for bookings: deposits, cancellations, guest responsibilities, how we rely on published access details, and how disputes are handled in the UK.',
					'The terms for booking the bungalow: deposits, cancelling and changing dates. They also cover guest numbers, the access kit and what happens if we cancel.',
				),
				'focus_keyphrase'  => array( 'restwell terms', 'restwell retreats terms and conditions' ),
			),
			'accessibility-policy' => array(
				'legal_heading'    => array( 'Website accessibility statement', 'Accessibility statement for this website' ),
				'legal_intro'      => array(
					'WCAG-oriented testing, known limits of third-party embeds, and how to request alternative formats or report a barrier.',
					'This statement covers how well this website works for disabled visitors. It also says what isn’t right yet, and how to tell us about a problem.',
				),
				'meta_title'       => array( 'Website Accessibility Statement', 'Restwell Retreats website accessibility statement' ),
				'meta_description' => array(
					'Restwell website accessibility statement: WCAG approach, how we test, third-party limits, known gaps, and how to request information in another format.',
					'How we build and test this website against WCAG 2.2 AA, and the gaps we know about. Ask for any page in a format that suits you.',
				),
				'focus_keyphrase'  => array( 'restwell website accessibility', 'restwell retreats website accessibility statement' ),
			),
		)
	);
}

/**
 * Catch-up (23 Oct 2026). The October migrations each swap a field only while
 * it holds the exact wording they expect, so a site whose fields came from an
 * older seed, a different route through the migrations or a pasted brief can
 * be left showing September copy. A rehearsal on a September database left 74
 * fields behind. This brings every page field to the current seed while its
 * stored text is any wording the theme has ever shipped (seed-history.php);
 * text typed in wp-admin matches no fingerprint and is kept. Photos and their
 * captions and alt text are left alone so they keep matching each other.
 */
function restwell_migrate_seed_catch_up_v102() {
	if ( get_option( 'restwell_seed_catch_up_v102', '' ) === '1' ) {
		return;
	}
	update_option( 'restwell_seed_catch_up_v102', '1', false );

	$history = require __DIR__ . '/seed-history.php';
	if ( ! is_array( $history ) ) {
		return;
	}
	$fingerprint = static function ( $text ) {
		return substr( md5( trim( str_replace( array( "\r\n", "\r" ), "\n", (string) $text ) ) ), 0, 16 );
	};
	$is_ours     = static function ( $key, $stored, $target ) use ( $history, $fingerprint ) {
		return $fingerprint( $stored ) === $fingerprint( $target )
			|| ( isset( $history[ $key ] ) && in_array( $fingerprint( $stored ), $history[ $key ], true ) );
	};
	$catch_up    = static function ( $page_id, array $targets ) use ( $history, $fingerprint, $is_ours ) {
		foreach ( $targets as $key => $target ) {
			if ( ! is_string( $target ) || ! isset( $history[ $key ] ) || ! metadata_exists( 'post', $page_id, $key ) ) {
				continue;
			}
			$stored = (string) get_post_meta( $page_id, $key, true );
			if ( '' === trim( $stored ) || $fingerprint( $stored ) === $fingerprint( $target ) || ! $is_ours( $key, $stored, $target ) ) {
				continue;
			}
			// A question and its answer move together: if either was edited by
			// hand, leave both, so an answer never sits under the wrong question.
			if ( preg_match( '/^(.+_\d+)_(q|a)$/', $key, $m ) ) {
				$partner = $m[1] . '_' . ( 'q' === $m[2] ? 'a' : 'q' );
				$theirs  = (string) get_post_meta( $page_id, $partner, true );
				if ( isset( $targets[ $partner ] ) && '' !== trim( $theirs ) && ! $is_ours( $partner, $theirs, (string) $targets[ $partner ] ) ) {
					continue;
				}
			}
			update_post_meta( $page_id, $key, wp_slash( $target ) );
		}
	};

	// Page fields: the current seed for each template.
	$templates = array(
		'template-property.php'             => 'restwell_get_property_page_defaults',
		'template-how-it-works.php'         => 'restwell_get_how_it_works_page_defaults',
		'template-accessibility.php'        => 'restwell_get_accessibility_page_defaults',
		'template-who-its-for.php'          => 'restwell_get_who_its_for_page_defaults',
		'template-whitstable-guide.php'     => 'restwell_get_whitstable_guide_page_defaults',
		'template-faq.php'                  => 'restwell_get_faq_page_defaults',
		'template-enquire.php'              => 'restwell_get_enquire_page_defaults',
		'template-pricing.php'              => 'restwell_get_pricing_page_defaults',
		'template-resources.php'            => 'restwell_get_resources_page_defaults',
		'template-our-story.php'            => 'restwell_get_our_story_page_defaults',
		'template-care.php'                 => 'restwell_get_care_page_defaults',
		'template-privacy-policy.php'       => 'restwell_get_privacy_policy_page_defaults',
		'template-terms-and-conditions.php' => 'restwell_get_terms_conditions_page_defaults',
		'template-accessibility-policy.php' => 'restwell_get_accessibility_policy_page_defaults',
	);
	foreach ( $templates as $template => $defaults_fn ) {
		if ( ! function_exists( $defaults_fn ) ) {
			continue;
		}
		$ids = get_posts(
			array(
				'post_type'      => 'page',
				'post_status'    => array( 'publish', 'draft', 'private' ),
				'meta_key'       => '_wp_page_template', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				'meta_value'     => $template, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
				'posts_per_page' => -1,
				'fields'         => 'ids',
			)
		);
		foreach ( $ids as $page_id ) {
			$catch_up( (int) $page_id, (array) call_user_func( $defaults_fn ) );
		}
	}
	$front = (int) get_option( 'page_on_front', 0 );
	if ( $front > 0 && function_exists( 'restwell_get_theme_setup_defaults' ) ) {
		$catch_up( $front, (array) restwell_get_theme_setup_defaults() );
	}

	// Titles, metas and keyphrases as the October batches left them.
	$seo = array(
		'home' => array(
			'meta_title' => 'Accessible holiday cottage in Whitstable, Kent, sleeps five',
			'meta_description' => 'A private bungalow by the sea in Whitstable, Kent, with a level wet room and ceiling hoist fitted. It sleeps five, and our sister company can add care.',
			'focus_keyphrase' => 'accessible holiday cottages kent',
		),
		'the-property' => array(
			'meta_title' => 'Inside the accessible holiday bungalow in Whitstable',
			'meta_description' => 'A room-by-room look round the bungalow: two bedrooms, a level-access wet room, a kitchen you can wheel under and a level garden. It sleeps up to five.',
			'focus_keyphrase' => 'accessible holiday bungalow',
		),
		'how-it-works' => array(
			'meta_title' => 'How to book a stay at Restwell, step by step',
			'meta_description' => 'From your first message to the front door: how we check the bungalow fits, when the deposit is due and what happens when you arrive on the day.',
			'focus_keyphrase' => 'how to book a stay at restwell',
		),
		'accessibility' => array(
			'meta_title' => 'A disabled holiday cottage with a wet room and hoist',
			'meta_description' => 'Exact access details: a 965mm front door, 926mm inside doors, and hoists rated to 180kg. There’s also a profiling bed and a level wet room.',
			'focus_keyphrase' => 'disabled holiday cottage with wet room and hoists',
		),
		'who-its-for' => array(
			'meta_title' => 'Holidays for disabled adults and their carers',
			'meta_description' => 'A private adapted bungalow in Whitstable for disabled adults, their families and carers, in groups of up to five. Check the measurements before you book.',
			'focus_keyphrase' => 'holidays for disabled adults and carers',
		),
		'our-story' => array(
			'meta_title' => 'Why we built Restwell, and who Continuity are',
			'meta_description' => 'Why we built Restwell, a private adapted bungalow in Whitstable. Our sister company, Continuity of Care Services, can add home care to your stay.',
			'focus_keyphrase' => 'restwell retreats',
		),
		'optional-care' => array(
			'meta_title' => 'A holiday with care provided in Whitstable, if you want it',
			'meta_description' => 'Continuity of Care Services, our sister company, can come into the bungalow while you stay. Ask on the same enquiry as the house, or call 01622 809881.',
			'focus_keyphrase' => 'holidays with care provided',
		),
		'funding-and-support' => array(
			'meta_title' => 'Funding and grants for a disabled holiday',
			'meta_description' => 'Holiday grants for disabled adults and carers, plus council and NHS funding. Here’s what each covers, and the paperwork we can send your funder.',
			'focus_keyphrase' => 'funding and grants for disabled holidays',
		),
		'pricing' => array(
			'meta_title' => 'Accessible holiday prices for the Whitstable bungalow',
			'meta_description' => 'A week in the bungalow is £1,300 off-peak and £1,400 in peak season, and you can book a single night. The access equipment is included in the price.',
			'focus_keyphrase' => 'restwell retreats prices',
		),
		'faq' => array(
			'meta_title' => 'Restwell FAQ: the questions guests ask before booking',
			'meta_description' => 'Straight answers to what people ask before booking, from door widths and hoists to home care, prices and who can pay, each linked to the page with more.',
			'focus_keyphrase' => 'restwell faq',
		),
		'enquire' => array(
			'meta_title' => 'Contact Restwell about a stay in Whitstable',
			'meta_description' => 'Call 01622 809881, email or use the form to ask about dates, access or care. We aim to reply within 48 hours, and there’s no deposit until it fits.',
			'focus_keyphrase' => 'contact restwell retreats',
		),
		'whitstable-area-guide' => array(
			'meta_title' => 'Is Whitstable wheelchair friendly? A local access guide',
			'meta_description' => 'In parts, and we’ll tell you which. Tankerton’s promenade is level, the harbour is step-free with a Changing Places toilet, and the main beach is shingle.',
			'focus_keyphrase' => 'is whitstable wheelchair friendly',
		),
		'blog' => array(
			'meta_title' => 'Accessible travel guides from a Whitstable bungalow',
			'meta_description' => 'Guides written from one adapted bungalow in Whitstable: Kent coast days out, how to pay for a break, and how to check an access statement before you book.',
			'focus_keyphrase' => 'accessible travel guides',
		),
		'privacy-policy' => array(
			'meta_title' => 'Restwell Retreats privacy policy',
			'meta_description' => 'What we collect when you enquire or book, and how long we keep it. We also cover cookies and your rights under UK GDPR.',
			'focus_keyphrase' => 'restwell retreats privacy policy',
		),
		'terms-and-conditions' => array(
			'meta_title' => 'Restwell Retreats booking terms and conditions',
			'meta_description' => 'The terms for booking the bungalow: deposits, cancelling and changing dates. They also cover guest numbers, the access kit and what happens if we cancel.',
			'focus_keyphrase' => 'restwell retreats terms and conditions',
		),
		'accessibility-policy' => array(
			'meta_title' => 'Restwell Retreats website accessibility statement',
			'meta_description' => 'How we build and test this website against WCAG 2.2 AA, and the gaps we know about. Ask for any page in a format that suits you.',
			'focus_keyphrase' => 'restwell retreats website accessibility statement',
		),
	);
	if ( function_exists( 'restwell_page_id_for_stock_slug' ) ) {
		foreach ( $seo as $slug => $targets ) {
			$page_id = restwell_page_id_for_stock_slug( $slug );
			if ( $page_id > 0 ) {
				$catch_up( $page_id, $targets );
			}
		}
	}
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
		'restwell_resources_seo_v63',
		'restwell_privacy_tiktok_pixel_v64',
		'restwell_privacy_tiktok_submitform_v65',
		'restwell_dedupe_theme_pages_v66',
		'restwell_meta_description_length_v67',
		'restwell_legal_address_dates_v68',
		'restwell_house_style_dashes_v70',
		'restwell_post_title_tags_v71',
		'restwell_approved_meta_descriptions_v72',
		'restwell_post_title_tags_v73',
		'restwell_our_story_companies_dedupe_v74',
		'restwell_daylight_heroes_v75',
		'restwell_care_quote_wording_v76',
		'restwell_oven_door_wording_v77',
		'restwell_care_copy_v78',
		'restwell_care_copy_v79',
		'restwell_page_copy_v80',
		'restwell_page_copy_v81',
		'restwell_our_story_hero_v82',
		'restwell_dedupe_home_blog_v83',
		'restwell_batch1_copy_v84',
		'restwell_batch2_copy_v85',
		'restwell_blog_summaries_v86',
		'restwell_batch3_copy_v87',
		'restwell_batch4_copy_v88',
		'restwell_pricing_faq_v89',
		'restwell_pricing_faq_heading_v90',
		'restwell_home_cta_labels_v91',
		'restwell_pricing_rates_intro_v92',
		'restwell_our_story_plain_words_v93',
		'restwell_our_story_build_card_v94',
		'restwell_short_intros_v95',
		'restwell_care_intros_v96',
		'restwell_batch_a_posts_v97',
		'restwell_publish_kept_guides_v98',
		'restwell_page_copy_batch_b_v99',
		'restwell_page_seo_batch_b_v100',
		'restwell_legal_plain_english_v101',
		'restwell_seed_catch_up_v102',
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
	add_action( 'init', 'restwell_migrate_resources_seo_v63', 107 );
	add_action( 'after_switch_theme', 'restwell_migrate_resources_seo_v63', 102 );
	add_action( 'init', 'restwell_migrate_privacy_tiktok_pixel_v64', 108 );
	add_action( 'after_switch_theme', 'restwell_migrate_privacy_tiktok_pixel_v64', 103 );
	add_action( 'init', 'restwell_migrate_privacy_tiktok_submitform_v65', 109 );
	add_action( 'after_switch_theme', 'restwell_migrate_privacy_tiktok_submitform_v65', 104 );
	add_action( 'init', 'restwell_migrate_dedupe_theme_pages_v66', 110 );
	add_action( 'after_switch_theme', 'restwell_migrate_dedupe_theme_pages_v66', 105 );
	add_action( 'init', 'restwell_migrate_meta_description_length_v67', 111 );
	add_action( 'after_switch_theme', 'restwell_migrate_meta_description_length_v67', 106 );
	add_action( 'init', 'restwell_migrate_legal_address_dates_v68', 112 );
	add_action( 'after_switch_theme', 'restwell_migrate_legal_address_dates_v68', 107 );
	add_action( 'init', 'restwell_migrate_house_style_dashes_v70', 113 );
	add_action( 'after_switch_theme', 'restwell_migrate_house_style_dashes_v70', 108 );
	add_action( 'init', 'restwell_migrate_post_title_tags_v71', 114 );
	add_action( 'after_switch_theme', 'restwell_migrate_post_title_tags_v71', 109 );
	add_action( 'init', 'restwell_migrate_approved_meta_descriptions_v72', 115 );
	add_action( 'after_switch_theme', 'restwell_migrate_approved_meta_descriptions_v72', 110 );
	add_action( 'init', 'restwell_migrate_post_title_tags_v73', 116 );
	add_action( 'after_switch_theme', 'restwell_migrate_post_title_tags_v73', 111 );
	add_action( 'init', 'restwell_migrate_our_story_companies_dedupe_v74', 117 );
	add_action( 'after_switch_theme', 'restwell_migrate_our_story_companies_dedupe_v74', 112 );
	add_action( 'init', 'restwell_migrate_daylight_heroes_v75', 118 );
	add_action( 'after_switch_theme', 'restwell_migrate_daylight_heroes_v75', 113 );
	add_action( 'init', 'restwell_migrate_care_quote_wording_v76', 119 );
	add_action( 'after_switch_theme', 'restwell_migrate_care_quote_wording_v76', 114 );
	add_action( 'init', 'restwell_migrate_oven_door_wording_v77', 120 );
	add_action( 'after_switch_theme', 'restwell_migrate_oven_door_wording_v77', 115 );
	add_action( 'init', 'restwell_migrate_care_copy_v78', 121 );
	add_action( 'after_switch_theme', 'restwell_migrate_care_copy_v78', 116 );
	add_action( 'init', 'restwell_migrate_care_copy_v79', 122 );
	add_action( 'after_switch_theme', 'restwell_migrate_care_copy_v79', 117 );
	add_action( 'init', 'restwell_migrate_page_copy_v80', 123 );
	add_action( 'after_switch_theme', 'restwell_migrate_page_copy_v80', 118 );
	add_action( 'init', 'restwell_migrate_page_copy_v81', 124 );
	add_action( 'after_switch_theme', 'restwell_migrate_page_copy_v81', 119 );
	add_action( 'init', 'restwell_migrate_our_story_hero_v82', 125 );
	add_action( 'after_switch_theme', 'restwell_migrate_our_story_hero_v82', 120 );
	add_action( 'init', 'restwell_migrate_dedupe_home_blog_v83', 126 );
	add_action( 'after_switch_theme', 'restwell_migrate_dedupe_home_blog_v83', 121 );
	add_action( 'init', 'restwell_migrate_batch1_copy_v84', 127 );
	add_action( 'after_switch_theme', 'restwell_migrate_batch1_copy_v84', 122 );
	add_action( 'init', 'restwell_migrate_batch2_copy_v85', 128 );
	add_action( 'after_switch_theme', 'restwell_migrate_batch2_copy_v85', 123 );
	add_action( 'init', 'restwell_migrate_blog_summaries_v86', 129 );
	add_action( 'after_switch_theme', 'restwell_migrate_blog_summaries_v86', 124 );
	add_action( 'init', 'restwell_migrate_batch3_copy_v87', 130 );
	add_action( 'after_switch_theme', 'restwell_migrate_batch3_copy_v87', 125 );
	add_action( 'init', 'restwell_migrate_batch4_copy_v88', 131 );
	add_action( 'after_switch_theme', 'restwell_migrate_batch4_copy_v88', 126 );
	add_action( 'init', 'restwell_migrate_pricing_faq_v89', 132 );
	add_action( 'after_switch_theme', 'restwell_migrate_pricing_faq_v89', 127 );
	add_action( 'init', 'restwell_migrate_pricing_faq_heading_v90', 133 );
	add_action( 'after_switch_theme', 'restwell_migrate_pricing_faq_heading_v90', 128 );
	add_action( 'init', 'restwell_migrate_home_cta_labels_v91', 134 );
	add_action( 'after_switch_theme', 'restwell_migrate_home_cta_labels_v91', 129 );
	add_action( 'init', 'restwell_migrate_pricing_rates_intro_v92', 135 );
	add_action( 'after_switch_theme', 'restwell_migrate_pricing_rates_intro_v92', 130 );
	add_action( 'init', 'restwell_migrate_our_story_plain_words_v93', 136 );
	add_action( 'after_switch_theme', 'restwell_migrate_our_story_plain_words_v93', 131 );
	add_action( 'init', 'restwell_migrate_our_story_build_card_v94', 137 );
	add_action( 'after_switch_theme', 'restwell_migrate_our_story_build_card_v94', 132 );
	add_action( 'init', 'restwell_migrate_short_intros_v95', 138 );
	add_action( 'after_switch_theme', 'restwell_migrate_short_intros_v95', 133 );
	add_action( 'init', 'restwell_migrate_care_intros_v96', 139 );
	add_action( 'after_switch_theme', 'restwell_migrate_care_intros_v96', 134 );
	add_action( 'init', 'restwell_migrate_batch_a_posts_v97', 140 );
	add_action( 'after_switch_theme', 'restwell_migrate_batch_a_posts_v97', 135 );
	add_action( 'init', 'restwell_migrate_publish_kept_guides_v98', 141 );
	add_action( 'after_switch_theme', 'restwell_migrate_publish_kept_guides_v98', 136 );
	add_action( 'init', 'restwell_migrate_page_copy_batch_b_v99', 142 );
	add_action( 'after_switch_theme', 'restwell_migrate_page_copy_batch_b_v99', 137 );
	add_action( 'init', 'restwell_migrate_page_seo_batch_b_v100', 143 );
	add_action( 'after_switch_theme', 'restwell_migrate_page_seo_batch_b_v100', 138 );
	add_action( 'init', 'restwell_migrate_legal_plain_english_v101', 144 );
	add_action( 'after_switch_theme', 'restwell_migrate_legal_plain_english_v101', 139 );
	add_action( 'init', 'restwell_migrate_seed_catch_up_v102', 145 );
	add_action( 'after_switch_theme', 'restwell_migrate_seed_catch_up_v102', 140 );

	add_action( 'init', 'restwell_maybe_mark_schema_current', 100 );
	add_action( 'admin_init', 'restwell_maybe_mark_schema_current', 100 );
	add_action( 'after_switch_theme', 'restwell_maybe_mark_schema_current', 100 );
}
restwell_register_content_migrations();
