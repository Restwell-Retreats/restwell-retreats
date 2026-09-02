<?php
/**
 * CRM: scheduled anonymise and field-level retention (UK GDPR).
 *
 * Enquiry records: anonymise PII after three years from submitted_at.
 * Unused care/accessibility notes: 12 months if never booked; 90 days after
 * the stay end (date_to, else booked_at) when the enquiry was booked.
 *
 * @package Restwell_CRM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Schedule the daily retention pass.
 */
function restwell_crm_retention_schedule(): void {
	if ( wp_next_scheduled( 'restwell_crm_retention_daily' ) ) {
		return;
	}
	wp_schedule_event( time() + HOUR_IN_SECONDS, 'daily', 'restwell_crm_retention_daily' );
}
add_action( 'init', 'restwell_crm_retention_schedule', 30 );

/**
 * Run field purge then three-year anonymise.
 */
function restwell_crm_run_retention(): void {
	restwell_crm_purge_unused_health_fields();
	restwell_crm_anonymise_expired_enquiries();
	restwell_crm_anonymise_expired_faq_submissions();
	restwell_crm_anonymise_expired_guests();
}
add_action( 'restwell_crm_retention_daily', 'restwell_crm_run_retention' );

/**
 * Blank care/accessibility notes that have passed their shorter TTL.
 */
function restwell_crm_purge_unused_health_fields(): void {
	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_CRM_TABLE;
	$now   = current_time( 'mysql' );
	if ( ! is_string( $now ) || '' === $now ) {
		return;
	}

	$twelve_months_ago = gmdate( 'Y-m-d H:i:s', strtotime( $now . ' -12 months' ) );
	$ninety_days_ago   = gmdate( 'Y-m-d', strtotime( $now . ' -90 days' ) );

	// Never booked: drop health notes after 12 months.
	$wpdb->query(
		$wpdb->prepare(
			"UPDATE %i
			SET care_requirements = '',
				accessibility = ''
			WHERE anonymised_at IS NULL
			AND booked_at IS NULL
			AND submitted_at < %s
			AND (care_requirements <> '' OR accessibility <> '')",
			$table,
			$twelve_months_ago
		)
	);

	// Booked: drop health notes 90 days after stay end (date_to) or booked_at.
	$wpdb->query(
		$wpdb->prepare(
			"UPDATE %i
			SET care_requirements = '',
				accessibility = ''
			WHERE anonymised_at IS NULL
			AND booked_at IS NOT NULL
			AND (care_requirements <> '' OR accessibility <> '')
			AND COALESCE(date_to, DATE(booked_at)) < %s",
			$table,
			$ninety_days_ago
		)
	);
}

/**
 * Anonymise enquiry PII older than three years.
 */
function restwell_crm_anonymise_expired_enquiries(): void {
	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_CRM_TABLE;
	$now   = current_time( 'mysql' );
	if ( ! is_string( $now ) || '' === $now ) {
		return;
	}
	$cutoff = gmdate( 'Y-m-d H:i:s', strtotime( $now . ' -3 years' ) );

	$ids = $wpdb->get_col(
		$wpdb->prepare(
			'SELECT id FROM %i WHERE anonymised_at IS NULL AND submitted_at < %s',
			$table,
			$cutoff
		)
	);
	if ( ! is_array( $ids ) || array() === $ids ) {
		return;
	}

	foreach ( array_map( 'absint', $ids ) as $id ) {
		if ( $id < 1 ) {
			continue;
		}
		restwell_crm_anonymise_enquiry_id( $id, $now );
	}
}

/**
 * Anonymise one enquiry row and delete its staff notes.
 *
 * @param int    $id  Enquiry id.
 * @param string $now MySQL datetime; empty uses current_time.
 * @return bool
 */
function restwell_crm_anonymise_enquiry_id( int $id, string $now = '' ): bool {
	global $wpdb;
	$id = absint( $id );
	if ( $id < 1 ) {
		return false;
	}
	if ( '' === $now ) {
		$now = current_time( 'mysql' );
		if ( ! is_string( $now ) || '' === $now ) {
			return false;
		}
	}
	$table       = $wpdb->prefix . RESTWELL_CRM_TABLE;
	$notes_table = $wpdb->prefix . RESTWELL_NOTES_TABLE;
	$updated     = $wpdb->update(
		$table,
		array(
			'name'               => '',
			'email'              => '',
			'phone'              => '',
			'preferred_dates'    => '',
			'num_guests'         => '',
			'care_requirements'  => '',
			'accessibility'      => '',
			'message'            => '',
			'staff_notes'        => '',
			'contact_preference' => '',
			'preferred_time'     => '',
			'anonymised_at'      => $now,
		),
		array(
			'id' => $id,
		),
		array( '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' ),
		array( '%d' )
	);
	if ( false === $updated ) {
		return false;
	}
	$wpdb->delete( $notes_table, array( 'enquiry_id' => $id ), array( '%d' ) );
	return true;
}

