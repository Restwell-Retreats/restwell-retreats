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
			'meta_description' => 'How to book a stay at Restwell, from your first message to the front door. We check the bungalow fits before you pay any deposit.',
			'focus_keyphrase'  => 'how to book a stay at restwell',
		),
		'home'                  => array(
			'meta_title'       => 'Accessible holiday cottage in Whitstable, Kent, sleeps five',
			'meta_description' => 'An accessible holiday cottage by the sea in Whitstable, Kent, with a level wet room and hoist. It sleeps five, and our sister company can add care.',
			'focus_keyphrase'  => 'accessible holiday cottages kent',
		),
		'the-property'          => array(
			'meta_title'       => 'Look inside the accessible holiday bungalow',
			'meta_description' => 'Look round our accessible holiday bungalow, room by room. There are two bedrooms, a level wet room, a kitchen you can wheel under and a level garden.',
			'focus_keyphrase'  => 'accessible holiday bungalow',
		),
		'accessibility'         => array(
			'meta_title'       => 'A disabled holiday cottage with a wet room and hoist',
			'meta_description' => 'Our disabled holiday cottage in Whitstable has a 965mm front door, 926mm inside doors and a level wet room. Its ceiling and mobile hoists take 180kg.',
			'focus_keyphrase'  => 'disabled holiday cottage with wet room and hoists',
		),
		'who-its-for'           => array(
			'meta_title'       => 'Holidays for disabled adults and their carers',
			'meta_description' => 'A private adapted bungalow that sleeps five, for disabled adults, families and the people who care for them. A holiday, not a placement. See whether it fits.',
			'focus_keyphrase'  => 'holidays for disabled adults and carers',
		),
		'pricing'               => array(
			'meta_title'       => 'Accessible holiday prices at Restwell Retreats, Whitstable',
			'meta_description' => 'Restwell Retreats prices: a week is £1,300 off-peak and £1,400 in peak season, or you can book one night. The access equipment is included.',
			'focus_keyphrase'  => 'restwell retreats prices',
		),
		'whitstable-area-guide' => array(
			'meta_title'       => 'Is Whitstable wheelchair friendly? A local access guide',
			'meta_description' => 'Is Whitstable wheelchair friendly? In parts. Tankerton’s prom is level, the harbour is step-free with a Changing Places toilet, and the beach is shingle.',
			'focus_keyphrase'  => 'is whitstable wheelchair friendly',
		),
		'enquire'               => array(
			'meta_title'       => 'Ask us anything about a stay at Restwell',
			'meta_description' => 'Contact Restwell Retreats on 01622 809881, by email or with the form. Ask about dates, access or care, and we aim to reply within 48 hours.',
			'focus_keyphrase'  => 'contact restwell retreats',
		),
		'faq'                   => array(
			'meta_title'       => 'The questions guests ask us before booking',
			'meta_description' => 'The Restwell FAQ answers what people ask before they book. It covers door widths, hoists, home care, prices and who can pay.',
			'focus_keyphrase'  => 'restwell faq',
		),
		'resources'             => array(
			'meta_title'       => 'Funding and grants for a disabled holiday',
			'meta_description' => 'Holiday grants for disabled adults and carers, plus council and NHS funding. Here’s what each covers, and the paperwork we can send your funder.',
			'focus_keyphrase'  => 'funding and grants for disabled holidays',
		),
		'blog'                  => array(
			'meta_title'       => 'Accessible travel guides from a Whitstable bungalow',
			'meta_description' => 'Accessible travel guides from our adapted bungalow in Whitstable. Read about Kent coast days out, paying for a break and checking an access statement.',
			'focus_keyphrase'  => 'accessible travel guides',
		),
		'our-story'             => array(
			'meta_title'       => 'Why we built Restwell Retreats, and who Continuity are',
			'meta_description' => 'Why we built Restwell Retreats, a private adapted bungalow in Whitstable. Our sister company, Continuity of Care Services, can add home care to your stay.',
			'focus_keyphrase'  => 'restwell retreats',
		),
		'optional-care'         => array(
			'meta_title'       => 'A holiday with care provided in Whitstable, if you want it',
			'meta_description' => 'A holiday with care provided, if you want it. Our sister company, Continuity of Care Services, can come into the bungalow. Just ask when you enquire.',
			'focus_keyphrase'  => 'holidays with care provided',
		),
		'guest-guide'                              => array(
			'meta_title'       => 'Restwell guest guide for confirmed stays',
			'meta_description' => 'The Restwell guest guide for booked guests: check-in, WiFi, the bins and the list of jobs before you leave. We email you the access code.',
			'focus_keyphrase'  => 'restwell guest guide',
		),
		'accessible-beaches-coastal-walks-kent'    => array(
			'meta_title'       => 'Accessible beaches and coastal walks in Kent' . $name,
			'meta_description' => 'Which accessible beaches in Kent work with a wheelchair? See the level promenades, where shingle stops you, and where to borrow a beach wheelchair in Thanet.',
			'focus_keyphrase'  => 'accessible beaches kent',
		),
		'direct-payment-holiday-accommodation'     => array(
			'meta_title'       => 'Can I use direct payments for a holiday? A UK guide' . $name,
			'meta_description' => 'Can you use direct payments for a holiday? They rarely cover the stay itself, but they can often pay for your care while you’re away. Here’s what to ask.',
			'focus_keyphrase'  => 'can I use direct payments for a holiday',
		),
		'revitalise-alternatives-accessible-holidays' => array(
			'meta_title'       => 'Revitalise holidays: what happened, and where to go now' . $name,
			'meta_description' => 'Revitalise holidays ended when its centres closed in November 2024, and it now gives respite grants. Here’s where to find a break with care now.',
			'focus_keyphrase'  => 'revitalise holidays',
		),
		'how-to-choose-accessible-self-catering-holiday' => array(
			'meta_title'       => 'How to choose an accessible holiday cottage: a checklist' . $name,
			'meta_description' => 'Here’s how to choose an accessible holiday cottage. Check the equipment, beds, parking, nearby care and cancellation terms before you pay.',
			'focus_keyphrase'  => 'how to choose an accessible holiday cottage',
		),
		'carers-respite-holiday-guide'             => array(
			'meta_title'       => 'Respite for carers: how to get a break from caring' . $name,
			'meta_description' => 'Respite for carers means someone else helps while you take a break. Here’s how to ask your council, what a carer’s assessment covers and who pays.',
			'focus_keyphrase'  => 'respite for carers',
		),
		'what-to-pack-accessible-self-catering-uk' => array(
			'meta_title'       => 'What to pack for an accessible self-catering break' . $name,
			'meta_description' => 'What to pack for an accessible self-catering UK break: meds, continence, hoist extras, kitchen aids, and what to confirm with the owner before you travel.',
			'focus_keyphrase'  => 'accessible holiday packing list uk',
		),
		'accessible-parking-whitstable-tankerton' => array(
			'meta_title'       => 'Blue Badge parking in Whitstable and Tankerton' . $name,
			'meta_description' => 'Blue Badge parking in Whitstable: three free hours in council car parks, which ones need your badge registered first, and where to park for Tankerton.',
			'focus_keyphrase'  => 'blue badge parking whitstable',
		),
		'chc-respite-holiday-accommodation-uk' => array(
			'meta_title'       => 'CHC respite care: what the NHS pays for on a break' . $name,
			'meta_description' => 'CHC respite care explained: what NHS Continuing Healthcare pays for while your carer has a break, what it won’t cover on holiday, and what to ask.',
			'focus_keyphrase'  => 'chc respite care',
		),
		'hire-mobility-scooter-equipment-uk-holiday' => array(
			'meta_title'       => 'Mobility scooter and wheelchair hire in Whitstable' . $name,
			'meta_description' => 'Mobility scooter hire in Whitstable: where to hire a scooter or wheelchair, what it costs, the rules for scooters, and what’s already at Restwell.',
			'focus_keyphrase'  => 'mobility scooter hire whitstable',
		),
		'accessible-train-travel-whitstable-kent' => array(
			'meta_title'       => 'Is Whitstable station step-free? Trains to Whitstable' . $name,
			'meta_description' => 'Is Whitstable station step-free? Yes, by two entrances. Here’s which to use, how to book Passenger Assist, and taking a wheelchair or scooter on the train.',
			'focus_keyphrase'  => 'whitstable station step free',
		),
		'travel-insurance-disability-uk-self-catering' => array(
			'meta_title'       => 'Travel insurance for a UK holiday if you’re disabled' . $name,
			'meta_description' => 'Travel insurance for a UK holiday if you’re disabled: why it’s worth having, what to tell the insurer, wheelchair cover and what to do if refused.',
			'focus_keyphrase'  => 'travel insurance disabled uk',
		),
		'personal-budget-short-break-care-act' => array(
			'meta_title'       => 'Respite under the Care Act 2014: what your council must do' . $name,
			'meta_description' => 'Care Act 2014 respite explained: your right to an assessment, how councils arrange a break, who pays for it, and what to do if the council says no.',
			'focus_keyphrase'  => 'care act 2014 respite',
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
		'how-to-read-holiday-cottage-access-statement' => array(
			'meta_title'       => 'Will my wheelchair fit? Door widths and access statements' . $name,
			'meta_description' => 'Will your wheelchair fit? Door widths, turning space, hoist clearance and bed heights explained, plus what to ask when an access statement leaves gaps.',
			'focus_keyphrase'  => 'wheelchair door width',
		),
		'fatigue-friendly-whitstable-coastal-day' => array(
			'meta_title'       => 'A fatigue-friendly day out on the Whitstable coast' . $name,
			'meta_description' => 'Fatigue-friendly coastal days around Whitstable: pacing blocks, sensory load, wind and glare, hydration, and realistic promenade targets.',
			'focus_keyphrase'  => 'fatigue friendly whitstable coastal day',
		),
		'privacy-policy'        => array(
			'meta_title'       => 'Restwell Retreats privacy policy',
			'meta_description' => 'The Restwell Retreats privacy policy covers what we collect when you enquire or book, and how long we keep it. It also explains cookies and your rights.',
			'focus_keyphrase'  => 'restwell retreats privacy policy',
		),
		'terms-and-conditions'  => array(
			'meta_title'       => 'Restwell Retreats booking terms and conditions',
			'meta_description' => 'The Restwell Retreats terms and conditions cover deposits, cancelling and changing dates. They also cover guest numbers and what happens if we cancel.',
			'focus_keyphrase'  => 'restwell retreats terms and conditions',
		),
		'accessibility-policy'  => array(
			'meta_title'       => 'Restwell Retreats website accessibility statement',
			'meta_description' => 'The Restwell Retreats website accessibility statement explains how we test against WCAG 2.2 AA. It lists known gaps and how to ask for another format.',
			'focus_keyphrase'  => 'restwell retreats website accessibility statement',
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
