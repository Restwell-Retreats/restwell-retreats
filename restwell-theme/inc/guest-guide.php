<?php
/**
 * Guest Guide: email-gated arrival information for confirmed guests.
 *
 * Responsibilities:
 *  - Start a PHP session on `init` (before any output).
 *  - Manage a structured guest list with scheduled invitation emails.
 *  - Send invitation emails (scheduled via WP-Cron or manual) with configurable CC.
 *  - Provide helpers: approved-email check, OTP send/verify, email masker.
 *  - Register and save a meta box for the Guest Arrival Guide page template.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Welcome Guide–style shell (logo, gold rule, no teal banner stack).
 *
 * @param string $content Inner HTML.
 * @param string $preview Preheader text.
 * @return string Full HTML email document.
 */
function restwell_theme_email_wrap_welcome( string $content, string $preview = '' ): string {
	$font_base = get_template_directory_uri();
	$site      = wp_strip_all_tags( (string) get_bloginfo( 'name' ) );
	$home      = esc_url( home_url( '/' ) );
	$year      = gmdate( 'Y' );
	$phone     = esc_html( (string) get_option( 'restwell_phone_number', '01622 809881' ) );
	$logo_url  = esc_url( trailingslashit( $font_base ) . 'assets/images/long_logo.png' );
	$pre_header = $preview
		? '<div style="display:none;max-height:0;overflow:hidden;mso-hide:all;font-size:1px;color:#F5EDE0;line-height:1px;">' . esc_html( $preview ) . '&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;</div>'
		: '';

	return '<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="x-apple-disable-message-reformatting">
<title>' . esc_html( $site ) . '</title>
</head>
<body style="margin:0;padding:0;background-color:#F5EDE0;font-family:Georgia,\'Times New Roman\',serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;">
' . $pre_header . '

<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color:#F5EDE0;">
<tr><td style="padding:28px 12px;">

  <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" align="center" style="max-width:600px;width:100%;background-color:#FFFFFF;border:1px solid #E8DFD0;border-radius:2px;overflow:hidden;">

    <tr>
      <td style="padding:0;background-color:#D4A853;height:3px;font-size:0;line-height:0;">&nbsp;</td>
    </tr>

    <tr>
      <td style="padding:40px 40px 28px 40px;text-align:center;background-color:#FFFFFF;">
        <p style="margin:0 0 14px 0;font-family:Georgia,\'Times New Roman\',serif;font-size:15px;font-weight:normal;letter-spacing:0.04em;color:#3A5A63;line-height:1.3;">' . esc_html__( 'Welcome to', 'restwell-retreats' ) . '</p>
        <a href="' . $home . '" style="text-decoration:none;">
          <img src="' . $logo_url . '" alt="' . esc_attr( $site ) . '" width="220" style="display:inline-block;max-width:220px;width:100%;height:auto;border:0;outline:none;text-decoration:none;" />
        </a>
        <!--[if !mso]><!-- -->
        <div style="display:none;max-height:0;overflow:hidden;mso-hide:all;" aria-hidden="true">
          <p style="margin:0;font-family:Georgia,\'Times New Roman\',serif;font-size:26px;color:#1B4D5C;">' . esc_html( $site ) . '</p>
        </div>
        <!--<![endif]-->
        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="80" align="center" style="margin:22px auto 0 auto;">
          <tr><td height="2" style="background-color:#D4A853;font-size:0;line-height:0;">&nbsp;</td></tr>
        </table>
        <p style="margin:18px 0 0 0;font-family:Georgia,\'Times New Roman\',serif;font-size:16px;font-style:italic;color:#1B4D5C;line-height:1.4;">Rest Easy, Stay Well.</p>
      </td>
    </tr>

    <tr>
      <td style="padding:8px 40px 40px 40px;background-color:#FFFFFF;">
' . $content . '
      </td>
    </tr>

    <tr>
      <td bgcolor="#F5EDE0" style="background-color:#F5EDE0;padding:24px 40px;text-align:center;border-top:1px solid #E8DFD0;">
        <p style="margin:0 0 6px 0;font-family:Georgia,\'Times New Roman\',serif;font-size:14px;color:#1B4D5C;font-weight:normal;">' . esc_html( $site ) . '</p>
        <p style="margin:0 0 10px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#3A5A63;line-height:1.6;">
          hello@restwellretreats.co.uk &nbsp;&bull;&nbsp; ' . $phone . '
        </p>
        <p style="margin:0;font-family:Arial,Helvetica,sans-serif;font-size:11px;color:#9E9589;line-height:1.6;">
          &copy; ' . $year . ' ' . esc_html( $site ) . '. All rights reserved.
        </p>
      </td>
    </tr>

  </table>

</td></tr>
</table>

</body>
</html>';
}

/**
 * Calm single-panel “how to open” steps (not a zebra table).
 *
 * @param string $email Guest email shown in step 2.
 * @return string HTML.
 */
function restwell_theme_email_invite_steps( string $email ): string {
	return '<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin:8px 0 8px 0;">
  <tr>
    <td style="background-color:#F5EDE0;border-radius:3px;padding:20px 22px;">
      <p style="margin:0 0 14px 0;font-family:Arial,Helvetica,sans-serif;font-size:11px;letter-spacing:0.14em;text-transform:uppercase;color:#9E9589;">'
		. esc_html__( 'How to open your guide', 'restwell-retreats' )
		. '</p>
      <p style="margin:0 0 12px 0;font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#2d4a52;line-height:1.55;">
        <span style="color:#D4A853;font-weight:700;">1.</span>&nbsp; '
		. esc_html__( 'Open the link below (or the button).', 'restwell-retreats' )
		. '</p>
      <p style="margin:0 0 12px 0;font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#2d4a52;line-height:1.55;">
        <span style="color:#D4A853;font-weight:700;">2.</span>&nbsp; '
		. esc_html__( 'Enter your email:', 'restwell-retreats' )
		. ' <strong style="color:#1B4D5C;">' . esc_html( $email ) . '</strong></p>
      <p style="margin:0;font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#2d4a52;line-height:1.55;">
        <span style="color:#D4A853;font-weight:700;">3.</span>&nbsp; '
		. esc_html__( 'We will send a one-time code to that address. Enter it to unlock your guide.', 'restwell-retreats' )
		. '</p>
    </td>
  </tr>
</table>';
}

