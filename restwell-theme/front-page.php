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
	? restwell_page_content_text( $home_id, 'hero_heading', 'An accessible bungalow by the sea, at your own pace' )
	: 'An accessible bungalow by the sea, at your own pace';
$hero_intro   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text(
		$home_id,
		'hero_subheading',
		'Restwell is one private adapted bungalow by the sea in Whitstable, and the whole house is yours for the stay. It’s single-storey and step-free, with a level-access wet room and a ceiling track hoist over the profiling bed. It isn’t a care home, and it isn’t a respite centre.'
	)
	: 'Restwell is one private adapted bungalow by the sea in Whitstable, and the whole house is yours for the stay. It’s single-storey and step-free, with a level-access wet room and a ceiling track hoist over the profiling bed. It isn’t a care home, and it isn’t a respite centre.';

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
<section class="hero" aria-labelledby="hero-h">
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
			<p><?php echo esc_html( $hero_intro ); ?></p>
		  </div>
		  <div class="hero__ctas">
			<a class="btn btn-gold" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'enquire' ) ); ?>">Get in touch</a>
			<a class="btn btn-outline-light" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'the-property' ) ); ?>">Look inside the bungalow</a>
		  </div>
		  <p class="hero__note">We aim to reply within 48 hours, and there’s no deposit until you’ve decided the house fits.</p>
		  <p class="hero__scroll-hint">
			<a class="hero__scroll-link" href="#property">
			  <span>Take a look inside</span>
			  <svg class="hero__scroll-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
				<path d="M5 9l7 7 7-7" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"/>
			  </svg>
			</a>
		  </p>
		</div>
	  </div>
	</section>

	<section class="property section-y" id="property" aria-labelledby="property-h">
	  <div class="container">
		<div class="property__layout">
		  <div class="property__media-wrap">
			<img class="property__media" src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/EX-1-LS.jpg' ) ); ?>" alt="Restwell bungalow exterior in Whitstable" width="640" height="480" loading="lazy" decoding="async" />
		  </div>
		  <div class="property__copy">
			<p class="eyebrow">The bungalow</p>
			<h2 id="property-h">One bungalow, and it’s all yours</h2>
			<p class="lede">It sits on a quiet residential street in Whitstable, about ten minutes from the seafront. The driveway is private and level, takes two cars including an adapted vehicle, and the front door is straight ahead of you when you park. We’ll send you the address once your stay is confirmed.</p>
			<ul class="property__facts">
			  <li>Private, single-storey house</li>
			  <li>Driveway parking for two</li>
			  <li>Level-access wet room</li>
			</ul>
			<div class="property__cta-row">
			  <a class="btn btn-gold" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'the-property' ) ); ?>">Have a proper look round the rooms</a>
			  <a class="btn btn-outline-teal" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'accessibility' ) ); ?>">Door widths, the wet room and the hoist</a>
			</div>
		  </div>
		</div>
	  </div>
	</section>

	<section class="gallery section-y" aria-labelledby="gallery-h" data-gallery>
	  <div class="container">
		<header class="section-head section-head--center section-head--tight">
		  <p class="eyebrow">Inside the property</p>
		  <h2 id="gallery-h">Living room, bedroom and wet room</h2>
		  <button type="button" class="text-link" data-gallery-open data-gallery-index="0">View photos</button>
		</header>
		<ul class="gallery__grid" role="list" aria-label="Property photo preview">
		  <li class="gallery__item">
			<button type="button" class="gallery__open" data-gallery-open data-gallery-index="0" aria-label="View full size: Open-plan living room with wide, step-free walkways between furniture">
			  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/living-room-2.png' ) ); ?>" alt="Open-plan living room with wide, step-free walkways between furniture" width="640" height="480" loading="lazy" decoding="async" />
			</button>
		  </li>
		  <li class="gallery__item">
			<button type="button" class="gallery__open" data-gallery-open data-gallery-index="1" aria-label="View full size: Accessible bedroom with ceiling track and mobile hoist">
			  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/BD2-3-LS.jpg' ) ); ?>" alt="Accessible bedroom with ceiling track and mobile hoist" width="640" height="480" loading="lazy" decoding="async" />
			</button>
		  </li>
		  <li class="gallery__item">
			<button type="button" class="gallery__open" data-gallery-open data-gallery-index="2" aria-label="View full size: Level-access wet room shower with grab rails and fold-down seat">
			  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/wet-room-shower.png' ) ); ?>" alt="Level-access wet room shower with grab rails and fold-down seat" width="640" height="480" loading="lazy" decoding="async" />
			</button>
		  </li>
		</ul>
	  </div>
	</section>

	<section class="paths section-y" id="paths" aria-labelledby="paths-h">
	  <div class="container">
		<header class="section-head">
		  <h2 id="paths-h">Plan a day, or a way to pay</h2>
		  <p class="lede">The harbour beach is shingle. Tankerton promenade is the level stretch. If a funder might help with the cost, we can invoice whoever you name.</p>
		</header>
		<div class="paths__grid">
		  <article class="path-card path-card--area">
			<h3>Whitstable and Tankerton</h3>
			<p>Surfaces, parking, and which places have an accessible loo, including the ones that don’t.</p>
			<a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'whitstable-area-guide' ) ); ?>">Days out from the bungalow</a>
		  </article>
		  <article class="path-card path-card--funding">
			<h3>Who we can invoice</h3>
			<p>You, a council, the NHS or a grant body. The bungalow rate is the same either way. We can’t promise your package will cover it.</p>
			<a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'resources' ) ); ?>">Funding an accessible holiday</a>
		  </article>
		</div>
	  </div>
	</section>

	<?php if ( ! empty( $partners['heading'] ) && ! empty( $partners['items'] ) ) : ?>
	<section class="partners section-y" id="partners" aria-labelledby="partners-h">
	  <div class="container">
		<header class="section-head partners__head">
		  <?php if ( '' !== $partners['label'] ) : ?>
		  <p class="eyebrow"><?php echo esc_html( $partners['label'] ); ?></p>
		  <?php endif; ?>
		  <h2 id="partners-h"><?php echo esc_html( $partners['heading'] ); ?></h2>
		  <p class="lede"><?php echo esc_html( $partners['intro'] ); ?>
		  <?php
			if ( '' !== $partners['cta_text'] && '' !== $partners['cta_url'] ) :
				?>
				<a class="text-link" href="<?php echo esc_url( $partners['cta_url'] ); ?>"><?php echo esc_html( $partners['cta_text'] ); ?></a>.<?php endif; ?></p>
		</header>
		<ul class="partners__grid" role="list">
		  <?php foreach ( $partners['items'] as $partner ) : ?>
		  <li class="partners__item">
			<a class="partners__link" href="<?php echo esc_url( $partner['url'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( sprintf( /* translators: %s: partner name */ __( '%s (opens in a new tab)', 'restwell-retreats' ), $partner['name'] ) ); ?>">
			  <img src="<?php echo esc_url( $partner['img'] ); ?>" alt="<?php echo esc_attr( $partner['alt'] ); ?>" width="180" height="72" loading="lazy" decoding="async" />
			</a>
		  </li>
		  <?php endforeach; ?>
		</ul>
	  </div>
	</section>
	<?php endif; ?>

	<section class="comparison section-y" id="comparison" aria-labelledby="comparison-h">
	  <div class="container">
		<header class="section-head section-head--center">
		  <h2 id="comparison-h">A wet room in a hotel still comes with the corridor</h2>
		</header>
		<ul class="card-grid card-grid--3" role="list">
		  <li>
			<article class="info-card">
			  <span class="icon-circle" aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false"><path d="M7 3.5h6l4 4V20a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4.5a1 1 0 0 1 1-1z" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M13 3.5V8h4" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M9 13.5l2 2 4-4.5" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
			  <h3>One level, from driveway to garden</h3>
			  <p>No lift to queue for, no corridor to share. The linen is already on the beds.</p>
			</article>
		  </li>
		  <li>
			<article class="info-card">
			  <span class="icon-circle" aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false"><rect x="7" y="3" width="10" height="18" rx="1" fill="none" stroke="currentColor" stroke-width="1.6"/><path d="M14 12h.01" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg></span>
			  <h3>Only the people you came with</h3>
			  <p>The whole bungalow is yours. Nobody is going to knock unless you’ve asked them to.</p>
			</article>
		  </li>
		  <li>
			<article class="info-card">
			  <span class="icon-circle" aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false"><path d="M12 20s-7-4.4-9.5-9A5 5 0 0 1 12 6a5 5 0 0 1 9.5 5c-2.5 4.6-9.5 9-9.5 9z" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg></span>
			  <h3>Heating you can reach</h3>
			  <p>Controls are within reach from a seated position, so you set the temperature yourself.</p>
			</article>
		  </li>
		</ul>
	  </div>
	</section>

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

	<section class="care section-y" id="care" aria-labelledby="care-h">
	  <div class="container">
		<div class="care__panel">
		  <div class="care__intro">
			<header class="section-head">
			  <p class="eyebrow">If you need support while you stay</p>
			  <h2 id="care-h">Yes if you want it, and no, you don’t have to</h2>
			</header>
			<div class="care__intro-body">
			  <p class="lede">Plenty of guests bring their own person, or simply manage the way they do at home, and that’s completely fine. If you would like professional home care, Continuity of Care Services can come to you. They’re our sister company, they already know this house, and they’re rated Good by the CQC. One conversation covers both.</p>
			</div>
		  </div>
		  <div class="care__foot">
			<div class="care__foot-copy">
			  <p class="care__note">The bungalow rate stays exactly the same. Ring 01622 809881 if that’s easier than a form.</p>
			  <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'optional-care' ) ); ?>">What home care here actually looks like</a>
			</div>
			<div class="care__brand" aria-label="Sister company and CQC rating">
			  <a class="care__brand-link care__brand-link--ccs" href="https://www.continuitycareservices.co.uk/" target="_blank" rel="noopener noreferrer" aria-label="Continuity of Care Services (opens in a new tab)">
				<img src="<?php echo esc_url( restwell_theme_image_url( 'partners/continuity-of-care-services-long.png' ) ); ?>" alt="<?php echo esc_attr( restwell_theme_image_alt( 'partners/continuity-of-care-services-long.png' ) ); ?>" width="405" height="69" loading="lazy" decoding="async" />
			  </a>
			  <a class="care__brand-link care__brand-link--cqc" href="https://www.cqc.org.uk/location/1-2624556588" target="_blank" rel="noopener noreferrer" aria-label="CQC rating Good, Continuity of Care Services (opens in a new tab)">
				<img src="<?php echo esc_url( restwell_theme_image_url( 'partners/cqc-rating-good.jpg' ) ); ?>" alt="<?php echo esc_attr( restwell_theme_image_alt( 'partners/cqc-rating-good.jpg' ) ); ?>" width="710" height="399" loading="lazy" decoding="async" />
			  </a>
			</div>
		  </div>
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
	<section class="faq section-y" id="faq" aria-labelledby="faq-h">
	  <div class="container">
		<div class="faq__layout">
		  <header class="faq__intro">
			<p class="eyebrow">Quick answers</p>
			<h2 id="faq-h">The questions that stop an enquiry</h2>
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

	<section class="mid-cta mid-cta--plain section-y--cta" id="enquire" aria-labelledby="mid-cta-h">
	  <div class="mid-cta__media" aria-hidden="true"></div>
	  <div class="mid-cta__inner">
		<h2 id="mid-cta-h">Ask us anything about a stay</h2>
		<p>There’s no deposit until you’ve decided the house fits. We aim to reply within 48 hours.</p>
		<div class="mid-cta__btns">
		  <a class="btn btn-gold" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'enquire' ) ); ?>">Get in touch</a>
		  <a class="btn btn-outline-light" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'the-property' ) ); ?>">Look inside the bungalow</a>
		</div>
	  </div>
	</section>

</main>

<?php
get_footer();
