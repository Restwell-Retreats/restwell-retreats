<?php
/**
 * Dedicated SEO admin: pages/posts list + SEO-only edit screen.
 *
 * Keeps Search & Social off the normal page editor so content screens stay lighter.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register top-level SEO menu and hidden edit screen.
 */
function restwell_seo_pages_register_menu() {
	add_menu_page(
		__( 'SEO', 'restwell-retreats' ),
		__( 'SEO', 'restwell-retreats' ),
		'edit_pages',
		'restwell-seo',
		'restwell_seo_pages_render_router',
		'dashicons-chart-area',
		26
	);

	add_submenu_page(
		'restwell-seo',
		__( 'All pages', 'restwell-retreats' ),
		__( 'All pages', 'restwell-retreats' ),
		'edit_pages',
		'restwell-seo',
		'restwell_seo_pages_render_router'
	);

	add_submenu_page(
		'restwell-seo',
		__( 'Blog posts', 'restwell-retreats' ),
		__( 'Blog posts', 'restwell-retreats' ),
		'edit_posts',
		'restwell-seo-posts',
		'restwell_seo_posts_render_router'
	);
}
add_action( 'admin_menu', 'restwell_seo_pages_register_menu' );

/**
 * Enqueue SEO admin assets on the dedicated SEO screens.
 *
 * @param string $hook_suffix Current admin page hook.
 */
