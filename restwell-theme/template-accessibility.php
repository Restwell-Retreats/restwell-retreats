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

$restwell_acc_id = (int) get_queried_object_id();

$acc_txt = static function ( $key, $fallback ) use ( $restwell_acc_id ) {
	return function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_acc_id, $key, $fallback )
		: $fallback;
};

$restwell_acc_label   = $acc_txt( 'acc_label', 'Accessibility' );
$restwell_acc_heading = $acc_txt( 'acc_heading', 'The wet room, the hoists, and every measurement' );
$restwell_acc_intro   = $acc_txt(
	'acc_intro',
	'The full access statement for Restwell: exact door widths, hoist capacity and the level-access wet room.'
);

$acc_room_label   = $acc_txt( 'acc_room_label', 'Access statement' );
$acc_room_heading = $acc_txt( 'acc_room_heading', 'Room by room' );
$acc_room_intro   = $acc_txt(
	'acc_room_intro',
	'Photos of each space, with the confirmed measurements and kit from our property equipment register.'
);
$acc_room_cards   = array(
	array(
		'id'      => 'arrival',
		'nav'     => __( 'Arrival', 'restwell-retreats' ),
		'heading' => $acc_txt( 'acc_arrival_heading', 'Arrival & entrance' ),
		'body'    => $acc_txt(
			'acc_arrival_body',
			"Private resin-bound driveway: two off-road spaces (adapted vehicles welcome)\nOn-street parking outside if you need extra room. No residents permit on this road; check signs on arrival in case street rules change\nStep-free path from car to front door\nPorch outer doors 1720mm opening, with a full-width ribbed entrance mat\nInner front door 965mm clear; level threshold, no step\nPortable fold-up ramps kept for the front door — yours for the stay, including days out"
		),
		'photos'  => array(
			array(
				'src' => 'bungalow/FD-1-LS.jpg',
				'alt' => 'Front door with a wide, level threshold',
			),
			array(
				'src' => 'bungalow/entrance.webp',
				'alt' => 'Resin-bound driveway and porch approach',
			),
			array(
				'src' => 'bungalow/int-front-door.webp',
				'alt' => 'Inner front door clear opening',
			),
			array(
				'src' => 'bungalow/exterior-ramp.png',
				'alt' => 'Portable ramp at the entrance',
			),
		),
		'eager'   => true,
	),
	array(
		'id'      => 'inside',
		'nav'     => __( 'Inside', 'restwell-retreats' ),
		'heading' => $acc_txt( 'acc_inside_heading', 'Inside the property' ),
		'body'    => $acc_txt(
			'acc_inside_body',
			"All internal doors 926mm clear (white doors with black lever handles for contrast)\nOpen-plan ground floor, no internal steps\nLevel flooring throughout (no carpet lips)\nWet room on the same level as the accessible bedroom"
		),
		'photos'  => array(
			array(
				'src' => 'bungalow/LR-2-LS.jpg',
				'alt' => 'Open-plan living space with wide hall routes between furniture',
			),
			array(
				'src' => 'bungalow/LR-1-LS.jpg',
				'alt' => 'Living room walkways kept clear for turning',
			),
			array(
				'src' => 'bungalow/living-room-2.png',
				'alt' => 'Open-plan lounge looking toward the kitchen',
			),
		),
		'eager'   => false,
	),
	array(
		'id'      => 'bedrooms',
		'nav'     => __( 'Bedrooms', 'restwell-retreats' ),
		'heading' => $acc_txt( 'acc_bedroom_heading', 'Bedrooms & sleeping' ),
		'body'    => $acc_txt(
			'acc_bedroom_body',
			"Amico GoLift 400 ceiling track hoist: full-room coverage, 180kg SWL. Guests bring their own slings\nOxford Midi 180 mobile hoist, also rated to 180kg\nAccora CommunityBed profiling bed, maximum user weight 180kg; a second profiling bed on request\nAAL RS4 standing aid, rated to 185kg. Sleeps up to five (two bedrooms + conservatory sofa bed)\n---\nPressure-relieving mattress: Accora Allevia Comfort FirmEdge or Roma Medical MATT 1\nSpace for a carer on both sides of the bed\nSecond bedroom for additional guests or a support worker\nConservatory double sofa bed — tell us your party layout when you enquire"
		),
		'photos'  => array(
			array(
				'src' => 'bungalow/BD2-2-LS.jpg',
				'alt' => 'Adjustable profiling beds in the accessible bedroom',
			),
			array(
				'src' => 'bungalow/BD2-3-LS.jpg',
				'alt' => 'Accessible bedroom with ceiling track and mobile hoist',
			),
			array(
				'src' => 'bungalow/H-1-LS.jpg',
				'alt' => 'Ceiling track hoist over the profiling bed',
			),
			array(
				'src' => 'bungalow/BD1-1-LS.jpg',
				'alt' => 'Second double bedroom',
			),
			array(
				'src' => 'bungalow/BD2-6-LS.jpg',
				'alt' => 'Amico ceiling track hoist over the profiling bed',
			),
		),
		'eager'   => false,
	),
	array(
		'id'      => 'wetroom',
		'nav'     => __( 'Wet room', 'restwell-retreats' ),
		'heading' => $acc_txt( 'acc_bathroom_heading', 'Wet room' ),
		'body'    => $acc_txt(
			'acc_bathroom_body',
			"Level-access wet room with no lip. Layout and specification by <a href=\"https://www.carespaces.co.uk/\" target=\"_blank\" rel=\"noopener noreferrer\">Care Spaces</a>\nMira Select Flex TMV3 thermostatic shower, RNIB Tried & Tested\nRaz Design RAZ-AT tilt-in-space shower commode; Drive DeVilbiss stool rated to 136kg\nRopox Swing washbasin 750–950mm; Geberit AquaClean Mera Care wash-dry WC\n---\nNYMAS hinged lift-and-lock toilet support rail with drop-down leg\nPull-cord assistance alarm with reset plate and over-door light\nFloor-level drain, extractor fan, and a bin for continence products (emptied between stays)"
		),
		'photos'  => array(
			array(
				'src' => 'bungalow/WR-1-LS.jpg',
				'alt' => 'Level-access wet room with grab rails',
			),
			array(
				'src' => 'bungalow/wet-room-shower.png',
				'alt' => 'Level-access wet room shower with grab rails and fold-down seat',
			),
			array(
				'src' => 'bungalow/WR-2-LS.jpg',
				'alt' => 'Wet room grab rails and shower',
			),
			array(
				'src' => 'bungalow/WR-3-LS.jpg',
				'alt' => 'Wet room toilet and support rail',
			),
			array(
				'src' => 'bungalow/adjustable-sink.png',
				'alt' => 'Height-adjustable Ropox washbasin',
			),
		),
		'eager'   => false,
	),
	array(
		'id'      => 'kitchen',
		'nav'     => __( 'Kitchen', 'restwell-retreats' ),
		'heading' => $acc_txt( 'acc_kitchen_heading', 'Kitchen' ),
		'body'    => $acc_txt(
			'acc_kitchen_body',
			"Open-plan kitchen with wheelchair access and reachable worktops\nNEFF Slide & Hide oven — the door folds away underneath so you are not reaching across a hot open door from a seated position\nGas hob (not induction). No electromagnetic field from the cooktop, which many guests with pacemakers prefer\nMicrowave and accessible storage at lower levels"
		),
		'photos'  => array(
			array(
				'src' => 'bungalow/KT-1-LS.jpg',
				'alt' => 'Kitchen with a reachable, wheel-under worksurface',
			),
			array(
				'src' => 'bungalow/kitchen.webp',
				'alt' => 'Open-plan kitchen looking toward the living space',
			),
			array(
				'src' => 'bungalow/kitchen-portrait-view.webp',
				'alt' => 'Kitchen worktops and NEFF Slide & Hide oven',
			),
		),
		'eager'   => false,
	),
	array(
		'id'      => 'outdoor',
		'nav'     => __( 'Outside', 'restwell-retreats' ),
		'heading' => $acc_txt( 'acc_outdoor_heading', 'Outdoor spaces' ),
		'body'    => $acc_txt(
			'acc_outdoor_body',
			"Conservatory French doors 1720mm opening\nRear French doors 1720mm opening onto the patio, with a non-slip threshold ramp 20mm high × 80mm wide\nLevel patio with hard-standing suitable for wheelchairs\nEnclosed garden and BBQ area beyond the patio"
		),
		'photos'  => array(
			array(
				'src' => 'bungalow/GRDEN-1-LS.jpg',
				'alt' => 'Level garden and patio beyond the conservatory',
			),
			array(
				'src' => 'bungalow/PT-1-LS.jpg',
				'alt' => 'Level patio and enclosed dog-friendly garden',
			),
			array(
				'src' => 'bungalow/GRDEN-2-LS.jpg',
				'alt' => 'Conservatory with level access to the resin patio',
			),
			array(
				'src' => 'bungalow/conservatory-patio-doors.webp',
				'alt' => 'Conservatory patio doors opening onto the garden',
			),
			array(
				'src' => 'bungalow/ext-patio-door.webp',
				'alt' => 'Exterior patio door with threshold ramp',
			),
		),
		'eager'   => false,
	),
);

