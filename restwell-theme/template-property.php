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

$restwell_prop_heading = $prop_heading( 'prop_hero_heading', 'Inside the bungalow, room by room' );
$restwell_prop_intro   = $prop_txt(
	'prop_hero_subtitle',
	'Here’s a walk round Restwell, room by room. It’s a single-storey adapted bungalow on a quiet street in Whitstable, with two bedrooms and space for up to five people.'
);

$prop_bedrooms_heading = $prop_heading( 'prop_bedrooms_section_heading', 'Two bedrooms and a sofa bed, for up to five' );
$prop_bedrooms_paras   = $prop_paras(
	$prop_txt(
		'prop_bedrooms_section_body',
		"The accessible bedroom has a ceiling track hoist that covers the whole room, and we set it up with one or two profiling beds, depending on what you tell us when you book. If you’d like the furniture moved to match the way things are at home, just say, and it’ll be ready when you arrive.\n\nThe second bedroom next door has a double bed, and the conservatory has a double sofa bed, so up to five people can stay. The hoists, the standing aid and the profiling beds are all included in the price."
	)
);

$prop_wetroom_heading = $prop_heading( 'prop_wetroom_heading', 'Level-access wet room' );
$prop_wetroom_paras   = $prop_paras(
	$prop_txt(
		'prop_wetroom_body',
		"The wet room is step-free from the door to the shower. It has grab rails, a shower stool and a tilt-in-space shower chair, a basin that swings round and moves up and down to the height you need, and a wash-and-dry toilet.\n\nIt’s all fitted already, so there’s nothing to hire or set up before you arrive. If you’d like the makes, models and safe working loads, you’ll find them on the Accessibility page."
	)
);

$prop_living_heading = $prop_heading( 'prop_living_heading', 'Open-plan living room' );
$prop_living_paras   = $prop_paras(
	$prop_txt(
		'prop_living_body',
		"The living room is open-plan, with a rise-and-recline armchair, a sofa with pull-out footrests and a TV with Netflix. There’s room for wheelchairs, carers and family to get past each other.\n\nWe keep the floor between the sofa and the armchair clear so a wheelchair can turn. There’s free high-speed WiFi throughout, which matters more than people admit when someone needs to keep an eye on work or a hospital app."
	)
);

$prop_kitchen_heading = $prop_heading( 'prop_kitchen_heading', 'Kitchen with a wheel-under worktop' );
$prop_kitchen_paras   = $prop_paras(
	$prop_txt(
		'prop_kitchen_body',
		"The kitchen has a lowered worktop you can wheel under, an oven with a door that slides away underneath, a microwave, a fridge and a dishwasher. You’ll also find plates, pans, cutlery and the cooking basics.\n\nThe hob is gas rather than induction, which is worth knowing when you plan what to cook."
	)
);

$prop_conservatory_heading = $prop_heading( 'prop_conservatory_heading', 'Conservatory with level access to the patio' );
$prop_conservatory_paras   = $prop_paras(
	$prop_txt(
		'prop_conservatory_body',
		"The conservatory has a fold-out table to eat at and a double sofa bed, and its doors open out level onto the patio.\n\nThe laundry cupboards are in here too, with a washing machine and a tumble dryer."
	)
);

$prop_garden_heading = $prop_heading( 'prop_garden_heading', 'Level patio, enclosed garden, and private driveway' );
$prop_garden_paras   = $prop_paras(
	$prop_txt(
		'prop_garden_body',
		"French doors open onto a level patio, with a non-slip ramp over the threshold. The garden is fully enclosed, with outdoor seating, a barbecue and fairy lights.\n\nDogs are welcome, and we just ask you to let us know before you arrive so we can do a quick risk assessment.\n\nAt the front there’s a level, resin-bound driveway with space for two cars, and we’ve tested it with two wheelchair-accessible vehicles. Portable ramps are kept in the outdoor box by the front door, for use around the house or on days out."
	)
);

$prop_gallery_label   = $prop_txt( 'prop_gallery_label', 'Photos' );
$prop_gallery_heading = $prop_heading( 'prop_gallery_heading', 'More photos of the bungalow' );

$prop_care_heading = $prop_heading( 'prop_care_heading', 'Optional home care' );
$prop_care_body    = $prop_txt(
	'prop_care_body',
	'If someone in your group needs help with personal care, our sister company, Continuity, can come into the bungalow, and they’ll quote once you’ve talked through what’s needed. Plenty of guests bring their own carer instead, and the second bedroom is there for them.'
);
// Pages seeded before the 9 Oct 2026 wording pass still hold the old line in meta.
if ( 'Home care from Continuity can be added on the same enquiry, and they’ll quote for it. Bring your own carer if you prefer.' === $prop_care_body ) {
	$prop_care_body = 'If someone in your group needs help with personal care, our sister company, Continuity, can come into the bungalow, and they’ll quote once you’ve talked through what’s needed. Plenty of guests bring their own carer instead, and the second bedroom is there for them.';
}

