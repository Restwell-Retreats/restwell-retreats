<?php
/**
 * Primary navigation: WP menu filters, URL resolution, fallback structure/markup.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Align Primary menu markup with fallback nav classes for shared dropdown CSS/JS.
 *
 * @param string[] $classes Nav item classes.
 * @param WP_Post  $item    Menu item.
 * @param stdClass $args    wp_nav_menu() arguments.
 * @param int      $depth   Depth.
 * @return string[]
 */
function restwell_primary_nav_menu_css_class( $classes, $item, $args, $depth ) {
	if ( ! isset( $args->theme_location ) || 'primary' !== $args->theme_location ) {
		return $classes;
	}
	if ( 0 === (int) $depth ) {
		$classes[] = 'site-nav__item';
		if ( in_array( 'menu-item-has-children', $classes, true ) ) {
			$classes[] = 'site-nav__item--has-dropdown';
		}
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'restwell_primary_nav_menu_css_class', 10, 4 );

/**
 * Add submenu class so Primary dropdowns share styles with the fallback nav.
 *
 * @param string[] $classes Submenu ul classes.
 * @param stdClass $args    wp_nav_menu() arguments.
 * @param int      $depth   Depth.
 * @return string[]
 */
function restwell_primary_nav_submenu_css_class( $classes, $args, $depth ) {
	if ( isset( $args->theme_location ) && 'primary' === $args->theme_location ) {
		$classes[] = 'site-nav__submenu';
	}
	return $classes;
}
add_filter( 'nav_menu_submenu_css_class', 'restwell_primary_nav_submenu_css_class', 10, 3 );

/**
 * Add CTA classes to the Enquire menu item so styles match fallback nav (desktop + mobile sheet).
 *
 * @param array    $atts  HTML attributes for the anchor.
 * @param WP_Post  $item  Menu item.
 * @param stdClass $args  Menu arguments.
 * @return array
 */
function restwell_primary_nav_menu_link_attributes( $atts, $item, $args ) {
	if ( ! isset( $args->theme_location ) || 'primary' !== $args->theme_location ) {
		return $atts;
	}
	$enquire_url = restwell_nav_resolve_page_url( 'enquire' );
	$item_url    = isset( $item->url ) ? $item->url : '';
	if ( $item_url === '' || $enquire_url === '' ) {
		return $atts;
	}
	if ( untrailingslashit( $item_url ) !== untrailingslashit( $enquire_url ) ) {
		return $atts;
	}
	$existing       = isset( $atts['class'] ) ? $atts['class'] : '';
	$atts['class'] = trim( $existing . ' site-nav-cta mobile-nav-cta' );
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'restwell_primary_nav_menu_link_attributes', 10, 3 );

/**
 * Resolve a page slug to its permalink (home when slug is empty).
 *
 * @param string $slug Page path slug or empty for front page.
 * @return string
 */
function restwell_nav_resolve_page_url( $slug ) {
	static $cache = array();
	$slug = (string) $slug;
	if ( $slug === '' ) {
		return home_url( '/' );
	}
	if ( isset( $cache[ $slug ] ) ) {
		return $cache[ $slug ];
	}

	// Match Settings → Privacy: footer and nav must link to the designated policy page, not only /privacy-policy/.
	if ( 'privacy-policy' === $slug ) {
		$policy_id = (int) get_option( 'wp_page_for_privacy_policy', 0 );
		if ( $policy_id > 0 ) {
			$policy_url = get_permalink( $policy_id );
			if ( $policy_url ) {
				$cache[ $slug ] = $policy_url;
				return $cache[ $slug ];
			}
		}
	}

	$page = get_page_by_path( $slug, OBJECT, 'page' );
	$cache[ $slug ] = $page ? get_permalink( $page ) : home_url( '/' . $slug . '/' );
	return $cache[ $slug ];
}

/**
 * Primary navigation tree for desktop: top-level links plus dropdown groups.
 * Used by the fallback menu; mobile/footer use a flattened list from the same data.
 *
 * @return array<int, array<string, mixed>>
 */
function restwell_get_primary_nav_structure() {
	static $built = null;
	if ( null !== $built ) {
		return $built;
	}

	$raw = array(
		array(
			'type'   => 'link',
			'label'  => __( 'Home', 'restwell-retreats' ),
			'slug'   => '',
			'is_cta' => false,
		),
		array(
			'type'     => 'dropdown',
			'label'    => __( 'Your stay', 'restwell-retreats' ),
			'nav_id'   => 'restwell-nav-stay',
			'children' => array(
				array(
					'label' => __( 'The Property', 'restwell-retreats' ),
					'slug' => 'the-property',
				),
				array(
					'label' => __( 'How It Works', 'restwell-retreats' ),
					'slug' => 'how-it-works',
				),
				array(
					'label' => __( 'Accessibility', 'restwell-retreats' ),
					'slug' => 'accessibility',
				),
				array(
					'label' => __( 'Who It\'s For', 'restwell-retreats' ),
					'slug' => 'who-its-for',
				),
			),
		),
		array(
			'type'     => 'dropdown',
			'label'    => __( 'Area guide', 'restwell-retreats' ),
			'nav_id'   => 'restwell-nav-area',
			'children' => array(
				array(
					'label' => __( 'Whitstable Guide', 'restwell-retreats' ),
					'slug' => 'whitstable-area-guide',
				),
			),
		),
		array(
			'type'   => 'link',
			'label'  => __( 'Funding & Support', 'restwell-retreats' ),
			'slug'   => 'resources',
			'is_cta' => false,
		),
		array(
			'type'   => 'link',
			'label'  => __( 'FAQ', 'restwell-retreats' ),
			'slug'   => 'faq',
			'is_cta' => false,
		),
		array(
			'type'   => 'link',
			'label'  => __( 'Blog', 'restwell-retreats' ),
			'slug'   => 'blog',
			'is_cta' => false,
		),
		array(
			'type'   => 'link',
			'label'  => __( 'Enquire Now', 'restwell-retreats' ),
			'slug'   => 'enquire',
			'is_cta' => true,
		),
	);

	$out = array();
	foreach ( $raw as $item ) {
		if ( 'link' === $item['type'] ) {
			$out[] = array(
				'type'   => 'link',
				'label'  => $item['label'],
				'slug'   => $item['slug'],
				'url'    => restwell_nav_resolve_page_url( $item['slug'] ),
				'is_cta' => ! empty( $item['is_cta'] ),
			);
		} else {
			$children = array();
			foreach ( $item['children'] as $ch ) {
				$children[] = array(
					'label' => $ch['label'],
					'slug'  => $ch['slug'],
					'url'   => restwell_nav_resolve_page_url( $ch['slug'] ),
				);
			}
			// A single-child dropdown adds an unnecessary interaction step.
			// Collapse to a direct top-level link and keep the parent label.
			if ( 1 === count( $children ) ) {
				$out[] = array(
					'type'   => 'link',
					'label'  => $item['label'],
					'slug'   => $children[0]['slug'],
					'url'    => $children[0]['url'],
					'is_cta' => false,
				);
				continue;
			}
			$out[] = array(
				'type'     => 'dropdown',
				'label'    => $item['label'],
				'nav_id'   => $item['nav_id'],
				'children' => $children,
			);
		}
	}

	$built = $out;
	return $built;
}

/**
 * Flat list of nav links for footer, mobile fallback, and SEO: same destinations as the desktop structure.
 *
 * @return array<int, array{label: string, url: string, is_cta?: bool}>
 */
function restwell_get_primary_nav_links() {
	$flat = array();
	foreach ( restwell_get_primary_nav_structure() as $item ) {
		if ( 'link' === $item['type'] ) {
			$row = array(
				'label' => $item['label'],
				'url'   => $item['url'],
			);
			if ( ! empty( $item['is_cta'] ) ) {
				$row['is_cta'] = true;
			}
			$flat[] = $row;
		} else {
			foreach ( $item['children'] as $ch ) {
				$flat[] = array(
					'label' => $ch['label'],
					'url'   => $ch['url'],
				);
			}
		}
	}
	return $flat;
}

/**
 * Markup for the desktop fallback nav (dropdowns + links). Used when no Primary menu is assigned.
 */
function restwell_render_primary_nav_fallback() {
	$structure = restwell_get_primary_nav_structure();
	echo '<ul class="site-nav-list">';
	foreach ( $structure as $item ) {
		if ( 'link' === $item['type'] ) {
			$class = ! empty( $item['is_cta'] ) ? 'site-nav-cta' : '';
			echo '<li class="site-nav__item">';
			echo '<a href="' . esc_url( $item['url'] ) . '" class="' . esc_attr( trim( $class ) ) . '">' . esc_html( $item['label'] ) . '</a>';
			echo '</li>';
			continue;
		}

		$mid = $item['nav_id'];
		echo '<li class="site-nav__item site-nav__item--has-dropdown" data-nav-dropdown>';
		echo '<button type="button" class="site-nav__dropdown-toggle" id="' . esc_attr( $mid ) . '-btn" aria-expanded="false" aria-haspopup="true" aria-controls="' . esc_attr( $mid ) . '-menu">';
		echo esc_html( $item['label'] );
		echo '<span class="site-nav__dropdown-chevron" aria-hidden="true"><i class="ph-bold ph-caret-down"></i></span>';
		echo '</button>';
		echo '<ul class="site-nav__submenu" id="' . esc_attr( $mid ) . '-menu" role="list">';
		foreach ( $item['children'] as $ch ) {
			echo '<li class="site-nav__submenu-item" role="none">';
			echo '<a href="' . esc_url( $ch['url'] ) . '" class="site-nav__submenu-link">' . esc_html( $ch['label'] ) . '</a>';
			echo '</li>';
		}
		echo '</ul>';
		echo '</li>';
	}
	echo '</ul>';
}
