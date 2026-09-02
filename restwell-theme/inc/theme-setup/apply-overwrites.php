<?php
/**
 * Apply copy-overwrites/ markdown briefs into WordPress page meta (runtime).
 *
 * Briefs are the editorial source. Page content meta is what templates render.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Map copy-overwrites filename (no .md) to WP page slug.
 *
 * @return array<string, string>
 */
function restwell_copy_overwrite_slug_map(): array {
	return array(
		'home'                  => 'home',
		'the-property'          => 'the-property',
		'accessibility'         => 'accessibility',
		'enquire'               => 'enquire',
		'pricing'               => 'pricing',
		'faq'                   => 'faq',
		'optional-care'         => 'optional-care',
		'how-it-works'          => 'how-it-works',
		'our-story'             => 'our-story',
		'who-its-for'           => 'who-its-for',
		'whitstable-area-guide' => 'whitstable-area-guide',
		'resources'             => 'funding-and-support',
		'guest-guide'           => 'guest-guide',
		'blog'                  => 'blog',
	);
}

/**
 * First non-empty paragraph after a markdown heading, until the next heading.
 *
 * @param string $markdown File contents.
 * @param string $heading  Heading text without leading hashes.
 * @return string
 */
function restwell_copy_overwrite_section_text( string $markdown, string $heading ): string {
	$pattern = '/^##\s+' . preg_quote( $heading, '/' ) . '\b[^\n]*$/im';
	if ( ! preg_match( $pattern, $markdown, $m, PREG_OFFSET_CAPTURE ) ) {
		return '';
	}
	$start = (int) $m[0][1] + strlen( $m[0][0] );
	$rest  = substr( $markdown, $start );
	if ( preg_match( '/^##\s+/m', $rest, $next, PREG_OFFSET_CAPTURE ) ) {
		$rest = substr( $rest, 0, (int) $next[0][1] );
	}
	$rest = trim( $rest );
		if ( '' === $rest ) {
			return '';
		}
		$lines   = preg_split( '/\r\n|\r|\n/', $rest );
		$buffer  = array();
		$started = false;
		foreach ( $lines as $line ) {
			$trim = trim( $line );
			if ( '' === $trim ) {
			if ( $started ) {
				break;
			}
			continue;
		}
		$first = isset( $trim[0] ) ? $trim[0] : '';
		if ( '#' === $first || '*' === $first || '-' === $first ) {
			if ( $started ) {
				break;
			}
			continue;
		}
		$started  = true;
		$buffer[] = $trim;
	}
	return trim( implode( ' ', $buffer ) );
}

/**
 * Parse Title, Meta description, and H1 from a copy-overwrites markdown file.
 *
 * @param string $path Absolute path to the .md file.
 * @return array{title:string,meta_description:string,h1:string}
 */
function restwell_parse_copy_overwrite_file( string $path ): array {
	$empty = array(
		'title'            => '',
		'meta_description' => '',
		'h1'               => '',
	);
	if ( ! is_readable( $path ) ) {
		return $empty;
	}
	$markdown = (string) file_get_contents( $path );
	return array(
		'title'            => restwell_copy_overwrite_section_text( $markdown, 'Title' ),
		'meta_description' => restwell_copy_overwrite_section_text( $markdown, 'Meta description' ),
		'h1'               => restwell_copy_overwrite_section_text( $markdown, 'H1' ),
	);
}

/**
 * Page-content meta key that holds the H1 for a setup slug.
 *
 * @param string $slug Page slug.
 * @return string Empty when this brief has no H1 meta mapping.
 */
function restwell_copy_overwrite_h1_meta_key( string $slug ): string {
	$map = array(
		'home'                  => 'hero_heading',
		'the-property'          => 'prop_hero_heading',
		'accessibility'         => 'acc_heading',
		'enquire'               => 'enq_heading',
		'pricing'               => 'pricing_heading',
		'faq'                   => 'faq_heading',
		'optional-care'         => 'care_heading',
		'how-it-works'          => 'hiw_heading',
		'our-story'             => 'story_heading',
		'who-its-for'           => 'wif_heading',
		'whitstable-area-guide' => 'wg_heading',
		'funding-and-support'   => 'res_heading',
	);
	return isset( $map[ $slug ] ) ? $map[ $slug ] : '';
}

/**
 * Write a post meta value when empty, or when overwrite is requested.
 *
 * @param int    $post_id             Page ID.
 * @param string $key                 Meta key.
 * @param string $value               New value.
 * @param bool   $overwrite_existing  Replace a non-empty value.
 * @return bool True when a write happened.
 */
function restwell_copy_overwrite_maybe_write_meta( int $post_id, string $key, string $value, bool $overwrite_existing ): bool {
	if ( '' === $value ) {
		return false;
	}
	$cur = (string) get_post_meta( $post_id, $key, true );
	if ( '' !== $cur && ! $overwrite_existing ) {
		return false;
	}
	update_post_meta( $post_id, $key, $value );
	return true;
}

/**
 * Apply copy-overwrites briefs to matching published pages.
 *
 * Empty SEO / H1 fields are filled. Existing values are replaced only when
 * $overwrite_existing is true (Theme Setup “overwrite SEO” checkbox).
 *
 * @param bool $overwrite_existing Whether to replace non-empty meta.
 * @return array<string, mixed> Counts for Theme Setup output.
 */
function restwell_apply_copy_overwrites( bool $overwrite_existing = false ): array {
	$result = array(
		'pages_touched'  => 0,
		'fields_written' => 0,
		'missing_pages'  => array(),
	);
	$dir = get_template_directory() . '/copy-overwrites';
	if ( ! is_dir( $dir ) ) {
		return $result;
	}

	foreach ( restwell_copy_overwrite_slug_map() as $stem => $slug ) {
		$parsed = restwell_parse_copy_overwrite_file( $dir . '/' . $stem . '.md' );
		$page   = get_page_by_path( $slug, OBJECT, 'page' );
		if ( ! $page instanceof WP_Post ) {
			$result['missing_pages'][] = $slug;
			continue;
		}
		$pid     = (int) $page->ID;
		$written = 0;

		if ( restwell_copy_overwrite_maybe_write_meta( $pid, 'meta_title', $parsed['title'], $overwrite_existing ) ) {
			++$written;
		}
		if ( restwell_copy_overwrite_maybe_write_meta( $pid, 'meta_description', $parsed['meta_description'], $overwrite_existing ) ) {
			++$written;
		}

		$h1_key = restwell_copy_overwrite_h1_meta_key( $slug );
		if ( '' !== $h1_key && restwell_copy_overwrite_maybe_write_meta( $pid, $h1_key, $parsed['h1'], $overwrite_existing ) ) {
			++$written;
		}

		if ( $written > 0 ) {
			++$result['pages_touched'];
			$result['fields_written'] += $written;
		}
	}

	return $result;
}
