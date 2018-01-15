-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-01-2018 a las 21:39:12
-- Versión del servidor: 10.1.26-MariaDB
-- Versión de PHP: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sondeo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `documento` varchar(15) NOT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `usuario` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`documento`, `nombre`, `usuario`, `password`) VALUES
('1144190665', 'prueba', 'usuario_prueba', '123');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_resp_encuesta`
--

CREATE TABLE `detalle_resp_encuesta` (
  `id` int(11) NOT NULL,
  `id_pregunta_respuesta` int(11) NOT NULL,
  `id_respuesta_encuesta` int(11) NOT NULL,
  `otra_respuesta` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `detalle_resp_encuesta`
--

INSERT INTO `detalle_resp_encuesta` (`id`, `id_pregunta_respuesta`, `id_respuesta_encuesta`, `otra_respuesta`) VALUES
(1, 1, 1, ''),
(2, 5, 1, ''),
(3, 11, 1, ''),
(4, 16, 1, 'todas'),
(5, 17, 1, ''),
(6, 21, 1, ''),
(7, 4, 2, 'Nokia'),
(8, 5, 2, ''),
(9, 9, 2, ''),
(10, 14, 2, ''),
(11, 20, 2, ''),
(12, 22, 2, ''),
(13, 1, 3, ''),
(14, 8, 3, ''),
(15, 9, 3, ''),
(16, 13, 3, ''),
(17, 19, 3, ''),
(18, 22, 3, ''),
(19, 1, 4, ''),
(20, 5, 4, ''),
(21, 9, 4, ''),
(22, 14, 4, ''),
(23, 17, 4, ''),
(24, 21, 4, ''),
(25, 1, 5, ''),
(26, 7, 5, ''),
(27, 11, 5, ''),
(28, 15, 5, ''),
(29, 20, 5, ''),
(30, 21, 5, ''),
(31, 3, 6, ''),
(32, 8, 6, ''),
(33, 10, 6, ''),
(34, 15, 6, ''),
(35, 20, 6, ''),
(36, 21, 6, ''),
(37, 3, 7, ''),
(38, 7, 7, ''),
(39, 10, 7, ''),
(40, 13, 7, ''),
(41, 19, 7, ''),
(42, 21, 7, ''),
(43, 29, 8, ''),
(44, 29, 9, ''),
(45, 29, 10, ''),
(46, 30, 11, ''),
(47, 35, 20, ''),
(48, 35, 21, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuesta`
--

