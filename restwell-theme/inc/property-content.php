<?php
/**
 * Property page content helpers (sections, room tour, glance summary).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Replace em dashes in visitor-facing copy with plainer punctuation.
 *
 * @param string $text Source text.
 * @return string
 */
function restwell_normalize_editorial_dashes( $text ) {
	$text = (string) $text;
	if ( $text === '' || ! str_contains( $text, '—' ) ) {
		return $text;
	}

	return (string) preg_replace( '/\s*—\s*/u', ', ', $text );
}

/**
 * Stale property page headings mapped to refreshed SEO-friendly defaults.
 *
 * @return array<string, array<string, string>>
 */
function restwell_get_property_heading_refresh_maps() {
	$defaults = restwell_get_property_page_defaults();

	return array(
		'prop_bungalow_heading' => array(
			'An accessible bungalow on one level' => (string) ( $defaults['prop_bungalow_heading'] ?? '' ),
		),
		'prop_living_heading' => array(
			'Living room, kitchen and conservatory' => (string) ( $defaults['prop_living_heading'] ?? '' ),
		),
		'prop_bedrooms_section_heading' => array(
			'The accessible bedroom and a double' => (string) ( $defaults['prop_bedrooms_section_heading'] ?? '' ),
		),
		'prop_wetroom_heading' => array(
			'Level-access wet room' => (string) ( $defaults['prop_wetroom_heading'] ?? '' ),
		),
		'prop_garden_heading' => array(
			'Accessible garden and parking' => (string) ( $defaults['prop_garden_heading'] ?? '' ),
		),
		'prop_throughout_heading' => array(
			'Wide doorways throughout' => (string) ( $defaults['prop_throughout_heading'] ?? '' ),
		),
		'prop_practical_heading' => array(
			'The basics, clearly'                 => (string) ( $defaults['prop_practical_heading'] ?? '' ),
			'The basics, clearly.'                => (string) ( $defaults['prop_practical_heading'] ?? '' ),
			'At a glance'                         => (string) ( $defaults['prop_practical_heading'] ?? '' ),
			'Sleeping, parking and layout'        => (string) ( $defaults['prop_practical_heading'] ?? '' ),
		),
		'prop_gallery_heading' => array(
			'Take a look around' => (string) ( $defaults['prop_gallery_heading'] ?? '' ),
		),
		'prop_care_heading' => array(
			'Care and the welcome' => (string) ( $defaults['prop_care_heading'] ?? '' ),
		),
		'prop_location_heading' => array(
			'Whitstable and around' => (string) ( $defaults['prop_location_heading'] ?? '' ),
		),
		'prop_nearby_heading' => array(
			'Explore Whitstable' => (string) ( $defaults['prop_nearby_heading'] ?? '' ),
		),
	);
}

/**
 * Resolve a property page section heading with stale copy replaced.
 *
 * @param int    $post_id  Property page ID.
 * @param string $meta_key Meta key.
 * @return string
 */
function restwell_get_property_heading( $post_id, $meta_key ) {
	$post_id  = (int) $post_id;
	$meta_key = (string) $meta_key;
	$defaults = restwell_get_property_page_defaults();
	$heading  = trim( (string) restwell_post_meta_or_default( $post_id, $meta_key, $defaults ) );

	if ( $heading === '' && isset( $defaults[ $meta_key ] ) ) {
		return (string) $defaults[ $meta_key ];
	}

	$maps = restwell_get_property_heading_refresh_maps();
	if ( isset( $maps[ $meta_key ][ $heading ] ) ) {
		$refreshed = trim( (string) $maps[ $meta_key ][ $heading ] );
		if ( $refreshed !== '' ) {
			return $refreshed;
		}
	}

	return $heading;
}

/**
 * Alternating section background for the property page (white / cool subtle).
 *
 * @param int $band_index Zero-based section index after the hero.
 * @return string Tailwind background class.
 */
function restwell_get_property_section_bg_class( $band_index ) {
	return 0 === ( (int) $band_index % 2 ) ? 'bg-white' : 'bg-[var(--bg-subtle)]';
}

/**
 * Trim prose to a word count for room-tour blurbs.
 *
 * @param string $text Source text.
 * @param int    $max  Maximum words.
 * @return string
 */
function restwell_trim_words_prose( $text, $max = 55 ) {
	$text = trim( preg_replace( '/\s+/', ' ', wp_strip_all_tags( (string) $text ) ) );
	if ( $text === '' ) {
		return '';
	}
	$words = preg_split( '/\s+/', $text );
	if ( ! is_array( $words ) || count( $words ) <= $max ) {
		return $text;
	}
	return implode( ' ', array_slice( $words, 0, $max ) ) . '…';
}

