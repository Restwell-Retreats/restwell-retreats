<?php
/**
 * Guest Guide CRM: scheduled guest table.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render the scheduled guest emails table.
 *
 * @param array  $guests     Guest rows.
 * @param string $admin_post admin-post.php URL.
 */
function restwell_gg_admin_render_guest_list( $guests, $admin_post ) {
	?>
		<!-- ================================================================ -->
		<!-- Guest list                                                        -->
		<!-- ================================================================ -->
		<h2><?php esc_html_e( 'Scheduled guest emails', 'restwell-retreats' ); ?></h2>
		<p class="description rw-lead">
			<?php esc_html_e( 'Add each confirmed guest. The invitation email is sent automatically at the scheduled date and time, or you can send it manually at any time. Only guests in this table can access the arrival guide.', 'restwell-retreats' ); ?>
		</p>

		<?php if ( empty( $guests ) ) : ?>
			<p class="rw-empty-copy"><?php esc_html_e( 'No guests yet. Add one using the form below.', 'restwell-retreats' ); ?></p>
		<?php else : ?>
		<div class="rw-table-shell rw-table-shell--guest-guide">
		<table class="widefat striped rw-guest-guide-table">
			<thead>
				<tr>
					<th scope="col" class="column-name"><?php esc_html_e( 'Name', 'restwell-retreats' ); ?></th>
					<th scope="col" class="column-email"><?php esc_html_e( 'Email', 'restwell-retreats' ); ?></th>
					<th scope="col" class="column-enquiry"><?php esc_html_e( 'Enquiry', 'restwell-retreats' ); ?></th>
					<th scope="col" class="column-scheduled"><?php esc_html_e( 'Scheduled send', 'restwell-retreats' ); ?></th>
					<th scope="col" class="column-status"><?php esc_html_e( 'Status', 'restwell-retreats' ); ?></th>
					<th scope="col" class="column-actions"><?php esc_html_e( 'Actions', 'restwell-retreats' ); ?></th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach ( $guests as $guest ) :
				// send_date is stored as a MySQL datetime in site-local time.
				if ( ! empty( $guest['send_date'] ) ) {
					$formatted_date = esc_html( date_i18n( 'j M Y, g:i a', strtotime( $guest['send_date'] ) ) );
				} else {
					$formatted_date = '-';
				}

				if ( ! empty( $guest['sent_at'] ) ) {
					$status_label = '<span class="rw-status-sent">&#10003; ' . esc_html__( 'Sent', 'restwell-retreats' ) . '</span>'
						. '<br><small>'
						. esc_html( date_i18n( 'j M Y, g:i a', strtotime( $guest['sent_at'] ) ) )
						. '</small>';
					$send_btn_label = esc_html__( 'Resend', 'restwell-retreats' );
				} else {
					$now_local = current_time( 'mysql' );
					if ( ! empty( $guest['send_date'] ) && $guest['send_date'] > $now_local ) {
						$status_label = '<span class="rw-status-scheduled">' . esc_html__( 'Scheduled', 'restwell-retreats' ) . '</span>';
					} else {
						$status_label = '<span class="rw-status-pending">' . esc_html__( 'Pending', 'restwell-retreats' ) . '</span>';
					}
					$send_btn_label = esc_html__( 'Send now', 'restwell-retreats' );
				}
				?>
				<tr>
					<td class="column-name" data-label="<?php echo esc_attr__( 'Name', 'restwell-retreats' ); ?>">
						<?php echo esc_html( restwell_first_nonempty_string( $guest['name'] ?? '', '-' ) ); ?>
					</td>
					<td class="column-email" data-label="<?php echo esc_attr__( 'Email', 'restwell-retreats' ); ?>">
						<?php if ( ! empty( $guest['email'] ) ) : ?>
							<a class="rw-cell-email rw-tap-link" href="<?php echo esc_url( 'mailto:' . $guest['email'] ); ?>">
								<?php echo esc_html( $guest['email'] ); ?>
							</a>
						<?php else : ?>
							<span class="rw-text-dim">&ndash;</span>
						<?php endif; ?>
					</td>
					<?php
					$enq_id = isset( $guest['enquiry_id'] ) ? absint( $guest['enquiry_id'] ) : 0;
					?>
					<td class="column-enquiry<?php echo $enq_id > 0 ? '' : ' rw-cell--empty'; ?>" data-label="<?php echo esc_attr__( 'Enquiry', 'restwell-retreats' ); ?>">
						<?php
						if ( $enq_id > 0 ) :
							$enq_url = add_query_arg(
								array(
									'page' => 'restwell-enquiries',
									'view' => $enq_id,
								),
								admin_url( 'admin.php' )
							);
							?>
							<a href="<?php echo esc_url( $enq_url ); ?>">
								<?php
								echo esc_html(
									sprintf(
										/* translators: %d: enquiry ID */
										__( '#%d', 'restwell-retreats' ),
										$enq_id
									)
								);
								?>
							</a>
						<?php else : ?>
							<span class="rw-text-dim">&ndash;</span>
						<?php endif; ?>
					</td>
					<td class="column-scheduled" data-label="<?php echo esc_attr__( 'Scheduled send', 'restwell-retreats' ); ?>">
						<?php echo esc_html( $formatted_date ); ?>
					</td>
					<td class="column-status" data-label="<?php echo esc_attr__( 'Status', 'restwell-retreats' ); ?>">
						<?php
						echo wp_kses(
							$status_label,
							array(
								'span'  => array( 'class' => array() ),
								'br'    => array(),
								'small' => array(),
							)
						);
						?>
					</td>
					<td class="column-actions rw-action-cell" data-label="<?php echo esc_attr__( 'Actions', 'restwell-retreats' ); ?>">
						<div class="rw-action-cell-inner">
						<!-- Send now / Resend -->
						<form method="post" action="<?php echo esc_url( $admin_post ); ?>">
							<?php wp_nonce_field( 'restwell_gg_send_now' ); ?>
							<input type="hidden" name="action" value="restwell_gg_send_now" />
							<input type="hidden" name="gg_guest_id" value="<?php echo esc_attr( $guest['id'] ); ?>" />
							<button type="submit" class="button button-secondary button-small">
								<?php echo esc_html( $send_btn_label ); ?>
							</button>
						</form>
						<a
							class="button button-link button-small rw-gg-preview-link"
							href="
							<?php
							echo esc_url(
								add_query_arg(
									array(
										'page' => 'restwell-guest-guide',
										'preview_guest' => $guest['id'],
									),
									admin_url( 'admin.php' )
								) . '#rw-gg-email-preview'
							);
							?>
									"
						>
							<?php esc_html_e( 'View email', 'restwell-retreats' ); ?>
						</a>
						<!-- Delete -->
						<form method="post" action="<?php echo esc_url( $admin_post ); ?>"
							  onsubmit="return confirm('<?php echo esc_js( __( 'Remove this guest?', 'restwell-retreats' ) ); ?>')">
							<?php wp_nonce_field( 'restwell_gg_delete_guest' ); ?>
							<input type="hidden" name="action" value="restwell_gg_delete_guest" />
							<input type="hidden" name="gg_guest_id" value="<?php echo esc_attr( $guest['id'] ); ?>" />
							<button type="submit" class="button button-link-delete button-small">
								<?php esc_html_e( 'Delete', 'restwell-retreats' ); ?>
							</button>
						</form>
						</div>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		</div>
		<?php endif; ?>

	<?php
}
