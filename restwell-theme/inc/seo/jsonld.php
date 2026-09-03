<?php
/**
 * JSON-LD dispatcher. Builders live in jsonld-*.php siblings.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/jsonld-core.php';
require_once __DIR__ . '/jsonld-lodging.php';
require_once __DIR__ . '/jsonld-faq.php';
require_once __DIR__ . '/jsonld-pages.php';

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

	// How it works is a booking funnel (Enquire → Confirm → Arrive), not a DIY
	// procedure. Do not emit HowTo JSON-LD on that template.

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
