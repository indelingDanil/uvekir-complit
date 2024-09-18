<section class="product_catalog">
    <div class="product_catalog__crumb">
        <a href="<?php echo home_url(); ?>">Главная</a>
        <?php breadcrumb_separator(); ?>

        <?php if (is_page('catalog')): ?>
            <p style="color: #e8ab23;">Каталог</p>

        <?php elseif (is_tax('catalog_type')): ?>
            <a href="<?php echo home_url('/catalog/'); ?>">Каталог</a>
            <?php breadcrumb_separator(); ?>

            <?php
            $current_term = get_queried_object();

            $ancestors = get_ancestors($current_term->term_id, 'catalog_type');

            if ($ancestors):
                $ancestors = array_reverse($ancestors);
                foreach ($ancestors as $ancestor_id):
                    $ancestor = get_term($ancestor_id, 'catalog_type');
                    ?>
                    <a href="<?php echo get_term_link($ancestor); ?>"><?php echo $ancestor->name; ?></a>
                    <?php breadcrumb_separator(); ?>
                <?php endforeach; ?>
            <?php endif; ?>

            <p style="color: #e8ab23;"><?php single_term_title(); ?></p>
        <?php endif; ?>
    </div>
    <div class="product_catalog__content">
        <div class="product_catalog__nav">
            <div class="product_catalog__nav-block">
                <ul class="product_catalog__nav-block-ul">
                    <?php
                    $terms = get_terms(array(
                        'taxonomy' => 'catalog_type',
                        'hide_empty' => false,
                    ));

                    $current_term = get_queried_object();

                    if (!empty($terms) && !is_wp_error($terms)): ?>
                        <?php foreach ($terms as $term): ?>
                            <?php
                            $term_link = get_term_link($term);

                            if (is_wp_error($term_link)) {
                                continue;
                            }

                            $active_class = ($current_term && $current_term->term_id === $term->term_id) ? 'active' : '';
                            ?>
                            <a href="<?php echo esc_url($term_link); ?>" class="<?php echo esc_attr($active_class); ?>">
                                <?php echo esc_html($term->name); ?>
                            </a>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Термины таксономии не найдены.</p>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="product_catalog__tovars-wrapper">
            <div class="new_products__grid">
                <?php
                $current_term = get_queried_object();

                $args = [
                    'post_type' => 'catalog',
                    'posts_per_page' => 9,
                    'post_status' => 'publish',
                    'orderby' => 'date',
                    'order' => 'DESC',
                ];

                if ($current_term && isset($current_term->taxonomy) && $current_term->taxonomy === 'catalog_type') {
                    $args['tax_query'] = [
                        [
                            'taxonomy' => 'catalog_type',
                            'field' => 'slug',
                            'terms' => $current_term->slug,
                        ],
                    ];
                }

                $query = new WP_Query($args);

                if ($query->have_posts()):
                    while ($query->have_posts()):
                        $query->the_post(); ?>
                        <div class="new_products__card products-card">
                            <div>
                                <div class="new_products__image-and-heart_new">
                                    <?php if (has_post_thumbnail()): ?>
                                        <img class="new_products__image product-image"
                                            src="<?php the_post_thumbnail_url('full'); ?>" alt="<?php the_title_attribute(); ?>">
                                    <?php else: ?>
                                        <img class="new_products__image product-image"
                                            src="<?php echo esc_url(get_template_directory_uri()); ?>/img/png/product-image.png"
                                            alt="<?php the_title_attribute(); ?>">
                                    <?php endif; ?>

                                    <?php
                                    $is_new_term = has_term('new', 'catalog_type');
                                    ?>
                                    <?php if ($is_new_term): ?>
                                        <div class="new_products__heart_new">
                                            <img class="new-img"
                                                src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/new.svg">
                                            <button class="favorites-heart-btn">
                                                <svg class="heart-img" width="29.167206" height="26.957275"
                                                    viewBox="0 0 29.1672 26.9573" fill="none" xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                                    <defs />
                                                    <path
                                                        d="M14.58 2.22C18.01 -0.85 23.3 -0.75 26.6 2.56C29.9 5.86 30.01 11.13 26.94 14.57L14.58 26.95L2.21 14.57C-0.86 11.13 -0.74 5.86 2.56 2.56C5.86 -0.74 11.14 -0.86 14.58 2.22L14.58 2.22ZM24.53 4.62C22.35 2.43 18.82 2.34 16.53 4.39L14.58 6.14L12.63 4.4C10.34 2.34 6.81 2.43 4.62 4.62C2.45 6.79 2.34 10.27 4.34 12.57L14.58 22.82L24.82 12.57C26.82 10.27 26.71 6.8 24.53 4.62L24.53 4.62Z"
                                                        fill="#6A6A6A" fill-opacity="1.000000" fill-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                    <?php else: ?>
                                        <div class="new_products__heart_new">
                                            <button class="favorites-heart-btn">
                                                <svg class="heart-img" width="29.167206" height="26.957275"
                                                    viewBox="0 0 29.1672 26.9573" fill="none" xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                                    <defs />
                                                    <path
                                                        d="M14.58 2.22C18.01 -0.85 23.3 -0.75 26.6 2.56C29.9 5.86 30.01 11.13 26.94 14.57L14.58 26.95L2.21 14.57C-0.86 11.13 -0.74 5.86 2.56 2.56C5.86 -0.74 11.14 -0.86 14.58 2.22L14.58 2.22ZM24.53 4.62C22.35 2.43 18.82 2.34 16.53 4.39L14.58 6.14L12.63 4.4C10.34 2.34 6.81 2.43 4.62 4.62C2.45 6.79 2.34 10.27 4.34 12.57L14.58 22.82L24.82 12.57C26.82 10.27 26.71 6.8 24.53 4.62L24.53 4.62Z"
                                                        fill="#6A6A6A" fill-opacity="1.000000" fill-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                    <?php endif; ?>
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
                <button class="new_products__view-all">Загрузить еще</button>
            </div>
        </div>
    </div>
</section>