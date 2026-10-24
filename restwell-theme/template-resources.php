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
$restwell_res_id = (int) get_queried_object_id();

$res_txt = static function ( $key, $fallback ) use ( $restwell_res_id ) {
	return function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_res_id, $key, $fallback )
		: $fallback;
};

$restwell_res_heading = $res_txt( 'res_heading', 'Grants and funding for disabled holidays' );
$restwell_res_intro   = $res_txt(
	'res_intro',
	'A stay can be paid for by you, a council, the NHS or a grant body. Here’s how each route usually works, and what to ask before you book.'
);

$res_chc_heading = $res_txt( 'res_chc_heading', 'Continuing Healthcare and personal health budgets' );
$res_chc_body    = $res_txt(
	'res_chc_body',
	'Continuing Healthcare is there to pay for your care, not the holiday itself. Some teams will keep paying your usual hours while you’re away, if they agree it in writing. The bungalow rent is rarely part of that.'
);

$res_grants_heading = $res_txt( 'res_grants_heading', 'Grants and key contacts' );
$res_grants_body    = $res_txt(
	'res_grants_body',
	'These are the organisations people actually use. We can’t say yes on their behalf, but we can send whatever paperwork they ask for.'
);
// Plain lede field: if legacy meta still holds markup, fall back to the clean default.
if ( false !== strpos( (string) $res_grants_body, '<' ) ) {
	$res_grants_body = 'These are the organisations people actually use. We can’t say yes on their behalf, but we can send whatever paperwork they ask for.';
}

$res_contacts_heading = $res_txt( 'res_contacts_heading', 'Who to call' );
$res_contacts_body    = $res_txt( 'res_contacts_body', '' );

