<?php
/**
 * CRM: enquiries list and detail admin screens.
 *
 * @package Restwell_CRM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ─────────────────────────────────────────────────────────────────────────────
// 8. ENQUIRIES LIST PAGE
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Render the Enquiries admin page (list and detail views).
 */
function restwell_crm_enquiries_page() {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'You do not have permission to access this page.', 'restwell-retreats' ), '', array( 'response' => 403 ) );
	}

	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_CRM_TABLE;

	// ── Handle status + notes update from detail view ────────────────────────
	if (
		isset( $_POST['rw_crm_nonce'], $_POST['rw_enquiry_id'], $_POST['rw_status'] )
		&& wp_verify_nonce( sanitize_key( $_POST['rw_crm_nonce'] ), 'restwell_crm_action' )
	) {
		$id         = absint( $_POST['rw_enquiry_id'] );
		$new_status = sanitize_key( $_POST['rw_status'] );
		$notes      = isset( $_POST['rw_notes'] ) ? sanitize_textarea_field( wp_unslash( $_POST['rw_notes'] ) ) : '';

		// Parse follow-up date from datetime-local format (YYYY-MM-DDTHH:MM).
		$follow_up_raw = isset( $_POST['rw_follow_up'] ) ? sanitize_text_field( wp_unslash( $_POST['rw_follow_up'] ) ) : '';
		$follow_up_at  = $follow_up_raw ? str_replace( 'T', ' ', $follow_up_raw ) . ':00' : null;

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
			add_query_arg( array( 'page' => 'restwell-enquiries', 'view' => $id, 'updated' => '1' ), admin_url( 'admin.php' ) )
		);
		exit;
	}

	// ── Handle bulk status update ────────────────────────────────────────────
	if (
		isset( $_POST['rw_bulk_nonce'], $_POST['rw_bulk_action'], $_POST['rw_bulk_ids'] )
		&& wp_verify_nonce( sanitize_key( $_POST['rw_bulk_nonce'] ), 'restwell_crm_bulk' )
	) {
		$bulk_action = sanitize_key( $_POST['rw_bulk_action'] );
		$ids         = array_filter( array_map( 'absint', (array) $_POST['rw_bulk_ids'] ) );

		if ( array_key_exists( $bulk_action, restwell_crm_statuses() ) && $ids ) {
			foreach ( $ids as $id ) {
				// Booking confirmation email is suppressed in bulk context (context = 'bulk').
				restwell_crm_ops_apply_status_change( $id, $bulk_action, 'bulk' );
			}
		}

		wp_safe_redirect( add_query_arg( array( 'page' => 'restwell-enquiries', 'updated' => '1' ), admin_url( 'admin.php' ) ) );
		exit;
	}

	// ── Single enquiry detail view ───────────────────────────────────────────
	if ( isset( $_GET['view'] ) ) {
		restwell_crm_enquiry_detail( absint( $_GET['view'] ) );
		return;
	}

	// ── Build WHERE clause safely ────────────────────────────────────────────
	// SAFETY: only append fragments returned by $wpdb->prepare() — never raw $_GET strings.
	$status_filter      = isset( $_GET['status_filter'] ) ? sanitize_key( $_GET['status_filter'] ) : '';
	$search             = isset( $_GET['s'] ) ? sanitize_text_field( wp_unslash( $_GET['s'] ) ) : '';
	$urgent_filter      = isset( $_GET['urgent_filter'] ) ? absint( $_GET['urgent_filter'] ) : 0;
	$follow_up_filter   = isset( $_GET['follow_up_filter'] ) ? sanitize_key( $_GET['follow_up_filter'] ) : '';
	$submitted_since_raw = isset( $_GET['submitted_since'] ) ? sanitize_text_field( wp_unslash( $_GET['submitted_since'] ) ) : '';
	$per_page           = 25;
	$current_page       = max( 1, isset( $_GET['paged'] ) ? absint( $_GET['paged'] ) : 1 );
	$offset             = ( $current_page - 1 ) * $per_page;

	// Sortable columns.
	$allowed_orderby = array( 'submitted_at', 'status', 'name' );
	$orderby_raw     = isset( $_GET['orderby'] ) ? sanitize_key( $_GET['orderby'] ) : 'submitted_at';
	$orderby         = in_array( $orderby_raw, $allowed_orderby, true ) ? $orderby_raw : 'submitted_at';
	$order_raw       = isset( $_GET['order'] ) ? strtoupper( sanitize_key( $_GET['order'] ) ) : 'DESC';
	$order           = ( 'ASC' === $order_raw ) ? 'ASC' : 'DESC';

	$where_parts = array( '1=1' );

	if ( $status_filter && array_key_exists( $status_filter, restwell_crm_statuses() ) ) {
		$where_parts[] = $wpdb->prepare( 'status = %s', $status_filter );
	}
	if ( $search ) {
		$like          = '%' . $wpdb->esc_like( $search ) . '%';
		$where_parts[] = $wpdb->prepare( '(name LIKE %s OR email LIKE %s OR phone LIKE %s)', $like, $like, $like );
	}
	if ( $urgent_filter ) {
		$where_parts[] = 'is_urgent = 1';
	}
	if ( 'overdue' === $follow_up_filter ) {
		$where_parts[] = $wpdb->prepare(
			'follow_up_at IS NOT NULL AND follow_up_at <= %s AND status != %s',
			current_time( 'mysql' ),
			'closed'
		);
	}
	if ( $submitted_since_raw ) {
		$submitted_since_ts = strtotime( $submitted_since_raw );
		if ( $submitted_since_ts ) {
			$where_parts[] = $wpdb->prepare( 'submitted_at >= %s', gmdate( 'Y-m-d H:i:s', $submitted_since_ts ) );
		}
	}

	$where = implode( ' AND ', $where_parts );

	// phpcs:disable WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	$total = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$table} WHERE {$where}" );
	$rows  = $wpdb->get_results(
		$wpdb->prepare( "SELECT * FROM {$table} WHERE {$where} ORDER BY {$orderby} {$order} LIMIT %d OFFSET %d", $per_page, $offset )
	);
	// phpcs:enable

	$total_pages = (int) ceil( $total / $per_page );
	$statuses    = restwell_crm_statuses();
	$base_url    = admin_url( 'admin.php?page=restwell-enquiries' );
	$now_mysql   = current_time( 'mysql' );

	// Status counts for tabs.
	$counts = array();
	foreach ( array_keys( $statuses ) as $s ) {
		// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		$counts[ $s ] = (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$table} WHERE status = %s", $s ) );
	}
	// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	$counts['all'] = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$table}" );

	?>
	<div class="wrap restwell-admin restwell-admin-enquiries">
		<div class="rw-page-toolbar">
			<h1 class="wp-heading-inline"><?php esc_html_e( 'Enquiries', 'restwell-retreats' ); ?></h1>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="rw-export-form">
				<?php wp_nonce_field( 'restwell_crm_export_csv' ); ?>
				<input type="hidden" name="action" value="restwell_crm_export_csv" />
				<button type="submit" class="page-title-action">
					&#8659; <?php esc_html_e( 'Export CSV', 'restwell-retreats' ); ?>
				</button>
			</form>
		</div>

		<?php if ( isset( $_GET['updated'] ) ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Changes saved.', 'restwell-retreats' ); ?></p></div>
		<?php endif; ?>

		<div class="rw-enquiries-panel">
		<div class="rw-enquiries-controls">
			<div class="rw-enquiries-controls__primary">
			<!-- Status filter tabs -->
			<div class="rw-filter-group">
				<span class="rw-filter-group__label" id="rw-enquiries-status-label"><?php esc_html_e( 'Status', 'restwell-retreats' ); ?></span>
				<ul class="subsubsub rw-subsubsub--status rw-filter-pills" role="list" aria-labelledby="rw-enquiries-status-label">
					<li>
						<a href="<?php echo esc_url( $base_url ); ?>" <?php if ( ! $status_filter ) echo 'class="current"'; ?>>
							<?php esc_html_e( 'All', 'restwell-retreats' ); ?> <span class="count">(<?php echo esc_html( $counts['all'] ); ?>)</span>
						</a>
					</li>
					<?php foreach ( $statuses as $slug => $info ) : ?>
						<li>
							<a href="<?php echo esc_url( add_query_arg( 'status_filter', $slug, $base_url ) ); ?>"
							   <?php if ( $status_filter === $slug ) echo 'class="current"'; ?>>
								<?php echo esc_html( $info['label'] ); ?> <span class="count">(<?php echo esc_html( $counts[ $slug ] ); ?>)</span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
			</div><!-- .rw-enquiries-controls__primary -->

			<!-- Search (sibling of __primary: second column of .rw-enquiries-controls grid) -->
			<div class="rw-enquiries-search">
				<span class="rw-filter-group__label" id="rw-enquiries-search-label"><?php esc_html_e( 'Search', 'restwell-retreats' ); ?></span>
				<form method="get" action="<?php echo esc_url( admin_url( 'admin.php' ) ); ?>" aria-labelledby="rw-enquiries-search-label">
					<input type="hidden" name="page" value="restwell-enquiries">
					<?php if ( $status_filter ) : ?>
						<input type="hidden" name="status_filter" value="<?php echo esc_attr( $status_filter ); ?>">
					<?php endif; ?>
					<p class="search-box">
						<label class="screen-reader-text" for="rw-crm-search"><?php esc_html_e( 'Search enquiries', 'restwell-retreats' ); ?></label>
						<input type="search" id="rw-crm-search" name="s"
							   value="<?php echo esc_attr( $search ); ?>"
							   placeholder="<?php esc_attr_e( 'Name, email or phone…', 'restwell-retreats' ); ?>">
						<input type="submit" class="button" value="<?php esc_attr_e( 'Search', 'restwell-retreats' ); ?>">
						<?php if ( $search ) : ?>
							<a class="button" href="<?php echo esc_url( $base_url ); ?>"><?php esc_html_e( 'Clear', 'restwell-retreats' ); ?></a>
						<?php endif; ?>
					</p>
				</form>
			</div>
		</div><!-- .rw-enquiries-controls -->

		<?php if ( empty( $rows ) ) : ?>
			<div class="rw-enquiries-empty">
				<div class="rw-enquiries-empty__inner">
					<div class="rw-enquiries-empty__figure" aria-hidden="true">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80" fill="none" focusable="false">
							<circle cx="40" cy="40" r="38" stroke="currentColor" stroke-width="1.5" opacity="0.2"/>
							<path d="M24 32h32a4 4 0 014 4v16a4 4 0 01-4 4H24a4 4 0 01-4-4V36a4 4 0 014-4z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
							<path d="M22 36l18 12 18-12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</div>
					<p class="rw-enquiries-empty__title"><?php esc_html_e( 'No enquiries yet', 'restwell-retreats' ); ?></p>
					<p class="rw-enquiries-empty__text"><?php esc_html_e( 'When visitors submit the enquiry form on your site, they will show up here. You can filter by status and search by name or contact details.', 'restwell-retreats' ); ?></p>
				</div>
			</div>
		<?php else : ?>

		<!-- Bulk action + list -->
		<form method="post" action="">
			<?php wp_nonce_field( 'restwell_crm_bulk', 'rw_bulk_nonce' ); ?>

			<div class="rw-table-shell rw-table-shell--enquiries">
			<div class="tablenav top">
				<div class="alignleft actions bulkactions">
					<label for="rw-bulk-action" class="screen-reader-text"><?php esc_html_e( 'Select bulk action', 'restwell-retreats' ); ?></label>
					<select name="rw_bulk_action" id="rw-bulk-action">
						<option value=""><?php esc_html_e( '- Bulk action -', 'restwell-retreats' ); ?></option>
						<?php foreach ( $statuses as $slug => $info ) : ?>
							<option value="<?php echo esc_attr( $slug ); ?>">
								<?php
								/* translators: %s: status label */
								printf( esc_html__( 'Mark as %s', 'restwell-retreats' ), esc_html( $info['label'] ) );
								?>
							</option>
						<?php endforeach; ?>
					</select>
					<input type="submit" class="button action" value="<?php esc_attr_e( 'Apply', 'restwell-retreats' ); ?>">
				</div>

				<?php if ( $total_pages > 1 ) : ?>
					<div class="tablenav-pages">
						<span class="displaying-num">
							<?php
							/* translators: %d: number of items */
							printf( esc_html__( '%d items', 'restwell-retreats' ), esc_html( $total ) );
							?>
						</span>
						<?php for ( $p = 1; $p <= $total_pages; $p++ ) : ?>
							<a class="button<?php echo $p === $current_page ? ' button-primary' : ''; ?>"
							   href="<?php echo esc_url( add_query_arg( array( 'paged' => $p, 'status_filter' => $status_filter, 's' => $search ), $base_url ) ); ?>">
								<?php echo esc_html( $p ); ?>
							</a>
						<?php endfor; ?>
					</div>
				<?php endif; ?>
			</div>

			<table class="wp-list-table widefat striped rw-enquiries-table">
			<?php
			/**
			 * Build a sortable column header link.
			 *
			 * @param string $col     Column key (must be in $allowed_orderby).
			 * @param string $label   Display label.
			 * @param string $current Current $orderby value.
			 * @param string $current_order Current $order value.
			 * @param string $base    Base URL.
			 * @param array  $extras  Extra query args to preserve.
			 * @return string HTML.
			 */
			$sort_link = function( string $col, string $label, string $current, string $current_order, string $base, array $extras ): string {
				$is_active  = ( $col === $current );
				$next_order = $is_active && 'ASC' === $current_order ? 'DESC' : 'ASC';
				$arrow      = '';
				if ( $is_active ) {
					$arrow = 'ASC' === $current_order
						? ' <span aria-hidden="true">&#9650;</span>'
						: ' <span aria-hidden="true">&#9660;</span>';
				}
				$href = add_query_arg( array_merge( $extras, array( 'orderby' => $col, 'order' => $next_order ) ), $base );
				return sprintf(
					'<a href="%s" class="%s">%s%s</a>',
					esc_url( $href ),
					$is_active ? 'rw-sort-link rw-sort-link--active' : 'rw-sort-link',
					esc_html( $label ),
					$arrow
				);
			};
			$sort_extras = array_filter( array(
				'page'          => 'restwell-enquiries',
				'status_filter' => $status_filter,
				's'             => $search,
			) );
			?>
			<thead>
				<tr>
					<td class="manage-column check-column">
						<input id="cb-select-all" type="checkbox">
					</td>
					<th scope="col" class="column-rw-flag"><span class="screen-reader-text"><?php esc_html_e( 'Flags', 'restwell-retreats' ); ?></span></th>
					<th scope="col" class="column-rw-name sortable <?php echo 'name' === $orderby ? 'sorted' : ''; ?>">
						<?php echo $sort_link( 'name', __( 'Name', 'restwell-retreats' ), $orderby, $order, admin_url( 'admin.php' ), $sort_extras ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
					</th>
					<th scope="col" class="column-rw-contact"><?php esc_html_e( 'Contact', 'restwell-retreats' ); ?></th>
					<th scope="col" class="column-rw-marketing"><?php esc_html_e( 'Marketing', 'restwell-retreats' ); ?></th>
					<th scope="col" class="column-rw-dates"><?php esc_html_e( 'Dates / Guests', 'restwell-retreats' ); ?></th>
					<th scope="col" class="column-rw-status sortable <?php echo 'status' === $orderby ? 'sorted' : ''; ?>">
						<?php echo $sort_link( 'status', __( 'Status', 'restwell-retreats' ), $orderby, $order, admin_url( 'admin.php' ), $sort_extras ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
					</th>
					<th scope="col" class="column-rw-received sortable <?php echo 'submitted_at' === $orderby ? 'sorted' : ''; ?>">
						<?php echo $sort_link( 'submitted_at', __( 'Received', 'restwell-retreats' ), $orderby, $order, admin_url( 'admin.php' ), $sort_extras ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
					</th>
				</tr>
			</thead>
				<tbody>
					<?php foreach ( $rows as $row ) : ?>
						<?php
					$detail_url    = add_query_arg( array( 'page' => 'restwell-enquiries', 'view' => $row->id ), admin_url( 'admin.php' ) );
					$is_overdue    = ! empty( $row->follow_up_at ) && $row->follow_up_at <= $now_mysql && 'closed' !== $row->status;
					$sla_badge     = restwell_crm_sla_badge( $row );
						?>
						<tr<?php echo $row->is_urgent ? ' class="rw-row--urgent"' : ''; ?>>
							<th scope="row" class="check-column">
								<input type="checkbox" name="rw_bulk_ids[]" value="<?php echo esc_attr( $row->id ); ?>">
							</th>
							<td class="column-rw-flag">
								<?php if ( $row->is_urgent ) : ?>
									<span class="rw-badge rw-badge--urgent" title="<?php esc_attr_e( 'Urgent', 'restwell-retreats' ); ?>"><?php esc_html_e( 'Urgent', 'restwell-retreats' ); ?></span>
								<?php elseif ( $is_overdue ) : ?>
									<span class="rw-badge rw-badge--overdue" title="<?php esc_attr_e( 'Follow-up overdue', 'restwell-retreats' ); ?>"><?php esc_html_e( 'Overdue', 'restwell-retreats' ); ?></span>
								<?php endif; ?>
							</td>
							<td class="column-rw-name">
								<strong><a href="<?php echo esc_url( $detail_url ); ?>"><?php echo esc_html( $row->name ); ?></a></strong>
								<?php if ( $sla_badge ) : ?>
									<div class="rw-sla-badge"><?php echo $sla_badge; // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
								<?php endif; ?>
								<?php if ( $row->staff_notes ) : ?>
									<br><span class="rw-staff-note-preview">
										&#128221; <?php echo esc_html( wp_trim_words( $row->staff_notes, 10 ) ); ?>
									</span>
								<?php endif; ?>
							</td>
							<td class="column-rw-contact">
								<a href="mailto:<?php echo esc_attr( $row->email ); ?>"><?php echo esc_html( $row->email ); ?></a>
								<?php if ( $row->phone ) : ?>
									<br>
									<a href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', $row->phone ) ); ?>">
										<?php echo esc_html( $row->phone ); ?>
									</a>
								<?php endif; ?>
							</td>
							<td class="column-rw-marketing rw-text-meta">
								<?php if ( ! empty( $row->marketing_optin ) ) : ?>
									<span class="rw-badge rw-badge--booked"><?php esc_html_e( 'Opted in', 'restwell-retreats' ); ?></span>
									<?php if ( ! empty( $row->marketing_optin_at ) ) : ?>
										<br><span class="rw-text-muted-sm"><?php echo esc_html( date_i18n( 'j M Y', strtotime( $row->marketing_optin_at ) ) ); ?></span>
									<?php endif; ?>
								<?php else : ?>
									<span class="rw-text-dim"><?php esc_html_e( 'No', 'restwell-retreats' ); ?></span>
								<?php endif; ?>
							</td>
							<td class="column-rw-dates">
								<?php if ( $row->preferred_dates ) : ?>
									<span class="rw-text-meta"><?php echo esc_html( $row->preferred_dates ); ?></span>
								<?php endif; ?>
								<?php if ( $row->num_guests ) : ?>
									<br><span class="rw-text-muted-sm"><?php echo esc_html( $row->num_guests ); ?> guests</span>
								<?php endif; ?>
								<?php if ( ! $row->preferred_dates && ! $row->num_guests ) : ?>
									<span class="rw-text-dim">-</span>
								<?php endif; ?>
							</td>
							<td class="column-rw-status">
							<div class="rw-status-badge" data-enquiry-id="<?php echo esc_attr( $row->id ); ?>"><?php echo restwell_crm_status_badge( $row->status ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
								<div class="rw-status-actions">
									<a class="rw-details-link" href="<?php echo esc_url( $detail_url ); ?>">
										<?php esc_html_e( 'Open details', 'restwell-retreats' ); ?>
									</a>
								</div>
							</td>
							<td class="column-rw-received rw-text-meta">
								<?php echo esc_html( date_i18n( 'j M Y', strtotime( $row->submitted_at ) ) ); ?>
								<br><?php echo esc_html( date_i18n( 'H:i', strtotime( $row->submitted_at ) ) ); ?>
								<?php if ( $is_overdue ) : ?>
									<br><span class="rw-follow-up-hint">
										&#9201; <?php echo esc_html( date_i18n( 'j M', strtotime( $row->follow_up_at ) ) ); ?>
									</span>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			</div><!-- .rw-table-shell--enquiries -->
		</form>

		<?php endif; ?>
		</div><!-- .rw-enquiries-panel -->
	</div>

	<script>
	( function() {
		var selectAll = document.getElementById( 'cb-select-all' );
		if ( selectAll ) {
			selectAll.addEventListener( 'change', function() {
				document.querySelectorAll( '[name="rw_bulk_ids[]"]' ).forEach( function( cb ) {
					cb.checked = selectAll.checked;
				} );
			} );
		}
	} )();
	</script>
	<?php
}

// ─────────────────────────────────────────────────────────────────────────────
// 9. ENQUIRY DETAIL / EDIT VIEW
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Render the single-enquiry detail page.
 *
 * @param int $id Enquiry row ID.
 */
function restwell_crm_enquiry_detail( int $id ) {
	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_CRM_TABLE;
	// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	$row = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$table} WHERE id = %d", $id ) );

	if ( ! $row ) {
		echo '<div class="wrap"><div class="notice notice-error"><p>' . esc_html__( 'Enquiry not found.', 'restwell-retreats' ) . '</p></div></div>';
		return;
	}

	$statuses = restwell_crm_statuses();
	$back_url = admin_url( 'admin.php?page=restwell-enquiries' );
	$notes    = restwell_crm_get_notes( $id );

	// Build mailto with subject pre-filled.
	$mailto = 'mailto:' . rawurlencode( $row->email ) . '?subject=' . rawurlencode( 'Re: Your Restwell Retreats Enquiry' );

	// Format follow-up datetime for the datetime-local input (YYYY-MM-DDTHH:MM).
	$follow_up_value = '';
	if ( ! empty( $row->follow_up_at ) ) {
		$follow_up_value = date( 'Y-m-d\TH:i', strtotime( $row->follow_up_at ) );
	}

	// Promote-to-guest URL.
	$promote_url = add_query_arg(
		array(
			'page'               => 'restwell-guest-guide',
			'prefill_name'       => rawurlencode( $row->name ),
			'prefill_email'      => rawurlencode( $row->email ),
			'prefill_enquiry_id' => $row->id,
		),
		admin_url( 'admin.php' )
	);
	?>
	<div class="wrap restwell-admin restwell-admin-enquiry-detail">
		<h1 class="rw-detail-title-row">
			<a href="<?php echo esc_url( $back_url ); ?>" class="rw-back-link">
				&larr; <?php esc_html_e( 'All Enquiries', 'restwell-retreats' ); ?>
			</a>
			<span class="rw-title-sep" aria-hidden="true">|</span>
			<?php if ( $row->is_urgent ) : ?>
				<span class="rw-urgent-flag" title="<?php esc_attr_e( 'Urgent', 'restwell-retreats' ); ?>">&#9873; <?php esc_html_e( 'URGENT', 'restwell-retreats' ); ?>:</span>
			<?php endif; ?>
			<?php echo esc_html( $row->name ); ?>
			<?php echo restwell_crm_status_badge( $row->status ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		</h1>

		<?php if ( isset( $_GET['updated'] ) ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Changes saved.', 'restwell-retreats' ); ?></p></div>
		<?php endif; ?>
		<?php if ( isset( $_GET['note_added'] ) ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Note added.', 'restwell-retreats' ); ?></p></div>
		<?php endif; ?>
		<?php if ( isset( $_GET['stay_dates_updated'] ) ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Stay dates updated. The change has been recorded in the activity log.', 'restwell-retreats' ); ?></p></div>
		<?php endif; ?>
		<?php if ( isset( $_GET['stay_dates_unchanged'] ) ) : ?>
			<div class="notice notice-info is-dismissible"><p><?php esc_html_e( 'Stay dates were already set to those values — nothing to update.', 'restwell-retreats' ); ?></p></div>
		<?php endif; ?>
		<?php if ( isset( $_GET['stay_dates_error'] ) ) : ?>
			<div class="notice notice-error is-dismissible">
				<p>
					<?php
					// Two distinct error reasons get two distinct messages so staff
					// know exactly what to fix without guessing.
					if ( 'order' === $_GET['stay_dates_error'] ) {
						esc_html_e( 'End date must be on or after the start date.', 'restwell-retreats' );
					} else {
						esc_html_e( 'One of the dates was not in a valid format. Please use the date pickers to enter a date.', 'restwell-retreats' );
					}
					?>
				</p>
			</div>
		<?php endif; ?>

		<div class="rw-detail-layout">

			<!-- ── Left: enquiry details ─────────────────────────────────── -->
			<div class="rw-detail-layout__main">
				<div class="postbox">
					<div class="postbox-header">
						<h2 class="hndle"><span><?php esc_html_e( 'Enquiry Details', 'restwell-retreats' ); ?></span></h2>
					</div>
					<div class="inside">

						<?php
						$contact_fields = array(
							__( 'Name', 'restwell-retreats' )              => esc_html( $row->name ),
							__( 'Email', 'restwell-retreats' )             => '<a href="mailto:' . esc_attr( $row->email ) . '">' . esc_html( $row->email ) . '</a>',
							__( 'Phone', 'restwell-retreats' )             => $row->phone
								? '<a href="tel:' . esc_attr( preg_replace( '/[^\d+]/', '', $row->phone ) ) . '">' . esc_html( $row->phone ) . '</a>'
								: '',
							__( 'Preferred contact', 'restwell-retreats' ) => esc_html( $row->contact_preference ),
							__( 'Best time to call', 'restwell-retreats' ) => esc_html( $row->preferred_time ),
							__( 'Marketing preference', 'restwell-retreats' ) => ! empty( $row->marketing_optin )
								? esc_html__( 'Opted in', 'restwell-retreats' )
								: esc_html__( 'Not opted in', 'restwell-retreats' ),
						);
						if ( ! empty( $row->marketing_optin ) && ! empty( $row->marketing_optin_at ) ) {
							$contact_fields[ __( 'Marketing opted in at', 'restwell-retreats' ) ] = esc_html(
								date_i18n( 'j M Y, H:i', strtotime( $row->marketing_optin_at ) )
							);
						}
						// Preferred dates moved out of this read-only block — they get
						// their own editable panel below so staff can update them without
						// needing a separate edit screen. Guests and funding stay read-only:
						// guest count edits are rare and would warrant their own UX, and
						// funding type drives downstream comms so we don't want it changing
						// silently from the detail page.
						$booking_fields = array(
							__( 'Number of guests', 'restwell-retreats' ) => esc_html( $row->num_guests ),
							__( 'Funding type', 'restwell-retreats' )    => esc_html( function_exists( 'restwell_enquiry_funding_label' ) ? restwell_enquiry_funding_label( (string) $row->funding_type ) : $row->funding_type ),
						);
						?>

						<h3 class="rw-detail-section-title"><?php esc_html_e( 'Contact', 'restwell-retreats' ); ?></h3>
						<table class="form-table rw-readonly-table" role="presentation">
							<?php foreach ( $contact_fields as $label => $value ) : ?>
								<?php if ( $value ) : ?>
									<tr>
										<th scope="row"><?php echo esc_html( $label ); ?></th>
										<td><?php echo wp_kses_post( $value ); ?></td>
									</tr>
								<?php endif; ?>
							<?php endforeach; ?>
						</table>

						<h3 class="rw-detail-section-title"><?php esc_html_e( 'Booking', 'restwell-retreats' ); ?></h3>
						<table class="form-table rw-readonly-table" role="presentation">
							<?php foreach ( $booking_fields as $label => $value ) : ?>
								<?php if ( $value ) : ?>
									<tr>
										<th scope="row"><?php echo esc_html( $label ); ?></th>
										<td><?php echo wp_kses_post( $value ); ?></td>
									</tr>
								<?php endif; ?>
							<?php endforeach; ?>
						</table>

						<?php
						/*
						 * Editable stay-dates panel.
						 *
						 * Standalone form with native HTML5 date inputs (the device's own
						 * picker — no JS-driven calendar widget to fight with screen readers
						 * or break on mobile). Empty inputs are valid and clear the dates.
						 *
						 * The handler `restwell_crm_handle_update_stay_dates()` writes a
						 * "Stay dates updated: {old} → {new}" entry to the activity log on
						 * every change, so this is auditable without staff having to
						 * remember to leave a note.
						 */
						$stay_from = $row->date_from ? esc_attr( $row->date_from ) : '';
						$stay_to   = $row->date_to   ? esc_attr( $row->date_to )   : '';
						?>
						<h3 class="rw-detail-section-title">
							<?php esc_html_e( 'Stay dates', 'restwell-retreats' ); ?>
						</h3>
						<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="rw-stay-dates-form">
							<?php wp_nonce_field( 'restwell_crm_update_stay_dates' ); ?>
							<input type="hidden" name="action" value="restwell_crm_update_stay_dates" />
							<input type="hidden" name="rw_enquiry_id" value="<?php echo esc_attr( (string) $row->id ); ?>" />

							<div class="rw-stay-dates-grid">
								<p class="rw-stay-dates-field">
									<label for="rw_date_from">
										<?php esc_html_e( 'Arriving', 'restwell-retreats' ); ?>
									</label>
									<input
										type="date"
										id="rw_date_from"
										name="rw_date_from"
										value="<?php echo esc_attr( $stay_from ); ?>"
									/>
								</p>
								<p class="rw-stay-dates-field">
									<label for="rw_date_to">
										<?php esc_html_e( 'Leaving', 'restwell-retreats' ); ?>
									</label>
									<input
										type="date"
										id="rw_date_to"
										name="rw_date_to"
										value="<?php echo esc_attr( $stay_to ); ?>"
									/>
								</p>
							</div>

							<p class="rw-stay-dates-actions">
								<button type="submit" class="button button-primary">
									<?php esc_html_e( 'Save stay dates', 'restwell-retreats' ); ?>
								</button>
								<span class="description rw-stay-dates-help">
									<?php
									if ( '' !== (string) $row->preferred_dates ) {
										printf(
											/* translators: %s: current preferred-dates value as the guest entered or last edited it */
											esc_html__( 'Currently shown as: %s. Leave both empty to clear. Changes are recorded in the activity log.', 'restwell-retreats' ),
											esc_html( $row->preferred_dates )
										);
									} else {
										esc_html_e( 'No stay dates set yet. Changes are recorded in the activity log.', 'restwell-retreats' );
									}
									?>
								</span>
							</p>
						</form>

						<?php if ( $row->care_requirements ) : ?>
							<h3 class="rw-detail-section-title"><?php esc_html_e( 'Care Requirements', 'restwell-retreats' ); ?></h3>
							<p class="rw-prose-block">
								<?php echo esc_html( $row->care_requirements ); ?>
							</p>
						<?php endif; ?>

						<?php if ( $row->accessibility ) : ?>
							<h3 class="rw-detail-section-title"><?php esc_html_e( 'Accessibility Needs', 'restwell-retreats' ); ?></h3>
							<p class="rw-prose-block">
								<?php echo esc_html( $row->accessibility ); ?>
							</p>
						<?php endif; ?>

						<h3 class="rw-detail-section-title"><?php esc_html_e( 'Message', 'restwell-retreats' ); ?></h3>
						<p class="rw-prose-block rw-prose-block--message">
							<?php echo esc_html( $row->message ); ?>
						</p>

						<p class="rw-submitted-meta">
							<?php
							/* translators: %s: formatted date */
							printf(
								esc_html__( 'Submitted %s', 'restwell-retreats' ),
								esc_html( date_i18n( 'j F Y \a\t H:i', strtotime( $row->submitted_at ) ) )
							);
							?>
						</p>

					</div><!-- .inside -->
				</div><!-- .postbox -->
			</div>

			<!-- ── Right: status, notes, actions ────────────────────────── -->
			<div class="rw-detail-layout__sidebar">
				<!-- Status + follow-up form -->
				<form method="post" action="">
					<?php wp_nonce_field( 'restwell_crm_action', 'rw_crm_nonce' ); ?>
					<input type="hidden" name="rw_enquiry_id" value="<?php echo esc_attr( $row->id ); ?>">

					<div class="postbox">
						<div class="postbox-header">
							<h2 class="hndle"><span><?php esc_html_e( 'Status', 'restwell-retreats' ); ?></span></h2>
						</div>
						<div class="inside">
							<label class="screen-reader-text" for="rw-status-select"><?php esc_html_e( 'Status', 'restwell-retreats' ); ?></label>
							<select name="rw_status" id="rw-status-select" class="rw-sidebar-field">
								<?php foreach ( $statuses as $slug => $info ) : ?>
									<option value="<?php echo esc_attr( $slug ); ?>" <?php selected( $row->status, $slug ); ?>>
										<?php echo esc_html( $info['label'] ); ?>
									</option>
								<?php endforeach; ?>
							</select>

							<!-- Status timestamps -->
							<?php
						$ts_fields = array(
							'contacted_at'  => __( 'Contacted', 'restwell-retreats' ),
							'qualified_at'  => __( 'Qualified', 'restwell-retreats' ),
							'booked_at'     => __( 'Booked', 'restwell-retreats' ),
							'closed_at'     => __( 'Closed', 'restwell-retreats' ),
						);
							foreach ( $ts_fields as $col => $label ) :
								if ( ! empty( $row->$col ) ) :
							?>
							<p class="rw-ts-line">
								<?php
								printf(
									/* translators: 1: status label, 2: formatted date */
									esc_html__( '%1$s: %2$s', 'restwell-retreats' ),
									esc_html( $label ),
									esc_html( date_i18n( 'j M Y, H:i', strtotime( $row->$col ) ) )
								);
								?>
							</p>
							<?php
								endif;
							endforeach;
							?>

							<hr class="rw-divider-compact" />

							<label for="rw-follow-up" class="rw-sidebar-label rw-sidebar-label--tight">
								<?php esc_html_e( 'Follow-up date', 'restwell-retreats' ); ?>
							</label>
							<input
								type="datetime-local"
								id="rw-follow-up"
								name="rw_follow_up"
								value="<?php echo esc_attr( $follow_up_value ); ?>"
								class="rw-sidebar-field"
							/>
							<p class="description rw-description-tiny">
								<?php esc_html_e( 'Appears on the dashboard when due.', 'restwell-retreats' ); ?>
							</p>
						</div>
					</div>

					<div class="postbox">
						<div class="postbox-header">
							<h2 class="hndle"><span><?php esc_html_e( 'Staff Notes', 'restwell-retreats' ); ?></span></h2>
						</div>
						<div class="inside">
							<label class="screen-reader-text" for="rw-staff-notes"><?php esc_html_e( 'Staff notes', 'restwell-retreats' ); ?></label>
							<textarea name="rw_notes" id="rw-staff-notes" rows="5"
							          class="rw-sidebar-field"
							          placeholder="<?php esc_attr_e( 'Pinned summary (not visible to the enquirer).', 'restwell-retreats' ); ?>"
							><?php echo esc_textarea( $row->staff_notes ); ?></textarea>
						</div>
					</div>

					<input type="submit" class="button button-primary button-large rw-btn-block"
					       value="<?php esc_attr_e( 'Save Changes', 'restwell-retreats' ); ?>">

				</form>

				<!-- Activity log (append-only notes) -->
				<div class="postbox">
					<div class="postbox-header">
						<h2 class="hndle"><span><?php esc_html_e( 'Activity Log', 'restwell-retreats' ); ?></span></h2>
					</div>
					<div class="inside rw-activity-inside">

						<?php if ( ! empty( $notes ) ) : ?>
							<div class="rw-activity-list">
								<?php foreach ( $notes as $note ) :
									$author = get_userdata( (int) $note->created_by );
									$author_name = $author ? $author->display_name : __( 'Staff', 'restwell-retreats' );
									$initial     = mb_strtoupper( mb_substr( $author_name, 0, 1 ) );
								?>
								<div class="rw-activity-row">
									<div class="rw-activity-avatar" aria-hidden="true">
										<?php echo esc_html( $initial ); ?>
									</div>
									<div class="rw-activity-body">
										<div class="rw-activity-meta">
											<strong><?php echo esc_html( $author_name ); ?></strong>
											&middot; <?php echo esc_html( date_i18n( 'j M Y, H:i', strtotime( $note->created_at ) ) ); ?>
										</div>
										<div class="rw-activity-bubble">
											<?php echo esc_html( $note->note ); ?>
										</div>
									</div>
								</div>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>

						<!-- Add note form -->
						<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="rw-add-note-form">
							<?php wp_nonce_field( 'restwell_crm_add_note' ); ?>
							<input type="hidden" name="action" value="restwell_crm_add_note" />
							<input type="hidden" name="rw_enquiry_id" value="<?php echo esc_attr( $row->id ); ?>" />
							<label class="screen-reader-text" for="rw-new-note-<?php echo esc_attr( $row->id ); ?>">
								<?php esc_html_e( 'Add a note', 'restwell-retreats' ); ?>
							</label>
							<textarea
								id="rw-new-note-<?php echo esc_attr( $row->id ); ?>"
								name="rw_note_text"
								rows="3"
								placeholder="<?php esc_attr_e( 'Add a note…', 'restwell-retreats' ); ?>"
							></textarea>
							<input type="submit" class="button button-secondary" value="<?php esc_attr_e( 'Add note', 'restwell-retreats' ); ?>" />
						</form>

					</div>
				</div><!-- .postbox activity log -->

				<!-- Quick-contact buttons (outside form so they don't submit) -->
				<a href="<?php echo esc_url( $mailto ); ?>" class="button button-large rw-btn-block">
					&#9993; <?php esc_html_e( 'Reply by Email', 'restwell-retreats' ); ?>
				</a>
				<?php if ( $row->phone ) : ?>
					<a href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', $row->phone ) ); ?>"
					   class="button button-large rw-btn-block">
						&#128222; <?php echo esc_html( $row->phone ); ?>
					</a>
				<?php endif; ?>

			<?php if ( 'booked' === $row->status ) : ?>
				<a href="<?php echo esc_url( $promote_url ); ?>"
				   class="button button-primary button-large rw-btn-block">
					&#10133; <?php esc_html_e( 'Add to Guest Guide', 'restwell-retreats' ); ?>
				</a>
			<?php endif; ?>

			<?php if ( 'closed' === $row->status && function_exists( 'restwell_email_post_stay' ) ) : ?>
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="rw-post-stay-form">
					<?php wp_nonce_field( 'restwell_crm_send_post_stay_' . $row->id ); ?>
					<input type="hidden" name="action" value="restwell_crm_send_post_stay" />
					<input type="hidden" name="rw_enquiry_id" value="<?php echo esc_attr( $row->id ); ?>" />
					<button type="submit" class="button button-large rw-btn-block"
					        onclick="return confirm('<?php esc_attr_e( 'Send post-stay email to this guest?', 'restwell-retreats' ); ?>');">
						&#9993; <?php esc_html_e( 'Send Post-Stay Email', 'restwell-retreats' ); ?>
					</button>
				</form>
			<?php endif; ?>

			</div><!-- right column -->

		</div><!-- grid -->
	</div><!-- .wrap -->
	<?php
}
