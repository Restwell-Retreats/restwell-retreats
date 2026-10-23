<?php
/**
 * Hover and focus states on dark surfaces and photos (23 Oct 2026).
 *
 * axe-core checks resting colours only, so these slipped through: a dark-gold
 * hover on a teal card (1.15:1), teal focus rings on teal panels (1:1), gold
 * current-page text over bright hero photos (3.7:1). The full check is
 * tools/audit-interaction-contrast.mjs against a running site; these read the
 * source so the specific causes can't quietly come back.
 *
 * @package Restwell_Retreats
 */

class InteractionStatesTest extends PHPUnit\Framework\TestCase {

	private function css( $file = 'shared.css' ) {
		return (string) file_get_contents( dirname( __DIR__ ) . '/assets/css/' . $file );
	}

	private function rule( $css, $selector ) {
		$start = strpos( $css, $selector . ' {' );
		$this->assertNotFalse( $start, $selector . ' exists' );
		return substr( $css, $start, strpos( $css, '}', $start ) - $start );
	}

	public function test_text_link_focus_leaves_the_ring_colour_to_the_surface() {
		// Setting a colour here beat the dark-surface ring list near the top.
		$body = $this->rule( $this->css(), '.text-link:focus-visible' );
		$this->assertDoesNotMatchRegularExpression( '/outline(-color)?\s*:[^;]*var\(--/', $body );
	}

	public function test_dark_panels_get_the_gold_ring() {
		$css = $this->css();
		$this->assertStringContainsString( ".acc-download :focus-visible,\n#directory .fund-directory > div:last-child :focus-visible {\n  outline-color: var(--warm-gold-hero);", $css );
	}

	public function test_funding_card_links_hover_white() {
		$this->assertStringContainsString( ".funding-route__foot a:hover,\n.funding-route__foot a:focus-visible { color: var(--white);", $this->css() );
		$template = (string) file_get_contents( dirname( __DIR__ ) . '/template-resources.php' );
		$this->assertStringContainsString( 'class="text-link text-link--on-dark"', $template );
	}

	public function test_focus_over_photos_has_a_dark_band() {
		$css = $this->css();
		$this->assertStringContainsString( ".site-header :focus-visible,\n.hero:not(.hero--plain) :focus-visible,\n.mid-cta :focus-visible {\n  box-shadow: 0 0 0 7px var(--deep-teal);", $css );
	}

	public function test_skip_link_ring_has_a_white_halo_in_both_files() {
		$this->assertStringContainsString( 'box-shadow: 0 0 0 7px var(--white)', $this->rule( $this->css(), '.skip-link:focus-visible' ) );
		$this->assertStringContainsString( 'box-shadow: 0 0 0 7px var(--white)', $this->rule( $this->css( 'polish.css' ), '.skip-link:focus' ) );
	}

	public function test_hero_text_states_stay_white() {
		$css = $this->css();
		$this->assertStringContainsString( "color: var(--white);\n  text-decoration: underline;", $this->rule( $css, ".breadcrumb a:hover,\n.breadcrumb a:focus-visible" ) );
		$this->assertStringContainsString( 'color: var(--white);', $this->rule( $css, ".nav a.is-active,\n.nav__item--has-dropdown > .nav__trigger[aria-expanded=\"true\"],\n.nav__item--has-dropdown.is-current > .nav__trigger" ) );
	}

	public function test_the_audit_tool_is_kept() {
		$this->assertFileExists( dirname( __DIR__ ) . '/tools/audit-interaction-contrast.mjs' );
	}
}
