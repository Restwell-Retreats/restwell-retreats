<?php
/**
 * Template Name: Guest Arrival Guide
 *
 * Email-gated arrival information delivered via a 6-digit OTP.
 *
 * Flow:
 *  1. Email form       - guest enters their email address.
 *  2. OTP form         - if approved, a one-time code is emailed and entered here.
 *  3. Guide content    - session-gated, full arrival information.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Prevent the browser and any proxy from caching this page.
nocache_headers();

// Session is started in inc/guest-guide.php on `template_redirect` (priority 1),
// scoped to this template only. Session is live before any output is sent.

// -------------------------------------------------------------------------
// Form processing
// -------------------------------------------------------------------------

$gg_error = '';
$notice   = '';

// 30-minute OTP TTL, mirroring `restwell_send_guide_otp()` in inc/guest-guide.php.
// Anywhere we display "expires in N minutes" or detect expiry, this is the source of truth.
const RESTWELL_GG_OTP_TTL_SECONDS = 30 * MINUTE_IN_SECONDS;

// ---------- Step 1: email submitted ----------------------------------------
if (
	isset( $_POST['restwell_gg_step'], $_POST['restwell_gg_nonce'] ) &&
	'email' === $_POST['restwell_gg_step'] &&
	wp_verify_nonce(
		sanitize_text_field( wp_unslash( $_POST['restwell_gg_nonce'] ) ),
		'restwell_gg_email_step'
	)
) {
	$submitted_email = isset( $_POST['gg_email'] ) ? sanitize_email( wp_unslash( $_POST['gg_email'] ) ) : '';

	if ( '' === $submitted_email || ! is_email( $submitted_email ) ) {
		$gg_error = __( 'Please enter a valid email address.', 'restwell-retreats' );
	} else {
		// Anti-enumeration: ONE generic response for unknown, unapproved, and
		// throttled emails. Always advance to the OTP step with the same copy;
		// only send mail when the address is approved and under rate limits.
		$ip_blocked = restwell_form_rate_limit_exceeded( 'guide_otp', 5, HOUR_IN_SECONDS );
		$approved   = restwell_is_approved_email( $submitted_email );

		$_SESSION['gg_pending_email'] = $submitted_email;
		$_SESSION['gg_otp_sent']      = time();
		unset( $_SESSION['gg_verified'], $_SESSION['gg_verified_email'] );

		$mail_failed = false;
		if ( ! $ip_blocked && $approved ) {
			// Per-email throttle only runs when we are about to send (it increments).
			if ( ! restwell_guide_otp_email_throttled( $submitted_email ) ) {
				if ( ! restwell_send_guide_otp( $submitted_email ) ) {
					$mail_failed = true;
				}
			}
		}

		if ( $mail_failed ) {
			// Real delivery failure: do not leave the guest waiting on a code that never sent.
			unset( $_SESSION['gg_pending_email'], $_SESSION['gg_otp_sent'] );
			$gg_error = restwell_guide_otp_mail_failed_message();
		} else {
			$notice = sprintf(
				/* translators: %s: phone number */
				__( "If that email is on our guest list, we'll send a code shortly. Otherwise call us on %s and we'll help.", 'restwell-retreats' ),
				(string) get_option( 'restwell_phone_number', '01622 809881' )
			);
		}
	}
}