CREATE TABLE `encuesta` (
  `id_encuesta` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `creada_por` varchar(15) NOT NULL,
  `link` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `encuesta`
--

INSERT INTO `encuesta` (`id_encuesta`, `titulo`, `fecha_creacion`, `creada_por`, `link`) VALUES
(1, 'Aparatos móviles', '2017-12-01 11:30:56', 'usuario_prueba', 'localhost:8080/encuesta/vistaUsuario.php?id=1'),
(2, 'Título Encuesta Prueba editado', '2018-01-05 09:27:47', 'usuario_prueba', 'localhost:8888/encuesta/vistaUsuario.php?id=2'),
(4, 'Titulo prueba', '2018-01-05 10:48:13', 'usuario_prueba', 'localhost:8888/encuesta/vistaUsuario.php?id=4'),
(10, 'encuesta PRUEBA', '2018-01-05 16:45:23', 'usuario_prueba', 'localhost:8080/encuesta/vistaUsuario.php?id=10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

CREATE TABLE `pregunta` (
  `id_pregunta` int(11) NOT NULL,
  `descripcion` varchar(300) NOT NULL,
  `id_encuesta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pregunta`
--

INSERT INTO `pregunta` (`id_pregunta`, `descripcion`, `id_encuesta`) VALUES
(1, '¿Cuál de los siguientes aparatos móviles posees?', 1),
(2, '¿Cuál de los siguientes aparatos más utilizas para conectarte a Internet?', 1),
(3, '¿Cuál de los siguientes aparatos prefieres utilizar para comunicarte con tus amigos, familiares etc.?', 1),
(4, '¿Cuál es tu marca favorita de móviles?', 1),
(5, '¿Cuántas horas diarias utilizas los aparatos móviles?', 1),
(6, '¿Se ajustan tus aparatos móviles a tu estilo de vida?', 1),
(8, 'pregunta 1', 2),
(11, 'Pregunta 1', 4),
(12, 'pregunta 2', 4),
(19, 'pregunta 1.1', 10),
(20, 'pregunta 1.2', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta_respuesta`
--

CREATE TABLE `pregunta_respuesta` (
  `id` int(11) NOT NULL,
  `id_pregunta` int(11) NOT NULL,
  `id_respuesta` int(11) NOT NULL,
  `id_encuesta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pregunta_respuesta`
--

INSERT INTO `pregunta_respuesta` (`id`, `id_pregunta`, `id_respuesta`, `id_encuesta`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 1),
(3, 1, 3, 1),
(4, 1, 4, 1),
(5, 2, 5, 1),
(6, 2, 6, 1),
(7, 2, 7, 1),
(8, 2, 8, 1),
(9, 3, 9, 1),
(10, 3, 10, 1),
(11, 3, 11, 1),
(12, 3, 12, 1),
(13, 4, 13, 1),
(14, 4, 14, 1),
(15, 4, 15, 1),
(16, 4, 16, 1),
(17, 5, 17, 1),
(18, 5, 18, 1),
(19, 5, 19, 1),
(20, 5, 20, 1),
(21, 6, 21, 1),
(22, 6, 22, 1),
(25, 8, 24, 2),
(32, 8, 36, 4),
(33, 8, 37, 4),
(34, 12, 38, 4),
(35, 12, 39, 4),
(36, 12, 40, 4),
(37, 19, 58, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuesta`
--

CREATE TABLE `respuesta` (
  `id_respuesta` int(11) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `id_encuesta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `respuesta`
--

INSERT INTO `respuesta` (`id_respuesta`, `descripcion`, `id_encuesta`) VALUES
(1, 'Móvil', 1),
(2, 'Portátil', 1),
(3, 'Tablet', 1),
(4, 'otro', 1),
(5, 'Móvil', 1),
(6, 'Portátil', 1),
(7, 'Tablet', 1),
(8, 'Computador de Escritorio', 1),
(9, 'Móvil', 1),
(10, 'Tablet', 1),
(11, 'Portátil', 1),
(12, 'otro', 1),
(13, 'Samsung', 1),
(14, 'Apple', 1),
(15, 'Nokia', 1),
(16, 'otro', 1),
(17, '8 horas', 1),
(18, '5-8 horas', 1),
(19, '3-4 horas', 1),
(20, '1-2 horas', 1),
(21, 'si', 1),
(22, 'no', 1),
(23, 'Respuesta - Pregunta 1', 2),
(24, 'respuesta - pregunta 1', 2),
(36, 'respuesta 1', 4),
(37, 'respuesta 2', 4),
(38, ' pr1 ', 4),
(39, 'pr2', 4),
(40, 'otro', 4),
(41, 'respuesta 1', 4),
(42, 'pr1', 4),
(43, 'pr1', 4),
(44, 'pr1', 4),
(45, 'pr1', 4),
(46, 'pr1', 4),
(47, 'pr1', 4),
(48, 'pr1', 4),
(49, 'pr1', 4),
(50, 'pr1', 4),
(51, 'pr1', 4),
(52, 'pr1', 4),
(53, 'pr1', 4),
(54, 'pr1', 4),
(55, 'pr1', 4),
(56, 'pr1', 4),
(58, '   Respuesta 1 pregunta 1', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultado_encuesta`
--

CREATE TABLE `resultado_encuesta` (
  `id_respuesta_encuesta` int(11) NOT NULL,
  `usuario_encuestado` varchar(100) NOT NULL,
  `fecha_elaboracion` datetime NOT NULL,
  `cedula` varchar(15) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `email` varchar(35) NOT NULL,
  `id_encuesta` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `resultado_encuesta`
--

INSERT INTO `resultado_encuesta` (`id_respuesta_encuesta`, `usuario_encuestado`, `fecha_elaboracion`, `cedula`, `telefono`, `email`, `id_encuesta`) VALUES
(1, 'Mauricio Herrera', '2017-12-01 11:36:40', '1113626301', '', 'mherrera10@misena.edu.co', 1),
(2, 'Mama de Mauricio', '2017-12-01 11:36:49', '666666666666666', '', 'mama69', 1),
(3, 'richard eraso', '2017-12-01 11:37:07', '114411111', '', 'pos@expresopalmira.com.co', 1),
(4, 'camilo noguera', '2017-12-01 11:49:13', '1144190665', '', 'camilo', 1),
(5, 'nombre prueba', '2017-12-01 11:56:28', 'documento', '', 'emailprueba', 1),
(6, 'nombre', '2017-12-01 12:08:32', 'documento', '', 'asdasd', 1),
(7, 'asd', '2017-12-01 12:17:22', 'asd', '', 'asd@hotmail.com', 1),
(8, 'camilo', '2018-01-05 10:04:38', '0000', '', 'noguera1905@hotmail.com', NULL),
(9, 'asd', '2018-01-05 10:24:10', '9999', '', 'noguera1905@hotmail.com', NULL),
(10, 'werqweqwe', '2018-01-05 10:28:08', '1144190665', '987456321', 'noguera1905@hotmail.com', NULL),
(11, 'csa', '2018-01-05 10:28:49', '213', '3432', 'noguera1905@hotmail.com', NULL),
(12, 'camilo', '2018-01-05 10:49:17', '147896523', '78945612530', 'noguera1905@hotmail.com', NULL),
(13, 'camilo', '2018-01-05 10:52:21', '7894651230', '456', 'noguera1905@hotmail.com', NULL),
(14, 'sadasd', '2018-01-05 10:53:47', 'asdasd', 'asdasd', 'noguera1905@hotmail.com', NULL),
(15, 'camilo', '2018-01-05 10:57:03', 'dasdas', 'asdasd', 'noguera1905@hotmail.com', NULL),
(16, 'camilo', '2018-01-05 11:00:49', 'dasdas', 'asdasd', 'noguera1905@hotmail.com', NULL),
(17, 'camilo', '2018-01-05 11:01:21', 'dasdas', 'asdasd', 'noguera1905@hotmail.com', NULL),
(18, 'dsfds', '2018-01-05 11:04:49', 'sdg', 'sdgsdg', 'noguera1905@hotmail.com', NULL),
(19, 'ertyer', '2018-01-05 11:06:23', 'eryer', 'retyer', 'noguera1905@hotmail.com', NULL),
(20, 'camilo', '2018-01-05 11:07:23', 'fsdgfsd', 'sdgsdg', 'noguera1905@hotmail.com', NULL),
(21, 'camilo', '2018-01-05 11:11:40', 'gdfgdfg', 'dfgdfg', 'noguera1905@hotmail.com', 4);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`documento`);

--
-- Indices de la tabla `detalle_resp_encuesta`
--
ALTER TABLE `detalle_resp_encuesta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pregunta_respuesta` (`id_pregunta_respuesta`),
  ADD KEY `id_respuesta_encuesta` (`id_respuesta_encuesta`);

--
-- Indices de la tabla `encuesta`
--
ALTER TABLE `encuesta`
  ADD PRIMARY KEY (`id_encuesta`),
  ADD KEY `creada_por` (`creada_por`);

--
-- Indices de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD PRIMARY KEY (`id_pregunta`),
  ADD KEY `id_encuesta` (`id_encuesta`);

--
-- Indices de la tabla `pregunta_respuesta`
--
ALTER TABLE `pregunta_respuesta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pregunta` (`id_pregunta`,`id_respuesta`),
  ADD KEY `id_respuesta` (`id_respuesta`);

--
-- Indices de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD PRIMARY KEY (`id_respuesta`),
  ADD KEY `id_encuesta` (`id_encuesta`);

--
-- Indices de la tabla `resultado_encuesta`
--
ALTER TABLE `resultado_encuesta`
  ADD PRIMARY KEY (`id_respuesta_encuesta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detalle_resp_encuesta`
--
ALTER TABLE `detalle_resp_encuesta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT de la tabla `encuesta`
--
ALTER TABLE `encuesta`
  MODIFY `id_encuesta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  MODIFY `id_pregunta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT de la tabla `pregunta_respuesta`
--
ALTER TABLE `pregunta_respuesta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  MODIFY `id_respuesta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT de la tabla `resultado_encuesta`
--
ALTER TABLE `resultado_encuesta`
  MODIFY `id_respuesta_encuesta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
