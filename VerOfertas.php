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

// Consulta para obtener las ofertas y precios
$sql = "SELECT o.idOferta, o.FechaInicio, o.FechaFin, o.PorcentajeDescuento, 
                m.Nombre, m.PrecioVenta 
        FROM Ofertas o
        JOIN Medicamentos m ON o.idProducto = m.idProducto";

// Ejecutar la consulta
$result = mysqli_query($conexion, $sql);

// Verificar si hay resultados
if ($result && mysqli_num_rows($result) > 0) {
    // Mostrar los resultados en la tabla HTML
    $ofertas = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $ofertas = [];  // No hay ofertas en la base de datos
}

// Cerrar la conexión
mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar Ofertas - Sistema de Farmacia</title>
    <link rel="stylesheet" href="MosEmpleados.css"> <!-- Usar el mismo CSS que para Empleados -->
</head>
<body>
    <header class="header">
        <div class="header-box">
            <img src="Logo farmacia.png" alt="Logo de la Farmacia" class="header-logo">
            <h1>Mostrar Ofertas</h1>
        </div>
        <div class="search-container">
            <input type="text" placeholder="Buscar oferta..." class="search-input">
        </div>
    </header>

    <main class="main-container">
        <table class="employees-table"> <!-- Usar la misma clase "employees-table" para la tabla -->
            <thead>
                <tr>
                    <th>ID Oferta</th>
                    <th>Producto</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Descuento (%)</th>
                    <th>Precio Original</th>
                    <th>Precio con Descuento</th>
                </tr>
            </thead>
            <tbody id="employeeBody">
                <!-- Insertamos las filas con los datos de las ofertas -->
                <?php if (count($ofertas) > 0): ?>
                    <?php foreach ($ofertas as $oferta): ?>
                        <?php
                            // Calculamos el precio con descuento
                            $precioOriginal = $oferta['PrecioVenta'];
                            $precioDescuento = $precioOriginal * (1 - $oferta['PorcentajeDescuento'] / 100);
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($oferta['idOferta']); ?></td>
                            <td><?php echo htmlspecialchars($oferta['Nombre']); ?></td>
                            <td><?php echo htmlspecialchars($oferta['FechaInicio']); ?></td>
                            <td><?php echo htmlspecialchars($oferta['FechaFin']); ?></td>
                            <td><?php echo htmlspecialchars($oferta['PorcentajeDescuento']); ?>%</td>
                            <td>$<?php echo number_format($precioOriginal, 2); ?></td>
                            <td>$<?php echo number_format($precioDescuento, 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No hay ofertas registradas.</td>
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
