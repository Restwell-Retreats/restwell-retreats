<?php
/**
 * Additional seeded blog post HTML (cluster A: posts 1–6 of 12).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * CHC respite care (Batch D, 26 Oct 2026): what NHS Continuing Healthcare
 * pays for while a family carer has a break, and what it doesn't on holiday.
 *
 * @return string
 */
function restwell_get_blog_post_chc_respite_holiday_accommodation_html() {
	$funding = esc_url( home_url( '/funding-and-support/' ) );
	$care    = esc_url( home_url( '/optional-care/' ) );
	$enquire = esc_url( home_url( '/enquire/' ) );
	$carers  = esc_url( home_url( '/carers-respite-holiday-guide/' ) );
	$access  = esc_url( home_url( '/accessibility/' ) );

	return "<blockquote><p><strong>TL;DR:</strong> If you get NHS Continuing Healthcare, the NHS can pay for extra care while your family carer has a break. It doesn't pay for rent, food or the holiday itself. Your integrated care board decides what goes in your plan, so ask before you book.</p></blockquote>

<h2>What is CHC respite care?</h2>
<p>CHC respite care is extra care, paid for by the NHS, so a family carer can take a break. It's for people who get NHS Continuing Healthcare at home. The care can come to the house, or you can stay elsewhere for a while.</p>
<p>NHS Continuing Healthcare, or CHC, is care that the NHS arranges and pays for in full. It's for people with complex health needs. It isn't a benefit you claim, and it depends on your needs, not on a diagnosis.</p>

<h2>Does CHC pay for respite?</h2>
<p>Yes, the national rules say the NHS should pay for all your assessed care at home. That includes extra support while your carer has a break. The NHS should also make sure your carer knows that help is there.</p>
<p>The NHS body that decides is your integrated care board, or ICB. There's no national number of days, so how much respite you get depends on your care plan. As one example, NHS Sussex's 2024 policy offers family carers up to 28 days a year.</p>
<p>For other ways to pay for a break, see our guide to <a href=\"{$funding}\">grants, council funding and the NHS</a>.</p>

<h2>What can CHC respite look like?</h2>
<p>It depends on what suits you and your carer. These are the usual options, though your ICB decides what it offers.</p>
<ul>
<li>More care at home, such as extra PA hours or a live-in carer, while your carer goes away.</li>
<li>A short stay somewhere else, such as a care home, while your carer rests at home.</li>
<li>A holiday together, with paid care carrying on, so your carer does less of the hands-on help.</li>
</ul>

<h2>What doesn't CHC pay for on a break?</h2>
<p>CHC pays for care, not for the place you stay. The national rules say the NHS isn't responsible for rent, food or normal bills. So on a holiday, you'll usually pay for the holiday home, travel and days out yourself.</p>
<p>Local policies spell this out. NHS Sussex, for example, says your usual care carries on while you're away. The holiday itself, though, comes from your own money, including your PA's travel, their room and your travel insurance.</p>

<h2>Can a personal health budget pay for care on holiday?</h2>
<p>Often, yes. Since October 2014, people who get CHC have had a right to a personal health budget. This is the money for your care, and it can pay for care while you're away if your ICB agrees.</p>
<p>There are three ways to hold a personal health budget:</p>
<ul>
<li>The ICB keeps the money and arranges your care.</li>
<li>Another organisation manages the money for you.</li>
<li>You take it as a direct payment, choose your own PAs and keep a record of spending.</li>
</ul>
<p>In Kent, NHS Kent and Medway uses personal health budgets as the usual way to arrange CHC care at home. Wherever you live, the budget can't pay for things like alcohol, tobacco, gambling or debts.</p>

<h2>How do you get CHC?</h2>
<p>A nurse, doctor, social worker or other professional starts with a short checklist. If that suggests you might qualify, a team of at least two professionals does a full assessment. The decision should usually come within 28 days.</p>
<p>Once you're eligible, your care is normally reviewed after three months, and then at least once a year. It's worth asking about breaks at each review, because your carer's needs can change too.</p>

<h2>What should you ask your CHC team?</h2>
<p>Ask about the care, not the holiday. Tell your CHC team where you'd like to go, for how long and what help you'll need. Then ask what they'll fund, and get the answer in writing.</p>
<ul>
<li>Can my usual care carry on while I'm away?</li>
<li>Can my carer have a break, and how many days a year does that cover?</li>
<li>Can my PA or agency come with me, or can I use an agency near where I'm staying?</li>
<li>Do I need to tell you before I travel, and how far ahead?</li>
<li>Who do we call out of hours if something changes while we're away?</li>
</ul>

<h2>Practical steps before you book</h2>
<ul>
<li>Tell your ICB your dates early, and say whether your PA is coming with you.</li>
<li>Check with your GP or nurse that the trip suits you.</li>
<li>Get travel insurance that covers your health, and any PA who travels with you.</li>
<li>Send the holiday home's access details to whoever plans your care, so the equipment matches.</li>
<li>Get written quotes for the stay and for any care you book there.</li>
</ul>

<h2>Common mistakes to avoid</h2>
<ul>
<li>Expecting CHC to pay for the holiday home itself.</li>
<li>Booking before the ICB has agreed the care in writing.</li>
<li>Forgetting insurance for a PA who travels with you.</li>
<li>Setting off without an out-of-hours number for the trip.</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>Does CHC pay for a holiday?</h3>
<p>No. CHC pays for care, not the holiday itself. Your usual care can often carry on while you're away, but you pay for the stay, travel and food.</p>
<h3>Who decides on CHC respite?</h3>
<p>Your integrated care board, or ICB. ICBs replaced clinical commissioning groups in July 2022. Your care coordinator is usually the best person to ask.</p>
<h3>Can I get NHS respite without CHC?</h3>
<p>Sometimes. The NHS can pay for respite health care as part of a joint package with your council. It has to be part of your assessment and care plan, so ask whoever coordinates your care.</p>
<h3>Can my carer get a carer's assessment too?</h3>
<p>Yes, the council must assess any carer who seems to need support, even if you get CHC. It can help with things CHC doesn't cover, such as their work or free time. Our guide to <a href=\"{$carers}\">respite for carers</a> explains how to ask.</p>
<h3>Where can I get free advice on CHC?</h3>
<p>Beacon gives free, independent advice on NHS Continuing Healthcare. You can call them on 0345 548 0300.</p>

<h2>Using CHC funding at Restwell</h2>
<p>Restwell is a private, adapted bungalow in Whitstable, and some of our guests have their care paid for through CHC. Plenty of guests bring their own PAs or agency staff, and a carer can have the second double bedroom.</p>
<p>Your care team can check the <a href=\"{$access}\">the bungalow's door widths, bed heights and hoist limits</a> before you book. If you'd like care from our sister company, Continuity of Care Services, they'll talk through what's needed.</p>
<p>Continuity will then give you a quote to show your ICB. Read more about <a href=\"{$care}\">how care from Continuity works</a>.</p>

<h2>Closing</h2>
<p>We can send a written quote for the stay as well. <a href=\"{$enquire}\">Ask us for a quote for your ICB</a>, with the dates you have in mind.</p>";
}

