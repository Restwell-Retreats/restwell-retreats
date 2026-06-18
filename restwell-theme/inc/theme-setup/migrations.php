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
		update_post_meta( $page_id, 'prop_bedrooms', 'Two bedrooms, plus a sofa bed in the living area—sleeps up to five.' );
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
			'old' => 'Roll-in shower, grab rails, perching stool in the shower, fully height-adjustable washbasin that swings aside (shower chair may be available on request)',
			'new' => 'Roll-in shower, grab rails, and adjustable washbasin; shower chair may be available on request',
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
				'old' => 'Roll-in shower, grab rails, perching stool in the shower, height-adjustable washbasin that swings aside, and space to turn and assist (shower chair may be available on request).',
				'new' => 'Roll-in wet room with grab rails and an adjustable washbasin; shower chair may be available.',
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
