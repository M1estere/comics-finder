<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

/* Make the global query and post objects available */
global $wp_query, $post;
if ($pagination_option == 'pagination') {
  $posts_page = $nr_post;
} else {
  $posts_page = '-1';
};

/* Filter decoration inherited from the header options */

$decoration = get_theme_mod('minimalio_settings_link_decoration');
if ($decoration == 'underline') {
  $class = ' underlined';
} elseif ($decoration == 'line-through') {
  $class = 'line-through ';
} else {
  $class = '';
}

/* Dynamic title for the archive page*/
$dynamic_title = '';

if ($post_type == 'portfolio') {
  $taxonomy_name = 'portfolio-categories';
} elseif ($post_type == 'post') {
  $taxonomy_name = 'category';
}

if ($post_type == 'portfolio') {
  $portfolio_class = 'portfolio-post-type';
  $aspect_ratio = get_theme_mod('minimalio_settings_post_card_image_aspect_ratio');
  $gap = get_theme_mod('minimalio_settings_portfolio_gap');
} else {
  $portfolio_class = 'blog-post-type';
  $aspect_ratio = get_theme_mod('minimalio_settings_blog_post_card_image_aspect_ratio');
  $gap = get_theme_mod('minimalio_settings_blog_gap');
}


$term = get_queried_object();

if (isset($term->display_name)) {
  $dynamic_title = 'Posts by ' . ucfirst($term->display_name);
} elseif (isset($term->name)) {
  $dynamic_title = ucfirst($term->name);
} else {
  $dynamic_title = '';
}

// Check if category is defined to supress an "Undefined category" error on the archive list.
$check_cat = isset($category) ? $category : 'all';
$check_tag = isset($tag) ? $tag : 'all';
$check_author = isset($author) ? $author : 'all';
$check_date = isset($date_query) ? $date_query : 'all';
// Check if custom taxonomy is set
$check_taxonomy = isset($taxonomy) && ($taxonomy !== 'no_taxonomy' || $taxonomy_id != -1) ? $taxonomy : 'all';

// End check
if ($check_tag !== 'all') {
  $args_search = array(
    'tag_id' => $check_tag,
    'post_type' => $post_type,
    'post_status' => 'publish',
    'posts_per_page' => $posts_page,
    'orderby' => 'date',
    'order' => 'DESC',
    'lwd_paginate' => $posts_page,
    'taxonomy_name' => $taxonomy_name,
  );
} elseif ($check_author !== 'all') {
  $args_search = array(
    'author' => $check_author,
    'post_type' => $post_type,
    'post_status' => 'publish',
    'posts_per_page' => $posts_page,
    'orderby' => 'date',
    'order' => 'DESC',
    'lwd_paginate' => $posts_page,
    'taxonomy_name' => $taxonomy_name,
  );
} elseif ($check_date !== 'all') {
  $args_search = array(
    'post_type' => $post_type,
    'post_status' => 'publish',
    'posts_per_page' => $posts_page,
    'date_query' => $check_date,
    'orderby' => 'date',
    'order' => 'DESC',
    'lwd_paginate' => $posts_page,
  );
} elseif ($check_taxonomy !== 'all') {
  $args_search = array(
    'post_type' => 'portfolio',
    'tax_query' => array(
      array(
        'taxonomy' => $taxonomy,
        'field' => 'term_id',
        'terms' => $taxonomy_id,
      ),
    ),
    'lwd_paginate' => $posts_page,
    'taxonomy_name' => $taxonomy_name,
  );
} else {
  $args_search = array(
    'cat' => $check_cat,
    'post_type' => $post_type,
    'post_status' => 'publish',
    'posts_per_page' => $posts_page,
    'orderby' => 'date',
    'order' => 'DESC',
    'lwd_paginate' => $posts_page,
    'taxonomy_name' => $taxonomy_name,
  );
}

$search = new Minimalio_SearchFilter(
  $args_search
);

/* Pagination rules */
$args = array(
  'next_text' => '>>',
  'prev_text' => '<<',
  'end_size' => 1,
  'mid_size' => 1,
);

$cat_args = array(
  'post_type' => $post_type,
  'posts_per_page' => -1
);

if (!isset($all_label) || !$all_label) {
  $label = 'All';
} else {
  $label = $all_label;
}

if (!isset($filter) || !$filter) {
  $filter_default = 'yes';
} else {
  $filter_default = $filter;
}


if (!isset($_GET['category']) || !$_GET['category']) {
  $category_selected = 0;
} else {
  $category_selected = $_GET['category'];
}

/** Current URL */
$current_url = $_SERVER['REQUEST_URI'];

if (str_contains($current_url, 'page')) {
  for ($i = 1; $i <= 100; $i++) {
    $delete = '/page/' . $i . '/';

    if (str_contains($current_url, '/' . $i . '/')) {
      $clean_url = str_replace($delete, '', $current_url);
    }
  }
} else {
  $clean_url = $current_url;
}