/**
 * Hiring mobility equipment for a UK break.
 *
 * @return string
 */
function restwell_get_blog_post_hire_mobility_equipment_uk_html() {
	$blog      = esc_url( home_url( '/blog/' ) );
	$checklist = esc_url( home_url( '/how-to-choose-accessible-self-catering-holiday/' ) );
	$pack      = esc_url( home_url( '/what-to-pack-accessible-self-catering-uk/' ) );
	$ins       = esc_url( home_url( '/travel-insurance-disability-uk-self-catering/' ) );
	$enq       = esc_url( home_url( '/enquire/' ) );

	return "<blockquote><p><strong>TL;DR:</strong> Treat hired scooters, profiling beds, and shower chairs like medical logistics: confirm door widths, charging points, delivery windows, and who carries liability if kit fails. Book early in peak season and photograph condition sheets before anyone signs.</p></blockquote>

<h2>What is mobility equipment hire on holiday?</h2>
<p>It is short-term rental of aids from NHS wheelchair services partners or private firms, delivered to a cottage or collected from a depot.</p>

<h2>Why hire decisions trip people up</h2>
<p>Coastal humidity affects batteries; narrow terraces block turning circles; overnight charging sockets sit on the wrong wall. The rental sheet says \"delivered\"; it rarely says \"fitted around your hoist track\".</p>

<h2>How to match kit to property geometry</h2>
<h3>Scooters and powerchairs</h3>
<p>Ask for tyre width, folded length, and ramp gradient limits. Compare against thresholds on the <a href=\"{$checklist}\">property checklist</a>.</p>
<h3>Bathroom aids</h3>
<p>Seat heights must align with transfer technique; rental PVC differs from home moulded seats.</p>
<h3>Beds and mattresses</h3>
<p>Profiling hire must clear ceiling hoist paths already installed.</p>

<h2>Hire versus bring-from-home</h2>
<table>
<caption>Choose hire when transport risk outweighs familiarity</caption>
<thead><tr><th scope=\"col\">Factor</th><th scope=\"col\">Hire locally</th><th scope=\"col\">Bring your own</th></tr></thead>
<tbody>
<tr><th scope=\"row\">Airline or van damage risk</th><td>Often safer for heavy frames</td><td>You know sanitisation history</td></tr>
<tr><th scope=\"row\">Setup time</th><td>Vendor should assemble</td><td>Faster if already dialled in</td></tr>
<tr><th scope=\"row\">Insurance</th><td>Read hire excess clauses</td><td>Check home policy extends away</td></tr>
<tr><th scope=\"row\">Peak season</th><td>Stock runs out fast</td><td>No waiting lists</td></tr>
</tbody>
</table>

<h2>Practical booking checklist</h2>
<ul>
<li>Request serial photos of actual units, not catalogue renders.</li>
<li>Note breakdown helpline hours covering evenings.</li>
<li>Align delivery with someone able to sign and test brakes.</li>
<li>Pack adapters named on the <a href=\"{$pack}\">packing list</a>.</li>
</ul>

<h2>Common mistakes</h2>
<ul>
<li>Waiting until the week before August bank holiday.</li>
<li>Ignoring battery cooling rules after beach humidity.</li>
<li>Letting informal deposits bypass VAT receipts commissioners need.</li>
<li>Skipping compatibility checks with rental shower chairs and grab rails.</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>Does NHS wheelchair services cover Kent holidays?</h3>
<p>Some regions loan vacation kits; others refuse outside boundaries. Phone before you promise anyone.</p>
<h3>Who fixes a flat tyre on hire?</h3>
<p>The contract spells roadside repair or swap-out; keep that PDF on your phone.</p>
<h3>Can I hire a hoist?</h3>
<p>Mobile gantry hires exist but need ceiling assessments; ceiling tracks are property-fixed.</p>
<h3>Should I tell insurers?</h3>
<p>Yes. See our <a href=\"{$ins}\">insurance primer</a> for wording tips.</p>
<h3>What if equipment arrives damaged?</h3>
<p>Refuse sign-off, photograph scrapes, demand replacement before transfer attempts.</p>

<h2>Closing</h2>
<p>Hire adds flexibility when homework is dull. Read more on the <a href=\"{$blog}\">blog</a> and <a href=\"{$enq}\">tell us</a> what kit must marry our published dimensions.</p>";
}

