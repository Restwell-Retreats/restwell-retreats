<?php
/**
 * HTML mail MIME helpers (Outlook must not receive HTML as text/plain).
 *
 * @package Restwell_Retreats
 */

class MailHtmlMimeTest extends PHPUnit\Framework\TestCase {

	protected function setUp(): void {
		restwell_mail_current_is_html( false );
	}

	public function test_doctype_document_is_html() {
		$this->assertTrue(
			restwell_mail_message_is_html( "<!DOCTYPE html>\n<html><body><p>Hi</p></body></html>" )
		);
	}

	public function test_plain_text_is_not_html() {
		$this->assertFalse( restwell_mail_message_is_html( "Name: Jane\nEmail: jane@example.com" ) );
	}

	public function test_wp_mail_filter_flags_html_and_uses_crlf() {
		$out = restwell_mail_normalise_line_endings(
			array(
				'message' => "<!DOCTYPE html>\n<html><body>Hi</body></html>",
			)
		);
		$this->assertTrue( restwell_mail_current_is_html() );
		$this->assertStringContainsString( "\r\n", $out['message'] );
		$this->assertSame( 'text/html', restwell_mail_force_html_content_type( 'text/plain' ) );
	}

	public function test_wp_mail_filter_leaves_plain_text_alone() {
		restwell_mail_normalise_line_endings( array( 'message' => 'Just a note' ) );
		$this->assertFalse( restwell_mail_current_is_html() );
		$this->assertSame( 'text/plain', restwell_mail_force_html_content_type( 'text/plain' ) );
	}

	public function test_phpmailer_html_body_gets_base64() {
		$mailer              = new Restwell_PHPMailer_Stub();
		$mailer->Body        = '<!DOCTYPE html><html><body><table role="presentation"></table></body></html>';
		$mailer->ContentType = 'text/plain';
		$mailer->Encoding    = '8bit';

		restwell_phpmailer_apply_html_mime( $mailer );

		$this->assertSame( 'text/html', $mailer->ContentType );
		$this->assertSame( 'UTF-8', $mailer->CharSet );
		$this->assertSame( 'base64', $mailer->Encoding );
	}

	public function test_phpmailer_plain_body_is_unchanged() {
		$mailer              = new Restwell_PHPMailer_Stub();
		$mailer->Body        = 'Name: Jane';
		$mailer->ContentType = 'text/plain';
		$mailer->Encoding    = '8bit';

		restwell_phpmailer_apply_html_mime( $mailer );

		$this->assertSame( 'text/plain', $mailer->ContentType );
		$this->assertSame( '8bit', $mailer->Encoding );
	}
}

/**
 * Minimal PHPMailer stand-in for MIME helper tests.
 */
class Restwell_PHPMailer_Stub {
	public $Body        = '';
	public $ContentType = 'text/plain';
	public $CharSet     = 'iso-8859-1';
	public $Encoding    = '8bit';

	public function isHTML( $is_html = true ) {
		$this->ContentType = $is_html ? 'text/html' : 'text/plain';
	}
}
