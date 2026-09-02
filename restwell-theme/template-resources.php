<?php
/**
 * Template Name: Resources
 *
 * Concept port from mockups — Resources.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$restwell_guide_urls = array();
foreach (
	array(
		'direct-payment-holiday-accommodation',
		'personal-budget-short-break-care-act',
		'chc-respite-holiday-accommodation-uk',
		'carers-respite-holiday-guide',
		'commissioner-checklist-accessible-respite-stay',
	) as $restwell_guide_slug
) {
	$restwell_guide_post = get_page_by_path( $restwell_guide_slug, OBJECT, 'post' );
	$restwell_guide_urls[ $restwell_guide_slug ] = ( $restwell_guide_post instanceof WP_Post )
		? (string) get_permalink( $restwell_guide_post )
		: '';
}
?>


<main id="main-content">
<?php
$restwell_res_id      = (int) get_queried_object_id();
$restwell_res_heading = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $restwell_res_id, 'res_heading', 'Paying for a break, without the guesswork' )
	: 'Paying for a break, without the guesswork';
$restwell_res_intro   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $restwell_res_id, 'res_intro', 'Restwell can invoice you directly, a local authority, the NHS, or a grant body, and the bungalow costs the same whoever pays. Home care from Continuity of Care Services is invoiced separately by them. We can’t promise that your funding will cover a holiday. That decision sits with your social worker or case manager.' )
	: 'Restwell can invoice you directly, a local authority, the NHS, or a grant body, and the bungalow costs the same whoever pays. Home care from Continuity of Care Services is invoiced separately by them. We can’t promise that your funding will cover a holiday. That decision sits with your social worker or case manager.';
get_template_part(
	'template-parts/concept/photo-hero',
	null,
	array(
		'heading_id' => 'page-h',
		'heading'    => $restwell_res_heading,
		'intro'      => $restwell_res_intro,
		'crumbs'     => array(
			array(
				'label' => __( 'Home', 'restwell-retreats' ),
				'url'   => home_url( '/' ),
			),
			array(
				'label' => 'Funding & Support',
				'url'   => '',
			),
		),
		'post_id'    => (int) get_queried_object_id(),
		/* Force coastal hospitality hero — seeded woodland attachment must not override. */
		'image_url'  => function_exists( 'restwell_theme_image_url' )
			? restwell_theme_image_url( 'stock/restwell-whitstable-beach-huts-promenade-sunset.jpg' )
			: '',
		'image_alt'  => __( 'Colourful beach huts along Tankerton promenade at sunset, Whitstable', 'restwell-retreats' ),
	)
);
?>

	<nav class="subnav" aria-label="On this page" data-toc>
	  <div class="container">
		<ul class="subnav__list">
		  <li><a href="#basics">How it works</a></li>
		  <li><a href="#routes">Routes</a></li>
		  <li><a href="#directory">Grants</a></li>
		  <li><a href="#help">What we send</a></li>
		  <li><a href="#faq">FAQ</a></li>
		</ul>
	  </div>
	</nav>

	<section class="section-y band-subtle" id="basics" aria-labelledby="basics-h">
	  <div class="container">
		<div class="stat-row stat-row--prose">
		  <dl>
			<div class="stat"><dt class="stat__label">The published bungalow price, whoever is paying</dt><dd class="stat__value">Same rate</dd></div>
			<div class="stat"><dt class="stat__label">We’ll invoice your council, the NHS, a grant body, or you</dt><dd class="stat__value">Your funder</dd></div>
			<div class="stat"><dt class="stat__label">House from Restwell. Care from Continuity. Same phone number.</dt><dd class="stat__value">Two invoices</dd></div>
		  </dl>
		</div>
		<header class="section-head">
		  <p class="eyebrow">How the bills work</p>
		  <h2 id="basics-h">The house and the care can sit on different invoices</h2>
		  <p class="lede">A council or CHC team will often pay for care hours, and not the bungalow, or the other way round. Continuity is our sister company, so you still ring us once.</p>
		</header>
		<div class="invoice-pair">
		  <article class="invoice-card">
			<p class="eyebrow">Restwell</p>
			<h3>The bungalow</h3>
			<p>We’ll invoice whoever you ask us to, at the published rate.</p>
		  </article>
		  <article class="invoice-card">
			<p class="eyebrow">Continuity</p>
			<h3>Optional care</h3>
			<p>If you want care, Continuity quotes the hours. Same number as Restwell.</p>
		  </article>
		</div>
		<p class="invoice-pair__note">Give us a ring on 01622 809881. Dates, access needs, and who should receive which invoice is plenty to start.</p>
	  </div>
	</section>

	<section class="section-y band-white" id="routes" aria-labelledby="routes-h">
	  <div class="container">
		<header class="section-head">
		  <p class="eyebrow">What each route usually pays</p>
		  <h2 id="routes-h">A starting point for the conversation with your coordinator</h2>
		  <p class="lede">We’ve gone through the Care Act, NHS CHC guidance, and the main grant bodies, so you can see the pattern. Your own coordinator still has the last word. Ask us for the paperwork they need, and we’ll send it.</p>
		</header>

		<div class="funding-routes">
		  <article class="funding-route" id="local-authority">
			<div class="funding-route__copy">
			  <p class="eyebrow">Care Act</p>
			  <h3>Direct payments and personal budgets</h3>
			  <p>If a short break would meet needs in your support plan, a direct payment can usually help. Councils aren’t allowed to ban holidays as a blanket rule. Whether the bungalow rent is in depends on what’s written down, so it’s worth asking before you book.</p>
			</div>
			<div class="cover-split">
			  <div class="cover-split__col cover-split__col--yes">
				<h4>Usually covered</h4>
				<ul>
				  <li><span class="cover-split__mark" aria-hidden="true">✓</span> Assessed care hours during the break</li>
				  <li><span class="cover-split__mark" aria-hidden="true">✓</span> Replacement care so an unpaid carer can rest</li>
				  <li><span class="cover-split__mark" aria-hidden="true">✓</span> The bungalow, if it’s written into the plan</li>
				</ul>
			  </div>
			  <div class="cover-split__col cover-split__col--no">
				<h4>Usually not</h4>
				<ul>
				  <li><span class="cover-split__mark" aria-hidden="true">×</span> Travel, food, souvenirs, holiday extras</li>
				  <li><span class="cover-split__mark" aria-hidden="true">×</span> The rent, unless the support plan names it</li>
				  <li><span class="cover-split__mark" aria-hidden="true">×</span> A long stay in a care home (different rules)</li>
				</ul>
			  </div>
			</div>
			<p class="cover-split__source">That’s from the <a href="https://www.legislation.gov.uk/ukpga/2014/23/part/1/crossheading/direct-payments/enacted" target="_blank" rel="noopener noreferrer">Care Act 2014<span class="sr-only"> (opens in new tab)</span></a> and how councils write their handbooks. If you live in Kent, start with the number below.</p>
			<div class="funding-route__foot">
			  <p>Kent residents: <a href="tel:03000416161">03000 41 61 61</a></p>
			  <?php if ( ! empty( $restwell_guide_urls['direct-payment-holiday-accommodation'] ) ) : ?>
				<a class="text-link" href="<?php echo esc_url( $restwell_guide_urls['direct-payment-holiday-accommodation'] ); ?>"><?php esc_html_e( 'Direct payments guide', 'restwell-retreats' ); ?></a>
			  <?php endif; ?>
			</div>
		  </article>

		  <article class="funding-route" id="nhs">
			<div class="funding-route__copy">
			  <p class="eyebrow">NHS</p>
			  <h3>Continuing Healthcare and personal health budgets</h3>
			  <p>Continuing Healthcare is there to pay for your care, not the holiday itself. Some teams will keep paying your usual hours while you’re away, if they agree it in writing. The bungalow rent is rarely part of that, which is why we keep it on a separate invoice.</p>
			</div>
			<div class="cover-split">
			  <div class="cover-split__col cover-split__col--yes">
				<h4>Usually covered</h4>
				<ul>
				  <li><span class="cover-split__mark" aria-hidden="true">✓</span> Your usual care hours, if the team says they continue</li>
				  <li><span class="cover-split__mark" aria-hidden="true">✓</span> A personal health budget, if you’re CHC-eligible and take one</li>
				  <li><span class="cover-split__mark" aria-hidden="true">✓</span> Care away from hospital, in a place that works for you</li>
				</ul>
			  </div>
			  <div class="cover-split__col cover-split__col--no">
				<h4>Usually not</h4>
				<ul>
				  <li><span class="cover-split__mark" aria-hidden="true">×</span> The holiday itself: travel, food, Restwell rent</li>
				  <li><span class="cover-split__mark" aria-hidden="true">×</span> Extra hours just because you’re away from home</li>
				  <li><span class="cover-split__mark" aria-hidden="true">×</span> A scheme where the NHS pays for the holiday (there isn’t one)</li>
				</ul>
			  </div>
			</div>
			<p class="cover-split__source">That’s from the <a href="https://www.gov.uk/government/publications/nhs-continuing-healthcare-and-nhs-funded-nursing-care-public-information-leaflet/public-information-leaflet-nhs-continuing-healthcare-and-nhs-funded-nursing-care--2" target="_blank" rel="noopener noreferrer">GOV.UK CHC leaflet<span class="sr-only"> (opens in new tab)</span></a> and how ICBs write holiday-support policies. In Kent, Kent &amp; Medway ICB decides.</p>
			<div class="funding-route__foot">
			  <p>Kent &amp; Medway ICB: <a href="mailto:chc@kmicb.nhs.uk">chc@kmicb.nhs.uk</a></p>
			  <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'optional-care' ) ); ?>"><?php esc_html_e( 'How Continuity care is arranged', 'restwell-retreats' ); ?></a>
			</div>
		  </article>

		  <article class="funding-route" id="private">
			<div class="funding-route__copy">
			  <p class="eyebrow">Grants and self-pay</p>
			  <h3>Charity awards, or you pay Restwell</h3>
			  <p>You can book and pay Restwell yourselves, or put a charity award toward the stay. Grants are usually a contribution rather than the whole week, so read the letter before you lock the dates. If it only covers part, we can split the invoices.</p>
			</div>
			<div class="cover-split">
			  <div class="cover-split__col cover-split__col--yes">
				<h4>Usually covered</h4>
				<ul>
				  <li><span class="cover-split__mark" aria-hidden="true">✓</span> A contribution toward the holiday itself from Revitalise (typically £500)</li>
				  <li><span class="cover-split__mark" aria-hidden="true">✓</span> A cover carer from Respite Association (average around £450)</li>
				  <li><span class="cover-split__mark" aria-hidden="true">✓</span> Split invoices, if a grant only covers part</li>
				</ul>
			  </div>
			  <div class="cover-split__col cover-split__col--no">
				<h4>Usually not</h4>
				<ul>
				  <li><span class="cover-split__mark" aria-hidden="true">×</span> The whole stay, unless the letter is clear</li>
				  <li><span class="cover-split__mark" aria-hidden="true">×</span> The holiday itself from Respite Association (they pay the cover carer, not the house)</li>
				  <li><span class="cover-split__mark" aria-hidden="true">×</span> Food, entertainment, or travel, unless the letter names them</li>
				</ul>
			  </div>
			</div>
			<p class="cover-split__source">Revitalise closed its centres in 2024 and now awards grants toward a break of your choice, typically £500. Respite Association funds the cover carer, not the house. Ask us for a quote if you need a provisional booking to apply.</p>
			<div class="funding-route__foot">
			  <p><a class="text-link" href="#directory"><?php esc_html_e( 'Grant and advice sites', 'restwell-retreats' ); ?></a></p>
			  <?php if ( ! empty( $restwell_guide_urls['carers-respite-holiday-guide'] ) ) : ?>
				<a class="text-link" href="<?php echo esc_url( $restwell_guide_urls['carers-respite-holiday-guide'] ); ?>"><?php esc_html_e( 'Carer assessment guide', 'restwell-retreats' ); ?></a>
			  <?php endif; ?>
			</div>
		  </article>
		</div>
	  </div>
	</section>

	<section class="section-y section-y--compact band-subtle" id="directory" aria-labelledby="directory-h">
	  <div class="container">
		<header class="section-head">
		  <p class="eyebrow">Quick reference</p>
		  <h2 id="directory-h">Grants and key contacts</h2>
		  <p class="lede">These are the organisations people actually use. We can’t say yes on their behalf, but we can send whatever paperwork they ask for.</p>
		</header>
		<div class="fund-directory">
		<div>
		<p class="fund-directory__label">Grant and advice sites</p>
		<ul class="card-grid" role="list">
		  <li>
			<article class="info-card info-card--flat">
			  <h3><a href="https://revitalise.org.uk/what-we-fund/" target="_blank" rel="noopener noreferrer">Revitalise<span class="sr-only"> (opens in new tab)</span></a></h3>
			  <p>Their holiday centres closed in 2024. They still give grants toward a break of your choosing, typically £500, for disabled adults and carers aged 18+. We’ll send a quote if you need a provisional booking.</p>
			</article>
		  </li>
		  <li>
			<article class="info-card info-card--flat">
			  <h3><a href="https://carers.org/" target="_blank" rel="noopener noreferrer">Carers Trust<span class="sr-only"> (opens in new tab)</span></a></h3>
			  <p>Local carer centres, and grants if there’s a scheme near you. Search by postcode.</p>
			</article>
		  </li>
		  <li>
			<article class="info-card info-card--flat">
			  <h3><a href="https://www.turn2us.org.uk/" target="_blank" rel="noopener noreferrer">Turn2us<span class="sr-only"> (opens in new tab)</span></a></h3>
			  <p>A search for benefits and grants, useful if you’re piecing more than one source together.</p>
			</article>
		  </li>
		  <li>
			<article class="info-card info-card--flat">
			  <h3><a href="https://www.respiteassociation.org/" target="_blank" rel="noopener noreferrer">Respite Association<span class="sr-only"> (opens in new tab)</span></a></h3>
			  <p>They pay a cover carer so you can take a break, not the holiday itself. Average grant around £450.</p>
			</article>
		  </li>
		  <li>
			<article class="info-card info-card--flat">
			  <h3><a href="https://www.ageuk.org.uk/hernebayandwhitstable/" target="_blank" rel="noopener noreferrer">Age UK Herne Bay &amp; Whitstable<span class="sr-only"> (opens in new tab)</span></a></h3>
			  <p>Advice on your doorstep in Herne Bay and Whitstable, including benefits and nearby schemes.</p>
			</article>
		  </li>
		</ul>
		</div>
		<div>
		  <p class="fund-directory__label">Who to call</p>
		  <ul class="contact-list">
			<li class="contact-list__item">
			  <div class="contact-list__org">
				<h3>Kent County Council</h3>
				<p>If you live in Kent: assessments and direct payments</p>
			  </div>
			  <p class="contact-list__action"><a href="tel:03000416161">03000 41 61 61</a></p>
			</li>
			<li class="contact-list__item">
			  <div class="contact-list__org">
				<h3>Kent &amp; Medway ICB</h3>
				<p>If you live in Kent or Medway: Continuing Healthcare</p>
			  </div>
			  <p class="contact-list__action"><a href="mailto:chc@kmicb.nhs.uk">chc@kmicb.nhs.uk</a></p>
			</li>
			<li class="contact-list__item">
			  <div class="contact-list__org">
				<h3>Your own council</h3>
				<p>If you live elsewhere, start with adult social care where you live. We can still invoice them.</p>
			  </div>
			  <p class="contact-list__action"><a href="https://www.gov.uk/find-local-council" target="_blank" rel="noopener noreferrer">Find your council<span class="sr-only"> (opens in new tab)</span></a></p>
			</li>
			<li class="contact-list__item">
			  <div class="contact-list__org">
				<h3>Continuity of Care Services</h3>
				<p>Sister company. Same number as Restwell, wherever you live</p>
			  </div>
			  <p class="contact-list__action"><a href="tel:01622809881">01622 809881</a></p>
			</li>
		  </ul>
		  <p class="fund-directory__follow"><a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'pricing' ) . '#payment' ); ?>">How invoicing works on pricing</a></p>
		</div>
		</div>
	  </div>
	</section>

	<section class="section-y section-y--compact band-white" id="help" aria-labelledby="help-h">
	  <div class="container split">
		<div>
		  <header class="section-head">
			<p class="eyebrow">What we send</p>
			<h2 id="help-h">We’ll send what they usually ask for</h2>
			<p class="lede">Tell us the dates, the funding route, and who should receive which invoice. Continuity can quote care on the same call if you want it.</p>
		  </header>
		  <ul class="checklist">
			<li>Written quote at published rates</li>
			<li>Access statement and equipment list</li>
			<li>Invoices set up for the house, and for Continuity if you want care</li>
		  </ul>
		</div>
		<aside class="download-panel">
		  <h3>We’ll send a quote and the access statement</h3>
		  <p>Dates, access needs, and who to invoice. We’ll wait until the stay is agreed before anyone pays a deposit.</p>
		  <a class="btn btn-gold" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'enquire' ) ); ?>">Enquire Now</a>
		  <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'pricing' ) ); ?>">Published rates</a>
		</aside>
	  </div>
	</section>

	<section class="faq section-y band-subtle" id="faq" aria-labelledby="faq-h">
	  <div class="container">
		<div class="faq__layout">
		  <header class="faq__intro">
			<p class="eyebrow">Common questions</p>
			<h2 id="faq-h">Funding FAQ</h2>
			<p class="lede">It’s worth getting the yes in writing before anyone pays a deposit. We’ll send the quote and the access statement; the decision sits with your coordinator.</p>
		  </header>
		  <div class="faq-list" data-faq-accordion>
			<div class="faq-item is-open">
			  <button type="button" class="faq-item__trigger" aria-expanded="true" id="res-q1" aria-controls="res-q1-a">
				<span>Can NHS Continuing Healthcare funding be used for a holiday?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="res-q1-a" role="region" aria-labelledby="res-q1">
				<p>It can cover the care hours you’re already assessed for, if your CHC team agrees in writing. It doesn’t pay for the holiday itself, so the bungalow, travel and food are usually yours unless a panel says otherwise. Ask them which costs they’ll take, then tell us who to invoice.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="res-q2" aria-controls="res-q2-a">
				<span>Can I get an NHS-funded holiday in the UK?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="res-q2-a" role="region" aria-labelledby="res-q2" hidden>
				<p>There isn’t a general scheme where the NHS pays for holidays. Your assessed care can sometimes continue while you’re away. Treat the house, travel and care as separate costs, and get each one clear in writing.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="res-q3" aria-controls="res-q3-a">
				<span>Can I use direct payments for a short break or holiday in England?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="res-q3-a" role="region" aria-labelledby="res-q3" hidden>
				<p>Yes, if it fits your support plan. Councils can’t ban short breaks as a blanket rule. The bungalow rent is only in if the plan names it, and food and souvenirs usually aren’t. Check with your social worker before you pay a deposit.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="res-q4" aria-controls="res-q4-a">
				<span>Can a personal budget support a holiday or short break?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="res-q4-a" role="region" aria-labelledby="res-q4" hidden>
				<p>A Care Act personal budget can support a short break if that’s an assessed need. Keep general holiday spending off that line, and talk the wording through with your social worker. We can send the access statement to go on the file.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="res-q5" aria-controls="res-q5-a">
				<span>How do I use NHS CHC funding for a short break?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="res-q5-a" role="region" aria-labelledby="res-q5" hidden>
				<p>Speak to your CHC coordinator and ask which hours continue away from home. Enquire with Restwell, and Continuity can quote the care on the same call. We’ll send the access statement; you agree who receives which invoice.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="res-q6" aria-controls="res-q6-a">
				<span>What if my funding application is refused?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="res-q6-a" role="region" aria-labelledby="res-q6" hidden>
				<p>You can ask for a review. For a local authority decision, that’s your council first (Kent County Council if they funded the assessment), then the Local Government Ombudsman. For NHS CHC, follow the ICB appeals process, then the Parliamentary and Health Service Ombudsman. Scope and Beacon can advise either way, and we’re happy to resend the paperwork.</p>
			  </div>
			</div>
		  </div>
		</div>
	  </div>
	</section>

<?php
if ( function_exists( 'restwell_render_pillar_related_guides' ) ) {
	restwell_render_pillar_related_guides(
		'resources',
		array(
			'heading' => __( 'Guides by funding route', 'restwell-retreats' ),
			'intro'   => __( 'Longer guides for direct payments, Care Act personal budgets, NHS CHC, carers and commissioners, if you want to go deeper.', 'restwell-retreats' ),
		)
	);
}
?>

	<section class="mid-cta mid-cta--plain section-y--cta" aria-labelledby="mid-cta-h">
	  <div class="mid-cta__media" aria-hidden="true"></div>
	  <div class="mid-cta__inner">
		<h2 id="mid-cta-h">Send us your dates and who to invoice.</h2>
		<p>We’ll reply with a bungalow quote at the published rates, the access statement, and Continuity care on the same thread if you asked for it. Just let us know the dates.</p>
		<div class="mid-cta__btns">
		  <a class="btn btn-gold" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'enquire' ) ); ?>">Enquire Now</a>
		  <a class="btn btn-outline-light" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'pricing' ) ); ?>">See published rates</a>
		</div>
	  </div>
	</section>

</main>

<?php
get_footer();
