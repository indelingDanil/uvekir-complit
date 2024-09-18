import { updateCartDisplay } from "./cart";

function sendToTelegram(message) {
  const botToken = "7359845136:AAG5Vk6uzGw7xoIghd1TWIyN9L2fhGTUZ70";
  const chatId = "-4593361049";
  const apiUrl = `https://api.telegram.org/bot${botToken}/sendMessage`;

  const payload = {
    chat_id: chatId,
    text: message,
    parse_mode: "HTML",
  };

  console.log("Отправка сообщения в Telegram:", payload);

  return fetch(apiUrl, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(payload),
  })
    .then((response) => {
      console.log("Ответ от Telegram:", response);
      return response.json();
    })
    .catch((error) => {
      console.error("Ошибка при отправке сообщения в Telegram:", error);
      throw error;
    });
}

function getBasketData() {
  const basketData = JSON.parse(localStorage.getItem("cart"));
  let itemsMessage = "";

  if (basketData && basketData.length > 0) {
    basketData.forEach((item) => {
      itemsMessage += `<b>Товар:</b> ${item.name}\n<b>Количество:</b> ${item.quantity}\n<b>Ссылка:</b> ${item.detailsUrl}\n\n`;
    });
  } else {
    itemsMessage = "Корзина пуста";
  }

  return itemsMessage;
}

function sendToEmail(name, email, fullMessage) {
  console.log("Отправка письма на email:", { name, email, fullMessage });
  const apiUrl = wpApiSettings.apiUrl;
  const payload = {
    name: name,
    email: email,
    message: fullMessage,
  };

  return fetch(apiUrl, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-WP-Nonce": wpApiSettings.nonce, // Используем локализованный nonce
    },
    body: JSON.stringify(payload),
  })
    .then((response) => {
      console.log("Ответ от API отправки email:", response);
      return response.json(); // Обработка JSON
    })
    .catch((error) => {
      console.error("Ошибка при отправке email:", error);
      throw error;
    });
}

document
  .querySelector(".basket__modal__form-fields")
  .addEventListener("submit", function (event) {
    event.preventDefault();

    const submitButton = document.querySelector(".basket__modal__submit");
    const notification = document.createElement("div");
    notification.style.marginTop = "10px";
    notification.style.fontSize = "14px";

    submitButton.disabled = true;
    submitButton.innerHTML = "Отправляем...";

    const formData = new FormData(event.target);
    const name = formData.get("fio");
    const company = formData.get("company");
    const phone = formData.get("phone");
    const email = formData.get("email");
    const address = formData.get("address");
    const message = formData.get("message");

    let fullMessage = `<b>Данные пользователя:</b>\n`;
    fullMessage += `<b>ФИО:</b> ${name}\n`;
    fullMessage += `<b>Компания:</b> ${company}\n`;
    fullMessage += `<b>Телефон:</b> ${phone}\n`;
    fullMessage += `<b>Почта:</b> ${email}\n`;
    fullMessage += `<b>Адрес:</b> ${address}\n`;
    fullMessage += `<b>Сообщение:</b> ${message}\n\n`;
    fullMessage += `<b>Корзина:</b>\n`;
    fullMessage += getBasketData();

    sendToTelegram(fullMessage)
      .then((data) => {
        if (data.ok) {
          return sendToEmail(name, email, fullMessage);
        } else {
          throw new Error("Ошибка отправки в Telegram");
        }
      })
      .then((emailResponse) => {
        console.log("Email response:", emailResponse); // Для отладки
        if (emailResponse.success === true) {
          // Строгое сравнение
          notification.innerHTML =
            '<span style="color: green;">Ваше сообщение успешно отправлено!</span>';
          event.target.reset();
          localStorage.removeItem("cart");
          updateCartDisplay();
        } else {
          console.error("Fetch error:", error); // Для отладки
          notification.innerHTML =
            '<span style="color: red;">Ваше сообщение не было доставлено. Обратитесь по номеру телефона или email.</span>';
        }
      })
      .finally(() => {
        submitButton.innerHTML = "Отправить";
        submitButton.disabled = false;
        submitButton.parentNode.appendChild(notification);
      });
  });
