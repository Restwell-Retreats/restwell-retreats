<?php
/**
 * Priority blog post seeding and HTML (posts 1–7 cluster).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The priority guides: slug, title, excerpt, SEO meta, body and category.
 * Shared by the seeder and by migrations that refresh seeded posts.
 *
 * @return array<int, array<string, string>>
 */
function restwell_get_priority_blog_post_articles(): array {
	return array(
		array(
			'slug'             => 'accessible-beaches-coastal-walks-kent',
			'title'            => 'Accessible beaches and level coastal walks in Kent',
			'excerpt'          => 'Some Kent beaches and sea walks work well on wheels, and some don’t. Here’s where to go, and where to borrow a beach wheelchair in Thanet.',
			'meta_title'       => 'Accessible beaches and coastal walks in Kent',
			'meta_description' => 'Which Kent beaches work with a wheelchair: the level promenades, where shingle stops you, and where to borrow a beach wheelchair in Thanet.',
			'content'          => restwell_get_blog_post_beaches_kent_html(),
			'category_slug'    => 'kent-coast',
		),
		array(
			'slug'             => 'direct-payment-holiday-accommodation',
			'title'            => 'Can I use direct payments for a holiday?',
			'excerpt'          => 'This guide explains what a direct payment can pay for on a break, who decides, and what to ask first.',
			'meta_title'       => 'Can I use direct payments for a holiday? A UK guide',
			'meta_description' => 'A direct payment rarely covers the holiday itself, but it can often pay for your care while you’re away. Here’s what councils allow, and what to ask.',
			'content'          => restwell_get_blog_post_direct_payments_html(),
			'category_slug'    => 'funding-care',
		),
		array(
			'slug'             => 'revitalise-alternatives-accessible-holidays',
			'title'            => 'What happened to Revitalise holidays, and where to go now',
			'excerpt'          => 'Here’s where to find a break with care now that the Revitalise centres have closed.',
			'meta_title'       => 'Revitalise holidays: what happened, and where to go now',
			'meta_description' => 'Revitalise closed its holiday centres in November 2024 and now gives respite grants. Here’s what changed, and where to find a break with care now.',
			'content'          => restwell_get_blog_post_revitalise_html(),
			'category_slug'    => 'news-updates',
		),
		array(
			'slug'             => 'how-to-choose-accessible-self-catering-holiday',
			'title'            => 'How to choose an accessible holiday cottage: a checklist before you pay',
			'excerpt'          => 'The word “accessible” can mean almost anything on a listing. This checklist covers what to ask before you pay, from door widths and hoists to care and cancellation terms.',
			'meta_title'       => 'How to choose an accessible holiday cottage: a checklist',
			'meta_description' => 'A checklist for choosing an accessible holiday cottage: the kit, the beds, parking, care nearby and the cancellation terms, checked before you pay.',
			'content'          => restwell_get_blog_post_self_catering_checklist_html(),
			'category_slug'    => 'accessible-holidays',
		),
		array(
			'slug'             => 'carers-respite-holiday-guide',
			'title'            => 'Carers taking holidays: respite rights, funding, and how to plan a break that works',
			'excerpt'          => 'A guide for unpaid carers who need a break. It covers your rights under the Care Act and getting a carer’s assessment in Kent, and it explains how a break is paid for.',
			'meta_title'       => 'Carer’s assessments and your right to a respite break',
			'meta_description' => 'Guide to carer assessments and respite rights for unpaid carers: legal routes, funding pathways, and planning steps for short breaks.',
			'content'          => restwell_get_blog_post_carers_respite_html(),
			'category_slug'    => 'funding-care',
		),
		array(
			'slug'             => 'what-to-pack-accessible-self-catering-uk',
			'title'            => 'What to pack for an accessible self-catering break in the UK',
			'excerpt'          => 'A room-by-room packing list for hoist users, continence care, medicines and the kitchen, and what to check with the owner before you go.',
			'meta_title'       => 'What to pack for an accessible self-catering break',
			'meta_description' => 'What to pack for an accessible self-catering UK break: meds, continence, hoist extras, kitchen aids, and what to confirm with the owner before you travel.',
			'content'          => restwell_get_blog_post_pack_accessible_self_catering_html(),
			'category_slug'    => 'accessible-holidays',
		),
		array(
			'slug'             => 'accessible-parking-whitstable-tankerton',
			'title'            => 'Accessible parking and drop-off around Whitstable and Tankerton',
			'excerpt'          => 'Blue Badge basics, where parking gets tight by the sea, and how to park close to the level seafront path. We won’t pretend a space is always free.',
			'meta_title'       => 'Accessible parking in Whitstable and Tankerton',
			'meta_description' => 'Accessible parking and drop-off near Whitstable and Tankerton: Blue Badge basics, promenade access, timing tides and crowds, and links to Kent guides.',
			'content'          => restwell_get_blog_post_accessible_parking_whitstable_html(),
			'category_slug'    => 'kent-coast',
		),
		array(
			'slug'             => 'chc-respite-holiday-accommodation-uk',
			'title'            => 'CHC, respite, and holiday accommodation: plain English for families and commissioners',
			'excerpt'          => 'What NHS Continuing Healthcare can and can’t pay for on a break. It covers how the care and the rent are billed, and what a panel needs to see.',
			'meta_title'       => 'CHC funding and respite holiday accommodation',
			'meta_description' => 'CHC respite holiday accommodation explained: NHS continuing healthcare versus lodging costs, paperwork panels expect, and funding lines for supported breaks.',
			'content'          => restwell_get_blog_post_chc_respite_holiday_accommodation_html(),
			'category_slug'    => 'funding-care',
		),
		array(
			'slug'             => 'hire-mobility-scooter-equipment-uk-holiday',
			'title'            => 'Hiring mobility equipment for a UK self-catering holiday',
			'excerpt'          => 'How to hire a scooter, profiling bed or shower chair for your trip. It covers door widths, insurance and delivery, so you know what to check before you sign.',
			'meta_title'       => 'Hiring mobility equipment for a UK holiday',
			'meta_description' => 'Hire mobility scooters, shower chairs, and beds for a UK self-catering holiday: measurements, insurance, delivery slots, and what to photograph on handover.',
			'content'          => restwell_get_blog_post_hire_mobility_equipment_uk_html(),
			'category_slug'    => 'accessible-holidays',
		),
		array(
			'slug'             => 'accessible-train-travel-whitstable-kent',
			'title'            => 'Accessible train travel to Whitstable and around Kent',
			'excerpt'          => 'How Passenger Assist works, what to know about platform gaps and taxis, and why it’s worth having a backup plan if buses replace the trains.',
			'meta_title'       => 'Accessible train travel to Whitstable and Kent',
			'meta_description' => 'Accessible train travel to Whitstable and around Kent: Passenger Assist, platform gaps, connections, and pairing rail with local parking or taxi backup.',
			'content'          => restwell_get_blog_post_accessible_train_whitstable_kent_html(),
			'category_slug'    => 'kent-coast',
		),
		array(
			'slug'             => 'travel-insurance-disability-uk-self-catering',
			'title'            => 'Travel insurance, disability, and UK self-catering breaks',
			'excerpt'          => 'What to ask an insurer about your kit, your health and cancelling before a break in the UK. This is practical help, not legal advice.',
			'meta_title'       => 'Travel insurance for disabled travellers in the UK',
			'meta_description' => 'Travel insurance and disability on UK self-catering breaks: mobility equipment limits, pre-existing conditions, cancellation triggers, and broker questions.',
			'content'          => restwell_get_blog_post_travel_insurance_disability_uk_html(),
			'category_slug'    => 'accessible-holidays',
		),
		array(
			'slug'             => 'commissioner-checklist-accessible-respite-stay',
			'title'            => 'Commissioner checklist: evidencing an accessible respite stay',
			'excerpt'          => 'The proof a funding panel usually wants before it agrees to nights away, from hoist paperwork to sleep-in plans and insurance.',
			'meta_title'       => 'A commissioner’s checklist for an accessible respite stay',
			'meta_description' => 'Commissioner checklist for accessible respite stays: hoist paperwork, safeguarding sleep-ins, insurance certificates, and audit-ready evidence before approving nights.',
			'content'          => restwell_get_blog_post_commissioner_accessible_respite_html(),
			'category_slug'    => 'funding-care',
		),
		array(
			'slug'             => 'personal-budget-short-break-care-act',
			'title'            => 'Personal budgets and short breaks under the Care Act',
			'excerpt'          => 'What a direct payment can and can’t cover on a short break, such as PA hours and a PA’s travel. It also shows how to keep your council’s paperwork tidy.',
			'meta_title'       => 'Using a personal budget for a short break',
			'meta_description' => 'Personal budget short breaks under the Care Act: splitting PA hours, accommodation, and transport receipts so panel audits stay clean.',
			'content'          => restwell_get_blog_post_personal_budget_short_break_html(),
			'category_slug'    => 'funding-care',
		),
		array(
			'slug'             => 'accessible-eating-out-whitstable-kent',
			'title'            => 'Accessible eating out near Whitstable and along the Kent coast',
			'excerpt'          => 'Places to eat with step-free access and an accessible toilet, how to get a quieter table, and why the harbour gets so busy at weekends.',
			'meta_title'       => 'Accessible places to eat in Whitstable and Kent',
			'meta_description' => 'Accessible eating out near Whitstable and the Kent coast: step-free entries, toilet routes, quieter tables, and harbour crowding tactics.',
			'content'          => restwell_get_blog_post_accessible_eating_out_whitstable_html(),
			'category_slug'    => 'kent-coast',
		),
		array(
			'slug'             => 'changing-places-toilets-kent-coast-days-out',
			'title'            => 'Changing Places and accessible toilets for Kent coast days out',
			'excerpt'          => 'Where to find Changing Places and accessible toilets on the Kent coast, and how to plan your stops before a long walk by the sea.',
			'meta_title'       => 'Changing Places toilets for Kent coast days out',
			'meta_description' => 'Changing Places and accessible toilets for Kent coast days out: how CP differs from standard loos, mapping stops, and pairing with beach plans.',
			'content'          => restwell_get_blog_post_changing_places_kent_coast_html(),
			'category_slug'    => 'kent-coast',
		),
		array(
			'slug'             => 'quieter-times-whitstable-low-crowd-access',
			'title'            => 'Quieter times to visit Whitstable if you need space and calm',
			'excerpt'          => 'When Whitstable is at its quietest, which events to plan around, and why parking can matter as much as the tide.',
			'meta_title'       => 'When Whitstable is quieter: a guide to low-crowd days',
			'meta_description' => 'Quieter times to visit Whitstable for accessible travellers: weekday patterns, festival pitfalls, parking turnover, and fatigue-friendly pacing.',
			'content'          => restwell_get_blog_post_quieter_whitstable_visit_html(),
			'category_slug'    => 'kent-coast',
		),
		array(
			'slug'             => 'holiday-backup-plan-care-worker-change',
			'title'            => 'Backup plans when care arrangements change on holiday',
			'excerpt'          => 'What to do if a carer falls ill during your break, from backup cover to knowing when it’s safer to come home early.',
			'meta_title'       => 'A holiday backup plan if your care worker changes',
			'meta_description' => 'Holiday backup plans when care workers change or cancel: contingency cards, agency tiers, budgets for emergency cover, and safe escalation.',
			'content'          => restwell_get_blog_post_holiday_backup_care_plan_html(),
			'category_slug'    => 'accessible-holidays',
		),
		array(
			'slug'             => 'how-to-read-holiday-cottage-access-statement',
			'title'            => 'Will my wheelchair fit? How to read a holiday cottage access statement',
			'excerpt'          => 'Here’s how to check a cottage’s doors, beds and hoists against your own chair. It also covers what to ask when details are missing.',
			'meta_title'       => 'Will my wheelchair fit? Reading an access statement',
			'meta_description' => 'Door widths, turning space, hoist clearance and bed heights explained, with the questions to ask when a cottage’s access statement leaves gaps.',
			'content'          => restwell_get_blog_post_read_access_statement_html(),
			'category_slug'    => 'accessible-holidays',
		),
		array(
			'slug'             => 'fatigue-friendly-whitstable-coastal-day',
			'title'            => 'Fatigue-friendly coastal days around Whitstable',
			'excerpt'          => 'How to plan a day by the sea with places to rest, a route that suits you and an easy way home.',
			'meta_title'       => 'A fatigue-friendly day out on the Whitstable coast',
			'meta_description' => 'Plan a fatigue-friendly day around Whitstable, with practical checks for routes, seating, toilets, weather and the journey back.',
			'content'          => restwell_get_blog_post_fatigue_friendly_coastal_day_html(),
			'category_slug'    => 'kent-coast',
		),
	);
}

