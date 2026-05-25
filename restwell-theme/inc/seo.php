<?php
/**
 * SEO: title override, OG/Twitter Card meta tags, and JSON-LD structured data.
 *
 * All structured data is injected via wp_head hooks so no template files
 * need modifying for JSON-LD. Output order:
 *   priority 5  - OG + Twitter Card meta tags
 *   priority 10 - JSON-LD blocks
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
	return trim( $title );
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
		return restwell_build_meta_title( __( 'Accessible holidays in Whitstable', 'restwell-retreats' ) );
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
		return restwell_build_meta_title( __( 'Accessible travel blog', 'restwell-retreats' ) );
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
	if ( is_singular() ) {
		$pid    = get_queried_object_id();
		$custom = (string) get_post_meta( $pid, 'meta_title', true );
		if ( $custom !== '' ) {
			$parts['title'] = restwell_sanitize_seo_title_text( $custom );
		} else {
			$defaults = restwell_get_seo_default_meta_for_post_id( $pid );
			if ( $defaults['meta_title'] !== '' ) {
				$parts['title'] = restwell_sanitize_seo_title_text( $defaults['meta_title'] );
			}
		}
		// When title already ends with the blog name (e.g. "… | Restwell Retreats"), avoid WP appending site again.
		$site = isset( $parts['site'] ) ? trim( (string) $parts['site'] ) : '';
		if ( $site !== '' && ! empty( $parts['title'] ) ) {
			$t = trim( (string) $parts['title'] );
			$len = strlen( $site );
			if ( $len > 0 && strlen( $t ) >= $len && substr( $t, -$len ) === $site ) {
				unset( $parts['site'], $parts['tagline'] );
			}
		}
	} elseif ( ! is_404() ) {
		$parts['title'] = restwell_get_request_level_title_fallback();
		// restwell_build_meta_title() already appends " | Site Name"; prevent WP adding it again.
		$site = isset( $parts['site'] ) ? trim( (string) $parts['site'] ) : '';
		if ( $site !== '' && ! empty( $parts['title'] ) ) {
			$t   = trim( (string) $parts['title'] );
			$len = strlen( $site );
			if ( $len > 0 && strlen( $t ) >= $len && substr( $t, -$len ) === $site ) {
				unset( $parts['site'], $parts['tagline'] );
			}
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
					__( '%s — practical accessibility and holiday-planning guidance from Restwell Retreats.', 'restwell-retreats' ),
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
		return restwell_trim_meta_text( __( 'Accessible travel guides, Kent coast tips, and funding advice for disabled guests, carers, and families. Explore the latest articles.', 'restwell-retreats' ), 160 );
	}

	if ( is_category() || is_tag() || is_tax() ) {
		$term = get_queried_object();
		if ( $term && ! is_wp_error( $term ) ) {
			$td = term_description( $term, $term->taxonomy );
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

// ---------------------------------------------------------------------------
// 1c. Robots meta (noindex) + canonical URL
// ---------------------------------------------------------------------------

/**
 * Compute canonical URL for the current request.
 *
 * @return string Empty if no canonical should be output (e.g. 404).
 */
function restwell_get_canonical_url_for_request() {
	if ( is_404() || is_search() ) {
		return '';
	}

	if ( is_singular() ) {
		$post = get_queried_object();
		if ( ! $post instanceof WP_Post ) {
			return '';
		}
		$custom = (string) get_post_meta( $post->ID, 'meta_canonical', true );
		if ( $custom !== '' ) {
			return esc_url( $custom );
		}
		if ( function_exists( 'wp_get_canonical_url' ) ) {
			$core = wp_get_canonical_url( $post );
			if ( $core ) {
				return $core;
			}
		}
		return get_permalink( $post );
	}

	if ( is_front_page() ) {
		return home_url( '/' );
	}

	if ( is_home() && ! is_front_page() ) {
		$posts_page = (int) get_option( 'page_for_posts' );
		if ( ! $posts_page ) {
			return home_url( '/' );
		}
		global $wp_query;
		$paged_home = max( 1, (int) $wp_query->get( 'paged' ), (int) $wp_query->get( 'page' ) );
		if ( $paged_home > 1 ) {
			return get_pagenum_link( $paged_home, false );
		}
		return get_permalink( $posts_page );
	}

	global $wp_query;
	$paged = max( 1, (int) $wp_query->get( 'paged' ), (int) $wp_query->get( 'page' ) );

	if ( is_category() || is_tag() || is_tax() ) {
		$term = get_queried_object();
		if ( ! $term || is_wp_error( get_term_link( $term ) ) ) {
			return '';
		}
		$link = get_term_link( $term );
		if ( is_wp_error( $link ) ) {
			return '';
		}
		if ( $paged > 1 ) {
			return get_pagenum_link( $paged, false );
		}
		return $link;
	}

	if ( is_post_type_archive() ) {
		$pt = get_query_var( 'post_type' );
		if ( is_array( $pt ) ) {
			$pt = reset( $pt );
		}
		$link = $pt ? get_post_type_archive_link( $pt ) : '';
		if ( ! $link ) {
			return '';
		}
		if ( $paged > 1 ) {
			return get_pagenum_link( $paged, false );
		}
		return $link;
	}

	if ( is_author() ) {
		$link = get_author_posts_url( get_queried_object_id() );
		if ( $paged > 1 ) {
			return get_pagenum_link( $paged, false );
		}
		return $link;
	}

	if ( is_date() ) {
		$y = (int) get_query_var( 'year' );
		$m = (int) get_query_var( 'monthnum' );
		$d = (int) get_query_var( 'day' );
		if ( $d && $m && $y ) {
			return get_day_link( $y, $m, $d );
		}
		if ( $m && $y ) {
			return get_month_link( $y, $m );
		}
		if ( $y ) {
			return get_year_link( $y );
		}
	}

	return '';
}

/**
 * Output <meta name="robots"> noindex tag when the field is set (singular).
 * Output <link rel="canonical"> for all indexable views.
 */
