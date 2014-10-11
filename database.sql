-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Oct 11, 2014 at 08:18 PM
-- Server version: 5.5.34
-- PHP Version: 5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `hsc_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_reg_date` datetime NOT NULL,
  `customer_first_name` varchar(100) NOT NULL,
  `customer_middle_name` varchar(100) NOT NULL,
  `customer_last_name` varchar(100) NOT NULL,
  `customer_company_name` varchar(100) NOT NULL,
  `customer_city_name` varchar(100) NOT NULL,
  `customer_street_name` varchar(100) NOT NULL,
  `customer_country_name` varchar(100) NOT NULL,
  `customer_mobile1` varchar(20) NOT NULL,
  `customer_mobile2` varchar(20) NOT NULL,
  `customer_mobile3` varchar(20) NOT NULL,
  `customer_mobile4` varchar(20) NOT NULL,
  `customer_email1` varchar(150) NOT NULL,
  `customer_email2` varchar(150) NOT NULL,
  `customer_balance` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customer_reg_date`, `customer_first_name`, `customer_middle_name`, `customer_last_name`, `customer_company_name`, `customer_city_name`, `customer_street_name`, `customer_country_name`, `customer_mobile1`, `customer_mobile2`, `customer_mobile3`, `customer_mobile4`, `customer_email1`, `customer_email2`, `customer_balance`) VALUES
(13, '2014-10-07 09:17:10', 'Nadhir', 'Mubarak', 'Bahayan', 'Yoteyote | Shows', 'Dar es Salaam', 'Quality Center', 'Tanzania', '255655487333', '255655487333', '255655487333', '255655487333', 'nbahayan@gmail.com', 'nbahayan@gmail.com', 0),
(14, '2014-10-07 09:18:43', 'John', 'Doe', 'Done', 'Nida', 'Dar es salaam', 'Mkunguni', 'Tanzania', '255898999999', '', '', '', 'neo@yoteyote.com', 'neo@yoteyote.com', 0),
(15, '2014-10-08 07:09:40', 'Suleiman', 'Munir', 'Hazza', 'Shopador', 'Dar es salaam', 'Makumbusho', 'Tanzania', '0713889988', '', '', '', 's.munir@live.com', 's.munir@live.com', 0),
(16, '2014-10-09 09:12:26', 'Muhammad', 'Abbas', 'Burhan', 'Yoteyote | Shows', 'Dar es Salaam', 'Quality Center', 'Tanzania', '255655487333', '255655487333', '255655487333', '255655487333', 'm.abbas@hotmail.com', 'nbahayan@gmail.com', 0),
(17, '2014-10-09 10:21:35', 'Khamis', 'Khalfan', 'Khalfan', 'Yoteyote | Shows', 'Dar es Salaam', 'Quality Center', 'Tanzania', '255655487333', '255655487333', '255655487333', '255655487333', 'nbahayan@gmail.com', 'nbahayan@gmail.com', 0),
(18, '2014-10-09 14:01:10', 'John', 'Doe', 'Diin', 'Yoteyote | Shows', 'Dar es Salaam', 'Quality Center', 'Tanzania', '255655487333', '255655487333', '255655487333', '255655487333', 'nbahayan@gmail.com', 'nbahayan@gmail.com', 0),
(19, '2014-10-09 14:02:12', 'Nadh', 'Mubarak', 'Bahayan', 'Yoteyote | Shows', 'Dar es Salaam', 'Quality Center', 'Tanzania', '255655487333', '255655487333', '255655487333', '255655487333', 'nbahayan@gmail.com', 'nbahayan@gmail.com', 0),
(20, '2014-10-09 14:04:56', 'Rahim', 'Hassan', 'Dhanani', 'Yoteyote | Shows', 'Dar es Salaam', 'Quality Center', 'Tanzania', '255784301280', '255655487333', '255655487333', '255655487333', 'nbahayan@gmail.com', 'nbahayan@gmail.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `loan_orders`
--

CREATE TABLE `loan_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_date` datetime NOT NULL,
  `order_staff_id` int(11) NOT NULL,
  `order_customer_id` int(11) NOT NULL,
  `order_amount` int(11) NOT NULL,
  `order_status` varchar(20) NOT NULL DEFAULT 'pending',
  `order_status_reason` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=102 ;

--
-- Dumping data for table `loan_orders`
--

INSERT INTO `loan_orders` (`id`, `order_date`, `order_staff_id`, `order_customer_id`, `order_amount`, `order_status`, `order_status_reason`) VALUES
(1, '2014-10-11 00:00:00', 1, 1, 1, 'pending', NULL),
(2, '2014-10-11 12:39:42', 1, 15, 2, 'pending', NULL),
(3, '2014-10-11 12:41:07', 1, 13, 1, 'pending', NULL),
(4, '2014-10-11 12:46:32', 1, 13, 1, 'pending', NULL),
(5, '2014-10-11 12:47:57', 1, 13, 1, 'pending', NULL),
(6, '2014-10-11 12:48:30', 1, 19, 6, 'pending', NULL),
(7, '2014-10-11 12:51:19', 1, 18, 4, 'pending', NULL),
(8, '2014-10-11 12:51:56', 1, 15, 9, 'pending', NULL),
(9, '2014-10-11 12:52:26', 1, 14, 9, 'pending', NULL),
(10, '2014-10-11 12:58:12', 1, 0, 0, 'pending', NULL),
(11, '2014-10-11 12:59:23', 1, 13, 0, 'pending', NULL),
(12, '2014-10-11 12:59:32', 1, 0, 0, 'pending', NULL),
(13, '2014-10-11 13:01:05', 1, 0, 0, 'pending', NULL),
(14, '2014-10-11 13:01:16', 1, 0, 0, 'pending', NULL),
(15, '2014-10-11 13:01:21', 1, 0, 0, 'pending', NULL),
(16, '2014-10-11 13:01:26', 1, 0, 0, 'pending', NULL),
(17, '2014-10-11 13:01:39', 1, 0, 0, 'pending', NULL),
(18, '2014-10-11 13:03:18', 1, 13, 6, 'pending', NULL),
(19, '2014-10-11 13:04:02', 1, 20, 9, 'pending', NULL),
(20, '2014-10-11 13:04:30', 1, 19, 12, 'pending', NULL),
(21, '2014-10-11 16:30:01', 1, 0, 0, 'pending', NULL),
(22, '2014-10-11 16:50:18', 1, 15, 25, 'pending', NULL),
(23, '2014-10-11 16:51:52', 1, 17, 119709, 'pending', NULL),
(24, '2014-10-11 16:55:44', 1, 17, 36675, 'pending', NULL),
(25, '2014-10-11 16:56:06', 1, 17, 36675, 'pending', NULL),
(26, '2014-10-11 16:56:58', 1, 14, 4, 'pending', NULL),
(27, '2014-10-11 16:59:42', 1, 13, 66, 'pending', NULL),
(28, '2014-10-11 17:02:22', 1, 14, 9, 'pending', NULL),
(29, '2014-10-11 17:04:37', 1, 14, 185, 'pending', NULL),
(30, '2014-10-11 17:05:30', 1, 15, 9, 'pending', NULL),
(31, '2014-10-11 17:06:07', 1, 17, 21, 'pending', NULL),
(32, '2014-10-11 17:09:52', 1, 15, 12, 'pending', NULL),
(33, '2014-10-11 17:10:20', 1, 15, 3, 'pending', NULL),
(34, '2014-10-11 17:11:31', 1, 16, 3, 'pending', NULL),
(35, '2014-10-11 17:12:01', 1, 15, 27, 'pending', NULL),
(36, '2014-10-11 17:12:04', 1, 15, 27, 'pending', NULL),
(37, '2014-10-11 17:12:41', 1, 15, 12, 'pending', NULL),
(38, '2014-10-11 17:12:47', 1, 15, 12, 'pending', NULL),
(39, '2014-10-11 17:13:10', 1, 15, 12, 'pending', NULL),
(40, '2014-10-11 17:13:16', 1, 15, 12, 'pending', NULL),
(41, '2014-10-11 17:13:29', 1, 15, 12, 'pending', NULL),
(42, '2014-10-11 17:13:30', 1, 15, 12, 'pending', NULL),
(43, '2014-10-11 17:13:46', 1, 15, 12, 'pending', NULL),
(44, '2014-10-11 17:13:47', 1, 15, 12, 'pending', NULL),
(45, '2014-10-11 17:13:54', 1, 15, 12, 'pending', NULL),
(46, '2014-10-11 17:13:55', 1, 15, 12, 'pending', NULL),
(47, '2014-10-11 17:13:55', 1, 15, 12, 'pending', NULL),
(48, '2014-10-11 17:13:56', 1, 15, 12, 'pending', NULL),
(49, '2014-10-11 17:14:11', 1, 15, 12, 'pending', NULL),
(50, '2014-10-11 17:14:12', 1, 15, 12, 'pending', NULL),
(51, '2014-10-11 17:14:19', 1, 15, 12, 'pending', NULL),
(52, '2014-10-11 17:14:20', 1, 15, 12, 'pending', NULL),
(53, '2014-10-11 17:14:21', 1, 15, 12, 'pending', NULL),
(54, '2014-10-11 17:15:36', 1, 15, 12, 'pending', NULL),
(55, '2014-10-11 17:16:26', 1, 15, 12, 'pending', NULL),
(56, '2014-10-11 17:17:15', 1, 15, 12, 'pending', NULL),
(57, '2014-10-11 17:40:07', 1, 15, 14, 'pending', NULL),
(58, '2014-10-11 17:42:34', 1, 15, 14, 'pending', NULL),
(59, '2014-10-11 17:42:52', 1, 15, 14, 'pending', NULL),
(60, '2014-10-11 17:43:04', 1, 15, 14, 'pending', NULL),
(61, '2014-10-11 17:43:40', 1, 0, 0, 'pending', NULL),
(62, '2014-10-11 17:44:44', 1, 19, 30, 'pending', NULL),
(63, '2014-10-11 17:45:33', 1, 19, 30, 'pending', NULL),
(64, '2014-10-11 17:45:51', 1, 19, 30, 'pending', NULL),
(65, '2014-10-11 17:45:54', 1, 19, 30, 'pending', NULL),
(66, '2014-10-11 17:46:10', 1, 19, 30, 'pending', NULL),
(67, '2014-10-11 17:47:01', 1, 19, 30, 'pending', NULL),
(68, '2014-10-11 17:48:45', 1, 19, 30, 'pending', NULL),
(69, '2014-10-11 17:49:20', 1, 19, 30, 'pending', NULL),
(70, '2014-10-11 17:49:33', 1, 19, 30, 'pending', NULL),
(71, '2014-10-11 17:50:00', 1, 19, 30, 'pending', NULL),
(72, '2014-10-11 17:50:09', 1, 19, 30, 'pending', NULL),
(73, '2014-10-11 17:50:10', 1, 19, 30, 'pending', NULL),
(74, '2014-10-11 17:50:18', 1, 19, 30, 'pending', NULL),
(75, '2014-10-11 17:50:20', 1, 19, 30, 'pending', NULL),
(76, '2014-10-11 17:50:21', 1, 19, 30, 'pending', NULL),
(77, '2014-10-11 17:50:26', 1, 19, 30, 'pending', NULL),
(78, '2014-10-11 17:50:29', 1, 19, 30, 'pending', NULL),
(79, '2014-10-11 18:56:25', 1, 19, 30, 'pending', NULL),
(80, '2014-10-11 18:58:01', 1, 19, 30, 'pending', NULL),
(81, '2014-10-11 18:58:26', 1, 19, 30, 'pending', NULL),
(82, '2014-10-11 19:01:46', 1, 19, 30, 'pending', NULL),
(83, '2014-10-11 19:02:00', 1, 19, 30, 'pending', NULL),
(84, '2014-10-11 19:06:41', 1, 19, 30, 'pending', NULL),
(85, '2014-10-11 19:07:08', 1, 19, 30, 'pending', NULL),
(86, '2014-10-11 19:07:30', 1, 19, 30, 'pending', NULL),
(87, '2014-10-11 19:09:06', 1, 19, 30, 'pending', NULL),
(88, '2014-10-11 19:10:16', 1, 19, 30, 'pending', NULL),
(89, '2014-10-11 19:11:22', 1, 19, 30, 'pending', NULL),
(90, '2014-10-11 19:17:06', 1, 19, 30, 'pending', NULL),
(91, '2014-10-11 19:17:32', 1, 19, 30, 'pending', NULL),
(92, '2014-10-11 19:19:33', 1, 19, 30, 'pending', NULL),
(93, '2014-10-11 19:21:10', 1, 19, 30, 'pending', NULL),
(94, '2014-10-11 19:21:51', 1, 16, 1195, 'pending', NULL),
(95, '2014-10-11 19:22:08', 1, 16, 1195, 'pending', NULL),
(96, '2014-10-11 19:22:52', 1, 16, 1195, 'pending', NULL),
(97, '2014-10-11 19:23:19', 1, 16, 1195, 'pending', NULL),
(98, '2014-10-11 19:30:34', 1, 14, 375000, 'pending', NULL),
(99, '2014-10-11 19:33:54', 1, 14, 375000, 'pending', NULL),
(100, '2014-10-11 19:34:09', 1, 14, 405000, 'pending', NULL),
(101, '2014-10-11 19:38:30', 1, 15, 30, 'pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `loan_products`
--

CREATE TABLE `loan_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_order_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_code` varchar(100) NOT NULL,
  `product_price` int(11) NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `product_amount` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `loan_products`
--

INSERT INTO `loan_products` (`id`, `product_order_id`, `product_name`, `product_code`, `product_price`, `product_quantity`, `product_amount`) VALUES
(1, 97, 'a', 'a', 2, 2, 4),
(2, 97, 'b', 'b', 34, 3, 102),
(3, 97, 'c', 'c', 33, 33, 1089),
(4, 98, 'Bedsheet', 'B11-40', 75000, 3, 225000),
(5, 98, 'Curtains', 'C1', 30000, 4, 120000),
(6, 98, 'Towels', 'T1', 15000, 2, 30000),
(7, 99, 'Bedsheet', 'B11-40', 75000, 3, 225000),
(8, 99, 'Curtains', 'C1', 30000, 4, 120000),
(9, 99, 'Towels', 'T1', 15000, 2, 30000),
(10, 100, 'Bedsheet', 'B11-40', 75000, 3, 225000),
(11, 100, 'Curtains', 'C1', 30000, 4, 120000),
(12, 100, 'Towels', 'T1', 15000, 2, 30000),
(13, 100, 'Towels', 'T1', 15000, 2, 30000),
(14, 101, 'a', 'a', 1, 1, 1),
(15, 101, 'b', 'b', 2, 2, 4),
(16, 101, 'c', 'c', 3, 3, 9),
(17, 101, 'd', 'd', 4, 4, 16);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(300) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `auth_type` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `date`, `email`, `password`, `branch_id`, `auth_type`, `user_id`) VALUES
(1, '2014-07-04', 'nadhir.bahayan@hsctz.com', 'c149aedbd1cf84de81f5ab7437e5b3255edef0f71a1ce4e5a0396e5ff97ebfee8ca1547e548d60cd0', 0, 10, 1),
(2, '2014-07-04', 'nargis.ahmed@hsctz.com', 'c149aedbd1cf84de81f5ab7437e5b3255edef0f7d033e22ae348aeb5660fc2140aec35850c4da9970', 2, 40, 1),
(3, '2014-07-04', 'yusra.said@hsctz.com', 'c149aedbd1cf84de81f5ab7437e5b3255edef0f7d033e22ae348aeb5660fc2140aec35850c4da9970', 1, 40, 1),
(4, '2014-07-04', 'thalia.hassan@hsctz.com', 'c149aedbd1cf84de81f5ab7437e5b3255edef0f7882fc9e839db5dbfc8c68660b0300af5125c4f3c0', 3, 40, 1),
(5, '2014-07-04', 'fatma.abdallah@hsctz.com', 'c149aedbd1cf84de81f5ab7437e5b3255edef0f7d033e22ae348aeb5660fc2140aec35850c4da9970', 1, 40, 1),
(6, '2014-07-04', 'samya.mohamed@hsctz.com', 'c149aedbd1cf84de81f5ab7437e5b3255edef0f7d033e22ae348aeb5660fc2140aec35850c4da9970', 4, 40, 1),
(7, '2014-07-04', 'saleh.naajy@hsctz.com', 'c149aedbd1cf84de81f5ab7437e5b3255edef0f7d033e22ae348aeb5660fc2140aec35850c4da9970', 2, 40, 1),
(8, '2014-07-04', 'asia.abdallah@hsctz.com', 'c149aedbd1cf84de81f5ab7437e5b3255edef0f7d033e22ae348aeb5660fc2140aec35850c4da9970', 4, 40, 1),
(9, '2014-07-04', 'rahim.hassan@hsctz.com', 'c149aedbd1cf84de81f5ab7437e5b3255edef0f76ec3cd7389cef7feb7bd547c85e7bf3a6f54c4400', 0, 21, 1),
(10, '2014-07-04', 'saleh.ally@hsctz.com', 'c149aedbd1cf84de81f5ab7437e5b3255edef0f7d033e22ae348aeb5660fc2140aec35850c4da9970', 0, 40, 1),
(11, '2014-07-04', 'latifa.mkwachu@hsctz.com', 'c149aedbd1cf84de81f5ab7437e5b3255edef0f7d033e22ae348aeb5660fc2140aec35850c4da9970', 5, 50, 3),
(12, '2014-07-04', 'feisal.sharif@hsctz.com', 'c149aedbd1cf84de81f5ab7437e5b3255edef0f7d033e22ae348aeb5660fc2140aec35850c4da9970', 5, 50, 3),
(13, '2014-07-04', 'maryam.abdallah@hsctz.com', 'c149aedbd1cf84de81f5ab7437e5b3255edef0f7d033e22ae348aeb5660fc2140aec35850c4da9970', 5, 50, 1),
(15, '2014-07-04', 'abdul.kareem@hsctz.com', 'c149aedbd1cf84de81f5ab7437e5b3255edef0f7d033e22ae348aeb5660fc2140aec35850c4da9970', 5, 50, 3),
(16, '2014-07-04', 'fareed.hemeed@hsctz.com', 'c149aedbd1cf84de81f5ab7437e5b3255edef0f7d033e22ae348aeb5660fc2140aec35850c4da9970', 5, 50, 3),
(17, '2014-07-04', 'aisha.adam@hsctz.com', 'c149aedbd1cf84de81f5ab7437e5b3255edef0f7d033e22ae348aeb5660fc2140aec35850c4da9970', 5, 50, 3),
(18, '2014-07-04', 'habiba.said@hsctz.com', 'c149aedbd1cf84de81f5ab7437e5b3255edef0f7d033e22ae348aeb5660fc2140aec35850c4da9970', 5, 50, 3),
(19, '2014-07-05', 'hassan.naajy@hsctz.com', 'c149aedbd1cf84de81f5ab7437e5b3255edef0f7d033e22ae348aeb5660fc2140aec35850c4da9970', 1, 40, 1),
(20, '2014-07-05', 'aysha.nassor@hsctz.com', 'c149aedbd1cf84de81f5ab7437e5b3255edef0f7d033e22ae348aeb5660fc2140aec35850c4da9970', 3, 40, 1),
(21, '2014-07-10', 'hannan.awadh@hsctz.com', 'c149aedbd1cf84de81f5ab7437e5b3255edef0f7d033e22ae348aeb5660fc2140aec35850c4da9970', 0, 21, 1),
(22, '2014-07-23', 'fahad@yoteyote.com', 'c149aedbd1cf84de81f5ab7437e5b3255edef0f7d033e22ae348aeb5660fc2140aec35850c4da9970', 1, 30, 2),
(23, '2014-08-02', 'fadhil.ahmed@hsctz.com', 'c149aedbd1cf84de81f5ab7437e5b3255edef0f7d033e22ae348aeb5660fc2140aec35850c4da9970', 0, 31, 9),
(24, '2014-08-06', 'fayz.said@hsctz.com', 'c149aedbd1cf84de81f5ab7437e5b3255edef0f7d033e22ae348aeb5660fc2140aec35850c4da9970', 0, 31, 1),
(25, '2014-08-06', 'ruwaida.hussein@hsctz.com', 'c149aedbd1cf84de81f5ab7437e5b3255edef0f7d033e22ae348aeb5660fc2140aec35850c4da9970', 0, 31, 1),
(26, '2014-08-18', 'pasua.mustafa@hsctz.com', 'c149aedbd1cf84de81f5ab7437e5b3255edef0f71a1ce4e5a0396e5ff97ebfee8ca1547e548d60cd0', 2, 50, 2),
(27, '2014-08-18', 'masoud.hafidh@hsctz.com', 'c149aedbd1cf84de81f5ab7437e5b3255edef0f7d033e22ae348aeb5660fc2140aec35850c4da9970', 4, 50, 6),
(28, '2014-08-19', 'swaleh.salim@hsctz.com', 'c149aedbd1cf84de81f5ab7437e5b3255edef0f70419f14fb8b0487fed90d0d4e1a7c443e12134ba0', 3, 40, 1),
(29, '2014-08-19', 'mohamed.merchant@hsctz.com', 'c149aedbd1cf84de81f5ab7437e5b3255edef0f7d033e22ae348aeb5660fc2140aec35850c4da9970', 0, 30, 1),
(30, '2014-08-19', 'hassan.mtola@hsctz.com', 'c149aedbd1cf84de81f5ab7437e5b3255edef0f7d033e22ae348aeb5660fc2140aec35850c4da9970', 1, 50, 4),
(31, '2014-08-20', 'fathiya.seif@hsctz.com', 'c149aedbd1cf84de81f5ab7437e5b3255edef0f7d033e22ae348aeb5660fc2140aec35850c4da9970', 1, 50, 4),
(32, '2014-08-20', 'zabibu.saleh@hsctz.com', 'c149aedbd1cf84de81f5ab7437e5b3255edef0f7d033e22ae348aeb5660fc2140aec35850c4da9970', 1, 50, 4),
(33, '2014-08-20', 'fahmy.abood@hsctz.com', 'c149aedbd1cf84de81f5ab7437e5b3255edef0f7d033e22ae348aeb5660fc2140aec35850c4da9970', 1, 60, 4),
(34, '2014-08-20', 'fauz.khalid@hsctz.com', 'c149aedbd1cf84de81f5ab7437e5b3255edef0f7d033e22ae348aeb5660fc2140aec35850c4da9970', 1, 50, 4);
