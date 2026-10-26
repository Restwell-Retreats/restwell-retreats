<?php
/**
 * Additional seeded blog post HTML (cluster B: posts 7–12 of 12).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Accessible eating out near Whitstable.
 *
 * @return string
 */
function restwell_get_blog_post_accessible_eating_out_whitstable_html() {
	$blog   = esc_url( home_url( '/blog/' ) );
	$area   = esc_url( home_url( '/whitstable-area-guide/' ) );
	$park   = esc_url( home_url( '/accessible-parking-whitstable-tankerton/' ) );
	$cp     = esc_url( home_url( '/changing-places-toilets-kent-coast-days-out/' ) );
	$quiet  = esc_url( home_url( '/quieter-times-whitstable-low-crowd-access/' ) );
	$enq    = esc_url( home_url( '/enquire/' ) );

	return "<blockquote><p><strong>TL;DR:</strong> Eating out well means checking step-free entries, indoor circulation space, accessible toilets (Changing Places where relevant), and whether staff handle allergy cards calmly. Whitstable gets crowded; weekday lunches beat harbour sunsets for seating choice.</p></blockquote>

<h2>What is accessible dining on the Kent coast?</h2>
<p>Accessible dining is choosing venues where you can enter, use the loo, hear orders, and eat without improvising unsafe transfers.</p>

<h2>Why harbour crowds change access</h2>
<p>Aisle chairs disappear, temporary queues spill onto cambers, and outdoor heaters narrow gaps. Friday oysters draw standing crowds that block visibility lines for deaf diners.</p>

<h2>How to vet a venue before you commit</h2>
<h3>Entrance and threshold</h3>
<p>Ask for photos of the actual door lip, not street view from 2019.</p>
<h3>Toilet route</h3>
<p>Confirm whether WC is on the same level as seating.</p>
<h3>Menus</h3>
<p>Large print or QR alternatives reduce fatigue.</p>

<h2>Harbour versus side-street trade-offs</h2>
<table>
<caption>Pick what matches your priority today</caption>
<thead><tr><th scope=\"col\">Priority</th><th scope=\"col\">Harbour strip</th><th scope=\"col\">Side streets</th></tr></thead>
<tbody>
<tr><th scope=\"row\">Level approach</th><td>Busier, often paved</td><td>Check kerbs each block</td></tr>
<tr><th scope=\"row\">Noise control</th><td>Loud gulls and music</td><td>Usually calmer</td></tr>
<tr><th scope=\"row\">Parking proximity</th><td>See <a href=\"{$park}\">parking guide</a></td><td>May mean longer roll</td></tr>
<tr><th scope=\"row\">Changing Places nearby</th><td>Map via <a href=\"{$cp}\">CP guide</a></td><td>Plan route before ordering</td></tr>
</tbody>
</table>

<h2>Practical steps</h2>
<ol>
<li>Phone ahead with honest chair dimensions.</li>
<li>Book <a href=\"{$quiet}\">off-peak slots</a> when cognitive fatigue matters.</li>
<li>Save accessibility notes in Euan's Guide or similar when you learn facts.</li>
<li>Use our <a href=\"{$area}\">area guide</a> for context.</li>
</ol>

<h2>Common mistakes</h2>
<ul>
<li>Trusting \"a small step only\" from reception teens.</li>
<li>Skipping dessert because toilets sit upstairs unmentioned.</li>
<li>Forgetting medication timing around delayed courses.</li>
<li>Assuming every seafood spot takes cards offline.</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>Do pubs legally need Changing Places?</h3>
<p>No; standard accessible WCs differ. Ask measurements.</p>
<h3>Can I bring a hospital-profile chair inside?</h3>
<p>Ask width; some Grade II listings have narrow passages.</p>
<h3>Are dogs allowed everywhere?</h3>
<p>Varies; assistance dogs have separate equality duties.</p>
<h3>Who lists accurate access info?</h3>
<p>Cross-check AccessAble and recent visitor photos.</p>
<h3>What if reviews lie?</h3>
<p>Vote with spend elsewhere and leave factual feedback.</p>

<h2>Closing</h2>
<p>Good meals anchor trips. Read the <a href=\"{$blog}\">blog</a> and <a href=\"{$enq}\">tell us</a> if you want Restwell dinner recommendations after check-in.</p>";
}

/**
 * Changing Places and accessible toilets Kent coast.
 *
 * @return string
 */
