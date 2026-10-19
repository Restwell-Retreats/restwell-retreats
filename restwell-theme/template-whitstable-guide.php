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

$restwell_wg_id = (int) get_queried_object_id();

$wg_txt = static function ( $key, $fallback ) use ( $restwell_wg_id ) {
	return function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_wg_id, $key, $fallback )
		: $fallback;
};

$wg_lines = static function ( $key, array $fallback_lines ) use ( $wg_txt ) {
	$raw   = $wg_txt( $key, implode( "\n", $fallback_lines ) );
	$lines = array_values(
		array_filter(
			array_map( 'trim', explode( "\n", str_replace( "\r\n", "\n", $raw ) ) )
		)
	);
	return ! empty( $lines ) ? $lines : $fallback_lines;
};

$wg_spot_src = static function ( $n, $fallback_path ) use ( $restwell_wg_id ) {
	$id = 0;
	if ( function_exists( 'restwell_page_content_meta_or_default' ) ) {
		$id = absint( restwell_page_content_meta_or_default( $restwell_wg_id, "wg_spotlight_image_{$n}_id" ) );
	}
	if ( $id > 0 ) {
		$url = wp_get_attachment_image_url( $id, 'large' );
		if ( is_string( $url ) && '' !== $url ) {
			return $url;
		}
	}
	return function_exists( 'restwell_theme_image_url' )
		? restwell_theme_image_url( $fallback_path )
		: '';
};

$restwell_wg_heading = $wg_txt( 'wg_heading', 'Accessible days out in Whitstable and Tankerton' );
// Pages seeded before the 9 Oct 2026 rewrite still hold the old H1 in meta.
if ( 'What a day out from the bungalow is actually like' === $restwell_wg_heading ) {
	$restwell_wg_heading = 'Accessible days out in Whitstable and Tankerton';
}
$restwell_wg_intro   = $wg_txt(
	'wg_intro',
	'What we know about getting around Whitstable and Tankerton: the level routes, the ones that aren’t, and where to eat.'
);

$wg_about_heading = $wg_txt( 'wg_about_heading', 'Tankerton promenade' );
$wg_about_body    = $wg_txt(
	'wg_about_body',
	'About two miles of paved path runs from Tankerton Slopes towards the castle and harbour. The slopes down to the shingle are steep, so stay on the promenade for the level route.'
);

$wg_parking_heading = $wg_txt( 'wg_getting_here_heading', 'At the house and in town' );
$wg_parking_body    = $wg_txt(
	'wg_getting_here_body',
	'Park on the driveway when you can. In town, the harbour car parks are the ones that catch people out, because they use number-plate cameras.'
);

$wg_access_label   = $wg_txt( 'wg_access_label', 'Along the route' );
$wg_access_heading = $wg_txt( 'wg_access_heading', 'Castle, harbour and beach pub' );
$wg_access_intro   = $wg_txt(
	'wg_access_intro',
	'These are level stops on the promenade route, with access notes and links so you can check opening times before you set out.'
);

$wg_eating_label   = $wg_txt( 'wg_eating_label', 'Places to eat' );
$wg_eating_heading = $wg_txt( 'wg_eating_heading', 'Pubs and restaurants near the house' );
$wg_eating_intro   = $wg_txt(
	'wg_eating_intro',
	'The Plough is around the corner, and JoJo’s and the Marine Hotel are on Tankerton. Most Whitstable venues are in older buildings, so call ahead if access is critical.'
);

$wg_planning_label   = $wg_txt( 'wg_planning_label', 'Loos along the way' );
$wg_planning_heading = $wg_txt( 'wg_planning_heading', 'Accessible toilets' );
$wg_planning_intro   = $wg_txt(
	'wg_planning_intro',
	'These are the public and venue toilets on the promenade route. The Changing Places toilet at the harbour needs a RADAR key.'
);
$wg_toilet_bullets   = $wg_lines(
	'wg_planning_before_bullets',
	array(
		'Behind the sailing club at the foot of the slopes',
		'By the Marine Parade cafe at the top',
		'Under the promenade cafe near the castle',
		'Changing Places: Whitstable Harbour WC, Harbour Road',
		'JoJo’s Tankerton and the Marine Hotel, both with accessible loos',
	)
);

