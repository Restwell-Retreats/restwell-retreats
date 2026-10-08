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
			'q'   => 'What is Restwell, exactly: bungalow, care home, or respite centre?',
			'a'   => 'Both, in the way that helps you plan: it’s a private adapted bungalow that you rent as a holiday, with no staff on site, and optional care from Continuity if you want it. It’s not a registered respite centre, though your funder may use the word respite on paperwork, and that’s fine.',
			'cat' => 'about',
		),
		array(
			'q'   => 'Is it a respite centre?',
			'a'   => 'No, though your funder may well use the word respite, and that’s fine. It’s often how a break like this gets described on paperwork. It’s still a private house rather than a registered respite service.',
			'cat' => 'about',
		),
		array(
			'q'   => 'What are the doorway widths, and will my wheelchair fit?',
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
			'q'   => 'Can we add care to our booking?',
			'a'   => 'Yes. Continuity of Care Services, our sister company, can come into the bungalow, anything from a morning visit to nurse-led support. Care is quoted separately from the bungalow. Mention it on the same enquiry as the house and we’ll work it out together. See <a href="/optional-care/">Optional care</a>.',
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
