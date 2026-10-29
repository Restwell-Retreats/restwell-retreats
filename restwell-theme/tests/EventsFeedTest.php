<?php
/**
 * Data Thistle events feed: normalising, caching and the last-good fallback.
 *
 * The HTTP API is stubbed: each wp_remote_get() takes the next queued
 * response and records the URL, so a test can count API calls.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'DAY_IN_SECONDS' ) ) {
	define( 'DAY_IN_SECONDS', 86400 );
}
if ( ! class_exists( 'WP_Error' ) ) {
	class WP_Error {
		private $message;
		public function __construct( $code = '', $message = '' ) {
			unset( $code );
			$this->message = $message;
		}
		public function get_error_message() {
			return $this->message;
		}
	}
}
if ( ! function_exists( 'is_wp_error' ) ) {
	function is_wp_error( $thing ) {
		return $thing instanceof WP_Error;
	}
}
if ( ! function_exists( 'wp_remote_get' ) ) {
	function wp_remote_get( $url, $args = array() ) {
		$GLOBALS['restwell_test_http_calls'][] = array( $url, $args );
		if ( empty( $GLOBALS['restwell_test_http'] ) ) {
			return new WP_Error( 'http_request_failed', 'no stubbed response' );
		}
		return array_shift( $GLOBALS['restwell_test_http'] );
	}
}
if ( ! function_exists( 'wp_remote_retrieve_response_code' ) ) {
	function wp_remote_retrieve_response_code( $response ) {
		return $response['response']['code'] ?? '';
	}
}
if ( ! function_exists( 'wp_remote_retrieve_body' ) ) {
	function wp_remote_retrieve_body( $response ) {
		return $response['body'] ?? '';
	}
}
if ( ! function_exists( 'add_query_arg' ) ) {
	function add_query_arg( $args, $url ) {
		$pairs = array();
		foreach ( $args as $key => $value ) {
			$pairs[] = $key . '=' . $value;
		}
		return $url . '?' . implode( '&', $pairs );
	}
}
if ( ! function_exists( 'delete_option' ) ) {
	function delete_option( $option ) {
		unset( $GLOBALS['restwell_test_options'][ $option ] );
		return true;
	}
}

require_once dirname( __DIR__ ) . '/inc/services/class-restwell-events-feed.php';

class EventsFeedTest extends PHPUnit\Framework\TestCase {

	/** Fri 20 Nov 2026, 12:00 in London (GMT). */
	private const NOW = 1795176000;

	protected function setUp(): void {
		$GLOBALS['restwell_test_options']    = array();
		$GLOBALS['restwell_test_transients'] = array();
		$GLOBALS['restwell_test_http']       = array();
		$GLOBALS['restwell_test_http_calls'] = array();
	}

	private function feed_with_key(): Restwell_Events_Feed {
		update_option( Restwell_Events_Feed::KEY_OPTION, 'header.payload.sig' );
		return new Restwell_Events_Feed();
	}

	private static function ok( array $rows ): array {
		return array(
			'response' => array( 'code' => 200 ),
			'body'     => json_encode( $rows ),
		);
	}

	private static function event( string $name, string $ts, array $extra = array() ): array {
		return array_merge(
			array(
				'name'      => $name,
				'status'    => 'live',
				'website'   => 'https://example.org/' . rawurlencode( strtolower( $name ) ),
				'schedules' => array(
					array(
						'place'        => array(
							'name' => 'The Horsebridge',
							'town' => 'Whitstable',
						),
						'performances' => array( array( 'ts' => $ts ) ),
					),
				),
			),
			$extra
		);
	}

	public function test_no_key_means_no_request_and_no_events() {
		$feed = new Restwell_Events_Feed();
		$this->assertSame( array(), $feed->get_events( 6, self::NOW ) );
		$this->assertSame( array(), $GLOBALS['restwell_test_http_calls'] );
	}

	public function test_cold_cache_fetches_once_then_serves_the_transient() {
		$feed                          = $this->feed_with_key();
		$GLOBALS['restwell_test_http'] = array(
			self::ok(
				array(
					self::event( 'Later', '2026-11-25T19:30:00+00:00' ),
					self::event( 'Sooner', '2026-11-21 20:00:00+00' ),
				)
			),
		);

		$events = $feed->get_events( 6, self::NOW );
		$this->assertSame( array( 'Sooner', 'Later' ), array_column( $events, 'title' ) );
		$this->assertCount( 1, $GLOBALS['restwell_test_http_calls'] );

		list( $url, $args ) = $GLOBALS['restwell_test_http_calls'][0];
		$this->assertStringStartsWith( 'https://api.datathistle.com/v1/events?', $url );
		// Other tests' add_query_arg() stubs encode again, so decode to compare.
		parse_str( (string) parse_url( $url, PHP_URL_QUERY ), $query );
		$query = array_map( 'rawurldecode', $query );
		$this->assertSame( array( '51.363', '1.048', '4' ), array( $query['lat'], $query['lon'], $query['distance'] ) );
		$this->assertSame( '2026-11-20T00:00:00.000Z', $query['min_date'], 'From the start of today in London.' );
		$this->assertSame( '2026-12-04T00:00:00.000Z', $query['max_date'] );
		$this->assertSame( 'Bearer header.payload.sig', $args['headers']['Authorization'] );
		$this->assertSame( 5, $args['timeout'] );

		$this->assertCount( 2, ( new Restwell_Events_Feed() )->get_events( 6, self::NOW ) );
		$this->assertCount( 1, $GLOBALS['restwell_test_http_calls'], 'A warm transient must not call the API.' );
	}

	public function test_failed_request_serves_the_last_good_copy_and_backs_off() {
		$feed                          = $this->feed_with_key();
		$GLOBALS['restwell_test_http'] = array( self::ok( array( self::event( 'Quiz', '2026-11-22T20:00:00Z' ) ) ) );
		$feed->get_events( 6, self::NOW );

		$feed->flush();
		$GLOBALS['restwell_test_http'] = array( new WP_Error( 'http_request_failed', 'cURL error 28' ) );
		$this->assertSame( array( 'Quiz' ), array_column( $feed->get_events( 6, self::NOW + 60 ), 'title' ) );
		$this->assertStringContainsString( 'cURL error 28', $feed->cached_payload()['error'] );

		$feed->get_events( 6, self::NOW + 120 );
		$this->assertCount( 2, $GLOBALS['restwell_test_http_calls'], 'The retry window must not call the API again.' );
	}

	public function test_empty_or_unauthorised_responses_keep_the_last_good_copy() {
		$feed                          = $this->feed_with_key();
		$GLOBALS['restwell_test_http'] = array( self::ok( array( self::event( 'Quiz', '2026-11-22T20:00:00Z' ) ) ) );
		$feed->get_events( 6, self::NOW );

		foreach ( array(
			self::ok( array() ),
			array(
				'response' => array( 'code' => 401 ),
				'body'     => json_encode( array( 'error' => 'Unauthorized' ) ),
			),
			self::ok( array( 'status' => 200 ) ),
		) as $response ) {
			$feed->flush();
			$GLOBALS['restwell_test_http'] = array( $response );
			$this->assertSame( array( 'Quiz' ), array_column( $feed->get_events( 6, self::NOW + 60 ), 'title' ) );
		}
		$this->assertSame( 'response was not a JSON list', $feed->cached_payload()['error'] );
	}

	public function test_last_good_copy_older_than_a_day_is_not_shown() {
		$feed                          = $this->feed_with_key();
		$GLOBALS['restwell_test_http'] = array( self::ok( array( self::event( 'Quiz', '2026-11-25T20:00:00Z' ) ) ) );
		$feed->get_events( 6, self::NOW );

		$feed->flush();
		$this->assertSame( array(), $feed->get_events( 6, self::NOW + DAY_IN_SECONDS + 60 ) );
	}

	public function test_passed_events_drop_out_but_dated_ones_last_the_day() {
		$feed                          = $this->feed_with_key();
		$GLOBALS['restwell_test_http'] = array(
			self::ok(
				array(
					self::event( 'Matinee', '2026-11-20T14:00:00Z' ),
					self::event(
						'Market',
						'2026-11-20',
						array(
							'schedules' => array(
								array(
									'place'        => array( 'name' => 'South Quay', 'town' => 'Whitstable' ),
									'performances' => array(
										array(
											'ts'           => '2026-11-20',
											'time_unknown' => 'Times vary',
										),
									),
								),
							),
						)
					),
				)
			),
		);
		$this->assertSame( array( 'Market', 'Matinee' ), array_column( $feed->get_events( 6, self::NOW ), 'title' ) );
		// 6pm: the matinee has started; the market runs to the end of the day.
		$this->assertSame( array( 'Market' ), array_column( $feed->get_events( 6, self::NOW + 6 * HOUR_IN_SECONDS ), 'title' ) );
	}

	public function test_full_pages_are_followed_up_to_the_page_limit() {
		$feed = $this->feed_with_key();
		$page = array();
		for ( $i = 0; $i < Restwell_Events_Feed::PAGE_SIZE; $i++ ) {
			$page[] = self::event( 'Event ' . $i, '2026-11-2' . ( 1 + $i % 8 ) . 'T19:00:00Z' );
		}
		$GLOBALS['restwell_test_http'] = array( self::ok( $page ), self::ok( array( self::event( 'Last', '2026-11-21T09:00:00Z' ) ) ) );

		$events = $feed->get_events( 6, self::NOW );
		$this->assertCount( 2, $GLOBALS['restwell_test_http_calls'] );
		$this->assertStringContainsString( '&page=2', $GLOBALS['restwell_test_http_calls'][1][0] );
		$this->assertSame( 'Last', $events[0]['title'], 'Results are sorted by date across pages.' );
		$this->assertCount( Restwell_Events_Feed::KEEP, $feed->cached_payload()['events'] );
	}

	public function test_normalise_cleans_text_and_drops_unusable_events() {
		$now = self::NOW;

		$event = Restwell_Events_Feed::normalise_event( self::event( 'Folk &amp; Shanty <b>Night</b>', '2026-11-21T19:30:00Z' ), $now );
		$this->assertSame( 'Folk & Shanty Night', $event['title'] );
		$this->assertSame( 'The Horsebridge', $event['venue'] );
		$this->assertSame( 'Whitstable', $event['town'] );
		$this->assertFalse( $event['all_day'] );

		$this->assertSame( array(), Restwell_Events_Feed::normalise_event( self::event( 'Old', '2026-11-19T19:30:00Z' ), $now ), 'No upcoming performance.' );
		$this->assertSame( array(), Restwell_Events_Feed::normalise_event( self::event( 'Film', '2026-11-21T19:30:00Z', array( 'tags' => array( 'Film' ) ) ), $now ) );
		$this->assertSame( array(), Restwell_Events_Feed::normalise_event( self::event( 'Gone', '2026-11-21T19:30:00Z', array( 'status' => 'deleted' ) ), $now ) );
		$this->assertSame( array(), Restwell_Events_Feed::normalise_event( self::event( 'Bad link', '2026-11-21T19:30:00Z', array( 'website' => 'javascript:alert(1)' ) ), $now ) );
		$this->assertSame( array(), Restwell_Events_Feed::normalise_event( self::event( 'No link', '2026-11-21T19:30:00Z', array( 'website' => '' ) ), $now ) );
		$this->assertSame( array(), Restwell_Events_Feed::normalise_event( self::event( 'No date', 'not a date' ), $now ) );
	}

	public function test_booking_link_stands_in_for_a_missing_website() {
		$raw = self::event( 'Gig', '2026-11-21T19:30:00Z', array( 'website' => '' ) );

		$raw['schedules'][0]['performances'][0]['links'] = array(
			array(
				'type' => 'social',
				'url'  => 'https://social.example/gig',
			),
			array(
				'type' => 'booking',
				'url'  => 'https://tickets.example/gig',
			),
		);
		$this->assertSame( 'https://tickets.example/gig', Restwell_Events_Feed::normalise_event( $raw, self::NOW )['url'] );
	}

	public function test_api_key_keeps_bearer_token_characters_only() {
		$this->assertSame( 'abc.DEF-123_~+/=', Restwell_Events_Feed::sanitize_api_key( " abc.DEF-123_~+/= \n\t!<>" ) );
	}
}
