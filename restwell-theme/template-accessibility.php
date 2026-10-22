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
$restwell_acc_hero_lede = 'This is the full access statement for Restwell, our single-storey adapted bungalow in Whitstable, so you can check it against your own needs before you book.';
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
	'We publish makes, models and safe working loads because we know who reads this page. Somebody has told you a place was accessible before, and it wasn’t, and you found out standing in a doorway with your coat still on. Or you’re an occupational therapist who’s been asked to sign off a stay on the strength of three photographs.',
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
$acc_statement_heading = __( 'The house in numbers', 'restwell-retreats' );
$acc_statement_body    = __( 'We publish makes, models and safe working loads because we know who reads this page. Somebody has told you a place was accessible before, and it wasn’t, and you found out standing in a doorway with your coat still on. Or you’re an occupational therapist who’s been asked to sign off a stay on the strength of three photographs. If there’s a measurement we haven’t published, ring us and we’ll go and take it properly.', 'restwell-retreats' );

$acc_host_phone = function_exists( 'restwell_get_public_phone_number' )
	? restwell_get_public_phone_number()
	: '01622 809881';
$acc_host_tel   = function_exists( 'restwell_get_public_phone_tel' )
	? restwell_get_public_phone_tel()
	: '01622809881';
$acc_host_email = function_exists( 'restwell_get_public_enquiry_email' )
	? restwell_get_public_enquiry_email()
	: 'hello@restwellretreats.co.uk';

$acc_dest_heading = $acc_txt( 'acc_dest_heading', 'Getting around Whitstable' );
$acc_dest_intro   = $acc_txt(
	'acc_dest_intro',
	'Whitstable is an old seaside town, so some parts are easier to get around than others. Here’s what we’ve found.'
);
$acc_dest_items   = array(
	array(
		'dt' => $acc_txt( 'acc_dest_good_heading', 'The good' ),
		'dd' => $acc_txt(
			'acc_dest_good_body',
			'Tankerton promenade is a long, level, surfaced path along the seafront, and it’s the route most of our guests use. There’s free Blue Badge parking along Marine Parade. There are accessible toilets along the promenade, and a Changing Places toilet at the harbour. The streets around the bungalow are level and paved, with dropped kerbs.'
		),
	),
	array(
		'dt' => $acc_txt( 'acc_dest_challenge_heading', 'The challenges' ),
		'dd' => $acc_txt(
			'acc_dest_challenge_body',
			'Harbour Street and the old town have narrow pavements that get crowded at weekends and in summer. Some shops and cafes have a step at the door and no ramp. The ground around the harbour and the fish market can be uneven. Weekday mornings are the easiest time to visit.'
		),
	),
	array(
		'dt' => $acc_txt( 'acc_dest_reality_heading', 'The reality' ),
		'dd' => $acc_txt(
			'acc_dest_reality_body',
			'Our Whitstable guide lists the routes, cafes and accessible toilets we know work, and we send the same notes in your welcome pack.'
		),
	),
);

