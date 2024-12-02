<?php
// Conectar a la base de datos
$server = "localhost";
$user = "root";
$pass = "clave";  // Cambia esta clave por la correcta
$db = "Farmacia";

$conexion = mysqli_connect($server, $user, $pass, $db);

if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Obtener el ID del producto desde la solicitud GET
$idProducto = isset($_GET['idProducto']) ? $_GET['idProducto'] : '';

// Consulta para obtener el nombre y precio del producto
$sql = "SELECT Nombre, PrecioVenta FROM Medicamentos WHERE idProducto = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param('i', $idProducto);
$stmt->execute();
$stmt->bind_result($nombre, $precioVenta);

// Enviar la respuesta como un JSON con el nombre y precio
$product = null;
if ($stmt->fetch()) {
    $product = ['Nombre' => $nombre, 'PrecioVenta' => $precioVenta];
}

echo json_encode($product);

// Cerrar la conexión
$stmt->close();
mysqli_close($conexion);
?>
