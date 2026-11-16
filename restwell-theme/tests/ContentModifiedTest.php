<?php
/**
 * Sitemap "last changed" dates: which field changes count, and which date wins.
 *
 * @package Restwell_Retreats
 */

require_once dirname( __DIR__ ) . '/inc/content-modified.php';

class ContentModifiedTest extends PHPUnit\Framework\TestCase {

	public function test_visible_copy_fields_count_as_a_change() {
		foreach ( array( 'acc_intro', 'meta_title', 'wg_event_1_name', 'home_hero_heading' ) as $key ) {
			$this->assertTrue( restwell_content_modified_tracks_key( $key ), $key );
		}
	}

	public function test_template_and_featured_image_count_as_a_change() {
		$this->assertTrue( restwell_content_modified_tracks_key( '_wp_page_template' ) );
		$this->assertTrue( restwell_content_modified_tracks_key( '_thumbnail_id' ) );
	}

	public function test_bookkeeping_and_our_own_stamp_do_not_count() {
		foreach ( array( '', '_edit_lock', '_edit_last', '_wp_old_slug', '_restwell_stock_source', RESTWELL_CONTENT_MODIFIED_META ) as $key ) {
			$this->assertFalse( restwell_content_modified_tracks_key( $key ), $key );
		}
	}

	public function test_later_stamp_beats_the_wordpress_date() {
		$this->assertSame( '2026-11-02 12:00:00', restwell_content_modified_latest_gmt( '2026-04-23 11:49:58', '2026-11-02 12:00:00' ) );
	}

	public function test_later_wordpress_date_beats_an_older_stamp() {
		$this->assertSame( '2026-11-20 09:15:00', restwell_content_modified_latest_gmt( '2026-11-20 09:15:00', '2026-11-02 12:00:00' ) );
	}

	public function test_missing_or_broken_stamp_keeps_the_wordpress_date() {
		foreach ( array( '', '0000-00-00 00:00:00', 'yesterday', '2026-11-02' ) as $stamp ) {
			$this->assertSame( '2026-04-23 11:49:58', restwell_content_modified_latest_gmt( '2026-04-23 11:49:58', $stamp ), var_export( $stamp, true ) );
		}
	}

	public function test_zero_wordpress_date_falls_back_to_the_stamp() {
		$this->assertSame( '2026-11-02 12:00:00', restwell_content_modified_latest_gmt( '0000-00-00 00:00:00', '2026-11-02 12:00:00' ) );
	}

	public function test_backfill_dates_pages_to_the_1_1_1_release_only_when_older() {
		$source = (string) file_get_contents( dirname( __DIR__ ) . '/inc/theme-setup/migrations.php' );
		$this->assertStringContainsString( "\$stamp = '2026-11-02 12:00:00';", $source );
		$this->assertStringContainsString( "if ( strcmp( (string) \$page->post_modified_gmt, \$stamp ) >= 0 ) {", $source );
		$this->assertStringContainsString( "add_action( 'init', 'restwell_migrate_content_modified_backfill_v124',", $source );
	}
}
