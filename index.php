<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EcoRoots – Adopción de Plantas</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <header>
    <div class="header-content">
      <a href="index.html" class="logo">
        <div class="custom-icon"></div>
        EcoRoots
      </a>
      
      <nav class="navbar">
        <input type="checkbox" id="menu-toggle" />
        <label for="menu-toggle" class="menu-icon">&#9776;</label>
        <ul class="menu">
          <li><a href="#faq"><i class="fas fa-question-circle"></i> FAQ</a></li>

          <?php if (isset($_SESSION['rol'])): ?>
            <li><a href="php/logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a></li>
            <?php if ($_SESSION['rol'] === 'usuario'): ?>
              <li><a href="usuario/dash_user.php"><i class="fas fa-user"></i> Mi perfil</a></li>
              <li><a href="adoptar/plantas_disponibles.php"><i class="fas fa-seedling"></i> Adoptar</a></li>
            <?php elseif ($_SESSION['rol'] === 'admin'): ?>
              <li><a href="admin/dashboard.php"><i class="fas fa-cog"></i> Panel Admin</a></li>
            <?php endif; ?>
          <?php else: ?>
            <li><a href="usuario/login_usuario.html"><i class="fas fa-sign-in-alt"></i> Login Usuario</a></li>
            <li><a href="admin/login_admin.html"><i class="fas fa-sign-in-alt"></i> Login Admin</a></li>
            <li><a href="usuario/login_usuario.html"><i class="fas fa-user-plus"></i> Registro</a></li>
          <?php endif; ?>
          <li><a href="donar/donar.php"><i class="fas fa-hand-holding-heart"></i> Donar</a></li>
        </ul>
        
        <?php if (isset($_SESSION['rol'])): ?>
          <div class="user-indicator">
            <i class="fas fa-user-circle"></i>
            <?php echo $_SESSION['nombre'] ?>
          </div>
        <?php endif; ?>
      </nav>
    </div>
  </header>

  <div class="hero">
    <h1>Bienvenido a EcoRoots</h1>
    <p>Adopta una planta, salva una especie. Ayuda a conservar la biodiversidad mexicana.</p>
    <div class="cta-group">
      <a href="adoptar/plantas_disponibles.php" class="btn">Ver Plantas</a>
      <a href="donar/donar.php" class="btn btn-secondary">Hacer Donación</a>
    </div>
  </div>

  <section id="sobre" class="bg-white">
    <div class="section-title">
      <h2>Sobre Nosotros</h2>
    </div>
    <p>EcoRoots es una iniciativa para promover la adopción de plantas mexicanas en peligro de extinción. En colaboración con el Jardín Botánico del Instituto de Biología de la UNAM, buscamos educar y sensibilizar sobre el valor ecológico de nuestras especies nativas.</p>
  </section>

  <section id="galeria" class="bg-white">
    <div class="section-title">
      <h2>Galería</h2>
    </div>
    <div class="gallery-container">
      <div class="main-image">
        <img id="current" src="https://www.fciencias.unam.mx/sites/default/files/Imgs/Labs%20y%20talleres/Invernadero/invernadero06.jpg" alt="Planta principal">
      </div>
      <div class="thumbnails">
        <img src="https://www.fciencias.unam.mx/sites/default/files/Imgs/Labs%20y%20talleres/Invernadero/invernadero06.jpg" alt="Planta 1" class="thumb active">
        <img src="https://www.fciencias.unam.mx/sites/default/files/Imgs/Labs%20y%20talleres/Invernadero/invernadero07.jpg" alt="Planta 2" class="thumb">
        <img src="https://www.fciencias.unam.mx/sites/default/files/Imgs/Labs%20y%20talleres/Invernadero/invernadero09.jpg" alt="Planta 3" class="thumb">

      </div>
    </div>
  </section>

  <section id="plantas" class="tipo-planta">
    <div class="section-title">
      <h2>Especies en peligro de extinción</h2>
    </div>
    <div class="grid-plantas">

      <div class="card-flip">
        <div class="card-inner">
          <div class="card-front">
            <img src="https://i.pinimg.com/736x/d2/ce/75/d2ce75be608f2c065ac5cee6258a0ca7.jpg" alt="Agaváceas">
            <h3>Agaváceas</h3>
          </div>
          <div class="card-back">
            <h4>Agaváceas</h4>
            <p>Son plantas con rizomas o tallos leñosos, hojas alargadas, coriáceas, fibrosas y más o menos carnosas. </p>
            <a href="agaváceas.html">Ver más <i class="fas fa-arrow-right"></i></a>
          </div>
        </div>
      </div>

      <div class="card-flip">
        <div class="card-inner">
          <div class="card-front">
            <img src="https://i.pinimg.com/736x/f2/84/75/f284752b4b02aee57b42c18a59f6c8d5.jpg" alt="Cactáceas">
            <h3>Cactáceas</h3>
          </div>
          <div class="card-back">
            <h4>Cactáceas</h4>
            <p>Plantas que han evolucionado para adaptarse a entornos secos y cálidos, fundamentales en su ecosistema.</p>
            <a href="cactaceas.html">Ver más <i class="fas fa-arrow-right"></i></a>
          </div>
        </div>
      </div>

      <div class="card-flip">
        <div class="card-inner">
          <div class="card-front">
            <img src="https://brunoticias.com/wp-content/uploads/2017/10/crasul%C3%A1ceas-1.jpg" alt="Crasuláceas Mexicanas">
            <h3>Crasuláceas Mexicanas</h3>
          </div>
          <div class="card-back">
            <h4>Crasuláceas Mexicanas</h4>
            <p>Plantas suculentas con hojas carnosas, ideales para almacenar agua en climas extremos.</p>
            <a href="crasuláceas.html">Ver más <i class="fas fa-arrow-right"></i></a>
          </div>
        </div>
      </div>

    </div>
  </section>

  <section id="video">
    <div class="section-title">
      <h2>Descubre EcoRoots</h2>
    </div>
    <div class="video-wrapper">
      <iframe width="560" height="315" src="https://www.youtube.com/embed/_GXj4UZdohk?si=PpXb8hwy08r_PH53" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
    </div>
  </section>

  <section id="faq" class="bg-white">
    <div class="section-title">
      <h2>Preguntas Frecuentes</h2>
    </div>
    <div class="faq-item">
      <details>
        <summary>¿Cómo puedo adoptar una planta?</summary>
        <p>Solo debes registrarte e ir a la sección de plantas disponibles. Una vez seleccionada la planta, completa el formulario de adopción y coordina la recolección en el Jardín Botánico de la UNAM.</p>
      </details>
    </div>
    <div class="faq-item">
      <details>
        <summary>¿Dónde puedo recoger mi planta?</summary>
        <p>En el Jardín Botánico de la UNAM. Te proporcionaremos un horario específico para la recolección y una guía de cuidados para tu nueva planta.</p>
      </details>
    </div>
    <div class="faq-item">
      <details>
        <summary>¿Qué cuidados necesita mi planta?</summary>
        <p>Cada planta incluye su guía de cuidados personalizada. También puedes consultar información detallada en línea o contactar a nuestros especialistas para asesoramiento adicional.</p>
      </details>
    </div>
    <div class="faq-item">
      <details>
        <summary>¿Puedo donar si no vivo en México?</summary>
        <p>¡Sí! Aceptamos donaciones internacionales a través de nuestro sistema seguro de pagos en línea. Tu apoyo es fundamental sin importar dónde te encuentres.</p>
      </details>
    </div>
  </section>

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
                
                
            
            <div class="copyright">
                <p>&copy; EcoRoots</p>
            </div>
        </div>
    </footer>

  <script src="js/index.js"></script>
</body>
</html>