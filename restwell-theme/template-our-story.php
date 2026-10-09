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

$restwell_host_phone = function_exists( 'restwell_get_public_phone_number' )
	? restwell_get_public_phone_number()
	: '01622 809881';
$restwell_host_tel   = function_exists( 'restwell_get_public_phone_tel' )
	? restwell_get_public_phone_tel()
	: '01622809881';

$story_txt = static function ( $key, $fallback ) use ( $restwell_story_id ) {
	return function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_story_id, $key, $fallback )
		: $fallback;
};

$story_origin_label   = $story_txt( 'story_origin_label', 'The gap' );
$story_origin_heading = $story_txt( 'story_origin_heading', 'How Restwell started' );
$story_origin_lede    = $story_txt( 'story_origin_lede', 'Continuity of Care Services has been supporting people in their own homes across Kent for over a decade. In that time we lost count of the families who wanted a holiday and couldn’t make it work. Finding a house with honest access information was only part of it. Arranging suitable care during the stay could be just as difficult.' );
$story_origin_body    = $story_txt( 'story_origin_body', 'Somebody would travel for three hours, only to find a doorway they couldn’t get through. So we bought a bungalow in Whitstable that needed a lot of work, and we adapted it properly. Then we measured everything and published the details, including the ones that aren’t flattering. Guests can check the bungalow will work for them before they set off, and arrange optional care through the same office.' );

$story_month_label   = $story_txt( 'story_month_label', 'The build' );
$story_month_heading = $story_txt( 'story_month_heading', 'How the bungalow was built' );
$story_month_lede    = $story_txt( 'story_month_lede', 'Family, friends and three specialist teams brought the bungalow together in a month. Before anyone stayed, occupational therapists from Kent Community Health NHS Trust walked the bedroom and wet room. We changed what they flagged, down to the profiling bed.' );
$story_month_1_meta  = $story_txt( 'story_month_1_meta', 'Early March' );
$story_month_1_title = $story_txt( 'story_month_1_title', 'We got the keys' );
$story_month_1_body  = $story_txt( 'story_month_1_body', 'The bungalow needed more than a lick of paint.' );
$story_month_2_meta  = $story_txt( 'story_month_2_meta', 'During the build' );
$story_month_2_title = $story_txt( 'story_month_2_title', 'The specialists arrived' );
$story_month_2_body_default = 'The accessible bedroom and wet room were built by Care Spaces by Wealden Rehab and Thor Carpentry, with the occupational therapists’ advice. Family and friends filled the rest.';
$story_month_2_body  = $story_txt( 'story_month_2_body', $story_month_2_body_default );
$story_month_3_meta  = $story_txt( 'story_month_3_meta', 'Four weeks later' );
$story_month_3_title = $story_txt( 'story_month_3_title', 'The bungalow was ready' );
$story_month_3_body  = $story_txt( 'story_month_3_body', 'Once the work was finished, we measured everything and wrote the numbers down.' );

$story_host_label   = $story_txt( 'story_host_label', 'Who runs both' );
$story_host_heading = $story_txt( 'story_host_heading', 'Victoria Walker' );
$story_host_lede    = $story_txt( 'story_host_lede', 'Victoria owns Restwell and is Continuity’s registered manager, so one person is accountable for the house and for the care. Day to day, you’re more likely to speak with someone else in the office. They work across both companies too, so you won’t need to start from the beginning each time you call.' );

$story_companies_label   = $story_txt( 'story_companies_label', 'Who does what' );
$story_companies_heading = $story_txt( 'story_companies_heading', 'Two companies, one conversation' );
$story_companies_lede    = $story_txt( 'story_companies_lede', 'Restwell provides the accommodation. Continuity of Care Services provides the optional care. They invoice separately, and that is deliberate: funders usually treat accommodation and care as two different budgets, so keeping them apart makes your paperwork simpler, not harder.' );
$story_companies_items   = array(
	array(
		'title' => $story_txt( 'story_companies_1_title', 'Restwell' ),
		'body'  => $story_txt( 'story_companies_1_body', 'The bungalow: a private adapted house in Whitstable. Not a care home, and not a respite centre.' ),
	),
	array(
		'title' => $story_txt( 'story_companies_2_title', 'Continuity of Care Services' ),
		'body'  => $story_txt( 'story_companies_2_body', 'Optional home care during your stay, always from Continuity’s own team.' ),
	),
	array(
		'title' => $story_txt( 'story_companies_3_title', 'One place to start' ),
		'body'  => $story_txt( 'story_companies_3_body', 'Ask about the bungalow and any care in the same call, to the same office.' ),
	),
);
$story_companies_note      = $story_txt( 'story_companies_note', 'Restwell is not a registered care provider. Continuity of Care Services is.' );
$story_companies_cqc_label = $story_txt( 'story_companies_cqc_label', 'Read Continuity’s CQC profile' );

