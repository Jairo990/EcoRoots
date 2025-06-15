<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>EcoRoots</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Bienvenido a EcoRoots</h1>
        <?php if(isset($_SESSION['usuario'])): ?>
            <div class="user-info">
                <p>Hola, <?php echo htmlspecialchars($_SESSION['usuario']); ?></p>
                <a href="php/logout.php" class="btn">Cerrar sesión</a>
            </div>
        <?php endif; ?>
    </header>
    <main>
        <p>Este es el inicio de tu sistema de adopción de plantas en peligro de extinción.</p>
        <div class="button-container">
            <?php if(!isset($_SESSION['usuario'])): ?>
                <a href="usuario/login_usuario.html" class="btn">Iniciar sesión como Usuario</a>
                <a href="admin/login_admin.html" class="btn">Iniciar sesión como Administrador</a>
            <?php endif; ?>
            <a href="donar/donar.html" class="btn">Donar</a>
            <?php if(isset($_SESSION['usuario']) == 'usuario'): ?>
                <a href="usuario/dash_user.php" class="btn">Mi perfil</a>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>