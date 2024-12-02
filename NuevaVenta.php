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

// Verificar si los datos fueron enviados a través de POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $employeeId = $_POST['employeeId'] ?? null;
    $productId = $_POST['productId'] ?? null;
    $quantity = $_POST['quantity'] ?? null;
    $unitPrice = $_POST['unitPrice'] ?? null;
    $totalPrice = $_POST['totalPrice'] ?? null;
    $saleDate = $_POST['saleDate'] ?? null;
    $classification = $_POST['classification'] ?? null;

    // Datos de medicamento controlado (si es necesario)
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

    // Verificar si la consulta para DetalleVentas fue preparada correctamente
    if ($stmtVenta === false) {
        die("Error al preparar la consulta DetalleVentas: " . $conexion->error);
    }

    // Asignar el valor de idControlado a null por defecto
    $idControlado = null;

    // Usar bind_param con los tipos correctos
    $stmtVenta->bind_param('iiidii', $productId, $quantity, $unitPrice, $totalPrice, $employeeId, $idControlado);

    // Si el producto es un medicamento controlado, insertar en la tabla Controlado
    if ($classification === 'antialergicos') {
        // Insertar datos en la tabla Controlado
        $sqlControlados = "INSERT INTO Controlado (NombrePaciente, NombreDoctor, TelefonoDoctor, CedulaDoctor, Detalle) 
                           VALUES (?, ?, ?, ?, ?)";
        $stmtControlados = $conexion->prepare($sqlControlados);

        // Verificar si la consulta para Controlado fue preparada correctamente
        if ($stmtControlados === false) {
            die("Error al preparar la consulta Controlado: " . $conexion->error);
        }

        // Asignar los valores de los parámetros
        $stmtControlados->bind_param('sssss', $patientName, $doctorName, $doctorPhone, $doctorLicense, $controlledDetails);

        // Ejecutar la inserción en la tabla Controlado
        if ($stmtControlados->execute()) {
            // Obtener el ID generado del medicamento controlado insertado
            $idControlado = $conexion->insert_id;

            // Ahora que tenemos el ID de controlado, actualizamos el idControlado en la venta
            $stmtVenta->bind_param('iiidii', $productId, $quantity, $unitPrice, $totalPrice, $employeeId, $idControlado);
        } else {
            // Mostrar el error si no se insertó correctamente en Controlado
            die("Error al insertar en Controlado: " . $stmtControlados->error);
        }
    }

    // Ejecutar la inserción en la tabla DetalleVentas
    if ($stmtVenta->execute()) {
        // Redirigir a la página de la tabla dinámica después de la venta
        header("Location: Ventas.php");  // Aquí está la corrección
        exit();  // Asegúrate de detener la ejecución del script después de la redirección
    } else {
        die("Error al registrar la venta: " . $stmtVenta->error);
    }

    // Cerrar las declaraciones y la conexión
    $stmtVenta->close();
    if (isset($stmtControlados)) $stmtControlados->close();
}

// Cerrar la conexión
mysqli_close($conexion);
?>
