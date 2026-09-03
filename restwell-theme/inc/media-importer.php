<?php
/**
 * Restwell media metadata importer.
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
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Restwell Media Import', 'restwell-retreats' ); ?></h1>
		<p><?php esc_html_e( 'Choose media-metadata.csv from the media ZIP. Existing attachment metadata will be replaced.', 'restwell-retreats' ); ?></p>
		<?php if ( is_array( $result ) ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php echo esc_html( sprintf( __( 'Imported %1$d media items. %2$d rows could not be matched.', 'restwell-retreats' ), $result['matched'], $result['skipped'] ) ); ?></p></div>
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
	$result = array( 'matched' => 0, 'skipped' => 0, 'missing' => array() );
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
	$attachments = get_posts( array( 'post_type' => 'attachment', 'post_status' => 'inherit', 'posts_per_page' => -1, 'fields' => 'ids', 'no_found_rows' => true ) );
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
		wp_update_post( array( 'ID' => $attachment_id, 'post_title' => restwell_csv_value( $row, $columns, 'title' ), 'post_excerpt' => restwell_csv_value( $row, $columns, 'caption' ), 'post_content' => restwell_csv_value( $row, $columns, 'description' ) ) );
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
	return isset( $attachment_map[ $alias ] ) ? $alias : '';
}
