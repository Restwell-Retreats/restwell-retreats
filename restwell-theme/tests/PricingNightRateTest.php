<?php
/**
 * Nightly bungalow rates and guide stay totals.
 *
 * @package Restwell_Retreats
 */

require_once dirname( __DIR__ ) . '/inc/pricing.php';

class PricingNightRateTest extends PHPUnit\Framework\TestCase {

	public function test_weekend_nights_are_friday_to_sunday() {
		$this->assertFalse( restwell_is_weekend_night( '2026-09-03' ) ); // Thursday.
		$this->assertTrue( restwell_is_weekend_night( '2026-09-04' ) ); // Friday.
		$this->assertTrue( restwell_is_weekend_night( '2026-09-06' ) ); // Sunday.
		$this->assertFalse( restwell_is_weekend_night( '2026-09-07' ) ); // Monday.
		$this->assertFalse( restwell_is_weekend_night( 'not-a-date' ) );
	}

	public function test_night_rate_uses_season_and_weekend_split() {
		$this->assertSame( 200, restwell_night_rate_gbp( '2026-09-01' ) ); // Tue peak midweek.
		$this->assertSame( 185, restwell_night_rate_gbp( '2026-09-02' ) ); // Wed off-peak midweek.
		$this->assertSame( 235, restwell_night_rate_gbp( '2026-09-04' ) ); // Fri off-peak weekend.
		$this->assertSame( 255, restwell_night_rate_gbp( '2026-07-25' ) ); // Sat peak weekend.
		$this->assertSame( 0, restwell_night_rate_gbp( 'nope' ) );
	}

	public function test_seven_off_peak_nights_use_week_rate() {
		$nights = array(
			'2026-09-07',
			'2026-09-08',
			'2026-09-09',
			'2026-09-10',
			'2026-09-11',
			'2026-09-12',
			'2026-09-13',
		);
		$quote = restwell_guide_stay_total( $nights );
		$this->assertSame( 7, $quote['nights'] );
		$this->assertTrue( $quote['weekly'] );
		$this->assertSame( 1300, $quote['total'] );
	}

	public function test_mixed_season_week_sums_nightly() {
		$nights = array(
			'2026-08-30',
			'2026-08-31',
			'2026-09-01',
			'2026-09-02',
			'2026-09-03',
			'2026-09-04',
			'2026-09-05',
		);
		$quote = restwell_guide_stay_total( $nights );
		$this->assertFalse( $quote['weekly'] );
		$sum   = 0;
		foreach ( $nights as $iso ) {
			$sum += restwell_night_rate_gbp( $iso );
		}
		$this->assertSame( $sum, $quote['total'] );
	}

	public function test_single_night_is_the_published_rate() {
		$quote = restwell_guide_stay_total( array( '2026-09-02' ) );
		$this->assertSame( 1, $quote['nights'] );
		$this->assertFalse( $quote['weekly'] );
		$this->assertSame( 185, $quote['total'] );
	}
}
