<?php
/**
 * Pricing data helper: single source of truth for bungalow rates, peak dates,
 * deposit rules, and Continuity of Care Services guide rates.
 *
 * Consumed by template-pricing.php, LodgingBusiness JSON-LD, and (later) Job 12 calculator.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Seasonal bungalow rates, peak date ranges, deposit rules, and care guide rates.
 *
 * @return array{
 *   currency: string,
 *   currency_symbol: string,
 *   deposit_percent: int,
 *   balance_due_days_before: int,
 *   minimum_nights: int,
 *   security_deposit: bool,
 *   cleaning_fee: bool,
 *   check_in: string,
 *   check_out: string,
 *   seasons: array<string, array{label: string, full_week: int, midweek_night: int, weekend_night: int}>,
 *   peak_ranges: array<int, array{start: string, end: string, label: string}>,
 *   care: array<string, mixed>,
 *   price_range_schema: string
 * }
 */
function restwell_get_pricing(): array {
	$seasons = array(
		'off_peak' => array(
			'label'          => __( 'Off-peak season', 'restwell-retreats' ),
			'full_week'      => 1300,
			'midweek_night'  => 185,
			'weekend_night'  => 235,
		),
		'peak'     => array(
			'label'          => __( 'Peak season', 'restwell-retreats' ),
			'full_week'      => 1400,
			'midweek_night'  => 200,
			'weekend_night'  => 255,
		),
	);

	$peak_ranges = array(
		array(
			'start' => '2026-07-22',
			'end'   => '2026-09-01',
			'label' => '22 July to 1 September 2026',
		),
		array(
			'start' => '2026-10-26',
			'end'   => '2026-11-01',
			'label' => '26 October to 1 November 2026',
		),
		array(
			'start' => '2026-12-21',
			'end'   => '2027-01-03',
			'label' => '21 December 2026 to 3 January 2027',
		),
		array(
			'start' => '2027-02-15',
			'end'   => '2027-02-21',
			'label' => '15 to 21 February 2027',
		),
		array(
			'start' => '2027-03-29',
			'end'   => '2027-04-11',
			'label' => '29 March to 11 April 2027',
		),
		array(
			'start' => '2027-05-31',
			'end'   => '2027-06-06',
			'label' => '31 May to 6 June 2027',
		),
		array(
			'start' => '2027-07-22',
			'end'   => '2027-09-01',
			'label' => '22 July to 1 September 2027',
		),
	);

	$care = array(
		'provider'     => 'Continuity of Care Services',
		// Rate figures unchanged; next review confirmed with Continuity of Care Services.
		'valid_from'   => '2025-07-01',
		'valid_to'     => '2026-09-01',
		'valid_label'  => '1 September 2026',
		'guide_intro'  => __( 'Think of them as starting points: because the right support depends entirely on what each guest needs, your final cost is tailored to you and confirmed after a free, no-obligation conversation with the care team. Nobody is quoted a figure before we understand what would actually help.', 'restwell-retreats' ),
		'rows'         => array(
			array(
				'type'            => 'Personal, social, sit-in and escort care (7am to 10pm)',
				'weekday_display' => '£34.65 per hour',
				'weekend_display' => '£41.25 per hour',
				'weekday_from'    => 34.65,
				'weekend_from'    => 41.25,
				'unit'            => 'hour',
			),
			array(
				'type'            => 'Personal care overnight (10pm to 7am)',
				'weekday_display' => '£40.15 per hour',
				'weekend_display' => '£46.75 per hour',
				'weekday_from'    => 40.15,
				'weekend_from'    => 46.75,
				'unit'            => 'hour',
			),
			array(
				'type'            => 'Domestic care (7am to 10pm)',
				'weekday_display' => '£34.65 per hour',
				'weekend_display' => 'Not available at weekends',
				'weekday_from'    => 34.65,
				'weekend_from'    => null,
				'unit'            => 'hour',
			),
			array(
				'type'            => 'Complex care (7am to 10pm)',
				'weekday_display' => '£38.50 per hour',
				'weekend_display' => '£46.20 per hour',
				'weekday_from'    => 38.50,
				'weekend_from'    => 46.20,
				'unit'            => 'hour',
			),
			array(
				'type'            => 'Complex care overnight (10pm to 7am)',
				'weekday_display' => '£44.00 per hour',
				'weekend_display' => '£50.60 per hour',
				'weekday_from'    => 44.00,
				'weekend_from'    => 50.60,
				'unit'            => 'hour',
			),
			array(
				'type'            => 'Sleep-in night, fixed rate (10pm to 7am)',
				'weekday_display' => '£230.94 standard, £274.02 complex',
				'weekend_display' => '£230.94 standard, £293.16 complex',
				'weekday_from'    => 230.94,
				'weekend_from'    => 230.94,
				'unit'            => 'night',
			),
			array(
				'type'            => 'Waking night, fixed rate (10pm to 7am)',
				'weekday_display' => '£307.62 standard, £307.62 complex',
				'weekend_display' => '£307.62 standard, £334.21 complex',
				'weekday_from'    => 307.62,
				'weekend_from'    => 307.62,
				'unit'            => 'night',
			),
		),
		'notes'        => array(
			__( 'Escort outings, such as hospital appointments or shopping trips, are charged at 50p per mile plus any parking.', 'restwell-retreats' ),
			__( 'Bank holidays are charged at double the standard rate. Christmas Day, Boxing Day and New Year\'s Day are charged at treble, as is New Year\'s Eve after 7pm.', 'restwell-retreats' ),
			__( 'Care is optional and arranged separately from your stay. Tell us what you need when you enquire and we will put together a clear quote.', 'restwell-retreats' ),
		),
	);

	$off_peak_low  = (int) $seasons['off_peak']['midweek_night'];
	$peak_high     = (int) $seasons['peak']['full_week'];
	$price_range   = '£' . number_format_i18n( $off_peak_low ) . '-£' . number_format_i18n( $peak_high );

	$data = array(
		'currency'                 => 'GBP',
		'currency_symbol'          => '£',
		'deposit_percent'          => 50,
		'balance_due_days_before'  => 7,
		'minimum_nights'           => 0,
		'security_deposit'         => false,
		'cleaning_fee'             => false,
		'check_in'                 => '15:00',
		'check_out'                => '11:00',
		'seasons'                  => $seasons,
		'peak_ranges'              => $peak_ranges,
		'care'                     => $care,
		'price_range_schema'       => $price_range,
	);

	/**
	 * Filter the pricing data array.
	 *
	 * @param array $data Pricing data.
	 */
	return apply_filters( 'restwell_pricing', $data );
}

