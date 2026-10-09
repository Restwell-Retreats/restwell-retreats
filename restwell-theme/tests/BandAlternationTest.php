<?php
/**
 * Neighbouring sections must not share a band background.
 *
 * The theme fuses two consecutive .band-white (or .band-subtle) sections into
 * one field (shared.css, "Two neighbouring sections on the same background
 * read as one"), so two different pieces of content look like a single block.
 * Alternate band-white and band-subtle down every page template.
 *
 * Reads the templates in file order and resolves the partials that print a
 * whole section. A section with no band class (a hero, a teal CTA) resets the
 * run.
 *
 * @package Restwell_Retreats
 */

class BandAlternationTest extends PHPUnit\Framework\TestCase {

	private const BANDS = array( 'band-white', 'band-subtle' );

	/**
	 * Section bands in the order a template prints them.
	 *
	 * @param string $source Template source.
	 * @return array<int, array{id: string, band: string}>
	 */
	private function sections( string $source ): array {
		$theme = dirname( __DIR__ );
		$found = array();

		preg_match_all( '/<section\b([^>]*)>|get_template_part\(\s*\'template-parts\/(sister-company|availability-calendar)\'(.*?)\);/s', $source, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE );

		foreach ( $matches as $m ) {
			$offset = $m[0][1];
			if ( '' !== $m[1][0] || '<' === $m[0][0][0] ) {
				$attrs = $m[1][0];
				$class = preg_match( '/class="([^"]*)"/', $attrs, $c ) ? $c[1] : '';
				$id    = preg_match( '/\bid="([^"]*)"/', $attrs, $i ) ? $i[1] : ( preg_match( '/aria-labelledby="([^"]*)"/', $attrs, $a ) ? $a[1] : '?' );
				$band  = '';
				foreach ( self::BANDS as $candidate ) {
					if ( in_array( $candidate, preg_split( '/\s+/', $class ), true ) ) {
						$band = $candidate;
					}
				}
				$found[ $offset ] = array( 'id' => $id, 'band' => $band );
				continue;
			}
			$part = $m[2][0];
			$args = $m[3][0];
			if ( 'sister-company' === $part ) {
				$band = preg_match( "/'band'\s*=>\s*'(band-[a-z]+)'/", $args, $b ) ? $b[1] : 'band-white';
				$id   = preg_match( "/'id'\s*=>\s*'([^']+)'/", $args, $i ) ? $i[1] : 'sister-company';
			} else {
				$partial = (string) file_get_contents( $theme . '/template-parts/availability-calendar.php' );
				$band    = '';
				foreach ( self::BANDS as $candidate ) {
					if ( false !== strpos( $partial, $candidate ) ) {
						$band = $candidate;
					}
				}
				$id = 'availability';
			}
			$found[ $offset ] = array( 'id' => $id, 'band' => $band );
		}

		ksort( $found );
		return array_values( $found );
	}

	public function test_neighbouring_sections_alternate_bands() {
		$theme = dirname( __DIR__ );
		$files = array_merge( (array) glob( $theme . '/template-*.php' ), array( $theme . '/front-page.php', $theme . '/page-guest-guide.php' ) );
		$this->assertNotEmpty( $files );

		$collisions = array();
		foreach ( $files as $file ) {
			$sections = $this->sections( (string) file_get_contents( $file ) );
			foreach ( $sections as $n => $section ) {
				if ( 0 === $n || '' === $section['band'] ) {
					continue;
				}
				$prev = $sections[ $n - 1 ];
				if ( $prev['band'] === $section['band'] ) {
					$collisions[] = basename( $file ) . ': #' . $prev['id'] . ' and #' . $section['id'] . ' are both ' . $section['band'];
				}
			}
		}

		$this->assertSame( array(), $collisions, "Neighbouring sections share a band, so they read as one block:\n" . implode( "\n", $collisions ) );
	}
}
