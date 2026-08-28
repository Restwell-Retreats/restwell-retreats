<?php
/**
 * Shared FAQ accordion renderer.
 *
 * Expects $args:
 *   id_prefix    string                Prefix for trigger/panel IDs (must be unique per page).
 *   columns      array<int, array>     Array of column arrays; each item: q, a (raw HTML), open, cat.
 *   list_class   string                Optional extra class on .faq-list.
 *   wrap_columns bool                  True renders a .faq-list__col wrapper per column.
 *
 * Answers arrive as ready-to-print HTML and are printed with wp_kses_post().
 * Question text is escaped here; callers pass plain text.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$faq_accordion_args = wp_parse_args(
	$args ?? array(),
	array(
		'id_prefix'    => 'faq-item',
		'columns'      => array(),
		'list_class'   => '',
		'wrap_columns' => false,
	)
);
?>
<div class="faq-list <?php echo esc_attr( ltrim( $faq_accordion_args['list_class'] ) ); ?>" data-faq-accordion>
	<?php foreach ( $faq_accordion_args['columns'] as $faq_accordion_index => $faq_accolumn_items ) : ?>
		<?php if ( empty( $faq_accolumn_items ) ) : ?>
			<?php continue; ?>
		<?php endif; ?>
		<?php if ( $faq_accordion_args['wrap_columns'] ) : ?>
			<div class="faq-list__col">
		<?php endif; ?>
		<?php foreach ( $faq_accolumn_items as $faq_accordion_pos => $faq_accordion_item ) : ?>
			<?php
			$faq_q = (string) ( $faq_accordion_item['q'] ?? '' );
			if ( '' === $faq_q ) {
				continue;
			}
			$faq_id     = sprintf( '%s%d', $faq_accordion_args['id_prefix'], (int) $faq_accordion_pos + 1 );
			$faq_open   = ! empty( $faq_accordion_item['open'] );
			$faq_cat    = (string) ( $faq_accordion_item['cat'] ?? '' );
			$faq_answer = (string) ( $faq_accordion_item['a'] ?? '' );
			?>
			<div class="faq-item<?php echo $faq_open ? ' is-open' : ''; ?>"<?php echo '' !== $faq_cat ? ' data-cat="' . esc_attr( $faq_cat ) . '"' : ''; ?>>
				<h3 class="faq-item__heading"><button type="button" class="faq-item__trigger" aria-expanded="<?php echo $faq_open ? 'true' : 'false'; ?>" id="<?php echo esc_attr( $faq_id ); ?>" aria-controls="<?php echo esc_attr( $faq_id ); ?>-a">
					<span><?php echo esc_html( $faq_q ); ?></span>
					<span class="faq-item__icon" aria-hidden="true"></span>
				</button></h3>
				<div class="faq-item__panel" id="<?php echo esc_attr( $faq_id ); ?>-a" role="region" aria-labelledby="<?php echo esc_attr( $faq_id ); ?>"<?php echo $faq_open ? '' : ' hidden'; ?>>
					<?php echo wp_kses_post( $faq_answer ); ?>
				</div>
			</div>
		<?php endforeach; ?>
		<?php if ( $faq_accordion_args['wrap_columns'] ) : ?>
			</div>
		<?php endif; ?>
	<?php endforeach; ?>
</div>
