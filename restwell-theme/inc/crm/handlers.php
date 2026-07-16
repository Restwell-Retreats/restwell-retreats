<?php
/**
 * CRM: admin-post and AJAX request handlers.
 *
 * @package Restwell_CRM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ─────────────────────────────────────────────────────────────────────────────
// 6. ADMIN POST HANDLERS
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Stream all enquiries as a UTF-8 CSV download.
 */
function restwell_crm_handle_export_csv() {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'Insufficient permissions.', 'restwell-retreats' ) );
	}
	check_admin_referer( 'restwell_crm_export_csv' );

	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_CRM_TABLE;
	// Explicit column list — avoids pulling unexpected columns added by future migrations.
	$rows = $wpdb->get_results(
		$wpdb->prepare(
			'SELECT id, submitted_at, name, email, phone,
			        preferred_dates, date_from, date_to, num_guests,
			        care_requirements, accessibility, funding_type,
			        contact_preference, preferred_time, message,
			        is_urgent, marketing_optin, marketing_optin_at,
			        status, staff_notes, follow_up_at,
			        last_reminder_at, contacted_at, qualified_at, booked_at, closed_at
			 FROM %i ORDER BY submitted_at DESC',
			$table
		),
		ARRAY_A
	);

	// Append to audit log before streaming headers (headers cannot be sent before update_option).
	$export_log_entry = array(
		'user_id'     => get_current_user_id(),
		'exported_at' => gmdate( 'Y-m-d H:i:s' ),
		'row_count'   => count( (array) $rows ),
	);
	$export_log = get_option( 'restwell_crm_export_log', array() );
	if ( ! is_array( $export_log ) ) {
		$export_log = array();
	}
	$export_log[] = $export_log_entry;
	update_option( 'restwell_crm_export_log', array_slice( $export_log, -200 ) ); // keep last 200 entries

	$filename = 'restwell-enquiries-' . gmdate( 'Y-m-d' ) . '.csv';

	header( 'Content-Type: text/csv; charset=UTF-8' );
	header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
	header( 'Pragma: no-cache' );
	header( 'Expires: 0' );

	$out = fopen( 'php://output', 'w' );
	// BOM for Excel UTF-8 compatibility.
	fprintf( $out, chr( 0xEF ) . chr( 0xBB ) . chr( 0xBF ) );

	if ( ! empty( $rows ) ) {
		fputcsv( $out, array_keys( $rows[0] ) );
		foreach ( $rows as $row ) {
			fputcsv( $out, $row );
		}
	}

	fclose( $out ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fclose
	exit;
}
add_action( 'admin_post_restwell_crm_export_csv', 'restwell_crm_handle_export_csv' );

/**
 * Send the post-stay follow-up email for a closed enquiry.
 */
function restwell_crm_handle_send_post_stay() {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'Insufficient permissions.', 'restwell-retreats' ) );
	}

	$id = absint( $_POST['rw_enquiry_id'] ?? 0 );
	check_admin_referer( 'restwell_crm_send_post_stay_' . $id );

	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_CRM_TABLE;
	// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	$row = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$table} WHERE id = %d", $id ) );

	if ( $row && function_exists( 'restwell_email_post_stay' ) ) {
		$email_data = restwell_email_post_stay( $row->email, $row->name );
		wp_mail( $row->email, $email_data['subject'], $email_data['body'], $email_data['headers'] );
		restwell_service_crm_gateway()->add_enquiry_note( $id, __( 'Post-stay email sent.', 'restwell-retreats' ) );
	}

	wp_safe_redirect(
		add_query_arg(
			array(
				'page' => 'restwell-enquiries',
				'view' => $id,
				'updated' => '1',
			),
			admin_url( 'admin.php' )
		)
	);
	exit;
}
add_action( 'admin_post_restwell_crm_send_post_stay', 'restwell_crm_handle_send_post_stay' );

/**
 * Save the notification email setting.
 */
