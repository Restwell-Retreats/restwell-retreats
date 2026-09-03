<?php
/**
 * Template Name: Pricing
 *
 * Concept port from mockups — Pricing.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$pricing  = restwell_get_pricing();
$seasons  = $pricing['seasons'];
$timeline = restwell_get_payment_timeline();

$rate_rows = array(
	array(
		'label' => __( 'Full week', 'restwell-retreats' ),
		'hint'  => __( '(7 nights)', 'restwell-retreats' ),
		'field' => 'full_week',
	),
	array(
		'label' => __( 'Weekend night', 'restwell-retreats' ),
		'hint'  => __( '(Fri–Sun)', 'restwell-retreats' ),
		'field' => 'weekend_night',
	),
	array(
		'label' => __( 'Midweek night', 'restwell-retreats' ),
		'hint'  => __( '(Mon–Thu)', 'restwell-retreats' ),
		'field' => 'midweek_night',
	),
);

// Example stays priced from the same season data: weekend/midnight split per stay.
$example_stays = array(
	array(
		'name'          => __( 'Weekend', 'restwell-retreats' ),
		'meta'          => __( '(Fri–Sun, 3 nights)', 'restwell-retreats' ),
		'weekend_count' => 3,
		'midweek_count' => 0,
	),
	array(
		'name'          => __( 'Midweek', 'restwell-retreats' ),
		'meta'          => __( '(Mon–Thu, 4 nights)', 'restwell-retreats' ),
		'weekend_count' => 0,
		'midweek_count' => 4,
	),
	array(
		'name'          => __( 'Long weekend', 'restwell-retreats' ),
		'meta'          => __( '(Fri–Mon, 4 nights)', 'restwell-retreats' ),
		'weekend_count' => 3,
		'midweek_count' => 1,
	),
);
?>


<main id="main-content">
<?php
$restwell_pricing_id      = (int) get_queried_object_id();
$restwell_pricing_heading = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $restwell_pricing_id, 'pricing_heading', 'What a stay here costs' )
	: 'What a stay here costs';
$restwell_pricing_intro   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $restwell_pricing_id, 'pricing_intro', 'A full week in the bungalow is £1,300 off-peak and £1,400 in peak season. Midweek nights are £185 off-peak and £200 peak, with weekend nights in the table below. A 50% deposit reserves your dates and the balance is due a week before you arrive. The rate is the same whoever we invoice.' )
	: 'A full week in the bungalow is £1,300 off-peak and £1,400 in peak season. Midweek nights are £185 off-peak and £200 peak, with weekend nights in the table below. A 50% deposit reserves your dates and the balance is due a week before you arrive. The rate is the same whoever we invoice.';
get_template_part(
	'template-parts/concept/photo-hero',
	null,
	array(
		'heading_id' => 'page-h',
		'heading'    => $restwell_pricing_heading,
		'intro'      => $restwell_pricing_intro,
		'crumbs'     => array(
			array(
				'label' => __( 'Home', 'restwell-retreats' ),
				'url'   => home_url( '/' ),
			),
			array(
				'label' => 'Pricing & dates',
				'url'   => '',
			),
		),
		'post_id'    => (int) get_queried_object_id(),
	)
);
?>

	<nav class="subnav" aria-label="On this page" data-toc>
	  <div class="container">
		<ul class="subnav__list">
		  <li><a href="#rates">Rates</a></li>
		  <li><a href="#availability">Dates</a></li>
		  <li><a href="#payment">Payment</a></li>
		  <li><a href="#care-rates">Optional care</a></li>
		  <li><a href="#faq">FAQ</a></li>
		</ul>
	  </div>
	</nav>

	<section class="section-y band-white" id="rates" aria-labelledby="rates-h">
	  <div class="container">
		<header class="section-head">
		  <p class="eyebrow">Bungalow rates</p>
		  <h2 id="rates-h">Published bungalow rates</h2>
		  <p class="lede">The bungalow sleeps five people. Prices vary for midweek (Monday to Thursday) and weekend (Friday to Sunday) nights. Care is optional and has a separate charge.</p>
		</header>
		<div class="rates-block">
		  <div class="rates-panel">
			<table class="data-table data-table--rates">
			  <caption class="sr-only">Bungalow rates by stay type and season</caption>
			  <thead>
				<tr>
				  <th scope="col">Stay type</th>
				  <th scope="col">Off-peak</th>
				  <th scope="col">Peak</th>
				</tr>
			  </thead>
			  <tbody>
<?php foreach ( $rate_rows as $rate_row ) : ?>
				<tr>
				  <th scope="row"><?php echo esc_html( $rate_row['label'] ); ?> <span class="data-table__hint"><?php echo esc_html( $rate_row['hint'] ); ?></span></th>
				  <td class="is-price" data-label="Off-peak"><?php echo esc_html( restwell_format_gbp( $seasons['off_peak'][ $rate_row['field'] ] ) ); ?></td>
				  <td class="is-price" data-label="Peak"><?php echo esc_html( restwell_format_gbp( $seasons['peak'][ $rate_row['field'] ] ) ); ?></td>
				</tr>
<?php endforeach; ?>
			  </tbody>
			</table>
			<div class="rates-examples">
			  <div class="rates-examples__head">
				<h3 class="rates-examples__title">Example stays</h3>
				<p class="rates-examples__cols" aria-hidden="true"><span>Off-peak</span><span>Peak</span></p>
			  </div>
			  <ul class="rates-examples__list">
<?php foreach ( $example_stays as $stay ) : ?>
				<li>
				  <div class="rates-examples__copy">
					<span class="rates-examples__name"><?php echo esc_html( $stay['name'] ); ?></span>
					<span class="rates-examples__meta"><?php echo esc_html( $stay['meta'] ); ?></span>
				  </div>
				  <span class="rates-examples__prices">
	<?php foreach ( array( 'off_peak', 'peak' ) as $_season_key ) : ?>
					<span class="is-price" data-label="<?php echo esc_attr( 'off_peak' === $_season_key ? 'Off-peak' : 'Peak' ); ?>"><?php echo esc_html( restwell_format_gbp( ( $stay['weekend_count'] * $seasons[ $_season_key ]['weekend_night'] ) + ( $stay['midweek_count'] * $seasons[ $_season_key ]['midweek_night'] ) ) ); ?></span>
<?php endforeach; ?>
				  </span>
				</li>
<?php endforeach; ?>
			  </ul>
			</div>
		  </div>
		  <p class="rates-follow">You can find room details and capacity on the <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'the-property' ) ); ?>">property page</a>. Equipment and measurements are listed in the <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'accessibility' ) ); ?>">access details</a>.</p>
		  <details class="peak-dates" data-peak-dates>
			<summary class="peak-dates__summary">
			  <h3 id="peak-dates-h" class="peak-dates__summary-title">Peak season dates</h3>
			  <span class="peak-dates__summary-hint">All other dates are off-peak.</span>
			  <span class="peak-dates__summary-action">
				<span class="peak-dates__action-open">Show dates</span>
				<span class="peak-dates__action-close">Hide dates</span>
				<span class="peak-dates__action-chevron" aria-hidden="true"></span>
			  </span>
			</summary>
			<ul class="peak-dates__list">
<?php foreach ( restwell_get_peak_ranges_display() as $_peak ) : ?>
			  <li><span class="peak-dates__label"><?php echo esc_html( $_peak['label'] ); ?></span><span class="peak-dates__range"><?php echo esc_html( $_peak['range'] ); ?></span></li>
<?php endforeach; ?>
			</ul>
		  </details>
		</div>
	  </div>
	</section>

	<?php
	get_template_part( 'template-parts/availability-calendar' );
	?>

	<section class="section-y band-subtle" id="payment" aria-labelledby="payment-h">
	  <div class="container">
		<header class="section-head">
		  <p class="eyebrow">Deposits and balance</p>
		  <h2 id="payment-h">How payment works</h2>
		  <p class="lede">You can pay by bank transfer or card. For information about invoicing different funders, see <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'resources' ) ); ?>">Funding &amp; Support</a>.</p>
		</header>
		<ol class="payment-steps">
		  <li class="payment-steps__item">
			<span class="payment-steps__index" aria-hidden="true">01</span>
			<div class="payment-steps__body">
			  <h3><?php echo esc_html( sprintf( /* translators: %d: deposit percentage */ __( '%d%% deposit', 'restwell-retreats' ), (int) $timeline['deposit_percent'] ) ); ?></h3>
			  <p><?php echo esc_html( __( 'This deposit secures your dates and removes the bungalow from the calendar.', 'restwell-retreats' ) ); ?></p>
			</div>
		  </li>
		  <li class="payment-steps__item">
			<span class="payment-steps__index" aria-hidden="true">02</span>
			<div class="payment-steps__body">
			  <h3>Balance before arrival</h3>
			  <p><?php echo esc_html( sprintf( /* translators: %s: balance due timing, e.g. "no later than one week before you arrive" */ __( 'The remaining balance is due %s.', 'restwell-retreats' ), $timeline['balance_due_clause_you'] ) ); ?></p>
			</div>
		  </li>
		  <li class="payment-steps__item">
			<span class="payment-steps__index" aria-hidden="true">03</span>
			<div class="payment-steps__body">
			  <h3>No extras</h3>
			  <p>We do not charge a damage deposit or a cleaning fee at the end of your stay.</p>
			</div>
		  </li>
		</ol>
		<p class="payment-note">If your plans change, our <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'terms-and-conditions' ) ); ?>">terms and cancellation policy</a> will explain what happens next.</p>
	  </div>
	</section>

	<section class="section-y band-white" id="care-rates" aria-labelledby="care-rates-h">
	  <div class="container">
		<header class="section-head section-head--tight">
		  <p class="eyebrow">Guide rates</p>
		  <h2 id="care-rates-h">Optional care while you stay</h2>
		  <p class="lede">Guide rates for care from Continuity depend on the hours and tasks you need. Continuity will give you a quote after you speak with them.</p>
		</header>
		<div class="care-rates">
		  <div class="rates-panel">
			<table class="data-table data-table--rates data-table--care">
			  <caption class="sr-only">Optional care guide rates by support type for weekday and weekend. Continuity quotes the care cost once hours and tasks are agreed.</caption>
			  <thead>
				<tr>
				  <th scope="col">Support</th>
				  <th scope="col">From, weekday</th>
				  <th scope="col">From, weekend</th>
				</tr>
			  </thead>
			  <tbody>
