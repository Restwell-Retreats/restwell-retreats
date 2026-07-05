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

	$articles = array(
		array(
			'slug'             => 'accessible-beaches-coastal-walks-kent',
			'title'            => 'A guide to accessible beaches and coastal walks in Kent',
			'excerpt'          => 'Level promenades, shingle realities, and where to plan a seaside day if you use a wheelchair or mobility equipment - covering Whitstable, Herne Bay, Broadstairs, and Margate.',
			'meta_title'       => 'Accessible Beaches Kent | Coast Walks | ' . $site_name,
			'meta_description' => 'Accessible beaches Kent: level promenades, Beach Within Reach, Herne Bay, Viking Bay, Margate. Plan a seaside day with realistic access notes.',
			'content'          => restwell_get_blog_post_beaches_kent_html(),
			'category_slug'    => 'kent-coast',
		),
		array(
			'slug'             => 'direct-payment-holiday-accommodation',
			'title'            => 'How to use your direct payment for a holiday',
			'excerpt'          => 'Direct payments fund care, not accommodation - but that distinction matters. A plain-English guide to what direct payments can cover, how personal health budgets work, and what to discuss with your social worker before booking.',
			'meta_title'       => 'Direct Payment for Holiday | Funding | ' . $site_name,
			'meta_description' => 'Direct payment for holiday stays: what counts as care vs accommodation, personal budgets, short breaks, and questions for your social worker.',
			'content'          => restwell_get_blog_post_direct_payments_html(),
			'category_slug'    => 'funding-care',
		),
		array(
			'slug'             => 'revitalise-alternatives-accessible-holidays',
			'title'            => 'What happened to Revitalise - and where to find accessible holidays now',
			'excerpt'          => "Revitalise closed its holiday centres in November 2024 after 60 years. Here's what happened, what Revitalise now offers, and where to find accessible holidays in the UK.",
			'meta_title'       => 'Revitalise Centres Closed | What Next | ' . $site_name,
			'meta_description' => 'Revitalise closed its holiday centres in 2024: why, what the charity funds now, and where to find accessible UK holidays and respite alternatives.',
			'content'          => restwell_get_blog_post_revitalise_html(),
			'category_slug'    => 'news-updates',
		),
		array(
			'slug'             => 'how-to-choose-accessible-self-catering-holiday',
			'title'            => 'How to choose an accessible self-catering holiday property',
			'excerpt'          => 'The word "accessible" on a property listing can mean almost anything. A practical checklist covering what to ask before booking - from door widths and hoist specifications to what red flags look like in listings.',
			'meta_title'       => 'Accessible Self-Catering Holiday Guide | ' . $site_name,
			'meta_description' => 'Choose an accessible self-catering holiday: verify hoist specs, door widths, wet rooms, and red flags in listings before you pay a deposit.',
			'content'          => restwell_get_blog_post_self_catering_checklist_html(),
			'category_slug'    => 'accessible-holidays',
		),
		array(
			'slug'             => 'carers-respite-holiday-guide',
			'title'            => "Carers taking holidays: respite rights, funding, and how to plan a break that works",
			'excerpt'          => "A practical guide for unpaid carers: what you're entitled to under the Care Act, how to get a carer's assessment in Kent, the funding routes available, and what makes a supported break actually restful.",
			'meta_title'       => 'Carer Assessment & Respite Rights Guide | ' . $site_name,
			'meta_description' => 'Guide to carer assessments and respite rights for unpaid carers: legal routes, funding pathways, and planning steps for short breaks.',
			'content'          => restwell_get_blog_post_carers_respite_html(),
			'category_slug'    => 'funding-care',
		),
		array(
			'slug'             => 'what-to-pack-accessible-self-catering-uk',
			'title'            => 'What to pack for an accessible self-catering break in the UK',
			'excerpt'          => 'A room-by-room packing list for hoist users, continence care, medication routines, and kitchen access — plus what to verify with the owner before you zip the case.',
			'meta_title'       => 'Accessible Holiday Packing List UK | Self-Catering | ' . $site_name,
			'meta_description' => 'What to pack for an accessible self-catering UK break: meds, continence, hoist extras, kitchen aids, and what to confirm with the owner before you travel.',
			'content'          => restwell_get_blog_post_pack_accessible_self_catering_html(),
			'category_slug'    => 'accessible-holidays',
		),
		array(
			'slug'             => 'accessible-parking-whitstable-tankerton',
			'title'            => 'Accessible parking and drop-off around Whitstable and Tankerton',
			'excerpt'          => 'Blue Badge basics, where seaside crowds pinch space, and how to pair parking with level promenade walks — without pretending every bay is always empty.',
			'meta_title'       => 'Accessible Parking Whitstable | Tankerton | ' . $site_name,
			'meta_description' => 'Accessible parking and drop-off near Whitstable and Tankerton: Blue Badge basics, promenade access, timing tides and crowds, and links to Kent guides.',
			'content'          => restwell_get_blog_post_accessible_parking_whitstable_html(),
			'category_slug'    => 'kent-coast',
		),
		array(
			'slug'             => 'chc-respite-holiday-accommodation-uk',
			'title'            => 'CHC, respite, and holiday accommodation: plain English for families and commissioners',
			'excerpt'          => 'What NHS Continuing Healthcare can and cannot pay for on a break, how to split care invoices from cottage rent, and the paperwork panels expect before they sign off.',
			'meta_title'       => 'CHC Respite Holiday Accommodation UK | ' . $site_name,
			'meta_description' => 'CHC respite holiday accommodation explained: NHS continuing healthcare versus lodging costs, paperwork panels expect, and funding lines for supported breaks.',
			'content'          => restwell_get_blog_post_chc_respite_holiday_accommodation_html(),
			'category_slug'    => 'funding-care',
		),
		array(
			'slug'             => 'hire-mobility-scooter-equipment-uk-holiday',
			'title'            => 'Hiring mobility equipment for a UK self-catering holiday',
			'excerpt'          => 'Scooters, profiling beds, and shower chairs: how to match hire stock to door widths, insurance small-print, delivery slots, and handover photos before you sign.',
			'meta_title'       => 'Hire Mobility Equipment UK Holiday | Self-Catering | ' . $site_name,
			'meta_description' => 'Hire mobility scooters, shower chairs, and beds for a UK self-catering holiday: measurements, insurance, delivery slots, and what to photograph on handover.',
			'content'          => restwell_get_blog_post_hire_mobility_equipment_uk_html(),
			'category_slug'    => 'accessible-holidays',
		),
		array(
			'slug'             => 'accessible-train-travel-whitstable-kent',
			'title'            => 'Accessible train travel to Whitstable and around Kent',
			'excerpt'          => 'Passenger Assist, platform gaps, onward taxis, and why seaside rail hops still need backup plans when buses replace trains.',
			'meta_title'       => 'Accessible Train Travel Whitstable Kent | ' . $site_name,
			'meta_description' => 'Accessible train travel to Whitstable and around Kent: Passenger Assist, platform gaps, connections, and pairing rail with local parking or taxi backup.',
			'content'          => restwell_get_blog_post_accessible_train_whitstable_kent_html(),
			'category_slug'    => 'kent-coast',
		),
		array(
			'slug'             => 'travel-insurance-disability-uk-self-catering',
			'title'            => 'Travel insurance, disability, and UK self-catering breaks',
			'excerpt'          => 'Equipment limits, pre-existing conditions, cancellation clauses, and broker questions — practical guidance, not legal advice.',
			'meta_title'       => 'Travel Insurance Disability UK Self-Catering | ' . $site_name,
			'meta_description' => 'Travel insurance and disability on UK self-catering breaks: mobility equipment limits, pre-existing conditions, cancellation triggers, and broker questions.',
			'content'          => restwell_get_blog_post_travel_insurance_disability_uk_html(),
			'category_slug'    => 'accessible-holidays',
		),
		array(
			'slug'             => 'commissioner-checklist-accessible-respite-stay',
			'title'            => 'Commissioner checklist: evidencing an accessible respite stay',
			'excerpt'          => 'Hoist paperwork, sleep-in safeguarding, insurance certificates, and the measurement rows audit teams expect before approving nights away.',
			'meta_title'       => 'Commissioner Checklist Accessible Respite Stay | ' . $site_name,
			'meta_description' => 'Commissioner checklist for accessible respite stays: hoist paperwork, safeguarding sleep-ins, insurance certificates, and audit-ready evidence before approving nights.',
			'content'          => restwell_get_blog_post_commissioner_accessible_respite_html(),
			'category_slug'    => 'funding-care',
		),
		array(
			'slug'             => 'personal-budget-short-break-care-act',
			'title'            => 'Personal budgets and short breaks under the Care Act',
			'excerpt'          => 'Splitting PA hours, transport, and accommodation receipts so retrospective audits survive — without pretending social care money buys flights by default.',
			'meta_title'       => 'Personal Budget Short Break Care Act | ' . $site_name,
			'meta_description' => 'Personal budget short breaks under the Care Act: splitting PA hours, accommodation, and transport receipts so panel audits stay clean.',
			'content'          => restwell_get_blog_post_personal_budget_short_break_html(),
			'category_slug'    => 'funding-care',
		),
		array(
			'slug'             => 'accessible-eating-out-whitstable-kent',
			'title'            => 'Accessible eating out near Whitstable and along the Kent coast',
			'excerpt'          => 'Step-free routes, toilet reality, quieter tables, and why harbour weekends punish wheelchair circulation.',
			'meta_title'       => 'Accessible Eating Out Whitstable Kent | ' . $site_name,
			'meta_description' => 'Accessible eating out near Whitstable and the Kent coast: step-free entries, toilet routes, quieter tables, and harbour crowding tactics.',
			'content'          => restwell_get_blog_post_accessible_eating_out_whitstable_html(),
			'category_slug'    => 'kent-coast',
		),
		array(
			'slug'             => 'changing-places-toilets-kent-coast-days-out',
			'title'            => 'Changing Places and accessible toilets for Kent coast days out',
			'excerpt'          => 'Why Changing Places matter, how standard accessible loos differ, and how to map toilet stops before you commit miles of promenade.',
			'meta_title'       => 'Changing Places Toilets Kent Coast | Days Out | ' . $site_name,
			'meta_description' => 'Changing Places and accessible toilets for Kent coast days out: how CP differs from standard loos, mapping stops, and pairing with beach plans.',
			'content'          => restwell_get_blog_post_changing_places_kent_coast_html(),
			'category_slug'    => 'kent-coast',
		),
		array(
			'slug'             => 'quieter-times-whitstable-low-crowd-access',
			'title'            => 'Quieter times to visit Whitstable if you need space and calm',
			'excerpt'          => 'Weekday patterns, festival pitfalls, and why parking turnover matters as much as tide times for low-energy travellers.',
			'meta_title'       => 'Quieter Times Whitstable Visit | Low Crowd Access | ' . $site_name,
			'meta_description' => 'Quieter times to visit Whitstable for accessible travellers: weekday patterns, festival pitfalls, parking turnover, and fatigue-friendly pacing.',
			'content'          => restwell_get_blog_post_quieter_whitstable_visit_html(),
			'category_slug'    => 'kent-coast',
		),
		array(
			'slug'             => 'holiday-backup-plan-care-worker-change',
			'title'            => 'Backup plans when care arrangements change on holiday',
			'excerpt'          => 'Contingency cards, agency overflow, consent paperwork, and when cutting a trip short beats unsafe nights.',
			'meta_title'       => 'Holiday Backup Plan Care Worker Change | ' . $site_name,
			'meta_description' => 'Holiday backup plans when care workers change or cancel: contingency cards, agency tiers, budgets for emergency cover, and safe escalation.',
			'content'          => restwell_get_blog_post_holiday_backup_care_plan_html(),
			'category_slug'    => 'accessible-holidays',
		),
		array(
			'slug'             => 'how-to-read-holiday-cottage-access-statement',
			'title'            => 'How to read a holiday cottage access statement before you book',
			'excerpt'          => 'Measurements that matter, hoist proof, red-flag phrases, and how commissioners score PDFs differently from families.',
			'meta_title'       => 'How to Read Holiday Cottage Access Statement | ' . $site_name,
			'meta_description' => 'How to read a holiday cottage access statement: measurements that matter, hoist proof, red-flag phrases, and questions OTs and families should ask.',
			'content'          => restwell_get_blog_post_read_access_statement_html(),
			'category_slug'    => 'accessible-holidays',
		),
		array(
			'slug'             => 'fatigue-friendly-whitstable-coastal-day',
			'title'            => 'Fatigue-friendly coastal days around Whitstable',
			'excerpt'          => 'Pacing blocks, wind and glare, hydration, and realistic promenade targets for MS, long COVID, and post-stroke endurance limits.',
			'meta_title'       => 'Fatigue Friendly Whitstable Coastal Day | ' . $site_name,
			'meta_description' => 'Fatigue-friendly coastal days around Whitstable: pacing blocks, sensory load, wind and glare, hydration, and realistic promenade targets.',
			'content'          => restwell_get_blog_post_fatigue_friendly_coastal_day_html(),
			'category_slug'    => 'kent-coast',
		),
	);

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
			'post_author'   => get_current_user_id() ?: 1,
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
	$loc       = esc_url( home_url( '/whitstable-area-guide/' ) );
	$pr        = esc_url( home_url( '/the-property/' ) );
	$home      = esc_url( home_url( '/' ) );
	$blog      = esc_url( home_url( '/blog/' ) );
	$enq       = esc_url( home_url( '/enquire/' ) );
	$who       = esc_url( home_url( '/who-its-for/' ) );
	$checklist = esc_url( home_url( '/how-to-choose-accessible-self-catering-holiday/' ) );
	$dp        = esc_url( home_url( '/direct-payment-holiday-accommodation/' ) );
	$turner    = 'https://www.turnercontemporary.org/';

	return "<blockquote><p><strong>TL;DR:</strong> Most of the Kent coast is shingle, which is hard work or impossible for many wheeled mobility aids on the beach surface itself. Plan around level promenades, sandy bays such as Viking Bay or Margate Main Sands, and Beach Within Reach beach wheelchairs where they operate.</p></blockquote>

