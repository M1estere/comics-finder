<?php
/**
 * Theme Minimalio
 * Inline styles
 * From Minimalio Customizer
 */

defined( 'ABSPATH' ) || exit();
/**
 * Layout options
 */
function minimalio_dynamic_styles() {
	if ( get_theme_mod( 'minimalio_settings_container_type' ) !== 'container-fluid' ) {
		$container_width = get_theme_mod( 'minimalio_settings_container_width' );
	} else {
		$container_width = '';
	}

	$styles = [
		'container_width'           => $container_width,
		'scrollbar'                 => get_theme_mod( 'minimalio_settings_scrollbar' ),
		'body_background'           => get_theme_mod(
			'minimalio_settings_image_background'
		),
		'body_color'                => str_replace(
			'#',
			'',
			get_theme_mod( 'minimalio_settings_color_background' )
		),
		'main_font'                 => get_theme_mod(
			'minimalio_typography_settings_google_font'
		),
		'main_font_size'            => get_theme_mod(
			'minimalio_settings_google_font_size'
		),
		'main_font_size_tablet'     => get_theme_mod(
			'minimalio_settings_google_font_size_tablet'
		),
		'main_font_size_mobile'     => get_theme_mod(
			'minimalio_settings_google_font_size_mobile'
		),
		'main_font_weight'          => get_theme_mod(
			'minimalio_typography_settings_google_font_wight'
		),
		'main_font_style'           => get_theme_mod(
			'minimalio_settings_google_font_style'
		),
		'main_font_line'            => get_theme_mod(
			'minimalio_settings_google_line_height'
		),
		'main_font_spacing'         => get_theme_mod(
			'minimalio_settings_google_letter_spacing'
		),
		'main_font_color'           => str_replace(
			'#',
			'',
			get_theme_mod( 'minimalio_settings_font_color' )
		),
		'main_font_link_decoration' => get_theme_mod(
			'minimalio_settings_google_link_decoration'
		),
		
		'link_color'                => str_replace(
			'#',
			'',
			get_theme_mod( 'minimalio_settings_link_color' )
		),
		'link_color_hover'          => str_replace(
			'#',
			'',
			get_theme_mod( 'minimalio_settings_hover_color' )
		),
		'logo_width'                => get_theme_mod( 'minimalio_settings_logo_width' ),
		'header_text_decoration'    => get_theme_mod(
			'minimalio_settings_link_decoration'
		),
		'header_text_weight'        => get_theme_mod( 'minimalio_settings_link_weight' ),
		'header_text_font_size'     => get_theme_mod(
			'minimalio_settings_menu_google_font_size'
		),
		'submenu_font_size'         => get_theme_mod(
			'minimalio_settings_submenu_font_size'
		),
		'header_text_font_weight'   => get_theme_mod(
			'minimalio_settings_menu_google_font_weight'
		),
		'header_text_font_style'    => get_theme_mod(
			'minimalio_settings_menu_google_font_style'
		),
		'header_text_font_spacing'  => get_theme_mod(
			'minimalio_settings_menu_google_letter_spacing'
		),
		'header_background'         => str_replace(
			'#',
			'',
			get_theme_mod( 'minimalio_settings_header_background' )
		),
		'header_fixed_background'   => str_replace(
			'#',
			'',
			get_theme_mod( 'minimalio_settings_fixed_header_background' )
		),
		'header_fixed_color'        => str_replace(
			'#',
			'',
			get_theme_mod( 'minimalio_settings_fixed_color' )
		),
		'header_fixed_color_hover'  => str_replace(
			'#',
			'',
			get_theme_mod( 'minimalio_settings_fixed_color_hover' )
		),
		'header_color'              => str_replace(
			'#',
			'',
			get_theme_mod( 'minimalio_settings_header_color' )
		),
		'header_color_hover'        => str_replace(
			'#',
			'',
			get_theme_mod( 'minimalio_settings_header_color_hover' )
		),
		'submenu_background'        => str_replace(
			'#',
			'',
			get_theme_mod( 'minimalio_settings_submenu_background_color' )
		),
		'submenu_color'             => str_replace(
			'#',
			'',
			get_theme_mod( 'minimalio_settings_submenu_color' )
		),
		'submenu_color_hover'       => str_replace(
			'#',
			'',
			get_theme_mod( 'minimalio_settings_submenu_color_hover' )
		),
		'blog_hover_color'          => str_replace(
			'#',
			'',
			get_theme_mod( 'minimalio_settings_blog_hover_color' )
		),
		'portfolio_hover_color'     => str_replace(
			'#',
			'',
			get_theme_mod( 'minimalio_settings_portfolio_hover_color' )
		),
		'footer_background'         => str_replace(
			'#',
			'',
			get_theme_mod( 'minimalio_settings_footer_background' )
		),
		'footer_font_color'         => str_replace(
			'#',
			'',
			get_theme_mod( 'minimalio_settings_footer_font_color' )
		),
		'back_top_background'       => str_replace(
			'#',
			'',
			get_theme_mod( 'minimalio_settings_top_background' )
		),
		'breaking_point'            => get_theme_mod(
			'minimalio_settings_mobile_menu_breack'
		),
		'icons_bar_color'           => str_replace(
			'#',
			'',
			get_theme_mod( 'minimalio_settings_mobile_menu_icon_colour' )
		),
		'icons_bar_color_fixed'     => str_replace(
			'#',
			'',
			get_theme_mod( 'minimalio_settings_mobile_menu_icon_colour_fixed' )
		),
		'mobile_top_background'     => str_replace(
			'#',
			'',
			get_theme_mod( 'minimalio_settings_mobile_top_background' )
		),
		'mobile_close_color'        => str_replace(
			'#',
			'',
			get_theme_mod( 'minimalio_settings_mobile_close_colour' )
		),
		'mobile_background'         => str_replace(
			'#',
			'',
			get_theme_mod( 'minimalio_settings_mobile_body_background' )
		),
		'mobile_color'              => str_replace(
			'#',
			'',
			get_theme_mod( 'minimalio_settings_mobile_font_colour' )
		),
		'mobile_font_size'          => get_theme_mod(
			'minimalio_settings_mobile_font_size'
		),
		'mobile_font_style'         => get_theme_mod(
			'minimalio_settings_mobile_font_style'
		),
		'mobile_font_spacing'       => get_theme_mod(
			'minimalio_settings_mobile_letter_spacing'
		),
		'lightbox_icons_color'      => str_replace(
			'#',
			'',
			get_theme_mod( 'minimalio_ligtbox_icon_color_settings' )
		),
	];

	function minimalio_mapped_implode( $glue, $array, $symbol = '=' ) {
		return implode(
			$glue,
			array_map(
				function ( $k, $v ) use ( $symbol ) {
					return $k . $symbol . $v;
				},
				array_keys( $array ),
				array_values( $array )
			)
		);
	}

	global $parameters;
	$parameters = $styles;
	$css = require_once(__DIR__ . '/../../custom/customizer.css.php');

	wp_register_style( 'layout-options', false );
	wp_enqueue_style( 'layout-options' );

	wp_add_inline_style(
		'layout-options',
		$css,
	);
}
add_action( 'wp_enqueue_scripts', 'minimalio_dynamic_styles' );

/**
 * Used by hook: 'customize_preview_init'
 *
 * @see add_action('customize_preview_init',$func)
 */
function minimalio_customizer_live_preview() {
	wp_enqueue_script(
		'minimalio-themecustomizer',
		get_template_directory_uri() .
			'/inc/theme-customizer/js/minimalio-theme-customizer.js',
		[ 'jquery', 'customize-preview' ],
		MINIMALIO_VERSION,
		true
	);
}
add_action( 'customize_preview_init', 'minimalio_customizer_live_preview' );

/**
 * Load dynamic logic for the customizer controls area.
 */
function minimalio_customizer_controls_js() {
	wp_enqueue_script(
		'customizer-control',
		get_theme_file_uri(
			'/inc/theme-customizer/js/minimalio-customize-controls.js'
		),
		[],
		'20181231',
		true
	);
}
add_action(
	'customize_controls_enqueue_scripts',
	'minimalio_customizer_controls_js'
);
