<?php
/**
 * Homepage FAQ content (Git-managed).
 *
 * Visible accordion and FAQPage JSON-LD both read
 * restwell_get_faq_items( 'homepage' ).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default homepage FAQ items (three pairs; must match Home visible copy).
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
	$q1_text = __(
		'No. It’s a private bungalow holiday: one house, by the sea, for your party alone. Home care is optional and comes from our sister company if you want it.',
		'restwell-retreats'
	);
	$q1_html = '<p>' . esc_html( $q1_text ) . '</p>';

	$q2_text = __(
		'The house is single-storey and step-free throughout. The front door is 965mm, internal doorways are 926mm, the wet room is level-access, and there’s a ceiling hoist over the profiling bed. If you need a measurement we haven’t published, just ask and we’ll go and measure it.',
		'restwell-retreats'
	);
	$q2_html = '<p>' . esc_html( $q2_text ) . '</p>';

	$q3_text = __(
		'Yes. Continuity of Care Services can come in while you’re staying. Mention it when you enquire, or ring us on 01622 809881.',
		'restwell-retreats'
	);
	$q3_html = '<p>' . esc_html( $q3_text ) . '</p>';

	return array(
		array(
			'id'          => 'faq_1',
			'question'    => __( 'Is Restwell a care home?', 'restwell-retreats' ),
			'answer_html' => $q1_html,
			'answer_text' => $q1_text,
			'cat'         => 'about',
		),
		array(
			'id'          => 'faq_2',
			'question'    => __( 'Will a wheelchair actually fit?', 'restwell-retreats' ),
			'answer_html' => $q2_html,
			'answer_text' => $q2_text,
			'cat'         => 'about',
		),
		array(
			'id'          => 'faq_3',
			'question'    => __( 'Can we add home care?', 'restwell-retreats' ),
			'answer_html' => $q3_html,
			'answer_text' => $q3_text,
			'cat'         => 'care',
		),
	);
}
