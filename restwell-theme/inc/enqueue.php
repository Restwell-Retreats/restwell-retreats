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
 * @param string $relative_path Path under the theme directory, e.g. '/assets/css/shared.css'.
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

	// Production: one minified bundle (tools/build-css.sh) instead of four
	// render-blocking stylesheets. The old handles stay registered as empty
	// aliases so anything depending on them still resolves.
	if ( $use_min && is_readable( get_template_directory() . '/assets/css/site.min.css' ) ) {
		wp_enqueue_style(
			'restwell-shared',
			$theme_uri . '/assets/css/site.min.css',
			array(),
			restwell_theme_asset_version( '/assets/css/site.min.css' )
		);
		foreach ( array( 'restwell-fonts', 'restwell-shared-wp', 'restwell-polish' ) as $alias ) {
			wp_register_style( $alias, false, array( 'restwell-shared' ), null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
		}
	} else {
		wp_enqueue_style(
			'restwell-fonts',
			$theme_uri . '/assets/css/fonts.css',
			array(),
			restwell_theme_asset_version( '/assets/css/fonts.css' )
		);

		// shared.css is the live design system. Tailwind / Phosphor are not enqueued.
		wp_enqueue_style(
			'restwell-shared',
			$theme_uri . '/assets/css/shared.css',
			array( 'restwell-fonts' ),
			restwell_theme_asset_version( '/assets/css/shared.css' )
		);
		wp_enqueue_style(
			'restwell-shared-wp',
			$theme_uri . '/assets/css/shared-wp.css',
			array( 'restwell-shared' ),
			restwell_theme_asset_version( '/assets/css/shared-wp.css' )
		);

		// Small refinements layered after the established classic-theme design system.
		wp_enqueue_style(
			'restwell-polish',
			$theme_uri . '/assets/css/polish.css',
			array( 'restwell-shared-wp' ),
			restwell_theme_asset_version( '/assets/css/polish.css' )
		);
	}

	$shared_rel = '/assets/js/shared.js';
	if ( $use_min && is_readable( get_template_directory() . '/assets/js/shared.min.js' ) ) {
		$shared_rel = '/assets/js/shared.min.js';
	}
	wp_enqueue_script(
		'restwell-shared',
		$theme_uri . $shared_rel,
		array(),
		restwell_theme_asset_version( $shared_rel ),
		true
	);

	$js_suffix = $use_min ? '.min.js' : '.js';

	// Always: nav chrome + shared behaviours (scroll-top, sticky header, mobile menu).
	$nav_rel = '/assets/js/nav' . $js_suffix;
	if ( $use_min && ! is_readable( get_template_directory() . $nav_rel ) ) {
		$nav_rel = '/assets/js/nav.js';
	}
	wp_enqueue_script(
		'restwell-nav',
		$theme_uri . $nav_rel,
		array( 'restwell-shared' ),
		restwell_theme_asset_version( $nav_rel ),
		true
	);

	$main_rel = '/assets/js/main' . $js_suffix;
	if ( $use_min && ! is_readable( get_template_directory() . $main_rel ) ) {
		$main_rel = '/assets/js/main.js';
	}
	wp_enqueue_script(
		'restwell-main',
		$theme_uri . $main_rel,
		array( 'restwell-shared' ),
		restwell_theme_asset_version( $main_rel ),
		true
	);

	// Enquire form helpers — enquire page, and the pricing diary dialog (same POST).
	$needs_enquire_js = is_page_template( 'template-enquire.php' )
		|| (
			is_page_template( 'template-pricing.php' )
			&& function_exists( 'restwell_occupancy_is_configured' )
			&& restwell_occupancy_is_configured()
		);
	if ( $needs_enquire_js ) {
		$enquire_rel = '/assets/js/enquire' . $js_suffix;
		if ( $use_min && ! is_readable( get_template_directory() . $enquire_rel ) ) {
			$enquire_rel = '/assets/js/enquire.js';
		}
		wp_enqueue_script(
			'restwell-enquire',
			$theme_uri . $enquire_rel,
			array( 'restwell-shared' ),
			restwell_theme_asset_version( $enquire_rel ),
			true
		);
	}

	// Media-library gallery JS is only needed when that markup is rendered.
	// Concept pages use shared.js [data-gallery] lightbox instead.

	if ( is_page_template( 'template-pricing.php' )
		&& function_exists( 'restwell_occupancy_is_configured' )
		&& restwell_occupancy_is_configured()
	) {
		$availability_rel = '/assets/js/availability' . $js_suffix;
		if ( $use_min && ! is_readable( get_template_directory() . $availability_rel ) ) {
			$availability_rel = '/assets/js/availability.js';
		}
		wp_enqueue_script(
			'restwell-availability',
			$theme_uri . $availability_rel,
			array( 'restwell-shared' ),
			restwell_theme_asset_version( $availability_rel ),
			true
		);
	}
}
add_action( 'wp_enqueue_scripts', 'restwell_enqueue_scripts' );

/**
 * Defer front-end theme scripts (non-blocking).
 *
 * @param string $tag    The script HTML.
 * @param string $handle Script handle.
 * @param string $src    Source URL (unused).
 * @return string
 */