/**
 * Build the practical "At a glance" summary from meta defaults.
 *
 * @param int $post_id Property page ID.
 * @return string
 */
function restwell_get_property_glance_summary( $post_id = 0 ) {
	$post_id = (int) $post_id;
	if ( $post_id <= 0 ) {
		$post_id = (int) get_the_ID();
	}

	$d = restwell_get_property_page_defaults();
	$m = function ( $key ) use ( $post_id, $d ) {
		return restwell_post_meta_or_default( $post_id, $key, $d );
	};

	$parts = array();
	for ( $fi = 1; $fi <= 8; $fi++ ) {
		$title = trim( (string) $m( "prop_feature_{$fi}" ) );
		$desc  = trim( (string) $m( "prop_feature_{$fi}_desc" ) );
		if ( $title === '' ) {
			continue;
		}
		$parts[] = $desc !== '' ? $title . ' (' . $desc . ')' : $title;
	}

	return implode( ', ', $parts );
}

/**
 * Wet room capacity tile detail, with optional walkthrough link.
 *
 * @param int $post_id Property page ID.
 * @return array{detail:string, detail_html:string}
 */
function restwell_get_property_wetroom_stat_detail( $post_id = 0 ) {
	$post_id = (int) $post_id;
	if ( $post_id <= 0 ) {
		$post_id = (int) get_the_ID();
	}

	$defaults = restwell_get_property_page_defaults();
	$base     = trim( (string) restwell_post_meta_or_default( $post_id, 'prop_bathroom', $defaults ) );
	$url      = function_exists( 'restwell_post_meta_url' )
		? restwell_post_meta_url( $post_id, 'prop_wetroom_walkthrough_url', $defaults )
		: trim( (string) restwell_post_meta_or_default( $post_id, 'prop_wetroom_walkthrough_url', $defaults ) );

	if ( $base === '' ) {
		$base = __( 'Roll-in shower with grab rails and adjustable basin.', 'restwell-retreats' );
	}

	if ( $url === '' ) {
		return array(
			'detail'      => $base,
			'detail_html' => '',
		);
	}

	$link_label = __( 'See a short walkthrough', 'restwell-retreats' );
	$link       = '<a href="' . esc_url( $url ) . '" class="rw-link-prose rw-link-prose--focus" target="_blank" rel="noopener noreferrer">'
		. esc_html( $link_label )
		. '<span class="sr-only"> ' . esc_html__( '(opens on YouTube)', 'restwell-retreats' ) . '</span></a>';

	$detail_html = esc_html( rtrim( $base, '. ' ) ) . '. ' . $link;

	return array(
		'detail'      => wp_strip_all_tags( $detail_html ),
		'detail_html' => $detail_html,
	);
}

/**
 * Practical stat tiles for the property page essentials panel.
 *
 * @param int $post_id Property page ID.
 * @return array<int, array{value:string, label:string, detail:string, icon:string}>
 */
function restwell_get_property_essentials_stats( $post_id = 0 ) {
	$post_id = (int) $post_id;
	if ( $post_id <= 0 ) {
		$post_id = (int) get_the_ID();
	}

	$d = restwell_get_property_page_defaults();
	$m = function ( $key ) use ( $post_id, $d ) {
		return restwell_post_meta_or_default( $post_id, $key, $d );
	};

	$parking_raw    = trim( (string) $m( 'prop_parking' ) );
	$parking_value  = $parking_raw;
	$parking_label  = __( 'Parking spaces', 'restwell-retreats' );
	$parking_detail = trim( (string) $m( 'prop_parking_detail' ) );
	if ( preg_match( '/^(\d+)\s*(.*)$/u', $parking_raw, $parking_matches ) ) {
		$parking_value = $parking_matches[1];
		if ( $parking_detail === '' ) {
			$parking_detail = trim( $parking_matches[2] );
		}
	}
	if ( $parking_detail !== '' ) {
		$parking_detail = ucfirst( $parking_detail );
	}

	$wetroom_detail = function_exists( 'restwell_get_property_wetroom_stat_detail' )
		? restwell_get_property_wetroom_stat_detail( $post_id )
		: array(
			'detail'      => trim( (string) $m( 'prop_bathroom' ) ),
			'detail_html' => '',
		);

	return array(
		array(
			'value'  => trim( (string) $m( 'prop_bedrooms_count' ) ),
			'label'  => __( 'Bedrooms', 'restwell-retreats' ),
			'detail' => trim( (string) $m( 'prop_bedrooms' ) ),
			'icon'   => 'bed',
		),
		array(
			'value'       => trim( (string) $m( 'prop_bathrooms_count' ) ),
			'label'       => __( 'Wet room', 'restwell-retreats' ),
			'detail'      => (string) ( $wetroom_detail['detail'] ?? '' ),
			'detail_html' => (string) ( $wetroom_detail['detail_html'] ?? '' ),
			'icon'        => 'bathtub',
		),
		array(
			'value'  => $parking_value,
			'label'  => $parking_label,
			'detail' => $parking_detail,
			'icon'   => 'car',
		),
		array(
			'value'  => trim( (string) $m( 'prop_sleeps_value' ) ),
			'label'  => __( 'Guests', 'restwell-retreats' ),
			'detail' => trim( (string) $m( 'prop_feature_3_desc' ) ),
			'icon'   => 'users-three',
		),
	);
}

