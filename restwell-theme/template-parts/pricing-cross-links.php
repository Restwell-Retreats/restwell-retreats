<?php
/**
 * Pricing page cross-links (Job 11 hub outbound links).
 *
 * Expects query var `restwell_pricing_cross_links`.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$items = get_query_var( 'restwell_pricing_cross_links', array() );
if ( ! is_array( $items ) || empty( $items ) ) {
	return;
}
?>
<section class="rw-section-y--compact border-t border-gray-100 mt-8" aria-labelledby="restwell-pricing-links-heading">
	<div class="max-w-3xl">
		<h2 id="restwell-pricing-links-heading" class="text-2xl font-serif text-[var(--deep-teal)] mb-4 m-0"><?php esc_html_e( 'Related Restwell pages', 'restwell-retreats' ); ?></h2>
		<p class="text-gray-600 mb-6 leading-relaxed"><?php esc_html_e( 'Before you enquire, these pages cover the property, access detail, funding routes, and how to get in touch.', 'restwell-retreats' ); ?></p>
		<ul class="space-y-3 m-0 list-none p-0">
			<?php foreach ( $items as $item ) : ?>
				<?php
				if ( empty( $item['url'] ) || empty( $item['label'] ) ) {
					continue;
				}
				?>
				<li>
					<a href="<?php echo esc_url( $item['url'] ); ?>" class="rw-link-prose">
						<?php echo esc_html( $item['label'] ); ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