/**
 * Build the Welcome Guide–branded invitation email payload.
 *
 * @param string   $email     Guest email.
 * @param string   $name      Guest name.
 * @param string   $guide_url Guide URL.
 * @param string[] $cc_list   CC addresses.
 * @return array{ subject: string, body: string, headers: string[] }
 */
function restwell_theme_email_guest_guide_invite( string $email, string $name, string $guide_url, array $cc_list = array() ): array {
	$site       = wp_strip_all_tags( (string) get_bloginfo( 'name' ) );
	$first_name = $name ? explode( ' ', trim( $name ) )[0] : '';
	$greeting   = $first_name
		? sprintf(
			/* translators: %s: guest first name */
			__( 'Dear %s,', 'restwell-retreats' ),
			$first_name
		)
		: __( 'Dear guest,', 'restwell-retreats' );

	$subject = sprintf(
		/* translators: %s - site name */
		__( 'Your arrival guide is ready - %s', 'restwell-retreats' ),
		$site
	);
	$preview = __( 'Everything you need for your upcoming stay is now available online.', 'restwell-retreats' );

	$cta = function_exists( 'restwell_email_button' )
		? restwell_email_button( $guide_url, __( 'Open your arrival guide', 'restwell-retreats' ) )
		: '<p style="text-align:center;margin:28px 0 0;"><a href="' . esc_url( $guide_url ) . '" style="display:inline-block;padding:14px 32px;background:#1B4D5C;color:#fff;text-decoration:none;font-family:Arial,Helvetica,sans-serif;font-size:14px;font-weight:600;">' . esc_html__( 'Open your arrival guide', 'restwell-retreats' ) . '</a></p>
<p style="text-align:center;margin:12px 0 0 0;font-family:Arial,Helvetica,sans-serif;font-size:11px;color:#9E9589;">' . esc_html__( 'Or copy this link:', 'restwell-retreats' ) . ' <a href="' . esc_url( $guide_url ) . '" style="color:#1B4D5C;word-break:break-all;">' . esc_url( $guide_url ) . '</a></p>';

	$content = '<p style="margin:0 0 20px 0;font-family:Georgia,\'Times New Roman\',serif;font-size:17px;color:#1B4D5C;line-height:1.7;">'
		. esc_html( $greeting )
		. '</p>'
		. '<p style="margin:0 0 24px 0;font-family:Arial,Helvetica,sans-serif;font-size:15px;color:#2d4a52;line-height:1.7;">'
		. esc_html(
			sprintf(
				/* translators: %s: site name */
				__( 'Your arrival guide for %s is ready. It covers check-in, the property layout, local tips, and who to call: everything you need before you arrive.', 'restwell-retreats' ),
				$site
			)
		)
		. '</p>'
		. restwell_theme_email_invite_steps( $email )
		. $cta
		. '<p style="margin:28px 0 0 0;font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#3A5A63;line-height:1.7;border-top:1px solid #E8DFD0;padding-top:20px;">'
		. esc_html__( 'Questions before your stay? Call us or reply to this email. We are happy to help.', 'restwell-retreats' )
		. '<br>'
		. esc_html__( 'Call', 'restwell-retreats' )
		. ' <strong style="color:#1B4D5C;">'
		. esc_html( (string) get_option( 'restwell_phone_number', '01622 809881' ) )
		. '</strong>'
		. '</p>'
		. '<p style="margin:28px 0 0 0;font-family:Georgia,\'Times New Roman\',serif;font-size:16px;color:#1B4D5C;line-height:1.7;">'
		. esc_html__( 'Warm regards,', 'restwell-retreats' )
		. '<br><strong>' . esc_html__( 'The Restwell team', 'restwell-retreats' ) . '</strong></p>';

	$headers = array( 'Content-Type: text/html; charset=UTF-8' );
	if ( ! empty( $cc_list ) ) {
		$headers[] = 'Cc: ' . implode( ', ', $cc_list );
	}

	return array(
		'subject' => $subject,
		'body'    => restwell_theme_email_wrap_welcome( $content, $preview ),
		'headers' => $headers,
	);
}


// =============================================================================
// Session
// =============================================================================

/**
 * Start a PHP session only when the Guest Arrival Guide template is active.
 *
 * Using `template_redirect` (fires after query resolution, before template
 * output) allows us to check the page template slug before starting the
 * session, avoiding unnecessary sessions on every page of the site.
 * Priority 1 keeps it ahead of any other template_redirect callbacks.
 */
function restwell_guest_guide_start_session() {
	if ( is_admin() || PHP_SESSION_NONE !== session_status() ) {
		return;
	}
	$page = get_queried_object();
	if (
		$page instanceof WP_Post &&
		'page-guest-guide.php' === get_page_template_slug( $page->ID )
	) {
		$path   = ( defined( 'COOKIEPATH' ) && COOKIEPATH ) ? COOKIEPATH : '/';
		$domain = ( defined( 'COOKIE_DOMAIN' ) && COOKIE_DOMAIN ) ? COOKIE_DOMAIN : '';
		session_set_cookie_params(
			array(
				'lifetime' => 0,
				'path'     => $path,
				'domain'   => $domain,
				'secure'   => is_ssl(),
				'httponly' => true,
				'samesite' => 'Lax',
			)
		);
		session_start();
	}
}
add_action( 'template_redirect', 'restwell_guest_guide_start_session', 1 );

// =============================================================================
// Guest data helpers
// =============================================================================

