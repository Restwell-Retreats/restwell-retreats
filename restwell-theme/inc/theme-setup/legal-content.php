<?php
/**
 * Theme setup: legal policy default HTML and page field maps.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function restwell_get_public_enquiry_email(): string {
	if ( function_exists( 'restwell_get_submission_notify_email' ) ) {
		return restwell_get_submission_notify_email();
	}
	return 'hello@restwellretreats.co.uk';
}

/**
 * Registered / trading name for legal copy (same option as footer copyright).
 *
 * @return string Plain text (escape when outputting in HTML).
 */
function restwell_get_legal_entity_display_name(): string {
	return (string) get_option(
		'restwell_footer_legal_name',
		__( 'Homely Housing Investments Ltd t/a Restwell Retreats', 'restwell-retreats' )
	);
}

/**
 * Site hostname for policy text (avoids hardcoding the production domain).
 *
 * @return string Hostname only, no scheme.
 */
function restwell_get_public_site_host(): string {
	$host = wp_parse_url( home_url(), PHP_URL_HOST );
	return is_string( $host ) && $host !== '' ? $host : 'restwellretreats.co.uk';
}

/**
 * Stable version stamp stored on enquiry consent (YYYY-MM-DD).
 * Bump when the privacy policy body that guests consent to changes.
 *
 * @return string
 */
function restwell_privacy_policy_version(): string {
	return '2026-10-23';
}

/**
 * Last-updated date for the Terms. A fixed date, changed only when the wording
 * changes: it used to print the current month on every re-seed (audit I40).
 *
 * @return string
 */
function restwell_terms_updated_label(): string {
	return '23 October 2026';
}

/**
 * Last-updated date for the website accessibility statement (see above).
 *
 * @return string
 */
function restwell_accessibility_statement_updated_label(): string {
	return '23 October 2026';
}

/**
 * Human-readable last-updated date for the privacy policy body.
 *
 * @return string
 */
function restwell_privacy_policy_updated_label(): string {
	$ts = strtotime( restwell_privacy_policy_version() . ' UTC' );
	return $ts ? gmdate( 'j F Y', $ts ) : restwell_privacy_policy_version();
}

/**
 * Returns minimal Privacy Policy body HTML (used by template-privacy-policy when legal_body_html is empty).
 *
 * @return string HTML string.
 */
