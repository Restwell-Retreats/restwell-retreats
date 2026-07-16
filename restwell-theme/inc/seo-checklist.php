<?php
/**
 * SEO checklist helpers for All pages list + Site-wide screen.
 *
 * Plain-language flags (meta length, keyphrase, OG, site-wide verification/analytics).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Build a checklist summary array from discrete check rows.
 *
 * @param array<int, array{id:string,label:string,state:string}> $checks Check rows (ok|warn|bad).
 * @param WP_Post                                                $post   Post (for noindex).
 * @return array{
 *   status:string,
 *   bad:int,
 *   warn:int,
 *   ok:int,
 *   issues:array<int, array{id:string,severity:string,message:string}>
 * }
 */
function restwell_seo_checklist_build_summary_from_checks( array $checks, WP_Post $post ): array {
	$bad    = 0;
	$warn   = 0;
	$ok     = 0;
	$issues = array();

	foreach ( $checks as $check ) {
		$state = isset( $check['state'] ) ? (string) $check['state'] : 'ok';
		if ( 'bad' === $state ) {
			++$bad;
			$issues[] = array(
				'id'       => (string) ( $check['id'] ?? '' ),
				'severity' => 'error',
				'message'  => (string) ( $check['label'] ?? '' ),
			);
		} elseif ( 'warn' === $state ) {
			++$warn;
			$issues[] = array(
				'id'       => (string) ( $check['id'] ?? '' ),
				'severity' => 'warn',
				'message'  => (string) ( $check['label'] ?? '' ),
			);
		} else {
			++$ok;
		}
	}

	$noindex = (bool) get_post_meta( $post->ID, 'meta_noindex', true );
	if ( $noindex && 'publish' === $post->post_status ) {
		++$warn;
		$issues[] = array(
			'id'       => 'noindex',
			'severity' => 'warn',
			'message'  => __( 'Hidden from Google (noindex is on)', 'restwell-retreats' ),
		);
	}

	if ( $bad > 0 ) {
		$status = 'bad';
	} elseif ( $warn > 0 ) {
		$status = 'warn';
	} else {
		$status = 'ok';
	}

	return array(
		'status' => $status,
		'bad'    => $bad,
		'warn'   => $warn,
		'ok'     => $ok,
		'issues' => $issues,
	);
}

/**
 * Resolve focus keyphrase, SEO title, and meta description (saved meta, else defaults).
 *
 * @param WP_Post $post Post or page.
 * @return array{focus_keyphrase:string,meta_title:string,meta_description:string}
 */
function restwell_seo_checklist_effective_meta( WP_Post $post ): array {
	$focus = (string) get_post_meta( $post->ID, 'focus_keyphrase', true );
	$title = (string) get_post_meta( $post->ID, 'meta_title', true );
	$desc  = (string) get_post_meta( $post->ID, 'meta_description', true );

	$defaults = function_exists( 'restwell_get_seo_default_meta_for_post_id' )
		? restwell_get_seo_default_meta_for_post_id( $post->ID )
		: array();

	if ( $focus === '' && ! empty( $defaults['focus_keyphrase'] ) ) {
		$focus = (string) $defaults['focus_keyphrase'];
	}
	if ( $title === '' && ! empty( $defaults['meta_title'] ) ) {
		$title = (string) $defaults['meta_title'];
	}
	if ( $desc === '' && ! empty( $defaults['meta_description'] ) ) {
		$desc = (string) $defaults['meta_description'];
	}

	if ( $title === '' ) {
		$title = (string) $post->post_title;
	}

	return array(
		'focus_keyphrase'  => $focus,
		'meta_title'       => $title,
		'meta_description' => $desc,
	);
}

/**
 * Lightweight SEO checks for the All pages / Blog posts list (no content aggregation).
 *
 * Covers title length, description length, keyphrase presence in title/description,
 * OG/featured image, plus noindex via restwell_seo_checklist_build_summary_from_checks().
 * Full eight-check analysis (headings, word count, internal links) stays on the edit screen.
 *
 * @param WP_Post $post Post or page.
 * @return array{
 *   status:string,
 *   bad:int,
 *   warn:int,
 *   ok:int,
 *   issues:array<int, array{id:string,severity:string,message:string}>
 * }
 */
