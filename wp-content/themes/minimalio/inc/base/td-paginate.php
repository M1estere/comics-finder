<?php
/**
 * Additional pagination handler for use outside of
 * standard archive pages
 */

defined( 'ABSPATH' ) || exit;

new Minimalio_Pagination;
#[AllowDynamicProperties]
class Minimalio_Pagination {


	/**
	 * Called on class initialisation
	 */
	function __construct() {
		// Add the pagination parameters
		add_filter( 'pre_get_posts', [ &$this, 'minimalio_addArgs' ], 10, 1 );
	}

	/**
	 * Add the correct pagination args to the query
	 * @param WP_Query $query Modified WP_Query object
	 */
	function minimalio_addArgs( $query ) {

		// Store the query for use by class
		$this->query = $query;

		// Only paginate if custom var present
		if ( ! $query->get( 'lwd_paginate' ) ) {
			return $query;
		}

		// Set the amount per page to our variable
		$query->set( 'posts_per_page', (int) $query->get( 'lwd_paginate' ) );

		// Get the current page request
		$query->set( 'paged', get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1 );

		// Force the count to be calculated
		$query->set( 'no_found_rows', false );

		return $query;
	}

	/**
	 * Get paginate_links to match query
	 * @param  array $minimalio_args Arguments to be merged into paginate_links
	 * @return string        Pagination links HTML
	 */
	function minimalio_customPagination( $minimalio_args = [] ) {
		// Upper bounds
		$big = 99999999;
		// Get total posts from query

		$post_count = $this->query->found_posts;

		// Setup new default arguments
		$defaults = [
			'base'    => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
			// URL format to use GET parameters
			'format'  => '?paged=%#%',
			// Current page
			'current' => $this->query->query_vars['paged'],
			// Total amount of pages
			'total'   => ceil( $post_count / $this->query->get( 'posts_per_page' ) ),
		];

		// Merge provided args with new defaults
		$minimalio_args = array_merge( $minimalio_args, $defaults );

		// Return the paginated links for the query
		return paginate_links( $minimalio_args );
	}
}

// Currently utilising a global - @TODO
global $Minimalio_Pagination;
$Minimalio_Pagination = new Minimalio_Pagination;

/**
 * Get the custom pagination links
 * @param  array $minimalio_args Arguments to be merged into paginate_links
 * @return string       Pagination links HTML
 */
function minimalio_td_pagination( $minimalio_args = [] ) {
	global $Minimalio_Pagination;
	return $Minimalio_Pagination->minimalio_customPagination( $minimalio_args );
}
