<?php
session_start();
include("bd.php");

$folio = $_POST['folio'];
$contenido = $_POST['contenido'];
$foto = null;

if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $nombre_tmp = $_FILES['foto']['tmp_name'];
    $nombre_archivo = uniqid() . "_" . basename($_FILES['foto']['name']);
    $ruta_destino = "../fotos/" . $nombre_archivo;
    move_uploaded_file($nombre_tmp, $ruta_destino);
    $foto = $nombre_archivo;
}

$sql = "INSERT INTO diarios (folio, contenido, foto) VALUES (?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("iss", $folio, $contenido, $foto);
$stmt->execute();

header("Location: ../html/diario.php");
