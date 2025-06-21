<?php
session_start();

if (!isset($_SESSION['correo'])) {
    // Guardamos la página destino para después de loguear
    $_SESSION['redirect_after_login'] = 'donar/donar.php'; 
    header("Location: ../usuario/login_usuario.html");
    exit;
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Donar a EcoRoots</title>
    <link rel="stylesheet" href="../css/donar.css">
</head>
<body>
    <div class="donar-wrapper">
        <div class="formulario">
            <h1>🌱 Apoya la causa</h1>
            <p>Tu donación ayuda a proteger plantas en peligro de extinción.</p>

            <form action="../php/recibir_donaciones.php" method="POST">

                <label for="monto">Monto a donar (MXN):</label>
                <input type="number" id="monto" name="monto" required min="5" placeholder="100">

                <label for="tipo">Tipo de donación:</label>
                <select id="tipo" name="tipo">
                    <option value="unica">Única</option>
                    <option value="mensual">Mensual</option>
                </select>

                <label for="mensaje">Mensaje (opcional):</label>
                <textarea id="mensaje" name="mensaje" rows="3" placeholder="¡Sigan con el gran trabajo!"></textarea>

                <label>
                    <input type="checkbox" name="privado" value="1">
                    No mostrar mi nombre públicamente
                </label>

                <!-- Campos falsos de tarjeta -->
                <label for="tarjeta">Número de tarjeta:</label>
                <input type="text" id="tarjeta" name="tarjeta" required maxlength="16" pattern="\d{16}" placeholder="1234123412341234">

                <label for="fecha_exp">Fecha de expiración (MM/AA):</label>
                <input type="text" id="fecha_exp" name="fecha_exp" required pattern="(0[1-9]|1[0-2])\/\d{2}" placeholder="12/25">

                <label for="cvv">CVV:</label>
                <input type="text" id="cvv" name="cvv" required pattern="\d{3}" maxlength="3" placeholder="123">

                <button type="submit">Donar 💚</button>
            </form>
        </div>

        <div class="donadores">
            <h2>Últimos donadores</h2>
            <div class="carrusel" id="carrusel">
                <!-- Se llena con JS -->
            </div>
        </div>
    </div>

    <script src="../js/carrusel.js"></script>
</body>
</html>
