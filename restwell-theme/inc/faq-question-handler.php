<?php
/**
 * FAQ page “Ask a question” form: validate, persist, notify hello@, redirect with feedback.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Process FAQ question POST before templates run.
 */
function restwell_handle_faq_question_submit(): void {
	if ( 'POST' !== ( $_SERVER['REQUEST_METHOD'] ?? '' ) || ! isset( $_POST['restwell_faq_question'] ) ) {
		return;
	}

	$nonce = isset( $_POST['restwell_faq_question_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['restwell_faq_question_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'restwell_faq_question' ) ) {
		$pid_fail = isset( $_POST['restwell_faq_page_id'] ) ? absint( $_POST['restwell_faq_page_id'] ) : 0;
		$url_fail = $pid_fail ? get_permalink( $pid_fail ) : home_url( '/' );
		restwell_faq_question_redirect_flash(
			$url_fail,
			array( __( 'Security check failed. Please try again.', 'restwell-retreats' ) ),
			array()
		);
		return;
	}

	// Honeypot (label hidden off-screen; bots often fill “website”).
	if ( ! empty( $_POST['faq_q_website'] ) ) {
		$pid = isset( $_POST['restwell_faq_page_id'] ) ? absint( $_POST['restwell_faq_page_id'] ) : 0;
		$url = $pid ? get_permalink( $pid ) : home_url( '/' );
		wp_safe_redirect( add_query_arg( 'question_sent', '1', $url ) . '#faq-question-form' );
		exit;
	}

	if ( restwell_form_timing_suspicious( isset( $_POST['restwell_form_opened_at'] ) ? (string) wp_unslash( $_POST['restwell_form_opened_at'] ) : '' ) ) {
		$pid = isset( $_POST['restwell_faq_page_id'] ) ? absint( $_POST['restwell_faq_page_id'] ) : 0;
		$url = $pid ? get_permalink( $pid ) : home_url( '/' );
		wp_safe_redirect( add_query_arg( 'question_sent', '1', $url ) . '#faq-question-form' );
		exit;
	}

	if ( restwell_form_rate_limit_exceeded( 'faq' ) ) {
		$pid = isset( $_POST['restwell_faq_page_id'] ) ? absint( $_POST['restwell_faq_page_id'] ) : 0;
		$url = $pid ? get_permalink( $pid ) : home_url( '/' );
		restwell_faq_question_redirect_flash(
			$url,
			array( __( 'Too many attempts from your connection. Please wait an hour and try again, or email us directly.', 'restwell-retreats' ) ),
			array()
		);
		return;
	}

	$name    = isset( $_POST['faq_q_name'] ) ? sanitize_text_field( wp_unslash( $_POST['faq_q_name'] ) ) : '';
	$email   = isset( $_POST['faq_q_email'] ) ? sanitize_email( wp_unslash( $_POST['faq_q_email'] ) ) : '';
	$phone_check = restwell_validate_submission_phone(
		isset( $_POST['faq_q_phone'] ) ? (string) wp_unslash( $_POST['faq_q_phone'] ) : ''
	);
	$phone   = $phone_check['phone'];
	$message = isset( $_POST['faq_q_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['faq_q_message'] ) ) : '';
	$marketing_optin = ! empty( $_POST['faq_q_marketing_optin'] );
	$pid     = isset( $_POST['restwell_faq_page_id'] ) ? absint( $_POST['restwell_faq_page_id'] ) : 0;
	$back    = $pid ? get_permalink( $pid ) : home_url( '/' );

	$errors = array();
	if ( '' === $name ) {
		$errors[] = __( 'Please add your name.', 'restwell-retreats' );
	}
	if ( '' === $email || ! is_email( $email ) ) {
		$errors[] = __( 'Please add a valid email address.', 'restwell-retreats' );
	}
	if ( '' !== $phone_check['error'] ) {
		$errors[] = $phone_check['error'];
	}
	if ( '' === $message ) {
		$errors[] = __( 'Please type your question.', 'restwell-retreats' );
	}
	if ( strlen( $message ) > 12000 ) {
		$errors[] = __( 'Your question is too long. Please shorten it slightly.', 'restwell-retreats' );
	}
	if ( empty( $_POST['faq_q_consent'] ) ) {
		$errors[] = __( 'Please confirm we can use this information to reply, as set out in the privacy policy.', 'restwell-retreats' );
	}

	if ( $errors ) {
		restwell_faq_question_redirect_flash(
			$back,
			$errors,
			array(
				'name'    => $name,
				'email'   => $email,
				'phone'   => $phone,
				'message' => $message,
				'marketing_optin' => $marketing_optin ? '1' : '',
				'consent' => empty( $_POST['faq_q_consent'] ) ? '' : '1',
			)
		);
		return;
	}

	$source = $pid ? (string) get_permalink( $pid ) : $back;
	$row_id = restwell_service_crm_gateway()->save_faq_submission(
		array(
			'name'            => $name,
			'email'           => $email,
			'phone'           => $phone,
			'question'        => $message,
			'marketing_optin' => $marketing_optin,
			'privacy_consent' => true,
			'source_url'      => $source,
		)
	);

	if ( $marketing_optin ) {
		$mc_ok = restwell_mailchimp_upsert_marketing_contact(
			$email,
			$name,
			$phone,
			'faq',
			array( 'faq-form' )
		);
		// Persist failure flag so inbox can surface rows that need manual sync.
		if ( ! $mc_ok && $row_id ) {
			restwell_service_crm_gateway()->mark_faq_marketing_sync_failed( (int) $row_id );
		}
	}

	$to       = restwell_get_submission_notify_email();
	$subject  = $row_id
		? restwell_mail_staff_subject( 'faq', (int) $row_id )
		: restwell_mail_staff_subject( 'faq_save_failed' );
	$rows = array(
		__( 'Name', 'restwell-retreats' )  => $name,
		__( 'Email', 'restwell-retreats' ) => $email,
	);
	if ( '' !== trim( (string) $phone ) ) {
		$rows[ __( 'Phone', 'restwell-retreats' ) ] = $phone;
	}
	$rows[ __( 'Marketing updates', 'restwell-retreats' ) ] = $marketing_optin
		? __( 'Yes, opted in', 'restwell-retreats' )
		: __( 'No, not opted in', 'restwell-retreats' );

	$body = restwell_email_staff_body(
		array(
			'label'       => __( 'Question from the FAQ page', 'restwell-retreats' ),
			'heading'     => $row_id
				? sprintf(
					/* translators: %d: submission ID. */
					__( 'Someone asked a question (#%d)', 'restwell-retreats' ),
					(int) $row_id
				)
				: __( 'Someone asked a question', 'restwell-retreats' ),
			'rows'        => $rows,
			'quote'       => (string) $message,
			'quote_label' => __( 'Their question', 'restwell-retreats' ),
			'note'        => $row_id
				? sprintf(
					/* translators: %d: submission ID. */
					__( 'Saved as submission #%d in the site database. Reply to this email to answer them directly.', 'restwell-retreats' ),
					(int) $row_id
				)
				: __( 'This could not be saved to the database, so this email is the only copy. Reply to it to answer them directly.', 'restwell-retreats' ),
			'preview'     => __( 'A new question from the FAQ page', 'restwell-retreats' ),
		)
	);

	$headers = restwell_email_staff_headers( (string) $email );

	if ( ! $row_id ) {
		$sent = restwell_wp_mail_with_retry( $to, $subject, $body, $headers );
		if ( $sent ) {
			wp_safe_redirect( add_query_arg( 'question_sent', '1', $back ) . '#faq-question-form' );
		} else {
			restwell_faq_question_redirect_flash(
				$back,
				array(
					__( 'We could not save your question or send it by email. Please try again in a few minutes, or email hello@restwellretreats.co.uk directly.', 'restwell-retreats' ),
				),
				array()
			);
		}
		exit;
	}

	$sent = restwell_wp_mail_with_retry( $to, $subject, $body, $headers );
	if ( $sent ) {
		restwell_service_crm_gateway()->mark_faq_notify_sent( $row_id );
		wp_safe_redirect( add_query_arg( 'question_sent', '1', $back ) . '#faq-question-form' );
		exit;
	}

	restwell_faq_question_redirect_flash(
		$back,
		array(
			__( 'Your question was saved. We will get back to you soon.', 'restwell-retreats' ),
		),
		array()
	);
}
add_action( 'template_redirect', 'restwell_handle_faq_question_submit', 4 );

/**
 * Store flash data and redirect back to the FAQ form.
 *
 * @param string             $url    Redirect URL.
 * @param array<int, string> $errors Error messages.
 * @param array<string,string> $fields Field repopulation.
 */
function restwell_faq_question_redirect_flash( string $url, array $errors, array $fields ): void {
	$key = wp_generate_password( 12, false, false );
	set_transient(
		'restwell_faq_flash_' . $key,
		array(
			'errors' => $errors,
			'fields' => $fields,
		),
		300
	);
	wp_safe_redirect( add_query_arg( 'faq_flash', rawurlencode( $key ), $url ) . '#faq-question-form' );
	exit;
}

/**
 * Consume one-shot FAQ flash (validation errors + field values).
 *
 * @return array{errors: string[], fields: array<string, mixed>}|null
 */
function restwell_faq_consume_flash(): ?array {
	if ( ! isset( $_GET['faq_flash'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return null;
	}
	$key = sanitize_text_field( wp_unslash( $_GET['faq_flash'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( '' === $key || ! preg_match( '/^[A-Za-z0-9]{8,32}$/', $key ) ) {
		return null;
	}
	$transient_key = 'restwell_faq_flash_' . $key;
	$data          = get_transient( $transient_key );
	delete_transient( $transient_key );
	if ( ! is_array( $data ) ) {
		return null;
	}
	$errors = isset( $data['errors'] ) && is_array( $data['errors'] ) ? $data['errors'] : array();
	$fields = isset( $data['fields'] ) && is_array( $data['fields'] ) ? $data['fields'] : array();
	return array(
		'errors' => array_values( array_filter( array_map( 'strval', $errors ) ) ),
		'fields' => $fields,
	);
}

/**
 * Admin: list FAQ form submissions (for follow-up when email did not send).
 */
function restwell_faq_register_inbox_menu(): void {
	add_submenu_page(
		'restwell-crm',
		__( 'FAQ questions', 'restwell-retreats' ),
		__( 'FAQ questions', 'restwell-retreats' ),
		restwell_crm_capability(),
		'restwell-faq-inbox',
		'restwell_faq_inbox_page'
	);
}
add_action( 'admin_menu', 'restwell_faq_register_inbox_menu', 7 );

/**
 * Render FAQ submissions inbox.
 */
function restwell_faq_inbox_page(): void {
	if ( ! function_exists( 'restwell_crm_can_manage' ) || ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'You do not have permission to access this page.', 'restwell-retreats' ), '', array( 'response' => 403 ) );
	}
	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_FAQ_TABLE;
	$rows  = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM %i ORDER BY submitted_at DESC LIMIT 100', $table ), ARRAY_A );
	$total = is_array( $rows ) ? count( $rows ) : 0;
	?>
	<div class="wrap restwell-admin restwell-admin-faq-inbox">
		<h1 class="rw-page-title"><?php esc_html_e( 'FAQ questions', 'restwell-retreats' ); ?></h1>
		<p class="description rw-lead">
			<?php esc_html_e( 'Questions submitted from the FAQ page. Rows marked Notify: No may need a manual reply if email delivery failed.', 'restwell-retreats' ); ?>
		</p>

		<?php if ( empty( $rows ) ) : ?>
			<section class="rw-faq-inbox-empty" aria-labelledby="rw-faq-inbox-empty-title">
				<div class="rw-enquiries-empty">
					<div class="rw-enquiries-empty__inner">
						<div class="rw-enquiries-empty__icon" aria-hidden="true">
							<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" focusable="false">
								<circle cx="24" cy="24" r="18" stroke="currentColor" stroke-width="2"/>
								<path d="M18 20a6 6 0 1 1 12 0c0 4-6 4-6 8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
								<circle cx="24" cy="34" r="1.5" fill="currentColor"/>
							</svg>
						</div>
						<p id="rw-faq-inbox-empty-title" class="rw-enquiries-empty__title">
							<?php esc_html_e( 'No FAQ submissions yet', 'restwell-retreats' ); ?>
						</p>
						<p class="rw-enquiries-empty__text">
							<?php esc_html_e( 'When someone asks a question on the FAQ page, it will appear here with their contact details.', 'restwell-retreats' ); ?>
						</p>
					</div>
				</div>
			</section>
		<?php else : ?>
			<section class="rw-faq-inbox-panel" aria-labelledby="rw-faq-inbox-heading">
				<div class="rw-faq-inbox-panel__header">
					<h2 id="rw-faq-inbox-heading" class="rw-faq-inbox-panel__title">
						<?php esc_html_e( 'Recent submissions', 'restwell-retreats' ); ?>
					</h2>
					<p class="rw-faq-inbox-panel__count">
						<?php
						printf(
							/* translators: %d: submission count */
							esc_html( _n( '%d question', '%d questions', $total, 'restwell-retreats' ) ),
							(int) $total
						);
						?>
					</p>
				</div>
				<div class="rw-table-shell rw-table-shell--faq-inbox">
					<p class="rw-table-scroll-hint"><?php esc_html_e( 'Scroll sideways if columns are hidden.', 'restwell-retreats' ); ?></p>
					<table class="widefat striped rw-faq-inbox-table">
						<thead>
							<tr>
								<th scope="col" class="column-name"><?php esc_html_e( 'Name', 'restwell-retreats' ); ?></th>
								<th scope="col" class="column-question"><?php esc_html_e( 'Question', 'restwell-retreats' ); ?></th>
								<th scope="col" class="column-email"><?php esc_html_e( 'Email', 'restwell-retreats' ); ?></th>
								<th scope="col" class="column-phone"><?php esc_html_e( 'Phone', 'restwell-retreats' ); ?></th>
								<th scope="col" class="column-date"><?php esc_html_e( 'Submitted', 'restwell-retreats' ); ?></th>
								<th scope="col" class="column-notify"><?php esc_html_e( 'Notify', 'restwell-retreats' ); ?></th>
								<th scope="col" class="column-optin"><?php esc_html_e( 'Marketing', 'restwell-retreats' ); ?></th>
								<th scope="col" class="column-sync"><?php esc_html_e( 'MC sync', 'restwell-retreats' ); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ( $rows as $r ) : ?>
								<?php
								$name     = (string) ( $r['name'] ?? '' );
								$email    = (string) ( $r['email'] ?? '' );
								$phone    = trim( (string) ( $r['phone'] ?? '' ) );
								$question = (string) ( $r['question'] ?? '' );
								$submitted_ts = ! empty( $r['submitted_at'] ) ? strtotime( (string) $r['submitted_at'] ) : false;
								?>
								<tr>
									<td class="column-name" data-label="<?php echo esc_attr__( 'Name', 'restwell-retreats' ); ?>">
										<?php echo esc_html( $name !== '' ? $name : '—' ); ?>
									</td>
									<td class="column-question" data-label="<?php echo esc_attr__( 'Question', 'restwell-retreats' ); ?>">
										<?php echo esc_html( $question ); ?>
									</td>
									<td class="column-email" data-label="<?php echo esc_attr__( 'Email', 'restwell-retreats' ); ?>">
										<?php if ( $email ) : ?>
											<a class="rw-tap-link rw-cell-email" href="<?php echo esc_url( 'mailto:' . $email ); ?>">
												<?php echo esc_html( $email ); ?>
											</a>
										<?php else : ?>
											<span class="rw-text-dim">&mdash;</span>
										<?php endif; ?>
									</td>
									<td class="column-phone" data-label="<?php echo esc_attr__( 'Phone', 'restwell-retreats' ); ?>">
										<?php if ( $phone ) : ?>
											<a class="rw-tap-link" href="<?php echo esc_url( 'tel:' . $phone ); ?>">
												<?php echo esc_html( $phone ); ?>
											</a>
										<?php else : ?>
											<span class="rw-text-dim">&mdash;</span>
										<?php endif; ?>
									</td>
									<td class="column-date rw-text-meta" data-label="<?php echo esc_attr__( 'Submitted', 'restwell-retreats' ); ?>">
										<?php
										if ( $submitted_ts ) {
											echo esc_html( date_i18n( 'j M Y, H:i', $submitted_ts ) );
										} else {
											?>
											<span class="rw-text-dim">&mdash;</span>
											<?php
										}
										?>
									</td>
									<td class="column-notify" data-label="<?php echo esc_attr__( 'Notify', 'restwell-retreats' ); ?>">
										<?php if ( ! empty( $r['notify_sent'] ) ) : ?>
											<span class="rw-badge rw-badge--success"><?php esc_html_e( 'Yes', 'restwell-retreats' ); ?></span>
										<?php else : ?>
											<span class="rw-badge rw-badge--warn"><?php esc_html_e( 'No', 'restwell-retreats' ); ?></span>
										<?php endif; ?>
									</td>
									<td class="column-optin" data-label="<?php echo esc_attr__( 'Marketing', 'restwell-retreats' ); ?>">
										<?php if ( ! empty( $r['marketing_optin'] ) ) : ?>
											<span class="rw-badge rw-badge--optin"><?php esc_html_e( 'Opted in', 'restwell-retreats' ); ?></span>
										<?php else : ?>
											<span class="rw-text-dim"><?php esc_html_e( 'No', 'restwell-retreats' ); ?></span>
										<?php endif; ?>
									</td>
									<td class="column-sync" data-label="<?php echo esc_attr__( 'MC sync', 'restwell-retreats' ); ?>">
										<?php if ( ! empty( $r['marketing_optin'] ) ) : ?>
											<?php if ( ! empty( $r['marketing_sync_failed'] ) ) : ?>
												<span class="rw-badge rw-badge--failed" title="<?php esc_attr_e( 'Mailchimp sync failed — needs manual retry', 'restwell-retreats' ); ?>">
													<?php esc_html_e( 'Failed', 'restwell-retreats' ); ?>
												</span>
											<?php else : ?>
												<span class="rw-badge rw-badge--success"><?php esc_html_e( 'OK', 'restwell-retreats' ); ?></span>
											<?php endif; ?>
										<?php else : ?>
											<span class="rw-text-dim">&mdash;</span>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</section>
		<?php endif; ?>
	</div>
	<?php
}
