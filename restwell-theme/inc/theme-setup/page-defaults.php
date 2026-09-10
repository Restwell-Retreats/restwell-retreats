<?php
/**
 * Theme setup: page registry and default field maps.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function restwell_get_theme_setup_pages() {
	// Contact is retired: /contact/ 301s to /enquire/. Do not add it here.
	// WP demo leftovers (sample-page, hello-world) are also excluded.
	return array(
		'Home'               => 'home',
		'The Property'       => 'the-property',
		'How It Works'       => 'how-it-works',
		'Accessibility'      => 'accessibility',
		'Who It\'s For'      => 'who-its-for',
		'FAQ'                => 'faq',
		'Enquire'            => 'enquire',
		'Pricing'            => 'pricing',
		'Resources'          => 'funding-and-support',
		'Whitstable Guide'     => 'whitstable-area-guide',
		'Blog'                 => 'blog',
		'Our Story'            => 'our-story',
		'Optional care'        => 'optional-care',
		'Guest Guide'          => 'guest-guide',
		'Privacy Policy'       => 'privacy-policy',
		'Terms & Conditions'   => 'terms-and-conditions',
		'Accessibility Policy' => 'accessibility-policy',
	);
}

/**
 * Page title => PHP template file for Theme Setup and missing-page ensure.
 *
 * @return array<string, string>
 */
function restwell_get_theme_setup_page_templates() {
	return array(
		'The Property'           => 'template-property.php',
		'How It Works'           => 'template-how-it-works.php',
		'Accessibility'          => 'template-accessibility.php',
		'Who It\'s For'          => 'template-who-its-for.php',
		'Whitstable Guide'       => 'template-whitstable-guide.php',
		'FAQ'                    => 'template-faq.php',
		'Enquire'                => 'template-enquire.php',
		'Pricing'                => 'template-pricing.php',
		'Resources'              => 'template-resources.php',
		'Our Story'              => 'template-our-story.php',
		'Optional care'          => 'template-care.php',
		'Guest Guide'            => 'page-guest-guide.php',
		'Privacy Policy'         => 'template-privacy-policy.php',
		'Terms & Conditions'     => 'template-terms-and-conditions.php',
		'Accessibility Policy'   => 'template-accessibility-policy.php',
	);
}

/**
 * Default meta values for the front page (Home).
 */
function restwell_get_theme_setup_defaults() {
	$defaults = array(
		'hero_eyebrow'             => 'Restwell Retreats',
		'hero_heading'             => 'Accessible holidays in Whitstable',
		'hero_subheading'          => 'Private bungalow with a level wet room and ceiling track hoist. Home care from Continuity, quoted separately.',
		'hero_spec_heading'        => '',
		'hero_cta_primary_label'   => 'Enquire',
		'hero_cta_primary_url'     => '/enquire/',
		'hero_cta_secondary_label' => 'Look inside the bungalow',
		'hero_cta_secondary_url'   => '/the-property/',
		'hero_cta_promise'         => 'We aim to reply within 48 hours, and there’s no deposit until you’ve decided the house fits.',
		'home_partners_label'      => 'Behind Restwell',
		'home_partners_heading'    => 'Who built it, and who we work with',
		'home_partners_intro'      => 'Specialist firms adapted the house.',
		'home_partners_cta_text'   => 'Read the full story',
		'home_partners_cta_url'    => '/our-story/',
		'home_partner_1_name'      => 'Care Spaces',
		'home_partner_1_url'       => 'https://www.carespaces.co.uk/',
		'home_partner_1_logo_id'   => 0,
		'home_partner_2_name'      => 'Thor Carpentry',
		'home_partner_2_url'       => 'https://thorcarpenter.co.uk/',
		'home_partner_2_logo_id'   => 0,
		'home_partner_3_name'      => 'Wealden Rehab',
		'home_partner_3_url'       => 'https://www.wealdenrehab.com/',
		'home_partner_3_logo_id'   => 0,
		'home_partner_4_name'      => 'Continuity of Care Services',
		'home_partner_4_url'       => 'https://www.continuitycareservices.co.uk/',
		'home_partner_4_logo_id'   => 0,
		'home_partner_5_name'      => 'Continuity Training Academy',
		'home_partner_5_url'       => 'https://www.continuitytrainingacademy.co.uk/',
		'home_partner_5_logo_id'   => 0,

		'testimonial_label'   => 'What guests say',
		'testimonial_heading' => 'What guests wrote after staying',
		'testimonial_1_quote' => 'Keelie was tremendously helpful in explaining all the facilities, equipment and care help they could provide. The fact that they could move all the furniture around to a layout suitable for Mum was fantastic.',
		'testimonial_1_name'  => 'M.H.',
		'testimonial_1_role'  => 'Family carer · Facebook review',
		'testimonial_2_quote' => '10/10 from me, as there was NOTHING i needed to ask for, as Restwell Retreats had catered for it all already.. and with the complex care I need, this is worth it\'s weight in gold',
		'testimonial_2_name'  => 'M.P.',
		'testimonial_2_role'  => 'Wheelchair user · Google review',
		'testimonial_3_quote' => 'The property is beautifully presented, exceptionally clean, well equipped, and in a fantastic location. One of the highlights was waking up to the sound of birds singing each morning',
		'testimonial_3_name'  => 'M.Z.',
		'testimonial_3_role'  => 'Guest · Google review',

		'home_teaser_label'         => 'Area & funding',
		'home_teaser_area_title'    => 'Whitstable & the Kent coast',
		'home_teaser_area_body'     => 'The harbour beach is shingle. Tankerton promenade is the level stretch with the sea view. We’ve written down what we know about surfaces, parking and which places have an accessible loo, including the ones that don’t.',
		'home_teaser_funding_title' => 'Funding your stay',
		'home_teaser_funding_body'  => 'If a council, a grant or a direct payment might go towards the cost, we can invoice whoever you name. We can’t promise your package will stretch to a holiday, but we can tell you honestly how the paperwork usually goes.',

		'what_restwell_label'   => 'What is Restwell?',
		'what_restwell_heading' => 'A proper accessible coastal holiday.',
		'highlights_heading'    => '',
		'highlight_1_title'     => 'Ceiling track hoist',
		'highlight_1_desc'      => 'Full-room ceiling track in the accessible bedroom for daily bed transfers.',
		'highlight_2_title'   => 'Profiling bed',
		'highlight_2_desc'      => 'Adjustable profiling bed with a pressure-relieving mattress, ready on arrival.',
		'highlight_3_title'     => 'Full wet room',
		'highlight_3_desc'      => 'Roll-in wet room with grab rails and an adjustable washbasin; shower chair may be available.',
		'intro_body'            => 'Restwell is a wheelchair-accessible, single-storey self-catering bungalow in Whitstable, Kent, for guests with disabilities, their families, and carers. You book the whole property for a private coastal break. Optional professional care is available through Continuity of Care Services (CQC-regulated), on your terms.',

		'who_label'        => 'Who stays here',
		'who_heading'      => 'Privacy and accessibility for everyone',
		'who_guest_title'  => 'Space and access that work',
		'who_guest_body'   => 'A private home with the space and access features you need: wide doorways, level thresholds, room for equipment, and space to settle. Self-catering in Whitstable at your pace: the house is yours, the timetable is yours. Rest by the sea, then explore the town or stay close as you prefer.',
		'who_carer_title'  => 'Optional care on your terms',
		'who_carer_body'   => 'The layout supports everyday routines: separate sleeping, practical bathroom access, and space to assist when needed. Optional CQC-regulated support is available through Continuity of Care Services, or bring your own support. Either way, the environment is set up for real routines, day and night, so you are not improvising.',

		'property_label'      => 'The bungalow',
		'property_heading'   => 'One bungalow, and it’s all yours',
		'property_body'      => 'It sits on a quiet residential street in Whitstable, about ten minutes from the seafront. The driveway is private and level, takes two cars including an adapted vehicle, and the front door is straight ahead of you when you park. We’ll send you the address and directions once your stay is confirmed.',
		'property_cta_label' => 'Have a proper look round the rooms',
		'property_cta_url'   => '/the-property/',
		'property_image_id'  => 0,

		'why_label'       => 'Why a house',
		'why_heading'     => 'A wet room in a hotel still comes with the corridor',
		'why_item1_title' => 'Private & personal',
		'why_item1_desc'  => 'The whole bungalow is yours: living space, kitchen, two bedrooms plus a sofa bed in the conservatory (sleeps up to five), with the privacy of a self-catering stay.',
		'why_item2_title' => 'Professional support on your terms',
		'why_item2_desc'  => 'Continuity of Care Services (CQC-regulated): support arranged on your terms, as much or as little as you need, or bring your own carer.',
		'why_item3_title' => 'Local knowledge',
		'why_item3_desc'  => 'We can tell you which cafes have step-free access, where to park near the harbour, and which routes work for wheelchairs, so you spend more time relaxing and less time planning.',
		'why_item4_title' => 'Honest & open',
		'why_item4_desc'  => 'We publish the access specification: exact dimensions, thresholds, and equipment, so you can plan with confidence before you travel.',

		'home_comparison_label'          => 'Compare options',
		'home_comparison_heading'        => 'A wet room in a hotel still comes with the corridor',
		'home_comparison_intro'          => 'Plenty of hotels will tell you they have an accessible room. What they don’t mention is the lift you queue for, the breakfast room you cross, and the feeling of being a logistical problem in somebody else’s building.',
		'home_comparison_row1_feature'   => 'Privacy',
		'home_comparison_row1_restwell'  => 'Whole property',
		'home_comparison_row1_other'     => 'Shared spaces',
		'home_comparison_row2_feature'   => 'Equipment',
		'home_comparison_row2_restwell'  => 'Bedroom ceiling hoist, profiling bed',
		'home_comparison_row2_other'     => 'Limited',
		'home_comparison_row3_feature'   => 'Care',
		'home_comparison_row3_restwell'  => 'Optional, your choice',
		'home_comparison_row3_other'     => 'Fixed or none',
		'home_comparison_row4_feature'   => 'Kitchen',
		'home_comparison_row4_restwell'  => 'Full self-catering',
		'home_comparison_row4_other'     => 'None or limited',

		'home_care_label'       => '',
		'home_care_heading'     => 'Optional home care',
		'home_care_intro'       => 'How you manage your care is entirely up to you. The bungalow rate stays exactly the same whichever you choose:',
		'home_care_item1_title' => 'Bring your own support',
		'home_care_item1_body'  => 'Plenty of guests bring their own carer or manage just like they do at home.',
		'home_care_item2_title' => 'Use our care team',
		'home_care_item2_body'  => 'If you\'d like professional home care, our sister company Continuity of Care Services can come to you. They\'re rated Good by the CQC, and because we share an office and phone number, one conversation covers everything.',
		'home_care_note'        => 'Ring 01622 809881 if that’s easier than a form.',
		'home_care_cta_label'   => 'What home care here actually looks like',
		'home_care_cta_url'     => '/optional-care/',

		'cta_heading'          => 'Ask us anything about a stay',
		'cta_body'            => 'Tell us your dates and what you need from the house. We aim to reply within 48 hours, and there’s no deposit until you’ve decided it fits.',
		'cta_primary_label'   => 'Enquire',
		'cta_primary_url'     => '/enquire/',
		'cta_secondary_label' => 'Look inside the bungalow',
		'cta_secondary_url'   => '/the-property/',
		'cta_promise'         => 'We aim to reply within 48 hours. No deposit until you’ve decided the house fits.',
		'cta_image_id'        => 0,
	);

	if ( function_exists( 'restwell_get_homepage_faq_meta_seed_map' ) ) {
		$defaults = array_merge( $defaults, restwell_get_homepage_faq_meta_seed_map() );
	}

	return $defaults;
}