if (get_theme_mod('minimalio_settings_post_cart_button_label')) {
  $button_label = get_theme_mod('minimalio_settings_post_cart_button_label');
} else {
  $button_label = 'Read More';
};

/* If the query has results, proceed */
if ($search) :
  ?>


  <div class="posts overflow-hidden <?php echo $enable_masonry; ?> w-full pb-12 lg:pb-16">

    <?php if ($filter_default == 'yes') : ?>
      <div class="pt-0 pb-8 m-0 posts__container">

        <div class="flex items-center justify-between block m-0 posts__row">

          <form action="<?php echo $clean_url ?>" class="justify-between block w-full posts__form" method="get">

            <div class="flex flex-wrap items-center justify-start posts__categories-wrapper gap-x-4 lg:gap-x-8 gap-y-4">

              <label class="posts__tab<?php if ($category_selected == '0') : ?> checked<?php endif; ?> inline-block bg-transparent h-fit rounded-none">
                <input type="radio" class="posts__radio<?php if (empty($_GET['category']) && empty($_GET['keywords'])) : ?> checked<?php endif; ?> absolute top-0 right-0 bottom-0 left-0 invisible" name="category" value="" onchange="this.form.submit();" data-search-element />
                <span class="posts__tab-label <?php echo esc_attr($class); ?> block">
                  <?php echo $label; ?>
                </span>

              </label>

              <?php

              if ($categories) :
                foreach ($categories as $category) : ?>

                  <label class="posts__tab<?php if (($category_selected === $category->slug) or ($category_selected === '/' . $category->slug . '/')) : ?> checked<?php endif; ?> inline-block bg-transparent h-fit rounded-none">

                    <input type="radio" class="absolute top-0 bottom-0 left-0 right-0 invisible posts__radio" name="category" value="<?php echo $category->slug; ?>" onchange="this.form.submit();" data-search-element />
                    <span class="posts__tab-label <?php echo esc_attr($class); ?>">
                      <?php echo $category->name; ?>
                    </span>

                  </label>

              <?php endforeach;
              endif; ?>

            </div>

          </form>

        </div>

      </div>

    <?php endif; ?>

    <div class="<?php echo $portfolio_class ?> <?php if ($gap) {
      echo $gap; } else {
        echo esc_attr("gap_1");
      } ?> aspect-ratio-<?php echo $aspect_ratio ?>">

      <div class="posts__container photoswipe-wrapper">

        <?php if (!empty($dynamic_title)) { ?>
          <h1 class="pb-8 mb-0 break-words entry-title">
            <?php echo $dynamic_title; ?>
          </h1>
        <?php } ?>

        <?php if ($search->results) :

          $enable_masonry_style = $enable_masonry; ?>

          <div class="grid grid-cols-1 sm:grid-cols-2 posts__row pswp__wrap <?php echo 'lg:grid-cols-' . $nr_columns . ''; ?>">

            <?php foreach ($search->results as $post) : ?>
              <div class="post-item <?php if ($enable_masonry == 'masonry') : ?>post-item__masonry grid-item<?php endif; ?>">

                <?php minimalio_get_part(
                  'templates/snippets/post-cards/' . $post_card,
                  array(
                    'id' => $post->ID,
                    'author_type' => $author_type,
                    'author' => $post->post_author,
                    'link_url' => get_the_permalink($post->ID),
                    'card_image' => get_post_thumbnail_id($post->ID),
                    'image_size' => array(400, 500, 1),
                    'heading_type' => 'h5',
                    'card_title' => get_the_title($post->ID),
                    'card_excerpt' => get_the_excerpt($post->ID),
                    'card_content' => get_the_content($post->ID),
                    'card_category' => $post_type == 'portfolio' ? get_the_terms($post->ID, 'portfolio-categories') : get_the_category($post->ID),
                    'card_tag' => $post_type == 'portfolio' ? get_the_terms($post->ID, 'portfolio-tags') : wp_get_post_tags($post->ID),
                    'minimalio_button_label' => $button_label,
                    'minimalio_hover_image' => get_post_meta($post->ID, '_hover_image_id', true),
                    'minimalio_hover_video' => get_post_meta($post->ID, '_hover_video_id', true),
                    'vimeo_id'             =>   get_post_meta($post->ID, '_vimeo_id', true)
                  )
                ); ?>
              </div>

            <?php endforeach; ?>
          </div>

        <?php else : ?>

          <p class="posts__no-label">
            <?php _e('No posts found, please try a different search combination.', 'minimalio'); ?>
          </p>

        <?php endif; ?>

            <div class="mt-8 posts__pagination pagination">
              <?php
              the_posts_pagination(array(
                'mid_size' => 2,
                'prev_text' => __('Previous Page', 'minimalio'),
                'next_text' => __('Next Page', 'minimalio'),
              )); ?>
            </div>

      </div>

    </div>

  <?php endif; ?>
