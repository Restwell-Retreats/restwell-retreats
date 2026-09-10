<?php
/**
 * Template Name: How It Works
 *
 * Concept port from mockups — How It Works.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$restwell_hiw_id      = (int) get_queried_object_id();
$restwell_hiw_heading = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $restwell_hiw_id, 'hiw_heading', 'The bookends of a holiday should be the easy bit' )
	: 'The bookends of a holiday should be the easy bit';
$restwell_hiw_intro   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text(
		$restwell_hiw_id,
		'hiw_intro',
		'Booking Restwell is three steps: enquire, confirm with a deposit, and arrive from 3pm using a key safe.'
	)
	: 'Booking Restwell is three steps: enquire, confirm with a deposit, and arrive from 3pm using a key safe.';
$restwell_hiw_eyebrow = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $restwell_hiw_id, 'hiw_label', '' )
	: '';

/**
 * Prefer live template copy when stored meta still holds known short seeds.
 *
 * @param string   $value Current meta/default value.
 * @param string   $live  Preferred live copy.
 * @param string[] $stale Known outdated strings.
 * @return string
 */
$restwell_hiw_prefer_live = static function ( $value, $live, array $stale = array() ) {
	$value = trim( (string) $value );
	$live  = (string) $live;
	if ( '' === $value ) {
		return $live;
	}
	foreach ( $stale as $old ) {
		if ( $value === $old ) {
			return $live;
		}
	}
	return $value;
};

$hiw_steps_label   = $restwell_hiw_prefer_live(
	function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_hiw_id, 'hiw_steps_label', 'How it works' )
		: 'How it works',
	'How it works',
	array( 'THREE-STEP PROCESS', 'FOUR-STEP PROCESS' )
);
$hiw_steps_heading = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $restwell_hiw_id, 'hiw_steps_heading', 'Enquire, confirm, arrive' )
	: 'Enquire, confirm, arrive';
$hiw_steps_intro   = $restwell_hiw_prefer_live(
	function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_hiw_id, 'hiw_steps_intro', '' )
		: '',
	'Three steps from your first message to the front door. There is no online checkout, and you only pay a deposit after we’ve both agreed the bungalow fits.'
);

$hiw_step_live = array(
	1 => array(
		'title' => 'Enquire',
		'body'  => 'Send us your dates, who’s coming, and anything that would make the house work better for you. We aim to reply within 48 hours. Nothing to pay at this stage.',
		'stale' => array( 'Tell us your dates and what you need. Nothing to pay at this stage.' ),
	),
	2 => array(
		'title' => 'Confirm',
		'body'  => 'We set the house up around what you’ve told us. A 50% deposit reserves the dates; the balance is due a week before you arrive. Care from Continuity stays in the same conversation.',
		'stale' => array( 'We set the house up around you. A 50% deposit reserves the dates.' ),
	),
	3 => array(
		'title' => 'Arrive',
		'body'  => 'Check-in is from 3pm, through a key safe. We send the code and the address with your confirmation, never on the website.',
		'stale' => array( 'From 3pm, through a key safe. The address comes with your confirmation.' ),
	),
	4 => array(
		'title' => '',
		'body'  => '',
		'stale' => array(),
	),
);

$hiw_steps = array();
for ( $i = 1; $i <= 4; $i++ ) {
	$live_title = $hiw_step_live[ $i ]['title'];
	$live_body  = $hiw_step_live[ $i ]['body'];
	$step_title = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_hiw_id, "hiw_step{$i}_title", $live_title )
		: $live_title;
	$step_body  = $restwell_hiw_prefer_live(
		function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text( $restwell_hiw_id, "hiw_step{$i}_body", $live_body )
			: $live_body,
		$live_body,
		$hiw_step_live[ $i ]['stale']
	);
	if ( '' === trim( $step_title ) && '' === trim( $step_body ) ) {
		continue;
	}
	$hiw_steps[] = array(
		'title' => $step_title,
		'body'  => $step_body,
	);
}
if ( empty( $hiw_steps ) ) {
	$hiw_steps = array(
		array(
			'title' => $hiw_step_live[1]['title'],
			'body'  => $hiw_step_live[1]['body'],
		),
		array(
			'title' => $hiw_step_live[2]['title'],
			'body'  => $hiw_step_live[2]['body'],
		),
		array(
			'title' => $hiw_step_live[3]['title'],
			'body'  => $hiw_step_live[3]['body'],
		),
	);
}

