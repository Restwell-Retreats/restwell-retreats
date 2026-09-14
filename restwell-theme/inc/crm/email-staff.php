<?php
/**
 * Staff notification email templates, and the plain-text alternative for all HTML mail.
 *
 * Staff notifications previously went out as ad-hoc plain text built with bare
 * "\n" and box-drawing rules, which quoted-printable mangled into "=0A" and
 * "=E2=80=94" escapes in the inbox. They now use a denser Outlook-safe table
 * layout (Arial, MSO ghost table, no webfonts): details table up top, a CRM
 * link, and no warm sign-off. Guest marketing mail stays in emails.php.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plain shell for staff notifications.
 *
 * Deliberately minimal: these are read fast, on a phone, to decide whether to
 * pick something up. One accent colour, one typeface, no rules or ornament.
 *
 * @param string $content Inner HTML.
 * @param string $preview Preheader text.
 * @return string Full HTML email document.
 */
function restwell_email_guide_wrap( string $content, string $preview = '' ): string {
	$site  = wp_strip_all_tags( (string) get_bloginfo( 'name' ) );
	$phone = esc_html( (string) get_option( 'restwell_phone_number', '01622 809881' ) );

	$pre_header = '' !== $preview
		? '<div style="display:none;max-height:0;overflow:hidden;mso-hide:all;font-size:1px;line-height:1px;color:#F4F4F2;">' . esc_html( $preview ) . '</div>'
		: '';

	$table_reset = function_exists( 'restwell_email_table_reset_style' )
		? restwell_email_table_reset_style()
		: 'border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt;';
	$mso_head    = function_exists( 'restwell_email_mso_head_styles' )
		? restwell_email_mso_head_styles( false )
		: '<!--[if mso]><noscript><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml></noscript><![endif]-->';
	$mso_open    = function_exists( 'restwell_email_mso_width_open' )
		? restwell_email_mso_width_open( 560 )
		: '';
	$mso_close   = function_exists( 'restwell_email_mso_width_close' )
		? restwell_email_mso_width_close()
		: '';

	return '<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="x-apple-disable-message-reformatting">
<title>' . esc_html( $site ) . '</title>
' . $mso_head . '
</head>
<body style="margin:0;padding:0;background-color:#F4F4F2;font-family:Arial,Helvetica,sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;">
' . $pre_header . '
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" bgcolor="#F4F4F2" style="background-color:#F4F4F2;' . $table_reset . '">
<tr>
<td align="center" style="padding:24px 12px;">
' . $mso_open . '
  <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" align="center" bgcolor="#FFFFFF" style="max-width:560px;width:100%;background-color:#FFFFFF;border:1px solid #E2E2DE;' . $table_reset . '">
    <tr>
      <td style="padding:28px 28px 32px 28px;font-family:Arial,Helvetica,sans-serif;">
' . $content . '
      </td>
    </tr>
    <tr>
      <td style="padding:14px 28px 18px 28px;border-top:1px solid #E2E2DE;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#767676;">
        ' . esc_html( $site ) . ' &nbsp;&middot;&nbsp; hello@restwellretreats.co.uk &nbsp;&middot;&nbsp; ' . $phone . '
      </td>
    </tr>
  </table>
' . $mso_close . '
</td>
</tr>
</table>
</body>
</html>';
}

/**
 * Heading block: a small label and a plain bold heading.
 *
 * @param string $label   Small label above the heading.
 * @param string $heading Heading text.
 * @param bool   $urgent  Whether to mark the label as urgent.
 * @return string HTML snippet.
 */
function restwell_email_staff_banner( string $label, string $heading, bool $urgent = false ): string {
	$label_color = $urgent ? '#B42318' : '#767676';

	return '<p style="margin:0 0 4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:bold;color:' . esc_attr( $label_color ) . ';">' . esc_html( $label ) . '</p>
<h1 style="margin:0 0 18px 0;font-family:Arial,Helvetica,sans-serif;font-size:20px;font-weight:bold;color:#1B4D5C;line-height:1.4;mso-line-height-rule:exactly;">' . esc_html( $heading ) . '</h1>';
}

/**
 * Detail rows: plain label and value, one per line, hairline separated.
 *
 * @param array<string,string> $rows    Label => value pairs.
 * @param string               $caption Unused; kept so callers stay stable.
 * @return string HTML snippet.
 */