function restwell_seo_pages_enqueue( $hook_suffix ) {
	$seo_hooks = array(
		'toplevel_page_restwell-seo',
		'restwell-seo_page_restwell-seo-posts',
		'restwell-seo_page_restwell-seo-sitewide',
	);
	$page = isset( $_GET['page'] ) ? sanitize_key( wp_unslash( $_GET['page'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$seo_pages = array( 'restwell-seo', 'restwell-seo-posts', 'restwell-seo-sitewide' );
	if ( ! in_array( $hook_suffix, $seo_hooks, true ) && ! in_array( $page, $seo_pages, true ) ) {
		return;
	}

	$uri  = get_template_directory_uri();
	$path = get_template_directory() . '/assets/css/seo-admin.css';
	$ver  = file_exists( $path ) ? (string) filemtime( $path ) : (string) wp_get_theme()->get( 'Version' );

	// List + Site-wide + Edit: shared checklist / dashboard styles.
	wp_enqueue_style(
		'restwell-seo-admin',
		$uri . '/assets/css/seo-admin.css',
		array(),
		$ver
	);

	// Edit view needs the full Search & Social UI assets.
	$editing = isset( $_GET['edit'] ) && absint( $_GET['edit'] ) > 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( ! $editing ) {
		return;
	}

	wp_enqueue_script(
		'restwell-seo-admin',
		$uri . '/assets/js/seo-admin.js',
		array( 'wp-util', 'jquery' ),
		$ver,
		true
	);

	wp_enqueue_media();

	wp_localize_script(
		'restwell-seo-admin',
		'rwSeoAdmin',
		array(
			'siteUrl'     => home_url( '/' ),
			'siteName'    => get_bloginfo( 'name' ),
			'chooseImage' => __( 'Choose OG image', 'restwell-retreats' ),
			'useImage'    => __( 'Use this image', 'restwell-retreats' ),
		)
	);
}
add_action( 'admin_enqueue_scripts', 'restwell_seo_pages_enqueue' );

/**
 * Router for pages SEO screen (list or edit).
 */
function restwell_seo_pages_render_router() {
	if ( ! current_user_can( 'edit_pages' ) ) {
		wp_die( esc_html__( 'You do not have permission to access this page.', 'restwell-retreats' ), '', array( 'response' => 403 ) );
	}

	$edit_id = isset( $_GET['edit'] ) ? absint( $_GET['edit'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( $edit_id > 0 ) {
		restwell_seo_pages_render_edit_screen( $edit_id, 'page', 'restwell-seo' );
		return;
	}

	restwell_seo_pages_render_list( 'page', 'restwell-seo' );
}

/**
 * Router for posts SEO screen (list or edit).
 */
function restwell_seo_posts_render_router() {
	if ( ! current_user_can( 'edit_posts' ) ) {
		wp_die( esc_html__( 'You do not have permission to access this page.', 'restwell-retreats' ), '', array( 'response' => 403 ) );
	}

	$edit_id = isset( $_GET['edit'] ) ? absint( $_GET['edit'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( $edit_id > 0 ) {
		restwell_seo_pages_render_edit_screen( $edit_id, 'post', 'restwell-seo-posts' );
		return;
	}

	restwell_seo_pages_render_list( 'post', 'restwell-seo-posts' );
}

/**
 * Handle save from the dedicated SEO edit screen.
 */
function restwell_seo_pages_handle_save() {
	if ( ! isset( $_POST['restwell_seo_standalone_save'] ) ) {
		return;
	}

	if (
		! isset( $_POST['restwell_seo_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['restwell_seo_nonce'] ) ), 'restwell_seo_save' )
	) {
		wp_die( esc_html__( 'Security check failed. Please try again.', 'restwell-retreats' ), '', array( 'response' => 403 ) );
	}

	$post_id = isset( $_POST['restwell_seo_post_id'] ) ? absint( $_POST['restwell_seo_post_id'] ) : 0;
	$post    = $post_id ? get_post( $post_id ) : null;
	if ( ! $post || ! in_array( $post->post_type, array( 'page', 'post' ), true ) ) {
		wp_die( esc_html__( 'Invalid page.', 'restwell-retreats' ), '', array( 'response' => 404 ) );
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		wp_die( esc_html__( 'You do not have permission to edit this item.', 'restwell-retreats' ), '', array( 'response' => 403 ) );
	}

	if ( function_exists( 'restwell_seo_admin_save_fields' ) ) {
		restwell_seo_admin_save_fields( $post_id, $post );
	}

	$list_page = ( 'post' === $post->post_type ) ? 'restwell-seo-posts' : 'restwell-seo';
	wp_safe_redirect(
		add_query_arg(
			array(
				'page'    => $list_page,
				'edit'    => $post_id,
				'updated' => '1',
			),
			admin_url( 'admin.php' )
		)
	);
	exit;
}
add_action( 'admin_init', 'restwell_seo_pages_handle_save' );

/**
 * Slugs that must not appear in SEO admin lists (retired URLs + WP install stubs).
 *
 * @param string $post_type page|post.
 * @return string[]
 */
function restwell_seo_admin_excluded_slugs( string $post_type ) {
	if ( 'post' === $post_type ) {
		return array( 'hello-world' );
	}
	return array( 'contact', 'sample-page' );
}

/**
 * Post IDs to hide from the SEO list for a post type.
 *
 * @param string $post_type page|post.
 * @return int[]
 */
function restwell_seo_admin_excluded_ids( string $post_type ) {
	$ids = array();
	foreach ( restwell_seo_admin_excluded_slugs( $post_type ) as $slug ) {
		$found = get_page_by_path( $slug, OBJECT, $post_type );
		if ( $found instanceof WP_Post ) {
			$ids[] = (int) $found->ID;
		}
	}
	return array_values( array_filter( $ids ) );
}

/**
 * Render the SEO list table (pages or posts).
 *
 * @param string $post_type page|post.
 * @param string $menu_slug Admin menu slug for links.
 */
function restwell_seo_pages_render_list( string $post_type, string $menu_slug ) {
	$search = isset( $_GET['s'] ) ? sanitize_text_field( wp_unslash( $_GET['s'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$paged  = isset( $_GET['paged'] ) ? max( 1, absint( $_GET['paged'] ) ) : 1; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$per_page = 20;

	$query_args = array(
		'post_type'              => $post_type,
		'post_status'            => array( 'publish', 'draft', 'pending', 'private', 'future' ),
		'posts_per_page'         => $per_page,
		'paged'                  => $paged,
		's'                      => $search,
		'orderby'                => 'title',
		'order'                  => 'ASC',
		'update_post_meta_cache' => true,
		'no_found_rows'          => false,
	);
	$exclude_ids = restwell_seo_admin_excluded_ids( $post_type );
	if ( ! empty( $exclude_ids ) ) {
		$query_args['post__not_in'] = $exclude_ids;
	}

	$query = new WP_Query( $query_args );

	$heading = ( 'post' === $post_type )
		? __( 'SEO — Blog posts', 'restwell-retreats' )
		: __( 'SEO — Pages', 'restwell-retreats' );

	$list_bad  = 0;
	$list_warn = 0;
	$list_ok   = 0;
	$rows      = array();

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$post_obj  = get_post();
			$post_id   = get_the_ID();
			$seo_title = (string) get_post_meta( $post_id, 'meta_title', true );
			$focus_kp  = (string) get_post_meta( $post_id, 'focus_keyphrase', true );
			$noindex   = (bool) get_post_meta( $post_id, 'meta_noindex', true );
			$edit_url  = add_query_arg(
				array(
					'page' => $menu_slug,
					'edit' => $post_id,
				),
				admin_url( 'admin.php' )
			);
			$content_url  = get_edit_post_link( $post_id, 'raw' );
			$status_obj   = get_post_status_object( get_post_status() );
			$status_label = ( $status_obj && isset( $status_obj->label ) ) ? $status_obj->label : get_post_status();

			$summary = ( $post_obj instanceof WP_Post && function_exists( 'restwell_seo_checklist_summarize_post_list' ) )
				? restwell_seo_checklist_summarize_post_list( $post_obj )
				: array(
					'status' => 'ok',
					'bad'    => 0,
					'warn'   => 0,
					'info'   => 0,
					'issues' => array(),
				);

			$dupes = ( $post_obj instanceof WP_Post && function_exists( 'restwell_seo_checklist_duplicate_keyphrase_ids' ) )
				? restwell_seo_checklist_duplicate_keyphrase_ids( $post_obj )
				: array();
			if ( ! empty( $dupes ) ) {
				$summary['warn']     = (int) $summary['warn'] + 1;
				$summary['status']   = ( 'bad' === $summary['status'] ) ? 'bad' : 'warn';
				$summary['issues'][] = array(
					'id'       => 'cannibal',
					'severity' => 'warn',
					'message'  => sprintf(
						/* translators: %s: other page titles */
						__( 'Same focus keyphrase as: %s', 'restwell-retreats' ),
						implode(
							', ',
							array_map(
								static function ( $id ) {
									$t = get_the_title( $id );
									return $t !== '' ? $t : '#' . (string) $id;
								},
								array_slice( $dupes, 0, 3 )
							)
						)
					),
				);
			}

			if ( 'bad' === $summary['status'] ) {
				++$list_bad;
			} elseif ( 'warn' === $summary['status'] ) {
				++$list_warn;
			} else {
				++$list_ok;
			}

			$action_issues = array_values(
				array_filter(
					$summary['issues'],
					static function ( $issue ) {
						return in_array( $issue['severity'] ?? '', array( 'error', 'warn' ), true );
					}
				)
			);
			$tip_issues = array_values(
				array_filter(
					$summary['issues'],
					static function ( $issue ) {
						return ( $issue['severity'] ?? '' ) === 'info';
					}
				)
			);

			$rows[] = array(
				'post_id'        => $post_id,
				'title'          => get_the_title() ?: __( '(no title)', 'restwell-retreats' ),
				'edit_url'       => $edit_url,
				'content_url'    => $content_url,
				'permalink'      => get_permalink( $post_id ),
				'seo_title'      => $seo_title,
				'focus_kp'       => $focus_kp,
				'status_label'   => $status_label,
				'noindex'        => $noindex,
				'status'         => $summary['status'],
				'badge_class'    => 'rw-seo-flag rw-seo-flag--' . sanitize_html_class( $summary['status'] ),
				'badge_label'    => function_exists( 'restwell_seo_checklist_badge_label' )
					? restwell_seo_checklist_badge_label( $summary )
					: '',
				'action_issues'  => $action_issues,
				'tip_issues'     => $tip_issues,
			);
		}
		wp_reset_postdata();
	}

	?>
	<div class="wrap rw-seo-dash">
		<h1 class="wp-heading-inline"><?php echo esc_html( $heading ); ?></h1>
		<form method="get" action="<?php echo esc_url( admin_url( 'admin.php' ) ); ?>" class="search-box">
			<input type="hidden" name="page" value="<?php echo esc_attr( $menu_slug ); ?>" />
			<label class="screen-reader-text" for="restwell-seo-search"><?php esc_html_e( 'Search', 'restwell-retreats' ); ?></label>
			<input type="search" id="restwell-seo-search" name="s" value="<?php echo esc_attr( $search ); ?>" />
			<?php submit_button( __( 'Search', 'restwell-retreats' ), '', '', false, array( 'id' => 'search-submit' ) ); ?>
		</form>
		<hr class="wp-header-end" />

		<p class="description rw-seo-dash__lead">
			<?php esc_html_e( 'Search titles, descriptions, and social previews. Page copy is still edited under Pages.', 'restwell-retreats' ); ?>
		</p>

		<?php if ( ( $list_ok + $list_bad + $list_warn ) > 0 ) : ?>
			<p class="rw-seo-dash__summary" aria-live="polite">
				<?php if ( $list_bad ) : ?>
					<span class="rw-seo-flag rw-seo-flag--bad"><?php echo esc_html( sprintf( /* translators: %d: count */ _n( '%d needs work', '%d need work', $list_bad, 'restwell-retreats' ), $list_bad ) ); ?></span>
				<?php endif; ?>
				<?php if ( $list_warn ) : ?>
					<span class="rw-seo-flag rw-seo-flag--warn"><?php echo esc_html( sprintf( /* translators: %d: count */ _n( '%d suggestion', '%d suggestions', $list_warn, 'restwell-retreats' ), $list_warn ) ); ?></span>
				<?php endif; ?>
				<?php if ( $list_ok ) : ?>
					<span class="rw-seo-flag rw-seo-flag--ok"><?php echo esc_html( sprintf( /* translators: %d: count */ _n( '%d looking good', '%d looking good', $list_ok, 'restwell-retreats' ), $list_ok ) ); ?></span>
				<?php endif; ?>
			</p>
		<?php endif; ?>

		<?php if ( empty( $rows ) ) : ?>
			<p class="rw-seo-dash__empty"><?php esc_html_e( 'No items found.', 'restwell-retreats' ); ?></p>
		<?php else : ?>
			<div class="rw-seo-dash__table-wrap">
				<table class="widefat striped rw-seo-dash__table">
					<thead>
						<tr>
							<th scope="col" class="column-rw-seo-page"><?php echo esc_html( 'post' === $post_type ? __( 'Post', 'restwell-retreats' ) : __( 'Page', 'restwell-retreats' ) ); ?></th>
							<th scope="col" class="column-rw-seo-title"><?php esc_html_e( 'SEO title', 'restwell-retreats' ); ?></th>
							<th scope="col" class="column-rw-seo-keyphrase"><?php esc_html_e( 'Keyphrase', 'restwell-retreats' ); ?></th>
							<th scope="col" class="column-rw-seo-status"><?php esc_html_e( 'Status', 'restwell-retreats' ); ?></th>
							<th scope="col" class="column-rw-seo-issues"><?php esc_html_e( 'Issues', 'restwell-retreats' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $rows as $row ) : ?>
							<tr class="rw-seo-dash__row rw-seo-dash__row--<?php echo esc_attr( $row['status'] ); ?>">
								<th scope="row" class="column-rw-seo-page">
									<strong>
										<a class="row-title" href="<?php echo esc_url( $row['edit_url'] ); ?>">
											<?php echo esc_html( $row['title'] ); ?>
										</a>
									</strong>
									<div class="row-actions">
										<span class="edit">
											<a href="<?php echo esc_url( $row['edit_url'] ); ?>"><?php esc_html_e( 'Edit SEO', 'restwell-retreats' ); ?></a>
										</span>
										<?php if ( $row['content_url'] ) : ?>
											<span class="content"> | <a href="<?php echo esc_url( $row['content_url'] ); ?>"><?php esc_html_e( 'Edit content', 'restwell-retreats' ); ?></a></span>
										<?php endif; ?>
										<span class="view"> | <a href="<?php echo esc_url( $row['permalink'] ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'View', 'restwell-retreats' ); ?><span class="screen-reader-text"> <?php esc_html_e( '(opens in a new tab)', 'restwell-retreats' ); ?></span></a></span>
									</div>
								</th>
								<td class="column-rw-seo-title">
									<?php
									if ( $row['seo_title'] !== '' ) {
										echo esc_html( $row['seo_title'] );
									} else {
										echo '<span class="rw-seo-dash__muted">' . esc_html__( 'Using default', 'restwell-retreats' ) . '</span>';
									}
									?>
								</td>
								<td class="column-rw-seo-keyphrase">
									<?php
									if ( $row['focus_kp'] !== '' ) {
										echo esc_html( $row['focus_kp'] );
									} else {
										echo '<span class="rw-seo-dash__muted">&mdash;</span>';
									}
									?>
								</td>
								<td class="column-rw-seo-status">
									<?php echo esc_html( $row['status_label'] ); ?>
									<?php if ( $row['noindex'] ) : ?>
										<span class="rw-seo-dash__noindex"><?php esc_html_e( 'noindex', 'restwell-retreats' ); ?></span>
									<?php endif; ?>
								</td>
								<td class="column-rw-seo-issues">
									<span class="<?php echo esc_attr( $row['badge_class'] ); ?>"><?php echo esc_html( $row['badge_label'] ); ?></span>
									<?php if ( ! empty( $row['action_issues'] ) ) : ?>
										<ul class="rw-seo-flag__list rw-seo-flag__list--actions">
											<?php foreach ( array_slice( $row['action_issues'], 0, 2 ) as $issue ) : ?>
												<li class="rw-seo-flag__item rw-seo-flag__item--<?php echo esc_attr( $issue['severity'] ); ?>">
													<?php echo esc_html( $issue['message'] ); ?>
												</li>
											<?php endforeach; ?>
										</ul>
									<?php endif; ?>
									<?php if ( ! empty( $row['tip_issues'] ) ) : ?>
										<details class="rw-seo-dash__tips">
											<summary><?php esc_html_e( 'Tips', 'restwell-retreats' ); ?></summary>
											<ul class="rw-seo-flag__list">
												<?php foreach ( $row['tip_issues'] as $issue ) : ?>
													<li class="rw-seo-flag__item rw-seo-flag__item--info">
														<?php echo esc_html( $issue['message'] ); ?>
													</li>
												<?php endforeach; ?>
											</ul>
										</details>
									<?php endif; ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		<?php endif; ?>

		<?php
		$total_pages = (int) $query->max_num_pages;
		if ( $total_pages > 1 ) :
			$page_links = paginate_links(
				array(
					'base'      => add_query_arg(
						array(
							'page'  => $menu_slug,
							'paged' => '%#%',
							's'     => $search,
						),
						admin_url( 'admin.php' )
					),
					'format'    => '',
					'current'   => $paged,
					'total'     => $total_pages,
					'prev_text' => '&laquo;',
					'next_text' => '&raquo;',
					'type'      => 'plain',
				)
			);
			if ( $page_links ) :
				?>
				<div class="tablenav bottom">
					<div class="tablenav-pages"><?php echo wp_kses_post( $page_links ); ?></div>
				</div>
				<?php
			endif;
		endif;
		?>
	</div>
	<?php
}


/**
 * Render the SEO-only edit screen for one page or post.
 *
 * @param int    $post_id   Post ID.
 * @param string $post_type Expected post type.
 * @param string $menu_slug List menu slug for back link.
 */
function restwell_seo_pages_render_edit_screen( int $post_id, string $post_type, string $menu_slug ) {
	$post = get_post( $post_id );
	if ( ! $post || $post->post_type !== $post_type ) {
		echo '<div class="wrap"><div class="notice notice-error"><p>' . esc_html__( 'Item not found.', 'restwell-retreats' ) . '</p></div></div>';
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		wp_die( esc_html__( 'You do not have permission to edit this item.', 'restwell-retreats' ), '', array( 'response' => 403 ) );
	}

	$list_url    = add_query_arg( 'page', $menu_slug, admin_url( 'admin.php' ) );
	$content_url = get_edit_post_link( $post_id, 'raw' );
	$updated     = isset( $_GET['updated'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	?>
	<div class="wrap rw-seo-dash rw-seo-edit">
		<h1>
			<?php
			echo esc_html(
				sprintf(
					/* translators: %s: page or post title */
					__( 'SEO: %s', 'restwell-retreats' ),
					get_the_title( $post ) ?: __( '(no title)', 'restwell-retreats' )
				)
			);
			?>
		</h1>

		<p class="rw-seo-edit__nav">
			<a href="<?php echo esc_url( $list_url ); ?>">&larr; <?php esc_html_e( 'Back to SEO list', 'restwell-retreats' ); ?></a>
			<?php if ( $content_url ) : ?>
				<span class="rw-seo-edit__nav-sep" aria-hidden="true">|</span>
				<a href="<?php echo esc_url( $content_url ); ?>"><?php esc_html_e( 'Edit page content', 'restwell-retreats' ); ?></a>
			<?php endif; ?>
			<span class="rw-seo-edit__nav-sep" aria-hidden="true">|</span>
			<a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'View live page', 'restwell-retreats' ); ?></a>
		</p>

		<?php if ( $updated ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'SEO settings saved.', 'restwell-retreats' ); ?></p></div>
		<?php endif; ?>

		<form method="post" action="" class="rw-seo-edit__form">
			<input type="hidden" name="restwell_seo_standalone_save" value="1" />
			<input type="hidden" name="restwell_seo_post_id" value="<?php echo esc_attr( (string) $post_id ); ?>" />

			<div class="postbox rw-seo-edit__box">
				<div class="postbox-header">
					<h2 class="hndle"><?php esc_html_e( 'Search &amp; Social', 'restwell-retreats' ); ?></h2>
				</div>
				<div class="inside rw-seo-edit__inside">
					<?php
					if ( function_exists( 'restwell_seo_admin_meta_box_callback' ) ) {
						restwell_seo_admin_meta_box_callback( $post );
					}
					?>
				</div>
			</div>

			<p class="submit rw-seo-edit__submit">
				<?php submit_button( __( 'Save SEO settings', 'restwell-retreats' ), 'primary', 'submit', false ); ?>
			</p>
		</form>
	</div>
	<?php
}

/**
 * Add an "SEO" quick link on the Pages / Posts list tables.
 *
 * @param array<string, string> $actions Row actions.
 * @param WP_Post               $post    Post object.
 * @return array<string, string>
 */
function restwell_seo_pages_row_actions( $actions, $post ) {
	if ( ! $post instanceof WP_Post || ! in_array( $post->post_type, array( 'page', 'post' ), true ) ) {
		return $actions;
	}
	if ( ! current_user_can( 'edit_post', $post->ID ) ) {
		return $actions;
	}

	$menu_slug = ( 'post' === $post->post_type ) ? 'restwell-seo-posts' : 'restwell-seo';
	$url       = add_query_arg(
		array(
			'page' => $menu_slug,
			'edit' => $post->ID,
		),
		admin_url( 'admin.php' )
	);

	$actions['restwell_seo'] = '<a href="' . esc_url( $url ) . '">' . esc_html__( 'SEO', 'restwell-retreats' ) . '</a>';
	return $actions;
}
add_filter( 'page_row_actions', 'restwell_seo_pages_row_actions', 10, 2 );
add_filter( 'post_row_actions', 'restwell_seo_pages_row_actions', 10, 2 );

/**
 * Notice on classic page/post edit: SEO lives in the SEO menu now.
 *
 * @param WP_Post $post Post being edited.
 */
function restwell_seo_pages_edit_screen_notice( $post ) {
	if ( ! $post instanceof WP_Post || ! in_array( $post->post_type, array( 'page', 'post' ), true ) ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post->ID ) ) {
		return;
	}

	$menu_slug = ( 'post' === $post->post_type ) ? 'restwell-seo-posts' : 'restwell-seo';
	$url       = add_query_arg(
		array(
			'page' => $menu_slug,
			'edit' => $post->ID,
		),
		admin_url( 'admin.php' )
	);
	?>
	<div class="notice notice-info">
		<p>
			<?php
			echo wp_kses_post(
				sprintf(
					/* translators: %s: link to SEO edit screen */
					__( 'Search titles and meta live under %s — keep editing page copy here.', 'restwell-retreats' ),
					'<a href="' . esc_url( $url ) . '"><strong>' . esc_html__( 'SEO → Edit SEO', 'restwell-retreats' ) . '</strong></a>'
				)
			);
			?>
		</p>
	</div>
	<?php
}
add_action( 'edit_form_top', 'restwell_seo_pages_edit_screen_notice' );