<h2>What is accessible coastal access in Kent?</h2>
<p>Accessible coastal access here means matching how you move to the surface you will cross: promenades and sea walls for predictable level routes, sandy bays where wheels roll more predictably, and equipment schemes when you need help onto sand or shingle.</p>
<p>Kent's coastline stretches for over 350 miles. Most of it is shingle. That matters if you use a wheelchair, powerchair, or walking frame, because shingle varies from manageable to impassable depending on depth and compaction.</p>

<h2>Why surface matters more than Blue Flags</h2>
<p>Blue Flags signal water quality; they do not guarantee a roll-friendly beach. The most reliable accessible experience on much of the north Kent coast is often the promenade: paved or tarmac paths above the beach that stay level and in reasonable repair. You can still see and hear the sea and, on many stretches, get close to the waterline without crossing loose shingle.</p>
<p>All-terrain beach wheelchairs, pushed by a companion, open up sand and some shingle at a limited set of locations. Details below.</p>

<div class=\"wp-block-table\">
<table>
<caption>Three ways to experience the Kent coast with mobility equipment</caption>
<thead>
<tr><th scope=\"col\">Approach</th><th scope=\"col\">Best when</th><th scope=\"col\">Watch out for</th></tr>
</thead>
<tbody>
<tr><td>Seafront promenade</td><td>You want a level route beside the sea without crossing loose stone.</td><td>Steep or uneven transitions from car parks; busy summer parking.</td></tr>
<tr><td>Sandy bay</td><td>You want to roll closer to the water on a more predictable surface.</td><td>Tide times; lifeguard and hire seasons vary.</td></tr>
<tr><td>Beach Within Reach loan chairs</td><td>You want to reach sand or shingle off a promenade.</td><td>Availability on busy days; confirm by phone where listed.</td></tr>
</tbody>
</table>
</div>

