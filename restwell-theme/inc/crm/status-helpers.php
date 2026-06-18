<?php
/**
 * CRM: lead status labels, badges, and SLA helpers.
 *
 * @package Restwell_CRM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ─────────────────────────────────────────────────────────────────────────────
// 4. STATUS HELPERS
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Return the defined lead statuses with label and badge colour.
 *
 * @return array<string, array{label: string, color: string}>
 */
function restwell_crm_statuses(): array {
	return array(
		'new'       => array( 'label' => 'New',        'color' => '#2271b1' ),
		'contacted' => array( 'label' => 'Contacted',  'color' => '#996800' ),
		'qualified' => array( 'label' => 'Qualified',  'color' => '#6f41c1' ),
		'booked'    => array( 'label' => 'Booked',     'color' => '#007a3d' ),
		'closed'    => array( 'label' => 'Closed',     'color' => '#787c82' ),
	);
}

/**
 * Render a coloured status badge.
 *
 * @param string $status Status slug.
 * @return string HTML span.
 */
function restwell_crm_status_badge( string $status ): string {
	$statuses = restwell_crm_statuses();
	$label    = $statuses[ $status ]['label'] ?? ucfirst( $status );
	$color    = $statuses[ $status ]['color'] ?? '#787c82';

	return sprintf(
		'<span class="rw-status-pill" style="background:%1$s;">%2$s</span>',
		esc_attr( $color ),
		esc_html( $label )
	);
}

/**
 * Return SLA badge HTML for stale "new" leads.
 *
 * @param object $row Enquiry row.
 * @return string
 */
function restwell_crm_sla_badge( object $row ): string {
	if ( 'new' !== (string) $row->status || empty( $row->submitted_at ) ) {
		return '';
	}

	$submitted_ts = strtotime( (string) $row->submitted_at );
	if ( ! $submitted_ts ) {
		return '';
	}

	$age_hours = floor( ( current_time( 'timestamp' ) - $submitted_ts ) / HOUR_IN_SECONDS );
	if ( $age_hours < 2 ) {
		return '';
	}

	$is_critical = $age_hours >= 18;
	$label       = $is_critical ? __( 'New >18h', 'restwell-retreats' ) : __( 'New >2h', 'restwell-retreats' );

	$class = $is_critical ? 'rw-sla-pill rw-sla-pill--critical' : 'rw-sla-pill rw-sla-pill--warn';

	return sprintf(
		'<span class="%1$s">%2$s</span>',
		esc_attr( $class ),
		esc_html( $label )
	);
}

