<?php
/**
 * Partial template for content in page.php
 *
 * @package minimalio
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">


	<?php if ( get_theme_mod( 'minimalio_settings_show_page_title' ) === 'yes' ) : ?>
		<header class="entry-header">

			<?php the_title( '<h1 class="pb-8 mb-0 break-words entry-title">', '</h1>' ); ?>

		</header><!-- .entry-header -->
	<?php endif; ?>

	<div class="entry-content">

		<?php the_content(); ?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

	</footer><!-- .entry-footer -->

</article>
