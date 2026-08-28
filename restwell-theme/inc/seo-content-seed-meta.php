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
 * Titles are human-shaped (40–60 characters). Focus keyphrases are write-toward phrases
 * for admin scoring and are not required to appear verbatim in the title.
 *
 * @return array<string, array{meta_title:string, meta_description:string, focus_keyphrase:string}>
 */
function restwell_get_seo_meta_defaults_by_slug() {
	$name = get_bloginfo( 'name' );
	// Defaults: 40–60 char human titles. Focus keyphrases stay as write-toward phrases.
	return array(
		'how-it-works'          => array(
			'meta_title'       => 'Booking a stay, from first email to front door',
			'meta_description' => 'Tell us your dates and who’s coming, we confirm the bungalow, you pay a deposit, and then you arrive to a house already set up for you. Care can go on the same note.',
			'focus_keyphrase'  => 'how a restwell stay is booked',
		),
		'home'                  => array(
			'meta_title'       => 'Accessible holiday cottage in Whitstable, sleeps five',
			'meta_description' => 'One private bungalow by the sea, with the wet room and ceiling hoist already fitted. The whole house is yours, and you can add home care if you’d like it.',
			'focus_keyphrase'  => 'accessible holiday cottages by the sea',
		),
		'the-property'          => array(
			'meta_title'       => 'Look inside the accessible holiday bungalow',
			'meta_description' => 'A room-by-room look round the bungalow: two bedrooms, a level-access wet room, an open kitchen, and French doors onto the garden. Sleeps five, and it’s all yours.',
			'focus_keyphrase'  => 'accessible holiday bungalow',
		),
		'accessibility'         => array(
			'meta_title'       => 'A disabled holiday cottage with a wet room and hoist',
			'meta_description' => 'The access statement in full: a 965mm front door, 926mm inside, a ceiling track hoist rated to 180kg, a height-adjustable basin and a tilt-in-space shower commode chair.',
			'focus_keyphrase'  => 'disabled holiday cottages with wet room',
		),
		'who-its-for'           => array(
			'meta_title'       => 'Holidays for disabled adults and their carers',
			'meta_description' => 'A private adapted bungalow that sleeps five, for disabled adults, families and the people who care for them. A holiday, not a placement. See whether it fits.',
			'focus_keyphrase'  => 'holidays for disabled adults and carers',
		),
		'pricing'               => array(
			'meta_title'       => 'Prices for the bungalow, and what’s included',
			'meta_description' => 'A week in the bungalow is £1,300 off-peak and £1,400 in peak season, with all the access equipment included. The rate is the same whoever pays the invoice.',
			'focus_keyphrase'  => 'accessible holiday prices',
		),
		'whitstable-area-guide' => array(
			'meta_title'       => 'Accessible days out in Whitstable and Tankerton',
			'meta_description' => 'Which bits of Whitstable work in a wheelchair and which don’t. Tankerton promenade is level, the harbour beach is shingle, and we’ve named the venues with an accessible loo.',
			'focus_keyphrase'  => 'whitstable accessible days out',
		),
		'enquire'               => array(
			'meta_title'       => 'Ask us anything about a stay at Restwell',
			'meta_description' => 'Call, email, or fill in the form. Tell us your dates and what you need from the house, and put any care questions on the same note. Nothing to pay until it fits.',
			'focus_keyphrase'  => 'contact restwell',
		),
		'faq'                   => array(
			'meta_title'       => 'The questions guests ask us before booking',
			'meta_description' => 'Straight answers about the house, the access equipment, optional home care, deposits and who we can invoice. Then a link to the page that covers it properly.',
			'focus_keyphrase'  => 'restwell faq',
		),
		'resources'             => array(
			'meta_title'       => 'Funding an accessible holiday, and who we invoice',
			'meta_description' => 'We can invoice you, a council, the NHS or a grant body, and the bungalow rate is the same either way. What we can’t do is promise your package will cover it.',
			'focus_keyphrase'  => 'funding an accessible holiday',
		),
		'blog'                  => array(
			'meta_title'       => 'Accessible travel notes from one bungalow',
			'meta_description' => 'Guides written from a single adapted house on the Kent coast: days out that work, funding explained, and how to read an access statement without getting caught out.',
			'focus_keyphrase'  => 'accessible travel',
		),
		'our-story'             => array(
			'meta_title'       => 'Why we built Restwell, and who Continuity are',
			'meta_description' => 'Restwell is a private adapted bungalow in Whitstable. Continuity of Care Services is our sister company for optional home care. Two companies, one family, one phone.',
			'focus_keyphrase'  => 'restwell our story',
		),
		'optional-care'         => array(
			'meta_title'       => 'Home care in the bungalow, if you’d like it',
			'meta_description' => 'Continuity of Care Services, our sister company, can come into the bungalow while you stay. Same conversation as the house. Ring 01622 809881 or send us a note.',
			'focus_keyphrase'  => 'adding home care during a self-catering stay',
		),
		'guest-guide'                              => array(
			'meta_title'       => 'Restwell guest guide for confirmed stays',
			'meta_description' => 'Check-in, WiFi, bins and the departure list for guests with a booking.',
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
			'meta_title'       => 'Privacy Policy for Restwell Guests',
			'meta_description' => 'Restwell privacy policy: what we collect on forms and bookings, cookies, retention periods, your rights under UK GDPR, and how to request changes or deletion.',
			'focus_keyphrase'  => 'restwell privacy',
		),
		'terms-and-conditions'  => array(
			'meta_title'       => 'Restwell Terms: Booking & Payment Rules',
			'meta_description' => 'Restwell terms for bookings: deposits, cancellations, guest responsibilities, how we rely on published access details, and how disputes are handled in the UK.',
			'focus_keyphrase'  => 'restwell terms',
		),
		'accessibility-policy'  => array(
			'meta_title'       => 'Website Accessibility Statement',
			'meta_description' => 'Restwell website accessibility statement: WCAG approach, how we test, third-party limits, known gaps, and how to request information in another format.',
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
