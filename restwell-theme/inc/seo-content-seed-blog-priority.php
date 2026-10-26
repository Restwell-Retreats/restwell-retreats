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
			'meta_description' => 'Which accessible beaches in Kent work with a wheelchair? See the level promenades, where shingle stops you, and where to borrow a beach wheelchair in Thanet.',
			'content'          => restwell_get_blog_post_beaches_kent_html(),
			'category_slug'    => 'kent-coast',
		),
		array(
			'slug'             => 'direct-payment-holiday-accommodation',
			'title'            => 'Can I use direct payments for a holiday?',
			'excerpt'          => 'This guide explains what a direct payment can pay for on a break, who decides, and what to ask first.',
			'meta_title'       => 'Can I use direct payments for a holiday? A UK guide',
			'meta_description' => 'Can you use direct payments for a holiday? They rarely cover the stay itself, but they can often pay for your care while you’re away. Here’s what to ask.',
			'content'          => restwell_get_blog_post_direct_payments_html(),
			'category_slug'    => 'funding-care',
		),
		array(
			'slug'             => 'revitalise-alternatives-accessible-holidays',
			'title'            => 'What happened to Revitalise holidays, and where to go now',
			'excerpt'          => 'Here’s where to find a break with care now that the Revitalise centres have closed.',
			'meta_title'       => 'Revitalise holidays: what happened, and where to go now',
			'meta_description' => 'Revitalise holidays ended when its centres closed in November 2024, and it now gives respite grants. Here’s where to find a break with care now.',
			'content'          => restwell_get_blog_post_revitalise_html(),
			'category_slug'    => 'news-updates',
		),
		array(
			'slug'             => 'how-to-choose-accessible-self-catering-holiday',
			'title'            => 'How to choose an accessible holiday cottage: a checklist before you pay',
			'excerpt'          => 'The word “accessible” can mean almost anything on a listing. This checklist covers what to ask before you pay, from door widths and hoists to care and cancellation terms.',
			'meta_title'       => 'How to choose an accessible holiday cottage: a checklist',
			'meta_description' => 'Here’s how to choose an accessible holiday cottage. Check the equipment, beds, parking, nearby care and cancellation terms before you pay.',
			'content'          => restwell_get_blog_post_self_catering_checklist_html(),
			'category_slug'    => 'accessible-holidays',
		),
		array(
			'slug'             => 'carers-respite-holiday-guide',
			'title'            => 'Respite for carers: how to get a break from caring',
			'excerpt'          => 'How to get a break from caring, from asking for a carer’s assessment to who pays. It also covers Carer’s Allowance and taking a holiday together.',
			'meta_title'       => 'Respite for carers: how to get a break from caring',
			'meta_description' => 'Respite for carers means someone else helps while you take a break. Here’s how to ask your council, what a carer’s assessment covers and who pays.',
			'content'          => restwell_get_blog_post_carers_respite_html(),
			'category_slug'    => 'funding-care',
		),
		array(
			'slug'             => 'what-to-pack-accessible-self-catering-uk',
			'title'            => 'A self-catering packing list for an accessible UK holiday',
			'excerpt'          => 'What to pack for a self-catering holiday in the UK. It also covers the extras that help if you have access or care needs.',
			'meta_title'       => 'A self-catering packing list for an accessible UK holiday',
			'meta_description' => 'A self-catering packing list for a UK holiday, with the extras for access needs: medicines, your sling, chargers and supplies, plus what Restwell provides.',
			'content'          => restwell_get_blog_post_pack_accessible_self_catering_html(),
			'category_slug'    => 'accessible-holidays',
		),
		array(
			'slug'             => 'accessible-parking-whitstable-tankerton',
			'title'            => 'Blue Badge parking in Whitstable and Tankerton',
			'excerpt'          => 'Where you can park with a Blue Badge in Whitstable, and which car parks need your badge registered first. It also covers parking for Tankerton seafront.',
			'meta_title'       => 'Blue Badge parking in Whitstable and Tankerton',
			'meta_description' => 'Blue Badge parking in Whitstable: three free hours in council car parks, which ones need your badge registered first, and where to park for Tankerton.',
			'content'          => restwell_get_blog_post_accessible_parking_whitstable_html(),
			'category_slug'    => 'kent-coast',
		),
		array(
			'slug'             => 'chc-respite-holiday-accommodation-uk',
			'title'            => 'CHC respite care: what NHS Continuing Healthcare pays for on a break',
			'excerpt'          => 'How NHS Continuing Healthcare covers a break for your family carer, and how a personal health budget can help. It also lists the holiday costs you still pay yourself.',
			'meta_title'       => 'CHC respite care: what the NHS pays for on a break',
			'meta_description' => 'CHC respite care explained: what NHS Continuing Healthcare pays for while your carer has a break, what it won’t cover on holiday, and what to ask.',
			'content'          => restwell_get_blog_post_chc_respite_holiday_accommodation_html(),
			'category_slug'    => 'funding-care',
		),
		array(
			'slug'             => 'hire-mobility-scooter-equipment-uk-holiday',
			'title'            => 'Mobility scooter and wheelchair hire in Whitstable',
			'excerpt'          => 'Where to hire a mobility scooter or wheelchair in Whitstable, and what it costs. It also covers the rules for using a scooter on pavements and roads.',
			'meta_title'       => 'Mobility scooter and wheelchair hire in Whitstable',
			'meta_description' => 'Mobility scooter hire in Whitstable: where to hire a scooter or wheelchair, what it costs, the rules for scooters, and what’s already at Restwell.',
			'content'          => restwell_get_blog_post_hire_mobility_equipment_uk_html(),
			'category_slug'    => 'accessible-holidays',
		),
		array(
			'slug'             => 'accessible-train-travel-whitstable-kent',
			'title'            => 'Is Whitstable station step-free? Accessible trains to Whitstable',
			'excerpt'          => 'Which entrance to use for each platform at Whitstable, and how to book help. It also covers taking a wheelchair or scooter on the train.',
			'meta_title'       => 'Is Whitstable station step-free? Trains to Whitstable',
			'meta_description' => 'Is Whitstable station step-free? Yes, by two entrances. Here’s which to use, how to book Passenger Assist, and taking a wheelchair or scooter on the train.',
			'content'          => restwell_get_blog_post_accessible_train_whitstable_kent_html(),
			'category_slug'    => 'kent-coast',
		),
		array(
			'slug'             => 'travel-insurance-disability-uk-self-catering',
			'title'            => 'Travel insurance for a UK holiday if you’re disabled',
			'excerpt'          => 'Why cover is worth having for a holiday in the UK, and what to tell the insurer. It also covers your wheelchair, and what to do if you’re turned down.',
			'meta_title'       => 'Travel insurance for a UK holiday if you’re disabled',
			'meta_description' => 'Travel insurance for a UK holiday if you’re disabled: why it’s worth having, what to tell the insurer, wheelchair cover and what to do if refused.',
			'content'          => restwell_get_blog_post_travel_insurance_disability_uk_html(),
			'category_slug'    => 'accessible-holidays',
		),
		array(
			'slug'             => 'personal-budget-short-break-care-act',
			'title'            => 'Respite under the Care Act 2014: what your council must do',
			'excerpt'          => 'What the Care Act 2014 says about breaks from caring. It covers assessments, eligible needs, personal budgets, who pays and how to challenge a decision.',
			'meta_title'       => 'Respite under the Care Act 2014: what your council must do',
			'meta_description' => 'Care Act 2014 respite explained: your right to an assessment, how councils arrange a break, who pays for it, and what to do if the council says no.',
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
			'title'            => 'When is the best time to visit Whitstable?',
			'excerpt'          => 'How Whitstable changes through the year, and which dates get busy. It also covers when the town is calmer for a slower pace.',
			'meta_title'       => 'The best time to visit Whitstable, season by season',
			'meta_description' => 'The best time to visit Whitstable depends on what you want: quieter streets, warm weather or oysters. Here’s each season, the busy dates and calmer times.',
			'content'          => restwell_get_blog_post_quieter_whitstable_visit_html(),
			'category_slug'    => 'kent-coast',
		),
		array(
			'slug'             => 'how-to-read-holiday-cottage-access-statement',
			'title'            => 'Will my wheelchair fit? Door widths and how to read an access statement',
			'excerpt'          => 'Here’s how to check a cottage’s doors, beds and hoists against your own chair. It also covers what to ask when details are missing.',
			'meta_title'       => 'Will my wheelchair fit? Door widths and access statements',
			'meta_description' => 'Will your wheelchair fit? Door widths, turning space, hoist clearance and bed heights explained, plus what to ask when an access statement leaves gaps.',
			'content'          => restwell_get_blog_post_read_access_statement_html(),
			'category_slug'    => 'accessible-holidays',
		),
		array(
			'slug'             => 'fatigue-friendly-whitstable-coastal-day',
			'title'            => 'Wheelchair accessible days out in Kent, from Whitstable',
			'excerpt'          => 'Six days out within reach of Whitstable, with what’s step-free and where to borrow a wheelchair. It also lists free carer tickets and Changing Places toilets.',
			'meta_title'       => 'Wheelchair accessible days out in Kent, from Whitstable',
			'meta_description' => 'Wheelchair accessible days out in Kent near Whitstable: what’s step-free, where to borrow a wheelchair, free carer tickets and Changing Places toilets.',
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
 * Respite for carers (Batch D, 26 Oct 2026): the carer's assessment, kinds of
 * break, who pays, Carer's Allowance and taking a holiday together.
 *
 * @return string
 */
function restwell_get_blog_post_carers_respite_html() {
	$funding   = esc_url( home_url( '/funding-and-support/' ) );
	$dp        = esc_url( home_url( '/direct-payment-holiday-accommodation/' ) );
	$checklist = esc_url( home_url( '/how-to-choose-accessible-self-catering-holiday/' ) );
	$care      = esc_url( home_url( '/optional-care/' ) );
	$enquire   = esc_url( home_url( '/enquire/' ) );
	$careact   = esc_url( home_url( '/personal-budget-short-break-care-act/' ) );

	return "<blockquote><p><strong>TL;DR:</strong> Respite means someone else looks after the person you care for while you take a break. It starts with a free carer's assessment from the council where they live. If you have eligible needs, the council must help.</p></blockquote>

<h2>What is respite for carers?</h2>
<p>Respite for carers is a break from caring, while someone else looks after the person you care for. It might be a few hours, a regular night off or a week away. The help can come to the house, or happen somewhere else.</p>
<p>Some carers use the time to sleep, see friends or keep up with work. Others use it for a holiday. A break is a normal part of caring, so you don't need to wait for a crisis to ask.</p>

<h2>What kinds of break are there?</h2>
<p>There are more choices than most people expect. Here are the main ones, and you can mix them.</p>
<ul>
<li><strong>Care at home:</strong> a paid carer comes in for a few hours, or for a whole week while you're away.</li>
<li><strong>A day centre:</strong> the person you care for spends the day with other people. Many offer transport, but there may be a charge.</li>
<li><strong>A sitting service:</strong> a trained volunteer keeps them company for a few hours, often for free or a small charge.</li>
<li><strong>A short stay away:</strong> some care homes take short stays, and some let you book ahead.</li>
<li><strong>Family and friends:</strong> someone moves in for a while, or the person you care for goes to stay with them.</li>
<li><strong>A holiday:</strong> you go away while someone else cares, or you go together and book care where you're staying.</li>
</ul>
<p>Grants can help with some of the cost. See our guide to <a href=\"{$funding}\">grants and other ways to pay for a break</a>.</p>

<h2>Are carers entitled to respite?</h2>
<p>You're entitled to a carer's assessment, and that's where respite starts. Under the Care Act 2014, the council must assess any carer who appears to need support. That's true however much care you give, and whatever money you have.</p>
<p>If the assessment finds eligible needs, the council must help meet them.</p>
<p>There's no set number of respite days or weeks in law. What you get depends on your assessment and the support plan you agree. One family might need a week away each year, while another needs a regular night off.</p>
<p>Our guide to <a href=\"{$careact}\">respite under the Care Act 2014</a> explains the rules in more detail.</p>

<h2>How do you ask for a carer's assessment?</h2>
<p>Contact adult social care at the council where the person you care for lives. You can usually ask online or by phone. You don't need their permission, and they don't need to be getting help from the council already.</p>
<p>In Kent, call Kent County Council on 03000 41 61 61, or use its online form. A local carers' organisation can also help you ask. Elsewhere, search for your council's name and \"carer's assessment\" to find the right page.</p>
<p>The assessment is a conversation about you, not a test. Most councils do it face to face, though some do it by phone. It looks at your health, your work, your free time and your relationships, and you can bring someone with you.</p>

<h2>What should you say in a carer's assessment?</h2>
<p>Describe a normal week in detail, because the details are what the council acts on. Say what you help with, how often you're up in the night, and what you've had to give up. If you'd like a break, say what kind and how often.</p>
<ul>
<li>What you do each day and each night, with rough times.</li>
<li>Anything you find hard, such as lifting or broken sleep.</li>
<li>How caring affects your work, your health and the rest of your family.</li>
<li>The kind of break you'd like, and how often.</li>
<li>What happens now if you're ill or have to be away.</li>
</ul>

<h2>Who pays for respite?</h2>
<p>The carer's assessment is free. If the council arranges care to give you a break, the person you care for is the one receiving it. So if there's a charge, they pay it, not you.</p>
<p>Any charge depends on a check of their finances, and some councils don't charge for it at all.</p>
<p>The council can also help you directly, for example with a direct payment for things that make caring easier. Councils don't have to charge carers for this, and the official guidance advises against it in most cases.</p>
<p>If you pay for a break yourself, charities can help. Carers Trust and Turn2us both list grants for carers. Some charities pay for a cover carer, rather than the trip itself.</p>

<h2>Will a break affect your Carer's Allowance?</h2>
<p>A short break won't usually affect your Carer's Allowance. You only need to tell the DWP if you stop caring for more than 28 days. The limit is 12 weeks if either of you is in hospital, a nursing home or respite care.</p>
<p>Having a carer's assessment won't change your Carer's Allowance either. The rules can change, so check the latest guidance on GOV.UK before a long break.</p>

<h2>Can you take a holiday together?</h2>
<p>Yes, and for many families that's the break they want most. Someone else does some of the hands-on help, so you can rest without being apart. It can work with your own PA, an agency where you're staying or care booked with the holiday.</p>
<p>If the person you care for has a direct payment, it can often pay for their care while they're away. The council decides, so ask before you book. Our guide on <a href=\"{$dp}\">using direct payments for a holiday</a> explains what to ask.</p>
<p>Check the holiday home as carefully as the care. Ask for the door widths, the bed heights, the hoist's details and where a carer will sleep. Our <a href=\"{$checklist}\">checklist for choosing an accessible holiday cottage</a> covers what to ask before you pay.</p>

<h2>What if you care for a child?</h2>
<p>If you look after a disabled child, ask your council's children's services for a parent carer needs assessment. Councils must also offer short breaks for disabled children, and publish what's on offer in their area.</p>
<p>Family Fund gives grants towards holidays for families on lower incomes who are raising a disabled or seriously ill child.</p>

<h2>Practical steps before you book</h2>
<ul>
<li>Ask for a carer's assessment, even if you're not sure you'll qualify.</li>
<li>Ask whether the person you care for should have a new needs assessment too.</li>
<li>Get your support plan in writing, including any breaks it agrees.</li>
<li>If a direct payment will pay for care while you're away, get the council's answer in writing.</li>
<li>Book the care and the holiday home at the same time, so the dates match.</li>
</ul>

<h2>Common mistakes to avoid</h2>
<ul>
<li>Waiting until something goes wrong before you ask for help.</li>
<li>Asking the wrong council, when it should be the one where the person you care for lives.</li>
<li>Paying for a holiday before the council has agreed to fund the care.</li>
<li>Assuming last year's support plan still covers this year's break.</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>Can carers get free respite care?</h3>
<p>Sometimes, yes. A sitting service from a charity may be free, and some councils don't charge for short breaks. Otherwise, the person you care for may pay towards the care after a check of their finances.</p>
<h3>How much respite can a carer get?</h3>
<p>There's no fixed amount. It depends on your assessment and the support plan you agree. Ask for the break that would help you most, and explain why you need it.</p>
<h3>Does the person I care for have to agree?</h3>
<p>Not to your own assessment, because you can ask for that in your own right. If the council arranges care for them so that you can have a break, though, they should agree to it.</p>
<h3>What if the council says no?</h3>
<p>Ask for the decision and the reasons in writing. You can complain to the council first. If you're still unhappy, you can take it to the Local Government and Social Care Ombudsman, which is free.</p>
<h3>Can I get respite if I work?</h3>
<p>Yes. A carer's assessment must look at whether you want to work, and how caring affects that. A regular break or extra help at home can make it easier to keep your job.</p>

<h2>How carers use Restwell</h2>
<p>Restwell is a private, single-storey holiday bungalow in Whitstable. It has a ceiling track hoist, two profiling beds and a level wet room. Some families bring their own PA, who can have the second double bedroom or the sofa bed.</p>
<p>Others ask our sister company, Continuity of Care Services, to come in while they're here. That way, the family carer gets time off without anyone going home.</p>
<p>Continuity is rated Good by the Care Quality Commission, and it gives you a quote once the hours are agreed. Read more about <a href=\"{$care}\">care from our sister company during your stay</a>.</p>

<h2>Closing</h2>
<p>If your council or a charity needs a written quote for the stay, we can send one. <a href=\"{$enquire}\">Tell us your dates and who's coming</a>, and we'll help with the paperwork.</p>";
}

/**
 * A self-catering packing list for an accessible UK holiday (Batch F, 26 Oct
 * 2026). Lists what Restwell provides; keep it in step with the equipment list.
 *
 * @return string
 */
function restwell_get_blog_post_pack_accessible_self_catering_html() {
	$enquire = esc_url( home_url( '/enquire/' ) );
	$hire    = esc_url( home_url( '/hire-mobility-scooter-equipment-uk-holiday/' ) );
	$access  = esc_url( home_url( '/accessibility/' ) );

	return "<blockquote><p><strong>TL;DR:</strong> Check what the holiday home provides before you pack, as it varies a lot. Then bring what only you have, such as medicines, your hoist sling, chargers and continence supplies. At Restwell, linen, towels and the access equipment are all included.</p></blockquote>

<h2>What should you check before you pack?</h2>
<p>Ask the holiday home what's included, and get the answer in writing. Linen, towels, cooking basics and WiFi all vary between lets. So do starter supplies, such as toilet roll and washing-up liquid.</p>
<p>At Restwell, linen, towels and WiFi are included, along with all the access equipment. The kitchen has plates, pans, cutlery and the cooking basics. Our <a href=\"{$access}\">list of the equipment at the bungalow</a> gives the makes and weight limits.</p>

<h2>What to pack for a self-catering holiday in the UK</h2>
<p>These are the basics for most self-catering stays in the UK. Strike off anything your holiday home already provides.</p>
<ul>
<li>Clothes for wind and rain, even in summer, as the coast can be breezy.</li>
<li>Toiletries and a small first aid kit.</li>
<li>Food for your first evening and breakfast, in case the shops are shut when you arrive.</li>
<li>Phone chargers, and an extension lead if you have a lot to charge.</li>
<li>A blanket or windbreak for the beach, and a flask for days out.</li>
<li>A bank card or app for parking, as many car parks no longer take cash.</li>
</ul>

<h2>Extras to pack if you have access or care needs</h2>
<ul>
<li><strong>Medicines:</strong> enough for the stay plus a few spare days, in their boxes, with a list of what you take.</li>
<li><strong>Your hoist sling:</strong> a sling has to fit the person using it, so holiday homes can't safely supply one.</li>
<li><strong>Continence and skin care supplies:</strong> pack a few days' extra, in case your plans change.</li>
<li><strong>Feeding supplies:</strong> bring enough for the stay if you use them, plus spares.</li>
<li><strong>Chargers:</strong> for your powerchair, scooter, phone and any medical devices, with labels.</li>
<li><strong>Your own cushion:</strong> a pressure cushion or pillow you rely on at home.</li>
<li><strong>Your routine on paper:</strong> a short note of your care routine helps anyone stepping in.</li>
<li><strong>Your Blue Badge and clock:</strong> and your railcard if you're coming by train.</li>
</ul>

<h2>What you don't need to bring to Restwell</h2>
<p>You don't need to bring bedding, towels or access equipment. The bungalow has two profiling beds, a ceiling track hoist, a mobile hoist and a standing aid. It also has a tilt-in-space shower chair, a shower stool, a wash-dry toilet and a height-adjustable basin.</p>
<p>Fold-up ramps are kept by the front door, for the house and for days out. There's also a washing machine, a tumble dryer and a dishwasher.</p>
<p>Both hoists take loop-style slings on a two-point spreader bar, so please bring the sling you already use.</p>

<h2>What if you forget something?</h2>
<p>Whitstable has pharmacies in the town centre that open seven days a week, and big supermarkets a short drive away. If you've left a prescription medicine at home, NHS 111 can ask a local pharmacy for an emergency supply. Use 111 online or call 111.</p>
<p>If your chair or scooter breaks, see our guide to <a href=\"{$hire}\">mobility scooter and wheelchair hire in Whitstable</a>.</p>

<h2>Common mistakes to avoid</h2>
<ul>
<li>Packing your medicines in a case you can't reach on the way.</li>
<li>Forgetting the sling, because the hoist is already at the holiday home.</li>
<li>Leaving a charger plugged in at home.</li>
<li>Arriving late with nothing in for breakfast.</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>What do you need to bring to a self-catering holiday?</h3>
<p>Usually your food, toiletries and anything personal. Check whether linen, towels and cleaning basics are included, as they vary between holiday homes.</p>
<h3>Do I need to bring bedding and towels to Restwell?</h3>
<p>No, linen and towels are included in the price. So is all the access equipment.</p>
<h3>Can I bring my own equipment?</h3>
<p>Yes. If you'd like to bring a bed, chair or other equipment, tell us first, and we'll check it fits. The front door is 965mm wide and the doors inside are 926mm.</p>
<h3>Should I bring my own sling?</h3>
<p>Yes, please. A sling needs to fit the person using it, so we can't safely supply one.</p>

<h2>Packing for a stay at Restwell</h2>
<p>Restwell is a private, adapted bungalow in Whitstable. Most of what you need for access is already there, so you can pack lighter than you might expect.</p>

<h2>Closing</h2>
<p>If you're not sure whether to bring something, <a href=\"{$enquire}\">ask us what's at the bungalow</a>, and we'll let you know.</p>";
}

/**
 * Blue Badge parking in Whitstable (Batch E, 26 Oct 2026): council car parks,
 * the camera car parks that need a badge registered, street rules and Tankerton.
 *
 * @return string
 */
function restwell_get_blog_post_accessible_parking_whitstable_html() {
	$area    = esc_url( home_url( '/whitstable-area-guide/' ) );
	$train   = esc_url( home_url( '/accessible-train-travel-whitstable-kent/' ) );
	$enquire = esc_url( home_url( '/enquire/' ) );

	return "<blockquote><p><strong>TL;DR:</strong> In Whitstable's council car parks, a Blue Badge gives you three free hours. Gorrell Tank and Middle Wall use number-plate cameras, so register your badge online before your first visit. On the street, the national Blue Badge rules apply.</p></blockquote>

<h2>Is Blue Badge parking free in Whitstable?</h2>
<p>Often, yes, for up to three hours. Canterbury City Council runs the car parks in Whitstable. Blue Badge holders park free for up to three hours in most spaces, though not in permit bays.</p>
<p>After three hours, you pay the normal charge. Put your badge on the dashboard, and set your blue clock to the time you arrived. Some car parks have a shorter limit, such as two hours at the harbour, so read the sign.</p>
<p>Our guide to <a href=\"{$area}\">the level routes around Whitstable</a> covers where to go once you've parked.</p>

<h2>Which car parks need your badge registered first?</h2>
<p>Gorrell Tank and Middle Wall, near the harbour and the town centre, use number-plate cameras instead of tickets. To get your three free hours there, register your badge in a council parking account before your first visit.</p>
<p>You can register up to two vehicles against one badge. Each time you park, check that the car you're using is set as the main vehicle in your account. You still need to show the badge on the dashboard.</p>

<h2>Where can you park on the street with a Blue Badge?</h2>
<p>On the street, the national Blue Badge rules for England apply. At parking meters and pay-and-display bays, you park free for as long as you need, unless a sign says otherwise. Disabled bays are free too, though some have a time limit on the sign.</p>
<p>You can park on single or double yellow lines for up to three hours, with your clock set. You can't park there if there's a loading ban, shown by yellow dashes on the kerb or a sign.</p>
<p>After parking on yellow lines, wait at least an hour before parking in the same road again that day.</p>
<p>A Blue Badge never lets you park on a crossing, such as a zebra crossing. Nor can you park by double white lines in the middle of the road.</p>

<h2>Where should you park for Tankerton seafront?</h2>
<p>There's free parking along Marine Parade, at the top of Tankerton Slopes. The grassy slopes down to the promenade are steep, so use the paved paths to get down. The promenade itself is long, level and surfaced.</p>
<p>The seafront is at its busiest on sunny weekends and in the school holidays. If you need a space close to a path down, it helps to arrive in the morning.</p>

<h2>Can you park free at Whitstable station?</h2>
<p>Southeastern lets Blue Badge holders park free in its station car parks. It's free all day if you're catching a train, and for up to three hours otherwise. Whitstable's car park has 43 spaces, and 9 are accessible.</p>
<p>Our guide to <a href=\"{$train}\">step-free train travel to Whitstable</a> covers the platforms and booking help.</p>

<h2>What about supermarkets and private car parks?</h2>
<p>Private car parks set their own rules for Blue Badge holders. Many have disabled bays near the entrance, but parking isn't always free. The owner's signs tell you what applies, so don't assume the council's three free hours carry over.</p>

<h2>Practical steps before you drive</h2>
<ul>
<li>Set up a council parking account and register your badge before you use Gorrell Tank or Middle Wall.</li>
<li>Pack your blue parking clock as well as your badge.</li>
<li>Check the maximum stay on the sign, as it varies between car parks.</li>
<li>Plan to arrive early on sunny weekends if you want a space near the seafront.</li>
<li>Keep the badge out of sight when the badge holder isn't with you.</li>
</ul>

<h2>Common mistakes to avoid</h2>
<ul>
<li>Driving into a camera car park before your badge is registered.</li>
<li>Forgetting to set the clock on yellow lines or in a timed bay.</li>
<li>Assuming every car park gives three free hours, including private ones.</li>
<li>Parking on yellow lines where the kerb shows a loading ban.</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>Can I use my Blue Badge in Kent if it was issued elsewhere?</h3>
<p>Yes. A Blue Badge from another UK council works in Whitstable too. To use the camera car parks, register it in a Canterbury City Council parking account first.</p>
<h3>Can someone else use my badge?</h3>
<p>Only when you're travelling in the car, or they're dropping you off or picking you up. It can't be used for anyone else's errands.</p>
<h3>Can a carer register the badge for me?</h3>
<p>Yes. The council's camera car parks let you register up to two vehicles against one badge. That way, it works whether you drive or a carer drives you.</p>
<h3>How do I apply for a Blue Badge in Kent?</h3>
<p>If you live in Kent, you apply to Kent County Council. If you live somewhere else, apply to your own council.</p>
<h3>Is there parking at Restwell?</h3>
<p>Yes. The bungalow has a private, level drive with room for two cars, including an adapted vehicle. You can also park on the street outside if you need extra room.</p>

<h2>Parking at Restwell</h2>
<p>Restwell is a private, adapted bungalow in Whitstable. The resin-bound drive is level, so you can get in and out of the car right by the front door. That means you only need the car parks for days out, not for coming home.</p>

<h2>Closing</h2>
<p>If you're planning a stay, <a href=\"{$enquire}\">ask us about parking and arriving</a>, and we'll help with the details.</p>";
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
