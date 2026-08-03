<?php
/**
 * Homepage trust strip: Continuity intro + partner & CQC links.
 *
 * Flat section on all breakpoints — no nested grey band + link footer card.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$a = (array) get_query_var( 'args', array() );

$section_class   = isset( $a['section_class'] ) ? (string) $a['section_class'] : '';
$container_class = isset( $a['container_class'] ) ? (string) $a['container_class'] : 'max-w-5xl mx-auto';
$trust_label     = isset( $a['trust_label'] ) ? (string) $a['trust_label'] : '';
$trust_heading   = isset( $a['trust_heading'] ) ? (string) $a['trust_heading'] : '';
$trust_badge_id  = isset( $a['trust_badge_image_id'] ) ? absint( $a['trust_badge_image_id'] ) : 0;
$show_partner    = ! empty( $a['show_trust_partner'] );
$show_cqc        = ! empty( $a['show_trust_cqc_card'] );
$line_primary    = isset( $a['trust_line_primary'] ) ? (string) $a['trust_line_primary'] : '';
$trust_line_full = isset( $a['trust_line'] ) ? (string) $a['trust_line'] : '';
$line_secondary  = isset( $a['trust_line_secondary'] ) ? (string) $a['trust_line_secondary'] : '';
$partner_url     = isset( $a['trust_partner_url'] ) ? (string) $a['trust_partner_url'] : '';
$cqc_url         = isset( $a['trust_cqc_profile_url'] ) ? (string) $a['trust_cqc_profile_url'] : '';

$trust_intro = apply_filters(
	'restwell_trust_strip_intro',
	__(
		"You book the whole bungalow as a self-catering stay. Your space, your pace. Professional care is not bundled into the booking unless you choose it.\n\nIf you want regulated support while you are here, we introduce Continuity of Care Services: Kent-based and registered with the CQC. You agree what that looks like directly with them, from a short daily check-in to more hands-on help.",
		'restwell-retreats'
	)
);

$has_trust_links  = ( $show_partner && $partner_url !== '' ) || ( $show_cqc && $cqc_url !== '' );
$show_trust_panel = ( is_string( $trust_intro ) && $trust_intro !== '' ) || $has_trust_links;

/*
 * Visible eyebrow + heading. Post meta often leaves these empty; defaults keep the section scannable.
 * Override per page via trust_label / trust_heading meta, or filters below.
 */
if ( $show_trust_panel ) {
	if ( $trust_heading === '' ) {
		$trust_heading = apply_filters(
			'restwell_trust_strip_heading_default',
			__( 'Care on your terms', 'restwell-retreats' )
		);
		if ( ! is_string( $trust_heading ) || $trust_heading === '' ) {
			$trust_heading = __( 'Care on your terms', 'restwell-retreats' );
		}
	}
	if ( $trust_label === '' ) {
		$trust_label = apply_filters(
			'restwell_trust_strip_label_default',
			__( 'Care if you need it', 'restwell-retreats' )
		);
		if ( ! is_string( $trust_label ) || $trust_label === '' ) {
			$trust_label = __( 'Care if you need it', 'restwell-retreats' );
		}
	}
}

$trust_strip_heading_id = 'trust-strip-heading';
?>
<section
	class="trust-strip <?php echo esc_attr( trim( $section_class ) ); ?>"
	<?php if ( $trust_heading !== '' ) : ?>
	aria-labelledby="<?php echo esc_attr( $trust_strip_heading_id ); ?>"
	<?php else : ?>
	aria-label="<?php echo esc_attr__( 'Care partner and CQC verification', 'restwell-retreats' ); ?>"
	<?php endif; ?>
