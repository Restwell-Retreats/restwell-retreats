<?php
/**
 * Header template — mockup chrome (shared.css / shared.js).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$enquire_url = function_exists( 'restwell_nav_resolve_page_url' ) ? restwell_nav_resolve_page_url( 'enquire' ) : home_url( '/enquire/' );
$header_class = 'site-header';
// Solid chrome when there is no photo hero to fade over (policies, guest guide, etc.).
$photo_hero = function_exists( 'restwell_page_has_photo_hero' ) && restwell_page_has_photo_hero();
if ( ! is_front_page() && ! $photo_hero ) {
	$header_class .= ' is-solid';
}
$logo_url = function_exists( 'restwell_get_logo_url' ) ? restwell_get_logo_url( 'restwell_logo_long_id', 'long_logo.png' ) : '';
$brand    = function_exists( 'restwell_site_brand_lockup' ) ? restwell_site_brand_lockup() : get_bloginfo( 'name' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<nav class="skip-links" aria-label="<?php esc_attr_e( 'Skip links', 'restwell-retreats' ); ?>">
	<a href="#main-content" class="skip-link"><?php esc_html_e( 'Skip to main content', 'restwell-retreats' ); ?></a>
</nav>
<header class="<?php echo esc_attr( $header_class ); ?>">
	<div class="container site-header__inner">
		<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php if ( $logo_url ) : ?>
				<img
					src="<?php echo esc_url( $logo_url ); ?>"
					alt="<?php echo esc_attr( $brand ); ?>"
					class="site-logo__img"
					width="282"
					height="44"
				>
			<?php else : ?>
				<?php echo esc_html( $brand ); ?>
			<?php endif; ?>
		</a>

		<nav aria-label="<?php esc_attr_e( 'Primary', 'restwell-retreats' ); ?>">
			<?php
			// Prefer concept fallback IA (mockup source of truth). Assigned Primary menus
			// can be re-enabled with Restwell_Concept_Nav_Walker once curated in WP admin.
			restwell_render_primary_nav_fallback();
			?>
		</nav>

		<div class="site-header__actions">
			<a class="btn btn-gold" href="<?php echo esc_url( $enquire_url ); ?>"><?php esc_html_e( 'Enquire Now', 'restwell-retreats' ); ?></a>
			<button type="button" class="nav-toggle" aria-expanded="false" aria-controls="mobile-nav" aria-label="<?php esc_attr_e( 'Open menu', 'restwell-retreats' ); ?>">
				<span class="nav-toggle__icon" aria-hidden="true"><span></span></span>
			</button>
		</div>
	</div>

	<nav class="mobile-nav" id="mobile-nav" aria-label="<?php esc_attr_e( 'Mobile', 'restwell-retreats' ); ?>">
		<?php restwell_render_mobile_nav(); ?>
	</nav>
</header>
