document.addEventListener("DOMContentLoaded", () => {
    const container = document.querySelector('.trust-us__logos');

    // Проверяем, существует ли элемент с классом .trust-us__logos на странице
    if (container) {
        const scrollContainer = document.createElement('div');
        scrollContainer.classList.add('scroll-container');

        // Клонируем все логотипы для бесконечной прокрутки
        const logos = container.innerHTML;
        scrollContainer.innerHTML = `${logos}${logos}`; // Клонируем изображения

        container.innerHTML = '';
        container.appendChild(scrollContainer);

        const logosElements = container.querySelectorAll('.trust-us__logo');
        const logoWidth = logosElements[0].offsetWidth;
        const totalWidth = (logoWidth + 20) * logosElements.length;

        // Устанавливаем скорость прокрутки
        const animationDuration = totalWidth / 300; // Скорость можно настраивать

        scrollContainer.style.display = 'flex';
        scrollContainer.style.animation = `scroll ${animationDuration}s linear infinite`;

        // Добавляем ключевые кадры для анимации через JS
        const styleSheet = document.styleSheets[0]; 
        styleSheet.insertRule(`
            @keyframes scroll {
                0% { transform: translateX(0); }
                100% { transform: translateX(-${totalWidth / 2}px); }
            }
        `, styleSheet.cssRules.length);
    }
});