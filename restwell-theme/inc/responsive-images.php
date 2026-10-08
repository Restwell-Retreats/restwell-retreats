<?php
/**
 * Responsive images: srcset + sizes for theme assets and Media Library URLs.
 *
 * Templates print most images by URL (restwell_theme_image_url(), hero
 * attachment URLs), which bypasses WordPress's srcset pipeline. This module
 * restores it in one place:
 *
 * - restwell_image_srcset( $url ) builds a srcset for a theme Opt WebP (from the
 *   opt/<stem>-<w>w.webp variants made by tools/generate-opt-webp.sh) or for a
 *   Media Library URL (from the attachment's registered sizes).
 * - A front-end output filter adds srcset and sizes to every <img> that has a
 *   resolvable src and no srcset of its own. Templates that know their layout
 *   set an explicit sizes attribute, which the filter keeps.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Pixel width of a local image file (cached per request).
 *
 * @param string $path Absolute path.
 * @return int
 */
function restwell_image_file_width( $path ) {
	static $cache = array();
	if ( ! isset( $cache[ $path ] ) ) {
		$size           = is_readable( $path ) ? wp_getimagesize( $path ) : false;
		$cache[ $path ] = $size ? (int) $size[0] : 0;
	}
	return $cache[ $path ];
}

/**
 * srcset for a theme asset Opt WebP URL, or '' when it has no variants.
 *
 * @param string $url Image URL.
 * @return string
 */
function restwell_theme_image_srcset( $url ) {
	$base_uri = get_template_directory_uri() . '/assets/images/';
	$path     = (string) wp_parse_url( $url, PHP_URL_PATH );
	$base     = (string) wp_parse_url( $base_uri, PHP_URL_PATH );
	if ( '' === $path || 0 !== strpos( $path, $base ) || ! preg_match( '#/opt/([^/]+)\.webp$#', $path, $m ) ) {
		return '';
	}
	$rel  = substr( $path, strlen( $base ) );
	$file = get_template_directory() . '/assets/images/' . $rel;
	$dir  = dirname( $file );
	$stem = preg_replace( '/-\d+w$/', '', $m[1] );

	$candidates = array();
	$opt_file   = $dir . '/' . $stem . '.webp';
	$opt_width  = restwell_image_file_width( $opt_file );
	if ( $opt_width > 0 ) {
		$candidates[ $opt_width ] = $base_uri . dirname( $rel ) . '/' . $stem . '.webp';
	}
	foreach ( (array) glob( $dir . '/' . $stem . '-*w.webp' ) as $variant ) {
		if ( preg_match( '/-(\d+)w\.webp$/', $variant, $vm ) ) {
			$w = restwell_image_file_width( $variant );
			if ( $w > 0 ) {
				$candidates[ $w ] = $base_uri . dirname( $rel ) . '/' . basename( $variant );
			}
		}
	}
	if ( count( $candidates ) < 2 ) {
		return '';
	}
	ksort( $candidates );
	$parts = array();
	foreach ( $candidates as $w => $src ) {
		$parts[] = esc_url( $src ) . ' ' . $w . 'w';
	}
	return implode( ', ', $parts );
}

/**
 * Attachment ID for a Media Library URL, including intermediate-size URLs.
 *
 * @param string $url Image URL.
 * @return int
 */
function restwell_attachment_id_from_url( $url ) {
	static $cache = array();
	if ( isset( $cache[ $url ] ) ) {
		return $cache[ $url ];
	}
	$uploads = wp_get_upload_dir();
	$id      = 0;
	if ( ! empty( $uploads['baseurl'] ) && false !== strpos( $url, (string) wp_parse_url( $uploads['baseurl'], PHP_URL_PATH ) ) ) {
		$id = (int) attachment_url_to_postid( $url );
		if ( ! $id ) {
			$full = preg_replace( '/-(?:\d+x\d+|scaled)(\.[a-z0-9]+)$/i', '$1', $url );
			$id   = $full !== $url ? (int) attachment_url_to_postid( $full ) : 0;
		}
	}
	$cache[ $url ] = $id;
	return $id;
}

/**
 * Theme Opt WebP twin of a Media Library image, or ''.
 *
 * Most hero and section photos exist twice: uploaded to the Media Library (so
 * the owner can swap them) and bundled in assets/images/ with WebP width
 * variants. WordPress serves its own JPEG sizes, which ran up to 205 KB for a
 * 768px hero; the twin is the same photo at about half the bytes. Matching is
 * by file stem, so a photo swapped in admin with no theme copy keeps its
 * WordPress sizes.
 *
 * @param string $url Image URL.
 * @return string Theme Opt WebP URL with width variants, or ''.
 */
