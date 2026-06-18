<?php
/**
 * CRM: capability constants, role mapping, and access checks.
 *
 * @package Restwell_CRM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'RESTWELL_CRM_DB_VERSION', '3.5' );
define( 'RESTWELL_CRM_TABLE',    'rw_enquiries' );
define( 'RESTWELL_NOTES_TABLE',  'rw_enquiry_notes' );
define( 'RESTWELL_GUESTS_TABLE', 'rw_guests' );
define( 'RESTWELL_FAQ_TABLE',    'rw_faq_submissions' );
define( 'RESTWELL_CRM_CAP',      'restwell_manage_enquiries' );

/**
 * Return the CRM capability key.
 *
 * @return string
 */
function restwell_crm_capability(): string {
	return RESTWELL_CRM_CAP;
}

/**
 * Check current-user CRM access.
 *
 * @return bool
 */
function restwell_crm_can_manage(): bool {
	return current_user_can( restwell_crm_capability() );
}

/**
 * Roles granted CRM access.
 *
 * @return array<int, string>
 */
function restwell_crm_get_cap_roles(): array {
	$roles = get_option( 'restwell_crm_cap_roles', array( 'administrator', 'editor' ) );
	if ( ! is_array( $roles ) ) {
		return array( 'administrator', 'editor' );
	}
	return array_values( array_filter( array_map( 'sanitize_key', $roles ) ) );
}

/**
 * Re-apply CRM capability mapping on init.
 */
function restwell_crm_apply_role_caps(): void {
	$wp_roles = wp_roles();
	if ( ! $wp_roles ) {
		return;
	}

	$allowed_roles = array_flip( restwell_crm_get_cap_roles() );
	foreach ( $wp_roles->roles as $role_slug => $_role_data ) {
		$role = get_role( $role_slug );
		if ( ! $role ) {
			continue;
		}
		if ( isset( $allowed_roles[ $role_slug ] ) ) {
			$role->add_cap( restwell_crm_capability() );
		} else {
			$role->remove_cap( restwell_crm_capability() );
		}
	}
}
add_action( 'init', 'restwell_crm_apply_role_caps', 20 );

