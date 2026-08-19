<?php
/**
 * Template Name: Accessibility Policy
 *
 * Concept port from mockups — Accessibility Policy.
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
          <ol class="breadcrumb"><li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li><li class="breadcrumb__sep" aria-hidden="true">/</li><li aria-current="page">Website accessibility</li></ol>
          <div class="hero__text">
            <h1 id="page-h">Restwell website accessibility</h1>
            <p>How we aim to make restwellretreats.co.uk usable, how we test, and how to get content in another format.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="section-y band-white">
      <div class="container">
        <div class="prose prose--wide">
          <p>This statement covers the Restwell Retreats website. It is separate from the <a href="<?php echo esc_url( restwell_nav_resolve_page_url( 'accessibility' ) ); ?>">property Accessibility page</a>, which describes the bungalow.</p>
          <h2>Our aim</h2>
          <p>We aim to meet WCAG 2.2 Level AA. We test key user flows including enquire, property information and funding content.</p>
          <h2>How we test</h2>
          <p>Manual keyboard checks, screen-reader spot checks, and automated audits on major templates. Known issues are prioritised by impact.</p>
          <h2>Property access information</h2>
          <p>Door widths, equipment and room-by-room notes live on the <a href="<?php echo esc_url( restwell_nav_resolve_page_url( 'accessibility' ) ); ?>">Accessibility</a> page.</p>
          <h2>Third-party content</h2>
          <p>Embedded maps, payment or partner tools may not fully meet our standard. We choose alternatives where practical.</p>
          <h2>Feedback</h2>
          <p>Email hello@restwellretreats.co.uk or call 01622 809881 if you find a barrier or need information in another format.</p>
          <h2>Formal complaints</h2>
          <p>If you are not satisfied with our response, you can contact the <a href="https://www.equalityhumanrights.com/" target="_blank" rel="noopener noreferrer">Equality and Human Rights Commission (EHRC)<span class="sr-only"> (opens in new tab)</span></a> for further advice.</p>
        </div>
      </div>
    </section>

</main>

<?php
get_footer();