/**
 * Accessible rail travel to Whitstable and Kent.
 *
 * @return string
 */
function restwell_get_blog_post_accessible_train_whitstable_kent_html() {
	$blog  = esc_url( home_url( '/blog/' ) );
	$area  = esc_url( home_url( '/whitstable-area-guide/' ) );
	$park  = esc_url( home_url( '/accessible-parking-whitstable-tankerton/' ) );
	$hire  = esc_url( home_url( '/hire-mobility-scooter-equipment-uk-holiday/' ) );
	$enq   = esc_url( home_url( '/enquire/' ) );

	return "<blockquote><p><strong>TL;DR:</strong> Southeastern trains serve Whitstable from London Victoria and high-speed links via St Pancras; accessibility means booking assistance ahead, knowing platform gaps, and planning onward taxis if station lifts fail. Carry a printed itinerary because rural signal drops surprise apps.</p></blockquote>

<h2>What counts as accessible train travel here?</h2>
<p>Accessible train travel is booked assistance plus rolling-stock features such as wheelchair bays, tactile strips, and ramp deployment agreed at least the night before travel where operators require notice.</p>

<h2>Why coastal hops still bruise plans</h2>
<p>Replacement buses erase step-free routes. Short platforms sometimes limit carriage positions. Powerchair users face tighter turning space on older rolling stock.</p>

<h2>How the journey segments break down</h2>
<h3>London to Whitstable</h3>
<p>High-speed services trim time but not always staff availability at smaller stations.</p>
<h3>Kent hops</h3>
<p>Connections through Faversham or Ramsgate need lift maps checked when changing platforms.</p>
<h3>Last mile</h3>
<p>Station forecourts slope; pre-book accessible taxis on race days and oyster-popular weekends.</p>

<h2>Operator asks versus DIY</h2>
<table>
<caption>Know what assistance promises cover</caption>
<thead><tr><th scope=\"col\">Need</th><th scope=\"col\">Booked Passenger Assist</th><th scope=\"col\">Turn-up-and-go limits</th></tr></thead>
<tbody>
<tr><th scope=\"row\">Ramp onto train</th><td>Staff meet with timeline</td><td>May wait if unbooked</td></tr>
<tr><th scope=\"row\">Station wheelchair when yours breaks</th><td>Subject to depot stock</td><td>Not guaranteed</td></tr>
<tr><th scope=\"row\">Companion seat</th><td>Reserve adjacent bay</td><td>Peak trains fill fast</td></tr>
<tr><th scope=\"row\">Step-free entire route</th><td>Ask for map PDF</td><td>Engineering diverts break promises</td></tr>
</tbody>
</table>

<h2>Practical steps</h2>
<ol>
<li>Book assistance when you buy tickets or at least 24 hours ahead.</li>
<li>Download station layouts from National Rail Enquiries.</li>
<li>Charge backup battery packs; USB sockets vary by train.</li>
<li>Pair rail with <a href=\"{$park}\">local parking plans</a> if someone meets you by car.</li>
</ol>

<h2>Common mistakes</h2>
<ul>
<li>Assuming every Whitstable departure uses the same door gap.</li>
<li>Forgetting medication schedules across delayed legs.</li>
<li>Blocking wheelchair bays with suitcases.</li>
<li>Skipping <a href=\"{$hire}\">local hire</a> backup if your chair fails en route.</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>Are all Whitstable platforms step-free?</h3>
<p>Layout changes with engineering; verify on the day via operator alerts.</p>
<h3>Can I stay seated in my powerchair?</h3>
<p>Yes when designated bays exist; alternatively use onboard wheelchair storage policies.</p>
<h3>Do carers travel free?</h3>
<p>Some operators issue companion passes; ask when booking assistance.</p>
<h3>What if assistance no-shows?</h3>
<p>Use station help points and note staff names for compensation claims.</p>
<h3>Where is local orientation?</h3>
<p>Use our <a href=\"{$area}\">Whitstable area guide</a> after you arrive.</p>

<h2>Closing</h2>
<p>Rails work when paperwork leads. Explore <a href=\"{$blog}\">more guides</a> and <a href=\"{$enq}\">ask Restwell</a> about station pickup timing.</p>";
}

