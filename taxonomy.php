<?php get_header();

$templatePath = TEMPLATEPATH . '/lib/flexible_blocks/';
$layoutMapping = [
    'main_catalog' => 'main_catalog.php',
    'product_catalog' => 'product_catalog.php',
    'trust_us' => 'trust_us.php'
];
echo '<wrapper class="wrapper">';
$layouts = array_values($layoutMapping);
$index = 0;

while ($index < count($layouts)) {
    include $templatePath . $layouts[$index];
    $index++;
}
echo '</wrapper>';

get_footer(); ?>