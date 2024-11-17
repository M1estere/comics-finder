<?php

/**
 * Custom theme banner
 *
 * @access      public
 * @since       1.0
 * @return      void
 */

defined( 'ABSPATH' ) || exit;


function minimalio_admin_banner() {
	global $pagenow;

	include_once ABSPATH . 'wp-admin/includes/plugin.php';
		$user_id = get_current_user_id();
	$admin_pages = [ 'index.php', 'themes.php', 'plugins.php' ];
	if ( in_array( $pagenow, $admin_pages ) && ! get_user_meta( $user_id, 'minimalio_theme_notice_dismissed' ) && ! is_plugin_active( 'minimalio-portfolio/minimalio-portfolio.php' ) ) {
		$templateDirectory = get_template_directory_uri();
			print '<div class="notice notice-info minimalio-notice">
				<div class="minimalio-row">
						
				<a class="notice-dismiss" href="?my-theme-dismissed"></a>
							<div class="minimalio-col">
								<div class="notice-content">
									<div class="minimalio-flex">
										<div class="minimalio-col minimalio-col-left">
											<h1>Welcome to Minimalio!</h1>
										<h2>Extra features for Portfolio website:</h2>
											<ul>
												<li>Extra customizer options</li>
												<li>Portfolio custom post type</li>
												<li>Video and gallery Gutenberg blocks</li>
											</ul>
											
												<a href="https://minimalio.org/product/minimalio-plugin/"  target="_blank" >
												<button class="button button-primary">Premium Features ($20)</button>
												</a>
											<div style="height:1rem"></div>
											<div class="links">
											<p>
												<a href="https://minimalio.org/" target="_blank" class="">
												Websites with Minimalio
												</a>	</p>
											<p>	<a href="https://minimalio.org/demos/" target="_blank" class="">
												Demos to import
												</a>	</p>
											<p>	<a href="https://minimalio.org/blog-instructions/" target="_blank" class="">
												Tutorials / Documentation
												</a>
											</p>
											</div>
										</div>
										<div class="minimalio-col minimalio-col-right">

											<div class="image-container">
												<img src="' . get_template_directory_uri() . '/screenshot.png" style="" alt="">
											</div>

										</div>
									</div>
								</div>
							</div>
						</div>

					</div>';
	}
}
add_action( 'admin_notices', 'minimalio_admin_banner' );

function minimalio_theme_notice_dismissed() {
	$user_id = get_current_user_id();
	if ( isset( $_GET['my-theme-dismissed'] ) ) {
		add_user_meta( $user_id, 'minimalio_theme_notice_dismissed', 'true', true );
	}
}
add_action( 'admin_init', 'minimalio_theme_notice_dismissed' );


function minimalio_admin_theme_style() {
	wp_enqueue_style( 'minimalio-admin-theme', get_theme_file_uri( './assets/dist/css/minimalio-notice.css' ) );
}
add_action( 'admin_enqueue_scripts', 'minimalio_admin_theme_style' );
add_action( 'login_enqueue_scripts', 'minimalio_admin_theme_style' );
