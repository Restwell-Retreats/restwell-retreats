<?php
/**
 * Primary keyphrase map and cannibalisation audit.
 *
 * Source of truth: focus_keyphrase values in restwell_get_seo_meta_defaults_by_slug()
 * (seo-content-seed-meta.php, loaded via seo-content-seed.php).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Slugs excluded from the keyphrase-clash audit (noindex or branded utility).
 *
 * @return array<int, string>
 */
function restwell_keyword_map_excluded_slugs() {
	return array(
		'guest-guide',
		'privacy-policy',
		'terms-and-conditions',
	);
}

/**
 * Reserved primary keyphrases for pages not yet in the seed map.
 *
 * @return array<string, string> slug => focus_keyphrase
 */
function restwell_get_reserved_primary_keyphrases() {
	return array();
}

/**
 * Full primary-keyphrase map: seed focus_keyphrase values plus reserved lanes.
 *
 * @return array<string, string> slug => normalised-ready focus_keyphrase
 */
function restwell_get_seo_keyword_map() {
	$map = array();

	if ( function_exists( 'restwell_get_seo_meta_defaults_by_slug' ) ) {
		foreach ( restwell_get_seo_meta_defaults_by_slug() as $slug => $row ) {
			$kp = isset( $row['focus_keyphrase'] ) ? trim( (string) $row['focus_keyphrase'] ) : '';
			if ( $kp !== '' ) {
				$map[ (string) $slug ] = $kp;
			}
		}
	}

	foreach ( restwell_get_reserved_primary_keyphrases() as $slug => $kp ) {
		$kp = trim( (string) $kp );
		if ( $kp !== '' && ! isset( $map[ $slug ] ) ) {
			$map[ $slug ] = $kp;
		}
	}

	return $map;
}

/**
 * Primary focus keyphrase for a page/post slug.
 *
 * @param string $slug Path slug without slashes (e.g. home, the-property, pricing).
 * @return string Empty when unknown.
 */
function restwell_get_primary_keyphrase( $slug ) {
	$slug = sanitize_title( (string) $slug );
	if ( $slug === '' ) {
		return '';
	}

	$map = restwell_get_seo_keyword_map();
	return isset( $map[ $slug ] ) ? (string) $map[ $slug ] : '';
}

/**
 * Normalise text for clash comparison (lowercase, collapsed whitespace).
 *
 * @param string $text Raw text.
 * @return string
 */
function restwell_keyword_map_normalize( $text ) {
	if ( function_exists( 'restwell_seo_admin_normalize_for_keyphrase_match' ) ) {
		return restwell_seo_admin_normalize_for_keyphrase_match( (string) $text );
	}
	$text = strtolower( trim( (string) $text ) );
	return (string) preg_replace( '/\s+/u', ' ', $text );
}

/**
 * Strip brand / site-name suffixes from a title for near-duplicate checks.
 *
 * @param string $title Title tag text.
 * @return string
 */
function restwell_keyword_map_title_core( $title ) {
	$title = restwell_keyword_map_normalize( $title );
	$name  = restwell_keyword_map_normalize( get_bloginfo( 'name' ) );
	if ( $name !== '' ) {
		$title = preg_replace( '/\s*[\|\-–—]\s*' . preg_quote( $name, '/' ) . '\s*$/u', '', $title );
		$title = preg_replace( '/\s*[\|\-–—]\s*restwell(?:\s+retreats)?\s*$/u', '', $title );
	} else {
		$title = preg_replace( '/\s*[\|\-–—]\s*restwell(?:\s+retreats)?\s*$/u', '', $title );
	}
	return trim( (string) $title );
}

/**
 * Whether two title cores are near-duplicates.
 *
 * @param string $a Normalised title core.
 * @param string $b Normalised title core.
 * @return bool
 */
function restwell_keyword_map_titles_near_duplicate( $a, $b ) {
	if ( $a === '' || $b === '' ) {
		return false;
	}
	if ( $a === $b ) {
		return true;
	}
	similar_text( $a, $b, $percent );
	return (float) $percent >= 90.0;
}

/**
 * Resolve the public H1 for a published page/post used in the audit.
 *
 * @param WP_Post $post Post object.
 * @return string
 */
