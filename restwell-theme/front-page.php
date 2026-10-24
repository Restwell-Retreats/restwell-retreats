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
	? restwell_page_content_text( $home_id, 'hero_heading', 'Accessible holiday cottage in Kent' )
	: 'Accessible holiday cottage in Kent';
$hero_intro   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text(
		$home_id,
		'hero_subheading',
		'A private, single-storey bungalow in Kent, a short walk from the sea. The level wet room and ceiling track hoist are already fitted. Home care from our sister company is there if you’d like it.'
	)
	: 'A private, single-storey bungalow in Kent, a short walk from the sea. The level wet room and ceiling track hoist are already fitted. Home care from our sister company is there if you’d like it.';

$hero_cta_primary_label = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'hero_cta_primary_label', __( 'Enquire', 'restwell-retreats' ) )
	: __( 'Enquire', 'restwell-retreats' );
$hero_cta_primary_url   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'hero_cta_primary_url', restwell_nav_resolve_page_url( 'enquire' ) )
	: restwell_nav_resolve_page_url( 'enquire' );
$hero_cta_secondary_label = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'hero_cta_secondary_label', __( 'Look inside', 'restwell-retreats' ) )
	: __( 'Look inside', 'restwell-retreats' );
$hero_cta_secondary_url   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'hero_cta_secondary_url', restwell_nav_resolve_page_url( 'the-property' ) )
	: restwell_nav_resolve_page_url( 'the-property' );
$property_label   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'property_label', __( 'The bungalow', 'restwell-retreats' ) )
	: __( 'The bungalow', 'restwell-retreats' );
$property_heading = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'property_heading', __( 'A private bungalow that sleeps five', 'restwell-retreats' ) )
	: __( 'A private bungalow that sleeps five', 'restwell-retreats' );
$property_body    = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text(
		$home_id,
		'property_body',
		__( "It sits on a quiet residential street in Whitstable, about ten minutes from the seafront. The driveway is private and level. It takes two cars, including an adapted vehicle, and the front door is straight ahead when you park.\n\nInside there are two bedrooms and a double sofa bed in the conservatory, so up to five can stay. You can book from a single night, and we’ll set the bedroom up for you. We’ll send the address once your stay is confirmed.", 'restwell-retreats' )
	)
	: __( "It sits on a quiet residential street in Whitstable, about ten minutes from the seafront. The driveway is private and level. It takes two cars, including an adapted vehicle, and the front door is straight ahead when you park.\n\nInside there are two bedrooms and a double sofa bed in the conservatory, so up to five can stay. You can book from a single night, and we’ll set the bedroom up for you. We’ll send the address once your stay is confirmed.", 'restwell-retreats' );
$property_cta_label = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'property_cta_label', __( 'See the rooms', 'restwell-retreats' ) )
	: __( 'See the rooms', 'restwell-retreats' );
$property_cta_url   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'property_cta_url', restwell_nav_resolve_page_url( 'the-property' ) )
	: restwell_nav_resolve_page_url( 'the-property' );
// Restwell's first guests at the house (13 Oct 2026; the owner confirmed consent).
// Until then no photo on the site showed anyone staying here.
$property_image_url = restwell_theme_image_url( 'journey/restwell-first-guests.webp' );
$property_image_alt = 'Restwell’s first guests outside the conservatory, one in a wheelchair';
$property_image_w   = 1200;
$property_image_h   = 1600;
if ( $home_id > 0 && function_exists( 'restwell_page_content_meta_or_default' ) ) {
	$property_image_id = absint( restwell_page_content_meta_or_default( $home_id, 'property_image_id' ) );
	if ( $property_image_id > 0 ) {
		$picked = function_exists( 'restwell_pick_attachment_size' )
			? restwell_pick_attachment_size( $property_image_id, 'restwell-property', 'large' )
			: 'large';
		$src    = wp_get_attachment_image_src( $property_image_id, $picked );
		if ( $src && ! empty( $src[0] ) ) {
			$property_image_url = $src[0];
			$property_image_w   = (int) $src[1];
			$property_image_h   = (int) $src[2];
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
		__( 'Tell us your dates and what you need from the house, and we’ll aim to reply within 48 hours. There’s no deposit to pay until we’ve talked it through and you’re happy it fits.', 'restwell-retreats' )
	)
	: __( 'Tell us your dates and what you need from the house, and we’ll aim to reply within 48 hours. There’s no deposit to pay until we’ve talked it through and you’re happy it fits.', 'restwell-retreats' );
$mid_cta_primary_label = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'cta_primary_label', __( 'Enquire', 'restwell-retreats' ) )
	: __( 'Enquire', 'restwell-retreats' );
$mid_cta_primary_url   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'cta_primary_url', restwell_nav_resolve_page_url( 'enquire' ) )
	: restwell_nav_resolve_page_url( 'enquire' );
