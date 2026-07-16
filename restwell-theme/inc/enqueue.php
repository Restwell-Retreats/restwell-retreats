<?php
/**
 * Enqueue all theme styles and scripts.
 * Loaded on every page via wp_enqueue_scripts; header/footer output wp_head() and wp_footer().
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Version string for a theme file (filemtime) so deploys bust LiteSpeed / CDN caches without a manual style.css bump.
 *
 * @param string $relative_path Path under the theme directory, e.g. '/assets/css/tailwind.css'.
 * @return string
 */
function restwell_theme_asset_version( $relative_path ) {
	$relative_path = '/' . ltrim( (string) $relative_path, '/' );
	$full          = get_template_directory() . $relative_path;
	if ( is_readable( $full ) ) {
		return (string) filemtime( $full );
	}
	return (string) wp_get_theme()->get( 'Version' );
}

/**
 * Enqueue front-end styles and scripts for the theme.
 */
function restwell_enqueue_scripts() {
	$theme_uri = get_template_directory_uri();

	// Serve minified assets in production; fall back to unminified when SCRIPT_DEBUG is on.
	$use_min = ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG );

	/*
	 * Phosphor Icons (@phosphor-icons/web): regular = `.ph` + `.ph-{name}`, bold = `.ph-bold` + `.ph-{name}`.
	 * Note: there is no single `src/index.css` in this package; per-weight styles are the supported entry points.
	 *
	 * Output normal <link rel="stylesheet"> tags only. Print/onload deferral was removed: Google Rich Results Test
	 * and LiteSpeed CSS combine/minify often fail on non-standard markup, producing "resources could not be loaded".
	 */
	wp_enqueue_style(
		'phosphor-icons-regular',
		$theme_uri . '/assets/fonts/phosphor/regular/style.css',
		array(),
		restwell_theme_asset_version( '/assets/fonts/phosphor/regular/style.css' )
	);
	wp_enqueue_style(
		'phosphor-icons-bold',
		$theme_uri . '/assets/fonts/phosphor/bold/style.css',
		array( 'phosphor-icons-regular' ),
		restwell_theme_asset_version( '/assets/fonts/phosphor/bold/style.css' )
	);

	// tailwind.css is always built minified via `npm run build` (Tailwind CLI --minify).
	wp_enqueue_style(
		'restwell-tailwind',
		$theme_uri . '/assets/css/tailwind.css',
		array( 'phosphor-icons-bold' ),
		restwell_theme_asset_version( '/assets/css/tailwind.css' )
	);

	$main_js = $use_min ? '/assets/js/main.min.js' : '/assets/js/main.js';
	wp_enqueue_script(
		'restwell-main',
		$theme_uri . $main_js,
		array(),
		restwell_theme_asset_version( $main_js ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'restwell_enqueue_scripts' );

/**
 * Load main.js with defer (non-blocking) for better LCP / main-thread work.
 *
 * @param string $tag    The script HTML.
 * @param string $handle Script handle.
 * @param string $src    Source URL (unused).
 * @return string
 */
function restwell_defer_main_script( $tag, $handle, $src ) {
	unset( $src );
	if ( 'restwell-main' !== $handle ) {
		return $tag;
	}
	if ( false !== strpos( $tag, ' defer' ) ) {
		return $tag;
	}
	return str_replace( '<script ', '<script defer ', $tag );
}
add_filter( 'script_loader_tag', 'restwell_defer_main_script', 10, 3 );

/**
 * Load analytics-loader.js with defer when enqueued (footer deferred / CMP modes).
 *
 * @param string $tag    The script HTML.
 * @param string $handle Script handle.
 * @param string $src    Source URL (unused).
 * @return string
 */
function restwell_defer_analytics_loader_script( $tag, $handle, $src ) {
	unset( $src );
	if ( 'restwell-analytics-loader' !== $handle ) {
		return $tag;
	}
	if ( false !== strpos( $tag, ' defer' ) ) {
		return $tag;
	}
	return str_replace( '<script ', '<script defer ', $tag );
}
add_filter( 'script_loader_tag', 'restwell_defer_analytics_loader_script', 10, 3 );

/**
 * Enqueue polished admin styles for Restwell CRM screens.
 *
 * @param string $hook_suffix Current admin page hook suffix.
 */
function restwell_enqueue_admin_styles( $hook_suffix ) {
	$target_hooks = array(
		'toplevel_page_restwell-crm',
		'restwell-crm_page_restwell-enquiries',
		'restwell-crm_page_restwell-mailing-list',
		'restwell-crm_page_restwell-guest-guide',
		// Legacy hook prefixes (kept so Local / older WP menus still get styles).
		'restwell_page_restwell-enquiries',
		'restwell_page_restwell-guest-guide',
	);

	$page = isset( $_GET['page'] ) ? sanitize_key( wp_unslash( $_GET['page'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

	$crm_pages = array(
		'restwell-crm',
		'restwell-enquiries',
		'restwell-mailing-list',
		'restwell-guest-guide',
	);

	$load_crm_screen = in_array( $hook_suffix, $target_hooks, true )
		|| in_array( $page, $crm_pages, true );

	// Guest Guide meta box on page edit: shared form/section classes in admin-crm.css.
	$page_editor_gg = false;
	if ( in_array( $hook_suffix, array( 'post.php', 'post-new.php' ), true ) ) {
		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
		if ( $screen && isset( $screen->post_type ) && 'page' === $screen->post_type ) {
			$page_editor_gg = true;
		} elseif ( 'post.php' === $hook_suffix && isset( $_GET['post'] ) ) {
			$page_editor_gg = ( 'page' === get_post_type( absint( wp_unslash( $_GET['post'] ) ) ) );
		} elseif ( 'post-new.php' === $hook_suffix && isset( $_GET['post_type'] ) ) {
			$page_editor_gg = ( 'page' === sanitize_key( wp_unslash( $_GET['post_type'] ) ) );
		}
	}

	if ( ! $load_crm_screen && ! $page_editor_gg ) {
		return;
	}

	$theme_uri  = get_template_directory_uri();
	$theme_dir  = get_template_directory();
	$crm_css    = $theme_dir . '/assets/css/admin-crm.css';
	$crm_js     = $theme_dir . '/assets/js/admin-crm-actions.js';
	$meta_css   = $theme_dir . '/assets/css/admin-meta-fields.css';
	$meta_js    = $theme_dir . '/assets/js/admin-meta-fields.js';
	$theme_ver  = (string) wp_get_theme()->get( 'Version' );
	$crm_css_ver = file_exists( $crm_css ) ? (string) filemtime( $crm_css ) : $theme_ver;

	wp_enqueue_style(
		'restwell-admin-crm',
		$theme_uri . '/assets/css/admin-crm.css',
		array(),
		$crm_css_ver
	);

	// Inline status-change UI — only needed on the enquiries list, not the dashboard or guest guide.
	$load_enquiries_screen = in_array(
		$hook_suffix,
		array( 'restwell-crm_page_restwell-enquiries', 'restwell_page_restwell-enquiries' ),
		true
	) || ( 'restwell-enquiries' === $page );

	if ( $load_enquiries_screen ) {
		$crm_js_ver = file_exists( $crm_js ) ? (string) filemtime( $crm_js ) : $theme_ver;
		wp_enqueue_script(
			'restwell-crm-actions',
			$theme_uri . '/assets/js/admin-crm-actions.js',
			array(),
			$crm_js_ver,
			true
		);
		wp_localize_script(
			'restwell-crm-actions',
			'rwCrmActions',
			array(
				'nonce'    => wp_create_nonce( 'restwell_crm_lead_action' ),
				'ajaxurl'  => admin_url( 'admin-ajax.php' ),
				'statuses' => restwell_crm_statuses(),
			)
		);
	}

	if ( $page_editor_gg ) {
		$meta_css_ver = file_exists( $meta_css ) ? (string) filemtime( $meta_css ) : $theme_ver;
		$meta_js_ver  = file_exists( $meta_js ) ? (string) filemtime( $meta_js ) : $theme_ver;
		wp_enqueue_style(
			'restwell-admin-meta-fields',
			$theme_uri . '/assets/css/admin-meta-fields.css',
			array(),
			$meta_css_ver
		);
		wp_enqueue_script(
			'restwell-admin-meta-fields',
			$theme_uri . '/assets/js/admin-meta-fields.js',
			array(),
			$meta_js_ver,
			true
		);
	}
}
add_action( 'admin_enqueue_scripts', 'restwell_enqueue_admin_styles' );
