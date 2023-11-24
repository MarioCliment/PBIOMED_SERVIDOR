-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-10-2023 a las 15:35:36
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pbiomed`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mediciones`
--

CREATE TABLE `mediciones` (
  `idMedicion` int(10) NOT NULL,
  `fecha` varchar(20) NOT NULL,
  `lugar` varchar(25) NOT NULL,
  `valor` int(10) NOT NULL,
  `idTipoMedicion` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sonda`
--

CREATE TABLE `sonda` (
  `idSonda` int(10) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `estado` enum('correcto','averiado') NOT NULL DEFAULT 'correcto'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `telefono`
--

CREATE TABLE `telefono` (
  `email` varchar(50) NOT NULL,
  `telefono` int(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipomedicion`
--

CREATE TABLE `tipomedicion` (
  `idTipoMedicion` int(10) NOT NULL,
  `medida` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `email` varchar(50) NOT NULL,
  `contrasenya` varchar(20) NOT NULL,
  `rol` varchar(10) NOT NULL,
  `nombreApellidos` varchar(30) NOT NULL,
  `nickname` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario-medicion`
--

CREATE TABLE `usuario-medicion` (
  `email` varchar(50) NOT NULL,
  `idMedicion` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario-sonda`
--

CREATE TABLE `usuario-sonda` (
  `email` varchar(50) NOT NULL,
  `idSonda` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `mediciones`
--
ALTER TABLE `mediciones`
  ADD PRIMARY KEY (`idMedicion`),
  ADD KEY `idTipoMedicion` (`idTipoMedicion`),
  ADD KEY `idMedicion` (`idMedicion`);

--
-- Indices de la tabla `sonda`
--
ALTER TABLE `sonda`
  ADD PRIMARY KEY (`idSonda`),
  ADD KEY `idSonda` (`idSonda`);

--
-- Indices de la tabla `telefono`
--
ALTER TABLE `telefono`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `tipomedicion`
--
ALTER TABLE `tipomedicion`
  ADD PRIMARY KEY (`idTipoMedicion`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`email`),
  ADD UNIQUE KEY `nickname` (`nickname`),
  ADD KEY `email` (`email`);

--
-- Indices de la tabla `usuario-medicion`
--
ALTER TABLE `usuario-medicion`
  ADD PRIMARY KEY (`email`,`idMedicion`),
  ADD KEY `idMedicion` (`idMedicion`);

--
-- Indices de la tabla `usuario-sonda`
--
ALTER TABLE `usuario-sonda`
  ADD PRIMARY KEY (`email`,`idSonda`),
  ADD KEY `idSonda` (`idSonda`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `mediciones`
--
ALTER TABLE `mediciones`
  MODIFY `idMedicion` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sonda`
--
ALTER TABLE `sonda`
  MODIFY `idSonda` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipomedicion`
--
ALTER TABLE `tipomedicion`
  MODIFY `idTipoMedicion` int(10) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `mediciones`
--
ALTER TABLE `mediciones`
  ADD CONSTRAINT `mediciones_ibfk_1` FOREIGN KEY (`idTipoMedicion`) REFERENCES `tipomedicion` (`idTipoMedicion`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `telefono`
--
ALTER TABLE `telefono`
  ADD CONSTRAINT `telefono_ibfk_1` FOREIGN KEY (`email`) REFERENCES `usuario` (`email`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario-medicion`
--
ALTER TABLE `usuario-medicion`
  ADD CONSTRAINT `usuario-medicion_ibfk_1` FOREIGN KEY (`email`) REFERENCES `usuario` (`email`) ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario-medicion_ibfk_2` FOREIGN KEY (`idMedicion`) REFERENCES `mediciones` (`idMedicion`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario-sonda`
--
ALTER TABLE `usuario-sonda`
  ADD CONSTRAINT `usuario-sonda_ibfk_1` FOREIGN KEY (`email`) REFERENCES `usuario` (`email`) ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario-sonda_ibfk_2` FOREIGN KEY (`idSonda`) REFERENCES `sonda` (`idSonda`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
