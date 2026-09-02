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
			glob( $theme . '/copy-overwrites/*.md' ) ?: array()
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
}
