<?php
/**
 * Page content field schema: remaining public and legal templates.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * How It Works page.
 */
function restwell_get_how_it_works_field_definitions() {
	$included = array(
		'hiw_included_label'   => restwell_field( __( 'Section label', 'restwell-retreats' ) ),
		'hiw_included_heading' => restwell_field( __( 'Section heading (h2)', 'restwell-retreats' ) ),
		'hiw_included_intro'   => restwell_field( __( 'Section intro paragraph', 'restwell-retreats' ), 'textarea' ),
	);
	for ( $i = 1; $i <= 6; $i++ ) {
		$included[ "hiw_included_{$i}_title" ] = restwell_field(
			sprintf(
				/* translators: %d: item number */
				__( 'Item %d title', 'restwell-retreats' ),
				$i
			)
		);
		$included[ "hiw_included_{$i}_desc" ]  = restwell_field(
			sprintf(
				/* translators: %d: item number */
				__( 'Item %d description (optional)', 'restwell-retreats' ),
				$i
			),
			'textarea'
		);
	}
	$faq = array(
		'hiw_faq_label'   => restwell_field( __( 'Section eyebrow label', 'restwell-retreats' ) ),
		'hiw_faq_heading' => restwell_field( __( 'Section heading (h2)', 'restwell-retreats' ) ),
		'hiw_faq_intro'   => restwell_field( __( 'Section intro paragraph', 'restwell-retreats' ), 'textarea' ),
	);
	for ( $i = 1; $i <= 3; $i++ ) {
		$faq[ "hiw_faq_{$i}_q" ] = restwell_field(
			sprintf(
				/* translators: %d: question number */
				__( 'Question %d', 'restwell-retreats' ),
				$i
			)
		);
		$faq[ "hiw_faq_{$i}_a" ] = restwell_field(
			sprintf(
				/* translators: %d: question number */
				__( 'Answer %d', 'restwell-retreats' ),
				$i
			),
			'textarea'
		);
	}
	return array(
		'Header' => array(
			'hiw_hero_image_id'           => restwell_field( __( 'Hero background image ID (optional)', 'restwell-retreats' ), 'media' ),
			'hiw_label'                   => restwell_field( __( 'Hero eyebrow label (e.g. WHITSTABLE, KENT)', 'restwell-retreats' ) ),
			'hiw_heading'                 => restwell_field( __( 'Page heading (h1)', 'restwell-retreats' ) ),
			'hiw_intro'                   => restwell_field( __( 'Intro paragraph', 'restwell-retreats' ), 'textarea' ),
			'hiw_hero_cta_text'           => restwell_field( __( 'Hero primary CTA label (optional)', 'restwell-retreats' ) ),
			'hiw_hero_cta_url'            => restwell_field( __( 'Hero primary CTA URL (optional)', 'restwell-retreats' ) ),
			'hiw_hero_cta_secondary_text' => restwell_field( __( 'Hero secondary CTA label (optional)', 'restwell-retreats' ) ),
			'hiw_hero_cta_secondary_url'  => restwell_field( __( 'Hero secondary CTA URL (optional)', 'restwell-retreats' ) ),
			'hiw_hero_cta_promise'        => restwell_field( __( 'Hero promise line (optional)', 'restwell-retreats' ) ),
		),
		'Steps' => array(
			'hiw_steps_label'   => restwell_field( __( 'Steps section label (e.g. FOUR-STEP PROCESS)', 'restwell-retreats' ) ),
			'hiw_steps_heading' => restwell_field( __( 'Steps section heading (h2)', 'restwell-retreats' ) ),
			'hiw_steps_intro'   => restwell_field( __( 'Steps section intro paragraph', 'restwell-retreats' ), 'textarea' ),
			'hiw_step1_title'   => restwell_field( __( 'Step 1 title', 'restwell-retreats' ) ),
			'hiw_step1_body'    => restwell_field( __( 'Step 1 body', 'restwell-retreats' ), 'textarea' ),
			'hiw_step2_title'   => restwell_field( __( 'Step 2 title', 'restwell-retreats' ) ),
			'hiw_step2_body'    => restwell_field( __( 'Step 2 body', 'restwell-retreats' ), 'textarea' ),
			'hiw_step3_title'   => restwell_field( __( 'Step 3 title', 'restwell-retreats' ) ),
			'hiw_step3_body'    => restwell_field( __( 'Step 3 body', 'restwell-retreats' ), 'textarea' ),
			'hiw_step4_title'   => restwell_field( __( 'Step 4 title', 'restwell-retreats' ) ),
			'hiw_step4_body'    => restwell_field( __( 'Step 4 body', 'restwell-retreats' ), 'textarea' ),
		),
		'Care CTA' => array(
			'hiw_care_cta_label'   => restwell_field( __( 'Band eyebrow label', 'restwell-retreats' ) ),
			'hiw_care_cta_heading' => restwell_field( __( 'Band heading', 'restwell-retreats' ) ),
			'hiw_care_cta_body'    => restwell_field( __( 'Band body (short)', 'restwell-retreats' ), 'textarea' ),
			'hiw_care_cta_btn'     => restwell_field( __( 'Button label', 'restwell-retreats' ) ),
			'hiw_care_cta_url'     => restwell_field( __( 'Button URL', 'restwell-retreats' ) ),
		),
		'What\'s included' => $included,
		'Bottom CTA' => array(
			'hiw_cta_label'           => restwell_field( __( 'CTA section eyebrow (optional)', 'restwell-retreats' ) ),
			'hiw_cta_heading'         => restwell_field( __( 'CTA heading (e.g. Ready to plan your break?)', 'restwell-retreats' ) ),
			'hiw_cta_body'            => restwell_field( __( 'CTA body paragraph', 'restwell-retreats' ), 'textarea' ),
			'hiw_cta_primary_label'   => restwell_field( __( 'Primary button label', 'restwell-retreats' ) ),
			'hiw_cta_primary_url'     => restwell_field( __( 'Primary button URL', 'restwell-retreats' ) ),
			'hiw_cta_secondary_label' => restwell_field( __( 'Secondary button label', 'restwell-retreats' ) ),
			'hiw_cta_secondary_url'   => restwell_field( __( 'Secondary button URL', 'restwell-retreats' ) ),
			'hiw_cta_promise'         => restwell_field( __( 'CTA promise line (optional)', 'restwell-retreats' ) ),
		),
		'Common questions' => $faq,
	);
}

