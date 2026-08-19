<?php
/**
 * Concept on-page subnav.
 *
 * @package Restwell_Retreats
 *
 * @param array $args {
 *     @type array $items List of array( 'label' => '', 'url' => '#anchor' ).
 *     @type bool  $toc   Add data-toc for shared.js scroll spy.
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = isset( $args ) && is_array( $args ) ? $args : array();
$args = wp_parse_args(
	$args,
	array(
		'items' => array(),
		'toc'   => false,
	)
);

$items = is_array( $args['items'] ) ? $args['items'] : array();
if ( empty( $items ) ) {
	return;
}
?>
<nav class="subnav" aria-label="<?php esc_attr_e( 'On this page', 'restwell-retreats' ); ?>"<?php echo ! empty( $args['toc'] ) ? ' data-toc' : ''; ?>>
	<div class="container">
		<ul class="subnav__list">
			<?php foreach ( $items as $item ) : ?>
				<li>
					<a href="<?php echo esc_url( (string) $item['url'] ); ?>"><?php echo esc_html( (string) $item['label'] ); ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</nav>
