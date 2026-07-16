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
	$e = (string) get_option( 'restwell_enquiry_notify_email', '' );
	if ( $e && function_exists( 'is_email' ) && is_email( $e ) ) {
		return $e;
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
<p>' . $site . ' ("we", "us", "our") offers accessible holiday accommodation in Whitstable, Kent. This website is published at ' . esc_url( home_url( '/' ) ) . '.</p>
<p>The data controller for personal information collected through this site is ' . $entity . '.</p>

<h2>What information we collect and why</h2>
<p>When you use our enquiry form we collect: your name, email address, phone number, and any care or accessibility information you choose to share. We use this on the basis of our legitimate interests to respond to your enquiry and, if you go on to book, to perform the contract for your stay.</p>
<p>We do not sell your personal information. We share it only with our care partner, Continuity of Care Services (CQC-regulated), when care support is part of your booking and you have agreed to that arrangement.</p>

<h2>Cookies and analytics</h2>
<p>We use cookies for essential site functionality and, where you consent, for analytics (Google Analytics 4). You can change preferences using the cookie controls shown on your first visit.</p>

<h2>How long we keep your data</h2>
<p>We keep enquiry and booking-related records for up to three years so we can answer follow-up questions and meet regulatory and insurance expectations. You can ask us to delete your data sooner where the law allows.</p>

<h2>Your rights</h2>
<p>Under UK GDPR you may: ask what data we hold about you; ask us to correct mistakes; ask us to delete or restrict use of your data in certain cases; object to some processing; and complain to the <a href="https://www.ico.org.uk/" target="_blank" rel="noopener noreferrer">Information Commissioner\'s Office (ICO)<span class="sr-only"> (opens in new tab)</span></a>.</p>
<p>To exercise these rights, email <a href="' . $mailto_href . '">' . esc_html( $email ) . '</a>.</p>

<h2>Changes to this policy</h2>
<p>We may update this policy from time to time. The current version is always on this page. Last updated: ' . esc_html( gmdate( 'F Y' ) ) . '.</p>';
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

	return '<h2>The booking</h2>
<p>These terms apply when you book the adapted self-catering bungalow at 101 Russell Drive, Whitstable, Kent, CT5 2RQ with ' . $entity . '. Your booking is confirmed when you receive written confirmation from us. Until that point, no contract exists and the dates are not reserved. All bookings are subject to availability.</p>

<h2>Accessibility requirements</h2>
<p>We ask you to share your accessibility and equipment requirements at the time of booking so we can confirm the property is suitable for your needs. Requirements disclosed after written confirmation has been issued may not be possible to meet; we cannot guarantee changes to setup or equipment at short notice.</p>

<h2>Payment</h2>
<p>A deposit secures your dates; the amount is confirmed at the time of booking. The balance is due no later than six weeks before arrival unless we agree otherwise in writing. We accept bank transfer (BACS) and debit or credit card.</p>

<h2>Cancellation by you</h2>
<p>If you need to cancel, please contact us as soon as possible. Refunds are calculated as follows:</p>
<ul>
<li><strong>More than 30 days before arrival:</strong> full refund of all payments made.</li>
<li><strong>14 to 30 days before arrival:</strong> 50 per cent refund of the total booking cost.</li>
<li><strong>Fewer than 14 days before arrival:</strong> no refund will be issued.</li>
</ul>
<p>We strongly recommend that all guests take out travel and cancellation insurance.</p>

<h2>Accessibility and exceptional circumstances</h2>
<p>We recognise that guests booking accessible accommodation may face unforeseen medical or care-related changes. Where cancellation results from serious illness, injury, or a care emergency, we may offer a partial refund or a free date change subject to availability. We may ask for reasonable supporting evidence, such as a letter from a doctor. Each situation is considered on its own merits.</p>

<h2>Date changes</h2>
<p>You may request a change of dates up to 14 days before arrival at no additional charge, subject to availability. Changes requested within 14 days of arrival may incur an administration fee.</p>

<h2>Early departure and no-shows</h2>
<p>No refund is given for early departure or for failure to arrive without prior notice.</p>

<h2>If we cancel</h2>
<p>In the event that we must cancel your booking, you will receive a full refund of all payments made, or the option to rebook on alternative dates.</p>

<h2>Check-in and check-out</h2>
<p>Check-in is from 15:00. Check-out is by 11:00. If your accessibility requirements mean a different time would help, let us know when booking and we will accommodate where possible.</p>

<h2>Number of guests</h2>
<p>The property has a maximum occupancy confirmed at the time of booking. This number must not be exceeded without prior written agreement.</p>

<h2>Accessibility equipment</h2>
<p>The property includes a ceiling track hoist, profiling bed, wet room, and other accessibility features. Please use all equipment safely and only for its intended purpose. Report any fault or problem to us immediately so we can resolve it promptly. Equipment must be left in the condition and position in which it was found.</p>

<h2>Assistance dogs</h2>
<p>Dogs are allowed, subject to risk assessment and prior notice.</p>

<h2>Smoking and vaping</h2>
<p>Smoking and vaping are not permitted inside the property. If you smoke, please do so outside and dispose of waste safely.</p>

<h2>Care of the property</h2>
<p>Please take reasonable care of the bungalow and its contents. Report any breakages or damage as soon as they occur. Please leave the property in a tidy condition on departure: lights off, windows closed, doors locked, and used towels left in the bathroom.</p>

<h2>Care support</h2>
<p>Optional care can be arranged with Continuity of Care Services, a CQC-regulated provider. Their own terms and privacy notices apply to the care they deliver. ' . $entity . ' introduces that service only and takes no responsibility for the care provided.</p>

<h2>Liability</h2>
<p>To the extent permitted by law, ' . $entity . ' is not liable for loss, injury, or damage to guests or their belongings during a stay, except where caused directly by our negligence. Guests are responsible for holding adequate travel, cancellation, and personal insurance.</p>

<h2>Your data</h2>
<p>We handle your personal information in line with our <a href="' . $privacy . '">privacy policy</a>.</p>

<h2>Contact</h2>
<p>Questions about these terms: use <a href="' . $enquire . '">our enquiry page</a> or email <a href="' . $mailto . '">' . esc_html( $email ) . '</a>.</p>

<p><em>Last updated: ' . esc_html( gmdate( 'F Y' ) ) . '.</em></p>';
}

