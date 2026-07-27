<?php
/**
 * Related guides module (pillar → cluster posts, sibling pillars, conversion).
 *
 * Expects query var `restwell_related_guides`.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$data = get_query_var( 'restwell_related_guides', array() );
if ( ! is_array( $data ) ) {
	return;
}

$heading        = isset( $data['heading'] ) ? (string) $data['heading'] : __( 'Related guides', 'restwell-retreats' );
$intro          = isset( $data['intro'] ) ? (string) $data['intro'] : '';
$heading_id     = isset( $data['heading_id'] ) ? (string) $data['heading_id'] : 'restwell-related-guides-heading';
$posts          = isset( $data['posts'] ) && is_array( $data['posts'] ) ? $data['posts'] : array();
$siblings       = isset( $data['siblings'] ) && is_array( $data['siblings'] ) ? $data['siblings'] : array();
$conversion     = isset( $data['conversion'] ) && is_array( $data['conversion'] ) ? $data['conversion'] : array();
$category_url   = isset( $data['category_url'] ) ? (string) $data['category_url'] : '';
$category_name  = isset( $data['category_name'] ) ? (string) $data['category_name'] : '';

if ( empty( $posts ) && empty( $siblings ) && empty( $conversion ) ) {
	return;
}

$link_class = 'rw-link-prose';
?>
<section class="rw-section-y--compact bg-white border-t border-gray-100" aria-labelledby="<?php echo esc_attr( $heading_id ); ?>">
	<div class="container max-w-3xl">
		<h2 id="<?php echo esc_attr( $heading_id ); ?>" class="text-2xl font-serif text-[var(--deep-teal)] mb-6 m-0"><?php echo esc_html( $heading ); ?></h2>
		<?php if ( $intro !== '' ) : ?>
			<p class="text-gray-600 mb-6 leading-relaxed"><?php echo esc_html( $intro ); ?></p>
		<?php endif; ?>

		<?php if ( ! empty( $posts ) ) : ?>
			<ul class="space-y-3 m-0 list-none p-0">
				<?php foreach ( $posts as $guide_post ) : ?>
					<?php
					if ( ! $guide_post instanceof WP_Post ) {
						continue;
					}
					$guide_url   = get_permalink( $guide_post );
					$guide_title = get_the_title( $guide_post );
					if ( ! $guide_url || $guide_title === '' ) {
						continue;
					}
					?>
					<li>
						<a href="<?php echo esc_url( $guide_url ); ?>" class="<?php echo esc_attr( $link_class ); ?>">
							<?php echo esc_html( $guide_title ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

		<?php if ( $category_url !== '' && $category_name !== '' ) : ?>
			<p class="mt-6 mb-0 text-sm text-gray-600 leading-relaxed">
				<a href="<?php echo esc_url( $category_url ); ?>" class="<?php echo esc_attr( $link_class ); ?>">
					<?php
					echo esc_html(
						sprintf(
							/* translators: %s: category name */
							__( 'Browse all articles in %s', 'restwell-retreats' ),
							$category_name
						)
					);
					?>
				</a>
			</p>
		<?php endif; ?>

		<?php if ( ! empty( $siblings ) ) : ?>
			<div class="mt-8 pt-6 border-t border-gray-100">
				<h3 class="text-lg font-serif text-[var(--deep-teal)] mb-3 m-0"><?php esc_html_e( 'Also on Restwell', 'restwell-retreats' ); ?></h3>
				<ul class="space-y-3 m-0 list-none p-0">
					<?php foreach ( $siblings as $sib ) : ?>
						<?php
						if ( empty( $sib['url'] ) || empty( $sib['label'] ) ) {
							continue;
						}
						?>
						<li>
							<a href="<?php echo esc_url( $sib['url'] ); ?>" class="<?php echo esc_attr( $link_class ); ?>">
								<?php echo esc_html( $sib['label'] ); ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $conversion ) ) : ?>
			<div class="mt-8 pt-6 border-t border-gray-100">
				<h3 class="text-lg font-serif text-[var(--deep-teal)] mb-3 m-0"><?php esc_html_e( 'Plan your stay', 'restwell-retreats' ); ?></h3>
				<ul class="space-y-3 m-0 list-none p-0">
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
	</div>
</section>
