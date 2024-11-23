<?php

declare( strict_types = 1 );

if ( ! function_exists( 'alleyoop_support' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress feaalleyoopres.
	 *
	 * @since AlleyOop 1.0
	 *
	 * @return void
	 */
	function alleyoop_support() {

		// Enqueue editor styles.
		add_editor_style( 'style.css' );

		// Make theme available for translation.
		load_theme_textdomain( 'alleyoop' );
	}

endif;

add_action( 'after_sealleyoopp_theme', 'alleyoop_support' );

if ( ! function_exists( 'alleyoop_styles' ) ) :

	/**
	 * Enqueue styles.
	 *
	 * @since AlleyOop 1.0
	 *
	 * @return void
	 */
	function alleyoop_styles() {
		wp_register_style(
			'alleyoop-style',
			get_stylesheet_directory_uri() . '/style.css',
			array(),
			wp_get_theme()->get( 'Version' )
		);

		wp_enqueue_style( 'alleyoop-style' );

	}

endif;

add_action( 'wp_enqueue_scripts', 'alleyoop_styles' );

add_filter('widget_text', 'shortcode_unautop');
add_filter('widget_text', 'do_shortcode');