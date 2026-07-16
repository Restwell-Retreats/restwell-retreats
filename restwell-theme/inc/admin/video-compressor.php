<?php
/**
 * Media Library video compressor.
 *
 * Adds a "Compress for web" button to MP4 attachment detail panels in the
 * Media Library. When clicked, it uses system FFmpeg to produce a compressed
 * H.264 MP4 and a VP9 WebM, then registers both as new WordPress attachments.
 *
 * Loaded only when is_admin() is true (see functions.php).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Transient key for the single-flight video encode lock.
 */
const RESTWELL_VIDEO_COMPRESS_LOCK = 'restwell_video_compress_lock';

// ---------------------------------------------------------------------------
// 1. Attachment detail field — "Compress for web" button
// ---------------------------------------------------------------------------

/**
 * Add the "Compress for web" custom field to MP4 attachment detail panels.
 *
 * Hooked to `attachment_fields_to_edit`. Returns the unmodified $form_fields
 * for any attachment that is not video/mp4 or when the current user cannot
 * upload files.
 *
 * @param array   $form_fields Existing attachment form fields.
 * @param WP_Post $post        Attachment post object.
 * @return array Modified form fields.
 */
function restwell_video_compressor_attachment_fields( $form_fields, $post ) {
	if ( 'video/mp4' !== get_post_mime_type( $post->ID ) ) {
		return $form_fields;
	}

	if ( ! current_user_can( 'upload_files' ) ) {
		return $form_fields;
	}

	// On non-AJAX requests, restrict to the Media Library screen only.
	// During admin-ajax.php calls get_current_screen() returns null — allow
	// through so the detail panel loaded via the Media Library JS still renders.
	if ( ! wp_doing_ajax() && function_exists( 'get_current_screen' ) ) {
		$screen = get_current_screen();
		if ( $screen && 'upload' !== $screen->base ) {
			return $form_fields;
		}
	}

	$source_path  = get_attached_file( $post->ID );
	$dir          = $source_path ? dirname( $source_path ) : '';
	$basename     = $source_path ? pathinfo( $source_path, PATHINFO_FILENAME ) : '';
	$mp4_output   = $dir . '/' . $basename . '-web.mp4';
	$webm_output  = $dir . '/' . $basename . '-web.webm';
	$already_done = ( file_exists( $mp4_output ) || file_exists( $webm_output ) );

	$nonce = wp_create_nonce( 'restwell_compress_video_' . $post->ID );

	$confirm_attr = '';
	if ( $already_done ) {
		$confirm_attr = ' data-confirm="' . esc_attr( __( 'Compressed versions already exist. Overwrite?', 'restwell-retreats' ) ) . '"';
	}

	$html  = '<button type="button"';
	$html .= ' class="button button-secondary"';
	$html .= ' id="restwell-compress-video-btn-' . esc_attr( $post->ID ) . '"';
	$html .= ' data-attachment-id="' . esc_attr( $post->ID ) . '"';
	$html .= ' data-nonce="' . esc_attr( $nonce ) . '"';
	$html .= $confirm_attr;
	$html .= '>' . esc_html__( 'Compress for web', 'restwell-retreats' ) . '</button>';
	$html .= '<p class="description">';
	$html .= esc_html__( 'Strips audio · caps 1080p · outputs MP4 + WebM', 'restwell-retreats' );
	$html .= '</p>';
	$html .= '<div id="restwell-compress-video-status-' . esc_attr( $post->ID ) . '"';
	$html .= ' aria-live="polite" style="margin-top:6px;"></div>';

	$form_fields['restwell_compress_video'] = array(
		'label' => __( 'Compress for web', 'restwell-retreats' ),
		'input' => 'html',
		'html'  => $html,
	);

	return $form_fields;
}
add_filter( 'attachment_fields_to_edit', 'restwell_video_compressor_attachment_fields', 10, 2 );

// ---------------------------------------------------------------------------
// 2. Script enqueue — Media Library (upload) screen only
// ---------------------------------------------------------------------------

/**
 * Enqueue the video compressor JS on the Media Library screen.
 *
 * @param string $hook_suffix Current admin page hook.
 */
