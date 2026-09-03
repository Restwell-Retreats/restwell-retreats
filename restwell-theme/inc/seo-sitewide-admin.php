<?php
/**
 * SEO → Site-wide settings (verification, analytics, business schema).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/seo-sitewide-render.php';

/**
 * Register Site-wide under the SEO menu.
 */
function restwell_seo_sitewide_register_menu() {
	add_submenu_page(
		'restwell-seo',
		__( 'Site-wide', 'restwell-retreats' ),
		__( 'Site-wide', 'restwell-retreats' ),
		'manage_options',
		'restwell-seo-sitewide',
		'restwell_seo_sitewide_render_page'
	);
}
add_action( 'admin_menu', 'restwell_seo_sitewide_register_menu', 20 );

/**
 * Save site-wide SEO options.
 */
function restwell_seo_sitewide_handle_save() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You do not have permission to change these settings.', 'restwell-retreats' ), '', array( 'response' => 403 ) );
	}
	check_admin_referer( 'restwell_seo_sitewide' );

	$phone = isset( $_POST['restwell_phone_number'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_phone_number'] ) )
		: '';
	update_option( 'restwell_phone_number', $phone );

	$business_street = isset( $_POST['restwell_business_street'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_business_street'] ) )
		: '';
	update_option( 'restwell_business_street', $business_street );

	$business_locality = isset( $_POST['restwell_business_locality'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_business_locality'] ) )
		: '';
	update_option( 'restwell_business_locality', $business_locality );

	$business_region = isset( $_POST['restwell_business_region'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_business_region'] ) )
		: '';
	update_option( 'restwell_business_region', $business_region );

	$business_postcode = isset( $_POST['restwell_business_postcode'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_business_postcode'] ) )
		: '';
	update_option( 'restwell_business_postcode', $business_postcode );

	$business_geo_lat = isset( $_POST['restwell_business_geo_lat'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_business_geo_lat'] ) )
		: '';
	update_option( 'restwell_business_geo_lat', $business_geo_lat );

	$business_geo_lon = isset( $_POST['restwell_business_geo_lon'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_business_geo_lon'] ) )
		: '';
	update_option( 'restwell_business_geo_lon', $business_geo_lon );

	$gsc = isset( $_POST['restwell_gsc_verification'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_gsc_verification'] ) )
		: '';
	update_option( 'restwell_gsc_verification', $gsc );

	$bing = isset( $_POST['restwell_bing_verification'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_bing_verification'] ) )
		: '';
	update_option( 'restwell_bing_verification', preg_replace( '/[^0-9A-Za-z]/', '', $bing ) );

	$bing_api_key   = '';
	$bing_api_clear = isset( $_POST['restwell_bing_webmaster_api_key_clear'] )
		&& '1' === sanitize_text_field( wp_unslash( $_POST['restwell_bing_webmaster_api_key_clear'] ) );
	if ( isset( $_POST['restwell_bing_webmaster_api_key'] ) ) {
		$bing_api_posted = sanitize_text_field( wp_unslash( $_POST['restwell_bing_webmaster_api_key'] ) );
		if ( function_exists( 'restwell_bing_webmaster_sanitize_api_key' ) ) {
			$bing_api_key = restwell_bing_webmaster_sanitize_api_key( $bing_api_posted );
		} else {
			$bing_api_key = preg_replace( '/[^0-9A-Za-z]/', '', $bing_api_posted );
		}
	}
	$bing_from_constant = defined( 'RESTWELL_BING_WEBMASTER_API_KEY' ) && '' !== (string) RESTWELL_BING_WEBMASTER_API_KEY;
	$bing_prod_locked   = function_exists( 'restwell_is_production_environment' ) && restwell_is_production_environment();
	$bing_key_blocked   = false;
	if ( $bing_from_constant || $bing_prod_locked ) {
		if ( '' !== $bing_api_key || $bing_api_clear ) {
			$bing_key_blocked = $bing_prod_locked && ! $bing_from_constant;
		}
	} elseif ( '' !== $bing_api_key ) {
		update_option( 'restwell_bing_webmaster_api_key', $bing_api_key, false );
	} elseif ( $bing_api_clear ) {
		update_option( 'restwell_bing_webmaster_api_key', '', false );
	}

	if ( function_exists( 'restwell_bing_webmaster_refresh_status' ) ) {
		$should_ping = function_exists( 'restwell_bing_webmaster_is_configured' ) && restwell_bing_webmaster_is_configured();
		if ( $should_ping || $bing_api_clear ) {
			restwell_bing_webmaster_refresh_status( $should_ping );
		}
	}

	$ga4 = isset( $_POST['restwell_ga4_measurement_id'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_ga4_measurement_id'] ) )
		: '';
	$ga4 = preg_replace( '/\s+/', '', $ga4 );
	update_option( 'restwell_ga4_measurement_id', $ga4 );

	$metricool_hash = isset( $_POST['restwell_metricool_hash'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_metricool_hash'] ) )
		: '';
	$metricool_hash = strtolower( preg_replace( '/[^0-9A-Za-z]/', '', $metricool_hash ) );
	update_option( 'restwell_metricool_hash', $metricool_hash );

	$analytics_mode = isset( $_POST['restwell_analytics_load_mode'] )
		? sanitize_key( wp_unslash( $_POST['restwell_analytics_load_mode'] ) )
		: 'consent_gated';
	if ( ! in_array( $analytics_mode, array( 'head', 'footer_deferred', 'consent_gated' ), true ) ) {
		$analytics_mode = 'consent_gated';
	}
	update_option( 'restwell_analytics_load_mode', $analytics_mode );

	// Website copy (not Google schema) — kept here so CRM save cannot touch it.
	$property_address = isset( $_POST['restwell_property_address'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_property_address'] ) )
		: '';
	update_option( 'restwell_property_address', $property_address );

	$property_postcode = isset( $_POST['restwell_property_postcode'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_property_postcode'] ) )
		: '';
	update_option( 'restwell_property_postcode', $property_postcode );

	$footer_heading = isset( $_POST['restwell_footer_cta_heading'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_footer_cta_heading'] ) )
		: '';
	update_option( 'restwell_footer_cta_heading', $footer_heading );

	$footer_intro = isset( $_POST['restwell_footer_cta_intro'] )
		? sanitize_textarea_field( wp_unslash( $_POST['restwell_footer_cta_intro'] ) )
		: '';
	update_option( 'restwell_footer_cta_intro', $footer_intro );

	$footer_primary_label = isset( $_POST['restwell_footer_cta_primary_label'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_footer_cta_primary_label'] ) )
		: '';
	update_option( 'restwell_footer_cta_primary_label', $footer_primary_label );

	$footer_primary_url = isset( $_POST['restwell_footer_cta_primary_url'] )
		? esc_url_raw( wp_unslash( $_POST['restwell_footer_cta_primary_url'] ) )
		: '';
	update_option( 'restwell_footer_cta_primary_url', $footer_primary_url );

	$footer_btn = isset( $_POST['restwell_footer_cta_btn'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_footer_cta_btn'] ) )
		: '';
	update_option( 'restwell_footer_cta_btn', $footer_btn );

	$footer_note = isset( $_POST['restwell_footer_cta_note'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_footer_cta_note'] ) )
		: '';
	update_option( 'restwell_footer_cta_note', $footer_note );

	$access_pdf = isset( $_POST['restwell_access_statement_url'] )
		? esc_url_raw( wp_unslash( $_POST['restwell_access_statement_url'] ) )
		: '';
	update_option( 'restwell_access_statement_url', $access_pdf );

	$redirect_args = array(
		'page'    => 'restwell-seo-sitewide',
		'updated' => '1',
	);
	if ( ! empty( $bing_key_blocked ) ) {
		$redirect_args['bing_key_blocked'] = '1';
	}
	wp_safe_redirect(
		add_query_arg(
			$redirect_args,
			admin_url( 'admin.php' )
		)
	);
	exit;
}
add_action( 'admin_post_restwell_save_seo_sitewide', 'restwell_seo_sitewide_handle_save' );

/**
 * Whether a field id should be highlighted from checklist issues.
 *
 * @param string                           $field_id Field HTML id.
 * @param array<int, array{field?:string}> $issues   Issues.
 * @return bool
 */
function restwell_seo_sitewide_field_has_issue( string $field_id, array $issues ): bool {
	foreach ( $issues as $issue ) {
		if ( isset( $issue['field'] ) && $issue['field'] === $field_id ) {
			return true;
		}
	}
	return false;
}

/**
 * Open a site-wide field row.
 *
 * @param string $field_id Field id (for flagging + jump links).
 * @param string $label    Label text.
 * @param array  $issues   Checklist issues.
 * @param string $for_id   Optional label for= id (defaults to field_id).
 */
function restwell_seo_sitewide_field_open( string $field_id, string $label, array $issues, string $for_id = '' ): void {
	$for_id = $for_id !== '' ? $for_id : $field_id;
	$class  = 'rw-seo-field';
	if ( restwell_seo_sitewide_field_has_issue( $field_id, $issues ) ) {
		$class .= ' rw-seo-field--flagged';
	}
	printf( '<div class="%s">', esc_attr( $class ) );
	printf(
		'<label class="rw-seo-field__label" for="%s">%s</label>',
		esc_attr( $for_id ),
		esc_html( $label )
	);
	echo '<div class="rw-seo-field__control">';
}

/**
 * Close a site-wide field row.
 */
function restwell_seo_sitewide_field_close(): void {
	echo '</div></div>';
}
