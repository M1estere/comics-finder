<?php
/**
 * Plugin Name: Comic Uploader Plugin
 * Description: Плагин для загрузки комиксов на сайт.
 * Version: 1.0
 * Author: m1estere
 */

if (!defined('ABSPATH')) {
    exit;
}

class ComicUploaderPlugin
{
    private $uploads_table;
    private $approved_table;

    public function __construct()
    {
        global $wpdb;
        $this->uploads_table = $wpdb->prefix . 'comic_uploads';
        $this->approved_table = $wpdb->prefix . 'comic_approved';

        register_activation_hook(__FILE__, [$this, 'install']);
        register_deactivation_hook(__FILE__, [$this, 'uninstall']);

        add_action('admin_menu', [$this, 'register_admin_menu']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);

        add_action('wp_ajax_comic_uploader', [$this, 'handle_upload']);
        add_action('wp_ajax_nopriv_comic_uploader', [$this, 'handle_upload']);

        add_action('wp_ajax_approve_comic', [$this, 'approve_comic']);
        add_action('wp_ajax_nopriv_approve_comic', [$this, 'approve_comic']);

        add_action('wp_ajax_delete_comic', [$this, 'delete_comic']);

        add_action('wp_ajax_load_comics_list', [$this, 'load_comics_list']);
        add_action('wp_ajax_nopriv_load_comics_list', [$this, 'load_comics_list']);

        add_shortcode('comic_uploader_form', [$this, 'render_upload_form']);
        // add_shortcode('display_comics', [$this, 'display_comics_shortcode']);
    }

