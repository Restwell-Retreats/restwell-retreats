<?php
/**
 * CRM CSV care/accessibility redaction.
 *
 * @package Restwell_Retreats
 */

class CrmExportRedactTest extends PHPUnit\Framework\TestCase {

	public function test_redacts_care_and_access_by_default() {
		$rows = array(
			array(
				'name'               => 'Test Guest',
				'care_requirements'  => 'overnight support',
				'accessibility'      => 'hoist needed',
				'message'            => 'hello',
			),
		);
		$out = restwell_crm_redact_sensitive_export_rows( $rows, false );
		$this->assertSame( '', $out[0]['care_requirements'] );
		$this->assertSame( '', $out[0]['accessibility'] );
		$this->assertSame( 'hello', $out[0]['message'] );
		$this->assertSame( 'Test Guest', $out[0]['name'] );
	}

	public function test_keeps_care_when_sensitive_export_requested() {
		$rows = array(
			array(
				'care_requirements' => 'overnight support',
				'accessibility'     => 'hoist needed',
			),
		);
		$out = restwell_crm_redact_sensitive_export_rows( $rows, true );
		$this->assertSame( 'overnight support', $out[0]['care_requirements'] );
		$this->assertSame( 'hoist needed', $out[0]['accessibility'] );
	}
}
