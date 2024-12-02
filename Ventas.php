<?php
$server = "localhost";
$user = "root";  // Cambia esto si es necesario
$pass = "clave"; // Cambia esto si es necesario
$db = "Farmacia";

// Crear conexión
$conexion = mysqli_connect($server, $user, $pass, $db);

// Verificar conexión
if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Consulta SQL para obtener los datos de la base de datos
$query = "
    SELECT 
        dv.idDetalleVenta,
        dv.idProducto,
        dv.Cantidad,
        dv.PrecioUnitario,
        dv.PrecioTotal,
        dv.idComicion,
        dv.idControlado,
        c.NombrePaciente,
        c.NombreDoctor,
        c.TelefonoDoctor,
        c.CedulaDoctor,
        c.Detalle
    FROM DetalleVentas dv
    LEFT JOIN Controlado c ON dv.idControlado = c.idControlado
";

// Ejecutar la consulta
$result = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas - Sistema de Farmacia</title>
    <link rel="stylesheet" href="MosEmpleados.css"> <!-- Aquí usas el mismo archivo CSS -->
</head>
<body>
    <header class="header">
        <div class="header-box">
            <img src="Logo farmacia.png" alt="Logo de la Farmacia" class="header-logo">
            <h1>Ventas</h1>
        </div>
        <div class="search-container">
            <input type="text" placeholder="Buscar venta..." class="search-input" id="searchInput">
        </div>
    </header>

    <main class="main-container">
        <table class="employees-table">
            <thead>
                <tr>
                    <th>ID Detalle Venta</th>
                    <th>ID Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Precio Total</th>
                    <th>ID Comición</th>
                    <th>ID Controlado</th>
                    <th>Nombre Paciente</th>
                    <th>Nombre Doctor</th>
                    <th>Teléfono Doctor</th>
                    <th>Cédula Doctor</th>
                    <th>Detalle</th>
                </tr>
            </thead>
            <tbody id="employeesBody">
                <?php
                // Si hay resultados, los mostramos en la tabla
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['idDetalleVenta'] . "</td>";
                        echo "<td>" . $row['idProducto'] . "</td>";
                        echo "<td>" . $row['Cantidad'] . "</td>";
                        echo "<td>" . $row['PrecioUnitario'] . "</td>";
                        echo "<td>" . $row['PrecioTotal'] . "</td>";
                        echo "<td>" . $row['idComicion'] . "</td>";
                        echo "<td>" . $row['idControlado'] . "</td>";

                        // Mostrar los datos del controlado si existe
                        if ($row['idControlado']) {
                            echo "<td>" . $row['NombrePaciente'] . "</td>";
                            echo "<td>" . $row['NombreDoctor'] . "</td>";
                            echo "<td>" . $row['TelefonoDoctor'] . "</td>";
                            echo "<td>" . $row['CedulaDoctor'] . "</td>";
                            echo "<td>" . $row['Detalle'] . "</td>";
                        } else {
                            echo "<td colspan='5'>No Controlado</td>";
                        }

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='12'>No se encontraron resultados.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <div class="button-container">
            <a href="Sistema-farmacia.html" class="back-button"><< Regresar al Menú Principal</a>
        </div>
    </main>

    <script src="empleados.js"></script> <!-- Si necesitas algún script adicional -->
</body>
</html>

<?php
// Cerrar la conexión
mysqli_close($conexion);
?>