<h2>How it works: where to go</h2>
<h3>Whitstable and Tankerton</h3>
<p>Tankerton is the area immediately east of Whitstable town centre, and its promenade is one of the most consistently accessible seafront routes on the north Kent coast. The surface is smooth and level, suitable for powered and manual wheelchairs alike. It runs for several miles and connects back to Whitstable seafront.</p>
<p>Access from the road is off Marine Parade, where there is a mix of free and pay-and-display parking along the seafront. The transition from parking to promenade level involves a slope - some sections are steeper than others. The paved paths are easier than the grassy slopes between the road and the sea wall, so look for those rather than cutting across the grass.</p>
<p>At very low tide a shingle spit called The Street extends out from Tankerton beach. It attracts attention, but it is loose shingle and not accessible for wheelchair users.</p>
<p>Whitstable town centre and harbour are mostly level, though some older streets near the harbour have uneven or narrow sections. The harbour itself can be congested at weekends - weekday mornings are generally easier. Areas near the fish market can have rougher surfaces at the edges.</p>

<h3>Herne Bay</h3>
<p>About four miles east of Whitstable, Herne Bay is a traditional seaside town with one of the more practical seafronts for accessibility on this stretch of coast. The central promenade is wide, flat, and well-surfaced, running in both directions from the town centre.</p>
<p>Accessible parking and toilets are available on Central Parade. Seafront cafes are generally at promenade level. Herne Bay holds Blue Flag status for water quality. The beach is a mix of shingle and sand at lower tide - more navigable than pure shingle but still not easily crossed in a standard wheelchair without beach-specific equipment.</p>
<p>Herne Bay Pier has been partially rebuilt following earlier storm damage. Check current access conditions before planning a visit there specifically.</p>

