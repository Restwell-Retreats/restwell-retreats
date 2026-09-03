<?php
/**
 * SEO → Site-wide: page sections.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Site-wide SEO check banner.
 *
 * @param array $issues Checklist issues.
 * @param array $counts Severity counts.
 */
function restwell_seo_sitewide_render_checklist( $issues, $counts ) {
	?>
		<div class="rw-seo-dash__checklist" id="rw-seo-sitewide-checklist" aria-live="polite">
			<div class="rw-seo-dash__checklist-head">
				<strong><?php esc_html_e( 'Site-wide SEO check', 'restwell-retreats' ); ?></strong>
				<?php if ( empty( $issues ) ) : ?>
					<span class="rw-seo-flag rw-seo-flag--ok"><?php esc_html_e( 'Looking good', 'restwell-retreats' ); ?></span>
				<?php else : ?>
					<?php if ( $counts['error'] > 0 ) : ?>
						<span class="rw-seo-flag rw-seo-flag--bad">
							<?php
							echo esc_html(
								sprintf(
									/* translators: %d: number of errors */
									_n( '%d must-fix', '%d must-fix', $counts['error'], 'restwell-retreats' ),
									$counts['error']
								)
							);
							?>
						</span>
					<?php endif; ?>
					<?php if ( $counts['warn'] > 0 ) : ?>
						<span class="rw-seo-flag rw-seo-flag--warn">
							<?php
							echo esc_html(
								sprintf(
									/* translators: %d: number of warnings */
									_n( '%d suggestion', '%d suggestions', $counts['warn'], 'restwell-retreats' ),
									$counts['warn']
								)
							);
							?>
						</span>
					<?php endif; ?>
					<?php if ( $counts['info'] > 0 ) : ?>
						<span class="rw-seo-flag rw-seo-flag--info">
							<?php
							echo esc_html(
								sprintf(
									/* translators: %d: number of tips */
									_n( '%d tip', '%d tips', $counts['info'], 'restwell-retreats' ),
									$counts['info']
								)
							);
							?>
						</span>
					<?php endif; ?>
				<?php endif; ?>
			</div>
			<?php if ( ! empty( $issues ) ) : ?>
				<ul class="rw-seo-dash__checklist-list">
					<?php foreach ( $issues as $issue ) : ?>
						<li class="rw-seo-dash__check rw-seo-dash__check--<?php echo esc_attr( $issue['severity'] ); ?>">
							<?php if ( ! empty( $issue['field'] ) ) : ?>
								<a href="#<?php echo esc_attr( $issue['field'] ); ?>"><?php echo esc_html( $issue['message'] ); ?></a>
							<?php else : ?>
								<?php echo esc_html( $issue['message'] ); ?>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php else : ?>
				<p class="rw-seo-dash__checklist-ok">
					<?php esc_html_e( 'Business details, verification, analytics, and AI readiness look set. Still run the monthly checklist on the right.', 'restwell-retreats' ); ?>
				</p>
			<?php endif; ?>
			<p class="rw-seo-dash__checklist-note">
				<?php esc_html_e( 'Tip: page titles and keyphrases are checked under SEO → All pages. This screen is for the whole site only.', 'restwell-retreats' ); ?>
			</p>
		</div>

	<?php
}

/**
 * Business details card (Organization / LocalBusiness).
 *
 * @param array $issues Checklist issues.
 */