function restwell_output_canonical_and_robots() {
	if ( is_singular() ) {
		$pid = get_queried_object_id();
		$noindex = (bool) get_post_meta( $pid, 'meta_noindex', true );
		// Guest guide is session-gated private content; always keep it out of index.
		if ( is_page_template( 'page-guest-guide.php' ) ) {
			$noindex = true;
		}
		if ( $noindex ) {
			// noindex keeps URLs out of the index; follow allows normal link discovery on private/marketing-off URLs.
			echo '<meta name="robots" content="noindex, follow">' . "\n";
		}
	}

	$canonical = restwell_get_canonical_url_for_request();
	if ( $canonical !== '' ) {
		echo '<link rel="canonical" href="' . esc_url( $canonical ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'restwell_output_canonical_and_robots', 2 );

// ---------------------------------------------------------------------------
// 1d. Analytics (GA4) + Bing Webmaster verification
// ---------------------------------------------------------------------------

/**
 * Where to load GA4 / Metricool: head (legacy), non-blocking footer loader, or CMP-gated footer loader.
 *
 * @return string head|footer_deferred|consent_gated
 */
function restwell_get_analytics_load_mode() {
	$mode = (string) get_option( 'restwell_analytics_load_mode', 'head' );
	$allowed = array( 'head', 'footer_deferred', 'consent_gated' );
	return in_array( $mode, $allowed, true ) ? $mode : 'head';
}

/**
 * Sanitized GA4 measurement ID or empty.
 *
 * @return string
 */
function restwell_analytics_ga4_measurement_id_sanitized() {
	$mid = (string) get_option( 'restwell_ga4_measurement_id', '' );
	$mid = preg_replace( '/[^G0-9A-Za-z\-]/', '', $mid );
	if ( $mid === '' || strpos( $mid, 'G-' ) !== 0 ) {
		return '';
	}
	return $mid;
}

/**
 * Sanitized Metricool hash or empty.
 *
 * @return string
 */
function restwell_analytics_metricool_hash_sanitized() {
	$hash = (string) get_option( 'restwell_metricool_hash', '' );
	$hash = preg_replace( '/[^0-9A-Za-z]/', '', strtolower( $hash ) );
	return preg_match( '/^[a-f0-9]{32}$/i', $hash ) ? $hash : '';
}

/**
 * Whether analytics scripts are routed through the footer loader (defer / CMP).
 *
 * @return bool
 */
function restwell_analytics_use_footer_loader() {
	if ( 'head' === restwell_get_analytics_load_mode() ) {
		return false;
	}
	return restwell_analytics_ga4_measurement_id_sanitized() !== '' || restwell_analytics_metricool_hash_sanitized() !== '';
}

/**
 * Consent Mode defaults before gtag loads (consent_gated + GA4 only).
 */
function restwell_output_ga4_consent_default() {
	if ( 'consent_gated' !== restwell_get_analytics_load_mode() ) {
		return;
	}
	if ( ! restwell_analytics_use_footer_loader() ) {
		return;
	}
	$mid = restwell_analytics_ga4_measurement_id_sanitized();
	if ( $mid === '' ) {
		return;
	}
	?>
<script<?php echo restwell_csp_script_nonce_attr(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('consent', 'default', {
	analytics_storage: 'denied',
	ad_storage: 'denied',
	ad_user_data: 'denied',
	ad_personalization: 'denied',
	wait_for_update: 500
});
</script>
	<?php
}
add_action( 'wp_head', 'restwell_output_ga4_consent_default', 1 );

/**
 * Enqueue deferred / consent-gated analytics loader (GA4 + Metricool).
 */
function restwell_enqueue_analytics_loader() {
	if ( is_admin() || ! restwell_analytics_use_footer_loader() ) {
		return;
	}

	$theme_uri = get_template_directory_uri();
	$use_min   = ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG );
	$loader_js = $use_min ? '/assets/js/analytics-loader.min.js' : '/assets/js/analytics-loader.js';
	$loader_ver = function_exists( 'restwell_theme_asset_version' )
		? restwell_theme_asset_version( $loader_js )
		: (string) wp_get_theme()->get( 'Version' );

	wp_enqueue_script(
		'restwell-analytics-loader',
		$theme_uri . $loader_js,
		array(),
		$loader_ver,
		true
	);

	$mode = restwell_get_analytics_load_mode();
	wp_localize_script(
		'restwell-analytics-loader',
		'restwellAnalytics',
		array(
			'loadMode'      => 'footer_deferred' === $mode ? 'footer_deferred' : 'consent_gated',
			'consentGated'  => ( 'consent_gated' === $mode ),
			'gaId'          => restwell_analytics_ga4_measurement_id_sanitized(),
			'metricoolHash' => restwell_analytics_metricool_hash_sanitized(),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'restwell_enqueue_analytics_loader', 25 );

/**
 * Output Google Analytics 4 gtag when measurement ID is set (head mode only).
 */
function restwell_output_ga4() {
	if ( restwell_analytics_use_footer_loader() ) {
		return;
	}

	$mid = restwell_analytics_ga4_measurement_id_sanitized();
	if ( $mid === '' ) {
		return;
	}
	?>
	<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr( $mid ); ?>"></script>
<script<?php echo restwell_csp_script_nonce_attr(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', '<?php echo esc_js( $mid ); ?>');
</script>
	<?php
}
add_action( 'wp_head', 'restwell_output_ga4', 20 );

/**
 * Output Metricool tracking snippet when a hash is set (head mode only).
 */
function restwell_output_metricool_tracker() {
	if ( restwell_analytics_use_footer_loader() ) {
		return;
	}

	$hash = restwell_analytics_metricool_hash_sanitized();
	if ( $hash === '' ) {
		return;
	}
	?>
<script<?php echo restwell_csp_script_nonce_attr(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
function loadScript(a){
var b=document.getElementsByTagName("head")[0],c=document.createElement("script");
c.type="text/javascript",c.src="https://tracker.metricool.com/resources/be.js",c.onreadystatechange=a,c.onload=a,b.appendChild(c)}
loadScript(function(){beTracker.t({hash:"<?php echo esc_js( $hash ); ?>"})});
</script>
	<?php
}
add_action( 'wp_head', 'restwell_output_metricool_tracker', 20 );

/**
 * Bing Webmaster Tools verification meta tag.
 */
function restwell_output_bing_verification() {
	$token = (string) get_option( 'restwell_bing_verification', '' );
	$token = preg_replace( '/[^0-9A-Za-z]/', '', $token );
	if ( $token === '' ) {
		return;
	}
	echo '<meta name="msvalidate.01" content="' . esc_attr( $token ) . '">' . "\n";
}
add_action( 'wp_head', 'restwell_output_bing_verification', 1 );

// ---------------------------------------------------------------------------
// 2. OG + Twitter Card meta tags
// ---------------------------------------------------------------------------
// Moved to inc/seo-social-meta.php to keep this file focused on canonical + JSON-LD.

// ---------------------------------------------------------------------------
// 3. JSON-LD structured data
// ---------------------------------------------------------------------------

/**
 * Stable @id for the Organization entity (matches GBP / registered address).
 *
 * @return string Absolute URL with fragment.
 */
function restwell_get_organization_schema_id() {
	$base = trailingslashit( home_url( '/' ) );
	return apply_filters( 'restwell_organization_schema_id', $base . '#organization' );
}

/**
 * Stable @id for LocalBusiness (same brand; postal address aligns with Google Business Profile).
 *
 * @return string Absolute URL with fragment.
 */
function restwell_get_local_business_schema_id() {
	$base = trailingslashit( home_url( '/' ) );
	return apply_filters( 'restwell_local_business_schema_id', $base . '#local-business' );
}

/**
 * Business postal address parts for JSON-LD (GBP-aligned defaults).
 *
 * @return array{streetAddress: string, addressLocality: string, addressRegion: string, postalCode: string, addressCountry: string}
 */
function restwell_get_business_postal_address_parts() {
	$parts = array(
		'streetAddress'   => (string) get_option( 'restwell_business_street', 'Vinters Business Park' ),
		'addressLocality' => (string) get_option( 'restwell_business_locality', 'Maidstone' ),
		'addressRegion'   => (string) get_option( 'restwell_business_region', 'Kent' ),
		'postalCode'      => (string) get_option( 'restwell_business_postcode', 'ME14 5NZ' ),
		'addressCountry'  => 'GB',
	);

	/**
	 * Filter business postal address used in Organization / LocalBusiness JSON-LD.
	 *
	 * @param array{streetAddress: string, addressLocality: string, addressRegion: string, postalCode: string, addressCountry: string} $parts Address parts.
	 */
	return apply_filters( 'restwell_business_postal_address_parts', $parts );
}

/**
 * Geo coordinates for the business address (optional overrides in Theme settings).
 *
 * @return array<string, float>
 */
function restwell_get_business_geo_coordinates() {
	$lat = (float) get_option( 'restwell_business_geo_lat', '51.2707' );
	$lon = (float) get_option( 'restwell_business_geo_lon', '0.5207' );

	return array(
		'@type'     => 'GeoCoordinates',
		'latitude'  => $lat,
		'longitude' => $lon,
	);
}

/**
 * Build Organization JSON-LD array (business address; no property street).
 *
 * @return array<string, mixed>
 */
function restwell_build_jsonld_organization() {
	$site_name = get_bloginfo( 'name' );
	$site_url  = home_url( '/' );
	$addr      = restwell_get_business_postal_address_parts();

	$organization = restwell_jsonld_with_same_as(
		array(
			'@context'    => 'https://schema.org',
			'@type'       => 'Organization',
			'@id'         => restwell_get_organization_schema_id(),
			'name'        => $site_name,
			'url'         => $site_url,
			'description' => get_bloginfo( 'description' ),
			'address'     => array_merge(
				array( '@type' => 'PostalAddress' ),
				$addr
			),
		)
	);

	return $organization;
}

/**
 * Output Organization JSON-LD only (front page uses this with WebSite-only block).
 */
function restwell_output_jsonld_organization_entity() {
	restwell_print_jsonld( restwell_build_jsonld_organization() );
}

/**
 * Output all applicable JSON-LD <script> blocks.
 */
function restwell_output_structured_data() {
	if ( is_front_page() ) {
		restwell_output_jsonld_website_only();
		restwell_output_jsonld_front_page_webpage();
		restwell_output_jsonld_organization_entity();
		restwell_output_jsonld_local_business( 0 );
	} else {
		restwell_output_jsonld_website_organization();
		if ( is_page_template( 'template-property.php' ) && is_singular( 'page' ) && ! is_front_page() ) {
			restwell_output_jsonld_local_business( get_queried_object_id() );
			restwell_output_jsonld_accommodation_service();
		}
	}

	if ( is_front_page() ) {
		restwell_output_jsonld_homepage_faq();
	}

	if ( ! is_front_page() && ( is_singular() || is_home() || is_category() || is_tag() || is_date() || is_author() ) ) {
		restwell_output_jsonld_breadcrumb();
	}

	if ( is_singular( 'post' ) ) {
		restwell_output_jsonld_article();
	}

	if ( is_page_template( 'template-faq.php' ) || is_page( 'faq' ) ) {
		restwell_output_jsonld_faq_page();
	}

	if ( is_page_template( 'template-whitstable-guide.php' ) ) {
		restwell_output_jsonld_tourist_destination();
	}

	if ( is_page_template( 'template-how-it-works.php' ) ) {
		restwell_output_jsonld_how_to();
	}

	if ( is_page_template( 'template-enquire.php' ) ) {
		restwell_output_jsonld_contact_page();
	}
}
add_action( 'wp_head', 'restwell_output_structured_data', 10 );

/**
 * Helper: encode schema array to a JSON-LD <script> block.
 *
 * @param array $schema Schema.org data array.
 */
function restwell_print_jsonld( $schema ) {
	// Remove null values to keep output clean
	$schema = array_filter(
		$schema,
		function( $v ) {
			return $v !== null && $v !== '' && $v !== array();
		}
	);
	echo '<script type="application/ld+json">' . "\n";
	echo wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
	echo "\n" . '</script>' . "\n";
}

/**
 * Back-compat: former VacationRental @id fragment now points at LocalBusiness.
 *
 * @return string Absolute URL with fragment.
 */
function restwell_get_place_schema_id() {
	return apply_filters( 'restwell_place_schema_id', restwell_get_local_business_schema_id() );
}

/**
 * Canonical URL for the single bookable property in JSON-LD (defaults to homepage).
 *
 * @param int $page_id Page ID for context (e.g. property template page ID), or 0.
 * @return string Absolute URL.
 */
function restwell_get_single_property_canonical_url( $page_id = 0 ) {
	$default = trailingslashit( home_url( '/' ) );
	return apply_filters( 'restwell_single_property_canonical_url', apply_filters( 'restwell_vacation_rental_canonical_url', $default, (int) $page_id ), (int) $page_id );
}

/**
 * Collect accommodation image URLs from page media fields (LocalBusiness / Service JSON-LD).
 *
 * @param int $page_id Optional page context (property template page ID). If omitted, uses front page.
 * @return array<int, string>
 */
function restwell_get_accommodation_image_urls( $page_id = 0 ) {
	$page_id = (int) $page_id;
	if ( $page_id <= 0 ) {
		$page_id = (int) get_option( 'page_on_front', 0 );
	}
	if ( $page_id <= 0 ) {
		return array();
	}

	$meta_image_keys = array(
		'og_image_id',
		'hero_media_id',
		'prop_hero_image_id',
		'prop_dignity_image_id',
		'prop_gallery_1_image_id',
		'prop_gallery_2_image_id',
		'prop_gallery_3_image_id',
	);

	$image_urls = array();
	foreach ( $meta_image_keys as $meta_key ) {
		$img_id = absint( get_post_meta( $page_id, $meta_key, true ) );
		if ( ! $img_id ) {
			continue;
		}

		$mime = (string) get_post_mime_type( $img_id );
		if ( $mime !== '' && strpos( $mime, 'image/' ) !== 0 ) {
			continue;
		}

		$img = wp_get_attachment_image_url( $img_id, 'full' );
		if ( $img ) {
			$image_urls[] = $img;
		}
	}

	return array_values( array_unique( array_filter( $image_urls ) ) );
}

/**
 * Default accessibility amenity rows for LocalBusiness JSON-LD.
 *
 * @return array<int, array<string, mixed>>
 */
function restwell_get_default_lodging_amenity_features() {
	return array(
		array( '@type' => 'LocationFeatureSpecification', 'name' => 'Wheelchair accessible accommodation', 'value' => true ),
		array( '@type' => 'LocationFeatureSpecification', 'name' => 'Ceiling track hoist (accessible bedroom)', 'value' => true ),
		array( '@type' => 'LocationFeatureSpecification', 'name' => 'Profiling bed', 'value' => true ),
		array( '@type' => 'LocationFeatureSpecification', 'name' => 'Wet room / roll-in shower', 'value' => true ),
		array( '@type' => 'LocationFeatureSpecification', 'name' => 'Level access throughout', 'value' => true ),
		array( '@type' => 'LocationFeatureSpecification', 'name' => 'Self-catering kitchen', 'value' => true ),
		array( '@type' => 'LocationFeatureSpecification', 'name' => 'Whole-property booking', 'value' => true ),
		array( '@type' => 'LocationFeatureSpecification', 'name' => 'Optional CQC-regulated care (Continuity of Care Services)', 'value' => true ),
	);
}

/**
 * LocalBusiness JSON-LD (postal address matches Google Business Profile; area served Whitstable).
 *
 * @param int $page_id Front page context uses 0 to merge property-page gallery images when available.
 */
function restwell_output_jsonld_local_business( $page_id = 0 ) {
	$page_id   = (int) $page_id;
	$site_name = get_bloginfo( 'name' );
	$site_url  = home_url( '/' );
	$phone     = (string) get_option( 'restwell_phone_number', '' );
	$email     = (string) get_option( 'restwell_enquiry_notify_email', '' );

	$addr_parts = restwell_get_business_postal_address_parts();
	$address    = array_merge( array( '@type' => 'PostalAddress' ), $addr_parts );

	$desc = get_bloginfo( 'description' );
	if ( $desc === '' ) {
		$desc = __( 'Wheelchair-accessible adapted holiday bungalow in Whitstable, Kent: bedroom ceiling track hoist, profiling bed, roll-in shower.', 'restwell-retreats' );
	}

	$price_range = (string) get_option( 'restwell_lodging_price_range', '' );
	$price_range = (string) apply_filters( 'restwell_lodging_price_range', $price_range );
	$price_range = (string) apply_filters( 'restwell_vacation_rental_price_range', $price_range );
	if ( $price_range === '' ) {
		$price_range = __( 'Rates on enquiry', 'restwell-retreats' );
	}

	$image_urls = restwell_get_accommodation_image_urls( $page_id <= 0 ? 0 : $page_id );

	if ( 0 === $page_id ) {
		$prop_page = get_page_by_path( 'the-property', OBJECT, 'page' );
		$prop_pid  = $prop_page ? (int) $prop_page->ID : 0;
		if ( $prop_pid > 0 ) {
			$property_image_keys = array(
				'og_image_id',
				'prop_hero_image_id',
				'prop_dignity_image_id',
				'prop_gallery_1_image_id',
				'prop_gallery_2_image_id',
				'prop_gallery_3_image_id',
			);
			foreach ( $property_image_keys as $meta_key ) {
				$img_id = absint( get_post_meta( $prop_pid, $meta_key, true ) );
				if ( ! $img_id ) {
					continue;
				}
				$mime = (string) get_post_mime_type( $img_id );
				if ( $mime !== '' && strpos( $mime, 'image/' ) !== 0 ) {
					continue;
				}
				$img = wp_get_attachment_image_url( $img_id, 'full' );
				if ( $img ) {
					$image_urls[] = $img;
				}
			}
			$image_urls = array_values( array_unique( array_filter( $image_urls ) ) );
		}
	}

	$schema = array(
		'@context'            => 'https://schema.org',
		'@type'               => 'LocalBusiness',
		'@id'                 => restwell_get_local_business_schema_id(),
		'name'                => $site_name,
		'description'         => $desc,
		'url'                 => $site_url,
		'priceRange'          => $price_range,
		'address'             => $address,
		'geo'                 => restwell_get_business_geo_coordinates(),
		'parentOrganization'  => array( '@id' => restwell_get_organization_schema_id() ),
		'areaServed'          => array(
			'@type'   => 'Place',
			'name'    => __( 'Whitstable, Kent', 'restwell-retreats' ),
			'address' => array(
				'@type'           => 'PostalAddress',
				'addressLocality' => 'Whitstable',
				'addressRegion'   => 'Kent',
				'addressCountry'  => 'GB',
			),
		),
		'amenityFeature'      => restwell_get_default_lodging_amenity_features(),
		'acceptsReservations' => true,
	);

	if ( $phone !== '' ) {
		$schema['telephone'] = $phone;
	}
	if ( $email !== '' ) {
		$schema['email'] = $email;
	}
	if ( ! empty( $image_urls ) ) {
		$schema['image'] = count( $image_urls ) === 1 ? $image_urls[0] : $image_urls;
	}

	$schema = restwell_jsonld_with_same_as( $schema );

	restwell_print_jsonld( $schema );
}

/**
 * Service JSON-LD for the accessible holiday let (property template only; no street address).
 */
function restwell_output_jsonld_accommodation_service() {
	$pid = get_queried_object_id();
	if ( ! $pid ) {
		return;
	}

	$name = (string) get_post_meta( $pid, 'meta_title', true );
	if ( $name === '' ) {
		$name = (string) get_post_meta( $pid, 'prop_hero_heading', true );
	}
	if ( $name === '' ) {
		$name = get_bloginfo( 'name' ) . ' — ' . __( 'Accessible holiday accommodation, Whitstable', 'restwell-retreats' );
	}

	$desc = (string) get_post_meta( $pid, 'meta_description', true );
	if ( $desc === '' ) {
		$desc = (string) get_post_meta( $pid, 'prop_hero_subtitle', true );
	}
	if ( $desc === '' ) {
		$desc = __( 'Accessible self-catering holiday accommodation in Whitstable, Kent, with ceiling-track hoist, profiling bed, and roll-in wet room.', 'restwell-retreats' );
	}

	$permalink = get_permalink( $pid );
	if ( ! $permalink ) {
		return;
	}

	$enquire_page = get_page_by_path( 'enquire', OBJECT, 'page' );
	$booking_url  = $enquire_page ? get_permalink( $enquire_page ) : home_url( '/enquire/' );

	$amenities = array();
	for ( $i = 1; $i <= 8; $i++ ) {
		$feat = get_post_meta( $pid, 'prop_feature_' . $i, true );
		$feat_desc = get_post_meta( $pid, 'prop_feature_' . $i . '_desc', true );
		if ( $feat !== '' ) {
			$amenity = array(
				'@type' => 'LocationFeatureSpecification',
				'name'  => $feat,
				'value' => true,
			);
			if ( $feat_desc !== '' ) {
				$amenity['description'] = $feat_desc;
			}
			$amenities[] = $amenity;
		}
	}
	if ( empty( $amenities ) ) {
		$amenities = restwell_get_default_lodging_amenity_features();
	}

	$image_urls = restwell_get_accommodation_image_urls( $pid );

	$schema = array(
		'@context'    => 'https://schema.org',
		'@type'       => 'Service',
		'@id'         => trailingslashit( $permalink ) . '#accommodation-service',
		'name'        => $name,
		'description' => $desc,
		'url'         => $permalink,
		'serviceType' => __( 'Accessible self-catering holiday accommodation', 'restwell-retreats' ),
		'provider'    => array( '@id' => restwell_get_organization_schema_id() ),
		'areaServed'  => array(
			'@type'   => 'Place',
			'name'    => __( 'Whitstable, Kent', 'restwell-retreats' ),
			'address' => array(
				'@type'           => 'PostalAddress',
				'addressLocality' => 'Whitstable',
				'addressRegion'   => 'Kent',
				'addressCountry'  => 'GB',
			),
		),
		'availableChannel' => array(
			'@type'       => 'ServiceChannel',
			'serviceUrl'  => $booking_url,
			'serviceName' => __( 'Booking enquiry', 'restwell-retreats' ),
		),
		'category'    => array(
			__( 'Accessible travel', 'restwell-retreats' ),
			__( 'Self-catering holiday', 'restwell-retreats' ),
		),
	);

	if ( ! empty( $image_urls ) ) {
		$schema['image'] = count( $image_urls ) === 1 ? $image_urls[0] : $image_urls;
	}

	$schema = restwell_jsonld_with_same_as( $schema );

	restwell_print_jsonld( $schema );
}

/**
 * WebSite only - used on front page (Organization + LocalBusiness output separately).
 */
function restwell_output_jsonld_website_only() {
	$site_name = get_bloginfo( 'name' );
	$site_url  = home_url( '/' );
	// Sitelinks search box: WordPress core search query param `s`.
	$search_url_template = home_url( '/?s={search_term_string}' );

	$website = array(
		'@context' => 'https://schema.org',
		'@type'    => 'WebSite',
		'@id'      => trailingslashit( $site_url ) . '#website',
		'name'     => $site_name,
		'url'      => $site_url,
		'about'    => array( '@id' => restwell_get_local_business_schema_id() ),
		'potentialAction' => array(
			'@type'       => 'SearchAction',
			'target'      => array(
				'@type'        => 'EntryPoint',
				'urlTemplate'  => $search_url_template,
			),
			'query-input' => 'required name=search_term_string',
		),
	);

	restwell_print_jsonld( $website );
}

/**
 * WebPage JSON-LD on the static front page (freshness: datePublished / dateModified).
 */
function restwell_output_jsonld_front_page_webpage() {
	$pid = (int) get_option( 'page_on_front', 0 );
	if ( $pid <= 0 ) {
		return;
	}
	$url      = get_permalink( $pid );
	$title    = get_the_title( $pid );
	$pub      = get_the_date( 'c', $pid );
	$mod      = get_the_modified_date( 'c', $pid );
	$schema   = array(
		'@context'      => 'https://schema.org',
		'@type'         => 'WebPage',
		'@id'           => trailingslashit( $url ) . '#webpage',
		'url'           => $url,
		'name'          => $title,
		'datePublished' => $pub,
		'dateModified'  => $mod,
		'inLanguage'    => 'en-GB',
		'isPartOf'      => array(
			'@type' => 'WebSite',
			'url'   => home_url( '/' ),
			'name'  => get_bloginfo( 'name' ),
		),
	);
	restwell_print_jsonld( $schema );
}

/**
 * Homepage FAQ pairs (legacy q/a shape for theme setup seed map).
 *
 * Content comes from inc/homepage-faq.php via restwell_get_faq_items( 'homepage' ).
 * Front page post meta home_faq_{1..7}_{q,a} is no longer read for FAQ copy.
 *
 * @param int $page_id Front page post ID (unused for FAQ copy; kept for filter signature).
 * @return array<int, array{q: string, a: string}>
 */
function restwell_get_homepage_faq_pairs( $page_id = 0 ) {
	$page_id = (int) $page_id;
	$pairs   = array();

	if ( function_exists( 'restwell_get_faq_items' ) ) {
		foreach ( restwell_get_faq_items( 'homepage' ) as $item ) {
			if ( empty( $item['q'] ) || empty( $item['a'] ) ) {
				continue;
			}
			$pairs[] = array(
				'q' => $item['q'],
				'a' => $item['a'],
			);
		}
	}

	/**
	 * Filter homepage FAQ pairs before output (theme setup seed map).
	 *
	 * @param array<int, array{q: string, a: string}> $pairs   Pairs to show.
	 * @param int                                     $page_id Front page ID.
	 */
	return apply_filters( 'restwell_homepage_faq_pairs', $pairs, $page_id );
}

/**
 * Flat post meta for homepage FAQ section (Theme Setup seed + one-time migration).
 * Keys match page-meta-definitions and front-page.php.
 *
 * @return array<string, string>
 */
function restwell_get_homepage_faq_meta_seed_map() {
	$pairs = restwell_get_homepage_faq_pairs( 0 );
	$out   = array(
		'home_faq_label'   => __( 'Quick answers', 'restwell-retreats' ),
		'home_faq_heading' => __( 'Common questions', 'restwell-retreats' ),
	);
	foreach ( $pairs as $i => $p ) {
		$n = $i + 1;
		$out[ 'home_faq_' . $n . '_q' ] = $p['q'];
		$out[ 'home_faq_' . $n . '_a' ] = $p['a'];
	}
	return $out;
}

/**
 * Output FAQPage JSON-LD on the front page (pairs must match visible content).
 */
function restwell_output_jsonld_homepage_faq() {
	$front_id = (int) get_option( 'page_on_front', 0 );
	if ( $front_id <= 0 ) {
		return;
	}
	// Match front-page.php: section hidden when heading cleared in Page Content Fields.
	$heading_meta = get_post_meta( $front_id, 'home_faq_heading', true );
	$show_section = ! ( metadata_exists( 'post', $front_id, 'home_faq_heading' ) && $heading_meta === '' );
	if ( ! $show_section ) {
		return;
	}

	$pairs = function_exists( 'restwell_get_faq_items' ) ? restwell_get_faq_items( 'homepage' ) : array();
	if ( empty( $pairs ) ) {
		return;
	}

	$main_entity = array();
	foreach ( $pairs as $pair ) {
		if ( empty( $pair['q'] ) || empty( $pair['a'] ) ) {
			continue;
		}

		$answer_text = '';
		if ( ! empty( $pair['answer_text'] ) ) {
			$answer_text = $pair['answer_text'];
		} else {
			$answer_text = wp_strip_all_tags( $pair['a'] );
		}

		$main_entity[] = array(
			'@type'          => 'Question',
			'name'           => wp_strip_all_tags( $pair['q'] ),
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => $answer_text,
			),
		);
	}

	if ( empty( $main_entity ) ) {
		return;
	}

	$schema = array(
		'@context'   => 'https://schema.org',
		'@type'      => 'FAQPage',
		'mainEntity' => $main_entity,
	);

	restwell_print_jsonld( $schema );
}

/**
 * WebSite + Organization - output on interior pages.
 */
function restwell_output_jsonld_website_organization() {
	$site_name = get_bloginfo( 'name' );
	$site_url  = home_url( '/' );

	$website = array(
		'@context'  => 'https://schema.org',
		'@type'     => 'WebSite',
		'@id'       => trailingslashit( $site_url ) . '#website',
		'name'      => $site_name,
		'url'       => $site_url,
		'publisher' => array( '@id' => restwell_get_organization_schema_id() ),
	);

	restwell_print_jsonld( $website );
	restwell_print_jsonld( restwell_build_jsonld_organization() );
}

/**
 * BreadcrumbList - output on interior singular pages.
 * For single posts: Home > Blog > [primary category] > Post title (category omitted when only Uncategorized).
 */
function restwell_output_jsonld_breadcrumb() {
	$posts_page_id  = (int) get_option( 'page_for_posts' );
	$archive_name   = $posts_page_id ? get_the_title( $posts_page_id ) : __( 'Blog', 'restwell-retreats' );
	$archive_url    = $posts_page_id ? (string) get_permalink( $posts_page_id ) : home_url( '/blog/' );

	$items = array(
		array(
			'@type'    => 'ListItem',
			'position' => 1,
			'name'     => __( 'Home', 'restwell-retreats' ),
			'item'     => home_url( '/' ),
		),
	);

	if ( is_home() ) {
		// Blog index: Home > Blog title (current, no item URL).
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => 2,
			'name'     => $archive_name,
		);
	} elseif ( is_category() ) {
		$cat     = get_queried_object();
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => 2,
			'name'     => $archive_name,
			'item'     => $archive_url,
		);
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => 3,
			'name'     => $cat instanceof WP_Term ? $cat->name : '',
		);
	} elseif ( is_tag() ) {
		$tag     = get_queried_object();
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => 2,
			'name'     => $archive_name,
			'item'     => $archive_url,
		);
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => 3,
			'name'     => $tag instanceof WP_Term ? $tag->name : '',
		);
	} elseif ( is_date() ) {
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => 2,
			'name'     => $archive_name,
			'item'     => $archive_url,
		);
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => 3,
			'name'     => get_the_archive_title(),
		);
	} elseif ( is_author() ) {
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => 2,
			'name'     => get_the_author_meta( 'display_name', get_queried_object_id() ),
		);
	} elseif ( is_singular( 'post' ) ) {
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => 2,
			'name'     => $archive_name,
			'item'     => $archive_url,
		);
		$position = 3;
		$post_categories = get_the_category();
		if ( ! empty( $post_categories ) ) {
			foreach ( $post_categories as $cat_obj ) {
				if ( 'uncategorized' === $cat_obj->slug ) {
					continue;
				}
				$items[] = array(
					'@type'    => 'ListItem',
					'position' => $position,
					'name'     => $cat_obj->name,
					'item'     => get_category_link( $cat_obj->term_id ),
				);
				++$position;
				break;
			}
		}
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => $position,
			'name'     => get_the_title(),
			'item'     => (string) get_permalink(),
		);
	} else {
		// Default singular page: Home > Page title.
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => 2,
			'name'     => get_the_title(),
			'item'     => (string) get_permalink(),
		);
	}

	// Strip empty-string 'name' entries that would create invalid markup.
	$items = array_filter(
		$items,
		static function ( $item ) {
			return isset( $item['name'] ) && '' !== (string) $item['name'];
		}
	);

	restwell_print_jsonld( array(
		'@context'        => 'https://schema.org',
		'@type'           => 'BreadcrumbList',
		'itemListElement' => array_values( $items ),
	) );
}

