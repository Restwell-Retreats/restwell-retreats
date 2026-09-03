<?php
/**
 * CRM: dashboard admin screen orchestrator.
 *
 * Panels and settings markup live in dashboard-panels.php and dashboard-settings.php.
 *
 * @package Restwell_CRM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/dashboard-panels.php';
require_once __DIR__ . '/dashboard-settings.php';

/**
 * Render the Restwell CRM dashboard.
 */
function restwell_crm_dashboard_page() {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'You do not have permission to access this page.', 'restwell-retreats' ), '', array( 'response' => 403 ) );
	}

	global $wpdb;
	$enq_table    = $wpdb->prefix . RESTWELL_CRM_TABLE;
	$guests_table = $wpdb->prefix . RESTWELL_GUESTS_TABLE;
	$now_mysql    = current_time( 'mysql' );
	$week_ago     = wp_date( 'Y-m-d H:i:s', time() - WEEK_IN_SECONDS );
	if ( ! is_string( $week_ago ) || $week_ago === '' ) {
		$week_ago = $now_mysql;
	}

	$stat_new_week   = (int) $wpdb->get_var( $wpdb->prepare( 'SELECT COUNT(*) FROM %i WHERE submitted_at >= %s', $enq_table, $week_ago ) );
	$stat_total      = (int) $wpdb->get_var( $wpdb->prepare( 'SELECT COUNT(*) FROM %i', $enq_table ) );
	$stat_urgent     = (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM %i WHERE is_urgent = 1 AND status = 'new'", $enq_table ) );
	$stat_follow_ups = (int) $wpdb->get_var(
		$wpdb->prepare( "SELECT COUNT(*) FROM %i WHERE follow_up_at IS NOT NULL AND follow_up_at <= %s AND status != 'closed'", $enq_table, $now_mysql )
	);

	$follow_up_rows = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT id, name, email, status, follow_up_at FROM %i
			 WHERE follow_up_at IS NOT NULL AND follow_up_at <= %s AND status != 'closed'
			 ORDER BY follow_up_at ASC LIMIT 20",
			$enq_table,
			$now_mysql
		)
	);

	// NOTE: LOWER() on both sides prevents index use on email columns; revisit with a normalised
	// stored column (e.g. email_lower GENERATED ALWAYS AS (LOWER(email)) STORED + index) if this
	// query appears in the MySQL slow log.
	$booked_without_guide = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT e.id, e.name, e.email, e.preferred_dates, e.booked_at
			 FROM %i e
			 LEFT JOIN %i g ON LOWER(g.email) = LOWER(e.email)
			 WHERE e.status = 'booked' AND g.id IS NULL
			 ORDER BY e.booked_at ASC",
			$enq_table,
			$guests_table
		)
	);
	$enquiries_url = admin_url( 'admin.php?page=restwell-enquiries' );
	?>
	<div class="wrap restwell-admin restwell-admin-dashboard">
		<h1 class="rw-page-title"><?php esc_html_e( 'Restwell Dashboard', 'restwell-retreats' ); ?></h1>
		<?php
		restwell_crm_dashboard_render_notices();
		restwell_crm_dashboard_render_stat_tiles( $stat_new_week, $stat_total, $stat_urgent, $stat_follow_ups, $week_ago, $enquiries_url );
		restwell_crm_dashboard_render_quicklinks( $enquiries_url );
		?>
		<div class="rw-dashboard-grid">
			<?php
			restwell_crm_dashboard_render_follow_ups( $follow_up_rows, $enquiries_url );
			restwell_crm_dashboard_render_booked_without_guide( $booked_without_guide );
			?>
		</div>
		<?php
		restwell_crm_dashboard_render_orientation();
		restwell_crm_dashboard_render_settings();
		restwell_crm_dashboard_render_export_log();
		?>
	</div>
	<?php
}
