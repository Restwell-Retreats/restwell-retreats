<?php
/**
 * Concept port from mockups — Default page.
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
          <ol class="breadcrumb"><li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li><li class="breadcrumb__sep" aria-hidden="true">/</li><li aria-current="page">Sample page</li></ol>
          <div class="hero__text">
            <h1 id="page-h">About Restwell Retreats</h1>
            <p>A private accessible bungalow in Whitstable, Kent: step-free, with published access details and optional Continuity care.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="section-y band-white">
      <div class="container">
        <div class="prose prose--wide">
          <p>Restwell is a single-storey holiday bungalow on Russell Drive. Guests who need a ceiling hoist, level-access wet room and driveway parking can check those details before they enquire.</p>
          <h2>What this page is for</h2>
          <p>Simple WordPress pages use this layout: interior hero, then long-form prose. Link to the property, accessibility and enquire pages when readers need the next step.</p>
          <ul>
            <li>Property and access specs</li>
            <li>Funding and optional care</li>
            <li>Enquire with dates and needs</li>
          </ul>
        </div>
      </div>
    </section>

</main>

<?php
get_footer();
