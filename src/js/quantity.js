document.addEventListener("DOMContentLoaded", function () {
  document
    .querySelectorAll(".new_products__cart-quantity-wrapper")
    .forEach((control) => {
      const quantityInput = control.querySelector(
        ".new_products__cart-quantity"
      );
      const increaseButton = control.querySelector(".increase-button");
      const decreaseButton = control.querySelector(".decrease-button");

      increaseButton.addEventListener("click", () => {
        let currentValue = parseInt(quantityInput.value, 10);
        quantityInput.value = currentValue + 1;
      });

      decreaseButton.addEventListener("click", () => {
        let currentValue = parseInt(quantityInput.value, 10);
        if (currentValue > 1) {
          quantityInput.value = currentValue - 1;
        }
      });
    });
});
