<?php
/**
 * CRM dashboard: orientation panel, CRM settings, export audit log.
 *
 * @package Restwell_CRM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Collapsed “where to edit what” reference.
 */
function restwell_crm_dashboard_render_orientation() {
	?>
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
						__( 'House availability calendar', 'restwell-retreats' ),
						'<a href="#rw-crm-settings">' . esc_html__( 'Dashboard → Settings (ICS URL)', 'restwell-retreats' ) . '</a>',
						__( 'Published Outlook Website Availability feed. Titles are stripped. Prefer RESTWELL_ICAL_FEED_URL in wp-config.', 'restwell-retreats' ),
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

	<?php
}

/**
 * Enquiry notify / Mailchimp / CRM roles form and SMTP test.
 */
function restwell_crm_dashboard_render_settings() {
	?>
	<!-- CRM settings (enquiry notify / Mailchimp / roles only) -->
		<div id="rw-crm-settings" class="rw-settings-wrap rw-settings-wrap--demoted">
			<div class="rw-dash-panel">
				<h2 class="rw-dash-panel__title"><?php esc_html_e( 'Settings', 'restwell-retreats' ); ?></h2>
				<div class="rw-dash-panel__body">
					<p class="description rw-description--tight-top">
						<?php esc_html_e( 'Who gets enquiry emails, Mailchimp, the house diary ICS feed, and which roles can use the CRM.', 'restwell-retreats' ); ?>
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
								<th scope="row">
									<label for="restwell_ical_feed_url">
										<?php esc_html_e( 'Availability ICS', 'restwell-retreats' ); ?>
									</label>
								</th>
								<td>
									<?php
									$ical_from_constant = defined( 'RESTWELL_ICAL_FEED_URL' ) && '' !== restwell_occupancy_sanitize_feed_url( (string) RESTWELL_ICAL_FEED_URL );
									$ical_stored        = (string) get_option( 'restwell_ical_feed_url', '' );
									$ical_prod_locked   = function_exists( 'restwell_is_production_environment' ) && restwell_is_production_environment();
									$ical_masked        = '';
									if ( '' !== $ical_stored ) {
										$ical_masked = '…' . substr( $ical_stored, -12 );
									}
									$ical_configured = function_exists( 'restwell_occupancy_is_configured' ) && restwell_occupancy_is_configured();
									if ( $ical_configured ) {
										$ical_badge_class = 'rw-ga4-badge rw-ga4-badge--active';
										$ical_badge_text  = $ical_from_constant
											? __( 'Configured (wp-config)', 'restwell-retreats' )
											: __( 'Configured', 'restwell-retreats' );
									} else {
										$ical_badge_class = 'rw-ga4-badge rw-ga4-badge--unset';
										$ical_badge_text  = __( 'Not configured', 'restwell-retreats' );
									}
									?>
									<div class="rw-ga4-field-wrap">
										<input
											type="url"
											id="restwell_ical_feed_url"
											name="restwell_ical_feed_url"
											value=""
											class="regular-text"
											autocomplete="off"
											placeholder="<?php echo esc_attr( $ical_masked ? $ical_masked : 'https://outlook.office365.com/owa/calendar/.../calendar.ics' ); ?>"
											<?php disabled( $ical_from_constant || $ical_prod_locked ); ?>
										/>
										<span class="<?php echo esc_attr( $ical_badge_class ); ?>" aria-live="polite">
											<?php echo esc_html( $ical_badge_text ); ?>
										</span>
									</div>
									<p class="description">
										<?php
										if ( $ical_from_constant ) {
											esc_html_e( 'RESTWELL_ICAL_FEED_URL is set in wp-config.php. The option field is unused while that constant is defined.', 'restwell-retreats' );
										} elseif ( $ical_prod_locked ) {
											esc_html_e( 'Production will not store this URL in the database. Define RESTWELL_ICAL_FEED_URL in wp-config.php.', 'restwell-retreats' );
										} else {
											esc_html_e( 'Paste the Website Availability ICS link (ends in calendar.ics), not the HTML preview. Leave blank to keep the stored URL. Event titles are never shown on the site.', 'restwell-retreats' );
										}
										?>
									</p>
									<?php if ( ! $ical_from_constant && ! $ical_prod_locked ) : ?>
									<p class="description">
										<label>
											<input type="checkbox" name="restwell_ical_feed_url_clear" value="1" />
											<?php esc_html_e( 'Clear stored ICS URL on save', 'restwell-retreats' ); ?>
										</label>
									</p>
									<?php endif; ?>
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

	<?php
}

/**
 * Recent CRM CSV export audit entries.
 */
function restwell_crm_dashboard_render_export_log() {
	?>
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

	<?php
}
