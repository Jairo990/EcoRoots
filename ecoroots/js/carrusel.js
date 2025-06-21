window.addEventListener("DOMContentLoaded", () => {
    const carrusel = document.getElementById("carrusel");

    fetch("../php/mostrar_donadores.php")
    .then(res => res.json())
    .then(data => {
        if(data.error) {
            carrusel.textContent = "Error al cargar donadores: " + data.error;
            return;
        }

        // Limpiar contenido previo
        carrusel.innerHTML = "";

        // Crear elementos para cada donador
        data.forEach(donador => {
            const div = document.createElement("div");
            div.classList.add("donador");
            const msg = donador.mensaje.trim() === "" ? "Gracias por apoyar." : donador.mensaje;
            div.innerHTML = `<strong>${donador.nombre}</strong><p>${msg}</p>`;
            carrusel.appendChild(div);
        });

        // Clonar el contenido para el scroll infinito
        const contenidoOriginal = carrusel.innerHTML;
        carrusel.innerHTML += contenidoOriginal;

        // Variables de animación
        let scrollY = 0;
        const velocidad = 0.5; // píxeles por frame, ajusta para velocidad

        // Altura total del contenido (la mitad es la original)
        const alturaContenido = carrusel.scrollHeight / 2;

        function animarScroll() {
            scrollY += velocidad;
            if(scrollY >= alturaContenido) {
                scrollY = 0; // Resetea sin salto
            }
            carrusel.style.transform = `translateY(-${scrollY}px)`;
            requestAnimationFrame(animarScroll);
        }

        animarScroll();
    })
    .catch(err => {
        carrusel.textContent = "Error al cargar donadores.";
        console.error(err);
    });
});
