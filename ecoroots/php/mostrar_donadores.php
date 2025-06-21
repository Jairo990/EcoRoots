<?php
include("bd.php");

$sql = "SELECT u.nombre, u.apellido, d.mensaje
        FROM donaciones d
        JOIN usuarios u ON d.correo = u.correo
        WHERE d.privado = 0
        ORDER BY d.fecha DESC
        LIMIT 10";


$result = $conexion->query($sql);

$donadores = [];

if(!$result) {
    echo json_encode(['error' => $conexion->error]);
    exit;
}

while ($row = $result->fetch_assoc()) {
    $nombreCompleto = htmlspecialchars($row['nombre'] . " " . $row['apellido']);
    $mensaje = htmlspecialchars($row['mensaje']);
    $donadores[] = [
        'nombre' => $nombreCompleto,
        'mensaje' => $mensaje
    ];
}

header('Content-Type: application/json');
echo json_encode($donadores);
?>
