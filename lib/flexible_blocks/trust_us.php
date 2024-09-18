<section class="trust-us">
    <h2 class="trust-us__title"><?php the_field("title_trust_us", "option") ?></h2>
    <p class="trust-us__subtitle"><?php the_field("subtitle_trust_us", "option") ?></p>
    <div class="trust-us__logos">
        <?php if (have_rows('reparter_trust_us', 'option')): ?>
            <?php while (have_rows('reparter_trust_us', 'option')):
                the_row(); ?>
                <?php
                $img = get_sub_field('img'); // Получаем URL изображения из вложенного поля img
                ?>
                <div class="trust-us__logo">
                    <img src="<?php echo esc_url($img); ?>" alt="Trust Us Logo">
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
    <p class="trust-us__more"><?php the_field("info_trust_us", "option") ?></p>
</section>