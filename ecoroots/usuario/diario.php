<?php
session_start();
include '../php/bd.php';

if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== 'usuario') {
    header("Location: ../usuario/login_usuario.html");
    exit;
}

$correo = $_SESSION['correo'];

// Consulta con JOIN para obtener el folio y el nombre de la planta
$sql = "SELECT a.folio, p.nombre AS planta_nombre 
        FROM adopciones a
        JOIN plantas p ON a.id_planta = p.id_planta
        WHERE a.correo = ? AND a.estado = 'aceptada'";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$res = $stmt->get_result();

$adopciones = [];
while ($row = $res->fetch_assoc()) {
    $adopciones[] = $row;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Diario de Plantas</title>
    <link rel="stylesheet" href="../css/diario.css">
</head>
<body>
    <div class="diario-container">
        <div class="sidebar">
            <h3>Mis adopciones</h3>
            <ul id="lista-adopciones">
                <?php foreach ($adopciones as $a): ?>
                    <li data-folio="<?= $a['folio'] ?>">
                        <?= htmlspecialchars($a['planta_nombre']) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="contenido">
            <div class="encabezado">
                <h2>Entradas del diario</h2>
                <button onclick="abrirFormulario()">➕ Nueva entrada</button>
            </div>
            <div id="entradas-container">
                <p>Selecciona una planta para ver sus entradas</p>
            </div>
        </div>
    </div>

    <div id="formulario-popup" class="oculto">
        <form action="../php/guardar_entrada.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="folio" id="folioSeleccionado">
            <textarea name="contenido" placeholder="Escribe tu entrada..." required></textarea>
            <input type="file" name="foto" accept="image/*">
            <button type="submit">Guardar entrada</button>
            <button type="button" onclick="cerrarFormulario()">Cancelar</button>
        </form>
    </div>

    <script src="../js/diario.js"></script>
    <script>
        // Agrega el listener una vez cargada la página
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('#lista-adopciones li').forEach(li => {
                li.addEventListener('click', () => {
                    const folio = li.getAttribute('data-folio');
                    console.log("mostrarEntradas se llamó con folio:", folio);
                    mostrarEntradas(folio);
                });
            });
        });
    </script>
</body>
</html>
