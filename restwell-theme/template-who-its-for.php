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
	? restwell_page_content_text( $restwell_wif_id, 'wif_heading', 'Holidays for disabled adults, their carers and families' )
	: 'Holidays for disabled adults, their carers and families';
$restwell_wif_intro   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text(
		$restwell_wif_id,
		'wif_intro',
		'Restwell is a private holiday home in Whitstable that sleeps five. Wheelchair users, people with learning disabilities, and guests with or without a PA are all welcome.'
	)
	: 'Restwell is a private holiday home in Whitstable that sleeps five. Wheelchair users, people with learning disabilities, and guests with or without a PA are all welcome.';

$wif_audience_heading = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $restwell_wif_id, 'wif_audience_heading', 'Who Restwell is built for' )
	: 'Who Restwell is built for';
$wif_audience_intro   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text(
		$restwell_wif_id,
		'wif_audience_intro',
		'Everyone works from the same door widths and kit list, so you can check the bungalow fits before anyone travels.'
	)
	: 'Everyone works from the same door widths and kit list, so you can check the bungalow fits before anyone travels.';

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
	),
);

// One photo and panel id per group for the tabs (21 Oct 2026), in $wif_personas order.
$wif_persona_tabs = array(
	array( 'families', 'journey/guest-harbour-beach.jpg', 1620, 1012, __( 'A guest in a powered wheelchair and a companion on Harbour Beach, Whitstable', 'restwell-retreats' ) ),
	array( 'carers', 'bungalow/BD1-2-LS.jpg', 2400, 1500, __( 'The second double bedroom, for a carer or support worker', 'restwell-retreats' ) ),
	array( 'ot', 'bungalow/BD2-6-LS.jpg', 2400, 1500, __( 'The ceiling track hoist over the profiling bed', 'restwell-retreats' ) ),
	array( 'commissioners', 'bungalow/EX-1-LS.jpg', 2400, 1500, __( 'The adapted bungalow in Whitstable from the drive', 'restwell-retreats' ) ),
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
		'fallback_src' => 'bungalow/H-1-LS.jpg',
		'fallback_alt' => 'Amico GoLift 400 ceiling hoist on the bedroom track',
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
			'For people who qualify for NHS Continuing Healthcare.',
			'Your ICB or CHC team deals with the forms.',
			'A stay in a private adapted house can be written into the plan where it meets the person’s needs.',
		)
	)
	: array();
