<?php
/**
 * Page hero helpers: Featured image as source of truth for photo heroes + OG.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Whether the current view uses a full photo hero (transparent nav over media).
 *
 * Compact interiors (guest guide, 404, singles) keep a solid header.
 *
 * @return bool
 */
function restwell_page_has_photo_hero() {
	if ( is_front_page() ) {
		return true;
	}

	if ( is_404() || is_singular( 'post' ) ) {
		return false;
	}

	if ( is_search() ) {
		return true;
	}

	$compact = array(
		'page-guest-guide.php',
	);
	if ( is_page_template( $compact ) ) {
		return false;
	}

	if ( is_home() ) {
		return true;
	}

	$photo = array(
		'template-accessibility.php',
		'template-who-its-for.php',
		'template-faq.php',
		'template-pricing.php',
		'template-property.php',
		'template-how-it-works.php',
		'template-enquire.php',
		'template-resources.php',
		'template-care.php',
		'template-our-story.php',
		'template-whitstable-guide.php',
		'template-privacy-policy.php',
		'template-terms-and-conditions.php',
		'template-accessibility-policy.php',
	);

	return is_page_template( $photo );
}

/**
 * Template slug / context → Page content hero meta key.
 *
 * @param WP_Post|null $post Page post.
 * @return string Meta key or empty.
 */
function restwell_page_hero_meta_key( $post = null ) {
	if ( ! $post instanceof WP_Post ) {
		return '';
	}

	$front_id = (int) get_option( 'page_on_front', 0 );
	if ( $front_id > 0 && (int) $post->ID === $front_id ) {
		return 'hero_media_id';
	}

	$template = (string) get_page_template_slug( $post );
	$map      = array(
		'template-property.php'             => 'prop_hero_image_id',
		'template-how-it-works.php'         => 'hiw_hero_image_id',
		'template-accessibility.php'        => 'acc_hero_image_id',
		'template-who-its-for.php'          => 'wif_hero_image_id',
		'template-whitstable-guide.php'     => 'wg_hero_image_id',
		'template-faq.php'                  => 'faq_hero_image_id',
		'template-enquire.php'              => 'enq_hero_image_id',
		'template-pricing.php'              => 'pricing_hero_image_id',
		'template-resources.php'            => 'res_hero_image_id',
		'template-care.php'                 => 'care_hero_image_id',
		'template-our-story.php'            => 'story_hero_image_id',
		'template-privacy-policy.php'       => 'legal_hero_image_id',
		'template-terms-and-conditions.php' => 'legal_hero_image_id',
		'template-accessibility-policy.php' => 'legal_hero_image_id',
	);

	return isset( $map[ $template ] ) ? $map[ $template ] : '';
}

/**
 * All known page hero meta keys (for OG fallbacks).
 *
 * @return string[]
 */
function restwell_page_hero_meta_keys_all() {
	return array(
		'hero_media_id',
		'prop_hero_image_id',
		'hiw_hero_image_id',
		'acc_hero_image_id',
		'wif_hero_image_id',
		'wg_hero_image_id',
		'faq_hero_image_id',
		'enq_hero_image_id',
		'pricing_hero_image_id',
		'res_hero_image_id',
		'care_hero_image_id',
		'story_hero_image_id',
		'legal_hero_image_id',
		'page_hero_image_id',
	);
}

/**
 * Resolve attachment ID for a page hero: Featured → template hero meta → 0.
 *
 * @param int $post_id Page ID.
 * @return int
 */
function restwell_page_hero_attachment_id( $post_id = 0 ) {
	$post_id = absint( $post_id );
	if ( $post_id < 1 ) {
		return 0;
	}

	$thumb = (int) get_post_thumbnail_id( $post_id );
	if ( $thumb > 0 && wp_attachment_is_image( $thumb ) ) {
		return $thumb;
	}

	$post = get_post( $post_id );
	$key  = restwell_page_hero_meta_key( $post );
	if ( $key !== '' ) {
		$hero = absint( get_post_meta( $post_id, $key, true ) );
		if ( $hero > 0 && wp_attachment_is_image( $hero ) ) {
			return $hero;
		}
	}

	return 0;
}

