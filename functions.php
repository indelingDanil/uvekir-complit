<?php

function update_wp_site_url_in_env()
{
    $env_file_path = __DIR__ . '/.env';

    if (!file_exists($env_file_path)) {
        return;
    }

    $env_content = file_get_contents($env_file_path);
    preg_match('/^WP_SITE_URL=(.*)$/m', $env_content, $matches);
    $current_env_url = isset($matches[1]) ? trim($matches[1]) : '';
    $current_site_url = get_site_url();

    if ($current_env_url !== $current_site_url) {
        $new_env_content = preg_replace('/^WP_SITE_URL=.*$/m', 'WP_SITE_URL=' . $current_site_url, $env_content);
        file_put_contents($env_file_path, $new_env_content);
    }
}

function custom_upload_dir($uploads)
{
    // Устанавливаем новый URL и пути только для папки uploads
    $uploads['baseurl'] = 'https://uvelir-complit.indeling.ru/wp-content/uploads';
    $uploads['url'] = $uploads['baseurl'] . $uploads['subdir'];
    $uploads['path'] = $uploads['basedir'] . $uploads['subdir'];
    return $uploads;
}
add_filter('upload_dir', 'custom_upload_dir');

add_action('init', 'update_wp_site_url_in_env');

require get_template_directory() . '/lib/include/custom-post-type-catalog.php';
require get_template_directory() . '/lib/include/taxonomy-catalog.php';
require get_template_directory() . '/lib/include/cart-form.php';
function theme_builder()
{
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css');
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js');
    wp_enqueue_style('css', get_template_directory_uri() . '/assets/bundle.min.css', 1.0);
    wp_enqueue_script('js', get_template_directory_uri() . '/assets/bundle.min.js', ['jquery'], 1.0, true);
    $nonce = wp_create_nonce('wp_rest');

    // Передаем объект wpApiSettings в ваш скрипт
    wp_localize_script('js', 'wpApiSettings', array(
        'nonce' => $nonce,
        'apiUrl' => esc_url(rest_url('/custom/v1/send-email/'))
    ));
    // wp_enqueue_script('cart-form-js', get_template_directory_uri() . '/assets/cart-telegram.js', [], 1.0, true);
}

add_action('wp_enqueue_scripts', 'theme_builder');

function catalog_post_type_link($post_link, $post)
{
    if ($post->post_type == 'catalog') {
        if ($terms = get_the_terms($post->ID, 'catalog_type')) {
            $post_link = str_replace('%catalog_type%', array_pop($terms)->slug, $post_link);
        } else {
            $post_link = str_replace('%catalog_type%', 'no-category', $post_link);
        }
    }
    return $post_link;
}
add_filter('post_type_link', 'catalog_post_type_link', 10, 2);

function rewrite_flush()
{
    register_catalog_post_type(); // Вызов функции регистрации типа поста
    register_catalog_taxonomy(); // Вызов функции регистрации таксономии
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'rewrite_flush');

function custom_rewrite_rules()
{
    add_rewrite_rule(
        '^catalog/([^/]+)/?$',
        'index.php?catalog_type=$matches[1]',
        'top'
    );
    add_rewrite_rule(
        '^catalog/([^/]+)/(.+)$',
        'index.php?catalog_type=$matches[1]&catalog=$matches[2]',
        'top'
    );
}
add_action('init', 'custom_rewrite_rules');

function custom_taxonomy_permalink($term_link, $term, $taxonomy)
{
    if ($taxonomy === 'catalog_type') {
        return home_url('catalog/' . $term->slug);
    }
    return $term_link;
}

add_filter('term_link', 'custom_taxonomy_permalink', 10, 3);

function custom_catalog_template($template)
{
    if (is_page() && get_queried_object()->post_name === 'catalog') {
        if ($new_template = locate_template('taxonomy.php')) {
            return $new_template;
        }
    }
    return $template;
}
add_filter('template_include', 'custom_catalog_template');

if (function_exists('acf_add_options_page')) {
    // Регистрация страницы "Контактная информация"
    acf_add_options_page(array(
        'page_title' => 'Контактная информация',
        'menu_title' => 'Контактная информация',
        'menu_slug' => 'contact-info',
        'capability' => 'edit_posts',
        'redirect' => false
    ));
    // Регистрация страницы "Настройки шапки сайта"
    acf_add_options_page(array(
        'page_title' => 'Настройки шапки сайта',
        'menu_title' => 'Настройки шапки сайта',
        'menu_slug' => 'header-settings',
        'capability' => 'edit_posts',
        'redirect' => false
    ));
    // Регистрация страницы "Настройки подвала сайта"
    acf_add_options_page(array(
        'page_title' => 'Настройки подвала сайта',
        'menu_title' => 'Настройки подвала сайта',
        'menu_slug' => 'footer-settings',
        'capability' => 'edit_posts',
        'redirect' => false
    ));
    // Регистрация страницы "Настройки подвала сайта"
    acf_add_options_page(array(
        'page_title' => 'Статичные шаблоны',
        'menu_title' => 'Статичные шаблоны',
        'menu_slug' => 'static-settings',
        'capability' => 'edit_posts',
        'redirect' => false
    ));
}