$mid_cta_secondary_label = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'cta_secondary_label', __( 'Look inside', 'restwell-retreats' ) )
	: __( 'Look inside', 'restwell-retreats' );
$mid_cta_secondary_url   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'cta_secondary_url', restwell_nav_resolve_page_url( 'the-property' ) )
	: restwell_nav_resolve_page_url( 'the-property' );

$home_care_label   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'home_care_label', '' )
	: '';
$home_care_heading = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'home_care_heading', __( 'Home care from our sister company', 'restwell-retreats' ) )
	: __( 'Home care from our sister company', 'restwell-retreats' );
$home_care_intro   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text(
		$home_id,
		'home_care_intro',
		__( 'How you handle care on holiday is up to you, and most guests do one of two things.', 'restwell-retreats' )
	)
	: __( 'How you handle care on holiday is up to you, and most guests do one of two things.', 'restwell-retreats' );
$home_care_item1_title = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'home_care_item1_title', __( 'Bring your own support', 'restwell-retreats' ) )
	: __( 'Bring your own support', 'restwell-retreats' );
$home_care_item1_body  = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'home_care_item1_body', __( 'Plenty of guests bring their own carer or PA, or manage the way they do at home. The second bedroom gives a carer somewhere proper to sleep.', 'restwell-retreats' ) )
	: __( 'Plenty of guests bring their own carer or PA, or manage the way they do at home. The second bedroom gives a carer somewhere proper to sleep.', 'restwell-retreats' );
$home_care_item2_title = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'home_care_item2_title', __( 'Add care from Continuity', 'restwell-retreats' ) )
	: __( 'Add care from Continuity', 'restwell-retreats' );
$home_care_item2_body  = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text(
		$home_id,
		'home_care_item2_body',
		__( 'Our sister company, Continuity of Care Services, can come into the bungalow while you’re here. They’re rated Good by the CQC. We share an office and a phone number, so one call covers the house and the care.', 'restwell-retreats' )
	)
	: __( 'Our sister company, Continuity of Care Services, can come into the bungalow while you’re here. They’re rated Good by the CQC. We share an office and a phone number, so one call covers the house and the care.', 'restwell-retreats' );
$home_care_note      = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'home_care_note', __( 'Ring 01622 809881 if that’s easier than a form.', 'restwell-retreats' ) )
	: __( 'Ring 01622 809881 if that’s easier than a form.', 'restwell-retreats' );
$home_care_cta_label = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'home_care_cta_label', __( 'How home care works', 'restwell-retreats' ) )
	: __( 'How home care works', 'restwell-retreats' );
$home_care_cta_url   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'home_care_cta_url', restwell_nav_resolve_page_url( 'optional-care' ) )
	: restwell_nav_resolve_page_url( 'optional-care' );

$home_faq_label   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'home_faq_label', __( 'Quick answers', 'restwell-retreats' ) )
	: __( 'Quick answers', 'restwell-retreats' );
