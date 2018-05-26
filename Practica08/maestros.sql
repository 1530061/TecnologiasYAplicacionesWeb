-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2018 at 05:56 AM
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
-- Table structure for table `maestros`
--

CREATE TABLE `maestros` (
  `num_empleado` varchar(128) NOT NULL,
  `nombre` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `id_carrera` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `maestros`
--

INSERT INTO `maestros` (`num_empleado`, `nombre`, `email`, `password`, `id_carrera`) VALUES
('1500231', 'Mario', 'mario@upv.edu.mx', 'mario', 1),
('1550002', 'Jose Carrizales', 'jose@upv.edu.mx', '12345', 2),
('423', 'erick', 'dasdad@gmail.com', '1423', 1),
('asdfasdf', 'Ramon Ramirez', '123123@gmail.com', '123', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `maestros`
--
ALTER TABLE `maestros`
  ADD PRIMARY KEY (`num_empleado`),
  ADD KEY `id_carrera` (`id_carrera`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `maestros`
--
ALTER TABLE `maestros`
  ADD CONSTRAINT `maestros_ibfk_1` FOREIGN KEY (`id_carrera`) REFERENCES `carrera` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
