<?php
    $file_info = pathinfo($comic->url);
    $file_name_without_extension = $file_info['filename'];
?>

<div class="comic-item">
    <div class="comic-thumbnail">
        <a href="<?php echo esc_url($comic->url); ?>" target="_blank">
            <img src="<?php echo esc_url($comic->thumbnail_url); ?>" alt="<?php echo esc_html($comic->title); ?>" />
        </a>
    </div>

    <div class="comic-info">
        <h3 class="comic-title">
            <?php echo esc_html($file_name_without_extension); ?>
        </h3>
        
        <p class="comic-date">Дата загрузки: <?php echo esc_html($comic->uploaded_at); ?> | <a href="<?php echo esc_url($comic->url); ?>" class="comic-download-link" target="_blank">Скачать</a></p>
    </div>
</div>