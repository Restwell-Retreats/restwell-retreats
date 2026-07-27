<?php
/**
 * Page Content Fields checklist: required content + SEO alignment checks.
 *
 * Plain-language flags for editors (empty H1, missing keyphrase in H1 / SEO title, etc.).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Resolve which meta key holds the page H1 for this page.
 *
 * @param WP_Post|null $post Page post.
 * @return string Meta key or empty.
 */
function restwell_page_content_h1_meta_key( $post = null ) {
	if ( ! $post instanceof WP_Post ) {
		return '';
	}

	$front_id = (int) get_option( 'page_on_front', 0 );
	if ( $front_id > 0 && (int) $post->ID === $front_id ) {
		return 'hero_heading';
	}

	$template = (string) get_page_template_slug( $post );
	$map      = array(
		'template-property.php'         => 'prop_hero_heading',
		'template-how-it-works.php'     => 'hiw_heading',
		'template-accessibility.php'    => 'acc_heading',
		'template-who-its-for.php'      => 'wif_heading',
		'template-whitstable-guide.php' => 'wg_heading',
		'template-faq.php'              => 'faq_heading',
		'template-enquire.php'          => 'enq_heading',
		'template-pricing.php'          => 'pricing_heading',
		'template-resources.php'        => 'res_heading',
		'template-privacy-policy.php'   => 'legal_heading',
		'template-terms-and-conditions.php' => 'legal_heading',
		'template-accessibility-policy.php' => 'legal_heading',
	);

	return isset( $map[ $template ] ) ? $map[ $template ] : '';
}

/**
 * Required content fields for a page (meta_key => short label).
 *
 * Keep this list short — only must-haves, not every optional field.
 *
 * @param WP_Post|null $post Page post.
 * @return array<string, string>
 */
function restwell_page_content_required_fields( $post = null ) {
	if ( ! $post instanceof WP_Post ) {
		return array();
	}

	$h1 = restwell_page_content_h1_meta_key( $post );
	$required = array();
	if ( $h1 !== '' ) {
		$required[ $h1 ] = __( 'Page heading (H1)', 'restwell-retreats' );
	}

	$front_id = (int) get_option( 'page_on_front', 0 );
	if ( $front_id > 0 && (int) $post->ID === $front_id ) {
		$required['hero_media_id']          = __( 'Hero background image or video', 'restwell-retreats' );
		$required['hero_cta_primary_label'] = __( 'Hero primary button label', 'restwell-retreats' );
		$required['hero_cta_primary_url']   = __( 'Hero primary button URL', 'restwell-retreats' );
		return $required;
	}

	$template = (string) get_page_template_slug( $post );
	switch ( $template ) {
		case 'template-property.php':
			$required['prop_hero_image_id'] = __( 'Hero image', 'restwell-retreats' );
			$required['prop_hero_cta_text'] = __( 'Hero primary button label', 'restwell-retreats' );
			$required['prop_hero_cta_url']  = __( 'Hero primary button URL', 'restwell-retreats' );
			break;
		case 'template-how-it-works.php':
			$required['hiw_intro'] = __( 'Intro paragraph', 'restwell-retreats' );
			break;
		case 'template-enquire.php':
			$required['enq_intro'] = __( 'Intro paragraph', 'restwell-retreats' );
			break;
		case 'template-pricing.php':
			$required['pricing_subheading'] = __( 'Hero subheading', 'restwell-retreats' );
			$required['pricing_intro']      = __( 'Intro paragraph', 'restwell-retreats' );
			break;
		case 'template-faq.php':
			$required['faq_intro'] = __( 'Intro paragraph', 'restwell-retreats' );
			break;
		case 'template-who-its-for.php':
			$required['wif_intro'] = __( 'Intro paragraph', 'restwell-retreats' );
			break;
		case 'template-whitstable-guide.php':
			$required['wg_intro'] = __( 'Intro paragraph', 'restwell-retreats' );
			break;
		case 'template-accessibility.php':
			$required['acc_intro'] = __( 'Intro paragraph', 'restwell-retreats' );
			break;
		case 'template-resources.php':
			$required['res_intro'] = __( 'Intro paragraph', 'restwell-retreats' );
			break;
		case 'template-privacy-policy.php':
		case 'template-terms-and-conditions.php':
		case 'template-accessibility-policy.php':
			$required['legal_body_html'] = __( 'Document body', 'restwell-retreats' );
			break;
	}

	return $required;
}

