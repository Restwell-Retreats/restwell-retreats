<?php
/**
 * Guest-guide OTP hash and verify.
 *
 * @package Restwell_Retreats
 */

class GuideOtpTest extends PHPUnit\Framework\TestCase {

	protected function setUp(): void {
		$GLOBALS['restwell_test_transients'] = array();
	}

	public function test_hash_is_deterministic_for_the_same_code() {
		$a = restwell_guide_otp_hash( '123456' );
		$b = restwell_guide_otp_hash( '123456' );
		$this->assertSame( $a, $b );
		$this->assertSame( 64, strlen( $a ) );
	}

	public function test_different_codes_hash_differently() {
		$this->assertNotSame(
			restwell_guide_otp_hash( '123456' ),
			restwell_guide_otp_hash( '123457' )
		);
	}

	public function test_verify_accepts_matching_hash_and_is_single_use() {
		$email = 'guest@example.com';
		$code  = '654321';
		$key   = 'restwell_guide_otp_' . md5( strtolower( $email ) );
		set_transient( $key, restwell_guide_otp_hash( $code ) );

		$this->assertTrue( restwell_verify_guide_otp( $email, $code ) );
		$this->assertFalse( restwell_verify_guide_otp( $email, $code ) );
	}

	public function test_verify_rejects_wrong_code() {
		$email = 'guest@example.com';
		$key   = 'restwell_guide_otp_' . md5( strtolower( $email ) );
		set_transient( $key, restwell_guide_otp_hash( '111111' ) );

		$this->assertFalse( restwell_verify_guide_otp( $email, '222222' ) );
	}

	public function test_verify_rejects_missing_transient() {
		$this->assertFalse( restwell_verify_guide_otp( 'nobody@example.com', '000000' ) );
	}

	public function test_legacy_plaintext_transient_still_matches() {
		$email = 'legacy@example.com';
		$key   = 'restwell_guide_otp_' . md5( strtolower( $email ) );
		set_transient( $key, '888999' );

		$this->assertTrue( restwell_verify_guide_otp( $email, '888999' ) );
	}
}
