<?php
/**
 * Template Name: Optional Care
 *
 * Concept port from mockups — Optional care.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$restwell_care_id      = (int) get_queried_object_id();
$restwell_care_heading = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $restwell_care_id, 'care_heading', 'Care during your stay, arranged in the same conversation' )
	: 'Care during your stay, arranged in the same conversation';
$restwell_care_intro   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text(
		$restwell_care_id,
		'care_intro',
		'Our sister company, Continuity of Care Services, can come into the bungalow while you stay. Ask on the same enquiry as the house.'
	)
	: 'Our sister company, Continuity of Care Services, can come into the bungalow while you stay. Ask on the same enquiry as the house.';
$restwell_care_eyebrow = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $restwell_care_id, 'care_label', '' )
	: '';

$care_txt = static function ( $key, $fallback ) use ( $restwell_care_id ) {
	return function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_care_id, $key, $fallback )
		: $fallback;
};

$care_standfirst     = $care_txt( 'care_standfirst', 'Most people arrive here with the same worry: that a holiday means either leaving the care behind, or doing all of it yourself.' );
$care_sister_heading = $care_txt( 'care_sister_heading', 'We’re the house. Continuity are the care.' );
$care_sister_lede    = $care_txt( 'care_sister_lede', 'You don’t have to use them. Plenty of guests bring their own carer or PA, or manage the way they do at home. But if someone coming in would turn a hard week into a good one, that’s what Continuity are here for.' );
$care_sister_note        = $care_txt( 'care_sister_note', 'Nothing is added to your stay until you’ve agreed it.' );
$care_sister_rates_label = $care_txt( 'care_sister_rates_label', 'See care guide rates' );

$care_support_heading = $care_txt( 'care_support_heading', 'You choose how much, and it isn’t a package' );
$care_support_lede    = $care_txt( 'care_support_lede', 'Tell us what a good day would look like and we’ll work backwards from there. There’s no minimum package to squeeze yourself into.' );
$care_support_items   = array(
	array(
		'title' => $care_txt( 'care_support_1_title', 'Personal care' ),
		'body'  => $care_txt( 'care_support_1_body', 'Help getting up, washed and dressed, at the times you keep at home.' ),
	),
	array(
		'title' => $care_txt( 'care_support_2_title', 'A few hours off' ),
		'body'  => $care_txt( 'care_support_2_body', 'Time here and there, so whoever normally does the caring can walk down to Tankerton and look at the water without watching the clock.' ),
	),
	array(
		'title' => $care_txt( 'care_support_3_title', 'Overnight' ),
		'body'  => $care_txt( 'care_support_3_body', 'A sleep-in or a waking night, when daytime visits aren’t enough.' ),
	),
	array(
		'title' => $care_txt( 'care_support_4_title', 'Hoisting and transfers' ),
		'body'  => $care_txt( 'care_support_4_body', 'The hoist is over the bed and the chair is in the wet room, so Continuity aren’t improvising around a standard holiday let.' ),
	),
);
$care_own_heading = $care_txt( 'care_own_heading', 'Bringing your own carer' );
$care_own_lede    = $care_txt( 'care_own_lede', 'You’re very welcome to. Just tell us who’s coming.' );
$care_own_items   = array(
	array(
		'title' => $care_txt( 'care_own_1_title', 'Use of the kit' ),
		'body'  => $care_txt( 'care_own_1_body', 'The ceiling hoist, profiling beds and shower chair are here for your carer to use as well.' ),
	),
	array(
		'title' => $care_txt( 'care_own_2_title', 'A room of their own' ),
		'body'  => $care_txt( 'care_own_2_body', 'Your carer can have the second double bedroom, or the double sofa bed in the conservatory. We can think it through with you if that’s easier.' ),
	),
	array(
		'title' => $care_txt( 'care_own_3_title', 'Room to park' ),
		'body'  => $care_txt( 'care_own_3_body', 'The driveway holds two cars, so a carer’s car can park alongside yours.' ),
	),
);

$care_how_heading = $care_txt( 'care_how_heading', 'Sooner if you ask sooner, and we won’t pretend otherwise' );
$care_how_lede    = $care_txt( 'care_how_lede', 'We don’t publish a lead time, because we’d only be making it up: it depends on what you need and who’s working that week. What we will do is give you a straight answer quickly.' );
$care_how_steps   = array(
	array(
		'title' => $care_txt( 'care_how_step1_title', 'Mention it when you enquire' ),
		'body'  => $care_txt(
			'care_how_step1_body',
			'Say what you’re thinking when you first write or ring 01622 809881, even if your dates are vague. There’s no separate form for care.'
		),
		'link'  => null,
	),
	array(
		'title' => $care_txt( 'care_how_step2_title', 'Talk it through with Continuity' ),
		'body'  => $care_txt(
			'care_how_step2_body',
			'They’ll ask about hours and tasks and tell you plainly what’s possible. Many people settle it on the first call; overnight or complex rotas can take a short follow-up.'
		),
		'link'  => null,
	),
	array(
		'title' => $care_txt( 'care_how_step3_title', 'They quote, you decide' ),
		'body'  => $care_txt(
			'care_how_step3_body',
			'Continuity quote your care once hours and tasks are agreed. Their guide rates are on Pricing & dates.'
		),
		'link'  => array(
			'phrase' => 'Pricing & dates',
			'url'    => restwell_nav_resolve_page_url( 'pricing' ) . '#care-rates',
		),
	),
);

$care_cqc_link_label = $care_txt( 'care_cqc_link_label', 'Read the CQC inspection profile' );

$care_pro_heading = $care_txt( 'care_pro_heading', 'For OTs, case managers and commissioners' );
$care_pro_lede    = $care_txt( 'care_pro_lede', 'What each of us can give you when you’re planning a funded break with care. Who It’s For has suitability at a glance.' );
$care_pro_items   = array(
	array(
		'title' => $care_txt( 'care_pro_1_title', 'Access evidence' ),
		'body'  => $care_txt( 'care_pro_1_body', 'Door widths, hoist and wet-room specs are published, and we’ll measure anything that isn’t.' ),
		'link'  => array(
			'label' => 'Accessibility',
			'url'   => restwell_nav_resolve_page_url( 'accessibility' ),
		),
	),
	array(
		'title' => $care_txt( 'care_pro_2_title', 'The care plan and cost' ),
		'body'  => $care_txt( 'care_pro_2_body', 'Continuity confirm the care plan and the cost once hours and tasks are agreed.' ),
		'link'  => null,
	),
	array(
		'title' => $care_txt( 'care_pro_3_title', 'Funding routes' ),
		'body'  => $care_txt( 'care_pro_3_body', 'Care Act short breaks, direct payments, personal health budgets or NHS CHC.' ),
		'link'  => array(
			'label' => 'Funding & Support',
			'url'   => restwell_nav_resolve_page_url( 'resources' ),
		),
	),
	array(
		'title' => $care_txt( 'care_pro_4_title', 'One number for both' ),
		'body'  => $care_txt( 'care_pro_4_body', 'Restwell and Continuity share 01622 809881, so access and care can be one call.' ),
		'link'  => null,
	),
);

$care_faq_label   = $care_txt( 'care_faq_label', 'Care questions' );
$care_faq_heading = $care_txt( 'care_faq_heading', 'Optional care FAQ' );
$care_faq_intro   = $care_txt( 'care_faq_intro', 'The questions people ask most before they mention care.' );
$care_faq_live    = array(
	1 => array(
		'q' => 'Do I have to book care?',
		'a' => 'No. Many guests book the house as a self-catering holiday and need no additional support. Continuity care is optional.',
	),
	2 => array(
		'q' => 'Who regulates the care team?',
		'a' => 'The Care Quality Commission. Continuity of Care Services is rated Good, and Victoria Walker, who owns Restwell, is their registered manager. Read the published report yourself rather than take our word for it.',
	),
	3 => array(
		'q' => 'Do I book care separately?',
		'a' => 'No. Ask when you enquire about the bungalow. Restwell and Continuity share 01622 809881, so house and care can start in one conversation when you want both.',
	),
	4 => array(
		'q' => 'Can I bring my own carers?',
		'a' => 'Yes. The layout supports familiar routines, with separate sleeping and space to assist. Tell us your party layout when you enquire.',
	),
	5 => array(
		'q' => 'Where do I see guide rates?',
		'a' => 'On Pricing & dates. They are Continuity guide rates only. Continuity quotes your care cost once hours and tasks are agreed.',
	),
);
$care_faq_items = array();
for ( $i = 1; $i <= 5; $i++ ) {
	$q = $care_txt( "care_faq_{$i}_q", $care_faq_live[ $i ]['q'] );
	$a = $care_txt( "care_faq_{$i}_a", $care_faq_live[ $i ]['a'] );
	if ( '' === trim( $q ) || '' === trim( $a ) ) {
		continue;
	}
	$care_faq_items[] = array(
		'q' => $q,
		'a' => $a,
	);
}
if ( empty( $care_faq_items ) ) {
	$care_faq_items = array_values( $care_faq_live );
}

/**
 * Link a known phrase inside already-escaped HTML.
 *
 * @param string $escaped Escaped plain text.
 * @param string $phrase  Phrase to wrap.
 * @param string $url     Absolute or site URL.
 * @return string
 */