$wg_travel_heading = $wg_txt( 'wg_getting_around_heading', 'Station, buses and taxis' );
$wg_travel_body    = $wg_txt(
	'wg_getting_around_body',
	'Travel times from London are in the strip at the top of the page. Here’s how to get around Whitstable once you’ve arrived.'
);

$wg_towns_heading = $wg_txt( 'wg_towns_heading', 'Wildwood, Dreamland and Canterbury' );
$wg_towns_body    = $wg_txt(
	'wg_towns_body',
	'Check each venue’s site for scooter hire, companion tickets and parking for your dates.'
);

$wg_stop_1_src = $wg_spot_src( 1, 'stock/restwell-whitstable-beach-huts.webp' );
$wg_stop_1_alt = $wg_txt( 'wg_spotlight_image_1_caption', 'Colourful beach huts along the Whitstable seafront' );
$wg_stop_2_src = $wg_spot_src( 2, 'journey/guest-harbour-beach.jpg' );
$wg_stop_2_alt = $wg_txt( 'wg_spotlight_image_2_caption', 'A guest in a powered wheelchair and a companion on the firm Harbour Beach by the lifeboat station' );
$wg_stop_3_src = $wg_spot_src( 3, 'stock/restwell-whitstable-pebble-beach-groynes.jpg' );
$wg_stop_3_alt = $wg_txt( 'wg_spotlight_image_3_caption', 'Shingle beach and timber groynes on the Whitstable shore' );

