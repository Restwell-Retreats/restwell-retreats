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
 * Schema.org name for Restwell entities. Never use get_bloginfo('name') here —
 * WP site title can be a short lockup that is wrong for LodgingBusiness.
 *
 * @return string
 */
function restwell_get_schema_brand_name() {
	return 'Restwell Retreats';
}

/**
 * Public phone as shown in templates (spaces allowed).
 *
 * @return string
 */
function restwell_get_public_phone_number() {
	$phone = trim( (string) get_option( 'restwell_phone_number', '' ) );
	return '' !== $phone ? $phone : '01622 809881';
}

/**
 * Public phone as digits only (schema telephone / tel: href).
 *
 * @return string
 */
function restwell_get_public_phone_tel() {
	$digits = preg_replace( '/\D+/', '', restwell_get_public_phone_number() );
	return ( is_string( $digits ) && '' !== $digits ) ? $digits : '01622809881';
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
	// WP site title may be lowercase ("restwell") while the SEO title uses "Restwell".
	if ( 0 === strcasecmp( substr( $title, -strlen( $site ) ), $site ) ) {
		return true;
	}
	// Brand anywhere in the title is enough (e.g. "Ask us anything about a stay at Restwell").
	if ( false !== stripos( $title, 'Restwell' ) ) {
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
	// Keep a closing full stop: a description that ends mid-sentence without one reads as cut.
	return trim( $text, " \t\n\r\0\x0B,;-" );
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
	// Count characters, not bytes: curly quotes and £ are multibyte.
	if ( $max_length < 20 || mb_strlen( $text, 'UTF-8' ) <= $max_length ) {
		return $text;
	}

	$window = mb_substr( $text, 0, $max_length, 'UTF-8' );
	// Multibyte-safe edge trim (trim() works on bytes and would split dashes).
	$edge = static function ( $s ) {
		return (string) preg_replace( '/^[\s,;:.|–—-]+|[\s,;:|–—-]+$|(?<!\.)\.$/u', '', $s );
	};

	// 1. End on the last whole sentence, if one fills at least half the space.
	$min_sentence = (int) floor( $max_length * 0.5 );
	if ( preg_match( '/^(.{' . $min_sentence . ',}[.!?])\s/us', $window . ' ', $m ) ) {
		return $m[1];
	}

	// 2. Otherwise end on a clause or title separator (comma, colon, semicolon, dash, pipe).
	$min_clause = (int) floor( $max_length * 0.6 );
	if ( preg_match( '/^(.{' . $min_clause . ',}?)(?:[,;:]|\s[|–—-])\s(?!.*(?:[,;:]|\s[|–—-])\s)/us', $window, $m ) ) {
		// Descriptions close the clause as a sentence; titles stay unpunctuated.
		return $edge( $m[1] ) . ( $max_length >= 100 ? '.' : '' );
	}

	// 3. Last resort: whole words, no dangling connective, and an ellipsis so it reads as cut.
	$space   = mb_strrpos( $window, ' ', 0, 'UTF-8' );
	$trimmed = false !== $space ? mb_substr( $window, 0, $space, 'UTF-8' ) : $window;
	$trimmed = (string) preg_replace( '/(?:\s+(?:and|or|but|the|a|an|with|of|to|for|in|on|at|by|from|as|is|it’s|its|our|your|we|you|that))+$/iu', '', $edge( $trimmed ) );

	return $edge( $trimmed ) . '…';
}

/**
 * Build a concise title in "Primary | Site" format.
 *
 * @param string $primary Primary title phrase.
 * @return string
 */
function restwell_build_meta_title( $primary ) {
	$site    = restwell_get_schema_brand_name();
	$primary = restwell_trim_meta_text( $primary, 56 );

	if ( $primary === '' ) {
		return $site;
	}
	if ( restwell_title_already_includes_site_brand( $primary, $site ) ) {
		return restwell_trim_meta_text( $primary, 60 );
	}

	$title = $primary . ' | ' . $site;
	if ( mb_strlen( $title, 'UTF-8' ) <= 60 ) {
		return $title;
	}

	$max_primary = max( 20, 60 - mb_strlen( $site, 'UTF-8' ) - 3 );
	return restwell_trim_meta_text( $primary, $max_primary ) . ' | ' . $site;
}

/**
 * Build a request-level fallback title for non-singular views.
 *
 * @return string
 */
function restwell_get_request_level_title_fallback() {
	if ( is_404() ) {
		return restwell_build_meta_title( __( 'Page not found', 'restwell-retreats' ) );
	}

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
		return restwell_build_meta_title(
			sprintf(
				/* translators: %s: author display name */
				__( 'Articles by %s', 'restwell-retreats' ),
				get_the_author_meta( 'display_name', get_queried_object_id() )
			)
		);
	}

	if ( is_date() ) {
		return restwell_build_meta_title( get_the_archive_title() );
	}

	if ( is_search() ) {
		return restwell_build_meta_title(
			sprintf(
				/* translators: %s: search query */
				__( 'Search results for %s', 'restwell-retreats' ),
				get_search_query()
			)
		);
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
	} else {
		$parts['title'] = restwell_get_request_level_title_fallback();
		$injected       = true;
	}

	if ( $injected ) {
		// Custom SEO titles and request-level fallbacks are self-contained.
		unset( $parts['tagline'], $parts['site'] );
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
