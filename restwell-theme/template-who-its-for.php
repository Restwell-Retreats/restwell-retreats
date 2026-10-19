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
		'Restwell is built for disabled adults, their families and the people who care for them, in groups of up to five. It’s a holiday let you have to yourselves, not a care home or a respite centre.'
	)
	: 'Restwell is built for disabled adults, their families and the people who care for them, in groups of up to five. It’s a holiday let you have to yourselves, not a care home or a respite centre.';

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
		'Families, carers, occupational therapists and commissioners all work from the same published door widths and equipment list. That way you can decide whether the bungalow fits before anyone travels.'
	)
	: 'Families, carers, occupational therapists and commissioners all work from the same published door widths and equipment list. That way you can decide whether the bungalow fits before anyone travels.';

$wif_default_family_bullets = function_exists( 'restwell_get_property_facts_persona_bullets' )
	? restwell_get_property_facts_persona_bullets( 'family' )
	: array(
		'Ceiling track hoist in the accessible bedroom, profiling bed, and wet room with roll-in shower.',
		'Published access measurements before you commit.',
		'A private, self-catering house, so your routines run to your own schedule.',
	);
$wif_default_carers_bullets = function_exists( 'restwell_get_property_facts_persona_bullets' )
	? restwell_get_property_facts_persona_bullets( 'carers' )
	: array(
		'A separate place to sleep for the support worker or carer.',
		'A wet room set up for assisted personal care on the same level.',
		'You have a legal right to a Carer\'s Assessment under the Care Act 2014.',
	);
$wif_default_ot_bullets = function_exists( 'restwell_get_property_facts_persona_bullets' )
	? restwell_get_property_facts_persona_bullets( 'ot' )
	: array(
		'Doorway widths, turning circles, hoist specs, and wet room measurements on request.',
		'We confirm transfer clearances and equipment positioning if they are not already published.',
		'We welcome referral conversations before any booking commitment.',
	);
