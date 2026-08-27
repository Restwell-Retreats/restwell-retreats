<?php
/**
 * SEO: title/description text helpers and document title filter.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Access statement PDF URL from CRM settings (empty string if not set).
 *
 * @return string Sanitise with esc_url() when printing in HTML attributes.
 */
function restwell_get_access_statement_url() {
	return (string) get_option( 'restwell_access_statement_url', '' );
}

/**
 * Add configured social profile URLs to a schema.org entity as `sameAs`.
 *
 * @param array<string, mixed> $entity JSON-LD object.
 * @return array<string, mixed>
 */
function restwell_jsonld_with_same_as( array $entity ) {
	if ( function_exists( 'restwell_get_social_same_as_list' ) ) {
		$same = restwell_get_social_same_as_list();
		if ( ! empty( $same ) ) {
			$entity['sameAs'] = $same;
		}
	}
	return $entity;
}

// ---------------------------------------------------------------------------
// 1. Title tag override
// ---------------------------------------------------------------------------

/**
 * Strip legacy branding suffixes from SEO title values.
 *
 * @param string $title Raw title value.
 * @return string
 */
function restwell_sanitize_seo_title_text( $title ) {
	$title = trim( (string) $title );
	if ( $title === '' ) {
		return '';
	}
	$title = (string) preg_replace( '/\s*[|\-–—]\s*from\s+Homely\s+Housing\s*$/i', '', $title );
	// Strip trailing brand so WP / restwell_build_meta_title do not double the site name.
	$title = (string) preg_replace( '/\s*[|\-–—]\s*Restwell(?:\s+Retreats)?\s*$/iu', '', $title );
	return trim( $title );
}

/**
 * Whether a document title already includes the site brand (avoid appending again).
 *
 * @param string $title Title part.
 * @param string $site  Blog name.
 * @return bool
 */
function restwell_title_already_includes_site_brand( $title, $site ) {
	$title = trim( (string) $title );
	$site  = trim( (string) $site );
	if ( $title === '' || $site === '' ) {
		return false;
	}
	if ( substr( $title, -strlen( $site ) ) === $site ) {
		return true;
	}
	// Partial brand in seeds, e.g. "| Restwell" while site is "Restwell Retreats".
	if ( preg_match( '/(?:^|[|\-–—])\s*Restwell(?:\s+Retreats)?\s*$/iu', $title ) ) {
		return true;
	}
	if ( stripos( $title, 'Restwell Retreats' ) !== false ) {
		return true;
	}
	return false;
}

/**
 * Collapse whitespace and trim punctuation for head tags.
 *
 * @param string $text Raw text.
 * @return string
 */
function restwell_normalize_meta_text( $text ) {
	$text = wp_strip_all_tags( (string) $text );
	$text = html_entity_decode( $text, ENT_QUOTES, 'UTF-8' );
	$text = (string) preg_replace( '/\s+/', ' ', $text );
	$text = trim( $text );
	return trim( $text, " \t\n\r\0\x0B,;.-" );
}

/**
 * Trim text to a sensible length without cutting words.
 *
 * @param string $text       Raw text.
 * @param int    $max_length Maximum length.
 * @return string
 */
function restwell_trim_meta_text( $text, $max_length = 160 ) {
	$text       = restwell_normalize_meta_text( $text );
	$max_length = absint( $max_length );
	if ( $max_length < 20 || strlen( $text ) <= $max_length ) {
		return $text;
	}

	$trimmed = substr( $text, 0, $max_length );
	$space   = strrpos( $trimmed, ' ' );
	if ( false !== $space && $space > (int) ( $max_length * 0.6 ) ) {
		$trimmed = substr( $trimmed, 0, $space );
	}

	return trim( $trimmed, " \t\n\r\0\x0B,;.-" );
}

/**
 * Build a concise title in "Primary | Site" format.
 *
 * @param string $primary Primary title phrase.
 * @return string
 */
function restwell_build_meta_title( $primary ) {
	$site    = restwell_normalize_meta_text( get_bloginfo( 'name' ) );
	$primary = restwell_trim_meta_text( $primary, 56 );

	if ( $primary === '' ) {
		return $site;
	}
	if ( $site === '' ) {
		return restwell_trim_meta_text( $primary, 60 );
	}

	$title = $primary . ' | ' . $site;
	if ( strlen( $title ) <= 60 ) {
		return $title;
	}

	$max_primary = max( 20, 60 - strlen( $site ) - 3 );
	return restwell_trim_meta_text( $primary, $max_primary ) . ' | ' . $site;
}

/**
 * Build a request-level fallback title for non-singular views.
 *
 * @return string
 */
