<?php
$conexion = new mysqli("localhost", "root", "", "eco", 3306);
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}
?>
