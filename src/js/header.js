document.addEventListener("DOMContentLoaded", () => {
  // Находим элементы header, header_top, header_bottom, wrapper и первый элемент section внутри wrapper
  const header = document.querySelector(".header");
  const headerTop = document.querySelector(".header_top");
  const headerBottom = document.querySelector(".header_bottom");
  const wrapper = document.querySelector(".wrapper");
  const firstSection = wrapper.querySelector("section");

  // Проверяем, что все элементы существуют
  if (window.innerWidth >= 980 && header && headerTop && headerBottom && wrapper && firstSection) {
    // Получаем высоту header
    const headerHeight = header.offsetHeight;

    // Устанавливаем padding-top у первого элемента section на высоту header
      firstSection.style.paddingTop = `${headerHeight}px`;
    // Устанавливаем начальный top у header равный 0 и добавляем плавный переход
    header.style.top = "0";
    header.style.transition = "top 0.2s ease-out";
  }

  // Обработчик скролла
  const handleScroll = () => {
    if (window.innerWidth >= 980) {
      // Проверяем ширину экрана
      if (window.scrollY >= 80) {
        // Сдвигаем header вверх на высоту headerTop
        header.style.top = `-${headerTop.offsetHeight}px`;
        headerBottom.classList.add("active");
      } else {
        // Возвращаем header на место
        header.style.top = "0";
        headerBottom.classList.remove("active");
      }
    } else {
      // Если ширина экрана больше 980px, сбрасываем положение header
      header.style.top = "0";
      headerBottom.classList.remove("active");
    }
  };

  window.addEventListener("scroll", handleScroll);
  window.addEventListener("resize", handleScroll); // Перепроверяем при изменении размера окна
});

document.addEventListener("DOMContentLoaded", function () {
  // Проверяем ширину экрана при загрузке страницы
  if (window.innerWidth < 980) {
    // Находим все элементы с классом visible-input
    const visibleInputs = document.querySelectorAll(".visible-input");

    visibleInputs.forEach(function (input) {
      input.addEventListener("click", function () {
        // Находим родительский элемент с классом search-item_mob
        const parent = input.closest(".search-item_mob");
        if (input) {
          input.classList.toggle("active");
        }
        // Если родитель найден, добавляем класс active к элементам внутри
        if (parent) {
          const searchInput = parent.querySelector(".search-input");
          const buttonSubmit = parent.querySelector(".button-submit");

          if (searchInput) {
            searchInput.classList.toggle("active");
          }

          if (buttonSubmit) {
            buttonSubmit.classList.toggle("active");
          }
        }
      });
    });
  }
});