/**
 * Feature list from property page meta.
 *
 * @param int $post_id Property page ID.
 * @return array<int, array{title:string, desc:string}>
 */
function restwell_get_property_features_list( $post_id = 0 ) {
	$post_id = (int) $post_id;
	if ( $post_id <= 0 ) {
		$post_id = (int) get_the_ID();
	}

	$d        = restwell_get_property_page_defaults();
	$m        = static function ( $key ) use ( $post_id, $d ) {
		return restwell_post_meta_or_default( $post_id, $key, $d );
	};
	$features = array();

	for ( $fi = 1; $fi <= 8; $fi++ ) {
		$title = trim( (string) $m( "prop_feature_{$fi}" ) );
		if ( $title === '' ) {
			continue;
		}
		$features[] = array(
			'title' => $title,
			'desc'  => trim( (string) $m( "prop_feature_{$fi}_desc" ) ),
		);
	}

	return $features;
}

/**
 * Practical section heading with stale AI copy replaced.
 *
 * @param int $post_id Property page ID.
 * @return string
 */
function restwell_get_property_practical_heading( $post_id = 0 ) {
	return restwell_get_property_heading( (int) $post_id, 'prop_practical_heading' );
}

/**
 * Room tour section heading with stale copy replaced.
 *
 * @param int $post_id Property page ID.
 * @return string
 */
function restwell_get_property_room_tour_heading( $post_id = 0 ) {
	$post_id = (int) $post_id;
	if ( $post_id <= 0 ) {
		$post_id = (int) get_the_ID();
	}

	$defaults = restwell_get_property_page_defaults();
	$heading  = trim( (string) restwell_post_meta_or_default( $post_id, 'prop_features_heading', $defaults ) );
	$stale    = array(
		'At a glance',
	);

	if ( $heading === '' || in_array( $heading, $stale, true ) ) {
		return __( 'What\'s in the house', 'restwell-retreats' );
	}

	return $heading;
}

/**
 * Keyword map for assigning glance features to room tour blocks.
 *
 * @return array<string, array<int, string>>
 */
function restwell_get_property_room_feature_keyword_map() {
	return array(
		'living'   => array(
			'kitchen',
			'conservatory',
			'broadband',
			'wi-fi',
			'wifi',
			'living room',
			'lounge',
			'open-plan',
			'open plan',
			'dining',
			'worksurface',
			'fireplace',
			'hamper',
		),
		'bedroom'  => array(
			'accessible bedroom',
			'bedroom',
			'profiling bed',
			'profiling',
			'ceiling track',
			'ceiling hoist',
			'hoist',
			'mattress',
			'double bed',
			'sleep',
			'beds',
			'sara stedy',
		),
		'wetroom'  => array(
			'wet room',
			'wetroom',
			'roll-in shower',
			'shower',
			'washroom',
			'bathroom',
			'grab rail',
			'wasbasin',
			'toilet',
			'geberit',
			'commode',
			'bathing',
		),
		'garden'   => array(
			'garden',
			'patio',
			'outdoor',
			'driveway',
			'parking',
			'drive',
			'exterior',
			'bbq',
			'lawn',
			'dog-friendly',
			'dog friendly',
		),
		'throughout' => array(
			'doorway',
			'door width',
			'wide door',
			'926',
			'965',
			'step-free',
			'step free',
			'level access',
			'throughout',
			'hallway',
			'entrance',
		),
	);
}

/**
 * Pick the best room key for a feature title and description.
 *
 * @param string                             $title       Feature title.
 * @param string                             $desc        Feature description.
 * @param array<string, array<int, string>>  $keyword_map Room keyword map.
 * @return string
 */