/**
 * Return the full guest list from the database, ordered by creation date.
 *
 * Each entry is an associative array:
 *  - id         int     Row ID.
 *  - enquiry_id int     Linked enquiry ID, or 0 if none.
 *  - name       string  Guest display name.
 *  - email      string  Guest email address.
 *  - send_date  string  Scheduled send datetime (MySQL format), or empty.
 *  - sent_at    string  Datetime when invitation was sent (MySQL format), or empty.
 *  - created_at string  Row creation datetime.
 *
 * @return array<int, array<string, mixed>>
 */
function restwell_gg_get_guests(): array {
	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_GUESTS_TABLE;
	$rows = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM %i ORDER BY created_at ASC', $table ), ARRAY_A );
	return is_array( $rows ) ? $rows : array();
}

/**
 * Add a guest to the database.
 *
 * @param string $name        Guest display name.
 * @param string $email       Guest email address.
 * @param string $send_date   Scheduled send in 'Y-m-d H:i' or 'Y-m-d H:i:s' format (site local).
 * @param int    $enquiry_id  Linked enquiry ID (0 if none).
 */
function restwell_gg_add_guest( string $name, string $email, string $send_date, int $enquiry_id = 0 ): void {
	global $wpdb;
	// Normalise datetime-local format to MySQL datetime.
	$send_date_mysql = $send_date ? wp_date( 'Y-m-d H:i:s', strtotime( str_replace( 'T', ' ', $send_date ) ) ) : null;

	$wpdb->insert(
		$wpdb->prefix . RESTWELL_GUESTS_TABLE,
		array(
			'enquiry_id' => $enquiry_id > 0 ? $enquiry_id : null,
			'name'       => $name,
			'email'      => $email,
			'send_date'  => $send_date_mysql,
			'created_at' => current_time( 'mysql' ),
		),
		array( '%d', '%s', '%s', '%s', '%s' )
	);
}

/**
 * Remove a guest by integer ID.
 *
 * @param int $id Guest row ID.
 */
function restwell_gg_delete_guest( int $id ): void {
	global $wpdb;
	$wpdb->delete(
		$wpdb->prefix . RESTWELL_GUESTS_TABLE,
		array( 'id' => $id ),
		array( '%d' )
	);
}

/**
 * Mark a guest's invitation as sent (sets sent_at to now).
 *
 * @param int $id Guest row ID.
 */
function restwell_gg_mark_sent( int $id ): void {
	global $wpdb;
	$wpdb->update(
		$wpdb->prefix . RESTWELL_GUESTS_TABLE,
		array( 'sent_at' => current_time( 'mysql' ) ),
		array( 'id'      => $id ),
		array( '%s' ),
		array( '%d' )
	);
}

/**
 * Return a guest row object by email address, or null if not found.
 *
 * @param string $email Guest email address.
 * @return object|null
 */
function restwell_get_guest_by_email( string $email ): ?object {
	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_GUESTS_TABLE;
	return $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM %i WHERE email = %s ORDER BY id DESC LIMIT 1', $table, $email ) );
}

/**
 * Record that a guest has read the arrival guide and notify the admin.
 *
 * Sets `confirmed_at` on the guest row (first time only) and sends a brief
 * admin notification email.
 *
 * @param string $email Verified guest email address.
 */
function restwell_guest_guide_confirm_read( string $email ): void {
	global $wpdb;
	$table  = $wpdb->prefix . RESTWELL_GUESTS_TABLE;
	$guest  = restwell_get_guest_by_email( $email );

	if ( ! $guest ) {
		return;
	}

	// Only set confirmed_at once (idempotent).
	if ( empty( $guest->confirmed_at ) ) {
		$wpdb->update(
			$table,
			array( 'confirmed_at' => current_time( 'mysql' ) ),
			array( 'id' => (int) $guest->id ),
			array( '%s' ),
			array( '%d' )
		);
	}

	// Notify the admin.
	$notify = (string) get_option( 'restwell_enquiry_notify_email', 'hello@restwellretreats.co.uk' );
	$site   = wp_strip_all_tags( (string) get_bloginfo( 'name' ) );
	wp_mail(
		$notify,
		/* translators: %s: guest display name */
		sprintf( __( '[%s] Guest confirmed reading the arrival guide', 'restwell-retreats' ), $site ),
		sprintf(
			/* translators: 1: guest name, 2: guest email */
			__( '%1$s (%2$s) confirmed they have read the guest arrival guide.', 'restwell-retreats' ),
			esc_html( $guest->name ),
			esc_html( $email )
		),
		array( 'Content-Type: text/plain; charset=UTF-8' )
	);
}

/**
 * Return a guest row as an associative array by integer ID, or null if not found.
 *
 * @param int $id Guest row ID.
 * @return array<string, mixed>|null
 */
function restwell_gg_find_guest( int $id ): ?array {
	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_GUESTS_TABLE;
	$row = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM %i WHERE id = %d', $table, $id ), ARRAY_A );
	return is_array( $row ) ? $row : null;
}

// =============================================================================
// Invitation email
// =============================================================================

/**
 * Return the published URL of the page using the Guest Arrival Guide template.
 * Falls back to /guest-guide/ if no such page is found.
 *
 * @return string
 */
function restwell_gg_get_guide_url() {
	$pages = get_pages(
		array(
			'meta_key'    => '_wp_page_template',
			'meta_value'  => 'page-guest-guide.php',
			'number'      => 1,
			'post_status' => 'publish',
		)
	);
	return ! empty( $pages ) ? get_permalink( $pages[0]->ID ) : home_url( '/guest-guide/' );
}

/**
 * Send the "your arrival guide is ready" invitation email to a single guest.
 *
 * CC addresses are taken from the `restwell_guide_cc_emails` option (one per line).
 *
 * @param string $email Guest email address.
 * @param string $name  Guest display name (optional).
 * @return bool Whether wp_mail reported success.
 */