/**
 * Default meta for the Property page.
 *
 * @return array<string, mixed>
 */
function restwell_get_property_page_defaults() {
	return array(
		'prop_address_street'   => '101 Russell Drive',
		'prop_address_locality' => 'Whitstable',
		'prop_address_region'   => 'Kent',
		'prop_address_postcode' => 'CT5 2RQ',

		'prop_hero_label'               => 'The bungalow',
		'prop_hero_heading'             => 'A proper look round the bungalow',
		'prop_hero_subtitle'            => 'A room-by-room look round Restwell: a single-storey adapted bungalow in Whitstable that sleeps up to five.',
		'prop_hero_cta_text'            => 'Ask about your dates',
		'prop_hero_cta_url'             => '/enquire/',
		'prop_hero_cta_secondary_text'  => 'How it works',
		'prop_hero_cta_secondary_url'   => '/how-it-works/',
		'prop_hero_cta_promise'         => 'We reply within 48 hours.',
		'prop_hero_image_id'            => 0,

		'prop_bungalow_label'   => '',
		'prop_bungalow_heading' => 'Single-storey accessible bungalow in Whitstable',
		'prop_bungalow_body'    => 'Restwell Retreats is a spacious wheelchair-accessible bungalow in a quiet spot close to Whitstable town centre, harbour and beach, and just a few minutes\' walk from Tankerton Beach. A spacious porch with threshold ramp access leads into the hallway, and the whole bungalow is on one level with wide doorways throughout (measurements available on request). It can be tailored to each guest\'s needs, with furniture, beds and equipment rearranged or repositioned on request, and measurements can be provided before you book.',
		'prop_bungalow_image_id' => 0,

		'prop_bedrooms_section_heading' => 'The room with the hoist, and room for everyone else',
		'prop_bedrooms_section_body'    => "The accessible bedroom has a ceiling-track hoist that reaches the whole room and can have one or two adjustable profiling beds, depending on what your group needs. There’s a second double bedroom next door, and the conservatory has a double sofa bed for extra guests. We also have a mobile hoist and a standing aid (an AAL RS4, rated to 185kg).\n\nThe bungalow can sleep up to five people using the accessible bedroom, the second double, and the conservatory sofa bed. Hoists, profiling beds, and wet-room equipment are all included in the price, unless you need something very specific that we don’t have. When you get in touch, we’ll ask about your group and accessibility needs so we can set up the room for you, with one or two profiling beds as needed. For example, a guest once asked us to match her mum’s bedroom layout from home, and we were happy to help.",

		'prop_wetroom_heading' => 'Roll-in shower and accessible washroom',
		'prop_wetroom_body'    => "The step-free wet room includes a roll-in shower, grab rails, shower and commode chairs, a tilt-in-space chair, a height-adjustable 180° spin wash basin, and a Geberit AquaClean wash-dry WC.\n\nThe wet room is arranged to make washing, using the toilet, and transfers easier while you’re here.\n\nAll the equipment mentioned is already installed in the bungalow, so you don’t need to hire or set up anything before you arrive.",

		'prop_living_heading' => 'A comfortable place to come back to',
		'prop_living_body'    => "After time by the sea, the living room gives everyone space to settle in.\n\nYou’ll find a rise-and-recline armchair, a sofa with pull-out footrests, and a TV with Netflix. The open-plan layout makes it easy for wheelchair users, families, and carers to move around comfortably.\n\nThere’s enough seating for everyone, and we keep the space between the sofa and armchair clear so wheelchairs can turn easily.",

		'prop_kitchen_heading' => 'Wheel-under kitchen, ready for everyday meals',
		'prop_kitchen_body'    => "The kitchen features a lowered wheel-under counter, a slide-under oven, microwave, fridge, dishwasher, and all the plates, cutlery, utensils, and cooking basics you’ll need.\n\nIt’s set up for easy breakfasts, family meals, and relaxed evenings at home.\n\nThe hob is gas, not induction, which might be useful to know for your cooking plans.",

		'prop_conservatory_heading' => 'Sunny dining space with level garden access',
		'prop_conservatory_body'    => "The conservatory is a bright space where you can eat, read, or enjoy the garden view.\n\nIt has a fold-out dining table, a double sofa bed, level access to the patio, and laundry cupboards with a washing machine and tumble dryer.",

		'prop_garden_heading' => 'Level patio, enclosed garden, and private driveway',
		'prop_garden_body'    => "French doors open onto a level patio with a non-slip ramp at the threshold.\n\nThe garden is fully enclosed and dog-friendly, with outdoor seating, a BBQ, and fairy lights. You can eat outside or let your dog out safely. Please let us know ahead of time so we can do a quick risk assessment.\n\nAt the front, there’s a resin-bound, level-access driveway with space for two cars. It’s been tested with two wheelchair-accessible vehicles. Portable ramps are kept in the outdoor box by the front door, ready for you to use around the property or take with you during your stay.",

		'prop_throughout_heading' => 'Wide doorways, step-free throughout',
		'prop_throughout_body'    => 'The bungalow is on one level with wide doorways (926 mm and 965 mm clear widths) and step-free routes from the porch through to the patio. Full door and transfer measurements are on the accessibility page if you need them before booking.',

		'prop_care_heading' => 'Optional home care',
		'prop_care_body'    => 'Home care from Continuity can be added on the same enquiry, quoted separately. Bring your own carer if you prefer.',

		'prop_location_heading' => 'A quiet street in Whitstable, close to the coast path',
		'prop_location_body'    => "The bungalow sits on a quiet residential street, a short walk from The Plough pub and about ten minutes on foot from the seafront.\n\nThe beach is shingle, but the wide, paved promenade offers a step-free route along the coast and forms part of the King Charles III England Coast Path.\n\nJoJo’s is about twenty minutes on foot: ten minutes down to the sea, then west along Tankerton promenade. The Marine Hotel sits on that same stretch. A short drive if you’d rather save your energy for lunch.",
		'prop_location_image_id' => 0,

		'prop_tour_living_image_id'        => 0,
		'prop_tour_bedroom_image_id'       => 0,
		'prop_tour_wetroom_image_id'       => 0,
		'prop_tour_kitchen_image_id'       => 0,
		'prop_tour_conservatory_image_id'  => 0,
		'prop_tour_garden_image_id'        => 0,
		'prop_tour_throughout_image_id'    => 0,

		'prop_overview_heading' => 'An accessible bungalow on one level',
		'prop_overview_body'    => 'Restwell Retreats is a spacious wheelchair-accessible bungalow in a quiet spot close to Whitstable town centre, harbour and beach, and just a few minutes\' walk from Tankerton Beach. A spacious porch with threshold ramp access leads into the hallway, and the whole bungalow is on one level with wide doorways throughout (measurements available on request). It can be tailored to each guest\'s needs, with furniture, beds and equipment rearranged or repositioned on request, and measurements can be provided before you book.',

		'prop_dignity_label'    => '',
		'prop_dignity_heading'  => 'An accessible bungalow on one level',
		'prop_dignity_body'     => 'Restwell Retreats is a spacious wheelchair-accessible bungalow in a quiet spot close to Whitstable town centre, harbour and beach, and just a few minutes\' walk from Tankerton Beach. A spacious porch with threshold ramp access leads into the hallway, and the whole bungalow is on one level with wide doorways throughout (measurements available on request). It can be tailored to each guest\'s needs, with furniture, beds and equipment rearranged or repositioned on request, and measurements can be provided before you book.',
		'prop_dignity_image_id' => 0,

		'prop_features_label'   => '',
		'prop_features_heading' => 'At a glance',
		'prop_feature_1'        => 'Two bedrooms',
		'prop_feature_1_desc'   => '',
		'prop_feature_2'        => 'Accessible wet room',
		'prop_feature_2_desc'   => '',
		'prop_feature_3'        => 'Sleeps up to five',
		'prop_feature_3_desc'   => 'Two profiling beds, a double, sofa bed in conservatory',
		'prop_feature_4'        => 'Driveway for two cars',
		'prop_feature_4_desc'   => 'Plus street parking',
		'prop_feature_5'        => 'Full room coverage ceiling hoist',
		'prop_feature_5_desc'   => 'In the accessible bedroom',
		'prop_feature_6'        => 'Step-free throughout',
		'prop_feature_6_desc'   => '',
		'prop_feature_7'        => 'Dog-friendly',
		'prop_feature_7_desc'   => '',
		'prop_feature_8'        => 'Welcome hamper',
		'prop_feature_8_desc'   => 'On every stay',
		'prop_glance_summary'   => 'Two bedrooms, accessible wet room, sleeps up to five (two profiling beds, a double, and a sofa bed in the conservatory), private driveway for two cars plus street parking, dog-friendly.',

		'prop_acc_label'     => '',
		'prop_acc_heading'   => '',
		'prop_acc_intro'     => '',
		'prop_acc_confirmed' => '',
		'prop_acc_tbc'       => '',

		'prop_comparison_label'         => '',
		'prop_comparison_heading'       => '',
		'prop_comparison_intro'         => '',
		'prop_comparison_left_heading'  => '',
		'prop_comparison_right_heading' => '',
		'prop_comparison_left_1'        => '',
		'prop_comparison_left_2'        => '',
		'prop_comparison_left_3'        => '',
		'prop_comparison_left_4'        => '',
		'prop_comparison_right_1'       => '',
		'prop_comparison_right_2'       => '',
		'prop_comparison_right_3'       => '',
		'prop_comparison_right_4'       => '',

		'prop_gallery_label'       => 'Photos',
		'prop_gallery_heading'     => 'See more of the bungalow.',
		'prop_gallery_image_ids'   => '',
		'prop_gallery_btn_1_label' => '',
		'prop_gallery_btn_1_url'   => '',
		'prop_gallery_btn_2_label' => '',
		'prop_gallery_btn_2_url'   => '',
		'prop_gallery_btn_3_label' => '',
		'prop_gallery_btn_3_url'   => '',

		'prop_practical_label'   => '',
		'prop_practical_heading' => '2 bedrooms, 2 parking spaces, sleeps 5',
		'prop_bedrooms_count'    => '2',
		'prop_bedrooms'          => 'Two bedrooms, plus a sofa bed in the conservatory. Sleeps up to five.',
		'prop_bathrooms_count'   => '1',
		'prop_bathroom'          => 'Roll-in shower with grab rails and adjustable basin.',
		'prop_wetroom_walkthrough_url' => 'https://youtube.com/shorts/i1LGyKsyVdw',
		'prop_parking_label'     => 'Parking',
		'prop_parking'           => '2',
		'prop_parking_detail'    => 'Room for two vehicles on the resin-bound private drive',
		'prop_sleeps_value'      => '5',
		'prop_sleeps_label'      => 'Sleeps',
		'prop_distances'         => "Seafront: about 10 min on foot from the driveway\nJoJo’s, Tankerton promenade: about 20 min (10 min to the sea, then west along the prom)",
		'prop_confirm_details_url' => '/enquire/',

		'prop_nearby_label'       => '',
		'prop_nearby_heading'     => 'Accessible days out near Whitstable',
		'prop_nearby_1_title'     => 'The Plough Pub',
		'prop_nearby_1_body'      => "A friendly local pub on St John's Road, just a short walk from the property. Relaxed atmosphere, good food, live music nights, and welcoming to families and groups.",
		'prop_nearby_1_acc'       => 'Wheelchair-accessible entrance and accessible restroom. Confirm current details with the pub.',
		'prop_nearby_1_distance'  => 'Approx. 5 min walk',
		'prop_nearby_1_filter'    => 'wheelchair-friendly quieter',
		'prop_nearby_1_map_url'   => 'https://maps.google.com/?q=The+Plough+St+Johns+Road+Whitstable',
		'prop_nearby_2_title'     => 'Tankerton Slopes & Promenade',
		'prop_nearby_2_body'      => 'A long, flat, surfaced promenade with views across the Thames Estuary. The promenade path itself is wide and level, suitable for wheelchairs and powerchairs. The grassy slopes between the road and the promenade are steep, so use the paved access paths. Free parking along Marine Parade at the top.',
		'prop_nearby_2_acc'       => 'Flat tarmac path, no steps, suitable for wheelchairs. Accessible WC at harbour end.',
		'prop_nearby_2_distance'  => 'About 10 min on foot',
		'prop_nearby_2_filter'    => 'wheelchair-friendly',
		'prop_nearby_2_map_url'   => 'https://maps.google.com/?q=Tankerton+Slopes+Whitstable',
		'prop_nearby_3_title'     => 'Whitstable Harbour & Harbour Street',
		'prop_nearby_3_body'      => 'Fresh oysters, fish and chips, independent restaurants, boutiques, galleries, and cafes. A lively working harbour with a relaxed, artistic character that draws visitors year-round.',
		'prop_nearby_3_acc'       => 'Mostly flat approach. Some cobblestone sections near the harbour. Harbour Street pavements can be narrow during peak times; quieter on weekday mornings.',
		'prop_nearby_3_distance'  => 'Approx. 20 min walk or 7 min drive',
		'prop_nearby_3_filter'    => 'quieter',
		'prop_nearby_3_map_url'   => 'https://maps.google.com/?q=Harbour+Street+Whitstable+Kent',
		'prop_nearby_4_title'     => 'Whitstable Beach',
		'prop_nearby_4_body'      => "Whitstable's iconic shingle beach is beautiful, but we want to be honest: shingle is generally not suitable for wheelchairs. The promenade above provides excellent sea views and is accessible for most wheelchair users.",
		'prop_nearby_4_acc'       => 'Shingle beach is not recommended for wheelchairs. The level promenade path above the beach is the accessible alternative.',
		'prop_nearby_4_distance'  => 'About 10 min on foot',
		'prop_nearby_4_filter'    => 'wheelchair-friendly',
		'prop_nearby_4_map_url'   => 'https://maps.google.com/?q=Whitstable+Beach+Kent',
		'prop_nearby_5_title'     => 'Supermarkets',
		'prop_nearby_5_body'      => "Sainsbury's is the closest at 4 minutes (Reeves Way, Chestfield CT5 3QS). Tesco Extra is 7 minutes (Millstrood Rd CT5 3EE). Co-op is 9 minutes (14-16 Canterbury Rd CT5 4EX). Aldi is 10 minutes (Prospect Retail Park CT5 3SD). All have accessible parking.",
		'prop_nearby_5_acc'       => 'All four stores have step-free access and accessible parking bays.',
		'prop_nearby_5_distance'  => 'From 4 min drive',
		'prop_nearby_5_filter'    => 'practical',
		'prop_nearby_5_map_url'   => 'https://maps.google.com/?q=Sainsbury%27s+Whitstable+Chestfield',
		'prop_nearby_6_title'     => 'Local Pharmacies',
		'prop_nearby_6_body'      => 'Boots Pharmacy and Superdrug Pharmacy are both in Whitstable town centre and open 7 days a week. Hours may vary slightly on Sundays; check locally if urgent.',
		'prop_nearby_6_acc'       => 'Accessible entrances. Confirm current details with each pharmacy.',
		'prop_nearby_6_distance'  => 'Short drive or bus to town',
		'prop_nearby_6_filter'    => 'practical',
		'prop_nearby_6_map_url'   => 'https://maps.google.com/?q=Boots+Pharmacy+Whitstable',
		'prop_nearby_7_title'     => 'Getting Around',
		'prop_nearby_7_body'      => 'Accessible taxis: Abacus Cars LTD (01227 277745). Pre-book wheelchair-accessible vehicles, especially during school run times. Stagecoach South East: the 400 bus from The Plough runs to the beach, harbour, and Canterbury bus station. Whitstable Railway Station has direct trains to London St Pancras and Victoria; Chestfield & Swalecliffe is a quieter alternative nearby.',
		'prop_nearby_7_acc'       => 'Pre-book accessible vehicles with Abacus Cars. Bus stops within walking distance. Confirm station accessibility with National Rail.',
		'prop_nearby_7_distance'  => 'Various',
		'prop_nearby_7_filter'    => 'practical',
		'prop_nearby_7_map_url'   => 'https://maps.google.com/?q=Whitstable+Railway+Station',
		'prop_nearby_8_title'     => 'Medical & Emergency',
		'prop_nearby_8_body'      => 'Nearest A&E: Kent and Canterbury Hospital, Ethelbert Rd, Canterbury CT1 3NG, approximately 7 miles, 15-20 minutes by car. Non-emergency NHS: call 111. Local GP: Whitstable Medical Practice (approx. 5 min drive). Emergencies: 999.',
		'prop_nearby_8_acc'       => 'Kent and Canterbury Hospital has accessible parking and entrances. Call ahead for GP appointments.',
		'prop_nearby_8_distance'  => 'A&E approx. 7 miles / 15-20 min',
		'prop_nearby_8_filter'    => 'practical',
		'prop_nearby_8_map_url'   => 'https://maps.google.com/?q=Kent+and+Canterbury+Hospital+CT1+3NG',
		'prop_nearby_cta_label'   => 'Questions about access?',
		'prop_nearby_cta_url'     => '/enquire/',

		'prop_cta_heading' => 'See if the bungalow fits your group',
		'prop_cta_body'    => 'Tell us your preferred dates, group size, and any access or equipment needs. We’ll reply with availability, measurements, equipment details, and your next steps.',
		'prop_cta_btn'     => 'Enquire',
		'prop_cta_url'     => '/enquire/',
		'prop_cta_promise' => 'We reply within 48 hours. No booking commitment.',
	);
}

