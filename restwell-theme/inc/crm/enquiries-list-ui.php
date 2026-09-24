<?php
/**
 * CRM enquiries list: row context, filter helpers, card + table renderers.
 *
 * @package Restwell_CRM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Build query args that preserve the active list filters.
 *
 * @param array<string, mixed> $list     List data from restwell_crm_get_enquiries_list_data().
 * @param array<string, mixed> $overrides Keys to merge/override.
 * @return array<string, mixed>
 */
function restwell_crm_list_preserve_args( array $list, array $overrides = array() ): array {
	$args = array(
		'page' => 'restwell-enquiries',
	);

	if ( ! empty( $list['status_filter'] ) ) {
		$args['status_filter'] = $list['status_filter'];
	}
	if ( ! empty( $list['search'] ) ) {
		$args['s'] = $list['search'];
	}
	if ( ! empty( $list['urgent_filter'] ) ) {
		$args['urgent_filter'] = '1';
	}
	if ( ! empty( $list['follow_up_filter'] ) ) {
		$args['follow_up_filter'] = $list['follow_up_filter'];
	}
	if ( ! empty( $list['submitted_since'] ) ) {
		$args['submitted_since'] = $list['submitted_since'];
	}
	if ( ! empty( $list['orderby'] ) && 'submitted_at' !== $list['orderby'] ) {
		$args['orderby'] = $list['orderby'];
	}
	if ( ! empty( $list['order'] ) && 'DESC' !== $list['order'] ) {
		$args['order'] = $list['order'];
	}

	$args = array_merge( $args, $overrides );

	foreach ( $overrides as $key => $value ) {
		if ( false === $value || '' === $value ) {
			unset( $args[ $key ] );
		}
	}

	return $args;
}

/**
 * Whether any non-default dashboard/list filter is active.
 *
 * @param array<string, mixed> $list List data.
 */
function restwell_crm_list_has_active_filters( array $list ): bool {
	return ! empty( $list['status_filter'] )
		|| ! empty( $list['search'] )
		|| ! empty( $list['urgent_filter'] )
		|| ! empty( $list['follow_up_filter'] )
		|| ! empty( $list['submitted_since'] );
}

/**
 * Human-readable description of active dashboard-style filters.
 *
 * @param array<string, mixed> $list List data.
 * @return string Empty when no special filter is active.
 */
function restwell_crm_list_filter_banner_text( array $list ): string {
	$parts     = array();
	$has_extra = ! empty( $list['urgent_filter'] )
		|| 'overdue' === ( $list['follow_up_filter'] ?? '' )
		|| ! empty( $list['submitted_since'] )
		|| ! empty( $list['search'] );

	if ( ! empty( $list['urgent_filter'] ) && 'new' === ( $list['status_filter'] ?? '' ) ) {
		$parts[] = __( 'urgent, uncontacted enquiries', 'restwell-retreats' );
	} elseif ( ! empty( $list['status_filter'] ) && $has_extra ) {
		$statuses = restwell_crm_statuses();
		$slug     = (string) $list['status_filter'];
		if ( isset( $statuses[ $slug ] ) ) {
			$parts[] = sprintf(
				/* translators: %s: status label */
				__( '%s enquiries', 'restwell-retreats' ),
				$statuses[ $slug ]['label']
			);
		}
	}

	if ( 'overdue' === ( $list['follow_up_filter'] ?? '' ) ) {
		$parts[] = __( 'overdue follow-ups', 'restwell-retreats' );
	}

	if ( ! empty( $list['submitted_since'] ) ) {
		$since_ts = strtotime( (string) $list['submitted_since'] );
		if ( $since_ts ) {
			$parts[] = sprintf(
				/* translators: %s: formatted date/time */
				__( 'received since %s', 'restwell-retreats' ),
				date_i18n( 'j M Y, H:i', $since_ts )
			);
		}
	}

	$search = ! empty( $list['search'] ) ? (string) $list['search'] : '';

	if ( '' === $search && empty( $parts ) ) {
		return '';
	}

	if ( '' !== $search && empty( $parts ) ) {
		return sprintf(
			/* translators: %s: search string */
			__( 'Search results for “%s”.', 'restwell-retreats' ),
			$search
		);
	}

	if ( '' !== $search ) {
		$parts[] = sprintf(
			/* translators: %s: search string */
			__( 'matching “%s”', 'restwell-retreats' ),
			$search
		);
	}

	return sprintf(
		/* translators: %s: comma-separated filter description */
		__( 'Showing %s.', 'restwell-retreats' ),
		implode( ', ', $parts )
	);
}

