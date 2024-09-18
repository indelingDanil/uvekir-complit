<?php
// Функция для регистрации нового типа поста "каталог"
function register_catalog_post_type()
{
    $labels = array(
        'name' => 'Каталог',
        'singular_name' => 'Каталог',
        'menu_name' => 'Каталоги',
        'name_admin_bar' => 'Каталог',
        'add_new' => 'Добавить новый',
        'add_new_item' => 'Добавить новый каталог',
        'new_item' => 'Новый каталог',
        'edit_item' => 'Редактировать каталог',
        'view_item' => 'Просмотр каталога',
        'all_items' => 'Все каталоги',
        'search_items' => 'Искать каталоги',
        'parent_item_colon' => 'Родительский каталог:',
        'not_found' => 'Каталоги не найдены',
        'not_found_in_trash' => 'Каталоги в корзине не найдены',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'catalog/%catalog_type%', 'with_front' => false),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
    );

    register_post_type('catalog', $args);
}
add_action('init', 'register_catalog_post_type');
?>