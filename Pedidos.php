<?php
// Conectar a la base de datos
$server = "localhost";
$user = "root";
$pass = "clave"; 
$db = "Farmacia";

// Crear la conexión
$conexion = mysqli_connect($server, $user, $pass, $db);

// Verificar la conexión
if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Obtener los productos desde la base de datos
$sqlProductos = "SELECT idProducto, Nombre, PrecioVenta FROM Medicamentos";
$resultProductos = mysqli_query($conexion, $sqlProductos);

// Verificar si la consulta ha devuelto productos
$productos = [];
if ($resultProductos) {
    while ($row = mysqli_fetch_assoc($resultProductos)) {
        $productos[] = $row;
    }
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);

// Procesar el formulario si se recibe una solicitud POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conexion = mysqli_connect($server, $user, $pass, $db);

    // Verificar la conexión
    if (!$conexion) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    // Obtener los datos enviados desde el formulario
    $proveedorSeleccionado = $_POST['proveedorSeleccionado'];
    $productosSeleccionados = $_POST['productoSeleccionado'];
    $cantidades = $_POST['cantidad'];
    $precios = $_POST['precio'];
    $totalProductos = $_POST['totalProducto']; // Este campo contiene el precio total calculado por producto
    $fechaPedido = date('Y-m-d');  // Fecha actual del pedido

    // Calcular el total del pedido
    $totalPedido = 0;
    for ($i = 0; $i < count($productosSeleccionados); $i++) {
        $totalPedido += $cantidades[$i] * $precios[$i];  // Total por producto
    }

    // Insertar el pedido en la tabla Pedidos con el total calculado
    $sqlPedido = "INSERT INTO Pedidos (idProvedor, FechaPedido, Estado, totalPedido) VALUES (?, ?, 'Pendiente', ?)";
    $stmtPedido = mysqli_prepare($conexion, $sqlPedido);

    if ($stmtPedido) {
        mysqli_stmt_bind_param($stmtPedido, "isd", $proveedorSeleccionado, $fechaPedido, $totalPedido);
        $ejecutado = mysqli_stmt_execute($stmtPedido);

        if ($ejecutado) {
            // Obtener el ID del pedido recién insertado
            $idPedido = mysqli_insert_id($conexion);

            // Insertar los detalles del pedido (productos y cantidades) en la tabla DetallePedidos
            $sqlDetallePedido = "INSERT INTO DetallePedidos (idPedido, idProducto, Cantidad, Precio) VALUES (?, ?, ?, ?)";
            $stmtDetallePedido = mysqli_prepare($conexion, $sqlDetallePedido);

            if ($stmtDetallePedido) {
                // Iterar a través de los productos seleccionados
                for ($i = 0; $i < count($productosSeleccionados); $i++) {
                    $producto = $productosSeleccionados[$i];
                    $cantidad = $cantidades[$i];
                    $precio = $precios[$i];

                    // Insertar cada producto en la tabla DetallePedidos
                    mysqli_stmt_bind_param($stmtDetallePedido, "iiid", $idPedido, $producto, $cantidad, $precio);
                    if (!mysqli_stmt_execute($stmtDetallePedido)) {
                        echo "Error al insertar detalle del pedido: " . mysqli_error($conexion);
                    }
                }

                // Redireccionar a la página verPedidos.php después de realizar el pedido
                header("Location: VerPedidos.php");
                exit; // Asegura que el script se detenga aquí
            } else {
                echo "Error al preparar la consulta para el detalle del pedido: " . mysqli_error($conexion);
            }
        } else {
            echo "Error al realizar el pedido: " . mysqli_error($conexion);
        }
    } else {
        echo "Error al preparar la consulta para el pedido: " . mysqli_error($conexion);
    }

    // Cerrar la conexión
    mysqli_close($conexion);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar Pedido a Proveedor - Sistema de Farmacia</title>
    <link rel="stylesheet" href="Pedidos.css"> <!-- Archivo CSS para estilos -->
