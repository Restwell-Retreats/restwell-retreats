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

$restwell_host_phone = function_exists( 'restwell_get_public_phone_number' )
	? restwell_get_public_phone_number()
	: '01622 809881';
$restwell_host_tel   = function_exists( 'restwell_get_public_phone_tel' )
	? restwell_get_public_phone_tel()
	: '01622809881';
?>


<main id="main-content">
<?php
get_template_part(
	'template-parts/concept/photo-hero',
	null,
	array(
		'heading_id' => 'page-h',
		'heading'    => $restwell_story_heading,
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
		'post_id'    => (int) get_queried_object_id(),
	)
);
?>

	<nav class="subnav" aria-label="On this page">
	  <div class="container">
		<ul class="subnav__list">
		  <li><a href="#origin">The gap</a></li>
		  <li><a href="#month">Four weeks</a></li>
		  <li><a href="#host">Who runs Restwell</a></li>
		  <li><a href="#shaped">Built around real stays</a></li>
		  <li><a href="#next">What's next</a></li>
		</ul>
	  </div>
	</nav>

	<section class="section-y band-white" id="origin" aria-labelledby="origin-h">
	  <div class="container split">
		<div>
		  <header class="section-head section-head--tight">
			<p class="eyebrow">The gap</p>
			<h2 id="origin-h">How Restwell started</h2>
			<p class="lede">Continuity of Care Services has been supporting people in their own homes across Kent for years. In that time we lost count of the families who wanted a holiday and couldn’t make one work, not because of money, and not because of the care, but because the houses on offer weren’t honest.</p>
		  </header>
		  <p>Somebody would arrive after a three-hour drive to find a doorway they couldn’t get through. So we bought a bungalow in Whitstable that needed a lot of work, and we adapted it properly. Then we wrote down every measurement, including the ones that aren’t flattering, because that was the whole problem: nobody else had.</p>
		</div>
		<div class="split__media" data-reveal>
				 <img src="<?php echo esc_url( restwell_theme_image_url( 'journey/101-russel-drive-archive.webp' ) ); ?>" alt="The bungalow before renovation, with peeling render and an overgrown front garden" width="900" height="675" loading="lazy" />
		</div>
	  </div>
	</section>

	<section class="section-y band-subtle process" id="month" aria-labelledby="month-h">
	  <div class="container">
		<header class="section-head section-head--center process__head">
		  <p class="eyebrow">The build</p>
		  <h2 id="month-h">How the bungalow was built</h2>
		  <p class="lede">Family, friends, and three specialist teams did the work. Occupational therapists at Kent Community Health NHS Trust advised on the bedroom and wet room before a guest ever stayed.</p>
		</header>
		<div class="process__layout">
		  <div class="process__media" data-reveal>
			<img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/EX-1-LS.jpg' ) ); ?>" alt="The adapted bungalow as it is now, with a level driveway and front garden" width="900" height="1200" loading="lazy" />
		  </div>
		  <ol class="process-list">
			<li>
			  <span class="process-list__index" aria-hidden="true">01</span>
			  <div class="process-list__body">
				<h3><?php esc_html_e( 'Early March', 'restwell-retreats' ); ?></h3>
				<p><?php esc_html_e( 'We got the keys. The bungalow needed more than a lick of paint.', 'restwell-retreats' ); ?></p>
			  </div>
			</li>
			<li>
			  <span class="process-list__index" aria-hidden="true">02</span>
			  <div class="process-list__body">
				<h3><?php esc_html_e( 'The specialists', 'restwell-retreats' ); ?></h3>
				<p>
					<?php esc_html_e( 'The accessible bedroom and wet room were built by', 'restwell-retreats' ); ?>
					<a class="text-link" href="https://www.carespaces.co.uk/" target="_blank" rel="noopener noreferrer">Care Spaces by Wealden Rehab<span class="sr-only"><?php esc_html_e( ' (opens in new tab)', 'restwell-retreats' ); ?></span></a>
					<?php esc_html_e( 'and', 'restwell-retreats' ); ?>
					<a class="text-link" href="https://thorcarpenter.co.uk/" target="_blank" rel="noopener noreferrer">Thor Carpentry<span class="sr-only"><?php esc_html_e( ' (opens in new tab)', 'restwell-retreats' ); ?></span></a><?php esc_html_e( ', with the occupational therapists’ advice. Family and friends filled the rest.', 'restwell-retreats' ); ?>
				</p>
			  </div>
			</li>
			<li>
			  <span class="process-list__index" aria-hidden="true">03</span>
			  <div class="process-list__body">
				<h3><?php esc_html_e( 'Four weeks later', 'restwell-retreats' ); ?></h3>
				<p><?php esc_html_e( 'The bungalow was ready. The millimetres went on the Accessibility page, not into a brochure line.', 'restwell-retreats' ); ?></p>
			  </div>
			</li>
		  </ol>
		</div>
	  </div>
	</section>

	<section class="section-y band-white" id="host" aria-labelledby="host-h">
	  <div class="container">
		<header class="section-head section-head--tight">
		  <p class="eyebrow">Who runs Restwell</p>
		  <h2 id="host-h">Victoria Walker</h2>
		  <p class="lede">Victoria owns Restwell Retreats, a private adapted bungalow in Whitstable. She is the CQC registered manager of sister company Continuity of Care Services. Restwell is not a registered care provider; Continuity’s CQC rating of Good is theirs.</p>
		</header>
		<dl class="comparison-list">
		  <div class="comparison-list__item">
			<dt><?php esc_html_e( 'Restwell', 'restwell-retreats' ); ?></dt>
			<dd><?php esc_html_e( 'The house. A private adapted bungalow, not a care home or respite centre. Separate invoice from any care.', 'restwell-retreats' ); ?></dd>
		  </div>
		  <div class="comparison-list__item">
			<dt><?php esc_html_e( 'Continuity of Care Services', 'restwell-retreats' ); ?></dt>
			<dd>
				<?php esc_html_e( 'Optional home care during a stay, invoiced separately. Victoria is their registered manager.', 'restwell-retreats' ); ?>
			</dd>
		  </div>
		  <div class="comparison-list__item">
			<dt><?php esc_html_e( 'Same conversation', 'restwell-retreats' ); ?></dt>
			<dd>
				<?php esc_html_e( 'One office, one number. You won’t be handed to a different team.', 'restwell-retreats' ); ?>
				<a class="text-link" href="<?php echo esc_url( 'tel:' . $restwell_host_tel ); ?>"><?php echo esc_html( $restwell_host_phone ); ?></a>
			</dd>
		  </div>
		</dl>
		<div class="care-page__trust">
		  <div class="care__foot-copy">
			<p class="care__note"><?php esc_html_e( 'The CQC rating belongs to Continuity. Read the published report yourself rather than take our word for it.', 'restwell-retreats' ); ?></p>
			<a class="text-link" href="https://www.cqc.org.uk/location/1-2624556588" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Read Continuity’s CQC profile', 'restwell-retreats' ); ?><span class="sr-only"><?php esc_html_e( ' (opens in new tab)', 'restwell-retreats' ); ?></span></a>
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

	<section class="section-y band-subtle" id="shaped" aria-labelledby="shaped-h">
	  <div class="container split split--flip">
		<div>
		  <header class="section-head section-head--tight">
			<p class="eyebrow">Shaped by real needs</p>
			<h2 id="shaped-h">Designed with the people who’d actually stay</h2>
			<p class="lede">The layout and kit were shaped by real people, not planned on paper. Individuals with muscular dystrophy, cerebral palsy, and those recovering from strokes told us what mattered for transfers, what got in the way, and what “accessible” meant for them.</p>
		  </header>
		  <p>That’s why the <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'accessibility' ) ); ?>">Accessibility page</a> lists exact measurements in millimetres, so you can check the fit yourself before you book.</p>
		</div>
		<div class="split__media" data-reveal>
		  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/WR-1-LS.jpg' ) ); ?>" alt="Level-access wet room with grab rails" width="900" height="675" loading="lazy" />
		</div>
	  </div>
	</section>

	<section class="section-y band-teal" id="specialists" aria-labelledby="specialists-h">
	  <div class="container">
		<div class="split">
		  <div class="band-teal__stack">
			<p class="eyebrow eyebrow--on-dark">Built with specialists</p>
			<h2 id="specialists-h">Occupational therapists, not guesswork</h2>
			<p class="lede">The companies we worked with understood the brief from the start: the kit has to work for a genuine range of needs, rather than one imagined average guest. Continuity of Care Services takes the same approach if you want support during your stay. The CQC rating of Good is theirs, not Restwell’s.</p>
			<div class="band-teal__actions">
			  <a class="btn btn-gold" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'accessibility' ) ); ?>">Read the access specs</a>
			  <a class="btn btn-outline-light" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'the-property' ) ); ?>">Tour the property</a>
			</div>
		  </div>
		  <div class="split__media" data-reveal>
			<img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/BD2-6-LS.jpg' ) ); ?>" alt="Amico ceiling track hoist over the profiling bed" width="900" height="675" loading="lazy" />
		  </div>
		</div>
	  </div>
	</section>

	<section class="section-y band-white" aria-labelledby="quote-h">
	  <div class="container">
		<h2 id="quote-h" class="sr-only">What a guest wrote after staying</h2>
		<figure class="pull-quote">
		  <span class="pull-quote__mark" aria-hidden="true">&ldquo;</span>
		  <blockquote class="pull-quote__text">it truly amazes me, just how much work has gone into this &ldquo;home from home&rdquo; literally everything you may require, is provided.. I will most definitely be back.. 10/10 from me, as there was NOTHING i needed to ask for, as Restwell Retreats had catered for it all already</blockquote>
		  <figcaption class="pull-quote__cite"><cite>M.P.</cite><span class="pull-quote__role">Wheelchair user &middot; Google review</span></figcaption>
		</figure>
	  </div>
	</section>

	<section class="section-y band-subtle" id="next" aria-labelledby="next-h">
	  <div class="container">
		<header class="section-head section-head--tight">
		  <p class="eyebrow">What’s next</p>
		  <h2 id="next-h">One bungalow so far</h2>
		  <p class="lede">The next question people usually ask, once they know it works, is whether there’ll be more places like this. We don’t have news yet. If there is a second bungalow, it’ll be built the same way this one was: around the people who’ll actually stay, not around guesswork.</p>
		</header>
		<p class="lede"><?php esc_html_e( 'Rest Easy, Stay Well.', 'restwell-retreats' ); ?></p>
	  </div>
	</section>

	<section class="mid-cta mid-cta--plain section-y--cta" aria-labelledby="mid-cta-h">
	  <div class="mid-cta__media" aria-hidden="true"></div>
	  <div class="mid-cta__inner">
		<h2 id="mid-cta-h">See what that means in the bungalow.</h2>
		<p>You can look at door widths, hoist details, and room photos before reaching out.</p>
		<div class="mid-cta__btns">
		  <a class="btn btn-gold" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'enquire' ) ); ?>">Enquire Now</a>
		  <a class="btn btn-outline-light" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'the-property' ) ); ?>">Tour the property</a>
		</div>
	  </div>
	</section>

</main>

<?php
get_footer();
