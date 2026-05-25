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
 * DNS (outside WordPress): add SPF, DKIM, and DMARC for the From domain so messages
 * reach inboxes. Use your host or transactional provider’s documentation.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
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

	if ( defined( 'RESTWELL_SMTP_FROM' ) && is_email( RESTWELL_SMTP_FROM ) ) {
		$name = defined( 'RESTWELL_SMTP_FROM_NAME' ) ? (string) RESTWELL_SMTP_FROM_NAME : '';
		$phpmailer->setFrom( (string) RESTWELL_SMTP_FROM, $name, false );
	}
}
add_action( 'phpmailer_init', 'restwell_phpmailer_smtp_init' );
