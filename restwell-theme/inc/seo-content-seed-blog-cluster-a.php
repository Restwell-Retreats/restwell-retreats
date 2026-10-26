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
 * Mobility scooter and wheelchair hire in Whitstable (Batch E, 26 Oct 2026).
 * Prices are as checked on 26 Oct 2026; recheck them before each copy pass.
 *
 * @return string
 */
function restwell_get_blog_post_hire_mobility_equipment_uk_html() {
	$train     = esc_url( home_url( '/accessible-train-travel-whitstable-kent/' ) );
	$enquire   = esc_url( home_url( '/enquire/' ) );
	$access    = esc_url( home_url( '/accessibility/' ) );
	$insurance = esc_url( home_url( '/travel-insurance-disability-uk-self-catering/' ) );
	$beaches   = esc_url( home_url( '/accessible-beaches-coastal-walks-kent/' ) );

	return "<blockquote><p><strong>TL;DR:</strong> First Choice Mobility has a branch in Whitstable that hires out scooters and wheelchairs. The British Red Cross hires out wheelchairs too, but only delivers to your home, so book before you travel. At Restwell, the hoists, beds and shower chairs are already there.</p></blockquote>

<h2>Can you hire a mobility scooter in Whitstable?</h2>
<p>Yes, First Choice Mobility has a branch in Whitstable. It hires out scooters and wheelchairs for a few days, a holiday or longer. You usually collect from the branch, though it can deliver for a charge.</p>
<p>Call 01227 907003 to check what's free for your dates.</p>
<p>When we checked in October 2026, a travel or 4mph scooter cost £45 a week. An 8mph scooter cost £60, and every scooter needs a £250 deposit, which you get back. Prices can change, so confirm them when you book.</p>
<p>Before you choose a scooter, check where you'll use it. Our <a href=\"{$access}\">door widths and equipment list for the bungalow</a> will tell you whether it fits indoors.</p>

<h2>Where can you hire a wheelchair?</h2>
<p>First Choice Mobility hires out wheelchairs from £25 a week, or £5 a day. There's an £80 refundable deposit.</p>
<p>The British Red Cross also hires out wheelchairs, for £22 a week plus £35 for delivery and collection. There's no deposit, and you don't need a referral. It only delivers to a home address, so book it before you leave.</p>

<h2>Do you need to hire anything for Restwell?</h2>
<p>Probably not the big things. The bungalow has a ceiling track hoist, a mobile hoist and a standing aid. It also has two profiling beds, a tilt-in-space shower chair and a shower stool.</p>
<p>Please bring the sling you already use, because a sling has to fit the person using it. Both hoists take loop-style slings on a two-point spreader bar. Fold-up ramps are kept by the front door, for the house and for days out.</p>

<h2>What are the rules for using a mobility scooter?</h2>
<p>Most scooters are class 2 or class 3. A class 2 scooter goes up to 4mph and is for pavements. A class 3 scooter goes up to 8mph and can go on the road as well.</p>
<p>A class 3 scooter has to be registered with the DVLA, but there's no vehicle tax to pay. On pavements, every scooter is limited to 4mph, and you must give way to people walking.</p>
<p>By law, you can drive a scooter if an injury, disability or health condition makes walking hard.</p>

<h2>Can you get VAT off the hire?</h2>
<p>Often, yes. If you're disabled or have a long-term health condition, hiring equipment made for disabled people can be free of VAT. You'll usually sign a short form to say you qualify, and the supplier can tell you if it counts.</p>

<h2>What should you check before you hire?</h2>
<ul>
<li><strong>Width:</strong> compare the scooter or chair with the doors where you're staying. At Restwell, the front door is 965mm and the doors inside are 926mm.</li>
<li><strong>Charging:</strong> ask how long the battery lasts, and where you'll charge it overnight.</li>
<li><strong>Folding:</strong> check whether it folds or comes apart to fit in your car.</li>
<li><strong>Breakdowns:</strong> save the number to call if it stops working, and ask about evenings and weekends.</li>
<li><strong>Insurance:</strong> ask what you'd pay if it's damaged or stolen.</li>
</ul>
<p>Our guide to <a href=\"{$insurance}\">travel insurance for a UK holiday if you're disabled</a> covers hired kit as well.</p>

<h2>Can you take a hired scooter on the train?</h2>
<p>Yes, if it's small enough. Southeastern trains take scooters up to 1,200mm long and 700mm wide, in the wheelchair space. Our guide to <a href=\"{$train}\">step-free trains to Whitstable</a> has the rest of the rules.</p>

<h2>Common mistakes to avoid</h2>
<ul>
<li>Booking a scooter for a busy summer week at the last minute.</li>
<li>Hiring a wide scooter without checking the doors where you're staying.</li>
<li>Expecting the Red Cross to deliver to a holiday address.</li>
<li>Forgetting to ask about VAT relief before you pay.</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>Can I get a wheelchair for free?</h3>
<p>If you need a wheelchair long term, your GP or physio can refer you to the NHS wheelchair service. For a short holiday, hiring is usually quicker.</p>
<h3>Can I hire a beach wheelchair?</h3>
<p>Yes, on some Kent beaches. Our guide to <a href=\"{$beaches}\">accessible beaches and coastal walks in Kent</a> says where to borrow one.</p>
<h3>Do I need to hire a hoist for Restwell?</h3>
<p>No. There's a ceiling track hoist over the bed and a mobile hoist you can use in any room. Please bring your own sling.</p>
<h3>Can I hire a scooter for just a day?</h3>
<p>First Choice Mobility lists weekly and monthly prices for scooters, and daily prices for wheelchairs. Ask the branch if you need a scooter for less than a week.</p>

<h2>Bringing your own kit to Restwell</h2>
<p>Restwell is a private, single-storey bungalow in Whitstable, with a step-free front door. The private drive is level, which makes it easier to get a scooter in and out of a car. If you're bringing one, ask us where it can be charged.</p>

<h2>Closing</h2>
<p>Not sure what to bring? <a href=\"{$enquire}\">Ask us about the equipment at the bungalow</a>, and we'll tell you what's here.</p>";
}

