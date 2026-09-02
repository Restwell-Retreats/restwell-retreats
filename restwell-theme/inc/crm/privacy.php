<?php
/**
 * CRM: UK GDPR subject-access export and erasure.
 *
 * Hooks WordPress Tools → Export/Erase Personal Data, and adds a CRM form to
 * export or anonymise by email.
 *
 * @package Restwell_CRM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register CRM exporters for Tools → Export Personal Data.
 *
 * @param array<string, array<string, mixed>> $exporters Exporters.
 * @return array<string, array<string, mixed>>
 */
function restwell_crm_privacy_register_exporters( array $exporters ): array {
	$exporters['restwell-crm-enquiries'] = array(
		'exporter_friendly_name' => __( 'Restwell enquiries', 'restwell-retreats' ),
		'callback'               => 'restwell_crm_privacy_export_enquiries',
	);
	$exporters['restwell-crm-faq']       = array(
		'exporter_friendly_name' => __( 'Restwell FAQ questions', 'restwell-retreats' ),
		'callback'               => 'restwell_crm_privacy_export_faq',
	);
	$exporters['restwell-crm-guests']    = array(
		'exporter_friendly_name' => __( 'Restwell guest guide', 'restwell-retreats' ),
		'callback'               => 'restwell_crm_privacy_export_guests',
	);
	return $exporters;
}
add_filter( 'wp_privacy_personal_data_exporters', 'restwell_crm_privacy_register_exporters' );

/**
 * Register CRM erasers for Tools → Erase Personal Data.
 *
 * @param array<string, array<string, mixed>> $erasers Erasers.
 * @return array<string, array<string, mixed>>
 */
function restwell_crm_privacy_register_erasers( array $erasers ): array {
	$erasers['restwell-crm'] = array(
		'eraser_friendly_name' => __( 'Restwell CRM', 'restwell-retreats' ),
		'callback'             => 'restwell_crm_privacy_erase_by_email',
	);
	return $erasers;
}
add_filter( 'wp_privacy_personal_data_erasers', 'restwell_crm_privacy_register_erasers' );

/**
 * Export enquiry rows for an email (includes care/access — this is the subject’s own data).
 *
 * @param string $email_address Email.
 * @param int    $page          Page (unused; small tables).
 * @return array{data: array<int, array<string, mixed>>, done: bool}
 */
function restwell_crm_privacy_export_enquiries( string $email_address, int $page = 1 ): array {
	unset( $page );
	global $wpdb;
	$email = strtolower( sanitize_email( $email_address ) );
	$data  = array();
	if ( ! is_email( $email ) ) {
		return array(
			'data' => $data,
			'done' => true,
		);
	}
	$table = $wpdb->prefix . RESTWELL_CRM_TABLE;
	$rows  = $wpdb->get_results(
		$wpdb->prepare(
			'SELECT id, submitted_at, name, email, phone, preferred_dates, date_from, date_to,
			        num_guests, care_requirements, accessibility, funding_type, message,
			        status, privacy_consented_at, privacy_policy_version,
			        health_data_consent, health_data_consented_at
			 FROM %i WHERE anonymised_at IS NULL AND LOWER(email) = %s',
			$table,
			$email
		)
	);
	if ( ! is_array( $rows ) ) {
		$rows = array();
	}
	foreach ( $rows as $row ) {
		$item = array();
		foreach ( (array) $row as $key => $value ) {
			$item[] = array(
				'name'  => (string) $key,
				'value' => (string) $value,
			);
		}
		$data[] = array(
			'group_id'    => 'restwell-enquiries',
			'group_label' => __( 'Restwell enquiries', 'restwell-retreats' ),
			'item_id'     => 'enquiry-' . absint( $row->id ),
			'data'        => $item,
		);
	}
	return array(
		'data' => $data,
		'done' => true,
	);
}

/**
 * Export FAQ rows for an email.
 *
 * @param string $email_address Email.
 * @param int    $page          Page.
 * @return array{data: array<int, array<string, mixed>>, done: bool}
 */
