<?php

/*
Plugin Name: News Post Type
Description: Плагин для создания нового типа записи "Новости".
Version: 1.0
Author: m1estere
*/

if (!defined( 'ABSPATH' ) ) {
    exit;
}

class MyPlugin
{
    public function __construct()
    {
        add_action('init', [$this, 'create_news_post_type']);
        add_action('add_meta_boxes', [$this, 'add_news_meta_boxes']);
        add_action('save_post', [$this, 'save_news_meta_box_data']);

        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);

        add_action('wp_ajax_load_more_news', 'load_more_news');
        add_action('wp_ajax_nopriv_load_more_news', 'load_more_news');

        add_shortcode('display_news', [$this, 'display_news']);
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
        add_meta_box('news_autor_meta_box', 'Автор новости', [$this, 'news_author_meta_box_callback'], 'news', 'side', 'default');
    }

    public function enqueue_scripts()
    {
        wp_enqueue_style('custom-news-css', plugin_dir_url(__FILE__) . 'style.css', [], '1.0', 'all');
        wp_enqueue_script('custom-news-js', plugin_dir_url(__FILE__) . 'script.js', ['jquery'], null, true);
    }

    public function news_date_meta_box_callback($post)
    {
        $value = get_post_meta($post->ID, '_news_date', true);
        echo '<label for="news_date_field">Дата:</label>';
        echo '<input type="date" id="news_date_field" name="news_date_field" value="' . esc_attr($value) . '" />';
    }

    public function news_author_meta_box_callback($post)
    {
        $value = get_post_meta($post->ID, '_news_author', true);
        echo '<label for="news_author_field">Автор:</label>';
        echo '<input type="text" id="news_author_field" name="news_author_field" value="' . esc_attr($value) . '" />';
    }

    public function save_news_meta_box_data($post_id)
    {
        if (array_key_exists('news_date_field', $_POST)) {
            update_post_meta($post_id, '_news_date', sanitize_text_field($_POST['news_date_field']));
        }

        if (array_key_exists('news_author_field', $_POST)) {
            update_post_meta($post_id, '_news_author', sanitize_text_field($_POST['news_author_field']));
        }
    }

    public function load_more_news()
    {
        if( !isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'load_more_news_nonce') ) {
            die('Permission Denied');
        }
    
        $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
    
        $args = array(
            'post_type' => 'news',
            'posts_per_page' => 3, 
            'orderby' => 'date',
            'order' => 'DESC',
            'paged' => $paged,
        );
    
        $query = new WP_Query($args);
    
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $news_date = get_post_meta(get_the_ID(), '_news_date', true);
                $title = get_the_title();
                $excerpt = get_the_excerpt();
    
                ob_start();
                include locate_template('template-parts/news-item.php');
                echo ob_get_clean();
            }
        } else {
            echo 'no_more_posts';
        }
    
        wp_die();
    }

    public function display_news($atts)
    {
        $args = array(
            'post_type' => 'news',
            'posts_per_page' => -1,
            'orderby' => 'date',
            'order' => 'DESC'
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            $output = '<div class="news-carousel-container">';
            $output .= '<div class="news-carousel">';

            $output .= '<div class="news-row">';
            $count = 0;
            while ($query->have_posts()) {
                $query->the_post();
                $news_date = get_post_meta(get_the_ID(), '_news_date', true);

                $output .= $this->get_news_template(get_the_ID(), get_the_title(), $news_date, get_the_excerpt());

                $count++;
                if ($count % 3 == 0) {
                    $output .= '</div><div class="news-row">';
                }
            }

            $output .= '</div>';

            wp_reset_postdata();

            $output .= '</div>';
            $output .= '<button class="prev">&#10094;</button>';
            $output .= '<button class="next">&#10095;</button>';
            $output .= '</div>';
        } else {
            $output = '<p>Новости не найдены.</p>';
        }

        return $output;
    }

    public function get_news_template($post_id, $title, $date, $excerpt)
    {
        ob_start();

        include plugin_dir_path(__FILE__) . 'templates/news-item.php';

        return ob_get_clean();
    }
}

new MyPlugin();
