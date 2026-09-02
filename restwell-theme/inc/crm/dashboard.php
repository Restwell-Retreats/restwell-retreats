<?php
/**
 * CRM: dashboard admin screen.
 *
 * @package Restwell_CRM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ─────────────────────────────────────────────────────────────────────────────
// 7. DASHBOARD PAGE
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Render the Restwell CRM dashboard.
 */
function restwell_crm_dashboard_page() {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'You do not have permission to access this page.', 'restwell-retreats' ), '', array( 'response' => 403 ) );
	}

	global $wpdb;
	$enq_table    = $wpdb->prefix . RESTWELL_CRM_TABLE;
	$guests_table = $wpdb->prefix . RESTWELL_GUESTS_TABLE;
	$now_mysql    = current_time( 'mysql' );
	$week_ago     = wp_date( 'Y-m-d H:i:s', time() - WEEK_IN_SECONDS );
	if ( ! is_string( $week_ago ) || $week_ago === '' ) {
		$week_ago = $now_mysql;
	}

	// ── Stats ────────────────────────────────────────────────────────────────
	$stat_new_week   = (int) $wpdb->get_var( $wpdb->prepare( 'SELECT COUNT(*) FROM %i WHERE submitted_at >= %s', $enq_table, $week_ago ) );
	$stat_total      = (int) $wpdb->get_var( $wpdb->prepare( 'SELECT COUNT(*) FROM %i', $enq_table ) );
	$stat_urgent     = (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM %i WHERE is_urgent = 1 AND status = 'new'", $enq_table ) );
	$stat_follow_ups = (int) $wpdb->get_var(
		$wpdb->prepare( "SELECT COUNT(*) FROM %i WHERE follow_up_at IS NOT NULL AND follow_up_at <= %s AND status != 'closed'", $enq_table, $now_mysql )
	);

	// Follow-ups due today or overdue.
	$follow_up_rows = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT id, name, email, status, follow_up_at FROM %i
			 WHERE follow_up_at IS NOT NULL AND follow_up_at <= %s AND status != 'closed'
			 ORDER BY follow_up_at ASC LIMIT 20",
			$enq_table,
			$now_mysql
		)
	);

	// Booked enquiries not yet added to the Guest Guide.
	// NOTE: LOWER() on both sides prevents index use on email columns; revisit with a normalised
	// stored column (e.g. email_lower GENERATED ALWAYS AS (LOWER(email)) STORED + index) if this
	// query appears in the MySQL slow log.
	$booked_without_guide = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT e.id, e.name, e.email, e.preferred_dates, e.booked_at
			 FROM %i e
			 LEFT JOIN %i g ON LOWER(g.email) = LOWER(e.email)
			 WHERE e.status = 'booked' AND g.id IS NULL
			 ORDER BY e.booked_at ASC",
			$enq_table,
			$guests_table
		)
	);
	$enquiries_url = admin_url( 'admin.php?page=restwell-enquiries' );
	?>
	<div class="wrap restwell-admin restwell-admin-dashboard">
		<h1 class="rw-page-title"><?php esc_html_e( 'Restwell Dashboard', 'restwell-retreats' ); ?></h1>

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

		<!-- Stat tiles -->
		<div class="rw-stat-grid" role="list" aria-label="<?php esc_attr_e( 'Dashboard summary metrics', 'restwell-retreats' ); ?>">
			<?php
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
			foreach ( $tiles as $tile ) :
				?>
			<a href="<?php echo esc_url( $tile['url'] ); ?>" class="rw-stat-tile" role="listitem" style="--rw-tile-accent:<?php echo esc_attr( $tile['color'] ); ?>;">
				<div class="rw-stat-value"><?php echo esc_html( $tile['value'] ); ?></div>
				<div class="rw-stat-label"><?php echo esc_html( $tile['label'] ); ?></div>
			</a>
			<?php endforeach; ?>
		</div>

		<nav class="rw-dash-quicklinks" aria-label="<?php esc_attr_e( 'CRM shortcuts', 'restwell-retreats' ); ?>">
			<a class="button button-secondary" href="<?php echo esc_url( $enquiries_url ); ?>"><?php esc_html_e( 'Enquiries', 'restwell-retreats' ); ?></a>
			<a class="button button-secondary" href="<?php echo esc_url( admin_url( 'admin.php?page=restwell-guest-guide' ) ); ?>"><?php esc_html_e( 'Guest Guide', 'restwell-retreats' ); ?></a>
			<a class="button button-secondary" href="<?php echo esc_url( admin_url( 'admin.php?page=restwell-mailing-list' ) ); ?>"><?php esc_html_e( 'Mailing list', 'restwell-retreats' ); ?></a>
		</nav>

		<div class="rw-dashboard-grid">

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
											<a class="rw-tap-link" href="<?php echo esc_url( add_query_arg( array( 'page' => 'restwell-enquiries', 'view' => $r->id ), admin_url( 'admin.php' ) ) ); ?>">
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
											<a class="rw-tap-link" href="<?php echo esc_url( add_query_arg( array( 'page' => 'restwell-enquiries', 'view' => $r->id ), admin_url( 'admin.php' ) ) ); ?>">
												<?php echo esc_html( $r->name ); ?>
											</a>
										</td>
										<td class="rw-table-meta" data-label="<?php echo esc_attr__( 'Dates', 'restwell-retreats' ); ?>"><?php echo esc_html( $r->preferred_dates ?: '-' ); ?></td>
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

	</div><!-- grid -->

	<!-- Where-to-edit-what orientation panel (collapsed by default) -->
	<details class="rw-orientation-details">
		<summary class="rw-orientation-details__summary"><?php esc_html_e( 'Where to edit what', 'restwell-retreats' ); ?></summary>
		<div class="rw-orientation-details__body">
				<p class="description rw-description--tight-top">
					<?php esc_html_e( 'Quick reference — every piece of content and where it lives.', 'restwell-retreats' ); ?>
				</p>
				<?php
				$base_url  = admin_url( 'admin.php' );
				$pages_url = admin_url( 'edit.php?post_type=page' );
				$rows      = array(
					array(
						__( 'Hero text and images', 'restwell-retreats' ),
						'<a href="' . esc_url( $pages_url ) . '">' . esc_html__( 'Pages → edit page → Page content', 'restwell-retreats' ) . '</a>',
						__( 'What goes live depends on the template. Homepage: hero heading and intro (hero media is used). Legal pages: label, heading, intro, body HTML, and hero image. Concept pages: hero fields; most body copy lives in the theme PHP. Each Page content box spells this out.', 'restwell-retreats' ),
					),
					array(
						__( 'FAQ questions & answers', 'restwell-retreats' ),
						'<a href="' . esc_url( admin_url( 'edit.php?post_type=page' ) ) . '">' . esc_html__( 'Pages → FAQ (and How It Works)', 'restwell-retreats' ) . '</a>',
						__( 'The FAQ page reads its own question/answer fields. Homepage FAQ is in the theme file inc/homepage-faq.php. How It Works FAQ is that page’s fields (or theme defaults). The homepage Page content box has no FAQ tab.', 'restwell-retreats' ),
					),
					array(
						__( 'SEO title & meta description for a page', 'restwell-retreats' ),
						'<a href="' . esc_url( add_query_arg( 'page', 'restwell-seo', $base_url ) ) . '">' . esc_html__( 'SEO → All pages', 'restwell-retreats' ) . '</a>',
						__( 'Per-page focus keyphrase, SEO title, and social settings.', 'restwell-retreats' ),
					),
					array(
						__( 'Phone, Google address, GA4, footer CTA, property line', 'restwell-retreats' ),
						'<a href="' . esc_url( add_query_arg( 'page', 'restwell-seo-sitewide', $base_url ) ) . '">' . esc_html__( 'SEO → Site-wide', 'restwell-retreats' ) . '</a>',
						__( 'Everything that applies to the whole site (search, analytics, and shared website copy).', 'restwell-retreats' ),
					),
					array(
						__( 'Notify email, Mailchimp, who can use the CRM', 'restwell-retreats' ),
						'<a href="#rw-crm-settings">' . esc_html__( 'Dashboard → Settings (below)', 'restwell-retreats' ) . '</a>',
						__( 'Enquiry alerts and CRM access only — not SEO or website copy.', 'restwell-retreats' ),
					),
					array(
						__( 'Enquiries (contact form submissions)', 'restwell-retreats' ),
						'<a href="' . esc_url( add_query_arg( 'page', 'restwell-enquiries', $base_url ) ) . '">' . esc_html__( 'Restwell → Enquiries', 'restwell-retreats' ) . '</a>',
						__( 'View, reply, update status, add follow-up notes, and mark urgent.', 'restwell-retreats' ),
					),
					array(
						__( 'Guest guide (pre-stay info sent to bookers)', 'restwell-retreats' ),
						'<a href="' . esc_url( add_query_arg( 'page', 'restwell-guest-guide', $base_url ) ) . '">' . esc_html__( 'Restwell → Guest Guide', 'restwell-retreats' ) . '</a>',
						__( 'Create a personalised guide link. Guests receive a private URL with their arrival details.', 'restwell-retreats' ),
					),
					array(
						__( 'Partner logos on the homepage', 'restwell-retreats' ),
						esc_html__( 'Home → Page content → Partners (theme images used until a logo is uploaded)', 'restwell-retreats' ),
						__( 'Heading, intro, CTA and the five partner names/URLs/logos go live. Empty heading hides the strip.', 'restwell-retreats' ),
					),
					array(
						__( 'Guest reviews / testimonials', 'restwell-retreats' ),
						esc_html__( 'Places API when configured; otherwise Home → Page content → Testimonials', 'restwell-retreats' ),
						__( 'Always the guest’s consecutive words from the review. Do not rewrite to house style.', 'restwell-retreats' ),
					),
					array(
						__( 'Legal pages (Privacy Policy, Terms etc.)', 'restwell-retreats' ),
						esc_html__( 'Pages → edit the relevant legal page → Page content', 'restwell-retreats' ),
						__( 'Body accepts full HTML via the wp_kses_post sanitiser.', 'restwell-retreats' ),
					),
				);
				?>
				<ul class="rw-orientation-list">
					<?php foreach ( $rows as $row ) : ?>
						<li class="rw-orientation-list__item">
							<div class="rw-orientation-list__what"><?php echo esc_html( $row[0] ); ?></div>
							<div class="rw-orientation-list__where"><?php echo wp_kses_post( $row[1] ); ?></div>
							<p class="rw-orientation-list__notes"><?php echo esc_html( $row[2] ); ?></p>
						</li>
					<?php endforeach; ?>
				</ul>
		</div>
	</details>

	<!-- CRM settings (enquiry notify / Mailchimp / roles only) -->
		<div id="rw-crm-settings" class="rw-settings-wrap rw-settings-wrap--demoted">
			<div class="rw-dash-panel">
				<h2 class="rw-dash-panel__title"><?php esc_html_e( 'Settings', 'restwell-retreats' ); ?></h2>
				<div class="rw-dash-panel__body">
					<p class="description rw-description--tight-top">
						<?php esc_html_e( 'Who gets enquiry emails, Mailchimp, and which roles can use the CRM.', 'restwell-retreats' ); ?>
					</p>
					<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
						<?php wp_nonce_field( 'restwell_crm_settings' ); ?>
						<input type="hidden" name="action" value="restwell_save_settings" />
						<div class="notice notice-info inline">
							<p>
								<?php
								echo wp_kses_post(
									sprintf(
										/* translators: %s: link to SEO site-wide settings */
										__( 'Phone, Google address, analytics, footer CTA, and the property line are under %s.', 'restwell-retreats' ),
										'<a href="' . esc_url( admin_url( 'admin.php?page=restwell-seo-sitewide' ) ) . '"><strong>' . esc_html__( 'SEO → Site-wide', 'restwell-retreats' ) . '</strong></a>'
									)
								);
								?>
							</p>
						</div>
						<table class="form-table" role="presentation">
							<tr>
								<th scope="row">
									<label for="restwell_enquiry_notify_email">
										<?php esc_html_e( 'Notify email', 'restwell-retreats' ); ?>
									</label>
								</th>
								<td>
									<input
										type="email"
										id="restwell_enquiry_notify_email"
										name="restwell_enquiry_notify_email"
										value="<?php echo esc_attr( (string) get_option( 'restwell_enquiry_notify_email', 'hello@restwellretreats.co.uk' ) ); ?>"
										class="regular-text"
									/>
									<p class="description">
										<?php esc_html_e( 'New enquiry notification emails are sent here.', 'restwell-retreats' ); ?>
									</p>
								</td>
							</tr>
							<tr>
								<th scope="row"><?php esc_html_e( 'Mail transport', 'restwell-retreats' ); ?></th>
								<td>
									<?php
									$smtp_configured = function_exists( 'restwell_smtp_is_configured' ) && restwell_smtp_is_configured();
									?>
									<p>
										<?php
										echo esc_html(
											$smtp_configured
												? __( 'SMTP constants are set (RESTWELL_SMTP_HOST).', 'restwell-retreats' )
												: __( 'No RESTWELL_SMTP_HOST. wp_mail uses PHP mail (Local Mailpit catches this).', 'restwell-retreats' )
										);
										?>
									</p>
									<p class="description">
										<?php esc_html_e( 'Does not prove a production inbox. Use Send test email after Save if the notify address is empty.', 'restwell-retreats' ); ?>
									</p>
								</td>
							</tr>
						<tr>
							<th scope="row">
								<label for="restwell_mailchimp_api_key">
									<?php esc_html_e( 'Mailchimp API key', 'restwell-retreats' ); ?>
								</label>
							</th>
							<td>
								<?php
								$mailchimp_from_constant = defined( 'RESTWELL_MAILCHIMP_API_KEY' ) && '' !== (string) RESTWELL_MAILCHIMP_API_KEY;
								$mailchimp_key_stored    = (string) get_option( 'restwell_mailchimp_api_key', '' );
								$mailchimp_prod_locked   = function_exists( 'restwell_is_production_environment' ) && restwell_is_production_environment();
								// Never echo the raw key — masked placeholder only when an option is stored.
								$mailchimp_key_masked = '';
								if ( '' !== $mailchimp_key_stored ) {
									$masked_tail          = substr( $mailchimp_key_stored, -4 );
									$mailchimp_key_masked = '************' . $masked_tail;
								}
								$mailchimp_audience_current = (string) get_option( 'restwell_mailchimp_audience_id', '' );
								$mailchimp_server_current   = (string) get_option( 'restwell_mailchimp_server_prefix', '' );
								if ( restwell_mailchimp_is_configured() ) {
									$mailchimp_badge_class = 'rw-ga4-badge rw-ga4-badge--active';
									$mailchimp_badge_text  = $mailchimp_from_constant
										? __( 'Configured (wp-config)', 'restwell-retreats' )
										: __( 'Configured', 'restwell-retreats' );
								} else {
									$mailchimp_badge_class = 'rw-ga4-badge rw-ga4-badge--unset';
									$mailchimp_badge_text  = __( 'Not configured', 'restwell-retreats' );
								}
								?>
								<div class="rw-ga4-field-wrap">
									<input
										type="password"
										id="restwell_mailchimp_api_key"
										name="restwell_mailchimp_api_key"
										value=""
										class="regular-text"
										autocomplete="new-password"
										placeholder="<?php echo esc_attr( $mailchimp_key_masked ); ?>"
										<?php disabled( $mailchimp_from_constant || $mailchimp_prod_locked ); ?>
									/>
									<span class="<?php echo esc_attr( $mailchimp_badge_class ); ?>" aria-live="polite">
										<?php echo esc_html( $mailchimp_badge_text ); ?>
									</span>
								</div>
								<p class="description">
									<?php
									if ( $mailchimp_from_constant ) {
										esc_html_e( 'RESTWELL_MAILCHIMP_API_KEY is set in wp-config.php (or the environment). The option field is unused while that constant is defined.', 'restwell-retreats' );
									} elseif ( $mailchimp_prod_locked ) {
										esc_html_e( 'Production will not store this key in the database. Define RESTWELL_MAILCHIMP_API_KEY in wp-config.php (or the environment).', 'restwell-retreats' );
									} else {
										esc_html_e( 'Preferred: define RESTWELL_MAILCHIMP_API_KEY in wp-config.php (mirrors SMTP constants). This non-autoloaded option is a fallback only. Leave blank to keep an existing key; enter a new key to replace it.', 'restwell-retreats' );
									}
									?>
								</p>
								<?php if ( ! $mailchimp_from_constant && ! $mailchimp_prod_locked ) : ?>
								<p class="description">
									<label>
										<input type="checkbox" name="restwell_mailchimp_api_key_clear" value="1" />
										<?php esc_html_e( 'Clear stored API key on save', 'restwell-retreats' ); ?>
									</label>
								</p>
								<?php endif; ?>
								<p class="description">
									<label for="restwell_mailchimp_audience_id"><?php esc_html_e( 'Audience ID', 'restwell-retreats' ); ?></label><br />
									<input
										type="text"
										id="restwell_mailchimp_audience_id"
										name="restwell_mailchimp_audience_id"
										value="<?php echo esc_attr( $mailchimp_audience_current ); ?>"
										class="regular-text"
										placeholder="3ad6ed993b"
									/>
								</p>
								<p class="description">
									<label for="restwell_mailchimp_server_prefix"><?php esc_html_e( 'Server prefix', 'restwell-retreats' ); ?></label><br />
									<input
										type="text"
										id="restwell_mailchimp_server_prefix"
										name="restwell_mailchimp_server_prefix"
										value="<?php echo esc_attr( $mailchimp_server_current ); ?>"
										class="small-text"
										placeholder="us15"
									/>
								</p>
								<p class="description">
									<?php esc_html_e( 'Tip: you can still override these with constants in wp-config.php.', 'restwell-retreats' ); ?>
								</p>
							</td>
						</tr>
							<tr>
								<th scope="row"><?php esc_html_e( 'CRM role access', 'restwell-retreats' ); ?></th>
								<td>
									<?php
									$cap_roles = restwell_crm_get_cap_roles();
									$role_choices = array(
										'administrator' => __( 'Administrator', 'restwell-retreats' ),
										'editor'        => __( 'Editor', 'restwell-retreats' ),
										'author'        => __( 'Author', 'restwell-retreats' ),
									);
									?>
									<div class="rw-checkbox-stack">
									<?php foreach ( $role_choices as $role_slug => $role_label ) : ?>
										<label>
											<input type="checkbox" name="restwell_crm_cap_roles[]" value="<?php echo esc_attr( $role_slug ); ?>" <?php checked( in_array( $role_slug, $cap_roles, true ) ); ?> />
											<?php echo esc_html( $role_label ); ?>
										</label>
									<?php endforeach; ?>
									</div>
									<p class="description"><?php esc_html_e( 'Selected roles can access and edit CRM enquiries.', 'restwell-retreats' ); ?></p>
								</td>
							</tr>
						</table>
					<?php submit_button( __( 'Save', 'restwell-retreats' ), 'secondary', 'submit', false ); ?>
				</form>
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="rw-smtp-test-form">
					<?php wp_nonce_field( 'restwell_crm_send_test_mail' ); ?>
					<input type="hidden" name="action" value="restwell_crm_send_test_mail" />
					<?php submit_button( __( 'Send test email', 'restwell-retreats' ), 'secondary', 'submit', false ); ?>
					<p class="description">
						<?php esc_html_e( 'Sends one line to the notify address, or the WordPress admin email if notify is empty. Limited to once every five minutes.', 'restwell-retreats' ); ?>
					</p>
				</form>
				</div>
			</div>
		</div>

	<!-- Export audit log -->
	<div class="rw-settings-wrap rw-settings-wrap--demoted">
		<section class="rw-dash-panel">
			<h2 class="rw-dash-panel__title"><?php esc_html_e( 'Export audit log', 'restwell-retreats' ); ?></h2>
			<div class="rw-dash-panel__body">
				<?php
				$export_log     = get_option( 'restwell_crm_export_log', array() );
				$export_log     = is_array( $export_log ) ? $export_log : array();
				$recent_exports = array_slice( array_reverse( $export_log ), 0, 10 );
				if ( empty( $recent_exports ) ) :
					?>
					<p class="rw-empty"><?php esc_html_e( 'No exports have been run yet.', 'restwell-retreats' ); ?></p>
				<?php else : ?>
					<table class="widefat striped rw-dashboard-table">
						<thead>
							<tr>
								<th><?php esc_html_e( 'User', 'restwell-retreats' ); ?></th>
								<th><?php esc_html_e( 'Exported at (UTC)', 'restwell-retreats' ); ?></th>
								<th><?php esc_html_e( 'Rows', 'restwell-retreats' ); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ( $recent_exports as $entry ) :
								$exporter    = isset( $entry['user_id'] ) ? get_userdata( (int) $entry['user_id'] ) : false;
								$display     = $exporter ? $exporter->display_name : __( 'Unknown', 'restwell-retreats' );
								$exported_at = isset( $entry['exported_at'] ) ? $entry['exported_at'] : '—';
								$row_count   = isset( $entry['row_count'] ) ? absint( $entry['row_count'] ) : '—';
								?>
							<tr>
								<td><?php echo esc_html( $display ); ?></td>
								<td class="rw-table-meta"><?php echo esc_html( $exported_at ); ?></td>
								<td class="rw-table-meta"><?php echo esc_html( (string) $row_count ); ?></td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				<?php endif; ?>
			</div>
		</section>
	</div>

</div><!-- .wrap -->
	<?php
}