$acc_gallery_label   = $acc_txt( 'acc_gallery_label', 'Equipment' );
$acc_gallery_heading = $acc_txt( 'acc_gallery_heading', 'Tailored to you' );
$acc_gallery_intro   = $acc_txt(
	'acc_gallery_intro',
	'We prepare the bungalow for you before you arrive, setting up the equipment you need from our list based on what you tell us when you enquire. If anything feels loose or isn’t right, please let us know right away.'
);
$acc_gallery_ids = function_exists( 'restwell_get_page_gallery_ids' )
	? restwell_get_page_gallery_ids( $restwell_acc_id, 'acc_gallery_image_ids' )
	: array();
$acc_gallery_fallback = array(
	array(
		'src' => 'bungalow/H-1-LS.jpg',
		'alt' => 'Ceiling track hoist in situ',
	),
	array(
		'src' => 'bungalow/RAR-2-LS.jpg',
		'alt' => 'Rise and recline chair',
	),
	array(
		'src' => 'bungalow/WR-2-LS.jpg',
		'alt' => 'Wet room grab rails and shower',
	),
	array(
		'src' => 'bungalow/EQU-2-LS.jpg',
		'alt' => 'Access equipment in the bedroom',
	),
	array(
		'src' => 'bungalow/adjustable-sink.png',
		'alt' => 'Height-adjustable basin',
	),
	array(
		'src' => 'bungalow/exterior-ramp.png',
		'alt' => 'Exterior threshold ramp',
	),
);

