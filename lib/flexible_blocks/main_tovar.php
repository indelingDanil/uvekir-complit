<?php 
// Получаем изображение из ACF или используем изображение по умолчанию
$main_img = get_field("main_img") ?: get_template_directory_uri() . '/img/png/bg_img-scaled.jpeg'; 
?>
<section class="main_catalog" style="background: url('<?php echo esc_url($main_img); ?>') no-repeat center center; background-size: cover;">
    <div class="main_catalog__content">
        <h1 class="main_catalog__title">
            <?php the_title(); ?>
        </h1>
        <div class="main_catalog__image-wrapper">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/logo-main.svg" class="main_catalog__image">
        </div>
    </div>
</section>