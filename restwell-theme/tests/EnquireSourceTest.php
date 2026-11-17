<?php
/**
 * Enquiry source: cleaning posted values and the readable Source label.
 *
 * @package Restwell_Retreats
 */

class EnquireSourceTest extends PHPUnit\Framework\TestCase {

	/**
	 * Posted fields with the capture flag set.
	 *
	 * @param array<string, string> $fields Short name => value.
	 * @return array<string, string>
	 */
	private function post( array $fields ): array {
		$post = array( 'enq_src_v' => '1' );
		foreach ( $fields as $key => $value ) {
			$post[ 'enq_src_' . $key ] = $value;
		}
		return $post;
	}

	private function label( array $fields ): string {
		return restwell_enquiry_source_from_post( $this->post( $fields ) )['source_label'];
	}

	public function test_no_capture_flag_stores_nothing_and_shows_unknown() {
		$src = restwell_enquiry_source_from_post(
			array(
				'enq_src_utm_source' => 'facebook',
				'enq_src_referrer'   => 'google.com',
			)
		);
		$this->assertSame( restwell_enquiry_source_empty(), $src );
		$this->assertSame( 'Unknown', restwell_enquiry_source_display_label( (object) $src ) );
	}

	public function test_legacy_row_without_column_shows_unknown() {
		$this->assertSame( 'Unknown', restwell_enquiry_source_display_label( (object) array( 'id' => 3 ) ) );
	}

	public function test_meta_ad_from_paid_social_utms() {
		$src = restwell_enquiry_source_from_post(
			$this->post(
				array(
					'utm_source'   => 'Facebook',
					'utm_medium'   => 'paid_social',
					'utm_campaign' => 'december_stays',
					'utm_content'  => 'Hoist bedroom video',
					'fbclid'       => '1',
					'landing'      => '/pricing/',
				)
			)
		);
		$this->assertSame( 'Meta ad', $src['source_label'] );
		$this->assertSame( 'facebook', $src['utm_source'] );
		$this->assertSame( 'december_stays', $src['utm_campaign'] );
		$this->assertSame( 'Hoist bedroom video', $src['utm_content'] );
		$this->assertSame( 1, $src['has_fbclid'] );
		$this->assertSame( 0, $src['has_gclid'] );
		$this->assertSame( '/pricing/', $src['landing_path'] );
	}

	public function test_instagram_paid_is_meta_ad() {
		$this->assertSame( 'Meta ad', $this->label( array( 'utm_source' => 'ig', 'utm_medium' => 'cpc' ) ) );
	}

	public function test_fbclid_alone_is_organic() {
		$this->assertSame( 'Facebook or Instagram organic', $this->label( array( 'fbclid' => '1' ) ) );
	}

	public function test_facebook_referrer_is_organic() {
		$this->assertSame( 'Facebook or Instagram organic', $this->label( array( 'referrer' => 'l.facebook.com' ) ) );
		$this->assertSame( 'Facebook or Instagram organic', $this->label( array( 'referrer' => 'www.instagram.com' ) ) );
	}

	public function test_gclid_is_google_ads() {
		$this->assertSame( 'Google ads', $this->label( array( 'gclid' => '1', 'referrer' => 'google.co.uk' ) ) );
	}

	public function test_google_cpc_utms_are_google_ads() {
		$this->assertSame( 'Google ads', $this->label( array( 'utm_source' => 'google', 'utm_medium' => 'cpc' ) ) );
	}

	public function test_google_referrers_are_organic() {
		foreach ( array( 'google.com', 'www.google.co.uk', 'google.de', 'google.com.au', 'com.google.android.googlequicksearchbox' ) as $host ) {
			$this->assertSame( 'Google organic', $this->label( array( 'referrer' => $host ) ), $host );
		}
	}

	public function test_gmail_and_lookalikes_are_not_google_search() {
		$this->assertSame( 'Referral (mail.google.com)', $this->label( array( 'referrer' => 'mail.google.com' ) ) );
		$this->assertSame( 'Referral (notgoogle.com)', $this->label( array( 'referrer' => 'notgoogle.com' ) ) );
	}

	public function test_email_medium() {
		$this->assertSame( 'Email', $this->label( array( 'utm_source' => 'newsletter', 'utm_medium' => 'Email' ) ) );
	}

	public function test_other_search_engines() {
		foreach ( array( 'bing.com', 'duckduckgo.com', 'uk.search.yahoo.com', 'ecosia.org' ) as $host ) {
			$this->assertSame( 'Other search', $this->label( array( 'referrer' => $host ) ), $host );
		}
	}

	public function test_unmatched_campaign_names_its_source() {
		$this->assertSame( 'Other campaign (tiktok)', $this->label( array( 'utm_source' => 'TikTok', 'utm_medium' => 'social' ) ) );
	}

	public function test_referral_and_direct() {
		$this->assertSame( 'Referral (euansguide.com)', $this->label( array( 'referrer' => 'euansguide.com' ) ) );
		$this->assertSame( 'Direct', $this->label( array( 'landing' => '/' ) ) );
	}

	public function test_own_domain_referrer_counts_as_none() {
		$this->assertSame( 'Direct', $this->label( array( 'referrer' => 'www.restwellretreats.co.uk' ) ) );
	}

	public function test_formula_characters_are_stripped() {
		$src = restwell_enquiry_source_from_post(
			$this->post(
				array(
					'utm_campaign' => '=HYPERLINK("http://x","y")',
					'utm_content'  => "+@-cmd|' /C calc'!A0",
					'utm_term'     => "line\none<script>x</script>",
				)
			)
		);
		$this->assertStringStartsNotWith( '=', $src['utm_campaign'] );
		$this->assertSame( "cmd|' /C calc'!A0", $src['utm_content'] );
		$this->assertStringNotContainsString( "\n", $src['utm_term'] );
		$this->assertStringNotContainsString( '<', $src['utm_term'] );
	}

	public function test_values_are_cut_to_column_length() {
		$src = restwell_enquiry_source_from_post( $this->post( array( 'utm_campaign' => str_repeat( 'a', 400 ) ) ) );
		$this->assertSame( 150, strlen( $src['utm_campaign'] ) );
	}

	public function test_bad_paths_and_domains_are_dropped() {
		$this->assertSame( '/pricing/', restwell_enquiry_source_clean_path( '/pricing/?utm_source=x#top' ) );
		$this->assertSame( '', restwell_enquiry_source_clean_path( 'https://evil.example/' ) );
		$this->assertSame( '', restwell_enquiry_source_clean_path( '//evil.example/' ) );
		$this->assertSame( '', restwell_enquiry_source_clean_path( '/a"onmouseover=x' ) );
		$this->assertSame( '', restwell_enquiry_source_clean_domain( 'bad host.com' ) );
		$this->assertSame( '', restwell_enquiry_source_clean_domain( '-x.com' ) );
		$this->assertSame( '', restwell_enquiry_source_clean_domain( 'localhost' ) );
	}

	public function test_click_id_flags_only_accept_one() {
		$src = restwell_enquiry_source_from_post( $this->post( array( 'fbclid' => 'IwAR123', 'gclid' => 'yes' ) ) );
		$this->assertSame( 0, $src['has_fbclid'] );
		$this->assertSame( 0, $src['has_gclid'] );
	}
}