function restwell_gg_send_invitation( $email, $name = '' ) {
	$guide_url = restwell_gg_get_guide_url();

	// Build CC list from option.
	$raw_cc  = (string) get_option( 'restwell_guide_cc_emails', 'hello@restwellretreats.co.uk' );
	$cc_list = array_filter( array_map( 'trim', explode( "\n", $raw_cc ) ) );

	$mail = function_exists( 'restwell_theme_email_guest_guide_invite' )
		? restwell_theme_email_guest_guide_invite( $email, $name, $guide_url, $cc_list )
		: restwell_email_guest_guide_invite( $email, $name, $guide_url, $cc_list );

	return wp_mail( $email, $mail['subject'], $mail['body'], $mail['headers'] );
}

/**
 * Build the invitation email payload for admin preview (does not send).
 *
 * @param string $email Guest email.
 * @param string $name  Guest name.
 * @return array{ subject: string, body: string, headers: string[] }|null
 */
function restwell_gg_build_invitation_preview( string $email, string $name = '' ): ?array {
	if ( ! function_exists( 'restwell_theme_email_guest_guide_invite' ) && ! function_exists( 'restwell_email_guest_guide_invite' ) ) {
		return null;
	}

	$guide_url = restwell_gg_get_guide_url();
	$raw_cc    = (string) get_option( 'restwell_guide_cc_emails', 'hello@restwellretreats.co.uk' );
	$cc_list   = array_filter( array_map( 'trim', explode( "\n", $raw_cc ) ) );

	if ( function_exists( 'restwell_theme_email_guest_guide_invite' ) ) {
		return restwell_theme_email_guest_guide_invite( $email, $name, $guide_url, $cc_list );
	}

	return restwell_email_guest_guide_invite( $email, $name, $guide_url, $cc_list );
}

/**
 * Resolve which guest (or sample) to show in the invitation email preview.
 *
 * @param array<int, array<string, mixed>> $guests Guest list.
 * @return array{ email: string, name: string, label: string, is_sample: bool }
 */
function restwell_gg_preview_guest_context( array $guests ): array {
	$preview_id = isset( $_GET['preview_guest'] ) ? sanitize_text_field( wp_unslash( $_GET['preview_guest'] ) ) : '';

	if ( $preview_id !== '' ) {
		foreach ( $guests as $guest ) {
			if ( isset( $guest['id'] ) && (string) $guest['id'] === $preview_id ) {
				return array(
					'email'     => (string) $guest['email'],
					'name'      => (string) ( $guest['name'] ?? '' ),
					'label'     => $guest['name'] ? (string) $guest['name'] : (string) $guest['email'],
					'is_sample' => false,
				);
			}
		}
	}

	if ( ! empty( $guests[0]['email'] ) ) {
		return array(
			'email'     => (string) $guests[0]['email'],
			'name'      => (string) ( $guests[0]['name'] ?? '' ),
			'label'     => ! empty( $guests[0]['name'] ) ? (string) $guests[0]['name'] : (string) $guests[0]['email'],
			'is_sample' => false,
		);
	}

	return array(
		'email'     => 'jane@example.com',
		'name'      => 'Jane Smith',
		'label'     => __( 'Sample guest', 'restwell-retreats' ),
		'is_sample' => true,
	);
}

// =============================================================================
// WP-Cron: scheduled invitation dispatch
// =============================================================================

/**
 * Register the hourly cron event on `init` if it is not already scheduled.
 */
function restwell_gg_schedule_cron() {
	if ( ! wp_next_scheduled( 'restwell_gg_dispatch_scheduled' ) ) {
		wp_schedule_event( time(), 'hourly', 'restwell_gg_dispatch_scheduled' );
	}
}
add_action( 'init', 'restwell_gg_schedule_cron' );

/**
 * Cron callback: send invitation emails for any guest whose scheduled send time
 * has arrived and who has not yet been sent an invitation.
 */
function restwell_gg_process_scheduled_dispatch() {
	global $wpdb;
	$table     = $wpdb->prefix . RESTWELL_GUESTS_TABLE;
	// Use site local time so the comparison respects the configured timezone.
	$now_local = current_time( 'mysql' );

	$pending = $wpdb->get_results(
		$wpdb->prepare(
			'SELECT * FROM %i WHERE send_date <= %s AND sent_at IS NULL',
			$table,
			$now_local
		),
		ARRAY_A
	);

	foreach ( $pending as $guest ) {
		restwell_gg_send_invitation( $guest['email'], $guest['name'] );
		restwell_gg_mark_sent( (int) $guest['id'] );
	}
}
add_action( 'restwell_gg_dispatch_scheduled', 'restwell_gg_process_scheduled_dispatch' );

// =============================================================================
// Admin: form action handlers
// =============================================================================

/**
 * Handle "Add guest" form submission.
 */
function restwell_gg_handle_add_guest() {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'Insufficient permissions.', 'restwell-retreats' ) );
	}
	check_admin_referer( 'restwell_gg_add_guest' );

	$name        = isset( $_POST['gg_name'] ) ? sanitize_text_field( wp_unslash( $_POST['gg_name'] ) ) : '';
	$email       = isset( $_POST['gg_email'] ) ? sanitize_email( wp_unslash( $_POST['gg_email'] ) ) : '';
	$send_date   = isset( $_POST['gg_send_date'] ) ? sanitize_text_field( wp_unslash( $_POST['gg_send_date'] ) ) : '';
	$enquiry_id  = isset( $_POST['gg_enquiry_id'] ) ? absint( $_POST['gg_enquiry_id'] ) : 0;

	if ( is_email( $email ) && $send_date ) {
		restwell_gg_add_guest( $name, $email, $send_date, $enquiry_id );
		$status = 'added';
	} else {
		$status = 'invalid';
	}

	wp_safe_redirect(
		add_query_arg(
			array(
				'page' => 'restwell-guest-guide',
				'gg_status' => $status,
			),
			admin_url( 'admin.php' )
		)
	);
	exit;
}
add_action( 'admin_post_restwell_gg_add_guest', 'restwell_gg_handle_add_guest' );

