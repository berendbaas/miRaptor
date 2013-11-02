-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 02, 2013 at 09:13 AM
-- Server version: 5.5.31
-- PHP Version: 5.4.17RC1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `miraptor_config`
--

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` int(11) NOT NULL,
  `runtime` int(11) NOT NULL,
  `bandwidth` int(11) NOT NULL,
  `statusCode` int(11) NOT NULL,
  `request` varchar(2048) COLLATE utf8_unicode_ci NOT NULL,
  `referal` varchar(2048) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=29 ;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`id`, `time`, `runtime`, `bandwidth`, `statusCode`, `request`, `referal`, `ip`) VALUES
(1, 1382531667, 6, 1034, 404, 'http://77.72.144.172/', NULL, '54.229.249.178'),
(2, 1382559334, 4, 1034, 404, 'http://77.72.144.172/HNAP1/', 'http://77.72.144.172/', '66.68.159.3'),
(3, 1382572728, 6, 1038, 404, 'http://admin.miraptor.nl/', NULL, '80.100.210.48'),
(4, 1382605270, 9, 1038, 404, 'http://admin.miraptor.nl/', NULL, '80.100.210.48'),
(5, 1382605274, 4, 998, 301, 'http://miraptor.nl/', NULL, '80.100.210.48'),
(6, 1382610119, 6, 1038, 404, 'http://admin.miraptor.nl/', NULL, '80.100.210.48'),
(7, 1382616177, 4, 1038, 404, 'http://admin.miraptor.nl/', NULL, '80.100.210.48'),
(8, 1382617448, 4, 1039, 404, 'http://www.daydaydata.comhttp://www.daydaydata.com/proxy.txt', NULL, '111.73.45.116'),
(9, 1382617450, 7, 1039, 404, 'http://www.daydaydata.comhttp://www.daydaydata.com/proxy.txt', NULL, '111.73.45.116'),
(10, 1382617458, 4, 1039, 404, 'http://www.daydaydata.comhttp://www.daydaydata.com/proxy.txt', NULL, '111.73.45.116'),
(11, 1383316252, 3, 1038, 404, 'http://admin.miraptor.nl/', NULL, '80.100.210.48'),
(12, 1383316623, 6, 1038, 404, 'http://admin.miraptor.nl/', NULL, '80.100.210.48'),
(13, 1383320043, 4, 1038, 404, 'http://admin.miraptor.nl/', NULL, '80.100.210.48'),
(14, 1383320082, 4, 1038, 404, 'http://admin.miraptor.nl/', NULL, '80.100.210.48'),
(15, 1383320082, 3, 1038, 404, 'http://admin.miraptor.nl/favicon.ico', 'http://admin.miraptor.nl/', '80.100.210.48'),
(16, 1383321585, 3, 1038, 404, 'http://admin.miraptor.nl/', NULL, '82.169.10.191'),
(17, 1383321586, 3, 1038, 404, 'http://admin.miraptor.nl/favicon.ico', NULL, '82.169.10.191'),
(18, 1383322074, 6, 1034, 404, 'http://77.72.144.172/HNAP1/', 'http://77.72.144.172/', '66.206.59.42'),
(19, 1383325634, 4, 1038, 404, 'http://admin.miraptor.nl/', NULL, '80.100.210.48'),
(20, 1383325637, 9, 1038, 404, 'http://admin.miraptor.nl/', NULL, '80.100.210.48'),
(21, 1383341911, 6, 1034, 404, 'http://77.72.144.172/', NULL, '198.20.70.114'),
(22, 1383341912, 4, 1034, 404, 'http://77.72.144.172/robots.txt', NULL, '198.20.70.114'),
(23, 1383364892, 12, 1034, 404, 'http://77.72.144.172/w00tw00t.at.blackhats.romanian.anti-sec:)', NULL, '85.17.155.196'),
(24, 1383364892, 6, 1034, 404, 'http://77.72.144.172/phpMyAdmin/scripts/setup.php', NULL, '85.17.155.196'),
(25, 1383364892, 8, 1034, 404, 'http://77.72.144.172/pma/scripts/setup.php', NULL, '85.17.155.196'),
(26, 1383364892, 4, 1034, 404, 'http://77.72.144.172/myadmin/scripts/setup.php', NULL, '85.17.155.196'),
(27, 1383364892, 3, 1034, 404, 'http://77.72.144.172/MyAdmin/scripts/setup.php', NULL, '85.17.155.196'),
(28, 1383367637, 7, 1034, 404, 'http://77.72.144.172/HNAP1/', 'http://77.72.144.172/', '50.198.58.77');

-- --------------------------------------------------------

--
-- Table structure for table `redirect`
--

CREATE TABLE IF NOT EXISTS `redirect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wid` int(11) NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `domain` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `redirect`
--

INSERT INTO `redirect` (`id`, `wid`, `path`, `domain`) VALUES
(1, 1, '', 'miraptor.nl');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `location`, `username`, `password`, `email`, `name`) VALUES
(1, '/admin', 'admin', 'Password', 'info@miwebb.com', 'miRaptor Admin');

-- --------------------------------------------------------

--
-- Table structure for table `website`
--

CREATE TABLE IF NOT EXISTS `website` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `domain` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `db` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `website`
--

INSERT INTO `website` (`id`, `uid`, `name`, `domain`, `db`, `location`, `active`) VALUES
(1, 1, 'miRaptor', 'www.miraptor.nl', 'miraptor_admin_miraptor', '/miraptor', 1),
(2, 1, 'miRaptor2', 'test.miraptor.nl', 'miraptor_admin_miraptor', '/miraptor', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `website`
--
ALTER TABLE `website`
  ADD CONSTRAINT `website_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
