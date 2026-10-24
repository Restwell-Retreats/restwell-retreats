<?php
/**
 * The release photo zip import can only add images to the theme, and only for
 * people who could upload a theme anyway.
 *
 * @package Restwell_Retreats
 */

class MediaImportGuardTest extends PHPUnit\Framework\TestCase {

	private function importer() {
		return (string) file_get_contents( dirname( __DIR__ ) . '/inc/media-importer.php' );
	}

	public function test_only_image_files_are_copied_into_the_theme() {
		$source = $this->importer();
		$this->assertStringContainsString( "\$allowed = array( 'webp', 'png', 'jpg', 'jpeg', 'gif' );", $source );
		$this->assertStringContainsString( "false !== strpos( \$rel, '..' )", $source );
		// Only the assets/images folder of the zip is read.
		$this->assertStringContainsString( "array( 'restwell-theme/assets/images', 'assets/images' )", $source );
	}

	public function test_uploads_need_theme_rights_and_a_nonce() {
		$source = $this->importer();
		$this->assertStringContainsString( "check_ajax_referer( 'restwell_media_zip', 'nonce' );", $source );
		$this->assertStringContainsString( "if ( ! current_user_can( 'install_themes' ) ) {", $source );
		$this->assertStringContainsString( "check_admin_referer( 'restwell_media_zip', 'restwell_media_zip_nonce' );", $source );
	}

	public function test_pieces_must_arrive_in_order() {
		$source = $this->importer();
		$this->assertStringContainsString( "preg_match( '/^[a-f0-9]{16,64}$/', \$id )", $source );
		$this->assertStringContainsString( 'if ( $have !== $offset ) {', $source );
	}
}
