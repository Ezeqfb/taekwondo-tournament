document.addEventListener("DOMContentLoaded", function () {
    var loader = document.getElementById("loader");

    // Mostrar el cargador
    loader.style.opacity = "1";
    loader.style.display = "flex";

    // Ocultar el cargador después de 3 segundos
    setTimeout(function () {
        loader.style.opacity = "0";
        setTimeout(function () {
            loader.style.display = "none";
        }, 500);
    }, 330);
});