<?php
/**
 * CRM: enquiry and FAQ submission persistence.
 *
 * @package Restwell_CRM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ─────────────────────────────────────────────────────────────────────────────
// 2. SAVE ENQUIRY (called from enquire-handler.php)
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Persist an enquiry submission to the database.
 *
 * Runs a lightweight duplicate check first: if the same email submitted
 * within the last 30 minutes we skip the insert and return the existing
 * row ID, preventing accidental double-submissions.
 *
 * @param array $data Sanitised form values keyed by short name.
 * @return array{id: int|false, is_duplicate: bool}
 *   'id'           — Inserted or existing row ID (false on DB failure).
 *   'is_duplicate' — true when the insert was skipped due to deduplication.
 */
function restwell_crm_save_enquiry( array $data ): array {
	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_CRM_TABLE;
	$email = $data['email'] ?? '';

	// Duplicate guard: same email, submitted in the last 30 minutes.
	if ( $email ) {
		$cutoff  = gmdate( 'Y-m-d H:i:s', time() - 30 * MINUTE_IN_SECONDS );
		$dup_id  = (int) $wpdb->get_var(
			$wpdb->prepare(
				'SELECT id FROM %i WHERE email = %s AND submitted_at >= %s ORDER BY id DESC LIMIT 1',
				$table,
				$email,
				$cutoff
			)
		);
		if ( $dup_id ) {
			return array(
				'id' => $dup_id,
				'is_duplicate' => true,
			);
		}
	}

	// Normalise optional date columns; store NULL when blank.
	$date_from = ! empty( $data['date_from'] ) ? $data['date_from'] : null;
	$date_to   = ! empty( $data['date_to'] ) ? $data['date_to'] : null;
	$marketing_optin    = ! empty( $data['marketing_optin'] ) ? 1 : 0;
	$marketing_optin_at = $marketing_optin ? current_time( 'mysql' ) : null;
	$staff_notes = '';
	if ( array_key_exists( 'marketing_optin', $data ) ) {
		$staff_notes = ! empty( $data['marketing_optin'] )
			? __( 'Marketing updates consent: Yes (opted in).', 'restwell-retreats' )
			: __( 'Marketing updates consent: No (not opted in).', 'restwell-retreats' );
	}

	$result = $wpdb->insert(
		$table,
		array(
			'submitted_at'       => current_time( 'mysql' ),
			'name'               => $data['name'] ?? '',
			'email'              => $email,
			'phone'              => $data['phone'] ?? '',
			'preferred_dates'    => $data['dates'] ?? '',
			'date_from'          => $date_from,
			'date_to'            => $date_to,
			'num_guests'         => $data['guests'] ?? '',
			'care_requirements'  => $data['care'] ?? '',
			'accessibility'      => $data['access'] ?? '',
			'funding_type'       => $data['funding'] ?? '',
			'contact_preference' => $data['contact_pref'] ?? '',
			'preferred_time'     => $data['pref_time'] ?? '',
			'message'            => $data['message'] ?? '',
			'is_urgent'          => ! empty( $data['urgent'] ) ? 1 : 0,
			'marketing_optin'    => $marketing_optin,
			'marketing_optin_at' => $marketing_optin_at,
			'status'             => 'new',
			'staff_notes'        => $staff_notes,
		),
		array( '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%d', '%s', '%s', '%s' )
	);

	if ( $result ) {
		return array(
			'id' => (int) $wpdb->insert_id,
			'is_duplicate' => false,
		);
	}
	return array(
		'id' => false,
		'is_duplicate' => false,
	);
}

/**
 * Persist an FAQ page question (always store before attempting email).
 *
 * @param array{name:string,email:string,question:string,source_url?:string,marketing_optin?:bool|int|string} $data Sanitised fields.
 * @return int|false Inserted row ID, or false on failure.
 */
function restwell_faq_save_submission( array $data ) {
	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_FAQ_TABLE;
	$marketing_optin    = ! empty( $data['marketing_optin'] ) ? 1 : 0;
	$marketing_optin_at = $marketing_optin ? current_time( 'mysql' ) : null;
	$result = $wpdb->insert(
		$table,
		array(
			'submitted_at' => current_time( 'mysql' ),
			'name'         => $data['name'] ?? '',
			'email'        => $data['email'] ?? '',
			'question'     => $data['question'] ?? '',
			'notify_sent'  => 0,
			'marketing_optin' => $marketing_optin,
			'marketing_optin_at' => $marketing_optin_at,
			'source_url'   => $data['source_url'] ?? '',
		),
		array( '%s', '%s', '%s', '%s', '%d', '%d', '%s', '%s' )
	);
	return $result ? (int) $wpdb->insert_id : false;
}

/**
 * Mark FAQ staff notification as sent.
 *
 * @param int $id Submission row ID.
 */
function restwell_faq_mark_notify_sent( int $id ): void {
	global $wpdb;
	$wpdb->update(
		$wpdb->prefix . RESTWELL_FAQ_TABLE,
		array( 'notify_sent' => 1 ),
		array( 'id' => $id ),
		array( '%d' ),
		array( '%d' )
	);
}
