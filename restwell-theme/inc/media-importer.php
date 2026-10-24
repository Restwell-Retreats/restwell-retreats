<?php
/**
 * Restwell media importer: the photo zip from a theme release, and photo
 * descriptions from a CSV.
 *
 * Releases ship the photos as a second zip (tools/build-release-zips.sh). This
 * screen unpacks it into the theme, so nobody needs the host's file manager.
 * The browser sends the zip in small pieces, because hosts often cap uploads
 * below its size; the last piece unpacks it.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'admin_menu', 'restwell_register_media_importer_page' );

function restwell_register_media_importer_page() {
	add_media_page(
		__( 'Restwell Media Import', 'restwell-retreats' ),
		__( 'Restwell Media Import', 'restwell-retreats' ),
		'upload_files',
		'restwell-media-import',
		'restwell_render_media_importer_page'
	);
}

function restwell_render_media_importer_page() {
	if ( ! current_user_can( 'upload_files' ) ) {
		wp_die( esc_html__( 'You do not have permission to import media metadata.', 'restwell-retreats' ) );
	}
	$result = null;
	if ( isset( $_POST['restwell_media_import'] ) ) {
		check_admin_referer( 'restwell_import_media', 'restwell_media_nonce' );
		$result = restwell_import_media_metadata();
	}
	// Without JavaScript the zip arrives in one piece, so the host's upload limit applies.
	$zip_result = null;
	if ( isset( $_POST['restwell_media_zip_import'] ) && current_user_can( 'install_themes' ) ) {
		check_admin_referer( 'restwell_media_zip', 'restwell_media_zip_nonce' );
		$zip_result = restwell_media_zip_import_from_form();
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Restwell Media Import', 'restwell-retreats' ); ?></h1>
		<?php if ( current_user_can( 'install_themes' ) ) : ?>
			<h2><?php esc_html_e( 'Photos from a theme release', 'restwell-retreats' ); ?></h2>
			<p><?php esc_html_e( 'After uploading the theme zip, upload the media zip (restwell-theme-media-…zip) here. Its photos replace the ones in the theme folder, and the page photos update on the next page load.', 'restwell-retreats' ); ?></p>
			<?php if ( is_wp_error( $zip_result ) ) : ?>
				<div class="notice notice-error"><p><?php echo esc_html( $zip_result->get_error_message() ); ?></p></div>
			<?php elseif ( is_array( $zip_result ) ) : ?>
				<div class="notice notice-success is-dismissible"><p><?php echo esc_html( restwell_media_zip_result_message( $zip_result ) ); ?></p></div>
			<?php endif; ?>
			<form id="restwell-media-zip-form" method="post" enctype="multipart/form-data">
				<?php wp_nonce_field( 'restwell_media_zip', 'restwell_media_zip_nonce' ); ?>
				<input type="file" name="restwell_media_zip" accept=".zip,application/zip" required />
				<?php submit_button( __( 'Upload photos', 'restwell-retreats' ), 'primary', 'restwell_media_zip_import' ); ?>
				<p class="restwell-media-zip__status" role="status" aria-live="polite"></p>
			</form>
			<h2><?php esc_html_e( 'Photo descriptions', 'restwell-retreats' ); ?></h2>
		<?php endif; ?>
		<p><?php esc_html_e( 'Choose media-metadata.csv to update the titles, captions and alt text of photos already in the Media Library. Existing values are replaced.', 'restwell-retreats' ); ?></p>
		<?php if ( is_array( $result ) ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php echo esc_html( sprintf( /* translators: 1: number of media items imported, 2: number of rows that could not be matched. */ __( 'Imported %1$d media items. %2$d rows could not be matched.', 'restwell-retreats' ), $result['matched'], $result['skipped'] ) ); ?></p></div>
			<?php if ( ! empty( $result['missing'] ) ) : ?>
				<p><strong><?php esc_html_e( 'Unmatched filenames:', 'restwell-retreats' ); ?></strong> <?php echo esc_html( implode( ', ', $result['missing'] ) ); ?></p>
			<?php endif; ?>
		<?php endif; ?>
		<form method="post" enctype="multipart/form-data">
			<?php wp_nonce_field( 'restwell_import_media', 'restwell_media_nonce' ); ?>
			<input type="file" name="restwell_media_csv" accept=".csv,text/csv" required />
			<?php submit_button( __( 'Import Media Metadata', 'restwell-retreats' ), 'primary', 'restwell_media_import' ); ?>
		</form>
	</div>
	<?php
}

