<?php
/**
 * Guest Guide OTP send, verify, throttle, and email mask.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// =============================================================================
// Helpers: approved-email check
// =============================================================================

/**
 * Check whether an email address belongs to a guest in the guest list.
 *
 * Comparison is case-insensitive.
 *
 * @param string $email Raw email address submitted by the user.
 * @return bool True when the email is on the guest list.
 */
function restwell_is_approved_email( $email ): bool {
	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_GUESTS_TABLE;
	$count = (int) $wpdb->get_var(
		$wpdb->prepare( 'SELECT COUNT(*) FROM %i WHERE LOWER(email) = LOWER(%s)', $table, trim( $email ) )
	);
	return $count > 0;
}

// =============================================================================
// Helpers: OTP
// =============================================================================

/**
 * Per-email issuance throttle for OTP requests.
 *
 * Complements the per-IP throttle (`restwell_form_rate_limit_exceeded()`):
 * the IP guard stops a single attacker, this guard stops a distributed
 * email-bomb attack on one specific guest's inbox. Capped at 5 issuances
 * per hour per email by default — well above what a real guest needs even
 * with retries, far below what an attacker would need for abuse.
 *
 * Counter increments on every call (matching the per-IP helper's contract),
 * so simply *checking* the throttle uses a slot. Always call this immediately
 * before issuing an OTP, never speculatively.
 *
 * @param string $email  Email address (will be lower-cased / trimmed for keying).
 * @param int    $max    Max issuances per window. Default 5.
 * @param int    $window Window length in seconds. Default 1 hour.
 * @return bool True when the limit has been exceeded (caller must block).
 */
function restwell_guide_otp_email_throttled( string $email, int $max = 5, int $window = HOUR_IN_SECONDS ): bool {
	$key   = 'rw_otp_email_' . md5( strtolower( trim( $email ) ) );
	$count = (int) get_transient( $key );
	if ( $count >= $max ) {
		return true;
	}
	set_transient( $key, $count + 1, $window );
	return false;
}

/**
 * HMAC hash for a guest-guide OTP (never store the raw code).
 *
 * @param string $code Six-digit OTP.
 * @return string
 */
function restwell_guide_otp_hash( string $code ): string {
	return hash_hmac( 'sha256', $code, wp_salt( 'auth' ) );
}

/**
 * Generate a 6-digit OTP, persist a hash as a 30-minute WordPress transient,
 * and send the plaintext code to the guest via wp_mail().
 *
 * Note: this function does NOT enforce rate limits. Callers are responsible
 * for checking `restwell_form_rate_limit_exceeded( 'guide_otp', ... )` and
 * `restwell_guide_otp_email_throttled()` before calling, so that legitimate
 * non-public callers (admin tooling, future cron jobs) can bypass throttles.
 *
 * On mail failure the transient is removed so a undelivered code cannot be used.
 *
 * @param string $email Verified approved email address.
 * @return bool True when the message was accepted by wp_mail().
 */
function restwell_send_guide_otp( $email ) {
	$code = str_pad( (string) wp_rand( 0, 999999 ), 6, '0', STR_PAD_LEFT );
	$key  = 'restwell_guide_otp_' . md5( strtolower( trim( $email ) ) );

	set_transient( $key, restwell_guide_otp_hash( $code ), 30 * MINUTE_IN_SECONDS );

	$mail = restwell_email_otp( $email, $code );
	if ( function_exists( 'restwell_wp_mail_with_retry' ) ) {
		$sent = restwell_wp_mail_with_retry( $email, $mail['subject'], $mail['body'], $mail['headers'] );
	} else {
		$sent = wp_mail( $email, $mail['subject'], $mail['body'], $mail['headers'] );
	}

	if ( ! $sent ) {
		delete_transient( $key );
		// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log -- intentional ops signal for failed OTP delivery.
		error_log( 'restwell_send_guide_otp: wp_mail failed for guest guide OTP.' );
		return false;
	}

	return true;
}

/**
 * User-facing copy when OTP email delivery fails.
 *
 * @return string
 */
function restwell_guide_otp_mail_failed_message(): string {
	return sprintf(
		/* translators: %s: phone number */
		__( "We couldn't send your code just now. Please try again in a moment, or call us on %s and we'll help.", 'restwell-retreats' ),
		(string) get_option( 'restwell_phone_number', '01622 809881' )
	);
}

/**
 * Verify a submitted OTP code against the stored transient hash.
 *
 * Uses hash_equals() for timing-safe comparison. Deletes the transient on a
 * successful match to prevent reuse. Accepts legacy plaintext transients from
 * before hashed storage so in-flight codes still work after deploy.
 *
 * @param string $email Email address used when the OTP was generated.
 * @param string $code  Raw code submitted by the user.
 * @return bool True when the code matches and has not expired.
 */
function restwell_verify_guide_otp( $email, $code ) {
	$key    = 'restwell_guide_otp_' . md5( strtolower( trim( $email ) ) );
	$stored = get_transient( $key );

	if ( false === $stored ) {
		return false;
	}

	$stored     = (string) $stored;
	$code       = (string) $code;
	$code_hash  = restwell_guide_otp_hash( $code );
	$matched    = hash_equals( $stored, $code_hash );
	// Legacy: plaintext 6-digit codes issued before hashed storage.
	if ( ! $matched && preg_match( '/^\d{6}$/', $stored ) ) {
		$matched = hash_equals( $stored, $code );
	}

	if ( ! $matched ) {
		return false;
	}

	delete_transient( $key );
	return true;
}

/**
 * Return a partially-masked email address suitable for display.
 *
 * Example: jane.smith@example.com → ja**********@example.com
 *
 * @param string $email Raw email address.
 * @return string Masked email, or the original value if it cannot be parsed.
 */
function restwell_mask_guide_email( $email ) {
	$parts = explode( '@', $email, 2 );

	if ( 2 !== count( $parts ) || '' === $parts[0] ) {
		return $email;
	}

	$local   = $parts[0];
	$visible = substr( $local, 0, min( 2, strlen( $local ) ) );
	$stars   = str_repeat( '*', max( 2, strlen( $local ) - strlen( $visible ) ) );

	return $visible . $stars . '@' . $parts[1];
}

// =============================================================================
// Meta box: Guest Arrival Guide Content
// =============================================================================

define( 'RESTWELL_GG_NONCE_ACTION', 'restwell_guest_guide_meta_save' );
define( 'RESTWELL_GG_NONCE_NAME', 'restwell_gg_nonce' );
