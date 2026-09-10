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
$story_origin_lede    = $story_txt( 'story_origin_lede', 'Continuity of Care Services has been supporting people in their own homes across Kent for years. In that time we lost count of the families who wanted a holiday and couldn’t make one work, not because of money, and not because of the care, but because the houses on offer weren’t honest.' );
$story_origin_body    = $story_txt( 'story_origin_body', 'Somebody would arrive after a three-hour drive to find a doorway they couldn’t get through. So we bought a bungalow in Whitstable that needed a lot of work, and we adapted it properly. Then we wrote down every measurement, including the ones that aren’t flattering, because that was the whole problem: nobody else had.' );

$story_month_label   = $story_txt( 'story_month_label', 'The build' );
$story_month_heading = $story_txt( 'story_month_heading', 'How the bungalow was built' );
$story_month_lede    = $story_txt( 'story_month_lede', 'Family, friends, and three specialist teams did the work. Occupational therapists at Kent Community Health NHS Trust advised on the bedroom and wet room before a guest ever stayed.' );
$story_month_1_meta  = $story_txt( 'story_month_1_meta', 'Early March' );
$story_month_1_title = $story_txt( 'story_month_1_title', 'We got the keys' );
$story_month_1_body  = $story_txt( 'story_month_1_body', 'The bungalow needed more than a lick of paint.' );
$story_month_2_meta  = $story_txt( 'story_month_2_meta', 'During the build' );
$story_month_2_title = $story_txt( 'story_month_2_title', 'The specialists' );
$story_month_2_body_default = 'The accessible bedroom and wet room were built by Care Spaces by Wealden Rehab and Thor Carpentry, with the occupational therapists’ advice. Family and friends filled the rest.';
$story_month_2_body  = $story_txt( 'story_month_2_body', $story_month_2_body_default );
$story_month_3_meta  = $story_txt( 'story_month_3_meta', 'Four weeks later' );
$story_month_3_title = $story_txt( 'story_month_3_title', 'The bungalow was ready' );
$story_month_3_body  = $story_txt( 'story_month_3_body', 'Then we measured all of it and wrote the numbers down.' );

$story_host_label   = $story_txt( 'story_host_label', 'Who runs both' );
$story_host_heading = $story_txt( 'story_host_heading', 'Victoria Walker' );
$story_host_lede    = $story_txt( 'story_host_lede', 'The link between the two companies is a person. Victoria owns Restwell and is Continuity’s registered manager, so one person is accountable for the house and for the care. Day to day you are more likely to speak to someone else in the office, and they work across both as well.' );

$story_companies_label   = $story_txt( 'story_companies_label', 'Two companies' );
$story_companies_heading = $story_txt( 'story_companies_heading', 'Two companies, one conversation' );
$story_companies_lede    = $story_txt( 'story_companies_lede', 'Restwell is the house. Continuity is the care. They bill you separately, and that is deliberate rather than awkward: funders usually treat accommodation and care as two different budgets, so keeping them apart makes your paperwork simpler, not harder.' );
$story_companies_items   = array(
	array(
		'title' => $story_txt( 'story_companies_1_title', 'Restwell' ),
		'body'  => $story_txt( 'story_companies_1_body', 'The house. A private adapted bungalow, not a care home or respite centre. Separate invoice from any care.' ),
	),
	array(
		'title' => $story_txt( 'story_companies_2_title', 'Continuity of Care Services' ),
		'body'  => $story_txt( 'story_companies_2_body', 'Optional home care during a stay, invoiced separately. Victoria is their registered manager.' ),
	),
	array(
		'title' => $story_txt( 'story_companies_3_title', 'Same conversation' ),
		'body'  => $story_txt( 'story_companies_3_body', 'One office, one number. The house and the care get sorted in the same call.' ),
	),
);
$story_companies_note      = $story_txt( 'story_companies_note', 'Restwell is not a registered care provider and doesn’t pretend to be one. We’re a house. We mention Continuity’s rating so you know exactly who is accountable for the care, and can go and read the report yourself.' );
$story_companies_cqc_label = $story_txt( 'story_companies_cqc_label', 'Read Continuity’s CQC profile' );

$story_shaped_label   = $story_txt( 'story_shaped_label', 'Shaped by real needs' );
$story_shaped_heading = $story_txt( 'story_shaped_heading', 'Designed with the people who’d actually stay' );
$story_shaped_lede    = $story_txt( 'story_shaped_lede', 'Individuals with muscular dystrophy, cerebral palsy, and people recovering from strokes told us what mattered for transfers, what got in the way, and what “accessible” meant for them. The layout and the kit came from those conversations rather than from a plan on paper.' );