/**
 * Seed priority blog posts. Pass $force = true to overwrite existing content.
 *
 * @param array $result Result array with optional key blog_posts_seeded.
 * @param bool  $force  Overwrite existing post content and meta.
 */
function restwell_seed_priority_blog_posts( array &$result, bool $force = false ) {
	if ( ! isset( $result['blog_posts_seeded'] ) ) {
		$result['blog_posts_seeded'] = array();
	}
	if ( ! isset( $result['blog_posts_failed'] ) ) {
		$result['blog_posts_failed'] = array();
	}

	$posts_page = (int) get_option( 'page_for_posts', 0 );
	if ( $posts_page < 1 ) {
		return;
	}

	$site_name = get_bloginfo( 'name' );
	$seo_map   = restwell_get_seo_meta_defaults_by_slug();

	$articles = restwell_get_priority_blog_post_articles();

	foreach ( $articles as $article ) {
		$existing_posts = get_posts(
			array(
				'name'           => $article['slug'],
				'post_type'      => 'post',
				'post_status'    => 'any',
				'posts_per_page' => 1,
				'fields'         => 'ids',
			)
		);

		if ( ! empty( $existing_posts ) ) {
			if ( ! $force ) {
				continue;
			}
			// Force-update existing post content and meta.
			$post_id = (int) $existing_posts[0];
			$updated = wp_update_post(
				array(
					'ID'           => $post_id,
					'post_content' => wp_kses_post( $article['content'] ),
					'post_excerpt' => $article['excerpt'],
				),
				true
			);
			if ( is_wp_error( $updated ) ) {
				$result['blog_posts_failed'][] = $article['slug'];
				continue;
			}
			update_post_meta( $post_id, 'meta_title', $article['meta_title'] );
			update_post_meta( $post_id, 'meta_description', $article['meta_description'] );
			if ( ! empty( $seo_map[ $article['slug'] ]['focus_keyphrase'] ) ) {
				update_post_meta( $post_id, 'focus_keyphrase', $seo_map[ $article['slug'] ]['focus_keyphrase'] );
			}
			$result['blog_posts_seeded'][] = $article['title'] . ' (updated)';
			continue;
		}

		// Resolve or create the category term (slugs match inc/blog-categories.php).
		$cat_id = 0;
		$defs   = function_exists( 'restwell_get_blog_category_definitions' ) ? restwell_get_blog_category_definitions() : array();
		$slug   = isset( $article['category_slug'] ) ? sanitize_title( $article['category_slug'] ) : '';

		if ( $slug && isset( $defs[ $slug ] ) ) {
			$name = $defs[ $slug ]['name'];
			$term = term_exists( $slug, 'category' );
			if ( ! $term ) {
				$term = term_exists( $name, 'category' );
			}
			if ( ! $term ) {
				$term = wp_insert_term(
					$name,
					'category',
					array(
						'slug'        => $slug,
						'description' => $defs[ $slug ]['description'],
					)
				);
			}
		} elseif ( ! empty( $article['category'] ) ) {
			$name = (string) $article['category'];
			$term = term_exists( $name, 'category' );
			if ( ! $term ) {
				$term = wp_insert_term( $name, 'category' );
			}
		} else {
			$term = null;
		}

		if ( ! empty( $term ) && ! is_wp_error( $term ) ) {
			$cat_id = is_array( $term ) ? (int) $term['term_id'] : (int) $term;
		}

		$insert_args = array(
			'post_title'    => $article['title'],
			'post_name'     => $article['slug'],
			'post_status'   => 'publish',
			'post_type'     => 'post',
			'post_content'  => wp_kses_post( $article['content'] ),
			'post_excerpt'  => $article['excerpt'],
			'post_author'   => max( 1, (int) get_current_user_id() ),
		);
		if ( $cat_id ) {
			$insert_args['post_category'] = array( $cat_id );
		}

		$post_id = wp_insert_post( $insert_args, true );

		if ( is_wp_error( $post_id ) || ! $post_id ) {
			$result['blog_posts_failed'][] = $article['slug'];
			continue;
		}
		update_post_meta( $post_id, 'meta_title', $article['meta_title'] );
		update_post_meta( $post_id, 'meta_description', $article['meta_description'] );
		if ( ! empty( $seo_map[ $article['slug'] ]['focus_keyphrase'] ) ) {
			update_post_meta( $post_id, 'focus_keyphrase', $seo_map[ $article['slug'] ]['focus_keyphrase'] );
		}
		$result['blog_posts_seeded'][] = $article['title'];
	}
}