/**
 * Theme asset path for a page hero (OG map), or empty.
 *
 * @param int $post_id Page ID.
 * @return string Path relative to assets/images/ (e.g. bungalow/foo.jpg).
 */
function restwell_page_hero_stock_filename( $post_id = 0 ) {
	$post_id = absint( $post_id );
	if ( $post_id < 1 || ! function_exists( 'restwell_get_default_og_stock_filename_map' ) ) {
		return '';
	}

	$map  = restwell_get_default_og_stock_filename_map();
	$slug = (string) get_post_field( 'post_name', $post_id );

	$front_id = (int) get_option( 'page_on_front', 0 );
	if ( $front_id > 0 && $post_id === $front_id ) {
		$slug = 'home';
	}
	$blog_id = (int) get_option( 'page_for_posts', 0 );
	if ( $blog_id > 0 && $post_id === $blog_id ) {
		$slug = 'blog';
	}

	// Optional care page may use optional-care slug.
	if ( $slug === 'care-during-your-stay' && isset( $map['optional-care'] ) ) {
		$slug = 'optional-care';
	}

	return ( $slug !== '' && isset( $map[ $slug ] ) ) ? (string) $map[ $slug ] : '';
}

/**
 * Absolute filesystem path for a theme image relative path.
 *
 * @param string $rel Path relative to assets/images/, or bare stock basename.
 * @return string Absolute path or empty.
 */
function restwell_theme_image_abs_path( $rel ) {
	$rel = ltrim( str_replace( '\\', '/', (string) $rel ), '/' );
	if ( $rel === '' || false !== strpos( $rel, '..' ) ) {
		return '';
	}
	if ( false === strpos( $rel, '/' ) ) {
		$rel = 'stock/' . $rel;
	}
	$path = get_template_directory() . '/assets/images/' . $rel;
	return is_readable( $path ) ? $path : '';
}

/**
 * Absolute URL for the page hero image (attachment or theme asset fallback).
 *
 * Prefers the restwell-hero size when available so large uploads stay sharp
 * without shipping a multi‑megabyte original to the browser.
 *
 * @param int $post_id Page ID.
 * @return string
 */
function restwell_page_hero_image_url( $post_id = 0 ) {
	$post_id = absint( $post_id );
	$att_id  = restwell_page_hero_attachment_id( $post_id );
	if ( $att_id > 0 ) {
		$size = function_exists( 'restwell_pick_attachment_size' )
			? restwell_pick_attachment_size( $att_id, 'restwell-hero', 'large', 'full' )
			: 'full';
		$url  = wp_get_attachment_image_url( $att_id, $size );
		if ( $url ) {
			return $url;
		}
	}

	$rel = restwell_page_hero_stock_filename( $post_id );
	if ( $rel !== '' && function_exists( 'restwell_theme_image_url' ) ) {
		if ( false === strpos( $rel, '/' ) ) {
			$rel = 'stock/' . $rel;
		}
		return restwell_theme_image_url( $rel );
	}

	if ( function_exists( 'restwell_theme_image_url' ) ) {
		return restwell_theme_image_url( 'stock/restwell-whitstable-coastline-panorama.webp' );
	}

	return get_template_directory_uri() . '/assets/images/stock/restwell-whitstable-coastline-panorama.webp';
}

/**
 * Theme-bundled image path → visitor-facing alt text.
 *
 * Keys are paths relative to assets/images/. Lookup also matches basename.
 *
 * @return array<string, string>
 */