function restwell_seo_sitewide_render_business_card( $issues ) {
	?>
				<section class="rw-seo-sitewide__card">
					<h2 class="rw-seo-sitewide__card-title"><?php esc_html_e( 'Business details (shown to Google)', 'restwell-retreats' ); ?></h2>
					<p class="rw-seo-sitewide__card-desc">
						<?php esc_html_e( 'Used for Organization / LocalBusiness structured data. Keep this aligned with your Google Business Profile.', 'restwell-retreats' ); ?>
					</p>

					<?php restwell_seo_sitewide_field_open( 'restwell_phone_number', __( 'Phone number', 'restwell-retreats' ), $issues ); ?>
						<input type="tel" class="rw-seo-field__input" id="restwell_phone_number" name="restwell_phone_number" value="<?php echo esc_attr( (string) get_option( 'restwell_phone_number', '01622 809881' ) ); ?>" />
						<p class="rw-seo-field__hint"><?php esc_html_e( 'Also used in the site footer and email templates.', 'restwell-retreats' ); ?></p>
					<?php restwell_seo_sitewide_field_close(); ?>

					<?php restwell_seo_sitewide_field_open( 'restwell_business_street', __( 'Business street', 'restwell-retreats' ), $issues ); ?>
						<input type="text" class="rw-seo-field__input" id="restwell_business_street" name="restwell_business_street" value="<?php echo esc_attr( (string) get_option( 'restwell_business_street', 'Vinters Business Park' ) ); ?>" />
					<?php restwell_seo_sitewide_field_close(); ?>

					<div class="rw-seo-sitewide__grid">
						<?php restwell_seo_sitewide_field_open( 'restwell_business_locality', __( 'Town / city', 'restwell-retreats' ), $issues ); ?>
							<input type="text" class="rw-seo-field__input" id="restwell_business_locality" name="restwell_business_locality" value="<?php echo esc_attr( (string) get_option( 'restwell_business_locality', 'Maidstone' ) ); ?>" />
						<?php restwell_seo_sitewide_field_close(); ?>

						<?php restwell_seo_sitewide_field_open( 'restwell_business_region', __( 'County / region', 'restwell-retreats' ), $issues ); ?>
							<input type="text" class="rw-seo-field__input" id="restwell_business_region" name="restwell_business_region" value="<?php echo esc_attr( (string) get_option( 'restwell_business_region', 'Kent' ) ); ?>" />
						<?php restwell_seo_sitewide_field_close(); ?>

						<?php restwell_seo_sitewide_field_open( 'restwell_business_postcode', __( 'Postcode', 'restwell-retreats' ), $issues ); ?>
							<input type="text" class="rw-seo-field__input" id="restwell_business_postcode" name="restwell_business_postcode" value="<?php echo esc_attr( (string) get_option( 'restwell_business_postcode', 'ME14 5NZ' ) ); ?>" />
						<?php restwell_seo_sitewide_field_close(); ?>

						<?php restwell_seo_sitewide_field_open( 'restwell_business_geo_lat', __( 'Latitude (optional)', 'restwell-retreats' ), $issues ); ?>
							<input type="text" class="rw-seo-field__input" id="restwell_business_geo_lat" name="restwell_business_geo_lat" value="<?php echo esc_attr( (string) get_option( 'restwell_business_geo_lat', '51.2707' ) ); ?>" />
						<?php restwell_seo_sitewide_field_close(); ?>

						<?php restwell_seo_sitewide_field_open( 'restwell_business_geo_lon', __( 'Longitude (optional)', 'restwell-retreats' ), $issues ); ?>
							<input type="text" class="rw-seo-field__input" id="restwell_business_geo_lon" name="restwell_business_geo_lon" value="<?php echo esc_attr( (string) get_option( 'restwell_business_geo_lon', '0.5207' ) ); ?>" />
						<?php restwell_seo_sitewide_field_close(); ?>
					</div>
				</section>

	<?php
}

/**
 * Search Console / Bing verification card.
 *
 * @param array $issues Checklist issues.
 */
