<?php
/**
 * Google reviews section for the front page.
 *
 * $args:
 *   fallbacks array<int, array{quote:string,name:string,role:string}> Current on-page quotes (copy source of truth).
 *
 * Renders live Google reviews when the Places API returns them; otherwise
 * re-renders the exact static quotes already on the page. Never empty.
 * Review text is the guest’s words. Do not rewrite for house style.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$google_reviews_args = wp_parse_args(
	$args ?? array(),
	array(
		'fallbacks' => array(),
		'label'     => 'What guests say',
		'heading'   => 'What guests wrote after staying',
	)
);

$google_reviews  = restwell_get_google_reviews();
$reviews_label   = (string) $google_reviews_args['label'];
$reviews_heading = (string) $google_reviews_args['heading'];
if ( '' === $reviews_label ) {
	$reviews_label = 'What guests say';
}
if ( '' === $reviews_heading ) {
	$reviews_heading = 'What guests wrote after staying';
}

$review_cards = array();
if ( ! empty( $google_reviews['reviews'] ) ) {
	foreach ( $google_reviews['reviews'] as $google_review ) {
		$google_role = 'Google review';
		if ( '' !== $google_review['relative_time'] ) {
			$google_role .= ' · ' . $google_review['relative_time'];
		}
		$review_cards[] = array(
			'quote' => $google_review['text'],
			'name'  => $google_review['name'],
			'role'  => $google_role,
		);
	}
} else {
	$review_cards = $google_reviews_args['fallbacks'];
}

if ( empty( $review_cards ) ) {
	return;
}
?>
<section class="testimonials section-y" aria-labelledby="testimonials-h">
	<div class="container">
		<header class="section-head">
			<p class="eyebrow eyebrow--on-dark"><?php echo esc_html( $reviews_label ); ?></p>
			<h2 id="testimonials-h"><?php echo esc_html( $reviews_heading ); ?></h2>
		</header>
		<ul class="testimonials__grid" role="list">
			<?php foreach ( $review_cards as $review_card ) : ?>
				<?php
				$review_quote = isset( $review_card['quote'] ) ? (string) $review_card['quote'] : '';
				$review_name  = isset( $review_card['name'] ) ? (string) $review_card['name'] : '';
				$review_role  = isset( $review_card['role'] ) ? (string) $review_card['role'] : '';
				if ( '' === $review_quote ) {
					continue;
				}
				?>
				<li>
					<article class="testimonial-card">
						<span class="testimonial-card__mark" aria-hidden="true">“</span>
						<blockquote class="testimonial-card__quote">
							<p><?php echo esc_html( $review_quote ); ?></p>
							<footer>
								<cite class="testimonial-card__cite">
									<span class="testimonial-card__name"><?php echo esc_html( $review_name ); ?></span>
									<?php if ( '' !== $review_role ) : ?>
										<span class="testimonial-card__role"><?php echo esc_html( $review_role ); ?></span>
									<?php endif; ?>
								</cite>
							</footer>
						</blockquote>
					</article>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php if ( '' !== $google_reviews['reviews_uri'] ) : ?>
			<p class="testimonials__more">
				<a class="text-link" href="<?php echo esc_url( $google_reviews['reviews_uri'] ); ?>" target="_blank" rel="noopener noreferrer">Read all our Google reviews<span class="sr-only"> (opens in a new tab)</span></a>
			</p>
		<?php endif; ?>
	</div>
</section>
