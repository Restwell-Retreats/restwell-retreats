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
?>


<main id="main-content">
<?php
$restwell_pricing_id      = (int) get_queried_object_id();
$restwell_pricing_heading = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $restwell_pricing_id, 'pricing_heading', 'What a stay here costs' )
	: 'What a stay here costs';
$restwell_pricing_intro   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $restwell_pricing_id, 'pricing_intro', 'Here are the weekly and nightly rates, the nights that are free and how the deposit works. You can stay for one night or a whole week, and the access equipment is included.' )
	: 'Here are the weekly and nightly rates, the nights that are free and how the deposit works. You can stay for one night or a whole week, and the access equipment is included.';

$pricing_txt = static function ( $key, $fallback ) use ( $restwell_pricing_id ) {
	return function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_pricing_id, $key, $fallback )
		: $fallback;
};

$pricing_rates_label   = $pricing_txt( 'pricing_rates_label', __( 'Bungalow rates', 'restwell-retreats' ) );
$pricing_rates_heading = $pricing_txt( 'pricing_rates_heading', __( 'Weekly and nightly rates', 'restwell-retreats' ) );
$pricing_rates_intro   = $pricing_txt(
	'pricing_rates_intro',
	__( 'You book the whole bungalow, for up to five people. Weekend nights cost a little more than midweek nights, and you can stay for just one night.', 'restwell-retreats' )
);
$pricing_payment_label   = $pricing_txt( 'pricing_payment_label', __( 'Deposits and balance', 'restwell-retreats' ) );
$pricing_payment_heading = $pricing_txt( 'pricing_payment_heading', __( 'How payment works', 'restwell-retreats' ) );
$pricing_payment_intro   = $pricing_txt(
	'pricing_payment_intro',
	__( 'You can pay by bank transfer or card. If a council, the NHS or a charity is paying, the price is the same. Funding & Support explains how the invoice works.', 'restwell-retreats' )
);
$pricing_care_rates_label   = $pricing_txt( 'pricing_care_rates_label', __( 'Guide rates', 'restwell-retreats' ) );
$pricing_care_rates_heading = $pricing_txt( 'pricing_care_rates_heading', __( 'Guide rates for optional care', 'restwell-retreats' ) );
$pricing_care_rates_intro   = $pricing_txt(
	'pricing_care_rates_intro',
	__( 'If you’d like home care during your stay, these are Continuity’s guide rates. What you pay depends on the hours and tasks you need. Continuity will give you a quote once you’ve talked it through.', 'restwell-retreats' )
);
$pricing_faq_label   = $pricing_txt( 'pricing_faq_label', __( 'Money questions', 'restwell-retreats' ) );
$pricing_faq_heading = $pricing_txt( 'pricing_faq_heading', __( 'Questions about prices', 'restwell-retreats' ) );
$pricing_faq_intro   = $pricing_txt(
	'pricing_faq_intro',
	__( 'What the bungalow price covers, how care is charged, and what changes when a council or the NHS pays.', 'restwell-retreats' )
);

/**
 * Turn a phrase inside already-escaped copy into an internal text link.
 *
 * @param string $escaped Escaped HTML text.
 * @param string $phrase  Visible phrase to wrap.
 * @param string $url     Destination URL.
 * @return string
 */
$pricing_link_phrase = static function ( $escaped, $phrase, $url ) {
	$needle = esc_html( $phrase );
	if ( '' === $needle || false === strpos( $escaped, $needle ) ) {
		return $escaped;
	}
	$link = '<a class="text-link" href="' . esc_url( $url ) . '">' . $needle . '</a>';
	return str_replace( $needle, $link, $escaped );
};

