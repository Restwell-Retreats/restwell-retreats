<?php
/**
 * Primary navigation: mockup chrome classes, URL resolution, fallback + mobile sheet.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Path candidates for a nav slug (canonical first, then retired aliases).
 *
 * @param string $slug Nav slug.
 * @return string[]
 */
function restwell_nav_page_path_candidates( $slug ) {
	$slug = (string) $slug;
	if ( 'resources' === $slug || 'funding-and-support' === $slug ) {
		return array( 'funding-and-support', 'resources' );
	}
	return array( $slug );
}

/**
 * Find a page by nav slug, including retired aliases.
 *
 * @param string $slug Nav slug.
 * @return WP_Post|null
 */
function restwell_get_page_by_nav_slug( $slug ) {
	foreach ( restwell_nav_page_path_candidates( $slug ) as $path ) {
		$page = get_page_by_path( $path, OBJECT, 'page' );
		if ( $page instanceof WP_Post ) {
			return $page;
		}
	}
	return null;
}

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

	$page = restwell_get_page_by_nav_slug( $slug );
	$canonical = restwell_nav_page_path_candidates( $slug )[0];
	$cache[ $slug ] = $page ? get_permalink( $page ) : home_url( '/' . $canonical . '/' );
	return $cache[ $slug ];
}

/**
 * Current request path for aria-current matching.
 *
 * @return string
 */
function restwell_nav_current_path() {
	$path = wp_parse_url( home_url( add_query_arg( array() ) ), PHP_URL_PATH );
	$path = is_string( $path ) ? untrailingslashit( $path ) : '';
	return $path === '' ? '/' : $path;
}

/**
 * Whether a URL matches the current request.
 *
 * @param string $url Absolute or relative URL.
 * @return bool
 */
function restwell_nav_url_is_current( $url ) {
	$link_path = wp_parse_url( $url, PHP_URL_PATH );
	$link_path = is_string( $link_path ) ? untrailingslashit( $link_path ) : '';
	if ( $link_path === '' ) {
		$link_path = '/';
	}
	return $link_path === restwell_nav_current_path();
}

/**
 * Primary navigation tree matching mockup IA.
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
			'type'  => 'link',
			'label' => __( 'Home', 'restwell-retreats' ),
			'slug'  => '',
		),
		array(
			'type'     => 'dropdown',
			'label'    => __( 'The Bungalow', 'restwell-retreats' ),
			'nav_id'   => 'nav-stay',
			'children' => array(
				array(
					'label' => __( 'Our Story', 'restwell-retreats' ),
					'slug'  => 'our-story',
				),
				array(
					'label' => __( 'The Property', 'restwell-retreats' ),
					'slug'  => 'the-property',
				),
				array(
					'label' => __( 'Accessibility', 'restwell-retreats' ),
					'slug'  => 'accessibility',
				),
				array(
					'label' => __( 'Pricing & dates', 'restwell-retreats' ),
					'slug'  => 'pricing',
				),
				array(
					'label' => __( 'How It Works', 'restwell-retreats' ),
					'slug'  => 'how-it-works',
				),
			),
		),
		array(
			'type'     => 'dropdown',
			'label'    => __( 'Plan your trip', 'restwell-retreats' ),
			'nav_id'   => 'nav-plan',
			'children' => array(
				array(
					'label' => __( 'Who It’s For', 'restwell-retreats' ),
					'slug'  => 'who-its-for',
				),
				array(
					'label' => __( 'Whitstable', 'restwell-retreats' ),
					'slug'  => 'whitstable-area-guide',
				),
				array(
					'label' => __( 'Funding & Support', 'restwell-retreats' ),
					'slug'  => 'funding-and-support',
				),
				array(
					'label' => __( 'Optional care', 'restwell-retreats' ),
					'slug'  => 'optional-care',
				),
			),
		),
		array(
			'type'  => 'link',
			'label' => __( 'FAQ', 'restwell-retreats' ),
			'slug'  => 'faq',
		),
		array(
			'type'  => 'link',
			'label' => __( 'Blog', 'restwell-retreats' ),
			'slug'  => 'blog',
		),
	);

	$out = array();
	foreach ( $raw as $item ) {
		if ( 'link' === $item['type'] ) {
			$out[] = array(
				'type'  => 'link',
				'label' => $item['label'],
				'slug'  => $item['slug'],
				'url'   => restwell_nav_resolve_page_url( $item['slug'] ),
			);
			continue;
		}
		$children = array();
		foreach ( $item['children'] as $ch ) {
			$children[] = array(
				'label' => $ch['label'],
				'slug'  => $ch['slug'],
				'url'   => restwell_nav_resolve_page_url( $ch['slug'] ),
			);
		}
		$out[] = array(
			'type'     => 'dropdown',
			'label'    => $item['label'],
			'nav_id'   => $item['nav_id'],
			'children' => $children,
		);
	}

	$built = $out;
	return $built;
}

/**
 * Flat list of nav links (SEO helpers). Enquire is not included — gold CTA only.
 *
 * @return array<int, array{label: string, url: string}>
 */
