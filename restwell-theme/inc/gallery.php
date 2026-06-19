<?php
/**
 * Reusable accessible photo gallery (Media Library attachment IDs only).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Parse gallery attachment IDs from meta storage (comma-separated string or array).
 *
 * @param mixed $raw Raw meta value.
 * @return array<int, int>
 */
function restwell_parse_gallery_ids( $raw ) {
	if ( is_array( $raw ) ) {
		$parts = $raw;
	} else {
		$raw   = trim( (string) $raw );
		$parts = $raw === '' ? array() : preg_split( '/\s*,\s*/', $raw );
	}

	$ids = array();
	foreach ( $parts as $part ) {
		$id = absint( $part );
		if ( $id > 0 && wp_attachment_is_image( $id ) ) {
			$ids[] = $id;
		}
	}

	return array_values( array_unique( $ids ) );
}

/**
 * Legacy property gallery slots (prop_gallery_1…3_image_id) for backward compatibility.
 *
 * @param int $post_id Property page ID.
 * @return array<int, int>
 */
function restwell_get_legacy_property_gallery_ids( $post_id ) {
	$post_id = (int) $post_id;
	if ( $post_id <= 0 ) {
		return array();
	}

	$legacy_keys = array(
		'prop_gallery_1_image_id',
		'prop_gallery_2_image_id',
		'prop_gallery_3_image_id',
	);

	$ids = array();
	foreach ( $legacy_keys as $key ) {
		$id = absint( get_post_meta( $post_id, $key, true ) );
		if ( $id > 0 && wp_attachment_is_image( $id ) ) {
			$ids[] = $id;
		}
	}

	return $ids;
}

/**
 * Gallery IDs for a page meta key, with optional legacy merge when primary meta is empty.
 *
 * @param int    $post_id     Page ID.
 * @param string $meta_key    Primary gallery meta key.
 * @param array  $legacy_keys Optional legacy single-image meta keys.
 * @return array<int, int>
 */
function restwell_get_page_gallery_ids( $post_id, $meta_key, $legacy_keys = array() ) {
	$post_id = (int) $post_id;
	if ( $post_id <= 0 ) {
		return array();
	}

	$ids = restwell_parse_gallery_ids( get_post_meta( $post_id, $meta_key, true ) );

	if ( empty( $ids ) && ! empty( $legacy_keys ) ) {
		foreach ( $legacy_keys as $key ) {
			$id = absint( get_post_meta( $post_id, $key, true ) );
			if ( $id > 0 && wp_attachment_is_image( $id ) ) {
				$ids[] = $id;
			}
		}
		$ids = array_values( array_unique( $ids ) );
	}

	return $ids;
}

/**
 * Property page gallery IDs (full room-by-room set).
 *
 * @param int $post_id Property page ID; 0 uses the-property page.
 * @return array<int, int>
 */
function restwell_get_property_gallery_ids( $post_id = 0 ) {
	$post_id = (int) $post_id;
	if ( $post_id <= 0 ) {
		$page = get_page_by_path( 'the-property', OBJECT, 'page' );
		$post_id = $page ? (int) $page->ID : 0;
	}
	if ( $post_id <= 0 ) {
		return array();
	}

	return restwell_get_page_gallery_ids(
		$post_id,
		'prop_gallery_image_ids',
		array(
			'prop_gallery_1_image_id',
			'prop_gallery_2_image_id',
			'prop_gallery_3_image_id',
		)
	);
}

/**
 * Accessibility page feature gallery IDs.
 *
 * @param int $post_id Accessibility page ID; 0 uses current queried object.
 * @return array<int, int>
 */
function restwell_get_accessibility_gallery_ids( $post_id = 0 ) {
	$post_id = (int) $post_id;
	if ( $post_id <= 0 && is_singular( 'page' ) ) {
		$post_id = (int) get_queried_object_id();
	}
	if ( $post_id <= 0 ) {
		$page = get_page_by_path( 'accessibility', OBJECT, 'page' );
		$post_id = $page ? (int) $page->ID : 0;
	}
	if ( $post_id <= 0 ) {
		return array();
	}

	return restwell_get_page_gallery_ids( $post_id, 'acc_gallery_image_ids' );
}

