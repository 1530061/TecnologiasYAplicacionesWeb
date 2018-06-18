-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2018 at 03:54 AM
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
-- Database: `inventarios`
--

-- --------------------------------------------------------

--
-- Table structure for table `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(255) NOT NULL,
  `descripcion_categoria` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL,
  `id_tienda` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre_categoria`, `descripcion_categoria`, `date_added`, `id_tienda`) VALUES
(31, 'Botana', 'Comida ', '2018-06-11 15:13:00', 5),
(32, 'Herramientas', 'Uso cotidiano', '2018-06-11 15:13:11', 5),
(33, 'Herramientas', 'Uso', '2018-06-11 15:18:02', 6),
(34, 'Transporte', 'Elementos de transporte', '2018-06-14 00:38:16', 5);

-- --------------------------------------------------------

--
-- Table structure for table `historial`
--

CREATE TABLE `historial` (
  `id_historial` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `nota` varchar(255) NOT NULL,
  `referencia` varchar(100) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `id_tienda` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `historial`
--

INSERT INTO `historial` (`id_historial`, `id_producto`, `user_id`, `fecha`, `nota`, `referencia`, `cantidad`, `id_tienda`) VALUES
(117, 43, 17, '2018-06-11 15:14:51', 'El usuario Ramiro Perez agrego 4 producto(s) al inventario.', '23141', 4, 5),
(118, 43, 17, '2018-06-11 15:14:55', 'El usuario Ramiro Perez agrego 12 producto(s) al inventario.', '23141', 12, 5),
(119, 43, 17, '2018-06-11 15:14:59', 'El usuario Ramiro Perez retiro 2 producto(s) al inventario.', '23141', 2, 5),
(120, 43, 17, '2018-06-11 15:15:07', 'El usuario Ramiro Perez agrego 132 producto(s) al inventario.', '23149', 132, 5),
(121, 43, 15, '2018-06-11 15:15:24', 'El usuario Erick Elizondo agrego 412 producto(s) al inventario.', '13123', 412, 5),
(122, 43, 1, '2018-06-13 17:52:52', 'El usuario Carlos Perez vendio 1 unidades del producto.', '412312', 1, 5),
(123, 43, 1, '2018-06-13 17:53:22', 'El usuario Carlos Perez vendio 100 unidades del producto.', '412312', 100, 5),
(124, 43, 1, '2018-06-13 17:57:40', 'El usuario Carlos Perez vendio 200 unidades del producto.', '000001', 200, 5),
(125, 43, 1, '2018-06-13 17:58:08', 'El usuario Carlos Perez vendio 12 unidades del producto.', '000001', 12, 5),
(126, 43, 1, '2018-06-13 17:58:23', 'El usuario Carlos Perez vendio 12 unidades del producto.', '000001', 12, 5),
(127, 43, 1, '2018-06-13 17:58:57', 'El usuario Carlos Perez vendio 20 unidades del producto.', '000001', 20, 5),
(128, 43, 1, '2018-06-13 18:05:41', 'El usuario Carlos Perez vendio 122 unidades del producto.', '000001', 122, 5),
(129, 43, 1, '2018-06-13 18:08:05', 'El usuario Carlos Perez vendio 100 unidades del producto.', '000001', 100, 5),
(130, 43, 1, '2018-06-13 18:08:08', 'El usuario Carlos Perez vendio 200 unidades del producto.', '000001', 200, 5),
(131, 43, 1, '2018-06-13 18:08:38', 'El usuario Carlos Perez vendio 12 unidades del producto.', '000001', 12, 5),
(132, 43, 1, '2018-06-13 18:09:03', 'El usuario Carlos Perez vendio 1 unidades del producto.', '000001', 1, 5),
(133, 43, 1, '2018-06-13 18:09:14', 'El usuario Carlos Perez vendio 1 unidades del producto.', '000001', 1, 5),
(134, 43, 1, '2018-06-13 18:11:07', 'El usuario Carlos Perez vendio 11 unidades del producto.', '000001', 11, 5),
(135, 45, 1, '2018-06-13 18:11:08', 'El usuario Carlos Perez vendio 12 unidades del producto.', '000001', 12, 5),
(136, 44, 1, '2018-06-13 18:11:08', 'El usuario Carlos Perez vendio 12 unidades del producto.', '000001', 12, 5),
(137, 43, 1, '2018-06-13 18:12:46', 'El usuario Carlos Perez vendio 1 unidades del producto.', '000001', 1, 5),
(138, 43, 1, '2018-06-13 18:13:06', 'El usuario Carlos Perez vendio 1 unidades del producto.', '000001', 1, 5),
(139, 43, 1, '2018-06-13 21:32:54', 'El usuario Carlos Perez vendio 10 unidades del producto.', '000001', 10, 5),
(140, 45, 1, '2018-06-13 21:32:54', 'El usuario Carlos Perez vendio 10 unidades del producto.', '000001', 10, 5),
(141, 43, 1, '2018-06-13 22:32:29', 'El usuario Carlos Perez vendio 2 unidades del producto.', '000001', 2, 5),
(142, 43, 1, '2018-06-13 22:34:24', 'El usuario Carlos Perez vendio 1 unidades del producto.', '000001', 1, 5),
(143, 43, 1, '2018-06-13 22:35:10', 'El usuario Carlos Perez vendio 1 unidades del producto.', '000001', 1, 5),
(144, 43, 1, '2018-06-13 22:41:57', 'El usuario Carlos Perez vendio 2 unidades del producto.', '000001', 2, 5),
(145, 43, 1, '2018-06-13 22:49:05', 'El usuario Carlos Perez vendio 1 unidades del producto.', '000001', 1, 5),
(146, 44, 1, '2018-06-13 22:49:05', 'El usuario Carlos Perez vendio 12 unidades del producto.', '000001', 12, 5),
(147, 43, 1, '2018-06-13 23:05:35', 'El usuario Carlos Perez vendio 31 unidades del producto.', '000001', 31, 5),
(148, 43, 1, '2018-06-13 23:05:47', 'El usuario Carlos Perez vendio 1 unidades del producto.', '000001', 1, 5),
(149, 45, 1, '2018-06-14 00:32:53', 'El usuario Carlos Perez agrego 10 producto(s) al inventario.', '231', 10, 5),
(150, 45, 1, '2018-06-14 00:32:59', 'El usuario Carlos Perez agrego 10 producto(s) al inventario.', '231', 10, 5),
(151, 45, 1, '2018-06-14 00:33:04', 'El usuario Carlos Perez agrego 10 producto(s) al inventario.', '41', 10, 5),
(152, 43, 1, '2018-06-14 00:33:11', 'El usuario Carlos Perez agrego 50 producto(s) al inventario.', '1', 50, 5),
(153, 48, 1, '2018-06-14 00:39:40', 'El usuario Carlos Perez vendio 1 unidades del producto.', '000001', 1, 5),
(154, 47, 1, '2018-06-14 00:39:40', 'El usuario Carlos Perez vendio 1 unidades del producto.', '000001', 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id_producto` int(11) NOT NULL,
  `codigo_producto` char(255) NOT NULL,
  `nombre_producto` char(255) NOT NULL,
  `date_added` datetime NOT NULL,
  `precio_producto` double NOT NULL,
  `stock` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_tienda` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id_producto`, `codigo_producto`, `nombre_producto`, `date_added`, `precio_producto`, `stock`, `id_categoria`, `id_tienda`) VALUES
(43, '14123', 'Sabritas Adobadas', '2018-06-11 15:13:34', 10, 52, 31, 5),
(44, '14124', 'Palomitas', '2018-06-11 15:13:48', 5, 107, 31, 5),
(45, '14129', 'Carro de Policia', '2018-06-11 15:14:08', 4123, 30, 32, 5),
(46, '5131231', 'Martillo', '2018-06-11 15:18:17', 250, 20, 33, 6),
(47, '511231', 'Palomitas', '2018-06-14 00:30:57', 13, 1, 31, 5),
(48, '51021412341', 'Automovil', '2018-06-14 00:38:46', 50000, 1, 34, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tienda`
--

CREATE TABLE `tienda` (
  `id_tienda` int(11) NOT NULL,
  `nombre` varchar(128) NOT NULL,
  `activa` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tienda`
--

INSERT INTO `tienda` (`id_tienda`, `nombre`, `activa`) VALUES
(1, 'Root', 1),
(5, 'Walmart', 1),
(6, 'Soriana', 1),
(7, 'La Mega', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `user_name` varchar(64) NOT NULL,
  `user_password_hash` varchar(255) NOT NULL,
  `user_email` varchar(64) NOT NULL,
  `date_added` datetime NOT NULL,
  `id_tienda` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `user_name`, `user_password_hash`, `user_email`, `date_added`, `id_tienda`) VALUES
(1, 'Carlos', 'Perez', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@gmail.com', '2018-05-23 00:00:00', 1),
(15, 'Erick', 'Elizondo', 'erick', '7b55f59d034002b5fdb7eee735c8846f', '1530061@upv.edu.mx', '2018-06-11 15:11:39', 5),
(16, 'Jose', 'Ramirez', '1', 'c4ca4238a0b923820dcc509a6f75849b', '1@upv.edu.mx', '2018-06-11 15:11:57', 5),
(17, 'Ramiro', 'Perez', 'walmart', '04a8ca7bf49e7ecb4a32451676e929f0', 'walmart@upv.edu.mx', '2018-06-11 15:14:31', 5),
(18, 'Jose', 'Rodriguez', 'soriana', '022d4b209299bee40a571eaeb1bf0741', 'soriana@upv.edu.mx', '2018-06-11 15:17:48', 6),
(19, 'Jose', 'Perez', 'mega', '91805ec00ad20b85226bec0bacf843d3', 'mega@upv.edu.mx', '2018-06-11 15:18:47', 7);

-- --------------------------------------------------------

--
-- Table structure for table `venta`
--

CREATE TABLE `venta` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `total` decimal(10,0) NOT NULL,
  `id_tienda` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `venta`
--

INSERT INTO `venta` (`id`, `fecha`, `total`, `id_tienda`) VALUES
(2, '2018-06-13', '10', 5),
(3, '2018-06-13', '20', 5),
(4, '2018-06-13', '70', 5),
(5, '2018-06-13', '310', 5),
(6, '2018-06-13', '10', 5),
(7, '2018-06-14', '50013', 5);

-- --------------------------------------------------------

--
-- Table structure for table `venta_producto`
--

CREATE TABLE `venta_producto` (
  `id_venta` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `importe` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `venta_producto`
--

INSERT INTO `venta_producto` (`id_venta`, `id_producto`, `cantidad`, `importe`) VALUES
(2, 43, 1, 10),
(3, 43, 2, 20),
(4, 43, 1, 10),
(4, 44, 12, 60),
(5, 43, 31, 310),
(6, 43, 1, 10),
(7, 48, 1, 50000),
(7, 47, 1, 13);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`),
  ADD KEY `id_tienda` (`id_tienda`);

--
-- Indexes for table `historial`
--
ALTER TABLE `historial`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `id_producto_2` (`id_producto`),
  ADD KEY `id_tienda` (`id_tienda`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id_producto`),
  ADD UNIQUE KEY `codigo_producto_2` (`codigo_producto`),
  ADD KEY `codigo_producto` (`codigo_producto`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `id_tienda` (`id_tienda`);

--
-- Indexes for table `tienda`
--
ALTER TABLE `tienda`
  ADD PRIMARY KEY (`id_tienda`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD KEY `user_email` (`user_email`),
  ADD KEY `id_tienda` (`id_tienda`);

--
-- Indexes for table `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tienda` (`id_tienda`);

--
-- Indexes for table `venta_producto`
--
ALTER TABLE `venta_producto`
  ADD KEY `id_venta` (`id_venta`),
  ADD KEY `id_producto` (`id_producto`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `historial`
--
ALTER TABLE `historial`
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `tienda`
--
ALTER TABLE `tienda`
  MODIFY `id_tienda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `venta`
--
ALTER TABLE `venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categorias`
--
ALTER TABLE `categorias`
  ADD CONSTRAINT `categorias_ibfk_1` FOREIGN KEY (`id_tienda`) REFERENCES `tienda` (`id_tienda`) ON DELETE CASCADE;

--
-- Constraints for table `historial`
--
ALTER TABLE `historial`
  ADD CONSTRAINT `historial_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `products` (`id_producto`) ON DELETE CASCADE,
  ADD CONSTRAINT `historial_ibfk_2` FOREIGN KEY (`id_tienda`) REFERENCES `tienda` (`id_tienda`),
  ADD CONSTRAINT `historial_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`id_tienda`) REFERENCES `tienda` (`id_tienda`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_tienda`) REFERENCES `tienda` (`id_tienda`) ON DELETE CASCADE;

--
-- Constraints for table `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`id_tienda`) REFERENCES `tienda` (`id_tienda`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
