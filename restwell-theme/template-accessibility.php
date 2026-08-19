<?php
/**
 * Template Name: Accessibility
 *
 * Concept port from mockups — Accessibility.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>


<main id="main-content">
<section class="hero hero--interior" aria-labelledby="page-h">
      <div class="container">
        <div class="hero__content">
          <ol class="breadcrumb"><li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li><li class="breadcrumb__sep" aria-hidden="true">/</li><li aria-current="page">Accessibility</li></ol>
          <div class="hero__text">
            <h1 id="page-h">A wheelchair accessible holiday cottage in Whitstable</h1>
            <p>We provide details on door widths, step-free routes, the wet room, hoist, and parking so you can see if Restwell suits your needs before you get in touch.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="section-y section-y--compact band-white" aria-label="Key measurements">
      <div class="container">
        <div class="stat-row">
          <div class="stat"><p class="stat__value">965mm</p><p class="stat__label">Clear opening, front door</p></div>
          <div class="stat"><p class="stat__value">926mm</p><p class="stat__label">Clear width, internal doors</p></div>
          <div class="stat"><p class="stat__value">Full-room</p><p class="stat__label">Ceiling track hoist over the bed</p></div>
        </div>
      </div>
    </section>

    <section class="section-y band-subtle" id="fit-check" aria-labelledby="fit-check-h">
      <div class="container">
        <div class="fit-check" data-fit-check>
          <header class="section-head section-head--tight">
            <p class="eyebrow">Try it yourself</p>
            <h2 id="fit-check-h">Will your wheelchair fit through our doors?</h2>
            <p class="lede">Check your chair’s width (look at your spec sheet or measure the widest part, including hand rims) to see how much space there is at each doorway.</p>
          </header>
          <div class="fit-check__panel">
            <div class="fit-check__control">
              <div class="fit-check__control-row">
                <label for="fit-check-input">Wheelchair width</label>
                <div class="fit-check__control-right">
                  <div class="fit-check__unit-toggle" role="group" aria-label="Units">
                    <button type="button" data-fit-unit="mm" aria-pressed="true">mm</button>
                    <button type="button" data-fit-unit="in" aria-pressed="false">in</button>
                  </div>
                  <output id="fit-check-value" for="fit-check-input" data-fit-value>700mm</output>
                </div>
              </div>
              <input type="range" id="fit-check-input" min="500" max="1050" step="10" value="700" data-fit-input aria-describedby="fit-check-value fit-check-summary" />
              <p class="fit-check__summary" id="fit-check-summary" data-fit-summary aria-live="polite"></p>
            </div>
            <div class="fit-check__bars">
              <div class="fit-bar" data-fit-gauge data-door-width="965" data-fit-name="the front door">
                <div class="fit-bar__head">
                  <svg class="fit-bar__icon" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 16a5 5 0 1 0 10 0a5 5 0 1 0 -10 0" />
                    <path d="M17 19a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                    <path d="M19 17a3 3 0 0 0 -3 -3h-3.4" />
                    <path d="M3 3h1a2 2 0 0 1 2 2v6" />
                    <path d="M6 8h11" />
                    <path d="M15 8v6" />
                  </svg>
                  <span class="fit-bar__label">Front door</span>
                </div>
                <div class="fit-bar__track" data-fit-track>
                  <span class="fit-bar__door-mark" aria-hidden="true"><span class="fit-bar__door-mark-label" data-fit-spec></span></span>
                  <span class="fit-bar__fill" data-fit-fill></span>
                </div>
                <p class="fit-bar__result" data-fit-result></p>
              </div>

              <div class="fit-bar" data-fit-gauge data-door-width="926" data-fit-name="the internal doors">
                <div class="fit-bar__head">
                  <svg class="fit-bar__icon" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 16a5 5 0 1 0 10 0a5 5 0 1 0 -10 0" />
                    <path d="M17 19a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                    <path d="M19 17a3 3 0 0 0 -3 -3h-3.4" />
                    <path d="M3 3h1a2 2 0 0 1 2 2v6" />
                    <path d="M6 8h11" />
                    <path d="M15 8v6" />
                  </svg>
                  <span class="fit-bar__label">Internal doors</span>
                </div>
                <div class="fit-bar__track" data-fit-track>
                  <span class="fit-bar__door-mark" aria-hidden="true"><span class="fit-bar__door-mark-label" data-fit-spec></span></span>
                  <span class="fit-bar__fill" data-fit-fill></span>
                </div>
                <p class="fit-bar__result" data-fit-result></p>
              </div>
            </div>
            <p class="fit-check__note">This is just a rough guide. We suggest having at least 50mm of clearance if you can, and please double-check your chair’s width with us before you book.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="section-y band-white">
      <div class="container">
        <header class="section-head">
          <p class="eyebrow">Room by room</p>
          <h2>Room-by-room access notes</h2>
        </header>
        <ul class="card-grid card-grid--3" role="list">
          <li><article class="media-card"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/bungalow/FD-1-LS.jpg' ); ?>" alt="Front door with a wide, level threshold" width="640" height="480" loading="eager" fetchpriority="high" decoding="async" /><h3>Arrival &amp; entrance</h3><p>You’ll find a private driveway for two cars, a step-free path, a 965mm wide front door, and a level threshold. If you need them, we have portable fold-up ramps for the front door.</p></article></li>
          <li><article class="media-card"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/bungalow/LR-2-LS.jpg' ); ?>" alt="Open-plan living space with wide hall routes between furniture" width="640" height="480" loading="lazy" decoding="async" /><h3>Inside the property</h3><p>The bungalow is single-storey. Inside, doorways are 926mm wide and hallways are kept clear so you can turn your chair easily.</p></article></li>
          <li><article class="media-card"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/bungalow/BD2-2-LS.jpg' ); ?>" alt="Adjustable profiling beds in the accessible bedroom" width="640" height="480" loading="lazy" decoding="async" /><h3>Bedrooms &amp; sleeping</h3><p>The accessible bedroom has a profiling bed with a pressure-relieving mattress and a hoist. Next door is a second double bedroom, and the conservatory sofa bed can sleep a fifth guest.</p></article></li>
          <li><article class="media-card"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/bungalow/WR-1-LS.jpg' ); ?>" alt="Level-access wet room with grab rails" width="640" height="480" loading="lazy" decoding="async" /><h3>Wet room</h3><p>The wet room includes a level-access shower, grab rails, a shower chair, a height-adjustable basin, and a wash-dry WC. Care Spaces adapted this room.</p></article></li>
          <li><article class="media-card"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/bungalow/KT-1-LS.jpg' ); ?>" alt="Kitchen with a reachable, wheel-under worksurface" width="640" height="480" loading="lazy" decoding="async" /><h3>Kitchen</h3><p>The kitchen features a wheel-under worktop, all the essential utensils, a slide-under oven, and a gas hob.</p></article></li>
          <li><article class="media-card"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/bungalow/GRDEN-1-LS.jpg' ); ?>" alt="Level garden and patio beyond the conservatory" width="640" height="480" loading="lazy" decoding="async" /><h3>Outdoor spaces</h3><p>A ramp leads to a level patio and enclosed garden, with space for a BBQ and French doors opening from the conservatory.</p></article></li>
        </ul>
        <ul class="card-grid card-grid--2" role="list">
          <li><article class="info-card info-card--sand info-card--flat"><h3>Specific requirement?</h3><p>Email us your needs as early as you can. We may not be able to provide every aid at short notice, but we’d much rather you ask than be unsure.</p><a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'enquire' ) ); ?>">Send details</a></article></li>
          <li><article class="info-card info-card--sand info-card--flat"><h3>Need precise measurements?</h3><p>You’ll find door widths and key specs here. If you need other measurements, just let us know and we’ll measure them for you.</p><a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'enquire' ) ); ?>">Request measurements</a></article></li>
        </ul>
      </div>
    </section>
    <section class="section-y band-subtle" data-gallery>
      <div class="container">
        <header class="section-head">
          <p class="eyebrow">Equipment</p>
          <h2>Tailored to you</h2>
          <p class="lede">We prepare the bungalow for you before you arrive, setting up the equipment you need from our list based on what you tell us when you enquire. If anything feels loose or isn’t right, please let us know right away.</p>
        </header>
        <ul class="gallery-grid" role="list" aria-label="Access equipment photos">
          <li>
            <button type="button" class="gallery__open" data-gallery-open data-gallery-index="0" aria-label="View full size: Ceiling track hoist in situ">
              <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/bungalow/H-1-LS.jpg' ); ?>" alt="Ceiling track hoist in situ" width="640" height="480" loading="lazy" decoding="async" />
            </button>
          </li>
          <li>
            <button type="button" class="gallery__open" data-gallery-open data-gallery-index="1" aria-label="View full size: Rise and recline chair">
              <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/bungalow/RAR-2-LS.jpg' ); ?>" alt="Rise and recline chair" width="640" height="480" loading="lazy" decoding="async" />
            </button>
          </li>
          <li>
            <button type="button" class="gallery__open" data-gallery-open data-gallery-index="2" aria-label="View full size: Wet room grab rails and shower">
              <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/bungalow/WR-2-LS.jpg' ); ?>" alt="Wet room grab rails and shower" width="640" height="480" loading="lazy" decoding="async" />
            </button>
          </li>
          <li>
            <button type="button" class="gallery__open" data-gallery-open data-gallery-index="3" aria-label="View full size: Access equipment in the bedroom">
              <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/bungalow/EQU-2-LS.jpg' ); ?>" alt="Access equipment in the bedroom" width="640" height="480" loading="lazy" decoding="async" />
            </button>
          </li>
          <li>
            <button type="button" class="gallery__open" data-gallery-open data-gallery-index="4" aria-label="View full size: Height-adjustable basin">
              <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/bungalow/adjustable-sink.png' ); ?>" alt="Height-adjustable basin" width="640" height="480" loading="lazy" decoding="async" />
            </button>
          </li>
          <li>
            <button type="button" class="gallery__open" data-gallery-open data-gallery-index="5" aria-label="View full size: Exterior threshold ramp">
              <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/bungalow/exterior-ramp.png' ); ?>" alt="Exterior threshold ramp" width="640" height="480" loading="lazy" decoding="async" />
            </button>
          </li>
        </ul>
      </div>
    </section>
    <section class="section-y band-white">
      <div class="container split">
        <div class="split__media">
          <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/stock/restwell-whitstable-coastal-pathway.webp' ); ?>" alt="Flat, paved coastal pathway along Tankerton promenade" width="900" height="675" loading="lazy" decoding="async" />
        </div>
        <div>
          <header class="section-head">
            <p class="eyebrow">Local coast</p>
            <h2>What to expect in Whitstable</h2>
          </header>
          <dl class="comparison-list">
            <div class="comparison-list__item">
              <dt>Level coast</dt>
              <dd>Tankerton promenade is flat and paved for miles, with parking along Marine Parade and accessible toilets nearby.</dd>
            </div>
            <div class="comparison-list__item">
              <dt>Town limits</dt>
              <dd>Harbour Street pavements can be narrow, some shop entrances have steps, and harbour surfaces may be uneven.</dd>
            </div>
            <div class="comparison-list__item">
              <dt>Beach</dt>
              <dd>The shingle beach isn’t wheelchair-friendly, but you can use the promenade above to enjoy the sea air.</dd>
            </div>
          </dl>
        </div>
      </div>
    </section>
    <section class="faq section-y band-white" id="faq" aria-labelledby="faq-h">
      <div class="container">
        <div class="faq__layout">
          <header class="faq__intro">
            <p class="eyebrow">Equipment &amp; access</p>
            <h2 id="faq-h">Access FAQ</h2>
            <p class="lede">Questions about ceiling hoist safe working loads, profiling beds, and the details that make a place truly “wheelchair friendly.”</p>
          </header>
          <div class="faq-list faq-list--split" data-faq-accordion>
            <div class="faq-list__col">
            <div class="faq-item is-open">
              <button type="button" class="faq-item__trigger" aria-expanded="true" id="a11y-q1" aria-controls="a11y-q1-a">
                <span>Can I find a holiday cottage with a ceiling hoist in England?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button>
              <div class="faq-item__panel" id="a11y-q1-a" role="region" aria-labelledby="a11y-q1">
                <p>Yes, they are uncommon. Confirm fixed ceiling track vs mobile only, coverage, safe working load, sling policy, and bed position under the track. Restwell has an Amico GoLift 400 ceiling track hoist over the profiling bed, safe working load 181kg; full specs are on this page.</p>
              </div>
            </div>
            <div class="faq-item">
              <button type="button" class="faq-item__trigger" aria-expanded="false" id="a11y-q2" aria-controls="a11y-q2-a">
                <span>What is a ceiling track hoist in holiday accommodation?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button>
              <div class="faq-item__panel" id="a11y-q2-a" role="region" aria-labelledby="a11y-q2" hidden>
                <p>A ceiling track hoist is fixed to the ceiling and moves a person in a sling along a rail. It’s less bulky than most mobile units. Most guests bring their own slings. Ask about what areas it covers and who can operate it before you arrive.</p>
              </div>
            </div>
            <div class="faq-item">
              <button type="button" class="faq-item__trigger" aria-expanded="false" id="a11y-q3" aria-controls="a11y-q3-a">
                <span>What should I check before booking a hoist-equipped holiday let?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button>
              <div class="faq-item__panel" id="a11y-q3-a" role="region" aria-labelledby="a11y-q3" hidden>
                <p>Check the hoist type and safe working load, whether the bed is under the track, if there’s same-level wet-room access, space for a second carer, parking, and what’s included versus what needs to be hired. Restwell includes the on-site hoist and wet-room kit in the bungalow rate.</p>
              </div>
            </div>
            <div class="faq-item">
              <button type="button" class="faq-item__trigger" aria-expanded="false" id="a11y-q4" aria-controls="a11y-q4-a">
                <span>Can I find a holiday cottage with a profiling bed in the UK?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button>
              <div class="faq-item__panel" id="a11y-q4-a" role="region" aria-labelledby="a11y-q4" hidden>
                <p>Yes, but make sure the bed is actually on site, not just “available to hire.” Ask about the mattress type, size, transfer height, and hoist clearance. Restwell’s accessible bedroom has a profiling bed with a pressure-relieving mattress.</p>
              </div>
            </div>
            <div class="faq-item">
              <button type="button" class="faq-item__trigger" aria-expanded="false" id="a11y-q5" aria-controls="a11y-q5-a">
                <span>Can I find a holiday cottage with a hospital-style or profiling bed?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button>
              <div class="faq-item__panel" id="a11y-q5-a" role="region" aria-labelledby="a11y-q5" hidden>
                <p>People searching for a “hospital bed holiday cottage” usually want an adjustable profiling bed at a safe transfer height, in a regular bedroom, not a hospital ward. Restwell’s accessible bedroom has this bed, with the ceiling track above it.</p>
              </div>
            </div>
            </div>
            <div class="faq-list__col">
            <div class="faq-item">
              <button type="button" class="faq-item__trigger" aria-expanded="false" id="a11y-q6" aria-controls="a11y-q6-a">
                <span>Why does an adjustable or profiling bed matter in an accessible bedroom?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button>
              <div class="faq-item__panel" id="a11y-q6-a" role="region" aria-labelledby="a11y-q6" hidden>
                <p>Profiling beds help with positioning, pressure care, safer transfers, and overnight care routines when a fixed divan isn’t safe. At Restwell, check the controls, side-rail policy, and space for a carer beside the bed to ensure it meets your needs.</p>
              </div>
            </div>
            <div class="faq-item">
              <button type="button" class="faq-item__trigger" aria-expanded="false" id="a11y-q7" aria-controls="a11y-q7-a">
                <span>What accessible equipment should I expect in a specialist holiday let?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button>
              <div class="faq-item__panel" id="a11y-q7-a" role="region" aria-labelledby="a11y-q7" hidden>
                <p>Ask for a published equipment list. Restwell includes a profiling bed, ceiling- and mobile hoists, a level-access wet room with a seat and grab rails, a height-adjustable basin, threshold ramps, and parking notes. Never assume “accessible” means a hoist is fitted.</p>
              </div>
            </div>
            <div class="faq-item">
              <button type="button" class="faq-item__trigger" aria-expanded="false" id="a11y-q8" aria-controls="a11y-q8-a">
                <span>What should “wheelchair friendly holiday cottage” mean?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button>
              <div class="faq-item__panel" id="a11y-q8-a" role="region" aria-labelledby="a11y-q8" hidden>
                <p>Look for step-free routes, door widths that fit your chair, a bathroom you can use, and parking for accessible vehicles all shown in measurements and photos. If a listing only says “wheelchair friendly,” ask for an access statement or look elsewhere.</p>
              </div>
            </div>
            <div class="faq-item">
              <button type="button" class="faq-item__trigger" aria-expanded="false" id="a11y-q9" aria-controls="a11y-q9-a">
                <span>What do I need to check before booking an accessible holiday cottage?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button>
              <div class="faq-item__panel" id="a11y-q9-a" role="region" aria-labelledby="a11y-q9" hidden>
                <p>Check for clear door openings, a step-free route from parking, whether there’s a wet room or adapted bath, hoist type, bed type, turning space, recent entrance and bathroom photos, sling policy, and if <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'optional-care' ) ); ?>">care can be arranged separately</a>. Restwell shares all these details on this page.</p>
              </div>
            </div>
            <div class="faq-item">
              <button type="button" class="faq-item__trigger" aria-expanded="false" id="a11y-q10" aria-controls="a11y-q10-a">
                <span>What makes an accessible bungalow in the UK suitable for complex needs?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button>
              <div class="faq-item__panel" id="a11y-q10-a" role="region" aria-labelledby="a11y-q10" hidden>
                <p>Being single-storey helps, but accessibility varies a lot. Some people need widened doorways, purpose-built wet rooms, parking, and often a hoist and profiling bed. Restwell is step-free throughout, as shown here.</p>
              </div>
            </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="mid-cta mid-cta--plain section-y--cta" aria-labelledby="mid-cta-h">
      <div class="mid-cta__media" aria-hidden="true"></div>
      <div class="mid-cta__inner">
        <h2 id="mid-cta-h">Ask about your equipment and clearances.</h2>
        <p>If you have questions about door widths, hoist limits, wet-room equipment, or care, we will answer them clearly.</p>
        <div class="mid-cta__btns">
          <a class="btn btn-gold" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'enquire' ) ); ?>">Enquire Now</a>
          <a class="btn btn-outline-light" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'the-property' ) ); ?>">Tour the property</a>
        </div>
      </div>
    </section>

</main>

<?php
get_footer();
