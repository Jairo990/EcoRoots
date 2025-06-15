<?php
session_start();

// Verificar que el usuario esté logueado y sea admin
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../admin/login_admin.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - EcoRoots</title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>

<header>
    <h1>Bienvenido, <?= htmlspecialchars($_SESSION['usuario']) ?></h1>
</header>

<section class="add-plant-container">
    <a href="agregar_planta.php" class="add-plant-btn">Agregar Planta</a>
</section>

<section class="dashboard">
    <h2>Panel de Control</h2>
    <div class="options">
        <div class="card">
            <h3>Solicitudes Pendientes</h3>
            <a href="solicitudes_pendientes.php">Ver Solicitudes</a>
        </div>
        <div class="card">
            <h3>Solicitudes Aceptadas</h3>
            <a href="solicitudes_aceptadas.php">Ver Aceptadas</a>
        </div>
        <div class="card">
            <h3>Solicitudes Rechazadas</h3>
            <a href="solicitudes_rechazadas.php">Ver Rechazadas</a>
        </div>
        <div class="card">
            <h3>Diarios de Usuarios</h3>
            <a href="ver_diarios.php">Ver Diarios</a>
        </div>
    </div>
</section>

</body>
</html>