$acc_faq_label   = $acc_txt( 'acc_faq_label', 'Equipment & access' );
$acc_faq_heading = $acc_txt( 'acc_faq_heading', 'Access FAQ' );
$acc_faq_intro   = $acc_txt(
	'acc_faq_intro',
	'The questions people ask most about the hoists, the beds and what wheelchair friendly should really mean.'
);
$acc_faq_live    = array(
	1 => array(
		'q' => 'Do you provide hoist slings?',
		'a' => 'No. Please bring the sling the person already uses. Both hoists take loop-style slings on a two-point spreader bar, and the note above the equipment register explains why we can’t supply one.',
	),
	2 => array(
		'q' => 'What is a ceiling track hoist in holiday accommodation?',
		'a' => 'It’s fixed to the ceiling and moves a person in a sling along a rail, so it takes up no floor space and needs no turning circle, unlike a mobile hoist, which has to be wheeled into place. Ours covers the whole of the accessible bedroom, and the details are in the equipment register above.',
	),
	3 => array(
		'q' => 'Why does a profiling bed matter in an accessible bedroom?',
		'a' => 'It helps with positioning, pressure care and safer transfers, and it sets a working height that protects the back of whoever is giving care. A fixed divan gives you none of that, and a mobile hoist often can’t get its legs under one. We have two profiling beds, and the accessible bedroom takes one or both.',
	),
	4 => array(
		'q' => 'What should wheelchair friendly actually mean?',
		'a' => 'It should mean published numbers you can check against your own chair and your own kit, like clear door openings, step-free routes, safe working loads and turning circles. If a listing says wheelchair friendly but won’t give you a measurement when you ask, that tells you what you need to know. Everything we have is on this page.',
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
	'Type in your chair’s width and see the clearance at each doorway before you enquire.'
);
$acc_fit_note          = $acc_txt(
	'acc_fit_note',
	'This is a guide only. Aim for at least 50mm of clearance where you can, and we’re happy to talk your measurements through before you book.'
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
	  <div class="container">
		<?php
		// The house in numbers (20 Oct 2026): a typed index after a luxury
		// listing site on Dribbble, each item's name on the left and a large
		// light number on the right, with the front door beside it. Each label
		// splits at its comma into a name and a note ("Front door" / "clear
		// opening"), so the copy stays one editable field.
		$acc_figure_kses = array(
			'span' => array(
				'class' => true,
			),
		);
		$acc_figures     = array(
			array( $acc_stat_1_value, $acc_stat_1_label ),
			array( $acc_stat_2_value, $acc_stat_2_label ),
			array( $acc_stat_3_value, $acc_stat_3_label ),
		);
		?>
		<div class="acc-index">
		  <div class="acc-index__copy">
			<h2 id="statement-h"><?php echo esc_html( $acc_statement_heading ); ?></h2>
			<p class="lede"><?php echo esc_html( $acc_statement_body ); ?></p>
			<dl class="acc-index__list">
			  <?php foreach ( $acc_figures as $acc_figure ) : ?>
					<?php $acc_figure_parts = array_map( 'trim', explode( ',', (string) $acc_figure[1], 2 ) ); ?>
			  <div class="acc-index__row">
				<dt>
				  <span class="acc-index__name"><?php echo esc_html( $acc_figure_parts[0] ); ?></span>
					<?php if ( isset( $acc_figure_parts[1] ) && '' !== $acc_figure_parts[1] ) : ?>
				  <span class="acc-index__note"><?php echo esc_html( ucfirst( $acc_figure_parts[1] ) ); ?></span>
					<?php endif; ?>
				</dt>
				<dd><?php echo wp_kses( restwell_format_acc_figure_value( (string) $acc_figure[0] ), $acc_figure_kses ); ?></dd>
			  </div>
			  <?php endforeach; ?>
			</dl>
		  </div>
		  <img class="acc-index__photo" src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/FD-1-LS.jpg' ) ); ?>" alt="" width="2400" height="1500" sizes="(min-width: 960px) 460px, 100vw" loading="lazy" decoding="async" />
		</div>
	  </div>
	</section>

	<section class="section-y band-white acc-fit" id="fit-check" aria-labelledby="fit-check-h">
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
		<div class="door-check" data-fit-check>
		  <div class="door-check__controls">
			<label class="door-check__label" for="fit-check-number"><?php esc_html_e( 'Your chair’s width', 'restwell-retreats' ); ?></label>
			<div class="door-check__readout">
			  <input class="door-check__number" type="number" id="fit-check-number" data-fit-number inputmode="decimal" min="500" max="1050" step="1" value="700" aria-describedby="fit-check-hint fit-check-summary" />
			  <div class="door-check__units" role="group" aria-label="<?php esc_attr_e( 'Measurement units', 'restwell-retreats' ); ?>">
				<button type="button" data-fit-unit="mm" aria-pressed="true">mm</button>
				<button type="button" data-fit-unit="in" aria-pressed="false">in</button>
			  </div>
			</div>
			<p class="door-check__hint" id="fit-check-hint"><?php esc_html_e( 'The widest point, wheel to wheel, hand rims included.', 'restwell-retreats' ); ?></p>
			<div class="door-check__presets" role="group" aria-labelledby="fit-check-presets-h">
			  <p class="door-check__presets-title" id="fit-check-presets-h"><?php esc_html_e( 'Or start from a typical chair', 'restwell-retreats' ); ?></p>
			  <div class="door-check__chips">
				<button type="button" class="door-check__chip" data-fit-preset="570" aria-pressed="false" aria-label="<?php echo esc_attr__( 'Set checker to 570 millimetres, typical transit chair', 'restwell-retreats' ); ?>"><?php esc_html_e( 'Transit', 'restwell-retreats' ); ?></button>
				<button type="button" class="door-check__chip" data-fit-preset="660" aria-pressed="false" aria-label="<?php echo esc_attr__( 'Set checker to 660 millimetres, typical self-propelled chair', 'restwell-retreats' ); ?>"><?php esc_html_e( 'Self-propelled', 'restwell-retreats' ); ?></button>
				<button type="button" class="door-check__chip" data-fit-preset="700" aria-pressed="true" aria-label="<?php echo esc_attr__( 'Set checker to 700 millimetres, typical powered chair', 'restwell-retreats' ); ?>"><?php esc_html_e( 'Powered', 'restwell-retreats' ); ?></button>
				<button type="button" class="door-check__chip" data-fit-preset="800" aria-pressed="false" aria-label="<?php echo esc_attr__( 'Set checker to 800 millimetres, typical bariatric chair', 'restwell-retreats' ); ?>"><?php esc_html_e( 'Bariatric', 'restwell-retreats' ); ?></button>
			  </div>
			</div>
		  </div>
		  <div class="door-check__results">
			<p class="door-check__verdict" id="fit-check-summary" data-fit-summary role="status" aria-live="polite"></p>
			<div class="door-check__doors">
			  <?php
				$acc_doors = array(
					array( 965, __( 'Front door', 'restwell-retreats' ), 'the front door' ),
					array( 926, __( 'Internal doors', 'restwell-retreats' ), 'the internal doors' ),
				);
				foreach ( $acc_doors as $acc_door ) :
					?>
			  <div class="door-check__door" data-fit-gauge data-door-width="<?php echo (int) $acc_door[0]; ?>" data-fit-name="<?php echo esc_attr( $acc_door[2] ); ?>">
				<div class="door-check__door-head">
				  <span class="door-check__door-name"><?php echo esc_html( $acc_door[1] ); ?></span>
				  <span class="door-check__result" data-fit-result></span>
				</div>
				<div class="door-check__track" aria-hidden="true">
				  <span class="door-check__jamb door-check__jamb--start"></span>
				  <span class="door-check__chair" data-fit-fill></span>
				  <span class="door-check__jamb door-check__jamb--end"></span>
				</div>
				<p class="door-check__door-width"><span data-fit-spec><?php echo (int) $acc_door[0]; ?>mm</span> <?php esc_html_e( 'clear opening', 'restwell-retreats' ); ?></p>
			  </div>
				<?php endforeach; ?>
			</div>
		  </div>
		</div>
		<p class="door-check__foot">
			<?php if ( '' !== $acc_fit_note ) : ?>
				<?php echo esc_html( $acc_fit_note ); ?>
			<?php endif; ?>
			<?php esc_html_e( 'Guidance:', 'restwell-retreats' ); ?>
		  <a class="text-link" href="https://www.gov.uk/government/publications/access-to-and-use-of-buildings-approved-document-m" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Approved Document M', 'restwell-retreats' ); ?><span class="sr-only"> <?php esc_html_e( '(opens in a new tab)', 'restwell-retreats' ); ?></span></a>
			<?php esc_html_e( 'and', 'restwell-retreats' ); ?>
		  <a class="text-link" href="https://www.bsigroup.com/en-GB/standards/bs-8300-1-and-2/" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'BS 8300', 'restwell-retreats' ); ?><span class="sr-only"> <?php esc_html_e( '(opens in a new tab)', 'restwell-retreats' ); ?></span></a>.
		</p>
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
	 * chapter (photo, headline numbers), then one spec card per piece of kit
	 * with its figures in a two-column key grid (5 Oct 2026 redesign). The
	 * property page remains the full room tour.
	 */
	$acc_equipment    = restwell_accessibility_equipment();
	$acc_equip_groups = restwell_accessibility_equipment_groups();
	$acc_grouped = array();
	foreach ( $acc_equipment as $acc_equip_item ) {
		$acc_gid = isset( $acc_equip_item['group'] ) ? (string) $acc_equip_item['group'] : '';
		if ( '' === $acc_gid || ! isset( $acc_equip_groups[ $acc_gid ] ) ) {
			$acc_gid = 'getting-in';
		}
		$acc_grouped[ $acc_gid ][] = $acc_equip_item;
	}
	?>

	<section class="section-y band-subtle" id="equipment" aria-labelledby="equipment-h">
	  <div class="container">
		<header class="section-head section-head--tight">
		  <p class="eyebrow"><?php esc_html_e( 'Equipment', 'restwell-retreats' ); ?></p>
		  <h2 id="equipment-h"><?php esc_html_e( 'The kit, room by room', 'restwell-retreats' ); ?></h2>
		  <p class="lede"><?php esc_html_e( 'Each piece of kit is listed by make and model, using the makers’ own figures. You can download the full list as a PDF for a risk assessment.', 'restwell-retreats' ); ?></p>
		</header>


		<?php
		/*
		 * Rooms at a glance: a photo and three headline figures per room. The
		 * full spec tables sit in the collapsed register below (and in the PDF).
		 */
		?>
		<ul class="acc-glance" role="list">
		  <?php foreach ( $acc_equip_groups as $acc_gid => $acc_gmeta ) : ?>
				<?php
				if ( empty( $acc_grouped[ $acc_gid ] ) ) {
					continue;
				}
				$acc_gl_image = '';
				$acc_gl_alt   = '';
				$acc_gl_facts = isset( $acc_gmeta['facts'] ) ? (array) $acc_gmeta['facts'] : array();
				$acc_gl_fixed = ! empty( $acc_gl_facts );
				foreach ( $acc_grouped[ $acc_gid ] as $acc_gl_item ) {
					if ( '' === $acc_gl_image && ! empty( $acc_gl_item['image'] ) ) {
						$acc_gl_image = (string) $acc_gl_item['image'];
						$acc_gl_alt   = isset( $acc_gl_item['image_alt'] ) ? (string) $acc_gl_item['image_alt'] : '';
					}
					$acc_gl_figure = isset( $acc_gl_item['figure'] ) ? (string) $acc_gl_item['figure'] : '';
					// Glance cards take any headline figure (the kitchen's is the oven, not a number); the register keeps measurements only.
					if ( '' === $acc_gl_figure && ! empty( $acc_gl_item['glance_figure'] ) ) {
						$acc_gl_figure = (string) $acc_gl_item['glance_figure'];
						$acc_gl_item['figure_label'] = isset( $acc_gl_item['glance_label'] ) ? (string) $acc_gl_item['glance_label'] : '';
					}
					if ( ! $acc_gl_fixed && '' !== $acc_gl_figure && count( $acc_gl_facts ) < 3 && ! in_array( $acc_gl_figure, array_column( $acc_gl_facts, 'value' ), true ) ) {
						$acc_gl_facts[] = array(
							'value' => $acc_gl_figure,
							'label' => isset( $acc_gl_item['figure_label'] ) ? (string) $acc_gl_item['figure_label'] : '',
						);
					}
				}
				?>
		  <li class="acc-glance__card">
				<?php if ( '' !== $acc_gl_image ) : ?>
			<img class="acc-glance__photo" src="<?php echo esc_url( restwell_theme_image_url( $acc_gl_image ) ); ?>" alt="<?php echo esc_attr( $acc_gl_alt ); ?>" width="800" height="600" sizes="(max-width: 719px) 100vw, (max-width: 1239px) 50vw, 36rem" loading="lazy" decoding="async" />
			<?php endif; ?>
			<div class="acc-glance__body">
			  <h3><?php echo esc_html( $acc_gmeta['title'] ); ?></h3>
			  <p><?php echo esc_html( $acc_gmeta['lede'] ); ?></p>
				  <?php if ( ! empty( $acc_gl_facts ) ) : ?>
			  <dl class="acc-glance__facts">
						<?php foreach ( $acc_gl_facts as $acc_gl_fact ) : ?>
				<div>
				  <dt><?php echo esc_html( $acc_gl_fact['label'] ); ?></dt>
				  <dd><?php echo esc_html( preg_replace( '/(\d)\s+(?=[a-z°])/u', "$1\u{202F}", $acc_gl_fact['value'] ) ); ?></dd>
				</div>
				<?php endforeach; ?>
			  </dl>
			  <?php endif; ?>
			</div>
		  </li>
		  <?php endforeach; ?>
		</ul>

		<aside class="acc-callout" id="equip-slings">
			  <span class="acc-callout__icon" aria-hidden="true"><?php restwell_the_icon( 'triangle-alert' ); ?></span>
			  <div>
				<p class="acc-callout__title"><?php esc_html_e( 'Please bring your own slings', 'restwell-retreats' ); ?></p>
				<p><?php esc_html_e( 'Slings are prescribed for each person and fitted to them and to the hoist, so we can’t safely supply them. Both hoists here take loop-style slings on a two-point spreader bar, so please bring the sling the person already uses.', 'restwell-retreats' ); ?></p>
			  </div>
			</aside>

		<details class="acc-register" id="register">
			  <summary class="acc-register__summary">
				<span class="acc-register__icon" aria-hidden="true"><?php restwell_the_icon( 'clipboard-list' ); ?></span>
				<span class="acc-register__text">
				  <span class="acc-register__title"><?php esc_html_e( 'Full equipment specifications', 'restwell-retreats' ); ?></span>
				  <span class="acc-register__count"><?php echo esc_html( sprintf( /* translators: %d: number of items */ _n( '%d item: make, model and safe working load', '%d items: makes, models and safe working loads', count( $acc_equipment ), 'restwell-retreats' ), count( $acc_equipment ) ) ); ?></span>
				</span>
				<span class="acc-register__toggle" aria-hidden="true"></span>
			  </summary>
			<div class="acc-reg">
				<p class="acc-reg__tour"><?php esc_html_e( 'The property page has the room-by-room photos. This register is the spec sheet, with the makes, models and safe working loads.', 'restwell-retreats' ); ?> <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'the-property' ) ); ?>"><?php esc_html_e( 'Tour the property', 'restwell-retreats' ); ?></a></p>

				<?php $acc_room_first = false; ?>
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
						// One chip per figure: the hoist, bed and mobile hoist all read "180 kg".
						if ( in_array( $acc_pack_figure, array_column( $acc_pack_facts, 'value' ), true ) ) {
							continue;
						}
						if ( '' !== $acc_pack_figure && preg_match( '/\d/', $acc_pack_figure ) && count( $acc_pack_facts ) < 3 ) {
							$acc_pack_facts[] = array(
								'value' => $acc_pack_figure,
								'label' => isset( $acc_pack_item['figure_label'] ) ? (string) $acc_pack_item['figure_label'] : '',
							);
						}
					}
					?>
				<details class="acc-room" id="equip-<?php echo esc_attr( $acc_gid ); ?>"<?php echo $acc_room_first ? ' open' : ''; ?>>
				  <summary class="acc-room__summary">
					<h3 id="<?php echo esc_attr( $acc_heading_id ); ?>"><?php echo esc_html( $acc_gtitle ); ?></h3>
					<?php if ( ! empty( $acc_pack_facts ) ) : ?>
					<span class="acc-room__facts">
						<?php foreach ( $acc_pack_facts as $acc_pack_fact ) : ?>
					  <span class="acc-room__fact"><strong><?php echo esc_html( preg_replace( '/(\d)\s+(?=[a-z°])/u', "$1\u{202F}", $acc_pack_fact['value'] ) ); ?></strong> <?php echo esc_html( $acc_pack_fact['label'] ); ?></span>
					  <?php endforeach; ?>
					</span>
					<?php endif; ?>
					<span class="acc-room__chevron" aria-hidden="true"></span>
				  </summary>
				  <div class="acc-room__body">
					<div class="acc-room__intro">
					  <?php if ( '' !== $acc_glede ) : ?>
					  <p class="acc-chapter__lede"><?php echo esc_html( $acc_glede ); ?></p>
					  <?php endif; ?>
					  <?php if ( '' !== $acc_pack_image ) : ?>
					  <figure class="acc-chapter__photo">
						<img src="<?php echo esc_url( restwell_theme_image_url( $acc_pack_image ) ); ?>" alt="<?php echo esc_attr( $acc_pack_alt ); ?>" width="800" height="600" sizes="(max-width: 767px) 100vw, 16rem" loading="lazy" decoding="async" />
					  </figure>
					  <?php endif; ?>
					</div>
					<div class="acc-kit">
					<?php foreach ( $acc_group_items as $acc_equip_item ) : ?>
						<?php
						$acc_item_compact  = ! empty( $acc_equip_item['compact'] );
						$acc_item_figure   = isset( $acc_equip_item['figure'] ) ? (string) $acc_equip_item['figure'] : '';
						$acc_item_flabel   = isset( $acc_equip_item['figure_label'] ) ? (string) $acc_equip_item['figure_label'] : '';
						$acc_item_where    = isset( $acc_equip_item['where'] ) ? (string) $acc_equip_item['where'] : '';
						$acc_item_note     = isset( $acc_equip_item['note'] ) ? (string) $acc_equip_item['note'] : '';
						$acc_item_specs    = isset( $acc_equip_item['specs'] ) && is_array( $acc_equip_item['specs'] ) ? $acc_equip_item['specs'] : array();
						$acc_figure_metric = '' !== $acc_item_figure && (bool) preg_match( '/\d/', $acc_item_figure );
						?>
					<article class="acc-kit__item<?php echo $acc_item_compact ? ' acc-kit__item--compact' : ''; ?>">
					  <header class="acc-kit__head">
						<div>
						  <h4><?php echo esc_html( $acc_equip_item['name'] ); ?></h4>
						  <?php if ( '' !== $acc_item_where ) : ?>
						  <p class="acc-kit__where"><?php echo esc_html( $acc_item_where ); ?></p>
						  <?php endif; ?>
						</div>
						<?php if ( $acc_figure_metric ) : ?>
						<p class="acc-kit__figure">
						  <span class="acc-kit__figure-value"><?php echo esc_html( preg_replace( '/(\d)\s+(?=[a-z°])/u', "$1\u{202F}", $acc_item_figure ) ); ?></span>
							<?php if ( '' !== $acc_item_flabel ) : ?>
						  <span class="acc-kit__figure-label"><?php echo esc_html( $acc_item_flabel ); ?></span>
						  <?php endif; ?>
						</p>
						<?php endif; ?>
					  </header>
						<?php if ( ! $acc_item_compact && ! empty( $acc_item_specs ) ) : ?>
					  <dl class="acc-kit__specs">
							<?php foreach ( $acc_item_specs as $acc_equip_label => $acc_equip_value ) : ?>
						<div>
						  <dt><?php echo esc_html( $acc_equip_label ); ?></dt>
						  <dd><?php echo esc_html( $acc_equip_value ); ?></dd>
						</div>
						<?php endforeach; ?>
					  </dl>
					  <?php endif; ?>
						<?php if ( '' !== $acc_item_note ) : ?>
					  <p class="acc-kit__note"><?php echo esc_html( $acc_item_note ); ?></p>
					  <?php endif; ?>
					</article>
					<?php endforeach; ?>
					</div>

					<?php if ( 'transfers' === $acc_gid ) : ?>
					<aside class="acc-callout acc-callout--quiet">
					<span class="acc-callout__icon" aria-hidden="true"><?php restwell_the_icon( 'info' ); ?></span>
					<div>
					  <p class="acc-callout__title"><?php esc_html_e( 'Bringing your own mobile hoist', 'restwell-retreats' ); ?></p>
					  <p><?php esc_html_e( 'The bed lowers to 220mm. The Oxford Midi’s legs stand 100mm high with 25mm of ground clearance, and it turns in 1235mm. If you’re bringing your own hoist, check its leg height and turning circle against those figures, and tell us what you’re bringing so we can set the room up for it.', 'restwell-retreats' ); ?></p>
					</div>
					</aside>
					<?php endif; ?>
				  </div>
			</details>
					<?php $acc_room_first = false; ?>
			<?php endforeach; ?>

		</div>
		</details>

		<?php
		$acc_pdf_url  = function_exists( 'restwell_access_statement_pdf_url' ) ? restwell_access_statement_pdf_url() : '';
		$acc_pdf_size = function_exists( 'restwell_access_statement_pdf_size' ) ? restwell_access_statement_pdf_size() : '';
		if ( '' !== $acc_pdf_url ) :
			?>
		<aside class="acc-download" aria-labelledby="acc-download-h">
		  <span class="acc-download__icon" aria-hidden="true"><?php restwell_the_icon( 'file-text' ); ?></span>
		  <div class="acc-download__text">
			<p class="acc-download__title" id="acc-download-h"><?php esc_html_e( 'Download the full access statement', 'restwell-retreats' ); ?></p>
			<p><?php esc_html_e( 'Every measurement and piece of kit on one printable sheet that works with screen readers, for occupational therapists, case managers and funding panels.', 'restwell-retreats' ); ?></p>
		  </div>
		  <a class="btn btn-gold acc-download__btn" href="<?php echo esc_url( $acc_pdf_url ); ?>" download data-analytics-event="access_statement_download">
			<?php restwell_the_icon( 'download' ); ?>
			<?php esc_html_e( 'Download PDF', 'restwell-retreats' ); ?>
			<?php if ( '' !== $acc_pdf_size ) : ?>
			<span class="acc-download__meta"><?php echo esc_html( $acc_pdf_size ); ?></span>
			<?php endif; ?>
		  </a>
		</aside>
		<?php endif; ?>
	  </div>
	</section>

	<?php // Its own section (11 Oct 2026): it closed the equipment band as a sixth block and read as part of the kit list. ?>
	<section class="section-y section-y--slim band-white acc-limits" id="acc-limits" aria-labelledby="acc-limits-h">
	  <div class="container acc-limits__layout">
		<header class="section-head">
		  <p class="eyebrow"><?php esc_html_e( 'Honest limits', 'restwell-retreats' ); ?></p>
		  <h2 id="acc-limits-h"><?php esc_html_e( 'What we can’t promise', 'restwell-retreats' ); ?></h2>
		  <p class="lede"><?php esc_html_e( 'We can’t guarantee every piece of specialist kit at short notice, because some of it has to be hired in and some depends on what’s free that week. What we can promise is a straight answer, quickly, rather than leaving you hoping.', 'restwell-retreats' ); ?></p>
		</header>
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

	<section class="section-y band-subtle" id="destination" aria-labelledby="destination-h">
	  <div class="container">
		<?php
		/*
		 * Getting around (20 Oct 2026): Home's overlapping panel, mirrored, over
		 * a guest on Harbour Beach. The good and the challenges are a pair, so
		 * they sit as two tabs in the panel ([data-tabs] in shared.js; without
		 * it both lists show). The reality is the conclusion, a line under them
		 * with the guide linked, not a third box of equal weight.
		 */
		$acc_dest_pair    = array_slice( $acc_dest_items, 0, 2 );
		$acc_dest_reality = isset( $acc_dest_items[2] ) ? $acc_dest_items[2] : null;
		?>
		<div class="property__layout property__layout--flip">
		  <div class="property__copy acc-dest" data-tabs>
			<h2 id="destination-h"><?php echo esc_html( $acc_dest_heading ); ?></h2>
			<?php if ( '' !== $acc_dest_intro ) : ?>
			<p class="lede"><?php echo esc_html( $acc_dest_intro ); ?></p>
			<?php endif; ?>
			<div class="acc-dest__tabs" role="tablist" aria-label="<?php esc_attr_e( 'Getting around Whitstable', 'restwell-retreats' ); ?>" hidden>
			  <?php foreach ( $acc_dest_pair as $acc_dest_i => $acc_dest_item ) : ?>
			  <button type="button" role="tab" id="dest-tab-<?php echo (int) $acc_dest_i; ?>" aria-controls="dest-<?php echo 0 === $acc_dest_i ? 'good' : 'challenges'; ?>" aria-selected="<?php echo 0 === $acc_dest_i ? 'true' : 'false'; ?>"<?php echo 0 === $acc_dest_i ? '' : ' tabindex="-1"'; ?>><?php echo esc_html( $acc_dest_item['dt'] ); ?></button>
			  <?php endforeach; ?>
			</div>
			<?php foreach ( $acc_dest_pair as $acc_dest_i => $acc_dest_item ) : ?>
				<?php
				// Short lines read faster than a paragraph; the copy is unchanged, just split at sentence ends.
				$acc_dest_lines = preg_split( '/(?<=[.!?])\s+/', trim( (string) $acc_dest_item['dd'] ), -1, PREG_SPLIT_NO_EMPTY );
				?>
			<div class="acc-dest__panel acc-dest__panel--<?php echo 0 === $acc_dest_i ? 'good' : 'watch'; ?>" id="dest-<?php echo 0 === $acc_dest_i ? 'good' : 'challenges'; ?>">
			  <h3 class="acc-dest__panel-title"><?php echo esc_html( $acc_dest_item['dt'] ); ?></h3>
			  <ul class="acc-dest__lines" role="list">
				<?php foreach ( $acc_dest_lines as $acc_dest_line ) : ?>
				<li><?php echo esc_html( $acc_dest_line ); ?></li>
				<?php endforeach; ?>
			  </ul>
			</div>
			<?php endforeach; ?>
			<?php if ( null !== $acc_dest_reality ) : ?>
			<p class="acc-dest__more">
				<?php
				echo wp_kses_post(
					str_replace(
						esc_html__( 'Whitstable guide', 'restwell-retreats' ),
						'<a class="text-link" href="' . esc_url( restwell_nav_resolve_page_url( 'whitstable-area-guide' ) ) . '">' . esc_html__( 'Whitstable guide', 'restwell-retreats' ) . '</a>',
						esc_html( $acc_dest_reality['dd'] )
					)
				);
				?>
			</p>
			<?php endif; ?>
		  </div>
		  <img class="property__photo acc-dest__photo" src="<?php echo esc_url( restwell_theme_image_url( 'journey/guest-harbour-beach.jpg' ) ); ?>" alt="<?php esc_attr_e( 'A guest in a powered wheelchair and a companion on the firm Harbour Beach by the lifeboat station', 'restwell-retreats' ); ?>" width="1620" height="1012" sizes="(min-width: 960px) 760px, 100vw" loading="lazy" decoding="async" />
		</div>
	  </div>
	</section>
	<?php
	$restwell_access_guide     = get_page_by_path( 'how-to-read-holiday-cottage-access-statement', OBJECT, 'post' );
	$restwell_access_guide_url = $restwell_access_guide instanceof WP_Post ? get_permalink( $restwell_access_guide ) : '';
	?>
	<section class="section-y band-white" id="faq" aria-labelledby="faq-h">
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
				$answer = $acc_link_phrase( $answer, 'optional home care', restwell_nav_resolve_page_url( 'optional-care' ) );
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
		<?php if ( $restwell_access_guide_url ) : ?>
			<?php list( $acc_guide_thumb, $acc_guide_thumb_alt ) = restwell_get_post_card_thumb( $restwell_access_guide->ID, 'medium_large' ); ?>
		<aside class="acc-guide" aria-labelledby="access-guide-h">
			<?php if ( '' !== (string) $acc_guide_thumb ) : ?>
		  <a class="acc-guide__media" href="<?php echo esc_url( $restwell_access_guide_url ); ?>" aria-hidden="true" tabindex="-1">
			<img src="<?php echo esc_url( $acc_guide_thumb ); ?>" alt="<?php echo esc_attr( $acc_guide_thumb_alt ); ?>" width="640" height="427" loading="lazy" decoding="async" />
		  </a>
		  <?php endif; ?>
		  <div class="acc-guide__body">
			<p class="eyebrow"><?php esc_html_e( 'Comparing other cottages?', 'restwell-retreats' ); ?></p>
			<h3 id="access-guide-h"><a href="<?php echo esc_url( $restwell_access_guide_url ); ?>"><?php esc_html_e( 'How to read any access statement', 'restwell-retreats' ); ?></a></h3>
			<p><?php esc_html_e( 'This page is Restwell’s own statement. For a general checklist of measurements, red flags and questions for an OT, read our guide.', 'restwell-retreats' ); ?></p>
			<span class="acc-guide__more" aria-hidden="true"><?php esc_html_e( 'Read the guide', 'restwell-retreats' ); ?><?php restwell_the_icon( 'arrow-right' ); ?></span>
		  </div>
		</aside>
		<?php endif; ?>
	  </div>
	</section>

	<?php
	$mid_cta_heading = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_acc_id, 'acc_cta_heading', __( 'Ask about your equipment and clearances.', 'restwell-retreats' ) )
		: __( 'Ask about your equipment and clearances.', 'restwell-retreats' );
	$mid_cta_intro   = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text(
			$restwell_acc_id,
			'acc_cta_body',
			__( 'If you’ve a question about door widths, hoist limits, the wet room or care, ask us and we’ll give you a clear answer.', 'restwell-retreats' )
		)
		: __( 'If you’ve a question about door widths, hoist limits, the wet room or care, ask us and we’ll give you a clear answer.', 'restwell-retreats' );
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
