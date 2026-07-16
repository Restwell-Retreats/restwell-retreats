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
	$week_ago     = gmdate( 'Y-m-d H:i:s', strtotime( '-7 days' ) );

	// ── Stats ────────────────────────────────────────────────────────────────
	// phpcs:disable WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	$stat_new_week   = (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$enq_table} WHERE submitted_at >= %s", $week_ago ) );
	$stat_total      = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$enq_table}" );
	$stat_urgent     = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$enq_table} WHERE is_urgent = 1 AND status = 'new'" );
	$stat_follow_ups = (int) $wpdb->get_var(
		$wpdb->prepare( "SELECT COUNT(*) FROM {$enq_table} WHERE follow_up_at IS NOT NULL AND follow_up_at <= %s AND status != 'closed'", $now_mysql )
	);

	// Follow-ups due today or overdue.
	$follow_up_rows = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT id, name, email, status, follow_up_at FROM {$enq_table}
			 WHERE follow_up_at IS NOT NULL AND follow_up_at <= %s AND status != 'closed'
			 ORDER BY follow_up_at ASC LIMIT 20",
			$now_mysql
		)
	);

	// Booked enquiries not yet added to the Guest Guide.
	// NOTE: LOWER() on both sides prevents index use on email columns; revisit with a normalised
	// stored column (e.g. email_lower GENERATED ALWAYS AS (LOWER(email)) STORED + index) if this
	// query appears in the MySQL slow log.
	$booked_without_guide = $wpdb->get_results(
		"SELECT e.id, e.name, e.email, e.preferred_dates, e.booked_at
		 FROM {$enq_table} e
		 LEFT JOIN {$guests_table} g ON LOWER(g.email) = LOWER(e.email)
		 WHERE e.status = 'booked' AND g.id IS NULL
		 ORDER BY e.booked_at ASC"
	);
	// phpcs:enable

	$enquiries_url = admin_url( 'admin.php?page=restwell-enquiries' );
	?>
	<div class="wrap restwell-admin restwell-admin-dashboard">
		<h1 class="rw-page-title"><?php esc_html_e( 'Restwell Dashboard', 'restwell-retreats' ); ?></h1>

		<?php if ( isset( $_GET['settings_saved'] ) && absint( wp_unslash( $_GET['settings_saved'] ) ) ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Settings saved.', 'restwell-retreats' ); ?></p></div>
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

		<div class="rw-dashboard-grid">

			<!-- Follow-ups due -->
			<div class="postbox">
				<div class="postbox-header">
					<h2 class="hndle">
						<span class="rw-panel-title">
							<span class="rw-panel-title__icon" aria-hidden="true">&#9201;</span>
							<span><?php esc_html_e( 'Follow-ups due', 'restwell-retreats' ); ?></span>
						</span>
					</h2>
				</div>
				<div class="inside">
					<?php if ( empty( $follow_up_rows ) ) : ?>
						<p class="rw-empty"><?php esc_html_e( 'No overdue follow-ups. Nice work.', 'restwell-retreats' ); ?></p>
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
										<td>
											<a href="
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
										<td><?php echo restwell_crm_status_badge( $r->status ); // phpcs:ignore WordPress.Security.EscapeOutput ?></td>
										<td class="rw-table-meta">
											<?php echo esc_html( date_i18n( 'j M Y', strtotime( $r->follow_up_at ) ) ); ?>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					<?php endif; ?>
				</div>
			</div>

			<!-- Booked without guide -->
			<div class="postbox">
				<div class="postbox-header">
					<h2 class="hndle">
						<span class="rw-panel-title">
							<span class="rw-panel-title__icon" aria-hidden="true">&#128203;</span>
							<span><?php esc_html_e( 'Booked; guide not sent', 'restwell-retreats' ); ?></span>
						</span>
					</h2>
				</div>
				<div class="inside">
					<?php if ( empty( $booked_without_guide ) ) : ?>
						<p class="rw-empty"><?php esc_html_e( 'All booked guests have a guide invitation.', 'restwell-retreats' ); ?></p>
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
										<td>
											<a href="
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
										<td class="rw-table-meta"><?php echo esc_html( $r->preferred_dates ?: '-' ); ?></td>
										<td>
											<a href="<?php echo esc_url( $promote_url ); ?>" class="button button-small">
												<?php esc_html_e( 'Add to Guide', 'restwell-retreats' ); ?>
											</a>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					<?php endif; ?>
				</div>
			</div>

	</div><!-- grid -->

	<!-- Where-to-edit-what orientation panel -->
	<div class="rw-settings-wrap rw-orientation-wrap">
		<div class="postbox">
			<div class="postbox-header">
				<h2 class="hndle">
					<span class="rw-panel-title">
						<span class="rw-panel-title__icon" aria-hidden="true">&#128196;</span>
						<span><?php esc_html_e( 'Where to edit what', 'restwell-retreats' ); ?></span>
					</span>
				</h2>
			</div>
			<div class="inside">
				<p class="description rw-description--tight-top">
					<?php esc_html_e( 'Quick reference — every piece of content and where it lives.', 'restwell-retreats' ); ?>
				</p>
				<table class="widefat rw-orientation-table">
					<thead>
						<tr>
							<th><?php esc_html_e( 'What you want to change', 'restwell-retreats' ); ?></th>
							<th><?php esc_html_e( 'Where to go', 'restwell-retreats' ); ?></th>
							<th><?php esc_html_e( 'Notes', 'restwell-retreats' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$base_url = admin_url( 'admin.php' );
						$pages_url = admin_url( 'edit.php?post_type=page' );
						$rows = array(
							array(
								__( 'Hero text, images, body copy on any page', 'restwell-retreats' ),
								'<a href="' . esc_url( $pages_url ) . '">' . __( 'Pages → edit page → Page Content Fields metabox', 'restwell-retreats' ) . '</a>',
								__( 'Use the tabbed sections in the "Page Content Fields" panel. Changes here update the live site immediately on save.', 'restwell-retreats' ),
							),
							array(
								__( 'FAQ questions &amp; answers', 'restwell-retreats' ),
								'<a href="' . esc_url( admin_url( 'post.php?post=' . (int) get_option( 'page_on_front' ) . '&action=edit' ) ) . '">' . __( 'Front Page → Page Content Fields → FAQ tab', 'restwell-retreats' ) . '</a>',
								__( 'Up to 14 items. The same data renders on the FAQ page, How It Works page, and homepage. Categories: about | booking | care | local | funding.', 'restwell-retreats' ),
							),
							array(
								__( 'SEO title &amp; meta description for a page', 'restwell-retreats' ),
								__( 'Pages → edit page → Page Content Fields → SEO tab', 'restwell-retreats' ),
								__( 'Focus keyphrase and meta description are set per-page here, not in a separate plugin.', 'restwell-retreats' ),
							),
							array(
								__( 'GA4 Measurement ID', 'restwell-retreats' ),
								'<a href="' . esc_url( add_query_arg( 'page', 'restwell-crm', $base_url ) ) . '">' . __( 'Dashboard → Settings (bottom of this page)', 'restwell-retreats' ) . '</a>',
								__( 'Paste your G-XXXXXXXX ID. Analytics loads site-wide once saved.', 'restwell-retreats' ),
							),
							array(
								__( 'Notification email / phone / address', 'restwell-retreats' ),
								'<a href="' . esc_url( add_query_arg( 'page', 'restwell-crm', $base_url ) ) . '">' . __( 'Dashboard → Notification &amp; Site Settings', 'restwell-retreats' ) . '</a>',
								__( 'Property line is for internal copy and the 404 page (not public JSON-LD). Business address fields power Organization / LocalBusiness schema and should match Google Business Profile.', 'restwell-retreats' ),
							),
							array(
								__( 'Enquiries (contact form submissions)', 'restwell-retreats' ),
								'<a href="' . esc_url( add_query_arg( 'page', 'restwell-enquiries', $base_url ) ) . '">' . __( 'Restwell → Enquiries', 'restwell-retreats' ) . '</a>',
								__( 'View, reply, update status, add follow-up notes, and mark urgent.', 'restwell-retreats' ),
							),
							array(
								__( 'Guest guide (pre-stay info sent to bookers)', 'restwell-retreats' ),
								'<a href="' . esc_url( add_query_arg( 'page', 'restwell-guest-guide', $base_url ) ) . '">' . __( 'Restwell → Guest Guide', 'restwell-retreats' ) . '</a>',
								__( 'Create a personalised guide link. Guests receive a private URL with their arrival details.', 'restwell-retreats' ),
							),
							array(
								__( 'Partner logos on the homepage trust strip', 'restwell-retreats' ),
								__( 'Pages → Front Page → Page Content Fields → Partners tab', 'restwell-retreats' ),
								__( 'Upload a PNG for each partner. Leave empty to hide that slot.', 'restwell-retreats' ),
							),
							array(
								__( 'Legal pages (Privacy Policy, Terms etc.)', 'restwell-retreats' ),
								__( 'Pages → edit the relevant legal page → Page Content Fields', 'restwell-retreats' ),
								__( 'Body accepts full HTML via the wp_kses_post sanitiser.', 'restwell-retreats' ),
							),
						);
						foreach ( $rows as $row ) :
							?>
							<tr>
								<td class="rw-orient-what"><strong><?php echo wp_kses_post( $row[0] ); ?></strong></td>
								<td class="rw-orient-where"><?php echo wp_kses_post( $row[1] ); ?></td>
								<td class="rw-orient-notes rw-table-meta"><?php echo wp_kses_post( $row[2] ); ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- Notification settings -->
		<div class="rw-settings-wrap">
			<div class="postbox">
				<div class="postbox-header">
					<h2 class="hndle"><span><?php esc_html_e( 'Notification Settings', 'restwell-retreats' ); ?></span></h2>
				</div>
				<div class="inside">
					<p class="description rw-description--tight-top">
						<?php esc_html_e( 'New enquiry notification emails are sent to this address.', 'restwell-retreats' ); ?>
					</p>
					<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
						<?php wp_nonce_field( 'restwell_crm_settings' ); ?>
						<input type="hidden" name="action" value="restwell_save_settings" />
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
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_phone_number">
										<?php esc_html_e( 'Phone number', 'restwell-retreats' ); ?>
									</label>
								</th>
								<td>
									<input
										type="tel"
										id="restwell_phone_number"
										name="restwell_phone_number"
										value="<?php echo esc_attr( (string) get_option( 'restwell_phone_number', '01622 809881' ) ); ?>"
										class="regular-text"
									/>
									<p class="description">
										<?php esc_html_e( 'Used in email templates and the site footer.', 'restwell-retreats' ); ?>
									</p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_property_address">
										<?php esc_html_e( 'Property street address', 'restwell-retreats' ); ?>
									</label>
								</th>
								<td>
									<input
										type="text"
										id="restwell_property_address"
										name="restwell_property_address"
										value="<?php echo esc_attr( (string) get_option( 'restwell_property_address', '101 Russell Drive' ) ); ?>"
										class="regular-text"
									/>
									<p class="description">
										<?php esc_html_e( 'Shown in on-site copy and the 404 page. Not used in public JSON-LD (use Business address below for Organization / LocalBusiness).', 'restwell-retreats' ); ?>
									</p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_property_postcode">
										<?php esc_html_e( 'Property postcode', 'restwell-retreats' ); ?>
									</label>
								</th>
								<td>
									<input
										type="text"
										id="restwell_property_postcode"
										name="restwell_property_postcode"
										value="<?php echo esc_attr( (string) get_option( 'restwell_property_postcode', 'CT5 2RQ' ) ); ?>"
										class="regular-text"
									/>
									<p class="description">
										<?php esc_html_e( 'Matches the property line above for internal copy; not output in public schema.', 'restwell-retreats' ); ?>
									</p>
								</td>
							</tr>
							<tr>
								<th scope="row" colspan="2">
									<strong><?php esc_html_e( 'Business address (JSON-LD)', 'restwell-retreats' ); ?></strong>
									<p class="description rw-description--tight-top">
										<?php esc_html_e( 'Used for Organization and LocalBusiness structured data. Keep aligned with your Google Business Profile (default: Vinters Business Park, Maidstone).', 'restwell-retreats' ); ?>
									</p>
								</th>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_business_street"><?php esc_html_e( 'Business street', 'restwell-retreats' ); ?></label>
								</th>
								<td>
									<input type="text" id="restwell_business_street" name="restwell_business_street" class="regular-text" value="<?php echo esc_attr( (string) get_option( 'restwell_business_street', 'Vinters Business Park' ) ); ?>" />
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_business_locality"><?php esc_html_e( 'Business town / city', 'restwell-retreats' ); ?></label>
								</th>
								<td>
									<input type="text" id="restwell_business_locality" name="restwell_business_locality" class="regular-text" value="<?php echo esc_attr( (string) get_option( 'restwell_business_locality', 'Maidstone' ) ); ?>" />
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_business_region"><?php esc_html_e( 'Business county / region', 'restwell-retreats' ); ?></label>
								</th>
								<td>
									<input type="text" id="restwell_business_region" name="restwell_business_region" class="regular-text" value="<?php echo esc_attr( (string) get_option( 'restwell_business_region', 'Kent' ) ); ?>" />
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_business_postcode"><?php esc_html_e( 'Business postcode', 'restwell-retreats' ); ?></label>
								</th>
								<td>
									<input type="text" id="restwell_business_postcode" name="restwell_business_postcode" class="regular-text" value="<?php echo esc_attr( (string) get_option( 'restwell_business_postcode', 'ME14 5NZ' ) ); ?>" />
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_business_geo_lat"><?php esc_html_e( 'Business latitude (optional)', 'restwell-retreats' ); ?></label>
								</th>
								<td>
									<input type="text" id="restwell_business_geo_lat" name="restwell_business_geo_lat" class="regular-text" value="<?php echo esc_attr( (string) get_option( 'restwell_business_geo_lat', '51.2707' ) ); ?>" />
									<p class="description"><?php esc_html_e( 'Decimal degrees; used for LocalBusiness geo.', 'restwell-retreats' ); ?></p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_business_geo_lon"><?php esc_html_e( 'Business longitude (optional)', 'restwell-retreats' ); ?></label>
								</th>
								<td>
									<input type="text" id="restwell_business_geo_lon" name="restwell_business_geo_lon" class="regular-text" value="<?php echo esc_attr( (string) get_option( 'restwell_business_geo_lon', '0.5207' ) ); ?>" />
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_footer_cta_heading">
										<?php esc_html_e( 'Footer CTA heading', 'restwell-retreats' ); ?>
									</label>
								</th>
								<td>
									<input
										type="text"
										id="restwell_footer_cta_heading"
										name="restwell_footer_cta_heading"
										value="<?php echo esc_attr( (string) get_option( 'restwell_footer_cta_heading', '' ) ); ?>"
										class="regular-text"
										placeholder="<?php esc_attr_e( 'Ready to plan your break?', 'restwell-retreats' ); ?>"
									/>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_footer_cta_intro">
										<?php esc_html_e( 'Footer CTA intro', 'restwell-retreats' ); ?>
									</label>
								</th>
								<td>
									<textarea
										id="restwell_footer_cta_intro"
										name="restwell_footer_cta_intro"
										rows="3"
										class="large-text"
									><?php echo esc_textarea( (string) get_option( 'restwell_footer_cta_intro', '' ) ); ?></textarea>
									<p class="description">
										<?php esc_html_e( 'Short paragraph below the heading. Leave empty to use the theme default.', 'restwell-retreats' ); ?>
									</p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_footer_cta_primary_label">
										<?php esc_html_e( 'Footer CTA primary button', 'restwell-retreats' ); ?>
									</label>
								</th>
								<td>
									<input
										type="text"
										id="restwell_footer_cta_primary_label"
										name="restwell_footer_cta_primary_label"
										value="<?php echo esc_attr( (string) get_option( 'restwell_footer_cta_primary_label', '' ) ); ?>"
										class="regular-text"
										placeholder="<?php esc_attr_e( 'See the property', 'restwell-retreats' ); ?>"
									/>
									<p class="description">
										<label for="restwell_footer_cta_primary_url"><?php esc_html_e( 'URL path or full link', 'restwell-retreats' ); ?></label><br />
										<input
											type="text"
											id="restwell_footer_cta_primary_url"
											name="restwell_footer_cta_primary_url"
											value="<?php echo esc_attr( (string) get_option( 'restwell_footer_cta_primary_url', '' ) ); ?>"
											class="regular-text"
											placeholder="<?php echo esc_attr( home_url( '/the-property/' ) ); ?>"
										/>
									</p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_footer_cta_btn">
										<?php esc_html_e( 'Footer CTA secondary button', 'restwell-retreats' ); ?>
									</label>
								</th>
								<td>
									<input
										type="text"
										id="restwell_footer_cta_btn"
										name="restwell_footer_cta_btn"
										value="<?php echo esc_attr( (string) get_option( 'restwell_footer_cta_btn', '' ) ); ?>"
										class="regular-text"
										placeholder="<?php esc_attr_e( 'Ask about your dates', 'restwell-retreats' ); ?>"
									/>
									<p class="description">
										<?php esc_html_e( 'Usually links to the Enquire page.', 'restwell-retreats' ); ?>
									</p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_footer_cta_note">
										<?php esc_html_e( 'Footer CTA reassurance line', 'restwell-retreats' ); ?>
									</label>
								</th>
								<td>
									<input
										type="text"
										id="restwell_footer_cta_note"
										name="restwell_footer_cta_note"
										value="<?php echo esc_attr( (string) get_option( 'restwell_footer_cta_note', '' ) ); ?>"
										class="regular-text"
										placeholder="<?php esc_attr_e( 'No booking commitment. Just a conversation.', 'restwell-retreats' ); ?>"
									/>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_gsc_verification">
										<?php esc_html_e( 'Google Search Console verification', 'restwell-retreats' ); ?>
									</label>
								</th>
								<td>
									<input
										type="text"
										id="restwell_gsc_verification"
										name="restwell_gsc_verification"
										value="<?php echo esc_attr( (string) get_option( 'restwell_gsc_verification', '' ) ); ?>"
										class="regular-text"
										placeholder="ABC123..."
									/>
									<p class="description">
										<?php esc_html_e( 'Paste the content value from the Google Search Console HTML meta tag verification method.', 'restwell-retreats' ); ?>
									</p>
								</td>
							</tr>
						<tr>
							<th scope="row">
								<label for="restwell_ga4_measurement_id">
									<?php esc_html_e( 'Google Analytics 4 Measurement ID', 'restwell-retreats' ); ?>
								</label>
							</th>
							<td>
								<?php
								$ga4_current = (string) get_option( 'restwell_ga4_measurement_id', '' );
								if ( $ga4_current === '' ) {
									$ga4_badge_class = 'rw-ga4-badge rw-ga4-badge--unset';
									$ga4_badge_text  = __( 'Not set — analytics inactive', 'restwell-retreats' );
								} elseif ( preg_match( '/^G-[A-Z0-9]+$/i', $ga4_current ) ) {
									$ga4_badge_class = 'rw-ga4-badge rw-ga4-badge--active';
									$ga4_badge_text  = __( 'Active', 'restwell-retreats' );
								} else {
									$ga4_badge_class = 'rw-ga4-badge rw-ga4-badge--invalid';
									$ga4_badge_text  = __( 'Wrong format — should be G-XXXXXXXXXX', 'restwell-retreats' );
								}
								?>
								<div class="rw-ga4-field-wrap">
									<input
										type="text"
										id="restwell_ga4_measurement_id"
										name="restwell_ga4_measurement_id"
										value="<?php echo esc_attr( $ga4_current ); ?>"
										class="regular-text"
										placeholder="G-XXXXXXXXXX"
									/>
									<span class="<?php echo esc_attr( $ga4_badge_class ); ?>" aria-live="polite">
										<?php echo esc_html( $ga4_badge_text ); ?>
									</span>
								</div>
								<p class="description">
									<?php esc_html_e( 'Optional. When set, GA4 is loaded according to “Analytics script placement” below (head, deferred footer, or consent-gated).', 'restwell-retreats' ); ?>
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
										<?php disabled( $mailchimp_from_constant ); ?>
									/>
									<span class="<?php echo esc_attr( $mailchimp_badge_class ); ?>" aria-live="polite">
										<?php echo esc_html( $mailchimp_badge_text ); ?>
									</span>
								</div>
								<p class="description">
									<?php
									if ( $mailchimp_from_constant ) {
										esc_html_e( 'RESTWELL_MAILCHIMP_API_KEY is set in wp-config.php (or the environment). The option field is unused while that constant is defined.', 'restwell-retreats' );
									} else {
										esc_html_e( 'Preferred: define RESTWELL_MAILCHIMP_API_KEY in wp-config.php (mirrors SMTP constants). This non-autoloaded option is a fallback only. Leave blank to keep an existing key; enter a new key to replace it.', 'restwell-retreats' );
									}
									?>
								</p>
								<p class="description">
									<label>
										<input type="checkbox" name="restwell_mailchimp_api_key_clear" value="1" />
										<?php esc_html_e( 'Clear stored API key on save', 'restwell-retreats' ); ?>
									</label>
								</p>
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
							<th scope="row">
								<label for="restwell_metricool_hash">
									<?php esc_html_e( 'Metricool tracking hash', 'restwell-retreats' ); ?>
								</label>
							</th>
							<td>
								<?php
								$metricool_current = (string) get_option( 'restwell_metricool_hash', '' );
								if ( $metricool_current === '' ) {
									$metricool_badge_class = 'rw-ga4-badge rw-ga4-badge--unset';
									$metricool_badge_text  = __( 'Not set — tracking inactive', 'restwell-retreats' );
								} elseif ( preg_match( '/^[a-f0-9]{32}$/i', $metricool_current ) ) {
									$metricool_badge_class = 'rw-ga4-badge rw-ga4-badge--active';
									$metricool_badge_text  = __( 'Active', 'restwell-retreats' );
								} else {
									$metricool_badge_class = 'rw-ga4-badge rw-ga4-badge--invalid';
									$metricool_badge_text  = __( 'Wrong format — should be a 32-character hash', 'restwell-retreats' );
								}
								?>
								<div class="rw-ga4-field-wrap">
								<input
									type="text"
									id="restwell_metricool_hash"
									name="restwell_metricool_hash"
									value="<?php echo esc_attr( $metricool_current ); ?>"
									class="regular-text"
									placeholder="0123456789abcdef0123456789abcdef"
								/>
									<span class="<?php echo esc_attr( $metricool_badge_class ); ?>" aria-live="polite">
										<?php echo esc_html( $metricool_badge_text ); ?>
									</span>
								</div>
								<p class="description">
									<?php esc_html_e( 'Optional. Paste your Metricool 32-character website tracking hash. When valid, tracking loads according to “Analytics script placement”.', 'restwell-retreats' ); ?>
								</p>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="restwell_analytics_load_mode">
									<?php esc_html_e( 'Analytics script placement', 'restwell-retreats' ); ?>
								</label>
							</th>
							<td>
								<?php
								$analytics_mode_current = (string) get_option( 'restwell_analytics_load_mode', 'head' );
								if ( ! in_array( $analytics_mode_current, array( 'head', 'footer_deferred', 'consent_gated' ), true ) ) {
									$analytics_mode_current = 'head';
								}
								?>
								<select name="restwell_analytics_load_mode" id="restwell_analytics_load_mode">
									<option value="head" <?php selected( $analytics_mode_current, 'head' ); ?>>
										<?php esc_html_e( 'Head — load immediately (default)', 'restwell-retreats' ); ?>
									</option>
									<option value="footer_deferred" <?php selected( $analytics_mode_current, 'footer_deferred' ); ?>>
										<?php esc_html_e( 'Footer — deferred loader (better for Core Web Vitals)', 'restwell-retreats' ); ?>
									</option>
									<option value="consent_gated" <?php selected( $analytics_mode_current, 'consent_gated' ); ?>>
										<?php esc_html_e( 'Consent-gated — load only after CMP / consent (recommended with a cookie banner)', 'restwell-retreats' ); ?>
									</option>
								</select>
								<p class="description">
									<?php esc_html_e( 'Consent-gated mode outputs Google Consent Mode defaults in the head and loads GA4 and Metricool only after consent — you do not need CookieAdmin Pro; the free plugin is enough. With CookieAdmin (free), the theme reads the cookieadmin_consent cookie (Accept all or Analytics). Other CMPs can call window.restwellGrantAnalyticsConsent() or dispatch document event restwell-analytics-allow. Cookiebot and CookieYes listeners are included; Complianz often works via cmplz_fire_categories when statistics cookies are allowed.', 'restwell-retreats' ); ?>
								</p>
								<p class="description">
									<?php esc_html_e( 'Verify Search Console using the meta tag above or DNS — GA placement no longer affects verification when using deferred or consent modes.', 'restwell-retreats' ); ?>
								</p>
							</td>
						</tr>
							<tr>
								<th scope="row">
									<label for="restwell_bing_verification">
										<?php esc_html_e( 'Bing Webmaster verification', 'restwell-retreats' ); ?>
									</label>
								</th>
								<td>
									<input
										type="text"
										id="restwell_bing_verification"
										name="restwell_bing_verification"
										value="<?php echo esc_attr( (string) get_option( 'restwell_bing_verification', '' ) ); ?>"
										class="regular-text"
									/>
									<p class="description">
										<?php esc_html_e( 'Paste the content value from Bing’s msvalidate.01 meta tag.', 'restwell-retreats' ); ?>
									</p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="restwell_access_statement_url">
										<?php esc_html_e( 'Access statement PDF URL', 'restwell-retreats' ); ?>
									</label>
								</th>
								<td>
									<input
										type="url"
										id="restwell_access_statement_url"
										name="restwell_access_statement_url"
										value="<?php echo esc_attr( (string) get_option( 'restwell_access_statement_url', '' ) ); ?>"
										class="regular-text"
										placeholder="https://"
									/>
									<p class="description">
										<?php esc_html_e( 'Upload the PDF to Media Library, then paste the file URL here. Linked from the footer and Accessibility page.', 'restwell-retreats' ); ?>
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
			</div>
		</div>
	</div>

	<!-- Export audit log -->
	<div class="rw-settings-wrap">
		<div class="postbox">
			<div class="postbox-header">
				<h2 class="hndle">
					<span class="rw-panel-title">
						<span class="rw-panel-title__icon" aria-hidden="true">&#128196;</span>
						<span><?php esc_html_e( 'Export Audit Log', 'restwell-retreats' ); ?></span>
					</span>
				</h2>
			</div>
			<div class="inside">
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
		</div>
	</div>

</div><!-- .wrap -->
	<?php
}

