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
		'hero_subheading'          => 'A private, single-storey bungalow a short walk from the sea, with a level wet room and a ceiling track hoist already fitted. Home care from our sister company is there if you’d like it.',
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
		'property_heading'   => 'A private bungalow that sleeps five',
		'property_body'      => "It sits on a quiet residential street in Whitstable, about ten minutes from the seafront. The driveway is private and level. It takes two cars, including an adapted vehicle, and the front door is straight ahead when you park.\n\nInside there are two bedrooms and a double sofa bed in the conservatory, so up to five people can stay. You can book from a single night, and we’ll set the bedroom up around what you tell us before you arrive. We’ll send the address and directions once your stay is confirmed.",
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

		'home_care_label'       => 'Home care on holiday',
		'home_care_heading'     => 'Optional home care',
		'home_care_intro'       => 'How you handle care on holiday is up to you, and most guests do one of two things.',
		'home_care_item1_title' => 'Bring your own support',
		'home_care_item1_body'  => 'Plenty of guests bring their own carer or PA, or simply manage the way they do at home, and the second bedroom gives a carer somewhere proper to sleep.',
		'home_care_item2_title' => 'Add care from Continuity',
		'home_care_item2_body'  => 'Our sister company, Continuity of Care Services, can come into the bungalow while you’re here. They’re rated Good by the CQC, and because we share an office and a phone number, one call covers the house and the care.',
		'home_care_note'        => 'Ring 01622 809881 if that’s easier than a form.',
		'home_care_cta_label'   => 'What home care here actually looks like',
		'home_care_cta_url'     => '/optional-care/',

		'cta_heading'          => 'Ask us anything about a stay',
		'cta_body'            => 'Tell us your dates and what you need from the house, and we’ll aim to reply within 48 hours. There’s no deposit to pay until we’ve talked it through and you’re happy it fits.',
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
		'prop_hero_heading'             => 'Inside the bungalow, room by room',
		'prop_hero_subtitle'            => 'Here’s a walk round Restwell, room by room. It’s a single-storey adapted bungalow on a quiet street in Whitstable, with two bedrooms and space for up to five people.',
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

		'prop_bedrooms_section_heading' => 'Two bedrooms and a sofa bed, for up to five',
		'prop_bedrooms_section_body'    => "The accessible bedroom has a ceiling track hoist that covers the whole room, and we set it up with one or two profiling beds, depending on what you tell us when you book. If you’d like the furniture moved to match the way things are at home, just say, and it’ll be ready when you arrive.\n\nThe second bedroom next door has a double bed, and the conservatory has a double sofa bed, so up to five people can stay. The hoists, the standing aid and the profiling beds are all included in the price.",

		'prop_wetroom_heading' => 'Level-access wet room',
		'prop_wetroom_body'    => "The wet room is step-free from the door to the shower. It has grab rails, a shower stool and a tilt-in-space shower chair, a basin that swings round and moves up and down to the height you need, and a wash-and-dry toilet.\n\nIt’s all fitted already, so there’s nothing to hire or set up before you arrive. If you’d like the makes, models and safe working loads, you’ll find them on the Accessibility page.",

		'prop_living_heading' => 'Open-plan living room',
		'prop_living_body'    => "The living room is open-plan, with a rise-and-recline armchair, a sofa with pull-out footrests and a TV with Netflix. There’s room for wheelchairs, carers and family to get past each other.\n\nWe keep the floor between the sofa and the armchair clear so a wheelchair can turn. There’s free high-speed WiFi throughout, which matters more than people admit when someone needs to keep an eye on work or a hospital app.",

		'prop_kitchen_heading' => 'Kitchen with a wheel-under worktop',
		'prop_kitchen_body'    => "The kitchen has a lowered worktop you can wheel under, an oven with a door that slides away underneath, a microwave, a fridge and a dishwasher. You’ll also find plates, pans, cutlery and the cooking basics.\n\nThe hob is gas rather than induction, which is worth knowing when you plan what to cook.",

		'prop_conservatory_heading' => 'Conservatory with level access to the patio',
		'prop_conservatory_body'    => "The conservatory has a fold-out table to eat at and a double sofa bed, and its doors open out level onto the patio.\n\nThe laundry cupboards are in here too, with a washing machine and a tumble dryer.",

		'prop_garden_heading' => 'Level patio, enclosed garden, and private driveway',
		'prop_garden_body'    => "French doors open onto a level patio, with a non-slip ramp over the threshold. The garden is fully enclosed, with outdoor seating, a barbecue and fairy lights.\n\nDogs are welcome, and we just ask you to let us know before you arrive so we can do a quick risk assessment.\n\nAt the front there’s a level, resin-bound driveway with space for two cars, and we’ve tested it with two wheelchair-accessible vehicles. Portable ramps are kept in the outdoor box by the front door, for use around the house or on days out.",

		'prop_throughout_heading' => 'Wide doorways, step-free throughout',
		'prop_throughout_body'    => 'The bungalow is on one level with wide doorways (926 mm and 965 mm clear widths) and step-free routes from the porch through to the patio. Full door and transfer measurements are on the accessibility page if you need them before booking.',

		'prop_care_heading' => 'Optional home care',
		'prop_care_body'    => 'If someone in your group needs help with personal care, our sister company, Continuity, can come into the bungalow, and they’ll quote once you’ve talked through what’s needed. Plenty of guests bring their own carer instead, and the second bedroom is there for them.',

		'prop_location_heading' => 'On a quiet street, ten minutes from the seafront',
		'prop_location_body'    => "The bungalow is on a quiet residential street, a short walk from The Plough pub and about ten minutes on foot from the seafront. Down there, the wide, paved promenade gives you a step-free route along the coast.\n\nThe beach is shingle, so the paved promenade is the step-free way along the seafront.",
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
		'prop_gallery_heading'     => 'More photos of the bungalow',
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
		'prop_cta_body'    => 'Tell us your dates, who’s coming and any access or equipment needs, and we’ll come back with availability and an honest answer on whether the house will work for you.',
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
		'hiw_heading' => 'How booking a stay works',
		'hiw_intro'   => 'There’s no online checkout. You tell us your dates and what you need, we check the house will work for you, and only then do you pay a deposit.',

		'hiw_steps_label'   => 'How it works',
		'hiw_steps_heading' => 'Enquire, confirm, arrive',
		'hiw_steps_intro'   => 'There are three steps between your first message and the front door, and you don’t pay anything until we’ve agreed the house fits.',
		'hiw_step1_title'   => 'Enquire',
		'hiw_step1_body'    => 'Send us your dates, who’s coming and anything that would help the house work for you, like how you’d like the bedroom set up. We aim to reply within 48 hours, and there’s nothing to pay at this stage.',
		'hiw_step2_title'   => 'Confirm',
		'hiw_step2_body'    => 'Once we’ve agreed the house fits, a 50% deposit holds your dates and the rest is due a week before you arrive. In the meantime, we set the furniture and equipment up around what you’ve told us.',
		'hiw_step3_title'   => 'Arrive',
		'hiw_step3_body'    => 'Check-in is from 3pm, and you let yourselves in with a key safe. We send the code and the address with your confirmation, and we never put them on the website.',
		'hiw_step4_title'   => '',
		'hiw_step4_body'    => '',

		'hiw_arrival_label'       => 'Arrival day',
		'hiw_arrival_heading'     => 'What happens on arrival day',
		'hiw_arrival_lede'        => 'There’s no reception desk to queue at. You park on the level driveway, open the key safe and let yourselves into a house that’s already set up for your group.',
		'hiw_arrival_1_dt'        => 'Check-in',
		'hiw_arrival_1_dd'        => 'From 3pm, using the key safe. Check-out is by 11am.',
		'hiw_arrival_2_dt'        => 'Parking',
		'hiw_arrival_2_dd'        => 'A level driveway for two cars, including an adapted vehicle',
		'hiw_arrival_3_dt'        => 'Ready for you',
		'hiw_arrival_3_dd'        => 'Beds and equipment set up as we agreed, with a guest guide sent once your dates are confirmed',
		'hiw_arrival_link1_label' => 'Tour the property',
		'hiw_arrival_link2_label' => 'Door widths and the hoist',

		'hiw_care_cta_label'   => 'Optional care',
		'hiw_care_cta_heading' => 'Adding care to your stay',
		'hiw_care_cta_body'    => 'If you’d like home care while you’re here, mention it in your first message. Continuity, our sister company, will talk it through with you and give you a quote. You’re just as welcome to bring your own carer or PA.',
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

		'hiw_cta_heading'         => 'Tell us your dates',
		'hiw_cta_body'            => 'Let us know when you’d like to come and what you need from the house. We’ll reply with the measurements, equipment details and what happens next.',
		'hiw_cta_primary_label'   => 'Enquire',
		'hiw_cta_primary_url'     => '/enquire/',
		'hiw_cta_secondary_label' => 'View the property',
		'hiw_cta_secondary_url'   => '/the-property/',

		'hiw_faq_label'   => 'Booking',
		'hiw_faq_heading' => 'Questions about booking',
		'hiw_faq_intro'   => 'When the deposit is due, who we can invoice, and how care fits around a self-catering stay.',
		'hiw_faq_1_q'     => 'How do I book a stay?',
		'hiw_faq_1_a'     => 'Send us your dates and what you need, using the form, by email or on 01622 809881. Once we’ve checked the house fits, a 50% deposit holds your dates, and you arrive from 3pm on the day.',
		'hiw_faq_2_q'     => 'When can care be added?',
		'hiw_faq_2_a'     => 'It’s best to mention it in your first message, even if your dates aren’t fixed yet. We don’t publish a lead time, because it depends on what you need and who’s free that week. We’ll give you a straight answer as soon as we can.',
		'hiw_faq_3_q'     => 'How can I pay?',
		'hiw_faq_3_a'     => 'You can pay by bank transfer or card, and we can also invoice a council, the NHS or a grant body directly. The deposit and balance are set out on <a href="/pricing/#payment">Prices and dates</a>, and <a href="/funding-and-support/">Funding and support</a> explains the paperwork.',
		'hiw_faq_4_q'     => 'Can a council, case manager or NHS team book for me?',
		'hiw_faq_4_a'     => 'Yes, and funded bookings are very welcome. A funder can confirm the booking with a purchase order, and the deposit and balance follow the same timings as any other stay.',
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
		'acc_intro'   => 'This is the full access statement for Restwell, our single-storey adapted bungalow in Whitstable, so you can check it against your own needs before you book.',

		'acc_stat_1_label' => 'Front door, clear opening',
		'acc_stat_1_value' => '965mm',
		'acc_stat_2_label' => 'Internal doors, clear width',
		'acc_stat_2_value' => '926mm',
		'acc_stat_3_label' => 'Ceiling hoist, safe working load',
		'acc_stat_3_value' => '180 kg',

		'acc_fit_label'         => 'Door clearances',
		'acc_fit_heading'       => 'Compare your chair width to our doorways',
		'acc_fit_intro'         => 'Type in your chair’s width and see the clearance at each doorway before you enquire.',
		'acc_fit_note'          => 'This is a guide only. Aim for at least 50mm of clearance where you can, and we’re happy to talk your measurements through before you book.',

		'acc_dest_label'             => 'Whitstable',
		'acc_dest_heading'           => 'Getting around Whitstable',
		'acc_dest_intro'             => 'Whitstable is an old seaside town, so some parts are easier to get around than others. Here’s what we’ve found.',
		'acc_dest_good_heading'      => 'The good',
		'acc_dest_good_body'         => 'Tankerton promenade is a long, level, surfaced path along the seafront, and it’s the route most of our guests use. There’s free Blue Badge parking along Marine Parade. There are accessible toilets along the promenade, and a Changing Places toilet at the harbour. The streets around the bungalow are level and paved, with dropped kerbs.',
		'acc_dest_challenge_heading' => 'The challenges',
		'acc_dest_challenge_body'    => 'Harbour Street and the old town have narrow pavements that get crowded at weekends and in summer. Some shops and cafes have a step at the door and no ramp. The ground around the harbour and the fish market can be uneven. Weekday mornings are the easiest time to visit.',
		'acc_dest_reality_heading'   => 'The reality',
		'acc_dest_reality_body'      => 'Our Whitstable guide lists the routes, cafes and accessible toilets we know work, and we send the same notes in your welcome pack.',

		'acc_faq_label'   => 'Equipment & access',
		'acc_faq_heading' => 'Access FAQ',
		'acc_faq_intro'   => 'The questions people ask most about the hoists, the beds and what wheelchair friendly should really mean.',

		'acc_faq_1_q' => 'Do you provide hoist slings?',
		'acc_faq_1_a' => 'No. Please bring the sling the person already uses. Both hoists take loop-style slings on a two-point spreader bar, and the note above the equipment register explains why we can’t supply one.',
		'acc_faq_2_q' => 'What is a ceiling track hoist in holiday accommodation?',
		'acc_faq_2_a' => 'It’s fixed to the ceiling and moves a person in a sling along a rail, so it takes up no floor space and needs no turning circle, unlike a mobile hoist, which has to be wheeled into place. Ours covers the whole of the accessible bedroom, and the details are in the equipment register above.',
		'acc_faq_3_q' => 'Why does a profiling bed matter in an accessible bedroom?',
		'acc_faq_3_a' => 'It helps with positioning, pressure care and safer transfers, and it sets a working height that protects the back of whoever is giving care. A fixed divan gives you none of that, and a mobile hoist often can’t get its legs under one. We have two profiling beds, and the accessible bedroom takes one or both.',
		'acc_faq_4_q' => 'What should wheelchair friendly actually mean?',
		'acc_faq_4_a' => 'It should mean published numbers you can check against your own chair and your own kit, like clear door openings, step-free routes, safe working loads and turning circles. If a listing says wheelchair friendly but won’t give you a measurement when you ask, that tells you what you need to know. Everything we have is on this page.',

		'acc_cta_heading' => 'Ask about your equipment and clearances',
		'acc_cta_body'    => 'If you’ve a question about door widths, hoist limits, the wet room or care, ask us and we’ll give you a clear answer.',
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
		'faq_intro'        => 'These are the things people ask us most before they book. Each answer is short and links to the page with more detail.',
		'faq_list_label'   => '',
		'faq_list_heading' => 'Frequently asked questions',

		'faq_cta_label'   => '',
		'faq_cta_heading' => 'Ask about your dates',
		'faq_cta_body'    => 'Tell us when you’d like to come and what you need. We aim to reply within 48 hours, or you can call 01622 809881 if you’d rather talk it through.',
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
		'enq_heading' => 'Ask us about a stay',
		'enq_intro'   => 'Tell us your dates and what you need from the house, and ask about care on the same form if you’d like it. We aim to reply within 48 hours, and there’s no deposit to pay until we’ve talked it through and you’re sure it fits.',

		'enq_form_heading'        => 'Tell us about your stay',
		'enq_success_heading'     => 'We’ve got your enquiry',
		'enq_success_body'        => 'Thank you, we’ve got your enquiry. We’ve emailed you to confirm, and one of us will read your details and aim to reply within 48 hours. If you’d rather talk it through, call 01622 809881.',
		'enq_success_urgent_body' => 'We’ve marked this as urgent and will try to call you back sooner than our usual 48 hours. If you need to speak to someone now, call 01622 809881.',

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
		'pricing_intro'         => 'Here are the weekly and nightly rates, the nights that are free and how the deposit works. You can stay for one night or a whole week, and the access equipment is included.',
		'pricing_hero_cta_text' => 'Tell us your dates',
		'pricing_hero_cta_url'  => '/enquire/',
		'pricing_hero_cta_promise' => 'No deposit until you’ve decided the house fits.',
		'pricing_rates_label'   => 'Bungalow rates',
		'pricing_rates_heading' => 'Weekly and nightly rates',
		'pricing_rates_intro'   => 'You book the whole bungalow, which sleeps up to five. Weekend nights (Friday to Sunday) cost a little more than midweek nights (Monday to Thursday), and the minimum stay is one night. Care from Continuity is optional, and they’ll give you a quote for it.',
		'pricing_payment_label'   => 'Deposits and balance',
		'pricing_payment_heading' => 'How payment works',
		'pricing_payment_intro'   => 'You can pay by bank transfer or card. If a council, the NHS or a charity is paying, the price is the same, and Funding & Support explains how the invoice works.',
		'pricing_care_rates_label'   => 'Guide rates',
		'pricing_care_rates_heading' => 'Guide rates for optional care',
		'pricing_care_rates_intro'   => 'If you’d like home care during your stay, these are Continuity’s guide rates. What you pay depends on the hours and tasks you need, and Continuity will give you a quote once you’ve talked it through with them.',
		'pricing_faq_label'     => 'Money questions',
		'pricing_faq_heading'   => 'Questions about prices',
		'pricing_faq_intro'     => 'What the bungalow price covers, how care is charged, and what changes when a council or the NHS pays.',
		'pricing_cta_heading'         => 'Ask about dates and care',
		'pricing_cta_body'            => 'Tell us when you’d like to come, what you need from the house and whether you’d like care from Continuity. We aim to reply within 48 hours, and there’s no deposit to pay until you’re happy the house fits.',
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
		'res_heading' => 'Funding an accessible holiday',
		'res_intro'   => 'A stay can be paid for by you, a council, the NHS or a grant body. Here’s how each route usually works, and what to ask before you book.',

		'res_grants_heading' => 'Grants and key contacts',
		'res_grants_body'    => 'These are the organisations people actually use. We can’t say yes on their behalf, but we can send whatever paperwork they ask for.',

		'res_chc_heading' => 'Continuing Healthcare and personal health budgets',
		'res_chc_body'    => 'Continuing Healthcare is there to pay for your care, not the holiday itself. Some teams will keep paying your usual hours while you’re away, if they agree it in writing. The bungalow rent is rarely part of that.',

		'res_complaints_heading' => 'What if my funding application is refused?',
		'res_complaints_body'    => 'You can ask for a review. For a council decision, go to your council first (Kent County Council if they funded the assessment), then the Local Government Ombudsman. For NHS CHC, follow the ICB appeals process, then the Parliamentary and Health Service Ombudsman. Scope and Beacon can advise either way, and we’re happy to resend the paperwork.',

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
		'wif_intro'         => 'Restwell is built for disabled adults, their families and the people who care for them, in groups of up to five. It’s a holiday let you have to yourselves, not a care home or a respite centre.',
		'wif_hero_image_id' => 0,

		'wif_audience_heading' => 'Who Restwell is built for',
		'wif_audience_intro'   => 'Families, carers, occupational therapists and commissioners all work from the same published door widths and equipment list. That way you can decide whether the bungalow fits before anyone travels.',

		'wif_nav_family_label'        => "I'm a guest or family",
		'wif_nav_carers_label'        => "I'm a carer",
		'wif_nav_ot_label'            => "I'm an OT / case manager",
		'wif_nav_commissioners_label' => "I'm a commissioner",

		'wif_family_title' => 'Guests and families',
		'wif_family_body'  => 'The hoist and the wet room are already fitted, and every measurement is published. It’s a private house, so your routines run on your own time rather than a hotel’s.',
		'wif_family_detail_bullets'   => "A ceiling track hoist across the whole bedroom, two profiling beds and a level wet room.\nEvery door width and safe working load published before you book.\nA private, self-catering house, so you keep your own routines.",
		'wif_family_inline_cta_label' => 'Door widths and the hoist',
		'wif_family_inline_cta_url'   => '/accessibility/',

		'wif_carers_title' => 'Carers and support workers',
		'wif_carers_body'  => 'There’s a separate bedroom for a carer or support worker, and room to help with transfers and personal care. If you look after someone, you can ask your council for a carer’s assessment.',
		'wif_carers_detail_bullets'   => "A separate bedroom for the support worker or carer.\nA level-access wet room with space to help with personal care.\nA legal right to a carer’s assessment under the Care Act 2014.",
		'wif_carers_inline_cta_label' => 'Ask a suitability question',
		'wif_carers_inline_cta_url'   => '/enquire/',

		'wif_ot_title' => 'Occupational therapists',
		'wif_ot_body'  => 'Door widths, hoist details and wet room measurements are all published. If you need one we haven’t listed, ask and we’ll go and measure it.',
		'wif_ot_detail_bullets'   => 'You’re welcome to talk a referral through with us before anyone commits to a booking.',
		'wif_ot_inline_cta_label' => 'Door widths and the hoist',
		'wif_ot_inline_cta_url'   => '/accessibility/',

		'wif_commissioners_title' => 'Commissioners & social care',
		'wif_commissioners_body'  => 'A stay here can form part of a Care Act short break. We can supply the paperwork for direct payments, personal health budgets or CHC.',
		'wif_commissioners_detail_bullets'   => "A short break in a private adapted house can be part of a care and support plan under the Care Act 2014.\nWe can send you the house details, the measurements and Continuity’s CQC rating.\nWe can work with direct payments, personal health budgets and CHC funding.",
		'wif_commissioners_inline_cta_label' => 'Enquire about a funded stay',
		'wif_commissioners_inline_cta_url'   => '/enquire/',

		'wif_visual_intro' => 'All three are in the bungalow before you arrive, so there’s nothing to hire for the week.',

		'wif_section_image_1_caption' => 'Level-access wet room',
		'wif_section_image_2_caption' => 'Ceiling track hoist',
		'wif_section_image_3_caption' => 'Reachable kitchen',

		'wif_funding_heading' => 'Who we can invoice',
		'wif_funding_body'    => 'We can invoice you, a council, an NHS team or a grant body. Our funding page explains how each route usually works and what to ask before you book.',

		'wif_fund_la_title'     => 'Local authority & direct payments',
		'wif_fund_la_bullets'   => "It starts with an assessment of your care needs, and unpaid carers can ask for their own assessment too.\nWith direct payments, you hold the money and choose who provides the support.\nWhether a direct payment covers the stay is up to your council, so ask before you book.",
		'wif_fund_la_cta_label' => 'Direct payments guide',
		'wif_fund_la_cta_url'   => '/direct-payment-holiday-accommodation/',

		'wif_fund_phb_title'     => 'Personal health budget',
		'wif_fund_phb_bullets'   => "For people found eligible for NHS Continuing Healthcare.\nYour ICB or continuing healthcare team handles the application.\nA stay in a private adapted house can be written into the plan where it meets the person’s needs.",
		'wif_fund_phb_cta_label' => 'How NHS funding usually works',
		'wif_fund_phb_cta_url'   => '/funding-and-support/',

		'wif_fund_private_title'     => 'Private / self-funded',
		'wif_fund_private_bullets'   => "You get the same access information and straight answers as funded guests.\nWe can send paperwork for your insurer or employer if you need it.\nWe’ll tell you plainly if the bungalow isn’t the right fit.",
		'wif_fund_private_cta_label' => 'Ask about your dates',
		'wif_fund_private_cta_url'   => '/enquire/',

		'wif_cta_heading'         => 'Tell us who’s coming and what you use',
		'wif_cta_body'            => 'We’ll tell you plainly whether the bungalow fits, and where it doesn’t.',
		'wif_cta_primary_label'   => 'Enquire',
		'wif_cta_primary_url'     => '/enquire/',
		'wif_cta_secondary_label' => 'Door widths and the hoist',
		'wif_cta_secondary_url'   => '/accessibility/',
	);
}

