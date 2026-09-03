<?php
/**
 * Branded HTML email templates for Restwell Retreats.
 *
 * Every public function returns a two-element array:
 *   [ 'subject' => string, 'body' => string, 'headers' => array ]
 * ready to be passed directly to wp_mail().
 *
 * Design tokens (matching restwell-theme/assets/css/shared.css):
 *   Deep teal   #1B4D5C   (--deep-teal)
 *   Warm gold   #D4A853   (--warm-gold)
 *   Driftwood   #E8DFD0   (--driftwood; email header accent, replaces retired sea-glass)
 *   Soft sand   #F5EDE0   (--soft-sand)
 *   Muted grey  #3A5A63   (--muted-grey)
 *
 * @package Restwell_CRM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ---------------------------------------------------------------------------
// Internal helpers
// ---------------------------------------------------------------------------

/**
 * Wrap arbitrary HTML body content in the shared Restwell email shell.
 *
 * @param string $content  Inner HTML to drop into the body section.
 * @param string $preview  Short preview-text string (hidden pre-header).
 * @return string          Full HTML email document.
 */
function restwell_email_wrap( string $content, string $preview = '' ): string {
	$font_base  = function_exists( 'restwell_crm_theme_asset_uri' ) ? restwell_crm_theme_asset_uri() : get_template_directory_uri();
	$site       = wp_strip_all_tags( (string) get_bloginfo( 'name' ) );
	$home       = esc_url( home_url( '/' ) );
	$year       = gmdate( 'Y' );
	$phone      = esc_html( (string) get_option( 'restwell_phone_number', '01622 809881' ) );
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
<!--[if !mso]><!-->
<style type="text/css">
  /* Self-hosted fonts - work in Apple Mail, Yahoo, Samsung. Gmail strips <style>; fallbacks handle it. */
  @font-face {
    font-family: "Inter";
    src: url("' . esc_url( $font_base ) . '/assets/fonts/inter/Inter-VariableFont_opsz,wght.ttf") format("truetype");
    font-weight: 100 900;
    font-style: normal;
  }
  @font-face {
    font-family: "Inter";
    src: url("' . esc_url( $font_base ) . '/assets/fonts/inter/Inter-Italic-VariableFont_opsz,wght.ttf") format("truetype");
    font-weight: 100 900;
    font-style: italic;
  }
  @font-face {
    font-family: "Lora";
    src: url("' . esc_url( $font_base ) . '/assets/fonts/lora/Lora-VariableFont_wght.ttf") format("truetype");
    font-weight: 400 700;
    font-style: normal;
  }
  @font-face {
    font-family: "Lora";
    src: url("' . esc_url( $font_base ) . '/assets/fonts/lora/Lora-Italic-VariableFont_wght.ttf") format("truetype");
    font-weight: 400 700;
    font-style: italic;
  }
</style>
<!--<![endif]-->
<!--[if mso]>
<noscript><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml></noscript>
<![endif]-->
</head>
<body style="margin:0;padding:0;background-color:#EFEFEF;font-family:\'Inter\',system-ui,Arial,sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;">
' . $pre_header . '

<!-- Email wrapper -->
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color:#EFEFEF;">
<tr><td style="padding:24px 12px;">

  <!-- 600px card -->
  <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" align="center" style="max-width:600px;width:100%;background-color:#FFFFFF;border-radius:4px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.08);">

    <!-- ─── HEADER ────────────────────────────────────────────── -->
    <tr>
      <td bgcolor="#1B4D5C" style="background-color:#1B4D5C;padding:36px 40px 0 40px;text-align:center;">
        <a href="' . $home . '" style="text-decoration:none;">
          <p style="margin:0;font-family:\'Lora\',Georgia,serif;font-size:26px;font-weight:normal;letter-spacing:0.04em;color:#FFFFFF;line-height:1.2;">' . esc_html( $site ) . '</p>
          <p style="margin:6px 0 0 0;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:11px;letter-spacing:0.2em;text-transform:uppercase;color:#E8DFD0;">Accessible holidays &middot; Whitstable, Kent</p>
        </a>
        <!-- gold rule -->
        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-top:28px;">
          <tr><td height="3" style="background-color:#D4A853;font-size:0;line-height:0;">&nbsp;</td></tr>
        </table>
      </td>
    </tr>

    <!-- ─── BODY ──────────────────────────────────────────────── -->
    <tr>
      <td style="padding:40px 40px 36px 40px;background-color:#FFFFFF;">
' . $content . '
      </td>
    </tr>

    <!-- ─── FOOTER ────────────────────────────────────────────── -->
    <tr>
      <td bgcolor="#F5EDE0" style="background-color:#F5EDE0;padding:24px 40px;text-align:center;border-top:1px solid #E8DFD0;">
        <p style="margin:0 0 6px 0;font-family:\'Lora\',Georgia,serif;font-size:14px;color:#1B4D5C;font-weight:normal;">' . esc_html( $site ) . '</p>
        <p style="margin:0 0 10px 0;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:12px;color:#3A5A63;line-height:1.6;">
          hello@restwellretreats.co.uk &nbsp;&bull;&nbsp; ' . $phone . '
        </p>
        <p style="margin:0;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:11px;color:#9E9589;line-height:1.6;">
          &copy; ' . $year . ' ' . esc_html( $site ) . '. All rights reserved.
        </p>
      </td>
    </tr>

  </table>
  <!-- /600px card -->

</td></tr>
</table>
<!-- /Email wrapper -->

</body>
</html>';
}