/**
 * Shared payment and arrival timeline (Pricing page + Terms).
 *
 * Balance due is the verified one-week rule (balance_due_days_before = 7).
 * Both surfaces must read from this helper so the copy cannot drift.
 *
 * @return array{
 *   deposit_percent: int,
 *   balance_due_days_before: int,
 *   balance_due_clause: string,
 *   balance_due_clause_you: string,
 *   check_in: string,
 *   check_out: string
 * }
 */
function restwell_get_payment_timeline(): array {
	$pricing = restwell_get_pricing();

	return array(
		'deposit_percent'         => isset( $pricing['deposit_percent'] ) ? (int) $pricing['deposit_percent'] : 50,
		'balance_due_days_before' => isset( $pricing['balance_due_days_before'] ) ? (int) $pricing['balance_due_days_before'] : 7,
		// Canonical phrases for the 7-day rule (British English).
		'balance_due_clause'      => __( 'no later than one week before arrival', 'restwell-retreats' ),
		'balance_due_clause_you'  => __( 'no later than one week before you arrive', 'restwell-retreats' ),
		'check_in'                => isset( $pricing['check_in'] ) ? (string) $pricing['check_in'] : '15:00',
		'check_out'               => isset( $pricing['check_out'] ) ? (string) $pricing['check_out'] : '11:00',
	);
}

/**
 * Terms & Conditions Payment section paragraph (HTML-safe plain text).
 *
 * @return string Escaped paragraph body without wrapping <p> tags.
 */
