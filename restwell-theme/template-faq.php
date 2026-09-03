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
			  <form class="form-stack restwell-faq-question-form" id="faq-question-form" action="<?php echo esc_url( get_permalink() ? get_permalink() : home_url( '/faq/' ) ); ?>" method="post">
				<?php wp_nonce_field( 'restwell_faq_question', 'restwell_faq_question_nonce' ); ?>
				<input type="hidden" name="restwell_faq_question" value="1" />
				<input type="hidden" name="restwell_faq_page_id" value="<?php echo esc_attr( (string) get_the_ID() ); ?>" />
				<input type="hidden" name="restwell_form_opened_at" value="" data-restwell-form-opened />
				<div class="field" hidden aria-hidden="true">
				  <label for="faq_q_website">Website</label>
				  <input type="text" id="faq_q_website" name="faq_q_website" tabindex="-1" autocomplete="off" />
				</div>
				<div class="field"><label for="ask-name">Name</label><input id="ask-name" name="faq_q_name" autocomplete="name" /></div>
				<div class="field"><label for="ask-email">Email</label><input id="ask-email" name="faq_q_email" type="email" autocomplete="email" required /></div>
				<div class="field"><label for="ask-q">Your question</label><textarea id="ask-q" name="faq_q_message" required rows="4"></textarea></div>
				<div class="form-actions"><button class="btn btn-gold" type="submit">Send question</button></div>
			  </form>
			</div>
		  </aside>
		</div>
	  </div>
	</section>

	<section class="mid-cta mid-cta--plain section-y--cta" aria-labelledby="mid-cta-h">
	  <div class="mid-cta__media" aria-hidden="true"></div>
	  <div class="mid-cta__inner">
		<h2 id="mid-cta-h">Send dates and access needs</h2>
		<p>We reply within 48 hours on most enquiries; phone 01622 809881 if you need to talk it through.</p>
		<div class="mid-cta__btns">
		  <a class="btn btn-gold" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'enquire' ) ); ?>">Enquire Now</a>
		  <a class="btn btn-outline-light" href="<?php echo esc_url( restwell_nav_resolve_page_url( 'accessibility' ) ); ?>">See access details</a>
		</div>
	  </div>
	</section>

</main>

<?php
get_footer();
