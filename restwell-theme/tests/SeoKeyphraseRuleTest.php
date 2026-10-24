<?php
/**
 * One keyphrase rule for the SEO table and the page editor.
 *
 * @package Restwell_Retreats
 */

require_once dirname( __DIR__ ) . '/inc/seo-checklist.php';

class SeoKeyphraseRuleTest extends PHPUnit\Framework\TestCase {

	public function test_every_main_word_must_appear_in_any_order() {
		$kp = 'disabled holiday cottage with wet room and hoists';
		$this->assertSame( array(), restwell_seo_keyphrase_missing_words( 'A disabled holiday cottage with a wet room and hoist', $kp ) );
		$this->assertSame( array( 'disabled', 'holiday', 'cottage' ), restwell_seo_keyphrase_missing_words( 'Exact access details: hoists and a level wet room.', $kp ) );
	}

	public function test_plurals_and_small_words_do_not_count_against_a_page() {
		$this->assertSame( array(), restwell_seo_keyphrase_missing_words( 'Accessible holiday cottage in Whitstable, Kent', 'accessible holiday cottages kent' ) );
		$this->assertSame( array(), restwell_seo_keyphrase_missing_words( 'Which accessible beaches in Kent work?', 'accessible beach kent' ) );
		$this->assertSame( array(), restwell_seo_keyphrase_missing_words( 'How to book a stay at Restwell', 'how to book a stay at restwell' ) );
	}

	public function test_two_words_out_of_three_is_not_enough() {
		// The old table rule passed any two words; "retreats" was missing from the Enquire title.
		$this->assertSame( array( 'retreats' ), restwell_seo_keyphrase_missing_words( 'Contact Restwell about a stay in Whitstable', 'contact restwell retreats' ) );
	}

	public function test_table_and_editor_share_the_checks() {
		$checklist = (string) file_get_contents( dirname( __DIR__ ) . '/inc/seo-checklist.php' );
		$this->assertStringContainsString( "restwell_seo_admin_run_checks( \$post, \$meta['focus_keyphrase'], \$meta['meta_title'], \$meta['meta_description'] )", $checklist );
		// The editor script asks the server instead of scoring the fields itself.
		$script = (string) file_get_contents( dirname( __DIR__ ) . '/assets/js/seo-admin.js' );
		$this->assertStringContainsString( "data.append('action', 'restwell_seo_live_checks');", $script );
		$this->assertStringNotContainsString( 'indexOf(kpN)', $script );
		$this->assertStringNotContainsString( 'ideal: 50-60', $script );
	}

	public function test_page_editor_content_check_uses_the_same_checks() {
		$panel = (string) file_get_contents( dirname( __DIR__ ) . '/inc/page-content-checklist.php' );
		$this->assertStringContainsString( "restwell_seo_admin_run_checks( \$post, \$seo['focus_keyphrase'], \$seo['meta_title'], \$seo['meta_description'] )", $panel );
		// Its old exact-phrase checks, H1 included, are gone.
		$this->assertStringNotContainsString( 'seo_kp_not_in_h1', $panel );
		$this->assertStringNotContainsString( 'str_contains( $title_n, $kp )', $panel );
	}
}