// ---------- Step 1b: resend code (no re-typing email) ----------------------
// Issued from the OTP form, reuses the email already in session. Subject to
// the same per-IP and per-email throttles as a fresh request, so a guest who
// hammers it gets the same friendly throttle message rather than an inbox flood.
if (
	isset( $_POST['restwell_gg_step'], $_POST['restwell_gg_nonce'] ) &&
	'resend' === $_POST['restwell_gg_step'] &&
	wp_verify_nonce(
		sanitize_text_field( wp_unslash( $_POST['restwell_gg_nonce'] ) ),
		'restwell_gg_resend_step'
	)
) {
	$pending_email = isset( $_SESSION['gg_pending_email'] ) ? (string) $_SESSION['gg_pending_email'] : '';

	if ( '' === $pending_email ) {
		// Session lost (cookie cleared, server restart) — gracefully bounce
		// them back to the email-entry step rather than silently failing.
		$gg_error = __( 'Your session has expired. Please enter your email again.', 'restwell-retreats' );
		unset( $_SESSION['gg_pending_email'], $_SESSION['gg_otp_sent'] );
	} else {
		$ip_blocked  = restwell_form_rate_limit_exceeded( 'guide_otp', 5, HOUR_IN_SECONDS );
		$mail_failed = false;
		$sent        = false;

		if ( ! $ip_blocked && restwell_is_approved_email( $pending_email ) ) {
			if ( ! restwell_guide_otp_email_throttled( $pending_email ) ) {
				$sent = restwell_send_guide_otp( $pending_email );
				if ( ! $sent ) {
					$mail_failed = true;
				}
			}
		}

		if ( $mail_failed ) {
			unset( $_SESSION['gg_pending_email'], $_SESSION['gg_otp_sent'] );
			$gg_error = restwell_guide_otp_mail_failed_message();
		} else {
			// Same notice whether a code was issued or not (anti-enumeration).
			if ( $sent ) {
				$_SESSION['gg_otp_sent'] = time();
			}
			$notice = sprintf(
				/* translators: %s: phone number */
				__( "If that email is on our guest list, we'll send a code shortly. Otherwise call us on %s and we'll help.", 'restwell-retreats' ),
				(string) get_option( 'restwell_phone_number', '01622 809881' )
			);
		}
	}
}

// ---------- Step 2: OTP submitted ------------------------------------------
if (
	isset( $_POST['restwell_gg_step'], $_POST['restwell_gg_nonce'] ) &&
	'otp' === $_POST['restwell_gg_step'] &&
	wp_verify_nonce(
		sanitize_text_field( wp_unslash( $_POST['restwell_gg_nonce'] ) ),
		'restwell_gg_otp_step'
	)
) {
	$submitted_code = isset( $_POST['gg_code'] ) ? sanitize_text_field( wp_unslash( $_POST['gg_code'] ) ) : '';
	if ( '' === $submitted_code && isset( $_POST['gg_otp'] ) && is_array( $_POST['gg_otp'] ) ) {
		$digits = array();
		foreach ( $_POST['gg_otp'] as $digit ) { // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- sanitized below.
			$digits[] = preg_replace( '/\D/', '', sanitize_text_field( wp_unslash( $digit ) ) );
		}
		$submitted_code = implode( '', $digits );
	}
	$pending_email = isset( $_SESSION['gg_pending_email'] ) ? (string) $_SESSION['gg_pending_email'] : '';

	if ( '' === $submitted_code || '' === $pending_email ) {
		$gg_error = __( 'Your session has expired. Please start again.', 'restwell-retreats' );
		unset( $_SESSION['gg_pending_email'], $_SESSION['gg_otp_sent'] );
	} elseif ( restwell_form_rate_limit_exceeded( 'guide_otp_verify', 10, HOUR_IN_SECONDS ) ) {
		// Brute-force guard: 10 verification attempts per IP per hour. Code is
		// 6 digits (1,000,000 combinations); 10 attempts/hour caps any guesser
		// at well below feasible brute-force range while still leaving room
		// for a real guest's typos. Same generic message as a wrong code so
		// the limit itself isn't useful information to an attacker.
		$gg_error = __( 'Too many attempts. Please wait a little while and try again, or request a new code.', 'restwell-retreats' );
	} elseif ( restwell_verify_guide_otp( $pending_email, $submitted_code ) ) {
		if ( PHP_SESSION_ACTIVE === session_status() ) {
			session_regenerate_id( true );
		}
		$_SESSION['gg_verified']       = true;
		$_SESSION['gg_verified_email'] = $pending_email;
		unset( $_SESSION['gg_pending_email'], $_SESSION['gg_otp_sent'] );
	} else {
		$gg_error = __( 'That code is not correct, or it has expired. Please try again or request a new code.', 'restwell-retreats' );
	}
}