function restwell_theme_twin_url( $url ) {
	static $index = null;
	static $cache = array();
	$url = (string) $url;
	if ( isset( $cache[ $url ] ) ) {
		return $cache[ $url ];
	}
	$cache[ $url ] = '';
	$uploads       = wp_get_upload_dir();
	$base_path     = empty( $uploads['baseurl'] ) ? '' : (string) wp_parse_url( $uploads['baseurl'], PHP_URL_PATH );
	$path          = (string) wp_parse_url( $url, PHP_URL_PATH );
	if ( '' === $base_path || 0 !== strpos( $path, $base_path ) || ! function_exists( 'restwell_theme_image_url' ) ) {
		return '';
	}
	if ( null === $index ) {
		$index = array();
		$root  = get_template_directory() . '/assets/images/';
		foreach ( array( 'bungalow', 'stock', 'journey' ) as $dir ) {
			// No GLOB_BRACE: it is undefined on some PHP builds (Playground, musl).
			foreach ( (array) glob( $root . $dir . '/*.*' ) as $file ) {
				$stem = strtolower( (string) pathinfo( $file, PATHINFO_FILENAME ) );
				if ( ! preg_match( '/\.(?:jpe?g|png|webp)$/i', $file ) ) {
					continue;
				}
				if ( ! isset( $index[ $stem ] ) ) {
					$index[ $stem ] = $dir . '/' . basename( $file );
				}
			}
		}
	}
	$stem = strtolower( (string) preg_replace( '/-(?:\d+x\d+|scaled)$/i', '', (string) pathinfo( $path, PATHINFO_FILENAME ) ) );
	if ( ! isset( $index[ $stem ] ) ) {
		return '';
	}
	$twin = (string) restwell_theme_image_url( $index[ $stem ] );
	if ( '' !== restwell_theme_image_srcset( $twin ) ) {
		$cache[ $url ] = $twin;
	}
	return $cache[ $url ];
}

/**
 * srcset for any theme or Media Library image URL, or ''.
 *
 * @param string $url Image URL.
 * @return string
 */
function restwell_image_srcset( $url ) {
	$url = (string) $url;
	if ( '' === $url ) {
		return '';
	}
	$twin = restwell_theme_twin_url( $url );
	if ( '' !== $twin ) {
		$url = $twin;
	}
	$theme = restwell_theme_image_srcset( $url );
	if ( '' !== $theme ) {
		return $theme;
	}
	$att_id = restwell_attachment_id_from_url( $url );
	if ( $att_id > 0 ) {
		$meta = wp_get_attachment_metadata( $att_id );
		if ( is_array( $meta ) && ! empty( $meta['width'] ) ) {
			$srcset = wp_calculate_image_srcset( array( (int) $meta['width'], (int) $meta['height'] ), wp_get_attachment_url( $att_id ), $meta, $att_id );
			return $srcset ? (string) $srcset : '';
		}
	}
	return '';
}

/**
 * Default sizes for an image the template gave no sizes for.
 *
 * Heroes (fetchpriority high) span the viewport. Everything else lets
 * browsers that support sizes="auto" use the laid-out width, and falls back to
 * full width on phones and the image's own width attribute above that.
 *
 * @param WP_HTML_Tag_Processor $img Processor positioned on an <img>.
 * @return string
 */
function restwell_default_image_sizes( $img ) {
	if ( 'high' === $img->get_attribute( 'fetchpriority' ) ) {
		return '100vw';
	}
	$width = (int) $img->get_attribute( 'width' );
	$cap   = $width > 0 ? min( $width, 1200 ) . 'px' : '50vw';
	$auto  = 'lazy' === $img->get_attribute( 'loading' ) ? 'auto, ' : '';
	return $auto . '(max-width: 767px) 100vw, ' . $cap;
}

/**
 * Add srcset/sizes to <img> tags in a block of HTML.
 *
 * @param string $html HTML.
 * @return string
 */
function restwell_add_srcset_to_html( $html ) {
	if ( false === stripos( $html, '<img' ) || ! class_exists( 'WP_HTML_Tag_Processor' ) ) {
		return $html;
	}
	$p = new WP_HTML_Tag_Processor( $html );
	while ( $p->next_tag( 'img' ) ) {
		$src = $p->get_attribute( 'src' );
		// Media Library photo with a theme WebP twin: serve the twin, even over
		// WordPress's own srcset.
		$twin = is_string( $src ) ? restwell_theme_twin_url( $src ) : '';
		if ( '' !== $twin ) {
			$p->set_attribute( 'src', $twin );
			$p->set_attribute( 'srcset', restwell_theme_image_srcset( $twin ) );
			if ( null === $p->get_attribute( 'sizes' ) ) {
				$p->set_attribute( 'sizes', restwell_default_image_sizes( $p ) );
			}
			continue;
		}
		if ( null !== $p->get_attribute( 'srcset' ) ) {
			continue;
		}
		if ( ! is_string( $src ) || '' === $src || 0 === strpos( $src, 'data:' ) ) {
			continue;
		}
		$srcset = restwell_image_srcset( $src );
		if ( '' === $srcset ) {
			continue;
		}
		$p->set_attribute( 'srcset', $srcset );
		if ( null === $p->get_attribute( 'sizes' ) ) {
			$p->set_attribute( 'sizes', restwell_default_image_sizes( $p ) );
		}
	}
	return $p->get_updated_html();
}

add_filter( 'restwell_front_html', 'restwell_add_srcset_to_html' );

/**
 * Buffer front-end HTML pages and pass them through the `restwell_front_html`
 * filter (srcset here; unpublished-guide links in inc/internal-links.php).
 */
function restwell_start_front_html_buffer() {
	if ( is_admin() || is_feed() || is_embed() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) || is_robots() ) {
		return;
	}
	ob_start(
		static function ( $html ) {
			return (string) apply_filters( 'restwell_front_html', (string) $html );
		}
	);
}
add_action( 'template_redirect', 'restwell_start_front_html_buffer', PHP_INT_MAX );
