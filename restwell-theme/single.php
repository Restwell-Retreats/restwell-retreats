<?php
/**
 * Concept port from mockups — Blog single (dynamic post fields).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$fallback_img = get_template_directory_uri() . '/assets/images/stock/restwell-whitstable-coastline-panorama.webp';
?>

<main id="main-content">
<?php
while ( have_posts() ) :
	the_post();

	$post_id   = get_the_ID();
	$title     = get_the_title();
	$excerpt   = trim( (string) get_the_excerpt() );
	if ( $excerpt === '' ) {
		$excerpt = wp_trim_words( wp_strip_all_tags( get_the_content( null, false ) ), 28, '…' );
	}
	$category  = function_exists( 'restwell_get_primary_category' ) ? restwell_get_primary_category( $post_id ) : '';
	$read_mins = function_exists( 'restwell_estimate_read_time' ) ? restwell_estimate_read_time( get_post_field( 'post_content', $post_id ) ) : 1;
	$author    = get_the_author();
	$crumb     = wp_html_excerpt( $title, 42, '…' );
	?>
<section class="hero hero--interior hero--place" aria-labelledby="page-h">
	<div class="hero__media" aria-hidden="true"></div>
	<div class="container">
		<div class="hero__content">
			<ol class="breadcrumb">
				<li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"><?php esc_html_e( 'Blog', 'restwell-retreats' ); ?></a></li>
				<li class="breadcrumb__sep" aria-hidden="true">/</li>
				<li aria-current="page"><?php echo esc_html( $crumb ); ?></li>
			</ol>
			<div class="hero__text">
				<h1 id="page-h"><?php echo esc_html( $title ); ?></h1>
				<?php if ( $excerpt !== '' ) : ?>
					<p><?php echo esc_html( $excerpt ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<article class="section-y band-white">
	<div class="container">
		<p class="blog-meta">
			<?php if ( $category !== '' ) : ?>
				<span class="tag"><?php echo esc_html( $category ); ?></span>
			<?php endif; ?>
			<span><?php echo esc_html( sprintf( /* translators: %d: minutes */ _n( '%d min read', '%d min read', $read_mins, 'restwell-retreats' ), $read_mins ) ); ?></span>
			<?php if ( $author !== '' ) : ?>
				<span><?php echo esc_html( $author ); ?></span>
			<?php endif; ?>
		</p>
		<div class="prose prose--wide">
			<?php the_content(); ?>
		</div>
	</div>
</article>
	<?php
endwhile;

$related = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 3,
		'post__not_in'        => array( get_queried_object_id() ),
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	)
);
?>
<section class="section-y band-subtle">
	<div class="container">
		<header class="section-head"><h2><?php esc_html_e( 'Related reading', 'restwell-retreats' ); ?></h2></header>
		<?php if ( $related->have_posts() ) : ?>
			<ul class="card-grid card-grid--3" role="list">
				<?php
				while ( $related->have_posts() ) :
					$related->the_post();
					$thumb = get_the_post_thumbnail_url( get_the_ID(), 'medium_large' );
					if ( ! $thumb ) {
						$thumb = $fallback_img;
					}
					?>
					<li>
						<article class="media-card">
							<img src="<?php echo esc_url( $thumb ); ?>" alt="" width="640" height="480" loading="lazy" decoding="async" />
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						</article>
					</li>
				<?php endwhile; ?>
			</ul>
			<?php
			wp_reset_postdata();
		else :
			?>
			<p class="lede"><?php esc_html_e( 'More articles will appear here as the blog grows.', 'restwell-retreats' ); ?></p>
		<?php endif; ?>
	</div>
</section>

</main>

<?php
get_footer();