/**
 * Is Whitstable station step-free? (Batch E, 26 Oct 2026): the two platform
 * entrances, Passenger Assist, scooters on Southeastern and the railcard.
 *
 * @return string
 */
function restwell_get_blog_post_accessible_train_whitstable_kent_html() {
	$area    = esc_url( home_url( '/whitstable-area-guide/' ) );
	$parking = esc_url( home_url( '/accessible-parking-whitstable-tankerton/' ) );
	$enquire = esc_url( home_url( '/enquire/' ) );

	return "<blockquote><p><strong>TL;DR:</strong> Yes, both platforms at Whitstable are step-free, but each has its own entrance. Platform 1, for London, is off Old Bridge Road, and platform 2, towards Margate, is off Railway Avenue. The footbridge between them has steps.</p></blockquote>

<h2>Is Whitstable station step-free?</h2>
<p>Yes, but each platform has its own step-free entrance. Platform 1, for trains towards London, is reached from the forecourt off Old Bridge Road. Platform 2, for trains towards Margate, is reached from Railway Avenue.</p>
<p>There are no lifts, and the footbridge between the platforms has steps. So if you need to cross over, you go out of the station and round by road. National Rail lists Whitstable as step-free category B2, which means some step-free access to every platform.</p>
<p>Staff keep ramps at the station for getting on and off the train. There are no wheelchairs to borrow, so bring your own if you need one. Once you arrive, our guide to <a href=\"{$area}\">getting around Whitstable on wheels</a> covers the town itself.</p>

<h2>Which London stations have trains to Whitstable?</h2>
<p>Southeastern runs direct trains to Whitstable from London St Pancras and London Victoria. The trip takes about an hour and a half. Trains from St Pancras use the high-speed line for the first part of the trip.</p>
<p>The same line runs along the coast to Herne Bay, Margate and Ramsgate. Going the other way, you can change at Faversham for trains to Canterbury and Dover.</p>

<h2>How do you book help at the station?</h2>
<p>You can book Passenger Assist through its app or website, or by calling 0800 022 3720. You can book up to two hours before you travel, but earlier is better. Staff can then set up a ramp and meet you off the train.</p>
<p>They can also help with up to three bags, as long as one person can carry them. If you don't book, you can still turn up and go. Staff will help where they can, though it may take longer at busy times.</p>
<p>Whitstable isn't staffed all day. National Rail lists staff help from 6am to midday, Monday to Saturday, and from 9.10am to 4pm on Sundays. At other times, there are help points inside and outside the station.</p>
<p>If you've booked help, wait at the platform shelter, where staff on the train can see you. Make yourself known when the train comes in, or press a help point button.</p>

<h2>Can you take a wheelchair or mobility scooter on the train?</h2>
<p>Yes, Southeastern trains take wheelchairs and mobility scooters up to 1,200mm long and 700mm wide. You travel in the wheelchair space. You can't reserve it, but staff will try to get you on the train you want.</p>
<p>The ramps take up to 300kg in total, which includes you, your chair or scooter and your bags. A class 3 scooter must be set to its 4mph pavement setting on board. Southeastern also suggests moving to a seat once you're on the train.</p>
<p>A folding scooter that fits in the luggage rack can go on any train. Replacement buses may not take scooters, so check for engineering work before you travel. Southeastern publishes planned work 12 weeks ahead.</p>

<h2>What happens if a replacement bus isn't accessible?</h2>
<p>Southeastern's replacement buses have to be wheelchair accessible. If you can't use the transport on the day, it will arrange an accessible taxi at no extra charge. The taxi takes you to the nearest accessible station, so you can carry on.</p>
<p>You still need a ticket for the whole trip. If disruption stops you travelling, call Southeastern on 0800 783 4524. You can also ask staff or use a help point.</p>

<h2>Is there a railcard if you're disabled?</h2>
<p>Yes. The Disabled Persons Railcard costs £20 for a year, or £54 for three years. It takes a third off most fares for you and for one adult travelling with you.</p>
<p>You can qualify in several ways, such as getting PIP at any rate or holding a Blue Badge. Being registered as sight impaired counts too. The full list is on the Railcard website, and the card can be on your phone or printed.</p>

<h2>Getting from Whitstable station to where you're staying</h2>
<p>There's a drop-off point by the station, and a taxi office right by the exit. When you book a taxi, ask for a wheelchair-accessible car if you need one, because not every car is adapted.</p>
<p>The station car park has 43 spaces, and 9 of them are accessible. Southeastern lets Blue Badge holders park free in its station car parks, all day if you're catching a train.</p>
<p>Our guide to <a href=\"{$parking}\">Blue Badge parking in Whitstable</a> covers the rest of the town.</p>

<h2>Practical steps before you travel</h2>
<ul>
<li>Book Passenger Assist when you buy your tickets, and keep the reference number.</li>
<li>Check which platform your train uses, so you go in by the right entrance.</li>
<li>Look up engineering work for your dates, especially if you use a scooter.</li>
<li>Measure your chair or scooter if you're not sure it fits the 1,200mm by 700mm space.</li>
<li>Book an accessible taxi for the last part of the trip if you need one.</li>
</ul>

<h2>Common mistakes to avoid</h2>
<ul>
<li>Going in by the wrong entrance, when the footbridge between the platforms has steps.</li>
<li>Arriving after midday and expecting staff at the station.</li>
<li>Assuming a replacement bus will take a mobility scooter.</li>
<li>Booking a taxi without saying you need an adapted car.</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>Does Whitstable station have toilets?</h3>
<p>Yes, there's a toilet and an accessible toilet. There's no Changing Places toilet and no baby changing at the station.</p>
<h3>When is the ticket office open?</h3>
<p>National Rail lists it as open from 6am to 7.30pm, Monday to Saturday, and from 9.10am to 4pm on Sundays. There are ticket machines too.</p>
<h3>Which station is nearest if Whitstable doesn't suit?</h3>
<p>National Rail names Faversham as the nearest accessible station. It's the next stop towards London on the same line.</p>
<h3>What if the help I booked doesn't turn up?</h3>
<p>Tell Southeastern, because it will look into what went wrong. Depending on what happened, you may get a full or partial refund, or vouchers.</p>
<h3>Can a carer travel with me on a railcard?</h3>
<p>Yes. The Disabled Persons Railcard takes a third off for one adult travelling with you. They don't have to be the same person every time.</p>

<h2>Coming to Restwell by train</h2>
<p>Restwell is a private, adapted bungalow in Whitstable. From the station, it's a walk of 20 to 30 minutes, or a short taxi ride. If someone is driving down to meet you, the private drive has room for two cars.</p>

<h2>Closing</h2>
<p>If you'd like help planning the trip, <a href=\"{$enquire}\">tell us your dates and how you're travelling</a>. We'll share what we know.</p>";
}