function restwell_theme_image_alt_map() {
	return array(
		'stock/restwell-whitstable-beach-huts-promenade-sunset.jpg' => __( 'Colourful beach huts along Tankerton promenade at sunset, Whitstable', 'restwell-retreats' ),
		'stock/restwell-kent-riverside-brick-house.jpg'             => __( 'Brick house beside a riverside path in Kent', 'restwell-retreats' ),
		'stock/restwell-whitstable-promenade-golden-hour.jpg'       => __( 'Tankerton promenade at golden hour, Whitstable', 'restwell-retreats' ),
		'stock/restwell-whitstable-beach-huts-sunset-slope.jpg'     => __( 'Beach huts on the Tankerton slope at sunset', 'restwell-retreats' ),
		'stock/restwell-whitstable-painted-beach-huts.jpg'          => __( 'Painted beach huts on the Whitstable seafront', 'restwell-retreats' ),
		'stock/restwell-kent-woodland-paved-path.jpg'              => __( 'Paved woodland path in Kent', 'restwell-retreats' ),
		'stock/restwell-canterbury-riverside-walk.jpg'             => __( 'Riverside walk in Canterbury', 'restwell-retreats' ),
		'stock/restwell-whitstable-beach-huts-pier-view.jpg'        => __( 'Whitstable beach huts with the pier beyond', 'restwell-retreats' ),
		'stock/restwell-whitstable-beach-sailboats-sunset.jpg'      => __( 'Sailboats off Whitstable beach at sunset', 'restwell-retreats' ),
		'stock/restwell-whitstable-beach-hut-gallery.jpg'           => __( 'Row of colourful Whitstable beach huts', 'restwell-retreats' ),
		'stock/restwell-whitstable-pebble-beach-groynes.jpg'        => __( 'Pebble beach and groynes at Whitstable', 'restwell-retreats' ),
		'stock/restwell-whitstable-shingle-beach-sunset.jpg'        => __( 'Shingle beach at Whitstable at sunset', 'restwell-retreats' ),
		'stock/restwell-kent-nursery-hedgerow-path.jpg'            => __( 'Hedgerow path through a Kent nursery', 'restwell-retreats' ),
		'stock/restwell-whitstable-coastline-panorama.webp'        => __( 'Whitstable coastline looking along the seafront', 'restwell-retreats' ),
		'stock/restwell-whitstable-coastal-pathway.webp'           => __( 'Flat, paved coastal pathway along Tankerton promenade', 'restwell-retreats' ),
		'stock/restwell-whitstable-marina-sunset.webp'             => __( 'Whitstable harbour and marina at sunset', 'restwell-retreats' ),
		'stock/restwell-whitstable-drone-aerial-view.webp'         => __( 'Aerial view of Whitstable and the Kent coast', 'restwell-retreats' ),
		'stock/restwell-whitstable-beach-huts.webp'                => __( 'Colourful beach huts along the Whitstable seafront', 'restwell-retreats' ),
		'stock/restwell-whitstable-sunset-pier.webp'               => __( 'Whitstable harbour area at sunset', 'restwell-retreats' ),
		'stock/restwell-whitstable-coastal-walk.webp'              => __( 'Coastal walk near the Whitstable seafront', 'restwell-retreats' ),
		'stock/russell-drive-whitstable.webp'                      => __( 'Quiet residential street near Tankerton', 'restwell-retreats' ),
		'stock/whitstable-days-out.webp'                           => __( 'Woodland day out near the Kent coast', 'restwell-retreats' ),
		'stock/row-of-colorful-beach-homes-2026-03-25-01-44-35-utc.webp' => __( 'Colourful seaside buildings on the Kent coast', 'restwell-retreats' ),
		'stock/st-augustines-abbey-in-caterbury-city-england-2026-03-20-01-00-24-utc.webp' => __( 'Historic stone ruins in Canterbury', 'restwell-retreats' ),
		'stock/restwell-whitstable-beach-relaxation.webp'          => __( 'Guest relaxing on the Whitstable seafront', 'restwell-retreats' ),
		'stock/restwell-kent-woodland-ferns.jpg'                   => __( 'Woodland ferns beside a path in Kent', 'restwell-retreats' ),
		'stock/restwell-kent-woodland-trail.jpg'                   => __( 'Woodland trail in Kent', 'restwell-retreats' ),
		'stock/restwell-whitstable-beach-hut-mural.jpg'            => __( 'Painted beach-hut mural on the Whitstable seafront', 'restwell-retreats' ),
		'bungalow/LR-RNR-LS.jpg'                                   => __( 'Open-plan living room with a rise-and-recline chair and wide walkways', 'restwell-retreats' ),
		'bungalow/SB-3-LS.jpg'                                     => __( 'Conservatory sofa bed opened into a fifth guest bed', 'restwell-retreats' ),
		'bungalow/BD1-2-LS.jpg'                                    => __( 'Second double bedroom with beach-hut bedding', 'restwell-retreats' ),
		'bungalow/SB-1-LS.jpg'                                     => __( 'Conservatory sofa with level access to the garden', 'restwell-retreats' ),
		'bungalow/EX-1-LS.jpg'                                     => __( 'Restwell bungalow exterior in Whitstable', 'restwell-retreats' ),
		'bungalow/LR-1-LS.jpg'                                     => __( 'Open-plan living room with rise-and-recline chair and wide walkways', 'restwell-retreats' ),
		'bungalow/WR-1-LS.jpg'                                     => __( 'Level-access wet room with grab rails', 'restwell-retreats' ),
		'bungalow/entrance.png'                                    => __( 'Step-free entrance doors to the Restwell bungalow', 'restwell-retreats' ),
		'partners/care-spaces.png'                                 => __( 'Care Spaces', 'restwell-retreats' ),
		'partners/thor-carpentry.png'                              => __( 'Thor Carpentry', 'restwell-retreats' ),
		'partners/wealden-rehab.png'                               => __( 'Wealden Rehab', 'restwell-retreats' ),
		'partners/continuity-of-care-services.png'                 => __( 'Continuity of Care Services', 'restwell-retreats' ),
		'partners/continuity-training-academy.png'                 => __( 'Continuity Training Academy', 'restwell-retreats' ),
		'partners/continuity-of-care-services-long.png'            => __( 'Continuity of Care Services', 'restwell-retreats' ),
		'partners/cqc-rating-good.jpg'                             => __( 'CQC rating Good for Continuity of Care Services', 'restwell-retreats' ),
		'long_logo.png'                                            => __( 'Restwell by Continuity of Care Services', 'restwell-retreats' ),
		'logo.png'                                                 => __( 'Restwell by Continuity of Care Services', 'restwell-retreats' ),
	);
}

