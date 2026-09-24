<?php
/**
 * Keep the pricing Dates links useful when the live diary is unavailable.
 *
 * @package Restwell_Retreats
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="section-y section-y--compact band-subtle" id="availability" aria-labelledby="availability-h">
	<div class="container availability-unavailable">
		<header class="section-head section-head--tight">
			<p class="eyebrow"><?php esc_html_e( 'Your dates', 'restwell-retreats' ); ?></p>
			<h2 id="availability-h"><?php esc_html_e( 'Let’s find a time for your stay', 'restwell-retreats' ); ?></h2>
			<p class="lede"><?php esc_html_e( 'The online calendar is currently unavailable. Send us your preferred dates and we’ll check availability for you.', 'restwell-retreats' ); ?></p>
		</header>
		<a class="btn btn-gold" href="<?php echo esc_url( home_url( '/enquire/' ) ); ?>"><?php esc_html_e( 'Ask about your dates', 'restwell-retreats' ); ?></a>
	</div>
</section>
