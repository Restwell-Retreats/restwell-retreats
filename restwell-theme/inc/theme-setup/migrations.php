<?php
/**
 * Theme setup: one-time content migrations on init/admin.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function restwell_migrate_homepage_faq_meta_v1() {
	if ( get_option( 'restwell_home_faq_meta_migrated_v1', '' ) === '1' ) {
		return;
	}
	if ( ! function_exists( 'restwell_get_homepage_faq_meta_seed_map' ) ) {
		return;
	}
	$home_id = (int) get_option( 'page_on_front', 0 );
	if ( $home_id < 1 ) {
		return;
	}

	$map = restwell_get_homepage_faq_meta_seed_map();
	foreach ( $map as $key => $value ) {
		if ( metadata_exists( 'post', $home_id, $key ) ) {
			continue;
		}
		update_post_meta( $home_id, $key, $value );
	}

	update_option( 'restwell_home_faq_meta_migrated_v1', '1' );
}
add_action( 'admin_init', 'restwell_migrate_homepage_faq_meta_v1', 5 );
add_action( 'after_switch_theme', 'restwell_migrate_homepage_faq_meta_v1', 10 );

/**
 * One-time refresh of Property page practical-stats meta for sites seeded with TBC / long parking copy.
 *
 * Only overwrites values that still match the old placeholders so manual edits stay intact.
 */
function restwell_migrate_property_practical_meta_v1() {
	if ( get_option( 'restwell_property_practical_meta_v1', '' ) === '1' ) {
		return;
	}
	$page = get_page_by_path( 'the-property', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		return;
	}
	$page_id  = (int) $page->ID;
	$defaults = restwell_get_property_page_defaults();

	$is_tbc = static function ( $val ) {
		return is_string( $val ) && strcasecmp( trim( $val ), 'TBC' ) === 0;
	};

	foreach ( array( 'prop_bedrooms_count', 'prop_bathrooms_count', 'prop_sleeps_value' ) as $key ) {
		$cur = get_post_meta( $page_id, $key, true );
		if ( $is_tbc( $cur ) && isset( $defaults[ $key ] ) ) {
			update_post_meta( $page_id, $key, $defaults[ $key ] );
		}
	}

	$park_cur = (string) get_post_meta( $page_id, 'prop_parking', true );
	$park_old = 'Private driveway, two cars';
	if ( $is_tbc( $park_cur ) || trim( $park_cur ) === $park_old ) {
		update_post_meta( $page_id, 'prop_parking', $defaults['prop_parking'] ?? '2 on private drive' );
	}

	foreach ( array( 'prop_bedrooms', 'prop_bathroom' ) as $key ) {
		$cur = get_post_meta( $page_id, $key, true );
		$old_bed = 'Bedroom configuration confirmed before booking';
		$old_bath = 'Bathroom configuration confirmed before booking';
		if ( $key === 'prop_bedrooms' && is_string( $cur ) && trim( $cur ) === $old_bed && isset( $defaults[ $key ] ) ) {
			update_post_meta( $page_id, $key, $defaults[ $key ] );
		}
		if ( $key === 'prop_bathroom' && is_string( $cur ) && trim( $cur ) === $old_bath && isset( $defaults[ $key ] ) ) {
			update_post_meta( $page_id, $key, $defaults[ $key ] );
		}
	}

	update_option( 'restwell_property_practical_meta_v1', '1' );
}
add_action( 'init', 'restwell_migrate_property_practical_meta_v1', 20 );
add_action( 'after_switch_theme', 'restwell_migrate_property_practical_meta_v1', 10 );

/**
 * One-time: set sleeps to 5 for sites that received the earlier default of 6.
 */
function restwell_migrate_property_sleeps_five_v1() {
	if ( get_option( 'restwell_property_sleeps_five_v1', '' ) === '1' ) {
		return;
	}
	$page = get_page_by_path( 'the-property', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		return;
	}
	$page_id = (int) $page->ID;
	$cur     = get_post_meta( $page_id, 'prop_sleeps_value', true );
	if ( is_string( $cur ) && trim( $cur ) === '6' ) {
		update_post_meta( $page_id, 'prop_sleeps_value', '5' );
	}
	update_option( 'restwell_property_sleeps_five_v1', '1' );
}
add_action( 'init', 'restwell_migrate_property_sleeps_five_v1', 21 );
add_action( 'after_switch_theme', 'restwell_migrate_property_sleeps_five_v1', 11 );

/**
 * One-time: shorten parking strip text (private drive wording was too long for the grid on small screens).
 */