/**
 * Whether the attachment is missing dedicated alt text in the Media Library.
 *
 * @param int $attachment_id Attachment ID.
 * @return bool
 */
function restwell_attachment_alt_is_missing( $attachment_id ) {
	$attachment_id = (int) $attachment_id;
	if ( $attachment_id <= 0 ) {
		return true;
	}
	return trim( (string) get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) === '';
}

/**
 * Alt text for front-end output: attachment alt meta, then title. Never invented.
 *
 * @param int $attachment_id Attachment ID.
 * @return string
 */
function restwell_get_gallery_attachment_alt( $attachment_id ) {
	$attachment_id = (int) $attachment_id;
	if ( $attachment_id <= 0 ) {
		return '';
	}

	$alt = trim( (string) get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) );
	if ( $alt !== '' ) {
		return $alt;
	}

	return trim( (string) get_the_title( $attachment_id ) );
}

/**
 * Caption for gallery slides: Media Library caption, else alt text.
 *
 * @param int $attachment_id Attachment ID.
 * @return string
 */
function restwell_get_gallery_attachment_caption( $attachment_id ) {
	$attachment_id = (int) $attachment_id;
	if ( $attachment_id <= 0 ) {
		return '';
	}

	$post = get_post( $attachment_id );
	if ( $post instanceof WP_Post ) {
		$caption = trim( (string) $post->post_excerpt );
		if ( $caption !== '' ) {
			return $caption;
		}
	}

	return restwell_get_gallery_attachment_alt( $attachment_id );
}

/**
 * Resolve a room-tour image: explicit meta ID, else gallery slot by index.
 *
 * @param int           $meta_image_id   Optional attachment ID from page meta.
 * @param array<int,int> $gallery_ids    Property gallery IDs.
 * @param int           $fallback_index  Zero-based gallery index.
 * @return int Attachment ID or 0.
 */
function restwell_resolve_property_tour_image_id( $meta_image_id, $gallery_ids, $fallback_index ) {
	$meta_image_id = (int) $meta_image_id;
	if ( $meta_image_id > 0 && wp_attachment_is_image( $meta_image_id ) ) {
		return $meta_image_id;
	}

	$gallery_ids = restwell_parse_gallery_ids( $gallery_ids );
	$fallback_index = (int) $fallback_index;
	if ( isset( $gallery_ids[ $fallback_index ] ) ) {
		return (int) $gallery_ids[ $fallback_index ];
	}

	return 0;
}

/**
 * Room-by-room tour blocks for the property page (Job 10 migration target).
 *
 * @param int $post_id Property page ID.
 * @return array<int, array{heading:string,body:string,image_id:int}>
 */
function restwell_get_property_room_tour_sections( $post_id = 0 ) {
	$post_id = (int) $post_id;
	if ( $post_id <= 0 ) {
		$post_id = (int) get_queried_object_id();
	}

	$defaults = restwell_get_property_page_defaults();
	$m        = static function ( $key ) use ( $post_id, $defaults ) {
		return restwell_post_meta_or_default( $post_id, $key, $defaults );
	};

	$gallery_ids = restwell_get_property_gallery_ids( $post_id );

	$sections = array(
		array(
			'heading'   => (string) $m( 'prop_living_heading' ),
			'body'      => (string) $m( 'prop_living_body' ),
			'image_id'  => restwell_resolve_property_tour_image_id( (int) $m( 'prop_tour_living_image_id' ), $gallery_ids, 0 ),
		),
		array(
			'heading'   => (string) $m( 'prop_bedrooms_section_heading' ),
			'body'      => (string) $m( 'prop_bedrooms_section_body' ),
			'image_id'  => restwell_resolve_property_tour_image_id( (int) $m( 'prop_tour_bedroom_image_id' ), $gallery_ids, 1 ),
		),
		array(
			'heading'   => (string) $m( 'prop_wetroom_heading' ),
			'body'      => (string) $m( 'prop_wetroom_body' ),
			'image_id'  => restwell_resolve_property_tour_image_id( (int) $m( 'prop_tour_wetroom_image_id' ), $gallery_ids, 2 ),
		),
		array(
			'heading'   => (string) $m( 'prop_garden_heading' ),
			'body'      => (string) $m( 'prop_garden_body' ),
			'image_id'  => restwell_resolve_property_tour_image_id( (int) $m( 'prop_tour_garden_image_id' ), $gallery_ids, 3 ),
		),
	);

	return array_values(
		array_filter(
			$sections,
			static function ( $section ) {
				return trim( (string) ( $section['heading'] ?? '' ) ) !== '' || trim( (string) ( $section['body'] ?? '' ) ) !== '';
			}
		)
	);
}