$wg_related_heading = $wg_txt( 'wg_related_heading', 'Local Whitstable guides' );
$wg_related_intro   = $wg_txt(
	'wg_related_intro',
	'Longer guides on parking, trains, eating out, beaches and the quieter times to visit.'
);
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

	<nav class="subnav" aria-label="On this page" data-toc>
	  <div class="container">
		<ul class="subnav__list">
		  <li><a href="#promenade">Promenade</a></li>
		  <li><a href="#parking">Parking</a></li>
		  <li><a href="#stops">Along the route</a></li>
		  <li><a href="#eat">Eat</a></li>
		  <li><a href="#toilets">Toilets</a></li>
		  <li><a href="#travel">Getting around</a></li>
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
			<h2 id="promenade-h"><?php echo esc_html( $wg_about_heading ); ?></h2>
			<p class="lede"><?php echo esc_html( $wg_about_body ); ?></p>
		  </header>
		  <ul class="checklist">
			<li>A wide, surfaced path with weather shelters and benches</li>
			<li>At low tide you can see The Street, a shingle spit that isn’t a wheelchair route</li>
			<li>A level route from Restwell, with no steps on the way</li>
		  </ul>
		</div>
		<div class="split__media">
				  <img src="<?php echo esc_url( restwell_theme_image_url( 'stock/restwell-whitstable-coastal-pathway.webp' ) ); ?>" alt="Level coastal pathway at Whitstable" width="900" height="675" loading="lazy" />
		</div>
	  </div>
	</section>

	<section class="section-y band-white" id="parking" aria-labelledby="parking-h">
	  <div class="container route-split">
		<header class="section-head section-head--tight">
		  <p class="eyebrow">Parking, plainly</p>
		  <h2 id="parking-h"><?php echo esc_html( $wg_parking_heading ); ?></h2>
		  <p class="lede"><?php echo esc_html( $wg_parking_body ); ?></p>
		</header>
		<ol class="route-list route-list--parking" aria-label="<?php esc_attr_e( 'Where to park, easiest first', 'restwell-retreats' ); ?>">
		  <li class="route-list__stop">
			<p class="route-list__head"><span class="route-list__name">At Restwell</span><span class="route-list__tag">Easiest</span></p>
			<p class="route-list__note">There are two spaces on the private driveway, which is level and step-free to the front door. There’s usually room on the street outside if you need more.</p>
		  </li>
		  <li class="route-list__stop">
			<p class="route-list__head"><span class="route-list__name">Marine Parade</span><span class="route-list__tag">Free</span></p>
			<p class="route-list__note">There are free Blue Badge bays along the seafront. Just display your badge, and there’s no app to download.</p>
		  </li>
		  <li class="route-list__stop">
			<p class="route-list__head"><span class="route-list__name">Tankerton Road Car Park</span><span class="route-list__tag">3 hours free</span></p>
			<p class="route-list__note">You get three hours free with a physical Blue Badge, and the promenade is right there.</p>
		  </li>
		  <li class="route-list__stop route-list__stop--warn">
			<p class="route-list__head"><span class="route-list__name">Harbour car parks</span><span class="route-list__tag">Register first</span></p>
			<p class="route-list__note">Gorrell Tank and Keam’s Yard use number-plate cameras, so register your vehicle and Blue Badge online before you park.</p>
			<p class="route-list__links">
			  <a href="https://www.canterbury.gov.uk/parking-and-roads/automatic-car-park-payments/register-your-blue-badge-park" class="text-link" target="_blank" rel="noopener noreferrer">Register your Blue Badge<span class="sr-only"> (opens in new tab)</span><?php restwell_the_icon( 'arrow-up-right' ); ?></a>
			  <a href="https://www.canterbury.gov.uk/parking-and-roads/blue-badge-parking" class="text-link" target="_blank" rel="noopener noreferrer">Blue Badge parking (CCC)<span class="sr-only"> (opens in new tab)</span><?php restwell_the_icon( 'arrow-up-right' ); ?></a>
			</p>
		  </li>
		</ol>
	  </div>
	</section>

	<section class="section-y band-subtle" id="stops" aria-labelledby="stops-h">
	  <div class="container">
		<header class="section-head">
		  <p class="eyebrow"><?php echo esc_html( $wg_access_label ); ?></p>
		  <h2 id="stops-h"><?php echo esc_html( $wg_access_heading ); ?></h2>
		  <p class="lede"><?php echo esc_html( $wg_access_intro ); ?></p>
		</header>
		<div class="place-list place-list--3">
		  <article class="place-list__item">
					   <img class="place-list__thumb" src="<?php echo esc_url( $wg_stop_1_src ); ?>" alt="<?php echo esc_attr( $wg_stop_1_alt ); ?>" width="640" height="400" loading="lazy" decoding="async" />
			<h3 class="place-list__title"><a href="https://whitstablecastle.co.uk/" target="_blank" rel="noopener noreferrer">Whitstable Castle &amp; Gardens<span class="sr-only"> (opens in new tab)</span></a></h3>
			<p class="place-list__meta">Promenade stop</p>
			<p>Paved grounds and the Orangery Tearooms, which has an accessible loo. It’s a level stop halfway along the promenade.</p>
			<p class="place-list__actions"><a href="https://whitstablecastle.co.uk/" class="text-link" target="_blank" rel="noopener noreferrer">Website<span class="sr-only"> (opens in new tab)</span></a><a class="text-link" href="tel:01227281726">Call 01227 281726</a></p>
		  </article>
		  <article class="place-list__item">
					   <img class="place-list__thumb" src="<?php echo esc_url( $wg_stop_2_src ); ?>" alt="<?php echo esc_attr( $wg_stop_2_alt ); ?>" width="640" height="400" loading="lazy" decoding="async" />
			<h3 class="place-list__title"><a href="https://www.canterbury.co.uk/whitstable-harbour/" target="_blank" rel="noopener noreferrer">Whitstable Harbour<span class="sr-only"> (opens in new tab)</span></a></h3>
			<p class="place-list__meta">Town &amp; seafood</p>
			<p>It’s a working oyster port. South Quay Shed has a lift to a quieter upper floor, and the ground can be uneven, so take it steady when it’s busy.</p>
			<p class="place-list__actions"><a href="https://www.canterbury.co.uk/whitstable-harbour/" class="text-link" target="_blank" rel="noopener noreferrer">Website<span class="sr-only"> (opens in new tab)</span></a><a href="https://maps.google.com/?q=Whitstable+Harbour" class="text-link" target="_blank" rel="noopener noreferrer">Map<span class="sr-only"> (opens in new tab)</span></a></p>
		  </article>
		  <article class="place-list__item">
					   <img class="place-list__thumb" src="<?php echo esc_url( $wg_stop_3_src ); ?>" alt="<?php echo esc_attr( $wg_stop_3_alt ); ?>" width="640" height="400" loading="lazy" decoding="async" />
			<h3 class="place-list__title"><a href="https://www.thepubonthebeach.co.uk/" target="_blank" rel="noopener noreferrer">The Old Neptune<span class="sr-only"> (opens in new tab)</span></a></h3>
			<p class="place-list__meta">Beach pub</p>
			<p>This pub sits on the shingle. The terrace is on firm ground and is the realistic option, because the floors inside slope and there’s no step-free entrance.</p>
			<p class="place-list__actions"><a href="https://www.thepubonthebeach.co.uk/" class="text-link" target="_blank" rel="noopener noreferrer">Website<span class="sr-only"> (opens in new tab)</span></a><a href="https://maps.google.com/?q=The+Old+Neptune+Whitstable" class="text-link" target="_blank" rel="noopener noreferrer">Map<span class="sr-only"> (opens in new tab)</span></a></p>
		  </article>
		</div>
	  </div>
	</section>

	<section class="section-y band-white" id="eat" aria-labelledby="eat-h">
	  <div class="container">
		<header class="section-head">
			<p class="eyebrow"><?php echo esc_html( $wg_eating_label ); ?></p>
			<h2 id="eat-h"><?php echo esc_html( $wg_eating_heading ); ?></h2>
			<p class="lede"><?php echo esc_html( $wg_eating_intro ); ?></p>
		  </header>
		<div class="eat-banner">
				 <img src="<?php echo esc_url( restwell_theme_image_url( 'stock/restwell-whitstable-harbour-boats.jpg' ) ); ?>" alt="Fishing boats moored in Whitstable Harbour" width="2000" height="1500" loading="lazy" decoding="async" />
		</div>
		<div class="place-list place-list--3 place-list--venues">
		  <article class="place-list__item">
			<h3 class="place-list__title"><a href="https://maps.google.com/?q=The+Plough+St+Johns+Road+Whitstable" target="_blank" rel="noopener noreferrer">The Plough Inn, Swalecliffe<span class="sr-only"> (opens in new tab)</span></a></h3>
			<p class="place-list__meta">Nearest pub · CT5 2RN</p>
			<p>Around the corner via a footpath at the end of the road. We’ll point it out in your welcome pack. Step-free entry, but no accessible toilet, so confirm on the day if that matters.</p>
			<p class="place-list__actions"><a class="text-link" href="tel:01227794636">Call 01227 794636</a><a href="https://maps.google.com/?q=The+Plough+St+Johns+Road+Whitstable" class="text-link" target="_blank" rel="noopener noreferrer">Map<span class="sr-only"> (opens in new tab)</span></a></p>
		  </article>
		  <article class="place-list__item">
			<h3 class="place-list__title"><a href="https://jojosrestaurant.co.uk/" target="_blank" rel="noopener noreferrer">JoJo’s, Tankerton<span class="sr-only"> (opens in new tab)</span></a></h3>
			<p class="place-list__meta">2 Herne Bay Road · CT5 2LQ</p>
			<p>About twenty minutes on foot from the bungalow: ten to the seafront, then west along the promenade. It has wheelchair access and an accessible toilet. Book ahead, as it fills quickly.</p>
			<p class="place-list__actions"><a href="https://jojosrestaurant.co.uk/" class="text-link" target="_blank" rel="noopener noreferrer">Website<span class="sr-only"> (opens in new tab)</span></a><a class="text-link" href="tel:01227274591">Call 01227 274591</a></p>
		  </article>
		  <article class="place-list__item">
			<h3 class="place-list__title"><a href="https://www.marinewhitstable.co.uk/" target="_blank" rel="noopener noreferrer">Marine Hotel, Tankerton<span class="sr-only"> (opens in new tab)</span></a></h3>
			<p class="place-list__meta">32–33 Marine Parade · CT5 2BE</p>
			<p>Ground-floor lounge and restaurant, step-free, with an accessible loo by reception. It looks out over the Tankerton Slopes to the sea from Marine Parade. Ask for a window table when you book.</p>
			<p class="place-list__actions"><a href="https://www.marinewhitstable.co.uk/" class="text-link" target="_blank" rel="noopener noreferrer">Website<span class="sr-only"> (opens in new tab)</span></a><a class="text-link" href="tel:01227272672">Call 01227 272672</a></p>
		  </article>
		  </div>
	  </div>
	</section>

	<section class="section-y band-subtle" id="toilets" aria-labelledby="toilets-h">
	  <div class="container route-split">
		<header class="section-head section-head--tight">
		  <p class="eyebrow"><?php echo esc_html( $wg_planning_label ); ?></p>
		  <h2 id="toilets-h"><?php echo esc_html( $wg_planning_heading ); ?></h2>
		  <p class="lede"><?php echo esc_html( $wg_planning_intro ); ?></p>
		  <p><a href="https://www.changing-places.org/find" class="text-link" target="_blank" rel="noopener noreferrer">Changing Places map<span class="sr-only"> (opens in new tab)</span></a></p>
		</header>
		<ol class="route-list" aria-label="<?php esc_attr_e( 'Accessible toilets along the promenade route', 'restwell-retreats' ); ?>">
		  <?php
			foreach ( $wg_toilet_bullets as $wg_toilet_line ) :
				$wg_is_cp = 0 === stripos( $wg_toilet_line, 'Changing Places' );
				?>
		  <li class="route-list__stop<?php echo $wg_is_cp ? ' route-list__stop--key' : ''; ?>">
				<?php if ( $wg_is_cp ) : ?>
			<span class="route-list__tag"><?php esc_html_e( 'Changing Places', 'restwell-retreats' ); ?></span>
					<?php echo esc_html( trim( preg_replace( '/^Changing Places:\s*/i', '', $wg_toilet_line ) ) ); ?>
				<?php else : ?>
					<?php echo esc_html( $wg_toilet_line ); ?>
				<?php endif; ?>
		  </li>
		  <?php endforeach; ?>
		</ol>
	  </div>
	</section>

	<section class="section-y band-white" id="travel" aria-labelledby="travel-h">
	  <div class="container">
		<header class="section-head">
		  <p class="eyebrow">Getting around</p>
		  <h2 id="travel-h"><?php echo esc_html( $wg_travel_heading ); ?></h2>
		  <p class="lede"><?php echo esc_html( $wg_travel_body ); ?></p>
		</header>
		<ul class="trio" role="list">
		  <li class="trio__item">
			<h3>Station</h3>
			<p>Access at Whitstable station varies by platform, so check <a class="text-link" href="https://www.nationalrail.co.uk/" target="_blank" rel="noopener noreferrer">National Rail<span class="sr-only"> (opens in new tab)</span></a> before you travel. It’s about 20–30 minutes’ walk from the bungalow on paved routes, or a short taxi ride.</p>
		  </li>
		  <li class="trio__item">
			<h3>Buses</h3>
			<p><a class="text-link" href="https://www.stagecoachbus.com/" target="_blank" rel="noopener noreferrer">Stagecoach South East<span class="sr-only"> (opens in new tab)</span></a> route 400 links The Plough area toward the beach, harbour and Canterbury. Low-floor space can vary, so check on the day.</p>
		  </li>
		  <li class="trio__item">
			<h3>Accessible taxis</h3>
			<p>Ask for a car with wheelchair access, and say if the passenger stays in their chair. Book ahead on busy days with Abacus Cars, <a class="text-link" href="tel:01227277745">01227 277745</a>.</p>
		  </li>
		</ul>
	  </div>
	</section>

	<section class="section-y band-subtle" id="days-out" aria-labelledby="days-out-h">
	  <div class="container">
		<header class="section-head">
		  <p class="eyebrow">Further afield</p>
		  <h2 id="days-out-h"><?php echo esc_html( $wg_towns_heading ); ?></h2>
		  <p class="lede"><?php echo esc_html( $wg_towns_body ); ?></p>
		</header>
		<ul class="card-grid card-grid--3" role="list">
		  <li><article class="media-card">
					   <img src="<?php echo esc_url( restwell_theme_image_url( 'stock/restwell-kent-woodland-paved-path.jpg' ) ); ?>" alt="Paved woodland path near the Kent coast" width="640" height="480" loading="lazy" />
			<h3><a href="https://kent.wildwoodtrust.org/" class="media-card__title-link" target="_blank" rel="noopener noreferrer">Wildwood, Herne Bay<span class="sr-only"> (opens in new tab)</span></a></h3>
			<p>About 30 minutes. The woodland paths are mostly accessible, and scooters can be booked ahead on 01227 209621.</p>
			<p class="place-list__actions"><a href="https://kent.wildwoodtrust.org/plan-your-visit/" class="text-link" target="_blank" rel="noopener noreferrer">Plan your visit<span class="sr-only"> (opens in new tab)</span></a></p>
		  </article></li>
		  <li><article class="media-card">
					   <img src="<?php echo esc_url( restwell_theme_image_url( 'stock/row-of-colorful-beach-homes-2026-03-25-01-44-35-utc.webp' ) ); ?>" alt="Colourful seaside buildings on the Kent coast" width="640" height="480" loading="lazy" />
			<h3><a href="https://www.dreamland.co.uk/" class="media-card__title-link" target="_blank" rel="noopener noreferrer">Dreamland, Margate<span class="sr-only"> (opens in new tab)</span></a></h3>
			<p>Dreamland accepts the Nimbus Access Card and runs an Essential Companion scheme, and there’s accessible parking nearby. Some rides have their own transfer rules, so check the access guide before you go.</p>
			<p class="place-list__actions"><a href="https://www.dreamland.co.uk/" class="text-link" target="_blank" rel="noopener noreferrer">Dreamland website<span class="sr-only"> (opens in new tab)</span></a></p>
		  </article></li>
		  <li><article class="media-card">
					   <img src="<?php echo esc_url( restwell_theme_image_url( 'stock/st-augustines-abbey-in-caterbury-city-england-2026-03-20-01-00-24-utc.webp' ) ); ?>" alt="Historic stone ruins in Canterbury" width="640" height="480" loading="lazy" />
			<h3><a href="https://www.canterbury-cathedral.org/" class="media-card__title-link" target="_blank" rel="noopener noreferrer">Canterbury<span class="sr-only"> (opens in new tab)</span></a></h3>
			<p>About 20 minutes by car. The Cathedral Welcome Centre lends wheelchairs. The riverside and Westgate Gardens are smoother than the cobbles.</p>
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
			<p class="lede">Answers about Tankerton promenade, Blue Badge parking and what the shingle beach can and can’t do.</p>
		  </header>
		  <div class="faq-list faq-list--split" data-faq-accordion>
			<div class="faq-list__col">
			<div class="faq-item is-open">
			  <button type="button" class="faq-item__trigger" aria-expanded="true" id="whit-q1" aria-controls="whit-q1-a">
				<span>Is Whitstable accessible for disabled visitors?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="whit-q1-a" role="region" aria-labelledby="whit-q1">
				<p>Yes, with some planning, as long as you stick to the paved routes. Tankerton’s level promenade works well, but loose shingle and some of the older streets don’t. Plan your parking and toilet stops first, and bring a RADAR key for the Changing Places toilet at the harbour.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="whit-q2" aria-controls="whit-q2-a">
				<span>What is Whitstable like for wheelchair users?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="whit-q2-a" role="region" aria-labelledby="whit-q2" hidden>
				<p>It’s a compact seaside town with a harbour and plenty of independent shops, and the surfaces vary. From Restwell, the seafront is about ten minutes on a flat paved route, and JoJo’s on Tankerton promenade is about twenty minutes in all. Stay on the paved path, because the grassy slopes above it are steep, and keep off the shingle beach, which isn’t a wheelchair surface.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="whit-q4" aria-controls="whit-q4-a">
				<span>Where can I find step-free routes on the Kent coast?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="whit-q4-a" role="region" aria-labelledby="whit-q4" hidden>
				<p>Paved promenades are a better bet than shingle or steep slipways. Tankerton’s promenade, near Restwell, is the stretch we use most, and our guide to accessible beaches covers the rest of the Kent coast.</p>
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
				<p>Book step-free accommodation first, then plan your days around Tankerton promenade. Check where the accessible toilets and parking are, and leave some rest days in the plan. This guide has the local detail from the bungalow.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="whit-q6" aria-controls="whit-q6-a">
				<span>What makes an accessible beach day work here?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="whit-q6-a" role="region" aria-labelledby="whit-q6" hidden>
				<p>A level promenade with parking and toilets nearby, and knowing that the shingle beach isn’t wheelchair friendly. The promenade above the beach is the route to use. We can’t promise a beach wheelchair, so ask locally if you need one.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="whit-q7" aria-controls="whit-q7-a">
				<span>What should I look for in an accessible seaside holiday in Kent?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="whit-q7-a" role="region" aria-labelledby="whit-q7" hidden>
				<p>Look for a private adapted base, level routes you know about, quieter times if crowds are hard, and an indoor backup plan for bad weather. Restwell is that kind of base on the Kent coast, with optional care from Continuity if you need it.</p>
			  </div>
			</div>
			</div>
		  </div>
		</div>
	  </div>
	</section>

	<?php
	$mid_cta_heading = $wg_txt( 'wg_cta_heading', __( 'Ask for route notes for your party', 'restwell-retreats' ) );
	$mid_cta_intro   = $wg_txt(
		'wg_cta_body',
		__( 'Tell us your chair size and how far you like to go in a day, and we’ll point you to the routes that suit.', 'restwell-retreats' )
	);
	$mid_cta_primary_label = $wg_txt( 'wg_cta_primary_label', __( 'Enquire', 'restwell-retreats' ) );
	$mid_cta_primary_url   = $wg_txt( 'wg_cta_primary_url', restwell_nav_resolve_page_url( 'enquire' ) );

	$mid_cta_secondary_label = $wg_txt( 'wg_cta_secondary_label', __( 'See the bungalow', 'restwell-retreats' ) );
	$mid_cta_secondary_url   = $wg_txt( 'wg_cta_secondary_url', restwell_nav_resolve_page_url( 'the-property' ) );

	// Further reading sits above the closing CTA, as on Funding & Support, so the
	// teal CTA runs straight into the teal footer. The FAQ above is band-white.
	if ( function_exists( 'restwell_render_pillar_related_guides' ) ) {
		restwell_render_pillar_related_guides(
			'whitstable-area-guide',
			array(
				'heading' => $wg_related_heading,
				'intro'   => $wg_related_intro,
				'band'    => 'band-subtle',
			)
		);
	}

	get_template_part(
		'template-parts/mid-cta',
		null,
		array(
			'heading'         => $mid_cta_heading,
			'intro'           => $mid_cta_intro,
			'primary_label'   => $mid_cta_primary_label,
			'primary_url'     => $mid_cta_primary_url,
			'secondary_label' => $mid_cta_secondary_label,
			'secondary_url'   => $mid_cta_secondary_url,
		)
	);
	?>



</main>

<?php
get_footer();
