<?php
/**
 * Public booked-nights board (Pricing).
 *
 * Two months side by side on wide screens, one on phones. Each free night is
 * a button carrying its nightly rate; booked nights are hatched and struck
 * through; the chosen stay is one continuous band from the arrival coin to
 * the leave-morning coin. Further months are built client-side from
 * data-booked / data-pricing.
 *
 * $args['months']     int Months rendered server-side (default 2).
 * $args['max_months'] int Furthest month the pager reaches (default 12).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'restwell_occupancy_is_configured' ) || ! restwell_occupancy_is_configured() ) {
	get_template_part( 'template-parts/availability-unavailable' );
	return;
}

$availability_args = wp_parse_args(
	$args ?? array(),
	array(
		'months'     => 2,
		'max_months' => 12,
	)
);

$occupancy = restwell_get_occupancy_booked();
if ( empty( $occupancy['ok'] ) ) {
	get_template_part( 'template-parts/availability-unavailable' );
	return;
}

$london    = new DateTimeZone( 'Europe/London' );
$today     = new DateTime( 'today', $london );
$today_iso = $today->format( 'Y-m-d' );

// Only today onward reaches the page: past occupancy is not published.
$upcoming_booked = array_values(
	array_filter(
		(array) $occupancy['dates'],
		static function ( $iso ) use ( $today_iso ) {
			return is_string( $iso ) && $iso >= $today_iso;
		}
	)
);
$booked_lookup = array_fill_keys( $upcoming_booked, true );
$month_count   = max( 1, min( 4, (int) $availability_args['months'] ) );
$max_months    = max( $month_count, min( 18, (int) $availability_args['max_months'] ) );

$weekdays = array(
	array(
		'short' => __( 'Mo', 'restwell-retreats' ),
		'long'  => __( 'Monday', 'restwell-retreats' ),
	),
	array(
		'short' => __( 'Tu', 'restwell-retreats' ),
		'long'  => __( 'Tuesday', 'restwell-retreats' ),
	),
	array(
		'short' => __( 'We', 'restwell-retreats' ),
		'long'  => __( 'Wednesday', 'restwell-retreats' ),
	),
	array(
		'short' => __( 'Th', 'restwell-retreats' ),
		'long'  => __( 'Thursday', 'restwell-retreats' ),
	),
	array(
		'short' => __( 'Fr', 'restwell-retreats' ),
		'long'  => __( 'Friday', 'restwell-retreats' ),
	),
	array(
		'short' => __( 'Sa', 'restwell-retreats' ),
		'long'  => __( 'Saturday', 'restwell-retreats' ),
	),
	array(
		'short' => __( 'Su', 'restwell-retreats' ),
		'long'  => __( 'Sunday', 'restwell-retreats' ),
	),
);
$enquire_url = function_exists( 'restwell_nav_resolve_page_url' )
	? restwell_nav_resolve_page_url( 'enquire' )
	: home_url( '/enquire/' );
$privacy_url = function_exists( 'restwell_nav_resolve_page_url' )
	? restwell_nav_resolve_page_url( 'privacy-policy' )
	: home_url( '/privacy-policy/' );

$pricing   = function_exists( 'restwell_get_pricing' ) ? restwell_get_pricing() : array();
$week_off  = isset( $pricing['seasons']['off_peak']['full_week'] ) ? (int) $pricing['seasons']['off_peak']['full_week'] : 0;
$week_peak = isset( $pricing['seasons']['peak']['full_week'] ) ? (int) $pricing['seasons']['peak']['full_week'] : 0;
$check_in  = isset( $pricing['check_in'] ) ? (string) $pricing['check_in'] : '15:00';
$check_out = isset( $pricing['check_out'] ) ? (string) $pricing['check_out'] : '11:00';

$pricing_payload = array(
	'off_mid'   => isset( $pricing['seasons']['off_peak']['midweek_night'] ) ? (int) $pricing['seasons']['off_peak']['midweek_night'] : 0,
	'off_wknd'  => isset( $pricing['seasons']['off_peak']['weekend_night'] ) ? (int) $pricing['seasons']['off_peak']['weekend_night'] : 0,
	'peak_mid'  => isset( $pricing['seasons']['peak']['midweek_night'] ) ? (int) $pricing['seasons']['peak']['midweek_night'] : 0,
	'peak_wknd' => isset( $pricing['seasons']['peak']['weekend_night'] ) ? (int) $pricing['seasons']['peak']['weekend_night'] : 0,
	'peaks'     => array(),
);
if ( ! empty( $pricing['peak_ranges'] ) && is_array( $pricing['peak_ranges'] ) ) {
	foreach ( $pricing['peak_ranges'] as $range ) {
		$pricing_payload['peaks'][] = array(
			's' => isset( $range['start'] ) ? (string) $range['start'] : '',
			'e' => isset( $range['end'] ) ? (string) $range['end'] : '',
		);
	}
}
$booked_json   = wp_json_encode( $upcoming_booked );
$pricing_json  = wp_json_encode( $pricing_payload );
$weekday_short = wp_json_encode( wp_list_pluck( $weekdays, 'short' ) );
$weekday_long  = wp_json_encode( wp_list_pluck( $weekdays, 'long' ) );
$times_line    = sprintf(
	/* translators: 1: check-in time, 2: check-out time */
	__( 'Arrive from %1$s, leave by %2$s.', 'restwell-retreats' ),
	$check_in,
	$check_out
);
?>
<section class="section-y band-subtle" id="availability" aria-labelledby="availability-h">
	<div class="container">
		<header class="section-head section-head--tight">
			<p class="eyebrow"><?php esc_html_e( 'Dates', 'restwell-retreats' ); ?></p>
			<h2 id="availability-h"><?php esc_html_e( 'Which nights are free', 'restwell-retreats' ); ?></h2>
		</header>
		<div
			class="availability"
			data-availability
			data-enquire-url="<?php echo esc_url( $enquire_url ); ?>"
			data-week-offpeak="<?php echo esc_attr( (string) $week_off ); ?>"
			data-week-peak="<?php echo esc_attr( (string) $week_peak ); ?>"
			data-max-months="<?php echo esc_attr( (string) $max_months ); ?>"
			data-today="<?php echo esc_attr( $today_iso ); ?>"
			data-booked="<?php echo esc_attr( is_string( $booked_json ) ? $booked_json : '[]' ); ?>"
			data-pricing="<?php echo esc_attr( is_string( $pricing_json ) ? $pricing_json : '{}' ); ?>"
			data-weekdays="<?php echo esc_attr( is_string( $weekday_short ) ? $weekday_short : '[]' ); ?>"
			data-weekdays-long="<?php echo esc_attr( is_string( $weekday_long ) ? $weekday_long : '[]' ); ?>"
		>
			<div class="availability__board">
				<div class="availability__toolbar">
					<button type="button" class="availability__nav" data-availability-prev aria-label="<?php esc_attr_e( 'Previous month', 'restwell-retreats' ); ?>" disabled>
						<svg viewBox="0 0 16 16" aria-hidden="true" focusable="false"><path d="M10 3 5 8l5 5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</button>
					<ul class="availability__legend" role="list">
						<li class="availability__key is-free"><span class="availability__swatch" aria-hidden="true">£</span><?php esc_html_e( 'Free, price per night', 'restwell-retreats' ); ?></li>
						<li class="availability__key is-booked"><span class="availability__swatch" aria-hidden="true"></span><?php esc_html_e( 'Booked', 'restwell-retreats' ); ?></li>
						<li class="availability__key is-peak"><span class="availability__swatch" aria-hidden="true">£</span><?php esc_html_e( 'Peak rate', 'restwell-retreats' ); ?></li>
						<li class="availability__key is-today"><span class="availability__swatch" aria-hidden="true"></span><?php esc_html_e( 'Today', 'restwell-retreats' ); ?></li>
					</ul>
					<button type="button" class="availability__nav" data-availability-next aria-label="<?php esc_attr_e( 'Next month', 'restwell-retreats' ); ?>">
						<svg viewBox="0 0 16 16" aria-hidden="true" focusable="false"><path d="m6 3 5 5-5 5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</button>
				</div>

				<div class="availability__months" data-availability-months>
					<?php
					for ( $i = 0; $i < $month_count; $i++ ) :
						$month = new DateTime( 'first day of this month', $london );
						if ( $i > 0 ) {
							$month->modify( '+' . $i . ' month' );
						}
						$cal_year   = (int) $month->format( 'Y' );
						$month_num  = (int) $month->format( 'n' );
						$days_in    = (int) $month->format( 't' );
						$lead       = (int) $month->format( 'N' ) - 1;
						$month_id   = 'availability-m-' . $month->format( 'Y-m' );
						$month_name = $month->format( 'F Y' );
						?>
						<article class="availability__month" data-availability-month aria-labelledby="<?php echo esc_attr( $month_id ); ?>">
							<h3 id="<?php echo esc_attr( $month_id ); ?>" class="availability__month-title"><?php echo esc_html( $month_name ); ?></h3>
							<table class="availability__grid" role="grid" aria-labelledby="<?php echo esc_attr( $month_id ); ?>">
								<thead>
									<tr>
										<?php foreach ( $weekdays as $weekday ) : ?>
											<th scope="col"><abbr title="<?php echo esc_attr( $weekday['long'] ); ?>"><?php echo esc_html( $weekday['short'] ); ?></abbr></th>
										<?php endforeach; ?>
									</tr>
								</thead>
								<tbody>
									<?php
									$cell = 0;
									echo '<tr>';
									for ( $pad = 0; $pad < $lead; $pad++ ) {
										echo '<td class="availability__day is-pad" aria-hidden="true"></td>';
										++$cell;
									}
									for ( $day = 1; $day <= $days_in; $day++ ) {
										if ( 0 === $cell % 7 && $cell > 0 ) {
											echo '</tr><tr>';
										}
										$iso       = sprintf( '%04d-%02d-%02d', $cal_year, $month_num, $day );
										$is_past   = $iso < $today_iso;
										$is_booked = ! $is_past && isset( $booked_lookup[ $iso ] );
										$is_today  = $iso === $today_iso;
										$is_peak   = ! $is_past && function_exists( 'restwell_is_peak_date' ) && restwell_is_peak_date( $iso );
										$is_pick   = ! $is_booked && ! $is_past;
										$rate      = $is_pick && function_exists( 'restwell_night_rate_gbp' ) ? (int) restwell_night_rate_gbp( $iso ) : 0;

										$classes = array( 'availability__day' );
										if ( $is_booked ) {
											$classes[] = 'is-booked';
										}
										if ( $is_today ) {
											$classes[] = 'is-today';
										}
										if ( $is_past ) {
											$classes[] = 'is-past';
										}
										if ( $is_peak ) {
											$classes[] = 'is-peak';
										}
										if ( $is_pick ) {
											$classes[] = 'is-pick';
										}

										$day_date = DateTime::createFromFormat( '!Y-m-d', $iso, $london );
										$spoken   = $day_date ? $day_date->format( 'l j F Y' ) : $iso;

										echo '<td class="' . esc_attr( implode( ' ', $classes ) ) . '" data-iso="' . esc_attr( $iso ) . '"';
										if ( $rate > 0 ) {
											echo ' data-rate="' . esc_attr( (string) $rate ) . '"';
										}
										if ( $is_peak ) {
											echo ' data-peak="1"';
										}
										if ( $is_today ) {
											echo ' aria-current="date"';
										}
										echo '>';

										if ( $is_pick ) {
											$label_bits = array( $spoken );
											if ( $rate > 0 ) {
												/* translators: %s: nightly price, e.g. £235 */
												$label_bits[] = sprintf( __( '%s a night', 'restwell-retreats' ), restwell_format_gbp( $rate ) );
											}
											if ( $is_peak ) {
												$label_bits[] = __( 'peak rate', 'restwell-retreats' );
											}
											echo '<button type="button" class="availability__cell" data-iso="' . esc_attr( $iso ) . '" aria-pressed="false" tabindex="-1" aria-label="' . esc_attr( implode( ', ', $label_bits ) ) . '">';
											echo '<span class="availability__date">' . esc_html( (string) $day ) . '</span>';
											if ( $rate > 0 ) {
												echo '<span class="availability__price">' . esc_html( restwell_format_gbp( $rate ) ) . '</span>';
											}
											echo '</button>';
										} elseif ( $is_booked ) {
											// Focusable so a booked morning can be picked as a leaving day.
											/* translators: %s: spoken date, e.g. Monday 5 October 2026 */
											$booked_label = sprintf( __( '%s, booked', 'restwell-retreats' ), $spoken );
											echo '<button type="button" class="availability__cell" data-iso="' . esc_attr( $iso ) . '" data-booked="1" aria-pressed="false" tabindex="-1" aria-label="' . esc_attr( $booked_label ) . '">';
											echo '<span class="availability__date">' . esc_html( (string) $day ) . '</span>';
											echo '</button>';
										} else {
											echo '<span class="availability__cell"><span class="availability__date">' . esc_html( (string) $day ) . '</span></span>';
										}
										echo '</td>';
										++$cell;
									}
									while ( 0 !== $cell % 7 ) {
										echo '<td class="availability__day is-pad" aria-hidden="true"></td>';
										++$cell;
									}
									echo '</tr>';
									?>
								</tbody>
							</table>
						</article>
					<?php endfor; ?>
				</div>
			</div>

			<div class="availability__summary" data-availability-stay>
				<div class="availability__readout">
					<p class="availability__dates" data-availability-dates>
						<span class="availability__dates-from" data-availability-from><?php esc_html_e( 'Pick your arrival night', 'restwell-retreats' ); ?></span>
						<span class="availability__dates-arrow" data-availability-arrow aria-hidden="true" hidden>→</span>
						<span class="availability__dates-to" data-availability-to></span>
					</p>
					<p class="availability__detail" data-availability-detail><?php echo esc_html( $times_line ); ?></p>
					<dl class="availability__breakdown" data-availability-breakdown hidden></dl>
				</div>
				<div class="availability__actions">
					<button type="button" class="availability__clear" data-availability-clear hidden><?php esc_html_e( 'Clear dates', 'restwell-retreats' ); ?></button>
					<a class="btn btn-gold availability__enquire" data-availability-enquire href="#availability-enquiry"><?php esc_html_e( 'Enquire', 'restwell-retreats' ); ?></a>
				</div>
				<p class="availability__live sr-only" data-availability-live aria-live="polite"></p>
			</div>
			<p class="availability__note"><?php esc_html_e( 'Guide prices only. Nothing is reserved until we confirm by email.', 'restwell-retreats' ); ?></p>

			<dialog class="availability__enquiry" data-availability-enquiry data-multistep aria-labelledby="availability-enquiry-h">
				<button class="availability__enquiry-close" type="button" data-availability-enquiry-close aria-label="<?php esc_attr_e( 'Close enquiry form', 'restwell-retreats' ); ?>">&times;</button>
				<h3 id="availability-enquiry-h"><?php esc_html_e( 'Tell us about your stay', 'restwell-retreats' ); ?></h3>
				<p data-availability-enquiry-dates><?php esc_html_e( 'Your selected dates are already included. Add your details and we will reply within 48 hours.', 'restwell-retreats' ); ?></p>
				<ol class="step-indicator" data-step-indicator role="list" aria-label="<?php esc_attr_e( 'Enquiry form progress', 'restwell-retreats' ); ?>">
					<li class="step-indicator__item is-current" data-step-item="1" aria-current="step"><span class="step-indicator__marker" aria-hidden="true"><span class="step-indicator__num">1</span></span><span class="step-indicator__label"><?php esc_html_e( 'About you', 'restwell-retreats' ); ?></span></li>
					<li class="step-indicator__connector" aria-hidden="true"></li>
					<li class="step-indicator__item" data-step-item="2"><span class="step-indicator__marker" aria-hidden="true"><span class="step-indicator__num">2</span></span><span class="step-indicator__label"><?php esc_html_e( 'Your needs', 'restwell-retreats' ); ?></span></li>
					<li class="step-indicator__connector" aria-hidden="true"></li>
					<li class="step-indicator__item" data-step-item="3"><span class="step-indicator__marker" aria-hidden="true"><span class="step-indicator__num">3</span></span><span class="step-indicator__label"><?php esc_html_e( 'Send', 'restwell-retreats' ); ?></span></li>
				</ol>
				<form class="form-stack restwell-enq-form" data-multistep-form data-live-submit="1" action="<?php echo esc_url( $enquire_url ); ?>" method="post">
					<?php wp_nonce_field( RESTWELL_ENQUIRE_NONCE_ACTION, RESTWELL_ENQUIRE_NONCE_NAME ); ?>
					<input type="hidden" name="restwell_enquire" value="1" />
					<input type="hidden" name="enq_redirect" value="<?php echo esc_url( $enquire_url ); ?>" />
					<input type="hidden" name="enq_date_from" data-availability-enquiry-from value="" />
					<input type="hidden" name="enq_date_to" data-availability-enquiry-to value="" />
					<div class="form-step" data-step-panel="1">
						<div class="field"><label for="availability-name"><?php esc_html_e( 'Name', 'restwell-retreats' ); ?> <span aria-hidden="true">*</span></label><input id="availability-name" name="enq_name" autocomplete="name" required /></div>
						<div class="field"><label for="availability-email"><?php esc_html_e( 'Email', 'restwell-retreats' ); ?> <span aria-hidden="true">*</span></label><input id="availability-email" name="enq_email" type="email" autocomplete="email" required /></div>
						<div class="field"><label for="availability-phone"><?php esc_html_e( 'Phone', 'restwell-retreats' ); ?> <span aria-hidden="true">*</span></label><input id="availability-phone" name="enq_phone" type="tel" autocomplete="tel" required /></div>
						<?php get_template_part( 'template-parts/enquire-heard-about', null, array( 'id_prefix' => 'availability' ) ); ?>
						<button class="btn btn-gold" type="button" data-step-next><?php esc_html_e( 'Continue', 'restwell-retreats' ); ?></button>
					</div>
					<div class="form-step" data-step-panel="2" hidden>
						<div class="field">
							<label for="availability-message"><?php esc_html_e( 'Message', 'restwell-retreats' ); ?> <span aria-hidden="true">*</span></label>
							<textarea id="availability-message" name="enq_message" rows="4" required></textarea>
						</div>
						<div class="field">
							<label for="availability-care"><?php esc_html_e( 'Care requirements (optional)', 'restwell-retreats' ); ?></label>
							<textarea id="availability-care" name="enq_care" rows="2" placeholder="<?php esc_attr_e( 'e.g. morning personal care, overnight support', 'restwell-retreats' ); ?>"></textarea>
						</div>
						<div class="field">
							<label for="availability-access"><?php esc_html_e( 'Accessibility needs (optional)', 'restwell-retreats' ); ?></label>
							<textarea id="availability-access" name="enq_accessibility" rows="2" placeholder="<?php esc_attr_e( 'Equipment, doorway clearances, vehicle access…', 'restwell-retreats' ); ?>"></textarea>
						</div>
						<button class="btn btn-outline-teal" type="button" data-step-prev><?php esc_html_e( 'Back', 'restwell-retreats' ); ?></button>
						<button class="btn btn-gold" type="button" data-step-next><?php esc_html_e( 'Continue', 'restwell-retreats' ); ?></button>
					</div>
					<div class="form-step" data-step-panel="3" hidden>
						<div class="field">
							<label for="availability-health-consent">
								<input id="availability-health-consent" type="checkbox" name="enq_health_consent" value="1" aria-describedby="availability-health-consent-hint availability-health-consent-error" />
								<span><?php esc_html_e( 'If I have added care or accessibility notes, I agree Restwell can use that information to reply to this enquiry. Those notes can include health information, as explained in the', 'restwell-retreats' ); ?>
								<a class="text-link" href="<?php echo esc_url( $privacy_url ); ?>"><?php esc_html_e( 'Privacy Policy', 'restwell-retreats' ); ?></a>.</span>
							</label>
							<p class="field-hint" id="availability-health-consent-hint"><?php esc_html_e( 'Required only if you fill in care or accessibility notes above.', 'restwell-retreats' ); ?></p>
							<p class="field-error" id="availability-health-consent-error" role="alert" hidden><?php esc_html_e( 'Confirm we can use those notes before sending.', 'restwell-retreats' ); ?></p>
						</div>
						<div class="field">
							<label for="availability-consent">
								<input id="availability-consent" type="checkbox" name="enq_consent" value="1" required aria-describedby="availability-consent-error" />
								<span><?php esc_html_e( 'I agree to Restwell contacting me about this enquiry and to my information being handled as set out in the', 'restwell-retreats' ); ?>
								<a class="text-link" href="<?php echo esc_url( $privacy_url ); ?>"><?php esc_html_e( 'Privacy Policy', 'restwell-retreats' ); ?></a> *</span>
							</label>
							<p class="field-error" id="availability-consent-error" role="alert" hidden><?php esc_html_e( 'Check this box so we can contact you about your enquiry.', 'restwell-retreats' ); ?></p>
						</div>
						<button class="btn btn-outline-teal" type="button" data-step-prev><?php esc_html_e( 'Back', 'restwell-retreats' ); ?></button>
						<button class="btn btn-gold" type="submit"><?php esc_html_e( 'Send enquiry', 'restwell-retreats' ); ?></button>
					</div>
				</form>
			</dialog>
		</div>
	</div>
</section>
