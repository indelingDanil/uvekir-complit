import { getCart, saveCart, updateCartDisplay } from "./cart";
document.addEventListener("DOMContentLoaded", function () {
  const favoritesItemsContainer = document.querySelector(".favorites__items");
  const totalFavoritesElement = document.querySelector(
    ".all_products-favorites"
  );
  const favoritesBadge = document.querySelectorAll(".favorites-badge");

  function getFavorites() {
    const favorites = localStorage.getItem("favorites");
    return favorites ? JSON.parse(favorites) : [];
  }

  function saveFavorites(favorites) {
    localStorage.setItem("favorites", JSON.stringify(favorites));
    updateFavoritesQuantity(totalFavoritesElement);
    updateFavoritesDisplay(favorites);
    initializeHeartButtons();
  }

  function updateFavoritesQuantity(count) {
    const favorites = getFavorites();
    const totalFavorites = favorites.length;
    if (count) {
      count.textContent = `${totalFavorites}`;
    }
    if (favoritesBadge) {
      favoritesBadge.forEach((el) => {
        el.textContent = totalFavorites;
      });
    }
  }

  function updateFavoritesDisplay(favorites) {
    if (!favoritesItemsContainer) return;
    favoritesItemsContainer.innerHTML = "";

    favorites.forEach((item, index) => {
      const favoriteItemHTML = `
                <div class="favorites__item" data-index="${index}">
                  <div class="basket__item-info">
                    <input type="checkbox" class="favorites__item-checkbox" data-index="${index}">
                    <img src="${item.imageSrc}" alt="${item.name}" class="basket__item-image">
                    <h3 class="basket__item-title">${item.name}</h3>
                  </div>
                  <div class="basket__item-controls">
                    <a href="${item.detailsUrl}" class="new_products__btn"><img src="https://uvelir-complit.indeling.ru/wp-content/uploads/2024/09/reply.svg" alt="Подробнее">
                    Подробнее</a>
                      <button class="favorites-heart active-heart" data-index="${index}">
                      <svg class="heart-img" width="29.167206" height="26.957275" viewBox="0 0 29.1672 26.9573" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.58 2.22C18.01 -0.85 23.3 -0.75 26.6 2.56C29.9 5.86 30.01 11.13 26.94 14.57L14.58 26.95L2.21 14.57C-0.86 11.13 -0.74 5.86 2.56 2.56C5.86 -0.74 11.14 -0.86 14.58 2.22L14.58 2.22ZM24.53 4.62C22.35 2.43 18.82 2.34 16.53 4.39L14.58 6.14L12.63 4.4C10.34 2.34 6.81 2.43 4.62 4.62C2.45 6.79 2.34 10.27 4.34 12.57L14.58 22.82L24.82 12.57C26.82 10.27 26.71 6.8 24.53 4.62L24.53 4.62Z" fill="#6A6A6A" />
                  </svg>
                    </button>
                    <button class="new_products__cart-btn" data-index="${index}">
                    <img src="https://uvelir-complit.indeling.ru/wp-content/uploads/2024/09/products_cart.svg" alt="cart">
                  </button>
                  </div>
                </div>
              `;
      favoritesItemsContainer.insertAdjacentHTML("beforeend", favoriteItemHTML);
    });
    attachCartButtonsEvents();
    attachDeleteButtonsEvents();
  }

  function attachCartButtonsEvents() {
    const cartButtons = document.querySelectorAll(".new_products__cart-btn");

    cartButtons.forEach((button) => {
      button.addEventListener("click", function () {
        const index = parseInt(button.getAttribute("data-index"));
        const favorites = getFavorites();
        const item = favorites[index]; // Получаем товар из избранного

        const cart = getCart();
        const existingItemIndex = cart.findIndex(
          (cartItem) => cartItem.name === item.name
        );

        if (existingItemIndex > -1) {
          cart[existingItemIndex].quantity += 1; // Увеличиваем количество, если товар уже есть в корзине
        } else {
          cart.push({ ...item, quantity: 1 }); // Добавляем товар в корзину
        }

        saveCart(cart); // Сохраняем корзину
        updateCartDisplay(cart); // Обновляем отображение корзины, если нужно
      });
    });
  }

  const favoritesSelectAllButton = document.querySelector(
    ".favorites__select-all-btn"
  );
  const favoritesselectAllCheckbox = document.querySelector(
    ".favorites__select-all"
  );

  if (favoritesSelectAllButton && favoritesselectAllCheckbox) {
    favoritesSelectAllButton.addEventListener("click", function (event) {
      event.preventDefault();
      favoritesselectAllCheckbox.checked = !favoritesselectAllCheckbox.checked;

      const itemCheckboxes = document.querySelectorAll(
        ".favorites__item-checkbox"
      );
      itemCheckboxes.forEach((checkbox) => {
        checkbox.checked = favoritesselectAllCheckbox.checked;
      });
    });

    favoritesselectAllCheckbox.addEventListener("change", function () {
      const itemCheckboxes = document.querySelectorAll(
        ".favorites__item-checkbox"
      );
      itemCheckboxes.forEach((checkbox) => {
        checkbox.checked = this.checked;
      });
    });
  }
  function attachDeleteButtonsEvents() {
    const deleteButtons = document.querySelectorAll(".favorites-heart");

    deleteButtons.forEach((button) => {
      button.addEventListener("click", function () {
        const index = parseInt(button.getAttribute("data-index"));
        removeItemFromFavorites(index); // Удаление элемента из корзины
      });
    });
  }

  function removeItemFromFavorites(index) {
    const favorites = getFavorites();
    favorites.splice(index, 1); // Удаляем элемент по индексу
    saveFavorites(favorites); // Сохраняем обновлённую корзину
    updateFavoritesDisplay(favorites); // Обновляем отображение корзины
  }

  const removeSelectedButton = document.querySelector(
    ".favorites__remove-selected"
  );
  if (removeSelectedButton) {
    removeSelectedButton.addEventListener("click", function () {
      let favories = getFavorites();
      const selectedCheckboxes = Array.from(
        document.querySelectorAll(".favorites__item-checkbox:checked")
      );
      selectedCheckboxes.reverse().forEach((checkbox) => {
        const index = parseInt(checkbox.getAttribute("data-index"));
        favories.splice(index, 1);
      });

      saveFavorites(favories);
      updateFavoritesDisplay(favories);
    });
  }

  function initializeHeartButtons() {
    const productHeartButtons = document.querySelectorAll(
      ".favorites-heart-btn"
    );

    productHeartButtons.forEach((button) => {
      const productElement = button.closest(".products-card");
      const name = productElement.querySelector(".product-name").textContent;
      const favorites = getFavorites();
      const isInFavorites = favorites.some((item) => item.name === name);

      if (isInFavorites) {
        button.classList.add("active-heart");
      }

      button.addEventListener("click", function () {
        const imageSrc = productElement.querySelector(".product-image").src;
        const detailsUrl =
          productElement.querySelector(".link-to-product").href;

        const existingItemIndex = favorites.findIndex(
          (item) => item.name === name
        );

        if (existingItemIndex > -1) {
          favorites.splice(existingItemIndex, 1);
          button.classList.remove("active-heart");
        } else {
          favorites.push({ name, imageSrc, detailsUrl });
          button.classList.add("active-heart");
        }

        saveFavorites(favorites);
      });
    });
  }

  updateFavoritesQuantity(totalFavoritesElement);
  updateFavoritesDisplay(getFavorites());
  initializeHeartButtons();
});
