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
		'hero_heading'             => 'An accessible bungalow by the sea, at your own pace',
		'hero_subheading'          => 'Restwell is one private adapted bungalow by the sea in Whitstable, and the whole house is yours for the stay. It’s single-storey and step-free, with a level-access wet room and a ceiling track hoist over the profiling bed. It isn’t a care home, and it isn’t a respite centre.',
		'hero_spec_heading'        => '',
		'hero_cta_primary_label'   => 'Get in touch',
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
		'testimonial_3_quote' => 'The property is beautifully presented, exceptionally clean, well equipped, and in a fantastic location. One of the highlights was waking up to the sound of birds singing each morning and watching them from the garden while enjoying our breakfast. It was the perfect way to start the day.',
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

		'cta_heading'          => 'Ask us anything about a stay',
		'cta_body'            => 'Tell us your dates and what you need from the house. We aim to reply within 48 hours, and there’s no deposit until you’ve decided it fits.',
		'cta_primary_label'   => 'Get in touch',
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
		'prop_hero_subtitle'            => 'This is a room-by-room look round Restwell, a single-storey adapted bungalow on a quiet street in Whitstable that sleeps up to five. There are two bedrooms, a level-access wet room, an open living and kitchen space, and French doors onto a level patio and garden.',
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

		'prop_living_heading' => 'Wheel-under kitchen and open-plan living',
		'prop_living_body'    => 'The light and airy open-plan living room has sofas, a riser/recliner chair, a dining table, a wall-mounted TV and a feature fireplace, and leads round into a modern fully-equipped kitchen with a lowered, wheel-under worksurface. Double doors open into a conservatory with a sofa (including a sofa bed), laundry facilities and garden views, with threshold ramps onto the patio.',

		'prop_bedrooms_section_heading' => 'The room with the hoist, and room for everyone else',
		'prop_bedrooms_section_body'    => 'The accessible bedroom has a ceiling track hoist running over a profiling bed with a pressure-relieving mattress, a mobile hoist as well, and a standing aid. We set the room up around what you tell us when you book. If you need a second profiling bed, say so and we’ll put one in. The second bedroom sleeps whoever else is with you, and there’s a double sofa bed in the conservatory. Five is the limit.',

		'prop_wetroom_heading' => 'Roll-in wet room with adjustable basin',
		'prop_wetroom_body'    => 'The accessible wet room has a step-free shower with a fixed grab-rail, a shower/commode chair, a tilt-in-space shower chair and a shower stool, with fixed and drop-down grab-rails. There is a Geberit AquaClean wash and dry WC with remote and touch control, and a height-adjustable wheel-under washbasin that also swings aside.',

		'prop_garden_heading' => 'Private drive, patio and step-free garden',
		'prop_garden_body'    => 'Double doors from the conservatory lead onto a patio with outdoor dining furniture and a BBQ, with threshold ramps for wheelchair access. The enclosed garden is wheelchair-accessible with a lawned area. To the front there is a hard-standing private driveway for two cars, with additional street parking available.',

		'prop_throughout_heading' => 'Wide doorways, step-free throughout',
		'prop_throughout_body'    => 'The bungalow is on one level with wide doorways (926 mm and 965 mm clear widths) and step-free routes from the porch through to the patio. Full door and transfer measurements are on the accessibility page if you need them before booking.',

		'prop_care_heading' => 'Optional care and welcome hamper',
		'prop_care_body'    => 'A range of support can be arranged with Continuity Care Services, from companionship and domiciliary care to complex and 24/7 care. Every stay starts with a welcome hamper, and the bungalow is dog-friendly.',

		'prop_location_heading' => 'Whitstable, Tankerton Beach and the Kent coast',
		'prop_location_body'    => 'The bungalow is a few minutes\' walk from Tankerton Beach and its accessible promenade. Whitstable itself, with its harbour, beach, restaurants and cafes, supermarkets and independent shops and galleries, is within a 20-minute walk. By car you are close to Canterbury, Faversham and Herne Bay, with the countryside and coastline of North Kent to explore. The area guide on the website covers accessible attractions and activities in more detail.',
		'prop_location_image_id' => 0,

		'prop_tour_living_image_id'   => 0,
		'prop_tour_bedroom_image_id' => 0,
		'prop_tour_wetroom_image_id' => 0,
		'prop_tour_garden_image_id'     => 0,
		'prop_tour_throughout_image_id' => 0,

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
		'prop_gallery_heading'     => 'Photo tour of the accessible bungalow',
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

		'prop_cta_heading' => 'Ask about your dates',
		'prop_cta_body'    => 'Tell us who is travelling, when you are thinking of visiting, and any access or care questions. We will reply within 48 hours.',
		'prop_cta_btn'     => 'Enquire now',
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
		'hiw_intro'   => 'Booking Restwell has three steps: you enquire with your dates and what you need, we confirm the bungalow and take a 50% deposit, and then you arrive from 3pm using a key safe. If you’d like home care during the stay, it goes on the same enquiry.',

		'hiw_steps_label'   => 'THREE-STEP PROCESS',
		'hiw_steps_heading' => 'Enquire, confirm, arrive',
		'hiw_steps_intro'   => '',
		'hiw_step1_title'   => 'Enquire',
		'hiw_step1_body'    => 'Tell us your dates and what you need. Nothing to pay at this stage.',
		'hiw_step2_title'   => 'Confirm',
		'hiw_step2_body'    => 'We set the house up around you. A 50% deposit reserves the dates.',
		'hiw_step3_title'   => 'Arrive',
		'hiw_step3_body'    => 'From 3pm, through a key safe. The address comes with your confirmation.',
		'hiw_step4_title'   => '',
		'hiw_step4_body'    => '',

		'hiw_care_cta_label'   => 'CARE SUPPORT',
		'hiw_care_cta_heading' => 'Care fits around your routine',
		'hiw_care_cta_body'    => 'Care is entirely optional. If you want it, Continuity of Care Services (CQC-regulated and experienced) will work to your schedule, not theirs. Morning check-ins, personal care, or more comprehensive support: you decide.',
		'hiw_care_cta_btn'     => 'Ask about care options',
		'hiw_care_cta_url'     => '/enquire/',

		'hiw_included_label'   => 'What\'s included',
		'hiw_included_heading' => 'Everything in the house is yours.',
		'hiw_included_intro'   => 'Your booking covers exclusive use of the whole property for the duration of your stay.',
		'hiw_included_1_title' => 'Exclusive use of the whole house',
		'hiw_included_1_desc'  => 'Private use of the whole bungalow, with no shared spaces.',
		'hiw_included_2_title' => 'Ceiling hoist & profiling bed',
		'hiw_included_2_desc'  => 'Ceiling hoist, profiling bed, and wet room with grab rails are ready on arrival.',
		'hiw_included_3_title' => 'High-speed broadband',
		'hiw_included_3_desc'  => 'Reliable Wi-Fi coverage across the property for guests and carers.',
		'hiw_included_4_title' => 'Linen and towels',
		'hiw_included_4_desc'  => 'Freshly laundered bed linen and towels, prepared before you arrive.',
		'hiw_included_5_title' => 'Parking for two cars',
		'hiw_included_5_desc'  => 'Two off-road spaces on the private drive, with nearby on-street overflow.',
		'hiw_included_6_title' => 'Welcome information pack',
		'hiw_included_6_desc'  => 'House guide, local contacts, plus tea, coffee, and basic arrival essentials.',

		'hiw_cta_label'           => 'Ready?',
		'hiw_cta_heading'         => 'Start with a conversation.',
		'hiw_cta_body'            => 'No commitment, no lengthy forms. Just get in touch and we\'ll take it from there.',
		'hiw_cta_primary_label'   => 'Enquire now',
		'hiw_cta_primary_url'     => '/enquire/',
		'hiw_cta_secondary_label' => 'See the property',
		'hiw_cta_secondary_url'   => '/the-property/',
		'hiw_cta_promise'         => 'No obligation. Ask us anything.',

		'hiw_faq_label'   => 'Common questions',
		'hiw_faq_heading' => 'Things people often ask.',
		'hiw_faq_intro'   => '',
		'hiw_faq_1_q'     => 'How do I book a stay?',
		'hiw_faq_1_a'     => 'Three steps: send us your dates and what you need, we confirm the bungalow and take a 50% deposit, then you arrive from 3pm using a key safe. Care can go on the same enquiry.',
		'hiw_faq_2_q'     => 'When can care be added?',
		'hiw_faq_2_a'     => 'Mention it when you first write, even if the dates are still vague. We don’t publish a lead time because it depends on what you need and who’s available that week. We’ll give you a real answer quickly.',
		'hiw_faq_3_q'     => 'How can I pay?',
		'hiw_faq_3_a'     => 'We can invoice you, a council, the NHS or a grant body, at the same bungalow rate. Who we invoice doesn’t change the price.',
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
		'acc_intro'   => 'This is the access statement for Restwell, a single-storey adapted bungalow in Whitstable. The front door has a 965mm clear opening and internal doorways are 926mm. There is a ceiling track hoist rated to 180kg, a mobile hoist, a level-access wet room, and up to two profiling beds depending on what you need.',

		'acc_room_label'      => 'The property',
		'acc_room_heading'    => 'Room by room',
		'acc_arrival_heading' => 'Arrival & entrance',
		'acc_arrival_body'    => "Private driveway: two off-road car spaces (adapted vehicles welcome)\nOn-street parking outside if you need extra room. No residents permit on this road; check signs on arrival in case street rules change\nStep-free path from car to front door\nPorch opening 1720mm; inner front door 965mm clear\nLevel threshold, no step",
		'acc_inside_heading'  => 'Inside the property',
		'acc_inside_body'     => "All internal doors 926mm clear\nOpen-plan ground floor, no internal steps\nLevel flooring throughout (no carpet lips)\nCeiling track hoist in the accessible bedroom (Amico GoLift 400, 180kg SWL; wet room is on the same level nearby)",
		'acc_bedroom_heading' => 'Bedrooms & sleeping',
		'acc_bedroom_body'    => "Accessible bedroom: Accora CommunityBed profiling bed, maximum user weight 180kg, with pressure-relieving mattress\nCeiling hoist with full-room track in this room for transfers at the bed\nA second profiling bed can be set up on request\nSpace for carer on both sides of bed\nSecond bedroom for additional guests or a support worker\nSofa bed in the conservatory. The house sleeps up to five; tell us your party layout when you enquire",
		'acc_bathroom_heading' => 'Wet room',
		'acc_bathroom_body'   => "Full wet room: roll-in shower, no lip. Layout and specification by <a href=\"https://www.carespaces.co.uk/\" target=\"_blank\" rel=\"noopener noreferrer\">Care Spaces</a> (specialist care environments, design & installation)\nMira Select Flex TMV3 shower, RNIB Tried & Tested\nRAZ-AT tilt-in-space shower commode chair\nDrive DeVilbiss shower stool, rated to 136kg\nRopox Swing washbasin, height-adjustable 750–950mm\nGrab rails: shower, toilet, and washbasin\nFloor-level drain\nExtractor fan",
		'acc_kitchen_heading' => 'Kitchen',
		'acc_kitchen_body'    => "Open-plan kitchen, easy wheelchair access\nHeight-adapted worktop section\nGas hob (not induction). No electromagnetic field from the cooktop, which many guests with pacemakers prefer\nAccessible storage at lower levels",
		'acc_outdoor_heading' => 'Outdoor spaces',
		'acc_outdoor_body'    => "Level patio immediately outside rear doors\nHard-standing surface suitable for wheelchairs\nSmall garden area, mostly flat",

		'acc_dest_label'              => 'Whitstable',
		'acc_dest_heading'            => 'The destination, honestly.',
		'acc_dest_intro'              => 'Whitstable is a genuinely lovely town, but like most historic coastal places, it has its challenges. Here is the honest picture.',
		'acc_dest_good_heading'       => 'The good',
		'acc_dest_good_body'          => 'The Tankerton promenade is a long, flat, surfaced path along the seafront, one of the most wheelchair-friendly coastal routes in Kent. Free parking at Marine Parade. Accessible toilets at the harbour end. The streets around the property are flat and paved with dropped kerbs.',
		'acc_dest_challenge_heading'  => 'The challenges',
		'acc_dest_challenge_body'     => 'Harbour Street and the old town have narrow pavements that get crowded at weekends and in summer. Some shops and cafes have stepped entrances with no ramp. The harbour itself has some uneven surfaces near the fish market. Weekday mornings are the easiest time to visit.',
		'acc_dest_reality_heading'    => 'The reality',
		'acc_dest_reality_body'       => 'Whitstable is more accessible than most UK coastal towns. With a little planning and our local knowledge, we can point you to the best accessible routes, cafes, and experiences. We will share everything we know in your welcome pack.',

		'acc_cta_heading' => 'Still have questions about access?',
		'acc_cta_body'    => 'Get in touch and we will answer honestly. If the property isn\'t right for your needs, we will tell you.',
		'acc_cta_btn'     => 'Ask an accessibility question',
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
		'faq_intro'        => 'Short answers to the things we’re asked most: what Restwell is, whether a wheelchair fits, how care works, what it costs, and who we can invoice. Each answer links to the page that goes into proper detail.',
		'faq_list_label'   => '',
		'faq_list_heading' => 'Frequently asked questions',

		'faq_cta_label'   => '',
		'faq_cta_heading' => 'Still have a question?',
		'faq_cta_body'    => 'If your question isn’t here, ring us on 01622 809881 and just ask it. We keep a note of the ones that come up repeatedly and add them to this page.',
		'faq_cta_btn'     => 'Enquire now',
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
		'enq_intro'   => 'Send us your dates, who’s coming and anything you need from the house, and we’ll reply within 48 hours. There’s no deposit until you’ve decided the bungalow fits. You can also ring 01622 809881 or email hello@restwellretreats.co.uk instead of using the form.',

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
		'pricing_label'         => 'Pricing',
		'pricing_heading'       => 'What a stay here costs',
		'pricing_subheading'    => 'A full week in the bungalow is £1,300 off-peak and £1,400 in peak season. The rate is the same whoever we invoice.',
		'pricing_intro'         => 'A full week in the bungalow is £1,300 off-peak and £1,400 in peak season. Midweek nights are £185 off-peak and £200 peak, with weekend nights in the table below. A 50% deposit reserves your dates and the balance is due a week before you arrive. The rate is the same whoever we invoice.',
		'pricing_hero_cta_text' => 'Tell us your dates',
		'pricing_hero_cta_url'  => '/enquire/',
		'pricing_hero_cta_promise' => 'No deposit until you’ve decided the house fits.',
		'pricing_faq_label'     => 'FAQ',
		'pricing_faq_heading'   => 'Common questions about pricing',
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
		'res_intro'   => 'Restwell can invoice you directly, a local authority, the NHS, or a grant body, and the bungalow costs the same whoever pays. Home care from Continuity of Care Services is invoiced separately by them. We can’t promise that your funding will cover a holiday. That decision sits with your social worker or case manager.',

		'res_fund_heading' => 'How to fund your stay',
		'res_fund_body'    => "Many guests use a combination of personal savings, direct payments, and charitable grants to fund their stay.\n\nIf you receive a personal budget or direct payment from your local authority or NHS, you may be able to use this towards your stay, particularly if care support is included. We recommend speaking to your care coordinator or social worker in the first instance.\n\nWe are happy to provide documentation to support a funding application.",

		'res_grants_heading' => 'Grants and charities',
		'res_grants_body'    => "A number of charities offer grants specifically for people with disabilities and their carers to take a holiday. These include:\n\n- <a href=\"https://www.tourismforall.co.uk\" target=\"_blank\" rel=\"noopener\">Tourism for All</a>\n- <a href=\"https://familyfund.org.uk\" target=\"_blank\" rel=\"noopener\">Family Fund</a> (families with children who have disabilities or serious illnesses)\n- <a href=\"https://www.carers.org\" target=\"_blank\" rel=\"noopener\">Carers UK</a> (signposting to local grants)\n- Local authority short breaks / respite funding\n\nEligibility varies. We recommend checking each organisation\'s current criteria.",

		'res_chc_heading' => 'NHS Continuing Healthcare (CHC)',
		'res_chc_body'    => "If you or the person you care for receives NHS Continuing Healthcare, it may be possible to use some of that funding towards care support during your stay.\n\nThis is not straightforward and depends on your individual package. We recommend raising it with your NHS case manager or care coordinator.\n\nContinuity of Care Services, our care partner, can provide documentation to support a CHC application for care during your stay.",

		'res_complaints_heading' => 'Complaints and appeals',
		'res_complaints_body'    => "If a funding application is refused, you have the right to request a review. Local authorities are required to follow a formal review process.\n\nUseful resources:\n\n- <a href=\"https://www.disabilityrightsuk.org\" target=\"_blank\" rel=\"noopener\">Disability Rights UK</a>\n- <a href=\"https://www.lgo.org.uk\" target=\"_blank\" rel=\"noopener\">Local Government & Social Care Ombudsman</a>",

		'res_contacts_heading' => 'Key contacts',
		'res_contacts_body'    => "We have compiled a short list of organisations that may be helpful:\n\n- <strong>Continuity of Care Services</strong>, our care partner: <a href=\"https://www.continuitycareservices.co.uk\" target=\"_blank\" rel=\"noopener noreferrer\">continuitycareservices.co.uk</a>\n- <strong>Continuity on the CQC register</strong> (inspection & rating): <a href=\"https://www.cqc.org.uk/location/1-2624556588\" target=\"_blank\" rel=\"noopener noreferrer\">cqc.org.uk profile</a>\n- <strong>Disability Rights UK</strong>: <a href=\"https://www.disabilityrightsuk.org\" target=\"_blank\" rel=\"noopener noreferrer\">disabilityrightsuk.org</a>",

		'res_cta_heading' => 'Not sure where to start?',
		'res_cta_body'    => 'Get in touch and we will help you think through the options. We have helped guests navigate funding before and will point you in the right direction.',
		'res_cta_btn'     => 'Get in touch',
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
		'wif_label'           => 'Who it is for',
		'wif_heading'         => 'Is this the right house for your group?',
		'wif_intro'           => 'Restwell suits disabled adults, families and the people who care for them, in parties of up to five. It’s a private adapted bungalow you rent as a holiday, not a care home, not a nursing home, and not a registered respite centre. Home care is available if you want it, and entirely optional.',
		'wif_hero_image_id'   => 0,
		'wif_family_title'    => 'For guests and families',
		'wif_family_body'     => '"Accessible" and "wheelchair friendly" are used loosely by a lot of accommodation. People book in good faith and arrive to find a step at the entrance, a bathroom that is too small to turn, or a hoist that is not actually there. Restwell works the other way: the ceiling track hoist is already fitted in the accessible bedroom, the wet room has a roll-in shower with turning space, and every doorway and corridor is sized for a powerchair. The full measurements are published on our accessibility page. Check them before you enquire, not after. This is a private home, not a converted hotel room. No shared spaces, no clinical layout, and no surprises on arrival.',
		'wif_carers_title'    => 'For carers and support workers',
		'wif_carers_body'     => 'The ceiling hoist is already fitted in the accessible bedroom; the wet room is designed for assisted personal care on the same level; and there is a separate sleeping area for the support worker. The layout is practical, not just manageable. If your client has complex needs, check the suitability details with us before you commit. We will give you specifics, not a brochure. One thing many carers do not know: you have a legal right to a Carer\'s Assessment under the Care Act 2014. Your local council must carry one out if you ask. It can open up direct payment routes to fund a holiday or short break, so it is worth requesting if you have not had one.',
		'wif_ot_title'        => 'For occupational therapists and case managers',
		'wif_ot_body'         => 'Our accessibility page publishes doorway widths, turning circle dimensions, bedroom ceiling track hoist specifications, profiling bed measurements, and wet room dimensions: the specifics that matter for a clinical recommendation. If you need something we have not published (transfer clearances, approach gradients, equipment positioning), ask and we will measure it. We understand a poor recommendation reflects on you. We would rather give you a straight answer than lose your trust, and we welcome referral conversations before any booking commitment.',
		'wif_commissioners_title' => 'For commissioners and social care teams',
		'wif_commissioners_body'  => 'Under the Care Act 2014, short breaks at a private adapted setting can be included in a care and support plan where the property meets the person\'s assessed needs. Restwell supports direct payment stays, personal health budgets, and CHC-funded packages. We can provide the documentation a referral process typically requires: property specification, access measurements, equipment inventory, and written confirmation of our connection to Continuity of Care Services, a CQC-registered provider. Most local authority funding decisions require evidence. We provide it.',
		'wif_visual_intro'    => 'Real photos help you judge fit before you book: layout, circulation space, and how equipment sits in the room. Pair these with our accessibility specification for verified measurements and features.',
		'wif_funding_heading' => 'How funding can work',
		'wif_funding_body'    => 'Many guests use direct payments, personal budgets, or CHC pathways. Most funded stays begin with a Care and Support Assessment, which is a right under the Care Act 2014. In Kent, that means contacting Kent County Council Adult Social Care. The three routes below explain how each pathway works.',
		'wif_cta_heading'     => 'Need to check suitability first?',
		'wif_cta_body'        => 'Tell us what you need and we will answer honestly, with no pressure.',
		'wif_cta_primary_label' => 'Read accessibility features',
		'wif_cta_primary_url'   => '/accessibility/',
		'wif_cta_secondary_label' => 'Enquire about your dates',
		'wif_cta_secondary_url'  => '/enquire/',
	);
}