$acc_dest_label   = $acc_txt( 'acc_dest_label', 'Whitstable' );
$acc_dest_heading = $acc_txt( 'acc_dest_heading', 'The destination, honestly.' );
$acc_dest_intro   = $acc_txt(
	'acc_dest_intro',
	'Whitstable is a genuinely lovely town, but like most historic coastal places, it has its challenges. Here is the honest picture.'
);
$acc_dest_items   = array(
	array(
		'dt' => $acc_txt( 'acc_dest_good_heading', 'The good' ),
		'dd' => $acc_txt(
			'acc_dest_good_body',
			'The Tankerton promenade is a long, flat, surfaced path along the seafront, one of the most wheelchair-friendly coastal routes in Kent. Free parking at Marine Parade. Accessible toilets at the harbour end. The streets around the property are flat and paved with dropped kerbs.'
		),
	),
	array(
		'dt' => $acc_txt( 'acc_dest_challenge_heading', 'The challenges' ),
		'dd' => $acc_txt(
			'acc_dest_challenge_body',
			'Harbour Street and the old town have narrow pavements that get crowded at weekends and in summer. Some shops and cafes have stepped entrances with no ramp. The harbour itself has some uneven surfaces near the fish market. Weekday mornings are the easiest time to visit.'
		),
	),
	array(
		'dt' => $acc_txt( 'acc_dest_reality_heading', 'The reality' ),
		'dd' => $acc_txt(
			'acc_dest_reality_body',
			'Whitstable is more accessible than most UK coastal towns. With a little planning and our local knowledge, we can point you to the best accessible routes, cafes, and experiences. We will share everything we know in your welcome pack.'
		),
	),
);

