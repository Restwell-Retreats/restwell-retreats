<?php
/**
 * Export Restwell custom SEO data for Yoast/Rank Math migration.
 *
 * Run from WordPress root:
 * wp eval-file wp-content/themes/restwell-theme/tools/export-restwell-seo.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$timestamp = gmdate( 'Y-m-d-His' );
$upload    = wp_upload_dir();
$dir       = trailingslashit( $upload['basedir'] ) . 'restwell-seo-export';

wp_mkdir_p( $dir );

$csv_path  = $dir . "/restwell-seo-export-{$timestamp}.csv";
$json_path = $dir . "/restwell-seo-export-{$timestamp}.json";

$fields = array(
	'id',
	'post_type',
	'post_status',
	'slug',
	'title',
	'url',
	'template',
	'custom_meta_title',
	'effective_meta_title',
	'custom_meta_description',
	'effective_meta_description',
	'custom_focus_keyphrase',
	'effective_focus_keyphrase',
	'meta_canonical',
	'meta_noindex',
	'effective_noindex',
	'og_image_id',
	'og_image_url',
	'rank_math_title',
	'rank_math_description',
	'rank_math_focus_keyword',
	'rank_math_canonical_url',
);

$posts = get_posts(
	array(
		'post_type'      => array( 'page', 'post' ),
		'post_status'    => array( 'publish', 'draft', 'private' ),
		'posts_per_page' => -1,
		'orderby'        => 'post_type title',
		'order'          => 'ASC',
	)
);

$rows = array();

foreach ( $posts as $post ) {
	$id       = (int) $post->ID;
	$template = get_page_template_slug( $id );

	$defaults = function_exists( 'restwell_get_seo_default_meta_for_post_id' )
		? restwell_get_seo_default_meta_for_post_id( $id )
		: array(
			'meta_title'       => '',
			'meta_description' => '',
			'focus_keyphrase'  => '',
		);

	$custom_title = (string) get_post_meta( $id, 'meta_title', true );
	$custom_desc  = (string) get_post_meta( $id, 'meta_description', true );
	$custom_focus = (string) get_post_meta( $id, 'focus_keyphrase', true );
	$canonical    = (string) get_post_meta( $id, 'meta_canonical', true );
	$noindex      = (bool) get_post_meta( $id, 'meta_noindex', true );
	$og_image_id  = absint( get_post_meta( $id, 'og_image_id', true ) );

	$effective_noindex = $noindex || ( 'page-guest-guide.php' === $template );

	$rows[] = array(
		'id'                        => $id,
		'post_type'                 => $post->post_type,
		'post_status'               => $post->post_status,
		'slug'                      => $post->post_name,
		'title'                     => get_the_title( $id ),
		'url'                       => get_permalink( $id ),
		'template'                  => $template,
		'custom_meta_title'         => $custom_title,
		'effective_meta_title'      => $custom_title ?: ( $defaults['meta_title'] ?? '' ),
		'custom_meta_description'   => $custom_desc,
		'effective_meta_description'=> $custom_desc ?: ( $defaults['meta_description'] ?? '' ),
		'custom_focus_keyphrase'    => $custom_focus,
		'effective_focus_keyphrase' => $custom_focus ?: ( $defaults['focus_keyphrase'] ?? '' ),
		'meta_canonical'            => $canonical,
		'meta_noindex'              => $noindex ? '1' : '0',
		'effective_noindex'         => $effective_noindex ? '1' : '0',
		'og_image_id'               => $og_image_id ?: '',
		'og_image_url'              => $og_image_id ? wp_get_attachment_image_url( $og_image_id, 'full' ) : '',
		'rank_math_title'           => get_post_meta( $id, 'rank_math_title', true ),
		'rank_math_description'     => get_post_meta( $id, 'rank_math_description', true ),
		'rank_math_focus_keyword'   => get_post_meta( $id, 'rank_math_focus_keyword', true ),
		'rank_math_canonical_url'   => get_post_meta( $id, 'rank_math_canonical_url', true ),
	);
}

$csv = fopen( $csv_path, 'w' );
fputcsv( $csv, $fields );

foreach ( $rows as $row ) {
	fputcsv( $csv, array_map( static fn( $field ) => $row[ $field ] ?? '', $fields ) );
}

fclose( $csv );

file_put_contents(
	$json_path,
	wp_json_encode( $rows, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
);

WP_CLI::success( "CSV export: {$csv_path}" );
WP_CLI::success( "JSON export: {$json_path}" );
WP_CLI::success( 'Exported ' . count( $rows ) . ' posts/pages.' );
