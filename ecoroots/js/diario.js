document.addEventListener('DOMContentLoaded', () => {
    // Agrega el evento a cada li una vez que el DOM está listo
    document.querySelectorAll('#lista-adopciones li').forEach(li => {
        li.addEventListener('click', () => {
            const folio = li.getAttribute('data-folio');
            console.log("mostrarEntradas se llamó con folio:", folio);
            
            // Quitar clase 'seleccionado' de todos
            document.querySelectorAll('#lista-adopciones li').forEach(item => {
                item.classList.remove('seleccionado');
            });
            // Agregar clase 'seleccionado' al clicado
            li.classList.add('seleccionado');

            mostrarEntradas(folio);
        });
    });
});

function mostrarEntradas(folio) {
    document.getElementById('folioSeleccionado').value = folio;

    fetch(`../php/get_entradas.php?folio=${folio}`)
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('entradas-container');
            container.innerHTML = '';
            if (data.length === 0) {
                container.innerHTML = '<p>No hay entradas todavía.</p>';
                return;
            }

            data.forEach(entrada => {
                const div = document.createElement('div');
                div.classList.add('entrada');
                div.innerHTML = `
                    <p><strong>Fecha:</strong> ${entrada.fecha}</p>
                    <p>${entrada.contenido}</p>
                    ${entrada.foto ? `<img src="../img/diarios/${entrada.foto}" alt="Foto">` : ''}
                `;
                container.appendChild(div);
            });
        })
        .catch(error => {
            console.error("Error al cargar entradas:", error);
            document.getElementById('entradas-container').innerHTML = '<p>Error al cargar entradas.</p>';
        });
}

function abrirFormulario() {
    document.getElementById('formulario-popup').style.display = 'block';
}

function cerrarFormulario() {
    document.getElementById('formulario-popup').style.display = 'none';
}