get_template_part(
	'template-parts/concept/photo-hero',
	null,
	array(
		'heading_id' => 'page-h',
		'heading'    => $restwell_pricing_heading,
		'intro'      => $restwell_pricing_intro,
		'overlay'    => 'heavy',
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
		  <?php if ( '' !== $pricing_rates_label ) : ?>
		  <p class="eyebrow"><?php echo esc_html( $pricing_rates_label ); ?></p>
		  <?php endif; ?>
		  <h2 id="rates-h"><?php echo esc_html( $pricing_rates_heading ); ?></h2>
		  <?php if ( '' !== $pricing_rates_intro ) : ?>
		  <p class="lede"><?php echo esc_html( $pricing_rates_intro ); ?></p>
		  <?php endif; ?>
		</header>
		<?php
		// Rates (22 Oct 2026, owner's pick after eight rounds): the living room
		// wide across the page, then off-peak and peak as two columns under it.
		// Example stays and the peak dates sit behind one tap, like the care rates.
		$rate_seasons = array(
			'off_peak' => array( __( 'Off-peak', 'restwell-retreats' ), __( 'Most of the year', 'restwell-retreats' ) ),
			'peak'     => array( __( 'Peak', 'restwell-retreats' ), __( 'School holidays', 'restwell-retreats' ) ),
		);
		?>
		<img class="season-rates__photo" src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/LR-1-LS.jpg' ) ); ?>" alt="<?php echo esc_attr( restwell_theme_image_alt( 'bungalow/LR-1-LS.jpg' ) ); ?>" width="2400" height="1500" sizes="(min-width: 1200px) 1120px, 100vw" loading="lazy" decoding="async" />
		<div class="season-rates">
		  <?php foreach ( $rate_seasons as $season_key => $season_text ) : ?>
		  <div class="season-rates__col">
			<h3><?php echo esc_html( $season_text[0] ); ?></h3>
			<p class="season-rates__when"><?php echo esc_html( $season_text[1] ); ?></p>
			<dl>
				<?php foreach ( $rate_rows as $rate_row ) : ?>
			  <div>
				<dt><?php echo esc_html( $rate_row['label'] ); ?><span><?php echo esc_html( trim( $rate_row['hint'], '()' ) ); ?></span></dt>
				<dd><?php echo esc_html( restwell_format_gbp( $seasons[ $season_key ][ $rate_row['field'] ] ) ); ?></dd>
			  </div>
				<?php endforeach; ?>
			</dl>
		  </div>
		  <?php endforeach; ?>
		</div>
		<?php
		// Peak dates (22 Oct 2026, owner's pick): grouped by the year they start,
		// one year under each season column so the section stays balanced.
		// The example stays were dropped.
		$peak_by_year = array();
		foreach ( restwell_get_peak_ranges_display() as $peak_range ) {
			$peak_by_year[ $peak_range['year'] ][] = $peak_range;
		}
		?>
		<?php if ( $peak_by_year ) : ?>
		<div class="peak-years" id="peak-dates">
			<?php foreach ( $peak_by_year as $peak_year => $peak_ranges ) : ?>
		  <div>
			<h3>
				<?php
				/* translators: %s: a year, e.g. 2026 */
				echo esc_html( sprintf( __( 'Peak dates, %s', 'restwell-retreats' ), $peak_year ) );
				?>
			</h3>
			<dl>
				<?php foreach ( $peak_ranges as $peak_range ) : ?>
			  <div>
				<dt><?php echo esc_html( $peak_range['label'] ); ?></dt>
				<dd><?php echo esc_html( $peak_range['range'] ); ?></dd>
			  </div>
				<?php endforeach; ?>
			</dl>
		  </div>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
	  </div>
	</section>

	<?php
	get_template_part( 'template-parts/availability-calendar' );
	?>

	<section class="section-y band-white" id="payment" aria-labelledby="payment-h">
	  <div class="container">
		<?php // How payment works (21 Oct 2026): Home's overlapping panel, the three steps on a white panel over a photo of the house. ?>
		<div class="property__layout">
		  <div class="property__copy">
			<?php if ( '' !== $pricing_payment_label ) : ?>
			<p class="eyebrow"><?php echo esc_html( $pricing_payment_label ); ?></p>
			<?php endif; ?>
			<h2 id="payment-h"><?php echo esc_html( $pricing_payment_heading ); ?></h2>
			<?php if ( '' !== $pricing_payment_intro ) : ?>
			<p class="lede"><?php echo wp_kses_post( $pricing_link_phrase( esc_html( $pricing_payment_intro ), 'Funding & Support', restwell_nav_resolve_page_url( 'resources' ) ) ); ?></p>
			<?php endif; ?>
			<ol class="pay-steps">
			  <li>
				<h3><?php echo esc_html( sprintf( /* translators: %d: deposit percentage */ __( '%d%% deposit', 'restwell-retreats' ), (int) $timeline['deposit_percent'] ) ); ?></h3>
				<p><?php echo esc_html( __( 'Once you’re happy the house fits, the deposit holds your dates and takes them off the calendar.', 'restwell-retreats' ) ); ?></p>
			  </li>
			  <li>
				<h3>Balance before arrival</h3>
				<p><?php echo esc_html( sprintf( /* translators: %s: balance due timing, e.g. "no later than one week before you arrive" */ __( 'You pay the rest %s.', 'restwell-retreats' ), $timeline['balance_due_clause_you'] ) ); ?></p>
			  </li>
			  <li>
				<h3>No extras</h3>
				<p>There’s no damage deposit and no cleaning fee to pay at the end of your stay.</p>
			  </li>
			</ol>
			<p class="pay-note">If your plans change, our <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'terms-and-conditions' ) ); ?>">terms and cancellation policy</a> explain what happens next.</p>
		  </div>
		  <img class="property__photo" src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/EX-1-LS.jpg' ) ); ?>" alt="" width="1920" height="1200" sizes="(min-width: 960px) 760px, 100vw" loading="lazy" decoding="async" />
		</div>
	  </div>
	</section>

	<section class="section-y band-subtle" id="care-rates" aria-labelledby="care-rates-h">
	  <div class="container">
