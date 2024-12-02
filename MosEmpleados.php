<?php
// Configuración de la base de datos
$server = "localhost";
$user = "root";
$pass = "clave";  // Cambia esta clave por la correcta
$db = "Farmacia";

// Crear conexión
$conexion = mysqli_connect($server, $user, $pass, $db);

// Verificar conexión
if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Consulta para obtener todos los empleados
$sql = "SELECT idEmpleado, Nombre, Puesto, Correo, Telefono, CURP, RFC, Salario FROM Empleados";

// Ejecutar la consulta
$result = mysqli_query($conexion, $sql);

// Verificar si hay resultados
if ($result && mysqli_num_rows($result) > 0) {
    // Mostrar los resultados en la tabla HTML
    $empleados = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $empleados = [];  // No hay empleados en la base de datos
}

// Cerrar la conexión
mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar Empleados - Sistema de Farmacia</title>
    <link rel="stylesheet" href="MosEmpleados.css"> <!-- Referencia al archivo CSS -->
</head>
<body>
    <header class="header">
        <div class="header-box">
            <img src="Logo farmacia.png" alt="Logo de la Farmacia" class="header-logo">
            <h1>Mostrar Empleados</h1>
        </div>
        <div class="search-container">
            <input type="text" placeholder="Buscar empleado..." class="search-input">
        </div>
    </header>

    <main class="main-container">
        <table class="employees-table"> <!-- Cambié la clase a "employees-table" -->
            <thead>
                <tr>
                    <th>ID Empleado</th>
                    <th>Nombre</th>
                    <th>Puesto</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>CURP</th>
                    <th>RFC</th>
                    <th>Salario</th>
                </tr>
            </thead>
            <tbody id="employeeBody">
                <!-- Insertamos las filas con los datos de los empleados -->
                <?php if (count($empleados) > 0): ?>
                    <?php foreach ($empleados as $empleado): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($empleado['idEmpleado']); ?></td>
                            <td><?php echo htmlspecialchars($empleado['Nombre']); ?></td>
                            <td><?php echo htmlspecialchars($empleado['Puesto']); ?></td>
                            <td><?php echo htmlspecialchars($empleado['Correo']); ?></td>
                            <td><?php echo htmlspecialchars($empleado['Telefono']); ?></td>
                            <td><?php echo htmlspecialchars($empleado['CURP']); ?></td>
                            <td><?php echo htmlspecialchars($empleado['RFC']); ?></td>
                            <td><?php echo htmlspecialchars($empleado['Salario']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No hay empleados registrados.</td>
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
