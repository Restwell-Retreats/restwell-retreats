<?php
/**
 * Concept FAQ list (accordion). Optional category filters.
 *
 * @package Restwell_Retreats
 *
 * @param array $args {
 *     @type array $items   List of array( 'id' => '', 'question' => '', 'answer_html' => '', 'cat' => '' ).
 *     @type array $filters Optional list of array( 'slug' => '', 'label' => '' ); empty = no pills.
 *     @type bool  $split   Two-column list.
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = isset( $args ) && is_array( $args ) ? $args : array();
$args = wp_parse_args(
	$args,
	array(
		'items'   => array(),
		'filters' => array(),
		'split'   => true,
	)
);

$items   = is_array( $args['items'] ) ? $args['items'] : array();
$filters = is_array( $args['filters'] ) ? $args['filters'] : array();
if ( empty( $items ) ) {
	return;
}

$list_class = 'faq-list faq-list--measure';
if ( ! empty( $args['split'] ) ) {
	$list_class .= ' faq-list--split';
}
?>
<?php if ( ! empty( $filters ) ) : ?>
	<ul class="pill-tabs" data-faq-filters role="tablist" aria-label="<?php esc_attr_e( 'FAQ categories', 'restwell-retreats' ); ?>">
		<li><button type="button" data-filter="all" class="is-active" aria-selected="true"><?php esc_html_e( 'All', 'restwell-retreats' ); ?></button></li>
		<?php foreach ( $filters as $filter ) : ?>
			<li>
				<button type="button" data-filter="<?php echo esc_attr( (string) $filter['slug'] ); ?>" aria-selected="false">
					<?php echo esc_html( (string) $filter['label'] ); ?>
				</button>
			</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>

<div class="<?php echo esc_attr( $list_class ); ?>" data-faq-accordion>
	<?php
	$mid = (int) ceil( count( $items ) / 2 );
	$cols = ! empty( $args['split'] ) ? array( array_slice( $items, 0, $mid ), array_slice( $items, $mid ) ) : array( $items );
	foreach ( $cols as $col_items ) :
		?>
		<div class="faq-list__col">
			<?php
			foreach ( $col_items as $i => $item ) :
				$qid   = ! empty( $item['id'] ) ? (string) $item['id'] : 'faq-q' . ( $i + 1 );
				$cat   = isset( $item['cat'] ) ? (string) $item['cat'] : '';
				$q     = isset( $item['question'] ) ? (string) $item['question'] : '';
				$a     = isset( $item['answer_html'] ) ? (string) $item['answer_html'] : '';
				$open  = ! empty( $item['open'] );
				if ( $q === '' ) {
					continue;
				}
				?>
				<div class="faq-item<?php echo $open ? ' is-open' : ''; ?>"<?php echo $cat !== '' ? ' data-cat="' . esc_attr( $cat ) . '"' : ''; ?>>
					<h3 class="faq-item__heading">
						<button type="button" class="faq-item__trigger" aria-expanded="<?php echo $open ? 'true' : 'false'; ?>" id="<?php echo esc_attr( $qid ); ?>" aria-controls="<?php echo esc_attr( $qid ); ?>-a">
							<span><?php echo esc_html( $q ); ?></span>
							<span class="faq-item__icon" aria-hidden="true"></span>
						</button>
					</h3>
					<div class="faq-item__panel" id="<?php echo esc_attr( $qid ); ?>-a" role="region" aria-labelledby="<?php echo esc_attr( $qid ); ?>"<?php echo $open ? '' : ' hidden'; ?>>
						<?php echo wp_kses_post( $a ); ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endforeach; ?>
</div>
