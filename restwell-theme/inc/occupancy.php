<?php
/**
 * House occupancy from a published Outlook ICS feed.
 *
 * The feed URL is a secret (wp-config constant or non-autoloaded option).
 * Event titles, locations, and descriptions are discarded. Only busy/opaque
 * overnight blocks become booked nights on the public calendar.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const RESTWELL_OCCUPANCY_CACHE_KEY = 'restwell_occupancy_booked_v2';
const RESTWELL_OCCUPANCY_CACHE_TTL = HOUR_IN_SECONDS;
const RESTWELL_OCCUPANCY_MIN_STAY_SECONDS = 21600;

/**
 * ICS feed URL. Constant wins. Never log or print this.
 *
 * @return string
 */
function restwell_occupancy_feed_url() {
	if ( defined( 'RESTWELL_ICAL_FEED_URL' ) ) {
		return restwell_occupancy_sanitize_feed_url( (string) RESTWELL_ICAL_FEED_URL );
	}
	return restwell_occupancy_sanitize_feed_url( (string) get_option( 'restwell_ical_feed_url', '' ) );
}

/**
 * Allow only HTTPS Outlook published calendar.ics URLs.
 *
 * @param string $url Raw URL.
 * @return string Empty when rejected.
 */
function restwell_occupancy_sanitize_feed_url( $url ) {
	$url = trim( (string) $url );
	if ( '' === $url ) {
		return '';
	}
	$clean = function_exists( 'esc_url_raw' ) ? esc_url_raw( $url ) : $url;
	$parts = function_exists( 'wp_parse_url' ) ? wp_parse_url( $clean ) : parse_url( $clean );
	if ( ! is_array( $parts ) ) {
		return '';
	}
	$scheme = isset( $parts['scheme'] ) ? strtolower( (string) $parts['scheme'] ) : '';
	$host   = isset( $parts['host'] ) ? strtolower( (string) $parts['host'] ) : '';
	$path   = isset( $parts['path'] ) ? strtolower( (string) $parts['path'] ) : '';
	$ok_host = in_array(
		$host,
		array(
			'outlook.office365.com',
			'outlook.office.com',
			'outlook.live.com',
		),
		true
	);
	if ( 'https' !== $scheme || ! $ok_host ) {
		return '';
	}
	if ( ! preg_match( '/\/calendar\.ics$/', $path ) ) {
		return '';
	}
	return $clean;
}

/**
 * Whether a public calendar can be attempted.
 *
 * @return bool
 */
function restwell_occupancy_is_configured() {
	return '' !== restwell_occupancy_feed_url();
}

/**
 * Map Windows / ICS TZIDs onto IANA zones. Default London.
 *
 * @param string $tzid ICS TZID.
 * @return DateTimeZone
 */
function restwell_occupancy_timezone_from_tzid( $tzid ) {
	$tzid = trim( (string) $tzid );
	$map  = array(
		'GMT Standard Time'       => 'Europe/London',
		'Greenwich Standard Time' => 'Europe/London',
		'UTC'                     => 'UTC',
	);
	$name = isset( $map[ $tzid ] ) ? $map[ $tzid ] : $tzid;
	try {
		return new DateTimeZone( $name );
	} catch ( Exception $e ) {
		unset( $e );
		return new DateTimeZone( 'Europe/London' );
	}
}

/**
 * Unfold RFC 5545 folded lines.
 *
 * @param string $raw ICS body.
 * @return string[]
 */
function restwell_occupancy_unfold_ics_lines( $raw ) {
	$raw   = str_replace( array( "\r\n", "\r" ), "\n", (string) $raw );
	$lines = explode( "\n", $raw );
	$out   = array();
	foreach ( $lines as $line ) {
		if ( '' !== $line && isset( $line[0] ) && ( ' ' === $line[0] || "\t" === $line[0] ) && array() !== $out ) {
			$out[ count( $out ) - 1 ] .= substr( $line, 1 );
			continue;
		}
		$out[] = $line;
	}
	return $out;
}

