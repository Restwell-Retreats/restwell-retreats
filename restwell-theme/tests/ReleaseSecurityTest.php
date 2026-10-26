<?php
/**
 * Security pass on the release (24 Oct 2026): what ships, and the guards on it.
 *
 * @package Restwell_Retreats
 */

class ReleaseSecurityTest extends PHPUnit\Framework\TestCase {

	private function theme( string $path ): string {
		return (string) file_get_contents( dirname( __DIR__ ) . '/' . $path );
	}

	public function test_every_shipped_php_file_refuses_direct_requests() {
		$root  = dirname( __DIR__ );
		$files = array_merge( glob( $root . '/*.php' ), glob( $root . '/template-parts/*.php' ), glob( $root . '/template-parts/*/*.php' ), glob( $root . '/inc/*.php' ), glob( $root . '/inc/*/*.php' ), glob( $root . '/inc/*/*/*.php' ) );
		foreach ( $files as $file ) {
			$this->assertMatchesRegularExpression( "/defined\\(\\s*'(ABSPATH|WPINC)'\\s*\\)/", (string) file_get_contents( $file ), basename( $file ) . ' has a direct-access guard' );
		}
	}

	public function test_copy_briefs_are_closed_to_browsers_and_notes_do_not_ship() {
		$this->assertStringContainsString( 'Require all denied', $this->theme( 'copy-overwrites/.htaccess' ) );
		$this->assertStringContainsString( 'Deny from all', $this->theme( 'copy-overwrites/.htaccess' ) );
		$this->assertStringContainsString( "find \"\$THEME\" -type f -name '*.md' ! -path \"\$THEME/copy-overwrites/*\" -delete", $this->theme( 'tools/build-release-zips.sh' ) );
	}

	public function test_guest_guide_code_dies_after_five_wrong_tries() {
		$otp = $this->theme( 'inc/guest-guide/otp.php' );
		$this->assertStringContainsString( "\$fails = (int) get_transient( \$key . '_fails' ) + 1;", $otp );
		$this->assertStringContainsString( 'if ( $fails >= 5 ) {', $otp );
		$this->assertStringContainsString( 'hash_equals( $stored, $code_hash )', $otp );
	}

	public function test_site_hardening_is_in_the_theme() {
		$hard = $this->theme( 'inc/security-hardening.php' );
		// Login names stay private: no author archives, no oEmbed author.
		$this->assertStringContainsString( "if ( isset( \$query_vars['author'] ) || isset( \$query_vars['author_name'] ) ) {", $hard );
		$this->assertStringContainsString( "unset( \$data['author_name'], \$data['author_url'] );", $hard );
		// XML-RPC answers with nothing; no version in feeds; file editors off.
		$this->assertStringContainsString( "add_filter( 'xmlrpc_methods', '__return_empty_array' );", $hard );
		$this->assertStringContainsString( "add_filter( 'the_generator', '__return_empty_string' );", $hard );
		$this->assertStringContainsString( "define( 'DISALLOW_FILE_EDIT', true );", $hard );
		// 10 failed logins lock the connection out for 15 minutes.
		$this->assertStringContainsString( ') >= 10 ) {', $hard );
		$this->assertStringContainsString( "add_filter( 'login_errors', 'restwell_generic_login_error' );", $hard );
		$this->assertStringContainsString( "require_once get_template_directory() . '/inc/security-hardening.php';", $this->theme( 'functions.php' ) );
		// WordPress never offers someone else's theme as an update for this one.
		$this->assertStringContainsString( "\nUpdate URI: false\n", $this->theme( 'style.css' ) );
	}

	public function test_photo_upload_is_capped() {
		$this->assertStringContainsString( '> 400 * MB_IN_BYTES', $this->theme( 'inc/media-importer.php' ) );
	}

	public function test_partner_logos_carry_no_metadata() {
		foreach ( array_merge( glob( dirname( __DIR__ ) . '/assets/images/partners/*.png' ), glob( dirname( __DIR__ ) . '/assets/images/partners/*.jpg' ) ) as $file ) {
			$data = (string) file_get_contents( $file );
			$this->assertStringNotContainsString( 'x:xmpmeta', $data, basename( $file ) );
			$this->assertStringNotContainsString( "Exif\0\0", substr( $data, 0, 4096 ), basename( $file ) );
		}
	}
}
