-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-07-2020 a las 01:45:24
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
  `idPublicacion` int(11) NOT NULL,
  `tituloForm` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `subtituloForm` varchar(1000) NOT NULL,
  `fechaForm` varchar(50) NOT NULL,
  `imagenJPG` varchar(20) NOT NULL,
  `cuerpoForm` varchar(9999) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `noticias`
--

INSERT INTO `noticias` (`cantidadDescargas`, `estado`, `idNoticia`, `idPublicacion`, `tituloForm`, `subtituloForm`, `fechaForm`, `imagenJPG`, `cuerpoForm`) VALUES
(3, 'rechazada', '20200629190351', 3, 'rechazada1-3', 'subtitulosad', '29 de Junio de 2020', '20200629190351.jpg', 'sajkdhsjd shdjkdh sjahd sajjdhsa dsahdjksa as'),
(0, 'rechazada', '20200703211751', 6, 'rechazada1-6', 'asdasdada', '03 de Julio de 2020', '20200703211751.jpg', 'hsahdhajshdjajskdfdd'),
(4, 'rechazada', '20200703220704', 7, 'rechazada1-7', 'fdfdesdfsdf', '03 de Julio de 2020', '20200703220704.jpg', 'shdfgsah hgdgsh dgd'),
(0, 'rechazada', '20200709220141', 6, 'rechazada2-6', 'fdsfsdfs', '09 de Julio de 2020', '20200709220141.jpg', 'dshadg sdghsad hdds'),
(1, 'aceptada', '20200710004539', 8, 'aceptada1-8', 'dsagd dd', '10 de Julio de 2020', '20200710004539.jpg', 'fdsfg sdhfg dshfghsdf'),
(12, 'aceptada', '20200710174150', 1, 'aceptada1-1', 'sddfsdfdfsd', '10 de Julio de 2020', '20200710174150.jpg', 'dsfsdfhg gefjhdfghdsf fd'),
(0, 'aceptada', '20200710174241', 1, 'aceptada2-1', 'dsfdfdf sdff', '10 de Julio de 2020', '20200710174241.jpg', 'sdfsfsdfdhdjf dfjsjhffh'),
(1, 'aceptada', '20200710174317', 1, 'aceptada3-1', 'dsf dsf sdf', '10 de Julio de 2020', '20200710174317.jpg', 'dfdfdfdfdusfu hjdfjhdsjf'),
(0, 'aceptada', '20200710174357', 2, 'aceptada1-2', 'df esfsdf dsf', '10 de Julio de 2020', '20200710174357.jpg', 'shdgsahdghds shdghsa'),
(3, 'aceptada', '20200710181501', 6, 'aceptada1-6', 'sdrfwefdsf', '10 de Julio de 2020', '20200710181501.jpg', 'fdsfsdfddfsdf fidsfdsdfd'),
(2, 'aceptada', '20200710181833', 6, 'aceptada2-6', 'sdfdfdsf fhjdsf', '10 de Julio de 2020', '20200710181833.jpg', 'fdfdsfsdfsdf dsfsdfsdfd'),
(7, 'aceptada', '20200710181914', 9, 'aceptada1-9', 'dsfds ffdfdsd', '10 de Julio de 2020', '20200710181914.jpg', 'fghghfhhghgh hghjjghg'),
(15, 'aceptada', '20200711165803', 14, 'aceptada1-14', 'sdfff fdffdsd', '11 de Julio de 2020', '20200711165803.jpg', 'dfjhsdjkfhskdjkfjsdjk'),
(0, 'rechazada', '20200712224909', 1, 'Soy un buen titular', 'No, yo soy un buen titular', '12 de Julio de 2020', '20200712224909.jpg', 'Cállense la boca. A mí tardan más en escribirme y me dedican más tiempo, manga de giles.'),
(0, 'aceptada', '20200713171426', 10, 'prueba 1', 'sdasdas', '13 de julio de 2020', '20200713171426.jpg', 'cuerpo'),
(0, 'rechazada', '20200713171502', 10, 'prueba 2', 'sdsdfsdf', '13 de Julio de 2020', '20200713171502.jpg', 'sdhsdhfghjdf'),
(0, 'rechazada', '20200713171544', 10, 'prueba3', 'sdfsdf', '13 DE JULIO DE 2020', '20200713171544.jpg', 'CUERPO'),
(0, 'aceptada', '20200713200352', 18, 'notticiaprueba', 'subtitulo', '13 de Julio de 2020', '20200713200352.jpg', 'jksajdhjskahd sdhjkshdjksadh saddjka');

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
(1, 'aprobada', 9, 'El Gourmet'),
(1, 'aprobada', 10, 'El Garage'),
(1, 'rechazada', 11, 'Animal Planet'),
(1, 'rechazada', 12, 'Locomotion'),
(1, 'aprobada', 14, 'AnimePlus'),
(1, 'aprobada', 15, 'MangaPlus'),
(1, 'pendiente', 16, 'prueba1'),
(1, 'rechazada', 17, 'prueba2'),
(1, 'aprobada', 18, 'Cinecalidad');

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
(1, 6, 'sebeatport'),
(6, 10, 'prueba'),
(9, 6, 'maxi'),
(11, 14, 'sebi'),
(15, 8, 'luis');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `clave` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `rol` varchar(50) NOT NULL,
  `usuario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`clave`, `email`, `rol`, `usuario`) VALUES
('81dc9bdb52d04dc20036dbd8313ed055', 'cacho@gg.com', 'lector', 'cacho'),
('81dc9bdb52d04dc20036dbd8313ed055', 'conte3@gg.com', 'contenidista', 'conte3'),
('81dc9bdb52d04dc20036dbd8313ed055', 'contenidista@gg.com', 'contenidista', 'contenidista'),
('d93591bdf7860e1e4ee2fca799911215', 'j@gg.com', 'lector', 'jorge'),
('81dc9bdb52d04dc20036dbd8313ed055', 'luis@gg.com', 'lector', 'luis'),
('81dc9bdb52d04dc20036dbd8313ed055', 'maxi@unlam.com', 'lector', 'maxi'),
('81dc9bdb52d04dc20036dbd8313ed055', 'prueba@gg.com', 'lector', 'prueba'),
('81dc9bdb52d04dc20036dbd8313ed055', 'sebeatport@gg.com', 'lector', 'sebeatport'),
('81dc9bdb52d04dc20036dbd8313ed055', 'sebi@gg.com', 'lector', 'sebi'),
('81dc9bdb52d04dc20036dbd8313ed055', 'sebicontenidista@gg.com', 'contenidista', 'sebicontenidista'),
('0b180078d994cb2b5ed89d7ce8e7eea2', 'administracion@infonete.com', 'admin', 'su');

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
  MODIFY `idPublicacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `suscripcion`
--
ALTER TABLE `suscripcion`
  MODIFY `idSuscripcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
