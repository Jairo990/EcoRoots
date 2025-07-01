<?php
class RegistroUsuario {
    private $conexion;

    public function __construct() {
        $this->conexion = new mysqli("localhost", "root", "", "eco", 3306); // usa el mismo puerto que bd.php
        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }

    public function registrar($correo, $nombre, $apellido, $contraseña) {
        // Verificar si el correo ya existe
        $stmt = $this->conexion->prepare("SELECT correo FROM usuarios WHERE correo = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "El correo ya está registrado. <a href='../html/login_usuario.html'>Inicia sesión</a>";
            $stmt->close();
            return;
        }

        $stmt->close();

        // Insertar nuevo usuario
        $stmt = $this->conexion->prepare("INSERT INTO usuarios (correo, nombre, apellido, contraseña, rol) VALUES (?, ?, ?, ?, 'usuario')");
        $stmt->bind_param("ssss", $correo, $nombre, $apellido, $contraseña);

        if ($stmt->execute()) {
            echo "Registro exitoso. <a href='login_usuario'></a>";
        } else {
            echo "Error al registrar: " . $stmt->error;
        }

        $stmt->close();
        $this->conexion->close();
    }
}

// Ejecutar si se recibió por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $registro = new RegistroUsuario();
    $registro->registrar($_POST['correo'], $_POST['nombre'], $_POST['apellido'], $_POST['contraseña']);
}
?>