/**
 * Default meta for the How It Works page.
 */
function restwell_get_how_it_works_page_defaults() {
	$defaults = array(
		'hiw_label'   => 'How it works',
		'hiw_heading' => 'The bookends of a holiday should be the easy bit',
		'hiw_intro'   => 'Booking Restwell is three steps: enquire, confirm with a deposit, and arrive from 3pm using a key safe.',

		'hiw_steps_label'   => 'How it works',
		'hiw_steps_heading' => 'Enquire, confirm, arrive',
		'hiw_steps_intro'   => 'Three steps from your first message to the front door. There is no online checkout, and you only pay a deposit after we’ve both agreed the bungalow fits.',
		'hiw_step1_title'   => 'Enquire',
		'hiw_step1_body'    => 'Send us your dates, who’s coming, and anything that would make the house work better for you. We aim to reply within 48 hours. Nothing to pay at this stage.',
		'hiw_step2_title'   => 'Confirm',
		'hiw_step2_body'    => 'We set the house up around what you’ve told us. A 50% deposit reserves the dates; the balance is due a week before you arrive. Care from Continuity stays in the same conversation.',
		'hiw_step3_title'   => 'Arrive',
		'hiw_step3_body'    => 'Check-in is from 3pm, through a key safe. We send the code and the address with your confirmation, never on the website.',
		'hiw_step4_title'   => '',
		'hiw_step4_body'    => '',

		'hiw_arrival_label'       => 'Arrival day',
		'hiw_arrival_heading'     => 'Key-safe from 3pm',
		'hiw_arrival_lede'        => 'There is no reception desk. Park in the driveway, open the key safe, and settle into a house that is already set up for your group.',
		'hiw_arrival_1_dt'        => 'Check-in',
		'hiw_arrival_1_dd'        => 'From 3pm via the key-safe · departure by 11am',
		'hiw_arrival_2_dt'        => 'Parking',
		'hiw_arrival_2_dd'        => 'Level driveway for two cars, including accessible vehicles',
		'hiw_arrival_3_dt'        => 'Ready for you',
		'hiw_arrival_3_dd'        => 'Step-free routes and kit set from your enquiry · guest notes after dates are confirmed',
		'hiw_arrival_link1_label' => 'Tour the property',
		'hiw_arrival_link2_label' => 'Door widths and kit notes',

		'hiw_care_cta_label'   => 'Optional care',
		'hiw_care_cta_heading' => 'Add care only if you need it',
		'hiw_care_cta_body'    => 'Home care from Continuity can be added on the same enquiry, quoted separately. Bring your own team if you prefer.',
		'hiw_care_type1_title' => 'Personal care',
		'hiw_care_type1_text'  => 'Washing, dressing and daily routines on agreed times.',
		'hiw_care_type2_title' => 'Visiting care',
		'hiw_care_type2_text'  => 'Short daytime visits, or support for a promenade or town trip.',
		'hiw_care_type3_title' => 'Mobility and hoisting',
		'hiw_care_type3_text'  => 'Transfers with the on-site ceiling track and wet-room kit.',
		'hiw_care_note'        => 'We do not add anything until you agree to the support package.',
		'hiw_care_cta_btn'     => 'How optional care works',
		'hiw_care_cta_url'     => '/optional-care/',
		'hiw_care_rates_label' => 'See care guide rates',
		'hiw_care_rates_url'   => '/pricing/#care-rates',

		'hiw_cta_heading'         => 'Send dates and access needs',
		'hiw_cta_body'            => 'We will reply with measurements, equipment notes, and your next steps.',
		'hiw_cta_primary_label'   => 'Enquire',
		'hiw_cta_primary_url'     => '/enquire/',
		'hiw_cta_secondary_label' => 'View the property',
		'hiw_cta_secondary_url'   => '/the-property/',

		'hiw_faq_label'   => 'Booking',
		'hiw_faq_heading' => 'Before you enquire',
		'hiw_faq_intro'   => 'We will explain when to pay the deposit, who we invoice, arrival details, and how optional care works with a self-catering stay.',
		'hiw_faq_1_q'     => 'How do I book a stay?',
		'hiw_faq_1_a'     => 'Three steps: send us your dates and what you need, we confirm the bungalow and take a 50% deposit, then you arrive from 3pm using a key safe. Care can go on the same enquiry.',
		'hiw_faq_2_q'     => 'When can care be added?',
		'hiw_faq_2_a'     => 'Mention it when you first write, even if the dates are still vague. We don’t publish a lead time because it depends on what you need and who’s available that week. We’ll give you a real answer quickly.',
		'hiw_faq_3_q'     => 'How can I pay?',
		'hiw_faq_3_a'     => 'We can invoice you, a council, the NHS or a grant body, at the same bungalow rate. Who we invoice doesn’t change the price. See Funding and support for the paperwork.',
		'hiw_faq_4_q'     => 'Can a local authority, case manager or NHS team book for me?',
		'hiw_faq_4_a'     => 'Yes. Funded bookings are welcome, and funders can confirm a booking with a purchase order on the same payment timeline as every guest.',
	);
	return $defaults;
}

