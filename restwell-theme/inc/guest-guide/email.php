<?php
/**
 * Guest Guide invitation email HTML.
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
	if ( function_exists( 'restwell_email_wrap_welcome' ) ) {
		return restwell_email_wrap_welcome( $content, $preview );
	}

	$site = wp_strip_all_tags( (string) get_bloginfo( 'name' ) );
	return '<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>' . esc_html( $site ) . '</title>
</head>
<body style="margin:0;padding:0;font-family:Arial,Helvetica,sans-serif;">
' . $content . '
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
	$inner = '<p style="margin:0 0 14px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;letter-spacing:0.14em;text-transform:uppercase;color:#9E9589;">'
		. esc_html__( 'How to open your guide', 'restwell-retreats' )
		. '</p>
      <p style="margin:0 0 12px 0;font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#2d4a52;line-height:1.55;">
        <span style="color:#D4A853;font-weight:bold;">1.</span>&nbsp; '
		. esc_html__( 'Open the link below (or the button).', 'restwell-retreats' )
		. '</p>
      <p style="margin:0 0 12px 0;font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#2d4a52;line-height:1.55;">
        <span style="color:#D4A853;font-weight:bold;">2.</span>&nbsp; '
		. esc_html__( 'Enter your email:', 'restwell-retreats' )
		. ' <strong style="color:#1B4D5C;">' . esc_html( $email ) . '</strong></p>
      <p style="margin:0;font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#2d4a52;line-height:1.55;">
        <span style="color:#D4A853;font-weight:bold;">3.</span>&nbsp; '
		. esc_html__( 'We will send a one-time code to that address. Enter it to unlock your guide.', 'restwell-retreats' )
		. '</p>';

	if ( function_exists( 'restwell_email_panel' ) ) {
		return restwell_email_panel( $inner, '#F5EDE0' );
	}

	return '<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin:8px 0;border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt;">
  <tr>
    <td bgcolor="#F5EDE0" style="background-color:#F5EDE0;padding:20px 22px;font-family:Arial,Helvetica,sans-serif;">
      ' . $inner . '
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
		: '<table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" style="margin:28px auto 0 auto;border-collapse:collapse;">
  <tr>
    <td align="center" bgcolor="#1B4D5C" style="background-color:#1B4D5C;padding:14px 32px;">
      <a href="' . esc_url( $guide_url ) . '" style="color:#ffffff;text-decoration:none;font-family:Arial,Helvetica,sans-serif;font-size:14px;font-weight:bold;">' . esc_html__( 'Open your arrival guide', 'restwell-retreats' ) . '</a>
    </td>
  </tr>
</table>
<p style="text-align:center;margin:12px 0 0 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#9E9589;">' . esc_html__( 'Or copy this link:', 'restwell-retreats' ) . ' <a href="' . esc_url( $guide_url ) . '" style="color:#1B4D5C;word-break:break-all;">' . esc_url( $guide_url ) . '</a></p>';

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
