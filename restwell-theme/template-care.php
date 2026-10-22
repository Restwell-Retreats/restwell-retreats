<?php
/**
 * Template Name: Optional Care
 *
 * Concept port from mockups — Optional care.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$restwell_care_id      = (int) get_queried_object_id();
$restwell_care_heading = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $restwell_care_id, 'care_heading', 'Optional home care during your stay' )
	: 'Optional home care during your stay';
$restwell_care_intro   = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text(
		$restwell_care_id,
		'care_intro',
		'Our sister company, Continuity of Care Services, can come in while you’re here if you ask. Tell us what you need and we’ll check who’s free.'
	)
	: 'Our sister company, Continuity of Care Services, can come in while you’re here if you ask. Tell us what you need and we’ll check who’s free.';
$restwell_care_eyebrow = function_exists( 'restwell_page_content_text' )
	? restwell_page_content_text( $restwell_care_id, 'care_label', '' )
	: '';

$care_txt = static function ( $key, $fallback ) use ( $restwell_care_id ) {
	return function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_care_id, $key, $fallback )
		: $fallback;
};

$care_day_heading = $care_txt( 'care_day_heading', 'Morning, daytime and overnight help' );
$care_day_lede = $care_txt( 'care_day_lede', 'Tell us what a normal day looks like, and Continuity will plan around it.' );
$care_who_heading = $care_txt( 'care_who_heading', 'Rated Good by the Care Quality Commission' );
$care_who_lede = $care_txt( 'care_who_lede', 'The people who come in work for Continuity of Care Services, our sister company. Victoria Walker owns Restwell and is Continuity’s registered manager, so the house and the care start in one conversation.' );
$care_cqc_link_label = $care_txt( 'care_cqc_link_label', 'Read the CQC inspection profile' );
$care_how_heading = $care_txt( 'care_how_heading', 'Asking for care' );
$care_how_lede = $care_txt( 'care_how_lede', 'Mention it on the same enquiry as the house, and nothing is booked until you say yes.' );
$care_own_heading = $care_txt( 'care_own_heading', 'Bringing your own carer' );
$care_own_lede = $care_txt( 'care_own_lede', 'Plenty of guests do. They can have the second double bedroom or the sofa bed in the conservatory, use the hoist and shower chair, and park on the drive.' );
$care_pro_heading = $care_txt( 'care_pro_heading', 'For OTs, case managers and commissioners' );
$care_pro_lede = $care_txt( 'care_pro_lede', 'Door widths and equipment are published, and Continuity confirm the care plan and the cost once the hours and tasks are agreed.' );
$care_day = array();
for ( $care_day_i = 1; $care_day_i <= 3; $care_day_i++ ) {
	$care_day[] = array(
		'time' => $care_txt( "care_day_{$care_day_i}_time", '' ),
		'body' => $care_txt( "care_day_{$care_day_i}_body", '' ),
	);
}
$care_how_steps = array();
for ( $care_step_i = 1; $care_step_i <= 3; $care_step_i++ ) {
	$care_how_steps[] = array(
		'title' => $care_txt( "care_how_step{$care_step_i}_title", '' ),
		'body'  => $care_txt( "care_how_step{$care_step_i}_body", '' ),
	);
}

$care_faq_label   = $care_txt( 'care_faq_label', 'Care questions' );
$care_faq_heading = $care_txt( 'care_faq_heading', 'Optional care FAQ' );
$care_faq_intro   = $care_txt( 'care_faq_intro', 'The questions people ask most before they mention care.' );
$care_faq_live    = array(
	1 => array(
		'q' => 'Do I have to book care?',
		'a' => 'No. Plenty of guests book the house as a self-catering holiday and don’t need any extra support. Care from Continuity is there if you’d like it.',
	),
	2 => array(
		'q' => 'Who regulates the care team?',
		'a' => 'The Care Quality Commission. Continuity of Care Services is rated Good, and Victoria Walker, who owns Restwell, is their registered manager. Read the published report yourself rather than take our word for it.',
	),
	3 => array(
		'q' => 'Do I need to book care on its own?',
		'a' => 'No. Just mention it when you enquire about the bungalow. Restwell and Continuity share 01622 809881, so the house and the care can start in one conversation.',
	),
	4 => array(
		'q' => 'Can I bring my own carers?',
		'a' => 'Yes. A carer can have the second bedroom, and there’s space to help with transfers and personal care. Tell us who’s coming when you enquire, and we’ll set the rooms up to suit.',
	),
	5 => array(
		'q' => 'Where do I see guide rates?',
		'a' => 'On Pricing & dates. They’re Continuity’s guide rates, and Continuity give you a quote once the hours and tasks are agreed.',
	),
);
$care_faq_items = array();
for ( $i = 1; $i <= 5; $i++ ) {
	$q = $care_txt( "care_faq_{$i}_q", $care_faq_live[ $i ]['q'] );
	$a = $care_txt( "care_faq_{$i}_a", $care_faq_live[ $i ]['a'] );
	if ( '' === trim( $q ) || '' === trim( $a ) ) {
		continue;
	}
	$care_faq_items[] = array(
		'q' => $q,
		'a' => $a,
	);
}
if ( empty( $care_faq_items ) ) {
	$care_faq_items = array_values( $care_faq_live );
}

/**
 * Link a known phrase inside already-escaped HTML.
 *
 * @param string $escaped Escaped plain text.
 * @param string $phrase  Phrase to wrap.
 * @param string $url     Absolute or site URL.
 * @return string
 */