/**
 * Welcome Guide–style shell for the guest invitation email (logo, gold rule, no teal banner stack).
 *
 * @param string $content Inner HTML.
 * @param string $preview Preheader text.
 * @return string Full HTML email document.
 */
function restwell_email_wrap_welcome( string $content, string $preview = '' ): string {
	$font_base = function_exists( 'restwell_crm_theme_asset_uri' ) ? restwell_crm_theme_asset_uri() : get_template_directory_uri();
	$site      = wp_strip_all_tags( (string) get_bloginfo( 'name' ) );
	$home      = esc_url( home_url( '/' ) );
	$year      = gmdate( 'Y' );
	$phone     = esc_html( (string) get_option( 'restwell_phone_number', '01622 809881' ) );
  $logo_url  = esc_url( restwell_theme_image_url( 'long_logo.png' ) );
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
 * Render a full-width teal banner (used as the first element inside the body cell).
 *
 * @param string $label   Small uppercase eyebrow label.
 * @param string $heading Main heading text.
 * @return string HTML snippet.
 */
function restwell_email_banner( string $label, string $heading ): string {
	return '<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin:-40px -40px 32px -40px;width:calc(100% + 80px);">
  <tr>
    <td bgcolor="#1B4D5C" style="background-color:#1B4D5C;padding:32px 40px;text-align:center;">
        <p style="margin:0 0 8px 0;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:11px;letter-spacing:0.2em;text-transform:uppercase;color:#F0C97A;">' . esc_html( $label ) . '</p>
      <h1 style="margin:0;font-family:\'Lora\',Georgia,serif;font-size:24px;font-weight:normal;color:#FFFFFF;line-height:1.3;">' . esc_html( $heading ) . '</h1>
    </td>
  </tr>
</table>';
}

/**
 * Render a CTA button (centred).
 *
 * @param string $url   Destination URL.
 * @param string $label Button text.
 * @param string $color Background colour (hex). Defaults to deep teal.
 * @return string HTML snippet.
 */
function restwell_email_button( string $url, string $label, string $color = '#1B4D5C' ): string {
	return '<table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" style="margin:28px auto 0 auto;">
  <tr>
    <td style="border-radius:3px;background-color:' . esc_attr( $color ) . ';">
      <a href="' . esc_url( $url ) . '" target="_blank" style="display:inline-block;padding:14px 32px;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:14px;font-weight:600;letter-spacing:0.04em;color:#FFFFFF;text-decoration:none;border-radius:3px;">' . esc_html( $label ) . '</a>
    </td>
  </tr>
</table>
<p style="text-align:center;margin:12px 0 0 0;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:11px;color:#9E9589;">
  Or copy this link: <a href="' . esc_url( $url ) . '" style="color:#1B4D5C;word-break:break-all;">' . esc_url( $url ) . '</a>
</p>';
}

/**
 * Render a key-value info row (light sand background).
 *
 * @param array<string,string> $rows Associative array of label => value.
 * @return string HTML snippet.
 */
function restwell_email_info_table( array $rows ): string {
	$html = '<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin:20px 0;border-radius:3px;overflow:hidden;">';
	$i    = 0;
	foreach ( $rows as $label => $value ) {
		$bg    = ( $i % 2 === 0 ) ? '#F5EDE0' : '#FAF5EE';
		$html .= '<tr>
      <td width="36%" style="background-color:' . $bg . ';padding:10px 14px;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:12px;font-weight:600;color:#1B4D5C;vertical-align:top;">' . esc_html( $label ) . '</td>
      <td width="64%" style="background-color:' . $bg . ';padding:10px 14px;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:13px;color:#2d4a52;vertical-align:top;">' . wp_kses_post( $value ) . '</td>
    </tr>';
		++$i;
	}
	$html .= '</table>';
	return $html;
}

/**
 * Shared sign-off block.
 *
 * @return string HTML snippet.
 */
function restwell_email_signoff(): string {
	$site = wp_strip_all_tags( (string) get_bloginfo( 'name' ) );
	return '<p style="margin:28px 0 0 0;font-family:\'Lora\',Georgia,serif;font-size:16px;color:#1B4D5C;line-height:1.7;">
  Warm regards,<br>
  <strong>The Restwell team</strong>
</p>';
}

// ---------------------------------------------------------------------------
// 1. Enquiry acknowledgement
// ---------------------------------------------------------------------------

/**
 * Build the HTML enquiry acknowledgement email sent to the person who enquired.
 *
 * @param string $name    Enquirer's name.
 * @param string $email   Enquirer's email address.
 * @param bool   $urgent  Whether the enquiry was marked urgent.
 * @return array{ subject: string, body: string, headers: string[] }
 */
function restwell_email_enquiry_ack( string $name, string $email, bool $urgent = false ): array {
	$site       = wp_strip_all_tags( (string) get_bloginfo( 'name' ) );
	$first_name = explode( ' ', trim( $name ) )[0];

	$subject = $site . ' | ' . __( "We've got your enquiry", 'restwell-retreats' );
	$preview = __( 'There’s nothing to pay at this stage. We’ll reply properly, usually within 48 hours.', 'restwell-retreats' );

	$urgent_note = $urgent
		? '<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin:20px 0;">
        <tr>
          <td style="background-color:#FEF3C7;border-left:4px solid #D4A853;border-radius:3px;padding:14px 16px;">
            <p style="margin:0;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:13px;color:#92400E;line-height:1.6;">
			<strong>Your enquiry has been flagged as urgent.</strong> A member of our team will aim to contact you as a priority. If you need to speak with us sooner, please call <strong>' . esc_html( (string) get_option( 'restwell_phone_number', '01622 809881' ) ) . '</strong> and quote your name.
            </p>
          </td>
        </tr>
      </table>'
		: '';

	$phone = esc_html( (string) get_option( 'restwell_phone_number', '01622 809881' ) );

	$content = restwell_email_banner( 'We’ve got your enquiry', 'Thank you, ' . $first_name . '.' )
		. '<p style="margin:0 0 16px 0;font-family:\'Lora\',Georgia,serif;font-size:16px;color:#1B4D5C;line-height:1.7;">
    Your enquiry about the bungalow in Whitstable has reached us, and one of us will reply properly, usually within 48 hours, and sooner if we can.
  </p>'
		. $urgent_note
		. '<p style="margin:0 0 16px 0;font-family:\'Lora\',Georgia,serif;font-size:16px;color:#1B4D5C;line-height:1.7;">
    There’s nothing to pay at this stage and nothing to commit to. When we write back we’ll confirm whether your dates are free and answer whatever you’ve asked.
  </p>
  <p style="margin:0 0 16px 0;font-family:\'Lora\',Georgia,serif;font-size:16px;color:#1B4D5C;line-height:1.7;">
    If you mentioned care, that’s in hand too. Continuity of Care Services is our sister company, in the same office on the same phone, so it’s one conversation rather than two. And if you’re bringing your own carer or PA, they’re very welcome. It doesn’t change anything.
  </p>
  <p style="margin:0 0 20px 0;font-family:\'Lora\',Georgia,serif;font-size:16px;color:#1B4D5C;line-height:1.7;">
    If your plans shift in the meantime, or you think of something you forgot to mention, just reply to this email. There’s no such thing as a silly question.
  </p>
  <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin:20px 0;">
    <tr>
      <td style="background-color:#F5EDE0;border-radius:3px;padding:18px 20px;text-align:center;">
        <p style="margin:0 0 4px 0;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:11px;letter-spacing:0.12em;text-transform:uppercase;color:#3A5A63;">Questions? Reach us directly</p>
        <p style="margin:0 0 6px 0;font-family:\'Lora\',Georgia,serif;font-size:20px;color:#1B4D5C;">' . $phone . '</p>
        <p style="margin:0;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:14px;color:#2d4a52;"><a href="mailto:hello@restwellretreats.co.uk" style="color:#1B4D5C;text-decoration:underline;">hello@restwellretreats.co.uk</a></p>
      </td>
    </tr>
  </table>
  <p style="margin:28px 0 0 0;font-family:\'Lora\',Georgia,serif;font-size:16px;color:#1B4D5C;line-height:1.7;">Rest Easy, Stay Well.</p>';

	$headers = array(
		'Content-Type: text/html; charset=UTF-8',
		'Reply-To: hello@restwellretreats.co.uk',
	);

	return array(
		'subject' => $subject,
		'body'    => restwell_email_wrap( $content, $preview ),
		'headers' => $headers,
	);
}

/**
 * Build the internal enquiry notification email for staff.
 *
 * @param array<string, mixed> $data Enquiry data and CRM id.
 * @return array{ subject: string, body: string, headers: string[] }
 */
function restwell_email_enquiry_notification( array $data ): array {
  $id      = isset( $data['id'] ) ? absint( $data['id'] ) : 0;
  $name    = isset( $data['name'] ) ? (string) $data['name'] : '';
  $email   = isset( $data['email'] ) ? (string) $data['email'] : '';
  $phone   = isset( $data['phone'] ) ? (string) $data['phone'] : '';
  $urgent  = ! empty( $data['urgent'] );
  $subject = restwell_mail_staff_subject( $urgent ? 'urgent_enquiry' : 'enquiry', $id );
  $rows    = array(
    __( 'Name', 'restwell-retreats' )              => $name,
    __( 'Email', 'restwell-retreats' )             => '<a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a>',
    __( 'Phone', 'restwell-retreats' )             => '<a href="tel:' . esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ) . '">' . esc_html( $phone ) . '</a>',
    __( 'Preferred contact', 'restwell-retreats' ) => isset( $data['contact_pref'] ) ? (string) $data['contact_pref'] : '',
    __( 'Best time to call', 'restwell-retreats' ) => isset( $data['pref_time'] ) ? (string) $data['pref_time'] : '',
    __( 'Preferred dates', 'restwell-retreats' )   => isset( $data['dates'] ) ? (string) $data['dates'] : '',
    __( 'Guests', 'restwell-retreats' )            => isset( $data['guests'] ) ? (string) $data['guests'] : '',
    __( 'Funding type', 'restwell-retreats' )     => isset( $data['funding'] ) ? restwell_enquiry_funding_label( (string) $data['funding'] ) : '',
  );
  $rows = array_filter( $rows, static function ( $value ) {
    return '' !== trim( wp_strip_all_tags( (string) $value ) );
  } );

  $sections = '';
  foreach ( array( 'care' => __( 'Care requirements', 'restwell-retreats' ), 'access' => __( 'Accessibility needs', 'restwell-retreats' ), 'message' => __( 'Message', 'restwell-retreats' ) ) as $key => $label ) {
    $value = isset( $data[ $key ] ) ? trim( (string) $data[ $key ] ) : '';
    if ( '' !== $value ) {
      $sections .= '<p style="margin:24px 0 8px;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:12px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#1B4D5C;">' . esc_html( $label ) . '</p><div style="padding:14px 16px;background:#F5EDE0;border-left:3px solid #D4A853;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:14px;line-height:1.6;color:#2d4a52;white-space:pre-line;">' . esc_html( $value ) . '</div>';
    }
  }

  $content = restwell_email_banner( $urgent ? __( 'Urgent enquiry', 'restwell-retreats' ) : __( 'New enquiry', 'restwell-retreats' ), $name )
    . ( $urgent ? '<p style="margin:0 0 20px;padding:12px 16px;background:#FEF3C7;border-left:4px solid #D4A853;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:14px;font-weight:600;color:#92400E;">' . esc_html__( 'Priority callback requested.', 'restwell-retreats' ) . '</p>' : '' )
    . restwell_email_info_table( $rows )
    . $sections
    . '<p style="margin:28px 0 0;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:12px;color:#6B7D82;">' . esc_html( sprintf( __( 'CRM enquiry ID: #%d', 'restwell-retreats' ), $id ) ) . '</p>';

  return array(
    'subject' => $subject,
    'body'    => restwell_email_wrap( $content, $urgent ? __( 'Urgent Restwell enquiry requiring a priority callback.', 'restwell-retreats' ) : __( 'New Restwell enquiry received.', 'restwell-retreats' ) ),
    'headers' => array( 'Content-Type: text/html; charset=UTF-8', restwell_mail_reply_to_header( $email ) ),
  );
}

