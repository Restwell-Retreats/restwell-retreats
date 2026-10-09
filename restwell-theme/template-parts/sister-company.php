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
 *     Each item may also carry 'link' (label, url): a text link pinned to the foot of its card.
 *     @type string $band        band-white (default) or band-subtle, so the band can alternate with its neighbours.
 *     @type bool   $strip_last  Print the last item as a full-width action strip under the cards, with its 'html' on the right.
 *     @type int    $badges_in   Index of the item card that holds the Continuity and CQC badges. -1 (default) puts them beside the intro.
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
		'band'        => 'band-white',
		'strip_last'  => false,
		'badges_in'   => -1,
	)
);
$sc_heading_id = $sc['id'] . '-h';
$sc_cqc_url    = 'https://www.cqc.org.uk/location/1-2624556588';

$sc_items = array_values(
	array_filter(
		(array) $sc['items'],
		static function ( $item ) {
			return '' !== trim( (string) ( $item['title'] ?? '' ) );
		}
	)
);
$sc_strip = null;
if ( $sc['strip_last'] && count( $sc_items ) > 1 ) {
	$sc_strip = array_pop( $sc_items );
}
$sc_cols   = max( 1, min( 3, count( $sc_items ) ) );
$sc_badges = static function () use ( $sc_cqc_url ) {
	?>
	<div class="sister-band__badges" aria-label="<?php esc_attr_e( 'Sister company and CQC rating', 'restwell-retreats' ); ?>">
		<a class="sister-band__badge" href="https://www.continuitycareservices.co.uk/" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Continuity of Care Services (opens in a new tab)', 'restwell-retreats' ); ?>">
			<img src="<?php echo esc_url( restwell_theme_image_url( 'partners/continuity-of-care-services-long.png' ) ); ?>" alt="" sizes="180px" width="405" height="69" loading="lazy" decoding="async" />
		</a>
		<a class="sister-band__badge sister-band__badge--cqc" href="<?php echo esc_url( $sc_cqc_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'CQC rating Good, Continuity of Care Services (opens in a new tab)', 'restwell-retreats' ); ?>">
			<img src="<?php echo esc_url( restwell_theme_image_url( 'partners/cqc-rating-good.jpg' ) ); ?>" alt="" sizes="80px" width="710" height="399" loading="lazy" decoding="async" />
		</a>
	</div>
	<?php
};
?>
<section class="section-y <?php echo esc_attr( $sc['band'] ); ?> sister-band" id="<?php echo esc_attr( $sc['id'] ); ?>" aria-labelledby="<?php echo esc_attr( $sc_heading_id ); ?>">
	<div class="container">
		<header class="sister-band__head">
			<div class="sister-band__intro">
				<?php if ( '' !== $sc['label'] ) : ?>
				<p class="eyebrow"><?php echo esc_html( $sc['label'] ); ?></p>
				<?php endif; ?>
				<h2 id="<?php echo esc_attr( $sc_heading_id ); ?>"><?php echo esc_html( $sc['heading'] ); ?></h2>
				<?php if ( '' !== $sc['lede'] ) : ?>
				<p class="sister-band__lede"><?php echo esc_html( $sc['lede'] ); ?></p>
				<?php endif; ?>
			</div>
			<?php if ( $sc['show_person'] || $sc['badges_in'] < 0 ) : ?>
			<div class="sister-band__aside">
				<?php if ( $sc['show_person'] ) : ?>
				<div class="sister-band__person">
					<img src="<?php echo esc_url( restwell_theme_image_url( 'journey/victoria-walker-portrait.webp' ) ); ?>" alt="" width="160" height="160" loading="lazy" decoding="async" />
					<p>
						<strong><?php esc_html_e( 'Victoria Walker', 'restwell-retreats' ); ?></strong>
						<span><?php esc_html_e( 'Owns Restwell, and is Continuity’s CQC registered manager', 'restwell-retreats' ); ?></span>
					</p>
				</div>
				<?php endif; ?>
				<?php
				if ( $sc['badges_in'] < 0 ) {
					$sc_badges();
				}
				?>
			</div>
			<?php endif; ?>
		</header>

		<?php if ( ! empty( $sc_items ) ) : ?>
		<ul class="sister-band__cards" role="list" style="--sister-cols: <?php echo (int) $sc_cols; ?>">
			<?php foreach ( $sc_items as $sc_i => $sc_item ) : ?>
			<li class="sister-band__card">
				<h3><?php echo esc_html( $sc_item['title'] ); ?></h3>
				<?php if ( '' !== trim( (string) ( $sc_item['body'] ?? '' ) ) ) : ?>
				<p><?php echo esc_html( $sc_item['body'] ); ?></p>
				<?php endif; ?>
				<?php if ( ! empty( $sc_item['html'] ) ) : ?>
				<p class="sister-band__card-action"><?php echo wp_kses_post( $sc_item['html'] ); ?></p>
				<?php endif; ?>
				<?php
				if ( $sc_i === (int) $sc['badges_in'] ) {
					$sc_badges();
				}
				?>
				<?php if ( ! empty( $sc_item['link']['label'] ) && ! empty( $sc_item['link']['url'] ) ) : ?>
				<a class="text-link sister-band__card-link" href="<?php echo esc_url( $sc_item['link']['url'] ); ?>"><?php echo esc_html( $sc_item['link']['label'] ); ?></a>
				<?php endif; ?>
			</li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>

		<?php if ( $sc_strip ) : ?>
		<div class="sister-band__strip">
			<div class="sister-band__strip-text">
				<h3><?php echo esc_html( $sc_strip['title'] ); ?></h3>
				<?php if ( '' !== trim( (string) ( $sc_strip['body'] ?? '' ) ) ) : ?>
				<p><?php echo esc_html( $sc_strip['body'] ); ?></p>
				<?php endif; ?>
			</div>
			<?php if ( ! empty( $sc_strip['html'] ) ) : ?>
			<div class="sister-band__strip-action"><?php echo wp_kses_post( $sc_strip['html'] ); ?></div>
			<?php endif; ?>
		</div>
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
</section>