/**
 * Accessibility page.
 */
function restwell_get_accessibility_field_definitions() {
	return array(
		'Header' => array(
			'acc_hero_image_id' => restwell_field( __( 'Hero background image (attachment ID, optional)', 'restwell-retreats' ), 'media' ),
			'acc_label'         => restwell_field( __( 'Hero eyebrow label', 'restwell-retreats' ) ),
			'acc_heading'       => restwell_field( __( 'Page heading (h1)', 'restwell-retreats' ) ),
			'acc_intro'         => restwell_field( __( 'Intro paragraph', 'restwell-retreats' ), 'textarea' ),
		),
		'Feature photos' => array(
			'acc_gallery_label'     => restwell_field( __( 'Gallery section label (optional)', 'restwell-retreats' ) ),
			'acc_gallery_heading'   => restwell_field( __( 'Gallery section heading (h2)', 'restwell-retreats' ) ),
			'acc_gallery_intro'     => restwell_field( __( 'Short intro above the gallery (optional)', 'restwell-retreats' ), 'textarea' ),
			'acc_gallery_image_ids' => restwell_field( __( 'Feature photos (level-access shower, ceiling hoist, step-free entrance, profiling bed, door clearances, etc.)', 'restwell-retreats' ), 'gallery' ),
		),
		'Property: room by room' => array(
			'acc_room_label'      => restwell_field( __( 'Room-by-room section label (optional)', 'restwell-retreats' ) ),
			'acc_room_heading'    => restwell_field( __( 'Section heading (h2)', 'restwell-retreats' ) ),
			'acc_arrival_heading' => restwell_field( __( 'Arrival & entrance (h3)', 'restwell-retreats' ) ),
			'acc_arrival_body'    => restwell_field( __( 'Arrival body (bullets or paragraph)', 'restwell-retreats' ), 'textarea' ),
			'acc_inside_heading'  => restwell_field( __( 'Inside the property (h3)', 'restwell-retreats' ) ),
			'acc_inside_body'     => restwell_field( __( 'Inside body', 'restwell-retreats' ), 'textarea' ),
			'acc_bedroom_heading' => restwell_field( __( 'Bedrooms (h3)', 'restwell-retreats' ) ),
			'acc_bedroom_body'    => restwell_field( __( 'Bedrooms body', 'restwell-retreats' ), 'textarea' ),
			'acc_bathroom_heading' => restwell_field( __( 'Bathroom (h3)', 'restwell-retreats' ) ),
			'acc_bathroom_body'   => restwell_field( __( 'Bathroom body', 'restwell-retreats' ), 'textarea' ),
			'acc_kitchen_heading' => restwell_field( __( 'Kitchen (h3)', 'restwell-retreats' ) ),
			'acc_kitchen_body'    => restwell_field( __( 'Kitchen body', 'restwell-retreats' ), 'textarea' ),
			'acc_outdoor_heading' => restwell_field( __( 'Outdoor spaces (h3)', 'restwell-retreats' ) ),
			'acc_outdoor_body'    => restwell_field( __( 'Outdoor body', 'restwell-retreats' ), 'textarea' ),
		),
		'The destination' => array(
			'acc_dest_label'             => restwell_field( __( 'Section label', 'restwell-retreats' ) ),
			'acc_dest_heading'           => restwell_field( __( 'Section heading (h2)', 'restwell-retreats' ) ),
			'acc_dest_intro'             => restwell_field( __( 'Intro paragraph', 'restwell-retreats' ), 'textarea' ),
			'acc_dest_good_heading'      => restwell_field( __( 'The good (h3)', 'restwell-retreats' ) ),
			'acc_dest_good_body'         => restwell_field( __( 'The good body', 'restwell-retreats' ), 'textarea' ),
			'acc_dest_challenge_heading' => restwell_field( __( 'The challenge (h3)', 'restwell-retreats' ) ),
			'acc_dest_challenge_body'    => restwell_field( __( 'The challenge body', 'restwell-retreats' ), 'textarea' ),
			'acc_dest_reality_heading'   => restwell_field( __( 'The reality (h3)', 'restwell-retreats' ) ),
			'acc_dest_reality_body'      => restwell_field( __( 'The reality body', 'restwell-retreats' ), 'textarea' ),
		),
		'Contact CTA' => array(
			'acc_cta_heading' => restwell_field( __( 'Section heading (h2)', 'restwell-retreats' ) ),
			'acc_cta_body'    => restwell_field( __( 'Body paragraph', 'restwell-retreats' ), 'textarea' ),
			'acc_cta_btn'     => restwell_field( __( 'Button label', 'restwell-retreats' ) ),
			'acc_cta_url'     => restwell_field( __( 'Button URL', 'restwell-retreats' ) ),
		),
	);
}

