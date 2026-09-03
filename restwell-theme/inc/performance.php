<?php
/**
 * Front-end performance helpers: responsive image sizes, LCP preload, fallbacks.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Pick a registered image size when its file exists; otherwise fall back so older uploads still render.
 *
 * @param int    $attachment_id Attachment ID.
 * @param string $preferred     Preferred size name (e.g. restwell-hero).
 * @param string ...$fallbacks  Additional size names to try before full.
 * @return string Size name for wp_get_attachment_image / src.
 */
function restwell_pick_attachment_size( $attachment_id, $preferred, ...$fallbacks ) {
	$attachment_id = (int) $attachment_id;
	if ( $attachment_id <= 0 ) {
		return $preferred;
	}
	$meta = wp_get_attachment_metadata( $attachment_id );
	if ( empty( $meta['sizes'] ) || ! is_array( $meta['sizes'] ) ) {
		return 'full';
	}
	$sizes = $meta['sizes'];
	if ( ! empty( $sizes[ $preferred ] ) ) {
		return $preferred;
	}
	foreach ( $fallbacks as $fb ) {
		if ( $fb && ! empty( $sizes[ $fb ] ) ) {
			return $fb;
		}
	}
	// Common theme / WP sizes.
	foreach ( array( 'large', 'medium_large', 'medium' ) as $fb ) {
		if ( ! empty( $sizes[ $fb ] ) ) {
			return $fb;
		}
	}
	return 'full';
}

/**
 * Regenerate WordPress intermediate sizes for every image attachment so new theme sizes
 * (e.g. restwell-hero, restwell-cta-bg, restwell-property) exist in metadata. Intended for admin Theme Setup.
 *
 * May be slow on very large media libraries; use the skip option or WP-CLI `wp media regenerate` instead.
 *
 * @return array{processed:int, errors:int, skipped:bool, error_samples:string[]}
 */
function restwell_regenerate_all_image_subsizes() {
	$result = array(
		'processed'      => 0,
		'errors'         => 0,
		'skipped'        => false,
		'error_samples'  => array(),
	);

	if ( ! function_exists( 'wp_update_image_subsizes' ) ) {
		$result['error_samples'][] = __( 'wp_update_image_subsizes() is not available.', 'restwell-retreats' );
		return $result;
	}

	require_once ABSPATH . 'wp-admin/includes/image.php';

	if ( function_exists( 'set_time_limit' ) ) {
		set_time_limit( 0 );
	}

	$ids = get_posts(
		array(
			'post_type'              => 'attachment',
			'post_status'            => 'inherit',
			'posts_per_page'         => -1,
			'post_mime_type'         => 'image',
			'fields'                 => 'ids',
			'orderby'                => 'ID',
			'order'                  => 'ASC',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
		)
	);

	foreach ( $ids as $id ) {
		$file = get_attached_file( $id );
		if ( ! $file || ! file_exists( $file ) ) {
			continue;
		}

		$ok = wp_update_image_subsizes( $id );
		if ( is_wp_error( $ok ) ) {
			++$result['errors'];
			if ( count( $result['error_samples'] ) < 3 ) {
				$result['error_samples'][] = sprintf(
					/* translators: 1: attachment ID, 2: error message */
					__( 'Attachment %1$d: %2$s', 'restwell-retreats' ),
					(int) $id,
					$ok->get_error_message()
				);
			}
		} else {
			++$result['processed'];
		}
	}

	return $result;
}

/**
 * Preload the front-page hero image for LCP.
 *
 * Prefers the resolved page hero URL (Featured / stock map), then falls back
 * to the theme coastline stock asset.
 */
function restwell_preload_front_page_hero_image() {
	if ( ! is_front_page() ) {
		return;
	}

	$home_id = (int) get_option( 'page_on_front', 0 );
	if ( $home_id > 0 && function_exists( 'restwell_page_hero_image_url' ) ) {
		$url = restwell_page_hero_image_url( $home_id );
		if ( $url !== '' ) {
			echo '<link rel="preload" as="image" href="' . esc_url( $url ) . '" fetchpriority="high" />' . "\n";
			return;
		}
	}

	$concept_rel = 'stock/restwell-whitstable-promenade-golden-hour.jpg';
	$concept_url = function_exists( 'restwell_theme_image_url' ) ? restwell_theme_image_url( $concept_rel ) : '';
	if ( $concept_url !== '' && 0 !== strpos( $concept_url, get_template_directory_uri() . '/assets/images/' ) ) {
		echo '<link rel="preload" as="image" href="' . esc_url( $concept_url ) . '" fetchpriority="high" />' . "\n";
		return;
	}

	$pid = (int) get_queried_object_id();
	if ( $pid <= 0 ) {
		return;
	}
	$hero_media_id = (int) get_post_meta( $pid, 'hero_media_id', true );
	if ( $hero_media_id <= 0 ) {
		return;
	}
	$mime = get_post_mime_type( $hero_media_id );
	if ( ! $mime || strpos( $mime, 'image/' ) !== 0 ) {
		return;
	}
	$size = restwell_pick_attachment_size( $hero_media_id, 'restwell-hero' );
	$src  = wp_get_attachment_image_src( $hero_media_id, $size );
	if ( ! $src || empty( $src[0] ) ) {
		return;
	}
	$srcset = wp_get_attachment_image_srcset( $hero_media_id, $size );
	$sizes  = '100vw';
	echo '<link rel="preload" as="image" href="' . esc_url( $src[0] ) . '"';
	if ( $srcset ) {
		echo ' imagesrcset="' . esc_attr( $srcset ) . '" imagesizes="' . esc_attr( $sizes ) . '"';
	}
	echo ' fetchpriority="high" />' . "\n";
}
add_action( 'wp_head', 'restwell_preload_front_page_hero_image', 1 );