/**
 * Editor-only notice for attachments missing alt text.
 *
 * @param array<int, int> $image_ids Attachment IDs.
 */
function restwell_render_gallery_admin_alt_notice( $image_ids ) {
	if ( empty( $image_ids ) || ! is_admin() ) {
		return;
	}

	$missing = array();
	foreach ( $image_ids as $id ) {
		if ( restwell_attachment_alt_is_missing( $id ) ) {
			$missing[] = (int) $id;
		}
	}

	if ( empty( $missing ) ) {
		return;
	}

	echo '<p class="restwell-gallery-alt-notice description" style="margin-top:0.5rem;color:#b32d2e;">';
	echo esc_html(
		sprintf(
			/* translators: %s: comma-separated attachment IDs */
			__( 'Confirm in WP: alt text is missing for attachment ID(s) %s. Add descriptive alt text in the Media Library before publishing.', 'restwell-retreats' ),
			implode( ', ', $missing )
		)
	);
	echo '</p>';
}

/**
 * Build ImageGallery / ImageObject JSON-LD for images actually shown.
 *
 * @param array<int, int>        $image_ids Attachment IDs.
 * @param array<string, mixed>   $args      name, url (page URL).
 * @return array<string, mixed>|null
 */
function restwell_build_gallery_jsonld( $image_ids, $args = array() ) {
	$image_ids = restwell_parse_gallery_ids( $image_ids );
	if ( empty( $image_ids ) ) {
		return null;
	}

	$defaults = array(
		'name'  => '',
		'url'   => '',
		'limit' => 0,
	);
	$args     = wp_parse_args( $args, $defaults );

	if ( ! empty( $args['limit'] ) ) {
		$image_ids = array_slice( $image_ids, 0, (int) $args['limit'] );
	}

	$items = array();
	foreach ( $image_ids as $id ) {
		$img_url = wp_get_attachment_image_url( $id, 'full' );
		if ( ! $img_url ) {
			continue;
		}
		$meta = wp_get_attachment_metadata( $id );
		$item = array(
			'@type' => 'ImageObject',
			'url'   => $img_url,
			'name'  => restwell_get_gallery_attachment_alt( $id ),
		);
		if ( is_array( $meta ) && ! empty( $meta['width'] ) && ! empty( $meta['height'] ) ) {
			$item['width']  = (int) $meta['width'];
			$item['height'] = (int) $meta['height'];
		}
		$items[] = $item;
	}

	if ( empty( $items ) ) {
		return null;
	}

	$schema = array(
		'@context'      => 'https://schema.org',
		'@type'         => 'ImageGallery',
		'associatedMedia' => $items,
	);

	if ( $args['name'] !== '' ) {
		$schema['name'] = (string) $args['name'];
	}
	if ( $args['url'] !== '' ) {
		$schema['url'] = (string) $args['url'];
	}

	return $schema;
}

/**
 * Output gallery JSON-LD when schema is non-empty.
 *
 * @param array<int, int>      $image_ids Attachment IDs.
 * @param array<string, mixed> $args      Passed to restwell_build_gallery_jsonld().
 */
function restwell_output_gallery_jsonld( $image_ids, $args = array() ) {
	if ( ! function_exists( 'restwell_print_jsonld' ) ) {
		return;
	}
	$schema = restwell_build_gallery_jsonld( $image_ids, $args );
	if ( ! empty( $schema ) ) {
		restwell_print_jsonld( $schema );
	}
}

/**
 * Render a single-slide accessible photo carousel with caption and counter.
 *
 * @param array<int, int>      $image_ids Attachment IDs.
 * @param array<string, mixed> $args      Same keys as restwell_render_gallery().
 */