/**
 * FAQ page. Pairs faq_1_q, faq_1_a ... faq_15_q, faq_15_a.
 * Categories: about | booking | care | local | funding
 */
function restwell_get_faq_field_definitions() {
	$faq_section = array();
	for ( $i = 1; $i <= 15; $i++ ) {
		$faq_section[ "faq_{$i}_q" ]   = restwell_field(
			sprintf(
				/* translators: %d: question number */
				__( 'Question %d', 'restwell-retreats' ),
				$i
			)
		);
		$faq_section[ "faq_{$i}_a" ]   = restwell_field(
			sprintf(
				/* translators: %d: question number */
				__( 'Answer %d', 'restwell-retreats' ),
				$i
			),
			'textarea'
		);
		$faq_section[ "faq_{$i}_cat" ] = restwell_field(
			sprintf(
				/* translators: %d: question number */
				__( 'Question %d category (about | booking | care | local | funding)', 'restwell-retreats' ),
				$i
			)
		);
	}
	return array(
		'Header' => array(
			'faq_hero_image_id' => restwell_field( __( 'Hero background image (attachment ID, optional)', 'restwell-retreats' ), 'media' ),
			'faq_label'         => restwell_field( __( 'Hero eyebrow label', 'restwell-retreats' ) ),
			'faq_heading'       => restwell_field( __( 'Page heading (h1)', 'restwell-retreats' ) ),
			'faq_intro'         => restwell_field( __( 'Intro paragraph', 'restwell-retreats' ), 'textarea' ),
			'faq_list_label'    => restwell_field( __( 'FAQ list section label (optional)', 'restwell-retreats' ) ),
			'faq_list_heading'  => restwell_field( __( 'FAQ list heading (h2)', 'restwell-retreats' ) ),
		),
		'FAQ items' => $faq_section,
		'CTA' => array(
			'faq_cta_label'   => restwell_field( __( 'CTA section label (optional)', 'restwell-retreats' ) ),
			'faq_cta_heading' => restwell_field( __( 'CTA heading (h2)', 'restwell-retreats' ) ),
			'faq_cta_body'    => restwell_field( __( 'CTA body', 'restwell-retreats' ), 'textarea' ),
			'faq_cta_btn'     => restwell_field( __( 'Button label', 'restwell-retreats' ) ),
			'faq_cta_url'     => restwell_field( __( 'Button URL', 'restwell-retreats' ) ),
		),
	);
}

/**
 * Pricing page field definitions.
 */