// ---------------------------------------------------------------------------
// 2. Guest Guide invitation
// ---------------------------------------------------------------------------

/**
 * Build the guest guide invitation email sent when a guest is added.
 *
 * @param string $email     Guest's email address.
 * @param string $name      Guest's display name (optional).
 * @param string $guide_url URL of the guest guide page.
 * @param array  $cc_list   Array of CC email addresses.
 * @return array{ subject: string, body: string, headers: string[] }
 */
function restwell_email_guest_guide_invite( string $email, string $name, string $guide_url, array $cc_list = array() ): array {
	// Prefer theme builder when available (Playground mounts theme live; keeps preview = send).
	if ( function_exists( 'restwell_theme_email_guest_guide_invite' ) ) {
		return restwell_theme_email_guest_guide_invite( $email, $name, $guide_url, $cc_list );
	}

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

	$steps = '<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin:8px 0 8px 0;">
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
		. $steps
		. restwell_email_button( $guide_url, __( 'Open your arrival guide', 'restwell-retreats' ) )
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
		'body'    => restwell_email_wrap_welcome( $content, $preview ),
		'headers' => $headers,
	);
}

// ---------------------------------------------------------------------------
// 3. One-time access code (OTP)
// ---------------------------------------------------------------------------

/**
 * Build the guest guide OTP email.
 *
 * @param string $email Guest's email address.
 * @param string $code  6-digit OTP code.
 * @return array{ subject: string, body: string, headers: string[] }
 */
