<?php require get_template_directory() . '/lib/flexible_blocks/main_page.php'; ?>
<section class="basket">
    <div class="product_catalog__crumb">
        <a href="<?php echo home_url(); ?>">Главная</a>
        <?php breadcrumb_separator(); ?>
        <p style="color: #e8ab23;"><?php the_title(); ?></p>
    </div>
    <div class="basket__wrapper">
        <div class="basket__left">
            <div class="basket__controls">
                <button class="basket__select-all-btn">
                    <input type="checkbox" class="basket__select-all"> Выбрать все
                </button>
                <button class="basket__remove-selected">Удалить выбранное</button>
            </div>
            <div class="basket__all-prod">
                <p>Товаров в корзине, <strong><span class="all_products">0</span> шт.</strong></p>
            </div>
            <div class="basket__items">

            </div>
        </div>
        <div class="basket__right">
            <div class="basket__summary">
                <div class="basket__summary-text">Товаров в корзине, <strong><span class="all_products">0</span>
                        шт.</strong></div>
            </div>
            <div class="basket__more-benefits">
                <h4 class="basket__more-benefits-title">Хотите больше выгоды?</h4>
                <p class="basket__more-benefits-text">Ознакомьтесь с нашими акционными товарами по <a href="#"
                        class="basket__more-benefits-link">ссылке</a>.</p>
            </div>
            <div class="basket__registration">

                <button class="basket__checkout-button"><img
                        src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/reply.svg">Перейти к
                    оформлению</button>
            </div>
        </div>
    </div>
    <div class="basket__modal modal_hidden" id="orderModal">
        <div class="basket__modal__overlay"></div>
        <div class="basket__modal__content">
            <img class="basket__modal__image"
                src="<?php echo esc_url(get_template_directory_uri()); ?>/img/png/earrings.png" alt="Product Image">
            <div class="basket__modal__form">
                <h2 class="basket__modal__title">Оформление заказа</h2>
                <p class="basket__modal__subtitle">Заполните информацию ниже и мы свяжемся с Вами как можно быстрее!</p>
                <form class="basket__modal__form-fields">
                    <div class="form-wrapp">
                        <input class="basket__modal__input" type="text" name="fio" placeholder="ФИО">
                        <input class="basket__modal__input" type="text" name="company" placeholder="Название компании">
                        <input class="basket__modal__input" type="text" name="phone" placeholder="Телефон для связи">
                        <input class="basket__modal__input" type="email" name="email" placeholder="Почта">
                    </div>
                    <input class="basket__modal__input full-adress" type="text" name="address"
                        placeholder="Полный адрес доставки">
                    <textarea class="basket__modal__textarea" name="message" placeholder="Ваше сообщение"></textarea>
                    <div class="wrapp-links-btn">
                        <div class="basket__modal__links">
                            <a class="basket__modal__link" href="">Политика конфиденциальности</a>
                            <a class="basket__modal__link" href="">Пользовательское соглашение</a>
                        </div>

                        <button class="basket__modal__submit" type="submit">Отправить</button>
                    </div>
                </form>
            </div>
            <button class="basket__modal__close" id="closeModal"><img
                    src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/close.svg"></button>
        </div>
    </div>
</section>