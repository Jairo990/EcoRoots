<?php
session_start();
include '../php/bd.php';

// Verificar si está el usuario logueado y es rol usuario
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'usuario') {
    header('Location: ../usuario/login_usuario.html?error=debes_iniciar_sesion');
    exit;
}

$sql = "SELECT id_planta, nombre, descripcion, imagen FROM plantas WHERE disponible = 0";
$result = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plantas Disponibles - EcoRoots</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', 'Segoe UI', sans-serif;
        }
        
        :root {
            --primary: #1d3525;
            --secondary: #2c6e49;
            --accent: #d68c45;
            --light: #fefee3;
            --dark: #0f1e13;
        }
        
        body {
            background: linear-gradient(135deg, #f0f7f4 0%, #e3f2e9 100%);
            color: #333;
            line-height: 1.6;
            padding-bottom: 60px;
        }
        
        header {
            background: var(--primary);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 10px 0;
        }
        
.custom-icon {
  width: 40px;
  height: 40px;
  position: relative;
}

.custom-icon::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: white;
  -webkit-mask: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><path d="M50 20 Q60 0 70 20 T90 40 Q80 60 70 50 T50 60 T30 50 T10 40 Q20 20 30 20 T50 20" fill="black"/></svg>') no-repeat center;
  mask: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><path d="M50 20 Q60 0 70 20 T90 40 Q80 60 70 50 T50 60 T30 50 T10 40 Q20 20 30 20 T50 20" fill="black"/></svg>') no-repeat center;
}
        
        .logo h1 {
            font-size: 1.8rem;
            font-weight: 700;
        }
        
        nav ul {
            display: flex;
            list-style: none;
            gap: 15px;
            flex-wrap: wrap;
        }
        
        nav a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            padding: 8px 12px;
            border-radius: 4px;
            transition: all 0.3s ease;
            display: block;
        }
        
        nav a:hover, nav a.active {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .hero {
            text-align: center;
            padding: 60px 0 40px;
            background: url('https://images.unsplash.com/photo-1530836369250-ef72a3f5cda8?auto=format&fit=crop&w=1200') center/cover no-repeat;
            position: relative;
            color: white;
            margin-bottom: 40px;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }
        
        .hero-content {
            position: relative;
            max-width: 800px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .hero h2 {
            font-size: 2.2rem;
            margin-bottom: 20px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        
        .hero p {
            font-size: 1.1rem;
            margin-bottom: 30px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .section-title {
            text-align: center;
            margin: 40px 0;
            color: var(--dark);
            position: relative;
        }
        
        .section-title h2 {
            font-size: 2rem;
            display: inline-block;
            padding-bottom: 10px;
        }
        
        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--accent);
            border-radius: 2px;
        }
        
        .plants-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }
        
        .plant-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.4s ease;
        }
        
        .plant-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }
        
        .plant-img {
            height: 220px;
            overflow: hidden;
            position: relative;
        }
        
        .plant-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .plant-card:hover .plant-img img {
            transform: scale(1.05);
        }
        
        .plant-tag {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255, 0, 0, 0.85);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .plant-info {
            padding: 20px;
        }
        
        .plant-info h3 {
            font-size: 1.5rem;
            color: var(--primary);
            margin-bottom: 10px;
        }
        
        .plant-info p {
            color: #555;
            margin-bottom: 20px;
            min-height: 100px;
        }
        
        .plant-specs {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding: 10px 0;
            border-top: 1px solid #eee;
            border-bottom: 1px solid #eee;
        }
        
        .spec {
            text-align: center;
            flex: 1;
        }
        
        .spec i {
            font-size: 1.4rem;
            color: var(--secondary);
            margin-bottom: 5px;
        }
        
        .spec span {
            display: block;
            font-size: 0.85rem;
            color: #666;
        }
        
        .adopt-btn {
            display: block;
            width: 100%;
            background: var(--secondary);
            color: white;
            text-align: center;
            padding: 12px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }
        
        .adopt-btn:hover {
            background: var(--primary);
        }
        
        .care-tips {
            background: white;
            border-radius: 12px;
            padding: 30px;
            margin: 50px 0;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }
        
        .tips-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .tip-card {
            background: var(--light);
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .tip-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .tip-card i {
            font-size: 2.5rem;
            color: var(--secondary);
            margin-bottom: 15px;
        }
        
        .tip-card h4 {
            margin-bottom: 10px;
            color: var(--dark);
        }
        
        footer {
            background: var(--dark);
            color: white;
            padding: 40px 0 20px;
            margin-top: 60px;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
        }
        
        .footer-section h3 {
            font-size: 1.4rem;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }
        
        .footer-section h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--accent);
        }
        
        .footer-links a {
            display: block;
            color: #ddd;
            text-decoration: none;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }
        
        .footer-links a:hover {
            color: var(--accent);
            padding-left: 5px;
        }
        
        .social-icons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .social-icons a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: white;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }
        
        .social-icons a:hover {
            background: var(--accent);
            transform: translateY(-3px);
        }
        
        .copyright {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.9rem;
            color: #aaa;
        }
        
        /* Modales */
        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.6);
        }
        
        .modal-content {
            background: white;
            margin: 100px auto;
            padding: 25px;
            width: 90%;
            max-width: 500px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0,0,0,0.3);
        }
        
        .modal-content h2 {
            margin-top: 0;
            color: var(--primary);
            margin-bottom: 15px;
        }
        
        .modal-content p {
            margin-bottom: 20px;
            color: #555;
        }
        
        .modal-content label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
            font-weight: 500;
            color: #333;
        }
        
        .modal-content select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
        }
        
        .modal-content button {
            margin-top: 15px;
            background-color: var(--secondary);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            font-size: 1rem;
            transition: background-color 0.3s;
        }
        
        .modal-content button[type="button"] {
            background-color: #777;
        }
        
        .modal-content button:hover {
            background-color: var(--primary);
        }
        
        .modal-content button[type="button"]:hover {
            background-color: #555;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                align-items: flex-start;
            }
            
            nav ul {
                margin-top: 10px;
            }
            
            .hero h2 {
                font-size: 1.8rem;
            }
            
            .section-title h2 {
                font-size: 1.8rem;
            }
        }
        
        @media (max-width: 480px) {
            .hero h2 {
                font-size: 1.6rem;
            }
            
            .section-title h2 {
                font-size: 1.6rem;
            }
            
            .plants-grid {
                grid-template-columns: 1fr;
            }
            
            .modal-content {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Encabezado con silueta personalizada -->
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <div class="custom-icon"></div>
                    <h1>EcoRoots</h1>
                </div>
                <nav>
                    <ul>
                        <li><a href="../index.php">Inicio</a></li>
                        <li><a href="plantas_disponibles.php" class="active">Plantas</a></li>
                        <li><a href="mis_adopciones.php">Mis Adopciones</a></li>
                        <li><a href="diario.php">Diario</a></li>
                        <li><a href="mis_donaciones.php">Donaciones</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h2>Adopta una planta, adopta vida</h2>
            <p>Únete a nuestra iniciativa de conservación y lleva a casa una planta que necesita cuidado y amor. Juntos podemos preservar la biodiversidad.</p>
        </div>
    </section>

    <section class="container">
        <div class="section-title">
            <h2>Plantas Disponibles para Adoptar</h2>
        </div>
        
        <div class="plants-grid">
            <?php while($row = $result->fetch_assoc()): ?>
            <div class="plant-card">
                <div class="plant-img">
                    <img src="../img/plantas/<?= htmlspecialchars($row['imagen']) ?>" alt="<?= htmlspecialchars($row['nombre']) ?>">
                    <!-- <div class="plant-tag">En peligro de extinción</div> -->
                </div>
                <div class="plant-info">
                    <h3><?= htmlspecialchars($row['nombre']) ?></h3>
                    <p><?= htmlspecialchars($row['descripcion']) ?></p>
                    
                    <div class="plant-specs">
                        <div class="spec">
                            <i class="fas fa-tint"></i>
                            <span>Media-alta humedad</span>
                        </div>
                        <div class="spec">
                            <i class="fas fa-sun"></i>
                            <span>Sombra parcial o sol directo</span>
                        </div>
                        <div class="spec">
                            <i class="fas fa-thermometer-half"></i>
                            <span>18-25°C</span>
                        </div>
                    </div>
                    
                    <button class="adopt-btn" onclick="abrirModal(<?= $row['id_planta'] ?>)">Adoptar esta planta</button>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </section>
    
    <!-- Consejos de cuidado -->
    <section class="container">
        <div class="care-tips">
            <div class="section-title">
                <h2>Consejos para el Cuidado de Plantas</h2>
            </div>
            
            <div class="tips-grid">
                <div class="tip-card">
                    <i class="fas fa-tint"></i>
                    <h4>Riego Adecuado</h4>
                    <p>Cada planta tiene necesidades específicas de agua. Investiga y sigue un horario de riego consistente.</p>
                </div>
                
                <div class="tip-card">
                    <i class="fas fa-sun"></i>
                    <h4>Luz Apropiada</h4>
                    <p>Proporciona la cantidad correcta de luz solar según los requisitos de cada especie.</p>
                </div>
                
                <div class="tip-card">
                    <i class="fas fa-thermometer-half"></i>
                    <h4>Temperatura</h4>
                    <p>Mantén un rango de temperatura adecuado para tus plantas, evitando cambios bruscos.</p>
                </div>
                
                <div class="tip-card">
                    <i class="fas fa-seedling"></i>
                    <h4>Sustrato y Fertilización</h4>
                    <p>Usa tierra de calidad y fertiliza regularmente durante la temporada de crecimiento.</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Pie de página -->
<footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Jardín Botánico</h3>
                    <p>Dedicados a la conservación de especies vegetales y a la educación ambiental. Nuestro vivero alberga más de 500 especies diferentes.</p>
                    <div class="social-icons">
                        <a href="https://www.facebook.com/p/Instituto-de-Biolog%C3%ADa-UNAM-100057331545214"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/jbunam/"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.youtube.com/channel/UCKzEFu4T_-ibrr6hVhomiQA"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h3>Contacto</h3>
                    <p><i class="fas fa-map-marker-alt"></i> C.U., Coyoacán, 04510 Ciudad de México, CDMX</p>
                    <p><i class="fas fa-phone"></i> 55 5622 9047</p>
                    <p><i class="fas fa-clock"></i> Lunes a Viernes: 9am - 5pm <br>
                            Sábado: 9am - 3pm</p>
                </div>
            </div>
            
            <div class="copyright">
                <p>&copy; EcoRoots</p>
            </div>
        </div>
    </footer>

    <!-- Modal Mensaje -->
    <div id="modalMensaje" class="modal">
        <div class="modal-content">
            <h2>Importante</h2>
            <p>Ten en consideración que debes conocer cómo cuidar correctamente la planta antes de adoptarla.</p>
            <button onclick="mostrarCuestionario()">Continuar</button>
            <button onclick="cerrarModal()">Cancelar</button>
        </div>
    </div>

    <!-- Modal Cuestionario -->
    <div id="modalCuestionario" class="modal">
        <div class="modal-content">
            <h2>Cuestionario de Conocimientos Básicos</h2>
            <form id="formCuestionario" action="adoptar.php" method="POST">
                <input type="hidden" name="id_planta" id="id_planta_input" value="" />

                <label>¿Cada cuánto riegas esta planta?</label>
                <select name="pregunta1" required>
                    <option value="">Selecciona una opción</option>
                    <option value="Una vez por semana">Una vez por semana</option>
                    <option value="Cada dos días">Cada dos días</option>
                    <option value="Solo cuando la tierra esté seca">Solo cuando la tierra esté seca</option>
                </select>

                <label>¿Dónde debe estar ubicada la planta?</label>
                <select name="pregunta2" required>
                    <option value="">Selecciona una opción</option>
                    <option value="A pleno sol">A pleno sol</option>
                    <option value="A media sombra">A media sombra</option>
                    <option value="En un lugar oscuro">En un lugar oscuro</option>
                </select>

                <div style="margin-top:15px;">
                    <button type="submit">Enviar solicitud</button>
                    <button type="button" onclick="cerrarModal()">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let plantaSeleccionada = null;

        function abrirModal(idPlanta) {
            plantaSeleccionada = idPlanta;
            document.getElementById('modalMensaje').style.display = 'block';
        }

        function cerrarModal() {
            document.getElementById('modalMensaje').style.display = 'none';
            document.getElementById('modalCuestionario').style.display = 'none';
        }

        function mostrarCuestionario() {
            document.getElementById('modalMensaje').style.display = 'none';
            document.getElementById('id_planta_input').value = plantaSeleccionada;
            document.getElementById('modalCuestionario').style.display = 'block';
        }

        window.onclick = function(event) {
            const modalMensaje = document.getElementById('modalMensaje');
            const modalCuestionario = document.getElementById('modalCuestionario');
            if (event.target === modalMensaje) cerrarModal();
            if (event.target === modalCuestionario) cerrarModal();
        }
    </script>
</body>
</html>