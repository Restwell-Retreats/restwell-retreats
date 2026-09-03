<?php
/**
 * Public booked-nights diary (Pricing).
 *
 * $args['months'] int Months from the current month (default 12).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'restwell_occupancy_is_configured' ) || ! restwell_occupancy_is_configured() ) {
	return;
}

$availability_args = wp_parse_args(
	$args ?? array(),
	array(
		'months' => 12,
	)
);

$occupancy = restwell_get_occupancy_booked();
if ( empty( $occupancy['ok'] ) ) {
	return;
}

$booked_lookup = array_fill_keys( $occupancy['dates'], true );
$month_count   = max( 1, min( 18, (int) $availability_args['months'] ) );
$london        = new DateTimeZone( 'Europe/London' );
$today         = new DateTime( 'today', $london );
$today_iso     = $today->format( 'Y-m-d' );
$weekdays      = array(
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

$pricing    = function_exists( 'restwell_get_pricing' ) ? restwell_get_pricing() : array();
$week_off   = isset( $pricing['seasons']['off_peak']['full_week'] ) ? (int) $pricing['seasons']['off_peak']['full_week'] : 0;
$week_peak  = isset( $pricing['seasons']['peak']['full_week'] ) ? (int) $pricing['seasons']['peak']['full_week'] : 0;
$check_in   = isset( $pricing['check_in'] ) ? (string) $pricing['check_in'] : '15:00';
$check_out  = isset( $pricing['check_out'] ) ? (string) $pricing['check_out'] : '11:00';
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
		>
			<div class="availability__layout">
			<div class="availability__card">
			<div class="availability__toolbar">
				<button type="button" class="availability__nav" data-availability-prev aria-label="<?php esc_attr_e( 'Previous month', 'restwell-retreats' ); ?>" disabled>
					<span aria-hidden="true">&lsaquo;</span>
				</button>
				<p class="availability__choose sr-only"><?php esc_html_e( 'Change month', 'restwell-retreats' ); ?></p>
				<button type="button" class="availability__nav" data-availability-next aria-label="<?php esc_attr_e( 'Next month', 'restwell-retreats' ); ?>">
					<span aria-hidden="true">&rsaquo;</span>
				</button>
			</div>
			<div class="availability__months">
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
						$is_first   = ( 0 === $i );
						?>
					<article
						class="availability__month<?php echo $is_first ? ' is-active' : ''; ?>"
						data-availability-month
						aria-labelledby="<?php echo esc_attr( $month_id ); ?>"
						<?php echo $is_first ? '' : ' hidden'; ?>
					>
						<h3 id="<?php echo esc_attr( $month_id ); ?>" class="availability__month-title"><?php echo esc_html( $month_name ); ?></h3>
						<table class="availability__grid">
							<caption class="sr-only"><?php echo esc_html( $month_name ); ?></caption>
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
									$classes   = array( 'availability__day' );
									$is_booked = isset( $booked_lookup[ $iso ] );
									$is_today  = $iso === $today_iso;
									$is_past   = $iso < $today_iso;
									$is_peak   = function_exists( 'restwell_is_peak_date' ) && restwell_is_peak_date( $iso );
									$is_pick   = ( ! $is_booked && ! $is_past );
									$rate      = function_exists( 'restwell_night_rate_gbp' ) ? restwell_night_rate_gbp( $iso ) : 0;
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

									$aria_bits = array( $day . ' ' . $month_name );
									if ( $rate > 0 ) {
										$aria_bits[] = restwell_format_gbp( $rate );
									}
									if ( $is_peak ) {
										$aria_bits[] = __( 'Peak season', 'restwell-retreats' );
									}
									$aria = implode( ', ', $aria_bits );

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
										echo '<button type="button" class="availability__num" data-iso="' . esc_attr( $iso ) . '" aria-pressed="false" aria-label="' . esc_attr( $aria ) . '">';
									} else {
										echo '<span class="availability__num">';
									}
									echo '<span class="availability__date">' . esc_html( (string) $day ) . '</span>';
									if ( $rate > 0 ) {
										echo '<span class="availability__price">' . esc_html( restwell_format_gbp( $rate ) ) . '</span>';
									}
									echo $is_pick ? '</button>' : '</span>';
									if ( $is_booked ) {
										echo '<span class="sr-only">' . esc_html__( 'Booked', 'restwell-retreats' ) . '</span>';
									} elseif ( $is_peak && ! $is_pick ) {
										echo '<span class="sr-only">' . esc_html__( 'Peak season', 'restwell-retreats' ) . '</span>';
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
						<?php
					endfor;
					?>
			</div>
			<ul class="availability__legend" role="list">
				<li>
					<span class="availability__key is-open">
						<span class="availability__key-mark" aria-hidden="true"></span>
						<?php esc_html_e( 'Available', 'restwell-retreats' ); ?>
					</span>
				</li>
				<li>
					<span class="availability__key is-hope">
						<span class="availability__key-mark" aria-hidden="true"></span>
						<?php esc_html_e( 'Your nights', 'restwell-retreats' ); ?>
					</span>
				</li>
				<li>
					<span class="availability__key is-booked">
						<span class="availability__key-mark" aria-hidden="true"></span>
						<?php esc_html_e( 'Booked', 'restwell-retreats' ); ?>
					</span>
				</li>
				<li>
					<span class="availability__key is-peak">
						<span class="availability__key-mark" aria-hidden="true"></span>
						<?php esc_html_e( 'Peak rate', 'restwell-retreats' ); ?>
					</span>
				</li>
			</ul>
			<p class="availability__live sr-only" data-availability-live aria-live="polite"></p>
			</div>
			<aside class="availability__stay is-empty" data-availability-stay>
				<header class="availability__stay-head">
					<h3 class="availability__stay-title"><?php esc_html_e( 'Your stay', 'restwell-retreats' ); ?></h3>
					<button type="button" class="availability__stay-clear" data-availability-clear hidden><?php esc_html_e( 'Clear', 'restwell-retreats' ); ?></button>
				</header>
				<div class="availability__fields">
					<div class="availability__field" data-availability-from-field>
						<span class="availability__field-label"><?php esc_html_e( 'Arrive', 'restwell-retreats' ); ?></span>
						<span class="availability__field-value" data-availability-from><?php esc_html_e( '—', 'restwell-retreats' ); ?></span>
						<span class="availability__stay-times">
							<?php
							echo esc_html(
								sprintf(
									/* translators: %s: check-in time */
									__( 'from %s', 'restwell-retreats' ),
									$check_in
								)
							);
							?>
						</span>
					</div>
					<span class="availability__stay-arrow" aria-hidden="true">→</span>
					<div class="availability__field" data-availability-to-field>
						<span class="availability__field-label"><?php esc_html_e( 'Leave', 'restwell-retreats' ); ?></span>
						<span class="availability__field-value" data-availability-to><?php esc_html_e( '—', 'restwell-retreats' ); ?></span>
						<span class="availability__stay-times">
							<?php
							echo esc_html(
								sprintf(
									/* translators: %s: check-out time */
									__( 'by %s', 'restwell-retreats' ),
									$check_out
								)
							);
							?>
						</span>
					</div>
				</div>
				<p class="availability__stay-prompt" data-availability-prompt><?php esc_html_e( 'Tap a night to start.', 'restwell-retreats' ); ?></p>
				<div class="availability__quote" data-availability-quote hidden>
					<p class="availability__stay-count" data-availability-count></p>
					<dl class="availability__breakdown" data-availability-breakdown>
						<div class="availability__total">
							<dt><?php esc_html_e( 'Guide total', 'restwell-retreats' ); ?></dt>
							<dd data-availability-total></dd>
						</div>
					</dl>
					<p class="availability__stay-foot" data-availability-foot><?php esc_html_e( 'Published bungalow rates. Nothing is reserved until we reply.', 'restwell-retreats' ); ?></p>
				</div>
				<div class="availability__cta">
					<a class="btn btn-gold" data-availability-enquire href="#availability-enquiry"><?php esc_html_e( 'Enquire', 'restwell-retreats' ); ?></a>
				</div>
				<div class="availability__enquiry" data-availability-enquiry hidden>
					<h4><?php esc_html_e( 'Tell us about your stay', 'restwell-retreats' ); ?></h4>
					<p><?php esc_html_e( 'Your selected dates are already included. Add your details and we will reply within 48 hours.', 'restwell-retreats' ); ?></p>
					<form class="form-stack" action="<?php echo esc_url( $enquire_url ); ?>" method="post">
						<?php wp_nonce_field( RESTWELL_ENQUIRE_NONCE_ACTION, RESTWELL_ENQUIRE_NONCE_NAME ); ?>
						<input type="hidden" name="restwell_enquire" value="1" />
						<input type="hidden" name="enq_redirect" value="<?php echo esc_url( $enquire_url ); ?>" />
						<input type="hidden" name="enq_date_from" data-availability-enquiry-from value="" />
						<input type="hidden" name="enq_date_to" data-availability-enquiry-to value="" />
						<div class="field"><label for="availability-name"><?php esc_html_e( 'Name', 'restwell-retreats' ); ?></label><input id="availability-name" name="enq_name" autocomplete="name" required /></div>
						<div class="field"><label for="availability-email"><?php esc_html_e( 'Email', 'restwell-retreats' ); ?></label><input id="availability-email" name="enq_email" type="email" autocomplete="email" required /></div>
						<div class="field"><label for="availability-phone"><?php esc_html_e( 'Phone', 'restwell-retreats' ); ?></label><input id="availability-phone" name="enq_phone" type="tel" autocomplete="tel" required /></div>
						<div class="field"><label for="availability-message"><?php esc_html_e( 'Message', 'restwell-retreats' ); ?></label><textarea id="availability-message" name="enq_message" rows="3" required></textarea></div>
						<div class="field"><label for="availability-consent"><input id="availability-consent" type="checkbox" name="enq_consent" value="1" required /> <?php esc_html_e( 'I agree to Restwell contacting me about this enquiry.', 'restwell-retreats' ); ?></label></div>
						<button class="btn btn-gold" type="submit"><?php esc_html_e( 'Send enquiry', 'restwell-retreats' ); ?></button>
					</form>
				</div>
			</aside>
			</div>
		</div>
	</div>
</section>
