<?php
/**
 * Enquire front-end split: live stepper is shared.js, not enquire.js.
 *
 * @package Restwell_Retreats
 */

class EnquireJsSplitTest extends PHPUnit\Framework\TestCase {

	public function test_dead_multistep_init_is_gone() {
		$js = (string) file_get_contents( dirname( __DIR__ ) . '/assets/js/enquire.js' );
		$this->assertStringNotContainsString( 'initMultiStepForm', $js );
		$this->assertStringContainsString( 'initEnquiryDateConstraints', $js );
		$this->assertStringContainsString( '#enq-from', $js );
		$this->assertStringContainsString( '#enq-to', $js );
		$this->assertStringContainsString( 'readUrlStayDates', $js );
		$this->assertStringNotContainsString( "querySelector('#enq_date_from')", $js );
		$this->assertStringContainsString( 'initEnquiryDraftPersistence', $js );
	}
}
