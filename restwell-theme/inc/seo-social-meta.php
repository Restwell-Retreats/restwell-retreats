<?php
/**
 * Social meta output (Open Graph + Twitter Card).
 *
 * Kept in a dedicated include to reduce `inc/seo.php` file size and separate
 * social graph tags from JSON-LD and canonical logic.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme-relative image paths for Open Graph / Featured heroes by page slug.
 *
 * Paths are under assets/images/. Place-led and local-area pages use the new
 * Kent/Whitstable stock JPGs; product pages use inviting bungalow photos
 * (garden, lounge, bedroom) rather than kit/detail documentary shots.
 *
 * @return array<string, string> Slug => path relative to assets/images/.
 */
function restwell_get_default_og_stock_filename_map() {
	return array(
		'home'                  => 'stock/restwell-whitstable-promenade-golden-hour.jpg',
		'our-story'             => 'stock/restwell-kent-riverside-brick-house.jpg',
		'the-property'          => 'bungalow/GRDEN-1-LS.jpg',
		'accessibility'         => 'stock/restwell-whitstable-promenade-golden-hour.jpg',
		'pricing'               => 'bungalow/LR-2-LS.jpg',
		'how-it-works'          => 'bungalow/BD1-2-LS.jpg',
		'who-its-for'           => 'stock/restwell-whitstable-beach-huts-sunset-slope.jpg',
		'whitstable-area-guide' => 'stock/restwell-whitstable-painted-beach-huts.jpg',
		'resources'             => 'stock/restwell-whitstable-beach-huts-promenade-sunset.jpg',
		'optional-care'         => 'bungalow/LR-1-LS.jpg',
		'faq'                   => 'stock/restwell-canterbury-riverside-walk.jpg',
		'enquire'               => 'stock/restwell-whitstable-beach-huts-pier-view.jpg',
		'blog'                  => 'stock/restwell-whitstable-beach-sailboats-sunset.jpg',
		'guest-guide'           => 'stock/restwell-whitstable-beach-hut-gallery.jpg',
		'privacy-policy'        => 'stock/restwell-whitstable-pebble-beach-groynes.jpg',
		'terms-and-conditions'  => 'stock/restwell-whitstable-shingle-beach-sunset.jpg',
		'accessibility-policy'  => 'stock/restwell-kent-nursery-hedgerow-path.jpg',
	);
}

/**
 * Absolute URL for the default OG image for the current request / post.
 *
 * @param int $post_id Queried post ID (0 for non-singular).
 * @return string Absolute image URL or empty string.
 */
function restwell_get_default_og_image_url_for_request( $post_id = 0 ) {
	$post_id  = absint( $post_id );
	$map      = restwell_get_default_og_stock_filename_map();
	$filename = '';

	if ( $post_id > 0 ) {
		$slug = (string) get_post_field( 'post_name', $post_id );
		if ( $slug !== '' && isset( $map[ $slug ] ) ) {
			$filename = $map[ $slug ];
		}
		$front_id = (int) get_option( 'page_on_front', 0 );
		if ( $filename === '' && $front_id > 0 && $post_id === $front_id ) {
			$filename = $map['home'];
		}
		$blog_id = (int) get_option( 'page_for_posts', 0 );
		if ( $filename === '' && $blog_id > 0 && $post_id === $blog_id ) {
			$filename = $map['blog'];
		}
	} elseif ( is_front_page() ) {
		$filename = $map['home'];
	} elseif ( is_home() ) {
		$filename = $map['blog'];
	}

	if ( $filename === '' ) {
		return '';
	}

	// Paths may be stock/foo.jpg or bungalow/foo.jpg (relative to assets/images/).
	$rel = ltrim( $filename, '/' );
	if ( false === strpos( $filename, '/' ) ) {
		$rel = 'stock/' . $rel;
	}
	$path = get_template_directory() . '/assets/images/' . $rel;
	if ( ! is_readable( $path ) ) {
		return '';
	}

	// Route through the WebP optimisation helper so social crawlers fetch the
	// same lightweight opt/ variant used on-page, not the raw multi-MB source.
	return restwell_theme_image_url( $rel );
}

/**
 * Output Open Graph and Twitter Card <meta> tags in <head>.
 */
