<?php
/**
 * Footer template — mockup chrome (partner + legal; mid-cta lives on pages).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$legal_entity_name = (string) get_option( 'restwell_footer_legal_name', __( 'Homely Housing Investments Ltd t/a Restwell Retreats', 'restwell-retreats' ) );

$footer_partner_url = trim( (string) get_option( 'restwell_footer_partner_url', 'https://www.continuitycareservices.co.uk/' ) );
if ( $footer_partner_url === '' ) {
	$footer_partner_url = 'https://www.continuitycareservices.co.uk/';
}
$footer_cqc_profile_url = trim( (string) get_option( 'restwell_footer_cqc_profile_url', 'https://www.cqc.org.uk/location/1-2624556588' ) );
if ( $footer_cqc_profile_url === '' ) {
	$footer_cqc_profile_url = 'https://www.cqc.org.uk/location/1-2624556588';
}

$logo_url = function_exists( 'restwell_get_logo_url' ) ? restwell_get_logo_url( 'restwell_logo_long_id', 'long_logo.png' ) : '';
$brand    = function_exists( 'restwell_site_brand_lockup' ) ? restwell_site_brand_lockup() : get_bloginfo( 'name' );

$faq_url      = function_exists( 'restwell_nav_resolve_page_url' ) ? restwell_nav_resolve_page_url( 'faq' ) : home_url( '/faq/' );
$privacy_url  = function_exists( 'restwell_nav_resolve_page_url' ) ? restwell_nav_resolve_page_url( 'privacy-policy' ) : home_url( '/privacy-policy/' );
$terms_url    = function_exists( 'restwell_nav_resolve_page_url' ) ? restwell_nav_resolve_page_url( 'terms-and-conditions' ) : home_url( '/terms-and-conditions/' );
$a11y_pol_url = function_exists( 'restwell_nav_resolve_page_url' ) ? restwell_nav_resolve_page_url( 'accessibility-policy' ) : home_url( '/accessibility-policy/' );
?>
<footer class="site-footer">
	<div class="container">
		<div class="site-footer__brand">
			<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php if ( $logo_url ) : ?>
					<img
						src="<?php echo esc_url( $logo_url ); ?>"
						alt="<?php echo esc_attr( $brand ); ?>"
						class="site-logo__img"
						width="282"
						height="44"
					>
				<?php else : ?>
					<?php echo esc_html( $brand ); ?>
				<?php endif; ?>
			</a>
			<p class="site-footer__partner-line">
				<?php esc_html_e( 'Care partner:', 'restwell-retreats' ); ?>
				<a href="<?php echo esc_url( $footer_partner_url ); ?>" target="_blank" rel="noopener noreferrer">
					<?php esc_html_e( 'Continuity of Care Services', 'restwell-retreats' ); ?><span class="sr-only"> <?php esc_html_e( '(opens in new tab)', 'restwell-retreats' ); ?></span>
				</a>
			</p>
			<p class="site-footer__partner-line">
				<a href="<?php echo esc_url( $footer_cqc_profile_url ); ?>" target="_blank" rel="noopener noreferrer">
					<?php esc_html_e( 'CQC inspection profile', 'restwell-retreats' ); ?><span class="sr-only"> <?php esc_html_e( '(opens in new tab)', 'restwell-retreats' ); ?></span>
				</a>
			</p>
			<p class="site-footer__partner-line"><?php esc_html_e( 'Accessible holidays, Whitstable, Kent', 'restwell-retreats' ); ?></p>
		</div>
		<div class="site-footer__bottom">
			<nav class="site-footer__legal" aria-label="<?php esc_attr_e( 'Legal', 'restwell-retreats' ); ?>">
				<a href="<?php echo esc_url( $faq_url ); ?>"><?php esc_html_e( 'FAQ', 'restwell-retreats' ); ?></a>
				<a href="<?php echo esc_url( $privacy_url ); ?>"><?php esc_html_e( 'Privacy Policy', 'restwell-retreats' ); ?></a>
				<a href="<?php echo esc_url( $terms_url ); ?>"><?php esc_html_e( 'Terms &amp; Conditions', 'restwell-retreats' ); ?></a>
				<a href="<?php echo esc_url( $a11y_pol_url ); ?>"><?php esc_html_e( 'Website accessibility', 'restwell-retreats' ); ?></a>
			</nav>
			<p class="site-footer__copyright">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( $legal_entity_name ); ?>. <?php esc_html_e( 'All rights reserved.', 'restwell-retreats' ); ?></p>
		</div>
	</div>
	<?php wp_footer(); ?>
</footer>
<div class="lightbox" id="gallery-lightbox" hidden role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Photo gallery', 'restwell-retreats' ); ?>">
	<button type="button" class="lightbox__close" data-lightbox-close>
		<svg viewBox="0 0 16 16" aria-hidden="true" focusable="false">
			<path d="M3.2 3.2l9.6 9.6M12.8 3.2L3.2 12.8" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
		</svg>
		<?php esc_html_e( 'Close', 'restwell-retreats' ); ?>
	</button>
	<div class="lightbox__stage">
		<button type="button" class="lightbox__nav lightbox__nav--prev" data-lightbox-prev aria-label="<?php esc_attr_e( 'Previous image', 'restwell-retreats' ); ?>">
			<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
				<path d="M15 5L8 12l7 7" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>
		</button>
		<figure class="lightbox__figure">
			<img class="lightbox__image" data-lightbox-image src="" alt="<?php echo esc_attr__( 'Gallery image', 'restwell-retreats' ); ?>" decoding="async" />
		</figure>
		<button type="button" class="lightbox__nav lightbox__nav--next" data-lightbox-next aria-label="<?php esc_attr_e( 'Next image', 'restwell-retreats' ); ?>">
			<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
				<path d="M9 5l7 7-7 7" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>
		</button>
	</div>
	<div class="lightbox__meta">
		<p class="lightbox__status" data-lightbox-status aria-live="polite"></p>
		<p class="lightbox__caption" data-lightbox-caption></p>
	</div>
</div>
<button type="button" class="scroll-top" data-scroll-top hidden aria-label="<?php esc_attr_e( 'Back to top', 'restwell-retreats' ); ?>">
	<svg viewBox="0 0 16 16" aria-hidden="true" focusable="false">
		<path d="M8 12.8V3.2M3.6 7.6L8 3.2l4.4 4.4" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
	</svg>
</button>
</body>
</html>
