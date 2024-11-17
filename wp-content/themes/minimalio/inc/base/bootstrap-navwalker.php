<?php
/**
 * Custom nav walker for adding BEM based classes
 *
 * @author Warren Bickley <warren@wbickley.com>
 * @since  1.0
 */

defined( 'ABSPATH' ) || exit;

class Minimalio_BemNavWalker extends Walker {

	public $bem_class = 'menu';

	/**
	 * What the class handles.
	 *
	 * @see Walker::$tree_type
	 * @since 3.0.0
	 * @var string
	 */
	public $tree_type = [ 'post_type', 'taxonomy', 'custom' ];

	/**
	 * Database fields to use.
	 *
	 * @see Walker::$db_fields
	 * @since 3.0.0
	 * @todo Decouple this.
	 * @var array
	 */
	public $db_fields = [
		'parent' => 'menu_item_parent',
		'id'     => 'db_id',
	];

	/**
	 * Starts the list before the elements are added.
	 *
	 * @since 3.0.0
	 *
	 * @see Walker::start_lvl()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $minimalio_args   An array of wp_nav_menu() arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $minimalio_args = [] ) {
		$minimalio_class = isset( $minimalio_args->bem_block ) ? esc_attr( $minimalio_args->bem_block ) : $this->bem_class;

		if ( $depth >= 0 ) {
			$minimalio_class .= '__submenu ' . $this->bem_class . '__submenu--depth-' . ( $depth + 1 );
		}

		$indent = str_repeat( "\t", $depth );

		if ( isset( $minimalio_args->before_ul ) && $depth === 0 ) {
			$output .= $minimalio_args->before_ul;
		}

		$output .= "\n$indent<ul class=\"" . $minimalio_class . "\">\n";
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @since 3.0.0
	 *
	 * @see Walker::end_lvl()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $minimalio_args   An array of wp_nav_menu() arguments.
	 */
	public function end_lvl( &$output, $depth = 0, $minimalio_args = [] ) {
		$indent  = str_repeat( "\t", $depth );
		$output .= "$indent</ul>\n";

		if ( isset( $minimalio_args->after_ul ) && $depth === 0 ) {
			$output .= $minimalio_args->after_ul;
		}
	}

	/**
	 * Starts the element output.
	 *
	 * @since 3.0.0
	 * @since 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
	 *
	 * @see Walker::start_el()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $minimalio_args   An array of wp_nav_menu() arguments.
	 * @param int    $id     Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $minimalio_args = [], $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$classes = empty( $item->classes ) ? [] : (array) $item->classes;

		// Add class for open parrent
		$open_menu = get_theme_mod( 'minimalio_settings_submenu_open' );

		if ( $open_menu === 'yes' ) {
			$classes[] = 'menu-item__open-parent';
		}

		// Special class for portfolio
		$currentPageUrl = $_SERVER['REQUEST_URI'];
		$website        = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http' ) . "://$_SERVER[HTTP_HOST]" . '/';
		$actual_link    = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http' ) . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$slug           = get_theme_mod( 'minimalio_settings_portfolio_slug' );
		$home_portfolio = get_theme_mod( 'minimalio_settings_portfolio_home' );
		$menu_slug      = str_replace( $website, '', $item->url );

		if ( get_theme_mod( 'minimalio_settings_portfolio_slug' ) ) {
			$portfolio_slug = get_theme_mod( 'minimalio_settings_portfolio_slug' );
		} else {
			$portfolio_slug = 'portfolio';
		}

		if ( $menu_slug === $portfolio_slug || str_replace( '/', '', $menu_slug ) === $portfolio_slug ) {
			$classes[] = 'portfolio';
		}

		// Check if portfolio is home page
		if ( $home_portfolio === 'yes' ) {

			if ( $actual_link === $item->url || $actual_link === $item->url . '/' ) {

				$classes[] = 'portfolio';
			}
		}

		/* Add our BEM class */
		$classes[] = ( isset( $minimalio_args->bem_block ) ? esc_attr( $minimalio_args->bem_block ) : $this->bem_class ) . '__item ';

		$classes[] = 'menu-item-' . $item->ID;