/**
 * Article (BlogPosting) - output on single post pages.
 */
function restwell_output_jsonld_article() {
	$pid = get_queried_object_id();
	if ( ! $pid ) {
		return;
	}

	$title       = get_the_title( $pid );
	$excerpt     = wp_strip_all_tags( get_the_excerpt( $pid ) );
	$date_pub    = get_the_date( 'c', $pid );
	$date_mod    = get_the_modified_date( 'c', $pid );
	$author_name = get_bloginfo( 'name' ); // site name as author for brand articles

	$image_url = '';
	$thumb_id  = get_post_thumbnail_id( $pid );
	if ( $thumb_id ) {
		$image_url = wp_get_attachment_image_url( $thumb_id, 'full' );
	}

	// Primary category for articleSection.
	$category = '';
	if ( function_exists( 'restwell_get_primary_category' ) ) {
		$category = restwell_get_primary_category( $pid );
	}

	$publisher_org = restwell_jsonld_with_same_as(
		array(
			'@type' => 'Organization',
			'name'  => get_bloginfo( 'name' ),
			'url'   => home_url( '/' ),
		)
	);

	$schema = array(
		'@context'         => 'https://schema.org',
		'@type'            => 'BlogPosting',
		'headline'         => $title,
		'url'              => get_permalink( $pid ),
		'datePublished'    => $date_pub,
		'dateModified'     => $date_mod,
		'description'      => $excerpt,
		'author'           => array(
			'@type' => 'Organization',
			'name'  => $author_name,
			'url'   => home_url( '/' ),
		),
		'publisher'        => $publisher_org,
		'mainEntityOfPage' => array(
			'@type' => 'WebPage',
			'@id'   => get_permalink( $pid ),
		),
		'inLanguage'       => 'en-GB',
		'isPartOf'         => array(
			'@type' => 'WebSite',
			'url'   => home_url( '/' ),
			'name'  => get_bloginfo( 'name' ),
		),
	);

	if ( $image_url ) {
		$schema['image'] = $image_url;
	}
	if ( $category !== '' ) {
		$schema['articleSection'] = $category;
	}

	restwell_print_jsonld( $schema );
}