/**
 * Default meta for the Accessibility page.
 */
function restwell_get_accessibility_page_defaults() {
	return array(
		'acc_label'   => 'Accessibility',
		'acc_heading' => 'The wet room, the hoists, and every measurement',
		'acc_intro'   => 'The full access statement for Restwell: exact door widths, hoist capacity and the level-access wet room.',

		'acc_stat_1_label' => 'Clear opening, front door',
		'acc_stat_1_value' => '965mm',
		'acc_stat_2_label' => 'Clear width, internal doors',
		'acc_stat_2_value' => '926mm',
		'acc_stat_3_label' => 'Ceiling track hoist over the bed',
		'acc_stat_3_value' => 'Full-room',

		'acc_fit_label'         => 'Door clearances',
		'acc_fit_heading'       => 'Compare your chair width to our doorways',
		'acc_fit_intro'         => 'Enter the overall width of the chair you travel with (widest point, including hand rims). We’ll show the clearance at each doorway so you can judge the numbers before you enquire.',
		'acc_fit_note'          => 'This is a guide only. Aim for at least 50mm of clearance where you can, and we’re happy to talk through your measurements before you book.',
		'acc_fit_guide_heading' => 'Typical chair widths',
		'acc_fit_guide_intro'   => 'Wheel to wheel, including hand rims. These are common ranges, not a measurement of your chair.',

		'acc_gallery_label'   => 'Equipment',
		'acc_gallery_heading' => 'Tailored to you',
		'acc_gallery_intro'   => 'We prepare the bungalow for you before you arrive, setting up the equipment you need from our list based on what you tell us when you enquire. If anything feels loose or isn’t right, please let us know right away.',

		'acc_room_label'       => 'Access statement',
		'acc_room_heading'     => 'Room by room',
		'acc_room_intro'       => 'Photos of each space, with the confirmed measurements and kit from our property equipment register.',
		'acc_arrival_heading'  => 'Arrival & entrance',
		'acc_arrival_body'     => "Private resin-bound driveway: two off-road spaces (adapted vehicles welcome)\nOn-street parking outside if you need extra room. No residents permit on this road; check signs on arrival in case street rules change\nStep-free path from car to front door\nPorch outer doors 1720mm opening, with a full-width ribbed entrance mat\nInner front door 965mm clear; level threshold, no step\nPortable fold-up ramps kept for the front door — yours for the stay, including days out",
		'acc_inside_heading'   => 'Inside the property',
		'acc_inside_body'      => "All internal doors 926mm clear (white doors with black lever handles for contrast)\nOpen-plan ground floor, no internal steps\nLevel flooring throughout (no carpet lips)\nWet room on the same level as the accessible bedroom",
		'acc_bedroom_heading'  => 'Bedrooms & sleeping',
		/* Summary bullets above ---; kit detail in a disclosure below. */
		'acc_bedroom_body'     => "Amico GoLift 400 ceiling track hoist: full-room coverage, 180kg SWL. Guests bring their own slings\nOxford Midi 180 mobile hoist, also rated to 180kg\nAccora CommunityBed profiling bed, maximum user weight 180kg; a second profiling bed on request\nAAL RS4 standing aid, rated to 185kg. Sleeps up to five (two bedrooms + conservatory sofa bed)\n---\nPressure-relieving mattress: Accora Allevia Comfort FirmEdge or Roma Medical MATT 1\nSpace for a carer on both sides of the bed\nSecond bedroom for additional guests or a support worker\nConservatory double sofa bed — tell us your party layout when you enquire",
		'acc_bathroom_heading' => 'Wet room',
		'acc_bathroom_body'    => "Level-access wet room with no lip. Layout and specification by <a href=\"https://www.carespaces.co.uk/\" target=\"_blank\" rel=\"noopener noreferrer\">Care Spaces</a>\nMira Select Flex TMV3 thermostatic shower, RNIB Tried & Tested\nRaz Design RAZ-AT tilt-in-space shower commode; Drive DeVilbiss stool rated to 136kg\nRopox Swing washbasin 750–950mm; Geberit AquaClean Mera Care wash-dry WC\n---\nNYMAS hinged lift-and-lock toilet support rail with drop-down leg\nPull-cord assistance alarm with reset plate and over-door light\nFloor-level drain, extractor fan, and a bin for continence products (emptied between stays)",
		'acc_kitchen_heading'  => 'Kitchen',
		'acc_kitchen_body'     => "Open-plan kitchen with wheelchair access and reachable worktops\nNEFF Slide & Hide oven — the door folds away underneath so you are not reaching across a hot open door from a seated position\nGas hob (not induction). No electromagnetic field from the cooktop, which many guests with pacemakers prefer\nMicrowave and accessible storage at lower levels",
		'acc_outdoor_heading'  => 'Outdoor spaces',
		'acc_outdoor_body'     => "Conservatory French doors 1720mm opening\nRear French doors 1720mm opening onto the patio, with a non-slip threshold ramp 20mm high × 80mm wide\nLevel patio with hard-standing suitable for wheelchairs\nEnclosed garden and BBQ area beyond the patio",

		'acc_dest_label'             => 'Whitstable',
		'acc_dest_heading'           => 'The destination, honestly.',
		'acc_dest_intro'             => 'Whitstable is a genuinely lovely town, but like most historic coastal places, it has its challenges. Here is the honest picture.',
		'acc_dest_good_heading'      => 'The good',
		'acc_dest_good_body'         => 'The Tankerton promenade is a long, flat, surfaced path along the seafront, one of the most wheelchair-friendly coastal routes in Kent. Free parking at Marine Parade. Accessible toilets at the harbour end. The streets around the property are flat and paved with dropped kerbs.',
		'acc_dest_challenge_heading' => 'The challenges',
		'acc_dest_challenge_body'    => 'Harbour Street and the old town have narrow pavements that get crowded at weekends and in summer. Some shops and cafes have stepped entrances with no ramp. The harbour itself has some uneven surfaces near the fish market. Weekday mornings are the easiest time to visit.',
		'acc_dest_reality_heading'   => 'The reality',
		'acc_dest_reality_body'      => 'Whitstable is more accessible than most UK coastal towns. With a little planning and our local knowledge, we can point you to the best accessible routes, cafes, and experiences. We will share everything we know in your welcome pack.',

		'acc_faq_label'   => 'Equipment & access',
		'acc_faq_heading' => 'Access FAQ',
		'acc_faq_intro'   => 'Questions about ceiling hoist safe working loads, profiling beds, and the details that make a place truly “wheelchair friendly.”',

		'acc_faq_1_q' => 'Can I find a holiday cottage with a ceiling hoist in England?',
		'acc_faq_1_a' => 'Yes, they are uncommon. Confirm fixed ceiling track vs mobile only, coverage, safe working load, sling policy, and bed position under the track. Restwell has an Amico GoLift 400 ceiling track hoist over the profiling bed, safe working load 180kg; full specs are on this page.',
		'acc_faq_2_q' => 'What is a ceiling track hoist in holiday accommodation?',
		'acc_faq_2_a' => 'A ceiling track hoist is fixed to the ceiling and moves a person in a sling along a rail. It’s less bulky than most mobile units. Most guests bring their own slings. Ask about what areas it covers and who can operate it before you arrive.',
		'acc_faq_3_q' => 'What should I check before booking a hoist-equipped holiday let?',
		'acc_faq_3_a' => 'Check the hoist type and safe working load, whether the bed is under the track, if there’s same-level wet-room access, space for a second carer, parking, and what’s included versus what needs to be hired. Restwell includes the on-site hoist and wet-room kit in the bungalow rate.',
		'acc_faq_4_q' => 'Can I find a holiday cottage with a profiling bed in the UK?',
		'acc_faq_4_a' => 'Yes, but make sure the bed is actually on site, not just “available to hire.” Ask about the mattress type, size, transfer height, and hoist clearance. Restwell’s accessible bedroom has a profiling bed with a pressure-relieving mattress.',
		'acc_faq_5_q' => 'Can I find a holiday cottage with a hospital-style or profiling bed?',
		'acc_faq_5_a' => 'People searching for a “hospital bed holiday cottage” usually want an adjustable profiling bed at a safe transfer height, in a regular bedroom, not a hospital ward. Restwell’s accessible bedroom has this bed, with the ceiling track above it.',
		'acc_faq_6_q' => 'Why does an adjustable or profiling bed matter in an accessible bedroom?',
		'acc_faq_6_a' => 'Profiling beds help with positioning, pressure care, safer transfers, and overnight care routines when a fixed divan isn’t safe. At Restwell, check the controls, side-rail policy, and space for a carer beside the bed to ensure it meets your needs.',
		'acc_faq_7_q' => 'What accessible equipment should I expect in a specialist holiday let?',
		'acc_faq_7_a' => 'Ask for a published equipment list. Restwell includes a profiling bed, ceiling- and mobile hoists, a level-access wet room with a seat and grab rails, a height-adjustable basin, threshold ramps, and parking notes. Never assume “accessible” means a hoist is fitted.',
		'acc_faq_8_q' => 'What should “wheelchair friendly holiday cottage” mean?',
		'acc_faq_8_a' => 'Look for step-free routes, door widths that fit your chair, a bathroom you can use, and parking for accessible vehicles all shown in measurements and photos. If a listing only says “wheelchair friendly,” ask for an access statement or look elsewhere.',
		'acc_faq_9_q' => 'What do I need to check before booking an accessible holiday cottage?',
		'acc_faq_9_a' => 'Check for clear door openings, a step-free route from parking, whether there’s a wet room or adapted bath, hoist type, bed type, turning space, recent entrance and bathroom photos, sling policy, and if care can be arranged separately. Restwell shares all these details on this page.',
		'acc_faq_10_q' => 'What makes an accessible bungalow in the UK suitable for complex needs?',
		'acc_faq_10_a' => 'Being single-storey helps, but accessibility varies a lot. Some people need widened doorways, purpose-built wet rooms, parking, and often a hoist and profiling bed. Restwell is step-free throughout, as shown here.',

		'acc_cta_heading' => 'Ask about your equipment and clearances',
		'acc_cta_body'    => 'If you have questions about door widths, hoist limits, wet-room equipment, or care, we will answer them clearly.',
		'acc_cta_btn'     => 'Enquire',
		'acc_cta_url'     => '/enquire/',
	);
}

