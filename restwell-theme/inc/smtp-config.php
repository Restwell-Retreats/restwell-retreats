<?php
/**
 * Optional transactional SMTP for wp_mail() (no plugin required).
 *
 * Define these in wp-config.php (or an environment loader) after WordPress sets ABSPATH:
 *
 *   define( 'RESTWELL_SMTP_HOST', 'smtp.example.com' );
 *   define( 'RESTWELL_SMTP_PORT', 587 );
 *   define( 'RESTWELL_SMTP_ENCRYPTION', 'tls' ); // tls | ssl | ''
 *   define( 'RESTWELL_SMTP_USER', 'user@example.com' );
 *   define( 'RESTWELL_SMTP_PASS', 'app-password' );
 *   define( 'RESTWELL_SMTP_FROM', 'hello@restwellretreats.co.uk' ); // optional
 *   define( 'RESTWELL_SMTP_FROM_NAME', 'Restwell Retreats' );       // optional
 *
 * Optional Mailchimp (preferred over the CRM settings fallback option):
 *
 *   define( 'RESTWELL_MAILCHIMP_API_KEY', 'your-key-usXX' );
 *   define( 'RESTWELL_MAILCHIMP_AUDIENCE_ID', 'audienceid' );       // optional
 *   define( 'RESTWELL_MAILCHIMP_SERVER_PREFIX', 'us15' );           // optional
 *
 * Optional Bing Webmaster REST API (JSON only — SOAP/POX retired 31 Aug 2026):
 *
 *   define( 'RESTWELL_BING_WEBMASTER_API_KEY', 'your-bing-api-key' );
 *
 * DNS (outside WordPress): add SPF, DKIM, and DMARC for the From domain so messages
 * reach inboxes. Use your host or transactional provider’s documentation.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Whether transactional SMTP constants are present.
 *
 * Does not prove delivery. Local WP-CLI / the CRM test button prove wp_mail().
 *
 * @return bool
 */
function restwell_smtp_is_configured(): bool {
	return defined( 'RESTWELL_SMTP_HOST' ) && is_string( RESTWELL_SMTP_HOST ) && RESTWELL_SMTP_HOST !== '';
}

/**
 * Configure PHPMailer when RESTWELL_SMTP_HOST is defined.
 *
 * @param \PHPMailer\PHPMailer\PHPMailer $phpmailer PHPMailer instance.
 */
function restwell_phpmailer_smtp_init( $phpmailer ) {
	if ( ! defined( 'RESTWELL_SMTP_HOST' ) || RESTWELL_SMTP_HOST === '' ) {
		return;
	}

	$phpmailer->isSMTP();
	// PHPMailer's public API is PascalCase; WPCS snake_case does not apply.
	// phpcs:disable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
	$phpmailer->Host = (string) RESTWELL_SMTP_HOST;
	$phpmailer->Port = defined( 'RESTWELL_SMTP_PORT' ) ? absint( RESTWELL_SMTP_PORT ) : 587;

	$enc = defined( 'RESTWELL_SMTP_ENCRYPTION' ) ? strtolower( (string) RESTWELL_SMTP_ENCRYPTION ) : 'tls';
	if ( 'ssl' === $enc ) {
		$phpmailer->SMTPSecure = 'ssl';
	} elseif ( 'tls' === $enc ) {
		$phpmailer->SMTPSecure = 'tls';
	} else {
		$phpmailer->SMTPSecure = '';
	}

	if ( defined( 'RESTWELL_SMTP_USER' ) && RESTWELL_SMTP_USER !== ''
		&& defined( 'RESTWELL_SMTP_PASS' ) ) {
		$phpmailer->SMTPAuth = true;
		$phpmailer->Username  = (string) RESTWELL_SMTP_USER;
		$phpmailer->Password  = (string) RESTWELL_SMTP_PASS;
	} else {
		$phpmailer->SMTPAuth = false;
	}
	// phpcs:enable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase

	if ( defined( 'RESTWELL_SMTP_FROM' ) && is_email( RESTWELL_SMTP_FROM ) ) {
		$name = defined( 'RESTWELL_SMTP_FROM_NAME' ) ? (string) RESTWELL_SMTP_FROM_NAME : '';
		$phpmailer->setFrom( (string) RESTWELL_SMTP_FROM, $name, false );
	}
}
add_action( 'phpmailer_init', 'restwell_phpmailer_smtp_init' );

/**
 * Normalise mail bodies to CRLF line endings.
 *
 * RFC 5322 requires CRLF. Our mail bodies are built with bare "\n", which
 * PHPMailer quoted-printable-encodes as a literal "=0A" rather than treating as
 * a line break; the MIME body then fails to decode and recipients see raw
 * "=0A" / "=E2=80=94" / "=E2=94=80" escapes instead of text. Guest mail is the
 * worst affected because it uses box-drawing rules and curly punctuation.
 *
 * Hooked on wp_mail rather than our send wrapper because several senders call
 * wp_mail() directly and would otherwise bypass the fix.
 *
 * @param array $args wp_mail() arguments.
 * @return array
 */
function restwell_mail_normalise_line_endings( $args ) {
	if ( isset( $args['message'] ) && is_string( $args['message'] ) ) {
		$message            = str_replace( array( "\r\n", "\r" ), "\n", $args['message'] );
		$args['message'] = str_replace( "\n", "\r\n", $message );
	}
	return $args;
}
add_filter( 'wp_mail', 'restwell_mail_normalise_line_endings', 5 );