/**
 * @return string
 */
function restwell_get_blog_post_beaches_kent_html() {
	$whitstable = esc_url( home_url( '/whitstable-area-guide/' ) );
	$home       = esc_url( home_url( '/' ) );

	return "<blockquote><p><strong>TL;DR:</strong> Most of the Kent coast is shingle, which is hard going on wheels. Plan your day around the level promenades and the few sandy bays. In Thanet, you can also borrow a beach wheelchair at Minnis Bay, Westbrook Bay and Viking Bay.</p></blockquote>

<h2>Which beaches in Kent are wheelchair accessible?</h2>
<p>The easiest seaside days in Kent are spent on the promenades rather than the beaches. The paths from Whitstable to Herne Bay, and the seafronts in Thanet, are level and paved. For sand, head to Thanet's bays, some of which lend beach wheelchairs.</p>
<p>Most north Kent beaches are shingle, and loose stones can stop a wheelchair or a walking frame. A level path by the sea, with a café and a toilet along the way, usually makes a better day.</p>

<h2>Which Kent seaside town is best for wheelchair users?</h2>
<p>There isn't one winner, because it depends on what you want from the day. For a long, level walk by the sea, try Herne Bay or the path from Tankerton. If you want to get onto the sand, Thanet's bays are your best bet.</p>
<ul>
<li><strong>A long, level seafront:</strong> Herne Bay, or the promenade from Tankerton towards Herne Bay.</li>
<li><strong>Sand and a beach wheelchair:</strong> Minnis Bay, Westbrook Bay or Viking Bay.</li>
<li><strong>A harbour, shops and food:</strong> Whitstable, where the harbour is step-free.</li>
<li><strong>Somewhere new to explore:</strong> Folkestone Harbour Arm, which is mostly ramped.</li>
</ul>

<h2>Whitstable and Tankerton</h2>
<p>About two miles of paved path runs along the top of Tankerton Slopes towards the castle and the harbour. The grass slopes down to the beach are steep, so stay on the path for a level route. The beach itself is shingle.</p>
<p>Whitstable Harbour is step-free, and it has a Changing Places toilet run by Canterbury City Council. The town's older streets are narrower, with some uneven paving. Our <a href=\"{$whitstable}\">guide to getting around Whitstable on wheels</a> covers the routes we know well.</p>
<p>At low tide, you'll see The Street, a ridge of shingle running out to sea from Tankerton. It looks tempting, but it's loose stone and no place for wheels.</p>

<h2>Herne Bay and Reculver</h2>
<p>The Oyster Bay Trail runs for about eight miles from Whitstable to Reculver, passing through Herne Bay. Most of it is a flat path along the sea wall, shared with cyclists. In Herne Bay, it joins a traffic-calmed seafront road with a 20mph limit.</p>
<p>Most of the trail is paved, but about a tenth of it has a loose surface. Check the stretch you plan to use before you set off.</p>
<p>Herne Bay's seafront is wide and level, with cafés along the way. There's a Changing Places toilet at the Sainsbury's in the town.</p>
<p>At the far end, Reculver Country Park has a visitor centre and a café. Its Changing Places toilet opened in 2022. It's a good place to turn back if you're following the trail.</p>

<h2>Minnis Bay and Margate</h2>
<p>Minnis Bay in Birchington has a sandy beach, a promenade and nine disabled bays in its car park. It's also one of the beaches where you can borrow a beach wheelchair.</p>
<p>Westbrook Bay in Margate also lends a beach wheelchair, and Barnes Car Park nearby has five disabled bays. Margate's Main Sands are close by, with the old town and the seafront beyond.</p>
<p>Margate has two Changing Places toilets. One is at the station, on platform 1, and opens with a RADAR key. The other is at Thanet Gateway Plus in Cecil Square.</p>

<h2>Broadstairs and Viking Bay</h2>
<p>Viking Bay is a sandy bay in the middle of Broadstairs, with two beach wheelchairs to borrow. In summer, a lift runs from the promenade down to the beach. A wooden boardwalk also crosses part of the sand.</p>
<p>The lift has been closed for repairs in some years, so check that it's running before you go. When the Pavilion is open, you can also reach the boardwalk through its gardens.</p>
<p>Away from the bay, Broadstairs is hilly, so it helps to park as close as you can. Joss Bay, just up the coast, has four disabled bays in its car park.</p>

<h2>Folkestone Harbour Arm</h2>
<p>Folkestone Harbour Arm is a long, historic harbour wall with food stalls and views back over the town. Ramps and slopes give access to most of the site, and there are accessible toilets and Blue Badge bays.</p>
<p>The harbour team doesn't recommend the boardwalk for wheelchairs or scooters, so keep to the main route. It's under an hour's drive from Whitstable, so it works well as a day trip.</p>

<h2>Can you take a wheelchair onto sand or shingle?</h2>
<p>A standard wheelchair sinks into soft sand and gets stuck in shingle. A beach wheelchair has wide balloon tyres, so someone can push you across the sand. In Thanet, you can borrow one through a scheme called Beach Within Reach.</p>
<p>The scheme is run by Your Leisure's Bay Inspectors, who keep chairs at Minnis Bay, Westbrook Bay and Viking Bay. You can book one on the Your Leisure website or app, or by calling 03333 660661.</p>
<p>You'll need to be able to transfer into the chair without a hoist, and you'll need someone to push you. If that doesn't suit you, a level promenade is the better choice.</p>

<h2>Where are the Changing Places toilets on the Kent coast?</h2>
<p>A Changing Places toilet has a hoist, an adult-sized changing bench and more room than a standard accessible toilet. There are several along this stretch of coast, though their opening times vary. Check the Changing Places map before you set off.</p>
<ul>
<li><strong>Whitstable:</strong> at the harbour.</li>
<li><strong>Herne Bay:</strong> at Sainsbury's.</li>
<li><strong>Reculver:</strong> in the country park.</li>
<li><strong>Margate:</strong> at the station and at Thanet Gateway Plus.</li>
<li><strong>Ramsgate:</strong> at the Royal Victoria Pavilion.</li>
</ul>

<h2>When is the best time to go?</h2>
<p>Weekday mornings outside the school holidays are the quietest, with more room on the paths and in car parks. In summer, the lifts run, and opening hours are at their longest. Whatever the month, check the tide, because high tide covers much of the sand.</p>
<p>Spring and early autumn are a good compromise. The weather is milder, the crowds are smaller, and most cafés are open. Winter can be lovely on a calm day, but expect fewer open toilets and shorter hours.</p>

<h2>Practical steps before you go</h2>
<ul>
<li>Check the tide times, because at high tide some bays have little or no sand left.</li>
<li>Book a beach wheelchair a few days ahead, especially for a summer weekend.</li>
<li>Get a RADAR key if you don't have one. Margate's visitor information centre sells them.</li>
<li>Check each council's Blue Badge rules, because they differ from town to town.</li>
<li>Check that the lifts and toilets are open, especially outside the summer season.</li>
</ul>

<h2>Common mistakes on a coast day out</h2>
<ul>
<li>Assuming a Blue Flag means the beach suits wheels. The award is about the water, not the surface.</li>
<li>Heading out onto the shingle at low tide without knowing how loose it is.</li>
<li>Assuming that lifts and beach wheelchairs are available all year.</li>
<li>Leaving parking to chance on a hot weekend.</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>How do people in wheelchairs go to the beach?</h3>
<p>Most use a level promenade beside the beach, or a boardwalk or mat where there is one. To get onto the sand, many borrow a beach wheelchair with wide tyres, pushed by a friend or carer.</p>
<h3>Can I use a wheelchair on beach sand?</h3>
<p>A standard chair will usually sink in soft sand. Wet, firm sand near the water is easier, but it changes with the tide. A beach wheelchair is the safer choice.</p>
<h3>Do I need to book a beach wheelchair in Thanet?</h3>
<p>Yes, it's best to book, because there are only one or two chairs at each beach. You can book through Your Leisure on 03333 660661, or on its website or app.</p>
<h3>Is Tankerton promenade suitable for a powerchair?</h3>
<p>Yes. The path along the top of Tankerton Slopes is paved and level. Use the paths from Marine Parade to reach it, rather than crossing the grass.</p>

<h2>Closing</h2>
<p>Whitstable makes a good base for all of these, and Thanet and Folkestone are close enough for a day trip. If you need somewhere to stay, see <a href=\"{$home}\">our accessible holiday home in Whitstable</a>, which is ten minutes from the seafront.</p>";
}

