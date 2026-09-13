<?php
/**
 * CRM enquiries admin: POST handlers and list/detail router.
 *
 * @package Restwell_CRM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/enquiries-list.php';
require_once __DIR__ . '/enquiry-detail.php';

// ─────────────────────────────────────────────────────────────────────────────
// 8. ENQUIRIES LIST PAGE
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Handle the status/notes/follow-up POST from the enquiry detail view.
 *
 * Redirects and exits on a handled submission; returns (falls through)
 * if the request isn't a matching, nonce-verified POST.
 *
 * @param string $table Enquiries table name (with prefix).
 */
function restwell_crm_handle_enquiry_detail_post( string $table ) {
	global $wpdb;

	if (
		! isset( $_POST['rw_crm_nonce'], $_POST['rw_enquiry_id'], $_POST['rw_status'] )
		|| ! wp_verify_nonce( sanitize_key( $_POST['rw_crm_nonce'] ), 'restwell_crm_action' )
	) {
		return;
	}

	$id         = absint( $_POST['rw_enquiry_id'] );
	$new_status = sanitize_key( $_POST['rw_status'] );
	$notes      = isset( $_POST['rw_notes'] ) ? sanitize_textarea_field( wp_unslash( $_POST['rw_notes'] ) ) : '';

	// Parse follow-up date from datetime-local format (YYYY-MM-DDTHH:MM).
	// Reject anything unparseable rather than writing a malformed DATETIME.
	$follow_up_raw = isset( $_POST['rw_follow_up'] ) ? sanitize_text_field( wp_unslash( $_POST['rw_follow_up'] ) ) : '';
	$follow_up_at  = null;
	if ( '' !== $follow_up_raw ) {
		$parsed = DateTime::createFromFormat( 'Y-m-d\TH:i', $follow_up_raw );
		$valid  = $parsed && $parsed->format( 'Y-m-d\TH:i' ) === $follow_up_raw;
		if ( $valid ) {
			$follow_up_at = $parsed->format( 'Y-m-d H:i:s' );
		}
	}

	if ( array_key_exists( $new_status, restwell_crm_statuses() ) ) {
		// Status transition (timestamps, status-change note, booking email) is
		// handled entirely by the unified function.
		restwell_crm_ops_apply_status_change( $id, $new_status, 'detail' );

		// Detail-view-only fields: notes, follow-up date.
		$wpdb->update(
			$table,
			array(
				'staff_notes'  => $notes,
				'follow_up_at' => $follow_up_at,
			),
			array( 'id' => $id ),
			array( '%s', '%s' ),
			array( '%d' )
		);
	}

	wp_safe_redirect(
		add_query_arg(
			array(
				'page'    => 'restwell-enquiries',
				'view'    => $id,
				'updated' => '1',
			),
			admin_url( 'admin.php' )
		)
	);
	exit;
}

/**
 * Handle the bulk status-update POST from the enquiries list view.
 *
 * Redirects and exits on a handled submission; returns (falls through)
 * if the request isn't a matching, nonce-verified POST.
 */
function restwell_crm_handle_bulk_status_post() {
	if (
		! isset( $_POST['rw_bulk_nonce'], $_POST['rw_bulk_action'], $_POST['rw_bulk_ids'] )
		|| ! wp_verify_nonce( sanitize_key( $_POST['rw_bulk_nonce'] ), 'restwell_crm_bulk' )
	) {
		return;
	}

	$bulk_action = sanitize_key( $_POST['rw_bulk_action'] );
	$ids         = array_filter( array_map( 'absint', (array) $_POST['rw_bulk_ids'] ) );

	if ( array_key_exists( $bulk_action, restwell_crm_statuses() ) && $ids ) {
		foreach ( $ids as $id ) {
			// Booking confirmation email is suppressed in bulk context (context = 'bulk').
			restwell_crm_ops_apply_status_change( $id, $bulk_action, 'bulk' );
		}
	}

	wp_safe_redirect(
		add_query_arg(
			array(
				'page'    => 'restwell-enquiries',
				'updated' => '1',
			),
			admin_url( 'admin.php' )
		)
	);
	exit;
}

/**
 * Render the Enquiries admin page (list and detail views).
 */