/**
 * Visitor-facing alt for a theme image path.
 *
 * @param string $rel Path relative to assets/images/, or a basename.
 * @return string
 */
function restwell_theme_image_alt( $rel ) {
	$rel = ltrim( str_replace( '\\', '/', (string) $rel ), '/' );
	if ( $rel === '' ) {
		return '';
	}

	$map = restwell_theme_image_alt_map();
	if ( isset( $map[ $rel ] ) ) {
		return $map[ $rel ];
	}

	$normalised = function_exists( 'restwell_normalise_stock_rel' )
		? restwell_normalise_stock_rel( $rel )
		: $rel;
	if ( $normalised !== $rel && isset( $map[ $normalised ] ) ) {
		return $map[ $normalised ];
	}

	$base = basename( $rel );
	foreach ( $map as $key => $alt ) {
		if ( basename( $key ) === $base ) {
			return $alt;
		}
	}

	return '';
}

/**
 * Apply mapped theme alt to a Media Library attachment when alt is empty.
 *
 * @param int    $att_id Attachment ID.
 * @param string $rel    Optional path relative to assets/images/.
 * @return string Alt written or already present.
 */
function restwell_maybe_set_attachment_alt_from_theme_map( $att_id, $rel = '' ) {
	$att_id = absint( $att_id );
	if ( $att_id < 1 ) {
		return '';
	}

	$existing = trim( (string) get_post_meta( $att_id, '_wp_attachment_image_alt', true ) );
	if ( $existing !== '' ) {
		return $existing;
	}

	if ( $rel === '' ) {
		$rel = (string) get_post_meta( $att_id, '_restwell_stock_source', true );
	}

	$alt = restwell_theme_image_alt( $rel );
	if ( $alt === '' ) {
		return '';
	}

	update_post_meta( $att_id, '_wp_attachment_image_alt', $alt );
	return $alt;
}

/**
 * Visitor-facing alt for a Media Library image.
 *
 * Prefers Media Library alt, then theme stock map, then a non-filename title.
 *
 * @param int $attachment_id Attachment ID.
 * @return string
 */