function restwell_email_guide_table( array $rows, string $caption = '' ): string {
	unset( $caption );
	if ( empty( $rows ) ) {
		return '';
	}

	$html = '<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin:0 0 4px 0;border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt;font-family:Arial,Helvetica,sans-serif;">';
	foreach ( $rows as $label => $value ) {
		$html .= '<tr>
      <td width="30%" valign="top" style="padding:8px 0;border-bottom:1px solid #EFEFED;font-size:14px;color:#767676;font-family:Arial,Helvetica,sans-serif;">' . esc_html( $label ) . '</td>
      <td width="70%" valign="top" style="padding:8px 0;border-bottom:1px solid #EFEFED;font-size:14px;color:#222222;font-family:Arial,Helvetica,sans-serif;">' . esc_html( $value ) . '</td>
    </tr>';
	}
	$html .= '</table>';

	return $html;
}

/**
 * The guest's own words, set apart by a hairline rule.
 *
 * @param string $text Plain-text message from the guest.
 * @return string HTML snippet.
 */
function restwell_email_staff_quote( string $text ): string {
	$text = trim( wp_strip_all_tags( $text ) );
	if ( '' === $text ) {
		return '';
	}

	return '<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin:6px 0 0 0;border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt;">
  <tr>
    <td style="border-left:2px solid #D9D9D5;padding:4px 0 4px 14px;font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#222222;line-height:1.6;mso-line-height-rule:exactly;">' . nl2br( esc_html( $text ), false ) . '</td>
  </tr>
</table>';
}

/**
 * Small grey footnote.
 *
 * @param string $text Footnote text.
 * @return string HTML snippet.
 */
function restwell_email_staff_note( string $text ): string {
	if ( '' === trim( $text ) ) {
		return '';
	}

	return '<p style="margin:24px 0 0 0;font-family:Arial,Helvetica,sans-serif;font-size:11px;color:#767676;line-height:1.6;">' . esc_html( $text ) . '</p>';
}

/**
 * Plain text link, used instead of a button.
 *
 * @param string $url   Destination.
 * @param string $label Link text.
 * @return string HTML snippet.
 */
function restwell_email_staff_link( string $url, string $label ): string {
	return '<p style="margin:20px 0 0 0;font-family:Arial,Helvetica,sans-serif;font-size:14px;">
  <a href="' . esc_url( $url ) . '" style="color:#1B4D5C;font-weight:bold;">' . esc_html( $label ) . '</a>
</p>';
}

/**
 * Compose a staff notification body.
 *
 * @param array{
 *     label?:string, heading?:string, urgent?:bool, intro?:string,
 *     rows?:array<string,string>, rows_caption?:string, quote?:string,
 *     quote_label?:string, sections?:array<int,array{label?:string,text?:string}>,
 *     button_url?:string, button_label?:string,
 *     note?:string, preview?:string
 * } $args Section content.
 * @return string Full HTML email document.
 */
function restwell_email_staff_body( array $args ): string {
	$args = wp_parse_args(
		$args,
		array(
			'label'        => __( 'Restwell CRM', 'restwell-retreats' ),
			'heading'      => '',
			'urgent'       => false,
			'intro'        => '',
			'rows'         => array(),
			'rows_caption' => '',
			'quote'        => '',
			'quote_label'  => __( 'Their message', 'restwell-retreats' ),
			'sections'     => array(),
			'button_url'   => '',
			'button_label' => __( 'Open in CRM', 'restwell-retreats' ),
			'note'         => '',
			'preview'      => '',
		)
	);

	$html = restwell_email_staff_banner( (string) $args['label'], (string) $args['heading'], (bool) $args['urgent'] );

	if ( '' !== (string) $args['intro'] ) {
		$html .= '<p style="margin:0 0 16px 0;font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#222222;line-height:1.6;">' . esc_html( (string) $args['intro'] ) . '</p>';
	}

	if ( ! empty( $args['rows'] ) ) {
		$html .= restwell_email_guide_table( (array) $args['rows'] );
	}

	$sections = is_array( $args['sections'] ) ? $args['sections'] : array();
	if ( '' !== trim( (string) $args['quote'] ) ) {
		$sections[] = array(
			'label' => (string) $args['quote_label'],
			'text'  => (string) $args['quote'],
		);
	}
	foreach ( $sections as $section ) {
		if ( ! is_array( $section ) ) {
			continue;
		}
		$text = isset( $section['text'] ) ? trim( (string) $section['text'] ) : '';
		if ( '' === $text ) {
			continue;
		}
		$label = isset( $section['label'] ) ? (string) $section['label'] : '';
		if ( '' !== $label ) {
			$html .= '<p style="margin:20px 0 6px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:bold;color:#767676;">' . esc_html( $label ) . '</p>';
		}
		$html .= restwell_email_staff_quote( $text );
	}

	if ( '' !== (string) $args['button_url'] ) {
		$html .= restwell_email_staff_link( (string) $args['button_url'], (string) $args['button_label'] );
	}

	$html .= restwell_email_staff_note( (string) $args['note'] );

	return restwell_email_guide_wrap( $html, (string) $args['preview'] );
}

