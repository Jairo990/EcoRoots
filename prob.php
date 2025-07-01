<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>EcoRoots</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <div class="logo">EcoRoots</div>

        <div class="user-info">
            <?php if (isset($_SESSION['rol'])): ?>
                <p>Hola, <?php echo htmlspecialchars($_SESSION['nombre']); ?></p>
                <a href="php/logout.php" class="btn btn-small">Cerrar sesión</a>
                <?php if ($_SESSION['rol'] === 'usuario'): ?>
                    <a href="usuario/dash_user.php" class="btn btn-small">Mi perfil</a>
                    <a href="adoptar/plantas_disponibles.php" class="btn btn-small">Adoptar</a>
                <?php elseif ($_SESSION['rol'] === 'admin'): ?>
                    <a href="admin/dashboard.php" class="btn btn-small">Panel Admin</a>
                <?php endif; ?>
            <?php else: ?>
                <a href="usuario/login_usuario.html" class="btn btn-small">Login Usuario</a>
                <a href="admin/login_admin.html" class="btn btn-small">Login Admin</a>
                <a href="usuario/login_usuario.html" class="btn btn-small">Registro</a>
            <?php endif; ?>
            <a href="donar/donar.php" class="btn btn-small">Donar</a>
        </div>
    </header>

    <section class="hero">
        <h1>BIENVENID@ A ECOROOTS</h1>
        <p>
            Visita el Centro de Adopción de Plantas Mexicanas en Peligro de Extinción del Jardín Botánico del
            Instituto de Biología de la UNAM <br>
            Aprende, adopta, preserva.
        </p>
        <button class="btn" onclick="location.href='inicio.html'">ÚNETE AHORA</button>
    </section>
</body>
