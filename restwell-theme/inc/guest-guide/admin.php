<?php
/**
 * Guest Guide CRM settings screen orchestrator.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/admin-list.php';
require_once __DIR__ . '/admin-forms.php';

/**
 * The Guest Guide page is registered as a submenu of the Restwell CRM menu
 * in the Restwell CRM mu-plugin (crm.php). No separate menu registration needed here.
 */

/**
 * Render the Guest Guide settings page.
 */
function restwell_guest_guide_settings_page() {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'You do not have permission to access this page.', 'restwell-retreats' ), '', array( 'response' => 403 ) );
	}

	$guests       = restwell_gg_get_guests();
	$raw_cc       = (string) get_option( 'restwell_guide_cc_emails', 'hello@restwellretreats.co.uk' );
	$status       = isset( $_GET['gg_status'] ) ? sanitize_key( $_GET['gg_status'] ) : '';
	$admin_post   = admin_url( 'admin-post.php' );
	$preview_ctx  = restwell_gg_preview_guest_context( $guests );
	$preview_mail = restwell_gg_build_invitation_preview( $preview_ctx['email'], $preview_ctx['name'] );
	$preview_open = isset( $_GET['preview_guest'] );

	$prefill_name       = isset( $_GET['prefill_name'] ) ? sanitize_text_field( urldecode( wp_unslash( $_GET['prefill_name'] ) ) ) : '';
	$prefill_email      = isset( $_GET['prefill_email'] ) ? sanitize_email( urldecode( wp_unslash( $_GET['prefill_email'] ) ) ) : '';
	$prefill_enquiry_id = isset( $_GET['prefill_enquiry_id'] ) ? absint( $_GET['prefill_enquiry_id'] ) : 0;

	$notices = array(
		'added'     => array( 'success', __( 'Guest added.', 'restwell-retreats' ) ),
		'deleted'   => array( 'success', __( 'Guest removed.', 'restwell-retreats' ) ),
		'sent'      => array( 'success', __( 'Invitation sent.', 'restwell-retreats' ) ),
		'cc_saved'  => array( 'success', __( 'CC addresses saved.', 'restwell-retreats' ) ),
		'invalid'   => array( 'error', __( 'Invalid email or missing scheduled date. Please try again.', 'restwell-retreats' ) ),
		'not_found' => array( 'error', __( 'Guest not found.', 'restwell-retreats' ) ),
	);
	?>
	<div class="wrap restwell-admin restwell-admin-guest-guide">
		<h1 class="rw-page-title"><?php esc_html_e( 'Guest Guide Settings', 'restwell-retreats' ); ?></h1>

		<?php if ( isset( $notices[ $status ] ) ) : ?>
			<div class="notice notice-<?php echo esc_attr( $notices[ $status ][0] ); ?> is-dismissible">
				<p><?php echo esc_html( $notices[ $status ][1] ); ?></p>
			</div>
		<?php endif; ?>

		<?php
		restwell_gg_admin_render_guest_list( $guests, $admin_post );
		restwell_gg_admin_render_email_preview( $preview_mail, $preview_ctx, $preview_open, $raw_cc );
		restwell_gg_admin_render_add_guest_form( $admin_post, $prefill_name, $prefill_email, $prefill_enquiry_id );
		restwell_gg_admin_render_cc_form( $admin_post, $raw_cc );
		?>
	</div>
	<?php
}