function restwell_crm_enquiries_page() {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'You do not have permission to view this page.', 'restwell-retreats' ) );
	}

	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_CRM_TABLE;

	restwell_crm_handle_enquiry_detail_post( $table );
	restwell_crm_handle_bulk_status_post();

	// ── Single enquiry detail view ───────────────────────────────────────────
	if ( isset( $_GET['view'] ) ) {
		restwell_crm_enquiry_detail( absint( wp_unslash( $_GET['view'] ) ) );
		return;
	}

	$list = restwell_crm_get_enquiries_list_data( $table );
	?>
	<div class="wrap restwell-admin restwell-admin-enquiries">
		<h1 class="rw-page-title"><?php esc_html_e( 'Enquiries', 'restwell-retreats' ); ?></h1>

		<?php if ( isset( $_GET['updated'] ) ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Changes saved.', 'restwell-retreats' ); ?></p></div>
		<?php endif; ?>
		<?php
		$dsr_error = isset( $_GET['dsr_error'] ) ? sanitize_key( wp_unslash( $_GET['dsr_error'] ) ) : '';
		if ( 'email' === $dsr_error ) :
			?>
			<div class="notice notice-error is-dismissible"><p><?php esc_html_e( 'Enter a valid email address to export.', 'restwell-retreats' ); ?></p></div>
		<?php endif; ?>

		<?php restwell_crm_render_enquiries_panel( $list ); ?>
		<?php restwell_crm_render_enquiries_export_tools(); ?>
	</div>
	<?php
}

/**
 * CSV and subject-access export, kept off the main list.
 */
function restwell_crm_render_enquiries_export_tools(): void {
	?>
	<details class="rw-enquiries-tools">
		<summary><?php esc_html_e( 'Export', 'restwell-retreats' ); ?></summary>
		<div class="rw-enquiries-tools__body">
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="rw-export-form">
				<?php wp_nonce_field( 'restwell_crm_export_csv' ); ?>
				<input type="hidden" name="action" value="restwell_crm_export_csv" />
				<p class="rw-enquiries-tools__label"><?php esc_html_e( 'All enquiries (CSV)', 'restwell-retreats' ); ?></p>
				<div class="rw-enquiries-tools__grid">
					<label class="rw-export-date">
						<span class="rw-enquiries-tools__field-label"><?php esc_html_e( 'From', 'restwell-retreats' ); ?></span>
						<input type="date" name="submitted_from" />
					</label>
					<label class="rw-export-date">
						<span class="rw-enquiries-tools__field-label"><?php esc_html_e( 'To', 'restwell-retreats' ); ?></span>
						<input type="date" name="submitted_to" />
					</label>
					<?php if ( restwell_crm_can_export_sensitive() ) : ?>
						<label class="rw-export-sensitive">
							<input type="checkbox" name="include_sensitive" value="1" />
							<?php esc_html_e( 'Include care notes', 'restwell-retreats' ); ?>
						</label>
					<?php endif; ?>
					<button type="submit" class="button button-primary rw-enquiries-tools__submit">
						<?php esc_html_e( 'Download CSV', 'restwell-retreats' ); ?>
					</button>
				</div>
				<p class="description rw-enquiries-tools__hint"><?php esc_html_e( 'Leave dates blank for everything.', 'restwell-retreats' ); ?></p>
			</form>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="rw-dsr-form">
				<?php wp_nonce_field( 'restwell_crm_dsr' ); ?>
				<input type="hidden" name="action" value="restwell_crm_dsr_export" />
				<p class="rw-enquiries-tools__label"><?php esc_html_e( 'One email (subject access)', 'restwell-retreats' ); ?></p>
				<div class="rw-enquiries-tools__grid rw-enquiries-tools__grid--dsr">
					<label class="rw-dsr-email-field" for="rw-dsr-email">
						<span class="rw-enquiries-tools__field-label"><?php esc_html_e( 'Email', 'restwell-retreats' ); ?></span>
						<input id="rw-dsr-email" type="email" name="dsr_email" required autocomplete="off" />
					</label>
					<button type="submit" class="button button-primary rw-enquiries-tools__submit">
						<?php esc_html_e( 'Export', 'restwell-retreats' ); ?>
					</button>
				</div>
			</form>
		</div>
	</details>
	<?php
}
