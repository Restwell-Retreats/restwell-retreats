<?php
/**
 * Guest and staff HTML mail must stay inside Outlook’s Word engine.
 *
 * @package Restwell_Retreats
 */

if ( ! function_exists( 'esc_html' ) ) {
	function esc_html( $text ) {
		return htmlspecialchars( (string) $text, ENT_QUOTES, 'UTF-8' );
	}
}
if ( ! function_exists( 'wp_kses_post' ) ) {
	function wp_kses_post( $text ) {
		return (string) $text;
	}
}
if ( ! function_exists( 'wp_parse_args' ) ) {
	function wp_parse_args( $args, $defaults = array() ) {
		return array_merge( $defaults, $args );
	}
}
if ( ! function_exists( 'sanitize_email' ) ) {
	function sanitize_email( $email ) {
		return filter_var( (string) $email, FILTER_SANITIZE_EMAIL );
	}
}
if ( ! function_exists( 'is_email' ) ) {
	function is_email( $email ) {
		return (bool) filter_var( $email, FILTER_VALIDATE_EMAIL );
	}
}
if ( ! function_exists( 'sanitize_key' ) ) {
	function sanitize_key( $key ) {
		return strtolower( preg_replace( '/[^a-z0-9_\-]/', '', (string) $key ) );
	}
}
if ( ! function_exists( 'admin_url' ) ) {
	function admin_url( $path = '' ) {
		return 'https://restwellretreats.co.uk/wp-admin/' . ltrim( (string) $path, '/' );
	}
}
if ( ! function_exists( 'add_query_arg' ) ) {
	function add_query_arg( $args, $url ) {
		$sep = false === strpos( (string) $url, '?' ) ? '?' : '&';
		return $url . $sep . http_build_query( $args );
	}
}
if ( ! function_exists( 'restwell_theme_image_url' ) ) {
	function restwell_theme_image_url( $relative ) {
		return get_template_directory_uri() . '/assets/images/' . ltrim( (string) $relative, '/' );
	}
}

require_once dirname( __DIR__ ) . '/inc/crm/form-notify.php';
require_once dirname( __DIR__ ) . '/inc/crm/emails.php';
require_once dirname( __DIR__ ) . '/inc/crm/email-staff.php';

class EmailOutlookMarkupTest extends PHPUnit\Framework\TestCase {

	/**
	 * @param string $html Full HTML document.
	 */
	private function assert_outlook_safe( string $html ) {
		$this->assertStringContainsString( '<!--[if mso]>', $html );
		$this->assertStringContainsString( 'PixelsPerInch', $html );
		$this->assertStringContainsString( 'Arial,Helvetica', $html );
		$this->assertStringContainsString( 'cellpadding="0"', $html );
		$this->assertStringContainsString( 'bgcolor=', $html );
		$this->assertStringNotContainsString( 'calc(', $html );
		$this->assertStringNotContainsString( 'margin:-', $html );
		$this->assertStringNotContainsString( 'white-space:pre', $html );
		$this->assertStringNotContainsString( '⏱', $html );
		$this->assertDoesNotMatchRegularExpression( '/style="[^"]*font-family:\s*[\'"]?Inter/', $html );
		$this->assertDoesNotMatchRegularExpression( '/<a [^>]*display:\s*inline-block[^>]*padding:\s*14px/', $html );
	}

	public function test_enquiry_acknowledgement_is_outlook_safe() {
		$mail = restwell_email_enquiry_ack( 'Jane Hartley', 'jane@example.com', true );
		$this->assert_outlook_safe( $mail['body'] );
		$this->assertStringContainsString( 'flagged as urgent', $mail['body'] );
		$this->assertStringContainsString( 'bgcolor="#FEF3C7"', $mail['body'] );
		$this->assertStringContainsString( 'Content-Type: text/html', $mail['headers'][0] );
	}

	public function test_staff_enquiry_notification_is_outlook_safe() {
		$mail = restwell_email_enquiry_notification(
			array(
				'id'           => 42,
				'name'         => 'Jane Hartley',
				'email'        => 'jane@example.com',
				'phone'        => '01622 809881',
				'contact_pref' => 'email',
				'message'      => "Line one.\nLine two.",
				'urgent'       => true,
			)
		);
		$this->assert_outlook_safe( $mail['body'] );
		$this->assertStringContainsString( '<br>', $mail['body'] );
		$this->assertStringContainsString( 'Open in CRM', $mail['body'] );
		$this->assertStringContainsString( 'width="560"', $mail['body'] );
	}

	public function test_otp_digits_are_table_cells() {
		$mail = restwell_email_otp( 'jane@example.com', '847291' );
		$this->assert_outlook_safe( $mail['body'] );
		$this->assertStringContainsString( '>8</td>', $mail['body'] );
		$this->assertStringContainsString( '>1</td>', $mail['body'] );
		$this->assertStringNotContainsString( 'display:inline-block;width:42px', $mail['body'] );
		$this->assertStringContainsString( '30 minutes', $mail['body'] );
	}

	public function test_booking_confirmation_is_outlook_safe() {
		$mail = restwell_email_booking_confirmed( 'Jane Hartley', 'jane@example.com' );
		$this->assert_outlook_safe( $mail['body'] );
		$this->assertStringContainsString( 'booking is confirmed', strtolower( $mail['subject'] ) );
	}

	public function test_post_stay_button_padding_lives_on_td() {
		$mail = restwell_email_post_stay( 'jane@example.com', 'Jane Hartley', '14-17 April 2026' );
		$this->assert_outlook_safe( $mail['body'] );
		$this->assertMatchesRegularExpression(
			'/td align="center" bgcolor="#[A-Fa-f0-9]{6}"[^>]*padding:14px 32px/',
			$mail['body']
		);
	}

	public function test_guest_guide_invite_uses_welcome_shell() {
		$mail = restwell_theme_email_guest_guide_invite(
			'jane@example.com',
			'Jane Hartley',
			'https://restwellretreats.co.uk/guest-guide/'
		);
		$this->assert_outlook_safe( $mail['body'] );
		$this->assertStringContainsString( 'Welcome to', $mail['body'] );
		$this->assertStringContainsString( 'width="220"', $mail['body'] );
		$this->assertStringContainsString( 'How to open your guide', $mail['body'] );
		$this->assertStringContainsString( 'bgcolor="#F5EDE0"', $mail['body'] );
	}

	public function test_faq_staff_body_is_outlook_safe() {
		$html = restwell_email_staff_body(
			array(
				'label'       => 'Question from the FAQ page',
				'heading'     => 'Someone asked a question (#9)',
				'rows'        => array( 'Name' => 'Jane', 'Email' => 'jane@example.com' ),
				'quote'       => "Can you take a hoist?\nWe have a powerchair.",
				'quote_label' => 'Their question',
				'preview'     => 'A new question from the FAQ page',
			)
		);
		$this->assert_outlook_safe( $html );
		$this->assertStringContainsString( '<br>', $html );
	}
}
