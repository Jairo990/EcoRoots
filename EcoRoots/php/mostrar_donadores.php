<?php
include("bd.php");

$sql = "SELECT u.username 
        FROM donaciones d
        JOIN usuarios u ON d.id_usuario = u.id_usuario
        WHERE d.es_privado = 0
        ORDER BY d.fecha DESC
        LIMIT 10";

$result = $conn->query($sql);

$donadores = [];

while ($row = $result->fetch_assoc()) {
    $donadores[] = htmlspecialchars($row['username']);
}

echo json_encode($donadores);
?>