/**
 * Handle "Delete guest" form submission.
 */
function restwell_gg_handle_delete_guest() {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'Insufficient permissions.', 'restwell-retreats' ) );
	}
	check_admin_referer( 'restwell_gg_delete_guest' );

	$id = isset( $_POST['gg_guest_id'] ) ? absint( $_POST['gg_guest_id'] ) : 0;
	if ( $id ) {
		restwell_gg_delete_guest( $id );
	}

	wp_safe_redirect(
		add_query_arg(
			array(
				'page' => 'restwell-guest-guide',
				'gg_status' => 'deleted',
			),
			admin_url( 'admin.php' )
		)
	);
	exit;
}
add_action( 'admin_post_restwell_gg_delete_guest', 'restwell_gg_handle_delete_guest' );

/**
 * Handle "Send now" / "Resend" form submission.
 */
function restwell_gg_handle_send_now() {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'Insufficient permissions.', 'restwell-retreats' ) );
	}
	check_admin_referer( 'restwell_gg_send_now' );

	$id    = isset( $_POST['gg_guest_id'] ) ? absint( $_POST['gg_guest_id'] ) : 0;
	$guest = $id ? restwell_gg_find_guest( $id ) : null;

	if ( $guest ) {
		restwell_gg_send_invitation( $guest['email'], $guest['name'] );
		restwell_gg_mark_sent( $id );
		$status = 'sent';
	} else {
		$status = 'not_found';
	}

	wp_safe_redirect(
		add_query_arg(
			array(
				'page' => 'restwell-guest-guide',
				'gg_status' => $status,
			),
			admin_url( 'admin.php' )
		)
	);
	exit;
}
add_action( 'admin_post_restwell_gg_send_now', 'restwell_gg_handle_send_now' );

/**
 * Handle "Save CC emails" form submission.
 */
function restwell_gg_handle_save_cc() {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'Insufficient permissions.', 'restwell-retreats' ) );
	}
	check_admin_referer( 'restwell_gg_save_cc' );

	$raw = isset( $_POST['restwell_guide_cc_emails'] )
		? sanitize_textarea_field( wp_unslash( $_POST['restwell_guide_cc_emails'] ) )
		: '';

	update_option( 'restwell_guide_cc_emails', $raw );

	wp_safe_redirect(
		add_query_arg(
			array(
				'page' => 'restwell-guest-guide',
				'gg_status' => 'cc_saved',
			),
			admin_url( 'admin.php' )
		)
	);
	exit;
}
add_action( 'admin_post_restwell_gg_save_cc', 'restwell_gg_handle_save_cc' );