/**
 * Render hidden inputs preserving list filters (for search forms).
 *
 * @param array<string, mixed> $list List data.
 */
function restwell_crm_list_render_hidden_filters( array $list ): void {
	foreach ( restwell_crm_list_preserve_args( $list ) as $key => $value ) {
		if ( in_array( $key, array( 'page', 's' ), true ) || '' === $value || null === $value ) {
			continue;
		}
		printf(
			'<input type="hidden" name="%1$s" value="%2$s">',
			esc_attr( $key ),
			esc_attr( (string) $value )
		);
	}
}

/**
 * Normalise one enquiry row for list/card/table renderers.
 *
 * @param object $row       Enquiry row.
 * @param string $now_mysql Current time in MySQL format.
 * @return array<string, mixed>
 */
function restwell_crm_enquiry_row_context( $row, string $now_mysql ): array {
	$detail_url = add_query_arg(
		array(
			'page' => 'restwell-enquiries',
			'view' => $row->id,
		),
		admin_url( 'admin.php' )
	);
	$is_overdue = ! empty( $row->follow_up_at )
		&& $row->follow_up_at <= $now_mysql
		&& 'closed' !== $row->status;
	$sla_badge  = restwell_crm_sla_badge( $row );
	// When SLA already signals a stale "new" lead, skip the duplicate status pill on cards.
	$show_status_pill = ! ( $sla_badge && 'new' === (string) $row->status );

	return array(
		'row'              => $row,
		'detail_url'       => $detail_url,
		'is_overdue'       => $is_overdue,
		'sla_badge'        => $sla_badge,
		'show_status_pill' => $show_status_pill,
	);
}

/**
 * Flags column / card chips (urgent, overdue, SLA).
 *
 * @param array<string, mixed> $ctx Row context.
 */
