<?php
session_start();
if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== 'usuario') {
    header("Location: ../usuario/login_usuario.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard Usuario - EcoRoots</title>
    <link rel="stylesheet" href="../css/diseño.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4faf4;
        }

        header {
            background-color: #2e7d32;
            padding: 20px;
            text-align: center;
            color: white;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
            padding: 40px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #2e7d32;
        }

        .welcome {
            font-size: 1.3em;
            margin-bottom: 30px;
        }

        nav a {
            display: inline-block;
            margin: 10px;
            background-color: #66bb6a;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        nav a:hover {
            background-color: #388e3c;
        }

        .btn-volver {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: #388e3c;
            padding: 10px 15px;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }

        .btn-volver:hover {
            background-color: #2e7d32;
        }

        @media (max-width: 600px) {
            nav a {
                display: block;
                margin: 10px auto;
                width: 80%;
            }
        }
    </style>
</head>
<body>

    <a href="../index.php" class="btn-volver">← Volver</a>

    <header>
        <h1>Bienvenido a EcoRoots</h1>
    </header>

    <div class="container">
        <div class="welcome">
            ¡Hola, <strong><?= htmlspecialchars($_SESSION['nombre']) ?></strong>!
        </div>

        <nav>
            <a href="plantas_disponibles.php">Plantas Disponibles</a>
            <a href="mis_solicitudes.php">Mis Solicitudes</a>
            <a href="diario.php">Mis Diarios</a>
            <a href="mis_donaciones.php">Mis Donaciones</a>
        </nav>
    </div>

</body>
</html>
