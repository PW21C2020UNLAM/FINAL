-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-07-2020 a las 01:55:20
-- Versión del servidor: 8.0.18
-- Versión de PHP: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pw2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticias`
--

CREATE TABLE `noticias` (
  `cantidadDescargas` int(20) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `idNoticia` varchar(20) NOT NULL,
  `idPublicacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `noticias`
--

INSERT INTO `noticias` (`cantidadDescargas`, `estado`, `idNoticia`, `idPublicacion`) VALUES
(0, 'rechazada', '20200628165816', 1),
(5, 'aceptada', '20200628165850', 1),
(0, 'aceptada', '20200628165912', 6),
(9, 'aceptada', '20200628185307', 6),
(1, 'aceptada', '20200628205914', 1),
(10, 'aceptada', '20200628214335', 2),
(1, 'aceptada', '20200629003055', 2),
(0, 'rechazada', '20200629190351', 3),
(0, 'rechazada', '20200703211751', 6),
(0, 'rechazada', '20200703220704', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicacion`
--

CREATE TABLE `publicacion` (
  `esPremium` tinyint(4) NOT NULL,
  `estado` varchar(45) NOT NULL,
  `idPublicacion` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `publicacion`
--

INSERT INTO `publicacion` (`esPremium`, `estado`, `idPublicacion`, `nombre`) VALUES
(0, 'aprobada', 1, 'Caras'),
(0, 'aprobada', 2, 'El Grafico'),
(1, 'rechazada', 3, 'La Cosa Cine'),
(1, 'aprobada', 6, 'El Oso Ochentoso'),
(1, 'rechazada', 7, 'Fulbacho'),
(1, 'aprobada', 8, 'Zona Gamer'),
(1, 'aprobada', 9, 'El Gourmet');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suscripcion`
--

CREATE TABLE `suscripcion` (
  `idSuscripcion` int(11) NOT NULL,
  `idPublicacion` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `suscripcion`
--

INSERT INTO `suscripcion` (`idSuscripcion`, `idPublicacion`, `usuario`) VALUES
(1, 6, 'sebeatport');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `clave` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `rol` varchar(50) NOT NULL,
  `suscriptorPorDefecto` tinyint(1) NOT NULL,
  `usuario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`clave`, `email`, `rol`, `suscriptorPorDefecto`, `usuario`) VALUES
('81dc9bdb52d04dc20036dbd8313ed055', 'conte@gg.com', 'contenidista', 1, 'conte'),
('81dc9bdb52d04dc20036dbd8313ed055', 'contenidista@gg.com', 'contenidista', 1, 'contenidista'),
('81dc9bdb52d04dc20036dbd8313ed055', 'sebeatport@gg.com', 'lector', 0, 'sebeatport'),
('81dc9bdb52d04dc20036dbd8313ed055', 'sebi@gg.com', 'lector', 0, 'sebi'),
('81dc9bdb52d04dc20036dbd8313ed055', 'sebicontenidista@gg.com', 'contenidista', 1, 'sebicontenidista'),
('0b180078d994cb2b5ed89d7ce8e7eea2', 'administracion@infonete.com', 'admin', 1, 'su');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`idNoticia`),
  ADD KEY `idPublicacion` (`idPublicacion`);

--
-- Indices de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  ADD PRIMARY KEY (`idPublicacion`);

--
-- Indices de la tabla `suscripcion`
--
ALTER TABLE `suscripcion`
  ADD PRIMARY KEY (`idSuscripcion`),
  ADD KEY `idPublicacion` (`idPublicacion`),
  ADD KEY `usuario` (`usuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  MODIFY `idPublicacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `suscripcion`
--
ALTER TABLE `suscripcion`
  MODIFY `idSuscripcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD CONSTRAINT `noticias_ibfk_1` FOREIGN KEY (`idPublicacion`) REFERENCES `publicacion` (`idPublicacion`);

--
-- Filtros para la tabla `suscripcion`
--
ALTER TABLE `suscripcion`
  ADD CONSTRAINT `suscripcion_ibfk_1` FOREIGN KEY (`idPublicacion`) REFERENCES `publicacion` (`idPublicacion`),
  ADD CONSTRAINT `suscripcion_ibfk_2` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