function restwell_keyword_map_resolve_h1( WP_Post $post ) {
	$h1_key = function_exists( 'restwell_page_content_h1_meta_key' )
		? restwell_page_content_h1_meta_key( $post )
		: '';
	if ( $h1_key !== '' ) {
		$h1 = trim( (string) get_post_meta( $post->ID, $h1_key, true ) );
		if ( $h1 !== '' ) {
			return $h1;
		}
	}

	return trim( (string) get_the_title( $post ) );
}

/**
 * Resolve effective focus keyphrase for a post (saved meta, else seed map).
 *
 * @param WP_Post $post Post object.
 * @return string
 */
function restwell_keyword_map_resolve_keyphrase( WP_Post $post ) {
	$kp = trim( (string) get_post_meta( $post->ID, 'focus_keyphrase', true ) );
	if ( $kp !== '' ) {
		return $kp;
	}

	if ( function_exists( 'restwell_get_seo_default_meta_for_post_id' ) ) {
		$defaults = restwell_get_seo_default_meta_for_post_id( (int) $post->ID );
		if ( ! empty( $defaults['focus_keyphrase'] ) ) {
			return (string) $defaults['focus_keyphrase'];
		}
	}

	$slug = (string) $post->post_name;
	$front = (int) get_option( 'page_on_front', 0 );
	if ( $front > 0 && (int) $post->ID === $front ) {
		$slug = 'home';
	}
	$posts_page = (int) get_option( 'page_for_posts', 0 );
	if ( $posts_page > 0 && (int) $post->ID === $posts_page ) {
		$slug = 'blog';
	}

	return restwell_get_primary_keyphrase( $slug );
}

/**
 * Resolve effective SEO title for a post.
 *
 * @param WP_Post $post Post object.
 * @return string
 */
function restwell_keyword_map_resolve_title( WP_Post $post ) {
	$title = trim( (string) get_post_meta( $post->ID, 'meta_title', true ) );
	if ( $title !== '' ) {
		return $title;
	}
	if ( function_exists( 'restwell_get_seo_default_meta_for_post_id' ) ) {
		$defaults = restwell_get_seo_default_meta_for_post_id( (int) $post->ID );
		if ( ! empty( $defaults['meta_title'] ) ) {
			return (string) $defaults['meta_title'];
		}
	}
	return trim( (string) get_the_title( $post ) );
}

/**
 * Whether a post is excluded from the indexable clash audit.
 *
 * @param WP_Post $post Post object.
 * @return bool
 */
function restwell_keyword_map_is_excluded( WP_Post $post ) {
	$slug = (string) $post->post_name;
	if ( in_array( $slug, restwell_keyword_map_excluded_slugs(), true ) ) {
		return true;
	}

	if ( (bool) get_post_meta( $post->ID, 'meta_noindex', true ) ) {
		return true;
	}

	if ( 'page-guest-guide.php' === get_page_template_slug( $post ) ) {
		return true;
	}

	return false;
}

/**
 * Collect indexable published pages and posts for the audit.
 *
 * @return array<int, WP_Post>
 */
function restwell_keyword_map_indexable_posts() {
	$query = new WP_Query(
		array(
			'post_type'              => array( 'page', 'post' ),
			'post_status'            => 'publish',
			'posts_per_page'         => 300,
			'no_found_rows'          => true,
			'update_post_meta_cache' => true,
			'update_post_term_cache' => false,
		)
	);

	$out = array();
	foreach ( $query->posts as $post ) {
		if ( ! $post instanceof WP_Post ) {
			continue;
		}
		if ( restwell_keyword_map_is_excluded( $post ) ) {
			continue;
		}
		$out[] = $post;
	}

	return $out;
}

/**
 * Run the cannibalisation audit across indexable pages.
 *
 * Reports shared focus keyphrases, identical H1s, and near-duplicate title tags.
 *
 * @return array{
 *   ok:bool,
 *   issues:array<int, array{type:string, message:string, slugs:array<int, string>}>,
 *   checked:int
 * }
 */