function restwell_seo_sitewide_render_verification_card( $issues ) {
	$bing_from_constant = defined( 'RESTWELL_BING_WEBMASTER_API_KEY' ) && '' !== (string) RESTWELL_BING_WEBMASTER_API_KEY;
	$bing_key_stored    = (string) get_option( 'restwell_bing_webmaster_api_key', '' );
	$bing_prod_locked   = function_exists( 'restwell_is_production_environment' ) && restwell_is_production_environment();
	$bing_key_masked    = '';
	if ( '' !== $bing_key_stored ) {
		$bing_key_masked = '************' . substr( $bing_key_stored, -4 );
	}

	$bing_configured = function_exists( 'restwell_bing_webmaster_is_configured' ) && restwell_bing_webmaster_is_configured();
	$bing_status     = function_exists( 'restwell_bing_webmaster_get_status' )
		? restwell_bing_webmaster_get_status()
		: array(
			'ok'         => false,
			'site_url'   => '',
			'checked_at' => 0,
			'message'    => '',
		);

	if ( $bing_configured && ! empty( $bing_status['ok'] ) ) {
		$bing_badge_class = 'rw-seo-flag rw-seo-flag--ok';
		$bing_badge_text  = __( 'REST connected', 'restwell-retreats' );
	} elseif ( $bing_configured && ! empty( $bing_status['key_ok'] ) ) {
		$bing_badge_class = 'rw-seo-flag rw-seo-flag--ok';
		$bing_badge_text  = __( 'API key valid', 'restwell-retreats' );
	} elseif ( $bing_configured ) {
		$bing_badge_class = 'rw-seo-flag rw-seo-flag--warn';
		$bing_badge_text  = __( 'Key set — not connected yet', 'restwell-retreats' );
	} else {
		$bing_badge_class = 'rw-seo-flag rw-seo-flag--info';
		$bing_badge_text  = __( 'Not configured', 'restwell-retreats' );
	}
	?>
				<section class="rw-seo-sitewide__card">
					<h2 class="rw-seo-sitewide__card-title"><?php esc_html_e( 'Search verification', 'restwell-retreats' ); ?></h2>

					<?php restwell_seo_sitewide_field_open( 'restwell_gsc_verification', __( 'Google Search Console', 'restwell-retreats' ), $issues ); ?>
						<input type="text" class="rw-seo-field__input" id="restwell_gsc_verification" name="restwell_gsc_verification" value="<?php echo esc_attr( (string) get_option( 'restwell_gsc_verification', '' ) ); ?>" placeholder="ABC123..." />
						<p class="rw-seo-field__hint"><?php esc_html_e( 'Paste the content value from the Google HTML meta tag verification method.', 'restwell-retreats' ); ?></p>
					<?php restwell_seo_sitewide_field_close(); ?>

					<?php restwell_seo_sitewide_field_open( 'restwell_bing_verification', __( 'Bing Webmaster verification', 'restwell-retreats' ), $issues ); ?>
						<input type="text" class="rw-seo-field__input" id="restwell_bing_verification" name="restwell_bing_verification" value="<?php echo esc_attr( (string) get_option( 'restwell_bing_verification', '' ) ); ?>" />
						<p class="rw-seo-field__hint"><?php esc_html_e( 'msvalidate.01 meta content. Proves the site to Bing. Not the API key.', 'restwell-retreats' ); ?></p>
					<?php restwell_seo_sitewide_field_close(); ?>

					<?php restwell_seo_sitewide_field_open( 'restwell_bing_webmaster_api_key', __( 'Bing Webmaster API key', 'restwell-retreats' ), $issues ); ?>
						<div class="rw-seo-sitewide__inline">
							<input
								type="password"
								class="rw-seo-field__input"
								id="restwell_bing_webmaster_api_key"
								name="restwell_bing_webmaster_api_key"
								value=""
								autocomplete="new-password"
								placeholder="<?php echo esc_attr( $bing_key_masked ); ?>"
								<?php disabled( $bing_from_constant || $bing_prod_locked ); ?>
							/>
							<span class="<?php echo esc_attr( $bing_badge_class ); ?>" aria-live="polite"><?php echo esc_html( $bing_badge_text ); ?></span>
						</div>
						<p class="rw-seo-field__hint">
							<?php
							if ( $bing_from_constant ) {
								esc_html_e( 'RESTWELL_BING_WEBMASTER_API_KEY is set in wp-config.php (or the environment). This field is unused while that constant is defined.', 'restwell-retreats' );
							} elseif ( $bing_prod_locked ) {
								esc_html_e( 'Production will not store this key in the database. Define RESTWELL_BING_WEBMASTER_API_KEY in wp-config.php.', 'restwell-retreats' );
							} else {
								esc_html_e( 'Settings → API Access in Bing Webmaster Tools. REST JSON only (SOAP/POX retired 31 Aug 2026). Leave blank to keep an existing key.', 'restwell-retreats' );
							}
							?>
						</p>
						<?php if ( ! $bing_from_constant && ! $bing_prod_locked ) : ?>
							<p class="rw-seo-field__hint">
								<label>
									<input type="checkbox" name="restwell_bing_webmaster_api_key_clear" value="1" />
									<?php esc_html_e( 'Clear stored API key on save', 'restwell-retreats' ); ?>
								</label>
							</p>
						<?php endif; ?>
						<?php if ( $bing_status['message'] !== '' ) : ?>
							<p class="rw-seo-field__hint">
								<?php echo esc_html( $bing_status['message'] ); ?>
							</p>
						<?php endif; ?>
					<?php restwell_seo_sitewide_field_close(); ?>
				</section>

	<?php
}

