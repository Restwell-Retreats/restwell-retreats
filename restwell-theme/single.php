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
?>

<main id="main-content">
<?php
while ( have_posts() ) :
	the_post();

	$entry_id   = get_the_ID();
	$entry_title     = get_the_title();
	$excerpt   = trim( (string) get_the_excerpt() );
	if ( $excerpt === '' ) {
		$excerpt = wp_trim_words( wp_strip_all_tags( get_the_content( null, false ) ), 28, '…' );
	}
	$category  = function_exists( 'restwell_get_primary_category' ) ? restwell_get_primary_category( $entry_id ) : '';
	$read_mins = function_exists( 'restwell_estimate_read_time' ) ? restwell_estimate_read_time( get_post_field( 'post_content', $entry_id ) ) : 1;
	$byline    = function_exists( 'restwell_get_post_byline' ) ? restwell_get_post_byline() : array( 'name' => '' );
	$published = get_the_date( 'Y-m-d', $entry_id );
	$modified  = get_the_modified_date( 'Y-m-d', $entry_id );
	$crumb     = wp_html_excerpt( $entry_title, 42, '…' );
	list( $hero_image, $hero_image_alt ) = function_exists( 'restwell_get_post_card_thumb' )
		? restwell_get_post_card_thumb( $entry_id, 'full' )
		: array( '', '' );
	?>
<section class="hero hero--interior hero--place hero--overlay-heavy" aria-labelledby="page-h">
	<div class="hero__media" aria-hidden="true">
		<?php if ( $hero_image !== '' ) : ?>
			<img class="hero__media-img" src="<?php echo esc_url( $hero_image ); ?>" alt="" width="1600" height="900" decoding="async" fetchpriority="high" />
		<?php endif; ?>
	</div>
	<div class="container">
		<div class="hero__content">
			<ol class="breadcrumb">
				<li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"><?php esc_html_e( 'Blog', 'restwell-retreats' ); ?></a></li>
				<li class="breadcrumb__sep" aria-hidden="true">/</li>
				<li aria-current="page"><?php echo esc_html( $crumb ); ?></li>
			</ol>
			<div class="hero__text">
				<?php if ( $category !== '' ) : ?>
					<p class="eyebrow eyebrow--on-dark"><?php echo esc_html( $category ); ?></p>
				<?php endif; ?>
				<h1 id="page-h"><?php echo esc_html( $entry_title ); ?></h1>
				<?php if ( $excerpt !== '' ) : ?>
					<p><?php echo esc_html( $excerpt ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

	<?php
	$post_body = apply_filters( 'the_content', get_the_content() );
	$post_body = function_exists( 'restwell_enhance_post_html' ) ? restwell_enhance_post_html( $post_body ) : $post_body;
	$post_toc  = function_exists( 'restwell_post_toc' ) ? restwell_post_toc( $post_body ) : array();
	?>
<article class="section-y band-white blog-article<?php echo count( $post_toc ) >= 3 ? ' blog-article--has-toc' : ''; ?>" aria-labelledby="page-h">
	<div class="container blog-article__inner">
		<?php if ( count( $post_toc ) >= 3 ) : ?>
		<nav class="post-toc" aria-labelledby="post-toc-h">
			<p class="post-toc__title" id="post-toc-h"><?php esc_html_e( 'On this page', 'restwell-retreats' ); ?></p>
			<ol>
				<?php foreach ( $post_toc as $toc_item ) : ?>
				<li><a href="#<?php echo esc_attr( $toc_item['id'] ); ?>"><?php echo esc_html( $toc_item['label'] ); ?></a></li>
				<?php endforeach; ?>
			</ol>
		</nav>
		<?php endif; ?>
		<div class="blog-article__main">
		<p class="blog-meta">
			<?php if ( $category !== '' ) : ?>
				<span class="tag"><?php echo esc_html( $category ); ?></span>
			<?php endif; ?>
			<span><?php echo esc_html( sprintf( /* translators: %d: minutes */ _n( '%d min read', '%d min read', $read_mins, 'restwell-retreats' ), $read_mins ) ); ?></span>
			<?php if ( '' !== $byline['name'] ) : ?>
				<span class="blog-meta__byline"><?php echo esc_html( sprintf( /* translators: %s: author name */ __( 'By %s', 'restwell-retreats' ), $byline['name'] ) ); ?></span>
			<?php endif; ?>
			<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date( RESTWELL_POST_DATE_FORMAT ) ); ?></time>
			<?php if ( $modified > $published ) : ?>
				<span><?php esc_html_e( 'Updated', 'restwell-retreats' ); ?> <time datetime="<?php echo esc_attr( get_the_modified_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_modified_date( RESTWELL_POST_DATE_FORMAT ) ); ?></time></span>
			<?php endif; ?>
		</p>
		<div class="prose prose--wide post-body">
			<?php echo $post_body; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- the_content output, restructured in restwell_enhance_post_html(). ?>
		</div>
		<?php
		if ( function_exists( 'restwell_render_post_cluster_links' ) ) {
			restwell_render_post_cluster_links( $entry_id );
		}
		?>
		<nav class="blog-article__back" aria-label="<?php esc_attr_e( 'Article navigation', 'restwell-retreats' ); ?>">
			<a class="btn btn-outline-teal" href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"><?php esc_html_e( 'Back to all articles', 'restwell-retreats' ); ?></a>
		</nav>
		</div>
	</div>
</article>
	<?php
endwhile;

$related_args = array(
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'posts_per_page'      => 3,
	'post__not_in'        => array( get_queried_object_id() ),
	'ignore_sticky_posts' => true,
	'no_found_rows'       => true,
);
$primary_cat_id = function_exists( 'restwell_get_primary_category_id' )
	? restwell_get_primary_category_id( get_queried_object_id() )
	: 0;
if ( $primary_cat_id > 0 ) {
	$related_args['category__in'] = array( $primary_cat_id );
}
$related = new WP_Query( $related_args );
?>
<section class="section-y band-subtle">
	<div class="container">
		<header class="section-head"><h2><?php esc_html_e( 'Related reading', 'restwell-retreats' ); ?></h2></header>
		<?php if ( $related->have_posts() ) : ?>
			<ul class="card-grid card-grid--3" role="list">
				<?php
				while ( $related->have_posts() ) :
					$related->the_post();
					$related_id = get_the_ID();
					list( $thumb, $thumb_alt ) = restwell_get_post_card_thumb( $related_id, 'medium_large' );
					?>
					<li>
						<article class="media-card">
							<?php // Decorative: the heading link beside it already names the article. ?>
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
			<div class="empty-state blog-empty-state" role="status">
				<p class="lede"><?php esc_html_e( 'More articles will appear here as the blog grows.', 'restwell-retreats' ); ?></p>
			</div>
		<?php endif; ?>
	</div>
</section>

</main>

<?php
get_footer();