>
	<div class="container <?php echo esc_attr( $container_class ); ?>">
		<?php if ( $trust_label !== '' || $trust_heading !== '' || $trust_badge_id ) : ?>
		<header class="trust-strip__head rw-section-head rw-section-head--center rw-section-head--tight rw-section-head--trust-strip">
			<?php if ( $trust_badge_id ) : ?>
				<div class="flex justify-center">
					<?php
					echo wp_get_attachment_image(
						$trust_badge_id,
						'medium',
						false,
						array(
							'class'    => 'h-14 w-auto object-contain md:h-16',
							'alt'      => __( 'CQC regulated care provider accreditation', 'restwell-retreats' ),
							'loading'  => 'lazy',
							'decoding' => 'async',
							'sizes'    => '200px',
						)
					);
					?>
				</div>
			<?php endif; ?>
			<?php if ( $trust_label !== '' ) : ?>
				<p class="section-label"><?php echo esc_html( $trust_label ); ?></p>
			<?php endif; ?>
			<?php if ( $trust_heading !== '' ) : ?>
				<h2 id="<?php echo esc_attr( $trust_strip_heading_id ); ?>" class="text-3xl md:text-4xl section-heading m-0 text-balance text-[var(--deep-teal)]"><?php echo esc_html( $trust_heading ); ?></h2>
			<?php endif; ?>
		</header>
		<?php endif; ?>

		<?php if ( $show_trust_panel ) : ?>
		<div class="trust-strip__body">
			<?php if ( is_string( $trust_intro ) && $trust_intro !== '' ) : ?>
			<div class="trust-strip__intro">
				<?php echo wp_kses_post( wpautop( $trust_intro ) ); ?>
			</div>
			<?php endif; ?>

			<?php if ( $has_trust_links ) : ?>
			<div class="trust-strip__links">
				<?php if ( $show_partner && $partner_url !== '' ) : ?>
					<a
						class="trust-strip__link"
						href="<?php echo esc_url( $partner_url ); ?>"
						target="_blank"
						rel="noopener noreferrer"
					>
						<span class="trust-strip__link-meta">
							<span class="trust-strip__link-label"><?php esc_html_e( 'Provider site', 'restwell-retreats' ); ?></span>
							<i class="ph-bold ph-arrow-square-out trust-strip__link-icon" aria-hidden="true"></i>
						</span>
						<span class="trust-strip__link-copy">
							<?php if ( $line_primary !== '' ) : ?>
								<span class="trust-strip__link-title"><?php echo esc_html( $line_primary ); ?></span>
							<?php else : ?>
								<span class="trust-strip__link-title"><?php echo esc_html( $trust_line_full ); ?></span>
							<?php endif; ?>
							<?php if ( $line_secondary !== '' ) : ?>
								<span class="trust-strip__link-badge"><?php echo esc_html( $line_secondary ); ?></span>
							<?php endif; ?>
						</span>
						<span class="sr-only"><?php esc_html_e( 'Opens the care provider website in a new tab', 'restwell-retreats' ); ?></span>
					</a>
				<?php endif; ?>

				<?php if ( $show_cqc && $cqc_url !== '' ) : ?>
					<a
						class="trust-strip__link"
						href="<?php echo esc_url( $cqc_url ); ?>"
						target="_blank"
						rel="noopener noreferrer"
					>
						<span class="trust-strip__link-meta">
							<span class="trust-strip__link-label"><?php esc_html_e( 'CQC inspection', 'restwell-retreats' ); ?></span>
							<i class="ph-bold ph-arrow-square-out trust-strip__link-icon" aria-hidden="true"></i>
						</span>
						<span class="trust-strip__link-copy">
							<span class="trust-strip__link-title"><?php esc_html_e( 'Continuity on the official CQC register', 'restwell-retreats' ); ?></span>
							<span class="trust-strip__link-desc"><?php esc_html_e( 'Independent inspection reports and latest rating', 'restwell-retreats' ); ?></span>
						</span>
						<span class="sr-only"><?php esc_html_e( 'Opens the Care Quality Commission website in a new tab', 'restwell-retreats' ); ?></span>
					</a>
				<?php endif; ?>
			</div>
			<?php endif; ?>
		</div>
		<?php endif; ?>
	</div>
</section>