// ---------- "I've read the guide" confirmation ------------------------------
if (
	! empty( $_POST['restwell_gg_step'] ) && 'confirm_read' === $_POST['restwell_gg_step']
	&& isset( $_POST['restwell_gg_nonce'] )
	&& wp_verify_nonce(
		sanitize_text_field( wp_unslash( $_POST['restwell_gg_nonce'] ) ),
		'restwell_gg_confirm_read'
	)
	&& ! empty( $_SESSION['gg_verified'] )
	&& ! empty( $_SESSION['gg_verified_email'] )
) {
	if ( function_exists( 'restwell_guest_guide_confirm_read' ) ) {
		restwell_guest_guide_confirm_read( (string) $_SESSION['gg_verified_email'] );
	}
	wp_safe_redirect( add_query_arg( 'gg_confirmed', '1', get_permalink() ) . '#gg-read-confirmation' );
	exit;
}

// ---------- Reset -----------------------------------------------------------
if ( isset( $_GET['gg_reset'] ) && '1' === $_GET['gg_reset'] ) {
	unset( $_SESSION['gg_verified'], $_SESSION['gg_verified_email'], $_SESSION['gg_pending_email'], $_SESSION['gg_otp_sent'] );
	wp_safe_redirect( get_permalink() );
	exit;
}

// ---------- Determine current UI state -------------------------------------
$admin_bypass  = is_user_logged_in() && current_user_can( 'manage_options' );
if ( $admin_bypass ) {
	$_SESSION['gg_verified']       = true;
	$_SESSION['gg_verified_email'] = (string) wp_get_current_user()->user_email;
	unset( $_SESSION['gg_pending_email'], $_SESSION['gg_otp_sent'] );
}

$is_verified   = ! empty( $_SESSION['gg_verified'] );
$pending_email = isset( $_SESSION['gg_pending_email'] ) ? (string) $_SESSION['gg_pending_email'] : '';
$otp_sent      = ! empty( $pending_email );
$show_otp_form = $otp_sent && ! $is_verified;
$show_email_form = ! $is_verified && ! $otp_sent;

// Honest "expires in N minutes" countdown. The static "30 minutes" line was
// only true at issuance — by the time a guest actually reads the page (often
// minutes later after switching apps for the email), it's misleading.
// `$_SESSION['gg_otp_sent']` is the unix timestamp from `restwell_send_guide_otp`.
$otp_remaining_minutes = 0;
$otp_expired           = false;
if ( $show_otp_form && ! empty( $_SESSION['gg_otp_sent'] ) ) {
	$elapsed   = time() - (int) $_SESSION['gg_otp_sent'];
	$remaining = RESTWELL_GG_OTP_TTL_SECONDS - $elapsed;
	if ( $remaining <= 0 ) {
		$otp_expired = true;
	} else {
		// Round up so we never show "0 minutes" while there's still time on the clock.
		$otp_remaining_minutes = (int) ceil( $remaining / MINUTE_IN_SECONDS );
	}
}

// -------------------------------------------------------------------------
// Meta field retrieval
// -------------------------------------------------------------------------

$pid = get_the_ID();