function restwell_seo_checklist_summarize_post_list( WP_Post $post ): array {
	$meta       = restwell_seo_checklist_effective_meta( $post );
	$focus_kp   = $meta['focus_keyphrase'];
	$title      = $meta['meta_title'];
	$desc       = $meta['meta_description'];
	$kp         = function_exists( 'restwell_seo_admin_normalize_for_keyphrase_match' )
		? restwell_seo_admin_normalize_for_keyphrase_match( $focus_kp )
		: strtolower( trim( $focus_kp ) );
	$title_l    = function_exists( 'restwell_seo_admin_normalize_for_keyphrase_match' )
		? restwell_seo_admin_normalize_for_keyphrase_match( $title )
		: strtolower( trim( $title ) );
	$desc_l     = function_exists( 'restwell_seo_admin_normalize_for_keyphrase_match' )
		? restwell_seo_admin_normalize_for_keyphrase_match( $desc )
		: strtolower( trim( $desc ) );
	$title_len  = mb_strlen( $title );
	$desc_len   = mb_strlen( $desc );
	$has_og     = (bool) get_post_meta( $post->ID, 'og_image_id', true ) || has_post_thumbnail( $post->ID );
	$checks     = array();

	if ( $kp === '' ) {
		$checks[] = array(
			'id'    => 'kp_title',
			'label' => __( 'No focus keyphrase set (optional but recommended)', 'restwell-retreats' ),
			'state' => 'warn',
		);
		$checks[] = array(
			'id'    => 'kp_desc',
			'label' => __( 'Focus keyphrase in meta description - set a keyphrase first', 'restwell-retreats' ),
			'state' => 'warn',
		);
	} else {
		$checks[] = array(
			'id'    => 'kp_title',
			'label' => __( 'Focus keyphrase in SEO title', 'restwell-retreats' ),
			'state' => str_contains( $title_l, $kp ) ? 'ok' : 'bad',
		);
		$checks[] = array(
			'id'    => 'kp_desc',
			'label' => __( 'Focus keyphrase in meta description', 'restwell-retreats' ),
			'state' => str_contains( $desc_l, $kp ) ? 'ok' : 'bad',
		);
	}

	if ( $title_len >= 50 && $title_len <= 60 ) {
		$title_state = 'ok';
	} elseif ( $title_len >= 40 ) {
		$title_state = 'warn';
	} else {
		$title_state = 'bad';
	}
	$checks[] = array(
		'id'    => 'title_len',
		'label' => sprintf(
			/* translators: %d - character count */
			__( 'SEO title length: %d characters (ideal: 50-60)', 'restwell-retreats' ),
			$title_len
		),
		'state' => $title_state,
	);

	if ( $desc_len >= 120 && $desc_len <= 160 ) {
		$desc_state = 'ok';
	} elseif ( $desc_len >= 100 ) {
		$desc_state = 'warn';
	} else {
		$desc_state = 'bad';
	}
	$checks[] = array(
		'id'    => 'desc_len',
		'label' => sprintf(
			/* translators: %d - character count */
			__( 'Meta description length: %d characters (ideal: 120-160)', 'restwell-retreats' ),
			$desc_len
		),
		'state' => $desc_state,
	);

	$checks[] = array(
		'id'    => 'og_image',
		'label' => __( 'Featured or OG image is set', 'restwell-retreats' ),
		'state' => $has_og ? 'ok' : 'bad',
	);

	return restwell_seo_checklist_build_summary_from_checks( $checks, $post );
}

/**
 * Full SEO summary for one post (eight content checks). Prefer the list scorer in tables.
 *
 * @param WP_Post $post Post or page.
 * @return array{
 *   status:string,
 *   bad:int,
 *   warn:int,
 *   ok:int,
 *   issues:array<int, array{id:string,severity:string,message:string}>
 * }
 */
function restwell_seo_checklist_summarize_post( WP_Post $post ): array {
	$focus = (string) get_post_meta( $post->ID, 'focus_keyphrase', true );
	$title = (string) get_post_meta( $post->ID, 'meta_title', true );
	$desc  = (string) get_post_meta( $post->ID, 'meta_description', true );

	$checks = function_exists( 'restwell_seo_admin_run_checks' )
		? restwell_seo_admin_run_checks( $post, $focus, $title, $desc )
		: array();

	return restwell_seo_checklist_build_summary_from_checks( $checks, $post );
}

/**
 * Map of normalised focus keyphrases → post IDs (published pages + posts).
 *
 * Used for a light cannibalisation warning in the SEO list.
 *
 * @return array<string, array<int, int>>
 */
