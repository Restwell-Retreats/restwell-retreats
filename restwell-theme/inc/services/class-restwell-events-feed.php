<?php
/**
 * Events feed: upcoming events near the bungalow from the Data Thistle API.
 *
 * Boundary: template-whitstable-guide.php reads events through this class (via
 * restwell_service_events_feed()). The API is only ever called server-side,
 * so guests' browsers never contact Data Thistle and no cookies are set.
 *
 * API (https://api.datathistle.com/openapi/index.html): GET /v1/events with
 * the access token as a Bearer header. A lat/lon/distance query comes back
 * ordered by distance whatever `order` says, so the feed reads up to three
 * pages and sorts by date itself.
 *
 * Caching: the normalised list sits in a transient for 12 hours, so a warm
 * page load makes no API call. The last good fetch is also kept in an option
 * and served when a fetch fails or comes back empty, but never once it is
 * more than 24 hours old: Data Thistle's API terms limit caching to 24 hours.
 *
 * Key: SEO → Site-wide → Data Thistle API key, or RESTWELL_DATATHISTLE_KEY in
 * wp-config.php, which wins. Saving Site-wide clears the cached list.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fetch, normalise and cache upcoming events around Tankerton.
 */
final class Restwell_Events_Feed {

	const API_URL = 'https://api.datathistle.com/v1/events';

	const KEY_OPTION       = 'restwell_datathistle_api_key';
	const CACHE_KEY        = 'restwell_events_feed_v1';
	const LAST_GOOD_OPTION = 'restwell_events_feed_last_good';

	const CACHE_TTL = 12 * HOUR_IN_SECONDS;
	// After a failed fetch, wait this long before asking again, so a broken
	// key or an outage doesn't slow every visit to the page.
	const RETRY_TTL = HOUR_IN_SECONDS;
	// Data Thistle API terms: cache for 24 hours at most.
	const MAX_AGE = DAY_IN_SECONDS;

	// Tankerton, by the bungalow.
	const LAT          = 51.3630;
	const LON          = 1.0480;
	const RADIUS_MILES = 4;
	const WINDOW_DAYS  = 14;

	// The API's largest page. Three pages keeps the nearest 60 events.
	const PAGE_SIZE = 20;
	const MAX_PAGES = 3;
	// Don't start another page once a fetch has taken this long.
	const PAGE_BUDGET_SECONDS = 4;

	const SHOW = 6;
	// Cache a few spare so the list stays full as the day's events pass.
	const KEEP = 12;

	// Cinema listings carry a performance most days, so they would fill all six places.
	const EXCLUDED_TAGS = array( 'film' );

	const TIMEZONE = 'Europe/London';

	/**
	 * Configured access token: the wp-config constant wins over the saved option.
	 *
	 * @return string Empty when unset.
	 */
	public function api_key(): string {
		$key = defined( 'RESTWELL_DATATHISTLE_KEY' ) ? (string) constant( 'RESTWELL_DATATHISTLE_KEY' ) : '';
		if ( '' === trim( $key ) ) {
			$key = (string) get_option( self::KEY_OPTION, '' );
		}
		return self::sanitize_api_key( $key );
	}

	/**
	 * Whether the key comes from wp-config.php (the admin field is then unused).
	 *
	 * @return bool
	 */
	public function key_from_constant(): bool {
		return defined( 'RESTWELL_DATATHISTLE_KEY' ) && '' !== trim( (string) constant( 'RESTWELL_DATATHISTLE_KEY' ) );
	}

	/**
	 * Keep only the characters a Bearer token can hold (RFC 6750 b64token).
	 *
	 * @param string $key Raw key.
	 * @return string
	 */
	public static function sanitize_api_key( string $key ): string {
		return (string) preg_replace( '#[^A-Za-z0-9\-._~+/=]#', '', $key );
	}

