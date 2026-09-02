<?php
/**
 * SEO Admin: "Search & Social" form fields and analysis helpers.
 *
 * The UI is rendered on the dedicated SEO screens (inc/seo-pages-admin.php).
 * This file holds the form markup, checks, and save helpers.
 *
 * Fields saved:
 *  focus_keyphrase, meta_title, meta_description, og_image_id,
 *  meta_og_type, meta_canonical, meta_noindex
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// =============================================================================
// Registration
// =============================================================================

/*
 * Search & Social UI lives under the dedicated SEO admin menu
 * (inc/seo-pages-admin.php). It is intentionally not registered as a
 * metabox on the normal page/post editors.
 */

// =============================================================================
// Meta box callback
// =============================================================================

/**
 * Render the SEO meta box HTML.
 *
 * @param WP_Post $post Current post object.
 */
function restwell_seo_admin_meta_box_callback( $post ) {
	wp_nonce_field( 'restwell_seo_save', 'restwell_seo_nonce' );

	$focus_kp    = (string) get_post_meta( $post->ID, 'focus_keyphrase', true );
	$meta_title  = (string) get_post_meta( $post->ID, 'meta_title', true );
	$meta_desc   = (string) get_post_meta( $post->ID, 'meta_description', true );
	$seo_defs = function_exists( 'restwell_get_seo_default_meta_for_post_id' )
		? restwell_get_seo_default_meta_for_post_id( $post->ID )
		: array(
			'focus_keyphrase'  => '',
			'meta_title'       => '',
			'meta_description' => '',
		);
	$kp_placeholder = ! empty( $seo_defs['focus_keyphrase'] ) ? $seo_defs['focus_keyphrase'] : '';
	$og_image_id = (int) get_post_meta( $post->ID, 'og_image_id', true );
	$og_type     = (string) get_post_meta( $post->ID, 'meta_og_type', true );
	$canonical   = (string) get_post_meta( $post->ID, 'meta_canonical', true );
	$noindex     = (bool) get_post_meta( $post->ID, 'meta_noindex', true );

	if ( ! in_array( $og_type, array( 'website', 'article' ), true ) ) {
		$og_type = ( get_post_type( $post ) === 'post' ) ? 'article' : 'website';
	}

	$og_image_url = $og_image_id ? wp_get_attachment_image_url( $og_image_id, 'large' ) : '';

	// SERP preview: match front-end output (saved meta, else theme defaults, else post title).
	$preview_title = $meta_title !== '' ? $meta_title : ( ! empty( $seo_defs['meta_title'] ) ? $seo_defs['meta_title'] : $post->post_title );
	$preview_desc  = $meta_desc !== '' ? $meta_desc : (string) ( $seo_defs['meta_description'] ?? '' );
	$preview_url   = get_permalink( $post->ID );

	// Schema status.
	$template     = get_page_template_slug( $post->ID );
	$schema_items = restwell_seo_admin_schema_status( $post, $template );
	?>
	<div
		class="rw-seo"
		id="rw-seo-root"
		data-seo-default-kp="<?php echo esc_attr( $seo_defs['focus_keyphrase'] ?? '' ); ?>"
		data-seo-default-title="<?php echo esc_attr( $seo_defs['meta_title'] ?? '' ); ?>"
		data-seo-default-desc="<?php echo esc_attr( $seo_defs['meta_description'] ?? '' ); ?>"
	>

		<!-- Focus keyphrase -->
		<div class="rw-seo__field">
			<label class="rw-seo__label" for="rw_focus_keyphrase">
				<?php esc_html_e( 'Focus keyphrase', 'restwell-retreats' ); ?>
				<span class="rw-seo__hint"><?php esc_html_e( '(recommended; include it in your meta description)', 'restwell-retreats' ); ?></span>
			</label>
			<input
				type="text"
				id="rw_focus_keyphrase"
				name="focus_keyphrase"
				value="<?php echo esc_attr( $focus_kp ); ?>"
				class="rw-seo__input"
				placeholder="<?php echo $kp_placeholder !== '' ? esc_attr( $kp_placeholder ) : esc_attr__( 'e.g. accessible holiday cottage Kent', 'restwell-retreats' ); ?>"
			/>
		</div>

		<!-- ── SERP preview ─────────────────────────────────────────────── -->
		<div class="rw-seo__section rw-seo__serp-preview" aria-label="<?php esc_attr_e( 'SERP preview', 'restwell-retreats' ); ?>">
			<p class="rw-seo__section-label"><?php esc_html_e( 'Search result preview', 'restwell-retreats' ); ?></p>
			<div class="rw-seo__serp-box">
				<div class="rw-seo__serp-url" id="rw-serp-url"><?php echo esc_html( $preview_url ); ?></div>
				<div class="rw-seo__serp-title" id="rw-serp-title"><?php echo esc_html( mb_substr( $preview_title, 0, 60 ) ); ?></div>
				<div class="rw-seo__serp-desc" id="rw-serp-desc"><?php echo esc_html( mb_substr( $preview_desc, 0, 160 ) ); ?></div>
			</div>
		</div>

		<!-- Meta title -->
		<div class="rw-seo__field">
			<label class="rw-seo__label" for="rw_meta_title">
				<?php esc_html_e( 'SEO title', 'restwell-retreats' ); ?>
			</label>
			<input
				type="text"
				id="rw_meta_title"
				name="meta_title"
				value="<?php echo esc_attr( $meta_title ); ?>"
				class="rw-seo__input"
				placeholder="<?php echo esc_attr( $post->post_title ); ?>"
				data-rw-seo="title"
			/>
			<p class="rw-seo__counter" id="rw-title-counter" data-max="60">
				<span class="rw-seo__counter-val">0</span> / 60
			</p>
		</div>

		<!-- Meta description -->
		<div class="rw-seo__field">
			<label class="rw-seo__label" for="rw_meta_description">
				<?php esc_html_e( 'Meta description', 'restwell-retreats' ); ?>
			</label>
			<textarea
				id="rw_meta_description"
				name="meta_description"
				rows="3"
				class="rw-seo__input rw-seo__textarea"
				data-rw-seo="desc"
			><?php echo esc_textarea( $meta_desc ); ?></textarea>
			<p class="rw-seo__counter" id="rw-desc-counter" data-max="160">
				<span class="rw-seo__counter-val">0</span> / 160
			</p>
		</div>

		<!-- ── Social preview ───────────────────────────────────────────── -->
		<div class="rw-seo__section" aria-label="<?php esc_attr_e( 'Social preview', 'restwell-retreats' ); ?>">
			<p class="rw-seo__section-label"><?php esc_html_e( 'Social card preview', 'restwell-retreats' ); ?></p>

			<div class="rw-seo__tabs">
				<button type="button" class="rw-seo__tab rw-seo__tab--active" data-tab="facebook">Facebook</button>
				<button type="button" class="rw-seo__tab" data-tab="twitter">Twitter / X</button>
			</div>

			<div class="rw-seo__social-preview" id="rw-social-fb">
				<div class="rw-seo__social-img" id="rw-social-fb-img">
					<?php if ( $og_image_url ) : ?>
						<img src="<?php echo esc_url( $og_image_url ); ?>" alt="<?php echo esc_attr__( 'Social image preview', 'restwell-retreats' ); ?>" />
					<?php else : ?>
						<span class="rw-seo__social-placeholder"><?php esc_html_e( 'No image set', 'restwell-retreats' ); ?></span>
					<?php endif; ?>
				</div>
				<div class="rw-seo__social-body">
					<div class="rw-seo__social-domain"><?php echo esc_html( wp_parse_url( home_url(), PHP_URL_HOST ) ); ?></div>
					<div class="rw-seo__social-title" id="rw-social-fb-title"><?php echo esc_html( mb_substr( $preview_title, 0, 60 ) ); ?></div>
					<div class="rw-seo__social-desc" id="rw-social-fb-desc"><?php echo esc_html( mb_substr( $preview_desc, 0, 160 ) ); ?></div>
				</div>
			</div>

			<div class="rw-seo__social-preview rw-seo__social-preview--twitter" id="rw-social-tw" style="display:none;">
				<div class="rw-seo__social-img" id="rw-social-tw-img">
					<?php if ( $og_image_url ) : ?>
						<img src="<?php echo esc_url( $og_image_url ); ?>" alt="<?php echo esc_attr__( 'Social image preview', 'restwell-retreats' ); ?>" />
					<?php else : ?>
						<span class="rw-seo__social-placeholder"><?php esc_html_e( 'No image set', 'restwell-retreats' ); ?></span>
					<?php endif; ?>
				</div>
				<div class="rw-seo__social-body">
					<div class="rw-seo__social-title" id="rw-social-tw-title"><?php echo esc_html( mb_substr( $preview_title, 0, 60 ) ); ?></div>
					<div class="rw-seo__social-desc" id="rw-social-tw-desc"><?php echo esc_html( mb_substr( $preview_desc, 0, 120 ) ); ?></div>
					<div class="rw-seo__social-domain"><?php echo esc_html( wp_parse_url( home_url(), PHP_URL_HOST ) ); ?></div>
				</div>
			</div>
		</div>

		<!-- OG image -->
		<div class="rw-seo__field rw-seo__og-image-row">
			<label class="rw-seo__label"><?php esc_html_e( 'OG / social image', 'restwell-retreats' ); ?></label>
			<input type="hidden" id="rw_og_image_id" name="og_image_id" value="<?php echo esc_attr( (string) $og_image_id ); ?>" />
			<div class="rw-seo__og-thumb" id="rw-og-thumb">
				<?php if ( $og_image_url ) : ?>
					<img src="<?php echo esc_url( $og_image_url ); ?>" alt="<?php echo esc_attr__( 'Selected social image', 'restwell-retreats' ); ?>" />
				<?php endif; ?>
			</div>
			<div class="rw-seo__og-actions">
				<button type="button" id="rw-og-choose" class="button button-secondary">
					<?php esc_html_e( 'Choose image', 'restwell-retreats' ); ?>
				</button>
				<?php if ( $og_image_id ) : ?>
					<button type="button" id="rw-og-remove" class="button-link rw-seo__remove-btn">
						<?php esc_html_e( 'Remove', 'restwell-retreats' ); ?>
					</button>
				<?php endif; ?>
			</div>
		</div>

		<!-- OG type -->
		<div class="rw-seo__field rw-seo__field--half">
			<label class="rw-seo__label" for="rw_meta_og_type">
				<?php esc_html_e( 'OG type', 'restwell-retreats' ); ?>
			</label>
			<select id="rw_meta_og_type" name="meta_og_type" class="rw-seo__input">
				<option value="website"  <?php selected( $og_type, 'website' ); ?>><?php esc_html_e( 'website', 'restwell-retreats' ); ?></option>
				<option value="article"  <?php selected( $og_type, 'article' ); ?>><?php esc_html_e( 'article', 'restwell-retreats' ); ?></option>
			</select>
		</div>

		<!-- Canonical -->
		<div class="rw-seo__field">
			<label class="rw-seo__label" for="rw_meta_canonical">
				<?php esc_html_e( 'Canonical URL', 'restwell-retreats' ); ?>
				<span class="rw-seo__hint"><?php esc_html_e( '(leave blank to use default)', 'restwell-retreats' ); ?></span>
			</label>
			<input
				type="text"
				inputmode="url"
				autocomplete="off"
				id="rw_meta_canonical"
				name="meta_canonical"
				value="<?php echo esc_attr( $canonical ); ?>"
				class="rw-seo__input"
				placeholder="https://..."
			/>
		</div>

		<!-- No-index -->
		<div class="rw-seo__field rw-seo__field--checkbox">
			<label for="rw_meta_noindex" class="rw-seo__checkbox-label">
				<input type="hidden" name="meta_noindex" value="0" />
				<input
					type="checkbox"
					id="rw_meta_noindex"
					name="meta_noindex"
					value="1"
					<?php checked( $noindex ); ?>
				/>
				<?php esc_html_e( 'Hide from search engines (noindex, nofollow)', 'restwell-retreats' ); ?>
			</label>
		</div>

		<!-- ── SEO analysis panel ───────────────────────────────────────── -->
		<div class="rw-seo__section" aria-label="<?php esc_attr_e( 'SEO analysis', 'restwell-retreats' ); ?>">
			<p class="rw-seo__section-label"><?php esc_html_e( 'SEO analysis', 'restwell-retreats' ); ?></p>
			<ul class="rw-seo__checks" id="rw-seo-checks"
				data-content="<?php echo esc_attr( $post->post_content ); ?>"
				data-post-type="<?php echo esc_attr( $post->post_type ); ?>">

				<?php
				$checks = restwell_seo_admin_run_checks( $post, $focus_kp, $meta_title, $meta_desc );
				foreach ( $checks as $check ) :
					$state = $check['state']; // 'ok', 'warn', 'bad'
					$icons = array(
						'ok'   => '✓',
						'warn' => '~',
						'bad'  => '✗',
						'info' => 'i',
					);
					$icon  = $icons[ $state ] ?? '•';
					?>
				<li class="rw-seo__check rw-seo__check--<?php echo esc_attr( $state ); ?>" data-check="<?php echo esc_attr( $check['id'] ); ?>">
					<span class="rw-seo__check-icon" aria-hidden="true"><?php echo esc_html( $icon ); ?></span>
					<span class="rw-seo__check-label"><?php echo esc_html( $check['label'] ); ?></span>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>

		<!-- ── Schema status panel ──────────────────────────────────────── -->
		<div class="rw-seo__section rw-seo__schema-panel" aria-label="<?php esc_attr_e( 'Schema status', 'restwell-retreats' ); ?>">
			<p class="rw-seo__section-label"><?php esc_html_e( 'Active schema', 'restwell-retreats' ); ?></p>
			<ul class="rw-seo__schema-list">
				<?php foreach ( $schema_items as $name => $active ) : ?>
				<li class="rw-seo__schema-item rw-seo__schema-item--<?php echo esc_attr( $active ? 'on' : 'off' ); ?>">
					<span class="rw-seo__schema-dot" aria-hidden="true"><?php echo esc_html( $active ? '✓' : '✗' ); ?></span>
					<?php echo esc_html( $name ); ?>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>

	</div><!-- /.rw-seo -->
	<?php
}

