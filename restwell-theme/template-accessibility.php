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
$restwell_acc_hero_lede = 'This is the access statement for Restwell, a single-storey adapted bungalow in Whitstable.';
$restwell_acc_intro     = $acc_txt(
	'acc_intro',
	$restwell_acc_hero_lede
);
/*
 * Stored hero ledes that belong in the statement band, or the old one-liner,
 * would flood the photo overlay. Keep a short H1 deck; the numbers follow.
 */
$restwell_acc_intro_legacy = array(
	'The full access statement for Restwell: exact door widths, hoist capacity and the level-access wet room.',
	'This is the access statement for Restwell, a single-storey adapted bungalow in Whitstable. The front door has a 965mm clear opening and internal doorways are 926mm. There is a ceiling track hoist rated to 180kg, a mobile hoist, a level-access wet room, and up to two profiling beds depending on what you need.',
	'We publish makes, models and safe working loads because we know who reads this page. Somebody has told you a place was accessible before, and it wasn’t, and you found out standing in a doorway with your coat still on. Or you’re an occupational therapist who has been asked to sign off a stay on the strength of three photographs.',
);
if ( in_array( $restwell_acc_intro, $restwell_acc_intro_legacy, true ) ) {
	$restwell_acc_intro = $restwell_acc_hero_lede;
}

$acc_stat_1_value = $acc_txt( 'acc_stat_1_value', '965mm' );
$acc_stat_1_label = $acc_txt( 'acc_stat_1_label', 'Front door, clear opening' );
$acc_stat_2_value = $acc_txt( 'acc_stat_2_value', '926mm' );
$acc_stat_2_label = $acc_txt( 'acc_stat_2_label', 'Internal doors, clear width' );
$acc_stat_3_value = $acc_txt( 'acc_stat_3_value', '180 kg' );
$acc_stat_3_label = $acc_txt( 'acc_stat_3_label', 'Ceiling hoist, safe working load' );
if ( 'Full-room' === $acc_stat_3_value ) {
	$acc_stat_3_value = '180 kg';
	if ( 'Ceiling track hoist over the bed' === $acc_stat_3_label ) {
		$acc_stat_3_label = 'Ceiling hoist, safe working load';
	}
}
$acc_statement_label   = __( 'Access statement', 'restwell-retreats' );
$acc_statement_heading = __( 'The house in numbers', 'restwell-retreats' );
$acc_statement_body    = __( 'We publish makes, models and safe working loads because we know who reads this page. Somebody has told you a place was accessible before, and it wasn’t, and you found out standing in a doorway with your coat still on. Or you’re an occupational therapist who has been asked to sign off a stay on the strength of three photographs. If there’s a measurement we haven’t published, ring us and we’ll go and take it properly.', 'restwell-retreats' );

$acc_host_phone = function_exists( 'restwell_get_public_phone_number' )
	? restwell_get_public_phone_number()
	: '01622 809881';
$acc_host_tel   = function_exists( 'restwell_get_public_phone_tel' )
	? restwell_get_public_phone_tel()
	: '01622809881';
