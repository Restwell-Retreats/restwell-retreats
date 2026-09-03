<?php
/**
 * CRM single-enquiry detail view.
 *
 * @package Restwell_CRM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
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
	$row = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM %i WHERE id = %d', $table, $id ) );

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
		$follow_up_value = wp_date( 'Y-m-d\TH:i', strtotime( $row->follow_up_at ) );
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
		<?php
		$stay_dates_error = isset( $_GET['stay_dates_error'] )
			? sanitize_key( wp_unslash( $_GET['stay_dates_error'] ) )
			: '';
		?>
		<?php if ( $stay_dates_error !== '' ) : ?>
			<div class="notice notice-error is-dismissible">
				<p>
					<?php
					// Two distinct error reasons get two distinct messages so staff
					// know exactly what to fix without guessing.
					if ( 'order' === $stay_dates_error ) {
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
			<?php restwell_crm_render_enquiry_main( $row, $promote_url ); ?>

			<!-- ── Right: status, notes, actions ────────────────────────── -->
			<?php restwell_crm_render_enquiry_sidebar( $row, $notes, $statuses, $follow_up_value, $mailto, $promote_url ); ?>

		</div><!-- grid -->
	</div><!-- .wrap -->
	<?php
}

/**
 * Left column of the enquiry detail view: contact info, guest-guide link,
 * booking summary, editable stay-dates form, and the free-text fields.
 *
 * @param object $row         Enquiry row from the database.
 * @param string $promote_url "Add to Guest Guide" prefilled URL.
 */
function restwell_crm_render_enquiry_main( $row, string $promote_url ) {
	?>
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
						if ( ! empty( $row->privacy_consented_at ) ) {
							$privacy_stamp = date_i18n( 'j M Y, H:i', strtotime( (string) $row->privacy_consented_at ) );
							$policy_ver    = isset( $row->privacy_policy_version ) ? trim( (string) $row->privacy_policy_version ) : '';
							$contact_fields[ __( 'Privacy consent', 'restwell-retreats' ) ] = esc_html(
								$policy_ver
									? sprintf(
										/* translators: 1: datetime, 2: policy version */
										__( 'Yes — %1$s (policy %2$s)', 'restwell-retreats' ),
										$privacy_stamp,
										$policy_ver
									)
									: sprintf(
										/* translators: %s: datetime */
										__( 'Yes — %s', 'restwell-retreats' ),
										$privacy_stamp
									)
							);
						}
						if ( ! empty( $row->health_data_consent ) ) {
							$health_stamp = ! empty( $row->health_data_consented_at )
								? date_i18n( 'j M Y, H:i', strtotime( (string) $row->health_data_consented_at ) )
								: '';
							$health_policy = isset( $row->privacy_policy_version ) ? trim( (string) $row->privacy_policy_version ) : '';
							if ( $health_stamp && $health_policy ) {
								$contact_fields[ __( 'Health-data consent', 'restwell-retreats' ) ] = esc_html(
									sprintf(
										/* translators: 1: datetime, 2: policy version */
										__( 'Yes — care/accessibility notes — %1$s (policy %2$s)', 'restwell-retreats' ),
										$health_stamp,
										$health_policy
									)
								);
							} elseif ( $health_stamp ) {
								$contact_fields[ __( 'Health-data consent', 'restwell-retreats' ) ] = esc_html(
									sprintf(
										/* translators: %s: datetime */
										__( 'Yes — care/accessibility notes — %s', 'restwell-retreats' ),
										$health_stamp
									)
								);
							} else {
								$contact_fields[ __( 'Health-data consent', 'restwell-retreats' ) ] = esc_html__( 'Yes — care/accessibility notes', 'restwell-retreats' );
							}
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

						<?php
						$gg_guest = function_exists( 'restwell_get_guest_by_email' )
							? restwell_get_guest_by_email( (string) $row->email )
							: null;
						?>
						<h3 class="rw-detail-section-title"><?php esc_html_e( 'Guest guide', 'restwell-retreats' ); ?></h3>
						<?php if ( $gg_guest ) : ?>
							<table class="form-table rw-readonly-table" role="presentation">
								<tr>
									<th scope="row"><?php esc_html_e( 'Guest row', 'restwell-retreats' ); ?></th>
									<td>
										<a href="<?php echo esc_url( admin_url( 'admin.php?page=restwell-guest-guide' ) ); ?>">
											<?php
											echo esc_html(
												sprintf(
													/* translators: %d: guest row ID */
													__( 'Guest #%d', 'restwell-retreats' ),
													(int) $gg_guest->id
												)
											);
											?>
										</a>
									</td>
								</tr>
								<tr>
									<th scope="row"><?php esc_html_e( 'Invitation', 'restwell-retreats' ); ?></th>
									<td>
										<?php
										if ( ! empty( $gg_guest->sent_at ) ) {
											echo esc_html(
												sprintf(
													/* translators: %s: date/time */
													__( 'Sent %s', 'restwell-retreats' ),
													date_i18n( 'j M Y, H:i', strtotime( (string) $gg_guest->sent_at ) )
												)
											);
										} else {
											esc_html_e( 'Not sent yet', 'restwell-retreats' );
										}
										?>
									</td>
								</tr>
								<tr>
									<th scope="row"><?php esc_html_e( 'Guide read', 'restwell-retreats' ); ?></th>
									<td>
										<?php
										if ( ! empty( $gg_guest->confirmed_at ) ) {
											echo esc_html(
												sprintf(
													/* translators: %s: date/time */
													__( 'Confirmed %s', 'restwell-retreats' ),
													date_i18n( 'j M Y, H:i', strtotime( (string) $gg_guest->confirmed_at ) )
												)
											);
										} else {
											esc_html_e( 'Not confirmed yet', 'restwell-retreats' );
										}
										?>
									</td>
								</tr>
							</table>
						<?php else : ?>
							<p class="description">
								<?php esc_html_e( 'No guest-guide row for this email yet.', 'restwell-retreats' ); ?>
								<?php if ( 'booked' === $row->status ) : ?>
									<a href="<?php echo esc_url( $promote_url ); ?>"><?php esc_html_e( 'Add to Guest Guide', 'restwell-retreats' ); ?></a>
								<?php endif; ?>
							</p>
						<?php endif; ?>

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
						$stay_to   = $row->date_to ? esc_attr( $row->date_to ) : '';
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
							printf(
								/* translators: %s: formatted date */
								esc_html__( 'Submitted %s', 'restwell-retreats' ),
								esc_html( date_i18n( 'j F Y \a\t H:i', strtotime( $row->submitted_at ) ) )
							);
							?>
						</p>

					</div><!-- .inside -->
				</div><!-- .postbox -->
			</div>
	<?php
}

/**
 * Right column of the enquiry detail view: status/follow-up form, staff
 * notes, activity log, and the quick-contact / promote / post-stay actions.
 *
 * @param object $row              Enquiry row from the database.
 * @param array  $notes            Activity log rows for this enquiry.
 * @param array  $statuses         Status slug => info map.
 * @param string $follow_up_value  Follow-up date formatted for datetime-local input.
 * @param string $mailto           Pre-filled mailto: link.
 * @param string $promote_url      "Add to Guest Guide" prefilled URL.
 */
function restwell_crm_render_enquiry_sidebar( $row, array $notes, array $statuses, string $follow_up_value, string $mailto, string $promote_url ) {
	?>
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
								<?php
								foreach ( $notes as $note ) :
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
	<?php
}
