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

$restwell_prop_heading = $prop_heading( 'prop_hero_heading', 'Inside the accessible bungalow, room by room' );
$restwell_prop_intro   = $prop_txt(
	'prop_hero_subtitle',
	'Here’s a walk round Restwell, room by room. It’s a single-storey adapted bungalow on a quiet street in Whitstable. It has two bedrooms and space for up to five people.'
);

$prop_bedrooms_heading = $prop_heading( 'prop_bedrooms_section_heading', 'Two bedrooms and a sofa bed, for up to five' );
$prop_bedrooms_paras   = $prop_paras(
	$prop_txt(
		'prop_bedrooms_section_body',
		"The accessible bedroom has a ceiling track hoist that covers the whole room. We set it up with one or two profiling beds, depending on what you tell us when you book.\n\nIf you’d like the furniture arranged like your room at home, just say, and we’ll have it ready.\n\nThe second bedroom next door has a double bed. The conservatory has a double sofa bed, so up to five people can stay. The hoists, the standing aid and the profiling beds are all included in the price."
	)
);

$prop_wetroom_heading = $prop_heading( 'prop_wetroom_heading', 'Level-access wet room' );
$prop_wetroom_paras   = $prop_paras(
	$prop_txt(
		'prop_wetroom_body',
		"The wet room is step-free from the door to the shower. It has grab rails, a shower stool and a tilt-in-space shower chair. There’s also a wash-and-dry toilet, and a basin that swings round and moves up and down.\n\nIt’s all fitted already, so there’s nothing to hire or set up before you arrive. You’ll find the makes, models and safe working loads on the Accessibility page."
	)
);

$prop_living_heading = $prop_heading( 'prop_living_heading', 'Open-plan living room' );
$prop_living_paras   = $prop_paras(
	$prop_txt(
		'prop_living_body',
		"The living room is open-plan, with a rise-and-recline armchair, a sofa with pull-out footrests and a TV with Netflix. There’s room for wheelchairs, carers and family to get past each other.\n\nWe keep the floor between the sofa and the armchair clear, so a wheelchair can turn. There’s free high-speed WiFi throughout. That matters more than people admit if you need to keep an eye on work or a hospital app."
	)
);

$prop_kitchen_heading = $prop_heading( 'prop_kitchen_heading', 'Kitchen with a wheel-under worktop' );
$prop_kitchen_paras   = $prop_paras(
	$prop_txt(
		'prop_kitchen_body',
		"The kitchen has a lowered worktop you can wheel under, and an oven whose door slides away underneath. There’s also a microwave, a fridge and a dishwasher, plus plates, pans, cutlery and the cooking basics.\n\nThe hob is gas rather than induction, which is worth knowing when you plan what to cook."
	)
);

$prop_conservatory_heading = $prop_heading( 'prop_conservatory_heading', 'Conservatory with level access to the patio' );
$prop_conservatory_paras   = $prop_paras(
	$prop_txt(
		'prop_conservatory_body',
		"The conservatory has a fold-out table to eat at and a double sofa bed. Its doors open out level onto the patio.\n\nThe laundry cupboards are in here too, with a washing machine and a tumble dryer."
	)
);

$prop_garden_heading = $prop_heading( 'prop_garden_heading', 'Level patio, enclosed garden, and private driveway' );
$prop_garden_paras   = $prop_paras(
	$prop_txt(
		'prop_garden_body',
		"French doors open onto a level patio, with a non-slip ramp over the threshold. The garden is fully enclosed, with outdoor seating, a barbecue and fairy lights.\n\nDogs are welcome. Please let us know before you arrive, so we can do a quick risk assessment.\n\nAt the front there’s a level, resin-bound driveway with space for two cars. We’ve tested it with two wheelchair-accessible vehicles. Portable ramps are kept in the outdoor box by the front door, for the house or for days out."
	)
);

$prop_gallery_label   = $prop_txt( 'prop_gallery_label', 'Photos' );
$prop_gallery_heading = $prop_heading( 'prop_gallery_heading', 'More photos of the bungalow' );