function restwell_keyword_cannibalisation_audit() {
	$posts  = restwell_keyword_map_indexable_posts();
	$issues = array();

	$by_kp    = array();
	$by_h1    = array();
	$titles   = array();

	foreach ( $posts as $post ) {
		$slug = (string) $post->post_name;
		$front = (int) get_option( 'page_on_front', 0 );
		if ( $front > 0 && (int) $post->ID === $front ) {
			$slug = 'home';
		}
		$posts_page = (int) get_option( 'page_for_posts', 0 );
		if ( $posts_page > 0 && (int) $post->ID === $posts_page ) {
			$slug = 'blog';
		}

		$kp = restwell_keyword_map_normalize( restwell_keyword_map_resolve_keyphrase( $post ) );
		if ( $kp !== '' ) {
			if ( ! isset( $by_kp[ $kp ] ) ) {
				$by_kp[ $kp ] = array();
			}
			$by_kp[ $kp ][] = $slug;
		}

		$h1 = restwell_keyword_map_normalize( restwell_keyword_map_resolve_h1( $post ) );
		if ( $h1 !== '' ) {
			if ( ! isset( $by_h1[ $h1 ] ) ) {
				$by_h1[ $h1 ] = array();
			}
			$by_h1[ $h1 ][] = $slug;
		}

		$titles[] = array(
			'slug' => $slug,
			'core' => restwell_keyword_map_title_core( restwell_keyword_map_resolve_title( $post ) ),
		);
	}

	foreach ( $by_kp as $kp => $slugs ) {
		$slugs = array_values( array_unique( $slugs ) );
		if ( count( $slugs ) < 2 ) {
			continue;
		}
		$issues[] = array(
			'type'    => 'keyphrase',
			'message' => sprintf(
				/* translators: 1: focus keyphrase, 2: comma-separated slugs */
				__( 'Shared focus keyphrase “%1$s” on: %2$s', 'restwell-retreats' ),
				$kp,
				implode( ', ', $slugs )
			),
			'slugs'   => $slugs,
		);
	}

	foreach ( $by_h1 as $h1 => $slugs ) {
		$slugs = array_values( array_unique( $slugs ) );
		if ( count( $slugs ) < 2 ) {
			continue;
		}
		$issues[] = array(
			'type'    => 'h1',
			'message' => sprintf(
				/* translators: 1: H1 text, 2: comma-separated slugs */
				__( 'Identical H1 “%1$s” on: %2$s', 'restwell-retreats' ),
				$h1,
				implode( ', ', $slugs )
			),
			'slugs'   => $slugs,
		);
	}

	$count = count( $titles );
	for ( $i = 0; $i < $count; $i++ ) {
		for ( $j = $i + 1; $j < $count; $j++ ) {
			if ( ! restwell_keyword_map_titles_near_duplicate( $titles[ $i ]['core'], $titles[ $j ]['core'] ) ) {
				continue;
			}
			$slugs    = array( $titles[ $i ]['slug'], $titles[ $j ]['slug'] );
			$issues[] = array(
				'type'    => 'title',
				'message' => sprintf(
					/* translators: 1: first slug, 2: second slug */
					__( 'Near-duplicate title tags on: %1$s and %2$s', 'restwell-retreats' ),
					$slugs[0],
					$slugs[1]
				),
				'slugs'   => $slugs,
			);
		}
	}

	// Also flag reserved map lanes that collide with an indexable page keyphrase.
	$seed_kps = array();
	foreach ( $by_kp as $kp => $slugs ) {
		$seed_kps[ $kp ] = $slugs;
	}
	foreach ( restwell_get_reserved_primary_keyphrases() as $reserved_slug => $reserved_kp ) {
		$norm = restwell_keyword_map_normalize( $reserved_kp );
		if ( $norm === '' || empty( $seed_kps[ $norm ] ) ) {
			continue;
		}
		// Reserved slug itself is fine; clash only if another live page owns the same KP.
		$others = array_values(
			array_filter(
				$seed_kps[ $norm ],
				static function ( $s ) use ( $reserved_slug ) {
					return $s !== $reserved_slug;
				}
			)
		);
		if ( empty( $others ) ) {
			continue;
		}
		$issues[] = array(
			'type'    => 'keyphrase',
			'message' => sprintf(
				/* translators: 1: reserved slug, 2: keyphrase, 3: live slugs */
				__( 'Reserved lane “%1$s” (%2$s) clashes with live pages: %3$s', 'restwell-retreats' ),
				$reserved_slug,
				$norm,
				implode( ', ', $others )
			),
			'slugs'   => array_merge( array( $reserved_slug ), $others ),
		);
	}

	return array(
		'ok'      => empty( $issues ),
		'issues'  => $issues,
		'checked' => count( $posts ),
	);
}