// =============================================================================
// Server-side analysis helpers
// =============================================================================

/**
 * Normalize text for focus keyphrase substring checks (case, whitespace).
 *
 * @param string $text Raw text.
 * @return string
 */
function restwell_seo_admin_normalize_for_keyphrase_match( string $text ): string {
	$text = strtolower( trim( $text ) );
	$text = (string) preg_replace( '/\s+/u', ' ', $text );
	// Curly apostrophes / primes vs ASCII — avoids false "missing keyphrase" when copy uses typographic quotes.
	$text = (string) preg_replace( '/[\x{2018}\x{2019}\x{2032}]/u', "'", $text );
	return $text;
}

/**
 * Whether a URL points at this site (root-relative or absolute same-host).
 *
 * Used only for structural SEO checks — not for sanitising saved meta.
 *
 * @param string $url Raw URL from a meta field.
 * @return bool
 */
function restwell_seo_admin_url_is_internal( string $url ): bool {
	$url = trim( $url );
	if ( $url === '' ) {
		return false;
	}
	if ( str_starts_with( $url, '/' ) ) {
		return true;
	}
	$home_base = untrailingslashit( home_url() );
	if ( $home_base === '' ) {
		return false;
	}
	return str_starts_with( untrailingslashit( $url ), $home_base );
}

