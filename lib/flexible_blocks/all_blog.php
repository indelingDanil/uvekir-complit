<section class="blog">
    <div class="blog__content">
        <?php
        // Получаем текущую страницу для пагинации
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        // Настраиваем WP_Query для получения постов с пагинацией
        $args = [
            'post_type' => 'post',      // Тип записи (в данном случае посты)
            'posts_per_page' => 12,     // Количество постов на страницу
            'paged' => $paged,          // Текущая страница
            'order' => 'DESC',          // Порядок сортировки (от новых к старым)
            'orderby' => 'date'         // Сортировка по дате
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

            // Добавляем пагинацию
            $big = 999999999; // уникальное число для замены в ссылках
            echo '<div class="pagination">';
            echo paginate_links([
                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                'format' => '?paged=%#%',
                'current' => max(1, get_query_var('paged')),
                'total' => $recent_posts->max_num_pages,
                'prev_text' => __('« Предыдущая'),
                'next_text' => __('Следующая »'),
            ]);
            echo '</div>';

            wp_reset_postdata();
        else: ?>
            <p>Постов не найдено.</p>
        <?php endif; ?>
    </div>
</section>