function restwell_attachment_image_alt( $attachment_id ) {
	$attachment_id = absint( $attachment_id );
	if ( $attachment_id < 1 ) {
		return '';
	}

	$alt = trim( (string) get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) );
	if ( $alt !== '' && ! ( function_exists( 'restwell_is_internal_gallery_label' ) && restwell_is_internal_gallery_label( $alt ) ) ) {
		return $alt;
	}

	$source = (string) get_post_meta( $attachment_id, '_restwell_stock_source', true );
	$mapped = restwell_theme_image_alt( $source );
	if ( $mapped !== '' ) {
		return $mapped;
	}

	$file = (string) get_attached_file( $attachment_id );
	if ( $file !== '' ) {
		$mapped = restwell_theme_image_alt( basename( $file ) );
		if ( $mapped !== '' ) {
			return $mapped;
		}
	}

	$title = trim( (string) get_the_title( $attachment_id ) );
	if ( $title !== '' && ! ( function_exists( 'restwell_is_internal_gallery_label' ) && restwell_is_internal_gallery_label( $title ) ) ) {
		return $title;
	}

	return '';
}

/**
 * Alt text for a page photo hero (attachment, stock map, then heading).
 *
 * @param int    $post_id Page ID.
 * @param string $heading Fallback heading text.
 * @return string
 */
function restwell_page_hero_image_alt( $post_id = 0, $heading = '' ) {
	$post_id = absint( $post_id );
	$heading = trim( wp_strip_all_tags( (string) $heading ) );

	$att_id = $post_id > 0 ? restwell_page_hero_attachment_id( $post_id ) : 0;
	if ( $att_id > 0 ) {
		$alt = restwell_attachment_image_alt( $att_id );
		if ( $alt !== '' ) {
			return $alt;
		}
	}

	$rel = $post_id > 0 ? restwell_page_hero_stock_filename( $post_id ) : '';
	if ( $rel !== '' ) {
		$mapped = restwell_theme_image_alt( $rel );
		if ( $mapped !== '' ) {
			return $mapped;
		}
	}

	$mapped = restwell_theme_image_alt( 'stock/restwell-whitstable-coastline-panorama.webp' );
	if ( $mapped !== '' ) {
		return $mapped;
	}

	if ( $heading !== '' ) {
		return $heading;
	}

	return __( 'Accessible holiday bungalow in Whitstable', 'restwell-retreats' );
}

/**
 * Keep Featured image, template hero meta, and og_image_id aligned.
 *
 * Prefers Featured when set; otherwise uses hero meta or og_image_id.
 *
 * @param int $post_id Page ID.
 * @return int Attachment ID written (0 if none).
 */
function restwell_sync_page_hero_image_trio( $post_id ) {
	$post_id = absint( $post_id );
	if ( $post_id < 1 || 'page' !== get_post_type( $post_id ) ) {
		return 0;
	}

	$post = get_post( $post_id );
	if ( ! $post instanceof WP_Post ) {
		return 0;
	}

	$thumb = (int) get_post_thumbnail_id( $post_id );
	$key   = restwell_page_hero_meta_key( $post );
	$hero  = ( $key !== '' ) ? absint( get_post_meta( $post_id, $key, true ) ) : 0;
	$og    = absint( get_post_meta( $post_id, 'og_image_id', true ) );

	$id = 0;
	if ( $thumb > 0 && wp_attachment_is_image( $thumb ) ) {
		$id = $thumb;
	} elseif ( $hero > 0 && wp_attachment_is_image( $hero ) ) {
		$id = $hero;
	} elseif ( $og > 0 && wp_attachment_is_image( $og ) ) {
		$id = $og;
	}

	if ( $id < 1 ) {
		return 0;
	}

	if ( $thumb !== $id ) {
		set_post_thumbnail( $post_id, $id );
	}
	if ( $key !== '' && $hero !== $id ) {
		update_post_meta( $post_id, $key, $id );
	}
	if ( $og !== $id ) {
		update_post_meta( $post_id, 'og_image_id', $id );
	}

	return $id;
}