/**
 * Build plain-text and HTML corpora for SEO analysis from a post's content + meta.
 *
 * Template pages store almost all copy in structured meta (hero headings, body
 * copy, FAQ answers, CTA URLs, etc.) rather than `post_content`. Word-count and
 * keyphrase checks need stripped plain text; heading / internal-link checks need
 * a corpus that can still contain markup (or synthetic markup derived from known
 * heading / URL meta keys).
 *
 * @param WP_Post $post Post to analyse.
 * @return array{plain:string,html:string}
 */
function restwell_get_effective_content_for_seo( WP_Post $post ): array {
	$plain_parts = array();
	$html_parts  = array();

	// Block / classic editor body (often empty on template pages).
	if ( (string) $post->post_content !== '' ) {
		$html_parts[]  = (string) $post->post_content;
		$plain_parts[] = wp_strip_all_tags( $post->post_content );
	}

	$h1_key = function_exists( 'restwell_page_content_h1_meta_key' )
		? restwell_page_content_h1_meta_key( $post )
		: '';

	if ( function_exists( 'restwell_get_page_content_field_definitions' ) ) {
		$groups = restwell_get_page_content_field_definitions( $post );
		foreach ( $groups as $items ) {
			foreach ( $items as $key => $field ) {
				$type = isset( $field['type'] ) ? (string) $field['type'] : 'text';
				if ( ! in_array( $type, array( 'text', 'textarea' ), true ) ) {
					continue;
				}
				// Skip SEO meta fields — those are analysed separately.
				if ( in_array( $key, array( 'meta_title', 'meta_description', 'focus_keyphrase' ), true ) ) {
					continue;
				}
				$val = (string) get_post_meta( $post->ID, $key, true );
				if ( $val === '' ) {
					continue;
				}

				$plain_parts[] = wp_strip_all_tags( $val );

				// Textareas may hold HTML (policy body, rich intros) — keep raw for structure.
				if ( 'textarea' === $type ) {
					$html_parts[] = $val;
				}

				/*
				 * Plain-text heading fields are rendered as h2/h3 in templates.
				 * Skip the page H1 key so the "subheading" check stays honest.
				 */
				if (
					$h1_key !== $key
					&& str_ends_with( $key, '_heading' )
					&& trim( wp_strip_all_tags( $val ) ) !== ''
				) {
					$html_parts[] = '<h2>' . wp_strip_all_tags( $val ) . '</h2>';
				}

				// CTA / link URL fields that point within this site.
				if ( str_ends_with( $key, '_url' ) && restwell_seo_admin_url_is_internal( $val ) ) {
					$html_parts[] = '<a href="' . esc_url( $val ) . '">link</a>';
				}
			}
		}
	}

	return array(
		'plain' => trim( implode( ' ', array_filter( $plain_parts ) ) ),
		'html'  => implode( "\n", array_filter( $html_parts ) ),
	);
}

