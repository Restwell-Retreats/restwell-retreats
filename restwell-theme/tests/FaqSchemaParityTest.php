<?php
/**
 * FAQPage schema parity (audit I16): schema is built from the rendered FAQ
 * accordions, so it lists exactly the questions and answers a visitor sees.
 *
 * @package Restwell_Retreats
 */

if ( ! function_exists( 'restwell_jsonld_script_tag' ) ) {
	function restwell_jsonld_script_tag( $schema ) {
		return '<script type="application/ld+json">' . wp_json_encode( $schema ) . '</script>';
	}
}
if ( ! function_exists( 'wp_json_encode' ) ) {
	function wp_json_encode( $data, $options = 0 ) {
		return json_encode( $data, $options );
	}
}

require_once dirname( __DIR__ ) . '/inc/seo/jsonld-faq.php';

class FaqSchemaParityTest extends PHPUnit\Framework\TestCase {

	private function accordion( array $pairs, $hidden_answer = true ) {
		$html = '<div class="faq-list" data-faq-accordion>';
		foreach ( $pairs as $i => $pair ) {
			$html .= '<div class="faq-item"><h3 class="faq-item__heading"><button type="button" class="faq-item__trigger" aria-expanded="false" id="q' . $i . '"><span>' . $pair[0] . '</span><span class="faq-item__icon" aria-hidden="true"></span></button></h3>'
				. '<div class="faq-item__panel" id="q' . $i . '-a" role="region"' . ( $hidden_answer ? ' hidden' : '' ) . '>' . $pair[1] . '</div></div>';
		}
		return $html . '</div>';
	}

	public function test_extracts_every_visible_question_and_answer() {
		$html  = '<html><body><main>' . $this->accordion(
			array(
				array( 'Are dogs allowed?', '<p>Yes, one well-behaved dog.</p>' ),
				array( 'What time is check-in?', '<p>From 3pm, through a <a href="/guest-guide/">key safe</a>.</p>' ),
			)
		) . '</main></body></html>';
		$pairs = restwell_extract_faq_pairs_from_html( $html );
		$this->assertSame(
			array(
				array(
					'q' => 'Are dogs allowed?',
					'a' => 'Yes, one well-behaved dog.',
				),
				array(
					'q' => 'What time is check-in?',
					'a' => 'From 3pm, through a key safe.',
				),
			),
			$pairs
		);
	}

	public function test_lists_a_repeated_question_once_and_keeps_unicode() {
		$html  = '<html><body>' . $this->accordion( array( array( 'What’s included?', 'Everything in the house — and the kit.' ) ) )
			. $this->accordion( array( array( 'What’s included?', 'Everything in the house — and the kit.' ) ) ) . '</body></html>';
		$pairs = restwell_extract_faq_pairs_from_html( $html );
		$this->assertCount( 1, $pairs );
		$this->assertSame( 'What’s included?', $pairs[0]['q'] );
	}

	public function test_no_accordion_means_no_schema() {
		$this->assertSame( array(), restwell_extract_faq_pairs_from_html( '<html><body><p>No FAQs here.</p></body></html>' ) );
	}

	public function test_schema_mirrors_the_pairs() {
		$schema = restwell_build_faq_schema(
			array(
				array(
					'q' => 'Q1',
					'a' => 'A1',
				),
			)
		);
		$this->assertSame( 'FAQPage', $schema['@type'] );
		$this->assertSame( 'Q1', $schema['mainEntity'][0]['name'] );
		$this->assertSame( 'A1', $schema['mainEntity'][0]['acceptedAnswer']['text'] );
	}

	public function test_no_hand_built_faq_schema_is_hooked() {
		$dispatcher = (string) file_get_contents( dirname( __DIR__ ) . '/inc/seo/jsonld.php' );
		$this->assertDoesNotMatchRegularExpression( '/restwell_output_jsonld_\\w*faq\\w*\\(/', $dispatcher );
		$faq = (string) file_get_contents( dirname( __DIR__ ) . '/inc/seo/jsonld-faq.php' );
		$this->assertStringContainsString( "add_filter( 'restwell_front_html', 'restwell_inject_faq_jsonld'", $faq );
	}
}