		/**
		 * Filters the arguments for a single nav menu item.
		 *
		 * @since 4.4.0
		 *
		 * @param array  $minimalio_args  An array of arguments.
		 * @param object $item  Menu item data object.
		 * @param int    $depth Depth of menu item. Used for padding.
		 */
		$minimalio_args = apply_filters( 'nav_menu_item_args', $minimalio_args, $item, $depth );

		/**
		 * Filters the CSS class(es) applied to a menu item's list item element.
		 *
		 * @since 3.0.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array  $classes The CSS classes that are applied to the menu item's `<li>` element.
		 * @param object $item    The current menu item.
		 * @param array  $minimalio_args    An array of wp_nav_menu() arguments.
		 * @param int    $depth   Depth of menu item. Used for padding.
		 */
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $minimalio_args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		/**
		 * Filters the ID applied to a menu item's list item element.
		 *
		 * @since 3.0.1
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
		 * @param object $item    The current menu item.
		 * @param array  $minimalio_args    An array of wp_nav_menu() arguments.
		 * @param int    $depth   Depth of menu item. Used for padding.
		 */
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $minimalio_args, $depth );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $class_names . '>';

		$atts           = [];
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target ) ? $item->target : '';
		$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
		$atts['href']   = ! empty( $item->url ) ? $item->url : '';

		/* Add BEM class to anchor */
		$atts['class'] = ( isset( $minimalio_args->bem_block ) ? esc_attr( $minimalio_args->bem_block ) : $this->bem_class ) . '__link';

		/* Add ARIA to current page */
		$atts['aria-current'] = $item->current ? 'page' : '';
		/**
		 * Filters the HTML attributes applied to a menu item's anchor element.
		 *
		 * @since 3.6.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array $atts {
		 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 *
		 *     @type string $minimalio_title  Title attribute.
		 *     @type string $target Target attribute.
		 *     @type string $rel    The rel attribute.
		 *     @type string $href   The href attribute.
		 * }
		 * @param object $item  The current menu item.
		 * @param array  $minimalio_args  An array of wp_nav_menu() arguments.
		 * @param int    $depth Depth of menu item. Used for padding.
		 */
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $minimalio_args, $depth );

		$attributes = '';
		$my_slug    = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
				if ( ( $slug = strpos( $value, '?category=/' ) ) !== false ) {
					$clean_slug = substr( $value, $slug + 11 );
				} else {
					$clean_slug = '';
				}
				$my_slug .= $clean_slug;
			}
		}

		/** This filter is documented in wp-includes/post-template.php */
		$minimalio_title = apply_filters( 'the_title', $item->title, $item->ID );

		/**
		 * Filters a menu item's title.
		 *
		 * @since 4.4.0
		 *
		 * @param string $minimalio_title The menu item's title.
		 * @param object $item  The current menu item.
		 * @param array  $minimalio_args  An array of wp_nav_menu() arguments.
		 * @param int    $depth Depth of menu item. Used for padding.
		 */
		$minimalio_title = apply_filters( 'nav_menu_item_title', $minimalio_title, $item, $minimalio_args, $depth );

		$item_output  = $minimalio_args->before;
		$item_output .= '<a' . $attributes . ' data-slug="' . trim( $my_slug, '/' ) . '" >';
		$item_output .= $minimalio_args->link_before . $minimalio_title . $minimalio_args->link_after;
		$item_output .= '</a>';
		$item_output .= $minimalio_args->after;

		/**
		 * Filters a menu item's starting output.
		 *
		 * The menu item's starting output only includes `$minimalio_args->before`, the opening `<a>`,
		 * the menu item's title, the closing `</a>`, and `$minimalio_args->after`. Currently, there is
		 * no filter for modifying the opening and closing `<li>` for a menu item.
		 *
		 * @since 3.0.0
		 *
		 * @param string $item_output The menu item's starting HTML output.
		 * @param object $item        Menu item data object.
		 * @param int    $depth       Depth of menu item. Used for padding.
		 * @param array  $minimalio_args        An array of wp_nav_menu() arguments.
		 */
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $minimalio_args );
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @since 3.0.0
	 *
	 * @see Walker::end_el()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Page data object. Not used.
	 * @param int    $depth  Depth of page. Not Used.
	 * @param array  $minimalio_args   An array of wp_nav_menu() arguments.
	 */
	public function end_el( &$output, $item, $depth = 0, $minimalio_args = [] ) {
		$output .= "</li>\n";
	}
} // Walker_Nav_Menu