/**
 * Find which Page Content Fields section contains a meta key.
 *
 * @param WP_Post $post Page post.
 * @param string  $meta_key Meta key.
 * @return string Section label or empty.
 */
function restwell_page_content_section_for_field( WP_Post $post, string $meta_key ): string {
	if ( ! function_exists( 'restwell_get_page_content_field_definitions' ) ) {
		return '';
	}
	$groups = restwell_get_page_content_field_definitions( $post );
	foreach ( $groups as $section => $items ) {
		if ( isset( $items[ $meta_key ] ) ) {
			return (string) $section;
		}
	}
	return '';
}

/**
 * Normalize text for keyphrase matching (same idea as SEO admin checks).
 *
 * @param string $text Raw text.
 * @return string
 */
function restwell_page_content_normalize_text( string $text ): string {
	$text = strtolower( trim( wp_strip_all_tags( $text ) ) );
	$text = (string) preg_replace( '/\s+/u', ' ', $text );
	$text = (string) preg_replace( '/[\x{2018}\x{2019}\x{2032}]/u', "'", $text );
	return $text;
}

/**
 * Effective SEO values for a page (saved meta, else theme defaults).
 *
 * @param WP_Post $post Page post.
 * @return array{focus_keyphrase:string,meta_title:string,meta_description:string}
 */
function restwell_page_content_effective_seo( WP_Post $post ): array {
	$defaults = function_exists( 'restwell_get_seo_default_meta_for_post_id' )
		? restwell_get_seo_default_meta_for_post_id( $post->ID )
		: array();

	$focus = (string) get_post_meta( $post->ID, 'focus_keyphrase', true );
	$title = (string) get_post_meta( $post->ID, 'meta_title', true );
	$desc  = (string) get_post_meta( $post->ID, 'meta_description', true );

	if ( $focus === '' && ! empty( $defaults['focus_keyphrase'] ) ) {
		$focus = (string) $defaults['focus_keyphrase'];
	}
	if ( $title === '' && ! empty( $defaults['meta_title'] ) ) {
		$title = (string) $defaults['meta_title'];
	}
	if ( $desc === '' && ! empty( $defaults['meta_description'] ) ) {
		$desc = (string) $defaults['meta_description'];
	}

	return array(
		'focus_keyphrase'  => $focus,
		'meta_title'       => $title,
		'meta_description' => $desc,
	);
}

/**
 * Run content + SEO alignment checks for a page.
 *
 * @param WP_Post $post Page post.
 * @return array<int, array{id:string,severity:string,message:string,field:string,section:string}>
 */