function restwell_get_privacy_policy_content(): string {
	$site        = esc_html( get_bloginfo( 'name' ) );
	$entity      = esc_html( restwell_get_legal_entity_display_name() );
	$email       = restwell_get_public_enquiry_email();
	$mailto_href = esc_url( 'mailto:' . $email );

	return '<h2>Who we are</h2>
<p>' . $site . ' (“we” or “us”) runs an accessible holiday bungalow in Whitstable, Kent. This website is ' . esc_url( home_url( '/' ) ) . '.</p>
<p>The data controller is ' . $entity . '. That means we decide how your information is used, and we’re responsible for it.</p>
<p>Restwell is a private holiday home. It isn’t a care home, a nursing home, an NHS service or a registered respite centre. If you arrange optional care, it comes from Continuity of Care Services, which the CQC regulates, not from Restwell.</p>

<h2>What we collect, and why</h2>
<p>Our enquiry form, including the date picker on the Pricing page, asks for your name, email, phone number and message. We also keep any dates, guest numbers, funding notes and contact preferences, and how you found us if you say.</p>
<p>We use these details with your consent, which you give by ticking the privacy box (UK GDPR Article 6(1)(a)). If you book, we use them to carry out our contract with you (Article 6(1)(b)).</p>
<p>Where needed, we also rely on our legitimate interest in running the holiday let (Article 6(1)(f)).</p>
<p>If you ask a question on the FAQ page, we collect your name, email, phone number and question. This uses the same consent tick, and we use it only to reply.</p>
<p>If you sign up for our news, we keep your name, email and phone number to send it. That box stays unticked unless you tick it. The legal basis is your consent (UK GDPR and PECR), and you can unsubscribe from any marketing email.</p>
<p>Once a stay is confirmed, we keep booking records: your name, email, dates and payments. If we send the arrival guide, we keep a record so we can email you a one-time access code. We do this to carry out the booking contract.</p>

<h2>Care notes and health information</h2>
<p>The care and accessibility boxes on the enquiry form are optional. What you write there can include health information, which the law calls special category data. We only store it if you tick the separate health-data box.</p>
<p>The legal basis is your explicit consent (UK GDPR Article 9(2)(a)). We use these notes only to reply and to check the bungalow is likely to suit you. If you later agree in writing to a stay with care, we use them to introduce Continuity.</p>
<p>Please put care and accessibility notes in the labelled boxes, not just in your general message. We treat what’s in those boxes as special category data. If your FAQ question includes health or care details, we use them only to reply.</p>
<p>We never use health notes for marketing, and we don’t send them to Google, Metricool, TikTok or Mailchimp. We don’t create medical records. Ticking the privacy box on the enquiry form doesn’t share your details with Continuity.</p>

<h2>Who we share it with</h2>
<p>We never sell your personal information. We share it only with:</p>
<ul>
<li>The firms that run our website, email and hosting, who use it only as we tell them.</li>
<li>Mailchimp (The Rocket Science Group, part of Intuit), only if you sign up for news.</li>
<li>Google Analytics 4, Metricool and TikTok Pixel, only if you accept analytics cookies. TikTok learns when a page is viewed or an enquiry is sent, but not what you wrote on a form.</li>
<li>Continuity, only if you later agree in writing to a stay with care.</li>
<li>Insurers, accountants or public bodies, when the law says we must.</li>
</ul>

<h2>Sending data outside the UK</h2>
<p>Google, Mailchimp, Metricool and TikTok may handle data outside the UK, including the US. They only get it after you accept analytics cookies or sign up for news. If a tool can’t protect it as well as UK law does, we won’t use that tool.</p>

<h2>Cookies and analytics</h2>
<p>Essential cookies keep the site working. They remember your cookie choice and run security checks on our forms. After the email code, they also keep a booked guest signed in to the arrival guide for a while.</p>
<p>Analytics and advertising measurement cookies (Google Analytics 4, Metricool and TikTok Pixel, if set up) are optional. None is set until you choose Accept analytics on the cookie banner.</p>
<p>You can reject them and still use the whole site, or change your mind in Cookie settings in the footer. Tracking scripts stay off until you agree, even if we add a new service later.</p>
<p>If you accept analytics, TikTok Pixel records when a page is viewed and when an enquiry form is sent. We never send it names, email addresses, phone numbers, addresses, care or accessibility notes, or other form fields.</p>

<h2>How long we keep it</h2>
<p>We keep enquiry, FAQ, guest guide and booking records for up to three years. That lets us answer follow-up questions and meet our insurance and accounting needs. We don’t delete whole records automatically when that time is up.</p>
<p>Care and accessibility notes are blanked sooner. That’s after 12 months if the enquiry doesn’t become a booking, or 90 days after the stay if it does.</p>
<p>If you want your records corrected or removed sooner, email us. We handle these requests ourselves, as there’s no delete button on the site.</p>

<h2>Your rights</h2>
<p>Under UK GDPR, you can:</p>
<ul>
<li>Ask what information we hold about you.</li>
<li>Ask us to correct mistakes.</li>
<li>Ask us to delete it, or limit how we use it, where the law allows.</li>
<li>Object to some of the ways we use it.</li>
<li>Withdraw your consent at any time, including for health notes and marketing. This doesn’t affect anything we did before you withdrew it.</li>
<li>Complain to the <a href="https://www.ico.org.uk/" target="_blank" rel="noopener noreferrer">Information Commissioner’s Office (ICO)<span class="sr-only"> (opens in new tab)</span></a>.</li>
</ul>
<p>To use any of these rights, email <a href="' . $mailto_href . '">' . esc_html( $email ) . '</a>. We’ll check it’s you before we change or delete anything, and we aim to reply within one month.</p>

<h2>Changes to this policy</h2>
<p>We may update this policy from time to time, and the current version is always on this page. This is version ' . esc_html( restwell_privacy_policy_version() ) . ', last updated on ' . esc_html( restwell_privacy_policy_updated_label() ) . '.</p>';
}

