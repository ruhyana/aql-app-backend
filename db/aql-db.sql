-- phpMyAdmin SQL Dump
-- version 3.4.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 17, 2014 at 01:33 AM
-- Server version: 5.1.73
-- PHP Version: 5.3.3-7+squeeze18

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `k2214867_publish`
--
CREATE DATABASE `k2214867_publish` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `k2214867_publish`;

-- --------------------------------------------------------

--
-- Table structure for table `mobile_reg`
--

CREATE TABLE IF NOT EXISTS `mobile_reg` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `phone_id` varchar(300) NOT NULL,
  `reg_id` varchar(300) NOT NULL,
  `app_version` int(11) NOT NULL,
  `app_id` varchar(20) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone_id` (`phone_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1488 ;

-- --------------------------------------------------------

--
-- Table structure for table `yisc_update`
--

CREATE TABLE IF NOT EXISTS `yisc_update` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `image` blob NOT NULL,
  `has_image` int(1) NOT NULL,
  `app_id` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=872 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
