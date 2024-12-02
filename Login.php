<?php
// Verifica si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Configuración de la base de datos
    $server = "localhost";
    $user = "root";
    $pass = "clave";
    $db = "Farmacia";

    // Crear conexión
    $conexion = mysqli_connect($server, $user, $pass, $db);

    // Verificar conexión
    if ($conexion->connect_errno) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    // Verificar si los campos están establecidos
    if (isset($_POST["Nombre"]) && isset($_POST["Clave"])) {
        $usuario = $_POST["Nombre"];
        $clave = $_POST["Clave"];

        // Consulta para verificar el usuario y la contraseña
        $sql = $conexion->prepare("SELECT * FROM Empleados WHERE Nombre=? AND nuevaPassword=?");
        $sql->bind_param("ss", $usuario, $clave);
        $sql->execute();
        $result = $sql->get_result();

        // Verificar si se encontró un usuario
        if ($result->num_rows > 0) {
            // Página a la que se quiere redirigir
            header("Location: Sistema-farmacia.html");
            exit();
        } else {
            // Mensaje para cuando el usuario o la contraseña no son correctos
            echo "El nombre o contraseña son incorrectos.";
        }

        // Cerrar la conexión
        $conexion->close();
    }
}
?>