/**
 * Returns minimal Terms & Conditions body HTML (used by template-terms-and-conditions when legal_body_html is empty).
 *
 * @return string HTML string.
 */
function restwell_get_terms_conditions_content(): string {
	$entity  = esc_html( restwell_get_legal_entity_display_name() );
	$enquire = esc_url( home_url( '/enquire/' ) );
	$privacy = esc_url( home_url( '/privacy-policy/' ) );
	$email   = restwell_get_public_enquiry_email();
	$mailto  = esc_url( 'mailto:' . $email );

	$payment_para = function_exists( 'restwell_get_terms_payment_paragraph' )
		? restwell_get_terms_payment_paragraph()
		: esc_html__( 'A 50% deposit secures your dates. The balance is due no later than one week before arrival unless we agree otherwise in writing. We accept bank transfer (BACS) and debit or credit card.', 'restwell-retreats' );

	$timeline  = function_exists( 'restwell_get_payment_timeline' ) ? restwell_get_payment_timeline() : array();
	$check_in  = isset( $timeline['check_in'] ) ? esc_html( $timeline['check_in'] ) : '15:00';
	$check_out = isset( $timeline['check_out'] ) ? esc_html( $timeline['check_out'] ) : '11:00';

	return '<h2>Your booking</h2>
<p>These terms apply when you book our self-catering bungalow in Whitstable, Kent. In these terms, “we” and “us” mean ' . $entity . '. We send the full address with your booking confirmation.</p>
<p>Your booking is confirmed only when we confirm it to you in writing. Until then there’s no contract, and the dates aren’t held for you. Every booking depends on the dates being free.</p>

<h2>Your access needs</h2>
<p>Please tell us your access and equipment needs when you book, so we can check the bungalow suits you. Needs we hear about after written confirmation may not be possible to meet. We can’t promise changes to the setup or equipment at short notice.</p>

<h2>Payment</h2>
<p>' . $payment_para . '</p>

<h2>If you cancel</h2>
<p>If you need to cancel, please tell us as soon as you can. Your refund depends on how long before arrival you cancel:</p>
<ul>
<li><strong>More than 30 days before arrival:</strong> a full refund of everything you’ve paid.</li>
<li><strong>14 to 30 days before arrival:</strong> a refund of 50% of the total booking cost.</li>
<li><strong>Less than 14 days before arrival:</strong> no refund.</li>
</ul>
<p>We strongly advise everyone in your group to take out travel and cancellation insurance.</p>

<h2>Illness, injury and care emergencies</h2>
<p>We know plans can change suddenly when someone needs care or access support. If you cancel because of serious illness, injury or a care emergency, we may offer a partial refund. Or we may offer a free date change, if other dates are free.</p>
<p>We may ask for reasonable evidence, such as a letter from a doctor. We look at each case on its own merits.</p>

<h2>Changing your dates</h2>
<p>Up to 14 days before arrival, you can ask to change your dates at no extra charge. This depends on the new dates being free. Changes asked for within 14 days of arrival may carry an admin fee.</p>

<h2>Leaving early or not arriving</h2>
<p>We don’t give a refund if you leave early, or if you don’t arrive and haven’t told us beforehand.</p>

<h2>If we cancel</h2>
<p>If we have to cancel your booking, you’ll get a full refund of everything you’ve paid. Or, if you prefer, you can rebook for other dates.</p>

<h2>Check-in and check-out</h2>
<p>Check-in is from ' . $check_in . ', and check-out is by ' . $check_out . '. If a different time would help because of your access needs, tell us when you book. We’ll fit in with you where we can.</p>

<h2>Number of guests</h2>
<p>We confirm the most guests who can stay when you book. That number must not be exceeded without our written agreement first.</p>

<h2>Access equipment</h2>
<p>The bungalow has a ceiling track hoist, a profiling bed, a wet room and other access features. Please use all the equipment safely, and only for what it’s meant for.</p>
<p>Tell us straight away about any fault or problem, so we can put it right quickly. Equipment must be left in the condition and position you found it in.</p>

<h2>Dogs</h2>
<p>Dogs are allowed, as long as you tell us beforehand and we’ve done a risk assessment.</p>

<h2>Smoking and vaping</h2>
<p>Smoking and vaping aren’t allowed inside the bungalow. If you smoke, please do it outside and get rid of your waste safely.</p>

<h2>Looking after the bungalow</h2>
<p>Please take reasonable care of the bungalow and everything in it. Tell us about any breakage or damage as soon as it happens. When you leave, please leave it tidy: lights off, windows closed, doors locked and used towels in the bathroom.</p>

<h2>Optional care</h2>
<p>You can arrange optional care with Continuity of Care Services, which the CQC regulates. Their own terms and privacy notices apply to the care they give. We only introduce their service, and we take no responsibility for the care provided.</p>

<h2>Liability</h2>
<p>We aren’t liable for loss, injury or damage to guests or their belongings during a stay. The exceptions are where our negligence directly caused it, and anything else the law doesn’t let us exclude.</p>
<p>It’s up to guests to have enough travel, cancellation and personal insurance.</p>

<h2>Your data and cookies</h2>
<p>Our <a href="' . $privacy . '">privacy policy</a> explains how we look after your details, including any care or access notes you share. Optional cookies for analytics and advertising stay off until you accept them. You can change your choice in Cookie settings, in the footer.</p>

<h2>Contact</h2>
<p>If you have a question about these terms, use <a href="' . $enquire . '">our enquiry page</a> or email <a href="' . $mailto . '">' . esc_html( $email ) . '</a>.</p>

<p><em>Last updated: ' . esc_html( restwell_terms_updated_label() ) . '.</em></p>';
}

