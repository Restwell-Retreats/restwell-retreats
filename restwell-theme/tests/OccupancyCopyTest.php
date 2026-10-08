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

	/**
	 * Availability board (2026-10 overhaul): light board on a subtle band,
	 * nightly prices on free tiles, booked marked without colour alone, past
	 * occupancy never published, and a named enquiry dialog.
	 */
	public function test_availability_board_design_contract() {
		$theme = dirname( __DIR__ );
		$cal   = (string) file_get_contents( $theme . '/template-parts/availability-calendar.php' );
		$css   = (string) file_get_contents( $theme . '/assets/css/shared.css' );
		$js    = (string) file_get_contents( $theme . '/assets/js/availability.js' );

		// Light board, not a dark tile widget.
		$this->assertStringNotContainsString( 'band-teal', $cal );
		$this->assertStringNotContainsString( '.band-teal .availability', $css );

		// Free nights carry their rate; totals come from the same per-night data.
		$this->assertStringContainsString( 'availability__price', $cal );
		$this->assertStringContainsString( 'data-rate', $js );
		$this->assertStringContainsString( 'guideTotal', $js );
		$this->assertStringContainsString( 'fillBreakdown', $js );

		// Booked is struck through and hatched, not just a paler colour.
		$this->assertStringContainsString( 'text-decoration: line-through', $css );
		$this->assertStringContainsString( 'repeating-linear-gradient', $css );

		// Stay band rounds wherever it starts, ends or wraps a week row.
		$this->assertStringContainsString( 'is-hope-cap-start', $css );
		$this->assertStringContainsString( 'is-hope-cap-end', $js );

		// Only today onward is published.
		$this->assertStringContainsString( '$iso >= $today_iso', $cal );

		// Enquiry dialog has an accessible name; summary and Enquire are present.
		$this->assertStringContainsString( 'aria-labelledby="availability-enquiry-h"', $cal );
		$this->assertStringContainsString( 'data-availability-stay', $cal );
		$this->assertStringContainsString( 'data-availability-enquire', $cal );

		$this->assertStringNotContainsString( 'House diary', $cal );
		$this->assertStringNotContainsString( 'Tap another night to stay longer.', $js );
		$this->assertStringNotContainsString( 'click it again', $js );
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
