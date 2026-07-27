<?php
/**
 * SEO meta defaults and apply helpers.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default meta_title, meta_description, and focus_keyphrase by page/post slug (path without slashes).
 * Each meta_description is written so it contains the focus keyphrase (checked in SEO admin analysis).
 *
 * @return array<string, array{meta_title:string, meta_description:string, focus_keyphrase:string}>
 */
function restwell_get_seo_meta_defaults_by_slug() {
	$name = get_bloginfo( 'name' );
	// Defaults tuned for 50–60 char titles, 120–160 char descriptions, unique focus keyphrases (cannibalization), and theme SEO admin keyphrase checks.
	return array(
		'how-it-works'          => array(
			'meta_title'       => 'Accessible Stay Booking Process | Restwell Retreats',
			'meta_description' => 'An accessible stay with Restwell starts at enquiry: share access needs, confirm dates, add optional CQC-regulated care, then arrive ready.',
			'focus_keyphrase'  => 'accessible stay',
		),
		'home'                  => array(
			'meta_title'       => 'Accessible Holidays Whitstable | Restwell Retreats',
			'meta_description' => 'Accessible holidays Whitstable: a step-free self-catering home on the Kent coast. Explore the bungalow, access statement and how booking works.',
			'focus_keyphrase'  => 'accessible holidays whitstable',
		),
		'the-property'          => array(
			'meta_title'       => 'Accessible Bungalow Whitstable | Restwell Retreats',
			'meta_description' => 'Accessible bungalow Whitstable: single-storey, step-free layout with room-by-room specs, inclusions and optional care for your party.',
			'focus_keyphrase'  => 'accessible bungalow whitstable',
		),
		'accessibility'         => array(
			'meta_title'       => 'Wheelchair Accessible Holiday Cottage | Restwell Retreats',
			'meta_description' => 'Wheelchair accessible holiday cottage access statement: ceiling hoist, level-access wet room, door widths 965mm and 926mm, plus parking.',
			'focus_keyphrase'  => 'wheelchair accessible holiday cottage',
		),
		'who-its-for'           => array(
			'meta_title'       => 'Accessible Stay Suitability | Who It Fits | Restwell',
			'meta_description' => 'Accessible stay suitability for guests, carers, OTs and commissioners. Check who Restwell suits before you enquire about dates.',
			'focus_keyphrase'  => 'accessible stay suitability',
		),
		// Reserved for Job 11 (template-pricing.php). Do not invent the page here.
		'pricing'               => array(
			'meta_title'       => 'Accessible Holiday Pricing Whitstable | Restwell Retreats',
			'meta_description' => 'Accessible holiday pricing Whitstable: rates, deposit rules, funding routes and care costs explained before you enquire.',
			'focus_keyphrase'  => 'accessible holiday pricing whitstable',
		),
		'whitstable-area-guide' => array(
			'meta_title'       => 'Whitstable Kent Coast Guide | Days Out | ' . $name,
			'meta_description' => 'The Whitstable Kent coast: accessible days out in Canterbury, Faversham, Herne Bay, Tankerton. Where to eat, promenade walks, parking, and travel tips.',
			'focus_keyphrase'  => 'whitstable kent coast',
		),
		'enquire'               => array(
			'meta_title'       => 'Contact & Enquire | Restwell | ' . $name,
			'meta_description' => 'Contact Restwell by phone, email, or enquiry form for rates, availability, and access questions. We usually reply within 48 hours.',
			'focus_keyphrase'  => 'contact restwell',
		),
		'faq'                   => array(
			'meta_title'       => 'Accessible Holiday FAQs | Restwell Retreats',
			'meta_description' => 'Quick answers on bookings, assistance dogs, parking and access details at our step-free Whitstable bungalow, with links to the full room-by-room guides.',
			'focus_keyphrase'  => 'accessible holiday faq whitstable',
		),
		'resources'             => array(
			'meta_title'       => 'Funding an Accessible Respite Holiday | Restwell',
			'meta_description' => 'How families fund an accessible respite break: direct payments, personal budgets under the Care Act, and NHS Continuing Healthcare. A plain-English guide.',
			'focus_keyphrase'  => 'fund accessible respite holiday',
		),
		'blog'                  => array(
			'meta_title'       => 'Accessible Travel Blog | Kent Stories | ' . $name,
			'meta_description' => 'Accessible travel and Kent coast guides: days out, planning tips, funding news, and stories from guests with disabilities and carers.',
			'focus_keyphrase'  => 'accessible travel',
		),
		'guest-guide'                              => array(
			'meta_title'       => 'Restwell Guest Guide | Check-In Tips | ' . $name,
			'meta_description' => 'Restwell guest guide: check-in, Wi-Fi, house rules, parking, and local tips for Whitstable. Everything confirmed guests need in one place.',
			'focus_keyphrase'  => 'restwell guest guide',
		),
		'accessible-beaches-coastal-walks-kent'    => array(
			'meta_title'       => 'Accessible Beaches Kent | Coast Walks | ' . $name,
			'meta_description' => 'Accessible beaches Kent: level promenades, Beach Within Reach, Herne Bay, Viking Bay, Margate. Plan a seaside day with realistic access notes.',
			'focus_keyphrase'  => 'accessible beaches kent',
		),
		'direct-payment-holiday-accommodation'     => array(
			'meta_title'       => 'Direct Payment for Holiday | Funding | ' . $name,
			'meta_description' => 'Direct payment for holiday stays: what counts as care vs accommodation, personal budgets, short breaks, and questions for your social worker.',
			'focus_keyphrase'  => 'direct payment for holiday',
		),
		'revitalise-alternatives-accessible-holidays' => array(
			'meta_title'       => 'Revitalise Centres Closed | What Next | ' . $name,
			'meta_description' => 'Revitalise closed its holiday centres in 2024: why, what the charity funds now, and where to find accessible UK holidays and respite alternatives.',
			'focus_keyphrase'  => 'revitalise',
		),
		'how-to-choose-accessible-self-catering-holiday' => array(
			'meta_title'       => 'Accessible Self-Catering Holiday Guide | ' . $name,
			'meta_description' => 'Choose an accessible self-catering holiday: verify hoist specs, door widths, wet rooms, and red flags in listings before you pay a deposit.',
			'focus_keyphrase'  => 'accessible self-catering holiday',
		),
		'carers-respite-holiday-guide'             => array(
			'meta_title'       => 'Carer Assessment & Respite Rights Guide | ' . $name,
			'meta_description' => 'Guide to carer assessments and respite rights for unpaid carers: legal routes, funding pathways, and planning steps for short breaks.',
			'focus_keyphrase'  => 'carer assessment respite rights',
		),
		'what-to-pack-accessible-self-catering-uk' => array(
			'meta_title'       => 'Accessible Holiday Packing List UK | Self-Catering | ' . $name,
			'meta_description' => 'What to pack for an accessible self-catering UK break: meds, continence, hoist extras, kitchen aids, and what to confirm with the owner before you travel.',
			'focus_keyphrase'  => 'accessible holiday packing list uk',
		),
		'accessible-parking-whitstable-tankerton' => array(
			'meta_title'       => 'Accessible Parking Whitstable | Tankerton | ' . $name,
			'meta_description' => 'Accessible parking and drop-off near Whitstable and Tankerton: Blue Badge basics, promenade access, timing tides and crowds, and links to Kent guides.',
			'focus_keyphrase'  => 'accessible parking whitstable',
		),
		'chc-respite-holiday-accommodation-uk' => array(
			'meta_title'       => 'CHC Respite Holiday Accommodation UK | ' . $name,
			'meta_description' => 'CHC respite holiday accommodation explained: NHS continuing healthcare versus lodging costs, paperwork panels expect, and funding lines for supported breaks.',
			'focus_keyphrase'  => 'chc respite holiday accommodation',
		),
		'hire-mobility-scooter-equipment-uk-holiday' => array(
			'meta_title'       => 'Hire Mobility Equipment UK Holiday | Self-Catering | ' . $name,
			'meta_description' => 'Hire mobility scooters, shower chairs, and beds for a UK self-catering holiday: measurements, insurance, delivery slots, and what to photograph on handover.',
			'focus_keyphrase'  => 'hire mobility equipment uk holiday',
		),
		'accessible-train-travel-whitstable-kent' => array(
			'meta_title'       => 'Accessible Train Travel Whitstable Kent | ' . $name,
			'meta_description' => 'Accessible train travel to Whitstable and around Kent: Passenger Assist, platform gaps, connections, and pairing rail with local parking or taxi backup.',
			'focus_keyphrase'  => 'accessible train travel whitstable',
		),
		'travel-insurance-disability-uk-self-catering' => array(
			'meta_title'       => 'Travel Insurance Disability UK Self-Catering | ' . $name,
			'meta_description' => 'Travel insurance and disability on UK self-catering breaks: mobility equipment limits, pre-existing conditions, cancellation triggers, and broker questions.',
			'focus_keyphrase'  => 'travel insurance disability uk self catering',
		),
		'commissioner-checklist-accessible-respite-stay' => array(
			'meta_title'       => 'Commissioner Checklist Accessible Respite Stay | ' . $name,
			'meta_description' => 'Commissioner checklist for accessible respite stays: hoist paperwork, safeguarding sleep-ins, insurance certificates, and audit-ready evidence before approving nights.',
			'focus_keyphrase'  => 'commissioner accessible respite stay',
		),
		'personal-budget-short-break-care-act' => array(
			'meta_title'       => 'Personal Budget Short Break Care Act | ' . $name,
			'meta_description' => 'Personal budget short breaks under the Care Act: splitting PA hours, accommodation, and transport receipts so panel audits stay clean.',
			'focus_keyphrase'  => 'personal budget short break care act',
		),
		'accessible-eating-out-whitstable-kent' => array(
			'meta_title'       => 'Accessible Eating Out Whitstable Kent | ' . $name,
			'meta_description' => 'Accessible eating out near Whitstable and the Kent coast: step-free entries, toilet routes, quieter tables, and harbour crowding tactics.',
			'focus_keyphrase'  => 'accessible eating out whitstable',
		),
		'changing-places-toilets-kent-coast-days-out' => array(
			'meta_title'       => 'Changing Places Toilets Kent Coast | Days Out | ' . $name,
			'meta_description' => 'Changing Places and accessible toilets for Kent coast days out: how CP differs from standard loos, mapping stops, and pairing with beach plans.',
			'focus_keyphrase'  => 'changing places toilets kent coast',
		),
		'quieter-times-whitstable-low-crowd-access' => array(
			'meta_title'       => 'Quieter Times Whitstable Visit | Low Crowd Access | ' . $name,
			'meta_description' => 'Quieter times to visit Whitstable for accessible travellers: weekday patterns, festival pitfalls, parking turnover, and fatigue-friendly pacing.',
			'focus_keyphrase'  => 'quieter times whitstable visit',
		),
		'holiday-backup-plan-care-worker-change' => array(
			'meta_title'       => 'Holiday Backup Plan Care Worker Change | ' . $name,
			'meta_description' => 'Holiday backup plans when care workers change or cancel: contingency cards, agency tiers, budgets for emergency cover, and safe escalation.',
			'focus_keyphrase'  => 'holiday backup plan care worker',
		),
		'how-to-read-holiday-cottage-access-statement' => array(
			'meta_title'       => 'How to Read Holiday Cottage Access Statement | ' . $name,
			'meta_description' => 'How to read a holiday cottage access statement: measurements that matter, hoist proof, red-flag phrases, and questions OTs and families should ask.',
			'focus_keyphrase'  => 'holiday cottage access statement',
		),
		'fatigue-friendly-whitstable-coastal-day' => array(
			'meta_title'       => 'Fatigue Friendly Whitstable Coastal Day | ' . $name,
			'meta_description' => 'Fatigue-friendly coastal days around Whitstable: pacing blocks, sensory load, wind and glare, hydration, and realistic promenade targets.',
			'focus_keyphrase'  => 'fatigue friendly whitstable coastal day',
		),
		'privacy-policy'        => array(
			'meta_title'       => 'Restwell Privacy | Policy & Data | ' . $name,
			'meta_description' => 'Restwell privacy policy: what we collect on forms and bookings, cookies, retention, your rights, and how to request changes or deletion.',
			'focus_keyphrase'  => 'restwell privacy',
		),
		'terms-and-conditions'  => array(
			'meta_title'       => 'Restwell Terms | Bookings & Payments | ' . $name,
			'meta_description' => 'Restwell terms for bookings: deposits, cancellations, guest responsibilities, accessibility reliance, and how disputes are handled.',
			'focus_keyphrase'  => 'restwell terms',
		),
		'accessibility-policy'  => array(
			'meta_title'       => 'Website Accessibility | Restwell | ' . $name,
			'meta_description' => 'Accessibility statement for the Restwell Retreats website: WCAG-based approach, how we test, third-party content, and how to request information in another format.',
			'focus_keyphrase'  => 'restwell website accessibility',
		),
	);
}

