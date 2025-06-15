<?php
session_start();
include("bd.php");

$id_usuario = $_SESSION['id_usuario'] ?? null;

if (!$id_usuario) {
    die("No has iniciado sesión.");
}

$monto = $_POST['monto'];
$tipo = $_POST['tipo'];
$mensaje = $_POST['mensaje'] ?? '';
$privado = isset($_POST['privado']) ? 1 : 0;

$sql = "INSERT INTO donaciones (id_usuario, monto, tipo, mensaje, es_privado)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("idssi", $id_usuario, $monto, $tipo, $mensaje, $privado);

if ($stmt->execute()) {
    header("Location: ../html/donar.html?exito=1");
} else {
    echo "Error al donar: " . $conn->error;
}
?>