function restwell_crm_handle_save_settings() {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'Insufficient permissions.', 'restwell-retreats' ) );
	}
	check_admin_referer( 'restwell_crm_settings' );

	// Always persist these values — including empty string — so editors can intentionally clear stale data.
	$email = isset( $_POST['restwell_enquiry_notify_email'] )
		? sanitize_email( wp_unslash( $_POST['restwell_enquiry_notify_email'] ) )
		: '';
	update_option( 'restwell_enquiry_notify_email', $email );

	// Phone, schema address, verification, analytics, property line, footer CTA, access PDF:
	// managed under SEO → Site-wide (restwell_seo_sitewide_handle_save).

	$mailchimp_api_key = isset( $_POST['restwell_mailchimp_api_key'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_mailchimp_api_key'] ) )
		: '';
	$mailchimp_api_key = preg_replace( '/[^A-Za-z0-9\-]/', '', trim( $mailchimp_api_key ) );
	// Prefer RESTWELL_MAILCHIMP_API_KEY in wp-config; option is fallback only and must not autoload.
	if ( '' !== $mailchimp_api_key ) {
		update_option( 'restwell_mailchimp_api_key', $mailchimp_api_key, false );
	} elseif ( ! empty( $_POST['restwell_mailchimp_api_key_clear'] ) ) {
		update_option( 'restwell_mailchimp_api_key', '', false );
	}

	$mailchimp_audience_id = isset( $_POST['restwell_mailchimp_audience_id'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_mailchimp_audience_id'] ) )
		: '';
	$mailchimp_audience_id = preg_replace( '/[^0-9A-Za-z]/', '', $mailchimp_audience_id );
	update_option( 'restwell_mailchimp_audience_id', $mailchimp_audience_id, false );

	$mailchimp_server_prefix = isset( $_POST['restwell_mailchimp_server_prefix'] )
		? sanitize_key( wp_unslash( $_POST['restwell_mailchimp_server_prefix'] ) )
		: '';
	update_option( 'restwell_mailchimp_server_prefix', $mailchimp_server_prefix, false );

	$raw_cap_roles = isset( $_POST['restwell_crm_cap_roles'] ) ? (array) wp_unslash( $_POST['restwell_crm_cap_roles'] ) : array();
	$cap_roles     = array_values(
		array_intersect(
			array_map( 'sanitize_key', $raw_cap_roles ),
			array( 'administrator', 'editor', 'author' )
		)
	);
	if ( empty( $cap_roles ) ) {
		$cap_roles = array( 'administrator' );
	}
	update_option( 'restwell_crm_cap_roles', $cap_roles );

	wp_safe_redirect(
		add_query_arg(
			array(
				'page' => 'restwell-crm',
				'settings_saved' => '1',
			),
			admin_url( 'admin.php' )
		)
	);
	exit;
}
add_action( 'admin_post_restwell_save_settings', 'restwell_crm_handle_save_settings' );

/**
 * Add a note to the enquiry activity log.
 */
function restwell_crm_handle_add_note() {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'Insufficient permissions.', 'restwell-retreats' ) );
	}
	check_admin_referer( 'restwell_crm_add_note' );

	$enquiry_id = absint( $_POST['rw_enquiry_id'] ?? 0 );
	$note       = sanitize_textarea_field( wp_unslash( $_POST['rw_note_text'] ?? '' ) );

	if ( $enquiry_id && $note ) {
		restwell_service_crm_gateway()->add_enquiry_note( $enquiry_id, $note );
	}

	wp_safe_redirect(
		add_query_arg(
			array(
				'page' => 'restwell-enquiries',
				'view' => $enquiry_id,
				'note_added' => '1',
			),
			admin_url( 'admin.php' )
		)
	);
	exit;
}
add_action( 'admin_post_restwell_crm_add_note', 'restwell_crm_handle_add_note' );

