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
		'Optional home care from Continuity of Care Services, our CQC-rated sister company, arranged on the same enquiry.'
	)
	: 'Optional home care from Continuity of Care Services, our CQC-rated sister company, arranged on the same enquiry.';
$restwell_care_eyebrow = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $restwell_care_id, 'care_label', '' )
	: '';

$care_txt = static function ( $key, $fallback ) use ( $restwell_care_id ) {
	return function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_care_id, $key, $fallback )
		: $fallback;
};

$care_sister_label   = $care_txt( 'care_sister_label', 'Sister company' );
$care_sister_heading = $care_txt( 'care_sister_heading', 'One conversation if you need both the bungalow and care' );
$care_sister_lede    = $care_txt( 'care_sister_lede', 'Victoria Walker owns Restwell and is Continuity’s CQC registered manager. That’s why one call can cover the house and the care, without a handover to somebody else.' );
$care_sister_items   = array(
	array(
		'title' => $care_txt( 'care_sister_1_title', 'Optional, not automatic' ),
		'body'  => $care_txt( 'care_sister_1_body', 'We only introduce Continuity if you ask. Care is never forced into the bungalow rate.' ),
	),
	array(
		'title' => $care_txt( 'care_sister_2_title', 'Ask when you enquire' ),
		'body'  => $care_txt( 'care_sister_2_body', 'Dates, access needs and care can sit in one conversation on 01622 809881.' ),
	),
	array(
		'title' => $care_txt( 'care_sister_3_title', 'Bring your own team' ),
		'body'  => $care_txt( 'care_sister_3_body', 'Familiar carers are welcome; the layout works with visiting Continuity staff or your own rota.' ),
	),
);
$care_sister_note        = $care_txt( 'care_sister_note', 'We add nothing until you agree the support package.' );
$care_sister_rates_label = $care_txt( 'care_sister_rates_label', 'See care guide rates' );

$care_support_label   = $care_txt( 'care_support_label', 'Support options' );
$care_support_heading = $care_txt( 'care_support_heading', 'What support looks like' );
$care_support_items   = array(
	array(
		'title' => $care_txt( 'care_support_1_title', 'Personal care' ),
		'body'  => $care_txt( 'care_support_1_body', 'Support with washing, dressing and daily routines on your schedule.' ),
	),
	array(
		'title' => $care_txt( 'care_support_2_title', 'Visiting care' ),
		'body'  => $care_txt( 'care_support_2_body', 'Short daytime visits, or support for a promenade or town trip.' ),
	),
	array(
		'title' => $care_txt( 'care_support_3_title', 'Overnight cover' ),
		'body'  => $care_txt( 'care_support_3_body', 'Sleep-in or waking night support when daytime visits are not enough.' ),
	),
	array(
		'title' => $care_txt( 'care_support_4_title', 'Mobility and hoisting' ),
		'body'  => $care_txt( 'care_support_4_body', 'Transfers with trained carers, using the ceiling track and wet-room kit already in the house.' ),
	),
);
$care_support_icons = array(
	'<svg viewBox="0 0 24 24" focusable="false"><path d="M12 20.5s-7.5-4.6-9.3-9C1.4 8 3 5 6.2 5c2.1 0 4 1.3 5.8 3.8C13.8 6.3 15.7 5 17.8 5 21 5 22.6 8 21.3 11.5c-1.8 4.4-9.3 9-9.3 9z" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	'<svg viewBox="0 0 24 24" focusable="false"><circle cx="12" cy="12" r="8" fill="none" stroke="currentColor" stroke-width="1.6"/><path d="M12 7.5V12l3.2 2" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	'<svg viewBox="0 0 24 24" focusable="false"><path d="M15.8 3.6a8.4 8.4 0 1 0 4.9 15.2A8.4 8.4 0 0 1 15.8 3.6z" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	'<svg viewBox="0 0 24 24" focusable="false"><path d="M12 3v18M8 7l4-4 4 4M8 17l4 4 4-4" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>',
);

