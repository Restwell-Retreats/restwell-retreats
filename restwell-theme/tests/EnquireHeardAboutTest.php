<?php
/**
 * Enquiry “how did you hear about us” helpers.
 *
 * @package Restwell_Retreats
 */

class EnquireHeardAboutTest extends PHPUnit\Framework\TestCase {

	public function test_unknown_slug_is_empty() {
		$this->assertSame( '', restwell_enquiry_normalise_heard_about( 'billboard' ) );
	}

	public function test_known_slug_is_kept() {
		$this->assertSame( 'continuity', restwell_enquiry_normalise_heard_about( 'continuity' ) );
	}

	public function test_store_known_slug_without_detail() {
		$this->assertSame( 'google', restwell_enquiry_store_heard_about( 'google', 'ignored extra' ) );
	}

	public function test_store_other_with_detail() {
		$this->assertSame( 'other:Nextdoor', restwell_enquiry_store_heard_about( 'other', 'Nextdoor' ) );
	}

	public function test_label_for_other_with_detail() {
		$this->assertSame(
			'Somewhere else — Nextdoor',
			restwell_enquiry_heard_about_label( 'other:Nextdoor' )
		);
	}

	public function test_label_for_empty() {
		$this->assertSame( '', restwell_enquiry_heard_about_label( '' ) );
	}

	public function test_contact_pref_slug_becomes_label() {
		$this->assertSame( 'Email', restwell_enquiry_contact_pref_label( 'email' ) );
		$this->assertSame( 'Phone', restwell_enquiry_contact_pref_label( 'phone' ) );
		$this->assertSame( 'Either', restwell_enquiry_contact_pref_label( 'either' ) );
	}
}
