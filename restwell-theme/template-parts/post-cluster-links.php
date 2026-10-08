<?php
/**
 * Single post: Part of [pillar] + sibling cluster guides.
 *
 * Expects query var `restwell_post_cluster_links`.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$data = get_query_var( 'restwell_post_cluster_links', array() );
if ( ! is_array( $data ) ) {
	return;
}

$pillar_url   = isset( $data['pillar_url'] ) ? (string) $data['pillar_url'] : '';
$pillar_title = isset( $data['pillar_title'] ) ? (string) $data['pillar_title'] : '';
$siblings     = isset( $data['siblings'] ) && is_array( $data['siblings'] ) ? $data['siblings'] : array();
$conversion   = isset( $data['conversion'] ) && is_array( $data['conversion'] ) ? $data['conversion'] : array();

if ( '' === $pillar_url && empty( $siblings ) && empty( $conversion ) ) {
	return;
}

?>
<section class="blog-cluster-links" aria-labelledby="restwell-cluster-links-heading">
	<h2 id="restwell-cluster-links-heading" class="sr-only"><?php esc_html_e( 'Related Restwell guides', 'restwell-retreats' ); ?></h2>

	<?php if ( $pillar_url !== '' && $pillar_title !== '' ) : ?>
		<p class="blog-cluster-links__part">
			<?php esc_html_e( 'Part of:', 'restwell-retreats' ); ?>
			<a class="text-link" href="<?php echo esc_url( $pillar_url ); ?>"><?php echo esc_html( $pillar_title ); ?></a>
		</p>
	<?php endif; ?>

	<?php if ( ! empty( $siblings ) ) : ?>
		<div class="blog-cluster-links__group">
			<p class="eyebrow"><?php esc_html_e( 'More in this topic', 'restwell-retreats' ); ?></p>
			<ul class="link-list">
				<?php foreach ( $siblings as $sib_post ) : ?>
					<?php
					if ( ! $sib_post instanceof WP_Post ) {
						continue;
					}
					$sib_url   = get_permalink( $sib_post );
					$sib_title = get_the_title( $sib_post );
					if ( ! $sib_url || $sib_title === '' ) {
						continue;
					}
					?>
					<li><a href="<?php echo esc_url( $sib_url ); ?>"><?php echo esc_html( $sib_title ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>

	<?php if ( ! empty( $conversion ) ) : ?>
		<div class="blog-cluster-links__group">
			<p class="eyebrow"><?php esc_html_e( 'Next steps', 'restwell-retreats' ); ?></p>
			<ul class="link-list">
				<?php foreach ( $conversion as $item ) : ?>
					<?php
					if ( empty( $item['url'] ) || empty( $item['label'] ) ) {
						continue;
					}
					?>
					<li><a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>
</section>