function restwell_seo_checklist_keyphrase_index(): array {
	static $cache = null;
	if ( null !== $cache ) {
		return $cache;
	}

	$cache = array();
	$query = new WP_Query(
		array(
			'post_type'              => array( 'page', 'post' ),
			'post_status'            => 'publish',
			'posts_per_page'         => 200,
			'fields'                 => 'ids',
			'no_found_rows'          => true,
			'update_post_meta_cache' => true,
			'update_post_term_cache' => false,
		)
	);

	foreach ( $query->posts as $post_id ) {
		$post_id = (int) $post_id;
		$kp      = (string) get_post_meta( $post_id, 'focus_keyphrase', true );
		if ( $kp === '' && function_exists( 'restwell_get_seo_default_meta_for_post_id' ) ) {
			$defaults = restwell_get_seo_default_meta_for_post_id( $post_id );
			$kp       = ! empty( $defaults['focus_keyphrase'] ) ? (string) $defaults['focus_keyphrase'] : '';
		}
		if ( $kp === '' ) {
			continue;
		}
		$key = function_exists( 'restwell_seo_admin_normalize_for_keyphrase_match' )
			? restwell_seo_admin_normalize_for_keyphrase_match( $kp )
			: strtolower( trim( $kp ) );
		if ( $key === '' ) {
			continue;
		}
		if ( ! isset( $cache[ $key ] ) ) {
			$cache[ $key ] = array();
		}
		$cache[ $key ][] = $post_id;
	}

	return $cache;
}

/**
 * Other published posts sharing this post's focus keyphrase.
 *
 * @param WP_Post $post Post.
 * @return array<int, int> Other post IDs.
 */
function restwell_seo_checklist_duplicate_keyphrase_ids( WP_Post $post ): array {
	$kp = (string) get_post_meta( $post->ID, 'focus_keyphrase', true );
	if ( $kp === '' && function_exists( 'restwell_get_seo_default_meta_for_post_id' ) ) {
		$defaults = restwell_get_seo_default_meta_for_post_id( $post->ID );
		$kp       = ! empty( $defaults['focus_keyphrase'] ) ? (string) $defaults['focus_keyphrase'] : '';
	}
	if ( $kp === '' ) {
		return array();
	}

	$key = function_exists( 'restwell_seo_admin_normalize_for_keyphrase_match' )
		? restwell_seo_admin_normalize_for_keyphrase_match( $kp )
		: strtolower( trim( $kp ) );

	$index = restwell_seo_checklist_keyphrase_index();
	if ( empty( $index[ $key ] ) || count( $index[ $key ] ) < 2 ) {
		return array();
	}

	return array_values(
		array_filter(
			$index[ $key ],
			static function ( $id ) use ( $post ) {
				return (int) $id !== (int) $post->ID;
			}
		)
	);
}

/**
 * Short badge label for a post summary.
 *
 * @param array{status:string,bad:int,warn:int} $summary Summary from restwell_seo_checklist_summarize_post().
 * @return string
 */
function restwell_seo_checklist_badge_label( array $summary ): string {
	$status = $summary['status'] ?? 'ok';
	$bad    = (int) ( $summary['bad'] ?? 0 );
	$warn   = (int) ( $summary['warn'] ?? 0 );

	if ( 'ok' === $status ) {
		return __( 'Looking good', 'restwell-retreats' );
	}

	$total = $bad + $warn;
	if ( $bad > 0 ) {
		return sprintf(
			/* translators: %d: number of issues */
			_n( '%d must-fix', '%d must-fix', $total, 'restwell-retreats' ),
			$total
		);
	}

	return sprintf(
		/* translators: %d: number of suggestions */
		_n( '%d suggestion', '%d suggestions', $warn, 'restwell-retreats' ),
		$warn
	);
}

/**
 * Site-wide SEO health checks (verification, analytics, business schema, GEO).
 *
 * @return array<int, array{id:string,severity:string,message:string,field:string}>
 */