function restwell_output_media_site_icon() {
	$icon_url = restwell_theme_media_url( 'logo.png' );
	if ( $icon_url !== '' ) {
		echo '<link rel="icon" href="' . esc_url( $icon_url ) . '" />' . "\n";
	}
}
add_action( 'wp_head', 'restwell_output_media_site_icon', 1 );

function restwell_redirect_favicon_request() {
	$request_path = wp_parse_url( home_url( wp_unslash( $_SERVER['REQUEST_URI'] ?? '' ) ), PHP_URL_PATH );
	if ( '/favicon.ico' !== $request_path ) {
		return;
	}
	$icon_url = restwell_theme_media_url( 'logo.png' );
	if ( $icon_url !== '' ) {
		wp_safe_redirect( $icon_url, 301 );
		exit;
	}
}
add_action( 'template_redirect', 'restwell_redirect_favicon_request', 1 );

/**
 * Theme-bundled image URL, preferring a resized WebP under assets/images/.../opt/ when present.
 *
 * @param string $relative Path under assets/images/ (e.g. bungalow/EX-1-LS.jpg).
 * @return string Absolute theme URI.
 */
function restwell_theme_media_url( string $relative ): string {
	$filename = wp_basename( wp_parse_url( $relative, PHP_URL_PATH ) );
	if ( $filename === '' ) {
		return '';
	}

	static $media_urls      = array();
	static $attachment_urls = null;
	static $attachment_stems = null;
	if ( array_key_exists( $filename, $media_urls ) ) {
		return $media_urls[ $filename ];
	}

	$stem      = pathinfo( $filename, PATHINFO_FILENAME );
	$extension = strtolower( pathinfo( $filename, PATHINFO_EXTENSION ) );
	$filenames = array( $filename );
	if ( in_array( $extension, array( 'jpg', 'jpeg', 'png' ), true ) ) {
		$filenames[] = $stem . '.webp';
	}

	if ( null === $attachment_urls ) {
		$attachment_urls = array();
		$attachment_stems = array();
		$attachments     = get_posts(
			array(
				'post_type'      => 'attachment',
				'post_status'    => 'inherit',
				'posts_per_page' => -1,
				'fields'         => 'ids',
				'no_found_rows'  => true,
			)
		);
		foreach ( $attachments as $attachment_id ) {
			$attached_file = (string) get_post_meta( $attachment_id, '_wp_attached_file', true );
			$attached_name = strtolower( wp_basename( $attached_file ) );
			if ( $attached_name !== '' ) {
				$attachment_urls[ $attached_name ] = (string) wp_get_attachment_url( (int) $attachment_id );
				$attachment_stems[ pathinfo( $attached_name, PATHINFO_FILENAME ) ] = $attachment_urls[ $attached_name ];
			}
		}
	}

	$media_urls[ $filename ] = '';
	foreach ( array_unique( $filenames ) as $candidate ) {
		$candidate = strtolower( $candidate );
		if ( isset( $attachment_urls[ $candidate ] ) ) {
			$media_urls[ $filename ] = $attachment_urls[ $candidate ];
			break;
		}
		$stem       = pathinfo( $candidate, PATHINFO_FILENAME );
		$extension  = pathinfo( $candidate, PATHINFO_EXTENSION );
		if ( isset( $attachment_stems[ $stem ] ) ) {
			$media_urls[ $filename ] = $attachment_stems[ $stem ];
			break;
		}
		$pattern    = '/^' . preg_quote( $stem, '/' ) . '-[0-9]+\.' . preg_quote( $extension, '/' ) . '$/';
		foreach ( $attachment_urls as $attached_name => $url ) {
			if ( preg_match( $pattern, $attached_name ) ) {
				$media_urls[ $filename ] = $url;
				break 2;
			}
		}
	}
	return $media_urls[ $filename ];
}

function restwell_theme_image_url( string $relative ): string {
	$relative = ltrim( str_replace( '\\', '/', $relative ), '/' );
	$media_url = restwell_theme_media_url( $relative );
	if ( $media_url !== '' ) {
		return $media_url;
	}
	$base     = get_template_directory() . '/assets/images/';
	$dir      = dirname( $relative );
	$stem     = pathinfo( $relative, PATHINFO_FILENAME );
	$opt_rel  = ( '.' === $dir || '' === $dir )
		? 'opt/' . $stem . '.webp'
		: $dir . '/opt/' . $stem . '.webp';
	if ( is_readable( $base . $opt_rel ) ) {
		return get_template_directory_uri() . '/assets/images/' . $opt_rel;
	}
	return get_template_directory_uri() . '/assets/images/' . $relative;
}
