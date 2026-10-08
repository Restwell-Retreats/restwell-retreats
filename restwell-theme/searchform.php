<?php
/**
 * Site search form (get_search_form()). Used on search results and the 404,
 * matching the SearchAction declared in the WebSite schema (audit I30).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$restwell_search_id = wp_unique_id( 'site-search-' );
?>
<form role="search" method="get" class="site-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="field site-search__field">
		<label for="<?php echo esc_attr( $restwell_search_id ); ?>"><?php esc_html_e( 'Search guides and pages', 'restwell-retreats' ); ?></label>
		<div class="site-search__row">
			<input type="search" id="<?php echo esc_attr( $restwell_search_id ); ?>" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" autocomplete="off" placeholder="<?php esc_attr_e( 'For example, hoist or parking', 'restwell-retreats' ); ?>" />
			<button type="submit" class="btn btn-gold"><?php esc_html_e( 'Search', 'restwell-retreats' ); ?></button>
		</div>
	</div>
</form>