/**
 * Default FAQ Q/A for the FAQ page template and matching FAQPage JSON-LD (single source of truth).
 *
 * @return array<int, array{q: string, a: string, cat: string}>
 */
function restwell_get_faq_page_default_pairs() {
	return array(
		array(
			'q'   => 'Is this a care home?',
			'a'   => 'No. Restwell is a private holiday let: a real house that you have entirely to yourself. It is not a care home, a residential facility, or a clinical environment. Care is an optional extra that you can choose to add through our partner, Continuity of Care Services.',
			'cat' => 'about',
		),
		array(
			'q'   => 'What accessibility features does the property have?',
			'a'   => 'The property has level access throughout the ground floor and wide doorways suitable for wheelchair access. It is located on a quiet, flat residential street. For full details please visit our Accessibility page.',
			'cat' => 'about',
		),
		array(
			'q'   => 'How do I book?',
			'a'   => 'Start by using our enquiry form or getting in touch by phone or email. We will talk through your dates, your needs, and any questions you have. Once we have confirmed availability and you are happy with everything, we will confirm your booking.',
			'cat' => 'booking',
		),
		array(
			'q'   => 'How far in advance can I book?',
			'a'   => 'We accept bookings as early as you need; some guests plan months ahead, particularly for summer. Get in touch with your preferred dates and we will confirm availability.',
			'cat' => 'booking',
		),
		array(
			'q'   => 'Can I bring my own carer or PA?',
			'a'   => 'Absolutely. Many of our guests bring their own Personal Assistant or carer. The property is designed to accommodate everyone comfortably. You can also use CCS for \'top-up\' support alongside your own carer.',
			'cat' => 'care',
		),
		array(
			'q'   => 'What care can you provide?',
			'a'   => 'Care is provided by Continuity of Care Services (CCS), a CQC-regulated Kent-based provider. Support can range from a brief morning check-in to more comprehensive daily assistance. We will discuss your needs before your stay.',
			'cat' => 'care',
		),
		array(
			'q'   => 'Is the beach accessible?',
			'a'   => 'Whitstable\'s beach is shingle, which is generally not wheelchair-friendly. However, the Tankerton Slopes promenade (a long, flat concrete walkway above the beach) is excellent for wheelchair users and offers stunning sea views.',
			'cat' => 'local',
		),
		array(
			'q'   => 'What is Whitstable like to get around?',
			'a'   => 'Much of central Whitstable and the seafront area is relatively flat and accessible. The town has accessible parking, and the high street has a good mix of level and stepped access venues. We are happy to suggest specific places to eat, visit, and explore.',
			'cat' => 'local',
		),
		array(
			'q'   => 'Can I use my direct payment to stay at Restwell?',
			'a'   => 'In many cases, yes. Direct payments can often be used for short breaks and respite accommodation, depending on your care plan and local authority. We can provide the documentation your social worker or broker needs to approve the spend. Start with our Funding & Support page or get in touch to discuss your situation.',
			'cat' => 'funding',
		),
		array(
			'q'   => 'Is the property suitable for hoists and profiling beds?',
			'a'   => 'Yes. The accessible bedroom has a ceiling track hoist and profiling bed, and there is a full roll-in wet room on the same single-storey level, with a perching stool in the shower and a washbasin you can raise, lower, and swing aside when you need clearer space. A shower chair may be available on request; please say so when you enquire or book. If you have additional or specialist equipment needs, please get in touch before booking so we can confirm we can accommodate them.',
			'cat' => 'about',
		),
		array(
			'q'   => 'What is the minimum stay?',
			'a'   => 'We are flexible. Most guests stay for a week, but shorter breaks are sometimes available depending on the time of year. Get in touch with your preferred dates and we will let you know.',
			'cat' => 'booking',
		),
		array(
			'q'   => 'What does CQC-regulated mean?',
			'a'   => 'CQC stands for Care Quality Commission, the independent regulator of health and social care in England. Continuity of Care Services, our partner provider, is inspected and rated by the CQC. This means the care you receive meets nationally recognised standards for safety and quality. You can see Continuity’s latest inspection summary on the <a href="https://www.cqc.org.uk/location/1-2624556588" target="_blank" rel="noopener noreferrer">Care Quality Commission website<span class="sr-only"> (opens in new tab)</span></a>.',
			'cat' => 'funding',
		),
	);
}