$care_own_label   = $care_txt( 'care_own_label', 'Your own team' );
$care_own_heading = $care_txt( 'care_own_heading', 'Bringing your own carer' );
$care_own_items   = array(
	array(
		'title' => $care_txt( 'care_own_1_title', 'No extra fee' ),
		'body'  => $care_txt( 'care_own_1_body', 'Bring your own carer or PA at no extra charge; the bungalow rate is the same either way.' ),
	),
	array(
		'title' => $care_txt( 'care_own_2_title', 'Separate sleeping space' ),
		'body'  => $care_txt( 'care_own_2_body', 'The second double bedroom, or the conservatory’s double sofa bed, keeps your carer’s sleeping space away from yours.' ),
	),
	array(
		'title' => $care_txt( 'care_own_3_title', 'Room to park' ),
		'body'  => $care_txt( 'care_own_3_body', 'The driveway holds two cars, so a carer’s vehicle can park alongside yours.' ),
	),
);

$care_how_label   = $care_txt( 'care_how_label', 'Getting started' );
$care_how_heading = $care_txt( 'care_how_heading', 'How care is arranged' );
$care_how_lede    = $care_txt( 'care_how_lede', 'This is the care conversation specifically; see How It Works for the full booking journey from enquiry to arrival.' );
$care_how_steps   = array(
	array(
		'title' => $care_txt( 'care_how_step1_title', 'Enquire as usual' ),
		'body'  => $care_txt(
			'care_how_step1_body',
			'Share dates, access needs, and any support you think would help. Call 01622 809881 or use the enquire form. No separate care booking maze.'
		),
		'link'  => null,
	),
	array(
		'title' => $care_txt( 'care_how_step2_title', 'Agree tasks and hours' ),
		'body'  => $care_txt(
			'care_how_step2_body',
			'If care is needed, Continuity confirms what is possible and what it costs. Many packages settle on the first call; a short follow-up covers overnight or complex rotas.'
		),
		'link'  => null,
	),
	array(
		'title' => $care_txt( 'care_how_step3_title', 'Guide rates, then your figure' ),
		'body'  => $care_txt(
			'care_how_step3_body',
			'Guide rates live on Pricing & dates. Continuity quotes your care cost once hours and tasks are agreed.'
		),
		'link'  => array(
			'phrase' => 'Pricing & dates',
			'url'    => restwell_nav_resolve_page_url( 'pricing' ) . '#care-rates',
		),
	),
);

$care_cqc_label      = $care_txt( 'care_cqc_label', 'Regulation' );
$care_cqc_heading    = $care_txt( 'care_cqc_heading', 'What CQC-regulated means' );
$care_cqc_body_1     = $care_txt( 'care_cqc_body_1', 'The Care Quality Commission (CQC) inspects and rates health and social care providers in England against standards of safety, effectiveness and leadership. Continuity of Care Services holds a CQC rating of Good; Victoria Walker, who owns Restwell, is Continuity’s registered manager. Read the published report yourself rather than take our word for it.' );
$care_cqc_body_2     = $care_txt( 'care_cqc_body_2', 'Restwell is the accommodation, not the regulated care provider. When care is arranged during your stay, Continuity of Care Services delivers it under that CQC registration: the accountability of a regulated provider, not an informal or unregistered introduction.' );
$care_cqc_link_label = $care_txt( 'care_cqc_link_label', 'Read the CQC inspection profile' );

$care_pro_label   = $care_txt( 'care_pro_label', 'For professionals' );
$care_pro_heading = $care_txt( 'care_pro_heading', 'For OTs, case managers and commissioners' );
$care_pro_lede    = $care_txt( 'care_pro_lede', 'Restwell and Continuity can support a funded short break with care alongside it: here’s what each side provides. See Who It’s For for guest, carer and professional-referrer suitability at a glance.' );
$care_pro_items   = array(
	array(
		'title' => $care_txt( 'care_pro_1_title', 'Access evidence' ),
		'body'  => $care_txt( 'care_pro_1_body', 'Published door widths, hoist and wet-room specs; we’ll measure unpublished clearances on request.' ),
		'link'  => array(
			'label' => 'Accessibility',
			'url'   => restwell_nav_resolve_page_url( 'accessibility' ),
		),
	),
	array(
		'title' => $care_txt( 'care_pro_2_title', 'Care documentation' ),
		'body'  => $care_txt( 'care_pro_2_body', 'Continuity confirms the care plan and cost once hours and tasks are agreed: the detail a funding panel needs to approve a break.' ),
		'link'  => null,
	),
	array(
		'title' => $care_txt( 'care_pro_3_title', 'Funding routes' ),
		'body'  => $care_txt( 'care_pro_3_body', 'Care Act short breaks, direct payments, personal health budgets or NHS CHC: the bungalow rate is the same whoever we invoice.' ),
		'link'  => array(
			'label' => 'Funding & Support',
			'url'   => restwell_nav_resolve_page_url( 'resources' ),
		),
	),
	array(
		'title' => $care_txt( 'care_pro_4_title', 'One number for both' ),
		'body'  => $care_txt( 'care_pro_4_body', 'Restwell and Continuity share 01622 809881, so access needs and a care conversation can happen in one call.' ),
		'link'  => null,
	),
);

