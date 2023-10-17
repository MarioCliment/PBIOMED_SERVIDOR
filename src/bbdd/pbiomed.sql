-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2023 at 07:44 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pbiomed`
--

-- --------------------------------------------------------

--
-- Table structure for table `mediciones`
--

CREATE TABLE `mediciones` (
  `id_medicion` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `tiempo` datetime DEFAULT NULL,
  `temperatura` decimal(5,2) DEFAULT NULL,
  `concentracion` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mediciones`
--

INSERT INTO `mediciones` (`id_medicion`, `id_usuario`, `tiempo`, `temperatura`, `concentracion`) VALUES
(1, 1, '2023-10-15 20:00:00', 36.50, 5.20),
(2, 1, '2023-10-15 23:00:00', 36.50, 5.20),
(3, 1, '2023-10-15 23:59:59', 36.50, 5.20),
(4, 1, '2023-10-15 12:00:00', 25.50, 0.10),
(5, 1, '2023-10-15 12:00:00', 25.50, 0.10),
(6, 1, '2023-10-15 12:00:00', 25.50, 0.10),
(7, 1, '2023-10-15 12:00:00', 25.50, 0.10),
(8, 1, '0000-00-00 00:00:00', 25.50, 0.10),
(9, 1, '0000-00-00 00:00:00', 25.50, 0.10),
(10, 1, '0000-00-00 00:00:00', 25.50, 0.10),
(11, 1, '0000-00-00 00:00:00', 25.50, 0.10),
(12, 1, '0000-00-00 00:00:00', 25.50, 0.10),
(13, 1, '0000-00-00 00:00:00', 25.50, 0.10),
(14, 1, '0000-00-00 00:00:00', 25.50, 0.10),
(15, 1, '0000-00-00 00:00:00', 25.50, 0.10),
(16, 1, '0000-00-00 00:00:00', 25.50, 0.10);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Apellidos` varchar(50) DEFAULT NULL,
  `user` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `Nombre`, `Apellidos`, `user`, `password`) VALUES
(1, 'Mario', 'Climent', 'mario.climent', '1234');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mediciones`
--
ALTER TABLE `mediciones`
  ADD PRIMARY KEY (`id_medicion`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mediciones`
--
ALTER TABLE `mediciones`
  MODIFY `id_medicion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mediciones`
--
ALTER TABLE `mediciones`
  ADD CONSTRAINT `mediciones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
