<?php
/**
 * CRM enquiries list query and results table.
 *
 * @package Restwell_CRM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Parse the enquiries list's $_GET filters/sort/pagination into a single
 * array, and run the counted, paginated query against it.
 *
 * @param string $table Enquiries table name (with prefix).
 * @return array{
 *     status_filter:string, search:string, orderby:string, order:string,
 *     per_page:int, current_page:int, total:int, total_pages:int,
 *     rows:array, counts:array, statuses:array, base_url:string, now_mysql:string
 * }
 */
function restwell_crm_get_enquiries_list_data( string $table ) {
	global $wpdb;

	// SAFETY: only append fragments returned by $wpdb->prepare() — never raw $_GET strings.
	$status_filter       = isset( $_GET['status_filter'] ) ? sanitize_key( wp_unslash( $_GET['status_filter'] ) ) : '';
	$search              = isset( $_GET['s'] ) ? sanitize_text_field( wp_unslash( $_GET['s'] ) ) : '';
	$urgent_filter       = isset( $_GET['urgent_filter'] ) ? absint( wp_unslash( $_GET['urgent_filter'] ) ) : 0;
	$follow_up_filter    = isset( $_GET['follow_up_filter'] ) ? sanitize_key( wp_unslash( $_GET['follow_up_filter'] ) ) : '';
	$submitted_since_raw = isset( $_GET['submitted_since'] ) ? sanitize_text_field( wp_unslash( $_GET['submitted_since'] ) ) : '';
	$per_page            = 25;
	$current_page        = max( 1, isset( $_GET['paged'] ) ? absint( wp_unslash( $_GET['paged'] ) ) : 1 );
	$offset              = ( $current_page - 1 ) * $per_page;

	// Sortable columns.
	$allowed_orderby = array( 'submitted_at', 'status', 'name' );
	$orderby_raw     = isset( $_GET['orderby'] ) ? sanitize_key( wp_unslash( $_GET['orderby'] ) ) : 'submitted_at';
	$orderby         = in_array( $orderby_raw, $allowed_orderby, true ) ? $orderby_raw : 'submitted_at';
	$order_raw       = isset( $_GET['order'] ) ? strtoupper( sanitize_key( wp_unslash( $_GET['order'] ) ) ) : 'DESC';
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

	// $where is built only from $wpdb->prepare() fragments and fixed SQL; $orderby/$order are allow-listed.
	// phpcs:disable WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- dynamic WHERE cannot be re-prepared (LIKE % wildcards); table via %i below.
	$from_sql = $wpdb->prepare( 'FROM %i', $table );
	$total    = (int) $wpdb->get_var( "SELECT COUNT(*) {$from_sql} WHERE {$where}" );
	$rows     = $wpdb->get_results(
		"SELECT * {$from_sql} WHERE {$where} ORDER BY {$orderby} {$order} LIMIT " . absint( $per_page ) . ' OFFSET ' . absint( $offset )
	);
	// phpcs:enable WordPress.DB.PreparedSQL.InterpolatedNotPrepared

	$total_pages = (int) ceil( $total / $per_page );
	$statuses    = restwell_crm_statuses();

	// Status counts for tabs.
	$counts = array();
	foreach ( array_keys( $statuses ) as $s ) {
		$counts[ $s ] = (int) $wpdb->get_var( $wpdb->prepare( 'SELECT COUNT(*) FROM %i WHERE status = %s', $table, $s ) );
	}
	$counts['all'] = (int) $wpdb->get_var( $wpdb->prepare( 'SELECT COUNT(*) FROM %i', $table ) );

	return array(
		'status_filter' => $status_filter,
		'search'        => $search,
		'orderby'       => $orderby,
		'order'         => $order,
		'per_page'      => $per_page,
		'current_page'  => $current_page,
		'total'         => $total,
		'total_pages'   => $total_pages,
		'rows'          => $rows,
		'counts'        => $counts,
		'statuses'      => $statuses,
		'base_url'      => admin_url( 'admin.php?page=restwell-enquiries' ),
		'now_mysql'     => current_time( 'mysql' ),
	);
}

/**
 * The filter tabs, search box, and (bulk-action) results table for the
 * enquiries list page.
 *
 * @param array $list Data from {@see restwell_crm_get_enquiries_list_data()}.
 */