$prop_care_heading = $prop_heading( 'prop_care_heading', 'Care in the bungalow, if you need it' );
$prop_care_body    = $prop_txt(
	'prop_care_body',
	'If someone in your group needs help with personal care, our sister company, Continuity, can come into the bungalow. They’ll give you a quote once you’ve talked through what’s needed. Plenty of guests bring their own carer, and the second bedroom is there for them.'
);
// Pages seeded before the 9 Oct 2026 wording pass still hold the old line in meta.
if ( 'Home care from Continuity can be added on the same enquiry, and they’ll quote for it. Bring your own carer if you prefer.' === $prop_care_body ) {
	$prop_care_body = 'If someone in your group needs help with personal care, our sister company, Continuity, can come into the bungalow. They’ll give you a quote once you’ve talked through what’s needed. Plenty of guests bring their own carer, and the second bedroom is there for them.';
}

$prop_location_heading = $prop_heading( 'prop_location_heading', 'On a quiet street, ten minutes from the seafront' );
$prop_location_paras   = $prop_paras(
	$prop_txt(
		'prop_location_body',
		"The bungalow is on a quiet residential street, a short walk from The Plough pub. The seafront is about ten minutes away on foot.\n\nThe beach there is shingle, but the wide, paved promenade gives you a step-free route along the coast."
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
		  <li><a href="#rooms">Rooms</a></li>
		  <li><a href="#photos">Photos</a></li>
		  <li><a href="#location">Location</a></li>
		  <li><a href="#care">Care</a></li>
		</ul>
	  </div>
	</nav>

	<?php
	// Room by room (20 Oct 2026): one section with the rooms as tabs, a large
	// photo and a white card over its corner, in place of six identical
	// photo-and-text rows. Uses the [data-tabs] script in shared.js: without
	// it every room is shown in turn. Each panel keeps its old id, so links to
	// #wetroom or #garden still open that room.
	$prop_wetroom_link = static function ( $para ) {
		// The spec belongs to /accessibility/: link the phrase that points there.
		return str_replace(
			esc_html__( 'makes, models and safe working loads', 'restwell-retreats' ),
			'<a class="text-link" href="' . esc_url( restwell_nav_resolve_page_url( 'accessibility' ) ) . '">' . esc_html__( 'makes, models and safe working loads', 'restwell-retreats' ) . '</a>',
			esc_html( $para )
		);
	};
	// WiFi is listed in the LodgingBusiness amenities, so it has to be on the
	// page too (audit I17). Wording is verbatim from copy-overwrites/the-property.md.
	if ( false === stripos( implode( ' ', $prop_living_paras ), 'wifi' ) ) {
		$prop_living_paras[] = __( 'There’s free high-speed WiFi throughout, which matters more than people admit when someone in the party needs to keep an eye on work or a hospital app.', 'restwell-retreats' );
	}
	$prop_rooms = array(
		array( 'bedrooms', __( 'Bedrooms', 'restwell-retreats' ), $prop_bedrooms_heading, $prop_bedrooms_paras, 'bungalow/BD2-2-LS.jpg', 2400, 1500, 'Accessible bedroom with two profiling beds and coastal bedding' ),
		array( 'wetroom', __( 'Wet room', 'restwell-retreats' ), $prop_wetroom_heading, $prop_wetroom_paras, 'bungalow/WR-1-LS.jpg', 2400, 1500, 'Level-access wet room with grab rails' ),
		array( 'living', __( 'Living room', 'restwell-retreats' ), $prop_living_heading, $prop_living_paras, 'bungalow/LR-1-LS.jpg', 2400, 1500, 'Open-plan living room with rise-and-recline chair and wide walkways' ),
		array( 'kitchen', __( 'Kitchen', 'restwell-retreats' ), $prop_kitchen_heading, $prop_kitchen_paras, 'bungalow/KT-1-LS.jpg', 2400, 1500, 'Kitchen with lowered wheel-under worksurface' ),
		array( 'conservatory', __( 'Conservatory', 'restwell-retreats' ), $prop_conservatory_heading, $prop_conservatory_paras, 'bungalow/SB-1-LS.jpg', 6000, 3750, 'The conservatory: the sofa bed under the windows on level wood flooring' ),
		array( 'garden', __( 'Outside', 'restwell-retreats' ), $prop_garden_heading, $prop_garden_paras, 'journey/guest-garden-path.jpg', 1125, 1500, 'A guest in a powered wheelchair on the level resin path through the enclosed garden' ),
	);
	?>
	<section class="section-y band-white" id="rooms" aria-label="<?php esc_attr_e( 'Room by room', 'restwell-retreats' ); ?>">
	  <div class="container">
		<div class="room-tour" data-tabs>
		  <div class="room-tour__nav">
			<p class="room-tour__intro"><?php esc_html_e( 'Everything is on one level. Choose a room to see what’s in it.', 'restwell-retreats' ); ?></p>
			<div class="room-tour__tabs" role="tablist" aria-label="<?php esc_attr_e( 'Rooms', 'restwell-retreats' ); ?>" hidden>
			  <?php foreach ( $prop_rooms as $prop_room_i => $prop_room ) : ?>
			  <button type="button" role="tab" id="room-tab-<?php echo esc_attr( $prop_room[0] ); ?>" aria-controls="<?php echo esc_attr( $prop_room[0] ); ?>" aria-selected="<?php echo 0 === $prop_room_i ? 'true' : 'false'; ?>"<?php echo 0 === $prop_room_i ? '' : ' tabindex="-1"'; ?>><?php echo esc_html( $prop_room[1] ); ?></button>
			  <?php endforeach; ?>
			</div>
		  </div>
		  <div class="room-tour__panels">
			<?php foreach ( $prop_rooms as $prop_room ) : ?>
			<article class="room-tour__panel room-tour__panel--<?php echo esc_attr( $prop_room[0] ); ?>" id="<?php echo esc_attr( $prop_room[0] ); ?>">
			  <img class="room-tour__photo" src="<?php echo esc_url( restwell_theme_image_url( $prop_room[4] ) ); ?>" alt="<?php echo esc_attr( $prop_room[7] ); ?>" width="<?php echo (int) $prop_room[5]; ?>" height="<?php echo (int) $prop_room[6]; ?>" sizes="(min-width: 1200px) 860px, 100vw" loading="lazy" decoding="async" />
			  <div class="room-tour__card">
				<h2><?php echo esc_html( $prop_room[2] ); ?></h2>
				<?php foreach ( $prop_room[3] as $prop_room_para ) : ?>
				<p><?php echo 'wetroom' === $prop_room[0] ? wp_kses_post( $prop_wetroom_link( $prop_room_para ) ) : esc_html( $prop_room_para ); ?></p>
				<?php endforeach; ?>
				<?php if ( 'bedrooms' === $prop_room[0] ) : ?>
				<p class="room-tour__link"><a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'accessibility' ) ); ?>"><?php esc_html_e( 'Door widths and the hoist', 'restwell-retreats' ); ?></a></p>
				<?php endif; ?>
			  </div>
			</article>
			<?php endforeach; ?>
		  </div>
		</div>
	  </div>
	</section>

	<section class="section-y band-subtle" id="photos" data-gallery>
	  <div class="container">
		<header class="section-head section-head--tight">
		  <?php if ( '' !== $prop_gallery_label ) : ?>
		  <p class="eyebrow"><?php echo esc_html( $prop_gallery_label ); ?></p>
		  <?php endif; ?>
		  <h2><?php echo esc_html( $prop_gallery_heading ); ?></h2>
		</header>
		<?php // A mosaic (20 Oct 2026): the garden leads large, the rest sit round it. ?>
		<ul class="gallery-grid gallery-grid--mosaic" role="list" aria-label="Property photos">
		  <li>
			<button type="button" class="gallery__open" data-gallery-open data-gallery-index="0" aria-label="View full size: Enclosed garden and level patio">
			  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/GRDEN-1-LS.jpg' ) ); ?>" alt="Enclosed garden and level patio" width="640" height="480" loading="lazy" decoding="async" />
			</button>
		  </li>
		  <li>
			<button type="button" class="gallery__open" data-gallery-open data-gallery-index="1" aria-label="View full size: Level-access wet room shower with the tilt-in-space shower chair and a grab rail">
			  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/wet-room-shower.png' ) ); ?>" alt="Level-access wet room shower with the tilt-in-space shower chair and a grab rail" width="640" height="480" loading="lazy" decoding="async" />
			</button>
		  </li>
		  <li>
			<button type="button" class="gallery__open" data-gallery-open data-gallery-index="2" aria-label="View full size: Accessible bedroom with ceiling track and mobile hoist">
			  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/BD2-3-LS.jpg' ) ); ?>" alt="Accessible bedroom with ceiling track and mobile hoist" width="640" height="480" loading="lazy" decoding="async" />
			</button>
		  </li>
		  <li>
			<button type="button" class="gallery__open" data-gallery-open data-gallery-index="3" aria-label="View full size: Second double bedroom">
			  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/BD1-1-LS.jpg' ) ); ?>" alt="Second double bedroom" width="640" height="480" loading="lazy" decoding="async" />
			</button>
		  </li>
		  <li>
			<button type="button" class="gallery__open" data-gallery-open data-gallery-index="4" aria-label="View full size: Kitchen with wheel-under worksurface">
			  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/KT-1-LS.jpg' ) ); ?>" alt="Kitchen with wheel-under worksurface" width="640" height="480" loading="lazy" decoding="async" />
			</button>
		  </li>
		  <li>
			<button type="button" class="gallery__open" data-gallery-open data-gallery-index="5" aria-label="View full size: Open-plan living room with wide walkways">
			  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/living-room-2.png' ) ); ?>" alt="Open-plan living room with wide walkways" width="640" height="480" loading="lazy" decoding="async" />
			</button>
		  </li>
		  <li>
			<button type="button" class="gallery__open" data-gallery-open data-gallery-index="6" aria-label="View full size: Rise-and-recline armchair in the living room">
			  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/RAR-1-LS.jpg' ) ); ?>" alt="Rise-and-recline armchair in the living room" width="640" height="480" loading="lazy" decoding="async" />
			</button>
		  </li>
		  <li>
			<button type="button" class="gallery__open" data-gallery-open data-gallery-index="7" aria-label="View full size: Conservatory doors opening toward the living space">
			  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/conservatory-doors.png' ) ); ?>" alt="Conservatory doors opening toward the living space" width="640" height="480" loading="lazy" decoding="async" />
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


	<section class="section-y band-white" id="location" aria-labelledby="location-h">
	  <div class="container">
		<?php // Home's overlapping panel (20 Oct 2026), mirrored: the seafront photo on the right. ?>
		<div class="property__layout property__layout--flip">
		  <div class="property__copy">
			<h2 id="location-h"><?php echo esc_html( $prop_location_heading ); ?></h2>
			<?php foreach ( $prop_location_paras as $prop_location_para ) : ?>
			<p class="lede"><?php echo esc_html( $prop_location_para ); ?></p>
			<?php endforeach; ?>
			<p class="lede">Our <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'whitstable-area-guide' ) ); ?>">Whitstable guide</a> covers where to eat, where to park and which places have an accessible loo.</p>
		  </div>
		  <img class="property__photo" src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/WHIT-SEAFRONT-1-LS.jpg' ) ); ?>" alt="Tankerton promenade and Whitstable seafront" width="2400" height="1500" sizes="(min-width: 960px) 760px, 100vw" loading="lazy" decoding="async" />
		</div>
	  </div>
	</section>

	<?php
	// Optional care (20 Oct 2026): Home's teal card with Keelie and Nikki, laid
	// out wide, in place of two small round faces. Photos published with consent.
	$prop_care_team = array(
		array( 'journey/keelie-varney.webp', 1500, 'Keelie Varney' ),
		array( 'journey/nikki-mackay.webp', 1429, 'Nikki Mackay' ),
	);
	?>
	<section class="section-y band-subtle" id="care" aria-labelledby="care-h">
	  <div class="container">
		<div class="care-choice care-choice--continuity care-choice--wide">
		  <div class="care-choice__team">
			<?php foreach ( $prop_care_team as $prop_care_person ) : ?>
			<figure>
			  <img src="<?php echo esc_url( restwell_theme_image_url( $prop_care_person[0] ) ); ?>" alt="" width="<?php echo (int) $prop_care_person[1]; ?>" height="2000" sizes="(min-width: 900px) 220px, 42vw" loading="lazy" decoding="async" />
			  <figcaption><?php echo esc_html( $prop_care_person[2] ); ?></figcaption>
			</figure>
			<?php endforeach; ?>
		  </div>
		  <div class="care-choice__text">
			<h2 id="care-h"><?php echo esc_html( $prop_care_heading ); ?></h2>
			<p><?php echo esc_html( $prop_care_body ); ?></p>
			<a class="care-choice__link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'optional-care' ) ); ?>"><?php esc_html_e( 'How optional care works', 'restwell-retreats' ); ?> <span aria-hidden="true">&rarr;</span></a>
		  </div>
		</div>
	  </div>
	</section>
	<?php
	$mid_cta_heading = $prop_txt( 'prop_cta_heading', __( 'See if the bungalow fits your group', 'restwell-retreats' ) );
	$mid_cta_intro   = $prop_txt(
		'prop_cta_body',
		__( 'Tell us your dates, who’s coming and any access or equipment needs. We’ll come back with availability and an honest answer on whether the house will work for you.', 'restwell-retreats' )
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
