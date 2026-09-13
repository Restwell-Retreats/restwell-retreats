<?php
/**
 * CRM: field-level retention for unused care/accessibility notes.
 *
 * Unused care/accessibility notes: 12 months if never booked; 90 days after
 * the stay end (date_to, else booked_at) when the enquiry was booked.
 * Full-row anonymise is not used.
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
 * Blank unused care/accessibility notes that have passed their TTL.
 */
function restwell_crm_run_retention(): void {
	restwell_crm_purge_unused_health_fields();
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
