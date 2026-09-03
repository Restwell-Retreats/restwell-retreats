<?php
/**
 * JSON-LD page-type graphs (contact, about, audience, collection, care, access, blog, legal, tourist).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
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

	$phone = restwell_get_public_phone_tel();
	$email = (string) get_option( 'restwell_enquiry_notify_email', '' );

	$contact_point = array(
		'@type'             => 'ContactPoint',
		'contactType'       => 'customer service',
		'areaServed'        => 'GB',
		'availableLanguage' => 'English',
	);

	$contact_point['telephone'] = $phone;
	if ( $email !== '' ) {
		$contact_point['email'] = $email;
	}

	$main_org = restwell_jsonld_with_same_as(
		array(
			'@type'         => 'Organization',
			'@id'           => trailingslashit( home_url( '/' ) ) . '#organization',
			'name'          => restwell_get_schema_brand_name(),
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

/**
 * AboutPage for Our Story.
 */
function restwell_output_jsonld_about_page() {
	$pid = get_queried_object_id();
	if ( ! $pid ) {
		return;
	}
	$url  = get_permalink( $pid );
	$desc = (string) get_post_meta( $pid, 'meta_description', true );
	if ( $desc === '' && function_exists( 'restwell_get_seo_default_meta_for_post_id' ) ) {
		$desc = restwell_get_seo_default_meta_for_post_id( $pid )['meta_description'];
	}
	restwell_print_jsonld(
		array(
			'@context'    => 'https://schema.org',
			'@type'       => 'AboutPage',
			'@id'         => trailingslashit( $url ) . '#webpage',
			'url'         => $url,
			'name'        => get_the_title( $pid ),
			'description' => $desc,
			'inLanguage'  => 'en-GB',
			'isPartOf'    => array(
				'@type' => 'WebSite',
				'@id'   => trailingslashit( home_url( '/' ) ) . '#website',
				'url'   => home_url( '/' ),
				'name'  => restwell_get_schema_brand_name(),
			),
			'about'       => array(
				'@id' => restwell_get_organization_schema_id(),
			),
			'mainEntity'  => restwell_get_host_person_schema(),
		)
	);
}

/**
 * WebPage for Who It's For (audience fit).
 */
function restwell_output_jsonld_audience_webpage() {
	$pid = get_queried_object_id();
	if ( ! $pid ) {
		return;
	}
	$url  = get_permalink( $pid );
	$desc = (string) get_post_meta( $pid, 'meta_description', true );
	if ( $desc === '' && function_exists( 'restwell_get_seo_default_meta_for_post_id' ) ) {
		$desc = restwell_get_seo_default_meta_for_post_id( $pid )['meta_description'];
	}
	restwell_print_jsonld(
		array(
			'@context'    => 'https://schema.org',
			'@type'       => 'WebPage',
			'@id'         => trailingslashit( $url ) . '#webpage',
			'url'         => $url,
			'name'        => get_the_title( $pid ),
			'description' => $desc,
			'inLanguage'  => 'en-GB',
			'audience'    => array(
				array(
					'@type'        => 'Audience',
					'audienceType' => 'Wheelchair users and disabled holidaymakers',
				),
				array(
					'@type'        => 'Audience',
					'audienceType' => 'Family carers',
				),
				array(
					'@type'        => 'Audience',
					'audienceType' => 'Occupational therapists and commissioners',
				),
			),
		)
	);
}

/**
 * CollectionPage for Funding & Support resources.
 */
function restwell_output_jsonld_collection_page() {
	$pid = get_queried_object_id();
	if ( ! $pid ) {
		return;
	}
	$url  = get_permalink( $pid );
	$desc = (string) get_post_meta( $pid, 'meta_description', true );
	if ( $desc === '' && function_exists( 'restwell_get_seo_default_meta_for_post_id' ) ) {
		$desc = restwell_get_seo_default_meta_for_post_id( $pid )['meta_description'];
	}
	restwell_print_jsonld(
		array(
			'@context'    => 'https://schema.org',
			'@type'       => 'CollectionPage',
			'@id'         => trailingslashit( $url ) . '#webpage',
			'url'         => $url,
			'name'        => get_the_title( $pid ),
			'description' => $desc,
			'inLanguage'  => 'en-GB',
			'about'       => array(
				'@type' => 'Thing',
				'name'  => 'Accessible respite holiday funding',
			),
		)
	);
}

