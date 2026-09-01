<?php
/**
 * Legal policy photo hero + HTML body (Privacy, Terms, Website accessibility).
 *
 * @package Restwell_Retreats
 *
 * @param array $args {
 *     @type int    $post_id     Page ID for hero image resolution.
 *     @type string $eyebrow     Optional eyebrow (legal_label).
 *     @type string $heading     H1.
 *     @type string $intro       Lede.
 *     @type string $crumb_label Current-page breadcrumb.
 *     @type string $body_html   Policy HTML (already kses’d by the caller or kses’d here).
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = isset( $args ) && is_array( $args ) ? $args : array();
$args = wp_parse_args(
	$args,
	array(
		'post_id'     => 0,
		'eyebrow'     => '',
		'heading'     => '',
		'intro'       => '',
		'crumb_label' => '',
		'body_html'   => '',
	)
);

get_template_part(
	'template-parts/concept/photo-hero',
	null,
	array(
		'heading_id' => 'page-h',
		'heading'    => (string) $args['heading'],
		'eyebrow'    => (string) $args['eyebrow'],
		'intro'      => (string) $args['intro'],
		'crumbs'     => array(
			array(
				'label' => __( 'Home', 'restwell-retreats' ),
				'url'   => home_url( '/' ),
			),
			array(
				'label' => (string) $args['crumb_label'],
				'url'   => '',
			),
		),
		'post_id'    => absint( $args['post_id'] ),
	)
);
?>

	<section class="section-y band-white">
	  <div class="container">
		<div class="prose prose--wide">
		  <?php echo wp_kses_post( (string) $args['body_html'] ); ?>
		</div>
	  </div>
	</section>
