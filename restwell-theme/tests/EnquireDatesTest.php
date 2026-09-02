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
}