/**
 * GA4 / Metricool / load-mode card.
 *
 * @param array  $issues                 Checklist issues.
 * @param string $ga4_current            Measurement ID.
 * @param string $ga4_badge_class        Badge class.
 * @param string $ga4_badge_text         Badge label.
 * @param string $metricool_current      Hash.
 * @param string $metricool_badge_class  Badge class.
 * @param string $metricool_badge_text   Badge label.
 * @param string $analytics_mode_current Load mode.
 */
function restwell_seo_sitewide_render_analytics_card(
	$issues,
	$ga4_current,
	$ga4_badge_class,
	$ga4_badge_text,
	$metricool_current,
	$metricool_badge_class,
	$metricool_badge_text,
	$analytics_mode_current
) {
	?>
				<section class="rw-seo-sitewide__card">
					<h2 class="rw-seo-sitewide__card-title"><?php esc_html_e( 'Analytics & tracking', 'restwell-retreats' ); ?></h2>

					<?php restwell_seo_sitewide_field_open( 'restwell_ga4_measurement_id', __( 'Google Analytics 4', 'restwell-retreats' ), $issues ); ?>
						<div class="rw-seo-sitewide__inline">
							<input type="text" class="rw-seo-field__input" id="restwell_ga4_measurement_id" name="restwell_ga4_measurement_id" value="<?php echo esc_attr( $ga4_current ); ?>" placeholder="G-XXXXXXXXXX" />
							<span class="<?php echo esc_attr( $ga4_badge_class ); ?>" aria-live="polite"><?php echo esc_html( $ga4_badge_text ); ?></span>
						</div>
						<p class="rw-seo-field__hint"><?php esc_html_e( 'Optional. Measurement ID starts with G-.', 'restwell-retreats' ); ?></p>
					<?php restwell_seo_sitewide_field_close(); ?>

					<?php restwell_seo_sitewide_field_open( 'restwell_metricool_hash', __( 'Metricool hash', 'restwell-retreats' ), $issues ); ?>
						<div class="rw-seo-sitewide__inline">
							<input type="text" class="rw-seo-field__input" id="restwell_metricool_hash" name="restwell_metricool_hash" value="<?php echo esc_attr( $metricool_current ); ?>" placeholder="0123456789abcdef0123456789abcdef" />
							<span class="<?php echo esc_attr( $metricool_badge_class ); ?>" aria-live="polite"><?php echo esc_html( $metricool_badge_text ); ?></span>
						</div>
					<?php restwell_seo_sitewide_field_close(); ?>

					<?php restwell_seo_sitewide_field_open( 'restwell_analytics_load_mode', __( 'When to load analytics', 'restwell-retreats' ), $issues ); ?>
						<select class="rw-seo-field__input rw-seo-field__input--select" name="restwell_analytics_load_mode" id="restwell_analytics_load_mode">
							<option value="head" <?php selected( $analytics_mode_current, 'head' ); ?>><?php esc_html_e( 'Head — load immediately', 'restwell-retreats' ); ?></option>
							<option value="footer_deferred" <?php selected( $analytics_mode_current, 'footer_deferred' ); ?>><?php esc_html_e( 'Footer — deferred (better for page speed)', 'restwell-retreats' ); ?></option>
							<option value="consent_gated" <?php selected( $analytics_mode_current, 'consent_gated' ); ?>><?php esc_html_e( 'Consent-gated — only after cookie consent', 'restwell-retreats' ); ?></option>
						</select>
						<p class="rw-seo-field__hint"><?php esc_html_e( 'Consent-gated is the PECR-safe default: the theme cookie banner stores the choice, and GA4/Metricool stay off until the visitor accepts analytics. Head and Footer deferred load tracking without that consent.', 'restwell-retreats' ); ?></p>
					<?php restwell_seo_sitewide_field_close(); ?>
				</section>

	<?php
}

