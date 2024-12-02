<?php
// Configuración de la base de datos
$servername = "localhost";  
$username = "root";        
$password = "clave"; 
$dbname = "Farmacia";      

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta SQL para obtener los medicamentos y su fecha de caducidad
$sql = "
    SELECT 
        m.Nombre, 
        m.FechaCaducidad, 
        DATEDIFF(m.FechaCaducidad, CURDATE()) AS TiempoRestante
    FROM 
        Medicamentos m
    WHERE 
        m.FechaCaducidad >= CURDATE()
    ORDER BY 
        m.FechaCaducidad ASC;
";

$result = $conn->query($sql);

// Comienza a generar el HTML para la tabla
echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Caducidades - Sistema de Farmacia</title>
    <link rel='stylesheet' href='ClasMedicamento.css'>
</head>
<body>
    <header class='header'>
        <div class='header-box'>
            <img src='Logo farmacia.png' alt='Logo de la Farmacia' class='header-logo'>
            <h1>Medicamentos - Caducidades</h1>
        </div>
    </header>

    <main class='main-container'>
        <table class='medicamentos-table'>
            <thead>
                <tr>
                    <th>Nombre del Medicamento</th>
                    <th>Fecha de Caducidad</th>
                    <th>Tiempo Restante (días)</th>
                </tr>
            </thead>
            <tbody>";

if ($result->num_rows > 0) {
    // Mostrar los resultados en la tabla
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['Nombre'] . "</td>
                <td>" . $row['FechaCaducidad'] . "</td>
                <td>" . $row['TiempoRestante'] . " días</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='3'>No se encontraron productos con fecha de caducidad futura.</td></tr>";
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
