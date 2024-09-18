document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById("orderModal");
  if (modal) {
    const openModalButton = document.querySelector(".basket__checkout-button");
    const closeModalButton = document.getElementById("closeModal");
    openModalButton.addEventListener("click", function () {
      modal.classList.remove("modal_hidden");
    });
    closeModalButton.addEventListener("click", function () {
      modal.classList.add("modal_hidden");
    });
    modal.addEventListener("click", function (event) {
      if (event.target === modal) {
        modal.classList.add("modal_hidden");
      }
    });
  }
});