function restwell_import_media_metadata() {
	// Re-verified here, not just in the caller: this function reads $_FILES directly.
	check_admin_referer( 'restwell_import_media', 'restwell_media_nonce' );

	$result = array(
		'matched' => 0,
		'skipped' => 0,
		'missing' => array(),
	);
	if ( empty( $_FILES['restwell_media_csv']['tmp_name'] ) || ! is_uploaded_file( $_FILES['restwell_media_csv']['tmp_name'] ) ) {
		return $result;
	}
	$handle = fopen( $_FILES['restwell_media_csv']['tmp_name'], 'r' );
	if ( false === $handle ) {
		return $result;
	}
	$header  = fgetcsv( $handle );
	$columns = array();
	if ( is_array( $header ) ) {
		foreach ( $header as $index => $column ) {
			$columns[ sanitize_key( preg_replace( '/^\xEF\xBB\xBF/', '', $column ) ) ] = $index;
		}
	}
	$attachments = get_posts(
		array(
			'post_type' => 'attachment',
			'post_status' => 'inherit',
			'posts_per_page' => -1,
			'fields' => 'ids',
			'no_found_rows' => true,
		)
	);
	$attachment_map = array();
	foreach ( $attachments as $attachment_id ) {
		$file = get_post_meta( $attachment_id, '_wp_attached_file', true );
		if ( $file ) {
			$attachment_map[ strtolower( wp_basename( $file ) ) ] = (int) $attachment_id;
		}
	}
	while ( false !== ( $row = fgetcsv( $handle ) ) ) {
		$filename = restwell_csv_value( $row, $columns, 'filename' );
		$key      = restwell_media_match_key( $filename, $attachment_map );
		if ( '' === $key || empty( $attachment_map[ $key ] ) ) {
			$result['skipped']++;
			if ( '' !== $filename ) {
				$result['missing'][] = $filename;
			}
			continue;
		}
		$attachment_id = $attachment_map[ $key ];
		wp_update_post(
			array(
				'ID' => $attachment_id,
				'post_title' => restwell_csv_value( $row, $columns, 'title' ),
				'post_excerpt' => restwell_csv_value( $row, $columns, 'caption' ),
				'post_content' => restwell_csv_value( $row, $columns, 'description' ),
			)
		);
		$alt_text = restwell_csv_value( $row, $columns, 'alt_text' );
		if ( '' !== $alt_text && strpos( get_post_mime_type( $attachment_id ), 'image/' ) === 0 ) {
			update_post_meta( $attachment_id, '_wp_attachment_image_alt', $alt_text );
		}
		$result['matched']++;
	}
	fclose( $handle );
	$result['missing'] = array_unique( $result['missing'] );
	return $result;
}

function restwell_csv_value( $row, $columns, $column ) {
	if ( ! isset( $columns[ $column ], $row[ $columns[ $column ] ] ) ) {
		return '';
	}
	return sanitize_textarea_field( $row[ $columns[ $column ] ] );
}

function restwell_media_match_key( $filename, $attachment_map ) {
	$key = strtolower( wp_basename( $filename ) );
	if ( isset( $attachment_map[ $key ] ) ) {
		return $key;
	}
	$stem = pathinfo( $key, PATHINFO_FILENAME );
	if ( substr( $stem, -8 ) === '-display' ) {
		$stem = substr( $stem, 0, -8 );
	}
	if ( substr( $stem, -5 ) === '-webp' ) {
		$stem = substr( $stem, 0, -5 );
	}
	$alias = $stem . '.webp';
	if ( isset( $attachment_map[ $alias ] ) ) {
		return $alias;
	}

	$preferred = '';
	foreach ( $attachment_map as $attachment_key => $attachment_id ) {
		$attachment_stem = pathinfo( $attachment_key, PATHINFO_FILENAME );
		$attachment_stem = preg_replace( '/-[0-9]+$/', '', $attachment_stem );
		if ( $attachment_stem !== $stem ) {
			continue;
		}
		if ( '.webp' === substr( $attachment_key, -5 ) ) {
			return $attachment_key;
		}
		$preferred = $attachment_key;
	}
	return $preferred;
}

/**
 * Folder for the zip while it arrives and while it is unpacked.
 *
 * @return string
 */
function restwell_media_zip_tmp_dir() {
	return (string) apply_filters( 'restwell_media_zip_tmp_dir', WP_CONTENT_DIR . '/upgrade' );
}

/**
 * Bytes per piece: 4 MB, or less when the host's upload limit is lower.
 *
 * @return int
 */
function restwell_media_zip_chunk_bytes() {
	return (int) max( 256 * KB_IN_BYTES, min( 4 * MB_IN_BYTES, floor( wp_max_upload_size() * 0.8 ) ) );
}

/**
 * Unpack a release media zip into the theme's assets/images folder.
 *
 * Only image files under restwell-theme/assets/images/ are copied, so a zip
 * cannot add code to the theme.
 *
 * @param string $zip Path to the zip.
 * @return array{copied:int, skipped:int}|WP_Error
 */
