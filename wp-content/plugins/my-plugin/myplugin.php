<?php

/*
Plugin Name: News Post Type
Description: Плагин для создания нового типа записи "Новости".
Version: 1.0
Author: m1estere
*/

class MyPlugin
{
    public function __construct()
    {
        add_action('init', [$this, 'create_news_post_type']);
        add_action('add_meta_boxes', [$this, 'add_news_meta_boxes']);
        add_action('save_post', [$this, 'save_news_meta_box_data']);
    }

    public function create_news_post_type()
    {
        register_post_type('news',
            array(
                'labels' => array(
                    'name' => __('Новости'),
                    'singular_name' => __('Новость')
                ),
                'public' => true,
                'has_archive' => true,
                'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
                'menu_icon' => 'dashicons-megaphone',
                'rewrite' => array('slug' => 'news'),
            )
        );
    }

    public function add_news_meta_boxes()
    {
        add_meta_box('news_date_meta_box', 'Дата новости', [$this, 'news_date_meta_box_callback'], 'news', 'side', 'default');
    }

    public function news_date_meta_box_callback($post)
    {
        $value = get_post_meta($post->ID, '_news_date', true);
        echo '<label for="news_date_field">Дата:</label>';
        echo '<input type="date" id="news_date_field" name="news_date_field" value="' . esc_attr($value) . '" />';
    }

    public function save_news_meta_box_data($post_id)
    {
        if (array_key_exists('news_date_field', $_POST)) {
            update_post_meta($post_id, '_news_date', sanitize_text_field($_POST['news_date_field']));
        }
    }
}

new MyPlugin();
