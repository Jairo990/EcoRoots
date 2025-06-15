<?php
class RegistroUsuario {
    private $conexion;

    public function __construct() {
        $this->conexion = new mysqli("localhost", "root", "", "EcoRoots", 3307);
        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }

    public function registrar($nombre, $apellido, $usuario, $contraseña) {
        // Evitar inyección SQL
        $nombre = $this->conexion->real_escape_string($nombre);
        $apellido = $this->conexion->real_escape_string($apellido);
        $usuario = $this->conexion->real_escape_string($usuario);
        $contraseña = $this->conexion->real_escape_string($contraseña);

        // Insertar usuario con rol "usuario"
        $sql = "INSERT INTO usuarios (nombre, apellido, usuario, contraseña, rol) 
                VALUES ('$nombre', '$apellido', '$usuario', '$contraseña', 'usuario')";

        if ($this->conexion->query($sql) === TRUE) {
            echo "Registro exitoso. <a href='login_usuario.html'>Iniciar sesión</a>";
        } else {
            echo "Error: " . $this->conexion->error;
        }

        $this->conexion->close();
    }
}

// Ejecutar si se recibió por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $registro = new RegistroUsuario();
    $registro->registrar($_POST['nombre'], $_POST['apellido'], $_POST['usuario'], $_POST['contraseña']);
}
?>
