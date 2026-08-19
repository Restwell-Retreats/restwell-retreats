<?php
/**
 * Concept interior hero (crumbs + H1 + lede). No photo scrim.
 *
 * @package Restwell_Retreats
 *
 * @param array $args {
 *     @type string $heading_id H1 id.
 *     @type string $heading    H1 text.
 *     @type string $intro      Lede paragraph.
 *     @type string $eyebrow    Optional eyebrow (rarely used on interiors).
 *     @type array  $crumbs     Optional list of array( 'label' => '', 'url' => '' ); last item current.
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = isset( $args ) && is_array( $args ) ? $args : array();
$args = wp_parse_args(
	$args,
	array(
		'heading_id' => 'page-h',
		'heading'    => '',
		'intro'      => '',
		'eyebrow'    => '',
		'crumbs'     => array(),
	)
);

$heading_id = (string) $args['heading_id'];
$heading    = (string) $args['heading'];
$intro      = (string) $args['intro'];
$eyebrow    = (string) $args['eyebrow'];
$crumbs     = is_array( $args['crumbs'] ) ? $args['crumbs'] : array();

if ( $heading === '' ) {
	return;
}
?>
<section class="hero hero--interior" aria-labelledby="<?php echo esc_attr( $heading_id ); ?>">
	<div class="container">
		<div class="hero__content">
			<?php if ( ! empty( $crumbs ) ) : ?>
				<ol class="breadcrumb">
					<?php
					$crumb_count = count( $crumbs );
					foreach ( $crumbs as $i => $crumb ) :
						$label = isset( $crumb['label'] ) ? (string) $crumb['label'] : '';
						$url   = isset( $crumb['url'] ) ? (string) $crumb['url'] : '';
						$last  = ( $i === $crumb_count - 1 );
						if ( $i > 0 ) :
							?>
							<li class="breadcrumb__sep" aria-hidden="true">/</li>
						<?php endif; ?>
						<?php if ( $last || $url === '' ) : ?>
							<li aria-current="page"><?php echo esc_html( $label ); ?></li>
						<?php else : ?>
							<li><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $label ); ?></a></li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ol>
			<?php endif; ?>
			<div class="hero__text">
				<?php if ( $eyebrow !== '' ) : ?>
					<p class="eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
				<?php endif; ?>
				<h1 id="<?php echo esc_attr( $heading_id ); ?>"><?php echo esc_html( $heading ); ?></h1>
				<?php if ( $intro !== '' ) : ?>
					<p><?php echo esc_html( $intro ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