$wif_default_commissioners_bullets = function_exists( 'restwell_get_property_facts_persona_bullets' )
	? restwell_get_property_facts_persona_bullets( 'commissioners' )
	: array(
		'Short breaks at a private adapted setting can form part of a care and support plan under the Care Act 2014.',
		'We provide the paperwork: property spec, access measurements, and CQC-registered care provider confirmation.',
		'We support direct payments, personal health budgets and CHC.',
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
		'icon'             => 'house',
		'title'            => function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text( $restwell_wif_id, 'wif_family_title', 'Guests and families' )
			: 'Guests and families',
		'body'             => function_exists( 'restwell_wif_persona_intro_body' )
			? restwell_wif_persona_intro_body(
				$restwell_wif_id,
				'wif_family_body',
				'wif_family_detail_body',
				'The hoist and the wet room are already fitted, and every measurement is published. It’s a private house, so your routines run on your own time rather than a hotel’s.'
			)
			: ( function_exists( 'restwell_page_content_text' )
				? restwell_page_content_text( $restwell_wif_id, 'wif_family_body', 'The hoist and the wet room are already fitted, and every measurement is published. It’s a private house, so your routines run on your own time rather than a hotel’s.' )
				: 'The hoist and the wet room are already fitted, and every measurement is published. It’s a private house, so your routines run on your own time rather than a hotel’s.' ),
		'bullets'          => function_exists( 'restwell_wif_bullet_list' )
			? restwell_wif_bullet_list( $restwell_wif_id, 'wif_family_detail_bullets', $wif_default_family_bullets )
			: $wif_default_family_bullets,
		'inline_cta_label' => function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text( $restwell_wif_id, 'wif_family_inline_cta_label', 'Door widths and the hoist' )
			: 'Door widths and the hoist',
		'inline_cta_url'   => $wif_resolve_url( 'wif_family_inline_cta_url', '/accessibility/' ),
	),
	array(
		'icon'             => 'users',
		'title'            => function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text( $restwell_wif_id, 'wif_carers_title', 'Carers and support workers' )
			: 'Carers and support workers',
		'body'             => function_exists( 'restwell_wif_persona_intro_body' )
			? restwell_wif_persona_intro_body(
				$restwell_wif_id,
				'wif_carers_body',
				'wif_carers_detail_body',
				'There’s a separate bedroom for a carer or support worker, and room to help with transfers and personal care. If you look after someone, you can ask your council for a carer’s assessment.'
			)
			: ( function_exists( 'restwell_page_content_text' )
				? restwell_page_content_text( $restwell_wif_id, 'wif_carers_body', 'There’s a separate bedroom for a carer or support worker, and room to help with transfers and personal care. If you look after someone, you can ask your council for a carer’s assessment.' )
				: 'There’s a separate bedroom for a carer or support worker, and room to help with transfers and personal care. If you look after someone, you can ask your council for a carer’s assessment.' ),
		'bullets'          => function_exists( 'restwell_wif_bullet_list' )
			? restwell_wif_bullet_list( $restwell_wif_id, 'wif_carers_detail_bullets', $wif_default_carers_bullets )
			: $wif_default_carers_bullets,
		'inline_cta_label' => function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text( $restwell_wif_id, 'wif_carers_inline_cta_label', 'Ask a suitability question' )
			: 'Ask a suitability question',
		'inline_cta_url'   => $wif_resolve_url( 'wif_carers_inline_cta_url', '/enquire/' ),
	),
	array(
		'icon'             => 'clipboard-check',
		'title'            => function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text( $restwell_wif_id, 'wif_ot_title', 'Occupational therapists' )
			: 'Occupational therapists',
		'body'             => function_exists( 'restwell_wif_persona_intro_body' )
			? restwell_wif_persona_intro_body(
				$restwell_wif_id,
				'wif_ot_body',
				'wif_ot_detail_body',
				'Door widths, hoist details and wet room measurements are all published. If you need one we haven’t listed, ask and we’ll go and measure it.'
			)
			: ( function_exists( 'restwell_page_content_text' )
				? restwell_page_content_text( $restwell_wif_id, 'wif_ot_body', 'Door widths, hoist details and wet room measurements are all published. If you need one we haven’t listed, ask and we’ll go and measure it.' )
				: 'Door widths, hoist details and wet room measurements are all published. If you need one we haven’t listed, ask and we’ll go and measure it.' ),
		'bullets'          => function_exists( 'restwell_wif_bullet_list' )
			? restwell_wif_bullet_list( $restwell_wif_id, 'wif_ot_detail_bullets', $wif_default_ot_bullets )
			: $wif_default_ot_bullets,
		'inline_cta_label' => function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text( $restwell_wif_id, 'wif_ot_inline_cta_label', 'Door widths and the hoist' )
			: 'Door widths and the hoist',
		'inline_cta_url'   => $wif_resolve_url( 'wif_ot_inline_cta_url', '/accessibility/' ),
	),
	array(
		'icon'             => 'building-2',
		'title'            => function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text( $restwell_wif_id, 'wif_commissioners_title', 'Commissioners & social care' )
			: 'Commissioners & social care',
		'body'             => function_exists( 'restwell_wif_persona_intro_body' )
			? restwell_wif_persona_intro_body(
				$restwell_wif_id,
				'wif_commissioners_body',
				'wif_commissioners_detail_body',
				'A stay here can form part of a Care Act short break. We can supply the paperwork for direct payments, personal health budgets or CHC.'
			)
			: ( function_exists( 'restwell_page_content_text' )
				? restwell_page_content_text( $restwell_wif_id, 'wif_commissioners_body', 'A stay here can form part of a Care Act short break. We can supply the paperwork for direct payments, personal health budgets or CHC.' )
				: 'A stay here can form part of a Care Act short break. We can supply the paperwork for direct payments, personal health budgets or CHC.' ),
		'bullets'          => function_exists( 'restwell_wif_bullet_list' )
			? restwell_wif_bullet_list( $restwell_wif_id, 'wif_commissioners_detail_bullets', $wif_default_commissioners_bullets )
			: $wif_default_commissioners_bullets,
		'inline_cta_label' => function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text( $restwell_wif_id, 'wif_commissioners_inline_cta_label', 'Enquire about a funded stay' )
			: 'Enquire about a funded stay',
		'inline_cta_url'   => $wif_resolve_url( 'wif_commissioners_inline_cta_url', '/enquire/' ),
	),
);

$wif_visual_intro = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text(
		$restwell_wif_id,
		'wif_visual_intro',
		'All three are in the bungalow before you arrive, so there’s nothing to hire for the week.'
	)
	: 'All three are in the bungalow before you arrive, so there’s nothing to hire for the week.';

