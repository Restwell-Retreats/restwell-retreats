<?php
/**
 * On-page titles and Our Story host identity (SEO 88 → 100 theme-side).
 *
 * @package Restwell_Retreats
 */

$GLOBALS['restwell_query_flags'] = array(
	'404'      => false,
	'singular' => false,
);

if ( ! function_exists( 'is_404' ) ) {
	function is_404() {
		return ! empty( $GLOBALS['restwell_query_flags']['404'] );
	}
}
if ( ! function_exists( 'is_singular' ) ) {
	function is_singular( $post_types = null ) {
		unset( $post_types );
		return ! empty( $GLOBALS['restwell_query_flags']['singular'] );
	}
}
if ( ! function_exists( 'is_front_page' ) ) {
	function is_front_page() {
		return false;
	}
}
if ( ! function_exists( 'is_home' ) ) {
	function is_home() {
		return false;
	}
}
if ( ! function_exists( 'is_category' ) ) {
	function is_category() {
		return false;
	}
}
if ( ! function_exists( 'is_tag' ) ) {
	function is_tag() {
		return false;
	}
}
if ( ! function_exists( 'is_tax' ) ) {
	function is_tax() {
		return false;
	}
}
if ( ! function_exists( 'is_post_type_archive' ) ) {
	function is_post_type_archive( $post_types = null ) {
		unset( $post_types );
		return false;
	}
}
if ( ! function_exists( 'is_author' ) ) {
	function is_author() {
		return false;
	}
}
if ( ! function_exists( 'is_date' ) ) {
	function is_date() {
		return false;
	}
}
if ( ! function_exists( 'is_search' ) ) {
	function is_search() {
		return false;
	}
}
if ( ! function_exists( 'get_queried_object_id' ) ) {
	function get_queried_object_id() {
		return 0;
	}
}
if ( ! function_exists( 'get_post_meta' ) ) {
	function get_post_meta( $post_id, $key = '', $single = false ) {
		unset( $post_id, $key, $single );
		return '';
	}
}

require_once dirname( __DIR__ ) . '/inc/seo/meta-helpers.php';

class SeoOnpageEeatTest extends PHPUnit\Framework\TestCase {

	protected function setUp(): void {
		$GLOBALS['restwell_query_flags'] = array(
			'404'      => false,
			'singular' => false,
		);
	}

	public function test_build_meta_title_uses_schema_brand_not_wp_site_title() {
		$this->assertSame(
			'Page not found | Restwell Retreats',
			restwell_build_meta_title( 'Page not found' )
		);
	}

	public function test_build_meta_title_does_not_double_restwell_brand() {
		$this->assertSame(
			'Ask us anything about a stay at Restwell',
			restwell_build_meta_title( 'Ask us anything about a stay at Restwell' )
		);
	}

	public function test_404_fallback_title_uses_schema_brand() {
		$GLOBALS['restwell_query_flags']['404'] = true;
		$this->assertSame(
			'Page not found | Restwell Retreats',
			restwell_get_request_level_title_fallback()
		);
	}

	public function test_document_title_parts_injects_404_and_drops_meek_site_suffix() {
		$GLOBALS['restwell_query_flags']['404']      = true;
		$GLOBALS['restwell_query_flags']['singular'] = false;
		$parts                                       = restwell_document_title_parts(
			array(
				'title'   => 'Page not found',
				'site'    => 'restwell',
				'tagline' => '',
			)
		);
		$this->assertSame( 'Page not found | Restwell Retreats', $parts['title'] );
		$this->assertArrayNotHasKey( 'site', $parts );
		$this->assertArrayNotHasKey( 'tagline', $parts );
	}

	public function test_about_page_jsonld_names_the_host() {
		$core  = (string) file_get_contents( dirname( __DIR__ ) . '/inc/seo/jsonld-core.php' );
		$pages = (string) file_get_contents( dirname( __DIR__ ) . '/inc/seo/jsonld-pages.php' );
		$this->assertStringContainsString( 'function restwell_get_host_person_schema', $core );
		$this->assertStringContainsString( "'name'        => 'Victoria Walker'", $core );
		$this->assertStringContainsString( "'founder'     => restwell_get_host_person_schema()", $core );
		$this->assertStringContainsString( 'https://www.cqc.org.uk/location/1-2624556588', $core );
		$this->assertStringContainsString( 'restwell_get_host_person_schema()', $pages );
		$this->assertStringNotContainsString( 'function restwell_get_host_person_schema', $pages );
	}

	public function test_our_story_shows_host_identity_and_verbatim_cite() {
		$php = (string) file_get_contents( dirname( __DIR__ ) . '/template-our-story.php' );
		$this->assertStringContainsString( 'id="host"', $php );
		$this->assertStringContainsString( 'Victoria Walker', $php );
		$this->assertStringContainsString( 'https://www.cqc.org.uk/location/1-2624556588', $php );
		$this->assertStringContainsString( 'not a registered care provider', $php );
		$this->assertStringContainsString( '<cite>M.P.</cite>', $php );
		$this->assertStringContainsString( 'it truly amazes me, just how much work has gone into this', $php );
		$this->assertStringNotContainsString( 'fully accessible', $php );
		$this->assertStringNotContainsString( 'fully-accessible', $php );
	}
}