/**
 * After Page content fields save, sync hero image trio.
 *
 * @param int $post_id Post ID.
 */
function restwell_sync_page_hero_after_content_save( $post_id ) {
	restwell_sync_page_hero_image_trio( (int) $post_id );
}
add_action( 'save_post_page', 'restwell_sync_page_hero_after_content_save', 30 );

/**
 * When Featured image is set/removed in the editor, keep hero + OG in sync.
 *
 * @param int $meta_id    Unused.
 * @param int $post_id    Post ID.
 * @param string $meta_key Meta key.
 * @param mixed $meta_value Meta value.
 */
function restwell_sync_page_hero_on_thumbnail_meta( $meta_id, $post_id, $meta_key, $meta_value ) {
	if ( '_thumbnail_id' !== $meta_key || 'page' !== get_post_type( $post_id ) ) {
		return;
	}
	// Avoid recursion loops from set_post_thumbnail inside sync.
	static $busy = false;
	if ( $busy ) {
		return;
	}
	$busy = true;
	restwell_sync_page_hero_image_trio( (int) $post_id );
	$busy = false;
}
add_action( 'updated_post_meta', 'restwell_sync_page_hero_on_thumbnail_meta', 20, 4 );
add_action( 'added_post_meta', 'restwell_sync_page_hero_on_thumbnail_meta', 20, 4 );

/**
 * Find an existing Media Library attachment for a theme asset relative path.
 *
 * @param string $rel Path relative to assets/images/ (or bare basename).
 * @return int Attachment ID or 0.
 */
function restwell_find_stock_attachment_id( $rel ) {
	$rel = ltrim( str_replace( '\\', '/', (string) $rel ), '/' );
	if ( $rel === '' ) {
		return 0;
	}
	if ( false === strpos( $rel, '/' ) ) {
		$rel = 'stock/' . $rel;
	}

	$query = new WP_Query(
		array(
			'post_type'              => 'attachment',
			'post_status'            => 'inherit',
			'posts_per_page'         => 1,
			'fields'                 => 'ids',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			'meta_key'               => '_restwell_stock_source',
			'meta_value'             => $rel,
		)
	);

	if ( ! empty( $query->posts[0] ) ) {
		return (int) $query->posts[0];
	}

	// Legacy: basename-only meta from earlier stock webp seed.
	$base = basename( $rel );
	if ( $base !== $rel ) {
		$query = new WP_Query(
			array(
				'post_type'              => 'attachment',
				'post_status'            => 'inherit',
				'posts_per_page'         => 1,
				'fields'                 => 'ids',
				'no_found_rows'          => true,
				'update_post_meta_cache' => false,
				'update_post_term_cache' => false,
				'meta_key'               => '_restwell_stock_source',
				'meta_value'             => $base,
			)
		);
		if ( ! empty( $query->posts[0] ) ) {
			return (int) $query->posts[0];
		}
	}

	return 0;
}

/**
 * Prepare a theme image for upload: downscale very large sources to ~2400px
 * at high JPEG quality so heroes stay sharp without multi‑MB originals.
 *
 * @param string $path Absolute source path.
 * @return array{path:string,name:string,cleanup:bool}|null
 */
