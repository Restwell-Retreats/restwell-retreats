<?php
/**
 * Template Name: FAQ
 *
 * Concept port from mockups — FAQ.
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
          <ol class="breadcrumb"><li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li><li class="breadcrumb__sep" aria-hidden="true">/</li><li aria-current="page">FAQ</li></ol>
          <div class="hero__text">
            <h1 id="page-h">Whitstable bungalow holiday FAQs</h1>
            <p>House, booking and packing questions we hear before an enquiry — with links when the full answer lives on Accessibility, Pricing, Care or Whitstable.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="faq section-y band-white">
      <div class="container">
        <h2 class="sr-only">Frequently asked questions</h2>
        <ul class="pill-tabs" data-faq-filters role="tablist" aria-label="FAQ categories">
          <li><button type="button" data-filter="all" class="is-active" aria-selected="true">All</button></li>
          <li><button type="button" data-filter="booking" aria-selected="false">Booking</button></li>
          <li><button type="button" data-filter="property" aria-selected="false">The house</button></li>
          <li><button type="button" data-filter="prep" aria-selected="false">Before you travel</button></li>
          <li><button type="button" data-filter="care" aria-selected="false">Care</button></li>
          <li><button type="button" data-filter="funding" aria-selected="false">Funding</button></li>
        </ul>
          <div class="faq-list faq-list--split faq-list--measure" data-faq-accordion>
            <div class="faq-list__col">
            <div class="faq-item is-open" data-cat="booking">
              <h3 class="faq-item__heading"><button type="button" class="faq-item__trigger" aria-expanded="true" id="faq-q1" aria-controls="faq-q1-a">
                <span>Is Restwell open for bookings?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button></h3>
              <div class="faq-item__panel" id="faq-q1-a" role="region" aria-labelledby="faq-q1">
                <p>Yes, we take bookings for 2026 and 2027. Send dates and access needs via the enquire form.</p>
              </div>
            </div>
            <div class="faq-item" data-cat="booking">
              <h3 class="faq-item__heading"><button type="button" class="faq-item__trigger" aria-expanded="false" id="faq-q2" aria-controls="faq-q2-a">
                <span>How do I check dates if there’s no online checkout?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button></h3>
              <div class="faq-item__panel" id="faq-q2-a" role="region" aria-labelledby="faq-q2" hidden>
                <p>Enquire with dates and access needs, or call 01622 809881. We reply within 48 hours on most enquiries. A 50% deposit only happens after we’ve confirmed the house fits. The booking steps are on <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'how-it-works' ) ); ?>">How It Works</a>.</p>
              </div>
            </div>
            <div class="faq-item" data-cat="booking">
              <h3 class="faq-item__heading"><button type="button" class="faq-item__trigger" aria-expanded="false" id="faq-q3" aria-controls="faq-q3-a">
                <span>How quickly do you reply?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button></h3>
              <div class="faq-item__panel" id="faq-q3-a" role="region" aria-labelledby="faq-q3" hidden>
                <p>Within 48 hours on most enquiries. Mark the form as time-sensitive if dates are tight, or phone 01622 809881.</p>
              </div>
            </div>
            <div class="faq-item" data-cat="booking">
              <h3 class="faq-item__heading"><button type="button" class="faq-item__trigger" aria-expanded="false" id="faq-q4" aria-controls="faq-q4-a">
                <span>What time is check-in and check-out?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button></h3>
              <div class="faq-item__panel" id="faq-q4-a" role="region" aria-labelledby="faq-q4" hidden>
                <p>Check-in is from 3pm via the key-safe. Check-out is 11am unless we’ve agreed something else for access or care travel.</p>
              </div>
            </div>
            <div class="faq-item" data-cat="booking">
              <h3 class="faq-item__heading"><button type="button" class="faq-item__trigger" aria-expanded="false" id="faq-q5" aria-controls="faq-q5-a">
                <span>What’s your cancellation policy?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button></h3>
              <div class="faq-item__panel" id="faq-q5-a" role="region" aria-labelledby="faq-q5" hidden>
                <p>More than 30 days before arrival your deposit is refundable minus an admin fee; 14–30 days sees partial forfeiture; inside 14 days the balance is typically due. Full wording is in the <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'terms-and-conditions' ) ); ?>">Terms &amp; Conditions</a>.</p>
              </div>
            </div>
            <div class="faq-item" data-cat="booking">
              <h3 class="faq-item__heading"><button type="button" class="faq-item__trigger" aria-expanded="false" id="faq-q6" aria-controls="faq-q6-a">
                <span>How many guests can stay, and can we book a few nights?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button></h3>
              <div class="faq-item__panel" id="faq-q6-a" role="region" aria-labelledby="faq-q6" hidden>
                <p>Maximum occupancy is five guests unless agreed in writing. Midweek and weekend night rates are published, including three- and four-night examples, as well as a seven-night week. See <a class="text-link" href="<?php echo esc_url(  restwell_nav_resolve_page_url( 'pricing' )  . '#rates' ); ?>">Pricing</a> and the room layout on <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'the-property' ) ); ?>">The Property</a>.</p>
              </div>
            </div>
            <div class="faq-item" data-cat="property">
              <h3 class="faq-item__heading"><button type="button" class="faq-item__trigger" aria-expanded="false" id="faq-q7" aria-controls="faq-q7-a">
                <span>Do we have the whole bungalow to ourselves?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button></h3>
              <div class="faq-item__panel" id="faq-q7-a" role="region" aria-labelledby="faq-q7" hidden>
                <p>Yes. Restwell is one private house for your party only. There is no shared corridor or reception desk.</p>
              </div>
            </div>
            <div class="faq-item" data-cat="property">
              <h3 class="faq-item__heading"><button type="button" class="faq-item__trigger" aria-expanded="false" id="faq-q8" aria-controls="faq-q8-a">
                <span>Do you allow assistance dogs?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button></h3>
              <div class="faq-item__panel" id="faq-q8-a" role="region" aria-labelledby="faq-q8" hidden>
                <p>Yes. The bungalow is dog-friendly and welcomes assistance dogs. Please tell us in advance so we can complete a risk assessment. Water bowls and a toileting area are provided.</p>
              </div>
            </div>
            <div class="faq-item" data-cat="property">
              <h3 class="faq-item__heading"><button type="button" class="faq-item__trigger" aria-expanded="false" id="faq-q9" aria-controls="faq-q9-a">
                <span>Is parking available at the bungalow?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button></h3>
              <div class="faq-item__panel" id="faq-q9-a" role="region" aria-labelledby="faq-q9" hidden>
                <p>Yes, driveway parking for two cars on a level surface. Adapted vehicles with ramps or side lifts usually fit; tell us your vehicle length when you enquire. Town Blue Badge bays are on the <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'whitstable-area-guide' ) ); ?>">Whitstable guide</a>.</p>
              </div>
            </div>
            <div class="faq-item" data-cat="property">
              <h3 class="faq-item__heading"><button type="button" class="faq-item__trigger" aria-expanded="false" id="faq-q10" aria-controls="faq-q10-a">
                <span>What is included — linen, towels, kitchen, Wi-Fi?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button></h3>
              <div class="faq-item__panel" id="faq-q10-a" role="region" aria-labelledby="faq-q10" hidden>
                <p>Exclusive use of the house, bed linen and towels, a full kitchen with cooking basics, private garden, driveway parking, and Wi-Fi (network details on your confirmation). On-site access equipment is included in the bungalow rate; the millimetre list is on <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'accessibility' ) ); ?>">Accessibility</a>. Care is never included in that rate.</p>
              </div>
            </div>
            <div class="faq-item" data-cat="property">
              <h3 class="faq-item__heading"><button type="button" class="faq-item__trigger" aria-expanded="false" id="faq-q11" aria-controls="faq-q11-a">
                <span>Is there a damage deposit or end-of-stay cleaning fee?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button></h3>
              <div class="faq-item__panel" id="faq-q11-a" role="region" aria-labelledby="faq-q11" hidden>
                <p>No. We do not charge a damage deposit or a leaving-clean fee. Report any damage so we can put it right. Payment steps live on <a class="text-link" href="<?php echo esc_url(  restwell_nav_resolve_page_url( 'pricing' )  . '#payment' ); ?>">Pricing</a>.</p>
              </div>
            </div>
            </div>
            <div class="faq-list__col">
            <div class="faq-item" data-cat="property">
              <h3 class="faq-item__heading"><button type="button" class="faq-item__trigger" aria-expanded="false" id="faq-q12" aria-controls="faq-q12-a">
                <span>Can I smoke or vape at Restwell?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button></h3>
              <div class="faq-item__panel" id="faq-q12-a" role="region" aria-labelledby="faq-q12" hidden>
                <p>No smoking or vaping inside. Outside only, with windows closed so smoke does not drift indoors. House rules are also in the guest guide after you book.</p>
              </div>
            </div>
            <div class="faq-item" data-cat="property">
              <h3 class="faq-item__heading"><button type="button" class="faq-item__trigger" aria-expanded="false" id="faq-q13" aria-controls="faq-q13-a">
                <span>Can I see the access measurements before I book?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button></h3>
              <div class="faq-item__panel" id="faq-q13-a" role="region" aria-labelledby="faq-q13" hidden>
                <p>Yes. Door widths, hoist safe working load, wet room and beds are on the <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'accessibility' ) ); ?>">Accessibility</a> page. We keep that as the spec sheet so it isn’t copied around the site.</p>
              </div>
            </div>
            <div class="faq-item" data-cat="prep">
              <h3 class="faq-item__heading"><button type="button" class="faq-item__trigger" aria-expanded="false" id="faq-q14" aria-controls="faq-q14-a">
                <span>Do you provide hoist slings?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button></h3>
              <div class="faq-item__panel" id="faq-q14-a" role="region" aria-labelledby="faq-q14" hidden>
                <p>No. Please bring your own slings so they fit the person and the hoist. Ceiling track details and safe working load are on <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'accessibility' ) ); ?>">Accessibility</a>.</p>
              </div>
            </div>
            <div class="faq-item" data-cat="prep">
              <h3 class="faq-item__heading"><button type="button" class="faq-item__trigger" aria-expanded="false" id="faq-q15" aria-controls="faq-q15-a">
                <span>Can I hire extra mobility equipment for the stay?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button></h3>
              <div class="faq-item__panel" id="faq-q15-a" role="region" aria-labelledby="faq-q15" hidden>
                <p>On-site kit is included. Extra hire (for example a scooter) is charged separately if we need to arrange it — tell us when you enquire. We can also share local hire contacts. Confirm anything hired against the access statement so it actually fits the house.</p>
              </div>
            </div>
            <div class="faq-item" data-cat="prep">
              <h3 class="faq-item__heading"><button type="button" class="faq-item__trigger" aria-expanded="false" id="faq-q16" aria-controls="faq-q16-a">
                <span>Do I need holiday or travel insurance?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button></h3>
              <div class="faq-item__panel" id="faq-q16-a" role="region" aria-labelledby="faq-q16" hidden>
                <p>We do not sell insurance. Most guests arrange their own cover for cancellation, medical kit and travel. Check the policy covers pre-existing conditions and hired equipment. Our cancellation rules are still in the <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'terms-and-conditions' ) ); ?>">terms</a>.</p>
              </div>
            </div>
            <div class="faq-item" data-cat="prep">
              <h3 class="faq-item__heading"><button type="button" class="faq-item__trigger" aria-expanded="false" id="faq-q17" aria-controls="faq-q17-a">
                <span>What if a carer is ill and can’t come?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button></h3>
              <div class="faq-item__panel" id="faq-q17-a" role="region" aria-labelledby="faq-q17" hidden>
                <p>Restwell is a holiday let, not a care service, so plan a backup before you travel. If Continuity is already booked, they hold the care contract — phone them and us as soon as you know. If you bring your own PA, agree cover with your usual team. Optional Continuity is explained on <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'optional-care' ) ); ?>">Optional care</a>.</p>
              </div>
            </div>
            <div class="faq-item" data-cat="property">
              <h3 class="faq-item__heading"><button type="button" class="faq-item__trigger" aria-expanded="false" id="faq-q18" aria-controls="faq-q18-a">
                <span>How far is the bungalow from the seafront?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button></h3>
              <div class="faq-item__panel" id="faq-q18-a" role="region" aria-labelledby="faq-q18" hidden>
                <p>About ten to fifteen minutes. Tankerton promenade is the level coastal stretch; the shingle beach is not a wheelchair route. Days out, station access and RADAR toilets are on the <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'whitstable-area-guide' ) ); ?>">Whitstable guide</a>.</p>
              </div>
            </div>
            <div class="faq-item" data-cat="care">
              <h3 class="faq-item__heading"><button type="button" class="faq-item__trigger" aria-expanded="false" id="faq-q19" aria-controls="faq-q19-a">
                <span>Is care optional, or do I have to book Continuity?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button></h3>
              <div class="faq-item__panel" id="faq-q19-a" role="region" aria-labelledby="faq-q19" hidden>
                <p>Optional. Most guests book the bungalow as self-catering. You can bring your own carer or PA at no extra house charge, or ask about Continuity. Restwell is not a care home. Process and rates: <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'optional-care' ) ); ?>">Optional care</a>, <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'how-it-works' ) ); ?>">How It Works</a>, <a class="text-link" href="<?php echo esc_url(  restwell_nav_resolve_page_url( 'pricing' )  . '#care-rates' ); ?>">Pricing</a>.</p>
              </div>
            </div>
            <div class="faq-item" data-cat="funding">
              <h3 class="faq-item__heading"><button type="button" class="faq-item__trigger" aria-expanded="false" id="faq-q20" aria-controls="faq-q20-a">
                <span>Where do I read about CHC, direct payments and who you invoice?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button></h3>
              <div class="faq-item__panel" id="faq-q20-a" role="region" aria-labelledby="faq-q20" hidden>
                <p>On <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'resources' ) ); ?>">Funding &amp; Support</a>. House rates do not change with the funder; only who we invoice does. Deposits and “no damage deposit” are on <a class="text-link" href="<?php echo esc_url(  restwell_nav_resolve_page_url( 'pricing' )  . '#payment' ); ?>">Pricing</a>.</p>
              </div>
            </div>
            <div class="faq-item" data-cat="care">
              <h3 class="faq-item__heading"><button type="button" class="faq-item__trigger" aria-expanded="false" id="faq-q21" aria-controls="faq-q21-a">
                <span>Is Restwell a respite centre or care home?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button></h3>
              <div class="faq-item__panel" id="faq-q21-a" role="region" aria-labelledby="faq-q21" hidden>
                <p>No. It is a private adapted bungalow with optional Continuity care. Suitability versus a care-home placement is on <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'who-its-for' ) ); ?>">Who It’s For</a>.</p>
              </div>
            </div>
            <div class="faq-item" data-cat="prep">
              <h3 class="faq-item__heading"><button type="button" class="faq-item__trigger" aria-expanded="false" id="faq-q22" aria-controls="faq-q22-a">
                <span>Is there a supermarket near the bungalow?</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button></h3>
              <div class="faq-item__panel" id="faq-q22-a" role="region" aria-labelledby="faq-q22" hidden>
                <p>Tesco Extra is about seven minutes’ drive. Town eating and parking notes stay on the <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'whitstable-area-guide' ) ); ?>">Whitstable guide</a> so this page does not become a days-out list.</p>
              </div>
            </div>
            </div>
          </div>
    <section class="section-y band-subtle">
      <div class="container container--md">
        <header class="section-head">
          <p class="eyebrow">Can’t find your answer?</p>
          <h2>Ask us directly</h2>
        </header>
        <form class="form-stack restwell-faq-question-form" id="faq-question-form" action="<?php echo esc_url( get_permalink() ? get_permalink() : home_url( '/faq/' ) ); ?>" method="post">
          <?php wp_nonce_field( 'restwell_faq_question', 'restwell_faq_question_nonce' ); ?>
          <input type="hidden" name="restwell_faq_question" value="1" />
          <input type="hidden" name="restwell_faq_page_id" value="<?php echo esc_attr( (string) get_the_ID() ); ?>" />
          <input type="hidden" name="restwell_form_opened_at" value="" data-restwell-form-opened />
          <div class="field" hidden aria-hidden="true">
            <label for="faq_q_website">Website</label>
            <input type="text" id="faq_q_website" name="faq_q_website" tabindex="-1" autocomplete="off" />
          </div>
          <div class="field"><label for="ask-name">Name</label><input id="ask-name" name="faq_q_name" autocomplete="name" /></div>
          <div class="field"><label for="ask-email">Email</label><input id="ask-email" name="faq_q_email" type="email" autocomplete="email" required /></div>
          <div class="field"><label for="ask-q">Your question</label><textarea id="ask-q" name="faq_q_message" required></textarea></div>
          <div class="form-actions"><button class="btn btn-gold" type="submit">Send question</button></div>
        </form>
      </div>
    </section>
    <section class="mid-cta mid-cta--plain section-y--cta" aria-labelledby="mid-cta-h">
      <div class="mid-cta__media" aria-hidden="true"></div>
      <div class="mid-cta__inner">
        <h2 id="mid-cta-h">Send dates and access needs</h2>
        <p>We reply within 48 hours on most enquiries; phone 01622 809881 if you need to talk it through.</p>
        <div class="mid-cta__btns">
          <a class="btn btn-gold" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'enquire' ) ); ?>">Enquire Now</a>
          <a class="btn btn-outline-light" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'enquire' ) ); ?>">Go to enquire form</a>
        </div>
      </div>
    </section>

</main>

<?php
get_footer();
