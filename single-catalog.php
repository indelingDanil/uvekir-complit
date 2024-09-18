<?php get_header(); ?>
<wrapper class="wrapper">
    <?php require get_template_directory() . '/lib/flexible_blocks/main_tovar.php'; ?>
    <section class="single-catalog">
        <div class="single-catalog__crumb">
            <a href="<?php echo home_url(); ?>">Главная</a>
            <?php breadcrumb_separator(); ?>

            <a href="<?php echo home_url(); ?>/catalog/">Каталог</a>
            <?php breadcrumb_separator(); ?>

            <?php
            function get_taxonomy_parents($term_id, $taxonomy)
            {
                $parents = [];
                $term = get_term($term_id, $taxonomy);

                if (!is_wp_error($term)) {
                    $parents[] = '<a href="' . get_term_link($term) . '">' . $term->name . '</a>';
                }

                while ($term->parent != 0) {
                    $term = get_term($term->parent, $taxonomy);
                    if (!is_wp_error($term)) {
                        array_unshift($parents, '<a href="' . get_term_link($term) . '">' . $term->name . '</a>');
                    } else {
                        break;
                    }
                }

                return $parents;
            }

            $terms = get_the_terms(get_the_ID(), 'catalog_type'); 
            
            if ($terms && !is_wp_error($terms)) {
                $term = $terms[0];

                $term_parents = get_taxonomy_parents($term->term_id, $term->taxonomy);

                foreach ($term_parents as $parent) {
                    echo $parent;
                    breadcrumb_separator();
                }
            }
            ?>

            <p style="color: #e8ab23;"><?php the_title(); ?></p>
        </div>
        <div class="single-catalog__content products-card">
            <?php
            $images = get_field('galery_tovar_img');
            if ($images): ?>
                <div class="slider">
                    <div class="slider__flex">
                        <div class="slider__col">
                            <div class="slider__thumbs">
                                <div class="swiper-container thumbs-container"> <!-- Слайдер с превью -->
                                    <div class="swiper-wrapper">
                                        <?php foreach ($images as $image): ?>
                                            <div class="swiper-slide">
                                                <div class="slider__image">
                                                    <img loading="lazy" src="<?php echo $image['url']; ?>" alt="" />
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="slider__images">
                            <div class="swiper-container images-container"> <!-- Слайдер с изображениями -->
                                <div class="swiper-wrapper">
                                    <?php
                                    $first = true; // Переменная для отслеживания первой итерации
                                    foreach ($images as $image): ?>
                                        <div class="swiper-slide">
                                            <div class="slider__image btn_modal">
                                                <img loading="lazy" class="<?php echo $first ? 'product-image' : ''; ?>"
                                                    src="<?php echo $image['url']; ?>" alt="" />
                                            </div>
                                        </div>
                                        <?php $first = false; // После первой итерации сбрасываем переменную ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div> <!-- Закрытие slider__flex -->
                </div>
            <?php endif; ?>

            <div class="single-catalog__info">
                <div class="single-catalog__title product-name"><?php the_title(); ?></div>
                <div class="single-catalog__info-title-top">Технические характеристики</div>
                <ul class="single-catalog__info-list">
                    <?php if (have_rows('reparter_tovar_info')): ?>
                        <?php while (have_rows('reparter_tovar_info')):
                            the_row();
                            $param = get_sub_field('param');
                            $value = get_sub_field('value');
                            ?>
                            <li class="single-catalog__info-item">
                                <span class="single-catalog__info-title"><?php echo esc_html($param); ?></span>
                                <span class="single-catalog__info-value"><?php echo esc_html($value); ?></span>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php endif; ?>
                <div class="new_products__actions single-catalog__actions">
                    <button href="<?php the_permalink(); ?>" class="single-catalog__btn-heart favorites-heart-btn"><svg
                            class="heart-img" width="29.167206" height="26.957275" viewBox="0 0 29.1672 26.9573"
                            fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <defs />
                            <path
                                d="M14.58 2.22C18.01 -0.85 23.3 -0.75 26.6 2.56C29.9 5.86 30.01 11.13 26.94 14.57L14.58 26.95L2.21 14.57C-0.86 11.13 -0.74 5.86 2.56 2.56C5.86 -0.74 11.14 -0.86 14.58 2.22L14.58 2.22ZM24.53 4.62C22.35 2.43 18.82 2.34 16.53 4.39L14.58 6.14L12.63 4.4C10.34 2.34 6.81 2.43 4.62 4.62C2.45 6.79 2.34 10.27 4.34 12.57L14.58 22.82L24.82 12.57C26.82 10.27 26.71 6.8 24.53 4.62L24.53 4.62Z"
                                fill="#6A6A6A" fill-opacity="1.000000" fill-rule="evenodd" />
                        </svg>
                        <button class="new_products__cart-btn single-catalog__cart-btn"><img
                                src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/products_cart.svg"
                                alt="cart">Добавить в корзину</button>
                        <a href="<?php the_permalink(); ?>" class="link-to-product" style="display: none;"></a>
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
        </div>
        <div class="single-catalog__text">
            <?php the_content(); ?>
        </div>

        <script>
            // Инициализация слайдера превью
            const sliderThumbs = new Swiper(".thumbs-container", {
                lazy: true,
                preloadImages: false,
                direction: "vertical",
                slidesPerView: 3,
                spaceBetween: 40,
                navigation: {
                    nextEl: ".slider__next",
                    prevEl: ".slider__prev",
                },
                freeMode: true,
                breakpoints: {
                    0: {
                        direction: "horizontal",
                    },
                    768: {
                        direction: "vertical",
                    },
                },
            });

            // Инициализация основного слайдера
            const sliderImages = new Swiper(".images-container", {
                lazy: true,
                preloadImages: false,
                direction: "vertical",
                slidesPerView: 1,
                spaceBetween: 32,
                mousewheel: true,
                navigation: {
                    nextEl: ".slider__next",
                    prevEl: ".slider__prev",
                },
                grabCursor: true,
                thumbs: {
                    swiper: sliderThumbs,
                },
                breakpoints: {
                    0: {
                        direction: "horizontal",
                    },
                    768: {
                        direction: "vertical",
                    },
                },
            });
        </script>
    </section>
    <?php require get_template_directory() . '/lib/flexible_blocks/trust_us.php'; ?>
</wrapper>
<?php get_footer(); ?>