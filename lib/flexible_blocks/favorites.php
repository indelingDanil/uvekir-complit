<?php require get_template_directory() . '/lib/flexible_blocks/main_page.php'; ?>
<section class="favorites">
    <?php

    $cart_url = get_field("cart_link", "option");
    
    ?>
    <div class="product_catalog__crumb">
        <a href="<?php echo home_url(); ?>">Главная</a>
        <?php breadcrumb_separator(); ?>
        <p style="color: #e8ab23;"><?php the_title(); ?></p>
    </div>
    <div class="favorites__wrapper">
        <div class="basket__left">
            <div class="basket__controls">
                <button class="favorites__select-all-btn">
                    <input type="checkbox" class="favorites__select-all"> Выбрать все
                </button>
                <button class="favorites__remove-selected">Удалить выбранное</button>
            </div>
            <div class="basket__all-prod">
                <p>Товаров в избранном, <strong><span class="all_products-favorites" id="favorites-badge">0</span>
                        шт.</strong></p>
            </div>
            <div class="favorites__items">

            </div>
        </div>
        <div class="basket__right">
            <div class="basket__more-benefits">
                <h4 class="basket__more-benefits-title">Хотите больше выгоды?</h4>
                <p class="basket__more-benefits-text">Ознакомьтесь с нашими акционными товарами по <a href="#"
                        class="basket__more-benefits-link">ссылке</a>.</p>
            </div>
            <div class="basket__registration">
                <a href="<?php echo esc_url($cart_url); ?>" class="basket__checkout-button"><img
                        src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/reply.svg">Перейти в
                    корзину</a>
            </div>
        </div>
    </div>
</section>