/**
 * FAQPage - output on the FAQ template.
 */
function restwell_output_jsonld_faq_page() {
	$pid = get_queried_object_id();
	if ( ! $pid ) {
		return;
	}

	// Use centralised helper so JSON-LD mirrors the same data as the template.
	$faq_pairs = function_exists( 'restwell_get_faq_items' ) ? restwell_get_faq_items( 'faq-page' ) : array();

	$main_entity = array();
	foreach ( $faq_pairs as $pair ) {
		$main_entity[] = array(
			'@type'          => 'Question',
			'name'           => wp_strip_all_tags( $pair['q'] ),
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => wp_strip_all_tags( $pair['a'] ),
			),
		);
	}

	$schema = array(
		'@context'   => 'https://schema.org',
		'@type'      => 'FAQPage',
		'mainEntity' => $main_entity,
	);

	restwell_print_jsonld( $schema );
}

/**
 * TouristDestination / Place schema for Whitstable guide page.
 */
function restwell_output_jsonld_tourist_destination() {
	$pid = get_queried_object_id();
	if ( ! $pid ) {
		return;
	}

	$schema = array(
		'@context'    => 'https://schema.org',
		'@type'       => 'TouristDestination',
		'name'        => 'Whitstable, Kent',
		'url'         => get_permalink( $pid ),
		'description' => 'A practical accessibility-focused guide to Whitstable for guests staying at Restwell Retreats.',
		'containedInPlace' => array(
			'@type' => 'AdministrativeArea',
			'name'  => 'Kent',
		),
		'touristType' => array(
			'Accessible travel',
			'Family breaks',
			'Coastal day trips',
		),
	);

	restwell_print_jsonld( $schema );
}

