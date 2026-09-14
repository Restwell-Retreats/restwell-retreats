<?php
/**
 * Template Name: FAQ
 *
 * Concept port from mockups — FAQ.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$restwell_faq_id      = (int) get_queried_object_id();
$restwell_faq_heading = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $restwell_faq_id, 'faq_heading', 'Questions people ask before they book' )
	: 'Questions people ask before they book';
$restwell_faq_intro   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text(
		$restwell_faq_id,
		'faq_intro',
		'Short answers to what people ask before booking: what Restwell is, whether it fits, and what it costs.'
	)
	: 'Short answers to what people ask before booking: what Restwell is, whether it fits, and what it costs.';
?>


<main id="main-content">
<?php
get_template_part(
	'template-parts/concept/photo-hero',
	null,
	array(
		'heading_id' => 'page-h',
		'heading'    => $restwell_faq_heading,
		'intro'      => $restwell_faq_intro,
		'crumbs'     => array(
			array(
				'label' => __( 'Home', 'restwell-retreats' ),
				'url'   => home_url( '/' ),
			),
			array(
				'label' => 'FAQ',
				'url'   => '',
			),
		),
		'post_id'    => (int) get_queried_object_id(),
	)
);
?>

	<section class="faq section-y band-white" aria-labelledby="faq-list-h">
	  <div class="container faq-page">
		<header class="faq-page__head section-head section-head--center section-head--tight">
		  <p class="eyebrow"><?php esc_html_e( 'Browse by topic', 'restwell-retreats' ); ?></p>
		  <h2 id="faq-list-h"><?php esc_html_e( 'Frequently asked questions', 'restwell-retreats' ); ?></h2>
		</header>
		<div class="pill-tabs" data-faq-filters role="group" aria-label="<?php esc_attr_e( 'Filter questions by category', 'restwell-retreats' ); ?>">
		  <button type="button" data-filter="all" class="is-active" aria-pressed="true">All</button>
		  <button type="button" data-filter="about" aria-pressed="false">The house</button>
		  <button type="button" data-filter="booking" aria-pressed="false">Booking</button>
		  <button type="button" data-filter="care" aria-pressed="false">Care</button>
		  <button type="button" data-filter="local" aria-pressed="false">Local</button>
		  <button type="button" data-filter="funding" aria-pressed="false">Funding</button>
		</div>
		<div class="faq-page__layout">
		  <?php
			$faq_page_items = function_exists( 'restwell_get_faq_items' ) ? restwell_get_faq_items( 'faq-page' ) : array();
			$faq_page_col   = array();
			foreach ( $faq_page_items as $faq_page_i => $faq_page_item ) {
				$faq_page_answer = (string) ( $faq_page_item['a'] ?? '' );
				if ( $faq_page_answer !== '' && false === stripos( $faq_page_answer, '<p' ) ) {
					$faq_page_item['a'] = '<p>' . $faq_page_answer . '</p>';
				}
				$faq_page_item['open'] = ( 0 === (int) $faq_page_i );
				$faq_page_col[]       = $faq_page_item;
			}
			get_template_part(
				'template-parts/faq-accordion',
				null,
				array(
					'id_prefix'  => 'faq-q',
					'columns'    => array( $faq_page_col ),
					'list_class' => 'faq-list--page',
				)
			);
			?>
		  <aside class="faq-page__aside" aria-labelledby="faq-ask-h">
			<div class="faq-ask">
			  <header class="section-head section-head--tight">
				<p class="eyebrow">Can’t find your answer?</p>
				<h2 id="faq-ask-h">Ask us directly</h2>
				<p>We reply within 48 hours on most questions. Prefer to talk? Call 01622 809881.</p>
			  </header>
			  <?php
				$faq_flash  = function_exists( 'restwell_faq_consume_flash' ) ? restwell_faq_consume_flash() : null;
				$faq_errors = ( $faq_flash && ! empty( $faq_flash['errors'] ) ) ? $faq_flash['errors'] : array();
				$faq_fields = ( $faq_flash && ! empty( $faq_flash['fields'] ) ) ? $faq_flash['fields'] : array();
				$faq_val    = static function ( string $key, array $fields, string $default = '' ): string {
					if ( ! array_key_exists( $key, $fields ) ) {
						return $default;
					}
					return (string) $fields[ $key ];
				};
				// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- public PRG success flag.
				$faq_sent = isset( $_GET['question_sent'] ) && '1' === (string) wp_unslash( $_GET['question_sent'] );
				?>
			  <?php if ( $faq_sent ) : ?>
			  <p class="lede" role="status"><?php esc_html_e( 'We’ve got your question. We’ll reply within 48 hours on most questions.', 'restwell-retreats' ); ?></p>
			  <?php elseif ( $faq_errors ) : ?>
			  <div class="form-errors" role="alert" tabindex="-1">
				<p><strong><?php esc_html_e( 'Please check the form and try again.', 'restwell-retreats' ); ?></strong></p>
				<ul>
					<?php foreach ( $faq_errors as $faq_error ) : ?>
					<li><?php echo esc_html( $faq_error ); ?></li>
					<?php endforeach; ?>
				</ul>
			  </div>
			  <?php endif; ?>
			  <form class="form-stack restwell-faq-question-form" id="faq-question-form" action="<?php echo esc_url( get_permalink() ? get_permalink() : home_url( '/faq/' ) ); ?>" method="post">
				<?php wp_nonce_field( 'restwell_faq_question', 'restwell_faq_question_nonce' ); ?>
				<input type="hidden" name="restwell_faq_question" value="1" />
				<input type="hidden" name="restwell_faq_page_id" value="<?php echo esc_attr( (string) get_the_ID() ); ?>" />
				<input type="hidden" name="restwell_form_opened_at" value="" data-restwell-form-opened />
				<div class="field" hidden aria-hidden="true">
				  <label for="faq_q_website">Website</label>
				  <input type="text" id="faq_q_website" name="faq_q_website" tabindex="-1" autocomplete="off" />
				</div>
				<div class="field"><label for="ask-name"><?php esc_html_e( 'Name', 'restwell-retreats' ); ?></label><input id="ask-name" name="faq_q_name" autocomplete="name" required aria-describedby="ask-name-error" value="<?php echo esc_attr( $faq_val( 'name', $faq_fields ) ); ?>" /><p class="field-error" id="ask-name-error" role="alert" hidden><?php esc_html_e( 'Enter your name.', 'restwell-retreats' ); ?></p></div>
				<div class="field"><label for="ask-email"><?php esc_html_e( 'Email', 'restwell-retreats' ); ?></label><input id="ask-email" name="faq_q_email" type="email" autocomplete="email" required aria-describedby="ask-email-error" value="<?php echo esc_attr( $faq_val( 'email', $faq_fields ) ); ?>" /><p class="field-error" id="ask-email-error" role="alert" hidden><?php esc_html_e( 'Enter a valid email address.', 'restwell-retreats' ); ?></p></div>
				<div class="field"><label for="ask-phone"><?php esc_html_e( 'Phone', 'restwell-retreats' ); ?></label><input id="ask-phone" name="faq_q_phone" type="tel" autocomplete="tel" required aria-describedby="ask-phone-error" value="<?php echo esc_attr( $faq_val( 'phone', $faq_fields ) ); ?>" /><p class="field-error" id="ask-phone-error" role="alert" hidden><?php esc_html_e( 'Enter your phone number.', 'restwell-retreats' ); ?></p></div>
				<div class="field"><label for="ask-q"><?php esc_html_e( 'Your question', 'restwell-retreats' ); ?></label><textarea id="ask-q" name="faq_q_message" required rows="4" aria-describedby="ask-q-error"><?php echo esc_textarea( $faq_val( 'message', $faq_fields ) ); ?></textarea><p class="field-error" id="ask-q-error" role="alert" hidden><?php esc_html_e( 'Type your question.', 'restwell-retreats' ); ?></p></div>
				<div class="field"><label for="ask-consent"><input id="ask-consent" type="checkbox" name="faq_q_consent" value="1" required aria-describedby="ask-consent-error" <?php checked( $faq_val( 'consent', $faq_fields ), '1' ); ?> /> <span><?php esc_html_e( 'I agree Restwell can use this information to reply, as set out in the', 'restwell-retreats' ); ?> <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'privacy-policy' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'restwell-retreats' ); ?></a> *</span></label><p class="field-error" id="ask-consent-error" role="alert" hidden><?php esc_html_e( 'Please confirm we can use this information to reply.', 'restwell-retreats' ); ?></p></div>
				<div class="form-actions"><button class="btn btn-gold" type="submit"><?php esc_html_e( 'Send question', 'restwell-retreats' ); ?></button></div>
			  </form>
			</div>
		  </aside>
		</div>
	  </div>
	</section>

	<?php
	$faq_mid_cta_heading = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_faq_id, 'faq_cta_heading', __( 'Send dates and access needs', 'restwell-retreats' ) )
		: __( 'Send dates and access needs', 'restwell-retreats' );
	$faq_mid_cta_intro   = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text(
			$restwell_faq_id,
			'faq_cta_body',
			__( 'We reply within 48 hours on most enquiries; phone 01622 809881 if you need to talk it through.', 'restwell-retreats' )
		)
		: __( 'We reply within 48 hours on most enquiries; phone 01622 809881 if you need to talk it through.', 'restwell-retreats' );
	$faq_mid_cta_primary_label = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_faq_id, 'faq_cta_btn', __( 'Enquire', 'restwell-retreats' ) )
		: __( 'Enquire', 'restwell-retreats' );
	$faq_mid_cta_primary_url   = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_faq_id, 'faq_cta_url', restwell_nav_resolve_page_url( 'enquire' ) )
		: restwell_nav_resolve_page_url( 'enquire' );

	get_template_part(
		'template-parts/mid-cta',
		null,
		array(
			'heading'         => $faq_mid_cta_heading,
			'intro'           => $faq_mid_cta_intro,
			'primary_label'   => $faq_mid_cta_primary_label,
			'primary_url'     => $faq_mid_cta_primary_url,
			'secondary_label' => __( 'See access details', 'restwell-retreats' ),
			'secondary_url'   => restwell_nav_resolve_page_url( 'accessibility' ),
		)
	);
	?>

</main>

<?php
get_footer();
