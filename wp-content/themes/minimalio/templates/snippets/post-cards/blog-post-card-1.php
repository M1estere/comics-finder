<?php defined( 'ABSPATH' ) || exit; ?>

<div class="relative w-full post-card blog-post-card-1" data-card-id="<?php echo esc_attr( $id ); ?>">
	<?php if ( $link_url ) : ?>
			<a class="absolute top-0 bottom-0 left-0 right-0 z-20 no-underline opacity-0 post-card__link" href="<?php echo esc_url( $link_url ); ?>">
			<?php echo esc_html( $card_title ); ?>
		</a>
	<?php endif; ?>

	<?php if ( $card_image ) : ?>
		<figure class="relative w-full h-auto post-card__image">
			<?php echo wp_get_attachment_image( $card_image, [ 600, 400, 1 ] ); ?>

			<div
				class="absolute top-0 bottom-0 left-0 right-0 z-10 overflow-auto transition-opacity duration-300 bg-black opacity-0 post-card__overlay">
			</div>
		</figure>
	<?php endif; ?>

	<div class="overflow-auto post-card__body">

		<?php if ( $card_title ) : ?>
			<h1 class="py-4 m-0 break-words post-card__heading">
				<?php echo esc_html( $card_title ); ?>
			</h1>
		<?php endif; ?>

		<?php if ( $card_category ) : ?>
			<div class="pb-4 post-card__categories">
			<?php
			$minimalio_i = 0;
			foreach ( $card_category as $minimalio_category ) :
				++$minimalio_i;
				?>
							<?php
							echo esc_html( $minimalio_category->name );
							if ( $minimalio_i < count( $card_category ) ) {
								echo ', ';
							}
							?>
			<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<div class="pb-4 post-card__date">
			<?php
			$minimalio_post_date = get_the_date();
			echo $minimalio_post_date;
			?>
		</div>

	</div>
</div>