$home_faq_heading = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $home_id, 'home_faq_heading', __( 'Common questions before booking', 'restwell-retreats' ) )
	: __( 'Common questions before booking', 'restwell-retreats' );

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
		</div>
	  </div>
	</section>

	<?php
	// At a glance (19 Oct 2026): four real photos, each with a label, rising
	// over the bottom edge of the hero. It replaced icons in circles. Facts as
	// in inc/property-facts.php; the gallery below uses different shots. Keep
	// the titles to one line and the four sub-lines the same length, so the
	// labels sit level across the row.
	$home_glance = array(
		array( 'bungalow/BD1-1-LS.jpg', 2400, 1500, __( 'Two bedrooms', 'restwell-retreats' ), __( 'Sleeps five, with a conservatory sofa bed', 'restwell-retreats' ) ),
		array( 'bungalow/FD-1-LS.jpg', 2400, 1500, __( 'Step-free entry', 'restwell-retreats' ), __( 'A 965mm front door off a level driveway', 'restwell-retreats' ) ),
		array( 'bungalow/WR-1-LS.jpg', 2400, 1500, __( 'Wet room', 'restwell-retreats' ), __( 'Level access, a shower chair and grab rails', 'restwell-retreats' ) ),
		array( 'bungalow/H-1-LS.jpg', 1920, 1200, __( 'Ceiling hoist', 'restwell-retreats' ), __( 'Rated to 180kg, over the profiling bed', 'restwell-retreats' ) ),
	);
	?>
	<section class="facts-strip band-subtle" aria-label="<?php esc_attr_e( 'The bungalow at a glance', 'restwell-retreats' ); ?>">
	  <div class="container">
		<ul class="facts-strip__list" role="list">
		  <?php foreach ( $home_glance as $glance ) : ?>
		  <li class="facts-strip__item">
			<img class="facts-strip__photo" src="<?php echo esc_url( restwell_theme_image_url( $glance[0] ) ); ?>" alt="" width="<?php echo (int) $glance[1]; ?>" height="<?php echo (int) $glance[2]; ?>" sizes="(min-width: 900px) 280px, 50vw" decoding="async" />
			<p class="facts-strip__text">
			  <span class="facts-strip__title"><?php echo esc_html( $glance[3] ); ?></span>
			  <span class="facts-strip__sub"><?php echo esc_html( $glance[4] ); ?></span>
			</p>
		  </li>
		  <?php endforeach; ?>
		</ul>
	  </div>
	</section>

	<?php
	// The bungalow (19 Oct 2026): the first-guests photo large on the left,
	// with a white panel overlapping its right edge that holds the words and
	// links. The copy comes first in the markup so it is read first; the grid
	// puts the photo on the left from 960px and above the panel on phones.
	// One button and one backup link, as in every section.
	?>
	<section class="property section-y" id="property" aria-labelledby="property-h">
	  <div class="container">
		<div class="property__layout">
		  <div class="property__copy">
			<?php if ( '' !== $property_label ) : ?>
			<p class="eyebrow"><?php echo esc_html( $property_label ); ?></p>
			<?php endif; ?>
			<h2 id="property-h"><?php echo esc_html( $property_heading ); ?></h2>
			<?php foreach ( preg_split( '/\n\s*\n/', trim( $property_body ) ) as $property_para ) : ?>
			<p class="lede"><?php echo esc_html( trim( $property_para ) ); ?></p>
			<?php endforeach; ?>
			<div class="property__cta-row">
			  <a class="btn btn-outline-teal" href="<?php echo esc_url( $property_cta_url ); ?>"><?php echo esc_html( $property_cta_label ); ?></a>
			  <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'pricing' ) ); ?>"><?php esc_html_e( 'Prices and dates', 'restwell-retreats' ); ?></a>
			</div>
		  </div>
		  <img class="property__photo" src="<?php echo esc_url( $property_image_url ); ?>" alt="<?php echo esc_attr( $property_image_alt ); ?>" width="<?php echo (int) $property_image_w; ?>" height="<?php echo (int) $property_image_h; ?>" sizes="(min-width: 960px) 760px, 100vw" loading="lazy" decoding="async" />
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
			<button type="button" class="gallery__open" data-gallery-open data-gallery-index="0" aria-label="View full size: The open-plan living room, with wide, clear walkways between the furniture">
			  <?php /* Mosaic images load eagerly (no loading=lazy): the mosaic sits ~1 screen down and lazy-decode left a beige placeholder flash on scroll. Hero keeps LCP priority (design-audit c9). */ ?>
			  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/living-room-2.png' ) ); ?>" alt="The open-plan living room, with wide, clear walkways between the furniture" width="640" height="480" sizes="(max-width: 767px) 84vw, 660px" decoding="async" />
			</button>
		  </li>
		  <li class="gallery__item">
			<button type="button" class="gallery__open" data-gallery-open data-gallery-index="1" aria-label="View full size: The accessible bedroom, with two profiling beds side by side">
			  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/BD2-2-LS.jpg' ) ); ?>" alt="The accessible bedroom, with two profiling beds side by side" width="2400" height="1500" sizes="(max-width: 767px) 41vw, 460px" decoding="async" />
			</button>
		  </li>
		  <li class="gallery__item">
			<button type="button" class="gallery__open" data-gallery-open data-gallery-index="2" aria-label="View full size: The level-access shower, with the tilt-in-space shower chair and a grab rail">
			  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/wet-room-shower.png' ) ); ?>" alt="The level-access shower, with the tilt-in-space shower chair and a grab rail" width="640" height="480" sizes="(max-width: 767px) 41vw, 460px" decoding="async" />
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

	<?php
	// Care, the two ways guests handle it (19 Oct 2026): a photo card of the
	// second bedroom for bringing your own carer, and a teal card with Keelie
	// and Nikki for care from Continuity. They replaced two text columns and
	// two small round faces. Photos of the team published with consent.
	$home_care_link = ( '' !== $home_care_cta_label && '' !== $home_care_cta_url )
		? '<a class="care-choice__link" href="' . esc_url( $home_care_cta_url ) . '">' . esc_html( $home_care_cta_label ) . ' <span aria-hidden="true">&rarr;</span></a>'
		: '';
	$home_care_team = array(
		array( 'journey/keelie-varney.webp', 1500, 'Keelie Varney' ),
		array( 'journey/nikki-mackay.webp', 1429, 'Nikki Mackay' ),
	);
	?>
	<section class="care care--tease section-y band-white" id="care" aria-labelledby="care-h">
	  <div class="container">
		<header class="section-head">
		  <?php if ( '' !== $home_care_label ) : ?>
		  <p class="eyebrow"><?php echo esc_html( $home_care_label ); ?></p>
		  <?php endif; ?>
		  <h2 id="care-h"><?php echo esc_html( $home_care_heading ); ?></h2>
		  <p class="lede"><?php echo esc_html( $home_care_intro ); ?></p>
		</header>
		<ul class="care-choices" role="list">
		  <?php if ( '' !== trim( $home_care_item1_title ) ) : ?>
		  <li class="care-choice care-choice--own">
			<img class="care-choice__photo" src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/BD1-1-LS.jpg' ) ); ?>" alt="" width="2400" height="1500" sizes="(min-width: 900px) 660px, 100vw" loading="lazy" decoding="async" />
			<div class="care-choice__text">
			  <h3><?php echo esc_html( $home_care_item1_title ); ?></h3>
			  <p><?php echo esc_html( $home_care_item1_body ); ?></p>
			</div>
		  </li>
		  <?php endif; ?>
		  <?php if ( '' !== trim( $home_care_item2_title ) ) : ?>
		  <li class="care-choice care-choice--continuity">
			<div class="care-choice__team">
				<?php foreach ( $home_care_team as $home_care_person ) : ?>
			  <figure>
				<img src="<?php echo esc_url( restwell_theme_image_url( $home_care_person[0] ) ); ?>" alt="" width="<?php echo (int) $home_care_person[1]; ?>" height="2000" sizes="(min-width: 900px) 210px, 42vw" loading="lazy" decoding="async" />
				<figcaption><?php echo esc_html( $home_care_person[2] ); ?></figcaption>
			  </figure>
				<?php endforeach; ?>
			</div>
			<div class="care-choice__text">
			  <h3><?php echo esc_html( $home_care_item2_title ); ?></h3>
			  <p><?php echo esc_html( $home_care_item2_body ); ?></p>
				<?php echo $home_care_link; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped when built above. ?>
			</div>
		  </li>
		  <?php elseif ( '' !== $home_care_link ) : ?>
		  <li class="care-choice care-choice--link"><?php echo $home_care_link; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped when built above. ?></li>
		  <?php endif; ?>
		</ul>
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
