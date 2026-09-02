<?php
/**
 * copy-overwrites markdown parser.
 *
 * @package Restwell_Retreats
 */

class CopyOverwriteParserTest extends PHPUnit\Framework\TestCase {

	public function test_extracts_title_and_h1() {
		$md = "# Home `/`\n\n## Title\n\nAccessible holiday cottage in Whitstable, sleeps five\n\n## Meta description\n\nOne private bungalow by the sea.\n\n## H1 (`hero_heading`)\n\nAn accessible bungalow by the sea, at your own pace\n";
		$this->assertSame(
			'Accessible holiday cottage in Whitstable, sleeps five',
			restwell_copy_overwrite_section_text( $md, 'Title' )
		);
		$this->assertSame(
			'One private bungalow by the sea.',
			restwell_copy_overwrite_section_text( $md, 'Meta description' )
		);
		$this->assertSame(
			'An accessible bungalow by the sea, at your own pace',
			restwell_copy_overwrite_section_text( $md, 'H1' )
		);
	}

	public function test_h1_key_map() {
		$this->assertSame( 'enq_heading', restwell_copy_overwrite_h1_meta_key( 'enquire' ) );
		$this->assertSame( '', restwell_copy_overwrite_h1_meta_key( 'blog' ) );
		$this->assertSame( '', restwell_copy_overwrite_h1_meta_key( 'guest-guide' ) );
	}

	public function test_guest_guide_brief_has_meta_description() {
		$parsed = restwell_parse_copy_overwrite_file( dirname( __DIR__ ) . '/copy-overwrites/guest-guide.md' );
		$this->assertSame(
			'Check-in, WiFi, bins and the departure list for guests with a booking.',
			$parsed['meta_description']
		);
		$this->assertSame(
			'Restwell guest guide for confirmed stays',
			$parsed['title']
		);
	}
}