$acc_faq_label   = $acc_txt( 'acc_faq_label', 'Equipment & access' );
$acc_faq_heading = $acc_txt( 'acc_faq_heading', 'Access FAQ' );
$acc_faq_intro   = $acc_txt(
	'acc_faq_intro',
	'Questions about ceiling hoist safe working loads, profiling beds, and the details that make a place truly “wheelchair friendly.”'
);
$acc_faq_live    = array(
	1  => array(
		'q' => 'Can I find a holiday cottage with a ceiling hoist in England?',
		'a' => 'Yes, they are uncommon. Confirm fixed ceiling track vs mobile only, coverage, safe working load, sling policy, and bed position under the track. Restwell has an Amico GoLift 400 ceiling track hoist over the profiling bed, safe working load 180kg; full specs are on this page.',
	),
	2  => array(
		'q' => 'What is a ceiling track hoist in holiday accommodation?',
		'a' => 'A ceiling track hoist is fixed to the ceiling and moves a person in a sling along a rail. It’s less bulky than most mobile units. Most guests bring their own slings. Ask about what areas it covers and who can operate it before you arrive.',
	),
	3  => array(
		'q' => 'What should I check before booking a hoist-equipped holiday let?',
		'a' => 'Check the hoist type and safe working load, whether the bed is under the track, if there’s same-level wet-room access, space for a second carer, parking, and what’s included versus what needs to be hired. Restwell includes the on-site hoist and wet-room kit in the bungalow rate.',
	),
	4  => array(
		'q' => 'Can I find a holiday cottage with a profiling bed in the UK?',
		'a' => 'Yes, but make sure the bed is actually on site, not just “available to hire.” Ask about the mattress type, size, transfer height, and hoist clearance. Restwell’s accessible bedroom has a profiling bed with a pressure-relieving mattress.',
	),
	5  => array(
		'q' => 'Can I find a holiday cottage with a hospital-style or profiling bed?',
		'a' => 'People searching for a “hospital bed holiday cottage” usually want an adjustable profiling bed at a safe transfer height, in a regular bedroom, not a hospital ward. Restwell’s accessible bedroom has this bed, with the ceiling track above it.',
	),
	6  => array(
		'q' => 'Why does an adjustable or profiling bed matter in an accessible bedroom?',
		'a' => 'Profiling beds help with positioning, pressure care, safer transfers, and overnight care routines when a fixed divan isn’t safe. At Restwell, check the controls, side-rail policy, and space for a carer beside the bed to ensure it meets your needs.',
	),
	7  => array(
		'q' => 'What accessible equipment should I expect in a specialist holiday let?',
		'a' => 'Ask for a published equipment list. Restwell includes a profiling bed, ceiling- and mobile hoists, a level-access wet room with a seat and grab rails, a height-adjustable basin, threshold ramps, and parking notes. Never assume “accessible” means a hoist is fitted.',
	),
	8  => array(
		'q' => 'What should “wheelchair friendly holiday cottage” mean?',
		'a' => 'Look for step-free routes, door widths that fit your chair, a bathroom you can use, and parking for accessible vehicles all shown in measurements and photos. If a listing only says “wheelchair friendly,” ask for an access statement or look elsewhere.',
	),
	9  => array(
		'q' => 'What do I need to check before booking an accessible holiday cottage?',
		'a' => 'Check for clear door openings, a step-free route from parking, whether there’s a wet room or adapted bath, hoist type, bed type, turning space, recent entrance and bathroom photos, sling policy, and if care can be arranged separately. Restwell shares all these details on this page.',
	),
	10 => array(
		'q' => 'What makes an accessible bungalow in the UK suitable for complex needs?',
		'a' => 'Being single-storey helps, but accessibility varies a lot. Some people need widened doorways, purpose-built wet rooms, parking, and often a hoist and profiling bed. Restwell is step-free throughout, as shown here.',
	),
);
$acc_faq_items = array();
for ( $i = 1; $i <= 10; $i++ ) {
	$q = $acc_txt( "acc_faq_{$i}_q", $acc_faq_live[ $i ]['q'] );
	$a = $acc_txt( "acc_faq_{$i}_a", $acc_faq_live[ $i ]['a'] );
	if ( '' === trim( $q ) || '' === trim( $a ) ) {
		continue;
	}
	$acc_faq_items[] = array(
		'q' => $q,
		'a' => $a,
	);
}
if ( empty( $acc_faq_items ) ) {
	$acc_faq_items = array_values( $acc_faq_live );
}

$acc_stat_1_label = $acc_txt( 'acc_stat_1_label', 'Clear opening, front door' );
$acc_stat_1_value = $acc_txt( 'acc_stat_1_value', '965mm' );
$acc_stat_2_label = $acc_txt( 'acc_stat_2_label', 'Clear width, internal doors' );
$acc_stat_2_value = $acc_txt( 'acc_stat_2_value', '926mm' );
$acc_stat_3_label = $acc_txt( 'acc_stat_3_label', 'Ceiling track hoist over the bed' );
$acc_stat_3_value = $acc_txt( 'acc_stat_3_value', 'Full-room' );