/**
 * Standard headers for a staff HTML notification.
 *
 * @param string $reply_to Optional address to set as Reply-To.
 * @return string[]
 */
function restwell_email_staff_headers( string $reply_to = '' ): array {
	$headers = array( 'Content-Type: text/html; charset=UTF-8' );
	if ( '' !== $reply_to && function_exists( 'restwell_mail_reply_to_header' ) ) {
		$reply_header = restwell_mail_reply_to_header( $reply_to );
		if ( '' !== $reply_header ) {
			$headers[] = $reply_header;
		}
	}
	return $headers;
}

// ---------------------------------------------------------------------------
// Plain-text alternative for every HTML email
// ---------------------------------------------------------------------------

/**
 * Convert one of our HTML email bodies to a readable plain-text equivalent.
 *
 * Not a general-purpose converter: it handles the constructs our templates use
 * (tables of label/value pairs, buttons, paragraphs, quoted blocks).
 *
 * @param string $html Full HTML email document.
 * @return string Plain-text rendering.
 */
function restwell_email_html_to_text( string $html ): string {
	// Drop everything that never carries visible copy.
	$text = (string) preg_replace( '#<(head|style|script|title)\b[^>]*>.*?</\1>#is', '', $html );
	// The hidden pre-header duplicates the subject line; it is noise in plain text.
	$text = (string) preg_replace( '#<div style="display:none[^"]*"[^>]*>.*?</div>#is', '', $text );
	$text = (string) preg_replace( '#<!--.*?-->#s', '', $text );

	// Keep the destination of links rather than losing them to tag-stripping.
	$text = (string) preg_replace_callback(
		'#<a\b[^>]*href=["\']([^"\']+)["\'][^>]*>(.*?)</a>#is',
		static function ( array $m ): string {
			$label = trim( wp_strip_all_tags( $m[2] ) );
			$url   = trim( $m[1] );
			if ( '' === $label || $label === $url ) {
				return $url;
			}
			return $label . ' (' . $url . ')';
		},
		$text
	);

	// Block-level boundaries become line breaks; table cells become separators.
	$text = str_ireplace( array( '<br>', '<br/>', '<br />' ), "\n", $text );
	$text = (string) preg_replace( '#</(p|h1|h2|h3|tr|div)>#i', "\n", $text );
	$text = (string) preg_replace( '#</td>\s*<td[^>]*>#i', ': ', $text );

	$text = wp_strip_all_tags( $text );
	$text = html_entity_decode( $text, ENT_QUOTES | ENT_HTML5, 'UTF-8' );
	$text = str_replace( "\xc2\xa0", ' ', $text );

	// Tidy: trim each line, collapse runs of blank lines.
	$split = preg_split( '/\R/', $text );
	$lines = array_map( 'trim', is_array( $split ) ? $split : array() );
	$out   = array();
	foreach ( $lines as $line ) {
		if ( '' === $line && ( empty( $out ) || '' === end( $out ) ) ) {
			continue;
		}
		$out[] = $line;
	}

	return trim( implode( "\n", $out ) );
}

/**
 * Give every HTML message a plain-text alternative.
 *
 * Improves deliverability and gives plain-text and screen-reader clients
 * something readable instead of raw markup.
 *
 * @param PHPMailer\PHPMailer\PHPMailer $phpmailer Mailer instance, by reference.
 * @return void
 */
function restwell_email_attach_plain_text_alternative( $phpmailer ): void {
	// phpcs:disable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase -- PHPMailer's public API is PascalCase.
	if ( ! is_object( $phpmailer ) ) {
		return;
	}

	$body    = isset( $phpmailer->Body ) ? (string) $phpmailer->Body : '';
	$type    = isset( $phpmailer->ContentType ) ? (string) $phpmailer->ContentType : '';
	$is_html = ( '' !== $type && false !== stripos( $type, 'text/html' ) )
		|| ( function_exists( 'restwell_mail_message_is_html' ) && restwell_mail_message_is_html( $body ) );
	if ( ! $is_html ) {
		return;
	}

	// Defence: some hosts drop the Content-Type header. Mark MIME here so
	// Outlook does not render the HTML document as plain-text source.
	if ( function_exists( 'restwell_phpmailer_apply_html_mime' ) ) {
		restwell_phpmailer_apply_html_mime( $phpmailer );
	} elseif ( method_exists( $phpmailer, 'isHTML' ) ) {
		$phpmailer->isHTML( true );
	}

	if ( ! empty( $phpmailer->AltBody ) ) {
		return;
	}

	$text = restwell_email_html_to_text( $body );
	if ( '' !== $text ) {
		$phpmailer->AltBody = $text;
	}
	// phpcs:enable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
}
add_action( 'phpmailer_init', 'restwell_email_attach_plain_text_alternative', 20 );