/**
 * @return string
 */
function restwell_get_blog_post_direct_payments_html() {
	$funding = esc_url( home_url( '/funding-and-support/' ) );
	$care    = esc_url( home_url( '/optional-care/' ) );
	$enquire = esc_url( home_url( '/enquire/' ) );

	return "<blockquote><p><strong>TL;DR:</strong> A direct payment usually won't pay for the holiday itself. However, it can often pay for the care you need while you're away, such as your PA's hours. You'll usually pay for the holiday home yourself.</p></blockquote>

<h2>Do direct payments cover holiday costs?</h2>
<p>Usually, they don't, because a direct payment has to meet the needs in your care and support plan. That means it can often pay for your care while you're away, such as your PA's hours. You'll normally pay for the holiday home and travel yourself.</p>
<p>The rule comes from the Care Act 2014. A direct payment lets you arrange your own care, instead of the council arranging it for you. The money follows your needs, not where you happen to be that week.</p>
<p>So the question for your council isn't whether it will pay for your holiday. It's whether it will pay for your care while you're away. For the other costs, see our guide to <a href=\"{$funding}\">grants and other ways to fund a disabled holiday</a>.</p>

<h2>What can direct payments pay for while you're away?</h2>
<p>They can pay for the care and support in your plan, wherever you are. For most people, that means a PA's wages for their usual hours. Some councils also agree to pay a PA's travel and accommodation costs, or for extra hours during the trip.</p>
<ul>
<li><strong>Your PA's hours:</strong> the hours in your plan can usually go with you.</li>
<li><strong>An agency where you're staying:</strong> you can often pay a registered care agency near your holiday base.</li>
<li><strong>Your PA's travel and accommodation:</strong> some councils agree, some agree only in special cases, and some refuse.</li>
<li><strong>A short respite stay:</strong> many councils allow direct payments to be used for short breaks and respite.</li>
</ul>
<p>What they don't normally cover is the cost of the holiday itself. That means your own travel, the holiday home, your food and your days out. Councils also rule out things like alcohol, tobacco and gambling.</p>

<h2>Who decides what's allowed?</h2>
<p>Your council decides, based on your care and support plan. The national guidance doesn't set a rule for holidays, so each council writes its own policy. That's why two people in different areas can get different answers to the same question.</p>
<p>Croydon's October 2025 policy is one example. It lets you use a direct payment for a care home stay of up to four weeks in a row. For a trip abroad, though, you pay your PA's travel and accommodation yourself, unless there's an exceptional reason.</p>
<p>Other councils draw the line elsewhere. Read your own council's direct payments policy, or ask your social worker for a copy. You can usually find it by searching for your council's name and \"direct payments policy\".</p>

<h2>What should you ask your social worker?</h2>
<p>Ask about the care, not the holiday. Explain where you'd like to go, for how long, and what help you'll need each day. Then ask which of the costs your direct payment can cover, and get the answer in writing.</p>
<ul>
<li>Can my PA's hours go with me, and can I add hours for the trip?</li>
<li>Can my direct payment cover my PA's travel or accommodation?</li>
<li>Can I use it to pay a care agency near where I'm staying?</li>
<li>Is there a short breaks budget I can apply for this year?</li>
<li>What paperwork do you need from me, and by when?</li>
</ul>

<h2>Can a family carer use a direct payment for a break?</h2>
<p>Yes, a family carer can ask the council for their own assessment. If they have needs that the council must meet, it can arrange care for you while they take a break. It can also fund that care through a direct payment.</p>
<p>That care might take place at home, or on a holiday you take together. Ask the council what it would fund before you book anything, because the rules for carers vary as well.</p>

<h2>What about NHS Continuing Healthcare?</h2>
<p>If you get NHS Continuing Healthcare, the NHS pays for your care, not the council. You have the right to a personal health budget, which can be paid to you as a direct payment. It has to meet the needs in your NHS care plan.</p>
<p>On holiday, that usually means paying for the care you need, just as a council direct payment would. Some areas don't allow health budgets to be used for respite breaks. Check with your CHC team or care co-ordinator first.</p>

<h2>What is an individual service fund?</h2>
<p>An individual service fund, or ISF, is your care budget, held by a provider you choose. The provider arranges your support with you, so you don't have to employ anyone. It suits people who want a say in their care without becoming an employer.</p>
<p>The same rule applies, though: an ISF pays only for the support in your plan. Whether that support can travel with you is up to your council and the provider.</p>

<h2>Practical steps before you book</h2>
<ul>
<li>Find your council's direct payments policy and look for anything on holidays, travel or respite.</li>
<li>Write down how many hours of care you'll need on each day of the trip.</li>
<li>Ask whether your PA's travel and accommodation can be paid for, and get the answer in writing.</li>
<li>Get a written quote for the stay, and a quote for any care you'll book there.</li>
<li>Wait for the council to agree before you pay a deposit.</li>
</ul>

<h2>Common mistakes to avoid</h2>
<ul>
<li>Paying for the holiday home from your direct payment account without written agreement.</li>
<li>Asking the council to fund \"a holiday\" when what you need is care while you're away.</li>
<li>Assuming last year's answer still stands, when policies and plans change.</li>
<li>Leaving your request until a few weeks before you go.</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>What can you not use direct payments for?</h3>
<p>You can't use them for anything that isn't in your care and support plan. Most councils also rule out alcohol, tobacco, gambling and everyday living costs, such as food and your rent at home. Your council's policy will have the full list.</p>
<h3>Can my PA come on holiday with me?</h3>
<p>Yes, as long as your plan covers the hours. Their wages can usually come from your direct payment. Whether their travel and accommodation can be paid for is up to your council, so ask first.</p>
<h3>Can direct payments pay for respite?</h3>
<p>Often, yes. Many councils let you use them for short breaks, such as a short stay in a care home. A holiday home is a different matter, and the answer depends on your council and your plan.</p>
<h3>Can I use direct payments for care abroad?</h3>
<p>Sometimes. Some councils agree, as long as the care meets your plan and the agency is properly regulated. Many won't pay for a PA's travel abroad unless there's a strong reason.</p>
<h3>What happens if I spend it on the wrong thing?</h3>
<p>The council can ask for the money back. Keep every receipt and invoice, and get any unusual spending agreed in writing first.</p>

<h2>How guests at Restwell use direct payments</h2>
<p>Restwell is a private, adapted bungalow in Whitstable, and many of our guests bring their own PA. Their direct payment often covers the PA's hours. They pay for the bungalow another way, such as from savings or with a grant.</p>
<p>Other guests book care from Continuity of Care Services, our sister company. Continuity talks through what's needed and gives a quote, which you can show your council. Read more about <a href=\"{$care}\">booking care from Continuity during your stay</a>.</p>

<h2>Closing</h2>
<p>If it helps, we can send you a written quote for the bungalow to show your council. <a href=\"{$enquire}\">Ask us for a quote for your funder</a>, and tell us the dates you have in mind.</p>";
}

