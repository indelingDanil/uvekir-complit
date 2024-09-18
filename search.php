<?php get_header(); ?>
<wrapper class="wrapper">
    <section class="search">
        <div class="search-results-container">
            <h1 class="search-results-title">
                <?php printf('Результаты поиска для: %s', '<span>' . get_search_query() . '</span>'); ?>
            </h1>

            <?php if (have_posts()): ?>
                <div class="search-results-list">
                    <?php while (have_posts()):
                        the_post(); ?>
                        <?php
                        $post_type = get_post_type(); // Получаем тип поста
                        ?>
                        <?php if ($post_type === 'post'): ?>
                            <!-- Шаблон для постов блога -->
                            <div class="favorites__item products-card">
                                <div class="basket__item-info">
                                    <!-- Изображение поста или стандартное изображение -->
                                    <?php if (has_post_thumbnail()): ?>
                                        <img src="<?php the_post_thumbnail_url('full'); ?>" alt="<?php the_title_attribute(); ?>"
                                            class="basket__item-image product-image">
                                    <?php else: ?>
                                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/png/product-image.png"
                                            alt="<?php the_title_attribute(); ?>" class="basket__item-image product-image">
                                    <?php endif; ?>
                                    <!-- Название поста -->
                                    <h3 class="basket__item-title product-name"><?php the_title(); ?></h3>
                                </div>
                                <div class="basket__item-controls">
                                    <!-- Ссылка "Подробнее" -->
                                    <a href="<?php the_permalink(); ?>" class="new_products__btn link-to-product" style="width: fit-content">Перейти на страницу 
                                        поста</a>
                                </div>
                            </div>
                        <?php elseif ($post_type === 'page'): ?>
                            <!-- Шаблон для страниц -->
                            <div class="favorites__item products-card" data-index="<?php the_ID(); ?>">
                                <div class="basket__item-info">
                                    <!-- Изображение поста или стандартное изображение -->
                                    <?php if (has_post_thumbnail()): ?>
                                        <img src="<?php the_post_thumbnail_url('full'); ?>" alt="<?php the_title_attribute(); ?>"
                                            class="basket__item-image product-image">
                                    <?php else: ?>
                                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/png/product-image.png"
                                            alt="<?php the_title_attribute(); ?>" class="basket__item-image product-image">
                                    <?php endif; ?>
                                    <!-- Название поста -->
                                    <h3 class="basket__item-title product-name"><?php the_title(); ?></h3>
                                </div>
                                <div class="basket__item-controls">
                                    <!-- Ссылка "Подробнее" -->
                                    <a href="<?php the_permalink(); ?>" class="new_products__btn link-to-product" style="width: fit-content">Перейти на
                                        страницу</a>
                                </div>
                            </div>
                        <?php else: ?>
                            <!-- Шаблон для других типов постов -->
                            <div class="favorites__item products-card" data-index="<?php the_ID(); ?>">
                                <div class="basket__item-info">
                                    <!-- Изображение поста или стандартное изображение -->
                                    <?php if (has_post_thumbnail()): ?>
                                        <img src="<?php the_post_thumbnail_url('full'); ?>" alt="<?php the_title_attribute(); ?>"
                                            class="basket__item-image product-image">
                                    <?php else: ?>
                                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/png/product-image.png"
                                            alt="<?php the_title_attribute(); ?>" class="basket__item-image product-image">
                                    <?php endif; ?>
                                    <!-- Название поста -->
                                    <h3 class="basket__item-title product-name"><?php the_title(); ?></h3>
                                </div>
                                <div class="basket__item-controls">
                                    <!-- Ссылка "Подробнее" -->
                                    <a href="<?php the_permalink(); ?>" class="new_products__btn link-to-product">Подробнее</a>
                                    <!-- Кнопка "Избранное" -->
                                    <button class="single-catalog__btn-heart favorites-heart-btn" data-index="<?php the_ID(); ?>">
                                        <svg class="heart-img" width="29.167206" height="26.957275" viewBox="0 0 29.1672 26.9573"
                                            fill="none" xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <defs></defs>
                                            <path
                                                d="M14.58 2.22C18.01 -0.85 23.3 -0.75 26.6 2.56C29.9 5.86 30.01 11.13 26.94 14.57L14.58 26.95L2.21 14.57C-0.86 11.13 -0.74 5.86 2.56 2.56C5.86 -0.74 11.14 -0.86 14.58 2.22L14.58 2.22ZM24.53 4.62C22.35 2.43 18.82 2.34 16.53 4.39L14.58 6.14L12.63 4.4C10.34 2.34 6.81 2.43 4.62 4.62C2.45 6.79 2.34 10.27 4.34 12.57L14.58 22.82L24.82 12.57C26.82 10.27 26.71 6.8 24.53 4.62L24.53 4.62Z"
                                                fill="#6A6A6A" fill-opacity="1.000000" fill-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                    <!-- Кнопка "Добавить в корзину" -->
                                    <button class="new_products__cart-btn" data-index="<?php the_ID(); ?>">
                                        <img src="https://uvelir-complit.indeling.ru/wp-content/uploads/2024/09/products_cart.svg"
                                            alt="cart">
                                    </button>
                                    <input type="number" style="display:none" class="new_products__cart-quantity product-quantity"
                                        value="1" min="1">
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endwhile; ?>
                </div>

                <div class="search-pagination">
                    <?php
                    the_posts_pagination(array(
                        'prev_text' => 'Назад',
                        'next_text' => 'Вперед',
                    ));
                    ?>
                </div>

            <?php else: ?>
                <div class="no-results">
                    <h2>Ничего не найдено</h2>
                    <p>Извините, но по вашему запросу ничего не найдено. Попробуйте другой поисковый запрос.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</wrapper>
<?php get_footer(); ?>