function restwell_get_pricing_field_definitions() {
	$faq = array(
		'pricing_faq_label'   => restwell_field( __( 'FAQ section eyebrow', 'restwell-retreats' ) ),
		'pricing_faq_heading' => restwell_field( __( 'FAQ section heading (h2)', 'restwell-retreats' ) ),
	);
	for ( $i = 1; $i <= 5; $i++ ) {
		$faq[ "pricing_faq_{$i}_q" ] = restwell_field( sprintf( /* translators: %d: FAQ number */ __( 'Question %d', 'restwell-retreats' ), $i ) );
		$faq[ "pricing_faq_{$i}_a" ] = restwell_field( sprintf( /* translators: %d: FAQ number */ __( 'Answer %d', 'restwell-retreats' ), $i ), 'textarea' );
	}

	return array(
		'Header' => array(
			'pricing_hero_image_id'    => restwell_field( __( 'Hero background image (attachment ID, optional)', 'restwell-retreats' ), 'media' ),
			'pricing_label'            => restwell_field( __( 'Hero eyebrow label', 'restwell-retreats' ) ),
			'pricing_heading'          => restwell_field( __( 'Page heading (h1)', 'restwell-retreats' ) ),
			'pricing_subheading'       => restwell_field( __( 'Hero subheading (under H1)', 'restwell-retreats' ), 'textarea' ),
			'pricing_intro'            => restwell_field( __( 'Intro paragraph', 'restwell-retreats' ), 'textarea' ),
			'pricing_hero_cta_text'    => restwell_field( __( 'Hero primary CTA label', 'restwell-retreats' ) ),
			'pricing_hero_cta_url'     => restwell_field( __( 'Hero primary CTA URL', 'restwell-retreats' ) ),
			'pricing_hero_cta_promise' => restwell_field( __( 'Hero CTA promise line (optional)', 'restwell-retreats' ) ),
		),
		'FAQ' => $faq,
	);
}

/**
 * Resources / Funding & support page.
 */
function restwell_get_resources_field_definitions() {
	return array(
		'Header' => array(
			'res_hero_image_id' => restwell_field( __( 'Hero background image (attachment ID, optional)', 'restwell-retreats' ), 'media' ),
			'res_label'         => restwell_field( __( 'Hero eyebrow label', 'restwell-retreats' ) ),
			'res_heading'       => restwell_field( __( 'Page heading (h1)', 'restwell-retreats' ) ),
			'res_intro'         => restwell_field( __( 'Intro paragraph', 'restwell-retreats' ), 'textarea' ),
		),
		'How to fund' => array(
			'res_fund_heading' => restwell_field( __( 'Section heading (h2)', 'restwell-retreats' ) ),
			'res_fund_body'    => restwell_field( __( 'Body (HTML allowed: links, lists)', 'restwell-retreats' ), 'textarea' ),
		),
		'Grants and charities' => array(
			'res_grants_heading' => restwell_field( __( 'Section heading (h2)', 'restwell-retreats' ) ),
			'res_grants_body'    => restwell_field( __( 'Body (HTML allowed)', 'restwell-retreats' ), 'textarea' ),
		),
		'NHS CHC' => array(
			'res_chc_heading' => restwell_field( __( 'Section heading (h2)', 'restwell-retreats' ) ),
			'res_chc_body'    => restwell_field( __( 'Body (HTML allowed)', 'restwell-retreats' ), 'textarea' ),
		),
		'Complaints & appeals' => array(
			'res_complaints_heading' => restwell_field( __( 'Section heading (h2)', 'restwell-retreats' ) ),
			'res_complaints_body'    => restwell_field( __( 'Body (HTML allowed)', 'restwell-retreats' ), 'textarea' ),
		),
		'Key contacts' => array(
			'res_contacts_heading' => restwell_field( __( 'Section heading (h2)', 'restwell-retreats' ) ),
			'res_contacts_body'    => restwell_field( __( 'Table or list (HTML allowed)', 'restwell-retreats' ), 'textarea' ),
		),
		'CTA' => array(
			'res_cta_heading' => restwell_field( __( 'CTA heading (h2)', 'restwell-retreats' ) ),
			'res_cta_body'    => restwell_field( __( 'CTA body', 'restwell-retreats' ), 'textarea' ),
			'res_cta_btn'     => restwell_field( __( 'Button label', 'restwell-retreats' ) ),
			'res_cta_url'     => restwell_field( __( 'Button URL', 'restwell-retreats' ) ),
		),
	);
}

/**
 * Enquire page.
 */