/**
 * @return string
 */
function restwell_get_blog_post_revitalise_html() {
	$funding = esc_url( home_url( '/funding-and-support/' ) );
	$care    = esc_url( home_url( '/optional-care/' ) );
	$enquire = esc_url( home_url( '/enquire/' ) );
	$who     = esc_url( home_url( '/who-its-for/' ) );

	return "<blockquote><p><strong>TL;DR:</strong> Revitalise closed its holiday centres in November 2024, after more than 60 years. The charity now gives grants towards breaks, usually of about £500 a person. Today, the main options are group trips with care, activity centres, and self-catering stays with care added.</p></blockquote>

<h2>What happened to Revitalise holidays?</h2>
<p>Revitalise closed its last two holiday centres in November 2024. They were Sandpipers in Southport and Jubilee Lodge in Chigwell, Essex. The charity said that rising costs, and less respite funding from councils and grant-makers, left it with no other option.</p>
<p>For many guests and their families, it was a real loss. The centres offered a break with care on site, day and night, in a place built for the purpose.</p>

<h2>What was Revitalise?</h2>
<p>Revitalise began in 1963 as the Winged Fellowship Trust. It ran holiday centres where disabled adults could stay with care on hand, alone or with a family carer. Trips, meals and company were part of every stay.</p>
<p>It also ran a third centre, Netley Waterside House near Southampton. That centre closed earlier, in 2020, and has since been sold.</p>

<h2>Why did the centres close?</h2>
<p>Running a centre with care around the clock is very expensive. Revitalise said that its costs kept rising while respite funding from councils and grant-makers fell. In the end, it couldn't keep the centres open.</p>
<p>The same pressures affect the whole of adult social care, so another charity is unlikely to open similar centres soon.</p>

<h2>Does Revitalise still help with holidays?</h2>
<p>Yes, Revitalise now gives grants instead of running centres. Disabled adults and carers aged 18 and over can apply for help towards a break in the UK or abroad. The usual grant is about £500 a person.</p>
<ul>
<li><strong>Breaks and holidays:</strong> usually about £500 a person, and sometimes more. If you travel with a carer, you can both be considered.</li>
<li><strong>A break at home:</strong> up to £100 towards care at home, so that a family carer can take a break.</li>
<li><strong>Day trips and activities:</strong> up to £100 each, towards things like tickets, travel, meals or care.</li>
</ul>
<p>You can apply online, on a paper form, or by phone on set days. Only a set number of grants is given each month. People who haven't had one in the last year come first.</p>

<h2>Where can you go now instead?</h2>
<p>No single place offers everything Revitalise did, but there are good options. The right one depends on how much care you need and who you'd like to go with. It also depends on how much of the planning you want to do yourself.</p>
<h3>Group holidays with care</h3>
<p>Some companies run trips in the UK and abroad, with care staff travelling with the group. Limitless Travel is one example. This is the closest thing to the old centres, with company and care built in.</p>
<h3>Activity centres</h3>
<p>The Calvert Trust runs centres in the Lake District, Kielder and Exmoor. They offer outdoor activities for disabled people, with somewhere to stay on site. The Lake District centre is open 50 weeks a year.</p>
<h3>Self-catering with your own carer</h3>
<p>An adapted holiday home gives you a whole house to yourselves. You bring your own carer, PA or family, and set your own routine. It works best when the house already has the equipment you need.</p>
<h3>Self-catering with care added</h3>
<p>Some adapted holiday homes can arrange care from a local care company during your stay. You get the privacy of a house, with help in the morning, during the day or overnight. You'll be given a quote for the care first.</p>

<h2>How is a self-catering break different?</h2>
<p>A self-catering break is your own holiday, in your own space. There's no timetable, no shared dining room and nobody else's routine to fit around. The trade-off is that you do more of the planning, from the equipment to the care.</p>
<p>That's why it's worth checking the details before you book. Look for exact door widths, the type of hoist and bed, and how the bathroom works. If you need care, ask early how it's arranged and what it costs.</p>

<h2>How can you pay for a break now?</h2>
<p>Most people combine a few sources, such as a Revitalise grant or help from another charity like the 3H Foundation. If the council pays for your care, a direct payment may cover that care while you're away. It rarely pays for the stay itself.</p>
<p>A family carer can also ask the council for a carer's assessment, which can lead to support for a break. Our funding page covers <a href=\"{$funding}\">ways to fund an accessible holiday</a>, from grants to council funding.</p>

<h2>Frequently asked questions</h2>
<h3>Why did Revitalise close its centres?</h3>
<p>It closed them because of rising costs and less respite funding from councils and grant-makers. The charity still exists, and it now gives grants towards breaks.</p>
<h3>Are the Revitalise centres reopening?</h3>
<p>No reopening has been announced. Revitalise now focuses on grants, so it's worth checking its website for any news.</p>
<h3>How much is a Revitalise grant?</h3>
<p>It's usually about £500 a person for a break or holiday. Grants for a break at home, a day trip or an activity are usually up to £100.</p>
<h3>Can people on PIP get a free holiday?</h3>
<p>There's no free holiday scheme for people on PIP. However, some charities ask about benefits such as PIP, so mention it when you apply for a grant.</p>

<h2>Where Restwell fits</h2>
<p>Restwell is a private, adapted bungalow in Whitstable, with a ceiling hoist, a profiling bed and a level-access wet room. It's a holiday home, not a care centre, so it feels quite different from Revitalise. Before you decide, see <a href=\"{$who}\">who the Whitstable bungalow suits</a>.</p>
<p>Many guests bring their own carer or PA. Others add care from Continuity of Care Services, our sister company, which is rated Good by the Care Quality Commission. If that sounds useful, read about <a href=\"{$care}\">a self-catering break with care provided</a>.</p>

<h2>Closing</h2>
<p>If you're not sure what would suit you now, we're happy to talk it through. <a href=\"{$enquire}\">Ask us whether the bungalow would suit you</a>, and we'll give you a straight answer.</p>";
}

/**
 * @return string
 */
