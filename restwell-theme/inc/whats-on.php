<?php
/**
 * What's on: the Whitstable guide's hand-entered events.
 *
 * Eight event slots are Page content fields in the guide's "What’s on" tab
 * (wg_event_{n}_name, _start, _end, _time, _venue, _url). The template shows
 * the next six that haven't ended, soonest first. An event hides itself the
 * day after it ends, judged by the site's timezone, so nothing needs deleting.
 * Nothing here makes an outbound request.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const RESTWELL_WHATS_ON_SLOTS = 8;
const RESTWELL_WHATS_ON_SHOW  = 6;
// Saving the page clears slots that ended more than this many days ago.
const RESTWELL_WHATS_ON_TIDY_DAYS = 30;

/**
 * Meta keys for one slot, by part.
 *
 * @param int $slot Slot number, 1 to RESTWELL_WHATS_ON_SLOTS.
 * @return array<string, string> Part => meta key.
 */
function restwell_whats_on_slot_keys( int $slot ): array {
	$keys = array();
	foreach ( array( 'name', 'start', 'end', 'time', 'venue', 'url' ) as $part ) {
		$keys[ $part ] = "wg_event_{$slot}_{$part}";
	}
	return $keys;
}

/**
 * Page content field definitions for the "What’s on" tab.
 *
 * @return array<string, array{label: string, type: string}>
 */
function restwell_whats_on_field_definitions(): array {
	$fields = array();
	for ( $slot = 1; $slot <= RESTWELL_WHATS_ON_SLOTS; $slot++ ) {
		$keys   = restwell_whats_on_slot_keys( $slot );
		$labels = array(
			/* translators: %d: event slot number */
			'name'  => array( __( 'Event %d name (leave empty to skip this slot)', 'restwell-retreats' ), 'text' ),
			/* translators: %d: event slot number */
			'start' => array( __( 'Event %d date (needed for it to show)', 'restwell-retreats' ), 'date' ),
			/* translators: %d: event slot number */
			'end'   => array( __( 'Event %d end date (optional, for events over several days)', 'restwell-retreats' ), 'date' ),
			/* translators: %d: event slot number */
			'time'  => array( __( 'Event %d time (optional, e.g. from 10am)', 'restwell-retreats' ), 'text' ),
			/* translators: %d: event slot number */
			'venue' => array( __( 'Event %d venue or area (e.g. Long Beach)', 'restwell-retreats' ), 'text' ),
			/* translators: %d: event slot number */
			'url'   => array( __( 'Event %d link (optional, the organiser’s page)', 'restwell-retreats' ), 'url' ),
		);
		foreach ( $labels as $part => $label ) {
			$fields[ $keys[ $part ] ] = array(
				'label' => sprintf( $label[0], $slot ),
				'type'  => $label[1],
			);
		}
	}
	return $fields;
}

/**
 * Empty defaults for every slot, merged into the guide's page defaults.
 *
 * @return array<string, string>
 */
function restwell_whats_on_default_values(): array {
	$defaults = array();
	for ( $slot = 1; $slot <= RESTWELL_WHATS_ON_SLOTS; $slot++ ) {
		foreach ( restwell_whats_on_slot_keys( $slot ) as $key ) {
			$defaults[ $key ] = '';
		}
	}
	return $defaults;
}

/**
 * A Y-m-d date string, or empty when the value isn't a real date.
 *
 * @param mixed $value Raw value.
 * @return string
 */
function restwell_whats_on_date( $value ): string {
	$value = is_string( $value ) ? trim( $value ) : '';
	$date  = '' !== $value ? DateTimeImmutable::createFromFormat( '!Y-m-d', $value ) : false;
	return ( $date && $date->format( 'Y-m-d' ) === $value ) ? $value : '';
}

/**
 * Usable events from the slot values. Slots with no name or no valid date are skipped.
 *
 * @param array<string, mixed> $values Meta key => stored value.
 * @return array<int, array{slot: int, name: string, start: string, end: string, time: string, venue: string, url: string}>
 */
function restwell_whats_on_parse_slots( array $values ): array {
	$events = array();
	for ( $slot = 1; $slot <= RESTWELL_WHATS_ON_SLOTS; $slot++ ) {
		$keys = restwell_whats_on_slot_keys( $slot );
		$text = static function ( $part ) use ( $values, $keys ) {
			$value = $values[ $keys[ $part ] ] ?? '';
			return is_scalar( $value ) ? trim( (string) $value ) : '';
		};

		$name  = $text( 'name' );
		$start = restwell_whats_on_date( $text( 'start' ) );
		if ( '' === $name || '' === $start ) {
			continue;
		}
		// An end date on or before the start is a one-day event.
		$end = restwell_whats_on_date( $text( 'end' ) );
		if ( $end <= $start ) {
			$end = '';
		}
		$url    = $text( 'url' );
		$scheme = strtolower( (string) wp_parse_url( $url, PHP_URL_SCHEME ) );
		if ( ! in_array( $scheme, array( 'http', 'https' ), true ) ) {
			$url = '';
		}

		$events[] = array(
			'slot'  => $slot,
			'name'  => $name,
			'start' => $start,
			'end'   => $end,
			'time'  => $text( 'time' ),
			'venue' => $text( 'venue' ),
			'url'   => $url,
		);
	}
	return $events;
}

/**
 * The last day an event runs: its end date if set, otherwise its date.
 *
 * @param array{start: string, end: string} $event Parsed event.
 * @return string Y-m-d.
 */
function restwell_whats_on_last_day( array $event ): string {
	return '' !== $event['end'] ? $event['end'] : $event['start'];
}

