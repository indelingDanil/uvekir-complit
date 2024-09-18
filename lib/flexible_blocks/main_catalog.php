<?php 
// Проверяем, является ли это страницей таксономии
if (is_tax() || is_category() || is_tag()) {
    // Получаем изображение ACF для текущего термина таксономии
    $term = get_queried_object();
    $term_img = get_field('main_img', $term); // Используем ACF для получения изображения термина
} else {
    // Здесь можно добавить изображение по умолчанию или оставить пустым
    $term_img = ''; 
}
?>
<section class="main_catalog" 
    style="background: url('<?php echo $term_img ? esc_url($term_img) : esc_url(get_template_directory_uri()) . '/img/png/bg_img-scaled.jpeg'; ?>') no-repeat center center; background-size: cover;">
    <div class="main_catalog__content">
        <h2 class="main_catalog__title">
            <?php
            // Если это страница таксономии, выводим название термина
            if (is_tax() || is_category() || is_tag()) {
                $term = get_queried_object();
                echo esc_html($term->name);
            } else {
                the_title(); // Для обычных страниц
            }
            ?>
        </h2>
        <div class="main_catalog__image-wrapper">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/logo-main.svg" class="main_catalog__image">
        </div>
    </div>
</section>