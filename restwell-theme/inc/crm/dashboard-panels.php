<?php
/**
 * CRM dashboard: notices, stat tiles, follow-ups, booked-without-guide.
 *
 * @package Restwell_CRM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Flash notices after settings save / Mailchimp block / SMTP test.
 */
function restwell_crm_dashboard_render_notices() {
	?>
		<?php if ( isset( $_GET['settings_saved'] ) && absint( wp_unslash( $_GET['settings_saved'] ) ) ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Settings saved.', 'restwell-retreats' ); ?></p></div>
		<?php endif; ?>
		<?php if ( isset( $_GET['mailchimp_key_blocked'] ) && absint( wp_unslash( $_GET['mailchimp_key_blocked'] ) ) ) : ?>
			<div class="notice notice-warning is-dismissible"><p><?php esc_html_e( 'The Mailchimp API key was not saved. On production it must live in RESTWELL_MAILCHIMP_API_KEY (wp-config or the environment), not in the database.', 'restwell-retreats' ); ?></p></div>
		<?php endif; ?>
		<?php
		$smtp_test = isset( $_GET['smtp_test'] ) ? sanitize_key( wp_unslash( $_GET['smtp_test'] ) ) : '';
		if ( 'ok' === $smtp_test ) :
			?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Test email handed to wp_mail. Check the notify inbox, or Mailpit on Local.', 'restwell-retreats' ); ?></p></div>
		<?php elseif ( 'fail' === $smtp_test ) : ?>
			<div class="notice notice-error is-dismissible"><p><?php esc_html_e( 'wp_mail returned false. Check SMTP constants or the mail log.', 'restwell-retreats' ); ?></p></div>
		<?php elseif ( 'rate' === $smtp_test ) : ?>
			<div class="notice notice-warning is-dismissible"><p><?php esc_html_e( 'Wait five minutes before sending another test email.', 'restwell-retreats' ); ?></p></div>
		<?php elseif ( 'no_recipient' === $smtp_test ) : ?>
			<div class="notice notice-error is-dismissible"><p><?php esc_html_e( 'Set a notify email (or a WordPress admin email) before sending a test.', 'restwell-retreats' ); ?></p></div>
		<?php endif; ?>

	<?php
}

/**
 * Summary metric tiles.
 *
 * @param int    $stat_new_week   New enquiries this week.
 * @param int    $stat_total      Total enquiries.
 * @param int    $stat_urgent     Urgent uncontacted count.
 * @param int    $stat_follow_ups Overdue follow-ups.
 * @param string $week_ago        MySQL datetime for the week window.
 * @param string $enquiries_url   Enquiries admin URL.
 */
function restwell_crm_dashboard_render_stat_tiles( $stat_new_week, $stat_total, $stat_urgent, $stat_follow_ups, $week_ago, $enquiries_url ) {
	$tiles = array(
		array(
			'label' => __( 'New this week', 'restwell-retreats' ),
			'value' => $stat_new_week,
			'color' => '#2271b1',
			// Links to all enquiries submitted in the last 7 days, matching the count's SQL.
			'url'   => add_query_arg( 'submitted_since', $week_ago, $enquiries_url ),
		),
		array(
			'label' => __( 'Total enquiries', 'restwell-retreats' ),
			'value' => $stat_total,
			'color' => '#3c434a',
			'url'   => $enquiries_url,
		),
		array(
			'label' => __( 'Urgent & uncontacted', 'restwell-retreats' ),
			'value' => $stat_urgent,
			'color' => '#d63638',
			// Both filters must match the SQL: is_urgent = 1 AND status = 'new'.
			'url'   => add_query_arg(
				array(
					'status_filter' => 'new',
					'urgent_filter' => '1',
				),
				$enquiries_url
			),
		),
		array(
			'label' => __( 'Follow-ups overdue', 'restwell-retreats' ),
			'value' => $stat_follow_ups,
			'color' => '#996800',
			// Filter matches the SQL: follow_up_at <= now AND status != 'closed'.
			'url'   => add_query_arg( 'follow_up_filter', 'overdue', $enquiries_url ),
		),
	);
	?>
	<div class="rw-stat-grid" role="list" aria-label="<?php esc_attr_e( 'Dashboard summary metrics', 'restwell-retreats' ); ?>">
		<?php foreach ( $tiles as $tile ) : ?>
		<a href="<?php echo esc_url( $tile['url'] ); ?>" class="rw-stat-tile" role="listitem" style="--rw-tile-accent:<?php echo esc_attr( $tile['color'] ); ?>;">
			<div class="rw-stat-value"><?php echo esc_html( $tile['value'] ); ?></div>
			<div class="rw-stat-label"><?php echo esc_html( $tile['label'] ); ?></div>
		</a>
		<?php endforeach; ?>
	</div>
	<?php
}

/**
 * Shortcut buttons to Enquiries, Guest Guide, and mailing list.
 *
 * @param string $enquiries_url Enquiries admin URL.
 */
function restwell_crm_dashboard_render_quicklinks( string $enquiries_url ) {
	?>
		<nav class="rw-dash-quicklinks" aria-label="<?php esc_attr_e( 'CRM shortcuts', 'restwell-retreats' ); ?>">
			<a class="button button-secondary" href="<?php echo esc_url( $enquiries_url ); ?>"><?php esc_html_e( 'Enquiries', 'restwell-retreats' ); ?></a>
			<a class="button button-secondary" href="<?php echo esc_url( admin_url( 'admin.php?page=restwell-guest-guide' ) ); ?>"><?php esc_html_e( 'Guest Guide', 'restwell-retreats' ); ?></a>
			<a class="button button-secondary" href="<?php echo esc_url( admin_url( 'admin.php?page=restwell-mailing-list' ) ); ?>"><?php esc_html_e( 'Mailing list', 'restwell-retreats' ); ?></a>
		</nav>

	<?php
}

/**
 * Overdue follow-up table.
 *
 * @param array<int, object>|null $follow_up_rows Rows.
 * @param string                  $enquiries_url  Enquiries admin URL.
 */
function restwell_crm_dashboard_render_follow_ups( $follow_up_rows, string $enquiries_url ) {
	?>
			<!-- Follow-ups due -->
			<section class="rw-dash-panel">
				<h2 class="rw-dash-panel__title"><?php esc_html_e( 'Follow-ups due', 'restwell-retreats' ); ?></h2>
				<div class="rw-dash-panel__body">
					<?php if ( empty( $follow_up_rows ) ) : ?>
						<p class="rw-empty"><?php esc_html_e( 'No overdue follow-ups. Nice work.', 'restwell-retreats' ); ?></p>
						<p class="rw-dash-panel__action">
							<a class="button button-secondary" href="<?php echo esc_url( $enquiries_url ); ?>"><?php esc_html_e( 'Open enquiries', 'restwell-retreats' ); ?></a>
						</p>
					<?php else : ?>
						<table class="widefat striped rw-dashboard-table">
							<thead>
								<tr>
									<th><?php esc_html_e( 'Name', 'restwell-retreats' ); ?></th>
									<th><?php esc_html_e( 'Status', 'restwell-retreats' ); ?></th>
									<th><?php esc_html_e( 'Due', 'restwell-retreats' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ( $follow_up_rows as $r ) : ?>
									<tr>
										<td data-label="<?php echo esc_attr__( 'Name', 'restwell-retreats' ); ?>">
											<a class="rw-tap-link" href="
											<?php
											echo esc_url(
												add_query_arg(
													array(
														'page' => 'restwell-enquiries',
														'view' => $r->id,
													),
													admin_url( 'admin.php' )
												)
											);
											?>
																			">
												<?php echo esc_html( $r->name ); ?>
											</a>
										</td>
										<td data-label="<?php echo esc_attr__( 'Status', 'restwell-retreats' ); ?>"><?php echo restwell_crm_status_badge( $r->status ); // phpcs:ignore WordPress.Security.EscapeOutput ?></td>
										<td class="rw-table-meta" data-label="<?php echo esc_attr__( 'Due', 'restwell-retreats' ); ?>">
											<?php echo esc_html( date_i18n( 'j M Y', strtotime( $r->follow_up_at ) ) ); ?>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					<?php endif; ?>
				</div>
			</section>

	<?php
}

/**
 * Booked enquiries with no Guest Guide invitation.
 *
 * @param array<int, object>|null $booked_without_guide Rows.
 */
function restwell_crm_dashboard_render_booked_without_guide( $booked_without_guide ) {
	?>
			<!-- Booked without guide -->
			<section class="rw-dash-panel">
				<h2 class="rw-dash-panel__title"><?php esc_html_e( 'Booked; guide not sent', 'restwell-retreats' ); ?></h2>
				<div class="rw-dash-panel__body">
					<?php if ( empty( $booked_without_guide ) ) : ?>
						<p class="rw-empty"><?php esc_html_e( 'All booked guests have a guide invitation.', 'restwell-retreats' ); ?></p>
						<p class="rw-dash-panel__action">
							<a class="button button-secondary" href="<?php echo esc_url( admin_url( 'admin.php?page=restwell-guest-guide' ) ); ?>"><?php esc_html_e( 'Open Guest Guide', 'restwell-retreats' ); ?></a>
						</p>
					<?php else : ?>
						<table class="widefat striped rw-dashboard-table">
							<thead>
								<tr>
									<th><?php esc_html_e( 'Name', 'restwell-retreats' ); ?></th>
									<th><?php esc_html_e( 'Dates', 'restwell-retreats' ); ?></th>
									<th><?php esc_html_e( 'Action', 'restwell-retreats' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ( $booked_without_guide as $r ) : ?>
									<?php
									$promote_url = add_query_arg(
										array(
											'page'               => 'restwell-guest-guide',
											'prefill_name'       => rawurlencode( $r->name ),
											'prefill_email'      => rawurlencode( $r->email ),
											'prefill_enquiry_id' => $r->id,
										),
										admin_url( 'admin.php' )
									);
									?>
									<tr>
										<td data-label="<?php echo esc_attr__( 'Name', 'restwell-retreats' ); ?>">
											<a class="rw-tap-link" href="
											<?php
											echo esc_url(
												add_query_arg(
													array(
														'page' => 'restwell-enquiries',
														'view' => $r->id,
													),
													admin_url( 'admin.php' )
												)
											);
											?>
																			">
												<?php echo esc_html( $r->name ); ?>
											</a>
										</td>
										<td class="rw-table-meta" data-label="<?php echo esc_attr__( 'Dates', 'restwell-retreats' ); ?>"><?php echo esc_html( restwell_first_nonempty_string( $r->preferred_dates ?? '', '-' ) ); ?></td>
										<td data-label="<?php echo esc_attr__( 'Action', 'restwell-retreats' ); ?>">
											<a href="<?php echo esc_url( $promote_url ); ?>" class="button button-small rw-tap-button">
												<?php esc_html_e( 'Add to Guide', 'restwell-retreats' ); ?>
											</a>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					<?php endif; ?>
				</div>
			</section>

	<?php
}
