<?php
/**
 * Guest Guide CRM: invitation preview, add-guest form, CC addresses.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Invitation email preview (not sent).
 *
 * @param array|null $preview_mail Built preview or null.
 * @param array      $preview_ctx  Label / sample flag.
 * @param bool       $preview_open Whether the details element should be open.
 * @param string     $raw_cc       Raw CC option value.
 */
function restwell_gg_admin_render_email_preview( $preview_mail, $preview_ctx, $preview_open, $raw_cc ) {
	?>
		<?php if ( $preview_mail ) : ?>
			<details
				id="rw-gg-email-preview"
				class="rw-email-preview"
				<?php echo $preview_open ? ' open' : ''; ?>
			>
				<summary class="rw-email-preview__summary">
					<?php esc_html_e( 'View invitation email', 'restwell-retreats' ); ?>
				</summary>
				<div class="rw-email-preview__body">
					<p class="description rw-email-preview__meta">
						<?php
						echo esc_html(
							sprintf(
								/* translators: %s: guest name or sample label */
								__( 'Not sent. This is the HTML for: %s', 'restwell-retreats' ),
								$preview_ctx['label']
							)
						);
						if ( $preview_ctx['is_sample'] ) {
							echo ' ';
							esc_html_e( '(sample: add a guest or use View email on a row for a real name.)', 'restwell-retreats' );
						}
						?>
					</p>
					<div class="rw-email-preview__meta-card">
						<p class="rw-email-preview__subject">
							<span class="rw-email-preview__label"><?php esc_html_e( 'Subject', 'restwell-retreats' ); ?></span>
							<span class="rw-email-preview__value"><?php echo esc_html( $preview_mail['subject'] ); ?></span>
						</p>
						<?php
						$cc_preview = array_filter( array_map( 'trim', explode( "\n", $raw_cc ) ) );
						if ( ! empty( $cc_preview ) ) :
							?>
							<p class="rw-email-preview__cc">
								<span class="rw-email-preview__label"><?php esc_html_e( 'CC', 'restwell-retreats' ); ?></span>
								<span class="rw-email-preview__value"><?php echo esc_html( implode( ', ', $cc_preview ) ); ?></span>
							</p>
						<?php endif; ?>
					</div>
					<div class="rw-email-preview__viewport">
						<iframe
							class="rw-email-preview__frame"
							title="<?php echo esc_attr__( 'Invitation email preview', 'restwell-retreats' ); ?>"
							sandbox=""
							srcdoc="<?php echo esc_attr( $preview_mail['body'] ); ?>"
						></iframe>
					</div>
				</div>
			</details>
		<?php endif; ?>

	<?php
}

/**
 * Add-guest form, optionally prefilled from an enquiry.
 *
 * @param string $admin_post          admin-post.php URL.
 * @param string $prefill_name        Name from enquiry.
 * @param string $prefill_email       Email from enquiry.
 * @param int    $prefill_enquiry_id  Enquiry ID.
 */
function restwell_gg_admin_render_add_guest_form( $admin_post, $prefill_name, $prefill_email, $prefill_enquiry_id ) {
	?>
		<!-- Add guest form -->
		<h3 class="rw-subsection-title">
			<?php
			echo $prefill_name
				? sprintf(
					/* translators: %s: enquirer name */
					esc_html__( 'Add a guest (pre-filled from enquiry: %s)', 'restwell-retreats' ),
					'<strong>' . esc_html( $prefill_name ) . '</strong>'
				)
				: esc_html__( 'Add a guest', 'restwell-retreats' );
			?>
		</h3>
		<form method="post" action="<?php echo esc_url( $admin_post ); ?>" class="rw-settings-wrap">
			<?php wp_nonce_field( 'restwell_gg_add_guest' ); ?>
			<input type="hidden" name="action" value="restwell_gg_add_guest" />
			<?php if ( $prefill_enquiry_id ) : ?>
				<input type="hidden" name="gg_enquiry_id" value="<?php echo esc_attr( $prefill_enquiry_id ); ?>" />
			<?php endif; ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row">
						<label for="gg_name"><?php esc_html_e( 'Guest name', 'restwell-retreats' ); ?></label>
					</th>
					<td>
						<input type="text" id="gg_name" name="gg_name" class="regular-text"
							   value="<?php echo esc_attr( $prefill_name ); ?>"
							   placeholder="<?php esc_attr_e( 'Jane Smith', 'restwell-retreats' ); ?>" />
						<p class="description"><?php esc_html_e( 'Optional; used in the invitation email greeting.', 'restwell-retreats' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="gg_email"><?php esc_html_e( 'Email address', 'restwell-retreats' ); ?> <span class="rw-required" aria-hidden="true">*</span></label>
					</th>
					<td>
						<input type="email" id="gg_email" name="gg_email" class="regular-text" required
							   value="<?php echo esc_attr( $prefill_email ); ?>"
							   placeholder="jane@example.com" />
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="gg_send_date"><?php esc_html_e( 'Scheduled send', 'restwell-retreats' ); ?> <span class="rw-required" aria-hidden="true">*</span></label>
					</th>
					<td>
						<input type="datetime-local" id="gg_send_date" name="gg_send_date" class="regular-text" required />
						<p class="description">
							<?php esc_html_e( 'The invitation email will be sent automatically at this date and time. You can also send it immediately with "Send now" after adding.', 'restwell-retreats' ); ?>
						</p>
					</td>
				</tr>
			</table>
			<?php submit_button( __( 'Add guest', 'restwell-retreats' ), 'secondary', 'submit', false ); ?>
		</form>

	<?php
}

/**
 * CC address settings form.
 *
 * @param string $admin_post admin-post.php URL.
 * @param string $raw_cc     Current CC option.
 */
function restwell_gg_admin_render_cc_form( $admin_post, $raw_cc ) {
	?>
		<hr class="rw-section-rule" />

		<!-- ================================================================ -->
		<!-- CC email addresses                                                -->
		<!-- ================================================================ -->
		<h2><?php esc_html_e( 'Invitation email: CC addresses', 'restwell-retreats' ); ?></h2>
		<p class="description rw-lead">
			<?php esc_html_e( 'Every invitation email will CC these addresses. One address per line.', 'restwell-retreats' ); ?>
		</p>
		<form method="post" action="<?php echo esc_url( $admin_post ); ?>" class="rw-settings-wrap">
			<?php wp_nonce_field( 'restwell_gg_save_cc' ); ?>
			<input type="hidden" name="action" value="restwell_gg_save_cc" />
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row">
						<label for="restwell_guide_cc_emails"><?php esc_html_e( 'CC addresses', 'restwell-retreats' ); ?></label>
					</th>
					<td>
						<textarea
							id="restwell_guide_cc_emails"
							name="restwell_guide_cc_emails"
							rows="5"
							cols="40"
							class="large-text code"
						><?php echo esc_textarea( $raw_cc ); ?></textarea>
					</td>
				</tr>
			</table>
			<?php submit_button( __( 'Save CC addresses', 'restwell-retreats' ), 'secondary', 'submit', false ); ?>
		</form>

	<?php
}