// =============================================================================
// Admin: Settings → Guest Guide menu + page
// =============================================================================

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

	$guests     = restwell_gg_get_guests();
	$raw_cc     = (string) get_option( 'restwell_guide_cc_emails', 'hello@restwellretreats.co.uk' );
	$status     = isset( $_GET['gg_status'] ) ? sanitize_key( $_GET['gg_status'] ) : '';
	$admin_post = admin_url( 'admin-post.php' );
	$preview_ctx = restwell_gg_preview_guest_context( $guests );
	$preview_mail = restwell_gg_build_invitation_preview( $preview_ctx['email'], $preview_ctx['name'] );
	$preview_open = isset( $_GET['preview_guest'] );

	// Prefill from "Promote to Guest" link on an enquiry detail page.
	$prefill_name       = isset( $_GET['prefill_name'] ) ? sanitize_text_field( urldecode( wp_unslash( $_GET['prefill_name'] ) ) ) : '';
	$prefill_email      = isset( $_GET['prefill_email'] ) ? sanitize_email( urldecode( wp_unslash( $_GET['prefill_email'] ) ) ) : '';
	$prefill_enquiry_id = isset( $_GET['prefill_enquiry_id'] ) ? absint( $_GET['prefill_enquiry_id'] ) : 0;

	// Status notices.
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

		<!-- ================================================================ -->
		<!-- Guest list                                                        -->
		<!-- ================================================================ -->
		<h2><?php esc_html_e( 'Scheduled guest emails', 'restwell-retreats' ); ?></h2>
		<p class="description rw-lead">
			<?php esc_html_e( 'Add each confirmed guest. The invitation email is sent automatically at the scheduled date and time, or you can send it manually at any time. Only guests in this table can access the arrival guide.', 'restwell-retreats' ); ?>
		</p>

		<?php if ( empty( $guests ) ) : ?>
			<p class="rw-empty-copy"><?php esc_html_e( 'No guests yet. Add one using the form below.', 'restwell-retreats' ); ?></p>
		<?php else : ?>
		<div class="rw-table-shell rw-table-shell--guest-guide">
		<table class="widefat striped rw-guest-guide-table">
			<thead>
				<tr>
					<th scope="col" class="column-name"><?php esc_html_e( 'Name', 'restwell-retreats' ); ?></th>
					<th scope="col" class="column-email"><?php esc_html_e( 'Email', 'restwell-retreats' ); ?></th>
					<th scope="col" class="column-enquiry"><?php esc_html_e( 'Enquiry', 'restwell-retreats' ); ?></th>
					<th scope="col" class="column-scheduled"><?php esc_html_e( 'Scheduled send', 'restwell-retreats' ); ?></th>
					<th scope="col" class="column-status"><?php esc_html_e( 'Status', 'restwell-retreats' ); ?></th>
					<th scope="col" class="column-actions"><?php esc_html_e( 'Actions', 'restwell-retreats' ); ?></th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach ( $guests as $guest ) :
				// send_date is stored as a MySQL datetime in site-local time.
				if ( ! empty( $guest['send_date'] ) ) {
					$formatted_date = esc_html( date_i18n( 'j M Y, g:i a', strtotime( $guest['send_date'] ) ) );
				} else {
					$formatted_date = '-';
				}

				if ( ! empty( $guest['sent_at'] ) ) {
					$status_label = '<span class="rw-status-sent">&#10003; ' . esc_html__( 'Sent', 'restwell-retreats' ) . '</span>'
						. '<br><small>'
						. esc_html( date_i18n( 'j M Y, g:i a', strtotime( $guest['sent_at'] ) ) )
						. '</small>';
					$send_btn_label = esc_html__( 'Resend', 'restwell-retreats' );
				} else {
					$now_local = current_time( 'mysql' );
					if ( ! empty( $guest['send_date'] ) && $guest['send_date'] > $now_local ) {
						$status_label = '<span class="rw-status-scheduled">' . esc_html__( 'Scheduled', 'restwell-retreats' ) . '</span>';
					} else {
						$status_label = '<span class="rw-status-pending">' . esc_html__( 'Pending', 'restwell-retreats' ) . '</span>';
					}
					$send_btn_label = esc_html__( 'Send now', 'restwell-retreats' );
				}
				?>
				<tr>
					<td class="column-name" data-label="<?php echo esc_attr__( 'Name', 'restwell-retreats' ); ?>">
						<?php echo esc_html( restwell_first_nonempty_string( $guest['name'] ?? '', '-' ) ); ?>
					</td>
					<td class="column-email" data-label="<?php echo esc_attr__( 'Email', 'restwell-retreats' ); ?>">
						<?php if ( ! empty( $guest['email'] ) ) : ?>
							<a class="rw-cell-email rw-tap-link" href="<?php echo esc_url( 'mailto:' . $guest['email'] ); ?>">
								<?php echo esc_html( $guest['email'] ); ?>
							</a>
						<?php else : ?>
							<span class="rw-text-dim">&ndash;</span>
						<?php endif; ?>
					</td>
					<?php
					$enq_id = isset( $guest['enquiry_id'] ) ? absint( $guest['enquiry_id'] ) : 0;
					?>
					<td class="column-enquiry<?php echo $enq_id > 0 ? '' : ' rw-cell--empty'; ?>" data-label="<?php echo esc_attr__( 'Enquiry', 'restwell-retreats' ); ?>">
						<?php
						if ( $enq_id > 0 ) :
							$enq_url = add_query_arg(
								array(
									'page' => 'restwell-enquiries',
									'view' => $enq_id,
								),
								admin_url( 'admin.php' )
							);
							?>
							<a href="<?php echo esc_url( $enq_url ); ?>">
								<?php
								echo esc_html(
									sprintf(
										/* translators: %d: enquiry ID */
										__( '#%d', 'restwell-retreats' ),
										$enq_id
									)
								);
								?>
							</a>
						<?php else : ?>
							<span class="rw-text-dim">&ndash;</span>
						<?php endif; ?>
					</td>
					<td class="column-scheduled" data-label="<?php echo esc_attr__( 'Scheduled send', 'restwell-retreats' ); ?>">
						<?php echo esc_html( $formatted_date ); ?>
					</td>
					<td class="column-status" data-label="<?php echo esc_attr__( 'Status', 'restwell-retreats' ); ?>">
						<?php
						echo wp_kses(
							$status_label,
							array(
								'span'  => array( 'class' => array() ),
								'br'    => array(),
								'small' => array(),
							)
						);
						?>
					</td>
					<td class="column-actions rw-action-cell" data-label="<?php echo esc_attr__( 'Actions', 'restwell-retreats' ); ?>">
						<div class="rw-action-cell-inner">
						<!-- Send now / Resend -->
						<form method="post" action="<?php echo esc_url( $admin_post ); ?>">
							<?php wp_nonce_field( 'restwell_gg_send_now' ); ?>
							<input type="hidden" name="action" value="restwell_gg_send_now" />
							<input type="hidden" name="gg_guest_id" value="<?php echo esc_attr( $guest['id'] ); ?>" />
							<button type="submit" class="button button-secondary button-small">
								<?php echo esc_html( $send_btn_label ); ?>
							</button>
						</form>
						<a
							class="button button-link button-small rw-gg-preview-link"
							href="
							<?php
							echo esc_url(
								add_query_arg(
									array(
										'page' => 'restwell-guest-guide',
										'preview_guest' => $guest['id'],
									),
									admin_url( 'admin.php' )
								) . '#rw-gg-email-preview'
							);
							?>
									"
						>
							<?php esc_html_e( 'View email', 'restwell-retreats' ); ?>
						</a>
						<!-- Delete -->
						<form method="post" action="<?php echo esc_url( $admin_post ); ?>"
							  onsubmit="return confirm('<?php echo esc_js( __( 'Remove this guest?', 'restwell-retreats' ) ); ?>')">
							<?php wp_nonce_field( 'restwell_gg_delete_guest' ); ?>
							<input type="hidden" name="action" value="restwell_gg_delete_guest" />
							<input type="hidden" name="gg_guest_id" value="<?php echo esc_attr( $guest['id'] ); ?>" />
							<button type="submit" class="button button-link-delete button-small">
								<?php esc_html_e( 'Delete', 'restwell-retreats' ); ?>
							</button>
						</form>
						</div>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		</div>
		<?php endif; ?>

		<?php if ( $preview_mail ) : ?>
			<details
				id="rw-gg-email-preview"
				class="rw-email-preview"
				<?php echo $preview_open ? ' open' : ''; ?>
			>
				<summary class="rw-email-preview__summary">
					<?php esc_html_e( 'View invitation email', 'restwell-retreats' ); ?>
				</summary>
				<div class="rw-email-preview__body">
					<p class="description rw-email-preview__meta">
						<?php
						echo esc_html(
							sprintf(
								/* translators: %s: guest name or sample label */
								__( 'Not sent. This is the HTML for: %s', 'restwell-retreats' ),
								$preview_ctx['label']
							)
						);
						if ( $preview_ctx['is_sample'] ) {
							echo ' ';
							esc_html_e( '(sample: add a guest or use View email on a row for a real name.)', 'restwell-retreats' );
						}
						?>
					</p>
					<div class="rw-email-preview__meta-card">
						<p class="rw-email-preview__subject">
							<span class="rw-email-preview__label"><?php esc_html_e( 'Subject', 'restwell-retreats' ); ?></span>
							<span class="rw-email-preview__value"><?php echo esc_html( $preview_mail['subject'] ); ?></span>
						</p>
						<?php
						$cc_preview = array_filter( array_map( 'trim', explode( "\n", $raw_cc ) ) );
						if ( ! empty( $cc_preview ) ) :
							?>
							<p class="rw-email-preview__cc">
								<span class="rw-email-preview__label"><?php esc_html_e( 'CC', 'restwell-retreats' ); ?></span>
								<span class="rw-email-preview__value"><?php echo esc_html( implode( ', ', $cc_preview ) ); ?></span>
							</p>
						<?php endif; ?>
					</div>
					<div class="rw-email-preview__viewport">
						<iframe
							class="rw-email-preview__frame"
							title="<?php echo esc_attr__( 'Invitation email preview', 'restwell-retreats' ); ?>"
							sandbox=""
							srcdoc="<?php echo esc_attr( $preview_mail['body'] ); ?>"
						></iframe>
					</div>
				</div>
			</details>
		<?php endif; ?>

		<!-- Add guest form -->
		<h3 class="rw-subsection-title">
			<?php
			echo $prefill_name
				? sprintf(
					/* translators: %s: enquirer name */
					esc_html__( 'Add a guest (pre-filled from enquiry: %s)', 'restwell-retreats' ),
					'<strong>' . esc_html( $prefill_name ) . '</strong>'
				)
				: esc_html__( 'Add a guest', 'restwell-retreats' );
			?>
		</h3>
		<form method="post" action="<?php echo esc_url( $admin_post ); ?>" class="rw-settings-wrap">
			<?php wp_nonce_field( 'restwell_gg_add_guest' ); ?>
			<input type="hidden" name="action" value="restwell_gg_add_guest" />
			<?php if ( $prefill_enquiry_id ) : ?>
				<input type="hidden" name="gg_enquiry_id" value="<?php echo esc_attr( $prefill_enquiry_id ); ?>" />
			<?php endif; ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row">
						<label for="gg_name"><?php esc_html_e( 'Guest name', 'restwell-retreats' ); ?></label>
					</th>
					<td>
						<input type="text" id="gg_name" name="gg_name" class="regular-text"
							   value="<?php echo esc_attr( $prefill_name ); ?>"
							   placeholder="<?php esc_attr_e( 'Jane Smith', 'restwell-retreats' ); ?>" />
						<p class="description"><?php esc_html_e( 'Optional; used in the invitation email greeting.', 'restwell-retreats' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="gg_email"><?php esc_html_e( 'Email address', 'restwell-retreats' ); ?> <span class="rw-required" aria-hidden="true">*</span></label>
					</th>
					<td>
						<input type="email" id="gg_email" name="gg_email" class="regular-text" required
							   value="<?php echo esc_attr( $prefill_email ); ?>"
							   placeholder="jane@example.com" />
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="gg_send_date"><?php esc_html_e( 'Scheduled send', 'restwell-retreats' ); ?> <span class="rw-required" aria-hidden="true">*</span></label>
					</th>
					<td>
						<input type="datetime-local" id="gg_send_date" name="gg_send_date" class="regular-text" required />
						<p class="description">
							<?php esc_html_e( 'The invitation email will be sent automatically at this date and time. You can also send it immediately with "Send now" after adding.', 'restwell-retreats' ); ?>
						</p>
					</td>
				</tr>
			</table>
			<?php submit_button( __( 'Add guest', 'restwell-retreats' ), 'secondary', 'submit', false ); ?>
		</form>

		<hr class="rw-section-rule" />

		<!-- ================================================================ -->
		<!-- CC email addresses                                                -->
		<!-- ================================================================ -->
		<h2><?php esc_html_e( 'Invitation email: CC addresses', 'restwell-retreats' ); ?></h2>
		<p class="description rw-lead">
			<?php esc_html_e( 'Every invitation email will CC these addresses. One address per line.', 'restwell-retreats' ); ?>
		</p>
		<form method="post" action="<?php echo esc_url( $admin_post ); ?>" class="rw-settings-wrap">
			<?php wp_nonce_field( 'restwell_gg_save_cc' ); ?>
			<input type="hidden" name="action" value="restwell_gg_save_cc" />
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row">
						<label for="restwell_guide_cc_emails"><?php esc_html_e( 'CC addresses', 'restwell-retreats' ); ?></label>
					</th>
					<td>
						<textarea
							id="restwell_guide_cc_emails"
							name="restwell_guide_cc_emails"
							rows="5"
							cols="40"
							class="large-text code"
						><?php echo esc_textarea( $raw_cc ); ?></textarea>
					</td>
				</tr>
			</table>
			<?php submit_button( __( 'Save CC addresses', 'restwell-retreats' ), 'secondary', 'submit', false ); ?>
		</form>

	</div>
	<?php
}

