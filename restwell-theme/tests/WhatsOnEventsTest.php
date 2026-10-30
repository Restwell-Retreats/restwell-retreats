<?php
/**
 * Whitstable guide What's on: slot parsing, expiry at day boundaries,
 * multi-day ranges, date labels and the 30-day tidy-up.
 *
 * @package Restwell_Retreats
 */

if ( ! function_exists( 'wp_timezone' ) ) {
	function wp_timezone() {
		return new DateTimeZone( 'Europe/London' );
	}
}
if ( ! function_exists( 'wp_date' ) ) {
	function wp_date( $format, $timestamp = null, $timezone = null ) {
		$zone = $timezone ? $timezone : wp_timezone();
		return ( new DateTimeImmutable( '@' . ( null === $timestamp ? time() : $timestamp ) ) )->setTimezone( $zone )->format( $format );
	}
}

require_once dirname( __DIR__ ) . '/inc/whats-on.php';

class WhatsOnEventsTest extends PHPUnit\Framework\TestCase {

	/**
	 * Slot values as the meta box stores them.
	 *
	 * @param array<int, array<string, string>> $slots Slot number => part => value.
	 * @return array<string, string>
	 */
	private static function values( array $slots ): array {
		$values = restwell_whats_on_default_values();
		foreach ( $slots as $slot => $parts ) {
			foreach ( $parts as $part => $value ) {
				$values[ "wg_event_{$slot}_{$part}" ] = $value;
			}
		}
		return $values;
	}

	private static function names( array $events ): array {
		return array_column( $events, 'name' );
	}

	public function test_eight_slots_with_date_and_url_fields() {
		$fields = restwell_whats_on_field_definitions();
		$this->assertCount( 8 * 6, $fields );
		$this->assertSame( 'date', $fields['wg_event_1_start']['type'] );
		$this->assertSame( 'date', $fields['wg_event_8_end']['type'] );
		$this->assertSame( 'url', $fields['wg_event_3_url']['type'] );
		$this->assertSame( 'text', $fields['wg_event_5_time']['type'] );
		$this->assertSame( 'Event 8 venue or area (e.g. Long Beach)', $fields['wg_event_8_venue']['label'] );
		$this->assertSame( array_keys( $fields ), array_keys( restwell_whats_on_default_values() ) );
		$this->assertSame( array( '' ), array_values( array_unique( restwell_whats_on_default_values() ) ) );
	}

	public function test_empty_and_undated_slots_are_skipped() {
		$events = restwell_whats_on_parse_slots(
			self::values(
				array(
					1 => array( 'name' => 'Quiz night' ),
					2 => array( 'start' => '2026-11-21' ),
					3 => array(
						'name'  => 'Bad date',
						'start' => '2026-02-30',
					),
					5 => array(
						'name'  => '  Carols on the harbour  ',
						'start' => '2026-12-19',
						'time'  => ' from 6pm ',
						'venue' => 'South Quay',
					),
				)
			)
		);
		$this->assertCount( 1, $events );
		$this->assertSame(
			array(
				'slot'  => 5,
				'name'  => 'Carols on the harbour',
				'start' => '2026-12-19',
				'end'   => '',
				'time'  => 'from 6pm',
				'venue' => 'South Quay',
				'url'   => '',
			),
			$events[0]
		);
		$this->assertSame( array(), restwell_whats_on_parse_slots( restwell_whats_on_default_values() ) );
	}

	public function test_end_dates_and_links_are_checked() {
		$events = restwell_whats_on_parse_slots(
			self::values(
				array(
					1 => array(
						'name'  => 'Same day',
						'start' => '2026-11-21',
						'end'   => '2026-11-21',
						'url'   => 'javascript:alert(1)',
					),
					2 => array(
						'name'  => 'Backwards',
						'start' => '2026-11-21',
						'end'   => '2026-11-20',
						'url'   => 'https://example.org/backwards',
					),
					3 => array(
						'name'  => 'Festival',
						'start' => '2026-09-11',
						'end'   => '2026-09-13',
						'url'   => 'http://example.org/festival',
					),
				)
			)
		);
		$this->assertSame( array( '', '', '2026-09-13' ), array_column( $events, 'end' ) );
		$this->assertSame( array( '', 'https://example.org/backwards', 'http://example.org/festival' ), array_column( $events, 'url' ) );
	}

	public function test_one_day_event_shows_through_its_day_and_hides_the_next() {
		$events = restwell_whats_on_parse_slots(
			self::values(
				array(
					1 => array(
						'name'  => 'Market',
						'start' => '2026-11-21',
					),
				)
			)
		);
		$this->assertSame( array( 'Market' ), self::names( restwell_whats_on_upcoming( $events, '2026-11-20' ) ) );
		$this->assertSame( array( 'Market' ), self::names( restwell_whats_on_upcoming( $events, '2026-11-21' ) ), 'Still shows on the day.' );
		$this->assertSame( array(), restwell_whats_on_upcoming( $events, '2026-11-22' ), 'Gone the day after.' );
	}

