<?php
/**
 * Template Name: Our Story
 *
 * Concept port from mockups — Our Story.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$restwell_story_id      = (int) get_queried_object_id();
$restwell_story_heading = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $restwell_story_id, 'story_heading', 'Why Restwell exists' )
	: 'Why Restwell exists';
$restwell_story_hook    = 'We started Restwell because of a gap we kept running into from the other side of it.';
$restwell_story_intro   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text(
		$restwell_story_id,
		'story_intro',
		$restwell_story_hook
	)
	: $restwell_story_hook;
if ( 0 === strpos( $restwell_story_intro, 'Restwell Retreats is an adapted holiday bungalow' ) ) {
	$restwell_story_intro = $restwell_story_hook;
}
$restwell_story_eyebrow = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $restwell_story_id, 'story_label', '' )
	: '';

$story_txt = static function ( $key, $fallback ) use ( $restwell_story_id ) {
	return function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_story_id, $key, $fallback )
		: $fallback;
};

$story_origin_label   = $story_txt( 'story_origin_label', 'The gap' );
$story_origin_heading = $story_txt( 'story_origin_heading', 'How Restwell started' );
$story_origin_lede    = $story_txt( 'story_origin_lede', 'For over a decade, Continuity of Care Services has supported people in their own homes across Kent. In that time, we lost count of families who couldn’t make a holiday work. Honest access details were hard to find, and so was care for the stay.' );
$story_origin_body    = $story_txt( 'story_origin_body', 'People would travel three hours, only to find a door they couldn’t get through. So we bought a bungalow in Whitstable, adapted it properly and published every measurement. Now guests can check the fit first, and ask about care through the same office.' );

$story_month_label   = $story_txt( 'story_month_label', 'The build' );
$story_month_heading = $story_txt( 'story_month_heading', 'How the bungalow was built' );
$story_month_lede    = $story_txt( 'story_month_lede', 'Family, friends and three teams of experts got it ready in a month. Before anyone stayed, occupational therapists from Kent Community Health NHS Trust checked the bedroom and wet room.' );
$story_month_1_meta  = $story_txt( 'story_month_1_meta', 'Early March' );
$story_month_1_title = $story_txt( 'story_month_1_title', 'We got the keys' );
$story_month_1_body  = $story_txt( 'story_month_1_body', 'It needed more than a lick of paint.' );
$story_month_2_meta  = $story_txt( 'story_month_2_meta', 'During the build' );
$story_month_2_title = $story_txt( 'story_month_2_title', 'The specialists arrived' );
$story_month_2_body_default = 'Care Spaces and Thor Carpentry built the bedroom and wet room.';
$story_month_2_body  = $story_txt( 'story_month_2_body', $story_month_2_body_default );
$story_month_3_meta  = $story_txt( 'story_month_3_meta', 'Four weeks later' );
$story_month_3_title = $story_txt( 'story_month_3_title', 'It was ready' );
$story_month_3_body  = $story_txt( 'story_month_3_body', 'We measured everything and wrote it down.' );

$story_host_label   = $story_txt( 'story_host_label', 'Who runs both' );
$story_host_heading = $story_txt( 'story_host_heading', 'Victoria Walker' );
$story_host_lede    = $story_txt( 'story_host_lede', 'Victoria owns Restwell and is Continuity’s registered manager, so one person answers for the house and the care. Day to day, you’ll usually speak with someone else in the office. They work across both companies too, so you won’t have to start again each time.' );

$story_companies_label   = $story_txt( 'story_companies_label', 'Who does what' );
$story_companies_heading = $story_txt( 'story_companies_heading', 'Two companies, one conversation' );
$story_companies_lede    = $story_txt( 'story_companies_lede', 'Restwell runs the bungalow. Continuity of Care Services provides the optional care. They quote for it once you’ve talked through what you need.' );
$story_companies_items   = array(
	array(
		'title' => $story_txt( 'story_companies_1_title', 'Restwell' ),
		'body'  => $story_txt( 'story_companies_1_body', 'It’s a private holiday home in Whitstable, not a care home or a respite centre.' ),
	),
	array(
		'title' => $story_txt( 'story_companies_2_title', 'Continuity of Care Services' ),
		'body'  => $story_txt( 'story_companies_2_body', 'Care while you stay is up to you. If you want it, it comes from Continuity’s own team.' ),
	),
);
$story_companies_note = $story_txt( 'story_companies_note', 'Restwell is not a registered care provider, but Continuity of Care Services is.' );

$story_shaped_label   = $story_txt( 'story_shaped_label', 'Shaped with guests' );
$story_shaped_heading = $story_txt( 'story_shaped_heading', 'Built around what disabled people told us' );
$story_shaped_lede    = $story_txt( 'story_shaped_lede', 'Before we opened, we asked what helps during a transfer and what gets in the way. The layout and the kit came from the answers, not from guesswork.' );

$story_specialists_label      = $story_txt( 'story_specialists_label', 'Check the details for yourself' );
$story_specialists_heading    = $story_txt( 'story_specialists_heading', 'Every measurement is published' );
$story_specialists_lede       = $story_txt( 'story_specialists_lede', 'Every measurement is on the Accessibility page, good or bad. Check the doors and spaces against your own chair or hoist before you book. If you’re not sure, just ask.' );
$story_specialists_btn1_label = $story_txt( 'story_specialists_btn1_label', 'Door widths and the hoist' );
$story_specialists_btn2_label = $story_txt( 'story_specialists_btn2_label', 'Tour the property' );

$story_next_label   = $story_txt( 'story_next_label', 'What we’re trying to do' );
$story_next_heading = $story_txt( 'story_next_heading', 'What we hold ourselves to' );
$story_next_lede    = $story_txt( 'story_next_lede', 'We publish every measurement. We say what the house can’t do as clearly as what it can. You can plan a week away, and the support to enjoy it, in one call. Nobody should have to explain their needs four times to four different people.' );
?>


<main id="main-content">
<?php
get_template_part(
	'template-parts/concept/photo-hero',
	null,
	array(
		'heading_id' => 'page-h',
		'heading'    => $restwell_story_heading,
		'eyebrow'    => $restwell_story_eyebrow,
		'intro'      => $restwell_story_intro,
		'crumbs'     => array(
			array(
				'label' => __( 'Home', 'restwell-retreats' ),
				'url'   => home_url( '/' ),
			),
			array(
				'label' => 'Our Story',
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
		  <?php if ( '' !== $story_origin_label ) : ?>
		  <li><a href="#origin"><?php echo esc_html( $story_origin_label ); ?></a></li>
		  <?php endif; ?>
		  <?php if ( '' !== $story_month_label ) : ?>
		  <li><a href="#month"><?php echo esc_html( $story_month_label ); ?></a></li>
		  <?php endif; ?>
		  <?php if ( '' !== $story_host_label ) : ?>
		  <li><a href="#host"><?php echo esc_html( $story_host_label ); ?></a></li>
		  <?php endif; ?>
		  <?php if ( '' !== $story_companies_label ) : ?>
		  <li><a href="#companies"><?php echo esc_html( $story_companies_label ); ?></a></li>
		  <?php endif; ?>
		  <?php if ( '' !== $story_shaped_label ) : ?>
		  <li><a href="#shaped"><?php echo esc_html( $story_shaped_label ); ?></a></li>
		  <?php endif; ?>
		  <?php if ( '' !== $story_specialists_label ) : ?>
		  <li><a href="#specialists"><?php echo esc_html( $story_specialists_label ); ?></a></li>
		  <?php endif; ?>
		  <?php if ( '' !== $story_next_label ) : ?>
		  <li><a href="#next"><?php echo esc_html( $story_next_label ); ?></a></li>
		  <?php endif; ?>
		</ul>
	  </div>
	</nav>

	<section class="section-y band-white" id="origin" aria-labelledby="origin-h">
	  <div class="container split split--fill">
		<div>
		  <header class="section-head section-head--tight">
			<?php if ( '' !== $story_origin_label ) : ?>
			<p class="eyebrow"><?php echo esc_html( $story_origin_label ); ?></p>
			<?php endif; ?>
			<h2 id="origin-h"><?php echo esc_html( $story_origin_heading ); ?></h2>
			<?php if ( '' !== $story_origin_lede ) : ?>
			<p class="lede"><?php echo esc_html( $story_origin_lede ); ?></p>
			<?php endif; ?>
		  </header>
		  <?php if ( '' !== $story_origin_body ) : ?>
		  <p><?php echo esc_html( $story_origin_body ); ?></p>
		  <?php endif; ?>
		</div>
		<div class="split__media" data-reveal>
				 <img src="<?php echo esc_url( restwell_theme_image_url( 'journey/bungalow-before-renovation.webp' ) ); ?>" alt="The bungalow before renovation, with peeling render and an overgrown front garden" width="900" height="675" loading="lazy" />
		</div>
	  </div>
	</section>

	<?php
	// How the bungalow was built (22 Oct 2026, owner's pick after five rounds):
	// the teal card from Funding & Support, the month in white on the left and
	// the finished house on the right; on phones the photo leads.
	$story_month_steps = array(
		array( $story_month_1_meta, $story_month_1_title, $story_month_1_body ),
		array( $story_month_2_meta, $story_month_2_title, $story_month_2_body ),
		array( $story_month_3_meta, $story_month_3_title, $story_month_3_body ),
	);
	?>
	<section class="section-y band-subtle" id="month" aria-labelledby="month-h">
	  <div class="container">
		<div class="build-card">
		  <div class="build-card__words">
			<h2 id="month-h"><?php echo esc_html( $story_month_heading ); ?></h2>
			<?php if ( '' !== $story_month_lede ) : ?>
			<p class="build-card__lede"><?php echo esc_html( $story_month_lede ); ?></p>
			<?php endif; ?>
			<ol class="build-card__steps">
			  <?php foreach ( $story_month_steps as $story_month_i => $story_month_step ) : ?>
					<?php
					if ( '' === $story_month_step[1] ) {
						continue;
					}
					?>
			  <li>
					<?php if ( '' !== $story_month_step[0] ) : ?>
					<p class="build-card__when"><?php echo esc_html( $story_month_step[0] ); ?></p>
					<?php endif; ?>
					<h3><?php echo esc_html( $story_month_step[1] ); ?></h3>
					<?php if ( 1 === $story_month_i && $story_month_2_body === $story_month_2_body_default ) : ?>
					<p><a href="https://www.carespaces.co.uk/" target="_blank" rel="noopener noreferrer">Care Spaces<span class="sr-only"> <?php esc_html_e( '(opens in new tab)', 'restwell-retreats' ); ?></span></a> <?php esc_html_e( 'and', 'restwell-retreats' ); ?> <a href="https://thorcarpenter.co.uk/" target="_blank" rel="noopener noreferrer">Thor Carpentry<span class="sr-only"> <?php esc_html_e( '(opens in new tab)', 'restwell-retreats' ); ?></span></a> <?php esc_html_e( 'built the bedroom and wet room.', 'restwell-retreats' ); ?></p>
					<?php elseif ( '' !== $story_month_step[2] ) : ?>
					<p><?php echo esc_html( $story_month_step[2] ); ?></p>
					<?php endif; ?>
			  </li>
			  <?php endforeach; ?>
			</ol>
		  </div>
		  <img class="build-card__photo" src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/EX-1-LS.jpg' ) ); ?>" alt="<?php esc_attr_e( 'The adapted bungalow as it is now, with hanging baskets under the windows', 'restwell-retreats' ); ?>" width="1920" height="1200" sizes="(min-width: 900px) 460px, 100vw" loading="lazy" decoding="async" />
		</div>
	  </div>
	</section>

	<?php // Who runs both (21 Oct 2026): Victoria's full-length portrait in the first of the page's three columns, her words across the other two. It was another half-and-half split, the third in a row. ?>
	<section class="section-y band-white" id="host" aria-labelledby="host-h">
	  <div class="container story-host">
		<img class="story-host__photo" src="<?php echo esc_url( restwell_theme_image_url( 'journey/victoria-walker-full.webp' ) ); ?>" alt="<?php echo esc_attr( restwell_theme_image_alt( 'journey/victoria-walker.webp' ) ); ?>" width="1620" height="1859" sizes="(min-width: 1200px) 352px, (min-width: 768px) 30vw, 100vw" loading="lazy" decoding="async" data-reveal />
		<div class="story-host__copy">
		  <header class="section-head section-head--tight">
			<?php if ( '' !== $story_host_label ) : ?>
			<p class="eyebrow"><?php echo esc_html( $story_host_label ); ?></p>
			<?php endif; ?>
			<h2 id="host-h"><?php echo esc_html( $story_host_heading ); ?></h2>
			<?php if ( '' !== $story_host_lede ) : ?>
			<p class="lede"><?php echo esc_html( $story_host_lede ); ?></p>
			<?php endif; ?>
			<?php
			// Faces for "someone else in the office" (photos published with consent, 13 Oct 2026).
			$story_team = array(
				'keelie-varney' => 'Keelie Varney',
				'nikki-mackay'  => 'Nikki Mackay',
			);
			?>
			<ul class="host-team" role="list">
			  <?php foreach ( $story_team as $story_team_file => $story_team_name ) : ?>
			  <li class="host-team__member">
				<img class="host-team__photo" src="<?php echo esc_url( restwell_theme_image_url( 'journey/' . $story_team_file . '.webp' ) ); ?>" alt="" width="1500" height="2000" sizes="4rem" loading="lazy" decoding="async" />
				<span class="host-team__name"><?php echo esc_html( $story_team_name ); ?></span>
			  </li>
			  <?php endforeach; ?>
			</ul>
		  </header>
		</div>
	  </div>
	</section>

	<?php
	// Who does what (21 Oct 2026): Home's photo card for Restwell beside a white
	// card for Continuity, its logo and CQC badge loose (no boxes round them)
	// with the registration note under them. No call to action of its own: the
	// closing band below carries Enquire. It was a paired panel with four links
	// and a dark "one place to start" bar.
	$story_co_restwell = $story_companies_items[0];
	$story_co_care     = $story_companies_items[1];
	$story_co_cqc_url  = 'https://www.cqc.org.uk/location/1-2624556588';
	?>
	<section class="section-y band-subtle" id="companies" aria-labelledby="companies-h">
	  <div class="container">
		<header class="section-head">
		  <?php if ( '' !== $story_companies_label ) : ?>
		  <p class="eyebrow"><?php echo esc_html( $story_companies_label ); ?></p>
		  <?php endif; ?>
		  <h2 id="companies-h"><?php echo esc_html( $story_companies_heading ); ?></h2>
		  <?php if ( '' !== $story_companies_lede ) : ?>
		  <p class="lede"><?php echo esc_html( $story_companies_lede ); ?></p>
		  <?php endif; ?>
		</header>
		<ul class="company-cards" role="list">
		  <li class="care-choice care-choice--own">
			<img class="care-choice__photo" src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/GRDEN-1-LS.jpg' ) ); ?>" alt="" width="2400" height="1500" sizes="(min-width: 960px) 640px, 100vw" loading="lazy" decoding="async" />
			<div class="care-choice__text">
			  <h3><?php echo esc_html( $story_co_restwell['title'] ); ?></h3>
			  <p><?php echo esc_html( $story_co_restwell['body'] ); ?></p>
			</div>
		  </li>
		  <li class="company-card">
			<div class="company-card__marks">
			  <div class="company-card__logos">
				<a href="https://www.continuitycareservices.co.uk/" target="_blank" rel="noopener noreferrer">
				  <img class="company-card__logo" src="<?php echo esc_url( restwell_theme_image_url( 'partners/continuity-of-care-services-long.png' ) ); ?>" alt="<?php esc_attr_e( 'Continuity of Care Services (opens in a new tab)', 'restwell-retreats' ); ?>" width="405" height="69" loading="lazy" decoding="async" />
				</a>
				<a href="<?php echo esc_url( $story_co_cqc_url ); ?>" target="_blank" rel="noopener noreferrer">
				  <img class="company-card__cqc" src="<?php echo esc_url( restwell_theme_image_url( 'partners/cqc-rating-good.jpg' ) ); ?>" alt="<?php esc_attr_e( 'CQC rating Good, Continuity of Care Services (opens in a new tab)', 'restwell-retreats' ); ?>" width="710" height="399" loading="lazy" decoding="async" />
				</a>
			  </div>
			  <?php if ( '' !== $story_companies_note ) : ?>
			  <p class="company-card__note"><?php echo esc_html( $story_companies_note ); ?></p>
			  <?php endif; ?>
			</div>
			<div class="care-choice__text">
			  <h3><?php echo esc_html( $story_co_care['title'] ); ?></h3>
			  <p><?php echo esc_html( $story_co_care['body'] ); ?></p>
			</div>
		  </li>
		</ul>
	  </div>
	</section>

	<section class="section-y band-white" id="shaped" aria-labelledby="shaped-h">
	  <div class="container split split--flip split--fill">
		<div>
		  <header class="section-head section-head--tight">
			<?php if ( '' !== $story_shaped_label ) : ?>
			<p class="eyebrow"><?php echo esc_html( $story_shaped_label ); ?></p>
			<?php endif; ?>
			<h2 id="shaped-h"><?php echo esc_html( $story_shaped_heading ); ?></h2>
			<?php if ( '' !== $story_shaped_lede ) : ?>
			<p class="lede"><?php echo esc_html( $story_shaped_lede ); ?></p>
			<?php endif; ?>
		  </header>
		</div>
		<div class="split__media" data-reveal>
		  <img src="<?php echo esc_url( restwell_theme_image_url( 'journey/restwell-first-guests.webp' ) ); ?>" alt="Restwell’s first guests outside the conservatory, one in a wheelchair" width="1200" height="1600" loading="lazy" decoding="async" />
		</div>
	  </div>
	</section>



	<section class="section-y band-subtle" id="specialists" aria-labelledby="specialists-h">
	  <div class="container">
		<div class="split split--fill">
		  <div class="specialists__copy">
			<?php if ( '' !== $story_specialists_label ) : ?>
			<p class="eyebrow"><?php echo esc_html( $story_specialists_label ); ?></p>
			<?php endif; ?>
			<h2 id="specialists-h"><?php echo esc_html( $story_specialists_heading ); ?></h2>
			<?php if ( '' !== $story_specialists_lede ) : ?>
			<p class="lede"><?php echo esc_html( $story_specialists_lede ); ?></p>
			<?php endif; ?>
			<div class="specialists__actions">
			  <?php if ( '' !== $story_specialists_btn1_label ) : ?>
			  <a class="btn btn-outline-teal" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'accessibility' ) ); ?>"><?php echo esc_html( $story_specialists_btn1_label ); ?></a>
			  <?php endif; ?>
			  <?php if ( '' !== $story_specialists_btn2_label ) : ?>
			  <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'the-property' ) ); ?>"><?php echo esc_html( $story_specialists_btn2_label ); ?></a>
			  <?php endif; ?>
			</div>
		  </div>
		  <div class="split__media" data-reveal>
			<img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/BD2-6-LS.jpg' ) ); ?>" alt="Amico ceiling track hoist over the profiling bed" width="1600" height="1000" loading="lazy" />
		  </div>
		</div>
	  </div>
	</section>

	<?php
	// Guest words, consecutive and unedited bar the capital and the closing
	// stop (docs/guest-reviews-bank.md); initials only. One line about the
	// design leads, then two about the stay. The same band as the homepage.
	get_template_part(
		'template-parts/google-reviews',
		null,
		array(
			'curated'   => true,
			'fallbacks' => array(
				array(
					'quote' => 'The entire house though, mirrors one philosophy, be flat, be accessible.',
					'name'  => 'M.P.',
					'role'  => 'Wheelchair user · Google review',
				),
				array(
					'quote' => 'The bungalow is modern and spotless. It is fully equipped – for both the person you are caring for, and for the carer.',
					'name'  => 'M.H.',
					'role'  => 'Family carer · Google review',
				),
				array(
					'quote' => 'Everything is thoughtfully organised and easy to use, and Victoria was friendly, helpful and very easy to communicate with.',
					'name'  => 'N.T.',
					'role'  => 'Guest · Google review',
				),
			),
		)
	);
	?>

	<?php
	// The closing lines are three short commitments; each gets its own row.
	$story_next_points = array_values( array_filter( array_map( 'trim', (array) preg_split( '/(?<=[.!?])\s+/u', $story_next_lede ) ) ) );
	?>
	<section class="section-y band-subtle story-close" id="next" aria-labelledby="next-h">
	  <div class="container story-close__grid">
		<div class="story-close__head">
		  <?php if ( '' !== $story_next_label ) : ?>
		  <p class="eyebrow"><?php echo esc_html( $story_next_label ); ?></p>
		  <?php endif; ?>
		  <h2 id="next-h"><?php echo esc_html( $story_next_heading ); ?></h2>
		  <p class="restwell-signoff"><?php esc_html_e( 'Rest Easy, Stay Well.', 'restwell-retreats' ); ?></p>
		</div>
		<?php if ( count( $story_next_points ) >= 2 ) : ?>
		<ul class="story-close__list" role="list">
			<?php foreach ( $story_next_points as $story_next_point ) : ?>
			<li><?php echo esc_html( $story_next_point ); ?></li>
			<?php endforeach; ?>
		</ul>
		<?php elseif ( '' !== $story_next_lede ) : ?>
		<p class="lede"><?php echo esc_html( $story_next_lede ); ?></p>
		<?php endif; ?>
	  </div>
	</section>

	<?php
	$story_mid_cta_heading = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_story_id, 'story_cta_heading', __( 'See what that means inside the bungalow', 'restwell-retreats' ) )
		: __( 'See what that means inside the bungalow', 'restwell-retreats' );
	$story_mid_cta_intro   = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text(
			$restwell_story_id,
			'story_cta_body',
			__( 'You can check door widths, hoist details and photos of each room before you get in touch. Compare them with what you need, and ask about anything that isn’t clear.', 'restwell-retreats' )
		)
		: __( 'You can check door widths, hoist details and photos of each room before you get in touch. Compare them with what you need, and ask about anything that isn’t clear.', 'restwell-retreats' );
	$story_mid_cta_primary_label = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_story_id, 'story_cta_primary_label', __( 'Enquire', 'restwell-retreats' ) )
		: __( 'Enquire', 'restwell-retreats' );
	$story_mid_cta_primary_url   = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_story_id, 'story_cta_primary_url', restwell_nav_resolve_page_url( 'enquire' ) )
		: restwell_nav_resolve_page_url( 'enquire' );
	$story_mid_cta_secondary_label = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_story_id, 'story_cta_secondary_label', __( 'Tour the property', 'restwell-retreats' ) )
		: __( 'Tour the property', 'restwell-retreats' );
	$story_mid_cta_secondary_url   = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_story_id, 'story_cta_secondary_url', restwell_nav_resolve_page_url( 'the-property' ) )
		: restwell_nav_resolve_page_url( 'the-property' );

	get_template_part(
		'template-parts/mid-cta',
		null,
		array(
			'heading'         => $story_mid_cta_heading,
			'intro'           => $story_mid_cta_intro,
			'primary_label'   => $story_mid_cta_primary_label,
			'primary_url'     => $story_mid_cta_primary_url,
			'secondary_label' => $story_mid_cta_secondary_label,
			'secondary_url'   => $story_mid_cta_secondary_url,
		)
	);
	?>

</main>

<?php
get_footer();
