<?php
/**
 * Template Name: Whitstable Guide
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$pid = get_the_ID();

$hero_image_id = (int) get_post_meta( $pid, 'wg_hero_image_id', true );
$label            = (string) get_post_meta( $pid, 'wg_label', true ) ?: 'Whitstable & Kent coast';
$heading          = (string) get_post_meta( $pid, 'wg_heading', true ) ?: 'A practical local guide for your stay.';
$intro            = (string) get_post_meta( $pid, 'wg_intro', true ) ?: 'From the Tankerton promenade to harbour stops and day trips, here is what guests usually explore on a Restwell stay, with access notes woven in.';
$hero_heading_id = 'wg-hero-heading';

$sections = array(
	array(
		'key'     => 'walk',
		'eyebrow' => 'Coastal walk',
		'heading' => (string) get_post_meta( $pid, 'wg_about_heading', true ) ?: 'The promenade from Tankerton Slopes',
		'body'    => (string) get_post_meta( $pid, 'wg_about_body', true ) ?: "A paved promenade route of about two miles, west from the property at the top of Tankerton Slopes. Marine Parade clifftop is wide and flat with weather shelters and benches. At the right tide you can watch The Street, a natural shingle spit, emerge almost 800 metres into the estuary.\nSloped paths down to the beach are steep and easier with a companion for manual wheelchair users. The lower promenade then runs unbroken west past the painted beach huts to Whitstable Castle gardens, town and harbour.",
		'bg'      => 'bg-white',
	),
	array(
		'key'     => 'parking',
		'eyebrow' => 'Practical',
		'heading' => (string) get_post_meta( $pid, 'wg_getting_here_heading', true ) ?: 'Parking, plainly',
		'body'    => (string) get_post_meta( $pid, 'wg_getting_here_body', true ) ?: "Free Blue Badge bays along Marine Parade (display badge, no app). Tankerton Road Car Park gives three hours free with a physical badge.\nHeads-up: the harbour car parks (Gorrell Tank, Keam's Yard) use ANPR and need your vehicle and Blue Badge registered online beforehand. Parking at Tankerton Road and rolling along the promenade is usually easier.",
		'bg'      => 'bg-[var(--bg-subtle)] rw-seam-t',
	),
	array(
		'key'     => 'further',
		'eyebrow' => 'Day trips',
		'heading' => (string) get_post_meta( $pid, 'wg_towns_heading', true ) ?: 'Further afield',
		'body'    => (string) get_post_meta( $pid, 'wg_towns_body', true ) ?: "Wildwood Trust, Herne Bay: mostly accessible woodland paths, scooters to borrow on request. Book ahead on 01227 209621.\nDreamland, Margate: wheelchair accessible with accessible toilets. Nimbus Access Card and Essential Companion scheme accepted.\nCanterbury: Cathedral Welcome Centre lends wheelchairs; the cathedral is mostly step-free. Some cobbled streets in the centre; riverside routes and Westgate Gardens are smoother under wheels.",
		'bg'      => 'bg-white',
	),
);

$access_cards = array(
	array(
		'title' => 'Whitstable Castle & Gardens',
		'body'  => 'Paved paths through the grounds. Orangery Tearooms are step-free with an accessible loo. Dogs welcome.',
		'note'  => 'A natural pause halfway along the promenade walk.',
		'icon'  => 'castle',
	),
	array(
		'title' => 'Whitstable Harbour',
		'body'  => 'Working oyster port. South Quay Shed has a lift to a quieter upper floor. Changing Places at Whitstable Harbour WC on Harbour Road (RADAR key).',
		'note'  => 'Busier at weekends; weekday mornings are usually quieter.',
		'icon'  => 'anchor',
	),
	array(
		'title' => 'The Old Neptune',
		'body'  => 'Timber pub on the shingle. Best enjoyed from the terrace on firm ground.',
		'note'  => 'Sloping floors inside and no step-free entrance. The terrace is the practical option.',
		'icon'  => 'beer-stein',
	),
);

$access_label   = (string) get_post_meta( $pid, 'wg_access_label', true ) ?: 'Along the route';
$access_heading = (string) get_post_meta( $pid, 'wg_access_heading', true ) ?: 'Three good stops';
$access_intro   = (string) get_post_meta( $pid, 'wg_access_intro', true ) ?: 'Each stop sits on or just off the promenade route, with access notes woven in so you can plan before you set off.';

$spotlight_label   = (string) get_post_meta( $pid, 'wg_spotlight_label', true ) ?: 'Visual guide';
$spotlight_heading = (string) get_post_meta( $pid, 'wg_spotlight_heading', true ) ?: 'Key local areas at a glance';
$spotlight_intro   = (string) get_post_meta( $pid, 'wg_spotlight_intro', true ) ?: 'Photos help you picture routes and surfaces before you arrive.';

$related_label   = (string) get_post_meta( $pid, 'wg_related_label', true ) ?: 'Related reading';
$related_heading = (string) get_post_meta( $pid, 'wg_related_heading', true ) ?: 'Plan your stay with connected guides';
$related_intro   = (string) get_post_meta( $pid, 'wg_related_intro', true ) ?: 'If you are comparing locations and practical suitability, these pages answer the next common questions.';

$planning_label          = (string) get_post_meta( $pid, 'wg_planning_label', true ) ?: 'Practical stops';
$planning_heading        = (string) get_post_meta( $pid, 'wg_planning_heading', true ) ?: 'Loos along the way';
$planning_intro          = (string) get_post_meta( $pid, 'wg_planning_intro', true ) ?: 'Public toilets on and near the promenade route, including a Changing Places facility at the harbour.';
$planning_before_heading = (string) get_post_meta( $pid, 'wg_planning_before_heading', true ) ?: '';
$planning_day_heading    = (string) get_post_meta( $pid, 'wg_planning_day_heading', true ) ?: '';
$planning_before_bullets = (string) get_post_meta( $pid, 'wg_planning_before_bullets', true ) ?: "Behind the sailing club at the foot of the slopes.\nBy the Marine Parade cafe at the top.\nUnder the promenade cafe near the castle.\nChanging Places at Whitstable Harbour WC, Harbour Road.";
$planning_day_bullets    = (string) get_post_meta( $pid, 'wg_planning_day_bullets', true ) ?: '';

$eating_label   = (string) get_post_meta( $pid, 'wg_eating_label', true ) ?: 'Eating out';
$eating_heading = (string) get_post_meta( $pid, 'wg_eating_heading', true ) ?: 'Places to eat near the property';
$eating_intro   = (string) get_post_meta( $pid, 'wg_eating_intro', true ) ?: 'Three nearby options with honest access notes. Confirm details with the venue before you travel if access is critical to your plans.';
$eating_body    = (string) get_post_meta( $pid, 'wg_eating_body', true ) ?: "<strong>The Plough Inn, Swalecliffe</strong> (100 St John's Road, CT5 2RN, 01227 794636): step-free entry, no accessible toilet. Confirm in WP: full access details.\n<strong>JoJo's, Tankerton</strong> (2 Herne Bay Road, CT5 2LQ, 01227 274591): wheelchair access and accessible toilet.\n<strong>Marine Hotel, Tankerton</strong> (32-33 Marine Parade, CT5 2BE, 01227 272672): ground-floor step-free dining, accessible toilet by reception.";

$cta_heading         = (string) get_post_meta( $pid, 'wg_cta_heading', true ) ?: 'Planning your coastal break?';
$cta_body            = (string) get_post_meta( $pid, 'wg_cta_body', true ) ?: 'If you have dates in mind, get in touch and we will help you plan a stay that works for your access needs.';
$cta_primary_label   = (string) get_post_meta( $pid, 'wg_cta_primary_label', true ) ?: 'See the property';
$cta_primary_url     = (string) get_post_meta( $pid, 'wg_cta_primary_url', true ) ?: '/the-property/';
$cta_secondary_label = (string) get_post_meta( $pid, 'wg_cta_secondary_label', true ) ?: 'Ask about your dates';
$cta_secondary_url   = (string) get_post_meta( $pid, 'wg_cta_secondary_url', true ) ?: '/enquire/';
$cta_blog_label      = (string) get_post_meta( $pid, 'wg_cta_blog_label', true ) ?: 'Read local articles';
$cta_blog_url        = (string) get_post_meta( $pid, 'wg_cta_blog_url', true ) ?: '/blog/';

$restwell_wg_resolve_url = static function ( $path ) {
	$path = trim( (string) $path );
	if ( $path === '' ) {
		return '';
	}
	if ( 0 === strpos( $path, 'http' ) ) {
		return $path;
	}
	return home_url( $path );
};

$spotlight_images = array();
for ( $i = 1; $i <= 3; $i++ ) {
	$image_id = (int) get_post_meta( $pid, "wg_spotlight_image_{$i}_id", true );
	if ( ! $image_id ) {
		continue;
	}
	$image_src = wp_get_attachment_image_url( $image_id, 'large' );
	if ( ! $image_src ) {
		continue;
	}
	$image_alt = trim( wp_strip_all_tags( (string) get_post_meta( $image_id, '_wp_attachment_image_alt', true ) ) );
	$caption   = (string) get_post_meta( $pid, "wg_spotlight_image_{$i}_caption", true );
	$spotlight_images[] = array(
		'src'     => $image_src,
		'alt'     => $image_alt,
		'caption' => $caption,
	);
}

$card_hover = 'rw-surface-card rw-card-hover-lift motion-reduce:transition-none motion-reduce:hover:translate-y-0';
$body_class = 'rw-copy-body font-sans text-base leading-relaxed';
$link_class = 'text-[var(--deep-teal)] font-medium underline underline-offset-2 hover:bg-[var(--deep-teal)]/5 rounded-sm cursor-pointer transition-colors duration-200 focus:outline-none focus-visible:ring-[3px] focus-visible:ring-[var(--deep-teal)] focus-visible:ring-offset-[3px]';

$wg_glance = array(
	array(
		'stat'  => __( '~90 min', 'restwell-retreats' ),
		'label' => __( 'Typical drive from London (M2 / A299)', 'restwell-retreats' ),
		'icon'  => 'car',
	),
	array(
		'stat'  => __( '75–90 min', 'restwell-retreats' ),
		'label' => __( 'Direct trains from Victoria or St Pancras', 'restwell-retreats' ),
		'icon'  => 'train',
	),
	array(
		'stat'  => __( '20–30 min', 'restwell-retreats' ),
		'label' => __( 'Approx. walk from the property to Whitstable station (paved routes; exact time varies). Check station access with National Rail before you travel.', 'restwell-retreats' ),
		'icon'  => 'map-pin',
	),
);

?>
<main class="flex-1 page-whitstable-guide" id="main-content">
	<?php get_template_part( 'template-parts/breadcrumb' ); ?>

	<?php
	set_query_var(
		'args',
		array(
			'heading_id'      => $hero_heading_id,
			'label'           => $label,
			'heading'         => $heading,
			'intro'           => $intro,
			'media_id'        => $hero_image_id,
			'image_alt' => $heading,
		)
	);
	get_template_part( 'template-parts/interior-hero' );
	?>

	<section class="wg-glance py-0 bg-[var(--bg-subtle)] rw-seam-y-soft" aria-label="<?php esc_attr_e( 'Whitstable and travel at a glance', 'restwell-retreats' ); ?>">
		<div class="container max-w-5xl mx-auto py-10 md:py-12">
			<div class="grid w-full grid-cols-1 gap-0 divide-y divide-[var(--deep-teal)]/10 sm:grid-cols-3 sm:divide-x sm:divide-y-0">
				<?php foreach ( $wg_glance as $glance ) : ?>
					<?php $g_icon = isset( $glance['icon'] ) ? $glance['icon'] : 'dot'; ?>
					<div class="wg-glance-item flex flex-col sm:flex-row sm:items-start gap-4 py-8 text-center sm:px-6 sm:py-6 sm:first:pl-0 sm:last:pr-0 sm:text-left">
						<span class="wg-glance-item__icon flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[color-mix(in_srgb,var(--sea-glass)_30%,transparent)] text-[var(--deep-teal)] mx-auto sm:mx-0" aria-hidden="true">
							<i class="ph-bold ph-<?php echo esc_attr( $g_icon ); ?> text-lg text-[var(--deep-teal)]"></i>
						</span>
						<dl class="min-w-0 flex-1 m-0">
							<dt class="font-serif text-2xl md:text-[1.65rem] text-[var(--deep-teal)] tracking-tight leading-tight"><?php echo esc_html( $glance['stat'] ); ?></dt>
							<dd class="mt-2 text-sm font-sans leading-snug text-[var(--muted-grey)] m-0"><?php echo esc_html( $glance['label'] ); ?></dd>
						</dl>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php foreach ( $sections as $section ) : ?>
		<section class="wg-content-section rw-section-y <?php echo esc_attr( $section['bg'] ); ?>">
			<div class="container max-w-5xl mx-auto">
				<div class="wg-section-rail w-full">
					<div class="wg-section-head mb-6 md:mb-8">
						<p class="section-label mb-2"><?php echo esc_html( $section['eyebrow'] ); ?></p>
						<h2 class="text-3xl md:text-[2rem] font-serif text-[var(--deep-teal)] tracking-tight"><?php echo esc_html( $section['heading'] ); ?></h2>
					</div>
					<div class="wg-content-body <?php echo esc_attr( $body_class ); ?> space-y-5">
						<?php foreach ( preg_split( "/\\r\\n|\\r|\\n/", (string) $section['body'] ) as $line ) : ?>
							<?php if ( trim( $line ) !== '' ) : ?>
								<p class="m-0"><?php echo esc_html( $line ); ?></p>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
					<?php if ( 'walk' === $section['key'] ) : ?>
						<p class="<?php echo esc_attr( $body_class ); ?> mt-8 pt-6 border-t border-[var(--deep-teal)]/10 m-0"><?php esc_html_e( 'Read more:', 'restwell-retreats' ); ?>
							<a class="<?php echo esc_attr( $link_class ); ?>" href="<?php echo esc_url( home_url( '/accessible-beaches-coastal-walks-kent/' ) ); ?>"><?php esc_html_e( 'A guide to accessible beaches and coastal walks in Kent', 'restwell-retreats' ); ?></a>
						</p>
						<p class="<?php echo esc_attr( $body_class ); ?> mt-6 m-0 max-w-[65ch]">
							<?php esc_html_e( 'Staying at Restwell puts Whitstable on your doorstep. For kit, access, and layout,', 'restwell-retreats' ); ?>
							<a class="<?php echo esc_attr( $link_class ); ?>" href="<?php echo esc_url( home_url( '/the-property/' ) ); ?>"><?php esc_html_e( 'see the adapted bungalow', 'restwell-retreats' ); ?></a><?php esc_html_e( '. When you are ready,', 'restwell-retreats' ); ?>
							<a class="<?php echo esc_attr( $link_class ); ?>" href="<?php echo esc_url( home_url( '/enquire/' ) ); ?>"><?php esc_html_e( 'get in touch about your stay', 'restwell-retreats' ); ?></a>.
						</p>
					<?php endif; ?>
				<?php if ( 'parking' === $section['key'] ) : ?>
					<p class="<?php echo esc_attr( $body_class ); ?> mt-8 pt-6 border-t border-[var(--deep-teal)]/10 m-0"><?php esc_html_e( 'For more on Blue Badge bays and harbour car parks, see our', 'restwell-retreats' ); ?>
						<a class="<?php echo esc_attr( $link_class ); ?>" href="<?php echo esc_url( home_url( '/accessible-parking-whitstable-tankerton/' ) ); ?>"><?php esc_html_e( 'accessible parking guide for Whitstable and Tankerton', 'restwell-retreats' ); ?></a>.
					</p>
				<?php endif; ?>
				</div>
			</div>
		</section>
	<?php endforeach; ?>

	<section class="wg-content-section rw-section-y bg-[var(--bg-subtle)] rw-seam-t" aria-labelledby="wg-access-heading">
		<div class="container max-w-5xl mx-auto">
			<div class="wg-section-rail w-full">
				<div class="wg-section-head mb-10 md:mb-12">
					<p class="section-label mb-2"><?php echo esc_html( $access_label ); ?></p>
					<h2 id="wg-access-heading" class="text-3xl md:text-[2rem] font-serif text-[var(--deep-teal)] tracking-tight mb-5 md:mb-6"><?php echo esc_html( $access_heading ); ?></h2>
					<p class="<?php echo esc_attr( $body_class ); ?> max-w-[65ch]"><?php echo esc_html( $access_intro ); ?></p>
				</div>
				<div class="grid grid-cols-1 gap-7 md:gap-8 md:grid-cols-3 sm:items-stretch">
				<?php
				$wg_card_i = 0;
				foreach ( $access_cards as $card ) :
					++$wg_card_i;
					$icon = isset( $card['icon'] ) ? $card['icon'] : 'dot';
					?>
					<div class="wg-access-card min-w-0 bg-white rounded-2xl p-8 md:p-9 h-full flex flex-col <?php echo esc_attr( $card_hover ); ?>">
						<div class="flex gap-4">
							<span class="wg-access-card__icon flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[color-mix(in_srgb,var(--sea-glass)_35%,transparent)] text-[var(--deep-teal)] shadow-[inset_0_1px_0_rgba(255,255,255,0.65)]" aria-hidden="true">
								<i class="ph-bold ph-<?php echo esc_attr( $icon ); ?> text-lg text-[var(--deep-teal)]"></i>
							</span>
							<div class="min-w-0 flex-1">
								<p class="section-label mb-2 !text-xs !tracking-[0.18em]"><?php echo esc_html( sprintf( '%02d', $wg_card_i ) ); ?></p>
								<h3 class="text-xl font-serif text-[var(--deep-teal)] mb-4"><?php echo esc_html( $card['title'] ); ?></h3>
								<p class="<?php echo esc_attr( $body_class ); ?> mb-4"><?php echo esc_html( $card['body'] ); ?></p>
							</div>
						</div>
						<p class="text-sm text-[var(--muted-grey)] leading-relaxed border-t border-[var(--deep-teal)]/10 pt-4 mt-auto pl-0 sm:pl-16"><?php echo esc_html( $card['note'] ); ?></p>
					</div>
				<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>

	<?php if ( ! empty( $spotlight_images ) ) : ?>
	<section class="wg-content-section rw-section-y bg-[var(--soft-sand)] rw-seam-t" aria-labelledby="wg-visual-guide-heading">
		<div class="container max-w-5xl mx-auto">
			<div class="wg-section-rail w-full">
				<div class="wg-section-head mb-10 md:mb-12">
					<p class="section-label mb-2"><?php echo esc_html( $spotlight_label ); ?></p>
					<h2 id="wg-visual-guide-heading" class="text-3xl md:text-[2rem] font-serif text-[var(--deep-teal)] tracking-tight mb-5 md:mb-6"><?php echo esc_html( $spotlight_heading ); ?></h2>
					<p class="<?php echo esc_attr( $body_class ); ?> max-w-[65ch]"><?php echo esc_html( $spotlight_intro ); ?></p>
				</div>
				<div class="grid grid-cols-1 gap-6 md:grid-cols-3">
				<?php foreach ( $spotlight_images as $image ) : ?>
					<?php
					$img_alt = $image['alt'];
					if ( $img_alt === '' ) {
						$img_alt = $image['caption'] !== '' ? $image['caption'] : __( 'Local area photo', 'restwell-retreats' );
					}
					?>
					<figure class="bg-white rounded-2xl overflow-hidden <?php echo esc_attr( $card_hover ); ?>">
						<img src="<?php echo esc_url( $image['src'] ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>" class="w-full aspect-[4/3] object-cover" loading="lazy" decoding="async" />
						<?php if ( $image['caption'] !== '' ) : ?>
							<figcaption class="px-5 py-4 text-sm text-[var(--body-secondary)] leading-relaxed"><?php echo esc_html( $image['caption'] ); ?></figcaption>
						<?php endif; ?>
					</figure>
				<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<section class="wg-content-section rw-section-y bg-white rw-seam-t" aria-labelledby="wg-related-reading-heading">
		<div class="container max-w-5xl mx-auto">
			<div class="wg-section-rail w-full">
				<div class="wg-section-head mb-8 md:mb-10">
					<p class="section-label mb-2"><?php echo esc_html( $related_label ); ?></p>
					<h2 id="wg-related-reading-heading" class="text-3xl md:text-[2rem] font-serif text-[var(--deep-teal)] tracking-tight mb-5 md:mb-6"><?php echo esc_html( $related_heading ); ?></h2>
					<p class="<?php echo esc_attr( $body_class ); ?> max-w-[65ch]"><?php echo esc_html( $related_intro ); ?></p>
				</div>
				<div class="flex flex-col flex-wrap items-stretch gap-4 sm:flex-row sm:items-center md:gap-5">
				<a class="btn btn-outline w-full sm:w-auto justify-center whitespace-normal text-center leading-snug px-6" href="<?php echo esc_url( home_url( '/accessible-beaches-coastal-walks-kent/' ) ); ?>"><?php esc_html_e( 'Accessible beaches on the Kent coast', 'restwell-retreats' ); ?></a>
				<a class="btn btn-outline w-full sm:w-auto justify-center whitespace-normal text-center leading-snug px-6" href="<?php echo esc_url( home_url( '/who-its-for/' ) ); ?>"><?php esc_html_e( 'Who Restwell is for', 'restwell-retreats' ); ?></a>
				<a class="btn btn-outline w-full sm:w-auto justify-center whitespace-normal text-center leading-snug px-6" href="<?php echo esc_url( home_url( '/direct-payment-holiday-accommodation/' ) ); ?>"><?php esc_html_e( 'Using direct payments for holidays', 'restwell-retreats' ); ?></a>
			<a class="btn btn-outline w-full sm:w-auto justify-center whitespace-normal text-center leading-snug px-6" href="<?php echo esc_url( home_url( '/carers-respite-holiday-guide/' ) ); ?>"><?php esc_html_e( "Carers' respite: rights and funding", 'restwell-retreats' ); ?></a>
			<a class="btn btn-outline w-full sm:w-auto justify-center whitespace-normal text-center leading-snug px-6" href="<?php echo esc_url( home_url( '/faq/' ) ); ?>"><?php esc_html_e( 'Booking and planning FAQs', 'restwell-retreats' ); ?></a>
			</div>
			</div>
		</div>
	</section>

	<section class="wg-content-section rw-section-y bg-[var(--bg-subtle)] rw-seam-t" aria-labelledby="wg-planning-heading">
		<div class="container max-w-5xl mx-auto">
			<div class="wg-section-rail w-full">
				<div class="wg-section-head mb-8 md:mb-10">
					<p class="section-label mb-2"><?php echo esc_html( $planning_label ); ?></p>
					<h2 id="wg-planning-heading" class="text-3xl md:text-[2rem] font-serif text-[var(--deep-teal)] tracking-tight mb-5 md:mb-6"><?php echo esc_html( $planning_heading ); ?></h2>
					<p class="<?php echo esc_attr( $body_class ); ?> max-w-[65ch]"><?php echo esc_html( $planning_intro ); ?></p>
				</div>
				<div class="wg-planning-card min-w-0 bg-white rounded-2xl p-8 md:p-9 <?php echo esc_attr( $card_hover ); ?>">
					<ul class="wg-planning-card__list space-y-3 font-sans text-[var(--body-secondary)] text-base leading-relaxed list-disc pl-5 marker:text-[var(--deep-teal)] m-0">
						<?php foreach ( preg_split( "/\\r\\n|\\r|\\n/", $planning_before_bullets ) as $bullet ) : ?>
							<?php if ( trim( $bullet ) !== '' ) : ?>
								<li><?php echo esc_html( $bullet ); ?></li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</div>
	</section>

	<section class="wg-content-section rw-section-y bg-white rw-seam-t" aria-labelledby="wg-eating-heading">
		<div class="container max-w-5xl mx-auto">
			<div class="wg-section-rail w-full">
				<div class="wg-section-head <?php echo $eating_intro !== '' ? 'mb-8 md:mb-10' : 'mb-6 md:mb-8'; ?>">
					<p class="section-label mb-2"><?php echo esc_html( $eating_label ); ?></p>
					<h2 id="wg-eating-heading" class="text-3xl md:text-[2rem] font-serif text-[var(--deep-teal)] tracking-tight <?php echo $eating_intro !== '' ? 'mb-5 md:mb-6' : 'mb-0'; ?>"><?php echo esc_html( $eating_heading ); ?></h2>
					<?php if ( $eating_intro !== '' ) : ?>
						<p class="<?php echo esc_attr( $body_class ); ?> mb-0 max-w-[65ch]"><?php echo esc_html( $eating_intro ); ?></p>
					<?php endif; ?>
				</div>
			<div class="wg-content-body wg-eating-body space-y-5 <?php echo esc_attr( $body_class ); ?> border-t border-[var(--deep-teal)]/10 pt-8 md:pt-10">
				<?php foreach ( preg_split( "/\\r\\n|\\r|\\n/", $eating_body ) as $para ) : ?>
					<?php if ( trim( $para ) !== '' ) : ?>
						<p class="m-0"><?php echo wp_kses_post( $para ); ?></p>
					<?php endif; ?>
				<?php endforeach; ?>
				<p class="m-0 pt-6 border-t border-[var(--deep-teal)]/10 <?php echo esc_attr( $body_class ); ?>"><?php esc_html_e( 'For full details on the property and equipment,', 'restwell-retreats' ); ?>
					<a class="<?php echo esc_attr( $link_class ); ?>" href="<?php echo esc_url( home_url( '/the-property/' ) ); ?>"><?php esc_html_e( 'see the adapted bungalow', 'restwell-retreats' ); ?></a>.
					<?php esc_html_e( 'When you are ready,', 'restwell-retreats' ); ?>
					<a class="<?php echo esc_attr( $link_class ); ?>" href="<?php echo esc_url( home_url( '/enquire/' ) ); ?>"><?php esc_html_e( 'get in touch about your stay', 'restwell-retreats' ); ?></a>.
					<?php esc_html_e( 'For in-depth access notes on specific beaches and promenades along this stretch of coast, read our', 'restwell-retreats' ); ?>
					<a class="<?php echo esc_attr( $link_class ); ?>" href="<?php echo esc_url( home_url( '/accessible-beaches-coastal-walks-kent/' ) ); ?>"><?php esc_html_e( 'guide to accessible beaches in Kent', 'restwell-retreats' ); ?></a>.
				</p>
			</div>
			</div>
		</div>
	</section>

	<section class="rw-section-y--cta bg-[var(--deep-teal)] rw-seam-t" aria-labelledby="wg-cta-heading">
		<div class="container max-w-3xl mx-auto text-center">
			<h2 id="wg-cta-heading" class="text-3xl md:text-4xl font-serif text-white mb-4 tracking-tight text-balance"><?php echo esc_html( $cta_heading ); ?></h2>
			<p class="text-white/85 text-lg leading-relaxed mb-8 max-w-2xl mx-auto text-pretty"><?php echo esc_html( $cta_body ); ?></p>
			<div class="flex flex-col flex-wrap items-center justify-center gap-4 sm:flex-row">
				<?php if ( $cta_primary_label !== '' && $cta_primary_url !== '' ) : ?>
					<a href="<?php echo esc_url( $restwell_wg_resolve_url( $cta_primary_url ) ); ?>" class="btn btn-gold">
						<?php echo esc_html( $cta_primary_label ); ?>
						<i class="ph-bold ph-arrow-right" aria-hidden="true"></i>
					</a>
				<?php endif; ?>
				<?php if ( $cta_secondary_label !== '' && $cta_secondary_url !== '' ) : ?>
					<a href="<?php echo esc_url( $restwell_wg_resolve_url( $cta_secondary_url ) ); ?>" class="btn btn-ghost-light">
						<?php echo esc_html( $cta_secondary_label ); ?>
					</a>
				<?php endif; ?>
			</div>
			<?php if ( $cta_blog_label !== '' && $cta_blog_url !== '' ) : ?>
				<p class="mt-6 mb-0">
					<a class="text-white/90 font-medium underline underline-offset-[0.28em] decoration-white/60 hover:text-[var(--warm-gold-hero)] hover:decoration-[var(--warm-gold-hero)] focus:outline-none focus-visible:ring-2 focus-visible:ring-white/70 rounded-sm transition-colors duration-200" href="<?php echo esc_url( $restwell_wg_resolve_url( $cta_blog_url ) ); ?>">
						<?php echo esc_html( $cta_blog_label ); ?>
					</a>
				</p>
			<?php endif; ?>
		</div>
	</section>

</main>
<?php get_footer(); ?>
