<?php
/**
 * Staff notification email templates, and the plain-text alternative for all HTML mail.
 *
 * Staff notifications previously went out as ad-hoc plain text built with bare
 * "\n" and box-drawing rules, which quoted-printable mangled into "=0A" and
 * "=E2=80=94" escapes in the inbox. They now use the same shell as guest mail
 * (see emails.php) in a denser, scan-first layout: details table up top, a
 * prominent CRM button, and no warm sign-off.
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
		? '<div style="display:none;max-height:0;overflow:hidden;mso-hide:all;font-size:1px;color:#FFFFFF;line-height:1px;">' . esc_html( $preview ) . '</div>'
		: '';

	return '<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="x-apple-disable-message-reformatting">
<title>' . esc_html( $site ) . '</title>
</head>
<body style="margin:0;padding:0;background-color:#F4F4F2;-webkit-text-size-adjust:100%;">
' . $pre_header . '
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color:#F4F4F2;">
<tr><td style="padding:24px 12px;">

  <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="560" align="center" style="max-width:560px;width:100%;background-color:#FFFFFF;border:1px solid #E2E2DE;">
    <tr>
      <td style="padding:28px 28px 32px 28px;font-family:Arial,Helvetica,sans-serif;">
' . $content . '
      </td>
    </tr>
    <tr>
      <td style="padding:14px 28px 18px 28px;border-top:1px solid #E2E2DE;font-family:Arial,Helvetica,sans-serif;font-size:11px;color:#767676;">
        ' . esc_html( $site ) . ' &nbsp;&middot;&nbsp; hello@restwellretreats.co.uk &nbsp;&middot;&nbsp; ' . $phone . '
      </td>
    </tr>
  </table>

</td></tr>
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
<h1 style="margin:0 0 18px 0;font-family:Arial,Helvetica,sans-serif;font-size:20px;font-weight:bold;color:#1B4D5C;line-height:1.35;">' . esc_html( $heading ) . '</h1>';
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

	$html = '<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin:0 0 4px 0;font-family:Arial,Helvetica,sans-serif;">';
	foreach ( $rows as $label => $value ) {
		$html .= '<tr>
      <td width="30%" style="padding:7px 0;border-bottom:1px solid #EFEFED;font-size:13px;color:#767676;vertical-align:top;">' . esc_html( $label ) . '</td>
      <td width="70%" style="padding:7px 0;border-bottom:1px solid #EFEFED;font-size:13px;color:#222222;vertical-align:top;">' . esc_html( $value ) . '</td>
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

	return '<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin:6px 0 0 0;">
  <tr>
    <td style="border-left:2px solid #D9D9D5;padding:2px 0 2px 14px;font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#222222;line-height:1.6;white-space:pre-wrap;">' . esc_html( $text ) . '</td>
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
 *     quote_label?:string, button_url?:string, button_label?:string,
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

	if ( '' !== trim( (string) $args['quote'] ) ) {
		$html .= '<p style="margin:20px 0 6px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:bold;color:#767676;">' . esc_html( (string) $args['quote_label'] ) . '</p>';
		$html .= restwell_email_staff_quote( (string) $args['quote'] );
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
	if ( empty( $phpmailer->ContentType ) || false === stripos( (string) $phpmailer->ContentType, 'text/html' ) ) {
		return;
	}
	if ( ! empty( $phpmailer->AltBody ) ) {
		return;
	}

	$text = restwell_email_html_to_text( (string) $phpmailer->Body );
	if ( '' !== $text ) {
		$phpmailer->AltBody = $text;
	}
	// phpcs:enable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
}
add_action( 'phpmailer_init', 'restwell_email_attach_plain_text_alternative', 20 );
