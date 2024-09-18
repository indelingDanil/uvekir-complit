<section class="new_products">
    <h2 class="new_products__title">Новые товары</h2>
    <p class="new_products__subtitle">В нашем каталоге</p>
    <div class="new_products__grid">
        <?php
        // Настраиваем WP_Query для получения последних 8 постов из таксономии catalog и рубрики new
        $args = [
            'post_type' => 'catalog', // Если у вас другая кастомная запись, укажите её
            'posts_per_page' => 8,
            'post_status' => 'publish',
            'tax_query' => [
                'relation' => 'AND',
                [
                    'taxonomy' => 'catalog_type', // Ваша таксономия catalog
                    'field' => 'slug',
                    'terms' => 'new', // Рубрика таксономии new
                ],
            ],
            'orderby' => 'date',
            'order' => 'DESC',
        ];

        $new_products_query = new WP_Query($args);

        if ($new_products_query->have_posts()):
            while ($new_products_query->have_posts()):
                $new_products_query->the_post(); ?>
                <div class="new_products__card products-card">
                    <div>
                        <div class="new_products__image-and-heart_new">
                            <?php if (has_post_thumbnail()): ?>
                                <img class="new_products__image product-image" src="<?php the_post_thumbnail_url('full'); ?>"
                                    alt="<?php the_title_attribute(); ?>">
                            <?php else: ?>
                                <img class="new_products__image product-image"
                                    src="<?php echo esc_url(get_template_directory_uri()); ?>/img/png/product-image.png"
                                    alt="<?php the_title_attribute(); ?>">
                            <?php endif; ?>
                            <div class="new_products__heart_new">
                                <img class="new-img" src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/new.svg">
                                <button class="favorites-heart-btn">
                                    <svg class=" heart-img" width="29.167206" height="26.957275" viewBox="0 0 29.1672 26.9573"
                                        fill="none" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <defs />
                                        <path
                                            d="M14.58 2.22C18.01 -0.85 23.3 -0.75 26.6 2.56C29.9 5.86 30.01 11.13 26.94 14.57L14.58 26.95L2.21 14.57C-0.86 11.13 -0.74 5.86 2.56 2.56C5.86 -0.74 11.14 -0.86 14.58 2.22L14.58 2.22ZM24.53 4.62C22.35 2.43 18.82 2.34 16.53 4.39L14.58 6.14L12.63 4.4C10.34 2.34 6.81 2.43 4.62 4.62C2.45 6.79 2.34 10.27 4.34 12.57L14.58 22.82L24.82 12.57C26.82 10.27 26.71 6.8 24.53 4.62L24.53 4.62Z"
                                            fill="#6A6A6A" fill-opacity="1.000000" fill-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="new_products__info">
                            <h3 class="new_products__name product-name"><?php the_title(); ?></h3>
                        </div>
                    </div>
                    <div class="new_products__actions">
                        <a href="<?php the_permalink(); ?>" class="new_products__btn link-to-product"><img
                                src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/reply.svg"
                                alt="Подробнее">Подробнее</a>
                        <button class="new_products__cart-btn"><img
                                src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/products_cart.svg"
                                alt="cart"></button>
                        <div class="new_products__cart-quantity-wrapper">
                            <input type="number" class="new_products__cart-quantity product-quantity" value="1" min="1">
                            <div class="new_products__quantity-buttons">
                                <button class="new_products__quantity-button increase-button"><img
                                        src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/arrow_up.svg"
                                        alt="Increase"></button>
                                <button class="new_products__quantity-button decrease-button"><img
                                        src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/arrow_up.svg"
                                        alt="Decrease"></button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile;
            wp_reset_postdata();
        else: ?>
            <p>Товары не найдены.</p>
        <?php endif; ?>
    </div>
    <div class="view-all">
        <button class="new_products__view-all"><img
                src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/reply.svg" alt="">Смотреть
            все</button>
    </div>
</section>