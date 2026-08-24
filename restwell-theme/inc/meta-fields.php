<?php
/**
 * Page Content Fields - meta box for page structured content (front page + template pages).
 * WordPress core only; no plugins.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/page-meta-definitions.php';

const RESTWELL_META_NONCE_ACTION = 'restwell_page_content_fields_save';
const RESTWELL_META_NONCE_NAME   = 'restwell_page_content_fields_nonce';

/**
 * Register meta box "Page content" for pages.
 */
function restwell_register_page_content_meta_box() {
	add_meta_box(
		'restwell_page_content_fields',
		__( 'Page content', 'restwell-retreats' ),
		'restwell_page_content_meta_box_callback',
		'page',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'restwell_register_page_content_meta_box' );

/**
 * Enqueue WordPress media modal on page edit screens only.
 */
function restwell_enqueue_media_for_page_edit() {
	$screen = get_current_screen();
	if ( ! $screen || 'page' !== $screen->post_type || ! in_array( $screen->base, array( 'post', 'post-new' ), true ) ) {
		return;
	}
	wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'restwell_enqueue_media_for_page_edit' );

/**
 * Meta box callback: output all input fields in a tabbed interface.
 *
 * @param WP_Post $post Current post object.
 */
function restwell_page_content_meta_box_callback( WP_Post $post ) {
	wp_nonce_field( RESTWELL_META_NONCE_ACTION, RESTWELL_META_NONCE_NAME );

	$fields   = restwell_get_page_content_field_definitions( $post );
	$defaults = function_exists( 'restwell_get_page_content_defaults' )
		? restwell_get_page_content_defaults( $post )
		: array();

	// Fill any keys Theme Setup has not written yet, so the editor is not a wall of empty inputs.
	if ( ! empty( $defaults ) && function_exists( 'restwell_merge_theme_defaults_into_post_meta' ) ) {
		restwell_merge_theme_defaults_into_post_meta( (int) $post->ID, $defaults, false );
	}

	$index       = 0;
	$issues      = function_exists( 'restwell_page_content_run_checks' ) ? restwell_page_content_run_checks( $post ) : array();
	$section_bad = function_exists( 'restwell_page_content_issues_by_section' ) ? restwell_page_content_issues_by_section( $issues ) : array();
	$required    = function_exists( 'restwell_page_content_required_fields' ) ? restwell_page_content_required_fields( $post ) : array();
	$h1_key      = function_exists( 'restwell_page_content_h1_meta_key' ) ? restwell_page_content_h1_meta_key( $post ) : '';
	$seo         = function_exists( 'restwell_page_content_effective_seo' ) ? restwell_page_content_effective_seo( $post ) : array();
	$seo_edit_url = add_query_arg(
		array(
			'page' => 'restwell-seo',
			'edit' => $post->ID,
		),
		admin_url( 'admin.php' )
	);
	$error_count = 0;
	$warn_count  = 0;
	foreach ( $issues as $issue ) {
		if ( 'error' === $issue['severity'] ) {
			++$error_count;
		} elseif ( 'warn' === $issue['severity'] ) {
			++$warn_count;
		}
	}

	?>

	<div
		class="restwell-meta-fields"
		data-post-id="<?php echo esc_attr( (string) $post->ID ); ?>"
		data-h1-field="<?php echo esc_attr( $h1_key ); ?>"
		data-focus-keyphrase="<?php echo esc_attr( $seo['focus_keyphrase'] ?? '' ); ?>"
		data-seo-title="<?php echo esc_attr( $seo['meta_title'] ?? '' ); ?>"
		data-seo-desc="<?php echo esc_attr( $seo['meta_description'] ?? '' ); ?>"
		data-seo-url="<?php echo esc_url( $seo_edit_url ); ?>"
		data-required-fields="<?php echo esc_attr( wp_json_encode( array_keys( $required ) ) ); ?>"
	>
		<p class="restwell-meta-fields__intro description">
			<?php esc_html_e( 'Pick a section, edit the fields. Search titles and meta live under SEO in the admin menu.', 'restwell-retreats' ); ?>
		</p>

		<details class="restwell-meta-fields__checklist" id="restwell-content-checklist"<?php echo ( $error_count > 0 || $warn_count > 0 ) ? ' open' : ''; ?>>
			<summary class="restwell-meta-fields__checklist-head">
				<strong><?php esc_html_e( 'Content check', 'restwell-retreats' ); ?></strong>
				<?php if ( empty( $issues ) || ( 0 === $error_count && 0 === $warn_count ) ) : ?>
					<span class="restwell-meta-fields__badge restwell-meta-fields__badge--ok"><?php esc_html_e( 'Looking good', 'restwell-retreats' ); ?></span>
				<?php else : ?>
					<?php if ( $error_count > 0 ) : ?>
						<span class="restwell-meta-fields__badge restwell-meta-fields__badge--error">
							<?php
							echo esc_html(
								sprintf(
									/* translators: %d: number of errors */
									_n( '%d must-fix', '%d must-fix', $error_count, 'restwell-retreats' ),
									$error_count
								)
							);
							?>
						</span>
					<?php endif; ?>
					<?php if ( $warn_count > 0 ) : ?>
						<span class="restwell-meta-fields__badge restwell-meta-fields__badge--warn">
							<?php
							echo esc_html(
								sprintf(
									/* translators: %d: number of warnings */
									_n( '%d suggestion', '%d suggestions', $warn_count, 'restwell-retreats' ),
									$warn_count
								)
							);
							?>
						</span>
					<?php endif; ?>
				<?php endif; ?>
			</summary>
			<?php
			$action_issues = array_values(
				array_filter(
					$issues,
					static function ( $issue ) {
						return in_array( $issue['severity'] ?? '', array( 'error', 'warn' ), true );
					}
				)
			);
			$tip_issues = array_values(
				array_filter(
					$issues,
					static function ( $issue ) {
						return ( $issue['severity'] ?? '' ) === 'info';
					}
				)
			);
			?>
			<?php if ( ! empty( $action_issues ) ) : ?>
				<ul class="restwell-meta-fields__checklist-list">
					<?php foreach ( $action_issues as $issue ) : ?>
						<li class="restwell-meta-fields__check restwell-meta-fields__check--<?php echo esc_attr( $issue['severity'] ); ?>" data-field="<?php echo esc_attr( $issue['field'] ); ?>">
							<?php echo esc_html( $issue['message'] ); ?>
							<?php if ( '' === $issue['field'] ) : ?>
								<a href="<?php echo esc_url( $seo_edit_url ); ?>"><?php esc_html_e( 'Open SEO', 'restwell-retreats' ); ?></a>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php else : ?>
				<p class="description restwell-meta-fields__checklist-ok"><?php esc_html_e( 'Required content looks filled. Tips below are optional polish.', 'restwell-retreats' ); ?></p>
			<?php endif; ?>
			<?php if ( ! empty( $tip_issues ) ) : ?>
				<details class="restwell-meta-fields__tips">
					<summary><?php esc_html_e( 'Show tips', 'restwell-retreats' ); ?></summary>
					<ul class="restwell-meta-fields__checklist-list">
						<?php foreach ( $tip_issues as $issue ) : ?>
							<li class="restwell-meta-fields__check restwell-meta-fields__check--info" data-field="<?php echo esc_attr( $issue['field'] ); ?>">
								<?php echo esc_html( $issue['message'] ); ?>
								<?php if ( '' === $issue['field'] ) : ?>
									<a href="<?php echo esc_url( $seo_edit_url ); ?>"><?php esc_html_e( 'Open SEO', 'restwell-retreats' ); ?></a>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				</details>
			<?php endif; ?>
			<p class="description restwell-meta-fields__checklist-note">
				<?php esc_html_e( 'SEO titles and descriptions are edited under SEO → Edit SEO — not in this panel.', 'restwell-retreats' ); ?>
			</p>
		</details>

		<div class="restwell-meta-fields__layout">
			<nav class="restwell-meta-fields__nav" aria-label="<?php esc_attr_e( 'Page sections', 'restwell-retreats' ); ?>">
				<p class="restwell-meta-fields__nav-label"><?php esc_html_e( 'Sections', 'restwell-retreats' ); ?></p>
				<ul class="restwell-meta-fields__nav-list" role="tablist">
					<?php
					foreach ( array_keys( $fields ) as $section ) {
						$panel_id = 'restwell-panel-' . $index;
						$active   = ( 0 === $index ) ? ' is-active' : '';
						$badges   = isset( $section_bad[ $section ] ) ? (int) $section_bad[ $section ] : 0;
						echo '<li role="presentation">';
						echo '<button type="button" class="restwell-nav-tab' . esc_attr( $active ) . '" data-panel="' . esc_attr( $panel_id ) . '" data-section="' . esc_attr( $section ) . '" role="tab" aria-selected="' . ( 0 === $index ? 'true' : 'false' ) . '">';
						echo '<span class="restwell-nav-tab__label">' . esc_html( $section ) . '</span>';
						if ( $badges > 0 ) {
							echo '<span class="restwell-nav-tab__flag" aria-label="' . esc_attr( sprintf( __( '%d issues', 'restwell-retreats' ), $badges ) ) . '">' . esc_html( (string) $badges ) . '</span>';
						}
						echo '</button>';
						echo '</li>';
						$index++;
					}
					$index = 0;
					?>
				</ul>
			</nav>

			<div class="restwell-meta-fields__panels">
		<?php
		foreach ( $fields as $section => $items ) {
			$panel_id = 'restwell-panel-' . $index;
			$active   = ( 0 === $index ) ? ' active' : '';
			echo '<div id="' . esc_attr( $panel_id ) . '" class="restwell-tab-panel' . esc_attr( $active ) . '" role="tabpanel" aria-label="' . esc_attr( $section ) . '">';
			echo '<h3 class="restwell-meta-fields__panel-title">' . esc_html( $section ) . '</h3>';

			foreach ( $items as $key => $field ) {
				$label     = $field['label'];
				$type      = $field['type'];
				$value     = function_exists( 'restwell_page_content_meta_or_default' )
					? restwell_page_content_meta_or_default( (int) $post->ID, $key, $defaults )
					: get_post_meta( (int) $post->ID, $key, true );
				$id        = 'restwell_' . $key;
				$name      = $key;
				$is_req    = isset( $required[ $key ] );
				$is_empty  = ( trim( (string) $value ) === '' || (string) $value === '0' );
				$field_cls = 'restwell-field';
				if ( $is_req ) {
					$field_cls .= ' restwell-field--required';
					if ( $is_empty ) {
						$field_cls .= ' restwell-field--missing';
					}
				}
				echo '<div class="' . esc_attr( $field_cls ) . '" data-field-key="' . esc_attr( $key ) . '">';
				$req_mark = $is_req ? ' <span class="restwell-field__req">' . esc_html__( 'required', 'restwell-retreats' ) . '</span>' : '';

				if ( 'textarea' === $type ) {
					echo '<label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . $req_mark . '</label>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- $req_mark escaped above
					echo '<textarea id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" rows="5">' . esc_textarea( $value ) . '</textarea>';
				} elseif ( 'gallery' === $type ) {
					$gallery_ids   = restwell_parse_gallery_ids( $value );
					$gallery_value = implode( ',', $gallery_ids );
					$input_id      = $id . '_value';
					echo '<label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . $req_mark . '</label>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo '<div class="restwell-gallery-upload" data-field-id="' . esc_attr( $id ) . '">';
					echo '<input type="hidden" id="' . esc_attr( $input_id ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $gallery_value ) . '" />';
					echo '<ul class="restwell-gallery-preview" role="list">';
					foreach ( $gallery_ids as $gid ) {
						$thumb = wp_get_attachment_image_url( $gid, 'thumbnail' );
						if ( ! $thumb ) {
							continue;
						}
						echo '<li class="restwell-gallery-preview__item" data-id="' . esc_attr( (string) $gid ) . '">';
						$thumb_alt = function_exists( 'restwell_get_gallery_attachment_alt' )
							? restwell_get_gallery_attachment_alt( $gid )
							: '';
						if ( $thumb_alt === '' ) {
							$thumb_alt = __( 'Gallery image preview', 'restwell-retreats' );
						}
						echo '<img src="' . esc_url( $thumb ) . '" alt="' . esc_attr( $thumb_alt ) . '" width="80" height="80" />';
						echo '<button type="button" class="button-link restwell-gallery-remove" aria-label="' . esc_attr__( 'Remove image', 'restwell-retreats' ) . '">&times;</button>';
						echo '</li>';
					}
					echo '</ul>';
					echo '<button type="button" id="' . esc_attr( $id ) . '" class="button button-secondary restwell-select-gallery">' . esc_html__( 'Add gallery images', 'restwell-retreats' ) . '</button>';
					echo '</div>';
					restwell_render_gallery_admin_alt_notice( $gallery_ids );
				} elseif ( 'image' === $type || 'media' === $type ) {
					$img_value       = absint( $value );
					$img_url         = $img_value ? wp_get_attachment_image_url( $img_value, 'medium' ) : '';
					$mime_type       = $img_value ? get_post_mime_type( $img_value ) : '';
					$is_video        = $mime_type && strpos( $mime_type, 'video/' ) === 0;
					$has_preview     = (bool) $img_value;
					$allows_video    = ( 'media' === $type );
					$allowed_types   = $allows_video ? 'image,video' : 'image';
					$preview_text    = $is_video ? __( 'Video selected', 'restwell-retreats' ) : '';
					$preview_alt     = $img_value && function_exists( 'restwell_get_gallery_attachment_alt' )
						? restwell_get_gallery_attachment_alt( $img_value )
						: '';
					if ( $preview_alt === '' ) {
						$preview_alt = __( 'Selected image preview', 'restwell-retreats' );
					}
					$input_id        = $id . '_value';
					echo '<label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . $req_mark . '</label>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo '<div class="restwell-image-upload restwell-media-upload" data-allowed-types="' . esc_attr( $allowed_types ) . '">';
					echo '<input type="hidden" id="' . esc_attr( $input_id ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '" />';
					echo '<div class="restwell-image-preview"' . ( $has_preview ? '' : ' style="display:none;"' ) . '>';
					if ( $allows_video ) {
						echo '<img src="' . esc_url( $img_url ) . '" alt="' . esc_attr( $preview_alt ) . '" style="' . ( $is_video ? 'display:none;' : '' ) . '" />';
						echo '<span class="restwell-media-preview-text" style="' . ( $is_video ? '' : 'display:none;' ) . '">' . esc_html( $preview_text ) . '</span>';
					} else {
						echo '<img src="' . esc_url( $img_url ) . '" alt="' . esc_attr( $preview_alt ) . '" />';
					}
					echo '</div>';
					$select_btn_text = $allows_video ? __( 'Select image or video', 'restwell-retreats' ) : __( 'Select Image', 'restwell-retreats' );
					echo '<button type="button" id="' . esc_attr( $id ) . '" class="button button-secondary restwell-select-image">' . esc_html( $select_btn_text ) . '</button>';
					echo '<button type="button" class="button button-link restwell-remove-image"' . ( $has_preview ? '' : ' style="display:none;"' ) . '>' . esc_html__( 'Remove', 'restwell-retreats' ) . '</button>';
					echo '</div>';
				} elseif ( 'number' === $type ) {
					echo '<label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . $req_mark . '</label>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo '<input type="number" step="any" id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '" />';
				} else {
					echo '<label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . $req_mark . '</label>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo '<input type="text" id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '" />';
				}
				echo '</div>';
			}
			echo '</div>';
			$index++;
		}
		?>
			</div><!-- .restwell-meta-fields__panels -->
		</div><!-- .restwell-meta-fields__layout -->
	</div>
	<?php
}

/**
 * Save meta box: verify nonce and sanitize all fields for this page's template.
 *
 * @param int $post_id Post ID being saved.
 */
function restwell_save_page_content_meta_box( int $post_id ): void {
	if ( ! isset( $_POST[ RESTWELL_META_NONCE_NAME ] ) ||
		 ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ RESTWELL_META_NONCE_NAME ] ) ), RESTWELL_META_NONCE_ACTION ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$post   = get_post( $post_id );
	$fields = restwell_get_page_content_field_definitions( $post );
	foreach ( $fields as $items ) {
		foreach ( $items as $key => $field ) {
			if ( ! isset( $_POST[ $key ] ) ) {
				continue;
			}
			$raw  = wp_unslash( $_POST[ $key ] );
			$type = $field['type'];
			if ( 'gallery' === $type ) {
				$ids   = restwell_parse_gallery_ids( $raw );
				$value = implode( ',', $ids );
			} elseif ( 'image' === $type || 'media' === $type ) {
				$value = absint( $raw );
			} elseif ( 'textarea' === $type && 'legal_body_html' === $key ) {
				$value = wp_kses_post( $raw );
			} elseif ( 'textarea' === $type ) {
				$value = sanitize_textarea_field( $raw );
			} elseif ( 'number' === $type ) {
				$value = sanitize_text_field( $raw );
			} else {
				$value = sanitize_text_field( $raw );
			}
			update_post_meta( $post_id, $key, $value );
		}
	}
}
add_action( 'save_post_page', 'restwell_save_page_content_meta_box' );
