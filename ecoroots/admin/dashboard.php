<?php
session_start();
include '../php/bd.php';

// Verificar sesión admin
if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../admin/login_admin.html");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Actualizar estado de solicitud
    if (isset($_POST['folio'], $_POST['nuevo_estado'])) {
        $folio = intval($_POST['folio']);
        $nuevo_estado = $_POST['nuevo_estado'];

        $estados_validos = ['pendiente', 'aceptada', 'rechazada'];
        if (in_array($nuevo_estado, $estados_validos)) {
            // Obtener id_planta
            $stmt_planta = $conexion->prepare("SELECT id_planta FROM adopciones WHERE folio = ?");
            $stmt_planta->bind_param("i", $folio);
            $stmt_planta->execute();
            $res = $stmt_planta->get_result();
            $id_planta = $res->fetch_assoc()['id_planta'] ?? null;

            // Actualizar estado
            $stmt_update = $conexion->prepare("UPDATE adopciones SET estado = ? WHERE folio = ?");
            $stmt_update->bind_param("si", $nuevo_estado, $folio);

            if ($stmt_update->execute() && $id_planta !== null) {
                // Actualizar disponible de la planta
                $disponible = ($nuevo_estado === 'aceptada') ? 1 : 0;
                $stmt_disp = $conexion->prepare("UPDATE plantas SET disponible = ? WHERE id_planta = ?");
                $stmt_disp->bind_param("ii", $disponible, $id_planta);
                $stmt_disp->execute();

                $mensaje = "Estado actualizado correctamente.";
            } else {
                $error = "Error al actualizar solicitud.";
            }
        } else {
            $error = "Estado no válido.";
        }
    }

    // novo
    if (isset($_POST['nombre_planta'], $_POST['descripcion']) && isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $nombrePlanta = $_POST['nombre_planta'];
        $descripcion = $_POST['descripcion'];
        $nombreArchivo = time() . "_" . basename($_FILES['foto']['name']);
        $rutaDestino = "../img/uploads/" . $nombreArchivo;

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $rutaDestino)) {
            $rutaRelativa = "uploads/" . $nombreArchivo;
            $stmt_planta = $conexion->prepare("INSERT INTO plantas (nombre, imagen, descripcion, disponible) VALUES (?, ?, ?, 0)");
            $stmt_planta->bind_param("sss", $nombrePlanta, $rutaRelativa, $descripcion);
            if ($stmt_planta->execute()) {
                $mensaje = "Nueva planta agregada correctamente.";
            } else {
                $error = "Error al guardar planta: " . $stmt_planta->error;
            }
        } else {
            $error = "Error al subir la imagen.";
        }
    }
}

// Obtener todas las solicitudes
$stmt = $conexion->prepare("SELECT a.folio, a.fecha_solicitud, a.correo, a.estado, a.id_planta, p.nombre AS nombre_planta 
                            FROM adopciones a 
                            INNER JOIN plantas p ON a.id_planta = p.id_planta
                            ORDER BY a.fecha_solicitud DESC");
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Administrar Solicitudes - EcoRoots</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 900px; margin: 20px auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 8px; border: 1px solid #ccc; text-align: left; }
        th { background-color: #4caf50; color: white; }
        form { margin: 0; }
        select, input[type="text"], input[type="file"], textarea { padding: 5px; width: 100%; }
        button { padding: 5px 10px; background-color: #4caf50; color: white; border: none; border-radius: 3px; cursor: pointer; }
        button:hover { background-color: #45a049; }
        .mensaje { padding: 10px; background-color: #d4edda; color: #155724; margin-bottom: 15px; border-radius: 5px; }
        .error { padding: 10px; background-color: #f8d7da; color: #721c24; margin-bottom: 15px; border-radius: 5px; }
        a.volver { display: inline-block; margin-top: 20px; text-decoration: none; background: #4caf50; color: white; padding: 8px 15px; border-radius: 5px; }
        a.volver:hover { background: #388e3c; }
        .form-planta { margin-top: 50px; border-top: 2px solid #ccc; padding-top: 20px; }
    </style>
</head>
<body>

<h1>Administrar Solicitudes de Adopción</h1>

<?php if (!empty($mensaje)): ?>
    <div class="mensaje"><?= htmlspecialchars($mensaje) ?></div>
<?php endif; ?>
<?php if (!empty($error)): ?>
    <div class="error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>Folio</th>
            <th>Correo</th>
            <th>Planta</th>
            <th>Fecha de Solicitud</th>
            <th>Estado</th>
            <th>Actualizar Estado</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($fila = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($fila['folio']) ?></td>
                <td><?= htmlspecialchars($fila['correo']) ?></td>
                <td><?= htmlspecialchars($fila['nombre_planta']) ?></td>
                <td><?= htmlspecialchars($fila['fecha_solicitud']) ?></td>
                <td><?= htmlspecialchars(ucfirst($fila['estado'])) ?></td>
                <td>
                    <form method="POST" action="">
                        <input type="hidden" name="folio" value="<?= $fila['folio'] ?>" />
                        <select name="nuevo_estado" required>
                            <option value="pendiente" <?= $fila['estado'] === 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                            <option value="aceptada" <?= $fila['estado'] === 'aceptada' ? 'selected' : '' ?>>Aceptada</option>
                            <option value="rechazada" <?= $fila['estado'] === 'rechazada' ? 'selected' : '' ?>>Rechazada</option>
                        </select>
                        <button type="submit">Actualizar</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        <?php if ($resultado->num_rows === 0): ?>
            <tr><td colspan="6" style="text-align:center;">No hay solicitudes para mostrar.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<a href="../index.php" class="volver">← Volver al Inicio</a>

<div class="form-planta">
    <h2>Agregar Nueva Planta</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <label>Nombre de la planta:</label><br>
        <input type="text" name="nombre_planta" required><br><br>

        <label>Descripción de la planta:</label><br>
        <textarea name="descripcion" rows="4" required></textarea><br><br>

        <label>Foto de la planta:</label><br>
        <input type="file" name="foto" accept="image/*" required><br><br>

        <button type="submit">Agregar Planta</button>
    </form>
</div>

</body>
</html>
