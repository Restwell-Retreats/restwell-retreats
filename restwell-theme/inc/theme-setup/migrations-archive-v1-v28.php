<?php
/**
 * Frozen content migrations v1–v28.
 *
 * Loaded only when restwell_schema_version is below 29.
 * Do not add new migrate_* functions here.
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
	$next = 'Accessible holiday tips, guest stories, what’s on around Whitstable, and practical updates for wheelchair users, carers and anyone planning a respite break.';
	return array(
		// hub-pages seed (previous).
		'Guides and honest local information for accessible travel around Whitstable, the Kent coast and beyond. Written for wheelchair users, carers and anyone who needs a bit more detail before they go.' => $next,
		// hub-pages seed (older).
		'Guides and stories: accessible travel, the Kent coast, funding routes, and updates from Restwell Retreats.' => $next,
		// index.php fallback when no excerpt is stored.
		'Practical guides to accessible travel on the Kent coast, local area information, and updates from Restwell.' => $next,
		'Access notes for Whitstable and the Kent coast, written for wheelchair users, carers and anyone planning a disability-friendly holiday or a funded stay.' => $next,
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
	$next = 'Accessible holiday tips, guest stories, what’s on around Whitstable, and practical updates for wheelchair users, carers and anyone planning a respite break.';
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
 * Broaden blog index H1/lede beyond “Accessible travel guides”.
 */
function restwell_migrate_blog_index_copy_v2() {
	if ( get_option( 'restwell_blog_index_copy_v2', '' ) === '1' ) {
		return;
	}

	$blog_id = (int) get_option( 'page_for_posts', 0 );
	if ( $blog_id < 1 ) {
		$blog_page = get_page_by_path( 'blog', OBJECT, 'page' );
		$blog_id   = $blog_page ? (int) $blog_page->ID : 0;
	}

	$next = 'Accessible holiday tips, guest stories, what’s on around Whitstable, and practical updates for wheelchair users, carers and anyone planning a respite break.';

	if ( $blog_id > 0 ) {
		$current = trim( (string) get_post_field( 'post_excerpt', $blog_id ) );
		$stale   = array_keys( restwell_get_blog_lede_refresh_map() );
		$stale[] = '';
		if ( in_array( $current, $stale, true ) || $current !== $next ) {
			// Only overwrite known stale / empty / previous broadened-but-guides ledes.
			$overwrite = ( $current === '' || isset( restwell_get_blog_lede_refresh_map()[ $current ] ) || str_contains( $current, 'accessible travel' ) || str_contains( $current, 'Access notes for Whitstable' ) );
			if ( $overwrite ) {
				wp_update_post(
					array(
						'ID'           => $blog_id,
						'post_excerpt' => $next,
					)
				);
			}
		}

		// Clear SEO meta title/description so theme defaults / seed can re-apply broader copy when empty after delete.
		$old_titles = array(
			'Accessible Travel Blog | Kent Stories | Restwell Retreats',
			'Accessible travel blog',
		);
		$meta_title = (string) get_post_meta( $blog_id, 'meta_title', true );
		foreach ( $old_titles as $old ) {
			if ( $meta_title === $old || str_contains( $meta_title, 'Accessible Travel Blog' ) ) {
				delete_post_meta( $blog_id, 'meta_title' );
				break;
			}
		}
		$meta_desc = (string) get_post_meta( $blog_id, 'meta_description', true );
		if ( str_contains( $meta_desc, 'Accessible travel and Kent coast guides' ) || str_contains( $meta_desc, 'Accessible travel guides, Kent coast tips' ) ) {
			delete_post_meta( $blog_id, 'meta_description' );
		}
	}

	update_option( 'restwell_blog_index_copy_v2', '1' );
}

/**
 * De-brand stored meta titles, fill Our Story / Optional care SEO, refresh stale titles.
 */
function restwell_migrate_seo_titles_meta_v3() {
	if ( get_option( 'restwell_seo_titles_meta_v3', '' ) === '1' ) {
		return;
	}

	if ( ! function_exists( 'restwell_get_seo_meta_defaults_by_slug' ) ) {
		update_option( 'restwell_seo_titles_meta_v3', '1' );
		return;
	}

	$defaults = restwell_get_seo_meta_defaults_by_slug();
	$force_slugs = array(
		'who-its-for',
		'resources',
		'enquire',
		'privacy-policy',
		'terms-and-conditions',
		'accessibility-policy',
		'our-story',
		'optional-care',
		'blog',
		'faq',
		'how-it-works',
		'home',
		'the-property',
		'accessibility',
		'pricing',
		'whitstable-area-guide',
		'guest-guide',
	);

	foreach ( $force_slugs as $slug ) {
		if ( empty( $defaults[ $slug ] ) ) {
			continue;
		}
		$page = get_page_by_path( $slug, OBJECT, 'page' );
		if ( ! $page || (int) $page->ID < 1 ) {
			continue;
		}
		$pid = (int) $page->ID;
		$seo = $defaults[ $slug ];

		$current_title = (string) get_post_meta( $pid, 'meta_title', true );
		$stale_title   = (
			$current_title === ''
			|| str_contains( $current_title, '| Restwell' )
			|| str_contains( $current_title, '– Restwell' )
			|| str_contains( $current_title, 'Restwell Retreats' )
			|| str_contains( $current_title, 'Who It Fits' )
			|| str_contains( $current_title, 'Contact & Enquire | Restwell' )
		);
		if ( $stale_title && $seo['meta_title'] !== '' ) {
			update_post_meta( $pid, 'meta_title', $seo['meta_title'] );
		}

		$current_desc = (string) get_post_meta( $pid, 'meta_description', true );
		$thin_or_generic = (
			$current_desc === ''
			|| strlen( $current_desc ) < 110
			|| str_contains( $current_desc, 'practical accessibility and holiday-planning guidance' )
		);
		if ( $thin_or_generic && $seo['meta_description'] !== '' ) {
			update_post_meta( $pid, 'meta_description', $seo['meta_description'] );
		}

		if ( $seo['focus_keyphrase'] !== '' && (string) get_post_meta( $pid, 'focus_keyphrase', true ) === '' ) {
			update_post_meta( $pid, 'focus_keyphrase', $seo['focus_keyphrase'] );
		}
	}

	update_option( 'restwell_seo_titles_meta_v3', '1' );
}

/**
 * Excellence pass: retarget marketing SEO titles/descriptions into 50–60 / 150–160 bands.
 */
function restwell_migrate_seo_titles_meta_v4() {
	if ( get_option( 'restwell_seo_titles_meta_v4', '' ) === '1' ) {
		return;
	}

	if ( ! function_exists( 'restwell_get_seo_meta_defaults_by_slug' ) ) {
		update_option( 'restwell_seo_titles_meta_v4', '1' );
		return;
	}

	$defaults = restwell_get_seo_meta_defaults_by_slug();
	$force_slugs = array(
		'who-its-for',
		'resources',
		'enquire',
		'privacy-policy',
		'terms-and-conditions',
		'accessibility-policy',
		'our-story',
		'optional-care',
		'blog',
		'faq',
		'how-it-works',
		'home',
		'the-property',
		'accessibility',
		'pricing',
		'whitstable-area-guide',
	);

	foreach ( $force_slugs as $slug ) {
		if ( empty( $defaults[ $slug ] ) ) {
			continue;
		}
		$page = get_page_by_path( $slug, OBJECT, 'page' );
		if ( ! $page || (int) $page->ID < 1 ) {
			continue;
		}
		$pid = (int) $page->ID;
		$seo = $defaults[ $slug ];

		if ( $seo['meta_title'] !== '' ) {
			update_post_meta( $pid, 'meta_title', $seo['meta_title'] );
		}
		if ( $seo['meta_description'] !== '' ) {
			update_post_meta( $pid, 'meta_description', $seo['meta_description'] );
		}
		if ( $seo['focus_keyphrase'] !== '' ) {
			update_post_meta( $pid, 'focus_keyphrase', $seo['focus_keyphrase'] );
		}
	}

	update_option( 'restwell_seo_titles_meta_v4', '1' );
}

