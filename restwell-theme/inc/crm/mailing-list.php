<?php
/**
 * CRM: marketing opt-in mailing list admin screen.
 *
 * @package Restwell_CRM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render opted-in marketing contacts from site forms.
 */
function restwell_crm_mailing_list_page(): void {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'You do not have permission to view this page.', 'restwell-retreats' ) );
	}

	global $wpdb;
	$enq_table = $wpdb->prefix . RESTWELL_CRM_TABLE;
	$faq_table = $wpdb->prefix . RESTWELL_FAQ_TABLE;

	$rows = $wpdb->get_results(
		$wpdb->prepare(
			"
		SELECT
			email,
			MAX(name) AS name,
			MAX(last_opted_in_at) AS last_opted_in_at,
			GROUP_CONCAT(DISTINCT source ORDER BY source SEPARATOR ', ') AS sources
		FROM (
			SELECT
				email,
				name,
				COALESCE(marketing_optin_at, submitted_at) AS last_opted_in_at,
				'Enquiry form' AS source
			FROM %i
			WHERE marketing_optin = 1 AND email <> ''
			UNION ALL
			SELECT
				email,
				name,
				COALESCE(marketing_optin_at, submitted_at) AS last_opted_in_at,
				'FAQ question form' AS source
			FROM %i
			WHERE marketing_optin = 1 AND email <> ''
		) all_optins
		GROUP BY email
		ORDER BY last_opted_in_at DESC
		",
			$enq_table,
			$faq_table
		),
		ARRAY_A
	);
	$total = is_array( $rows ) ? count( $rows ) : 0;
	?>
	<div class="wrap restwell-admin restwell-admin-mailing-list">
		<h1 class="rw-page-title"><?php esc_html_e( 'Mailing list', 'restwell-retreats' ); ?></h1>
		<p class="description rw-lead">
			<?php esc_html_e( 'Contacts who explicitly opted in to marketing emails from enquiry and FAQ forms.', 'restwell-retreats' ); ?>
		</p>

		<?php if ( empty( $rows ) ) : ?>
			<section class="rw-mailing-list-empty" aria-labelledby="rw-mailing-list-empty-title">
				<div class="rw-enquiries-empty">
					<div class="rw-enquiries-empty__inner">
						<div class="rw-enquiries-empty__icon" aria-hidden="true">
							<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" focusable="false">
								<rect x="4" y="10" width="40" height="28" rx="4" stroke="currentColor" stroke-width="2"/>
								<path d="M4 14l20 14L44 14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</div>
						<p id="rw-mailing-list-empty-title" class="rw-enquiries-empty__title">
							<?php esc_html_e( 'No opted-in contacts yet', 'restwell-retreats' ); ?>
						</p>
						<p class="rw-enquiries-empty__text">
							<?php esc_html_e( 'When someone ticks marketing consent on the enquiry or FAQ form, they will appear here.', 'restwell-retreats' ); ?>
						</p>
						<p class="rw-enquiries-empty__meta">
							<?php esc_html_e( 'Mailchimp sync uses the same opt-in flag. Configure the audience under Dashboard → Settings.', 'restwell-retreats' ); ?>
						</p>
					</div>
				</div>
			</section>
		<?php else : ?>
			<section class="rw-mailing-list-panel" aria-labelledby="rw-mailing-list-heading">
				<div class="rw-mailing-list-panel__header">
					<h2 id="rw-mailing-list-heading" class="rw-mailing-list-panel__title">
						<?php esc_html_e( 'Opted-in contacts', 'restwell-retreats' ); ?>
					</h2>
					<p class="rw-mailing-list-panel__count">
						<?php
						printf(
							/* translators: %d: subscriber count */
							esc_html( _n( '%d subscriber', '%d subscribers', $total, 'restwell-retreats' ) ),
							(int) $total
						);
						?>
					</p>
				</div>
				<div class="rw-table-shell rw-table-shell--mailing-list">
					<p class="rw-table-scroll-hint"><?php esc_html_e( 'Scroll sideways if columns are hidden.', 'restwell-retreats' ); ?></p>
					<table class="widefat striped rw-mailing-list-table">
						<thead>
							<tr>
								<th scope="col" class="column-name"><?php esc_html_e( 'Name', 'restwell-retreats' ); ?></th>
								<th scope="col" class="column-email"><?php esc_html_e( 'Email', 'restwell-retreats' ); ?></th>
								<th scope="col" class="column-source"><?php esc_html_e( 'Source', 'restwell-retreats' ); ?></th>
								<th scope="col" class="column-optin"><?php esc_html_e( 'Most recent opt-in', 'restwell-retreats' ); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ( $rows as $row ) : ?>
								<?php
								$name    = (string) ( $row['name'] ?? '' );
								$email   = (string) ( $row['email'] ?? '' );
								$sources = (string) ( $row['sources'] ?? '' );
								$optin   = (string) ( $row['last_opted_in_at'] ?? '' );
								$optin_ts = $optin ? strtotime( $optin ) : false;
								?>
								<tr>
									<td class="column-name" data-label="<?php echo esc_attr__( 'Name', 'restwell-retreats' ); ?>">
										<?php echo esc_html( $name !== '' ? $name : '—' ); ?>
									</td>
									<td class="column-email" data-label="<?php echo esc_attr__( 'Email', 'restwell-retreats' ); ?>">
										<?php if ( $email ) : ?>
											<a class="rw-tap-link rw-cell-email" href="<?php echo esc_url( 'mailto:' . $email ); ?>">
												<?php echo esc_html( $email ); ?>
											</a>
										<?php else : ?>
											<span class="rw-text-dim">—</span>
										<?php endif; ?>
									</td>
									<td class="column-source" data-label="<?php echo esc_attr__( 'Source', 'restwell-retreats' ); ?>">
										<?php echo esc_html( $sources ); ?>
									</td>
									<td class="column-optin rw-text-meta" data-label="<?php echo esc_attr__( 'Most recent opt-in', 'restwell-retreats' ); ?>">
										<?php
										if ( $optin_ts ) {
											echo esc_html( date_i18n( 'j M Y, H:i', $optin_ts ) );
										} else {
											?>
											<span class="rw-text-dim">&mdash;</span>
											<?php
										}
										?>
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
