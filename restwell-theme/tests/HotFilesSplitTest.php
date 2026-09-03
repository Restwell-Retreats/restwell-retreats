<?php
/**
 * Hot-file splits: dispatchers stay thin; spent migrations stay archived.
 *
 * @package Restwell_Retreats
 */

class HotFilesSplitTest extends PHPUnit\Framework\TestCase {

	private function theme_file( $relative ) {
		return dirname( __DIR__ ) . '/' . ltrim( $relative, '/' );
	}

	public function test_main_js_dead_nav_chrome_is_gone() {
		$js = (string) file_get_contents( $this->theme_file( 'assets/js/main.js' ) );
		$this->assertStringNotContainsString( 'initMobileMenu', $js );
		$this->assertStringNotContainsString( 'initNavDropdowns', $js );
		$this->assertStringNotContainsString( 'initHomeFaqAccordion', $js );
		$this->assertStringContainsString( 'initExploreFilter', $js );
		$this->assertStringContainsString( 'initFaqTabs', $js );
	}

	public function test_jsonld_dispatcher_loads_siblings() {
		$php = (string) file_get_contents( $this->theme_file( 'inc/seo/jsonld.php' ) );
		$this->assertStringContainsString( "require_once __DIR__ . '/jsonld-core.php'", $php );
		$this->assertStringContainsString( "require_once __DIR__ . '/jsonld-lodging.php'", $php );
		$this->assertStringNotContainsString( 'function restwell_output_jsonld_local_business', $php );
		$lodging = (string) file_get_contents( $this->theme_file( 'inc/seo/jsonld-lodging.php' ) );
		$this->assertStringContainsString( 'function restwell_output_jsonld_local_business', $lodging );
	}

	public function test_guest_guide_bootstrap_loads_modules() {
		$php = (string) file_get_contents( $this->theme_file( 'inc/guest-guide.php' ) );
		$this->assertStringContainsString( "require_once __DIR__ . '/guest-guide/otp.php'", $php );
		$this->assertStringNotContainsString( 'function restwell_send_guide_otp', $php );
		$otp = (string) file_get_contents( $this->theme_file( 'inc/guest-guide/otp.php' ) );
		$this->assertStringContainsString( 'function restwell_send_guide_otp', $otp );
	}

	public function test_spent_migrations_are_archived() {
		$hot = (string) file_get_contents( $this->theme_file( 'inc/theme-setup/migrations.php' ) );
		$this->assertStringNotContainsString( 'function restwell_migrate_privacy_consent_v29', $hot );
		$this->assertStringContainsString( 'migrations-archive-v29-v31.php', $hot );
		$archive = (string) file_get_contents( $this->theme_file( 'inc/theme-setup/migrations-archive-v29-v31.php' ) );
		$this->assertStringContainsString( 'function restwell_migrate_privacy_consent_v29', $archive );
		$this->assertStringContainsString( 'function restwell_migrate_site_identity_v30', $archive );
		$this->assertStringContainsString( 'function restwell_migrate_privacy_consent_v31', $archive );
	}

	public function test_tailwind_is_not_enqueued() {
		$php = (string) file_get_contents( $this->theme_file( 'inc/enqueue.php' ) );
		$this->assertStringNotContainsString( 'restwell-tailwind', $php );
		$this->assertStringNotContainsString( 'phosphor-icons-regular', $php );
	}

	public function test_dashboard_page_is_a_dispatcher() {
		$php = (string) file_get_contents( $this->theme_file( 'inc/crm/dashboard.php' ) );
		$this->assertStringContainsString( "require_once __DIR__ . '/dashboard-panels.php'", $php );
		$this->assertStringContainsString( "require_once __DIR__ . '/dashboard-settings.php'", $php );
		$this->assertStringNotContainsString( 'function restwell_crm_dashboard_render_settings', $php );
		$settings = (string) file_get_contents( $this->theme_file( 'inc/crm/dashboard-settings.php' ) );
		$this->assertStringContainsString( 'function restwell_crm_dashboard_render_settings', $settings );
	}

	public function test_guest_guide_settings_page_is_a_dispatcher() {
		$php = (string) file_get_contents( $this->theme_file( 'inc/guest-guide/admin.php' ) );
		$this->assertStringContainsString( "require_once __DIR__ . '/admin-list.php'", $php );
		$this->assertStringContainsString( "require_once __DIR__ . '/admin-forms.php'", $php );
		$this->assertStringNotContainsString( 'function restwell_gg_admin_render_guest_list', $php );
		$list = (string) file_get_contents( $this->theme_file( 'inc/guest-guide/admin-list.php' ) );
		$this->assertStringContainsString( 'function restwell_gg_admin_render_guest_list', $list );
	}

	public function test_seo_loads_bing_webmaster_rest_client() {
		$php = (string) file_get_contents( $this->theme_file( 'inc/seo.php' ) );
		$this->assertStringContainsString( "'bing-webmaster.php'", $php );
		$client = (string) file_get_contents( $this->theme_file( 'inc/seo/bing-webmaster.php' ) );
		$this->assertStringContainsString( 'api.svc/json/', $client );
		$this->assertStringNotContainsString( 'api.svc/soap', $client );
		$this->assertStringNotContainsString( 'api.svc/pox', $client );
	}

	public function test_seo_sitewide_render_is_split() {
		$admin = (string) file_get_contents( $this->theme_file( 'inc/seo-sitewide-admin.php' ) );
		$this->assertStringContainsString( "require_once __DIR__ . '/seo-sitewide-render.php'", $admin );
		$this->assertStringNotContainsString( 'function restwell_seo_sitewide_render_page', $admin );
		$render = (string) file_get_contents( $this->theme_file( 'inc/seo-sitewide-render.php' ) );
		$this->assertStringContainsString( 'function restwell_seo_sitewide_render_page', $render );
		$this->assertStringContainsString( 'function restwell_seo_sitewide_render_business_card', $render );
	}

	public function test_tailwind_source_is_archived_not_live() {
		$theme = dirname( __DIR__ );
		$this->assertFileDoesNotExist( $theme . '/assets/css/input.css' );
		$this->assertFileDoesNotExist( $theme . '/assets/css/tailwind.css' );
		$this->assertFileExists( $theme . '/docs/archive/tailwind-source/input.css' );
		$pkg = (string) file_get_contents( $theme . '/package.json' );
		$this->assertStringNotContainsString( 'tailwindcss -i', $pkg );
		$this->assertStringNotContainsString( 'assets/css/input.css', $pkg );
	}

	public function test_availability_script_is_pricing_only() {
		$php = (string) file_get_contents( $this->theme_file( 'inc/enqueue.php' ) );
		$this->assertStringContainsString( 'restwell-availability', $php );
		$this->assertStringContainsString( 'template-pricing.php', $php );
		$this->assertStringContainsString( 'restwell_occupancy_is_configured', $php );
	}
}
