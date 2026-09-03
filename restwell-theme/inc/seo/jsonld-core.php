<?php
/**
 * JSON-LD helpers: IDs, Organization, WebSite, breadcrumbs, Article.
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
 * Host Person for JSON-LD. Facts already on Our Story: Victoria Walker owns
 * Restwell; she is Continuity’s CQC registered manager. Restwell is not a
 * registered care provider.
 *
 * @return array<string, mixed>
 */
function restwell_get_host_person_schema() {
	$base  = trailingslashit( home_url( '/' ) );
	$story = function_exists( 'restwell_nav_resolve_page_url' )
		? restwell_nav_resolve_page_url( 'our-story' )
		: home_url( '/our-story/' );

	return array(
		'@type'       => 'Person',
		'@id'         => $base . '#host',
		'name'        => 'Victoria Walker',
		'jobTitle'    => 'Owner',
		'url'         => $story,
		'description' => 'Owns Restwell Retreats, a private adapted bungalow in Whitstable. CQC registered manager of sister company Continuity of Care Services.',
		'telephone'   => restwell_get_public_phone_tel(),
		'worksFor'    => array(
			array(
				'@type' => 'Organization',
				'@id'   => restwell_get_organization_schema_id(),
				'name'  => restwell_get_schema_brand_name(),
			),
			array(
				'@type'  => 'Organization',
				'name'   => 'Continuity of Care Services',
				'url'    => 'https://www.continuitycareservices.co.uk/',
				'sameAs' => 'https://www.cqc.org.uk/location/1-2624556588',
			),
		),
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
			'telephone'   => restwell_get_public_phone_tel(),
			'description' => get_bloginfo( 'description' ),
			'founder'     => restwell_get_host_person_schema(),
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
 * WebSite only - used on front page (Organization + LocalBusiness output separately).
 */
function restwell_output_jsonld_website_only() {
	$site_name = restwell_get_schema_brand_name();
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
			'name'  => restwell_get_schema_brand_name(),
		),
	);
	restwell_print_jsonld( $schema );
}

/**
 * WebSite + Organization - output on interior pages.
 */
function restwell_output_jsonld_website_organization() {
	$site_name = restwell_get_schema_brand_name();
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
	$author_name = restwell_get_schema_brand_name(); // site name as author for brand articles

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
			'name'  => restwell_get_schema_brand_name(),
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
			'name'  => restwell_get_schema_brand_name(),
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
