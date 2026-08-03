<?php
/**
 * Theme setup: one-time content migrations on init/admin.
 *
 * Bootstrap: hooks are registered only while restwell_schema_version is below
 * RESTWELL_SCHEMA_VERSION. Migration function bodies are unchanged.
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
const RESTWELL_SCHEMA_VERSION = 5;

function restwell_migrate_homepage_faq_meta_v1() {
	if ( get_option( 'restwell_home_faq_meta_migrated_v1', '' ) === '1' ) {
		return;
	}
	if ( ! function_exists( 'restwell_get_homepage_faq_meta_seed_map' ) ) {
		update_option( 'restwell_home_faq_meta_migrated_v1', '1' );
		return;
	}
	$home_id = (int) get_option( 'page_on_front', 0 );
	if ( $home_id < 1 ) {
		update_option( 'restwell_home_faq_meta_migrated_v1', '1' );
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
		update_option( 'restwell_property_practical_meta_v1', '1' );
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

/**
 * One-time: set sleeps to 5 for sites that received the earlier default of 6.
 */
function restwell_migrate_property_sleeps_five_v1() {
	if ( get_option( 'restwell_property_sleeps_five_v1', '' ) === '1' ) {
		return;
	}
	$page = get_page_by_path( 'the-property', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		update_option( 'restwell_property_sleeps_five_v1', '1' );
		return;
	}
	$page_id = (int) $page->ID;
	$cur     = get_post_meta( $page_id, 'prop_sleeps_value', true );
	if ( is_string( $cur ) && trim( $cur ) === '6' ) {
		update_post_meta( $page_id, 'prop_sleeps_value', '5' );
	}
	update_option( 'restwell_property_sleeps_five_v1', '1' );
}

/**
 * One-time: shorten parking strip text (private drive wording was too long for the grid on small screens).
 */
