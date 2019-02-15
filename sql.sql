-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 15, 2019 at 08:59 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fullstack`
--
-- ~ CREATE DATABASE IF NOT EXISTS `fullstack` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
-- ~ USE `fullstack`;

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE IF NOT EXISTS `clientes` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `nome_cliente` varchar(100) NOT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nome_cliente`) VALUES
(5, 'Han Solo'),
(4, 'Imperador Palpatine'),
(3, 'Luke Skywalker'),
(2, 'Obi-Wan Kenobi'),
(1, 'Darth Vader');

-- --------------------------------------------------------

--
-- Table structure for table `pedido`
--

DROP TABLE IF EXISTS `pedido`;
CREATE TABLE IF NOT EXISTS `pedido` (
  `id_pedido` int(11) NOT NULL AUTO_INCREMENT,
  `id_produto_pedido` int(11) NOT NULL,
  `id_cliente_pedido` int(11) NOT NULL,
  `preco_unitario_pedido` float NOT NULL,
  `quantidade_pedido` int(11) NOT NULL,
  `tempo_pedido` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pedido`),
  KEY `fk_produto_pedido` (`id_produto_pedido`),
  KEY `fk_cliente_pedido` (`id_cliente_pedido`)
) ENGINE=MyISAM AUTO_INCREMENT=78 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pedido`
--

INSERT INTO `pedido` (`id_pedido`, `id_produto_pedido`, `id_cliente_pedido`, `preco_unitario_pedido`, `quantidade_pedido`, `tempo_pedido`) VALUES
(43, 3, 4, 4615700, 1, '2019-02-14 20:57:41'),
(2, 1, 5, 123, 2, '2019-02-12 19:27:37'),
(48, 6, 1, 5857.99, 3, '2019-02-15 17:25:38'),
(5, 1, 6, 12, 2, '2019-02-12 20:22:56'),
(47, 6, 1, 5858, 2, '2019-02-15 17:25:37'),
(46, 6, 1, 5858, 2, '2019-02-15 17:25:37'),
(8, 1, 7, 1515.11, 0, '2019-02-13 16:57:05'),
(9, 1, 7, 0, 0, '2019-02-13 16:57:13'),
(45, 1, 1, 555500, 2, '2019-02-15 17:25:24'),
(44, 1, 1, 555500, 1, '2019-02-15 17:25:15'),
(41, 3, 4, 4615700, 1, '2019-02-14 20:12:20'),
(13, 3, 3, 4615700, 1, '2019-02-13 17:04:58'),
(14, 3, 7, 1515, 200, '2019-02-13 17:05:36'),
(15, 3, 5, 6060, 5, '2019-02-13 18:01:15'),
(16, 3, 5, 6060, 5, '2019-02-13 18:01:59'),
(17, 3, 5, 6060, 5, '2019-02-13 18:02:15'),
(18, 1, 2, 555500, 4, '2019-02-13 18:03:52'),
(19, 3, 7, 1515.02, 30, '2019-02-13 18:07:10'),
(20, 3, 7, 1515.02, 30, '2019-02-13 18:08:16'),
(21, 3, 7, 1515.02, 30, '2019-02-13 18:08:29'),
(22, 7, 3, 1515.02, 30, '2019-02-13 18:10:00'),
(23, 5, 3, 6060, 50, '2019-02-13 18:10:30'),
(24, 1, 3, 555500, 1, '2019-02-13 20:38:01'),
(25, 4, 1, 75750, 2, '2019-02-13 20:39:01'),
(26, 2, 3, 60600, 2, '2019-02-13 20:39:27'),
(27, 3, 2, 4615700, 1, '2019-02-13 20:42:11'),
(28, 5, 3, 6060, 5, '2019-02-13 20:58:24'),
(29, 2, 4, 60600, 4, '2019-02-14 14:48:56'),
(30, 5, 4, 6060, 5, '2019-02-14 14:49:04'),
(31, 7, 4, 1515, 20, '2019-02-14 14:49:31'),
(32, 4, 3, 75750, 2, '2019-02-14 15:15:17'),
(33, 3, 1, 4615700, 1, '2019-02-14 15:21:25'),
(34, 3, 2, 4615700, 1, '2019-02-14 15:26:38'),
(35, 1, 2, 555500, 1, '2019-02-14 15:33:13'),
(36, 1, 2, 555500, 1, '2019-02-14 15:39:15'),
(37, 2, 3, 60600, 2, '2019-02-14 15:42:21'),
(38, 1, 1, 555500, 1, '2019-02-14 18:10:41'),
(39, 2, 1, 606010000, 50, '2019-02-14 18:11:15'),
(40, 2, 1, 606010000, 6, '2019-02-14 18:11:34'),
(49, 6, 1, 5858, 2, '2019-02-15 17:25:38'),
(50, 6, 1, 5858, 2, '2019-02-15 17:25:38'),
(51, 6, 1, 5858, 2, '2019-02-15 17:25:39'),
(52, 6, 1, 5858, 2, '2019-02-15 17:25:39'),
(53, 6, 1, 5858, 2, '2019-02-15 17:25:39'),
(54, 6, 1, 5858, 2, '2019-02-15 17:25:39'),
(55, 6, 1, 5858, 2, '2019-02-15 17:25:39'),
(56, 6, 1, 5858, 2, '2019-02-15 17:25:39'),
(57, 6, 1, 5858, 2, '2019-02-15 17:25:39'),
(58, 6, 1, 5858, 2, '2019-02-15 17:25:39'),
(59, 6, 1, 5858, 2, '2019-02-15 17:25:39'),
(60, 6, 1, 5858, 2, '2019-02-15 17:25:40'),
(61, 6, 1, 5858, 2, '2019-02-15 17:25:40'),
(62, 6, 1, 5858, 2, '2019-02-15 17:25:40'),
(63, 6, 1, 5858, 2, '2019-02-15 17:25:41'),
(64, 6, 1, 5858, 2, '2019-02-15 17:25:41'),
(65, 6, 1, 5858, 2, '2019-02-15 17:25:41'),
(66, 6, 1, 5858, 2, '2019-02-15 17:25:41'),
(67, 6, 1, 5858, 2, '2019-02-15 17:25:42'),
(68, 6, 1, 5858, 2, '2019-02-15 17:25:42'),
(69, 3, 4, 4615700, 1, '2019-02-15 17:26:17'),
(71, 5, 1, 60600, 5, '2019-02-15 17:26:37'),
(72, 5, 1, 60600, 10, '2019-02-15 17:26:55'),
(73, 5, 1, 60600, 10, '2019-02-15 17:26:56'),
(74, 5, 1, 60600, 10, '2019-02-15 17:26:56'),
(75, 5, 1, 60600, 10, '2019-02-15 17:26:56'),
(76, 5, 1, 60600, 10, '2019-02-15 17:26:57');

--
-- Triggers `pedido`
--
DROP TRIGGER IF EXISTS `validate_insert_pedido`;
DELIMITER $$
CREATE TRIGGER `validate_insert_pedido` BEFORE INSERT ON `pedido` FOR EACH ROW BEGIN
    DECLARE preco_produto Float;
    DECLARE quantidade_produto INT;
    SET preco_produto = (SELECT produtos.preco_unitario_produto FROM produtos WHERE produtos.id_produto = NEW.id_produto_pedido);
    SET quantidade_produto = (SELECT produtos.multiplo_produto FROM produtos WHERE produtos.id_produto = NEW.id_produto_pedido);
    IF (NEW.preco_unitario_pedido < (preco_produto*0.9)) THEN
        SET NEW.preco_unitario_pedido = NULL;
    END IF;
    IF ((SELECT MOD(NEW.quantidade_pedido, quantidade_produto)) != 0) THEN
        SET NEW.quantidade_pedido = NULL;
    END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `validate_update_pedido`;
DELIMITER $$
CREATE TRIGGER `validate_update_pedido` BEFORE UPDATE ON `pedido` FOR EACH ROW BEGIN
    DECLARE preco_produto Float;
    DECLARE quantidade_produto INT;
    SET preco_produto = (SELECT produtos.preco_unitario_produto FROM produtos WHERE produtos.id_produto = NEW.id_produto_pedido);
    SET quantidade_produto = (SELECT produtos.multiplo_produto FROM produtos WHERE produtos.id_produto = NEW.id_produto_pedido);
    IF (NEW.preco_unitario_pedido < (preco_produto*0.9)) THEN
        SET NEW.preco_unitario_pedido = NULL;
    END IF;
    IF ((SELECT MOD(NEW.quantidade_pedido, quantidade_produto)) != 0) THEN
        SET NEW.quantidade_pedido = NULL;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `produtos`
--

DROP TABLE IF EXISTS `produtos`;
CREATE TABLE IF NOT EXISTS `produtos` (
  `id_produto` int(11) NOT NULL AUTO_INCREMENT,
  `nome_produto` varchar(100) NOT NULL,
  `preco_unitario_produto` float NOT NULL,
  `multiplo_produto` int(11) NOT NULL,
  PRIMARY KEY (`id_produto`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `produtos`
--

INSERT INTO `produtos` (`id_produto`, `nome_produto`, `preco_unitario_produto`, `multiplo_produto`) VALUES
(5, 'Lightsaber', 6000, 5),
(4, 'TIE Fighter', 75000, 2),
(3, 'Super Star Destroyer', 4570000, 1),
(2, 'X-Wing', 60000, 2),
(1, 'Millenium Falcon', 550000, 1),
(6, 'DLT-19 Heavy Blaster ifle', 5800, 1),
(7, 'DL-44 Heavy Blaster Pistol', 1500, 10);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
