<?php
/**
 * Template Name: The Property
 *
 * Concept port from mockups — The Property.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$restwell_prop_id      = (int) get_queried_object_id();
$restwell_prop_heading = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $restwell_prop_id, 'prop_hero_heading', 'A proper look round the bungalow' )
	: 'A proper look round the bungalow';
$restwell_prop_intro   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text(
		$restwell_prop_id,
		'prop_hero_subtitle',
		'This is a room-by-room look round Restwell, a single-storey adapted bungalow on a quiet street in Whitstable that sleeps up to five. There are two bedrooms, a level-access wet room, an open living and kitchen space, and French doors onto a level patio and garden.'
	)
	: 'This is a room-by-room look round Restwell, a single-storey adapted bungalow on a quiet street in Whitstable that sleeps up to five. There are two bedrooms, a level-access wet room, an open living and kitchen space, and French doors onto a level patio and garden.';
?>


<main id="main-content">
<?php
get_template_part(
	'template-parts/concept/photo-hero',
	null,
	array(
		'heading_id' => 'page-h',
		'heading'    => $restwell_prop_heading,
		'intro'      => $restwell_prop_intro,
		'crumbs'     => array(
			array(
				'label' => __( 'Home', 'restwell-retreats' ),
				'url'   => home_url( '/' ),
			),
			array(
				'label' => 'The Property',
				'url'   => '',
			),
		),
		'post_id'    => (int) get_queried_object_id(),
	)
);
?>

	<nav class="subnav" aria-label="On this page" data-toc>
	  <div class="container">
		<ul class="subnav__list">
		  <li><a href="#rooms">Bedrooms</a></li>
		  <li><a href="#wetroom">Wet room</a></li>
		  <li><a href="#living">Living</a></li>
		  <li><a href="#kitchen">Kitchen</a></li>
		  <li><a href="#conservatory">Conservatory</a></li>
		  <li><a href="#garden">Outside</a></li>
		  <li><a href="#photos">Photos</a></li>
		  <li><a href="#care">Care</a></li>
		  <li><a href="#location">Location</a></li>
		</ul>
	  </div>
	</nav>

	<section class="section-y band-white" id="rooms" aria-labelledby="rooms-h">
	  <div class="container split">
		<div class="split__media">
		  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/BD2-6-LS.jpg' ) ); ?>" alt="Amico ceiling track hoist in the accessible bedroom" width="900" height="675" loading="lazy" />
		</div>
		<div>
		  <header class="section-head section-head--tight">
			<p class="eyebrow">Bedrooms</p>
			<h2 id="rooms-h">The room with the hoist, and room for everyone else</h2>
			<p class="lede">The accessible bedroom has a ceiling-track hoist that reaches the whole room and can have one or two adjustable profiling beds, depending on what your group needs. There’s a second double bedroom next door, and the conservatory has a double sofa bed for extra guests. We also have a mobile hoist and a standing aid (an AAL RS4, rated to 185kg).</p>
		  </header>
		  <p class="lede">The bungalow can sleep up to five people using the accessible bedroom, the second double, and the conservatory sofa bed. Hoists, profiling beds, and wet-room equipment are all included in the price, unless you need something very specific that we don’t have. When you get in touch, we’ll ask about your group and accessibility needs so we can set up the room for you, with one or two profiling beds as needed. For example, a guest once asked us to match her mum’s bedroom layout from home, and we were happy to help.</p>
		  <p><a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'accessibility' ) ); ?>">Door widths and equipment notes</a></p>
		</div>
	  </div>
	</section>

	<section class="section-y band-subtle" id="wetroom" aria-labelledby="wetroom-h">
	  <div class="container split split--flip">
		<div class="split__media">
		  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/WR-1-LS.jpg' ) ); ?>" alt="Level-access wet room with grab rails" width="900" height="675" loading="lazy" />
		</div>
		<div>
		  <header class="section-head section-head--tight">
			<p class="eyebrow">Wet room</p>
			<h2 id="wetroom-h">Roll-in shower and accessible washroom</h2>
			<p class="lede">The step-free wet room includes a roll-in shower, grab rails, shower and commode chairs, a tilt-in-space chair, a height-adjustable 180° spin wash basin, and a Geberit AquaClean wash-dry WC.</p>
		  </header>
		  <p class="lede">The wet room is arranged to make washing, using the toilet, and transfers easier while you’re here.</p>
		  <p class="lede">All the equipment mentioned is already installed in the bungalow, so you don’t need to hire or set up anything before you arrive.</p>
		</div>
	  </div>
	</section>

	<section class="section-y band-white" id="living" aria-labelledby="living-h">
	  <div class="container split">
		<div class="split__media">
		  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/LR-1-LS.jpg' ) ); ?>" alt="Open-plan living room with rise-and-recline chair and wide walkways" width="900" height="675" loading="lazy" />
		</div>
		<div>
		  <header class="section-head section-head--tight">
			<p class="eyebrow">Living room</p>
			<h2 id="living-h">A comfortable place to come back to</h2>
			<p class="lede">After time by the sea, the living room gives everyone space to settle in.</p>
		  </header>
		  <p class="lede">You’ll find a rise-and-recline armchair, a sofa with pull-out footrests, and a TV with Netflix. The open-plan layout makes it easy for wheelchair users, families, and carers to move around comfortably.</p>
		  <p class="lede">There’s enough seating for everyone, and we keep the space between the sofa and armchair clear so wheelchairs can turn easily.</p>
		</div>
	  </div>
	</section>

	<section class="section-y band-subtle" id="kitchen" aria-labelledby="kitchen-h">
	  <div class="container split split--flip">
		<div class="split__media">
		  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/KT-1-LS.jpg' ) ); ?>" alt="Kitchen with lowered wheel-under worksurface" width="900" height="675" loading="lazy" />
		</div>
		<div>
		  <header class="section-head section-head--tight">
			<p class="eyebrow">Kitchen</p>
			<h2 id="kitchen-h">Wheel-under kitchen, ready for everyday meals</h2>
			<p class="lede">The kitchen features a lowered wheel-under counter, a slide-under oven, microwave, fridge, dishwasher, and all the plates, cutlery, utensils, and cooking basics you’ll need.</p>
		  </header>
		  <p class="lede">It’s set up for easy breakfasts, family meals, and relaxed evenings at home.</p>
		  <p class="lede">The hob is gas, not induction, which might be useful to know for your cooking plans.</p>
		</div>
	  </div>
	</section>

	<section class="section-y band-white" id="conservatory" aria-labelledby="conservatory-h">
	  <div class="container split">
		<div class="split__media">
		  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/GRDEN-2-LS.jpg' ) ); ?>" alt="Sunny conservatory with level access to the resin patio and garden" width="900" height="675" loading="lazy" />
		</div>
		<div>
		  <header class="section-head section-head--tight">
			<p class="eyebrow">Conservatory</p>
			<h2 id="conservatory-h">Sunny dining space with level garden access</h2>
			<p class="lede">The conservatory is a bright space where you can eat, read, or enjoy the garden view.</p>
		  </header>
		  <p class="lede">It has a fold-out dining table, a double sofa bed, level access to the patio, and laundry cupboards with a washing machine and tumble dryer.</p>
		</div>
	  </div>
	</section>

	<section class="section-y band-subtle" id="garden" aria-labelledby="garden-h">
	  <div class="container split split--flip">
		<div class="split__media">
		  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/PT-1-LS.jpg' ) ); ?>" alt="Level patio and enclosed dog-friendly garden" width="900" height="675" loading="lazy" />
		</div>
		<div>
		  <header class="section-head section-head--tight">
			<p class="eyebrow">Outside</p>
			<h2 id="garden-h">Level patio, enclosed garden, and private driveway</h2>
			<p class="lede">French doors open onto a level patio with a non-slip ramp at the threshold.</p>
		  </header>
		  <p class="lede">The garden is fully enclosed and dog-friendly, with outdoor seating, a BBQ, and fairy lights. You can eat outside or let your dog out safely. Please let us know ahead of time so we can do a quick risk assessment.</p>
		  <p class="lede">At the front, there’s a resin-bound, level-access driveway with space for two cars. It’s been tested with two wheelchair-accessible vehicles. Portable ramps are kept in the outdoor box by the front door, ready for you to use around the property or take with you during your stay.</p>
		</div>
	  </div>
	</section>

	<section class="section-y band-white" id="photos" data-gallery>
	  <div class="container">
		<header class="section-head section-head--tight">
		  <p class="eyebrow">Photos</p>
		  <h2>See more of the bungalow.</h2>
		</header>
		<ul class="gallery-grid" role="list" aria-label="Property photos">
		  <li>
			<button type="button" class="gallery__open" data-gallery-open data-gallery-index="0" aria-label="View full size: Level-access wet room shower with grab rails and fold-down seat">
			  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/wet-room-shower.png' ) ); ?>" alt="Level-access wet room shower with grab rails and fold-down seat" width="640" height="480" loading="lazy" decoding="async" />
			</button>
		  </li>
		  <li>
			<button type="button" class="gallery__open" data-gallery-open data-gallery-index="1" aria-label="View full size: Accessible bedroom with ceiling track and mobile hoist">
			  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/BD2-3-LS.jpg' ) ); ?>" alt="Accessible bedroom with ceiling track and mobile hoist" width="640" height="480" loading="lazy" decoding="async" />
			</button>
		  </li>
		  <li>
			<button type="button" class="gallery__open" data-gallery-open data-gallery-index="2" aria-label="View full size: Second double bedroom">
			  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/BD1-1-LS.jpg' ) ); ?>" alt="Second double bedroom" width="640" height="480" loading="lazy" decoding="async" />
			</button>
		  </li>
		  <li>
			<button type="button" class="gallery__open" data-gallery-open data-gallery-index="3" aria-label="View full size: Kitchen with wheel-under worksurface">
			  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/KT-1-LS.jpg' ) ); ?>" alt="Kitchen with wheel-under worksurface" width="640" height="480" loading="lazy" decoding="async" />
			</button>
		  </li>
		  <li>
			<button type="button" class="gallery__open" data-gallery-open data-gallery-index="4" aria-label="View full size: Open-plan living room with wide walkways">
			  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/living-room-2.png' ) ); ?>" alt="Open-plan living room with wide walkways" width="640" height="480" loading="lazy" decoding="async" />
			</button>
		  </li>
		  <li>
			<button type="button" class="gallery__open" data-gallery-open data-gallery-index="5" aria-label="View full size: Rise-and-recline armchair in the living room">
			  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/RAR-1-LS.jpg' ) ); ?>" alt="Rise-and-recline armchair in the living room" width="640" height="480" loading="lazy" decoding="async" />
			</button>
		  </li>
		  <li>
			<button type="button" class="gallery__open" data-gallery-open data-gallery-index="6" aria-label="View full size: Conservatory doors opening toward the living space">
			  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/conservatory-doors.png' ) ); ?>" alt="Conservatory doors opening toward the living space" width="640" height="480" loading="lazy" decoding="async" />
			</button>
		  </li>
		  <li>
			<button type="button" class="gallery__open" data-gallery-open data-gallery-index="7" aria-label="View full size: Enclosed garden and level patio">
			  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/GRDEN-1-LS.jpg' ) ); ?>" alt="Enclosed garden and level patio" width="640" height="480" loading="lazy" decoding="async" />
			</button>
		  </li>
		  <li>
			<button type="button" class="gallery__open" data-gallery-open data-gallery-index="8" aria-label="View full size: Step-free entrance doors to the bungalow">
			  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/entrance.png' ) ); ?>" alt="Step-free entrance doors to the bungalow" width="640" height="480" loading="lazy" decoding="async" />
			</button>
		  </li>
		</ul>
	  </div>
	</section>

	<section class="section-y band-teal" id="care" aria-labelledby="care-h">
	  <div class="container">
		<div class="split">
		  <div class="band-teal__stack">
			<p class="eyebrow eyebrow--on-dark">Optional care</p>
			<h2 id="care-h">Care support is available if you need it</h2>
			<p class="lede">Professional care support is available on site through Continuity, our CQC-regulated sister company. Just ask when you enquire, and care can be arranged at the same time as your booking. Or, if you prefer, you can bring your own carer.</p>
			<ul class="checklist">
			  <li>Personal care: washing, dressing and daily routines at agreed times</li>
			  <li>Visiting care: short daytime visits, or support for a promenade or town trip</li>
			  <li>Mobility and hoisting: transfers with the on-site ceiling track and wet-room kit</li>
			</ul>
			<div class="band-teal__actions">
			  <a class="btn btn-gold" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'optional-care' ) ); ?>">How optional care works</a>
			  <a class="btn btn-outline-light" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'pricing' ) . '#care-rates' ); ?>">See care guide rates</a>
			</div>
		  </div>
		  <div class="split__media">
			<img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/WR-2-LS.jpg' ) ); ?>" alt="Level-access wet room with grab rails and shower seat" width="900" height="675" loading="lazy" />
		  </div>
		</div>
	  </div>
	</section>

	<section class="section-y band-white" id="location" aria-labelledby="location-h">
	  <div class="container split">
		<div>
		  <header class="section-head section-head--tight">
			<p class="eyebrow">Location</p>
			<h2 id="location-h">A quiet street in Whitstable, close to the coast path</h2>
			<p class="lede">The bungalow sits on a quiet residential street, a short walk from The Plough pub and about ten minutes on foot from the seafront.</p>
		  </header>
		  <p class="lede">The beach is shingle, but the wide, paved promenade offers a step-free route along the coast and forms part of the King Charles III England Coast Path.</p>
		  <p class="lede">JoJo’s is about twenty minutes on foot: ten minutes down to the sea, then west along Tankerton promenade. The Marine Hotel sits on that same stretch. A short drive if you’d rather save your energy for lunch.</p>
		  <p class="lede">For route tips, local recommendations, and access details, check our <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'whitstable-area-guide' ) ); ?>">Whitstable accessibility guide</a>.</p>
		</div>
		<div class="split__media">
		  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/WHIT-SEAFRONT-1-LS.jpg' ) ); ?>" alt="Tankerton promenade and Whitstable seafront" width="900" height="675" loading="lazy" />
		</div>
	  </div>
	</section>
	<section class="mid-cta mid-cta--plain section-y--cta" aria-labelledby="mid-cta-h">
	  <div class="mid-cta__media" aria-hidden="true"></div>
	  <div class="mid-cta__inner">
		<h2 id="mid-cta-h">See if the bungalow fits your group.</h2>
		<p>Tell us your preferred dates, group size, and any access or equipment needs.</p>
		<p>We’ll reply with availability, measurements, equipment details, and your next steps.</p>
		<div class="mid-cta__btns">
		  <a class="btn btn-gold" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'enquire' ) ); ?>">Enquire Now</a>
		  <a class="btn btn-outline-light" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'accessibility' ) ); ?>">Read accessibility details</a>
		</div>
	  </div>
	</section>

</main>

<?php
get_footer();
