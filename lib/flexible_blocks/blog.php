<section class="blog">
    <h2 class="blog__title">БЛОГ "ЮВЕЛИР КОМПЛИТ"</h2>
    <p class="blog__subtitle">Будь в курсе всех акций и новостей</p>
    <div class="blog__content">
        <?php
        // Настраиваем WP_Query для получения последних 4 постов
        $args = [
            'post_type' => 'post',      // Тип записи (в данном случае посты)
            'posts_per_page' => 4,           // Количество постов
            'order' => 'DESC',      // Порядок сортировки (от новых к старым)
            'orderby' => 'date'       // Сортировка по дате
        ];

        $recent_posts = new WP_Query($args);

        if ($recent_posts->have_posts()):
            while ($recent_posts->have_posts()):
                $recent_posts->the_post(); ?>
                <a class="blog__card" href="<?php the_permalink(); ?>">
                    <?php if (has_post_thumbnail()): ?>
                        <img src="<?php the_post_thumbnail_url('full'); ?>" alt="<?php the_title_attribute(); ?>"
                            class="blog__image">
                    <?php else: ?>
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/png/no-img.jpeg"
                            alt="<?php the_title_attribute(); ?>" class="blog__image">
                    <?php endif; ?>
                    <div class="blog__info">
                        <h3 class="blog__name"><?php the_title(); ?></h3>
                        <div class="blog__date-link">
                            <p class="blog__date"><?php echo get_the_date('d.m.Y'); ?></p>
                            <p class="blog__link">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/reply-gray.svg"
                                    alt="Подробнее">Подробнее
                            </p>
                        </div>
                    </div>
                </a>
            <?php endwhile;
            wp_reset_postdata();
        else: ?>
            <p>Постов не найдено.</p>
        <?php endif; ?>
    </div>
</section>