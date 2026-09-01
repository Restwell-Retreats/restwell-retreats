<?php
/**
 * Template Name: Terms & Conditions
 *
 * Reads the "Legal" content fields (Page content metabox) so editors can
 * change the label, headline, intro and body without touching code. Any
 * field left empty falls back to the theme default in inc/theme-setup/legal-content.php.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$restwell_legal_post_id = (int) get_queried_object_id();
$restwell_legal_defaults = function_exists( 'restwell_get_terms_conditions_page_defaults' )
	? restwell_get_terms_conditions_page_defaults()
	: array();

$restwell_legal_label = trim( (string) get_post_meta( $restwell_legal_post_id, 'legal_label', true ) );
if ( '' === $restwell_legal_label ) {
	$restwell_legal_label = (string) ( $restwell_legal_defaults['legal_label'] ?? '' );
}

$restwell_legal_heading = trim( (string) get_post_meta( $restwell_legal_post_id, 'legal_heading', true ) );
if ( '' === $restwell_legal_heading ) {
	$restwell_legal_heading = (string) ( $restwell_legal_defaults['legal_heading'] ?? __( 'Restwell terms and conditions', 'restwell-retreats' ) );
}

$restwell_legal_intro = trim( (string) get_post_meta( $restwell_legal_post_id, 'legal_intro', true ) );
if ( '' === $restwell_legal_intro ) {
	$restwell_legal_intro = (string) ( $restwell_legal_defaults['legal_intro'] ?? '' );
}

$restwell_legal_body = trim( (string) get_post_meta( $restwell_legal_post_id, 'legal_body_html', true ) );
if ( '' === $restwell_legal_body && function_exists( 'restwell_get_terms_conditions_content' ) ) {
	$restwell_legal_body = restwell_get_terms_conditions_content();
}

get_header();
?>


<main id="main-content">
<?php
get_template_part(
	'template-parts/legal-document',
	null,
	array(
		'post_id'     => $restwell_legal_post_id,
		'eyebrow'     => $restwell_legal_label,
		'heading'     => $restwell_legal_heading,
		'intro'       => $restwell_legal_intro,
		'crumb_label' => __( 'Terms & Conditions', 'restwell-retreats' ),
		'body_html'   => $restwell_legal_body,
	)
);
?>

</main>

<?php
get_footer();
