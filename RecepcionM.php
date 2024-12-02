<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configuración de la base de datos
$server = "localhost";
$user = "root";
$pass = "clave";  // Cambia esta clave por la correcta
$db = "Farmacia";

// Crear conexión
$conexion = mysqli_connect($server, $user, $pass, $db);

// Verificar conexión
if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Obtener datos del formulario
$nombre = $_POST['nombre'] ?? '';
$lote = $_POST['lote'] ?? '';
$cantidad = $_POST['cantidad'] ?? 0;
$precioCompra = $_POST['precio-compra'] ?? 0.00;
$precioVenta = $_POST['precio-venta'] ?? 0.00;
$proveedorId = $_POST['id-proveedor'] ?? '';  // ID del proveedor
$fechaEntrada = $_POST['fecha-entrada'] ?? ''; // Asegúrate de usar el nombre exacto de la columna
$fechaCaducidad = $_POST['fecha-caducidad'] ?? '';
$categoria = $_POST['categoria'] ?? ''; // En tu base de datos este campo es `idClasificacion`
$descripcion = $_POST['descripcion'] ?? '';
$regresable = isset($_POST['regresable']) ? 1 : 0;  // Si el checkbox está marcado, será 1, sino será 0

// Verificar campos requeridos
if (empty($nombre) || empty($lote) || empty($cantidad) || empty($precioCompra) || empty($precioVenta) || empty($proveedorId) || empty($fechaEntrada) || empty($fechaCaducidad) || empty($categoria)) {
    die("Error: Todos los campos son obligatorios.");
}

// Preparar la consulta SQL usando declaraciones preparadas
$stmt = $conexion->prepare("INSERT INTO Medicamentos (Nombre, Lote, Cantidad, PrecioCompra, PrecioVenta, idProvedor, `Fecha de entrada`, FechaCaducidad, idClasificacion, Descripcion, E_Regresable)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

if ($stmt) {
    // Vincular parámetros
    $stmt->bind_param('ssisissssss', $nombre, $lote, $cantidad, $precioCompra, $precioVenta, $proveedorId, $fechaEntrada, $fechaCaducidad, $categoria, $descripcion, $regresable);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Redirigir a la página de éxito o inventario
        header("Location: MosMedicamentos.php");  // Cambia la URL si es necesario
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