<h3>Viking Bay, Broadstairs</h3>
<p>Viking Bay has one of the best beach accessibility setups on the Kent coast. A boardwalk more than two metres wide was installed to provide direct route to the beach surface, and a seasonal lift from the clifftop car park to beach level operates from April to September.</p>
<p>Accessible toilets are at Broadstairs Harbour and the Clock Tower. The bay is well-sheltered and has a sandy beach - a significant practical advantage over the shingle-heavy beaches further west along the coast.</p>
<p>Viking Bay is one of the Beach Within Reach locations (see below). The sandy surface combined with wheelchair lending makes it one of the most genuinely accessible beach experiences in Kent.</p>

<h3>Joss Bay and Botany Bay</h3>
<p>Both are near Broadstairs and hold Blue Flag and Seaside Award status. Joss Bay has accessible routes to the beach, accessible toilets, seasonal lifeguards (May to September), and a café. An access statement is available - worth requesting before your visit to confirm what is currently in place.</p>
<p>Botany Bay is more remote, with limited parking and no coach access. It is best reached on foot or by bike from Broadstairs, which limits its practicality for most wheelchair users. If distance from parking is a problem, focus on Viking Bay or Joss Bay instead.</p>

<h3>Margate Main Sands</h3>
<p>Margate's main beach is sandy rather than shingle - a difference that immediately makes it more manageable on wheels. Blue Badge parking is available at Dreamland car park, with level seafront access via dropped kerbs and tactile paving.</p>
<p>If you are combining the coast with art, <a href=\"{$turner}\" target=\"_blank\" rel=\"noopener noreferrer\">Turner Contemporary</a> is a short distance from Main Sands. Check their site for current access, tickets, and lift status before you travel.</p>
<p>Beach Within Reach wheelchairs are available at Margate from the Bay Inspectors office - contact 07432 648279 to confirm availability before your visit. A boardwalk improvement funded by Thanet District Council is planned for 2026-27, which should extend accessible beach-level access further.</p>

<h3>Beach Within Reach</h3>
<p>Beach Within Reach is a scheme operating at several locations on the Thanet coast that provides free all-terrain beach wheelchairs. These are purpose-designed to be pushed across sand and shingle by a companion, allowing wheelchair users access to the beach surface rather than being limited to promenades.</p>
<p>Current locations include Viking Bay, Broadstairs, and Margate Main Sands. No prior booking is usually required, but availability can vary on busy days. If you are planning a specific visit, contact ahead to confirm.</p>

<h3>Coastal walking between towns</h3>
<p>The Viking Coastal Trail covers about 32 miles around Thanet. Sections near Margate and Broadstairs run on good, level surfaces and are suitable for many wheelchair users. Some inland stretches are less consistent - check specific sections before planning a longer route.</p>
<p>Tankerton to Herne Bay is roughly four miles along mostly level promenade. The surface changes character at various points, so checking conditions in advance is sensible if you plan to do the full stretch. This route is popular with Restwell guests staying in Whitstable.</p>

<h2>Practical steps before you travel</h2>
<h3>Accessible toilets</h3>
<p>Accessible public toilets are not consistently available at every beach. Check visitkent.co.uk or contact each location in advance. The situation changes seasonally and some facilities close outside peak months.</p>
<h3>Seasonal access services</h3>
<p>Beach wheelchairs, lifeguards, and certain access facilities generally run from May to September. Visiting outside that window means reduced support at most locations.</p>
<h3>Parking</h3>
<p>Seafront car parks fill quickly on warm weekends and bank holidays. Blue Badge holders can use on-street bays free of charge with no time limit under current rules, but bay availability varies. Arriving early or planning a mid-week visit makes parking more predictable.</p>

<h2>Common mistakes on coastal days out</h2>
<ul>
<li>Treating Blue Flag awards as proof that the beach surface suits your wheelchair or frame.</li>
<li>Heading onto Tankerton's The Street shingle spit at low tide without realising how loose the stone is.</li>
<li>Assuming cliff lifts, beach wheelchairs, or lifeguard cover run year-round.</li>
<li>Leaving seafront parking to chance on the hottest weekends.</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>Can a standard wheelchair cross Kent beaches?</h3>
<p>Often not on loose shingle without help. Promenades stay level beside the sea. Sandy bays such as Viking Bay or Margate Main Sands help. Beach Within Reach loans chairs at some Thanet beaches; phone ahead on busy days.</p>
<h3>Where is the easiest sandy beach between Whitstable and Margate?</h3>
<p>Viking Bay combines sand, a wide boardwalk, a seasonal cliff lift, and Beach Within Reach. Margate Main Sands is sandy with Blue Badge parking nearby. Both beat pure shingle for rolling closer to the water.</p>
<h3>Do I need to book a Beach Within Reach wheelchair?</h3>
<p>Usually no prior booking, but busy days exhaust stock fast. At Margate call the Bay Inspectors office on 07432 648279 before you travel if the chair is essential to your plan.</p>
<h3>Is Herne Bay Central Parade workable in a powerchair?</h3>
<p>Yes for the main seafront strip: wide, flat paving. Shingle or mixed sand below still needs caution or specialist chairs. Verify pier access separately if that matters to your day.</p>
<h3>What is the most wheelchair-friendly seafront near Whitstable?</h3>
<p>Tankerton promenade east of town: smooth, level, and continuous for miles. Stay on paved routes from Marine Parade rather than cutting grass slopes.</p>