function restwell_crm_render_enquiry_flags( array $ctx ): void {
	$row = $ctx['row'];
	?>
	<div class="rw-flag-stack">
		<?php if ( $row->is_urgent ) : ?>
			<span class="rw-badge rw-badge--urgent"><?php esc_html_e( 'Urgent', 'restwell-retreats' ); ?></span>
		<?php elseif ( $ctx['is_overdue'] ) : ?>
			<span class="rw-badge rw-badge--overdue"><?php esc_html_e( 'Overdue', 'restwell-retreats' ); ?></span>
		<?php endif; ?>
		<?php if ( $ctx['sla_badge'] ) : ?>
			<span class="rw-sla-badge"><?php echo $ctx['sla_badge']; // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Inline status badge + optional change hint.
 *
 * @param array<string, mixed> $ctx Row context.
 */
function restwell_crm_render_enquiry_status_badge( array $ctx ): void {
	$row = $ctx['row'];
	if ( ! $ctx['show_status_pill'] ) {
		return;
	}
	?>
	<div
		class="rw-status-badge"
		data-enquiry-id="<?php echo esc_attr( (string) $row->id ); ?>"
		data-status-key="<?php echo esc_attr( (string) $row->status ); ?>"
	>
		<?php echo restwell_crm_status_badge( (string) $row->status ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		<span class="rw-status-hint"><?php esc_html_e( 'Tap to change', 'restwell-retreats' ); ?></span>
	</div>
	<?php
}

/**
 * One mobile enquiry card.
 *
 * @param array<string, mixed> $ctx Row context.
 */
function restwell_crm_render_enquiry_card( array $ctx ): void {
	$row = $ctx['row'];
	$classes = array( 'rw-enquiry-card' );
	if ( $row->is_urgent ) {
		$classes[] = 'rw-enquiry-card--urgent';
	}
	?>
	<li class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
		<header class="rw-enquiry-card__header">
			<div class="rw-enquiry-card__lead">
				<?php if ( $row->is_urgent || $ctx['is_overdue'] || $ctx['sla_badge'] ) : ?>
					<?php restwell_crm_render_enquiry_flags( $ctx ); ?>
				<?php endif; ?>
				<a class="rw-enquiry-card__name" href="<?php echo esc_url( $ctx['detail_url'] ); ?>">
					<?php echo esc_html( $row->name ); ?>
				</a>
			</div>
			<div class="rw-enquiry-card__status">
				<?php restwell_crm_render_enquiry_status_badge( $ctx ); ?>
			</div>
		</header>

		<?php if ( $row->staff_notes ) : ?>
			<p class="rw-enquiry-card__note">
				<span class="rw-enquiry-card__note-icon" aria-hidden="true">&#128221;</span>
				<?php echo esc_html( wp_trim_words( $row->staff_notes, 12 ) ); ?>
			</p>
		<?php endif; ?>

		<div class="rw-enquiry-card__contact">
			<a class="rw-tap-link" href="mailto:<?php echo esc_attr( $row->email ); ?>"><?php echo esc_html( $row->email ); ?></a>
			<?php if ( $row->phone ) : ?>
				<a class="rw-tap-link" href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', $row->phone ) ); ?>">
					<?php echo esc_html( $row->phone ); ?>
				</a>
			<?php endif; ?>
		</div>

		<dl class="rw-enquiry-card__meta">
			<?php if ( $row->preferred_dates || $row->num_guests ) : ?>
				<div class="rw-enquiry-card__meta-row">
					<dt><?php esc_html_e( 'Dates / guests', 'restwell-retreats' ); ?></dt>
					<dd>
						<?php if ( $row->preferred_dates ) : ?>
							<span><?php echo esc_html( $row->preferred_dates ); ?></span>
						<?php endif; ?>
						<?php if ( $row->num_guests ) : ?>
							<span class="rw-text-muted-sm"><?php echo esc_html( $row->num_guests ); ?> <?php esc_html_e( 'guests', 'restwell-retreats' ); ?></span>
						<?php endif; ?>
					</dd>
				</div>
			<?php endif; ?>
			<div class="rw-enquiry-card__meta-row">
				<dt><?php esc_html_e( 'Received', 'restwell-retreats' ); ?></dt>
				<dd>
					<?php echo esc_html( date_i18n( 'j M Y, H:i', strtotime( $row->submitted_at ) ) ); ?>
					<?php if ( $ctx['is_overdue'] ) : ?>
						<span class="rw-follow-up-hint">
							&#9201; <?php echo esc_html( date_i18n( 'j M', strtotime( $row->follow_up_at ) ) ); ?>
						</span>
					<?php endif; ?>
				</dd>
			</div>
			<?php if ( ! empty( $row->marketing_optin ) ) : ?>
				<div class="rw-enquiry-card__meta-row">
					<dt><?php esc_html_e( 'Marketing', 'restwell-retreats' ); ?></dt>
					<dd><span class="rw-badge rw-badge--optin"><?php esc_html_e( 'Opted in', 'restwell-retreats' ); ?></span></dd>
				</div>
			<?php endif; ?>
		</dl>

		<footer class="rw-enquiry-card__footer">
			<a class="button button-primary rw-enquiry-card__open" href="<?php echo esc_url( $ctx['detail_url'] ); ?>">
				<?php esc_html_e( 'Open enquiry', 'restwell-retreats' ); ?>
			</a>
		</footer>
	</li>
	<?php
}

/**
 * One desktop table row.
 *
 * @param array<string, mixed> $ctx Row context.
 */
function restwell_crm_render_enquiry_table_row( array $ctx ): void {
	$row = $ctx['row'];
	?>
	<tr<?php echo $row->is_urgent ? ' class="rw-row--urgent"' : ''; ?>>
		<th scope="row" class="check-column">
			<input type="checkbox" name="rw_bulk_ids[]" value="<?php echo esc_attr( (string) $row->id ); ?>">
		</th>
		<td class="column-rw-flag">
			<?php restwell_crm_render_enquiry_flags( $ctx ); ?>
		</td>
		<td class="column-rw-name">
			<strong><a href="<?php echo esc_url( $ctx['detail_url'] ); ?>"><?php echo esc_html( $row->name ); ?></a></strong>
			<?php if ( $row->staff_notes ) : ?>
				<br><span class="rw-staff-note-preview">
					&#128221; <?php echo esc_html( wp_trim_words( $row->staff_notes, 10 ) ); ?>
				</span>
			<?php endif; ?>
		</td>
		<td class="column-rw-contact">
			<a class="rw-tap-link" href="mailto:<?php echo esc_attr( $row->email ); ?>"><?php echo esc_html( $row->email ); ?></a>
			<?php if ( $row->phone ) : ?>
				<br>
				<a class="rw-tap-link" href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', $row->phone ) ); ?>">
					<?php echo esc_html( $row->phone ); ?>
				</a>
			<?php endif; ?>
		</td>
		<td class="column-rw-marketing rw-text-meta">
			<?php if ( ! empty( $row->marketing_optin ) ) : ?>
				<span class="rw-badge rw-badge--optin"><?php esc_html_e( 'Opted in', 'restwell-retreats' ); ?></span>
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
				<br><span class="rw-text-muted-sm"><?php echo esc_html( $row->num_guests ); ?> <?php esc_html_e( 'guests', 'restwell-retreats' ); ?></span>
			<?php endif; ?>
			<?php if ( ! $row->preferred_dates && ! $row->num_guests ) : ?>
				<span class="rw-text-dim">-</span>
			<?php endif; ?>
		</td>
		<td class="column-rw-status">
			<div
				class="rw-status-badge"
				data-enquiry-id="<?php echo esc_attr( (string) $row->id ); ?>"
				data-status-key="<?php echo esc_attr( (string) $row->status ); ?>"
			>
				<?php echo restwell_crm_status_badge( (string) $row->status ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			</div>
			<div class="rw-status-actions">
				<a class="rw-details-link" href="<?php echo esc_url( $ctx['detail_url'] ); ?>">
					<?php esc_html_e( 'Open details', 'restwell-retreats' ); ?>
				</a>
			</div>
		</td>
		<td class="column-rw-received rw-text-meta">
			<?php echo esc_html( date_i18n( 'j M Y', strtotime( $row->submitted_at ) ) ); ?>
			<br><?php echo esc_html( date_i18n( 'H:i', strtotime( $row->submitted_at ) ) ); ?>
			<?php if ( $ctx['is_overdue'] ) : ?>
				<br><span class="rw-follow-up-hint">
					&#9201; <?php echo esc_html( date_i18n( 'j M', strtotime( $row->follow_up_at ) ) ); ?>
				</span>
			<?php endif; ?>
		</td>
	</tr>
	<?php
}

/**
 * Pagination controls shared by mobile cards and desktop table.
 *
 * @param array<string, mixed> $list List data.
 */
function restwell_crm_render_enquiries_pagination( array $list ): void {
	$total        = (int) $list['total'];
	$total_pages  = (int) $list['total_pages'];
	$current_page = (int) $list['current_page'];
	$base_url     = $list['base_url'];

	if ( $total_pages <= 1 ) {
		return;
	}

	$prev_page = $current_page > 1 ? $current_page - 1 : null;
	$next_page = $current_page < $total_pages ? $current_page + 1 : null;
	?>
	<nav class="rw-enquiries-pagination" aria-label="<?php esc_attr_e( 'Enquiries pagination', 'restwell-retreats' ); ?>">
		<span class="rw-enquiries-pagination__count">
			<?php
			printf(
				/* translators: %d: number of items */
				esc_html__( '%d items', 'restwell-retreats' ),
				(int) $total
			);
			?>
		</span>
		<div class="rw-enquiries-pagination__compact">
			<?php if ( $prev_page ) : ?>
				<a
					class="rw-enquiries-pagination__btn rw-enquiries-pagination__prev"
					href="<?php echo esc_url( add_query_arg( restwell_crm_list_preserve_args( $list, array( 'paged' => $prev_page ) ), $base_url ) ); ?>"
				>
					<?php esc_html_e( 'Previous', 'restwell-retreats' ); ?>
				</a>
			<?php else : ?>
				<span class="rw-enquiries-pagination__btn rw-enquiries-pagination__prev rw-enquiries-pagination__prev--disabled" aria-disabled="true">
					<?php esc_html_e( 'Previous', 'restwell-retreats' ); ?>
				</span>
			<?php endif; ?>
			<span class="rw-enquiries-pagination__position">
				<?php
				printf(
					/* translators: 1: current page, 2: total pages */
					esc_html__( 'Page %1$d of %2$d', 'restwell-retreats' ),
					(int) $current_page,
					(int) $total_pages
				);
				?>
			</span>
			<?php if ( $next_page ) : ?>
				<a
					class="rw-enquiries-pagination__btn rw-enquiries-pagination__next"
					href="<?php echo esc_url( add_query_arg( restwell_crm_list_preserve_args( $list, array( 'paged' => $next_page ) ), $base_url ) ); ?>"
				>
					<?php esc_html_e( 'Next', 'restwell-retreats' ); ?>
				</a>
			<?php else : ?>
				<span class="rw-enquiries-pagination__btn rw-enquiries-pagination__next rw-enquiries-pagination__next--disabled" aria-disabled="true">
					<?php esc_html_e( 'Next', 'restwell-retreats' ); ?>
				</span>
			<?php endif; ?>
		</div>
		<div class="rw-enquiries-pagination__pages">
			<?php for ( $p = 1; $p <= $total_pages; $p++ ) : ?>
				<a
					class="button<?php echo $p === $current_page ? ' button-primary' : ''; ?>"
					href="<?php echo esc_url( add_query_arg( restwell_crm_list_preserve_args( $list, array( 'paged' => $p ) ), $base_url ) ); ?>"
					<?php echo $p === $current_page ? ' aria-current="page"' : ''; ?>
				>
					<?php echo esc_html( (string) $p ); ?>
				</a>
			<?php endfor; ?>
		</div>
	</nav>
	<?php
}
