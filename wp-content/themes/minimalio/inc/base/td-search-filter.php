<?php
/**
 * Search and filtering controls for post queries.
 * standard archive pages
 *
 * @author Tom Lewis <support@lightboxdigital.co.uk>
 * @since  1.0
 */

defined( 'ABSPATH' ) || exit;
	#[AllowDynamicProperties]
class Minimalio_SearchFilter {


	/**
	 * Called on class initialisation
	 */
	function __construct( $default_args ) {
		// Ensure we have GET variables
		if ( ! isset( $_GET ) ) {
			return false;
		}

		// remove_filter( 'posts_request', 'relevanssi_prevent_default_request' );
		// remove_filter( 'the_posts', 'relevanssi_query', 99 );

		// Empty array, initialised for our sort/filter args
		$this->default_arguments = [];
		$this->default_arguments = $default_args;
		$filter_args             = $this->default_arguments;

		// Store get variables in input array
		$this->input = $_GET;

		// Loop over all the get variables
		foreach ( $this->input as $key => $value ) {
			// Check if the key matches a filter function within class
			if ( method_exists( $this, 'filter_' . $key ) && $value ) {
				// Select the correct function to call within this file
				$func = 'filter_' . $key;

				// Get the new argument response from the filter function
				$new_args = $this->$func( $value );

				// Merge the arguments into our defaults
				$filter_args = array_merge_recursive( $filter_args, $new_args );
			}
		}

		// If tax query then add relationship
		if ( isset( $filter_args['tax_query'] ) ) {
			$filter_args['tax_query']['relationship'] = 'AND';
		}

		// Ordering
		$orderargs = $this->minimalio_order_by();

		// Merge ordering arguments into our defaults
		$filter_args = array_merge_recursive( $filter_args, $orderargs );

		// Finally check that all the arguments necessary are present
		$minimalio_args = $this->minimalio_build_default_args( $filter_args );

		// Run the query
		$this->minimalio_run_query( $minimalio_args );

		// Return the entire object for use
		return $this;
	}

	/**
	 * Load our initial arguments, defaults needed to run a query.
	 * @return array $base_args An array of default arguments for WP_Query
	 */
	public function minimalio_base_arguments() {

		// Return these arguments (on a new line for clarity)
		return $this->default_arguments;
	}

	/**
	 * Merge the supplied arguments with our defaults
	 * @param  array $arguments An array of additional arguments
	 * @return array An array of new arguments merged with the defaults
	 */
	public function minimalio_build_default_args( $arguments = null ) {

		// Arguments array to house new arguments
		$add_arguments = [];

		// If no arguments have been supplied, simply return the original
		// default arguments
		if ( ! isset( $arguments ) || ! $arguments ) {
			return $this->minimalio_base_arguments();
		}

		foreach ( $arguments as $argument => $param ) {
			$add_arguments[ $argument ] = $param;
		}

		// Return the newly compiled array of arguments
		return $add_arguments;
	}

	/**
	 * Run our query!
	 * @param  array $query_args An array of arguments to query against
	 * @return null
	 */
	public function minimalio_run_query( $query_args ) {

		// Ensure we have access to the global query and post objects
		global $wp_query, $post;

		// And query the DB with our arguments
		$wp_query = new WP_Query( $query_args );

		// Store our posts returned into an accessible endpoint
		$this->results = $wp_query->posts;

		// Paged value
		$this->paged = max( 1, $wp_query->get( 'paged' ) );

		// The number of posts we wish to show per page
		$this->per_page = $wp_query->get( 'posts_per_page' );

		// This is our total count of posts found
		$this->total = $wp_query->found_posts;

		// The first page of results
		$this->first = ( $this->per_page * $this->paged ) - $this->per_page + 1;

		// The last page of results (both of these combine for useses such as page X of Y )
		$this->last = min( $this->total, $wp_query->get( 'posts_per_page' ) * $this->paged );

		// Return to ensure we don't get stuck here
		return;
	}

	/**
	 * String search filter
	 * @param  string $keywords A string of keywords to filter by
	 * @return array An array of the built string search query arguments
	 */
	public function minimalio_filter_keywords( $keywords ) {

		if ( ! $keywords ) {
			return [];
		}

		return [ 's' => esc_sql( $keywords ) ];
	}



	/**
	 * Post Category filter
	 * @param  array $categories An array of category slugs to filter by
	 * @return array An array of the built tax query arguments
	 */
	public function filter_category( $categories ) {

		// Ensure we're returning with an array, to avoid issues later on
		if ( ! is_string( $categories ) ) {
			return [];
		}

		// Call our build tax query function, passing through the terms and which field
		// to filter by
		return $this->minimalio_build_tax_query( $this->default_arguments['taxonomy_name'], 'slug', [ $categories ] );
	}





	/**
	 * Build taxonomy query arguments for the main WP_Query
	 * @param  string $taxonomy the taxonomy name we wish to query against
	 * @param  string $field The field we are checking against (e.g. slug, id, name)
	 * @param  array  $terms An array of terms to check posts are assigned to
	 * @return array An array of the built tax query arguments
	 */
	public function minimalio_build_tax_query( $taxonomy, $field, $terms ) {

		// Return the WP Query taxonomy arguments
		return [
			'tax_query' => [
				[
					'taxonomy' => $taxonomy,
					'field'    => $field,
					'terms'    => $terms,
				],
			],
		];
	}

	/**
	 * Orderby options for our search
	 * @return array An array of the order and orderby arguments
	 */
	public function minimalio_order_by() {

		// If the sort has been set, proceed
		if ( isset( $this->input['sort'] ) ) {

			// If the sort order is ascending, return the arguments
			if ( 'asc' === $this->input['sort'] ) {
				return [
					'orderby' => 'title',
					'order'   => 'ASC',
				];
			}

			// If the user has selected descending, return the arguments
			if ( 'desc' === $this->input['sort'] ) {
				return [
					'orderby' => 'title',
					'order'   => 'DESC',
				];
			}
		}

		return [];
	}
}
