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
		foreach ( array( 'restwell_page_copy_v80', 'restwell_page_copy_v81', 'restwell_our_story_hero_v82', 'restwell_dedupe_home_blog_v83', 'restwell_batch1_copy_v84', 'restwell_batch2_copy_v85', 'restwell_blog_summaries_v86', 'restwell_batch3_copy_v87' ) as $flag ) {
			$this->assertSame( 1, preg_match_all( "/'" . $flag . "',\n/", $source ), $flag . ' is in the flag list' );
		}
		$this->assertStringContainsString( 'const RESTWELL_SCHEMA_VERSION = 87;', $source );
	}

	public function test_home_blog_cleanup_never_touches_the_front_or_posts_page() {
		$body = $this->function_body( $this->migrations(), 'restwell_migrate_dedupe_home_blog_v83' );
		$this->assertStringContainsString( "get_option( 'page_on_front', 0 )", $body );
		$this->assertStringContainsString( "get_option( 'page_for_posts', 0 )", $body );
		$this->assertStringContainsString( "'post__not_in'     => \$protected", $body );
		// Only empty, template-less pages with the same title are trashed, never deleted.
		$this->assertStringContainsString( "'' !== trim( (string) \$dupe->post_content )", $body );
		$this->assertStringContainsString( 'wp_trash_post(', $body );
		$this->assertStringNotContainsString( 'wp_delete_post(', $body );
	}

	public function test_page_creation_lock_is_an_atomic_insert() {
		$runner = (string) file_get_contents( dirname( __DIR__ ) . '/inc/theme-setup/runner.php' );
		$body   = $this->function_body( $runner, 'restwell_take_page_creation_lock' );
		$this->assertStringContainsString( 'INSERT IGNORE INTO', $body );
		$this->assertStringContainsString( '1 === (int) $won', $body );
		// A request that waited must not trust its cached "not found" lookups.
		$this->assertStringContainsString( "wp_cache_delete( 'last_changed', 'posts' )", $body );
		$this->assertStringNotContainsString( "add_option( 'restwell_ensure_pages_lock'", $runner );
	}
}