/**
 * Read-only social profile URLs.
 *
 * @param array $social_urls Network => URL.
 */
function restwell_seo_sitewide_render_social_card( $social_urls ) {
	?>
				<?php if ( ! empty( $social_urls ) ) : ?>
					<section class="rw-seo-sitewide__card">
						<h2 class="rw-seo-sitewide__card-title"><?php esc_html_e( 'Social profiles (read-only)', 'restwell-retreats' ); ?></h2>
						<p class="rw-seo-sitewide__card-desc"><?php esc_html_e( 'These power footer links and schema sameAs. They are set in the theme code for now.', 'restwell-retreats' ); ?></p>
						<ul class="rw-seo-sitewide__links">
							<?php foreach ( $social_urls as $network => $url ) : ?>
								<li>
									<strong><?php echo esc_html( ucfirst( $network ) ); ?></strong>
									<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $url ); ?></a>
								</li>
							<?php endforeach; ?>
						</ul>
					</section>
				<?php endif; ?>

	<?php
}

/**
 * Website copy that is not Google schema.
 *
 * @param array $issues Checklist issues.
 */
function restwell_seo_sitewide_render_copy_card( $issues ) {
	?>
				<section class="rw-seo-sitewide__card" id="rw-seo-sitewide-copy">
					<h2 class="rw-seo-sitewide__card-title"><?php esc_html_e( 'Website copy (not for Google)', 'restwell-retreats' ); ?></h2>
					<p class="rw-seo-sitewide__card-desc">
						<?php esc_html_e( 'Shared text shown on the live site. Separate from the business address Google sees above.', 'restwell-retreats' ); ?>
					</p>

					<div class="rw-seo-sitewide__grid">
						<?php restwell_seo_sitewide_field_open( 'restwell_property_address', __( 'Property street address', 'restwell-retreats' ), $issues ); ?>
							<input type="text" class="rw-seo-field__input" id="restwell_property_address" name="restwell_property_address" value="<?php echo esc_attr( (string) get_option( 'restwell_property_address', '101 Russell Drive' ) ); ?>" />
							<p class="rw-seo-field__hint"><?php esc_html_e( 'Published in Google schema without the house number.', 'restwell-retreats' ); ?></p>
						<?php restwell_seo_sitewide_field_close(); ?>

						<?php restwell_seo_sitewide_field_open( 'restwell_property_postcode', __( 'Property postcode', 'restwell-retreats' ), $issues ); ?>
							<input type="text" class="rw-seo-field__input" id="restwell_property_postcode" name="restwell_property_postcode" value="<?php echo esc_attr( (string) get_option( 'restwell_property_postcode', 'CT5 2RQ' ) ); ?>" />
						<?php restwell_seo_sitewide_field_close(); ?>
					</div>

					<?php restwell_seo_sitewide_field_open( 'restwell_footer_cta_heading', __( 'Footer CTA heading', 'restwell-retreats' ), $issues ); ?>
						<input type="text" class="rw-seo-field__input" id="restwell_footer_cta_heading" name="restwell_footer_cta_heading" value="<?php echo esc_attr( (string) get_option( 'restwell_footer_cta_heading', '' ) ); ?>" placeholder="<?php esc_attr_e( 'Ready to plan your break?', 'restwell-retreats' ); ?>" />
					<?php restwell_seo_sitewide_field_close(); ?>

					<?php restwell_seo_sitewide_field_open( 'restwell_footer_cta_intro', __( 'Footer CTA intro', 'restwell-retreats' ), $issues ); ?>
						<textarea class="rw-seo-field__input rw-seo-field__input--area" id="restwell_footer_cta_intro" name="restwell_footer_cta_intro" rows="3"><?php echo esc_textarea( (string) get_option( 'restwell_footer_cta_intro', '' ) ); ?></textarea>
						<p class="rw-seo-field__hint"><?php esc_html_e( 'Leave empty to use the theme default.', 'restwell-retreats' ); ?></p>
					<?php restwell_seo_sitewide_field_close(); ?>

					<div class="rw-seo-sitewide__grid">
						<?php restwell_seo_sitewide_field_open( 'restwell_footer_cta_primary_label', __( 'Primary button label', 'restwell-retreats' ), $issues ); ?>
							<input type="text" class="rw-seo-field__input" id="restwell_footer_cta_primary_label" name="restwell_footer_cta_primary_label" value="<?php echo esc_attr( (string) get_option( 'restwell_footer_cta_primary_label', '' ) ); ?>" placeholder="<?php esc_attr_e( 'See the property', 'restwell-retreats' ); ?>" />
						<?php restwell_seo_sitewide_field_close(); ?>

						<?php restwell_seo_sitewide_field_open( 'restwell_footer_cta_primary_url', __( 'Primary button URL', 'restwell-retreats' ), $issues ); ?>
							<input type="text" class="rw-seo-field__input" id="restwell_footer_cta_primary_url" name="restwell_footer_cta_primary_url" value="<?php echo esc_attr( (string) get_option( 'restwell_footer_cta_primary_url', '' ) ); ?>" placeholder="<?php echo esc_attr( home_url( '/the-property/' ) ); ?>" />
						<?php restwell_seo_sitewide_field_close(); ?>

						<?php restwell_seo_sitewide_field_open( 'restwell_footer_cta_btn', __( 'Secondary button label', 'restwell-retreats' ), $issues ); ?>
							<input type="text" class="rw-seo-field__input" id="restwell_footer_cta_btn" name="restwell_footer_cta_btn" value="<?php echo esc_attr( (string) get_option( 'restwell_footer_cta_btn', '' ) ); ?>" placeholder="<?php esc_attr_e( 'Ask about your dates', 'restwell-retreats' ); ?>" />
							<p class="rw-seo-field__hint"><?php esc_html_e( 'Usually links to the Enquire page.', 'restwell-retreats' ); ?></p>
						<?php restwell_seo_sitewide_field_close(); ?>

						<?php restwell_seo_sitewide_field_open( 'restwell_footer_cta_note', __( 'Reassurance line', 'restwell-retreats' ), $issues ); ?>
							<input type="text" class="rw-seo-field__input" id="restwell_footer_cta_note" name="restwell_footer_cta_note" value="<?php echo esc_attr( (string) get_option( 'restwell_footer_cta_note', '' ) ); ?>" placeholder="<?php esc_attr_e( 'No booking commitment. Just a conversation.', 'restwell-retreats' ); ?>" />
						<?php restwell_seo_sitewide_field_close(); ?>
					</div>

					<?php restwell_seo_sitewide_field_open( 'restwell_access_statement_url', __( 'Access statement PDF URL', 'restwell-retreats' ), $issues ); ?>
						<input type="url" class="rw-seo-field__input" id="restwell_access_statement_url" name="restwell_access_statement_url" value="<?php echo esc_attr( (string) get_option( 'restwell_access_statement_url', '' ) ); ?>" placeholder="https://" />
						<p class="rw-seo-field__hint"><?php esc_html_e( 'Upload the PDF to Media Library, then paste the file URL.', 'restwell-retreats' ); ?></p>
					<?php restwell_seo_sitewide_field_close(); ?>
				</section>

	<?php
}

