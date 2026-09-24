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
		'No. It’s a private bungalow you rent as a holiday — the whole house is yours, with no staff on site. Optional home care comes from our sister company, Continuity, and is arranged separately if you want it.',
		'restwell-retreats'
	);
	$q1_html = '<p>' . esc_html( $q1_text ) . '</p>';

	$q2_text = __(
		'Single-storey and step-free throughout: a 965mm front door, 926mm internal doors, a level-access wet room, and a ceiling track hoist over the profiling bed. Every measurement is published on the Accessibility page — including the ones that aren’t flattering.',
		'restwell-retreats'
	);
	$q2_html = '<p>' . esc_html( $q2_text ) . '</p>';

	$q3_text = __(
		'Yes. Continuity of Care Services can come in while you’re staying. Care is quoted separately from the bungalow. Mention it when you enquire, or ring us on 01622 809881.',
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
