<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configuración de la base de datos
$server = "localhost";
$user = "root";
$pass = "clave";
$db = "Farmacia";

// Crear conexión
$conexion = mysqli_connect($server, $user, $pass, $db);

// Verificar conexión
if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Obtener datos del formulario
$nombre = $_POST['Nombre'] ?? '';  
$puesto = $_POST['Puesto'] ?? '';  
$correo = $_POST['Correo'] ?? '';
$telefono = $_POST['Telefono'] ?? '';
$curp = $_POST['CURP'] ?? '';
$rfc = $_POST['RFC'] ?? '';
$salario = $_POST['Salario'] ?? '';
$nuevaPassword = $_POST['nuevaPassword'] ?? '';
$confirmarPassword = $_POST['confirmarPassword'] ?? '';  

// Verificar campos requeridos
if (empty($nombre) || empty($puesto) || empty($correo) || empty($telefono) || empty($curp) || empty($rfc) || empty($salario) || empty($nuevaPassword) || empty($confirmarPassword)) {
    die("Error: Todos los campos son obligatorios.");
}

// Validar que las contraseñas coincidan
if ($nuevaPassword !== $confirmarPassword) {
    die("Error: Las contraseñas no coinciden.");
}

// Validar longitud de la contraseña
if (strlen($nuevaPassword) > 255) {
    die("Error: La contraseña es demasiado larga.");
}

// Convertir salario a float
$salario = (float)$salario;

// Hash de la nueva contraseña
$nuevaPasswordHash = password_hash($nuevaPassword, PASSWORD_DEFAULT);

// Verificar si el hash se generó correctamente
if (empty($nuevaPasswordHash)) {
    die("Error: El hash de la contraseña no se generó correctamente.");
}

// Preparar la consulta SQL usando declaraciones preparadas
$stmt = $conexion->prepare("INSERT INTO Empleados (Nombre, Puesto, Correo, Telefono, CURP, RFC, Salario, nuevaPassword) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

if ($stmt) {
    // Vincular parámetros
    $stmt->bind_param('ssssssds', $nombre, $puesto, $correo, $telefono, $curp, $rfc, $salario, $nuevaPassword);
    
    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Redirigir a la página que muestra los empleados
        header("Location: MosEmpleados.php");  // Cambia la URL si es necesario
        exit();
    } else {
        echo "Error al registrar: " . $stmt->error;
    }

    // Cerrar la declaración
    $stmt->close();
} else {
    echo "Error al preparar la consulta: " . $conexion->error;
}

// Cerrar la conexión
mysqli_close($conexion);
?>
