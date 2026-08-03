<?php
/**
 * Template Name: Pricing
 * Accessible holiday pricing: bungalow rates, funding routes, care guide rates, FAQ.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$pid     = get_the_ID();
$pricing = function_exists( 'restwell_get_pricing' ) ? restwell_get_pricing() : array();

$pricing_hero_image_id = (int) get_post_meta( $pid, 'pricing_hero_image_id', true );
$pricing_label         = get_post_meta( $pid, 'pricing_label', true ) ?: 'Pricing';
$pricing_heading       = get_post_meta( $pid, 'pricing_heading', true ) ?: 'Pricing for your accessible Whitstable break';
$pricing_subheading    = get_post_meta( $pid, 'pricing_subheading', true ) ?: 'Transparent accessible holiday pricing in Whitstable: the bungalow, optional care and every funding route explained.';
$pricing_intro         = get_post_meta( $pid, 'pricing_intro', true ) ?: 'Restwell Retreats is a step-free, single-storey bungalow in Whitstable, and when you book it, the whole house is yours. The access equipment listed on this page is included in the bungalow rate. Extra kit we need to hire in is charged separately. This page explains what is included, how payment works, common funding routes, and what else to budget for. If anything is unclear, we are always happy to talk it through before you book.';

$pricing_hero_cta_text    = get_post_meta( $pid, 'pricing_hero_cta_text', true ) ?: 'Check dates and care availability';
$pricing_hero_cta_url     = esc_url( get_post_meta( $pid, 'pricing_hero_cta_url', true ) ?: home_url( '/enquire/' ) );
$pricing_hero_cta_promise = get_post_meta( $pid, 'pricing_hero_cta_promise', true ) ?: 'No booking commitment, just a conversation.';
$pricing_tldr_markup      = function_exists( 'restwell_get_tldr_markup' ) ? restwell_get_tldr_markup( $pid, '' ) : '';

$pricing_append_after_h1 = '';
if ( $pricing_subheading !== '' ) {
	$pricing_append_after_h1 .= '<p class="mt-3 max-w-prose text-white/95 font-sans text-base sm:text-lg font-normal leading-relaxed tracking-normal m-0 [text-shadow:0_2px_4px_rgba(0,0,0,0.3)]">' . esc_html( $pricing_subheading ) . '</p>';
}
if ( $pricing_tldr_markup !== '' ) {
	$pricing_append_after_h1 .= $pricing_tldr_markup;
}

$off_peak = isset( $pricing['seasons']['off_peak'] ) ? $pricing['seasons']['off_peak'] : array();
$peak     = isset( $pricing['seasons']['peak'] ) ? $pricing['seasons']['peak'] : array();
$care     = isset( $pricing['care'] ) && is_array( $pricing['care'] ) ? $pricing['care'] : array();

$peak_labels = function_exists( 'restwell_get_peak_season_labels_sentence' )
	? restwell_get_peak_season_labels_sentence()
	: '';

$deposit_pct = isset( $pricing['deposit_percent'] ) ? (int) $pricing['deposit_percent'] : 50;
$timeline    = function_exists( 'restwell_get_payment_timeline' ) ? restwell_get_payment_timeline() : array();
$terms_url   = home_url( '/terms-and-conditions/' );
$enquire_url = home_url( '/enquire/' );
// TODO(dates): restore home_url( '/dates/' ) when /dates/ ships. Interim CTAs use /enquire/.

$faq_pairs = function_exists( 'restwell_get_faq_items' ) ? restwell_get_faq_items( 'pricing' ) : array();

$included_items = array(
	__( 'The whole single-storey, step-free bungalow, sleeping up to 5 people', 'restwell-retreats' ),
	__( 'The accessible bedroom with two profiling beds and full-room-coverage ceiling track hoist', 'restwell-retreats' ),
	__( 'A mobile hoist and a Sara Stedy stand aid', 'restwell-retreats' ),
	__( 'A level-access wet room with a fixed grab-rail, a tilt-in-space shower chair, a shower stool and a Geberit AquaClean wash-dry WC, plus a height-adjustable wheel-under basin', 'restwell-retreats' ),
	__( 'A second bedroom with a double bed, and a sofa bed in the conservatory', 'restwell-retreats' ),
	__( 'An open-plan living and kitchen area with a lowered wheel-under worktop and a riser-recliner chair', 'restwell-retreats' ),
	__( 'An enclosed wheelchair-accessible garden with a patio and BBQ area', 'restwell-retreats' ),
	__( 'A private driveway for two cars, with additional street parking', 'restwell-retreats' ),
	__( 'A welcome hamper on arrival, and a dog-friendly home throughout', 'restwell-retreats' ),
);

$sections = array(
	array(
		'id'      => 'pricing-rates',
		'label'   => 'Our rates',
		'eyebrow' => 'Bungalow rates',
	),
	array(
		'id'      => 'pricing-included',
		'label'   => 'What is included',
		'eyebrow' => 'Included as standard',
	),
	array(
		'id'      => 'pricing-equipment',
		'label'   => 'Access equipment',
		'eyebrow' => 'On-site kit',
	),
	array(
		'id'      => 'pricing-payment',
		'label'   => 'How payment works',
		'eyebrow' => 'Deposits and balance',
	),
	array(
		'id'      => 'pricing-funding',
		'label'   => 'Funding routes',
		'eyebrow' => 'Three ways to fund',
	),
	array(
		'id'      => 'pricing-care',
		'label'   => 'Optional care',
		'eyebrow' => 'Guide rates',
	),
	array(
		'id'      => 'pricing-budget',
		'label'   => 'What else to budget for',
		'eyebrow' => 'Beyond the stay',
	),
	array(
		'id'      => 'pricing-accessible-booking',
		'label'   => 'Accessible booking',
		'eyebrow' => 'Before you commit',
	),
	array(
		'id'      => 'pricing-faq',
		'label'   => 'Common questions',
		'eyebrow' => 'FAQ',
	),
);

$prose_class = 'restwell-resources-body restwell-prose-readable rw-measure-readable text-gray-600 leading-relaxed prose prose-sm max-w-none prose-a:text-[var(--deep-teal)] prose-a:underline hover:prose-a:no-underline prose-strong:text-[var(--deep-teal)]';
?>
<main class="flex-1 restwell-pricing-page" id="main-content">
<?php get_template_part( 'template-parts/breadcrumb' ); ?>

	<?php
	set_query_var(
		'args',
		array(
			'heading_id'           => 'page-hero-heading',
			'label'                => $pricing_label,
			'heading'              => $pricing_heading,
			'intro'                => $pricing_intro,
			'media_id'             => $pricing_hero_image_id,
			'append_after_h1_html' => $pricing_append_after_h1,
			'cta_primary'          => $pricing_hero_cta_text !== '' ? array(
				'label' => $pricing_hero_cta_text,
				'url'   => $pricing_hero_cta_url,
			) : array(),
			'cta_promise'          => $pricing_hero_cta_promise,
		)
	);
	get_template_part( 'template-parts/interior-hero' );
	?>

	<?php /* Mobile TOC: horizontal chips only — not sticky, so it does not fight the bottom CTA. */ ?>
	<div class="md:hidden bg-white/95 border-b border-gray-100 py-3 overflow-x-auto" data-pricing-toc="mobile" aria-label="<?php esc_attr_e( 'Jump to section', 'restwell-retreats' ); ?>">
		<div class="container">
			<p class="text-xs font-semibold uppercase tracking-[0.15em] text-[var(--muted-grey)] mb-2"><?php esc_html_e( 'On this page', 'restwell-retreats' ); ?></p>
			<div class="flex gap-2 min-w-max">
				<?php foreach ( $sections as $section ) : ?>
					<a href="#<?php echo esc_attr( $section['id'] ); ?>"
					   data-pricing-anchor="<?php echo esc_attr( $section['id'] ); ?>"
					   class="inline-flex items-center text-sm font-medium text-[var(--deep-teal)] bg-[var(--bg-subtle)] border border-[var(--deep-teal)]/15 px-4 py-2 rounded-full whitespace-nowrap no-underline hover:bg-[var(--deep-teal)]/10 transition-colors duration-150 motion-reduce:transition-none focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--deep-teal)]">
						<?php echo esc_html( $section['label'] ); ?>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

	<section class="rw-section-y bg-white" aria-label="<?php esc_attr_e( 'Accessible holiday pricing information', 'restwell-retreats' ); ?>">
		<div class="container max-w-6xl">
			<div class="grid md:grid-cols-[220px_1fr] gap-12 lg:gap-16 items-start">

				<nav class="hidden md:block sticky top-24 self-start" aria-label="<?php esc_attr_e( 'Page sections', 'restwell-retreats' ); ?>" data-pricing-toc="desktop">
					<p class="text-xs font-semibold uppercase tracking-[0.15em] text-[var(--muted-grey)] mb-4"><?php esc_html_e( 'On this page', 'restwell-retreats' ); ?></p>
					<ul class="space-y-1">
						<?php foreach ( $sections as $section ) : ?>
							<li>
								<a href="#<?php echo esc_attr( $section['id'] ); ?>"
								   data-pricing-anchor="<?php echo esc_attr( $section['id'] ); ?>"
								   class="block text-sm text-[var(--deep-teal)] py-1.5 px-3 rounded-lg hover:bg-[var(--bg-subtle)] transition-colors duration-150 motion-reduce:transition-none no-underline focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--deep-teal)]">
									<?php echo esc_html( $section['label'] ); ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</nav>

				<div class="space-y-12 md:space-y-20 min-w-0 overflow-x-hidden">

					<div id="pricing-rates" class="scroll-mt-24 rw-card-elevated rw-card-pad">
						<div class="rw-stack">
							<div class="rw-section-head rw-section-head--left">
								<p class="section-label"><?php echo esc_html( $sections[0]['eyebrow'] ); ?></p>
								<h2 class="text-2xl md:text-3xl font-serif text-[var(--deep-teal)] m-0"><?php esc_html_e( 'Our rates', 'restwell-retreats' ); ?></h2>
							</div>
							<div class="<?php echo esc_attr( $prose_class ); ?>">
								<p><?php esc_html_e( 'You book the whole bungalow, and the rate depends on the time of year and whether your nights fall midweek or at the weekend. Midweek nights are Monday to Thursday, and weekend nights are Friday, Saturday and Sunday.', 'restwell-retreats' ); ?></p>
							</div>
							<?php if ( ! empty( $off_peak ) && ! empty( $peak ) ) : ?>
							<div class="rw-table-wrap">
								<table class="rw-table rw-table--stack w-full text-left text-sm">
									<caption class="sr-only"><?php esc_html_e( 'Bungalow rates by season', 'restwell-retreats' ); ?></caption>
									<thead class="border-b border-gray-200">
										<tr>
											<th scope="col" class="pb-3 pr-6 font-semibold text-[var(--deep-teal)]"><?php esc_html_e( 'Time of year', 'restwell-retreats' ); ?></th>
											<th scope="col" class="pb-3 pr-6 font-semibold text-[var(--deep-teal)] text-right"><?php esc_html_e( 'Full week (7 nights)', 'restwell-retreats' ); ?></th>
											<th scope="col" class="pb-3 pr-6 font-semibold text-[var(--deep-teal)] text-right"><?php esc_html_e( 'Midweek night (Mon to Thu)', 'restwell-retreats' ); ?></th>
											<th scope="col" class="pb-3 font-semibold text-[var(--deep-teal)] text-right"><?php esc_html_e( 'Weekend night (Fri, Sat, Sun)', 'restwell-retreats' ); ?></th>
										</tr>
									</thead>
									<tbody class="divide-y divide-gray-100">
										<tr>
											<th scope="row" class="py-3 pr-6 font-medium text-gray-800 text-left">
												<span class="inline-flex flex-wrap items-center gap-2">
													<?php echo esc_html( $off_peak['label'] ); ?>
													<span class="inline-flex items-center rounded-full border border-gray-200 bg-[var(--bg-subtle)] px-2.5 py-0.5 text-xs font-medium text-[var(--deep-teal)]"><?php esc_html_e( 'Off-peak', 'restwell-retreats' ); ?></span>
												</span>
											</th>
											<td class="py-3 pr-6 text-right font-semibold text-gray-800" data-label="<?php esc_attr_e( 'Full week (7 nights)', 'restwell-retreats' ); ?>"><?php echo esc_html( restwell_format_gbp( $off_peak['full_week'] ) ); ?></td>
											<td class="py-3 pr-6 text-right font-semibold text-gray-800" data-label="<?php esc_attr_e( 'Midweek night (Mon to Thu)', 'restwell-retreats' ); ?>"><?php echo esc_html( restwell_format_gbp( $off_peak['midweek_night'] ) ); ?></td>
											<td class="py-3 text-right font-semibold text-gray-800" data-label="<?php esc_attr_e( 'Weekend night (Fri, Sat, Sun)', 'restwell-retreats' ); ?>"><?php echo esc_html( restwell_format_gbp( $off_peak['weekend_night'] ) ); ?></td>
										</tr>
										<tr>
											<th scope="row" class="py-3 pr-6 font-medium text-gray-800 text-left">
												<span class="inline-flex flex-wrap items-center gap-2">
													<?php echo esc_html( $peak['label'] ); ?>
													<span class="inline-flex items-center rounded-full border border-[var(--warm-gold-text)]/25 bg-[var(--bg-subtle)] px-2.5 py-0.5 text-xs font-medium text-[var(--warm-gold-text)]"><?php esc_html_e( 'Peak', 'restwell-retreats' ); ?></span>
												</span>
											</th>
											<td class="py-3 pr-6 text-right font-semibold text-gray-800" data-label="<?php esc_attr_e( 'Full week (7 nights)', 'restwell-retreats' ); ?>"><?php echo esc_html( restwell_format_gbp( $peak['full_week'] ) ); ?></td>
											<td class="py-3 pr-6 text-right font-semibold text-gray-800" data-label="<?php esc_attr_e( 'Midweek night (Mon to Thu)', 'restwell-retreats' ); ?>"><?php echo esc_html( restwell_format_gbp( $peak['midweek_night'] ) ); ?></td>
											<td class="py-3 text-right font-semibold text-gray-800" data-label="<?php esc_attr_e( 'Weekend night (Fri, Sat, Sun)', 'restwell-retreats' ); ?>"><?php echo esc_html( restwell_format_gbp( $peak['weekend_night'] ) ); ?></td>
										</tr>
									</tbody>
								</table>
							</div>
							<?php endif; ?>
							<div class="<?php echo esc_attr( $prose_class ); ?>">
								<p>
									<?php
									esc_html_e( 'These rates are for the bungalow only and do not include optional care. Peak season covers the UK school holidays: ', 'restwell-retreats' );
									echo esc_html( $peak_labels );
									echo wp_kses(
										__( '. Every other date is off-peak. <strong>There is no minimum stay</strong>, so you can book a single night or a full week.', 'restwell-retreats' ),
										array( 'strong' => array() )
									);
									?>
								</p>
								<p>
									<?php
									echo wp_kses(
										__( '<strong>The same rates apply to every guest, whatever funding route you use.</strong> The funding routes below affect who we invoice and how. They do not change the price of the bungalow itself.', 'restwell-retreats' ),
										array( 'strong' => array() )
									);
									?>
								</p>
							</div>
						</div>
					</div>

					<div id="pricing-included" class="scroll-mt-24 rw-card-solid rw-card-pad">
						<div class="rw-stack">
							<div class="rw-section-head rw-section-head--left">
								<p class="section-label"><?php echo esc_html( $sections[1]['eyebrow'] ); ?></p>
								<h2 class="text-2xl md:text-3xl font-serif text-[var(--deep-teal)] m-0"><?php esc_html_e( 'What is included in the price', 'restwell-retreats' ); ?></h2>
							</div>
							<div class="<?php echo esc_attr( $prose_class ); ?>">
								<p><?php esc_html_e( 'One booking gives you the entire bungalow and grounds, with all of the following included as standard:', 'restwell-retreats' ); ?></p>
							</div>
							<ul class="m-0 grid list-none grid-cols-1 gap-3 p-0 md:grid-cols-2 md:gap-x-8 md:gap-y-3">
								<?php foreach ( $included_items as $item ) : ?>
									<li class="flex gap-2.5 items-start">
										<span class="mt-0.5 shrink-0 text-[var(--deep-teal)]" aria-hidden="true"><i class="ph-bold ph-check text-[1.05rem]" aria-hidden="true"></i></span>
										<span class="text-gray-700 leading-relaxed"><?php echo esc_html( $item ); ?></span>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>

					<div id="pricing-equipment" class="scroll-mt-24 rw-card-solid rw-card-pad">
						<div class="rw-stack">
							<div class="rw-section-head rw-section-head--left">
								<p class="section-label"><?php echo esc_html( $sections[2]['eyebrow'] ); ?></p>
								<h2 class="text-2xl md:text-3xl font-serif text-[var(--deep-teal)] m-0"><?php esc_html_e( 'On-site access equipment is included', 'restwell-retreats' ); ?></h2>
							</div>
							<div class="<?php echo esc_attr( $prose_class ); ?>">
								<p><?php esc_html_e( 'At many holiday properties the room rate is only the start, and hoists, profiling beds and shower chairs are charged as hire extras. At Restwell the equipment listed above is part of the bungalow rate. Guests bring their own slings for hygiene reasons. If you need any other specialist item we do not hold, tell us when you enquire and we can help arrange hire — those hire costs are charged separately.', 'restwell-retreats' ); ?></p>
							</div>
						</div>
					</div>

					<div id="pricing-payment" class="scroll-mt-24 rw-card-solid rw-card-pad">
						<div class="rw-stack">
							<div class="rw-section-head rw-section-head--left">
								<p class="section-label"><?php echo esc_html( $sections[3]['eyebrow'] ); ?></p>
								<h2 class="text-2xl md:text-3xl font-serif text-[var(--deep-teal)] m-0"><?php esc_html_e( 'How payment works', 'restwell-retreats' ); ?></h2>
							</div>
							<div class="<?php echo esc_attr( $prose_class ); ?> prose-ol:my-4">
								<ol>
									<li>
										<?php
										printf(
											/* translators: %d: deposit percentage */
											esc_html__( 'A %d%% deposit secures your chosen dates and takes the bungalow off the calendar for everyone else.', 'restwell-retreats' ),
											isset( $timeline['deposit_percent'] ) ? (int) $timeline['deposit_percent'] : (int) $deposit_pct
										);
										?>
									</li>
									<li>
										<?php
										printf(
											/* translators: %s: balance due clause e.g. "no later than one week before you arrive" */
											esc_html__( 'The remaining balance is due %s.', 'restwell-retreats' ),
											esc_html( isset( $timeline['balance_due_clause_you'] ) ? $timeline['balance_due_clause_you'] : __( 'no later than one week before you arrive', 'restwell-retreats' ) )
										);
										?>
									</li>
									<li><?php esc_html_e( 'We send a clear written invoice at each stage, so you always know what has been paid and what is left.', 'restwell-retreats' ); ?></li>
								</ol>
								<p>
									<?php
									printf(
										/* translators: %d: deposit percentage */
										wp_kses(
											__( '<strong>There is no minimum stay, no security or damage deposit, and no end-of-stay cleaning fee.</strong> The %d%% deposit and the balance before arrival are all you pay for the bungalow itself. (Nightly and weekly rates are in the rates table above.)', 'restwell-retreats' ),
											array( 'strong' => array() )
										),
										isset( $timeline['deposit_percent'] ) ? (int) $timeline['deposit_percent'] : (int) $deposit_pct
									);
									?>
								</p>
								<p>
									<?php
									$check_in  = isset( $timeline['check_in'] ) ? (string) $timeline['check_in'] : '15:00';
									$check_out = isset( $timeline['check_out'] ) ? (string) $timeline['check_out'] : '11:00';
									echo wp_kses(
										sprintf(
											/* translators: 1: check-in time, 2: check-out time, 3: terms URL */
											__( 'Check-in is from %1$s and check-out is by %2$s. For cancellations and refunds, see our <a class="rw-link-prose" href="%3$s">terms and cancellation policy</a>.', 'restwell-retreats' ),
											esc_html( $check_in ),
											esc_html( $check_out ),
											esc_url( $terms_url )
										),
										array(
											'a' => array(
												'href'  => array(),
												'class' => array(),
											),
										)
									);
									?>
								</p>
							</div>
						</div>
					</div>

					<div id="pricing-funding" class="scroll-mt-24">
						<div class="bg-[var(--bg-subtle)] rounded-2xl p-6 md:p-8 border border-gray-100 rw-stack">
							<div class="rw-section-head rw-section-head--left">
								<p class="section-label"><?php echo esc_html( $sections[4]['eyebrow'] ); ?></p>
								<h2 class="text-2xl md:text-3xl font-serif text-[var(--deep-teal)] m-0"><?php esc_html_e( 'Three ways to fund your stay', 'restwell-retreats' ); ?></h2>
							</div>
							<div class="<?php echo esc_attr( $prose_class ); ?>">
								<p><?php esc_html_e( 'Most guests book through one of three routes. The table gives the quick version, and the notes below add the detail.', 'restwell-retreats' ); ?></p>
							</div>
							<div class="rw-table-wrap">
								<table class="rw-table rw-table--stack w-full text-left text-sm">
									<caption class="sr-only"><?php esc_html_e( 'Funding routes for a Restwell stay', 'restwell-retreats' ); ?></caption>
									<thead class="border-b border-gray-200">
										<tr>
											<th scope="col" class="pb-3 pr-6 font-semibold text-[var(--deep-teal)]"><?php esc_html_e( 'Funding route', 'restwell-retreats' ); ?></th>
											<th scope="col" class="pb-3 pr-6 font-semibold text-[var(--deep-teal)]"><?php esc_html_e( 'Who it suits', 'restwell-retreats' ); ?></th>
											<th scope="col" class="pb-3 font-semibold text-[var(--deep-teal)]"><?php esc_html_e( 'How it works', 'restwell-retreats' ); ?></th>
										</tr>
									</thead>
									<tbody class="divide-y divide-gray-100">
										<tr>
											<th scope="row" class="py-3 pr-6 font-medium text-gray-800 align-top text-left"><?php esc_html_e( 'Private', 'restwell-retreats' ); ?></th>
											<td class="py-3 pr-6 text-gray-700 align-top" data-label="<?php esc_attr_e( 'Who it suits', 'restwell-retreats' ); ?>"><?php esc_html_e( 'Anyone booking a self-catering break directly', 'restwell-retreats' ); ?></td>
											<td class="py-3 text-gray-700 align-top" data-label="<?php esc_attr_e( 'How it works', 'restwell-retreats' ); ?>"><?php esc_html_e( 'Pay the deposit to secure dates, then the balance before arrival.', 'restwell-retreats' ); ?></td>
										</tr>
										<tr>
											<th scope="row" class="py-3 pr-6 font-medium text-gray-800 align-top text-left"><?php esc_html_e( 'Case-managed', 'restwell-retreats' ); ?></th>
											<td class="py-3 pr-6 text-gray-700 align-top" data-label="<?php esc_attr_e( 'Who it suits', 'restwell-retreats' ); ?>"><?php esc_html_e( 'Case managers and commissioners booking for a client', 'restwell-retreats' ); ?></td>
											<td class="py-3 text-gray-700 align-top" data-label="<?php esc_attr_e( 'How it works', 'restwell-retreats' ); ?>"><?php esc_html_e( 'We invoice your organisation and provide an access statement and quote up front. We accept purchase orders, with payment due before the stay.', 'restwell-retreats' ); ?></td>
										</tr>
										<tr>
											<th scope="row" class="py-3 pr-6 font-medium text-gray-800 align-top text-left"><?php esc_html_e( 'NHS Continuing Healthcare (CHC)', 'restwell-retreats' ); ?></th>
											<td class="py-3 pr-6 text-gray-700 align-top" data-label="<?php esc_attr_e( 'Who it suits', 'restwell-retreats' ); ?>"><?php esc_html_e( 'Guests with CHC-funded respite', 'restwell-retreats' ); ?></td>
											<td class="py-3 text-gray-700 align-top" data-label="<?php esc_attr_e( 'How it works', 'restwell-retreats' ); ?>"><?php esc_html_e( 'We work with your funding contact to confirm what the respite budget covers, then invoice the funder, with payment due before the stay.', 'restwell-retreats' ); ?></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="<?php echo esc_attr( $prose_class ); ?>">
								<p><strong><?php esc_html_e( 'Private bookings.', 'restwell-retreats' ); ?></strong> <?php esc_html_e( 'The most straightforward route. You choose your dates, pay the deposit to secure them, and settle the balance a week before arrival. This is also the route most families use when they are paying towards a break themselves.', 'restwell-retreats' ); ?></p>
								<p><strong><?php esc_html_e( 'Case-managed and commissioned bookings.', 'restwell-retreats' ); ?></strong> <?php esc_html_e( 'If you are a case manager, social worker or commissioner arranging a stay for someone you support, we can provide a written quote and a detailed access statement up front so you have everything you need for sign-off. We invoice your organisation directly, and we are happy to accept a purchase order. Payment simply needs to clear before the stay, on the same timeline as every booking.', 'restwell-retreats' ); ?></p>
								<p><strong><?php esc_html_e( 'NHS Continuing Healthcare (CHC) respite.', 'restwell-retreats' ); ?></strong> <?php esc_html_e( 'If the person staying has CHC funding that includes respite, we will work with your named funding contact to confirm what the budget covers before anything is booked, then invoice the funder directly, with payment due before the stay.', 'restwell-retreats' ); ?></p>
								<p><strong><?php esc_html_e( 'Direct payments and personal budgets.', 'restwell-retreats' ); ?></strong> <?php esc_html_e( 'If you receive a Care Act personal budget or a direct payment, you can usually use it towards a respite break here. In practice this sits under the private or case-managed route depending on who holds the budget. Talk to us and we will help you work out the cleanest way to arrange it.', 'restwell-retreats' ); ?></p>
								<p>
									<?php
									echo wp_kses(
										sprintf(
											/* translators: %s: resources page URL */
											__( 'For more on Kent funding routes, grants and CHC, see our <a class="rw-link-prose" href="%s">Funding &amp; Support</a> hub.', 'restwell-retreats' ),
											esc_url( home_url( '/resources/' ) )
										),
										array(
											'a' => array(
												'href'  => array(),
												'class' => array(),
											),
										)
									);
									?>
								</p>
							</div>
							<p class="m-0">
								<a href="<?php echo esc_url( $enquire_url ); ?>" class="btn btn-gold" data-cta="pricing-funding-primary">
									<?php esc_html_e( 'Check dates and care availability', 'restwell-retreats' ); ?>
									<i class="ph-bold ph-caret-right" aria-hidden="true"></i>
								</a>
							</p>
						</div>
					</div>

					<div id="pricing-care" class="scroll-mt-24 rw-card-elevated rw-card-pad">
						<div class="rw-stack">
							<div class="rw-section-head rw-section-head--left">
								<p class="section-label"><?php echo esc_html( $sections[5]['eyebrow'] ); ?></p>
								<h2 class="text-2xl md:text-3xl font-serif text-[var(--deep-teal)] m-0"><?php esc_html_e( 'Optional care while you stay', 'restwell-retreats' ); ?></h2>
							</div>
							<div class="<?php echo esc_attr( $prose_class ); ?>">
								<p><?php esc_html_e( 'Care is never bundled into the price of the bungalow, so you only ever pay for the support you actually want. Through our sister company, Continuity of Care Services, a CQC-regulated provider, you can add anything from a few hours of companionship a day up to full 24-hour support. Because the care team and the property are part of the same family, your support can be arranged alongside your booking rather than chased separately.', 'restwell-retreats' ); ?></p>
								<p>
									<?php
									esc_html_e( 'We believe in being open about what care costs, so the table below shows the current Continuity of Care Services guide rates. ', 'restwell-retreats' );
									$guide_intro = isset( $care['guide_intro'] ) ? (string) $care['guide_intro'] : '';
									if ( $guide_intro !== '' ) {
										// Emphasise the existing "starting points" phrase only (no new copy).
										$guide_emphasised = preg_replace(
											'/^(Think of them as )(starting points)(:)/',
											'$1<strong>$2</strong>$3',
											$guide_intro,
											1
										);
										echo wp_kses(
											$guide_emphasised ? $guide_emphasised : esc_html( $guide_intro ),
											array( 'strong' => array() )
										);
										echo ' ';
									}
									esc_html_e( 'These guide rates are correct at the time of writing and are next reviewed on 1 September 2026.', 'restwell-retreats' );
									?>
								</p>
							</div>
							<?php if ( ! empty( $care['rows'] ) && is_array( $care['rows'] ) ) : ?>
							<?php
							$care_row_groups = array(
								0 => 'day',
								1 => 'overnight',
								2 => 'day',
								3 => 'day',
								4 => 'overnight',
								5 => 'fixed',
								6 => 'fixed',
							);
							?>
							<div class="rw-table-wrap">
								<table class="rw-table rw-table--stack rw-table--care w-full text-left text-sm">
									<caption class="sr-only"><?php esc_html_e( 'Continuity of Care Services guide rates (from / guide)', 'restwell-retreats' ); ?></caption>
									<thead class="border-b border-gray-200">
										<tr>
											<th scope="col" class="pb-3 pr-6 font-semibold text-[var(--deep-teal)]"><?php esc_html_e( 'Type of support', 'restwell-retreats' ); ?></th>
											<th scope="col" class="pb-3 pr-6 font-semibold text-[var(--deep-teal)] text-right"><?php esc_html_e( 'From, weekday (Mon to Fri)', 'restwell-retreats' ); ?></th>
											<th scope="col" class="pb-3 font-semibold text-[var(--deep-teal)] text-right"><?php esc_html_e( 'From, weekend (Sat to Sun)', 'restwell-retreats' ); ?></th>
										</tr>
									</thead>
									<tbody class="divide-y divide-gray-100">
										<?php foreach ( $care['rows'] as $row_i => $row ) : ?>
										<?php
										$group = isset( $care_row_groups[ $row_i ] ) ? $care_row_groups[ $row_i ] : 'day';
										$group_class = 'rw-table__row--' . $group;
										?>
										<tr class="<?php echo esc_attr( $group_class ); ?>">
											<th scope="row" class="py-3 pr-6 font-medium text-gray-800 align-top text-left"><?php echo esc_html( $row['type'] ); ?></th>
											<td class="py-3 pr-6 text-right font-semibold text-gray-800 align-top" data-label="<?php esc_attr_e( 'From, weekday (Mon to Fri)', 'restwell-retreats' ); ?>"><?php echo esc_html( $row['weekday_display'] ); ?></td>
											<td class="py-3 text-right font-semibold text-gray-800 align-top" data-label="<?php esc_attr_e( 'From, weekend (Sat to Sun)', 'restwell-retreats' ); ?>"><?php echo esc_html( $row['weekend_display'] ); ?></td>
										</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
							<p class="text-sm text-gray-500 m-0"><?php esc_html_e( 'All care figures above are guide / from rates, confirmed after a free conversation with Continuity of Care Services.', 'restwell-retreats' ); ?></p>
							<?php endif; ?>
							<?php if ( ! empty( $care['notes'] ) && is_array( $care['notes'] ) ) : ?>
							<div class="<?php echo esc_attr( $prose_class ); ?> prose-li:my-1.5">
								<p><strong><?php esc_html_e( 'Notes on care pricing:', 'restwell-retreats' ); ?></strong></p>
								<ul>
									<?php foreach ( $care['notes'] as $note ) : ?>
										<li><?php echo esc_html( $note ); ?></li>
									<?php endforeach; ?>
								</ul>
							</div>
							<?php endif; ?>
							<p class="m-0">
								<a href="<?php echo esc_url( $enquire_url ); ?>" class="btn btn-outline">
									<?php esc_html_e( 'Arrange a care conversation', 'restwell-retreats' ); ?>
									<i class="ph-bold ph-arrow-right" aria-hidden="true"></i>
								</a>
							</p>
						</div>
					</div>

					<div id="pricing-budget" class="scroll-mt-24 rw-card-solid rw-card-pad">
						<div class="rw-stack">
							<div class="rw-section-head rw-section-head--left">
								<p class="section-label"><?php echo esc_html( $sections[6]['eyebrow'] ); ?></p>
								<h2 class="text-2xl md:text-3xl font-serif text-[var(--deep-teal)] m-0"><?php esc_html_e( 'What else to budget for', 'restwell-retreats' ); ?></h2>
							</div>
							<div class="<?php echo esc_attr( $prose_class ); ?> prose-li:my-1.5">
								<p><?php esc_html_e( 'Beyond the stay itself, it helps to plan for:', 'restwell-retreats' ); ?></p>
								<ul>
									<li><?php esc_html_e( 'Travel to Whitstable and any accessible transport you need on arrival', 'restwell-retreats' ); ?></li>
									<li><?php esc_html_e( 'Optional care support, if you would like it', 'restwell-retreats' ); ?></li>
									<li><?php esc_html_e( 'Hire of any specialist equipment we do not already provide (charged separately)', 'restwell-retreats' ); ?></li>
									<li><?php esc_html_e( 'Food and days out, though the kitchen means you can self-cater as much as you like', 'restwell-retreats' ); ?></li>
								</ul>
							</div>
						</div>
					</div>

					<div id="pricing-accessible-booking" class="scroll-mt-24 rw-card-solid rw-card-pad">
						<div class="rw-stack">
							<div class="rw-section-head rw-section-head--left">
								<p class="section-label"><?php echo esc_html( $sections[7]['eyebrow'] ); ?></p>
								<h2 class="text-2xl md:text-3xl font-serif text-[var(--deep-teal)] m-0"><?php esc_html_e( 'Booking is built to be accessible too', 'restwell-retreats' ); ?></h2>
							</div>
							<div class="<?php echo esc_attr( $prose_class ); ?>">
								<p><?php esc_html_e( 'We answer access questions in writing, in plain language, before you pay anything. You can ask for exact measurements, photographs or a full access statement, and we will send them over. The aim is for you to know whether Restwell works for you before you commit a penny.', 'restwell-retreats' ); ?></p>
								<p>
									<?php
									echo wp_kses(
										sprintf(
											/* translators: 1: property URL, 2: accessibility URL, 3: how-it-works URL */
											__( 'Explore <a class="rw-link-prose" href="%1$s">the property</a>, read the <a class="rw-link-prose" href="%2$s">accessibility measurements and equipment</a>, or see <a class="rw-link-prose" href="%3$s">how booking works</a> before you enquire.', 'restwell-retreats' ),
											esc_url( home_url( '/the-property/' ) ),
											esc_url( home_url( '/accessibility/' ) ),
											esc_url( home_url( '/how-it-works/' ) )
										),
										array(
											'a' => array(
												'href'  => array(),
												'class' => array(),
											),
										)
									);
									?>
								</p>
							</div>
						</div>
					</div>

					<?php if ( ! empty( $faq_pairs ) ) : ?>
					<div id="pricing-faq" class="scroll-mt-24">
						<div class="rw-stack">
							<div class="rw-section-head rw-section-head--left">
								<p class="section-label"><?php echo esc_html( $sections[8]['eyebrow'] ); ?></p>
								<h2 class="text-2xl md:text-3xl font-serif text-[var(--deep-teal)] m-0"><?php esc_html_e( 'Common questions about pricing', 'restwell-retreats' ); ?></h2>
							</div>
							<div class="rw-stack--tight">
								<?php foreach ( $faq_pairs as $faq ) : ?>
									<details class="rw-faq-shell group">
										<summary class="text-[var(--deep-teal)] font-medium text-base py-5 min-h-[2.75rem] cursor-pointer list-none flex items-center justify-between gap-4 [&::-webkit-details-marker]:hidden rounded-xl focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--deep-teal)] focus-visible:ring-offset-2">
											<span><?php echo esc_html( $faq['q'] ); ?></span>
											<span class="flex-shrink-0 text-[var(--warm-gold-text)] transition-transform duration-200 motion-reduce:transition-none group-open:rotate-180" aria-hidden="true"><i class="ph-bold ph-caret-down"></i></span>
										</summary>
										<div class="text-gray-600 text-sm leading-relaxed pb-6"><?php echo wp_kses_post( wpautop( $faq['a'] ) ); ?></div>
									</details>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
					<?php endif; ?>

				</div>
			</div>
		</div>
	</section>

	<section id="pricing-ready" class="rw-section-y--cta bg-[var(--bg-subtle)]" aria-labelledby="pricing-cta-heading">
		<div class="container max-w-3xl">
			<div class="rw-stack text-center items-center">
				<div class="rw-section-head rw-section-head--center rw-section-head--tight mx-auto">
					<h2 id="pricing-cta-heading" class="text-3xl font-serif text-[var(--deep-teal)] m-0"><?php esc_html_e( 'Ready to plan your accessible break?', 'restwell-retreats' ); ?></h2>
				</div>
				<p class="text-center text-gray-600 text-lg leading-relaxed m-0 max-w-prose mx-auto">
					<?php esc_html_e( 'No booking commitment, just a conversation. Tell us your dates and what support would help, and we will confirm availability, answer your access questions in writing and put together a clear quote.', 'restwell-retreats' ); ?>
				</p>
				<ul class="m-0 mx-auto max-w-prose list-none space-y-2 p-0 text-left text-gray-700 leading-relaxed">
					<li class="flex gap-2.5 items-start">
						<span class="mt-0.5 shrink-0 text-[var(--deep-teal)]" aria-hidden="true"><i class="ph-bold ph-check" aria-hidden="true"></i></span>
						<span><?php esc_html_e( 'Transparent pricing with no hidden fees', 'restwell-retreats' ); ?></span>
					</li>
					<li class="flex gap-2.5 items-start">
						<span class="mt-0.5 shrink-0 text-[var(--deep-teal)]" aria-hidden="true"><i class="ph-bold ph-check" aria-hidden="true"></i></span>
						<span><?php esc_html_e( 'Step-free bungalow with listed on-site access equipment included', 'restwell-retreats' ); ?></span>
					</li>
					<li class="flex gap-2.5 items-start">
						<span class="mt-0.5 shrink-0 text-[var(--deep-teal)]" aria-hidden="true"><i class="ph-bold ph-check" aria-hidden="true"></i></span>
						<span><?php esc_html_e( 'Optional CQC-regulated care arranged alongside your stay', 'restwell-retreats' ); ?></span>
					</li>
				</ul>
				<p class="m-0">
					<a href="<?php echo esc_url( $enquire_url ); ?>" class="btn btn-gold" data-cta="pricing-closing-primary">
						<?php esc_html_e( 'Check dates and care availability', 'restwell-retreats' ); ?>
						<i class="ph-bold ph-caret-right" aria-hidden="true"></i>
					</a>
				</p>
				<?php // TODO(dates): restore a secondary CTA to /dates/ when that page ships. Interim path: /enquire/ via $dates_cta_url. ?>
			</div>
		</div>
	</section>

	<?php
	if ( function_exists( 'restwell_render_pricing_cross_links' ) ) {
		echo '<div class="container max-w-6xl">';
		restwell_render_pricing_cross_links();
		echo '</div>';
	}
	?>

	<div class="md:hidden fixed bottom-0 inset-x-0 z-40 border-t border-gray-100 bg-white/95 backdrop-blur-sm px-4 pt-2.5 pb-[max(0.5rem,env(safe-area-inset-bottom,0px))]" data-pricing-sticky-cta role="region" aria-label="<?php esc_attr_e( 'Quick booking action', 'restwell-retreats' ); ?>">
		<a href="<?php echo esc_url( $enquire_url ); ?>" class="btn btn-gold w-full justify-center min-h-11" data-cta="pricing-sticky-mobile">
			<?php esc_html_e( 'Check dates and care availability', 'restwell-retreats' ); ?>
			<i class="ph-bold ph-caret-right" aria-hidden="true"></i>
		</a>
	</div>

</main>
<?php get_footer(); ?>
