<?php
/**
 * Concept port from mockups — Homepage.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$home_id  = (int) get_option( 'page_on_front', 0 );
$hero_src = ( $home_id > 0 && function_exists( 'restwell_page_hero_image_url' ) )
	? restwell_page_hero_image_url( $home_id )
	: restwell_theme_image_url( 'stock/restwell-whitstable-promenade-golden-hour.jpg' );
$hero_alt = ( $home_id > 0 && function_exists( 'restwell_page_hero_image_alt' ) )
	? restwell_page_hero_image_alt( $home_id, __( 'Accessible holidays in Whitstable', 'restwell-retreats' ) )
	: restwell_theme_image_alt( 'stock/restwell-whitstable-promenade-golden-hour.jpg' );

$hero_heading = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'hero_heading', 'Accessible holidays in Whitstable' )
	: 'Accessible holidays in Whitstable';
$hero_intro   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text(
		$home_id,
		'hero_subheading',
		'Private bungalow with a level wet room and ceiling track hoist. Home care from Continuity, quoted separately.'
	)
	: 'Private bungalow with a level wet room and ceiling track hoist. Home care from Continuity, quoted separately.';

$hero_cta_primary_label = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'hero_cta_primary_label', __( 'Enquire', 'restwell-retreats' ) )
	: __( 'Enquire', 'restwell-retreats' );
$hero_cta_primary_url   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'hero_cta_primary_url', restwell_nav_resolve_page_url( 'enquire' ) )
	: restwell_nav_resolve_page_url( 'enquire' );
$hero_cta_secondary_label = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'hero_cta_secondary_label', __( 'Look inside the bungalow', 'restwell-retreats' ) )
	: __( 'Look inside the bungalow', 'restwell-retreats' );
$hero_cta_secondary_url   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'hero_cta_secondary_url', restwell_nav_resolve_page_url( 'the-property' ) )
	: restwell_nav_resolve_page_url( 'the-property' );
$hero_cta_note = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text(
		$home_id,
		'hero_cta_reassurance',
		__( 'We aim to reply within 48 hours, and there’s no deposit until you’ve decided the house fits.', 'restwell-retreats' )
	)
	: __( 'We aim to reply within 48 hours, and there’s no deposit until you’ve decided the house fits.', 'restwell-retreats' );

$property_label   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'property_label', __( 'The bungalow', 'restwell-retreats' ) )
	: __( 'The bungalow', 'restwell-retreats' );
$property_heading = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'property_heading', __( 'One bungalow, and it’s all yours', 'restwell-retreats' ) )
	: __( 'One bungalow, and it’s all yours', 'restwell-retreats' );
$property_body    = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text(
		$home_id,
		'property_body',
		__( 'It sits on a quiet residential street in Whitstable, about ten minutes from the seafront. The driveway is private and level, with room for two cars including an adapted vehicle. Park up and the front door is straight ahead. We’ll send you the address once your stay is confirmed.', 'restwell-retreats' )
	)
	: __( 'It sits on a quiet residential street in Whitstable, about ten minutes from the seafront. The driveway is private and level, with room for two cars including an adapted vehicle. Park up and the front door is straight ahead. We’ll send you the address once your stay is confirmed.', 'restwell-retreats' );
$property_cta_label = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'property_cta_label', __( 'Have a proper look round the rooms', 'restwell-retreats' ) )
	: __( 'Have a proper look round the rooms', 'restwell-retreats' );
$property_cta_url   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'property_cta_url', restwell_nav_resolve_page_url( 'the-property' ) )
	: restwell_nav_resolve_page_url( 'the-property' );
$property_image_url = restwell_theme_image_url( 'bungalow/EX-1-LS.jpg' );
$property_image_alt = 'Restwell bungalow exterior in Whitstable';
if ( $home_id > 0 && function_exists( 'restwell_page_content_meta_or_default' ) ) {
	$property_image_id = absint( restwell_page_content_meta_or_default( $home_id, 'property_image_id' ) );
	if ( $property_image_id > 0 ) {
		$picked = function_exists( 'restwell_pick_attachment_size' )
			? restwell_pick_attachment_size( $property_image_id, 'restwell-property', 'large' )
			: 'large';
		$src    = wp_get_attachment_image_src( $property_image_id, $picked );
		if ( $src && ! empty( $src[0] ) ) {
			$property_image_url = $src[0];
			$alt                = trim( (string) get_post_meta( $property_image_id, '_wp_attachment_image_alt', true ) );
			if ( '' !== $alt ) {
				$property_image_alt = $alt;
			}
		}
	}
}

$comparison_heading = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'home_comparison_heading', __( 'A wet room in a hotel still comes with the corridor', 'restwell-retreats' ) )
	: __( 'A wet room in a hotel still comes with the corridor', 'restwell-retreats' );
$comparison_cards   = array(
	array(
		'title' => function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text( $home_id, 'why_item1_title', __( 'Private & personal', 'restwell-retreats' ) )
			: __( 'Private & personal', 'restwell-retreats' ),
		'desc'  => function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text(
				$home_id,
				'why_item1_desc',
				__( 'The whole bungalow is yours: living space, kitchen, two bedrooms plus a sofa bed in the conservatory (sleeps up to five), with the privacy of a self-catering stay.', 'restwell-retreats' )
			)
			: __( 'The whole bungalow is yours: living space, kitchen, two bedrooms plus a sofa bed in the conservatory (sleeps up to five), with the privacy of a self-catering stay.', 'restwell-retreats' ),
		'icon'  => 'doc',
	),
	array(
		'title' => function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text( $home_id, 'why_item2_title', __( 'Professional support on your terms', 'restwell-retreats' ) )
			: __( 'Professional support on your terms', 'restwell-retreats' ),
		'desc'  => function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text(
				$home_id,
				'why_item2_desc',
				__( 'Continuity of Care Services (CQC-regulated): support arranged on your terms, as much or as little as you need, or bring your own carer.', 'restwell-retreats' )
			)
			: __( 'Continuity of Care Services (CQC-regulated): support arranged on your terms, as much or as little as you need, or bring your own carer.', 'restwell-retreats' ),
		'icon'  => 'phone',
	),
	array(
		'title' => function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text( $home_id, 'why_item3_title', __( 'Local knowledge', 'restwell-retreats' ) )
			: __( 'Local knowledge', 'restwell-retreats' ),
		'desc'  => function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text(
				$home_id,
				'why_item3_desc',
				__( 'We can tell you which cafes have step-free access, where to park near the harbour, and which routes work for wheelchairs, so you spend more time relaxing and less time planning.', 'restwell-retreats' )
			)
			: __( 'We can tell you which cafes have step-free access, where to park near the harbour, and which routes work for wheelchairs, so you spend more time relaxing and less time planning.', 'restwell-retreats' ),
		'icon'  => 'heart',
	),
);

$paths_label         = function_exists( 'restwell_page_content_text' )
	? trim( (string) restwell_page_content_meta_or_default( $home_id, 'home_teaser_label' ) )
	: 'show';
$paths_show          = ( '' !== $paths_label ); // empty label hides the band (schema contract).
$paths_heading       = __( 'Plan a day, or a way to pay', 'restwell-retreats' );
$paths_intro         = __( 'The harbour beach is shingle. Tankerton promenade is the level stretch. If a funder might help with the cost, we can invoice whoever you name.', 'restwell-retreats' );
$paths_area_title    = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'home_teaser_area_title', __( 'Whitstable and Tankerton', 'restwell-retreats' ) )
	: __( 'Whitstable and Tankerton', 'restwell-retreats' );
$paths_area_body     = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'home_teaser_area_body', __( 'Surfaces, parking, and which places have an accessible loo, including the ones that don’t.', 'restwell-retreats' ) )
	: __( 'Surfaces, parking, and which places have an accessible loo, including the ones that don’t.', 'restwell-retreats' );
$paths_funding_title = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'home_teaser_funding_title', __( 'Who we can invoice', 'restwell-retreats' ) )
	: __( 'Who we can invoice', 'restwell-retreats' );
$paths_funding_body  = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'home_teaser_funding_body', __( 'You, a council, the NHS or a grant body. The bungalow rate is the same either way. We can’t promise your package will cover it.', 'restwell-retreats' ) )
	: __( 'You, a council, the NHS or a grant body. The bungalow rate is the same either way. We can’t promise your package will cover it.', 'restwell-retreats' );

$mid_cta_heading = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'cta_heading', __( 'Ask us anything about a stay', 'restwell-retreats' ) )
	: __( 'Ask us anything about a stay', 'restwell-retreats' );
$mid_cta_intro   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text(
		$home_id,
		'cta_body',
		__( 'There’s no deposit until you’ve decided the house fits. We aim to reply within 48 hours.', 'restwell-retreats' )
	)
	: __( 'There’s no deposit until you’ve decided the house fits. We aim to reply within 48 hours.', 'restwell-retreats' );
$mid_cta_primary_label = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'cta_primary_label', __( 'Enquire', 'restwell-retreats' ) )
	: __( 'Enquire', 'restwell-retreats' );
$mid_cta_primary_url   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'cta_primary_url', restwell_nav_resolve_page_url( 'enquire' ) )
	: restwell_nav_resolve_page_url( 'enquire' );
$mid_cta_secondary_label = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'cta_secondary_label', __( 'Look inside the bungalow', 'restwell-retreats' ) )
	: __( 'Look inside the bungalow', 'restwell-retreats' );
$mid_cta_secondary_url   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'cta_secondary_url', restwell_nav_resolve_page_url( 'the-property' ) )
	: restwell_nav_resolve_page_url( 'the-property' );

$home_care_label   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'home_care_label', '' )
	: '';
$home_care_heading = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'home_care_heading', __( 'Optional home care', 'restwell-retreats' ) )
	: __( 'Optional home care', 'restwell-retreats' );
$home_care_intro   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text(
		$home_id,
		'home_care_intro',
		__( 'Restwell is a private bungalow holiday: one house, by the sea, for your party alone, not a care home. How you manage care is up to you, and the bungalow rate stays the same whichever you choose:', 'restwell-retreats' )
	)
	: __( 'Restwell is a private bungalow holiday: one house, by the sea, for your party alone, not a care home. How you manage care is up to you, and the bungalow rate stays the same whichever you choose:', 'restwell-retreats' );
$home_care_item1_title = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'home_care_item1_title', __( 'Bring your own support', 'restwell-retreats' ) )
	: __( 'Bring your own support', 'restwell-retreats' );
$home_care_item1_body  = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'home_care_item1_body', __( 'Plenty of guests bring their own carer or manage just like they do at home.', 'restwell-retreats' ) )
	: __( 'Plenty of guests bring their own carer or manage just like they do at home.', 'restwell-retreats' );
$home_care_item2_title = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'home_care_item2_title', __( 'Use our care team', 'restwell-retreats' ) )
	: __( 'Use our care team', 'restwell-retreats' );
$home_care_item2_body  = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text(
		$home_id,
		'home_care_item2_body',
		__( 'If you\'d like professional home care, our sister company Continuity of Care Services can come to you. They\'re rated Good by the CQC, and because we share an office and phone number, one conversation covers everything.', 'restwell-retreats' )
	)
	: __( 'If you\'d like professional home care, our sister company Continuity of Care Services can come to you. They\'re rated Good by the CQC, and because we share an office and phone number, one conversation covers everything.', 'restwell-retreats' );
$home_care_note      = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'home_care_note', __( 'Ring 01622 809881 if that’s easier than a form.', 'restwell-retreats' ) )
	: __( 'Ring 01622 809881 if that’s easier than a form.', 'restwell-retreats' );
$home_care_cta_label = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'home_care_cta_label', __( 'What home care here actually looks like', 'restwell-retreats' ) )
	: __( 'What home care here actually looks like', 'restwell-retreats' );
$home_care_cta_url   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'home_care_cta_url', restwell_nav_resolve_page_url( 'optional-care' ) )
	: restwell_nav_resolve_page_url( 'optional-care' );

$home_faq_label   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'home_faq_label', __( 'Quick answers', 'restwell-retreats' ) )
	: __( 'Quick answers', 'restwell-retreats' );
$home_faq_heading = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'home_faq_heading', __( 'The questions that stop an enquiry', 'restwell-retreats' ) )
	: __( 'The questions that stop an enquiry', 'restwell-retreats' );

$partners     = function_exists( 'restwell_get_homepage_partners' )
	? restwell_get_homepage_partners( $home_id )
	: array();
$testimonials = function_exists( 'restwell_get_homepage_testimonials' )
	? restwell_get_homepage_testimonials( $home_id )
	: array(
		'label'     => 'What guests say',
		'heading'   => 'What guests wrote after staying',
		'fallbacks' => array(),
	);
?>


<main id="main-content">
<section class="hero hero--overlay-heavy" aria-labelledby="hero-h">
	  <div class="hero__media">
		<img
		  class="hero__media-img"
		  src="<?php echo esc_url( $hero_src ); ?>"
		  alt="<?php echo esc_attr( $hero_alt ); ?>"
		  width="1920"
		  height="1080"
		  decoding="async"
		  fetchpriority="high"
		/>
	  </div>
	  <div class="container">
		<div class="hero__content">
		  <div class="hero__text">
			<h1 id="hero-h"><?php echo esc_html( $hero_heading ); ?></h1>
			<?php if ( '' !== trim( (string) $hero_intro ) ) : ?>
			<p class="hero__sub"><?php echo esc_html( $hero_intro ); ?></p>
			<?php endif; ?>
		  </div>
		  <div class="hero__ctas">
			<a class="btn btn-gold" href="<?php echo esc_url( $hero_cta_primary_url ); ?>"><?php echo esc_html( $hero_cta_primary_label ); ?></a>
			<a class="btn btn-outline-light" href="<?php echo esc_url( $hero_cta_secondary_url ); ?>"><?php echo esc_html( $hero_cta_secondary_label ); ?></a>
		  </div>
		  <?php if ( '' !== trim( (string) $hero_cta_note ) ) : ?>
		  <p class="hero__note"><?php echo esc_html( $hero_cta_note ); ?></p>
		  <?php endif; ?>
		</div>
	  </div>
	</section>

	<section class="facts-strip band-subtle" aria-label="<?php esc_attr_e( 'The bungalow at a glance', 'restwell-retreats' ); ?>">
	  <div class="container">
		<ul class="facts-strip__list" role="list">
		  <li>
			<span class="icon-circle" aria-hidden="true"><svg viewBox="0 0 48 48" focusable="false"><path d="M5 23 24 7l19 16M10 20v21h28V20M20 41V29h8v12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
			<span><?php esc_html_e( 'Private, single-storey house', 'restwell-retreats' ); ?></span>
		  </li>
		  <li>
			<span class="icon-circle" aria-hidden="true"><svg viewBox="0 0 48 48" focusable="false" fill="currentColor"><path d="M47,46H46V40.21c1.23-1.12,1-1.89,1-6.21a3.51,3.51,0,0,0-1.06-2.34l-3-8.37A5,5,0,0,0,38.2,20H23.8a5,5,0,0,0-4.7,3.29l-3,8.37A3.53,3.53,0,0,0,15,34c0,3.85-.31,5,1,6.21V46H12V22h3a3,3,0,0,0,3-3V3a3,3,0,0,0-3-3H3A3,3,0,0,0,0,3V19a3,3,0,0,0,3,3H6V46H1a1,1,0,0,0,0,2H47A1,1,0,0,0,47,46Zm-9-3v3H24V43ZM20.67,41c-.46,0-.39,0-3.27-2.2-.57-.43-.4-.76-.4-4.8a1,1,0,0,1,1-1H44a1,1,0,0,1,1,1v4c0,.66-.25.68-3.07,2.8a1,1,0,0,1-.6.2ZM21,24a3,3,0,0,1,2.82-2H38.2A3,3,0,0,1,41,24l2.55,7H35.41l2.3-2.29a1,1,0,0,0-1.42-1.42L32.59,31H27.41l2.3-2.29a1,1,0,0,0-1.42-1.42L24.59,31H18.43ZM2,19V3A1,1,0,0,1,3,2H15a1,1,0,0,1,1,1V19a1,1,0,0,1-1,1H3A1,1,0,0,1,2,19ZM8,46V22h2V46Zm10,0V41.75C19.68,43,19.5,43,22,43v3Zm22,0V43c2.27,0,2.16.13,4-1.25V46Z"/><path d="M7,12H9.5a3.5,3.5,0,0,0,0-7H6A1,1,0,0,0,5,6V16a1,1,0,0,0,2,0ZM7,7H9.5a1.5,1.5,0,0,1,0,3H7Z"/><path d="M24,35H22a2,2,0,0,0,0,4h2a2,2,0,0,0,0-4Z"/><path d="M42,37a2,2,0,0,0-2-2H38a2,2,0,0,0,0,4h2A2,2,0,0,0,42,37Z"/><path d="M33,35H29a1,1,0,0,0,0,2h4A1,1,0,0,0,33,35Z"/><path d="M33,38H29a1,1,0,0,0,0,2h4A1,1,0,0,0,33,38Z"/></svg></span>
			<span><?php esc_html_e( 'Driveway parking for two', 'restwell-retreats' ); ?></span>
		  </li>
		  <li>
			<span class="icon-circle" aria-hidden="true"><svg viewBox="0 0 48 48" focusable="false" fill="currentColor"><path d="M2,16H16a1,1,0,0,0,1-1V1a1,1,0,0,0-1-1H2A1,1,0,0,0,1,1V15A1,1,0,0,0,2,16ZM3,2H15V14H3Z"/><path d="M7.71,7.71l2-2A1,1,0,0,0,8.29,4.29l-2,2A1,1,0,0,0,7.71,7.71Z"/><path d="M9.29,8.29l-2,2a1,1,0,0,0,1.42,1.42l2-2A1,1,0,0,0,9.29,8.29Z"/><path d="M46,28h1a1,1,0,0,0,0-2H46V20h1a1,1,0,0,0,0-2H46V7a5,5,0,0,0-5-5H37a5,5,0,0,0-5,5V9H29.06A3.06,3.06,0,0,0,26,12.06V14a1,1,0,0,0,1,1H39a1,1,0,0,0,1-1V12.06A3.06,3.06,0,0,0,36.94,9H34V7a3,3,0,0,1,3-3h4a3,3,0,0,1,3,3V33H42V32a1,1,0,0,0-2,0v4a1,1,0,0,0,2,0V35h2V46H12V34h1a3,3,0,0,0,3-3V30h1a1,1,0,0,0,1-1V25a1,1,0,0,0-1-1H10V20.5a2.5,2.5,0,0,0-5,0V21a1,1,0,0,0,2,0v-.5a.5.5,0,0,1,1,0V24H1a1,1,0,0,0-1,1v4a1,1,0,0,0,1,1H2v1a3,3,0,0,0,3,3H6V46H1a1,1,0,0,0,0,2H47a1,1,0,0,0,0-2H46ZM38,12.06V13H28v-.94A1.07,1.07,0,0,1,29.06,11h7.88A1.07,1.07,0,0,1,38,12.06ZM2,26H16v2H2Zm2,5V30H14v1a1,1,0,0,1-1,1H5A1,1,0,0,1,4,31ZM8,46V34h2V46Z"/><path d="M29,19a1,1,0,0,0,0-2A1,1,0,0,0,29,19Z"/><path d="M33,19a1,1,0,0,0,0-2A1,1,0,0,0,33,19Z"/><path d="M29,23a1,1,0,0,0,0-2A1,1,0,0,0,29,23Z"/><path d="M33,23a1,1,0,0,0,0-2A1,1,0,0,0,33,23Z"/><path d="M29,27a1,1,0,0,0,0-2A1,1,0,0,0,29,27Z"/><path d="M33,27a1,1,0,0,0,0-2A1,1,0,0,0,33,27Z"/><path d="M29,31a1,1,0,0,0,0-2A1,1,0,0,0,29,31Z"/><path d="M33,31a1,1,0,0,0,0-2A1,1,0,0,0,33,31Z"/><path d="M37,19a1,1,0,0,0,0-2A1,1,0,0,0,37,19Z"/><path d="M37,23a1,1,0,0,0,0-2A1,1,0,0,0,37,23Z"/><path d="M37,27a1,1,0,0,0,0-2A1,1,0,0,0,37,27Z"/><path d="M37,31a1,1,0,0,0,0-2A1,1,0,0,0,37,31Z"/></svg></span>
			<span><?php esc_html_e( 'Level-access wet room', 'restwell-retreats' ); ?></span>
		  </li>
		  <li>
			<span class="icon-circle" aria-hidden="true"><svg viewBox="0 0 48 48" focusable="false"><path d="M5 7h38M24 7v4M17 11h14v7H17zM24 18v5M14 23h20M15 23l2.6 14c.2 1.1 1.2 1.9 2.3 1.9h8.2c1.1 0 2.1-.8 2.3-1.9L33 23" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><circle cx="24" cy="29.5" r="3" fill="none" stroke="currentColor" stroke-width="2"/></svg></span>
			<span><?php esc_html_e( 'Ceiling track hoist', 'restwell-retreats' ); ?></span>
		  </li>
		</ul>
	  </div>
	</section>

	<section class="property section-y" id="property" aria-labelledby="property-h">
	  <div class="container">
		<div class="property__layout">
		  <div class="property__copy">
			<?php if ( '' !== $property_label ) : ?>
			<p class="eyebrow"><?php echo esc_html( $property_label ); ?></p>
			<?php endif; ?>
			<h2 id="property-h"><?php echo esc_html( $property_heading ); ?></h2>
			<p class="lede"><?php echo esc_html( $property_body ); ?></p>
			<div class="property__cta-row">
			  <a class="btn btn-gold" href="<?php echo esc_url( $property_cta_url ); ?>"><?php echo esc_html( $property_cta_label ); ?></a>
			  <a class="btn btn-outline-teal" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'accessibility' ) ); ?>"><?php esc_html_e( 'Door widths and the hoist', 'restwell-retreats' ); ?></a>
			</div>
		  </div>
		  <div class="property__media-wrap">
			<img class="property__media" src="<?php echo esc_url( $property_image_url ); ?>" alt="<?php echo esc_attr( $property_image_alt ); ?>" width="640" height="480" loading="lazy" decoding="async" />
		  </div>
		</div>
	  </div>
	</section>

	<section class="gallery section-y band-subtle" aria-labelledby="gallery-h" data-gallery>
	  <div class="container">
		<header class="section-head section-head--tight">
		  <p class="eyebrow">Inside the property</p>
		  <h2 id="gallery-h">Living room, bedroom and wet room</h2>
		  <button type="button" class="text-link" data-gallery-open data-gallery-index="0">View photos</button>
		</header>
		<ul class="gallery__grid" role="list" aria-label="Property photo preview">
		  <li class="gallery__item">
			<button type="button" class="gallery__open" data-gallery-open data-gallery-index="0" aria-label="View full size: Open-plan living room with wide, step-free walkways between furniture">
			  <?php /* Mosaic images load eagerly (no loading=lazy): the mosaic sits ~1 screen down and lazy-decode left a beige placeholder flash on scroll. Hero keeps LCP priority (design-audit c9). */ ?>
			  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/living-room-2.png' ) ); ?>" alt="Open-plan living room with wide, step-free walkways between furniture" width="640" height="480" sizes="(max-width: 767px) 84vw, 660px" decoding="async" />
			</button>
		  </li>
		  <li class="gallery__item">
			<button type="button" class="gallery__open" data-gallery-open data-gallery-index="1" aria-label="View full size: Accessible bedroom with ceiling track and mobile hoist">
			  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/BD2-3-LS.jpg' ) ); ?>" alt="Accessible bedroom with ceiling track and mobile hoist" width="640" height="480" sizes="(max-width: 767px) 41vw, 460px" decoding="async" />
			</button>
		  </li>
		  <li class="gallery__item">
			<button type="button" class="gallery__open" data-gallery-open data-gallery-index="2" aria-label="View full size: Level-access wet room shower with grab rails and fold-down seat">
			  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/wet-room-shower.png' ) ); ?>" alt="Level-access wet room shower with grab rails and fold-down seat" width="640" height="480" sizes="(max-width: 767px) 41vw, 460px" decoding="async" />
			</button>
		  </li>
		</ul>
	  </div>
	</section>

	<?php
	/* Paths, partners, and equal-weight comparison cards cut (design-audit P1):
	   they diluted USPs before proof. Whitstable/funding live on their pages;
	   partners belong on Our Story; kit proof stays in property + gallery. */
	?>

	<?php
	// Reviews: live Google reviews when Places API is configured, otherwise
	// Page content → Testimonials (verbatim guest words). Hardcoded fallbacks
	// in restwell_homepage_testimonial_hard_fallbacks() if the tab is empty.
	get_template_part(
		'template-parts/google-reviews',
		null,
		array(
			'fallbacks' => $testimonials['fallbacks'],
			'label'     => $testimonials['label'],
			'heading'   => $testimonials['heading'],
		)
	);
	?>

	<section class="care care--tease section-y band-white" id="care" aria-labelledby="care-h">
	  <div class="container">
		<div class="care__tease">
		  <?php if ( '' !== $home_care_label ) : ?>
		  <p class="eyebrow"><?php echo esc_html( $home_care_label ); ?></p>
		  <?php endif; ?>
		  <h2 id="care-h"><?php echo esc_html( $home_care_heading ); ?></h2>
		  <p class="lede"><?php echo esc_html( $home_care_intro ); ?></p>
		  <?php // The intro ends "whichever you choose:", so the two choices follow it (audit I08). ?>
		  <ul class="care__types" role="list">
			<?php foreach ( array( array( $home_care_item1_title, $home_care_item1_body ), array( $home_care_item2_title, $home_care_item2_body ) ) as $home_care_item ) : ?>
				<?php if ( '' !== trim( $home_care_item[0] ) ) : ?>
			<li>
			  <span class="care__type-title"><?php echo esc_html( $home_care_item[0] ); ?></span>
			  <span class="care__type-text"><?php echo esc_html( $home_care_item[1] ); ?></span>
			</li>
				<?php endif; ?>
			<?php endforeach; ?>
		  </ul>
		  <?php if ( '' !== $home_care_cta_label && '' !== $home_care_cta_url ) : ?>
		  <a class="text-link" href="<?php echo esc_url( $home_care_cta_url ); ?>"><?php echo esc_html( $home_care_cta_label ); ?></a>
		  <?php endif; ?>
		</div>
	  </div>
	</section>

	<?php
	$home_faq_items = function_exists( 'restwell_get_faq_items' ) ? restwell_get_faq_items( 'homepage' ) : array();
	$home_faq_col   = array();
	foreach ( $home_faq_items as $home_faq_i => $home_faq_item ) {
		$home_faq_item['open'] = ( 0 === (int) $home_faq_i );
		$home_faq_col[]       = $home_faq_item;
	}
	?>
	<section class="faq section-y band-subtle" id="faq" aria-labelledby="faq-h">
	  <div class="container">
		<div class="faq__layout">
		  <header class="faq__intro">
			<?php if ( '' !== $home_faq_label ) : ?>
			<p class="eyebrow"><?php echo esc_html( $home_faq_label ); ?></p>
			<?php endif; ?>
			<h2 id="faq-h"><?php echo esc_html( $home_faq_heading ); ?></h2>
		  </header>
		  <?php
			get_template_part(
				'template-parts/faq-accordion',
				null,
				array(
					'id_prefix' => 'home-q',
					'columns'   => array( $home_faq_col ),
				)
			);
			?>
		  <aside class="faq-cta" aria-label="More questions">
			<a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'faq' ) ); ?>">Browse the FAQ</a>
		  </aside>
		</div>
	  </div>
	</section>

	<?php
	get_template_part(
		'template-parts/mid-cta',
		null,
		array(
			'section_id'      => 'enquire',
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