$story_specialists_label      = $story_txt( 'story_specialists_label', 'Check it yourself' );
$story_specialists_heading    = $story_txt( 'story_specialists_heading', 'The numbers are published so you don’t have to trust us' );
$story_specialists_lede       = $story_txt( 'story_specialists_lede', 'Every measurement is on the Accessibility page, including the ones that aren’t flattering. Measure your own chair, your own hoist, your own doorways at home, and compare them. That is what the houses we kept sending people to would never do.' );
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

	<nav class="subnav" aria-label="On this page">
	  <div class="container">
		<ul class="subnav__list">
		  <li><a href="#origin">The gap</a></li>
		  <li><a href="#month">Four weeks</a></li>
		  <li><a href="#host">Who runs both</a></li>
		  <li><a href="#companies">Two companies</a></li>
		  <li><a href="#shaped">Built around real stays</a></li>
		  <li><a href="#next">What's next</a></li>
		</ul>
	  </div>
	</nav>

	<section class="section-y band-white" id="origin" aria-labelledby="origin-h">
	  <div class="container split">
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
				 <img src="<?php echo esc_url( restwell_theme_image_url( 'journey/101-russel-drive-archive.webp' ) ); ?>" alt="The bungalow before renovation, with peeling render and an overgrown front garden" width="900" height="675" loading="lazy" />
		</div>
	  </div>
	</section>

	<section class="section-y band-subtle process" id="month" aria-labelledby="month-h">
	  <div class="container">
		<header class="section-head section-head--center process__head">
		  <?php if ( '' !== $story_month_label ) : ?>
		  <p class="eyebrow"><?php echo esc_html( $story_month_label ); ?></p>
		  <?php endif; ?>
		  <h2 id="month-h"><?php echo esc_html( $story_month_heading ); ?></h2>
		  <?php if ( '' !== $story_month_lede ) : ?>
		  <p class="lede"><?php echo esc_html( $story_month_lede ); ?></p>
		  <?php endif; ?>
		</header>
		<div class="process__layout">
		  <div class="process__media" data-reveal>
			<img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/EX-1-LS.jpg' ) ); ?>" alt="The adapted bungalow as it is now, with a level driveway and front garden" width="1600" height="1000" loading="lazy" />
		  </div>
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
	  <div class="container split">
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

	<section class="section-y band-subtle" id="companies" aria-labelledby="companies-h">
	  <div class="container">
		<header class="section-head section-head--tight">
		  <?php if ( '' !== $story_companies_label ) : ?>
		  <p class="eyebrow"><?php echo esc_html( $story_companies_label ); ?></p>
		  <?php endif; ?>
		  <h2 id="companies-h"><?php echo esc_html( $story_companies_heading ); ?></h2>
		  <?php if ( '' !== $story_companies_lede ) : ?>
		  <p class="lede"><?php echo esc_html( $story_companies_lede ); ?></p>
		  <?php endif; ?>
		</header>
		<dl class="comparison-list">
		  <?php foreach ( $story_companies_items as $company_i => $company_item ) : ?>
		  <div class="comparison-list__item">
			<?php if ( '' !== $company_item['title'] ) : ?>
			<dt><?php echo esc_html( $company_item['title'] ); ?></dt>
			<?php endif; ?>
			<?php if ( '' !== $company_item['body'] ) : ?>
			<dd>
			  <?php echo esc_html( $company_item['body'] ); ?>
			  <?php if ( 2 === $company_i ) : ?>
			  <a class="text-link" href="<?php echo esc_url( 'tel:' . $restwell_host_tel ); ?>"><?php echo esc_html( $restwell_host_phone ); ?></a>
			  <?php endif; ?>
			</dd>
			<?php endif; ?>
		  </div>
		  <?php endforeach; ?>
		</dl>
		<div class="care-page__trust">
		  <div class="care__foot-copy">
			<?php if ( '' !== $story_companies_note ) : ?>
			<p class="care__note"><?php echo esc_html( $story_companies_note ); ?></p>
			<?php endif; ?>
			<?php if ( '' !== $story_companies_cqc_label ) : ?>
			<a class="text-link" href="https://www.cqc.org.uk/location/1-2624556588" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $story_companies_cqc_label ); ?><span class="sr-only"><?php esc_html_e( ' (opens in new tab)', 'restwell-retreats' ); ?></span></a>
			<?php endif; ?>
		  </div>
		  <div class="care__brand" aria-label="<?php echo esc_attr__( 'Sister company and CQC rating', 'restwell-retreats' ); ?>">
			<a class="care__brand-link care__brand-link--ccs" href="https://www.continuitycareservices.co.uk/" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr__( 'Continuity of Care Services (opens in a new tab)', 'restwell-retreats' ); ?>">
			  <img src="<?php echo esc_url( restwell_theme_image_url( 'partners/continuity-of-care-services-long.png' ) ); ?>" alt="<?php echo esc_attr( restwell_theme_image_alt( 'partners/continuity-of-care-services-long.png' ) ); ?>" width="405" height="69" loading="lazy" decoding="async" />
			</a>
			<a class="care__brand-link care__brand-link--cqc" href="https://www.cqc.org.uk/location/1-2624556588" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr__( 'CQC rating Good, Continuity of Care Services (opens in a new tab)', 'restwell-retreats' ); ?>">
			  <img src="<?php echo esc_url( restwell_theme_image_url( 'partners/cqc-rating-good.jpg' ) ); ?>" alt="<?php echo esc_attr( restwell_theme_image_alt( 'partners/cqc-rating-good.jpg' ) ); ?>" width="710" height="399" loading="lazy" decoding="async" />
			</a>
		  </div>
		</div>
	  </div>
	</section>

	<section class="section-y band-white" id="shaped" aria-labelledby="shaped-h">
	  <div class="container split split--flip">
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

	<section class="section-y band-teal" id="specialists" aria-labelledby="specialists-h">
	  <div class="container">
		<div class="split">
		  <div class="band-teal__stack">
			<?php if ( '' !== $story_specialists_label ) : ?>
			<p class="eyebrow eyebrow--on-dark"><?php echo esc_html( $story_specialists_label ); ?></p>
			<?php endif; ?>
			<h2 id="specialists-h"><?php echo esc_html( $story_specialists_heading ); ?></h2>
			<?php if ( '' !== $story_specialists_lede ) : ?>
			<p class="lede"><?php echo esc_html( $story_specialists_lede ); ?></p>
			<?php endif; ?>
			<div class="band-teal__actions">
			  <?php if ( '' !== $story_specialists_btn1_label ) : ?>
			  <a class="btn btn-gold" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'accessibility' ) ); ?>"><?php echo esc_html( $story_specialists_btn1_label ); ?></a>
			  <?php endif; ?>
			  <?php if ( '' !== $story_specialists_btn2_label ) : ?>
			  <a class="btn btn-outline-light" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'the-property' ) ); ?>"><?php echo esc_html( $story_specialists_btn2_label ); ?></a>
			  <?php endif; ?>
			</div>
		  </div>
		  <div class="split__media" data-reveal>
			<img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/BD2-6-LS.jpg' ) ); ?>" alt="Amico ceiling track hoist over the profiling bed" width="1600" height="1000" loading="lazy" />
		  </div>
		</div>
	  </div>
	</section>

	<section class="section-y band-white" aria-labelledby="quote-h">
	  <div class="container">
		<h2 id="quote-h" class="sr-only">What a guest wrote after their stay</h2>
		<figure class="pull-quote">
		  <span class="pull-quote__mark" aria-hidden="true">&ldquo;</span>
		  <?php /* Guest words: consecutive from M.P. Google review (docs/guest-reviews-bank.md). Capital start so the decorative mark does not sit before a mid-sentence lowercase excerpt. */ ?>
		  <blockquote class="pull-quote__text">I will most definitely be back.. 10/10 from me, as there was NOTHING i needed to ask for, as Restwell Retreats had catered for it all already</blockquote>
		  <figcaption class="pull-quote__cite"><cite>M.P.</cite><span class="pull-quote__role">Wheelchair user &middot; Google review</span></figcaption>
		</figure>
	  </div>
	</section>

	<section class="section-y band-subtle" id="next" aria-labelledby="next-h">
	  <div class="container">
		<header class="section-head section-head--tight">
		  <?php if ( '' !== $story_next_label ) : ?>
		  <p class="eyebrow"><?php echo esc_html( $story_next_label ); ?></p>
		  <?php endif; ?>
		  <h2 id="next-h"><?php echo esc_html( $story_next_heading ); ?></h2>
		  <?php if ( '' !== $story_next_lede ) : ?>
		  <p class="lede"><?php echo esc_html( $story_next_lede ); ?></p>
		  <?php endif; ?>
		</header>
		<p class="lede"><?php esc_html_e( 'Rest Easy, Stay Well.', 'restwell-retreats' ); ?></p>
	  </div>
	</section>

	<?php
	$story_mid_cta_heading = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_story_id, 'story_cta_heading', __( 'See what that means in the bungalow.', 'restwell-retreats' ) )
		: __( 'See what that means in the bungalow.', 'restwell-retreats' );
	$story_mid_cta_intro   = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text(
			$restwell_story_id,
			'story_cta_body',
			__( 'You can look at door widths, hoist details, and room photos before reaching out.', 'restwell-retreats' )
		)
		: __( 'You can look at door widths, hoist details, and room photos before reaching out.', 'restwell-retreats' );
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
