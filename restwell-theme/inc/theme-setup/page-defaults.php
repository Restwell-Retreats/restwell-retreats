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
	return array(
		'Home'               => 'home',
		'The Property'       => 'the-property',
		'How It Works'       => 'how-it-works',
		'Accessibility'      => 'accessibility',
		'Who It\'s For'      => 'who-its-for',
		'FAQ'                => 'faq',
		'Enquire'            => 'enquire',
		'Resources'          => 'resources',
		'Whitstable Guide'   => 'whitstable-area-guide',
		'Blog'               => 'blog',
		'Guest Guide'        => 'guest-guide',
		'Privacy Policy'       => 'privacy-policy',
		'Terms & Conditions' => 'terms-and-conditions',
		'Accessibility Policy' => 'accessibility-policy',
	);
}

/**
 * Default meta values for the front page (Home).
 */
function restwell_get_theme_setup_defaults() {
	$defaults = array(
		'hero_eyebrow'             => 'Restwell Retreats',
		'hero_heading'             => 'Accessible holidays in Whitstable, set up for the way you live',
		'hero_subheading'          => 'Wake up to the sea air in Whitstable and shape the day around your own clock. Restwell Retreats is a step-free, single-storey accessible holiday home on the Kent coast, ten minutes from the seafront, and the whole house is yours. There\'s a ceiling track hoist over the profiling bed, a level-access wet room already in place, and optional CQC-regulated care if you\'d like it. Come for a holiday or a respite break, and settle in at your own pace.',
		'hero_spec_heading'        => '',
		'hero_cta_primary_label'   => 'View the property',
		'hero_cta_primary_url'     => '/the-property/',
		'hero_cta_secondary_label' => 'Send an enquiry',
		'hero_cta_secondary_url'   => '/enquire/',
		'hero_cta_promise'         => '',
		'home_partners_label'      => 'Trusted partners',
		'home_partners_heading'    => 'Specialist Partners',
		'home_partners_intro'      => 'The full story of how we adapted Restwell, who built it, and who supports guests today.',
		'home_partners_cta_text'   => 'See our journey',
		'home_partners_cta_url'    => '/how-it-works/',
		'home_partner_1_name'      => 'Care Spaces',
		'home_partner_1_url'       => 'https://www.carespaces.co.uk/',
		'home_partner_1_logo_id'   => 0,
		'home_partner_1_blurb'     => 'Specialist design and installation for changing places, hygiene rooms, and accessible care environments.',
		'home_partner_1_logo_scale' => 1.75,
		'home_partner_2_name'      => 'Thor Carpentry',
		'home_partner_2_url'       => 'https://thorcarpenter.co.uk/',
		'home_partner_2_logo_id'   => 0,
		'home_partner_2_blurb'     => 'Bespoke carpentry and practical adaptation works that help make the property function day to day.',
		'home_partner_2_logo_scale' => 1.85,
		'home_partner_3_name'      => 'Wealden Rehab',
		'home_partner_3_url'       => 'https://www.wealdenrehab.com/',
		'home_partner_3_logo_id'   => 0,
		'home_partner_3_blurb'     => 'Care equipment specialists supporting bathing, moving and handling, and seating solutions.',
		'home_partner_3_logo_scale' => 1.7,
		'home_partner_4_name'      => 'Continuity of Care Services',
		'home_partner_4_url'       => 'https://www.continuitycareservices.co.uk/',
		'home_partner_4_logo_id'   => 0,
		'home_partner_4_blurb'     => 'CQC-regulated care partner providing domiciliary, respite, complex and palliative care in Kent.',
		'home_partner_4_logo_scale' => 1.65,
		'home_partner_5_name'      => 'Continuity Training Academy',
		'home_partner_5_url'       => 'https://www.continuitytrainingacademy.co.uk/',
		'home_partner_5_logo_id'   => 0,
		'home_partner_5_blurb'     => 'CPD-accredited care training provider supporting safer, compliant practice across care teams.',
		'home_partner_5_logo_scale' => 1.6,

		'home_teaser_label'         => 'Area & funding',
		'home_teaser_area_title'    => 'Whitstable & the Kent coast',
		'home_teaser_area_body'     => 'Single-storey bungalow on the Kent coast: harbour, promenade, and day trips with realistic access notes. We focus on step-free routes, parking, and places that match your needs, not a vague list labelled "wheelchair friendly".',
		'home_teaser_funding_title' => 'Funding your stay',
		'home_teaser_funding_body'  => 'Many guests use personal budgets, direct payments, NHS Continuing Healthcare, or local authority funding. Our guides explain common routes in plain English: what to ask your social worker, and what paperwork helps.',

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

		'who_label'        => "Who it's for",
		'who_heading'      => 'Two people. One break.',
		'who_guest_title'  => 'For the guest',
		'who_guest_body'   => 'A private home with the space and access features you need: wide doorways, level thresholds, room for equipment, and space to settle. Self-catering in Whitstable at your pace: the house is yours, the timetable is yours. Rest by the sea, then explore the town or stay close as you prefer.',
		'who_carer_title'  => 'For the carer',
		'who_carer_body'   => 'The layout supports care routines: separate sleeping, practical bathroom access, and space to assist. Optional CQC-regulated support is available through Continuity of Care Services, or bring your own carer. Either way, the environment is set up for real routines, day and night, so you are not improvising.',

		'property_label'      => 'The property',
		'property_heading'   => 'Our Whitstable home',
		'property_body'      => 'An adapted single-storey property in Whitstable: level approach from the street, two off-road spaces on the private drive (on-street outside if you need extra room—no residents permit on this road), and a flat route toward the Tankerton promenade. Whitstable town centre (harbour, seafood restaurants, and the waterfront) is close enough for day trips without stressful route planning.',
		'property_cta_label' => 'Explore the property',
		'property_cta_url'   => '/the-property/',
		'property_image_id'  => 0,

		'why_label'       => 'Why Restwell?',
		'why_heading'     => 'Why choose Restwell for your accessible break?',
		'why_item1_title' => 'Private & personal',
		'why_item1_desc'  => 'The whole bungalow is yours: living space, kitchen, two bedrooms plus a sofa bed in the living area (sleeps up to five), with the privacy of a self-catering stay.',
		'why_item2_title' => 'Professional support on your terms',
		'why_item2_desc'  => 'Continuity of Care Services (CQC-regulated): support arranged on your terms, as much or as little as you need, or bring your own carer.',
		'why_item3_title' => 'Local knowledge',
		'why_item3_desc'  => 'We can tell you which cafes have step-free access, where to park near the harbour, and which routes work for wheelchairs, so you spend more time relaxing and less time planning.',
		'why_item4_title' => 'Honest & open',
		'why_item4_desc'  => 'We publish the access specification: exact dimensions, thresholds, and equipment, so you can plan with confidence before you travel.',

		'home_comparison_label'          => 'Compare options',
		'home_comparison_heading'        => 'Restwell vs. a typical hotel stay',
		'home_comparison_intro'          => 'A side-by-side on privacy, equipment, care, and the kitchen.',
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

		'cta_heading'          => 'Need exact access details first?',
		'cta_body'            => 'Tell us your dates and practical needs. We will reply with clear measurements, equipment details, and next steps.',
		'cta_primary_label'   => 'Send an enquiry',
		'cta_primary_url'     => '/enquire/',
		'cta_secondary_label' => 'See the property',
		'cta_secondary_url'   => '/the-property/',
		'cta_promise'         => 'No pressure to book. Useful answers, usually within 48 hours.',
		'cta_image_id'        => 0,
	);

	if ( function_exists( 'restwell_get_homepage_faq_meta_seed_map' ) ) {
		$defaults = array_merge( $defaults, restwell_get_homepage_faq_meta_seed_map() );
	}

	return $defaults;
}