function restwell_email_otp( string $email, string $code ): array {
	$site    = wp_strip_all_tags( (string) get_bloginfo( 'name' ) );
	$subject = $site . ' | ' . __( 'Your guest guide access code', 'restwell-retreats' );
	$preview = sprintf(
		/* translators: %s - 6-digit OTP code */
		__( 'Your one-time code is: %s - valid for 30 minutes.', 'restwell-retreats' ),
		$code
	);

	// Split code into individual digits for large display.
	$digits      = str_split( $code );
	$digits_html = '';
	foreach ( $digits as $digit ) {
		$digits_html .= '<td style="padding:0 4px;">
      <span style="display:inline-block;width:42px;height:52px;line-height:52px;text-align:center;font-family:\'Courier New\',Courier,monospace;font-size:28px;font-weight:bold;color:#1B4D5C;background-color:#F5EDE0;border:2px solid #D4A853;border-radius:4px;">' . esc_html( $digit ) . '</span>
    </td>';
	}

	$content = restwell_email_banner( 'Access code', 'Your one-time login code.' )
		. '<p style="margin:0 0 24px 0;font-family:\'Lora\',Georgia,serif;font-size:16px;color:#1B4D5C;line-height:1.7;">
    Here is your one-time access code for the ' . esc_html( $site ) . ' Guest Arrival Guide:
  </p>
  <!-- Code digits -->
  <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" style="margin:0 auto 24px auto;">
    <tr>' . $digits_html . '</tr>
  </table>
  <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-bottom:24px;">
    <tr>
      <td style="background-color:#FEF3C7;border-radius:3px;padding:12px 16px;text-align:center;">
        <p style="margin:0;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:13px;color:#92400E;">
          ⏱ This code is valid for <strong>30 minutes</strong>. Do not share it with anyone.
        </p>
      </td>
    </tr>
  </table>
  <p style="margin:0 0 8px 0;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:13px;color:#3A5A63;line-height:1.7;">
    If you didn\'t request this code, please disregard this email - your account has not been accessed.
  </p>
  <p style="margin:0;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:13px;color:#3A5A63;line-height:1.7;">
    Need help? Call us on <strong style="color:#1B4D5C;">' . esc_html( (string) get_option( 'restwell_phone_number', '01622 809881' ) ) . '</strong>.
  </p>'
		. restwell_email_signoff();

	return array(
		'subject' => $subject,
		'body'    => restwell_email_wrap( $content, $preview ),
		'headers' => array( 'Content-Type: text/html; charset=UTF-8' ),
	);
}