function restwell_get_enquire_field_definitions() {
	return array(
		'Header' => array(
			'enq_hero_image_id' => restwell_field( __( 'Hero background image (attachment ID, optional)', 'restwell-retreats' ), 'media' ),
			'enq_label'         => restwell_field( __( 'Hero eyebrow label', 'restwell-retreats' ) ),
			'enq_heading'       => restwell_field( __( 'Page heading (h1)', 'restwell-retreats' ) ),
			'enq_intro'         => restwell_field( __( 'Intro paragraph', 'restwell-retreats' ), 'textarea' ),
		),
		'Form' => array(
			'enq_form_heading'        => restwell_field( __( 'Form heading (h2)', 'restwell-retreats' ) ),
			'enq_success_heading'     => restwell_field( __( 'Success message heading (default and urgent)', 'restwell-retreats' ) ),
			'enq_success_body'        => restwell_field( __( 'Success message body (default). Aim for a 48-hour reply, not working days.', 'restwell-retreats' ), 'textarea' ),
			'enq_success_urgent_body' => restwell_field( __( 'Success message body when urgent (48-hour window, not working days)', 'restwell-retreats' ), 'textarea' ),
		),
		'Sidebar' => array(
			'enq_contact_heading' => restwell_field( __( 'Sidebar contact card heading', 'restwell-retreats' ) ),
			'enq_email'           => restwell_field( __( 'Email address', 'restwell-retreats' ) ),
			'enq_phone'           => restwell_field( __( 'Phone number', 'restwell-retreats' ) ),
		),
	);
}

/**
 * Who It's For page.
 */