<?php
$care_nights = array();
$care_hourly = array();
foreach ( $pricing['care']['rows'] as $_care_row ) {
	if ( isset( $_care_row['unit'] ) && 'night' === $_care_row['unit'] ) {
		$care_nights[] = $_care_row;
	} else {
		$care_hourly[] = $_care_row;
	}
}
// The two headline prices are the lowest weekday rates, so they stay true when the rates are reviewed.
$care_from_hour  = empty( $care_hourly ) ? 0 : min( wp_list_pluck( $care_hourly, 'weekday_from' ) );
$care_from_night = empty( $care_nights ) ? 0 : min( wp_list_pluck( $care_nights, 'weekday_from' ) );
?>
		<?php
		// Care guide rates (21 Oct 2026): two headline prices as a typed index
		// (like the Accessibility numbers), one line on what costs more, and
		// every rate and note behind "See every rate". The full list was a
		// 1,750px wall of figures. The hoist photo sits beside it.
		?>
		<div class="care-index">
		  <div class="care-index__copy">
			<header class="section-head section-head--tight">
			  <?php if ( '' !== $pricing_care_rates_label ) : ?>
			  <p class="eyebrow"><?php echo esc_html( $pricing_care_rates_label ); ?></p>
			  <?php endif; ?>
			  <h2 id="care-rates-h"><?php echo esc_html( $pricing_care_rates_heading ); ?></h2>
			  <?php if ( '' !== $pricing_care_rates_intro ) : ?>
			  <p class="lede"><?php echo esc_html( $pricing_care_rates_intro ); ?></p>
			  <?php endif; ?>
			</header>
			<dl class="care-index__list">
			  <?php if ( ! empty( $care_hourly ) ) : ?>
			  <div class="care-index__row">
				<dt><span class="care-index__name"><?php esc_html_e( 'Hourly care', 'restwell-retreats' ); ?></span><span class="care-index__note"><?php esc_html_e( 'Personal, domestic and complex care', 'restwell-retreats' ); ?></span></dt>
				<dd><span class="care-index__from"><?php esc_html_e( 'from', 'restwell-retreats' ); ?></span><?php echo esc_html( restwell_format_gbp( $care_from_hour, 2 ) ); ?><span class="care-index__unit"><?php esc_html_e( 'an hour', 'restwell-retreats' ); ?></span></dd>
			  </div>
			  <?php endif; ?>
			  <?php if ( ! empty( $care_nights ) ) : ?>
			  <div class="care-index__row">
				<dt><span class="care-index__name"><?php esc_html_e( 'Overnight care', 'restwell-retreats' ); ?></span><span class="care-index__note"><?php esc_html_e( 'A sleep-in or a waking night', 'restwell-retreats' ); ?></span></dt>
				<dd><span class="care-index__from"><?php esc_html_e( 'from', 'restwell-retreats' ); ?></span><?php echo esc_html( restwell_format_gbp( $care_from_night, 2 ) ); ?><span class="care-index__unit"><?php esc_html_e( 'a night', 'restwell-retreats' ); ?></span></dd>
			  </div>
			  <?php endif; ?>
			</dl>
			<p class="care-index__line"><?php esc_html_e( 'Weekends, complex care and bank holidays cost more, and Continuity will give you a quote.', 'restwell-retreats' ); ?></p>
			<details class="care-index__all">
			  <summary><?php esc_html_e( 'See every rate', 'restwell-retreats' ); ?></summary>
			  <div class="care-index__all-body">
				<?php if ( ! empty( $care_nights ) ) : ?>
				<p class="care-index__group"><?php esc_html_e( 'Overnight, per night', 'restwell-retreats' ); ?></p>
				<dl>
					<?php foreach ( $care_nights as $_care_row ) : ?>
				  <div>
					<dt><?php echo esc_html( $_care_row['type_short'] ); ?><span><?php echo esc_html( sprintf( /* translators: 1: weekday rates, 2: weekend rates */ __( 'Weekday from %1$s. Weekend from %2$s.', 'restwell-retreats' ), $_care_row['weekday_display'], $_care_row['weekend_display'] ) ); ?></span></dt>
					<dd><?php echo esc_html( restwell_format_gbp( $_care_row['weekday_from'], 2 ) ); ?></dd>
				  </div>
					<?php endforeach; ?>
				</dl>
				<?php endif; ?>
				<?php if ( ! empty( $care_hourly ) ) : ?>
				<p class="care-index__group"><?php esc_html_e( 'Hourly, weekday and weekend', 'restwell-retreats' ); ?></p>
				<dl>
					<?php foreach ( $care_hourly as $_care_row ) : ?>
				  <div>
					<dt><?php echo esc_html( $_care_row['type_short'] ); ?></dt>
					<dd><?php echo esc_html( restwell_format_gbp( $_care_row['weekday_from'], 2 ) ); ?> <span>/ <?php echo null === $_care_row['weekend_from'] ? esc_html__( 'weekdays only', 'restwell-retreats' ) : esc_html( restwell_format_gbp( $_care_row['weekend_from'], 2 ) ); ?></span></dd>
				  </div>
					<?php endforeach; ?>
				</dl>
				<?php endif; ?>
				<p class="care-index__group"><?php esc_html_e( 'Good to know', 'restwell-retreats' ); ?></p>
				<dl>
					<?php
					foreach ( $pricing['care']['notes'] as $_care_note ) :
						// A short label above each note so the terms can be scanned; unmatched notes just have none.
						$_care_label = '';
						if ( false !== stripos( $_care_note, 'one-off' ) ) {
							$_care_label = __( 'Set-up fee', 'restwell-retreats' );
						} elseif ( false !== stripos( $_care_note, 'escort' ) ) {
							$_care_label = __( 'Escort outings', 'restwell-retreats' );
						} elseif ( false !== stripos( $_care_note, 'bank holiday' ) ) {
							$_care_label = __( 'Bank holidays', 'restwell-retreats' );
						} elseif ( false !== stripos( $_care_note, 'optional' ) ) {
							$_care_label = __( 'How it is quoted', 'restwell-retreats' );
						}
						?>
				  <div class="care-index__note-row">
					<dt><?php echo esc_html( $_care_label ); ?><span><?php echo esc_html( $_care_note ); ?></span></dt>
				  </div>
					<?php endforeach; ?>
				</dl>
				<p class="care-index__review"><?php echo esc_html( sprintf( /* translators: %s: next review date */ __( 'Next review: %s.', 'restwell-retreats' ), $pricing['care']['valid_label'] ) ); ?></p>
			  </div>
			</details>
			<div class="care-index__ctas">
			  <a class="btn btn-gold" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'enquire' ) ); ?>">Enquire about care</a>
			  <a class="text-link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'optional-care' ) ); ?>">How optional care works</a>
			</div>
		  </div>
		  <figure class="care-index__media">
			<img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/BD2-6-LS.jpg' ) ); ?>" alt="<?php esc_attr_e( 'The ceiling track hoist over the profiling bed', 'restwell-retreats' ); ?>" width="2400" height="1500" sizes="(min-width: 960px) 430px, 100vw" loading="lazy" decoding="async" />
			<div class="care-rates__brands care__brand" aria-label="Sister company and CQC rating">
			  <a class="care__brand-link care__brand-link--ccs" href="https://www.continuitycareservices.co.uk/" target="_blank" rel="noopener noreferrer" aria-label="Continuity of Care Services (opens in a new tab)">
				<img src="<?php echo esc_url( restwell_theme_image_url( 'partners/continuity-of-care-services-long.png' ) ); ?>" alt="<?php echo esc_attr( restwell_theme_image_alt( 'partners/continuity-of-care-services-long.png' ) ); ?>" sizes="200px" width="405" height="69" loading="lazy" decoding="async" />
			  </a>
			  <a class="care__brand-link care__brand-link--cqc" href="https://www.cqc.org.uk/location/1-2624556588" target="_blank" rel="noopener noreferrer" aria-label="CQC rating Good, Continuity of Care Services (opens in a new tab)">
				<img src="<?php echo esc_url( restwell_theme_image_url( 'partners/cqc-rating-good.jpg' ) ); ?>" alt="<?php echo esc_attr( restwell_theme_image_alt( 'partners/cqc-rating-good.jpg' ) ); ?>" sizes="72px" width="710" height="399" loading="lazy" decoding="async" />
			  </a>
			</div>
		  </figure>
		</div>
	  </div>
	</section>

	<section class="faq section-y band-white" id="faq" aria-labelledby="faq-h">
	  <div class="container">
		<div class="faq__layout">
		  <header class="faq__intro">
			<?php if ( '' !== $pricing_faq_label ) : ?>
			<p class="eyebrow"><?php echo esc_html( $pricing_faq_label ); ?></p>
			<?php endif; ?>
			<h2 id="faq-h"><?php echo esc_html( $pricing_faq_heading ); ?></h2>
			<?php if ( '' !== $pricing_faq_intro ) : ?>
			<p class="lede"><?php echo esc_html( $pricing_faq_intro ); ?></p>
			<?php endif; ?>
		  </header>
		  <?php
			$pricing_faq_items = array();
			foreach ( restwell_get_faq_items( 'pricing' ) as $row ) {
				$pricing_faq_items[] = array(
					'q'    => $row['q'],
					'a'    => '<p>' . wp_kses_post( $row['a'] ) . '</p>',
					'open' => empty( $pricing_faq_items ),
					'cat'  => isset( $row['cat'] ) ? $row['cat'] : 'booking',
				);
			}
			get_template_part(
				'template-parts/faq-accordion',
				null,
				array(
					'id_prefix' => 'pr-q',
					'columns'   => array( $pricing_faq_items ),
				)
			);
			?>
		</div>
	  </div>
	</section>

	<?php
	$restwell_pricing_id = (int) get_queried_object_id();
	$pricing_mid_cta_heading = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_pricing_id, 'pricing_cta_heading', __( 'Ask about dates and care', 'restwell-retreats' ) )
		: __( 'Ask about dates and care', 'restwell-retreats' );
	$pricing_mid_cta_intro = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text(
			$restwell_pricing_id,
			'pricing_cta_body',
			__( 'Tell us when you’d like to come, what you need from the house and whether you’d like care from Continuity. We aim to reply within 48 hours, and there’s no deposit to pay until you’re happy the house fits.', 'restwell-retreats' )
		)
		: __( 'Tell us when you’d like to come, what you need from the house and whether you’d like care from Continuity. We aim to reply within 48 hours, and there’s no deposit to pay until you’re happy the house fits.', 'restwell-retreats' );
	$pricing_mid_cta_primary_label = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_pricing_id, 'pricing_cta_primary_label', __( 'Enquire', 'restwell-retreats' ) )
		: __( 'Enquire', 'restwell-retreats' );
	$pricing_mid_cta_primary_url = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_pricing_id, 'pricing_cta_primary_url', restwell_nav_resolve_page_url( 'enquire' ) )
		: restwell_nav_resolve_page_url( 'enquire' );
	$pricing_mid_cta_secondary_label = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_pricing_id, 'pricing_cta_secondary_label', __( 'Check availability', 'restwell-retreats' ) )
		: __( 'Check availability', 'restwell-retreats' );
	$pricing_mid_cta_secondary_url = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_pricing_id, 'pricing_cta_secondary_url', '#availability' )
		: '#availability';

	get_template_part(
		'template-parts/mid-cta',
		null,
		array(
			'heading'         => $pricing_mid_cta_heading,
			'intro'           => $pricing_mid_cta_intro,
			'primary_label'   => $pricing_mid_cta_primary_label,
			'primary_url'     => $pricing_mid_cta_primary_url,
			'secondary_label' => $pricing_mid_cta_secondary_label,
			'secondary_url'   => $pricing_mid_cta_secondary_url,
		)
	);
	?>

</main>

<?php
get_footer();
