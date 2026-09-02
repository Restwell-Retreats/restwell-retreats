<?php
/**
 * SEO: meta description resolution and head output.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function restwell_output_meta_description_tag() {
	if ( is_404() || is_search() ) {
		return;
	}

	$desc = restwell_get_meta_description_for_request();
	if ( $desc === '' ) {
		return;
	}
	echo '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n";
}
add_action( 'wp_head', 'restwell_output_meta_description_tag', 0 );

/**
 * Resolve meta description for the current request.
 *
 * @return string
 */
function restwell_get_meta_description_for_request() {
	if ( is_singular() && is_page_template( 'page-guest-guide.php' ) ) {
		return '';
	}

	if ( is_singular() ) {
		$pid  = get_queried_object_id();
		$desc = (string) get_post_meta( $pid, 'meta_description', true );
		if ( $desc !== '' ) {
			return restwell_trim_meta_text( $desc, 160 );
		}
		$defaults = restwell_get_seo_default_meta_for_post_id( $pid );
		if ( $defaults['meta_description'] !== '' ) {
			return restwell_trim_meta_text( $defaults['meta_description'], 160 );
		}
		if ( is_singular( 'post' ) ) {
			$excerpt = wp_strip_all_tags( get_the_excerpt( $pid ) );
			if ( $excerpt !== '' ) {
				return restwell_trim_meta_text( $excerpt, 150 ) . '. ' . __( 'Read practical guidance and next steps.', 'restwell-retreats' );
			}
		}

		$content_raw = get_post_field( 'post_content', $pid );
		$content     = $content_raw ? wp_strip_all_tags( (string) $content_raw ) : '';
		$content     = trim( (string) preg_replace( '/\s+/', ' ', $content ) );
		if ( $content !== '' ) {
			return restwell_trim_meta_text( $content, 155 ) . '…';
		}

		$title = get_the_title( $pid );
		if ( $title !== '' ) {
			return restwell_trim_meta_text(
				sprintf(
					/* translators: %s: page or post title */
					__( '%s: practical accessibility and holiday-planning guidance from Restwell Retreats.', 'restwell-retreats' ),
					$title
				),
				160
			);
		}

		return '';
	}

	if ( is_front_page() ) {
		$pid = (int) get_option( 'page_on_front', 0 );
		if ( $pid > 0 ) {
			$desc = (string) get_post_meta( $pid, 'meta_description', true );
			if ( $desc !== '' ) {
				return restwell_trim_meta_text( $desc, 160 );
			}
			$defaults = restwell_get_seo_default_meta_for_post_id( $pid );
			if ( $defaults['meta_description'] !== '' ) {
				return restwell_trim_meta_text( $defaults['meta_description'], 160 );
			}
		}
		return restwell_trim_meta_text( __( 'Bedroom ceiling hoist, profiling bed, and roll-in wet room in a private Whitstable bungalow. Optional CQC-regulated care support. Check availability today.', 'restwell-retreats' ), 160 );
	}

	if ( is_home() && ! is_front_page() ) {
		$posts_id = (int) get_option( 'page_for_posts', 0 );
		if ( $posts_id > 0 ) {
			$desc = (string) get_post_meta( $posts_id, 'meta_description', true );
			if ( $desc !== '' ) {
				return restwell_trim_meta_text( $desc, 160 );
			}
			$defaults = restwell_get_seo_default_meta_for_post_id( $posts_id );
			if ( $defaults['meta_description'] !== '' ) {
				return restwell_trim_meta_text( $defaults['meta_description'], 160 );
			}
		}
		return restwell_trim_meta_text( __( 'Accessible holiday tips, guest stories, what’s on in Whitstable, and practical updates for wheelchair users, carers and anyone planning a respite break.', 'restwell-retreats' ), 160 );
	}

	if ( is_category() || is_tag() || is_tax() ) {
		$term = get_queried_object();
		if ( $term && ! is_wp_error( $term ) ) {
			$td = term_description( $term );
			if ( $td ) {
				return restwell_trim_meta_text( $td, 150 ) . '. ' . __( 'Browse the latest posts in this topic.', 'restwell-retreats' );
			}
			if ( ! empty( $term->name ) ) {
				return restwell_trim_meta_text(
					sprintf(
						/* translators: %s: term name */
						__( 'Browse %s articles from Restwell Retreats with practical accessibility, care-planning, and Kent travel guidance.', 'restwell-retreats' ),
						(string) $term->name
					),
					160
				);
			}
		}
	}

	if ( is_post_type_archive() ) {
		return restwell_trim_meta_text(
			sprintf(
				/* translators: %s: archive title */
				__( 'Explore %s from Restwell Retreats, with practical, accessibility-first information to help you plan with confidence.', 'restwell-retreats' ),
				post_type_archive_title( '', false )
			),
			160
		);
	}

	if ( is_author() ) {
		return restwell_trim_meta_text( __( 'Read practical accessibility and holiday-planning insights from Restwell Retreats.', 'restwell-retreats' ), 160 );
	}

	if ( is_date() ) {
		return restwell_trim_meta_text( __( 'Archive of Restwell Retreats articles and updates for this period.', 'restwell-retreats' ), 160 );
	}

	return restwell_trim_meta_text( (string) get_bloginfo( 'description' ), 160 );
}
