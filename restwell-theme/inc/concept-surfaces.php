<?php
/**
 * Concept (mockup) surface helpers: hard Tailwind cut per ported template.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Page templates / surfaces ported to the mockup system (no Tailwind).
 *
 * @return string[]
 */
function restwell_concept_page_templates() {
	return array(
		'front-page',
		'template-property.php',
		'template-pricing.php',
		'template-care.php',
		'template-how-it-works.php',
		'template-accessibility.php',
		'template-who-its-for.php',
		'template-whitstable-guide.php',
		'template-resources.php',
		'template-faq.php',
		'template-enquire.php',
		'template-our-story.php',
		'template-privacy-policy.php',
		'template-terms-and-conditions.php',
		'template-accessibility-policy.php',
		'page-guest-guide.php',
		'404',
		'blog',
		'page',
		'search',
	);
}

/**
 * Whether the current request should render with shared.css only (no Tailwind).
 *
 * @return bool
 */
function restwell_is_concept_surface() {
	static $cached = null;
	if ( null !== $cached ) {
		return $cached;
	}

	$cached = false;
	$ported = restwell_concept_page_templates();

	if ( in_array( 'front-page', $ported, true ) && is_front_page() ) {
		$cached = true;
		return $cached;
	}

	$page_templates = array_values(
		array_filter(
			$ported,
			static function ( $item ) {
				return ( 0 === strpos( $item, 'template-' ) || 0 === strpos( $item, 'page-' ) );
			}
		)
	);

	if ( ! empty( $page_templates ) && is_page_template( $page_templates ) ) {
		$cached = true;
		return $cached;
	}

	if ( in_array( '404', $ported, true ) && is_404() ) {
		$cached = true;
		return $cached;
	}

	if ( in_array( 'blog', $ported, true ) && ( is_home() || is_singular( 'post' ) ) ) {
		$cached = true;
		return $cached;
	}

	if ( in_array( 'page', $ported, true ) && is_page() && ! is_page_template() ) {
		$cached = true;
		return $cached;
	}

	if ( in_array( 'search', $ported, true ) && is_search() ) {
		$cached = true;
	}

	return $cached;
}

/**
 * Dequeue Tailwind on concept surfaces (hard cut).
 */
function restwell_dequeue_tailwind_on_concept() {
	if ( ! restwell_is_concept_surface() ) {
		return;
	}
	wp_dequeue_style( 'restwell-tailwind' );
	wp_deregister_style( 'restwell-tailwind' );
	wp_dequeue_style( 'phosphor-icons-regular' );
	wp_dequeue_style( 'phosphor-icons-bold' );
	wp_deregister_style( 'phosphor-icons-regular' );
	wp_deregister_style( 'phosphor-icons-bold' );
}
add_action( 'wp_enqueue_scripts', 'restwell_dequeue_tailwind_on_concept', 100 );

/**
 * Body classes for interior density (mockup shared.css) and concept surfaces.
 *
 * @param string[] $classes Body classes.
 * @return string[]
 */
function restwell_concept_body_class( $classes ) {
	if ( ! is_front_page() ) {
		$classes[] = 'page--interior';
	}
	if ( restwell_is_concept_surface() ) {
		$classes[] = 'restwell-concept';
	}
	if ( function_exists( 'restwell_page_has_photo_hero' ) && restwell_page_has_photo_hero() && ! is_front_page() ) {
		$classes[] = 'has-photo-hero';
	}
	return $classes;
}
add_filter( 'body_class', 'restwell_concept_body_class' );
