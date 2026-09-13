<?php
/**
 * CRM enquiries list query and results table.
 *
 * @package Restwell_CRM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/enquiries-list-ui.php';

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
		'status_filter'    => $status_filter,
		'search'           => $search,
		'urgent_filter'    => $urgent_filter,
		'follow_up_filter' => $follow_up_filter,
		'submitted_since'  => $submitted_since_raw,
		'orderby'          => $orderby,
		'order'            => $order,
		'per_page'         => $per_page,
		'current_page'     => $current_page,
		'total'            => $total,
		'total_pages'      => $total_pages,
		'rows'             => $rows,
		'counts'           => $counts,
		'statuses'         => $statuses,
		'base_url'         => admin_url( 'admin.php?page=restwell-enquiries' ),
		'now_mysql'        => current_time( 'mysql' ),
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
	$total         = $list['total'];
	$rows          = $list['rows'];
	$counts        = $list['counts'];
	$statuses      = $list['statuses'];
	$base_url      = $list['base_url'];
	$now_mysql     = $list['now_mysql'];
	$banner_text   = restwell_crm_list_filter_banner_text( $list );

	$sort_link = function ( string $col, string $label, string $current, string $current_order, string $base, array $extras ): string {
		$is_active  = ( $col === $current );
		$next_order = $is_active && 'ASC' === $current_order ? 'DESC' : 'ASC';
		$arrow      = '';
		$sort_hint  = '';
		if ( $is_active ) {
			$arrow     = 'ASC' === $current_order
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
					'order'   => $next_order,
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
	$sort_aria   = function ( string $col, string $current, string $current_order ): string {
		if ( $col !== $current ) {
			return 'none';
		}
		return 'ASC' === $current_order ? 'ascending' : 'descending';
	};
	$sort_extras = restwell_crm_list_preserve_args( $list );
	?>
	<div class="rw-enquiries-panel">
		<div class="rw-enquiries-controls">
			<ul class="subsubsub rw-filter-pills" role="list">
				<li>
					<a href="<?php echo esc_url( $base_url ); ?>"<?php echo $status_filter || restwell_crm_list_has_active_filters( $list ) ? '' : ' class="current"'; ?>>
						<?php esc_html_e( 'All', 'restwell-retreats' ); ?>
						<span class="count">(<?php echo esc_html( $counts['all'] ); ?>)</span>
					</a>
				</li>
				<?php foreach ( $statuses as $slug => $info ) : ?>
					<li>
						<a href="<?php echo esc_url( add_query_arg( restwell_crm_list_preserve_args( $list, array( 'status_filter' => $slug, 'urgent_filter' => false ) ), $base_url ) ); ?>"<?php echo $status_filter === $slug ? ' class="current"' : ''; ?>>
							<?php echo esc_html( $info['label'] ); ?>
							<span class="count">(<?php echo esc_html( $counts[ $slug ] ); ?>)</span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
			<form class="rw-enquiries-search" method="get" action="<?php echo esc_url( admin_url( 'admin.php' ) ); ?>">
				<input type="hidden" name="page" value="restwell-enquiries">
				<?php restwell_crm_list_render_hidden_filters( $list ); ?>
				<div class="rw-search-bar">
					<label class="screen-reader-text" for="rw-crm-search"><?php esc_html_e( 'Search enquiries', 'restwell-retreats' ); ?></label>
					<input
						type="search"
						id="rw-crm-search"
						name="s"
						class="rw-search-bar__input"
						value="<?php echo esc_attr( $search ); ?>"
						placeholder="<?php esc_attr_e( 'Name, email or phone…', 'restwell-retreats' ); ?>"
					>
					<button type="submit" class="button button-primary rw-search-bar__submit">
						<?php esc_html_e( 'Search', 'restwell-retreats' ); ?>
					</button>
					<?php if ( $search ) : ?>
						<a
							class="rw-search-bar__clear"
							href="<?php echo esc_url( add_query_arg( restwell_crm_list_preserve_args( $list, array( 's' => false ) ), $base_url ) ); ?>"
						>
							<?php esc_html_e( 'Clear search', 'restwell-retreats' ); ?>
						</a>
					<?php endif; ?>
				</div>
			</form>
		</div><!-- .rw-enquiries-controls -->

		<?php if ( $banner_text ) : ?>
			<div class="rw-list-filter-banner">
				<p class="rw-list-filter-banner__text"><?php echo esc_html( $banner_text ); ?></p>
				<a class="rw-list-filter-banner__clear" href="<?php echo esc_url( $base_url ); ?>">
					<?php esc_html_e( 'Clear filters', 'restwell-retreats' ); ?>
				</a>
			</div>
		<?php endif; ?>

		<?php if ( empty( $rows ) ) : ?>
			<div class="rw-enquiries-empty">
				<div class="rw-enquiries-empty__inner">
					<?php if ( restwell_crm_list_has_active_filters( $list ) ) : ?>
						<p class="rw-enquiries-empty__title"><?php esc_html_e( 'No enquiries match', 'restwell-retreats' ); ?></p>
						<p class="rw-enquiries-empty__text"><?php esc_html_e( 'Try clearing filters or searching with a different name, email, or phone number.', 'restwell-retreats' ); ?></p>
					<?php else : ?>
						<p class="rw-enquiries-empty__title"><?php esc_html_e( 'No enquiries yet', 'restwell-retreats' ); ?></p>
						<p class="rw-enquiries-empty__text"><?php esc_html_e( 'New form submissions from the website will appear here. You can reply, update status, and schedule follow-ups from each row.', 'restwell-retreats' ); ?></p>
					<?php endif; ?>
				</div>
			</div>
		<?php else : ?>

		<p class="rw-enquiries-summary" aria-live="polite">
			<?php
			printf(
				/* translators: %d: number of enquiries */
				esc_html( _n( '%d enquiry', '%d enquiries', $total, 'restwell-retreats' ) ),
				(int) $total
			);
			?>
		</p>

		<ul class="rw-enquiries-cards" aria-label="<?php esc_attr_e( 'Enquiries', 'restwell-retreats' ); ?>">
			<?php foreach ( $rows as $row ) : ?>
				<?php restwell_crm_render_enquiry_card( restwell_crm_enquiry_row_context( $row, $now_mysql ) ); ?>
			<?php endforeach; ?>
		</ul>
		<div class="rw-enquiries-mobile-nav">
			<?php restwell_crm_render_enquiries_pagination( $list ); ?>
		</div>

		<form method="post" action="" class="rw-enquiries-desktop">
			<?php wp_nonce_field( 'restwell_crm_bulk', 'rw_bulk_nonce' ); ?>

			<div class="rw-table-shell rw-table-shell--enquiries">
				<p class="rw-table-scroll-hint"><?php esc_html_e( 'Scroll sideways if columns are hidden.', 'restwell-retreats' ); ?></p>
				<div class="tablenav top">
					<div class="alignleft actions bulkactions">
						<label for="rw-bulk-action" class="screen-reader-text"><?php esc_html_e( 'Select bulk action', 'restwell-retreats' ); ?></label>
						<select name="rw_bulk_action" id="rw-bulk-action">
							<option value=""><?php esc_html_e( 'Bulk action…', 'restwell-retreats' ); ?></option>
							<?php foreach ( $statuses as $slug => $info ) : ?>
								<option value="<?php echo esc_attr( $slug ); ?>">
									<?php
									printf(
										/* translators: %s: status label */
										esc_html__( 'Mark as %s', 'restwell-retreats' ),
										esc_html( $info['label'] )
									);
									?>
								</option>
							<?php endforeach; ?>
						</select>
						<input type="submit" class="button action" value="<?php esc_attr_e( 'Apply', 'restwell-retreats' ); ?>">
					</div>
					<?php restwell_crm_render_enquiries_pagination( $list ); ?>
				</div>

				<table class="widefat striped rw-enquiries-table">
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
							<?php restwell_crm_render_enquiry_table_row( restwell_crm_enquiry_row_context( $row, $now_mysql ) ); ?>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div><!-- .rw-table-shell--enquiries -->
		</form>

		<?php endif; ?>
	</div><!-- .rw-enquiries-panel -->
	<?php
}