/**
 * Update an enquiry's stay dates from the detail page.
 *
 * Why this exists separately from the public enquiry form's validation:
 * - Admins are allowed to set dates in the past (cleaning up historical records,
 *   logging arrival info after the fact, etc.). The public-form rule that
 *   "preferred dates can't be in the past" doesn't apply to staff.
 * - Admins are allowed to clear dates entirely (a guest changes their mind,
 *   or the original submission was a typo). Empty string → NULL in the DB,
 *   and `preferred_dates` gets recomputed to "" in lockstep.
 * - Every change is recorded as an automated note ("Stay dates updated:
 *   {old} → {new}") so the activity log stays an honest audit trail.
 *
 * Re-uses `restwell_format_enquiry_date_range()` so the human-readable
 * `preferred_dates` string the rest of the CRM displays stays byte-identical
 * to what the public form would have written.
 */
function restwell_crm_handle_update_stay_dates(): void {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'Insufficient permissions.', 'restwell-retreats' ) );
	}
	check_admin_referer( 'restwell_crm_update_stay_dates' );

	$enquiry_id = absint( $_POST['rw_enquiry_id'] ?? 0 );
	$date_from  = sanitize_text_field( wp_unslash( $_POST['rw_date_from'] ?? '' ) );
	$date_to    = sanitize_text_field( wp_unslash( $_POST['rw_date_to'] ?? '' ) );

	if ( ! $enquiry_id ) {
		wp_die( esc_html__( 'Missing enquiry ID.', 'restwell-retreats' ) );
	}

	$redirect_base = add_query_arg(
		array(
			'page' => 'restwell-enquiries',
			'view' => $enquiry_id,
		),
		admin_url( 'admin.php' )
	);

	// Format check: empty is fine (= clear the field), but anything non-empty
	// must be a valid Y-m-d. We deliberately *don't* reject past dates here —
	// see the docblock above.
	$valid_ymd = static function ( string $d ): bool {
		return '' === $d || (bool) preg_match( '/^\d{4}-\d{2}-\d{2}$/', $d );
	};
	if ( ! $valid_ymd( $date_from ) || ! $valid_ymd( $date_to ) ) {
		wp_safe_redirect( add_query_arg( 'stay_dates_error', 'invalid', $redirect_base ) );
		exit;
	}
	if ( '' !== $date_from && '' !== $date_to && $date_to < $date_from ) {
		wp_safe_redirect( add_query_arg( 'stay_dates_error', 'order', $redirect_base ) );
		exit;
	}

	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_CRM_TABLE;

	// Read current values so we can (a) skip a no-op write, and (b) write a
	// "before → after" entry in the activity log.
	$existing = $wpdb->get_row(
		$wpdb->prepare( 'SELECT date_from, date_to FROM %i WHERE id = %d', $table, $enquiry_id )
	);
	if ( ! $existing ) {
		wp_die( esc_html__( 'Enquiry not found.', 'restwell-retreats' ) );
	}
	$old_from = $existing->date_from ?: '';
	$old_to   = $existing->date_to ?: '';

	if ( $old_from === $date_from && $old_to === $date_to ) {
		// Nothing changed — don't pollute the activity log with empty diffs.
		wp_safe_redirect( add_query_arg( 'stay_dates_unchanged', '1', $redirect_base ) );
		exit;
	}

	$wpdb->update(
		$table,
		array(
			// Empty becomes NULL in the column (it's `date DEFAULT NULL`); $wpdb
			// passes NULL through regardless of the format string for that slot.
			'date_from'       => '' === $date_from ? null : $date_from,
			'date_to'         => '' === $date_to ? null : $date_to,
			'preferred_dates' => restwell_format_enquiry_date_range( $date_from, $date_to ),
		),
		array( 'id' => $enquiry_id ),
		array( '%s', '%s', '%s' ),
		array( '%d' )
	);

	$none_label = __( '(none)', 'restwell-retreats' );
	$note       = sprintf(
		/* translators: 1: previous stay-date range or "(none)", 2: new stay-date range or "(none)" */
		__( 'Stay dates updated: %1$s → %2$s', 'restwell-retreats' ),
		restwell_format_enquiry_date_range( $old_from, $old_to ) ?: $none_label,
		restwell_format_enquiry_date_range( $date_from, $date_to ) ?: $none_label
	);
	restwell_service_crm_gateway()->add_enquiry_note( $enquiry_id, $note );

	wp_safe_redirect( add_query_arg( 'stay_dates_updated', '1', $redirect_base ) );
	exit;
}
add_action( 'admin_post_restwell_crm_update_stay_dates', 'restwell_crm_handle_update_stay_dates' );

