<?php
// Conectar a la base de datos
$servername = "localhost";
$username = "root";  // Cambia esto por tu usuario de base de datos
$password = "clave";      // Cambia esto por tu contraseña de base de datos
$dbname = "Farmacia"; // Asegúrate de que este es el nombre de tu base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se recibió la solicitud POST con los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $idProducto = $_POST['idProducto'] ?? '';
    $porcentajeDescuento = $_POST['PorcentajeDescuento'] ?? 0;
    $fechaInicio = $_POST['FechaInicio'] ?? '';
    $fechaFin = $_POST['FechaFin'] ?? '';

    // Validación básica
    if (empty($idProducto) || empty($porcentajeDescuento) || empty($fechaInicio) || empty($fechaFin)) {
        die("Todos los campos son obligatorios.");
    }

    // Insertar la oferta en la base de datos
    $sql = "INSERT INTO Ofertas (idProducto, FechaInicio, FechaFin, PorcentajeDescuento) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issi", $idProducto, $fechaInicio, $fechaFin, $porcentajeDescuento); // "i" = entero, "s" = string

    if ($stmt->execute()) {
        echo "Oferta registrada con éxito.";
    } else {
        echo "Error al registrar la oferta: " . $stmt->error;
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
}

// Cerrar la conexión
$conn->close();
?>
