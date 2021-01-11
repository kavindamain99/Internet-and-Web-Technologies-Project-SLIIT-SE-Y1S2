-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3303
-- Generation Time: Oct 23, 2020 at 06:42 AM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `auc_sys_2020`
--

-- --------------------------------------------------------

--
-- Table structure for table `auc_sys_bids`
--

DROP TABLE IF EXISTS `auc_sys_bids`;
CREATE TABLE IF NOT EXISTS `auc_sys_bids` (
  `bid_id` int(255) NOT NULL AUTO_INCREMENT,
  `bid_price` varchar(255) NOT NULL,
  `buyer_id_fk` int(255) NOT NULL,
  `item_id_fk` int(255) NOT NULL,
  PRIMARY KEY (`bid_id`),
  KEY `auc_sys_bids_ibfk_1` (`buyer_id_fk`),
  KEY `item_id_fk` (`item_id_fk`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `auc_sys_buyer`
--

DROP TABLE IF EXISTS `auc_sys_buyer`;
CREATE TABLE IF NOT EXISTS `auc_sys_buyer` (
  `buyer_id` int(255) NOT NULL AUTO_INCREMENT,
  `b_fname` varchar(50) NOT NULL,
  `b_lname` varchar(50) NOT NULL,
  `b_email` varchar(50) NOT NULL,
  `b_user_type` varchar(10) NOT NULL,
  `b_password` varchar(255) NOT NULL,
  PRIMARY KEY (`buyer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `auc_sys_item`
--

DROP TABLE IF EXISTS `auc_sys_item`;
CREATE TABLE IF NOT EXISTS `auc_sys_item` (
  `item_id` int(255) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) NOT NULL,
  `img_name` varchar(255) DEFAULT NULL,
  `item_price` double NOT NULL,
  `seller_id_fk` int(11) NOT NULL,
  `due_date` date DEFAULT NULL,
  `due_time` time(6) DEFAULT NULL,
  PRIMARY KEY (`item_id`),
  KEY `seller_fk` (`seller_id_fk`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `auc_sys_seller`
--

DROP TABLE IF EXISTS `auc_sys_seller`;
CREATE TABLE IF NOT EXISTS `auc_sys_seller` (
  `seller_id` int(255) NOT NULL AUTO_INCREMENT,
  `s_fname` varchar(50) NOT NULL,
  `s_lname` varchar(50) NOT NULL,
  `s_email` varchar(50) NOT NULL,
  `s_user_type` varchar(10) NOT NULL,
  `s_password` varchar(255) NOT NULL,
  PRIMARY KEY (`seller_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auc_sys_bids`
--
ALTER TABLE `auc_sys_bids`
  ADD CONSTRAINT `auc_sys_bids_ibfk_1` FOREIGN KEY (`buyer_id_fk`) REFERENCES `auc_sys_buyer` (`buyer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auc_sys_bids_ibfk_2` FOREIGN KEY (`item_id_fk`) REFERENCES `auc_sys_item` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auc_sys_item`
--
ALTER TABLE `auc_sys_item`
  ADD CONSTRAINT `seller_fk` FOREIGN KEY (`seller_id_fk`) REFERENCES `auc_sys_seller` (`seller_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