/**
 * Website accessibility statement body HTML (template-accessibility-policy).
 *
 * @return string HTML string.
 */
function restwell_get_accessibility_policy_content(): string {
	$site   = esc_html( get_bloginfo( 'name' ) );
	$host   = esc_html( restwell_get_public_site_host() );
	$acc    = esc_url( home_url( '/accessibility/' ) );
	$enq    = esc_url( home_url( '/enquire/' ) );
	$email  = restwell_get_public_enquiry_email();
	$mailto = esc_url( 'mailto:' . $email );

	return '<h2>Our aim</h2>
<p>' . $site . ' aims to make ' . $host . ' as easy to use and understand as we can for guests, families, carers, and professionals. We aim to meet Web Content Accessibility Guidelines (WCAG) 2.2 Level AA where it is reasonably practicable for our pages, forms, and theme.</p>

<h2>How we test</h2>
<p>We combine automated checks with manual testing: keyboard-only navigation, text zoom to at least 200%, and common browser and screen reader pairings. We fix issues we can control when we update the site.</p>

<h2>Property access information</h2>
<p>Door widths, equipment, and room layout for the bungalow are on our <a href="' . $acc . '">accessibility specification</a> page. This statement is about the website, not the bricks-and-mortar property.</p>

<h2>Third-party content</h2>
<p>Some pages include embedded maps, video, or links to other organisations. We cannot guarantee how accessible those services are. If something blocks you, tell us and we will try to provide an alternative where we can.</p>

<h2>Feedback and help</h2>
<p>If any part of this site does not work for you, or you need information in another format, email <a href="' . $mailto . '">' . esc_html( $email ) . '</a> or use our <a href="' . $enq . '">enquiry form</a>. We aim to reply within 48 hours.</p>

<h2>Formal complaints</h2>
<p>If you are not satisfied with our response, the <a href="https://www.equalityhumanrights.com/en" target="_blank" rel="noopener noreferrer">Equality and Human Rights Commission (EHRC)<span class="sr-only"> (opens in new tab)</span></a> publishes guidance on accessibility rights in England, Scotland, and Wales.</p>

<p><em>Last updated: ' . esc_html( gmdate( 'F Y' ) ) . '.</em></p>';
}

/**
 * Default Page Content Fields for Privacy Policy template.
 *
 * @return array<string, mixed>
 */
function restwell_get_privacy_policy_page_defaults() {
	return array(
		'legal_label'         => 'Your information',
		'legal_heading'       => 'Privacy Policy',
		'legal_intro'         => 'Who is responsible for your data, what we collect when you enquire or book, cookies, retention, and your UK GDPR rights (including contacting the ICO).',
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
		'legal_heading'       => 'Terms & Conditions',
		'legal_intro'         => 'Booking confirmation, payment, cancellation terms, accessibility and exceptional circumstances, house rules, optional care via Continuity of Care Services, and liability.',
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
		'legal_heading'       => 'Website accessibility statement',
		'legal_intro'         => 'WCAG-oriented testing, known limits of third-party embeds, and how to request alternative formats or report a barrier.',
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
		'Resources'     => 'restwell_get_resources_page_defaults',
		'Guest Guide'          => 'restwell_get_guest_guide_page_defaults',
		'Privacy Policy'       => 'restwell_get_privacy_policy_page_defaults',
		'Terms & Conditions'   => 'restwell_get_terms_conditions_page_defaults',
		'Accessibility Policy' => 'restwell_get_accessibility_policy_page_defaults',
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
