<?php
/**
 * Concept port from mockups — Blog single.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>


<main id="main-content">
<section class="hero hero--interior hero--place" aria-labelledby="page-h">
      <div class="hero__media" aria-hidden="true"></div>
      <div class="container">
        <div class="hero__content">
          <ol class="breadcrumb"><li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">Blog</a></li><li class="breadcrumb__sep" aria-hidden="true">/</li><li aria-current="page">Article</li></ol>
          <div class="hero__text">
            <h1 id="page-h">Accessible beaches and promenades near Whitstable</h1>
            <p>Tankerton’s level promenade, harbour limits, and why the shingle beach is not the wheelchair route.</p>
          </div>
        </div>
      </div>
    </section>

    <article class="section-y band-white">
      <div class="container">
        <p class="blog-meta"><span class="tag">Area guide</span><span>8 min read</span><span>Restwell team</span></p>
        <div class="prose prose--wide">
          <p>If you use a wheelchair or mobility scooter, aim for Whitstable’s paved promenade, not the shingle. Tankerton’s seafront path is wide, level and long enough for a proper coastal outing from Restwell.</p>
          <h2>Start at Tankerton</h2>
          <p>From Restwell, Tankerton promenade is about a 15-minute walk. The path is wide, level and surfaced for several miles. The grassy slopes above are steep; stay on the paved seafront route. Free parking is often available along Marine Parade at the top.</p>
          <h2>Harbour and town</h2>
          <p>Harbour Street can be narrow, and some shop entrances are stepped. The harbour has a Changing Places toilet (RADAR key) and uneven surfaces in places. Take it steady, and call venues ahead if you need a table with step-free access.</p>
          <h2>About the beach</h2>
          <p>The beach itself is shingle. Chairs don’t roll well on it. Guests who want sea air without fighting the stones use the promenade above, the same route we map on the Whitstable guide.</p>
          <p class="link-stack">
            <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'whitstable-area-guide' ) ); ?>">Full Whitstable guide</a>
            <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'accessibility' ) ); ?>">Property accessibility</a>
          </p>
        </div>
        <p class="blog-meta"><span class="tag">Whitstable</span><span class="tag">Access</span><span class="tag">Promenade</span></p>
      </div>
    </article>
    <section class="section-y band-subtle">
      <div class="container">
        <header class="section-head"><h2>Related reading</h2></header>
        <ul class="card-grid card-grid--3" role="list">
          <li><article class="media-card"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/stock/restwell-whitstable-beach-relaxation.webp' ); ?>" alt="Guest relaxing on the Whitstable seafront" width="640" height="480" loading="lazy" /><h3><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">What to pack for an accessible stay</a></h3></article></li>
          <li><article class="media-card"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/bungalow/WHIT-SEAFRONT-2-LS.jpg' ); ?>" alt="Whitstable seafront view from the promenade" width="640" height="480" loading="lazy" /><h3><a href="<?php echo esc_url( restwell_nav_resolve_page_url( 'whitstable-area-guide' ) ); ?>">Whitstable guide</a></h3></article></li>
          <li><article class="media-card"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/bungalow/entrance.png' ); ?>" alt="Step-free entrance to the Restwell bungalow" width="640" height="480" loading="lazy" /><h3><a href="<?php echo esc_url( restwell_nav_resolve_page_url( 'the-property' ) ); ?>">The property</a></h3></article></li>
        </ul>
      </div>
    </section>

</main>

<?php
get_footer();