$hiw_care_label   = $restwell_hiw_prefer_live(
	function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_hiw_id, 'hiw_care_cta_label', 'Optional care' )
		: 'Optional care',
	'Optional care',
	array( 'CARE SUPPORT' )
);
$hiw_care_heading = $restwell_hiw_prefer_live(
	function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_hiw_id, 'hiw_care_cta_heading', 'Add care only if you need it' )
		: 'Add care only if you need it',
	'Add care only if you need it',
	array( 'Care fits around your routine' )
);
$hiw_care_body    = $restwell_hiw_prefer_live(
	function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text(
			$restwell_hiw_id,
			'hiw_care_cta_body',
			'Home care from Continuity can be added on the same enquiry, quoted separately. Bring your own team if you prefer.'
		)
		: 'Home care from Continuity can be added on the same enquiry, quoted separately. Bring your own team if you prefer.',
	'Home care from Continuity can be added on the same enquiry, quoted separately. Bring your own team if you prefer.',
	array(
		'Care is entirely optional. If you want it, Continuity of Care Services (CQC-regulated and experienced) will work to your schedule, not theirs. Morning check-ins, personal care, or more comprehensive support: you decide.',
		'Ask about Continuity of Care Services when you enquire, or bring your own team. Care can be arranged in the same conversation as your booking.',
		'Continuity home care can be added on the same enquiry, quoted separately. Bring your own team if you prefer.',
	)
);
$hiw_care_btn     = $restwell_hiw_prefer_live(
	function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_hiw_id, 'hiw_care_cta_btn', 'How optional care works' )
		: 'How optional care works',
	'How optional care works',
	array( 'Ask about care options' )
);
$hiw_care_url     = $restwell_hiw_prefer_live(
	function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_hiw_id, 'hiw_care_cta_url', restwell_nav_resolve_page_url( 'optional-care' ) )
		: restwell_nav_resolve_page_url( 'optional-care' ),
	restwell_nav_resolve_page_url( 'optional-care' ),
	array( '/enquire/' )
);

$hiw_arrival_label   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $restwell_hiw_id, 'hiw_arrival_label', 'Arrival day' )
	: 'Arrival day';
$hiw_arrival_heading = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $restwell_hiw_id, 'hiw_arrival_heading', 'Key-safe from 3pm' )
	: 'Key-safe from 3pm';
$hiw_arrival_lede    = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text(
		$restwell_hiw_id,
		'hiw_arrival_lede',
		'There is no reception desk. Park in the driveway, open the key safe, and settle into a house that is already set up for your group.'
	)
	: 'There is no reception desk. Park in the driveway, open the key safe, and settle into a house that is already set up for your group.';

$hiw_arrival_items = array();
$hiw_arrival_live  = array(
	1 => array(
		'dt' => 'Check-in',
		'dd' => 'From 3pm via the key-safe · departure by 11am',
	),
	2 => array(
		'dt' => 'Parking',
		'dd' => 'Level driveway for two cars, including accessible vehicles',
	),
	3 => array(
		'dt' => 'Ready for you',
		'dd' => 'Step-free routes and kit set from your enquiry · guest notes after dates are confirmed',
	),
);
for ( $i = 1; $i <= 3; $i++ ) {
	$dt = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_hiw_id, "hiw_arrival_{$i}_dt", $hiw_arrival_live[ $i ]['dt'] )
		: $hiw_arrival_live[ $i ]['dt'];
	$dd = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_hiw_id, "hiw_arrival_{$i}_dd", $hiw_arrival_live[ $i ]['dd'] )
		: $hiw_arrival_live[ $i ]['dd'];
	if ( '' === trim( $dt ) && '' === trim( $dd ) ) {
		continue;
	}
	$hiw_arrival_items[] = array(
		'dt' => $dt,
		'dd' => $dd,
	);
}
if ( empty( $hiw_arrival_items ) ) {
	$hiw_arrival_items = array_values( $hiw_arrival_live );
}