function restwell_video_compressor_enqueue_scripts( $hook_suffix ) {
	if ( 'upload' !== $hook_suffix ) {
		return;
	}

	$theme_uri = get_template_directory_uri();
	$version   = function_exists( 'restwell_theme_asset_version' )
		? restwell_theme_asset_version( '/assets/js/admin/video-compressor.js' )
		: wp_get_theme()->get( 'Version' );

	wp_enqueue_script(
		'restwell-video-compressor',
		$theme_uri . '/assets/js/admin/video-compressor.js',
		array(),
		$version,
		true
	);

	wp_localize_script(
		'restwell-video-compressor',
		'rwVideoCompressor',
		array(
			'ajaxurl'       => admin_url( 'admin-ajax.php' ),
			'action'        => 'restwell_compress_video',
			'labelDefault'  => __( 'Compress for web', 'restwell-retreats' ),
			/* translators: ellipsis indicates work in progress */
			'labelWorking'  => __( 'Compressing…', 'restwell-retreats' ),
			'successPrefix' => __( 'Done — MP4 (', 'restwell-retreats' ),
			'successMid'    => __( ' MB) and WebM (', 'restwell-retreats' ),
			'successSuffix' => __( ' MB) saved to your library.', 'restwell-retreats' ),
			'errorFallback' => __( 'Compression failed. Please try again or contact support.', 'restwell-retreats' ),
		)
	);
}
add_action( 'admin_enqueue_scripts', 'restwell_video_compressor_enqueue_scripts' );

// ---------------------------------------------------------------------------
// 3. AJAX handler
// ---------------------------------------------------------------------------

/**
 * Find the FFmpeg binary on the server.
 *
 * Order: filter override, then known absolute paths (no shell PATH lookup).
 * Use the `restwell_ffmpeg_path` filter to point at a custom binary.
 *
 * @return string|false Absolute path to ffmpeg, or false if not found.
 */
function restwell_video_compressor_find_ffmpeg() {
	/**
	 * Filter the absolute path to the ffmpeg binary.
	 *
	 * Return a non-empty string to skip auto-detection.
	 *
	 * @param string|false $path Absolute path, or false to use built-in candidates.
	 */
	$filtered = apply_filters( 'restwell_ffmpeg_path', false );
	if ( is_string( $filtered ) && '' !== $filtered && is_executable( $filtered ) ) {
		return $filtered;
	}

	$candidates = array(
		'/opt/homebrew/bin/ffmpeg',
		'/usr/bin/ffmpeg',
		'/usr/local/bin/ffmpeg',
	);

	foreach ( $candidates as $path ) {
		if ( is_executable( $path ) ) {
			return $path;
		}
	}

	return false;
}

/**
 * Register a compressed video file as a WordPress attachment.
 *
 * If an attachment whose `_wp_attached_file` meta matches the relative path
 * of $file_path already exists, that attachment is updated in place rather
 * than creating a duplicate entry.
 *
 * @param string $file_path   Absolute path to the new file.
 * @param int    $original_id Post ID of the source attachment.
 * @param string $mime_type   MIME type (video/mp4 or video/webm).
 * @return int|WP_Error New or updated attachment post ID, or WP_Error on failure.
 */
function restwell_video_compressor_register_output( $file_path, $original_id, $mime_type ) {
	require_once ABSPATH . 'wp-admin/includes/image.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';

	$upload_dir   = wp_upload_dir();
	$relative     = str_replace( trailingslashit( $upload_dir['basedir'] ), '', $file_path );
	$original_post = get_post( $original_id );
	$parent_id     = $original_post ? $original_post->post_parent : 0;

	// Check for an existing attachment with this relative path to avoid duplicates.
	$existing = get_posts(
		array(
			'post_type'      => 'attachment',
			'posts_per_page' => 1,
			'meta_key'       => '_wp_attached_file',
			'meta_value'     => $relative,
			'fields'         => 'ids',
		)
	);

	if ( ! empty( $existing ) ) {
		$attachment_id = $existing[0];
		$metadata      = wp_generate_attachment_metadata( $attachment_id, $file_path );
		wp_update_attachment_metadata( $attachment_id, $metadata );
		return $attachment_id;
	}

	$original_title = $original_post ? get_the_title( $original_id ) : pathinfo( $file_path, PATHINFO_FILENAME );
	/* translators: %s: original attachment title */
	$new_title = sprintf( __( '%s (web)', 'restwell-retreats' ), $original_title );

	$attachment_data = array(
		'post_mime_type' => $mime_type,
		'post_title'     => sanitize_text_field( $new_title ),
		'post_content'   => '',
		'post_status'    => 'inherit',
		'post_parent'    => $parent_id,
	);

	$attachment_id = wp_insert_attachment( $attachment_data, $file_path, $parent_id );
	if ( is_wp_error( $attachment_id ) ) {
		return $attachment_id;
	}

	$metadata = wp_generate_attachment_metadata( $attachment_id, $file_path );
	wp_update_attachment_metadata( $attachment_id, $metadata );

	return $attachment_id;
}

/**
 * Acquire a simple site-wide encode lock (one compression at a time).
 *
 * @return bool True when this request holds the lock.
 */
