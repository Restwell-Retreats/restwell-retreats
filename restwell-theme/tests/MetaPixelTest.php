<?php
/**
 * Meta (Facebook) Pixel: ID handling, Consent-gated only, and a loader that
 * sends PageView and nothing else, with no <noscript> fallback.
 *
 * @package Restwell_Retreats
 */

require_once dirname( __DIR__ ) . '/inc/seo/analytics.php';

class MetaPixelTest extends PHPUnit\Framework\TestCase {

	protected function setUp(): void {
		$GLOBALS['restwell_test_options'] = array();
	}

	public function test_pixel_id_is_digits_only() {
		$this->assertSame( '849444474275220', restwell_analytics_sanitize_meta_pixel_id( ' 849444474275220 ' ) );
		$this->assertSame( '849444474275220', restwell_analytics_sanitize_meta_pixel_id( '8494-4447-4275-220' ) );
		$this->assertSame( '', restwell_analytics_sanitize_meta_pixel_id( 'G-ABC123' ) );
		$this->assertSame( '', restwell_analytics_sanitize_meta_pixel_id( '12345' ), 'Too short to be a pixel ID.' );
		$this->assertSame( '', restwell_analytics_sanitize_meta_pixel_id( '' ) );
	}

	public function test_saved_id_is_read_from_the_option() {
		$this->assertSame( '', restwell_analytics_meta_pixel_id_sanitized() );
		update_option( 'restwell_meta_pixel_id', '849444474275220' );
		$this->assertSame( '849444474275220', restwell_analytics_meta_pixel_id_sanitized() );
	}

	public function test_loader_gets_the_id_in_consent_gated_mode_only() {
		update_option( 'restwell_meta_pixel_id', '849444474275220' );

		update_option( 'restwell_analytics_load_mode', 'consent_gated' );
		$this->assertSame( '849444474275220', restwell_analytics_meta_pixel_id_for_loader() );
		$this->assertTrue( restwell_analytics_use_footer_loader(), 'A Meta Pixel on its own still needs the loader.' );

		foreach ( array( 'footer_deferred', 'head' ) as $mode ) {
			update_option( 'restwell_analytics_load_mode', $mode );
			$this->assertSame( '', restwell_analytics_meta_pixel_id_for_loader(), "No pixel in $mode mode, which loads without consent." );
			$this->assertFalse( restwell_analytics_use_footer_loader() );
		}
	}

	public function test_loader_sends_page_view_only_and_only_after_consent() {
		$js = (string) file_get_contents( dirname( __DIR__ ) . '/assets/js/analytics-loader.js' );

		$this->assertSame( 1, substr_count( $js, 'https://connect.facebook.net/en_US/fbevents.js' ) );
		preg_match_all( "/fbq\\(\\s*'track'\\s*,\\s*'([A-Za-z]+)'/", $js, $tracked );
		$this->assertSame( array( 'PageView' ), $tracked[1], 'PageView is the only Meta event for now.' );
		$this->assertStringContainsString( "fbq('init', pixelId)", $js );

		// The only call to loadMeta() sits in the consent grant, behind the consent-gated flag.
		preg_match_all( '/loadMeta\(cfg\.metaPixelId\)/', $js, $calls, PREG_OFFSET_CAPTURE );
		$this->assertCount( 1, $calls[0] );
		$grant = strpos( $js, 'window.restwellGrantAnalyticsConsent = function' );
		$revoke = strpos( $js, 'window.restwellRevokeAnalyticsConsent = function' );
		$this->assertGreaterThan( $grant, $calls[0][0][1] );
		$this->assertLessThan( $revoke, $calls[0][0][1] );
		$this->assertStringContainsString( 'if (cfg.metaPixelId && cfg.consentGated) {', $js );

		$min = (string) file_get_contents( dirname( __DIR__ ) . '/assets/js/analytics-loader.min.js' );
		$this->assertStringContainsString( 'connect.facebook.net/en_US/fbevents.js', $min, 'Rebuild analytics-loader.min.js after editing the loader.' );
	}

	public function test_no_noscript_pixel_anywhere_in_the_theme() {
		$theme = dirname( __DIR__ );
		$files = array_merge(
			(array) glob( $theme . '/*.php' ),
			(array) glob( $theme . '/inc/*.php' ),
			(array) glob( $theme . '/inc/*/*.php' ),
			(array) glob( $theme . '/template-parts/*.php' ),
			(array) glob( $theme . '/template-parts/*/*.php' )
		);
		foreach ( $files as $file ) {
			$this->assertDoesNotMatchRegularExpression( '#<noscript>[^<]*<img[^>]*facebook\.com/tr#i', (string) file_get_contents( $file ), basename( $file ) );
		}
	}
}