/**
 * HowTo - booking process steps on the how-it-works template.
 */
function restwell_output_jsonld_how_to() {
	$pid = get_queried_object_id();
	if ( ! $pid ) {
		return;
	}

	$name = get_post_meta( $pid, 'meta_title', true );
	if ( $name === '' ) {
		$name = __( 'How to book Restwell Retreats', 'restwell-retreats' );
	}

	$desc = get_post_meta( $pid, 'meta_description', true );
	if ( $desc === '' ) {
		$desc = __( 'A straightforward three-step process to enquire, confirm suitability, and book your accessible holiday at Restwell Retreats.', 'restwell-retreats' );
	}

	$schema = array(
		'@context'    => 'https://schema.org',
		'@type'       => 'HowTo',
		'name'        => $name,
		'description' => $desc,
		'url'         => get_permalink( $pid ),
		'step'        => array(
			array(
				'@type'    => 'HowToStep',
				'position' => 1,
				'name'     => 'Share your requirements',
				'text'     => 'Use the enquiry form or get in touch by phone or email to tell us about your dates, access needs, and any questions you have.',
				'url'      => home_url( '/enquire/' ),
			),
			array(
				'@type'    => 'HowToStep',
				'position' => 2,
				'name'     => 'Confirm suitability',
				'text'     => 'We will talk through your specific requirements, share the access statement, and confirm the property is right for you before you commit to anything.',
			),
			array(
				'@type'    => 'HowToStep',
				'position' => 3,
				'name'     => 'Book and prepare',
				'text'     => 'Once you are happy, we confirm your booking and help you plan your stay, including care support options if needed.',
			),
		),
	);

	restwell_print_jsonld( $schema );
}