<h2>Planning a stay or related guides</h2>
<p>Whitstable puts you within easy reach of the Tankerton promenade, and about fifteen minutes' drive from Herne Bay's seafront. Broadstairs and Margate are roughly 30 to 40 minutes by car - practical for day trips but worth planning rather than treating as spontaneous.</p>
<p>For more Restwell guides start from our <a href=\"{$blog}\">blog</a>. Our <a href=\"{$loc}\">Whitstable and Kent coast area guide</a> has local detail. If you are considering a stay, <a href=\"{$who}\">read who Restwell is for</a>, <a href=\"{$pr}\">review the adapted bungalow</a>, or <a href=\"{$enq}\">enquire about dates and suitability</a>.</p>
<p>For a quick overview before you book, see the <a href=\"{$home}\">Restwell home page</a>. Planning where to stay? Our <a href=\"{$checklist}\">guide to choosing an accessible self-catering property</a> lists verification steps. Funding a PA on trip day? Read our <a href=\"{$dp}\">direct payments guide</a>.</p>";
}

/**
 * @return string
 */
function restwell_get_blog_post_direct_payments_html() {
	$res    = esc_url( home_url( '/resources/' ) );
	$faq    = esc_url( home_url( '/faq/' ) );
	$blog   = esc_url( home_url( '/blog/' ) );
	$enq    = esc_url( home_url( '/enquire/' ) );
	$pr     = esc_url( home_url( '/the-property/' ) );
	$carers = esc_url( home_url( '/carers-respite-holiday-guide/' ) );
	$who    = esc_url( home_url( '/who-its-for/' ) );
	$acc    = esc_url( home_url( '/accessibility/' ) );

	return "<blockquote><p><strong>TL;DR:</strong> Direct payments buy care that matches your agreed plan, not the bricks-and-mortar cost of a holiday let. You can often fund a PA or agency during a trip; the cottage or hotel room usually sits outside that budget unless a separate short-break package applies.</p></blockquote>

<h2>What is a direct payment?</h2>
<p>A direct payment is money from your local authority paid to you so you can arrange your own care instead of the council commissioning services directly. In Kent this typically sits on the Kent Card and must follow your written care and support plan.</p>
<p>You receive direct payments only after a formal needs assessment, a personal budget calculation, and any contribution assessment. Records matter: spending outside the plan can trigger reviews or clawback.</p>

<h2>Why holidays confuse people</h2>
<p>Guests assume \"holiday\" means one invoice. Commissioners think in two lines: care time (often eligible) and accommodation (usually private or another scheme). Until you separate those costs, conversations about funded breaks stall.</p>

<h2>How funding lines actually split</h2>
<p>Direct payments routinely cover employment of a personal assistant, payments to an approved agency, and agreed activity support. They generally do <strong>not</strong> cover accommodation charges billed as property rent.</p>
<p>The rule of thumb: fund the <em>care</em>, not the postcode.</p>

<div class=\"wp-block-table\">
<table>
<caption>Care funding versus accommodation on a trip</caption>
<thead>
<tr><th scope=\"col\">Cost type</th><th scope=\"col\">Often covered by direct payment / PHB care budget</th><th scope=\"col\">Usually paid separately</th></tr>
</thead>
<tbody>
<tr><td>Personal assistant wages during travel</td><td>Yes, when named in the plan</td><td>N/A</td></tr>
<tr><td>Approved agency shifts on holiday</td><td>Yes, when pre-authorised</td><td>N/A</td></tr>
<tr><td>Holiday cottage, hotel room, or letting fee</td><td>Rare via standard direct payment</td><td>Self-funded, grants, or bespoke short-break funding</td></tr>
</tbody>
</table>
</div>

<h3>Lists worth copying into your notes</h3>
<ul>
<li><strong>Supported travel:</strong> PA wages, mileage agreed in advance, overnight allowances if your plan permits.</li>
<li><strong>Still separate:</strong> nightly accommodation charges unless the council packages respite with lodging under a distinct assessment.</li>
</ul>
<p>Some authorities negotiate short breaks that wrap lodging and care for eligible people. That is not the same mechanism as your standing weekly direct payment. Ask explicitly for short-break provision.</p>

<h2>Short breaks sit in a different conversation</h2>
<p>The Care Act 2014 duties around carers and disabled adults include routes to respite-style support. In Kent, adult social care teams bridge assessments and funded packages.</p>
<p>You might receive an annual short-break allocation or add holiday care hours into an existing plan. Nothing is automatic: it tracks assessed need and local budgets.</p>
<p>Ask: <em>&ldquo;Can respite or a short break be written into our plan this year, and what evidence do you need to approve it?&rdquo;</em></p>

<h2>NHS Continuing Healthcare and personal health budgets</h2>
<p>NHS Continuing Healthcare packages include a right to a personal health budget. That NHS pot can pay for assessed nursing or personal care while you travel. Accommodation remains a separate invoice in most cases.</p>
<p>People who hold CHC and take a direct payment for their health budget keep the most flexibility about where care happens. Start with your CHC coordinator or ICB if this is unfamiliar. Our <a href=\"{$res}\">funding and support page</a> walks through the crossover.</p>

<h2>Practical paperwork before you ask commissioners</h2>
<ul>
<li>Dates, party size, and where hands-on support is needed versus standby.</li>
<li>The property access statement, equipment list, and dimensions.</li>
<li>A clear funding ask: hours of care, not nights booked.</li>
<li>Questions about short-break pots, not only baseline direct payment rules.</li>
</ul>
<p>Restwell supplies specs for commissioners on request. <a href=\"{$pr}\">Review the property</a> or <a href=\"{$enq}\">contact us</a> when you need paperwork.</p>

<h2>Common mistakes when booking</h2>
<ul>
<li>Routing the entire cottage invoice through a Kent Card without written approval.</li>
<li>Discussing \"holiday funding\" without separating care hours from accommodation.</li>
<li>Forgetting to request short-break clauses during annual planning meetings.</li>
<li>Arriving without PDF evidence when an OT or social worker needs to sign off.</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>Can I pay for a holiday cottage with my direct payment?</h3>
<p>Usually no if it is purely accommodation rent. Care staff hours during the stay may qualify. Some councils fund packaged respite that includes lodging after assessment.</p>
<h3>Can my PA travel with me using direct payment funds?</h3>
<p>Yes when your plan documents PA coverage and the spend matches agreed rates and expenses.</p>
<h3>Does CHC pay for both care and the hotel?</h3>
<p>Care duties yes; room charges typically stay separate unless a bespoke NHS package states otherwise.</p>
<h3>What question unlocks short-break funding?</h3>
<p>Ask whether respite or a short break can be written into your support plan and which forms or OT letters they require.</p>
<h3>Where can I read Restwell's accessibility evidence?</h3>
<p>Use our <a href=\"{$acc}\">accessibility specification</a> alongside the funding page when you build a packet for commissioners.</p>

<h2>What usually happens for Restwell guests</h2>
<p>Most funded visitors self-pay the bungalow and route PA or agency hours through direct payment or a PHB. Splitting invoices keeps audits simple.</p>
<p>If accommodation cost blocks the trip, investigate Revitalise Support Fund grants at revitalise.org.uk.</p>
<p>Continue with our <a href=\"{$res}\">funding hub</a>, <a href=\"{$faq}\">FAQ on funded stays</a>, and related posts on the <a href=\"{$blog}\">blog</a>. Carers should also read the <a href=\"{$carers}\">carers respite guide</a>. When you are ready, <a href=\"{$who}\">confirm fit</a> and <a href=\"{$enq}\">talk to us</a>.</p>";
}