/**
 * Website accessibility statement body HTML (template-accessibility-policy).
 *
 * @return string HTML string.
 */
function restwell_get_accessibility_policy_content(): string {
	$acc    = esc_url( home_url( '/accessibility/' ) );
	$enq    = esc_url( home_url( '/enquire/' ) );
	$email  = restwell_get_public_enquiry_email();
	$mailto = esc_url( 'mailto:' . $email );

	return '<h2>Our aim</h2>
<p>We want this website to be easy to use for everyone, including guests, families, carers and professionals. We aim to meet the Web Content Accessibility Guidelines (WCAG) 2.2 at level AA.</p>
<p>This statement is about the website. For door widths, equipment and room layouts, see <a href="' . $acc . '">the bungalow’s access details</a>.</p>

<h2>What you can do on this site</h2>
<p>You should be able to:</p>
<ul>
<li>Move through every page with a keyboard, with a clear outline showing where you are.</li>
<li>Skip straight to the main content from the top of each page.</li>
<li>Zoom in to 400% without text running off the side of the screen.</li>
<li>Read text and links that stand out from the background, even when you hover over them or move to them.</li>
<li>Use forms with a clear label on every box.</li>
</ul>

<h2>What isn’t right yet</h2>
<p>We haven’t yet tested every page with a screen reader, or with disabled people using their own set-ups. Until we have, we can’t say the site fully meets WCAG 2.2 AA.</p>
<p>Some pages link to maps, a video and other organisations’ websites. We can’t control how accessible those are. If one of them stops you, tell us, and we’ll find another way to give you the information.</p>

<h2>How we test</h2>
<p>We check page structure, keyboard use, form labels and colour contrast, with testing software and by hand. We also check each page at phone, tablet and desktop widths. We fix the problems we can control whenever we update the site.</p>

<h2>Our commitment under the Equality Act 2010</h2>
<p>We make reasonable adjustments so disabled people aren’t at a disadvantage when they use our services. That includes this website.</p>

<h2>Tell us about a problem</h2>
<p>If any part of this site doesn’t work for you, please tell us. If you need information in another format, just ask. Email <a href="' . $mailto . '">' . esc_html( $email ) . '</a> or use our <a href="' . $enq . '">enquiry form</a>, and we aim to reply within 48 hours.</p>

<h2>If you’re not happy with our reply</h2>
<p>The <a href="https://www.equalityhumanrights.com/en" target="_blank" rel="noopener noreferrer">Equality and Human Rights Commission (EHRC)<span class="sr-only"> (opens in new tab)</span></a> publishes guidance on rights in England, Scotland and Wales.</p>

<p><em>Last updated: ' . esc_html( restwell_accessibility_statement_updated_label() ) . '.</em></p>';
}

