<?php
/**
 * SEO: GA4, Metricool, Bing verification, and analytics loader enqueue.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function restwell_get_analytics_load_mode() {
	$mode = (string) get_option( 'restwell_analytics_load_mode', 'head' );
	$allowed = array( 'head', 'footer_deferred', 'consent_gated' );
	return in_array( $mode, $allowed, true ) ? $mode : 'head';
}

/**
 * Sanitized GA4 measurement ID or empty.
 *
 * @return string
 */
function restwell_analytics_ga4_measurement_id_sanitized() {
	$mid = (string) get_option( 'restwell_ga4_measurement_id', '' );
	$mid = preg_replace( '/[^G0-9A-Za-z\-]/', '', $mid );
	if ( $mid === '' || strpos( $mid, 'G-' ) !== 0 ) {
		return '';
	}
	return $mid;
}

/**
 * Sanitized Metricool hash or empty.
 *
 * @return string
 */
function restwell_analytics_metricool_hash_sanitized() {
	$hash = (string) get_option( 'restwell_metricool_hash', '' );
	$hash = preg_replace( '/[^0-9A-Za-z]/', '', strtolower( $hash ) );
	return preg_match( '/^[a-f0-9]{32}$/i', $hash ) ? $hash : '';
}

/**
 * Whether analytics scripts are routed through the footer loader (defer / CMP).
 *
 * @return bool
 */
function restwell_analytics_use_footer_loader() {
	if ( 'head' === restwell_get_analytics_load_mode() ) {
		return false;
	}
	return restwell_analytics_ga4_measurement_id_sanitized() !== '' || restwell_analytics_metricool_hash_sanitized() !== '';
}

/**
 * Consent Mode defaults before gtag loads (consent_gated + GA4 only).
 */
function restwell_output_ga4_consent_default() {
	if ( 'consent_gated' !== restwell_get_analytics_load_mode() ) {
		return;
	}
	if ( ! restwell_analytics_use_footer_loader() ) {
		return;
	}
	$mid = restwell_analytics_ga4_measurement_id_sanitized();
	if ( $mid === '' ) {
		return;
	}
	?>
<script<?php echo restwell_csp_script_nonce_attr(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('consent', 'default', {
	analytics_storage: 'denied',
	ad_storage: 'denied',
	ad_user_data: 'denied',
	ad_personalization: 'denied',
	wait_for_update: 500
});
</script>
	<?php
}
add_action( 'wp_head', 'restwell_output_ga4_consent_default', 1 );

/**
 * Enqueue deferred / consent-gated analytics loader (GA4 + Metricool).
 */
function restwell_enqueue_analytics_loader() {
	if ( is_admin() || ! restwell_analytics_use_footer_loader() ) {
		return;
	}

	$theme_uri = get_template_directory_uri();
	$use_min   = ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG );
	$loader_js = $use_min ? '/assets/js/analytics-loader.min.js' : '/assets/js/analytics-loader.js';
	$loader_ver = function_exists( 'restwell_theme_asset_version' )
		? restwell_theme_asset_version( $loader_js )
		: (string) wp_get_theme()->get( 'Version' );

	wp_enqueue_script(
		'restwell-analytics-loader',
		$theme_uri . $loader_js,
		array(),
		$loader_ver,
		true
	);

	$mode = restwell_get_analytics_load_mode();
	wp_localize_script(
		'restwell-analytics-loader',
		'restwellAnalytics',
		array(
			'loadMode'      => 'footer_deferred' === $mode ? 'footer_deferred' : 'consent_gated',
			'consentGated'  => ( 'consent_gated' === $mode ),
			'gaId'          => restwell_analytics_ga4_measurement_id_sanitized(),
			'metricoolHash' => restwell_analytics_metricool_hash_sanitized(),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'restwell_enqueue_analytics_loader', 25 );

/**
 * Output Google Analytics 4 gtag when measurement ID is set (head mode only).
 */
function restwell_output_ga4() {
	if ( restwell_analytics_use_footer_loader() ) {
		return;
	}

	$mid = restwell_analytics_ga4_measurement_id_sanitized();
	if ( $mid === '' ) {
		return;
	}
	?>
	<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr( $mid ); ?>"></script>
<script<?php echo restwell_csp_script_nonce_attr(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', '<?php echo esc_js( $mid ); ?>');
</script>
	<?php
}
add_action( 'wp_head', 'restwell_output_ga4', 20 );

/**
 * Output Metricool tracking snippet when a hash is set (head mode only).
 */
function restwell_output_metricool_tracker() {
	if ( restwell_analytics_use_footer_loader() ) {
		return;
	}

	$hash = restwell_analytics_metricool_hash_sanitized();
	if ( $hash === '' ) {
		return;
	}
	?>
<script<?php echo restwell_csp_script_nonce_attr(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
function loadScript(a){
var b=document.getElementsByTagName("head")[0],c=document.createElement("script");
c.type="text/javascript",c.src="https://tracker.metricool.com/resources/be.js",c.onreadystatechange=a,c.onload=a,b.appendChild(c)}
loadScript(function(){beTracker.t({hash:"<?php echo esc_js( $hash ); ?>"})});
</script>
	<?php
}
add_action( 'wp_head', 'restwell_output_metricool_tracker', 20 );

/**
 * Bing Webmaster Tools verification meta tag.
 */
function restwell_output_bing_verification() {
	$token = (string) get_option( 'restwell_bing_verification', '' );
	$token = preg_replace( '/[^0-9A-Za-z]/', '', $token );
	if ( $token === '' ) {
		return;
	}
	echo '<meta name="msvalidate.01" content="' . esc_attr( $token ) . '">' . "\n";
}
add_action( 'wp_head', 'restwell_output_bing_verification', 1 );

// ---------------------------------------------------------------------------
// 2. OG + Twitter Card meta tags
// ---------------------------------------------------------------------------
// Moved to inc/seo-social-meta.php to keep this file focused on canonical + JSON-LD.

// ---------------------------------------------------------------------------
// 3. JSON-LD structured data
// ---------------------------------------------------------------------------

/**
 * Stable @id for the Organization entity (matches GBP / registered address).
 *
 * @return string Absolute URL with fragment.
 */
