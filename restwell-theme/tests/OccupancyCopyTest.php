<?php
/**
 * Occupancy marketing must stay unpublished until iCal/facts exist.
 *
 * @package Restwell_Retreats
 */

class OccupancyCopyTest extends PHPUnit\Framework\TestCase {

	/**
	 * Phrases from docs/seo/LANES.md that must not appear in live templates or briefs.
	 *
	 * @return string[]
	 */
	private function banned_fragments(): array {
		return array(
			'leftover night',
			'last-minute stock',
			'last minute stock',
			'christmas spaces',
		);
	}

	public function test_public_templates_and_briefs_have_no_occupancy_offers() {
		$theme = dirname( __DIR__ );
		$paths = array_merge(
			glob( $theme . '/template-*.php' ) ?: array(),
			glob( $theme . '/front-page.php' ) ?: array(),
			glob( $theme . '/page-*.php' ) ?: array(),
			glob( $theme . '/copy-overwrites/*.md' ) ?: array(),
			array( $theme . '/template-parts/availability-calendar.php' )
		);
		$this->assertNotEmpty( $paths );

		$banned = $this->banned_fragments();
		$hits   = array();
		foreach ( $paths as $path ) {
			$hay = strtolower( (string) file_get_contents( $path ) );
			foreach ( $banned as $needle ) {
				if ( false !== strpos( $hay, $needle ) ) {
					$hits[] = basename( $path ) . ': ' . $needle;
				}
			}
		}
		$this->assertSame( array(), $hits );
	}

	public function test_diary_is_not_a_dark_tile_widget() {
		$theme = dirname( __DIR__ );
		$cal   = (string) file_get_contents( $theme . '/template-parts/availability-calendar.php' );
		$css   = (string) file_get_contents( $theme . '/assets/css/shared.css' );
		$js    = (string) file_get_contents( $theme . '/assets/js/availability.js' );
		$this->assertStringNotContainsString( 'band-teal', $cal );
		$this->assertStringNotContainsString( 'availability-tile', $css );
		$this->assertStringNotContainsString( '.band-teal .availability', $css );
		$this->assertStringNotContainsString( 'availability__swatch', $cal );
		$this->assertStringNotContainsString( 'availability__peaks', $cal );
		$this->assertStringContainsString( 'availability__stay', $cal );
		$this->assertStringContainsString( 'availability__price', $cal );
		$this->assertStringContainsString( 'availability__key-mark', $cal );
		$this->assertStringContainsString( 'availability__stay-times', $cal );
		$this->assertStringContainsString( 'availability__stay-count', $cal );
		$this->assertStringContainsString( 'availability__quote', $cal );
		$this->assertStringNotContainsString( 'House diary', $cal );
		$this->assertStringContainsString( 'btn-outline-teal', $cal );
		$this->assertStringNotContainsString( 'availability__cta-skip', $cal );
		$this->assertStringContainsString( 'availability__layout', $css );
		$this->assertStringContainsString( 'guideTotal', $js );
		$this->assertStringContainsString( 'fillBreakdown', $js );
		$this->assertStringContainsString( 'data-rate', $js );
		$this->assertStringContainsString( 'Tap another night to stay longer.', $js );
		$this->assertStringNotContainsString( 'click it again', $js );
		$this->assertStringNotContainsString( 'Click a last night', $js );
	}

	public function test_pricing_page_is_named_pricing_and_dates() {
		$theme = dirname( __DIR__ );
		$nav   = (string) file_get_contents( $theme . '/inc/nav.php' );
		$page  = (string) file_get_contents( $theme . '/template-pricing.php' );
		$enq   = (string) file_get_contents( $theme . '/template-enquire.php' );
		$this->assertStringContainsString( "'Pricing & dates'", $nav );
		$this->assertStringContainsString( "'label' => 'Pricing & dates'", $page );
		$this->assertStringContainsString( 'Pricing & dates', $enq );
		$this->assertStringNotContainsString( 'Pricing page', $enq );
	}
}
