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