/**
 * Merge theme default post meta into a page: overwrite all keys when $force; otherwise only set keys that are not stored yet.
 *
 * Preserves intentional edits and empty values; fills gaps when new defaults are added to the theme.
 *
 * @param int   $post_id  Post ID.
 * @param array $defaults Key => value from a restwell_get_*_defaults() map.
 * @param bool  $force    When true, replace every listed key from defaults.
 * @return int Number of meta keys written.
 */
function restwell_get_property_page_defaults() {
	return array(
		'prop_address_street'   => '101 Russell Drive',
		'prop_address_locality' => 'Whitstable',
		'prop_address_region'   => 'Kent',
		'prop_address_postcode' => 'CT5 2RQ',

		'prop_hero_label'               => 'The Property',
		'prop_hero_heading'             => 'An accessible bungalow in Whitstable, near the beach',
		'prop_hero_subtitle'            => 'A newly adapted single-storey bungalow a few minutes from Tankerton Beach. Step-free throughout, with a full room coverage ceiling hoist, profiling beds and a level-access wet room.',
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

		'prop_bedrooms_section_heading' => 'Ceiling hoist, profiling beds and a double room',
		'prop_bedrooms_section_body'    => 'The accessible bedroom has two profiling beds, a full room coverage ceiling hoist and a wall-mounted TV. A mobile hoist and a Sara Stedy stand aid are available to guests and can be used in the bedroom and throughout the bungalow. The second bedroom has a double bed and a wall-mounted TV.',

		'prop_wetroom_heading' => 'Roll-in wet room with adjustable basin',
		'prop_wetroom_body'    => 'The accessible wet room has a step-free shower with a fixed grab-rail, a shower/commode chair, a tilt-in-space shower chair and a shower stool, with fixed and drop-down grab-rails. There is a Geberit AquaClean wash and dry WC with remote and touch control, and a height-adjustable wheel-under washbasin that also swings aside.',

		'prop_garden_heading' => 'Private drive, patio and step-free garden',
		'prop_garden_body'    => 'Double doors from the conservatory lead onto a patio with outdoor dining furniture and a BBQ, with threshold ramps for wheelchair access. The enclosed garden is wheelchair-accessible with a lawned area. To the front there is a hard-standing private driveway for two cars, with additional street parking available.',

		'prop_throughout_heading' => 'Wide doorways and step-free access throughout',
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
		'prop_bedrooms'          => 'Two bedrooms, plus a sofa bed in the living area. Sleeps up to five.',
		'prop_bathrooms_count'   => '1',
		'prop_bathroom'          => 'Roll-in shower with grab rails and adjustable basin.',
		'prop_wetroom_walkthrough_url' => 'https://youtube.com/shorts/i1LGyKsyVdw',
		'prop_parking_label'     => 'Parking',
		'prop_parking'           => '2',
		'prop_parking_detail'    => 'Room for two vehicles on the resin-bound private drive',
		'prop_sleeps_value'      => '5',
		'prop_sleeps_label'      => 'Sleeps',
		'prop_distances'         => "Tankerton Slopes promenade: 15 min flat walk\nWhitstable town centre: 15 min walk\nWhitstable station: 20-30 min walk",
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
		'prop_nearby_2_distance'  => 'Approx. 15 min flat walk',
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
		'prop_nearby_4_distance'  => 'Approx. 15 min walk',
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
		'hiw_heading' => 'How to book an accessible holiday with care',
		'hiw_intro'   => 'Booking a break should be the easy part. From your first enquiry to the morning you leave, we keep things clear and unhurried, so you know what\'s in the house, what care is available and how to pay.',

		'hiw_steps_label'   => 'FOUR-STEP PROCESS',
		'hiw_steps_heading' => 'Straightforward from start to finish',
		'hiw_steps_intro'   => '',
		'hiw_step1_title'   => 'Enquire',
		'hiw_step1_body'    => 'Tell us your dates and your access needs.',
		'hiw_step2_title'   => 'Confirm',
		'hiw_step2_body'    => 'We talk through what\'s in the house and any care you\'d like.',
		'hiw_step3_title'   => 'Book',
		'hiw_step3_body'    => 'You secure your dates.',
		'hiw_step4_title'   => 'Arrive',
		'hiw_step4_body'    => 'You come home to a step-free house that is ready for you.',

		'hiw_care_cta_label'   => 'CARE SUPPORT',
		'hiw_care_cta_heading' => 'Care is arranged around your days and your routine.',
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
		'hiw_faq_1_q'     => 'Do I have to book care?',
		'hiw_faq_1_a'     => 'No. Care support through Continuity of Care Services is entirely optional. Many guests book the house as a self-catering holiday and need no additional support.',
		'hiw_faq_2_q'     => 'How far in advance should I book?',
		'hiw_faq_2_a'     => 'We recommend enquiring as early as possible; peak summer weeks fill quickly. That said, we will always try to accommodate shorter-notice bookings where we can.',
		'hiw_faq_3_q'     => 'How far is the property from the beach?',
		'hiw_faq_3_a'     => 'The Tankerton promenade is about 15 minutes\' flat walk from the property. The town centre and harbour are about a 7-minute drive or 20-minute walk. We can provide exact routes and accessibility notes for any destination before your stay.',
	);
	return $defaults;
}

