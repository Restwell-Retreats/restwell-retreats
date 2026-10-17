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
const RESTWELL_SCHEMA_VERSION = 84;


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

	add_action( 'init', 'restwell_maybe_mark_schema_current', 100 );
	add_action( 'admin_init', 'restwell_maybe_mark_schema_current', 100 );
	add_action( 'after_switch_theme', 'restwell_maybe_mark_schema_current', 100 );
}
restwell_register_content_migrations();