/**
 * Run 8 SEO checks on the post and return their state.
 *
 * Uses theme SEO defaults when post meta is empty so analysis matches
 * `restwell_get_meta_description_for_request()` and seeded defaults.
 *
 * @param WP_Post $post         Post object.
 * @param string  $focus_kp     Focus keyphrase.
 * @param string  $meta_title   SEO title.
 * @param string  $meta_desc    Meta description.
 * @return array<int, array{id:string,label:string,state:string}>
 */
function restwell_seo_admin_run_checks( WP_Post $post, string $focus_kp, string $meta_title, string $meta_desc ): array {
	$defaults = function_exists( 'restwell_get_seo_default_meta_for_post_id' )
		? restwell_get_seo_default_meta_for_post_id( $post->ID )
		: array(
			'meta_title'       => '',
			'meta_description' => '',
			'focus_keyphrase'  => '',
		);

	if ( $focus_kp === '' && ! empty( $defaults['focus_keyphrase'] ) ) {
		$focus_kp = (string) $defaults['focus_keyphrase'];
	}
	if ( $meta_title === '' && ! empty( $defaults['meta_title'] ) ) {
		$meta_title = (string) $defaults['meta_title'];
	}
	if ( $meta_desc === '' && ! empty( $defaults['meta_description'] ) ) {
		$meta_desc = (string) $defaults['meta_description'];
	}

	$corpora    = restwell_get_effective_content_for_seo( $post );
	$plain      = $corpora['plain'];
	$html       = $corpora['html'];
	$title      = $meta_title !== '' ? $meta_title : $post->post_title;
	$desc       = $meta_desc;
	$kp         = restwell_seo_admin_normalize_for_keyphrase_match( $focus_kp );
	$title_l    = restwell_seo_admin_normalize_for_keyphrase_match( $title );
	$desc_l     = restwell_seo_admin_normalize_for_keyphrase_match( $desc );
	$title_len  = mb_strlen( $title );
	$desc_len   = mb_strlen( $desc );
	$word_count = str_word_count( $plain );
	$has_og     = (bool) get_post_meta( $post->ID, 'og_image_id', true ) || has_post_thumbnail( $post->ID );
	$has_site_og = ! $has_og && function_exists( 'restwell_get_default_og_image_url_for_request' )
		? (bool) restwell_get_default_og_image_url_for_request( $post->ID )
		: false;

	$checks = array();

	$defaults_for_expect = function_exists( 'restwell_get_seo_default_meta_for_post_id' )
		? restwell_get_seo_default_meta_for_post_id( $post->ID )
		: array();
	$expects_kp = ! empty( $defaults_for_expect['focus_keyphrase'] );

	if ( $title === '' ) {
		$checks[] = array(
			'id'    => 'title_missing',
			'label' => __( 'SEO title is missing', 'restwell-retreats' ),
			'state' => 'bad',
		);
	}

	if ( $desc === '' ) {
		$checks[] = array(
			'id'    => 'desc_missing',
			'label' => __( 'Meta description is missing', 'restwell-retreats' ),
			'state' => 'bad',
		);
	}

	// 1 - title reflects focus keyphrase (token match).
	if ( $kp === '' ) {
		$checks[] = array(
			'id'    => 'kp_missing',
			'label' => $expects_kp
				? __( 'No focus keyphrase set (this page has a theme default — add one)', 'restwell-retreats' )
				: __( 'No focus keyphrase set (optional but recommended)', 'restwell-retreats' ),
			'state' => $expects_kp ? 'bad' : 'warn',
		);
	} else {
		$kp_fn = function_exists( 'restwell_seo_checklist_keyphrase_tokens_match' )
			? 'restwell_seo_checklist_keyphrase_tokens_match'
			: null;
		$in_title = $kp_fn
			? restwell_seo_checklist_keyphrase_tokens_match( $title_l, $kp )
			: str_contains( $title_l, $kp );
		$checks[] = array(
			'id'    => 'kp_title',
			'label' => __( 'Focus keyphrase reflected in SEO title', 'restwell-retreats' ),
			'state' => $in_title ? 'ok' : 'warn',
		);
		$in_desc = $kp_fn
			? restwell_seo_checklist_keyphrase_tokens_match( $desc_l, $kp )
			: str_contains( $desc_l, $kp );
		$checks[] = array(
			'id'    => 'kp_desc',
			'label' => __( 'Focus keyphrase reflected in meta description', 'restwell-retreats' ),
			'state' => $in_desc ? 'ok' : 'info',
		);
	}

	// 3 - title length (tips, not hard fails for 30–45).
	if ( $title_len > 0 ) {
		if ( $title_len >= 30 && $title_len <= 60 ) {
			$state = 'ok';
			$label = sprintf(
				/* translators: %d - character count */
				__( 'SEO title length: %d characters (good range)', 'restwell-retreats' ),
				$title_len
			);
		} elseif ( $title_len < 25 ) {
			$state = 'warn';
			$label = sprintf(
				/* translators: %d - character count */
				__( 'SEO title length: %d characters (very short — may be vague in search)', 'restwell-retreats' ),
				$title_len
			);
		} elseif ( $title_len > 60 ) {
			$state = 'info';
			$label = sprintf(
				/* translators: %d - character count */
				__( 'SEO title length: %d characters (may truncate in Google ~50–60)', 'restwell-retreats' ),
				$title_len
			);
		} else {
			$state = 'info';
			$label = sprintf(
				/* translators: %d - character count */
				__( 'SEO title length: %d characters (tip: 30–60 is a solid SERP range)', 'restwell-retreats' ),
				$title_len
			);
		}
		$checks[] = array(
			'id'    => 'title_len',
			'label' => $label,
			'state' => $state,
		);
	}

	// 4 - description length.
	if ( $desc_len > 0 ) {
		if ( $desc_len >= 120 && $desc_len <= 160 ) {
			$state = 'ok';
		} elseif ( $desc_len < 80 ) {
			$state = 'warn';
		} else {
			$state = 'info';
		}
		$checks[] = array(
			'id'    => 'desc_len',
			'label' => sprintf(
				/* translators: %d - character count */
				__( 'Meta description length: %d characters (guide: 120–160)', 'restwell-retreats' ),
				$desc_len
			),
			'state' => $state,
		);
	}

	// 5 - featured / OG.
	$checks[] = array(
		'id'    => 'og_image',
		'label' => $has_og
			? __( 'Featured or OG image is set', 'restwell-retreats' )
			: ( $has_site_og
				? __( 'No page OG/featured image — site default image will be used', 'restwell-retreats' )
				: __( 'No OG/featured image and no usable site default', 'restwell-retreats' ) ),
		'state' => $has_og ? 'ok' : ( $has_site_og ? 'info' : 'warn' ),
	);

	// 6 - content contains at least one heading (HTML corpus / derived heading meta).
	$has_heading = preg_match( '/<h[23]/i', $html ) === 1;
	$checks[]    = array(
		'id'    => 'headings',
		'label' => __( 'Content contains at least one subheading (h2/h3)', 'restwell-retreats' ),
		'state' => $has_heading ? 'ok' : ( $post->post_type === 'page' ? 'warn' : 'bad' ),
	);

	// 7 - word count (posts stricter).
	if ( $word_count >= 300 ) {
		$state = 'ok';
	} elseif ( $word_count >= 150 ) {
		$state = 'warn';
	} else {
		$state = ( 'post' === $post->post_type ) ? 'bad' : 'warn';
	}
	$checks[] = array(
		'id'    => 'word_count',
		'label' => sprintf(
			/* translators: %d - word count */
			__( 'Word count: %d words (recommended: 300+)', 'restwell-retreats' ),
			$word_count
		),
		'state' => $state,
	);

	// 8 - at least one internal link.
	$home_base    = untrailingslashit( home_url() );
	$has_internal = preg_match( '/href=["\']\//', $html ) === 1
		|| ( $home_base !== '' && preg_match( '#href=["\']' . preg_quote( $home_base, '#' ) . '/#', $html ) === 1 );
	$checks[]     = array(
		'id'    => 'internal_links',
		'label' => __( 'Content contains at least one internal link', 'restwell-retreats' ),
		'state' => $has_internal ? 'ok' : 'warn',
	);

	return $checks;
}