function restwell_seo_checklist_sitewide(): array {
	$issues = array();

	// Match schema/form fallbacks so unset options are not flagged while the live site still outputs defaults.
	$phone = trim( (string) get_option( 'restwell_phone_number', '01622 809881' ) );
	if ( $phone === '' ) {
		$issues[] = array(
			'id'       => 'phone',
			'severity' => 'error',
			'message'  => __( 'Phone number is missing (used in the footer and for Google business schema).', 'restwell-retreats' ),
			'field'    => 'restwell_phone_number',
		);
	}

	$street    = trim( (string) get_option( 'restwell_business_street', 'Vinters Business Park' ) );
	$locality  = trim( (string) get_option( 'restwell_business_locality', 'Maidstone' ) );
	$postcode  = trim( (string) get_option( 'restwell_business_postcode', 'ME14 5NZ' ) );
	$region    = trim( (string) get_option( 'restwell_business_region', 'Kent' ) );
	$addr_bits = array_filter( array( $street, $locality, $postcode ) );
	if ( count( $addr_bits ) < 3 ) {
		$issues[] = array(
			'id'       => 'address',
			'severity' => 'error',
			'message'  => __( 'Business address is incomplete — street, town, and postcode help LocalBusiness schema match your Google Business Profile.', 'restwell-retreats' ),
			'field'    => 'restwell_business_street',
		);
	} elseif ( $region === '' ) {
		$issues[] = array(
			'id'       => 'region',
			'severity' => 'warn',
			'message'  => __( 'County / region is empty (recommended for local SEO schema).', 'restwell-retreats' ),
			'field'    => 'restwell_business_region',
		);
	}

	$gsc = trim( (string) get_option( 'restwell_gsc_verification', '' ) );
	if ( $gsc === '' ) {
		$issues[] = array(
			'id'       => 'gsc',
			'severity' => 'warn',
			'message'  => __( 'Google Search Console verification is not set — you cannot confirm indexing or CWV in GSC until this is done.', 'restwell-retreats' ),
			'field'    => 'restwell_gsc_verification',
		);
	}

	$bing = trim( (string) get_option( 'restwell_bing_verification', '' ) );
	if ( $bing === '' ) {
		$issues[] = array(
			'id'       => 'bing',
			'severity' => 'info',
			'message'  => __( 'Bing Webmaster verification is empty (optional, but useful for Bing / Copilot discovery).', 'restwell-retreats' ),
			'field'    => 'restwell_bing_verification',
		);
	}

	$ga4 = trim( (string) get_option( 'restwell_ga4_measurement_id', '' ) );
	if ( $ga4 === '' ) {
		$issues[] = array(
			'id'       => 'ga4_unset',
			'severity' => 'warn',
			'message'  => __( 'Google Analytics 4 is not set — you will not see landing-page or enquiry conversion data.', 'restwell-retreats' ),
			'field'    => 'restwell_ga4_measurement_id',
		);
	} elseif ( ! preg_match( '/^G-[A-Z0-9]+$/i', $ga4 ) ) {
		$issues[] = array(
			'id'       => 'ga4_invalid',
			'severity' => 'error',
			'message'  => __( 'GA4 ID looks wrong — it should look like G-XXXXXXXXXX.', 'restwell-retreats' ),
			'field'    => 'restwell_ga4_measurement_id',
		);
	}

	$metricool = trim( (string) get_option( 'restwell_metricool_hash', '' ) );
	if ( $metricool !== '' && ! preg_match( '/^[a-f0-9]{32}$/i', $metricool ) ) {
		$issues[] = array(
			'id'       => 'metricool_invalid',
			'severity' => 'error',
			'message'  => __( 'Metricool hash looks wrong — it should be a 32-character hex string.', 'restwell-retreats' ),
			'field'    => 'restwell_metricool_hash',
		);
	}

	$mode = (string) get_option( 'restwell_analytics_load_mode', 'head' );
	if ( $ga4 !== '' && 'head' === $mode ) {
		$issues[] = array(
			'id'       => 'analytics_mode',
			'severity' => 'info',
			'message'  => __( 'Analytics loads in the head immediately. For page speed or a cookie banner, consider Footer deferred or Consent-gated.', 'restwell-retreats' ),
			'field'    => 'restwell_analytics_load_mode',
		);
	}

	$llms_file = get_template_directory() . '/llms.txt';
	if ( ! is_readable( $llms_file ) ) {
		$issues[] = array(
			'id'       => 'llms',
			'severity' => 'warn',
			'message'  => __( 'llms.txt is missing from the theme — AI search crawlers use this for GEO / AI Overviews readiness.', 'restwell-retreats' ),
			'field'    => '',
		);
	}

	$social = function_exists( 'restwell_get_social_profile_urls' ) ? restwell_get_social_profile_urls() : array();
	if ( empty( $social ) ) {
		$issues[] = array(
			'id'       => 'social',
			'severity' => 'warn',
			'message'  => __( 'No social profile URLs found — schema sameAs and footer social links will be empty.', 'restwell-retreats' ),
			'field'    => '',
		);
	}

	return $issues;
}

/**
 * Count site-wide issues by severity.
 *
 * @param array<int, array{severity:string}> $issues Issues.
 * @return array{error:int,warn:int,info:int}
 */
function restwell_seo_checklist_count_severities( array $issues ): array {
	$counts = array(
		'error' => 0,
		'warn'  => 0,
		'info'  => 0,
	);
	foreach ( $issues as $issue ) {
		$sev = isset( $issue['severity'] ) ? (string) $issue['severity'] : 'info';
		if ( isset( $counts[ $sev ] ) ) {
			++$counts[ $sev ];
		}
	}
	return $counts;
}
