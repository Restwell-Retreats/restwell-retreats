<?php
/**
 * Template Name: Who It's For
 *
 * Concept port from mockups — Who It's For.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$restwell_wif_id      = (int) get_queried_object_id();
$restwell_wif_heading = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $restwell_wif_id, 'wif_heading', 'Is this the right house for your group?' )
	: 'Is this the right house for your group?';
$restwell_wif_intro   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text(
		$restwell_wif_id,
		'wif_intro',
		'Built for disabled adults, families and carers, in parties of up to five. A holiday let, not a care home or respite centre.'
	)
	: 'Built for disabled adults, families and carers, in parties of up to five. A holiday let, not a care home or respite centre.';

$wif_defaults = function_exists( 'restwell_get_who_its_for_page_defaults' )
	? restwell_get_who_its_for_page_defaults()
	: array();

$wif_audience_heading = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $restwell_wif_id, 'wif_audience_heading', 'Who Restwell is built for' )
	: 'Who Restwell is built for';
$wif_audience_intro   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text(
		$restwell_wif_id,
		'wif_audience_intro',
		'Families, carers, OTs and commissioners use the same published door widths and kit list, then decide if this bungalow fits before they travel.'
	)
	: 'Families, carers, OTs and commissioners use the same published door widths and kit list, then decide if this bungalow fits before they travel.';

$wif_default_family_bullets = function_exists( 'restwell_get_property_facts_persona_bullets' )
	? restwell_get_property_facts_persona_bullets( 'family' )
	: array(
		'Ceiling track hoist in the accessible bedroom, profiling bed, and wet room with roll-in shower.',
		'Published access measurements before you commit.',
		'A private self-catering layout: your daily routines run on your schedule.',
	);
$wif_default_carers_bullets = function_exists( 'restwell_get_property_facts_persona_bullets' )
	? restwell_get_property_facts_persona_bullets( 'carers' )
	: array(
		'Separate sleeping area for the support worker or carer.',
		'Wet room designed for assisted personal care on the same level.',
		'You have a legal right to a Carer\'s Assessment under the Care Act 2014.',
	);
$wif_default_ot_bullets = function_exists( 'restwell_get_property_facts_persona_bullets' )
	? restwell_get_property_facts_persona_bullets( 'ot' )
	: array(
		'Doorway widths, turning circles, hoist specs, and wet room measurements on request.',
		'Transfer clearances and equipment positioning confirmed if not already published.',
		'Referral conversations welcomed before any booking commitment.',
	);
$wif_default_commissioners_bullets = function_exists( 'restwell_get_property_facts_persona_bullets' )
	? restwell_get_property_facts_persona_bullets( 'commissioners' )
	: array(
		'Short breaks at a private adapted setting can form part of a care and support plan under the Care Act 2014.',
		'Documentation provided: property spec, access measurements, and CQC-registered care provider confirmation.',
		'Direct payments, personal health budgets, and CHC pathways all supported.',
	);

$wif_resolve_url = static function ( $key, $fallback ) use ( $restwell_wif_id, $wif_defaults ) {
	if ( function_exists( 'restwell_post_meta_url' ) && ! empty( $wif_defaults ) ) {
		$url = restwell_post_meta_url( $restwell_wif_id, $key, $wif_defaults );
		if ( is_string( $url ) && '' !== $url ) {
			return $url;
		}
	}
	$raw = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_wif_id, $key, $fallback )
		: $fallback;
	$raw = trim( (string) $raw );
	if ( '' === $raw ) {
		$raw = $fallback;
	}
	if ( preg_match( '#^https?://#i', $raw ) ) {
		return $raw;
	}
	return home_url( $raw );
};

$wif_personas = array(
	array(
		'icon'             => 'home',
		'title'            => function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text( $restwell_wif_id, 'wif_family_title', 'Guests and families' )
			: 'Guests and families',
		'body'             => function_exists( 'restwell_wif_persona_intro_body' )
			? restwell_wif_persona_intro_body(
				$restwell_wif_id,
				'wif_family_body',
				'wif_family_detail_body',
				'Hoist and wet room already fitted; measurements published; a private home, not a hotel room.'
			)
			: ( function_exists( 'restwell_page_content_text' )
				? restwell_page_content_text( $restwell_wif_id, 'wif_family_body', 'Hoist and wet room already fitted; measurements published; a private home, not a hotel room.' )
				: 'Hoist and wet room already fitted; measurements published; a private home, not a hotel room.' ),
		'bullets'          => function_exists( 'restwell_wif_bullet_list' )
			? restwell_wif_bullet_list( $restwell_wif_id, 'wif_family_detail_bullets', $wif_default_family_bullets )
			: $wif_default_family_bullets,
		'inline_cta_label' => function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text( $restwell_wif_id, 'wif_family_inline_cta_label', 'Read accessibility specification' )
			: 'Read accessibility specification',
		'inline_cta_url'   => $wif_resolve_url( 'wif_family_inline_cta_url', '/accessibility/' ),
		'svg'              => '<path d="M4 11.5 12 5l8 6.5M6 10.5V19a1 1 0 0 0 1 1h3v-5h4v5h3a1 1 0 0 0 1-1v-8.5" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>',
	),
	array(
		'icon'             => 'carers',
		'title'            => function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text( $restwell_wif_id, 'wif_carers_title', 'Carers and support workers' )
			: 'Carers and support workers',
		'body'             => function_exists( 'restwell_wif_persona_intro_body' )
			? restwell_wif_persona_intro_body(
				$restwell_wif_id,
				'wif_carers_body',
				'wif_carers_detail_body',
				'Separate sleeping and space to assist without blocking hall routes. Ask your council about a Carer’s Assessment under the Care Act 2014 if you need funding for a break.'
			)
			: ( function_exists( 'restwell_page_content_text' )
				? restwell_page_content_text( $restwell_wif_id, 'wif_carers_body', 'Separate sleeping and space to assist without blocking hall routes. Ask your council about a Carer’s Assessment under the Care Act 2014 if you need funding for a break.' )
				: 'Separate sleeping and space to assist without blocking hall routes. Ask your council about a Carer’s Assessment under the Care Act 2014 if you need funding for a break.' ),
		'bullets'          => function_exists( 'restwell_wif_bullet_list' )
			? restwell_wif_bullet_list( $restwell_wif_id, 'wif_carers_detail_bullets', $wif_default_carers_bullets )
			: $wif_default_carers_bullets,
		'inline_cta_label' => function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text( $restwell_wif_id, 'wif_carers_inline_cta_label', 'Ask a suitability question' )
			: 'Ask a suitability question',
		'inline_cta_url'   => $wif_resolve_url( 'wif_carers_inline_cta_url', '/enquire/' ),
		'svg'              => '<circle cx="8.5" cy="8" r="2.5" fill="none" stroke="currentColor" stroke-width="1.6"/><path d="M3.5 19c0-3 2.2-5 5-5s5 2 5 5" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><circle cx="16.5" cy="9" r="2" fill="none" stroke="currentColor" stroke-width="1.6"/><path d="M14 19c.2-2.6 1.9-4.5 4.3-4.8" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>',
	),
	array(
		'icon'             => 'ot',
		'title'            => function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text( $restwell_wif_id, 'wif_ot_title', 'Occupational therapists' )
			: 'Occupational therapists',
		'body'             => function_exists( 'restwell_wif_persona_intro_body' )
			? restwell_wif_persona_intro_body(
				$restwell_wif_id,
				'wif_ot_body',
				'wif_ot_detail_body',
				'Published doorway widths, hoist and wet-room specs. Ask for unpublished clearances; we’ll measure.'
			)
			: ( function_exists( 'restwell_page_content_text' )
				? restwell_page_content_text( $restwell_wif_id, 'wif_ot_body', 'Published doorway widths, hoist and wet-room specs. Ask for unpublished clearances; we’ll measure.' )
				: 'Published doorway widths, hoist and wet-room specs. Ask for unpublished clearances; we’ll measure.' ),
		'bullets'          => function_exists( 'restwell_wif_bullet_list' )
			? restwell_wif_bullet_list( $restwell_wif_id, 'wif_ot_detail_bullets', $wif_default_ot_bullets )
			: $wif_default_ot_bullets,
		'inline_cta_label' => function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text( $restwell_wif_id, 'wif_ot_inline_cta_label', 'Review accessibility details' )
			: 'Review accessibility details',
		'inline_cta_url'   => $wif_resolve_url( 'wif_ot_inline_cta_url', '/accessibility/' ),
		'svg'              => '<rect x="5" y="4.5" width="14" height="17" rx="1.5" fill="none" stroke="currentColor" stroke-width="1.6"/><path d="M9 4.5V3.8A1.8 1.8 0 0 1 10.8 2h2.4A1.8 1.8 0 0 1 15 3.8v.7" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M8.5 12.2l2 2 4-4.5M8.5 17h7" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>',
	),
	array(
		'icon'             => 'commissioners',
		'title'            => function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text( $restwell_wif_id, 'wif_commissioners_title', 'Commissioners & social care' )
			: 'Commissioners & social care',
		'body'             => function_exists( 'restwell_wif_persona_intro_body' )
			? restwell_wif_persona_intro_body(
				$restwell_wif_id,
				'wif_commissioners_body',
				'wif_commissioners_detail_body',
				'Care Act short breaks; documentation for direct payments, PHB or CHC. Same rates regardless of who we invoice.'
			)
			: ( function_exists( 'restwell_page_content_text' )
				? restwell_page_content_text( $restwell_wif_id, 'wif_commissioners_body', 'Care Act short breaks; documentation for direct payments, PHB or CHC. Same rates regardless of who we invoice.' )
				: 'Care Act short breaks; documentation for direct payments, PHB or CHC. Same rates regardless of who we invoice.' ),
		'bullets'          => function_exists( 'restwell_wif_bullet_list' )
			? restwell_wif_bullet_list( $restwell_wif_id, 'wif_commissioners_detail_bullets', $wif_default_commissioners_bullets )
			: $wif_default_commissioners_bullets,
		'inline_cta_label' => function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text( $restwell_wif_id, 'wif_commissioners_inline_cta_label', 'Enquire about a funded stay' )
			: 'Enquire about a funded stay',
		'inline_cta_url'   => $wif_resolve_url( 'wif_commissioners_inline_cta_url', '/enquire/' ),
		'svg'              => '<path d="M4 21V6.5L12 3l8 3.5V21M9 21v-5h6v5M4 21h16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>',
	),
);

$wif_visual_intro = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text(
		$restwell_wif_id,
		'wif_visual_intro',
		'These three items are on site before arrival, not hired for the week.'
	)
	: 'These three items are on site before arrival, not hired for the week.';

$wif_kit_cards = array(
	array(
		'fallback_src' => 'bungalow/WR-3-LS.jpg',
		'fallback_alt' => 'Level-access wet room with grab rails',
		'title'        => function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text( $restwell_wif_id, 'wif_section_image_1_caption', 'Level-access wet room' )
			: 'Level-access wet room',
		'body'         => 'Roll-in shower, grab rails and a height-adjustable basin. Care Spaces adapted.',
		'slot_index'   => 0,
	),
	array(
		'fallback_src' => 'bungalow/BD2-6-LS.jpg',
		'fallback_alt' => 'Amico ceiling track hoist over the bed',
		'title'        => function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text( $restwell_wif_id, 'wif_section_image_2_caption', 'Ceiling track hoist' )
			: 'Ceiling track hoist',
		'body'         => 'Full-room Amico track over the profiling bed; mobile hoist also on site.',
		'slot_index'   => 1,
	),
	array(
		'fallback_src' => 'bungalow/kitchen.png',
		'fallback_alt' => 'Kitchen with wheel-under worksurface',
		'title'        => function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text( $restwell_wif_id, 'wif_section_image_3_caption', 'Reachable kitchen' )
			: 'Reachable kitchen',
		'body'         => 'Wheel-under worksurface, stocked basics, gas hob (tell us if you need induction).',
		'slot_index'   => 2,
	),
);

$wif_gallery_slots = function_exists( 'restwell_get_wif_gallery_slots' )
	? restwell_get_wif_gallery_slots( $restwell_wif_id )
	: array();

$wif_funding_heading = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $restwell_wif_id, 'wif_funding_heading', 'Who we can invoice' )
	: 'Who we can invoice';
$wif_funding_body    = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text(
		$restwell_wif_id,
		'wif_funding_body',
		'If a stay is funded through a local authority, CHC, direct payments or a personal budget, the bungalow rate stays the same. Funding only changes who we invoice.'
	)
	: 'If a stay is funded through a local authority, CHC, direct payments or a personal budget, the bungalow rate stays the same. Funding only changes who we invoice.';

$wif_fund_la_bullets = function_exists( 'restwell_wif_bullet_list' )
	? restwell_wif_bullet_list(
		$restwell_wif_id,
		'wif_fund_la_bullets',
		array(
			'Begins with a Care and Support Assessment. Unpaid carers can request a Carer\'s Assessment too (Care Act 2014).',
			'Direct payments: you receive the funding and choose your provider.',
			'Capital limits 2024/25: above £23,250 you pay in full; below £14,250 is usually ignored.',
		)
	)
	: array();
$wif_fund_phb_bullets = function_exists( 'restwell_wif_bullet_list' )
	? restwell_wif_bullet_list(
		$restwell_wif_id,
		'wif_fund_phb_bullets',
		array(
			'Available for people with continuing healthcare needs, subject to eligibility assessment.',
			'Your ICB or NHS continuing healthcare team manages the application.',
			'A private adapted setting can be written into a care and support plan where clinically appropriate.',
		)
	)
	: array();
$wif_fund_private_bullets = function_exists( 'restwell_wif_bullet_list' )
	? restwell_wif_bullet_list(
		$restwell_wif_id,
		'wif_fund_private_bullets',
		array(
			'The same clear accessibility information and direct answers as for funded guests.',
			'Documentation for insurers or employers if you need it.',
			'No pressure: we tell you plainly whether the property is a good fit.',
		)
	)
	: array();

$wif_funding_routes = array(
	array(
		'title'     => function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text( $restwell_wif_id, 'wif_fund_la_title', 'Local authority & direct payments' )
			: 'Local authority & direct payments',
		'bullets'   => $wif_fund_la_bullets,
		'cta_label' => function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text( $restwell_wif_id, 'wif_fund_la_cta_label', 'Direct payments guide' )
			: 'Direct payments guide',
		'cta_url'   => $wif_resolve_url( 'wif_fund_la_cta_url', '/direct-payment-holiday-accommodation/' ),
	),
	array(
		'title'     => function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text( $restwell_wif_id, 'wif_fund_phb_title', 'Personal health budget' )
			: 'Personal health budget',
		'bullets'   => $wif_fund_phb_bullets,
		'cta_label' => function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text( $restwell_wif_id, 'wif_fund_phb_cta_label', 'PHB and funding overview' )
			: 'PHB and funding overview',
		'cta_url'   => $wif_resolve_url( 'wif_fund_phb_cta_url', '/resources/' ),
	),
	array(
		'title'     => function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text( $restwell_wif_id, 'wif_fund_private_title', 'Private / self-funded' )
			: 'Private / self-funded',
		'bullets'   => $wif_fund_private_bullets,
		'cta_label' => function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text( $restwell_wif_id, 'wif_fund_private_cta_label', 'Ask about your dates' )
			: 'Ask about your dates',
		'cta_url'   => $wif_resolve_url( 'wif_fund_private_cta_url', '/enquire/' ),
	),
);
?>


<main id="main-content">
<?php
get_template_part(
	'template-parts/concept/photo-hero',
	null,
	array(
		'heading_id' => 'page-h',
		'heading'    => $restwell_wif_heading,
		'intro'      => $restwell_wif_intro,
		'crumbs'     => array(
			array(
				'label' => __( 'Home', 'restwell-retreats' ),
				'url'   => home_url( '/' ),
			),
			array(
				'label' => 'Who It\'s For',
				'url'   => '',
			),
		),
		'post_id'    => $restwell_wif_id,
	)
);
?>

	<nav class="subnav" aria-label="On this page">
	  <div class="container">
		<ul class="subnav__list">
		  <li><a href="#situations">Situations</a></li>
		  <li><a href="#access">Access</a></li>
		  <li><a href="#care">Care</a></li>
		  <li><a href="#funding">Funding</a></li>
		  <li><a href="#next">Next steps</a></li>
		  <li><a href="#faq">FAQ</a></li>
		</ul>
	  </div>
	</nav>

	<section class="section-y band-white" id="situations" aria-labelledby="situations-h">
	  <div class="container split">
		<div>
		  <header class="section-head section-head--tight">
			<p class="eyebrow">Your situation</p>
			<h2 id="situations-h"><?php echo esc_html( $wif_audience_heading ); ?></h2>
			<p class="lede"><?php echo esc_html( $wif_audience_intro ); ?></p>
		  </header>
		  <ul class="persona-list" role="list">
			<?php foreach ( $wif_personas as $persona ) : ?>
			<li class="persona-list__item">
			  <span class="icon-circle" aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false"><?php echo $persona['svg']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- hard-coded SVG paths. ?></svg></span>
			  <div>
				<h3><?php echo esc_html( $persona['title'] ); ?></h3>
				<?php
				$body_paras = function_exists( 'restwell_wif_split_body_paragraphs' )
					? restwell_wif_split_body_paragraphs( $persona['body'] )
					: array( $persona['body'] );
				foreach ( $body_paras as $para ) :
					?>
				<p><?php echo esc_html( $para ); ?></p>
				<?php endforeach; ?>
				<?php if ( ! empty( $persona['bullets'] ) ) : ?>
				<ul class="checklist">
					<?php foreach ( $persona['bullets'] as $bullet ) : ?>
					<li><?php echo esc_html( $bullet ); ?></li>
					<?php endforeach; ?>
				</ul>
				<?php endif; ?>
				<?php if ( '' !== trim( (string) $persona['inline_cta_label'] ) ) : ?>
				<p><a class="text-link" href="<?php echo esc_url( $persona['inline_cta_url'] ); ?>"><?php echo esc_html( $persona['inline_cta_label'] ); ?></a></p>
				<?php endif; ?>
			  </div>
			</li>
			<?php endforeach; ?>
		  </ul>
		</div>
		<div class="split__media" data-reveal>
		  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/LR-1-LS.jpg' ) ); ?>" alt="Open-plan living space in the accessible bungalow" width="900" height="675" loading="lazy" />
		</div>
	  </div>
	</section>

	<section class="section-y band-subtle" id="access" aria-labelledby="access-h">
	  <div class="container">
		<header class="section-head">
		  <p class="eyebrow">See the access</p>
		  <h2 id="access-h">Wet room, hoist and kitchen already fitted</h2>
		  <p class="lede"><?php echo esc_html( $wif_visual_intro ); ?></p>
		</header>
		<ul class="card-grid card-grid--3" role="list">
		  <?php foreach ( $wif_kit_cards as $kit_card ) : ?>
			<?php
			$slot       = $wif_gallery_slots[ $kit_card['slot_index'] ] ?? array();
			$slot_id    = (int) ( $slot['id'] ?? 0 );
			$slot_alt   = trim( (string) ( $slot['caption'] ?? '' ) );
			$img_alt    = '' !== $slot_alt ? $slot_alt : $kit_card['fallback_alt'];
			$kit_body   = $kit_card['body'];
			?>
		  <li>
			<article class="media-card">
			  <?php if ( $slot_id > 0 && function_exists( 'restwell_get_property_attachment_image' ) ) : ?>
				<?php
				echo restwell_get_property_attachment_image( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- helper returns escaped HTML.
					$slot_id,
					'grid',
					array(
						'alt' => $img_alt,
					)
				);
				?>
			  <?php elseif ( $slot_id > 0 ) : ?>
				<?php
				echo wp_get_attachment_image(
					$slot_id,
					'large',
					false,
					array(
						'alt'      => $img_alt,
						'loading'  => 'lazy',
						'decoding' => 'async',
						'width'    => 640,
						'height'   => 480,
					)
				);
				?>
			  <?php else : ?>
			  <img src="<?php echo esc_url( restwell_theme_image_url( $kit_card['fallback_src'] ) ); ?>" alt="<?php echo esc_attr( $kit_card['fallback_alt'] ); ?>" width="640" height="480" loading="lazy" />
			  <?php endif; ?>
			  <h3><?php echo esc_html( $kit_card['title'] ); ?></h3>
			  <p><?php echo esc_html( $kit_body ); ?></p>
			</article>
		  </li>
		  <?php endforeach; ?>
		</ul>
		<p><a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'accessibility' ) ); ?>">Full accessibility details</a></p>
	  </div>
	</section>

	<section class="section-y band-white" aria-labelledby="quote-h">
	  <div class="container">
		<h2 id="quote-h" class="sr-only">What guests say</h2>
		<figure class="pull-quote">
		  <span class="pull-quote__mark" aria-hidden="true">&ldquo;</span>
		  <blockquote class="pull-quote__text">The house was well equipped with all the facilities we needed for my Dad&rsquo;s complex needs. Vicky and Keeley could not do enough for us, we forgot flannels and they traveled to bring us some which was very kind.</blockquote>
		  <figcaption class="pull-quote__cite">M.W.<span class="pull-quote__role">Visiting family &middot; Facebook review</span></figcaption>
		</figure>
	  </div>
	</section>

	<section class="section-y section-y--compact band-teal" id="care" aria-labelledby="care-h">
	  <div class="container">
		<div class="band-teal__stack band-teal__stack--tease">
		  <p class="eyebrow eyebrow--on-dark"><?php esc_html_e( 'Optional care', 'restwell-retreats' ); ?></p>
		  <h2 id="care-h"><?php esc_html_e( 'Optional home care', 'restwell-retreats' ); ?></h2>
		  <p class="lede"><?php esc_html_e( 'Home care from Continuity can be added on the same enquiry, quoted separately. Bring your own team if that works better.', 'restwell-retreats' ); ?></p>
		  <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'optional-care' ) ); ?>"><?php esc_html_e( 'How optional care works', 'restwell-retreats' ); ?></a>
		</div>
	  </div>
	</section>

	<section class="section-y band-white" id="funding" aria-labelledby="funding-h">
	  <div class="container">
		<header class="section-head">
		  <p class="eyebrow">Funding</p>
		  <h2 id="funding-h"><?php echo esc_html( $wif_funding_heading ); ?></h2>
		  <p class="lede"><?php echo esc_html( $wif_funding_body ); ?></p>
		</header>
		<ul class="card-grid card-grid--3" role="list">
		  <?php foreach ( $wif_funding_routes as $route ) : ?>
		  <li>
			<article class="media-card">
			  <h3><?php echo esc_html( $route['title'] ); ?></h3>
			  <?php if ( ! empty( $route['bullets'] ) ) : ?>
			  <ul class="checklist">
				<?php foreach ( $route['bullets'] as $bullet ) : ?>
				<li><?php echo esc_html( $bullet ); ?></li>
				<?php endforeach; ?>
			  </ul>
			  <?php endif; ?>
			  <?php if ( '' !== trim( (string) $route['cta_label'] ) ) : ?>
			  <p><a class="text-link" href="<?php echo esc_url( $route['cta_url'] ); ?>"><?php echo esc_html( $route['cta_label'] ); ?></a></p>
			  <?php endif; ?>
			</article>
		  </li>
		  <?php endforeach; ?>
		</ul>
		<p><a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'resources' ) ); ?>">Funding &amp; support hub</a></p>
	  </div>
	</section>

	<section class="section-y band-subtle process" id="next" aria-labelledby="next-h">
	  <div class="container">
		<header class="section-head section-head--center process__head">
		  <p class="eyebrow">Next steps</p>
		  <h2 id="next-h">Enquire, match the house, then deposit</h2>
		  <p class="lede">No online checkout maze. You get a straight yes/no on kit fit before any money changes hands.</p>
		</header>
		<div class="process__layout">
		  <div class="process__media" data-reveal>
			<img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/entrance.png' ) ); ?>" alt="Step-free entrance to the Restwell bungalow" width="900" height="675" loading="lazy" />
		  </div>
		  <ol class="process-list">
			<li>
			  <span class="process-list__index" aria-hidden="true">01</span>
			  <div class="process-list__body">
				<h3>Share requirements</h3>
				<p class="process-list__meta">Start here</p>
				<p>Dates, chair/hoist needs, funding contact, and whether you want Continuity care.</p>
			  </div>
			</li>
			<li>
			  <span class="process-list__index" aria-hidden="true">02</span>
			  <div class="process-list__body">
				<h3>Confirm suitability</h3>
				<p class="process-list__meta">We reply</p>
				<p>We check doorway widths and on-site kit against your party, and say if Restwell is the wrong house.</p>
			  </div>
			</li>
			<li>
			  <span class="process-list__index" aria-hidden="true">03</span>
			  <div class="process-list__body">
				<h3>Book and prepare</h3>
				<p class="process-list__meta">When you’re ready</p>
				<p>50% deposit, welcome pack, and a Continuity intro only if you asked for care.</p>
			  </div>
			</li>
		  </ol>
		</div>
	  </div>
	</section>
	<section class="faq section-y band-white" id="faq" aria-labelledby="faq-h">
	  <div class="container">
		<div class="faq__layout">
		  <header class="faq__intro">
			<p class="eyebrow">Suitability</p>
			<h2 id="faq-h">Planning &amp; respite FAQ</h2>
			<p class="lede">Complex-care planning order, and when a private bungalow beats care-home respite, or doesn’t.</p>
		  </header>
		  <div class="faq-list faq-list--split" data-faq-accordion>
			<div class="faq-list__col">
			<div class="faq-item is-open">
			  <button type="button" class="faq-item__trigger" aria-expanded="true" id="wif-q1" aria-controls="wif-q1-a">
				<span>How do I plan a holiday when someone has complex care needs?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="wif-q1-a" role="region" aria-labelledby="wif-q1">
				<p>Work in this order: match published access specs to the person’s equipment; set staffing (daytime, sleep-in vs waking night, backup); decide who pays lodging vs care; get kit confirmation in writing; sort medication, transport and emergency contacts. Only lock dates once those are clear.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="wif-q2" aria-controls="wif-q2-a">
				<span>How do I plan a holiday if I have complex care needs?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="wif-q2-a" role="region" aria-labelledby="wif-q2" hidden>
				<p>Start on the Accessibility page for Restwell’s door widths and hoist. Then coordinate carers or Continuity, confirm slings, sort prescriptions, build buffer into travel, and agree a backup if a carer is ill. Enquire with dates and care needs once that list is drafted.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="wif-q3" aria-controls="wif-q3-a">
				<span>How should I prepare for an accessible holiday?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="wif-q3-a" role="region" aria-labelledby="wif-q3" hidden>
				<p>Confirm access details in writing; pack slings, meds, chargers and comfort items the house won’t supply; share care plans with anyone covering the stay; note nearest accessible parking, toilets and pharmacy; keep Restwell and care-provider numbers to hand.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="wif-q4" aria-controls="wif-q4-a">
				<span>What belongs on a disabled holiday checklist?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="wif-q4-a" role="region" aria-labelledby="wif-q4" hidden>
				<p>Five lists: access needs; medical; care rota and backup; documents (funding letters, insurance, access statement); comfort and daily living. Tick each against Restwell’s published kit so you don’t pack what is already on site, or assume kit that isn’t.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="wif-q5" aria-controls="wif-q5-a">
				<span>Is a holiday possible if someone has complex needs?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="wif-q5-a" role="region" aria-labelledby="wif-q5" hidden>
				<p>Yes, if doorway widths, overnight staffing and transfers match before you travel. Start with measurements and the care rota, not brochure photos. This page and Accessibility are the fit check before you enquire.</p>
			  </div>
			</div>
			</div>
			<div class="faq-list__col">
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="wif-q6" aria-controls="wif-q6-a">
				<span>Is a holiday cottage better than a respite care placement for disabled adults?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="wif-q6-a" role="region" aria-labelledby="wif-q6" hidden>
				<p>Neither is universally better. A specialist cottage suits private stays with your own or visiting carers and enough kit for transfers. A respite placement suits higher on-site clinical oversight. Match setting to risk, staffing and what the person wants from the break.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="wif-q7" aria-controls="wif-q7-a">
				<span>Can we take a disabled holiday instead of care-home respite?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="wif-q7-a" role="region" aria-labelledby="wif-q7" hidden>
				<p>Yes when risk, staffing and equipment fit a private bungalow: Restwell with optional Continuity care is one such option. It is not a substitute for registered residential care when that is clinically required.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="wif-q8" aria-controls="wif-q8-a">
				<span>How does an accessible holiday let compare with respite care?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="wif-q8-a" role="region" aria-labelledby="wif-q8" hidden>
				<p>Compare environment (private home vs care setting), independence, how care is delivered, cost lines, family involvement and clinical suitability. Restwell is a private adapted bungalow with optional Continuity care, not a care home.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="wif-q9" aria-controls="wif-q9-a">
				<span>What is the difference between a respite break and an accessible holiday?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="wif-q9-a" role="region" aria-labelledby="wif-q9" hidden>
				<p>Respite usually means planned carer relief or continued formal care under funding language. An accessible holiday describes a place a disabled traveller can use. Many Restwell stays are both, but the paperwork answers different questions.</p>
			  </div>
			</div>
			</div>
		  </div>
		</div>
	  </div>
	</section>

	<?php
	$mid_cta_heading = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_wif_id, 'wif_cta_heading', __( 'Describe the party and equipment', 'restwell-retreats' ) )
		: __( 'Describe the party and equipment', 'restwell-retreats' );
	$mid_cta_intro   = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text(
			$restwell_wif_id,
			'wif_cta_body',
			__( 'We’ll say straight whether the bungalow fits, or where it doesn’t.', 'restwell-retreats' )
		)
		: __( 'We’ll say straight whether the bungalow fits, or where it doesn’t.', 'restwell-retreats' );
	$mid_cta_primary_label = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_wif_id, 'wif_cta_primary_label', __( 'Enquire', 'restwell-retreats' ) )
		: __( 'Enquire', 'restwell-retreats' );
	$mid_cta_primary_url   = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_wif_id, 'wif_cta_primary_url', restwell_nav_resolve_page_url( 'enquire' ) )
		: restwell_nav_resolve_page_url( 'enquire' );

	$mid_cta_secondary_label = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_wif_id, 'wif_cta_secondary_label', __( 'Read accessibility', 'restwell-retreats' ) )
		: __( 'Read accessibility', 'restwell-retreats' );
	$mid_cta_secondary_url   = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_wif_id, 'wif_cta_secondary_url', restwell_nav_resolve_page_url( 'accessibility' ) )
		: restwell_nav_resolve_page_url( 'accessibility' );

	get_template_part(
		'template-parts/mid-cta',
		null,
		array(
			'heading'         => $mid_cta_heading,
			'intro'           => $mid_cta_intro,
			'primary_label'   => $mid_cta_primary_label,
			'primary_url'     => $mid_cta_primary_url,
			'secondary_label' => $mid_cta_secondary_label,
			'secondary_url'   => $mid_cta_secondary_url,
		)
	);
	?>


</main>

<?php
get_footer();
