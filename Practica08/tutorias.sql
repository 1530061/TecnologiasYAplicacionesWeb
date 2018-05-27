-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2018 at 08:43 PM
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
-- Database: `tutorias`
--

-- --------------------------------------------------------

--
-- Table structure for table `alumnos`
--

CREATE TABLE `alumnos` (
  `matricula` varchar(128) NOT NULL,
  `nombre` varchar(128) NOT NULL,
  `id_carrera` int(11) NOT NULL,
  `id_tutor` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `alumnos`
--

INSERT INTO `alumnos` (`matricula`, `nombre`, `id_carrera`, `id_tutor`) VALUES
('1530012', 'Carla Perez', 1, '1500235'),
('1530019', 'Pedro Perales', 1, '1500235'),
('1530031', 'Ana Gomez', 1, '1500235'),
('1530061', 'Erick Elizondo Rodriguez', 2, '1500235'),
('1530201', 'Luis Perales', 1, '1550002');

-- --------------------------------------------------------

--
-- Table structure for table `carrera`
--

CREATE TABLE `carrera` (
  `id` int(11) NOT NULL,
  `nombre` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `carrera`
--

INSERT INTO `carrera` (`id`, `nombre`) VALUES
(1, 'Ing. en Tecnologias de la Informacion'),
(2, 'Lic. en Gestion y Administracion de Pequenas y Medianas Empresas'),
(4, 'Ing. en Tecnologias de la Manufactura'),
(5, 'Ing. en Sistemas Automotrices'),
(7, 'Ing. en Ciencias');

-- --------------------------------------------------------

--
-- Table structure for table `maestros`
--

CREATE TABLE `maestros` (
  `num_empleado` varchar(128) NOT NULL,
  `nombre` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `id_carrera` int(11) NOT NULL,
  `nivel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `maestros`
--

INSERT INTO `maestros` (`num_empleado`, `nombre`, `email`, `password`, `id_carrera`, `nivel`) VALUES
('1450002', 'Juan Torres', 'jt@upv.edu.mx', '12345', 1, 0),
('1500231', 'Ramon Hernandez Rodriguez', 'superadmin@upv.edu.mx', 'superadmin', 1, 1),
('1500235', 'Jose Ramirez Perez', 'maestro@upv.edu.mx', 'maestro', 1, 0),
('1523122', 'Carlos Perales', 'ca@upv.edu.mx', '12345', 2, 0),
('1540213', 'Pedro Perales', 'pe@upv.edu.mx', '12345', 1, 1),
('1550002', 'Jose Carrizales', 'jose@upv.edu.mx', '12345', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sesion_alumnos`
--

CREATE TABLE `sesion_alumnos` (
  `matricula_alumno` varchar(128) NOT NULL,
  `id_sesion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sesion_alumnos`
--

INSERT INTO `sesion_alumnos` (`matricula_alumno`, `id_sesion`) VALUES
('1530012', 86),
('1530019', 86),
('1530061', 87),
('1530031', 87),
('1530201', 88);

-- --------------------------------------------------------

--
-- Table structure for table `sesion_tutoria`
--

CREATE TABLE `sesion_tutoria` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `tipo` varchar(128) NOT NULL,
  `tema` varchar(128) NOT NULL,
  `num_maestro` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sesion_tutoria`
--

INSERT INTO `sesion_tutoria` (`id`, `fecha`, `hora`, `tipo`, `tema`, `num_maestro`) VALUES
(86, '2018-05-28', '15:12:00', 'Grupal', 'Internet', '1500235'),
(87, '2018-05-30', '17:55:00', 'Grupal', 'Tecnologias', '1500235'),
(88, '2018-05-18', '01:05:00', 'Grupal', 'Ciencias', '1550002');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`matricula`),
  ADD KEY `id_tutor` (`id_tutor`),
  ADD KEY `id_carrera` (`id_carrera`);

--
-- Indexes for table `carrera`
--
ALTER TABLE `carrera`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maestros`
--
ALTER TABLE `maestros`
  ADD PRIMARY KEY (`num_empleado`),
  ADD KEY `id_carrera` (`id_carrera`);

--
-- Indexes for table `sesion_alumnos`
--
ALTER TABLE `sesion_alumnos`
  ADD KEY `matricula_alumno` (`matricula_alumno`),
  ADD KEY `id_sesion` (`id_sesion`);

--
-- Indexes for table `sesion_tutoria`
--
ALTER TABLE `sesion_tutoria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `num_maestro` (`num_maestro`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carrera`
--
ALTER TABLE `carrera`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sesion_tutoria`
--
ALTER TABLE `sesion_tutoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alumnos`
--
ALTER TABLE `alumnos`
  ADD CONSTRAINT `alumnos_ibfk_1` FOREIGN KEY (`id_carrera`) REFERENCES `carrera` (`id`),
  ADD CONSTRAINT `alumnos_ibfk_2` FOREIGN KEY (`id_tutor`) REFERENCES `maestros` (`num_empleado`);

--
-- Constraints for table `maestros`
--
ALTER TABLE `maestros`
  ADD CONSTRAINT `maestros_ibfk_1` FOREIGN KEY (`id_carrera`) REFERENCES `carrera` (`id`);

--
-- Constraints for table `sesion_alumnos`
--
ALTER TABLE `sesion_alumnos`
  ADD CONSTRAINT `sesion_alumnos_ibfk_1` FOREIGN KEY (`matricula_alumno`) REFERENCES `alumnos` (`matricula`),
  ADD CONSTRAINT `sesion_alumnos_ibfk_2` FOREIGN KEY (`id_sesion`) REFERENCES `sesion_tutoria` (`id`);

--
-- Constraints for table `sesion_tutoria`
--
ALTER TABLE `sesion_tutoria`
  ADD CONSTRAINT `sesion_tutoria_ibfk_1` FOREIGN KEY (`num_maestro`) REFERENCES `maestros` (`num_empleado`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
