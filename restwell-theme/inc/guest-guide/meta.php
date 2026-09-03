<?php
/**
 * Guest Guide page-template metabox (separate from Page content).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the content meta box only when editing a page that uses the
 * Guest Arrival Guide template.
 *
 * @param WP_Post $post Page currently being edited.
 */
function restwell_guest_guide_register_meta_box( $post ) {
	if ( 'page-guest-guide.php' !== get_page_template_slug( $post ) ) {
		return;
	}

	add_meta_box(
		'restwell_guest_guide_fields',
		__( 'Guest Arrival Guide Content', 'restwell-retreats' ),
		'restwell_guest_guide_meta_box_callback',
		'page',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes_page', 'restwell_guest_guide_register_meta_box' );

/**
 * Return the canonical field definitions for the Guest Guide meta box.
 *
 * @return array<string, array<string, array<string, string>>>
 */
function restwell_guest_guide_field_definitions() {
	return array(
		__( 'Welcome', 'restwell-retreats' ) => array(
			'gg_welcome_message' => array(
				'label' => __( 'Welcome message', 'restwell-retreats' ),
				'type'  => 'textarea',
			),
		),
		__( 'Arrival', 'restwell-retreats' ) => array(
			'gg_address'       => array(
				'label' => __( 'Property address', 'restwell-retreats' ),
				'type'  => 'text',
			),
			'gg_checkin_time'  => array(
				'label' => __( 'Check-in time (e.g. from 15:00)', 'restwell-retreats' ),
				'type'  => 'text',
			),
			'gg_checkout_time' => array(
				'label' => __( 'Check-out time (e.g. by 11:00)', 'restwell-retreats' ),
				'type'  => 'text',
			),
		),
		__( 'Access', 'restwell-retreats' ) => array(
			'gg_keysafe_code'      => array(
				'label' => __( 'Key safe code', 'restwell-retreats' ),
				'type'  => 'text',
			),
			'gg_door_instructions' => array(
				'label' => __( 'Door / entry instructions', 'restwell-retreats' ),
				'type'  => 'textarea',
			),
		),
		__( 'Connectivity', 'restwell-retreats' ) => array(
			'gg_wifi_name'     => array(
				'label' => __( 'WiFi network name (SSID)', 'restwell-retreats' ),
				'type'  => 'text',
			),
			'gg_wifi_password' => array(
				'label' => __( 'WiFi password', 'restwell-retreats' ),
				'type'  => 'text',
			),
		),
		__( 'Getting around', 'restwell-retreats' ) => array(
			'gg_parking_info' => array(
				'label' => __( 'Parking information', 'restwell-retreats' ),
				'type'  => 'textarea',
			),
		),
		__( 'House rules', 'restwell-retreats' ) => array(
			'gg_house_rules' => array(
				'label' => __( 'House rules', 'restwell-retreats' ),
				'type'  => 'textarea',
			),
		),
		__( 'Departure', 'restwell-retreats' ) => array(
			'gg_departure_notes' => array(
				'label' => __( 'Departure / before-you-leave checklist', 'restwell-retreats' ),
				'type'  => 'textarea',
			),
		),
		__( 'Local area', 'restwell-retreats' ) => array(
			'gg_local_info' => array(
				'label' => __( 'Local area information', 'restwell-retreats' ),
				'type'  => 'textarea',
			),
		),
		__( 'Emergency information', 'restwell-retreats' ) => array(
			'gg_emergency_services'  => array(
				'label' => __( 'Emergency services', 'restwell-retreats' ),
				'type' => 'text',
			),
			'gg_nhs_number'          => array(
				'label' => __( 'NHS (non-emergency)', 'restwell-retreats' ),
				'type' => 'text',
			),
			'gg_police_number'       => array(
				'label' => __( 'Police (non-emergency)', 'restwell-retreats' ),
				'type' => 'text',
			),
			'gg_nearest_ae'          => array(
				'label' => __( 'Nearest A&E', 'restwell-retreats' ),
				'type' => 'text',
			),
			'gg_nearest_ae_map_url'  => array(
				'label' => __( 'Nearest A&E: Google Maps URL', 'restwell-retreats' ),
				'type' => 'text',
			),
			'gg_maintenance_contact' => array(
				'label' => __( 'Property maintenance', 'restwell-retreats' ),
				'type' => 'text',
			),
			'gg_maintenance_oos'     => array(
				'label' => __( 'Out-of-hours maintenance', 'restwell-retreats' ),
				'type' => 'text',
			),
			'gg_gas_oos'             => array(
				'label' => __( 'Gas emergency', 'restwell-retreats' ),
				'type' => 'text',
			),
		),
		__( 'Contact', 'restwell-retreats' ) => array(
			'gg_host_contact' => array(
				'label' => __( 'Host contact details (name and phone number)', 'restwell-retreats' ),
				'type'  => 'text',
			),
		),
	);
}

/**
 * Render the Guest Guide meta box HTML.
 *
 * @param WP_Post $post Current post object.
 */
function restwell_guest_guide_meta_box_callback( $post ) {
	wp_nonce_field( RESTWELL_GG_NONCE_ACTION, RESTWELL_GG_NONCE_NAME );

	$sections = restwell_guest_guide_field_definitions();

	echo '<table class="form-table" role="presentation">';

	foreach ( $sections as $section_label => $fields ) {
		echo '<tr><td colspan="2"><h3 class="rw-gg-section-title">'
			. esc_html( $section_label )
			. '</h3></td></tr>';

		foreach ( $fields as $key => $field ) {
			$value = (string) get_post_meta( $post->ID, $key, true );
			$el_id = 'restwell_' . $key;

			echo '<tr>';
			echo '<th scope="row" class="rw-gg-meta-th">';
			echo '<label for="' . esc_attr( $el_id ) . '">' . esc_html( $field['label'] ) . '</label>';
			echo '</th>';
			echo '<td>';

			if ( 'textarea' === $field['type'] ) {
				echo '<textarea id="' . esc_attr( $el_id ) . '" name="' . esc_attr( $key ) . '" rows="4" class="rw-gg-meta-textarea large-text">'
					. esc_textarea( $value )
					. '</textarea>';
			} else {
				echo '<input type="text" id="' . esc_attr( $el_id ) . '" name="' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '" class="rw-gg-meta-input large-text" />';
			}

			echo '</td>';
			echo '</tr>';
		}
	}

	echo '</table>';
}

/**
 * Save Guest Guide post meta when a page is saved.
 *
 * @param int $post_id Post ID.
 */
function restwell_guest_guide_save_meta( $post_id ) {
	if ( ! isset( $_POST[ RESTWELL_GG_NONCE_NAME ] ) ) {
		return;
	}
	if ( ! wp_verify_nonce(
		sanitize_text_field( wp_unslash( $_POST[ RESTWELL_GG_NONCE_NAME ] ) ),
		RESTWELL_GG_NONCE_ACTION
	) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$sections = restwell_guest_guide_field_definitions();

	foreach ( $sections as $fields ) {
		foreach ( $fields as $key => $field ) {
			if ( ! isset( $_POST[ $key ] ) ) {
				continue;
			}

			$raw = wp_unslash( $_POST[ $key ] );

			if ( 'textarea' === $field['type'] ) {
				update_post_meta( $post_id, $key, sanitize_textarea_field( $raw ) );
			} else {
				update_post_meta( $post_id, $key, sanitize_text_field( $raw ) );
			}
		}
	}
}
add_action( 'save_post_page', 'restwell_guest_guide_save_meta' );