/**
 * Parse DTSTART / DTEND into a London DateTime. False on failure.
 *
 * @param string $spec ICS value (may include TZID= in the property name side — pass full right-hand value).
 * @param string $params Property parameters string (e.g. TZID=GMT Standard Time or VALUE=DATE).
 * @return DateTime|false
 */
function restwell_occupancy_parse_ics_datetime( $spec, $params ) {
	$spec   = trim( (string) $spec );
	$params = (string) $params;
	$london = new DateTimeZone( 'Europe/London' );

	if ( false !== stripos( $params, 'VALUE=DATE' ) || preg_match( '/^\d{8}$/', $spec ) ) {
		if ( ! preg_match( '/^(\d{4})(\d{2})(\d{2})$/', $spec, $m ) ) {
			return false;
		}
		try {
			return new DateTime( $m[1] . '-' . $m[2] . '-' . $m[3] . ' 00:00:00', $london );
		} catch ( Exception $e ) {
			unset( $e );
			return false;
		}
	}

	$tz = $london;
	if ( preg_match( '/TZID=([^;]+)/i', $params, $tz_m ) ) {
		$tz = restwell_occupancy_timezone_from_tzid( $tz_m[1] );
	}

	$utc = ( strlen( $spec ) && 'Z' === strtoupper( substr( $spec, -1 ) ) );
	if ( $utc ) {
		$spec = substr( $spec, 0, -1 );
		$tz   = new DateTimeZone( 'UTC' );
	}

	if ( preg_match( '/^(\d{4})(\d{2})(\d{2})T(\d{2})(\d{2})(\d{2})$/', $spec, $m ) ) {
		try {
			$dt = new DateTime(
				$m[1] . '-' . $m[2] . '-' . $m[3] . ' ' . $m[4] . ':' . $m[5] . ':' . $m[6],
				$tz
			);
			$dt->setTimezone( $london );
			return $dt;
		} catch ( Exception $e ) {
			unset( $e );
			return false;
		}
	}

	return false;
}

/**
 * Whether an event should occupy the house diary.
 *
 * @param array{busy?:string,transp?:string} $meta Event flags.
 * @return bool
 */
function restwell_occupancy_event_is_busy( array $meta ) {
	$busy = isset( $meta['busy'] ) ? strtoupper( (string) $meta['busy'] ) : '';
	if ( 'FREE' === $busy ) {
		return false;
	}
	if ( in_array( $busy, array( 'BUSY', 'TENTATIVE', 'OOF' ), true ) ) {
		return true;
	}
	$transp = isset( $meta['transp'] ) ? strtoupper( (string) $meta['transp'] ) : '';
	return 'TRANSPARENT' !== $transp;
}

/**
 * Booked night dates (Y-m-d, Europe/London) from an ICS string.
 * Titles and locations are never returned.
 *
 * @param string $raw ICS body.
 * @return string[] Sorted unique dates.
 */
