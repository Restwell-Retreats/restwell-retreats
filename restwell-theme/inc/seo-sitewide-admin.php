<?php
/**
 * SEO → Site-wide settings (verification, analytics, business schema).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Site-wide under the SEO menu.
 */
function restwell_seo_sitewide_register_menu() {
	add_submenu_page(
		'restwell-seo',
		__( 'Site-wide', 'restwell-retreats' ),
		__( 'Site-wide', 'restwell-retreats' ),
		'manage_options',
		'restwell-seo-sitewide',
		'restwell_seo_sitewide_render_page'
	);
}
add_action( 'admin_menu', 'restwell_seo_sitewide_register_menu', 20 );

/**
 * Save site-wide SEO options.
 */
function restwell_seo_sitewide_handle_save() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You do not have permission to change these settings.', 'restwell-retreats' ), '', array( 'response' => 403 ) );
	}
	check_admin_referer( 'restwell_seo_sitewide' );

	$phone = isset( $_POST['restwell_phone_number'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_phone_number'] ) )
		: '';
	update_option( 'restwell_phone_number', $phone );

	$business_street = isset( $_POST['restwell_business_street'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_business_street'] ) )
		: '';
	update_option( 'restwell_business_street', $business_street );

	$business_locality = isset( $_POST['restwell_business_locality'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_business_locality'] ) )
		: '';
	update_option( 'restwell_business_locality', $business_locality );

	$business_region = isset( $_POST['restwell_business_region'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_business_region'] ) )
		: '';
	update_option( 'restwell_business_region', $business_region );

	$business_postcode = isset( $_POST['restwell_business_postcode'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_business_postcode'] ) )
		: '';
	update_option( 'restwell_business_postcode', $business_postcode );

	$business_geo_lat = isset( $_POST['restwell_business_geo_lat'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_business_geo_lat'] ) )
		: '';
	update_option( 'restwell_business_geo_lat', $business_geo_lat );

	$business_geo_lon = isset( $_POST['restwell_business_geo_lon'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_business_geo_lon'] ) )
		: '';
	update_option( 'restwell_business_geo_lon', $business_geo_lon );

	$gsc = isset( $_POST['restwell_gsc_verification'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_gsc_verification'] ) )
		: '';
	update_option( 'restwell_gsc_verification', $gsc );

	$bing = isset( $_POST['restwell_bing_verification'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_bing_verification'] ) )
		: '';
	update_option( 'restwell_bing_verification', preg_replace( '/[^0-9A-Za-z]/', '', $bing ) );

	$ga4 = isset( $_POST['restwell_ga4_measurement_id'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_ga4_measurement_id'] ) )
		: '';
	$ga4 = preg_replace( '/\s+/', '', $ga4 );
	update_option( 'restwell_ga4_measurement_id', $ga4 );

	$metricool_hash = isset( $_POST['restwell_metricool_hash'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_metricool_hash'] ) )
		: '';
	$metricool_hash = strtolower( preg_replace( '/[^0-9A-Za-z]/', '', $metricool_hash ) );
	update_option( 'restwell_metricool_hash', $metricool_hash );

	$analytics_mode = isset( $_POST['restwell_analytics_load_mode'] )
		? sanitize_key( wp_unslash( $_POST['restwell_analytics_load_mode'] ) )
		: 'head';
	if ( ! in_array( $analytics_mode, array( 'head', 'footer_deferred', 'consent_gated' ), true ) ) {
		$analytics_mode = 'head';
	}
	update_option( 'restwell_analytics_load_mode', $analytics_mode );

	// Website copy (not Google schema) — kept here so CRM save cannot touch it.
	$property_address = isset( $_POST['restwell_property_address'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_property_address'] ) )
		: '';
	update_option( 'restwell_property_address', $property_address );

	$property_postcode = isset( $_POST['restwell_property_postcode'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_property_postcode'] ) )
		: '';
	update_option( 'restwell_property_postcode', $property_postcode );

	$footer_heading = isset( $_POST['restwell_footer_cta_heading'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_footer_cta_heading'] ) )
		: '';
	update_option( 'restwell_footer_cta_heading', $footer_heading );

	$footer_intro = isset( $_POST['restwell_footer_cta_intro'] )
		? sanitize_textarea_field( wp_unslash( $_POST['restwell_footer_cta_intro'] ) )
		: '';
	update_option( 'restwell_footer_cta_intro', $footer_intro );

	$footer_primary_label = isset( $_POST['restwell_footer_cta_primary_label'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_footer_cta_primary_label'] ) )
		: '';
	update_option( 'restwell_footer_cta_primary_label', $footer_primary_label );

	$footer_primary_url = isset( $_POST['restwell_footer_cta_primary_url'] )
		? esc_url_raw( wp_unslash( $_POST['restwell_footer_cta_primary_url'] ) )
		: '';
	update_option( 'restwell_footer_cta_primary_url', $footer_primary_url );

	$footer_btn = isset( $_POST['restwell_footer_cta_btn'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_footer_cta_btn'] ) )
		: '';
	update_option( 'restwell_footer_cta_btn', $footer_btn );

	$footer_note = isset( $_POST['restwell_footer_cta_note'] )
		? sanitize_text_field( wp_unslash( $_POST['restwell_footer_cta_note'] ) )
		: '';
	update_option( 'restwell_footer_cta_note', $footer_note );

	$access_pdf = isset( $_POST['restwell_access_statement_url'] )
		? esc_url_raw( wp_unslash( $_POST['restwell_access_statement_url'] ) )
		: '';
	update_option( 'restwell_access_statement_url', $access_pdf );

	wp_safe_redirect(
		add_query_arg(
			array(
				'page'    => 'restwell-seo-sitewide',
				'updated' => '1',
			),
			admin_url( 'admin.php' )
		)
	);
	exit;
}
add_action( 'admin_post_restwell_save_seo_sitewide', 'restwell_seo_sitewide_handle_save' );

/**
 * Whether a field id should be highlighted from checklist issues.
 *
 * @param string                           $field_id Field HTML id.
 * @param array<int, array{field?:string}> $issues   Issues.
 * @return bool
 */
function restwell_seo_sitewide_field_has_issue( string $field_id, array $issues ): bool {
	foreach ( $issues as $issue ) {
		if ( isset( $issue['field'] ) && $issue['field'] === $field_id ) {
			return true;
		}
	}
	return false;
}

/**
 * Open a site-wide field row.
 *
 * @param string $field_id Field id (for flagging + jump links).
 * @param string $label    Label text.
 * @param array  $issues   Checklist issues.
 * @param string $for_id   Optional label for= id (defaults to field_id).
 */
function restwell_seo_sitewide_field_open( string $field_id, string $label, array $issues, string $for_id = '' ): void {
	$for_id = $for_id !== '' ? $for_id : $field_id;
	$class  = 'rw-seo-field';
	if ( restwell_seo_sitewide_field_has_issue( $field_id, $issues ) ) {
		$class .= ' rw-seo-field--flagged';
	}
	printf( '<div class="%s">', esc_attr( $class ) );
	printf(
		'<label class="rw-seo-field__label" for="%s">%s</label>',
		esc_attr( $for_id ),
		esc_html( $label )
	);
	echo '<div class="rw-seo-field__control">';
}

/**
 * Close a site-wide field row.
 */
function restwell_seo_sitewide_field_close(): void {
	echo '</div></div>';
}

/**
 * Render SEO → Site-wide page.
 */
function restwell_seo_sitewide_render_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You do not have permission to access this page.', 'restwell-retreats' ), '', array( 'response' => 403 ) );
	}

	$updated = isset( $_GET['updated'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
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

	$analytics_mode_current = (string) get_option( 'restwell_analytics_load_mode', 'head' );
	if ( ! in_array( $analytics_mode_current, array( 'head', 'footer_deferred', 'consent_gated' ), true ) ) {
		$analytics_mode_current = 'head';
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

		<div class="rw-seo-sitewide__layout">
			<form class="rw-seo-sitewide__form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<?php wp_nonce_field( 'restwell_seo_sitewide' ); ?>
				<input type="hidden" name="action" value="restwell_save_seo_sitewide" />

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

				<section class="rw-seo-sitewide__card">
					<h2 class="rw-seo-sitewide__card-title"><?php esc_html_e( 'Search verification', 'restwell-retreats' ); ?></h2>

					<?php restwell_seo_sitewide_field_open( 'restwell_gsc_verification', __( 'Google Search Console', 'restwell-retreats' ), $issues ); ?>
						<input type="text" class="rw-seo-field__input" id="restwell_gsc_verification" name="restwell_gsc_verification" value="<?php echo esc_attr( (string) get_option( 'restwell_gsc_verification', '' ) ); ?>" placeholder="ABC123..." />
						<p class="rw-seo-field__hint"><?php esc_html_e( 'Paste the content value from the Google HTML meta tag verification method.', 'restwell-retreats' ); ?></p>
					<?php restwell_seo_sitewide_field_close(); ?>

					<?php restwell_seo_sitewide_field_open( 'restwell_bing_verification', __( 'Bing Webmaster', 'restwell-retreats' ), $issues ); ?>
						<input type="text" class="rw-seo-field__input" id="restwell_bing_verification" name="restwell_bing_verification" value="<?php echo esc_attr( (string) get_option( 'restwell_bing_verification', '' ) ); ?>" />
						<p class="rw-seo-field__hint"><?php esc_html_e( 'Paste the content value from Bing’s msvalidate.01 meta tag.', 'restwell-retreats' ); ?></p>
					<?php restwell_seo_sitewide_field_close(); ?>
				</section>

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
						<p class="rw-seo-field__hint"><?php esc_html_e( 'Consent-gated is best if you use a cookie banner. GA4 and Metricool wait until analytics consent is given.', 'restwell-retreats' ); ?></p>
					<?php restwell_seo_sitewide_field_close(); ?>
				</section>

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

				<p class="rw-seo-sitewide__submit">
					<?php submit_button( __( 'Save site-wide settings', 'restwell-retreats' ), 'primary large', 'submit', false ); ?>
				</p>
			</form>

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
		</div>
	</div>
	<?php
}
