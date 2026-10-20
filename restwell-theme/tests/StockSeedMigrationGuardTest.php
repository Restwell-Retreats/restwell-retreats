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
		foreach ( array( 'restwell_page_copy_v80', 'restwell_page_copy_v81', 'restwell_our_story_hero_v82', 'restwell_dedupe_home_blog_v83', 'restwell_batch1_copy_v84', 'restwell_batch2_copy_v85', 'restwell_blog_summaries_v86', 'restwell_batch3_copy_v87', 'restwell_batch4_copy_v88', 'restwell_pricing_faq_v89', 'restwell_pricing_faq_heading_v90', 'restwell_home_cta_labels_v91' ) as $flag ) {
			$this->assertSame( 1, preg_match_all( "/'" . $flag . "',\n/", $source ), $flag . ' is in the flag list' );
		}
		$this->assertStringContainsString( 'const RESTWELL_SCHEMA_VERSION = 91;', $source );
		$this->assertStringContainsString( "add_action( 'init', 'restwell_migrate_pricing_faq_v89',", $source );
		$this->assertStringContainsString( "add_action( 'after_switch_theme', 'restwell_migrate_pricing_faq_v89',", $source );
		$this->assertStringContainsString( "add_action( 'init', 'restwell_migrate_pricing_faq_heading_v90',", $source );
		$this->assertStringContainsString( "add_action( 'after_switch_theme', 'restwell_migrate_pricing_faq_heading_v90',", $source );
		$this->assertStringContainsString( "add_action( 'init', 'restwell_migrate_home_cta_labels_v91',", $source );
		$this->assertStringContainsString( "add_action( 'after_switch_theme', 'restwell_migrate_home_cta_labels_v91',", $source );
	}

	public function test_pricing_faq_heading_swap_only_replaces_the_july_seeds() {
		$body = $this->function_body( $this->migrations(), 'restwell_migrate_pricing_faq_heading_v90' );
		$this->assertStringContainsString( 'restwell_replace_stale_page_copy(', $body );
		$this->assertStringContainsString( "'pricing_faq_label'   => array( 'FAQ', 'Money questions' ),", $body );
		$this->assertStringContainsString( "'pricing_faq_heading' => array( 'Common questions about pricing', 'Questions about prices' ),", $body );
		$this->assertStringContainsString( "update_option( 'restwell_pricing_faq_heading_v90', '1'", $body );
		// The template reads the fields, with the same copy as its fallback.
		$template = (string) file_get_contents( dirname( __DIR__ ) . '/template-pricing.php' );
		$this->assertStringContainsString( "\$pricing_txt( 'pricing_faq_label', __( 'Money questions', 'restwell-retreats' ) )", $template );
		$this->assertStringContainsString( "\$pricing_txt( 'pricing_faq_heading', __( 'Questions about prices', 'restwell-retreats' ) )", $template );
		$this->assertStringContainsString( "'pricing_faq_intro',", $template );
	}

	public function test_pricing_faq_swap_moves_whole_pairs_to_the_shipped_defaults() {
		$body = $this->function_body( $this->migrations(), 'restwell_migrate_pricing_faq_v89' );
		// A slot moves only while its question and its answer are both the old seed.
		$this->assertStringContainsString( 'continue 2;', $body );
		$this->assertStringContainsString( "restwell_replace_stale_page_copy( array( 'pricing' => \$fields ) );", $body );
		$this->assertStringContainsString( "update_option( 'restwell_pricing_faq_v89', '1'", $body );
		// It writes exactly what a fresh install seeds.
		require_once dirname( __DIR__ ) . '/inc/pricing.php';
		foreach ( restwell_get_pricing_faq_defaults() as $row ) {
			$this->assertStringContainsString( "'" . $row['q'] . "'", $body );
			$this->assertStringContainsString( "'" . $row['a'] . "'", $body );
		}
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