$gg_welcome   = (string) get_post_meta( $pid, 'gg_welcome_message', true );
$gg_address   = (string) get_post_meta( $pid, 'gg_address', true );
$gg_checkin   = (string) get_post_meta( $pid, 'gg_checkin_time', true );
$gg_checkout  = (string) get_post_meta( $pid, 'gg_checkout_time', true );
$gg_keysafe          = (string) get_post_meta( $pid, 'gg_keysafe_code', true );
$gg_departure_notes  = (string) get_post_meta( $pid, 'gg_departure_notes', true );
$gg_nearest_ae_url   = (string) get_post_meta( $pid, 'gg_nearest_ae_map_url', true );
$gg_door      = (string) get_post_meta( $pid, 'gg_door_instructions', true );
$gg_wifi_name = (string) get_post_meta( $pid, 'gg_wifi_name', true );
$gg_wifi_pass = (string) get_post_meta( $pid, 'gg_wifi_password', true );
$gg_parking   = (string) get_post_meta( $pid, 'gg_parking_info', true );
$gg_host        = (string) get_post_meta( $pid, 'gg_host_contact', true );
$gg_house_rules = (string) get_post_meta( $pid, 'gg_house_rules', true );
$gg_local_info  = (string) get_post_meta( $pid, 'gg_local_info', true );
$gg_emergency   = array(
	__( 'Emergency services', 'restwell-retreats' )      => (string) get_post_meta( $pid, 'gg_emergency_services', true ),
	__( 'NHS (non-emergency)', 'restwell-retreats' )      => (string) get_post_meta( $pid, 'gg_nhs_number', true ),
	__( 'Police (non-emergency)', 'restwell-retreats' )   => (string) get_post_meta( $pid, 'gg_police_number', true ),
	__( 'Nearest A&E', 'restwell-retreats' )          => (string) get_post_meta( $pid, 'gg_nearest_ae', true ),
	__( 'Property maintenance', 'restwell-retreats' )     => (string) get_post_meta( $pid, 'gg_maintenance_contact', true ),
	__( 'Out-of-hours maintenance', 'restwell-retreats' ) => (string) get_post_meta( $pid, 'gg_maintenance_oos', true ),
	__( 'Gas emergency', 'restwell-retreats' )            => (string) get_post_meta( $pid, 'gg_gas_oos', true ),
);

get_header();
?>
<main id="main-content">
<section class="hero hero--interior" aria-labelledby="page-h">
	<div class="container">
		<div class="hero__content">
			<ol class="breadcrumb"><li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'restwell-retreats' ); ?></a></li><li class="breadcrumb__sep" aria-hidden="true">/</li><li aria-current="page"><?php esc_html_e( 'Guest Guide', 'restwell-retreats' ); ?></li></ol>
			<div class="hero__text">
				<h1 id="page-h"><?php esc_html_e( 'Restwell guest guide for confirmed stays', 'restwell-retreats' ); ?></h1>
				<p><?php esc_html_e( 'Arrival notes, Wi‑Fi, parking and house guidance for confirmed guests. Enter the email used on your booking confirmation to unlock the guide.', 'restwell-retreats' ); ?></p>
			</div>
		</div>
	</div>
</section>

<?php if ( $admin_bypass ) : ?>
<section class="section-y section-y--compact band-subtle no-print" aria-label="<?php esc_attr_e( 'Admin notice', 'restwell-retreats' ); ?>">
	<div class="container container--sm">
		<p class="lede"><strong><?php esc_html_e( 'Admin preview mode:', 'restwell-retreats' ); ?></strong> <?php esc_html_e( 'OTP is bypassed while you are logged in with administrator access.', 'restwell-retreats' ); ?></p>
	</div>
</section>
<?php endif; ?>

<?php if ( $show_email_form ) : ?>
<section class="section-y band-white" id="gate" aria-labelledby="gg-email-h">
	<div class="container container--sm">
		<header class="section-head">
			<p class="eyebrow"><?php esc_html_e( 'Step 1', 'restwell-retreats' ); ?></p>
			<h2 id="gg-email-h"><?php esc_html_e( 'Verify your email', 'restwell-retreats' ); ?></h2>
			<p class="lede"><?php esc_html_e( 'Enter the email address used for your booking. We’ll send a one-time code.', 'restwell-retreats' ); ?></p>
		</header>

		<?php if ( '' !== $gg_error ) : ?>
			<p class="gg-banner gg-banner--error" role="alert"><?php echo esc_html( $gg_error ); ?></p>
		<?php endif; ?>

		<form class="form-stack" method="post" action="<?php echo esc_url( get_permalink() ); ?>" novalidate>
			<?php wp_nonce_field( 'restwell_gg_email_step', 'restwell_gg_nonce' ); ?>
			<input type="hidden" name="restwell_gg_step" value="email" />
			<div class="field">
				<label for="gg_email"><?php esc_html_e( 'Booking email', 'restwell-retreats' ); ?> <span aria-hidden="true">*</span></label>
				<input id="gg_email" name="gg_email" type="email" required aria-required="true" autocomplete="email" />
			</div>
			<div class="form-actions">
				<button class="btn btn-gold" type="submit"><?php esc_html_e( 'Send code', 'restwell-retreats' ); ?></button>
			</div>
		</form>
	</div>