$acc_host_email = function_exists( 'restwell_get_public_enquiry_email' )
	? restwell_get_public_enquiry_email()
	: 'hello@restwellretreats.co.uk';

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
	1 => array(
		'q' => 'Do you provide hoist slings?',
		'a' => 'No. Bring the sling the person already uses — both hoists take loop-style slings on a two-point spreader bar. The note above the equipment register explains why we cannot supply one.',
	),
	2 => array(
		'q' => 'What is a ceiling track hoist in holiday accommodation?',
		'a' => 'It is fixed to the ceiling and moves a person in a sling along a rail, so it takes no floor space and needs no turning circle — unlike a mobile hoist, which has to be wheeled into position. Ours runs over the bed in the main bedroom. Full coverage, capacity and attachment details are in the equipment register above.',
	),
	3 => array(
		'q' => 'Why does a profiling bed matter in an accessible bedroom?',
		'a' => 'It helps with positioning, pressure care and safer transfers, and it sets a working height that protects the back of whoever is providing care. A fixed divan gives you none of that, and a mobile hoist often cannot get its legs underneath one. We have two profiling beds; the accessible bedroom takes one or two.',
	),
	4 => array(
		'q' => 'What should “wheelchair friendly” actually mean?',
		'a' => 'It should mean published numbers you can check against your own chair and your own equipment: clear door openings, step-free routes, safe working loads, turning circles. If a listing says “wheelchair friendly” and will not give you a measurement when you ask, that tells you what you need to know. Everything we have is on this page.',
	),
);
$acc_faq_items = array();
$acc_faq_count = count( $acc_faq_live );
for ( $i = 1; $i <= $acc_faq_count; $i++ ) {
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
$acc_hero_att  = absint( get_post_meta( $restwell_acc_id, 'acc_hero_image_id', true ) );
$acc_hero_args = array(
	'heading_id' => 'page-h',
	'heading'    => $restwell_acc_heading,
	'eyebrow'    => $restwell_acc_label,
	'intro'      => $restwell_acc_intro,
	'overlay'    => 'heavy',
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
	'image_url'  => restwell_theme_image_url( 'bungalow/WR-1-LS.jpg' ),
	'image_alt'  => function_exists( 'restwell_theme_image_alt' )
		? restwell_theme_image_alt( 'bungalow/WR-1-LS.jpg' )
		: __( 'Level-access wet room with grab rails and a shower commode chair', 'restwell-retreats' ),
);
/*
 * Featured / seeded OG stock on this page is a Whitstable sunset. Only honour
 * an editor-picked hero when it is not that coastal stand-in.
 */
if ( $acc_hero_att > 0 ) {
	$acc_hero_file = strtolower( (string) get_attached_file( $acc_hero_att ) );
	$acc_hero_stem = pathinfo( $acc_hero_file, PATHINFO_FILENAME );
	$acc_is_sunset = ( false !== strpos( $acc_hero_stem, 'promenade' )
		|| false !== strpos( $acc_hero_stem, 'golden-hour' )
		|| false !== strpos( $acc_hero_stem, 'beach-hut' )
		|| false !== strpos( $acc_hero_stem, 'coastline' ) );
	if ( ! $acc_is_sunset ) {
		$acc_hero_args['media_id']  = $acc_hero_att;
		$acc_hero_args['image_url'] = '';
		$acc_hero_args['image_alt'] = '';
	}
}
get_template_part( 'template-parts/concept/photo-hero', null, $acc_hero_args );
?>

	<nav class="subnav" aria-label="<?php echo esc_attr__( 'On this page', 'restwell-retreats' ); ?>" data-toc>
	  <div class="container">
		<ul class="subnav__list">
		  <li><a href="#statement"><?php esc_html_e( 'The numbers', 'restwell-retreats' ); ?></a></li>
		  <li><a href="#fit-check"><?php esc_html_e( 'Doorways', 'restwell-retreats' ); ?></a></li>
		  <li><a href="#equipment"><?php esc_html_e( 'Equipment', 'restwell-retreats' ); ?></a></li>
		  <li><a href="#destination"><?php esc_html_e( 'Whitstable', 'restwell-retreats' ); ?></a></li>
		  <li><a href="#faq"><?php esc_html_e( 'FAQ', 'restwell-retreats' ); ?></a></li>
		</ul>
	  </div>
	</nav>

	<section class="section-y band-subtle" id="statement" aria-labelledby="statement-h">
	  <div class="container split acc-statement-split">
		<header class="section-head section-head--tight">
		  <p class="eyebrow"><?php echo esc_html( $acc_statement_label ); ?></p>
		  <h2 id="statement-h"><?php echo esc_html( $acc_statement_heading ); ?></h2>
		  <p class="lede acc-statement-split__lede"><?php echo esc_html( $acc_statement_body ); ?></p>
		</header>
		<?php
		$acc_figure_kses = array(
			'span' => array(
				'class' => true,
			),
		);
		?>
		<div class="acc-panel acc-panel--stats">
		  <div class="stat-row stat-row--hero">
			<dl>
			  <div class="stat">
				<dt class="stat__label"><?php echo esc_html( $acc_stat_1_label ); ?></dt>
				<dd class="stat__value"><?php echo wp_kses( restwell_format_acc_figure_value( (string) $acc_stat_1_value ), $acc_figure_kses ); ?></dd>
			  </div>
			  <div class="stat">
				<dt class="stat__label"><?php echo esc_html( $acc_stat_2_label ); ?></dt>
				<dd class="stat__value"><?php echo wp_kses( restwell_format_acc_figure_value( (string) $acc_stat_2_value ), $acc_figure_kses ); ?></dd>
			  </div>
			  <div class="stat">
				<dt class="stat__label"><?php echo esc_html( $acc_stat_3_label ); ?></dt>
				<dd class="stat__value"><?php echo wp_kses( restwell_format_acc_figure_value( (string) $acc_stat_3_value ), $acc_figure_kses ); ?></dd>
			  </div>
			</dl>
		  </div>
		</div>

		<?php
		/*
		 * The fit check belongs to the numbers, not beside them. Split across
		 * two bands a reader met 965mm as a fact, scrolled past a band edge,
		 * and met it again as a tool — the same question answered twice. Here
		 * the essay hands straight over to the thing that answers it.
		 */
		?>
		<section class="acc-fit" id="fit-check" aria-labelledby="fit-check-h">
		  <header class="section-head section-head--tight">
		  <?php if ( '' !== $acc_fit_label ) : ?>
		  <p class="eyebrow"><?php echo esc_html( $acc_fit_label ); ?></p>
		  <?php endif; ?>
		  <h3 id="fit-check-h"><?php echo esc_html( $acc_fit_heading ); ?></h3>
		  <?php if ( '' !== $acc_fit_intro ) : ?>
		  <p class="lede"><?php echo esc_html( $acc_fit_intro ); ?></p>
		  <?php endif; ?>
		</header>
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
			<div class="fit-check__presets">
			  <h4 class="fit-check__presets-title" id="fit-check-presets-h"><?php echo esc_html( $acc_fit_guide_heading ); ?></h4>
			  <?php if ( '' !== $acc_fit_guide_intro ) : ?>
			  <p class="fit-check__presets-intro"><?php echo esc_html( $acc_fit_guide_intro ); ?></p>
			  <?php endif; ?>
			  <div class="fit-check__chips" role="group" aria-labelledby="fit-check-presets-h">
				<button type="button" class="fit-check__chip" data-fit-preset="570" aria-pressed="false" aria-label="<?php echo esc_attr__( 'Set checker to 570 millimetres, typical transit chair', 'restwell-retreats' ); ?>">
				  <span class="fit-check__chip-name"><?php esc_html_e( 'Transit', 'restwell-retreats' ); ?></span>
				  <span class="fit-check__chip-size">530–610mm</span>
				</button>
				<button type="button" class="fit-check__chip" data-fit-preset="660" aria-pressed="false" aria-label="<?php echo esc_attr__( 'Set checker to 660 millimetres, typical self-propelled chair', 'restwell-retreats' ); ?>">
				  <span class="fit-check__chip-name"><?php esc_html_e( 'Self-propelled', 'restwell-retreats' ); ?></span>
				  <span class="fit-check__chip-size">635–685mm</span>
				</button>
				<button type="button" class="fit-check__chip" data-fit-preset="700" aria-pressed="true" aria-label="<?php echo esc_attr__( 'Set checker to 700 millimetres, typical powered chair', 'restwell-retreats' ); ?>">
				  <span class="fit-check__chip-name"><?php esc_html_e( 'Powered', 'restwell-retreats' ); ?></span>
				  <span class="fit-check__chip-size">600–760mm+</span>
				</button>
				<button type="button" class="fit-check__chip" data-fit-preset="800" aria-pressed="false" aria-label="<?php echo esc_attr__( 'Set checker to 800 millimetres, typical bariatric chair', 'restwell-retreats' ); ?>">
				  <span class="fit-check__chip-name"><?php esc_html_e( 'Bariatric', 'restwell-retreats' ); ?></span>
				  <span class="fit-check__chip-size">Over 760mm</span>
				</button>
			  </div>
			  <p class="fit-check__presets-note"><?php esc_html_e( 'Choose a type to try a midpoint. Measure your own chair before you book.', 'restwell-retreats' ); ?></p>
			</div>
			<div class="fit-check__gauges">
			<div class="fit-check__bars">
			  <div class="fit-bar" data-fit-gauge data-door-width="965" data-fit-name="the front door">
				<div class="fit-bar__head">
				  <span class="fit-bar__label">Front door</span>
				  <span class="fit-bar__spec" data-fit-spec>965mm</span>
				</div>
				<div class="fit-bar__track" data-fit-track aria-hidden="true">
				  <span class="fit-bar__door-mark fit-bar__door-mark--start"></span>
				  <span class="fit-bar__fill" data-fit-fill></span>
				  <span class="fit-bar__door-mark fit-bar__door-mark--end"></span>
				</div>
				<p class="fit-bar__result" data-fit-result></p>
			  </div>

			  <div class="fit-bar" data-fit-gauge data-door-width="926" data-fit-name="the internal doors">
				<div class="fit-bar__head">
				  <span class="fit-bar__label">Internal doors</span>
				  <span class="fit-bar__spec" data-fit-spec>926mm</span>
				</div>
				<div class="fit-bar__track" data-fit-track aria-hidden="true">
				  <span class="fit-bar__door-mark fit-bar__door-mark--start"></span>
				  <span class="fit-bar__fill" data-fit-fill></span>
				  <span class="fit-bar__door-mark fit-bar__door-mark--end"></span>
				</div>
				<p class="fit-bar__result" data-fit-result></p>
			  </div>
			</div>
			<?php if ( '' !== $acc_fit_note ) : ?>
			<p class="fit-check__note"><?php echo esc_html( $acc_fit_note ); ?></p>
			<?php endif; ?>
			<p class="fit-check__refs-label" id="fit-check-refs-h"><?php esc_html_e( 'Reference standards', 'restwell-retreats' ); ?></p>
			<ul class="fit-check__refs" aria-labelledby="fit-check-refs-h">
			  <li>
				<a class="text-link" href="https://www.gov.uk/government/publications/access-to-and-use-of-buildings-approved-document-m" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'UK Approved Document M', 'restwell-retreats' ); ?><span class="sr-only"> <?php esc_html_e( '(opens in a new tab)', 'restwell-retreats' ); ?></span></a>
			  </li>
			  <li>
				<a class="text-link" href="https://www.bsigroup.com/en-GB/standards/bs-8300-1-and-2/" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'BS 8300 accessible environment', 'restwell-retreats' ); ?><span class="sr-only"> <?php esc_html_e( '(opens in a new tab)', 'restwell-retreats' ); ?></span></a>
			  </li>
			</ul>
			</div>
		  </div>
		</div>
		</section>
	  </div>
	</section>


	<?php
	/*
	 * Equipment register.
	 *
	 * This is the section that separates /accessibility/ from /the-property/:
	 * the property page is the tour, this is the risk-assessment document an OT,
	 * case manager or deputy needs before they can sign off a stay. Named makes
	 * and models, safe working loads and clearances — no marketing adjectives.
	 * Figures come from the manufacturers' own spec sheets. Each room is a
	 * package card (photo + headline numbers + spec list) so an OT can scan
	 * one space at a time. The property page remains the full room tour.
	 */
	$acc_equipment = array(
		array(
			'group'         => 'getting-in',
			'name'          => __( 'Parking and getting around', 'restwell-retreats' ),
			'where'         => __( 'Single storey, no internal steps', 'restwell-retreats' ),
			'lead'          => true,
			'image'         => 'bungalow/entrance.png',
			'image_alt'     => __( 'Level driveway and front door of the bungalow', 'restwell-retreats' ),
			'specs'         => array(
				__( 'Driveway', 'restwell-retreats' )          => __( 'Private, resin-bound: two off-road spaces, adapted vehicles welcome', 'restwell-retreats' ),
				__( 'Street parking', 'restwell-retreats' )    => __( 'Outside the house if you need extra room. No residents permit on this road; check signs on arrival in case street rules change', 'restwell-retreats' ),
				__( 'Car to front door', 'restwell-retreats' ) => __( 'Step-free path', 'restwell-retreats' ),
				__( 'Floors', 'restwell-retreats' )            => __( 'Level flooring throughout, no carpet lips', 'restwell-retreats' ),
				__( 'Patio', 'restwell-retreats' )             => __( 'Level hard-standing suitable for wheelchairs, with the enclosed garden and BBQ area beyond', 'restwell-retreats' ),
			),
		),
		array(
			'group'         => 'getting-in',
			'name'          => __( 'Doorways and thresholds', 'restwell-retreats' ),
			'where'         => __( 'Clear openings, measured door-stop to door-stop', 'restwell-retreats' ),
			'lead'          => true,
			'figure'        => '965 mm',
			'figure_label'  => __( 'Front door clear opening', 'restwell-retreats' ),
			'specs'         => array(
				__( 'Front door', 'restwell-retreats' )            => __( '965 mm clear, level threshold, no step', 'restwell-retreats' ),
				__( 'Porch outer doors', 'restwell-retreats' )     => __( '1720 mm opening, with a full-width ribbed entrance mat', 'restwell-retreats' ),
				__( 'All internal doors', 'restwell-retreats' )    => __( '926 mm clear', 'restwell-retreats' ),
				__( 'Conservatory French doors', 'restwell-retreats' ) => __( '1720 mm opening', 'restwell-retreats' ),
				__( 'Rear French doors', 'restwell-retreats' )     => __( '1720 mm opening, onto the patio', 'restwell-retreats' ),
				__( 'Patio threshold ramp', 'restwell-retreats' )  => __( '20 mm high × 80 mm wide, non-slip', 'restwell-retreats' ),
				__( 'Door furniture', 'restwell-retreats' )        => __( 'White doors with black lever handles, for contrast', 'restwell-retreats' ),
				__( 'Portable ramps', 'restwell-retreats' )        => __( 'Fold-up ramps kept for the front door, yours for the stay and for days out', 'restwell-retreats' ),
			),
		),
		array(
			'group'         => 'transfers',
			'name'          => __( 'Amico GoLift 400 — ceiling track hoist', 'restwell-retreats' ),
			'where'         => __( 'Main bedroom, over the profiling bed', 'restwell-retreats' ),
			'lead'          => true,
			'image'         => 'bungalow/BD2-3-LS.jpg',
			'image_alt'     => __( 'Accessible bedroom with ceiling track hoist over the profiling bed', 'restwell-retreats' ),
			'figure'        => '180 kg',
			'figure_label'  => __( 'Safe working load', 'restwell-retreats' ),
			'specs'         => array(
				__( 'Safe working load', 'restwell-retreats' )   => __( '180 kg / 28 st', 'restwell-retreats' ),
				__( 'Lift and lower', 'restwell-retreats' )      => __( 'Powered', 'restwell-retreats' ),
				__( 'Traverse', 'restwell-retreats' )            => __( 'Manual', 'restwell-retreats' ),
				__( 'Trolley', 'restwell-retreats' )             => __( 'Fixed', 'restwell-retreats' ),
				__( 'Attachment', 'restwell-retreats' )          => __( 'Lifting strap with loop', 'restwell-retreats' ),
				__( 'Coverage', 'restwell-retreats' )            => __( 'Full-room', 'restwell-retreats' ),
				__( 'Thorough examination', 'restwell-retreats' ) => __( 'LOLER, every six months', 'restwell-retreats' ),
			),
		),
		array(
			'group'         => 'transfers',
			'name'          => __( 'Accora CommunityBed', 'restwell-retreats' ),
			'where'         => __( 'Accessible bedroom, under the ceiling track', 'restwell-retreats' ),
			'lead'          => true,
			'figure'        => '180 kg',
			'figure_label'  => __( 'Maximum user weight', 'restwell-retreats' ),
			'specs'         => array(
				__( 'Safe working load', 'restwell-retreats' )      => __( '215 kg / 34 st', 'restwell-retreats' ),
				__( 'Maximum user weight', 'restwell-retreats' )    => __( '180 kg / 28 st', 'restwell-retreats' ),
				__( 'Mattress platform', 'restwell-retreats' )      => __( '900 × 2000 mm', 'restwell-retreats' ),
				__( 'Overall frame', 'restwell-retreats' )          => __( '930 × 2250 mm', 'restwell-retreats' ),
				__( 'Platform height', 'restwell-retreats' )        => __( '220–800 mm', 'restwell-retreats' ),
				__( 'Profiling', 'restwell-retreats' )              => __( 'Four-section: backrest with auto-regression, kneebreak, Trendelenburg and anti-Trendelenburg', 'restwell-retreats' ),
				__( 'Mattress', 'restwell-retreats' )               => __( 'Accora Allevia Comfort FirmEdge 90 cm, or Roma Medical MATT 1 — both pressure-relieving', 'restwell-retreats' ),
				__( 'Side rails', 'restwell-retreats' )             => __( 'Fabric siderail set, 200 cm', 'restwell-retreats' ),
				__( 'Minimum user height', 'restwell-retreats' )    => __( '1460 mm', 'restwell-retreats' ),
				__( 'Carer access', 'restwell-retreats' )           => __( 'Space for a carer on both sides of the bed', 'restwell-retreats' ),
			),
			'note'  => __( 'We have two of these. The accessible bedroom can be set up with one or two, depending on what you need. Tell us when you enquire and the room will be laid out that way before you arrive.', 'restwell-retreats' ),
		),
		array(
			'group'         => 'transfers',
			'name'          => __( 'Joerns Oxford Midi 180 — mobile hoist', 'restwell-retreats' ),
			'where'         => __( 'Kept in the bungalow, usable in any room', 'restwell-retreats' ),
			'lead'          => true,
			'figure'        => '180 kg',
			'figure_label'  => __( 'Safe working load', 'restwell-retreats' ),
			'specs'         => array(
				__( 'Safe working load', 'restwell-retreats' )       => __( '180 kg / 28 st', 'restwell-retreats' ),
				__( 'Turning radius', 'restwell-retreats' )          => __( '1235 mm', 'restwell-retreats' ),
				__( 'Legs open, external', 'restwell-retreats' )     => __( '1170 mm', 'restwell-retreats' ),
				__( 'Legs closed, external', 'restwell-retreats' )   => __( '600 mm', 'restwell-retreats' ),
				__( 'Leg height', 'restwell-retreats' )              => __( '100 mm', 'restwell-retreats' ),
				__( 'Ground clearance', 'restwell-retreats' )        => __( '25 mm', 'restwell-retreats' ),
				__( 'Spreader bar height', 'restwell-retreats' )     => __( '525–1660 mm', 'restwell-retreats' ),
				__( 'Emergency descent', 'restwell-retreats' )       => __( 'Manual', 'restwell-retreats' ),
				__( 'Thorough examination', 'restwell-retreats' )    => __( 'LOLER, every six months', 'restwell-retreats' ),
			),
		),
		array(
			'group'         => 'transfers',
			'name'          => __( 'AAL RS4 — transfer and standing aid', 'restwell-retreats' ),
			'compact'       => true,
			'figure'        => '185 kg',
			'figure_label'  => __( 'Safe working load', 'restwell-retreats' ),
			'note'          => __( 'The RS4 is an Able Assist device. It is not an Arjo Sara Stedy, and the two are not interchangeable in a handling plan — please check your care plan names the right one.', 'restwell-retreats' ),
			'specs'         => array(
				__( 'Safe working load', 'restwell-retreats' ) => __( '185 kg', 'restwell-retreats' ),
			),
		),
		array(
			'group'         => 'wet-room',
			'name'          => __( 'Level-access wet room', 'restwell-retreats' ),
			'where'         => __( 'Specified by Care Spaces', 'restwell-retreats' ),
			'lead'          => true,
			'image'         => 'bungalow/WR-1-LS.jpg',
			'image_alt'     => __( 'Level-access wet room with grab rails and a shower commode chair', 'restwell-retreats' ),
			'specs'         => array(
				__( 'Floor', 'restwell-retreats' )               => __( 'Level access with no lip, floor-level drain', 'restwell-retreats' ),
				__( 'Toilet support rail', 'restwell-retreats' ) => __( 'NYMAS hinged lift-and-lock, with drop-down leg', 'restwell-retreats' ),
				__( 'Assistance alarm', 'restwell-retreats' )    => __( 'Pull-cord with reset plate and over-door light', 'restwell-retreats' ),
				__( 'Extractor fan', 'restwell-retreats' )       => __( 'Fitted', 'restwell-retreats' ),
			),
		),
		array(
			'group'         => 'wet-room',
			'name'          => __( 'RAZ-AT — tilt-in-space shower commode chair', 'restwell-retreats' ),
			'where'         => __( 'Kept in the wet room', 'restwell-retreats' ),
			'lead'          => true,
			'figure'        => '40°',
			'figure_label'  => __( 'Tilt-in-space', 'restwell-retreats' ),
			'specs'         => array(
				__( 'Tilt-in-space', 'restwell-retreats' )    => __( '40°, with tilt-assist pedal', 'restwell-retreats' ),
				__( 'Seat height', 'restwell-retreats' )      => __( '560 mm', 'restwell-retreats' ),
				__( 'Backrest', 'restwell-retreats' )         => __( 'AdjustaBack, 50 cm, with flip-up armrests', 'restwell-retreats' ),
				__( 'Seat module', 'restwell-retreats' )      => __( 'Moulded, front opening', 'restwell-retreats' ),
				__( 'Footplates', 'restwell-retreats' )       => __( 'Adjustable 410–520 mm, folding plate', 'restwell-retreats' ),
				__( 'Castors', 'restwell-retreats' )          => __( 'Four dual-locking, 5 inch', 'restwell-retreats' ),
				__( 'Headrest', 'restwell-retreats' )         => __( 'Moulded', 'restwell-retreats' ),
				__( 'Commode pan', 'restwell-retreats' )      => __( 'Autoclavable', 'restwell-retreats' ),
				__( 'Hip belt', 'restwell-retreats' )         => __( 'Adjustable', 'restwell-retreats' ),
			),
		),
		array(
			'group'         => 'wet-room',
			'name'          => __( 'Mira Select Flex EV — shower valve', 'restwell-retreats' ),
			'figure'        => 'TMV3',
			'figure_label'  => __( 'Thermostatic valve', 'restwell-retreats' ),
			'specs'         => array(
				__( 'Type', 'restwell-retreats' )    => __( 'Thermostatic, TMV3', 'restwell-retreats' ),
				__( 'Fittings', 'restwell-retreats' ) => __( 'Long riser rail, 2 m hose and handset', 'restwell-retreats' ),
				__( 'Accreditation', 'restwell-retreats' ) => __( 'RNIB Tried & Tested', 'restwell-retreats' ),
			),
		),
		array(
			'group'         => 'wet-room',
			'name'          => __( 'Drive DeVilbiss — shower stool', 'restwell-retreats' ),
			'compact'       => true,
			'figure'        => '136 kg',
			'figure_label'  => __( 'Safe working load', 'restwell-retreats' ),
			'specs'         => array(
				__( 'Safe working load', 'restwell-retreats' ) => __( '136 kg / 21 st', 'restwell-retreats' ),
			),
		),
		array(
			'group'         => 'wet-room',
			'name'          => __( 'Geberit AquaClean Mera Care — wash-dry WC', 'restwell-retreats' ),
			'specs'         => array(
				__( 'Wash', 'restwell-retreats' )       => __( 'WhirlSpray shower, plus lady shower', 'restwell-retreats' ),
				__( 'Dry', 'restwell-retreats' )        => __( 'Warm air dryer', 'restwell-retreats' ),
				__( 'Controls', 'restwell-retreats' )   => __( 'Remote control and touchless wall panel', 'restwell-retreats' ),
				__( 'Odour extraction', 'restwell-retreats' ) => __( 'Fitted, with a soft-closing seat', 'restwell-retreats' ),
			),
		),
		array(
			'group'         => 'wet-room',
			'name'          => __( 'Ropox Swing — height-adjustable washbasin', 'restwell-retreats' ),
			'figure'        => '750–950 mm',
			'figure_label'  => __( 'Basin height range', 'restwell-retreats' ),
			'specs'         => array(
				__( 'Height range', 'restwell-retreats' )   => __( '750–950 mm, manual adjustment', 'restwell-retreats' ),
				__( 'Mounting', 'restwell-retreats' )       => __( 'Swing basin with dock-in unit', 'restwell-retreats' ),
				__( 'Tap', 'restwell-retreats' )            => __( 'Thermostatic mixer, lever operation, safe-touch body, TMV3 approved', 'restwell-retreats' ),
			),
		),
		array(
			'group'         => 'kitchen',
			'name'          => __( 'NEFF Slide & Hide — oven', 'restwell-retreats' ),
			'where'         => __( 'Open-plan, wheelchair access to worktops', 'restwell-retreats' ),
			'lead'          => true,
			'image'         => 'bungalow/KT-1-LS.jpg',
			'image_alt'     => __( 'Kitchen with seated-height worktops and a NEFF Slide and Hide oven', 'restwell-retreats' ),
			'specs'         => array(
				__( 'Oven', 'restwell-retreats' )   => __( 'NEFF Slide & Hide — the door folds away underneath, so you are not reaching across a hot open door from a seated position', 'restwell-retreats' ),
				__( 'Hob', 'restwell-retreats' )    => __( 'Gas, not induction — no electromagnetic field from the cooktop, which many guests with pacemakers prefer', 'restwell-retreats' ),
				__( 'Storage', 'restwell-retreats' ) => __( 'Microwave and accessible storage at lower levels', 'restwell-retreats' ),
			),
		),
	);

	$acc_equip_groups = array(
		'getting-in' => array(
			'title' => __( 'Getting in', 'restwell-retreats' ),
			'lede'  => __( 'The driveway is resin-bound, level, and takes two cars including an adapted vehicle. There is no step up into the house from where you park.', 'restwell-retreats' ),
		),
		'transfers'  => array(
			'title' => __( 'Beds and hoists', 'restwell-retreats' ),
			'lede'  => __( 'The accessible bedroom can be set up with one or two profiling beds, depending on what you need.', 'restwell-retreats' ),
		),
		'wet-room'   => array(
			'title' => __( 'Wet room', 'restwell-retreats' ),
			'lede'  => __( 'Level-access throughout, with no lip at the entrance. Specified by Care Spaces.', 'restwell-retreats' ),
		),
		'kitchen'    => array(
			'title' => __( 'Kitchen', 'restwell-retreats' ),
			'lede'  => __( 'Worktops you can reach from a seated position. The living room has a rise-and-recline chair; rear French doors onto the patio give a 1720mm opening.', 'restwell-retreats' ),
		),
	);
	$acc_grouped = array();
	foreach ( $acc_equipment as $acc_equip_item ) {
		$acc_gid = isset( $acc_equip_item['group'] ) ? (string) $acc_equip_item['group'] : '';
		if ( '' === $acc_gid || ! isset( $acc_equip_groups[ $acc_gid ] ) ) {
			$acc_gid = 'getting-in';
		}
		$acc_grouped[ $acc_gid ][] = $acc_equip_item;
	}

	/*
	 * Chapter numbers for the register.
	 *
	 * The numerals give the register the shape of a document, so a reader can
	 * say which chapter they are in and where they are up to. The sticky
	 * subnav is the only index on the page — this section used to publish a
	 * second one of its own, which was the same job twice. The limits chapter
	 * is numbered last because the honest caveats belong inside the spec
	 * document, not stranded in a band of their own after it.
	 */
	$acc_chapter_ids = array();
	foreach ( $acc_equip_groups as $acc_gid => $acc_gmeta ) {
		if ( empty( $acc_grouped[ $acc_gid ] ) ) {
			continue;
		}
		$acc_chapter_ids[] = 'equip-' . $acc_gid;
	}
	$acc_chapter_ids[] = 'acc-limits';
	$acc_chapter_no = array();
	foreach ( $acc_chapter_ids as $acc_ci => $acc_chapter_id ) {
		$acc_chapter_no[ $acc_chapter_id ] = str_pad( (string) ( $acc_ci + 1 ), 2, '0', STR_PAD_LEFT );
	}
	?>

	<section class="section-y band-subtle" id="equipment" aria-labelledby="equipment-h">
	  <div class="container">
		<header class="section-head section-head--tight">
		  <p class="eyebrow"><?php esc_html_e( 'Equipment register', 'restwell-retreats' ); ?></p>
		  <h2 id="equipment-h"><?php esc_html_e( 'Named kit, with the numbers a risk assessment needs', 'restwell-retreats' ); ?></h2>
		  <p class="lede"><?php esc_html_e( 'Every piece of equipment fitted in the bungalow, by make and model, with safe working loads and clearances taken from the manufacturers’ own spec sheets. If you need a measurement that isn’t here, ask and we will go and measure it.', 'restwell-retreats' ); ?></p>
		</header>
		<div class="acc-register-doc">
		  <div class="acc-register-doc__intro">
			<aside class="download-panel equip-register__aside">
			  <p><?php esc_html_e( 'Room-by-room photos and the property tour live on the property page. This register is the spec sheet — makes, models, and safe working loads.', 'restwell-retreats' ); ?></p>
			  <p><a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'the-property' ) ); ?>"><?php esc_html_e( 'Tour the property', 'restwell-retreats' ); ?></a></p>
			</aside>
			<div class="equip-notice equip-notice--quiet" id="equip-slings">
			  <p class="equip-notice__title"><?php esc_html_e( 'Please bring your own slings', 'restwell-retreats' ); ?></p>
			  <p><?php esc_html_e( 'Slings are prescribed items of personal care. They are fitted to the individual and to the hoist mechanism, so we cannot safely supply them. Both hoists here take loop-style slings on a two-point spreader bar. Bring the sling the person already uses.', 'restwell-retreats' ); ?></p>
			</div>
		  </div>

		<?php foreach ( $acc_equip_groups as $acc_gid => $acc_gmeta ) : ?>
			<?php
			if ( empty( $acc_grouped[ $acc_gid ] ) ) {
				continue;
			}
			$acc_group_items = $acc_grouped[ $acc_gid ];
			$acc_gtitle      = isset( $acc_gmeta['title'] ) ? (string) $acc_gmeta['title'] : '';
			$acc_glede       = isset( $acc_gmeta['lede'] ) ? (string) $acc_gmeta['lede'] : '';
			$acc_heading_id  = 'equip-' . $acc_gid . '-h';
			$acc_pack_image  = '';
			$acc_pack_alt    = '';
			$acc_pack_facts  = array();
			foreach ( $acc_group_items as $acc_pack_item ) {
				if ( '' === $acc_pack_image && ! empty( $acc_pack_item['image'] ) ) {
					$acc_pack_image = (string) $acc_pack_item['image'];
					$acc_pack_alt   = isset( $acc_pack_item['image_alt'] ) ? (string) $acc_pack_item['image_alt'] : '';
					if ( '' === $acc_pack_alt && function_exists( 'restwell_theme_image_alt' ) ) {
						$acc_pack_alt = restwell_theme_image_alt( $acc_pack_image );
					}
				}
				$acc_pack_figure = isset( $acc_pack_item['figure'] ) ? (string) $acc_pack_item['figure'] : '';
				if ( '' !== $acc_pack_figure && preg_match( '/\d/', $acc_pack_figure ) && count( $acc_pack_facts ) < 3 ) {
					$acc_pack_facts[] = array(
						'value' => $acc_pack_figure,
						'label' => isset( $acc_pack_item['figure_label'] ) ? (string) $acc_pack_item['figure_label'] : '',
					);
				}
			}
			?>
		<section class="equip-group acc-package" id="equip-<?php echo esc_attr( $acc_gid ); ?>" aria-labelledby="<?php echo esc_attr( $acc_heading_id ); ?>">
		  <div class="equip-group-panel acc-package__panel">
			<?php if ( '' !== $acc_pack_image ) : ?>
			<figure class="acc-package__media">
			  <img src="<?php echo esc_url( restwell_theme_image_url( $acc_pack_image ) ); ?>" alt="<?php echo esc_attr( $acc_pack_alt ); ?>" width="1200" height="750" loading="lazy" decoding="async" />
			</figure>
			<?php endif; ?>
			<div class="acc-package__body">
		  <h3 id="<?php echo esc_attr( $acc_heading_id ); ?>" class="equip-group__title" data-chapter="<?php echo esc_attr( $acc_chapter_no[ 'equip-' . $acc_gid ] ); ?>"><?php echo esc_html( $acc_gtitle ); ?></h3>
			<?php if ( '' !== $acc_glede ) : ?>
		  <p class="equip-group__lede"><?php echo esc_html( $acc_glede ); ?></p>
		  <?php endif; ?>
			<?php if ( ! empty( $acc_pack_facts ) ) : ?>
		  <ul class="acc-package__facts" role="list">
				<?php foreach ( $acc_pack_facts as $acc_pack_fact ) : ?>
			<li class="acc-package__fact">
			  <span class="acc-package__fact-value"><?php echo esc_html( $acc_pack_fact['value'] ); ?></span>
				<?php if ( '' !== $acc_pack_fact['label'] ) : ?>
			  <span class="acc-package__fact-label"><?php echo esc_html( $acc_pack_fact['label'] ); ?></span>
			  <?php endif; ?>
			</li>
			<?php endforeach; ?>
		  </ul>
		  <?php endif; ?>
		  <ul class="equip-list" role="list">
			<?php foreach ( $acc_group_items as $acc_equip_item ) : ?>
				<?php
				$acc_item_lead    = ! empty( $acc_equip_item['lead'] );
				$acc_item_compact = ! empty( $acc_equip_item['compact'] );
				$acc_item_image   = isset( $acc_equip_item['image'] ) ? (string) $acc_equip_item['image'] : '';
				if ( '' !== $acc_pack_image && $acc_item_image === $acc_pack_image ) {
					$acc_item_image = '';
				}
				$acc_item_figure  = isset( $acc_equip_item['figure'] ) ? (string) $acc_equip_item['figure'] : '';
				$acc_item_flabel  = isset( $acc_equip_item['figure_label'] ) ? (string) $acc_equip_item['figure_label'] : '';
				$acc_item_where   = isset( $acc_equip_item['where'] ) ? (string) $acc_equip_item['where'] : '';
				$acc_item_note    = isset( $acc_equip_item['note'] ) ? (string) $acc_equip_item['note'] : '';
				$acc_item_specs   = isset( $acc_equip_item['specs'] ) && is_array( $acc_equip_item['specs'] ) ? $acc_equip_item['specs'] : array();
				$acc_figure_metric = '' !== $acc_item_figure && (bool) preg_match( '/\d/', $acc_item_figure );
				$acc_show_name    = $acc_item_lead || ( $acc_equip_item['name'] !== $acc_gtitle );
				$acc_item_class   = 'equip-item';
				if ( $acc_item_lead ) {
					$acc_item_class .= ' equip-item--lead';
				} elseif ( $acc_item_compact ) {
					$acc_item_class .= ' equip-item--compact';
				}
				$acc_item_alt = '';
				if ( '' !== $acc_item_image ) {
					$acc_item_alt = isset( $acc_equip_item['image_alt'] ) ? (string) $acc_equip_item['image_alt'] : '';
					if ( '' === $acc_item_alt && function_exists( 'restwell_theme_image_alt' ) ) {
						$acc_item_alt = restwell_theme_image_alt( $acc_item_image );
					}
				}
				?>
		  <li class="<?php echo esc_attr( $acc_item_class ); ?>">
				<?php if ( $acc_item_lead ) : ?>
			<div class="equip-item__mast">
					<?php if ( '' !== $acc_item_image ) : ?>
			  <figure class="equip-item__photo">
				<img src="<?php echo esc_url( restwell_theme_image_url( $acc_item_image ) ); ?>" alt="<?php echo esc_attr( $acc_item_alt ); ?>" width="900" height="675" loading="lazy" decoding="async" />
			  </figure>
			  <?php endif; ?>
			  <div class="equip-item__ident">
					<?php if ( $acc_show_name ) : ?>
				<h4 class="equip-item__name"><?php echo esc_html( $acc_equip_item['name'] ); ?></h4>
				<?php endif; ?>
					<?php if ( '' !== $acc_item_where ) : ?>
				<p class="equip-item__where"><?php echo esc_html( $acc_item_where ); ?></p>
				<?php endif; ?>
					<?php if ( $acc_figure_metric ) : ?>
				<p class="equip-item__figure">
				  <span class="equip-item__figure-value"><?php echo esc_html( $acc_item_figure ); ?></span>
						<?php if ( '' !== $acc_item_flabel ) : ?>
				  <span class="equip-item__figure-label"><?php echo esc_html( $acc_item_flabel ); ?></span>
				  <?php endif; ?>
				</p>
				<?php endif; ?>
			  </div>
					<?php if ( ! empty( $acc_item_specs ) ) : ?>
			  <dl class="equip-item__specs">
						<?php foreach ( $acc_item_specs as $acc_equip_label => $acc_equip_value ) : ?>
				<div class="equip-spec">
				  <dt><?php echo esc_html( $acc_equip_label ); ?></dt>
				  <dd><?php echo esc_html( $acc_equip_value ); ?></dd>
				</div>
				<?php endforeach; ?>
			  </dl>
			  <?php endif; ?>
					<?php if ( '' !== $acc_item_note ) : ?>
			  <p class="equip-item__note"><?php echo esc_html( $acc_item_note ); ?></p>
			  <?php endif; ?>
			</div>
			<?php else : ?>
			<div class="equip-item__head">
				<?php if ( $acc_show_name ) : ?>
			  <h4 class="equip-item__name"><?php echo esc_html( $acc_equip_item['name'] ); ?></h4>
			  <?php endif; ?>
				<?php if ( $acc_figure_metric ) : ?>
			  <p class="equip-item__figure">
				<span class="equip-item__figure-value"><?php echo esc_html( $acc_item_figure ); ?></span>
					<?php if ( '' !== $acc_item_flabel ) : ?>
				<span class="equip-item__figure-label"><?php echo esc_html( $acc_item_flabel ); ?></span>
				<?php endif; ?>
			  </p>
			  <?php endif; ?>
			</div>
			<?php endif; ?>
				<?php if ( ! $acc_item_lead && ! $acc_item_compact && ! empty( $acc_item_specs ) ) : ?>
			<dl class="equip-item__specs">
					<?php foreach ( $acc_item_specs as $acc_equip_label => $acc_equip_value ) : ?>
			  <div class="equip-spec">
				<dt><?php echo esc_html( $acc_equip_label ); ?></dt>
				<dd><?php echo esc_html( $acc_equip_value ); ?></dd>
			  </div>
			  <?php endforeach; ?>
			</dl>
			<?php endif; ?>
				<?php if ( '' !== $acc_item_note && ! $acc_item_lead ) : ?>
			<p class="equip-item__note"><?php echo esc_html( $acc_item_note ); ?></p>
			<?php endif; ?>
		  </li>
			<?php endforeach; ?>
		  </ul>
			<?php if ( 'transfers' === $acc_gid ) : ?>
		  <div class="equip-notice equip-notice--quiet">
			<p class="equip-notice__title"><?php esc_html_e( 'Bringing your own mobile hoist', 'restwell-retreats' ); ?></p>
			<p><?php esc_html_e( 'The bed platform lowers to 220 mm. The Oxford Midi’s legs stand 100 mm high with 25 mm of ground clearance, and its turning radius is 1235 mm. If you are bringing your own hoist, measure its leg height and turning circle against those figures, and tell us what you are bringing so we can set the room up for it.', 'restwell-retreats' ); ?></p>
		  </div>
			<?php endif; ?>
			</div>
		  </div>
		</section>
		<?php endforeach; ?>

		<?php
		/*
		 * Closing chapter. The caveats are part of the register: every line
		 * above is kit we own and can point a tape measure at, and this says
		 * where that stops. Read after the specs it qualifies, not in a band
		 * of its own where it was easy to scroll past.
		 */
		?>
		<section class="equip-group equip-group--close" id="acc-limits" aria-labelledby="acc-limits-h">
		  <div class="equip-group-panel">
			<h3 id="acc-limits-h" class="equip-group__title" data-chapter="<?php echo esc_attr( $acc_chapter_no['acc-limits'] ); ?>"><?php esc_html_e( 'What we can’t promise', 'restwell-retreats' ); ?></h3>
			<p class="equip-group__lede"><?php esc_html_e( 'We can’t guarantee every piece of specialist equipment at short notice. Some has to be hired in, and some depends on what’s available that week. What we can promise is a straight answer quickly rather than leaving you hoping.', 'restwell-retreats' ); ?></p>
			<p class="acc-limits__contact">
			  <?php
				echo wp_kses(
					sprintf(
						/* translators: 1: tel href, 2: visible phone, 3: mailto href, 4: visible email */
						__( 'Ring <a class="text-link" href="%1$s">%2$s</a> or email <a class="text-link" href="%3$s">%4$s</a> and tell us what would make the stay work. Five guests is the limit our safety checks are based on.', 'restwell-retreats' ),
						esc_url( 'tel:' . $acc_host_tel ),
						esc_html( $acc_host_phone ),
						esc_url( 'mailto:' . $acc_host_email ),
						esc_html( $acc_host_email )
					),
					array(
						'a' => array(
							'class' => true,
							'href'  => true,
						),
					)
				);
				?>
			</p>
		  </div>
		</section>
		</div>
	  </div>
	</section>

	<section class="section-y band-white" id="destination" aria-labelledby="destination-h">
	  <div class="container">
		  <header class="section-head section-head--tight">
			<?php if ( '' !== $acc_dest_label ) : ?>
			<p class="eyebrow"><?php echo esc_html( $acc_dest_label ); ?></p>
			<?php endif; ?>
			<h2 id="destination-h"><?php echo esc_html( $acc_dest_heading ); ?></h2>
			<?php if ( '' !== $acc_dest_intro ) : ?>
			<p class="lede"><?php echo esc_html( $acc_dest_intro ); ?></p>
			<?php endif; ?>
		  </header>
		  <?php
			/*
			 * The good and the challenges are a pair — set them as one so the
			 * balance is the point. The reality is the conclusion drawn from
			 * them, not a third column of equal weight; as three matching
			 * columns the verdict read like another category.
			 */
			$acc_dest_pair    = array_slice( $acc_dest_items, 0, 2 );
			$acc_dest_reality = isset( $acc_dest_items[2] ) ? $acc_dest_items[2] : null;
			?>
		  <dl class="comparison-list comparison-list--2 acc-dest__pair">
			<?php foreach ( $acc_dest_pair as $acc_dest_item ) : ?>
			<div class="comparison-list__item">
			  <dt><?php echo esc_html( $acc_dest_item['dt'] ); ?></dt>
			  <dd><?php echo esc_html( $acc_dest_item['dd'] ); ?></dd>
			</div>
			<?php endforeach; ?>
		  </dl>
			<?php if ( null !== $acc_dest_reality ) : ?>
		  <div class="acc-dest__verdict">
			<p class="acc-dest__verdict-label"><?php echo esc_html( $acc_dest_reality['dt'] ); ?></p>
			<p class="acc-dest__verdict-body"><?php echo esc_html( $acc_dest_reality['dd'] ); ?></p>
		  </div>
			<?php endif; ?>
	  </div>
	</section>
	<section class="section-y band-subtle" id="faq" aria-labelledby="faq-h">
	  <div class="container">
		<header class="section-head section-head--tight">
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
					'list_class'   => '',
					'wrap_columns' => false,
					'columns'      => array( $acc_faq_accordion ),
				)
			);
			?>
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
		  <p class="lede">This page is Restwell’s property-specific statement. For a general checklist of measurements, red flags and OT questions, see <a class="text-link" href="<?php echo esc_url( $restwell_access_guide_url ); ?>"><?php echo esc_html( rtrim( get_the_title( $restwell_access_guide ), '.' ) ); ?>.</a></p>
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
