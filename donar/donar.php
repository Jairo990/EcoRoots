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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apoya la Causa - Conservación de Plantas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/donar.css">
</head>
<body>
    <!-- Encabezado -->
    <header>
        <div class="header-content">
            <div class="logo">
                <div class="custom-icon"></div>
                <h1>EcoRoots</h1>
            </div>
            <nav>
                <a href="../index.php" style="color: white; text-decoration: none; padding: 8px 15px; border-radius: 5px; background: rgba(255,255,255,0.2);">
                    <i class="fas fa-arrow-left"></i> Volver al sitio
                </a>
            </nav>
        </div>
    </header>

    <!-- Banner superior -->
    <section class="donation-banner">
        <h1>Apoya la Causa</h1>
        <p>Tu donación ayuda a proteger plantas en peligro de extinción y a preservar la biodiversidad para futuras generaciones.</p>
        
        <div class="impact-stats">
            <div class="stat-item">
                <div class="stat-value">250+</div>
                <div class="stat-label">Especies protegidas</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">1,200</div>
                <div class="stat-label">Plantas rescatadas</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">85%</div>
                <div class="stat-label">Tasa de supervivencia</div>
            </div>
        </div>
    </section>

    <!-- Contenido principal -->
    <div class="container">
        <div class="main-content">
            <!-- Formulario de donación -->
            <div class="donation-form-section">
                <div class="section-title">
                    <i class="fas fa-seedling"></i>
                    <h2>Realizar una Donación</h2>
                </div>
                
                <form action="../php/recibir_donaciones.php" method="POST">
                    <div class="form-group">
                        <label>Monto a donar (MXN)</label>
                        <div class="amount-options">
                            <div class="amount-option selected" data-amount="100">$100</div>
                            <div class="amount-option" data-amount="250">$250</div>
                            <div class="amount-option" data-amount="500">$500</div>
                            <div class="amount-option" data-amount="1000">$1,000</div>
                        </div>
                        <div class="custom-amount">
                            <div class="currency-symbol">$</div>
                            <input type="number" name="monto" id="monto" placeholder="Otro monto" min="50" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Tipo de donación</label>
                        <div class="donation-type">
                            <div class="type-option selected" data-type="unica">
                                <i class="fas fa-calendar-day"></i>
                                <div>Única</div>
                            </div>
                            <div class="type-option" data-type="mensual">
                                <i class="fas fa-sync-alt"></i>
                                <div>Recurrente</div>
                            </div>
                            <input type="hidden" name="tipo" id="tipo_donacion" value="unica">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Mensaje (opcional)</label>
                        <textarea class="card-input" name="mensaje" rows="3" placeholder="Escribe un mensaje de apoyo...">¡Sigan con el gran trabajo!</textarea>
                    </div>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" id="anonymous" name="privado" value="1">
                        <label for="anonymous">No mostrar mi nombre públicamente</label>
                    </div>
                    
                    <!-- Campos de tarjeta -->
                    <div class="card-fields">
                        <div class="section-title" style="border-bottom: none; padding-bottom: 0; margin-bottom: 20px;">
                            <i class="fas fa-credit-card"></i>
                            <h3>Información de Pago</h3>
                        </div>
                        
                        <div class="form-group">
                            <label>Número de tarjeta</label>
                            <div class="card-number-group">
                                <input type="text" class="card-input" name="tarjeta" placeholder="1234 5678 9012 3456" required maxlength="19" pattern="\d{16}">
                                <div class="card-icons">
                                    <div class="card-icon">VISA</div>
                                    <div class="card-icon">MC</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-details">
                            <div class="form-group">
                                <label>Fecha de expiración (MM/AA)</label>
                                <input type="text" class="card-input" name="fecha_exp" placeholder="MM/AA" required pattern="(0[1-9]|1[0-2])\/\d{2}">
                            </div>
                            
                            <div class="form-group">
                                <label>CVV</label>
                                <input type="text" class="card-input" name="cvv" placeholder="CVV" required pattern="\d{3}" maxlength="3">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Nombre en la tarjeta</label>
                            <input type="text" class="card-input" name="nombre_tarjeta" placeholder="Nombre completo" required>
                        </div>
                    </div>
                    
                    <button type="submit" class="donate-btn">Donar Ahora</button>
                </form>
            </div>
            
            <!-- Panel de últimos donadores -->
            <div class="donors-panel">
                <div class="section-title">
                    <i class="fas fa-users"></i>
                    <h2>Últimos Donadores</h2>
                </div>
                
                <div class="donor-list" id="carrusel">
                    <!-- Se llena con JS -->
                </div>
                
                <div class="thank-you">
                    <i class="fas fa-hands-heart"></i>
                    <h3>¡Gracias por tu apoyo!</h3>
                    <p>Cada donación marca la diferencia en nuestros esfuerzos de conservación.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Pie de página -->
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>EcoRoots</h3>
                <p>Comprometidos con la protección de especies vegetales en peligro de extinción y la preservación de la biodiversidad global.</p>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            
            <div class="footer-section">
                <h3>Enlaces Rápidos</h3>
                <div class="footer-links">
                    <a href="#">Nuestro trabajo</a>
                    <a href="#">Plantas protegidas</a>
                    <a href="#">Programas de adopción</a>
                    <a href="#">Eventos</a>
                    <a href="#">Voluntariado</a>
                </div>
            </div>
            
            <div class="footer-section">
                <h3>Contacto</h3>
                <p><i class="fas fa-map-marker-alt"></i> Calle Conservación 456, Ciudad Verde</p>
                <p><i class="fas fa-phone"></i> (55) 1234-5678</p>
                <p><i class="fas fa-envelope"></i> donaciones@ecoroots.org</p>
                <p><i class="fas fa-clock"></i> Lunes a Viernes: 9am - 6pm</p>
            </div>
        </div>
        
        <div class="copyright">
            <p>&copy; 2023 EcoRoots. Todos los derechos reservados. Las donaciones son deducibles de impuestos según la ley aplicable.</p>
        </div>
    </footer>
    
    <script src="../js/don.js"></script>
    <script src="../js/carrusel.js"></script>
</body>
</html>