/**
 * Sitemap / monthly checklist aside.
 *
 * @param string $sitemap Sitemap URL.
 * @param string $llms    llms.txt URL.
 */
function restwell_seo_sitewide_render_aside( $sitemap, $llms ) {
	?>
			<aside class="rw-seo-sitewide__aside">
				<div class="rw-seo-sitewide__card rw-seo-sitewide__card--aside">
					<h2 class="rw-seo-sitewide__card-title"><?php esc_html_e( 'Quick links', 'restwell-retreats' ); ?></h2>
					<ul class="rw-seo-sitewide__links">
						<li>
							<a href="<?php echo esc_url( $sitemap ); ?>" target="_blank" rel="noopener noreferrer">
								<?php esc_html_e( 'XML sitemap', 'restwell-retreats' ); ?>
							</a>
						</li>
						<li>
							<a href="<?php echo esc_url( $llms ); ?>" target="_blank" rel="noopener noreferrer">
								<?php esc_html_e( 'llms.txt (AI / GEO)', 'restwell-retreats' ); ?>
							</a>
						</li>
						<li>
							<a href="<?php echo esc_url( admin_url( 'admin.php?page=restwell-seo' ) ); ?>">
								<?php esc_html_e( 'SEO → All pages', 'restwell-retreats' ); ?>
							</a>
						</li>
						<li>
							<a href="<?php echo esc_url( admin_url( 'admin.php?page=restwell-seo-posts' ) ); ?>">
								<?php esc_html_e( 'SEO → Blog posts', 'restwell-retreats' ); ?>
							</a>
						</li>
					</ul>
				</div>

				<div class="rw-seo-sitewide__card rw-seo-sitewide__card--aside">
					<h2 class="rw-seo-sitewide__card-title"><?php esc_html_e( 'Monthly SEO checklist', 'restwell-retreats' ); ?></h2>
					<ul class="rw-seo-sitewide__checklist-manual">
						<li><?php esc_html_e( 'Search Console: coverage, Core Web Vitals, top queries and CTR.', 'restwell-retreats' ); ?></li>
						<li><?php esc_html_e( 'Bing Webmaster: crawl errors and query stats (Copilot).', 'restwell-retreats' ); ?></li>
						<li><?php esc_html_e( 'Analytics: landing pages and enquiry conversions.', 'restwell-retreats' ); ?></li>
						<li><?php esc_html_e( 'Confirm the XML sitemap link still works.', 'restwell-retreats' ); ?></li>
						<li><?php esc_html_e( 'Update titles/meta on pages with low CTR.', 'restwell-retreats' ); ?></li>
						<li><?php esc_html_e( 'Refresh one older blog post with internal links to core pages.', 'restwell-retreats' ); ?></li>
						<li><?php esc_html_e( 'Off-site SEO: finish Google Business Profile (categories, services, photos, Q&A).', 'restwell-retreats' ); ?></li>
						<li><?php esc_html_e( 'Directories when ready: Tourism for All, DisabledHolidays, AccessAble, Euan’s Guide, Visit Kent.', 'restwell-retreats' ); ?></li>
						<li><?php esc_html_e( 'Ask Continuity Group sites for a footer link.', 'restwell-retreats' ); ?></li>
					</ul>
				</div>
			</aside>

	<?php
}

