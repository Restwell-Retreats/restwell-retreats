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

$google_reviews = restwell_get_google_reviews();
$review_items   = $google_reviews['reviews'];
$reviews_label  = (string) $google_reviews_args['label'];
$reviews_heading = (string) $google_reviews_args['heading'];
if ( '' === $reviews_label ) {
	$reviews_label = 'What guests say';
}
if ( '' === $reviews_heading ) {
	$reviews_heading = 'What guests wrote after staying';
}

if ( ! empty( $review_items ) ) :
	?>
	<section class="testimonials section-y" aria-labelledby="testimonials-h">
		<div class="container">
			<header class="section-head">
				<p class="eyebrow eyebrow--on-dark"><?php echo esc_html( $reviews_label ); ?></p>
				<h2 id="testimonials-h"><?php echo esc_html( $reviews_heading ); ?></h2>
			</header>
			<ul class="testimonials__grid" role="list">
				<?php foreach ( $review_items as $google_review ) : ?>
					<li>
						<article class="testimonial-card">
							<blockquote class="testimonial-card__quote"><?php echo esc_html( $google_review['text'] ); ?></blockquote>
							<footer class="testimonial-card__name"><?php echo esc_html( $google_review['name'] ); ?>
							<?php
							if ( '' !== $google_review['relative_time'] ) :
								?>
								<span class="testimonial-card__role">Google review<?php echo '' !== $google_review['relative_time'] ? ' &middot; ' . esc_html( $google_review['relative_time'] ) : ''; ?></span><?php endif; ?></footer>
						</article>
					</li>
				<?php endforeach; ?>
			</ul>
			<?php if ( '' !== $google_reviews['reviews_uri'] ) : ?>
				<p class="testimonials__more"><a class="text-link" href="<?php echo esc_url( $google_reviews['reviews_uri'] ); ?>" target="_blank" rel="noopener noreferrer">Read all our Google reviews<span class="sr-only"> (opens in a new tab)</span></a></p>
			<?php endif; ?>
		</div>
	</section>
	<?php
	return;
endif;
?>

<?php // Fallback: verbatim current page copy. ?>
<section class="testimonials section-y" aria-labelledby="testimonials-h">
	<div class="container">
		<header class="section-head">
			<p class="eyebrow eyebrow--on-dark"><?php echo esc_html( $reviews_label ); ?></p>
			<h2 id="testimonials-h"><?php echo esc_html( $reviews_heading ); ?></h2>
		</header>
		<ul class="testimonials__grid" role="list">
			<?php foreach ( $google_reviews_args['fallbacks'] as $static_review ) : ?>
				<li>
					<article class="testimonial-card">
						<blockquote class="testimonial-card__quote"><?php echo esc_html( $static_review['quote'] ); ?></blockquote>
						<footer class="testimonial-card__name"><?php echo esc_html( $static_review['name'] ); ?><span class="testimonial-card__role"><?php echo esc_html( $static_review['role'] ); ?></span></footer>
					</article>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