function restwell_media_import_photo_zip( $zip ) {
	require_once ABSPATH . 'wp-admin/includes/file.php';
	if ( 'direct' !== get_filesystem_method() || ! WP_Filesystem() ) {
		return new WP_Error( 'restwell_media_fs', __( 'WordPress can’t write to the theme folder on this server. Unzip the media zip into wp-content/themes/ with the host’s file manager instead.', 'restwell-retreats' ) );
	}
	global $wp_filesystem;

	$tmp      = trailingslashit( restwell_media_zip_tmp_dir() ) . 'restwell-media-' . wp_generate_password( 12, false, false );
	$unzipped = unzip_file( $zip, $tmp );
	if ( is_wp_error( $unzipped ) ) {
		$wp_filesystem->delete( $tmp, true );
		return $unzipped;
	}

	$src = '';
	foreach ( array( 'restwell-theme/assets/images', 'assets/images' ) as $root ) {
		if ( is_dir( $tmp . '/' . $root ) ) {
			$src = $tmp . '/' . $root;
			break;
		}
	}
	if ( '' === $src ) {
		$wp_filesystem->delete( $tmp, true );
		return new WP_Error( 'restwell_media_not_release', __( 'This zip has no restwell-theme/assets/images folder. Use the restwell-theme-media zip that came with the theme release.', 'restwell-retreats' ) );
	}

	$dest    = get_template_directory() . '/assets/images';
	$allowed = array( 'webp', 'png', 'jpg', 'jpeg', 'gif' );
	$copied  = 0;
	$skipped = 0;
	$files   = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $src, FilesystemIterator::SKIP_DOTS ) );
	foreach ( $files as $file ) {
		if ( ! $file->isFile() ) {
			continue;
		}
		$rel = ltrim( str_replace( '\\', '/', substr( $file->getPathname(), strlen( $src ) ) ), '/' );
		if ( false !== strpos( $rel, '..' ) || ! in_array( strtolower( pathinfo( $rel, PATHINFO_EXTENSION ) ), $allowed, true ) ) {
			++$skipped;
			continue;
		}
		$target = $dest . '/' . $rel;
		wp_mkdir_p( dirname( $target ) );
		if ( $wp_filesystem->copy( $file->getPathname(), $target, true, FS_CHMOD_FILE ) ) {
			++$copied;
		} else {
			++$skipped;
		}
	}
	$wp_filesystem->delete( $tmp, true );
	clearstatcache();

	// Pages cached without photos must be rebuilt now the photos are back.
	do_action( 'litespeed_purge_all' );

	return array(
		'copied'  => $copied,
		'skipped' => $skipped,
	);
}

/**
 * One-line summary of an import.
 *
 * @param array $result Result from restwell_media_import_photo_zip().
 * @return string
 */
function restwell_media_zip_result_message( array $result ) {
	return sprintf(
		/* translators: 1: number of photos copied, 2: number of files left out. */
		__( 'Done: %1$d photos copied into the theme (%2$d other files left out). The page photos update on the next page load.', 'restwell-retreats' ),
		(int) $result['copied'],
		(int) $result['skipped']
	);
}

/**
 * Import a zip posted in one piece (the form without JavaScript).
 *
 * @return array|WP_Error
 */
