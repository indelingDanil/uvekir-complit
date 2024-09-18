<?php require get_template_directory() . '/lib/flexible_blocks/main_page.php'; ?>
<section class="contacts">
    <div class="product_catalog__crumb">
        <a href="<?php echo home_url(); ?>">Главная</a>
        <?php breadcrumb_separator(); ?>
        <p style="color: #e8ab23;"><?php the_title(); ?></p>
    </div>
    <div class="frame">
        <div class="frame_constacts">
            <p><span class="label">Адрес:</span> <a href="<?php the_field("map_link", "option"); ?>"><?php the_field("map_text", "option"); ?></a></p>
            <p><span class="label">Номер телефона:</span> <a href="tel:<?php the_field("tel_link", "option"); ?>" class="info"><?php the_field("tel", "option"); ?></a>
            </p>
            <p><span class="label">Почта:</span> <a href="mailto:<?php the_field("email", "option"); ?>"
                    class="info"><?php the_field("email", "option"); ?></a></p>
            <p><span class="label">ИНН:</span> <span class="info">4400018465</span></p>
            <p><span class="label">КПП:</span> <span class="info">440001001</span></p>
            <p><span class="label">ОГРН:</span> <span class="info">1244400000602</span></p>
            <p><span class="label">График работы:</span> <span class="info">9.00 - 17.00</span></p>

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
        <iframe
            src="https://yandex.ru/map-widget/v1/?um=constructor%3A37a7144949b4597350fec0031f43190655184cd82e3538718efb8100a6e19f33&amp;source=constructor"
            width="100%" height="100%" frameborder="0">
        </iframe>

    </div>
</section>