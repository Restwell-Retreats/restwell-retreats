<?php
/**
 * Restwell Retreats theme functions and definitions.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load Restwell CRM when the mu-plugin is not present (e.g. Local dev with only the theme symlinked).
 * Production should use wp-content/mu-plugins/restwell-crm.php; this path is the monorepo sibling.
 */
if ( ! function_exists( 'restwell_crm_capability' ) ) {
	$crm_bootstrap = dirname( get_template_directory() ) . '/wp-content/mu-plugins/restwell-crm/restwell-crm.php';
	if ( is_readable( $crm_bootstrap ) ) {
		require_once $crm_bootstrap;
	}
}

require_once get_template_directory() . '/inc/admin-meta-boxes.php';
require_once get_template_directory() . '/inc/blog-categories.php';
require_once get_template_directory() . '/inc/csp.php';
require_once get_template_directory() . '/inc/enqueue.php';
require_once get_template_directory() . '/inc/faq.php';
require_once get_template_directory() . '/inc/faq-question-handler.php';
require_once get_template_directory() . '/inc/gallery.php';
require_once get_template_directory() . '/inc/property-facts.php';
require_once get_template_directory() . '/inc/property-content.php';
require_once get_template_directory() . '/inc/guest-guide.php';
require_once get_template_directory() . '/inc/homepage-faq.php';
require_once get_template_directory() . '/inc/llms-txt.php';
require_once get_template_directory() . '/inc/litespeed-compat.php';
require_once get_template_directory() . '/inc/meta-fields.php';
require_once get_template_directory() . '/inc/nav.php';
require_once get_template_directory() . '/inc/performance.php';
require_once get_template_directory() . '/inc/post-helpers.php';
require_once get_template_directory() . '/inc/privacy-page-bootstrap.php';
require_once get_template_directory() . '/inc/redirects.php';
require_once get_template_directory() . '/inc/security-rest.php';
require_once get_template_directory() . '/inc/seo.php';
require_once get_template_directory() . '/inc/seo-admin.php';
require_once get_template_directory() . '/inc/seo-dashboard.php';
require_once get_template_directory() . '/inc/seo-social-meta.php';
require_once get_template_directory() . '/inc/sitemap-robots.php';
require_once get_template_directory() . '/inc/smtp-config.php';
require_once get_template_directory() . '/inc/social-profiles.php';
require_once get_template_directory() . '/inc/theme-setup.php';
require_once get_template_directory() . '/inc/crm.php';
require_once get_template_directory() . '/inc/services/bootstrap.php';
require_once get_template_directory() . '/inc/tldr.php';
require_once get_template_directory() . '/inc/wif-helpers.php';
require_once get_template_directory() . '/inc/wp-runtime-optimization.php';

// Disable Gutenberg block editor - use classic editor
add_filter( 'use_block_editor_for_post', '__return_false' );
add_filter( 'use_widgets_block_editor', '__return_false' );
add_filter( 'xmlrpc_enabled', '__return_false' );

/**
 * Declare theme support and register nav menu.
 */
function restwell_theme_setup() {
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'restwell-retreats' ),
		)
	);

	// Responsive theme images: cap hero/CTA width for smaller files + richer srcset (regenerate after deploy: wp media regenerate).
	add_image_size( 'restwell-hero', 1920, 0 );
	add_image_size( 'restwell-cta-bg', 1920, 0 );
	add_image_size( 'restwell-property', 1920, 0 );
}
add_action( 'after_setup_theme', 'restwell_theme_setup' );

/**
 * Send security headers on HTTPS responses.
 *
 * HSTS uses includeSubDomains without preload as a safe default.
 * X-Content-Type-Options nosniff prevents MIME sniffing.
 * X-Frame-Options SAMEORIGIN allows same-site embeds (use DENY if no embeds ever).
 * Referrer-Policy strict-origin-when-cross-origin limits referrer leakage while keeping analytics useful.
 * Permissions-Policy denies geolocation, microphone, and camera (unused on this site).
 * Content-Security-Policy: see inc/csp.php (Report-Only by default; enforce via restwell_enable_csp_enforce).
 */
function restwell_send_security_headers() {
	if ( is_ssl() ) {
		header( 'Strict-Transport-Security: max-age=31536000; includeSubDomains' );
		header( 'X-Content-Type-Options: nosniff' );
		header( 'X-Frame-Options: SAMEORIGIN' );
		header( 'Referrer-Policy: strict-origin-when-cross-origin' );
		header( 'Permissions-Policy: geolocation=(), microphone=(), camera=()' );
	}
}
add_action( 'send_headers', 'restwell_send_security_headers' );

/**
 * Suppress WordPress users sitemap provider to avoid username exposure.
 *
 * @param WP_Sitemaps_Provider|false $provider Provider instance.
 * @param string                     $name     Provider name.
 * @return WP_Sitemaps_Provider|false
 */
function restwell_disable_users_sitemap_provider( $provider, $name ) {
	if ( 'users' === $name ) {
		return false;
	}
	return $provider;
}
add_filter( 'wp_sitemaps_add_provider', 'restwell_disable_users_sitemap_provider', 10, 2 );