/**
 * Enquiry ids for an email that have not been anonymised.
 *
 * @param string $email Address.
 * @return int[]
 */
function restwell_crm_enquiry_ids_for_email( string $email ): array {
	global $wpdb;
	$email = strtolower( sanitize_email( $email ) );
	if ( ! is_email( $email ) ) {
		return array();
	}
	$table = $wpdb->prefix . RESTWELL_CRM_TABLE;
	$ids   = $wpdb->get_col(
		$wpdb->prepare(
			'SELECT id FROM %i WHERE anonymised_at IS NULL AND LOWER(email) = %s',
			$table,
			$email
		)
	);
	if ( ! is_array( $ids ) ) {
		return array();
	}
	return array_values( array_filter( array_map( 'absint', $ids ) ) );
}

/**
 * Anonymise all live enquiry rows for an email.
 *
 * @param string $email Address.
 * @return int Rows anonymised.
 */
function restwell_crm_anonymise_enquiries_by_email( string $email ): int {
	$now   = current_time( 'mysql' );
	$count = 0;
	foreach ( restwell_crm_enquiry_ids_for_email( $email ) as $id ) {
		if ( restwell_crm_anonymise_enquiry_id( $id, is_string( $now ) ? $now : '' ) ) {
			++$count;
		}
	}
	return $count;
}

/**
 * Anonymise FAQ questions for an email.
 *
 * @param string $email Address.
 * @return int Rows updated.
 */
function restwell_crm_anonymise_faq_by_email( string $email ): int {
	global $wpdb;
	$email = strtolower( sanitize_email( $email ) );
	if ( ! is_email( $email ) ) {
		return 0;
	}
	$table = $wpdb->prefix . RESTWELL_FAQ_TABLE;
	$now   = current_time( 'mysql' );
	if ( ! is_string( $now ) || '' === $now ) {
		return 0;
	}
	$updated = $wpdb->query(
		$wpdb->prepare(
			"UPDATE %i
			SET name = '',
				email = '',
				question = '',
				source_url = '',
				anonymised_at = %s
			WHERE anonymised_at IS NULL
			AND LOWER(email) = %s",
			$table,
			$now,
			$email
		)
	);
	return is_int( $updated ) ? $updated : 0;
}

/**
 * Anonymise guest-guide rows for an email.
 *
 * @param string $email Address.
 * @return int Rows updated.
 */
function restwell_crm_anonymise_guests_by_email( string $email ): int {
	global $wpdb;
	$email = strtolower( sanitize_email( $email ) );
	if ( ! is_email( $email ) ) {
		return 0;
	}
	$table = $wpdb->prefix . RESTWELL_GUESTS_TABLE;
	$now   = current_time( 'mysql' );
	if ( ! is_string( $now ) || '' === $now ) {
		return 0;
	}
	$updated = $wpdb->query(
		$wpdb->prepare(
			"UPDATE %i
			SET name = '',
				email = '',
				anonymised_at = %s
			WHERE anonymised_at IS NULL
			AND LOWER(email) = %s",
			$table,
			$now,
			$email
		)
	);
	return is_int( $updated ) ? $updated : 0;
}

/**
 * Anonymise FAQ questions older than three years.
 */
function restwell_crm_anonymise_expired_faq_submissions(): void {
	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_FAQ_TABLE;
	$now   = current_time( 'mysql' );
	if ( ! is_string( $now ) || '' === $now ) {
		return;
	}
	$cutoff = gmdate( 'Y-m-d H:i:s', strtotime( $now . ' -3 years' ) );

	$wpdb->query(
		$wpdb->prepare(
			"UPDATE %i
			SET name = '',
				email = '',
				question = '',
				source_url = '',
				anonymised_at = %s
			WHERE anonymised_at IS NULL
			AND submitted_at < %s",
			$table,
			$now,
			$cutoff
		)
	);
}

/**
 * Anonymise guest-guide rows older than three years.
 */
function restwell_crm_anonymise_expired_guests(): void {
	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_GUESTS_TABLE;
	$now   = current_time( 'mysql' );
	if ( ! is_string( $now ) || '' === $now ) {
		return;
	}
	$cutoff = gmdate( 'Y-m-d H:i:s', strtotime( $now . ' -3 years' ) );

	$wpdb->query(
		$wpdb->prepare(
			"UPDATE %i
			SET name = '',
				email = '',
				anonymised_at = %s
			WHERE anonymised_at IS NULL
			AND created_at < %s",
			$table,
			$now,
			$cutoff
		)
	);
}