$acc_fit_label         = $acc_txt( 'acc_fit_label', 'Door clearances' );
$acc_fit_heading       = $acc_txt( 'acc_fit_heading', 'Compare your chair width to our doorways' );
$acc_fit_intro         = $acc_txt(
	'acc_fit_intro',
	'Enter the overall width of the chair you travel with (widest point, including hand rims). We’ll show the clearance at each doorway so you can judge the numbers before you enquire.'
);
$acc_fit_note          = $acc_txt(
	'acc_fit_note',
	'This is a guide only. Aim for at least 50mm of clearance where you can, and we’re happy to talk through your measurements before you book.'
);
$acc_fit_guide_heading = $acc_txt( 'acc_fit_guide_heading', 'Typical chair widths' );
$acc_fit_guide_intro   = $acc_txt(
	'acc_fit_guide_intro',
	'Wheel to wheel, including hand rims. These are common ranges, not a measurement of your chair.'
);

/**
 * Link a known phrase inside already-escaped HTML.
 *
 * @param string $escaped Escaped plain text.
 * @param string $phrase  Phrase to wrap.
 * @param string $url     Absolute or site URL.
 * @return string
 */
$acc_link_phrase = static function ( $escaped, $phrase, $url ) {
	$needle = esc_html( $phrase );
	if ( '' === $needle || false === strpos( $escaped, $needle ) ) {
		return $escaped;
	}
	$link = '<a class="text-link" href="' . esc_url( $url ) . '">' . $needle . '</a>';
	return str_replace( $needle, $link, $escaped );
};
?>


