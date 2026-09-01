<?php
/**
 * SEO: JSON-LD structured data builders and wp_head output.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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
	$site_name = restwell_get_schema_brand_name();
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

	if ( is_page_template( 'template-pricing.php' ) ) {
		restwell_output_jsonld_pricing_faq();
		if ( is_singular( 'page' ) && ! is_front_page() ) {
			restwell_output_jsonld_local_business( get_queried_object_id() );
		}
	}

	if ( is_page_template( 'template-whitstable-guide.php' ) ) {
		restwell_output_jsonld_tourist_destination();
	}

	if ( is_page_template( 'template-enquire.php' ) ) {
		restwell_output_jsonld_contact_page();
	}

	if ( is_page_template( 'template-our-story.php' ) ) {
		restwell_output_jsonld_about_page();
	}

	if ( is_page_template( 'template-who-its-for.php' ) ) {
		restwell_output_jsonld_audience_webpage();
	}

	if ( is_page_template( 'template-resources.php' ) ) {
		restwell_output_jsonld_collection_page();
		restwell_output_jsonld_resources_faq();
	}

	if ( is_page_template( 'template-care.php' ) ) {
		restwell_output_jsonld_care_service();
		restwell_output_jsonld_care_faq();
	}

	if ( is_page_template( 'template-accessibility.php' ) ) {
		restwell_output_jsonld_access_webpage();
	}

	if ( is_home() && ! is_front_page() ) {
		restwell_output_jsonld_blog();
	}

	if (
		is_page_template( 'template-privacy-policy.php' )
		|| is_page_template( 'template-terms-and-conditions.php' )
		|| is_page_template( 'template-accessibility-policy.php' )
	) {
		restwell_output_jsonld_legal_webpage();
	}

	if ( is_front_page() ) {
		$teaser_ids = array_slice( restwell_get_property_gallery_ids(), 0, 6 );
		if ( ! empty( $teaser_ids ) ) {
			restwell_output_gallery_jsonld(
				$teaser_ids,
				array(
					'name' => __( 'Property photo preview', 'restwell-retreats' ),
					'url'  => home_url( '/' ),
				)
			);
		}
	}

	if ( is_page_template( 'template-property.php' ) && is_singular( 'page' ) ) {
		$prop_ids = restwell_get_property_gallery_ids( get_queried_object_id() );
		if ( ! empty( $prop_ids ) ) {
			restwell_output_gallery_jsonld(
				$prop_ids,
				array(
					'name' => get_the_title( get_queried_object_id() ),
					'url'  => get_permalink( get_queried_object_id() ),
				)
			);
		}
	}

	if ( is_page_template( 'template-accessibility.php' ) && is_singular( 'page' ) ) {
		$acc_ids = restwell_get_accessibility_gallery_ids( get_queried_object_id() );
		if ( ! empty( $acc_ids ) ) {
			restwell_output_gallery_jsonld(
				$acc_ids,
				array(
					'name' => get_the_title( get_queried_object_id() ),
					'url'  => get_permalink( get_queried_object_id() ),
				)
			);
		}
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
		function ( $v ) {
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
					'priceSpecification'=> array(
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
					'priceSpecification'=> array(
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
		$name = get_bloginfo( 'name' ) . ': ' . __( 'Accessible holiday accommodation, Whitstable', 'restwell-retreats' );
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
		'home_faq_heading' => __( 'The questions that stop an enquiry', 'restwell-retreats' ),
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

	restwell_print_jsonld(
		array(
			'@context'        => 'https://schema.org',
			'@type'           => 'BreadcrumbList',
			'itemListElement' => array_values( $items ),
		)
	);
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
	// Broader set -- kept distinct from per-page FAQs (homepage, how-it-works) to prevent duplicate-content cannibalisation.
	return array(
		array(
			'q'   => 'Is Restwell a care home?',
			'a'   => 'No. It’s a private adapted bungalow that you rent as a holiday, and the whole house is yours for the stay. There’s no staff on site and nobody has a key but you. If you’d like professional care while you’re here, that comes separately from our sister company. See <a href="/optional-care/">Optional care</a>.',
			'cat' => 'about',
		),
		array(
			'q'   => 'Is it a respite centre?',
			'a'   => 'No, though your funder may well use the word respite, and that’s fine. It’s often how a break like this gets described on paperwork. It’s still a private house rather than a registered respite service.',
			'cat' => 'about',
		),
		array(
			'q'   => 'Will a wheelchair actually fit?',
			'a'   => 'The house is single-storey and step-free throughout. The front door has a 965mm clear opening, the internal doorways are 926mm, the wet room is level-access, and there’s a ceiling track hoist over the profiling bed. If you need a measurement we haven’t published, ask and we’ll go and take it. See the <a href="/accessibility/">access statement</a>.',
			'cat' => 'about',
		),
		array(
			'q'   => 'Is there a hoist, and what’s it rated to?',
			'a'   => 'There’s a ceiling track hoist rated to 180kg, and an electric mobile hoist also rated to 180kg. Both are subject to a LOLER thorough examination every six months. Guests bring their own slings, because a sling needs to fit the person.',
			'cat' => 'about',
		),
		array(
			'q'   => 'Can we have two profiling beds?',
			'a'   => 'Yes. We arrange the accessible bedroom around each guest: one profiling bed if that’s what you need, two if it isn’t. Tell us when you book so it’s set up before you arrive.',
			'cat' => 'about',
		),
		array(
			'q'   => 'How many people does it sleep?',
			'a'   => 'Five. There are two bedrooms and a double sofa bed in the conservatory. Five is what our safety checks are based on, so we do have to hold to it.',
			'cat' => 'about',
		),
		array(
			'q'   => 'Can we add home care?',
			'a'   => 'Yes. Continuity of Care Services, our sister company, can come into the bungalow, anything from a morning visit to nurse-led support. Mention it on the same enquiry as the house and we’ll work it out together. See <a href="/optional-care/">Optional care</a>.',
			'cat' => 'care',
		),
		array(
			'q'   => 'How far ahead do we need to arrange the care?',
			'a'   => 'The sooner you ask, the more likely we can say yes. We don’t publish a lead time because it honestly depends on what you need and who’s available that week, and we’d rather give you a real answer quickly than a number we’ve invented.',
			'cat' => 'care',
		),
		array(
			'q'   => 'Can we bring our own carer or PA?',
			'a'   => 'Of course, and the price doesn’t change. A support worker can use the second bedroom, or we can think through the sleeping arrangements with you.',
			'cat' => 'care',
		),
		array(
			'q'   => 'How far is the bungalow from the seafront?',
			'a'   => 'About ten minutes on foot from the driveway. Places along Tankerton promenade take longer, because you walk down to the sea first and then head west along the prom. JoJo’s is roughly twenty minutes all in. See the <a href="/whitstable-area-guide/">Whitstable guide</a>.',
			'cat' => 'local',
		),
		array(
			'q'   => 'What does it cost, and what’s included?',
			'a'   => 'A week is £1,300 off-peak and £1,400 in peak season, with all the access equipment, linen, towels and parking included. A 50% deposit reserves your dates and the balance follows a week before arrival. See <a href="/pricing/">Pricing</a>.',
			'cat' => 'booking',
		),
		array(
			'q'   => 'Can a council or the NHS pay?',
			'a'   => 'We can invoice you, a local authority, the NHS or a grant body, and the rate is identical either way. What we can’t do is promise your package will cover a holiday. That decision sits with your social worker or case manager. See <a href="/funding-and-support/">Funding and support</a>.',
			'cat' => 'funding',
		),
		array(
			'q'   => 'Can we use direct payments?',
			'a'   => 'Some guests do, for the accommodation or for a PA’s time. The rules vary by area, so start with your own care team. See <a href="/direct-payment-holiday-accommodation/">direct payments</a>.',
			'cat' => 'funding',
		),
		array(
			'q'   => 'Are dogs allowed?',
			'a'   => 'Yes, with a bit of notice so we can run a quick risk assessment. Assistance dogs are welcome on the same terms.',
			'cat' => 'about',
		),
		array(
			'q'   => 'What time is check-in?',
			'a'   => 'From 3pm, through a key safe, with the code sent to you beforehand. Check-out is by 11am, and if you need longer for personal care or transport, tell us a few days ahead and we’ll do our best. See <a href="/how-it-works/">How it works</a>.',
			'cat' => 'booking',
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
				'text'  => wp_strip_all_tags( isset( $pair['answer_text'] ) ? $pair['answer_text'] : $pair['a'] ),
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
 * FAQPage for the Pricing template (same Q&A as the visible accordion).
 */
