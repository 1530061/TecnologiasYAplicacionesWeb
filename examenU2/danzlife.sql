-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 26, 2018 at 02:27 AM
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
-- Database: `danzlife`
--

-- --------------------------------------------------------

--
-- Table structure for table `alumnas`
--

CREATE TABLE `alumnas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(128) NOT NULL,
  `apellido_paterno` varchar(128) NOT NULL,
  `id_grupo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `alumnas`
--

INSERT INTO `alumnas` (`id`, `nombre`, `apellido_paterno`, `id_grupo`) VALUES
(5, 'Karla', 'Perales', 4),
(6, 'Alma', 'Rodriguez', 4),
(7, 'Ana', 'Perez', 5),
(8, 'Perla', 'Ramirez', 5),
(9, 'Jimena', 'Carmona', 5),
(10, 'Silvia', 'Perez', 6),
(11, 'Ana', 'Gomez', 6);

-- --------------------------------------------------------

--
-- Table structure for table `grupos`
--

CREATE TABLE `grupos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grupos`
--

INSERT INTO `grupos` (`id`, `nombre`) VALUES
(4, '1A'),
(5, '2A'),
(6, '2B');

-- --------------------------------------------------------

--
-- Table structure for table `pagos`
--

CREATE TABLE `pagos` (
  `id_pago` int(11) NOT NULL,
  `id_alumna` int(11) NOT NULL,
  `nombre_mama` varchar(128) NOT NULL,
  `fecha_pago` datetime NOT NULL,
  `fecha_envio` datetime NOT NULL,
  `url_imagen` varchar(128) NOT NULL,
  `folio` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pagos`
--

INSERT INTO `pagos` (`id_pago`, `id_alumna`, `nombre_mama`, `fecha_pago`, `fecha_envio`, `url_imagen`, `folio`) VALUES
(68, 5, '123 213', '0000-00-00 00:00:00', '2018-06-26 02:25:43', '2018-06-26-02-25-43registered-trademark-black-transparent-fixed-hi.png', '3123'),
(69, 7, 'mama ana', '0000-00-00 00:00:00', '2018-06-26 02:26:53', '2018-06-26-02-26-53logo_sinfondo.png', '123'),
(71, 8, 'mama perla', '0000-00-00 00:00:00', '2018-06-26 02:27:23', '2018-06-26-02-27-23logo_sinfondo.png', '125');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user` varchar(128) NOT NULL,
  `pass` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user`, `pass`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alumnas`
--
ALTER TABLE `alumnas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_grupo` (`id_grupo`);

--
-- Indexes for table `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id_pago`),
  ADD KEY `id_alumna` (`id_alumna`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alumnas`
--
ALTER TABLE `alumnas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alumnas`
--
ALTER TABLE `alumnas`
  ADD CONSTRAINT `alumnas_ibfk_1` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`id_alumna`) REFERENCES `alumnas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
