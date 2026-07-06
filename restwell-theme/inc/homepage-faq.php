<?php
/**
 * Homepage FAQ content (Git-managed).
 *
 * Source of truth for copy and schema: SEO-INTENT-ONPAGE-PLAN.md §13.1 and §4.1
 * Step D (2026-05-25) for https://restwellretreats.co.uk/
 *
 * Consumed by restwell_get_faq_items( 'homepage' ) in inc/faq.php (accordion +
 * FAQPage JSON-LD). Other scopes still use the FAQ template page in WP.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default homepage FAQ items (five pairs).
 *
 * @return array<int, array{
 *   id: string,
 *   question: string,
 *   answer_html: string,
 *   answer_text: string,
 *   cat: string
 * }>
 */
function restwell_get_homepage_faq_defaults(): array {
	$accessibility_url = esc_url( home_url( '/accessibility/' ) );
	$resources_url     = esc_url( home_url( '/resources/' ) );
	$enquire_url       = esc_url( home_url( '/enquire/' ) );

	return array(
		array(
			'id'          => 'faq_1',
			'question'    => __( 'Is the whole house wheelchair accessible?', 'restwell-retreats' ),
			'answer_html' => __(
				'The bungalow is single-storey and step-free throughout, with a 965mm front doorway, 926mm internal doorways, a level-access wet room and a threshold ramp to the garden.',
				'restwell-retreats'
			),
			'answer_text' => __(
				'The bungalow is single-storey and step-free throughout, with a 965mm front doorway, 926mm internal doorways, a level-access wet room and a threshold ramp to the garden.',
				'restwell-retreats'
			),
			'cat'         => 'about',
		),
		array(
			'id'          => 'faq_2',
			'question'    => __( 'Can I arrange care during my stay?', 'restwell-retreats' ),
			'answer_html' => __(
				'Yes. Care is optional and arranged locally through Continuity Care Services, from companionship and domiciliary care to complex and 24/7 support.',
				'restwell-retreats'
			),
			'answer_text' => __(
				'Yes. Care is optional and arranged locally through Continuity Care Services, from companionship and domiciliary care to complex and 24/7 support.',
				'restwell-retreats'
			),
			// Confirm in WP: CQC registration wording and how far ahead to book.
			'cat'         => 'care',
		),
		array(
			'id'          => 'faq_3',
			'question'    => __( 'How many people does it sleep?', 'restwell-retreats' ),
			'answer_html' => __(
				'Up to five, across two bedrooms plus a sofa bed in the conservatory.',
				'restwell-retreats'
			),
			'answer_text' => __(
				'Up to five, across two bedrooms plus a sofa bed in the conservatory.',
				'restwell-retreats'
			),
			'cat'         => 'about',
		),
		array(
			'id'          => 'faq_4',
			'question'    => __( 'Where exactly is Restwell?', 'restwell-retreats' ),
			'answer_html' => __(
				'On a quiet street in Whitstable, Kent, about ten minutes from the seafront and the Tankerton Slopes promenade.',
				'restwell-retreats'
			),
			'answer_text' => __(
				'On a quiet street in Whitstable, Kent, about ten minutes from the seafront and the Tankerton Slopes promenade.',
				'restwell-retreats'
			),
			'cat'         => 'local',
		),
		array(
			'id'          => 'faq_5',
			'question'    => __( 'Is Restwell only for wheelchair users?', 'restwell-retreats' ),
			'answer_html' => __(
				'The house is built around wheelchair users, hoist users and travellers with complex care needs, and the calm single-storey layout and quiet street also suit guests with sensory, cognitive or neurodivergent needs.',
				'restwell-retreats'
			),
			'answer_text' => __(
				'The house is built around wheelchair users, hoist users and travellers with complex care needs, and the calm single-storey layout and quiet street also suit guests with sensory, cognitive or neurodivergent needs.',
				'restwell-retreats'
			),
			'cat'         => 'about',
		),
	);
}
