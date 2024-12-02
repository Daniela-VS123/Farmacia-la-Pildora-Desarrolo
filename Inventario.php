<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "clave"; // Asegúrate de usar la contraseña correcta
$dbname = "Farmacia";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta SQL para obtener los datos de inventario con agrupación y suma de cantidades
$sql = "SELECT 
            m.Nombre AS Medicamento,
            c.Tipo AS Categoria,
            SUM(m.Cantidad) AS CantidadTotal,
            m.PrecioCompra,
            m.PrecioVenta,
            m.FechaCaducidad,
            m.`Fecha de entrada` AS FechaEntrada,
            m.Lote
        FROM Medicamentos m
        JOIN Clasificacion c ON m.idClasificacion = c.idClasificacion
        GROUP BY m.Nombre, c.Tipo, m.PrecioCompra, m.PrecioVenta, m.FechaCaducidad, m.`Fecha de entrada`, m.Lote
        ORDER BY m.Nombre";

// Ejecutar la consulta
$result = $conn->query($sql);

// Verificar si la consulta fue exitosa
if (!$result) {
    die("Error en la consulta: " . $conn->error); // Imprimir el error si la consulta falla
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario - Sistema de Farmacia</title>
    <link rel="stylesheet" href="Inventario.css"> <!-- Asegúrate de que el archivo CSS esté correctamente vinculado -->
</head>
<body>
    <!-- Encabezado -->
    <header class="header">
        <div class="header-box">
            <img src="Logo farmacia.png" alt="Logo de la Farmacia" class="header-logo">
            <h1>Inventario de Medicamentos</h1>
        </div>
        <div class="search-container">
            <input type="text" placeholder="Buscar medicamento..." class="search-input" id="searchInput">
        </div>
    </header>
    
    <!-- Contenido principal -->
    <main class="main-container">
        <table class="inventory-table">
            <thead>
                <tr>
                    <th>Medicamento</th>
                    <th>Categoría</th>
                    <th>Cantidad Total</th>
                    <th>Precio de Compra</th>
                    <th>Precio de Venta</th>
                    <th>Fecha de Caducidad</th>
                    <th>Fecha de Entrada</th>
                    <th>Lote</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Mostrar los resultados de la consulta
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["Medicamento"] . "</td>
                                <td>" . $row["Categoria"] . "</td>
                                <td>" . $row["CantidadTotal"] . "</td>
                                <td>" . $row["PrecioCompra"] . "</td>
                                <td>" . $row["PrecioVenta"] . "</td>
                                <td>" . $row["FechaCaducidad"] . "</td>
                                <td>" . $row["FechaEntrada"] . "</td>
                                <td>" . $row["Lote"] . "</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No hay productos en el inventario.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="button-container">
            <a href="Sistema-farmacia.html" class="back-button"><< Regresar al Menú Principal</a>
        </div>
    </main>

    <!-- Inclusión del script de búsqueda -->
    <script>
        // Filtrado de la tabla según el texto ingresado en el campo de búsqueda
        document.getElementById('searchInput').addEventListener('input', function() {
            let filter = this.value.toUpperCase();
            let rows = document.querySelectorAll('.inventory-table tbody tr');
            rows.forEach(function(row) {
                let cells = row.getElementsByTagName('td');
                let match = false;
                for (let i = 0; i < cells.length; i++) {
                    if (cells[i].textContent.toUpperCase().includes(filter)) {
                        match = true;
                        break;
                    }
                }
                row.style.display = match ? '' : 'none';
            });
        });
    </script>
</body>
</html>