function restwell_crm_privacy_export_faq( string $email_address, int $page = 1 ): array {
	unset( $page );
	global $wpdb;
	$email = strtolower( sanitize_email( $email_address ) );
	$data  = array();
	if ( ! is_email( $email ) ) {
		return array(
			'data' => $data,
			'done' => true,
		);
	}
	$table = $wpdb->prefix . RESTWELL_FAQ_TABLE;
	$rows  = $wpdb->get_results(
		$wpdb->prepare(
			'SELECT id, submitted_at, name, email, question, source_url
			 FROM %i WHERE anonymised_at IS NULL AND LOWER(email) = %s',
			$table,
			$email
		)
	);
	if ( ! is_array( $rows ) ) {
		$rows = array();
	}
	foreach ( $rows as $row ) {
		$item = array();
		foreach ( (array) $row as $key => $value ) {
			$item[] = array(
				'name'  => (string) $key,
				'value' => (string) $value,
			);
		}
		$data[] = array(
			'group_id'    => 'restwell-faq',
			'group_label' => __( 'Restwell FAQ questions', 'restwell-retreats' ),
			'item_id'     => 'faq-' . absint( $row->id ),
			'data'        => $item,
		);
	}
	return array(
		'data' => $data,
		'done' => true,
	);
}

/**
 * Export guest-guide rows for an email.
 *
 * @param string $email_address Email.
 * @param int    $page          Page.
 * @return array{data: array<int, array<string, mixed>>, done: bool}
 */
function restwell_crm_privacy_export_guests( string $email_address, int $page = 1 ): array {
	unset( $page );
	global $wpdb;
	$email = strtolower( sanitize_email( $email_address ) );
	$data  = array();
	if ( ! is_email( $email ) ) {
		return array(
			'data' => $data,
			'done' => true,
		);
	}
	$table = $wpdb->prefix . RESTWELL_GUESTS_TABLE;
	$rows  = $wpdb->get_results(
		$wpdb->prepare(
			'SELECT id, created_at, name, email
			 FROM %i WHERE anonymised_at IS NULL AND LOWER(email) = %s',
			$table,
			$email
		)
	);
	if ( ! is_array( $rows ) ) {
		$rows = array();
	}
	foreach ( $rows as $row ) {
		$item = array();
		foreach ( (array) $row as $key => $value ) {
			$item[] = array(
				'name'  => (string) $key,
				'value' => (string) $value,
			);
		}
		$data[] = array(
			'group_id'    => 'restwell-guests',
			'group_label' => __( 'Restwell guest guide', 'restwell-retreats' ),
			'item_id'     => 'guest-' . absint( $row->id ),
			'data'        => $item,
		);
	}
	return array(
		'data' => $data,
		'done' => true,
	);
}

/**
 * Anonymise CRM rows for a WordPress erasure request.
 *
 * @param string $email_address Email.
 * @param int    $page          Page.
 * @return array{items_removed: bool, items_retained: bool, messages: array<int, string>, done: bool}
 */
function restwell_crm_privacy_erase_by_email( string $email_address, int $page = 1 ): array {
	unset( $page );
	$email = sanitize_email( $email_address );
	$n     = 0;
	if ( is_email( $email ) ) {
		$n += restwell_crm_anonymise_enquiries_by_email( $email );
		$n += restwell_crm_anonymise_faq_by_email( $email );
		$n += restwell_crm_anonymise_guests_by_email( $email );
	}
	return array(
		'items_removed'  => $n > 0,
		'items_retained' => false,
		'messages'       => array(),
		'done'           => true,
	);
}

/**
 * Whether the user may anonymise CRM rows (destructive).
 *
 * @return bool
 */
function restwell_crm_can_erase_personal_data(): bool {
	return restwell_crm_can_manage()
		&& ( current_user_can( 'erase_others_personal_data' ) || current_user_can( 'manage_options' ) );
}