$wif_fund_private_bullets = function_exists( 'restwell_wif_bullet_list' )
	? restwell_wif_bullet_list(
		$restwell_wif_id,
		'wif_fund_private_bullets',
		array(
			'You get the same access details and straight answers as funded guests.',
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
	),
	array(
		'title'     => function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text( $restwell_wif_id, 'wif_fund_phb_title', 'Personal health budget' )
			: 'Personal health budget',
		'bullets'   => $wif_fund_phb_bullets,
	),
	array(
		'title'     => function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text( $restwell_wif_id, 'wif_fund_private_title', 'Private / self-funded' )
			: 'Private / self-funded',
		'bullets'   => $wif_fund_private_bullets,
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
		  <li><a href="#faq">Questions</a></li>
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
		  <?php // The Property's room tabs (21 Oct 2026): one group per tab, a photo each. It was four long text rows. ?>
		  <div class="room-tour room-tour--groups" data-tabs>
			<div class="room-tour__nav">
			  <div class="room-tour__tabs" role="tablist" aria-label="<?php esc_attr_e( 'Who it’s for', 'restwell-retreats' ); ?>" hidden>
				<?php foreach ( $wif_personas as $wif_i => $persona ) : ?>
				<button type="button" role="tab" id="wif-tab-<?php echo esc_attr( $wif_persona_tabs[ $wif_i ][0] ); ?>" aria-controls="wif-<?php echo esc_attr( $wif_persona_tabs[ $wif_i ][0] ); ?>" aria-selected="<?php echo 0 === $wif_i ? 'true' : 'false'; ?>"<?php echo 0 === $wif_i ? '' : ' tabindex="-1"'; ?>><?php echo esc_html( $persona['title'] ); ?></button>
				<?php endforeach; ?>
			  </div>
			</div>
			<div class="room-tour__panels">
			  <?php foreach ( $wif_personas as $wif_i => $persona ) : ?>
			  <article class="room-tour__panel" id="wif-<?php echo esc_attr( $wif_persona_tabs[ $wif_i ][0] ); ?>">
				<img class="room-tour__photo" src="<?php echo esc_url( restwell_theme_image_url( $wif_persona_tabs[ $wif_i ][1] ) ); ?>" alt="<?php echo esc_attr( $wif_persona_tabs[ $wif_i ][4] ); ?>" width="<?php echo (int) $wif_persona_tabs[ $wif_i ][2]; ?>" height="<?php echo (int) $wif_persona_tabs[ $wif_i ][3]; ?>" sizes="(min-width: 1200px) 860px, 100vw" loading="lazy" decoding="async" />
				<div class="room-tour__card">
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
				</div>
			  </article>
			  <?php endforeach; ?>
			</div>
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
		<?php // Home's photo cards (21 Oct 2026): the wet room large, the hoist and kitchen beside it. It was three cards in a row. ?>
		<ul class="kit-cards" role="list">
		  <?php foreach ( $wif_kit_cards as $kit_card ) : ?>
				<?php
				$slot     = $wif_gallery_slots[ $kit_card['slot_index'] ] ?? array();
				$slot_id  = (int) ( $slot['id'] ?? 0 );
				$slot_alt = trim( (string) ( $slot['caption'] ?? '' ) );
				$img_alt  = '' !== $slot_alt ? $slot_alt : $kit_card['fallback_alt'];
				?>
		  <li class="care-choice care-choice--own">
				<?php if ( $slot_id > 0 && function_exists( 'restwell_get_property_attachment_image' ) ) : ?>
					<?php
					echo restwell_get_property_attachment_image( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- helper returns escaped HTML.
						$slot_id,
						'grid',
						array(
							'alt'   => $img_alt,
							'class' => 'care-choice__photo',
						)
					);
					?>
			<?php else : ?>
			<img class="care-choice__photo" src="<?php echo esc_url( restwell_theme_image_url( $kit_card['fallback_src'] ) ); ?>" alt="<?php echo esc_attr( $kit_card['fallback_alt'] ); ?>" width="2400" height="1500" sizes="(min-width: 768px) 720px, 100vw" loading="lazy" decoding="async" />
			<?php endif; ?>
			<div class="care-choice__text">
			  <h3><?php echo esc_html( $kit_card['title'] ); ?></h3>
			  <p><?php echo esc_html( $kit_card['body'] ); ?></p>
			</div>
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

	<?php
	// Optional home care (21 Oct 2026): the teal card The Property and How It
	// Works use, Keelie and Nikki by name only. It was small round faces.
	$wif_care_team = array(
		array( 'journey/keelie-varney.webp', 1500, 'Keelie Varney' ),
		array( 'journey/nikki-mackay.webp', 1429, 'Nikki Mackay' ),
	);
	?>
	<section class="section-y band-subtle" id="care" aria-labelledby="care-h">
	  <div class="container">
		<div class="care-choice care-choice--continuity care-choice--wide">
		  <div class="care-choice__team">
			<?php foreach ( $wif_care_team as $wif_care_person ) : ?>
			<figure>
			  <img src="<?php echo esc_url( restwell_theme_image_url( $wif_care_person[0] ) ); ?>" alt="" width="<?php echo (int) $wif_care_person[1]; ?>" height="2000" sizes="(min-width: 900px) 220px, 42vw" loading="lazy" decoding="async" />
			  <figcaption><?php echo esc_html( $wif_care_person[2] ); ?></figcaption>
			</figure>
			<?php endforeach; ?>
		  </div>
		  <div class="care-choice__text">
			<h2 id="care-h"><?php esc_html_e( 'If someone in your group needs care', 'restwell-retreats' ); ?></h2>
			<p><?php esc_html_e( 'Some groups bring their own carers. Others ask our sister company, Continuity, to cover a few visits or the nights. If you’d like their help, mention it when you enquire and they’ll give you a quote.', 'restwell-retreats' ); ?></p>
			<a class="care-choice__link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'optional-care' ) ); ?>"><?php esc_html_e( 'How optional care works', 'restwell-retreats' ); ?> <span aria-hidden="true">&rarr;</span></a>
		  </div>
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
			</div>
		  </li>
		  <?php endforeach; ?>
		</ul>
		<p><a class="text-link text-link--standalone" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'resources' ) ); ?>">Funding and support</a></p>
	  </div>
	</section>

	<?php // What happens when you get in touch? (21 Oct 2026): How It Works' photo per step. ?>
	<section class="section-y band-subtle" id="next" aria-labelledby="next-h">
	  <div class="container">
		<header class="section-head">
		  <p class="eyebrow">Next steps</p>
		  <h2 id="next-h">What happens when you get in touch?</h2>
		  <p class="lede">Tell us as much or as little as you like, and we’ll do the working out at our end.</p>
		</header>
		<ol class="step-photos">
		  <li>
			<img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/LR-1-LS.jpg' ) ); ?>" alt="" width="2400" height="1500" sizes="(min-width: 768px) 360px, 100vw" loading="lazy" decoding="async" />
			<h3>Tell us what you need</h3>
			<p>Tell us your dates, who’s coming and the chair or hoist you use. Say who’s paying, and whether you’d like care from Continuity. There’s no deposit to pay and no sales call.</p>
		  </li>
		  <li>
			<img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/EQU-2-LS.jpg' ) ); ?>" alt="" width="2400" height="1500" sizes="(min-width: 768px) 360px, 100vw" loading="lazy" decoding="async" />
			<h3>We check it fits</h3>
			<p>We compare what you’ve told us with our door widths and kit. If Restwell isn’t the right house, we’ll say so plainly.</p>
		  </li>
		  <li>
			<img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/GRDEN-2-LS.jpg' ) ); ?>" alt="" width="2400" height="1500" sizes="(min-width: 768px) 360px, 100vw" loading="lazy" decoding="async" />
			<h3>Reserve your dates</h3>
			<p>Once we’ve agreed the bungalow fits, a 50% deposit holds your dates. <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'how-it-works' ) ); ?>">How booking works</a> covers the rest, from the balance to arrival day.</p>
		  </li>
		</ol>
	  </div>
	</section>
	<section class="faq section-y band-white" id="faq" aria-labelledby="faq-h">
	  <div class="container">
		<div class="faq__layout">
		  <header class="faq__intro">
			<p class="eyebrow">Suitability</p>
			<h2 id="faq-h">Questions about planning a stay</h2>
			<p class="lede">How to plan a stay around complex care needs, and when a bungalow suits better than a respite placement.</p>
		  </header>
		  <div class="faq-list faq-list--split" data-faq-accordion>
			<div class="faq-list__col">
			<div class="faq-item is-open">
			  <button type="button" class="faq-item__trigger" aria-expanded="true" id="wif-q1" aria-controls="wif-q1-a">
				<span>How do I plan a holiday when someone has complex care needs?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="wif-q1-a" role="region" aria-labelledby="wif-q1">
				<p>Start by checking our measurements against the person’s equipment. Then plan staffing for the day and night, with a backup if someone falls ill. After that, sort out who pays for the stay and the care, and fix your dates.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="wif-q2" aria-controls="wif-q2-a">
				<span>How do I plan a holiday if I have complex care needs myself?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="wif-q2-a" role="region" aria-labelledby="wif-q2" hidden>
				<p>Start with our access statement, which has the door widths and hoist details. Then arrange your carers or ask Continuity, and agree a backup if a carer is ill. When you have a plan, send us your dates, and we’ll check it with you.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="wif-q3" aria-controls="wif-q3-a">
				<span>How should I prepare for an accessible holiday?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="wif-q3-a" role="region" aria-labelledby="wif-q3" hidden>
				<p>Get the access details confirmed in writing, and pack what the house won’t have, like slings, medicines and chargers. Share the care plan with whoever is covering the stay. Keep our number and your care provider’s to hand.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="wif-q4" aria-controls="wif-q4-a">
				<span>What belongs on a disabled holiday checklist?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="wif-q4-a" role="region" aria-labelledby="wif-q4" hidden>
				<p>It helps to make five short lists. Cover access needs, medical needs, the care rota and backup, documents, and home comforts. Check each one against our published equipment list, so you don’t pack anything we already have.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="wif-q5" aria-controls="wif-q5-a">
				<span>Is a holiday possible if someone has complex needs?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="wif-q5-a" role="region" aria-labelledby="wif-q5" hidden>
				<p>Yes, as long as the door widths, the overnight staffing and the transfers all work before you travel. Start with the measurements and the care rota rather than the photos. This page and our access statement will help you check the fit before you enquire.</p>
				<?php
				// Revitalise guests still search for the old centres; the guide says where people go now.
				$restwell_revitalise_post = get_page_by_path( 'revitalise-alternatives-accessible-holidays', OBJECT, 'post' );
				if ( $restwell_revitalise_post instanceof WP_Post && 'publish' === $restwell_revitalise_post->post_status ) :
					?>
				<p>If you used to book with Revitalise, our guide to <a class="text-link" href="<?php echo esc_url( get_permalink( $restwell_revitalise_post ) ); ?>">what happened to Revitalise holidays</a> covers where people go now.</p>
				<?php endif; ?>
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
				<p>Neither is better in every case. A private cottage suits people who bring their own carers or have visiting care. A respite placement suits people who need nursing or clinical support on site.</p>
				<p>Restwell, with optional care from Continuity, fits the first case. It isn’t a substitute for residential care when that’s clinically needed.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="wif-q9" aria-controls="wif-q9-a">
				<span>What is the difference between a respite break and an accessible holiday?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="wif-q9-a" role="region" aria-labelledby="wif-q9" hidden>
				<p>Respite usually means planned time off for a carer, or care that carries on under a funding plan. An accessible holiday is a place a disabled person can stay and get around. Many stays here are both, but funders ask different questions about each.</p>
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