add_theme_support('post-thumbnails');


// menus
register_nav_menus([
    'nav_main' => __('Menu principal'),
    'nav_footer' => __('Menu footer'),
]);


function custom_excerpt_more($more)
{
    return '...';
}
add_filter('excerpt_more', 'custom_excerpt_more');

function custom_excerpt_length($length)
{
    return 20; // Установите желаемую длину отрывка
}
add_filter('excerpt_length', 'custom_excerpt_length', 999);


function load_more_products()
{
    check_ajax_referer('load_more_nonce', 'nonce');

    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;

    // Получаем количество уже загруженных постов
    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;

    // Получаем переданный термин
    $term_slug = isset($_POST['term_slug']) ? sanitize_text_field($_POST['term_slug']) : '';

    $args = [
        'post_type' => 'catalog',
        'posts_per_page' => 6,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
        'paged' => $paged,
        'offset' => $offset, // Добавляем смещение
    ];

    if (!empty($term_slug)) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'catalog_type',
                'field' => 'slug',
                'terms' => $term_slug,
            ],
        ];
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            ?>
            <div class="new_products__card">
                <div class="new_products__image-and-heart_new">
                    <?php if (has_post_thumbnail()): ?>
                        <img class="new_products__image" src="<?php the_post_thumbnail_url('full'); ?>"
                            alt="<?php the_title_attribute(); ?>">
                    <?php else: ?>
                        <img class="new_products__image"
                            src="<?php echo esc_url(get_template_directory_uri()); ?>/img/png/product-image.png"
                            alt="<?php the_title_attribute(); ?>">
                    <?php endif; ?>

                    <?php $is_new_term = has_term('new', 'catalog_type'); ?>
                    <?php if ($is_new_term): ?>
                        <div class="new_products__heart_new">
                            <img class="new-img" src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/new.svg">
                            <button>
                                <img class="heart-img" src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/heart.svg">
                            </button>
                        </div>
                    <?php else: ?>
                        <div class="new_products__heart_new">
                            <button>
                                <img class="heart-img" src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/heart.svg">
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="new_products__info">
                    <h3 class="new_products__name"><?php the_title(); ?></h3>
                </div>
                <div class="new_products__actions">
                    <a href="<?php the_permalink(); ?>" class="new_products__btn"><img
                            src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/reply.svg"
                            alt="Подробнее">Подробнее</a>
                    <button class="new_products__cart-btn"><img
                            src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/products_cart.svg"
                            alt="cart"></button>
                    <div class="new_products__cart-quantity-wrapper">
                        <input type="number" class="new_products__cart-quantity" value="1" min="1" id="quantityInput">
                        <div class="new_products__quantity-buttons">
                            <button class="new_products__quantity-button" id="increaseButton"><img
                                    src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/arrow_up.svg"
                                    alt="Increase"></button>
                            <button class="new_products__quantity-button" id="decreaseButton"><img
                                    src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/arrow_up.svg"
                                    alt="Decrease"></button>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        echo 'end';
    }

    wp_reset_postdata();
    wp_die();
}
add_action('wp_ajax_load_more_products', 'load_more_products');
add_action('wp_ajax_nopriv_load_more_products', 'load_more_products');

function enqueue_load_more_script()
{
    $current_term = get_queried_object();
    $term_slug = '';

    if ($current_term && isset($current_term->slug)) {
        $term_slug = $current_term->slug;
    }

    wp_enqueue_script('load-more-products', get_template_directory_uri() . '/assets/load-more-products.js', ['jquery'], null, true);

    wp_localize_script('load-more-products', 'load_more_params', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('load_more_nonce'),
        'current_page' => 1,
        'term_slug' => $term_slug, // передаем слаг термина
    ]);
}
add_action('wp_enqueue_scripts', 'enqueue_load_more_script');

// Функция для вывода стрелки-разделителя
function breadcrumb_separator() {
    echo '<img src="' . esc_url(get_template_directory_uri()) . '/img/svg/arrow_right.svg" alt="Arrow">';
}

// Функция для получения ссылки на таксономию
function get_breadcrumb_taxonomy_link($post_id, $excluded_taxonomy = 'new') {
    // Получаем все таксономии, связанные с постом
    $taxonomies = get_object_taxonomies(get_post_type($post_id), 'objects');

    // Проверяем, есть ли таксономии
    if (!empty($taxonomies)) {
        foreach ($taxonomies as $taxonomy) {
            // Исключаем указанную таксономию
            if ($taxonomy->name !== $excluded_taxonomy) {
                // Получаем термины для данной таксономии
                $terms = get_the_terms($post_id, $taxonomy->name);

                if (!empty($terms) && !is_wp_error($terms)) {
                    foreach ($terms as $term) {
                        // Возвращаем ссылку на первый термин
                        return '<a href="' . esc_url(get_term_link($term)) . '">' . esc_html($term->name) . '</a>';
                    }
                }
            }
        }
    }
    return ''; // Возвращаем пустую строку, если таксономия не найдена
}