<?php
/**
 * Concept photo hero — homepage-style media plane + crumbs + H1 + lede.
 *
 * @package Restwell_Retreats
 *
 * @param array $args {
 *     @type string $heading_id H1 id.
 *     @type string $heading    H1 text.
 *     @type string $eyebrow    Optional eyebrow above the H1.
 *     @type string $intro      Lede paragraph.
 *     @type array  $crumbs     Optional list of array( 'label' => '', 'url' => '' ); last item current.
 *     @type int    $media_id   Optional attachment ID (0 = resolve from page / stock).
 *     @type string $image_url  Optional absolute image URL override.
 *     @type string $image_alt  Optional alt text override.
 *     @type string $overlay    Optional 'heavy' for a darker bottom-up scrim (enquire photo hero).
 *     @type int    $post_id    Page ID for Featured/stock resolution (default queried object).
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
		'eyebrow'    => '',
		'intro'      => '',
		'crumbs'     => array(),
		'media_id'   => 0,
		'image_url'  => '',
		'image_alt'  => '',
		'overlay'    => '',
		'post_id'    => 0,
	)
);

$heading_id = (string) $args['heading_id'];
$heading    = (string) $args['heading'];
$eyebrow    = trim( (string) $args['eyebrow'] );
$intro      = (string) $args['intro'];
$crumbs     = is_array( $args['crumbs'] ) ? $args['crumbs'] : array();
$media_id   = absint( $args['media_id'] );
$image_url  = trim( (string) $args['image_url'] );
$image_alt  = trim( (string) $args['image_alt'] );
$overlay    = sanitize_key( (string) $args['overlay'] );
$post_id    = absint( $args['post_id'] );

if ( $heading === '' ) {
	return;
}

if ( $post_id < 1 ) {
	$post_id = (int) get_queried_object_id();
}

if ( $media_id < 1 && $post_id > 0 && function_exists( 'restwell_page_hero_attachment_id' ) ) {
	$media_id = restwell_page_hero_attachment_id( $post_id );
}

if ( $image_url === '' ) {
	if ( $media_id > 0 ) {
		$size = function_exists( 'restwell_pick_attachment_size' )
			? restwell_pick_attachment_size( $media_id, 'restwell-hero', 'large', 'full' )
			: 'full';
		$from_att  = wp_get_attachment_image_url( $media_id, $size );
		$image_url = $from_att ? $from_att : '';
	}
	if ( $image_url === '' && $post_id > 0 && function_exists( 'restwell_page_hero_image_url' ) ) {
		$image_url = restwell_page_hero_image_url( $post_id );
	}
	if ( $image_url === '' && function_exists( 'restwell_theme_image_url' ) ) {
		$image_url = restwell_theme_image_url( 'stock/restwell-whitstable-coastline-panorama.webp' );
	}
}

if ( $image_alt === '' && $media_id > 0 && function_exists( 'restwell_attachment_image_alt' ) ) {
	$image_alt = restwell_attachment_image_alt( $media_id );
}
if ( $image_alt === '' && $post_id > 0 && function_exists( 'restwell_page_hero_image_alt' ) ) {
	$image_alt = restwell_page_hero_image_alt( $post_id, $heading );
}
if ( $image_alt === '' && function_exists( 'restwell_theme_image_alt' ) ) {
	$image_alt = restwell_theme_image_alt( 'stock/restwell-whitstable-coastline-panorama.webp' );
}
if ( $image_alt === '' ) {
	$image_alt = $heading;
}
$hero_class = 'hero';
if ( 'heavy' === $overlay ) {
	$hero_class .= ' hero--overlay-heavy';
}
?>
<section class="<?php echo esc_attr( $hero_class ); ?>" aria-labelledby="<?php echo esc_attr( $heading_id ); ?>">
	<div class="hero__media">
		<?php if ( $image_url !== '' ) : ?>
			<img
				class="hero__media-img"
				src="<?php echo esc_url( $image_url ); ?>"
				alt="<?php echo esc_attr( $image_alt ); ?>"
				width="1920"
				height="1080"
				decoding="async"
				fetchpriority="high"
			/>
		<?php endif; ?>
	</div>
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
					<p class="eyebrow eyebrow--on-dark"><?php echo esc_html( $eyebrow ); ?></p>
				<?php endif; ?>
				<h1 id="<?php echo esc_attr( $heading_id ); ?>"><?php echo esc_html( $heading ); ?></h1>
				<?php if ( $intro !== '' ) : ?>
					<p><?php echo esc_html( $intro ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
