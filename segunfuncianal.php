<?php
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
$employeeId = $_POST['employeeId'] ?? null;
$productId = $_POST['productId'] ?? null;
$quantity = $_POST['quantity'] ?? null;
$unitPrice = $_POST['unitPrice'] ?? null;
$totalPrice = $_POST['totalPrice'] ?? null;
$saleDate = $_POST['saleDate'] ?? null;
$classification = $_POST['classification'] ?? null;

// Datos de producto controlado (si es necesario)
$patientName = $_POST['patientName'] ?? null;
$doctorName = $_POST['doctorName'] ?? null;
$doctorPhone = $_POST['doctorPhone'] ?? null;
$doctorLicense = $_POST['doctorLicense'] ?? null;
$controlledDetails = $_POST['controlledDetails'] ?? null;

// Verificar que los campos básicos no estén vacíos
if (empty($employeeId) || empty($productId) || empty($quantity) || empty($unitPrice) || empty($totalPrice)) {
    die("Error: Todos los campos obligatorios deben ser completados.");
}

// 1. Registrar la venta en DetalleVentas
$sqlVenta = "INSERT INTO DetalleVentas (idProducto, Cantidad, PrecioUnitario, PrecioTotal, idComicion, idControlado) 
             VALUES (?, ?, ?, ?, ?, ?)";
$stmtVenta = $conexion->prepare($sqlVenta);

// Asignar el valor de idControlado a null por defecto
$idControlado = null;

if ($stmtVenta) {
    $stmtVenta->bind_param('iiidii', $productId, $quantity, $unitPrice, $totalPrice, $employeeId, $idControlado);

    // Si es un medicamento controlado, insertar en la tabla Controlado
    if ($classification === 'antialergicos') {
        // Insertar datos en la tabla Controlado
        $sqlControlados = "INSERT INTO Controlado (NombrePaciente, NombreDoctor, TelefonoDoctor, CedulaDoctor, Detalle) 
                           VALUES (?, ?, ?, ?, ?)";
        $stmtControlados = $conexion->prepare($sqlControlados);

        if ($stmtControlados) {
            $stmtControlados->bind_param('sssss', $patientName, $doctorName, $doctorPhone, $doctorLicense, $controlledDetails);

            if ($stmtControlados->execute()) {
                // Obtener el ID generado del medicamento controlado insertado
                $idControlado = $conexion->insert_id;

                $stmtVenta->bind_param('iiidii', $productId, $quantity, $unitPrice, $totalPrice, $employeeId, $idControlado);
            } else {
                echo "Error al insertar en Controlado: " . $stmtControlados->error;
                exit();
            }
        } else {
            echo "Error al preparar la consulta Controlado: " . $conexion->error;
            exit();
        }
    }

    // Ejecutar la inserción en la tabla DetalleVentas
    if ($stmtVenta->execute()) {
        echo "Venta registrada con éxito.";
    } else {
        echo "Error al registrar la venta: " . $stmtVenta->error;
    }
} else {
    echo "Error al preparar la consulta DetalleVentas: " . $conexion->error;
}

// Cerrar las declaraciones y la conexión
$stmtVenta->close();
if (isset($stmtControlados)) $stmtControlados->close();
mysqli_close($conexion);
?>

