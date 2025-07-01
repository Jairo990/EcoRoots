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

        // Mensaje de éxito
        echo "<!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Solicitud Exitosa - EcoRoots</title>
            <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css'>
            <style>
                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                    font-family: 'Poppins', sans-serif;
                }
                
                body {
                    background: linear-gradient(135deg, #f0f7f4 0%, #e3f2e9 100%);
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    min-height: 100vh;
                    padding: 20px;
                }
                
                .success-container {
                    background: white;
                    border-radius: 12px;
                    padding: 40px;
                    text-align: center;
                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                    max-width: 600px;
                    width: 100%;
                }
                
                .success-icon {
                    font-size: 5rem;
                    color: #2c6e49;
                    margin-bottom: 20px;
                }
                
                .success-container h2 {
                    font-size: 2.2rem;
                    color: #1d3525;
                    margin-bottom: 15px;
                }
                
                .success-container p {
                    font-size: 1.1rem;
                    color: #555;
                    margin-bottom: 30px;
                    line-height: 1.6;
                }
                
                .success-container a {
                    display: inline-block;
                    background: #2c6e49;
                    color: white;
                    padding: 12px 25px;
                    border-radius: 50px;
                    text-decoration: none;
                    font-weight: 600;
                    transition: all 0.3s ease;
                }
                
                .success-container a:hover {
                    background: #1d3525;
                    transform: translateY(-3px);
                    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                }
            </style>
        </head>
        <body>
            <div class='success-container'>
                <i class='fas fa-check-circle success-icon'></i>
                <h2>¡Solicitud enviada con éxito!</h2>
                <p>Gracias por tu interés en adoptar. Pronto revisaremos tu solicitud y te notificaremos por correo electrónico sobre el estado de tu solicitud.</p>
                <a href='plantas_disponibles.php'>Volver a Plantas Disponibles</a>
            </div>
        </body>
        </html>";
    } else {
        echo "Error al enviar la solicitud: " . $conexion->error;
    }

} else {
    header('Location: plantas_disponibles.php');
    exit;
}
?>