<?php
/**
 * Template Name: Enquire
 *
 * Concept port from mockups — Enquire.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$current_url = get_permalink() ? (string) get_permalink() : home_url( '/enquire/' );
// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- public PRG success flags.
$enq_success   = isset( $_GET['sent'] ) && '1' === (string) wp_unslash( $_GET['sent'] );
$enq_urgent    = $enq_success && isset( $_GET['urgent'] ) && '1' === (string) wp_unslash( $_GET['urgent'] );
$enq_mail_warn = $enq_success && isset( $_GET['mail_warn'] ) && '1' === (string) wp_unslash( $_GET['mail_warn'] );
$enq_duplicate = $enq_success && isset( $_GET['duplicate'] ) && '1' === (string) wp_unslash( $_GET['duplicate'] );

$enq_flash  = function_exists( 'restwell_enquire_consume_flash' ) ? restwell_enquire_consume_flash() : null;
$enq_errors = ( $enq_flash && ! empty( $enq_flash['errors'] ) ) ? $enq_flash['errors'] : array();
$enq_fields = ( $enq_flash && ! empty( $enq_flash['fields'] ) ) ? $enq_flash['fields'] : array();

/**
 * Repopulate a posted field after validation flash.
 *
 * @param string               $key     Field key in flash array.
 * @param array<string, mixed> $fields  Flash fields.
 * @param string               $default Default when absent.
 * @return string
 */
$enq_val = static function ( string $key, array $fields, string $default = '' ): string {
	if ( ! array_key_exists( $key, $fields ) ) {
		return $default;
	}
	return (string) $fields[ $key ];
};

$funding_selected = $enq_val( 'enq_funding', $enq_fields, 'self' );
$phone_number     = (string) get_option( 'restwell_phone_number', '01622 809881' );
$phone_tel        = preg_replace( '/\s+/', '', $phone_number );

$restwell_enq_id      = (int) get_queried_object_id();
$restwell_enq_heading = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $restwell_enq_id, 'enq_heading', 'Get in touch whenever you’re ready' )
	: 'Get in touch whenever you’re ready';
$restwell_enq_intro   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text(
		$restwell_enq_id,
		'enq_intro',
		'Send us your dates, who’s coming and anything you need from the house, and we’ll reply within 48 hours. There’s no deposit until you’ve decided the bungalow fits. You can also ring 01622 809881 or email hello@restwellretreats.co.uk instead of using the form.'
	)
	: 'Send us your dates, who’s coming and anything you need from the house, and we’ll reply within 48 hours. There’s no deposit until you’ve decided the bungalow fits. You can also ring 01622 809881 or email hello@restwellretreats.co.uk instead of using the form.';

$enq_success_heading_default = __( 'We’ve got your enquiry', 'restwell-retreats' );
$enq_success_body_default    = __( 'We’ve emailed you an acknowledgement. Next: a team member reviews your details and replies, usually within 48 hours. Call 01622 809881 if you’d rather talk it through.', 'restwell-retreats' );
$enq_urgent_body_default     = sprintf(
	/* translators: %s: phone number */
	__( 'We’ve flagged this for a priority callback and aim to contact you sooner than our usual 48-hour window. If you need to speak now, call %s.', 'restwell-retreats' ),
	$phone_number
);

$enq_success_heading = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $restwell_enq_id, 'enq_success_heading', $enq_success_heading_default )
	: $enq_success_heading_default;
$enq_success_body    = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $restwell_enq_id, 'enq_success_body', $enq_success_body_default )
	: $enq_success_body_default;
$enq_urgent_body     = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $restwell_enq_id, 'enq_success_urgent_body', $enq_urgent_body_default )
	: $enq_urgent_body_default;

// Saved Page content can still hold the old “working days” seed; guest copy is 48 hours.
if ( 0 === strcasecmp( trim( $enq_success_heading ), 'Thank you. We have your enquiry.' ) ) {
	$enq_success_heading = $enq_success_heading_default;
}
if ( false !== stripos( $enq_success_body, 'working days' ) ) {
	$enq_success_body = $enq_success_body_default;
}
if ( false !== stripos( $enq_urgent_body, 'working days' ) ) {
	$enq_urgent_body = $enq_urgent_body_default;
}
?>