/**
 * Determine which JSON-LD schemas are active for this post.
 *
 * @param WP_Post $post     Post object.
 * @param string  $template Page template slug.
 * @return array<string, bool>
 */
function restwell_seo_admin_schema_status( WP_Post $post, string $template ): array {
	$front_id  = (int) get_option( 'page_on_front', 0 );
	$is_front  = ( $front_id > 0 && (int) $post->ID === $front_id );
	$breadcrumb = ! ( $post->post_type === 'page' && $front_id === (int) $post->ID );

	$is_property = ( 'template-property.php' === $template );

	return array(
		__( 'WebSite + Organization', 'restwell-retreats' ) => ! $is_front,
		__( 'WebSite + WebPage + Organization + LocalBusiness (front page)', 'restwell-retreats' ) => $is_front,
		__( 'LocalBusiness + Service (property template)', 'restwell-retreats' ) => $is_property && ! $is_front,
		__( 'BreadcrumbList', 'restwell-retreats' ) => $breadcrumb,
		__( 'FAQPage', 'restwell-retreats' ) => ( 'template-faq.php' === $template ) || ( 'template-pricing.php' === $template ) || ( 'template-care.php' === $template ) || ( 'template-resources.php' === $template ) || $is_front,
		__( 'AboutPage', 'restwell-retreats' ) => ( 'template-our-story.php' === $template ),
		__( 'CollectionPage', 'restwell-retreats' ) => ( 'template-resources.php' === $template ),
		__( 'Service (optional care)', 'restwell-retreats' ) => ( 'template-care.php' === $template ),
		__( 'ContactPage', 'restwell-retreats' ) => ( 'template-enquire.php' === $template ),
		__( 'TouristDestination', 'restwell-retreats' ) => ( 'template-whitstable-guide.php' === $template ),
		__( 'BlogPosting', 'restwell-retreats' ) => ( 'post' === $post->post_type ),
	);
}

