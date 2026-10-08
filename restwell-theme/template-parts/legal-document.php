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

// Contents list for long documents (Terms has 18 sections, audit I46): give
// each H2 an id and list them above the body. Wording is untouched.
$legal_body = wp_kses_post( (string) $args['body_html'] );
$legal_toc  = array();
if ( preg_match_all( '/<h2(\s[^>]*)?>(.*?)<\/h2>/is', $legal_body, $legal_heads ) >= 6 ) {
	$legal_used = array();
	$legal_body = preg_replace_callback(
		'/<h2(\s[^>]*)?>(.*?)<\/h2>/is',
		static function ( $m ) use ( &$legal_toc, &$legal_used ) {
			$attrs = (string) $m[1];
			$label = trim( wp_strip_all_tags( $m[2] ) );
			if ( preg_match( '/\sid=["\']([^"\']+)["\']/', $attrs, $idm ) ) {
				$id = $idm[1];
			} else {
				$base = sanitize_title( $label );
				$id   = $base;
				$n    = 2;
				while ( isset( $legal_used[ $id ] ) ) {
					$id = $base . '-' . $n;
					++$n;
				}
				$attrs .= ' id="' . esc_attr( $id ) . '"';
			}
			$legal_used[ $id ] = true;
			$legal_toc[]       = array( $id, $label );
			return '<h2' . $attrs . '>' . $m[2] . '</h2>';
		},
		$legal_body
	);
}
?>

	<section class="section-y band-white">
	  <div class="container">
		<?php if ( $legal_toc ) : ?>
		<nav class="legal-toc" aria-labelledby="legal-toc-h">
		  <h2 id="legal-toc-h" class="legal-toc__title"><?php esc_html_e( 'On this page', 'restwell-retreats' ); ?></h2>
		  <ol class="legal-toc__list">
			<?php foreach ( $legal_toc as $legal_item ) : ?>
			<li><a href="#<?php echo esc_attr( $legal_item[0] ); ?>"><?php echo esc_html( $legal_item[1] ); ?></a></li>
			<?php endforeach; ?>
		  </ol>
		</nav>
		<?php endif; ?>
		<div class="prose prose--wide">
		  <?php echo $legal_body; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- kses'd above; only id attributes added. ?>
		</div>
	  </div>
	</section>