/**
 * Default meta for the FAQ page.
 */
function restwell_get_faq_page_defaults() {
	$defaults = array(
		'faq_label'        => 'FAQ',
		'faq_heading'      => 'Questions people ask before they book',
		'faq_intro'        => 'Short answers to what people ask before booking: what Restwell is, whether it fits, and what it costs.',
		'faq_list_label'   => '',
		'faq_list_heading' => 'Frequently asked questions',

		'faq_cta_label'   => '',
		'faq_cta_heading' => 'Send dates and access needs',
		'faq_cta_body'    => 'We reply within 48 hours on most enquiries; phone 01622 809881 if you need to talk it through.',
		'faq_cta_btn'     => 'Enquire',
		'faq_cta_url'     => '/enquire/',
	);

	if ( function_exists( 'restwell_get_faq_page_default_pairs' ) ) {
		$i = 1;
		foreach ( restwell_get_faq_page_default_pairs() as $row ) {
			$defaults[ "faq_{$i}_q" ]   = $row['q'];
			$defaults[ "faq_{$i}_a" ]   = $row['a'];
			$defaults[ "faq_{$i}_cat" ] = isset( $row['cat'] ) ? $row['cat'] : 'about';
			$i++;
		}
	}

	return $defaults;
}

/**
 * Default meta for the Enquire page.
 */
function restwell_get_enquire_page_defaults() {
	return array(
		'enq_label'   => 'Get in touch',
		'enq_heading' => 'Get in touch whenever you’re ready',
		'enq_intro'   => 'Send your dates and what you need, and we’ll reply within 48 hours. There’s no deposit until you’ve decided it fits.',

		'enq_form_heading'        => 'Tell us about your stay',
		'enq_success_heading'     => 'We’ve got your enquiry',
		'enq_success_body'        => 'We’ve emailed you an acknowledgement. Next: a team member reviews your details and replies, usually within 48 hours. Call 01622 809881 if you’d rather talk it through.',
		'enq_success_urgent_body' => 'We’ve flagged this for a priority callback and aim to contact you sooner than our usual 48-hour window. If you need to speak now, call 01622 809881.',

		'enq_contact_heading' => 'Other ways to reach us',
		'enq_email'            => 'hello@restwellretreats.co.uk',
		'enq_phone'            => '01622 809881',
	);
}

