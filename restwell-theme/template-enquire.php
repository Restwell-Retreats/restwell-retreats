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
$enq_success = isset( $_GET['sent'] ) && '1' === (string) wp_unslash( $_GET['sent'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
?>

<main id="main-content">
<section class="hero hero--interior" aria-labelledby="page-h">
	<div class="container">
		<div class="hero__content">
			<ol class="breadcrumb"><li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li><li class="breadcrumb__sep" aria-hidden="true">/</li><li aria-current="page">Enquire</li></ol>
			<div class="hero__text">
				<h1 id="page-h">Contact Restwell about your stay</h1>
				<p>Share dates, access needs and funding contact. No deposit until you decide. We reply within 48 hours on most enquiries.</p>
			</div>
		</div>
	</div>
</section>

<section class="section-y band-white" id="enquiry-result">
	<div class="container layout-sidebar">
		<div class="multistep" data-multistep>
			<?php if ( $enq_success ) : ?>
			<div class="step-success" tabindex="-1">
				<span class="icon-circle icon-circle--lg" aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false"><path d="M4.5 12.5l5 5L19.5 7" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
				<h2><?php esc_html_e( 'We’ve got your enquiry', 'restwell-retreats' ); ?></h2>
				<p class="lede"><?php esc_html_e( 'We reply within 48 hours on most enquiries; call 01622 809881 if you’d rather talk it through.', 'restwell-retreats' ); ?></p>
			</div>
			<?php else : ?>
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
							<div class="field"><label for="enq-name"><?php esc_html_e( 'Full name *', 'restwell-retreats' ); ?></label><input id="enq-name" name="enq_name" required autocomplete="name" /></div>
							<div class="field"><label for="enq-email"><?php esc_html_e( 'Email *', 'restwell-retreats' ); ?></label><input id="enq-email" name="enq_email" type="email" required autocomplete="email" /></div>
							<div class="field"><label for="enq-phone"><?php esc_html_e( 'Phone *', 'restwell-retreats' ); ?></label><input id="enq-phone" name="enq_phone" type="tel" required autocomplete="tel" /></div>
							<div class="field"><label for="enq-pref"><?php esc_html_e( 'Contact preference', 'restwell-retreats' ); ?></label>
								<select id="enq-pref" name="enq_contact_preference"><option value="email">Email</option><option value="phone">Phone</option><option value="either">Either</option></select>
							</div>
						</div>
						<div class="field"><label for="enq-time"><?php esc_html_e( 'Best time to call', 'restwell-retreats' ); ?></label><input id="enq-time" name="enq_preferred_time" placeholder="e.g. weekday mornings" /></div>
					</fieldset>
					<div class="form-actions form-actions--end">
						<button class="btn btn-gold" type="button" data-step-next><?php esc_html_e( 'Continue', 'restwell-retreats' ); ?></button>
					</div>
				</div>
				<div class="form-step" data-step-panel="2" hidden>
					<fieldset class="form-stack">
						<legend class="form-legend"><?php esc_html_e( 'Your stay', 'restwell-retreats' ); ?></legend>
						<div class="form-grid form-grid--2">
							<div class="field"><label for="enq-from"><?php esc_html_e( 'Arrival (optional)', 'restwell-retreats' ); ?></label><input id="enq-from" name="enq_date_from" type="date" /></div>
							<div class="field"><label for="enq-to"><?php esc_html_e( 'Departure (optional)', 'restwell-retreats' ); ?></label><input id="enq-to" name="enq_date_to" type="date" /></div>
							<div class="field"><label for="enq-guests"><?php esc_html_e( 'Guests', 'restwell-retreats' ); ?></label><input id="enq-guests" name="enq_guests" type="number" min="1" max="5" value="2" /></div>
							<div class="field"><label for="enq-fund"><?php esc_html_e( 'Funding type', 'restwell-retreats' ); ?></label>
								<select id="enq-fund" name="enq_funding">
									<option value="self-funded">Self-funded</option>
									<option value="local-authority">Local authority / KCC</option>
									<option value="nhs-chc">NHS Continuing Healthcare</option>
									<option value="direct-payment">Direct payment / PHB</option>
									<option value="not-sure">Not sure yet</option>
								</select>
							</div>
						</div>
						<div class="field"><label for="enq-urgent"><input id="enq-urgent" type="checkbox" name="enq_urgent" value="1" /> <?php esc_html_e( 'This enquiry is time-sensitive', 'restwell-retreats' ); ?></label></div>
					</fieldset>
					<div class="form-actions form-actions--split">
						<button class="btn btn-outline-teal" type="button" data-step-prev><?php esc_html_e( 'Back', 'restwell-retreats' ); ?></button>
						<button class="btn btn-gold" type="button" data-step-next><?php esc_html_e( 'Continue', 'restwell-retreats' ); ?></button>
					</div>
				</div>
				<div class="form-step" data-step-panel="3" hidden>
					<fieldset class="form-stack">
						<legend class="form-legend"><?php esc_html_e( 'Your needs', 'restwell-retreats' ); ?></legend>
						<div class="field"><label for="enq-care"><?php esc_html_e( 'Care requirements', 'restwell-retreats' ); ?></label><textarea id="enq-care" name="enq_care" placeholder="Optional, e.g. morning personal care, overnight support"></textarea></div>
						<div class="field"><label for="enq-access"><?php esc_html_e( 'Accessibility needs', 'restwell-retreats' ); ?></label><textarea id="enq-access" name="enq_accessibility" placeholder="Equipment, doorway clearances, vehicle access…"></textarea></div>
						<div class="field"><label for="enq-msg"><?php esc_html_e( 'Message *', 'restwell-retreats' ); ?></label><textarea id="enq-msg" name="enq_message" required></textarea></div>
						<div class="field"><label for="enq-consent"><input id="enq-consent" type="checkbox" name="enq_consent" value="1" required /> <span><?php esc_html_e( 'I agree to Restwell contacting me about this enquiry and to my information being handled as set out in the', 'restwell-retreats' ); ?> <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'privacy-policy' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'restwell-retreats' ); ?></a> *</span></label></div>
						<div class="field"><label for="enq-marketing"><input id="enq-marketing" type="checkbox" name="enq_marketing_optin" value="1" /> <?php esc_html_e( 'Keep me updated about Restwell (optional)', 'restwell-retreats' ); ?></label></div>
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
			<p><strong><?php esc_html_e( 'Property', 'restwell-retreats' ); ?></strong><br />Russell Drive<br />Whitstable, CT5 2RQ</p>
			<p><a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'resources' ) ); ?>"><?php esc_html_e( 'Funding & support', 'restwell-retreats' ); ?></a></p>
			<p><a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'who-its-for' ) ); ?>"><?php esc_html_e( 'Who it’s for', 'restwell-retreats' ); ?></a></p>
			<p><a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'the-property' ) ); ?>"><?php esc_html_e( 'See the adapted bungalow', 'restwell-retreats' ); ?></a></p>
		</aside>
	</div>
</section>
</main>

<?php
get_footer();