// =============================================================================
// Save handler
// =============================================================================

/**
 * Persist SEO fields from a verified request (dedicated SEO screen).
 *
 * Caller must verify nonce and capabilities before calling.
 *
 * @param int     $post_id Post ID.
 * @param WP_Post $post    Post object.
 */
function restwell_seo_admin_save_fields( $post_id, $post ) {
	if ( ! $post instanceof WP_Post || ! in_array( $post->post_type, array( 'page', 'post' ), true ) ) {
		return;
	}

	// Caller (restwell_seo_pages_handle_save) already verified restwell_seo_nonce.
	// phpcs:disable WordPress.Security.NonceVerification.Missing

	$fields = array(
		'focus_keyphrase'  => 'sanitize_text_field',
		'meta_title'       => 'sanitize_text_field',
		'meta_description' => 'sanitize_textarea_field',
	);

	foreach ( $fields as $key => $sanitiser ) {
		if ( isset( $_POST[ $key ] ) ) {
			update_post_meta( $post_id, $key, call_user_func( $sanitiser, wp_unslash( $_POST[ $key ] ) ) );
		}
	}

	if ( isset( $_POST['og_image_id'] ) ) {
		$og_image_id = absint( $_POST['og_image_id'] );
		if ( $og_image_id > 0 ) {
			update_post_meta( $post_id, 'og_image_id', $og_image_id );
		} else {
			delete_post_meta( $post_id, 'og_image_id' );
		}
	}

	if ( isset( $_POST['meta_og_type'] ) ) {
		$og_type = sanitize_key( wp_unslash( $_POST['meta_og_type'] ) );
		if ( in_array( $og_type, array( 'website', 'article' ), true ) ) {
			update_post_meta( $post_id, 'meta_og_type', $og_type );
		}
	}

	if ( isset( $_POST['meta_canonical'] ) ) {
		$canonical = esc_url_raw( wp_unslash( $_POST['meta_canonical'] ) );
		update_post_meta( $post_id, 'meta_canonical', $canonical );
	}

	$noindex = isset( $_POST['meta_noindex'] ) ? absint( $_POST['meta_noindex'] ) : 0;
	update_post_meta( $post_id, 'meta_noindex', $noindex );
	// phpcs:enable WordPress.Security.NonceVerification.Missing
}
