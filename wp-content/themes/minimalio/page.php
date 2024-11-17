<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
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

// NY Customize the lightbox
if ( get_theme_mod( 'minimalio_gallery_bg_color_settings' ) ) {
	$minimalio_lightbox_bg = get_theme_mod( 'minimalio_gallery_bg_color_settings' );
} else {
	$minimalio_lightbox_bg = '#cecece'; // default lightbox background color
}
// End Customize the lightbox
?>

<div class="wrapper" id="page-wrapper">

	<div class="<?php echo esc_attr( $minimalio_container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check -->
			<?php get_template_part( 'templates/global-templates/checker/left-sidebar-check' ); ?>

			<main class="site-main" id="main"
			<?php
			if ( $minimalio_lightbox_bg ) {
				?>
				data-bgcolor='<?php echo esc_attr( $minimalio_lightbox_bg );} ?>'>

				<?php
				while ( have_posts() ) :
					the_post();
					?>

					<?php get_template_part( 'templates/loop-templates/content', 'page' ); ?>

					<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					?>

				<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->

			<!-- Do the right sidebar check -->
			<?php get_template_part( 'templates/global-templates/checker/right-sidebar-check' ); ?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #page-wrapper -->

<?php get_footer(); ?>