function restwell_page_content_run_checks( WP_Post $post ): array {
	$issues   = array();
	$required = restwell_page_content_required_fields( $post );

	foreach ( $required as $key => $label ) {
		$val = trim( (string) get_post_meta( $post->ID, $key, true ) );
		if ( $val === '' || $val === '0' ) {
			$issues[] = array(
				'id'       => 'required_' . $key,
				'severity' => 'error',
				'message'  => sprintf(
					/* translators: %s: field label */
					__( 'Missing: %s', 'restwell-retreats' ),
					$label
				),
				'field'    => $key,
				'section'  => restwell_page_content_section_for_field( $post, $key ),
			);
		}
	}

	$h1_key = restwell_page_content_h1_meta_key( $post );
	$h1     = $h1_key !== '' ? trim( (string) get_post_meta( $post->ID, $h1_key, true ) ) : '';
	$seo    = restwell_page_content_effective_seo( $post );
	$kp     = restwell_page_content_normalize_text( $seo['focus_keyphrase'] );
	$h1_n   = restwell_page_content_normalize_text( $h1 );
	$title_n = restwell_page_content_normalize_text( $seo['meta_title'] );
	$desc_n  = restwell_page_content_normalize_text( $seo['meta_description'] );

	if ( $kp === '' ) {
		$issues[] = array(
			'id'       => 'seo_no_keyphrase',
			'severity' => 'warn',
			'message'  => __( 'No focus keyphrase set for this page (set it under SEO → Edit SEO).', 'restwell-retreats' ),
			'field'    => '',
			'section'  => '',
		);
	} else {
		if ( $h1 !== '' && ! str_contains( $h1_n, $kp ) ) {
			$issues[] = array(
				'id'       => 'seo_kp_not_in_h1',
				'severity' => 'warn',
				'message'  => sprintf(
					/* translators: %s: focus keyphrase */
					__( 'H1 does not include the focus keyphrase (“%s”). It does not need to match the SEO title word-for-word — but the keyphrase should appear in the H1.', 'restwell-retreats' ),
					$seo['focus_keyphrase']
				),
				'field'    => $h1_key,
				'section'  => restwell_page_content_section_for_field( $post, $h1_key ),
			);
		}

		if ( $seo['meta_title'] !== '' && ! str_contains( $title_n, $kp ) ) {
			$issues[] = array(
				'id'       => 'seo_kp_not_in_title',
				'severity' => 'warn',
				'message'  => sprintf(
					/* translators: %s: focus keyphrase */
					__( 'SEO title does not include the focus keyphrase (“%s”). Fix under SEO → Edit SEO.', 'restwell-retreats' ),
					$seo['focus_keyphrase']
				),
				'field'    => '',
				'section'  => '',
			);
		}

		if ( $seo['meta_description'] !== '' && ! str_contains( $desc_n, $kp ) ) {
			$issues[] = array(
				'id'       => 'seo_kp_not_in_desc',
				'severity' => 'warn',
				'message'  => sprintf(
					/* translators: %s: focus keyphrase */
					__( 'Meta description does not include the focus keyphrase (“%s”). Fix under SEO → Edit SEO.', 'restwell-retreats' ),
					$seo['focus_keyphrase']
				),
				'field'    => '',
				'section'  => '',
			);
		}
	}

	$title_len = mb_strlen( $seo['meta_title'] );
	if ( $seo['meta_title'] !== '' && ( $title_len < 40 || $title_len > 60 ) ) {
		$issues[] = array(
			'id'       => 'seo_title_length',
			'severity' => 'info',
			'message'  => sprintf(
				/* translators: %d: character count */
				__( 'SEO title is %d characters (ideal about 50–60). Adjust under SEO → Edit SEO.', 'restwell-retreats' ),
				$title_len
			),
			'field'    => '',
			'section'  => '',
		);
	}

	$desc_len = mb_strlen( $seo['meta_description'] );
	if ( $seo['meta_description'] === '' ) {
		$issues[] = array(
			'id'       => 'seo_no_desc',
			'severity' => 'warn',
			'message'  => __( 'No meta description set (or default missing). Add one under SEO → Edit SEO.', 'restwell-retreats' ),
			'field'    => '',
			'section'  => '',
		);
	} elseif ( $desc_len < 100 || $desc_len > 160 ) {
		$issues[] = array(
			'id'       => 'seo_desc_length',
			'severity' => 'info',
			'message'  => sprintf(
				/* translators: %d: character count */
				__( 'Meta description is %d characters (ideal about 120–160). Adjust under SEO → Edit SEO.', 'restwell-retreats' ),
				$desc_len
			),
			'field'    => '',
			'section'  => '',
		);
	}

	return $issues;
}

/**
 * Count checklist issues per section label.
 *
 * @param array<int, array{section:string}> $issues Issues list.
 * @return array<string, int>
 */
function restwell_page_content_issues_by_section( array $issues ): array {
	$counts = array();
	foreach ( $issues as $issue ) {
		$section = isset( $issue['section'] ) ? (string) $issue['section'] : '';
		if ( $section === '' ) {
			continue;
		}
		if ( ! isset( $counts[ $section ] ) ) {
			$counts[ $section ] = 0;
		}
		$counts[ $section ]++;
	}
	return $counts;
}