$prop_location_heading = $prop_heading( 'prop_location_heading', 'On a quiet street, ten minutes from the seafront' );
$prop_location_paras   = $prop_paras(
	$prop_txt(
		'prop_location_body',
		"The bungalow is on a quiet residential street, a short walk from The Plough pub and about ten minutes on foot from the seafront. Down there, the wide, paved promenade gives you a step-free route along the coast.\n\nThe beach is shingle, so the paved promenade is the step-free way along the seafront."
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
		  <li><a href="#location">Location</a></li>
		  <li><a href="#care">Care</a></li>
		</ul>
	  </div>
	</nav>

	<section class="section-y band-white" id="rooms" aria-labelledby="rooms-h">
	  <div class="container split split--media-first split--fill">
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
		  <p><a class="text-link text-link--standalone" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'accessibility' ) ); ?>">Door widths and the hoist</a></p>
		</div>
	  </div>
	</section>

	<section class="section-y band-subtle" id="wetroom" aria-labelledby="wetroom-h">
	  <div class="container split split--flip split--media-first split--fill">
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
		  <p class="lede">
					<?php
					// The spec belongs to /accessibility/: link the phrase that points there.
					echo wp_kses_post(
						str_replace(
							esc_html__( 'makes, models and safe working loads', 'restwell-retreats' ),
							'<a class="text-link" href="' . esc_url( restwell_nav_resolve_page_url( 'accessibility' ) ) . '">' . esc_html__( 'makes, models and safe working loads', 'restwell-retreats' ) . '</a>',
							esc_html( $prop_wetroom_para )
						)
					);
					?>
		  </p>
				<?php
			endforeach;
			?>
		</div>
	  </div>
	</section>

	<section class="section-y band-white" id="living" aria-labelledby="living-h">
	  <div class="container split split--media-first split--fill">
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
			// WiFi is listed in the LodgingBusiness amenities, so it has to be on the
			// page too (audit I17). Wording is verbatim from copy-overwrites/the-property.md.
			if ( false === stripos( implode( ' ', $prop_living_paras ), 'wifi' ) ) :
				?>
		  <p class="lede"><?php esc_html_e( 'There’s free high-speed WiFi throughout, which matters more than people admit when someone in the party needs to keep an eye on work or a hospital app.', 'restwell-retreats' ); ?></p>
			<?php endif; ?>
		</div>
	  </div>
	</section>

	<section class="section-y band-subtle" id="kitchen" aria-labelledby="kitchen-h">
	  <div class="container split split--flip split--media-first split--fill">
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
	  <div class="container split split--media-first split--fill">
		<div class="split__media">
		  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/SB-1-LS.jpg' ) ); ?>" alt="The conservatory: the sofa bed under the windows on level wood flooring" width="2400" height="1500" loading="lazy" decoding="async" />
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
	  <div class="container split split--flip split--media-first split--fill">
		<div class="split__media">
		  <img class="media-guest-garden" src="<?php echo esc_url( restwell_theme_image_url( 'journey/guest-garden-path.jpg' ) ); ?>" alt="A guest in a powered wheelchair on the level resin path through the enclosed garden" width="1125" height="1500" loading="lazy" decoding="async" />
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
			<button type="button" class="gallery__open" data-gallery-open data-gallery-index="0" aria-label="View full size: Level-access wet room shower with the tilt-in-space shower chair and a grab rail">
			  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/wet-room-shower.png' ) ); ?>" alt="Level-access wet room shower with the tilt-in-space shower chair and a grab rail" width="640" height="480" loading="lazy" decoding="async" />
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


	<section class="section-y band-subtle" id="location" aria-labelledby="location-h">
	  <div class="container split split--fill">
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
		  <p class="lede">Our <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'whitstable-area-guide' ) ); ?>">Whitstable guide</a> covers where to eat, where to park and which places have an accessible loo.</p>
		</div>
		<div class="split__media">
		  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/WHIT-SEAFRONT-1-LS.jpg' ) ); ?>" alt="Tankerton promenade and Whitstable seafront" width="900" height="675" loading="lazy" />
		</div>
	  </div>
	</section>

	<section class="section-y section-y--slim band-white care-pointer" id="care" aria-labelledby="care-h">
	  <div class="container">
		<div class="care-pointer__card">
		  <?php get_template_part( 'template-parts/care-faces' ); ?>
		  <p class="eyebrow"><?php esc_html_e( 'Optional care', 'restwell-retreats' ); ?></p>
		  <h2 id="care-h"><?php echo esc_html( $prop_care_heading ); ?></h2>
		  <p class="lede"><?php echo esc_html( $prop_care_body ); ?></p>
		  <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'optional-care' ) ); ?>"><?php esc_html_e( 'How optional care works', 'restwell-retreats' ); ?><?php restwell_the_icon( 'arrow-right' ); ?></a>
		</div>
	  </div>
	</section>
	<?php
	$mid_cta_heading = $prop_txt( 'prop_cta_heading', __( 'See if the bungalow fits your group', 'restwell-retreats' ) );
	$mid_cta_intro   = $prop_txt(
		'prop_cta_body',
		__( 'Tell us your dates, who’s coming and any access or equipment needs, and we’ll come back with availability and an honest answer on whether the house will work for you.', 'restwell-retreats' )
	);
	$mid_cta_primary_label = $prop_txt( 'prop_cta_btn', __( 'Enquire', 'restwell-retreats' ) );
	$mid_cta_primary_url   = $prop_txt( 'prop_cta_url', restwell_nav_resolve_page_url( 'enquire' ) );

	$mid_cta_secondary_label = __( 'See prices and dates', 'restwell-retreats' );
	$mid_cta_secondary_url   = restwell_nav_resolve_page_url( 'pricing' );

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
