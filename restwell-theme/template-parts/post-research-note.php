<?php
/**
 * Single post: "About this guide" note under the article (23 Oct 2026, owner's
 * request). Says the guide reflects our research on the date it was last
 * checked, that details may have changed or be wrong, and asks readers to
 * send corrections or additions.
 *
 * Expects $args: 'date' (display), 'datetime' (W3C), 'title' (post title).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$note_date     = isset( $args['date'] ) ? (string) $args['date'] : '';
$note_datetime = isset( $args['datetime'] ) ? (string) $args['datetime'] : '';
$note_title    = isset( $args['title'] ) ? (string) $args['title'] : '';
if ( '' === $note_date ) {
	return;
}

$note_email   = (string) get_option( 'restwell_public_email', 'hello@restwellretreats.co.uk' );
$note_subject = sprintf(
	/* translators: %s: guide title */
	__( 'About your guide: %s', 'restwell-retreats' ),
	$note_title
);
$note_mailto = 'mailto:' . $note_email . '?subject=' . rawurlencode( $note_subject );
?>
<aside class="post-summary post-note" aria-labelledby="post-note-h">
	<h2 class="post-summary__label" id="post-note-h"><?php esc_html_e( 'About this guide', 'restwell-retreats' ); ?></h2>
	<p>
		<?php esc_html_e( 'We wrote this guide from our own research and experience.', 'restwell-retreats' ); ?>
		<?php
		printf(
			/* translators: %s: date the guide was last checked, inside a <time> element */
			esc_html__( 'It was correct, as far as we knew, on %s.', 'restwell-retreats' ),
			'<time datetime="' . esc_attr( $note_datetime ) . '">' . esc_html( $note_date ) . '</time>'
		);
		?>
		<?php esc_html_e( 'Rules, prices and services change, so some details may now be out of date or simply wrong.', 'restwell-retreats' ); ?>
	</p>
	<p>
		<?php esc_html_e( 'If you spot a mistake, or know something we should add, please tell us. We’ll check it and update the guide.', 'restwell-retreats' ); ?>
		<a class="text-link" href="<?php echo esc_url( $note_mailto ); ?>"><?php esc_html_e( 'Email us a correction or an addition', 'restwell-retreats' ); ?></a>
	</p>
</aside>
