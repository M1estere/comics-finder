<?php

/**
 * Load the relevant assets
 */

defined( 'ABSPATH' ) || exit;

new minimalio__Loader;
class minimalio__Loader {

	/**
	 * Called on class initialisation
	 */
	function __construct() {
		/* Setup wp global for removing query vars */
		global $wp;

		/* Add conditional tags around scripts that require them */
		add_filter( 'script_loader_tag', [ $this, 'minimalio_conditional_scripts' ], 10, 2 );

		/* Add our page templates to the page attributes dropdown */
		add_filter( 'theme_page_templates', [ $this, 'minimalio_add_page_templates' ], 10, 3 );

		/* Add compatibility tags for browsers */
		add_action( 'wp_head', [ $this, 'minimalio_compatibility_tags' ] );

		/* Load TypeKit kit */
		add_action( 'wp_head', [ $this, 'minimalio_load_typekit' ] );

		/* Remove emoji actions introduced in WordPress 4.2 */
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

		/* Remove the emoji button from the TinyMCE editor */
		add_filter( 'tiny_mce_plugins', [ $this, 'minimalio_remove_tinymce_emojis' ] );

		/* Remove jQuery migrate code from queue */
		add_filter( 'wp_default_scripts', [ $this, 'minimalio_remove_jquery_migrate' ] );

		/* Remove the embed query var */
		$wp->public_query_vars = array_diff($wp->public_query_vars, [
			'embed',
		]);

		/* Remove wp_oembed actions and filters introduced in WordPress 4.4 */
		remove_action( 'rest_api_init', 'wp_oembed_register_route' );
		add_filter( 'embed_oembed_discover', '__return_false' );
		remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
	}


	/**
	 * Selectively add conditional tags around assets
	 * @param  string $minimalio_tag    Full <link> or <script> tag
	 * @param  string $handle The handle/slug passed to enqueue function
	 * @return string         Modified $minimalio_tag
	 */
	public function minimalio_conditional_scripts( $minimalio_tag, $handle ) {
		// Add lower than ie9 wrapper around html5shiv
		if ( 'html5shiv' === $handle ) {
			$minimalio_tag = '<!--[if lt IE 9]>' . $minimalio_tag . '<![endif]-->';
		}

		return $minimalio_tag;
	}

	/**
	 * Add tags required for best compatibility
	 */
	public function minimalio_compatibility_tags() {
		echo '<meta charset="utf-8">';
	}

	/**
	 * Load TypeKit fonts
	 */
	public function minimalio_load_typekit() {
		// To load a typekit "kit" simply use the `load_typekit` function
		// containing the kit ID as the first and only parameter.
		if ( false !== get_theme_mod( 'minimalio_typography_settings_google_font' ) ) {
			echo '	<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=' . get_theme_mod( 'minimalio_typography_settings_google_font' ) . ':wght@' . get_theme_mod( 'minimalio_typography_settings_google_font_wight', 400 ) . '&display=swap">';
		}
	}

	/**
	 * Add our 2nd level page templates into the attribute dropdown
	 */
	public function minimalio_add_page_templates( $templates ) {
		/* Check to see if their is a page template cache */
		$theme_templates = wp_cache_get( 'minimalio_page_templates', 'minimalio' );

		/* If the cache is valid, merge it with existing templates and return */
		if ( is_array( $theme_templates ) ) {
			return array_merge( $templates, $theme_templates );
		}

		/* Empty the templates variable incase cache was invalid */
		$theme_templates = [];

		/* Get all the files within our templates folder */
		$dir   = get_template_directory() . '/templates/pages/';
		$files = scandir( $dir );

		/* Loop over template files */
		foreach ( $files as $file ) {
			/* Get the headers from the file */
			$headers = get_file_data( $dir . $file, [ 'Template Name' => 'Template Name' ] );

			/* If no template name is given, then skip */
			if ( empty( $headers['Template Name'] ) ) {
				continue;
			}

			/* Internationalise the header into the array with file as key */
			$theme_templates[ 'templates/pages/' . $file ] = $headers['Template Name'];
		}

		/* Build our page templates cache */
		wp_cache_add( 'minimalio_page_templates', $theme_templates, 'minimalio' );

		/* Add our page templates to the list */
		$templates = array_merge( $templates, $theme_templates );

		/* Return the templates */
		return $templates;
	}

	/**
	 * Remove `wpemoji` button from TinyMCE
	 * @param  array $plugins TinyMCE plugins
	 * @return array            Modified plugins
	 */
	public function minimalio_remove_tinymce_emojis( $plugins ) {
		// If this is not an array (false/empty etc).
		if ( ! is_array( $plugins ) ) {
			return $plugins; // Don't modify it
		}

		// Remove `wpemoji` from array and return.
		return array_diff( $plugins, [ 'wpemoji' ] );
	}

	/**
	 * Remove jQuery migrate scripts from queue
	 * @param  Object $scripts Scripts queue object
	 * @return null
	 */
	public function minimalio_remove_jquery_migrate( &$scripts ) {
		// If this is not the admin area, remove the migrate files.
		if ( ! is_admin() ) {
			$scripts->remove( 'minimalio_jquery' );
			$scripts->add( 'minimalio_jquery', false, [ 'jquery-core' ], '3.7.1' );
		}
	}
}
