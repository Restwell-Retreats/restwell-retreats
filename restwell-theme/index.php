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
?>


<main id="main-content">
<?php
get_template_part(
	'template-parts/concept/photo-hero',
	null,
	array(
		'heading_id' => 'page-h',
		'heading'    => restwell_get_blog_index_heading(),
		'intro'      => restwell_get_blog_index_lede(),
		'crumbs'     => array(
			array(
				'label' => __( 'Home', 'restwell-retreats' ),
				'url'   => home_url( '/' ),
			),
			array(
				'label' => __( 'Blog', 'restwell-retreats' ),
				'url'   => '',
			),
		),
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