function restwell_get_blog_post_self_catering_checklist_html() {
	$enquire       = esc_url( home_url( '/enquire/' ) );
	$statement     = esc_url( home_url( '/how-to-read-holiday-cottage-access-statement/' ) );
	$accessibility = esc_url( home_url( '/accessibility/' ) );
	$property      = esc_url( home_url( '/the-property/' ) );

	return "<blockquote><p><strong>TL;DR:</strong> Don't rely on the word \"accessible\" on its own. Ask for the door measurements, the make of the hoist and bed, and photos of the bathroom. Then check the parking, care nearby and cancellation terms, and get the answers in writing before you pay.</p></blockquote>

<h2>Where can I find cottages with disabled access?</h2>
<p>Start with the specialist agencies and directories, which let you filter for a wet room or a hoist. Euan's Guide has reviews written by disabled visitors. Some adapted houses also have their own websites, often with far more detail than an agency listing.</p>
<p>Treat the results of any filter as a shortlist, not a promise. One owner's \"accessible\" can mean a grab rail, while another's means a ceiling hoist. The checklist below helps you find out which you're looking at.</p>

<h2>What should an accessible holiday cottage have?</h2>
<p>That depends on you, so start with your own needs rather than the listing. Write down how you get in and out of bed, how you wash, and what equipment you use at home. Then look for a cottage that matches, item by item.</p>
<p>For many guests, the essentials come down to a short list.</p>
<ul>
<li>A step-free route from the car to the front door.</li>
<li>Doors wide enough for your chair, measured as the clear opening.</li>
<li>A level-access shower or wet room, with grab rails.</li>
<li>A bed you can get in and out of, with space beside it.</li>
<li>A hoist, if you use one, and room to use it.</li>
<li>Somewhere for a carer or PA to sleep, if one is coming.</li>
</ul>

<h2>Arriving and getting in</h2>
<p>Ask how you get from the car to the front door, step by step. \"Ramped access\" can mean a gentle slope or a steep one, so ask for the gradient or a photo.</p>
<ul>
<li>Is the parking level and firm, and is there room for a side or rear ramp?</li>
<li>Is the route to the door step-free, or are there slopes, gravel or kerbs?</li>
<li>Is there a lip at the front door, and how high is it?</li>
<li>Is there somewhere else to park nearby if the drive is full?</li>
</ul>

<h2>Doors, rooms and turning space</h2>
<p>Ask for the clear opening of each door, in millimetres. That's the gap you can actually pass through, and it's narrower than the door itself. Our guide explains <a href=\"{$statement}\">how to check door widths against your own chair</a>.</p>
<ul>
<li>What's the clear opening of the front door and of each inside door?</li>
<li>Are all the rooms on one level, with no steps or raised thresholds between them?</li>
<li>Is there space to turn your chair in the bedroom and bathroom? Building guidance for wheelchair users' homes allows a 1500mm turning circle.</li>
</ul>

<h2>The bathroom</h2>
<p>The bathroom is where most listings fall short, so this is where to ask the most questions. A photo of the whole room, taken from the doorway, tells you more than any description.</p>
<ul>
<li>Is the shower level, with no step or tray edge to cross?</li>
<li>Where are the grab rails, and are there rails on both sides of the toilet?</li>
<li>What shower seat is there: a stool, a chair or a tilting chair?</li>
<li>Can you reach the basin from a seat, and can it be raised or lowered?</li>
<li>Is there an alarm cord, and who does it alert?</li>
</ul>

<h2>The bedroom, beds and hoists</h2>
<p>Ask for the make and model of the bed and the hoist. With those, you or your OT can look up details such as safe working loads and heights. If the owner can't name them, that tells you something too.</p>
<ul>
<li>Is it a profiling bed, and how low and how high does it go?</li>
<li>Is there space on both sides of the bed for transfers and for a carer?</li>
<li>Is there a ceiling hoist, a mobile hoist or both, and which rooms does each one reach?</li>
<li>What's the hoist's safe working load, and when was it last examined?</li>
<li>Do you need to bring your own sling? You usually do, because a sling has to fit the person using it.</li>
</ul>
<p>Under the LOLER rules, hoists used at work to lift people need a thorough examination every six months. Many owners follow the same timetable, so ask for the date of the last one.</p>

<h2>The kitchen and living space</h2>
<ul>
<li>Can you use the worktop, hob and oven from a seated position?</li>
<li>Are the living room, bedroom and bathroom all on the same level?</li>
<li>Can you reach the light switches, sockets and heating controls?</li>
<li>Is there a chair or sofa that you can get in and out of easily?</li>
</ul>

<h2>Care and support while you stay</h2>
<p>If you need care, decide how it will work before you book the house. You might bring a PA or a family member, or book a local care agency. Some houses can also arrange care for you.</p>
<p>If you're booking an agency, ask how much notice it needs and what it will cost. Agencies in holiday areas can be busy in summer, so ask early.</p>

<h2>Booking terms and paperwork</h2>
<p>Read the cancellation terms with your health in mind. Plans can change at short notice, so check what happens to your deposit if you have to cancel. It's also worth finding travel insurance that covers your condition and your equipment.</p>
<p>If someone else is paying, such as a council or the NHS, ask the owner for a written quote. Most funders want one before they agree to anything.</p>

<h2>Practical steps before you pay</h2>
<ul>
<li>Email the owner your questions, so that you have the answers in writing.</li>
<li>Ask for photos of the bathroom, the bedroom and the route from the car.</li>
<li>Check the door widths against your own chair, measured at its widest point.</li>
<li>Show the details to your OT or carer, if you have one.</li>
<li>Check the cancellation terms and your travel insurance.</li>
<li>Pay the deposit only when you're happy that the house will work for you.</li>
</ul>

<h2>Red flags in a listing</h2>
<ul>
<li>\"Wheelchair friendly\" with no measurements anywhere.</li>
<li>Photos that never show the whole bathroom.</li>
<li>A hoist that's mentioned without a make, model or safe working load.</li>
<li>Vague answers to direct questions, or no answer at all.</li>
<li>Pressure to pay before your questions have been answered.</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>Which measurement matters most?</h3>
<p>For most wheelchair users, it's the clear opening of the doors. If your chair can't get through the bathroom door, nothing else in the house matters.</p>
<h3>Can I trust the accessible filter on booking sites?</h3>
<p>Use it to build a shortlist, then check the details with the owner. Filters only show what owners have ticked.</p>
<h3>What is a wet room for a disabled person?</h3>
<p>It's a bathroom where the shower floor is level with the rest of the room. You can wheel straight in, with no tray or step to cross.</p>
<h3>Should I bring my own equipment?</h3>
<p>Bring anything that's personal to you, such as your sling and your own chair. Ask the owner what's already there before you hire anything else.</p>

<h2>How Restwell answers these questions</h2>
<p>We've tried to answer every question on this list before you need to ask it. You'll find the makes, models and measurements in <a href=\"{$accessibility}\">our details of the wet room, ceiling hoist and profiling bed</a>.</p>
<p>For a feel of the house, take <a href=\"{$property}\">a room-by-room look round our bungalow</a>. If something isn't covered, ask us and we'll measure it.</p>

<h2>Closing</h2>
<p>A good owner won't mind how many questions you ask. If you'd like to ask us yours, <a href=\"{$enquire}\">send us your questions about the bungalow</a>.</p>";
}

/**
 * @return string
 */
