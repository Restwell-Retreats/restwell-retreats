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
 * Default FAQ Q/A for the FAQ page template and matching FAQPage JSON-LD (single source of truth).
 *
 * @return array<int, array{q: string, a: string, cat: string}>
 */
function restwell_get_faq_page_default_pairs() {
	// Broader set -- kept distinct from per-page FAQs (homepage, how-it-works) to prevent duplicate-content cannibalisation.
	return array(
		array(
			'q'   => 'Is Restwell a care home or a respite centre?',
			'a'   => 'No. Restwell is a private bungalow that you rent as a holiday, so the house is yours and there are no staff on site. If you’d like home care while you’re here, our sister company, Continuity of Care Services, can provide it. Your funder may call the break respite on their paperwork, and that’s fine.',
			'cat' => 'about',
		),
		array(
			'q'   => 'Can we book just one night?',
			'a'   => 'Yes. The minimum stay is one night, so you can book anything from a single night to a full week or more. The nightly and weekly rates are on <a href="/pricing/">Prices and dates</a>.',
			'cat' => 'booking',
		),
		array(
			'q'   => 'What are the door widths, and will my wheelchair fit?',
			'a'   => 'The bungalow is all on one level and step-free throughout. The front door has a 965mm clear opening and the doors inside are 926mm, so you can check those against your own chair. If you need a measurement we haven’t published, ask and we’ll go and measure it. Every figure is in the <a href="/accessibility/">access statement</a>.',
			'cat' => 'about',
		),
		array(
			'q'   => 'Is there a hoist, and what’s it rated to?',
			'a'   => 'Yes. There’s a ceiling track hoist that covers the whole of the main bedroom, and a mobile hoist you can use in any room. Both have a safe working load of 180kg and are examined under LOLER every six months. Please bring your own slings, because a sling needs to fit the person using it.',
			'cat' => 'about',
		),
		array(
			'q'   => 'Can we have two profiling beds?',
			'a'   => 'Yes. We have two profiling beds, and we set the accessible bedroom up with one or both, depending on who needs them. Tell us when you book and it’ll be ready when you arrive.',
			'cat' => 'about',
		),
		array(
			'q'   => 'How many people does it sleep?',
			'a'   => 'Up to five. There are two bedrooms and a double sofa bed in the conservatory. Our safety checks are based on five people, so we can’t go above that.',
			'cat' => 'about',
		),
		array(
			'q'   => 'Can we add care to our booking?',
			'a'   => 'Yes. Continuity of Care Services, our sister company, can come into the bungalow during your stay, from a morning visit to nurse-led support. Mention it on the same enquiry as the house, and Continuity will give you a quote once you’ve talked through what you need. There’s more on the <a href="/optional-care/">Optional care</a> page.',
			'cat' => 'care',
		),
		array(
			'q'   => 'How far ahead do we need to arrange care?',
			'a'   => 'The sooner you ask, the more likely it is that we can say yes. We don’t publish a lead time, because it depends on what you need and who’s free that week. We’d rather give you a real answer quickly than a number we’ve made up.',
			'cat' => 'care',
		),
		array(
			'q'   => 'Can we bring our own carer or PA?',
			'a'   => 'Of course. Plenty of guests bring their own carer or PA, and the second bedroom gives them somewhere proper to sleep. If you’d like to talk through who sleeps where, we’re happy to help.',
			'cat' => 'care',
		),
		array(
			'q'   => 'How far is the bungalow from the seafront?',
			'a'   => 'It’s about ten minutes on foot from the driveway to the seafront. Places along Tankerton promenade take a bit longer, because you head down to the sea first and then west along the prom. JoJo’s is about twenty minutes in all. The <a href="/whitstable-area-guide/">Whitstable guide</a> has the step-free routes.',
			'cat' => 'local',
		),
		array(
			'q'   => 'What does it cost, and what’s included?',
			'a'   => 'A week is £1,300 off-peak and £1,400 in peak season, and the access equipment, linen, towels and parking are all included. A 50% deposit holds your dates and the rest is due a week before you arrive. Every rate is on <a href="/pricing/">Prices and dates</a>.',
			'cat' => 'booking',
		),
		array(
			'q'   => 'Can a council or the NHS pay?',
			'a'   => 'We can invoice you, a local authority, the NHS or a grant body. What we can’t do is promise that your care package will cover a holiday, because that decision sits with your social worker or case manager. <a href="/funding-and-support/">Funding and support</a> explains how it usually works.',
			'cat' => 'funding',
		),
		array(
			'q'   => 'Can we use direct payments?',
			'a'   => 'Some guests do, either for the stay or for a PA’s time. The rules vary from area to area, so it’s best to start with your own care team. Our <a href="/direct-payment-holiday-accommodation/">guide to direct payments</a> explains more.',
			'cat' => 'funding',
		),
		array(
			'q'   => 'Are dogs allowed?',
			'a'   => 'Yes, with a little notice so we can do a quick risk assessment first. Assistance dogs are welcome on the same terms.',
			'cat' => 'about',
		),
		array(
			'q'   => 'What time is check-in?',
			'a'   => 'Check-in is from 3pm, using a key safe, and we send you the code beforehand. Check-out is by 11am. If you need longer for personal care or transport, let us know a few days ahead and we’ll do our best. <a href="/how-it-works/">How it works</a> covers arrival day in full.',
			'cat' => 'booking',
		),
	);
}