/**
 * Front-page title excellence: WP often omits the site name on the home document title.
 * Also re-applies accessibility-policy description into the 150–160 band.
 */
function restwell_migrate_seo_home_title_v5() {
	if ( get_option( 'restwell_seo_home_title_v5', '' ) === '1' ) {
		return;
	}

	if ( ! function_exists( 'restwell_get_seo_meta_defaults_by_slug' ) ) {
		update_option( 'restwell_seo_home_title_v5', '1' );
		return;
	}

	$defaults = restwell_get_seo_meta_defaults_by_slug();
	$home     = $defaults['home'] ?? null;
	$front_id = (int) get_option( 'page_on_front', 0 );
	if ( $front_id > 0 && is_array( $home ) && ! empty( $home['meta_title'] ) ) {
		update_post_meta( $front_id, 'meta_title', $home['meta_title'] );
		if ( ! empty( $home['meta_description'] ) ) {
			update_post_meta( $front_id, 'meta_description', $home['meta_description'] );
		}
	}

	$a11y = $defaults['accessibility-policy'] ?? null;
	$page = get_page_by_path( 'accessibility-policy', OBJECT, 'page' );
	if ( $page && is_array( $a11y ) && ! empty( $a11y['meta_description'] ) ) {
		update_post_meta( (int) $page->ID, 'meta_description', $a11y['meta_description'] );
		if ( ! empty( $a11y['meta_title'] ) ) {
			update_post_meta( (int) $page->ID, 'meta_title', $a11y['meta_title'] );
		}
	}

	update_option( 'restwell_seo_home_title_v5', '1' );
}

/**
 * Re-apply accessibility-policy meta into the 150–160 description band.
 */
function restwell_migrate_seo_a11y_policy_meta_v6() {
	if ( get_option( 'restwell_seo_a11y_policy_meta_v6', '' ) === '1' ) {
		return;
	}

	if ( ! function_exists( 'restwell_get_seo_meta_defaults_by_slug' ) ) {
		update_option( 'restwell_seo_a11y_policy_meta_v6', '1' );
		return;
	}

	$defaults = restwell_get_seo_meta_defaults_by_slug();
	$a11y     = $defaults['accessibility-policy'] ?? null;
	$page     = get_page_by_path( 'accessibility-policy', OBJECT, 'page' );
	if ( $page && is_array( $a11y ) ) {
		if ( ! empty( $a11y['meta_title'] ) ) {
			update_post_meta( (int) $page->ID, 'meta_title', $a11y['meta_title'] );
		}
		if ( ! empty( $a11y['meta_description'] ) ) {
			update_post_meta( (int) $page->ID, 'meta_description', $a11y['meta_description'] );
		}
	}

	update_option( 'restwell_seo_a11y_policy_meta_v6', '1' );
}

/**
 * Cannibalisation retarget: how-it-works + faq focus/title/description lanes.
 */
function restwell_migrate_seo_cannibal_lanes_v7() {
	if ( get_option( 'restwell_seo_cannibal_lanes_v7', '' ) === '1' ) {
		return;
	}

	if ( ! function_exists( 'restwell_get_seo_meta_defaults_by_slug' ) ) {
		update_option( 'restwell_seo_cannibal_lanes_v7', '1' );
		return;
	}

	$defaults = restwell_get_seo_meta_defaults_by_slug();
	foreach ( array( 'how-it-works', 'faq' ) as $slug ) {
		if ( empty( $defaults[ $slug ] ) ) {
			continue;
		}
		$page = get_page_by_path( $slug, OBJECT, 'page' );
		if ( ! $page || (int) $page->ID < 1 ) {
			continue;
		}
		$pid = (int) $page->ID;
		$seo = $defaults[ $slug ];
		if ( $seo['meta_title'] !== '' ) {
			update_post_meta( $pid, 'meta_title', $seo['meta_title'] );
		}
		if ( $seo['meta_description'] !== '' ) {
			update_post_meta( $pid, 'meta_description', $seo['meta_description'] );
		}
		if ( $seo['focus_keyphrase'] !== '' ) {
			update_post_meta( $pid, 'focus_keyphrase', $seo['focus_keyphrase'] );
		}
		if ( 'how-it-works' === $slug ) {
			update_post_meta( $pid, 'hiw_heading', 'How accessible holiday booking works' );
			$intro = 'An accessible holiday booking process with Restwell starts at enquiry: share access needs, confirm dates, arrange optional care if you want it, then settle in.';
			update_post_meta( $pid, 'hiw_intro', $intro );
		}
	}

	update_option( 'restwell_seo_cannibal_lanes_v7', '1' );
}

/**
 * Cannibalisation harden: property rooms/kit title + H1; accessibility access-statement H1.
 * Resources hub→spoke links ship in template-resources.php (no meta rewrite).
 */
function restwell_migrate_seo_cannibal_medium_v8() {
	if ( get_option( 'restwell_seo_cannibal_medium_v8', '' ) === '1' ) {
		return;
	}

	if ( ! function_exists( 'restwell_get_seo_meta_defaults_by_slug' ) ) {
		update_option( 'restwell_seo_cannibal_medium_v8', '1' );
		return;
	}

	$defaults = restwell_get_seo_meta_defaults_by_slug();

	$property = get_page_by_path( 'the-property', OBJECT, 'page' );
	if ( $property && (int) $property->ID > 0 && ! empty( $defaults['the-property'] ) ) {
		$pid = (int) $property->ID;
		$seo = $defaults['the-property'];
		if ( $seo['meta_title'] !== '' ) {
			update_post_meta( $pid, 'meta_title', $seo['meta_title'] );
		}
		if ( $seo['meta_description'] !== '' ) {
			update_post_meta( $pid, 'meta_description', $seo['meta_description'] );
		}
		if ( $seo['focus_keyphrase'] !== '' ) {
			update_post_meta( $pid, 'focus_keyphrase', $seo['focus_keyphrase'] );
		}

		$prop_h1_stale = array(
			'Accessible bungalow Whitstable',
			'An accessible bungalow in Whitstable',
			'An accessible bungalow in Whitstable, near the beach',
			'Inside the accessible bungalow in Whitstable',
		);
		$prop_h1 = trim( (string) get_post_meta( $pid, 'prop_hero_heading', true ) );
		if ( '' === $prop_h1 || in_array( $prop_h1, $prop_h1_stale, true ) ) {
			update_post_meta( $pid, 'prop_hero_heading', 'Accessible bungalow: rooms, wet room and kit' );
		}
	}

	$accessibility = get_page_by_path( 'accessibility', OBJECT, 'page' );
	if ( $accessibility && (int) $accessibility->ID > 0 ) {
		$aid = (int) $accessibility->ID;
		$acc_h1_stale = array(
			'Wheelchair accessible holiday cottage',
			'A wheelchair accessible holiday cottage in Whitstable',
			'Our access statement, room by room',
		);
		$acc_h1 = trim( (string) get_post_meta( $aid, 'acc_heading', true ) );
		if ( '' === $acc_h1 || in_array( $acc_h1, $acc_h1_stale, true ) ) {
			update_post_meta( $aid, 'acc_heading', 'Access statement: hoist, wet room, door widths' );
		}
	}

	update_option( 'restwell_seo_cannibal_medium_v8', '1' );
}

/**
 * Cannibalisation low polish: refresh access-statement post body (Restwell example links).
 * Whitstable hub→spoke related guides ship in template-whitstable-guide.php.
 */
