<?php
/**
 * Occupancy ICS parser: busy nights only, never titles.
 *
 * @package Restwell_Retreats
 */

require_once dirname( __DIR__ ) . '/inc/occupancy.php';

class OccupancyIcalTest extends PHPUnit\Framework\TestCase {

	private function fixture_ics() {
		return implode(
			"\r\n",
			array(
				'BEGIN:VCALENDAR',
				'VERSION:2.0',
				'BEGIN:VEVENT',
				'DTSTART;TZID=GMT Standard Time:20260612T180000',
				'DTEND;TZID=GMT Standard Time:20260615T140000',
				'SUMMARY:Jane Guest',
				'LOCATION:101 Russell Drive secret note that must never print',
				'X-MICROSOFT-CDO-BUSYSTATUS:BUSY',
				'TRANSP:OPAQUE',
				'END:VEVENT',
				'BEGIN:VEVENT',
				'DTSTART;TZID=GMT Standard Time:20260622T150000',
				'DTEND;TZID=GMT Standard Time:20260625T110000',
				'SUMMARY:Booked',
				'X-MICROSOFT-CDO-BUSYSTATUS:BUSY',
				'TRANSP:OPAQUE',
				'END:VEVENT',
				'BEGIN:VEVENT',
				'DTSTART;TZID=GMT Standard Time:20261026T000000',
				'DTEND;TZID=GMT Standard Time:20261102T000000',
				'SUMMARY:School holidays',
				'X-MICROSOFT-CDO-BUSYSTATUS:FREE',
				'TRANSP:TRANSPARENT',
				'END:VEVENT',
				'BEGIN:VEVENT',
				'DTSTART;TZID=GMT Standard Time:20270409T160000',
				'DTEND;TZID=GMT Standard Time:20270409T163000',
				'SUMMARY:Office call',
				'X-MICROSOFT-CDO-BUSYSTATUS:BUSY',
				'TRANSP:OPAQUE',
				'END:VEVENT',
				'END:VCALENDAR',
			)
		);
	}

	public function test_busy_stay_marks_nights_not_checkout_day() {
		$dates = restwell_occupancy_parse_ics( $this->fixture_ics() );
		$this->assertContains( '2026-06-12', $dates );
		$this->assertContains( '2026-06-13', $dates );
		$this->assertContains( '2026-06-14', $dates );
		$this->assertNotContains( '2026-06-15', $dates );
		$this->assertNotContains( '2026-06-11', $dates );
		$this->assertContains( '2026-06-22', $dates );
		$this->assertContains( '2026-06-24', $dates );
		$this->assertNotContains( '2026-06-25', $dates );
	}

	public function test_all_day_block_holds_the_previous_checkout_morning() {
		$ics = implode(
			"\r\n",
			array(
				'BEGIN:VCALENDAR',
				'VERSION:2.0',
				'BEGIN:VEVENT',
				'DTSTART;VALUE=DATE:20261020',
				'DTEND;VALUE=DATE:20261021',
				'SUMMARY:All day hold that must never print',
				'X-MICROSOFT-CDO-BUSYSTATUS:BUSY',
				'TRANSP:OPAQUE',
				'END:VEVENT',
				'END:VCALENDAR',
			)
		);
		$dates = restwell_occupancy_parse_ics( $ics );
		$this->assertContains( '2026-10-19', $dates );
		$this->assertContains( '2026-10-20', $dates );
		$this->assertNotContains( '2026-10-18', $dates );
		$this->assertNotContains( '2026-10-21', $dates );
		$this->assertStringNotContainsString( 'All day', implode( ',', $dates ) );
	}

	public function test_afternoon_arrival_does_not_hold_the_previous_night() {
		$ics = implode(
			"\r\n",
			array(
				'BEGIN:VCALENDAR',
				'VERSION:2.0',
				'BEGIN:VEVENT',
				'DTSTART;TZID=GMT Standard Time:20261020T150000',
				'DTEND;TZID=GMT Standard Time:20261026T110000',
				'X-MICROSOFT-CDO-BUSYSTATUS:BUSY',
				'TRANSP:OPAQUE',
				'END:VEVENT',
				'END:VCALENDAR',
			)
		);
		$dates = restwell_occupancy_parse_ics( $ics );
		$this->assertNotContains( '2026-10-19', $dates );
		$this->assertContains( '2026-10-20', $dates );
		$this->assertContains( '2026-10-25', $dates );
		$this->assertNotContains( '2026-10-26', $dates );
	}

	public function test_free_ranges_and_short_meetings_are_ignored() {
		$dates = restwell_occupancy_parse_ics( $this->fixture_ics() );
		$this->assertNotContains( '2026-10-26', $dates );
		$this->assertNotContains( '2026-11-01', $dates );
		$this->assertNotContains( '2027-04-09', $dates );
	}

	public function test_output_never_includes_event_text() {
		$dates = restwell_occupancy_parse_ics( $this->fixture_ics() );
		$blob = implode( ',', $dates );
		$this->assertStringNotContainsString( 'Jane', $blob );
		$this->assertStringNotContainsString( 'Guest', $blob );
		$this->assertStringNotContainsString( 'Russell', $blob );
		$this->assertStringNotContainsString( 'School', $blob );
		$this->assertStringNotContainsString( 'Office', $blob );
	}

	public function test_sanitize_rejects_html_preview_and_non_outlook_hosts() {
		$this->assertSame(
			'',
			restwell_occupancy_sanitize_feed_url( 'https://outlook.office365.com/owa/calendar/abc/calendar.html' )
		);
		$this->assertSame(
			'',
			restwell_occupancy_sanitize_feed_url( 'https://example.com/calendar.ics' )
		);
	}

	public function test_sanitize_accepts_outlook_ics() {
		$url = 'https://outlook.office365.com/owa/calendar/abc@restwellretreats.co.uk/token/calendar.ics';
		$this->assertSame( $url, restwell_occupancy_sanitize_feed_url( $url ) );
	}

	public function test_booked_nights_collapse_to_inclusive_ranges() {
		$ranges = restwell_occupancy_booked_ranges(
			array(
				'2026-09-04',
				'2026-09-01',
				'2026-09-02',
				'2026-09-01',
			)
		);
		$this->assertSame(
			array(
				array(
					'start' => '2026-09-01',
					'end'   => '2026-09-02',
				),
				array(
					'start' => '2026-09-04',
					'end'   => '2026-09-04',
				),
			),
			$ranges
		);
		$this->assertSame( '1–2 September', restwell_occupancy_format_range_label( '2026-09-01', '2026-09-02' ) );
		$this->assertSame( '28 September – 4 October', restwell_occupancy_format_range_label( '2026-09-28', '2026-10-04' ) );
	}

	public function test_sanitize_ymd_accepts_only_real_calendar_days() {
		$this->assertSame( '2026-10-09', restwell_occupancy_sanitize_ymd( '2026-10-09' ) );
		$this->assertSame( '', restwell_occupancy_sanitize_ymd( '2026-13-01' ) );
		$this->assertSame( '', restwell_occupancy_sanitize_ymd( 'tomorrow' ) );
	}
}
