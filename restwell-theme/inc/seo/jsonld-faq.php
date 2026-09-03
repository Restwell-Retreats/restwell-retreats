<?php
/**
 * JSON-LD FAQPage graphs (home, FAQ, pricing, funding, care).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Homepage FAQ pairs (legacy q/a shape for theme setup seed map).
 *
 * Content comes from inc/homepage-faq.php via restwell_get_faq_items( 'homepage' ).
 * Front page post meta home_faq_{1..7}_{q,a} is no longer read for FAQ copy.
 *
 * @param int $page_id Front page post ID (unused for FAQ copy; kept for filter signature).
 * @return array<int, array{q: string, a: string}>
 */
function restwell_get_homepage_faq_pairs( $page_id = 0 ) {
	$page_id = (int) $page_id;
	$pairs   = array();

	if ( function_exists( 'restwell_get_faq_items' ) ) {
		foreach ( restwell_get_faq_items( 'homepage' ) as $item ) {
			if ( empty( $item['q'] ) || empty( $item['a'] ) ) {
				continue;
			}
			$pairs[] = array(
				'q' => $item['q'],
				'a' => $item['a'],
			);
		}
	}

	/**
	 * Filter homepage FAQ pairs before output (theme setup seed map).
	 *
	 * @param array<int, array{q: string, a: string}> $pairs   Pairs to show.
	 * @param int                                     $page_id Front page ID.
	 */
	return apply_filters( 'restwell_homepage_faq_pairs', $pairs, $page_id );
}

/**
 * Flat post meta for homepage FAQ section (Theme Setup seed + one-time migration).
 * Keys match page-meta-definitions and front-page.php.
 *
 * @return array<string, string>
 */
function restwell_get_homepage_faq_meta_seed_map() {
	$pairs = restwell_get_homepage_faq_pairs( 0 );
	$out   = array(
		'home_faq_label'   => __( 'Quick answers', 'restwell-retreats' ),
		'home_faq_heading' => __( 'The questions that stop an enquiry', 'restwell-retreats' ),
	);
	foreach ( $pairs as $i => $p ) {
		$n = $i + 1;
		$out[ 'home_faq_' . $n . '_q' ] = $p['q'];
		$out[ 'home_faq_' . $n . '_a' ] = $p['a'];
	}
	return $out;
}

/**
 * Output FAQPage JSON-LD on the front page (pairs must match visible content).
 */
function restwell_output_jsonld_homepage_faq() {
	$front_id = (int) get_option( 'page_on_front', 0 );
	if ( $front_id <= 0 ) {
		return;
	}

	$pairs = function_exists( 'restwell_get_faq_items' ) ? restwell_get_faq_items( 'homepage' ) : array();
	if ( empty( $pairs ) ) {
		return;
	}

	$main_entity = array();
	foreach ( $pairs as $pair ) {
		if ( empty( $pair['q'] ) || empty( $pair['a'] ) ) {
			continue;
		}

		$answer_text = '';
		if ( ! empty( $pair['answer_text'] ) ) {
			$answer_text = $pair['answer_text'];
		} else {
			$answer_text = wp_strip_all_tags( $pair['a'] );
		}

		$main_entity[] = array(
			'@type'          => 'Question',
			'name'           => wp_strip_all_tags( $pair['q'] ),
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => $answer_text,
			),
		);
	}

	if ( empty( $main_entity ) ) {
		return;
	}

	$schema = array(
		'@context'   => 'https://schema.org',
		'@type'      => 'FAQPage',
		'mainEntity' => $main_entity,
	);

	restwell_print_jsonld( $schema );
}

/**
 * Default FAQ Q/A for the FAQ page template and matching FAQPage JSON-LD (single source of truth).
 *
 * @return array<int, array{q: string, a: string, cat: string}>
 */
