<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>EcoRoots – Adopción de Plantas</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap" rel="stylesheet">
</head>

<body>
  <header>
    <div class="logo">EcoRoots</div>
    <nav class="navbar">
      <input type="checkbox" id="menu-toggle" />
      <label for="menu-toggle" class="menu-icon">&#9776;</label>
      <ul class="menu">
        <li><a href="index.html">Inicio</a></li>
        <li><a href="#galeria">Galería</a></li>
        <li><a href="#faq">FAQ</a></li>

        <?php if (isset($_SESSION['rol'])): ?>
          <li><a href="php/logout.php">Cerrar sesión</a></li>
          <?php if ($_SESSION['rol'] === 'usuario'): ?>
            <li><a href="usuario/dash_user.php">Mi perfil</a></li>
            <li><a href="adoptar/plantas_disponibles.php">Adoptar</a></li>
          <?php elseif ($_SESSION['rol'] === 'admin'): ?>
            <li><a href="admin/dashboard.php">Panel Admin</a></li>
          <?php endif; ?>
        <?php else: ?>
          <li><a href="usuario/login_usuario.html">Login Usuario</a></li>
          <li><a href="admin/login_admin.html">Login Admin</a></li>
          <li><a href="usuario/login_usuario.html">Registro</a></li>
        <?php endif; ?>
        <li><a href="donar/donar.php">Donar</a></li>
      </ul>
    </nav>
  </header>

  <div class="hero">
    <div class="inner">
      <h1>Bienvenido a EcoRoots</h1>
      <p>Adopta una planta, salva una especie. Ayuda a conservar la biodiversidad mexicana.</p>
      <div class="cta-group">
        <a href="#plantas">Ver Plantas</a>
      </div>
    </div>
  </div>

  <section id="sobre" class="bg-white">
    <h2>Sobre Nosotros</h2>
    <p>EcoRoots es una iniciativa para promover la adopción de plantas mexicanas en peligro de extinción. En colaboración con el Jardín Botánico del Instituto de Biología de la UNAM, buscamos educar y sensibilizar sobre el valor ecológico de nuestras especies nativas.</p>
  </section>

  <section id="galeria" class="bg-white">
    <h2 style="text-align: center; color: #2e7d32;">Galería</h2>
    <div class="gallery-container">
      <div class="main-image">
        <img id="current" src="https://www.fciencias.unam.mx/sites/default/files/Imgs/Labs%20y%20talleres/Invernadero/invernadero06.jpg" alt="Planta principal">
      </div>
      <div class="thumbnails">
        <img src="https://www.fciencias.unam.mx/sites/default/files/Imgs/Labs%20y%20talleres/Invernadero/invernadero06.jpg" alt="Planta 1" class="thumb active">
        <img src="https://www.fciencias.unam.mx/sites/default/files/Imgs/Labs%20y%20talleres/Invernadero/invernadero07.jpg" alt="Planta 2" class="thumb">
        <img src="https://www.fciencias.unam.mx/sites/default/files/Imgs/Labs%20y%20talleres/Invernadero/invernadero09.jpg" alt="Planta 3" class="thumb">
        <img src="https://www.fciencias.unam.mx/sites/default/files/Imgs/Labs%20y%20talleres/Invernadero/invernadero10.jpg" alt="Planta 4" class="thumb">
        <img src="https://www.fciencias.unam.mx/sites/default/files/Imgs/Labs%20y%20talleres/Invernadero/invernadero01.jpg" alt="Planta 5" class="thumb">
        <img src="https://www.fciencias.unam.mx/sites/default/files/Imgs/Labs%20y%20talleres/Invernadero/invernadero02.jpg" alt="Planta 6" class="thumb">
      </div>
    </div>
  </section>

  <section id="plantas" class="tipo-planta">
    <h2 style="text-align: center; color: #2f5e41;">Especies en peligro de extinción</h2>
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
            <a href="agaváceas.html">Ver más</a>
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
            <a href="cactaceas.html">Ver más</a>
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
            <a href="crasuláceas.html">Ver más</a>
          </div>
        </div>
      </div>

    </div>
  </section>

  <section id="video">
    <h2 style="text-align: center; margin-bottom: 20px;">Descubre EcoRoots</h2>
    <div class="video-wrapper">
      <iframe width="560" height="315" src="https://www.youtube.com/embed/_GXj4UZdohk?si=PpXb8hwy08r_PH53" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
    </div>
  </section>

  <section id="faq" class="bg-white">
    <h2>Preguntas Frecuentes</h2>
    <div class="faq-item">
      <details>
        <summary>¿Cómo puedo adoptar una planta?</summary>
        <p>Solo debes registrarte e ir a la sección de plantas disponibles.</p>
      </details>
    </div>
    <div class="faq-item">
      <details>
        <summary>¿Dónde puedo recoger mi planta?</summary>
        <p>En el Jardín Botánico de la UNAM.</p>
      </details>
    </div>
    <div class="faq-item">
      <details>
        <summary>¿Qué cuidados necesita mi planta?</summary>
        <p>Cada planta incluye su guía de cuidados. También puedes consultarla en línea.</p>
      </details>
    </div>
  </section>

  <footer>
    <p>Adopción de Plantas Mexicanas.</p>
  </footer>

  <script>
    const current = document.getElementById('current');
    const thumbnails = document.querySelectorAll('.thumb');

    thumbnails.forEach(thumb => {
      thumb.addEventListener('click', () => {
        thumbnails.forEach(img => img.classList.remove('active'));
        current.src = thumb.src;
        thumb.classList.add('active');
      });
    });
  </script>

</body>

</html>
