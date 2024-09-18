<?php

function register_catalog_taxonomy() {
    $labels = array(
        'name'              => 'Типы каталога',
        'singular_name'     => 'Тип каталога',
        'search_items'      => 'Искать типы каталога',
        'all_items'         => 'Все типы каталога',
        'parent_item'       => 'Родительский тип каталога',
        'parent_item_colon' => 'Родительский тип каталога:',
        'edit_item'         => 'Редактировать тип каталога',
        'update_item'       => 'Обновить тип каталога',
        'add_new_item'      => 'Добавить новый тип каталога',
        'new_item_name'     => 'Название нового типа каталога',
        'menu_name'         => 'Типы каталога',
    );

    $args = array(
        'labels'            => $labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'catalog', 'with_front' => false),
    );

    register_taxonomy('catalog_type', array('catalog'), $args);
}
add_action('init', 'register_catalog_taxonomy');

?>