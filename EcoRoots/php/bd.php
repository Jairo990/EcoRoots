<?php
$conexion = new mysqli("localhost", "root", "", "EcoRoots", 3307);
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}
?>