function restwell_defer_front_script( $tag, $handle, $src ) {
	unset( $src );
	$deferred = array(
		'restwell-shared',
		'restwell-nav',
		'restwell-enquire',
		'restwell-gallery',
		'restwell-main',
		'restwell-availability',
		'restwell-analytics-loader',
	);
	if ( ! in_array( $handle, $deferred, true ) ) {
		return $tag;
	}
	if ( false !== strpos( $tag, ' defer' ) ) {
		return $tag;
	}
	return str_replace( '<script ', '<script defer ', $tag );
}
add_filter( 'script_loader_tag', 'restwell_defer_front_script', 10, 3 );

/**
 * Template family for critical CSS. Mirrors the key the build tool reads from
 * body classes in tools/build-critical-css.mjs; keep the two in step.
 *
 * @return string
 */
function restwell_critical_css_key() {
	if ( is_front_page() ) {
		return 'front';
	}
	if ( is_singular( 'post' ) ) {
		return 'post';
	}
	if ( is_page() ) {
		$slug = (string) get_page_template_slug( get_queried_object_id() );
		return '' === $slug ? 'page' : (string) preg_replace( '/-php$/', '', sanitize_html_class( str_replace( '.', '-', $slug ) ) );
	}
	if ( is_home() || is_archive() ) {
		return 'blog';
	}
	return 'utility';
}

/**
 * Critical CSS for this request, or '' to keep the normal blocking bundle.
 * Only used when the file was built from the current site.min.css (matching
 * source hash), so a stale extract can never style a page.
 *
 * @return string
 */
function restwell_critical_css() {
	static $css = null;
	if ( null !== $css ) {
		return $css;
	}
	$css = '';
	if ( is_admin() || is_customize_preview() || ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ) {
		return $css;
	}
	$dir    = get_template_directory() . '/assets/css';
	$file   = $dir . '/critical/' . restwell_critical_css_key() . '.min.css';
	$bundle = $dir . '/site.min.css';
	if ( ! is_readable( $file ) || ! is_readable( $bundle ) ) {
		return $css;
	}
	$raw = (string) file_get_contents( $file ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- local theme file.
	$fh  = fopen( $bundle, 'rb' ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fopen -- read the bundle's first line only.
	$top = $fh ? (string) fgets( $fh ) : '';
	if ( $fh ) {
		fclose( $fh ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fclose
	}
	if ( ! preg_match( '/source ([0-9a-f]{40})/', $raw, $want ) || false === strpos( $top, $want[1] ) ) {
		return $css;
	}
	$body = trim( (string) substr( $raw, (int) strpos( $raw, "\n" ) ) );
	// Inlined, so ../ no longer resolves from assets/css/.
	$css = str_replace( 'url("../', 'url("' . get_template_directory_uri() . '/assets/', $body );
	return $css;
}

/**
 * Print the critical CSS before the stylesheet links (wp_print_styles runs at 8).
 */
function restwell_print_critical_css() {
	$css = restwell_critical_css();
	if ( '' === $css ) {
		return;
	}
	echo '<style id="restwell-critical-css">' . str_replace( '</', '<\/', $css ) . "</style>\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- theme-built CSS file, closing tags neutralised.
}
add_action( 'wp_head', 'restwell_print_critical_css', 7 );

/**
 * With critical CSS inlined, fetch the full bundle at high priority without
 * blocking first paint: preload it, link it as print, switch to all once it
 * has loaded (nonce'd script; the CSP blocks inline onload handlers), and
 * keep a plain link for no-JS visitors.
 *
 * @param string $tag    The link HTML.
 * @param string $handle Style handle.
 * @param string $href   Stylesheet URL.
 * @return string
 */
function restwell_async_site_bundle( $tag, $handle, $href ) {
	if ( 'restwell-shared' !== $handle || '' === restwell_critical_css() || false === strpos( $href, 'site.min.css' ) ) {
		return $tag;
	}
	$async = (string) preg_replace( '/\smedia=([\'"])all\1/', ' media="print"', $tag, 1 );
	if ( $async === $tag ) {
		return $tag;
	}
	$nonce = function_exists( 'restwell_csp_script_nonce_attr' ) ? restwell_csp_script_nonce_attr() : '';
	return $async
		. '<script' . $nonce . '>(function(l){if(!l)return;function a(){l.media="all"}if(l.sheet){a()}else{l.addEventListener("load",a)}})(document.getElementById("restwell-shared-css"));</script>' . "\n"
		. '<noscript>' . trim( $tag ) . "</noscript>\n";
}
add_filter( 'style_loader_tag', 'restwell_async_site_bundle', 10, 3 );

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
		'restwell-crm_page_restwell-availability',
		'restwell-crm_page_restwell-faq-inbox',
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
		'restwell-availability',
		'restwell-faq-inbox',
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
	$fonts_css  = $theme_dir . '/assets/css/fonts.css';
	$theme_ver  = (string) wp_get_theme()->get( 'Version' );
	$crm_css_ver = file_exists( $crm_css ) ? (string) filemtime( $crm_css ) : $theme_ver;
	$fonts_ver   = file_exists( $fonts_css ) ? (string) filemtime( $fonts_css ) : $theme_ver;

	wp_enqueue_style(
		'restwell-admin-fonts',
		$theme_uri . '/assets/css/fonts.css',
		array(),
		$fonts_ver
	);

	wp_enqueue_style(
		'restwell-admin-crm',
		$theme_uri . '/assets/css/admin-crm.css',
		array( 'restwell-admin-fonts' ),
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
				'i18n'     => array(
					'statusHint' => __( 'Tap to change', 'restwell-retreats' ),
				),
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