function restwell_get_faq_page_default_pairs() {
	// Broader set -- kept distinct from per-page FAQs (homepage, how-it-works) to prevent duplicate-content cannibalisation.
	return array(
		array(
			'q'   => 'Is Restwell a care home?',
			'a'   => 'No. It’s a private adapted bungalow that you rent as a holiday, and the whole house is yours for the stay. There’s no staff on site and nobody has a key but you. If you’d like professional care while you’re here, that comes separately from our sister company. See <a href="/optional-care/">Optional care</a>.',
			'cat' => 'about',
		),
		array(
			'q'   => 'Is it a respite centre?',
			'a'   => 'No, though your funder may well use the word respite, and that’s fine. It’s often how a break like this gets described on paperwork. It’s still a private house rather than a registered respite service.',
			'cat' => 'about',
		),
		array(
			'q'   => 'Will a wheelchair actually fit?',
			'a'   => 'The house is single-storey and step-free throughout. The front door has a 965mm clear opening, the internal doorways are 926mm, the wet room is level-access, and there’s a ceiling track hoist over the profiling bed. If you need a measurement we haven’t published, ask and we’ll go and take it. See the <a href="/accessibility/">access statement</a>.',
			'cat' => 'about',
		),
		array(
			'q'   => 'Is there a hoist, and what’s it rated to?',
			'a'   => 'There’s a ceiling track hoist rated to 180kg, and an electric mobile hoist also rated to 180kg. Both are subject to a LOLER thorough examination every six months. Guests bring their own slings, because a sling needs to fit the person.',
			'cat' => 'about',
		),
		array(
			'q'   => 'Can we have two profiling beds?',
			'a'   => 'Yes. We arrange the accessible bedroom around each guest: one profiling bed if that’s what you need, two if it isn’t. Tell us when you book so it’s set up before you arrive.',
			'cat' => 'about',
		),
		array(
			'q'   => 'How many people does it sleep?',
			'a'   => 'Five. There are two bedrooms and a double sofa bed in the conservatory. Five is what our safety checks are based on, so we do have to hold to it.',
			'cat' => 'about',
		),
		array(
			'q'   => 'Can we add home care?',
			'a'   => 'Yes. Continuity of Care Services, our sister company, can come into the bungalow, anything from a morning visit to nurse-led support. Mention it on the same enquiry as the house and we’ll work it out together. See <a href="/optional-care/">Optional care</a>.',
			'cat' => 'care',
		),
		array(
			'q'   => 'How far ahead do we need to arrange the care?',
			'a'   => 'The sooner you ask, the more likely we can say yes. We don’t publish a lead time because it honestly depends on what you need and who’s available that week, and we’d rather give you a real answer quickly than a number we’ve invented.',
			'cat' => 'care',
		),
		array(
			'q'   => 'Can we bring our own carer or PA?',
			'a'   => 'Of course, and the price doesn’t change. A support worker can use the second bedroom, or we can think through the sleeping arrangements with you.',
			'cat' => 'care',
		),
		array(
			'q'   => 'How far is the bungalow from the seafront?',
			'a'   => 'About ten minutes on foot from the driveway. Places along Tankerton promenade take longer, because you walk down to the sea first and then head west along the prom. JoJo’s is roughly twenty minutes all in. See the <a href="/whitstable-area-guide/">Whitstable guide</a>.',
			'cat' => 'local',
		),
		array(
			'q'   => 'What does it cost, and what’s included?',
			'a'   => 'A week is £1,300 off-peak and £1,400 in peak season, with all the access equipment, linen, towels and parking included. A 50% deposit reserves your dates and the balance follows a week before arrival. See <a href="/pricing/">Pricing & dates</a>.',
			'cat' => 'booking',
		),
		array(
			'q'   => 'Can a council or the NHS pay?',
			'a'   => 'We can invoice you, a local authority, the NHS or a grant body, and the rate is identical either way. What we can’t do is promise your package will cover a holiday. That decision sits with your social worker or case manager. See <a href="/funding-and-support/">Funding and support</a>.',
			'cat' => 'funding',
		),
		array(
			'q'   => 'Can we use direct payments?',
			'a'   => 'Some guests do, for the accommodation or for a PA’s time. The rules vary by area, so start with your own care team. See <a href="/direct-payment-holiday-accommodation/">direct payments</a>.',
			'cat' => 'funding',
		),
		array(
			'q'   => 'Are dogs allowed?',
			'a'   => 'Yes, with a bit of notice so we can run a quick risk assessment. Assistance dogs are welcome on the same terms.',
			'cat' => 'about',
		),
		array(
			'q'   => 'What time is check-in?',
			'a'   => 'From 3pm, through a key safe, with the code sent to you beforehand. Check-out is by 11am, and if you need longer for personal care or transport, tell us a few days ahead and we’ll do our best. See <a href="/how-it-works/">How it works</a>.',
			'cat' => 'booking',
		),
	);
}

/**
 * FAQPage - output on the FAQ template.
 */
function restwell_output_jsonld_faq_page() {
	$pid = get_queried_object_id();
	if ( ! $pid ) {
		return;
	}

	// Use centralised helper so JSON-LD mirrors the same data as the template.
	$faq_pairs = function_exists( 'restwell_get_faq_items' ) ? restwell_get_faq_items( 'faq-page' ) : array();

	$main_entity = array();
	foreach ( $faq_pairs as $pair ) {
		$main_entity[] = array(
			'@type'          => 'Question',
			'name'           => wp_strip_all_tags( $pair['q'] ),
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => wp_strip_all_tags( isset( $pair['answer_text'] ) ? $pair['answer_text'] : $pair['a'] ),
			),
		);
	}

	$schema = array(
		'@context'   => 'https://schema.org',
		'@type'      => 'FAQPage',
		'mainEntity' => $main_entity,
	);

	restwell_print_jsonld( $schema );
}

/**
 * FAQPage for the Pricing template (same Q&A as the visible accordion).
 */
function restwell_output_jsonld_pricing_faq() {
	$pid = get_queried_object_id();
	if ( ! $pid ) {
		return;
	}

	$faq_pairs = function_exists( 'restwell_get_faq_items' ) ? restwell_get_faq_items( 'pricing' ) : array();
	if ( empty( $faq_pairs ) ) {
		return;
	}

	$main_entity = array();
	foreach ( $faq_pairs as $pair ) {
		$main_entity[] = array(
			'@type'          => 'Question',
			'name'           => wp_strip_all_tags( $pair['q'] ),
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => wp_strip_all_tags( isset( $pair['answer_text'] ) ? $pair['answer_text'] : $pair['a'] ),
			),
		);
	}

	$schema = array(
		'@context'   => 'https://schema.org',
		'@type'      => 'FAQPage',
		'mainEntity' => $main_entity,
	);

	restwell_print_jsonld( $schema );
}

