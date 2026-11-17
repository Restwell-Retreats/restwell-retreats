<?php
/**
 * CSV exports never hand a spreadsheet a formula.
 *
 * @package Restwell_Retreats
 */

class CrmCsvSafeTest extends PHPUnit\Framework\TestCase {

	public function test_formula_starts_get_an_apostrophe() {
		$this->assertSame( "'=HYPERLINK(\"http://x\",\"y\")", restwell_crm_csv_safe_cell( '=HYPERLINK("http://x","y")' ) );
		$this->assertSame( "'+cmd|' /C calc'!A0", restwell_crm_csv_safe_cell( "+cmd|' /C calc'!A0" ) );
		$this->assertSame( "'-2+3", restwell_crm_csv_safe_cell( '-2+3' ) );
		$this->assertSame( "'@SUM(A1)", restwell_crm_csv_safe_cell( '@SUM(A1)' ) );
		$this->assertSame( "'\t=1", restwell_crm_csv_safe_cell( "\t=1" ) );
		$this->assertSame( "'\r=1", restwell_crm_csv_safe_cell( "\r=1" ) );
	}

	public function test_ordinary_values_are_unchanged() {
		foreach ( array( 'Jane Smith', 'jane@example.com', '+447700900123', '-5', '2026-12-04', '', 'Meta ad', 'Hello = world' ) as $value ) {
			$this->assertSame( $value, restwell_crm_csv_safe_cell( $value ) );
		}
		$this->assertNull( restwell_crm_csv_safe_cell( null ) );
		$this->assertSame( 3, restwell_crm_csv_safe_cell( 3 ) );
	}

	public function test_row_keeps_its_keys() {
		$this->assertSame(
			array(
				'name'    => "'=1+1",
				'message' => 'Hi',
			),
			restwell_crm_csv_safe_row(
				array(
					'name'    => '=1+1',
					'message' => 'Hi',
				)
			)
		);
	}
}