/**
 * Default meta for the Accessibility page.
 */
function restwell_get_accessibility_page_defaults() {
	return array(
		'acc_label'   => 'Accessibility',
		'acc_heading' => 'Our access statement, room by room',
		'acc_intro'   => 'Doorway widths, ceiling-track hoist and wet room: we list the real measurements so you can decide whether the house works for you. Here is what we have verified in each room.',

		'acc_room_label'      => 'The property',
		'acc_room_heading'    => 'Room by room.',
		'acc_arrival_heading' => 'Arrival & entrance',
		'acc_arrival_body'    => "Private driveway: two off-road car spaces (adapted vehicles welcome)\nOn-street parking outside if you need extra room—no residents permit on this road; check signs on arrival in case street rules change\nStep-free path from car to front door\nWide front door (965 mm clear)\nLevel threshold, no step",
		'acc_inside_heading'  => 'Inside the property',
		'acc_inside_body'     => "All internal doors 926 mm clear\nOpen-plan ground floor, no internal steps\nLevel flooring throughout (no carpet lips)\nCeiling track hoist in the accessible bedroom (full-room track there; wet room is on the same level nearby)",
		'acc_bedroom_heading' => 'Bedrooms & sleeping',
		'acc_bedroom_body'    => "Accessible bedroom: profiling bed with pressure-relieving mattress\nCeiling hoist with full-room track in this room for transfers at the bed\nHeight-adjustable features\nSpace for carer on both sides of bed\nSecond bedroom for additional guests or a support worker\nSofa bed in the living area—house sleeps up to five; tell us your party layout when you enquire",
		'acc_bathroom_heading' => 'Wet room',
		'acc_bathroom_body'   => "Full wet room: roll-in shower, no lip — layout and specification by <a href=\"https://www.carespaces.co.uk/\" target=\"_blank\" rel=\"noopener noreferrer\">Care Spaces</a> (specialist care environments, design & installation)\nPerching stool in the shower for balance and short rests\nShower chair may be available on request; please say so when you enquire or book\nWashbasin is fully height-adjustable and swings aside, so you can set a comfortable working height and move it out of the way for transfers or assistance\nGrab rails: shower, toilet, and washbasin\nFloor-level drain\nExtractor fan",
		'acc_kitchen_heading' => 'Kitchen',
		'acc_kitchen_body'    => "Open-plan kitchen, easy wheelchair access\nHeight-adapted worktop section\nGas hob (not induction)—no electromagnetic field from the cooktop, which many guests with pacemakers prefer\nAccessible storage at lower levels",
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
	return array(
		'faq_label'        => 'FAQ',
		'faq_heading'      => 'Your questions, answered honestly.',
		'faq_intro'        => 'If you can\'t find the answer here, get in touch; we respond within 48 hours.',
		'faq_list_label'   => '',
		'faq_list_heading' => 'Frequently asked questions',

		'faq_1_q'   => 'What is Restwell?',
		'faq_1_a'   => 'Restwell is a high-quality accessible holiday let in Whitstable, Kent. It is a proper coastal holiday home, not a care home, not a clinical facility. We offer the option of professional, CQC-regulated care support through our partner, Continuity of Care Services, but it is entirely optional.',
		'faq_1_cat' => 'about',

		'faq_2_q'   => 'Who is the property suitable for?',
		'faq_2_a'   => 'The property is designed for guests with disabilities, wheelchair users, and people with complex care needs, and the family and carers who travel with them. It is for anyone who finds standard holiday accommodation doesn\'t quite work.',
		'faq_2_cat' => 'about',

		'faq_3_q'   => 'Do I need to book care?',
		'faq_3_a'   => 'No. Care support is entirely optional. Many guests book as a self-catering holiday and need no additional support. If you do want professional care, we will connect you with Continuity of Care Services to arrange it.',
		'faq_3_cat' => 'care',

		'faq_4_q'   => 'What care services are available?',
		'faq_4_a'   => 'Through Continuity of Care Services (CQC-regulated), we can arrange personal care, medication management, moving and handling support, and more. The level of support is entirely up to you, from a daily check-in to comprehensive care.',
		'faq_4_cat' => 'care',

		'faq_5_q'   => 'How do I book?',
		'faq_5_a'   => 'Use our enquiry form, email us, or call. We will get back to you within 48 hours, have a conversation about your needs, and confirm availability. Once you\'re happy, we take a deposit and send a booking confirmation.',
		'faq_5_cat' => 'booking',

		'faq_6_q'   => 'What is the minimum stay?',
		'faq_6_a'   => 'We are flexible. Most guests stay for a week, but shorter breaks are sometimes available depending on the time of year. Get in touch with your preferred dates and we will let you know.',
		'faq_6_cat' => 'booking',

		'faq_7_q'   => 'What is included in the price?',
		'faq_7_a'   => 'Exclusive use of the whole house, all accessibility equipment (ceiling hoist in the accessible bedroom, profiling bed, wet room), linen and towels, two off-road spaces on the private drive, and high-speed broadband. Need a third space? You can usually park on the road outside—there is no residents permit scheme on this road. Care is priced separately if required.',
		'faq_7_cat' => 'booking',

		'faq_8_q'   => 'Is the property suitable for hoists and profiling beds?',
		'faq_8_a'   => 'Yes. The accessible bedroom has a ceiling track hoist and profiling bed, and there is a full roll-in wet room on the same single-storey level, with a perching stool in the shower and a washbasin you can raise, lower, and swing aside when you need clearer space. A shower chair may be available on request; please say so when you enquire or book. If you have additional or specialist equipment needs, please get in touch before booking so we can confirm we can accommodate them.',
		'faq_8_cat' => 'about',

		'faq_9_q'   => 'What is Whitstable like for accessibility?',
		'faq_9_a'   => 'Mostly good: the Tankerton Slopes promenade is excellent for wheelchairs, the town centre is largely flat, and several restaurants and cafes are accessible. The harbour area has some cobblestones and the beach is shingle. Our welcome pack gives detailed local accessibility guidance.',
		'faq_9_cat' => 'local',

		'faq_10_q'   => 'How far is the property from the sea?',
		'faq_10_a'   => 'About a five-minute walk along a flat, tarmac path to the Tankerton Slopes promenade.',
		'faq_10_cat' => 'local',

		'faq_11_q'   => 'What is your cancellation policy?',
		'faq_11_a'   => "More than 30 days before arrival: full refund. 14-30 days before: 50% refund. Less than 14 days before: no refund.\n\nWe recognise that guests booking accessible accommodation may face unexpected medical or care-related changes. If cancellation is due to serious illness or a care emergency, we will consider a partial refund or a free date change subject to availability.\n\nDate changes requested more than 14 days before arrival are free of charge. Changes within 14 days may incur a fee. No refunds for early departure or no-shows.",
		'faq_11_cat' => 'booking',

		'faq_12_q'   => 'Can I visit the property before booking?',
		'faq_12_a'   => 'Pre-booking visits are welcome. Get in touch and we will arrange a convenient time.',
		'faq_12_cat' => 'booking',

		'faq_13_q'   => 'Can I use my direct payment to stay at Restwell?',
		'faq_13_a'   => 'In many cases, yes. Direct payments can often be used for short breaks and respite accommodation, depending on your care plan and local authority. We can provide the documentation your social worker or broker needs to approve the spend. Start with our Funding & Support page or get in touch to discuss your situation.',
		'faq_13_cat' => 'funding',

		'faq_14_q'   => 'What does CQC-regulated mean?',
		'faq_14_a'   => 'CQC stands for Care Quality Commission, the independent regulator of health and social care in England. Continuity of Care Services, our partner provider, is inspected and rated by the CQC. This means the care you receive meets nationally recognised standards for safety and quality. You can see Continuity’s latest inspection summary on the <a href="https://www.cqc.org.uk/location/1-2624556588" target="_blank" rel="noopener noreferrer">Care Quality Commission website<span class="sr-only"> (opens in new tab)</span></a>.',
		'faq_14_cat' => 'funding',

		'faq_cta_label'   => '',
		'faq_cta_heading' => 'Still have a question?',
		'faq_cta_body'    => 'Get in touch and we will answer honestly. We respond within 48 hours.',
		'faq_cta_btn'     => 'Enquire now',
		'faq_cta_url'     => '/enquire/',
	);
}

/**
 * Default meta for the Enquire page.
 */
function restwell_get_enquire_page_defaults() {
	return array(
		'enq_label'   => 'Get in touch',
		'enq_heading' => 'Let\'s talk about your stay.',
		'enq_intro'   => 'Fill in the form and we\'ll call you back within 48 hours. No commitment, no hard sell: just a conversation.',

		'enq_form_heading'        => 'Tell us about your stay',
		'enq_success_heading'     => 'Thank you — we have your enquiry.',
		'enq_success_body'        => 'We usually respond within one to two working days (often sooner), using your preferred contact method where you have told us one. If your dates are tight, say so in your message and we will prioritise a quick first reply.',
		'enq_success_urgent_body' => 'You marked this as time-sensitive. We will prioritise your request and aim to respond within one working day where possible, using your preferred contact method.',

		'enq_contact_heading' => 'Other ways to reach us',
		'enq_email'            => 'hello@restwellretreats.co.uk',
		'enq_phone'            => '01622 809881',
	);
}

/**
 * Default meta for the Resources / Funding & Support page.
 */
function restwell_get_resources_page_defaults() {
	return array(
		'res_label'   => 'Funding & support',
		'res_heading' => 'How to fund an accessible holiday in the UK',
		'res_intro'   => 'There are several ways people pay for a break like this. The most common are direct payments, a personal budget under the Care Act, and NHS Continuing Healthcare. The right route depends on your circumstances, so treat this as a starting point and check the detail with your local authority or care team.',

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
	return array(
		'gg_checkin_time'    => '2:00 pm',
		'gg_checkout_time'   => '11:00 am',
		'gg_house_rules'     => "Please treat the property with care; it is someone's home.\nNo smoking anywhere inside the property.\nDogs are allowed, subject to risk assessment and prior notice. Please keep dogs off the furniture.\nPlease lock all doors and close all windows when you go out.\nReport any damages as soon as possible.",
		'gg_departure_notes' => "Strip the beds and leave used linen in the laundry room.\nPlace all rubbish in the bins provided.\nReturn all keys and fobs to the key safe (location shared on arrival).\nClose all windows and lock all doors.\nLeave the property in a tidy condition. Thank you!",
		'gg_parking_info'    => "Two off-road spaces on the private driveway at the property—enough room for most cars and adapted vehicles if you deploy ramps thoughtfully.\nIf you are bringing more than two cars, you can usually park on the road outside. There is no residents permit scheme on this road, and we have not seen time-limited bay controls here—please still check any street signs when you arrive in case local rules change.",
		'gg_local_info'      => "Whitstable town centre is approximately 15 minutes on foot via a flat, paved route.\nTankerton promenade is about 15 minutes away on foot. The promenade itself is wide, level, and fully surfaced, suitable for wheelchairs and powerchairs. The grassy slopes above it are steep, so stick to the paved path along the seafront. Free parking is available along Marine Parade at the top.\nTesco Extra (Whitstable) is a 7-minute drive and has accessible parking, automatic doors, and a wheelchair-friendly layout.\nWheelchair and equipment hire is available locally; we can share details of trusted suppliers before your stay. Just ask.",
	);
}

/**
 * Default meta for the Who It's For page.
 */
function restwell_get_who_its_for_page_defaults() {
	return array(
		'wif_label'           => 'Who it is for',
		'wif_heading'         => 'Accessible holidays for disabled guests, families and carers',
		'wif_intro'           => 'Restwell suits anyone who needs a step-free holiday with room to bring family, carers or friends. These are the guests we most often welcome, and the features that matter most to each.',
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
		'wg_heading'       => 'A practical local guide for your stay.',
		'wg_intro'         => 'From the Tankerton promenade to harbour stops and day trips, here is what guests usually explore on a Restwell stay, with access notes woven in.',
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
		'wg_eating_body'             => "<strong>The Plough Inn, Swalecliffe</strong> (100 St John's Road, CT5 2RN, 01227 794636): step-free entry, no accessible toilet. Confirm in WP: full access details.\n<strong>JoJo's, Tankerton</strong> (2 Herne Bay Road, CT5 2LQ, 01227 274591): wheelchair access and accessible toilet.\n<strong>Marine Hotel, Tankerton</strong> (32-33 Marine Parade, CT5 2BE, 01227 272672): ground-floor step-free dining, accessible toilet by reception.",
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
 * Add Theme Setup under Appearance.
 */