/**
 * Travel insurance and disability (UK self-catering primer).
 *
 * @return string
 */
function restwell_get_blog_post_travel_insurance_disability_uk_html() {
	$blog = esc_url( home_url( '/blog/' ) );
	$res  = esc_url( home_url( '/funding-and-support/' ) );
	$hire = esc_url( home_url( '/hire-mobility-scooter-equipment-uk-holiday/' ) );
	$enq  = esc_url( home_url( '/enquire/' ) );

	return "<blockquote><p><strong>TL;DR:</strong> Standard policies often cap mobility equipment value or exclude unattended vans. Read Schedule coverage for wheelchairs, hoist damage, and cancellation due to hospital admission. This article is practical guidance, not legal advice; confirm wording with a broker.</p></blockquote>

<h2>What is disability-aware travel insurance?</h2>
<p>It is a policy where you declare equipment, pre-existing conditions, and likely cancellation triggers so claims teams cannot reject on non-disclosure grounds.</p>

<h2>Why claims fail for UK breaks</h2>
<p>People assume \"UK travel\" equals \"zero paperwork\". Equipment stolen from a beach hut still needs crime numbers. Cancellation because a PA drops out may fall outside narrow illness clauses.</p>

<h2>How policies differ on kit</h2>
<table>
<caption>Compare headings in the policy schedule before paying</caption>
<thead><tr><th scope=\"col\">Scenario</th><th scope=\"col\">Watch for</th><th scope=\"col\">Ask broker</th></tr></thead>
<tbody>
<tr><th scope=\"row\">Wheelchair in car boot theft</th><td>Vehicle unattended clauses</td><td>Proof of forced entry</td></tr>
<tr><th scope=\"row\">Hired scooter damage</th><td>Hire excess overlap</td><td>Who pays first pound</td></tr>
<tr><th scope=\"row\">Trip cut short</th><td>Curtainment wording</td><td>Medical certification timing</td></tr>
<tr><th scope=\"row\">Carer illness</th><td>Named traveller definitions</td><td>Whether PA counts as insured party</td></tr>
</tbody>
</table>

<h2>Evidence to gather before travel</h2>
<h3>Valuations</h3>
<p>Receipts or OT letters stating replacement cost.</p>
<h3>Photos</h3>
<p>Timestamp equipment condition.</p>
<h3>Medication list</h3>
<p>Matches prescribing clinician records.</p>

<h2>Practical steps</h2>
<ul>
<li>Compare three specialist insurers alongside mainstream brands.</li>
<li>Email written confirmations of coverage for hoists and hired beds.</li>
<li>Store insurer helplines offline.</li>
<li>Align hire contracts with <a href=\"{$hire}\">equipment hire</a> guidance.</li>
</ul>

<h2>Common mistakes</h2>
<ul>
<li>Ticking \"no conditions\" to save ten minutes online.</li>
<li>Forgetting to insure hired kit separately.</li>
<li>Relying on home contents cover without away-from-home limits.</li>
<li>Ignoring excess stacking between policies.</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>Does EHIC replace insurance?</h3>
<p>No for equipment or cancellations; it supports emergency healthcare abroad only.</p>
<h3>Will NHS continuing care void insurance?</h3>
<p>Declare funded care openly; hiding funding risks claims.</p>
<h3>Are beach injuries covered?</h3>
<p>Depends on hazardous activity clauses; read exclusions literally.</p>
<h3>Can I insure a hired WAV?</h3>
<p>Often via hire firm's CDW; confirm duplication before buying extras.</p>
<h3>Who helps if wording is vague?</h3>
<p>Use charity helplines plus our <a href=\"{$res}\">resources hub</a> for funding context.</p>

<h2>Closing</h2>
<p>Insurance rewards boring paperwork. Continue on the <a href=\"{$blog}\">blog</a> and <a href=\"{$enq}\">talk to us</a> about property risks we publish upfront.</p>";
}

