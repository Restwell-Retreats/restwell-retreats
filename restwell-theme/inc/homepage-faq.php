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
			'question'    => __( 'What is Restwell Retreats in Whitstable?', 'restwell-retreats' ),
			'answer_html' => __(
				'Restwell Retreats is a private wheelchair-accessible self-catering holiday bungalow in Whitstable, Kent. You book the whole property for guests, families, and carers. Care is optional and arranged separately through Continuity of Care Services (CQC-regulated); it is not included in the rental.',
				'restwell-retreats'
			),
			'answer_text' => __(
				'Restwell Retreats is a private wheelchair-accessible self-catering holiday bungalow in Whitstable, Kent. You book the whole property for guests, families, and carers. Care is optional and arranged separately through Continuity of Care Services (CQC-regulated); it is not included in the rental.',
				'restwell-retreats'
			),
			'cat'         => 'about',
		),
		array(
			'id'          => 'faq_2',
			'question'    => __( 'Is there wheelchair accessible self catering in Whitstable with a hoist?', 'restwell-retreats' ),
			'answer_html' => sprintf(
				/* translators: %s: accessibility page URL */
				__(
					'Yes. Restwell is a single-storey adapted bungalow with a ceiling track hoist in the accessible bedroom, a profiling bed, and a roll-in wet room on the same level. Check measurements and equipment on our <a href="%s">Accessibility</a> page before you book.',
					'restwell-retreats'
				),
				$accessibility_url
			),
			'answer_text' => __(
				'Yes. Restwell is a single-storey adapted bungalow with a ceiling track hoist in the accessible bedroom, a profiling bed, and a roll-in wet room on the same level. Check measurements and equipment on our Accessibility page before you book.',
				'restwell-retreats'
			),
			'cat'         => 'about',
		),
		array(
			'id'          => 'faq_3',
			'question'    => __( 'Can I use direct payments or NHS Continuing Healthcare toward a stay at Restwell?', 'restwell-retreats' ),
			'answer_html' => sprintf(
				/* translators: %s: funding and support page URL */
				__(
					'Many guests use personal budgets or direct payments, subject to your care plan. NHS Continuing Healthcare for care during your stay depends on your package: speak to your case manager. We can provide documentation to support applications. See <a href="%s">Funding &amp; Support</a> for routes in plain English.',
					'restwell-retreats'
				),
				$resources_url
			),
			'answer_text' => __(
				'Many guests use personal budgets or direct payments, subject to your care plan. NHS Continuing Healthcare for care during your stay depends on your package: speak to your case manager. We can provide documentation to support applications. See Funding and Support for routes in plain English.',
				'restwell-retreats'
			),
			'cat'         => 'funding',
		),
		array(
			'id'          => 'faq_4',
			'question'    => __( 'How do I book the whole property for a guest and carer?', 'restwell-retreats' ),
			'answer_html' => sprintf(
				/* translators: %s: enquiry page URL */
				__(
					'Start with our <a href="%s">enquiry form</a> or contact us by phone or email. We confirm availability, talk through access needs, then agree dates. There is no obligation until you are ready. Cancellation terms depend on how close your stay is; we confirm the policy when you book.',
					'restwell-retreats'
				),
				$enquire_url
			),
			'answer_text' => __(
				'Start with our enquiry form or contact us by phone or email. We confirm availability, talk through access needs, then agree dates. There is no obligation until you are ready. Cancellation terms depend on how close your stay is; we confirm the policy when you book.',
				'restwell-retreats'
			),
			'cat'         => 'booking',
		),
		array(
			'id'          => 'faq_5',
			'question'    => __( 'What accessibility equipment is included at Restwell?', 'restwell-retreats' ),
			'answer_html' => sprintf(
				/* translators: %s: accessibility page URL */
				__(
					'The accessible bedroom has a ceiling track hoist and profiling bed. The wet room has roll-in shower access, grab rails, and a height-adjustable washbasin. Level access and two off-road parking spaces are on the private drive. Full detail is on our <a href="%s">Accessibility</a> page.',
					'restwell-retreats'
				),
				$accessibility_url
			),
			'answer_text' => __(
				'The accessible bedroom has a ceiling track hoist and profiling bed. The wet room has roll-in shower access, grab rails, and a height-adjustable washbasin. Level access and two off-road parking spaces are on the private drive. Full detail is on our Accessibility page.',
				'restwell-retreats'
			),
			'cat'         => 'about',
		),
	);
}
