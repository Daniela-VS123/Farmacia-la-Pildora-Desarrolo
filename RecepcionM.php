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

// Comenzar transacción
mysqli_begin_transaction($conexion);

try {
    // Preparar la consulta SQL para insertar en Medicamentos
    $stmt = $conexion->prepare("INSERT INTO Medicamentos (Nombre, Lote, Cantidad, PrecioCompra, PrecioVenta, idProvedor, `Fecha de entrada`, FechaCaducidad, idClasificacion, Descripcion, E_Regresable)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt) {
        // Vincular parámetros
        $stmt->bind_param('ssisissssss', $nombre, $lote, $cantidad, $precioCompra, $precioVenta, $proveedorId, $fechaEntrada, $fechaCaducidad, $categoria, $descripcion, $regresable);

        // Ejecutar la consulta para Medicamentos
        if (!$stmt->execute()) {
            throw new Exception("Error al insertar en Medicamentos: " . $stmt->error);
        }

        // Obtener el ID del último medicamento insertado (para agregarlo al inventario)
        $last_id = $stmt->insert_id;

        // Preparar la consulta SQL para insertar en Inventario
        $stmtInv = $conexion->prepare("INSERT INTO Inventario (idProducto, Cantidad, PrecioCompra, PrecioVenta, FechaCaducidad, FechaEntrada, Lote)
        VALUES (?, ?, ?, ?, ?, ?, ?)");

        if ($stmtInv) {
            // Vincular los parámetros para Inventario
            $stmtInv->bind_param('iiissss', $last_id, $cantidad, $precioCompra, $precioVenta, $fechaCaducidad, $fechaEntrada, $lote);

            // Ejecutar la consulta para Inventario
            if (!$stmtInv->execute()) {
                throw new Exception("Error al insertar en Inventario: " . $stmtInv->error);
            }
        } else {
            throw new Exception("Error al preparar consulta para Inventario: " . $conexion->error);
        }

        // Si todo ha ido bien, hacer commit de la transacción
        mysqli_commit($conexion);

        // Redirigir a la página de éxito o inventario
        header("Location: MosMedicamentos.php");  // Cambia la URL si es necesario
        exit();
    } else {
        throw new Exception("Error al preparar la consulta para Medicamentos: " . $conexion->error);
    }

    // Cerrar la declaración
    $stmt->close();
    $stmtInv->close();
} catch (Exception $e) {
    // Si hay un error, hacer rollback
    mysqli_rollback($conexion);
    echo "Error al registrar: " . $e->getMessage();
}

// Cerrar la conexión
mysqli_close($conexion);
?>