$story_shaped_label   = $story_txt( 'story_shaped_label', 'Shaped by guests' );
$story_shaped_heading = $story_txt( 'story_shaped_heading', 'Designed with the people who’d actually stay' );
$story_shaped_lede    = $story_txt( 'story_shaped_lede', 'People with muscular dystrophy or cerebral palsy, and people recovering from strokes, told us what mattered during transfers, what got in the way, and what they needed from the stay. The layout and the kit grew from those conversations, rather than from assumptions on paper.' );

$story_specialists_label      = $story_txt( 'story_specialists_label', 'Check the details for yourself' );
$story_specialists_heading    = $story_txt( 'story_specialists_heading', 'The numbers are published so you don’t have to trust us' );
$story_specialists_lede       = $story_txt( 'story_specialists_lede', 'Every measurement is on the Accessibility page, including the ones that aren’t flattering. Compare the door widths, spaces, and equipment limits with your own chair, hoist, or other kit before you book. If you’re unsure whether something will work, please ask.' );
$story_specialists_btn1_label = $story_txt( 'story_specialists_btn1_label', 'Read the access specs' );
$story_specialists_btn2_label = $story_txt( 'story_specialists_btn2_label', 'Tour the property' );

$story_next_label   = $story_txt( 'story_next_label', 'What we’re trying to do' );
$story_next_heading = $story_txt( 'story_next_heading', 'Nothing very complicated' );
$story_next_lede    = $story_txt( 'story_next_lede', 'Publish the numbers. Say what the house can’t do as clearly as what it can. Make it possible to arrange a week away, and the support to enjoy it, in a single conversation, without anyone having to explain their situation four times to four different people.' );
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

	<section class="section-y band-subtle process" id="month" aria-labelledby="month-h">
	  <div class="container">
		<div class="split split--fill process__intro">
		  <header class="section-head process__head">
		  <?php if ( '' !== $story_month_label ) : ?>
		  <p class="eyebrow"><?php echo esc_html( $story_month_label ); ?></p>
		  <?php endif; ?>
		  <h2 id="month-h"><?php echo esc_html( $story_month_heading ); ?></h2>
		  <?php if ( '' !== $story_month_lede ) : ?>
		  <p class="lede"><?php echo esc_html( $story_month_lede ); ?></p>
		  <?php endif; ?>
		</header>
		  <div class="split__media" data-reveal>
			<img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/EX-1-LS.jpg' ) ); ?>" alt="The adapted bungalow as it is now, with a level driveway and front garden" width="1600" height="1000" loading="lazy" />
		  </div>
		</div>
		<div class="process__layout">
		  <ol class="process-list">
			<li>
			  <span class="process-list__index" aria-hidden="true">01</span>
			  <div class="process-list__body">
				<?php if ( '' !== $story_month_1_meta ) : ?>
				<p class="process-list__meta"><?php echo esc_html( $story_month_1_meta ); ?></p>
				<?php endif; ?>
				<?php if ( '' !== $story_month_1_title ) : ?>
				<h3><?php echo esc_html( $story_month_1_title ); ?></h3>
				<?php endif; ?>
				<?php if ( '' !== $story_month_1_body ) : ?>
				<p><?php echo esc_html( $story_month_1_body ); ?></p>
				<?php endif; ?>
			  </div>
			</li>
			<li>
			  <span class="process-list__index" aria-hidden="true">02</span>
			  <div class="process-list__body">
				<?php if ( '' !== $story_month_2_meta ) : ?>
				<p class="process-list__meta"><?php echo esc_html( $story_month_2_meta ); ?></p>
				<?php endif; ?>
				<?php if ( '' !== $story_month_2_title ) : ?>
				<h3><?php echo esc_html( $story_month_2_title ); ?></h3>
				<?php endif; ?>
				<?php if ( $story_month_2_body === $story_month_2_body_default ) : ?>
				<p>
					<?php esc_html_e( 'The accessible bedroom and wet room were built by', 'restwell-retreats' ); ?>
					<a class="text-link" href="https://www.carespaces.co.uk/" target="_blank" rel="noopener noreferrer">Care Spaces by Wealden Rehab<span class="sr-only"><?php esc_html_e( ' (opens in new tab)', 'restwell-retreats' ); ?></span></a>
					<?php esc_html_e( 'and', 'restwell-retreats' ); ?>
					<a class="text-link" href="https://thorcarpenter.co.uk/" target="_blank" rel="noopener noreferrer">Thor Carpentry<span class="sr-only"><?php esc_html_e( ' (opens in new tab)', 'restwell-retreats' ); ?></span></a><?php esc_html_e( ', with the occupational therapists’ advice. Family and friends filled the rest.', 'restwell-retreats' ); ?>
				</p>
				<?php elseif ( '' !== $story_month_2_body ) : ?>
				<p><?php echo esc_html( $story_month_2_body ); ?></p>
				<?php endif; ?>
			  </div>
			</li>
			<li>
			  <span class="process-list__index" aria-hidden="true">03</span>
			  <div class="process-list__body">
				<?php if ( '' !== $story_month_3_meta ) : ?>
				<p class="process-list__meta"><?php echo esc_html( $story_month_3_meta ); ?></p>
				<?php endif; ?>
				<?php if ( '' !== $story_month_3_title ) : ?>
				<h3><?php echo esc_html( $story_month_3_title ); ?></h3>
				<?php endif; ?>
				<?php if ( '' !== $story_month_3_body ) : ?>
				<p><?php echo esc_html( $story_month_3_body ); ?></p>
				<?php endif; ?>
			  </div>
			</li>
		  </ol>
		</div>
	  </div>
	</section>

	<section class="section-y band-white" id="host" aria-labelledby="host-h">
	  <div class="container split split--fill">
		<div>
		  <header class="section-head section-head--tight">
			<?php if ( '' !== $story_host_label ) : ?>
			<p class="eyebrow"><?php echo esc_html( $story_host_label ); ?></p>
			<?php endif; ?>
			<h2 id="host-h"><?php echo esc_html( $story_host_heading ); ?></h2>
			<?php if ( '' !== $story_host_lede ) : ?>
			<p class="lede"><?php echo esc_html( $story_host_lede ); ?></p>
			<?php endif; ?>
		  </header>
		</div>
		<div class="split__media" data-reveal>
		  <img src="<?php echo esc_url( restwell_theme_image_url( 'journey/victoria-walker.webp' ) ); ?>" alt="<?php echo esc_attr( restwell_theme_image_alt( 'journey/victoria-walker.webp' ) ); ?>" width="1600" height="1200" loading="lazy" decoding="async" />
		</div>
	  </div>
	</section>

	<?php
	$story_companies_band_items = $story_companies_items;
	if ( isset( $story_companies_band_items[2] ) ) {
		$story_companies_band_items[0]['link'] = array(
			'label' => __( 'Tour the property', 'restwell-retreats' ),
			'url'   => restwell_nav_resolve_page_url( 'the-property' ),
		);
		$story_companies_band_items[2]['html'] = '<a class="text-link" href="' . esc_url( 'tel:' . $restwell_host_tel ) . '">' . esc_html( $restwell_host_phone ) . '</a>';
	}
	get_template_part(
		'template-parts/sister-company',
		null,
		array(
			'id'      => 'companies',
			'band'    => 'band-subtle',
			'badges_in'  => 1,
			'label'   => $story_companies_label,
			'heading' => $story_companies_heading,
			'lede'    => $story_companies_lede,
			'items'   => $story_companies_band_items,
			'note'    => $story_companies_note,
			'link'    => array(
				'label'    => $story_companies_cqc_label,
				'url'      => 'https://www.cqc.org.uk/location/1-2624556588',
				'external' => true,
			),
		)
	);
	?>

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
		  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/WR-1-LS.jpg' ) ); ?>" alt="Level-access wet room with grab rails" width="1200" height="750" loading="lazy" />
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
			  <a class="btn btn-gold" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'accessibility' ) ); ?>"><?php echo esc_html( $story_specialists_btn1_label ); ?></a>
			  <?php endif; ?>
			  <?php if ( '' !== $story_specialists_btn2_label ) : ?>
			  <a class="btn btn-outline-teal" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'the-property' ) ); ?>"><?php echo esc_html( $story_specialists_btn2_label ); ?></a>
			  <?php endif; ?>
			</div>
		  </div>
		  <div class="split__media" data-reveal>
			<img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/BD2-6-LS.jpg' ) ); ?>" alt="Amico ceiling track hoist over the profiling bed" width="1600" height="1000" loading="lazy" />
		  </div>
		</div>
	  </div>
	</section>

	<section class="section-y band-white story-quotes" aria-labelledby="quote-h">
	  <div class="container">
		<h2 id="quote-h" class="sr-only">What guests say</h2>
		<div class="story-quotes__grid">
		  <figure class="pull-quote">
		  <span class="pull-quote__mark" aria-hidden="true">&ldquo;</span>
		  <blockquote class="pull-quote__text">It truly amazes me, just how much work has gone into this “home from home”.</blockquote>
		  <figcaption class="pull-quote__cite"><cite>M.P.</cite><span class="pull-quote__role">Guest review</span></figcaption>
		</figure>
		  <figure class="pull-quote">
		  <span class="pull-quote__mark" aria-hidden="true">&ldquo;</span>
		  <?php /* Guest words: consecutive from M.W. Facebook review (docs/guest-reviews-bank.md). Distinct reviewer from the homepage cards and the M.P. pull-quote above. */ ?>
		  <blockquote class="pull-quote__text">The house was well equipped with all the facilities we needed for my Dad’s complex needs. Vicky and Keeley could not do enough for us, we forgot flannels and they traveled to bring us some which was very kind.</blockquote>
		  <figcaption class="pull-quote__cite"><cite>M.W.</cite><span class="pull-quote__role">Visiting family &middot; Facebook review</span></figcaption>
		</figure>
		</div>
	  </div>
	</section>

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
			__( 'You can check door widths, hoist details, and photographs of each room before you contact us. Compare them with what you need, and ask about anything that isn’t clear.', 'restwell-retreats' )
		)
		: __( 'You can check door widths, hoist details, and photographs of each room before you contact us. Compare them with what you need, and ask about anything that isn’t clear.', 'restwell-retreats' );
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