/**
 * Whether the cannibalisation audit may run for this request.
 *
 * Dev-only: WP_DEBUG, or a logged-in administrator. Never for public visitors.
 *
 * @return bool
 */
function restwell_keyword_cannibalisation_audit_may_run() {
	if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		return true;
	}
	return is_user_logged_in() && current_user_can( 'manage_options' );
}

/**
 * Log audit issues and surface an admin-bar notice when clashes exist.
 */
function restwell_keyword_cannibalisation_audit_maybe_report() {
	if ( ! restwell_keyword_cannibalisation_audit_may_run() ) {
		return;
	}

	// Avoid hammering the DB on every admin AJAX tick.
	if ( wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}

	static $ran = false;
	if ( $ran ) {
		return;
	}
	$ran = true;

	$cached = get_transient( 'restwell_keyword_cannibalisation_audit' );
	if ( is_array( $cached ) && isset( $cached['ok'], $cached['issues'] ) ) {
		$result = $cached;
	} else {
		$result = restwell_keyword_cannibalisation_audit();
		set_transient( 'restwell_keyword_cannibalisation_audit', $result, 5 * MINUTE_IN_SECONDS );
	}

	if ( empty( $result['issues'] ) ) {
		return;
	}

	foreach ( $result['issues'] as $issue ) {
		$message = isset( $issue['message'] ) ? (string) $issue['message'] : '';
		if ( $message === '' ) {
			continue;
		}
		// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log -- intentional SEO audit signal for admins/debug.
		error_log( 'Restwell keyword cannibalisation: ' . $message );
	}
}
add_action( 'admin_init', 'restwell_keyword_cannibalisation_audit_maybe_report', 40 );
add_action( 'wp', 'restwell_keyword_cannibalisation_audit_maybe_report', 40 );

/**
 * Admin-bar node summarising the latest cannibalisation audit.
 *
 * @param WP_Admin_Bar $wp_admin_bar Admin bar.
 */
function restwell_keyword_cannibalisation_admin_bar( $wp_admin_bar ) {
	if ( ! restwell_keyword_cannibalisation_audit_may_run() ) {
		return;
	}
	if ( ! $wp_admin_bar instanceof WP_Admin_Bar ) {
		return;
	}

	$result = get_transient( 'restwell_keyword_cannibalisation_audit' );
	if ( ! is_array( $result ) ) {
		$result = restwell_keyword_cannibalisation_audit();
		set_transient( 'restwell_keyword_cannibalisation_audit', $result, 5 * MINUTE_IN_SECONDS );
	}

	$issue_count = isset( $result['issues'] ) ? count( (array) $result['issues'] ) : 0;
	if ( $issue_count < 1 ) {
		$title = __( 'SEO keyphrases: OK', 'restwell-retreats' );
		$meta  = array( 'class' => 'restwell-kw-audit-ok' );
	} else {
		$title = sprintf(
			/* translators: %d: number of clashes */
			__( 'SEO keyphrase clashes: %d', 'restwell-retreats' ),
			$issue_count
		);
		$meta = array( 'class' => 'restwell-kw-audit-bad' );
	}

	$wp_admin_bar->add_node(
		array(
			'id'    => 'restwell-kw-audit',
			'title' => esc_html( $title ),
			'href'  => admin_url( 'admin.php?page=restwell-seo' ),
			'meta'  => $meta,
		)
	);

	if ( $issue_count < 1 || empty( $result['issues'] ) ) {
		return;
	}

	foreach ( array_slice( (array) $result['issues'], 0, 8 ) as $i => $issue ) {
		$msg = isset( $issue['message'] ) ? (string) $issue['message'] : '';
		if ( $msg === '' ) {
			continue;
		}
		$wp_admin_bar->add_node(
			array(
				'id'     => 'restwell-kw-audit-' . $i,
				'parent' => 'restwell-kw-audit',
				'title'  => esc_html( wp_html_excerpt( $msg, 120, '…' ) ),
			)
		);
	}
}
add_action( 'admin_bar_menu', 'restwell_keyword_cannibalisation_admin_bar', 100 );
