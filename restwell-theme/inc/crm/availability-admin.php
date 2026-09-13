<?php
/**
 * CRM: house availability ICS feed admin screen.
 *
 * Outlook “Website Availability” publish link → public Pricing calendar.
 * Event titles are never stored or shown on the front end.
 *
 * @package Restwell_CRM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Restwell → Availability.
 */
function restwell_crm_register_availability_menu() {
	add_submenu_page(
		'restwell-crm',
		__( 'Availability', 'restwell-retreats' ),
		__( 'Availability', 'restwell-retreats' ),
		restwell_crm_capability(),
		'restwell-availability',
		'restwell_crm_availability_page'
	);
}
add_action( 'admin_menu', 'restwell_crm_register_availability_menu', 6 );

/**
 * Whether the feed URL is locked to wp-config.
 *
 * @return bool
 */
function restwell_crm_ical_from_constant() {
	return defined( 'RESTWELL_ICAL_FEED_URL' )
		&& function_exists( 'restwell_occupancy_sanitize_feed_url' )
		&& '' !== restwell_occupancy_sanitize_feed_url( (string) RESTWELL_ICAL_FEED_URL );
}

/**
 * Render Availability settings.
 */
function restwell_crm_availability_page() {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'You do not have permission to access this page.', 'restwell-retreats' ), '', array( 'response' => 403 ) );
	}

	$from_constant = restwell_crm_ical_from_constant();
	$stored        = (string) get_option( 'restwell_ical_feed_url', '' );
	$configured    = function_exists( 'restwell_occupancy_is_configured' ) && restwell_occupancy_is_configured();
	$pricing_url   = function_exists( 'restwell_nav_resolve_page_url' )
		? restwell_nav_resolve_page_url( 'pricing' )
		: home_url( '/pricing/' );
	$booked_count  = 0;
	if ( $configured && function_exists( 'restwell_get_occupancy_booked' ) ) {
		$payload = restwell_get_occupancy_booked();
		if ( ! empty( $payload['ok'] ) && isset( $payload['dates'] ) && is_array( $payload['dates'] ) ) {
			$booked_count = count( $payload['dates'] );
		}
	}

	$saved   = isset( $_GET['ical_saved'] ) && '1' === sanitize_key( wp_unslash( $_GET['ical_saved'] ) );
	$cleared = isset( $_GET['ical_cleared'] ) && '1' === sanitize_key( wp_unslash( $_GET['ical_cleared'] ) );
	$invalid = isset( $_GET['ical_invalid'] ) && '1' === sanitize_key( wp_unslash( $_GET['ical_invalid'] ) );
	$flushed = isset( $_GET['ical_flushed'] ) && '1' === sanitize_key( wp_unslash( $_GET['ical_flushed'] ) );
	$locked  = isset( $_GET['ical_locked'] ) && '1' === sanitize_key( wp_unslash( $_GET['ical_locked'] ) );
	?>
	<div class="wrap restwell-admin restwell-admin-availability">
		<h1 class="rw-page-title"><?php esc_html_e( 'House availability', 'restwell-retreats' ); ?></h1>

		<?php if ( $saved ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'ICS link saved. The Pricing calendar will refresh within the hour, or use Refresh now below.', 'restwell-retreats' ); ?></p></div>
		<?php endif; ?>
		<?php if ( $cleared ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Stored ICS link cleared.', 'restwell-retreats' ); ?></p></div>
		<?php endif; ?>
		<?php if ( $flushed ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Availability cache refreshed from the feed.', 'restwell-retreats' ); ?></p></div>
		<?php endif; ?>
		<?php if ( $invalid ) : ?>
			<div class="notice notice-error is-dismissible"><p><?php esc_html_e( 'That link was not accepted. Use the HTTPS Outlook Website Availability address that ends in calendar.ics (not the HTML preview page).', 'restwell-retreats' ); ?></p></div>
		<?php endif; ?>
		<?php if ( $locked ) : ?>
			<div class="notice notice-warning is-dismissible"><p><?php esc_html_e( 'RESTWELL_ICAL_FEED_URL is set in wp-config.php, so the field here cannot change the live feed.', 'restwell-retreats' ); ?></p></div>
		<?php endif; ?>

		<p class="description rw-lead">
			<?php
			echo esc_html__(
				'Paste the published Outlook calendar link so Pricing & dates can show when the bungalow is busy. Only busy nights are used — event titles never appear on the website.',
				'restwell-retreats'
			);
			?>
		</p>

		<section class="rw-dash-panel rw-availability-panel">
			<h2 class="rw-dash-panel__title"><?php esc_html_e( 'ICS feed', 'restwell-retreats' ); ?></h2>
			<div class="rw-dash-panel__body">
			<p class="rw-availability-status">
				<strong><?php esc_html_e( 'Status:', 'restwell-retreats' ); ?></strong>
				<?php
				if ( $configured ) {
					echo esc_html(
						$from_constant
							? __( 'Configured via wp-config', 'restwell-retreats' )
							: __( 'Configured', 'restwell-retreats' )
					);
					if ( $booked_count > 0 ) {
						echo ' — ';
						printf(
							/* translators: %d: number of booked night dates cached */
							esc_html( _n( '%d booked night in cache', '%d booked nights in cache', $booked_count, 'restwell-retreats' ) ),
							(int) $booked_count
						);
					}
				} else {
					esc_html_e( 'Not configured — the public calendar has no feed yet.', 'restwell-retreats' );
				}
				?>
			</p>

			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="restwell_save_availability" />
				<?php wp_nonce_field( 'restwell_save_availability' ); ?>

				<p>
					<label for="restwell_ical_feed_url"><strong><?php esc_html_e( 'Outlook ICS link', 'restwell-retreats' ); ?></strong></label><br />
					<input
						type="url"
						class="large-text code"
						id="restwell_ical_feed_url"
						name="restwell_ical_feed_url"
						value="<?php echo esc_attr( $from_constant ? '' : $stored ); ?>"
						placeholder="https://outlook.office365.com/owa/calendar/…/calendar.ics"
						autocomplete="off"
						spellcheck="false"
						<?php disabled( $from_constant ); ?>
					/>
				</p>
				<p class="description">
					<?php
					if ( $from_constant ) {
						esc_html_e( 'Remove RESTWELL_ICAL_FEED_URL from wp-config.php if you want to manage the link here instead.', 'restwell-retreats' );
					} else {
						esc_html_e( 'In Outlook: open the calendar → sharing / publish → Website Availability → copy the ICS address (must end in calendar.ics).', 'restwell-retreats' );
					}
					?>
				</p>

				<?php if ( ! $from_constant && '' !== $stored ) : ?>
				<p>
					<label>
						<input type="checkbox" name="restwell_ical_feed_url_clear" value="1" />
						<?php esc_html_e( 'Clear stored link on save', 'restwell-retreats' ); ?>
					</label>
				</p>
				<?php endif; ?>

				<?php if ( ! $from_constant ) : ?>
					<?php submit_button( __( 'Save ICS link', 'restwell-retreats' ), 'primary', 'submit', false ); ?>
				<?php endif; ?>
			</form>

			<?php if ( $configured ) : ?>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="rw-availability-flush-form">
				<input type="hidden" name="action" value="restwell_flush_availability" />
				<?php wp_nonce_field( 'restwell_flush_availability' ); ?>
				<?php submit_button( __( 'Refresh calendar now', 'restwell-retreats' ), 'secondary', 'submit', false ); ?>
			</form>
			<?php endif; ?>
			</div>
		</section>

		<p class="rw-availability-external">
			<a class="button button-secondary" href="<?php echo esc_url( $pricing_url . '#availability' ); ?>" target="_blank" rel="noopener noreferrer">
				<?php esc_html_e( 'Open Pricing & dates calendar', 'restwell-retreats' ); ?>
			</a>
		</p>
	</div>
	<?php
}

/**
 * Save or clear the ICS option.
 */
function restwell_crm_handle_save_availability() {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'Insufficient permissions.', 'restwell-retreats' ), '', array( 'response' => 403 ) );
	}
	check_admin_referer( 'restwell_save_availability' );

	$redirect = array( 'page' => 'restwell-availability' );

	if ( restwell_crm_ical_from_constant() ) {
		$redirect['ical_locked'] = '1';
		wp_safe_redirect( add_query_arg( $redirect, admin_url( 'admin.php' ) ) );
		exit;
	}

	$clear = isset( $_POST['restwell_ical_feed_url_clear'] )
		&& '1' === sanitize_text_field( wp_unslash( $_POST['restwell_ical_feed_url_clear'] ) );
	$raw   = isset( $_POST['restwell_ical_feed_url'] )
		? trim( (string) wp_unslash( $_POST['restwell_ical_feed_url'] ) )
		: '';

	if ( $clear ) {
		update_option( 'restwell_ical_feed_url', '', false );
		if ( function_exists( 'restwell_occupancy_flush_cache' ) ) {
			restwell_occupancy_flush_cache();
		}
		$redirect['ical_cleared'] = '1';
	} elseif ( '' !== $raw ) {
		$clean = function_exists( 'restwell_occupancy_sanitize_feed_url' )
			? restwell_occupancy_sanitize_feed_url( $raw )
			: '';
		if ( '' === $clean ) {
			$redirect['ical_invalid'] = '1';
		} else {
			update_option( 'restwell_ical_feed_url', $clean, false );
			if ( function_exists( 'restwell_occupancy_flush_cache' ) ) {
				restwell_occupancy_flush_cache();
			}
			$redirect['ical_saved'] = '1';
		}
	}

	wp_safe_redirect( add_query_arg( $redirect, admin_url( 'admin.php' ) ) );
	exit;
}
add_action( 'admin_post_restwell_save_availability', 'restwell_crm_handle_save_availability' );

/**
 * Force a re-fetch of the ICS feed.
 */
function restwell_crm_handle_flush_availability() {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'Insufficient permissions.', 'restwell-retreats' ), '', array( 'response' => 403 ) );
	}
	check_admin_referer( 'restwell_flush_availability' );

	if ( function_exists( 'restwell_occupancy_flush_cache' ) ) {
		restwell_occupancy_flush_cache();
	}
	// Warm the cache so the admin status count updates immediately.
	if ( function_exists( 'restwell_get_occupancy_booked' ) ) {
		restwell_get_occupancy_booked();
	}

	wp_safe_redirect(
		add_query_arg(
			array(
				'page'         => 'restwell-availability',
				'ical_flushed' => '1',
			),
			admin_url( 'admin.php' )
		)
	);
	exit;
}
add_action( 'admin_post_restwell_flush_availability', 'restwell_crm_handle_flush_availability' );
