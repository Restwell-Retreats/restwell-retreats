<?php
/**
 * Staff enquiry notification payload from a CRM row.
 *
 * @package Restwell_Retreats
 */

class EnquireNotificationDataTest extends PHPUnit\Framework\TestCase {

	public function test_maps_stored_columns_for_the_staff_email() {
		$row                      = new stdClass();
		$row->id                  = '42';
		$row->name                = 'Jane Hartley';
		$row->email               = 'jane@example.com';
		$row->phone               = '01622 809881';
		$row->contact_preference  = 'phone';
		$row->preferred_time      = 'Weekday mornings';
		$row->heard_about         = 'other:Disabled Holidays directory';
		$row->preferred_dates     = '12 Mar 2026 - 15 Mar 2026';
		$row->num_guests          = '2';
		$row->funding_type        = 'self';
		$row->care_requirements   = 'Overnight support';
		$row->accessibility       = 'Powerchair 620mm';
		$row->message             = "Hi,\nCan you confirm the hoist?";
		$row->is_urgent           = '1';

		$this->assertSame(
			array(
				'id'           => 42,
				'name'         => 'Jane Hartley',
				'email'        => 'jane@example.com',
				'phone'        => '01622 809881',
				'contact_pref' => 'phone',
				'pref_time'    => 'Weekday mornings',
				'heard_about'  => 'other:Disabled Holidays directory',
				'dates'        => '12 Mar 2026 - 15 Mar 2026',
				'guests'       => '2',
				'funding'      => 'self',
				'care'         => 'Overnight support',
				'access'       => 'Powerchair 620mm',
				'message'      => "Hi,\nCan you confirm the hoist?",
				'urgent'       => true,
			),
			restwell_enquiry_notification_data_from_row( $row )
		);
	}

	public function test_missing_optional_columns_are_empty_not_urgent() {
		$row = new stdClass();

		$out = restwell_enquiry_notification_data_from_row( $row );

		$this->assertSame( 0, $out['id'] );
		$this->assertSame( '', $out['name'] );
		$this->assertSame( '', $out['heard_about'] );
		$this->assertFalse( $out['urgent'] );
	}
}
