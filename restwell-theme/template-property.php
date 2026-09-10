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

$restwell_prop_id = (int) get_queried_object_id();

$prop_txt = static function ( $key, $fallback ) use ( $restwell_prop_id ) {
	return function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_prop_id, $key, $fallback )
		: $fallback;
};

$prop_heading = static function ( $key, $fallback ) use ( $restwell_prop_id, $prop_txt ) {
	if ( function_exists( 'restwell_get_property_heading' ) ) {
		$resolved = restwell_get_property_heading( $restwell_prop_id, $key );
		if ( '' !== trim( (string) $resolved ) ) {
			return $resolved;
		}
	}
	return $prop_txt( $key, $fallback );
};

$prop_paras = static function ( $text ) {
	$parts = preg_split( '/\n\s*\n/', trim( (string) $text ) );
	if ( ! is_array( $parts ) ) {
		return array();
	}
	return array_values(
		array_filter(
			array_map( 'trim', $parts ),
			static function ( $p ) {
				return '' !== $p;
			}
		)
	);
};

$restwell_prop_heading = $prop_heading( 'prop_hero_heading', 'A proper look round the bungalow' );
$restwell_prop_intro   = $prop_txt(
	'prop_hero_subtitle',
	'A room-by-room look round Restwell: a single-storey adapted bungalow in Whitstable that sleeps up to five.'
);

$prop_bedrooms_heading = $prop_heading( 'prop_bedrooms_section_heading', 'The room with the hoist, and room for everyone else' );
$prop_bedrooms_paras   = $prop_paras(
	$prop_txt(
		'prop_bedrooms_section_body',
		"The accessible bedroom has a ceiling-track hoist that reaches the whole room and can have one or two adjustable profiling beds, depending on what your group needs. There’s a second double bedroom next door, and the conservatory has a double sofa bed for extra guests. We also have a mobile hoist and a standing aid (an AAL RS4, rated to 185kg).\n\nThe bungalow can sleep up to five people using the accessible bedroom, the second double, and the conservatory sofa bed. Hoists, profiling beds, and wet-room equipment are all included in the price, unless you need something very specific that we don’t have. When you get in touch, we’ll ask about your group and accessibility needs so we can set up the room for you, with one or two profiling beds as needed. For example, a guest once asked us to match her mum’s bedroom layout from home, and we were happy to help."
	)
);

$prop_wetroom_heading = $prop_heading( 'prop_wetroom_heading', 'Roll-in shower and accessible washroom' );
$prop_wetroom_paras   = $prop_paras(
	$prop_txt(
		'prop_wetroom_body',
		"The step-free wet room includes a roll-in shower, grab rails, shower and commode chairs, a tilt-in-space chair, a height-adjustable 180° spin wash basin, and a Geberit AquaClean wash-dry WC.\n\nThe wet room is arranged to make washing, using the toilet, and transfers easier while you’re here.\n\nAll the equipment mentioned is already installed in the bungalow, so you don’t need to hire or set up anything before you arrive."
	)
);

$prop_living_heading = $prop_heading( 'prop_living_heading', 'A comfortable place to come back to' );
$prop_living_paras   = $prop_paras(
	$prop_txt(
		'prop_living_body',
		"After time by the sea, the living room gives everyone space to settle in.\n\nYou’ll find a rise-and-recline armchair, a sofa with pull-out footrests, and a TV with Netflix. The open-plan layout makes it easy for wheelchair users, families, and carers to move around comfortably.\n\nThere’s enough seating for everyone, and we keep the space between the sofa and armchair clear so wheelchairs can turn easily."
	)
);

$prop_kitchen_heading = $prop_heading( 'prop_kitchen_heading', 'Wheel-under kitchen, ready for everyday meals' );
$prop_kitchen_paras   = $prop_paras(
	$prop_txt(
		'prop_kitchen_body',
		"The kitchen features a lowered wheel-under counter, a slide-under oven, microwave, fridge, dishwasher, and all the plates, cutlery, utensils, and cooking basics you’ll need.\n\nIt’s set up for easy breakfasts, family meals, and relaxed evenings at home.\n\nThe hob is gas, not induction, which might be useful to know for your cooking plans."
	)
);

$prop_conservatory_heading = $prop_heading( 'prop_conservatory_heading', 'Sunny dining space with level garden access' );
$prop_conservatory_paras   = $prop_paras(
	$prop_txt(
		'prop_conservatory_body',
		"The conservatory is a bright space where you can eat, read, or enjoy the garden view.\n\nIt has a fold-out dining table, a double sofa bed, level access to the patio, and laundry cupboards with a washing machine and tumble dryer."
	)
);