function restwell_output_social_meta() {
	if ( is_404() || is_search() || is_page_template( 'page-guest-guide.php' ) || is_page( 'sample-page' ) ) {
		return;
	}

	$pid = is_singular() ? get_queried_object_id() : 0;

	// Title
	if ( $pid ) {
		$title = (string) get_post_meta( $pid, 'meta_title', true );
		if ( $title === '' ) {
			$defaults = restwell_get_seo_default_meta_for_post_id( $pid );
			$title    = $defaults['meta_title'] !== '' ? $defaults['meta_title'] : get_the_title( $pid );
		}
	} else {
		$title = restwell_get_request_level_title_fallback();
	}
	$title = restwell_trim_meta_text( $title, 60 );

	// Description
	$desc = restwell_get_meta_description_for_request();
	if ( $pid ) {
		$desc = (string) get_post_meta( $pid, 'meta_description', true );
		if ( $desc === '' ) {
			$defaults = restwell_get_seo_default_meta_for_post_id( $pid );
			$desc     = $defaults['meta_description'];
		}
		if ( $desc === '' && is_singular( 'post' ) ) {
			$desc = wp_strip_all_tags( get_the_excerpt( $pid ) );
		}
	}
	if ( $desc === '' ) {
		$desc = (string) get_bloginfo( 'description' );
	}
	$desc = restwell_trim_meta_text( $desc, 160 );

	// URL — match canonical (archives, pagination, meta_canonical) so og:url is not the homepage on non-singular views.
	$url = '';
	if ( function_exists( 'restwell_get_canonical_url_for_request' ) ) {
		$url = (string) restwell_get_canonical_url_for_request();
	}
	if ( $url === '' ) {
		$url = $pid ? (string) get_permalink( $pid ) : home_url( '/' );
	}
	if ( is_front_page() ) {
		$url = home_url( '/' );
	}

	// Image - og_image_id → featured image (posts) → template hero image → page stock map → coastline.
	$image_url           = '';
	$image_attachment_id = 0;
	if ( $pid ) {
		$og_img_id = absint( get_post_meta( $pid, 'og_image_id', true ) );
		if ( $og_img_id ) {
			$image_url           = wp_get_attachment_image_url( $og_img_id, 'full' );
			$image_attachment_id = $image_url ? $og_img_id : 0;
		}
		// Featured image for pages and posts.
		if ( ! $image_url ) {
			$thumb_id = get_post_thumbnail_id( $pid );
			if ( $thumb_id ) {
				$image_url           = wp_get_attachment_image_url( $thumb_id, 'full' );
				$image_attachment_id = $image_url ? $thumb_id : 0;
			}
		}
		if ( ! $image_url ) {
			// Fallback: template hero image meta keys.
			$hero_keys = function_exists( 'restwell_page_hero_meta_keys_all' )
				? restwell_page_hero_meta_keys_all()
				: array( 'hero_media_id', 'prop_hero_image_id' );
			foreach ( $hero_keys as $key ) {
				$hero_id = absint( get_post_meta( $pid, $key, true ) );
				if ( $hero_id ) {
					$candidate = wp_get_attachment_image_url( $hero_id, 'full' );
					if ( $candidate ) {
						$image_url           = $candidate;
						$image_attachment_id = $hero_id;
						break;
					}
				}
			}
		}
	}

	// Page-keyed theme stock (distinct per surface before the generic coastline).
	if ( ! $image_url && function_exists( 'restwell_get_default_og_image_url_for_request' ) ) {
		$mapped = restwell_get_default_og_image_url_for_request( $pid );
		if ( $mapped !== '' ) {
			$image_url = $mapped;
		}
	}

	// Last resort: theme stock coastline (covers unknown pages / Playground gaps).
	if ( ! $image_url ) {
			 $image_url = restwell_theme_image_url( 'stock/restwell-whitstable-coastline-panorama.webp' );
	}

	$image_width  = 0;
	$image_height = 0;
	$image_alt    = '';
	if ( $image_attachment_id > 0 ) {
		$img_meta = wp_get_attachment_metadata( $image_attachment_id );
		if ( is_array( $img_meta ) ) {
			$image_width  = ! empty( $img_meta['width'] ) ? absint( $img_meta['width'] ) : 0;
			$image_height = ! empty( $img_meta['height'] ) ? absint( $img_meta['height'] ) : 0;
		}
		$image_alt = function_exists( 'restwell_attachment_image_alt' )
			? restwell_attachment_image_alt( $image_attachment_id )
			: trim( (string) get_post_meta( $image_attachment_id, '_wp_attachment_image_alt', true ) );
	}
	if ( $image_alt === '' ) {
		$image_alt = $title !== '' ? $title : (string) get_bloginfo( 'name' );
	}

	// og:type - use saved value if set, otherwise derive from post type.
	$og_type = $pid ? (string) get_post_meta( $pid, 'meta_og_type', true ) : '';
	if ( ! in_array( $og_type, array( 'website', 'article' ), true ) ) {
		$og_type = is_singular( 'post' ) ? 'article' : 'website';
	}

	echo "\n<!-- Open Graph -->\n";
	echo '<meta property="og:locale" content="en_GB">' . "\n";
	echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . "\n";
	echo '<meta property="og:type" content="' . esc_attr( $og_type ) . '">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
	if ( $desc !== '' ) {
		echo '<meta property="og:description" content="' . esc_attr( $desc ) . '">' . "\n";
	}
	echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
	if ( $image_url ) {
		echo '<meta property="og:image" content="' . esc_url( $image_url ) . '">' . "\n";
		if ( $image_width > 0 ) {
			echo '<meta property="og:image:width" content="' . esc_attr( (string) $image_width ) . '">' . "\n";
		}
		if ( $image_height > 0 ) {
			echo '<meta property="og:image:height" content="' . esc_attr( (string) $image_height ) . '">' . "\n";
		}
	}
	if ( $pid && is_front_page() ) {
		echo '<meta property="article:published_time" content="' . esc_attr( get_the_date( 'c', $pid ) ) . '">' . "\n";
		echo '<meta property="article:modified_time" content="' . esc_attr( get_the_modified_date( 'c', $pid ) ) . '">' . "\n";
	}
	if ( is_singular( 'post' ) ) {
		$post_obj = get_post();
		if ( $post_obj ) {
			echo '<meta property="article:published_time" content="' . esc_attr( get_the_date( 'c', $post_obj ) ) . '">' . "\n";
			echo '<meta property="article:author" content="' . esc_attr( get_the_author_meta( 'display_name', (int) $post_obj->post_author ) ) . '">' . "\n";
		}
	}

	echo "\n<!-- Twitter Card -->\n";
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '">' . "\n";
	if ( $desc !== '' ) {
		echo '<meta name="twitter:description" content="' . esc_attr( $desc ) . '">' . "\n";
	}
	if ( $image_url ) {
		echo '<meta name="twitter:image" content="' . esc_url( $image_url ) . '">' . "\n";
		echo '<meta name="twitter:image:alt" content="' . esc_attr( wp_strip_all_tags( $image_alt ) ) . '">' . "\n";
	}
	echo "\n";
}
add_action( 'wp_head', 'restwell_output_social_meta', 5 );