/**
 * Default meta for the Whitstable Guide page.
 */
function restwell_get_whitstable_guide_page_defaults() {
	return array(
		'wg_label'         => 'Whitstable & Kent coast',
		'wg_heading'       => 'Accessible days out in Whitstable and Tankerton',
		'wg_intro'         => 'What we know about getting around Whitstable and Tankerton: the level routes, the ones that aren’t, and where to eat.',
		'wg_hero_image_id' => 0,
		'wg_about_heading' => 'Tankerton promenade',
		'wg_about_body'    => 'About two miles of paved path runs from Tankerton Slopes towards the castle and harbour. The slopes down to the shingle are steep, so stay on the promenade for the level route.',
		'wg_towns_heading' => 'Wildwood, Dreamland and Canterbury',
		'wg_towns_body'    => 'Check each venue’s site for scooter hire, companion tickets and parking for your dates.',
		'wg_getting_here_heading' => 'At the house and in town',
		'wg_getting_here_body'    => 'Park on the driveway when you can. In town, the harbour car parks are the ones that catch people out, because they use number-plate cameras.',
		'wg_getting_around_heading' => 'Station, buses and taxis',
		'wg_getting_around_body'    => 'Travel times from London are in the strip at the top of the page. Here’s how to get around Whitstable once you’ve arrived.',
		'wg_spotlight_image_1_id' => 0,
		'wg_spotlight_image_1_caption' => 'Colourful beach huts along the Whitstable seafront',
		'wg_spotlight_image_2_id' => 0,
		'wg_spotlight_image_2_caption' => 'Sailing dinghies drawn up on the shingle at Whitstable at sunset',
		'wg_spotlight_image_3_id' => 0,
		'wg_spotlight_image_3_caption' => 'Shingle beach and timber groynes on the Whitstable shore',
		'wg_access_label'            => 'Along the route',
		'wg_access_heading'          => 'Castle, harbour and beach pub',
		'wg_access_intro'            => 'These are level stops on the promenade route, with access notes and links so you can check opening times before you set out.',
		'wg_spotlight_label'         => 'Visual guide',
		'wg_spotlight_heading'       => 'Key local areas at a glance',
		'wg_spotlight_intro'         => 'Photos help you picture routes and surfaces before you arrive.',
		'wg_related_label'           => 'Related reading',
		'wg_related_heading'         => 'Local Whitstable guides',
		'wg_related_intro'           => 'Longer guides on parking, trains, eating out, beaches and the quieter times to visit.',
		'wg_planning_label'          => 'Loos along the way',
		'wg_planning_heading'        => 'Accessible toilets',
		'wg_planning_intro'          => 'These are the public and venue toilets on the promenade route. The Changing Places toilet at the harbour needs a RADAR key.',
		'wg_planning_before_heading' => '',
		'wg_planning_day_heading'    => '',
		'wg_planning_before_bullets' => "Behind the sailing club at the foot of the slopes\nBy the Marine Parade cafe at the top\nUnder the promenade cafe near the castle\nChanging Places: Whitstable Harbour WC, Harbour Road\nJoJo’s Tankerton and the Marine Hotel, both with accessible loos",
		'wg_planning_day_bullets'    => '',
		'wg_eating_label'            => 'Places to eat',
		'wg_eating_heading'          => 'Pubs and restaurants near the house',
		'wg_eating_intro'            => 'The Plough is around the corner, and JoJo’s and the Marine Hotel are on Tankerton. Most Whitstable venues are in older buildings, so call ahead if access is critical.',
		'wg_eating_body'             => '',
		'wg_cta_heading'         => 'Ask for route notes for your party',
		'wg_cta_body'            => 'Tell us your chair size and how far you like to go in a day, and we’ll point you to the routes that suit.',
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
		'care_heading' => 'Optional home care during your stay',
		'care_intro'   => 'Our sister company, Continuity of Care Services, can come into the bungalow while you’re here, but only if you ask. How much help they can give depends on what you need and who’s free, so we’ll talk it through with you first.',

		'care_day_heading' => 'Morning, daytime and overnight help',
		'care_day_lede' => 'Tell us what a normal day looks like at home, and Continuity will plan the help around it.',
		'care_day_1_time' => 'Morning',
		'care_day_1_body' => 'Help getting up, washed and dressed at the time you’d get up at home. The shower chair is already in the wet room.',
		'care_day_2_time' => 'In the day',
		'care_day_2_body' => 'Someone to come along the promenade or into town, or a few hours of cover so the usual carer can have some time off.',
		'care_day_3_time' => 'Overnight',
		'care_day_3_body' => 'A sleep-in, or a waking night if someone needs help during the night, so the person who usually cares can get some sleep.',
		'care_who_heading' => 'Rated Good by the Care Quality Commission',
		'care_who_lede' => 'The people who come in work for Continuity of Care Services, our sister company. Victoria Walker owns Restwell and is Continuity’s registered manager, so the house and the care start in one conversation.',

		'care_own_heading' => 'Bringing your own carer',
		'care_own_lede'    => 'Plenty of guests do. They can have the second double bedroom or the sofa bed in the conservatory, use the hoist and shower chair, and park on the drive.',

		'care_how_heading'     => 'Asking for care',
		'care_how_lede'        => 'Mention it on the same enquiry as the house, and nothing is booked until you say yes.',
		'care_how_step1_title' => 'Mention it when you enquire',
		'care_how_step1_body'  => 'Mention it in your first message, even if your dates aren’t fixed yet.',
		'care_how_step2_title' => 'Talk it through',
		'care_how_step2_body'  => 'Continuity will ask about the hours and the tasks you need help with.',
		'care_how_step3_title' => 'They quote, you decide',
		'care_how_step3_body'  => 'Continuity give you a quote, and nothing is booked until you’re happy with it.',

		'care_cqc_link_label' => 'Read the CQC inspection profile',

		'care_pro_heading' => 'For OTs, case managers and commissioners',
		'care_pro_lede'    => 'Door widths and equipment are published, and Continuity confirm the care plan and the cost once the hours and tasks are agreed.',

		'care_faq_label'   => 'Care questions',
		'care_faq_heading' => 'Optional care FAQ',
		'care_faq_intro'   => 'The questions people ask most before they mention care.',
		'care_faq_1_q'     => 'Do I have to book care?',
		'care_faq_1_a'     => 'No. Plenty of guests book the house as a self-catering holiday and don’t need any extra support. Care from Continuity is there if you’d like it.',
		'care_faq_2_q'     => 'Is Restwell a care home?',
		'care_faq_2_a'     => 'No. Restwell is a private holiday bungalow. Continuity of Care Services, our sister company, is the CQC-registered provider if you’d like professional care during your stay.',
		'care_faq_3_q'     => 'Do I need to book care on its own?',
		'care_faq_3_a'     => 'No. Just mention it when you enquire about the bungalow. Restwell and Continuity share 01622 809881, so the house and the care can start in one conversation.',
		'care_faq_4_q'     => 'Can I bring my own carers?',
		'care_faq_4_a'     => 'Yes. A carer can have the second bedroom, and there’s space to help with transfers and personal care. Tell us who’s coming when you enquire, and we’ll set the rooms up to suit.',
		'care_faq_5_q'     => 'Where do I see guide rates?',
		'care_faq_5_a'     => 'On Pricing & dates. They’re Continuity’s guide rates, and Continuity give you a quote once the hours and tasks are agreed.',

		'care_cta_heading'         => 'Tell us what you need, and we’ll work it out with you',
		'care_cta_body'            => 'Ring 01622 809881 or send us a note, and we’ll talk through what would help.',
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
		'story_origin_lede'    => 'Continuity of Care Services has been supporting people in their own homes across Kent for over a decade. In that time we lost count of the families who wanted a holiday and couldn’t make it work. Finding a house with honest access information was only part of it. Arranging suitable care during the stay could be just as difficult.',
		'story_origin_body'    => 'Somebody would travel for three hours, only to find a doorway they couldn’t get through. So we bought a bungalow in Whitstable that needed a lot of work, and we adapted it properly. Then we measured everything and published the details, flattering or not. Guests can check the bungalow will work for them before they set off. They can arrange optional care through the same office.',

		'story_month_label'   => 'The build',
		'story_month_heading' => 'How the bungalow was built',
		'story_month_lede'    => 'Family, friends and three specialist teams brought the bungalow together in a month. Before anyone stayed, occupational therapists from Kent Community Health NHS Trust walked the bedroom and wet room. We changed what they flagged, down to the profiling bed.',
		'story_month_1_meta'  => 'Early March',
		'story_month_1_title' => 'We got the keys',
		'story_month_1_body'  => 'The bungalow needed more than a lick of paint.',
		'story_month_2_meta'  => 'During the build',
		'story_month_2_title' => 'The specialists arrived',
		'story_month_2_body'  => 'The accessible bedroom and wet room were built by Care Spaces by Wealden Rehab and Thor Carpentry, with the occupational therapists’ advice. Family and friends did the rest.',
		'story_month_3_meta'  => 'Four weeks later',
		'story_month_3_title' => 'The bungalow was ready',
		'story_month_3_body'  => 'Once the work was finished, we measured everything and wrote the numbers down.',

		'story_host_label'   => 'Who runs both',
		'story_host_heading' => 'Victoria Walker',
		'story_host_lede'    => 'Victoria owns Restwell and is Continuity’s registered manager, so one person is accountable for the house and for the care. Day to day, you’re more likely to speak with someone else in the office. They work across both companies too, so you won’t need to start from the beginning each time you call.',

		'story_companies_label'     => 'Who does what',
		'story_companies_heading'   => 'Two companies, one conversation',
		'story_companies_lede'      => 'Restwell provides the accommodation. Continuity of Care Services provides the optional care. They quote for it once you’ve talked through what you need.',
		'story_companies_1_title'   => 'Restwell',
		'story_companies_1_body'    => 'The bungalow is a private adapted house in Whitstable. It isn’t a care home or a respite centre.',
		'story_companies_2_title'   => 'Continuity of Care Services',
		'story_companies_2_body'    => 'Home care during your stay is optional, and always from Continuity’s own team.',
		'story_companies_3_title'   => 'One place to start',
		'story_companies_3_body'    => 'Ask about the bungalow and any care in the same call, to the same office.',
		'story_companies_note'      => 'Restwell is not a registered care provider. Continuity of Care Services is.',
		'story_companies_cqc_label' => 'Read Continuity’s CQC profile',

		'story_shaped_label'   => 'Shaped with guests',
		'story_shaped_heading' => 'Planned with disabled people before it opened',
		'story_shaped_lede'    => 'People with muscular dystrophy or cerebral palsy, and people recovering from strokes, told us what mattered during transfers, what got in the way, and what they needed from the stay. The layout and the kit grew from those conversations, rather than from assumptions on paper.',

		'story_specialists_label'      => 'Check the details for yourself',
		'story_specialists_heading'    => 'Every measurement is published',
		'story_specialists_lede'       => 'Every measurement is on the Accessibility page, flattering or not. Compare the door widths, spaces and limits with your own chair or hoist before you book. If you’re unsure, please ask.',
		'story_specialists_btn1_label' => 'Door widths and the hoist',
		'story_specialists_btn2_label' => 'Tour the property',

		'story_next_label'   => 'What we’re trying to do',
		'story_next_heading' => 'What we hold ourselves to',
		'story_next_lede'    => 'We publish every measurement. We say what the house can’t do as clearly as what it can. You can arrange a week away, and the support to enjoy it, in one conversation. Nobody should have to explain their situation four times to four different people.',

		'story_cta_heading'         => 'See what that means inside the bungalow',
		'story_cta_body'            => 'You can check door widths, hoist details, and photographs of each room before you contact us. Compare them with what you need, and ask about anything that isn’t clear.',
		'story_cta_primary_label'   => 'Enquire',
		'story_cta_primary_url'     => '/enquire/',
		'story_cta_secondary_label' => 'Tour the property',
		'story_cta_secondary_url'   => '/the-property/',
	);
}

/**
 * Add Theme Setup under Appearance.
 */
