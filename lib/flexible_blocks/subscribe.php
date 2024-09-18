<section class="subscribe">
    <div class="subscribe__content">
        <div class="subscribe__text">
            <h2 class="subscribe__title"><?php the_field("titile_subscribe", "option") ?></h2>
            <p class="subscribe__description"><?php the_field("subtitle_subscribe", "option") ?></p>
        </div>
        <form class="subscribe__form">
            <input type="email" class="subscribe__input" placeholder="Ваш email">
            <button type="submit" class="subscribe__button">Отправить</button>
        </form>
    </div>
    <div class="subscribe__image">
        <img src="<?php the_field("img_subscribe", "option") ?>">
    </div>
</section>