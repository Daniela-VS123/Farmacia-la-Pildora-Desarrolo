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

// Realizar la consulta para obtener los medicamentos
$sql = "SELECT idProducto, Nombre, Cantidad, `Fecha de entrada`, FechaCaducidad, PrecioCompra, PrecioVenta, idClasificacion, Lote, idProvedor FROM Medicamentos";  
$result = mysqli_query($conexion, $sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar Medicamentos - Sistema de Farmacia</title>
    <link rel="stylesheet" href="MosMedicamentos.css">
</head>
<body>
    <header class="header">
        <div class="header-box">
            <img src="Logo farmacia.png" alt="Logo de la Farmacia" class="header-logo">
            <h1>Mostrar Medicamentos</h1>
        </div>
        <div class="search-container">
            <input type="text" placeholder="Buscar medicamento..." class="search-input">
        </div>
    </header>

    <main class="main-container">
        <table class="inventory-table">
            <thead>
                <tr>
                    <th>Id. Producto</th>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Fecha de Entrada</th>
                    <th>Caducidad</th>
                    <th>Precio Compra</th>
                    <th>Precio Venta</th>
                    <th>Categoría</th>
                    <th>Lote</th>
                    <th>Proveedor</th>
                </tr>
            </thead>
            <tbody id="inventoryBody">
                <?php
                // Comprobar si la consulta devolvió resultados
                if ($result && mysqli_num_rows($result) > 0) {
                    // Recorrer los resultados y mostrar cada fila
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Usar htmlspecialchars para evitar posibles problemas con datos especiales
                        echo "<tr>
                                <td>" . htmlspecialchars($row['idProducto']) . "</td>  <!-- Asegúrate de que 'idProducto' sea correcto -->
                                <td>" . htmlspecialchars($row['Nombre']) . "</td>
                                <td>" . htmlspecialchars($row['Cantidad']) . "</td>
                                <td>" . htmlspecialchars($row['Fecha de entrada']) . "</td>
                                <td>" . htmlspecialchars($row['FechaCaducidad']) . "</td>
                                <td>" . htmlspecialchars($row['PrecioCompra']) . "</td>
                                <td>" . htmlspecialchars($row['PrecioVenta']) . "</td>
                                <td>" . htmlspecialchars($row['idClasificacion']) . "</td>
                                <td>" . htmlspecialchars($row['Lote']) . "</td>
                                <td>" . htmlspecialchars($row['idProvedor']) . "</td>
                              </tr>";
                    }
                } else {
                    // En caso de que no haya resultados, mostrar un mensaje
                    echo "<tr><td colspan='10'>No se encontraron medicamentos.</td></tr>";
                }

                // Cerrar la conexión
                mysqli_close($conexion);
                ?>
            </tbody>
        </table>
        <div class="button-container">
            <a href="Sistema-farmacia.html" class="back-button"><< Regresar al Menú Principal</a>
        </div>
    </main>

    <script src="inventario.js"></script> <!-- Si decides agregar funcionalidad JavaScript más adelante -->
</body>
</html>
