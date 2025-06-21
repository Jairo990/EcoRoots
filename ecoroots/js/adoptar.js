let plantaSeleccionada = null;

function abrirModal(idPlanta) {
  plantaSeleccionada = idPlanta;
  document.getElementById('modalMensaje').style.display = 'block';
}

function cerrarModal() {
  document.getElementById('modalMensaje').style.display = 'none';
  document.getElementById('modalCuestionario').style.display = 'none';
}

function mostrarCuestionario() {
  document.getElementById('modalMensaje').style.display = 'none';
  document.getElementById('id_planta_input').value = plantaSeleccionada;
  document.getElementById('modalCuestionario').style.display = 'block';
}

window.onclick = function(event) {
  const modalMensaje = document.getElementById('modalMensaje');
  const modalCuestionario = document.getElementById('modalCuestionario');
  if (event.target === modalMensaje) cerrarModal();
  if (event.target === modalCuestionario) cerrarModal();
}