// =============================================================================
// Helpers: approved-email check
// =============================================================================

/**
 * Check whether an email address belongs to a guest in the guest list.
 *
 * Comparison is case-insensitive.
 *
 * @param string $email Raw email address submitted by the user.
 * @return bool True when the email is on the guest list.
 */
function restwell_is_approved_email( $email ): bool {
	global $wpdb;
	$table = $wpdb->prefix . RESTWELL_GUESTS_TABLE;
	$count = (int) $wpdb->get_var(
		$wpdb->prepare( 'SELECT COUNT(*) FROM %i WHERE LOWER(email) = LOWER(%s)', $table, trim( $email ) )
	);
	return $count > 0;
}

// =============================================================================
// Helpers: OTP
// =============================================================================

/**
 * Per-email issuance throttle for OTP requests.
 *
 * Complements the per-IP throttle (`restwell_form_rate_limit_exceeded()`):
 * the IP guard stops a single attacker, this guard stops a distributed
 * email-bomb attack on one specific guest's inbox. Capped at 5 issuances
 * per hour per email by default — well above what a real guest needs even
 * with retries, far below what an attacker would need for abuse.
 *
 * Counter increments on every call (matching the per-IP helper's contract),
 * so simply *checking* the throttle uses a slot. Always call this immediately
 * before issuing an OTP, never speculatively.
 *
 * @param string $email  Email address (will be lower-cased / trimmed for keying).
 * @param int    $max    Max issuances per window. Default 5.
 * @param int    $window Window length in seconds. Default 1 hour.
 * @return bool True when the limit has been exceeded (caller must block).
 */
