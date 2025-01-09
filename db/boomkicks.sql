-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: sql305.infinityfree.com
-- Tiempo de generación: 09-01-2025 a las 09:31:00
-- Versión del servidor: 10.6.19-MariaDB
-- Versión de PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `if0_38062014_boomkicks`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carritos`
--

CREATE TABLE `carritos` (
  `id_usuario` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_talla` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `cantidad_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_cat` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_cat`, `nombre`) VALUES
(1, 'Sneakers'),
(2, 'Running'),
(3, 'Baloncesto'),
(4, 'Fútbol'),
(5, 'Fútbol Sala'),
(6, 'Skateboarding'),
(7, 'Senderismo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedidos`
--

CREATE TABLE `detalle_pedidos` (
  `id_det_pedido` int(11) NOT NULL,
  `id_pedido` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `total` float DEFAULT NULL,
  `talla` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_pedidos`
--

INSERT INTO `detalle_pedidos` (`id_det_pedido`, `id_pedido`, `id_producto`, `total`, `talla`, `cantidad`) VALUES
(48, 54, 6, 150, 38, 1),
(54, 59, 6, 600, 42, 4),
(55, 60, 8, 240, 45, 2),
(58, 62, 5, 110, 45, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones`
--

CREATE TABLE `direcciones` (
  `id_direccion` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `telefono` int(20) DEFAULT NULL,
  `estado` text NOT NULL DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `direcciones`
--

INSERT INTO `direcciones` (`id_direccion`, `id_usuario`, `direccion`, `nombre`, `telefono`, `estado`) VALUES
(40, 3, 'Luisenstraße 62,76137,Karlsruhe,dsadsa,Alemania', 'samos', 2147483647, 'inactivo'),
(41, 3, 'Luisenstraße 62,76137,Karlsruhe,sdad,Alemania', 'Badal Khiatani Ramos', 2147483647, 'activo'),
(44, 3, 'Luisenstraße 62,76137,Karlsruhe,e,Alemania', 'Badal Khiatani Ramos', 2147483647, 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `likes`
--

CREATE TABLE `likes` (
  `id_producto` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `likes`
--

INSERT INTO `likes` (`id_producto`, `id_usuario`) VALUES
(8, 3),
(9, 3),
(32, 3),
(45, 3),
(46, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id_marca` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id_marca`, `nombre`) VALUES
(1, 'Nike'),
(2, 'Adidas'),
(3, 'Jordan'),
(6, 'Asics'),
(8, 'Timberland'),
(9, 'Salomon'),
(10, 'DC');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `estado` varchar(255) NOT NULL DEFAULT 'En proceso',
  `total` float DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `num_pedido` int(11) DEFAULT NULL,
  `id_direccion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `id_usuario`, `estado`, `total`, `fecha`, `num_pedido`, `id_direccion`) VALUES
(54, 3, 'En proceso', 150, '2025-01-06 18:23:02', 6720139, 40),
(58, 3, 'En proceso', 2, '2025-01-06 20:25:09', 6505397, 40),
(59, 3, 'En proceso', 600, '2025-01-06 22:36:31', 6652424, 41),
(60, 3, 'En proceso', 240, '2025-01-06 22:47:01', 9798526, 41),
(62, 3, 'En proceso', 110, '2025-01-07 14:24:11', 3526789, 44);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `color` varchar(255) NOT NULL,
  `descripcion` varchar(1000) DEFAULT 'Estos zapatos no necesitan presentación. ¡Simplemente irresistibles!',
  `precio` float DEFAULT NULL,
  `descuento` float DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `vendidos` int(11) NOT NULL DEFAULT 0,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_marca` int(11) DEFAULT NULL,
  `id_cat` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre`, `color`, `descripcion`, `precio`, `descuento`, `imagen`, `vendidos`, `fecha`, `id_marca`, `id_cat`) VALUES
(3, 'Nike Air Force 1', 'Blanco', 'Estos zapatos no necesitan presentación. ¡Simplemente irresistibles!', 99.3, NULL, '/recursos/img/zapatillas/airforce/img01.avif', 11, '2024-12-17 20:49:06', 1, 1),
(5, 'Adidas SuperStar', 'Blanco y Negro', 'Estos zapatos no necesitan presentación. ¡Simplemente irresistibles!', 110, NULL, '/recursos/img/zapatillas/Adidas-Super/img01.avif', 92, '2024-12-17 20:49:06', 2, 1),
(6, 'Jordan 1', 'Rojo ', 'Estos zapatos no necesitan presentación. ¡Simplemente irresistibles!Estos zapatos no necesitan presentación. ¡Simplemente irresistibles!', 150, NULL, '/recursos/img/zapatillas/Jordan-1/img01.avif', 86, '2024-12-17 20:49:06', 3, 1),
(7, 'Jordan Jumpman Jack', 'Marrón oscuro', 'Estos zapatos no necesitan presentación. ¡Simplemente irresistibles!Estos zapatos no aaaaaaaaaaaaaa', 150, NULL, '/recursos/img/zapatillas/Jordan-Jumpman/img01.avif', 0, '2024-12-17 20:50:44', 3, 1),
(8, 'Nike SB Dunk Low', 'Multicolor', 'Estos zapatos no necesitan presentación. ¡Simplemente irresistibles!', 120, NULL, '/recursos/img/zapatillas/Nike-Ben/img01.avif', 33, '2024-12-17 20:59:28', 1, 1),
(9, 'Adidas Adizero 3', 'Marrón claro', 'Estos zapatos no necesitan presentación. ¡Simplemente irresistibles!', 120, NULL, '/recursos/img/zapatillas/adidas-adizero/img01.avif', 0, '2024-12-17 21:00:00', 2, 2),
(32, 'Asics Media Naranja', 'Naranja y Azul', 'Estos zapatos no necesitan presentación. ¡Simplemente irresistibles!', 200, NULL, '/recursos/img/zapatillas/Asics-Media-Naranja/img01.avif', 1, '2025-01-07 23:02:25', 6, 2),
(36, 'Nike Zoom', 'Blanco, Azul y Naranja', 'Estos zapatos no necesitan presentación. ¡Simplemente irresistibles!', 70, NULL, ' /recursos/img/zapatillas/Nike-Zoom/img01.avif', 0, '2025-01-08 13:26:47', 1, 4),
(37, 'Nike SB Low Atmosphere', 'Vino', 'Estos zapatos no necesitan presentación. ¡Simplemente irresistibles!', 120, NULL, ' /recursos/img/zapatillas/Nike-SB-Low-Atmosphere/img01.avif', 0, '2025-01-08 13:28:27', 1, 1),
(38, 'Nike Phantom', 'Negro', 'Estos zapatos no necesitan presentación. ¡Simplemente irresistibles!', 230, NULL, ' /recursos/img/zapatillas/Nike-Phantom/img01.avif', 0, '2025-01-08 13:29:28', 1, 4),
(39, 'Nike Superfly 8', 'Blanco', 'Estos zapatos no necesitan presentación. ¡Simplemente irresistibles!', 137.5, NULL, ' /recursos/img/zapatillas/Nike-Superfly-8/img01.avif', 0, '2025-01-08 13:30:54', 1, 4),
(40, 'Nike Running Club', 'Blanco', 'Estos zapatos no necesitan presentación. ¡Simplemente irresistibles!', 140, NULL, ' /recursos/img/zapatillas/Nike-Running-Club/img01.avif', 0, '2025-01-08 13:31:36', 1, 2),
(41, 'Nike Football Girl', 'Celeste, Azul', 'Estos zapatos no necesitan presentación. ¡Simplemente irresistibles!', 90, NULL, ' /recursos/img/zapatillas/Nike-Football-Girl/img01.avif', 0, '2025-01-08 13:32:56', 1, 4),
(42, 'Asics Gel-Excite', 'Negro, Naranja', 'Estos zapatos no necesitan presentación. ¡Simplemente irresistibles!', 200, NULL, ' /recursos/img/zapatillas/Asics-Gel-Excite/img01.avif', 0, '2025-01-08 13:34:11', 6, 2),
(43, 'Adidas Top Sala', 'Azul', 'Estos zapatos no necesitan presentación. ¡Simplemente irresistibles!', 120, NULL, ' /recursos/img/zapatillas/Adidas-Top-Sala/img01.avif', 0, '2025-01-08 13:34:47', 2, 5),
(44, 'Adidas Nemeziz', 'Blanco y Azul', 'Estos zapatos no necesitan presentación. ¡Simplemente irresistibles!', 123, NULL, ' /recursos/img/zapatillas/Adidas-Nemeziz/img01.avif', 0, '2025-01-08 13:35:56', 2, 4),
(45, 'Adidas Elite', 'Azul', 'Estos zapatos no necesitan presentación. ¡Simplemente irresistibles!', 49, NULL, ' /recursos/img/zapatillas/Adidas-Elite/img01.avif', 2, '2025-01-08 13:36:55', 2, 1),
(46, 'Adidas Super Sala', 'Negro', 'Estos zapatos no necesitan presentación. ¡Simplemente irresistibles!', 90, NULL, ' /recursos/img/zapatillas/Adidas-Super-Sala/img01.avif', 0, '2025-01-08 13:38:43', 2, 5),
(49, 'Timberland Black', 'Negro', 'Estos zapatos no necesitan presentación. ¡Simplemente irresistibles!', 140, NULL, ' /recursos/img/zapatillas/Timberland-Black/img01.avif', 0, '2025-01-09 08:56:04', 8, 7),
(50, 'Salomon XT', 'Gris y plateado', 'Estos zapatos no necesitan presentación. ¡Simplemente irresistibles!', 119, NULL, ' /recursos/img/zapatillas/Salomon-XT/img01.avif', 0, '2025-01-09 08:57:48', 9, 7),
(51, 'Salomon XA', 'Gris claro', 'Estos zapatos no necesitan presentación. ¡Simplemente irresistibles!', 119, NULL, ' /recursos/img/zapatillas/Salomon-XA/img01.avif', 0, '2025-01-09 08:58:19', 9, 7),
(52, 'Jordan White Jump', 'Blanco', 'Estos zapatos no necesitan presentación. ¡Simplemente irresistibles!', 187, NULL, ' /recursos/img/zapatillas/Jordan-White-Jump/img01.avif', 0, '2025-01-09 08:59:59', 3, 3),
(53, 'Salomon XD', 'Marrón, negro, militar', 'Estos zapatos no necesitan presentación. ¡Simplemente irresistibles!', 119, NULL, ' /recursos/img/zapatillas/Salomon-XD/img01.avif', 0, '2025-01-09 09:00:50', 9, 7),
(54, 'Timberland Classic', 'Marrón', 'Estos zapatos no necesitan presentación. ¡Simplemente irresistibles!', 220, NULL, ' /recursos/img/zapatillas/Timberland-Classic/img01.avif', 0, '2025-01-09 09:01:34', 8, 7),
(55, 'Asics Skate Passion', 'Negro', 'Estos zapatos no necesitan presentación. ¡Simplemente irresistibles!', 89, NULL, ' /recursos/img/zapatillas/Asics-Skate-Passion/img01.avif', 0, '2025-01-09 09:02:19', 6, 6),
(56, 'Jordan Fear ', 'Negro, gris, blanco', 'Estos zapatos no necesitan presentación. ¡Simplemente irresistibles!', 121, NULL, ' /recursos/img/zapatillas/Jordan-Fear-/img01.avif', 0, '2025-01-09 09:03:05', 3, 3),
(57, 'Adidas Revenge', 'Rojo, blanco', 'Estos zapatos no necesitan presentación. ¡Simplemente irresistibles!', 170, NULL, ' /recursos/img/zapatillas/Adidas-Revenge/img01.avif', 0, '2025-01-09 09:03:56', 2, 3),
(58, 'Nike Fire ', 'Negro, naranja', 'Estos zapatos no necesitan presentación. ¡Simplemente irresistibles!', 200, NULL, ' /recursos/img/zapatillas/Nike-Fire-/img01.avif', 0, '2025-01-09 09:04:34', 1, 4),
(59, 'DC Purple Team', 'Violeta, blanco', 'Estos zapatos no necesitan presentación. ¡Simplemente irresistibles!', 100, NULL, ' /recursos/img/zapatillas/DC-Purple-Team/img01.avif', 0, '2025-01-09 09:05:19', 10, 6),
(60, 'DC Spectre', 'Negro, violeta', 'Estos zapatos no necesitan presentación. ¡Simplemente irresistibles!', 100, NULL, ' /recursos/img/zapatillas/DC-Spectre/img01.avif', 0, '2025-01-09 09:05:52', 10, 6),
(61, 'Asics Japan', 'Blanco, Beige', 'Estos zapatos no necesitan presentación. ¡Simplemente irresistibles!', 89, NULL, ' /recursos/img/zapatillas/Asics-Japan/img01.avif', 0, '2025-01-09 09:06:20', 6, 6),
(62, 'Air Jordan Take II', 'Blanco, rojo', 'Estos zapatos no necesitan presentación. ¡Simplemente irresistibles!', 130, NULL, ' /recursos/img/zapatillas/Air-Jordan-Take-II/img01.avif', 0, '2025-01-09 09:06:58', 3, 3),
(63, 'Adidas Crazy', 'Negro, rojo, azul, blanco', 'Estos zapatos no necesitan presentación. ¡Simplemente irresistibles!', 121, NULL, ' /recursos/img/zapatillas/Adidas-Crazy/img01.avif', 0, '2025-01-09 09:07:38', 2, 3),
(64, 'Adidas Bussesitzt', 'Beige, marrón', 'Estos zapatos no necesitan presentación. ¡Simplemente irresistibles!', 95, NULL, ' /recursos/img/zapatillas/Adidas-Bussesitzt/img01.avif', 0, '2025-01-09 09:08:35', 2, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_talla`
--

CREATE TABLE `producto_talla` (
  `id_producto` int(11) NOT NULL,
  `id_talla` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto_talla`
--

INSERT INTO `producto_talla` (`id_producto`, `id_talla`, `cantidad`) VALUES
(3, 7, 9),
(32, 3, 10),
(32, 4, 10),
(32, 5, 10),
(32, 6, 200),
(32, 7, 10),
(32, 8, 10),
(32, 9, 10),
(32, 10, 10),
(32, 11, 10),
(32, 12, 10),
(32, 13, 9),
(5, 3, 50),
(5, 4, 50),
(5, 5, 20),
(5, 6, 1),
(5, 7, 25),
(5, 8, 56),
(6, 3, 20),
(6, 4, 65),
(6, 12, 44),
(6, 10, 32),
(6, 8, 22),
(6, 6, 20),
(7, 6, 45),
(7, 12, 3),
(7, 10, 2),
(8, 6, 20),
(8, 7, 11),
(8, 8, 23),
(8, 9, 66),
(8, 10, 23),
(8, 11, 21),
(8, 12, 22),
(8, 13, 33),
(9, 6, 23),
(9, 7, 11),
(9, 8, 23),
(36, 6, 10),
(36, 8, 2),
(36, 3, 1),
(37, 7, 13),
(37, 6, 20),
(37, 8, 1),
(38, 6, 40),
(38, 7, 20),
(38, 8, 29),
(38, 9, 30),
(38, 10, 4),
(39, 7, 12),
(39, 3, 21),
(40, 6, 20),
(41, 3, 3),
(41, 14, 2),
(41, 10, 2),
(42, 12, 3),
(42, 1, 7),
(42, 12, 3),
(42, 10, 2),
(42, 9, 45),
(43, 1, 23),
(43, 2, 34),
(45, 7, 30),
(46, 7, 12),
(49, 7, 10),
(49, 4, 2),
(49, 12, 31),
(49, 11, 32),
(49, 10, 28),
(50, 6, 12),
(50, 10, 32),
(51, 7, 19),
(52, 7, 12),
(53, 1, 23),
(53, 2, 23),
(53, 5, 123),
(53, 7, 11),
(53, 10, 2),
(54, 7, 12),
(54, 8, 23),
(54, 10, 23),
(55, 6, 12),
(55, 5, 12),
(55, 4, 10),
(56, 7, 21),
(57, 6, 22),
(57, 7, 12),
(58, 5, 21),
(58, 7, 45),
(59, 6, 23),
(59, 7, 21),
(60, 7, 12),
(61, 6, 21),
(61, 12, 11),
(62, 7, 11),
(62, 8, 12),
(62, 9, 43),
(63, 1, 23),
(63, 2, 33),
(63, 3, 33),
(63, 4, 21),
(64, 4, 34),
(64, 5, 44),
(64, 6, 21),
(64, 7, 11),
(64, 8, 23),
(64, 9, 33),
(64, 10, 44);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tallas`
--

CREATE TABLE `tallas` (
  `id_talla` int(11) NOT NULL,
  `numero` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tallas`
--

INSERT INTO `tallas` (`id_talla`, `numero`) VALUES
(44, 12),
(46, 23),
(41, 33),
(1, 34),
(2, 35),
(3, 36),
(4, 37),
(5, 38),
(6, 39),
(7, 40),
(8, 41),
(9, 42),
(10, 43),
(11, 44),
(12, 45),
(13, 46),
(14, 47),
(42, 49),
(43, 50),
(45, 56);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `tipo` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `email`, `pass`, `tipo`) VALUES
(3, 'Admin', 'admin@admin.com', '123456', 1),
(32, 'Cliente', 'cliente@cliente.com', '123456', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carritos`
--
ALTER TABLE `carritos`
  ADD UNIQUE KEY `id_usuario_2` (`id_usuario`,`id_producto`,`id_talla`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_talla` (`id_talla`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_cat`);

--
-- Indices de la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  ADD PRIMARY KEY (`id_det_pedido`),
  ADD KEY `id_pedido` (`id_pedido`) USING BTREE,
  ADD KEY `detalle_pedidos_ibfk_2` (`id_producto`);

--
-- Indices de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD PRIMARY KEY (`id_direccion`),
  ADD KEY `direcciones_ibfk_1` (`id_usuario`);

--
-- Indices de la tabla `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id_producto`,`id_usuario`),
  ADD KEY `likes_ibfk_2` (`id_usuario`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id_marca`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD UNIQUE KEY `num_pedido` (`num_pedido`),
  ADD KEY `pedidos_ibfk_1` (`id_usuario`),
  ADD KEY `id_direccion_fk_2` (`id_direccion`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_marca` (`id_marca`),
  ADD KEY `id_cat` (`id_cat`);

--
-- Indices de la tabla `producto_talla`
--
ALTER TABLE `producto_talla`
  ADD KEY `id_producto` (`id_producto`) USING BTREE,
  ADD KEY `id_talla` (`id_talla`) USING BTREE;

--
-- Indices de la tabla `tallas`
--
ALTER TABLE `tallas`
  ADD PRIMARY KEY (`id_talla`),
  ADD UNIQUE KEY `numero` (`numero`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_cat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  MODIFY `id_det_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  MODIFY `id_direccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de la tabla `tallas`
--
ALTER TABLE `tallas`
  MODIFY `id_talla` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carritos`
--
ALTER TABLE `carritos`
  ADD CONSTRAINT `id_producto_fkfk` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_talla_fk` FOREIGN KEY (`id_talla`) REFERENCES `tallas` (`id_talla`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_usario_fk` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  ADD CONSTRAINT `detalle_pedidos_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_pedidos_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD CONSTRAINT `direcciones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `id_direccion_fk_2` FOREIGN KEY (`id_direccion`) REFERENCES `direcciones` (`id_direccion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_marca`) REFERENCES `marcas` (`id_marca`),
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`id_cat`) REFERENCES `categorias` (`id_cat`);

--
-- Filtros para la tabla `producto_talla`
--
ALTER TABLE `producto_talla`
  ADD CONSTRAINT `producto_talla_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `producto_talla_ibfk_2` FOREIGN KEY (`id_talla`) REFERENCES `tallas` (`id_talla`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
