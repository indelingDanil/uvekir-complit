jQuery(function ($) {
  let canBeLoaded = true;
  let offset = 9; // начальное количество загруженных постов

  $(".new_products__view-all").click(function () {
    if (canBeLoaded) {
      let button = $(this);
      let data = {
        action: "load_more_products",
        paged: load_more_params.current_page,
        nonce: load_more_params.nonce,
        term_slug: load_more_params.term_slug,
        offset: offset, // передаем количество загруженных постов
      };

      $.ajax({
        url: load_more_params.ajaxurl,
        data: data,
        type: "POST",
        beforeSend: function (xhr) {
          canBeLoaded = false;
          button.text("Загрузка...");
        },
        success: function (data) {
          if (data === "end") {
            button.text("Товаров больше нет");
          } else {
            $(".new_products__grid").append(data);
            load_more_params.current_page++;
            offset += 6; // увеличиваем смещение на количество загруженных постов
            canBeLoaded = true;
            button.text("Загрузить еще");
          }
        },
      });
    }
  });
});
