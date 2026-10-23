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
		'No, it’s a private bungalow you rent as a holiday. The whole house is yours, and there are no staff on site. If you’d like home care while you’re here, our sister company, Continuity, can arrange it.',
		'restwell-retreats'
	);
	$q1_html = '<p>' . esc_html( $q1_text ) . '</p>';

	$q2_lead = __( 'The bungalow is on one level and step-free throughout. The front door has a 965mm clear opening and the doors inside are 926mm. The', 'restwell-retreats' );
	$q2_link = __( 'wet room and hoist measurements', 'restwell-retreats' );
	$q2_tail = __( 'are published too, flattering or not, so you can check your own kit first.', 'restwell-retreats' );
	$q2_text = $q2_lead . ' ' . $q2_link . ' ' . $q2_tail;
	// Home's one in-body link to the Accessibility hub (blueprint linking map).
	$q2_url  = function_exists( 'restwell_nav_resolve_page_url' ) ? restwell_nav_resolve_page_url( 'accessibility' ) : home_url( '/accessibility/' );
	$q2_html = '<p>' . esc_html( $q2_lead ) . ' <a class="text-link" href="' . esc_url( $q2_url ) . '">' . esc_html( $q2_link ) . '</a> ' . esc_html( $q2_tail ) . '</p>';

	$q3_text = __(
		'Yes, Continuity of Care Services can come in while you’re staying. They’ll give you a quote once you’ve talked through what you need. Just mention it when you enquire, or ring us on 01622 809881.',
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
