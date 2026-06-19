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
$m   = function ( $key ) use ( $pid, $d ) {
	return restwell_post_meta_or_default( $pid, $key, $d );
};
$m_url = function ( $key ) use ( $pid, $d ) {
	return restwell_post_meta_url( $pid, $key, $d );
};

$prop_hero_label              = $m( 'prop_hero_label' );
$prop_hero_heading            = $m( 'prop_hero_heading' );
$prop_hero_subtitle           = $m( 'prop_hero_subtitle' );
$prop_hero_image_id           = (int) $m( 'prop_hero_image_id' );
$prop_hero_cta_text           = $m( 'prop_hero_cta_text' );
$prop_hero_cta_url            = esc_url( $m_url( 'prop_hero_cta_url' ) );
$prop_hero_cta_promise        = $m( 'prop_hero_cta_promise' );
$prop_hero_cta_secondary_text = $m( 'prop_hero_cta_secondary_text' );
$prop_hero_cta_secondary_url  = esc_url( $m_url( 'prop_hero_cta_secondary_url' ) );

$prop_bungalow_label    = $m( 'prop_bungalow_label' );
$prop_bungalow_heading  = $m( 'prop_bungalow_heading' );
$prop_bungalow_body     = $m( 'prop_bungalow_body' );

$prop_features = array();
for ( $fi = 1; $fi <= 8; $fi++ ) {
	$title = trim( (string) $m( "prop_feature_{$fi}" ) );
	if ( $title === '' ) {
		continue;
	}
	$prop_features[] = array(
		'title' => $title,
		'desc'  => trim( (string) $m( "prop_feature_{$fi}_desc" ) ),
	);
}

$prop_features_label   = $m( 'prop_features_label' );
$prop_features_heading = $m( 'prop_features_heading' );

$prop_gallery_label   = $m( 'prop_gallery_label' );
$prop_gallery_heading = $m( 'prop_gallery_heading' );
$prop_gallery_ids     = restwell_get_property_gallery_ids( $pid );

$prop_cta_heading = $m( 'prop_cta_heading' );
$prop_cta_body    = $m( 'prop_cta_body' );
$prop_cta_btn     = $m( 'prop_cta_btn' );
$prop_cta_url     = esc_url( $m_url( 'prop_cta_url' ) );
$prop_cta_promise = $m( 'prop_cta_promise' );

$prop_tldr_markup = function_exists( 'restwell_get_tldr_markup' ) ? restwell_get_tldr_markup( $pid, '' ) : '';

$prop_primary_cta = array(
	'label' => $prop_hero_cta_text,
	'url'   => $prop_hero_cta_url,
);

$prop_room_tour = function_exists( 'restwell_get_property_room_tour_sections' )
	? restwell_get_property_room_tour_sections( $pid )
	: array();

$prop_care_heading     = $m( 'prop_care_heading' );
$prop_care_body        = $m( 'prop_care_body' );
$prop_location_heading = $m( 'prop_location_heading' );
$prop_location_body    = $m( 'prop_location_body' );
$area_guide_url        = esc_url( home_url( '/whitstable-area-guide/' ) );

