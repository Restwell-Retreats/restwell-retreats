<?php
/**
 * Page content field schema dispatcher. Per-template maps live in inc/page-meta/.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Build a field definition array.
 *
 * @param string $label Human-readable label shown in the metabox.
 * @param string $type  Field type: text | textarea | image | media | number.
 * @return array{label:string,type:string}
 */
function restwell_field( string $label, string $type = 'text' ): array {
	return array(
		'label' => $label,
		'type'  => $type,
	);
}

/**
 * Get field definitions for a page.
 *
 * @param WP_Post|null $post Page post or null.
 * @return array<string, array<string, array{label:string,type:string}>>
 */
function restwell_get_page_content_field_definitions( $post = null ) {
	$front_page_id = (int) get_option( 'page_on_front', 0 );
	if ( $post && (int) $post->ID === $front_page_id ) {
		return restwell_get_front_page_field_definitions();
	}
	$template = $post ? get_page_template_slug( $post ) : '';
	$map = array(
		'template-property.php'    => 'restwell_get_property_field_definitions',
		'template-how-it-works.php' => 'restwell_get_how_it_works_field_definitions',
		'template-accessibility.php' => 'restwell_get_accessibility_field_definitions',
		'template-who-its-for.php' => 'restwell_get_who_its_for_field_definitions',
		'template-whitstable-guide.php' => 'restwell_get_whitstable_guide_field_definitions',
		'template-faq.php'        => 'restwell_get_faq_field_definitions',
		'template-enquire.php'    => 'restwell_get_enquire_field_definitions',
		'template-pricing.php'    => 'restwell_get_pricing_field_definitions',
		'template-resources.php'           => 'restwell_get_resources_field_definitions',
		'template-care.php'                => 'restwell_get_care_field_definitions',
		'template-our-story.php'           => 'restwell_get_our_story_field_definitions',
		'template-privacy-policy.php'      => 'restwell_get_legal_policy_field_definitions',
		'template-terms-and-conditions.php' => 'restwell_get_legal_policy_field_definitions',
		'template-accessibility-policy.php' => 'restwell_get_legal_policy_field_definitions',
	);
	if ( isset( $map[ $template ] ) && is_callable( $map[ $template ] ) ) {
		return call_user_func( $map[ $template ] );
	}
	// Default template: optional hero background (used by page.php and index.php).
	return array(
		'Hero' => array(
			'page_hero_image_id' => restwell_field( __( 'Hero background (image or video, optional)', 'restwell-retreats' ), 'media' ),
		),
	);
}

/**
 * Theme default values for a page's Page content fields (same maps Theme Setup seeds).
 *
 * @param WP_Post|null $post Page post or null.
 * @return array<string, mixed>
 */
function restwell_get_page_content_defaults( $post = null ) {
	if ( ! $post instanceof WP_Post ) {
		return array();
	}

	$front_page_id = (int) get_option( 'page_on_front', 0 );
	if ( $front_page_id > 0 && (int) $post->ID === $front_page_id ) {
		return function_exists( 'restwell_get_theme_setup_defaults' )
			? restwell_get_theme_setup_defaults()
			: array();
	}

	$template = (string) get_page_template_slug( $post );
	$map      = array(
		'template-property.php'             => 'restwell_get_property_page_defaults',
		'template-how-it-works.php'         => 'restwell_get_how_it_works_page_defaults',
		'template-accessibility.php'        => 'restwell_get_accessibility_page_defaults',
		'template-who-its-for.php'          => 'restwell_get_who_its_for_page_defaults',
		'template-whitstable-guide.php'     => 'restwell_get_whitstable_guide_page_defaults',
		'template-faq.php'                  => 'restwell_get_faq_page_defaults',
		'template-enquire.php'              => 'restwell_get_enquire_page_defaults',
		'template-pricing.php'              => 'restwell_get_pricing_page_defaults',
		'template-resources.php'            => 'restwell_get_resources_page_defaults',
		'template-care.php'                 => 'restwell_get_care_page_defaults',
		'template-our-story.php'            => 'restwell_get_our_story_page_defaults',
		'page-guest-guide.php'              => 'restwell_get_guest_guide_page_defaults',
		'template-privacy-policy.php'       => 'restwell_get_privacy_policy_page_defaults',
		'template-terms-and-conditions.php' => 'restwell_get_terms_conditions_page_defaults',
		'template-accessibility-policy.php' => 'restwell_get_accessibility_policy_page_defaults',
	);

	if ( ! isset( $map[ $template ] ) || ! is_callable( $map[ $template ] ) ) {
		return array();
	}

	$defaults = call_user_func( $map[ $template ] );
	return is_array( $defaults ) ? $defaults : array();
}