/**
 * SEO defaults for a page ID (by slug, with front page / posts page fallbacks).
 *
 * @param int $post_id Post ID.
 * @return array{meta_title: string, meta_description: string, focus_keyphrase: string}
 */
function restwell_get_seo_default_meta_for_post_id( $post_id ) {
	$post_id = absint( $post_id );
	$empty   = array(
		'meta_title'        => '',
		'meta_description'  => '',
		'focus_keyphrase'   => '',
	);
	if ( $post_id < 1 ) {
		return $empty;
	}

	$post = get_post( $post_id );
	if ( ! $post instanceof WP_Post ) {
		return $empty;
	}

	$map  = restwell_get_seo_meta_defaults_by_slug();
	$slug = $post->post_name;
	if ( isset( $map[ $slug ] ) ) {
		return $map[ $slug ];
	}

	$front = (int) get_option( 'page_on_front', 0 );
	if ( $front === $post_id && isset( $map['home'] ) ) {
		return $map['home'];
	}

	$posts_page = (int) get_option( 'page_for_posts', 0 );
	if ( $posts_page === $post_id && isset( $map['blog'] ) ) {
		return $map['blog'];
	}

	return $empty;
}

/**
 * Apply SEO meta to pages and seeded blog posts when keys are empty (idempotent).
 *
 * @param bool $force Overwrite existing meta_title, meta_description, and focus_keyphrase.
 */