/**
 * Events still on or still to come, soonest first.
 *
 * An event shows up to and including its last day and drops off the next day.
 *
 * @param array<int, array> $events Parsed events.
 * @param string            $today  Y-m-d in the site's timezone.
 * @param int               $limit  How many to keep.
 * @return array<int, array>
 */
function restwell_whats_on_upcoming( array $events, string $today, int $limit = RESTWELL_WHATS_ON_SHOW ): array {
	$events = array_values(
		array_filter(
			$events,
			static function ( $event ) use ( $today ) {
				return restwell_whats_on_last_day( $event ) >= $today;
			}
		)
	);
	usort(
		$events,
		static function ( $a, $b ) {
			return array( $a['start'], restwell_whats_on_last_day( $a ), $a['slot'] ) <=> array( $b['start'], restwell_whats_on_last_day( $b ), $b['slot'] );
		}
	);
	return array_slice( $events, 0, $limit );
}

/**
 * Today's date in the site's timezone (Settings → General).
 *
 * @param int|null $now Unix time; null for the current time.
 * @return string Y-m-d.
 */
function restwell_whats_on_today( ?int $now = null ): string {
	$date = null === $now
		? current_datetime()
		: ( new DateTimeImmutable( '@' . $now ) )->setTimezone( wp_timezone() );
	return $date->format( 'Y-m-d' );
}

/**
 * Stored slot values for a page.
 *
 * @param int $post_id Page ID.
 * @return array<string, string> Meta key => value.
 */
function restwell_whats_on_slot_values( int $post_id ): array {
	$values = array();
	foreach ( restwell_whats_on_default_values() as $key => $default ) {
		$values[ $key ] = (string) get_post_meta( $post_id, $key, true );
	}
	return $values;
}

/**
 * The events the guide should show today. Public entry point for the template.
 *
 * @param int $post_id Whitstable guide page ID.
 * @return array<int, array{slot: int, name: string, start: string, end: string, time: string, venue: string, url: string}>
 */
function restwell_whats_on_events( int $post_id ): array {
	if ( $post_id < 1 ) {
		return array();
	}
	return restwell_whats_on_upcoming( restwell_whats_on_parse_slots( restwell_whats_on_slot_values( $post_id ) ), restwell_whats_on_today() );
}

/**
 * The date as one or two parts, each with a machine date for <time datetime="">.
 *
 * "Sat 21 Nov" for one day; "11" and "13 Sep" for a range within a month;
 * "28 Aug" and "2 Sep" across months. The template joins two parts with an en dash.
 *
 * @param array{start: string, end: string} $event Parsed event.
 * @return array<int, array{iso: string, label: string}>
 */
function restwell_whats_on_date_parts( array $event ): array {
	// Noon keeps the timestamp on the same calendar day whatever the clocks do.
	$stamp = static function ( $ymd ) {
		return ( new DateTimeImmutable( $ymd . ' 12:00:00', wp_timezone() ) )->getTimestamp();
	};
	$start = $stamp( $event['start'] );
	if ( '' === $event['end'] ) {
		return array(
			array(
				'iso'   => $event['start'],
				'label' => wp_date( 'D j M', $start ),
			),
		);
	}
	$same_month = substr( $event['start'], 0, 7 ) === substr( $event['end'], 0, 7 );
	return array(
		array(
			'iso'   => $event['start'],
			'label' => wp_date( $same_month ? 'j' : 'j M', $start ),
		),
		array(
			'iso'   => $event['end'],
			'label' => wp_date( 'j M', $stamp( $event['end'] ) ),
		),
	);
}

/**
 * Slots whose event ended more than RESTWELL_WHATS_ON_TIDY_DAYS days ago.
 *
 * @param array<string, mixed> $values Meta key => stored value.
 * @param string               $today  Y-m-d in the site's timezone.
 * @return int[] Slot numbers.
 */
function restwell_whats_on_stale_slots( array $values, string $today ): array {
	$cutoff = ( new DateTimeImmutable( $today ) )->modify( '-' . RESTWELL_WHATS_ON_TIDY_DAYS . ' days' )->format( 'Y-m-d' );
	$stale  = array();
	foreach ( restwell_whats_on_parse_slots( $values ) as $event ) {
		if ( restwell_whats_on_last_day( $event ) < $cutoff ) {
			$stale[] = $event['slot'];
		}
	}
	return $stale;
}

/**
 * On saving the Whitstable guide in wp-admin, empty the slots of long-past events.
 *
 * Housekeeping only, to keep the field list short. The page never depends on
 * it: restwell_whats_on_upcoming() already hides an event the day after it
 * ends, whether or not anyone saves the page.
 *
 * @param int $post_id Page being saved.
 */
function restwell_whats_on_tidy_on_save( int $post_id ): void {
	if ( ! defined( 'RESTWELL_META_NONCE_NAME' ) || ! isset( $_POST[ RESTWELL_META_NONCE_NAME ] )
		|| ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ RESTWELL_META_NONCE_NAME ] ) ), RESTWELL_META_NONCE_ACTION ) ) {
		return;
	}
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( 'template-whitstable-guide.php' !== get_page_template_slug( $post_id ) ) {
		return;
	}
	foreach ( restwell_whats_on_stale_slots( restwell_whats_on_slot_values( $post_id ), restwell_whats_on_today() ) as $slot ) {
		foreach ( restwell_whats_on_slot_keys( $slot ) as $key ) {
			update_post_meta( $post_id, $key, '' );
		}
	}
}
// After restwell_save_page_content_meta_box() (priority 10) has stored the posted fields.
add_action( 'save_post_page', 'restwell_whats_on_tidy_on_save', 20 );