/**
 * Default Page Content Fields for Privacy Policy template.
 *
 * @return array<string, mixed>
 */
function restwell_get_privacy_policy_page_defaults() {
	return array(
		'legal_label'         => 'Your information',
		'legal_heading'       => 'Privacy policy: how we look after your details',
		'legal_intro'         => 'This explains what we collect when you contact us or book, and how long we keep it. It also sets out your rights under UK GDPR, including how to complain.',
		'legal_hero_image_id' => 0,
		'legal_body_html'     => '',
	);
}

/**
 * Default Page Content Fields for Terms & Conditions template.
 *
 * @return array<string, mixed>
 */
function restwell_get_terms_conditions_page_defaults() {
	return array(
		'legal_label'         => 'Bookings',
		'legal_heading'       => 'Terms and conditions for booking a stay',
		'legal_intro'         => 'These are the terms for booking the bungalow. They cover payment, cancelling, changing dates, the house rules and optional care.',
		'legal_hero_image_id' => 0,
		'legal_body_html'     => '',
	);
}

/**
 * Default Page Content Fields for Accessibility Policy (website statement) template.
 *
 * @return array<string, mixed>
 */
function restwell_get_accessibility_policy_page_defaults() {
	return array(
		'legal_label'         => 'Digital access',
		'legal_heading'       => 'Accessibility statement for this website',
		'legal_intro'         => 'This statement covers how well this website works for disabled visitors. It also says what isn’t right yet, and how to tell us about a problem.',
		'legal_hero_image_id' => 0,
		'legal_body_html'     => '',
	);
}

/**
 * Seed default meta for every template page except Home (which is handled above).
 *
 * Adds keys to $result: 'pages_seeded' and 'pages_seed_skipped'.
 *
 * @param array $created_ids Map of page title => post ID from the setup run.
 * @param bool  $force       Re-seed even if already seeded.
 * @param array $result      Result array passed by reference.
 */
function restwell_seed_all_pages_meta( array $created_ids, $force, array &$result ) {
	$page_defaults_map = array(
		'The Property'  => 'restwell_get_property_page_defaults',
		'How It Works'  => 'restwell_get_how_it_works_page_defaults',
		'Accessibility' => 'restwell_get_accessibility_page_defaults',
		'Who It\'s For' => 'restwell_get_who_its_for_page_defaults',
		'Whitstable Guide' => 'restwell_get_whitstable_guide_page_defaults',
		'FAQ'           => 'restwell_get_faq_page_defaults',
		'Enquire'       => 'restwell_get_enquire_page_defaults',
		'Pricing'       => 'restwell_get_pricing_page_defaults',
		'Resources'     => 'restwell_get_resources_page_defaults',
		'Guest Guide'          => 'restwell_get_guest_guide_page_defaults',
		'Privacy Policy'       => 'restwell_get_privacy_policy_page_defaults',
		'Terms & Conditions'   => 'restwell_get_terms_conditions_page_defaults',
		'Accessibility Policy' => 'restwell_get_accessibility_policy_page_defaults',
		'Our Story'            => 'restwell_get_our_story_page_defaults',
		'Optional care'        => 'restwell_get_care_page_defaults',
	);

	foreach ( $page_defaults_map as $title => $defaults_fn ) {
		// Resolve the page ID: prefer the ID from this run, then look it up.
		$page_id = isset( $created_ids[ $title ] ) ? (int) $created_ids[ $title ] : 0;
		if ( $page_id < 1 ) {
			$slug = sanitize_title( $title );
			$page = get_page_by_path( $slug, OBJECT, 'page' );
			$page_id = $page ? (int) $page->ID : 0;
		}
		if ( $page_id < 1 ) {
			continue;
		}

		if ( ! is_callable( $defaults_fn ) ) {
			continue;
		}

		$defaults = call_user_func( $defaults_fn );
		$n        = restwell_merge_theme_defaults_into_post_meta( $page_id, $defaults, $force );
		if ( $n > 0 ) {
			update_post_meta( $page_id, 'restwell_fields_seeded', '1' );
			$result['pages_seeded'][] = $title;
		} elseif ( ! $force ) {
			$result['pages_seed_skipped'][] = $title;
		}
	}
}

