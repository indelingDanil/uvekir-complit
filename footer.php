<section id="cart-modal" class="modal">
    <div class="modal-content">
        <p>Товар добавлен в корзину!</p>
        <button id="close-modal">Закрыть</button>
    </div>
</section>
<footer class="footer">
    <div class="footer__content">
        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/logo-main.svg" alt="Ювелир Комплит"
            class="footer__logo">
        <div class="footer__content-wrapper">
            <div class="footer__section--contact">
                <a href="<?php the_field("map_link", "option"); ?>">
                    <p class="footer__address"><img
                            src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/location.svg" alt="">
                        <?php the_field("map_text", "option"); ?> </p>
                </a>
                <a href="tel:<?php the_field("tel_link", "option"); ?>">
                    <p class="footer__phone"><img
                            src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/phone.svg"
                            alt=""><?php the_field("tel", "option"); ?></p>
                </a>
                <a href="mailto:<?php the_field("email", "option"); ?>">
                    <p class="footer__email"><img
                            src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/mail.svg"
                            alt=""><?php the_field("email", "option"); ?></p>
                </a>
                <div class="footer__social">
                    <a href="<?php the_field("whatsapp", "option"); ?>" class="footer__social-link"><img
                            src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/WhatsApp.svg"
                            alt="WhatsApp"></a>
                    <a href="<?php the_field("viber", "option"); ?>" class="footer__social-link"><img
                            src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/Viber.svg"
                            alt="Viber"></a>
                    <a href="<?php the_field("telegram", "option"); ?>" class="footer__social-link"><img
                            src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/Telegram.svg"
                            alt="Telegram"></a>
                    <a href="<?php the_field("vk", "option"); ?>" class="footer__social-link"><img
                            src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/VK.svg" alt="VK"></a>
                </div>
            </div>

            <div class="footer__section--client-info">
                <h3 class="footer__section-title">Информация для клиента</h3>
                <ul class="footer__list">
                    <?php if (have_rows('footer_links_info', 'option')): ?>
                        <?php while (have_rows('footer_links_info', 'option')):
                            the_row(); ?>
                            <?php
                            $link = get_sub_field('link');
                            if ($link):
                                $link_url = $link['url'];
                                $link_title = $link['title'];
                                $link_target = $link['target'] ? $link['target'] : '_self';
                                ?>
                                <li><a class="footer__link" href="<?php echo esc_url($link_url); ?>"
                                        target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
                                </li>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="footer__section--site-navigation">
                <h3 class="footer__section-title">Навигация по сайту</h3>
                <ul class="footer__list">
                    <?php if (have_rows('footer_links_nav', 'option')): ?>
                        <?php while (have_rows('footer_links_nav', 'option')):
                            the_row(); ?>
                            <?php
                            $link = get_sub_field('link');
                            if ($link):
                                $link_url = $link['url'];
                                $link_title = $link['title'];
                                $link_target = $link['target'] ? $link['target'] : '_self';
                                ?>
                                <li><a class="footer__link" href="<?php echo esc_url($link_url); ?>"
                                        target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
                                </li>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    <?php endif; ?>
                    <?php
                    // Получаем термины таксономии 'catalog_type'
                    $terms = get_terms(array(
                        'taxonomy' => 'catalog_type',
                        'hide_empty' => false, // Устанавливаем в false, чтобы показать все термины, даже если они не привязаны к постам
                    ));

                    if (!empty($terms) && !is_wp_error($terms)): ?>
                        <?php foreach ($terms as $term): ?>
                            <?php
                            // Получаем ссылку на архив термина
                            $term_link = get_term_link($term);

                            // Проверяем, что ссылка корректна
                            if (is_wp_error($term_link)) {
                                continue;
                            }
                            ?>
                            <li><a href="<?php echo esc_url($term_link); ?>" class="footer__link">
                                    <?php echo esc_html($term->name); ?>
                                </a></li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Термины таксономии не найдены.</p>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer__bottom">
        <div class="footer__bottom-content">
            <?php
            $link_policy = get_field('link_politika', "option");
            if ($link_policy):
                $link_url = $link_policy['url'];
                $link_title = $link_policy['title'];
                $link_target = $link_policy['target'] ? $link_policy['target'] : '_self';
                ?>
                <a class="footer__policy" href="<?php echo esc_url($link_url); ?>"
                    target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
            <?php endif; ?>
            <?php
            $link_terms = get_field('link_soglashenie', "option");
            if ($link_terms):
                $link_url = $link_terms['url'];
                $link_title = $link_terms['title'];
                $link_target = $link_terms['target'] ? $link_terms['target'] : '_self';
                ?>
                <a class="footer__terms" href="<?php echo esc_url($link_url); ?>"
                    target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
            <?php endif; ?>
            <p class="footer__copyright">© 2024 "Ювелир Комплит"</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>

</html>