// ---------------------------------------------------------------------------
// 4. Booking confirmation
// ---------------------------------------------------------------------------

/**
 * Build the booking confirmation email sent to a guest when their status
 * first transitions to "Booked" in the CRM.
 *
 * @param string $name  Guest's display name.
 * @param string $email Guest's email address.
 * @return array{ subject: string, body: string, headers: string[] }
 */
function restwell_email_booking_confirmed( string $name, string $email ): array {
	$site       = wp_strip_all_tags( (string) get_bloginfo( 'name' ) );
	$first_name = $name ? explode( ' ', trim( $name ) )[0] : 'there';
	$enquire    = esc_url( home_url( '/enquire/' ) );
	$subject    = $site . ' | ' . __( 'Your booking is confirmed', 'restwell-retreats' );
	$preview    = __( 'Great news - your stay at Restwell Retreats is confirmed. We look forward to welcoming you.', 'restwell-retreats' );

	$next_steps = array(
		__( 'What to bring', 'restwell-retreats' )       => __( 'Any medications, mobility equipment you use regularly, and anything personal that helps you feel settled. Linen, towels, and kitchen basics are provided.', 'restwell-retreats' ),
		__( 'Arrival', 'restwell-retreats' )             => __( 'Check-in is from 2 pm. If you need an earlier or later time - for example, to allow time for equipment setup - let us know and we will do our best to accommodate.', 'restwell-retreats' ),
		__( 'Your arrival guide', 'restwell-retreats' )  => __( 'We\'ll send your personalised arrival guide by email closer to your stay date. It contains everything you need - directions, house notes, and local information.', 'restwell-retreats' ),
	);

	$content = restwell_email_banner( 'Booking confirmed', 'We\'re looking forward to welcoming you.' )
		. '<p style="margin:0 0 20px 0;font-family:\'Lora\',Georgia,serif;font-size:16px;color:#1B4D5C;line-height:1.7;">
    Dear ' . esc_html( $first_name ) . ',<br><br>
    Your booking at ' . esc_html( $site ) . ' is confirmed. We are looking forward to welcoming you.
  </p>'
		. restwell_email_info_table( $next_steps )
		. '<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin:24px 0 0 0;">
    <tr>
      <td style="background-color:#F5EDE0;border-radius:3px;padding:18px 20px;text-align:center;">
        <p style="margin:0 0 4px 0;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:11px;letter-spacing:0.12em;text-transform:uppercase;color:#3A5A63;">Questions before your stay?</p>
        <p style="margin:0;font-family:\'Lora\',Georgia,serif;font-size:20px;color:#1B4D5C;">' . esc_html( (string) get_option( 'restwell_phone_number', '01622 809881' ) ) . '</p>
        <p style="margin:4px 0 0 0;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:12px;color:#3A5A63;">Or reply to this email - we\'re always happy to help.</p>
      </td>
    </tr>
  </table>'
		. restwell_email_signoff();

	$headers = array(
		'Content-Type: text/html; charset=UTF-8',
		'Reply-To: hello@restwellretreats.co.uk',
	);

	return array(
		'subject' => $subject,
		'body'    => restwell_email_wrap( $content, $preview ),
		'headers' => $headers,
	);
}

