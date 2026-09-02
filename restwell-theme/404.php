<?php
/**
 * Concept port from mockups — 404.
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
		  
		  <div class="hero__text">
			<h1 id="page-h">We couldn’t find that page</h1>
			<p>The link’s out of date. Here’s the quickest way to what you were probably after.</p>
		  </div>
		</div>
	  </div>
	</section>

	<section class="section-y band-white">
	  <div class="container">
		<h2 class="sr-only">Helpful links</h2>
		<div class="help-links">
		  <article class="info-card"><h3>The Property</h3><p>Rooms, equipment and photos of the Whitstable bungalow.</p><a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'the-property' ) ); ?>">View the bungalow</a></article>
		  <article class="info-card"><h3>Enquire</h3><p>Dates, access needs, funding questions.</p><a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'enquire' ) ); ?>">Send an enquiry</a></article>
		  <article class="info-card"><h3>How it works</h3><p>Enquire, deposit, key-safe arrival from 3pm.</p><a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'how-it-works' ) ); ?>">See the process</a></article>
		</div>
	  </div>
	</section>

</main>

<?php
get_footer();
