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

// Consulta para obtener los datos del inventario
$query = "SELECT i.idInventario, m.Nombre, i.Lote, i.Cantidad, i.PrecioCompra, i.PrecioVenta, i.FechaEntrada, i.FechaCaducidad
          FROM Inventario i
          JOIN Medicamentos m ON i.idProducto = m.idProducto
          ORDER BY i.FechaEntrada DESC"; // Puedes ordenar por cualquier campo que desees

// Ejecutar la consulta
$result = mysqli_query($conexion, $query);

// Verificar si la consulta se ejecutó correctamente
if (!$result) {
    die("Error al obtener los datos: " . mysqli_error($conexion));
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario de Medicamentos - Sistema de Farmacia</title>
    <link rel="stylesheet" href="MosEmpleados.css"> <!-- Referencia al archivo CSS -->
</head>
<body>
    <header class="header">
        <div class="header-box">
            <img src="Logo farmacia.png" alt="Logo de la Farmacia" class="header-logo">
            <h1>Inventario de Medicamentos</h1>
        </div>
        <div class="search-container">
            <input type="text" placeholder="Buscar medicamento..." class="search-input">
        </div>
    </header>

    <main class="main-container">
        <table class="employees-table">
            <thead>
                <tr>
                    <th>ID Inventario</th>
                    <th>Nombre del Producto</th>
                    <th>Lote</th>
                    <th>Cantidad</th>
                    <th>Precio de Compra</th>
                    <th>Precio de Venta</th>
                    <th>Fecha de Entrada</th>
                    <th>Fecha de Caducidad</th>
                </tr>
            </thead>
            <tbody id="employeeBody">
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['idInventario']); ?></td>
                            <td><?php echo htmlspecialchars($row['Nombre']); ?></td>
                            <td><?php echo htmlspecialchars($row['Lote']); ?></td>
                            <td><?php echo htmlspecialchars($row['Cantidad']); ?></td>
                            <td><?php echo htmlspecialchars($row['PrecioCompra']); ?></td>
                            <td><?php echo htmlspecialchars($row['PrecioVenta']); ?></td>
                            <td><?php echo htmlspecialchars($row['FechaEntrada']); ?></td>
                            <td><?php echo htmlspecialchars($row['FechaCaducidad']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No hay medicamentos registrados en el inventario.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="button-container">
            <a href="Sistema-farmacia.html" class="back-button"><< Regresar al Menú Principal</a>
        </div>
    </main>

    <script src="empleados.js"></script> <!-- Si decides agregar funcionalidad JavaScript más adelante -->
</body>
</html>

<?php
// Cerrar la conexión
mysqli_close($conexion);
?>

