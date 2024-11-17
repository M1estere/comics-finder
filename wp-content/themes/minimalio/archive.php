<?php
/**
 * The archive template file.
 *
 * This template is used for category, tag, and author archives.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package minimalio
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

if ( get_theme_mod( 'minimalio_settings_container_type' ) ) {
	$minimalio_container = get_theme_mod( 'minimalio_settings_container_type' );
} else {
	$minimalio_container = 'container';
}

$minimalio_card      = get_theme_mod( 'minimalio_settings_blog_post_card' );
$minimalio_post_card = minimalio_post_postcard( $minimalio_card );

if ( get_theme_mod( 'minimalio_settings_blog_pagination' ) ) {
	$minimalio_display = get_theme_mod( 'minimalio_settings_blog_pagination' );
} else {
	$minimalio_display = 'no';
}

if ( $minimalio_display === 'load' || $minimalio_display === 'load_scroll' ) {
	$minimalio_nr_post = get_theme_mod( 'minimalio_settings_blog_posts_per_page' );
} else {
	$minimalio_nr_post = '-1';
}


if ( is_tag() ) {
	// This is a tag archive page
	$minimalio_tag            = get_queried_object();
	$minimalio_tag_id         = $minimalio_tag->term_id;
	$minimalio_taxonomy       = 'tag';
	$minimalio_taxonomy_value = $minimalio_tag_id;
} elseif ( is_author() ) {
	// This is an author archive page
	$minimalio_author         = get_queried_object();
	$minimalio_author_id      = $minimalio_author->ID;
	$minimalio_taxonomy       = 'author';
	$minimalio_taxonomy_value = $minimalio_author_id;
} elseif ( is_date() ) {
	// This is a date archive
	$minimalio_year     = get_query_var( 'year' );
	$minimalio_monthnum = get_query_var( 'monthnum' );
	// $day = get_query_var( 'day' );
} else {
	// This is a category archive page or an unfiltered list
	$minimalio_category       = get_queried_object();
	$minimalio_category_id    = $minimalio_category->term_id;
	$minimalio_taxonomy       = 'category';
	$minimalio_taxonomy_value = $minimalio_category_id;
}
// NY Customize the lightbox
if ( get_theme_mod( 'minimalio_gallery_bg_color_settings' ) ) {
	$minimalio_lightbox_bg = get_theme_mod( 'minimalio_gallery_bg_color_settings' );
} else {
	$minimalio_lightbox_bg = '#cecece'; // default lightbox background color
}
// End Customize the lightbox
?>

<div class="wrapper" id="archive-wrapper">

	<div class="<?php echo esc_attr( $minimalio_container ); ?>" id="content" tabindex="-1">

		<div class="row">
			<!-- Do the left sidebar check -->
			<?php get_template_part( 'templates/global-templates/checker/left-sidebar-check' ); ?>

			<main class="site-main" id="main"
			<?php
			if ( $minimalio_lightbox_bg ) {
				?>
				data-bgcolor='<?php echo esc_attr( $minimalio_lightbox_bg );} ?>'>

				<?php if ( have_posts() ) : ?>

					<?php
					// use paginated list for blog taxonomy archives (category. tag, author)
					if ( is_category() || is_tag() || is_author() ) :

						minimalio_get_part( 'templates/blocks/posts/posts',
							[
								'nr_post'           => $minimalio_nr_post,
								'nr_columns'        => get_theme_mod( 'minimalio_settings_blog_columns', 4 ),
								'pagination_option' => 'pagination',
								'all_label'         => get_theme_mod( 'minimalio_settings_blog_all' ),
								'post_type'         => 'post',
								'post_card'         => $minimalio_post_card,
								'author_type'       => 'author-1',
								'categories'        => get_categories( [ 'hide_empty' => true ] ),
								$minimalio_taxonomy => $minimalio_taxonomy_value,
								'enable_masonry'    => get_theme_mod( 'minimalio_settings_blog_type' ),
								'filter'            => 'no',
							]
						);

					elseif ( is_date() ) :
						minimalio_get_part( 'templates/blocks/posts/posts',
							[
								'nr_post'           => $minimalio_nr_post,
								'nr_columns'        => get_theme_mod( 'minimalio_settings_blog_columns', 4 ),
								'pagination_option' => 'pagination',
								'all_label'         => get_theme_mod( 'minimalio_settings_blog_all' ),
								'post_type'         => 'post',
								'post_card'         => $minimalio_post_card,
								'author_type'       => 'author-1',
								'categories'        => get_categories( [ 'hide_empty' => true ] ),
								'date_query'        => [
									[
										'year'     => $minimalio_year,
										'monthnum' => $minimalio_monthnum,
										// 'day' => $day,
									],
								],
								'enable_masonry'    => get_theme_mod( 'minimalio_settings_blog_type' ),
								'filter'            => 'no',
							]
						);

					else :

						minimalio_get_part( 'templates/blocks/posts-ajax/posts-ajax',
							[
								'nr_post'           => get_theme_mod( 'minimalio_settings_blog_posts_per_page' ),
								'nr_columns'        => get_theme_mod( 'minimalio_settings_blog_columns' ),
								'pagination_option' => get_theme_mod( 'minimalio_settings_blog_pagination' ),
								'all_label'         => get_theme_mod( 'minimalio_settings_blog_all' ),
								'post_type'         => 'post',
								'post_card'         => $minimalio_card,
								'author_type'       => 'author-1',
								'categories'        => get_categories( [ 'hide_empty' => true ] ),
								'enable_masonry'    => get_theme_mod( 'minimalio_settings_blog_type' ),
								'filter'            => get_theme_mod( 'minimalio_settings_archive_template_filter_enable' ),
								$minimalio_taxonomy => $minimalio_taxonomy_value,
							]
						);
					endif;
					?>

				<?php endif; ?>

			</main><!-- #main -->

			<!-- The pagination component -->
			<?php // minimalio_pagination(); ?>

			<!-- Do the right sidebar check -->
			<?php get_template_part( 'templates/global-templates/checker/right-sidebar-check' ); ?>

		</div> <!-- .row -->

	</div><!-- #content -->

</div><!-- #archive-wrapper -->

<?php get_footer(); ?>