function restwell_apply_seo_meta_to_pages( $force = false ) {
	$map = restwell_get_seo_meta_defaults_by_slug();

	$apply = static function ( $post_id, $seo ) use ( $force ) {
		if ( $force || get_post_meta( $post_id, 'meta_title', true ) === '' ) {
			update_post_meta( $post_id, 'meta_title', $seo['meta_title'] );
		}
		if ( $force || get_post_meta( $post_id, 'meta_description', true ) === '' ) {
			update_post_meta( $post_id, 'meta_description', $seo['meta_description'] );
		}
		if ( ! empty( $seo['focus_keyphrase'] ) && ( $force || get_post_meta( $post_id, 'focus_keyphrase', true ) === '' ) ) {
			update_post_meta( $post_id, 'focus_keyphrase', $seo['focus_keyphrase'] );
		}
	};

	$pages = get_pages(
		array(
			'post_status' => 'publish',
			'number' => 500,
		)
	);
	foreach ( $pages as $page ) {
		$slug = $page->post_name;
		if ( ! isset( $map[ $slug ] ) ) {
			continue;
		}
		$apply( (int) $page->ID, $map[ $slug ] );
	}

	$posts = get_posts(
		array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => 500,
			'fields'         => 'ids',
		)
	);
	foreach ( $posts as $post_id ) {
		$post = get_post( $post_id );
		if ( ! $post ) {
			continue;
		}
		$slug = $post->post_name;
		if ( ! isset( $map[ $slug ] ) ) {
			continue;
		}
		$apply( (int) $post_id, $map[ $slug ] );
	}
}
