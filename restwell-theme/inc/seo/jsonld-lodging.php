<?php
/**
 * JSON-LD LodgingBusiness / Accommodation service graphs.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
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

	$gallery_ids = restwell_get_page_gallery_ids(
		$page_id,
		'prop_gallery_image_ids',
		array(
			'prop_gallery_1_image_id',
			'prop_gallery_2_image_id',
			'prop_gallery_3_image_id',
		)
	);
	foreach ( $gallery_ids as $gid ) {
		$img = wp_get_attachment_image_url( $gid, 'full' );
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
	if ( function_exists( 'restwell_get_property_facts_amenity_features' ) ) {
		return restwell_get_property_facts_amenity_features();
	}

	return array(
		array(
			'@type' => 'LocationFeatureSpecification',
			'name' => 'Wheelchair accessible accommodation',
			'value' => true,
		),
		array(
			'@type' => 'LocationFeatureSpecification',
			'name' => 'Ceiling track hoist (accessible bedroom)',
			'value' => true,
		),
		array(
			'@type' => 'LocationFeatureSpecification',
			'name' => 'Profiling bed',
			'value' => true,
		),
		array(
			'@type' => 'LocationFeatureSpecification',
			'name' => 'Wet room / roll-in shower',
			'value' => true,
		),
		array(
			'@type' => 'LocationFeatureSpecification',
			'name' => 'Level access throughout',
			'value' => true,
		),
		array(
			'@type' => 'LocationFeatureSpecification',
			'name' => 'Self-catering kitchen',
			'value' => true,
		),
		array(
			'@type' => 'LocationFeatureSpecification',
			'name' => 'Whole-property booking',
			'value' => true,
		),
		array(
			'@type' => 'LocationFeatureSpecification',
			'name' => 'Optional CQC-regulated care (Continuity of Care Services)',
			'value' => true,
		),
	);
}

/**
 * LodgingBusiness JSON-LD (Whitstable letting location; registered office via Organization entity).
 *
 * @param int $page_id Front page context uses 0 to merge property-page gallery images when available.
 */
function restwell_output_jsonld_local_business( $page_id = 0 ) {
	$page_id   = (int) $page_id;
	$site_name = restwell_get_schema_brand_name();
	$site_url  = home_url( '/' );
	$phone     = restwell_get_public_phone_tel();
	$email     = (string) get_option( 'restwell_enquiry_notify_email', '' );

	// Full street + postcode, house number never included (owner decision).
	// Site-wide SEO fields override these defaults when set.
	$address = array(
		'@type'           => 'PostalAddress',
		'streetAddress'   => 'Russell Drive',
		'addressLocality' => 'Whitstable',
		'addressRegion'   => 'Kent',
		'postalCode'      => 'CT5 2RQ',
		'addressCountry'  => 'GB',
	);

	$street = trim( (string) get_option( 'restwell_property_address', '' ) );
	if ( '' !== $street ) {
		// Editors sometimes paste the full address; house number never goes to schema.
		$address['streetAddress'] = trim( (string) preg_replace( '/^\s*[0-9]+[A-Za-z]?\s*,?\s*/', '', $street ) );
	}

	$postcode = trim( (string) get_option( 'restwell_property_postcode', '' ) );
	if ( '' !== $postcode ) {
		$address['postalCode'] = $postcode;
	}

	$desc = __(
		'A private adapted bungalow by the sea in Whitstable, sleeping five. Single-storey and step-free, with a level-access wet room and a ceiling track hoist. Optional home care from Continuity of Care Services, our sister company.',
		'restwell-retreats'
	);

	$price_range = (string) get_option( 'restwell_lodging_price_range', '' );
	if ( $price_range === '' && function_exists( 'restwell_get_pricing_price_range' ) ) {
		$price_range = restwell_get_pricing_price_range();
	}
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
			$prop_gallery_ids = restwell_get_property_gallery_ids( $prop_pid );
			foreach ( $prop_gallery_ids as $gid ) {
				$img = wp_get_attachment_image_url( $gid, 'full' );
				if ( $img ) {
					$image_urls[] = $img;
				}
			}
			$image_urls = array_values( array_unique( array_filter( $image_urls ) ) );
		}
	}

	$schema = array(
		'@context'            => 'https://schema.org',
		'@type'               => 'LodgingBusiness',
		'@id'                 => restwell_get_local_business_schema_id(),
		'name'                => $site_name,
		'description'         => $desc,
		'url'                 => $site_url,
		'priceRange'          => $price_range,
		'address'             => $address,
		'provider'            => array( '@id' => restwell_get_organization_schema_id() ),
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

	$schema['telephone'] = $phone;
	if ( $email !== '' ) {
		$schema['email'] = $email;
	}
	if ( ! empty( $image_urls ) ) {
		$schema['image'] = count( $image_urls ) === 1 ? $image_urls[0] : $image_urls;
	}

	if ( function_exists( 'restwell_get_pricing' ) ) {
		$pricing = restwell_get_pricing();
		$off     = isset( $pricing['seasons']['off_peak'] ) ? $pricing['seasons']['off_peak'] : array();
		$peak    = isset( $pricing['seasons']['peak'] ) ? $pricing['seasons']['peak'] : array();
		if ( ! empty( $off['midweek_night'] ) && ! empty( $peak['full_week'] ) ) {
			$schema['makesOffer'] = array(
				array(
					'@type'             => 'Offer',
					'name'              => __( 'Off-peak midweek night', 'restwell-retreats' ),
					'price'             => (string) (int) $off['midweek_night'],
					'priceCurrency'     => 'GBP',
					'priceSpecification' => array(
						'@type'             => 'UnitPriceSpecification',
						'price'             => (string) (int) $off['midweek_night'],
						'priceCurrency'     => 'GBP',
						'unitText'          => 'NIGHT',
					),
				),
				array(
					'@type'             => 'Offer',
					'name'              => __( 'Peak full week (7 nights)', 'restwell-retreats' ),
					'price'             => (string) (int) $peak['full_week'],
					'priceCurrency'     => 'GBP',
					'priceSpecification' => array(
						'@type'             => 'UnitPriceSpecification',
						'price'             => (string) (int) $peak['full_week'],
						'priceCurrency'     => 'GBP',
						'unitText'          => 'WEEK',
					),
				),
			);
		}
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
		$name = restwell_get_schema_brand_name() . ': ' . __( 'Accessible holiday accommodation, Whitstable', 'restwell-retreats' );
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
	if ( function_exists( 'restwell_get_property_facts_amenity_features' ) ) {
		$amenities = restwell_get_property_facts_amenity_features();
	} else {
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
		'amenityFeature' => $amenities,
	);

	if ( ! empty( $image_urls ) ) {
		$schema['image'] = count( $image_urls ) === 1 ? $image_urls[0] : $image_urls;
	}

	$schema = restwell_jsonld_with_same_as( $schema );

	restwell_print_jsonld( $schema );
}
