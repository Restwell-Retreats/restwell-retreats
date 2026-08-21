<?php
/**
 * Concept port from mockups — Default page (dynamic title + content).
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

	$title   = get_the_title();
	$excerpt = trim( (string) get_the_excerpt() );
	$crumb   = wp_html_excerpt( $title, 48, '…' );
	?>
	<section class="hero hero--interior" aria-labelledby="page-h">
		<div class="container">
			<div class="hero__content">
				<ol class="breadcrumb">
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'restwell-retreats' ); ?></a></li>
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

	<section class="section-y band-white">
		<div class="container">
			<div class="prose prose--wide">
				<?php the_content(); ?>
			</div>
		</div>
	</section>
	<?php
endwhile;
?>
</main>

<?php
get_footer();
