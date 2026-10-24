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
		foreach ( array( 'restwell_page_copy_v80', 'restwell_page_copy_v81', 'restwell_our_story_hero_v82', 'restwell_dedupe_home_blog_v83', 'restwell_batch1_copy_v84', 'restwell_batch2_copy_v85', 'restwell_blog_summaries_v86', 'restwell_batch3_copy_v87', 'restwell_batch4_copy_v88', 'restwell_pricing_faq_v89', 'restwell_pricing_faq_heading_v90', 'restwell_home_cta_labels_v91', 'restwell_pricing_rates_intro_v92', 'restwell_our_story_plain_words_v93', 'restwell_our_story_build_card_v94', 'restwell_short_intros_v95', 'restwell_care_intros_v96', 'restwell_batch_a_posts_v97', 'restwell_publish_kept_guides_v98', 'restwell_page_copy_batch_b_v99', 'restwell_page_seo_batch_b_v100', 'restwell_legal_plain_english_v101', 'restwell_seed_catch_up_v102', 'restwell_our_story_shaped_v103', 'restwell_our_story_shaped_v104' ) as $flag ) {
			$this->assertSame( 1, preg_match_all( "/'" . $flag . "',\n/", $source ), $flag . ' is in the flag list' );
		}
		$this->assertStringContainsString( 'const RESTWELL_SCHEMA_VERSION = 104;', $source );
		$this->assertStringContainsString( "add_action( 'init', 'restwell_migrate_pricing_faq_v89',", $source );
		$this->assertStringContainsString( "add_action( 'after_switch_theme', 'restwell_migrate_pricing_faq_v89',", $source );
		$this->assertStringContainsString( "add_action( 'init', 'restwell_migrate_pricing_faq_heading_v90',", $source );
		$this->assertStringContainsString( "add_action( 'after_switch_theme', 'restwell_migrate_pricing_faq_heading_v90',", $source );
		$this->assertStringContainsString( "add_action( 'init', 'restwell_migrate_home_cta_labels_v91',", $source );
		$this->assertStringContainsString( "add_action( 'after_switch_theme', 'restwell_migrate_home_cta_labels_v91',", $source );
		$this->assertStringContainsString( "add_action( 'init', 'restwell_migrate_pricing_rates_intro_v92',", $source );
		$this->assertStringContainsString( "add_action( 'after_switch_theme', 'restwell_migrate_pricing_rates_intro_v92',", $source );
		$this->assertStringContainsString( "add_action( 'init', 'restwell_migrate_our_story_plain_words_v93',", $source );
		$this->assertStringContainsString( "add_action( 'after_switch_theme', 'restwell_migrate_our_story_plain_words_v93',", $source );
		$this->assertStringContainsString( "add_action( 'init', 'restwell_migrate_our_story_build_card_v94',", $source );
		$this->assertStringContainsString( "add_action( 'after_switch_theme', 'restwell_migrate_our_story_build_card_v94',", $source );
		$this->assertStringContainsString( "add_action( 'init', 'restwell_migrate_short_intros_v95',", $source );
		$this->assertStringContainsString( "add_action( 'after_switch_theme', 'restwell_migrate_short_intros_v95',", $source );
		$this->assertStringContainsString( "add_action( 'init', 'restwell_migrate_care_intros_v96',", $source );
		$this->assertStringContainsString( "add_action( 'after_switch_theme', 'restwell_migrate_care_intros_v96',", $source );
		$this->assertStringContainsString( "add_action( 'init', 'restwell_migrate_batch_a_posts_v97',", $source );
		$this->assertStringContainsString( "add_action( 'after_switch_theme', 'restwell_migrate_batch_a_posts_v97',", $source );
		$this->assertStringContainsString( "add_action( 'init', 'restwell_migrate_page_copy_batch_b_v99',", $source );
		$this->assertStringContainsString( "add_action( 'after_switch_theme', 'restwell_migrate_page_copy_batch_b_v99',", $source );
		$this->assertStringContainsString( "add_action( 'init', 'restwell_migrate_page_seo_batch_b_v100',", $source );
		$this->assertStringContainsString( "add_action( 'after_switch_theme', 'restwell_migrate_page_seo_batch_b_v100',", $source );
		$this->assertStringContainsString( "add_action( 'init', 'restwell_migrate_legal_plain_english_v101',", $source );
		$this->assertStringContainsString( "add_action( 'after_switch_theme', 'restwell_migrate_legal_plain_english_v101',", $source );
		$this->assertStringContainsString( "add_action( 'init', 'restwell_migrate_seed_catch_up_v102',", $source );
		$this->assertStringContainsString( "add_action( 'after_switch_theme', 'restwell_migrate_seed_catch_up_v102',", $source );
		$this->assertStringContainsString( "add_action( 'init', 'restwell_migrate_our_story_shaped_v103',", $source );
		$this->assertStringContainsString( "add_action( 'init', 'restwell_migrate_our_story_shaped_v104',", $source );
	}

	public function test_photo_migrations_wait_for_their_files() {
		// In a two-zip deploy the theme can go live before its images; these
		// migrations must not mark themselves done until the photo is on disk.
		foreach ( array( 'restwell_migrate_daylight_heroes_v75', 'restwell_migrate_care_copy_v78', 'restwell_migrate_our_story_hero_v82' ) as $fn ) {
			$body  = $this->function_body( $this->migrations(), $fn );
			$wait  = strpos( $body, '! restwell_theme_photo_ready(' );
			$mark  = strpos( $body, 'update_option(' );
			$this->assertNotFalse( $wait, $fn . ' checks its photo' );
			$this->assertLessThan( $mark, $wait, $fn . ' checks before marking itself done' );
			// A failed sideload tries again later instead of staying marked done.
			$this->assertStringContainsString( 'restwell_retry_photo_migration(', $body, $fn . ' retries a failed sideload' );
		}
		$retry = $this->function_body( $this->migrations(), 'restwell_retry_photo_migration' );
		$this->assertStringContainsString( 'if ( $tries < 3 ) {', $retry );
		$build = (string) file_get_contents( dirname( __DIR__ ) . '/tools/build-release-zips.sh' );
		$this->assertStringContainsString( 'git -C "$REPO_ROOT" archive HEAD restwell-theme', $build );
		$this->assertStringContainsString( 'grep -qxF "$rel" "$KEEP"', $build );
	}

	public function test_seed_catch_up_only_replaces_our_own_past_wording() {
		$body = $this->function_body( $this->migrations(), 'restwell_migrate_seed_catch_up_v102' );
		$this->assertStringContainsString( "update_option( 'restwell_seed_catch_up_v102', '1'", $body );
		// A stored value moves only when its fingerprint is one the theme has shipped.
		$this->assertStringContainsString( "in_array( \$fingerprint( \$stored ), \$history[ \$key ], true )", $body );
		$this->assertStringContainsString( "require __DIR__ . '/seed-history.php'", $body );
		// Questions and answers move only as a pair.
		$this->assertStringContainsString( "preg_match( '/^(.+_\\d+)_(q|a)$/', \$key, \$m )", $body );
		// The history file is valid PHP that returns key => fingerprints, and never lists photo fields.
		$history = include dirname( __DIR__ ) . '/inc/theme-setup/seed-history.php';
		$this->assertIsArray( $history );
		$this->assertGreaterThan( 500, count( $history ) );
		foreach ( $history as $key => $prints ) {
			$this->assertDoesNotMatchRegularExpression( '/(image|photo|caption|_alt$|_id$)/', (string) $key );
			foreach ( $prints as $print ) {
				$this->assertMatchesRegularExpression( '/^[0-9a-f]{16}$/', $print );
			}
		}
		// It moves the September wording the rehearsal found left behind.
		$this->assertContains( substr( md5( 'Roll-in wet room with adjustable basin' ), 0, 16 ), $history['prop_wetroom_heading'] );
	}

	public function test_legal_pass_keeps_edits_and_matches_the_shipped_text() {
		$body  = $this->function_body( $this->migrations(), 'restwell_migrate_legal_plain_english_v101' );
		$legal = (string) file_get_contents( dirname( __DIR__ ) . '/inc/theme-setup/legal-content.php' );
		$this->assertStringContainsString( "update_option( 'restwell_legal_plain_english_v101', '1'", $body );
		$this->assertStringContainsString( 'restwell_replace_stale_page_copy(', $body );
		// A stored body is dropped only while it holds the old text and not the new.
		$this->assertStringContainsString( 'false !== strpos( $html, $markers[0] ) && false === strpos( $html, $markers[1] )', $body );
		// Each "new" marker is in the shipped body, so a current copy is never dropped.
		foreach ( array( 'That means we decide how your information is used', 'In these terms, “we” and “us” mean', 'What you can do on this site' ) as $marker ) {
			$this->assertStringContainsString( $marker, $body );
			$this->assertStringContainsString( $marker, $legal );
		}
		// New headings and intros are what a fresh install seeds.
		foreach ( array( 'Privacy policy: how we look after your details', 'Terms and conditions for booking a stay', 'Accessibility statement for this website' ) as $h1 ) {
			$this->assertStringContainsString( "'" . $h1 . "'", $body );
			$this->assertStringContainsString( "'" . $h1 . "'", $legal );
		}
		$seo = (string) file_get_contents( dirname( __DIR__ ) . '/inc/seo-content-seed-meta.php' );
		foreach ( array( 'Restwell Retreats privacy policy', 'Restwell Retreats booking terms and conditions', 'Restwell Retreats website accessibility statement' ) as $title ) {
			$this->assertStringContainsString( "'" . $title . "'", $body );
			$this->assertStringContainsString( "'" . $title . "'", $seo );
		}
	}

	public function test_batch_b_seo_pass_only_replaces_the_shipped_values() {
		$body = $this->function_body( $this->migrations(), 'restwell_migrate_page_seo_batch_b_v100' );
		$this->assertStringContainsString( 'restwell_replace_stale_page_copy( $changes );', $body );
		$this->assertStringContainsString( "update_option( 'restwell_page_seo_batch_b_v100', '1'", $body );
		$this->assertStringContainsString( "'focus_keyphrase' => array( 'accessible holiday cottages by the sea', 'accessible holiday cottages kent' ),", $body );
		// The new intros are what a fresh install seeds.
		$defaults = (string) file_get_contents( dirname( __DIR__ ) . '/inc/theme-setup/page-defaults.php' );
		foreach ( array( 'a private holiday home for disabled adults, their carers, families and friends.', 'If you’d like a holiday with care provided,', 'our adapted holiday bungalow in Whitstable with a wet room and hoists.' ) as $line ) {
			$this->assertStringContainsString( $line, $body );
			$this->assertStringContainsString( $line, $defaults );
		}
	}

	public function test_batch_b_copy_only_replaces_known_old_values() {
		$body = $this->function_body( $this->migrations(), 'restwell_migrate_page_copy_batch_b_v99' );
		// Each field is swapped only while it equals one of its listed old values.
		$this->assertStringContainsString( 'restwell_replace_stale_page_copy( array( $slug => array( $key => array( $old, $change[1] ) ) ) );', $body );
		$this->assertStringContainsString( "update_option( 'restwell_page_copy_batch_b_v99', '1'", $body );
		// The new copy matches the fresh-install seeds, so old and new sites agree.
		$defaults = (string) file_get_contents( dirname( __DIR__ ) . '/inc/theme-setup/page-defaults.php' );
		foreach ( array( 'Inside the accessible bungalow, room by room', 'Grants and funding for your accessible holiday', 'Is Whitstable wheelchair friendly?', 'Questions about access', 'Questions about care' ) as $heading ) {
			$this->assertStringContainsString( "'" . $heading . "'", $body, $heading . ' is migrated' );
			$this->assertStringContainsString( "'" . $heading . "'", $defaults, $heading . ' is seeded' );
		}
		$seo = (string) file_get_contents( dirname( __DIR__ ) . '/inc/seo-content-seed-meta.php' );
		foreach ( array( 'Funding and grants for a disabled holiday', 'Is Whitstable wheelchair friendly? A local access guide', 'Accessible travel guides from a Whitstable bungalow' ) as $title ) {
			$this->assertStringContainsString( "'" . $title . "'", $body, $title . ' is migrated' );
			$this->assertStringContainsString( "'" . $title . "'", $seo, $title . ' is seeded' );
		}
		// Funding titles from every era: with and without the site name, and the fresh-install seed.
		$this->assertStringContainsString( "'Funding an accessible holiday | Restwell Retreats',", $body );
		$this->assertStringContainsString( "'Funding an accessible holiday, and who we invoice',", $body );
	}

	public function test_batch_a_posts_only_replace_what_was_shipped() {
		$body = $this->function_body( $this->migrations(), 'restwell_migrate_batch_a_posts_v97' );
		// A body is swapped only while its text still matches the shipped seed.
		$this->assertStringContainsString( 'restwell_post_text_fingerprint( $post->post_content ) === $old[\'text\']', $body );
		// Every other field only while it still equals its old seeded value.
		$this->assertStringContainsString( '$post->post_title === $old[\'title\']', $body );
		$this->assertStringContainsString( 'trim( $post->post_excerpt ) === $old[\'excerpt\']', $body );
		$this->assertStringContainsString( '(string) get_post_meta( $post->ID, $key, true ) === $old[ $key ]', $body );
		// New values come from the same articles the seeder uses.
		$this->assertStringContainsString( 'restwell_get_priority_blog_post_articles()', $body );
		$this->assertStringContainsString( "update_option( 'restwell_batch_a_posts_v97', '1'", $body );
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
		// It, or Batch B (v99) after it, writes exactly what a fresh install seeds.
		$later = $this->function_body( $this->migrations(), 'restwell_migrate_page_copy_batch_b_v99' );
		require_once dirname( __DIR__ ) . '/inc/pricing.php';
		foreach ( restwell_get_pricing_faq_defaults() as $row ) {
			$this->assertStringContainsString( "'" . $row['q'] . "'", $body );
			$this->assertTrue( false !== strpos( $body, "'" . $row['a'] . "'" ) || false !== strpos( $later, "'" . $row['a'] . "'" ), $row['q'] . ' answer is migrated' );
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
