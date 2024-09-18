<section class="about_company">
    <div class="about_company__content">
        <h2 class="about_company__title"><?php the_sub_field("title") ?></h2>
        <p class="about_company__subtitle"><?php the_sub_field("subtitle") ?></p>
        <div class="about_company__content-wrapper">
            <div class="about_company__left">
                <div class="about_company__text">
                    <?php the_sub_field("info") ?>
                </div>
                <img src="<?php the_sub_field("img") ?>" alt="Jewelry" class="about_company__image">
            </div>
            <div class="about_company__right">
                <div class="timeline">
                    <?php if (have_rows('reparter_info')): ?>
                        <?php while (have_rows('reparter_info')):
                            the_row(); ?>
                            <div class="timeline__item">
                                <p class="timeline__year"><?php the_sub_field("god") ?></p>
                                <p class="timeline__text"><?php the_sub_field("info") ?></p>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>