<?php foreach ( $pricing['care']['rows'] as $_care_row ) : ?>
				<tr>
				  <th scope="row"><?php echo esc_html( $_care_row['type_short'] ); ?> <span class="data-table__hint">(per <?php echo esc_html( $_care_row['unit'] ); ?>)</span></th>
				  <td class="is-price" data-label="Weekday"><?php echo esc_html( restwell_format_gbp( $_care_row['weekday_from'], 2 ) ); ?></td>
	<?php if ( null === $_care_row['weekend_from'] ) : ?>
				  <td class="is-price is-price--na" data-label="Weekend"><?php echo esc_html__( 'Not available at weekends', 'restwell-retreats' ); ?></td>
<?php else : ?>
				  <td class="is-price" data-label="Weekend"><?php echo esc_html( restwell_format_gbp( $_care_row['weekend_from'], 2 ) ); ?></td>
<?php endif; ?>
				</tr>
<?php endforeach; ?>
			  </tbody>
			</table>
			<div class="care-rates__footer">
			  <div class="care-rates__brands care__brand" aria-label="Sister company and CQC rating">
				<a class="care__brand-link care__brand-link--ccs" href="https://www.continuitycareservices.co.uk/" target="_blank" rel="noopener noreferrer" aria-label="Continuity of Care Services (opens in a new tab)">
				  <img src="<?php echo esc_url( restwell_theme_image_url( 'partners/continuity-of-care-services-long.png' ) ); ?>" alt="<?php echo esc_attr( restwell_theme_image_alt( 'partners/continuity-of-care-services-long.png' ) ); ?>" width="405" height="69" loading="lazy" decoding="async" />
				</a>
				<a class="care__brand-link care__brand-link--cqc" href="https://www.cqc.org.uk/location/1-2624556588" target="_blank" rel="noopener noreferrer" aria-label="CQC rating Good, Continuity of Care Services (opens in a new tab)">
				  <img src="<?php echo esc_url( restwell_theme_image_url( 'partners/cqc-rating-good.jpg' ) ); ?>" alt="<?php echo esc_attr( restwell_theme_image_alt( 'partners/cqc-rating-good.jpg' ) ); ?>" width="710" height="399" loading="lazy" decoding="async" />
				</a>
			  </div>
			  <p class="care-rates__note">There may be extra charges for bank holidays and complex care. Next review: <?php echo esc_html( $pricing['care']['valid_label'] ); ?>.</p>
			  <div class="care-rates__ctas">
				<a class="btn btn-gold" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'enquire' ) ); ?>">Enquire about care</a>
				<a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'optional-care' ) ); ?>">How optional care works</a>
			  </div>
			</div>
		  </div>
		</div>
	  </div>
	</section>

	<section class="faq section-y band-subtle" id="faq" aria-labelledby="faq-h">
	  <div class="container">
		<div class="faq__layout">
		  <header class="faq__intro">
			<p class="eyebrow">Money questions</p>
			<h2 id="faq-h">Pricing FAQ</h2>
			<p class="lede">See what is included in the bungalow rate, how Continuity guide rates work, and why funding does not change our published price.</p>
		  </header>
		  <div class="faq-list" data-faq-accordion>
			<div class="faq-item is-open">
			  <button type="button" class="faq-item__trigger" aria-expanded="true" id="pr-q1" aria-controls="pr-q1-a">
				<span>Is care included in the bungalow price?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="pr-q1-a" role="region" aria-labelledby="pr-q1">
				<p>No. The bungalow rate covers the house and on-site access equipment. Care is optional and provided by Continuity of Care Services. See the guide rates above for details.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="pr-q2" aria-controls="pr-q2-a">
				<span>Are there extra charges for equipment?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="pr-q2-a" role="region" aria-labelledby="pr-q2" hidden>
				<p>On-site hoists, profiling beds, and wet-room equipment are included. If you need to hire specialist equipment, there is an extra charge, so let us know when you enquire. For fit and hygiene, please bring your own slings.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="pr-q3" aria-controls="pr-q3-a">
				<span>Do prices change with funding?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="pr-q3-a" role="region" aria-labelledby="pr-q3" hidden>
				<p>No. Funding only affects who receives the invoice. See <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'resources' ) ); ?>">Funding &amp; Support</a> for more information.</p>
			  </div>
			</div>
			<div class="faq-item">
			  <button type="button" class="faq-item__trigger" aria-expanded="false" id="pr-q4" aria-controls="pr-q4-a">
				<span>When do care guide rates go up?</span>
				<span class="faq-item__icon" aria-hidden="true"></span>
			  </button>
			  <div class="faq-item__panel" id="pr-q4-a" role="region" aria-labelledby="pr-q4" hidden>
				<p>Weekends, bank holidays, and complex care cost more. Continuity reviews their rates regularly, and the next review date is listed above. They will give you a care quote once you agree on the hours and tasks.</p>
			  </div>
			</div>
		  </div>
		</div>
	  </div>
	</section>

	<section class="mid-cta mid-cta--plain section-y--cta" aria-labelledby="mid-cta-h">
	  <div class="mid-cta__media" aria-hidden="true"></div>
	  <div class="mid-cta__inner">
		<h2 id="mid-cta-h">Enquire about dates and care.</h2>
		<p>Let us know your arrival dates, access needs, and if you want support from Continuity. You do not need to pay a deposit until you decide.</p>
		<div class="mid-cta__btns">
		  <a class="btn btn-gold" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'enquire' ) ); ?>">Enquire Now</a>
		  <a class="btn btn-outline-light" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'how-it-works' ) ); ?>">How booking works</a>
		</div>
	  </div>
	</section>

</main>

<?php
get_footer();