$care_faq_label   = $care_txt( 'care_faq_label', 'Care questions' );
$care_faq_heading = $care_txt( 'care_faq_heading', 'Optional care FAQ' );
$care_faq_intro   = $care_txt( 'care_faq_intro', 'Whether care is required, who Continuity is, and where guide rates live.' );
$care_faq_live    = array(
	1 => array(
		'q' => 'Do I have to book care?',
		'a' => 'No. Many guests book the house as a self-catering holiday and need no additional support. Continuity care is optional.',
	),
	2 => array(
		'q' => 'Is Restwell a care home?',
		'a' => 'No. Restwell is a private holiday bungalow. Continuity of Care Services (our sister company) is the CQC-regulated provider if you want professional care during your stay.',
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
get_template_part(
	'template-parts/concept/photo-hero',
	null,
	array(
		'heading_id' => 'page-h',
		'heading'    => $restwell_care_heading,
		'eyebrow'    => $restwell_care_eyebrow,
		'intro'      => $restwell_care_intro,
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
		'overlay'    => 'heavy',
		'post_id'    => (int) get_queried_object_id(),
	)
);
?>

	<nav class="subnav" aria-label="On this page" data-toc>
	  <div class="container">
		<ul class="subnav__list">
		  <li><a href="#sister-company">About</a></li>
		  <li><a href="#what-we-arrange">Support</a></li>
		  <li><a href="#bring-your-own-carer">Own carer</a></li>
		  <li><a href="#how-care-works">Steps</a></li>
		  <li><a href="#cqc-regulated">CQC</a></li>
		  <li><a href="#for-professionals">Professionals</a></li>
		  <li><a href="#faq">FAQ</a></li>
		</ul>
	  </div>
	</nav>

	<section class="section-y band-white" id="sister-company" aria-labelledby="sister-company-h">
	  <div class="container">
		<header class="section-head section-head--tight">
		  <?php if ( '' !== $care_sister_label ) : ?>
		  <p class="eyebrow"><?php echo esc_html( $care_sister_label ); ?></p>
		  <?php endif; ?>
		  <h2 id="sister-company-h"><?php echo esc_html( $care_sister_heading ); ?></h2>
		  <?php if ( '' !== $care_sister_lede ) : ?>
		  <p class="lede"><?php echo esc_html( $care_sister_lede ); ?></p>
		  <?php endif; ?>
		</header>
		<dl class="comparison-list">
		  <?php foreach ( $care_sister_items as $item ) : ?>
		  <div class="comparison-list__item">
			<?php if ( '' !== $item['title'] ) : ?>
			<dt><?php echo esc_html( $item['title'] ); ?></dt>
			<?php endif; ?>
			<?php if ( '' !== $item['body'] ) : ?>
			<dd><?php echo esc_html( $item['body'] ); ?></dd>
			<?php endif; ?>
		  </div>
		  <?php endforeach; ?>
		</dl>
		<div class="care-page__trust">
		  <div class="care__foot-copy">
			<?php if ( '' !== $care_sister_note ) : ?>
			<p class="care__note"><?php echo esc_html( $care_sister_note ); ?></p>
			<?php endif; ?>
			<?php if ( '' !== $care_sister_rates_label ) : ?>
			<a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'pricing' ) . '#care-rates' ); ?>"><?php echo esc_html( $care_sister_rates_label ); ?></a>
			<?php endif; ?>
		  </div>
		  <div class="care__brand" aria-label="Sister company and CQC rating">
			<a class="care__brand-link care__brand-link--ccs" href="https://www.continuitycareservices.co.uk/" target="_blank" rel="noopener noreferrer" aria-label="Continuity of Care Services (opens in a new tab)">
			  <img src="<?php echo esc_url( restwell_theme_image_url( 'partners/continuity-of-care-services-long.png' ) ); ?>" alt="<?php echo esc_attr( restwell_theme_image_alt( 'partners/continuity-of-care-services-long.png' ) ); ?>" width="405" height="69" loading="lazy" decoding="async" />
			</a>
			<a class="care__brand-link care__brand-link--cqc" href="https://www.cqc.org.uk/location/1-2624556588" target="_blank" rel="noopener noreferrer" aria-label="CQC rating Good, Continuity of Care Services (opens in a new tab)">
			  <img src="<?php echo esc_url( restwell_theme_image_url( 'partners/cqc-rating-good.jpg' ) ); ?>" alt="<?php echo esc_attr( restwell_theme_image_alt( 'partners/cqc-rating-good.jpg' ) ); ?>" width="710" height="399" loading="lazy" decoding="async" />
			</a>
		  </div>
		</div>
	  </div>
	</section>

	<section class="section-y band-subtle" id="what-we-arrange" aria-labelledby="what-we-arrange-h">
	  <div class="container">
		<header class="section-head section-head--tight">
		  <?php if ( '' !== $care_support_label ) : ?>
		  <p class="eyebrow"><?php echo esc_html( $care_support_label ); ?></p>
		  <?php endif; ?>
		  <h2 id="what-we-arrange-h"><?php echo esc_html( $care_support_heading ); ?></h2>
		</header>
		<ul class="persona-list" role="list">
		  <?php foreach ( $care_support_items as $support_i => $support_item ) : ?>
		  <li class="persona-list__item">
			<span class="icon-circle" aria-hidden="true"><?php echo $care_support_icons[ $support_i ]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG markup. ?></span>
			<div>
			  <?php if ( '' !== $support_item['title'] ) : ?>
			  <h3><?php echo esc_html( $support_item['title'] ); ?></h3>
			  <?php endif; ?>
			  <?php if ( '' !== $support_item['body'] ) : ?>
			  <p><?php echo esc_html( $support_item['body'] ); ?></p>
			  <?php endif; ?>
			</div>
		  </li>
		  <?php endforeach; ?>
		</ul>
	  </div>
	</section>

	<section class="section-y band-white" id="bring-your-own-carer" aria-labelledby="bring-your-own-carer-h">
	  <div class="container">
		<header class="section-head section-head--tight">
		  <?php if ( '' !== $care_own_label ) : ?>
		  <p class="eyebrow"><?php echo esc_html( $care_own_label ); ?></p>
		  <?php endif; ?>
		  <h2 id="bring-your-own-carer-h"><?php echo esc_html( $care_own_heading ); ?></h2>
		</header>
		<dl class="comparison-list">
		  <?php foreach ( $care_own_items as $item ) : ?>
		  <div class="comparison-list__item">
			<?php if ( '' !== $item['title'] ) : ?>
			<dt><?php echo esc_html( $item['title'] ); ?></dt>
			<?php endif; ?>
			<?php if ( '' !== $item['body'] ) : ?>
			<dd><?php echo esc_html( $item['body'] ); ?></dd>
			<?php endif; ?>
		  </div>
		  <?php endforeach; ?>
		</dl>
	  </div>
	</section>

	<section class="section-y band-subtle" id="how-care-works" aria-labelledby="how-care-works-h">
	  <div class="container">
		<header class="section-head section-head--tight">
		  <?php if ( '' !== $care_how_label ) : ?>
		  <p class="eyebrow"><?php echo esc_html( $care_how_label ); ?></p>
		  <?php endif; ?>
		  <h2 id="how-care-works-h"><?php echo esc_html( $care_how_heading ); ?></h2>
		  <?php if ( '' !== $care_how_lede ) : ?>
		  <p class="lede"><?php echo wp_kses_post( $care_link_phrase( esc_html( $care_how_lede ), 'How It Works', restwell_nav_resolve_page_url( 'how-it-works' ) ) ); ?></p>
		  <?php endif; ?>
		</header>
		<ol class="payment-steps">
		  <?php foreach ( $care_how_steps as $care_how_index => $care_how_step ) : ?>
		  <li class="payment-steps__item">
			<span class="payment-steps__index" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $care_how_index + 1 ) ); ?></span>
			<div class="payment-steps__body">
			  <h3><?php echo esc_html( $care_how_step['title'] ); ?></h3>
			  <p><?php
				$care_how_body_html = esc_html( $care_how_step['body'] );
				if ( ! empty( $care_how_step['link']['phrase'] ) && ! empty( $care_how_step['link']['url'] ) ) {
					$care_how_body_html = $care_link_phrase(
						$care_how_body_html,
						(string) $care_how_step['link']['phrase'],
						(string) $care_how_step['link']['url']
					);
				}
				echo wp_kses_post( $care_how_body_html );
				?></p>
			</div>
		  </li>
		  <?php endforeach; ?>
		</ol>
	  </div>
	</section>

	<section class="section-y band-white" id="cqc-regulated" aria-labelledby="cqc-regulated-h">
	  <div class="container">
		<header class="section-head section-head--tight">
		  <?php if ( '' !== $care_cqc_label ) : ?>
		  <p class="eyebrow"><?php echo esc_html( $care_cqc_label ); ?></p>
		  <?php endif; ?>
		  <h2 id="cqc-regulated-h"><?php echo esc_html( $care_cqc_heading ); ?></h2>
		</header>
		<div class="prose">
		  <?php if ( '' !== $care_cqc_body_1 ) : ?>
		  <p><?php echo esc_html( $care_cqc_body_1 ); ?></p>
		  <?php endif; ?>
		  <?php if ( '' !== $care_cqc_body_2 ) : ?>
		  <p><?php echo esc_html( $care_cqc_body_2 ); ?></p>
		  <?php endif; ?>
		  <?php if ( '' !== $care_cqc_link_label ) : ?>
		  <p><a href="https://www.cqc.org.uk/location/1-2624556588" class="text-link" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $care_cqc_link_label ); ?><span class="sr-only"> (opens in new tab)</span></a></p>
		  <?php endif; ?>
		</div>
	  </div>
	</section>

	<section class="section-y band-white" aria-labelledby="pro-quote-h">
	  <div class="container">
		<h2 id="pro-quote-h" class="sr-only">What a support team wrote after staying</h2>
		<figure class="pull-quote">
		  <span class="pull-quote__mark" aria-hidden="true">&ldquo;</span>
		  <blockquote class="pull-quote__text">Our support team recently stayed at Restwell Retreats while supporting our client on a UK holiday, and they were extremely impressed with the accommodation. Everything is clean, well-maintained, and fully accessible for clients who require disabled access, including wide doors, no thresholds, and a portable ramp for accessing the community. The toilet system is outstanding and makes a significant difference to the client’s comfort and dignity.</blockquote>
		  <figcaption class="pull-quote__cite">G.G.<span class="pull-quote__role">Support team lead &middot; Google review</span></figcaption>
		</figure>
	  </div>
	</section>

	<section class="section-y band-subtle" id="for-professionals" aria-labelledby="for-professionals-h">
	  <div class="container">
		<header class="section-head section-head--tight">
		  <?php if ( '' !== $care_pro_label ) : ?>
		  <p class="eyebrow"><?php echo esc_html( $care_pro_label ); ?></p>
		  <?php endif; ?>
		  <h2 id="for-professionals-h"><?php echo esc_html( $care_pro_heading ); ?></h2>
		  <?php if ( '' !== $care_pro_lede ) : ?>
		  <p class="lede"><?php echo wp_kses_post( $care_link_phrase( esc_html( $care_pro_lede ), 'Who It’s For', restwell_nav_resolve_page_url( 'who-its-for' ) ) ); ?></p>
		  <?php endif; ?>
		</header>
		<dl class="comparison-list comparison-list--2">
		  <?php foreach ( $care_pro_items as $item ) : ?>
		  <div class="comparison-list__item">
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

	<section class="faq section-y band-white" id="faq" aria-labelledby="faq-h">
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
		? restwell_page_content_text( $restwell_care_id, 'care_cta_heading', __( 'Ask about care with your enquiry', 'restwell-retreats' ) )
		: __( 'Ask about care with your enquiry', 'restwell-retreats' );
	$care_mid_cta_intro   = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_care_id, 'care_cta_body', __( 'Share your dates and what support would help.', 'restwell-retreats' ) )
		: __( 'Share your dates and what support would help.', 'restwell-retreats' );
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
