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
<section class="hero hero--interior" aria-labelledby="page-h">
      <div class="container">
        <div class="hero__content">
          <ol class="breadcrumb"><li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li><li class="breadcrumb__sep" aria-hidden="true">/</li><li aria-current="page">Funding & Support</li></ol>
          <div class="hero__text">
            <h1 id="page-h">Fund an accessible respite holiday</h1>
            <p>Local authority, NHS CHC or private pay: who we invoice can change. The bungalow price does not.</p>
          </div>
        </div>
      </div>
    </section>

    <nav class="subnav" aria-label="On this page">
      <div class="container">
        <ul class="subnav__list">
          <li><a href="#routes">Routes</a></li>
          <li><a href="#directory">Grants &amp; contacts</a></li>
          <li><a href="#help">Paperwork</a></li>
          <li><a href="#faq">FAQ</a></li>
        </ul>
      </div>
    </nav>

    <section class="section-y section-y--compact band-white" id="routes" aria-labelledby="routes-h">
      <div class="container">
        <header class="section-head section-head--tight">
          <p class="eyebrow">Start here</p>
          <h2 id="routes-h">Local authority, NHS CHC, or private pay</h2>
          <p class="lede">Restwell’s price stays the same on every route: only who we invoice changes.</p>
        </header>
        <ul class="card-grid card-grid--3" role="list" data-reveal>
          <li><article class="info-card info-card--route" id="local-authority">
            <div class="info-card__head"><span class="icon-circle" aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false"><path d="M12 3L3 8h18L12 3zM4 21V10M20 21V10M8 10v7M12 10v7M16 10v7M3 21h18" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></span><h3>Local authority</h3></div>
            <p>Ask Kent County Council for a <strong>Carer’s Assessment</strong> and, where relevant, a <strong>Care Needs Assessment</strong>. Direct payments can cover a short break that meets assessed needs.</p>
            <div class="info-card__steps">
              <h4>Next steps</h4>
              <ul class="checklist">
                <li>Call KCC on <a href="tel:03000416161">03000 41 61 61</a></li>
                <li>Ask about direct payments for a short break</li>
                <li>Nominate who Restwell should invoice</li>
              </ul>
            </div>
            <?php if ( ! empty( $restwell_guide_urls['direct-payment-holiday-accommodation'] ) || ! empty( $restwell_guide_urls['personal-budget-short-break-care-act'] ) ) : ?>
            <p class="info-card__more">
              <?php if ( ! empty( $restwell_guide_urls['direct-payment-holiday-accommodation'] ) ) : ?>
                <a class="text-link" href="<?php echo esc_url( $restwell_guide_urls['direct-payment-holiday-accommodation'] ); ?>"><?php esc_html_e( 'Direct payments guide', 'restwell-retreats' ); ?></a>
              <?php endif; ?>
              <?php if ( ! empty( $restwell_guide_urls['direct-payment-holiday-accommodation'] ) && ! empty( $restwell_guide_urls['personal-budget-short-break-care-act'] ) ) : ?>
                <span aria-hidden="true"> · </span>
              <?php endif; ?>
              <?php if ( ! empty( $restwell_guide_urls['personal-budget-short-break-care-act'] ) ) : ?>
                <a class="text-link" href="<?php echo esc_url( $restwell_guide_urls['personal-budget-short-break-care-act'] ); ?>"><?php esc_html_e( 'Care Act personal budgets', 'restwell-retreats' ); ?></a>
              <?php endif; ?>
            </p>
            <?php endif; ?>
          </article></li>
          <li><article class="info-card info-card--route" id="nhs">
            <div class="info-card__head"><span class="icon-circle" aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false"><path d="M3 12h4l2-5 3 10 2-7 1.5 2H21" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></span><h3>NHS / CHC</h3></div>
            <p>Contact Kent &amp; Medway ICB about Continuing Healthcare or a personal health budget. We confirm cover with your funding contact, then invoice the funder before the stay.</p>
            <div class="info-card__steps">
              <h4>Next steps</h4>
              <ul class="checklist">
                <li>Ask whether respite is in the budget</li>
                <li>Share your funding contact when you enquire</li>
                <li>Request Restwell details for the pack</li>
              </ul>
            </div>
            <?php if ( ! empty( $restwell_guide_urls['chc-respite-holiday-accommodation-uk'] ) ) : ?>
            <p class="info-card__more"><a class="text-link" href="<?php echo esc_url( $restwell_guide_urls['chc-respite-holiday-accommodation-uk'] ); ?>"><?php esc_html_e( 'CHC respite & lodging guide', 'restwell-retreats' ); ?></a></p>
            <?php endif; ?>
          </article></li>
          <li><article class="info-card info-card--route" id="private">
            <div class="info-card__head"><span class="icon-circle" aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false"><path d="M3 7.5A1.5 1.5 0 0 1 4.5 6h13A1.5 1.5 0 0 1 19 7.5V9h1.5A1.5 1.5 0 0 1 22 10.5v7A1.5 1.5 0 0 1 20.5 19h-15A2.5 2.5 0 0 1 3 16.5v-9Z" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="17.25" cy="14" r="1" fill="currentColor" stroke="none"/></svg></span><h3>Grants &amp; private</h3></div>
            <p>Book and pay Restwell directly, or combine with a charity award. Eligibility varies, apply early and keep award letters with your enquiry.</p>
            <div class="info-card__steps">
              <h4>Next steps</h4>
              <ul class="checklist">
                <li>Search grants via the links below</li>
                <li>Keep award letters with your enquiry</li>
                <li>Pay deposit to secure dates</li>
              </ul>
            </div>
            <?php if ( ! empty( $restwell_guide_urls['carers-respite-holiday-guide'] ) || ! empty( $restwell_guide_urls['commissioner-checklist-accessible-respite-stay'] ) ) : ?>
            <p class="info-card__more">
              <?php if ( ! empty( $restwell_guide_urls['carers-respite-holiday-guide'] ) ) : ?>
                <a class="text-link" href="<?php echo esc_url( $restwell_guide_urls['carers-respite-holiday-guide'] ); ?>"><?php esc_html_e( 'Carer assessment & respite rights', 'restwell-retreats' ); ?></a>
              <?php endif; ?>
              <?php if ( ! empty( $restwell_guide_urls['carers-respite-holiday-guide'] ) && ! empty( $restwell_guide_urls['commissioner-checklist-accessible-respite-stay'] ) ) : ?>
                <span aria-hidden="true"> · </span>
              <?php endif; ?>
              <?php if ( ! empty( $restwell_guide_urls['commissioner-checklist-accessible-respite-stay'] ) ) : ?>
                <a class="text-link" href="<?php echo esc_url( $restwell_guide_urls['commissioner-checklist-accessible-respite-stay'] ); ?>"><?php esc_html_e( 'Commissioner checklist', 'restwell-retreats' ); ?></a>
              <?php endif; ?>
            </p>
            <?php endif; ?>
            </article></li>
        </ul>
      </div>
    </section>

    <section class="section-y section-y--compact band-subtle" id="directory" aria-labelledby="directory-h">
      <div class="container">
        <header class="section-head section-head--tight">
          <p class="eyebrow">Quick reference</p>
          <h2 id="directory-h">Grants &amp; key contacts</h2>
        </header>
        <div class="fund-directory">
          <div>
            <p class="fund-directory__label">Grant and advice sites</p>
            <ul class="link-list">
              <li><a href="https://carers.org/" target="_blank" rel="noopener noreferrer">Carers Trust<span class="sr-only"> (opens in new tab)</span></a><span>Grants and local carer support</span></li>
              <li><a href="https://www.turn2us.org.uk/" target="_blank" rel="noopener noreferrer">Turn2us<span class="sr-only"> (opens in new tab)</span></a><span>Benefits and grants search</span></li>
              <li><a href="https://www.respiteassociation.org/" target="_blank" rel="noopener noreferrer">Respite Association<span class="sr-only"> (opens in new tab)</span></a><span>Help toward short breaks</span></li>
              <li><a href="https://www.ageuk.org.uk/hernebayandwhitstable/" target="_blank" rel="noopener noreferrer">Age UK Herne Bay &amp; Whitstable<span class="sr-only"> (opens in new tab)</span></a><span>Local advice, on your doorstep</span></li>
            </ul>
          </div>
          <div>
            <p class="fund-directory__label">Who to call</p>
            <ul class="contact-list">
              <li class="contact-list__item">
                <div class="contact-list__org">
                  <h3>Kent County Council</h3>
                  <p>Social care assessments</p>
                </div>
                <p class="contact-list__action"><a href="tel:03000416161">03000 41 61 61</a></p>
              </li>
              <li class="contact-list__item">
                <div class="contact-list__org">
                  <h3>Kent &amp; Medway ICB</h3>
                  <p>Continuing Healthcare</p>
                </div>
                <p class="contact-list__action"><a href="mailto:chc@kmicb.nhs.uk">chc@kmicb.nhs.uk</a></p>
              </li>
            </ul>
            <p class="fund-directory__follow"><a class="text-link" href="<?php echo esc_url(  restwell_nav_resolve_page_url( 'pricing' )  . '#payment' ); ?>">How invoicing works on pricing</a></p>
          </div>
        </div>
      </div>
    </section>

    <section class="section-y band-teal" id="help" aria-labelledby="help-h">
      <div class="container">
        <div class="split">
          <div class="band-teal__stack">
            <p class="eyebrow eyebrow--on-dark">What we can send</p>
            <h2 id="help-h">Quotes, access packs and invoice contacts</h2>
            <p class="lede">Tell us your funding route and paperwork stage; we send what your coordinator usually asks for.</p>
            <ul class="checklist">
              <li>Written quote at published rates</li>
              <li>Access statement and equipment list</li>
              <li>Invoice setup for a nominated funder</li>
            </ul>
            <div class="band-teal__actions">
              <a class="btn btn-gold" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'enquire' ) ); ?>">Enquire Now</a>
              <a class="btn btn-outline-light" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'who-its-for' ) ); ?>">Who it’s for</a>
            </div>
          </div>
          <div class="split__media" data-reveal>
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/bungalow/living-room-2.png' ); ?>" alt="Restwell bungalow living room" width="900" height="675" loading="lazy" />
          </div>
        </div>
      </div>
    </section>
    <section class="faq section-y band-subtle" id="faq" aria-labelledby="faq-h">
      <div class="container">
        <div class="faq__layout">
          <header class="faq__intro">
            <p class="eyebrow">Funding pathways</p>
            <h2 id="faq-h">Funding FAQ</h2>
            <p class="lede">Confirm CHC, direct payments or personal budgets with your coordinator before any deposit.</p>
          </header>
          <div class="faq-list faq-list--split" data-faq-accordion>
            <div class="faq-list__col">
            <div class="faq-item is-open">
              <button type="button" class="faq-item__trigger" aria-expanded="true" id="res-q1" aria-controls="res-q1-a">
                <span>Can NHS Continuing Healthcare funding be used for a holiday?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button>
              <div class="faq-item__panel" id="res-q1-a" role="region" aria-labelledby="res-q1">
                <p>Eligible care hours away from home can be covered if your CHC team agrees in writing; the cottage rent rarely is. Ask which invoice lines they will pay before anyone pays a deposit. Restwell can supply access evidence; funding decisions sit with the commissioner.</p>
              </div>
            </div>
            <div class="faq-item">
              <button type="button" class="faq-item__trigger" aria-expanded="false" id="res-q2" aria-controls="res-q2-a">
                <span>How does NHS CHC holiday funding work?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button>
              <div class="faq-item__panel" id="res-q2-a" role="region" aria-labelledby="res-q2" hidden>
                <p>CHC can cover assessed health and care needs during a short break. Accommodation is usually personal funds, direct payments or LA rules unless a panel explicitly agrees. Contact your CHC coordinator early with Restwell’s specs and care-provider details.</p>
              </div>
            </div>
            <div class="faq-item">
              <button type="button" class="faq-item__trigger" aria-expanded="false" id="res-q3" aria-controls="res-q3-a">
                <span>Can I get an NHS-funded holiday in the UK?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button>
              <div class="faq-item__panel" id="res-q3-a" role="region" aria-labelledby="res-q3" hidden>
                <p>There is no general “NHS pays for holidays” scheme. Assessed care (and some respite frameworks) can continue during a break. Treat lodging, travel and care as separate lines and get each clarified in writing.</p>
              </div>
            </div>
            <div class="faq-item">
              <button type="button" class="faq-item__trigger" aria-expanded="false" id="res-q4" aria-controls="res-q4-a">
                <span>How do I use NHS CHC funding for a short break?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button>
              <div class="faq-item__panel" id="res-q4-a" role="region" aria-labelledby="res-q4" hidden>
                <p>Speak to your CHC coordinator; ask which care tasks they will fund away from the usual address; share risk assessments and provider details; book the property separately with an access pack ready; align invoice contacts so care and lodging don’t get mixed.</p>
              </div>
            </div>
            <div class="faq-item">
              <button type="button" class="faq-item__trigger" aria-expanded="false" id="res-q5" aria-controls="res-q5-a">
                <span>How does Continuing Healthcare relate to a respite break?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button>
              <div class="faq-item__panel" id="res-q5-a" role="region" aria-labelledby="res-q5" hidden>
                <p>CHC-related respite continues eligible care and carer relief under health funding rules. Restwell is the place: a private adapted bungalow. “Respite” and “holiday rent” are not the same budget line. Clarify locally before booking.</p>
              </div>
            </div>
            <div class="faq-item">
              <button type="button" class="faq-item__trigger" aria-expanded="false" id="res-q6" aria-controls="res-q6-a">
                <span>Can I use direct payments for a short break?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button>
              <div class="faq-item__panel" id="res-q6-a" role="region" aria-labelledby="res-q6" hidden>
                <p>Yes when it fits your support plan. Ask your local authority what the payment can buy, what evidence they need, and how to record care vs lodging. Rules vary by council.</p>
              </div>
            </div>
            </div>
            <div class="faq-list__col">
            <div class="faq-item">
              <button type="button" class="faq-item__trigger" aria-expanded="false" id="res-q7" aria-controls="res-q7-a">
                <span>How can direct payments help fund a holiday?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button>
              <div class="faq-item__panel" id="res-q7-a" role="region" aria-labelledby="res-q7" hidden>
                <p>They can support care during a holiday-related package; the cottage rent is not always allowed. Get written clarity before booking. Restwell keeps the same bungalow tariff on every funding route and can invoice as agreed.</p>
              </div>
            </div>
            <div class="faq-item">
              <button type="button" class="faq-item__trigger" aria-expanded="false" id="res-q8" aria-controls="res-q8-a">
                <span>Can a personal budget support a holiday or short break?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button>
              <div class="faq-item__panel" id="res-q8-a" role="region" aria-labelledby="res-q8" hidden>
                <p>A Care Act personal budget (or personal health budget) can support assessed care needs during a break. Separate care costs from general holiday spending, see <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'optional-care' ) ); ?>">how care is arranged and costed</a>. Discuss wording with your social worker; we can supply property and access evidence.</p>
              </div>
            </div>
            <div class="faq-item">
              <button type="button" class="faq-item__trigger" aria-expanded="false" id="res-q9" aria-controls="res-q9-a">
                <span>How do I fund an accessible holiday with a personal budget?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button>
              <div class="faq-item__panel" id="res-q9-a" role="region" aria-labelledby="res-q9" hidden>
                <p>Talk to your social worker or care coordinator; explain outcomes the break supports; bring Restwell’s access specs and draft care hours; ask what the budget can and cannot pay; keep invoices clean.</p>
              </div>
            </div>
            <div class="faq-item">
              <button type="button" class="faq-item__trigger" aria-expanded="false" id="res-q10" aria-controls="res-q10-a">
                <span>Can I use my direct payments to pay for a holiday in England?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button>
              <div class="faq-item__panel" id="res-q10-a" role="region" aria-labelledby="res-q10" hidden>
                <p>Yes if the break meets assessed outcomes and your local authority’s direct payment rules allow it. Check your individual care plan; do not assume rent is covered. Ask in writing before you pay a deposit.</p>
              </div>
            </div>
            <div class="faq-item">
              <button type="button" class="faq-item__trigger" aria-expanded="false" id="res-q11" aria-controls="res-q11-a">
                <span>What if my funding application is refused?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button>
              <div class="faq-item__panel" id="res-q11-a" role="region" aria-labelledby="res-q11" hidden>
                <p>For a local authority decision, appeal to Kent County Council, then the Local Government Ombudsman. For NHS CHC, follow the ICB appeals process, then the Parliamentary and Health Service Ombudsman. Scope and Beacon can advise either way.</p>
              </div>
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
			'intro'   => __( 'Route-specific guides for direct payments, Care Act personal budgets, NHS CHC, carers and commissioners. This page stays the overview.', 'restwell-retreats' ),
		)
	);
}
?>

</main>

<?php
get_footer();