/**
 * Render SEO → Site-wide page.
 */
function restwell_seo_sitewide_render_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You do not have permission to access this page.', 'restwell-retreats' ), '', array( 'response' => 403 ) );
	}

	$updated          = isset( $_GET['updated'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$bing_key_blocked = isset( $_GET['bing_key_blocked'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$sitemap = home_url( '/wp-sitemap.xml' );
	$llms    = home_url( '/llms.txt' );

	$ga4_current = (string) get_option( 'restwell_ga4_measurement_id', '' );
	if ( $ga4_current === '' ) {
		$ga4_badge_class = 'rw-seo-flag rw-seo-flag--bad';
		$ga4_badge_text  = __( 'Not set — analytics inactive', 'restwell-retreats' );
	} elseif ( preg_match( '/^G-[A-Z0-9]+$/i', $ga4_current ) ) {
		$ga4_badge_class = 'rw-seo-flag rw-seo-flag--ok';
		$ga4_badge_text  = __( 'Active', 'restwell-retreats' );
	} else {
		$ga4_badge_class = 'rw-seo-flag rw-seo-flag--warn';
		$ga4_badge_text  = __( 'Wrong format — should be G-XXXXXXXXXX', 'restwell-retreats' );
	}

	$metricool_current = (string) get_option( 'restwell_metricool_hash', '' );
	if ( $metricool_current === '' ) {
		$metricool_badge_class = 'rw-seo-flag rw-seo-flag--warn';
		$metricool_badge_text  = __( 'Not set — tracking inactive', 'restwell-retreats' );
	} elseif ( preg_match( '/^[a-f0-9]{32}$/i', $metricool_current ) ) {
		$metricool_badge_class = 'rw-seo-flag rw-seo-flag--ok';
		$metricool_badge_text  = __( 'Active', 'restwell-retreats' );
	} else {
		$metricool_badge_class = 'rw-seo-flag rw-seo-flag--bad';
		$metricool_badge_text  = __( 'Wrong format — should be a 32-character hash', 'restwell-retreats' );
	}

	$analytics_mode_current = (string) get_option( 'restwell_analytics_load_mode', 'consent_gated' );
	if ( ! in_array( $analytics_mode_current, array( 'head', 'footer_deferred', 'consent_gated' ), true ) ) {
		$analytics_mode_current = 'consent_gated';
	}

	$social_urls = function_exists( 'restwell_get_social_profile_urls' ) ? restwell_get_social_profile_urls() : array();
	$issues      = function_exists( 'restwell_seo_checklist_sitewide' ) ? restwell_seo_checklist_sitewide() : array();
	$counts      = function_exists( 'restwell_seo_checklist_count_severities' )
		? restwell_seo_checklist_count_severities( $issues )
		: array(
			'error' => 0,
			'warn'  => 0,
			'info'  => 0,
		);
	?>
	<div class="wrap rw-seo-dash rw-seo-sitewide">
		<h1><?php esc_html_e( 'SEO — Site-wide', 'restwell-retreats' ); ?></h1>
		<p class="rw-seo-sitewide__lead">
			<?php esc_html_e( 'Settings that apply to the whole site (not one page). For page titles and descriptions, use SEO → All pages.', 'restwell-retreats' ); ?>
		</p>

		<?php if ( $updated ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Site-wide SEO settings saved.', 'restwell-retreats' ); ?></p></div>
		<?php endif; ?>
		<?php if ( $bing_key_blocked ) : ?>
			<div class="notice notice-warning is-dismissible"><p><?php esc_html_e( 'The Bing Webmaster API key was not saved. On production it must live in RESTWELL_BING_WEBMASTER_API_KEY (wp-config or the environment), not in the database.', 'restwell-retreats' ); ?></p></div>
		<?php endif; ?>

		<?php restwell_seo_sitewide_render_checklist( $issues, $counts ); ?>

		<div class="rw-seo-sitewide__layout">
			<form class="rw-seo-sitewide__form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<?php wp_nonce_field( 'restwell_seo_sitewide' ); ?>
				<input type="hidden" name="action" value="restwell_save_seo_sitewide" />
				<?php
				restwell_seo_sitewide_render_business_card( $issues );
				restwell_seo_sitewide_render_verification_card( $issues );
				restwell_seo_sitewide_render_analytics_card(
					$issues,
					$ga4_current,
					$ga4_badge_class,
					$ga4_badge_text,
					$metricool_current,
					$metricool_badge_class,
					$metricool_badge_text,
					$analytics_mode_current
				);
				restwell_seo_sitewide_render_social_card( $social_urls );
				restwell_seo_sitewide_render_copy_card( $issues );
				?>
				<p class="rw-seo-sitewide__submit">
					<?php submit_button( __( 'Save site-wide settings', 'restwell-retreats' ), 'primary large', 'submit', false ); ?>
				</p>
			</form>
			<?php restwell_seo_sitewide_render_aside( $sitemap, $llms ); ?>
		</div>
	</div>
	<?php
}
