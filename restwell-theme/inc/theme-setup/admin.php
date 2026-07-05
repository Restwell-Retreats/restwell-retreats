<?php
/**
 * Theme setup: WP Admin screen and setup result formatting.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function restwell_theme_setup_admin_menu() {
	add_theme_page(
		__( 'Theme Setup', 'restwell-retreats' ),
		__( 'Theme Setup', 'restwell-retreats' ),
		'manage_options',
		'restwell-theme-setup',
		'restwell_theme_setup_page'
	);
}
add_action( 'admin_menu', 'restwell_theme_setup_admin_menu' );

/**
 * Print long-cache guidance for theme static assets (server/CDN; not set by PHP).
 */
function restwell_theme_setup_performance_docs_section() {
	$slug = basename( get_template() );
	$path = '/wp-content/themes/' . $slug . '/assets/';
	$nginx_block = "location ~* ^{$path} {\n    expires 1y;\n    add_header Cache-Control \"public, max-age=31536000, immutable\";\n}";
	$apache_block = '<FilesMatch "\\.(css|js|woff2?|ttf|eot)$">' . "\n" . '    Header set Cache-Control "public, max-age=31536000, immutable"' . "\n" . '</FilesMatch>';
	?>
	<div class="card" style="max-width: 52rem; margin-top: 1.5rem;">
		<h2><?php esc_html_e( 'Performance: static assets & caching', 'restwell-retreats' ); ?></h2>
		<p><?php esc_html_e( 'After Theme Setup, WordPress regenerates responsive image sizes (unless you skip that step). For CSS/JS/fonts under the theme, set long cache lifetimes at the web server or CDN. Theme enqueue URLs include a version query string so updates bust caches.', 'restwell-retreats' ); ?></p>
		<p><strong><?php esc_html_e( 'Theme assets path (adjust for your install):', 'restwell-retreats' ); ?></strong> <code><?php echo esc_html( $path ); ?></code></p>
		<h3><?php esc_html_e( 'nginx (example location)', 'restwell-retreats' ); ?></h3>
		<pre style="overflow:auto; padding:12px; background:#f6f7f7; border:1px solid #c3c4c7;"><?php echo esc_html( $nginx_block ); ?></pre>
		<h3><?php esc_html_e( 'Apache (prefer server or vhost config; .htaccess in the theme is not loaded for asset requests)', 'restwell-retreats' ); ?></h3>
		<pre style="overflow:auto; padding:12px; background:#f6f7f7; border:1px solid #c3c4c7;"><?php echo esc_html( $apache_block ); ?></pre>
		<p class="description"><?php esc_html_e( 'Requires mod_headers (and related modules) as appropriate. Page caching remains a separate plugin or host feature.', 'restwell-retreats' ); ?></p>
	</div>
	<?php
}

/**
 * Render the Theme Setup admin page and handle POST.
 */
function restwell_theme_setup_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'restwell-retreats' ) );
	}

	$message = '';
	$already_seeded = restwell_theme_setup_is_seeded();

	// Handle form submission.
	if ( isset( $_POST[ RESTWELL_SETUP_NONCE_NAME ] ) && isset( $_POST['restwell_run_setup'] ) ) {
		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ RESTWELL_SETUP_NONCE_NAME ] ) ), RESTWELL_SETUP_NONCE_ACTION ) ) {
			$message = '<div class="notice notice-error"><p>' . esc_html__( 'Security check failed. Please try again.', 'restwell-retreats' ) . '</p></div>';
		} else {
			$force            = ! empty( $_POST['restwell_rerun'] );
			$skip_image_regen = ! empty( $_POST['restwell_skip_image_regen'] );
			$result           = restwell_run_theme_setup( $force, $skip_image_regen );
			$message          = restwell_theme_setup_format_message( $result );
		}
	}

	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Restwell Theme Setup', 'restwell-retreats' ); ?></h1>

		<?php echo wp_kses_post( $message ); ?>

		<div class="notice notice-warning">
			<p><?php esc_html_e( 'Creates missing pages and fills default content. Re-running merges any new theme default fields into pages where those keys are not stored yet; use “Re-run setup anyway” to overwrite Home and template page fields from current theme defaults.', 'restwell-retreats' ); ?></p>
		</div>

		<?php if ( $already_seeded ) : ?>
			<div class="notice notice-info">
				<p><?php esc_html_e( 'Setup already completed.', 'restwell-retreats' ); ?></p>
			</div>
		<?php endif; ?>

		<form method="post" action="">
			<?php wp_nonce_field( RESTWELL_SETUP_NONCE_ACTION, RESTWELL_SETUP_NONCE_NAME ); ?>
			<?php if ( $already_seeded ) : ?>
				<p>
					<label>
						<input type="checkbox" name="restwell_rerun" value="1" />
						<?php esc_html_e( 'Re-run setup anyway (re-seeds content and overwrites SEO title, meta description, and focus keyphrase from theme defaults). Responsive image regeneration still runs unless you skip it below.', 'restwell-retreats' ); ?>
					</label>
				</p>
			<?php endif; ?>
			<p>
				<label>
					<input type="checkbox" name="restwell_skip_image_regen" value="1" />
					<?php esc_html_e( 'Skip regenerating responsive image sizes (restwell-hero, restwell-cta-bg) for all uploads. Use if this request might time out on a very large Media Library; you can run wp media regenerate later.', 'restwell-retreats' ); ?>
				</label>
			</p>
			<p>
				<button type="submit" name="restwell_run_setup" value="1" class="button button-primary">
					<?php esc_html_e( 'Run Theme Setup', 'restwell-retreats' ); ?>
				</button>
			</p>
		</form>

		<?php restwell_theme_setup_performance_docs_section(); ?>
	</div>
	<?php
}

/**
 * Check if front page has been seeded (setup already run).
 */
function restwell_theme_setup_is_seeded() {
	$page_id = (int) get_option( 'page_on_front', 0 );
	if ( $page_id < 1 ) {
		return false;
	}
	return get_post_meta( $page_id, 'restwell_fields_seeded', true ) === '1';
}

/**
 * Return the URL for a theme logo, preferring the Media Library attachment.
 *
 * Falls back to the bundled file in /assets/images/ when the attachment ID has
 * not yet been stored (i.e. setup hasn't been run) or the attachment is missing.
 *
 * @param string $mod_key          Theme mod key, e.g. 'restwell_logo_long_id'.
 * @param string $fallback_filename Filename inside /assets/images/.
 * @return string Fully-qualified URL.
 */