function restwell_occupancy_parse_ics( $raw ) {
	$lines  = restwell_occupancy_unfold_ics_lines( $raw );
	$booked = array();
	$in     = false;
	$start  = false;
	$end    = false;
	$meta   = array();

	$flush = static function () use ( &$booked, &$start, &$end, &$meta ) {
		if ( $start instanceof DateTime && $end instanceof DateTime && restwell_occupancy_event_is_busy( $meta ) ) {
			$nights = restwell_occupancy_nights_for_interval( $start, $end );
			foreach ( $nights as $night ) {
				$booked[ $night ] = true;
			}
		}
		$start = false;
		$end   = false;
		$meta  = array();
	};

	foreach ( $lines as $line ) {
		if ( 'BEGIN:VEVENT' === $line ) {
			$in    = true;
			$start = false;
			$end   = false;
			$meta  = array();
			continue;
		}
		if ( 'END:VEVENT' === $line ) {
			if ( $in ) {
				$flush();
			}
			$in = false;
			continue;
		}
		if ( ! $in ) {
			continue;
		}
		$colon = strpos( $line, ':' );
		if ( false === $colon ) {
			continue;
		}
		$left   = substr( $line, 0, $colon );
		$value  = substr( $line, $colon + 1 );
		$semi   = strpos( $left, ';' );
		$name   = strtoupper( false === $semi ? $left : substr( $left, 0, $semi ) );
		$params = false === $semi ? '' : substr( $left, $semi + 1 );

		if ( 'DTSTART' === $name ) {
			$start = restwell_occupancy_parse_ics_datetime( $value, $params );
		} elseif ( 'DTEND' === $name ) {
			$end = restwell_occupancy_parse_ics_datetime( $value, $params );
		} elseif ( 'TRANSP' === $name ) {
			$meta['transp'] = $value;
		} elseif ( 'X-MICROSOFT-CDO-BUSYSTATUS' === $name ) {
			$meta['busy'] = $value;
		}
	}

	$dates = array_keys( $booked );
	sort( $dates, SORT_STRING );
	return $dates;
}

/**
 * Nights occupied by a stay. Checkout morning is not a booked night.
 * An all-day or midnight-starting block also holds the previous night
 * (guests would still be in until 11:00 that morning).
 * Events shorter than RESTWELL_OCCUPANCY_MIN_STAY_SECONDS are ignored.
 *
 * @param DateTime $start Inclusive.
 * @param DateTime $end   Exclusive-ish timed end (Outlook checkout 11:00).
 * @return string[]
 */
function restwell_occupancy_nights_for_interval( DateTime $start, DateTime $end ) {
	if ( $end <= $start ) {
		return array();
	}
	if ( ( $end->getTimestamp() - $start->getTimestamp() ) < RESTWELL_OCCUPANCY_MIN_STAY_SECONDS ) {
		return array();
	}

	$london = new DateTimeZone( 'Europe/London' );
	$cursor = clone $start;
	$cursor->setTimezone( $london );
	$cursor->setTime( 0, 0, 0 );
	// A midnight or morning start overlaps the previous night's 11:00 checkout.
	$cursor->modify( '-1 day' );
	$last = clone $end;
	$last->setTimezone( $london );
	$last->setTime( 0, 0, 0 );

	$nights = array();
	$guard  = 0;
	while ( $cursor <= $last && $guard < 400 ) {
		++$guard;
		$night_start = clone $cursor;
		$night_start->setTime( 15, 0, 0 );
		$night_end = clone $cursor;
		$night_end->modify( '+1 day' );
		$night_end->setTime( 11, 0, 0 );
		if ( $start < $night_end && $end > $night_start ) {
			$nights[] = $cursor->format( 'Y-m-d' );
		}
		$cursor->modify( '+1 day' );
	}

	return $nights;
}

/**
 * Fetch and cache booked nights. Empty array on failure (caller hides the UI).
 *
 * @return array{ok:bool,dates:string[]}
 */
function restwell_get_occupancy_booked() {
	$cached = get_transient( RESTWELL_OCCUPANCY_CACHE_KEY );
	if ( is_array( $cached ) && isset( $cached['ok'], $cached['dates'] ) && is_array( $cached['dates'] ) ) {
		return array(
			'ok'    => (bool) $cached['ok'],
			'dates' => array_values( array_map( 'strval', $cached['dates'] ) ),
		);
	}

	$empty = array(
		'ok'    => false,
		'dates' => array(),
	);
	$url   = restwell_occupancy_feed_url();
	if ( '' === $url || ! function_exists( 'wp_remote_get' ) ) {
		set_transient( RESTWELL_OCCUPANCY_CACHE_KEY, $empty, 15 * MINUTE_IN_SECONDS );
		return $empty;
	}

	$response = wp_remote_get(
		$url,
		array(
			'timeout'    => 10,
			'user-agent' => 'RestwellOccupancy/1.0',
			'headers'    => array(
				'Accept' => 'text/calendar',
			),
		)
	);

	if ( is_wp_error( $response ) || 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
		set_transient( RESTWELL_OCCUPANCY_CACHE_KEY, $empty, 15 * MINUTE_IN_SECONDS );
		return $empty;
	}

	$body = (string) wp_remote_retrieve_body( $response );
	if ( 0 !== strpos( ltrim( $body ), 'BEGIN:VCALENDAR' ) ) {
		set_transient( RESTWELL_OCCUPANCY_CACHE_KEY, $empty, 15 * MINUTE_IN_SECONDS );
		return $empty;
	}

	$payload = array(
		'ok'    => true,
		'dates' => restwell_occupancy_parse_ics( $body ),
	);
	set_transient( RESTWELL_OCCUPANCY_CACHE_KEY, $payload, RESTWELL_OCCUPANCY_CACHE_TTL );
	return $payload;
}

