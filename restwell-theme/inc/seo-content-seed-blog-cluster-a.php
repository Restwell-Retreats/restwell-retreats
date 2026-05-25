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
 * CHC, respite and holiday accommodation (plain English).
 *
 * @return string
 */
function restwell_get_blog_post_chc_respite_holiday_accommodation_html() {
	$blog   = esc_url( home_url( '/blog/' ) );
	$res    = esc_url( home_url( '/resources/' ) );
	$dp     = esc_url( home_url( '/direct-payment-holiday-accommodation/' ) );
	$carers = esc_url( home_url( '/carers-respite-holiday-guide/' ) );
	$enq    = esc_url( home_url( '/enquire/' ) );
	$acc    = esc_url( home_url( '/accessibility/' ) );

	return "<blockquote><p><strong>TL;DR:</strong> NHS Continuing Healthcare (CHC) funds assessed health and care needs; it does not buy holiday cottage rent. Commissioners split invoices so personal care hours, nursing tasks, or agency cover may sit on a health budget while lodging stays a private or social-care line. Get written clarity before anyone signs.</p></blockquote>

<h2>What is CHC in relation to holidays?</h2>
<p>CHC is an NHS-funded package for people whose primary needs are health-led. A holiday changes the postcode, not the principle: eligible care stays eligible when it is documented and agreed.</p>

<h2>Why CHC-funded respite trips stall</h2>
<p>Teams confuse \"respite\" with \"free holiday\". Accommodation is still a market rental unless a specific funded pathway covers it. Families arrive at check-in with unpaid deposits because nobody pinned down who pays the bricks-and-mortar bill versus who pays waking-night cover.</p>

<h2>How funding lines usually split</h2>
<table>
<caption>Typical split between health care spend and lodging (confirm locally)</caption>
<thead><tr><th scope=\"col\">Cost line</th><th scope=\"col\">Often CHC or NHS funded when eligible</th><th scope=\"col\">Usually separate from CHC</th></tr></thead>
<tbody>
<tr><th scope=\"row\">Registered nurse tasks</th><td>May be in package if assessed</td><td>Rarely bundled into cottage rent</td></tr>
<tr><th scope=\"row\">Agency PA hours on trip</th><td>Sometimes via PHB or CHC care plan</td><td>Needs named worker and risk assessment</td></tr>
<tr><th scope=\"row\">Property hire</th><td>Exceptional cases only via agreed panels</td><td>Most often personal, DP, or LA respite rules</td></tr>
<tr><th scope=\"row\">Equipment hire off-site</th><td>If clinically coded</td><td>Often self-funded unless prescribed route exists</td></tr>
</tbody>
</table>

<h2>How panels expect paperwork to read</h2>
<h3>Clinical narrative</h3>
<p>Spell night-time complexity, seizures, tissue viability, or cognition risks that do not pause for weekends.</p>
<h3>Risk assessment for unfamiliar environment</h3>
<p>Show hoist compatibility, emergency egress, and who holds clinical responsibility between providers.</p>
<h3>Budget transparency</h3>
<p>List VAT, mileage, sleep-ins, and cancellation terms on separate lines.</p>

<h2>Practical steps before you book Kent</h2>
<ol>
<li>Ask your CHC coordinator for a written yes-or-no on which invoice lines they can reimburse.</li>
<li>Send the property <a href=\"{$acc}\">access specification</a> to nursing so equipment matches.</li>
<li>Cross-read our <a href=\"{$dp}\">direct payment holiday guide</a> when personal budgets mix with NHS.</li>
<li>Keep unpaid carers in the loop using <a href=\"{$carers}\">respite rights basics</a>.</li>
</ol>

<h2>Common mistakes</h2>
<ul>
<li>Assuming \"NHS number on file\" equals \"full trip funded\".</li>
<li>Booking peak weeks before contingency workers confirm.</li>
<li>Skipping pharmacy transfers for coastal GP coverage.</li>
<li>Mixing CHC and direct payment invoices without ledger codes.</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>Does CHC pay for the cottage?</h3>
<p>Usually no. CHC pays for eligible care. Rent sits elsewhere unless your commissioner explicitly agrees.</p>
<h3>Can we combine CHC hours with direct payments?</h3>
<p>Sometimes, if duplication rules are respected. Ask both teams to countersign the plan.</p>
<h3>Who signs off risk for hoists away from home?</h3>
<p>The accountable clinician or therapist named on the care plan should document sling compatibility.</p>
<h3>What if needs spike mid-stay?</h3>
<p>Call the out-of-hours CHC line your pack lists; keep GP and NHS 111 numbers visible.</p>
<h3>Where do I start locally?</h3>
<p>Open our <a href=\"{$res}\">funding hub</a>, then speak to your coordinator with dates and property facts.</p>

<h2>Closing</h2>
<p>CHC conversations reward specificity. Browse the <a href=\"{$blog}\">blog</a>, gather paperwork, then <a href=\"{$enq}\">contact Restwell</a> if Whitstable fits your clinical brief.</p>";
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
	$res  = esc_url( home_url( '/resources/' ) );
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
 * Commissioner checklist for accessible respite stays.
 *
 * @return string
 */
function restwell_get_blog_post_commissioner_accessible_respite_html() {
	$blog   = esc_url( home_url( '/blog/' ) );
	$acc    = esc_url( home_url( '/accessibility/' ) );
	$access_doc = esc_url( home_url( '/how-to-read-holiday-cottage-access-statement/' ) );
	$dp     = esc_url( home_url( '/direct-payment-holiday-accommodation/' ) );
	$enq    = esc_url( home_url( '/enquire/' ) );

	return "<blockquote><p><strong>TL;DR:</strong> Commissioners defend placements when paperwork proves suitability: hoist SWL, infection-control alignment, sleeping arrangements for waking staff, and cancellation maths. Vague \"accessible bungalow\" lines fail audit; millimetres and named responsibilities pass.</p></blockquote>

<h2>What is commissioner evidence for respite?</h2>
<p>It is the dossier showing how a property meets assessed needs, budgets, and safeguarding rules before public money moves.</p>

<h2>Why panels bounce bookings</h2>
<p>Photos without measurements, informal WhatsApp promises, and unnamed crisis contacts trigger red flags. Panels fear stranded citizens when providers ghost Friday nights.</p>

<h2>Core documents to demand</h2>
<table>
<caption>Minimum pack before approving nights away</caption>
<thead><tr><th scope=\"col\">Document</th><th scope=\"col\">Why it matters</th><th scope=\"col\">Fail signal</th></tr></thead>
<tbody>
<tr><th scope=\"row\">Access statement PDF</th><td>Matches OT goals</td><td>Marketing fluff only</td></tr>
<tr><th scope=\"row\">Equipment service stickers</th><td>Proves hoist LOLER</td><td>Out-of-date inspections</td></tr>
<tr><th scope=\"row\">Sleep-in capacity plan</th><td>Safeguarding</td><td>Sofa-only carer rest</td></tr>
<tr><th scope=\"row\">Insurance certificates</th><td>Public liability</td><td>Expired dates</td></tr>
</tbody>
</table>

<h2>How to read measurements critically</h2>
<h3>Door schedules</h3>
<p>Ask clear opening widths after architrave, not just structural studs.</p>
<h3>Hoist coverage maps</h3>
<p>Overlay sling clip heights against user anthropometrics.</p>
<h3>Emergency egress</h3>
<p>Two routes or documented lone-worker protocol.</p>

<h2>Practical workflow</h2>
<ol>
<li>Request the owner's signed statement alongside OT sign-off.</li>
<li>Cross-check numbers using <a href=\"{$access_doc}\">how to read access statements</a>.</li>
<li>Align invoices with <a href=\"{$dp}\">direct payment rules</a>.</li>
<li>Publish aftercare contacts for out-of-area hospitals.</li>
</ol>

<h2>Common mistakes</h2>
<ul>
<li>Relying on satellite imagery instead of site visits.</li>
<li>Ignoring infection risk when shared aids arrive.</li>
<li>Letting families pay deposits on unofficial cards.</li>
<li>Omitting contingency if agency staff cancel.</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>Do we need a risk assessment per trip?</h3>
<p>Yes when needs or staff mix changes materially.</p>
<h3>Can tele-assessment replace visits?</h3>
<p>Sometimes during pandemic-era policies; confirm locally.</p>
<h3>Who owns safeguarding alerts?</h3>
<p>Name the duty social worker and NHS liaison on the pack.</p>
<h3>What if equipment differs on arrival?</h3>
<p>Halt placement, document variance, invoke contract clauses.</p>
<h3>Where are Restwell specs?</h3>
<p>See <a href=\"{$acc}\">Accessibility</a> then email evidence requests.</p>

<h2>Closing</h2>
<p>Good commissioning is boring and brave. Share this via the <a href=\"{$blog}\">blog</a> internally and <a href=\"{$enq}\">invite Restwell</a> into tender conversations early.</p>";
}

/**
 * Personal budgets and short breaks (Care Act primer).
 *
 * @return string
 */
function restwell_get_blog_post_personal_budget_short_break_html() {
	$blog   = esc_url( home_url( '/blog/' ) );
	$res    = esc_url( home_url( '/resources/' ) );
	$dp     = esc_url( home_url( '/direct-payment-holiday-accommodation/' ) );
	$carers = esc_url( home_url( '/carers-respite-holiday-guide/' ) );
	$chc    = esc_url( home_url( '/chc-respite-holiday-accommodation-uk/' ) );
	$enq    = esc_url( home_url( '/enquire/' ) );

	return "<blockquote><p><strong>TL;DR:</strong> Personal budgets under the Care Act buy outcomes agreed in care plans, not wish lists. Short breaks succeed when nights, PA hours, transport, and accommodation lines sit on separate ledger codes with social worker sign-off. Document everything before you spend.</p></blockquote>

<h2>What is a personal budget short break?</h2>
<p>It is a slice of allocated social-care money used to purchase respite outcomes such as sitting services, transport, or PA coverage while someone rests away from home.</p>

<h2>Why panels argue over receipts</h2>
<p>Blurry invoices that lump \"holiday package\" scare auditors. Care Act accountability expects identifiable services tied to eligible needs.</p>

<h2>Budget components to separate</h2>
<table>
<caption>Keep columns distinct for audit defence</caption>
<thead><tr><th scope=\"col\">Spend type</th><th scope=\"col\">Often allowed when plan says so</th><th scope=\"col\">Usually scrutinised</th></tr></thead>
<tbody>
<tr><th scope=\"row\">PA overnight</th><td>Named hours</td><td>Unplanned overtime</td></tr>
<tr><th scope=\"row\">Travel mileage</th><td>Agreed rates</td><td>First-class upgrades</td></tr>
<tr><th scope=\"row\">Accommodation</th><td>Via LA respite rules</td><td>Luxury upsells</td></tr>
<tr><th scope=\"row\">Activities</th><td>If wellbeing goal</td><td>Generic entertainment</td></tr>
</tbody>
</table>

<h2>How to prepare conversations</h2>
<h3>Care plan quotes</h3>
<p>Highlight sentences backing travel.</p>
<h3>Market comparisons</h3>
<p>Show three quotes for similar accessibility.</p>
<h3>Carer testimony</h3>
<p>Link to <a href=\"{$carers}\">carer assessment guidance</a>.</p>

<h2>Practical steps</h2>
<ul>
<li>Book a review meeting before peak holiday pricing.</li>
<li>Use prepaid cards if your LA mandates traceability.</li>
<li>Split NHS versus LA funding using <a href=\"{$chc}\">CHC basics</a> where dual packages exist.</li>
<li>Pair with <a href=\"{$dp}\">direct payment detail</a> for invoice wording.</li>
</ul>

<h2>Common mistakes</h2>
<ul>
<li>Spending first and requesting retrospective approval.</li>
<li>Using emergency credit cards without clarity who reimburses.</li>
<li>Ignoring annual budget refresh dates.</li>
<li>Forgetting to log informal family support hours.</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>Can I buy flights with social care money?</h3>
<p>Only if explicitly agreed; many councils forbid.</p>
<h3>Does personal budget replace disability benefits?</h3>
<p>No; different statutes govern each stream.</p>
<h3>Can unused respite roll over?</h3>
<p>Local policy decides; ask in writing.</p>
<h3>Who audits spends?</h3>
<p>LA fraud teams sample receipts randomly.</p>
<h3>Where is broader funding context?</h3>
<p>Open the <a href=\"{$res}\">resources hub</a>.</p>

<h2>Closing</h2>
<p>Budgets reward planners. Explore the <a href=\"{$blog}\">blog</a> and <a href=\"{$enq}\">enquire</a> when Whitstable matches your plan lines.</p>";
}
