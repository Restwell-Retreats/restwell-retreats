<?php
/**
 * Hub page HTML seeds (Who It's For, Whitstable guide).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * HTML post_content for Who It's For page.
 *
 * @return string
 */
function restwell_get_who_its_for_page_html() {
	$enquire = esc_url( home_url( '/enquire/' ) );
	$acc     = esc_url( home_url( '/accessibility/' ) );
	$prop    = esc_url( home_url( '/the-property/' ) );
	$faq     = esc_url( home_url( '/faq/' ) );
	$res     = esc_url( home_url( '/resources/' ) );
	return '<h2>For guests and families</h2>
<p>This is a real holiday - a comfortable self-catering bungalow on the Kent coast, not a clinical placement. We have designed the space so you can focus on the break: the sea air, Whitstable, and time together.</p>
<p><a href="' . $prop . '">View the property</a> or <a href="' . $enquire . '">check availability and enquire</a>.</p>
<h2>For carers and support workers</h2>
<p>Bring your client or family member knowing the property has level access, a ceiling track hoist in the accessible bedroom, profiling bed, and a full wet room on the same level with a height-adjustable washbasin. There is room for you to stay - tell us your party size when you book so we can confirm sleeping arrangements.</p>
<p>Read our <a href="' . $acc . '">accessibility specification</a> and <a href="' . $faq . '">funding and booking FAQs</a>.</p>
<h2>For occupational therapists and case managers</h2>
<p>We provide detailed accessibility information so you can assess suitability. If you need room dimensions, equipment specifications, or a site visit, <a href="' . $enquire . '">contact us</a> - we are used to working with professionals.</p>
<p><a href="' . $acc . '">See our equipment and access specification</a>.</p>
<h2>For commissioners and social care teams</h2>
<p>We welcome guests whose stays are funded through direct payments, personal budgets, or continuing healthcare (CHC) arrangements, subject to your local authority’s rules. We can provide documentation to support referrals.</p>
<p><a href="' . $res . '">Read about funding routes</a> and <a href="' . $faq . '">how funding works in our FAQ</a>.</p>
<h2>How funding works</h2>
<p>Eligibility depends on your package and local authority. Start with our <a href="' . $res . '">Funding &amp; support</a> page, then <a href="' . $enquire . '">get in touch</a> to discuss your situation.</p>';
}

/**
 * HTML post_content for Whitstable area guide page.
 *
 * @return string
 */
function restwell_get_whitstable_guide_page_html() {
	$prop = esc_url( home_url( '/the-property/' ) );
	$enq  = esc_url( home_url( '/enquire/' ) );
	return '<p>Restwell sits in a quiet residential street in Whitstable, about five minutes’ drive from the town centre and seafront. Below is a practical guide to the area - with accessibility notes where we can help.</p>
<h2>About Whitstable</h2>
<p>The harbour, independent shops, and seafood are the heart of the town. The beach is shingle; the Tankerton Slopes promenade offers a long, level walk with sea views - one of the more accessible coastal routes in Kent.</p>
<h2>Nearby towns</h2>
<p><strong>Canterbury</strong> (about eight miles) - cathedral, museums, and flat pedestrianised areas in the centre. <strong>Faversham</strong> and <strong>Herne Bay</strong> are short drives for market-town days out and traditional seafront.</p>
<h2>Getting here</h2>
<p>Whitstable station has trains to London St Pancras and Victoria. By car, use the M2 / Thanet Way. The property has two off-road spaces on a private drive, with on-street parking outside if you need extra room (no residents permit on this road).</p>
<p><a href="' . $prop . '">Back to the property</a> · <a href="' . $enq . '">Book your stay</a></p>';
}

/**
 * Seed HTML content for hub pages and blog archive excerpt (idempotent unless $force).
 *
 * @param array<string, int> $created_ids Page title => post ID.
 * @param bool               $force       Overwrite existing post_content / excerpt.
 * @param array              $result      Result array (hub_seeded key).
 */
function restwell_seed_hub_pages_content( array $created_ids, $force, array &$result ) {
	if ( ! isset( $result['hub_seeded'] ) ) {
		$result['hub_seeded'] = array();
	}

	$pages_cfg = array(
		'Who It\'s For'    => 'restwell_get_who_its_for_page_html',
		'Whitstable Guide' => 'restwell_get_whitstable_guide_page_html',
	);

	foreach ( $pages_cfg as $title => $callback ) {
		$page_id = isset( $created_ids[ $title ] ) ? (int) $created_ids[ $title ] : 0;
		if ( $page_id < 1 ) {
			$slug = ( 'Who It\'s For' === $title ) ? 'who-its-for' : 'whitstable-area-guide';
			$pg   = get_page_by_path( $slug, OBJECT, 'page' );
			$page_id = $pg ? (int) $pg->ID : 0;
		}
		if ( $page_id < 1 || ! is_callable( $callback ) ) {
			continue;
		}

		$existing = get_post_field( 'post_content', $page_id );
		if ( ! $force && ! empty( trim( (string) $existing ) ) ) {
			continue;
		}

		$html = call_user_func( $callback );
		wp_update_post(
			array(
				'ID'           => $page_id,
				'post_content' => wp_kses_post( $html ),
			)
		);
		$result['hub_seeded'][] = $title;
	}

	$blog_id = isset( $created_ids['Blog'] ) ? (int) $created_ids['Blog'] : 0;
	if ( $blog_id < 1 ) {
		$bp = get_page_by_path( 'blog', OBJECT, 'page' );
		$blog_id = $bp ? (int) $bp->ID : 0;
	}
	if ( $blog_id > 0 ) {
		$excerpt = (string) get_post_field( 'post_excerpt', $blog_id );
		if ( $force || $excerpt === '' ) {
			wp_update_post(
				array(
					'ID'           => $blog_id,
					'post_excerpt' => __( 'Guides and stories: accessible travel, the Kent coast, funding routes, and updates from Restwell Retreats.', 'restwell-retreats' ),
				)
			);
			$result['hub_seeded'][] = 'Blog';
		}
	}
}
