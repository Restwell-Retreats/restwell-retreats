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
		'Your own accessible bungalow in Whitstable. A self-catering stay with optional care support, so you can plan with confidence.'
	)
	: 'Your own accessible bungalow in Whitstable. A self-catering stay with optional care support, so you can plan with confidence.';
?>


<main id="main-content">
<section class="hero" aria-labelledby="hero-h">
      <div class="hero__media" aria-hidden="true">
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
            <a class="btn btn-outline-light" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'the-property' ) ); ?>">See the bungalow</a>
          </div>
          <p class="hero__note">We aim to reply within 48 hours, and you’re under no obligation to book</p>
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
            <img class="property__media" src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/EX-1-LS.jpg' ) ); ?>" alt="Restwell bungalow exterior on Russell Drive" width="640" height="480" loading="lazy" decoding="async" />
          </div>
          <div class="property__copy">
            <p class="eyebrow">The Bungalow</p>
            <h2 id="property-h">The details, before you book</h2>
            <p class="lede">It’s not easy to find a private holiday house that actually works for a wheelchair and a care routine. Guests often tell us this one is worth the journey.</p>
            <p class="lede">Restwell is a bungalow on Russell Drive in Whitstable, about an hour from London. You have the whole house. Access measurements and kit notes are published before you book.</p>
            <ul class="property__facts">
              <li>Private, single-storey house</li>
              <li>Driveway parking</li>
              <li>Access details published before you book</li>
            </ul>
            <div class="property__cta-row">
              <a class="btn btn-gold" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'the-property' ) ); ?>">View the property</a>
              <a class="btn btn-outline-teal" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'accessibility' ) ); ?>">Read the access statement</a>
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
          <h2 id="paths-h">Plan your stay</h2>
          <p class="lede">Before you contact us, it helps to read about what it’s really like to get around the area and how funding could help with costs.</p>
        </header>
        <div class="paths__grid">
          <article class="path-card path-card--area">
            <h3>Whitstable and the Kent coast</h3>
            <p>Harbour, promenade, and day trips — with honest notes on what is actually workable, not just labelled that way.</p>
            <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'whitstable-area-guide' ) ); ?>">Whitstable access notes</a>
          </article>
          <article class="path-card path-card--funding">
            <h3>Ways to help fund your stay</h3>
            <p>Some stays are paid for through a funder. We can tell you who we invoice, and point you to the pathway guides.</p>
            <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'resources' ) ); ?>">Read funding guides</a>
          </article>
        </div>
      </div>
    </section>

    <section class="partners section-y" id="partners" aria-labelledby="partners-h">
      <div class="container">
        <header class="section-head partners__head">
          <p class="eyebrow">Behind Restwell</p>
          <h2 id="partners-h">Who built it, and who we work with</h2>
          <p class="lede">Specialist firms adapted the house. Continuity, our sister company, is who we’d put you in touch with for care — <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'our-story' ) ); ?>">read the full story</a>.</p>
        </header>
        <ul class="partners__grid" role="list">
          <li class="partners__item">
            <a class="partners__link" href="https://www.carespaces.co.uk/" target="_blank" rel="noopener noreferrer" aria-label="Care Spaces (opens in a new tab)">
              <img src="<?php echo esc_url( restwell_theme_image_url( 'partners/care-spaces.png' ) ); ?>" alt="<?php echo esc_attr( restwell_theme_image_alt( 'partners/care-spaces.png' ) ); ?>" width="180" height="72" loading="lazy" decoding="async" />
            </a>
          </li>
          <li class="partners__item">
            <a class="partners__link" href="https://thorcarpenter.co.uk/" target="_blank" rel="noopener noreferrer" aria-label="Thor Carpentry (opens in a new tab)">
              <img src="<?php echo esc_url( restwell_theme_image_url( 'partners/thor-carpentry.png' ) ); ?>" alt="<?php echo esc_attr( restwell_theme_image_alt( 'partners/thor-carpentry.png' ) ); ?>" width="180" height="72" loading="lazy" decoding="async" />
            </a>
          </li>
          <li class="partners__item">
            <a class="partners__link" href="https://wealdenrehab.com/" target="_blank" rel="noopener noreferrer" aria-label="Wealden Rehab (opens in a new tab)">
              <img src="<?php echo esc_url( restwell_theme_image_url( 'partners/wealden-rehab.png' ) ); ?>" alt="<?php echo esc_attr( restwell_theme_image_alt( 'partners/wealden-rehab.png' ) ); ?>" width="180" height="72" loading="lazy" decoding="async" />
            </a>
          </li>
          <li class="partners__item">
            <a class="partners__link" href="https://www.continuitycareservices.co.uk/" target="_blank" rel="noopener noreferrer" aria-label="Continuity of Care Services (opens in a new tab)">
              <img src="<?php echo esc_url( restwell_theme_image_url( 'partners/continuity-of-care-services.png' ) ); ?>" alt="<?php echo esc_attr( restwell_theme_image_alt( 'partners/continuity-of-care-services.png' ) ); ?>" width="180" height="72" loading="lazy" decoding="async" />
            </a>
          </li>
          <li class="partners__item">
            <a class="partners__link" href="https://www.continuitytrainingacademy.co.uk/" target="_blank" rel="noopener noreferrer" aria-label="Continuity Training Academy (opens in a new tab)">
              <img src="<?php echo esc_url( restwell_theme_image_url( 'partners/continuity-training-academy.png' ) ); ?>" alt="<?php echo esc_attr( restwell_theme_image_alt( 'partners/continuity-training-academy.png' ) ); ?>" width="180" height="72" loading="lazy" decoding="async" />
            </a>
          </li>
        </ul>
      </div>
    </section>

    <section class="comparison section-y" id="comparison" aria-labelledby="comparison-h">
      <div class="container">
        <header class="section-head section-head--center">
          <h2 id="comparison-h">Why families choose Restwell</h2>
        </header>
        <ul class="card-grid card-grid--3" role="list">
          <li>
            <article class="info-card">
              <span class="icon-circle" aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false"><path d="M7 3.5h6l4 4V20a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4.5a1 1 0 0 1 1-1z" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M13 3.5V8h4" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M9 13.5l2 2 4-4.5" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
              <h3>Access details published</h3>
              <p>Measurements and kit notes live on the access statement, before you book.</p>
            </article>
          </li>
          <li>
            <article class="info-card">
              <span class="icon-circle" aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false"><rect x="7" y="3" width="10" height="18" rx="1" fill="none" stroke="currentColor" stroke-width="1.6"/><path d="M14 12h.01" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg></span>
              <h3>A private bungalow, not a hotel corridor</h3>
              <p>Your group has the whole place to yourselves. There are no shared lifts, lobbies, or public spaces between the bedroom and wet room.</p>
            </article>
          </li>
          <li>
            <article class="info-card">
              <span class="icon-circle" aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false"><path d="M12 20s-7-4.4-9.5-9A5 5 0 0 1 12 6a5 5 0 0 1 9.5 5c-2.5 4.6-9.5 9-9.5 9z" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg></span>
              <h3>Optional care support</h3>
              <p>Continuity of Care Services can arrange CQC-regulated support during the same call as your booking, or, if you prefer, you can bring your own carer.</p>
            </article>
          </li>
        </ul>
      </div>
    </section>

    <section class="testimonials section-y" aria-labelledby="testimonials-h">
      <div class="container">
        <header class="section-head">
          <p class="eyebrow eyebrow--on-dark">What guests say</p>
          <h2 id="testimonials-h">What guests wrote after staying</h2>
        </header>
        <ul class="testimonials__grid" role="list">
          <li>
            <article class="testimonial-card">
              <blockquote class="testimonial-card__quote">Keelie was tremendously helpful in explaining all the facilities, equipment and care help they could provide. The bungalow is modern and spotless, fully equipped for both the person you are caring for, and for the carer. It was a home from home.</blockquote>
              <footer class="testimonial-card__name">M.H.<span class="testimonial-card__role">Family carer · Facebook review</span></footer>
            </article>
          </li>
          <li>
            <article class="testimonial-card">
              <blockquote class="testimonial-card__quote">From the minute I rolled my wheelchair out the car, I smiled. Widened hallways, ceiling track hoist, a wet room that should be in a gallery. With the complex care I need, this is worth its weight in gold.</blockquote>
              <footer class="testimonial-card__name">M.P.<span class="testimonial-card__role">Wheelchair user · Google review</span></footer>
            </article>
          </li>
          <li>
            <article class="testimonial-card">
              <blockquote class="testimonial-card__quote">The property is beautifully presented, exceptionally clean, well equipped, and in a fantastic location. One of the highlights was waking up to the sound of birds singing each morning and watching them from the garden while enjoying our breakfast. It was the perfect way to start the day.</blockquote>
              <footer class="testimonial-card__name">M.Z.<span class="testimonial-card__role">Guest · Google review</span></footer>
            </article>
          </li>
        </ul>
      </div>
    </section>

    <section class="care section-y" id="care" aria-labelledby="care-h">
      <div class="container">
        <div class="care__panel">
          <div class="care__intro">
            <header class="section-head">
              <p class="eyebrow">If you need support while you stay</p>
              <h2 id="care-h">Optional care during your stay</h2>
            </header>
            <div class="care__intro-body">
              <p class="lede">You book the bungalow with Restwell. Optional CQC-regulated support is arranged separately with Continuity of Care Services if you want it — never bundled into the house rate.</p>
            </div>
          </div>
          <div class="care__foot">
            <div class="care__foot-copy">
              <p class="care__note">Nothing is added to your stay until you agree the plan.</p>
              <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'optional-care' ) ); ?>">How optional care works</a>
            </div>
            <div class="care__brand" aria-label="Care partner and CQC rating">
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

    <section class="faq section-y" id="faq" aria-labelledby="faq-h">
      <div class="container">
        <div class="faq__layout">
          <header class="faq__intro">
            <p class="eyebrow">Quick answers</p>
            <h2 id="faq-h">Questions you might have</h2>
          </header>
          <div class="faq-list" data-faq-accordion>
            <div class="faq-item is-open">
              <h3 class="faq-item__heading"><button type="button" class="faq-item__trigger" aria-expanded="true" id="home-q1" aria-controls="home-q1-a">
                <span>Is Restwell suitable for wheelchair users?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button></h3>
              <div class="faq-item__panel" id="home-q1-a" role="region" aria-labelledby="home-q1">
                <p>Yes. Restwell is a private, step-free house. Measurements and kit notes are on the Accessibility page, before you book.</p>
              </div>
            </div>
            <div class="faq-item">
              <h3 class="faq-item__heading"><button type="button" class="faq-item__trigger" aria-expanded="false" id="home-q2" aria-controls="home-q2-a">
                <span>What makes accessible self-catering work well?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button></h3>
              <div class="faq-item__panel" id="home-q2-a" role="region" aria-labelledby="home-q2" hidden>
                <p>Published access details, not a vague label. On-site equipment is included in the house rate. Measurements and kit notes are on the Accessibility page.</p>
              </div>
            </div>
            <div class="faq-item">
              <h3 class="faq-item__heading"><button type="button" class="faq-item__trigger" aria-expanded="false" id="home-q3" aria-controls="home-q3-a">
                <span>Is this disabled holiday accommodation in Kent?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button></h3>
              <div class="faq-item__panel" id="home-q3-a" role="region" aria-labelledby="home-q3" hidden>
                <p>Yes. It’s a specialist accessible holiday in Whitstable, Kent. Measurements and kit notes are on the Accessibility page.</p>
              </div>
            </div>
          </div>
          <aside class="faq-cta" aria-label="More questions">
            <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'faq' ) ); ?>">Browse the FAQ</a>
          </aside>
        </div>
      </div>
    </section>

    <section class="mid-cta mid-cta--plain section-y--cta" id="enquire" aria-labelledby="mid-cta-h">
      <div class="mid-cta__media" aria-hidden="true"></div>
      <div class="mid-cta__inner">
        <h2 id="mid-cta-h">Not sure it’s the right fit?</h2>
        <p>You can look through the FAQ, or just send us your dates and access needs. We’ll let you know quickly if it’s not the right fit.</p>
        <div class="mid-cta__btns">
          <a class="btn btn-gold" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'enquire' ) ); ?>">Enquire now</a>
          <a class="btn btn-outline-light" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'accessibility' ) ); ?>">Read the access statement</a>
        </div>
      </div>
    </section>

</main>

<?php
get_footer();