    public function install()
    {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE {$this->uploads_table} (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            title text NOT NULL,
            url text NOT NULL,
            thumbnail_url text DEFAULT '' NOT NULL,
            uploaded_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        $sql_approved = "CREATE TABLE {$this->approved_table} (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            title text NOT NULL,
            url text NOT NULL,
            thumbnail_url text DEFAULT '' NOT NULL,
            uploaded_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        dbDelta($sql_approved);
    }

    public function uninstall()
    {
        global $wpdb;

        $uploads_table = $this->uploads_table;
        $wpdb->query("DROP TABLE IF EXISTS $uploads_table");

        $approved_table = $this->approved_table;
        $wpdb->query("DROP TABLE IF EXISTS $approved_table");
    }

    public function register_admin_menu()
    {
        add_menu_page(
            'Comic Uploader',
            'Комиксы',
            'manage_options',
            'comic-uploader',
            [$this, 'admin_page'],
            'dashicons-upload',
            20
        );

        add_submenu_page(
            'comic-uploader',
            'Загруженные комиксы',
            'Загруженные комиксы',
            'manage_options',
            'comic-uploader',
            [$this, 'admin_page']
        );
        
        add_submenu_page(
            'comic-uploader',
            'Одобренные комиксы',
            'Одобренные',
            'manage_options',
            'comic-approved',
            [$this, 'approved_comics_page']
        );
    }

    public function admin_page()
    {
        global $wpdb;
        $comics = $wpdb->get_results("SELECT * FROM {$this->uploads_table} ORDER BY id DESC");

        echo '<div class="wrap">';
        echo '<h1>Загруженные комиксы</h1>';
        echo '<table class="widefat fixed">';
        echo '<thead><tr><th>ID</th><th>Название</th><th>Дата загрузки</th><th>URL</th><th>Превью</th><th>Действия</th></tr></thead>';
        echo '<tbody>';
        foreach ($comics as $comic) {
            echo "
                <tr>
                    <td>{$comic->id}</td>
                    <td>{$comic->title}</td>
                    <td>{$comic->uploaded_at}</td>
                    <td><a href='{$comic->url}' target='_blank'>Скачать</a></td>
                    <td><a href='{$comic->thumbnail_url}' target='_blank'>Смотреть</a></td>
                    <td>
                        <button class='approve-comic' data-comic-id='{$comic->id}'>Одобрить</button>
                        <button class='delete-comic' data-comic-id='{$comic->id}'>Удалить</button>
                    </td>
                </tr>
            ";
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    }

    public function approved_comics_page()
    {
        global $wpdb;
        $comics = $wpdb->get_results("SELECT * FROM {$this->approved_table} ORDER BY id DESC");

        echo '<div class="wrap">';
        echo '<h1>Одобренные комиксы</h1>';
        echo '<table class="widefat fixed">';
        echo '<thead><tr><th>ID</th><th>Название</th><th>Дата загрузки</th><th>URL</th><th>Превью</th><th>Действия</th></tr></thead>';
        echo '<tbody>';
        foreach ($comics as $comic) {
            echo "
                <tr>
                    <td>{$comic->id}</td>
                    <td>{$comic->title}</td>
                    <td>{$comic->uploaded_at}</td>
                    <td><a href='{$comic->url}' target='_blank'>Скачать</a></td>
                    <td><a href='{$comic->thumbnail_url}' target='_blank'>Смотреть</a></td>
                    <td><button class='delete-comic' data-comic-id='{$comic->id}'>Удалить</button></td>
                </tr>
            ";
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    }

    public function enqueue_scripts()
    {
        wp_enqueue_style('comic-uploader-css', plugin_dir_url(__FILE__) . 'comic-uploader.css', [], '1.0', 'all');
        wp_enqueue_script('comic-uploader-js', plugin_dir_url(__FILE__) . 'comic-uploader.js', ['jquery'], null, true);
        wp_localize_script('comic-uploader-js', 'comicUploader', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('comic_uploader_nonce'),
        ]);
    }

    public function handle_upload()
    {
        check_ajax_referer('comic_uploader_nonce', 'nonce');
    
        if (!isset($_FILES['comic_file'])) {
            wp_send_json_error(['message' => 'Файл не был загружен.']);
        }
    
        $file = $_FILES['comic_file'];
        $upload = wp_handle_upload($file, ['test_form' => false]);
    
        if (isset($upload['error'])) {
            wp_send_json_error(['message' => $upload['error']]);
        }
    
        // Генерация миниатюры для PDF
        if ($file['type'] === 'application/pdf') {
            $thumbnail_path = $this->generate_pdf_thumbnail($upload['file']);
            if ($thumbnail_path) {
                // Сохраняем миниатюру в базе данных
                $thumbnail_url = str_replace(ABSPATH, home_url('/'), $thumbnail_path);
            } else {
                $thumbnail_url = ''; // Ошибка генерации миниатюры
            }
        } else {
            $thumbnail_url = ''; // Если это не PDF, то миниатюра не нужна
        }
    
        global $wpdb;
        $wpdb->insert($this->uploads_table, [
            'title' => basename($upload['file']),
            'url' => $upload['url'],
            'uploaded_at' => current_time('mysql'),
            'thumbnail_url' => $thumbnail_url,
        ]);
    
        wp_send_json_success(['message' => 'Файл успешно загружен!', 'url' => $upload['url'], 'thumbnail_url' => $thumbnail_url]);
    }
    
    function load_comics_list() {
        global $wpdb;
    
        $comics = $wpdb->get_results("SELECT * FROM {$this->approved_table} ORDER BY RAND() LIMIT 3");
    
        if (empty($comics)) {
            echo '<p>Нет загруженных комиксов.</p>';
        }
    
        $output = '';
        foreach ($comics as $comic) {
            $output .= $this->render_comic_item($comic);
        }
    
        echo $output;
    }

    public function approve_comic()
    {
        check_ajax_referer('comic_uploader_nonce', 'nonce');

        if (!isset($_POST['comic_id'])) {
            wp_send_json_error(['message' => 'Комикс не выбран']);
        }

        global $wpdb;
        $comic_id = intval($_POST['comic_id']);

        $comic = $wpdb->get_row("SELECT * FROM {$this->uploads_table} WHERE id = $comic_id");

        if ($comic) {
            $wpdb->insert($this->approved_table, [
                'title' => $comic->title,
                'url' => $comic->url,
                'uploaded_at' => $comic->uploaded_at,
                'thumbnail_url' => $comic->thumbnail_url,
            ]);

            $wpdb->delete($this->uploads_table, ['id' => $comic_id]);

            wp_send_json_success(['message' => 'Комикс одобрен и перенесен']);
        }

        wp_send_json_error(['message' => 'Ошибка при одобрении комикса']);
    }

    public function delete_comic()
    {
        check_ajax_referer('comic_uploader_nonce', 'nonce');

        if (!isset($_POST['comic_id'])) {
            wp_send_json_error(['message' => 'Комикс не выбран']);
        }

        global $wpdb;
        $comic_id = intval($_POST['comic_id']);

        $deleted_from_uploaded = $wpdb->delete($this->uploads_table, ['id' => $comic_id]);

        if (!$deleted_from_uploaded) {
            $deleted_from_approved = $wpdb->delete($this->approved_table, ['id' => $comic_id]);
        }

        if ($deleted_from_uploaded || $deleted_from_approved) {
            wp_send_json_success(['message' => 'Комикс успешно удален']);
        } else {
            wp_send_json_error(['message' => 'Не удалось удалить комикс']);
        }
    }

    public function render_upload_form()
    {
        ob_start();
        ?>
        <div class="comic-uploader-container">
            <h2 class="comic-uploader-title">Покажите себя!</h2>
            <form id="comic-uploader-form" enctype="multipart/form-data">
                <input type="file" name="comic_file" required>
                <button type="submit">Загрузить</button>
            </form>
            <div id="comic-uploader-message"></div>
        </div>
        <?php
        return ob_get_clean();
    }
    
    public function render_comic_item($comic)
    {
        ob_start();

        include plugin_dir_path(__FILE__) . 'templates/comic-item.php'; 

        return ob_get_clean();
    }

    function generate_pdf_thumbnail($file_path)
    {
        if (!extension_loaded('imagick')) {
            return false;
        }
    
        if (!file_exists($file_path)) {
            return false;
        }
    
        try {
            $imagick = new Imagick();
    
            $imagick->readImage($file_path . '[0]');
    
            $imagick->setImageResolution(150, 150);
            
            $thumbnail_path = pathinfo($file_path, PATHINFO_DIRNAME) . '/' . uniqid('thumb_') . '.png';
            $imagick->writeImage($thumbnail_path);
    
            $imagick->clear();
            $imagick->destroy();
    
            return $thumbnail_path;
        } catch (Exception $e) {
            return false;
        }
    }
}

new ComicUploaderPlugin();