$care_link_phrase = static function ( $escaped, $phrase, $url ) {
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
// Trial (14 Oct 2026, owner: "shake off the current copywriting and design,
// and trial a fresh approach"). The page is built around a day: what help
// could look like in the morning, in the day and overnight, then who comes
// in, bringing your own carer, and how to ask. Copy is set here while it is
// on trial; it moves into the page fields once the owner keeps it.
get_template_part(
	'template-parts/concept/photo-hero',
	null,
	array(
		'heading_id' => 'page-h',
		'heading'    => __( 'Care that comes to your holiday', 'restwell-retreats' ),
		'eyebrow'    => $restwell_care_eyebrow,
		'intro'      => __( 'Our sister company, Continuity of Care Services, can come into the bungalow while you’re here. As much or as little as you’d like, and only if you ask.', 'restwell-retreats' ),
		'crumbs'     => array(
			array(
				'label' => __( 'Home', 'restwell-retreats' ),
				'url'   => home_url( '/' ),
			),
			array(
				'label' => 'Care during your stay',
				'url'   => '',
			),
		),
		'image_url'  => restwell_theme_image_url( 'stock/restwell-whitstable-coastal-pathway.webp' ),
		'image_alt'  => __( 'Flat, paved coastal pathway along Tankerton promenade', 'restwell-retreats' ),
		'overlay'    => 'heavy',
		'post_id'    => (int) get_queried_object_id(),
	)
);
$care_day = array(
	array(
		'id'    => 'morning',
		'time'  => __( 'Morning', 'restwell-retreats' ),
		'text'  => __( 'Someone to help you up, washed and dressed, at the time you’d get up at home. The hoist is over the bed and the shower chair is already in the wet room, so nobody’s improvising.', 'restwell-retreats' ),
		'img'   => 'bungalow/WR-1-LS.jpg',
		'alt'   => __( 'The level-access wet room: height-adjustable washbasin, grab rails and a tilt-in-space shower commode chair', 'restwell-retreats' ),
		'w'     => 2400,
		'h'     => 1500,
		'quote' => false,
	),
	array(
		'id'    => 'daytime',
		'time'  => __( 'In the day', 'restwell-retreats' ),
		'text'  => __( 'Company for a trip along the promenade or into town. Or a few hours to yourselves, so whoever usually does the caring can walk down to Tankerton and look at the water without watching the clock.', 'restwell-retreats' ),
		'img'   => 'journey/guest-harbour-beach.jpg',
		'alt'   => __( 'A guest in a powered wheelchair and a companion on the firm Harbour Beach by the lifeboat station', 'restwell-retreats' ),
		'w'     => 1620,
		'h'     => 1012,
		'quote' => false,
	),
	array(
		'id'    => 'overnight',
		'time'  => __( 'Overnight', 'restwell-retreats' ),
		'text'  => __( 'A sleep-in, or a waking night if someone needs to be up. Either way, the person who usually lies awake listening gets to sleep.', 'restwell-retreats' ),
		'img'   => 'bungalow/RAR-1-LS.jpg',
		'alt'   => __( 'The rise-and-recline armchair in the living room, footrest raised', 'restwell-retreats' ),
		'w'     => 2400,
		'h'     => 1500,
		'quote' => true,
	),
);
?>

	<nav class="subnav" aria-label="On this page" data-toc>
	  <div class="container">
		<ul class="subnav__list">
		  <li><a href="#a-day"><?php esc_html_e( 'A day', 'restwell-retreats' ); ?></a></li>
		  <li><a href="#who-comes-in"><?php esc_html_e( 'Who comes in', 'restwell-retreats' ); ?></a></li>
		  <li><a href="#bring-your-own-carer"><?php esc_html_e( 'Your own carer', 'restwell-retreats' ); ?></a></li>
		  <li><a href="#asking"><?php esc_html_e( 'Asking for care', 'restwell-retreats' ); ?></a></li>
		  <li><a href="#for-professionals"><?php esc_html_e( 'Professionals', 'restwell-retreats' ); ?></a></li>
		  <li><a href="#faq"><?php esc_html_e( 'FAQ', 'restwell-retreats' ); ?></a></li>
		</ul>
	  </div>
	</nav>

	<section class="section-y band-white care-day" id="a-day" aria-labelledby="a-day-h">
	  <div class="container">
		<header class="section-head section-head--tight">
		  <h2 id="a-day-h"><?php esc_html_e( 'What a day could look like', 'restwell-retreats' ); ?></h2>
		  <p class="lede"><?php esc_html_e( 'Tell us what a good day looks like at home and we’ll work backwards from there. There’s no package to squeeze into.', 'restwell-retreats' ); ?></p>
		</header>
	  </div>
	  <?php foreach ( $care_day as $care_day_i => $care_moment ) : ?>
	  <div class="container split split--media-first split--fill<?php echo 1 === $care_day_i % 2 ? ' split--flip' : ''; ?> care-day__moment" id="<?php echo esc_attr( $care_moment['id'] ); ?>">
		<div class="split__media">
		  <img src="<?php echo esc_url( restwell_theme_image_url( $care_moment['img'] ) ); ?>" alt="<?php echo esc_attr( $care_moment['alt'] ); ?>" width="<?php echo (int) $care_moment['w']; ?>" height="<?php echo (int) $care_moment['h']; ?>" loading="lazy" decoding="async" />
		</div>
		<div class="care-day__copy">
		  <h3><?php echo esc_html( $care_moment['time'] ); ?></h3>
		  <p><?php echo esc_html( $care_moment['text'] ); ?></p>
			<?php if ( $care_moment['quote'] ) : ?>
		  <figure class="care-own__quote">
				<?php /* Consecutive words from G.G.'s Google review (docs/guest-reviews-bank.md). */ ?>
			<blockquote><p>The adjustable armchair is ideal for a waking night carer, offering great comfort throughout their shift.</p></blockquote>
			<figcaption><cite>G.G.</cite> <?php esc_html_e( 'Support team lead · Google review', 'restwell-retreats' ); ?></figcaption>
		  </figure>
			<?php endif; ?>
		</div>
	  </div>
	  <?php endforeach; ?>
	</section>

	<section class="section-y band-subtle care-who" id="who-comes-in" aria-labelledby="who-comes-in-h">
	  <div class="container split split--media-first split--fill">
		<div class="split__media">
		  <img src="<?php echo esc_url( restwell_theme_image_url( 'journey/victoria-walker-full.webp' ) ); ?>" alt="Victoria Walker cutting the ribbon at the bungalow’s front door" width="1620" height="1859" loading="lazy" decoding="async" />
		</div>
		<div>
		  <header class="section-head section-head--tight">
			<h2 id="who-comes-in-h"><?php esc_html_e( 'Who comes in', 'restwell-retreats' ); ?></h2>
			<p class="lede"><?php esc_html_e( 'Carers from Continuity of Care Services, our sister company. Victoria Walker owns Restwell and is Continuity’s registered manager, so the house and the care start in one conversation.', 'restwell-retreats' ); ?></p>
		  </header>
		  <div class="care-cqc" id="cqc-regulated">
			<dl class="care-cqc__facts">
			  <div><dt><?php esc_html_e( 'CQC rating', 'restwell-retreats' ); ?></dt><dd class="care-cqc__rating"><?php esc_html_e( 'Good', 'restwell-retreats' ); ?></dd></div>
			  <div><dt><?php esc_html_e( 'Registered manager', 'restwell-retreats' ); ?></dt><dd><?php esc_html_e( 'Victoria Walker', 'restwell-retreats' ); ?></dd></div>
			  <div><dt><?php esc_html_e( 'Care provider', 'restwell-retreats' ); ?></dt><dd><?php esc_html_e( 'Continuity of Care Services', 'restwell-retreats' ); ?></dd></div>
			  <div><dt><?php esc_html_e( 'CQC location', 'restwell-retreats' ); ?></dt><dd>1-2624556588</dd></div>
			</dl>
			<p class="care-cqc__note">
			  <?php esc_html_e( 'Restwell is the house, not a care provider, and doesn’t pretend to be one. The rating is Continuity’s, and you can read the report yourself.', 'restwell-retreats' ); ?>
			  <a class="text-link" href="https://www.cqc.org.uk/location/1-2624556588" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Read the CQC report', 'restwell-retreats' ); ?><span class="sr-only"> <?php esc_html_e( '(opens in new tab)', 'restwell-retreats' ); ?></span></a>
			</p>
			<div class="care-intro__badges">
			  <a href="https://www.continuitycareservices.co.uk/" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Continuity of Care Services (opens in a new tab)', 'restwell-retreats' ); ?>">
				<img src="<?php echo esc_url( restwell_theme_image_url( 'partners/continuity-of-care-services-long.png' ) ); ?>" alt="" sizes="200px" width="405" height="69" loading="lazy" decoding="async" />
			  </a>
			  <a href="https://www.cqc.org.uk/location/1-2624556588" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'CQC rating Good, Continuity of Care Services (opens in a new tab)', 'restwell-retreats' ); ?>">
				<img src="<?php echo esc_url( restwell_theme_image_url( 'partners/cqc-rating-good.jpg' ) ); ?>" alt="" sizes="96px" width="710" height="399" loading="lazy" decoding="async" />
			  </a>
			</div>
		  </div>
		</div>
	  </div>
	</section>

	<section class="section-y band-white" id="bring-your-own-carer" aria-labelledby="bring-your-own-carer-h">
	  <div class="container">
		<header class="section-head section-head--tight">
		  <h2 id="bring-your-own-carer-h"><?php esc_html_e( 'Bringing your own carer instead', 'restwell-retreats' ); ?></h2>
		  <p class="lede"><?php esc_html_e( 'Plenty of guests do. Just tell us who’s coming.', 'restwell-retreats' ); ?></p>
		</header>
		<dl class="care-index care-index--wide">
		  <div><dt><?php esc_html_e( 'Their own room', 'restwell-retreats' ); ?></dt><dd><?php esc_html_e( 'The second double bedroom, or the double sofa bed in the conservatory.', 'restwell-retreats' ); ?></dd></div>
		  <div><dt><?php esc_html_e( 'The same kit', 'restwell-retreats' ); ?></dt><dd><?php esc_html_e( 'The ceiling hoist, profiling beds and shower chair are there for them to use.', 'restwell-retreats' ); ?></dd></div>
		  <div><dt><?php esc_html_e( 'Parking', 'restwell-retreats' ); ?></dt><dd><?php esc_html_e( 'The driveway takes two cars, so theirs can go alongside yours.', 'restwell-retreats' ); ?></dd></div>
		</dl>
	  </div>
	</section>

	<section class="section-y band-subtle care-how" id="asking" aria-labelledby="asking-h">
	  <div class="container">
		<header class="section-head section-head--tight">
		  <h2 id="asking-h"><?php esc_html_e( 'Asking for care', 'restwell-retreats' ); ?></h2>
		  <p class="lede"><?php esc_html_e( 'We don’t publish a lead time, because we’d only be making it up. Ask early, even if your dates are vague, and we’ll give you a straight answer quickly.', 'restwell-retreats' ); ?></p>
		</header>
		<ol class="care-route">
		  <li class="care-route__stop">
			<h3><?php esc_html_e( 'Mention it when you enquire', 'restwell-retreats' ); ?></h3>
			<p><?php esc_html_e( 'Say what would help when you write or ring 01622 809881. There’s no separate form.', 'restwell-retreats' ); ?></p>
		  </li>
		  <li class="care-route__stop">
			<h3><?php esc_html_e( 'Talk it through', 'restwell-retreats' ); ?></h3>
			<p><?php esc_html_e( 'Continuity ask about hours and tasks, and tell you plainly what’s possible.', 'restwell-retreats' ); ?></p>
		  </li>
		  <li class="care-route__stop">
			<h3><?php esc_html_e( 'They quote, you decide', 'restwell-retreats' ); ?></h3>
			<p><?php esc_html_e( 'Continuity quote for the care once you’ve agreed what’s needed. Their guide rates are on', 'restwell-retreats' ); ?> <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'pricing' ) . '#care-rates' ); ?>"><?php esc_html_e( 'Pricing & dates', 'restwell-retreats' ); ?></a>.</p>
		  </li>
		</ol>
		<p class="care-how__note"><?php esc_html_e( 'Nothing is booked until you’ve said yes.', 'restwell-retreats' ); ?></p>
	  </div>
	</section>

	<section class="section-y band-white" id="for-professionals" aria-labelledby="for-professionals-h">
	  <div class="container">
		<header class="section-head section-head--tight">
		  <h2 id="for-professionals-h"><?php echo esc_html( $care_pro_heading ); ?></h2>
		  <?php if ( '' !== $care_pro_lede ) : ?>
		  <p class="lede"><?php echo wp_kses_post( $care_link_phrase( esc_html( $care_pro_lede ), 'Who It’s For', restwell_nav_resolve_page_url( 'who-its-for' ) ) ); ?></p>
		  <?php endif; ?>
		</header>
		<dl class="care-index care-index--wide">
		  <?php foreach ( $care_pro_items as $item ) : ?>
		  <div>
				<?php if ( '' !== $item['title'] ) : ?>
			<dt><?php echo esc_html( $item['title'] ); ?></dt>
			<?php endif; ?>
				<?php if ( '' !== $item['body'] ) : ?>
			<dd>
					<?php echo esc_html( $item['body'] ); ?>
					<?php if ( ! empty( $item['link'] ) ) : ?>
						<?php echo ' '; ?>See <a class="text-link" href="<?php echo esc_url( $item['link']['url'] ); ?>"><?php echo esc_html( $item['link']['label'] ); ?></a>.
			  <?php endif; ?>
			</dd>
			<?php endif; ?>
		  </div>
		  <?php endforeach; ?>
		</dl>
	  </div>
	</section>

	<section class="faq section-y band-subtle" id="faq" aria-labelledby="faq-h">
	  <div class="container">
		<div class="faq__layout">
		  <header class="faq__intro">
			<?php if ( '' !== $care_faq_label ) : ?>
			<p class="eyebrow"><?php echo esc_html( $care_faq_label ); ?></p>
			<?php endif; ?>
			<h2 id="faq-h"><?php echo esc_html( $care_faq_heading ); ?></h2>
			<?php if ( '' !== $care_faq_intro ) : ?>
			<p class="lede"><?php echo esc_html( $care_faq_intro ); ?></p>
			<?php endif; ?>
		  </header>
		  <?php
			$care_faq_accordion = array();
			foreach ( $care_faq_items as $faq_i => $faq_row ) {
				$answer = esc_html( $faq_row['a'] );
				$answer = $care_link_phrase( $answer, 'Pricing & dates', restwell_nav_resolve_page_url( 'pricing' ) . '#care-rates' );
				$care_faq_accordion[] = array(
					'q'    => $faq_row['q'],
					'a'    => '<p>' . $answer . '</p>',
					'open' => 0 === $faq_i,
				);
			}
			get_template_part(
				'template-parts/faq-accordion',
				null,
				array(
					'id_prefix'    => 'care-q',
					'list_class'   => 'faq-list--split',
					'wrap_columns' => true,
					'columns'      => array( array_slice( $care_faq_accordion, 0, 3 ), array_slice( $care_faq_accordion, 3 ) ),
				)
			);
			?>
		</div>
	  </div>
	</section>

	<?php
	$care_mid_cta_heading = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_care_id, 'care_cta_heading', __( 'Tell us what you need, and we’ll work it out with you', 'restwell-retreats' ) )
		: __( 'Tell us what you need, and we’ll work it out with you', 'restwell-retreats' );
	$care_mid_cta_intro   = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_care_id, 'care_cta_body', __( 'Ring 01622 809881 or send a note. There’s no such thing as a silly question.', 'restwell-retreats' ) )
		: __( 'Ring 01622 809881 or send a note. There’s no such thing as a silly question.', 'restwell-retreats' );
	$care_mid_cta_primary_label = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_care_id, 'care_cta_primary_label', __( 'Enquire', 'restwell-retreats' ) )
		: __( 'Enquire', 'restwell-retreats' );
	$care_mid_cta_primary_url   = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_care_id, 'care_cta_primary_url', restwell_nav_resolve_page_url( 'enquire' ) )
		: restwell_nav_resolve_page_url( 'enquire' );
	$care_mid_cta_secondary_label = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_care_id, 'care_cta_secondary_label', __( 'See guide rates', 'restwell-retreats' ) )
		: __( 'See guide rates', 'restwell-retreats' );
	$care_mid_cta_secondary_url   = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_care_id, 'care_cta_secondary_url', restwell_nav_resolve_page_url( 'pricing' ) . '#care-rates' )
		: restwell_nav_resolve_page_url( 'pricing' ) . '#care-rates';

	get_template_part(
		'template-parts/mid-cta',
		null,
		array(
			'heading'         => $care_mid_cta_heading,
			'intro'           => $care_mid_cta_intro,
			'primary_label'   => $care_mid_cta_primary_label,
			'primary_url'     => $care_mid_cta_primary_url,
			'secondary_label' => $care_mid_cta_secondary_label,
			'secondary_url'   => $care_mid_cta_secondary_url,
		)
	);
	?>

</main>

<?php
get_footer();
