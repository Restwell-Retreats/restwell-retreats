<?php
/**
 * Bing Webmaster REST JSON helpers (no SOAP/POX).
 *
 * @package Restwell_Retreats
 */

require_once dirname( __DIR__ ) . '/inc/seo/bing-webmaster.php';

class BingWebmasterTest extends PHPUnit\Framework\TestCase {

	protected function setUp(): void {
		$GLOBALS['restwell_test_options']    = array();
		$GLOBALS['restwell_test_transients'] = array();
	}

	public function test_sanitize_strips_non_alphanumeric() {
		$this->assertSame(
			'aabbccddeeff00112233445566778899',
			restwell_bing_webmaster_sanitize_api_key( " aabbccddeeff00112233445566778899 \n" )
		);
		$this->assertSame( 'AB12', restwell_bing_webmaster_sanitize_api_key( 'AB-12!' ) );
	}

	public function test_unwraps_wcf_d_and_results() {
		$raw = array(
			'd' => array(
				'results' => array(
					array(
						'Url' => 'https://restwellretreats.co.uk/',
					),
				),
			),
		);
		$this->assertSame(
			array(
				array(
					'Url' => 'https://restwellretreats.co.uk/',
				),
			),
			restwell_bing_webmaster_unwrap_payload( $raw )
		);
		$this->assertSame(
			array( 'x' ),
			restwell_bing_webmaster_unwrap_payload( array( 'd' => array( 'x' ) ) )
		);
	}

	public function test_extract_site_urls_from_mixed_rows() {
		$urls = restwell_bing_webmaster_extract_site_urls(
			array(
				array(
					'Url'        => 'https://www.restwellretreats.co.uk/',
					'IsVerified' => true,
				),
				array(
					'url' => 'https://example.com/',
				),
				'https://also.example/',
			)
		);
		$this->assertSame(
			array(
				'https://www.restwellretreats.co.uk/',
				'https://example.com/',
				'https://also.example/',
			),
			$urls
		);
	}

	public function test_normalize_site_url_adds_trailing_slash() {
		$this->assertSame(
			'https://restwellretreats.co.uk/',
			restwell_bing_webmaster_normalize_site_url( 'https://RestwellRetreats.co.uk' )
		);
	}

	public function test_match_prefers_exact_then_www_alias() {
		$home = 'https://restwellretreats.co.uk/';
		$this->assertSame(
			'https://restwellretreats.co.uk/',
			restwell_bing_webmaster_match_verified_site(
				$home,
				array( 'https://other.test/', 'https://restwellretreats.co.uk/' )
			)
		);
		$this->assertSame(
			'https://www.restwellretreats.co.uk/',
			restwell_bing_webmaster_match_verified_site(
				$home,
				array( 'https://www.restwellretreats.co.uk/' )
			)
		);
		$this->assertSame(
			'',
			restwell_bing_webmaster_match_verified_site(
				$home,
				array( 'https://continuitygroup.co.uk/' )
			)
		);
	}

	public function test_build_url_is_json_rest_not_soap_or_pox() {
		$GLOBALS['restwell_test_options']['restwell_bing_webmaster_api_key'] = 'abc123def456';
		$url = restwell_bing_webmaster_build_url(
			'GetUserSites',
			array(
				'siteUrl' => 'https://restwellretreats.co.uk/',
			)
		);
		$this->assertStringContainsString( 'https://ssl.bing.com/webmaster/api.svc/json/GetUserSites?', $url );
		$this->assertStringContainsString( 'apikey=abc123def456', $url );
		$this->assertStringContainsString( 'siteUrl=', $url );
		$this->assertStringNotContainsString( '/soap', $url );
		$this->assertStringNotContainsString( '/pox', $url );
		$batch = restwell_bing_webmaster_build_url( 'SubmitUrlBatch' );
		$this->assertStringContainsString( '/json/SubmitUrlBatch?', $batch );
		$this->assertStringNotContainsString( 'SubmitUrlbatch', $batch );
	}

	public function test_host_mismatch_message_names_both_hosts() {
		$msg = restwell_bing_webmaster_host_mismatch_message(
			'http://restwell.local/',
			array( 'https://restwellretreats.co.uk/' )
		);
		$this->assertStringContainsString( 'http://restwell.local/', $msg );
		$this->assertStringContainsString( 'https://restwellretreats.co.uk/', $msg );
		$this->assertStringContainsString( 'skipped here', $msg );
	}
}
