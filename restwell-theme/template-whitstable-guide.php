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

$restwell_wg_heading = $wg_txt( 'wg_heading', 'Is Whitstable wheelchair friendly?' );
// Pages seeded before the 9 Oct 2026 rewrite still hold the old H1 in meta.
if ( 'What a day out from the bungalow is actually like' === $restwell_wg_heading ) {
	$restwell_wg_heading = 'Is Whitstable wheelchair friendly?';
}
$restwell_wg_intro   = $wg_txt(
	'wg_intro',
	'Parts of it are. Tankerton’s promenade and the harbour are level and step-free, but the beach is shingle and some older streets are uneven. Here are the routes we know well, and where to eat.'
);

$wg_about_heading = $wg_txt( 'wg_about_heading', 'Tankerton promenade' );
$wg_about_body    = $wg_txt(
	'wg_about_body',
	'About two miles of paved path runs from Tankerton Slopes towards the castle and harbour. The slopes down to the shingle are steep, so stay on the promenade for the level route.'
);

$wg_access_label   = $wg_txt( 'wg_access_label', 'Along the route' );
$wg_access_heading = $wg_txt( 'wg_access_heading', 'Castle, harbour and beach pub' );
$wg_access_intro   = $wg_txt(
	'wg_access_intro',
	'These are level stops on the promenade route. Each has access notes and a link to check opening times before you set out.'
);

$wg_eating_heading = $wg_txt( 'wg_eating_heading', 'Pubs and restaurants near the house' );

