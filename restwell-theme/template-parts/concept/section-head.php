<?php
/**
 * Concept section head (.eyebrow / h2 / .lede).
 *
 * @package Restwell_Retreats
 *
 * @param array $args {
 *     @type string $heading_id Optional h2 id.
 *     @type string $heading    Required.
 *     @type string $eyebrow    Optional.
 *     @type string $lede       Optional.
 *     @type string $modifier   Optional class suffix e.g. section-head--tight.
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = isset( $args ) && is_array( $args ) ? $args : array();
$args = wp_parse_args(
	$args,
	array(
		'heading_id' => '',
		'heading'    => '',
		'eyebrow'    => '',
		'lede'       => '',
		'modifier'   => 'section-head--tight',
	)
);

$heading = (string) $args['heading'];
if ( $heading === '' ) {
	return;
}

$class = 'section-head';
if ( $args['modifier'] !== '' ) {
	$class .= ' ' . (string) $args['modifier'];
}
?>
<header class="<?php echo esc_attr( $class ); ?>">
	<?php if ( $args['eyebrow'] !== '' ) : ?>
		<p class="eyebrow"><?php echo esc_html( (string) $args['eyebrow'] ); ?></p>
	<?php endif; ?>
	<h2<?php echo $args['heading_id'] !== '' ? ' id="' . esc_attr( (string) $args['heading_id'] ) . '"' : ''; ?>><?php echo esc_html( $heading ); ?></h2>
	<?php if ( $args['lede'] !== '' ) : ?>
		<p class="lede"><?php echo esc_html( (string) $args['lede'] ); ?></p>
	<?php endif; ?>
</header>
