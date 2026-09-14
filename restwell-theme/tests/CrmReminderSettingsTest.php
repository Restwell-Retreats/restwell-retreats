<?php
/**
 * Enquiry reminder thresholds are stored as options, then clamped.
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
if ( ! function_exists( 'mysql2date' ) ) {
	function mysql2date( $format, $date ) {
		unset( $format );
		return (string) $date;
	}
}

require_once dirname( __DIR__ ) . '/inc/crm/form-notify.php';
require_once dirname( __DIR__ ) . '/inc/crm/emails.php';
require_once dirname( __DIR__ ) . '/inc/crm/email-staff.php';
require_once dirname( __DIR__ ) . '/inc/crm/crm-reminders.php';

class CrmReminderSettingsTest extends PHPUnit\Framework\TestCase {

	protected function setUp(): void {
		$GLOBALS['restwell_test_options'] = array();
	}

	public function test_defaults_match_constants() {
		$this->assertTrue( restwell_crm_reminder_is_enabled() );
		$this->assertSame( 18, restwell_crm_reminder_stale_hours() );
		$this->assertSame( 24, restwell_crm_reminder_repeat_hours() );
	}

	public function test_options_override_defaults() {
		update_option( 'restwell_crm_reminder_enabled', '0' );
		update_option( 'restwell_crm_reminder_stale_hours', 6 );
		update_option( 'restwell_crm_reminder_repeat_hours', 48 );

		$this->assertFalse( restwell_crm_reminder_is_enabled() );
		$this->assertSame( 6, restwell_crm_reminder_stale_hours() );
		$this->assertSame( 48, restwell_crm_reminder_repeat_hours() );
	}

	public function test_hours_are_clamped() {
		$this->assertSame( 1, restwell_crm_reminder_clamp_hours( 0 ) );
		$this->assertSame( 168, restwell_crm_reminder_clamp_hours( 999 ) );

		update_option( 'restwell_crm_reminder_stale_hours', 400 );
		update_option( 'restwell_crm_reminder_repeat_hours', -3 );

		$this->assertSame( 168, restwell_crm_reminder_stale_hours() );
		$this->assertSame( 1, restwell_crm_reminder_repeat_hours() );
	}

	public function test_reminder_footnote_uses_repeat_hours() {
		$row                 = new stdClass();
		$row->id             = 7;
		$row->name           = 'Jane Hartley';
		$row->email          = 'jane@example.com';
		$row->phone          = '';
		$row->preferred_dates = '';
		$row->num_guests     = '';
		$row->message        = 'Hello';
		$row->is_urgent      = 0;
		$row->submitted_at   = '2026-09-13 12:00:00';

		$mail = restwell_crm_reminder_build_email( $row, 6, 12 );
		$this->assertStringContainsString( '6h stale threshold', $mail['body'] );
		$this->assertStringContainsString( 'at least 12 hours', $mail['body'] );
		$this->assertStringNotContainsString( 'at least 24 hours', $mail['body'] );
	}
}
