<?php
/**
 * Template Name: How It Works
 *
 * Concept port from mockups — How It Works.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$restwell_hiw_id      = (int) get_queried_object_id();
$restwell_hiw_heading = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $restwell_hiw_id, 'hiw_heading', 'How accessible holiday booking works' )
	: 'How accessible holiday booking works';
$restwell_hiw_intro   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text(
		$restwell_hiw_id,
		'hiw_intro',
		'Share your dates and access needs, check what is included in the house, add Continuity care if you want, and arrive any time after 3pm using the key-safe.'
	)
	: 'Share your dates and access needs, check what is included in the house, add Continuity care if you want, and arrive any time after 3pm using the key-safe.';
?>


<main id="main-content">
<?php
get_template_part(
	'template-parts/concept/photo-hero',
	null,
	array(
		'heading_id' => 'page-h',
		'heading'    => $restwell_hiw_heading,
		'intro'      => $restwell_hiw_intro,
		'crumbs'     => array(
			array(
				'label' => __( 'Home', 'restwell-retreats' ),
				'url'   => home_url( '/' ),
			),
			array(
				'label' => 'How It Works',
				'url'   => '',
			),
		),
		'post_id'    => $restwell_hiw_id,
	)
);
?>

    <nav class="subnav" aria-label="On this page" data-toc>
      <div class="container">
        <ul class="subnav__list">
          <li><a href="#process">Process</a></li>
          <li><a href="#arrival">Arrival</a></li>
          <li><a href="#care">Care</a></li>
          <li><a href="#faq">FAQ</a></li>
        </ul>
      </div>
    </nav>

    <section class="section-y band-white process" id="process" aria-labelledby="process-h">
      <div class="container">
        <header class="section-head section-head--center process__head">
          <p class="eyebrow">How it works</p>
          <h2 id="process-h">Enquire, confirm, deposit, arrive.</h2>
          <p class="lede">There are four steps from your first message to arriving at the key safe. There is no online checkout, and you only pay a deposit after we have agreed on your dates.</p>
        </header>
        <div class="process__layout">
          <div class="process__media" data-reveal>
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/bungalow/patio-1.png' ); ?>" alt="Level resin patio and seating area at Restwell" width="900" height="1200" loading="lazy" />
          </div>
          <ol class="process-list">
            <li>
              <span class="process-list__index" aria-hidden="true">01</span>
              <div class="process-list__body">
                <h3>Enquire</h3>
                <p>Tell us your travel dates, who’s coming, and what equipment you need.</p>
              </div>
            </li>
            <li>
              <span class="process-list__index" aria-hidden="true">02</span>
              <div class="process-list__body">
                <h3>Confirm</h3>
                <p>We will set up the house for your group, including the bed layout. If you want, we can also start a Continuity care conversation using the same phone number.</p>
              </div>
            </li>
            <li>
              <span class="process-list__index" aria-hidden="true">03</span>
              <div class="process-list__body">
                <h3>Deposit</h3>
                <p>Pay a 50% deposit to reserve your bungalow. The rest is due one week before you arrive.</p>
              </div>
            </li>
            <li>
              <span class="process-list__index" aria-hidden="true">04</span>
              <div class="process-list__body">
                <h3>Arrive</h3>
                <p>Arrive any time after 3pm and use the key-safe. The step-free house and all your equipment will be ready for your group.</p>
              </div>
            </li>
          </ol>
        </div>
      </div>
    </section>

    <section class="section-y band-subtle" id="arrival" aria-labelledby="arrival-h">
      <div class="container split split--flip split--cover">
        <div class="split__media" data-reveal>
          <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/bungalow/entrance.png' ); ?>" alt="Step-free entrance to the Restwell bungalow on Russell Drive" width="900" height="675" loading="lazy" />
        </div>
        <div>
          <header class="section-head section-head--tight">
            <p class="eyebrow">Arrival day</p>
            <h2 id="arrival-h">Key-safe from 3pm</h2>
            <p class="lede">There is no reception desk. Park in the driveway, open the key safe, and settle into a house that is already set up for your group.</p>
          </header>
          <dl class="comparison-list">
            <div class="comparison-list__item">
              <dt>Check-in</dt>
              <dd>From 3pm via the key-safe · departure by 11am</dd>
            </div>
            <div class="comparison-list__item">
              <dt>Parking</dt>
              <dd>Level driveway for two cars, including accessible vehicles</dd>
            </div>
            <div class="comparison-list__item">
              <dt>Ready for you</dt>
              <dd>Step-free routes and kit set from your enquiry · guest notes after dates are confirmed</dd>
            </div>
          </dl>
          <p class="link-stack">
            <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'the-property' ) ); ?>">Tour the property</a>
            <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'accessibility' ) ); ?>">Door widths and kit notes</a>
          </p>
        </div>
      </div>
    </section>

    <section class="care section-y band-white" id="care" aria-labelledby="care-h">
      <div class="container">
        <div class="care__panel">
          <div class="care__intro">
            <header class="section-head">
              <p class="eyebrow">Optional care</p>
              <h2 id="care-h">Add care only if you need it</h2>
            </header>
            <div class="care__intro-body">
              <p class="lede">Ask about Continuity of Care Services when you enquire, or bring your own team. Care can be arranged in the same conversation as your booking.</p>
            </div>
          </div>
          <ul class="care__types" aria-label="What Continuity can arrange">
            <li>
              <span class="care__type-title">Personal care</span>
              <span class="care__type-text">Washing, dressing and daily routines on agreed times.</span>
            </li>
            <li>
              <span class="care__type-title">Visiting care</span>
              <span class="care__type-text">Short daytime visits, or support for a promenade or town trip.</span>
            </li>
            <li>
              <span class="care__type-title">Mobility and hoisting</span>
              <span class="care__type-text">Transfers with the on-site ceiling track and wet-room kit.</span>
            </li>
          </ul>
          <div class="care__foot">
            <div class="care__foot-copy">
              <p class="care__note">We do not add anything until you agree to the support package.</p>
              <p class="link-stack">
                <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'optional-care' ) ); ?>">How optional care works</a>
                <a class="text-link" href="<?php echo esc_url(  restwell_nav_resolve_page_url( 'pricing' )  . '#care-rates' ); ?>">See care guide rates</a>
              </p>
            </div>
            <div class="care__brand" aria-label="Care partner and CQC rating">
              <a class="care__brand-link care__brand-link--ccs" href="https://www.continuitycareservices.co.uk/" target="_blank" rel="noopener noreferrer" aria-label="Continuity of Care Services (opens in a new tab)">
                <img src="<?php echo esc_url( restwell_theme_image_url( 'partners/continuity-of-care-services-long.png' ) ); ?>" alt="" width="405" height="69" loading="lazy" decoding="async" />
              </a>
              <a class="care__brand-link care__brand-link--cqc" href="https://www.cqc.org.uk/location/1-2624556588" target="_blank" rel="noopener noreferrer" aria-label="CQC rating Good, Continuity of Care Services (opens in a new tab)">
                <img src="<?php echo esc_url( restwell_theme_image_url( 'partners/cqc-rating-good.jpg' ) ); ?>" alt="" width="710" height="399" loading="lazy" decoding="async" />
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="faq section-y band-subtle" id="faq" aria-labelledby="faq-h">
      <div class="container">
        <div class="faq__layout">
          <header class="faq__intro">
            <p class="eyebrow">Booking</p>
            <h2 id="faq-h">Before you enquire</h2>
            <p class="lede">We will explain when to pay the deposit, who we invoice, arrival details, and how optional care works with a self-catering stay.</p>
          </header>
          <?php
          $hiw_faq_items = array();
          foreach ( restwell_get_faq_items( 'how-it-works' ) as $row ) {
            $hiw_faq_items[] = array(
              'q'    => $row['q'],
              'a'    => '<p>' . wp_kses_post( $row['a'] ) . '</p>',
              'open' => ! empty( $row['open'] ),
              'cat'  => isset( $row['cat'] ) ? $row['cat'] : 'booking',
            );
          }
          get_template_part(
            'template-parts/faq-accordion',
            null,
            array(
              'id_prefix'    => 'hiw-q',
              'list_class'   => 'faq-list--split',
              'wrap_columns' => true,
              'columns'      => array( array_slice( $hiw_faq_items, 0, 3 ), array_slice( $hiw_faq_items, 3 ) ),
            )
          );
          ?>
        </div>
      </div>
    </section>

    <section class="mid-cta mid-cta--plain section-y--cta" aria-labelledby="mid-cta-h">
      <div class="mid-cta__media" aria-hidden="true"></div>
      <div class="mid-cta__inner">
        <h2 id="mid-cta-h">Send dates and access needs.</h2>
        <p>We will reply with measurements, equipment notes, and your next steps.</p>
        <div class="mid-cta__btns">
          <a class="btn btn-gold" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'enquire' ) ); ?>">Enquire Now</a>
          <a class="btn btn-outline-light" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'the-property' ) ); ?>">View the property</a>
        </div>
      </div>
    </section>

</main>

<?php
get_footer();
