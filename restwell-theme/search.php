<?php
/**
 * Search results — own H1, not the blog archive heading.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$query = get_search_query( false );
if ( $query !== '' ) {
	$heading = sprintf(
		/* translators: %s: search query */
		__( 'Search results for “%s”', 'restwell-retreats' ),
		$query
	);
} else {
	$heading = __( 'Search', 'restwell-retreats' );
}

$blog_page_id = (int) get_option( 'page_for_posts', 0 );
$blog_url     = $blog_page_id > 0 ? get_permalink( $blog_page_id ) : home_url( '/blog/' );
?>


<main id="main-content">
<?php
get_template_part(
	'template-parts/concept/photo-hero',
	null,
	array(
		'heading_id' => 'page-h',
		'heading'    => $heading,
		'intro'      => __( 'Posts and guides on this site that match what you typed.', 'restwell-retreats' ),
		'crumbs'     => array(
			array(
				'label' => __( 'Home', 'restwell-retreats' ),
				'url'   => home_url( '/' ),
			),
			array(
				'label' => __( 'Search', 'restwell-retreats' ),
				'url'   => '',
			),
		),
		'post_id'    => 0,
	)
);
?>

<?php
get_template_part(
	'template-parts/blog-results',
	null,
	array(
		'empty_message'   => __( 'No posts matched that search. Try a different word.', 'restwell-retreats' ),
		'empty_blog_url'  => is_string( $blog_url ) ? $blog_url : '',
		'pagination_aria' => __( 'Search results navigation', 'restwell-retreats' ),
	)
);
?>

</main>

<?php
get_footer();
