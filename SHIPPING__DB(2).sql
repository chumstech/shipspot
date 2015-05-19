-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 25, 2014 at 05:22 PM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `shipping`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE IF NOT EXISTS `admin_users` (
  `User_Id` int(11) NOT NULL AUTO_INCREMENT,
  `First_Name` varchar(256) DEFAULT NULL,
  `Last_Name` varchar(256) DEFAULT NULL,
  `Address` varchar(256) DEFAULT NULL,
  `Country` varchar(20) DEFAULT NULL,
  `Email` text,
  `Password` text,
  `Status` varchar(5) DEFAULT 'S',
  `Confirm` varchar(1) DEFAULT NULL,
  `Owner` varchar(256) DEFAULT 'farhan_admin',
  `Posted_Rates` varchar(1) NOT NULL DEFAULT 'Y',
  `Discounted_Rates` varchar(1) NOT NULL DEFAULT 'Y',
  `Phone_Number` varchar(256) DEFAULT NULL,
  `Account` varchar(256) DEFAULT NULL,
  `Account_Password` varchar(256) DEFAULT NULL,
  `Discount_Percentage` varchar(256) DEFAULT NULL,
  `CDate` datetime NOT NULL,
  `MDate` datetime NOT NULL,
  `CBy` varchar(256) NOT NULL,
  `MBy` varchar(256) NOT NULL,
  PRIMARY KEY (`User_Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Triggers `admin_users`
--
DROP TRIGGER IF EXISTS `shipping`.`tr_BI_admin_users`;
DELIMITER //
CREATE TRIGGER `shipping`.`tr_BI_admin_users` BEFORE INSERT ON `shipping`.`admin_users`
 FOR EACH ROW SET new.CDate = now()
//
DELIMITER ;
DROP TRIGGER IF EXISTS `shipping`.`tr_BU_admin_users`;
DELIMITER //
CREATE TRIGGER `shipping`.`tr_BU_admin_users` BEFORE UPDATE ON `shipping`.`admin_users`
 FOR EACH ROW SET new.MDate = now()
//
DELIMITER ;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`User_Id`, `First_Name`, `Last_Name`, `Address`, `Country`, `Email`, `Password`, `Status`, `Confirm`, `Owner`, `Posted_Rates`, `Discounted_Rates`, `Phone_Number`, `Account`, `Account_Password`, `Discount_Percentage`, `CDate`, `MDate`, `CBy`, `MBy`) VALUES
(7, 'Farhan', 'Masoud', 'lahore', 'US', 'farhan_admin', '123', 'S', NULL, 'self', 'Y', 'Y', '0234364890', NULL, NULL, '2', '2014-01-23 17:07:52', '2014-02-01 21:10:49', 'knnj', ''),
(10, 'test2', 'user2', 'jkhjk', 'US', 'test_user@gmail.comm', 'jkhk', 'S', NULL, 'farhan_admin', 'Y', 'Y', 'bjb', NULL, NULL, '', '2014-01-29 01:07:59', '0000-00-00 00:00:00', 'test_user@gmail.comm', ''),
(11, 'testing', 'user3', 'lahore', 'US', 'testing@hotmail.com', '123', 'S', NULL, 'farhan_admin', 'Y', 'Y', '3333333333', NULL, NULL, '', '2014-01-29 12:38:33', '0000-00-00 00:00:00', 'farhan_admin', ''),
(12, 'abc', 'aaa', 'uhu', '', 'aa', 'khhui', 'S', NULL, 'farhan_admin', 'Y', 'Y', 'bhj', NULL, NULL, '', '2014-01-31 13:02:10', '0000-00-00 00:00:00', 'farhan_admin', ''),
(13, 'new', 'new', 'lahore', 'US', 'new@hotmail,com', '123', 'S', NULL, 'farhan_admin', 'Y', 'Y', '123454444444645', NULL, NULL, '', '2014-02-01 19:34:39', '0000-00-00 00:00:00', 'farhan_admin', ''),
(14, 'newwwww', 'newwwwwwww', 'bjbbkj', 'US', 'jkhkhhoihoi', 'kjbkj', 'S', NULL, 'farhan_admin', 'Y', 'Y', 'bjkbk', NULL, NULL, '2', '2014-02-01 20:43:51', '0000-00-00 00:00:00', 'farhan_admin', '');

-- --------------------------------------------------------

--
-- Table structure for table `carriers`
--

CREATE TABLE IF NOT EXISTS `carriers` (
  `carrierr_Id` int(11) NOT NULL AUTO_INCREMENT,
  `carrier_name` varchar(256) DEFAULT NULL,
  `carrier_key` text,
  `carrier_password` text,
  `carrier_account_number` text,
  `carrier_other_number` text,
  `User_Email` text,
  `carrier_otherinfo` varchar(256) DEFAULT NULL,
  `CDate` datetime NOT NULL,
  `MDate` datetime NOT NULL,
  `CBy` varchar(256) NOT NULL,
  `MBy` varchar(256) NOT NULL,
  PRIMARY KEY (`carrierr_Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=63 ;

--
-- Triggers `carriers`
--
DROP TRIGGER IF EXISTS `shipping`.`tr_BI_carriers`;
DELIMITER //
CREATE TRIGGER `shipping`.`tr_BI_carriers` BEFORE INSERT ON `shipping`.`carriers`
 FOR EACH ROW SET new.CDate = now()
//
DELIMITER ;
DROP TRIGGER IF EXISTS `shipping`.`tr_BU_carriers`;
DELIMITER //
CREATE TRIGGER `shipping`.`tr_BU_carriers` BEFORE UPDATE ON `shipping`.`carriers`
 FOR EACH ROW SET new.MDate = now()
//
DELIMITER ;

--
-- Dumping data for table `carriers`
--

INSERT INTO `carriers` (`carrierr_Id`, `carrier_name`, `carrier_key`, `carrier_password`, `carrier_account_number`, `carrier_other_number`, `User_Email`, `carrier_otherinfo`, `CDate`, `MDate`, `CBy`, `MBy`) VALUES
(5, 'Fedex', '5VXN0ScEphyDey4a', 'qie9SCbPWdLaGUfYAdorMQSSi', '510087860', '118596021', 'farhan_admin', 'Nothing', '2014-01-23 20:21:50', '2014-01-23 23:31:51', '', 'farhan_admin'),
(4, 'UPS', 'devpkgdepot', 'Tea+coffee2', '0CC547555AAD9026', 'R5X685', 'farhan_admin', 'Nothing', '2014-01-23 20:18:42', '2014-02-25 09:39:27', '', 'farhan_admin'),
(6, 'Canada Post', 'CPC_SSSHIPPING', '', '', '', 'farhan_admin', '', '2014-01-23 20:23:01', '2014-02-07 02:48:54', '', 'farhan_admin'),
(7, 'Purolator', '223f39dcb2b74e4885bea58d7abf986c', '?vN$J%]z', '9999999999', '9999999999', 'farhan_admin', 'Nothing', '2014-01-23 20:24:16', '0000-00-00 00:00:00', '', 'farhan_admin'),
(10, 'TnT', 'devpkgdepT', 'coffeetea', '00001001878', '', 'farhan_admin', '', '2014-01-24 00:58:01', '2014-02-13 23:16:23', 'farhan_admin', ''),
(11, 'DHL', '344535355', '', '', '', 'farhan_admin', '', '2014-01-24 00:58:10', '0000-00-00 00:00:00', 'farhan_admin', ''),
(12, 'LOOMIS', '3535353453', '', '', '', 'farhan_admin', '', '2014-01-24 00:59:11', '0000-00-00 00:00:00', 'farhan_admin', ''),
(17, 'Purolator', '223f39dcb2b74e4885bea58d7abf986c', '?vN$J%]z', '9999999999', '9999999999', 'new@hotmail,com', 'Nothing', '2014-02-07 03:29:58', '2014-02-07 03:31:37', '', 'farhan_admin'),
(18, 'TnT', '123', '', '', '', 'new@hotmail,com', '', '2014-02-07 03:29:58', '2014-02-07 03:31:37', 'farhan_admin', ''),
(19, 'DHL', '344535355', '', '', '', 'new@hotmail,com', '', '2014-02-07 03:29:58', '2014-02-07 03:31:37', 'farhan_admin', ''),
(20, 'LOOMIS', '3535353453', '', '', '', 'new@hotmail,com', '', '2014-02-07 03:29:58', '2014-02-07 03:31:37', 'farhan_admin', ''),
(16, 'Canada Post', 'CPC_SSSHIPPING', '', '', '', 'new@hotmail,com', '', '2014-02-07 03:29:58', '2014-02-07 03:31:37', '', 'farhan_admin'),
(14, 'UPS', 'devpkgdepot', 'Tea+coffee2', '0CC547555AAD9026', 'R5X685', 'new@hotmail,com', 'Nothing', '2014-02-07 03:29:58', '2014-02-07 03:31:37', '', 'farhan_admin'),
(13, 'Fedex', '5VXN0ScEphyDey4a', 'qie9SCbPWdLaGUfYAdorMQSSi', '510087860', '118596021', 'new@hotmail,com', 'Nothing', '2014-02-07 03:29:58', '2014-02-07 03:31:37', '', 'farhan_admin');

-- --------------------------------------------------------

--
-- Table structure for table `discount`
--

CREATE TABLE IF NOT EXISTS `discount` (
  `discount_id` int(11) NOT NULL AUTO_INCREMENT,
  `discount` int(11) DEFAULT NULL,
  `UPS` varchar(256) DEFAULT NULL,
  `Fedex` varchar(256) DEFAULT NULL,
  `Canada_post` varchar(256) DEFAULT NULL,
  `Purolator` varchar(256) DEFAULT NULL,
  `TnT` varchar(256) DEFAULT NULL,
  `DHL` varchar(256) DEFAULT NULL,
  `Loomis` varchar(256) DEFAULT NULL,
  `User_Email` text,
  `CDate` datetime NOT NULL,
  `MDate` datetime NOT NULL,
  `CBy` varchar(256) NOT NULL,
  `MBy` varchar(256) NOT NULL,
  PRIMARY KEY (`discount_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Triggers `discount`
--
DROP TRIGGER IF EXISTS `shipping`.`tr_BI_discount`;
DELIMITER //
CREATE TRIGGER `shipping`.`tr_BI_discount` BEFORE INSERT ON `shipping`.`discount`
 FOR EACH ROW SET new.CDate = now()
//
DELIMITER ;
DROP TRIGGER IF EXISTS `shipping`.`tr_BU_discount`;
DELIMITER //
CREATE TRIGGER `shipping`.`tr_BU_discount` BEFORE UPDATE ON `shipping`.`discount`
 FOR EACH ROW SET new.MDate = now()
//
DELIMITER ;

--
-- Dumping data for table `discount`
--

INSERT INTO `discount` (`discount_id`, `discount`, `UPS`, `Fedex`, `Canada_post`, `Purolator`, `TnT`, `DHL`, `Loomis`, `User_Email`, `CDate`, `MDate`, `CBy`, `MBy`) VALUES
(1, 10, '8', '8', '8', '8', '8', '8', '99999999', 'zertashia@hotmail.com', '2014-02-03 16:54:52', '2014-02-03 21:49:17', '', 'farhan_admin'),
(2, NULL, '', '', '', '', '', '', '', '', '2014-02-03 20:28:10', '2014-02-03 21:18:46', 'farhan_admin', ''),
(4, NULL, '9', '9', '9', '9', '9', '9', '9', 'ali@hotmail.com', '2014-02-03 21:13:27', '2014-02-04 20:29:06', '', 'farhan_admin'),
(5, NULL, '$ups', '$fedex', '$canada', '$purolator', '$tnt', '$dhl', '$loomis', '$user_email', '2014-02-03 21:33:11', '0000-00-00 00:00:00', '', '$CBy'),
(6, NULL, '', '', '', '', '', '', '', 'admin', '2014-02-03 21:48:42', '2014-02-03 21:53:20', 'farhan_admin', ''),
(7, NULL, 'h', 'hj', 'j', 'j', 'j', 'j', 'j', 'hello', '2014-02-03 21:55:34', '0000-00-00 00:00:00', 'farhan_admin', ''),
(8, NULL, '', '', '', '', '', '', '', 'a', '2014-02-03 23:16:48', '0000-00-00 00:00:00', 'farhan_admin', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `User_Id` int(11) NOT NULL AUTO_INCREMENT,
  `First_Name` varchar(256) DEFAULT NULL,
  `Last_Name` varchar(256) DEFAULT NULL,
  `Address` varchar(256) DEFAULT NULL,
  `Country` varchar(20) DEFAULT NULL,
  `Email` text,
  `Password` text,
  `Status` varchar(5) DEFAULT 'R',
  `Confirm` varchar(1) DEFAULT NULL,
  `owner` varchar(256) DEFAULT 'farhan_admin',
  `Posted_Rates` varchar(1) NOT NULL DEFAULT 'N',
  `Discounted_Rates` varchar(1) NOT NULL DEFAULT 'N',
  `Phone_Number` varchar(256) DEFAULT NULL,
  `CDate` datetime NOT NULL,
  `MDate` datetime NOT NULL,
  `CBy` varchar(256) NOT NULL,
  `MBy` varchar(256) NOT NULL,
  PRIMARY KEY (`User_Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Triggers `users`
--
DROP TRIGGER IF EXISTS `shipping`.`tr_BI_users`;
DELIMITER //
CREATE TRIGGER `shipping`.`tr_BI_users` BEFORE INSERT ON `shipping`.`users`
 FOR EACH ROW SET new.CDate = now()
//
DELIMITER ;
DROP TRIGGER IF EXISTS `shipping`.`tr_BU_users`;
DELIMITER //
CREATE TRIGGER `shipping`.`tr_BU_users` BEFORE UPDATE ON `shipping`.`users`
 FOR EACH ROW SET new.MDate = now()
//
DELIMITER ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_Id`, `First_Name`, `Last_Name`, `Address`, `Country`, `Email`, `Password`, `Status`, `Confirm`, `owner`, `Posted_Rates`, `Discounted_Rates`, `Phone_Number`, `CDate`, `MDate`, `CBy`, `MBy`) VALUES
(6, 'ali', 'ali', 'jlkjl', 'CA', 'ali@hotmail.com', '123', 'R', NULL, 'new@hotmail,com', 'Y', 'N', 'j', '2014-02-03 15:37:21', '2014-02-25 09:50:06', 'farhan_admin', 'farhan_admin'),
(4, 'Iram', 'Aziz', 'erererer', 'CA', 'zertashia@hotmail.com', '123', NULL, NULL, 'farhan_admin', 'Y', 'N', '123454444444645', '2014-01-21 01:15:17', '2014-02-24 21:48:15', 'zertashia@hotmail.com', 'farhan_admin'),
(7, 'jk', 'jkj', 'lkj', 'CA', 'lkj', 'lkj', 'R', NULL, 'ali@hotmail.com', 'N', 'N', 'lkj', '2014-02-03 21:12:29', '2014-02-25 09:48:08', 'farhan_admin', 'farhan_admin');
