<?php
/**
 * Theme setup: logo and partner asset sideloading.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function restwell_get_logo_url( $mod_key, $fallback_filename ) {
	$att_id = (int) get_theme_mod( $mod_key, 0 );
	if ( $att_id > 0 ) {
		// Prefer a right-sized derivative; small originals have no medium_large crop.
		$url = wp_get_attachment_image_url( $att_id, 'medium_large' );
		if ( ! $url ) {
			$url = wp_get_attachment_url( $att_id );
		}
		if ( $url ) {
			return $url;
		}
	}
	return restwell_theme_image_url( $fallback_filename );
}

/**
 * Canonical brand lockup for the horizontal logo (matches “Restwell by …” in long_logo artwork).
 *
 * @return string Translatable site brand line.
 */
function restwell_site_brand_lockup() {
	return __( 'Restwell by Continuity of Care Services', 'restwell-retreats' );
}

/**
 * Sideload the three theme logos into the Media Library and store attachment IDs
 * as theme mods. Idempotent; skips files already uploaded.
 *
 * Theme mods set:
 *   restwell_logo_long_id     → long_logo.png  (horizontal, used in header/footer)
 *   restwell_logo_stacked_id  → logo.png        (stacked, available for custom use)
 *   restwell_logo_infinity_id → restwellinfinity.png  (icon only, available for custom use)
 *
 * @param array $result Result array passed by reference; keys logos_uploaded,
 *                      logos_skipped, logos_missing, logos_failed are appended.
 */
function restwell_upload_theme_logos( array &$result ) {
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$logos = array(
		'restwell_logo_long_id'     => 'long_logo.png',
		'restwell_logo_stacked_id'  => 'logo.png',
		'restwell_logo_infinity_id' => 'restwellinfinity.png',
	);

	foreach ( $logos as $mod_key => $filename ) {
		// Already uploaded: verify the attachment still exists in the DB.
		$existing_id = (int) get_theme_mod( $mod_key, 0 );
		if ( $existing_id > 0 && get_post( $existing_id ) ) {
			$result['logos_skipped'][] = $filename;
			continue;
		}

		$file_path = get_template_directory() . '/assets/images/' . $filename;
		if ( ! file_exists( $file_path ) ) {
			$result['logos_missing'][] = $filename;
			continue;
		}

		// Copy to a temp path; media_handle_sideload moves/deletes the tmp file.
		$tmp = wp_tempnam( $filename );
		// phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
		if ( ! @copy( $file_path, $tmp ) ) {
			$result['logos_failed'][] = $filename;
			continue;
		}

		$att_id = media_handle_sideload(
			array(
				'name'     => $filename,
				'tmp_name' => $tmp,
			),
			0,
			''
		);

		if ( is_wp_error( $att_id ) ) {
			// phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
			@unlink( $tmp );
			$result['logos_failed'][] = $filename;
		} else {
			set_theme_mod( $mod_key, $att_id );
			if ( function_exists( 'restwell_maybe_set_attachment_alt_from_theme_map' ) ) {
				restwell_maybe_set_attachment_alt_from_theme_map( (int) $att_id, $filename );
			}
			$result['logos_uploaded'][] = $filename;
		}
	}
}

/**
 * Upload homepage partner logos from theme assets into Media Library and map
 * attachment IDs to Home page partner meta keys.
 *
 * Expected source folder:
 *   /assets/images/partners/
 *
 * Supported filenames per partner (first match wins):
 *   - care-spaces.(png|jpg|jpeg|webp|svg)
 *   - thor-carpentry.(png|jpg|jpeg|webp|svg)
 *   - wealden-rehab.(png|jpg|jpeg|webp|svg)
 *   - continuity-of-care-services.(png|jpg|jpeg|webp|svg)
 *   - continuity-training-academy.(png|jpg|jpeg|webp|svg)
 *
 * @param int   $home_id Home page ID.
 * @param array $result  Setup result array (appends partner_logo_* keys).
 * @param bool  $force   If true, re-upload and remap even when meta already has
 *                       an attachment ID.
 */
function restwell_upload_partner_logos( $home_id, array &$result, $force = false ) {
	$home_id = (int) $home_id;
	if ( $home_id < 1 ) {
		return;
	}

	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$partner_folder = trailingslashit( get_template_directory() ) . 'assets/images/partners/';
	$extensions     = array( 'png', 'jpg', 'jpeg', 'webp', 'svg' );

	$partner_logo_map = array(
		array(
			'meta_key'   => 'home_partner_1_logo_id',
			'base_names' => array( 'care-spaces' ),
		),
		array(
			'meta_key'   => 'home_partner_2_logo_id',
			'base_names' => array( 'thor-carpentry' ),
		),
		array(
			'meta_key'   => 'home_partner_3_logo_id',
			'base_names' => array( 'wealden-rehab' ),
		),
		array(
			'meta_key'   => 'home_partner_4_logo_id',
			'base_names' => array( 'continuity-of-care-services' ),
		),
		array(
			'meta_key'   => 'home_partner_5_logo_id',
			'base_names' => array( 'continuity-training-academy' ),
		),
	);

	foreach ( $partner_logo_map as $partner_logo ) {
		$meta_key = (string) $partner_logo['meta_key'];

		$existing_id = (int) get_post_meta( $home_id, $meta_key, true );
		if ( ! $force && $existing_id > 0 && get_post( $existing_id ) ) {
			$result['partner_logos_skipped'][] = $meta_key;
			continue;
		}

		$matched_filename = '';
		$matched_path     = '';
		foreach ( (array) $partner_logo['base_names'] as $base_name ) {
			foreach ( $extensions as $ext ) {
				$candidate = $base_name . '.' . $ext;
				$path      = $partner_folder . $candidate;
				if ( file_exists( $path ) ) {
					$matched_filename = $candidate;
					$matched_path     = $path;
					break 2;
				}
			}
		}

		if ( $matched_path === '' ) {
			$result['partner_logos_missing'][] = $meta_key;
			continue;
		}

		$tmp = wp_tempnam( $matched_filename );
		// phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
		if ( ! @copy( $matched_path, $tmp ) ) {
			$result['partner_logos_failed'][] = $meta_key;
			continue;
		}

		$att_id = media_handle_sideload(
			array(
				'name'     => $matched_filename,
				'tmp_name' => $tmp,
			),
			$home_id,
			''
		);

		if ( is_wp_error( $att_id ) ) {
			// phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
			@unlink( $tmp );
			$result['partner_logos_failed'][] = $meta_key;
			continue;
		}

		update_post_meta( $home_id, $meta_key, (int) $att_id );
		if ( function_exists( 'restwell_maybe_set_attachment_alt_from_theme_map' ) ) {
			restwell_maybe_set_attachment_alt_from_theme_map( (int) $att_id, 'partners/' . $matched_filename );
		}
		$result['partner_logos_uploaded'][] = $matched_filename . ' -> ' . $meta_key;
	}
}