	/**
	 * Upcoming events, soonest first. Public entry point for templates.
	 *
	 * @param int      $limit How many to return.
	 * @param int|null $now   Current Unix time (tests pass a fixed clock).
	 * @return array<int, array{title: string, start: int, all_day: bool, venue: string, town: string, url: string}>
	 */
	public function get_events( int $limit = self::SHOW, ?int $now = null ): array {
		if ( '' === $this->api_key() ) {
			return array();
		}
		$now = null === $now ? time() : $now;

		$payload = get_transient( self::CACHE_KEY );
		if ( ! is_array( $payload ) ) {
			$payload = $this->refresh( $now );
		}
		if ( $now - (int) ( $payload['fetched_at'] ?? 0 ) > self::MAX_AGE ) {
			return array();
		}

		$today  = self::start_of_day( $now );
		$events = array();
		foreach ( (array) ( $payload['events'] ?? array() ) as $event ) {
			if ( ! is_array( $event ) || ! isset( $event['start'] ) ) {
				continue;
			}
			// A dated event with no time stays listed until its day ends.
			if ( (int) $event['start'] < ( empty( $event['all_day'] ) ? $now : $today ) ) {
				continue;
			}
			$events[] = $event;
			if ( count( $events ) >= $limit ) {
				break;
			}
		}
		return $events;
	}

	/**
	 * The cached payload as it stands, for the admin status line. No API call.
	 *
	 * @return array{fetched_at?: int, events?: array, error?: string}|null Null when nothing is cached.
	 */
	public function cached_payload(): ?array {
		$payload = get_transient( self::CACHE_KEY );
		return is_array( $payload ) ? $payload : null;
	}

	/**
	 * Drop the cached list so the next page view fetches again.
	 *
	 * @param bool $forget_last_good Also drop the last good copy (when the key is removed).
	 */
	public function flush( bool $forget_last_good = false ): void {
		delete_transient( self::CACHE_KEY );
		if ( $forget_last_good ) {
			delete_option( self::LAST_GOOD_OPTION );
		}
	}

	/**
	 * Fetch from the API, cache the result, and fall back to the last good copy.
	 *
	 * @param int $now Current Unix time.
	 * @return array{fetched_at: int, events: array, error: string}
	 */
	private function refresh( int $now ): array {
		$fetched = $this->fetch( $now );

		if ( '' === $fetched['error'] && $fetched['events'] ) {
			$payload = array(
				'fetched_at' => $now,
				'events'     => $fetched['events'],
				'error'      => '',
			);
			set_transient( self::CACHE_KEY, $payload, self::CACHE_TTL );
			update_option( self::LAST_GOOD_OPTION, $payload, false );
			return $payload;
		}

		$error = '' !== $fetched['error'] ? $fetched['error'] : 'no upcoming events in the response';
		self::log( $error );

		$last_good = get_option( self::LAST_GOOD_OPTION, array() );
		$payload   = array(
			'fetched_at' => is_array( $last_good ) ? (int) ( $last_good['fetched_at'] ?? 0 ) : 0,
			'events'     => is_array( $last_good ) ? (array) ( $last_good['events'] ?? array() ) : array(),
			'error'      => $error,
		);
		set_transient( self::CACHE_KEY, $payload, self::RETRY_TTL );
		return $payload;
	}

