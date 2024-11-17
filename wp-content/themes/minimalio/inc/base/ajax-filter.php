<?php
/**
 * Filter ajax
 *
 * @package minimalio
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

function minimalio_filter_ajax() {
	$minimalio_category = esc_attr( $_POST['category'] );
	$card               = esc_attr( $_POST['card'] );
	$grid               = esc_attr( $_POST['grid'] );
	$author             = esc_attr( $_POST['author'] );
	$nr_columns         = esc_attr( $_POST['nr_columns'] );
	$minimalio_nr_posts = esc_attr( $_POST['nr_posts'] );
	$post_type          = esc_attr( $_POST['post_type'] );

	$minimalio_button_label = get_theme_mod( 'minimalio_settings_post_cart_button_label' ) ?
	get_theme_mod( 'minimalio_settings_post_cart_button_label' ) : 'Read me';

	if ( $post_type === 'portfolio' ) {
		$minimalio_display = get_theme_mod( 'minimalio_settings_portfolio_pagination' );
		$enable_masonry    = get_theme_mod( 'minimalio_settings_portfolio_type', 'grid' );
	} else {
		$minimalio_display = get_theme_mod( 'minimalio_settings_blog_pagination' );
		$enable_masonry    = get_theme_mod( 'minimalio_settings_blog_type', 'grid' );
	}

	if ( $minimalio_category !== 'all' ) {
		if ( isset( $minimalio_category ) ) {
			$taxonomy = [
				[
					'taxonomy' => $post_type === 'portfolio' ? 'portfolio-categories' : 'category',
					'field'    => 'slug',
					'terms'    => $minimalio_category,
				],
			];
		}
		$term               = get_term_by( 'name', $minimalio_category, $post_type === 'portfolio' ? 'portfolio-categories' : 'category' );
		$count_posts        = $term->count;
		$minimalio_category = '';
	} else {
		$taxonomy    = '';
		$count_posts = wp_count_posts( $post_type )->publish;
	}

	$minimalio_args = [
		'post_type'      => $post_type,
		'post_status'    => 'publish',
		'posts_per_page' => $minimalio_nr_posts,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'tax_query'      => $taxonomy,
	];

	$minimalio_the_query = new WP_Query( $minimalio_args );

	if ( $minimalio_the_query->have_posts() ) : ?>
		<div class="grid grid-cols-1 sm:grid-cols-2 posts__row pswp__wrap <?php echo 'lg:grid-cols-' . $nr_columns . ''; ?>">
			<?php
			while ( $minimalio_the_query->have_posts() ) :
				$minimalio_the_query->the_post();
				global $post;
				?>

				<div class="post-item
				<?php
				if ( $enable_masonry === 'masonry' ) :
					?>
					post-item__masonry grid-item<?php endif; ?>">

					<?php
					minimalio_get_part(
						'templates/snippets/post-cards/' . $card,
						[
							'id'                     => $post->ID,
							'author_type'            => $author_type,
							'author'                 => $post->post_author,
							'link_url'               => get_the_permalink( $post->ID ),
							'card_image'             => get_post_thumbnail_id( $post->ID ),
							'image_size'             => [ 400, 500, 1 ],
							'heading_type'           => 'h5',
							'card_title'             => get_the_title( $post->ID ),
							'card_excerpt'           => get_the_excerpt( $post->ID ),
							'card_content'           => get_the_content( $post->ID ),
							'card_category'          => $post_type === 'portfolio' ? get_the_terms( $post->ID, 'portfolio-categories' ) : get_the_category( $post->ID ),
							'card_tag'               => $post_type === 'portfolio' ? get_the_terms( $post->ID, 'portfolio-tags' ) : wp_get_post_tags( $post->ID ),
							'minimalio_button_label' => $minimalio_button_label,
							'hover_image'            => get_post_meta( $post->ID, '_hover_image_id', true ),
							'hover_video'            => get_post_meta( $post->ID, '_hover_video_id', true ),
							'vimeo_id'               => get_post_meta( $post->ID, '_vimeo_id', true ),
						]
					);
					?>
				</div>


			<?php endwhile; ?>

		</div>

		<?php if ( $minimalio_display !== 'no' && $minimalio_display !== 'load_scroll' ) : ?>

			<div class="w-full posts__button">
				<a class="wp-block-button__link wp-element-button posts__button-link
				<?php
				if ( get_theme_mod( 'minimalio_settings_portfolio_pagination' ) === 'load_scroll' ) {
					echo 'posts__button--load';
				}
				?>
				" id="load-more-ajax">
					<?php _e( 'Load More', 'minimalio' ); ?>
				</a>
			</div>
		<?php endif; ?>

		<?php
	endif;

	wp_reset_postdata();
	die();
}
add_action( 'wp_ajax_filter', 'minimalio_filter_ajax' );
add_action( 'wp_ajax_nopriv_filter', 'minimalio_filter_ajax' );

// Load more ajax
function minimalio_load_ajax() {
	$minimalio_category = esc_attr( $_POST['category'] );
	$card               = esc_attr( $_POST['card'] );
	$grid               = esc_attr( $_POST['grid'] );
	$author             = esc_attr( $_POST['author'] );
	$nr_columns         = esc_attr( $_POST['nr_columns'] );
	$minimalio_nr_posts = esc_attr( $_POST['nr_posts'] );
	$exclude            = esc_attr( $_POST['exclude'] );
	$post_type          = esc_attr( $_POST['post_type'] );

	$minimalio_button_label = get_theme_mod( 'minimalio_settings_post_cart_button_label' ) ?
		get_theme_mod( 'minimalio_settings_post_cart_button_label' ) : 'Read me';

	if ( $post_type === 'portfolio' ) {
		$enable_masonry = get_theme_mod( 'minimalio_settings_portfolio_type', 'grid' );
	} else {
		$enable_masonry = get_theme_mod( 'minimalio_settings_blog_type', 'grid' );
	}

	$url  = $_SERVER['HTTP_REFERER'];
	$path = parse_url( $url, PHP_URL_PATH );
	// Get the content after "/category/"
	$category_content = substr( $path, strpos( $path, '/category/' ) + strlen( '/category/' ) );

	// Remove the trailing slash
	$category_content = rtrim( $category_content, '/' );

	if ( $minimalio_category !== 'all' ) {
		if ( $post_type === 'portfolio' ) {
			if ( isset( $minimalio_category ) ) {
				$taxonomy = [
					[
						'taxonomy' => 'portfolio-categories',
						'field'    => 'slug',
						'terms'    => $minimalio_category,
					],
				];
			}
			$term              = get_term_by( 'name', $minimalio_category, 'portfolio-categories' );
			$category_selected = '';
		} else {
			$category_selected = $minimalio_category ? $minimalio_category : $category_content;
		}
	} else {
		$taxonomy          = '';
		$category_selected = '';
	}

	$minimalio_args = [
		'post_type'      => $post_type,
		'post_status'    => 'publish',
		'posts_per_page' => $minimalio_nr_posts,
		'orderby'        => 'date',
		'post__not_in'   => explode( ', ', $exclude ),
		'order'          => 'DESC',
		'category_name'  => $category_selected,
		'tax_query'      => $taxonomy,
	];

	$minimalio_the_query = new WP_Query( $minimalio_args );

	if ( $minimalio_the_query->have_posts() ) :
		?>
		<?php
		while ( $minimalio_the_query->have_posts() ) :
			$minimalio_the_query->the_post();
			global $post;
			?>

			<div class="post-item
			<?php
			if ( $enable_masonry === 'masonry' ) :
				?>
				post-item__masonry grid-item<?php endif; ?>">

				<?php
				minimalio_get_part(
					'templates/snippets/post-cards/' . $card,
					[
						'id'                     => $post->ID,
						'show_author'            => 'true',
						'author_type'            => $author,
						'author'                 => $post->post_author,
						'link_url'               => get_the_permalink( $post->ID ),
						'card_image'             => get_post_thumbnail_id( $post->ID ),
						'image_size'             => [ 400, 500, 1 ],
						'heading_type'           => 'h5',
						'card_title'             => get_the_title( $post->ID ),
						'card_excerpt'           => get_the_excerpt( $post->ID ),
						'card_category'          => $post_type === 'portfolio' ? get_the_terms( $post->ID, 'portfolio-categories' ) : get_the_category( $post->ID ),
						'card_tag'               => $post_type === 'portfolio' ? get_the_terms( $post->ID, 'portfolio-tag' ) : wp_get_post_tags( $post->ID ),
						'card_content'           => get_the_content( $post->ID ),
						'button_classes'         => 'btn-primary btn-sm',
						'minimalio_button_label' => $minimalio_button_label,
						'vimeo_id'               => get_post_meta( $post->ID, '_vimeo_id', true ),
					]
				);
				?>
			</div>

		<?php endwhile; ?>

		<?php
	endif;

	wp_reset_postdata();
	die();
}
add_action( 'wp_ajax_load', 'minimalio_load_ajax' );
add_action( 'wp_ajax_nopriv_load', 'minimalio_load_ajax' );

/* Preget posts for pagination */
function minimalio_pagination_pre_get_posts( $q ) {
	if (
		! is_admin()
		&& $q->is_main_query()
	) {
		$q->set( 'posts_per_page', 1 );
		$q->set( 'orderby', 'modified' );
	}
}
add_action( 'pre_get_posts', 'minimalio_pagination_pre_get_posts' );