function restwell_get_blog_post_carers_respite_html() {
	$res       = esc_url( home_url( '/funding-and-support/' ) );
	$blog      = esc_url( home_url( '/blog/' ) );
	$enq       = esc_url( home_url( '/enquire/' ) );
	$who       = esc_url( home_url( '/who-its-for/' ) );
	$loc       = esc_url( home_url( '/whitstable-area-guide/' ) );
	$dp        = esc_url( home_url( '/direct-payment-holiday-accommodation/' ) );
	$checklist = esc_url( home_url( '/how-to-choose-accessible-self-catering-holiday/' ) );

	return "<blockquote><p><strong>TL;DR:</strong> Unpaid carers can request a carer's assessment under the Care Act 2014; Kent County Council may fund wellbeing support after that conversation. Pair those rights with crisp paperwork about accommodation and PA hours when you plan a break together.</p></blockquote>

<h2>What is respite for carers?</h2>
<p>Respite is any planned relief from day-to-day caring: sitting services, residential cover for the person you support, or a holiday where someone else delivers hands-on care so you can sleep.</p>

<h2>Why breaks matter</h2>
<p>Long stretches without backup correlate with exhaustion, injury, and collapsed care arrangements. Pausing is injury prevention, not indulgence.</p>

<h2>Types of break to compare</h2>
<ul>
<li>Day care or sitting services at home.</li>
<li>Residential short stays for the person you support while you travel solo.</li>
<li>Supported trips where agency staff lead personal care.</li>
<li>Joint travel where your PA or direct payment covers care hours and you share the break.</li>
</ul>

<h2>Legal rights you should name in meetings</h2>
<p>The Care Act 2014 gives unpaid adults the right to a carer's assessment regardless of whether the council already funds the cared-for person. Assessments measure your wellbeing, sustainability, and emerging risks.</p>
<p>Parent carers can request a parent-carer needs assessment under the Children and Families Act 2014 when a disabled child is involved.</p>
<p>Kent routes assessments through KCC Adult Social Care; you may self-refer online or via the contact centre.</p>

<h2>How to request a carer's assessment in Kent</h2>
<p>Phone or complete KCC's online referral form. GP letters are optional extras, not prerequisites.</p>
<p>Bring diary notes about night waking, lifting, medication rounds, and employment impact. Specific beats stoic.</p>
<p>If the cared-for person already has a plan, ask whether it separately mentions short breaks so both documents align.</p>

<h2>Practical steps for travelling together</h2>
<p>Adapted properties must match clinical reality: hoist coverage, turning space, carer bedroom layout. Follow our <a href=\"{$checklist}\">self-catering checklist</a> before paying deposits.</p>
<p>Direct payments can fund PA hours during travel while accommodation stays a different invoice line; see <a href=\"{$dp}\">direct payments on holiday</a>.</p>

<h2>Funding routes at a glance</h2>
<h3>Carer's personal budget</h3>
<p>May cover wellbeing spends identified in your assessment; clarify eligible expenses with your worker.</p>
<h3>Cared-for person's direct payment</h3>
<p>Pays PA or agency time away from home when the plan allows; accommodation rent stays separate.</p>
<h3>Revitalise Support Fund</h3>
<p>Charity grants when affordability blocks any break. Apply via revitalise.org.uk.</p>
<h3>Carer charities</h3>
<p>Carers UK, Carers Trust, and Kent voluntary partners sometimes hold micro-grants. Ask locally.</p>
<h3>Self-funded accommodation</h3>
<p>Many families pay lodging privately while care hours route through statutory budgets.</p>

<h2>Common mistakes carers make</h2>
<ul>
<li>Waiting until crisis before requesting assessments.</li>
<li>Assuming \"accessible\" lettings need no follow-up questions.</li>
<li>Bringing unfamiliar agency staff on holiday without induction.</li>
<li>Ignoring recovery days after travel.</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>Can KCC refuse a carer's assessment?</h3>
<p>They must assess on request if you appear to have needs; push back politely with Care Act references if refused outright.</p>
<h3>Does respite money arrive instantly?</h3>
<p>No. Budgets follow assessments and panel decisions; plan months ahead.</p>
<h3>Can both co-parent carers ask for help?</h3>
<p>Yes. Each situation differs; disclose household dynamics honestly.</p>
<h3>Will a holiday cottage count as respite?</h3>
<p>Lodging rarely comes from the same budget line as PA wages; split invoices clearly.</p>
<h3>Where should I read local detail?</h3>
<p>Use our <a href=\"{$loc}\">Whitstable area guide</a> when Restwell sits on your shortlist.</p>

<h2>If Restwell suits your plan</h2>
<p>We host disabled guests and carers in Whitstable with adjoining carer sleeping space, hoist-track bedroom, profiling bed, and wet room that meets published measurements.</p>
<p>Share assessments early. We supply paperwork for funded stays when commissioners ask. Browse <a href=\"{$res}\">funding resources</a>, explore other articles on the <a href=\"{$blog}\">blog</a>, review <a href=\"{$who}\">guest fit</a>, then <a href=\"{$enq}\">message us</a>.</p>";
}

/**
 * Draft cluster article: packing for accessible self-catering (UK).
 *
 * @return string
 */
function restwell_get_blog_post_pack_accessible_self_catering_html() {
	$blog      = esc_url( home_url( '/blog/' ) );
	$checklist = esc_url( home_url( '/how-to-choose-accessible-self-catering-holiday/' ) );
	$beaches   = esc_url( home_url( '/accessible-beaches-coastal-walks-kent/' ) );
	$guide     = esc_url( home_url( '/guest-guide/' ) );
	$faq       = esc_url( home_url( '/faq/' ) );
	$enq       = esc_url( home_url( '/enquire/' ) );

	return "<blockquote><p><strong>TL;DR:</strong> Treat packing as part of your risk assessment: duplicate medication, spare sling parts, continence stock for closed shops, and written confirmations for anything the listing promises. If the hoist or mattress type is wrong when you arrive, bags cannot fix it. Verify specs before you pay.</p></blockquote>

<h2>What is an accessible packing plan?</h2>
<p>An accessible packing plan is a written list that matches your clinical routine to what a self-catering kitchen, bathroom, and bedroom actually contain.</p>

<h2>Why packing trips fail disabled travellers</h2>
<p>Coastal towns quiet down early evening and Sunday trading is thin. Running out of pads, feeds, or seizure rescue meds turns a holiday into an emergency round-trip to an unfamiliar pharmacy.</p>
<p>Self-catering assumed \"stocked like home\" is the usual failure mode. Owners rarely supply clinical quantities.</p>

<h2>Supplied by the property versus packed by you</h2>
<table>
<caption>Compare what owners typically include against what you should still bring</caption>
<thead><tr><th scope=\"col\">Item</th><th scope=\"col\">Often at adapted stays</th><th scope=\"col\">Usually yours to pack</th></tr></thead>
<tbody>
<tr><th scope=\"row\">Hoist &amp; bed</th><td>Track, motor, emergency lowering tools if advertised</td><td>Personal sling labelled with SWL, bedside cables, spare wipes</td></tr>
<tr><th scope=\"row\">Bathroom</th><td>Shower chair sometimes</td><td>Preferred slide sheets, stoma bags, catheter night drainage</td></tr>
<tr><th scope=\"row\">Kitchen</th><td>Standard pots and kettle</td><td>Thickened fluids, allergy-safe oils, adapted cutlery</td></tr>
<tr><th scope=\"row\">Power</th><td>UK sockets</td><td>Medical device chargers, extension rated for load, RCD awareness</td></tr>
</tbody>
</table>

<h2>How to tailor the list</h2>
<h3>Hoist and transfers</h3>
<p>Photograph your home sling tag before travel. Pack colour-coded loops if mixing identical-looking slings between carers.</p>
<h3>Medication and feeds</h3>
<p>Split scripts across two bags in case one goes missing. Carry liquid allowances letters if flying domestically with syringes.</p>
<h3>Continence and skin</h3>
<p>Add twenty percent buffer stock for beach days when changes spike.</p>
<h3>Communication and tech</h3>
<p>Download offline maps, save owner contacts, and screenshot door codes.</p>

<h2>Practical steps before you lock the door</h2>
<ol>
<li>Email the owner with yes-or-no questions echoing our <a href=\"{$checklist}\">self-catering checklist</a>.</li>
<li>Pack a paper copy of emergency numbers and insurer helplines.</li>
<li>Label bags \"medical supplies\" where airport security helps.</li>
<li>Photograph packed equipment so claims teams have evidence.</li>
</ol>

<h2>Common packing mistakes</h2>
<ul>
<li>Relying on supermarket delivery slots in peak season.</li>
<li>Assuming beach wheelchairs live at every gate without booking.</li>
<li>Shipping-only chargers that need tools you left at home.</li>
<li>Hiding mobility aids in the boot until day three.</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>Should I bring my own shower chair?</h3>
<p>If balance is marginal, yes. Molded seats feel different from rental PVC. Ask for seat height and rear wheels before you decide.</p>
<h3>How many spare sling loops?</h3>
<p>Two matched pairs per traveller using hoists covers laundry delays without panic buying.</p>
<h3>Can I bring a second fridge for meds?</h3>
<p>Ask first. Many cottages allow mini coolers in bedrooms if noise stays low.</p>
<h3>What paperwork helps carers?</h3>
<p>Care plans, MAR charts, and consent for emergency treatment speed unfamiliar GP calls.</p>
<h3>Where do I double-check house specifics?</h3>
<p>Read our <a href=\"{$guide}\">guest guide</a> once booked and skim site-wide <a href=\"{$faq}\">booking FAQs</a>.</p>

<h2>Closing</h2>
<p>Packing closes the gap between marketing photos and your real routine. Pair this list with Kent coastal planning in our <a href=\"{$beaches}\">accessible beaches guide</a>, browse more on the <a href=\"{$blog}\">blog</a>, then <a href=\"{$enq}\">tell us what you still need</a> if Whitstable is on your shortlist.</p>";
}

/**
 * Draft cluster article: accessible parking Whitstable / Tankerton.
 *
 * @return string
 */