/**
 * @return string
 */
function restwell_get_blog_post_revitalise_html() {
	$who       = esc_url( home_url( '/who-its-for/' ) );
	$enq       = esc_url( home_url( '/enquire/' ) );
	$acc       = esc_url( home_url( '/accessibility/' ) );
	$res       = esc_url( home_url( '/resources/' ) );
	$blog      = esc_url( home_url( '/blog/' ) );
	$dp        = esc_url( home_url( '/direct-payment-holiday-accommodation/' ) );
	$checklist = esc_url( home_url( '/how-to-choose-accessible-self-catering-holiday/' ) );

	return "<blockquote><p><strong>TL;DR:</strong> Revitalise shut its staffed holiday centres in November 2024 after costs outran income. The charity now awards Revitalise Support Fund grants. Most travellers replace the old residential model with adapted self-catering plus their own carers, or escorted trips such as Limitless Travel.</p></blockquote>

<h2>What was Revitalise?</h2>
<p>For decades Revitalise ran the UK's best-known staffed holiday centres for disabled adults who needed 24-hour nursing or personal care on site. Guests paid for packages that bundled adapted rooms, hoists, catering, activities, and rostered care teams.</p>

<h2>Why that model mattered</h2>
<p>The charity began in the 1960s as the Winged Fellowship Trust when almost no mainstream operators catered for complex disabilities. Centres such as Jubilee Lodge (Southport) and an Essex site delivered roughly 4,000 breaks a year at peak, funded through a mix of guest fees, NHS CHC routes, and local authority placements.</p>
<p>That setup filled a gap for guests who could not self-assemble care inside a cottage or hotel.</p>

<h2>Why the centres closed</h2>
<p>Revitalise listed pressures that made trading impossible:</p>
<ul>
<li>Council-funded placements shrank, leaving private tariffs carrying more of the weekly payroll.</li>
<li>Agency staffing inflation pushed weekly delivery costs toward £3,000 per guest at the end.</li>
<li>Donations dipped while utility and insurance bills climbed.</li>
<li>Recruiting permanent nurses and carers stayed difficult nationwide.</li>
</ul>
<p>Trade press coverage at the time framed the closure as the tip of wider adult social care funding stress, not an isolated bookkeeping glitch.</p>

<h2>What Revitalise offers now</h2>
<p>The charity stayed registered but pivoted to the Revitalise Support Fund. Grants fund breaks and experiences for disabled adults and carers who cannot otherwise afford them. Revitalise reports over £125,000 distributed since the fund launched.</p>
<p>Apply via <a href=\"https://revitalise.org.uk\" target=\"_blank\" rel=\"noopener noreferrer\">revitalise.org.uk</a> when price is the blocker.</p>

<h3>Netley Waterside House and Vitalise</h3>
<p>Netley Waterside House in Hampshire began life under Revitalise branding but operates separately today and appears in NHS directories under Vitalise. Names clash easily: confirm services, referrals, and safeguarding directly with that site before planning travel.</p>

<div class=\"wp-block-table\">
<table>
<caption>Three ways to holiday after the centres closed</caption>
<thead>
<tr><th scope=\"col\">Model</th><th scope=\"col\">Care arrangement</th><th scope=\"col\">Trade-offs</th></tr>
</thead>
<tbody>
<tr><td>Staffed Revitalise centre (historic)</td><td>24-hour teams on site</td><td>No longer available; was highest-touch option.</td></tr>
<tr><td>Adapted self-catering</td><td>You supply PA, family, or agency hours</td><td>Flexible but only works if care is already organised.</td></tr>
<tr><td>Escorted group operators</td><td>Trip staff deliver care on coach holidays</td><td>Fixed itineraries; less privacy than a bungalow.</td></tr>
</tbody>
</table>
</div>

<h2>How self-catering differs</h2>
<p>Self-catering swaps bundled staffing for independence. You verify hoists, wet rooms, and carer beds before you pay a deposit. \"Accessible\" listings range from grab rails to full track hoists, so ask measurable questions.</p>
<p><strong>Minimum checks:</strong> see our <a href=\"{$checklist}\">accessible self-catering guide</a> for the full interrogation list.</p>
<ul>
<li>Does the listing spell out equipment or hide behind adjectives?</li>
<li>Can you speak to the owner or operator directly?</li>
<li>Is there a written access statement with millimetre dimensions?</li>
<li>Will your commissioner accept the paperwork?</li>
</ul>

<h2>Escorted and specialist alternatives</h2>
<p><a href=\"https://www.limitlesstravel.org\" target=\"_blank\" rel=\"noopener noreferrer\">Limitless Travel</a> runs coach holidays with care teams onboard: closest vibe to the old residential centres for guests who need hands-on support without self-building rosters.</p>
<p><a href=\"https://calvertlakes.org.uk\" target=\"_blank\" rel=\"noopener noreferrer\">Calvert Lakes</a> combines outdoor activity programmes with bursaries up to 25% when eligibility criteria are met.</p>
<p>Directories worth bookmarking:</p>
<ul>
<li><a href=\"https://www.euansguide.com\" target=\"_blank\" rel=\"noopener noreferrer\">Euan's Guide</a> for crowdsourced access reviews.</li>
<li><a href=\"https://www.tourismforall.co.uk/\" target=\"_blank\" rel=\"noopener noreferrer\">Tourism for All</a> for national advice.</li>
<li><a href=\"https://www.accessable.org/\" target=\"_blank\" rel=\"noopener noreferrer\">AccessAble</a> for audited venue guides.</li>
</ul>

<h2>Common planning mistakes</h2>
<ul>
<li>Treating any cottage labelled \"accessible\" as clinically verified.</li>
<li>Expecting on-site nurses when booking generic holiday lets.</li>
<li>Forgetting to split accommodation invoices from PA wage claims.</li>
<li>Skipping grant applications when Revitalise Support Fund could bridge the gap.</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>Are Revitalise centres reopening?</h3>
<p>No announced reopening. Monitor revitalise.org.uk for governance updates; budgets now emphasise grants.</p>
<h3>What replaced 24-hour centre care?</h3>
<p>Guests mix self-catering with private PA hours, agency rotas, escorted operators, or NHS-funded packages tailored to clinical need.</p>
<h3>Can grants pay for adapted cottages?</h3>
<p>Revitalise Support Fund wording allows holidays and experiences; confirm eligibility PDFs on their site before applying.</p>
<h3>Is Limitless Travel suitable for hoist users?</h3>
<p>They publish accessibility questionnaires per trip. Complete theirs honestly rather than guessing equipment fit.</p>
<h3>Where does Restwell fit?</h3>
<p>We offer an adapted Whitstable bungalow with hoist-track bedroom and wet room for guests who bring their own support teams.</p>

<h2>Restwell's role</h2>
<p>We are not a staffed medical centre. Guests organise carers or family coverage. We publish hoist specs, wet-room dimensions, and door widths so clinicians can decide quickly.</p>
<p>Funded stays welcome where paperwork matches reality. Start at our <a href=\"{$res}\">funding hub</a>, then read <a href=\"{$dp}\">how direct payments interact with holidays</a>.</p>
<p>If we are not the right fit, say so early. Better a frank no than a breakdown on arrival. Explore other guides on the <a href=\"{$blog}\">blog</a>, study <a href=\"{$acc}\">accessibility detail</a>, <a href=\"{$who}\">who we host</a>, and <a href=\"{$enq}\">enquire</a> once assessments line up.</p>";
}