function restwell_guide_otp_email_throttled( string $email, int $max = 5, int $window = HOUR_IN_SECONDS ): bool {
	$key   = 'rw_otp_email_' . md5( strtolower( trim( $email ) ) );
	$count = (int) get_transient( $key );
	if ( $count >= $max ) {
		return true;
	}
	set_transient( $key, $count + 1, $window );
	return false;
}

/**
 * HMAC hash for a guest-guide OTP (never store the raw code).
 *
 * @param string $code Six-digit OTP.
 * @return string
 */
function restwell_guide_otp_hash( string $code ): string {
	return hash_hmac( 'sha256', $code, wp_salt( 'auth' ) );
}

/**
 * Generate a 6-digit OTP, persist a hash as a 30-minute WordPress transient,
 * and send the plaintext code to the guest via wp_mail().
 *
 * Note: this function does NOT enforce rate limits. Callers are responsible
 * for checking `restwell_form_rate_limit_exceeded( 'guide_otp', ... )` and
 * `restwell_guide_otp_email_throttled()` before calling, so that legitimate
 * non-public callers (admin tooling, future cron jobs) can bypass throttles.
 *
 * On mail failure the transient is removed so a undelivered code cannot be used.
 *
 * @param string $email Verified approved email address.
 * @return bool True when the message was accepted by wp_mail().
 */
function restwell_send_guide_otp( $email ) {
	$code = str_pad( (string) wp_rand( 0, 999999 ), 6, '0', STR_PAD_LEFT );
	$key  = 'restwell_guide_otp_' . md5( strtolower( trim( $email ) ) );

	set_transient( $key, restwell_guide_otp_hash( $code ), 30 * MINUTE_IN_SECONDS );

	$mail = restwell_email_otp( $email, $code );
	if ( function_exists( 'restwell_wp_mail_with_retry' ) ) {
		$sent = restwell_wp_mail_with_retry( $email, $mail['subject'], $mail['body'], $mail['headers'] );
	} else {
		$sent = wp_mail( $email, $mail['subject'], $mail['body'], $mail['headers'] );
	}

	if ( ! $sent ) {
		delete_transient( $key );
		// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log -- intentional ops signal for failed OTP delivery.
		error_log( 'restwell_send_guide_otp: wp_mail failed for guest guide OTP.' );
		return false;
	}

	return true;
}

/**
 * User-facing copy when OTP email delivery fails.
 *
 * @return string
 */
function restwell_guide_otp_mail_failed_message(): string {
	return sprintf(
		/* translators: %s: phone number */
		__( "We couldn't send your code just now. Please try again in a moment, or call us on %s and we'll help.", 'restwell-retreats' ),
		(string) get_option( 'restwell_phone_number', '01622 809881' )
	);
}

/**
 * Verify a submitted OTP code against the stored transient hash.
 *
 * Uses hash_equals() for timing-safe comparison. Deletes the transient on a
 * successful match to prevent reuse. Accepts legacy plaintext transients from
 * before hashed storage so in-flight codes still work after deploy.
 *
 * @param string $email Email address used when the OTP was generated.
 * @param string $code  Raw code submitted by the user.
 * @return bool True when the code matches and has not expired.
 */
function restwell_verify_guide_otp( $email, $code ) {
	$key    = 'restwell_guide_otp_' . md5( strtolower( trim( $email ) ) );
	$stored = get_transient( $key );

	if ( false === $stored ) {
		return false;
	}

	$stored     = (string) $stored;
	$code       = (string) $code;
	$code_hash  = restwell_guide_otp_hash( $code );
	$matched    = hash_equals( $stored, $code_hash );
	// Legacy: plaintext 6-digit codes issued before hashed storage.
	if ( ! $matched && preg_match( '/^\d{6}$/', $stored ) ) {
		$matched = hash_equals( $stored, $code );
	}

	if ( ! $matched ) {
		return false;
	}

	delete_transient( $key );
	return true;
}

/**
 * Return a partially-masked email address suitable for display.
 *
 * Example: jane.smith@example.com → ja**********@example.com
 *
 * @param string $email Raw email address.
 * @return string Masked email, or the original value if it cannot be parsed.
 */
function restwell_mask_guide_email( $email ) {
	$parts = explode( '@', $email, 2 );

	if ( 2 !== count( $parts ) || '' === $parts[0] ) {
		return $email;
	}

	$local   = $parts[0];
	$visible = substr( $local, 0, min( 2, strlen( $local ) ) );
	$stars   = str_repeat( '*', max( 2, strlen( $local ) - strlen( $visible ) ) );

	return $visible . $stars . '@' . $parts[1];
}

// =============================================================================
// Meta box: Guest Arrival Guide Content
// =============================================================================

define( 'RESTWELL_GG_NONCE_ACTION', 'restwell_guest_guide_meta_save' );
define( 'RESTWELL_GG_NONCE_NAME', 'restwell_gg_nonce' );

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