function restwell_get_terms_payment_paragraph(): string {
	$t = restwell_get_payment_timeline();

	return sprintf(
		/* translators: 1: deposit percent, 2: balance due clause e.g. "no later than one week before arrival" */
		esc_html__( 'A %1$d%% deposit secures your dates. The balance is due %2$s unless we agree otherwise in writing. We accept bank transfer (BACS) and debit or credit card.', 'restwell-retreats' ),
		(int) $t['deposit_percent'],
		esc_html( $t['balance_due_clause'] )
	);
}

/**
 * Format a pound amount for on-page display (British grouping).
 *
 * @param int|float $amount Amount in pounds.
 * @return string e.g. £1,300 or £34.65.
 */
function restwell_format_gbp( $amount ): string {
	$amount = (float) $amount;
	if ( abs( $amount - (int) $amount ) < 0.001 ) {
		return '£' . number_format_i18n( (int) $amount );
	}
	return '£' . number_format_i18n( $amount, 2 );
}

/**
 * Whether a Y-m-d date falls in a peak season range.
 *
 * @param string $ymd Date string Y-m-d.
 * @return bool
 */
function restwell_is_peak_date( string $ymd ): bool {
	$ymd = trim( $ymd );
	if ( ! preg_match( '/^\d{4}-\d{2}-\d{2}$/', $ymd ) ) {
		return false;
	}
	$pricing = restwell_get_pricing();
	foreach ( $pricing['peak_ranges'] as $range ) {
		if ( $ymd >= $range['start'] && $ymd <= $range['end'] ) {
			return true;
		}
	}
	return false;
}

/**
 * Schema.org priceRange string from restwell_get_pricing().
 *
 * @return string
 */
function restwell_get_pricing_price_range(): string {
	$pricing = restwell_get_pricing();
	return isset( $pricing['price_range_schema'] ) ? (string) $pricing['price_range_schema'] : '';
}

/**
 * Human-readable peak season date list (for the rates intro copy).
 *
 * @return string Comma-separated labels ending with "and …".
 */
function restwell_get_peak_season_labels_sentence(): string {
	$pricing = restwell_get_pricing();
	$labels  = array();
	foreach ( $pricing['peak_ranges'] as $range ) {
		$labels[] = $range['label'];
	}
	$count = count( $labels );
	if ( 0 === $count ) {
		return '';
	}
	if ( 1 === $count ) {
		return $labels[0];
	}
	$last = array_pop( $labels );
	return implode( ', ', $labels ) . ', and ' . $last;
}

/**
 * Default FAQ pairs for the Pricing page (visible accordion + FAQPage JSON-LD).
 *
 * @return array<int, array{q: string, a: string, cat: string}>
 */
function restwell_get_pricing_faq_defaults(): array {
	return array(
		array(
			'q'   => 'How much does an accessible holiday at Restwell cost?',
			'a'   => 'You book the whole step-free bungalow in Whitstable, with all access equipment included. A full week starts at £1,300 off-peak and £1,400 in peak season, with single nights from £185. A 50% deposit secures your dates and the balance is due one week before arrival.',
			'cat' => 'booking',
		),
		array(
			'q'   => 'Is care included in the price?',
			'a'   => 'No. The price covers the whole bungalow and all its access equipment. Care is optional and quoted separately through our sister company, Continuity of Care Services.',
			'cat' => 'care',
		),
		array(
			'q'   => 'Are there extra charges for using the equipment?',
			'a'   => 'No. The hoists, profiling beds and wet room equipment are part of the price, with no separate hire fees.',
			'cat' => 'booking',
		),
		array(
			'q'   => 'How much deposit do I pay to secure my dates?',
			'a'   => 'A 50% deposit secures your chosen dates, with the remaining balance due no later than one week before you arrive.',
			'cat' => 'booking',
		),
		array(
			'q'   => 'Do prices change depending on how my stay is funded?',
			'a'   => 'No. The same rates apply to every guest. The funding route only affects who we invoice, so it does not change the price of the bungalow.',
			'cat' => 'funding',
		),
	);
}