<main id="main-content">
<?php
get_template_part(
	'template-parts/concept/photo-hero',
	null,
	array(
		'heading_id' => 'page-h',
		'heading'    => $restwell_enq_heading,
		'intro'      => $restwell_enq_intro,
		'crumbs'     => array(
			array(
				'label' => __( 'Home', 'restwell-retreats' ),
				'url'   => home_url( '/' ),
			),
			array(
				'label' => 'Enquire',
				'url'   => '',
			),
		),
		'post_id'    => $restwell_enq_id,
		'overlay'    => 'heavy',
	)
);
?>

<section class="section-y band-white" id="enquiry-result">
	<div class="container layout-sidebar">
		<div class="multistep" data-multistep>
			<?php if ( $enq_success ) : ?>
			<div class="step-success" tabindex="-1">
				<span class="icon-circle icon-circle--lg" aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false"><path d="M4.5 12.5l5 5L19.5 7" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
				<?php if ( $enq_duplicate ) : ?>
				<h2><?php esc_html_e( 'We already have your enquiry', 'restwell-retreats' ); ?></h2>
				<p class="lede"><?php esc_html_e( 'You submitted recently with this email, so we have not sent another acknowledgement. Our team is still working from your earlier message and will reply within 48 hours on most enquiries.', 'restwell-retreats' ); ?></p>
				<?php elseif ( $enq_urgent ) : ?>
				<h2><?php esc_html_e( 'We’ve got your urgent enquiry', 'restwell-retreats' ); ?></h2>
				<p class="lede"><?php echo esc_html( $enq_urgent_body ); ?></p>
				<?php else : ?>
				<h2><?php echo esc_html( $enq_success_heading ); ?></h2>
				<p class="lede"><?php echo esc_html( $enq_success_body ); ?></p>
				<?php endif; ?>
				<?php if ( $enq_mail_warn && ! $enq_duplicate ) : ?>
				<p class="lede" role="status"><?php esc_html_e( 'Our confirmation email may not have sent just now. Your enquiry is still saved. Please call us if you do not hear back within 48 hours.', 'restwell-retreats' ); ?></p>
				<?php endif; ?>
				<p><a class="btn btn-outline-teal" href="tel:<?php echo esc_attr( $phone_tel ); ?>"><?php echo esc_html( $phone_number ); ?></a></p>
			</div>
			<?php else : ?>
				<?php if ( $enq_errors ) : ?>
			<div class="form-errors" role="alert" tabindex="-1">
				<p><strong><?php esc_html_e( 'Please check the form and try again.', 'restwell-retreats' ); ?></strong></p>
				<ul>
					<?php foreach ( $enq_errors as $enq_error ) : ?>
					<li><?php echo esc_html( $enq_error ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php endif; ?>
			<ol class="step-indicator" data-step-indicator role="list" aria-label="<?php esc_attr_e( 'Enquiry form progress', 'restwell-retreats' ); ?>">
				<li class="step-indicator__item is-current" data-step-item="1" aria-current="step">
					<span class="step-indicator__marker" aria-hidden="true">
						<span class="step-indicator__num">1</span>
						<svg class="step-indicator__check" viewBox="0 0 24 24" focusable="false"><path d="M4.5 12.5l5 5L19.5 7" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</span>
					<span class="step-indicator__label"><?php esc_html_e( 'About you', 'restwell-retreats' ); ?></span>
				</li>
				<li class="step-indicator__connector" aria-hidden="true"></li>
				<li class="step-indicator__item" data-step-item="2">
					<span class="step-indicator__marker" aria-hidden="true">
						<span class="step-indicator__num">2</span>
						<svg class="step-indicator__check" viewBox="0 0 24 24" focusable="false"><path d="M4.5 12.5l5 5L19.5 7" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</span>
					<span class="step-indicator__label"><?php esc_html_e( 'Your stay', 'restwell-retreats' ); ?></span>
				</li>
				<li class="step-indicator__connector" aria-hidden="true"></li>
				<li class="step-indicator__item" data-step-item="3">
					<span class="step-indicator__marker" aria-hidden="true">
						<span class="step-indicator__num">3</span>
						<svg class="step-indicator__check" viewBox="0 0 24 24" focusable="false"><path d="M4.5 12.5l5 5L19.5 7" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</span>
					<span class="step-indicator__label"><?php esc_html_e( 'Your needs', 'restwell-retreats' ); ?></span>
				</li>
			</ol>
			<form class="form-stack restwell-enq-form" data-multistep-form data-live-submit="1" action="<?php echo esc_url( $current_url ); ?>" method="post" novalidate>
				<?php
				if ( defined( 'RESTWELL_ENQUIRE_NONCE_ACTION' ) && defined( 'RESTWELL_ENQUIRE_NONCE_NAME' ) ) {
					wp_nonce_field( RESTWELL_ENQUIRE_NONCE_ACTION, RESTWELL_ENQUIRE_NONCE_NAME );
				}
				?>
				<input type="hidden" name="restwell_enquire" value="1" />
				<input type="hidden" name="enq_redirect" value="<?php echo esc_url( $current_url ); ?>" />
				<input type="hidden" name="restwell_form_opened_at" value="" data-restwell-form-opened />
				<div class="field" hidden aria-hidden="true">
					<label for="enq_website">Website</label>
					<input type="text" id="enq_website" name="enq_website" tabindex="-1" autocomplete="off" />
				</div>
				<div class="form-step" data-step-panel="1">
					<fieldset class="form-stack">
						<legend class="form-legend"><?php esc_html_e( 'About you', 'restwell-retreats' ); ?></legend>
						<div class="form-grid form-grid--2">
							<div class="field"><label for="enq-name"><?php esc_html_e( 'Full name *', 'restwell-retreats' ); ?></label><input id="enq-name" name="enq_name" required autocomplete="name" aria-describedby="enq-name-error" value="<?php echo esc_attr( $enq_val( 'enq_name', $enq_fields ) ); ?>" /><p class="field-error" id="enq-name-error" role="alert" hidden><?php esc_html_e( 'Enter your full name.', 'restwell-retreats' ); ?></p></div>
							<div class="field"><label for="enq-email"><?php esc_html_e( 'Email *', 'restwell-retreats' ); ?></label><input id="enq-email" name="enq_email" type="email" required autocomplete="email" aria-describedby="enq-email-error" value="<?php echo esc_attr( $enq_val( 'enq_email', $enq_fields ) ); ?>" /><p class="field-error" id="enq-email-error" role="alert" hidden><?php esc_html_e( 'Enter a valid email address.', 'restwell-retreats' ); ?></p></div>
							<div class="field"><label for="enq-phone"><?php esc_html_e( 'Phone *', 'restwell-retreats' ); ?></label><input id="enq-phone" name="enq_phone" type="tel" required autocomplete="tel" aria-describedby="enq-phone-error" value="<?php echo esc_attr( $enq_val( 'enq_phone', $enq_fields ) ); ?>" /><p class="field-error" id="enq-phone-error" role="alert" hidden><?php esc_html_e( 'Enter your phone number.', 'restwell-retreats' ); ?></p></div>
							<div class="field"><label for="enq-pref"><?php esc_html_e( 'Contact preference', 'restwell-retreats' ); ?></label>
								<?php $pref = $enq_val( 'enq_contact_preference', $enq_fields, 'email' ); ?>
								<select id="enq-pref" name="enq_contact_preference">
									<option value="email" <?php selected( $pref, 'email' ); ?>><?php esc_html_e( 'Email', 'restwell-retreats' ); ?></option>
									<option value="phone" <?php selected( $pref, 'phone' ); ?>><?php esc_html_e( 'Phone', 'restwell-retreats' ); ?></option>
									<option value="either" <?php selected( $pref, 'either' ); ?>><?php esc_html_e( 'Either', 'restwell-retreats' ); ?></option>
								</select>
							</div>
						</div>
						<div class="field"><label for="enq-time"><?php esc_html_e( 'Best time to call', 'restwell-retreats' ); ?></label><input id="enq-time" name="enq_preferred_time" placeholder="e.g. weekday mornings" value="<?php echo esc_attr( $enq_val( 'enq_preferred_time', $enq_fields ) ); ?>" /></div>
					</fieldset>
					<div class="form-actions form-actions--end">
						<button class="btn btn-gold" type="button" data-step-next><?php esc_html_e( 'Continue', 'restwell-retreats' ); ?></button>
					</div>
				</div>
				<div class="form-step" data-step-panel="2" hidden>
					<fieldset class="form-stack">
						<legend class="form-legend"><?php esc_html_e( 'Your stay', 'restwell-retreats' ); ?></legend>
						<div class="form-grid form-grid--2">
							<div class="field"><label for="enq-from"><?php esc_html_e( 'Arrival (optional)', 'restwell-retreats' ); ?></label><input id="enq-from" name="enq_date_from" type="date" value="<?php echo esc_attr( $enq_val( 'enq_date_from', $enq_fields ) ); ?>" /></div>
							<div class="field"><label for="enq-to"><?php esc_html_e( 'Departure (optional)', 'restwell-retreats' ); ?></label><input id="enq-to" name="enq_date_to" type="date" value="<?php echo esc_attr( $enq_val( 'enq_date_to', $enq_fields ) ); ?>" /></div>
							<div class="field"><label for="enq-guests"><?php esc_html_e( 'Guests', 'restwell-retreats' ); ?></label><input id="enq-guests" name="enq_guests" type="number" min="1" max="5" value="<?php echo esc_attr( $enq_val( 'enq_guests', $enq_fields, '2' ) ); ?>" /></div>
							<div class="field"><label for="enq-fund"><?php esc_html_e( 'Funding type', 'restwell-retreats' ); ?></label>
								<select id="enq-fund" name="enq_funding">
									<option value="self" <?php selected( $funding_selected, 'self' ); ?>><?php esc_html_e( 'Self-funded', 'restwell-retreats' ); ?></option>
									<option value="kcc" <?php selected( $funding_selected, 'kcc' ); ?>><?php esc_html_e( 'Local authority / KCC', 'restwell-retreats' ); ?></option>
									<option value="chc" <?php selected( $funding_selected, 'chc' ); ?>><?php esc_html_e( 'NHS Continuing Healthcare', 'restwell-retreats' ); ?></option>
									<option value="direct" <?php selected( $funding_selected, 'direct' ); ?>><?php esc_html_e( 'Direct payment / PHB', 'restwell-retreats' ); ?></option>
									<option value="" <?php selected( $funding_selected, '' ); ?>><?php esc_html_e( 'Not sure yet', 'restwell-retreats' ); ?></option>
								</select>
							</div>
						</div>
						<div class="field"><label for="enq-urgent"><input id="enq-urgent" type="checkbox" name="enq_urgent" value="1" <?php checked( $enq_val( 'enq_urgent', $enq_fields ), '1' ); ?> /> <?php esc_html_e( 'This enquiry is time-sensitive', 'restwell-retreats' ); ?></label></div>
					</fieldset>
					<div class="form-actions form-actions--split">
						<button class="btn btn-outline-teal" type="button" data-step-prev><?php esc_html_e( 'Back', 'restwell-retreats' ); ?></button>
						<button class="btn btn-gold" type="button" data-step-next><?php esc_html_e( 'Continue', 'restwell-retreats' ); ?></button>
					</div>
				</div>
				<div class="form-step" data-step-panel="3" hidden>
					<fieldset class="form-stack">
						<legend class="form-legend"><?php esc_html_e( 'Your needs', 'restwell-retreats' ); ?></legend>
						<div class="field"><label for="enq-care"><?php esc_html_e( 'Care requirements', 'restwell-retreats' ); ?></label><textarea id="enq-care" name="enq_care" placeholder="Optional, e.g. morning personal care, overnight support"><?php echo esc_textarea( $enq_val( 'enq_care', $enq_fields ) ); ?></textarea></div>
						<div class="field"><label for="enq-access"><?php esc_html_e( 'Accessibility needs', 'restwell-retreats' ); ?></label><textarea id="enq-access" name="enq_accessibility" placeholder="Equipment, doorway clearances, vehicle access…"><?php echo esc_textarea( $enq_val( 'enq_accessibility', $enq_fields ) ); ?></textarea></div>
						<div class="field"><label for="enq-health-consent"><input id="enq-health-consent" type="checkbox" name="enq_health_consent" value="1" aria-describedby="enq-health-consent-hint enq-health-consent-error" <?php checked( $enq_val( 'enq_health_consent', $enq_fields ), '1' ); ?> /> <span><?php esc_html_e( 'If I have added care or accessibility notes, I agree Restwell can use that information to reply to this enquiry. Those notes can include health information, as explained in the', 'restwell-retreats' ); ?> <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'privacy-policy' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'restwell-retreats' ); ?></a>.</span></label><p class="field-hint" id="enq-health-consent-hint"><?php esc_html_e( 'Required only if you fill in care or accessibility notes above.', 'restwell-retreats' ); ?></p><p class="field-error" id="enq-health-consent-error" role="alert" hidden><?php esc_html_e( 'Confirm we can use those notes before sending.', 'restwell-retreats' ); ?></p></div>
						<div class="field"><label for="enq-msg"><?php esc_html_e( 'Message *', 'restwell-retreats' ); ?></label><textarea id="enq-msg" name="enq_message" required aria-describedby="enq-msg-error"><?php echo esc_textarea( $enq_val( 'enq_message', $enq_fields ) ); ?></textarea><p class="field-error" id="enq-msg-error" role="alert" hidden><?php esc_html_e( 'Add a short message so we know what you need.', 'restwell-retreats' ); ?></p></div>
						<div class="field"><label for="enq-consent"><input id="enq-consent" type="checkbox" name="enq_consent" value="1" required aria-describedby="enq-consent-error" <?php checked( $enq_val( 'enq_consent', $enq_fields ), '1' ); ?> /> <span><?php esc_html_e( 'I agree to Restwell contacting me about this enquiry and to my information being handled as set out in the', 'restwell-retreats' ); ?> <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'privacy-policy' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'restwell-retreats' ); ?></a> *</span></label><p class="field-error" id="enq-consent-error" role="alert" hidden><?php esc_html_e( 'Check this box so we can contact you about your enquiry.', 'restwell-retreats' ); ?></p></div>
						<div class="field"><label for="enq-marketing"><input id="enq-marketing" type="checkbox" name="enq_marketing_optin" value="1" <?php checked( $enq_val( 'enq_marketing_optin', $enq_fields ), '1' ); ?> /> <?php esc_html_e( 'Keep me updated about Restwell (optional)', 'restwell-retreats' ); ?></label></div>
					</fieldset>
					<div class="form-actions form-actions--split">
						<button class="btn btn-outline-teal" type="button" data-step-prev><?php esc_html_e( 'Back', 'restwell-retreats' ); ?></button>
						<button class="btn btn-gold" type="submit"><?php esc_html_e( 'Send enquiry', 'restwell-retreats' ); ?></button>
					</div>
				</div>
			</form>
			<?php endif; ?>
		</div>
		<aside class="sidebar-card" aria-label="<?php esc_attr_e( 'Contact details', 'restwell-retreats' ); ?>">
			<h2><?php esc_html_e( 'Talk to us', 'restwell-retreats' ); ?></h2>
			<p><strong><?php esc_html_e( 'Phone', 'restwell-retreats' ); ?></strong><br /><a href="tel:01622809881">01622 809881</a></p>
			<p><strong><?php esc_html_e( 'Email', 'restwell-retreats' ); ?></strong><br /><a href="mailto:hello@restwellretreats.co.uk">hello@restwellretreats.co.uk</a></p>
			<p><strong><?php esc_html_e( 'Where', 'restwell-retreats' ); ?></strong><br />Whitstable, Kent</p>
			<p><a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'resources' ) ); ?>"><?php esc_html_e( 'Funding & support', 'restwell-retreats' ); ?></a></p>
			<p><a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'who-its-for' ) ); ?>"><?php esc_html_e( 'Who it’s for', 'restwell-retreats' ); ?></a></p>
			<p><a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'the-property' ) ); ?>"><?php esc_html_e( 'See the adapted bungalow', 'restwell-retreats' ); ?></a></p>
		</aside>
	</div>
</section>
</main>

<?php
get_footer();