function restwell_get_blog_post_changing_places_kent_coast_html() {
	$blog   = esc_url( home_url( '/blog/' ) );
	$beach  = esc_url( home_url( '/accessible-beaches-coastal-walks-kent/' ) );
	$dining = esc_url( home_url( '/accessible-eating-out-whitstable-kent/' ) );
	$enq    = esc_url( home_url( '/enquire/' ) );

	return "<blockquote><p><strong>TL;DR:</strong> Changing Places toilets add hoist, bench, and space beyond Part M minimums; standard accessible loos still matter for quick stops. Plan Kent coast days by mapping facilities before you leave, because miles of promenade separate usable toilets.</p></blockquote>

<h2>What is a Changing Places toilet?</h2>
<p>A Changing Places toilet is a large hygiene room with ceiling hoist, adult changing bench, centrally placed toilet, and space for two carers.</p>

<h2>Why coastal miles expose gaps</h2>
<p>Seaside paths feel endless until someone needs a bench hoist. Seasonal kiosks rarely upgrade plumbing mid-summer.</p>

<h2>How standard accessible loos differ</h2>
<table>
<caption>Match expectation to facility type</caption>
<thead><tr><th scope=\"col\">Feature</th><th scope=\"col\">Typical accessible WC</th><th scope=\"col\">Changing Places</th></tr></thead>
<tbody>
<tr><th scope=\"row\">Ceiling hoist</th><td>Rare</td><td>Required spec</td></tr>
<tr><th scope=\"row\">Changing bench</th><td>Baby units only</td><td>Rated load stated</td></tr>
<tr><th scope=\"row\">Turning circle</th><td>Often tight</td><td>Regulated dimensions</td></tr>
<tr><th scope=\"row\">Radar lock</th><td>Common</td><td>Bring key</td></tr>
</tbody>
</table>

<h2>Planning a day out</h2>
<h3>Morning anchor</h3>
<p>Start from a known CP site, then roll outward.</p>
<h3>Emergency backup</h3>
<p>Note hospitals with public access hours.</p>
<h3>Beach legs</h3>
<p>Pair toilet timing with <a href=\"{$beach}\">beach realism</a>.</p>

<h2>Practical steps</h2>
<ul>
<li>Download the national CP map offline.</li>
<li>Carry sling if you rely on unfamiliar hoist clips.</li>
<li>Phone attractions to confirm winter maintenance closures.</li>
<li>Align meal breaks with <a href=\"{$dining}\">dining picks</a>.</li>
</ul>

<h2>Common mistakes</h2>
<ul>
<li>Assuming Blue Badge parking equals toilet access inside venues.</li>
<li>Skipping cleaning time between users during viral season.</li>
<li>Forgetting radar keys on day trips.</li>
<li>Letting teenagers shoulder hoist transfers untrained.</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>Are Changing Places free?</h3>
<p>Usually yes inside venues; some charge radar-entry sites.</p>
<h3>Can families without disabilities use CP rooms?</h3>
<p>Priority goes to those who need the equipment; respect signage.</p>
<h3>Do all Kent beaches have loos?</h3>
<p>Seasonal blocks vary; winter hours shrink.</p>
<h3>What if hoist weight limit is low?</h3>
<p>Do not force transfers; find another facility.</p>
<h3>Who updates maps?</h3>
<p>Charities and councils; verify on the day.</p>

<h2>Closing</h2>
<p>Toilet planning is dignity planning. Continue on the <a href=\"{$blog}\">blog</a> and <a href=\"{$enq}\">ask Restwell</a> about on-property wet-room specs.</p>";
}

/**
 * The best time to visit Whitstable (Batch F, 26 Oct 2026): busy and quiet
 * times, oyster season and the festival. Event dates are as of 2026.
 *
 * @return string
 */