function restwell_render_gallery_carousel( $image_ids, $args = array() ) {
	$image_ids = restwell_parse_gallery_ids( $image_ids );
	if ( empty( $image_ids ) ) {
		return;
	}

	$defaults = array(
		'id'                  => '',
		'class'               => '',
		'image_size'          => 'large',
		'sizes'               => '(max-width: 1023px) 100vw, min(72rem, 90vw)',
		'lightbox'            => true,
		'aria_label'          => __( 'Property photo gallery', 'restwell-retreats' ),
		'all_grid_id'         => 'property-gallery-all',
		'all_grid_aria_label' => __( 'All property photos', 'restwell-retreats' ),
	);
	$args = wp_parse_args( $args, $defaults );

	$wrapper_id  = trim( (string) $args['id'] );
	$gallery_uid = $wrapper_id !== '' ? $wrapper_id : 'restwell-gallery-' . wp_unique_id();
	$total       = count( $image_ids );
	$classes     = trim( 'restwell-gallery restwell-gallery--carousel ' . (string) $args['class'] );
	$lightbox    = ! empty( $args['lightbox'] );

	echo '<div';
	if ( $wrapper_id !== '' ) {
		echo ' id="' . esc_attr( $wrapper_id ) . '"';
	}
	echo ' class="' . esc_attr( $classes ) . '"';
	echo ' data-restwell-carousel';
	if ( $lightbox ) {
		echo ' data-restwell-gallery';
	}
	echo ' role="group" aria-roledescription="carousel" aria-label="' . esc_attr( (string) $args['aria_label'] ) . '">';

	echo '<div class="restwell-carousel__viewport">';
	echo '<div class="restwell-carousel__track" data-carousel-track>';

	foreach ( $image_ids as $index => $attachment_id ) {
		$full_url = wp_get_attachment_image_url( $attachment_id, 'full' );
		if ( ! $full_url ) {
			continue;
		}

		$alt     = restwell_get_gallery_attachment_alt( $attachment_id );
		$caption = restwell_get_gallery_attachment_caption( $attachment_id );
		$meta    = wp_get_attachment_metadata( $attachment_id );
		$width   = is_array( $meta ) && ! empty( $meta['width'] ) ? (int) $meta['width'] : 1600;
		$height  = is_array( $meta ) && ! empty( $meta['height'] ) ? (int) $meta['height'] : 1200;
		$is_first = 0 === $index;
		$loading  = $is_first ? 'eager' : 'lazy';
		$hidden   = $is_first ? '' : ' hidden';

		echo '<figure class="restwell-carousel__slide' . esc_attr( $hidden ) . '" data-carousel-slide="' . esc_attr( (string) $index ) . '" role="group" aria-roledescription="slide" aria-label="' . esc_attr( sprintf( /* translators: 1: current slide number, 2: total slides */ __( 'Slide %1$d of %2$d', 'restwell-retreats' ), $index + 1, $total ) ) . '">';

		if ( $lightbox ) {
			echo '<button type="button" class="restwell-carousel__media-btn" data-restwell-gallery-open data-gallery-id="' . esc_attr( $gallery_uid ) . '" data-gallery-index="' . esc_attr( (string) $index ) . '" aria-label="' . esc_attr( sprintf( /* translators: %s: image description */ __( 'View full size: %s', 'restwell-retreats' ), $alt ) ) . '">';
		} else {
			echo '<div class="restwell-carousel__media-btn restwell-carousel__media-btn--static">';
		}

		$img_html = wp_get_attachment_image(
			$attachment_id,
			(string) $args['image_size'],
			false,
			array(
				'class'    => 'restwell-carousel__img',
				'alt'      => $alt,
				'loading'  => $loading,
				'decoding' => 'async',
				'sizes'    => (string) $args['sizes'],
				'width'    => $width,
				'height'   => $height,
			)
		);
		if ( $img_html ) {
			echo $img_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wp_get_attachment_image() is escaped.
		}

		echo $lightbox ? '</button>' : '</div>';

		if ( $caption !== '' ) {
			echo '<figcaption class="restwell-carousel__caption">' . esc_html( $caption ) . '</figcaption>';
		}

		echo '</figure>';
	}

	echo '</div></div>';

	echo '<div class="restwell-carousel__controls">';
	echo '<button type="button" class="restwell-carousel__btn restwell-carousel__btn--prev" data-carousel-prev aria-label="' . esc_attr__( 'Previous photo', 'restwell-retreats' ) . '">';
	echo '<i class="ph-bold ph-caret-left" aria-hidden="true"></i>';
	echo '</button>';
	echo '<p class="restwell-carousel__status" data-carousel-status aria-live="polite" aria-atomic="true">';
	echo esc_html( '1 / ' . $total );
	echo '</p>';
	echo '<button type="button" class="restwell-carousel__btn restwell-carousel__btn--next" data-carousel-next aria-label="' . esc_attr__( 'Next photo', 'restwell-retreats' ) . '">';
	echo '<i class="ph-bold ph-caret-right" aria-hidden="true"></i>';
	echo '</button>';
	echo '</div>';

	if ( $lightbox ) {
		$slides = array();
		foreach ( $image_ids as $attachment_id ) {
			$full_url = wp_get_attachment_image_url( $attachment_id, 'full' );
			if ( ! $full_url ) {
				continue;
			}
			$slides[] = array(
				'url' => $full_url,
				'alt' => restwell_get_gallery_attachment_caption( $attachment_id ),
			);
		}
		if ( ! empty( $slides ) ) {
			echo '<script type="application/json" class="restwell-gallery__data" data-gallery-id="' . esc_attr( $gallery_uid ) . '">';
			echo wp_json_encode( $slides, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
			echo '</script>';
		}
	}

	$all_grid_id = trim( (string) ( $args['all_grid_id'] ?? 'property-gallery-all' ) );
	if ( $all_grid_id === '' ) {
		$all_grid_id = 'property-gallery-all';
	}

	printf(
		'<p class="restwell-carousel__view-all"><a href="#%1$s" class="text-[var(--deep-teal)] font-medium underline underline-offset-2 hover:no-underline focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--deep-teal)] rounded-sm">%2$s</a></p>',
		esc_attr( $all_grid_id ),
		esc_html(
			sprintf(
				/* translators: %d: number of photos */
				_n( 'View all %d photo', 'View all %d photos', $total, 'restwell-retreats' ),
				$total
			)
		)
	);

	echo '<div id="' . esc_attr( $all_grid_id ) . '" class="restwell-gallery-all mt-10 md:mt-12">';
	echo '<h3 class="sr-only">' . esc_html( (string) ( $args['all_grid_aria_label'] ?? __( 'All property photos', 'restwell-retreats' ) ) ) . '</h3>';
	restwell_render_gallery(
		$image_ids,
		array(
			'layout'     => 'grid',
			'lightbox'   => $lightbox,
			'aria_label' => (string) ( $args['all_grid_aria_label'] ?? __( 'All property photos', 'restwell-retreats' ) ),
			'sizes'      => (string) $args['sizes'],
			'class'      => 'restwell-gallery--all-grid',
		)
	);
	echo '</div>';

	echo '</div>';
}

/**
 * Render a responsive photo gallery grid with progressive lightbox enhancement.
 *
 * @param array<int, int>|string $image_ids Attachment IDs or comma-separated string.
 * @param array<string, mixed>   $args {
 *     @type string $id          Wrapper element ID.
 *     @type string $class       Extra wrapper classes.
 *     @type string $layout      grid|teaser|carousel.
 *     @type int    $limit       Max images to show (0 = all).
 *     @type string $image_size  WordPress image size slug.
 *     @type string $sizes       Responsive sizes attribute.
 *     @type bool   $lightbox    Enable lightbox data attributes (default true).
 *     @type string $link_url    When set (teaser), each thumb links here instead of opening lightbox.
 *     @type string $aria_label  Accessible name for the gallery list.
 * }
 */
function restwell_render_gallery( $image_ids, $args = array() ) {
	$image_ids = restwell_parse_gallery_ids( $image_ids );
	if ( empty( $image_ids ) ) {
		return;
	}

	$defaults = array(
		'id'                 => '',
		'class'              => '',
		'layout'             => 'grid',
		'limit'              => 0,
		'image_size'         => 'large',
		'sizes'              => '(max-width: 639px) 100vw, (max-width: 1023px) 50vw, 33vw',
		'lightbox'           => true,
		'link_url'           => '',
		'aria_label'         => __( 'Property photo gallery', 'restwell-retreats' ),
		'carousel_label'     => __( 'Property photo carousel', 'restwell-retreats' ),
		'all_grid_id'        => 'property-gallery-all',
		'all_grid_aria_label' => __( 'All property photos', 'restwell-retreats' ),
	);
	$args = wp_parse_args( $args, $defaults );

	if ( ! empty( $args['limit'] ) ) {
		$image_ids = array_slice( $image_ids, 0, (int) $args['limit'] );
	}
	if ( empty( $image_ids ) ) {
		return;
	}

	if ( 'carousel' === $args['layout'] ) {
		restwell_render_gallery_carousel( $image_ids, $args );
		return;
	}

	$layout_class = 'restwell-gallery--grid';
	if ( 'teaser' === $args['layout'] ) {
		$layout_class = 'restwell-gallery--teaser';
		if ( '(max-width: 639px) 100vw, (max-width: 1023px) 50vw, 33vw' === $args['sizes'] ) {
			$args['sizes'] = '(max-width: 639px) 45vw, (max-width: 1023px) 30vw, 16vw';
		}
	}

	$wrapper_id = trim( (string) $args['id'] );
	$classes    = trim( 'restwell-gallery ' . $layout_class . ' ' . (string) $args['class'] );
	$lightbox   = ! empty( $args['lightbox'] ) && $args['link_url'] === '';
	$link_url   = $args['link_url'] !== '' ? esc_url( $args['link_url'] ) : '';

	$gallery_uid = $wrapper_id !== '' ? $wrapper_id : 'restwell-gallery-' . wp_unique_id();

	echo '<div';
	if ( $wrapper_id !== '' ) {
		echo ' id="' . esc_attr( $wrapper_id ) . '"';
	}
	echo ' class="' . esc_attr( $classes ) . '"';
	if ( $lightbox ) {
		echo ' data-restwell-gallery';
	}
	echo '>';

	echo '<ul class="restwell-gallery__list" role="list" aria-label="' . esc_attr( (string) $args['aria_label'] ) . '">';

	foreach ( $image_ids as $index => $attachment_id ) {
		$full_url = wp_get_attachment_image_url( $attachment_id, 'full' );
		if ( ! $full_url ) {
			continue;
		}

		$alt = restwell_get_gallery_attachment_alt( $attachment_id );

		echo '<li class="restwell-gallery__item">';

		if ( $link_url !== '' ) {
			echo '<a class="restwell-gallery__link restwell-gallery__link--external" href="' . esc_url( $link_url ) . '">';
		} else {
			echo '<a class="restwell-gallery__link" href="' . esc_url( $full_url ) . '"';
			if ( $lightbox ) {
				echo ' data-restwell-gallery-open';
				echo ' data-gallery-id="' . esc_attr( $gallery_uid ) . '"';
				echo ' data-gallery-index="' . esc_attr( (string) $index ) . '"';
			}
			echo '>';
		}

		$img_html = wp_get_attachment_image(
			$attachment_id,
			(string) $args['image_size'],
			false,
			array(
				'class'    => 'restwell-gallery__img',
				'alt'      => $alt,
				'loading'  => 'lazy',
				'decoding' => 'async',
				'sizes'    => (string) $args['sizes'],
			)
		);
		if ( $img_html ) {
			echo $img_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wp_get_attachment_image() is escaped.
		}

		echo '</a>';
		echo '</li>';
	}

	echo '</ul>';

	if ( $lightbox ) {
		$slides = array();
		foreach ( $image_ids as $attachment_id ) {
			$full_url = wp_get_attachment_image_url( $attachment_id, 'full' );
			if ( ! $full_url ) {
				continue;
			}
			$slides[] = array(
				'url' => $full_url,
				'alt' => restwell_get_gallery_attachment_alt( $attachment_id ),
			);
		}

		if ( ! empty( $slides ) ) {
			echo '<script type="application/json" class="restwell-gallery__data" data-gallery-id="' . esc_attr( $gallery_uid ) . '">';
			echo wp_json_encode( $slides, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
			echo '</script>';
		}
	}

	echo '</div>';
}