$prop_garden_heading = $prop_heading( 'prop_garden_heading', 'Level patio, enclosed garden, and private driveway' );
$prop_garden_paras   = $prop_paras(
	$prop_txt(
		'prop_garden_body',
		"French doors open onto a level patio with a non-slip ramp at the threshold.\n\nThe garden is fully enclosed and dog-friendly, with outdoor seating, a BBQ, and fairy lights. You can eat outside or let your dog out safely. Please let us know ahead of time so we can do a quick risk assessment.\n\nAt the front, there’s a resin-bound, level-access driveway with space for two cars. It’s been tested with two wheelchair-accessible vehicles. Portable ramps are kept in the outdoor box by the front door, ready for you to use around the property or take with you during your stay."
	)
);

$prop_gallery_label   = $prop_txt( 'prop_gallery_label', 'Photos' );
$prop_gallery_heading = $prop_heading( 'prop_gallery_heading', 'See more of the bungalow.' );

$prop_care_heading = $prop_heading( 'prop_care_heading', 'Optional home care' );
$prop_care_body    = $prop_txt(
	'prop_care_body',
	'Home care from Continuity can be added on the same enquiry, quoted separately. Bring your own carer if you prefer.'
);

$prop_location_heading = $prop_heading( 'prop_location_heading', 'A quiet street in Whitstable, close to the coast path' );
$prop_location_paras   = $prop_paras(
	$prop_txt(
		'prop_location_body',
		"The bungalow sits on a quiet residential street, a short walk from The Plough pub and about ten minutes on foot from the seafront.\n\nThe beach is shingle, but the wide, paved promenade offers a step-free route along the coast and forms part of the King Charles III England Coast Path.\n\nJoJo’s is about twenty minutes on foot: ten minutes down to the sea, then west along Tankerton promenade. The Marine Hotel sits on that same stretch. A short drive if you’d rather save your energy for lunch."
	)
);
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
				'label' => __( 'The Property', 'restwell-retreats' ),
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
		  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/BD2-2-LS.jpg' ) ); ?>" alt="Accessible bedroom with two profiling beds and coastal bedding" width="900" height="675" loading="lazy" decoding="async" />
		</div>
		<div>
		  <header class="section-head section-head--tight">
			<p class="eyebrow">Bedrooms</p>
			<h2 id="rooms-h"><?php echo esc_html( $prop_bedrooms_heading ); ?></h2>
			<?php if ( ! empty( $prop_bedrooms_paras[0] ) ) : ?>
			<p class="lede"><?php echo esc_html( $prop_bedrooms_paras[0] ); ?></p>
			<?php endif; ?>
		  </header>
		  <?php
			foreach ( array_slice( $prop_bedrooms_paras, 1 ) as $prop_bedrooms_para ) :
				?>
		  <p class="lede"><?php echo esc_html( $prop_bedrooms_para ); ?></p>
				<?php
			endforeach;
			?>
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
			<h2 id="wetroom-h"><?php echo esc_html( $prop_wetroom_heading ); ?></h2>
			<?php if ( ! empty( $prop_wetroom_paras[0] ) ) : ?>
			<p class="lede"><?php echo esc_html( $prop_wetroom_paras[0] ); ?></p>
			<?php endif; ?>
		  </header>
		  <?php
			foreach ( array_slice( $prop_wetroom_paras, 1 ) as $prop_wetroom_para ) :
				?>
		  <p class="lede"><?php echo esc_html( $prop_wetroom_para ); ?></p>
				<?php
			endforeach;
			?>
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
			<h2 id="living-h"><?php echo esc_html( $prop_living_heading ); ?></h2>
			<?php if ( ! empty( $prop_living_paras[0] ) ) : ?>
			<p class="lede"><?php echo esc_html( $prop_living_paras[0] ); ?></p>
			<?php endif; ?>
		  </header>
		  <?php
			foreach ( array_slice( $prop_living_paras, 1 ) as $prop_living_para ) :
				?>
		  <p class="lede"><?php echo esc_html( $prop_living_para ); ?></p>
				<?php
			endforeach;
			?>
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
			<h2 id="kitchen-h"><?php echo esc_html( $prop_kitchen_heading ); ?></h2>
			<?php if ( ! empty( $prop_kitchen_paras[0] ) ) : ?>
			<p class="lede"><?php echo esc_html( $prop_kitchen_paras[0] ); ?></p>
			<?php endif; ?>
		  </header>
		  <?php
			foreach ( array_slice( $prop_kitchen_paras, 1 ) as $prop_kitchen_para ) :
				?>
		  <p class="lede"><?php echo esc_html( $prop_kitchen_para ); ?></p>
				<?php
			endforeach;
			?>
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
			<h2 id="conservatory-h"><?php echo esc_html( $prop_conservatory_heading ); ?></h2>
			<?php if ( ! empty( $prop_conservatory_paras[0] ) ) : ?>
			<p class="lede"><?php echo esc_html( $prop_conservatory_paras[0] ); ?></p>
			<?php endif; ?>
		  </header>
		  <?php
			foreach ( array_slice( $prop_conservatory_paras, 1 ) as $prop_conservatory_para ) :
				?>
		  <p class="lede"><?php echo esc_html( $prop_conservatory_para ); ?></p>
				<?php
			endforeach;
			?>
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
			<h2 id="garden-h"><?php echo esc_html( $prop_garden_heading ); ?></h2>
			<?php if ( ! empty( $prop_garden_paras[0] ) ) : ?>
			<p class="lede"><?php echo esc_html( $prop_garden_paras[0] ); ?></p>
			<?php endif; ?>
		  </header>
		  <?php
			foreach ( array_slice( $prop_garden_paras, 1 ) as $prop_garden_para ) :
				?>
		  <p class="lede"><?php echo esc_html( $prop_garden_para ); ?></p>
				<?php
			endforeach;
			?>
		</div>
	  </div>
	</section>

	<section class="section-y band-white" id="photos" data-gallery>
	  <div class="container">
		<header class="section-head section-head--tight">
		  <?php if ( '' !== $prop_gallery_label ) : ?>
		  <p class="eyebrow"><?php echo esc_html( $prop_gallery_label ); ?></p>
		  <?php endif; ?>
		  <h2><?php echo esc_html( $prop_gallery_heading ); ?></h2>
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

	<section class="section-y section-y--compact band-teal" id="care" aria-labelledby="care-h">
	  <div class="container">
		<div class="band-teal__stack band-teal__stack--tease">
		  <p class="eyebrow eyebrow--on-dark"><?php esc_html_e( 'Optional care', 'restwell-retreats' ); ?></p>
		  <h2 id="care-h"><?php echo esc_html( $prop_care_heading ); ?></h2>
		  <p class="lede"><?php echo esc_html( $prop_care_body ); ?></p>
		  <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'optional-care' ) ); ?>"><?php esc_html_e( 'How optional care works', 'restwell-retreats' ); ?></a>
		</div>
	  </div>
	</section>

	<section class="section-y band-white" id="location" aria-labelledby="location-h">
	  <div class="container split">
		<div>
		  <header class="section-head section-head--tight">
			<p class="eyebrow">Location</p>
			<h2 id="location-h"><?php echo esc_html( $prop_location_heading ); ?></h2>
			<?php if ( ! empty( $prop_location_paras[0] ) ) : ?>
			<p class="lede"><?php echo esc_html( $prop_location_paras[0] ); ?></p>
			<?php endif; ?>
		  </header>
		  <?php
			foreach ( array_slice( $prop_location_paras, 1 ) as $prop_location_para ) :
				?>
		  <p class="lede"><?php echo esc_html( $prop_location_para ); ?></p>
				<?php
			endforeach;
			?>
		  <p class="lede">For route tips, local recommendations, and access details, check our <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'whitstable-area-guide' ) ); ?>">Whitstable accessibility guide</a>.</p>
		</div>
		<div class="split__media">
		  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/WHIT-SEAFRONT-1-LS.jpg' ) ); ?>" alt="Tankerton promenade and Whitstable seafront" width="900" height="675" loading="lazy" />
		</div>
	  </div>
	</section>
	<?php
	$mid_cta_heading = $prop_txt( 'prop_cta_heading', __( 'See if the bungalow fits your group.', 'restwell-retreats' ) );
	$mid_cta_intro   = $prop_txt(
		'prop_cta_body',
		__( 'Tell us your preferred dates, group size, and any access or equipment needs. We’ll reply with availability, measurements, equipment details, and your next steps.', 'restwell-retreats' )
	);
	$mid_cta_primary_label = $prop_txt( 'prop_cta_btn', __( 'Enquire', 'restwell-retreats' ) );
	$mid_cta_primary_url   = $prop_txt( 'prop_cta_url', restwell_nav_resolve_page_url( 'enquire' ) );

	$mid_cta_secondary_label = __( 'Read accessibility details', 'restwell-retreats' );
	$mid_cta_secondary_url   = restwell_nav_resolve_page_url( 'accessibility' );

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
