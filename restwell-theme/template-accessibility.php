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

$restwell_acc_id      = (int) get_queried_object_id();
$restwell_acc_heading = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $restwell_acc_id, 'acc_heading', 'The wet room, the hoists, and every measurement' )
	: 'The wet room, the hoists, and every measurement';
$restwell_acc_intro   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text(
		$restwell_acc_id,
		'acc_intro',
		'This is the access statement for Restwell, a single-storey adapted bungalow in Whitstable. The front door has a 965mm clear opening and internal doorways are 926mm. There is a ceiling track hoist rated to 180kg, a mobile hoist, a level-access wet room, and up to two profiling beds depending on what you need.'
	)
	: 'This is the access statement for Restwell, a single-storey adapted bungalow in Whitstable. The front door has a 965mm clear opening and internal doorways are 926mm. There is a ceiling track hoist rated to 180kg, a mobile hoist, a level-access wet room, and up to two profiling beds depending on what you need.';
?>


<main id="main-content">
<?php
get_template_part(
	'template-parts/concept/photo-hero',
	null,
	array(
		'heading_id' => 'page-h',
		'heading'    => $restwell_acc_heading,
		'intro'      => $restwell_acc_intro,
		'crumbs'     => array(
			array(
				'label' => __( 'Home', 'restwell-retreats' ),
				'url'   => home_url( '/' ),
			),
			array(
				'label' => 'Accessibility',
				'url'   => '',
			),
		),
		'post_id'    => $restwell_acc_id,
	)
);
?>

	<section class="section-y section-y--compact band-white" aria-label="Key measurements">
	  <div class="container">
		<div class="stat-row">
		  <dl>
			<div class="stat"><dt class="stat__label">Clear opening, front door</dt><dd class="stat__value">965mm</dd></div>
			<div class="stat"><dt class="stat__label">Clear width, internal doors</dt><dd class="stat__value">926mm</dd></div>
			<div class="stat"><dt class="stat__label">Ceiling track hoist over the bed</dt><dd class="stat__value">Full-room</dd></div>
		  </dl>
		</div>
	  </div>
	</section>

	<section class="section-y band-subtle" id="fit-check" aria-labelledby="fit-check-h">
	  <div class="container">
		<header class="section-head section-head--tight">
		  <p class="eyebrow">Door clearances</p>
		  <h2 id="fit-check-h">Compare your chair width to our doorways</h2>
		  <p class="lede">Enter the overall width of the chair you travel with (widest point, including hand rims). We’ll show the clearance at each doorway so you can judge the numbers before you enquire.</p>
		</header>
		<div class="fit-check-split">
		<div class="fit-check" data-fit-check>
		  <div class="fit-check__panel">
			<div class="fit-check__control">
			  <div class="fit-check__control-row">
				<label class="fit-check__label" for="fit-check-number" id="fit-check-label">Wheelchair width</label>
				<div class="fit-check__control-right">
				  <div class="fit-check__readout">
					<input type="number" id="fit-check-number" data-fit-number inputmode="decimal" min="500" max="1050" step="1" value="700" aria-describedby="fit-check-summary" />
				  </div>
				  <div class="fit-check__unit-toggle" role="group" aria-label="Measurement units">
					<button type="button" data-fit-unit="mm" aria-pressed="true">mm</button>
					<button type="button" data-fit-unit="in" aria-pressed="false">in</button>
				  </div>
				</div>
			  </div>
			  <input type="range" id="fit-check-input" min="500" max="1050" step="1" value="700" data-fit-input aria-labelledby="fit-check-label" aria-describedby="fit-check-summary" />
			  <div class="fit-check__scale" aria-hidden="true">
				<span data-fit-min-label>500mm</span>
				<span data-fit-max-label>1050mm</span>
			  </div>
			  <p class="fit-check__summary" id="fit-check-summary" data-fit-summary role="status" aria-live="polite"></p>
			</div>
			<div class="fit-check__bars">
			  <div class="fit-bar" data-fit-gauge data-door-width="965" data-fit-name="the front door">
				<div class="fit-bar__head">
				  <span class="fit-bar__label">Front door</span>
				  <span class="fit-bar__spec" data-fit-spec>965mm</span>
				</div>
				<div class="fit-bar__track" data-fit-track aria-hidden="true">
				  <span class="fit-bar__fill" data-fit-fill></span>
				</div>
				<p class="fit-bar__result" data-fit-result></p>
			  </div>

			  <div class="fit-bar" data-fit-gauge data-door-width="926" data-fit-name="the internal doors">
				<div class="fit-bar__head">
				  <span class="fit-bar__label">Internal doors</span>
				  <span class="fit-bar__spec" data-fit-spec>926mm</span>
				</div>
				<div class="fit-bar__track" data-fit-track aria-hidden="true">
				  <span class="fit-bar__fill" data-fit-fill></span>
				</div>
				<p class="fit-bar__result" data-fit-result></p>
			  </div>
			</div>
			<p class="fit-check__note">This is a guide only. Aim for at least 50mm of clearance where you can, and we’re happy to talk through your measurements before you book.</p>
		  </div>
		</div>
		<aside class="width-guide" aria-labelledby="width-guide-h">
		  <div class="width-guide__intro">
			<h3 id="width-guide-h" class="width-guide__title">Typical chair widths</h3>
			<p class="width-guide__lede">Wheel to wheel, including hand rims. These are common ranges, not a measurement of your chair.</p>
		  </div>
		  <ul class="width-guide__list">
			<li>
			  <button type="button" class="width-guide__row" data-fit-preset="570" aria-label="Set checker to 570 millimetres, typical transit chair">
				<span class="width-guide__copy">
				  <span class="width-guide__name">Transit</span>
				  <span class="width-guide__hint">Attendant-propelled</span>
				</span>
				<span class="width-guide__size">
				  <span class="width-guide__mm">530–610mm</span>
				  <span class="width-guide__in">21–24in</span>
				</span>
			  </button>
			</li>
			<li>
			  <button type="button" class="width-guide__row" data-fit-preset="660" aria-label="Set checker to 660 millimetres, typical self-propelled chair">
				<span class="width-guide__copy">
				  <span class="width-guide__name">Self-propelled</span>
				  <span class="width-guide__hint">Most adult manuals</span>
				</span>
				<span class="width-guide__size">
				  <span class="width-guide__mm">635–685mm</span>
				  <span class="width-guide__in">25–27in</span>
				</span>
			  </button>
			</li>
			<li>
			  <button type="button" class="width-guide__row" data-fit-preset="700" aria-label="Set checker to 700 millimetres, typical powered chair">
				<span class="width-guide__copy">
				  <span class="width-guide__name">Powered</span>
				  <span class="width-guide__hint">Electric bases</span>
				</span>
				<span class="width-guide__size">
				  <span class="width-guide__mm">600–760mm+</span>
				  <span class="width-guide__in">24–30in+</span>
				</span>
			  </button>
			</li>
			<li>
			  <button type="button" class="width-guide__row" data-fit-preset="800" aria-label="Set checker to 800 millimetres, typical bariatric chair">
				<span class="width-guide__copy">
				  <span class="width-guide__name">Bariatric</span>
				  <span class="width-guide__hint">Wide-width</span>
				</span>
				<span class="width-guide__size">
				  <span class="width-guide__mm">Over 760mm</span>
				  <span class="width-guide__in">Over 30in</span>
				</span>
			  </button>
			</li>
		  </ul>
		  <p class="width-guide__note">Choose a type to try a midpoint in the checker. Measure your own chair before you book.</p>
		  <ul class="width-guide__refs">
			<li>
			  <a class="text-link" href="https://www.gov.uk/government/publications/access-to-and-use-of-buildings-approved-document-m" target="_blank" rel="noopener noreferrer">UK Approved Document M<span class="sr-only"> (opens in a new tab)</span></a>
			</li>
			<li>
			  <a class="text-link" href="https://www.bsigroup.com/en-GB/standards/bs-8300-1-and-2/" target="_blank" rel="noopener noreferrer">BS 8300 accessible environment<span class="sr-only"> (opens in a new tab)</span></a>
			</li>
		  </ul>
		</aside>
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
		  <li><article class="media-card"><img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/FD-1-LS.jpg' ) ); ?>" alt="Front door with a wide, level threshold" width="640" height="480" loading="eager" fetchpriority="high" decoding="async" /><h3>Arrival &amp; entrance</h3><p>A private, level driveway for two cars, a 1720mm porch opening, a 965mm inner front door, and a level threshold. Portable fold-up ramps are yours to borrow while you’re here.</p></article></li>
		  <li><article class="media-card"><img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/LR-2-LS.jpg' ) ); ?>" alt="Open-plan living space with wide hall routes between furniture" width="640" height="480" loading="lazy" decoding="async" /><h3>Inside the property</h3><p>The bungalow is single-storey. Internal doorways are 926mm clear, and hallways are kept clear so you can turn your chair.</p></article></li>
		  <li><article class="media-card"><img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/BD2-2-LS.jpg' ) ); ?>" alt="Adjustable profiling beds in the accessible bedroom" width="640" height="480" loading="lazy" decoding="async" /><h3>Bedrooms &amp; sleeping</h3><p>An Accora CommunityBed profiling bed (180kg user weight) under an Amico GoLift 400 ceiling hoist (180kg SWL). A second profiling bed can be set up. The conservatory sofa bed makes the fifth sleeping space.</p></article></li>
		  <li><article class="media-card"><img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/WR-1-LS.jpg' ) ); ?>" alt="Level-access wet room with grab rails" width="640" height="480" loading="lazy" decoding="async" /><h3>Wet room</h3><p>Level-access throughout. Mira Select Flex TMV3 shower, a RAZ-AT tilt-in-space commode chair, a Drive DeVilbiss stool rated to 136kg, and a Ropox Swing basin that winds between 750mm and 950mm.</p></article></li>
		  <li><article class="media-card"><img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/KT-1-LS.jpg' ) ); ?>" alt="Kitchen with a reachable, wheel-under worksurface" width="640" height="480" loading="lazy" decoding="async" /><h3>Kitchen</h3><p>The kitchen features a wheel-under worktop, all the essential utensils, a slide-under oven, and a gas hob.</p></article></li>
		  <li><article class="media-card"><img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/GRDEN-1-LS.jpg' ) ); ?>" alt="Level garden and patio beyond the conservatory" width="640" height="480" loading="lazy" decoding="async" /><h3>Outdoor spaces</h3><p>A ramp leads to a level patio and enclosed garden, with space for a BBQ and French doors opening from the conservatory.</p></article></li>
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
			  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/H-1-LS.jpg' ) ); ?>" alt="Ceiling track hoist in situ" width="640" height="480" loading="lazy" decoding="async" />
			</button>
		  </li>
		  <li>
			<button type="button" class="gallery__open" data-gallery-open data-gallery-index="1" aria-label="View full size: Rise and recline chair">
			  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/RAR-2-LS.jpg' ) ); ?>" alt="Rise and recline chair" width="640" height="480" loading="lazy" decoding="async" />
			</button>
		  </li>
		  <li>
			<button type="button" class="gallery__open" data-gallery-open data-gallery-index="2" aria-label="View full size: Wet room grab rails and shower">
			  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/WR-2-LS.jpg' ) ); ?>" alt="Wet room grab rails and shower" width="640" height="480" loading="lazy" decoding="async" />
			</button>
		  </li>
		  <li>
			<button type="button" class="gallery__open" data-gallery-open data-gallery-index="3" aria-label="View full size: Access equipment in the bedroom">
			  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/EQU-2-LS.jpg' ) ); ?>" alt="Access equipment in the bedroom" width="640" height="480" loading="lazy" decoding="async" />
			</button>
		  </li>
		  <li>
			<button type="button" class="gallery__open" data-gallery-open data-gallery-index="4" aria-label="View full size: Height-adjustable basin">
			  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/adjustable-sink.png' ) ); ?>" alt="Height-adjustable basin" width="640" height="480" loading="lazy" decoding="async" />
			</button>
		  </li>
		  <li>
			<button type="button" class="gallery__open" data-gallery-open data-gallery-index="5" aria-label="View full size: Exterior threshold ramp">
			  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/exterior-ramp.png' ) ); ?>" alt="Exterior threshold ramp" width="640" height="480" loading="lazy" decoding="async" />
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
			  <h3 class="faq-item__heading"><button type="button" class="faq-item__trigger" aria-expanded="true" id="a11y-q1" aria-controls="a11y-q1-a">
				<span>Can I find a holiday cottage with a ceiling hoist in England?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button></h3>
			  <div class="faq-item__panel" id="a11y-q1-a" role="region" aria-labelledby="a11y-q1">
				<p>Yes, they are uncommon. Confirm fixed ceiling track vs mobile only, coverage, safe working load, sling policy, and bed position under the track. Restwell has an Amico GoLift 400 ceiling track hoist over the profiling bed, safe working load 180kg; full specs are on this page.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <h3 class="faq-item__heading"><button type="button" class="faq-item__trigger" aria-expanded="false" id="a11y-q2" aria-controls="a11y-q2-a">
				<span>What is a ceiling track hoist in holiday accommodation?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button></h3>
			  <div class="faq-item__panel" id="a11y-q2-a" role="region" aria-labelledby="a11y-q2" hidden>
				<p>A ceiling track hoist is fixed to the ceiling and moves a person in a sling along a rail. It’s less bulky than most mobile units. Most guests bring their own slings. Ask about what areas it covers and who can operate it before you arrive.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <h3 class="faq-item__heading"><button type="button" class="faq-item__trigger" aria-expanded="false" id="a11y-q3" aria-controls="a11y-q3-a">
				<span>What should I check before booking a hoist-equipped holiday let?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button></h3>
			  <div class="faq-item__panel" id="a11y-q3-a" role="region" aria-labelledby="a11y-q3" hidden>
				<p>Check the hoist type and safe working load, whether the bed is under the track, if there’s same-level wet-room access, space for a second carer, parking, and what’s included versus what needs to be hired. Restwell includes the on-site hoist and wet-room kit in the bungalow rate.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <h3 class="faq-item__heading"><button type="button" class="faq-item__trigger" aria-expanded="false" id="a11y-q4" aria-controls="a11y-q4-a">
				<span>Can I find a holiday cottage with a profiling bed in the UK?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button></h3>
			  <div class="faq-item__panel" id="a11y-q4-a" role="region" aria-labelledby="a11y-q4" hidden>
				<p>Yes, but make sure the bed is actually on site, not just “available to hire.” Ask about the mattress type, size, transfer height, and hoist clearance. Restwell’s accessible bedroom has a profiling bed with a pressure-relieving mattress.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <h3 class="faq-item__heading"><button type="button" class="faq-item__trigger" aria-expanded="false" id="a11y-q5" aria-controls="a11y-q5-a">
				<span>Can I find a holiday cottage with a hospital-style or profiling bed?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button></h3>
			  <div class="faq-item__panel" id="a11y-q5-a" role="region" aria-labelledby="a11y-q5" hidden>
				<p>People searching for a “hospital bed holiday cottage” usually want an adjustable profiling bed at a safe transfer height, in a regular bedroom, not a hospital ward. Restwell’s accessible bedroom has this bed, with the ceiling track above it.</p>
			  </div>
			</div>
			</div>
			<div class="faq-list__col">
			<div class="faq-item">
			  <h3 class="faq-item__heading"><button type="button" class="faq-item__trigger" aria-expanded="false" id="a11y-q6" aria-controls="a11y-q6-a">
				<span>Why does an adjustable or profiling bed matter in an accessible bedroom?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button></h3>
			  <div class="faq-item__panel" id="a11y-q6-a" role="region" aria-labelledby="a11y-q6" hidden>
				<p>Profiling beds help with positioning, pressure care, safer transfers, and overnight care routines when a fixed divan isn’t safe. At Restwell, check the controls, side-rail policy, and space for a carer beside the bed to ensure it meets your needs.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <h3 class="faq-item__heading"><button type="button" class="faq-item__trigger" aria-expanded="false" id="a11y-q7" aria-controls="a11y-q7-a">
				<span>What accessible equipment should I expect in a specialist holiday let?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button></h3>
			  <div class="faq-item__panel" id="a11y-q7-a" role="region" aria-labelledby="a11y-q7" hidden>
				<p>Ask for a published equipment list. Restwell includes a profiling bed, ceiling- and mobile hoists, a level-access wet room with a seat and grab rails, a height-adjustable basin, threshold ramps, and parking notes. Never assume “accessible” means a hoist is fitted.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <h3 class="faq-item__heading"><button type="button" class="faq-item__trigger" aria-expanded="false" id="a11y-q8" aria-controls="a11y-q8-a">
				<span>What should “wheelchair friendly holiday cottage” mean?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button></h3>
			  <div class="faq-item__panel" id="a11y-q8-a" role="region" aria-labelledby="a11y-q8" hidden>
				<p>Look for step-free routes, door widths that fit your chair, a bathroom you can use, and parking for accessible vehicles all shown in measurements and photos. If a listing only says “wheelchair friendly,” ask for an access statement or look elsewhere.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <h3 class="faq-item__heading"><button type="button" class="faq-item__trigger" aria-expanded="false" id="a11y-q9" aria-controls="a11y-q9-a">
				<span>What do I need to check before booking an accessible holiday cottage?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button></h3>
			  <div class="faq-item__panel" id="a11y-q9-a" role="region" aria-labelledby="a11y-q9" hidden>
				<p>Check for clear door openings, a step-free route from parking, whether there’s a wet room or adapted bath, hoist type, bed type, turning space, recent entrance and bathroom photos, sling policy, and if <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'optional-care' ) ); ?>">care can be arranged separately</a>. Restwell shares all these details on this page.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <h3 class="faq-item__heading"><button type="button" class="faq-item__trigger" aria-expanded="false" id="a11y-q10" aria-controls="a11y-q10-a">
				<span>What makes an accessible bungalow in the UK suitable for complex needs?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button></h3>
			  <div class="faq-item__panel" id="a11y-q10-a" role="region" aria-labelledby="a11y-q10" hidden>
				<p>Being single-storey helps, but accessibility varies a lot. Some people need widened doorways, purpose-built wet rooms, parking, and often a hoist and profiling bed. Restwell is step-free throughout, as shown here.</p>
			  </div>
			</div>
			</div>
		  </div>
		</div>
	  </div>
	</section>

<?php
$restwell_access_guide = get_page_by_path( 'how-to-read-holiday-cottage-access-statement', OBJECT, 'post' );
if ( $restwell_access_guide instanceof WP_Post ) :
	$restwell_access_guide_url = get_permalink( $restwell_access_guide );
	if ( $restwell_access_guide_url ) :
		?>
	<section class="section-y section-y--compact band-white" aria-labelledby="access-guide-h">
	  <div class="container">
		<header class="section-head section-head--tight">
		  <p class="eyebrow">Comparing other cottages?</p>
		  <h2 id="access-guide-h">How to read any access statement</h2>
		  <p class="lede">This page is Restwell’s property-specific statement. For a general checklist of measurements, red flags and OT questions, see <a class="text-link" href="<?php echo esc_url( $restwell_access_guide_url ); ?>"><?php echo esc_html( get_the_title( $restwell_access_guide ) ); ?></a>.</p>
		</header>
	  </div>
	</section>
		<?php
	endif;
endif;
?>

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
