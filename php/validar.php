<?php
session_start();
include 'bd.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correo = trim($_POST['correo']);
    $contraseña = trim($_POST['contraseña']);
    $rol = trim($_POST['tipo_login']); // 'admin' o 'usuario'

    // Consulta preparada para evitar inyección SQL
    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE correo = ? AND contraseña = ?");
    $stmt->bind_param("ss", $correo, $contraseña);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $fila = $resultado->fetch_assoc();

        if ($fila['rol'] === $rol) {
            $_SESSION['correo'] = $correo;
            $_SESSION['rol'] = $rol;
            $_SESSION['nombre'] = $fila['nombre'];

            // Si hay url guardada para redirigir después del login, la usamos
            if (isset($_SESSION['redirect_after_login'])) {
                $redirect_url = $_SESSION['redirect_after_login'];
                unset($_SESSION['redirect_after_login']);
                header("Location: ../$redirect_url");
            } else {
                if ($rol === 'admin') {
                    header("Location: ../admin/dashboard.php");
                } else {
                    header("Location: ../index.php");
                }
            }
            exit;
        } else {
            header("Location: ../$rol/login_$rol.html?error=acceso_no_permitido");
            exit;
        }
    } else {
        header("Location: ../$rol/login_$rol.html?error=usuario_no_encontrado");
        exit;
    }
}
?>
