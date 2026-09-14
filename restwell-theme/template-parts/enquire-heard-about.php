<?php
/**
 * Optional “How did you hear about us?” fields for enquiry forms.
 *
 * @package Restwell_Retreats
 *
 * @param array $args {
 *     @type string $id_prefix Unique prefix for element ids (e.g. enq, availability).
 *     @type string $selected  Current slug.
 *     @type string $other     Extra words when slug is other.
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args      = isset( $args ) && is_array( $args ) ? $args : array();
$id_prefix = isset( $args['id_prefix'] ) ? sanitize_html_class( (string) $args['id_prefix'] ) : 'enq';
if ( '' === $id_prefix ) {
	$id_prefix = 'enq';
}
$selected = isset( $args['selected'] ) ? (string) $args['selected'] : '';
$other    = isset( $args['other'] ) ? (string) $args['other'] : '';
$choices  = function_exists( 'restwell_enquiry_heard_about_choices' )
	? restwell_enquiry_heard_about_choices()
	: array();
$select_id = $id_prefix . '-heard-about';
$other_id  = $id_prefix . '-heard-other';
?>
<div class="field">
	<label for="<?php echo esc_attr( $select_id ); ?>"><?php esc_html_e( 'How did you hear about us? (optional)', 'restwell-retreats' ); ?></label>
	<select id="<?php echo esc_attr( $select_id ); ?>" name="enq_heard_about" data-heard-select aria-controls="<?php echo esc_attr( $other_id ); ?>">
		<option value="" <?php selected( $selected, '' ); ?>><?php esc_html_e( 'Please choose', 'restwell-retreats' ); ?></option>
		<?php foreach ( $choices as $slug => $label ) : ?>
		<option value="<?php echo esc_attr( $slug ); ?>" <?php selected( $selected, $slug ); ?>><?php echo esc_html( $label ); ?></option>
		<?php endforeach; ?>
	</select>
</div>
<div class="field" data-heard-other-wrap>
	<label for="<?php echo esc_attr( $other_id ); ?>"><?php esc_html_e( 'If somewhere else, a few words (optional)', 'restwell-retreats' ); ?></label>
	<input id="<?php echo esc_attr( $other_id ); ?>" name="enq_heard_other" type="text" maxlength="160" autocomplete="off" value="<?php echo esc_attr( $other ); ?>" />
</div>
