<?php
session_start();
include '../php/bd.php';

if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== 'usuario') {
    header("Location: ../usuario/login_usuario.html");
    exit;
}

$correo = $_SESSION['correo'];

// Obtener adopciones aceptadas
$sql_adopciones = "SELECT a.folio, p.id_planta, p.nombre AS planta_nombre, p.imagen, a.fecha_solicitud 
                   FROM adopciones a
                   JOIN plantas p ON a.id_planta = p.id_planta
                   WHERE a.correo = ? AND a.estado = 'aceptada'";
$stmt_adopciones = $conexion->prepare($sql_adopciones);
$stmt_adopciones->bind_param("s", $correo);
$stmt_adopciones->execute();
$res_adopciones = $stmt_adopciones->get_result();

$adopciones = [];
while ($row = $res_adopciones->fetch_assoc()) {
    $adopciones[] = $row;
}

// Entradas del diario
$entradas = [];
$fechas_con_entradas = [];
$folio_seleccionado = isset($_GET['folio']) ? (int)$_GET['folio'] : null;

if ($folio_seleccionado) {
    // Entradas
    $sql_entradas = "SELECT * FROM diarios WHERE folio = ? ORDER BY fecha DESC";
    $stmt_entradas = $conexion->prepare($sql_entradas);
    $stmt_entradas->bind_param("i", $folio_seleccionado);
    $stmt_entradas->execute();
    $res_entradas = $stmt_entradas->get_result();
    while ($row = $res_entradas->fetch_assoc()) {
        $entradas[] = $row;
    }

    // Fechas
    $sql_fechas = "SELECT DATE(fecha) as fecha_dia FROM diarios WHERE folio = ?";
    $stmt_fechas = $conexion->prepare($sql_fechas);
    $stmt_fechas->bind_param("i", $folio_seleccionado);
    $stmt_fechas->execute();
    $res_fechas = $stmt_fechas->get_result();
    while ($row = $res_fechas->fetch_assoc()) {
        $fechas_con_entradas[] = $row['fecha_dia'];
    }
}

// Calendario
$mes_actual = date('n');
$ano_actual = date('Y');
$dias_mes = cal_days_in_month(CAL_GREGORIAN, $mes_actual, $ano_actual);
$primer_dia = date('N', strtotime("$ano_actual-$mes_actual-01"));

$semanas = [];
$semana_actual = array_fill(0, 7, null);
$dia_contador = 1;

// Primera semana
for ($i = 0; $i < 7; $i++) {
    if ($i < $primer_dia - 1) {
        $semana_actual[$i] = null;
    } else {
        $fecha = sprintf("%04d-%02d-%02d", $ano_actual, $mes_actual, $dia_contador);
        $semana_actual[$i] = [
            'dia' => $dia_contador,
            'tiene_entrada' => in_array($fecha, $fechas_con_entradas)
        ];
        $dia_contador++;
    }
}
$semanas[] = $semana_actual;
$semana_actual = array_fill(0, 7, null);

