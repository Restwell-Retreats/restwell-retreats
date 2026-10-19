<?php
/**
 * Google reviews section for the front page.
 *
 * $args:
 *   fallbacks array<int, array{quote:string,name:string,role:string}> Current on-page quotes (copy source of truth).
 *   curated   bool  Show the fallbacks even when live reviews are available (Our Story's chosen three).
 *   photos    array<int, array{0:string,1:int,2:int}> Two real photos set among the quotes (path, width, height).
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
		'curated'   => false,
		'label'     => 'What guests say',
		'heading'   => 'What guests wrote after staying',
		'photos'    => array(
			array( 'journey/guest-harbour-beach.jpg', 1620, 1012 ),
			array( 'bungalow/GRDEN-3-LS.jpg', 2400, 1500 ),
		),
	)
);

$google_reviews  = restwell_get_google_reviews();
if ( ! empty( $google_reviews_args['curated'] ) ) {
	$google_reviews['reviews'] = array();
}
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
		<?php
		// A wall, not a row (19 Oct 2026): the first review large on a gold
		// card, the rest on white cards, with two real photos set among them.
		// Three or more reviews fill the grid; fewer stack without photos.
		$review_cards  = array_values(
			array_filter(
				$review_cards,
				static function ( $review_card ) {
					return isset( $review_card['quote'] ) && '' !== (string) $review_card['quote'];
				}
			)
		);
		$review_full   = count( $review_cards ) >= 3;
		$review_photos = $review_full ? array_slice( (array) $google_reviews_args['photos'], 0, 2 ) : array();
		?>
		<div class="testimonials__wall<?php echo $review_full ? ' testimonials__wall--full' : ''; ?>">
			<?php foreach ( $review_cards as $review_i => $review_card ) : ?>
				<?php
				$review_quote = (string) $review_card['quote'];
				$review_name  = isset( $review_card['name'] ) ? (string) $review_card['name'] : '';
				$review_role  = isset( $review_card['role'] ) ? (string) $review_card['role'] : '';
				?>
				<article class="testimonial-card testimonial-card--<?php echo 0 === $review_i ? 'lead' : (int) $review_i + 1; ?>">
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
				<?php
				// Photo one sits beside the lead, photo two after the third review.
				$review_photo_i = 0 === $review_i ? 0 : ( 2 === $review_i ? 1 : -1 );
				if ( $review_photo_i >= 0 && isset( $review_photos[ $review_photo_i ] ) ) :
					$review_photo = $review_photos[ $review_photo_i ];
					?>
				<img class="testimonials__photo testimonials__photo--<?php echo (int) $review_photo_i + 1; ?>" src="<?php echo esc_url( restwell_theme_image_url( (string) $review_photo[0] ) ); ?>" alt="" width="<?php echo (int) $review_photo[1]; ?>" height="<?php echo (int) $review_photo[2]; ?>" sizes="(min-width: 900px) 340px, 100vw" loading="lazy" decoding="async" />
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
		<?php if ( '' !== $google_reviews['reviews_uri'] ) : ?>
			<p class="testimonials__more">
				<a class="text-link" href="<?php echo esc_url( $google_reviews['reviews_uri'] ); ?>" target="_blank" rel="noopener noreferrer">Read all our Google reviews<span class="sr-only"> (opens in a new tab)</span></a>
			</p>
		<?php endif; ?>
	</div>
</section>
