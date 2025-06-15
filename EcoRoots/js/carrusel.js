window.addEventListener("DOMContentLoaded", () => {
    const carrusel = document.getElementById("carrusel");

    fetch("../php/mostrar_donadores.php")
        .then(response => response.json())
        .then(data => {
            carrusel.innerHTML = ""; // Limpia lo que había
            data.forEach(nombre => {
                const div = document.createElement("div");
                div.textContent = nombre;
                carrusel.appendChild(div);
            });
        })
        .catch(error => {
            console.error("Error al cargar donadores:", error);
        });
});