function restwell_migrate_seo_cannibal_low_v9() {
	if ( get_option( 'restwell_seo_cannibal_low_v9', '' ) === '1' ) {
		return;
	}

	$posts = get_posts(
		array(
			'name'                   => 'how-to-read-holiday-cottage-access-statement',
			'post_type'              => 'post',
			'post_status'            => 'any',
			'posts_per_page'         => 1,
			'fields'                 => 'ids',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
		)
	);

	if ( empty( $posts ) ) {
		update_option( 'restwell_seo_cannibal_low_v9', '1' );
		return;
	}

	$post_id = (int) $posts[0];
	$content = (string) get_post_field( 'post_content', $post_id );
	if ( '' === $content ) {
		update_option( 'restwell_seo_cannibal_low_v9', '1' );
		return;
	}

	if ( false !== strpos( $content, 'A worked Restwell example' ) ) {
		update_option( 'restwell_seo_cannibal_low_v9', '1' );
		return;
	}

	if ( function_exists( 'restwell_get_blog_post_read_access_statement_html' ) ) {
		$fresh = restwell_get_blog_post_read_access_statement_html();
		if ( is_string( $fresh ) && '' !== $fresh ) {
			wp_update_post(
				array(
					'ID'           => $post_id,
					'post_content' => wp_kses_post( $fresh ),
				)
			);
		}
	}

	update_option( 'restwell_seo_cannibal_low_v9', '1' );
}

/**
 * Leave WordPress Sample Page as a demo stub: noindex + exclude from SEO lanes.
 */
function restwell_migrate_sample_page_demo_v10() {
	if ( get_option( 'restwell_sample_page_demo_v10', '' ) === '1' ) {
		return;
	}

	$page = get_page_by_path( 'sample-page', OBJECT, 'page' );
	if ( $page && (int) $page->ID > 0 ) {
		update_post_meta( (int) $page->ID, 'meta_noindex', 1 );
	}

	update_option( 'restwell_sample_page_demo_v10', '1' );
}

/**
 * One-time: trash retired / WordPress demo content so it cannot linger in SEO → All pages.
 *
 * Contact is a retired URL (301 to enquire). Sample Page and Hello world! are install stubs.
 */
