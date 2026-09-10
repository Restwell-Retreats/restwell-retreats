<?php
/**
 * Mid-page conversion CTA (teal band).
 *
 * Expected $args (via get_template_part third argument / set_query_var):
 * - heading (string, required)
 * - intro   (string, optional)
 * - primary_label / primary_url (optional; defaults to Enquire)
 * - secondary_label / secondary_url (optional)
 * - section_id (optional HTML id)
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading          = isset( $args['heading'] ) ? (string) $args['heading'] : '';
$intro            = isset( $args['intro'] ) ? (string) $args['intro'] : '';
$primary_label    = isset( $args['primary_label'] ) ? (string) $args['primary_label'] : __( 'Enquire', 'restwell-retreats' );
$primary_url      = isset( $args['primary_url'] ) ? (string) $args['primary_url'] : '';
$secondary_label  = isset( $args['secondary_label'] ) ? (string) $args['secondary_label'] : '';
$secondary_url    = isset( $args['secondary_url'] ) ? (string) $args['secondary_url'] : '';
$section_id       = isset( $args['section_id'] ) ? (string) $args['section_id'] : '';

if ( '' === $heading ) {
	return;
}

if ( '' === $primary_url && function_exists( 'restwell_nav_resolve_page_url' ) ) {
	$primary_url = restwell_nav_resolve_page_url( 'enquire' );
}

$heading_id = $section_id ? $section_id . '-h' : 'mid-cta-h';
?>
<section class="mid-cta mid-cta--plain section-y--cta"<?php echo $section_id ? ' id="' . esc_attr( $section_id ) . '"' : ''; ?> aria-labelledby="<?php echo esc_attr( $heading_id ); ?>">
	<div class="mid-cta__media" aria-hidden="true"></div>
	<div class="mid-cta__inner">
		<h2 id="<?php echo esc_attr( $heading_id ); ?>"><?php echo esc_html( $heading ); ?></h2>
		<?php if ( '' !== $intro ) : ?>
		<p><?php echo esc_html( $intro ); ?></p>
		<?php endif; ?>
		<div class="mid-cta__btns">
			<?php if ( '' !== $primary_url && '' !== $primary_label ) : ?>
			<a class="btn btn-gold" href="<?php echo esc_url( $primary_url ); ?>"><?php echo esc_html( $primary_label ); ?></a>
			<?php endif; ?>
			<?php if ( '' !== $secondary_url && '' !== $secondary_label ) : ?>
			<a class="btn btn-outline-light" href="<?php echo esc_url( $secondary_url ); ?>"><?php echo esc_html( $secondary_label ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</section>