/**
 * Default meta for the Pricing page.
 */
function restwell_get_pricing_page_defaults() {
	$faq_defaults = function_exists( 'restwell_get_pricing_faq_defaults' )
		? restwell_get_pricing_faq_defaults()
		: array();

	$defaults = array(
		'pricing_label'         => 'Pricing & dates',
		'pricing_heading'       => 'What a stay here costs',
		'pricing_subheading'    => 'A full week in the bungalow is £1,300 off-peak and £1,400 in peak season. The rate is the same whoever we invoice.',
		'pricing_intro'         => 'Weekly and nightly rates, the deposit, and what’s included, at the same price whoever pays.',
		'pricing_hero_cta_text' => 'Tell us your dates',
		'pricing_hero_cta_url'  => '/enquire/',
		'pricing_hero_cta_promise' => 'No deposit until you’ve decided the house fits.',
		'pricing_rates_label'   => 'Bungalow rates',
		'pricing_rates_heading' => 'Published bungalow rates',
		'pricing_rates_intro'   => 'The bungalow sleeps five people. Prices vary for midweek (Monday to Thursday) and weekend (Friday to Sunday) nights. Care is optional and has a separate charge.',
		'pricing_payment_label'   => 'Deposits and balance',
		'pricing_payment_heading' => 'How payment works',
		'pricing_payment_intro'   => 'You can pay by bank transfer or card. For information about invoicing different funders, see Funding & Support.',
		'pricing_care_rates_label'   => 'Guide rates',
		'pricing_care_rates_heading' => 'Optional care while you stay',
		'pricing_care_rates_intro'   => 'Guide rates for care from Continuity depend on the hours and tasks you need. Continuity will give you a quote after you speak with them.',
		'pricing_faq_label'     => 'FAQ',
		'pricing_faq_heading'   => 'Common questions about pricing',
		'pricing_cta_heading'         => 'Enquire about dates and care',
		'pricing_cta_body'            => 'Let us know your arrival dates, access needs, and if you want support from Continuity. You do not need to pay a deposit until you decide.',
		'pricing_cta_primary_label'   => 'Enquire',
		'pricing_cta_primary_url'     => '/enquire/',
		'pricing_cta_secondary_label' => 'Check availability',
		'pricing_cta_secondary_url'   => '#availability',
	);

	$i = 1;
	foreach ( $faq_defaults as $row ) {
		$defaults[ "pricing_faq_{$i}_q" ] = $row['q'];
		$defaults[ "pricing_faq_{$i}_a" ] = $row['a'];
		$i++;
	}

	return $defaults;
}

/**
 * Default meta for the Resources / Funding & Support page.
 */
function restwell_get_resources_page_defaults() {
	return array(
		'res_label'   => 'Funding & support',
		'res_heading' => 'Paying for a break, without the guesswork',
		'res_intro'   => 'Who can pay for a stay: direct, a council, the NHS or a grant body, and how funding for a break usually works.',

		'res_fund_heading' => 'The house and the care can sit on different invoices',
		'res_fund_body'    => 'A council or CHC team will often pay for care hours, and not the bungalow, or the other way round. Continuity is our sister company, so you still ring us once.',

		'res_grants_heading' => 'Grants and key contacts',
		'res_grants_body'    => 'These are the organisations people actually use. We can’t say yes on their behalf, but we can send whatever paperwork they ask for.',

		'res_chc_heading' => 'Continuing Healthcare and personal health budgets',
		'res_chc_body'    => 'Continuing Healthcare is there to pay for your care, not the holiday itself. Some teams will keep paying your usual hours while you’re away, if they agree it in writing. The bungalow rent is rarely part of that, which is why we keep it on a separate invoice.',

		'res_complaints_heading' => 'What if my funding application is refused?',
		'res_complaints_body'    => 'You can ask for a review. For a local authority decision, that’s your council first (Kent County Council if they funded the assessment), then the Local Government Ombudsman. For NHS CHC, follow the ICB appeals process, then the Parliamentary and Health Service Ombudsman. Scope and Beacon can advise either way, and we’re happy to resend the paperwork.',

		'res_contacts_heading' => 'Who to call',
		'res_contacts_body'    => '',

		'res_cta_heading' => 'Send us your dates and who to invoice',
		'res_cta_body'    => 'We’ll reply with a bungalow quote at the published rates, the access statement, and Continuity care on the same thread if you asked for it. Just let us know the dates.',
		'res_cta_btn'     => 'Enquire',
		'res_cta_url'     => '/enquire/',
	);
}

/**
 * Default meta for the Guest Guide page.
 */
function restwell_get_guest_guide_page_defaults() {
	$check_in  = 'from 15:00';
	$check_out = 'by 11:00';
	if ( function_exists( 'restwell_get_payment_timeline' ) ) {
		$timeline  = restwell_get_payment_timeline();
		$check_in  = 'from ' . $timeline['check_in'];
		$check_out = 'by ' . $timeline['check_out'];
	}

	return array(
		'gg_checkin_time'    => $check_in,
		'gg_checkout_time'   => $check_out,
		'gg_house_rules'     => "Please treat the property with care; it is someone's home.\nNo smoking anywhere inside the property.\nDogs are allowed, subject to risk assessment and prior notice. Please keep dogs off the furniture.\nPlease lock all doors and close all windows when you go out.\nReport any damages as soon as possible.",
		'gg_departure_notes' => "Strip the beds and leave used linen in the laundry room.\nPlace all rubbish in the bins provided.\nReturn all keys and fobs to the key safe (location shared on arrival).\nClose all windows and lock all doors.\nLeave the property in a tidy condition. Thank you!",
		'gg_parking_info'    => "Two off-road spaces on the private driveway at the property, enough room for most cars and adapted vehicles if you deploy ramps thoughtfully.\nIf you are bringing more than two cars, you can usually park on the road outside. There is no residents permit scheme on this road, and we have not seen time-limited bay controls here. Please still check any street signs when you arrive in case local rules change.",
		'gg_local_info'      => "The seafront is about ten minutes on foot from the driveway, via a flat, paved route.\nTankerton promenade is the level stretch once you get there. Places along it, such as JoJo’s, take longer because you then walk west along the prom, roughly twenty minutes all in. The grassy slopes above the promenade are steep, so stick to the paved path. Free parking is available along Marine Parade at the top.\nTesco Extra (Whitstable) is a 7-minute drive and has accessible parking, automatic doors, and a wheelchair-friendly layout.\nWheelchair and equipment hire is available locally; we can share details of trusted suppliers before your stay. Just ask.",
	);
}

/**
 * Default meta for the Who It's For page.
 */
