<?php
get_header();
$templatePath = TEMPLATEPATH . '/lib/flexible_blocks/';
$layoutMapping = [
    'main_screen' => 'main_screen.php',
    'about_company' => 'about_company.php',
    'trust_us' => 'trust_us.php',
    'new_products' => 'new_products.php',
    'subscribe' => 'subscribe.php',
    'blog' => 'blog.php',
    'product_catalog' => 'product_catalog.php',
    'basket' => 'basket.php',
    'favorites' => 'favorites.php',
    'content' => 'content.php',
    'contacts' => 'contacts.php'
];

echo '<wrapper class="wrapper">';
if (get_field('flexible_blocks')) {
    while (has_sub_field('flexible_blocks')) {
        $layout = get_row_layout();
        if (isset($layoutMapping[$layout])) {
            require $templatePath . $layoutMapping[$layout];
        }
    }
} else {
    echo 'Тут нет контента:(';
}
get_footer();

?>