function restwell_migrate_property_parking_short_v1() {
	if ( get_option( 'restwell_property_parking_short_v1', '' ) === '1' ) {
		return;
	}
	$page = get_page_by_path( 'the-property', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		return;
	}
	$page_id = (int) $page->ID;
	$cur     = trim( (string) get_post_meta( $page_id, 'prop_parking', true ) );
	$short   = '2 cars';
	$legacy  = array(
		'Private drive · 2 cars',
		'Private drive • 2 cars',
		'Private driveway, two cars',
		'Private driveway, 2 cars',
		'Private drive, 2 cars',
		'Private drive, two cars',
	);
	if ( in_array( $cur, $legacy, true ) ) {
		update_post_meta( $page_id, 'prop_parking', $short );
	}
	update_option( 'restwell_property_parking_short_v1', '1' );
}
add_action( 'init', 'restwell_migrate_property_parking_short_v1', 22 );
add_action( 'after_switch_theme', 'restwell_migrate_property_parking_short_v1', 12 );

/**
 * One-time: correct bedroom count (2 + sofa bed, sleeps 5) and refresh parking strip label for existing installs.
 */
function restwell_migrate_property_bedrooms_parking_v2() {
	if ( get_option( 'restwell_property_bedrooms_parking_v2', '' ) === '1' ) {
		return;
	}
	$page = get_page_by_path( 'the-property', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		return;
	}
	$page_id = (int) $page->ID;

	$cur_count = trim( (string) get_post_meta( $page_id, 'prop_bedrooms_count', true ) );
	if ( $cur_count === '3' ) {
		update_post_meta( $page_id, 'prop_bedrooms_count', '2' );
	}

	$old_bed_txt = 'Three bedrooms: flexible layout for guests, family, and carers';
	$cur_bed     = trim( (string) get_post_meta( $page_id, 'prop_bedrooms', true ) );
	if ( $cur_bed === $old_bed_txt ) {
		update_post_meta( $page_id, 'prop_bedrooms', 'Two bedrooms, plus a sofa bed in the living area. Sleeps up to five.' );
	}

	$cur_park = trim( (string) get_post_meta( $page_id, 'prop_parking', true ) );
	if ( $cur_park === '2 cars' ) {
		update_post_meta( $page_id, 'prop_parking', '2 on private drive' );
	}

	update_option( 'restwell_property_bedrooms_parking_v2', '1' );
}
add_action( 'init', 'restwell_migrate_property_bedrooms_parking_v2', 23 );
add_action( 'after_switch_theme', 'restwell_migrate_property_bedrooms_parking_v2', 13 );

/**
 * One-time: longer parking detail line and split count from description for existing installs.
 */