$hiw_arrival_link1_label = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $restwell_hiw_id, 'hiw_arrival_link1_label', 'Tour the property' )
	: 'Tour the property';
$hiw_arrival_link2_label = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $restwell_hiw_id, 'hiw_arrival_link2_label', 'Door widths and kit notes' )
	: 'Door widths and kit notes';

$hiw_care_type_live = array(
	1 => array(
		'title' => 'Personal care',
		'text'  => 'Washing, dressing and daily routines on agreed times.',
	),
	2 => array(
		'title' => 'Visiting care',
		'text'  => 'Short daytime visits, or support for a promenade or town trip.',
	),
	3 => array(
		'title' => 'Mobility and hoisting',
		'text'  => 'Transfers with the on-site ceiling track and wet-room kit.',
	),
);
$hiw_care_types = array();
for ( $i = 1; $i <= 3; $i++ ) {
	$type_title = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_hiw_id, "hiw_care_type{$i}_title", $hiw_care_type_live[ $i ]['title'] )
		: $hiw_care_type_live[ $i ]['title'];
	$type_text  = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_hiw_id, "hiw_care_type{$i}_text", $hiw_care_type_live[ $i ]['text'] )
		: $hiw_care_type_live[ $i ]['text'];
	if ( '' === trim( $type_title ) && '' === trim( $type_text ) ) {
		continue;
	}
	$hiw_care_types[] = array(
		'title' => $type_title,
		'text'  => $type_text,
	);
}
if ( empty( $hiw_care_types ) ) {
	$hiw_care_types = array_values( $hiw_care_type_live );
}

$hiw_care_note        = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $restwell_hiw_id, 'hiw_care_note', 'We do not add anything until you agree to the support package.' )
	: 'We do not add anything until you agree to the support package.';
$hiw_care_rates_label = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $restwell_hiw_id, 'hiw_care_rates_label', 'See care guide rates' )
	: 'See care guide rates';
$hiw_care_rates_url   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $restwell_hiw_id, 'hiw_care_rates_url', restwell_nav_resolve_page_url( 'pricing' ) . '#care-rates' )
	: restwell_nav_resolve_page_url( 'pricing' ) . '#care-rates';

$hiw_faq_label   = $restwell_hiw_prefer_live(
	function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_hiw_id, 'hiw_faq_label', 'Booking' )
		: 'Booking',
	'Booking',
	array( 'Common questions' )
);
$hiw_faq_heading = $restwell_hiw_prefer_live(
	function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_hiw_id, 'hiw_faq_heading', 'Before you enquire' )
		: 'Before you enquire',
	'Before you enquire',
	array( 'Things people often ask.' )
);
$hiw_faq_intro   = $restwell_hiw_prefer_live(
	function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_hiw_id, 'hiw_faq_intro', '' )
		: '',
	'We will explain when to pay the deposit, who we invoice, arrival details, and how optional care works with a self-catering stay.'
);
?>


