<?php
/**
 * Verified property facts — single source of truth for specs reused across templates and schema.
 *
 * @package Restwell_Retreats
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Canonical verified property facts grouped by theme.
 *
 * @return array{
 *   access: array<int, string>,
 *   sleeping: array<int, string>,
 *   practical: array<int, string>
 * }
 */
function restwell_get_property_facts(): array {
	static $facts = null;

	if ( null !== $facts ) {
		return $facts;
	}

	$facts = array(
		'access'    => array(
			'Step-free throughout',
			'Front doorway 965mm clear',
			'Internal doorways 926mm clear',
			'Level-access wet room with shower chair and grab rails',
			'Ceiling track hoist over the profiling bed',
			'Threshold ramp to a level patio and garden',
		),
		'sleeping'  => array(
			'Two bedrooms, sleeps up to five',
			'Profiling bed with pressure-relieving mattress',
			'Sofa bed in the conservatory',
		),
		'practical' => array(
			'Driveway parking for two cars',
			'Fully equipped kitchen with reachable worktops',
			'High-speed broadband throughout',
		),
	);

	return $facts;
}

/**
 * One facts group, or all groups when $group is empty.
 *
 * @param string $group access|sleeping|practical, or '' for all.
 * @return array<int, string>|array<string, array<int, string>>
 */
function restwell_get_property_facts_group( string $group = '' ): array {
	$facts = restwell_get_property_facts();
	$group = (string) $group;

	if ( $group === '' ) {
		return $facts;
	}

	return isset( $facts[ $group ] ) ? $facts[ $group ] : array();
}

/**
 * Flat list of every verified fact label.
 *
 * @return array<int, string>
 */
function restwell_get_property_facts_flat(): array {
	$facts = restwell_get_property_facts();

	return array_values(
		array_merge(
			$facts['access'],
			$facts['sleeping'],
			$facts['practical']
		)
	);
}

/**
 * Homepage "at a glance" access strip (short, scannable subset).
 *
 * @return array<int, string>
 */
function restwell_get_property_facts_glance_strip(): array {
	$facts = restwell_get_property_facts();

	return array(
		$facts['access'][0],
		$facts['access'][4],
		$facts['access'][3],
		$facts['sleeping'][0],
		$facts['practical'][0],
	);
}

/**
 * Two or three verified facts per Who It's For persona.
 *
 * @param string $persona family|carers|ot|commissioners.
 * @return array<int, string>
 */
function restwell_get_property_facts_persona_bullets( string $persona ): array {
	$facts = restwell_get_property_facts();
	$persona = (string) $persona;

	switch ( $persona ) {
		case 'family':
			return array(
				$facts['access'][4],
				$facts['access'][3],
				$facts['access'][1],
			);
		case 'carers':
			return array(
				$facts['access'][4],
				$facts['access'][3],
				$facts['sleeping'][0],
			);
		case 'ot':
			return array(
				$facts['access'][1],
				$facts['access'][2],
				$facts['access'][4],
			);
		case 'commissioners':
			return array(
				$facts['access'][0],
				$facts['practical'][0],
				$facts['access'][3],
			);
		default:
			return array();
	}
}

/**
 * Travel / parking facts for the area guide parking section.
 *
 * @return array<int, string>
 */
function restwell_get_property_facts_area_travel(): array {
	$facts = restwell_get_property_facts();

	return array(
		$facts['practical'][0],
		$facts['access'][0],
	);
}

/**
 * Accessibility page room cards built from verified facts (headings still editable in WP meta).
 *
 * @param int $post_id Accessibility page ID.
 * @return array<int, array{heading: string, facts: array<int, string>}>
 */
function restwell_get_accessibility_rooms_from_facts( int $post_id = 0 ): array {
	$post_id = (int) $post_id;
	if ( $post_id <= 0 && is_singular( 'page' ) ) {
		$post_id = (int) get_queried_object_id();
	}

	$facts = restwell_get_property_facts();

	$heading = static function ( $meta_key, $fallback ) use ( $post_id ) {
		$stored = $post_id > 0 ? trim( (string) get_post_meta( $post_id, $meta_key, true ) ) : '';
		return $stored !== '' ? $stored : $fallback;
	};

	return array(
		array(
			'heading' => $heading( 'acc_arrival_heading', __( 'Arrival & entrance', 'restwell-retreats' ) ),
			'facts'   => array(
				$facts['practical'][0],
				$facts['access'][1],
				$facts['access'][0],
			),
		),
		array(
			'heading' => $heading( 'acc_inside_heading', __( 'Inside the property', 'restwell-retreats' ) ),
			'facts'   => array(
				$facts['access'][2],
				$facts['access'][0],
				$facts['access'][4],
			),
		),
		array(
			'heading' => $heading( 'acc_bedroom_heading', __( 'Bedrooms & sleeping', 'restwell-retreats' ) ),
			'facts'   => array(
				$facts['sleeping'][0],
				$facts['sleeping'][1],
				$facts['sleeping'][2],
				$facts['access'][4],
			),
		),
		array(
			'heading' => $heading( 'acc_bathroom_heading', __( 'Bathroom', 'restwell-retreats' ) ),
			'facts'   => array(
				$facts['access'][3],
			),
		),
		array(
			'heading' => $heading( 'acc_kitchen_heading', __( 'Kitchen', 'restwell-retreats' ) ),
			'facts'   => array(
				$facts['practical'][1],
			),
		),
		array(
			'heading' => $heading( 'acc_outdoor_heading', __( 'Outdoor spaces', 'restwell-retreats' ) ),
			'facts'   => array(
				$facts['access'][5],
			),
		),
	);
}

