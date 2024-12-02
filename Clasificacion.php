<?php
// Ajusta estos valores según tu configuración
$servername = "localhost";  // Puede ser "localhost" o la IP de tu servidor
$username = "root";         // Usuario MySQL
$password = "clave"; // Aquí va la contraseña correcta de tu base de datos
$dbname = "Farmacia";       // Nombre de la base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta SQL para obtener los datos
$sql = "
    SELECT 
        c.Tipo AS Clasificación, 
        SUM(m.Cantidad) AS Cantidad_Total
    FROM 
        Medicamentos m
    JOIN 
        Clasificacion c ON m.idClasificacion = c.idClasificacion
    GROUP BY 
        c.Tipo;
";

$result = $conn->query($sql);

// Empezamos a generar el HTML con el diseño

echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Medicamentos - Sistema de Farmacia</title>
    <link rel='stylesheet' href='ClasMedicamento.css'> <!-- Archivo de estilos CSS -->
</head>
<body>
    <header class='header'>
        <div class='header-box'>
            <img src='Logo farmacia.png' alt='Logo de la Farmacia' class='header-logo'>
            <h1>Medicamentos</h1>
        </div>
        <div class='search-container'>
            <input type='text' placeholder='Buscar medicamento...' class='search-input' id='searchInput'>
        </div>
    </header>

    <main class='main-container'>
        <table class='medicamentos-table'>
            <thead>
                <tr>
                    <th>Categoría</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>";

if ($result->num_rows > 0) {
    // Mostrar los resultados de la consulta en la tabla
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['Clasificación'] . "</td>
                <td>" . $row['Cantidad_Total'] . "</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='2'>No se encontraron resultados</td></tr>";
}

echo "  </tbody>
        </table>
        <div class='button-container'>
            <a href='Sistema-farmacia.html' class='back-button'><< Regresar al Menú Principal</a>
        </div>
    </main>
</body>
</html>";

$conn->close();
?>
