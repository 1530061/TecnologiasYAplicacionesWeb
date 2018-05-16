-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2018 at 05:30 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php_sql_course`
--

-- --------------------------------------------------------

--
-- Table structure for table `detalle_de_venta`
--

CREATE TABLE `detalle_de_venta` (
  `id` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `promedio_por_unidad` decimal(11,0) NOT NULL,
  `importe` decimal(11,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detalle_de_venta`
--

INSERT INTO `detalle_de_venta` (`id`, `id_venta`, `id_producto`, `cantidad`, `promedio_por_unidad`, `importe`) VALUES
(19, 18, 1, 8, '12', '96'),
(20, 18, 5, 3, '13', '39'),
(21, 18, 7, 4, '27', '108'),
(22, 18, 2, 1, '10', '10'),
(23, 18, 3, 3, '2', '6'),
(24, 18, 6, 3, '11', '33'),
(25, 19, 3, 2, '2', '4'),
(26, 19, 7, 10, '27', '270'),
(27, 20, 3, 15, '2', '30'),
(28, 21, 1, 6, '12', '72'),
(29, 22, 1, 3, '12', '36'),
(30, 22, 3, 10, '2', '20'),
(31, 22, 6, 10, '11', '110'),
(32, 22, 7, 10, '27', '270');

-- --------------------------------------------------------

--
-- Table structure for table `producto`
--

CREATE TABLE `producto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(128) NOT NULL,
  `precio` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `producto`
--

INSERT INTO `producto` (`id`, `nombre`, `precio`) VALUES
(1, 'Sabritas 300g', '12'),
(2, 'Chocolates Hershey 10g', '10'),
(3, 'Chicles Clorets 2pz', '2'),
(5, 'Coca Cola 600ml', '13'),
(6, 'Sprite 600ml', '11'),
(7, 'Coca Cola 2lt', '27');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(128) NOT NULL,
  `apellido_paterno` varchar(128) NOT NULL,
  `apellido_materno` varchar(128) NOT NULL,
  `usuario` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `apellido_paterno`, `apellido_materno`, `usuario`, `password`) VALUES
(28, 'Erick', 'Elizondo', 'RodrÃ­guez', 'erick', '7b55f59d034002b5fdb7eee735c8846f'),
(30, 'Karla', 'Perez', 'Carillo', 'karla', '5fcd162c2418ef549b7b912976468942'),
(31, 'Juan', 'Rodriguez', 'Hernandez', 'admin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Table structure for table `venta`
--

CREATE TABLE `venta` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `total` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `venta`
--

INSERT INTO `venta` (`id`, `fecha`, `total`) VALUES
(18, '2018-05-16', '292'),
(19, '2018-05-16', '274'),
(20, '2018-05-15', '30'),
(21, '2018-05-16', '72'),
(22, '2018-05-16', '436');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detalle_de_venta`
--
ALTER TABLE `detalle_de_venta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_venta` (`id_venta`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indexes for table `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indexes for table `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detalle_de_venta`
--
ALTER TABLE `detalle_de_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `venta`
--
ALTER TABLE `venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detalle_de_venta`
--
ALTER TABLE `detalle_de_venta`
  ADD CONSTRAINT `detalle_de_venta_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `venta` (`id`),
  ADD CONSTRAINT `detalle_de_venta_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
