<?php
session_start();
if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== 'usuario') {
    header("Location: ../usuario/login_usuario.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoRoots - Dashboard de Usuario</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        :root {
            --primary: #1d3525;   /* Verde oscuro */
            --secondary: #2c6e49; /* Verde medio */
            --accent: #d68c45;    /* Naranja acento */
            --light: #fefee3;     /* Color claro */
            --dark: #0f1e13;      /* Verde muy oscuro */
            --text: #333;
            --light-gray: #f5f7f6;
            --border: #e0e6e3;
        }
        
        body {
            background: linear-gradient(135deg, #f0f7f4 0%, #e3f2e9 100%);
            color: var(--text);
            line-height: 1.6;
            min-height: 100vh;
        }
        
        /* Encabezado */
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
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
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
        
        .user-menu {
            position: relative;
        }
        
        .user-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.1);
            padding: 8px 15px;
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .user-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
            color: white;
        }
        
        .user-menu-content {
            position: absolute;
            top: 60px;
            right: 0;
            background: white;
            width: 250px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            display: none;
            z-index: 100;
        }
        
        .user-menu-content.show {
            display: block;
        }
        
        .user-info {
            padding: 20px;
            background: var(--light);
            border-bottom: 1px solid var(--border);
        }
        
        .user-info .name {
            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 5px;
        }
        
        .user-info .email {
            color: #666;
            font-size: 0.9rem;
        }
        
        .menu-links {
            padding: 10px 0;
        }
        
        .menu-links a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            text-decoration: none;
            color: var(--text);
            transition: all 0.3s ease;
            gap: 10px;
        }
        
        .menu-links a:hover {
            background: var(--light);
            color: var(--secondary);
        }
        
        .menu-links a i {
            width: 20px;
            text-align: center;
        }
        
        /* Bienvenida */
        .welcome-section {
            padding: 60px 0 40px;
            text-align: center;
        }
        
        .welcome-card {
            background: white;
            border-radius: 20px;
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            position: relative;
            overflow: hidden;
        }
        
        .welcome-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 8px;
            background: linear-gradient(90deg, var(--secondary), var(--accent));
        }
        
        .welcome-title {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 15px;
        }
        
        .welcome-subtitle {
            font-size: 1.2rem;
            color: #555;
            max-width: 600px;
            margin: 0 auto 30px;
        }
        
        .user-name {
            color: var(--accent);
            font-weight: 600;
        }
        
        /* Tarjetas de secciones */
        .dashboard-sections {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin: 40px 0 60px;
        }
        
        .dashboard-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        
        .dashboard-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
        }
        
        .card-header {
            padding: 25px 25px 15px;
            position: relative;
        }
        
        .card-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 20px;
        }
        
        .plants-icon { background: rgba(44, 110, 73, 0.1); color: var(--secondary); }
        .requests-icon { background: rgba(214, 140, 69, 0.1); color: var(--accent); }
        .diary-icon { background: rgba(29, 53, 37, 0.1); color: var(--primary); }
        .donations-icon { background: rgba(254, 254, 227, 0.3); color: var(--dark); }
        
        .card-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--primary);
        }
        
        .card-content {
            padding: 0 25px 25px;
            flex-grow: 1;
        }
        
        .card-stats {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid var(--border);
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--secondary);
        }
        
        .stat-label {
            font-size: 0.85rem;
            color: #666;
        }
        
        .card-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            gap: 10px;
        }
        
        .btn {
            display: inline-block;
            background: var(--secondary);
            color: white;
            padding: 10px 20px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            font-size: 1rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            text-align: center;
            flex: 1;
        }
        
        .btn:hover {
            background: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .btn-accent {
            background: var(--accent);
        }
        
        .btn-accent:hover {
            background: #e09c4d;
        }
        
        /* Pie de página */
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
        
        /* Botón Volver */
        .btn-volver {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: rgba(255, 255, 255, 0.2);
            padding: 10px 15px;
            color: white;
            text-decoration: none;
            border-radius: 30px;
            font-weight: 500;
            z-index: 101;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .btn-volver:hover {
            background-color: rgba(255, 255, 255, 0.3);
            transform: translateX(-3px);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .welcome-card {
                padding: 30px 20px;
            }
            
            .welcome-title {
                font-size: 2rem;
            }
            
            .card-actions {
                flex-direction: column;
            }
            
            .btn-volver {
                top: 15px;
                left: 15px;
                padding: 8px 12px;
                font-size: 0.9rem;
            }
        }
        
        @media (max-width: 480px) {
            .header-content {
                flex-direction: column;
                gap: 20px;
            }
            
            .user-menu {
                align-self: flex-end;
            }
            
            .welcome-title {
                font-size: 1.8rem;
            }
            
            .btn-volver {
                top: 10px;
                left: 10px;
                padding: 6px 10px;
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <!-- Botón Volver -->
    <a href="../index.php" class="btn-volver">
        <i class="fas fa-arrow-left"></i> Volver
    </a>

    <!-- Encabezado con menú de usuario -->
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <div class="custom-icon"></div>
                    <h1>EcoRoots</h1>
                </div>
                
                <div class="user-menu">
                    <div class="user-btn" id="userMenuBtn">
                        <div class="user-avatar">
                            <?= substr($_SESSION['nombre'], 0, 1) ?>
                        </div>
                        <span><?= htmlspecialchars($_SESSION['nombre']) ?></span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    
                    <div class="user-menu-content" id="userMenuContent">
                        <div class="user-info">
                            <div class="name"><?= htmlspecialchars($_SESSION['nombre']) ?></div>
                            <div class="email"><?= htmlspecialchars($_SESSION['correo']) ?></div>
                        </div>
                        
                        <div class="menu-links">
                            <a href="#"><i class="fas fa-user"></i> Mi Perfil</a>
                            <a href="#"><i class="fas fa-cog"></i> Configuración</a>
                            <a href="#"><i class="fas fa-bell"></i> Notificaciones</a>
                            <a href="#"><i class="fas fa-question-circle"></i> Ayuda</a>
                            <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Sección de Bienvenida -->
    <section class="welcome-section">
        <div class="container">
            <div class="welcome-card">
                <h1 class="welcome-title">Bienvenido a EcoRoots</h1>
                <p class="welcome-subtitle">
                    Hola, <span class="user-name"><?= htmlspecialchars($_SESSION['nombre']) ?></span>. 
                    Estamos encantados de tenerte aquí. Gestiona tus plantas, solicitudes, diarios y donaciones desde tu panel personal.
                </p>
                
                <div class="card-stats">
                    <div class="stat-item">
                        <div class="stat-value">12</div>
                        <div class="stat-label">Plantas</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">3</div>
                        <div class="stat-label">Solicitudes</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">8</div>
                        <div class="stat-label">Entradas</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">5</div>
                        <div class="stat-label">Donaciones</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Secciones del Dashboard -->
    <div class="container">
        <div class="dashboard-sections">
            <!-- Plantas Disponibles -->
            <div class="dashboard-card">
                <div class="card-header">
                    <div class="card-icon plants-icon">
                        <i class="fas fa-seedling"></i>
                    </div>
                    <h2 class="card-title">Plantas Disponibles</h2>
                </div>
                <div class="card-content">
                    <p>Explora nuestra colección de plantas disponibles para adopción. Encuentra nuevas especies para tu hogar o jardín.</p>
                    
                    <div class="card-stats">
                        <div class="stat-item">
                            <div class="stat-value">24</div>
                            <div class="stat-label">Disponibles</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">5</div>
                            <div class="stat-label">Especies raras</div>
                        </div>
                    </div>
                    
                    <div class="card-actions">
                        <a href="../info/planta_inf.html" class="btn">Explorar Plantas</a>
                    </div>
                </div>
            </div>
            
            <!-- Mis Solicitudes -->
            <div class="dashboard-card">
                <div class="card-header">
                    <div class="card-icon requests-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h2 class="card-title">Mis Solicitudes</h2>
                </div>
                <div class="card-content">
                    <p>Revisa el estado de tus solicitudes de adopción, donaciones y eventos programados.</p>
                    
                    <div class="card-stats">
                        <div class="stat-item">
                            <div class="stat-value">2</div>
                            <div class="stat-label">Pendientes</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">1</div>
                            <div class="stat-label">Aprobadas</div>
                        </div>
                    </div>
                    
                    <div class="card-actions">
                        <a href="mis_solicitudes.php" class="btn">Ver Solicitudes</a>
        
                    </div>
                </div>
            </div>
            
            <!-- Mis Diarios -->
            <div class="dashboard-card">
                <div class="card-header">
                    <div class="card-icon diary-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <h2 class="card-title">Mis Diarios</h2>
                </div>
                <div class="card-content">
                    <p>Registra el crecimiento de tus plantas, observaciones y momentos especiales con tus diarios personales.</p>
                    
                    <div class="card-stats">
                        <div class="stat-item">
                            <div class="stat-value">8</div>
                            <div class="stat-label">Entradas</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">4</div>
                            <div class="stat-label">Plantas</div>
                        </div>
                    </div>
                    
                    <div class="card-actions">
                        <a href="diario.php" class="btn">Ver Diarios</a>
                    
                    </div>
                </div>
            </div>
            
            <!-- Mis Donaciones -->
            <div class="dashboard-card">
                <div class="card-header">
                    <div class="card-icon donations-icon">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <h2 class="card-title">Mis Donaciones</h2>
                </div>
                <div class="card-content">
                    <p>Consulta tu historial de donaciones y contribuciones a nuestra causa de conservación ambiental.</p>
                    
                    <div class="card-stats">
                        <div class="stat-item">
                            <div class="stat-value">5</div>
                            <div class="stat-label">Donaciones</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">$120</div>
                            <div class="stat-label">Total</div>
                        </div>
                    </div>
                    
                    <div class="card-actions">
                        <a href="../donar/donar.php" class="btn btn-accent">Hacer Donación</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Pie de página -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>EcoRoots</h3>
                    <p>Conectando amantes de las plantas con especies que necesitan cuidado y protección. Juntos podemos hacer la diferencia.</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-pinterest"></i></a>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h3>Enlaces Rápidos</h3>
                    <div class="footer-links">
                        <a href="../index.php">Inicio</a>
                        <a href="plantas_disponibles.php">Plantas disponibles</a>
                        <a href="#">Programas de adopción</a>
                        <a href="#">Eventos</a>
                        <a href="#">Blog</a>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h3>Contacto</h3>
                    <p><i class="fas fa-map-marker-alt"></i> Calle Ecológica 123, Ciudad Verde</p>
                    <p><i class="fas fa-phone"></i> (123) 456-7890</p>
                    <p><i class="fas fa-envelope"></i> info@ecoroots.org</p>
                    <p><i class="fas fa-clock"></i> Lunes a Viernes: 9am - 6pm</p>
                </div>
            </div>
            
            <div class="copyright">
                <p>&copy; 2023 EcoRoots. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
    
    <script>
        // Menú desplegable del usuario
        const userMenuBtn = document.getElementById('userMenuBtn');
        const userMenuContent = document.getElementById('userMenuContent');
        
        userMenuBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            userMenuContent.classList.toggle('show');
        });
        
        // Cerrar menú al hacer clic fuera de él
        document.addEventListener('click', function() {
            userMenuContent.classList.remove('show');
        });
        
        // Evitar que el menú se cierre al hacer clic dentro de él
        userMenuContent.addEventListener('click', function(e) {
            e.stopPropagation();
        });
        
        // Animación de las tarjetas al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.dashboard-card');
            
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    card.style.transition = 'all 0.5s ease';
                    
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 100);
                }, index * 150);
            });
            
            // Mostrar mensaje de bienvenida personalizado
            const welcomeMessage = document.querySelector('.welcome-subtitle');
            setTimeout(() => {
                welcomeMessage.style.opacity = '0';
                welcomeMessage.style.transform = 'translateY(10px)';
                welcomeMessage.style.transition = 'all 0.5s ease';
                
                setTimeout(() => {
                    welcomeMessage.textContent = "Gracias por unirte a nuestra comunidad de conservación. ¡Cada planta que adoptas hace la diferencia!";
                    welcomeMessage.style.opacity = '1';
                    welcomeMessage.style.transform = 'translateY(0)';
                }, 500);
            }, 3000);
        });
    </script>
</body>
</html>