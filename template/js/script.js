document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.querySelector(".main-sidebar");
    const closeBtn = document.querySelector(".close-sidebar");

    closeBtn.addEventListener("click", function () {
        sidebar.style.transform = "translateX(-230px)"; // Сдвигаем боковую панель за пределы видимости
    });
});