</section>

<?php elseif ( $show_otp_form ) : ?>
<section class="section-y band-subtle" id="otp" aria-labelledby="gg-otp-h">
	<div class="container container--sm">
		<header class="section-head">
			<p class="eyebrow"><?php esc_html_e( 'Step 2', 'restwell-retreats' ); ?></p>
			<h2 id="gg-otp-h"><?php esc_html_e( 'Enter your 6-digit code', 'restwell-retreats' ); ?></h2>
			<p class="lede">
				<?php
				if ( $otp_expired ) {
					echo wp_kses_post(
						sprintf(
							/* translators: %s - partially masked email address */
							__( 'Any code sent to %s has now expired. Please request a new one below.', 'restwell-retreats' ),
							'<strong>' . esc_html( restwell_mask_guide_email( $pending_email ) ) . '</strong>'
						)
					);
				} else {
					echo wp_kses_post(
						sprintf(
							/* translators: 1: partially masked email address, 2: number of whole minutes remaining */
							_n(
								'If %1$s is on our guest list, we\'ll send a code shortly (expires in about %2$d minute). Otherwise call us and we\'ll help.',
								'If %1$s is on our guest list, we\'ll send a code shortly (expires in about %2$d minutes). Otherwise call us and we\'ll help.',
								$otp_remaining_minutes,
								'restwell-retreats'
							),
							'<strong>' . esc_html( restwell_mask_guide_email( $pending_email ) ) . '</strong>',
							$otp_remaining_minutes
						)
					);
				}
				?>
			</p>
		</header>

		<?php if ( '' !== $gg_error ) : ?>
			<p class="gg-banner gg-banner--error" role="alert"><?php echo esc_html( $gg_error ); ?></p>
		<?php endif; ?>
		<?php if ( '' !== $notice ) : ?>
			<p class="gg-banner gg-banner--ok" role="status" aria-live="polite"><?php echo esc_html( $notice ); ?></p>
		<?php endif; ?>

		<form class="form-stack" method="post" action="<?php echo esc_url( get_permalink() ); ?>" novalidate>
			<?php wp_nonce_field( 'restwell_gg_otp_step', 'restwell_gg_nonce' ); ?>
			<input type="hidden" name="restwell_gg_step" value="otp" />
			<input type="hidden" name="gg_code" value="" data-otp-value <?php echo $otp_expired ? 'disabled' : ''; ?> />
			<div class="field">
				<label for="otp-1"><?php esc_html_e( 'One-time code', 'restwell-retreats' ); ?> <span aria-hidden="true">*</span></label>
				<div class="otp-box" role="group" aria-label="<?php esc_attr_e( 'Six digit code', 'restwell-retreats' ); ?>" data-otp-group>
					<?php for ( $i = 1; $i <= 6; $i++ ) : ?>
						<input
							id="otp-<?php echo esc_attr( (string) $i ); ?>"
							name="gg_otp[]"
							maxlength="1"
							inputmode="numeric"
							autocomplete="<?php echo 1 === $i ? 'one-time-code' : 'off'; ?>"
							aria-label="<?php echo esc_attr( sprintf( /* translators: %d: digit position */ __( 'Digit %d', 'restwell-retreats' ), $i ) ); ?>"
							<?php echo $otp_expired ? 'disabled aria-disabled="true"' : ''; ?>
							required
						/>
					<?php endfor; ?>
				</div>
			</div>
			<div class="form-actions">
				<button class="btn btn-gold" type="submit" <?php echo $otp_expired ? 'disabled aria-disabled="true"' : ''; ?>><?php esc_html_e( 'Unlock guide', 'restwell-retreats' ); ?></button>
			</div>
		</form>

		<div class="gg-secondary no-print">
			<form method="post" action="<?php echo esc_url( get_permalink() ); ?>">
				<?php wp_nonce_field( 'restwell_gg_resend_step', 'restwell_gg_nonce' ); ?>
				<input type="hidden" name="restwell_gg_step" value="resend" />
				<button type="submit" class="btn btn-outline-teal">
					<?php
					if ( $otp_expired ) {
						esc_html_e( 'Send me a new code', 'restwell-retreats' );
					} else {
						esc_html_e( 'Resend code', 'restwell-retreats' );
					}
					?>
				</button>
			</form>
			<p class="gg-secondary__hint">
				<?php esc_html_e( 'Used the wrong email?', 'restwell-retreats' ); ?>
				<a class="text-link" href="<?php echo esc_url( add_query_arg( 'gg_reset', '1', get_permalink() ) ); ?>"><?php esc_html_e( 'Start again with a different address', 'restwell-retreats' ); ?></a>
			</p>
		</div>
	</div>