/**
 * Format setup result as an admin notice.
 *
 * @param array $result Result from restwell_run_theme_setup().
 * @return string HTML for the notice.
 */
function restwell_theme_setup_format_message( $result ) {
	$lines = array();

	if ( ! empty( $result['created'] ) ) {
		$lines[] = '<strong>' . esc_html__( 'Created pages:', 'restwell-retreats' ) . '</strong> ' . esc_html( implode( ', ', $result['created'] ) );
	}
	if ( ! empty( $result['skipped'] ) ) {
		$lines[] = '<strong>' . esc_html__( 'Skipped (already exist):', 'restwell-retreats' ) . '</strong> ' . esc_html( implode( ', ', $result['skipped'] ) );
	}
	if ( $result['front_page_set'] ) {
		$lines[] = esc_html__( 'Home set as static front page.', 'restwell-retreats' );
	}
	if ( $result['home_seeded'] ) {
		$n          = isset( $result['home_meta_keys_written'] ) ? (int) $result['home_meta_keys_written'] : 0;
		$additive   = ! empty( $result['home_additive_only'] );
		if ( $additive && $n > 0 ) {
			/* translators: %d: number of meta keys written from theme defaults */
			$lines[] = sprintf( esc_html__( 'Home page: %d new default field(s) merged from theme (existing values unchanged).', 'restwell-retreats' ), $n );
		} else {
			$lines[] = esc_html__( 'Default content seeded on Home page.', 'restwell-retreats' );
		}
	}
	if ( ! empty( $result['pages_seeded'] ) ) {
		$lines[] = '<strong>' . esc_html__( 'Page content seeded:', 'restwell-retreats' ) . '</strong> ' . esc_html( implode( ', ', $result['pages_seeded'] ) );
	}
	if ( ! empty( $result['pages_seed_skipped'] ) ) {
		$lines[] = '<strong>' . esc_html__( 'Template pages: no missing default fields (unchanged):', 'restwell-retreats' ) . '</strong> ' . esc_html( implode( ', ', $result['pages_seed_skipped'] ) );
	}
	if ( ! empty( $result['media_seed_skipped'] ) ) {
		$lines[] = esc_html__( 'Media seed skipped (checkbox). Logos, partner images, and responsive image regeneration were not run.', 'restwell-retreats' );
	}
	if ( ! empty( $result['logos_uploaded'] ) ) {
		$lines[] = '<strong>' . esc_html__( 'Logos uploaded to Media Library:', 'restwell-retreats' ) . '</strong> ' . esc_html( implode( ', ', $result['logos_uploaded'] ) );
	}
	if ( ! empty( $result['logos_skipped'] ) ) {
		$lines[] = '<strong>' . esc_html__( 'Logos already in Media Library:', 'restwell-retreats' ) . '</strong> ' . esc_html( implode( ', ', $result['logos_skipped'] ) );
	}
	if ( ! empty( $result['logos_missing'] ) ) {
		$lines[] = '<strong>' . esc_html__( 'Logo files not found in theme:', 'restwell-retreats' ) . '</strong> ' . esc_html( implode( ', ', $result['logos_missing'] ) );
	}
	if ( ! empty( $result['logos_failed'] ) ) {
		$lines[] = '<strong>' . esc_html__( 'Logo upload failed:', 'restwell-retreats' ) . '</strong> ' . esc_html( implode( ', ', $result['logos_failed'] ) );
	}
	if ( ! empty( $result['partner_logos_uploaded'] ) ) {
		$lines[] = '<strong>' . esc_html__( 'Partner logos uploaded and mapped:', 'restwell-retreats' ) . '</strong> ' . esc_html( implode( ', ', $result['partner_logos_uploaded'] ) );
	}
	if ( ! empty( $result['partner_logos_skipped'] ) ) {
		$lines[] = '<strong>' . esc_html__( 'Partner logos already set:', 'restwell-retreats' ) . '</strong> ' . esc_html( implode( ', ', $result['partner_logos_skipped'] ) );
	}
	if ( ! empty( $result['partner_logos_missing'] ) ) {
		$lines[] = '<strong>' . esc_html__( 'Partner logo files not found in /assets/images/partners/:', 'restwell-retreats' ) . '</strong> ' . esc_html( implode( ', ', $result['partner_logos_missing'] ) );
	}
	if ( ! empty( $result['partner_logos_failed'] ) ) {
		$lines[] = '<strong>' . esc_html__( 'Partner logo upload failed:', 'restwell-retreats' ) . '</strong> ' . esc_html( implode( ', ', $result['partner_logos_failed'] ) );
	}
	if ( ! empty( $result['posts_page_set'] ) ) {
		$lines[] = esc_html__( 'Blog page set as the posts archive (Posts page).', 'restwell-retreats' );
	}
	if ( ! empty( $result['hub_seeded'] ) ) {
		$lines[] = '<strong>' . esc_html__( 'Hub / blog content updated:', 'restwell-retreats' ) . '</strong> ' . esc_html( implode( ', ', $result['hub_seeded'] ) );
	}
	if ( ! empty( $result['seo_meta_applied'] ) ) {
		if ( ! empty( $result['seo_meta_forced'] ) ) {
			$lines[] = esc_html__( 'SEO title, meta description, and focus keyphrases were refreshed from theme defaults (re-run).', 'restwell-retreats' );
		} else {
			$lines[] = esc_html__( 'SEO title and description defaults applied where fields were empty.', 'restwell-retreats' );
		}
	}
	if ( ! empty( $result['blog_posts_seeded'] ) ) {
		$lines[] = '<strong>' . esc_html__( 'Blog posts created:', 'restwell-retreats' ) . '</strong> ' . esc_html( implode( ', ', $result['blog_posts_seeded'] ) );
	}
	if ( ! empty( $result['blog_posts_failed'] ) ) {
		$lines[] = '<strong>' . esc_html__( 'Blog post seed failed (slug):', 'restwell-retreats' ) . '</strong> ' . esc_html( implode( ', ', $result['blog_posts_failed'] ) );
	}

	if ( ! empty( $result['image_regen_skipped'] ) && empty( $result['media_seed_skipped'] ) ) {
		$lines[] = esc_html__( 'Responsive image regeneration was skipped (checkbox). Use Theme Setup again or run wp media regenerate on the server.', 'restwell-retreats' );
	} elseif ( ! empty( $result['image_regen'] ) && is_array( $result['image_regen'] ) ) {
		$ir = $result['image_regen'];
		/* translators: %d: number of attachments processed */
		$lines[] = sprintf( esc_html__( 'Responsive image sizes updated for %d image(s) (restwell-hero, restwell-cta-bg, etc.).', 'restwell-retreats' ), (int) ( $ir['processed'] ?? 0 ) );
		if ( ! empty( $ir['errors'] ) ) {
			/* translators: %d: error count */
			$lines[] = sprintf( esc_html__( 'Image regeneration reported %d error(s). Check file permissions and disk space.', 'restwell-retreats' ), (int) $ir['errors'] );
			if ( ! empty( $ir['error_samples'] ) ) {
				$lines[] = esc_html( implode( ' ', $ir['error_samples'] ) );
			}
		}
	}

	if ( empty( $lines ) ) {
		return '<div class="notice notice-warning"><p>' . esc_html__( 'No changes made. Home page may be missing.', 'restwell-retreats' ) . '</p></div>';
	}

	return '<div class="notice notice-success"><p>' . implode( '<br />', $lines ) . '</p></div>';
}

/**
 * One-time seed for homepage FAQ post meta (sites that already had restwell_fields_seeded before FAQ keys existed).
 *
 * Fills only keys that do not exist yet so editor changes are preserved.
 */