/**
 * Default meta for the Whitstable Guide page.
 */
function restwell_get_whitstable_guide_page_defaults() {
	return array(
		'wg_label'         => 'Whitstable & Kent coast',
		'wg_heading'       => 'What a day out from the bungalow is actually like',
		'wg_intro'         => 'Tankerton promenade is the level route with the sea view, and the harbour beach is shingle, which isn’t a wheelchair surface. Most of the food and drink here is in old buildings, so access varies genuinely from door to door. Below is what we know about the places we go to ourselves.',
		'wg_hero_image_id' => 0,
		'wg_about_heading' => 'The promenade from Tankerton Slopes',
		'wg_about_body'    => "A paved promenade route of about two miles, west from the property at the top of Tankerton Slopes. Marine Parade clifftop is wide and flat with weather shelters and benches. At the right tide you can watch The Street, a natural shingle spit, emerge almost 800 metres into the estuary.\nSloped paths down to the beach are steep and easier with a companion for manual wheelchair users. The lower promenade then runs unbroken west past the painted beach huts to Whitstable Castle gardens, town and harbour.",
		'wg_towns_heading' => 'Further afield',
		'wg_towns_body'    => "Wildwood Trust, Herne Bay: mostly accessible woodland paths, scooters to borrow on request. Book ahead on 01227 209621.\nDreamland, Margate: wheelchair accessible with accessible toilets. Nimbus Access Card and Essential Companion scheme accepted.\nCanterbury: Cathedral Welcome Centre lends wheelchairs; the cathedral is mostly step-free. Some cobbled streets in the centre; riverside routes and Westgate Gardens are smoother under wheels.",
		'wg_getting_here_heading' => 'Parking, plainly',
		'wg_getting_here_body'    => "Free Blue Badge bays along Marine Parade (display badge, no app). Tankerton Road Car Park gives three hours free with a physical badge.\nHeads-up: the harbour car parks (Gorrell Tank, Keam's Yard) use ANPR and need your vehicle and Blue Badge registered online beforehand. Parking at Tankerton Road and rolling along the promenade is usually easier.",
		'wg_getting_around_heading' => '',
		'wg_getting_around_body'    => '',
		'wg_spotlight_image_1_id' => 0,
		'wg_spotlight_image_1_caption' => 'Tankerton promenade and sea-wall route',
		'wg_spotlight_image_2_id' => 0,
		'wg_spotlight_image_2_caption' => 'Whitstable harbour boardwalk and food huts',
		'wg_spotlight_image_3_id' => 0,
		'wg_spotlight_image_3_caption' => 'Town-centre route planning and practical stops',
		'wg_access_label'            => 'Along the route',
		'wg_access_heading'          => 'Three good stops',
		'wg_access_intro'            => 'Each stop sits on or just off the promenade route, with access notes woven in so you can plan before you set off.',
		'wg_spotlight_label'         => 'Visual guide',
		'wg_spotlight_heading'       => 'Key local areas at a glance',
		'wg_spotlight_intro'         => 'Photos help you picture routes and surfaces before you arrive.',
		'wg_related_label'           => 'Related reading',
		'wg_related_heading'         => 'Plan your stay with connected guides',
		'wg_related_intro'           => 'If you are comparing locations and practical suitability, these pages answer the next common questions.',
		'wg_planning_label'          => 'Practical stops',
		'wg_planning_heading'        => 'Loos along the way',
		'wg_planning_intro'          => 'Public toilets on and near the promenade route, including a Changing Places facility at the harbour.',
		'wg_planning_before_heading' => '',
		'wg_planning_day_heading'    => '',
		'wg_planning_before_bullets' => "Behind the sailing club at the foot of the slopes.\nBy the Marine Parade cafe at the top.\nUnder the promenade cafe near the castle.\nChanging Places at Whitstable Harbour WC, Harbour Road.",
		'wg_planning_day_bullets'    => '',
		'wg_eating_label'            => 'Eating out',
		'wg_eating_heading'          => 'Places to eat near the property',
		'wg_eating_intro'            => 'Three nearby options with honest access notes. Confirm details with the venue before you travel if access is critical to your plans.',
		'wg_eating_body'             => "<strong>The Plough Inn, Swalecliffe</strong> (100 St John's Road, CT5 2RN, 01227 794636): step-free entry, no accessible toilet; confirm access on the day if that matters.\n<strong>JoJo's, Tankerton</strong> (2 Herne Bay Road, CT5 2LQ, 01227 274591): wheelchair access and accessible toilet; book ahead.\n<strong>Marine Hotel, Tankerton</strong> (32-33 Marine Parade, CT5 2BE, 01227 272672): ground-floor step-free dining, accessible toilet by reception.",
		'wg_cta_heading'         => 'Planning your coastal break?',
		'wg_cta_body'            => 'If you have dates in mind, get in touch and we will help you plan a stay that works for your access needs.',
		'wg_cta_primary_label'   => 'See the property',
		'wg_cta_primary_url'       => '/the-property/',
		'wg_cta_secondary_label'   => 'Ask about your dates',
		'wg_cta_secondary_url'     => '/enquire/',
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
		'care_intro'   => 'Continuity of Care Services can provide home care inside the bungalow while you’re staying here. They’re our sister company, rated Good by the CQC, and they can be arranged on the same enquiry as the house. Victoria Walker owns Restwell and is Continuity’s registered manager. Restwell is the accommodation; Continuity provide and invoice the care.',
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
		'story_intro'   => 'Restwell Retreats is an adapted holiday bungalow in Whitstable, run by Victoria Walker. Continuity of Care Services is our sister company; Victoria is their CQC registered manager. They work from the same office on the same phone number. Restwell provides the house; Continuity provide any care.',
	);
}

/**
 * Add Theme Setup under Appearance.
 */
