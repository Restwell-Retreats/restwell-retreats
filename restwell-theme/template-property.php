<?php
/**
 * Template Name: The Property
 * Page template for the property page with editable meta fields.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$GLOBALS['restwell_hide_footer_cta'] = true;

$pid = get_the_ID();
$d   = restwell_get_property_page_defaults();
$prop_meta   = function ( $key ) use ( $pid, $d ) {
	return restwell_post_meta_or_default( $pid, $key, $d );
};
$m_url = function ( $key ) use ( $pid, $d ) {
	return restwell_post_meta_url( $pid, $key, $d );
};

$prop_hero_label              = $prop_meta( 'prop_hero_label' );
$prop_hero_heading            = function_exists( 'restwell_get_property_heading' )
	? restwell_get_property_heading( $pid, 'prop_hero_heading' )
	: $prop_meta( 'prop_hero_heading' );
$prop_hero_subtitle           = $prop_meta( 'prop_hero_subtitle' );
$prop_hero_cta_text           = $prop_meta( 'prop_hero_cta_text' );
$prop_hero_cta_url            = esc_url( $m_url( 'prop_hero_cta_url' ) );
$prop_hero_cta_promise        = $prop_meta( 'prop_hero_cta_promise' );
$prop_hero_cta_secondary_text = $prop_meta( 'prop_hero_cta_secondary_text' );
$prop_hero_cta_secondary_url  = esc_url( $m_url( 'prop_hero_cta_secondary_url' ) );

$prop_hero_image_id = function_exists( 'restwell_resolve_property_hero_image_id' )
	? restwell_resolve_property_hero_image_id( $pid )
	: (int) $prop_meta( 'prop_hero_image_id' );

$prop_bungalow_label    = $prop_meta( 'prop_bungalow_label' );
$prop_bungalow_heading  = function_exists( 'restwell_get_property_heading' )
	? restwell_get_property_heading( $pid, 'prop_bungalow_heading' )
	: $prop_meta( 'prop_bungalow_heading' );
$prop_bungalow_body     = $prop_meta( 'prop_bungalow_body' );
$prop_bungalow_image_id = (int) $prop_meta( 'prop_bungalow_image_id' );

$prop_features_label = function_exists( 'restwell_sanitize_property_section_label' )
	? restwell_sanitize_property_section_label( $prop_meta( 'prop_features_label' ) )
	: trim( (string) $prop_meta( 'prop_features_label' ) );

$prop_gallery_label   = $prop_meta( 'prop_gallery_label' );
$prop_gallery_heading = function_exists( 'restwell_get_property_heading' )
	? restwell_get_property_heading( $pid, 'prop_gallery_heading' )
	: $prop_meta( 'prop_gallery_heading' );
$prop_gallery_ids     = restwell_get_property_gallery_ids( $pid );

$prop_cta_heading = $prop_meta( 'prop_cta_heading' );
$prop_cta_body    = $prop_meta( 'prop_cta_body' );
$prop_cta_btn     = $prop_meta( 'prop_cta_btn' );
$prop_cta_url     = esc_url( $m_url( 'prop_cta_url' ) );
$prop_cta_promise = $prop_meta( 'prop_cta_promise' );

$prop_tldr_markup = function_exists( 'restwell_get_tldr_markup' ) ? restwell_get_tldr_markup( $pid, '' ) : '';

$prop_primary_cta = array(
	'label' => $prop_hero_cta_text,
	'url'   => $prop_hero_cta_url,
);

$prop_room_tour = function_exists( 'restwell_get_property_room_tour_with_features' )
	? restwell_get_property_room_tour_with_features( $pid )
	: array();

$prop_care_heading     = function_exists( 'restwell_get_property_heading' )
	? restwell_get_property_heading( $pid, 'prop_care_heading' )
	: $prop_meta( 'prop_care_heading' );
$prop_care_body        = $prop_meta( 'prop_care_body' );
$prop_location_heading = function_exists( 'restwell_get_property_heading' )
	? restwell_get_property_heading( $pid, 'prop_location_heading' )
	: $prop_meta( 'prop_location_heading' );
$prop_location_body    = $prop_meta( 'prop_location_body' );
$prop_location_image_id = (int) $prop_meta( 'prop_location_image_id' );
$prop_location_has_photo = $prop_location_image_id > 0 && wp_attachment_is_image( $prop_location_image_id );

$prop_practical_label   = function_exists( 'restwell_sanitize_property_section_label' )
	? restwell_sanitize_property_section_label( $prop_meta( 'prop_practical_label' ) )
	: trim( (string) $prop_meta( 'prop_practical_label' ) );
$prop_practical_heading = function_exists( 'restwell_get_property_practical_heading' )
	? restwell_get_property_practical_heading( $pid )
	: $prop_meta( 'prop_practical_heading' );
$prop_essentials_stats  = function_exists( 'restwell_get_property_essentials_stats' )
	? restwell_get_property_essentials_stats( $pid )
	: array();
$prop_confirm_details_url = esc_url( $m_url( 'prop_confirm_details_url' ) );

$prop_verified_facts = function_exists( 'restwell_get_property_facts' )
	? restwell_get_property_facts()
	: array();

$prop_nearby_label   = $prop_meta( 'prop_nearby_label' );
$prop_nearby_heading = function_exists( 'restwell_get_property_heading' )
	? restwell_get_property_heading( $pid, 'prop_nearby_heading' )
	: trim( (string) $prop_meta( 'prop_nearby_heading' ) );
$prop_nearby_places = function_exists( 'restwell_get_property_nearby_places' )
	? restwell_get_property_nearby_places( $pid )
	: array();
$prop_nearby_cta_label = $prop_meta( 'prop_nearby_cta_label' );
$prop_nearby_cta_url   = esc_url( $m_url( 'prop_nearby_cta_url' ) );

$area_guide_url = esc_url( home_url( '/whitstable-area-guide/' ) );
$access_url     = esc_url( home_url( '/accessibility/' ) );
$enquire_url    = esc_url( home_url( '/enquire/' ) );

$prop_nav_items = array(
	array(
		'id'    => 'prop-overview',
		'label' => __( 'Overview', 'restwell-retreats' ),
	),
);
if ( ! empty( $prop_room_tour ) ) {
	foreach ( $prop_room_tour as $tour_nav ) {
		$room_nav_key = (string) ( $tour_nav['key'] ?? '' );
		if ( $room_nav_key === '' ) {
			continue;
		}
		$prop_nav_items[] = array(
			'id'    => 'prop-room-' . $room_nav_key,
			'label' => function_exists( 'restwell_get_property_room_nav_label' )
				? restwell_get_property_room_nav_label( $tour_nav )
				: (string) ( $tour_nav['heading'] ?? '' ),
		);
	}
}
if ( ! empty( $prop_essentials_stats ) ) {
	$prop_nav_items[] = array(
		'id'    => 'prop-numbers',
		'label' => __( 'Capacity', 'restwell-retreats' ),
	);
}
if ( ! empty( $prop_gallery_ids ) ) {
	$prop_nav_items[] = array(
		'id'    => 'property-gallery',
		'label' => __( 'Photos', 'restwell-retreats' ),
	);
}
if ( $prop_care_heading !== '' || $prop_care_body !== '' ) {
	$prop_nav_items[] = array(
		'id'    => 'prop-care',
		'label' => __( 'Care', 'restwell-retreats' ),
	);
}
if ( $prop_location_heading !== '' || $prop_location_body !== '' ) {
	$prop_nav_items[] = array(
		'id'    => 'prop-location',
		'label' => __( 'Location', 'restwell-retreats' ),
	);
}
if ( ! empty( $prop_nearby_places ) ) {
	$prop_nav_items[] = array(
		'id'    => 'prop-nearby',
		'label' => __( 'Nearby', 'restwell-retreats' ),
	);
}

$prop_hero_secondary = array();
if ( $prop_hero_cta_secondary_text !== '' ) {
	$prop_hero_secondary = array(
		'label' => $prop_hero_cta_secondary_text,
		'url'   => $prop_hero_cta_secondary_url,
	);
} elseif ( ! empty( $prop_gallery_ids ) ) {
	$prop_hero_secondary = array(
		'label' => __( 'View photos', 'restwell-retreats' ),
		'url'   => '#property-gallery',
	);
}

$prop_band_index = 0;
$prop_section_bg = static function ( $index ) {
	return function_exists( 'restwell_get_property_section_bg_class' )
		? restwell_get_property_section_bg_class( $index )
		: ( 0 === ( (int) $index % 2 ) ? 'bg-white' : 'bg-[var(--bg-subtle)]' );
};
?>
<main class="flex-1 prop-page" id="main-content">
<?php get_template_part( 'template-parts/breadcrumb' ); ?>
	<?php
	set_query_var(
		'args',
		array(
			'heading_id'           => 'page-hero-heading',
			'label'                => $prop_hero_label,
			'heading'              => $prop_hero_heading,
			'intro'                => $prop_hero_subtitle,
			'media_id'             => $prop_hero_image_id,
			'image_alt'            => $prop_hero_heading,
			'append_after_h1_html' => $prop_tldr_markup,
			'cta_primary'          => $prop_primary_cta['label'] !== '' ? $prop_primary_cta : array(),
			'cta_secondary'        => $prop_hero_secondary,
			'cta_promise'          => $prop_hero_cta_promise,
		)
	);
	get_template_part( 'template-parts/interior-hero' );
	?>

	<?php if ( count( $prop_nav_items ) > 1 ) : ?>
	<nav class="prop-page-nav sticky z-30 border-b border-[var(--prop-subnav-border)] bg-white/95 backdrop-blur-sm shadow-[0_1px_0_rgba(0,0,0,0.04)]" aria-label="<?php esc_attr_e( 'On this page: section navigation', 'restwell-retreats' ); ?>">
		<div class="container max-w-5xl px-0 sm:px-4">
			<p class="sr-only"><?php esc_html_e( 'Jump to a section on this page', 'restwell-retreats' ); ?></p>
			<p class="prop-page-nav__hint md:hidden" id="prop-page-nav-hint">
				<?php esc_html_e( 'Swipe sideways to see every section.', 'restwell-retreats' ); ?>
			</p>
			<div class="prop-page-nav__track">
				<ul class="prop-page-nav__list">
					<?php foreach ( $prop_nav_items as $nav_item ) : ?>
					<li>
						<a class="prop-page-nav__link" href="<?php echo esc_url( '#' . $nav_item['id'] ); ?>" data-prop-anchor="<?php echo esc_attr( $nav_item['id'] ); ?>">
							<?php echo esc_html( $nav_item['label'] ); ?>
						</a>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</nav>
	<?php endif; ?>

	<section id="prop-overview" class="prop-page__anchor rw-section-y <?php echo esc_attr( $prop_section_bg( $prop_band_index++ ) ); ?> scroll-mt-28" aria-labelledby="prop-intro-heading">
		<div class="container max-w-5xl">
			<div class="rw-section-head rw-section-head--center">
				<?php if ( $prop_bungalow_label !== '' ) : ?>
					<?php get_template_part( 'template-parts/section-label', null, array( 'label' => $prop_bungalow_label ) ); ?>
				<?php endif; ?>
				<h2 id="prop-intro-heading" class="text-3xl md:text-4xl font-serif text-[var(--deep-teal)] m-0 leading-tight text-balance"><?php echo esc_html( $prop_bungalow_heading ); ?></h2>
			</div>
			<div class="prop-page__intro-split <?php echo $prop_bungalow_image_id > 0 ? 'md:grid md:grid-cols-2 md:items-center rw-gap-grid' : ''; ?>">
				<div class="prop-page__intro-copy max-w-prose <?php echo $prop_bungalow_image_id > 0 ? 'prop-page__copy--column' : 'mx-auto prop-page__copy--center'; ?>">
					<div class="rw-copy-body rw-prose-stack leading-relaxed">
						<?php echo wp_kses_post( wpautop( $prop_bungalow_body ) ); ?>
					</div>
				</div>
				<?php if ( $prop_bungalow_image_id > 0 ) : ?>
				<div class="prop-page__intro-media mt-10 md:mt-0">
					<?php
					if ( function_exists( 'restwell_get_property_attachment_image' ) ) {
						echo restwell_get_property_attachment_image(
							$prop_bungalow_image_id,
							'intro',
							array(
								'class' => 'prop-page__intro-img w-full aspect-[4/3] object-cover rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)]',
								'alt'   => $prop_bungalow_heading,
							)
						);
					} else {
						echo wp_get_attachment_image(
							$prop_bungalow_image_id,
							'large',
							false,
							array(
								'class'    => 'prop-page__intro-img w-full aspect-[4/3] object-cover rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)]',
								'alt'      => $prop_bungalow_heading,
								'loading'  => 'lazy',
								'decoding' => 'async',
							)
						);
					}
					?>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<?php if ( ! empty( $prop_room_tour ) ) : ?>
		<?php
		foreach ( $prop_room_tour as $tour_index => $tour ) :
			$room_key       = (string) ( $tour['key'] ?? '' );
			if ( $room_key === '' ) {
				continue;
			}
			$section_id     = 'prop-room-' . $room_key;
			$heading_id     = $section_id . '-heading';
			$image_first    = 0 === ( $tour_index % 2 );
			$image_id       = (int) ( $tour['image_id'] ?? 0 );
			$image_confirm  = (string) ( $tour['image_confirm'] ?? 'room photo' );
			$highlights     = is_array( $tour['highlights'] ?? null ) ? $tour['highlights'] : array();
			$section_bg     = $prop_section_bg( $prop_band_index++ );
			$room_eyebrow   = function_exists( 'restwell_get_property_room_nav_label' )
				? restwell_get_property_room_nav_label( $tour )
				: '';
			$highlights_class = 'prop-room-tour__highlights m-0 list-none p-0';
			if ( ! empty( $tour['body'] ) ) {
				$highlights_class .= ' mt-6';
			}
			?>
	<section id="<?php echo esc_attr( $section_id ); ?>" class="prop-page__anchor prop-page__room-section rw-section-y <?php echo esc_attr( $section_bg ); ?> scroll-mt-28" aria-labelledby="<?php echo esc_attr( $heading_id ); ?>">
		<div class="container max-w-5xl">
			<div class="rw-section-head rw-section-head--center">
				<?php if ( 0 === $tour_index && $prop_features_label !== '' ) : ?>
					<?php get_template_part( 'template-parts/section-label', null, array( 'label' => $prop_features_label ) ); ?>
				<?php elseif ( $room_eyebrow !== '' ) : ?>
					<?php get_template_part( 'template-parts/section-label', null, array( 'label' => $room_eyebrow ) ); ?>
				<?php elseif ( 0 === $tour_index ) : ?>
					<?php get_template_part( 'template-parts/section-label', null, array( 'label' => __( 'Around the house', 'restwell-retreats' ) ) ); ?>
				<?php endif; ?>
				<h2 id="<?php echo esc_attr( $heading_id ); ?>" class="text-3xl md:text-4xl font-serif text-[var(--deep-teal)] m-0 leading-tight text-balance"><?php echo esc_html( (string) ( $tour['heading'] ?? '' ) ); ?></h2>
			</div>
			<div class="prop-room-tour__layout grid gap-8 lg:gap-12 items-center md:grid-cols-2">
				<?php if ( $image_id > 0 ) : ?>
					<div class="<?php echo esc_attr( $image_first ? 'order-1' : 'order-1 md:order-2' ); ?>">
							<div class="prop-room-tour__figure">
								<?php
								if ( function_exists( 'restwell_get_property_attachment_image' ) ) {
									echo restwell_get_property_attachment_image(
										$image_id,
										'room',
										array(
											'class' => 'prop-room-tour__img',
											'alt'   => (string) ( $tour['heading'] ?? '' ),
										)
									);
								} else {
									echo wp_get_attachment_image(
										$image_id,
										'large',
										false,
										array(
											'class'    => 'prop-room-tour__img',
											'alt'      => (string) ( $tour['heading'] ?? '' ),
											'loading'  => 'lazy',
											'decoding' => 'async',
										)
									);
								}
								?>
							</div>
					</div>
				<?php else : ?>
					<!-- Confirm in WP: needs a <?php echo esc_html( $image_confirm ); ?>. -->
					<div class="<?php echo esc_attr( $image_first ? 'order-1' : 'order-1 md:order-2' ); ?>" aria-hidden="true">
						<div class="prop-room-tour__figure prop-room-tour__figure--empty"></div>
					</div>
				<?php endif; ?>
				<div class="<?php echo esc_attr( $image_first ? 'order-2' : 'order-2 md:order-1' ); ?>">
					<?php if ( ! empty( $tour['body'] ) ) : ?>
					<div class="rw-copy-body max-w-prose leading-relaxed prop-page__copy--column">
						<?php echo wp_kses_post( wpautop( (string) ( $tour['body'] ?? '' ) ) ); ?>
					</div>
					<?php endif; ?>
					<?php if ( ! empty( $highlights ) ) : ?>
					<ul class="<?php echo esc_attr( $highlights_class ); ?>" role="list">
						<?php foreach ( $highlights as $highlight ) : ?>
						<li class="prop-room-tour__highlight">
							<span class="prop-room-tour__highlight-icon" aria-hidden="true">
								<i class="ph-bold ph-check"></i>
							</span>
							<div class="prop-room-tour__highlight-copy">
								<strong class="prop-room-tour__highlight-title"><?php echo esc_html( (string) ( $highlight['title'] ?? '' ) ); ?></strong>
								<?php if ( ! empty( $highlight['desc'] ) ) : ?>
								<span class="prop-room-tour__highlight-desc"><?php echo esc_html( (string) $highlight['desc'] ); ?></span>
								<?php endif; ?>
							</div>
						</li>
						<?php endforeach; ?>
					</ul>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
		<?php endforeach; ?>
	<?php endif; ?>

	<?php if ( ! empty( $prop_essentials_stats ) ) : ?>
	<section id="prop-numbers" class="prop-page__anchor rw-section-y <?php echo esc_attr( $prop_section_bg( $prop_band_index++ ) ); ?> scroll-mt-28" aria-labelledby="prop-numbers-heading">
		<div class="container max-w-5xl">
			<div class="rw-section-head rw-section-head--center">
				<?php if ( $prop_practical_label !== '' ) : ?>
					<?php get_template_part( 'template-parts/section-label', null, array( 'label' => $prop_practical_label ) ); ?>
				<?php endif; ?>
				<h2 id="prop-numbers-heading" class="text-3xl md:text-4xl font-serif text-[var(--deep-teal)] m-0 leading-tight text-balance"><?php echo esc_html( $prop_practical_heading ); ?></h2>
			</div>

			<div class="prop-page__essentials-open">
					<?php
					foreach ( $prop_essentials_stats as $stat ) :
						if ( $stat['value'] === '' ) {
							continue;
						}
						?>
					<div class="prop-page__essential-tile flex flex-col items-center text-center gap-3 p-6 md:p-7 h-full">
						<span class="prop-page__essential-icon" aria-hidden="true">
							<i class="ph-bold ph-<?php echo esc_attr( $stat['icon'] ); ?>"></i>
						</span>
						<p class="prop-page__essential-value m-0 font-serif text-3xl md:text-4xl text-[var(--deep-teal)] leading-none"><?php echo esc_html( $stat['value'] ); ?></p>
						<p class="prop-page__essential-label m-0 text-sm font-semibold text-[var(--deep-teal)] leading-snug"><?php echo esc_html( $stat['label'] ); ?></p>
						<?php if ( ! empty( $stat['detail'] ) || ! empty( $stat['detail_html'] ) ) : ?>
						<p class="prop-page__essential-detail m-0 text-sm leading-relaxed text-[var(--muted-grey)]">
							<?php
							if ( ! empty( $stat['detail_html'] ) ) {
								echo wp_kses_post( (string) $stat['detail_html'] );
							} else {
								echo esc_html( (string) $stat['detail'] );
							}
							?>
						</p>
						<?php endif; ?>
					</div>
					<?php endforeach; ?>
			</div>

			<?php if ( ! empty( $prop_verified_facts ) ) : ?>
			<div class="prop-page__verified-facts mt-10 md:mt-12 max-w-4xl mx-auto">
				<h3 class="text-xl font-serif text-[var(--deep-teal)] m-0 mb-6 text-center"><?php esc_html_e( 'Verified specs', 'restwell-retreats' ); ?></h3>
				<div class="grid sm:grid-cols-3 rw-gap-grid">
					<?php
					$fact_groups = array(
						'access'    => __( 'Access', 'restwell-retreats' ),
						'sleeping'  => __( 'Sleeping', 'restwell-retreats' ),
						'practical' => __( 'Practical', 'restwell-retreats' ),
					);
					foreach ( $fact_groups as $group_key => $group_label ) :
						$group_facts = isset( $prop_verified_facts[ $group_key ] ) && is_array( $prop_verified_facts[ $group_key ] )
							? $prop_verified_facts[ $group_key ]
							: array();
						if ( empty( $group_facts ) ) {
							continue;
						}
						?>
					<div class="prop-page__verified-facts-group rounded-2xl border border-gray-100 bg-white p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
						<p class="section-label m-0 mb-4"><?php echo esc_html( $group_label ); ?></p>
						<ul class="m-0 list-none space-y-3 p-0 text-sm leading-relaxed text-[var(--muted-grey)]" role="list">
							<?php foreach ( $group_facts as $fact_label ) : ?>
							<li class="flex items-start gap-3">
								<span class="prop-room-tour__highlight-icon shrink-0" aria-hidden="true">
									<i class="ph-bold ph-check"></i>
								</span>
								<span class="min-w-0"><?php echo esc_html( (string) $fact_label ); ?></span>
							</li>
							<?php endforeach; ?>
						</ul>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
			<?php endif; ?>

			<p class="text-center text-[var(--muted-grey)] text-sm md:text-base mt-8 mb-0 max-w-prose mx-auto">
				<?php esc_html_e( 'Full measurements and equipment detail:', 'restwell-retreats' ); ?>
				<a href="<?php echo esc_url( $access_url ); ?>" class="rw-link-prose rw-link-prose--focus"><?php esc_html_e( 'accessibility page', 'restwell-retreats' ); ?></a>.
				<?php esc_html_e( 'Questions?', 'restwell-retreats' ); ?>
				<a href="<?php echo esc_url( $prop_confirm_details_url ); ?>" class="rw-link-prose rw-link-prose--focus"><?php esc_html_e( 'Get in touch', 'restwell-retreats' ); ?></a>.
			</p>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( ! empty( $prop_gallery_ids ) ) : ?>
	<section id="property-gallery" class="prop-page__anchor rw-section-y <?php echo esc_attr( $prop_section_bg( $prop_band_index++ ) ); ?> scroll-mt-28" aria-labelledby="property-gallery-heading">
		<div class="container max-w-5xl">
			<div class="rw-section-head rw-section-head--center">
				<?php if ( $prop_gallery_label !== '' ) : ?>
					<?php get_template_part( 'template-parts/section-label', null, array( 'label' => $prop_gallery_label ) ); ?>
				<?php endif; ?>
				<h2 id="property-gallery-heading" class="text-3xl md:text-4xl font-serif text-[var(--deep-teal)] m-0 leading-tight text-balance"><?php echo esc_html( $prop_gallery_heading ); ?></h2>
			</div>
			<?php
			restwell_render_gallery(
				$prop_gallery_ids,
				array(
					'layout'              => 'carousel',
					'aria_label'          => __( 'Property photo carousel', 'restwell-retreats' ),
					'all_grid_aria_label' => __( 'All property photos', 'restwell-retreats' ),
					'class'               => 'prop-page__gallery-carousel',
				)
			);
			?>
			<?php if ( $prop_primary_cta['label'] !== '' && $prop_primary_cta['url'] !== '' ) : ?>
			<div class="prop-page__gallery-cta text-center">
				<a href="<?php echo esc_url( $prop_primary_cta['url'] ); ?>" class="btn btn-primary">
					<?php echo esc_html( $prop_primary_cta['label'] ); ?>
					<i class="ph-bold ph-arrow-right" aria-hidden="true"></i>
				</a>
			</div>
			<?php endif; ?>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( $prop_care_heading !== '' || $prop_care_body !== '' ) : ?>
	<section id="prop-care" class="prop-page__anchor rw-section-y <?php echo esc_attr( $prop_section_bg( $prop_band_index++ ) ); ?> scroll-mt-28" aria-labelledby="prop-care-heading">
		<div class="container max-w-5xl">
			<div class="rw-section-head rw-section-head--center">
				<?php get_template_part( 'template-parts/section-label', null, array( 'label' => __( 'Care', 'restwell-retreats' ) ) ); ?>
				<?php if ( $prop_care_heading !== '' ) : ?>
				<h2 id="prop-care-heading" class="text-3xl md:text-4xl font-serif text-[var(--deep-teal)] m-0 leading-tight text-balance"><?php echo esc_html( $prop_care_heading ); ?></h2>
				<?php endif; ?>
			</div>
			<?php if ( $prop_care_body !== '' ) : ?>
			<div class="prop-page__feature-band max-w-3xl mx-auto">
				<div class="rw-copy-body rw-prose-stack max-w-prose mx-auto leading-relaxed prop-page__copy--center">
					<?php echo wp_kses_post( wpautop( $prop_care_body ) ); ?>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( $prop_location_heading !== '' || $prop_location_body !== '' ) : ?>
		<?php
		$prop_location_section_class = 'prop-page__anchor prop-page__location rw-section-y scroll-mt-28';
		if ( $prop_location_has_photo ) {
			$prop_location_section_class .= ' prop-page__location--photo';
		} else {
			$prop_location_section_class .= ' ' . $prop_section_bg( $prop_band_index++ );
		}
		$prop_location_panel_class = 'prop-page__feature-band max-w-3xl mx-auto';
		if ( $prop_location_has_photo ) {
			$prop_location_panel_class .= ' prop-page__location-panel prop-page__location-panel--frosted';
			$prop_band_index++;
		}
		$prop_location_image_size = function_exists( 'restwell_pick_property_visual_size' )
			? restwell_pick_property_visual_size( $prop_location_image_id )
			: 'restwell-cta-bg';
		$prop_location_image_alt = $prop_location_heading !== ''
			? $prop_location_heading
			: __( 'Whitstable and the Kent coast', 'restwell-retreats' );
		?>
	<section id="prop-location" class="<?php echo esc_attr( $prop_location_section_class ); ?>" aria-labelledby="prop-location-heading">
		<?php if ( $prop_location_has_photo ) : ?>
		<div class="prop-page__location-media" aria-hidden="true">
			<?php
			echo wp_get_attachment_image(
				$prop_location_image_id,
				$prop_location_image_size,
				false,
				array(
					'class'    => 'prop-page__location-img',
					'alt'      => '',
					'loading'  => 'lazy',
					'decoding' => 'async',
					'sizes'    => function_exists( 'restwell_get_property_visual_sizes_attr' )
						? restwell_get_property_visual_sizes_attr( 'hero' )
						: '100vw',
				)
			);
			?>
		</div>
		<div class="prop-page__location-scrim" aria-hidden="true"></div>
		<?php endif; ?>
		<div class="container max-w-5xl prop-page__location-inner">
			<div class="<?php echo esc_attr( $prop_location_panel_class ); ?>">
				<div class="rw-section-head rw-section-head--center">
					<?php get_template_part( 'template-parts/section-label', null, array( 'label' => __( 'Location', 'restwell-retreats' ) ) ); ?>
					<?php if ( $prop_location_heading !== '' ) : ?>
					<h2 id="prop-location-heading" class="text-3xl md:text-4xl font-serif text-[var(--deep-teal)] m-0 leading-tight text-balance"><?php echo esc_html( $prop_location_heading ); ?></h2>
					<?php endif; ?>
				</div>
				<?php if ( $prop_location_body !== '' ) : ?>
				<div class="rw-copy-body rw-prose-stack max-w-prose mx-auto leading-relaxed prop-page__copy--center">
						<?php
						$area_guide_needle = 'area guide';
						$location_parts    = explode( $area_guide_needle, $prop_location_body, 2 );
						if ( count( $location_parts ) === 2 ) {
							$location_html = esc_html( $location_parts[0] )
								. '<a href="' . esc_url( $area_guide_url ) . '" class="rw-link-prose rw-link-prose--focus">'
								. esc_html__( 'area guide', 'restwell-retreats' )
								. '</a>'
								. esc_html( $location_parts[1] );
							echo wp_kses_post( wpautop( $location_html ) );
						} else {
							echo wp_kses_post( wpautop( $prop_location_body ) );
						}
						?>
					</div>
					<?php endif; ?>
				<p class="m-0 mt-6 text-center">
					<a href="<?php echo esc_url( $area_guide_url ); ?>" class="inline-flex min-h-[2.75rem] items-center gap-2 text-sm font-semibold text-[var(--deep-teal)] no-underline hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--deep-teal)] rounded-sm">
						<?php esc_html_e( 'Whitstable area guide', 'restwell-retreats' ); ?>
						<i class="ph-bold ph-arrow-right text-xs" aria-hidden="true"></i>
					</a>
				</p>
			</div>
		</div>
		<?php if ( $prop_location_has_photo ) : ?>
		<span class="sr-only"><?php echo esc_html( $prop_location_image_alt ); ?></span>
		<?php endif; ?>
	</section>
	<?php endif; ?>

	<?php if ( ! empty( $prop_nearby_places ) ) : ?>
	<section id="prop-nearby" class="prop-page__anchor rw-section-y <?php echo esc_attr( $prop_section_bg( $prop_band_index++ ) ); ?> scroll-mt-28" aria-labelledby="prop-nearby-heading">
		<div class="container max-w-5xl">
			<div class="rw-section-head rw-section-head--center">
				<?php if ( $prop_nearby_label !== '' ) : ?>
					<?php get_template_part( 'template-parts/section-label', null, array( 'label' => $prop_nearby_label ) ); ?>
				<?php endif; ?>
				<h2 id="prop-nearby-heading" class="text-3xl md:text-4xl font-serif text-[var(--deep-teal)] m-0 leading-tight text-balance"><?php echo esc_html( $prop_nearby_heading ); ?></h2>
				<p class="text-[var(--muted-grey)] leading-relaxed m-0 max-w-prose mx-auto prop-page__copy--center"><?php esc_html_e( 'Places and services near the property. Filter by what matters to you.', 'restwell-retreats' ); ?></p>
			</div>

			<div class="explore-whitstable-filter flex flex-wrap justify-center gap-2 mb-6 md:mb-8" role="group" aria-label="<?php esc_attr_e( 'Filter nearby places', 'restwell-retreats' ); ?>">
				<button type="button" class="explore-filter-pill rounded-full px-3 py-2 sm:px-5 sm:py-2.5 text-xs sm:text-sm font-medium transition-all duration-200 ease-out motion-reduce:transition-none bg-white text-[var(--deep-teal)] border-2 border-gray-200 hover:border-[var(--deep-teal)]/50 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[var(--deep-teal)] min-h-[2.75rem]" data-filter="all" aria-pressed="true"><?php esc_html_e( 'All', 'restwell-retreats' ); ?></button>
				<button type="button" class="explore-filter-pill rounded-full px-3 py-2 sm:px-5 sm:py-2.5 text-xs sm:text-sm font-medium transition-all duration-200 ease-out motion-reduce:transition-none bg-white text-[var(--deep-teal)] border-2 border-gray-200 hover:border-[var(--deep-teal)]/50 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[var(--deep-teal)] min-h-[2.75rem]" data-filter="wheelchair-friendly" aria-pressed="false"><?php esc_html_e( 'Wheelchair-friendly', 'restwell-retreats' ); ?></button>
				<button type="button" class="explore-filter-pill rounded-full px-3 py-2 sm:px-5 sm:py-2.5 text-xs sm:text-sm font-medium transition-all duration-200 ease-out motion-reduce:transition-none bg-white text-[var(--deep-teal)] border-2 border-gray-200 hover:border-[var(--deep-teal)]/50 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[var(--deep-teal)] min-h-[2.75rem]" data-filter="quieter" aria-pressed="false"><?php esc_html_e( 'Quieter', 'restwell-retreats' ); ?></button>
				<button type="button" class="explore-filter-pill rounded-full px-3 py-2 sm:px-5 sm:py-2.5 text-xs sm:text-sm font-medium transition-all duration-200 ease-out motion-reduce:transition-none bg-white text-[var(--deep-teal)] border-2 border-gray-200 hover:border-[var(--deep-teal)]/50 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[var(--deep-teal)] min-h-[2.75rem]" data-filter="practical" aria-pressed="false"><?php esc_html_e( 'Practical', 'restwell-retreats' ); ?></button>
			</div>
			<p id="explore-filter-status" class="explore-filter-status text-center text-[var(--muted-grey)] text-xs min-h-0 mb-6" aria-live="polite" aria-atomic="true"></p>

			<div id="explore-empty-state" class="hidden text-center py-12 px-4 max-w-md mx-auto" aria-live="polite" aria-atomic="true">
				<p class="text-[var(--muted-grey)] leading-relaxed mb-4"><?php esc_html_e( 'No places match this filter. Try another or show all.', 'restwell-retreats' ); ?></p>
				<button type="button" class="explore-filter-show-all inline-flex items-center gap-2 rounded-full px-5 py-2.5 text-sm font-medium bg-[var(--deep-teal)] text-white border-2 border-[var(--deep-teal)] min-h-[2.75rem] focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[var(--deep-teal)]" aria-label="<?php esc_attr_e( 'Show all places', 'restwell-retreats' ); ?>"><?php esc_html_e( 'Show all', 'restwell-retreats' ); ?></button>
			</div>

			<div class="grid sm:grid-cols-2 rw-gap-grid max-w-4xl mx-auto" role="list" id="explore-whitstable-list">
				<?php foreach ( $prop_nearby_places as $place ) : ?>
				<article class="explore-card" role="listitem" data-filter="<?php echo esc_attr( $place['filter'] ); ?>">
					<header class="explore-card__head">
						<?php if ( $place['type'] !== '' ) : ?>
						<p class="explore-card__category"><?php echo esc_html( $place['type'] ); ?></p>
						<?php endif; ?>
						<?php if ( $place['distance'] !== '' ) : ?>
						<p class="explore-card__distance"><?php echo esc_html( $place['distance'] ); ?></p>
						<?php endif; ?>
						<h3 class="explore-card__title">
							<?php if ( $place['map_url'] !== '' ) : ?>
							<a href="<?php echo esc_url( $place['map_url'] ); ?>" target="_blank" rel="noopener noreferrer" class="explore-card__title-link">
								<?php echo esc_html( $place['title'] ); ?>
								<i class="ph-bold ph-arrow-square-out explore-card__link-icon" aria-hidden="true"></i>
								<span class="sr-only"><?php esc_html_e( '(opens in Google Maps)', 'restwell-retreats' ); ?></span>
							</a>
							<?php else : ?>
								<?php echo esc_html( $place['title'] ); ?>
							<?php endif; ?>
						</h3>
					</header>
					<div class="explore-card__body">
						<?php echo wp_kses_post( wpautop( $place['body'] ) ); ?>
					</div>
					<?php if ( $place['acc'] !== '' ) : ?>
					<footer class="explore-card__foot">
						<p class="explore-card__acc">
							<span class="explore-card__acc-label"><?php esc_html_e( 'Access', 'restwell-retreats' ); ?></span>
							<?php echo esc_html( $place['acc'] ); ?>
						</p>
					</footer>
					<?php endif; ?>
				</article>
				<?php endforeach; ?>

				<?php if ( $prop_nearby_cta_label !== '' && $prop_nearby_cta_url !== '' ) : ?>
				<article class="explore-card explore-card--cta" role="listitem" data-filter="all">
					<i class="ph-bold ph-envelope-simple explore-card--cta-icon" aria-hidden="true"></i>
					<p class="explore-card--cta-text"><?php echo esc_html( $prop_nearby_cta_label ); ?></p>
					<a href="<?php echo esc_url( $prop_nearby_cta_url ); ?>" class="btn btn-primary btn-sm min-h-[2.75rem]"><?php esc_html_e( 'Get in touch', 'restwell-retreats' ); ?></a>
				</article>
				<?php else : ?>
				<article class="explore-card explore-card--cta" role="listitem" data-filter="all">
					<i class="ph-bold ph-wheelchair explore-card--cta-icon" aria-hidden="true"></i>
					<p class="explore-card--cta-text"><?php esc_html_e( 'Questions about access?', 'restwell-retreats' ); ?></p>
					<a href="<?php echo esc_url( $enquire_url ); ?>" class="btn btn-primary btn-sm min-h-[2.75rem]"><?php esc_html_e( 'Get in touch', 'restwell-retreats' ); ?></a>
				</article>
				<?php endif; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<section class="rw-section-y--compact <?php echo esc_attr( $prop_section_bg( $prop_band_index++ ) ); ?>" aria-label="<?php esc_attr_e( 'Accessibility detail', 'restwell-retreats' ); ?>">
		<div class="container max-w-5xl">
			<p class="rw-copy-body text-sm md:text-base mb-0 max-w-prose mx-auto text-center">
				<?php esc_html_e( 'Full measurements, equipment detail and floor plans:', 'restwell-retreats' ); ?>
				<a href="<?php echo esc_url( $access_url ); ?>" class="rw-link-prose rw-link-prose--focus"><?php esc_html_e( 'accessibility page', 'restwell-retreats' ); ?></a>.
			</p>
		</div>
	</section>

	<?php
	if ( function_exists( 'restwell_render_pillar_related_guides' ) ) {
		restwell_render_pillar_related_guides(
			'the-property',
			array(
				'heading'         => __( 'Related guides', 'restwell-retreats' ),
				'intro'           => __( 'Practical guides on choosing an accessible self-catering stay, plus sector updates that affect how people book a break.', 'restwell-retreats' ),
				'heading_id'      => 'prop-related-guides-heading',
				'show_siblings'   => true,
				'show_conversion' => true,
			)
		);
	}
	?>

	<section class="rw-section-y--cta bg-[var(--deep-teal)]" aria-labelledby="prop-cta-heading">
		<div class="container max-w-5xl text-center">
			<h2 id="prop-cta-heading" class="text-3xl md:text-4xl font-serif text-white mb-4 tracking-tight text-balance m-0"><?php echo esc_html( $prop_cta_heading ); ?></h2>
			<?php if ( $prop_cta_body !== '' ) : ?>
				<p class="text-white/85 text-lg leading-relaxed mb-8 max-w-2xl mx-auto text-pretty m-0"><?php echo esc_html( $prop_cta_body ); ?></p>
			<?php endif; ?>
			<?php if ( $prop_cta_btn !== '' && $prop_cta_url !== '' ) : ?>
				<a href="<?php echo esc_url( $prop_cta_url ); ?>" class="btn btn-gold">
					<?php echo esc_html( $prop_cta_btn ); ?>
					<i class="ph-bold ph-arrow-right" aria-hidden="true"></i>
				</a>
			<?php endif; ?>
			<?php if ( $prop_cta_promise !== '' ) : ?>
				<p class="text-white/75 text-sm mt-5 mb-0"><?php echo esc_html( $prop_cta_promise ); ?></p>
			<?php endif; ?>
		</div>
	</section>

</main>
<?php get_footer(); ?>