function restwell_get_who_its_for_page_defaults() {
	return array(
		'wif_label'         => 'Who it is for',
		'wif_heading'       => 'Is this the right house for your group?',
		'wif_intro'         => 'Built for disabled adults, families and carers, in parties of up to five. A holiday let, not a care home or respite centre.',
		'wif_hero_image_id' => 0,

		'wif_audience_heading' => 'Who Restwell is built for',
		'wif_audience_intro'   => 'Families, carers, OTs and commissioners use the same published door widths and kit list, then decide if this bungalow fits before they travel.',

		'wif_nav_family_label'        => "I'm a guest or family",
		'wif_nav_carers_label'        => "I'm a carer",
		'wif_nav_ot_label'            => "I'm an OT / case manager",
		'wif_nav_commissioners_label' => "I'm a commissioner",

		'wif_family_title' => 'Guests and families',
		'wif_family_body'  => 'Hoist and wet room already fitted; measurements published; a private home, not a hotel room.',
		'wif_family_detail_bullets'   => "Ceiling track hoist in the accessible bedroom, profiling bed, and wet room with roll-in shower.\nPublished access measurements before you commit.\nA private self-catering layout: your daily routines run on your schedule.",
		'wif_family_inline_cta_label' => 'Read accessibility specification',
		'wif_family_inline_cta_url'   => '/accessibility/',

		'wif_carers_title' => 'Carers and support workers',
		'wif_carers_body'  => 'Separate sleeping and space to assist without blocking hall routes. Ask your council about a Carer’s Assessment under the Care Act 2014 if you need funding for a break.',
		'wif_carers_detail_bullets'   => "Separate sleeping area for the support worker or carer.\nWet room designed for assisted personal care on the same level.\nYou have a legal right to a Carer's Assessment under the Care Act 2014.",
		'wif_carers_inline_cta_label' => 'Ask a suitability question',
		'wif_carers_inline_cta_url'   => '/enquire/',

		'wif_ot_title' => 'Occupational therapists',
		'wif_ot_body'  => 'Published doorway widths, hoist and wet-room specs. Ask for unpublished clearances; we’ll measure.',
		'wif_ot_detail_bullets'   => "Doorway widths, turning circles, hoist specs, and wet room measurements on request.\nTransfer clearances and equipment positioning confirmed if not already published.\nReferral conversations welcomed before any booking commitment.",
		'wif_ot_inline_cta_label' => 'Review accessibility details',
		'wif_ot_inline_cta_url'   => '/accessibility/',

		'wif_commissioners_title' => 'Commissioners & social care',
		'wif_commissioners_body'  => 'Care Act short breaks; documentation for direct payments, PHB or CHC. Same rates regardless of who we invoice.',
		'wif_commissioners_detail_bullets'   => "Short breaks at a private adapted setting can form part of a care and support plan under the Care Act 2014.\nDocumentation provided: property spec, access measurements, and CQC-registered care provider confirmation.\nDirect payments, personal health budgets, and CHC pathways all supported.",
		'wif_commissioners_inline_cta_label' => 'Enquire about a funded stay',
		'wif_commissioners_inline_cta_url'   => '/enquire/',

		'wif_visual_intro' => 'These three items are on site before arrival, not hired for the week.',

		'wif_section_image_1_caption' => 'Level-access wet room',
		'wif_section_image_2_caption' => 'Ceiling track hoist',
		'wif_section_image_3_caption' => 'Reachable kitchen',

		'wif_funding_heading' => 'Who we can invoice',
		'wif_funding_body'    => 'If a stay is funded through a local authority, CHC, direct payments or a personal budget, the bungalow rate stays the same. Funding only changes who we invoice.',

		'wif_fund_la_title'     => 'Local authority & direct payments',
		'wif_fund_la_bullets'   => "Begins with a Care and Support Assessment. Unpaid carers can request a Carer's Assessment too (Care Act 2014).\nDirect payments: you receive the funding and choose your provider.\nCapital limits 2024/25: above £23,250 you pay in full; below £14,250 is usually ignored.",
		'wif_fund_la_cta_label' => 'Direct payments guide',
		'wif_fund_la_cta_url'   => '/direct-payment-holiday-accommodation/',

		'wif_fund_phb_title'     => 'Personal health budget',
		'wif_fund_phb_bullets'   => "Available for people with continuing healthcare needs, subject to eligibility assessment.\nYour ICB or NHS continuing healthcare team manages the application.\nA private adapted setting can be written into a care and support plan where clinically appropriate.",
		'wif_fund_phb_cta_label' => 'PHB and funding overview',
		'wif_fund_phb_cta_url'   => '/resources/',

		'wif_fund_private_title'     => 'Private / self-funded',
		'wif_fund_private_bullets'   => "The same clear accessibility information and direct answers as for funded guests.\nDocumentation for insurers or employers if you need it.\nNo pressure: we tell you plainly whether the property is a good fit.",
		'wif_fund_private_cta_label' => 'Ask about your dates',
		'wif_fund_private_cta_url'   => '/enquire/',

		'wif_cta_heading'         => 'Describe the party and equipment',
		'wif_cta_body'            => 'We’ll say straight whether the bungalow fits, or where it doesn’t.',
		'wif_cta_primary_label'   => 'Enquire',
		'wif_cta_primary_url'     => '/enquire/',
		'wif_cta_secondary_label' => 'Read accessibility',
		'wif_cta_secondary_url'   => '/accessibility/',
	);
}

/**
 * Default meta for the Whitstable Guide page.
 */
function restwell_get_whitstable_guide_page_defaults() {
	return array(
		'wg_label'         => 'Whitstable & Kent coast',
		'wg_heading'       => 'What a day out from the bungalow is actually like',
		'wg_intro'         => 'What we know about getting around Whitstable and Tankerton: the level routes, the ones that aren’t, and where to eat.',
		'wg_hero_image_id' => 0,
		'wg_about_heading' => 'Tankerton promenade',
		'wg_about_body'    => 'About two miles of paved route from Tankerton Slopes toward the castle and harbour. Beach slopes to the shingle are steep, stick to the promenade for level sea air.',
		'wg_towns_heading' => 'Wildwood, Dreamland and Canterbury',
		'wg_towns_body'    => 'Check each venue’s site for scooter hire, companion tickets and parking for your dates.',
		'wg_getting_here_heading' => 'At the house and in town',
		'wg_getting_here_body'    => 'Start from the driveway when you can. Harbour ANPR is the one that catches people out.',
		'wg_getting_around_heading' => 'Station, buses and taxis',
		'wg_getting_around_body'    => 'Travel times from London are in the strip above. Below: how to move around Whitstable once you’ve arrived.',
		'wg_spotlight_image_1_id' => 0,
		'wg_spotlight_image_1_caption' => 'Colourful beach huts along the Whitstable seafront',
		'wg_spotlight_image_2_id' => 0,
		'wg_spotlight_image_2_caption' => 'Whitstable harbour area at sunset',
		'wg_spotlight_image_3_id' => 0,
		'wg_spotlight_image_3_caption' => 'Coastal walk near the Whitstable beach pubs',
		'wg_access_label'            => 'Along the route',
		'wg_access_heading'          => 'Castle, harbour and beach pub',
		'wg_access_intro'            => 'Level stops on the promenade route, with access notes and links so you can check opening times before you set out.',
		'wg_spotlight_label'         => 'Visual guide',
		'wg_spotlight_heading'       => 'Key local areas at a glance',
		'wg_spotlight_intro'         => 'Photos help you picture routes and surfaces before you arrive.',
		'wg_related_label'           => 'Related reading',
		'wg_related_heading'         => 'Local Whitstable guides',
		'wg_related_intro'           => 'Long-tail notes on parking, trains, eating out, beaches and quieter timing. This page stays the Whitstable Kent coast overview.',
		'wg_planning_label'          => 'Loos along the way',
		'wg_planning_heading'        => 'Accessible toilets',
		'wg_planning_intro'          => 'Public and venue loos on the promenade route. Changing Places at the harbour needs a RADAR key.',
		'wg_planning_before_heading' => '',
		'wg_planning_day_heading'    => '',
		'wg_planning_before_bullets' => "Behind the sailing club at the foot of the slopes\nBy the Marine Parade cafe at the top\nUnder the promenade cafe near the castle\nChanging Places: Whitstable Harbour WC, Harbour Road\nJoJo’s Tankerton and Marine Hotel (venue accessible loos)",
		'wg_planning_day_bullets'    => '',
		'wg_eating_label'            => 'Places to eat',
		'wg_eating_heading'          => 'Pubs and restaurants near the house',
		'wg_eating_intro'            => 'The Plough is around the corner; JoJo’s and the Marine Hotel sit on Tankerton. Most Whitstable venues are older buildings, call ahead if access is critical.',
		'wg_eating_body'             => '',
		'wg_cta_heading'         => 'Ask for route notes for your party',
		'wg_cta_body'            => 'Tell us chair size and energy levels, then look inside the bungalow.',
		'wg_cta_primary_label'   => 'Enquire',
		'wg_cta_primary_url'       => '/enquire/',
		'wg_cta_secondary_label'   => 'See the bungalow',
		'wg_cta_secondary_url'     => '/the-property/',
		'wg_cta_blog_label'        => 'Read local articles',
		'wg_cta_blog_url'          => '/blog/',
	);
}

/**
 * Default meta for the Optional care page.
 *
 * @return array<string, mixed>
 */
