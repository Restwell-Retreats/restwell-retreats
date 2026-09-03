<?php
/**
 * Frozen content migrations v29–v31.
 *
 * Loaded only when restwell_schema_version is below 32.
 * Do not add new migrate_* functions here.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Align stored privacy HTML and analytics load mode with enquiry consent + first-party CMP.
 */
function restwell_migrate_privacy_consent_v29() {
	if ( get_option( 'restwell_privacy_consent_v29', '' ) === '1' ) {
		return;
	}

	$mode    = (string) get_option( 'restwell_analytics_load_mode', '' );
	$allowed = array( 'head', 'footer_deferred', 'consent_gated' );
	if ( '' === $mode || ! in_array( $mode, $allowed, true ) || 'consent_gated' !== $mode ) {
		update_option( 'restwell_analytics_load_mode', 'consent_gated', false );
	}

	$page_by_path_or_template = static function ( $slug, $template ) {
		$page = get_page_by_path( $slug, OBJECT, 'page' );
		if ( $page instanceof WP_Post ) {
			return $page;
		}
		$found = get_pages(
			array(
				'meta_key'   => '_wp_page_template',
				'meta_value' => $template,
				'number'     => 1,
			)
		);
		return ( ! empty( $found ) && $found[0] instanceof WP_Post ) ? $found[0] : null;
	};

	$privacy = $page_by_path_or_template( 'privacy-policy', 'template-privacy-policy.php' );
	if ( $privacy instanceof WP_Post ) {
		$pid  = (int) $privacy->ID;
		$html = (string) get_post_meta( $pid, 'legal_body_html', true );
		if ( $html !== '' && (
			false !== strpos( $html, 'legitimate interests to respond to your enquiry' )
			|| false !== strpos( $html, 'cookie controls shown on your first visit' )
		) ) {
			delete_post_meta( $pid, 'legal_body_html' );
		}

		$intro     = trim( (string) get_post_meta( $pid, 'legal_intro', true ) );
		$old_intro = 'Who is responsible for your data, what we collect when you enquire or book, cookies, retention, and your UK GDPR rights (including contacting the ICO).';
		$new_intro = 'Who is responsible for your data, what we collect on the enquiry form (including optional care notes), cookie choices, retention, and your UK GDPR rights (including contacting the ICO).';
		if ( $intro === $old_intro ) {
			update_post_meta( $pid, 'legal_intro', $new_intro );
		}
	}

	update_option( 'restwell_privacy_consent_v29', '1' );
}

/**
 * Site title, Funding & Support slug, homepage Partners/Testimonials seeds.
 */
