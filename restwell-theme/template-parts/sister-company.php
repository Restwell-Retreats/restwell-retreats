<?php
/**
 * Sister company band: Restwell + Continuity, one conversation.
 *
 * Shared by Optional care and Our Story. A light, site-standard section
 * (5 Oct 2026): intro, Victoria and badges beside one ledger card of points.
 * Takes the page's colours, so it is purple on the Continuity-themed care page.
 *
 * @package Restwell_Retreats
 *
 * @param array $args {
 *     @type string $id          Section id.
 *     @type string $label       Eyebrow.
 *     @type string $heading     H2.
 *     @type string $lede        Intro paragraph.
 *     @type array  $items       Points: title, body, optional html (appended, trusted).
 *     @type string $note        Small print under the points.
 *     @type array  $link        label, url, external (bool).
 *     @type bool   $show_person Show Victoria's portrait and role line.
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sc = wp_parse_args(
	$args ?? array(),
	array(
		'id'          => 'sister-company',
		'label'       => '',
		'heading'     => '',
		'lede'        => '',
		'items'       => array(),
		'note'        => '',
		'link'        => array(),
		'show_person' => false,
	)
);
$sc_heading_id = $sc['id'] . '-h';
$sc_cqc_url    = 'https://www.cqc.org.uk/location/1-2624556588';
?>
<section class="section-y band-white sister-band" id="<?php echo esc_attr( $sc['id'] ); ?>" aria-labelledby="<?php echo esc_attr( $sc_heading_id ); ?>">
	<div class="container sister-band__grid">
		<div class="sister-band__intro">
			<?php if ( '' !== $sc['label'] ) : ?>
			<p class="eyebrow"><?php echo esc_html( $sc['label'] ); ?></p>
			<?php endif; ?>
			<h2 id="<?php echo esc_attr( $sc_heading_id ); ?>"><?php echo esc_html( $sc['heading'] ); ?></h2>
			<?php if ( '' !== $sc['lede'] ) : ?>
			<p class="sister-band__lede"><?php echo esc_html( $sc['lede'] ); ?></p>
			<?php endif; ?>

			<?php if ( $sc['show_person'] ) : ?>
			<div class="sister-band__person">
				<img src="<?php echo esc_url( restwell_theme_image_url( 'journey/victoria-walker-portrait.webp' ) ); ?>" alt="" width="160" height="160" loading="lazy" decoding="async" />
				<p>
					<strong><?php esc_html_e( 'Victoria Walker', 'restwell-retreats' ); ?></strong>
					<span><?php esc_html_e( 'Owns Restwell, and is Continuity’s CQC registered manager', 'restwell-retreats' ); ?></span>
				</p>
			</div>
			<?php endif; ?>

			<div class="sister-band__badges" aria-label="<?php esc_attr_e( 'Sister company and CQC rating', 'restwell-retreats' ); ?>">
				<a class="sister-band__badge" href="https://www.continuitycareservices.co.uk/" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Continuity of Care Services (opens in a new tab)', 'restwell-retreats' ); ?>">
					<img src="<?php echo esc_url( restwell_theme_image_url( 'partners/continuity-of-care-services-long.png' ) ); ?>" alt="" sizes="180px" width="405" height="69" loading="lazy" decoding="async" />
				</a>
				<a class="sister-band__badge sister-band__badge--cqc" href="<?php echo esc_url( $sc_cqc_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'CQC rating Good, Continuity of Care Services (opens in a new tab)', 'restwell-retreats' ); ?>">
					<img src="<?php echo esc_url( restwell_theme_image_url( 'partners/cqc-rating-good.jpg' ) ); ?>" alt="" sizes="80px" width="710" height="399" loading="lazy" decoding="async" />
				</a>
			</div>
		</div>

		<div class="sister-band__points">
			<?php if ( ! empty( $sc['items'] ) ) : ?>
			<dl class="comparison-list sister-band__list">
				<?php foreach ( $sc['items'] as $sc_item ) : ?>
					<?php
					if ( '' === trim( (string) ( $sc_item['title'] ?? '' ) ) ) {
						continue;
					}
					?>
				<div class="comparison-list__item">
					<dt><?php echo esc_html( $sc_item['title'] ); ?></dt>
					<?php if ( '' !== trim( (string) ( $sc_item['body'] ?? '' ) ) ) : ?>
					<dd><?php echo esc_html( $sc_item['body'] ); ?><?php echo isset( $sc_item['html'] ) ? ' ' . wp_kses_post( $sc_item['html'] ) : ''; ?></dd>
					<?php endif; ?>
				</div>
				<?php endforeach; ?>
			</dl>
			<?php endif; ?>
			<?php if ( '' !== $sc['note'] || ! empty( $sc['link']['label'] ) ) : ?>
			<div class="sister-band__foot">
				<?php if ( '' !== $sc['note'] ) : ?>
				<p><?php echo esc_html( $sc['note'] ); ?></p>
				<?php endif; ?>
				<?php if ( ! empty( $sc['link']['label'] ) && ! empty( $sc['link']['url'] ) ) : ?>
				<a class="text-link" href="<?php echo esc_url( $sc['link']['url'] ); ?>"<?php echo ! empty( $sc['link']['external'] ) ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>><?php echo esc_html( $sc['link']['label'] ); ?><?php echo ! empty( $sc['link']['external'] ) ? '<span class="sr-only"> ' . esc_html__( '(opens in new tab)', 'restwell-retreats' ) . '</span>' : ''; ?></a>
				<?php endif; ?>
			</div>
			<?php endif; ?>
		</div>
	</div>
</section>