function restwell_migrate_property_parking_detail_v3() {
	if ( get_option( 'restwell_property_parking_detail_v3', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'the-property', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		return;
	}

	$page_id  = (int) $page->ID;
	$defaults = restwell_get_property_page_defaults();
	$cur_park = trim( (string) get_post_meta( $page_id, 'prop_parking', true ) );
	$legacy_parking = array(
		'2 on private drive',
		'2 cars',
		'Private drive · 2 cars',
		'Private drive • 2 cars',
		'Private driveway, two cars',
		'Private driveway, 2 cars',
		'Private drive, 2 cars',
		'Private drive, two cars',
	);

	if ( in_array( $cur_park, $legacy_parking, true ) || preg_match( '/^2\s+on private drive$/i', $cur_park ) ) {
		update_post_meta( $page_id, 'prop_parking', $defaults['prop_parking'] ?? '2' );
	}

	$cur_detail = trim( (string) get_post_meta( $page_id, 'prop_parking_detail', true ) );
	if ( $cur_detail === '' ) {
		update_post_meta( $page_id, 'prop_parking_detail', $defaults['prop_parking_detail'] ?? 'Room for two vehicles on the resin-bound private drive' );
	}

	$cur_bed = trim( (string) get_post_meta( $page_id, 'prop_bedrooms', true ) );
	if ( str_contains( $cur_bed, '—' ) ) {
		update_post_meta( $page_id, 'prop_bedrooms', restwell_normalize_editorial_dashes( $cur_bed ) );
	}

	update_option( 'restwell_property_parking_detail_v3', '1' );
}
add_action( 'init', 'restwell_migrate_property_parking_detail_v3', 24 );
add_action( 'after_switch_theme', 'restwell_migrate_property_parking_detail_v3', 14 );

/**
 * One-time: refresh property page H2 headings to SEO-friendly defaults.
 */
function restwell_migrate_property_headings_v4() {
	if ( get_option( 'restwell_property_headings_v4', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'the-property', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		return;
	}

	$page_id = (int) $page->ID;
	$maps    = function_exists( 'restwell_get_property_heading_refresh_maps' )
		? restwell_get_property_heading_refresh_maps()
		: array();

	foreach ( $maps as $meta_key => $stale_map ) {
		$current = trim( (string) get_post_meta( $page_id, $meta_key, true ) );
		if ( $current === '' || ! isset( $stale_map[ $current ] ) ) {
			continue;
		}
		$next = trim( (string) $stale_map[ $current ] );
		if ( $next !== '' ) {
			update_post_meta( $page_id, $meta_key, $next );
		}
	}

	foreach ( array( 'prop_practical_label', 'prop_features_label' ) as $label_key ) {
		$label = trim( (string) get_post_meta( $page_id, $label_key, true ) );
		if ( function_exists( 'restwell_sanitize_property_section_label' ) ) {
			$clean = restwell_sanitize_property_section_label( $label );
			if ( $clean !== $label ) {
				update_post_meta( $page_id, $label_key, $clean );
			}
		}
	}

	update_option( 'restwell_property_headings_v4', '1' );
}
add_action( 'init', 'restwell_migrate_property_headings_v4', 25 );
add_action( 'after_switch_theme', 'restwell_migrate_property_headings_v4', 15 );

/**
 * One-time: clear misplaced section labels and catch practical heading variants.
 */
function restwell_migrate_property_labels_v5() {
	if ( get_option( 'restwell_property_labels_v5', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'the-property', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		return;
	}

	$page_id = (int) $page->ID;

	foreach ( array( 'prop_practical_label', 'prop_features_label' ) as $label_key ) {
		$label = trim( (string) get_post_meta( $page_id, $label_key, true ) );
		if ( function_exists( 'restwell_sanitize_property_section_label' ) ) {
			$clean = restwell_sanitize_property_section_label( $label );
			if ( $clean !== $label ) {
				update_post_meta( $page_id, $label_key, $clean );
			}
		}
	}

	if ( function_exists( 'restwell_get_property_heading' ) ) {
		$heading = trim( (string) get_post_meta( $page_id, 'prop_practical_heading', true ) );
		$fixed   = restwell_get_property_heading( $page_id, 'prop_practical_heading' );
		if ( $heading !== '' && $fixed !== $heading ) {
			update_post_meta( $page_id, 'prop_practical_heading', $fixed );
		}
	}

	update_option( 'restwell_property_labels_v5', '1' );
}
add_action( 'init', 'restwell_migrate_property_labels_v5', 26 );
add_action( 'after_switch_theme', 'restwell_migrate_property_labels_v5', 16 );

/**
 * One-time: refresh wet room capacity tile copy and drop accessibility-page fallback wording.
 */
function restwell_migrate_property_wetroom_stat_v6() {
	if ( get_option( 'restwell_property_wetroom_stat_v6', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'the-property', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		return;
	}

	$page_id  = (int) $page->ID;
	$defaults = restwell_get_property_page_defaults();
	$current  = trim( (string) get_post_meta( $page_id, 'prop_bathroom', true ) );
	$next     = trim( (string) ( $defaults['prop_bathroom'] ?? '' ) );

	$stale = array(
		'One wet room with roll-in shower (full spec on our Accessibility page)',
		'One wet room with roll-in shower (full spec on our accessibility page)',
	);

	if ( $current === '' || in_array( $current, $stale, true ) || stripos( $current, 'accessibility page' ) !== false ) {
		if ( $next !== '' ) {
			update_post_meta( $page_id, 'prop_bathroom', $next );
		}
	}

	update_option( 'restwell_property_wetroom_stat_v6', '1' );
}
add_action( 'init', 'restwell_migrate_property_wetroom_stat_v6', 27 );
add_action( 'after_switch_theme', 'restwell_migrate_property_wetroom_stat_v6', 17 );

/**
 * One-time: seed wet room walkthrough YouTube Shorts URL when not yet set.
 */
function restwell_migrate_property_wetroom_walkthrough_v7() {
	if ( get_option( 'restwell_property_wetroom_walkthrough_v7', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'the-property', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		return;
	}

	$page_id  = (int) $page->ID;
	$defaults = restwell_get_property_page_defaults();
	$url      = trim( (string) get_post_meta( $page_id, 'prop_wetroom_walkthrough_url', true ) );
	$default  = trim( (string) ( $defaults['prop_wetroom_walkthrough_url'] ?? '' ) );

	if ( $url === '' && $default !== '' ) {
		update_post_meta( $page_id, 'prop_wetroom_walkthrough_url', $default );
	}

	update_option( 'restwell_property_wetroom_walkthrough_v7', '1' );
}
add_action( 'init', 'restwell_migrate_property_wetroom_walkthrough_v7', 28 );
add_action( 'after_switch_theme', 'restwell_migrate_property_wetroom_walkthrough_v7', 18 );

/**
 * One-time: replace SEO test placeholder copy (e.g. TESTWORD) on the homepage CTA.
 */
function restwell_migrate_homepage_cta_testword_v8() {
	if ( get_option( 'restwell_homepage_cta_testword_v8', '' ) === '1' ) {
		return;
	}

	$home = get_page_by_path( 'home', OBJECT, 'page' );
	if ( ! $home && (int) get_option( 'page_on_front' ) > 0 ) {
		$home = get_post( (int) get_option( 'page_on_front' ) );
	}
	if ( ! $home || (int) $home->ID < 1 ) {
		return;
	}

	$page_id  = (int) $home->ID;
	$defaults = restwell_get_theme_setup_defaults();
	$current  = trim( (string) get_post_meta( $page_id, 'cta_body', true ) );
	$fixed    = trim( (string) ( $defaults['cta_body'] ?? '' ) );

	if ( $current !== '' && stripos( $current, 'testword' ) !== false && $fixed !== '' ) {
		update_post_meta( $page_id, 'cta_body', $fixed );
	}

	update_option( 'restwell_homepage_cta_testword_v8', '1' );
}
add_action( 'init', 'restwell_migrate_homepage_cta_testword_v8', 29 );
add_action( 'after_switch_theme', 'restwell_migrate_homepage_cta_testword_v8', 19 );

/**
 * One-time: refresh wet room capacity tile copy (shorter detail under the Wet room label).
 */
function restwell_migrate_property_wetroom_stat_copy_v9() {
	if ( get_option( 'restwell_property_wetroom_stat_copy_v9', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'the-property', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		return;
	}

	$page_id  = (int) $page->ID;
	$defaults = restwell_get_property_page_defaults();
	$current  = trim( (string) get_post_meta( $page_id, 'prop_bathroom', true ) );
	$next     = trim( (string) ( $defaults['prop_bathroom'] ?? '' ) );

	$stale = array(
		'One wet room with roll-in shower.',
		'One wet room with roll-in shower',
		'One wet room with roll-in shower (full spec on our Accessibility page)',
		'One wet room with roll-in shower (full spec on our accessibility page)',
	);

	if ( ( $current === '' || in_array( $current, $stale, true ) || stripos( $current, 'accessibility page' ) !== false ) && $next !== '' ) {
		update_post_meta( $page_id, 'prop_bathroom', $next );
	}

	update_option( 'restwell_property_wetroom_stat_copy_v9', '1' );
}
add_action( 'init', 'restwell_migrate_property_wetroom_stat_copy_v9', 30 );
add_action( 'after_switch_theme', 'restwell_migrate_property_wetroom_stat_copy_v9', 20 );

/**
 * One-time: sync FAQ / Accessibility / How it works / Guest Guide copy when pages still have pre-correction defaults.
 */
function restwell_migrate_faq_access_parking_bedrooms_v1() {
	if ( get_option( 'restwell_faq_access_parking_bedrooms_v1', '' ) === '1' ) {
		return;
	}
	$faq_old_a = 'Exclusive use of the whole house, all accessibility equipment (ceiling hoist in the accessible bedroom, profiling bed, wet room), linen and towels, private parking for two cars, and high-speed broadband. Care is priced separately if required.';
	$faq_page  = get_page_by_path( 'faq', OBJECT, 'page' );
	if ( $faq_page ) {
		$fid = (int) $faq_page->ID;
		if ( trim( (string) get_post_meta( $fid, 'faq_7_a', true ) ) === $faq_old_a ) {
			$d = restwell_get_faq_page_defaults();
			update_post_meta( $fid, 'faq_7_a', $d['faq_7_a'] );
		}
	}

	$acc_page = get_page_by_path( 'accessibility', OBJECT, 'page' );
	if ( $acc_page ) {
		$aid          = (int) $acc_page->ID;
		$ad           = restwell_get_accessibility_page_defaults();
		$old_arrival  = "Level driveway with space for two cars\nStep-free path from car to front door\nWide front door (965 mm clear)\nLevel threshold, no step";
		$old_bed_body = "Profiling bed with pressure-relieving mattress\nCeiling hoist with full-room track in this bedroom for transfers at the bed\nHeight-adjustable features\nSpace for carer on both sides of bed";
		if ( trim( (string) get_post_meta( $aid, 'acc_arrival_body', true ) ) === $old_arrival ) {
			update_post_meta( $aid, 'acc_arrival_body', $ad['acc_arrival_body'] );
		}
		if ( trim( (string) get_post_meta( $aid, 'acc_bedroom_body', true ) ) === $old_bed_body ) {
			update_post_meta( $aid, 'acc_bedroom_heading', $ad['acc_bedroom_heading'] );
			update_post_meta( $aid, 'acc_bedroom_body', $ad['acc_bedroom_body'] );
		}
	}

	$hiw_page = get_page_by_path( 'how-it-works', OBJECT, 'page' );
	if ( $hiw_page ) {
		$hid = (int) $hiw_page->ID;
		if ( trim( (string) get_post_meta( $hid, 'hiw_included_5_desc', true ) ) === 'Private driveway.' ) {
			$hd = restwell_get_how_it_works_page_defaults();
			update_post_meta( $hid, 'hiw_included_5_desc', $hd['hiw_included_5_desc'] );
		}
	}

	$gg_page = get_page_by_path( 'guest-guide', OBJECT, 'page' );
	if ( $gg_page ) {
		$gid = (int) $gg_page->ID;
		if ( trim( (string) get_post_meta( $gid, 'gg_parking_info', true ) ) === '' ) {
			$gd = restwell_get_guest_guide_page_defaults();
			if ( isset( $gd['gg_parking_info'] ) ) {
				update_post_meta( $gid, 'gg_parking_info', $gd['gg_parking_info'] );
			}
		}
	}

	update_option( 'restwell_faq_access_parking_bedrooms_v1', '1' );
}
add_action( 'init', 'restwell_migrate_faq_access_parking_bedrooms_v1', 24 );
add_action( 'after_switch_theme', 'restwell_migrate_faq_access_parking_bedrooms_v1', 14 );

/**
 * One-time: normalise Property "What's in the house" card copy length for cleaner side-by-side rhythm.
 *
 * Only overwrites values that still match the previous defaults so editor-customised copy is preserved.
 */
function restwell_migrate_property_feature_copy_balance_v1() {
	if ( get_option( 'restwell_property_feature_copy_balance_v1', '' ) === '1' ) {
		return;
	}
	$page = get_page_by_path( 'the-property', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		return;
	}
	$page_id = (int) $page->ID;

	$replacements = array(
		'prop_feature_1_desc' => array(
			'old' => 'Track laid for the full accessible bedroom—focused where bed-based transfers happen every day',
			'new' => 'Full-room track in the accessible bedroom for daily bed transfers',
		),
		'prop_feature_2_desc' => array(
			'old' => 'Roll-in shower, grab rails, perching stool in the shower, fully height-adjustable washbasin that swings aside (shower chair on request)',
			'new' => 'Roll-in shower, grab rails, tilt-in-space shower chair, and adjustable washbasin',
		),
		'prop_feature_3_desc' => array(
			'old' => 'With pressure-relieving mattress',
			'new' => 'Pressure-relieving mattress included and ready for your stay',
		),
		'prop_feature_4_desc' => array(
			'old' => 'Internal doors 926 mm clear; front door 965 mm',
			'new' => 'Internal doors 926 mm clear; front door 965 mm clear',
		),
		'prop_feature_6_desc' => array(
			'old' => 'Hard-standing patio and level garden',
			'new' => 'Hard-standing patio with a level, step-free garden route',
		),
		'prop_feature_7_desc' => array(
			'old' => 'Gas hob (not induction); height-adapted worktop section',
			'new' => 'Gas hob kitchen with a height-adapted worktop section',
		),
		'prop_feature_8_desc' => array(
			'old' => 'Reliable Wi-Fi throughout the property',
			'new' => 'Reliable Wi-Fi coverage across the whole property',
		),
	);

	foreach ( $replacements as $meta_key => $pair ) {
		$current = trim( (string) get_post_meta( $page_id, $meta_key, true ) );
		if ( $current === trim( $pair['old'] ) ) {
			update_post_meta( $page_id, $meta_key, $pair['new'] );
		}
	}

	update_option( 'restwell_property_feature_copy_balance_v1', '1' );
}
add_action( 'init', 'restwell_migrate_property_feature_copy_balance_v1', 25 );
add_action( 'after_switch_theme', 'restwell_migrate_property_feature_copy_balance_v1', 15 );

/**
 * One-time: balance homepage and "How it works" card description lengths.
 *
 * Only replaces copy that still matches older defaults, preserving editor-updated content.
 */
function restwell_migrate_home_hiw_card_copy_balance_v1() {
	if ( get_option( 'restwell_home_hiw_card_copy_balance_v1', '' ) === '1' ) {
		return;
	}

	$home_id = (int) get_option( 'page_on_front', 0 );
	if ( $home_id > 0 ) {
		$home_replacements = array(
			'highlight_1_desc' => array(
				'old' => 'Ceiling track in the accessible bedroom, laid for the full room so transfers at the profiling bed are straightforward.',
				'new' => 'Full-room ceiling track in the accessible bedroom for daily bed transfers.',
			),
			'highlight_2_desc' => array(
				'old' => 'Adjustable, with a pressure-relieving mattress. Ready for your stay.',
				'new' => 'Adjustable profiling bed with a pressure-relieving mattress, ready on arrival.',
			),
			'highlight_3_desc' => array(
				'old' => 'Roll-in shower, grab rails, perching stool in the shower, height-adjustable washbasin that swings aside, and space to turn and assist (shower chair on request).',
				'new' => 'Roll-in wet room with grab rails, tilt-in-space shower chair, and an adjustable washbasin.',
			),
		);

		foreach ( $home_replacements as $meta_key => $pair ) {
			$current = trim( (string) get_post_meta( $home_id, $meta_key, true ) );
			if ( $current === trim( $pair['old'] ) ) {
				update_post_meta( $home_id, $meta_key, $pair['new'] );
			}
		}
	}

	$hiw_page = get_page_by_path( 'how-it-works', OBJECT, 'page' );
	if ( $hiw_page && (int) $hiw_page->ID > 0 ) {
		$hiw_id = (int) $hiw_page->ID;
		$hiw_replacements = array(
			'hiw_included_1_desc' => array(
				'old' => 'No shared spaces, no other guests.',
				'new' => 'Private use of the whole bungalow, with no shared spaces.',
			),
			'hiw_included_2_desc' => array(
				'old' => 'Ceiling track hoist in the accessible bedroom, profiling bed, and wet room with grab rails and a height-adjustable washbasin that swings aside—in place and ready for your arrival.',
				'new' => 'Ceiling hoist, profiling bed, and wet room with grab rails are ready on arrival.',
			),
			'hiw_included_3_desc' => array(
				'old' => 'Reliable Wi-Fi throughout.',
				'new' => 'Reliable Wi-Fi coverage across the property for guests and carers.',
			),
			'hiw_included_4_desc' => array(
				'old' => 'Freshly laundered for your arrival.',
				'new' => 'Freshly laundered bed linen and towels, prepared before you arrive.',
			),
			'hiw_included_5_desc' => array(
				'old' => 'Two off-road spaces on the private drive. On-street outside if you need more room—no residents permit on this road.',
				'new' => 'Two off-road spaces on the private drive, with nearby on-street overflow.',
			),
			'hiw_included_6_desc' => array(
				'old' => 'Local tips, emergency contacts, house guide, plus tea, coffee, and a few basics so you are not shopping the moment you arrive.',
				'new' => 'House guide, local contacts, plus tea, coffee, and basic arrival essentials.',
			),
		);

		foreach ( $hiw_replacements as $meta_key => $pair ) {
			$current = trim( (string) get_post_meta( $hiw_id, $meta_key, true ) );
			if ( $current === trim( $pair['old'] ) ) {
				update_post_meta( $hiw_id, $meta_key, $pair['new'] );
			}
		}
	}

	update_option( 'restwell_home_hiw_card_copy_balance_v1', '1' );
}
add_action( 'init', 'restwell_migrate_home_hiw_card_copy_balance_v1', 26 );
add_action( 'after_switch_theme', 'restwell_migrate_home_hiw_card_copy_balance_v1', 16 );

/**
 * One-time: assign dedicated legal / policy templates and ensure Accessibility Policy page exists.
 *
 * Existing installs keep their Privacy and Terms pages at the same URLs; post_content is no longer
 * used for the default copy (templates + Page Content Fields / theme defaults instead).
 */
function restwell_migrate_legal_policy_templates_v1() {
	if ( get_option( 'restwell_legal_policy_templates_v1', '' ) === '1' ) {
		return;
	}

	$assign = static function ( $slug, $template_file ) {
		$page = get_page_by_path( $slug, OBJECT, 'page' );
		if ( $page && (int) $page->ID > 0 ) {
			update_post_meta( (int) $page->ID, '_wp_page_template', $template_file );
		}
	};

	$assign( 'privacy-policy', 'template-privacy-policy.php' );
	$assign( 'terms-and-conditions', 'template-terms-and-conditions.php' );

	$ap = get_page_by_path( 'accessibility-policy', OBJECT, 'page' );
	if ( ! $ap ) {
		$admins = get_users(
			array(
				'role'   => 'administrator',
				'number' => 1,
				'fields' => 'ID',
			)
		);
		$author_id = ! empty( $admins[0] ) ? (int) $admins[0] : 1;

		$new_id = wp_insert_post(
			array(
				'post_title'   => 'Accessibility Policy',
				'post_name'    => 'accessibility-policy',
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_author'  => $author_id,
				'post_content' => '',
			),
			true
		);
		if ( ! is_wp_error( $new_id ) && $new_id > 0 ) {
			update_post_meta( (int) $new_id, '_wp_page_template', 'template-accessibility-policy.php' );
			if ( function_exists( 'restwell_merge_theme_defaults_into_post_meta' ) && function_exists( 'restwell_get_accessibility_policy_page_defaults' ) ) {
				restwell_merge_theme_defaults_into_post_meta( (int) $new_id, restwell_get_accessibility_policy_page_defaults(), false );
				update_post_meta( (int) $new_id, 'restwell_fields_seeded', '1' );
			}
		}
	} else {
		update_post_meta( (int) $ap->ID, '_wp_page_template', 'template-accessibility-policy.php' );
	}

	update_option( 'restwell_legal_policy_templates_v1', '1' );
}
add_action( 'init', 'restwell_migrate_legal_policy_templates_v1', 12 );
add_action( 'after_switch_theme', 'restwell_migrate_legal_policy_templates_v1', 12 );

/**
 * One-time: shorten accessibility page H1 and move equipment keywords into the intro.
 *
 * @return array<string, string>
 */
function restwell_get_accessibility_heading_refresh_map() {
	return array(
		'Our access statement: doorway widths, ceiling-track hoist and wet room' => 'Our access statement, room by room',
		'Our access statement: the Whitstable bungalow in plain detail' => 'Our access statement, room by room',
		'Wheelchair accessible holiday cottage near Whitstable: hoist, wet room, and measurements we publish' => 'Our access statement, room by room',
		'Honest detail, so you can decide' => 'Our access statement, room by room',
	);
}

/**
 * One-time: refresh accessibility page intro when it still matches stale defaults.
 *
 * @return array<string, string>
 */
function restwell_get_accessibility_intro_refresh_map() {
	return array(
		'We list the real measurements so you can decide whether the house works for you, rather than asking you to trust the word accessible. Here\'s what\'s in place, room by room.' => 'Our wheelchair-accessible Whitstable bungalow in detail: doorway widths, ceiling-track hoist and wet room measurements so you can decide whether the house works for you.',
		"We list the real measurements so you can decide whether the house works for you, rather than asking you to trust the word accessible. Here's what's in place, room by room." => 'Our wheelchair-accessible Whitstable bungalow in detail: doorway widths, ceiling-track hoist and wet room measurements so you can decide whether the house works for you.',
		'Doorway widths, ceiling-track hoist and wet room: we list the real measurements so you can decide whether the house works for you. Here is what we have verified in each room.' => 'Our wheelchair-accessible Whitstable bungalow in detail: doorway widths, ceiling-track hoist and wet room measurements so you can decide whether the house works for you.',
	);
}

/**
 * One-time: refresh accessibility page hero copy to compact headings.
 */
function restwell_migrate_accessibility_headings_v1() {
	if ( get_option( 'restwell_accessibility_headings_v1', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'accessibility', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		return;
	}

	$page_id = (int) $page->ID;

	foreach ( restwell_get_accessibility_heading_refresh_map() as $stale => $next ) {
		$current = trim( (string) get_post_meta( $page_id, 'acc_heading', true ) );
		if ( $current === $stale ) {
			update_post_meta( $page_id, 'acc_heading', $next );
		}
	}

	foreach ( restwell_get_accessibility_intro_refresh_map() as $stale => $next ) {
		$current = trim( (string) get_post_meta( $page_id, 'acc_intro', true ) );
		if ( $current === $stale ) {
			update_post_meta( $page_id, 'acc_intro', $next );
		}
	}

	update_option( 'restwell_accessibility_headings_v1', '1' );
}
add_action( 'init', 'restwell_migrate_accessibility_headings_v1', 25 );
add_action( 'after_switch_theme', 'restwell_migrate_accessibility_headings_v1', 15 );

/**
 * One-time: update accessibility page intro to SEO-keyword-leading version.
 * Migrates sites where v1 already ran (stored the previous intermediate intro).
 */
function restwell_migrate_accessibility_intro_v2() {
	if ( get_option( 'restwell_accessibility_intro_v2', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'accessibility', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		return;
	}

	$page_id = (int) $page->ID;
	$next    = 'Our wheelchair-accessible Whitstable bungalow in detail: doorway widths, ceiling-track hoist and wet room measurements so you can decide whether the house works for you.';

	foreach ( restwell_get_accessibility_intro_refresh_map() as $stale => $_ ) {
		$current = trim( (string) get_post_meta( $page_id, 'acc_intro', true ) );
		if ( $current === $stale ) {
			update_post_meta( $page_id, 'acc_intro', $next );
			break;
		}
	}

	update_option( 'restwell_accessibility_intro_v2', '1' );
}
add_action( 'init', 'restwell_migrate_accessibility_intro_v2', 26 );
add_action( 'after_switch_theme', 'restwell_migrate_accessibility_intro_v2', 16 );

/**
 * One-time: update Who It's For page H1 and intro to shortened, keyword-leading versions.
 */
function restwell_migrate_who_its_for_headings_v1() {
	if ( get_option( 'restwell_who_its_for_headings_v1', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'who-its-for', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		return;
	}

	$page_id = (int) $page->ID;

	$heading_map = array(
		'Built for guests with access needs, and everyone travelling with them' => 'Built for guests with access needs',
	);
	foreach ( $heading_map as $stale => $next ) {
		$current = trim( (string) get_post_meta( $page_id, 'wif_heading', true ) );
		if ( $current === $stale ) {
			update_post_meta( $page_id, 'wif_heading', $next );
		}
	}

	$intro_map = array(
		'Restwell suits anyone who needs a step-free holiday with room to bring family, carers or friends. These are the guests we most often welcome, and the features that matter most to each.' => 'Restwell is a wheelchair-accessible holiday in Whitstable for anyone who needs a step-free stay with room to bring family, carers or friends. These are the guests we most often welcome, and the features that matter most to each.',
	);
	foreach ( $intro_map as $stale => $next ) {
		$current = trim( (string) get_post_meta( $page_id, 'wif_intro', true ) );
		if ( $current === $stale ) {
			update_post_meta( $page_id, 'wif_intro', $next );
		}
	}

	update_option( 'restwell_who_its_for_headings_v1', '1' );
}
add_action( 'init', 'restwell_migrate_who_its_for_headings_v1', 27 );
add_action( 'after_switch_theme', 'restwell_migrate_who_its_for_headings_v1', 17 );

/**
 * One-time: update property page headings to shortened versions.
 * Handles prop_hero_heading (not covered by refresh maps at runtime).
 */
function restwell_migrate_property_headings_v1() {
	if ( get_option( 'restwell_property_headings_v1', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'the-property', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		return;
	}

	$page_id = (int) $page->ID;

	$meta_map = array(
		'prop_hero_heading' => array(
			'An accessible bungalow in Whitstable, near the beach' => 'An accessible bungalow in Whitstable',
		),
		'prop_bedrooms_section_heading' => array(
			'Ceiling hoist, profiling beds and a double room' => 'Ceiling hoist and profiling bed',
		),
		'prop_throughout_heading' => array(
			'Wide doorways and step-free access throughout' => 'Wide doorways, step-free throughout',
		),
	);

	foreach ( $meta_map as $meta_key => $map ) {
		$current = trim( (string) get_post_meta( $page_id, $meta_key, true ) );
		if ( isset( $map[ $current ] ) ) {
			update_post_meta( $page_id, $meta_key, $map[ $current ] );
		}
	}

	update_option( 'restwell_property_headings_v1', '1' );
}
add_action( 'init', 'restwell_migrate_property_headings_v1', 28 );
add_action( 'after_switch_theme', 'restwell_migrate_property_headings_v1', 18 );

/**
 * One-time: update How It Works care CTA heading to shortened version.
 */
function restwell_migrate_how_it_works_headings_v1() {
	if ( get_option( 'restwell_how_it_works_headings_v1', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'how-it-works', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		return;
	}

	$page_id    = (int) $page->ID;
	$stale      = 'Care is arranged around your days and your routine.';
	$next       = 'Care fits around your routine';
	$current    = trim( (string) get_post_meta( $page_id, 'hiw_care_cta_heading', true ) );
	if ( $current === $stale ) {
		update_post_meta( $page_id, 'hiw_care_cta_heading', $next );
	}

	update_option( 'restwell_how_it_works_headings_v1', '1' );
}
add_action( 'init', 'restwell_migrate_how_it_works_headings_v1', 29 );
add_action( 'after_switch_theme', 'restwell_migrate_how_it_works_headings_v1', 19 );
