const cartItemsContainer = document.querySelector(".basket__items");
const totalQuantityElement = document.querySelectorAll(".cart-badge");

export function getCart() {
  const cart = localStorage.getItem("cart");
  return cart ? JSON.parse(cart) : [];
}

export function saveCart(cart) {
  localStorage.setItem("cart", JSON.stringify(cart));
  updateQuantity(totalQuantityElement);
}

function updateQuantity(count) {
  const cart = getCart();
  const totalQuantity = cart.reduce((sum, item) => sum + item.quantity, 0);
  if (count) {
    count.textContent = `${totalQuantity}`;
  }
  if (totalQuantityElement) {
    totalQuantityElement.forEach((el) => {
      el.textContent = `${totalQuantity}`;
    });
  }
}

export function updateCartDisplay(cart) {
  if (!cartItemsContainer) return; // Проверка наличия контейнера корзины
  cartItemsContainer.innerHTML = "";
  const allProducts = document.querySelectorAll(".all_products");

  allProducts.forEach((product) => {
    updateQuantity(product);
  });

  cart.forEach((item, index) => {
    const basketItemHTML = `
          <div class="basket__item" data-index="${index}">
            <div class="basket__item-info">
              <input type="checkbox" class="basket__item-checkbox" data-index="${index}">
              <img src="${item.imageSrc}" alt="${item.name}" class="basket__item-image">
              <h3 class="basket__item-title">${item.name}</h3>
            </div>
            <div class="basket__item-controls">
              <a href="${item.detailsUrl}" class="new_products__btn">
                <img src="https://uvelir-complit.indeling.ru/wp-content/uploads/2024/09/reply.svg" alt="Подробнее">Подробнее
              </a>
              <button class="basket-delet-card-btn" data-index="${index}">
                <img src="https://uvelir-complit.indeling.ru/wp-content/uploads/2024/09/delete-btn.svg" alt="Удалить">
              </button>
              <div class="new_products__cart-quantity-wrapper">
                <input type="number" class="new_products__cart-quantity" value="${item.quantity}" min="1">
                <div class="new_products__quantity-buttons">
                  <button class="new_products__quantity-button increase-button">
                    <img src="https://uvelir-complit.indeling.ru/wp-content/uploads/2024/09/arrow_up.svg" alt="Increase">
                  </button>
                  <button class="new_products__quantity-button decrease-button">
                    <img src="https://uvelir-complit.indeling.ru/wp-content/uploads/2024/09/arrow_up.svg" alt="Decrease">
                  </button>
                </div>
              </div>
            </div>
          </div>
        `;
    cartItemsContainer.insertAdjacentHTML("beforeend", basketItemHTML);
  });

  attachQuantityButtonsEvents();
  attachDeleteButtonsEvents(); // Подключаем обработчики для кнопок удаления
}

function attachQuantityButtonsEvents() {
  const increaseButtons = document.querySelectorAll(".increase-button");
  const decreaseButtons = document.querySelectorAll(".decrease-button");

  increaseButtons.forEach((button, index) => {
    button.addEventListener("click", function () {
      updateItemQuantity(index, 1);
    });
  });

  decreaseButtons.forEach((button, index) => {
    button.addEventListener("click", function () {
      updateItemQuantity(index, -1);
    });
  });

  const quantityInputs = document.querySelectorAll(
    ".new_products__cart-quantity"
  );
  quantityInputs.forEach((input, index) => {
    input.addEventListener("change", function () {
      const newQuantity = parseInt(input.value, 10);
      updateItemQuantity(index, 0, newQuantity);
    });
  });
}

function attachDeleteButtonsEvents() {
  const deleteButtons = document.querySelectorAll(".basket-delet-card-btn");

  deleteButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const index = parseInt(button.getAttribute("data-index"));
      removeItemFromCart(index); // Удаление элемента из корзины
    });
  });
}