	public function test_multi_day_event_shows_until_its_end_date() {
		$events = restwell_whats_on_parse_slots(
			self::values(
				array(
					1 => array(
						'name'  => 'Oyster Festival',
						'start' => '2026-09-11',
						'end'   => '2026-09-13',
					),
				)
			)
		);
		$this->assertCount( 1, restwell_whats_on_upcoming( $events, '2026-09-12' ), 'Shows while it is on.' );
		$this->assertCount( 1, restwell_whats_on_upcoming( $events, '2026-09-13' ), 'Shows on its last day.' );
		$this->assertSame( array(), restwell_whats_on_upcoming( $events, '2026-09-14' ) );
	}

	public function test_next_six_soonest_first_from_eight_slots() {
		$slots = array();
		foreach ( array( '2026-12-05', '2026-11-25', '2026-10-28', '2026-11-30', '2026-12-24', '2026-11-22', '2026-12-01', '2026-11-29' ) as $n => $date ) {
			$slots[ $n + 1 ] = array(
				'name'  => 'Slot ' . ( $n + 1 ),
				'start' => $date,
			);
		}
		// Slot 3 (28 Oct) has passed; slot 5 (24 Dec) is seventh of the seven left.
		$this->assertSame(
			array( 'Slot 6', 'Slot 2', 'Slot 8', 'Slot 4', 'Slot 7', 'Slot 1' ),
			self::names( restwell_whats_on_upcoming( restwell_whats_on_parse_slots( self::values( $slots ) ), '2026-10-29' ) )
		);
	}

	public function test_today_follows_the_site_timezone() {
		// 23:30 UTC on 10 June is 00:30 on 11 June in London (BST).
		$this->assertSame( '2026-06-11', restwell_whats_on_today( gmmktime( 23, 30, 0, 6, 10, 2026 ) ) );
		// In winter London is on UTC, so the date doesn't move.
		$this->assertSame( '2026-11-20', restwell_whats_on_today( gmmktime( 23, 30, 0, 11, 20, 2026 ) ) );
	}

	public function test_date_labels_in_british_format() {
		$parts = static function ( $start, $end = '' ) {
			return restwell_whats_on_date_parts(
				array(
					'start' => $start,
					'end'   => $end,
				)
			);
		};
		$this->assertSame( array( array( 'iso' => '2026-11-21', 'label' => '21 Nov' ) ), $parts( '2026-11-21' ) );
		$this->assertSame( array( array( 'iso' => '2026-03-29', 'label' => '29 Mar' ) ), $parts( '2026-03-29' ), 'Clocks-change day keeps its date.' );
		$this->assertSame(
			array( array( 'iso' => '2026-09-11', 'label' => '11' ), array( 'iso' => '2026-09-13', 'label' => '13 Sep' ) ),
			$parts( '2026-09-11', '2026-09-13' )
		);
		$this->assertSame(
			array( array( 'iso' => '2026-08-28', 'label' => '28 Aug' ), array( 'iso' => '2026-09-02', 'label' => '2 Sep' ) ),
			$parts( '2026-08-28', '2026-09-02' )
		);
		$this->assertSame( array( '30 Dec', '2 Jan' ), array_column( $parts( '2026-12-30', '2027-01-02' ), 'label' ) );
	}

	public function test_weekday_label_above_the_date() {
		$days = static function ( $start, $end = '' ) {
			return restwell_whats_on_weekdays(
				array(
					'start' => $start,
					'end'   => $end,
				)
			);
		};
		$this->assertSame( 'Sat', $days( '2026-11-21' ) );
		$this->assertSame( 'Sun', $days( '2026-03-29' ), 'Clocks-change day keeps its weekday.' );
		$this->assertSame( 'Sat–Sun', $days( '2026-11-28', '2026-11-29' ) );
		$this->assertSame( 'Fri–Sun', $days( '2026-09-11', '2026-09-13' ) );
	}

	public function test_tidy_up_clears_slots_ended_more_than_thirty_days_ago() {
		$values = self::values(
			array(
				1 => array(
					'name'  => 'Ended 31 days ago',
					'start' => '2026-09-28',
				),
				2 => array(
					'name'  => 'Ended 30 days ago',
					'start' => '2026-09-29',
				),
				3 => array(
					'name'  => 'Long run, ended recently',
					'start' => '2026-08-01',
					'end'   => '2026-10-01',
				),
				4 => array(
					'name'  => 'Long run, ended long ago',
					'start' => '2026-07-01',
					'end'   => '2026-09-01',
				),
				5 => array( 'name' => 'No date yet' ),
				6 => array(
					'name'  => 'Coming up',
					'start' => '2026-12-01',
				),
			)
		);
		$this->assertSame( array( 1, 4 ), restwell_whats_on_stale_slots( $values, '2026-10-29' ) );
		$this->assertSame(
			array(
				'name'  => 'wg_event_4_name',
				'start' => 'wg_event_4_start',
				'end'   => 'wg_event_4_end',
				'time'  => 'wg_event_4_time',
				'venue' => 'wg_event_4_venue',
				'url'   => 'wg_event_4_url',
			),
			restwell_whats_on_slot_keys( 4 )
		);
	}
}