function restwell_get_blog_post_quieter_whitstable_visit_html() {
	$area    = esc_url( home_url( '/whitstable-area-guide/' ) );
	$parking = esc_url( home_url( '/accessible-parking-whitstable-tankerton/' ) );
	$pricing = esc_url( home_url( '/pricing/' ) );
	$enquire = esc_url( home_url( '/enquire/' ) );

	return "<blockquote><p><strong>TL;DR:</strong> For a calmer visit, come midweek outside the school holidays, especially in spring or early autumn. Summer is the warmest time but also the busiest. Native oysters are in season from September, which is also when the oyster festival takes place.</p></blockquote>

<h2>When is the best time to visit Whitstable?</h2>
<p>It depends on what matters most to you. For quieter streets and easier parking, come midweek outside the school holidays. For the warmest weather, come in July or August, and expect the town to be busy.</p>
<p>Spring and early autumn are a good middle ground. The days are often mild, the promenade is calmer, and it's easier to find a table for lunch. Our Whitstable guide lists <a href=\"{$area}\">the routes and cafés we know work</a>.</p>

<h2>When is Whitstable at its busiest?</h2>
<p>Sunny weekends and the school holidays bring the most visitors, especially in summer. The harbour and the High Street get crowded, and the car parks fill early. A few big events add to that.</p>
<ul>
<li><strong>Whitstable Carnival:</strong> a Saturday in early August, with a procession from Tankerton Road to Saddleton Road.</li>
<li><strong>Harbour Day:</strong> a Saturday in the middle of August.</li>
<li><strong>The Whitstable Rocks Oyster Festival:</strong> three days in September, across the harbour, the beach and the town.</li>
</ul>
<p>In Kent, the school summer holiday in 2027 runs from 22 July to 31 August. There are also half-terms in February, late May and late October.</p>

<h2>When is Whitstable at its quietest?</h2>
<p>Midweek outside the school holidays is usually the calmest time. Early mornings are quieter too, before most day visitors arrive.</p>
<p>Winter is the quietest season of all. It's colder and windier by the sea, but there's more space on the promenade. Some places shorten their hours, so check opening times before a special trip.</p>

<h2>When are Whitstable oysters in season?</h2>
<p>Native oysters are in season from September to April, in the months with an R. Rock oysters are farmed and served all year round, so you can try one whenever you visit.</p>
<p>The Whitstable Rocks Oyster Festival takes place over three days in September. Many of its events are free, and the town gets very busy, so plan your parking ahead.</p>

<h2>What is Whitstable like in each season?</h2>
<ul>
<li><strong>Spring:</strong> milder days and calmer weekdays, though the Easter holidays are busy.</li>
<li><strong>Summer:</strong> the warmest weather and longest days, and the most visitors, especially in August.</li>
<li><strong>Autumn:</strong> often still mild in September, with the oyster festival, and calmer once the schools go back.</li>
<li><strong>Winter:</strong> the quietest time, with cold winds off the sea and shorter opening hours.</li>
</ul>

<h2>Tips for a calmer visit</h2>
<ul>
<li>Arrive early on sunny weekends, when parking near the seafront goes quickly.</li>
<li>Book a table for lunch, or eat a little earlier or later than most people.</li>
<li>Check event dates before you book your stay.</li>
<li>Use Tankerton's promenade for a quieter walk, as it's long, level and surfaced.</li>
<li>Check the forecast for wind as well as rain, as it can be strong by the sea.</li>
</ul>
<p>Our guide to <a href=\"{$parking}\">Blue Badge parking in Whitstable</a> covers the car parks and the free time a badge gives you.</p>

<h2>Does Restwell cost more at busy times?</h2>
<p>A little. Peak rates apply in the school holidays, and the rest of the year is off-peak. A week is £1,300 off-peak and £1,400 in peak season.</p>
<p>Weekend nights cost a bit more than weeknights, and you can stay for one night or a whole week. Our <a href=\"{$pricing}\">rates and peak dates</a> are all on one page.</p>

<h2>Frequently asked questions</h2>
<h3>Is Whitstable worth visiting?</h3>
<p>Yes, if you enjoy the sea, seafood and a slower pace. Tankerton's promenade is long, level and surfaced, and the harbour is step-free. The beach itself is shingle, though.</p>
<h3>How busy is Whitstable on a summer weekend?</h3>
<p>Very busy, especially around the harbour and the High Street. Arrive early, or head to Tankerton for more space.</p>
<h3>What is Whitstable like in winter?</h3>
<p>It's quiet, cold and often windy. There's more room on the promenade, but some places open for shorter hours.</p>
<h3>When is the Whitstable oyster festival?</h3>
<p>The Whitstable Rocks Oyster Festival is held in September. In 2026, it ran from 11 to 13 September, so check the festival's website for the next dates.</p>

<h2>Staying at Restwell</h2>
<p>Restwell is a private, adapted bungalow in Whitstable, with a ceiling track hoist and a level wet room. Out of season, you can enjoy a quiet town and come back to your own hoist and wet room.</p>

<h2>Closing</h2>
<p>If you're weighing up dates, <a href=\"{$enquire}\">ask us which weeks are free</a>, and we'll help you choose.</p>";
}

/**
 * How to read a holiday cottage access statement.
 *
 * @return string
 */