function restwell_video_compressor_acquire_lock(): bool {
	if ( false !== get_transient( RESTWELL_VIDEO_COMPRESS_LOCK ) ) {
		return false;
	}
	set_transient( RESTWELL_VIDEO_COMPRESS_LOCK, get_current_user_id() ?: 1, 5 * MINUTE_IN_SECONDS );
	return true;
}

/**
 * Release the site-wide encode lock.
 */
function restwell_video_compressor_release_lock(): void {
	delete_transient( RESTWELL_VIDEO_COMPRESS_LOCK );
}

/**
 * Handle AJAX video compression.
 *
 * Validates the request, runs FFmpeg to produce a compressed MP4 and WebM,
 * registers both as WordPress attachments, and returns JSON.
 */
function restwell_video_compressor_handle_ajax() {
	// Capability gate.
	if ( ! current_user_can( 'upload_files' ) ) {
		wp_send_json(
			array(
				'success' => false,
				'message' => __( 'You do not have permission to compress videos.', 'restwell-retreats' ),
			),
			403
		);
	}

	// Attachment ID.
	$attachment_id = absint( $_POST['attachment_id'] ?? 0 );
	if ( ! $attachment_id ) {
		wp_send_json(
			array(
				'success' => false,
				'message' => __( 'Invalid attachment.', 'restwell-retreats' ),
			),
			400
		);
	}

	// Nonce.
	if ( ! check_ajax_referer( 'restwell_compress_video_' . $attachment_id, 'nonce', false ) ) {
		wp_send_json(
			array(
				'success' => false,
				'message' => __( 'Security check failed. Please reload the page and try again.', 'restwell-retreats' ),
			),
			403
		);
	}

	$attachment = get_post( $attachment_id );
	if ( ! $attachment || 'attachment' !== $attachment->post_type ) {
		wp_send_json(
			array(
				'success' => false,
				'message' => __( 'Invalid attachment.', 'restwell-retreats' ),
			),
			400
		);
	}

	if ( ! current_user_can( 'edit_post', $attachment_id ) ) {
		wp_send_json(
			array(
				'success' => false,
				'message' => __( 'You do not have permission to compress this video.', 'restwell-retreats' ),
			),
			403
		);
	}

	if ( ! restwell_video_compressor_acquire_lock() ) {
		wp_send_json(
			array(
				'success' => false,
				'message' => __( 'Another video is being compressed right now. Please wait for it to finish and try again.', 'restwell-retreats' ),
			),
			429
		);
	}
	register_shutdown_function( 'restwell_video_compressor_release_lock' );

	// Confirm it is a video/mp4 attachment.
	if ( 'video/mp4' !== get_post_mime_type( $attachment_id ) ) {
		wp_send_json(
			array(
				'success' => false,
				'message' => __( 'Attachment is not an MP4 file.', 'restwell-retreats' ),
			),
			400
		);
	}

	// Resolve and validate source path (uploads directory only).
	$source = get_attached_file( $attachment_id );
	if ( ! $source || ! is_readable( $source ) ) {
		wp_send_json(
			array(
				'success' => false,
				'message' => __( 'Source file could not be read.', 'restwell-retreats' ),
			),
			500
		);
	}

	$real_source     = realpath( $source );
	$upload_dir      = wp_upload_dir();
	$real_uploads_dir = ! empty( $upload_dir['basedir'] ) ? realpath( $upload_dir['basedir'] ) : false;

	if ( ! $real_source || ! $real_uploads_dir || 0 !== strpos( $real_source, trailingslashit( $real_uploads_dir ) ) ) {
		error_log( 'restwell_compress_video: rejected path outside uploads dir for attachment ' . $attachment_id );
		wp_send_json(
			array(
				'success' => false,
				'message' => __( 'File path is not permitted.', 'restwell-retreats' ),
			),
			403
		);
	}

	// Give FFmpeg time to finish — this request may take a while.
	// phpcs:ignore WordPress.PHP.IniSet.Risky
	ini_set( 'max_execution_time', '120' );

	// Find FFmpeg.
	$ffmpeg = restwell_video_compressor_find_ffmpeg();
	if ( ! $ffmpeg ) {
		wp_send_json(
			array(
				'success' => false,
				'message' => __( 'FFmpeg not found on this server — ask your host to install it, or set the restwell_ffmpeg_path filter.', 'restwell-retreats' ),
			),
			500
		);
	}

	$dir      = dirname( $real_source );
	$basename = pathinfo( $real_source, PATHINFO_FILENAME );

	// Avoid compressing already-compressed outputs into -web-web.* chains.
	if ( preg_match( '/-web$/i', $basename ) ) {
		wp_send_json(
			array(
				'success' => false,
				'message' => __( 'This file already looks like a web-compressed version. Compress the original MP4 instead.', 'restwell-retreats' ),
			),
			400
		);
	}

	$mp4_output  = $dir . '/' . $basename . '-web.mp4';
	$webm_output = $dir . '/' . $basename . '-web.webm';

	$original_size_mb = file_exists( $real_source ) ? round( filesize( $real_source ) / 1048576, 2 ) : 0;

	// --- MP4 compression ------------------------------------------------
	$mp4_cmd  = escapeshellarg( $ffmpeg );
	$mp4_cmd .= ' -y';
	$mp4_cmd .= ' -i ' . escapeshellarg( $real_source );
	$mp4_cmd .= ' -an';
	$mp4_cmd .= ' -vf ' . escapeshellarg( 'scale=-2:min(ih\,1080)' );
	$mp4_cmd .= ' -c:v libx264';
	$mp4_cmd .= ' -crf 32';
	$mp4_cmd .= ' -preset fast';
	$mp4_cmd .= ' -movflags +faststart';
	$mp4_cmd .= ' ' . escapeshellarg( $mp4_output );
	$mp4_cmd .= ' 2>&1';

	$mp4_exit_code = 0;
	// phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.system_calls_exec
	exec( $mp4_cmd, $mp4_out, $mp4_exit_code );

	if ( 0 !== $mp4_exit_code || ! file_exists( $mp4_output ) ) {
		error_log( 'restwell_compress_video: MP4 compression failed (exit ' . $mp4_exit_code . ') for attachment ' . $attachment_id );
		wp_send_json(
			array(
				'success' => false,
				'message' => __( 'Video compression failed. Please try again or contact support.', 'restwell-retreats' ),
			),
			500
		);
	}

	// --- WebM compression -----------------------------------------------
	$webm_cmd  = escapeshellarg( $ffmpeg );
	$webm_cmd .= ' -y';
	$webm_cmd .= ' -i ' . escapeshellarg( $real_source );
	$webm_cmd .= ' -an';
	$webm_cmd .= ' -vf ' . escapeshellarg( 'scale=-2:min(ih\,1080)' );
	$webm_cmd .= ' -c:v libvpx-vp9';
	$webm_cmd .= ' -crf 35';
	$webm_cmd .= ' -b:v 0';
	$webm_cmd .= ' ' . escapeshellarg( $webm_output );
	$webm_cmd .= ' 2>&1';

	$webm_exit_code = 0;
	// phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.system_calls_exec
	exec( $webm_cmd, $webm_out, $webm_exit_code );

	if ( 0 !== $webm_exit_code || ! file_exists( $webm_output ) ) {
		error_log( 'restwell_compress_video: WebM compression failed (exit ' . $webm_exit_code . ') for attachment ' . $attachment_id );
		// MP4 succeeded but WebM failed — still surface the error clearly.
		wp_send_json(
			array(
				'success' => false,
				'message' => __( 'WebM conversion failed. The compressed MP4 may have been created but WebM was not. Please try again or contact support.', 'restwell-retreats' ),
			),
			500
		);
	}

	// --- Register both outputs in the Media Library ---------------------
	$mp4_id = restwell_video_compressor_register_output( $mp4_output, $attachment_id, 'video/mp4' );
	if ( is_wp_error( $mp4_id ) ) {
		error_log( 'restwell_compress_video: wp_insert_attachment (mp4) failed: ' . $mp4_id->get_error_message() );
		wp_send_json(
			array(
				'success' => false,
				'message' => __( 'Files were compressed but could not be added to the Media Library. Please contact support.', 'restwell-retreats' ),
			),
			500
		);
	}

	$webm_id = restwell_video_compressor_register_output( $webm_output, $attachment_id, 'video/webm' );
	if ( is_wp_error( $webm_id ) ) {
		error_log( 'restwell_compress_video: wp_insert_attachment (webm) failed: ' . $webm_id->get_error_message() );
		wp_send_json(
			array(
				'success' => false,
				'message' => __( 'Files were compressed but could not be added to the Media Library. Please contact support.', 'restwell-retreats' ),
			),
			500
		);
	}

	$mp4_size_mb  = round( filesize( $mp4_output ) / 1048576, 2 );
	$webm_size_mb = round( filesize( $webm_output ) / 1048576, 2 );

	wp_send_json(
		array(
			'success'          => true,
			'mp4_url'          => wp_get_attachment_url( $mp4_id ),
			'webm_url'         => wp_get_attachment_url( $webm_id ),
			'mp4_size_mb'      => $mp4_size_mb,
			'webm_size_mb'     => $webm_size_mb,
			'original_size_mb' => $original_size_mb,
		)
	);
}
add_action( 'wp_ajax_restwell_compress_video', 'restwell_video_compressor_handle_ajax' );
