-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-05-2022 a las 03:27:46
-- Versión del servidor: 10.4.13-MariaDB
-- Versión de PHP: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contenedores`
--

CREATE TABLE `contenedores` (
  `id_contenedores` int(11) NOT NULL,
  `nombre_contenedores` varchar(255) DEFAULT NULL,
  `latitud` varchar(255) DEFAULT NULL,
  `longitud` varchar(255) DEFAULT NULL,
  `estado` int(11) DEFAULT 1,
  `inicio` bit(1) DEFAULT b'0',
  `fin` bit(1) DEFAULT b'0',
  `codigo` varchar(10) DEFAULT NULL,
  `largo` varchar(255) DEFAULT NULL,
  `alto` varchar(255) DEFAULT NULL,
  `ancho` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `contenedores`
--

INSERT INTO `contenedores` (`id_contenedores`, `nombre_contenedores`, `latitud`, `longitud`, `estado`, `inicio`, `fin`, `codigo`, `largo`, `alto`, `ancho`, `descripcion`, `foto`) VALUES
(43, 'inicio', '-0.0765376', '-78.4336947', 3, b'1', b'0', '1', NULL, NULL, NULL, NULL, 'contenedor1.jpg'),
(44, 'contenedor 1', '-0.0763982', '-78.4332763', 3, b'1', b'0', '1', '6', '5', '7', 's', 'contenedor1.jpg'),
(45, 'punto 2', '-0.0771843', '-78.4343003', 2, b'0', b'0', '1', NULL, NULL, NULL, NULL, 'contenedor1.jpg'),
(49, 'punto 6', '-0.0762748', '-78.4324636', 1, b'0', b'0', '1', NULL, NULL, NULL, NULL, 'contenedor1.jpg'),
(50, 'punto 7', '-0.0765001', '-78.4324475', 2, b'0', b'0', '1', NULL, NULL, NULL, NULL, 'contenedor1.jpg'),
(51, 'punto 8', '-0.0754463', '-78.4333033', 2, b'0', b'0', '1', NULL, NULL, NULL, NULL, 'contenedor1.jpg'),
(53, 'punto 9', '-0.0766557', '-78.432603', 3, b'0', b'0', 'br9', '', '', '', '', 'contenedor1.jpg'),
(55, 'contenedor nuevo', '-0.0753164074475381', '-78.43473315238954', 1, b'0', b'0', 'BR1', '2', '3', '1', 'contenedor nuevo', 'contenedor1.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_contenedor`
--

CREATE TABLE `estado_contenedor` (
  `id_estado` int(11) NOT NULL,
  `nombre_estado` varchar(255) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estado_contenedor`
--

INSERT INTO `estado_contenedor` (`id_estado`, `nombre_estado`, `imagen`) VALUES
(1, 'VACIO', NULL),
(2, 'MEDIO', NULL),
(3, 'LLENO', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

CREATE TABLE `historial` (
  `id_historial` int(11) NOT NULL,
  `sensor` int(255) DEFAULT NULL,
  `estado` int(255) DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `historial`
--

INSERT INTO `historial` (`id_historial`, `sensor`, `estado`, `fecha`) VALUES
(1, 44, 1, '2022-04-09'),
(2, 49, 1, '2022-04-13'),
(3, 44, 1, '2022-05-18'),
(4, 53, 2, '2022-04-06'),
(5, 44, 2, '2022-04-13'),
(6, 45, 2, '2022-04-19'),
(7, 44, 3, '2022-04-20'),
(8, 44, 3, '2022-05-14'),
(9, 44, 2, '2022-05-15'),
(11, 51, 2, '2022-04-13'),
(12, 44, 2, '2022-05-18'),
(13, 44, 1, '2022-04-21'),
(14, 51, 2, '2022-04-20'),
(15, 44, 1, '2022-05-25'),
(16, 50, 1, '2022-04-20'),
(17, 55, 2, '2022-05-12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `id_tipo` int(11) NOT NULL,
  `detalle_tipo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id_tipo`, `detalle_tipo`) VALUES
(1, 'ADMINISTRADOR'),
(2, 'USUARIO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(255) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `ci_ruc` varchar(10) DEFAULT NULL,
  `nick` varchar(255) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `id_tipo` int(11) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `direccion`, `ci_ruc`, `nick`, `pass`, `id_tipo`, `foto`, `telefono`, `email`) VALUES
(1, 'ADMINISTRADOR', 'DIRECCION DE ADMINISTRADOR', '111111111', 'ADMIN', 'ADMIN', 1, 'usuario1.jpg', '99999999', 'javierexample.com'),
(2, 'PACO', 'CALDERON', '1722221450', 'PACO', 'PEPE', 2, 'ss', '099999999', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `contenedores`
--
ALTER TABLE `contenedores`
  ADD PRIMARY KEY (`id_contenedores`),
  ADD KEY `FK_ESTADO_CONTENEDOR` (`estado`);

--
-- Indices de la tabla `estado_contenedor`
--
ALTER TABLE `estado_contenedor`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `historial`
--
ALTER TABLE `historial`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `FK_CONTENEDOR_HISTORIAL` (`sensor`),
  ADD KEY `FK_ESTADO_HISTORIAL` (`estado`);

--
-- Indices de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `FK_TIPO_USUARIO` (`id_tipo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `contenedores`
--
ALTER TABLE `contenedores`
  MODIFY `id_contenedores` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de la tabla `estado_contenedor`
--
ALTER TABLE `estado_contenedor`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `historial`
--
ALTER TABLE `historial`
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `contenedores`
--
ALTER TABLE `contenedores`
  ADD CONSTRAINT `FK_ESTADO_CONTENEDOR` FOREIGN KEY (`estado`) REFERENCES `estado_contenedor` (`id_estado`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `historial`
--
ALTER TABLE `historial`
  ADD CONSTRAINT `FK_CONTENEDOR_HISTORIAL` FOREIGN KEY (`sensor`) REFERENCES `contenedores` (`id_contenedores`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_ESTADO_HISTORIAL` FOREIGN KEY (`estado`) REFERENCES `estado_contenedor` (`id_estado`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `FK_TIPO_USUARIO` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_usuario` (`id_tipo`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
