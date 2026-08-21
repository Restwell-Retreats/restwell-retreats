<?php
/**
 * Template Name: Pricing
 *
 * Concept port from mockups — Pricing.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>


<main id="main-content">
<section class="hero hero--interior" aria-labelledby="page-h">
      <div class="container">
        <div class="hero__content">
          <ol class="breadcrumb"><li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li><li class="breadcrumb__sep" aria-hidden="true">/</li><li aria-current="page">Pricing</li></ol>
          <div class="hero__text">
            <h1 id="page-h">What a stay costs</h1>
            <p>Our rates include the entire bungalow. You can add care from Continuity if you need support.</p>
          </div>
        </div>
      </div>
    </section>

    <nav class="subnav" aria-label="On this page" data-toc>
      <div class="container">
        <ul class="subnav__list">
          <li><a href="#rates">Rates</a></li>
          <li><a href="#payment">Payment</a></li>
          <li><a href="#care-rates">Optional care</a></li>
          <li><a href="#faq">FAQ</a></li>
        </ul>
      </div>
    </nav>

    <section class="section-y band-white" id="rates" aria-labelledby="rates-h">
      <div class="container">
        <header class="section-head">
          <p class="eyebrow">Bungalow rates</p>
          <h2 id="rates-h">Published bungalow rates</h2>
          <p class="lede">The bungalow sleeps five people. Prices vary for midweek (Monday to Thursday) and weekend (Friday to Sunday) nights. Care is optional and has a separate charge.</p>
        </header>
        <div class="rates-block">
          <div class="rates-panel">
            <table class="data-table data-table--rates">
              <caption class="sr-only">Bungalow rates by stay type and season</caption>
              <thead>
                <tr>
                  <th scope="col">Stay type</th>
                  <th scope="col">Off-peak</th>
                  <th scope="col">Peak</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">Full week <span class="data-table__hint">(7 nights)</span></th>
                  <td class="is-price" data-label="Off-peak">£1,300</td>
                  <td class="is-price" data-label="Peak">£1,400</td>
                </tr>
                <tr>
                  <th scope="row">Weekend night <span class="data-table__hint">(Fri–Sun)</span></th>
                  <td class="is-price" data-label="Off-peak">£235</td>
                  <td class="is-price" data-label="Peak">£255</td>
                </tr>
                <tr>
                  <th scope="row">Midweek night <span class="data-table__hint">(Mon–Thu)</span></th>
                  <td class="is-price" data-label="Off-peak">£185</td>
                  <td class="is-price" data-label="Peak">£200</td>
                </tr>
              </tbody>
            </table>
            <div class="rates-examples">
              <div class="rates-examples__head">
                <h3 class="rates-examples__title">Example stays</h3>
                <p class="rates-examples__cols" aria-hidden="true"><span>Off-peak</span><span>Peak</span></p>
              </div>
              <ul class="rates-examples__list">
                <li>
                  <div class="rates-examples__copy">
                    <span class="rates-examples__name">Weekend</span>
                    <span class="rates-examples__meta">(Fri–Sun, 3 nights)</span>
                  </div>
                  <span class="rates-examples__prices">
                    <span class="is-price" data-label="Off-peak">£705</span>
                    <span class="is-price" data-label="Peak">£765</span>
                  </span>
                </li>
                <li>
                  <div class="rates-examples__copy">
                    <span class="rates-examples__name">Midweek</span>
                    <span class="rates-examples__meta">(Mon–Thu, 4 nights)</span>
                  </div>
                  <span class="rates-examples__prices">
                    <span class="is-price" data-label="Off-peak">£740</span>
                    <span class="is-price" data-label="Peak">£800</span>
                  </span>
                </li>
                <li>
                  <div class="rates-examples__copy">
                    <span class="rates-examples__name">Long weekend</span>
                    <span class="rates-examples__meta">(Fri–Mon, 4 nights)</span>
                  </div>
                  <span class="rates-examples__prices">
                    <span class="is-price" data-label="Off-peak">£890</span>
                    <span class="is-price" data-label="Peak">£965</span>
                  </span>
                </li>
              </ul>
            </div>
          </div>
          <p class="rates-follow">You can find room details and capacity on the <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'the-property' ) ); ?>">property page</a>. Equipment and measurements are listed in the <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'accessibility' ) ); ?>">access details</a>.</p>
          <details class="peak-dates" data-peak-dates>
            <summary class="peak-dates__summary">
              <h3 id="peak-dates-h" class="peak-dates__summary-title">Peak season dates</h3>
              <span class="peak-dates__summary-hint">All other dates are off-peak</span>
            </summary>
            <ul class="peak-dates__list">
              <li><span class="peak-dates__label">Summer 2026</span><span class="peak-dates__range">22 Jul – 1 Sep 2026</span></li>
              <li><span class="peak-dates__label">Autumn half-term</span><span class="peak-dates__range">26 Oct – 1 Nov 2026</span></li>
              <li><span class="peak-dates__label">Christmas</span><span class="peak-dates__range">21 Dec 2026 – 3 Jan 2027</span></li>
              <li><span class="peak-dates__label">February half-term</span><span class="peak-dates__range">15 – 21 Feb 2027</span></li>
              <li><span class="peak-dates__label">Easter</span><span class="peak-dates__range">29 Mar – 11 Apr 2027</span></li>
              <li><span class="peak-dates__label">Spring bank holiday</span><span class="peak-dates__range">31 May – 6 Jun 2027</span></li>
              <li><span class="peak-dates__label">Summer 2027</span><span class="peak-dates__range">22 Jul – 1 Sep 2027</span></li>
            </ul>
          </details>
        </div>
      </div>
    </section>

    <section class="section-y band-subtle" id="payment" aria-labelledby="payment-h">
      <div class="container">
        <header class="section-head">
          <p class="eyebrow">Deposits and balance</p>
          <h2 id="payment-h">How payment works</h2>
          <p class="lede">You can pay by bank transfer or card. For information about invoicing different funders, see <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'resources' ) ); ?>">Funding &amp; Support</a>.</p>
        </header>
        <ol class="payment-steps">
          <li class="payment-steps__item">
            <span class="payment-steps__index" aria-hidden="true">01</span>
            <div class="payment-steps__body">
              <h3>50% deposit</h3>
              <p>This deposit secures your dates and removes the bungalow from the calendar.</p>
            </div>
          </li>
          <li class="payment-steps__item">
            <span class="payment-steps__index" aria-hidden="true">02</span>
            <div class="payment-steps__body">
              <h3>Balance before arrival</h3>
              <p>The remaining balance is due at least one week before you arrive.</p>
            </div>
          </li>
          <li class="payment-steps__item">
            <span class="payment-steps__index" aria-hidden="true">03</span>
            <div class="payment-steps__body">
              <h3>No extras</h3>
              <p>We do not charge a damage deposit or a cleaning fee at the end of your stay.</p>
            </div>
          </li>
        </ol>
        <p class="payment-note">If your plans change, our <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'terms-and-conditions' ) ); ?>">terms and cancellation policy</a> will explain what happens next.</p>
      </div>
    </section>

    <section class="section-y band-white" id="care-rates" aria-labelledby="care-rates-h">
      <div class="container">
        <header class="section-head section-head--tight">
          <p class="eyebrow">Guide rates</p>
          <h2 id="care-rates-h">Optional care while you stay</h2>
          <p class="lede">Guide rates for care from Continuity depend on the hours and tasks you need. Continuity will give you a quote after you speak with them.</p>
        </header>
        <div class="care-rates">
          <div class="rates-panel">
            <table class="data-table data-table--rates data-table--care">
              <caption class="sr-only">Optional care guide rates by support type for weekday and weekend. Continuity quotes the care cost once hours and tasks are agreed.</caption>
              <thead>
                <tr>
                  <th scope="col">Support</th>
                  <th scope="col">From, weekday</th>
                  <th scope="col">From, weekend</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">Daytime personal care <span class="data-table__hint">(per hour)</span></th>
                  <td class="is-price" data-label="Weekday">£34.65</td>
                  <td class="is-price" data-label="Weekend">£41.25</td>
                </tr>
                <tr>
                  <th scope="row">Overnight personal care <span class="data-table__hint">(per hour)</span></th>
                  <td class="is-price" data-label="Weekday">£40.15</td>
                  <td class="is-price" data-label="Weekend">£46.75</td>
                </tr>
                <tr>
                  <th scope="row">Sleep-in night <span class="data-table__hint">(per night)</span></th>
                  <td class="is-price" data-label="Weekday">£230.94</td>
                  <td class="is-price" data-label="Weekend">£230.94</td>
                </tr>
                <tr>
                  <th scope="row">Waking night <span class="data-table__hint">(per night)</span></th>
                  <td class="is-price" data-label="Weekday">£307.62</td>
                  <td class="is-price" data-label="Weekend">£307.62</td>
                </tr>
              </tbody>
            </table>
            <div class="care-rates__footer">
              <div class="care-rates__brands care__brand" aria-label="Care partner and CQC rating">
                <a class="care__brand-link care__brand-link--ccs" href="https://www.continuitycareservices.co.uk/" target="_blank" rel="noopener noreferrer" aria-label="Continuity of Care Services (opens in a new tab)">
                  <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/partners/continuity-of-care-services-long.png' ); ?>" alt="" width="405" height="69" loading="lazy" decoding="async" />
                </a>
                <a class="care__brand-link care__brand-link--cqc" href="https://www.cqc.org.uk/location/1-2624556588" target="_blank" rel="noopener noreferrer" aria-label="CQC rating Good, Continuity of Care Services (opens in a new tab)">
                  <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/partners/cqc-rating-good.jpg' ); ?>" alt="" width="710" height="399" loading="lazy" decoding="async" />
                </a>
              </div>
              <p class="care-rates__note">There may be extra charges for bank holidays and complex care. Next review: 1 September 2026.</p>
              <div class="care-rates__ctas">
                <a class="btn btn-gold" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'enquire' ) ); ?>">Enquire about care</a>
                <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'optional-care' ) ); ?>">How optional care works</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="faq section-y band-subtle" id="faq" aria-labelledby="faq-h">
      <div class="container">
        <div class="faq__layout">
          <header class="faq__intro">
            <p class="eyebrow">Money questions</p>
            <h2 id="faq-h">Pricing FAQ</h2>
            <p class="lede">See what is included in the bungalow rate, how Continuity guide rates work, and why funding does not change our published price.</p>
          </header>
          <div class="faq-list" data-faq-accordion>
            <div class="faq-item is-open">
              <button type="button" class="faq-item__trigger" aria-expanded="true" id="pr-q1" aria-controls="pr-q1-a">
                <span>Is care included in the bungalow price?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button>
              <div class="faq-item__panel" id="pr-q1-a" role="region" aria-labelledby="pr-q1">
                <p>No. The bungalow rate covers the house and on-site access equipment. Care is optional and provided by Continuity of Care Services. See the guide rates above for details.</p>
              </div>
            </div>
            <div class="faq-item">
              <button type="button" class="faq-item__trigger" aria-expanded="false" id="pr-q2" aria-controls="pr-q2-a">
                <span>Are there extra charges for equipment?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button>
              <div class="faq-item__panel" id="pr-q2-a" role="region" aria-labelledby="pr-q2" hidden>
                <p>On-site hoists, profiling beds, and wet-room equipment are included. If you need to hire specialist equipment, there is an extra charge, so let us know when you enquire. For fit and hygiene, please bring your own slings.</p>
              </div>
            </div>
            <div class="faq-item">
              <button type="button" class="faq-item__trigger" aria-expanded="false" id="pr-q3" aria-controls="pr-q3-a">
                <span>Do prices change with funding?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button>
              <div class="faq-item__panel" id="pr-q3-a" role="region" aria-labelledby="pr-q3" hidden>
                <p>No. Funding only affects who receives the invoice. See <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'resources' ) ); ?>">Funding &amp; Support</a> for more information.</p>
              </div>
            </div>
            <div class="faq-item">
              <button type="button" class="faq-item__trigger" aria-expanded="false" id="pr-q4" aria-controls="pr-q4-a">
                <span>When do care guide rates go up?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button>
              <div class="faq-item__panel" id="pr-q4-a" role="region" aria-labelledby="pr-q4" hidden>
                <p>Weekends, bank holidays, and complex care cost more. Continuity reviews their rates regularly, and the next review date is listed above. They will give you a care quote once you agree on the hours and tasks.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="mid-cta mid-cta--plain section-y--cta" aria-labelledby="mid-cta-h">
      <div class="mid-cta__media" aria-hidden="true"></div>
      <div class="mid-cta__inner">
        <h2 id="mid-cta-h">Enquire about dates and care.</h2>
        <p>Let us know your arrival dates, access needs, and if you want support from Continuity. You do not need to pay a deposit until you decide.</p>
        <div class="mid-cta__btns">
          <a class="btn btn-gold" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'enquire' ) ); ?>">Enquire Now</a>
          <a class="btn btn-outline-light" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'how-it-works' ) ); ?>">How booking works</a>
        </div>
      </div>
    </section>

</main>

<?php
get_footer();
