<a href="<?php the_permalink(); ?>" target="_blank">
    <div class="news-item">
        <?php 
            if (has_post_thumbnail()) {
                $thumbnail = get_the_post_thumbnail(get_the_ID(), 'full');
                echo '<div class="news-thumbnail">' . $thumbnail . '</div>';
            }
        ?>
        <h2><?php echo esc_html($title); ?></h2>

        <?php if ($date): ?>
            <p><strong>Дата:</strong> <?php echo esc_html($date); ?></p>
        <?php endif; ?>

        <p class="news-desc"><?php echo esc_html($excerpt); ?></p>
    </div>
</a>