// ---------------------------------------------------------------------------
// 5. Post-stay thank you
// ---------------------------------------------------------------------------

/**
 * Build the post-stay "thank you for staying" email.
 *
 * This function returns the compiled email array. Call it after a guest's
 * departure date - you can hook it to a cron job or trigger it manually
 * from the Guest Guide admin once departure tracking is in place.
 *
 * @param string $email      Guest's email address.
 * @param string $name       Guest's display name.
 * @param string $stay_dates Optional human-readable stay dates (e.g. "14-17 April 2025").
 * @return array{ subject: string, body: string, headers: string[] }
 */
function restwell_email_post_stay( string $email, string $name, string $stay_dates = '' ): array {
	$site       = wp_strip_all_tags( (string) get_bloginfo( 'name' ) );
	$enquire    = esc_url( home_url( '/enquire/' ) );
	$google_url = 'https://g.page/r/CcRcJZcgLeuSEBM/review';
	$facebook_url = 'https://www.facebook.com/restwellretreats/reviews';
	$first_name = $name ? explode( ' ', trim( $name ) )[0] : 'there';
	$subject    = $site . ' | ' . __( 'Thank you for staying with us', 'restwell-retreats' );
	$preview    = __( 'It was a pleasure having you. We hope you felt truly at home.', 'restwell-retreats' );

	$dates_row = $stay_dates
		? restwell_email_info_table( array( __( 'Stay', 'restwell-retreats' ) => esc_html( $stay_dates ) ) )
		: '';

	$content = restwell_email_banner( 'Until next time', 'It was a pleasure having you.' )
		. '<p style="margin:0 0 20px 0;font-family:\'Lora\',Georgia,serif;font-size:16px;color:#1B4D5C;line-height:1.7;">
    Dear ' . esc_html( $first_name ) . ',<br><br>
    We hope you are settling back in. It was our pleasure to have you, and we hope the stay gave you and your family the break you needed.
  </p>'
		. $dates_row
		. '
  <p style="margin:0 0 16px 0;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:14px;color:#2d4a52;line-height:1.7;">
    Should you wish to visit us again - for yourself or someone close to you - we\'d love to welcome you back. You\'re always welcome here.
  </p>
  <p style="margin:0 0 8px 0;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:13px;color:#3A5A63;line-height:1.7;">
    If you are happy to share your experience - even a sentence or two - it helps other families decide whether Restwell is right for them:
  </p>
  <p style="margin:0 0 8px 0;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:13px;color:#3A5A63;line-height:1.7;">
    &bull; <a href="' . esc_url( $google_url ) . '" target="_blank" style="color:#1B4D5C;">Leave a Google review</a><br>
    &bull; <a href="' . esc_url( $facebook_url ) . '" target="_blank" style="color:#1B4D5C;">Review us on Facebook</a><br>
    &bull; Reply to this email with your thoughts, or ask us for a short form.
  </p>'
		. restwell_email_button( $enquire, __( 'Enquire About a Return Stay', 'restwell-retreats' ), '#D4A853' )
		. '<p style="margin:28px 0 0 0;font-family:\'Inter\',system-ui,Arial,sans-serif;font-size:13px;color:#3A5A63;line-height:1.7;border-top:1px solid #E8DFD0;padding-top:20px;">
    If there is anything we could do better, please reply to this email. Honest feedback helps us improve for every guest who follows.
  </p>'
		. restwell_email_signoff();

	return array(
		'subject' => $subject,
		'body'    => restwell_email_wrap( $content, $preview ),
		'headers' => array( 'Content-Type: text/html; charset=UTF-8' ),
	);
}

/**
 * Convenience wrapper - send the post-stay thank you directly via wp_mail().
 *
 * @param string $email      Guest's email address.
 * @param string $name       Guest's display name.
 * @param string $stay_dates Optional human-readable stay dates.
 * @return bool Whether wp_mail() reported success.
 */
function restwell_send_post_stay_email( string $email, string $name, string $stay_dates = '' ): bool {
	$mail = restwell_email_post_stay( $email, $name, $stay_dates );
	return (bool) wp_mail( $email, $mail['subject'], $mail['body'], $mail['headers'] );
}
