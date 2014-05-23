-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 24, 2013 at 06:49 PM
-- Server version: 5.5.25
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `video`
--

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE IF NOT EXISTS `devices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deviceType` varchar(100) NOT NULL,
  `os` varchar(100) NOT NULL,
  `browser` varchar(100) NOT NULL,
  `ip` int(39) NOT NULL,
  `accessTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=48 ;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`id`, `deviceType`, `os`, `browser`, `ip`, `accessTime`) VALUES
(1, 'computer', 'os', 'IE', 2130706433, '2013-09-19 01:13:39'),
(2, 'computer', 'os', 'IE', 2130706433, '2013-09-19 02:12:25'),
(3, 'computer', 'os', 'IE', 2130706433, '2013-09-19 02:16:07'),
(4, 'computer', 'os', 'IE', 2130706433, '2013-09-19 02:17:24'),
(5, 'computer', 'os', 'IE', 2130706433, '2013-09-19 02:23:52'),
(6, 'computer', 'os', 'IE', 2130706433, '2013-09-19 02:24:00'),
(7, 'computer', 'os', 'IE', 2130706433, '2013-09-19 02:24:24'),
(8, 'computer', 'os', 'IE', 2130706433, '2013-09-19 02:24:31'),
(9, 'computer', 'os', 'IE', 2130706433, '2013-09-19 02:25:07'),
(10, 'computer', 'os', 'IE', 2130706433, '2013-09-19 02:25:17'),
(11, 'computer', 'os', 'IE', 2130706433, '2013-09-19 02:25:23'),
(12, 'computer', 'os', 'IE', 2130706433, '2013-09-19 02:56:26'),
(13, 'computer', 'os', 'IE', 2130706433, '2013-09-19 02:56:49'),
(14, 'phone', 'os', 'IE', 2130706433, '2013-09-19 03:06:46'),
(15, 'phone', 'os', 'IE', 2130706433, '2013-09-19 03:06:55'),
(16, 'phone', 'os', 'IE', 2130706433, '2013-09-19 03:06:57'),
(17, 'phone', 'os', 'IE', 2130706433, '2013-09-19 03:07:07'),
(18, 'phone', 'os', 'IE', 2130706433, '2013-09-19 03:07:22'),
(19, 'computer', 'os', 'IE', 2130706433, '2013-09-19 03:08:35'),
(20, 'tablet', 'os', 'IE', 2130706433, '2013-09-19 03:09:13'),
(21, 'tablet', 'os', 'IE', 2130706433, '2013-09-19 03:09:27'),
(22, 'tablet', 'os', 'IE', 2130706433, '2013-09-19 03:09:30'),
(23, 'tablet', 'os', 'IE', 2130706433, '2013-09-19 03:09:54'),
(24, 'tablet', 'os', 'IE', 2130706433, '2013-09-19 03:10:09'),
(25, 'tablet', 'os', 'IE', 2130706433, '2013-09-19 03:10:13'),
(26, 'computer', 'os', 'IE', 2130706433, '2013-09-19 03:10:23'),
(27, 'tablet', 'os', 'IE', 2130706433, '2013-09-19 03:16:10'),
(28, 'computer', 'os', 'IE', 2130706433, '2013-09-19 03:21:41'),
(29, 'tablet', 'os', 'IE', 2130706433, '2013-09-19 03:21:51'),
(30, 'tablet', 'os', 'IE', 2130706433, '2013-09-19 03:31:50'),
(31, 'computer', 'os', 'Safari', 2130706433, '2013-09-20 04:05:40'),
(32, 'computer', 'os', 'Safari', 2130706433, '2013-09-20 04:05:44'),
(33, 'computer', 'os', 'Chrome', 2130706433, '2013-09-20 04:08:07'),
(34, 'computer', 'os', 'Firefox', 2130706433, '2013-09-20 04:08:12'),
(35, 'computer', 'os', 'Firefox', 2130706433, '2013-09-20 04:08:18'),
(36, 'computer', 'os', 'Chrome', 2130706433, '2013-09-20 04:08:22'),
(37, 'computer', 'os', 'Firefox', 2130706433, '2013-09-20 04:08:24'),
(38, 'computer', 'os', 'Chrome', 2130706433, '2013-09-20 04:08:28'),
(39, 'phone', 'os', 'Safari', 2130706433, '2013-09-20 04:38:58'),
(40, 'phone', 'os', 'Safari', 2130706433, '2013-09-20 04:39:15'),
(41, 'phone', 'os', 'Safari', 2130706433, '2013-09-20 04:39:17'),
(42, 'tablet', 'os', 'Safari', 2130706433, '2013-09-20 04:39:52'),
(43, 'tablet', 'os', 'Safari', 2130706433, '2013-09-20 04:39:57'),
(44, 'tablet', 'os', 'Safari', 2130706433, '2013-09-20 04:39:58'),
(45, 'tablet', 'os', 'Safari', 2130706433, '2013-09-20 04:40:49'),
(46, 'computer', 'os', 'Firefox', 2130706433, '2013-09-20 06:22:32'),
(47, 'computer', 'os', 'Firefox', 2130706433, '2013-09-20 06:22:35');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
