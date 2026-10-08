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
<section class="section-y section-y--compact band-white" aria-labelledby="restwell-pricing-links-heading">
	<div class="container">
		<header class="section-head section-head--tight">
			<h2 id="restwell-pricing-links-heading"><?php esc_html_e( 'Related Restwell pages', 'restwell-retreats' ); ?></h2>
			<p class="lede"><?php esc_html_e( 'Before you enquire, these pages cover the property, access detail, funding routes, and how to get in touch.', 'restwell-retreats' ); ?></p>
		</header>
		<ul class="link-list">
			<?php foreach ( $items as $item ) : ?>
				<?php
				if ( empty( $item['url'] ) || empty( $item['label'] ) ) {
					continue;
				}
				?>
				<li><a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