/**
 * Service schema for optional Continuity care during a Restwell stay.
 */
function restwell_output_jsonld_care_service() {
	$pid = get_queried_object_id();
	if ( ! $pid ) {
		return;
	}
	$url  = get_permalink( $pid );
	$desc = (string) get_post_meta( $pid, 'meta_description', true );
	if ( $desc === '' && function_exists( 'restwell_get_seo_default_meta_for_post_id' ) ) {
		$desc = restwell_get_seo_default_meta_for_post_id( $pid )['meta_description'];
	}
	restwell_print_jsonld(
		array(
			'@context'    => 'https://schema.org',
			'@type'       => 'Service',
			'@id'         => trailingslashit( $url ) . '#care-service',
			'name'        => __( 'Optional care during a Restwell stay', 'restwell-retreats' ),
			'url'         => $url,
			'description' => $desc,
			'provider'    => array(
				'@type' => 'Organization',
				'name'  => 'Continuity of Care Services',
				'url'   => 'https://www.continuitycareservices.co.uk/',
			),
			'areaServed'  => array(
				'@type' => 'Place',
				'name'  => 'Whitstable, Kent',
			),
			'serviceType' => 'Home care during self-catering holiday',
		)
	);
}

/**
 * WebPage for the Accessibility access statement surface.
 */
function restwell_output_jsonld_access_webpage() {
	$pid = get_queried_object_id();
	if ( ! $pid ) {
		return;
	}
	$url  = get_permalink( $pid );
	$desc = (string) get_post_meta( $pid, 'meta_description', true );
	if ( $desc === '' && function_exists( 'restwell_get_seo_default_meta_for_post_id' ) ) {
		$desc = restwell_get_seo_default_meta_for_post_id( $pid )['meta_description'];
	}
	restwell_print_jsonld(
		array(
			'@context'    => 'https://schema.org',
			'@type'       => 'WebPage',
			'@id'         => trailingslashit( $url ) . '#webpage',
			'url'         => $url,
			'name'        => get_the_title( $pid ),
			'description' => $desc,
			'inLanguage'  => 'en-GB',
			'about'       => array(
				'@id' => restwell_get_local_business_schema_id(),
			),
		)
	);
}

/**
 * Blog schema for the posts index.
 */
function restwell_output_jsonld_blog() {
	$blog_id = (int) get_option( 'page_for_posts', 0 );
	$url     = $blog_id > 0 ? get_permalink( $blog_id ) : home_url( '/blog/' );
	$name    = $blog_id > 0 ? get_the_title( $blog_id ) : __( 'Blog', 'restwell-retreats' );
	$desc    = '';
	if ( $blog_id > 0 ) {
		$desc = (string) get_post_meta( $blog_id, 'meta_description', true );
		if ( $desc === '' && function_exists( 'restwell_get_seo_default_meta_for_post_id' ) ) {
			$desc = restwell_get_seo_default_meta_for_post_id( $blog_id )['meta_description'];
		}
	}
	restwell_print_jsonld(
		array(
			'@context'    => 'https://schema.org',
			'@type'       => 'Blog',
			'@id'         => trailingslashit( $url ) . '#blog',
			'url'         => $url,
			'name'        => $name,
			'description' => $desc,
			'inLanguage'  => 'en-GB',
			'publisher'   => array(
				'@id' => restwell_get_organization_schema_id(),
			),
		)
	);
}

/**
 * WebPage for legal / policy templates.
 */
function restwell_output_jsonld_legal_webpage() {
	$pid = get_queried_object_id();
	if ( ! $pid ) {
		return;
	}
	$url  = get_permalink( $pid );
	$desc = (string) get_post_meta( $pid, 'meta_description', true );
	if ( $desc === '' && function_exists( 'restwell_get_seo_default_meta_for_post_id' ) ) {
		$desc = restwell_get_seo_default_meta_for_post_id( $pid )['meta_description'];
	}
	restwell_print_jsonld(
		array(
			'@context'    => 'https://schema.org',
			'@type'       => 'WebPage',
			'@id'         => trailingslashit( $url ) . '#webpage',
			'url'         => $url,
			'name'        => get_the_title( $pid ),
			'description' => $desc,
			'inLanguage'  => 'en-GB',
			'isPartOf'    => array(
				'@type' => 'WebSite',
				'url'   => home_url( '/' ),
				'name'  => restwell_get_schema_brand_name(),
			),
		)
	);
}