function restwell_get_primary_nav_links() {
	$flat = array();
	foreach ( restwell_get_primary_nav_structure() as $item ) {
		if ( 'link' === $item['type'] ) {
			$flat[] = array(
				'label' => $item['label'],
				'url'   => $item['url'],
			);
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
 * Desktop fallback nav (mockup classes). Used when no Primary menu is assigned.
 */
function restwell_render_primary_nav_fallback() {
	$structure = restwell_get_primary_nav_structure();
	echo '<ul class="nav">';
	foreach ( $structure as $item ) {
		if ( 'link' === $item['type'] ) {
			$current = restwell_nav_url_is_current( $item['url'] );
			$cls     = $current ? 'is-active' : '';
			echo '<li>';
			echo '<a href="' . esc_url( $item['url'] ) . '" class="' . esc_attr( $cls ) . '"' . ( $current ? ' aria-current="page"' : '' ) . '>';
			echo esc_html( $item['label'] );
			echo '</a></li>';
			continue;
		}

		$mid        = $item['nav_id'];
		$child_curr = false;
		foreach ( $item['children'] as $ch ) {
			if ( restwell_nav_url_is_current( $ch['url'] ) ) {
				$child_curr = true;
				break;
			}
		}
		$li_class = 'nav__item nav__item--has-dropdown' . ( $child_curr ? ' is-current' : '' );
		echo '<li class="' . esc_attr( $li_class ) . '">';
		echo '<button type="button" class="nav__trigger" id="' . esc_attr( $mid ) . '-trigger" aria-expanded="false" aria-controls="' . esc_attr( $mid ) . '-menu">';
		echo esc_html( $item['label'] );
		echo '</button>';
		echo '<ul class="nav__dropdown" id="' . esc_attr( $mid ) . '-menu" role="list" aria-labelledby="' . esc_attr( $mid ) . '-trigger">';
		foreach ( $item['children'] as $ch ) {
			$current = restwell_nav_url_is_current( $ch['url'] );
			$cls     = $current ? 'is-active' : '';
			echo '<li><a href="' . esc_url( $ch['url'] ) . '" class="' . esc_attr( $cls ) . '"' . ( $current ? ' aria-current="page"' : '' ) . '>';
			echo esc_html( $ch['label'] );
			echo '</a></li>';
		}
		echo '</ul></li>';
	}
	echo '</ul>';
}

/**
 * Mobile sheet markup matching mockup groups.
 */
function restwell_render_mobile_nav() {
	$structure   = restwell_get_primary_nav_structure();
	$enquire_url = restwell_nav_resolve_page_url( 'enquire' );

	echo '<ul class="mobile-nav__list">';
	foreach ( $structure as $item ) {
		if ( 'link' === $item['type'] ) {
			$current = restwell_nav_url_is_current( $item['url'] );
			$cls     = $current ? 'is-active' : '';
			echo '<li><a href="' . esc_url( $item['url'] ) . '" class="' . esc_attr( $cls ) . '"' . ( $current ? ' aria-current="page"' : '' ) . '>';
			echo esc_html( $item['label'] );
			echo '</a></li>';
			continue;
		}

		echo '<li><span class="mobile-nav__group-label">' . esc_html( $item['label'] ) . '</span></li>';
		foreach ( $item['children'] as $ch ) {
			$current = restwell_nav_url_is_current( $ch['url'] );
			$cls     = $current ? 'is-active' : '';
			echo '<li><a href="' . esc_url( $ch['url'] ) . '" class="' . esc_attr( $cls ) . '"' . ( $current ? ' aria-current="page"' : '' ) . '>';
			echo esc_html( $ch['label'] );
			echo '</a></li>';
		}
		echo '<li class="mobile-nav__rule" aria-hidden="true"></li>';
	}
	echo '</ul>';
	echo '<div class="mobile-nav__cta">';
	echo '<a class="btn btn-gold" href="' . esc_url( $enquire_url ) . '">' . esc_html__( 'Enquire Now', 'restwell-retreats' ) . '</a>';
	echo '</div>';
}

/**
 * Walker: Primary menu → mockup .nav / .nav__dropdown markup.
 */
class Restwell_Concept_Nav_Walker extends Walker_Nav_Menu {

	/**
	 * Pending submenu ids after a dropdown trigger.
	 *
	 * @var string|null
	 */
	private $restwell_pending_submenu_id = null;

	/**
	 * Pending trigger id for aria-labelledby.
	 *
	 * @var string|null
	 */
	private $restwell_pending_trigger_id = null;

	/**
	 * @param string   $output Output.
	 * @param int      $depth  Depth.
	 * @param stdClass $args   Args.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		if ( 0 === (int) $depth && $this->restwell_pending_submenu_id ) {
			$output .= '<ul class="nav__dropdown" id="' . esc_attr( $this->restwell_pending_submenu_id ) . '" role="list" aria-labelledby="' . esc_attr( (string) $this->restwell_pending_trigger_id ) . '">';
			$this->restwell_pending_submenu_id = null;
			$this->restwell_pending_trigger_id = null;
			return;
		}
		$output .= '<ul class="nav__dropdown" role="list">';
	}

	/**
	 * @param string   $output Output.
	 * @param int      $depth  Depth.
	 * @param stdClass $args   Args.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '</ul>';
	}

	/**
	 * @param string   $output Output.
	 * @param WP_Post  $item   Item.
	 * @param int      $depth  Depth.
	 * @param stdClass $args   Args.
	 * @param int      $id     ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$classes      = empty( $item->classes ) ? array() : (array) $item->classes;
		$has_children = in_array( 'menu-item-has-children', $classes, true );
		$is_current   = in_array( 'current-menu-item', $classes, true ) || in_array( 'current_page_item', $classes, true );
		$is_ancestor  = in_array( 'current-menu-ancestor', $classes, true ) || in_array( 'current-menu-parent', $classes, true );

		$enquire_url = restwell_nav_resolve_page_url( 'enquire' );
		if ( 0 === (int) $depth && $enquire_url && untrailingslashit( (string) $item->url ) === untrailingslashit( $enquire_url ) ) {
			return;
		}

		if ( 0 === (int) $depth && $has_children ) {
			$li_class = 'nav__item nav__item--has-dropdown';
			if ( $is_ancestor || $is_current ) {
				$li_class .= ' is-current';
			}
			$trigger_id                        = 'nav-trigger-' . (int) $item->ID;
			$menu_id                           = 'nav-menu-' . (int) $item->ID;
			$this->restwell_pending_submenu_id = $menu_id;
			$this->restwell_pending_trigger_id = $trigger_id;
			$output                           .= '<li class="' . esc_attr( $li_class ) . '">';
			$output                           .= '<button type="button" class="nav__trigger" id="' . esc_attr( $trigger_id ) . '" aria-expanded="false" aria-controls="' . esc_attr( $menu_id ) . '">';
			$output                           .= esc_html( $item->title );
			$output                           .= '</button>';
			return;
		}

		$atts = array(
			'title'  => ! empty( $item->attr_title ) ? $item->attr_title : '',
			'target' => ! empty( $item->target ) ? $item->target : '',
			'rel'    => ! empty( $item->xfn ) ? $item->xfn : '',
			'href'   => ! empty( $item->url ) ? $item->url : '',
		);
		if ( $is_current ) {
			$atts['aria-current'] = 'page';
			$atts['class']        = 'is-active';
		}

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( is_scalar( $value ) && '' !== $value ) {
				$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$output .= '<li>';
		$output .= '<a' . $attributes . '>' . esc_html( $item->title ) . '</a>';
	}

	/**
	 * @param string   $output Output.
	 * @param WP_Post  $item   Item.
	 * @param int      $depth  Depth.
	 * @param stdClass $args   Args.
	 */
	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		$enquire_url = restwell_nav_resolve_page_url( 'enquire' );
		if ( 0 === (int) $depth && $enquire_url && untrailingslashit( (string) $item->url ) === untrailingslashit( $enquire_url ) ) {
			return;
		}
		$output .= '</li>';
	}
}

/**
 * Align Primary menu CSS classes with mockup nav.
 *
 * @param string[] $classes Classes.
 * @param WP_Post  $item    Item.
 * @param stdClass $args    Args.
 * @param int      $depth   Depth.
 * @return string[]
 */
function restwell_primary_nav_menu_css_class( $classes, $item, $args, $depth ) {
	if ( ! isset( $args->theme_location ) || 'primary' !== $args->theme_location ) {
		return $classes;
	}
	if ( 0 === (int) $depth && in_array( 'menu-item-has-children', $classes, true ) ) {
		$classes[] = 'nav__item';
		$classes[] = 'nav__item--has-dropdown';
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'restwell_primary_nav_menu_css_class', 10, 4 );
