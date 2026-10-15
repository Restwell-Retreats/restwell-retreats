<?php
/**
 * Migrations that swap a seeded image or seeded copy must only touch an
 * untouched seed, never something Victoria or Ellie chose in wp-admin.
 *
 * These read the source because the suite runs without WordPress loaded; the
 * behaviour itself was exercised against the playground database.
 *
 * @package Restwell_Retreats
 */

class StockSeedMigrationGuardTest extends PHPUnit\Framework\TestCase {

	private function migrations() {
		return (string) file_get_contents( dirname( __DIR__ ) . '/inc/theme-setup/migrations.php' );
	}

	private function function_body( $source, $name ) {
		$start = strpos( $source, 'function ' . $name . '(' );
		$this->assertNotFalse( $start, $name . ' exists' );
		$end = strpos( $source, "\n}\n", $start );
		return substr( $source, $start, $end - $start );
	}

	public function test_our_story_hero_swap_only_replaces_the_untouched_seed() {
		$body = $this->function_body( $this->migrations(), 'restwell_migrate_our_story_hero_v82' );
		// Identifies the seed by its recorded stock source, not by guessing.
		$this->assertStringContainsString( '_restwell_stock_source', $body );
		$this->assertStringContainsString( "'stock/restwell-kent-riverside-brick-house.jpg' !== \$source", $body );
		// A hero field pointing somewhere else means someone chose it.
		$this->assertStringContainsString( '$hero > 0 && $hero !== $thumb', $body );
		// And it is flagged so it runs once.
		$this->assertStringContainsString( "update_option( 'restwell_our_story_hero_v82', '1'", $body );
	}

	public function test_copy_replacement_compares_on_normalised_line_endings() {
		$body = $this->function_body( $this->migrations(), 'restwell_replace_stale_page_copy' );
		$this->assertStringContainsString( '"\r\n"', $body );
		$this->assertStringContainsString( '$stored === trim( $pair[0] )', $body );
	}

	public function test_every_migration_flag_is_registered_for_the_schema_gate() {
		$source = $this->migrations();
		foreach ( array( 'restwell_page_copy_v80', 'restwell_page_copy_v81', 'restwell_our_story_hero_v82' ) as $flag ) {
			$this->assertSame( 1, preg_match_all( "/'" . $flag . "',\n/", $source ), $flag . ' is in the flag list' );
		}
		$this->assertStringContainsString( 'const RESTWELL_SCHEMA_VERSION = 82;', $source );
	}
}
