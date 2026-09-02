<?php
/**
 * Enquiry form submission handler: validate, persist to CRM, email notify address, acknowledgement, redirect.
 *
 * @package Restwell_CRM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const RESTWELL_ENQUIRE_NONCE_ACTION = 'restwell_enquire_submit';
const RESTWELL_ENQUIRE_NONCE_NAME   = 'restwell_enquire_nonce';

/**
 * Validate optional preferred date fields (site timezone “today”).
 *
 * @param string $date_from Y-m-d or empty.
 * @param string $date_to   Y-m-d or empty.
 * @return string[] Error messages (empty if OK).
 */
function restwell_validate_enquiry_dates( string $date_from, string $date_to ): array {
	$errors = array();
	$today  = current_time( 'Y-m-d' );

	$valid_ymd = static function ( string $d ): bool {
		return (bool) preg_match( '/^\d{4}-\d{2}-\d{2}$/', $d );
	};

	if ( '' !== $date_from ) {
		if ( ! $valid_ymd( $date_from ) ) {
			$errors[] = __( 'Please use a valid start date.', 'restwell-retreats' );
		} elseif ( $date_from < $today ) {
			$errors[] = __( 'Preferred start date cannot be in the past.', 'restwell-retreats' );
		}
	}
	if ( '' !== $date_to ) {
		if ( ! $valid_ymd( $date_to ) ) {
			$errors[] = __( 'Please use a valid end date.', 'restwell-retreats' );
		} elseif ( '' === $date_from && $date_to < $today ) {
			$errors[] = __( 'Preferred end date cannot be in the past.', 'restwell-retreats' );
		} elseif ( '' !== $date_from && $valid_ymd( $date_from ) && $date_to < $date_from ) {
			$errors[] = __( 'End date must be on or after the start date.', 'restwell-retreats' );
		}
	}
	return $errors;
}

/**
 * Render Y-m-d date pair as the human-readable `preferred_dates` string we store
 * on the enquiry row ("12 Mar 2026 - 15 Mar 2026", or "12 Mar 2026" for either
 * a start- or end-only value, or "" if neither is set).
 *
 * Centralising this means the public form (initial submission) and the admin
 * detail page (post-hoc edits) produce byte-identical strings — so the listing
 * column, CSV export, and any future filters never go out of sync.
 *
 * Note: end-only is rendered as a single date because the admin form lets a
 * staff member set just an end date (e.g. "guest is leaving on the 15th, start
 * TBC"). That input never reaches the public form, but if it ever does (custom
 * theme hack, manipulated POST), we still surface it rather than silently
 * dropping the data.
 *
 * @param string $date_from Y-m-d or empty.
 * @param string $date_to   Y-m-d or empty.
 * @return string
 */
function restwell_format_enquiry_date_range( string $date_from, string $date_to ): string {
	if ( '' !== $date_from && '' !== $date_to ) {
		return gmdate( 'j M Y', strtotime( $date_from ) ) . ' - ' . gmdate( 'j M Y', strtotime( $date_to ) );
	}
	if ( '' !== $date_from ) {
		return gmdate( 'j M Y', strtotime( $date_from ) );
	}
	if ( '' !== $date_to ) {
		return gmdate( 'j M Y', strtotime( $date_to ) );
	}
	return '';
}

/**
 * Redirect back to the enquiry form with validation messages and field values.
 *
 * @param string               $redirect Base URL.
 * @param array<int, string>   $errors   Error strings.
 * @param array<string, mixed> $fields   Raw-ish field values for repopulation.
 */
function restwell_enquire_redirect_flash( string $redirect, array $errors, array $fields ): void {
	$key = wp_generate_password( 12, false, false );
	set_transient(
		'restwell_enq_flash_' . $key,
		array(
			'errors' => $errors,
			'fields' => $fields,
		),
		300
	);
	wp_safe_redirect( add_query_arg( 'enq_flash', rawurlencode( $key ), $redirect ) . '#enquiry-result' );
	exit;
}

