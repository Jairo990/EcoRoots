<?php
$conexion = new mysqli("localhost", "root", "", "ecoroots", 3306);
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}
?>