$access_url = esc_url( home_url( '/accessibility/' ) );
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
			'cta_secondary'        => $prop_hero_cta_secondary_text !== '' ? array(
				'label' => $prop_hero_cta_secondary_text,
				'url'   => $prop_hero_cta_secondary_url,
			) : array(),
			'cta_promise'          => $prop_hero_cta_promise,
		)
	);
	get_template_part( 'template-parts/interior-hero' );
	?>

	<section class="rw-section-y bg-[var(--bg-subtle)] rw-seam-t" aria-labelledby="prop-intro-heading">
		<div class="container max-w-5xl mx-auto">
			<div class="max-w-3xl mx-auto">
				<div class="rw-section-head rw-section-head--center">
					<?php if ( $prop_bungalow_label !== '' ) : ?>
						<?php get_template_part( 'template-parts/section-label', null, array( 'label' => $prop_bungalow_label ) ); ?>
					<?php endif; ?>
					<h2 id="prop-intro-heading" class="text-3xl md:text-4xl font-serif text-[var(--deep-teal)] m-0 leading-tight"><?php echo esc_html( $prop_bungalow_heading ); ?></h2>
				</div>
				<div class="rw-copy-body rw-prose-stack max-w-prose mx-auto leading-relaxed">
					<?php echo wp_kses_post( wpautop( $prop_bungalow_body ) ); ?>
				</div>
			</div>

			<?php if ( ! empty( $prop_features ) ) : ?>
			<div class="max-w-3xl mx-auto prop-page__inset-seam rw-seam-t" aria-labelledby="prop-glance-heading">
				<div class="rw-section-head rw-section-head--center">
					<?php if ( $prop_features_label !== '' ) : ?>
						<?php get_template_part( 'template-parts/section-label', null, array( 'label' => $prop_features_label ) ); ?>
					<?php endif; ?>
					<h3 id="prop-glance-heading" class="text-2xl md:text-3xl font-serif text-[var(--deep-teal)] m-0 leading-tight"><?php echo esc_html( $prop_features_heading ); ?></h3>
				</div>
				<ul class="prop-glance-list grid sm:grid-cols-2 gap-x-10 gap-y-4 list-disc pl-5 rw-copy-body leading-relaxed m-0">
					<?php foreach ( $prop_features as $feature ) : ?>
					<li>
						<strong class="font-semibold text-[var(--deep-teal)]"><?php echo esc_html( $feature['title'] ); ?></strong><?php
						if ( $feature['desc'] !== '' ) {
							echo ' <span class="text-[var(--muted-grey)]">' . esc_html( $feature['desc'] ) . '</span>';
						}
						?>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php endif; ?>
		</div>
	</section>

	<?php if ( ! empty( $prop_gallery_ids ) ) : ?>
	<section class="rw-section-y bg-white rw-seam-t" id="property-gallery" aria-labelledby="property-gallery-heading">
		<div class="container max-w-5xl mx-auto">
			<div class="rw-section-head rw-section-head--center max-w-3xl mx-auto text-center">
				<?php if ( $prop_gallery_label !== '' ) : ?>
					<?php get_template_part( 'template-parts/section-label', null, array( 'label' => $prop_gallery_label ) ); ?>
				<?php endif; ?>
				<h2 id="property-gallery-heading" class="text-3xl font-serif text-[var(--deep-teal)] m-0"><?php echo esc_html( $prop_gallery_heading ); ?></h2>
			</div>
			<?php
			restwell_render_gallery(
				$prop_gallery_ids,
				array(
					'layout'              => 'carousel',
					'aria_label'          => __( 'Property photo carousel', 'restwell-retreats' ),
					'all_grid_aria_label' => __( 'All property photos', 'restwell-retreats' ),
					'sizes'               => '(max-width: 1023px) 100vw, min(64rem, 90vw)',
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

	<?php if ( ! empty( $prop_room_tour ) ) : ?>
	<section class="rw-section-y bg-[var(--bg-subtle)] rw-seam-t" aria-labelledby="prop-room-tour-heading">
		<div class="container max-w-5xl mx-auto">
			<h2 id="prop-room-tour-heading" class="sr-only"><?php esc_html_e( 'Room-by-room tour', 'restwell-retreats' ); ?></h2>
			<div class="prop-room-tour__stack">
				<?php
				foreach ( $prop_room_tour as $tour_index => $tour ) :
					$image_first    = 0 === ( $tour_index % 2 );
					$image_id       = (int) ( $tour['image_id'] ?? 0 );
					$image_confirm  = (string) ( $tour['image_confirm'] ?? 'room photo' );
					$image_meta     = $image_id > 0 ? wp_get_attachment_metadata( $image_id ) : array();
					$image_width    = is_array( $image_meta ) && ! empty( $image_meta['width'] ) ? (int) $image_meta['width'] : 1200;
					$image_height   = is_array( $image_meta ) && ! empty( $image_meta['height'] ) ? (int) $image_meta['height'] : 900;
					$block_classes  = 'prop-room-tour__block grid md:grid-cols-2 gap-8 lg:gap-12 items-start';
					if ( $tour_index > 0 ) {
						$block_classes .= ' prop-room-tour__block--seamed rw-seam-t';
					}
					?>
				<article class="<?php echo esc_attr( $block_classes ); ?>">
					<?php if ( $image_id > 0 ) : ?>
						<div class="<?php echo esc_attr( $image_first ? 'order-1' : 'order-1 md:order-2' ); ?>">
							<div class="prop-room-tour__figure">
								<?php
								echo wp_get_attachment_image(
									$image_id,
									'large',
									false,
									array(
										'class'    => 'prop-room-tour__img',
										'alt'      => (string) ( $tour['heading'] ?? '' ),
										'loading'  => 'lazy',
										'decoding' => 'async',
										'width'    => $image_width,
										'height'   => $image_height,
									)
								);
								?>
							</div>
						</div>
					<?php else : ?>
						<!-- Confirm in WP: needs a <?php echo esc_html( $image_confirm ); ?>. -->
					<?php endif; ?>
					<div class="<?php echo esc_attr( $image_id > 0 ? ( $image_first ? 'order-2' : 'order-2 md:order-1' ) : 'md:col-span-2' ); ?>">
						<h3 class="text-2xl md:text-3xl font-serif text-[var(--deep-teal)] m-0 mb-4 leading-tight"><?php echo esc_html( (string) ( $tour['heading'] ?? '' ) ); ?></h3>
						<div class="rw-copy-body max-w-prose leading-relaxed">
							<?php echo wp_kses_post( wpautop( (string) ( $tour['body'] ?? '' ) ) ); ?>
						</div>
					</div>
				</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( $prop_care_heading !== '' || $prop_care_body !== '' ) : ?>
	<section class="rw-section-y bg-white rw-seam-t" aria-labelledby="prop-care-heading">
		<div class="container max-w-5xl mx-auto">
			<div class="max-w-3xl mx-auto">
				<?php if ( $prop_care_heading !== '' ) : ?>
					<div class="rw-section-head rw-section-head--center">
						<h2 id="prop-care-heading" class="text-3xl md:text-4xl font-serif text-[var(--deep-teal)] m-0 leading-tight"><?php echo esc_html( $prop_care_heading ); ?></h2>
					</div>
				<?php endif; ?>
				<?php if ( $prop_care_body !== '' ) : ?>
					<div class="rw-copy-body rw-prose-stack max-w-prose mx-auto leading-relaxed">
						<?php echo wp_kses_post( wpautop( $prop_care_body ) ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( $prop_location_heading !== '' || $prop_location_body !== '' ) : ?>
	<section class="rw-section-y bg-[var(--bg-subtle)] rw-seam-t" aria-labelledby="prop-location-heading">
		<div class="container max-w-5xl mx-auto">
			<div class="max-w-3xl mx-auto">
				<?php if ( $prop_location_heading !== '' ) : ?>
					<div class="rw-section-head rw-section-head--center">
						<h2 id="prop-location-heading" class="text-3xl md:text-4xl font-serif text-[var(--deep-teal)] m-0 leading-tight"><?php echo esc_html( $prop_location_heading ); ?></h2>
					</div>
				<?php endif; ?>
				<?php if ( $prop_location_body !== '' ) : ?>
					<div class="rw-copy-body rw-prose-stack max-w-prose mx-auto leading-relaxed">
						<?php
						$area_guide_needle = 'area guide';
						$location_parts    = explode( $area_guide_needle, $prop_location_body, 2 );
						if ( count( $location_parts ) === 2 ) {
							$location_html = esc_html( $location_parts[0] )
								. '<a href="' . esc_url( $area_guide_url ) . '" class="text-[var(--deep-teal)] font-medium underline underline-offset-2 hover:no-underline focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--deep-teal)] rounded-sm">'
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
			</div>
		</div>
	</section>
	<?php endif; ?>

	<section class="rw-section-y bg-white rw-seam-t" aria-label="<?php esc_attr_e( 'Accessibility detail', 'restwell-retreats' ); ?>">
		<div class="container max-w-5xl mx-auto">
			<p class="rw-copy-body text-sm md:text-base mb-0 max-w-prose mx-auto text-center">
				<?php esc_html_e( 'Full measurements, equipment detail and floor plans:', 'restwell-retreats' ); ?>
				<a href="<?php echo esc_url( $access_url ); ?>" class="text-[var(--deep-teal)] font-medium underline underline-offset-2 hover:no-underline focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--deep-teal)] rounded-sm"><?php esc_html_e( 'accessibility page', 'restwell-retreats' ); ?></a>.
			</p>
		</div>
	</section>

	<section class="rw-section-y--cta bg-[var(--deep-teal)] rw-seam-t" aria-labelledby="prop-cta-heading">
		<div class="container max-w-5xl mx-auto text-center">
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