<main id="main-content">
<?php
get_template_part(
	'template-parts/concept/photo-hero',
	null,
	array(
		'heading_id' => 'page-h',
		'heading'    => $restwell_acc_heading,
		'eyebrow'    => $restwell_acc_label,
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

	<section class="section-y section-y--compact band-white" aria-label="<?php echo esc_attr__( 'Key measurements', 'restwell-retreats' ); ?>">
	  <div class="container">
		<div class="stat-row">
		  <dl>
			<div class="stat"><dt class="stat__label"><?php echo esc_html( $acc_stat_1_label ); ?></dt><dd class="stat__value"><?php echo esc_html( $acc_stat_1_value ); ?></dd></div>
			<div class="stat"><dt class="stat__label"><?php echo esc_html( $acc_stat_2_label ); ?></dt><dd class="stat__value"><?php echo esc_html( $acc_stat_2_value ); ?></dd></div>
			<div class="stat"><dt class="stat__label"><?php echo esc_html( $acc_stat_3_label ); ?></dt><dd class="stat__value"><?php echo esc_html( $acc_stat_3_value ); ?></dd></div>
		  </dl>
		</div>
	  </div>
	</section>

	<section class="section-y band-subtle" id="fit-check" aria-labelledby="fit-check-h">
	  <div class="container">
		<header class="section-head section-head--tight">
		  <?php if ( '' !== $acc_fit_label ) : ?>
		  <p class="eyebrow"><?php echo esc_html( $acc_fit_label ); ?></p>
		  <?php endif; ?>
		  <h2 id="fit-check-h"><?php echo esc_html( $acc_fit_heading ); ?></h2>
		  <?php if ( '' !== $acc_fit_intro ) : ?>
		  <p class="lede"><?php echo esc_html( $acc_fit_intro ); ?></p>
		  <?php endif; ?>
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
			  <label class="screen-reader-text" for="fit-check-input">Wheelchair width slider</label>
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
			<?php if ( '' !== $acc_fit_note ) : ?>
			<p class="fit-check__note"><?php echo esc_html( $acc_fit_note ); ?></p>
			<?php endif; ?>
		  </div>
		</div>
		<aside class="width-guide" aria-labelledby="width-guide-h">
		  <div class="width-guide__intro">
			<h3 id="width-guide-h" class="width-guide__title"><?php echo esc_html( $acc_fit_guide_heading ); ?></h3>
			<?php if ( '' !== $acc_fit_guide_intro ) : ?>
			<p class="width-guide__lede"><?php echo esc_html( $acc_fit_guide_intro ); ?></p>
			<?php endif; ?>
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

	<section id="rooms" aria-labelledby="rooms-h">
	  <div class="section-y band-white">
		<div class="container">
		  <header class="section-head">
			<?php if ( '' !== $acc_room_label ) : ?>
			<p class="eyebrow"><?php echo esc_html( $acc_room_label ); ?></p>
			<?php endif; ?>
			<h2 id="rooms-h"><?php echo esc_html( $acc_room_heading ); ?></h2>
			<?php if ( '' !== $acc_room_intro ) : ?>
			<p class="lede"><?php echo esc_html( $acc_room_intro ); ?></p>
			<?php endif; ?>
		  </header>
		  <nav class="subnav room-access__toc" aria-label="<?php echo esc_attr__( 'Jump to a room', 'restwell-retreats' ); ?>">
			<ul class="subnav__list">
			  <?php foreach ( $acc_room_cards as $acc_room_nav ) : ?>
			  <li><a href="#room-<?php echo esc_attr( $acc_room_nav['id'] ); ?>"><?php echo esc_html( ! empty( $acc_room_nav['nav'] ) ? $acc_room_nav['nav'] : $acc_room_nav['heading'] ); ?></a></li>
			  <?php endforeach; ?>
			</ul>
		  </nav>
		</div>
	  </div>

	  <?php
		foreach ( $acc_room_cards as $acc_room_i => $acc_room_card ) :
			$acc_room_photos = isset( $acc_room_card['photos'] ) && is_array( $acc_room_card['photos'] )
				? $acc_room_card['photos']
				: array();
			if ( empty( $acc_room_photos ) ) {
				continue;
			}
			$acc_room_primary = $acc_room_photos[0];
			$acc_room_count   = count( $acc_room_photos );
			$acc_room_parts   = preg_split( '/\n---\n/', (string) $acc_room_card['body'], 2 );
			$acc_room_summary = isset( $acc_room_parts[0] ) ? (string) $acc_room_parts[0] : '';
			$acc_room_detail  = isset( $acc_room_parts[1] ) ? (string) $acc_room_parts[1] : '';
			$acc_room_lines   = static function ( $raw ) {
				$items = preg_split( '/\n+/', (string) $raw );
				if ( ! is_array( $items ) ) {
					return array();
				}
				return array_values(
					array_filter(
						array_map( 'trim', $items ),
						static function ( $line ) {
							return '' !== $line && '---' !== $line;
						}
					)
				);
			};
			$acc_room_items        = $acc_room_lines( $acc_room_summary );
			$acc_room_detail_items = $acc_room_lines( $acc_room_detail );
			$acc_room_band  = ( 0 === $acc_room_i % 2 ) ? 'band-subtle' : 'band-white';
			$acc_room_flip  = ( 0 !== $acc_room_i % 2 ) ? ' split--flip' : '';
			$acc_room_eager = ! empty( $acc_room_card['eager'] );
			?>
	  <article
		class="section-y <?php echo esc_attr( $acc_room_band ); ?> room-access"
		id="room-<?php echo esc_attr( $acc_room_card['id'] ); ?>"
		data-gallery
		aria-labelledby="room-<?php echo esc_attr( $acc_room_card['id'] ); ?>-h"
	  >
		<div class="container split<?php echo esc_attr( $acc_room_flip ); ?>">
		  <div class="split__media room-access__media">
			<button
			  type="button"
			  class="gallery__open room-access__photo"
			  data-gallery-open
			  data-gallery-index="0"
			  aria-label="<?php echo esc_attr( sprintf( /* translators: %s: room photo description */ __( 'View photos: %s', 'restwell-retreats' ), $acc_room_primary['alt'] ) ); ?>"
			>
			  <img
				src="<?php echo esc_url( restwell_theme_image_url( $acc_room_primary['src'] ) ); ?>"
				alt="<?php echo esc_attr( $acc_room_primary['alt'] ); ?>"
				width="900"
				height="675"
				loading="<?php echo $acc_room_eager ? 'eager' : 'lazy'; ?>"
				<?php echo $acc_room_eager ? 'fetchpriority="high" ' : ''; ?>decoding="async"
			  />
			</button>
			<?php if ( $acc_room_count > 1 ) : ?>
			<p class="room-access__hint">
			  <?php
				echo esc_html(
					sprintf(
						/* translators: %d: number of photos for this room */
						_n( '%d photo', '%d photos', $acc_room_count, 'restwell-retreats' ),
						$acc_room_count
					)
				);
				?>
			</p>
			  <?php
				foreach ( array_slice( $acc_room_photos, 1 ) as $acc_room_extra ) :
					?>
			<img
			  data-gallery-slide
			  hidden
			  src="<?php echo esc_url( restwell_theme_image_url( $acc_room_extra['src'] ) ); ?>"
			  alt="<?php echo esc_attr( $acc_room_extra['alt'] ); ?>"
			  width="640"
			  height="480"
			  loading="lazy"
			  decoding="async"
			/>
					<?php
				endforeach;
				?>
			<?php endif; ?>
		  </div>
		  <div class="room-access__copy">
			<header class="section-head section-head--tight">
			  <h3 id="room-<?php echo esc_attr( $acc_room_card['id'] ); ?>-h"><?php echo esc_html( $acc_room_card['heading'] ); ?></h3>
			</header>
			<?php if ( ! empty( $acc_room_items ) ) : ?>
			<ul class="checklist">
			  <?php foreach ( $acc_room_items as $acc_room_item ) : ?>
			  <li><?php echo wp_kses_post( $acc_room_item ); ?></li>
			  <?php endforeach; ?>
			</ul>
			<?php endif; ?>
			<?php if ( ! empty( $acc_room_detail_items ) ) : ?>
			<details class="room-access__more-kit">
			  <summary><?php echo esc_html__( 'More kit detail', 'restwell-retreats' ); ?></summary>
			  <ul class="checklist">
				<?php foreach ( $acc_room_detail_items as $acc_room_item ) : ?>
				<li><?php echo wp_kses_post( $acc_room_item ); ?></li>
				<?php endforeach; ?>
			  </ul>
			</details>
			<?php endif; ?>
		  </div>
		</div>
	  </article>
			<?php
		endforeach;
		?>

	  <div class="section-y band-white">
		<div class="container">
		  <ul class="card-grid card-grid--2" role="list">
			<li><article class="info-card info-card--sand info-card--flat"><h3>Specific requirement?</h3><p>Email us your needs as early as you can. We may not be able to provide every aid at short notice, but we’d much rather you ask than be unsure.</p><a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'enquire' ) ); ?>">Send details</a></article></li>
			<li><article class="info-card info-card--sand info-card--flat"><h3>Need precise measurements?</h3><p>You’ll find door widths and key specs here. If you need other measurements, just let us know and we’ll measure them for you.</p><a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'enquire' ) ); ?>">Request measurements</a></article></li>
		  </ul>
		</div>
	  </div>
	</section>
	<section class="section-y band-subtle" data-gallery>
	  <div class="container">
		<header class="section-head">
		  <?php if ( '' !== $acc_gallery_label ) : ?>
		  <p class="eyebrow"><?php echo esc_html( $acc_gallery_label ); ?></p>
		  <?php endif; ?>
		  <h2><?php echo esc_html( $acc_gallery_heading ); ?></h2>
		  <?php if ( '' !== $acc_gallery_intro ) : ?>
		  <p class="lede"><?php echo esc_html( $acc_gallery_intro ); ?></p>
		  <?php endif; ?>
		</header>
		<ul class="gallery-grid" role="list" aria-label="Access equipment photos">
		  <?php
			if ( ! empty( $acc_gallery_ids ) ) :
				foreach ( $acc_gallery_ids as $acc_gallery_index => $acc_gallery_id ) :
					$acc_gallery_id  = absint( $acc_gallery_id );
					$acc_gallery_src = wp_get_attachment_image_url( $acc_gallery_id, 'large' );
					if ( ! $acc_gallery_src ) {
						continue;
					}
					$acc_gallery_alt = trim( (string) get_post_meta( $acc_gallery_id, '_wp_attachment_image_alt', true ) );
					if ( '' === $acc_gallery_alt ) {
						$acc_gallery_alt = get_the_title( $acc_gallery_id );
					}
					?>
		  <li>
			<button type="button" class="gallery__open" data-gallery-open data-gallery-index="<?php echo esc_attr( (string) $acc_gallery_index ); ?>" aria-label="<?php echo esc_attr( sprintf( /* translators: %s: image description */ __( 'View full size: %s', 'restwell-retreats' ), $acc_gallery_alt ) ); ?>">
			  <img src="<?php echo esc_url( $acc_gallery_src ); ?>" alt="<?php echo esc_attr( $acc_gallery_alt ); ?>" width="640" height="480" loading="lazy" decoding="async" />
			</button>
		  </li>
					<?php
				endforeach;
			else :
				foreach ( $acc_gallery_fallback as $acc_gallery_index => $acc_gallery_item ) :
					?>
		  <li>
			<button type="button" class="gallery__open" data-gallery-open data-gallery-index="<?php echo esc_attr( (string) $acc_gallery_index ); ?>" aria-label="<?php echo esc_attr( sprintf( /* translators: %s: image description */ __( 'View full size: %s', 'restwell-retreats' ), $acc_gallery_item['alt'] ) ); ?>">
			  <img src="<?php echo esc_url( restwell_theme_image_url( $acc_gallery_item['src'] ) ); ?>" alt="<?php echo esc_attr( $acc_gallery_item['alt'] ); ?>" width="640" height="480" loading="lazy" decoding="async" />
			</button>
		  </li>
					<?php
				endforeach;
			endif;
			?>
		</ul>
	  </div>
	</section>
	<section class="section-y band-white">
	  <div class="container split">
		<div class="split__media">
			<img src="<?php echo esc_url( restwell_theme_image_url( 'stock/restwell-whitstable-coastal-pathway.webp' ) ); ?>" alt="Flat, paved coastal pathway along Tankerton promenade" width="900" height="675" loading="lazy" decoding="async" />
		</div>
		<div>
		  <header class="section-head">
			<?php if ( '' !== $acc_dest_label ) : ?>
			<p class="eyebrow"><?php echo esc_html( $acc_dest_label ); ?></p>
			<?php endif; ?>
			<h2><?php echo esc_html( $acc_dest_heading ); ?></h2>
			<?php if ( '' !== $acc_dest_intro ) : ?>
			<p class="lede"><?php echo esc_html( $acc_dest_intro ); ?></p>
			<?php endif; ?>
		  </header>
		  <dl class="comparison-list">
			<?php foreach ( $acc_dest_items as $acc_dest_item ) : ?>
			<div class="comparison-list__item">
			  <dt><?php echo esc_html( $acc_dest_item['dt'] ); ?></dt>
			  <dd><?php echo esc_html( $acc_dest_item['dd'] ); ?></dd>
			</div>
			<?php endforeach; ?>
		  </dl>
		</div>
	  </div>
	</section>
	<section class="faq section-y band-white" id="faq" aria-labelledby="faq-h">
	  <div class="container">
		<div class="faq__layout">
		  <header class="faq__intro">
			<?php if ( '' !== $acc_faq_label ) : ?>
			<p class="eyebrow"><?php echo esc_html( $acc_faq_label ); ?></p>
			<?php endif; ?>
			<h2 id="faq-h"><?php echo esc_html( $acc_faq_heading ); ?></h2>
			<?php if ( '' !== $acc_faq_intro ) : ?>
			<p class="lede"><?php echo esc_html( $acc_faq_intro ); ?></p>
			<?php endif; ?>
		  </header>
		  <?php
			$acc_faq_accordion = array();
			foreach ( $acc_faq_items as $faq_i => $faq_row ) {
				$answer = esc_html( $faq_row['a'] );
				$answer = $acc_link_phrase( $answer, 'care can be arranged separately', restwell_nav_resolve_page_url( 'optional-care' ) );
				$acc_faq_accordion[] = array(
					'q'    => $faq_row['q'],
					'a'    => '<p>' . $answer . '</p>',
					'open' => 0 === $faq_i,
				);
			}
			get_template_part(
				'template-parts/faq-accordion',
				null,
				array(
					'id_prefix'    => 'a11y-q',
					'list_class'   => 'faq-list--split',
					'wrap_columns' => true,
					'columns'      => array( array_slice( $acc_faq_accordion, 0, 5, true ), array_slice( $acc_faq_accordion, 5, null, true ) ),
				)
			);
			?>
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

	<?php
	$mid_cta_heading = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_acc_id, 'acc_cta_heading', __( 'Ask about your equipment and clearances.', 'restwell-retreats' ) )
		: __( 'Ask about your equipment and clearances.', 'restwell-retreats' );
	$mid_cta_intro   = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text(
			$restwell_acc_id,
			'acc_cta_body',
			__( 'If you have questions about door widths, hoist limits, wet-room equipment, or care, we will answer them clearly.', 'restwell-retreats' )
		)
		: __( 'If you have questions about door widths, hoist limits, wet-room equipment, or care, we will answer them clearly.', 'restwell-retreats' );
	$mid_cta_primary_label = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_acc_id, 'acc_cta_btn', __( 'Enquire', 'restwell-retreats' ) )
		: __( 'Enquire', 'restwell-retreats' );
	$mid_cta_primary_url   = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_acc_id, 'acc_cta_url', restwell_nav_resolve_page_url( 'enquire' ) )
		: restwell_nav_resolve_page_url( 'enquire' );

	$mid_cta_secondary_label = __( 'Tour the property', 'restwell-retreats' );
	$mid_cta_secondary_url   = restwell_nav_resolve_page_url( 'the-property' );

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
