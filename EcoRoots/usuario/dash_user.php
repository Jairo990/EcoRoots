<?php
session_start();

// Si el usuario no está logueado o no es usuario, redirigir al login
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'usuario') {
    header("Location: ../usuario/login_usuario.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard Usuario - EcoRoots</title>
    <a href="../index.php" class="btn waves-effect waves-light">Volver</a>
    <link rel="stylesheet" href="../css/diseño.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }
        h2 {
            color: #2e7d32;
        }
        nav {
            margin-top: 20px;
        }
        nav a {
            display: inline-block;
            margin-right: 15px;
            background-color: #4caf50;
            color: white;
            padding: 10px 18px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        nav a:hover {
            background-color: #388e3c;
        }
        .welcome {
            margin-bottom: 20px;
            font-size: 1.2em;
        }
    </style>
</head>
<body>

    <div class="welcome">
        Bienvenido, <strong><?= htmlspecialchars($_SESSION['usuario']) ?></strong>!
    </div>

    <nav>
        <a href="plantas_disponibles.php">Adoptar</a>
        <a href="mis_adopciones.php">Mis Adopciones</a>
        <a href="mis_solicitudes.php">Mis Solicitudes</a>
        <a href="diarios.php">Diarios</a>
    </nav>

</body>
</html>
