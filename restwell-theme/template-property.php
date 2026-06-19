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
$prop_bungalow_image_id = (int) $m( 'prop_bungalow_image_id' );

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
$prop_glance_trust     = trim( (string) $m( 'prop_glance_trust' ) );

$prop_care_heading    = $m( 'prop_care_heading' );
$prop_care_body       = $m( 'prop_care_body' );
$prop_location_heading = $m( 'prop_location_heading' );
$prop_location_body   = $m( 'prop_location_body' );

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

$area_guide_url = esc_url( home_url( '/whitstable-area-guide/' ) );
$access_url     = esc_url( home_url( '/accessibility/' ) );
$enquire_url    = esc_url( home_url( '/enquire/' ) );
?>
<main class="flex-1" id="main-content">
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

	<section class="rw-section-y bg-[var(--bg-subtle)] rw-seam-t" aria-labelledby="prop-bungalow-heading">
		<div class="container max-w-6xl">
			<div class="grid md:grid-cols-2 gap-8 lg:gap-12 items-center">
				<div class="order-2 md:order-1">
					<div class="rw-section-head rw-section-head--left">
						<?php if ( $prop_bungalow_label !== '' ) : ?>
							<?php get_template_part( 'template-parts/section-label', null, array( 'label' => $prop_bungalow_label ) ); ?>
						<?php endif; ?>
						<h2 id="prop-bungalow-heading" class="text-3xl md:text-4xl font-serif text-[var(--deep-teal)] m-0 leading-tight"><?php echo esc_html( $prop_bungalow_heading ); ?></h2>
					</div>
					<div class="rw-copy-body rw-prose-stack max-w-prose leading-relaxed mt-6 md:mt-8">
						<?php echo wp_kses_post( wpautop( $prop_bungalow_body ) ); ?>
					</div>
				</div>
				<?php if ( $prop_bungalow_image_id > 0 ) : ?>
					<div class="order-1 md:order-2">
						<?php
						echo wp_get_attachment_image(
							$prop_bungalow_image_id,
							'large',
							false,
							array(
								'class'    => 'rounded-2xl w-full aspect-[4/3] object-cover shadow-[0_8px_30px_rgb(0,0,0,0.04)]',
								'alt'      => $prop_bungalow_heading,
								'loading'  => 'lazy',
								'decoding' => 'async',
							)
						);
						?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<?php if ( ! empty( $prop_gallery_ids ) ) : ?>
	<section class="rw-section-y bg-white rw-seam-t" id="property-gallery" aria-labelledby="property-gallery-heading">
		<div class="container">
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
					'sizes'               => '(max-width: 1023px) 100vw, min(72rem, 90vw)',
				)
			);
			?>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( ! empty( $prop_room_tour ) ) : ?>
	<section class="rw-section-y bg-[var(--bg-subtle)] rw-seam-t" aria-labelledby="prop-room-tour-heading">
		<div class="container max-w-6xl">
			<h2 id="prop-room-tour-heading" class="sr-only"><?php esc_html_e( 'Room-by-room tour', 'restwell-retreats' ); ?></h2>
			<div class="rw-stack rw-stack--loose">
				<?php
				foreach ( $prop_room_tour as $tour_index => $tour ) :
					$image_first = 0 === ( $tour_index % 2 );
					$image_id    = (int) ( $tour['image_id'] ?? 0 );
					?>
				<article class="prop-room-tour__block grid md:grid-cols-2 gap-8 lg:gap-12 items-center <?php echo $tour_index > 0 ? 'rw-seam-t pt-10 md:pt-12' : ''; ?>">
					<?php if ( $image_id > 0 ) : ?>
						<div class="<?php echo esc_attr( $image_first ? 'order-1' : 'order-1 md:order-2' ); ?>">
							<?php
							echo wp_get_attachment_image(
								$image_id,
								'large',
								false,
								array(
									'class'    => 'prop-room-tour__img rounded-2xl w-full aspect-[4/3] object-cover shadow-[0_8px_30px_rgb(0,0,0,0.04)]',
									'alt'      => (string) ( $tour['heading'] ?? '' ),
									'loading'  => 'lazy',
									'decoding' => 'async',
								)
							);
							?>
						</div>
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
			<?php if ( $prop_primary_cta['label'] !== '' && $prop_primary_cta['url'] !== '' ) : ?>
			<div class="mt-12 md:mt-16 text-center">
				<a href="<?php echo esc_url( $prop_primary_cta['url'] ); ?>" class="btn btn-primary">
					<?php echo esc_html( $prop_primary_cta['label'] ); ?>
					<i class="ph-bold ph-arrow-right" aria-hidden="true"></i>
				</a>
			</div>
			<?php endif; ?>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( ! empty( $prop_features ) ) : ?>
	<section class="rw-section-y bg-[var(--soft-sand)] rw-seam-t" aria-labelledby="prop-glance-heading">
		<div class="container">
			<div class="rw-section-head rw-section-head--center">
				<?php if ( $prop_features_label !== '' ) : ?>
					<?php get_template_part( 'template-parts/section-label', null, array( 'label' => $prop_features_label ) ); ?>
				<?php endif; ?>
				<h2 id="prop-glance-heading" class="text-3xl font-serif text-[var(--deep-teal)] m-0"><?php echo esc_html( $prop_features_heading ); ?></h2>
			</div>
			<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 rw-gap-grid max-w-5xl mx-auto items-stretch">
				<?php
				$feature_icons = array( 'bed', 'shower', 'users-three', 'car', 'wheelchair', 'path', 'dog', 'gift' );
				foreach ( $prop_features as $j => $feature ) :
					$icon = $feature_icons[ $j ] ?? 'check';
					?>
				<div class="rw-surface-card rw-card-hover-lift p-6 flex flex-col items-center text-center gap-2 h-full min-h-[9.5rem] motion-reduce:hover:translate-y-0 motion-reduce:transition-none">
					<div class="text-[var(--deep-teal)]" aria-hidden="true">
						<i class="ph-bold ph-<?php echo esc_attr( $icon ); ?> text-2xl"></i>
					</div>
					<h3 class="text-[var(--deep-teal)] font-semibold text-base leading-snug m-0"><?php echo esc_html( $feature['title'] ); ?></h3>
					<?php if ( $feature['desc'] !== '' ) : ?>
						<p class="rw-copy-body text-sm leading-relaxed m-0 flex-1"><?php echo esc_html( $feature['desc'] ); ?></p>
					<?php else : ?>
						<span class="flex-1" aria-hidden="true"></span>
					<?php endif; ?>
				</div>
				<?php endforeach; ?>
			</div>
			<?php if ( $prop_glance_trust !== '' ) : ?>
				<p class="text-center rw-copy-muted text-sm md:text-base mt-8 mb-0 max-w-prose mx-auto"><?php echo esc_html( $prop_glance_trust ); ?></p>
			<?php endif; ?>
			<p class="text-center rw-copy-body text-sm md:text-base mt-6 mb-0">
				<?php esc_html_e( 'Full measurements and equipment detail:', 'restwell-retreats' ); ?>
				<a href="<?php echo esc_url( $access_url ); ?>" class="text-[var(--deep-teal)] font-medium underline underline-offset-2 hover:no-underline focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--deep-teal)] rounded-sm"><?php esc_html_e( 'accessibility page', 'restwell-retreats' ); ?></a>.
				<?php esc_html_e( 'Questions?', 'restwell-retreats' ); ?>
				<a href="<?php echo esc_url( $enquire_url ); ?>" class="text-[var(--deep-teal)] font-medium underline underline-offset-2 hover:no-underline focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--deep-teal)] rounded-sm"><?php esc_html_e( 'Ask us directly', 'restwell-retreats' ); ?></a>.
			</p>
		</div>
	</section>
	<?php endif; ?>

	<section class="rw-section-y bg-white rw-seam-t" aria-labelledby="prop-care-heading">
		<div class="container max-w-3xl mx-auto text-center">
			<h2 id="prop-care-heading" class="text-3xl font-serif text-[var(--deep-teal)] m-0 mb-6 leading-tight"><?php echo esc_html( $prop_care_heading ); ?></h2>
			<div class="rw-copy-body max-w-prose mx-auto leading-relaxed text-left md:text-center">
				<?php echo wp_kses_post( wpautop( $prop_care_body ) ); ?>
			</div>
		</div>
	</section>

	<section class="rw-section-y bg-[var(--bg-subtle)] rw-seam-t" aria-labelledby="prop-location-heading">
		<div class="container max-w-3xl mx-auto">
			<h2 id="prop-location-heading" class="text-3xl font-serif text-[var(--deep-teal)] text-center m-0 mb-6 leading-tight"><?php echo esc_html( $prop_location_heading ); ?></h2>
			<div class="rw-copy-body max-w-prose mx-auto leading-relaxed">
				<?php echo wp_kses_post( wpautop( $prop_location_body ) ); ?>
			</div>
			<p class="text-center mt-6 mb-0">
				<a href="<?php echo esc_url( $area_guide_url ); ?>" class="text-[var(--deep-teal)] font-medium underline underline-offset-2 hover:no-underline focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--deep-teal)] rounded-sm"><?php esc_html_e( 'Whitstable area guide', 'restwell-retreats' ); ?></a>
			</p>
		</div>
	</section>

	<section class="rw-section-y--cta bg-[var(--deep-teal)] rw-seam-t" aria-labelledby="prop-cta-heading">
		<div class="container max-w-3xl mx-auto text-center">
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