/**
 * Property page room-tour keys mapped to relevant verified facts.
 *
 * @return array<string, array<int, string>>
 */
function restwell_get_property_facts_by_room_key(): array {
	$facts = restwell_get_property_facts();

	return array(
		'throughout' => array(
			$facts['access'][0],
			$facts['access'][1],
			$facts['access'][2],
		),
		'bedroom'    => array(
			$facts['sleeping'][0],
			$facts['sleeping'][1],
			$facts['access'][4],
		),
		'wetroom'    => array(
			$facts['access'][3],
		),
		'living'     => array(
			$facts['practical'][1],
			$facts['practical'][2],
			$facts['sleeping'][2],
		),
		'garden'     => array(
			$facts['access'][5],
			$facts['practical'][0],
		),
	);
}

/**
 * Convert verified fact labels into room-tour highlight rows.
 *
 * @param array<int, string> $fact_labels Fact labels.
 * @return array<int, array{title: string, desc: string}>
 */
function restwell_property_facts_to_highlights( array $fact_labels ): array {
	$highlights = array();

	foreach ( $fact_labels as $label ) {
		$label = trim( (string) $label );
		if ( $label === '' ) {
			continue;
		}
		$highlights[] = array(
			'title' => $label,
			'desc'  => '',
		);
	}

	return $highlights;
}

/**
 * FAQ answer: whole-house wheelchair accessibility (plain text).
 *
 * @return string
 */
function restwell_get_property_facts_faq_wheelchair_answer(): string {
	$facts = restwell_get_property_facts();

	return sprintf(
		/* translators: %1$s: step-free fact, %2$s: front door width, %3$s: internal door width, %4$s: wet room fact, %5$s: garden access fact. */
		__(
			'The bungalow is single-storey and %1$s, with a %2$s, %3$s, a %4$s and a %5$s.',
			'restwell-retreats'
		),
		strtolower( $facts['access'][0] ),
		strtolower( $facts['access'][1] ),
		strtolower( $facts['access'][2] ),
		strtolower( $facts['access'][3] ),
		strtolower( $facts['access'][5] )
	);
}

/**
 * FAQ answer: published accessibility features overview (plain text).
 *
 * @return string
 */
function restwell_get_property_facts_faq_features_answer(): string {
	$facts = restwell_get_property_facts();

	return sprintf(
		/* translators: %1$s–%5$s: verified fact phrases. */
		__(
			'Verified on site: %1$s, %2$s, %3$s, %4$s, and %5$s. Full room-by-room detail is on our accessibility page.',
			'restwell-retreats'
		),
		$facts['access'][0],
		$facts['access'][1],
		$facts['access'][2],
		$facts['access'][4],
		$facts['access'][3]
	);
}

/**
 * FAQ answer: hoist and profiling bed suitability (plain text).
 *
 * @return string
 */
function restwell_get_property_facts_faq_hoist_answer(): string {
	$facts = restwell_get_property_facts();

	$answer = sprintf(
		/* translators: %1$s: hoist fact, %2$s: profiling bed fact. */
		__(
			'Yes. The accessible bedroom has a %1$s and %2$s, and there is a level-access wet room with a shower chair, shower stool and grab rails on the same single-storey level.',
			'restwell-retreats'
		),
		strtolower( $facts['access'][4] ),
		strtolower( $facts['sleeping'][1] )
	);

	// Confirm in WP: perching stool, adjustable washbasin.
	return $answer . ' ' . __(
		'If you have additional or specialist equipment needs, please get in touch before booking so we can confirm we can accommodate them.',
		'restwell-retreats'
	);
}

/**
 * LocationFeatureSpecification rows for JSON-LD from verified facts.
 *
 * @return array<int, array<string, mixed>>
 */
function restwell_get_property_facts_amenity_features(): array {
	$amenities = array();

	// Confirm in WP: perching stool, adjustable washbasin.
	foreach ( restwell_get_property_facts_flat() as $fact ) {
		$amenities[] = array(
			'@type' => 'LocationFeatureSpecification',
			'name'  => $fact,
			'value' => true,
		);
	}

	return $amenities;
}

/**
 * Replace access-related FAQ answers with verified property facts (visible text + JSON-LD stay aligned).
 *
 * @param array<int, array{q: string, a: string, cat: string, answer_text?: string}> $items FAQ rows.
 * @return array<int, array{q: string, a: string, cat: string, answer_text?: string}>
 */
function restwell_apply_property_facts_to_faq_items( array $items ): array {
	$answer_map = array();

	if ( function_exists( 'restwell_get_property_facts_faq_features_answer' ) ) {
		$answer_map[ 'what accessibility features does the property have?' ] = restwell_get_property_facts_faq_features_answer();
	}
	if ( function_exists( 'restwell_get_property_facts_faq_hoist_answer' ) ) {
		$answer_map[ 'is the property suitable for hoists and profiling beds?' ] = restwell_get_property_facts_faq_hoist_answer();
	}
	if ( function_exists( 'restwell_get_property_facts_faq_wheelchair_answer' ) ) {
		$answer_map[ 'is the whole house wheelchair accessible?' ] = restwell_get_property_facts_faq_wheelchair_answer();
	}

	if ( empty( $answer_map ) ) {
		return $items;
	}

	foreach ( $items as $index => $item ) {
		$key = strtolower( trim( (string) ( $item['q'] ?? '' ) ) );
		if ( $key === '' || ! isset( $answer_map[ $key ] ) ) {
			continue;
		}
		$answer = (string) $answer_map[ $key ];
		$items[ $index ]['a'] = $answer;
		$items[ $index ]['answer_text'] = $answer;
	}

	return $items;
}
