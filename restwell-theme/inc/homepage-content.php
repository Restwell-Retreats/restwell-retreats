<?php
/**
 * Homepage Partners and Testimonials content from Page content tabs.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme-file logo path for a partner slot when no attachment is set.
 *
 * @param int    $slot 1–5.
 * @param string $name Partner name (used as a secondary lookup).
 * @return string Relative path under assets/images/, or empty.
 */
function restwell_homepage_partner_theme_logo( $slot, $name = '' ) {
	$by_slot = array(
		1 => 'partners/care-spaces.png',
		2 => 'partners/thor-carpentry.png',
		3 => 'partners/wealden-rehab.png',
		4 => 'partners/continuity-of-care-services.png',
		5 => 'partners/continuity-training-academy.png',
	);
	$by_name = array(
		'Care Spaces'                   => 'partners/care-spaces.png',
		'Thor Carpentry'                => 'partners/thor-carpentry.png',
		'Wealden Rehab'                 => 'partners/wealden-rehab.png',
		'Continuity of Care Services'   => 'partners/continuity-of-care-services.png',
		'Continuity Training Academy'   => 'partners/continuity-training-academy.png',
	);
	$name = trim( (string) $name );
	if ( '' !== $name && isset( $by_name[ $name ] ) ) {
		return $by_name[ $name ];
	}
	$slot = absint( $slot );
	return $by_slot[ $slot ] ?? '';
}

/**
 * Default partner rows matching the live homepage logos.
 *
 * @return array<int, array{name:string,url:string,logo:string}>
 */
function restwell_homepage_partner_fallbacks() {
	return array(
		1 => array(
			'name' => 'Care Spaces',
			'url'  => 'https://www.carespaces.co.uk/',
			'logo' => 'partners/care-spaces.png',
		),
		2 => array(
			'name' => 'Thor Carpentry',
			'url'  => 'https://thorcarpenter.co.uk/',
			'logo' => 'partners/thor-carpentry.png',
		),
		3 => array(
			'name' => 'Wealden Rehab',
			'url'  => 'https://wealdenrehab.com/',
			'logo' => 'partners/wealden-rehab.png',
		),
		4 => array(
			'name' => 'Continuity of Care Services',
			'url'  => 'https://www.continuitycareservices.co.uk/',
			'logo' => 'partners/continuity-of-care-services.png',
		),
		5 => array(
			'name' => 'Continuity Training Academy',
			'url'  => 'https://www.continuitytrainingacademy.co.uk/',
			'logo' => 'partners/continuity-training-academy.png',
		),
	);
}

/**
 * Partners strip for the homepage (Page content → Partners).
 *
 * Empty stored heading hides the section. Missing meta uses the live fallbacks.
 *
 * @param int $home_id Front page ID.
 * @return array{heading:string,label:string,intro:string,cta_text:string,cta_url:string,items:array<int,array{name:string,url:string,img:string,alt:string}>}
 */