function restwell_get_request_level_title_fallback() {
	if ( is_front_page() ) {
		$front_id = (int) get_option( 'page_on_front', 0 );
		if ( $front_id > 0 ) {
			$meta_title = (string) get_post_meta( $front_id, 'meta_title', true );
			if ( $meta_title !== '' ) {
				return restwell_sanitize_seo_title_text( $meta_title );
			}
			$defaults = restwell_get_seo_default_meta_for_post_id( $front_id );
			if ( ! empty( $defaults['meta_title'] ) ) {
				return restwell_sanitize_seo_title_text( $defaults['meta_title'] );
			}
		}
		return restwell_build_meta_title( __( 'Accessible holidays Whitstable', 'restwell-retreats' ) );
	}

	if ( is_home() && ! is_front_page() ) {
		$posts_id = (int) get_option( 'page_for_posts', 0 );
		if ( $posts_id > 0 ) {
			$meta_title = (string) get_post_meta( $posts_id, 'meta_title', true );
			if ( $meta_title !== '' ) {
				return restwell_sanitize_seo_title_text( $meta_title );
			}
			$defaults = restwell_get_seo_default_meta_for_post_id( $posts_id );
			if ( ! empty( $defaults['meta_title'] ) ) {
				return restwell_sanitize_seo_title_text( $defaults['meta_title'] );
			}
			return restwell_build_meta_title( get_the_title( $posts_id ) );
		}
		return restwell_build_meta_title( __( 'Tips, stories and Whitstable updates', 'restwell-retreats' ) );
	}

	if ( is_category() || is_tag() || is_tax() ) {
		$term = get_queried_object();
		if ( $term && isset( $term->name ) ) {
			return restwell_build_meta_title( (string) $term->name );
		}
	}

	if ( is_post_type_archive() ) {
		return restwell_build_meta_title( post_type_archive_title( '', false ) );
	}

	if ( is_author() ) {
		return restwell_build_meta_title( sprintf( __( 'Articles by %s', 'restwell-retreats' ), get_the_author_meta( 'display_name', get_queried_object_id() ) ) );
	}

	if ( is_date() ) {
		return restwell_build_meta_title( get_the_archive_title() );
	}

	if ( is_search() ) {
		return restwell_build_meta_title( sprintf( __( 'Search results for %s', 'restwell-retreats' ), get_search_query() ) );
	}

	return restwell_build_meta_title( get_bloginfo( 'description' ) );
}

/**
 * Allow editors to override the page <title> via the meta_title field.
 *
 * @param array $parts Associative array of title parts.
 * @return array
 */
function restwell_document_title_parts( $parts ) {
	$injected = false;

	if ( is_singular() ) {
		$pid    = get_queried_object_id();
		$custom = (string) get_post_meta( $pid, 'meta_title', true );
		if ( $custom !== '' ) {
			$parts['title'] = restwell_sanitize_seo_title_text( $custom );
			$injected       = true;
		} else {
			$defaults = restwell_get_seo_default_meta_for_post_id( $pid );
			if ( $defaults['meta_title'] !== '' ) {
				$parts['title'] = restwell_sanitize_seo_title_text( $defaults['meta_title'] );
				$injected       = true;
			}
		}
	} elseif ( ! is_404() ) {
		$parts['title'] = restwell_get_request_level_title_fallback();
		$injected       = true;
	}

	if ( $injected ) {
		// Injected titles are self-contained: the tagline must never be appended as well.
		// Drop the site name too when the title already carries the brand.
		unset( $parts['tagline'] );

		$site = isset( $parts['site'] ) ? trim( (string) $parts['site'] ) : '';
		if ( $site !== '' && ! empty( $parts['title'] ) && restwell_title_already_includes_site_brand( $parts['title'], $site ) ) {
			unset( $parts['site'] );
		}
	}

	return $parts;
}
add_filter( 'document_title_parts', 'restwell_document_title_parts' );

// ---------------------------------------------------------------------------
// 1b. Google Search Console verification
// ---------------------------------------------------------------------------

/**
 * Output the Google Search Console verification meta tag when the option is set.
 */
function restwell_output_gsc_verification() {
	$token = (string) get_option( 'restwell_gsc_verification', '' );
	if ( $token === '' ) {
		return;
	}
	echo '<meta name="google-site-verification" content="' . esc_attr( $token ) . '">' . "\n";
}
add_action( 'wp_head', 'restwell_output_gsc_verification', 1 );

// ---------------------------------------------------------------------------
// 1b-alt. Meta description (all public views)
// ---------------------------------------------------------------------------

/**
 * Output <meta name="description"> when a value is available.
 */
