<?php
/**
 * PHPUnit bootstrap for theme helpers that can run without WordPress.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', sys_get_temp_dir() . '/restwell-phpunit/' );
}

if ( ! defined( 'MINUTE_IN_SECONDS' ) ) {
	define( 'MINUTE_IN_SECONDS', 60 );
}
if ( ! defined( 'HOUR_IN_SECONDS' ) ) {
	define( 'HOUR_IN_SECONDS', 3600 );
}
if ( ! defined( 'OBJECT' ) ) {
	define( 'OBJECT', 'OBJECT' );
}

$GLOBALS['restwell_test_options']    = array();
$GLOBALS['restwell_test_transients'] = array();
$GLOBALS['restwell_test_today']      = '2026-09-01';

if ( ! function_exists( 'add_action' ) ) {
	function add_action( $hook, $callback, $priority = 10, $accepted_args = 1 ) {
		unset( $hook, $callback, $priority, $accepted_args );
	}
}
if ( ! function_exists( 'add_filter' ) ) {
	function add_filter( $hook, $callback, $priority = 10, $accepted_args = 1 ) {
		unset( $hook, $callback, $priority, $accepted_args );
	}
}
if ( ! function_exists( '__' ) ) {
	function __( $text, $domain = 'default' ) {
		unset( $domain );
		return $text;
	}
}
if ( ! function_exists( 'esc_html__' ) ) {
	function esc_html__( $text, $domain = 'default' ) {
		return __( $text, $domain );
	}
}
if ( ! function_exists( 'esc_html' ) ) {
	function esc_html( $text ) {
		return $text;
	}
}
if ( ! function_exists( 'esc_attr' ) ) {
	function esc_attr( $text ) {
		return $text;
	}
}
if ( ! function_exists( 'esc_url' ) ) {
	function esc_url( $url ) {
		return $url;
	}
}
if ( ! function_exists( 'esc_attr__' ) ) {
	function esc_attr__( $text, $domain = 'default' ) {
		return __( $text, $domain );
	}
}
if ( ! function_exists( 'current_time' ) ) {
	function current_time( $type, $gmt = 0 ) {
		unset( $gmt );
		if ( 'Y-m-d' === $type ) {
			return $GLOBALS['restwell_test_today'];
		}
		return $GLOBALS['restwell_test_today'] . ' 12:00:00';
	}
}
if ( ! function_exists( 'wp_salt' ) ) {
	function wp_salt( $scheme = 'auth' ) {
		return 'restwell-phpunit-salt-' . $scheme;
	}
}
if ( ! function_exists( 'get_option' ) ) {
	function get_option( $option, $default = false ) {
		if ( array_key_exists( $option, $GLOBALS['restwell_test_options'] ) ) {
			return $GLOBALS['restwell_test_options'][ $option ];
		}
		return $default;
	}
}
if ( ! function_exists( 'update_option' ) ) {
	function update_option( $option, $value, $autoload = null ) {
		unset( $autoload );
		$GLOBALS['restwell_test_options'][ $option ] = $value;
		return true;
	}
}
if ( ! function_exists( 'get_transient' ) ) {
	function get_transient( $transient ) {
		if ( ! array_key_exists( $transient, $GLOBALS['restwell_test_transients'] ) ) {
			return false;
		}
		return $GLOBALS['restwell_test_transients'][ $transient ];
	}
}
if ( ! function_exists( 'set_transient' ) ) {
	function set_transient( $transient, $value, $expiration = 0 ) {
		unset( $expiration );
		$GLOBALS['restwell_test_transients'][ $transient ] = $value;
		return true;
	}
}
if ( ! function_exists( 'delete_transient' ) ) {
	function delete_transient( $transient ) {
		unset( $GLOBALS['restwell_test_transients'][ $transient ] );
		return true;
	}
}
if ( ! function_exists( 'wp_strip_all_tags' ) ) {
	function wp_strip_all_tags( $string ) {
		return strip_tags( (string) $string );
	}
}
if ( ! function_exists( 'get_bloginfo' ) ) {
	function get_bloginfo( $show = '' ) {
		if ( 'name' === $show ) {
			return 'Restwell Retreats';
		}
		return '';
	}
}
if ( ! function_exists( 'home_url' ) ) {
	function home_url( $path = '' ) {
		return 'https://restwellretreats.co.uk/' . ltrim( (string) $path, '/' );
	}
}
if ( ! function_exists( 'get_template_directory' ) ) {
	function get_template_directory() {
		return dirname( __DIR__ );
	}
}
if ( ! function_exists( 'get_template_directory_uri' ) ) {
	function get_template_directory_uri() {
		return 'https://restwellretreats.co.uk/wp-content/themes/restwell-theme';
	}
}
if ( ! function_exists( 'is_ssl' ) ) {
	function is_ssl() {
		return false;
	}
}
if ( ! function_exists( 'wp_unslash' ) ) {
	function wp_unslash( $value ) {
		return $value;
	}
}
if ( ! class_exists( 'WP_Post' ) ) {
	class WP_Post {
		public $ID = 0;
	}
}

$theme = dirname( __DIR__ );
require_once $theme . '/inc/crm/enquire-handler.php';
require_once $theme . '/inc/crm/handlers.php';
require_once $theme . '/inc/guest-guide.php';
require_once $theme . '/inc/theme-setup/apply-overwrites.php';