function restwell_get_homepage_partners( $home_id ) {
	$home_id = absint( $home_id );
	$empty   = array(
		'heading'  => '',
		'label'    => '',
		'intro'    => '',
		'cta_text' => '',
		'cta_url'  => '',
		'items'    => array(),
	);

	$heading_fallback = 'Who built it, and who we work with';
	$heading          = $heading_fallback;
	if ( $home_id > 0 && metadata_exists( 'post', $home_id, 'home_partners_heading' ) ) {
		$heading = trim( (string) get_post_meta( $home_id, 'home_partners_heading', true ) );
		if ( '' === $heading ) {
			return $empty;
		}
	} elseif ( $home_id > 0 && function_exists( 'restwell_page_content_text' ) ) {
		$heading = restwell_page_content_text( $home_id, 'home_partners_heading', $heading_fallback );
	}

	$label = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $home_id, 'home_partners_label', 'Behind Restwell' )
		: 'Behind Restwell';
	$intro = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $home_id, 'home_partners_intro', 'Specialist firms adapted the house.' )
		: 'Specialist firms adapted the house.';
	$cta_text = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $home_id, 'home_partners_cta_text', 'Read the full story' )
		: 'Read the full story';
	$cta_url = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $home_id, 'home_partners_cta_url', '' )
		: '';
	if ( '' === $cta_url ) {
		$cta_url = function_exists( 'restwell_nav_resolve_page_url' )
			? restwell_nav_resolve_page_url( 'our-story' )
			: home_url( '/our-story/' );
	} elseif ( ! preg_match( '#^https?://#i', $cta_url ) ) {
		$cta_url = home_url( $cta_url );
	}

	$fallbacks = restwell_homepage_partner_fallbacks();
	$items     = array();
	for ( $i = 1; $i <= 5; $i++ ) {
		$fb   = $fallbacks[ $i ];
		$name = function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text( $home_id, 'home_partner_' . $i . '_name', $fb['name'] )
			: $fb['name'];
		$url  = function_exists( 'restwell_page_content_text' )
			? restwell_page_content_text( $home_id, 'home_partner_' . $i . '_url', $fb['url'] )
			: $fb['url'];
		$logo_id = $home_id > 0 ? absint( get_post_meta( $home_id, 'home_partner_' . $i . '_logo_id', true ) ) : 0;
		$img     = '';
		$alt     = $name;
		if ( $logo_id > 0 ) {
			$from_att = wp_get_attachment_image_url( $logo_id, 'medium' );
			if ( $from_att ) {
				$img = $from_att;
			}
			if ( function_exists( 'restwell_attachment_image_alt' ) ) {
				$att_alt = restwell_attachment_image_alt( $logo_id );
				if ( '' !== $att_alt ) {
					$alt = $att_alt;
				}
			}
		}
		if ( '' === $img ) {
			$theme_logo = restwell_homepage_partner_theme_logo( $i, $name );
			if ( '' === $theme_logo ) {
				$theme_logo = $fb['logo'];
			}
			if ( function_exists( 'restwell_theme_image_url' ) ) {
				$img = restwell_theme_image_url( $theme_logo );
				if ( function_exists( 'restwell_theme_image_alt' ) ) {
					$alt = restwell_theme_image_alt( $theme_logo );
				}
			}
		}
		if ( '' === $name || '' === $url || '' === $img ) {
			continue;
		}
		$items[] = array(
			'name' => $name,
			'url'  => $url,
			'img'  => $img,
			'alt'  => $alt,
		);
	}

	return array(
		'heading'  => $heading,
		'label'    => $label,
		'intro'    => $intro,
		'cta_text' => $cta_text,
		'cta_url'  => $cta_url,
		'items'    => $items,
	);
}

/**
 * Built-in verbatim guest quotes used when the Testimonials tab is empty.
 *
 * Consecutive words from the review. Do not rewrite.
 *
 * @return array<int, array{quote:string,name:string,role:string}>
 */
function restwell_homepage_testimonial_hard_fallbacks() {
	return array(
		array(
			'quote' => 'Keelie was tremendously helpful in explaining all the facilities, equipment and care help they could provide. The fact that they could move all the furniture around to a layout suitable for Mum was fantastic.',
			'name'  => 'M.H.',
			'role'  => 'Family carer · Facebook review',
		),
		array(
			'quote' => '10/10 from me, as there was NOTHING i needed to ask for, as Restwell Retreats had catered for it all already.. and with the complex care I need, this is worth it\'s weight in gold',
			'name'  => 'M.P.',
			'role'  => 'Wheelchair user · Google review',
		),
		array(
			'quote' => 'The property is beautifully presented, exceptionally clean, well equipped, and in a fantastic location. One of the highlights was waking up to the sound of birds singing each morning and watching them from the garden while enjoying our breakfast. It was the perfect way to start the day.',
			'name'  => 'M.Z.',
			'role'  => 'Guest · Google review',
		),
	);
}

/**
 * Testimonials heading, label, and fallback quotes from Page content.
 *
 * @param int $home_id Front page ID.
 * @return array{label:string,heading:string,fallbacks:array<int,array{quote:string,name:string,role:string}>}
 */
function restwell_get_homepage_testimonials( $home_id ) {
	$home_id = absint( $home_id );
	$label   = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $home_id, 'testimonial_label', 'What guests say' )
		: 'What guests say';
	$heading = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $home_id, 'testimonial_heading', 'What guests wrote after staying' )
		: 'What guests wrote after staying';

	$fallbacks = array();
	if ( $home_id > 0 && function_exists( 'restwell_page_content_text' ) ) {
		for ( $i = 1; $i <= 5; $i++ ) {
			$quote = restwell_page_content_text( $home_id, 'testimonial_' . $i . '_quote', '' );
			if ( '' === $quote ) {
				continue;
			}
			$fallbacks[] = array(
				'quote' => $quote,
				'name'  => restwell_page_content_text( $home_id, 'testimonial_' . $i . '_name', '' ),
				'role'  => restwell_page_content_text( $home_id, 'testimonial_' . $i . '_role', '' ),
			);
		}
	}
	if ( array() === $fallbacks ) {
		$fallbacks = restwell_homepage_testimonial_hard_fallbacks();
	}

	return array(
		'label'     => $label,
		'heading'   => $heading,
		'fallbacks' => $fallbacks,
	);
}
