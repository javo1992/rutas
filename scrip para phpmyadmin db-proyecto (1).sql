-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-01-2022 a las 15:36:11
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
  `codigo` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `contenedores`
--

INSERT INTO `contenedores` (`id_contenedores`, `nombre_contenedores`, `latitud`, `longitud`, `estado`, `inicio`, `fin`, `codigo`) VALUES
(43, 'inicio', '0.3569675240024344', '-78.11545645210407', 3, b'1', b'0', NULL),
(44, '1', '0.3552616720188183', '-78.11562826525945', 3, b'0', b'0', NULL),
(45, 'punto 2', '0.3542746380227375', '-78.11670209748046', 2, b'0', b'0', NULL),
(46, 'punto3', '0.35558353090779854', '-78.11861351883381', 2, b'0', b'0', NULL),
(47, 'punto4', '0.35407079403217095', '-78.11979243862851', 1, b'0', b'0', NULL),
(48, 'punto5', '0.35246149921270215', '-78.12168467898586', 2, b'0', b'0', NULL),
(49, 'punto 6', '0.35301938811500383', '-78.11833432245635', 1, b'0', b'0', NULL),
(50, 'punto 7', '0.3518392384745657', '-78.11832904815675', 2, b'0', b'0', NULL),
(51, 'punto 8', '0.3521825547490327', '-78.12006690141695', 2, b'0', b'0', NULL),
(52, 'fin', '0.35472524051225746', '-78.12445109655752', 2, b'0', b'1', NULL),
(53, 'punto 9', '0.3533305184498302', '-78.11605461080131', 3, b'0', b'0', 'C9'),
(54, 'punto 10', '0.3525473282767771', '-78.11640142445857', 1, b'0', b'0', 'C10');

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
  `id_tipo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `direccion`, `ci_ruc`, `nick`, `pass`, `id_tipo`) VALUES
(1, 'ADMINISTRADOR', 'DIRECCION DE ADMINISTRADOR', '111111111', 'ADMIN', 'ADMIN', 1),
(2, 'PACO', 'CALDERON', '1722221450', 'PACO', 'PEPE', 2);

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
  MODIFY `id_contenedores` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `estado_contenedor`
--
ALTER TABLE `estado_contenedor`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `FK_TIPO_USUARIO` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_usuario` (`id_tipo`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
