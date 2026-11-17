<?php
/**
 * Hidden "where did this enquiry come from" fields for both enquiry forms.
 *
 * assets/js/enquiry-source.js fills these (matched by data-enq-src). They are
 * hidden inputs only, so the form looks and behaves exactly as before. The
 * server treats every value as untrusted (inc/crm/enquiry-source.php).
 *
 * @package Restwell_Retreats
 *
 * @param array $args {
 *     @type array $fields Validation flash values, so a failed first try keeps its source.
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'restwell_enquiry_source_post_fields' ) ) {
	return;
}

$args       = isset( $args ) && is_array( $args ) ? $args : array();
$src_flash  = isset( $args['fields'] ) && is_array( $args['fields'] ) ? $args['fields'] : array();
$src_fields = array( 'v' => 'enq_src_v' ) + restwell_enquiry_source_post_fields();

foreach ( $src_fields as $src_key => $src_name ) {
	$src_value = isset( $src_flash[ $src_name ] ) && is_scalar( $src_flash[ $src_name ] ) ? (string) $src_flash[ $src_name ] : '';
	?>
	<input type="hidden" name="<?php echo esc_attr( $src_name ); ?>" value="<?php echo esc_attr( $src_value ); ?>" data-enq-src="<?php echo esc_attr( $src_key ); ?>" />
	<?php
}