/**
 * Respite under the Care Act 2014 (Batch D, 26 Oct 2026). The slug is the
 * older personal budget guide's, kept so existing links still work.
 *
 * @return string
 */
function restwell_get_blog_post_personal_budget_short_break_html() {
	$funding = esc_url( home_url( '/funding-and-support/' ) );
	$dp      = esc_url( home_url( '/direct-payment-holiday-accommodation/' ) );
	$care    = esc_url( home_url( '/optional-care/' ) );
	$enquire = esc_url( home_url( '/enquire/' ) );
	$chc     = esc_url( home_url( '/chc-respite-holiday-accommodation-uk/' ) );

	return "<blockquote><p><strong>TL;DR:</strong> The Care Act 2014 doesn't promise a set amount of respite. It gives you and your carer a right to be assessed, and makes the council meet eligible needs. A break is one way to meet them.</p></blockquote>

<h2>What does the Care Act 2014 say about respite?</h2>
<p>The Care Act 2014 never uses the word respite. Instead, it gives people a right to be assessed, and makes councils meet any eligible needs. The official guidance calls a break \"replacement care\", which means care for you, so your carer can rest.</p>
<p>Replacement care can be a few hours at home, regular nights or a longer stay elsewhere. The guidance gives examples, such as a carer getting to their own health appointments. It also mentions catching up on sleep, or taking a longer break from caring.</p>
<p>This guide covers the rules in England. Our guide to <a href=\"{$funding}\">funding a break, from grants to the NHS</a>, covers the other ways to pay.</p>

<h2>Who has a right to an assessment?</h2>
<p>The person who needs care can ask for a needs assessment, and their carer can ask for a carer's assessment. The council must assess anyone who appears to need support. That's true whatever their money, and whether or not they'll qualify.</p>
<p>The two assessments can be done together or apart. A carer's assessment must look at whether the carer can and wants to keep caring. It must also look at their work, learning and free time.</p>

<h2>When does the council have to provide a break?</h2>
<p>Only when there are eligible needs, and national rules set out what counts. For the person who needs care, the council checks two things.</p>
<p>First, it asks whether they can't manage two or more everyday things, such as washing, eating or getting out. Then it asks whether that has a big effect on their wellbeing.</p>
<p>For a carer, it asks whether caring puts their health at risk or stops them doing things that matter. That might be work, learning, seeing friends or time to themselves. Again, it must have a big effect on their wellbeing.</p>
<p>If either of you has eligible needs, the council must meet them. A break might be part of the answer. That's agreed in the care and support plan, or the carer's support plan.</p>

<h2>How can the council arrange a break?</h2>
<p>There's no single way, and the plan should fit what you both need. These are the common options.</p>
<ul>
<li><strong>Care at home:</strong> a care worker comes in so your carer can go out or get some sleep.</li>
<li><strong>A stay away:</strong> a short stay in a care home or another setting.</li>
<li><strong>A direct payment:</strong> money you use to arrange the care yourself, such as extra hours from a PA.</li>
<li><strong>Help for the carer:</strong> support aimed at the carer, such as a class or help to stay in work.</li>
</ul>
<p>Direct payments can cover short care home stays: up to four weeks in a row, in any 12 months. The guidance gives a carer's break as one example of what that's for.</p>
<p>A direct payment usually pays for care, though, not for a holiday itself. Our guide on <a href=\"{$dp}\">using direct payments for a holiday</a> explains what that means on a trip.</p>

<h2>Who pays for respite under the Care Act?</h2>
<p>Care that gives a carer a break counts as care for the person who receives it. So if there's a charge, that person pays it, not the carer. The council can also decide not to charge at all.</p>
<p>Any charge depends on a financial assessment of the person getting the care. For care home stays of up to eight weeks, councils can use the rules for care at home.</p>
<p>Councils don't have to charge carers for their own support either. The guidance says that charging carers is often a false economy.</p>

<h2>Can you use a personal budget for a short break?</h2>
<p>Yes, if your plan says a break would meet your needs. Your personal budget is what the council works out it'll cost to meet them. You can take it as a direct payment and arrange the care yourself, or let the council arrange it.</p>
<p>Ask for any break to be written into the plan, with the number of days or hours. That makes it much easier to book with confidence, and to check later what was agreed.</p>

<h2>What if the council says no?</h2>
<p>Ask for the decision and the reasons in writing. If you disagree, use the council's complaints process. If you're still unhappy after that, you can go to the Local Government and Social Care Ombudsman, which is free.</p>
<p>Ask for an independent advocate if you'd find it hard to take part. The council must provide one if you'd struggle to understand or share your views, and nobody suitable can help you.</p>

<h2>Practical steps</h2>
<ul>
<li>Ask for both assessments, and say that a break is one of the things you'd like.</li>
<li>Keep a short diary of a normal week, to show what caring involves.</li>
<li>Ask for your plan in writing, with any breaks it agrees.</li>
<li>If a direct payment will pay for care away from home, get the council's answer before you book.</li>
<li>Ask the council where the person who needs care lives, not the one where you're staying.</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>Am I entitled to respite care?</h3>
<p>Not to a set amount. You're entitled to an assessment, and to have eligible needs met. A break is often how councils meet a carer's needs, but it depends on what the assessment finds.</p>
<h3>What does respite care include?</h3>
<p>It can be care at home, a day centre, a sitting service or a short stay away. It can also be care while you're on holiday, if the council agrees it meets your needs.</p>
<h3>How often should my plan be reviewed?</h3>
<p>The guidance expects a review at least every 12 months. You can ask for one sooner if things change, such as your carer's health or your own.</p>
<h3>Does the Care Act cover children?</h3>
<p>No. For disabled children and parent carers, other laws apply, including the Children and Families Act 2014. Ask your council's children's services about short breaks.</p>
<h3>Does the Care Act apply in Scotland and Wales?</h3>
<p>Its main parts apply in England only. Scotland and Wales have their own laws on care and carers, so check with your council there.</p>
<h3>Can the NHS pay for respite instead?</h3>
<p>Yes, if you get NHS Continuing Healthcare, the NHS pays for your care instead of the council. Our guide to <a href=\"{$chc}\">CHC respite care</a> explains how that works.</p>

<h2>Using a council-funded break at Restwell</h2>
<p>Restwell is a private, adapted bungalow in Whitstable, and some guests come on a break their council has helped with. Often the council's money pays for the care, and the family pays for the stay.</p>
<p>Care can come from your own PAs, or from our sister company, Continuity of Care Services. Continuity will give you a quote to share with your council. Read more about <a href=\"{$care}\">holidays with care from Continuity</a>.</p>

<h2>Closing</h2>
<p>We can also send a written quote for the bungalow. <a href=\"{$enquire}\">Tell us your dates and who the quote is for</a>, and we'll get it to you.</p>";
}