$wif_kit_cards = array(
	array(
		'fallback_src' => 'bungalow/WR-1-LS.jpg',
		'fallback_alt' => 'Level-access wet room with grab rails and a shower commode chair',
		'title'        => function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text( $restwell_wif_id, 'wif_section_image_1_caption', 'Level-access wet room' )
			: 'Level-access wet room',
		'body'         => 'A level-access shower, grab rails and a basin that moves up and down, designed with Care Spaces.',
		'slot_index'   => 0,
	),
	array(
		'fallback_src' => 'bungalow/BD2-6-LS.jpg',
		'fallback_alt' => 'Amico ceiling track hoist over the bed',
		'title'        => function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text( $restwell_wif_id, 'wif_section_image_2_caption', 'Ceiling track hoist' )
			: 'Ceiling track hoist',
		'body'         => 'An Amico ceiling track that covers the whole bedroom, and a mobile hoist you can use in any room.',
		'slot_index'   => 1,
	),
	array(
		'fallback_src' => 'bungalow/KT-1-LS.jpg',
		'fallback_alt' => 'Kitchen with wheel-under worksurface',
		'title'        => function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text( $restwell_wif_id, 'wif_section_image_3_caption', 'Reachable kitchen' )
			: 'Reachable kitchen',
		'body'         => 'A worktop you can wheel under, a gas hob and the cooking basics.',
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
		'We can invoice you, a council, an NHS team or a grant body. Our funding page explains how each route usually works and what to ask before you book.'
	)
	: 'We can invoice you, a council, an NHS team or a grant body. Our funding page explains how each route usually works and what to ask before you book.';

$wif_fund_la_bullets = function_exists( 'restwell_wif_bullet_list' )
	? restwell_wif_bullet_list(
		$restwell_wif_id,
		'wif_fund_la_bullets',
		array(
			'It starts with an assessment of your care needs, and unpaid carers can ask for their own assessment too.',
			'With direct payments, you hold the money and choose who provides the support.',
			'Whether a direct payment covers the stay is up to your council, so ask before you book.',
		)
	)
	: array();
// Pages seeded before the 9 Oct 2026 pass still hold last year's figure line in meta.
$wif_fund_la_bullets = array_map(
	static function ( $bullet ) {
		return 0 === strpos( (string) $bullet, 'Capital limits 2024/25' )
			? 'Capital limits in England (2026/27): above £23,250 you generally pay in full; below £14,250 is usually ignored. Councils can set their own limits for care at home, so check yours.'
			: $bullet;
	},
	$wif_fund_la_bullets
);
$wif_fund_phb_bullets = function_exists( 'restwell_wif_bullet_list' )
	? restwell_wif_bullet_list(
		$restwell_wif_id,
		'wif_fund_phb_bullets',
		array(
			'For people found eligible for NHS Continuing Healthcare.',
			'Your ICB or continuing healthcare team handles the application.',
			'A stay in a private adapted house can be written into the plan where it meets the person’s needs.',
		)
	)
	: array();
$wif_fund_private_bullets = function_exists( 'restwell_wif_bullet_list' )
	? restwell_wif_bullet_list(
		$restwell_wif_id,
		'wif_fund_private_bullets',
		array(
			'You get the same access information and straight answers as funded guests.',
			'We can send paperwork for your insurer or employer if you need it.',
			'We’ll tell you plainly if the bungalow isn’t the right fit.',
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
			? restwell_page_content_text( $restwell_wif_id, 'wif_fund_phb_cta_label', 'How NHS funding usually works' )
			: 'How NHS funding usually works',
		'cta_url'   => $wif_resolve_url( 'wif_fund_phb_cta_url', '/funding-and-support/' ),
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

	<nav class="subnav" aria-label="On this page" data-toc>
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
	  <div class="container">
		  <header class="section-head section-head--tight">
			<p class="eyebrow">Your situation</p>
			<h2 id="situations-h"><?php echo esc_html( $wif_audience_heading ); ?></h2>
			<p class="lede"><?php echo esc_html( $wif_audience_intro ); ?></p>
		  </header>
		  <ul class="persona-list persona-list--cards persona-list--index" role="list">
			<?php foreach ( $wif_personas as $persona ) : ?>
			<li class="persona-list__item">
			  <span class="icon-circle" aria-hidden="true"><?php restwell_the_icon( $persona['icon'] ); ?></span>
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
				<p class="persona-list__cta"><a class="text-link" href="<?php echo esc_url( $persona['inline_cta_url'] ); ?>"><?php echo esc_html( $persona['inline_cta_label'] ); ?></a></p>
				<?php endif; ?>
			  </div>
			</li>
			<?php endforeach; ?>
		  </ul>
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
		<p><a class="text-link text-link--standalone" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'accessibility' ) ); ?>">Door widths and the hoist</a></p>
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

	<section class="section-y section-y--slim band-subtle care-pointer" id="care" aria-labelledby="care-h">
	  <div class="container">
		<div class="care-pointer__card">
		  <?php get_template_part( 'template-parts/care-faces' ); ?>
		  <p class="eyebrow"><?php esc_html_e( 'Optional care', 'restwell-retreats' ); ?></p>
		  <h2 id="care-h"><?php esc_html_e( 'Optional home care', 'restwell-retreats' ); ?></h2>
		  <p class="lede"><?php esc_html_e( 'Some groups bring their own carers, and some ask our sister company, Continuity, to cover a few visits or the nights. If you’d like their help, mention it when you enquire and they’ll give you a quote.', 'restwell-retreats' ); ?></p>
		  <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'optional-care' ) ); ?>"><?php esc_html_e( 'How optional care works', 'restwell-retreats' ); ?><?php restwell_the_icon( 'arrow-right' ); ?></a>
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
		<ul class="persona-list persona-list--cards persona-list--index" role="list">
		  <?php foreach ( $wif_funding_routes as $route ) : ?>
		  <li class="persona-list__item">
			<div>
			  <h3><?php echo esc_html( $route['title'] ); ?></h3>
				<?php if ( ! empty( $route['bullets'] ) ) : ?>
			  <ul class="checklist">
					<?php foreach ( $route['bullets'] as $bullet ) : ?>
				<li><?php echo esc_html( $bullet ); ?></li>
				<?php endforeach; ?>
			  </ul>
			  <?php endif; ?>
				<?php if ( '' !== trim( (string) $route['cta_label'] ) ) : ?>
			  <p class="persona-list__cta"><a class="text-link" href="<?php echo esc_url( $route['cta_url'] ); ?>"><?php echo esc_html( $route['cta_label'] ); ?></a></p>
			  <?php endif; ?>
			</div>
		  </li>
		  <?php endforeach; ?>
		</ul>
		<p><a class="text-link text-link--standalone" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'resources' ) ); ?>">Funding and support</a></p>
	  </div>
	</section>

	<section class="section-y band-subtle process" id="next" aria-labelledby="next-h">
	  <div class="container">
		<header class="section-head process__head">
		  <p class="eyebrow">Next steps</p>
		  <h2 id="next-h">What happens when you get in touch?</h2>
		  <p class="lede">Tell us as much or as little as you like, and we’ll do the working out at our end.</p>
		</header>
		<div class="process__layout">
		  <ol class="process-list">
			<li>
			  <span class="process-list__index" aria-hidden="true">01</span>
			  <div class="process-list__body">
				<h3>Tell us what you need</h3>
				<p class="process-list__meta">Start here</p>
				<p>Tell us your dates, who’s coming, the chair or hoist you use, who’s paying and whether you’d like care from Continuity. There’s no deposit to pay and no sales call.</p>
			  </div>
			</li>
			<li>
			  <span class="process-list__index" aria-hidden="true">02</span>
			  <div class="process-list__body">
				<h3>We check it fits</h3>
				<p class="process-list__meta">We reply</p>
				<p>We compare what you’ve told us with our door widths and kit, and say plainly if Restwell isn’t the right house.</p>
			  </div>
			</li>
			<li>
			  <span class="process-list__index" aria-hidden="true">03</span>
			  <div class="process-list__body">
				<h3>Reserve your dates</h3>
				<p class="process-list__meta">When you’re ready</p>
				<p>Once we’ve agreed the bungalow fits, a 50% deposit holds your dates. <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'how-it-works' ) ); ?>">How booking works</a> covers the rest, from the balance to arrival day.</p>
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
			<h2 id="faq-h">Questions about planning a stay</h2>
			<p class="lede">How to plan a stay when someone has complex care needs, and when a private bungalow suits better than respite in a care home.</p>
		  </header>
		  <div class="faq-list faq-list--split" data-faq-accordion>
			<div class="faq-list__col">
			<div class="faq-item is-open">
			  <button type="button" class="faq-item__trigger" aria-expanded="true" id="wif-q1" aria-controls="wif-q1-a">
				<span>How do I plan a holiday when someone has complex care needs?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="wif-q1-a" role="region" aria-labelledby="wif-q1">
				<p>Start by checking our published measurements against the person’s equipment. Then plan staffing for the day and the night, with a backup if someone falls ill. After that, work out who pays for the stay and who pays for the care, and get the equipment confirmed in writing. Fix your dates once that’s clear, along with medicines and transport.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="wif-q2" aria-controls="wif-q2-a">
				<span>How do I plan a holiday if I have complex care needs myself?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="wif-q2-a" role="region" aria-labelledby="wif-q2" hidden>
				<p>Our access statement is the place to start, because it has the door widths and the hoist details. Then arrange your carers or ask Continuity, check your slings and prescriptions, and agree a backup in case a carer is ill. When you have a rough plan, send us your dates and we’ll check it with you.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="wif-q3" aria-controls="wif-q3-a">
				<span>How should I prepare for an accessible holiday?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="wif-q3-a" role="region" aria-labelledby="wif-q3" hidden>
				<p>Get the access details confirmed in writing, and pack the things the house won’t have, like slings, medicines, chargers and anything that makes you comfortable. Share the care plan with whoever is covering the stay, and keep our number and your care provider’s number to hand.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="wif-q4" aria-controls="wif-q4-a">
				<span>What belongs on a disabled holiday checklist?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="wif-q4-a" role="region" aria-labelledby="wif-q4" hidden>
				<p>It helps to make five short lists: access needs, medical needs, the care rota and backup, documents, and the everyday things that make you comfortable. Check each one against our published equipment list, so you don’t pack anything we already have.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="wif-q5" aria-controls="wif-q5-a">
				<span>Is a holiday possible if someone has complex needs?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="wif-q5-a" role="region" aria-labelledby="wif-q5" hidden>
				<p>Yes, as long as the door widths, the overnight staffing and the transfers all work before you travel. Start with the measurements and the care rota rather than the photos. This page and our access statement will help you check the fit before you enquire.</p>
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
				<p>Neither is better in every case. A private cottage suits people who bring their own carers or have visiting care, with the right equipment for transfers. A respite placement suits people who need nursing or clinical support on site. Restwell, with optional care from Continuity, fits the first case, and it isn’t a substitute for residential care when that’s clinically needed.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="wif-q9" aria-controls="wif-q9-a">
				<span>What is the difference between a respite break and an accessible holiday?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="wif-q9-a" role="region" aria-labelledby="wif-q9" hidden>
				<p>Respite usually means planned time off for a carer, or care that carries on under a funding plan. An accessible holiday is a place a disabled person can stay and get around. Many stays here are both, but the funding paperwork asks different questions about each.</p>
			  </div>
			</div>
			</div>
		  </div>
		</div>
	  </div>
	</section>

	<?php
	$mid_cta_heading = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_wif_id, 'wif_cta_heading', __( 'Tell us who’s coming and what you use', 'restwell-retreats' ) )
		: __( 'Tell us who’s coming and what you use', 'restwell-retreats' );
	$mid_cta_intro   = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text(
			$restwell_wif_id,
			'wif_cta_body',
			__( 'We’ll tell you plainly whether the bungalow fits, and where it doesn’t.', 'restwell-retreats' )
		)
		: __( 'We’ll tell you plainly whether the bungalow fits, and where it doesn’t.', 'restwell-retreats' );
	$mid_cta_primary_label = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_wif_id, 'wif_cta_primary_label', __( 'Enquire', 'restwell-retreats' ) )
		: __( 'Enquire', 'restwell-retreats' );
	$mid_cta_primary_url   = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_wif_id, 'wif_cta_primary_url', restwell_nav_resolve_page_url( 'enquire' ) )
		: restwell_nav_resolve_page_url( 'enquire' );

	$mid_cta_secondary_label = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_wif_id, 'wif_cta_secondary_label', __( 'Door widths and the hoist', 'restwell-retreats' ) )
		: __( 'Door widths and the hoist', 'restwell-retreats' );
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