/**
 * Allowed funding slugs stored on `funding_type` (CRM + email).
 *
 * @return string[]
 */
function restwell_enquiry_funding_allowed_slugs(): array {
	return array( '', 'self', 'kcc', 'chc', 'direct' );
}

/**
 * Normalise a posted funding value to an allowed slug.
 *
 * Accepts canonical slugs and legacy concept-form values (self-funded, etc.).
 *
 * @param string $raw Raw POST value after sanitize_key.
 * @return string One of restwell_enquiry_funding_allowed_slugs().
 */
function restwell_enquiry_normalise_funding( string $raw ): string {
	$aliases = array(
		'self-funded'     => 'self',
		'local-authority' => 'kcc',
		'nhs-chc'         => 'chc',
		'direct-payment'  => 'direct',
		'not-sure'        => '',
		'notsure'         => '',
	);
	if ( isset( $aliases[ $raw ] ) ) {
		$raw = $aliases[ $raw ];
	}
	$allowed = restwell_enquiry_funding_allowed_slugs();
	return in_array( $raw, $allowed, true ) ? $raw : '';
}

/**
 * Map funding slug to readable label for email body and CRM.
 *
 * @param string $slug Form value.
 * @return string
 */
function restwell_enquiry_funding_label( string $slug ): string {
	$labels = array(
		'self'   => __( 'Self-funded', 'restwell-retreats' ),
		'kcc'    => __( 'Local authority / KCC', 'restwell-retreats' ),
		'chc'    => __( 'NHS Continuing Healthcare', 'restwell-retreats' ),
		'direct' => __( 'Direct payment / PHB', 'restwell-retreats' ),
		''       => __( 'Not sure yet', 'restwell-retreats' ),
	);
	if ( array_key_exists( $slug, $labels ) ) {
		return $labels[ $slug ];
	}
	return $slug;
}

/**
 * Consume one-shot enquiry flash (validation errors + field values).
 *
 * @return array{errors: string[], fields: array<string, mixed>}|null
 */