function restwell_get_who_its_for_field_definitions() {
	return array(
		'Header' => array(
			'wif_hero_image_id' => restwell_field( __( 'Hero background image (attachment ID, optional)', 'restwell-retreats' ), 'media' ),
			'wif_label'         => restwell_field( __( 'Hero eyebrow label', 'restwell-retreats' ) ),
			'wif_heading'       => restwell_field( __( 'Page heading (h1)', 'restwell-retreats' ) ),
			'wif_intro'         => restwell_field( __( 'Intro paragraph', 'restwell-retreats' ), 'textarea' ),
		),
		'Persona intro' => array(
			'wif_audience_heading' => restwell_field( __( 'Section heading (h2), under the eyebrow', 'restwell-retreats' ) ),
			'wif_audience_intro'   => restwell_field( __( 'Short intro under the heading', 'restwell-retreats' ), 'textarea' ),
		),
		'Jump links' => array(
			'wif_nav_family_label'       => restwell_field( __( 'Jump link: families / guests', 'restwell-retreats' ) ),
			'wif_nav_carers_label'       => restwell_field( __( 'Jump link: carers', 'restwell-retreats' ) ),
			'wif_nav_ot_label'           => restwell_field( __( 'Jump link: OT / case manager', 'restwell-retreats' ) ),
			'wif_nav_commissioners_label' => restwell_field( __( 'Jump link: commissioners', 'restwell-retreats' ) ),
		),
		'Persona cards' => array(
			'wif_family_title'        => restwell_field( __( 'Guests and families card title', 'restwell-retreats' ) ),
			'wif_family_body'         => restwell_field( __( 'Families intro (expanded: one paragraph, then bullets, then CTA)', 'restwell-retreats' ), 'textarea' ),
			'wif_carers_title'        => restwell_field( __( 'Carers card title', 'restwell-retreats' ) ),
			'wif_carers_body'         => restwell_field( __( 'Carers intro (expanded: paragraph, bullets, CTA)', 'restwell-retreats' ), 'textarea' ),
			'wif_ot_title'            => restwell_field( __( 'OT/case manager card title', 'restwell-retreats' ) ),
			'wif_ot_body'             => restwell_field( __( 'OT intro (expanded: paragraph, bullets, CTA)', 'restwell-retreats' ), 'textarea' ),
			'wif_commissioners_title' => restwell_field( __( 'Commissioners card title', 'restwell-retreats' ) ),
			'wif_commissioners_body'  => restwell_field( __( 'Commissioners intro (expanded: paragraph, bullets, CTA)', 'restwell-retreats' ), 'textarea' ),
		),
		'Families detail' => array(
			'wif_family_detail_bullets'   => restwell_field( __( 'Families detail bullets (one per line)', 'restwell-retreats' ), 'textarea' ),
			'wif_family_inline_cta_label' => restwell_field( __( 'Families inline CTA label', 'restwell-retreats' ) ),
			'wif_family_inline_cta_url'   => restwell_field( __( 'Families inline CTA URL (path)', 'restwell-retreats' ) ),
		),
		'Carers detail' => array(
			'wif_carers_detail_bullets'   => restwell_field( __( 'Carers detail bullets (one per line)', 'restwell-retreats' ), 'textarea' ),
			'wif_carers_inline_cta_label' => restwell_field( __( 'Carers inline CTA label', 'restwell-retreats' ) ),
			'wif_carers_inline_cta_url'   => restwell_field( __( 'Carers inline CTA URL (path)', 'restwell-retreats' ) ),
		),
		'OT detail' => array(
			'wif_ot_detail_bullets'   => restwell_field( __( 'OT detail bullets (one per line)', 'restwell-retreats' ), 'textarea' ),
			'wif_ot_inline_cta_label' => restwell_field( __( 'OT inline CTA label', 'restwell-retreats' ) ),
			'wif_ot_inline_cta_url'   => restwell_field( __( 'OT inline CTA URL (path)', 'restwell-retreats' ) ),
		),
		'Commissioners detail' => array(
			'wif_commissioners_detail_bullets'   => restwell_field( __( 'Commissioners detail bullets (one per line)', 'restwell-retreats' ), 'textarea' ),
			'wif_commissioners_inline_cta_label' => restwell_field( __( 'Commissioners inline CTA label', 'restwell-retreats' ) ),
			'wif_commissioners_inline_cta_url'   => restwell_field( __( 'Commissioners inline CTA URL (path)', 'restwell-retreats' ) ),
		),
		'Photos intro' => array(
			'wif_visual_intro' => restwell_field( __( 'Intro under "Accessibility you can see" (visitor-facing)', 'restwell-retreats' ), 'textarea' ),
		),
		'Body images' => array(
			'wif_section_image_1_id'      => restwell_field( __( 'Image 1 attachment ID', 'restwell-retreats' ), 'image' ),
			'wif_section_image_1_caption' => restwell_field( __( 'Image 1 caption', 'restwell-retreats' ) ),
			'wif_section_image_2_id'      => restwell_field( __( 'Image 2 attachment ID', 'restwell-retreats' ), 'image' ),
			'wif_section_image_2_caption' => restwell_field( __( 'Image 2 caption', 'restwell-retreats' ) ),
			'wif_section_image_3_id'      => restwell_field( __( 'Image 3 attachment ID', 'restwell-retreats' ), 'image' ),
			'wif_section_image_3_caption' => restwell_field( __( 'Image 3 caption', 'restwell-retreats' ) ),
		),
		'Funding' => array(
			'wif_funding_heading'        => restwell_field( __( 'Funding heading (h2)', 'restwell-retreats' ) ),
			'wif_funding_body'           => restwell_field( __( 'Funding intro paragraph', 'restwell-retreats' ), 'textarea' ),
			'wif_fund_la_title'          => restwell_field( __( 'Route 1 title (local authority / DP)', 'restwell-retreats' ) ),
			'wif_fund_la_bullets'        => restwell_field( __( 'Route 1 bullets (one per line)', 'restwell-retreats' ), 'textarea' ),
			'wif_fund_la_cta_label'      => restwell_field( __( 'Route 1 link label', 'restwell-retreats' ) ),
			'wif_fund_la_cta_url'        => restwell_field( __( 'Route 1 link URL (path)', 'restwell-retreats' ) ),
			'wif_fund_phb_title'         => restwell_field( __( 'Route 2 title (PHB)', 'restwell-retreats' ) ),
			'wif_fund_phb_bullets'       => restwell_field( __( 'Route 2 bullets (one per line)', 'restwell-retreats' ), 'textarea' ),
			'wif_fund_phb_cta_label'     => restwell_field( __( 'Route 2 link label', 'restwell-retreats' ) ),
			'wif_fund_phb_cta_url'       => restwell_field( __( 'Route 2 link URL (path)', 'restwell-retreats' ) ),
			'wif_fund_private_title'     => restwell_field( __( 'Route 3 title (private)', 'restwell-retreats' ) ),
			'wif_fund_private_bullets'   => restwell_field( __( 'Route 3 bullets (one per line)', 'restwell-retreats' ), 'textarea' ),
			'wif_fund_private_cta_label' => restwell_field( __( 'Route 3 link label', 'restwell-retreats' ) ),
			'wif_fund_private_cta_url'   => restwell_field( __( 'Route 3 link URL (path)', 'restwell-retreats' ) ),
		),
		'CTA' => array(
			'wif_cta_heading'         => restwell_field( __( 'CTA heading', 'restwell-retreats' ) ),
			'wif_cta_body'            => restwell_field( __( 'CTA body', 'restwell-retreats' ), 'textarea' ),
			'wif_cta_primary_label'   => restwell_field( __( 'Primary CTA label', 'restwell-retreats' ) ),
			'wif_cta_primary_url'     => restwell_field( __( 'Primary CTA URL', 'restwell-retreats' ) ),
			'wif_cta_secondary_label' => restwell_field( __( 'Secondary CTA label', 'restwell-retreats' ) ),
			'wif_cta_secondary_url'   => restwell_field( __( 'Secondary CTA URL', 'restwell-retreats' ) ),
		),
	);
}