function restwell_migrate_property_parking_short_v1() {
	if ( get_option( 'restwell_property_parking_short_v1', '' ) === '1' ) {
		return;
	}
	$page = get_page_by_path( 'the-property', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		update_option( 'restwell_property_parking_short_v1', '1' );
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

/**
 * One-time: correct bedroom count (2 + sofa bed, sleeps 5) and refresh parking strip label for existing installs.
 */
function restwell_migrate_property_bedrooms_parking_v2() {
	if ( get_option( 'restwell_property_bedrooms_parking_v2', '' ) === '1' ) {
		return;
	}
	$page = get_page_by_path( 'the-property', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		update_option( 'restwell_property_bedrooms_parking_v2', '1' );
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

/**
 * One-time: longer parking detail line and split count from description for existing installs.
 */
function restwell_migrate_property_parking_detail_v3() {
	if ( get_option( 'restwell_property_parking_detail_v3', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'the-property', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		update_option( 'restwell_property_parking_detail_v3', '1' );
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

/**
 * One-time: refresh property page H2 headings to SEO-friendly defaults.
 */
function restwell_migrate_property_headings_v4() {
	if ( get_option( 'restwell_property_headings_v4', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'the-property', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		update_option( 'restwell_property_headings_v4', '1' );
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

/**
 * One-time: clear misplaced section labels and catch practical heading variants.
 */
function restwell_migrate_property_labels_v5() {
	if ( get_option( 'restwell_property_labels_v5', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'the-property', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		update_option( 'restwell_property_labels_v5', '1' );
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

/**
 * One-time: refresh wet room capacity tile copy and drop accessibility-page fallback wording.
 */
function restwell_migrate_property_wetroom_stat_v6() {
	if ( get_option( 'restwell_property_wetroom_stat_v6', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'the-property', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		update_option( 'restwell_property_wetroom_stat_v6', '1' );
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

/**
 * One-time: seed wet room walkthrough YouTube Shorts URL when not yet set.
 */
function restwell_migrate_property_wetroom_walkthrough_v7() {
	if ( get_option( 'restwell_property_wetroom_walkthrough_v7', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'the-property', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		update_option( 'restwell_property_wetroom_walkthrough_v7', '1' );
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
		update_option( 'restwell_homepage_cta_testword_v8', '1' );
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

/**
 * One-time: refresh wet room capacity tile copy (shorter detail under the Wet room label).
 */
function restwell_migrate_property_wetroom_stat_copy_v9() {
	if ( get_option( 'restwell_property_wetroom_stat_copy_v9', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'the-property', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		update_option( 'restwell_property_wetroom_stat_copy_v9', '1' );
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
		update_option( 'restwell_property_feature_copy_balance_v1', '1' );
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
		update_option( 'restwell_accessibility_headings_v1', '1' );
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
		update_option( 'restwell_accessibility_intro_v2', '1' );
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

/**
 * One-time: update Who It's For page H1 and intro to shortened, keyword-leading versions.
 */
function restwell_migrate_who_its_for_headings_v1() {
	if ( get_option( 'restwell_who_its_for_headings_v1', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'who-its-for', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		update_option( 'restwell_who_its_for_headings_v1', '1' );
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
		update_option( 'restwell_property_headings_v1', '1' );
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

/**
 * One-time: update How It Works care CTA heading to shortened version.
 */
function restwell_migrate_how_it_works_headings_v1() {
	if ( get_option( 'restwell_how_it_works_headings_v1', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'how-it-works', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		update_option( 'restwell_how_it_works_headings_v1', '1' );
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

// ---------------------------------------------------------------------------
// Lede (hero intro paragraph) migrations — Job 9 copy swap.
// Priority band 30–38 on init / 20–28 on after_switch_theme.
// ---------------------------------------------------------------------------

/**
 * Stale => next map for the homepage hero_subheading lede.
 *
 * @return array<string, string>
 */
function restwell_get_home_lede_refresh_map() {
	$next = 'Wake up to the sea air in Whitstable and shape the day around your own clock. A step-free accessible holiday home with a ceiling track hoist, level-access wet room and optional CQC-regulated care: the whole house is yours.';
	return array(
		// Original 4-sentence seed (page-defaults + front-page.php fallback).
		'Wake up to the sea air in Whitstable and shape the day around your own clock. Restwell Retreats is a step-free, single-storey accessible holiday home on the Kent coast, ten minutes from the seafront, and the whole house is yours. There\'s a ceiling track hoist over the profiling bed, a level-access wet room already in place, and optional CQC-regulated care if you\'d like it. Come for a holiday or a respite break, and settle in at your own pace.' => $next,
	);
}

/**
 * One-time: refresh homepage hero lede to two-sentence version.
 */
function restwell_migrate_home_lede_v1() {
	if ( get_option( 'restwell_home_lede_v1', '' ) === '1' ) {
		return;
	}
	$home_id = (int) get_option( 'page_on_front', 0 );
	if ( $home_id < 1 ) {
		update_option( 'restwell_home_lede_v1', '1' );
		return;
	}
	foreach ( restwell_get_home_lede_refresh_map() as $stale => $next ) {
		$current = trim( (string) get_post_meta( $home_id, 'hero_subheading', true ) );
		if ( $current === $stale ) {
			update_post_meta( $home_id, 'hero_subheading', $next );
		}
	}
	update_option( 'restwell_home_lede_v1', '1' );
}

/**
 * Stale => next map for the property page prop_hero_subtitle lede.
 *
 * @return array<string, string>
 */
function restwell_get_property_lede_refresh_map() {
	$next = 'A single-storey wheelchair accessible bungalow in Whitstable, step-free throughout and fully fitted for access. Here is what each room has, so you can check whether it works for you before you enquire.';
	return array(
		'A newly adapted single-storey bungalow a few minutes from Tankerton Beach. Step-free throughout, with a full room coverage ceiling hoist, profiling beds and a level-access wet room.' => $next,
	);
}

/**
 * One-time: refresh property hero subtitle lede to two-sentence version.
 */
function restwell_migrate_property_lede_v1() {
	if ( get_option( 'restwell_property_lede_v1', '' ) === '1' ) {
		return;
	}
	$page = get_page_by_path( 'the-property', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		update_option( 'restwell_property_lede_v1', '1' );
		return;
	}
	$page_id = (int) $page->ID;
	foreach ( restwell_get_property_lede_refresh_map() as $stale => $next ) {
		$current = trim( (string) get_post_meta( $page_id, 'prop_hero_subtitle', true ) );
		if ( $current === $stale ) {
			update_post_meta( $page_id, 'prop_hero_subtitle', $next );
		}
	}
	update_option( 'restwell_property_lede_v1', '1' );
}

/**
 * Stale => next map for the Who It's For page wif_intro lede.
 *
 * @return array<string, string>
 */
function restwell_get_wif_lede_refresh_map() {
	$next = 'Restwell suits anyone planning an accessible holiday, from disabled guests and their carers to families, occupational therapists and commissioners. Open the section that fits your situation for honest detail on who the property works best for.';
	return array(
		// Pre-headings-v1 wording.
		'Restwell suits anyone who needs a step-free holiday with room to bring family, carers or friends. These are the guests we most often welcome, and the features that matter most to each.' => $next,
		// Post-headings-v1 wheelchair intro (set by restwell_migrate_who_its_for_headings_v1).
		'Restwell is a wheelchair-accessible holiday in Whitstable for anyone who needs a step-free stay with room to bring family, carers or friends. These are the guests we most often welcome, and the features that matter most to each.' => $next,
	);
}

/**
 * One-time: refresh Who It's For intro lede to two-sentence version.
 */
function restwell_migrate_wif_lede_v1() {
	if ( get_option( 'restwell_wif_lede_v1', '' ) === '1' ) {
		return;
	}
	$page = get_page_by_path( 'who-its-for', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		update_option( 'restwell_wif_lede_v1', '1' );
		return;
	}
	$page_id = (int) $page->ID;
	foreach ( restwell_get_wif_lede_refresh_map() as $stale => $next ) {
		$current = trim( (string) get_post_meta( $page_id, 'wif_intro', true ) );
		if ( $current === $stale ) {
			update_post_meta( $page_id, 'wif_intro', $next );
			break;
		}
	}
	update_option( 'restwell_wif_lede_v1', '1' );
}

/**
 * Stale => next map for the How It Works page hiw_intro lede.
 *
 * @return array<string, string>
 */
function restwell_get_hiw_lede_refresh_map() {
	$next = 'Booking an accessible holiday with optional care is more straightforward than it sounds. Here is what happens from your first question to arrival, and how care is arranged alongside your stay.';
	return array(
		'Booking a break should be the easy part. From your first enquiry to the morning you leave, we keep things clear and unhurried, so you know what\'s in the house, what care is available and how to pay.' => $next,
	);
}

/**
 * One-time: refresh How It Works intro lede to two-sentence version.
 */
function restwell_migrate_hiw_lede_v1() {
	if ( get_option( 'restwell_hiw_lede_v1', '' ) === '1' ) {
		return;
	}
	$page = get_page_by_path( 'how-it-works', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		update_option( 'restwell_hiw_lede_v1', '1' );
		return;
	}
	$page_id = (int) $page->ID;
	foreach ( restwell_get_hiw_lede_refresh_map() as $stale => $next ) {
		$current = trim( (string) get_post_meta( $page_id, 'hiw_intro', true ) );
		if ( $current === $stale ) {
			update_post_meta( $page_id, 'hiw_intro', $next );
		}
	}
	update_option( 'restwell_hiw_lede_v1', '1' );
}

/**
 * Stale => next map for the FAQ page faq_intro lede.
 *
 * @return array<string, string>
 */
function restwell_get_faq_lede_refresh_map() {
	$next = 'Short, plain answers to the questions we hear most before an enquiry. Accessibility, suitability, care, funding and what to do if your situation is not on the list.';
	return array(
		// page-defaults seed.
		'If you can\'t find the answer here, get in touch; we respond within 48 hours.' => $next,
		// template-faq.php inline fallback (differs from seed).
		'The questions we are asked most, in one place. For room-by-room measurements see the Accessibility page, and for paying for a stay see Funding and Support.' => $next,
	);
}

/**
 * One-time: refresh FAQ intro lede to two-sentence version.
 */
function restwell_migrate_faq_lede_v1() {
	if ( get_option( 'restwell_faq_lede_v1', '' ) === '1' ) {
		return;
	}
	$page = get_page_by_path( 'faq', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		update_option( 'restwell_faq_lede_v1', '1' );
		return;
	}
	$page_id = (int) $page->ID;
	foreach ( restwell_get_faq_lede_refresh_map() as $stale => $next ) {
		$current = trim( (string) get_post_meta( $page_id, 'faq_intro', true ) );
		if ( $current === $stale ) {
			update_post_meta( $page_id, 'faq_intro', $next );
			break;
		}
	}
	update_option( 'restwell_faq_lede_v1', '1' );
}

/**
 * Stale => next map for the Resources page res_intro lede.
 *
 * @return array<string, string>
 */
function restwell_get_resources_lede_refresh_map() {
	$next = 'Funding an accessible holiday in the UK is possible through several routes, even if you have been told otherwise. Here are the pathways that can help, with step-by-step guides for families, carers and commissioners.';
	return array(
		'There are several ways people pay for a break like this. The most common are direct payments, a personal budget under the Care Act, and NHS Continuing Healthcare. The right route depends on your circumstances, so treat this as a starting point and check the detail with your local authority or care team.' => $next,
	);
}

/**
 * One-time: refresh Resources intro lede to two-sentence version.
 */
function restwell_migrate_resources_lede_v1() {
	if ( get_option( 'restwell_resources_lede_v1', '' ) === '1' ) {
		return;
	}
	$page = get_page_by_path( 'resources', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		update_option( 'restwell_resources_lede_v1', '1' );
		return;
	}
	$page_id = (int) $page->ID;
	foreach ( restwell_get_resources_lede_refresh_map() as $stale => $next ) {
		$current = trim( (string) get_post_meta( $page_id, 'res_intro', true ) );
		if ( $current === $stale ) {
			update_post_meta( $page_id, 'res_intro', $next );
		}
	}
	update_option( 'restwell_resources_lede_v1', '1' );
}

/**
 * Stale => next map for the Whitstable area guide wg_intro lede.
 *
 * @return array<string, string>
 */
function restwell_get_wg_lede_refresh_map() {
	$next = 'Whitstable is a genuinely lovely town, and most of it is more accessible than it first appears. This guide covers the seafront, parking, eating out and quieter times, written for wheelchair users and visitors with access needs.';
	return array(
		'From the Tankerton promenade to harbour stops and day trips, here is what guests usually explore on a Restwell stay, with access notes woven in.' => $next,
	);
}

/**
 * One-time: refresh Whitstable area guide intro lede to two-sentence version.
 */
function restwell_migrate_wg_lede_v1() {
	if ( get_option( 'restwell_wg_lede_v1', '' ) === '1' ) {
		return;
	}
	$page = get_page_by_path( 'whitstable-area-guide', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		update_option( 'restwell_wg_lede_v1', '1' );
		return;
	}
	$page_id = (int) $page->ID;
	foreach ( restwell_get_wg_lede_refresh_map() as $stale => $next ) {
		$current = trim( (string) get_post_meta( $page_id, 'wg_intro', true ) );
		if ( $current === $stale ) {
			update_post_meta( $page_id, 'wg_intro', $next );
		}
	}
	update_option( 'restwell_wg_lede_v1', '1' );
}

/**
 * Stale => next map for the Enquire page enq_intro lede.
 *
 * @return array<string, string>
 */
function restwell_get_enq_lede_refresh_map() {
	$next = 'Tell us your dates, your access needs and anything specific to your situation. We will help you work out whether Restwell is the right fit, with no commitment until you are ready.';
	return array(
		// page-defaults seed.
		'Fill in the form and we\'ll call you back within 48 hours. No commitment, no hard sell: just a conversation.' => $next,
		// template-enquire.php inline fallback.
		'Whether you want to book an accessible holiday cottage in Kent or simply ask about a bathroom measurement, we are here to help. This is not a booking commitment: it is the start of a conversation. No pressure, no hard sell.' => $next,
	);
}

/**
 * One-time: refresh Enquire intro lede to two-sentence version.
 */
function restwell_migrate_enq_lede_v1() {
	if ( get_option( 'restwell_enq_lede_v1', '' ) === '1' ) {
		return;
	}
	$page = get_page_by_path( 'enquire', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		update_option( 'restwell_enq_lede_v1', '1' );
		return;
	}
	$page_id = (int) $page->ID;
	foreach ( restwell_get_enq_lede_refresh_map() as $stale => $next ) {
		$current = trim( (string) get_post_meta( $page_id, 'enq_intro', true ) );
		if ( $current === $stale ) {
			update_post_meta( $page_id, 'enq_intro', $next );
			break;
		}
	}
	update_option( 'restwell_enq_lede_v1', '1' );
}

/**
 * Stale => next map for the Blog index post_excerpt lede.
 *
 * @return array<string, string>
 */
function restwell_get_blog_lede_refresh_map() {
	$next = 'Guides and honest local information for accessible travel around Whitstable, the Kent coast and beyond. Written for wheelchair users, carers and anyone who needs a bit more detail before they go.';
	return array(
		// hub-pages seed.
		'Guides and stories: accessible travel, the Kent coast, funding routes, and updates from Restwell Retreats.' => $next,
		// index.php fallback when no excerpt is stored.
		'Practical guides to accessible travel on the Kent coast, local area information, and updates from Restwell.' => $next,
	);
}

/**
 * One-time: refresh Blog index post_excerpt lede to two-sentence version.
 */
function restwell_migrate_blog_lede_v1() {
	if ( get_option( 'restwell_blog_lede_v1', '' ) === '1' ) {
		return;
	}
	$blog_id = (int) get_option( 'page_for_posts', 0 );
	if ( $blog_id < 1 ) {
		$blog_page = get_page_by_path( 'blog', OBJECT, 'page' );
		$blog_id   = $blog_page ? (int) $blog_page->ID : 0;
	}
	if ( $blog_id < 1 ) {
		update_option( 'restwell_blog_lede_v1', '1' );
		return;
	}
	$next = 'Guides and honest local information for accessible travel around Whitstable, the Kent coast and beyond. Written for wheelchair users, carers and anyone who needs a bit more detail before they go.';
	foreach ( restwell_get_blog_lede_refresh_map() as $stale => $_ ) {
		$current = trim( (string) get_post_field( 'post_excerpt', $blog_id ) );
		if ( $current === $stale ) {
			wp_update_post(
				array(
					'ID'           => $blog_id,
					'post_excerpt' => $next,
				)
			);
			break;
		}
	}
	update_option( 'restwell_blog_lede_v1', '1' );
}

/**
 * One-time: lock Home / Property / Accessibility / How It Works / Who It's For into distinct keyword lanes.
 *
 * Updates focus_keyphrase, meta_title, meta_description, H1 and first-100-word ledes when they still
 * match the previous overlapping defaults. Pricing lives at /pricing/ (template-pricing.php).
 */
function restwell_migrate_keyword_lanes_v1() {
	if ( get_option( 'restwell_keyword_lanes_v1', '' ) === '1' ) {
		return;
	}

	if ( ! function_exists( 'restwell_get_seo_meta_defaults_by_slug' ) ) {
		update_option( 'restwell_keyword_lanes_v1', '1' );
		return;
	}

	$seo_map = restwell_get_seo_meta_defaults_by_slug();

	$pages = array(
		'home' => array(
			'front'    => true,
			'h1_key'   => 'hero_heading',
			'lede_key' => 'hero_subheading',
			'h1_stale' => array(
				'Accessible self-catering holidays in Whitstable, Kent',
				'Accessible Holidays in Whitstable, Kent',
				'Accessible holidays in Whitstable, Kent',
			),
			'lede_stale' => array(
				'Wake up to the sea air in Whitstable and shape the day around your own clock. A step-free accessible holiday home with a ceiling track hoist, level-access wet room and optional CQC-regulated care: the whole house is yours.',
				'Wake up to the sea air in Whitstable and shape the day around your own clock. Restwell Retreats is a step-free, single-storey accessible holiday home on the Kent coast, ten minutes from the seafront, and the whole house is yours. There\'s a ceiling track hoist over the profiling bed, a level-access wet room already in place, and optional CQC-regulated care if you\'d like it. Come for a holiday or a respite break, and settle in at your own pace.',
			),
			'kp_stale' => array(
				'accessible holidays whitstable',
			),
			'title_stale' => array(
				'Accessible Holidays in Whitstable, Kent | Restwell',
				'Accessible Holidays in Whitstable, Kent | Restwell Retreats',
			),
			'desc_stale' => array(
				'A step-free accessible holiday bungalow in Whitstable, Kent. Ceiling hoist, profiling bed and level-access wet room, with optional CQC-regulated care.',
			),
		),
		'the-property' => array(
			'path'     => 'the-property',
			'h1_key'   => 'prop_hero_heading',
			'lede_key' => 'prop_hero_subtitle',
			'h1_stale' => array(
				'An accessible bungalow in Whitstable',
				'An accessible bungalow in Whitstable, near the beach',
			),
			'lede_stale' => array(
				'A single-storey wheelchair accessible bungalow in Whitstable, step-free throughout and fully fitted for access. Here is what each room has, so you can check whether it works for you before you enquire.',
				'A newly adapted single-storey bungalow a few minutes from Tankerton Beach. Step-free throughout, with a full room coverage ceiling hoist, profiling beds and a level-access wet room.',
			),
			'kp_stale' => array(
				'accessible bungalow whitstable',
				'adapted bungalow whitstable',
			),
			'title_stale' => array(
				'Accessible bungalow in Whitstable | Restwell Retreats',
			),
			'desc_stale' => array(
				'A wheelchair-accessible, step-free bungalow in Whitstable. Ceiling hoist, profiling beds, level-access wet room and optional care, minutes from the sea.',
			),
		),
		'accessibility' => array(
			'path'     => 'accessibility',
			'h1_key'   => 'acc_heading',
			'lede_key' => 'acc_intro',
			'h1_stale' => array(
				'Our access statement, room by room',
			),
			'lede_stale' => array(
				'Our wheelchair-accessible Whitstable bungalow in detail: doorway widths, ceiling-track hoist and wet room measurements so you can decide whether the house works for you.',
			),
			'kp_stale' => array(
				'wheelchair accessible bungalow whitstable',
				'wheelchair accessible holiday cottage',
			),
			'title_stale' => array(
				'Access Statement | Step-Free Bungalow Whitstable | Restwell',
			),
			'desc_stale' => array(
				'Our full access statement: 965mm front and 926mm internal doorways, a ceiling track hoist, level-access wet room and step-free garden, described room by room.',
			),
		),
		'how-it-works' => array(
			'path'     => 'how-it-works',
			'h1_key'   => 'hiw_heading',
			'lede_key' => 'hiw_intro',
			'h1_stale' => array(
				'How to book an accessible holiday with care',
			),
			'lede_stale' => array(
				'Booking an accessible holiday with optional care is more straightforward than it sounds. Here is what happens from your first question to arrival, and how care is arranged alongside your stay.',
				'Booking a break should be the easy part. From your first enquiry to the morning you leave, we keep things clear and unhurried, so you know what\'s in the house, what care is available and how to pay.',
			),
			'kp_stale' => array(
				'book accessible holiday whitstable',
				'accessible stay',
			),
			'title_stale' => array(
				'How It Works | Booking an Accessible Holiday | Restwell',
			),
			'desc_stale' => array(
				'How to book an accessible self-catering break with Restwell in Whitstable. Share your access needs, add optional CQC-regulated care and pick your dates.',
			),
		),
		'who-its-for' => array(
			'path'     => 'who-its-for',
			'h1_key'   => 'wif_heading',
			'lede_key' => 'wif_intro',
			'h1_stale' => array(
				'Built for guests with access needs',
				'Built for guests with access needs, and everyone travelling with them',
			),
			'lede_stale' => array(
				'Restwell suits anyone planning an accessible holiday, from disabled guests and their carers to families, occupational therapists and commissioners. Open the section that fits your situation for honest detail on who the property works best for.',
				'Restwell suits anyone who needs a step-free holiday with room to bring family, carers or friends. These are the guests we most often welcome, and the features that matter most to each.',
				'Restwell is a wheelchair-accessible holiday in Whitstable for anyone who needs a step-free stay with room to bring family, carers or friends. These are the guests we most often welcome, and the features that matter most to each.',
			),
			'kp_stale' => array(
				'accessible holiday disabled guests carers',
				'accessible stay suitability',
			),
			'title_stale' => array(
				'Accessible Holidays for Disabled Guests & Carers | Restwell',
			),
			'desc_stale' => array(
				'Restwell welcomes wheelchair users, families and guests needing respite, with optional care. A calm, step-free Whitstable bungalow with room for carers too.',
			),
		),
	);

	$h1_next = array(
		'home'          => 'Accessible holidays Whitstable',
		'the-property'  => 'Accessible bungalow Whitstable',
		'accessibility' => 'Wheelchair accessible holiday cottage',
		'how-it-works'  => 'How your accessible stay works',
		'who-its-for'   => 'Accessible stay suitability',
	);

	$lede_next = array(
		'home'          => 'Restwell is the brand overview for accessible holidays Whitstable guests can plan with confidence. Start here, then follow links to the bungalow, the access statement, who the stay suits, and how booking works. Enquire when you are ready.',
		'the-property'  => 'This accessible bungalow Whitstable guests book for a private stay is single-storey and step-free throughout. Here is what each room has, what is included, and how the layout works before you enquire.',
		'accessibility' => 'This wheelchair accessible holiday cottage access statement covers the ceiling hoist, level-access wet room, door widths of 965mm at the front and 926mm inside, and parking, so you can judge fit before you book.',
		'how-it-works'  => 'An accessible stay at Restwell follows a clear booking process from first question to arrival. Share what you need, confirm dates, arrange optional care if you want it, then settle in.',
		'who-its-for'   => 'Use this accessible stay suitability guide to see whether Restwell fits your party: guests and families, carers and support workers, occupational therapists, and commissioners planning funded short breaks.',
	);

	foreach ( $pages as $slug => $cfg ) {
		$page_id = 0;
		if ( ! empty( $cfg['front'] ) ) {
			$page_id = (int) get_option( 'page_on_front', 0 );
		} else {
			$page    = get_page_by_path( (string) ( $cfg['path'] ?? '' ), OBJECT, 'page' );
			$page_id = $page ? (int) $page->ID : 0;
		}
		if ( $page_id < 1 || empty( $seo_map[ $slug ] ) ) {
			continue;
		}

		$target = $seo_map[ $slug ];

		$current_kp = trim( (string) get_post_meta( $page_id, 'focus_keyphrase', true ) );
		if ( $current_kp === '' || in_array( $current_kp, $cfg['kp_stale'], true ) ) {
			update_post_meta( $page_id, 'focus_keyphrase', $target['focus_keyphrase'] );
		}

		$current_title = trim( (string) get_post_meta( $page_id, 'meta_title', true ) );
		if ( $current_title === '' || in_array( $current_title, $cfg['title_stale'], true ) ) {
			update_post_meta( $page_id, 'meta_title', $target['meta_title'] );
		}

		$current_desc = trim( (string) get_post_meta( $page_id, 'meta_description', true ) );
		if ( $current_desc === '' || in_array( $current_desc, $cfg['desc_stale'], true ) ) {
			update_post_meta( $page_id, 'meta_description', $target['meta_description'] );
		}

		$h1_key     = (string) $cfg['h1_key'];
		$current_h1 = trim( (string) get_post_meta( $page_id, $h1_key, true ) );
		if ( $current_h1 === '' || in_array( $current_h1, $cfg['h1_stale'], true ) ) {
			update_post_meta( $page_id, $h1_key, $h1_next[ $slug ] );
		}

		$lede_key     = (string) $cfg['lede_key'];
		$current_lede = trim( (string) get_post_meta( $page_id, $lede_key, true ) );
		if ( $current_lede === '' || in_array( $current_lede, $cfg['lede_stale'], true ) ) {
			update_post_meta( $page_id, $lede_key, $lede_next[ $slug ] );
		}
	}

	update_option( 'restwell_keyword_lanes_v1', '1' );
}

/**
 * One-time: align guest guide check-in / check-out with booking docs (15:00 / 11:00).
 *
 * Only overwrites the old 2:00 pm / 11:00 am seed values so manual edits stay intact.
 */
function restwell_migrate_guest_guide_checkin_v1() {
	if ( get_option( 'restwell_guest_guide_checkin_v1', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'guest-guide', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		update_option( 'restwell_guest_guide_checkin_v1', '1' );
		return;
	}

	$page_id  = (int) $page->ID;
	$defaults = function_exists( 'restwell_get_guest_guide_page_defaults' )
		? restwell_get_guest_guide_page_defaults()
		: array(
			'gg_checkin_time'  => 'from 15:00',
			'gg_checkout_time' => 'by 11:00',
		);

	$checkin_stale = array(
		'2:00 pm',
		'2:00pm',
		'2 pm',
		'From 2:00 pm',
		'from 2:00 pm',
		'From 2 pm',
	);
	$checkout_stale = array(
		'11:00 am',
		'11:00am',
		'11 am',
		'By 11:00 am',
		'by 11:00 am',
		'By 11 am',
	);

	$current_in  = trim( (string) get_post_meta( $page_id, 'gg_checkin_time', true ) );
	$current_out = trim( (string) get_post_meta( $page_id, 'gg_checkout_time', true ) );
	$next_in     = trim( (string) ( $defaults['gg_checkin_time'] ?? 'from 15:00' ) );
	$next_out    = trim( (string) ( $defaults['gg_checkout_time'] ?? 'by 11:00' ) );

	if ( $next_in !== '' && ( $current_in === '' || in_array( $current_in, $checkin_stale, true ) ) ) {
		update_post_meta( $page_id, 'gg_checkin_time', $next_in );
	}
	if ( $next_out !== '' && ( $current_out === '' || in_array( $current_out, $checkout_stale, true ) ) ) {
		update_post_meta( $page_id, 'gg_checkout_time', $next_out );
	}

	update_option( 'restwell_guest_guide_checkin_v1', '1' );
}

/**
 * One-time: replace stale "six weeks before arrival" balance wording in stored Terms body.
 *
 * Theme fallback already uses restwell_get_terms_payment_paragraph() (one-week rule).
 * This only rewrites legal_body_html when it still contains the outdated six-week phrase.
 */
function restwell_migrate_terms_balance_one_week_v1() {
	if ( get_option( 'restwell_terms_balance_one_week_v1', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'terms-and-conditions', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		update_option( 'restwell_terms_balance_one_week_v1', '1' );
		return;
	}

	$page_id = (int) $page->ID;
	$body    = (string) get_post_meta( $page_id, 'legal_body_html', true );
	if ( $body === '' ) {
		update_option( 'restwell_terms_balance_one_week_v1', '1' );
		return;
	}

	$replacements = array(
		'six weeks before arrival'  => 'one week before arrival',
		'Six weeks before arrival'  => 'One week before arrival',
		'six weeks before you arrive' => 'one week before you arrive',
		'no later than six weeks before arrival' => 'no later than one week before arrival',
		'no later than six weeks before you arrive' => 'no later than one week before you arrive',
	);

	$updated = str_replace( array_keys( $replacements ), array_values( $replacements ), $body );
	if ( $updated !== $body ) {
		update_post_meta( $page_id, 'legal_body_html', $updated );
	}

	update_option( 'restwell_terms_balance_one_week_v1', '1' );
}

/**
 * One-time: refresh Pricing page hero intro / subheading when still on Job 11 launch defaults.
 */
function restwell_migrate_pricing_hero_copy_v1() {
	if ( get_option( 'restwell_pricing_hero_copy_v1', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'pricing', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		update_option( 'restwell_pricing_hero_copy_v1', '1' );
		return;
	}

	$page_id  = (int) $page->ID;
	$defaults = function_exists( 'restwell_get_pricing_page_defaults' )
		? restwell_get_pricing_page_defaults()
		: array();

	$stale_intro = 'Restwell Retreats is a step-free, single-storey bungalow in Whitstable, and when you book it, the whole house is yours. Every piece of access equipment is part of the price, so there are no surprise hire fees waiting for you on arrival. This page explains exactly what is included, how payment works, the three funding routes our guests use most, and what else you might want to budget for. If anything here is unclear, we are always happy to talk it through before you commit.';

	$current_intro = trim( (string) get_post_meta( $page_id, 'pricing_intro', true ) );
	$next_intro    = isset( $defaults['pricing_intro'] ) ? (string) $defaults['pricing_intro'] : '';
	if ( $next_intro !== '' && ( $current_intro === '' || $current_intro === $stale_intro ) ) {
		update_post_meta( $page_id, 'pricing_intro', $next_intro );
	}

	$current_sub = trim( (string) get_post_meta( $page_id, 'pricing_subheading', true ) );
	$next_sub    = isset( $defaults['pricing_subheading'] ) ? (string) $defaults['pricing_subheading'] : '';
	if ( $next_sub !== '' && $current_sub === '' ) {
		update_post_meta( $page_id, 'pricing_subheading', $next_sub );
	}

	$current_promise = trim( (string) get_post_meta( $page_id, 'pricing_hero_cta_promise', true ) );
	$next_promise    = isset( $defaults['pricing_hero_cta_promise'] ) ? (string) $defaults['pricing_hero_cta_promise'] : '';
	if ( $next_promise !== '' && $current_promise === '' ) {
		update_post_meta( $page_id, 'pricing_hero_cta_promise', $next_promise );
	}

	update_option( 'restwell_pricing_hero_copy_v1', '1' );
}

/**
 * One-time: correct Pricing intro + FAQ that implied all equipment (including hired extras) is free.
 */
function restwell_migrate_pricing_equipment_hire_copy_v1() {
	if ( get_option( 'restwell_pricing_equipment_hire_copy_v1', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'pricing', OBJECT, 'page' );
	if ( ! $page || (int) $page->ID < 1 ) {
		update_option( 'restwell_pricing_equipment_hire_copy_v1', '1' );
		return;
	}

	$page_id  = (int) $page->ID;
	$defaults = function_exists( 'restwell_get_pricing_page_defaults' )
		? restwell_get_pricing_page_defaults()
		: array();

	$stale_intros = array(
		'Restwell Retreats is a step-free, single-storey bungalow in Whitstable, and when you book it, the whole house is yours. Every piece of access equipment is part of the price, so there are no surprise hire fees waiting for you on arrival. This page explains exactly what is included, how payment works, the three funding routes our guests use most, and what else you might want to budget for. If anything here is unclear, we are always happy to talk it through before you commit.',
		'Restwell Retreats is a step-free, single-storey bungalow in Whitstable, and when you book it, the whole house is yours. Every piece of access equipment is included in the price, so there are no surprise hire fees. This page explains what is included, how payment works, common funding routes, and what else to budget for. If anything is unclear, we are always happy to talk it through before you book.',
	);
	$next_intro = isset( $defaults['pricing_intro'] ) ? (string) $defaults['pricing_intro'] : '';
	$current_intro = trim( (string) get_post_meta( $page_id, 'pricing_intro', true ) );
	if ( $next_intro !== '' && ( $current_intro === '' || in_array( $current_intro, $stale_intros, true ) ) ) {
		update_post_meta( $page_id, 'pricing_intro', $next_intro );
	}

	$stale_faq = array(
		1 => 'You book the whole step-free bungalow in Whitstable, with all access equipment included. A full week starts at £1,300 off-peak and £1,400 in peak season, with single nights from £185. A 50% deposit secures your dates and the balance is due one week before arrival.',
		2 => 'No. The price covers the whole bungalow and all its access equipment. Care is optional and quoted separately through our sister company, Continuity of Care Services.',
		3 => 'No. The hoists, profiling beds and wet room equipment are part of the price, with no separate hire fees.',
	);
	foreach ( $stale_faq as $i => $old_a ) {
		$key = "pricing_faq_{$i}_a";
		$cur = trim( (string) get_post_meta( $page_id, $key, true ) );
		if ( $cur === $old_a && isset( $defaults[ $key ] ) ) {
			update_post_meta( $page_id, $key, $defaults[ $key ] );
		}
	}

	update_option( 'restwell_pricing_equipment_hire_copy_v1', '1' );
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
		'restwell_keyword_lanes_v1',
		'restwell_guest_guide_checkin_v1',
		'restwell_terms_balance_one_week_v1',
		'restwell_pricing_hero_copy_v1',
		'restwell_pricing_equipment_hire_copy_v1',
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

	add_action( 'admin_init', 'restwell_migrate_homepage_faq_meta_v1', 5 );
	add_action( 'after_switch_theme', 'restwell_migrate_homepage_faq_meta_v1', 10 );
	add_action( 'init', 'restwell_migrate_property_practical_meta_v1', 20 );
	add_action( 'after_switch_theme', 'restwell_migrate_property_practical_meta_v1', 10 );
	add_action( 'init', 'restwell_migrate_property_sleeps_five_v1', 21 );
	add_action( 'after_switch_theme', 'restwell_migrate_property_sleeps_five_v1', 11 );
	add_action( 'init', 'restwell_migrate_property_parking_short_v1', 22 );
	add_action( 'after_switch_theme', 'restwell_migrate_property_parking_short_v1', 12 );
	add_action( 'init', 'restwell_migrate_property_bedrooms_parking_v2', 23 );
	add_action( 'after_switch_theme', 'restwell_migrate_property_bedrooms_parking_v2', 13 );
	add_action( 'init', 'restwell_migrate_property_parking_detail_v3', 24 );
	add_action( 'after_switch_theme', 'restwell_migrate_property_parking_detail_v3', 14 );
	add_action( 'init', 'restwell_migrate_property_headings_v4', 25 );
	add_action( 'after_switch_theme', 'restwell_migrate_property_headings_v4', 15 );
	add_action( 'init', 'restwell_migrate_property_labels_v5', 26 );
	add_action( 'after_switch_theme', 'restwell_migrate_property_labels_v5', 16 );
	add_action( 'init', 'restwell_migrate_property_wetroom_stat_v6', 27 );
	add_action( 'after_switch_theme', 'restwell_migrate_property_wetroom_stat_v6', 17 );
	add_action( 'init', 'restwell_migrate_property_wetroom_walkthrough_v7', 28 );
	add_action( 'after_switch_theme', 'restwell_migrate_property_wetroom_walkthrough_v7', 18 );
	add_action( 'init', 'restwell_migrate_homepage_cta_testword_v8', 29 );
	add_action( 'after_switch_theme', 'restwell_migrate_homepage_cta_testword_v8', 19 );
	add_action( 'init', 'restwell_migrate_property_wetroom_stat_copy_v9', 30 );
	add_action( 'after_switch_theme', 'restwell_migrate_property_wetroom_stat_copy_v9', 20 );
	add_action( 'init', 'restwell_migrate_faq_access_parking_bedrooms_v1', 24 );
	add_action( 'after_switch_theme', 'restwell_migrate_faq_access_parking_bedrooms_v1', 14 );
	add_action( 'init', 'restwell_migrate_property_feature_copy_balance_v1', 25 );
	add_action( 'after_switch_theme', 'restwell_migrate_property_feature_copy_balance_v1', 15 );
	add_action( 'init', 'restwell_migrate_home_hiw_card_copy_balance_v1', 26 );
	add_action( 'after_switch_theme', 'restwell_migrate_home_hiw_card_copy_balance_v1', 16 );
	add_action( 'init', 'restwell_migrate_legal_policy_templates_v1', 12 );
	add_action( 'after_switch_theme', 'restwell_migrate_legal_policy_templates_v1', 12 );
	add_action( 'init', 'restwell_migrate_accessibility_headings_v1', 25 );
	add_action( 'after_switch_theme', 'restwell_migrate_accessibility_headings_v1', 15 );
	add_action( 'init', 'restwell_migrate_accessibility_intro_v2', 26 );
	add_action( 'after_switch_theme', 'restwell_migrate_accessibility_intro_v2', 16 );
	add_action( 'init', 'restwell_migrate_who_its_for_headings_v1', 27 );
	add_action( 'after_switch_theme', 'restwell_migrate_who_its_for_headings_v1', 17 );
	add_action( 'init', 'restwell_migrate_property_headings_v1', 28 );
	add_action( 'after_switch_theme', 'restwell_migrate_property_headings_v1', 18 );
	add_action( 'init', 'restwell_migrate_how_it_works_headings_v1', 29 );
	add_action( 'after_switch_theme', 'restwell_migrate_how_it_works_headings_v1', 19 );
	add_action( 'init', 'restwell_migrate_home_lede_v1', 30 );
	add_action( 'after_switch_theme', 'restwell_migrate_home_lede_v1', 20 );
	add_action( 'init', 'restwell_migrate_property_lede_v1', 31 );
	add_action( 'after_switch_theme', 'restwell_migrate_property_lede_v1', 21 );
	add_action( 'init', 'restwell_migrate_wif_lede_v1', 32 );
	add_action( 'after_switch_theme', 'restwell_migrate_wif_lede_v1', 22 );
	add_action( 'init', 'restwell_migrate_hiw_lede_v1', 33 );
	add_action( 'after_switch_theme', 'restwell_migrate_hiw_lede_v1', 23 );
	add_action( 'init', 'restwell_migrate_faq_lede_v1', 34 );
	add_action( 'after_switch_theme', 'restwell_migrate_faq_lede_v1', 24 );
	add_action( 'init', 'restwell_migrate_resources_lede_v1', 35 );
	add_action( 'after_switch_theme', 'restwell_migrate_resources_lede_v1', 25 );
	add_action( 'init', 'restwell_migrate_wg_lede_v1', 36 );
	add_action( 'after_switch_theme', 'restwell_migrate_wg_lede_v1', 26 );
	add_action( 'init', 'restwell_migrate_enq_lede_v1', 37 );
	add_action( 'after_switch_theme', 'restwell_migrate_enq_lede_v1', 27 );
	add_action( 'init', 'restwell_migrate_blog_lede_v1', 38 );
	add_action( 'after_switch_theme', 'restwell_migrate_blog_lede_v1', 28 );
	add_action( 'init', 'restwell_migrate_keyword_lanes_v1', 39 );
	add_action( 'after_switch_theme', 'restwell_migrate_keyword_lanes_v1', 29 );
	add_action( 'init', 'restwell_migrate_guest_guide_checkin_v1', 40 );
	add_action( 'after_switch_theme', 'restwell_migrate_guest_guide_checkin_v1', 30 );
	add_action( 'init', 'restwell_migrate_terms_balance_one_week_v1', 41 );
	add_action( 'after_switch_theme', 'restwell_migrate_terms_balance_one_week_v1', 31 );
	add_action( 'init', 'restwell_migrate_pricing_hero_copy_v1', 42 );
	add_action( 'after_switch_theme', 'restwell_migrate_pricing_hero_copy_v1', 32 );
	add_action( 'init', 'restwell_migrate_pricing_equipment_hire_copy_v1', 43 );
	add_action( 'after_switch_theme', 'restwell_migrate_pricing_equipment_hire_copy_v1', 33 );

	add_action( 'init', 'restwell_maybe_mark_schema_current', 100 );
	add_action( 'admin_init', 'restwell_maybe_mark_schema_current', 100 );
	add_action( 'after_switch_theme', 'restwell_maybe_mark_schema_current', 100 );
}
restwell_register_content_migrations();