/**
 * Handle inline lead quick-actions from the enquiries list.
 */
function restwell_crm_handle_lead_action() {
	if ( ! restwell_crm_can_manage() ) {
		wp_send_json_error(
			array(
				'message' => __( 'You do not have permission to manage enquiries.', 'restwell-retreats' ),
			),
			403
		);
	}

	check_ajax_referer( 'restwell_crm_lead_action', 'nonce' );

	$lead_id      = absint( $_POST['lead_id'] ?? 0 );
	$action_type  = sanitize_key( $_POST['action_type'] ?? '' );

	if ( ! $lead_id || ! in_array( $action_type, array( 'set_status', 'add_note' ), true ) ) {
		wp_send_json_error(
			array(
				'message' => __( 'Invalid lead action request.', 'restwell-retreats' ),
			),
			400
		);
	}

	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_CRM_TABLE;
	// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	$row = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$table} WHERE id = %d", $lead_id ) );

	if ( ! $row ) {
		wp_send_json_error(
			array(
				'message' => __( 'Lead not found.', 'restwell-retreats' ),
			),
			404
		);
	}

	if ( 'set_status' === $action_type ) {
		$new_status = sanitize_key( $_POST['new_status'] ?? '' );
		if ( ! isset( restwell_crm_statuses()[ $new_status ] ) ) {
			wp_send_json_error(
				array(
					'message' => __( 'Invalid status.', 'restwell-retreats' ),
				),
				400
			);
		}

		// Delegate to the unified function — it handles timestamps, note, and booking email.
		$ok = restwell_crm_ops_apply_status_change( $lead_id, $new_status, 'ajax' );

		if ( ! $ok ) {
			wp_send_json_error( array( 'message' => __( 'Status update failed.', 'restwell-retreats' ) ), 500 );
		}

		// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		$fresh_row = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$table} WHERE id = %d", $lead_id ) );

		wp_send_json_success(
			array(
				'message'             => __( 'Status updated.', 'restwell-retreats' ),
				'updated_status'      => $new_status,
				'updated_status_html' => restwell_crm_status_badge( $new_status ),
				'sla_html'            => $fresh_row ? restwell_crm_sla_badge( $fresh_row ) : '',
				'timestamp'           => current_time( 'mysql' ),
			)
		);
	}

	$note_text = sanitize_textarea_field( wp_unslash( $_POST['note_text'] ?? '' ) );
	if ( '' === $note_text ) {
		wp_send_json_error(
			array(
				'message' => __( 'Note is empty.', 'restwell-retreats' ),
			),
			400
		);
	}

	restwell_service_crm_gateway()->add_enquiry_note( $lead_id, $note_text );

	wp_send_json_success(
		array(
			'message'   => __( 'Note added.', 'restwell-retreats' ),
			'timestamp' => current_time( 'mysql' ),
		)
	);
}
add_action( 'wp_ajax_restwell_lead_action', 'restwell_crm_handle_lead_action' );

/**
 * One-time: stop autoloading Mailchimp credentials already stored in the DB.
 */
function restwell_crm_disable_mailchimp_option_autoload() {
	if ( get_option( 'restwell_mailchimp_autoload_fixed_v1', '' ) === '1' ) {
		return;
	}

	$keys = array(
		'restwell_mailchimp_api_key',
		'restwell_mailchimp_audience_id',
		'restwell_mailchimp_server_prefix',
	);

	foreach ( $keys as $option_name ) {
		$value = get_option( $option_name, null );
		if ( null === $value || false === $value ) {
			continue;
		}
		update_option( $option_name, $value, false );
	}

	update_option( 'restwell_mailchimp_autoload_fixed_v1', '1', false );
}
add_action( 'admin_init', 'restwell_crm_disable_mailchimp_option_autoload', 5 );