/**
 * Effective Page content value: stored meta, else theme default when the key was never saved.
 *
 * @param int    $post_id Post ID.
 * @param string $key     Meta key.
 * @param array  $defaults Optional defaults map (looked up from the post when empty).
 * @return mixed
 */
function restwell_page_content_meta_or_default( $post_id, $key, array $defaults = array() ) {
	$post_id = (int) $post_id;
	if ( empty( $defaults ) && $post_id > 0 ) {
		$post = get_post( $post_id );
		if ( $post instanceof WP_Post ) {
			$defaults = restwell_get_page_content_defaults( $post );
		}
	}

	if ( function_exists( 'restwell_post_meta_or_default' ) ) {
		return restwell_post_meta_or_default( $post_id, $key, $defaults );
	}

	if ( $post_id > 0 && metadata_exists( 'post', $post_id, $key ) ) {
		return get_post_meta( $post_id, $key, true );
	}

	return $defaults[ $key ] ?? '';
}

/**
 * Page-content string for templates: stored meta / theme default, else hard fallback.
 *
 * Use the fallback for current live copy so a missing key never blanks the H1.
 *
 * @param int    $post_id  Page ID.
 * @param string $key      Meta key.
 * @param string $fallback Hardcoded fallback when meta and defaults are empty.
 * @return string
 */
function restwell_page_content_text( $post_id, $key, $fallback = '' ) {
	$post_id = absint( $post_id );
	$val     = '';
	if ( $post_id > 0 && function_exists( 'restwell_page_content_meta_or_default' ) ) {
		$val = trim( (string) restwell_page_content_meta_or_default( $post_id, $key ) );
	}
	if ( $val === '' && is_string( $fallback ) ) {
		$val = $fallback;
	}
	if ( $val !== '' && function_exists( 'restwell_normalize_editorial_dashes' ) ) {
		$val = restwell_normalize_editorial_dashes( $val );
	}
	return $val;
}

/**
 * Honest editor note for the Page content metabox (what actually goes live).
 *
 * @param WP_Post|null $post Page being edited.
 * @return string Plain text for esc_html().
 */
function restwell_page_content_editor_notice( $post = null ) {
	if ( ! $post instanceof WP_Post ) {
		return '';
	}

	$front_id = (int) get_option( 'page_on_front', 0 );
	if ( $front_id > 0 && (int) $post->ID === $front_id ) {
		return __( 'On the homepage, the live site reads the Hero heading and intro, plus hero media. Guest reviews are live Google reviews when the Places API is set, otherwise the Testimonials tab — paste the guest’s words, do not rewrite. Partners heading, intro, CTA and logos go live from the Partners tab (theme images until a logo is uploaded). Search titles and meta live under SEO in the admin menu.', 'restwell-retreats' );
	}

	$template = (string) get_page_template_slug( $post );
	$legal    = array(
		'template-privacy-policy.php',
		'template-terms-and-conditions.php',
		'template-accessibility-policy.php',
	);
	if ( in_array( $template, $legal, true ) ) {
		return __( 'Label, heading, intro, and body HTML go live. The hero image is used when one is set (otherwise the theme stock coastline). Search titles and meta live under SEO in the admin menu.', 'restwell-retreats' );
	}

	if ( 'template-faq.php' === $template ) {
		return __( 'Heading, intro, and the FAQ question/answer fields on this page go live. Homepage FAQ is in the theme (inc/homepage-faq.php). How It Works has its own FAQ fields. Search titles and meta live under SEO in the admin menu.', 'restwell-retreats' );
	}

	if ( 'template-enquire.php' === $template ) {
		return __( 'Hero heading and intro go live. Success heading and bodies appear after a guest submits the form (duplicate submissions keep a fixed message). Search titles and meta live under SEO in the admin menu.', 'restwell-retreats' );
	}

	if ( $template !== '' ) {
		return __( 'Hero heading, intro, and hero image go live where this template reads them. Most body copy on these templates lives in the theme PHP, not in this panel. Search titles and meta live under SEO in the admin menu.', 'restwell-retreats' );
	}

	return __( 'Pick a section, edit the fields. Search titles and meta live under SEO in the admin menu.', 'restwell-retreats' );
}

require_once __DIR__ . '/page-meta/home-property.php';
require_once __DIR__ . '/page-meta/templates.php';
