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
