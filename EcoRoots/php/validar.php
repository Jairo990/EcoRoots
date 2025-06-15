<?php
session_start();
include 'bd.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST['usuario']);
    $contraseña = trim($_POST['contraseña']);
    $rol = trim($_POST['tipo_login']); // 'admin' o 'usuario'

    // Consulta preparada para evitar inyección
    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE usuario = ? AND contraseña = ?");
    $stmt->bind_param("ss", $usuario, $contraseña);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $fila = $resultado->fetch_assoc();

        if ($fila['rol'] === $rol) {
            $_SESSION['usuario'] = $usuario;
            $_SESSION['rol'] = $rol;

            if ($rol === 'admin') {
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: ../index.php");
            }
            exit;
        } else {
            // Rol incorrecto
            header("Location: ../$rol/login_$rol.html?error=acceso_no_permitido");
            exit;
        }
    } else {
        // Usuario o contraseña incorrectos
        header("Location: ../$rol/login_$rol.html?error=usuario_no_encontrado");
        exit;
    }
}
?>