function restwell_match_property_feature_room_key( $title, $desc, $keyword_map ) {
	$haystack   = strtolower( trim( $title . ' ' . $desc ) );
	$best_key   = '';
	$best_score = 0;

	foreach ( $keyword_map as $room_key => $keywords ) {
		foreach ( $keywords as $keyword ) {
			$keyword = strtolower( trim( (string) $keyword ) );
			if ( $keyword === '' || ! str_contains( $haystack, $keyword ) ) {
				continue;
			}
			$score = strlen( $keyword );
			if ( $score > $best_score ) {
				$best_score = $score;
				$best_key   = (string) $room_key;
			}
		}
	}

	return $best_key !== '' ? $best_key : 'throughout';
}

/**
 * Standout fallback highlight when a room section has no matched features.
 *
 * @param string $room_key  Room tour key.
 * @param int    $post_id   Property page ID.
 * @return array{title:string, desc:string}
 */
function restwell_get_property_room_fallback_highlight( $room_key, $post_id = 0 ) {
	$post_id  = (int) $post_id;
	$room_key = (string) $room_key;
	$defaults = restwell_get_property_page_defaults();
	$m        = static function ( $key ) use ( $post_id, $defaults ) {
		return restwell_post_meta_or_default( $post_id, $key, $defaults );
	};

	$fallbacks = array(
		'living'     => array(
			'title' => __( 'Wheel-under kitchen worksurface', 'restwell-retreats' ),
			'desc'  => __( 'Open-plan living with conservatory access', 'restwell-retreats' ),
		),
		'bedroom'    => array(
			'title' => trim( (string) $m( 'prop_feature_5' ) ) ?: __( 'Ceiling track hoist', 'restwell-retreats' ),
			'desc'  => trim( (string) $m( 'prop_feature_5_desc' ) ) ?: __( 'Full room coverage in the accessible bedroom', 'restwell-retreats' ),
		),
		'wetroom'    => array(
			'title' => trim( (string) $m( 'prop_feature_2' ) ) ?: __( 'Accessible wet room', 'restwell-retreats' ),
			'desc'  => __( 'Roll-in shower, grab rails and adjustable basin', 'restwell-retreats' ),
		),
		'garden'     => array(
			'title' => trim( (string) $m( 'prop_feature_4' ) ) ?: __( 'Driveway for two cars', 'restwell-retreats' ),
			'desc'  => trim( (string) $m( 'prop_feature_4_desc' ) ) ?: __( 'Step-free patio and enclosed garden', 'restwell-retreats' ),
		),
		'throughout' => array(
			'title' => trim( (string) $m( 'prop_feature_6' ) ) ?: __( 'Step-free throughout', 'restwell-retreats' ),
			'desc'  => trim( (string) $m( 'prop_feature_6_desc' ) ) ?: __( 'Wide doorways on one level', 'restwell-retreats' ),
		),
	);

	if ( ! isset( $fallbacks[ $room_key ] ) ) {
		return array(
			'title' => '',
			'desc'  => '',
		);
	}

	$fallback = $fallbacks[ $room_key ];
	if ( trim( (string) ( $fallback['title'] ?? '' ) ) === '' ) {
		return array(
			'title' => '',
			'desc'  => '',
		);
	}

	return array(
		'title' => (string) $fallback['title'],
		'desc'  => (string) ( $fallback['desc'] ?? '' ),
	);
}

/**
 * Guarantee at least one highlight tick per room section.
 *
 * @param array<int, array{title:string, desc:string}> $highlights Assigned highlights.
 * @param string                                       $room_key   Room tour key.
 * @param int                                          $post_id    Property page ID.
 * @return array<int, array{title:string, desc:string}>
 */
function restwell_ensure_property_section_highlights( $highlights, $room_key, $post_id = 0 ) {
	$highlights = is_array( $highlights ) ? $highlights : array();
	if ( ! empty( $highlights ) ) {
		return $highlights;
	}

	$fallback = restwell_get_property_room_fallback_highlight( $room_key, $post_id );
	if ( (string) ( $fallback['title'] ?? '' ) === '' ) {
		return array();
	}

	return array( $fallback );
}

/**
 * Short nav label for a room tour section.
 *
 * @param array<string, mixed> $tour Room tour block.
 * @return string
 */
