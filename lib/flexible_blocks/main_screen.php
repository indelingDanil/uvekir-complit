<section class="main_screen">
    <img src="<?php the_sub_field("img_background") ?>" alt="Background" class="main_screen__background-image">

    <div class="main_screen__content">
        <div class="main_screen__logo-container">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/logo-main.svg"
                class="main_screen__logo">
        </div>
        <div class="main_screen__products">
            <?php if (have_rows('reparter_catalog')): ?>
                <?php while (have_rows('reparter_catalog')):
                    the_row(); ?>
                    <?php
                    $link = get_sub_field('link'); // Извлекаем URL из поля ACF
                    $term = get_term_by('slug', basename($link), 'catalog_type'); // Извлекаем термин по его slug
            
                    // Используем home_url() для получения текущего домена
                    $current_domain = home_url();

                    // Заменяем старый домен на новый
                    $parsed_url = parse_url($link);
                    $new_link = $current_domain . $parsed_url['path'];

                    if ($term) {
                        $title = $term->name; // Получаем название термина
                    } else {
                        $title = 'Название не найдено'; // На случай, если термин не найден
                    }
                    ?>
                    <a href="<?php echo esc_url($new_link); ?>" class="product">
                        <img src="<?php the_sub_field('img'); ?>" alt="<?php echo esc_attr($title); ?>" class="product__image">
                        <p class="product__title"><?php echo esc_html($title); ?></p>
                    </a>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</section>