function removeItemFromCart(index) {
  const cart = getCart();
  cart.splice(index, 1); // Удаляем элемент по индексу
  saveCart(cart); // Сохраняем обновлённую корзину
  updateCartDisplay(cart); // Обновляем отображение корзины
}

function updateItemQuantity(index, change, newQuantity = null) {
  const cart = getCart();

  if (newQuantity !== null) {
    cart[index].quantity = newQuantity > 0 ? newQuantity : 1;
  } else {
    cart[index].quantity += change;
    if (cart[index].quantity < 1) {
      cart[index].quantity = 1;
    }
  }

  saveCart(cart);
  updateCartDisplay(cart);
}

updateQuantity(totalQuantityElement);
updateCartDisplay(getCart());

const selectAllButton = document.querySelector(".basket__select-all-btn");
const selectAllCheckbox = document.querySelector(".basket__select-all");

if (selectAllButton && selectAllCheckbox) {
  selectAllButton.addEventListener("click", function (event) {
    event.preventDefault();
    selectAllCheckbox.checked = !selectAllCheckbox.checked;

    const itemCheckboxes = document.querySelectorAll(".basket__item-checkbox");
    itemCheckboxes.forEach((checkbox) => {
      checkbox.checked = selectAllCheckbox.checked;
    });
  });

  selectAllCheckbox.addEventListener("change", function () {
    const itemCheckboxes = document.querySelectorAll(".basket__item-checkbox");
    itemCheckboxes.forEach((checkbox) => {
      checkbox.checked = this.checked;
    });
  });
}

const removeSelectedButton = document.querySelector(".basket__remove-selected");
if (removeSelectedButton) {
  removeSelectedButton.addEventListener("click", function () {
    let cart = getCart();
    const selectedCheckboxes = Array.from(
      document.querySelectorAll(".basket__item-checkbox:checked")
    );

    selectedCheckboxes.reverse().forEach((checkbox) => {
      const index = parseInt(checkbox.getAttribute("data-index"));
      cart.splice(index, 1);
    });

    saveCart(cart);
    updateCartDisplay(cart);
  });
}

const checkoutButton = document.getElementById("checkout");
if (checkoutButton) {
  checkoutButton.addEventListener("click", function () {
    const cart = getCart();
    if (cart.length === 0) {
      console.log("Корзина пуста!");
      return;
    }

    const orderDetails = cart
      .map((item) => `${item.name} - Количество: ${item.quantity}`)
      .join("\n");

    alert(`Ваш заказ:\n${orderDetails}`);

    localStorage.removeItem("cart");
    updateCartDisplay([]);
  });
}

const cartButtons = document.querySelectorAll(".new_products__cart-btn");
if (cartButtons.length > 0) {
  cartButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const productElement = this.closest(".products-card");

      const name = productElement.querySelector(".product-name").textContent;
      const imageSrc = productElement.querySelector(".product-image").src;
      const detailsUrl = productElement.querySelector(".link-to-product").href;
      const quantityInput = productElement.querySelector(".product-quantity");
      const quantity = parseInt(quantityInput.value) || 1;

      const cart = getCart();

      const existingItemIndex = cart.findIndex((item) => item.name === name);
      if (existingItemIndex > -1) {
        cart[existingItemIndex].quantity += quantity;
      } else {
        cart.push({ name, imageSrc, detailsUrl, quantity });
      }

      saveCart(cart);
      if (cartItemsContainer) {
        updateCartDisplay(cart);
      }

      showModal();
    });
  });
}
//Модальное окно, вёрстка в подвале)
const modal = document.getElementById("cart-modal");
const closeModalButton = document.getElementById("close-modal");

function showModal() {
  modal.classList.add("show");
  setTimeout(() => {
    hideModal();
  }, 1000);
}

function hideModal() {
  modal.style.opacity = "0";
  setTimeout(() => {
    modal.classList.remove("show");
    modal.style.opacity = "";
  }, 500);
}

closeModalButton.addEventListener("click", function () {
  hideModal();
});