	/**
	 * Read up to MAX_PAGES pages and normalise them, soonest first.
	 *
	 * @param int $now Current Unix time.
	 * @return array{events: array, error: string} Error is empty on success.
	 */
	private function fetch( int $now ): array {
		if ( ! function_exists( 'wp_remote_get' ) ) {
			return array(
				'events' => array(),
				'error'  => 'wp_remote_get is unavailable',
			);
		}

		$from    = self::start_of_day( $now );
		$started = microtime( true );
		$raw     = array();

		for ( $page = 1; $page <= self::MAX_PAGES; $page++ ) {
			$url = add_query_arg(
				array_map(
					'rawurlencode',
					array(
						'lat'      => (string) self::LAT,
						'lon'      => (string) self::LON,
						'distance' => (string) self::RADIUS_MILES,
						'min_date' => gmdate( 'Y-m-d\TH:i:s.000\Z', $from ),
						'max_date' => gmdate( 'Y-m-d\TH:i:s.000\Z', $from + self::WINDOW_DAYS * DAY_IN_SECONDS ),
						'limit'    => (string) self::PAGE_SIZE,
						'page'     => (string) $page,
					)
				),
				self::API_URL
			);

			$response = wp_remote_get(
				$url,
				array(
					'timeout' => 5,
					'headers' => array(
						'Authorization' => 'Bearer ' . $this->api_key(),
						'Accept'        => 'application/json',
					),
				)
			);

			$error = '';
			$rows  = null;
			if ( is_wp_error( $response ) ) {
				$error = 'request failed: ' . $response->get_error_message();
			} else {
				$code = (int) wp_remote_retrieve_response_code( $response );
				$body = json_decode( (string) wp_remote_retrieve_body( $response ), true );
				if ( 200 !== $code ) {
					$api_error = is_array( $body ) && isset( $body['error'] ) && is_scalar( $body['error'] ) ? ' ' . sanitize_text_field( (string) $body['error'] ) : '';
					$error     = 'HTTP ' . $code . $api_error;
				} elseif ( ! is_array( $body ) || array_values( $body ) !== $body ) {
					$error = 'response was not a JSON list';
				} else {
					$rows = $body;
				}
			}

			if ( null === $rows ) {
				// A later page failing still leaves the nearest events from the first.
				if ( 1 === $page ) {
					return array(
						'events' => array(),
						'error'  => $error,
					);
				}
				self::log( 'page ' . $page . ' ' . $error );
				break;
			}

			foreach ( $rows as $row ) {
				if ( is_array( $row ) ) {
					$raw[] = $row;
				}
			}
			if ( count( $rows ) < self::PAGE_SIZE || microtime( true ) - $started > self::PAGE_BUDGET_SECONDS ) {
				break;
			}
		}

		$events = array();
		foreach ( $raw as $row ) {
			$event = self::normalise_event( $row, $now );
			if ( $event ) {
				$events[] = $event;
			}
		}
		usort(
			$events,
			static function ( $a, $b ) {
				return array( $a['start'], $a['title'] ) <=> array( $b['start'], $b['title'] );
			}
		);

		return array(
			'events' => array_slice( $events, 0, self::KEEP ),
			'error'  => '',
		);
	}

