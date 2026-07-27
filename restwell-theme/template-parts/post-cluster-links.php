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

$link_class = 'text-[var(--deep-teal)] text-sm font-semibold hover:underline no-underline';
?>
<section class="blog-single__cluster-links border-t border-gray-100 pt-8 mt-2" aria-labelledby="restwell-cluster-links-heading">
	<h2 id="restwell-cluster-links-heading" class="sr-only"><?php esc_html_e( 'Related Restwell guides', 'restwell-retreats' ); ?></h2>

	<?php if ( $pillar_url !== '' && $pillar_title !== '' ) : ?>
		<p class="m-0 mb-4 text-sm text-gray-700 leading-relaxed">
			<?php esc_html_e( 'Part of:', 'restwell-retreats' ); ?>
			<a href="<?php echo esc_url( $pillar_url ); ?>" class="<?php echo esc_attr( $link_class ); ?>">
				<?php echo esc_html( $pillar_title ); ?>
			</a>
		</p>
	<?php endif; ?>

	<?php if ( ! empty( $siblings ) ) : ?>
		<div class="mb-4">
			<p class="text-xs font-semibold uppercase tracking-[0.12em] text-[var(--muted-grey)] m-0 mb-2"><?php esc_html_e( 'More in this topic', 'restwell-retreats' ); ?></p>
			<ul class="space-y-2 m-0 list-none p-0">
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
					<li>
						<a href="<?php echo esc_url( $sib_url ); ?>" class="<?php echo esc_attr( $link_class ); ?>">
							<?php echo esc_html( $sib_title ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>

	<?php if ( ! empty( $conversion ) ) : ?>
		<div>
			<p class="text-xs font-semibold uppercase tracking-[0.12em] text-[var(--muted-grey)] m-0 mb-2"><?php esc_html_e( 'Next steps', 'restwell-retreats' ); ?></p>
			<ul class="space-y-2 m-0 list-none p-0">
				<?php foreach ( $conversion as $item ) : ?>
					<?php
					if ( empty( $item['url'] ) || empty( $item['label'] ) ) {
						continue;
					}
					?>
					<li>
						<a href="<?php echo esc_url( $item['url'] ); ?>" class="<?php echo esc_attr( $link_class ); ?>">
							<?php echo esc_html( $item['label'] ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>
</section>
