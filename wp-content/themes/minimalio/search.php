<?php
/**
 * The template for displaying search results pages.
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
<div class="wrapper" id="search-wrapper">
	<div class="
	<?php
		echo esc_attr( $minimalio_container );
	?>
		" id="content" tabindex="-1">
		<div class="row">
			<!-- Do the left sidebar check and opens the primary div -->
			<?php
				get_template_part( 'templates/global-templates/checker/left-sidebar-check' );
			?>

			<main class="site-main" id="main"
				<?php
				if ( $minimalio_lightbox_bg ) {
					?>
					data-bgcolor='
					<?php
					echo esc_attr( $minimalio_lightbox_bg ); }
				?>
				'>

				<?php

				$minimalio_s         = get_search_query();
				$minimalio_args      = [
					's'              => $minimalio_s,
					'posts_per_page' => '-1',
				];
				$minimalio_the_query = new WP_Query( $minimalio_args );


				if ( $minimalio_the_query->have_posts() ) :
					?>

					<header class="page-header">

						<h1 class="pb-8 mb-0 break-words entry-title">
							<?php
							printf(
								/* translators: %s: query term */
								esc_html__( 'Search Results for: %s', 'minimalio' ),
								'<span>' . get_search_query() . '</span>'
							);
							?>
						</h1>

					</header><!-- .page-header -->

					<?php
					while ( $minimalio_the_query->have_posts() ) :
						$minimalio_the_query->the_post();
						?>

						<?php
						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						get_template_part( 'templates/loop-templates/content', 'search' );
						?>

						<?php
					endwhile;
					?>

					<?php
				else :
					?>

					<?php
						get_template_part( 'templates/loop-templates/content', 'none' );
					?>

					<?php
				endif;
				?>

			</main><!-- #main -->

			<!-- Do the right sidebar check -->
			<?php
				get_template_part( 'templates/global-templates/checker/right-sidebar-check' );
			?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #search-wrapper -->

<?php
	get_footer();
?>
