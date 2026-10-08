<?php
/**
 * Enquire date helpers.
 *
 * @package Restwell_Retreats
 */

class EnquireDatesTest extends PHPUnit\Framework\TestCase {

	protected function setUp(): void {
		$GLOBALS['restwell_test_today'] = '2026-09-01';
	}

	public function test_empty_dates_are_valid() {
		$this->assertSame( array(), restwell_validate_enquiry_dates( '', '' ) );
	}

	public function test_rejects_malformed_start() {
		$errors = restwell_validate_enquiry_dates( '01-09-2026', '' );
		$this->assertNotEmpty( $errors );
	}

	public function test_rejects_start_in_the_past() {
		$errors = restwell_validate_enquiry_dates( '2026-08-31', '' );
		$this->assertNotEmpty( $errors );
	}

	public function test_accepts_today_as_start() {
		$this->assertSame( array(), restwell_validate_enquiry_dates( '2026-09-01', '' ) );
	}

	public function test_rejects_end_before_start() {
		$errors = restwell_validate_enquiry_dates( '2026-09-10', '2026-09-09' );
		$this->assertNotEmpty( $errors );
	}

	public function test_format_range_both_dates() {
		$this->assertSame(
			'12 Mar 2026 - 15 Mar 2026',
			restwell_format_enquiry_date_range( '2026-03-12', '2026-03-15' )
		);
	}

	public function test_format_range_start_only() {
		$this->assertSame( '12 Mar 2026', restwell_format_enquiry_date_range( '2026-03-12', '' ) );
	}

	public function test_format_range_empty() {
		$this->assertSame( '', restwell_format_enquiry_date_range( '', '' ) );
	}

	public function test_rejects_same_day_departure() {
		$this->assertNotEmpty( restwell_validate_enquiry_dates( '2026-09-10', '2026-09-10' ) );
	}

	public function test_accepts_one_night_stay() {
		$this->assertSame( array(), restwell_validate_enquiry_dates( '2026-09-10', '2026-09-11' ) );
	}

	public function test_guest_count_bounds() {
		$this->assertSame( array(), restwell_validate_enquiry_guests( '' ) );
		$this->assertSame( array(), restwell_validate_enquiry_guests( '1' ) );
		$this->assertSame( array(), restwell_validate_enquiry_guests( '5' ) );
		$this->assertNotEmpty( restwell_validate_enquiry_guests( '0' ) );
		$this->assertNotEmpty( restwell_validate_enquiry_guests( '6' ) );
		$this->assertNotEmpty( restwell_validate_enquiry_guests( '9' ) );
		$this->assertNotEmpty( restwell_validate_enquiry_guests( '2.5' ) );
	}

	public function test_conversion_token_redeems_once() {
		set_transient( 'restwell_conv_abc123', 1, 1800 );
		$this->assertTrue( restwell_redeem_conversion_token( 'abc123' ) );
		$this->assertFalse( restwell_redeem_conversion_token( 'abc123' ), 'a reload must not count again' );
		$this->assertFalse( restwell_redeem_conversion_token( '' ) );
		$this->assertFalse( restwell_redeem_conversion_token( 'never-issued' ) );
	}
}