/**
 * Question/answer pairs from the FAQ accordions actually rendered on a page.
 *
 * FAQPage schema is built from the finished HTML, so it always matches the
 * visible questions and answers: parity by construction, whichever template
 * printed the accordion (decided 1 Oct 2026, audit I16). Duplicate questions
 * are listed once. Pure PHP, so tests/FaqSchemaParityTest.php can exercise it.
 *
 * @param string $html Page HTML.
 * @return array<int, array{q:string, a:string}>
 */
function restwell_extract_faq_pairs_from_html( $html ) {
	if ( false === strpos( (string) $html, 'faq-item__trigger' ) || ! class_exists( 'DOMDocument' ) ) {
		return array();
	}
	$doc  = new DOMDocument();
	$prev = libxml_use_internal_errors( true );
	$doc->loadHTML( '<?xml encoding="utf-8"?>' . $html, LIBXML_NOERROR | LIBXML_NOWARNING );
	libxml_clear_errors();
	libxml_use_internal_errors( $prev );
	$xpath = new DOMXPath( $doc );
	$pairs = array();
	$seen  = array();
	$clean = static function ( $text ) {
		return trim( (string) preg_replace( '/\s+/u', ' ', (string) $text ) );
	};
	// phpcs:disable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase -- DOM API names.
	foreach ( $xpath->query( '//*[contains(concat(" ", normalize-space(@class), " "), " faq-item ")]' ) as $item ) {
		$trigger = $xpath->query( './/*[contains(concat(" ", normalize-space(@class), " "), " faq-item__trigger ")]', $item )->item( 0 );
		$panel   = $xpath->query( './/*[contains(concat(" ", normalize-space(@class), " "), " faq-item__panel ")]', $item )->item( 0 );
		if ( ! $trigger || ! $panel ) {
			continue;
		}
		$q = $clean( $trigger->textContent );
		$a = $clean( $panel->textContent );
		if ( '' === $q || '' === $a || isset( $seen[ $q ] ) ) {
			continue;
		}
		$seen[ $q ] = true;
		$pairs[]    = array(
			'q' => $q,
			'a' => $a,
		);
	}
	// phpcs:enable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
	return $pairs;
}

/**
 * FAQPage schema array for a list of pairs.
 *
 * @param array<int, array{q:string, a:string}> $pairs Pairs.
 * @return array<string, mixed>
 */
function restwell_build_faq_schema( array $pairs ) {
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
	return array(
		'@context'   => 'https://schema.org',
		'@type'      => 'FAQPage',
		'mainEntity' => $entities,
	);
}

/**
 * Append FAQPage JSON-LD built from the rendered page, before </body>.
 *
 * @param string $html Page HTML.
 * @return string
 */
function restwell_inject_faq_jsonld( $html ) {
	if ( is_404() || is_search() || false === stripos( $html, '</body>' ) ) {
		return $html;
	}
	$pairs = restwell_extract_faq_pairs_from_html( $html );
	if ( empty( $pairs ) ) {
		return $html;
	}
	// No ob_start() here: this runs inside an output-buffer callback.
	$script = restwell_jsonld_script_tag( restwell_build_faq_schema( $pairs ) );
	$pos    = strripos( $html, '</body>' );
	return substr( $html, 0, $pos ) . $script . substr( $html, $pos );
}
add_filter( 'restwell_front_html', 'restwell_inject_faq_jsonld', 20 );