$care_link_phrase = static function ( $escaped, $phrase, $url ) {
	$needle = esc_html( $phrase );
	if ( '' === $needle || false === strpos( $escaped, $needle ) ) {
		return $escaped;
	}
	$link = '<a class="text-link" href="' . esc_url( $url ) . '">' . $needle . '</a>';
	return str_replace( $needle, $link, $escaped );
};
?>


<main id="main-content">
<?php
// Built only from sections the rest of the site already uses (14 Oct 2026,
// after bespoke layouts read as a different site): the interior photo hero,
// the subnav, Who It's For's photo cards and pull quote, How It Works' split
// with facts and its route of steps. Large photos come from the professional
// shoot only.
get_template_part(
	'template-parts/concept/photo-hero',
	null,
	array(
		'heading_id' => 'page-h',
		'heading'    => $restwell_care_heading,
		'eyebrow'    => $restwell_care_eyebrow,
		'intro'      => $restwell_care_intro,
		'crumbs'     => array(
			array(
				'label' => __( 'Home', 'restwell-retreats' ),
				'url'   => home_url( '/' ),
			),
			array(
				'label' => 'Care during your stay',
				'url'   => '',
			),
		),
		'image_url'  => restwell_theme_image_url( 'bungalow/WHIT-SEAFRONT-2-LS.jpg' ),
		'image_alt'  => __( 'Boats pulled up on the shingle on Whitstable seafront at dusk', 'restwell-retreats' ),
		'post_id'    => (int) get_queried_object_id(),
	)
);
$care_day_photos = array(
	array( 'bungalow/WR-1-LS.jpg', __( 'The level-access wet room, with the shower chair and height-adjustable basin', 'restwell-retreats' ) ),
	array( 'bungalow/WHIT-SEAFRONT-1-LS.jpg', __( 'The flat promenade path past the beach huts', 'restwell-retreats' ) ),
	array( 'bungalow/BD2-2-LS.jpg', __( 'The twin profiling beds in the accessible bedroom', 'restwell-retreats' ) ),
);
?>

	<nav class="subnav" aria-label="On this page" data-toc>
	  <div class="container">
		<ul class="subnav__list">
		  <li><a href="#a-day"><?php esc_html_e( 'A day', 'restwell-retreats' ); ?></a></li>
		  <li><a href="#who-comes-in"><?php esc_html_e( 'Who comes in', 'restwell-retreats' ); ?></a></li>
		  <li><a href="#how-care-works"><?php esc_html_e( 'Asking', 'restwell-retreats' ); ?></a></li>
		  <li><a href="#bring-your-own-carer"><?php esc_html_e( 'Your own carer', 'restwell-retreats' ); ?></a></li>
		  <li><a href="#faq"><?php esc_html_e( 'FAQ', 'restwell-retreats' ); ?></a></li>
		</ul>
	  </div>
	</nav>

	<section class="section-y band-white" id="a-day" aria-labelledby="care-day-h">
	  <div class="container">
		<header class="section-head">
		  <h2 id="care-day-h"><?php echo esc_html( $care_day_heading ); ?></h2>
		  <?php if ( '' !== $care_day_lede ) : ?>
		  <p class="lede"><?php echo esc_html( $care_day_lede ); ?></p>
		  <?php endif; ?>
		</header>
		<?php // Who It's For's kit cards (22 Oct 2026): morning large, the day and the night beside it. It was three cards in a row. ?>
		<ul class="kit-cards" role="list">
		  <?php foreach ( $care_day as $care_day_i => $care_moment ) : ?>
				<?php
				if ( '' === trim( $care_moment['time'] ) || empty( $care_day_photos[ $care_day_i ] ) ) {
					continue;
				}
				$care_photo = $care_day_photos[ $care_day_i ];
				?>
		  <li class="care-choice care-choice--own">
			<img class="care-choice__photo" src="<?php echo esc_url( restwell_theme_image_url( $care_photo[0] ) ); ?>" alt="<?php echo esc_attr( $care_photo[1] ); ?>" width="2400" height="1500" sizes="(min-width: 768px) 720px, 100vw" loading="lazy" decoding="async" />
			<div class="care-choice__text">
			  <h3><?php echo esc_html( $care_moment['time'] ); ?></h3>
			  <p><?php echo esc_html( $care_moment['body'] ); ?></p>
			</div>
		  </li>
		  <?php endforeach; ?>
		</ul>
	  </div>
	</section>

	<section class="section-y band-subtle" id="who-comes-in" aria-labelledby="who-comes-in-h">
	  <div class="container split split--flip split--fill">
		<div class="split__media">
		  <img src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/LR-RNR-LS.jpg' ) ); ?>" alt="<?php esc_attr_e( 'The living room, with the rise-and-recline armchair by the window', 'restwell-retreats' ); ?>" width="2400" height="1500" loading="lazy" decoding="async" />
		</div>
		<div id="cqc-regulated">
		  <header class="section-head section-head--tight">
			<h2 id="who-comes-in-h"><?php echo esc_html( $care_who_heading ); ?></h2>
			<?php if ( '' !== $care_who_lede ) : ?>
			<p class="lede"><?php echo esc_html( $care_who_lede ); ?></p>
			<?php endif; ?>
		  </header>
		  <dl class="hiw-facts">
			<div>
			  <dt><span class="hiw-facts__icon" aria-hidden="true"><?php restwell_the_icon( 'badge-check' ); ?></span><?php esc_html_e( 'CQC rating', 'restwell-retreats' ); ?></dt>
			  <dd><?php esc_html_e( 'Good, for Continuity of Care Services', 'restwell-retreats' ); ?></dd>
			</div>
			<div>
			  <dt><span class="hiw-facts__icon" aria-hidden="true"><?php restwell_the_icon( 'users' ); ?></span><?php esc_html_e( 'Registered manager', 'restwell-retreats' ); ?></dt>
			  <dd><?php esc_html_e( 'Victoria Walker, who owns Restwell', 'restwell-retreats' ); ?></dd>
			</div>
			<div>
			  <dt><span class="hiw-facts__icon" aria-hidden="true"><?php restwell_the_icon( 'clipboard-check' ); ?></span><?php esc_html_e( 'CQC location', 'restwell-retreats' ); ?></dt>
			  <dd>1-2624556588</dd>
			</div>
		  </dl>
		  <?php if ( '' !== $care_cqc_link_label ) : ?>
		  <p class="hiw-arrival__links">
			<a class="btn btn-outline-teal" href="https://www.cqc.org.uk/location/1-2624556588" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $care_cqc_link_label ); ?><span class="sr-only"> <?php esc_html_e( '(opens in new tab)', 'restwell-retreats' ); ?></span></a>
		  </p>
		  <?php endif; ?>
		</div>
	  </div>
	</section>

	<section class="section-y band-white" aria-labelledby="care-quote-h">
	  <div class="container">
		<h2 id="care-quote-h" class="sr-only"><?php esc_html_e( 'What a support team lead wrote', 'restwell-retreats' ); ?></h2>
		<figure class="pull-quote">
		  <span class="pull-quote__mark" aria-hidden="true">&ldquo;</span>
		  <?php /* Consecutive words from G.G.'s Google review (docs/guest-reviews-bank.md). */ ?>
		  <blockquote class="pull-quote__text">The setup also works perfectly for support workers. The second bedroom provides a comfortable space for day support, and the adjustable armchair is ideal for a waking night carer, offering great comfort throughout their shift.</blockquote>
		  <figcaption class="pull-quote__cite">G.G.<span class="pull-quote__role"><?php esc_html_e( 'Support team lead · Google review', 'restwell-retreats' ); ?></span></figcaption>
		</figure>
	  </div>
	</section>

	<section class="section-y band-subtle" id="how-care-works" aria-labelledby="how-care-works-h">
	  <div class="container">
		<?php // Asking for care (22 Oct 2026): Pricing's payment panel, the three steps on a white panel over the patio. It was a list beside a photo. ?>
		<div class="property__layout">
		  <div class="property__copy">
			<h2 id="how-care-works-h"><?php echo esc_html( $care_how_heading ); ?></h2>
			<?php if ( '' !== $care_how_lede ) : ?>
			<p class="lede"><?php echo esc_html( $care_how_lede ); ?></p>
			<?php endif; ?>
			<ol class="pay-steps">
			  <?php foreach ( $care_how_steps as $care_how_step ) : ?>
					<?php
					if ( '' === trim( $care_how_step['title'] ) ) {
						continue;
					}
					?>
			  <li>
					<h3><?php echo esc_html( $care_how_step['title'] ); ?></h3>
					<?php if ( '' !== $care_how_step['body'] ) : ?>
					<p><?php echo esc_html( $care_how_step['body'] ); ?></p>
					<?php endif; ?>
			  </li>
			  <?php endforeach; ?>
			</ol>
		  </div>
		  <img class="property__photo" src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/PT-2-LS.jpg' ) ); ?>" alt="<?php esc_attr_e( 'The level patio and garden behind the bungalow', 'restwell-retreats' ); ?>" width="1920" height="1200" sizes="(min-width: 960px) 760px, 100vw" loading="lazy" decoding="async" />
		</div>
	  </div>
	</section>

	<section class="section-y band-white" id="bring-your-own-carer" aria-labelledby="own-carer-h">
	  <div class="container">
		<?php // Bringing your own carer (22 Oct 2026): Home's photo card beside the teal card, both cards' words at the foot. It was a photo beside text. ?>
		<ul class="care-choices care-choices--foot" role="list">
		  <li class="care-choice care-choice--own">
			<img class="care-choice__photo" src="<?php echo esc_url( restwell_theme_image_url( 'bungalow/SB-1-LS.jpg' ) ); ?>" alt="<?php esc_attr_e( 'The conservatory, with the sofa bed made up as a sofa', 'restwell-retreats' ); ?>" width="2400" height="1500" sizes="(min-width: 960px) 660px, 100vw" loading="lazy" decoding="async" />
			<div class="care-choice__text">
			  <h2 id="own-carer-h"><?php echo esc_html( $care_own_heading ); ?></h2>
			  <?php if ( '' !== $care_own_lede ) : ?>
			  <p><?php echo esc_html( $care_own_lede ); ?></p>
			  <?php endif; ?>
			</div>
		  </li>
		  <li class="care-choice care-choice--continuity" id="for-professionals">
			<div class="care-choice__text">
			  <h3><?php echo esc_html( $care_pro_heading ); ?></h3>
			  <?php if ( '' !== $care_pro_lede ) : ?>
			  <p><?php echo esc_html( $care_pro_lede ); ?></p>
			  <?php endif; ?>
			  <p class="care-choice__links">
				<a class="care-choice__link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'accessibility' ) ); ?>"><?php esc_html_e( 'Accessibility', 'restwell-retreats' ); ?></a>
				<a class="care-choice__link" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'resources' ) ); ?>"><?php esc_html_e( 'Funding & Support', 'restwell-retreats' ); ?></a>
			  </p>
			</div>
		  </li>
		</ul>
	  </div>
	</section>

	<section class="faq section-y band-subtle" id="faq" aria-labelledby="faq-h">
	  <div class="container">
		<div class="faq__layout">
		  <header class="faq__intro">
			<?php if ( '' !== $care_faq_label ) : ?>
			<p class="eyebrow"><?php echo esc_html( $care_faq_label ); ?></p>
			<?php endif; ?>
			<h2 id="faq-h"><?php echo esc_html( $care_faq_heading ); ?></h2>
			<?php if ( '' !== $care_faq_intro ) : ?>
			<p class="lede"><?php echo esc_html( $care_faq_intro ); ?></p>
			<?php endif; ?>
		  </header>
		  <?php
			$care_faq_accordion = array();
			foreach ( $care_faq_items as $faq_i => $faq_row ) {
				$answer = esc_html( $faq_row['a'] );
				$answer = $care_link_phrase( $answer, 'Pricing & dates', restwell_nav_resolve_page_url( 'pricing' ) . '#care-rates' );
				$care_faq_accordion[] = array(
					'q'    => $faq_row['q'],
					'a'    => '<p>' . $answer . '</p>',
					'open' => 0 === $faq_i,
				);
			}
			get_template_part(
				'template-parts/faq-accordion',
				null,
				array(
					'id_prefix'    => 'care-q',
					'list_class'   => 'faq-list--split',
					'wrap_columns' => true,
					'columns'      => array( array_slice( $care_faq_accordion, 0, 3 ), array_slice( $care_faq_accordion, 3 ) ),
				)
			);
			?>
		</div>
	  </div>
	</section>

	<?php
	$care_mid_cta_heading = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_care_id, 'care_cta_heading', __( 'Tell us what you need, and we’ll work it out with you', 'restwell-retreats' ) )
		: __( 'Tell us what you need, and we’ll work it out with you', 'restwell-retreats' );
	$care_mid_cta_intro   = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_care_id, 'care_cta_body', __( 'Ring 01622 809881 or send us a note, and we’ll talk through what would help.', 'restwell-retreats' ) )
		: __( 'Ring 01622 809881 or send us a note, and we’ll talk through what would help.', 'restwell-retreats' );
	$care_mid_cta_primary_label = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_care_id, 'care_cta_primary_label', __( 'Enquire', 'restwell-retreats' ) )
		: __( 'Enquire', 'restwell-retreats' );
	$care_mid_cta_primary_url   = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_care_id, 'care_cta_primary_url', restwell_nav_resolve_page_url( 'enquire' ) )
		: restwell_nav_resolve_page_url( 'enquire' );
	$care_mid_cta_secondary_label = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_care_id, 'care_cta_secondary_label', __( 'See guide rates', 'restwell-retreats' ) )
		: __( 'See guide rates', 'restwell-retreats' );
	$care_mid_cta_secondary_url   = function_exists( 'restwell_page_content_text' )
		? restwell_page_content_text( $restwell_care_id, 'care_cta_secondary_url', restwell_nav_resolve_page_url( 'pricing' ) . '#care-rates' )
		: restwell_nav_resolve_page_url( 'pricing' ) . '#care-rates';

	get_template_part(
		'template-parts/mid-cta',
		null,
		array(
			'heading'         => $care_mid_cta_heading,
			'intro'           => $care_mid_cta_intro,
			'primary_label'   => $care_mid_cta_primary_label,
			'primary_url'     => $care_mid_cta_primary_url,
			'secondary_label' => $care_mid_cta_secondary_label,
			'secondary_url'   => $care_mid_cta_secondary_url,
		)
	);
	?>

</main>

<?php
get_footer();