function restwell_get_blog_post_accessible_parking_whitstable_html() {
	$blog   = esc_url( home_url( '/blog/' ) );
	$area   = esc_url( home_url( '/whitstable-area-guide/' ) );
	$beach  = esc_url( home_url( '/accessible-beaches-coastal-walks-kent/' ) );
	$enq    = esc_url( home_url( '/enquire/' ) );
	$access = esc_url( home_url( '/accessibility/' ) );

	return "<blockquote><p><strong>TL;DR:</strong> Whitstable rewards drivers who arrive early on sunny Saturdays: Blue Badge bays fill fast near the harbour, while Tankerton's slope-top streets need patience for kerb drops. Pair whatever bay you find with the shortest roll to the promenade you can manage, then adjust plans when tides and events squeeze pavements.</p></blockquote>

<h2>What is accessible parking in a small seaside town?</h2>
<p>Accessible parking here means a bay or drop-off point that keeps walking or rolling distance short on uneven pavements, not just a ticket with a wheelchair symbol.</p>

<h2>Why parking changes your day at the coast</h2>
<p>Harbour crowds, pop-up markets, and summer day-trippers shrink manoeuvring space. A \"nearby\" multi-storey can stay useless if lifts break or payment gates sit on cambers.</p>

<h2>How different zones behave</h2>
<h3>Tankerton slopes and promenade</h3>
<p>Residential roads climb away from the sea. Scout kerb height before you commit someone to a manual chair push.</p>
<h3>Whitstable town centre</h3>
<p>High street footfall peaks midday. Drop-off may beat hunting a perfect bay.</p>
<h3>Harbour and beaches</h3>
<p>Shingle starts quickly once you leave concrete. Read terrain notes in our <a href=\"{$beach}\">Kent beaches guide</a>.</p>

<h2>On-street rules versus car parks</h2>
<table>
<caption>Pick a strategy by what you need most</caption>
<thead><tr><th scope=\"col\">Need</th><th scope=\"col\">On-street Blue Badge</th><th scope=\"col\">Pay-and-display car parks</th></tr></thead>
<tbody>
<tr><th scope=\"row\">Shortest walk to food</th><td>Strong when bays exist near your venue</td><td>Often one flat block away</td></tr>
<tr><th scope=\"row\">Extra vehicle height</th><td>Varies by bay signage</td><td>Check entrance height barriers first</td></tr>
<tr><th scope=\"row\">Changing space beside vehicle</th><td>Kerb-side risk from passing traffic</td><td>End bays sometimes wider</td></tr>
<tr><th scope=\"row\">Predictable routes</th><td>Depends on daily residency</td><td>Easier to repeat once learned</td></tr>
</tbody>
</table>
<p>Council tariffs and zone maps change; verify hours and charges on official Kent or Whitstable pages the week you travel.</p>

<h2>Practical steps before you drive</h2>
<ul>
<li>Screen-capture three candidate bays and note walking distance to toilets.</li>
<li>Carry the Blue Badge timer disc even if pay-by-phone claims \"not needed\".</li>
<li>Plan a wet-weather alternative so you are not circling in rain.</li>
<li>Message hosts about private drives only when listings explicitly allow it.</li>
</ul>

<h2>Common mistakes</h2>
<ul>
<li>Trusting sat-nav \"closest\" without checking stepped alleys.</li>
<li>Ignoring event road closures posted late.</li>
<li>Blocking dropped kerbs while unloading.</li>
<li>Forgetting coastal wind when stabilising doors.</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>Do Blue Badge holders always park free?</h3>
<p>No. Many bays still need tickets or discs. Read the specific sign every time.</p>
<h3>Is the promenade level all the way?</h3>
<p>Mostly along maintained sections, but side streets vary. Scout once before sunset.</p>
<h3>Can I reserve a harbour bay?</h3>
<p>Public bays rarely reserve; private yards need written permission.</p>
<h3>Where should electric wheelchair users aim?</h3>
<p>Prioritise flat approach routes over saving five metres of distance.</p>
<h3>What if every bay is full?</h3>
<p>Shift your meal inland or retry after peak lunch; stubborn circling drains carers fast.</p>

<h2>Closing</h2>
<p>Parking is only half the trip: confirm property access dimensions on our <a href=\"{$access}\">accessibility page</a>, explore wider Kent context in the <a href=\"{$area}\">Whitstable area guide</a>, read related posts on the <a href=\"{$blog}\">blog</a>, and <a href=\"{$enq}\">ask us</a> about arrival logistics if you plan to stay.</p>";
}
/**
 * One-time: fix outbound links in the Revitalise blog post that return 403 to crawlers (Semrush / bot UAs).
 *
 * Replaces DisabledHolidays.com (Cloudflare challenge), accessable.co.uk (403), and tourismforall.org.uk (301 to trade)
 * with crawlable equivalents. Runs once per site; safe if the post was never seeded.
 */
function restwell_migrate_revitalise_post_external_links_v2() {
	if ( wp_installing() ) {
		return;
	}
	$flag = get_option( 'restwell_revitalise_ext_links_v2', '' );
	if ( $flag === '1' ) {
		return;
	}

	$posts = get_posts(
		array(
			'name'                   => 'revitalise-alternatives-accessible-holidays',
			'post_type'              => 'post',
			'post_status'            => 'any',
			'posts_per_page'         => 1,
			'fields'                 => 'ids',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
		)
	);
	if ( empty( $posts ) ) {
		update_option( 'restwell_revitalise_ext_links_v2', '1' );
		return;
	}

	$post_id = (int) $posts[0];
	$content = (string) get_post_field( 'post_content', $post_id );
	if ( $content === '' ) {
		update_option( 'restwell_revitalise_ext_links_v2', '1' );
		return;
	}

	$replacements = array(
		'<li><a href="https://www.disabledholidays.com" target="_blank" rel="noopener noreferrer">DisabledHolidays.com</a> - UK-wide listings filtered by specific access features</li>' => '<li><a href="https://www.euansguide.com" target="_blank" rel="noopener noreferrer">Euan\'s Guide</a> - crowdsourced disabled access reviews and listings for venues across the UK</li>',
		'<li><a href="https://www.tourismforall.org.uk" target="_blank" rel="noopener noreferrer">Tourism for All</a> - national charity with an accessible tourism information service</li>' => '<li><a href="https://www.tourismforall.co.uk/" target="_blank" rel="noopener noreferrer">Tourism for All</a> - national charity with an accessible tourism information service</li>',
		'<li><a href="https://www.accessable.co.uk" target="_blank" rel="noopener noreferrer">AccessAble</a> - detailed access guides for venues, accommodation, and attractions</li>' => '<li><a href="https://www.accessable.org/" target="_blank" rel="noopener noreferrer">AccessAble</a> - detailed access guides for venues, accommodation, and attractions</li>',
	);

	$updated = $content;
	foreach ( $replacements as $from => $to ) {
		$updated = str_replace( $from, $to, $updated );
	}

	// Fallback if editors changed whitespace or rel order but left legacy domains.
	if ( false !== strpos( $updated, 'disabledholidays.com' ) ) {
		$updated = str_replace( 'https://www.disabledholidays.com', 'https://www.euansguide.com', $updated );
		$updated = str_replace( 'DisabledHolidays.com', 'Euan&#8217;s Guide', $updated );
	}
	if ( false !== strpos( $updated, 'tourismforall.org.uk' ) ) {
		$updated = str_replace( 'https://www.tourismforall.org.uk', 'https://www.tourismforall.co.uk/', $updated );
	}
	if ( false !== strpos( $updated, 'accessable.co.uk' ) ) {
		$updated = str_replace( 'https://www.accessable.co.uk', 'https://www.accessable.org/', $updated );
	}

	if ( $updated !== $content ) {
		wp_update_post(
			array(
				'ID'           => $post_id,
				'post_content' => $updated,
			)
		);
	}

	update_option( 'restwell_revitalise_ext_links_v2', '1' );
}
add_action( 'init', 'restwell_migrate_revitalise_post_external_links_v2', 35 );