/**
 * Collapse booked ISO nights into inclusive start/end ranges.
 *
 * @param string[] $dates Y-m-d nights.
 * @return array<int,array{start:string,end:string}>
 */
function restwell_occupancy_booked_ranges( $dates ) {
	$dates = array_values(
		array_unique(
			array_filter(
				array_map( 'strval', (array) $dates )
			)
		)
	);
	sort( $dates );
	$ranges = array();
	$start  = '';
	$end    = '';
	foreach ( $dates as $iso ) {
		if ( ! preg_match( '/^\d{4}-\d{2}-\d{2}$/', $iso ) ) {
			continue;
		}
		if ( '' === $start ) {
			$start = $iso;
			$end   = $iso;
			continue;
		}
		$expect = DateTime::createFromFormat( '!Y-m-d', $end, new DateTimeZone( 'UTC' ) );
		if ( ! $expect ) {
			$start = $iso;
			$end   = $iso;
			continue;
		}
		$expect->modify( '+1 day' );
		if ( $iso === $expect->format( 'Y-m-d' ) ) {
			$end = $iso;
			continue;
		}
		$ranges[] = array(
			'start' => $start,
			'end'   => $end,
		);
		$start = $iso;
		$end   = $iso;
	}
	if ( '' !== $start ) {
		$ranges[] = array(
			'start' => $start,
			'end'   => $end,
		);
	}
	return $ranges;
}

/**
 * Public label for a booked-night range (no year; the month heading owns that).
 *
 * @param string $start Y-m-d.
 * @param string $end   Y-m-d.
 * @return string
 */
function restwell_occupancy_format_range_label( $start, $end ) {
	$tz = new DateTimeZone( 'Europe/London' );
	$a  = DateTime::createFromFormat( '!Y-m-d', (string) $start, $tz );
	$b  = DateTime::createFromFormat( '!Y-m-d', (string) $end, $tz );
	if ( ! $a || ! $b ) {
		return '';
	}
	if ( $start === $end ) {
		return $a->format( 'j F' );
	}
	if ( $a->format( 'Y-m' ) === $b->format( 'Y-m' ) ) {
		return $a->format( 'j' ) . '–' . $b->format( 'j F' );
	}
	return $a->format( 'j F' ) . ' – ' . $b->format( 'j F' );
}

/**
 * Strict Y-m-d (public query args for the enquire form).
 *
 * @param mixed $value Raw value.
 * @return string Valid date or empty string.
 */
function restwell_occupancy_sanitize_ymd( $value ) {
	$raw = is_string( $value ) ? trim( $value ) : '';
	if ( ! preg_match( '/^\d{4}-\d{2}-\d{2}$/', $raw ) ) {
		return '';
	}
	$dt = DateTime::createFromFormat( '!Y-m-d', $raw );
	if ( ! $dt || $dt->format( 'Y-m-d' ) !== $raw ) {
		return '';
	}
	return $raw;
}

/**
 * Drop the occupancy cache (after the feed URL changes).
 */
function restwell_occupancy_flush_cache() {
	delete_transient( RESTWELL_OCCUPANCY_CACHE_KEY );
}
