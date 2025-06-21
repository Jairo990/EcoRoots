<?php
include("bd.php");

header('Content-Type: application/json');

if (!isset($_GET['folio']) || !is_numeric($_GET['folio'])) {
    echo json_encode([]);
    exit;
}

$folio = intval($_GET['folio']);

$sql = "SELECT contenido, fecha, foto FROM diarios WHERE folio = ? ORDER BY fecha DESC";
if ($stmt = $conexion->prepare($sql)) {
    $stmt->bind_param("i", $folio);
    if ($stmt->execute()) {
        $res = $stmt->get_result();
        $entradas = [];
        while ($row = $res->fetch_assoc()) {
            $entradas[] = $row;
        }
        echo json_encode($entradas);
    } else {
        echo json_encode(["error" => "Falló la ejecución"]);
    }
    $stmt->close();
} else {
    echo json_encode(["error" => "Falló la preparación"]);
}
?>
