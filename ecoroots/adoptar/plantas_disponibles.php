<?php
session_start();
include '../php/bd.php';

// Verificar si está el usuario logueado y es rol usuario
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'usuario') {
    header('Location: ../usuario/login_usuario.html?error=debes_iniciar_sesion');
    exit;
}

$sql = "SELECT id_planta, 
                nombre, 
                descripcion,
                imagen FROM plantas
                where disponible = 0";
$result = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<title>Plantas Disponibles - EcoRoots</title>
<style>
  body { font-family: Arial, sans-serif; margin: 20px; }
  .plantas { display: flex; flex-wrap: wrap; gap: 20px; }
  .planta {
    border: 1px solid #ccc;
    border-radius: 6px;
    width: 250px;
    padding: 10px;
    box-shadow: 0 2px 6px #aaa;
  }
  .planta img {
    width: 100%;
    height: 160px;
    object-fit: cover;
    border-radius: 4px;
  }
  .planta h3 { margin: 10px 0 6px; }
  .planta p { font-size: 14px; height: 60px; overflow: hidden; }
  button {
    margin-top: 10px;
    background-color: #4caf50;
    border: none;
    color: white;
    padding: 8px 12px;
    border-radius: 4px;
    cursor: pointer;
    font-weight: bold;
  }
  button:hover { background-color: #388e3c; }

  /* Modales */
  .modal {
    display: none;
    position: fixed;
    z-index: 999;
    left: 0; top: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.6);
  }
  .modal-content {
    background: white;
    margin: 100px auto;
    padding: 20px;
    width: 90%;
    max-width: 500px;
    border-radius: 8px;
    box-shadow: 0 0 15px #0003;
  }
  .modal-content h2 {
    margin-top: 0;
    color: #2e7d32;
  }
  .modal-content button {
    margin-right: 10px;
  }
  .modal-content label {
    display: block;
    margin-top: 12px;
  }
</style>
</head>
<body>

<h1>Plantas Disponibles para Adoptar</h1>

<div class="plantas">
  <?php while($row = $result->fetch_assoc()): ?>
  <div class="planta">
    <img src="../imagenes/<?php echo htmlspecialchars($row['imagen']); ?>" alt="<?php echo htmlspecialchars($row['nombre']); ?>" />
    <h3><?php echo htmlspecialchars($row['nombre']); ?></h3>
    <p><?php echo htmlspecialchars($row['descripcion']); ?></p>
    <button onclick="abrirModal(<?php echo $row['id_planta']; ?>)">Adoptar</button>
  </div>
  <?php endwhile; ?>
</div>

<!-- Modal Mensaje -->
<div id="modalMensaje" class="modal">
  <div class="modal-content">
    <h2>Importante</h2>
    <p>Ten en consideración que debes conocer cómo cuidar correctamente la planta antes de adoptarla.</p>
    <button onclick="mostrarCuestionario()">Continuar</button>
    <button onclick="cerrarModal()">Cancelar</button>
  </div>
</div>

<!-- Modal Cuestionario -->
<div id="modalCuestionario" class="modal">
  <div class="modal-content">
    <h2>Cuestionario de Conocimientos Básicos</h2>
    <form id="formCuestionario" action="adoptar.php" method="POST">
      <input type="hidden" name="id_planta" id="id_planta_input" value="" />

      <label>¿Cada cuánto riegas esta planta?</label>
      <select name="pregunta1" required>
        <option value="">Selecciona una opción</option>
        <option value="Una vez por semana">Una vez por semana</option>
        <option value="Cada dos días">Cada dos días</option>
        <option value="Solo cuando la tierra esté seca">Solo cuando la tierra esté seca</option>
      </select>

      <label>¿Dónde debe estar ubicada la planta?</label>
      <select name="pregunta2" required>
        <option value="">Selecciona una opción</option>
        <option value="A pleno sol">A pleno sol</option>
        <option value="A media sombra">A media sombra</option>
        <option value="En un lugar oscuro">En un lugar oscuro</option>
      </select>

      <div style="margin-top:15px;">
        <button type="submit">Enviar solicitud</button>
        <button type="button" onclick="cerrarModal()">Cancelar</button>
      </div>
    </form>
  </div>
</div>

<script src="../js/adoptar.js"></script>

</body>
</html>
