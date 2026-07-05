<?php
/**
 * Breadcrumb navigation.
 *
 * - Interior pages: Home > Page title
 * - Single posts:   Home > Articles > Post title
 *
 * Included at the top of each interior template (below <main>, above the hero).
 * Not shown on the front page.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( is_front_page() ) {
	return;
}

// Build crumb list.
$crumbs = array();

// Home is always first.
$crumbs[] = array(
	'label' => __( 'Home', 'restwell-retreats' ),
	'url'   => home_url( '/' ),
);

// Shared blog index crumb for posts, categories, tags and date archives.
$posts_page_id   = (int) get_option( 'page_for_posts' );
$blog_index_label = $posts_page_id ? get_the_title( $posts_page_id ) : __( 'Blog', 'restwell-retreats' );
$blog_index_url   = $posts_page_id ? get_permalink( $posts_page_id ) : home_url( '/blog/' );

if ( is_home() ) {
	$crumbs[] = array(
		'label' => $blog_index_label,
		'url'   => '',
	);
} elseif ( is_category() ) {
	$crumbs[] = array(
		'label' => $blog_index_label,
		'url'   => $blog_index_url,
	);
	$crumbs[] = array(
		'label' => single_cat_title( '', false ),
		'url'   => '',
	);
} elseif ( is_tag() ) {
	$crumbs[] = array(
		'label' => $blog_index_label,
		'url'   => $blog_index_url,
	);
	$crumbs[] = array(
		'label' => single_tag_title( '', false ),
		'url'   => '',
	);
} elseif ( is_date() ) {
	$crumbs[] = array(
		'label' => $blog_index_label,
		'url'   => $blog_index_url,
	);
	$crumbs[] = array(
		'label' => get_the_archive_title(),
		'url'   => '',
	);
} elseif ( is_singular( 'post' ) ) {
	$crumbs[] = array(
		'label' => $blog_index_label,
		'url'   => $blog_index_url,
	);

	$post_categories = get_the_category();
	if ( ! empty( $post_categories ) ) {
		foreach ( $post_categories as $cat_obj ) {
			if ( 'uncategorized' === $cat_obj->slug ) {
				continue;
			}
			$crumbs[] = array(
				'label' => $cat_obj->name,
				'url'   => get_category_link( $cat_obj->term_id ),
			);
			break;
		}
	}

	$crumbs[] = array(
		'label' => get_the_title(),
		'url'   => '',
	);
} else {
	// Default interior page / CPT fallback.
	$crumbs[] = array(
		'label' => get_the_title(),
		'url'   => '',
	);
}

// BreadcrumbList JSON-LD is output in <head> by restwell_output_jsonld_breadcrumb() (inc/seo.php).
// Do not echo a second <script type="application/ld+json"> block here to avoid duplicate markup errors.
?>
<nav class="breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'restwell-retreats' ); ?>">
	<div class="container">
		<ol class="breadcrumb__list">
			<?php foreach ( $crumbs as $i => $crumb ) : ?>
				<?php $is_last = ( $i === count( $crumbs ) - 1 ); ?>
				<li class="breadcrumb__item <?php echo $is_last ? 'breadcrumb__item--current' : ''; ?>"
					<?php
					if ( $is_last ) :
						?>
						aria-current="page" <?php endif; ?>>
					<?php if ( ! $is_last && $crumb['url'] ) : ?>
						<a href="<?php echo esc_url( $crumb['url'] ); ?>" class="breadcrumb__link">
							<?php echo esc_html( $crumb['label'] ); ?>
						</a>
					<?php else : ?>
						<span class="breadcrumb__current-label" title="<?php echo esc_attr( $crumb['label'] ); ?>">
							<?php echo esc_html( $crumb['label'] ); ?>
						</span>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</nav>