$wg_towns_heading = $wg_txt( 'wg_towns_heading', 'Herne Bay, Wildwood, Dreamland and Canterbury' );
$wg_towns_body    = $wg_txt(
	'wg_towns_body',
	'Check each venue for scooter hire, companion tickets and parking.'
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
		  <li><a href="#getting-around">Getting around</a></li>
		  <li><a href="#stops">Along the route</a></li>
		  <li><a href="#eat">Pubs and restaurants</a></li>
		  <li><a href="#days-out">Further afield</a></li>
		  <li><a href="#whats-on">What’s on</a></li>
		  <li><a href="#faq">Questions</a></li>
		</ul>
	  </div>
	</nav>

	<?php // Travel times (22 Oct 2026, owner's pick from three Dribbble-led options): the times as rows in the teal card, beside the promenade at sunset. ?>
	<section class="section-y section-y--compact band-white" aria-label="Travel times">
	  <div class="container travel-card">
		<dl class="travel-card__times">
		  <div><dt>From London by car</dt><dd>~90 min</dd></div>
		  <div><dt>By direct train</dt><dd>75–90 min</dd></div>
		  <div><dt>Walk to the sea</dt><dd>10 min</dd></div>
		</dl>
		<img class="travel-card__photo" src="<?php echo esc_url( restwell_theme_image_url( 'stock/restwell-whitstable-promenade-golden-hour.jpg' ) ); ?>" alt="" width="1600" height="1200" sizes="(min-width: 768px) 460px, 100vw" loading="lazy" decoding="async" />
	  </div>
	</section>

	<section class="section-y band-subtle" id="promenade" aria-labelledby="promenade-h">
	  <div class="container split split--fill">
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

	<?php
	// Getting around (22 Oct 2026, owner's pick from "too much text"): parking,
	// toilets and getting about without a car as three short cards over the
	// beach path. The detail lives in the three local guides each card links
	// to. It was three long text sections. The cards keep the old anchors.
	$wg_guide_urls = array();
	foreach ( array( 'accessible-parking-whitstable-tankerton', 'changing-places-toilets-kent-coast-days-out', 'accessible-train-travel-whitstable-kent' ) as $wg_guide_slug ) {
		$wg_guide_post                   = get_page_by_path( $wg_guide_slug, OBJECT, 'post' );
		$wg_guide_urls[ $wg_guide_slug ] = ( $wg_guide_post instanceof WP_Post ) ? (string) get_permalink( $wg_guide_post ) : '';
	}
	$wg_around = array(
		array(
			'id'    => 'parking',
			'title' => __( 'Parking', 'restwell-retreats' ),
			'lines' => array(
				array( __( 'Easiest', 'restwell-retreats' ), __( 'the level drive at Restwell', 'restwell-retreats' ) ),
				array( __( 'Free', 'restwell-retreats' ), __( 'Blue Badge bays on Marine Parade', 'restwell-retreats' ) ),
				array( __( '3 hours free', 'restwell-retreats' ), __( 'Tankerton Road car park', 'restwell-retreats' ) ),
				array( __( 'Register first', 'restwell-retreats' ), __( 'the harbour car parks', 'restwell-retreats' ) ),
			),
			'more'  => __( 'Parking in full', 'restwell-retreats' ),
			'url'   => $wg_guide_urls['accessible-parking-whitstable-tankerton'],
		),
		array(
			'id'    => 'toilets',
			'title' => __( 'Toilets', 'restwell-retreats' ),
			'lines' => array(
				array( '', __( 'Five along the promenade', 'restwell-retreats' ) ),
				array( __( 'Changing Places', 'restwell-retreats' ), __( 'at the harbour', 'restwell-retreats' ) ),
				array( '', __( 'Bring a RADAR key', 'restwell-retreats' ) ),
			),
			'more'  => __( 'The full route', 'restwell-retreats' ),
			'url'   => $wg_guide_urls['changing-places-toilets-kent-coast-days-out'],
		),
		array(
			'id'    => 'travel',
			'title' => __( 'Without a car', 'restwell-retreats' ),
			'lines' => array(
				array( __( 'Station', 'restwell-retreats' ), __( '20–30 min walk, or a short taxi', 'restwell-retreats' ) ),
				array( __( 'Bus 400', 'restwell-retreats' ), __( 'to the harbour and Canterbury', 'restwell-retreats' ) ),
				array( __( 'Taxis', 'restwell-retreats' ), __( 'Abacus Cars, 01227 277745', 'restwell-retreats' ) ),
			),
			'more'  => __( 'Station, bus and taxi', 'restwell-retreats' ),
			'url'   => $wg_guide_urls['accessible-train-travel-whitstable-kent'],
		),
	);
	?>
	<section class="section-y band-white" id="getting-around" aria-labelledby="getting-around-h">
	  <div class="container">
		<header class="section-head">
		  <h2 id="getting-around-h"><?php esc_html_e( 'Getting around', 'restwell-retreats' ); ?></h2>
		  <p class="lede"><?php esc_html_e( 'The short version. Each card links to the full guide.', 'restwell-retreats' ); ?></p>
		</header>
		<div class="around">
		  <img class="around__photo" src="<?php echo esc_url( restwell_theme_image_url( 'stock/restwell-whitstable-public-beach-path.webp' ) ); ?>" alt="" width="1600" height="1067" sizes="(min-width: 1200px) 1120px, 100vw" loading="lazy" decoding="async" />
		  <ul class="around__cards" role="list">
			<?php foreach ( $wg_around as $wg_card ) : ?>
			<li id="<?php echo esc_attr( $wg_card['id'] ); ?>">
			  <h3><?php echo esc_html( $wg_card['title'] ); ?></h3>
			  <ul>
				<?php foreach ( $wg_card['lines'] as $wg_line ) : ?>
				<li>
					<?php if ( '' !== $wg_line[0] ) : ?>
				  <strong><?php echo esc_html( $wg_line[0] ); ?></strong>
				  <?php endif; ?>
					<?php echo esc_html( $wg_line[1] ); ?>
				</li>
				<?php endforeach; ?>
			  </ul>
				<?php if ( '' !== $wg_card['url'] ) : ?>
			  <a class="around__more" href="<?php echo esc_url( $wg_card['url'] ); ?>"><?php echo esc_html( $wg_card['more'] ); ?> <span aria-hidden="true">&rarr;</span></a>
			  <?php endif; ?>
			</li>
			<?php endforeach; ?>
		  </ul>
		</div>
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
			<p>Paved paths, an accessible loo and the Wynn Ellis Tearoom. It’s a level stop halfway along the promenade. The car park is free for three hours if you register your car, with Blue Badge bays by the entrance.</p>
			<p class="place-list__actions"><a href="https://whitstablecastle.co.uk/" class="text-link" target="_blank" rel="noopener noreferrer">Website<span class="sr-only"> (opens in new tab)</span></a><a href="https://www.google.com/maps/dir/?api=1&amp;destination=Whitstable+Castle+and+Gardens" class="text-link" target="_blank" rel="noopener noreferrer">Directions<span class="sr-only"> (opens in new tab)</span></a></p>
		  </article>
		  <article class="place-list__item">
					   <img class="place-list__thumb" src="<?php echo esc_url( $wg_stop_2_src ); ?>" alt="<?php echo esc_attr( $wg_stop_2_alt ); ?>" width="640" height="400" loading="lazy" decoding="async" />
			<h3 class="place-list__title"><a href="https://www.canterbury.co.uk/whitstable-harbour/" target="_blank" rel="noopener noreferrer">Whitstable Harbour<span class="sr-only"> (opens in new tab)</span></a></h3>
			<p class="place-list__meta">Town &amp; seafood</p>
			<p>It’s a working oyster port. South Quay Shed has a lift to a quieter upper floor. The ground can be uneven, so take it steady when it’s busy.</p>
			<p class="place-list__actions"><a href="https://www.canterbury.co.uk/whitstable-harbour/" class="text-link" target="_blank" rel="noopener noreferrer">Website<span class="sr-only"> (opens in new tab)</span></a><a href="https://www.google.com/maps/dir/?api=1&amp;destination=Whitstable+Harbour" class="text-link" target="_blank" rel="noopener noreferrer">Directions<span class="sr-only"> (opens in new tab)</span></a></p>
		  </article>
		  <article class="place-list__item">
					   <img class="place-list__thumb" src="<?php echo esc_url( $wg_stop_3_src ); ?>" alt="<?php echo esc_attr( $wg_stop_3_alt ); ?>" width="640" height="400" loading="lazy" decoding="async" />
			<h3 class="place-list__title"><a href="https://www.thepubonthebeach.co.uk/" target="_blank" rel="noopener noreferrer">The Old Neptune<span class="sr-only"> (opens in new tab)</span></a></h3>
			<p class="place-list__meta">Beach pub</p>
			<p>This pub sits on the shingle. The terrace is on firm ground and is the realistic option. Inside, the floors slope and there’s no step-free entrance.</p>
			<p class="place-list__actions"><a href="https://www.thepubonthebeach.co.uk/" class="text-link" target="_blank" rel="noopener noreferrer">Website<span class="sr-only"> (opens in new tab)</span></a><a href="https://www.google.com/maps/dir/?api=1&amp;destination=The+Old+Neptune+Whitstable" class="text-link" target="_blank" rel="noopener noreferrer">Directions<span class="sr-only"> (opens in new tab)</span></a></p>
		  </article>
		</div>
	  </div>
	</section>

	<?php
	// Pubs and restaurants (22 Oct 2026): the harbour photo beside three short
	// rows, a name, what it is and one line each. It was long notes in columns.
	$wg_pubs = array(
		array( 'The Plough Inn', 'https://maps.google.com/?q=The+Plough+St+Johns+Road+Whitstable', __( 'Nearest pub', 'restwell-retreats' ), __( 'Round the corner. Step-free, but no accessible loo.', 'restwell-retreats' ) ),
		array( 'JoJo’s, Tankerton', 'https://jojosrestaurant.co.uk/', __( '20 min walk', 'restwell-retreats' ), __( 'Step-free, with an accessible loo. Book ahead.', 'restwell-retreats' ) ),
		array( 'Marine Hotel', 'https://www.marinewhitstable.co.uk/', __( 'Marine Parade', 'restwell-retreats' ), __( 'Step-free lounge, accessible loo and a sea view.', 'restwell-retreats' ) ),
	);
	?>
	<section class="section-y band-white" id="eat" aria-labelledby="eat-h">
	  <div class="container eat-near">
		<img class="eat-near__photo" src="<?php echo esc_url( restwell_theme_image_url( 'stock/restwell-whitstable-harbour-boats.jpg' ) ); ?>" alt="Fishing boats moored in Whitstable Harbour" width="2000" height="1500" sizes="(min-width: 900px) 640px, 100vw" loading="lazy" decoding="async" />
		<div>
		  <h2 id="eat-h"><?php echo esc_html( $wg_eating_heading ); ?></h2>
		  <ul class="eat-near__list" role="list">
			<?php foreach ( $wg_pubs as $wg_pub ) : ?>
			<li>
			  <h3><a href="<?php echo esc_url( $wg_pub[1] ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $wg_pub[0] ); ?><span class="sr-only"> <?php esc_html_e( '(opens in new tab)', 'restwell-retreats' ); ?></span></a></h3>
			  <p><span><?php echo esc_html( $wg_pub[2] ); ?></span> <?php echo esc_html( $wg_pub[3] ); ?></p>
			</li>
			<?php endforeach; ?>
		  </ul>
		</div>
	  </div>
	</section>

	<section class="section-y band-subtle" id="days-out" aria-labelledby="days-out-h">
	  <div class="container">
		<header class="section-head">
		  <p class="eyebrow">Further afield</p>
		  <h2 id="days-out-h"><?php echo esc_html( $wg_towns_heading ); ?></h2>
		  <p class="lede"><?php echo esc_html( $wg_towns_body ); ?></p>
		</header>
		<ul class="card-grid card-grid--2" role="list">
		  <?php // Herne Bay (28 Oct 2026): the printed Welcome Guide's coast QR (page 15) promises routes "along to Tankerton and Herne Bay". Facts researched 28 Oct 2026; no parking prices or bus frequencies, as both can change. ?>
		  <li id="herne-bay"><article class="media-card">
					   <img src="<?php echo esc_url( restwell_theme_image_url( 'stock/restwell-whitstable-beach-huts-pier-view.jpg' ) ); ?>" alt="Painted beach huts on a grassy slope above the sea, with a pier in the distance" width="640" height="480" loading="lazy" />
			<h3>Herne Bay</h3>
			<p>A day trip along the coast. The 400 becomes the 600 at Greenhill (same bus, no need to change), and the pier and bandstand sit along one level seafront stretch. Blue Badge holders get 3 hours free parking, but
			<?php if ( '' !== $wg_guide_urls['accessible-parking-whitstable-tankerton'] ) : ?>
				<a class="text-link" href="<?php echo esc_url( $wg_guide_urls['accessible-parking-whitstable-tankerton'] ); ?>">register the badge online</a>
			<?php else : ?>
				register the badge online
			<?php endif; ?>
			before your first visit. Accessible toilets on the seafront are limited, so bring your RADAR key.</p>
			<p class="place-list__actions"><a href="https://www.stagecoachbus.com/timetables" class="text-link" target="_blank" rel="noopener noreferrer">Stagecoach timetable<span class="sr-only"> (opens in new tab)</span></a></p>
		  </article></li>
		  <li><article class="media-card">
					   <img src="<?php echo esc_url( restwell_theme_image_url( 'stock/restwell-kent-woodland-paved-path.jpg' ) ); ?>" alt="Paved woodland path near the Kent coast" width="640" height="480" loading="lazy" />
			<h3><a href="https://kent.wildwoodtrust.org/" class="media-card__title-link" target="_blank" rel="noopener noreferrer">Wildwood, Herne Bay<span class="sr-only"> (opens in new tab)</span></a></h3>
			<p>About 30 minutes by car. Most of the woodland paths take wheelchairs and scooters, though they get muddy after rain. Book a scooter ahead on 01227 209621, as they go quickly.</p>
			<p class="place-list__actions"><a href="https://kent.wildwoodtrust.org/plan-your-visit/" class="text-link" target="_blank" rel="noopener noreferrer">Plan your visit<span class="sr-only"> (opens in new tab)</span></a></p>
		  </article></li>
		  <li><article class="media-card">
					   <img src="<?php echo esc_url( restwell_theme_image_url( 'stock/row-of-colorful-beach-homes-2026-03-25-01-44-35-utc.webp' ) ); ?>" alt="Colourful seaside buildings on the Kent coast" width="640" height="480" loading="lazy" />
			<h3><a href="https://www.dreamland.co.uk/" class="media-card__title-link" target="_blank" rel="noopener noreferrer">Dreamland, Margate<span class="sr-only"> (opens in new tab)</span></a></h3>
			<p>About 30 minutes by car. There are accessible toilets throughout, but no wheelchairs to hire. Apply through Nimbus at least a week ahead for an Essential Companion wristband.</p>
			<p class="place-list__actions"><a href="https://www.dreamland.co.uk/" class="text-link" target="_blank" rel="noopener noreferrer">Dreamland website<span class="sr-only"> (opens in new tab)</span></a></p>
		  </article></li>
		  <li><article class="media-card">
					   <img src="<?php echo esc_url( restwell_theme_image_url( 'stock/st-augustines-abbey-in-caterbury-city-england-2026-03-20-01-00-24-utc.webp' ) ); ?>" alt="Historic stone ruins in Canterbury" width="640" height="480" loading="lazy" />
			<h3><a href="https://www.canterbury-cathedral.org/" class="media-card__title-link" target="_blank" rel="noopener noreferrer">Canterbury<span class="sr-only"> (opens in new tab)</span></a></h3>
			<p>About 20 minutes by car. The Cathedral’s Welcome Centre lends free wheelchairs, and most of the Cathedral is step-free. The riverside paths and Westgate Gardens are smoother than the cobbles.</p>
			<p class="place-list__actions"><a href="https://www.canterbury-cathedral.org/visit/" class="text-link" target="_blank" rel="noopener noreferrer">Cathedral visit info<span class="sr-only"> (opens in new tab)</span></a></p>
		  </article></li>
		</ul>
	  </div>
	</section>

	<?php
	// What's on (29 Oct 2026): up to six events from the eight slots in this
	// page's "What’s on" tab, soonest first, then the listings for planning
	// further ahead, which always show. An event hides itself the day after it
	// ends (inc/whats-on.php), so with every slot empty or past only the links
	// show. No Event schema: these are other organisers' events.
	$wg_events = function_exists( 'restwell_whats_on_events' ) ? restwell_whats_on_events( $restwell_wg_id ) : array();
	$wg_ahead  = array(
		array( 'Visit Canterbury events', 'https://www.canterbury.co.uk/events', __( 'Canterbury, Whitstable and Herne Bay', 'restwell-retreats' ) ),
		array( 'Whitstable Rocks Oyster Festival', 'https://whitstablerocksoysterfestival.com/', __( 'Usually September', 'restwell-retreats' ) ),
		array( 'Whitstable Harbour Day', 'https://whitstablemaritime.org.uk/', __( 'Usually August', 'restwell-retreats' ) ),
		array( 'Whitstable.co.uk events', 'https://www.whitstable.co.uk/whitstable-events/', __( 'Independent local listings', 'restwell-retreats' ) ),
	);
	?>
	<section class="section-y band-white" id="whats-on" aria-labelledby="whats-on-h">
	  <div class="container">
		<header class="section-head">
		  <h2 id="whats-on-h">What’s on in Whitstable</h2>
		  <p class="lede">Upcoming events near the bungalow. Details can change, so check with the organiser, and ask the venue about access before you go.</p>
		</header>
		<?php if ( $wg_events ) : ?>
		<ul class="place-list whats-on__events" role="list">
			<?php foreach ( $wg_events as $wg_event ) : ?>
				<?php
				// One <time> per date, built from escaped values; a range reads "11–13 Sep".
				$wg_event_dates = array();
				foreach ( restwell_whats_on_date_parts( $wg_event ) as $wg_event_part ) {
					$wg_event_dates[] = '<time datetime="' . esc_attr( $wg_event_part['iso'] ) . '">' . esc_html( $wg_event_part['label'] ) . '</time>';
				}
				?>
		  <li class="place-list__item">
			<h3 class="place-list__title">
				<?php if ( '' !== $wg_event['url'] ) : ?>
				<a href="<?php echo esc_url( $wg_event['url'] ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $wg_event['name'] ); ?><span class="sr-only"> <?php esc_html_e( '(opens in new tab)', 'restwell-retreats' ); ?></span></a>
				<?php else : ?>
					<?php echo esc_html( $wg_event['name'] ); ?>
				<?php endif; ?>
			</h3>
			<p class="place-list__meta"><?php echo implode( '–', $wg_event_dates ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo '' !== $wg_event['time'] ? esc_html( ', ' . $wg_event['time'] ) : ''; ?></p>
				<?php if ( '' !== $wg_event['venue'] ) : ?>
			<p><?php echo esc_html( $wg_event['venue'] ); ?></p>
			<?php endif; ?>
		  </li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
		<h3 class="whats-on__ahead">Plan further ahead</h3>
		<ul class="place-list whats-on__links" role="list">
			<?php foreach ( $wg_ahead as $wg_ahead_link ) : ?>
		  <li class="place-list__item">
			<h4 class="place-list__title"><a href="<?php echo esc_url( $wg_ahead_link[1] ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $wg_ahead_link[0] ); ?><span class="sr-only"> <?php esc_html_e( '(opens in new tab)', 'restwell-retreats' ); ?></span></a></h4>
			<p class="place-list__meta"><?php echo esc_html( $wg_ahead_link[2] ); ?></p>
		  </li>
			<?php endforeach; ?>
		</ul>
	  </div>
	</section>

	<?php // The FAQ and Further reading swapped bands on 29 Oct 2026 when What's on (white) arrived above them. ?>
	<section class="faq section-y band-subtle" id="faq" aria-labelledby="faq-h">
	  <div class="container">
		<div class="faq__layout">
		  <header class="faq__intro">
			<p class="eyebrow">Local access</p>
			<h2 id="faq-h">Questions about Whitstable and the coast</h2>
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
				<p>Yes, with some planning, if you stick to the paved routes. Tankerton’s level promenade works well, but loose shingle and some of the older streets don’t. Plan your parking and toilet stops, and bring a RADAR key for the Changing Places toilet at the harbour.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="whit-q2" aria-controls="whit-q2-a">
				<span>What is Whitstable like for wheelchair users?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="whit-q2-a" role="region" aria-labelledby="whit-q2" hidden>
				<p>It’s a compact seaside town with a harbour and plenty of independent shops, and the surfaces vary. From Restwell, the seafront is about ten minutes on a flat paved route. JoJo’s on Tankerton promenade is about twenty minutes in all.</p>
				<p>Stay on the paved path, because the grassy slopes above it are steep. Keep off the shingle beach, which isn’t a wheelchair surface.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="whit-q4" aria-controls="whit-q4-a">
				<span>Where can I find step-free routes on the Kent coast?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="whit-q4-a" role="region" aria-labelledby="whit-q4" hidden>
				<?php $restwell_beaches_post = get_page_by_path( 'accessible-beaches-coastal-walks-kent', OBJECT, 'post' ); ?>
				<p>Paved promenades are a better bet than shingle or steep slipways. Tankerton’s promenade, near Restwell, is the stretch we use most.
				<?php if ( $restwell_beaches_post instanceof WP_Post && 'publish' === $restwell_beaches_post->post_status ) : ?>
					Our guide to <a class="text-link" href="<?php echo esc_url( get_permalink( $restwell_beaches_post ) ); ?>">accessible beaches and coastal walks across Kent</a> covers the rest of the coast.
				<?php endif; ?>
				</p>
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
				<p>Look for a private adapted base and level routes you know about. Pick quieter times if crowds are hard, and have an indoor plan for bad weather. Restwell is that kind of base, with optional care from Continuity if you need it.</p>
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
		__( 'Tell us your chair size and how far you like to go in a day. We’ll point you to the routes that suit.', 'restwell-retreats' )
	);
	$mid_cta_primary_label = $wg_txt( 'wg_cta_primary_label', __( 'Enquire', 'restwell-retreats' ) );
	$mid_cta_primary_url   = $wg_txt( 'wg_cta_primary_url', restwell_nav_resolve_page_url( 'enquire' ) );

	$mid_cta_secondary_label = $wg_txt( 'wg_cta_secondary_label', __( 'See the bungalow', 'restwell-retreats' ) );
	$mid_cta_secondary_url   = $wg_txt( 'wg_cta_secondary_url', restwell_nav_resolve_page_url( 'the-property' ) );

	// Further reading sits above the closing CTA, as on Funding & Support, so the
	// teal CTA runs straight into the teal footer. The FAQ above is band-subtle.
	if ( function_exists( 'restwell_render_pillar_related_guides' ) ) {
		restwell_render_pillar_related_guides(
			'whitstable-area-guide',
			array(
				'heading' => $wg_related_heading,
				'intro'   => $wg_related_intro,
				'band'    => 'band-white',
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