function restwell_get_blog_post_read_access_statement_html() {
	$enquire       = esc_url( home_url( '/enquire/' ) );
	$accessibility = esc_url( home_url( '/accessibility/' ) );

	return "<blockquote><p><strong>TL;DR:</strong> Measure your own chair first, at its widest point. Then compare it with the clear opening of each door, not the size of the door itself. Check the turning space, bed height and hoist too, and ask the owner for anything that's missing.</p></blockquote>

<h2>Can a wheelchair fit through a 900mm door?</h2>
<p>Usually, yes, but check what the 900mm refers to. If it's the clear opening, most wheelchairs will fit with room to spare. If it's the width of the door itself, the frame and the open door leave a narrower gap.</p>
<p>The gap you can actually use is called the clear opening. Building guidance in England treats a standard 826mm door as giving a clear opening of 775mm. That's why it's worth asking for the clear opening in millimetres and comparing it with your chair.</p>

<h2>How wide should a door be for a wheelchair?</h2>
<p>For homes built for wheelchair users, the building guidance asks for at least 850mm of clear opening at every door. In ordinary homes, an inside door can be as narrow as 750mm, depending on the hallway. A holiday cottage could be either, so ask.</p>
<p>The width of the hallway matters too. Turning through a narrow door from a narrow hall is much harder than going straight in. If a door is tight, ask how wide the hall is in front of it.</p>

<h2>How do I measure my wheelchair?</h2>
<p>Measure across the widest point, which is usually the wheels or the push rims. If you propel yourself, leave room for your hands. Measure the length too, from the back of the chair to the front of the footplates, because it affects turning.</p>
<p>Write the measurements down and keep them on your phone, so you can check any listing in a minute. To try it, compare them with <a href=\"{$accessibility}\">our own door widths, hoist ratings and bed heights</a>.</p>

<h2>What is an access statement?</h2>
<p>An access statement is a written guide to how easy a place is to reach, enter and move around. It should give real measurements, not just words like \"accessible\". VisitEngland now calls these documents accessibility guides, but many owners still use the older name.</p>
<p>There's no single legal format for a holiday let. VisitEngland recommends a detailed guide produced by AccessAble, whose surveyors visit and measure. However, many owners write their own, so the quality varies a lot.</p>

<h2>What should an access statement tell you?</h2>
<p>A good one takes you from the car park to the bed, with a measurement at each stage. If a section is missing, that's a question to ask the owner. Don't assume something is fine just because it isn't mentioned.</p>
<ul>
<li><strong>Getting there:</strong> where you park, the surface, and any slopes, steps or kerbs.</li>
<li><strong>Doors:</strong> the clear opening of every door, and any lip at the threshold.</li>
<li><strong>Turning space:</strong> room to turn in the bedroom and bathroom. Building guidance for wheelchair users' homes allows a 1500mm turning circle.</li>
<li><strong>The bathroom:</strong> whether the shower is level, where the rails are, and what you'd sit on.</li>
<li><strong>The bed:</strong> its lowest and highest heights, and the space beside it. The same guidance allows 1000mm.</li>
<li><strong>The hoist:</strong> its type, make and model, its safe working load, and which rooms it reaches.</li>
<li><strong>Photos:</strong> whole rooms, taken from the doorway, not just close-ups.</li>
</ul>

<h2>How do I check a hoist will work for me?</h2>
<p>Start with the safe working load, which needs to be higher than your weight. Then check where the hoist reaches, because a ceiling hoist only works under its track. A mobile hoist can move between rooms if the floors and doors allow it.</p>
<p>With a mobile hoist, the legs need to fit under the bed. Compare the height of the hoist's legs with the space under the bed at its lowest setting. Check that the hoist can turn in the room, too.</p>
<p>Ask when the hoist was last examined. Under the LOLER rules, hoists used at work to lift people need a thorough examination every six months. You should also plan to bring your own sling, because it has to fit you.</p>

<h2>Our own figures, as an example</h2>
<p>Here's how our bungalow in Whitstable measures up against that list. The front door has a clear opening of 965mm, and the inside doors have 926mm. There are no steps inside the bungalow.</p>
<p>The profiling bed's platform adjusts from 220mm to 800mm high. Our mobile hoist's legs are 100mm high, with 25mm of ground clearance, and it turns in 1235mm. Both hoists have a safe working load of 180kg and are examined every six months.</p>
<p>If you're bringing your own hoist, compare its leg height and turning space with those figures. Every listing should let you make that kind of check.</p>

<h2>Red flags in an access statement</h2>
<ul>
<li>\"Wheelchair friendly\" or \"accessible\" with no measurements.</li>
<li>Door widths that don't say whether they're the clear opening.</li>
<li>A hoist without a make, model or safe working load.</li>
<li>No photos of the whole bathroom.</li>
<li>A statement that hasn't been updated for years.</li>
</ul>

<h2>What to ask when details are missing</h2>
<p>Email the owner and ask for the exact measurements you need. Keep your email short and specific, so that it's easy to answer.</p>
<ul>
<li>What's the clear opening of the front door, the bedroom door and the bathroom door?</li>
<li>Is there a step or lip at any door, and how high is it?</li>
<li>What make and model are the bed and the hoist?</li>
<li>How low does the bed go, and how much space is there beside it?</li>
<li>Could you send a photo of the bathroom, taken from the doorway?</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>Can a wheelchair fit through a 27-inch door?</h3>
<p>Possibly not. Twenty-seven inches is about 686mm, and the clear opening will be narrower still. That's too tight for many adult wheelchairs, so measure your chair to be sure.</p>
<h3>What is the minimum door width for wheelchair access?</h3>
<p>Homes built for wheelchair users should have a clear opening of at least 850mm at every door. Ordinary homes can have inside doors with a clear opening of 750mm, depending on the hallway.</p>
<h3>How much space do you need to turn a wheelchair?</h3>
<p>Building guidance for wheelchair users' homes allows a 1500mm turning circle. Some chairs need less and some powerchairs need more, so try turning in a space at home and measure it.</p>
<h3>Is an access statement a legal requirement?</h3>
<p>Not as such, because there's no single legal format for holiday lets. However, VisitEngland asks the businesses in its quality scheme to publish their main access features online.</p>
<h3>What's the difference between an access statement and an accessibility guide?</h3>
<p>They're the same thing. VisitEngland now uses the name \"accessibility guide\", while many owners still say \"access statement\".</p>

<h2>Closing</h2>
<p>If you'd like us to check the fit for you, <a href=\"{$enquire}\">send us your chair measurements</a>. We'll tell you honestly whether the bungalow will work for you.</p>";
}

