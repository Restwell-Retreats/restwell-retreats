<?php
/**
 * Non-modal cookie banner (consent-gated analytics).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'restwell_cookie_consent_is_gated' ) || ! restwell_cookie_consent_is_gated() ) {
	return;
}

$privacy_url = function_exists( 'restwell_nav_resolve_page_url' )
	? restwell_nav_resolve_page_url( 'privacy-policy' )
	: home_url( '/privacy-policy/' );
$has_choice  = function_exists( 'restwell_cookie_consent_has_choice' ) && restwell_cookie_consent_has_choice();
?>
<div
	id="restwell-cookie-banner"
	class="cookie-banner"
	role="region"
	aria-labelledby="restwell-cookie-banner-title"
	data-cookie-banner
	<?php echo $has_choice ? ' hidden' : ''; ?>
>
	<div class="cookie-banner__inner">
		<div class="cookie-banner__copy">
			<p id="restwell-cookie-banner-title" class="cookie-banner__title"><?php esc_html_e( 'Cookies', 'restwell-retreats' ); ?></p>
			<p class="cookie-banner__text">
				<?php esc_html_e( 'Essential cookies keep the site working. Optional analytics cookies stay off unless you accept them.', 'restwell-retreats' ); ?>
				<a class="cookie-banner__link" href="<?php echo esc_url( $privacy_url ); ?>"><?php esc_html_e( 'Privacy Policy', 'restwell-retreats' ); ?></a>
			</p>
			<p class="sr-only" data-cookie-status aria-live="polite"></p>
		</div>
		<div class="cookie-banner__actions">
			<button type="button" class="btn btn-outline-light" data-cookie-reject><?php esc_html_e( 'Reject analytics', 'restwell-retreats' ); ?></button>
			<button type="button" class="btn btn-outline-light" data-cookie-accept><?php esc_html_e( 'Accept analytics', 'restwell-retreats' ); ?></button>
		</div>
	</div>
</div>
