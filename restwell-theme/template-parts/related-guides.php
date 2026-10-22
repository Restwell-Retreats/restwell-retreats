<?php
/**
 * Related guides module (pillar → cluster posts, sibling pillars, conversion).
 *
 * Expects query var `restwell_related_guides`.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$data = get_query_var( 'restwell_related_guides', array() );
if ( ! is_array( $data ) ) {
	return;
}

$heading        = isset( $data['heading'] ) ? (string) $data['heading'] : __( 'Related guides', 'restwell-retreats' );
$intro          = isset( $data['intro'] ) ? (string) $data['intro'] : '';
$heading_id     = isset( $data['heading_id'] ) ? (string) $data['heading_id'] : 'restwell-related-guides-heading';
$guide_posts          = isset( $data['posts'] ) && is_array( $data['posts'] ) ? $data['posts'] : array();
$siblings       = isset( $data['siblings'] ) && is_array( $data['siblings'] ) ? $data['siblings'] : array();
$conversion     = isset( $data['conversion'] ) && is_array( $data['conversion'] ) ? $data['conversion'] : array();
$category_url   = isset( $data['category_url'] ) ? (string) $data['category_url'] : '';
$category_name  = isset( $data['category_name'] ) ? (string) $data['category_name'] : '';
// The caller picks the band so the section alternates with its neighbours.
$band = ( isset( $data['band'] ) && in_array( $data['band'], array( 'band-white', 'band-subtle' ), true ) ) ? $data['band'] : 'band-white';

if ( empty( $guide_posts ) && empty( $siblings ) && empty( $conversion ) ) {
	return;
}
?>
<section class="section-y <?php echo esc_attr( $band ); ?>" aria-labelledby="<?php echo esc_attr( $heading_id ); ?>">
	<div class="container">
		<header class="section-head section-head--tight">
			<p class="eyebrow"><?php esc_html_e( 'Further reading', 'restwell-retreats' ); ?></p>
			<h2 id="<?php echo esc_attr( $heading_id ); ?>"><?php echo esc_html( $heading ); ?></h2>
			<?php if ( $intro !== '' ) : ?>
				<p class="lede"><?php echo esc_html( $intro ); ?></p>
			<?php endif; ?>
		</header>

		<?php
		// The first guide as Home's photo card, the rest listed beside it with a
		// thumbnail each (22 Oct 2026). It was a two-column list of links.
		$guide_items = array();
		foreach ( $guide_posts as $guide_post ) {
			if ( ! $guide_post instanceof WP_Post ) {
				continue;
			}
			$guide_url   = get_permalink( $guide_post );
			$guide_title = get_the_title( $guide_post );
			if ( ! $guide_url || '' === $guide_title ) {
				continue;
			}
			$guide_thumb   = function_exists( 'restwell_get_post_card_thumb' ) ? restwell_get_post_card_thumb( $guide_post->ID, 'large' ) : array( '', '' );
			$guide_items[] = array( $guide_url, $guide_title, (string) $guide_thumb[0] );
		}
		$guide_lead = array_shift( $guide_items );
		?>
		<?php if ( $guide_lead ) : ?>
		<div class="guide-feature">
			<a class="care-choice care-choice--own guide-feature__lead" href="<?php echo esc_url( $guide_lead[0] ); ?>">
				<?php if ( '' !== $guide_lead[2] ) : ?>
				<img class="care-choice__photo" src="<?php echo esc_url( $guide_lead[2] ); ?>" alt="" loading="lazy" decoding="async" />
				<?php endif; ?>
				<span class="care-choice__text">
					<span class="guide-feature__title"><?php echo esc_html( $guide_lead[1] ); ?></span>
					<span class="care-choice__link"><?php esc_html_e( 'Read the guide', 'restwell-retreats' ); ?> <span aria-hidden="true">&rarr;</span></span>
				</span>
			</a>
			<?php if ( $guide_items ) : ?>
			<ul class="guide-feature__list" role="list">
				<?php foreach ( $guide_items as $guide_item ) : ?>
				<li>
					<a href="<?php echo esc_url( $guide_item[0] ); ?>">
						<?php if ( '' !== $guide_item[2] ) : ?>
						<img src="<?php echo esc_url( $guide_item[2] ); ?>" alt="" width="88" height="88" loading="lazy" decoding="async" />
						<?php endif; ?>
						<span><?php echo esc_html( $guide_item[1] ); ?></span>
					</a>
				</li>
				<?php endforeach; ?>
			</ul>
			<?php endif; ?>
		</div>
		<?php endif; ?>

		<?php if ( $category_url !== '' && $category_name !== '' ) : ?>
			<p class="section-follow">
				<a class="text-link" href="<?php echo esc_url( $category_url ); ?>">
					<?php
					echo esc_html(
						sprintf(
							/* translators: %s: category name */
							__( 'Browse all articles in %s', 'restwell-retreats' ),
							$category_name
						)
					);
					?>
				</a>
			</p>
		<?php endif; ?>

		<?php if ( ! empty( $siblings ) ) : ?>
			<div class="section-follow">
				<h3><?php esc_html_e( 'Also on Restwell', 'restwell-retreats' ); ?></h3>
				<ul class="link-list link-list--cards">
					<?php foreach ( $siblings as $sib ) : ?>
						<?php
						if ( empty( $sib['url'] ) || empty( $sib['label'] ) ) {
							continue;
						}
						?>
						<li>
							<a href="<?php echo esc_url( $sib['url'] ); ?>"><?php echo esc_html( $sib['label'] ); ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $conversion ) ) : ?>
			<div class="section-follow">
				<h3><?php esc_html_e( 'Plan your stay', 'restwell-retreats' ); ?></h3>
				<ul class="link-list link-list--cards">
					<?php foreach ( $conversion as $item ) : ?>
						<?php
						if ( empty( $item['url'] ) || empty( $item['label'] ) ) {
							continue;
						}
						?>
						<li>
							<a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>
	</div>
</section>
