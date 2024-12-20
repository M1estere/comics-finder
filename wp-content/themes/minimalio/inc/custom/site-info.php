<?php
/**
 * Custom hooks.
 *
 * @package minimalio
 */

defined( 'ABSPATH' ) || exit;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'minimalio_site_info' ) ) {
	/**
	 * Add site info hook to WP hook library.
	 */
	function minimalio_site_info() {
		do_action( 'minimalio_site_info' );
	}
}

if ( ! function_exists( 'minimalio_add_site_info' ) ) {
	add_action( 'minimalio_site_info', 'minimalio_add_site_info' );

	/**
	 * Add site info content.
	 */
	function minimalio_add_site_info() {
		$the_theme = wp_get_theme();

		$site_info = sprintf(
			'<a href="%1$s">%2$s</a><span class="sep"> | </span>%3$s(%4$s)',
			esc_url( __( 'https://minimalio.com', 'minimalio' ) ),
			sprintf(
				/* translators:*/
				esc_html__( 'Proudly powered by %s', 'minimalio' ),
				'Minimalio'
			),
			sprintf( // WPCS: XSS ok.
				/* translators:*/
				esc_html__( 'Theme: %1$s by %2$s.', 'minimalio' ),
				$the_theme->get( 'Name' ),
				'<a href="' . esc_url( __( 'https://minimalio.com', 'minimalio' ) ) . '">minimalio.com</a>'
			),
			sprintf( // WPCS: XSS ok.
				/* translators:*/
				esc_html__( 'Version: %1$s', 'minimalio' ),
				$the_theme->get( 'Version' )
			)
		);

		echo apply_filters( 'minimalio_site_info_content', $site_info ); // WPCS: XSS ok.
	}
}
