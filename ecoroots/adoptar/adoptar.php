<?php
session_start();
include '../php/bd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== 'usuario') {
        header('Location: ../usuario/login_usuario.html?error=debes_iniciar_sesion');
        exit;
    }

    $id_planta = intval($_POST['id_planta'] ?? 0);
    $respuesta1 = trim($_POST['pregunta1'] ?? '');
    $respuesta2 = trim($_POST['pregunta2'] ?? '');

    if ($id_planta <= 0 || $respuesta1 === '' || $respuesta2 === '') {
        die("Por favor, completa todas las preguntas.");
    }

    $correo = $_SESSION['correo'];
    $estado = 'pendiente';

    // Paso 1: Insertar en adopciones
    $stmt = $conexion->prepare("INSERT INTO adopciones (correo, id_planta, estado) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $correo, $id_planta, $estado);

    if ($stmt->execute()) {
        $folio = $conexion->insert_id;

        // Paso 2: Insertar en cuestionarios
        $stmt2 = $conexion->prepare("INSERT INTO cuestionarios (folio, pregunta1, pregunta2) VALUES (?, ?, ?)");
        $stmt2->bind_param("iss", $folio, $respuesta1, $respuesta2);
        $stmt2->execute();

        echo "<h2>¡Solicitud enviada con éxito!</h2>";
        echo "<p>Gracias por tu interés en adoptar. Pronto revisaremos tu solicitud.</p>";
        echo '<a href="plantas_disponibles.php">Volver a Plantas Disponibles</a>';
    } else {
        echo "Error al enviar la solicitud: " . $conexion->error;
    }

} else {
    header('Location: plantas_disponibles.php');
    exit;
}
?>
