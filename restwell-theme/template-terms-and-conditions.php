<?php
/**
 * Template Name: Terms & Conditions
 *
 * Reads the "Legal" content fields (Page content metabox) so editors can
 * change the label, headline, intro and body without touching code. Any
 * field left empty falls back to the theme default in inc/theme-setup/legal-content.php.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$restwell_legal_post_id = (int) get_queried_object_id();
$restwell_legal_defaults = function_exists( 'restwell_get_terms_conditions_page_defaults' )
	? restwell_get_terms_conditions_page_defaults()
	: array();

$restwell_legal_label = trim( (string) get_post_meta( $restwell_legal_post_id, 'legal_label', true ) );
if ( '' === $restwell_legal_label ) {
	$restwell_legal_label = (string) ( $restwell_legal_defaults['legal_label'] ?? '' );
}

$restwell_legal_heading = trim( (string) get_post_meta( $restwell_legal_post_id, 'legal_heading', true ) );
if ( '' === $restwell_legal_heading ) {
	$restwell_legal_heading = (string) ( $restwell_legal_defaults['legal_heading'] ?? __( 'Restwell terms and conditions', 'restwell-retreats' ) );
}

$restwell_legal_intro = trim( (string) get_post_meta( $restwell_legal_post_id, 'legal_intro', true ) );
if ( '' === $restwell_legal_intro ) {
	$restwell_legal_intro = (string) ( $restwell_legal_defaults['legal_intro'] ?? '' );
}

$restwell_legal_body = trim( (string) get_post_meta( $restwell_legal_post_id, 'legal_body_html', true ) );
if ( '' === $restwell_legal_body && function_exists( 'restwell_get_terms_conditions_content' ) ) {
	$restwell_legal_body = restwell_get_terms_conditions_content();
}

get_header();
?>


<main id="main-content">
<section class="hero hero--interior" aria-labelledby="page-h">
	  <div class="container">
		<div class="hero__content">
		  <ol class="breadcrumb"><li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'restwell-retreats' ); ?></a></li><li class="breadcrumb__sep" aria-hidden="true">/</li><li aria-current="page"><?php esc_html_e( 'Terms & Conditions', 'restwell-retreats' ); ?></li></ol>
		  <div class="hero__text">
			<?php if ( '' !== $restwell_legal_label ) : ?>
			<p class="eyebrow eyebrow--on-dark"><?php echo esc_html( $restwell_legal_label ); ?></p>
			<?php endif; ?>
			<h1 id="page-h"><?php echo esc_html( $restwell_legal_heading ); ?></h1>
			<?php if ( '' !== $restwell_legal_intro ) : ?>
			<p><?php echo esc_html( $restwell_legal_intro ); ?></p>
			<?php endif; ?>
		  </div>
		</div>
	  </div>
	</section>

	<section class="section-y band-white">
	  <div class="container">
		<div class="prose prose--wide">
		  <?php echo wp_kses_post( $restwell_legal_body ); ?>
		</div>
	  </div>
	</section>

</main>

<?php
get_footer();