	/**
	 * One API event as the fields the template prints, using its next performance.
	 *
	 * Drops events with no usable date or link, and those with an excluded tag.
	 *
	 * @param array<string, mixed> $raw Event object from /v1/events.
	 * @param int                  $now Current Unix time.
	 * @return array{title: string, start: int, all_day: bool, venue: string, town: string, url: string}|array{} Empty when unusable.
	 */
	public static function normalise_event( array $raw, int $now ): array {
		if ( isset( $raw['status'] ) && 'live' !== $raw['status'] ) {
			return array();
		}
		$title = self::clean_text( $raw['name'] ?? '' );
		if ( '' === $title ) {
			return array();
		}
		$tags = array();
		foreach ( (array) ( $raw['tags'] ?? array() ) as $tag ) {
			if ( is_string( $tag ) ) {
				$tags[] = strtolower( trim( $tag ) );
			}
		}
		if ( array_intersect( self::EXCLUDED_TAGS, $tags ) ) {
			return array();
		}

		$today = self::start_of_day( $now );
		$next  = null;
		foreach ( (array) ( $raw['schedules'] ?? array() ) as $schedule ) {
			if ( ! is_array( $schedule ) ) {
				continue;
			}
			foreach ( (array) ( $schedule['performances'] ?? array() ) as $performance ) {
				if ( ! is_array( $performance ) || ! isset( $performance['ts'] ) || ! is_string( $performance['ts'] ) ) {
					continue;
				}
				$start = self::parse_timestamp( $performance['ts'] );
				if ( null === $start ) {
					continue;
				}
				// time_unknown holds text such as "Times vary"; ts then carries the date only.
				$all_day = ! empty( $performance['time_unknown'] ) || 10 === strlen( trim( $performance['ts'] ) );
				if ( $start < ( $all_day ? $today : $now ) ) {
					continue;
				}
				if ( null === $next || $start < $next['start'] ) {
					$next = array(
						'start'       => $start,
						'all_day'     => $all_day,
						'place'       => isset( $schedule['place'] ) && is_array( $schedule['place'] ) ? $schedule['place'] : array(),
						'performance' => $performance,
					);
				}
			}
		}
		if ( null === $next ) {
			return array();
		}

		// The organiser's own site first, then the booking link for that performance.
		$url = self::clean_url( $raw['website'] ?? '' );
		if ( '' === $url ) {
			foreach ( (array) ( $next['performance']['links'] ?? array() ) as $link ) {
				if ( is_array( $link ) && 'booking' === ( $link['type'] ?? '' ) ) {
					$url = self::clean_url( $link['url'] ?? '' );
					if ( '' !== $url ) {
						break;
					}
				}
			}
		}
		if ( '' === $url ) {
			return array();
		}

		return array(
			'title'   => $title,
			'start'   => $next['start'],
			'all_day' => $next['all_day'],
			'venue'   => self::clean_text( $next['place']['name'] ?? '' ),
			'town'    => self::clean_text( $next['place']['town'] ?? '' ),
			'url'     => $url,
		);
	}

	/**
	 * Unix time from an API timestamp. Times with no offset are UK local time.
	 *
	 * @param string $value e.g. "2025-04-01T10:30:00+01:00", "2025-04-10 18:45:00+01", "2025-04-01".
	 * @return int|null Null when unparseable.
	 */
	private static function parse_timestamp( string $value ): ?int {
		$value = trim( $value );
		if ( '' === $value ) {
			return null;
		}
		try {
			$date = new DateTimeImmutable( $value, new DateTimeZone( self::TIMEZONE ) );
		} catch ( Exception $e ) {
			return null;
		}
		return $date->getTimestamp();
	}

	/**
	 * Midnight in the UK on the day of the given time.
	 *
	 * @param int $time Unix time.
	 * @return int
	 */
	private static function start_of_day( int $time ): int {
		$zone = new DateTimeZone( self::TIMEZONE );
		return ( new DateTimeImmutable( '@' . $time ) )->setTimezone( $zone )->setTime( 0, 0 )->getTimestamp();
	}

	/**
	 * Plain text from an API string: entities decoded, then tags and line breaks stripped.
	 *
	 * @param mixed $value Raw value.
	 * @return string
	 */
	private static function clean_text( $value ): string {
		if ( ! is_scalar( $value ) ) {
			return '';
		}
		return sanitize_text_field( html_entity_decode( (string) $value, ENT_QUOTES | ENT_HTML5, 'UTF-8' ) );
	}

	/**
	 * An http(s) URL with a host, or an empty string.
	 *
	 * @param mixed $value Raw value.
	 * @return string
	 */
	private static function clean_url( $value ): string {
		if ( ! is_string( $value ) || '' === trim( $value ) ) {
			return '';
		}
		$url    = esc_url_raw( trim( $value ), array( 'http', 'https' ) );
		$scheme = strtolower( (string) wp_parse_url( $url, PHP_URL_SCHEME ) );
		$host   = (string) wp_parse_url( $url, PHP_URL_HOST );
		return ( in_array( $scheme, array( 'http', 'https' ), true ) && '' !== $host ) ? $url : '';
	}

	/**
	 * Note a failed fetch in the PHP error log, only while WP_DEBUG is on.
	 *
	 * @param string $message What went wrong (never the key).
	 */
	private static function log( string $message ): void {
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log -- debug-only feed diagnostics.
			error_log( 'Restwell events feed: ' . $message );
		}
	}
}