/**
 * Wheelchair accessible days out in Kent (Batch F, 26 Oct 2026), from each
 * venue’s own access page; the old fatigue-friendly day folds into its planning tips.
 *
 * @return string
 */
function restwell_get_blog_post_fatigue_friendly_coastal_day_html() {
	$area    = esc_url( home_url( '/whitstable-area-guide/' ) );
	$enquire = esc_url( home_url( '/enquire/' ) );
	$beaches = esc_url( home_url( '/accessible-beaches-coastal-walks-kent/' ) );
	$hire    = esc_url( home_url( '/hire-mobility-scooter-equipment-uk-holiday/' ) );

	return "<blockquote><p><strong>TL;DR:</strong> Canterbury Cathedral, Turner Contemporary in Margate and Leeds Castle all lend wheelchairs and have step-free routes. Howletts and Leeds Castle let one carer in free with a disabled visitor's ticket. Reculver and the Beaney in Canterbury have Changing Places toilets.</p></blockquote>

<h2>Which days out in Kent work well with a wheelchair?</h2>
<p>The places below are all within reach of Whitstable, and each one publishes clear access information. We've summed up what they say, but details change, so check before you go.</p>
<p>For the seafront itself, see our guide to <a href=\"{$beaches}\">accessible beaches and coastal walks in Kent</a>. Closer to home, our Whitstable guide covers <a href=\"{$area}\">the level routes and step-free stops in town</a>.</p>

<h2>Canterbury Cathedral</h2>
<p>The main step-free way into the cathedral grounds is Christ Church Gate, on the flat but cobbled Buttermarket. Step-free entry to the Nave is through the North Door.</p>
<p>Inside, a lift by the Dean's Steps takes you up to the Quire. The Trinity Chapel is the only part you can't reach in a wheelchair. The visitor centre lends a few wheelchairs for free.</p>
<p>Blue Badge parking in the grounds can be booked ahead, if there's space. The accessible toilet is about 135 metres from the visitor centre. There isn't room beside it for a sideways transfer, but the Beaney's Changing Places toilet is nearby.</p>

<h2>The Beaney, Canterbury</h2>
<p>The Beaney is Canterbury's free museum, gallery and library, on the High Street. It has a Changing Places toilet on the ground floor, with a ceiling hoist and an adjustable changing bench.</p>
<p>There's a 12-space disabled car park in Orange Street, next to the entrance on Best Lane. Ring ahead to check the lifts are working before you go.</p>

<h2>Turner Contemporary, Margate</h2>
<p>The gallery is step-free, with a ramp to the right of the entrance steps and a lift to both floors. Wheelchairs in different sizes are kept at the Access Station, and you can book one ahead.</p>
<p>There are seven free Blue Badge bays beside the gallery, near the visitor information centre. The nearest Changing Places toilet is at Thanet Gateway Plus, and staff can give you directions. The gallery also holds quiet hours, for a calmer visit.</p>

<h2>Reculver, near Herne Bay</h2>
<p>At Reculver, the twin towers of an old church stand inside a Roman fort, right by the sea. The grounds are free to visit, and you reach them up a long slope from the car park, which charges.</p>
<p>The country park next door has a café and toilets. One is a Changing Places toilet, with a full-room hoist and an adjustable bench. Check it's working before a long trip, as equipment can be out of use.</p>

<h2>Howletts Wild Animal Park, near Canterbury</h2>
<p>Howletts is mostly flat, with tarmac paths, a few gentle slopes and one steeper hill, where staff can help. Some paths have tree roots underneath, so expect the odd bump.</p>
<p>You can borrow a manual wheelchair from the Gatehouse, leaving your car keys or licence as a deposit. It's best to book it by phone first. Mobility scooters are allowed, but ring ahead for advice.</p>
<p>One carer goes in free with a disabled visitor's day ticket. You buy these tickets at the Gatehouse, with a benefit award letter or an Access Card as proof.</p>

<h2>Leeds Castle, near Maidstone</h2>
<p>The castle has step-free entry through the main front door and a wheelchair lift, though the upstairs rooms aren't accessible. A free mobility bus runs around the estate, because the land train can't take wheelchairs.</p>
<p>Wheelchairs are free to borrow, while there are some left. One carer goes in free with each disabled ticket. The Boat House Café has an accessible toilet with adult changing facilities.</p>
<p>Expect about 45 metres of cobbles across the drawbridge. The garden path is about 900 metres long, with one short, steep stretch.</p>

<h2>How do you plan a day out that doesn't wear you out?</h2>
<p>Choose one main place and plan around it, rather than fitting in several. Check where you'll park, how far it is to the entrance and where you can sit down. Then decide your turning-back point before you set off.</p>
<ul>
<li>Book a wheelchair ahead if you'll need to borrow one.</li>
<li>Bring proof for carer tickets, such as a benefit award letter.</li>
<li>Find the nearest Changing Places toilet, and check it's open.</li>
<li>Check the forecast for wind as well as rain.</li>
<li>Keep a shorter plan in mind if the day becomes too much.</li>
</ul>

<h2>Where are the Changing Places toilets near Whitstable?</h2>
<p>Canterbury City Council has Changing Places toilets at Whitstable Harbour and Reculver Country Park. There are two more at the Beaney in Canterbury and Herons Leisure Centre in Herne Bay. The national Changing Places map lists these and many more.</p>
<p>Equipment sometimes breaks, so check a toilet is working before you rely on it.</p>

<h2>Frequently asked questions</h2>
<h3>What can you do in Kent in a wheelchair?</h3>
<p>Plenty, from Canterbury Cathedral and Leeds Castle to galleries and wildlife parks. The coast has level promenades too, such as Tankerton, Herne Bay and Margate.</p>
<h3>Do carers get in free?</h3>
<p>Often, yes. Howletts and Leeds Castle both let one carer in free with a disabled ticket. Check each place's rules, and bring proof in case you're asked.</p>
<h3>Can I borrow a wheelchair at Kent attractions?</h3>
<p>Many lend them, including Canterbury Cathedral, Turner Contemporary, Howletts and Leeds Castle. They only have a few, so book ahead where you can.</p>
<h3>Can I take a mobility scooter?</h3>
<p>It depends on the place. Howletts allows scooters if you ring ahead, but Leeds Castle doesn't allow them inside the castle. Our guide to <a href=\"{$hire}\">mobility scooter hire in Whitstable</a> covers hiring one for your stay.</p>

<h2>Coming back to Restwell</h2>
<p>Restwell is a private, adapted bungalow in Whitstable. After a day out, you come back to a ceiling track hoist, a profiling bed and a level wet room. The private drive is level, which makes it easier to get in and out of the car.</p>

<h2>Closing</h2>
<p>Planning a stay around a day out? <a href=\"{$enquire}\">Tell us your dates and what you'd like to see</a>, and we'll share what we know.</p>";
}
