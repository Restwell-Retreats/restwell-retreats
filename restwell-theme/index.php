<?php
/**
 * Concept port from mockups — Blog index.
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
          <ol class="breadcrumb"><li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li><li class="breadcrumb__sep" aria-hidden="true">/</li><li aria-current="page">Blog</li></ol>
          <div class="hero__text">
            <h1 id="page-h">Accessible travel guides</h1>
            <p>Access notes for Whitstable and the Kent coast, written for wheelchair users, carers and anyone planning a disability-friendly holiday or a funded stay.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="section-y band-white">
      <div class="container">
        <article class="blog-featured">
          <a class="blog-featured__media" href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" aria-hidden="true" tabindex="-1">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/stock/restwell-whitstable-coastline-panorama.webp' ); ?>" alt="Whitstable coastline" width="1000" height="625" loading="lazy" />
            <span class="blog-featured__scrim" aria-hidden="true"></span>
            <span class="tag blog-featured__tag">Area guide</span>
          </a>
          <div class="blog-featured__overlay">
            <p class="blog-meta blog-meta--overlay">8 min read</p>
            <h2><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">Accessible beaches and promenades near Whitstable</a></h2>
            <p class="blog-featured__excerpt">Where the paved coast works for chairs, and where shingle means choosing the promenade instead.</p>
          </div>
        </article>
        <ul class="card-grid card-grid--2" role="list" data-reveal>
          <li><article class="media-card">
            <a class="media-card__image" href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" aria-hidden="true" tabindex="-1">
              <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/stock/restwell-whitstable-marina-sunset.webp' ); ?>" alt="Marina at sunset" width="640" height="480" loading="lazy" />
              <span class="tag media-card__tag">Planning</span>
            </a>
            <p class="blog-meta">5 min read</p>
            <h3><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">What to pack for an accessible coastal stay</a></h3>
            <p>A short list that assumes the hoist and wet room are already waiting.</p>
          </article></li>
          <li><article class="media-card">
            <a class="media-card__image" href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" aria-hidden="true" tabindex="-1">
              <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/stock/restwell-whitstable-drone-aerial-view.webp' ); ?>" alt="Aerial view of Whitstable" width="640" height="480" loading="lazy" />
              <span class="tag media-card__tag">Funding</span>
            </a>
            <p class="blog-meta">6 min read</p>
            <h3><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">Direct payments and short breaks: a plain overview</a></h3>
            <p>How families and carers often start the conversation with their local authority.</p>
          </article></li>
        </ul>
      </div>
    </section>

</main>

<?php
get_footer();
