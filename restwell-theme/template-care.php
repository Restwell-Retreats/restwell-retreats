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
		'Continuity of Care Services can provide home care inside the bungalow while you’re staying here. They’re our sister company, rated Good by the CQC, and they can be arranged on the same enquiry as the house. Victoria Walker owns Restwell and is Continuity’s registered manager. Restwell is the accommodation; Continuity provide and invoice the care.'
	)
	: 'Continuity of Care Services can provide home care inside the bungalow while you’re staying here. They’re our sister company, rated Good by the CQC, and they can be arranged on the same enquiry as the house. Victoria Walker owns Restwell and is Continuity’s registered manager. Restwell is the accommodation; Continuity provide and invoice the care.';
?>


<main id="main-content">
<?php
get_template_part(
	'template-parts/concept/photo-hero',
	null,
	array(
		'heading_id' => 'page-h',
		'heading'    => $restwell_care_heading,
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
		  <p class="eyebrow">Sister company</p>
		  <h2 id="sister-company-h">One conversation if you need both the bungalow and care</h2>
		  <p class="lede">Victoria Walker owns Restwell and is Continuity’s CQC registered manager. That’s why one call can cover the house and the care, without a handover to somebody else.</p>
		</header>
		<dl class="comparison-list">
		  <div class="comparison-list__item">
			<dt>Optional, not automatic</dt>
			<dd>We only introduce Continuity if you ask. Care is never forced into the bungalow rate.</dd>
		  </div>
		  <div class="comparison-list__item">
			<dt>Ask when you enquire</dt>
			<dd>Dates, access needs and care can sit in one conversation on 01622 809881.</dd>
		  </div>
		  <div class="comparison-list__item">
			<dt>Bring your own team</dt>
			<dd>Familiar carers are welcome; the layout works with visiting Continuity staff or your own rota.</dd>
		  </div>
		</dl>
		<div class="care-page__trust">
		  <div class="care__foot-copy">
			<p class="care__note">We add nothing until you agree the support package.</p>
			<a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'pricing' ) . '#care-rates' ); ?>">See care guide rates</a>
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
		  <p class="eyebrow">Support options</p>
		  <h2 id="what-we-arrange-h">What support looks like</h2>
		</header>
		<ul class="persona-list" role="list">
		  <li class="persona-list__item">
			<span class="icon-circle" aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false"><path d="M12 20.5s-7.5-4.6-9.3-9C1.4 8 3 5 6.2 5c2.1 0 4 1.3 5.8 3.8C13.8 6.3 15.7 5 17.8 5 21 5 22.6 8 21.3 11.5c-1.8 4.4-9.3 9-9.3 9z" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
			<div>
			  <h3>Personal care</h3>
			  <p>Support with washing, dressing and daily routines on your schedule.</p>
			</div>
		  </li>
		  <li class="persona-list__item">
			<span class="icon-circle" aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false"><circle cx="12" cy="12" r="8" fill="none" stroke="currentColor" stroke-width="1.6"/><path d="M12 7.5V12l3.2 2" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
			<div>
			  <h3>Visiting care</h3>
			  <p>Short daytime visits, or support for a promenade or town trip.</p>
			</div>
		  </li>
		  <li class="persona-list__item">
			<span class="icon-circle" aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false"><path d="M15.8 3.6a8.4 8.4 0 1 0 4.9 15.2A8.4 8.4 0 0 1 15.8 3.6z" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
			<div>
			  <h3>Overnight cover</h3>
			  <p>Sleep-in or waking night support when daytime visits are not enough.</p>
			</div>
		  </li>
		  <li class="persona-list__item">
			<span class="icon-circle" aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false"><path d="M12 3v18M8 7l4-4 4 4M8 17l4 4 4-4" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
			<div>
			  <h3>Mobility and hoisting</h3>
			  <p>Transfers with trained carers, using the ceiling track and wet-room kit already in the house.</p>
			</div>
		  </li>
		</ul>
	  </div>
	</section>

	<section class="section-y band-white" id="bring-your-own-carer" aria-labelledby="bring-your-own-carer-h">
	  <div class="container">
		<header class="section-head section-head--tight">
		  <p class="eyebrow">Your own team</p>
		  <h2 id="bring-your-own-carer-h">Bringing your own carer</h2>
		</header>
		<dl class="comparison-list">
		  <div class="comparison-list__item">
			<dt>No extra fee</dt>
			<dd>Bring your own carer or PA at no extra charge; the bungalow rate is the same either way.</dd>
		  </div>
		  <div class="comparison-list__item">
			<dt>Separate sleeping space</dt>
			<dd>The second double bedroom, or the conservatory’s double sofa bed, keeps your carer’s sleeping space away from yours.</dd>
		  </div>
		  <div class="comparison-list__item">
			<dt>Room to park</dt>
			<dd>The driveway holds two cars, so a carer’s vehicle can park alongside yours.</dd>
		  </div>
		</dl>
	  </div>
	</section>

	<section class="section-y band-subtle" id="how-care-works" aria-labelledby="how-care-works-h">
	  <div class="container">
		<header class="section-head section-head--tight">
		  <p class="eyebrow">Getting started</p>
		  <h2 id="how-care-works-h">How care is arranged</h2>
		  <p class="lede">This is the care conversation specifically; see <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'how-it-works' ) ); ?>">How It Works</a> for the full booking journey from enquiry to arrival.</p>
		</header>
		<ol class="payment-steps">
		  <li class="payment-steps__item">
			<span class="payment-steps__index" aria-hidden="true">01</span>
			<div class="payment-steps__body">
			  <h3>Enquire as usual</h3>
			  <p>Share dates, access needs, and any support you think would help. Call 01622 809881 or use the enquire form. No separate care booking maze.</p>
			</div>
		  </li>
		  <li class="payment-steps__item">
			<span class="payment-steps__index" aria-hidden="true">02</span>
			<div class="payment-steps__body">
			  <h3>Agree tasks and hours</h3>
			  <p>If care is needed, Continuity confirms what is possible and what it costs. Many packages settle on the first call; a short follow-up covers overnight or complex rotas.</p>
			</div>
		  </li>
		  <li class="payment-steps__item">
			<span class="payment-steps__index" aria-hidden="true">03</span>
			<div class="payment-steps__body">
			  <h3>Guide rates, then your figure</h3>
			  <p>Guide rates live on <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'pricing' ) . '#care-rates' ); ?>">Pricing</a>. Continuity quotes your care cost once hours and tasks are agreed.</p>
			</div>
		  </li>
		</ol>
	  </div>
	</section>

	<section class="section-y band-white" id="cqc-regulated" aria-labelledby="cqc-regulated-h">
	  <div class="container">
		<header class="section-head section-head--tight">
		  <p class="eyebrow">Regulation</p>
		  <h2 id="cqc-regulated-h">What CQC-regulated means</h2>
		</header>
		<div class="prose">
		  <p>The Care Quality Commission (CQC) inspects and rates health and social care providers in England against standards of safety, effectiveness and leadership. Continuity of Care Services holds a CQC rating of Good; Victoria Walker, who owns Restwell, is Continuity’s registered manager. Read the published report yourself rather than take our word for it.</p>
		  <p>Restwell is the accommodation, not the regulated care provider. When care is arranged during your stay, Continuity of Care Services delivers it under that CQC registration: the accountability of a regulated provider, not an informal or unregistered introduction.</p>
		  <p><a href="https://www.cqc.org.uk/location/1-2624556588" class="text-link" target="_blank" rel="noopener noreferrer">Read the CQC inspection profile<span class="sr-only"> (opens in new tab)</span></a></p>
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
		  <p class="eyebrow">For professionals</p>
		  <h2 id="for-professionals-h">For OTs, case managers and commissioners</h2>
		  <p class="lede">Restwell and Continuity can support a funded short break with care alongside it: here’s what each side provides. See <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'who-its-for' ) ); ?>">Who It’s For</a> for guest, carer and professional-referrer suitability at a glance.</p>
		</header>
		<dl class="comparison-list comparison-list--2">
		  <div class="comparison-list__item">
			<dt>Access evidence</dt>
			<dd>Published door widths, hoist and wet-room specs; we’ll measure unpublished clearances on request. See <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'accessibility' ) ); ?>">Accessibility</a>.</dd>
		  </div>
		  <div class="comparison-list__item">
			<dt>Care documentation</dt>
			<dd>Continuity confirms the care plan and cost once hours and tasks are agreed: the detail a funding panel needs to approve a break.</dd>
		  </div>
		  <div class="comparison-list__item">
			<dt>Funding routes</dt>
			<dd>Care Act short breaks, direct payments, personal health budgets or NHS CHC: the bungalow rate is the same whoever we invoice. See <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'resources' ) ); ?>">Funding &amp; Support</a>.</dd>
		  </div>
		  <div class="comparison-list__item">
			<dt>One number for both</dt>
			<dd>Restwell and Continuity share 01622 809881, so access needs and a care conversation can happen in one call.</dd>
		  </div>
		</dl>
	  </div>
	</section>

	<section class="faq section-y band-white" id="faq" aria-labelledby="faq-h">
	  <div class="container">
		<div class="faq__layout">
		  <header class="faq__intro">
			<p class="eyebrow">Care questions</p>
			<h2 id="faq-h">Optional care FAQ</h2>
			<p class="lede">Whether care is required, who Continuity is, and where guide rates live.</p>
		  </header>
		  <div class="faq-list faq-list--split" data-faq-accordion>
			<div class="faq-list__col">
			<div class="faq-item is-open">
			  <button type="button" class="faq-item__trigger" aria-expanded="true" id="care-q1" aria-controls="care-q1-a">
				<span>Do I have to book care?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="care-q1-a" role="region" aria-labelledby="care-q1">
				<p>No. Many guests book the house as a self-catering holiday and need no additional support. Continuity care is optional.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="care-q2" aria-controls="care-q2-a">
				<span>Is Restwell a care home?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="care-q2-a" role="region" aria-labelledby="care-q2" hidden>
				<p>No. Restwell is a private holiday bungalow. Continuity of Care Services (our sister company) is the CQC-regulated provider if you want professional care during your stay.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="care-q3" aria-controls="care-q3-a">
				<span>Do I book care separately?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="care-q3-a" role="region" aria-labelledby="care-q3" hidden>
				<p>No. Ask when you enquire about the bungalow. Restwell and Continuity share 01622 809881, so house and care can start in one conversation when you want both.</p>
			  </div>
			</div>
			</div>
			<div class="faq-list__col">
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="care-q4" aria-controls="care-q4-a">
				<span>Can I bring my own carers?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="care-q4-a" role="region" aria-labelledby="care-q4" hidden>
				<p>Yes. The layout supports familiar routines, with separate sleeping and space to assist. Tell us your party layout when you enquire.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="care-q5" aria-controls="care-q5-a">
				<span>Where do I see guide rates?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="care-q5-a" role="region" aria-labelledby="care-q5" hidden>
				<p>On the <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'pricing' ) . '#care-rates' ); ?>">Pricing</a> page. They are Continuity guide rates only. Continuity quotes your care cost once hours and tasks are agreed.</p>
			  </div>
			</div>
			</div>
		  </div>
		</div>
	  </div>
	</section>

	<section class="mid-cta mid-cta--plain section-y--cta" aria-labelledby="mid-cta-h">
	  <div class="mid-cta__media" aria-hidden="true"></div>
	  <div class="mid-cta__inner">
		<h2 id="mid-cta-h">Ask about care with your enquiry</h2>
		<p>Share your dates and what support would help.</p>
		<div class="mid-cta__btns">
		  <a class="btn btn-gold" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'enquire' ) ); ?>">Enquire Now</a>
		  <a class="btn btn-outline-light" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'pricing' ) . '#care-rates' ); ?>">See guide rates</a>
		</div>
	  </div>
	</section>

</main>

<?php
get_footer();