/**
 * Whitstable guide page.
 */
function restwell_get_whitstable_guide_field_definitions() {
	return array(
		'Header' => array(
			'wg_hero_image_id' => restwell_field( __( 'Hero background image (attachment ID, optional)', 'restwell-retreats' ), 'media' ),
			'wg_label'         => restwell_field( __( 'Hero eyebrow label', 'restwell-retreats' ) ),
			'wg_heading'       => restwell_field( __( 'Page heading (h1)', 'restwell-retreats' ) ),
			'wg_intro'         => restwell_field( __( 'Intro paragraph', 'restwell-retreats' ), 'textarea' ),
		),
		'Sections' => array(
			'wg_about_heading'          => restwell_field( __( 'About section heading', 'restwell-retreats' ) ),
			'wg_about_body'             => restwell_field( __( 'About section body', 'restwell-retreats' ), 'textarea' ),
			'wg_towns_heading'          => restwell_field( __( 'Nearby towns heading', 'restwell-retreats' ) ),
			'wg_towns_body'             => restwell_field( __( 'Nearby towns body', 'restwell-retreats' ), 'textarea' ),
			'wg_getting_here_heading'   => restwell_field( __( 'Getting here heading', 'restwell-retreats' ) ),
			'wg_getting_here_body'      => restwell_field( __( 'Getting here body', 'restwell-retreats' ), 'textarea' ),
			'wg_getting_around_heading' => restwell_field( __( 'Getting around heading', 'restwell-retreats' ) ),
			'wg_getting_around_body'    => restwell_field( __( 'Getting around body', 'restwell-retreats' ), 'textarea' ),
		),
		'Image slots' => array(
			'wg_spotlight_image_1_id'      => restwell_field( __( 'Spotlight image 1 attachment ID (optional)', 'restwell-retreats' ), 'image' ),
			'wg_spotlight_image_1_caption' => restwell_field( __( 'Spotlight image 1 caption', 'restwell-retreats' ) ),
			'wg_spotlight_image_2_id'      => restwell_field( __( 'Spotlight image 2 attachment ID (optional)', 'restwell-retreats' ), 'image' ),
			'wg_spotlight_image_2_caption' => restwell_field( __( 'Spotlight image 2 caption', 'restwell-retreats' ) ),
			'wg_spotlight_image_3_id'      => restwell_field( __( 'Spotlight image 3 attachment ID (optional)', 'restwell-retreats' ), 'image' ),
			'wg_spotlight_image_3_caption' => restwell_field( __( 'Spotlight image 3 caption', 'restwell-retreats' ) ),
		),
		'Guide sections' => array(
			'wg_access_label'            => restwell_field( __( 'Accessibility block eyebrow', 'restwell-retreats' ) ),
			'wg_access_heading'          => restwell_field( __( 'Accessibility block heading', 'restwell-retreats' ) ),
			'wg_access_intro'            => restwell_field( __( 'Accessibility block intro', 'restwell-retreats' ), 'textarea' ),
			'wg_spotlight_label'         => restwell_field( __( 'Visual guide eyebrow', 'restwell-retreats' ) ),
			'wg_spotlight_heading'       => restwell_field( __( 'Visual guide heading', 'restwell-retreats' ) ),
			'wg_spotlight_intro'         => restwell_field( __( 'Visual guide intro', 'restwell-retreats' ), 'textarea' ),
			'wg_related_label'           => restwell_field( __( 'Related reading eyebrow', 'restwell-retreats' ) ),
			'wg_related_heading'         => restwell_field( __( 'Related reading heading', 'restwell-retreats' ) ),
			'wg_related_intro'           => restwell_field( __( 'Related reading intro', 'restwell-retreats' ), 'textarea' ),
			'wg_planning_label'          => restwell_field( __( 'Planning notes eyebrow', 'restwell-retreats' ) ),
			'wg_planning_heading'        => restwell_field( __( 'Planning notes heading', 'restwell-retreats' ) ),
			'wg_planning_intro'          => restwell_field( __( 'Planning notes intro', 'restwell-retreats' ), 'textarea' ),
			'wg_planning_before_heading' => restwell_field( __( 'Planning: before you travel heading', 'restwell-retreats' ) ),
			'wg_planning_before_bullets' => restwell_field( __( 'Planning: before you travel bullets (one per line)', 'restwell-retreats' ), 'textarea' ),
			'wg_planning_day_heading'    => restwell_field( __( 'Planning: on the day heading', 'restwell-retreats' ) ),
			'wg_planning_day_bullets'    => restwell_field( __( 'Planning: on the day bullets (one per line)', 'restwell-retreats' ), 'textarea' ),
			'wg_eating_label'            => restwell_field( __( 'Eating out eyebrow', 'restwell-retreats' ) ),
			'wg_eating_heading'          => restwell_field( __( 'Eating out heading', 'restwell-retreats' ) ),
			'wg_eating_intro'            => restwell_field( __( 'Eating out intro (optional)', 'restwell-retreats' ), 'textarea' ),
			'wg_eating_body'             => restwell_field( __( 'Eating out body (HTML allowed: strong, em, br; one paragraph per line)', 'restwell-retreats' ), 'textarea' ),
		),
		'CTA' => array(
			'wg_cta_heading'         => restwell_field( __( 'CTA heading', 'restwell-retreats' ) ),
			'wg_cta_body'            => restwell_field( __( 'CTA body', 'restwell-retreats' ), 'textarea' ),
			'wg_cta_primary_label'   => restwell_field( __( 'Primary CTA label', 'restwell-retreats' ) ),
			'wg_cta_primary_url'     => restwell_field( __( 'Primary CTA URL', 'restwell-retreats' ) ),
			'wg_cta_secondary_label' => restwell_field( __( 'Secondary CTA label', 'restwell-retreats' ) ),
			'wg_cta_secondary_url'   => restwell_field( __( 'Secondary CTA URL', 'restwell-retreats' ) ),
			'wg_cta_blog_label'      => restwell_field( __( 'Tertiary CTA label (blog)', 'restwell-retreats' ) ),
			'wg_cta_blog_url'        => restwell_field( __( 'Tertiary CTA URL (blog)', 'restwell-retreats' ) ),
		),
	);
}