// Resto del mes
while ($dia_contador <= $dias_mes) {
    for ($i = 0; $i < 7; $i++) {
        if ($dia_contador > $dias_mes) break;
        $fecha = sprintf("%04d-%02d-%02d", $ano_actual, $mes_actual, $dia_contador);
        $semana_actual[$i] = [
            'dia' => $dia_contador,
            'tiene_entrada' => in_array($fecha, $fechas_con_entradas)
        ];
        $dia_contador++;
    }
    $semanas[] = $semana_actual;
    $semana_actual = array_fill(0, 7, null);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Diario de Plantas | EcoRoots</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/diario.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header>
        <!-- Encabezado -->
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <div class="custom-icon"></div>
                    <h1>EcoRoots</h1>
                </div>
                <nav>
                    <ul>
                        <li><a href="../index.php">Inicio</a></li>
                        <li><a href="dash_user.php">Perfil</a></li>
                        <li><a href="diario.php" class="active">Diario</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main class="container">
        <div class="page-header">
            <h1>Mi Diario de Plantas</h1>
            <p>Registra y sigue el progreso de tus plantas adoptadas</p>
        </div>

        <div class="content-container">
            <div class="main-content">
                <div class="section-title">
                    <h2>Tus Plantas Adoptadas</h2>
                </div>

                <?php if (count($adopciones) > 0): ?>
                    <div class="plants-grid">
                        <?php foreach ($adopciones as $adopcion): ?>
                            <div class="plant-card <?= $adopcion['folio'] == $folio_seleccionado ? 'selected' : '' ?>"
                                 onclick="cargarEntradas(<?= $adopcion['folio'] ?>)">
                                <div class="plant-img">
                                    <?php if (!empty($adopcion['imagen'])): ?>
                                        <img src="../img/plantas/<?= $adopcion['imagen'] ?>" alt="<?= $adopcion['planta_nombre'] ?>">
                                    <?php else: ?>
                                        <div><i class="fas fa-seedling"></i></div>
                                    <?php endif; ?>
                                </div>
                                <div class="plant-info">
                                    <h3><?= htmlspecialchars($adopcion['planta_nombre']) ?></h3>
                                    <div class="adoption-date">Solicitada: <?= date('d/m/Y', strtotime($adopcion['fecha_solicitud'])) ?></div>
                                    <span class="status">Creciendo</span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="journal-section">
                        <div class="section-title">
                            <h2>Entradas del Diario 
                                <?php if ($folio_seleccionado): ?>
                                    - <?= htmlspecialchars($adopciones[array_search($folio_seleccionado, array_column($adopciones, 'folio'))]['planta_nombre']) ?>
                                <?php endif; ?>
                            </h2>
                        </div>

                        <?php if ($folio_seleccionado && count($entradas) > 0): ?>
                            <div class="journal-entries">
                                <?php foreach ($entradas as $entrada): ?>
                                    <div class="journal-entry">
                                        <div class="entry-header">
                                            <div class="entry-date"><?= date('d M Y', strtotime($entrada['fecha'])) ?></div>
                                        </div>
                                        <div class="entry-content">
                                            <p><?= nl2br(htmlspecialchars($entrada['contenido'])) ?></p>
                                            <?php if (!empty($entrada['foto'])): ?>
                                                <img src="../uploads/<?= $entrada['foto'] ?>" alt="Foto del diario">
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php elseif ($folio_seleccionado): ?>
                            <div class="no-entries">
                                <i class="fas fa-book-open"></i>
                                <p>No hay entradas en el diario para esta planta.</p>
                            </div>
                        <?php else: ?>
                            <div class="no-entries">
                                <i class="fas fa-seedling"></i>
                                <p>Selecciona una planta para ver sus entradas del diario.</p>
                            </div>
                        <?php endif; ?>

                        <?php if ($folio_seleccionado): ?>
                            <div class="add-entry-btn">
                                <button class="btn btn-accent" onclick="abrirFormulario()">
                                    <i class="fas fa-plus"></i> Añadir Nueva Entrada
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="no-entries">
                        <i class="fas fa-seedling"></i>
                        <p>No tienes plantas adoptadas aún.</p>
                        <a href="plantas_disponibles.php" class="btn">Adoptar una Planta</a>
                    </div>
                <?php endif; ?>
            </div>

            <aside class="sidebar">
                <?php if ($folio_seleccionado): ?>
                    <div class="calendar">
                        <div class="calendar-header">
                            <h3><?= date('F Y') ?></h3>
                        </div>
                        <div class="calendar-grid">
                            <div class="calendar-day header">L</div>
                            <div class="calendar-day header">M</div>
                            <div class="calendar-day header">X</div>
                            <div class="calendar-day header">J</div>
                            <div class="calendar-day header">V</div>
                            <div class="calendar-day header">S</div>
                            <div class="calendar-day header">D</div>

                            <?php foreach ($semanas as $semana): ?>
                                <?php foreach ($semana as $dia): ?>
                                    <?php if ($dia === null): ?>
                                        <div class="calendar-day empty"></div>
                                    <?php else: ?>
                                        <div class="calendar-day <?= $dia['tiene_entrada'] ? 'has-entry' : '' ?>">
                                            <?= $dia['dia'] ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="no-entries">
                        <i class="fas fa-calendar"></i>
                        <p>Selecciona una planta para ver el calendario.</p>
                    </div>
                <?php endif; ?>
            </aside>
        </div>
    </main>

    <!-- Formulario emergente -->
    <div id="formulario-popup" class="formulario-popup oculto">
        <div class="formulario-container">
            <button class="cerrar-formulario" onclick="cerrarFormulario()">&times;</button>
            <form action="../php/guardar_entrada.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="folio" value="<?= $folio_seleccionado ?>">
                <textarea name="contenido" placeholder="Escribe tu entrada..." required></textarea>
                <label for="foto">Subir foto (opcional):</label>
                <input type="file" name="foto" accept="image/*">
                <div class="btn-group">
                    <button type="submit" class="btn">Guardar entrada</button>
                    <button type="button" class="btn btn-accent" onclick="cerrarFormulario()">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        function cargarEntradas(folio) {
            window.location.href = `diario.php?folio=${folio}`;
        }

        function abrirFormulario() {
            document.getElementById('formulario-popup').classList.remove('oculto');
        }

        function cerrarFormulario() {
            document.getElementById('formulario-popup').classList.add('oculto');
        }

        window.addEventListener('click', function (e) {
            const popup = document.getElementById('formulario-popup');
            if (e.target === popup) cerrarFormulario();
        });
    </script>
</body>
</html>