$res_complaints_body = $res_txt(
	'res_complaints_body',
	'You can ask for a review, and Scope and Beacon can advise. For a council decision, ask your council first, then the Local Government and Social Care Ombudsman. For NHS Continuing Healthcare, use your ICB’s appeals process, then the Parliamentary and Health Service Ombudsman.'
);
if ( false !== strpos( (string) $res_complaints_body, '<' ) ) {
	$res_complaints_body = 'You can ask for a review, and Scope and Beacon can advise. For a council decision, ask your council first, then the Local Government and Social Care Ombudsman. For NHS Continuing Healthcare, use your ICB’s appeals process, then the Parliamentary and Health Service Ombudsman.';
}

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
		/* Force a coastal hero (a seeded woodland attachment must not override). A
		   daylight seafront since 13 Oct 2026: the sunset huts went near-black
		   under the scrim. */
		'image_url'  => function_exists( 'restwell_theme_image_url' )
			? restwell_theme_image_url( 'bungalow/WHIT-SEAFRONT-4-LS.jpg' )
			: '',
		'image_alt'  => __( 'Beach huts along the green Tankerton slopes above the sea', 'restwell-retreats' ),
	)
);
?>

	<nav class="subnav" aria-label="On this page" data-toc>
	  <div class="container">
		<ul class="subnav__list">
		  <li><a href="#routes">Routes</a></li>
		  <li><a href="#directory">Grants</a></li>
		  <li><a href="#help">What we send</a></li>
		  <li><a href="#faq">FAQ</a></li>
		</ul>
	  </div>
	</nav>

	<section class="section-y band-white" id="routes" aria-labelledby="routes-h">
	  <div class="container">
		<header class="section-head">
		  <p class="eyebrow">What each route usually pays</p>
		  <h2 id="routes-h">Where to start with your coordinator</h2>
		  <p class="lede">This is the usual pattern for each route, but your own coordinator has the last word.</p>
		</header>

		<?php // M-Design's tabs over a deep-teal card (22 Oct 2026): each route's words in white, its photo on the right. It was open text on the white band. ?>
		<div class="funding-tabs" data-tabs>
		<div class="funding-tabs__list" role="tablist" aria-label="<?php esc_attr_e( 'Funding routes', 'restwell-retreats' ); ?>" hidden>
		  <button type="button" role="tab" id="route-tab-1" aria-controls="local-authority" aria-selected="true"><?php esc_html_e( 'Care Act', 'restwell-retreats' ); ?></button>
		  <button type="button" role="tab" id="route-tab-2" aria-controls="nhs" aria-selected="false" tabindex="-1"><?php esc_html_e( 'NHS', 'restwell-retreats' ); ?></button>
		  <button type="button" role="tab" id="route-tab-3" aria-controls="private" aria-selected="false" tabindex="-1"><?php esc_html_e( 'Grants and self-pay', 'restwell-retreats' ); ?></button>
		</div>
		<div class="funding-routes">
		  <article class="funding-route" id="local-authority">
			<div class="funding-route__words">
				<div class="funding-route__copy">
				  <p class="eyebrow">Care Act</p>
				  <h3>Direct payments and personal budgets</h3>
				  <p>If a short break would meet needs in your support plan, a direct payment can usually help. Councils shouldn’t limit direct payments without good reason, but each sets its own rules. Whether it covers the bungalow depends on your plan, so ask before you book.</p>
				</div>
				<div class="cover-prose">
				  <p><strong>Usually covers</strong> the care hours in your plan while you’re away, and cover for a family carer’s own break. It only covers the bungalow if the plan names it.</p>
				  <p><strong>Usually doesn’t cover</strong> travel, food or days out, or the bungalow unless your support plan names it. A long stay in a care home has different rules.</p>
				</div>
				<p class="cover-split__source">That’s from the <a href="https://www.legislation.gov.uk/ukpga/2014/23/part/1/crossheading/direct-payments/enacted" target="_blank" rel="noopener noreferrer">Care Act 2014<span class="sr-only"> (opens in new tab)</span></a> and how councils write their handbooks. If you live in Kent, start with the number below.</p>
				<div class="funding-route__foot">
				  <p>Kent residents: <a href="tel:03000416161">03000 41 61 61</a></p>
				  <?php if ( ! empty( $restwell_guide_urls['direct-payment-holiday-accommodation'] ) ) : ?>
					<a class="text-link text-link--on-dark" href="<?php echo esc_url( $restwell_guide_urls['direct-payment-holiday-accommodation'] ); ?>"><?php esc_html_e( 'Can I use direct payments for a holiday?', 'restwell-retreats' ); ?></a>
				  <?php endif; ?>
				</div>
			</div>
			<img class="funding-route__photo" src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/BD2-6-LS.jpg' ) ); ?>" alt="" width="2400" height="1500" sizes="(min-width: 900px) 460px, 100vw" loading="lazy" decoding="async" />
		  </article>

		  <article class="funding-route" id="nhs">
			<div class="funding-route__words">
				<div class="funding-route__copy">
				  <p class="eyebrow">NHS</p>
				  <h3><?php echo esc_html( $res_chc_heading ); ?></h3>
				  <p><?php echo esc_html( $res_chc_body ); ?></p>
				</div>
				<div class="cover-prose">
				  <p><strong>Usually covers</strong> the care hours you already have, if your CHC team agrees they can continue while you’re away. A personal health budget, if you have one, can also pay for care in a place that suits you.</p>
				  <p><strong>Usually doesn’t cover</strong> the holiday itself, like travel, food or the bungalow. Nor does it add hours just because you’re away.</p>
				</div>
				<p class="cover-split__source">That’s from the <a href="https://www.gov.uk/government/publications/nhs-continuing-healthcare-and-nhs-funded-nursing-care-public-information-leaflet/public-information-leaflet-nhs-continuing-healthcare-and-nhs-funded-nursing-care--2" target="_blank" rel="noopener noreferrer">GOV.UK CHC leaflet<span class="sr-only"> (opens in new tab)</span></a> and how ICBs write holiday-support policies. In Kent, Kent &amp; Medway ICB decides.</p>
				<div class="funding-route__foot">
				  <p>Kent &amp; Medway ICB: <a href="mailto:chc@kmicb.nhs.uk">chc@kmicb.nhs.uk</a></p>
				  <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'optional-care' ) ); ?>"><?php esc_html_e( 'How Continuity care is arranged', 'restwell-retreats' ); ?></a>
				</div>
			</div>
			<img class="funding-route__photo" src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/WR-2-LS.jpg' ) ); ?>" alt="" width="2400" height="1500" sizes="(min-width: 900px) 460px, 100vw" loading="lazy" decoding="async" />
		  </article>

		  <article class="funding-route" id="private">
			<div class="funding-route__words">
				<div class="funding-route__copy">
				  <p class="eyebrow">Grants and self-pay</p>
				  <h3>Charity awards, or you pay Restwell</h3>
				  <p>You can book and pay Restwell yourselves, or put a charity award toward the stay. Grants are usually a contribution rather than the whole week, so read the letter before you lock the dates.</p>
				</div>
				<div class="cover-prose">
				  <p><strong>Usually covers</strong> part of the holiday, like a Revitalise grant of about £500. The Respite Association pays for a cover carer instead, at about £450 on average.</p>
				  <p><strong>Usually doesn’t cover</strong> the whole stay, unless the grant letter says so. The Respite Association pays for the cover carer, not the bungalow. Food, days out and travel aren’t covered either.</p>
				</div>
				<p class="cover-split__source">Revitalise closed its centres in 2024 and now awards grants toward a break of your choice. Ask us for a quote if you need a provisional booking to apply.</p>
				<div class="funding-route__foot">
				  <p><a class="text-link" href="#directory"><?php esc_html_e( 'Grant and advice sites', 'restwell-retreats' ); ?></a></p>
				  <?php if ( ! empty( $restwell_guide_urls['carers-respite-holiday-guide'] ) ) : ?>
					<a class="text-link" href="<?php echo esc_url( $restwell_guide_urls['carers-respite-holiday-guide'] ); ?>"><?php esc_html_e( 'Carer assessment guide', 'restwell-retreats' ); ?></a>
				  <?php endif; ?>
				</div>
			</div>
			<img class="funding-route__photo" src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/WHIT-SEAFRONT-1-LS.jpg' ) ); ?>" alt="" width="2400" height="1500" sizes="(min-width: 900px) 460px, 100vw" loading="lazy" decoding="async" />
		  </article>
		</div>
		</div>
	  </div>
	</section>

	<section class="section-y band-subtle" id="directory" aria-labelledby="directory-h">
	  <div class="container">
		<header class="section-head">
		  <p class="eyebrow">Quick reference</p>
		  <h2 id="directory-h"><?php echo esc_html( $res_grants_heading ); ?></h2>
		  <p class="lede"><?php echo esc_html( $res_grants_body ); ?></p>
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
		  <p class="fund-directory__label"><?php echo esc_html( $res_contacts_heading ); ?></p>
		  <?php if ( '' !== trim( wp_strip_all_tags( $res_contacts_body ) ) ) : ?>
			<div class="prose"><?php echo wp_kses_post( $res_contacts_body ); ?></div>
		  <?php else : ?>
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
				<p>Our sister company, on the same number as Restwell wherever you live</p>
			  </div>
			  <p class="contact-list__action"><a href="tel:01622809881">01622 809881</a></p>
			</li>
		  </ul>
		  <?php endif; ?>
		  <p class="fund-directory__follow"><a class="text-link text-link--standalone" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'pricing' ) . '#payment' ); ?>">How invoicing works on pricing</a></p>
		</div>
		</div>
	  </div>
	</section>

	<section class="section-y band-white" id="help" aria-labelledby="help-h">
	  <div class="container">
		<?php
		// What we send (22 Oct 2026): Pricing's payment panel, mirrored, the three
		// documents on a white panel over the bedroom. It was text rows with icons.
		$res_send_docs = array(
			array(
				'title' => __( 'Written quote at published rates', 'restwell-retreats' ),
				'body'  => __( 'Your nights and the guide total, at the rates on our pricing page.', 'restwell-retreats' ),
			),
			array(
				'title' => __( 'Access statement and equipment list', 'restwell-retreats' ),
				'body'  => __( 'Every measurement and piece of kit, as a PDF for an OT or a funding panel.', 'restwell-retreats' ),
			),
			array(
				'title' => __( 'A care quote from Continuity, if you want care', 'restwell-retreats' ),
				'body'  => __( 'Continuity’s hours and rates, if you’d like care while you stay.', 'restwell-retreats' ),
			),
		);
		?>
		<div class="property__layout property__layout--flip">
		  <div class="property__copy">
			<p class="eyebrow">What we send</p>
			<h2 id="help-h">We’ll send what they usually ask for</h2>
			<p class="lede">Tell us the dates and who’s funding the stay. Continuity can quote care on the same call if you want it.</p>
			<ol class="pay-steps">
			  <?php foreach ( $res_send_docs as $res_send_doc ) : ?>
			  <li>
				<h3><?php echo esc_html( $res_send_doc['title'] ); ?></h3>
				<p><?php echo esc_html( $res_send_doc['body'] ); ?></p>
			  </li>
			  <?php endforeach; ?>
			</ol>
			<p class="pay-note">Dates, access needs, and who to invoice. We’ll wait until the stay is agreed before anyone pays a deposit.</p>
			<p class="property__action"><a class="btn btn-gold" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'enquire' ) ); ?>"><?php esc_html_e( 'Ask for the paperwork', 'restwell-retreats' ); ?></a></p>
		  </div>
		  <img class="property__photo" src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/BD2-2-LS.jpg' ) ); ?>" alt="" width="2400" height="1500" sizes="(min-width: 960px) 760px, 100vw" loading="lazy" decoding="async" />
		</div>
	  </div>
	</section>

	<section class="faq section-y band-subtle" id="faq" aria-labelledby="faq-h">
	  <div class="container">
		<div class="faq__layout">
		  <header class="faq__intro">
			<p class="eyebrow">Common questions</p>
			<h2 id="faq-h">Questions about funding</h2>
			<p class="lede">Get the yes in writing before anyone pays a deposit. We’ll send the quote and the access statement, but the decision is your coordinator’s.</p>
		  </header>
		  <div class="faq-list" data-faq-accordion>
			<div class="faq-item is-open">
			  <button type="button" class="faq-item__trigger" aria-expanded="true" id="res-q1" aria-controls="res-q1-a">
				<span>Can NHS Continuing Healthcare funding be used for a holiday?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="res-q1-a" role="region" aria-labelledby="res-q1">
				<p>It can cover the care hours you’re already assessed for, if your CHC team agrees in writing. It doesn’t pay for the bungalow, travel or food, unless a panel says otherwise. Ask which costs they’ll take, then tell us who to invoice.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="res-q2" aria-controls="res-q2-a">
				<span>Can I get an NHS-funded holiday in the UK?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="res-q2-a" role="region" aria-labelledby="res-q2" hidden>
				<p>There isn’t a general scheme where the NHS pays for holidays. Your assessed care can sometimes continue while you’re away. Work out the house, the travel and the care one at a time, and get each one clear in writing.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="res-q3" aria-controls="res-q3-a">
				<span>Can I use direct payments for a short break or holiday in England?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="res-q3-a" role="region" aria-labelledby="res-q3" hidden>
				<p>Yes, if it fits your support plan, although each council sets its own rules. The bungalow rent is only covered if the plan names it, and food and souvenirs usually aren’t. Check with your social worker before you pay a deposit.</p>
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
				<p>Ask your CHC coordinator which hours carry on while you’re away. When you enquire, Continuity can quote for the care on the same call. We’ll send the access statement.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="res-q6" aria-controls="res-q6-a">
				<span>What if my funding application is refused?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="res-q6-a" role="region" aria-labelledby="res-q6" hidden>
				<p><?php echo esc_html( $res_complaints_body ); ?></p>
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
			'intro'   => __( 'Longer guides on paying for a break, if you want more detail.', 'restwell-retreats' ),
		)
	);
}
?>

	<?php
	$mid_cta_heading = $res_txt( 'res_cta_heading', __( 'Send us your dates and who to invoice.', 'restwell-retreats' ) );
	$mid_cta_intro   = $res_txt(
		'res_cta_body',
		__( 'We’ll reply with a bungalow quote at the published rates and the access statement. If you asked about care, Continuity’s quote comes on the same thread. Just let us know the dates.', 'restwell-retreats' )
	);
	$mid_cta_primary_label = $res_txt( 'res_cta_btn', __( 'Enquire', 'restwell-retreats' ) );
	$mid_cta_primary_url   = $res_txt( 'res_cta_url', restwell_nav_resolve_page_url( 'enquire' ) );

	$mid_cta_secondary_label = __( 'See published rates', 'restwell-retreats' );
	$mid_cta_secondary_url   = restwell_nav_resolve_page_url( 'pricing' );

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
