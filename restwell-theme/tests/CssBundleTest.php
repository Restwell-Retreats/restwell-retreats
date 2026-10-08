<?php
/**
 * site.min.css must be rebuilt (tools/build-css.sh) whenever a source stylesheet changes.
 *
 * @package Restwell_Retreats
 */

class CssBundleTest extends PHPUnit\Framework\TestCase {

	public function test_site_min_css_matches_its_sources() {
		$css = dirname( __DIR__ ) . '/assets/css/';
		$src = '';
		foreach ( array( 'fonts.css', 'shared.css', 'shared-wp.css', 'polish.css' ) as $file ) {
			$src .= (string) file_get_contents( $css . $file ) . "\n";
		}
		$bundle = (string) file_get_contents( $css . 'site.min.css' );
		$this->assertMatchesRegularExpression( '/src-sha1:([0-9a-f]{40})/', $bundle );
		preg_match( '/src-sha1:([0-9a-f]{40})/', $bundle, $m );
		$this->assertSame( sha1( $src ), $m[1], 'site.min.css is stale: run restwell-theme/tools/build-css.sh' );
	}

	/**
	 * Critical CSS is only inlined when built from the current bundle (inc/enqueue.php
	 * falls back to the blocking stylesheet otherwise), so a stale extract silently
	 * loses the first-paint win. Rebuild with tools/build-critical-css.mjs.
	 */
	public function test_critical_css_matches_the_bundle() {
		$css   = dirname( __DIR__ ) . '/assets/css/';
		$files = (array) glob( $css . 'critical/*.min.css' );
		$this->assertNotEmpty( $files, 'No critical CSS: run node restwell-theme/tools/build-critical-css.mjs' );
		preg_match( '/src-sha1:([0-9a-f]{40})/', (string) file_get_contents( $css . 'site.min.css' ), $m );
		foreach ( $files as $file ) {
			$raw = (string) file_get_contents( $file );
			$this->assertStringContainsString( 'source ' . $m[1], strtok( $raw, "\n" ), basename( $file ) . ' is stale: run node restwell-theme/tools/build-critical-css.mjs' );
			$this->assertStringNotContainsString( '@font-face', $raw, basename( $file ) . ' must leave @font-face to the bundle' );
		}
		foreach ( array( 'front', 'post', 'blog', 'utility' ) as $key ) {
			$this->assertFileExists( $css . 'critical/' . $key . '.min.css' );
		}
	}
}