function restwell_migrate_site_identity_v30() {
	if ( get_option( 'restwell_site_identity_v30', '' ) === '1' ) {
		return;
	}

	$blogname = trim( (string) get_option( 'blogname', '' ) );
	if ( '' === $blogname || 0 === strcasecmp( $blogname, 'restwell' ) ) {
		update_option( 'blogname', 'Restwell Retreats' );
	}

	$funding = get_page_by_path( 'funding-and-support', OBJECT, 'page' );
	$res     = get_page_by_path( 'resources', OBJECT, 'page' );
	if ( $res instanceof WP_Post && ! ( $funding instanceof WP_Post ) ) {
		$update = array(
			'ID'        => (int) $res->ID,
			'post_name' => 'funding-and-support',
		);
		if ( 'Resources' === $res->post_title ) {
			$update['post_title'] = 'Funding & Support';
		}
		wp_update_post( $update );
	}

	$blog_id = (int) get_option( 'page_for_posts', 0 );
	if ( $blog_id > 0 ) {
		$blog = get_post( $blog_id );
		if ( $blog instanceof WP_Post && in_array( $blog->post_name, array( 'news', 'uncategorized' ), true ) ) {
			wp_update_post(
				array(
					'ID'        => $blog_id,
					'post_name' => 'blog',
				)
			);
		}
	}

	$privacy = get_page_by_path( 'privacy-policy', OBJECT, 'page' );
	if ( $privacy instanceof WP_Post ) {
		$html = (string) get_post_meta( (int) $privacy->ID, 'legal_body_html', true );
		$old  = 'We keep enquiry and booking-related records for up to three years so we can answer follow-up questions and meet regulatory and insurance expectations. You can ask us to delete your data sooner where the law allows.';
		$new  = 'We keep enquiry and booking-related records for up to three years so we can answer follow-up questions and meet regulatory and insurance expectations. Optional care and accessibility notes are kept for a shorter period: 12 months if the enquiry does not become a booking, or 90 days after the stay if it does. You can ask us to delete your data sooner where the law allows.';
		if ( '' !== $html && false !== strpos( $html, $old ) ) {
			update_post_meta( (int) $privacy->ID, 'legal_body_html', str_replace( $old, $new, $html ) );
		}
	}

	$front_id = (int) get_option( 'page_on_front', 0 );
	if ( $front_id > 0 ) {
		$partner_swaps = array(
			'home_partners_label'    => array(
				'Trusted partners' => 'Behind Restwell',
			),
			'home_partners_heading'  => array(
				'Specialist Partners' => 'Who built it, and who we work with',
			),
			'home_partners_intro'    => array(
				'The full story of how we adapted Restwell, who built it, and who supports guests today.' => 'Specialist firms adapted the house.',
			),
			'home_partners_cta_text' => array(
				'See our journey' => 'Read the full story',
			),
			'home_partners_cta_url'  => array(
				'/how-it-works/' => '/our-story/',
			),
		);
		foreach ( $partner_swaps as $key => $map ) {
			$current = (string) get_post_meta( $front_id, $key, true );
			if ( isset( $map[ $current ] ) ) {
				update_post_meta( $front_id, $key, $map[ $current ] );
			}
		}

		$quote_1 = trim( (string) get_post_meta( $front_id, 'testimonial_1_quote', true ) );
		if ( '' === $quote_1 && function_exists( 'restwell_homepage_testimonial_hard_fallbacks' ) ) {
			$i = 1;
			foreach ( restwell_homepage_testimonial_hard_fallbacks() as $item ) {
				update_post_meta( $front_id, 'testimonial_' . $i . '_quote', $item['quote'] );
				update_post_meta( $front_id, 'testimonial_' . $i . '_name', $item['name'] );
				update_post_meta( $front_id, 'testimonial_' . $i . '_role', $item['role'] );
				++$i;
			}
			if ( '' === trim( (string) get_post_meta( $front_id, 'testimonial_label', true ) ) ) {
				update_post_meta( $front_id, 'testimonial_label', 'What guests say' );
			}
			if ( '' === trim( (string) get_post_meta( $front_id, 'testimonial_heading', true ) ) ) {
				update_post_meta( $front_id, 'testimonial_heading', 'What guests wrote after staying' );
			}
		}
	}

	flush_rewrite_rules( false );
	update_option( 'restwell_site_identity_v30', '1' );
}

/**
 * Re-assert consent_gated analytics and drop stale privacy HTML the v29 string match missed.
 */
function restwell_migrate_privacy_consent_v31() {
	if ( get_option( 'restwell_privacy_consent_v31', '' ) === '1' ) {
		return;
	}

	update_option( 'restwell_analytics_load_mode', 'consent_gated', false );

	$page = get_page_by_path( 'privacy-policy', OBJECT, 'page' );
	if ( ! ( $page instanceof WP_Post ) ) {
		$found = get_pages(
			array(
				'meta_key'   => '_wp_page_template',
				'meta_value' => 'template-privacy-policy.php',
				'number'     => 1,
			)
		);
		$page = ( ! empty( $found ) && $found[0] instanceof WP_Post ) ? $found[0] : null;
	}

	if ( $page instanceof WP_Post ) {
		$html = (string) get_post_meta( (int) $page->ID, 'legal_body_html', true );
		if ( $html !== '' ) {
			$lower = strtolower( $html );
			$stale = false !== strpos( $lower, 'legitimate interest' )
				|| false !== strpos( $lower, 'cookie controls shown on your first visit' )
				|| false !== strpos( $lower, 'care or accessibility information you choose to share' );
			if ( $stale ) {
				delete_post_meta( (int) $page->ID, 'legal_body_html' );
			}
		}
	}

	update_option( 'restwell_privacy_consent_v31', '1' );
}

/**
 * Register v29–v31 migration callbacks.
 */
function restwell_register_spent_migrations_v29_v31(): void {
	add_action( 'init', 'restwell_migrate_privacy_consent_v29', 78 );
	add_action( 'after_switch_theme', 'restwell_migrate_privacy_consent_v29', 69 );
	add_action( 'init', 'restwell_migrate_site_identity_v30', 79 );
	add_action( 'after_switch_theme', 'restwell_migrate_site_identity_v30', 70 );
	add_action( 'init', 'restwell_migrate_privacy_consent_v31', 80 );
	add_action( 'after_switch_theme', 'restwell_migrate_privacy_consent_v31', 71 );
}