function restwell_migrate_retire_demo_content_v11() {
	if ( get_option( 'restwell_retire_demo_content_v11', '' ) === '1' ) {
		return;
	}

	$trash = static function ( $post ) {
		if ( $post instanceof WP_Post && (int) $post->ID > 0 && 'trash' !== $post->post_status ) {
			wp_trash_post( (int) $post->ID );
		}
	};

	$trash( get_page_by_path( 'contact', OBJECT, 'page' ) );
	$trash( get_page_by_path( 'sample-page', OBJECT, 'page' ) );

	$hello = get_page_by_path( 'hello-world', OBJECT, 'post' );
	if ( $hello instanceof WP_Post && 'Hello world!' === $hello->post_title ) {
		$trash( $hello );
	}

	update_option( 'restwell_retire_demo_content_v11', '1' );
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
 * Put focus keyphrase into Blog + Who It’s For SEO titles.
 */
function restwell_migrate_seo_kp_titles_v12() {
	if ( get_option( 'restwell_seo_kp_titles_v12', '' ) === '1' ) {
		return;
	}

	if ( ! function_exists( 'restwell_get_seo_meta_defaults_by_slug' ) ) {
		update_option( 'restwell_seo_kp_titles_v12', '1' );
		return;
	}

	$defaults = restwell_get_seo_meta_defaults_by_slug();

	foreach ( array( 'who-its-for', 'blog' ) as $slug ) {
		if ( empty( $defaults[ $slug ]['meta_title'] ) ) {
			continue;
		}
		$page_id = 0;
		if ( 'blog' === $slug ) {
			$page_id = (int) get_option( 'page_for_posts', 0 );
		}
		if ( $page_id < 1 ) {
			$page    = get_page_by_path( $slug, OBJECT, 'page' );
			$page_id = $page ? (int) $page->ID : 0;
		}
		if ( $page_id < 1 ) {
			continue;
		}
		update_post_meta( $page_id, 'meta_title', $defaults[ $slug ]['meta_title'] );
	}

	update_option( 'restwell_seo_kp_titles_v12', '1' );
}

/**
 * Sideload OG stock map into Media and set Featured/hero/OG when empty.
 */
function restwell_migrate_page_hero_stock_v13() {
	if ( get_option( 'restwell_page_hero_stock_v13', '' ) === '1' ) {
		return;
	}

	if ( function_exists( 'restwell_seed_page_hero_stock_images' ) ) {
		restwell_seed_page_hero_stock_images();
	}

	update_option( 'restwell_page_hero_stock_v13', '1' );
}

/**
 * Retry stock hero sideload with wp_upload_bits path (Playground-safe).
 */
function restwell_migrate_page_hero_stock_v14() {
	if ( get_option( 'restwell_page_hero_stock_v14', '' ) === '1' ) {
		return;
	}

	if ( function_exists( 'restwell_seed_page_hero_stock_images' ) ) {
		restwell_seed_page_hero_stock_images();
	}

	update_option( 'restwell_page_hero_stock_v14', '1' );
}

/**
 * Terms SEO title includes focus keyphrase; replace soft stock webp heroes with bungalow JPGs.
 */
function restwell_migrate_terms_title_hero_quality_v15() {
	if ( get_option( 'restwell_terms_title_hero_quality_v15', '' ) === '1' ) {
		return;
	}

	if ( function_exists( 'restwell_get_seo_meta_defaults_by_slug' ) ) {
		$defaults = restwell_get_seo_meta_defaults_by_slug();
		if ( ! empty( $defaults['terms-and-conditions']['meta_title'] ) ) {
			$page = get_page_by_path( 'terms-and-conditions', OBJECT, 'page' );
			if ( $page && (int) $page->ID > 0 ) {
				update_post_meta( (int) $page->ID, 'meta_title', $defaults['terms-and-conditions']['meta_title'] );
			}
		}
	}

	if ( function_exists( 'restwell_seed_page_hero_stock_images' ) ) {
		restwell_seed_page_hero_stock_images( true );
	}

	update_option( 'restwell_terms_title_hero_quality_v15', '1' );
}

/**
 * Apply new Kent/Whitstable stock JPGs to place-led page heroes and OG images.
 *
 * Clears mismatched Featured/hero/OG first so theme-file map fallbacks apply
 * immediately, then best-effort sideloads into Media.
 */
function restwell_migrate_page_hero_stock_v16() {
	if ( get_option( 'restwell_page_hero_stock_v16', '' ) === '1' ) {
		return;
	}

	if ( function_exists( 'restwell_get_default_og_stock_filename_map' ) && function_exists( 'restwell_page_id_for_stock_slug' ) ) {
		$map = restwell_get_default_og_stock_filename_map();
		foreach ( $map as $slug => $rel ) {
			$page_id = restwell_page_id_for_stock_slug( $slug );
			if ( $page_id < 1 ) {
				continue;
			}
			if ( function_exists( 'restwell_page_featured_matches_stock_rel' ) && restwell_page_featured_matches_stock_rel( $page_id, $rel ) ) {
				continue;
			}

			delete_post_thumbnail( $page_id );
			$post = get_post( $page_id );
			$key  = function_exists( 'restwell_page_hero_meta_key' ) ? restwell_page_hero_meta_key( $post ) : '';
			if ( $key !== '' ) {
				delete_post_meta( $page_id, $key );
			}
			delete_post_meta( $page_id, 'og_image_id' );
		}
	}

	// Mark complete before sideload so a timeout still leaves map fallbacks working.
	update_option( 'restwell_page_hero_stock_v16', '1' );

	if ( function_exists( 'set_time_limit' ) ) {
		set_time_limit( 180 );
	}

	if ( function_exists( 'restwell_seed_page_hero_stock_images' ) ) {
		restwell_seed_page_hero_stock_images( true );
	}
}

/**
 * Swap product-page heroes to inviting bungalow shots (garden / lounge / bedroom).
 */
function restwell_migrate_page_hero_stock_v17() {
	if ( get_option( 'restwell_page_hero_stock_v17', '' ) === '1' ) {
		return;
	}

	$slugs = array( 'the-property', 'pricing', 'how-it-works', 'optional-care' );

	if ( function_exists( 'restwell_get_default_og_stock_filename_map' ) && function_exists( 'restwell_page_id_for_stock_slug' ) ) {
		$map = restwell_get_default_og_stock_filename_map();
		foreach ( $slugs as $slug ) {
			if ( empty( $map[ $slug ] ) ) {
				continue;
			}
			$rel     = $map[ $slug ];
			$page_id = restwell_page_id_for_stock_slug( $slug );
			if ( $page_id < 1 ) {
				continue;
			}
			if ( function_exists( 'restwell_page_featured_matches_stock_rel' ) && restwell_page_featured_matches_stock_rel( $page_id, $rel ) ) {
				continue;
			}

			delete_post_thumbnail( $page_id );
			$post = get_post( $page_id );
			$key  = function_exists( 'restwell_page_hero_meta_key' ) ? restwell_page_hero_meta_key( $post ) : '';
			if ( $key !== '' ) {
				delete_post_meta( $page_id, $key );
			}
			delete_post_meta( $page_id, 'og_image_id' );
		}
	}

	update_option( 'restwell_page_hero_stock_v17', '1' );

	if ( function_exists( 'set_time_limit' ) ) {
		set_time_limit( 120 );
	}

	if ( function_exists( 'restwell_seed_page_hero_stock_images' ) ) {
		restwell_seed_page_hero_stock_images( true );
	}
}

/**
 * Put focus keyphrases into Our Story / Who It’s For meta descriptions,
 * and lengthen the Guest Guide SEO title into the 50–60 character range.
 *
 * Only overwrites known stale seed strings so later manual edits stay intact.
 */
function restwell_migrate_seo_meta_tips_v18() {
	if ( get_option( 'restwell_seo_meta_tips_v18', '' ) === '1' ) {
		return;
	}

	if ( ! function_exists( 'restwell_get_seo_meta_defaults_by_slug' ) ) {
		update_option( 'restwell_seo_meta_tips_v18', '1' );
		return;
	}

	$defaults = restwell_get_seo_meta_defaults_by_slug();
	$pages    = array(
		'our-story'   => array(
			'field' => 'meta_description',
			'stale' => array(
				'Restwell was built by someone who kept seeing the access gap firsthand, then shaped by disabled guests, carers and occupational therapists — not assumptions.',
			),
		),
		'who-its-for' => array(
			'field' => 'meta_description',
			'stale' => array(
				'See who Restwell suits: wheelchair users, carers, OTs and commissioners. Check access fit, care options and funding routes before you enquire about dates.',
			),
		),
		'guest-guide' => array(
			'field' => 'meta_title',
			'stale' => array(
				'Guest Guide | Check-In Tips',
			),
		),
	);

	foreach ( $pages as $slug => $cfg ) {
		if ( empty( $defaults[ $slug ][ $cfg['field'] ] ) ) {
			continue;
		}
		$page = get_page_by_path( $slug, OBJECT, 'page' );
		if ( ! $page || (int) $page->ID < 1 ) {
			continue;
		}
		$current = trim( (string) get_post_meta( (int) $page->ID, $cfg['field'], true ) );
		if ( $current === '' || in_array( $current, $cfg['stale'], true ) ) {
			update_post_meta( (int) $page->ID, $cfg['field'], $defaults[ $slug ][ $cfg['field'] ] );
		}
	}

	update_option( 'restwell_seo_meta_tips_v18', '1' );
}

/**
 * One-time: paste LANES Home title, meta, H1 and intro onto the front page.
 *
 * Only overwrites values that still match the old Whitstable seed so editor edits stay intact.
 */
function restwell_migrate_lanes_home_v22() {
	if ( get_option( 'restwell_lanes_home_v22', '' ) === '1' ) {
		return;
	}

	$front_id = (int) get_option( 'page_on_front', 0 );
	if ( $front_id < 1 ) {
		update_option( 'restwell_lanes_home_v22', '1' );
		return;
	}

	$seo = function_exists( 'restwell_get_seo_meta_defaults_by_slug' )
		? restwell_get_seo_meta_defaults_by_slug()
		: array();
	$home_seo = isset( $seo['home'] ) && is_array( $seo['home'] ) ? $seo['home'] : array();

	$replace_if_stale = static function ( $post_id, $key, $stale, $next ) {
		$next = is_string( $next ) ? $next : '';
		if ( $next === '' ) {
			return;
		}
		$cur = trim( (string) get_post_meta( $post_id, $key, true ) );
		if ( $cur === '' || in_array( $cur, $stale, true ) ) {
			update_post_meta( $post_id, $key, $next );
		}
	};

	$replace_if_stale(
		$front_id,
		'meta_title',
		array(
			'Accessible Holidays Whitstable: Step-Free Kent Stay',
			'Accessible Holidays in Whitstable, Kent | Restwell',
			'Accessible Holidays in Whitstable, Kent | Restwell Retreats',
		),
		$home_seo['meta_title'] ?? ''
	);
	$replace_if_stale(
		$front_id,
		'meta_description',
		array(
			'Accessible holidays Whitstable: a step-free self-catering home on the Kent coast. Explore the bungalow, published access details and how booking works with us.',
			'A step-free accessible holiday bungalow in Whitstable, Kent. Ceiling hoist, profiling bed and level-access wet room, with optional CQC-regulated care.',
		),
		$home_seo['meta_description'] ?? ''
	);
	$replace_if_stale(
		$front_id,
		'focus_keyphrase',
		array(
			'accessible holidays whitstable',
		),
		$home_seo['focus_keyphrase'] ?? ''
	);
	$replace_if_stale(
		$front_id,
		'hero_heading',
		array(
			'Accessible holidays in Whitstable',
			'Accessible holidays Whitstable',
			'Accessible holidays in Whitstable, Kent',
			'Accessible self-catering holidays in Whitstable, Kent',
			'Accessible Holidays in Whitstable, Kent',
		),
		'Accessible holiday cottages by the sea'
	);
	$replace_if_stale(
		$front_id,
		'hero_subheading',
		array(
			'Your own accessible bungalow in Whitstable. A self-catering stay with optional care support, so you can plan with confidence.',
			'Restwell is the brand overview for accessible holidays Whitstable guests can plan with confidence. Start here, then follow links to the bungalow, the access statement, who the stay suits, and how booking works. Enquire when you are ready.',
			'Wake up to the sea air in Whitstable and shape the day around your own clock. A step-free accessible holiday home with a ceiling track hoist, level-access wet room and optional CQC-regulated care: the whole house is yours.',
			'Restwell is a private bungalow in Whitstable, on the Kent coast. You book the whole house. Door widths, wet room and hoist notes are published before you enquire.',
			'Restwell is a private bungalow in Whitstable, on the Kent coast. You book the whole house.',
		),
		'Restwell is a private bungalow in Whitstable, on the Kent coast. The whole place is yours for the stay.'
	);

	update_option( 'restwell_lanes_home_v22', '1' );
}

/**
 * Soften the Home hero intro: "You book the whole house" reads as a rule.
 */
function restwell_migrate_home_hero_intro_v23() {
	if ( get_option( 'restwell_home_hero_intro_v23', '' ) === '1' ) {
		return;
	}

	$front_id = (int) get_option( 'page_on_front', 0 );
	if ( $front_id < 1 ) {
		update_option( 'restwell_home_hero_intro_v23', '1' );
		return;
	}

	$stale = array(
		'Restwell is a private bungalow in Whitstable, on the Kent coast. You book the whole house.',
		'Restwell is a private bungalow in Whitstable, on the Kent coast. You book the whole house. Door widths, wet room and hoist notes are published before you enquire.',
	);
	$cur = trim( (string) get_post_meta( $front_id, 'hero_subheading', true ) );
	if ( $cur === '' || in_array( $cur, $stale, true ) ) {
		update_post_meta(
			$front_id,
			'hero_subheading',
			'Restwell is a private bungalow in Whitstable, on the Kent coast. The whole place is yours for the stay.'
		);
	}

	update_option( 'restwell_home_hero_intro_v23', '1' );
}

/**
 * One-time: ship 28 Aug copy overhaul onto existing pages (titles, H1s, intros, FAQs).
 *
 * Force-writes guest-facing copy keys from PHP defaults so live post meta is not left stale.
 *
 * Historical one-shot: do not copy this force-write pattern. Later copy fixes must
 * compare stored values and only replace matching legacy strings (see restwell_migrate_audit_copy_fixes_v27).
 */
function restwell_migrate_copy_overhaul_v24() {
	if ( get_option( 'restwell_copy_overhaul_v24', '' ) === '1' ) {
		return;
	}

	if ( function_exists( 'restwell_apply_seo_meta_to_pages' ) ) {
		restwell_apply_seo_meta_to_pages( true );
	}

	$write_keys = static function ( $slug, $defaults, $keys ) {
		$page = get_page_by_path( $slug, OBJECT, 'page' );
		if ( ! $page instanceof WP_Post ) {
			return;
		}
		$pid = (int) $page->ID;
		foreach ( $keys as $key ) {
			if ( ! array_key_exists( $key, $defaults ) ) {
				continue;
			}
			update_post_meta( $pid, $key, $defaults[ $key ] );
		}
	};

	$home_defaults = function_exists( 'restwell_get_theme_setup_defaults' )
		? restwell_get_theme_setup_defaults()
		: array();
	$write_keys(
		'home',
		$home_defaults,
		array(
			'hero_heading',
			'hero_subheading',
			'hero_cta_primary_label',
			'hero_cta_secondary_label',
			'hero_cta_promise',
			'home_teaser_area_body',
			'home_teaser_funding_body',
			'property_label',
			'property_heading',
			'property_body',
			'property_cta_label',
			'why_heading',
			'home_comparison_heading',
			'home_comparison_intro',
			'cta_heading',
			'cta_body',
			'cta_primary_label',
			'cta_secondary_label',
			'cta_promise',
			'home_faq_label',
			'home_faq_heading',
			'home_faq_1_q',
			'home_faq_1_a',
			'home_faq_2_q',
			'home_faq_2_a',
			'home_faq_3_q',
			'home_faq_3_a',
		)
	);

	$prop_defaults = function_exists( 'restwell_get_property_page_defaults' )
		? restwell_get_property_page_defaults()
		: array();
	$write_keys(
		'the-property',
		$prop_defaults,
		array(
			'prop_hero_heading',
			'prop_hero_subtitle',
			'prop_bedrooms_section_heading',
			'prop_bedrooms_section_body',
			'prop_distances',
			'prop_nearby_2_distance',
			'prop_nearby_4_distance',
		)
	);

	$acc_defaults = function_exists( 'restwell_get_accessibility_page_defaults' )
		? restwell_get_accessibility_page_defaults()
		: array();
	$write_keys(
		'accessibility',
		$acc_defaults,
		array(
			'acc_heading',
			'acc_intro',
			'acc_arrival_body',
			'acc_inside_body',
			'acc_bedroom_body',
			'acc_bathroom_body',
		)
	);

	$hiw_defaults = function_exists( 'restwell_get_how_it_works_page_defaults' )
		? restwell_get_how_it_works_page_defaults()
		: array();
	$write_keys(
		'how-it-works',
		$hiw_defaults,
		array(
			'hiw_heading',
			'hiw_intro',
			'hiw_steps_label',
			'hiw_steps_heading',
			'hiw_step1_title',
			'hiw_step1_body',
			'hiw_step2_title',
			'hiw_step2_body',
			'hiw_step3_title',
			'hiw_step3_body',
			'hiw_step4_title',
			'hiw_step4_body',
			'hiw_faq_1_q',
			'hiw_faq_1_a',
			'hiw_faq_2_q',
			'hiw_faq_2_a',
			'hiw_faq_3_q',
			'hiw_faq_3_a',
		)
	);

	$wif_defaults = function_exists( 'restwell_get_who_its_for_page_defaults' )
		? restwell_get_who_its_for_page_defaults()
		: array();
	$write_keys( 'who-its-for', $wif_defaults, array( 'wif_heading', 'wif_intro' ) );

	$pricing_defaults = function_exists( 'restwell_get_pricing_page_defaults' )
		? restwell_get_pricing_page_defaults()
		: array();
	$pricing_keys = array(
		'pricing_heading',
		'pricing_subheading',
		'pricing_intro',
		'pricing_hero_cta_text',
		'pricing_hero_cta_promise',
	);
	for ( $i = 1; $i <= 8; $i++ ) {
		$pricing_keys[] = "pricing_faq_{$i}_q";
		$pricing_keys[] = "pricing_faq_{$i}_a";
	}
	$write_keys( 'pricing', $pricing_defaults, $pricing_keys );

	$wg_defaults = function_exists( 'restwell_get_whitstable_guide_page_defaults' )
		? restwell_get_whitstable_guide_page_defaults()
		: array();
	$write_keys( 'whitstable-area-guide', $wg_defaults, array( 'wg_heading', 'wg_intro' ) );

	$enq_defaults = function_exists( 'restwell_get_enquire_page_defaults' )
		? restwell_get_enquire_page_defaults()
		: array();
	$write_keys( 'enquire', $enq_defaults, array( 'enq_heading', 'enq_intro' ) );

	$faq_defaults = function_exists( 'restwell_get_faq_page_defaults' )
		? restwell_get_faq_page_defaults()
		: array();
	$faq_keys = array( 'faq_heading', 'faq_intro', 'faq_cta_body' );
	for ( $i = 1; $i <= 15; $i++ ) {
		$faq_keys[] = "faq_{$i}_q";
		$faq_keys[] = "faq_{$i}_a";
		$faq_keys[] = "faq_{$i}_cat";
	}
	$write_keys( 'faq', $faq_defaults, $faq_keys );

	$res_defaults = function_exists( 'restwell_get_resources_page_defaults' )
		? restwell_get_resources_page_defaults()
		: array();
	$write_keys( 'resources', $res_defaults, array( 'res_heading', 'res_intro' ) );

	$care_defaults = function_exists( 'restwell_get_care_page_defaults' )
		? restwell_get_care_page_defaults()
		: array();
	$write_keys( 'optional-care', $care_defaults, array( 'care_heading', 'care_intro' ) );

	$story_defaults = function_exists( 'restwell_get_our_story_page_defaults' )
		? restwell_get_our_story_page_defaults()
		: array();
	$write_keys( 'our-story', $story_defaults, array( 'story_heading', 'story_intro' ) );

	$gg_defaults = function_exists( 'restwell_get_guest_guide_page_defaults' )
		? restwell_get_guest_guide_page_defaults()
		: array();
	$write_keys( 'guest-guide', $gg_defaults, array( 'gg_local_info' ) );

	$blog_page = get_page_by_path( 'blog', OBJECT, 'page' );
	if ( $blog_page instanceof WP_Post ) {
		$blog_id = (int) $blog_page->ID;
		$excerpt = 'Guides about accessible travel written from one adapted bungalow in Whitstable: the Kent coast in a wheelchair, how funding for a break usually works, and how to read an access statement so a listing can’t catch you out.';
		wp_update_post(
			array(
				'ID'           => $blog_id,
				'post_excerpt' => $excerpt,
			)
		);
	}

	update_option( 'restwell_copy_overhaul_v24', '1' );
}

/**
 * One-time: Victoria Walker is Continuity’s CQC registered manager.
 *
 * Force-writes Our story and Optional care intros so live post meta is not left on the v24 copy.
 */
function restwell_migrate_victoria_registered_manager_v25() {
	if ( get_option( 'restwell_victoria_registered_manager_v25', '' ) === '1' ) {
		return;
	}

	$write_keys = static function ( $slug, $defaults, $keys ) {
		$page = get_page_by_path( $slug, OBJECT, 'page' );
		if ( ! $page instanceof WP_Post ) {
			return;
		}
		$pid = (int) $page->ID;
		foreach ( $keys as $key ) {
			if ( ! array_key_exists( $key, $defaults ) ) {
				continue;
			}
			update_post_meta( $pid, $key, $defaults[ $key ] );
		}
	};

	$care_defaults = function_exists( 'restwell_get_care_page_defaults' )
		? restwell_get_care_page_defaults()
		: array();
	$write_keys( 'optional-care', $care_defaults, array( 'care_intro' ) );

	$story_defaults = function_exists( 'restwell_get_our_story_page_defaults' )
		? restwell_get_our_story_page_defaults()
		: array();
	$write_keys( 'our-story', $story_defaults, array( 'story_intro' ) );

	update_option( 'restwell_victoria_registered_manager_v25', '1' );
}

/**
 * One-time: remove em dashes from visitor-facing page meta.
 */
function restwell_migrate_strip_em_dashes_v26() {
	if ( get_option( 'restwell_strip_em_dashes_v26', '' ) === '1' ) {
		return;
	}

	$write_keys = static function ( $slug, $defaults, $keys ) {
		$page = get_page_by_path( $slug, OBJECT, 'page' );
		if ( ! $page instanceof WP_Post ) {
			return;
		}
		$pid = (int) $page->ID;
		foreach ( $keys as $key ) {
			if ( ! array_key_exists( $key, $defaults ) ) {
				continue;
			}
			update_post_meta( $pid, $key, $defaults[ $key ] );
		}
	};

	$home_defaults = function_exists( 'restwell_get_theme_setup_defaults' )
		? restwell_get_theme_setup_defaults()
		: array();
	$write_keys( 'home', $home_defaults, array( 'home_teaser_area_body' ) );

	$acc_defaults = function_exists( 'restwell_get_accessibility_page_defaults' )
		? restwell_get_accessibility_page_defaults()
		: array();
	$write_keys(
		'accessibility',
		$acc_defaults,
		array( 'acc_arrival_body', 'acc_bedroom_body', 'acc_bathroom_body', 'acc_kitchen_body' )
	);

	$hiw_defaults = function_exists( 'restwell_get_how_it_works_page_defaults' )
		? restwell_get_how_it_works_page_defaults()
		: array();
	$write_keys( 'how-it-works', $hiw_defaults, array( 'hiw_faq_2_a' ) );

	$wif_defaults = function_exists( 'restwell_get_who_its_for_page_defaults' )
		? restwell_get_who_its_for_page_defaults()
		: array();
	$write_keys( 'who-its-for', $wif_defaults, array( 'wif_intro' ) );

	$enq_defaults = function_exists( 'restwell_get_enquire_page_defaults' )
		? restwell_get_enquire_page_defaults()
		: array();
	$write_keys( 'enquire', $enq_defaults, array( 'enq_success_heading' ) );

	$faq_defaults = function_exists( 'restwell_get_faq_page_defaults' )
		? restwell_get_faq_page_defaults()
		: array();
	$faq_keys = array();
	for ( $i = 1; $i <= 15; $i++ ) {
		$faq_keys[] = "faq_{$i}_a";
	}
	$write_keys( 'faq', $faq_defaults, $faq_keys );

	$pricing_defaults = function_exists( 'restwell_get_pricing_page_defaults' )
		? restwell_get_pricing_page_defaults()
		: array();
	$pricing_keys = array();
	for ( $i = 1; $i <= 8; $i++ ) {
		$pricing_keys[] = "pricing_faq_{$i}_a";
	}
	$write_keys( 'pricing', $pricing_defaults, $pricing_keys );

	$res_defaults = function_exists( 'restwell_get_resources_page_defaults' )
		? restwell_get_resources_page_defaults()
		: array();
	$write_keys( 'resources', $res_defaults, array( 'res_intro' ) );

	$gg_defaults = function_exists( 'restwell_get_guest_guide_page_defaults' )
		? restwell_get_guest_guide_page_defaults()
		: array();
	$write_keys( 'guest-guide', $gg_defaults, array( 'gg_parking_info', 'gg_local_info' ) );

	$blog_page = get_page_by_path( 'blog', OBJECT, 'page' );
	if ( $blog_page instanceof WP_Post && function_exists( 'restwell_get_blog_index_excerpt_default' ) ) {
		wp_update_post(
			array(
				'ID'           => (int) $blog_page->ID,
				'post_excerpt' => restwell_get_blog_index_excerpt_default(),
			)
		);
	} elseif ( $blog_page instanceof WP_Post ) {
		wp_update_post(
			array(
				'ID'           => (int) $blog_page->ID,
				'post_excerpt' => 'Guides about accessible travel written from one adapted bungalow in Whitstable: the Kent coast in a wheelchair, how funding for a break usually works, and how to read an access statement so a listing can’t catch you out.',
			)
		);
	}

	update_option( 'restwell_strip_em_dashes_v26', '1' );
}

/**
 * One-time: value-compare copy fixes from the 28 Aug audit (no force clobber).
 *
 * Replaces matching legacy strings only: privacy "care partner", sofa bed in the
 * living area, enquire working-days success copy, and de-indexes the defunct
 * beaches post that 301s to the canonical guide.
 */
function restwell_migrate_audit_copy_fixes_v27() {
	if ( get_option( 'restwell_audit_copy_fixes_v27', '' ) === '1' ) {
		return;
	}

	$replace_if_exact = static function ( $slug, $post_type, $key, $old, $new ) {
		$page = get_page_by_path( $slug, OBJECT, $post_type );
		if ( ! $page instanceof WP_Post ) {
			return;
		}
		$cur = (string) get_post_meta( (int) $page->ID, $key, true );
		if ( trim( $cur ) === $old ) {
			update_post_meta( (int) $page->ID, $key, $new );
		}
	};

	$privacy = get_page_by_path( 'privacy-policy', OBJECT, 'page' );
	if ( $privacy instanceof WP_Post ) {
		$html = (string) get_post_meta( (int) $privacy->ID, 'legal_body_html', true );
		$old  = 'our care partner, Continuity of Care Services';
		$new  = 'our sister company, Continuity of Care Services';
		if ( $html !== '' && false !== strpos( $html, $old ) ) {
			update_post_meta( (int) $privacy->ID, 'legal_body_html', str_replace( $old, $new, $html ) );
		}
	}

	$replace_if_exact(
		'home',
		'page',
		'why_item1_desc',
		'The whole bungalow is yours: living space, kitchen, two bedrooms plus a sofa bed in the living area (sleeps up to five), with the privacy of a self-catering stay.',
		'The whole bungalow is yours: living space, kitchen, two bedrooms plus a sofa bed in the conservatory (sleeps up to five), with the privacy of a self-catering stay.'
	);
	$replace_if_exact(
		'the-property',
		'page',
		'prop_bedrooms',
		'Two bedrooms, plus a sofa bed in the living area. Sleeps up to five.',
		'Two bedrooms, plus a sofa bed in the conservatory. Sleeps up to five.'
	);
	$replace_if_exact(
		'enquire',
		'page',
		'enq_success_heading',
		'Thank you. We have your enquiry.',
		'We’ve got your enquiry'
	);
	$replace_if_exact(
		'enquire',
		'page',
		'enq_success_body',
		'We usually respond within one to two working days (often sooner), using your preferred contact method where you have told us one. If your dates are tight, say so in your message and we will prioritise a quick first reply.',
		'We’ve emailed you an acknowledgement. Next: a team member reviews your details and replies, usually within 48 hours. Call 01622 809881 if you’d rather talk it through.'
	);
	$replace_if_exact(
		'enquire',
		'page',
		'enq_success_urgent_body',
		'You marked this as time-sensitive. We will prioritise your request and aim to respond within one working day where possible, using your preferred contact method.',
		'We’ve flagged this for a priority callback and aim to contact you sooner than our usual 48-hour window. If you need to speak now, call 01622 809881.'
	);

	$old_beaches = get_page_by_path( 'accessible-beaches-kent-coast', OBJECT, 'post' );
	if ( $old_beaches instanceof WP_Post ) {
		update_post_meta( (int) $old_beaches->ID, 'meta_noindex', 1 );
		$dup_title = 'A guide to accessible beaches and coastal walks in Kent';
		if ( 0 === strcasecmp( trim( (string) $old_beaches->post_title ), $dup_title ) ) {
			wp_update_post(
				array(
					'ID'         => (int) $old_beaches->ID,
					'post_title' => 'Level promenades and shingle beaches on the Kent coast',
				)
			);
		}
	}

	update_option( 'restwell_audit_copy_fixes_v27', '1' );
}

/**
 * Retry leftover 28 Aug copy fixes if v27 marked complete without matching stored meta.
 *
 * Looks up Enquire by template as well as slug. Replaces success copy that still
 * mentions working days, and sofa / privacy strings v27 may have missed.
 */
function restwell_migrate_audit_copy_fixes_v28() {
	if ( get_option( 'restwell_audit_copy_fixes_v28', '' ) === '1' ) {
		return;
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

	$replace_if_exact = static function ( $page, $key, $old, $new ) {
		if ( ! $page instanceof WP_Post ) {
			return;
		}
		$cur = (string) get_post_meta( (int) $page->ID, $key, true );
		if ( trim( $cur ) === $old ) {
			update_post_meta( (int) $page->ID, $key, $new );
		}
	};

	$home = get_page_by_path( 'home', OBJECT, 'page' );
	$replace_if_exact(
		$home,
		'why_item1_desc',
		'The whole bungalow is yours: living space, kitchen, two bedrooms plus a sofa bed in the living area (sleeps up to five), with the privacy of a self-catering stay.',
		'The whole bungalow is yours: living space, kitchen, two bedrooms plus a sofa bed in the conservatory (sleeps up to five), with the privacy of a self-catering stay.'
	);

	$property = $page_by_path_or_template( 'the-property', 'template-property.php' );
	$replace_if_exact(
		$property,
		'prop_bedrooms',
		'Two bedrooms, plus a sofa bed in the living area. Sleeps up to five.',
		'Two bedrooms, plus a sofa bed in the conservatory. Sleeps up to five.'
	);

	$enquire = $page_by_path_or_template( 'enquire', 'template-enquire.php' );
	if ( $enquire instanceof WP_Post ) {
		$pid = (int) $enquire->ID;
		$replace_if_exact( $enquire, 'enq_success_heading', 'Thank you. We have your enquiry.', 'We’ve got your enquiry' );
		$body = (string) get_post_meta( $pid, 'enq_success_body', true );
		if ( false !== stripos( $body, 'working days' ) ) {
			update_post_meta(
				$pid,
				'enq_success_body',
				'We’ve emailed you an acknowledgement. Next: a team member reviews your details and replies, usually within 48 hours. Call 01622 809881 if you’d rather talk it through.'
			);
		}
		$urgent = (string) get_post_meta( $pid, 'enq_success_urgent_body', true );
		if ( false !== stripos( $urgent, 'working days' ) ) {
			update_post_meta(
				$pid,
				'enq_success_urgent_body',
				'We’ve flagged this for a priority callback and aim to contact you sooner than our usual 48-hour window. If you need to speak now, call 01622 809881.'
			);
		}
	}

	$privacy = $page_by_path_or_template( 'privacy-policy', 'template-privacy-policy.php' );
	if ( $privacy instanceof WP_Post ) {
		$html = (string) get_post_meta( (int) $privacy->ID, 'legal_body_html', true );
		$old  = 'our care partner, Continuity of Care Services';
		$new  = 'our sister company, Continuity of Care Services';
		if ( $html !== '' && false !== strpos( $html, $old ) ) {
			update_post_meta( (int) $privacy->ID, 'legal_body_html', str_replace( $old, $new, $html ) );
		}
	}

	update_option( 'restwell_audit_copy_fixes_v28', '1' );
}

/**
 * Register v1–v28 migration callbacks.
 */
function restwell_register_legacy_content_migration_hooks(): void {
	add_action( 'admin_init', 'restwell_migrate_homepage_faq_meta_v1', 5 );
	add_action( 'after_switch_theme', 'restwell_migrate_homepage_faq_meta_v1', 10 );
	add_action( 'init', 'restwell_migrate_property_practical_meta_v1', 20 );
	add_action( 'after_switch_theme', 'restwell_migrate_property_practical_meta_v1', 11 );
	add_action( 'init', 'restwell_migrate_property_sleeps_five_v1', 21 );
	add_action( 'after_switch_theme', 'restwell_migrate_property_sleeps_five_v1', 12 );
	add_action( 'init', 'restwell_migrate_property_parking_short_v1', 22 );
	add_action( 'after_switch_theme', 'restwell_migrate_property_parking_short_v1', 13 );
	add_action( 'init', 'restwell_migrate_property_bedrooms_parking_v2', 23 );
	add_action( 'after_switch_theme', 'restwell_migrate_property_bedrooms_parking_v2', 14 );
	add_action( 'init', 'restwell_migrate_property_parking_detail_v3', 24 );
	add_action( 'after_switch_theme', 'restwell_migrate_property_parking_detail_v3', 15 );
	add_action( 'init', 'restwell_migrate_property_headings_v4', 25 );
	add_action( 'after_switch_theme', 'restwell_migrate_property_headings_v4', 16 );
	add_action( 'init', 'restwell_migrate_property_labels_v5', 26 );
	add_action( 'after_switch_theme', 'restwell_migrate_property_labels_v5', 17 );
	add_action( 'init', 'restwell_migrate_property_wetroom_stat_v6', 27 );
	add_action( 'after_switch_theme', 'restwell_migrate_property_wetroom_stat_v6', 18 );
	add_action( 'init', 'restwell_migrate_property_wetroom_walkthrough_v7', 28 );
	add_action( 'after_switch_theme', 'restwell_migrate_property_wetroom_walkthrough_v7', 19 );
	add_action( 'init', 'restwell_migrate_homepage_cta_testword_v8', 29 );
	add_action( 'after_switch_theme', 'restwell_migrate_homepage_cta_testword_v8', 20 );
	add_action( 'init', 'restwell_migrate_property_wetroom_stat_copy_v9', 30 );
	add_action( 'after_switch_theme', 'restwell_migrate_property_wetroom_stat_copy_v9', 21 );
	add_action( 'init', 'restwell_migrate_faq_access_parking_bedrooms_v1', 31 );
	add_action( 'after_switch_theme', 'restwell_migrate_faq_access_parking_bedrooms_v1', 22 );
	add_action( 'init', 'restwell_migrate_property_feature_copy_balance_v1', 32 );
	add_action( 'after_switch_theme', 'restwell_migrate_property_feature_copy_balance_v1', 23 );
	add_action( 'init', 'restwell_migrate_home_hiw_card_copy_balance_v1', 33 );
	add_action( 'after_switch_theme', 'restwell_migrate_home_hiw_card_copy_balance_v1', 24 );
	add_action( 'init', 'restwell_migrate_legal_policy_templates_v1', 34 );
	add_action( 'after_switch_theme', 'restwell_migrate_legal_policy_templates_v1', 25 );
	add_action( 'init', 'restwell_migrate_accessibility_headings_v1', 35 );
	add_action( 'after_switch_theme', 'restwell_migrate_accessibility_headings_v1', 26 );
	add_action( 'init', 'restwell_migrate_accessibility_intro_v2', 36 );
	add_action( 'after_switch_theme', 'restwell_migrate_accessibility_intro_v2', 27 );
	add_action( 'init', 'restwell_migrate_who_its_for_headings_v1', 37 );
	add_action( 'after_switch_theme', 'restwell_migrate_who_its_for_headings_v1', 28 );
	add_action( 'init', 'restwell_migrate_property_headings_v1', 38 );
	add_action( 'after_switch_theme', 'restwell_migrate_property_headings_v1', 29 );
	add_action( 'init', 'restwell_migrate_how_it_works_headings_v1', 39 );
	add_action( 'after_switch_theme', 'restwell_migrate_how_it_works_headings_v1', 30 );
	add_action( 'init', 'restwell_migrate_home_lede_v1', 40 );
	add_action( 'after_switch_theme', 'restwell_migrate_home_lede_v1', 31 );
	add_action( 'init', 'restwell_migrate_property_lede_v1', 41 );
	add_action( 'after_switch_theme', 'restwell_migrate_property_lede_v1', 32 );
	add_action( 'init', 'restwell_migrate_wif_lede_v1', 42 );
	add_action( 'after_switch_theme', 'restwell_migrate_wif_lede_v1', 33 );
	add_action( 'init', 'restwell_migrate_hiw_lede_v1', 43 );
	add_action( 'after_switch_theme', 'restwell_migrate_hiw_lede_v1', 34 );
	add_action( 'init', 'restwell_migrate_faq_lede_v1', 44 );
	add_action( 'after_switch_theme', 'restwell_migrate_faq_lede_v1', 35 );
	add_action( 'init', 'restwell_migrate_resources_lede_v1', 45 );
	add_action( 'after_switch_theme', 'restwell_migrate_resources_lede_v1', 36 );
	add_action( 'init', 'restwell_migrate_wg_lede_v1', 46 );
	add_action( 'after_switch_theme', 'restwell_migrate_wg_lede_v1', 37 );
	add_action( 'init', 'restwell_migrate_enq_lede_v1', 47 );
	add_action( 'after_switch_theme', 'restwell_migrate_enq_lede_v1', 38 );
	add_action( 'init', 'restwell_migrate_blog_lede_v1', 48 );
	add_action( 'after_switch_theme', 'restwell_migrate_blog_lede_v1', 39 );
	add_action( 'init', 'restwell_migrate_blog_index_copy_v2', 49 );
	add_action( 'after_switch_theme', 'restwell_migrate_blog_index_copy_v2', 40 );
	add_action( 'init', 'restwell_migrate_seo_titles_meta_v3', 50 );
	add_action( 'after_switch_theme', 'restwell_migrate_seo_titles_meta_v3', 41 );
	add_action( 'init', 'restwell_migrate_seo_titles_meta_v4', 51 );
	add_action( 'after_switch_theme', 'restwell_migrate_seo_titles_meta_v4', 42 );
	add_action( 'init', 'restwell_migrate_seo_home_title_v5', 52 );
	add_action( 'after_switch_theme', 'restwell_migrate_seo_home_title_v5', 43 );
	add_action( 'init', 'restwell_migrate_seo_a11y_policy_meta_v6', 53 );
	add_action( 'after_switch_theme', 'restwell_migrate_seo_a11y_policy_meta_v6', 44 );
	add_action( 'init', 'restwell_migrate_seo_cannibal_lanes_v7', 54 );
	add_action( 'after_switch_theme', 'restwell_migrate_seo_cannibal_lanes_v7', 45 );
	add_action( 'init', 'restwell_migrate_seo_cannibal_medium_v8', 55 );
	add_action( 'after_switch_theme', 'restwell_migrate_seo_cannibal_medium_v8', 46 );
	add_action( 'init', 'restwell_migrate_seo_cannibal_low_v9', 56 );
	add_action( 'after_switch_theme', 'restwell_migrate_seo_cannibal_low_v9', 47 );
	add_action( 'init', 'restwell_migrate_sample_page_demo_v10', 57 );
	add_action( 'after_switch_theme', 'restwell_migrate_sample_page_demo_v10', 48 );
	add_action( 'init', 'restwell_migrate_retire_demo_content_v11', 58 );
	add_action( 'after_switch_theme', 'restwell_migrate_retire_demo_content_v11', 49 );
	add_action( 'init', 'restwell_migrate_keyword_lanes_v1', 59 );
	add_action( 'after_switch_theme', 'restwell_migrate_keyword_lanes_v1', 50 );
	add_action( 'init', 'restwell_migrate_guest_guide_checkin_v1', 60 );
	add_action( 'after_switch_theme', 'restwell_migrate_guest_guide_checkin_v1', 51 );
	add_action( 'init', 'restwell_migrate_terms_balance_one_week_v1', 61 );
	add_action( 'after_switch_theme', 'restwell_migrate_terms_balance_one_week_v1', 52 );
	add_action( 'init', 'restwell_migrate_pricing_hero_copy_v1', 62 );
	add_action( 'after_switch_theme', 'restwell_migrate_pricing_hero_copy_v1', 53 );
	add_action( 'init', 'restwell_migrate_pricing_equipment_hire_copy_v1', 63 );
	add_action( 'after_switch_theme', 'restwell_migrate_pricing_equipment_hire_copy_v1', 54 );
	add_action( 'init', 'restwell_migrate_seo_kp_titles_v12', 64 );
	add_action( 'after_switch_theme', 'restwell_migrate_seo_kp_titles_v12', 55 );
	add_action( 'init', 'restwell_migrate_page_hero_stock_v13', 65 );
	add_action( 'after_switch_theme', 'restwell_migrate_page_hero_stock_v13', 56 );
	add_action( 'init', 'restwell_migrate_page_hero_stock_v14', 66 );
	add_action( 'after_switch_theme', 'restwell_migrate_page_hero_stock_v14', 57 );
	add_action( 'init', 'restwell_migrate_terms_title_hero_quality_v15', 67 );
	add_action( 'after_switch_theme', 'restwell_migrate_terms_title_hero_quality_v15', 58 );
	add_action( 'init', 'restwell_migrate_page_hero_stock_v16', 68 );
	add_action( 'after_switch_theme', 'restwell_migrate_page_hero_stock_v16', 59 );
	add_action( 'init', 'restwell_migrate_page_hero_stock_v17', 69 );
	add_action( 'after_switch_theme', 'restwell_migrate_page_hero_stock_v17', 60 );
	add_action( 'init', 'restwell_migrate_seo_meta_tips_v18', 70 );
	add_action( 'after_switch_theme', 'restwell_migrate_seo_meta_tips_v18', 61 );
	add_action( 'init', 'restwell_migrate_lanes_home_v22', 71 );
	add_action( 'after_switch_theme', 'restwell_migrate_lanes_home_v22', 62 );
	add_action( 'init', 'restwell_migrate_home_hero_intro_v23', 72 );
	add_action( 'after_switch_theme', 'restwell_migrate_home_hero_intro_v23', 63 );
	add_action( 'init', 'restwell_migrate_copy_overhaul_v24', 73 );
	add_action( 'after_switch_theme', 'restwell_migrate_copy_overhaul_v24', 64 );
	add_action( 'init', 'restwell_migrate_victoria_registered_manager_v25', 74 );
	add_action( 'after_switch_theme', 'restwell_migrate_victoria_registered_manager_v25', 65 );
	add_action( 'init', 'restwell_migrate_strip_em_dashes_v26', 75 );
	add_action( 'after_switch_theme', 'restwell_migrate_strip_em_dashes_v26', 66 );
	add_action( 'init', 'restwell_migrate_audit_copy_fixes_v27', 76 );
	add_action( 'after_switch_theme', 'restwell_migrate_audit_copy_fixes_v27', 67 );
	add_action( 'init', 'restwell_migrate_audit_copy_fixes_v28', 77 );
	add_action( 'after_switch_theme', 'restwell_migrate_audit_copy_fixes_v28', 68 );
}