function restwell_crm_render_enquiries_panel( array $list ) {
	$status_filter = $list['status_filter'];
	$search        = $list['search'];
	$orderby       = $list['orderby'];
	$order         = $list['order'];
	$current_page  = $list['current_page'];
	$total         = $list['total'];
	$total_pages   = $list['total_pages'];
	$rows          = $list['rows'];
	$counts        = $list['counts'];
	$statuses      = $list['statuses'];
	$base_url      = $list['base_url'];
	$now_mysql     = $list['now_mysql'];
	?>
		<div class="rw-enquiries-panel">
		<div class="rw-enquiries-controls">
			<div class="rw-enquiries-controls__primary">
			<!-- Status filter tabs -->
			<div class="rw-filter-group">
				<span class="rw-filter-group__label" id="rw-enquiries-status-label"><?php esc_html_e( 'Status', 'restwell-retreats' ); ?></span>
				<ul class="subsubsub rw-subsubsub--status rw-filter-pills" role="list" aria-labelledby="rw-enquiries-status-label">
					<li>
						<a href="<?php echo esc_url( $base_url ); ?>" 
						<?php
						if ( ! $status_filter ) {
							echo 'class="current"';}
						?>
						>
							<?php esc_html_e( 'All', 'restwell-retreats' ); ?> <span class="count">(<?php echo esc_html( $counts['all'] ); ?>)</span>
						</a>
					</li>
					<?php foreach ( $statuses as $slug => $info ) : ?>
						<li>
							<a href="<?php echo esc_url( add_query_arg( 'status_filter', $slug, $base_url ) ); ?>"
							   <?php
								if ( $status_filter === $slug ) {
									echo 'class="current"';}
								?>
								>
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
							href="
							<?php
							echo esc_url(
								add_query_arg(
									array(
										'paged' => $p,
										'status_filter' => $status_filter,
										's' => $search,
									),
									$base_url
								)
							);
							?>
									">
								<?php echo esc_html( $p ); ?>
							</a>
						<?php endfor; ?>
					</div>
				<?php endif; ?>
			</div>

			<table class="widefat striped rw-enquiries-table">
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
			$sort_link = function ( string $col, string $label, string $current, string $current_order, string $base, array $extras ): string {
				$is_active  = ( $col === $current );
				$next_order = $is_active && 'ASC' === $current_order ? 'DESC' : 'ASC';
				$arrow      = '';
				$sort_hint  = '';
				if ( $is_active ) {
					$arrow = 'ASC' === $current_order
						? ' <span aria-hidden="true">&#9650;</span>'
						: ' <span aria-hidden="true">&#9660;</span>';
					$sort_hint = 'ASC' === $current_order
						? ' ' . __( 'Sorted ascending.', 'restwell-retreats' )
						: ' ' . __( 'Sorted descending.', 'restwell-retreats' );
				}
				$href = add_query_arg(
					array_merge(
						$extras,
						array(
							'orderby' => $col,
							'order' => $next_order,
						)
					),
					$base
				);
				return sprintf(
					'<a href="%s" class="%s" aria-label="%s">%s%s<span class="screen-reader-text">%s</span></a>',
					esc_url( $href ),
					$is_active ? 'rw-sort-link rw-sort-link--active' : 'rw-sort-link',
					esc_attr(
						sprintf(
							/* translators: %s: column label */
							__( 'Sort by %s', 'restwell-retreats' ),
							$label
						)
					),
					esc_html( $label ),
					$arrow,
					esc_html( $sort_hint )
				);
			};
			$sort_aria = function ( string $col, string $current, string $current_order ): string {
				if ( $col !== $current ) {
					return 'none';
				}
				return 'ASC' === $current_order ? 'ascending' : 'descending';
			};
			$sort_extras = array_filter(
				array(
					'page'          => 'restwell-enquiries',
					'status_filter' => $status_filter,
					's'             => $search,
				)
			);
			?>
			<thead>
				<tr>
					<td class="manage-column check-column">
						<input id="cb-select-all" type="checkbox">
					</td>
					<th scope="col" class="column-rw-flag"><span class="screen-reader-text"><?php esc_html_e( 'Flags', 'restwell-retreats' ); ?></span></th>
					<th scope="col" class="column-rw-name sortable <?php echo 'name' === $orderby ? 'sorted' : ''; ?>" aria-sort="<?php echo esc_attr( $sort_aria( 'name', $orderby, $order ) ); ?>">
						<?php echo $sort_link( 'name', __( 'Name', 'restwell-retreats' ), $orderby, $order, admin_url( 'admin.php' ), $sort_extras ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
					</th>
					<th scope="col" class="column-rw-contact"><?php esc_html_e( 'Contact', 'restwell-retreats' ); ?></th>
					<th scope="col" class="column-rw-marketing"><?php esc_html_e( 'Marketing', 'restwell-retreats' ); ?></th>
					<th scope="col" class="column-rw-dates"><?php esc_html_e( 'Dates / Guests', 'restwell-retreats' ); ?></th>
					<th scope="col" class="column-rw-status sortable <?php echo 'status' === $orderby ? 'sorted' : ''; ?>" aria-sort="<?php echo esc_attr( $sort_aria( 'status', $orderby, $order ) ); ?>">
						<?php echo $sort_link( 'status', __( 'Status', 'restwell-retreats' ), $orderby, $order, admin_url( 'admin.php' ), $sort_extras ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
					</th>
					<th scope="col" class="column-rw-received sortable <?php echo 'submitted_at' === $orderby ? 'sorted' : ''; ?>" aria-sort="<?php echo esc_attr( $sort_aria( 'submitted_at', $orderby, $order ) ); ?>">
						<?php echo $sort_link( 'submitted_at', __( 'Received', 'restwell-retreats' ), $orderby, $order, admin_url( 'admin.php' ), $sort_extras ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
					</th>
				</tr>
			</thead>
				<tbody>
					<?php foreach ( $rows as $row ) : ?>
						<?php
						$detail_url    = add_query_arg(
							array(
								'page' => 'restwell-enquiries',
								'view' => $row->id,
							),
							admin_url( 'admin.php' )
						);
						$is_overdue    = ! empty( $row->follow_up_at ) && $row->follow_up_at <= $now_mysql && 'closed' !== $row->status;
						$sla_badge     = restwell_crm_sla_badge( $row );
						?>
						<tr<?php echo $row->is_urgent ? ' class="rw-row--urgent"' : ''; ?>>
							<th scope="row" class="check-column">
								<input type="checkbox" name="rw_bulk_ids[]" value="<?php echo esc_attr( $row->id ); ?>">
							</th>
							<td class="column-rw-flag" data-label="<?php echo esc_attr__( 'Flags', 'restwell-retreats' ); ?>">
								<?php if ( $row->is_urgent ) : ?>
									<span class="rw-badge rw-badge--urgent" title="<?php esc_attr_e( 'Urgent', 'restwell-retreats' ); ?>"><?php esc_html_e( 'Urgent', 'restwell-retreats' ); ?></span>
								<?php elseif ( $is_overdue ) : ?>
									<span class="rw-badge rw-badge--overdue" title="<?php esc_attr_e( 'Follow-up overdue', 'restwell-retreats' ); ?>"><?php esc_html_e( 'Overdue', 'restwell-retreats' ); ?></span>
								<?php endif; ?>
							</td>
							<td class="column-rw-name" data-label="<?php echo esc_attr__( 'Name', 'restwell-retreats' ); ?>">
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
							<td class="column-rw-contact" data-label="<?php echo esc_attr__( 'Contact', 'restwell-retreats' ); ?>">
								<a class="rw-tap-link" href="mailto:<?php echo esc_attr( $row->email ); ?>"><?php echo esc_html( $row->email ); ?></a>
								<?php if ( $row->phone ) : ?>
									<br>
									<a class="rw-tap-link" href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', $row->phone ) ); ?>">
										<?php echo esc_html( $row->phone ); ?>
									</a>
								<?php endif; ?>
							</td>
							<td class="column-rw-marketing rw-text-meta" data-label="<?php echo esc_attr__( 'Marketing', 'restwell-retreats' ); ?>">
								<?php if ( ! empty( $row->marketing_optin ) ) : ?>
									<span class="rw-badge rw-badge--booked"><?php esc_html_e( 'Opted in', 'restwell-retreats' ); ?></span>
									<?php if ( ! empty( $row->marketing_optin_at ) ) : ?>
										<br><span class="rw-text-muted-sm"><?php echo esc_html( date_i18n( 'j M Y', strtotime( $row->marketing_optin_at ) ) ); ?></span>
									<?php endif; ?>
								<?php else : ?>
									<span class="rw-text-dim"><?php esc_html_e( 'No', 'restwell-retreats' ); ?></span>
								<?php endif; ?>
							</td>
							<td class="column-rw-dates" data-label="<?php echo esc_attr__( 'Dates / Guests', 'restwell-retreats' ); ?>">
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
							<td class="column-rw-status" data-label="<?php echo esc_attr__( 'Status', 'restwell-retreats' ); ?>">
							<div class="rw-status-badge" data-enquiry-id="<?php echo esc_attr( $row->id ); ?>"><?php echo restwell_crm_status_badge( $row->status ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
								<div class="rw-status-actions">
									<a class="rw-details-link" href="<?php echo esc_url( $detail_url ); ?>">
										<?php esc_html_e( 'Open details', 'restwell-retreats' ); ?>
									</a>
								</div>
							</td>
							<td class="column-rw-received rw-text-meta" data-label="<?php echo esc_attr__( 'Received', 'restwell-retreats' ); ?>">
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
	<?php
}
