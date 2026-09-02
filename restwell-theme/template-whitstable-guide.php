<?php
/**
 * Template Name: Whitstable Guide
 *
 * Concept port from mockups — Whitstable Guide.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$restwell_wg_id      = (int) get_queried_object_id();
$restwell_wg_heading = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $restwell_wg_id, 'wg_heading', 'What a day out from the bungalow is actually like' )
	: 'What a day out from the bungalow is actually like';
$restwell_wg_intro   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text(
		$restwell_wg_id,
		'wg_intro',
		'Tankerton promenade is the level route with the sea view, and the harbour beach is shingle, which isn’t a wheelchair surface. Most of the food and drink here is in old buildings, so access varies genuinely from door to door. Below is what we know about the places we go to ourselves.'
	)
	: 'Tankerton promenade is the level route with the sea view, and the harbour beach is shingle, which isn’t a wheelchair surface. Most of the food and drink here is in old buildings, so access varies genuinely from door to door. Below is what we know about the places we go to ourselves.';
?>


<main id="main-content">
<?php
get_template_part(
	'template-parts/concept/photo-hero',
	null,
	array(
		'heading_id' => 'page-h',
		'heading'    => $restwell_wg_heading,
		'intro'      => $restwell_wg_intro,
		'crumbs'     => array(
			array(
				'label' => __( 'Home', 'restwell-retreats' ),
				'url'   => home_url( '/' ),
			),
			array(
				'label' => 'Whitstable',
				'url'   => '',
			),
		),
		'post_id'    => $restwell_wg_id,
	)
);
?>

	<nav class="subnav" aria-label="On this page">
	  <div class="container">
		<ul class="subnav__list">
		  <li><a href="#promenade">Promenade</a></li>
		  <li><a href="#parking">Parking</a></li>
		  <li><a href="#eat">Eat</a></li>
		  <li><a href="#toilets">Toilets</a></li>
		  <li><a href="#days-out">Days out</a></li>
		  <li><a href="#faq">FAQ</a></li>
		</ul>
	  </div>
	</nav>

	<section class="section-y section-y--compact band-white" aria-label="Travel times">
	  <div class="container">
		  <div class="stat-row">
			<dl>
			  <div class="stat"><dt class="stat__label">Drive from London (M2 / A299)</dt><dd class="stat__value">~90 min</dd></div>
			  <div class="stat"><dt class="stat__label">Direct train, check National Rail</dt><dd class="stat__value">75–90 min</dd></div>
			  <div class="stat"><dt class="stat__label">Walk to Tankerton promenade</dt><dd class="stat__value">10 min</dd></div>
			</dl>
		  </div>
	  </div>
	</section>

	<section class="section-y band-subtle" id="promenade" aria-labelledby="promenade-h">
	  <div class="container split">
		<div>
		  <header class="section-head section-head--tight">
			<p class="eyebrow">Coastal walk</p>
			<h2 id="promenade-h">Tankerton promenade</h2>
			<p class="lede">About two miles of paved route from Tankerton Slopes toward the castle and harbour. Beach slopes to the shingle are steep, stick to the promenade for level sea air.</p>
		  </header>
		  <ul class="checklist">
			<li>Wide, surfaced path with weather shelters and benches</li>
			<li>At low tide you can watch The Street spit: loose shingle, not a wheelchair route</li>
			<li>Level route from Restwell: no steps on the approach</li>
		  </ul>
		</div>
		<div class="split__media">
		  <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/stock/restwell-whitstable-coastal-pathway.webp' ); ?>" alt="Level coastal pathway at Whitstable" width="900" height="675" loading="lazy" />
		</div>
	  </div>
	</section>

	<section class="section-y band-white" id="parking" aria-labelledby="parking-h">
	  <div class="container split split--flip split--media-first">
		<div class="split__media">
		  <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/stock/russell-drive-whitstable.webp' ); ?>" alt="Quiet residential street near Tankerton" width="900" height="675" loading="lazy" />
		</div>
		<div>
		  <header class="section-head section-head--tight">
			<p class="eyebrow">Parking, plainly</p>
			<h2 id="parking-h">At the house and in town</h2>
			<p class="lede">Start from the driveway when you can. Harbour ANPR is the one that catches people out.</p>
		  </header>
		  <dl class="comparison-list">
			<div class="comparison-list__item">
			  <dt>At Restwell</dt>
			  <dd>Two off-road spaces on the private driveway: level, step-free to the front door. Street parking outside usually works for overflow; check signs on arrival.</dd>
			</div>
			<div class="comparison-list__item">
			  <dt>Marine Parade &amp; Tankerton</dt>
			  <dd>Free Blue Badge bays along Marine Parade (display badge, no app). Tankerton Road Car Park gives three hours free with a physical badge.</dd>
			</div>
		  </dl>
		  <aside class="download-panel">
			<h3>Harbour ANPR</h3>
			<p>Gorrell Tank and Keam’s Yard need your vehicle and Blue Badge pre-registered online. Parking at Tankerton Road and rolling the promenade is usually easier.</p>
			<p class="place-list__actions"><a href="https://www.canterbury.gov.uk/parking-and-roads/automatic-car-park-payments/register-your-blue-badge-park" class="text-link" target="_blank" rel="noopener noreferrer">Register Blue Badge for ANPR<span class="sr-only"> (opens in new tab)</span></a><a href="https://www.canterbury.gov.uk/parking-and-roads/blue-badge-parking" class="text-link" target="_blank" rel="noopener noreferrer">Blue Badge parking (CCC)<span class="sr-only"> (opens in new tab)</span></a></p>
		  </aside>
		</div>
	  </div>
	</section>

	<section class="section-y band-subtle" id="stops" aria-labelledby="stops-h">
	  <div class="container">
		<header class="section-head">
		  <p class="eyebrow">Along the route</p>
		  <h2 id="stops-h">Castle, harbour and beach pub</h2>
		  <p class="lede">Level stops on the promenade route, with access notes and links so you can check opening times before you set out.</p>
		</header>
		<div class="place-list place-list--3">
		  <article class="place-list__item">
			<img class="place-list__thumb" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/stock/restwell-whitstable-beach-huts.webp' ); ?>" alt="Colourful beach huts along the Whitstable seafront" width="640" height="400" loading="lazy" decoding="async" />
			<h3 class="place-list__title"><a href="https://whitstablecastle.co.uk/" target="_blank" rel="noopener noreferrer">Whitstable Castle &amp; Gardens<span class="sr-only"> (opens in new tab)</span></a></h3>
			<p class="place-list__meta">Promenade stop</p>
			<p>Paved grounds and Orangery Tearooms with an accessible loo, a level stop about halfway along the promenade.</p>
			<p class="place-list__actions"><a href="https://whitstablecastle.co.uk/" class="text-link" target="_blank" rel="noopener noreferrer">Website<span class="sr-only"> (opens in new tab)</span></a><a class="text-link" href="tel:01227281726">Call 01227 281726</a></p>
		  </article>
		  <article class="place-list__item">
			<img class="place-list__thumb" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/stock/restwell-whitstable-sunset-pier.webp' ); ?>" alt="Whitstable harbour area at sunset" width="640" height="400" loading="lazy" decoding="async" />
			<h3 class="place-list__title"><a href="https://www.canterbury.co.uk/whitstable-harbour/" target="_blank" rel="noopener noreferrer">Whitstable Harbour<span class="sr-only"> (opens in new tab)</span></a></h3>
			<p class="place-list__meta">Town &amp; seafood</p>
			<p>Working oyster port. South Quay Shed has a lift to a quieter upper floor. Surfaces can be uneven, take it steady at peak times.</p>
			<p class="place-list__actions"><a href="https://www.canterbury.co.uk/whitstable-harbour/" class="text-link" target="_blank" rel="noopener noreferrer">Website<span class="sr-only"> (opens in new tab)</span></a><a href="https://maps.google.com/?q=Whitstable+Harbour" class="text-link" target="_blank" rel="noopener noreferrer">Map<span class="sr-only"> (opens in new tab)</span></a></p>
		  </article>
		  <article class="place-list__item">
			<img class="place-list__thumb" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/stock/restwell-whitstable-coastal-walk.webp' ); ?>" alt="Coastal walk near the Whitstable beach pubs" width="640" height="400" loading="lazy" decoding="async" />
			<h3 class="place-list__title"><a href="https://www.thepubonthebeach.co.uk/" target="_blank" rel="noopener noreferrer">The Old Neptune<span class="sr-only"> (opens in new tab)</span></a></h3>
			<p class="place-list__meta">Beach pub</p>
			<p>Pub on the shingle. The terrace on firm ground is the realistic option: sloping floors inside, no step-free entrance.</p>
			<p class="place-list__actions"><a href="https://www.thepubonthebeach.co.uk/" class="text-link" target="_blank" rel="noopener noreferrer">Website<span class="sr-only"> (opens in new tab)</span></a><a href="https://maps.google.com/?q=The+Old+Neptune+Whitstable" class="text-link" target="_blank" rel="noopener noreferrer">Map<span class="sr-only"> (opens in new tab)</span></a></p>
		  </article>
		</div>
	  </div>
	</section>

	<section class="section-y band-white" id="eat" aria-labelledby="eat-h">
	  <div class="container split split--media-first">
		<div>
		  <header class="section-head section-head--tight">
			<p class="eyebrow">Places to eat</p>
			<h2 id="eat-h">Pubs and restaurants near the house</h2>
			<p class="lede">The Plough is around the corner; JoJo’s and the Marine Hotel sit on Tankerton. Most Whitstable venues are older buildings, call ahead if access is critical.</p>
		  </header>
		  <div class="place-list place-list--stack">
		  <article class="place-list__item">
			
			<h3 class="place-list__title"><a href="https://maps.google.com/?q=The+Plough+St+Johns+Road+Whitstable" target="_blank" rel="noopener noreferrer">The Plough Inn, Swalecliffe<span class="sr-only"> (opens in new tab)</span></a></h3>
			<p class="place-list__meta">Nearest pub · CT5 2RN</p>
			<p>Around the corner via a footpath at the end of the road. We’ll point it out in your welcome pack. Step-free entry; no accessible toilet, confirm on the day if that matters.</p>
			<p class="place-list__actions"><a class="text-link" href="tel:01227794636">Call 01227 794636</a><a href="https://maps.google.com/?q=The+Plough+St+Johns+Road+Whitstable" class="text-link" target="_blank" rel="noopener noreferrer">Map<span class="sr-only"> (opens in new tab)</span></a></p>
		  </article>
		  <article class="place-list__item">
			
			<h3 class="place-list__title"><a href="https://jojosrestaurant.co.uk/" target="_blank" rel="noopener noreferrer">JoJo’s, Tankerton<span class="sr-only"> (opens in new tab)</span></a></h3>
			<p class="place-list__meta">2 Herne Bay Road · CT5 2LQ</p>
			<p>About twenty minutes on foot from the bungalow: ten to the seafront, then west along the promenade. Wheelchair access and an accessible toilet. Book ahead: it fills quickly.</p>
			<p class="place-list__actions"><a href="https://jojosrestaurant.co.uk/" class="text-link" target="_blank" rel="noopener noreferrer">Website<span class="sr-only"> (opens in new tab)</span></a><a class="text-link" href="tel:01227274591">Call 01227 274591</a></p>
		  </article>
		  <article class="place-list__item">
			
			<h3 class="place-list__title"><a href="https://www.marinewhitstable.co.uk/" target="_blank" rel="noopener noreferrer">Marine Hotel, Tankerton<span class="sr-only"> (opens in new tab)</span></a></h3>
			<p class="place-list__meta">32–33 Marine Parade · CT5 2BE</p>
			<p>Ground-floor lounge and restaurant, step-free, accessible loo by reception. Sea views from Marine Parade.</p>
			<p class="place-list__actions"><a href="https://www.marinewhitstable.co.uk/" class="text-link" target="_blank" rel="noopener noreferrer">Website<span class="sr-only"> (opens in new tab)</span></a><a class="text-link" href="tel:01227272672">Call 01227 272672</a></p>
		  </article>
		  </div>
		</div>
		<div class="split__media">
		  <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/stock/restwell-whitstable-marina-sunset.webp' ); ?>" alt="Whitstable seafront near Tankerton, where several step-free dining options sit" width="900" height="675" loading="lazy" />
		</div>
	  </div>
	</section>

	<section class="section-y section-y--compact band-subtle" id="toilets" aria-labelledby="toilets-h">
	  <div class="container">
		<header class="section-head section-head--tight">
		  <p class="eyebrow">Loos along the way</p>
		  <h2 id="toilets-h">Accessible toilets</h2>
		  <p class="lede">Public and venue loos on the promenade route. Changing Places at the harbour needs a RADAR key.</p>
		</header>
		<ul class="checklist checklist--2">
		  <li>Behind the sailing club at the foot of the slopes</li>
		  <li>By the Marine Parade cafe at the top</li>
		  <li>Under the promenade cafe near the castle</li>
		  <li>Changing Places: Whitstable Harbour WC, Harbour Road</li>
		  <li>JoJo’s Tankerton and Marine Hotel (venue accessible loos)</li>
		</ul>
		<p><a href="https://www.changing-places.org/find" class="text-link" target="_blank" rel="noopener noreferrer">Changing Places map<span class="sr-only"> (opens in new tab)</span></a></p>
	  </div>
	</section>

	<section class="section-y band-white" id="travel" aria-labelledby="travel-h">
	  <div class="container">
		<header class="section-head">
		  <p class="eyebrow">Getting around</p>
		  <h2 id="travel-h">Station, buses and taxis</h2>
		  <p class="lede">Travel times from London are in the strip above. Below: how to move around Whitstable once you’ve arrived.</p>
		</header>
		<dl class="fact-dl">
		  <div>
			<dt>Station</dt>
			<dd>Whitstable station access varies by platform, check <a class="text-link" href="https://www.nationalrail.co.uk/" target="_blank" rel="noopener noreferrer">National Rail<span class="sr-only"> (opens in new tab)</span></a> before you travel. About 20–30 minutes’ walk from the bungalow on paved routes, or a short taxi.</dd>
		  </div>
		  <div>
			<dt>Buses</dt>
			<dd><a class="text-link" href="https://www.stagecoachbus.com/" target="_blank" rel="noopener noreferrer">Stagecoach South East<span class="sr-only"> (opens in new tab)</span></a> route 400 links The Plough area toward the beach, harbour and Canterbury. Low-floor space can vary; same-day check.</dd>
		  </div>
		  <div>
			<dt>Accessible taxis</dt>
			<dd>Pre-book on busy days. Abacus Cars: <a class="text-link" href="tel:01227277745">01227 277745</a>.</dd>
		  </div>
		</dl>
	  </div>
	</section>

	<section class="section-y band-subtle" id="days-out" aria-labelledby="days-out-h">
	  <div class="container">
		<header class="section-head">
		  <p class="eyebrow">Further afield</p>
		  <h2 id="days-out-h">Wildwood, Dreamland and Canterbury</h2>
		  <p class="lede">Check each venue’s site for scooter hire, companion tickets and parking for your dates.</p>
		</header>
		<ul class="card-grid card-grid--3" role="list">
		  <li><article class="media-card">
			<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/stock/whitstable-days-out.webp' ); ?>" alt="Woodland day out near the Kent coast" width="640" height="480" loading="lazy" />
			<h3><a href="https://kent.wildwoodtrust.org/" class="media-card__title-link" target="_blank" rel="noopener noreferrer">Wildwood, Herne Bay<span class="sr-only"> (opens in new tab)</span></a></h3>
			<p>~30 minutes. Mostly accessible woodland paths; scooters bookable ahead on 01227 209621.</p>
			<p class="place-list__actions"><a href="https://kent.wildwoodtrust.org/plan-your-visit/" class="text-link" target="_blank" rel="noopener noreferrer">Plan your visit<span class="sr-only"> (opens in new tab)</span></a></p>
		  </article></li>
		  <li><article class="media-card">
			<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/stock/row-of-colorful-beach-homes-2026-03-25-01-44-35-utc.webp' ); ?>" alt="Colourful seaside buildings on the Kent coast" width="640" height="480" loading="lazy" />
			<h3><a href="https://www.dreamland.co.uk/" class="media-card__title-link" target="_blank" rel="noopener noreferrer">Dreamland, Margate<span class="sr-only"> (opens in new tab)</span></a></h3>
			<p>Wheelchair accessible park; Nimbus Access Card and Essential Companion scheme. Accessible parking nearby.</p>
			<p class="place-list__actions"><a href="https://www.dreamland.co.uk/" class="text-link" target="_blank" rel="noopener noreferrer">Dreamland website<span class="sr-only"> (opens in new tab)</span></a></p>
		  </article></li>
		  <li><article class="media-card">
			<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/stock/st-augustines-abbey-in-caterbury-city-england-2026-03-20-01-00-24-utc.webp' ); ?>" alt="Historic stone ruins in Canterbury" width="640" height="480" loading="lazy" />
			<h3><a href="https://www.canterbury-cathedral.org/" class="media-card__title-link" target="_blank" rel="noopener noreferrer">Canterbury<span class="sr-only"> (opens in new tab)</span></a></h3>
			<p>~20 minutes by car. Cathedral Welcome Centre lends wheelchairs; riverside and Westgate Gardens are smoother than the cobbles.</p>
			<p class="place-list__actions"><a href="https://www.canterbury-cathedral.org/visit/" class="text-link" target="_blank" rel="noopener noreferrer">Cathedral visit info<span class="sr-only"> (opens in new tab)</span></a></p>
		  </article></li>
		</ul>
	  </div>
	</section>
	<section class="faq section-y band-white" id="faq" aria-labelledby="faq-h">
	  <div class="container">
		<div class="faq__layout">
		  <header class="faq__intro">
			<p class="eyebrow">Local access</p>
			<h2 id="faq-h">Whitstable &amp; coast FAQ</h2>
			<p class="lede">Tankerton promenade, Blue Badge parking, and what the shingle beach can and can’t do.</p>
		  </header>
		  <div class="faq-list faq-list--split" data-faq-accordion>
			<div class="faq-list__col">
			<div class="faq-item is-open">
			  <button type="button" class="faq-item__trigger" aria-expanded="true" id="whit-q1" aria-controls="whit-q1-a">
				<span>Is Whitstable accessible for disabled visitors?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="whit-q1-a" role="region" aria-labelledby="whit-q1">
				<p>With planning, yes for paved routes. Tankerton’s level promenade works well; loose shingle and some older streets do not. Use Blue Badge parking notes, the harbour RADAR toilet, and a step-free base like Restwell.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="whit-q2" aria-controls="whit-q2-a">
				<span>What is Whitstable like for wheelchair users?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="whit-q2-a" role="region" aria-labelledby="whit-q2" hidden>
				<p>Compact seaside town with harbour and independents; surfaces vary. From Restwell, the seafront is about ten minutes on a flat paved route. Places along Tankerton promenade take longer because you then walk west along the prom. JoJo’s is roughly twenty minutes all in. Stay on the paved path; grassy slopes above are steep.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="whit-q3" aria-controls="whit-q3-a">
				<span>Is Whitstable suitable for wheelchair users?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="whit-q3-a" role="region" aria-labelledby="whit-q3" hidden>
				<p>Yes if you plan parking, toilets and seafront routes first. Tankerton promenade is the main long level coastal stretch. Restwell’s step-free bungalow with driveway parking removes the hardest accommodation barrier.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="whit-q4" aria-controls="whit-q4-a">
				<span>Where can I find step-free routes on the Kent coast?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="whit-q4-a" role="region" aria-labelledby="whit-q4" hidden>
				<p>Favour paved promenades over shingle or steep slips. Tankerton’s promenade near Restwell is the local stretch we use most. A step-free bungalow means the day is about the route, not stairs at the house.</p>
			  </div>
			</div>
			</div>
			<div class="faq-list__col">
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="whit-q5" aria-controls="whit-q5-a">
				<span>How do I plan a wheelchair coastal holiday near Whitstable?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="whit-q5-a" role="region" aria-labelledby="whit-q5" hidden>
				<p>Secure step-free accommodation first; use Tankerton promenade for sea air; check accessible toilets and parking; leave rest days in the plan. This guide lists the local detail from the bungalow.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="whit-q6" aria-controls="whit-q6-a">
				<span>What makes an accessible beach day work here?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="whit-q6-a" role="region" aria-labelledby="whit-q6" hidden>
				<p>Level promenade, nearby parking and toilets, and knowing the shingle beach itself is not wheelchair-friendly. The promenade above is the coastal route. We don’t assume beach wheelchairs; ask locally if you need one.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="whit-q7" aria-controls="whit-q7-a">
				<span>What should I look for in an accessible seaside holiday in Kent?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="whit-q7-a" role="region" aria-labelledby="whit-q7" hidden>
				<p>A private adapted base, known level routes, quieter timing if crowds are hard, and a backup indoor plan for weather. Restwell is that base on the Kent coast, with optional Continuity care if you need it.</p>
			  </div>
			</div>
			</div>
		  </div>
		</div>
	  </div>
	</section>

	<section class="mid-cta mid-cta--plain section-y--cta" aria-labelledby="mid-cta-h">
	  <div class="mid-cta__media" aria-hidden="true"></div>
	  <div class="mid-cta__inner">
		<h2 id="mid-cta-h">Ask for route notes for your party</h2>
		<p>Tell us chair size and energy levels, then look inside the bungalow.</p>
		<div class="mid-cta__btns">
		  <a class="btn btn-gold" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'enquire' ) ); ?>">Enquire Now</a>
		  <a class="btn btn-outline-light" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'the-property' ) ); ?>">See the bungalow</a>
		</div>
	  </div>
	</section>

<?php
if ( function_exists( 'restwell_render_pillar_related_guides' ) ) {
	restwell_render_pillar_related_guides(
		'whitstable-area-guide',
		array(
			'heading' => __( 'Local Whitstable guides', 'restwell-retreats' ),
			'intro'   => __( 'Long-tail notes on parking, trains, eating out, beaches and quieter timing. This page stays the Whitstable Kent coast overview.', 'restwell-retreats' ),
		)
	);
}
?>

</main>

<?php
get_footer();
