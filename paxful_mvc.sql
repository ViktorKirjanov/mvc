-- phpMyAdmin SQL Dump
-- version 4.0.10
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 22, 2016 at 09:33 AM
-- Server version: 5.5.35-log
-- PHP Version: 5.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `paxful_mvc`
--

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE IF NOT EXISTS `currencies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `currency` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `fiat` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `rate` float NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `currencies` (`currency`),
  UNIQUE KEY `fiat` (`fiat`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `currency`, `fiat`, `rate`) VALUES
(1, 'Euro', 'EUR', 0.9422),
(3, 'British Pound', 'GBP', 0.7949),
(4, 'US Dollar', 'USD', 1),
(5, 'Australian Dollar', 'AUD', 1.341);

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE IF NOT EXISTS `offers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` int(2) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `payment_method_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `min` int(6) NOT NULL,
  `max` int(6) NOT NULL,
  `margin` float NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `payment_method_id` (`payment_method_id`,`currency_id`),
  KEY `payment_method_id_2` (`payment_method_id`),
  KEY `type` (`type`),
  KEY `currency_id` (`currency_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=90 ;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `user_id`, `type`, `status`, `payment_method_id`, `currency_id`, `min`, `max`, `margin`, `date`) VALUES
(79, 13, 1, 4, 1, 4, 400, 1200, 1, '2016-12-22 04:06:55'),
(80, 12, 1, 4, 8, 4, 400, 1200, 1, '2016-12-22 04:22:26'),
(81, 12, 1, 2, 7, 1, 1000, 2000, 1, '2016-12-22 04:24:25'),
(82, 12, 1, 4, 3, 1, 100, 1600, 1, '2016-12-22 04:47:58'),
(83, 12, 2, 3, 1, 5, 100, 250, 1.5, '2016-12-22 04:48:52'),
(84, 12, 2, 1, 3, 4, 1000, 2000, 1, '2016-12-22 04:49:30'),
(85, 12, 1, 1, 4, 4, 2000, 2000, 1, '2016-12-22 05:06:10'),
(86, 14, 1, 1, 4, 4, 800, 800, 1, '2016-12-22 05:16:48'),
(87, 14, 1, 1, 5, 5, 800, 800, 1, '2016-12-22 05:17:10'),
(88, 14, 1, 1, 1, 3, 1, 2, 1, '2016-12-22 05:18:12'),
(89, 14, 2, 1, 7, 4, 100000, 200000, 0.5, '2016-12-22 05:18:32');

-- --------------------------------------------------------

--
-- Table structure for table `offer_types`
--

CREATE TABLE IF NOT EXISTS `offer_types` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `type` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `invert_offer_type_id` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `invert_offer_type_id` (`invert_offer_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `offer_types`
--

INSERT INTO `offer_types` (`id`, `type`, `invert_offer_type_id`) VALUES
(1, 'Sell', 2),
(2, 'Buy', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE IF NOT EXISTS `payment_methods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `name` varchar(72) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  KEY `group_id_2` (`group_id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `group_id`, `name`) VALUES
(1, 1, 'Amazon Gift Card'),
(2, 1, 'Walmart Gift Card'),
(3, 2, 'Cash in Person'),
(4, 2, 'Cash By Mail'),
(5, 3, 'Bank of America Online Transfer'),
(6, 3, 'Citibank Online Transfer'),
(7, 4, 'Debit Card'),
(8, 4, 'VISA Credit/Debit Card');

-- --------------------------------------------------------

--
-- Table structure for table `payment_method_groups`
--

CREATE TABLE IF NOT EXISTS `payment_method_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(72) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `payment_method_groups`
--

INSERT INTO `payment_method_groups` (`id`, `name`) VALUES
(1, 'Gift cards'),
(2, 'Cash deposits'),
(3, 'Online transfers'),
(4, 'Debit/credit cards');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `status` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `status`) VALUES
(0, 'disabled'),
(1, 'enabled'),
(2, 'deleted'),
(3, 'in progress'),
(4, 'done');

-- --------------------------------------------------------

--
-- Table structure for table `trades`
--

CREATE TABLE IF NOT EXISTS `trades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `offer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `amount` int(6) NOT NULL,
  `btc_amount` decimal(16,8) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `status` (`status`),
  KEY `offer_id` (`offer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=27 ;

--
-- Dumping data for table `trades`
--

INSERT INTO `trades` (`id`, `offer_id`, `user_id`, `date`, `amount`, `btc_amount`, `status`) VALUES
(22, 79, 12, '2016-12-22 04:20:47', 800, '1.00000000', 2),
(23, 80, 13, '2016-12-22 04:22:38', 800, '1.00000000', 2),
(24, 82, 13, '2016-12-22 05:05:10', 753, '0.99899172', 2),
(25, 83, 14, '2016-12-22 05:15:52', 100, '0.06214268', 0),
(26, 83, 14, '2016-12-22 05:20:28', 100, '0.06214268', 1);

-- --------------------------------------------------------

--
-- Table structure for table `trade_statuses`
--

CREATE TABLE IF NOT EXISTS `trade_statuses` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `status` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `trade_statuses`
--

INSERT INTO `trade_statuses` (`id`, `status`) VALUES
(0, 'canseled'),
(1, 'in progress'),
(2, 'done');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `full_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `btc` decimal(16,8) NOT NULL DEFAULT '5.00000000',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `full_name`, `password`, `btc`) VALUES
(12, 'testX123', 'Aaaaa Test', '01f98512b5a90ece9f9c2c13571f024c', '4.00100828'),
(13, 'testX200', 'Bbbbbb Test', '220d294b30b1b117dde4b8f8456b4d1e', '5.99899172'),
(14, 'testX300', 'Cccccc Test', 'f63e224e2829d3b5589cfd5d096075dd', '5.00000000');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `offers`
--
ALTER TABLE `offers`
  ADD CONSTRAINT `fk_offers_currencies_currency_id` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  ADD CONSTRAINT `fk_offers_offer_types_id` FOREIGN KEY (`type`) REFERENCES `offer_types` (`id`),
  ADD CONSTRAINT `fk_offers_payment_methods_payment_method_id` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`),
  ADD CONSTRAINT `fk_offers_status_id` FOREIGN KEY (`status`) REFERENCES `status` (`id`),
  ADD CONSTRAINT `fk_offers_users_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `offer_types`
--
ALTER TABLE `offer_types`
  ADD CONSTRAINT `fk_offer_types_offer_types_id` FOREIGN KEY (`invert_offer_type_id`) REFERENCES `offer_types` (`id`);

--
-- Constraints for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD CONSTRAINT `fk_payment_methods_payment_method_groups_group_id` FOREIGN KEY (`group_id`) REFERENCES `payment_method_groups` (`id`);

--
-- Constraints for table `trades`
--
ALTER TABLE `trades`
  ADD CONSTRAINT `fk_trades_statuses_id` FOREIGN KEY (`status`) REFERENCES `trade_statuses` (`id`),
  ADD CONSTRAINT `fk_user_trades_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