/**
 * CRM subject-access export (CSV of matching enquiry rows).
 */
function restwell_crm_handle_dsr_export(): void {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'Insufficient permissions.', 'restwell-retreats' ) );
	}
	check_admin_referer( 'restwell_crm_dsr' );

	$email = isset( $_POST['dsr_email'] ) ? sanitize_email( wp_unslash( $_POST['dsr_email'] ) ) : '';
	if ( ! is_email( $email ) ) {
		wp_safe_redirect(
			add_query_arg(
				array(
					'page'      => 'restwell-enquiries',
					'dsr_error' => 'email',
				),
				admin_url( 'admin.php' )
			)
		);
		exit;
	}

	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_CRM_TABLE;
	$rows  = $wpdb->get_results(
		$wpdb->prepare(
			'SELECT id, submitted_at, name, email, phone,
			        preferred_dates, date_from, date_to, num_guests,
			        care_requirements, accessibility, funding_type,
			        contact_preference, preferred_time, message,
			        is_urgent, marketing_optin, marketing_optin_at,
			        privacy_consented_at, privacy_policy_version,
			        health_data_consent, health_data_consented_at,
			        status
			 FROM %i WHERE anonymised_at IS NULL AND LOWER(email) = %s
			 ORDER BY submitted_at DESC',
			$table,
			strtolower( $email )
		),
		ARRAY_A
	);
	if ( ! is_array( $rows ) ) {
		$rows = array();
	}

	$filename = 'restwell-sar-' . gmdate( 'Y-m-d' ) . '.csv';
	header( 'Content-Type: text/csv; charset=UTF-8' );
	header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
	header( 'Pragma: no-cache' );
	header( 'Expires: 0' );

	$out = fopen( 'php://output', 'w' );
	fprintf( $out, chr( 0xEF ) . chr( 0xBB ) . chr( 0xBF ) );
	if ( array() !== $rows ) {
		fputcsv( $out, array_keys( $rows[0] ) );
		foreach ( $rows as $row ) {
			fputcsv( $out, $row );
		}
	} else {
		fputcsv( $out, array( 'id' ) );
	}
	fclose( $out ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fclose
	exit;
}
add_action( 'admin_post_restwell_crm_dsr_export', 'restwell_crm_handle_dsr_export' );

/**
 * CRM subject-access anonymise.
 */
function restwell_crm_handle_dsr_erase(): void {
	if ( ! restwell_crm_can_erase_personal_data() ) {
		wp_die( esc_html__( 'Insufficient permissions.', 'restwell-retreats' ) );
	}
	check_admin_referer( 'restwell_crm_dsr' );

	$email         = isset( $_POST['dsr_email'] ) ? sanitize_email( wp_unslash( $_POST['dsr_email'] ) ) : '';
	$confirm_email = isset( $_POST['dsr_email_confirm'] ) ? sanitize_email( wp_unslash( $_POST['dsr_email_confirm'] ) ) : '';
	$confirmed     = isset( $_POST['dsr_confirm'] ) && '1' === (string) wp_unslash( $_POST['dsr_confirm'] );
	if ( ! is_email( $email ) || strtolower( $email ) !== strtolower( $confirm_email ) || ! $confirmed ) {
		wp_safe_redirect(
			add_query_arg(
				array(
					'page'      => 'restwell-enquiries',
					'dsr_error' => 'confirm',
				),
				admin_url( 'admin.php' )
			)
		);
		exit;
	}

	$n  = restwell_crm_anonymise_enquiries_by_email( $email );
	$n += restwell_crm_anonymise_faq_by_email( $email );
	$n += restwell_crm_anonymise_guests_by_email( $email );

	wp_safe_redirect(
		add_query_arg(
			array(
				'page'      => 'restwell-enquiries',
				'dsr_erased' => (string) $n,
			),
			admin_url( 'admin.php' )
		)
	);
	exit;
}
add_action( 'admin_post_restwell_crm_dsr_erase', 'restwell_crm_handle_dsr_erase' );