<main id="main-content">
<?php
get_template_part(
	'template-parts/concept/photo-hero',
	null,
	array(
		'heading_id' => 'page-h',
		'heading'    => $restwell_hiw_heading,
		'eyebrow'    => $restwell_hiw_eyebrow,
		'intro'      => $restwell_hiw_intro,
		'crumbs'     => array(
			array(
				'label' => __( 'Home', 'restwell-retreats' ),
				'url'   => home_url( '/' ),
			),
			array(
				'label' => 'How It Works',
				'url'   => '',
			),
		),
		'post_id'    => $restwell_hiw_id,
	)
);
?>

	<nav class="subnav" aria-label="On this page" data-toc>
	  <div class="container">
		<ul class="subnav__list">
		  <li><a href="#process">Process</a></li>
		  <li><a href="#arrival">Arrival</a></li>
		  <li><a href="#care">Care</a></li>
		  <li><a href="#faq">FAQ</a></li>
		</ul>
	  </div>
	</nav>

	<section class="section-y band-white process" id="process" aria-labelledby="process-h">
	  <div class="container">
		<header class="section-head section-head--center process__head">
		  <?php if ( '' !== $hiw_steps_label ) : ?>
		  <p class="eyebrow"><?php echo esc_html( $hiw_steps_label ); ?></p>
		  <?php endif; ?>
		  <h2 id="process-h"><?php echo esc_html( $hiw_steps_heading ); ?></h2>
		  <?php if ( '' !== $hiw_steps_intro ) : ?>
		  <p class="lede"><?php echo esc_html( $hiw_steps_intro ); ?></p>
		  <?php endif; ?>
		</header>
		<div class="process__layout">
		  <div class="process__media" data-reveal>
					<img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/patio-1.png' ) ); ?>" alt="Level resin patio and seating area at Restwell" width="900" height="1200" loading="lazy" />
		  </div>
		  <ol class="process-list">
			<?php foreach ( $hiw_steps as $step_i => $step ) : ?>
			<li>
			  <span class="process-list__index" aria-hidden="true"><?php echo esc_html( str_pad( (string) ( $step_i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
			  <div class="process-list__body">
				<?php if ( '' !== $step['title'] ) : ?>
				<h3><?php echo esc_html( $step['title'] ); ?></h3>
				<?php endif; ?>
				<?php if ( '' !== $step['body'] ) : ?>
				<p><?php echo esc_html( $step['body'] ); ?></p>
				<?php endif; ?>
			  </div>
			</li>
			<?php endforeach; ?>
		  </ol>
		</div>
	  </div>
	</section>

	<section class="section-y band-subtle" id="arrival" aria-labelledby="arrival-h">
	  <div class="container split split--flip split--cover">
		<div class="split__media" data-reveal>
			 <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/entrance.png' ) ); ?>" alt="Step-free entrance to the Restwell bungalow" width="900" height="675" loading="lazy" />
		</div>
		<div>
		  <header class="section-head section-head--tight">
			<?php if ( '' !== $hiw_arrival_label ) : ?>
			<p class="eyebrow"><?php echo esc_html( $hiw_arrival_label ); ?></p>
			<?php endif; ?>
			<h2 id="arrival-h"><?php echo esc_html( $hiw_arrival_heading ); ?></h2>
			<?php if ( '' !== $hiw_arrival_lede ) : ?>
			<p class="lede"><?php echo esc_html( $hiw_arrival_lede ); ?></p>
			<?php endif; ?>
		  </header>
		  <dl class="comparison-list">
			<?php foreach ( $hiw_arrival_items as $arrival_item ) : ?>
			<div class="comparison-list__item">
			  <?php if ( '' !== $arrival_item['dt'] ) : ?>
			  <dt><?php echo esc_html( $arrival_item['dt'] ); ?></dt>
			  <?php endif; ?>
			  <?php if ( '' !== $arrival_item['dd'] ) : ?>
			  <dd><?php echo esc_html( $arrival_item['dd'] ); ?></dd>
			  <?php endif; ?>
			</div>
			<?php endforeach; ?>
		  </dl>
		  <?php if ( '' !== $hiw_arrival_link1_label || '' !== $hiw_arrival_link2_label ) : ?>
		  <p class="link-stack">
			<?php if ( '' !== $hiw_arrival_link1_label ) : ?>
			<a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'the-property' ) ); ?>"><?php echo esc_html( $hiw_arrival_link1_label ); ?></a>
			<?php endif; ?>
			<?php if ( '' !== $hiw_arrival_link2_label ) : ?>
			<a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'accessibility' ) ); ?>"><?php echo esc_html( $hiw_arrival_link2_label ); ?></a>
			<?php endif; ?>
		  </p>
		  <?php endif; ?>
		</div>
	  </div>
	</section>

	<section class="care care--tease section-y section-y--compact" id="care" aria-labelledby="care-h">
	  <div class="container">
		<div class="care__tease">
		  <?php if ( '' !== $hiw_care_label ) : ?>
		  <p class="eyebrow"><?php echo esc_html( $hiw_care_label ); ?></p>
		  <?php endif; ?>
		  <h2 id="care-h"><?php echo esc_html( $hiw_care_heading ); ?></h2>
		  <?php if ( '' !== $hiw_care_body ) : ?>
		  <p class="lede"><?php echo esc_html( $hiw_care_body ); ?></p>
		  <?php endif; ?>
		  <?php if ( '' !== $hiw_care_btn && '' !== $hiw_care_url ) : ?>
		  <a class="text-link" href="<?php echo esc_url( $hiw_care_url ); ?>"><?php echo esc_html( $hiw_care_btn ); ?></a>
		  <?php endif; ?>
		</div>
	  </div>
	</section>

	<section class="faq section-y band-subtle" id="faq" aria-labelledby="faq-h">
	  <div class="container">
		<div class="faq__layout">
		  <header class="faq__intro">
			<?php if ( '' !== $hiw_faq_label ) : ?>
			<p class="eyebrow"><?php echo esc_html( $hiw_faq_label ); ?></p>
			<?php endif; ?>
			<h2 id="faq-h"><?php echo esc_html( $hiw_faq_heading ); ?></h2>
			<?php if ( '' !== $hiw_faq_intro ) : ?>
			<p class="lede"><?php echo esc_html( $hiw_faq_intro ); ?></p>
			<?php endif; ?>
		  </header>
		  <?php
			$hiw_faq_items = array();
			foreach ( restwell_get_faq_items( 'how-it-works' ) as $row ) {
				$hiw_faq_items[] = array(
					'q'    => $row['q'],
					'a'    => '<p>' . wp_kses_post( $row['a'] ) . '</p>',
					'open' => ! empty( $row['open'] ),
					'cat'  => isset( $row['cat'] ) ? $row['cat'] : 'booking',
				);
			}
			get_template_part(
				'template-parts/faq-accordion',
				null,
				array(
					'id_prefix'    => 'hiw-q',
					'list_class'   => 'faq-list--split',
					'wrap_columns' => true,
					'columns'      => array( array_slice( $hiw_faq_items, 0, 3 ), array_slice( $hiw_faq_items, 3 ) ),
				)
			);
			?>
		</div>
	  </div>
	</section>

	<?php
	$hiw_mid_cta_heading = $restwell_hiw_prefer_live(
		function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text( $restwell_hiw_id, 'hiw_cta_heading', __( 'Send dates and access needs.', 'restwell-retreats' ) )
			: __( 'Send dates and access needs.', 'restwell-retreats' ),
		__( 'Send dates and access needs.', 'restwell-retreats' ),
		array( 'Start with a conversation.', 'Ready to plan your break?' )
	);
	$hiw_mid_cta_intro   = $restwell_hiw_prefer_live(
		function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text(
				$restwell_hiw_id,
				'hiw_cta_body',
				__( 'We will reply with measurements, equipment notes, and your next steps.', 'restwell-retreats' )
			)
			: __( 'We will reply with measurements, equipment notes, and your next steps.', 'restwell-retreats' ),
		__( 'We will reply with measurements, equipment notes, and your next steps.', 'restwell-retreats' ),
		array(
			'No commitment, no lengthy forms. Just get in touch and we\'ll take it from there.',
			'No commitment, no lengthy forms. Just get in touch and we’ll take it from there.',
		)
	);
	$hiw_mid_cta_primary_label = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_hiw_id, 'hiw_cta_primary_label', __( 'Enquire', 'restwell-retreats' ) )
		: __( 'Enquire', 'restwell-retreats' );
	$hiw_mid_cta_primary_url   = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_hiw_id, 'hiw_cta_primary_url', restwell_nav_resolve_page_url( 'enquire' ) )
		: restwell_nav_resolve_page_url( 'enquire' );
	$hiw_mid_cta_secondary_label = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_hiw_id, 'hiw_cta_secondary_label', __( 'View the property', 'restwell-retreats' ) )
		: __( 'View the property', 'restwell-retreats' );
	$hiw_mid_cta_secondary_url   = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_hiw_id, 'hiw_cta_secondary_url', restwell_nav_resolve_page_url( 'the-property' ) )
		: restwell_nav_resolve_page_url( 'the-property' );

	get_template_part(
		'template-parts/mid-cta',
		null,
		array(
			'heading'         => $hiw_mid_cta_heading,
			'intro'           => $hiw_mid_cta_intro,
			'primary_label'   => $hiw_mid_cta_primary_label,
			'primary_url'     => $hiw_mid_cta_primary_url,
			'secondary_label' => $hiw_mid_cta_secondary_label,
			'secondary_url'   => $hiw_mid_cta_secondary_url,
		)
	);
	?>

</main>

<?php
get_footer();