</section>

<?php elseif ( $is_verified ) : ?>
<section class="section-y band-white" id="guide" aria-labelledby="gg-guide-h">
	<div class="container">
		<header class="section-head">
			<p class="eyebrow"><?php esc_html_e( 'Authenticated', 'restwell-retreats' ); ?></p>
			<h2 id="gg-guide-h"><?php esc_html_e( 'About your stay', 'restwell-retreats' ); ?></h2>
			<p class="lede"><?php esc_html_e( 'If anything in the house disagrees with your booking confirmation, call the number on that confirmation first.', 'restwell-retreats' ); ?></p>
		</header>

		<ul class="card-grid card-grid--2" role="list">
			<?php if ( '' !== $gg_welcome ) : ?>
			<li><article class="info-card">
				<h3><?php esc_html_e( 'Welcome', 'restwell-retreats' ); ?></h3>
				<p><?php echo wp_kses_post( nl2br( esc_html( $gg_welcome ) ) ); ?></p>
			</article></li>
			<?php endif; ?>

			<?php if ( $gg_address || $gg_checkin || $gg_checkout ) : ?>
			<li><article class="info-card">
				<h3><?php esc_html_e( 'Arrival details', 'restwell-retreats' ); ?></h3>
				<p>
					<?php if ( $gg_address ) : ?>
						<strong><?php esc_html_e( 'Address:', 'restwell-retreats' ); ?></strong> <?php echo wp_kses_post( nl2br( esc_html( $gg_address ) ) ); ?><br />
					<?php endif; ?>
					<?php if ( $gg_checkin ) : ?>
						<strong><?php esc_html_e( 'Check-in:', 'restwell-retreats' ); ?></strong> <?php echo esc_html( $gg_checkin ); ?>
						<?php if ( $gg_checkout ) : ?> · <?php endif; ?>
					<?php endif; ?>
					<?php if ( $gg_checkout ) : ?>
						<strong><?php esc_html_e( 'Check-out:', 'restwell-retreats' ); ?></strong> <?php echo esc_html( $gg_checkout ); ?>
					<?php endif; ?>
				</p>
			</article></li>
			<?php endif; ?>

			<?php if ( $gg_keysafe || $gg_door ) : ?>
			<li><article class="info-card">
				<h3><?php esc_html_e( 'Getting in', 'restwell-retreats' ); ?></h3>
				<p>
					<?php if ( $gg_keysafe ) : ?>
						<strong><?php esc_html_e( 'Key safe code:', 'restwell-retreats' ); ?></strong>
						<span class="gg-keysafe">
							<span id="gg-keysafe-value" class="gg-keysafe__value is-blurred" aria-label="<?php esc_attr_e( 'Hidden key safe code - tap to reveal', 'restwell-retreats' ); ?>"><?php echo esc_html( $gg_keysafe ); ?></span>
							<button type="button" id="gg-keysafe-reveal" class="text-link" aria-controls="gg-keysafe-value" aria-expanded="false" data-label-reveal="<?php echo esc_attr__( 'Tap to reveal', 'restwell-retreats' ); ?>" data-label-hide="<?php echo esc_attr__( 'Hide', 'restwell-retreats' ); ?>"><?php esc_html_e( 'Tap to reveal', 'restwell-retreats' ); ?></button>
						</span><br />
					<?php endif; ?>
					<?php if ( $gg_door ) : ?>
						<?php echo wp_kses_post( nl2br( esc_html( $gg_door ) ) ); ?>
					<?php endif; ?>
				</p>
			</article></li>
			<?php endif; ?>

			<?php if ( $gg_wifi_name || $gg_wifi_pass ) : ?>
			<li><article class="info-card">
				<h3><?php esc_html_e( 'Wi‑Fi', 'restwell-retreats' ); ?></h3>
				<p>
					<?php if ( $gg_wifi_name ) : ?>
						<strong><?php esc_html_e( 'Network:', 'restwell-retreats' ); ?></strong> <?php echo esc_html( $gg_wifi_name ); ?><br />
					<?php endif; ?>
					<?php if ( $gg_wifi_pass ) : ?>
						<strong><?php esc_html_e( 'Password:', 'restwell-retreats' ); ?></strong> <?php echo esc_html( $gg_wifi_pass ); ?>
					<?php endif; ?>
				</p>
			</article></li>
			<?php endif; ?>

			<?php if ( $gg_parking ) : ?>
			<li><article class="info-card">
				<h3><?php esc_html_e( 'Parking', 'restwell-retreats' ); ?></h3>
				<p><?php echo wp_kses_post( nl2br( esc_html( $gg_parking ) ) ); ?></p>
			</article></li>
			<?php endif; ?>

			<?php if ( '' !== $gg_house_rules ) : ?>
			<li><article class="info-card">
				<h3><?php esc_html_e( 'House rules', 'restwell-retreats' ); ?></h3>
				<p><?php echo wp_kses_post( nl2br( esc_html( $gg_house_rules ) ) ); ?></p>
			</article></li>
			<?php endif; ?>

			<?php if ( '' !== $gg_departure_notes ) : ?>
			<li><article class="info-card">
				<h3><?php esc_html_e( 'Before you leave', 'restwell-retreats' ); ?></h3>
				<p><?php echo wp_kses_post( nl2br( esc_html( $gg_departure_notes ) ) ); ?></p>
				<p><?php esc_html_e( 'Return keys and fobs to the key safe (same code as arrival). If you are unsure of the location, check Getting in above.', 'restwell-retreats' ); ?></p>
			</article></li>
			<?php endif; ?>

			<?php if ( '' !== $gg_local_info ) : ?>
			<li><article class="info-card">
				<h3><?php esc_html_e( 'Local area', 'restwell-retreats' ); ?></h3>
				<p><?php echo wp_kses_post( nl2br( esc_html( $gg_local_info ) ) ); ?></p>
				<p><a class="text-link" href="<?php echo esc_url( home_url( '/whitstable-area-guide/' ) ); ?>"><?php esc_html_e( 'Whitstable accessibility guide', 'restwell-retreats' ); ?></a></p>
			</article></li>
			<?php endif; ?>

			<?php if ( array_filter( $gg_emergency ) ) : ?>
			<li><article class="info-card">
				<h3><?php esc_html_e( 'Emergencies', 'restwell-retreats' ); ?></h3>
				<p>
					<?php
					$ae_label = __( 'Nearest A&E', 'restwell-retreats' );
					$lines    = array();
					foreach ( $gg_emergency as $label => $value ) {
						if ( '' === $value ) {
							continue;
						}
						$is_phone = (bool) preg_match( '/^[\d\s\+\(\)\-\.]+$/', trim( $value ) );
						if ( $is_phone ) {
							$tel     = preg_replace( '/[^\d\+]/', '', $value );
							$display = '<a class="text-link" href="tel:' . esc_attr( $tel ) . '">' . esc_html( $value ) . '</a>';
						} else {
							$display = esc_html( $value );
						}
						if ( $label === $ae_label && $gg_nearest_ae_url ) {
							$display .= ' <a class="text-link" href="' . esc_url( $gg_nearest_ae_url ) . '" target="_blank" rel="noopener noreferrer">' . esc_html__( 'View on Maps', 'restwell-retreats' ) . '<span class="sr-only"> ' . esc_html__( '(opens in new tab)', 'restwell-retreats' ) . '</span></a>';
						}
						$lines[] = '<strong>' . esc_html( $label ) . ':</strong> ' . $display;
					}
					echo wp_kses_post( implode( '<br />', $lines ) );
					?>
				</p>
			</article></li>
			<?php endif; ?>

			<?php if ( $gg_host ) : ?>
			<li><article class="info-card">
				<h3><?php esc_html_e( 'Your host', 'restwell-retreats' ); ?></h3>
				<p><?php echo wp_kses_post( nl2br( esc_html( $gg_host ) ) ); ?></p>
			</article></li>
			<?php endif; ?>

			<?php
			$gg_guest_row       = isset( $_SESSION['gg_verified_email'] )
				? restwell_get_guest_by_email( $_SESSION['gg_verified_email'] )
				: null;
			$already_confirmed = $gg_guest_row && ! empty( $gg_guest_row->confirmed_at );
			?>
			<li id="gg-read-confirmation"><article class="info-card info-card--sand">
				<h3><?php esc_html_e( 'Print / confirm', 'restwell-retreats' ); ?></h3>
				<p><?php esc_html_e( 'Print this guide for the fridge if you like.', 'restwell-retreats' ); ?></p>
				<div class="form-actions no-print">
					<button type="button" class="btn btn-outline-teal" data-gg-print><?php esc_html_e( 'Print this guide', 'restwell-retreats' ); ?></button>
				</div>
				<?php if ( ! $already_confirmed ) : ?>
					<?php if ( isset( $_GET['gg_confirmed'] ) ) : // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
						<p class="gg-banner gg-banner--ok no-print" role="status"><?php esc_html_e( "Thank you - we've recorded that you've read the guide.", 'restwell-retreats' ); ?></p>
					<?php else : ?>
						<form class="form-stack no-print" method="post" action="<?php echo esc_url( get_permalink() ); ?>">
							<?php wp_nonce_field( 'restwell_gg_confirm_read', 'restwell_gg_nonce' ); ?>
							<input type="hidden" name="restwell_gg_step" value="confirm_read" />
							<div class="field">
								<label for="guide-read">
									<input id="guide-read" type="checkbox" required />
									<span><?php esc_html_e( "I've read the guide", 'restwell-retreats' ); ?></span>
								</label>
							</div>
							<div class="form-actions">
								<button type="submit" class="btn btn-gold"><?php esc_html_e( 'Confirm', 'restwell-retreats' ); ?></button>
							</div>
						</form>
					<?php endif; ?>
				<?php else : ?>
					<p class="gg-banner gg-banner--ok no-print"><?php esc_html_e( 'You confirmed reading this guide.', 'restwell-retreats' ); ?></p>
				<?php endif; ?>
			</article></li>
		</ul>

		<p class="gg-secondary__hint no-print">
			<?php esc_html_e( 'Finished reading?', 'restwell-retreats' ); ?>
			<a class="text-link" href="<?php echo esc_url( add_query_arg( 'gg_reset', '1', get_permalink() ) ); ?>"><?php esc_html_e( 'Sign out of the guide', 'restwell-retreats' ); ?></a>
		</p>
	</div>
</section>
<?php endif; ?>

</main>
<?php
get_footer();