function restwell_prepare_theme_image_for_sideload( $path ) {
	$path = (string) $path;
	if ( ! is_readable( $path ) ) {
		return null;
	}

	$base = basename( $path );
	$size = @getimagesize( $path ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
	$w    = is_array( $size ) ? (int) $size[0] : 0;
	$h    = is_array( $size ) ? (int) $size[1] : 0;
	$bytes = (int) filesize( $path );

	$needs_resize = ( $w > 2400 || $h > 2400 || $bytes > 2500000 );
	if ( ! $needs_resize ) {
		return array(
			'path'    => $path,
			'name'    => $base,
			'cleanup' => false,
		);
	}

	$editor = wp_get_image_editor( $path );
	if ( is_wp_error( $editor ) ) {
		return array(
			'path'    => $path,
			'name'    => $base,
			'cleanup' => false,
		);
	}

	$editor->set_quality( 90 );
	$editor->resize( 2400, 2400, false );
	$tmp_name = 'restwell-hero-' . wp_unique_id() . '.jpg';
	$tmp      = trailingslashit( get_temp_dir() ) . $tmp_name;
	$saved    = $editor->save( $tmp, 'image/jpeg' );
	if ( is_wp_error( $saved ) || empty( $saved['path'] ) ) {
		return array(
			'path'    => $path,
			'name'    => $base,
			'cleanup' => false,
		);
	}

	return array(
		'path'    => (string) $saved['path'],
		'name'    => pathinfo( $base, PATHINFO_FILENAME ) . '-hero.jpg',
		'cleanup' => true,
	);
}

/**
 * Sideload a theme image into the Media Library (idempotent).
 *
 * @param string $rel Path relative to assets/images/ (or bare stock basename).
 * @return int Attachment ID or 0.
 */
function restwell_sideload_stock_image( $rel ) {
	$rel = ltrim( str_replace( '\\', '/', (string) $rel ), '/' );
	if ( $rel === '' || false !== strpos( $rel, '..' ) ) {
		return 0;
	}
	if ( false === strpos( $rel, '/' ) ) {
		$rel = 'stock/' . $rel;
	}

	$existing = restwell_find_stock_attachment_id( $rel );
	if ( $existing > 0 ) {
		restwell_maybe_set_attachment_alt_from_theme_map( $existing, $rel );
		return $existing;
	}

	$path = restwell_theme_image_abs_path( $rel );
	if ( $path === '' ) {
		return 0;
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$prepared = restwell_prepare_theme_image_for_sideload( $path );
	if ( ! $prepared ) {
		return 0;
	}

	// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- local theme asset.
	$contents = file_get_contents( $prepared['path'] );
	if ( false === $contents || $contents === '' ) {
		if ( ! empty( $prepared['cleanup'] ) ) {
			@unlink( $prepared['path'] ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
		}
		return 0;
	}

	$upload_name = (string) $prepared['name'];
	$bits        = wp_upload_bits( $upload_name, null, $contents );
	if ( ! empty( $prepared['cleanup'] ) ) {
		@unlink( $prepared['path'] ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
	}

	if ( ! empty( $bits['error'] ) || empty( $bits['file'] ) ) {
		return 0;
	}

	$filetype = wp_check_filetype( $upload_name, null );
	$mime     = ! empty( $filetype['type'] ) ? $filetype['type'] : 'image/jpeg';
	$att_id   = wp_insert_attachment(
		array(
			'post_mime_type' => $mime,
			'post_title'     => sanitize_file_name( pathinfo( $upload_name, PATHINFO_FILENAME ) ),
			'post_content'   => '',
			'post_status'    => 'inherit',
		),
		$bits['file']
	);

	if ( is_wp_error( $att_id ) || ! $att_id ) {
		return 0;
	}

	$att_id = (int) $att_id;
	$meta   = wp_generate_attachment_metadata( $att_id, $bits['file'] );
	if ( is_array( $meta ) ) {
		wp_update_attachment_metadata( $att_id, $meta );
	}
	update_post_meta( $att_id, '_restwell_stock_source', $rel );
	restwell_maybe_set_attachment_alt_from_theme_map( $att_id, $rel );

	return $att_id;
}

/**
 * Resolve page ID for an OG stock map slug.
 *
 * @param string $slug Map key (home, blog, accessibility, …).
 * @return int
 */
function restwell_page_id_for_stock_slug( $slug ) {
	$slug = (string) $slug;
	if ( 'home' === $slug ) {
		return (int) get_option( 'page_on_front', 0 );
	}
	if ( 'blog' === $slug ) {
		$id = (int) get_option( 'page_for_posts', 0 );
		if ( $id > 0 ) {
			return $id;
		}
	}
	if ( 'optional-care' === $slug ) {
		$page = get_page_by_path( 'optional-care', OBJECT, 'page' );
		if ( ! $page ) {
			$page = get_page_by_path( 'care-during-your-stay', OBJECT, 'page' );
		}
		return $page ? (int) $page->ID : 0;
	}

	$page = get_page_by_path( $slug, OBJECT, 'page' );
	return $page ? (int) $page->ID : 0;
}

/**
 * Whether a page’s Featured image is a prior low-res stock webp seed.
 *
 * @param int $post_id Page ID.
 * @return bool
 */
function restwell_page_featured_is_legacy_stock_webp( $post_id ) {
	$thumb = (int) get_post_thumbnail_id( $post_id );
	if ( $thumb < 1 ) {
		return false;
	}
	$source = (string) get_post_meta( $thumb, '_restwell_stock_source', true );
	if ( $source === '' ) {
		return false;
	}
	// Bare basename .webp or stock/*.webp from the first seed pass.
	return (bool) preg_match( '/\.webp$/i', $source );
}

/**
 * Normalise a theme image relative path for stock-source comparison.
 *
 * @param string $rel Path relative to assets/images/, or bare basename.
 * @return string e.g. stock/foo.jpg
 */
function restwell_normalise_stock_rel( $rel ) {
	$rel = ltrim( str_replace( '\\', '/', (string) $rel ), '/' );
	if ( $rel === '' ) {
		return '';
	}
	if ( false === strpos( $rel, '/' ) ) {
		$rel = 'stock/' . $rel;
	}
	return $rel;
}

/**
 * Whether a page’s Featured image already matches the mapped stock source.
 *
 * @param int    $post_id Page ID.
 * @param string $rel     Map path relative to assets/images/.
 * @return bool
 */
function restwell_page_featured_matches_stock_rel( $post_id, $rel ) {
	$thumb = (int) get_post_thumbnail_id( $post_id );
	if ( $thumb < 1 ) {
		return false;
	}
	$target = restwell_normalise_stock_rel( $rel );
	if ( $target === '' ) {
		return false;
	}
	$source = restwell_normalise_stock_rel( (string) get_post_meta( $thumb, '_restwell_stock_source', true ) );
	if ( $source !== '' && $source === $target ) {
		return true;
	}
	// Same attachment already sideloaded for this path.
	$mapped_att = restwell_find_stock_attachment_id( $target );
	return ( $mapped_att > 0 && $mapped_att === $thumb );
}

/**
 * Sideload hero map images and assign Featured/hero/OG.
 *
 * @param bool $force_replace When true, replace Featured when it does not match the map target
 *                            (or is a legacy soft stock webp).
 * @return array{assigned:int,skipped:int,failed:int,replaced:int}
 */
function restwell_seed_page_hero_stock_images( $force_replace = false ) {
	$result = array(
		'assigned'  => 0,
		'skipped'   => 0,
		'failed'    => 0,
		'replaced'  => 0,
	);

	if ( ! function_exists( 'restwell_get_default_og_stock_filename_map' ) ) {
		return $result;
	}

	$map = restwell_get_default_og_stock_filename_map();
	foreach ( $map as $slug => $rel ) {
		$page_id = restwell_page_id_for_stock_slug( $slug );
		if ( $page_id < 1 ) {
			++$result['skipped'];
			continue;
		}

		$att_id = restwell_sideload_stock_image( $rel );
		if ( $att_id < 1 ) {
			++$result['failed'];
			continue;
		}

		$thumb = (int) get_post_thumbnail_id( $page_id );
		$matches = restwell_page_featured_matches_stock_rel( $page_id, $rel );
		$replace = $force_replace && (
			! $matches
			|| restwell_page_featured_is_legacy_stock_webp( $page_id )
		);

		if ( $thumb > 0 && ! $replace ) {
			restwell_sync_page_hero_image_trio( $page_id );
			++$result['skipped'];
			continue;
		}

		if ( $matches && $thumb === $att_id ) {
			restwell_sync_page_hero_image_trio( $page_id );
			++$result['skipped'];
			continue;
		}

		set_post_thumbnail( $page_id, $att_id );
		restwell_sync_page_hero_image_trio( $page_id );
		if ( $thumb > 0 ) {
			++$result['replaced'];
		} else {
			++$result['assigned'];
		}
	}

	return $result;
}
