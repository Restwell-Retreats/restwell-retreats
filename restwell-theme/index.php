<?php
/**
 * Blog index — lists published posts.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$blog_page_id = (int) get_option( 'page_for_posts', 0 );
$blog_heading = restwell_get_blog_index_heading();
$blog_intro   = restwell_get_blog_index_lede();
$blog_crumbs  = array(
	array( 'label' => __( 'Home', 'restwell-retreats' ), 'url' => home_url( '/' ) ),
	array( 'label' => __( 'Blog', 'restwell-retreats' ), 'url' => '' ),
);
if ( is_archive() ) {
	$blog_heading = wp_strip_all_tags( get_the_archive_title() );
	$blog_intro   = wp_strip_all_tags( get_the_archive_description() );
	if ( '' === trim( $blog_intro ) ) {
		$blog_intro = __( 'Browse our guides on this topic, or return to the blog for all articles.', 'restwell-retreats' );
	}
	$blog_crumbs[1]['url'] = home_url( '/blog/' );
	$blog_crumbs[] = array( 'label' => $blog_heading, 'url' => '' );
}
?>


<main id="main-content">
<?php
get_template_part(
	'template-parts/concept/photo-hero',
	null,
	array(
		'heading_id' => 'page-h',
		'heading'    => $blog_heading,
		'intro'      => $blog_intro,
		'crumbs'     => $blog_crumbs,
		'post_id'    => $blog_page_id > 0 ? $blog_page_id : (int) get_queried_object_id(),
	)
);
?>

<?php
get_template_part(
	'template-parts/blog-results',
	null,
	array(
		'empty_message'   => __( 'More articles will appear here as the blog grows.', 'restwell-retreats' ),
		'pagination_aria' => __( 'Blog posts navigation', 'restwell-retreats' ),
	)
);
?>

</main>

<?php
get_footer();
