<?php
session_start();
include 'bd.php';

// Verificar que esté el usuario logueado
if (!isset($_SESSION['correo'])) {
    header("Location: ../usuario/login_usuario.html");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correo = $_SESSION['correo'];
    $monto = floatval($_POST['monto']);
    $tipo = $_POST['tipo']; // "unica" o "mensual"
    $mensaje = trim($_POST['mensaje']);
    $privado = isset($_POST['privado']) ? 1 : 0;

    // Insertar donación en la base de datos
    $stmt = $conexion->prepare("INSERT INTO donaciones (correo, monto, tipo, mensaje, privado, fecha) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sdssi", $correo, $monto, $tipo, $mensaje, $privado);

    if ($stmt->execute()) {
        header("Location: ../index.php?donacion=exito");
        exit;
    } else {
        echo "Error al guardar la donación: " . $conexion->error;
    }
}
?>
