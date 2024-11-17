<?php
/**
 * Add WooCommerce support
 *
 * @package minimalio
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

add_action( 'after_setup_theme', 'minimalio_woocommerce_support' );
if ( ! function_exists( 'minimalio_woocommerce_support' ) ) {
	/**
	 * Declares WooCommerce theme support.
	 */
	function minimalio_woocommerce_support() {
		add_theme_support( 'woocommerce' );

		// Add New Woocommerce 3.0.0 Product Gallery support.
		add_theme_support( 'wc-product-gallery-minimalio' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-slider' );

		// hook in and customizer form fields.
		add_filter( 'woocommerce_form_field_args', 'minimalio_wc_form_field_args', 10, 3 );
	}
}



/**
 * First unhook the WooCommerce wrappers
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
//
// /**
// * Then hook in your own functions to display the wrappers your theme requires
// */
// add_action( 'woocommerce_before_main_content', 'minimalio_woocommerce_wrapper_start', 10 );
// add_action( 'woocommerce_after_main_content', 'minimalio_woocommerce_wrapper_end', 10 );
// if ( ! function_exists( 'minimalio_woocommerce_wrapper_start' ) ) {
// function minimalio_woocommerce_wrapper_start() {
// $minimalio_container = get_theme_mod( 'minimalio_settings_container_type' );
// echo '<div class="wrapper" id="woocommerce-wrapper">';
// echo '<div class="' . esc_attr( $minimalio_container ) . '" id="content" tabindex="-1">';
// echo '<div class="row">';
// get_template_part( 'templates/global-templates/checker/left-sidebar-check' );
// echo '<main class="site-main" id="main">';
// }
// }
// if ( ! function_exists( 'minimalio_woocommerce_wrapper_end' ) ) {
// function minimalio_woocommerce_wrapper_end() {
// echo '</main><!-- #main -->';
// get_template_part( 'templates/global-templates/checker/right-sidebar-check' );
// echo '</div><!-- .row -->';
// echo '</div><!-- Container end -->';
// echo '</div><!-- Wrapper end -->';
// }
// }


/**
 * Filter hook function monkey patching form classes
 * Author: Adriano Monecchi http://stackoverflow.com/a/36724593/307826
 *
 * @param string $minimalio_args Form attributes.
 * @param string $key Not in use.
 * @param null   $value Not in use.
 *
 * @return mixed
 */
if ( ! function_exists( 'minimalio_wc_form_field_args' ) ) {
	function minimalio_wc_form_field_args( $minimalio_args, $key, $value = null ) {
		// Start field type switch case.
		switch ( $minimalio_args['type'] ) {
			/* Targets all select input type elements, except the country and state select input types */
			case 'select':
				// Add a class to the field's html element wrapper - woocommerce
				// input types (fields) are often wrapped within a <p></p> tag.
				$minimalio_args['class'][] = 'form-group';
				// Add a class to the form input itself.
				$minimalio_args['input_class']       = [ 'form-control', 'input-lg' ];
				$minimalio_args['label_class']       = [ 'control-label' ];
				$minimalio_args['custom_attributes'] = [
					'data-plugin'      => 'select2',
					'data-allow-clear' => 'true',
					'aria-hidden'      => 'true',
					// Add custom data attributes to the form input itself.
				];
				break;
			// By default WooCommerce will populate a select with the country names - $minimalio_args
			// defined for this specific input type targets only the country select element.
			case 'country':
				$minimalio_args['class'][]     = 'form-group single-country';
				$minimalio_args['label_class'] = [ 'control-label' ];
				break;
			// By default WooCommerce will populate a select with state names - $minimalio_args defined
			// for this specific input type targets only the country select element.
			case 'state':
				// Add class to the field's html element wrapper.
				$minimalio_args['class'][] = 'form-group';
				// add class to the form input itself.
				$minimalio_args['input_class']       = [ '', 'input-lg' ];
				$minimalio_args['label_class']       = [ 'control-label' ];
				$minimalio_args['custom_attributes'] = [
					'data-plugin'      => 'select2',
					'data-allow-clear' => 'true',
					'aria-hidden'      => 'true',
				];
				break;
			case 'password':
			case 'text':
			case 'email':
			case 'tel':
			case 'number':
				$minimalio_args['class'][]     = 'form-group';
				$minimalio_args['input_class'] = [ 'form-control', 'input-lg' ];
				$minimalio_args['label_class'] = [ 'control-label' ];
				break;
			case 'textarea':
				$minimalio_args['input_class'] = [ 'form-control', 'input-lg' ];
				$minimalio_args['label_class'] = [ 'control-label' ];
				break;
			case 'checkbox':
				$minimalio_args['label_class'] = [ 'custom-control custom-checkbox' ];
				$minimalio_args['input_class'] = [ 'custom-control-input', 'input-lg' ];
				break;
			case 'radio':
				$minimalio_args['label_class'] = [ 'custom-control custom-radio' ];
				$minimalio_args['input_class'] = [ 'custom-control-input', 'input-lg' ];
				break;
			default:
				$minimalio_args['class'][]     = 'form-group';
				$minimalio_args['input_class'] = [ 'form-control', 'input-lg' ];
				$minimalio_args['label_class'] = [ 'control-label' ];
				break;
		} // end switch ($minimalio_args).
		return $minimalio_args;
	}
}

if ( ! is_admin() && ! function_exists( 'wc_review_ratings_enabled' ) ) {
	/**
	 * Check if reviews are enabled.
	 *
	 * Function introduced in WooCommerce 3.6.0., include it for backward compatibility.
	 *
	 * @return bool
	 */
	function wc_reviews_enabled() {
		return 'yes' === get_option( 'woocommerce_enable_reviews' );
	}

	/**
	 * Check if reviews ratings are enabled.
	 *
	 * Function introduced in WooCommerce 3.6.0., include it for backward compatibility.
	 *
	 * @return bool
	 */
	function wc_review_ratings_enabled() {
		return wc_reviews_enabled() && 'yes' === get_option( 'woocommerce_enable_review_rating' );
	}
}