function restwell_get_care_page_defaults() {
	return array(
		'care_label'   => 'Optional care',
		'care_heading' => 'Care during your stay, arranged in the same conversation',
		'care_intro'   => 'Optional home care from Continuity of Care Services, our CQC-rated sister company, arranged on the same enquiry.',

		'care_sister_label'       => 'Sister company',
		'care_sister_heading'     => 'One conversation if you need both the bungalow and care',
		'care_sister_lede'        => 'Victoria Walker owns Restwell and is Continuity’s CQC registered manager. That’s why one call can cover the house and the care, without a handover to somebody else.',
		'care_sister_1_title'     => 'Optional, not automatic',
		'care_sister_1_body'      => 'We only introduce Continuity if you ask. Care is never forced into the bungalow rate.',
		'care_sister_2_title'     => 'Ask when you enquire',
		'care_sister_2_body'      => 'Dates, access needs and care can sit in one conversation on 01622 809881.',
		'care_sister_3_title'     => 'Bring your own team',
		'care_sister_3_body'      => 'Familiar carers are welcome; the layout works with visiting Continuity staff or your own rota.',
		'care_sister_note'        => 'We add nothing until you agree the support package.',
		'care_sister_rates_label' => 'See care guide rates',

		'care_support_label'   => 'Support options',
		'care_support_heading' => 'What support looks like',
		'care_support_1_title' => 'Personal care',
		'care_support_1_body'  => 'Support with washing, dressing and daily routines on your schedule.',
		'care_support_2_title' => 'Visiting care',
		'care_support_2_body'  => 'Short daytime visits, or support for a promenade or town trip.',
		'care_support_3_title' => 'Overnight cover',
		'care_support_3_body'  => 'Sleep-in or waking night support when daytime visits are not enough.',
		'care_support_4_title' => 'Mobility and hoisting',
		'care_support_4_body'  => 'Transfers with trained carers, using the ceiling track and wet-room kit already in the house.',

		'care_own_label'   => 'Your own team',
		'care_own_heading' => 'Bringing your own carer',
		'care_own_1_title' => 'No extra fee',
		'care_own_1_body'  => 'Bring your own carer or PA at no extra charge; the bungalow rate is the same either way.',
		'care_own_2_title' => 'Separate sleeping space',
		'care_own_2_body'  => 'The second double bedroom, or the conservatory’s double sofa bed, keeps your carer’s sleeping space away from yours.',
		'care_own_3_title' => 'Room to park',
		'care_own_3_body'  => 'The driveway holds two cars, so a carer’s vehicle can park alongside yours.',

		'care_how_label'       => 'Getting started',
		'care_how_heading'     => 'How care is arranged',
		'care_how_lede'        => 'This is the care conversation specifically; see How It Works for the full booking journey from enquiry to arrival.',
		'care_how_step1_title' => 'Enquire as usual',
		'care_how_step1_body'  => 'Share dates, access needs, and any support you think would help. Call 01622 809881 or use the enquire form. No separate care booking maze.',
		'care_how_step2_title' => 'Agree tasks and hours',
		'care_how_step2_body'  => 'If care is needed, Continuity confirms what is possible and what it costs. Many packages settle on the first call; a short follow-up covers overnight or complex rotas.',
		'care_how_step3_title' => 'Guide rates, then your figure',
		'care_how_step3_body'  => 'Guide rates live on Pricing & dates. Continuity quotes your care cost once hours and tasks are agreed.',

		'care_cqc_label'      => 'Regulation',
		'care_cqc_heading'    => 'What CQC-regulated means',
		'care_cqc_body_1'     => 'The Care Quality Commission (CQC) inspects and rates health and social care providers in England against standards of safety, effectiveness and leadership. Continuity of Care Services holds a CQC rating of Good; Victoria Walker, who owns Restwell, is Continuity’s registered manager. Read the published report yourself rather than take our word for it.',
		'care_cqc_body_2'     => 'Restwell is the accommodation, not the regulated care provider. When care is arranged during your stay, Continuity of Care Services delivers it under that CQC registration: the accountability of a regulated provider, not an informal or unregistered introduction.',
		'care_cqc_link_label' => 'Read the CQC inspection profile',

		'care_pro_label'   => 'For professionals',
		'care_pro_heading' => 'For OTs, case managers and commissioners',
		'care_pro_lede'    => 'Restwell and Continuity can support a funded short break with care alongside it: here’s what each side provides. See Who It’s For for guest, carer and professional-referrer suitability at a glance.',
		'care_pro_1_title' => 'Access evidence',
		'care_pro_1_body'  => 'Published door widths, hoist and wet-room specs; we’ll measure unpublished clearances on request.',
		'care_pro_2_title' => 'Care documentation',
		'care_pro_2_body'  => 'Continuity confirms the care plan and cost once hours and tasks are agreed: the detail a funding panel needs to approve a break.',
		'care_pro_3_title' => 'Funding routes',
		'care_pro_3_body'  => 'Care Act short breaks, direct payments, personal health budgets or NHS CHC: the bungalow rate is the same whoever we invoice.',
		'care_pro_4_title' => 'One number for both',
		'care_pro_4_body'  => 'Restwell and Continuity share 01622 809881, so access needs and a care conversation can happen in one call.',

		'care_faq_label'   => 'Care questions',
		'care_faq_heading' => 'Optional care FAQ',
		'care_faq_intro'   => 'Whether care is required, who Continuity is, and where guide rates live.',
		'care_faq_1_q'     => 'Do I have to book care?',
		'care_faq_1_a'     => 'No. Many guests book the house as a self-catering holiday and need no additional support. Continuity care is optional.',
		'care_faq_2_q'     => 'Is Restwell a care home?',
		'care_faq_2_a'     => 'No. Restwell is a private holiday bungalow. Continuity of Care Services (our sister company) is the CQC-regulated provider if you want professional care during your stay.',
		'care_faq_3_q'     => 'Do I book care separately?',
		'care_faq_3_a'     => 'No. Ask when you enquire about the bungalow. Restwell and Continuity share 01622 809881, so house and care can start in one conversation when you want both.',
		'care_faq_4_q'     => 'Can I bring my own carers?',
		'care_faq_4_a'     => 'Yes. The layout supports familiar routines, with separate sleeping and space to assist. Tell us your party layout when you enquire.',
		'care_faq_5_q'     => 'Where do I see guide rates?',
		'care_faq_5_a'     => 'On Pricing & dates. They are Continuity guide rates only. Continuity quotes your care cost once hours and tasks are agreed.',

		'care_cta_heading'         => 'Ask about care with your enquiry',
		'care_cta_body'            => 'Share your dates and what support would help.',
		'care_cta_primary_label'   => 'Enquire',
		'care_cta_primary_url'     => '/enquire/',
		'care_cta_secondary_label' => 'See guide rates',
		'care_cta_secondary_url'   => '/pricing/#care-rates',
	);
}

/**
 * Default meta for the Our Story page.
 *
 * @return array<string, mixed>
 */
function restwell_get_our_story_page_defaults() {
	return array(
		'story_label'   => 'Our story',
		'story_heading' => 'Why Restwell exists',
		'story_intro'   => 'We started Restwell because of a gap we kept running into from the other side of it.',

		'story_origin_label'   => 'The gap',
		'story_origin_heading' => 'How Restwell started',
		'story_origin_lede'    => 'Continuity of Care Services has been supporting people in their own homes across Kent for years. In that time we lost count of the families who wanted a holiday and couldn’t make one work, not because of money, and not because of the care, but because the houses on offer weren’t honest.',
		'story_origin_body'    => 'Somebody would arrive after a three-hour drive to find a doorway they couldn’t get through. So we bought a bungalow in Whitstable that needed a lot of work, and we adapted it properly. Then we wrote down every measurement, including the ones that aren’t flattering, because that was the whole problem: nobody else had.',

		'story_month_label'   => 'The build',
		'story_month_heading' => 'How the bungalow was built',
		'story_month_lede'    => 'Family, friends, and three specialist teams did the work. Occupational therapists at Kent Community Health NHS Trust advised on the bedroom and wet room before a guest ever stayed.',
		'story_month_1_meta'  => 'Early March',
		'story_month_1_title' => 'We got the keys',
		'story_month_1_body'  => 'The bungalow needed more than a lick of paint.',
		'story_month_2_meta'  => 'During the build',
		'story_month_2_title' => 'The specialists',
		'story_month_2_body'  => 'The accessible bedroom and wet room were built by Care Spaces by Wealden Rehab and Thor Carpentry, with the occupational therapists’ advice. Family and friends filled the rest.',
		'story_month_3_meta'  => 'Four weeks later',
		'story_month_3_title' => 'The bungalow was ready',
		'story_month_3_body'  => 'Then we measured all of it and wrote the numbers down.',

		'story_host_label'   => 'Who runs both',
		'story_host_heading' => 'Victoria Walker',
		'story_host_lede'    => 'The link between the two companies is a person. Victoria owns Restwell and is Continuity’s registered manager, so one person is accountable for the house and for the care. Day to day you are more likely to speak to someone else in the office, and they work across both as well.',

		'story_companies_label'     => 'Two companies',
		'story_companies_heading'   => 'Two companies, one conversation',
		'story_companies_lede'      => 'Restwell is the house. Continuity is the care. They bill you separately, and that is deliberate rather than awkward: funders usually treat accommodation and care as two different budgets, so keeping them apart makes your paperwork simpler, not harder.',
		'story_companies_1_title'   => 'Restwell',
		'story_companies_1_body'    => 'The house. A private adapted bungalow, not a care home or respite centre. Separate invoice from any care.',
		'story_companies_2_title'   => 'Continuity of Care Services',
		'story_companies_2_body'    => 'Optional home care during a stay, invoiced separately. Victoria is their registered manager.',
		'story_companies_3_title'   => 'Same conversation',
		'story_companies_3_body'    => 'One office, one number. The house and the care get sorted in the same call.',
		'story_companies_note'      => 'Restwell is not a registered care provider and doesn’t pretend to be one. We’re a house. We mention Continuity’s rating so you know exactly who is accountable for the care, and can go and read the report yourself.',
		'story_companies_cqc_label' => 'Read Continuity’s CQC profile',

		'story_shaped_label'   => 'Shaped by real needs',
		'story_shaped_heading' => 'Designed with the people who’d actually stay',
		'story_shaped_lede'    => 'Individuals with muscular dystrophy, cerebral palsy, and people recovering from strokes told us what mattered for transfers, what got in the way, and what “accessible” meant for them. The layout and the kit came from those conversations rather than from a plan on paper.',

		'story_specialists_label'      => 'Check it yourself',
		'story_specialists_heading'    => 'The numbers are published so you don’t have to trust us',
		'story_specialists_lede'       => 'Every measurement is on the Accessibility page, including the ones that aren’t flattering. Measure your own chair, your own hoist, your own doorways at home, and compare them. That is what the houses we kept sending people to would never do.',
		'story_specialists_btn1_label' => 'Read the access specs',
		'story_specialists_btn2_label' => 'Tour the property',

		'story_next_label'   => 'What we’re trying to do',
		'story_next_heading' => 'Nothing very complicated',
		'story_next_lede'    => 'Publish the numbers. Say what the house can’t do as clearly as what it can. Make it possible to arrange a week away, and the support to enjoy it, in a single conversation, without anyone having to explain their situation four times to four different people.',

		'story_cta_heading'         => 'See what that means in the bungalow',
		'story_cta_body'            => 'You can look at door widths, hoist details, and room photos before reaching out.',
		'story_cta_primary_label'   => 'Enquire',
		'story_cta_primary_url'     => '/enquire/',
		'story_cta_secondary_label' => 'Tour the property',
		'story_cta_secondary_url'   => '/the-property/',
	);
}

/**
 * Add Theme Setup under Appearance.
 */