/**
 * FAQ pairs for the Funding & Support page (must match visible accordion copy).
 *
 * @return array<int, array{q: string, a: string}>
 */
function restwell_get_resources_faq_pairs() {
	return array(
		array(
			'q' => 'Can NHS Continuing Healthcare funding be used for a holiday?',
			'a' => 'It can cover the care hours you’re already assessed for, if your CHC team agrees in writing. It doesn’t pay for the holiday itself, so the bungalow, travel and food are usually yours unless a panel says otherwise. Ask them which costs they’ll take, then tell us who to invoice.',
		),
		array(
			'q' => 'Can I get an NHS-funded holiday in the UK?',
			'a' => 'There isn’t a general scheme where the NHS pays for holidays. Your assessed care can sometimes continue while you’re away. Treat the house, travel and care as separate costs, and get each one clear in writing.',
		),
		array(
			'q' => 'Can I use direct payments for a short break or holiday in England?',
			'a' => 'Yes, if it fits your support plan. Councils can’t ban short breaks as a blanket rule. The bungalow rent is only in if the plan names it, and food and souvenirs usually aren’t. Check with your social worker before you pay a deposit.',
		),
		array(
			'q' => 'Can a personal budget support a holiday or short break?',
			'a' => 'A Care Act personal budget can support a short break if that’s an assessed need. Keep general holiday spending off that line, and talk the wording through with your social worker. We can send the access statement to go on the file.',
		),
		array(
			'q' => 'How do I use NHS CHC funding for a short break?',
			'a' => 'Speak to your CHC coordinator and ask which hours continue away from home. Enquire with Restwell, and Continuity can quote the care on the same call. We’ll send the access statement; you agree who receives which invoice.',
		),
		array(
			'q' => 'What if my funding application is refused?',
			'a' => 'You can ask for a review. For a local authority decision, that’s your council first (Kent County Council if they funded the assessment), then the Local Government Ombudsman. For NHS CHC, follow the ICB appeals process, then the Parliamentary and Health Service Ombudsman. Scope and Beacon can advise either way, and we’re happy to resend the paperwork.',
		),
	);
}

/**
 * FAQPage JSON-LD for Funding & Support.
 */
function restwell_output_jsonld_resources_faq() {
	$pairs = restwell_get_resources_faq_pairs();
	if ( empty( $pairs ) ) {
		return;
	}
	$entities = array();
	foreach ( $pairs as $pair ) {
		$entities[] = array(
			'@type'          => 'Question',
			'name'           => $pair['q'],
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => $pair['a'],
			),
		);
	}
	restwell_print_jsonld(
		array(
			'@context'   => 'https://schema.org',
			'@type'      => 'FAQPage',
			'mainEntity' => $entities,
		)
	);
}

/**
 * FAQ pairs for the Optional care page (must match visible accordion copy).
 *
 * @return array<int, array{q: string, a: string}>
 */
function restwell_get_care_faq_pairs() {
	$pricing_url = function_exists( 'restwell_nav_resolve_page_url' )
		? restwell_nav_resolve_page_url( 'pricing' )
		: home_url( '/pricing/' );
	return array(
		array(
			'q' => 'Do I have to book care?',
			'a' => 'No. Many guests book the house as a self-catering holiday and need no additional support. Continuity care is optional.',
		),
		array(
			'q' => 'Is Restwell a care home?',
			'a' => 'No. Restwell is a private holiday bungalow. Continuity of Care Services (our sister company) is the CQC-regulated provider if you want professional care during your stay.',
		),
		array(
			'q' => 'Do I book care separately?',
			'a' => 'No. Ask when you enquire about the bungalow. Restwell and Continuity share 01622 809881, so house and care can start in one conversation when you want both.',
		),
		array(
			'q' => 'Can I bring my own carers?',
			'a' => 'Yes. The layout supports familiar routines, with separate sleeping and space to assist. Tell us your party layout when you enquire.',
		),
		array(
			'q' => 'Where do I see guide rates?',
			'a' => 'On Pricing & dates (' . $pricing_url . '#care-rates). They are Continuity guide rates only. Continuity quotes your care cost once hours and tasks are agreed.',
		),
	);
}

/**
 * FAQPage JSON-LD for Optional care.
 */
function restwell_output_jsonld_care_faq() {
	$pairs = restwell_get_care_faq_pairs();
	if ( empty( $pairs ) ) {
		return;
	}
	$entities = array();
	foreach ( $pairs as $pair ) {
		$entities[] = array(
			'@type'          => 'Question',
			'name'           => $pair['q'],
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => $pair['a'],
			),
		);
	}
	restwell_print_jsonld(
		array(
			'@context'   => 'https://schema.org',
			'@type'      => 'FAQPage',
			'mainEntity' => $entities,
		)
	);
}