function restwell_enquire_consume_flash(): ?array {
	if ( ! isset( $_GET['enq_flash'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return null;
	}
	$key = sanitize_text_field( wp_unslash( $_GET['enq_flash'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( '' === $key || ! preg_match( '/^[A-Za-z0-9]{8,32}$/', $key ) ) {
		return null;
	}
	$transient_key = 'restwell_enq_flash_' . $key;
	$data          = get_transient( $transient_key );
	delete_transient( $transient_key );
	if ( ! is_array( $data ) ) {
		return null;
	}
	$errors = isset( $data['errors'] ) && is_array( $data['errors'] ) ? $data['errors'] : array();
	$fields = isset( $data['fields'] ) && is_array( $data['fields'] ) ? $data['fields'] : array();
	return array(
		'errors' => array_values( array_filter( array_map( 'strval', $errors ) ) ),
		'fields' => $fields,
	);
}

/**
 * Process enquiry form POST: validate, save CRM, send emails, redirect.
 */
function restwell_handle_enquire_submit(): void {
	if ( ! isset( $_POST['restwell_enquire'] ) || ! isset( $_POST[ RESTWELL_ENQUIRE_NONCE_NAME ] ) ) {
		return;
	}

	$redirect = isset( $_POST['enq_redirect'] ) ? esc_url_raw( wp_unslash( $_POST['enq_redirect'] ) ) : '';
	// Only trust client-supplied redirect targets pointing back at this site.
	if ( $redirect && '' !== (string) wp_parse_url( $redirect, PHP_URL_HOST )
		&& 0 !== strcasecmp( (string) wp_parse_url( $redirect, PHP_URL_HOST ), (string) wp_parse_url( home_url(), PHP_URL_HOST ) ) ) {
		$redirect = '';
	}
	if ( ! $redirect ) {
		$redirect = wp_get_referer();
		if ( ! $redirect ) {
			$redirect = home_url( '/enquire/' );
		}
	}

	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ RESTWELL_ENQUIRE_NONCE_NAME ] ) ), RESTWELL_ENQUIRE_NONCE_ACTION ) ) {
		restwell_enquire_redirect_flash(
			$redirect,
			array( __( 'Security check failed. Please try again.', 'restwell-retreats' ) ),
			array()
		);
	}

	// Honeypot: silent “success” for bots (no CRM row, no email).
	if ( ! empty( $_POST['enq_website'] ) ) {
		wp_safe_redirect( add_query_arg( 'sent', '1', $redirect ) . '#enquiry-result' );
		exit;
	}

	if ( restwell_form_timing_suspicious( isset( $_POST['restwell_form_opened_at'] ) ? (string) wp_unslash( $_POST['restwell_form_opened_at'] ) : '' ) ) {
		wp_safe_redirect( add_query_arg( 'sent', '1', $redirect ) . '#enquiry-result' );
		exit;
	}

	if ( restwell_form_rate_limit_exceeded( 'enquire' ) ) {
		restwell_enquire_redirect_flash(
			$redirect,
			array( __( 'Too many enquiries from your connection. Please wait before trying again, or phone us if your request is urgent.', 'restwell-retreats' ) ),
			array()
		);
	}

	$name    = isset( $_POST['enq_name'] ) ? sanitize_text_field( wp_unslash( $_POST['enq_name'] ) ) : '';
	$email   = isset( $_POST['enq_email'] ) ? sanitize_email( wp_unslash( $_POST['enq_email'] ) ) : '';
	$message = isset( $_POST['enq_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['enq_message'] ) ) : '';

	$phone_check  = restwell_validate_submission_phone(
		isset( $_POST['enq_phone'] ) ? (string) wp_unslash( $_POST['enq_phone'] ) : ''
	);
	$phone        = $phone_check['phone'];
	$date_from    = isset( $_POST['enq_date_from'] ) ? sanitize_text_field( wp_unslash( $_POST['enq_date_from'] ) ) : '';
	$date_to      = isset( $_POST['enq_date_to'] ) ? sanitize_text_field( wp_unslash( $_POST['enq_date_to'] ) ) : '';
	$guests       = isset( $_POST['enq_guests'] ) ? sanitize_text_field( wp_unslash( $_POST['enq_guests'] ) ) : '';
	$care         = isset( $_POST['enq_care'] ) ? sanitize_textarea_field( wp_unslash( $_POST['enq_care'] ) ) : '';
	$access       = isset( $_POST['enq_accessibility'] ) ? sanitize_textarea_field( wp_unslash( $_POST['enq_accessibility'] ) ) : '';
	$funding_raw  = isset( $_POST['enq_funding'] ) ? sanitize_key( wp_unslash( $_POST['enq_funding'] ) ) : '';
	$funding      = restwell_enquiry_normalise_funding( $funding_raw );
	$urgent       = ! empty( $_POST['enq_urgent'] );
	$marketing_optin = ! empty( $_POST['enq_marketing_optin'] );
	$privacy_consent = ! empty( $_POST['enq_consent'] );
	$health_consent  = ! empty( $_POST['enq_health_consent'] );
	$contact_pref = isset( $_POST['enq_contact_preference'] ) ? sanitize_key( wp_unslash( $_POST['enq_contact_preference'] ) ) : '';
	$pref_time    = isset( $_POST['enq_preferred_time'] ) ? sanitize_key( wp_unslash( $_POST['enq_preferred_time'] ) ) : '';

	$fields_flash = array(
		'enq_name'               => $name,
		'enq_email'              => $email,
		'enq_phone'              => $phone,
		'enq_message'            => $message,
		'enq_date_from'          => $date_from,
		'enq_date_to'            => $date_to,
		'enq_guests'             => $guests,
		'enq_care'               => $care,
		'enq_accessibility'      => $access,
		'enq_funding'            => $funding,
		'enq_urgent'             => $urgent ? '1' : '',
		'enq_marketing_optin'    => $marketing_optin ? '1' : '',
		'enq_consent'            => $privacy_consent ? '1' : '',
		'enq_health_consent'     => $health_consent ? '1' : '',
		'enq_contact_preference' => $contact_pref,
		'enq_preferred_time'     => $pref_time,
	);

	$errors = array();
	if ( '' === $name ) {
		$errors[] = __( 'Please add your name.', 'restwell-retreats' );
	}
	if ( '' === $email || ! is_email( $email ) ) {
		$errors[] = __( 'Please add a valid email address.', 'restwell-retreats' );
	}
	if ( '' !== $phone_check['error'] ) {
		$errors[] = $phone_check['error'];
	}
	if ( '' === $message ) {
		$errors[] = __( 'Please add a message so we know how to help.', 'restwell-retreats' );
	}
	if ( strlen( $message ) > 15000 ) {
		$errors[] = __( 'Your message is too long. Please shorten it slightly.', 'restwell-retreats' );
	}
	if ( ! $privacy_consent ) {
		$errors[] = __( 'Please confirm we can contact you about this enquiry, as set out in the privacy policy.', 'restwell-retreats' );
	}
	$has_health_notes = ( '' !== $care || '' !== $access );
	if ( $has_health_notes && ! $health_consent ) {
		$errors[] = __( 'Please confirm we can use the care or accessibility notes you added. Those notes can include health information.', 'restwell-retreats' );
	}
	if ( ! $has_health_notes ) {
		$health_consent = false;
	}

	$date_errors = restwell_validate_enquiry_dates( $date_from, $date_to );
	$errors      = array_merge( $errors, $date_errors );

	if ( $errors ) {
		restwell_enquire_redirect_flash( $redirect, $errors, $fields_flash );
	}

	// Defence in depth: never persist care/access notes without Art. 9 consent.
	if ( ! $health_consent ) {
		$care   = '';
		$access = '';
	}

	// Normalise dates for storage: blank invalid pairs already rejected.
	// Shared helper so admin date edits (crm.php) produce identical strings.
	$dates = restwell_format_enquiry_date_range( $date_from, $date_to );

	$body = "Name: $name\nEmail: $email\nPhone: $phone\n";
	if ( $contact_pref ) {
		$body .= 'Preferred contact: ' . $contact_pref . "\n";
	}
	if ( $pref_time ) {
		$body .= 'Best time to call: ' . $pref_time . "\n";
	}
	if ( $dates ) {
		$body .= "Preferred dates: $dates\n";
	}
	if ( $guests ) {
		$body .= "Number of guests: $guests\n";
	}
	if ( $funding ) {
		$body .= 'Funding type: ' . restwell_enquiry_funding_label( $funding ) . "\n";
	}
	if ( $urgent ) {
		$body .= "\n*** URGENT - prioritised callback requested ***\n";
	}
	$policy_version = function_exists( 'restwell_privacy_policy_version' )
		? restwell_privacy_policy_version()
		: '2026-09-01';
	$body .= "\nPrivacy consent: Yes (policy " . $policy_version . ")\n";
	$body .= 'Health-data consent (care/accessibility notes): ' . ( $health_consent ? 'Yes (policy ' . $policy_version . ')' : 'No (no care/accessibility notes stored as health data)' ) . "\n";
	$body .= 'Marketing updates consent: ' . ( $marketing_optin ? 'Yes (opted in)' : 'No (not opted in)' ) . "\n";
	if ( $care ) {
		$body .= "\nCare requirements:\n$care\n";
	}
	if ( $access ) {
		$body .= "\nAccessibility needs:\n$access\n";
	}
	$body .= "\nMessage:\n$message";

	$crm_data = array(
		'name'         => $name,
		'email'        => $email,
		'phone'        => $phone,
		'dates'        => $dates,
		'date_from'    => $date_from,
		'date_to'      => $date_to,
		'guests'       => $guests,
		'care'         => $care,
		'access'       => $access,
		'funding'      => $funding,
		'contact_pref' => $contact_pref,
		'pref_time'    => $pref_time,
		'message'      => $message,
		'urgent'                 => $urgent,
		'marketing_optin'        => $marketing_optin,
		'privacy_consent'        => true,
		'privacy_policy_version' => $policy_version,
		'health_data_consent'    => $health_consent,
	);

	$crm_result   = restwell_service_enquiry()->persist_lead( $crm_data );
	$enquiry_id   = $crm_result['id'] ?? false;
	$is_duplicate = $crm_result['is_duplicate'] ?? false;

	if ( ! $enquiry_id ) {
		// Rare DB failure: still email staff the payload so nothing is lost.
		$to      = restwell_get_submission_notify_email();
		$subject = restwell_mail_staff_subject( 'enquiry_save_failed' );
		$headers = array_values(
			array_filter(
				array(
					'Content-Type: text/plain; charset=UTF-8',
					restwell_mail_reply_to_header( $email ),
				)
			)
		);
		restwell_wp_mail_with_retry( $to, $subject, $body . "\n\n[CRM insert returned false]", $headers );
		restwell_enquire_redirect_flash(
			$redirect,
			array(
				__( 'We could not save your enquiry just now. Our team has been emailed with your details—please try again later or call us.', 'restwell-retreats' ),
			),
			$fields_flash
		);
	}

	if ( $is_duplicate ) {
		// Visitor re-submitted the same form within 30 minutes — succeed without
		// spamming staff or the guest with duplicate emails; surface distinct copy.
		restwell_service_enquiry()->record_duplicate_submit( (int) $enquiry_id );
		wp_safe_redirect(
			add_query_arg(
				array(
					'sent'      => '1',
					'duplicate' => '1',
				),
				$redirect
			) . '#enquiry-result'
		);
		exit;
	}

	if ( $marketing_optin ) {
		$mailchimp_ok = restwell_mailchimp_upsert_marketing_contact(
			$email,
			$name,
			$phone,
			'enquire',
			array( 'enquiry-form' )
		);
		if ( ! $mailchimp_ok ) {
			restwell_service_enquiry()->record_marketing_sync_failure( (int) $enquiry_id );
		}
	}

	$to      = restwell_get_submission_notify_email();
	$subject = restwell_mail_staff_subject( $urgent ? 'urgent_enquiry' : 'enquiry', (int) $enquiry_id );
	$headers = array_values(
		array_filter(
			array(
				'Content-Type: text/plain; charset=UTF-8',
				restwell_mail_reply_to_header( $email ),
			)
		)
	);
	$body   .= "\n\nCRM enquiry ID: #" . (string) $enquiry_id;

	$staff_sent = restwell_wp_mail_with_retry( $to, $subject, $body, $headers );
	if ( ! $staff_sent ) {
		restwell_service_crm_gateway()->add_enquiry_note(
			(int) $enquiry_id,
			__( 'Automated note: staff notification email did not send (SMTP/mail transport). Please follow up from CRM or resend manually.', 'restwell-retreats' )
		);
	}

	$ack = restwell_email_enquiry_ack( $name, $email, $urgent );
	$ack_ok = restwell_wp_mail_with_retry( $email, $ack['subject'], $ack['body'], $ack['headers'] );
	if ( ! $ack_ok ) {
		restwell_service_crm_gateway()->add_enquiry_note(
			(int) $enquiry_id,
			__( 'Automated note: acknowledgement email to the guest may not have sent. Consider replying manually.', 'restwell-retreats' )
		);
	}

	$args = array( 'sent' => '1' );
	if ( $urgent ) {
		$args['urgent'] = '1';
	}
	if ( ! $staff_sent ) {
		$args['mail_warn'] = '1';
	}
	wp_safe_redirect( add_query_arg( $args, $redirect ) . '#enquiry-result' );
	exit;
}
add_action( 'template_redirect', 'restwell_handle_enquire_submit', 5 );