function restwell_media_zip_import_from_form() {
	check_admin_referer( 'restwell_media_zip', 'restwell_media_zip_nonce' );
	$error = isset( $_FILES['restwell_media_zip']['error'] ) ? (int) $_FILES['restwell_media_zip']['error'] : UPLOAD_ERR_NO_FILE;
	if ( in_array( $error, array( UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE ), true ) ) {
		return new WP_Error( 'restwell_media_too_big', __( 'The zip is bigger than this server accepts in one upload. Turn on JavaScript so it can be sent in pieces, or use the host’s file manager.', 'restwell-retreats' ) );
	}
	if ( UPLOAD_ERR_OK !== $error || empty( $_FILES['restwell_media_zip']['tmp_name'] ) || ! is_uploaded_file( $_FILES['restwell_media_zip']['tmp_name'] ) ) {
		return new WP_Error( 'restwell_media_no_file', __( 'No zip arrived. Choose the media zip and try again.', 'restwell-retreats' ) );
	}
	return restwell_media_import_photo_zip( (string) $_FILES['restwell_media_zip']['tmp_name'] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- a temp path from PHP, checked by is_uploaded_file().
}

/**
 * Receive one piece of the media zip; unpack it when the last piece lands.
 *
 * The browser sends pieces in order, with the byte offset each starts at, so
 * a missed or repeated piece is caught instead of corrupting the zip.
 */
function restwell_ajax_media_zip_chunk() {
	check_ajax_referer( 'restwell_media_zip', 'nonce' );
	if ( ! current_user_can( 'install_themes' ) ) {
		wp_send_json_error( array( 'message' => __( 'You do not have permission to upload theme files.', 'restwell-retreats' ) ), 403 );
	}

	$id     = isset( $_POST['upload_id'] ) ? sanitize_key( wp_unslash( $_POST['upload_id'] ) ) : '';
	$index  = isset( $_POST['index'] ) ? absint( $_POST['index'] ) : 0;
	$total  = isset( $_POST['total'] ) ? absint( $_POST['total'] ) : 0;
	$offset = isset( $_POST['offset'] ) ? absint( $_POST['offset'] ) : 0;
	if ( ! preg_match( '/^[a-f0-9]{16,64}$/', $id ) || $total < 1 || $total > 1000 || $index >= $total ) {
		wp_send_json_error( array( 'message' => __( 'The upload was garbled. Reload the page and try again.', 'restwell-retreats' ) ), 400 );
	}
	if ( empty( $_FILES['chunk']['tmp_name'] ) || ! is_uploaded_file( $_FILES['chunk']['tmp_name'] ) ) { // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- a temp path from PHP.
		wp_send_json_error( array( 'message' => __( 'A piece of the zip did not arrive. Try again.', 'restwell-retreats' ) ), 400 );
	}

	$dir = restwell_media_zip_tmp_dir();
	wp_mkdir_p( $dir );
	$part = trailingslashit( $dir ) . 'restwell-media-' . $id . '.zip';
	if ( 0 === $index ) {
		wp_delete_file( $part );
	}
	clearstatcache( true, $part );
	$have = file_exists( $part ) ? (int) filesize( $part ) : 0;
	if ( $have !== $offset ) {
		wp_delete_file( $part );
		wp_send_json_error( array( 'message' => __( 'The upload was interrupted. Choose the zip and start again.', 'restwell-retreats' ) ), 409 );
	}
	// phpcs:disable WordPress.WP.AlternativeFunctions -- appending binary pieces in order; WP_Filesystem has no append.
	$in  = fopen( $_FILES['chunk']['tmp_name'], 'rb' ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	$out = fopen( $part, 'ab' );
	if ( false === $in || false === $out ) {
		wp_send_json_error( array( 'message' => __( 'WordPress can’t write to wp-content/upgrade on this server. Use the host’s file manager instead.', 'restwell-retreats' ) ), 500 );
	}
	stream_copy_to_stream( $in, $out );
	fclose( $in );
	fclose( $out );
	// phpcs:enable WordPress.WP.AlternativeFunctions

	if ( $index + 1 < $total ) {
		wp_send_json_success( array( 'received' => $index + 1 ) );
	}

	$result = restwell_media_import_photo_zip( $part );
	wp_delete_file( $part );
	if ( is_wp_error( $result ) ) {
		wp_send_json_error( array( 'message' => $result->get_error_message() ), 400 );
	}
	wp_send_json_success( array_merge( $result, array( 'message' => restwell_media_zip_result_message( $result ) ) ) );
}
add_action( 'wp_ajax_restwell_media_zip_chunk', 'restwell_ajax_media_zip_chunk' );

/**
 * Load the piece-by-piece uploader on the import screen only.
 *
 * @param string $hook_suffix Current admin screen.
 */
function restwell_media_import_enqueue_scripts( $hook_suffix ) {
	if ( 'media_page_restwell-media-import' !== $hook_suffix || ! current_user_can( 'install_themes' ) ) {
		return;
	}
	$version = function_exists( 'restwell_theme_asset_version' )
		? restwell_theme_asset_version( '/assets/js/admin/media-import.js' )
		: wp_get_theme()->get( 'Version' );
	wp_enqueue_script( 'restwell-media-import', get_template_directory_uri() . '/assets/js/admin/media-import.js', array(), $version, true );
	wp_localize_script(
		'restwell-media-import',
		'rwMediaImport',
		array(
			'ajaxurl'   => admin_url( 'admin-ajax.php' ),
			'nonce'     => wp_create_nonce( 'restwell_media_zip' ),
			'chunk'     => restwell_media_zip_chunk_bytes(),
			/* translators: 1: piece number, 2: number of pieces. */
			'uploading' => __( 'Uploading piece %1$d of %2$d…', 'restwell-retreats' ),
			'unpacking' => __( 'Unpacking the photos…', 'restwell-retreats' ),
			'failed'    => __( 'The upload failed. Try again, or use the host’s file manager.', 'restwell-retreats' ),
		)
	);
}
add_action( 'admin_enqueue_scripts', 'restwell_media_import_enqueue_scripts' );