</head>
<body>
    <header class="header">
        <div class="header-box">
            <img src="Logo farmacia.png" alt="Logo de la Farmacia" class="header-logo">
            <h1>Realizar Pedido a Proveedor</h1>
        </div>
    </header>

    <main class="main-container">
        <!-- Formulario para realizar un pedido a proveedor -->
        <form id="orderForm" class="order-form" method="POST" action="Pedidos.php">
            <table class="order-table">
                <tr>
                    <td><label for="proveedorSeleccionado">Proveedor:</label></td>
                    <td>
                        <select id="proveedorSeleccionado" name="proveedorSeleccionado" required onchange="habilitarProducto()">
                            <option value="" disabled selected>Seleccione un proveedor</option>
                            <option value="1">Proveedor A</option>
                            <option value="2">Proveedor B</option>
                            <option value="3">Proveedor C</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="productoSeleccionado">Producto(s):</label></td>
                    <td>
                        <select id="productoSeleccionado" name="productoSeleccionado[]" multiple required onchange="actualizarPrecio()">
                            <option value="" disabled selected>Seleccione productos</option>
                            <?php foreach ($productos as $producto): ?>
                                <option value="<?= $producto['idProducto'] ?>" data-precio="<?= $producto['PrecioVenta'] ?>"><?= $producto['Nombre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="cantidad">Cantidad(s):</label></td>
                    <td><input type="number" id="cantidad" name="cantidad[]" min="1" required></td>
                </tr>
                <tr>
                    <td><label for="precio">Precio del Producto:</label></td>
                    <td>
                        <input type="text" id="precio" name="precio[]" readonly>
                    </td>
                </tr>
                <tr>
                    <td><label for="totalProducto">Precio Total:</label></td>
                    <td>
                        <input type="text" id="totalProducto" name="totalProducto[]" readonly>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="button" class="add-product-button" onclick="agregarProducto()">Agregar Producto</button>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <h3>Total del Pedido: <span id="precioTotalPedido">0</span> MXN</h3>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="button-container">
                        <button type="submit" class="submit-button">Realizar Pedido</button>
                        <a href="Sistema-farmacia.html" class="cancel-button">Cancelar</a>
                    </td>
                </tr>
            </table>
        </form>
    </main>

    <script src="pedidosProveedor.js"></script> <!-- Archivo JavaScript -->

    <script>
        // Función para habilitar el campo de selección de productos solo después de seleccionar un proveedor
        function habilitarProducto() {
            var proveedorSeleccionado = document.getElementById("proveedorSeleccionado").value;
            var productoSelect = document.getElementById("productoSeleccionado");

            // Habilitar el select de productos si se ha seleccionado un proveedor
            if (proveedorSeleccionado) {
                productoSelect.disabled = false;
            } else {
                productoSelect.disabled = true;
            }
        }

        // Función para actualizar el precio cuando se selecciona un producto
        function actualizarPrecio() {
            var selectedOptions = document.getElementById("productoSeleccionado").selectedOptions;
            var precioTotal = 0;
            var precios = [];

            // Recorre los productos seleccionados
            for (var i = 0; i < selectedOptions.length; i++) {
                var precio = selectedOptions[i].getAttribute("data-precio");
                precios.push(precio);
            }

            // Mostrar el precio en el campo correspondiente
            document.getElementById("precio").value = precios.join(", ");
        }

        // Función para agregar un producto y calcular el precio total
        function agregarProducto() {
            var productoSelect = document.getElementById("productoSeleccionado");
            var cantidadInput = document.getElementById("cantidad");
            var precioInput = document.getElementById("precio");
            var totalProductoInput = document.getElementById("totalProducto");

            // Calcular el precio total del producto
            var cantidad = cantidadInput.value;
            var precio = parseFloat(precioInput.value);
            var totalProducto = cantidad * precio;

            // Agregar el precio total al formulario
            totalProductoInput.value = totalProducto.toFixed(2);

            // Calcular el precio total del pedido
            var precioTotal = 0;
            var totalProductos = document.getElementsByName("totalProducto[]");

            for (var i = 0; i < totalProductos.length; i++) {
                precioTotal += parseFloat(totalProductos[i].value || 0);
            }

            // Actualizar el total del pedido
            document.getElementById("precioTotalPedido").textContent = precioTotal.toFixed(2);
        }
    </script>
</body>
</html>