/**
 * Travel insurance for a UK holiday if you’re disabled (Batch E, 26 Oct 2026).
 * Quotes Restwell’s cancellation terms; keep it in step with legal-content.php.
 *
 * @return string
 */
function restwell_get_blog_post_travel_insurance_disability_uk_html() {
	$enquire = esc_url( home_url( '/enquire/' ) );
	$hire    = esc_url( home_url( '/hire-mobility-scooter-equipment-uk-holiday/' ) );
	$funding = esc_url( home_url( '/funding-and-support/' ) );
	$terms   = esc_url( home_url( '/terms-and-conditions/' ) );

	return "<blockquote><p><strong>TL;DR:</strong> Travel insurance is worth having for a UK holiday, mostly in case you have to cancel. Tell the insurer about every health condition and the equipment you take. If it turns you down, it must point you to a list of specialist insurers.</p></blockquote>

<h2>Do you need travel insurance for a UK holiday?</h2>
<p>It's worth having, mostly in case you have to cancel. In England, Scotland and Wales, the NHS treats you if you're ill. So on a UK trip, cover is mainly for cancelling, coming home early, or losing things like your wheelchair.</p>
<p>Many policies only cover a UK trip of at least two nights somewhere you pay to stay. Some also need you to travel a set distance from home. Read the policy before you buy.</p>
<p>For help paying for the stay itself, see our guide to <a href=\"{$funding}\">grants that can go towards a stay</a>.</p>

<h2>Why does cover for cancelling matter?</h2>
<p>Most holiday homes keep some or all of your money if you cancel late. At Restwell, you get all your money back if you cancel more than 30 days before you arrive.</p>
<p>If you cancel 14 to 30 days before, you get half back, and under 14 days, there's no refund.</p>
<p>After a serious illness or a care emergency, we may offer some money back or a free date change. We look at each case on its own, though, so insurance is what protects you.</p>

<h2>What do you need to tell the insurer?</h2>
<p>Tell them about every health condition and disability they ask about, even if it seems small. Most insurers mean anything you've seen a doctor about, or had treatment for, in the last two years. Some ask further back about serious illness.</p>
<p>They'll also ask how a condition affects your day, and what equipment you use. If you leave something out, the insurer may refuse to pay when you claim.</p>

<h2>Can an insurer turn you down or charge more?</h2>
<p>Yes, but only on fair grounds. Under the Equality Act 2010, an insurer can only treat you differently because of a disability if that's reasonable. It must also be based on good evidence about the risk.</p>
<p>Sometimes an insurer turns you down, won't cover a condition, or charges a lot more for it. When that happens, FCA rules say it must tell you about the MoneyHelper travel insurance directory. The directory lists specialist insurers who are more likely to cover you.</p>
<p>A broker can also shop around for you, for a fee. You can find one through the British Insurance Brokers' Association.</p>

<h2>Is your wheelchair or scooter covered?</h2>
<p>Not always for what it's worth. Most policies have a limit for any one item you take. That limit may be less than a powerchair or scooter costs to replace, though some specialist policies go higher.</p>
<p>Your home insurance may already cover your chair away from home, so check that first. If you hire one, ask the hire firm what you'd pay if it's damaged or stolen. Our guide to <a href=\"{$hire}\">mobility scooter hire in Whitstable</a> lists what to ask.</p>

<h2>Does the cover include your carer?</h2>
<p>Check what the policy says about cancelling because someone else falls ill. Ask whether that includes a carer or PA, especially one who isn't coming with you.</p>
<p>If your care falls through and you can't travel, ask whether that's a reason the insurer will pay out for. Get the answer in writing, so there's no doubt if you need to claim.</p>

<h2>Practical steps before you buy</h2>
<ul>
<li>Buy cover when you book, so you're covered for cancelling straight away.</li>
<li>Tell the insurer about every condition, and list your equipment and what it's worth.</li>
<li>Check the limit for one item against the cost of your chair or scooter.</li>
<li>Ask whether you're covered if your carer can't come.</li>
<li>Keep receipts and photos of your equipment in case you need to claim.</li>
</ul>

<h2>Common mistakes to avoid</h2>
<ul>
<li>Leaving out a condition to keep the price down.</li>
<li>Leaving insurance until just before you travel.</li>
<li>Assuming your home insurance covers everything away from home.</li>
<li>Missing a rule about how many nights a UK trip must last.</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>Does travel insurance cover you in the UK?</h3>
<p>Many policies do, as long as the trip fits their rules. A common rule is at least two nights somewhere you pay to stay. Read the policy to be sure.</p>
<h3>What medical conditions affect travel insurance?</h3>
<p>Anything you've seen a doctor about or had treatment for lately, and any serious illness you've had in the past. That includes things like cancer or heart trouble. If you're not sure, tell the insurer.</p>
<h3>Do I need a GHIC for a UK holiday?</h3>
<p>No. The Global Health Insurance Card is for health care abroad. On a holiday in England, Scotland or Wales, you can use the NHS as you would at home.</p>
<h3>What if I can't find cover?</h3>
<p>Try the MoneyHelper travel insurance directory, or ask a broker. A policy for one trip, rather than a whole year, can be easier to get.</p>

<h2>Booking Restwell with insurance in place</h2>
<p>Restwell is a private, adapted bungalow in Whitstable. Up to 14 days before you arrive, you can ask to move your dates for free.</p>
<p>The new dates just need to be open. Our <a href=\"{$terms}\">booking and cancelling terms</a> have the full details.</p>

<h2>Closing</h2>
<p>Need our terms or a quote to show your insurer? <a href=\"{$enquire}\">Ask us about your dates</a>, and we'll send them over.</p>";
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
