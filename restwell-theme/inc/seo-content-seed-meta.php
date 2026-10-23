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
			'meta_description' => 'Tell us your dates and who’s coming. We confirm the bungalow, you pay a deposit, and you arrive to a house set up for you. Care can go on the same note.',
			'focus_keyphrase'  => 'how to book a stay at restwell',
		),
		'home'                  => array(
			'meta_title'       => 'Accessible holiday cottage in Whitstable, Kent, sleeps five',
			'meta_description' => 'A private bungalow by the sea in Whitstable, Kent, with a level wet room and ceiling hoist fitted. It sleeps five, and our sister company can add care.',
			'focus_keyphrase'  => 'accessible holiday cottages kent',
		),
		'the-property'          => array(
			'meta_title'       => 'Look inside the accessible holiday bungalow',
			'meta_description' => 'A room-by-room look round the bungalow: two bedrooms, a level-access wet room, an open kitchen and French doors to the garden. Sleeps five, and it’s all yours.',
			'focus_keyphrase'  => 'accessible holiday bungalow',
		),
		'accessibility'         => array(
			'meta_title'       => 'A disabled holiday cottage with a wet room and hoist',
			'meta_description' => 'Exact access details: a 965mm front door, 926mm inside doors, and hoists rated to 180kg. There’s also a profiling bed and a level wet room.',
			'focus_keyphrase'  => 'disabled holiday cottage with wet room and hoists',
		),
		'who-its-for'           => array(
			'meta_title'       => 'Holidays for disabled adults and their carers',
			'meta_description' => 'A private adapted bungalow that sleeps five, for disabled adults, families and the people who care for them. A holiday, not a placement. See whether it fits.',
			'focus_keyphrase'  => 'holidays for disabled adults and carers',
		),
		'pricing'               => array(
			'meta_title'       => 'Prices for the bungalow, and what’s included',
			'meta_description' => 'A week in the bungalow is £1,300 off-peak and £1,400 in peak season, with all the access equipment included. The rate is the same whoever pays the invoice.',
			'focus_keyphrase'  => 'restwell retreats prices',
		),
		'whitstable-area-guide' => array(
			'meta_title'       => 'Is Whitstable wheelchair friendly? A local access guide',
			'meta_description' => 'In parts, and we’ll tell you which. Tankerton’s promenade is level, the harbour is step-free with a Changing Places toilet, and the main beach is shingle.',
			'focus_keyphrase'  => 'is whitstable wheelchair friendly',
		),
		'enquire'               => array(
			'meta_title'       => 'Ask us anything about a stay at Restwell',
			'meta_description' => 'Call, email or fill in the form. Tell us your dates and what you need from the house, with any care questions on the same note. Nothing to pay until it fits.',
			'focus_keyphrase'  => 'contact restwell retreats',
		),
		'faq'                   => array(
			'meta_title'       => 'The questions guests ask us before booking',
			'meta_description' => 'Straight answers about the house, the access equipment, optional home care, deposits and who we can invoice. Then a link to the page that covers it properly.',
			'focus_keyphrase'  => 'restwell faq',
		),
		'resources'             => array(
			'meta_title'       => 'Funding and grants for a disabled holiday',
			'meta_description' => 'Holiday grants for disabled adults and carers, plus council and NHS funding. Here’s what each covers, and the paperwork we can send your funder.',
			'focus_keyphrase'  => 'funding and grants for disabled holidays',
		),
		'blog'                  => array(
			'meta_title'       => 'Accessible travel guides from a Whitstable bungalow',
			'meta_description' => 'Guides written from one adapted house on the Kent coast: days out that work, funding explained, and how to read an access statement without getting caught out.',
			'focus_keyphrase'  => 'accessible travel guides',
		),
		'our-story'             => array(
			'meta_title'       => 'Why we built Restwell, and who Continuity are',
			'meta_description' => 'Restwell is a private adapted bungalow in Whitstable. Continuity of Care Services is our sister company for home care. Two companies, one family, one phone.',
			'focus_keyphrase'  => 'restwell retreats',
		),
		'optional-care'         => array(
			'meta_title'       => 'A holiday with care provided in Whitstable, if you want it',
			'meta_description' => 'Continuity of Care Services, our sister company, can come into the bungalow while you stay. Same conversation as the house. Ring 01622 809881 or send us a note.',
			'focus_keyphrase'  => 'holidays with care provided',
		),
		'guest-guide'                              => array(
			'meta_title'       => 'Restwell guest guide for confirmed stays',
			'meta_description' => 'Check-in, WiFi, bins and the departure list for guests with a booking.',
			'focus_keyphrase'  => 'restwell guest guide',
		),
		'accessible-beaches-coastal-walks-kent'    => array(
			'meta_title'       => 'Accessible beaches and coastal walks in Kent' . $name,
			'meta_description' => 'Which Kent beaches work with a wheelchair: the level promenades, where shingle stops you, and where to borrow a beach wheelchair in Thanet.',
			'focus_keyphrase'  => 'accessible beaches kent',
		),
		'direct-payment-holiday-accommodation'     => array(
			'meta_title'       => 'Can I use direct payments for a holiday? A UK guide' . $name,
			'meta_description' => 'A direct payment rarely covers the holiday itself, but it can often pay for your care while you’re away. Here’s what councils allow, and what to ask.',
			'focus_keyphrase'  => 'can I use direct payments for a holiday',
		),
		'revitalise-alternatives-accessible-holidays' => array(
			'meta_title'       => 'Revitalise holidays: what happened, and where to go now' . $name,
			'meta_description' => 'Revitalise closed its holiday centres in November 2024 and now gives respite grants. Here’s what changed, and where to find a break with care now.',
			'focus_keyphrase'  => 'revitalise holidays',
		),
		'how-to-choose-accessible-self-catering-holiday' => array(
			'meta_title'       => 'How to choose an accessible holiday cottage: a checklist' . $name,
			'meta_description' => 'A checklist for choosing an accessible holiday cottage: the kit, the beds, parking, care nearby and the cancellation terms, checked before you pay.',
			'focus_keyphrase'  => 'how to choose an accessible holiday cottage',
		),
		'carers-respite-holiday-guide'             => array(
			'meta_title'       => 'Carer’s assessments and your right to a respite break' . $name,
			'meta_description' => 'Guide to carer assessments and respite rights for unpaid carers: legal routes, funding pathways, and planning steps for short breaks.',
			'focus_keyphrase'  => 'carer assessment respite rights',
		),
		'what-to-pack-accessible-self-catering-uk' => array(
			'meta_title'       => 'What to pack for an accessible self-catering break' . $name,
			'meta_description' => 'What to pack for an accessible self-catering UK break: meds, continence, hoist extras, kitchen aids, and what to confirm with the owner before you travel.',
			'focus_keyphrase'  => 'accessible holiday packing list uk',
		),
		'accessible-parking-whitstable-tankerton' => array(
			'meta_title'       => 'Accessible parking in Whitstable and Tankerton' . $name,
			'meta_description' => 'Accessible parking and drop-off near Whitstable and Tankerton: Blue Badge basics, promenade access, timing tides and crowds, and links to Kent guides.',
			'focus_keyphrase'  => 'accessible parking whitstable',
		),
		'chc-respite-holiday-accommodation-uk' => array(
			'meta_title'       => 'CHC funding and respite holiday accommodation' . $name,
			'meta_description' => 'CHC respite holiday accommodation explained: NHS continuing healthcare versus lodging costs, paperwork panels expect, and funding lines for supported breaks.',
			'focus_keyphrase'  => 'chc respite holiday accommodation',
		),
		'hire-mobility-scooter-equipment-uk-holiday' => array(
			'meta_title'       => 'Hiring mobility equipment for a UK holiday' . $name,
			'meta_description' => 'Hire mobility scooters, shower chairs, and beds for a UK self-catering holiday: measurements, insurance, delivery slots, and what to photograph on handover.',
			'focus_keyphrase'  => 'hire mobility equipment uk holiday',
		),
		'accessible-train-travel-whitstable-kent' => array(
			'meta_title'       => 'Accessible train travel to Whitstable and Kent' . $name,
			'meta_description' => 'Accessible train travel to Whitstable and around Kent: Passenger Assist, platform gaps, connections, and pairing rail with local parking or taxi backup.',
			'focus_keyphrase'  => 'accessible train travel whitstable',
		),
		'travel-insurance-disability-uk-self-catering' => array(
			'meta_title'       => 'Travel insurance for disabled travellers in the UK' . $name,
			'meta_description' => 'Travel insurance and disability on UK self-catering breaks: mobility equipment limits, pre-existing conditions, cancellation triggers, and broker questions.',
			'focus_keyphrase'  => 'travel insurance disability uk self catering',
		),
		'commissioner-checklist-accessible-respite-stay' => array(
			'meta_title'       => 'A commissioner’s checklist for an accessible respite stay' . $name,
			'meta_description' => 'Commissioner checklist for accessible respite stays: hoist paperwork, safeguarding sleep-ins, insurance certificates, and audit-ready evidence before approving nights.',
			'focus_keyphrase'  => 'commissioner accessible respite stay',
		),
		'personal-budget-short-break-care-act' => array(
			'meta_title'       => 'Using a personal budget for a short break' . $name,
			'meta_description' => 'Personal budget short breaks under the Care Act: splitting PA hours, accommodation, and transport receipts so panel audits stay clean.',
			'focus_keyphrase'  => 'personal budget short break care act',
		),
		'accessible-eating-out-whitstable-kent' => array(
			'meta_title'       => 'Accessible places to eat in Whitstable and Kent' . $name,
			'meta_description' => 'Accessible eating out near Whitstable and the Kent coast: step-free entries, toilet routes, quieter tables, and harbour crowding tactics.',
			'focus_keyphrase'  => 'accessible eating out whitstable',
		),
		'changing-places-toilets-kent-coast-days-out' => array(
			'meta_title'       => 'Changing Places toilets for Kent coast days out' . $name,
			'meta_description' => 'Changing Places and accessible toilets for Kent coast days out: how CP differs from standard loos, mapping stops, and pairing with beach plans.',
			'focus_keyphrase'  => 'changing places toilets kent coast',
		),
		'quieter-times-whitstable-low-crowd-access' => array(
			'meta_title'       => 'When Whitstable is quieter: a guide to low-crowd days' . $name,
			'meta_description' => 'Quieter times to visit Whitstable for accessible travellers: weekday patterns, festival pitfalls, parking turnover, and fatigue-friendly pacing.',
			'focus_keyphrase'  => 'quieter times whitstable visit',
		),
		'holiday-backup-plan-care-worker-change' => array(
			'meta_title'       => 'A holiday backup plan if your care worker changes' . $name,
			'meta_description' => 'Holiday backup plans when care workers change or cancel: contingency cards, agency tiers, budgets for emergency cover, and safe escalation.',
			'focus_keyphrase'  => 'holiday backup plan care worker',
		),
		'how-to-read-holiday-cottage-access-statement' => array(
			'meta_title'       => 'Will my wheelchair fit? Reading an access statement' . $name,
			'meta_description' => 'Door widths, turning space, hoist clearance and bed heights explained, with the questions to ask when a cottage’s access statement leaves gaps.',
			'focus_keyphrase'  => 'wheelchair door width',
		),
		'fatigue-friendly-whitstable-coastal-day' => array(
			'meta_title'       => 'A fatigue-friendly day out on the Whitstable coast' . $name,
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