/**
 * ContactPage - output on the enquire template (primary contact surface).
 */
function restwell_output_jsonld_contact_page() {
	$pid = get_queried_object_id();
	if ( ! $pid ) {
		return;
	}

	$page_url = get_permalink( $pid );
	if ( ! $page_url ) {
		return;
	}

	$phone = (string) get_option( 'restwell_phone_number', '' );
	$email = (string) get_option( 'restwell_enquiry_notify_email', '' );

	$contact_point = array(
		'@type'             => 'ContactPoint',
		'contactType'       => 'customer service',
		'areaServed'        => 'GB',
		'availableLanguage' => 'English',
	);

	if ( $phone !== '' ) {
		$contact_point['telephone'] = $phone;
	}
	if ( $email !== '' ) {
		$contact_point['email'] = $email;
	}

	$main_org = restwell_jsonld_with_same_as(
		array(
			'@type'         => 'Organization',
			'@id'           => trailingslashit( home_url( '/' ) ) . '#organization',
			'name'          => get_bloginfo( 'name' ),
			'url'           => home_url( '/' ),
			'contactPoint'  => $contact_point,
		)
	);

	$schema = array(
		'@context'    => 'https://schema.org',
		'@type'       => 'ContactPage',
		'name'        => get_the_title( $pid ),
		'url'         => $page_url,
		'description' => __( 'Enquire about availability or ask any questions about staying at Restwell Retreats, the accessible holiday home in Whitstable, Kent.', 'restwell-retreats' ),
		'mainEntity'  => $main_org,
	);

	restwell_print_jsonld( $schema );
}