/**
 * Page Content Fields shared by Privacy Policy, Terms & Conditions, and Website Accessibility Policy.
 *
 * @return array<string, array<string, array{label:string,type:string}>>
 */
function restwell_get_legal_policy_field_definitions() {
	return array(
		'Hero & summary' => array(
			'legal_label'         => restwell_field( __( 'Eyebrow label (short, above the headline)', 'restwell-retreats' ) ),
			'legal_heading'       => restwell_field( __( 'Page headline (h1)', 'restwell-retreats' ) ),
			'legal_intro'         => restwell_field( __( 'Short intro under the headline (plain text)', 'restwell-retreats' ), 'textarea' ),
			'legal_hero_image_id' => restwell_field( __( 'Hero background (image or video, optional)', 'restwell-retreats' ), 'media' ),
		),
		'Document body' => array(
			'legal_body_html' => restwell_field( __( 'Main policy text (HTML). Leave empty to use the theme default for this page type.', 'restwell-retreats' ), 'textarea' ),
		),
	);
}

/**
 * Optional care page.
 *
 * @return array<string, array<string, array{label:string,type:string}>>
 */
function restwell_get_care_field_definitions() {
	return array(
		'Header' => array(
			'care_hero_image_id' => restwell_field( __( 'Hero background image (attachment ID, optional)', 'restwell-retreats' ), 'media' ),
			'care_label'         => restwell_field( __( 'Hero eyebrow label', 'restwell-retreats' ) ),
			'care_heading'       => restwell_field( __( 'Page heading (h1)', 'restwell-retreats' ) ),
			'care_intro'         => restwell_field( __( 'Intro paragraph', 'restwell-retreats' ), 'textarea' ),
		),
	);
}

/**
 * Our Story page.
 *
 * @return array<string, array<string, array{label:string,type:string}>>
 */
function restwell_get_our_story_field_definitions() {
	return array(
		'Header' => array(
			'story_hero_image_id' => restwell_field( __( 'Hero background image (attachment ID, optional)', 'restwell-retreats' ), 'media' ),
			'story_label'         => restwell_field( __( 'Hero eyebrow label', 'restwell-retreats' ) ),
			'story_heading'       => restwell_field( __( 'Page heading (h1)', 'restwell-retreats' ) ),
			'story_intro'         => restwell_field( __( 'Intro paragraph', 'restwell-retreats' ), 'textarea' ),
		),
	);
}