function restwell_get_property_room_nav_label( $tour ) {
	$key = (string) ( $tour['key'] ?? '' );
	$labels = array(
		'living'     => __( 'Living', 'restwell-retreats' ),
		'bedroom'    => __( 'Bedrooms', 'restwell-retreats' ),
		'bedrooms'   => __( 'Bedrooms', 'restwell-retreats' ),
		'wetroom'    => __( 'Wet room', 'restwell-retreats' ),
		'garden'     => __( 'Garden', 'restwell-retreats' ),
		'throughout' => __( 'Access', 'restwell-retreats' ),
	);

	if ( isset( $labels[ $key ] ) ) {
		return $labels[ $key ];
	}

	return trim( (string) ( $tour['heading'] ?? '' ) );
}

/**
 * Drop generic section labels that belong on the hero, not mid-page bands.
 *
 * @param string $label Raw label text.
 * @return string
 */
function restwell_sanitize_property_section_label( $label ) {
	$label = trim( (string) $label );
	if ( $label === '' ) {
		return '';
	}

	$stale = array(
		'the property',
		'property',
	);

	if ( in_array( strtolower( $label ), $stale, true ) ) {
		return '';
	}

	return $label;
}

/**
 * Room tour sections with glance features woven into each room block.
 *
 * @param int $post_id Property page ID.
 * @return array<int, array<string, mixed>>
 */
function restwell_get_property_room_tour_with_features( $post_id = 0 ) {
	if ( ! function_exists( 'restwell_get_property_room_tour_sections' ) ) {
		return array();
	}

	$sections    = restwell_get_property_room_tour_sections( $post_id );
	$features    = restwell_get_property_features_list( $post_id );
	$keyword_map = restwell_get_property_room_feature_keyword_map();

	if ( empty( $sections ) ) {
		return array();
	}

	$highlights_by_room = array();
	foreach ( $sections as $section ) {
		$highlights_by_room[ (string) ( $section['key'] ?? '' ) ] = array();
	}
	$highlights_by_room['throughout'] = array();

	foreach ( $features as $feature ) {
		$room_key = restwell_match_property_feature_room_key(
			(string) ( $feature['title'] ?? '' ),
			(string) ( $feature['desc'] ?? '' ),
			$keyword_map
		);
		if ( ! isset( $highlights_by_room[ $room_key ] ) ) {
			$highlights_by_room[ $room_key ] = array();
		}
		$highlights_by_room[ $room_key ][] = $feature;
	}

	$enriched = array();
	foreach ( $sections as $section ) {
		$key = (string) ( $section['key'] ?? '' );
		$section['highlights'] = restwell_ensure_property_section_highlights(
			$highlights_by_room[ $key ] ?? array(),
			$key,
			$post_id
		);
		$enriched[]            = $section;
	}

	return $enriched;
}

/**
 * Nearby place cards for the property page.
 *
 * @param int $post_id Property page ID.
 * @return array<int, array<string, string>>
 */
function restwell_get_property_nearby_places( $post_id = 0 ) {
	$post_id = (int) $post_id;
	if ( $post_id <= 0 ) {
		$post_id = (int) get_the_ID();
	}

	$d = restwell_get_property_page_defaults();
	$m = function ( $key ) use ( $post_id, $d ) {
		return restwell_post_meta_or_default( $post_id, $key, $d );
	};

	$icons = array( 'fork-knife', 'waves', 'shopping-bag', 'umbrella', 'shopping-cart', 'pill', 'bus', 'first-aid' );
	$types = array(
		__( 'Food and drink', 'restwell-retreats' ),
		__( 'The coast', 'restwell-retreats' ),
		__( 'Town and shops', 'restwell-retreats' ),
		__( 'The coast', 'restwell-retreats' ),
		__( 'Practical', 'restwell-retreats' ),
		__( 'Wellbeing', 'restwell-retreats' ),
		__( 'Transport', 'restwell-retreats' ),
		__( 'Wellbeing', 'restwell-retreats' ),
	);

	$places = array();
	for ( $ni = 1; $ni <= 8; $ni++ ) {
		$title = trim( (string) $m( "prop_nearby_{$ni}_title" ) );
		if ( $title === '' ) {
			continue;
		}
		$places[] = array(
			'title'    => $title,
			'body'     => (string) $m( "prop_nearby_{$ni}_body" ),
			'acc'      => (string) $m( "prop_nearby_{$ni}_acc" ),
			'distance' => (string) $m( "prop_nearby_{$ni}_distance" ),
			'filter'   => (string) $m( "prop_nearby_{$ni}_filter" ),
			'map_url'  => (string) $m( "prop_nearby_{$ni}_map_url" ),
			'icon'     => $icons[ $ni - 1 ] ?? 'map-pin',
			'type'     => $types[ $ni - 1 ] ?? '',
		);
	}

	return $places;
}
