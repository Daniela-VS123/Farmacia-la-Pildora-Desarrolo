-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.2
-- Tiempo de generación: 02-12-2024 a las 12:45:41
-- Versión del servidor: 8.0.40
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `Farmacia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Caducidades`
--

CREATE TABLE `Caducidades` (
  `idCaducidad` int NOT NULL,
  `idProducto` int DEFAULT NULL,
  `FechaCaducidad` date DEFAULT NULL,
  `TiempoRestante` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Clasificacion`
--

CREATE TABLE `Clasificacion` (
  `idClasificacion` int NOT NULL,
  `Tipo` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `Cantidad` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Volcado de datos para la tabla `Clasificacion`
--

INSERT INTO `Clasificacion` (`idClasificacion`, `Tipo`, `Cantidad`) VALUES
(1, 'Antibiótico', 0),
(2, 'Medicamento en refrigeración', 0),
(3, 'Vitaminas/Suplementos', 0),
(4, 'Medicamento controlado', 0),
(5, 'Medicamento de libre venta', 0),
(6, 'Artículos no Medicamentos-Insumos', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Comiciones`
--

CREATE TABLE `Comiciones` (
  `idComicion` int NOT NULL,
  `idProducto` int DEFAULT NULL,
  `Porcentaje` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Controlado`
--

CREATE TABLE `Controlado` (
  `idControlado` int NOT NULL,
  `NombrePaciente` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `NombreDoctor` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `TelefonoDoctor` varchar(18) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `CedulaDoctor` varchar(40) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `Detalle` varchar(700) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Volcado de datos para la tabla `Controlado`
--

INSERT INTO `Controlado` (`idControlado`, `NombrePaciente`, `NombreDoctor`, `TelefonoDoctor`, `CedulaDoctor`, `Detalle`) VALUES
(1, 'Elias', 'jose', '4453427865', '464784', 'Por debates'),
(2, 'Elias', 'jose', '4453427865', '464784', 'medicamento para dormir'),
(3, 'Elias', 'jose', '4453427865', '464784', 'medicamento para dormir'),
(4, 'Daniela', 'Jose', '4453427865', '464784', 'Diabetes'),
(5, 'Daniela', 'Jose', '4453427865', '464784', 'Diabetes'),
(6, 'Daniela', 'Jose', '4453427865', '464784', 'Diabetes'),
(7, 'Teresa', 'jose', '4453427865', '464784', 'Medicamento para dormir'),
(8, 'Teresa', 'jose', '4453427865', '464784', 'Medicamento para Dormir');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `DetallePedidos`
--

CREATE TABLE `DetallePedidos` (
  `idDetallePedido` int NOT NULL,
  `idProducto` int DEFAULT NULL,
  `idPedido` int NOT NULL,
  `Cantidad` int DEFAULT NULL,
  `Precio` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Volcado de datos para la tabla `DetallePedidos`
--

INSERT INTO `DetallePedidos` (`idDetallePedido`, `idProducto`, `idPedido`, `Cantidad`, `Precio`) VALUES
(1, 1, 0, 1, 80.00),
(2, 1, 0, 2, 80.00),
(3, 9, 0, 2, 67.00),
(4, 9, 0, 2, 67.00),
(5, 9, 0, 2, 67.00),
(6, 10, 0, 1, 67.00),
(7, 11, 0, 1, 120.00),
(8, 14, 0, 2, 300.00),
(9, 14, 0, 2, 300.00),
(10, 1, 0, 1, 80.00),
(24, 13, 52, 1, 90.00),
(25, 9, 53, 12, 67.00),
(26, 16, 54, 12, 140.00),
(27, 9, 55, 1, 67.00),
(28, 9, 56, 1, 67.00),
(29, 1, 57, 1, 80.00),
(30, 9, 58, 3, 67.00),
(31, 1, 59, 2, 80.00),
(32, 1, 60, 2, 80.00),
(33, 1, 61, 1, 80.00),
(34, 1, 62, 13, 80.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `DetalleVentas`
--

CREATE TABLE `DetalleVentas` (
  `idDetalleVenta` int NOT NULL,
  `idVenta` int DEFAULT NULL,
  `idProducto` int DEFAULT NULL,
  `Cantidad` int DEFAULT NULL,
  `PrecioUnitario` decimal(10,2) DEFAULT NULL,
  `PrecioTotal` decimal(10,2) DEFAULT NULL,
  `idComicion` int DEFAULT NULL,
  `idControlado` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Volcado de datos para la tabla `DetalleVentas`
--

INSERT INTO `DetalleVentas` (`idDetalleVenta`, `idVenta`, `idProducto`, `Cantidad`, `PrecioUnitario`, `PrecioTotal`, `idComicion`, `idControlado`) VALUES
(1, NULL, 1, 12, 80.00, 960.00, 1, NULL),
(2, NULL, 13, 12, 90.00, 1080.00, 1, 1),
(3, NULL, 14, 2, 300.00, 600.00, 2, 2),
(4, NULL, 14, 2, 300.00, 600.00, 2, 3),
(5, NULL, 11, 3, 120.00, 360.00, 5, NULL),
(6, NULL, 11, 3, 120.00, 360.00, 5, NULL),
(7, NULL, 1, 1, 80.00, 80.00, 3, NULL),
(8, NULL, 10, 1, 67.00, 67.00, 1, NULL),
(9, NULL, 13, 1, 90.00, 90.00, 1, 4),
(10, NULL, 13, 1, 90.00, 90.00, 1, 5),
(26, NULL, 15, 1, 90.00, 90.00, 3, NULL),
(27, NULL, 14, 14, 300.00, 4200.00, 1, 7),
(28, NULL, 14, 26, 300.00, 7800.00, 1, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Empleados`
--

CREATE TABLE `Empleados` (
  `idEmpleado` int NOT NULL,
  `idSucursal` int DEFAULT NULL,
  `Nombre` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `Correo` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `Puesto` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `Telefono` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `CURP` varchar(18) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `RFC` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `Salario` decimal(10,2) DEFAULT NULL,
  `nuevaPassword` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `confirmarPassword` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Volcado de datos para la tabla `Empleados`
--

INSERT INTO `Empleados` (`idEmpleado`, `idSucursal`, `Nombre`, `Correo`, `Puesto`, `Telefono`, `CURP`, `RFC`, `Salario`, `nuevaPassword`, `confirmarPassword`) VALUES
(1, NULL, 'Alex', 'Alex@hotmail.com', 'Cajero', '4451238765', '1264834', '5343fsr', 2000.00, '123', '123rs'),
(2, NULL, 'Juan Perez', 'Juanp@hotmail.com', 'Enfermero', '44576812387', '57754398', '565dt908', 4000.00, '456', '456rs'),
(3, NULL, 'Leonardo Salazar', 'leosz@hotmaol.com', 'Gerente', '4457865432', '648907', '636ghu7', 5000.00, '123', '123rs'),
(6, NULL, 'Maria Zavala', 'mariza@gmail.com', 'Cajera', '4457809543', '737936748', '7390UDHJ', 2000.00, '$2y$10$1kfnVclUxv0zf1uh4r84Ge1TOE04wJ6TtISj1IiarHe669Pq4RyR6', NULL),
(7, NULL, 'Elias hernandez', 'eli@hotmail.com', 'Efermero', '44578994532', '25678996', '4678985cfdhg', 4000.00, '$2y$10$WvxsWsVW1fNRfH5OH58V4.BMFOwfQTA0D7.MCFUQCxLFeSAZ5n3iW', NULL),
(8, NULL, 'Monica', 'Moni@hotmail.com', 'Puesto', '4451238765', '15368347959', 'hgfhjuy64675', 2000.00, '$2y$10$hbK0mdmWiD7eR76E8J75BeW8lqc7CMWHPQW7XmN.RwdOkznF6f5ZG', NULL),
(9, NULL, 'Monica', 'Moni@hotmail.com', '', '4451238765', '15368347959', 'hgfhjuy64675', 2000.00, '$2y$10$lZlzSxjRDmJPqcHyG5/YxO6zf3wJWZ.O47we2s3fltkslyRRS5l0.', NULL),
(10, NULL, 'Monica', 'Moni@hotmail.com', '', '4451238765', '15368347959', 'hgfhjuy64675', 2000.00, '$2y$10$Bh69IDIu6QVOaNa5tzWc0u6tpbKlXZ3uvIg166W3Vjt7ls8JdRbQm', NULL),
(11, NULL, 'Lucia', 'Luci@hotmail.com', 'gerentes', '4457893256', '464930', '54tdnt8934', 2000.00, '$2y$10$PYFYdZc2tjKBjtzCq.7mK.5qGlfceqLqw38taYfbJszZouMYLOUo2', NULL),
(12, NULL, 'Lucia', 'Luci@hotmail.com', 'gerentes', '4457893256', '464930', '54tdnt8934', 2000.00, '$2y$10$uzuh.fM8TYFbs7dBh95Bnup9QzqnCMSYvSeyC8mSgBXnFBbGLsLLm', NULL),
(13, NULL, 'Lucia', 'Luci@hotmail.com', 'gerentes', '4457893256', '464930', '54tdnt8934', 2000.00, '$2y$10$ISq6lH1W3m992cFX/9nG5.0Vulwc16wnVoYvBmqeoceQNvOKP/QSu', NULL),
(14, NULL, 'Daniela', 'Luci@hotmail.com', 'dueños', '4457893256', '464930', '54tdnt8934', 2000.00, '$2y$10$2.Evat33VS4rBiJ3.REUouDmj3fZY2hxWgnDFElZgz5mTGQXPv57y', NULL),
(15, NULL, 'Lucia', 'Luci@hotmail.com', 'gerentes', '4457809543', '464930', '436gsym52', 2000.00, '$2y$10$8mbVoBPjoSUIGUOgq7sRqO0VjeMkUOLM.PJ9CLPkgBO5agEM.E3uW', NULL),
(16, NULL, 'Jesus', 'jesus123@hotmail.com', 'gerentes', '4458976578', '5372836', '63ubnehf', 2000.00, '$2y$10$wI8Z25r0GMWLeKuvvrpoGOBSE6ewSiXuGRWbErtF1vYULXOAvbbk6', NULL),
(17, NULL, 'Jesus', 'jesus123@hotmail.com', 'gerentes', '4458976578', '5372836', '63ubnehf', 2000.00, '$2y$10$cVf/yZNpcZlYJpgNPB8oSucZ.hJy6DV/iJdwQqe9DdvLeMdMsPPNq', NULL),
(18, NULL, 'Jesus', 'jesus123@hotmail.com', 'gerentes', '4458976578', '5372836', '63ubnehf', 2000.00, '$2y$10$3mThXauF1DOwt61eEFu.0.V4SJb/Zc9sH4pnx30d59pXoG9enBpSa', NULL),
(19, NULL, 'Jesus juan', 'jesus123@hotmail.com', 'gerentes', '4458976578', '5372836', '63ubnehf', 2000.00, '$2y$10$.d4/CMIk90HofpjLLXqEfew2finKU2Fh79jU4h1mqrlLrIZ5xaqK.', NULL),
(20, NULL, 'Teresa', 'ter@hotmail.com', 'dueños', '4456789390', '2636464', 'yfihy747437', 5000.00, '$2y$10$8Ejz8/jq3zjHVhYWw.wgr.WhIv.E41MSHUWQZZ3erlZ4j0jQ3OyTK', NULL),
(21, NULL, 'Daniela Vargas Sanchez', 'd.vargassanchez@ugto.mx', 'gerentes', '4451111404', '12345674', '25354tdsr', 2000.00, '$2y$10$HZYy.RCdlV4KILBUBuxFGeOL5vJcpdRJqAyu9rbY96vEztQR0ddLy', NULL),
(22, NULL, 'Erick', 'Erick@hotmail.com', 'cajeros', '4457863219', '7387664', 'tr67ttr', 1000.00, '$2y$10$Yj0R06ywk/JwikUKtxcM6uXFWwoEx0zKjsygHs3EcO563rwDgYraC', NULL),
(23, NULL, 'Erick', 'Erick@hotmail.com', 'cajeros', '4457863219', '7387664', 'tr67ttr', 1000.00, '$2y$10$PoBID6WnVvUl3VoVtFH72Oq.KcCLtTVDiFfzr2XD16r4C8b54/Ggy', NULL),
(24, NULL, 'Daniela Vargas Sanchez', 'd.vargassanchez@ugto.mx', 'dueños', '4451111404', '123425', '5r345rf5', 5000.00, '$2y$10$uLae526ir1KgvOfyDurSq.PIjncUbRvei9fdCO4w6gtTwxHsIpvhC', NULL),
(25, NULL, 'Daniela Vargas Sanchez', 'd.vargassanchez@ugto.mx', 'dueños', '4451111404', '123425', '5r345rf5', 5000.00, '123rs', NULL),
(26, NULL, 'ceci', 'ceci@hotmail.com', 'gerentes', '4456789076', '456667', 'guyf57', 2000.00, '456rs', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Estatus`
--

CREATE TABLE `Estatus` (
  `E_Regresable` int NOT NULL,
  `Detalle` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Inventario`
--

CREATE TABLE `Inventario` (
  `idInventario` int NOT NULL,
  `idSucursal` int DEFAULT NULL,
  `idProducto` int DEFAULT NULL,
  `CantidadDisponible` int DEFAULT NULL,
  `CantidadVendida` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Medicamentos`
--

CREATE TABLE `Medicamentos` (
  `idProducto` int NOT NULL,
  `Nombre` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `idClasificacion` int DEFAULT NULL,
  `FechaCaducidad` date DEFAULT NULL,
  `Cantidad` int DEFAULT NULL,
  `PrecioCompra` decimal(10,2) DEFAULT NULL,
  `PrecioVenta` decimal(10,2) DEFAULT NULL,
  `idProvedor` int DEFAULT NULL,
  `E_Regresable` int DEFAULT NULL,
  `Descripcion` varchar(700) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `Fecha de entrada` date DEFAULT NULL,
  `Lote` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Volcado de datos para la tabla `Medicamentos`
--

INSERT INTO `Medicamentos` (`idProducto`, `Nombre`, `idClasificacion`, `FechaCaducidad`, `Cantidad`, `PrecioCompra`, `PrecioVenta`, `idProvedor`, `E_Regresable`, `Descripcion`, `Fecha de entrada`, `Lote`) VALUES
(1, 'Paracetamol', 1, '2027-05-10', 25, 45.00, 80.00, 1, 1, 'GVHJ', '2024-11-29', 1),
(9, 'Descenfriol', 1, '2028-10-20', 56, 25.00, 67.00, 1, 1, 'Para dolor de cuerpo', '2024-11-29', 2),
(10, 'Descenfriol', 1, '2028-10-20', 56, 25.00, 67.00, 1, 1, 'Para dolor de cuerpo', '2024-11-29', 2),
(11, 'Vitamina', 3, '2025-04-23', 67, 50.00, 120.00, 1, 1, 'hola', '2024-11-29', 3),
(12, 'Vitamina', 3, '2025-04-23', 67, 50.00, 120.00, 1, 1, 'hola', '2024-11-29', 3),
(13, 'Penicilina', 4, '2018-05-23', 16, 45.00, 90.00, 1, 1, 'no se que poner', '2024-11-30', 4),
(14, 'Clonacepam', 4, '2029-04-12', 26, 100.00, 300.00, 1, 0, 'medicamento para dormir', '2024-11-30', 2),
(15, 'Pomada', 5, '2029-06-12', 34, 67.00, 90.00, 1, 0, 'jdjd', '2024-11-30', 2),
(16, 'Treda', 1, '2026-07-05', 67, 89.00, 140.00, 1, 1, 'Medicamento para el dolor de estomago', '2024-12-01', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Ofertas`
--

CREATE TABLE `Ofertas` (
  `idOferta` int NOT NULL,
  `idProducto` int DEFAULT NULL,
  `FechaInicio` date DEFAULT NULL,
  `FechaFin` date DEFAULT NULL,
  `PorcentajeDescuento` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Volcado de datos para la tabla `Ofertas`
--

INSERT INTO `Ofertas` (`idOferta`, `idProducto`, `FechaInicio`, `FechaFin`, `PorcentajeDescuento`) VALUES
(1, 1, '0787-12-30', '2078-03-12', 10),
(2, 10, '2024-11-30', '2025-12-10', 10),
(3, 14, '2024-12-01', '2025-01-01', 40),
(4, 14, '2024-12-01', '2025-01-01', 40),
(5, 14, '2024-12-01', '2025-01-01', 40);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Pedidos`
--

CREATE TABLE `Pedidos` (
  `idPedido` int NOT NULL,
  `idSucursal` int DEFAULT NULL,
  `idProvedor` int DEFAULT NULL,
  `FechaPedido` date DEFAULT NULL,
  `Estado` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `idDetallePedido` int DEFAULT NULL,
  `totalPedido` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Volcado de datos para la tabla `Pedidos`
--

INSERT INTO `Pedidos` (`idPedido`, `idSucursal`, `idProvedor`, `FechaPedido`, `Estado`, `idDetallePedido`, `totalPedido`) VALUES
(62, NULL, 2, '2024-12-02', 'Pendiente', NULL, 1040);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Provedores`
--

CREATE TABLE `Provedores` (
  `idProvedor` int NOT NULL,
  `Nombre` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `Telefono` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `Direccion` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Volcado de datos para la tabla `Provedores`
--

INSERT INTO `Provedores` (`idProvedor`, `Nombre`, `Telefono`, `Direccion`) VALUES
(1, 'Medical', '4451124567', 'guerrero 20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Sucursal`
--

CREATE TABLE `Sucursal` (
  `id_Sucursal` int NOT NULL,
  `Nombre` varchar(70) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `Telefono` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `Direccion` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Ventas`
--

CREATE TABLE `Ventas` (
  `idVenta` int NOT NULL,
  `idDetalleVenta` int DEFAULT NULL,
  `idSucursal` int DEFAULT NULL,
  `idEmpleado` int DEFAULT NULL,
  `FechaVenta` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Caducidades`
--
ALTER TABLE `Caducidades`
  ADD PRIMARY KEY (`idCaducidad`),
  ADD UNIQUE KEY `idProducto` (`idProducto`);

--
-- Indices de la tabla `Clasificacion`
--
ALTER TABLE `Clasificacion`
  ADD PRIMARY KEY (`idClasificacion`);

--
-- Indices de la tabla `Comiciones`
--
ALTER TABLE `Comiciones`
  ADD PRIMARY KEY (`idComicion`),
  ADD KEY `idProducto` (`idProducto`);

--
-- Indices de la tabla `Controlado`
--
ALTER TABLE `Controlado`
  ADD PRIMARY KEY (`idControlado`);

--
-- Indices de la tabla `DetallePedidos`
--
ALTER TABLE `DetallePedidos`
  ADD PRIMARY KEY (`idDetallePedido`),
  ADD KEY `idProducto` (`idProducto`);

--
-- Indices de la tabla `DetalleVentas`
--
ALTER TABLE `DetalleVentas`
  ADD PRIMARY KEY (`idDetalleVenta`),
  ADD KEY `idProducto` (`idProducto`),
  ADD KEY `idComicion` (`idComicion`),
  ADD KEY `idControlado` (`idControlado`);

--
-- Indices de la tabla `Empleados`
--
ALTER TABLE `Empleados`
  ADD PRIMARY KEY (`idEmpleado`),
  ADD KEY `idSucursal` (`idSucursal`);

--
-- Indices de la tabla `Estatus`
--
ALTER TABLE `Estatus`
  ADD PRIMARY KEY (`E_Regresable`);

--
-- Indices de la tabla `Inventario`
--
ALTER TABLE `Inventario`
  ADD PRIMARY KEY (`idInventario`),
  ADD KEY `idSucursal` (`idSucursal`),
  ADD KEY `idProducto` (`idProducto`);

--
-- Indices de la tabla `Medicamentos`
--
ALTER TABLE `Medicamentos`
  ADD PRIMARY KEY (`idProducto`),
  ADD KEY `idClasificacion` (`idClasificacion`),
  ADD KEY `idProvedor` (`idProvedor`),
  ADD KEY `E_Regresable` (`E_Regresable`);

--
-- Indices de la tabla `Ofertas`
--
ALTER TABLE `Ofertas`
  ADD PRIMARY KEY (`idOferta`),
  ADD KEY `idProducto` (`idProducto`);

--
-- Indices de la tabla `Pedidos`
--
ALTER TABLE `Pedidos`
  ADD PRIMARY KEY (`idPedido`),
  ADD KEY `idDetallePedido` (`idDetallePedido`),
  ADD KEY `idProvedor` (`idProvedor`),
  ADD KEY `idSucursal` (`idSucursal`);

--
-- Indices de la tabla `Provedores`
--
ALTER TABLE `Provedores`
  ADD PRIMARY KEY (`idProvedor`);

--
-- Indices de la tabla `Sucursal`
--
ALTER TABLE `Sucursal`
  ADD PRIMARY KEY (`id_Sucursal`);

--
-- Indices de la tabla `Ventas`
--
ALTER TABLE `Ventas`
  ADD PRIMARY KEY (`idVenta`),
  ADD KEY `idDetalleVenta` (`idDetalleVenta`),
  ADD KEY `idSucursal` (`idSucursal`),
  ADD KEY `idEmpleado` (`idEmpleado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Caducidades`
--
ALTER TABLE `Caducidades`
  MODIFY `idCaducidad` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Clasificacion`
--
ALTER TABLE `Clasificacion`
  MODIFY `idClasificacion` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `Comiciones`
--
ALTER TABLE `Comiciones`
  MODIFY `idComicion` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Controlado`
--
ALTER TABLE `Controlado`
  MODIFY `idControlado` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `DetallePedidos`
--
ALTER TABLE `DetallePedidos`
  MODIFY `idDetallePedido` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `DetalleVentas`
--
ALTER TABLE `DetalleVentas`
  MODIFY `idDetalleVenta` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `Empleados`
--
ALTER TABLE `Empleados`
  MODIFY `idEmpleado` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `Estatus`
--
ALTER TABLE `Estatus`
  MODIFY `E_Regresable` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Inventario`
--
ALTER TABLE `Inventario`
  MODIFY `idInventario` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Medicamentos`
--
ALTER TABLE `Medicamentos`
  MODIFY `idProducto` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `Ofertas`
--
ALTER TABLE `Ofertas`
  MODIFY `idOferta` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `Pedidos`
--
ALTER TABLE `Pedidos`
  MODIFY `idPedido` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de la tabla `Provedores`
--
ALTER TABLE `Provedores`
  MODIFY `idProvedor` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