/**
 * @return string
 */
function restwell_get_blog_post_self_catering_checklist_html() {
	$acc    = esc_url( home_url( '/accessibility/' ) );
	$blog   = esc_url( home_url( '/blog/' ) );
	$enq    = esc_url( home_url( '/enquire/' ) );
	$who    = esc_url( home_url( '/who-its-for/' ) );
	$dp     = esc_url( home_url( '/direct-payment-holiday-accommodation/' ) );
	$rev    = esc_url( home_url( '/revitalise-alternatives-accessible-holidays/' ) );

	return "<blockquote><p><strong>TL;DR:</strong> Treat \"accessible\" as unverified until you have millimetre measurements, hoist safe working loads, and photos that match your transfer routine. Ask every question below in writing before you pay a deposit.</p></blockquote>

<h2>What counts as an accessible self-catering property?</h2>
<p>It is one where door widths, bathroom layout, hoist coverage, and bed heights match your assessed needs, evidenced by an access statement rather than adjectives. Anything less is marketing copy.</p>

<h2>Why listing sites mislead</h2>
<p>Platforms depend on owners self-certifying. Without a shared UK-wide standard, \"accessible\" can mean a grab rail or a full ceiling track system. You read between the lines because the platform rarely audits claims.</p>

<div class=\"wp-block-table\">
<table>
<caption>Listing clichés versus follow-up questions</caption>
<thead>
<tr><th scope=\"col\">Phrase you will see</th><th scope=\"col\">Push for specifics</th></tr>
</thead>
<tbody>
<tr><td>Accessible bathroom</td><td>Roll-in width? Ridge height? Hoist reach?</td></tr>
<tr><td>Ramped access</td><td>Gradient percentage? Handrails? Destination door width?</td></tr>
<tr><td>Ground-floor bedroom</td><td>Is the bathroom on the same level without steps?</td></tr>
<tr><td>Wheelchair friendly</td><td>Manual or powered chair? Tested by whom?</td></tr>
</tbody>
</table>
</div>

<h2>How to verify each area</h2>
<p>Before you commit, collect answers (email is fine) for every heading below.</p>

<h3>Arrival and outdoor access</h3>
<ul>
<li>Is there step-free access from the car to the front door? (Not \"ramped access\" - is the route completely level, or does it include slopes that would be difficult for a powerchair?)</li>
<li>What is the parking arrangement? Is there space for a vehicle with a rear or side ramp?</li>
<li>Is the parking surface level and firm?</li>
<li>What is the width of the front door - the actual measurement, not an estimate?</li>
</ul>

<h3>Internal layout</h3>
<ul>
<li>What are the door widths throughout the property? 750mm is often stated as a minimum for manual wheelchairs; 850mm or more is better for powerchairs and lateral transfers.</li>
<li>Is there step-free access between all rooms on a single level, including the bedroom, bathroom, and kitchen?</li>
<li>Is there a turning circle in the main bedroom - ideally 1500mm clear of obstructions?</li>
<li>Are there any internal thresholds or lips between rooms?</li>
</ul>

<h3>Bathroom</h3>
<p>The bathroom is the most important room in an adapted property. Generic descriptions are rarely sufficient. Ask:</p>
<ul>
<li>Is it a roll-in (wheel-in) shower, or does it have a step or ridge? What is the shower entry width?</li>
<li>Are there grab rails at the toilet and in the shower - on both sides, or only one?</li>
<li>What shower seating is provided (perching stool, portable chair, or none), and can the owner supply a shower chair if you need one?</li>
<li>Is the washbasin at a fixed height or fully height-adjustable? Can it swing or move aside when you need clearer transfer or assistance space?</li>
<li>Is there a ceiling or floor-based hoist, and if so, what is the safe working load?</li>
<li>If a hoist is advertised, which rooms does the track actually cover (bedroom only, into the bathroom, or further), and does that match how you transfer?</li>
<li>What is the floor surface - wet room drainage, or a wet room with a slight camber?</li>
</ul>

<h3>Bedroom</h3>
<ul>
<li>What is the bed height? Transfer height is typically 45-55cm from the floor.</li>
<li>Is the bed a standard fixed frame, or an adjustable profiling bed?</li>
<li>Is there a hoist, and is the track laid where you need it (for example fully over the bed, or extending into the bathroom)?</li>
<li>Is there space on both sides of the bed for transfers and for a carer to work?</li>
<li>Is there storage for medical equipment, mobility aids, or a ventilator if needed?</li>
</ul>

<h3>Kitchen and living spaces</h3>
<ul>
<li>Are kitchen worktops at a usable height from a seated position, or is the kitchen designed only for standing use?</li>
<li>Is the main living area on the same level as the bedroom and bathroom?</li>
<li>Are light switches, sockets, and thermostats at a reachable height from a wheelchair?</li>
</ul>

<h3>Sleeping for carers</h3>
<ul>
<li>Is there a separate bedroom for a carer or support worker?</li>
<li>If not, what are the sleeping arrangements for support staff?</li>
</ul>

<h2>Common mistakes while booking</h2>
<ul>
<li>Trusting glossy photography instead of dimensioned drawings.</li>
<li>Paying deposits before a commissioner or OT signs off.</li>
<li>Skipping carer sleeping arrangements until arrival night.</li>
<li>Assuming previous guests had identical hoist or toileting needs.</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>Which measurement matters most on day one?</h3>
<p>Door clear widths and turning circles. If those fail, every other feature becomes theoretical.</p>
<h3>Do I need a hoist survey?</h3>
<p>If transfers depend on ceiling tracks or portable lifts, yes. Request photos plus installer manuals showing safe working load.</p>
<h3>Can I rely on Airbnb filters?</h3>
<p>Use filters as a shortlist only. Nothing replaces owner emails with measurements.</p>
<h3>What proves wet-room drainage?</h3>
<p>Ask for photos showing gradients toward waste traps plus slip-resistant flooring notes.</p>
<h3>Who pays for accessibility paperwork?</h3>
<p>Guests usually assemble packs; thorough hosts supply PDF statements without charging.</p>

<h2>Documentation pack to assemble</h2>
<p>Serious operators send door widths in millimetres, hoist SWL, shower entry widths, toilet transfer zones, and honest photographs, not renders.</p>
<ul>
<li>Written access statement or guide endorsed by the owner.</li>
<li>Plans showing circulation space beside beds.</li>
<li>Equipment manuals or servicing stickers for hoists.</li>
<li>Screenshots of insurer or mortgage lender accessibility certifications where relevant.</li>
</ul>
<p>Funded placements fail fast when paperwork is thin. Give commissioners everything upfront.</p>

<h2>Restwell's approach</h2>
<p>We publish hoist routes, wet-room dimensions, and door widths publicly so OTs can veto or approve before emotions run high. Start at <a href=\"{$acc}\">Accessibility</a>, cross-check against funding guidance on our <a href=\"{$blog}\">blog</a>, then <a href=\"{$enq}\">email questions</a>.</p>
<p>If Restwell cannot meet clinical reality we say so early. Read <a href=\"{$who}\">who we host</a>, study <a href=\"{$dp}\">direct payment holiday rules</a>, and explore <a href=\"{$rev}\">Revitalise-era alternatives</a> when historic comparisons help.</p>";
}

/**
 * @return string
 */
function restwell_get_blog_post_carers_respite_html() {
	$res       = esc_url( home_url( '/resources/' ) );
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

	return "<blockquote><p><strong>TL;DR:</strong> Treat packing as part of your risk assessment: duplicate medication, spare sling parts, continence stock for closed shops, and written confirmations for anything the listing promises. If the hoist or mattress type is wrong when you arrive, bags cannot fix it — verify specs before you pay.</p></blockquote>

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