function restwell_output_jsonld_pricing_faq() {
	$pid = get_queried_object_id();
	if ( ! $pid ) {
		return;
	}

	$faq_pairs = function_exists( 'restwell_get_faq_items' ) ? restwell_get_faq_items( 'pricing' ) : array();
	if ( empty( $faq_pairs ) ) {
		return;
	}

	$main_entity = array();
	foreach ( $faq_pairs as $pair ) {
		$main_entity[] = array(
			'@type'          => 'Question',
			'name'           => wp_strip_all_tags( $pair['q'] ),
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => wp_strip_all_tags( isset( $pair['answer_text'] ) ? $pair['answer_text'] : $pair['a'] ),
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
				'name'  => get_bloginfo( 'name' ),
			),
			'about'       => array(
				'@id' => restwell_get_organization_schema_id(),
			),
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
 * FAQ pairs for the Funding & Support page (must match visible accordion copy).
 *
 * @return array<int, array{q: string, a: string}>
 */
function restwell_get_resources_faq_pairs() {
	return array(
		array(
			'q' => 'Can NHS Continuing Healthcare funding be used for a holiday?',
			'a' => 'It can cover the care hours you’re already assessed for, if your CHC team agrees in writing. It doesn’t pay for the holiday itself, so the bungalow, travel and food are usually yours unless a panel says otherwise. Ask them which costs they’ll take, then tell us who to invoice.',
		),
		array(
			'q' => 'Can I get an NHS-funded holiday in the UK?',
			'a' => 'There isn’t a general scheme where the NHS pays for holidays. Your assessed care can sometimes continue while you’re away. Treat the house, travel and care as separate costs, and get each one clear in writing.',
		),
		array(
			'q' => 'Can I use direct payments for a short break or holiday in England?',
			'a' => 'Yes, if it fits your support plan. Councils can’t ban short breaks as a blanket rule. The bungalow rent is only in if the plan names it, and food and souvenirs usually aren’t. Check with your social worker before you pay a deposit.',
		),
		array(
			'q' => 'Can a personal budget support a holiday or short break?',
			'a' => 'A Care Act personal budget can support a short break if that’s an assessed need. Keep general holiday spending off that line, and talk the wording through with your social worker. We can send the access statement to go on the file.',
		),
		array(
			'q' => 'How do I use NHS CHC funding for a short break?',
			'a' => 'Speak to your CHC coordinator and ask which hours continue away from home. Enquire with Restwell, and Continuity can quote the care on the same call. We’ll send the access statement; you agree who receives which invoice.',
		),
		array(
			'q' => 'What if my funding application is refused?',
			'a' => 'You can ask for a review. For a local authority decision, that’s your council first (Kent County Council if they funded the assessment), then the Local Government Ombudsman. For NHS CHC, follow the ICB appeals process, then the Parliamentary and Health Service Ombudsman. Scope and Beacon can advise either way, and we’re happy to resend the paperwork.',
		),
	);
}

/**
 * FAQPage JSON-LD for Funding & Support.
 */
function restwell_output_jsonld_resources_faq() {
	$pairs = restwell_get_resources_faq_pairs();
	if ( empty( $pairs ) ) {
		return;
	}
	$entities = array();
	foreach ( $pairs as $pair ) {
		$entities[] = array(
			'@type'          => 'Question',
			'name'           => $pair['q'],
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => $pair['a'],
			),
		);
	}
	restwell_print_jsonld(
		array(
			'@context'   => 'https://schema.org',
			'@type'      => 'FAQPage',
			'mainEntity' => $entities,
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
 * FAQ pairs for the Optional care page (must match visible accordion copy).
 *
 * @return array<int, array{q: string, a: string}>
 */
function restwell_get_care_faq_pairs() {
	$pricing_url = function_exists( 'restwell_nav_resolve_page_url' )
		? restwell_nav_resolve_page_url( 'pricing' )
		: home_url( '/pricing/' );
	return array(
		array(
			'q' => 'Do I have to book care?',
			'a' => 'No. Many guests book the house as a self-catering holiday and need no additional support. Continuity care is optional.',
		),
		array(
			'q' => 'Is Restwell a care home?',
			'a' => 'No. Restwell is a private holiday bungalow. Continuity of Care Services (our sister company) is the CQC-regulated provider if you want professional care during your stay.',
		),
		array(
			'q' => 'Do I book care separately?',
			'a' => 'No. Ask when you enquire about the bungalow. Restwell and Continuity share 01622 809881, so house and care can start in one conversation when you want both.',
		),
		array(
			'q' => 'Can I bring my own carers?',
			'a' => 'Yes. The layout supports familiar routines, with separate sleeping and space to assist. Tell us your party layout when you enquire.',
		),
		array(
			'q' => 'Where do I see guide rates?',
			'a' => 'On the Pricing page (' . $pricing_url . '#care-rates). They are Continuity guide rates only. Continuity quotes your care cost once hours and tasks are agreed.',
		),
	);
}

/**
 * FAQPage JSON-LD for Optional care.
 */
function restwell_output_jsonld_care_faq() {
	$pairs = restwell_get_care_faq_pairs();
	if ( empty( $pairs ) ) {
		return;
	}
	$entities = array();
	foreach ( $pairs as $pair ) {
		$entities[] = array(
			'@type'          => 'Question',
			'name'           => $pair['q'],
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => $pair['a'],
			),
		);
	}
	restwell_print_jsonld(
		array(
			'@context'   => 'https://schema.org',
			'@type'      => 'FAQPage',
			'mainEntity' => $entities,
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
				'name'  => get_bloginfo( 'name' ),
			),
		)
	);
}
