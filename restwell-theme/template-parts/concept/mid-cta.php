<?php
/**
 * Concept mid-cta band.
 *
 * @package Restwell_Retreats
 *
 * @param array $args {
 *     @type string $heading_id H2 id.
 *     @type string $heading    Required.
 *     @type string $body       Optional.
 *     @type array  $primary    array( 'label' => '', 'url' => '' ).
 *     @type array  $secondary  array( 'label' => '', 'url' => '' ).
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = isset( $args ) && is_array( $args ) ? $args : array();
$args = wp_parse_args(
	$args,
	array(
		'heading_id' => 'mid-cta-h',
		'heading'    => '',
		'body'       => '',
		'primary'    => array(),
		'secondary'  => array(),
	)
);

$heading = (string) $args['heading'];
if ( $heading === '' ) {
	return;
}

$primary   = is_array( $args['primary'] ) ? $args['primary'] : array();
$secondary = is_array( $args['secondary'] ) ? $args['secondary'] : array();
?>
<section class="mid-cta mid-cta--plain section-y--cta" aria-labelledby="<?php echo esc_attr( (string) $args['heading_id'] ); ?>">
	<div class="mid-cta__media" aria-hidden="true"></div>
	<div class="mid-cta__inner">
		<h2 id="<?php echo esc_attr( (string) $args['heading_id'] ); ?>"><?php echo esc_html( $heading ); ?></h2>
		<?php if ( $args['body'] !== '' ) : ?>
			<p><?php echo esc_html( (string) $args['body'] ); ?></p>
		<?php endif; ?>
		<?php if ( ! empty( $primary['label'] ) || ! empty( $secondary['label'] ) ) : ?>
			<div class="mid-cta__btns">
				<?php if ( ! empty( $primary['label'] ) && ! empty( $primary['url'] ) ) : ?>
					<a class="btn btn-gold" href="<?php echo esc_url( (string) $primary['url'] ); ?>"><?php echo esc_html( (string) $primary['label'] ); ?></a>
				<?php endif; ?>
				<?php if ( ! empty( $secondary['label'] ) && ! empty( $secondary['url'] ) ) : ?>
					<a class="btn btn-outline-light" href="<?php echo esc_url( (string) $secondary['url'] ); ?>"><?php echo esc_html( (string) $secondary['label'] ); ?></a>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
