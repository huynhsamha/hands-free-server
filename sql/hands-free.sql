-- phpMyAdmin SQL Dump
-- version 4.7.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 25, 2018 at 06:13 AM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hands-free`
--

-- --------------------------------------------------------

--
-- Table structure for table `Brand`
--

CREATE TABLE `Brand` (
  `id` int(11) NOT NULL,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `iconUri` varchar(128) DEFAULT '',
  `totalModels` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Brand`
--

INSERT INTO `Brand` (`id`, `name`, `iconUri`, `totalModels`) VALUES
(66, 'Apple', 'images/brands/apple-icon.jpg', 11),
(67, 'Samsung', 'images/brands/samsung-icon.png', 4),
(68, 'Sony', 'images/brands/sony-icon.png', 1),
(69, 'OPPO', 'images/brands/oppo-icon.png', 1),
(70, 'Xiaomi', 'images/brands/xiaomi-icon.png', 1),
(71, 'Huawei', 'images/brands/huawei-icon.png', 1),
(72, 'Nokia', 'images/brands/nokia-icon.png', 1),
(73, 'HÃ£ng khÃ¡c', 'images/brands/vivo-icon.png', 3);

-- --------------------------------------------------------

--
-- Table structure for table `Model`
--

CREATE TABLE `Model` (
  `id` int(11) NOT NULL,
  `brandId` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `totalProducts` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Model`
--

INSERT INTO `Model` (`id`, `brandId`, `name`, `totalProducts`) VALUES
(45, 66, 'iPhone 2018', 0),
(46, 66, 'iPhone XS', 0),
(47, 66, 'iPhone XS Max', 0),
(48, 66, 'iPhone XR', 0),
(49, 66, 'iPhone X', 0),
(50, 66, 'iPhone 8 | 8 Plus', 0),
(51, 66, 'iPhone 8 | 8 Plus Red', 0),
(52, 66, 'iPhone 7 | 7 Plus', 0),
(53, 66, 'iPhone 6S | 6S Plus', 0),
(54, 66, 'iPhone 6 | 6 Plus', 0),
(55, 66, 'iPhone 5S | SE', 0),
(56, 67, 'Galaxy Note', 0),
(57, 67, 'Galaxy S', 0),
(58, 67, 'Galaxy A', 0),
(59, 67, 'Galaxy J', 0),
(60, 68, 'Sony', 0),
(61, 69, 'OPPO', 0),
(62, 70, 'Xiaomi', 0),
(63, 71, 'Huawei', 0),
(64, 72, 'Nokia', 0),
(65, 73, 'Honor', 0),
(66, 73, 'Vivo', 0),
(67, 73, 'Sharp', 0);

-- --------------------------------------------------------

--
-- Table structure for table `OrderDetail`
--

CREATE TABLE `OrderDetail` (
  `id` int(11) NOT NULL,
  `orderId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unitPrice` int(11) NOT NULL,
  `totalPrice` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `OrderInfo`
--

CREATE TABLE `OrderInfo` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `orderTime` datetime NOT NULL,
  `approveTime` datetime DEFAULT NULL,
  `completeTime` datetime DEFAULT NULL,
  `status` varchar(32) DEFAULT NULL COMMENT 'Order, Approved, Completed',
  `paymentMethod` varchar(128) NOT NULL,
  `totalPrice` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Product`
--

CREATE TABLE `Product` (
  `id` int(11) NOT NULL,
  `modelId` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `thumbnail` varchar(256) NOT NULL,
  `price` int(11) NOT NULL,
  `priceText` varchar(32) NOT NULL,
  `ceilPrice` int(11) DEFAULT NULL,
  `ceilPriceText` varchar(32) DEFAULT NULL,
  `bestSell` tinyint(1) DEFAULT NULL,
  `bestGift` tinyint(1) DEFAULT NULL,
  `bestPrice` tinyint(1) DEFAULT NULL,
  `hotNew` tinyint(1) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `status` varchar(256) DEFAULT NULL,
  `warranty` varchar(256) DEFAULT NULL,
  `technicalInfo` varchar(2048) DEFAULT NULL COMMENT 'JSON.stringify()',
  `galleryImages` varchar(2048) NOT NULL COMMENT 'JSON.stringify()'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `id` int(11) NOT NULL,
  `email` varchar(256) NOT NULL,
  `first_name` varchar(64) NOT NULL DEFAULT '',
  `last_name` varchar(64) NOT NULL DEFAULT '',
  `tel` varchar(64) NOT NULL DEFAULT '',
  `photo_url` varchar(1024) DEFAULT '',
  `address` varchar(1024) DEFAULT '',
  `password` varchar(64) NOT NULL COMMENT 'Use SHA256, store HEX, length 64',
  `salt` varchar(64) NOT NULL COMMENT 'Salt for hash password, store HEX, length 64',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Brand`
--
ALTER TABLE `Brand`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE_NAME` (`name`);

--
-- Indexes for table `Model`
--
ALTER TABLE `Model`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE_NAME` (`name`),
  ADD KEY `FOREIGN_BRAND` (`brandId`);

--
-- Indexes for table `OrderDetail`
--
ALTER TABLE `OrderDetail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `OrderInfo`
--
ALTER TABLE `OrderInfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Product`
--
ALTER TABLE `Product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FOREIGN_MODEL` (`modelId`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE_EMAIL` (`email`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Brand`
--
ALTER TABLE `Brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `Model`
--
ALTER TABLE `Model`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `OrderDetail`
--
ALTER TABLE `OrderDetail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `OrderInfo`
--
ALTER TABLE `OrderInfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Product`
--
ALTER TABLE `Product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Model`
--
ALTER TABLE `Model`
  ADD CONSTRAINT `FOREIGN_BRAND` FOREIGN KEY (`brandId`) REFERENCES `Brand` (`id`);

--
-- Constraints for table `Product`
--
ALTER TABLE `Product`
  ADD CONSTRAINT `FOREIGN_MODEL` FOREIGN KEY (`modelId`) REFERENCES `Model` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
