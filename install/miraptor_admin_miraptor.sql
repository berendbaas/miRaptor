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
-- Database: `miraptor_admin_miraptor`
--

-- --------------------------------------------------------

--
-- Table structure for table `access`
--

CREATE TABLE IF NOT EXISTS `access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Dumping data for table `access`
--

INSERT INTO `access` (`id`, `name`) VALUES
(1, 'template'),
(2, 'stylesheet'),
(3, 'javascript'),
(4, 'block'),
(5, 'theme'),
(6, 'stats'),
(7, 'slider'),
(8, 'sitemap'),
(9, 'page'),
(10, 'news'),
(11, 'menu'),
(12, 'media'),
(13, 'mail'),
(14, 'breadcrumb'),
(15, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`id`, `name`) VALUES
(1, 'Default');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` int(11) NOT NULL,
  `runtime` int(11) NOT NULL,
  `bandwidth` int(11) NOT NULL,
  `statuscode` int(11) NOT NULL,
  `request` varchar(2048) COLLATE utf8_unicode_ci NOT NULL,
  `referal` varchar(2048) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=662 ;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`id`, `time`, `runtime`, `bandwidth`, `statuscode`, `request`, `referal`, `ip`) VALUES
(1, 1382294051, 9, 968, 200, 'http://www.miraptor.nl/raptor/', 'http://www.miraptor.nl/', '80.100.210.48'),
(2, 1382294051, 5, 955, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/raptor/', '80.100.210.48'),
(3, 1382294052, 5, 934, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(4, 1382294058, 6, 934, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(5, 1382294059, 6, 955, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(6, 1382294059, 6, 968, 200, 'http://www.miraptor.nl/raptor/', 'http://www.miraptor.nl/', '80.100.210.48'),
(7, 1382294059, 5, 934, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/raptor/', '80.100.210.48'),
(8, 1382294060, 6, 968, 200, 'http://www.miraptor.nl/raptor/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(9, 1382294060, 5, 955, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/raptor/', '80.100.210.48'),
(10, 1382294060, 6, 968, 200, 'http://www.miraptor.nl/raptor/', 'http://www.miraptor.nl/', '80.100.210.48'),
(11, 1382294061, 7, 934, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/raptor/', '80.100.210.48'),
(12, 1382294061, 6, 4765, 200, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(13, 1382294303, 27, 1650, 500, 'http://test.miraptor.nl/module/admin/site?id=1&module=block&action=new', 'http://test.miraptor.nl/module/admin/site?id=1&module=block&action=new', '80.100.210.48'),
(14, 1382294310, 8, 1780, 500, 'http://test.miraptor.nl/module/admin/site?id=1&module=block&action=remove&bid=3', 'http://test.miraptor.nl/module/admin/site?id=1&module=block&action=remove&bid=3', '80.100.210.48'),
(15, 1382294432, 13, 1653, 500, 'http://test.miraptor.nl/module/admin/site?id=1&module=block&action=remove&bid=3', 'http://test.miraptor.nl/module/admin/site?id=1&module=block&action=remove&bid=3', '80.100.210.48'),
(16, 1382294432, 4, 754, 304, 'http://www.miraptor.nl/_media/template/logo.png', 'http://test.miraptor.nl/module/admin/', '80.100.210.48'),
(17, 1382294435, 29, 1653, 500, 'http://test.miraptor.nl/module/admin/site?id=1&module=block&action=remove&bid=4', 'http://test.miraptor.nl/module/admin/site?id=1&module=block&action=remove&bid=4', '80.100.210.48'),
(18, 1382294441, 5, 1154, 500, 'http://test.miraptor.nl/module/admin/_media/template/logo.png', 'http://test.miraptor.nl/module/admin/site?id=1&module=block&action=edit&bid=2', '80.100.210.48'),
(19, 1382294458, 6, 934, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(20, 1382294459, 6, 968, 200, 'http://www.miraptor.nl/raptor/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(21, 1382294460, 11, 968, 200, 'http://www.miraptor.nl/raptor/', 'http://www.miraptor.nl/raptor/', '80.100.210.48'),
(22, 1382294460, 10, 934, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/raptor/', '80.100.210.48'),
(23, 1382295613, 12, 1154, 500, 'http://test.miraptor.nl/module/admin/_media/template/logo.png', 'http://test.miraptor.nl/module/admin/site?id=1&module=block&action=edit&bid=2', '80.100.210.48'),
(24, 1382295779, 25, 1916, 500, 'http://test.miraptor.nl/module/admin/site?id=1&module=block&action=edit&bid=2', 'http://test.miraptor.nl/module/admin/site?id=1&module=block&action=edit&bid=2', '80.100.210.48'),
(25, 1382295810, 6, 1154, 500, 'http://test.miraptor.nl/module/admin/_media/template/logo.png', 'http://test.miraptor.nl/module/admin/site?id=1&module=block&action=edit&bid=2', '80.100.210.48'),
(26, 1382295817, 4, 1154, 500, 'http://test.miraptor.nl/module/admin/_media/template/logo.png', 'http://test.miraptor.nl/module/admin/site?id=1&module=block&action=edit&bid=2', '80.100.210.48'),
(27, 1382295823, 9, 1778, 500, 'http://test.miraptor.nl/module/admin/site?id=1&module=template', 'http://test.miraptor.nl/module/admin/site?id=1&module=block&action=edit&bid=2', '80.100.210.48'),
(28, 1382296592, 7, 0, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/raptor/', '80.100.210.48'),
(29, 1382296693, 12, 1778, 500, 'http://test.miraptor.nl/module/admin/site?id=1&module=template', 'http://test.miraptor.nl/module/admin/site?id=1&module=menu', '80.100.210.48'),
(30, 1382296729, 10, 1776, 500, 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet&action=new', 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet&action=new', '80.100.210.48'),
(31, 1382296732, 11, 1778, 500, 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet&action=remove&tid=5', 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet&action=remove&tid=5', '80.100.210.48'),
(32, 1382296747, 71, 1650, 500, 'http://test.miraptor.nl/module/admin/site?id=1&module=block&action=new', 'http://test.miraptor.nl/module/admin/site?id=1&module=block&action=new', '80.100.210.48'),
(33, 1382296758, 11, 1653, 500, 'http://test.miraptor.nl/module/admin/site?id=1&module=block&action=remove&bid=5', 'http://test.miraptor.nl/module/admin/site?id=1&module=block&action=remove&bid=5', '80.100.210.48'),
(34, 1382297017, 9, 934, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/raptor/', '80.100.210.48'),
(35, 1382297147, 7, 934, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/raptor/', '80.100.210.48'),
(36, 1382297148, 6, 968, 200, 'http://www.miraptor.nl/raptor/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(37, 1382297149, 5, 955, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/raptor/', '80.100.210.48'),
(38, 1382297149, 6, 968, 200, 'http://www.miraptor.nl/raptor/', 'http://www.miraptor.nl/', '80.100.210.48'),
(39, 1382297149, 5, 934, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/raptor/', '80.100.210.48'),
(40, 1382297187, 12, 4765, 200, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(41, 1382297191, 13, 1309, 500, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(42, 1382297191, 12, 5307, 200, 'http://www.miraptor.nl/module/admin/overview', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(43, 1382297191, 11, 754, 304, 'http://www.miraptor.nl/_font/fontawesome-webfont.woff', 'http://www.miraptor.nl/module/admin/overview', '80.100.210.48'),
(44, 1382297194, 11, 1412, 500, 'http://www.miraptor.nl/module/admin/logout', 'http://www.miraptor.nl/module/admin/overview', '80.100.210.48'),
(45, 1382297194, 12, 4765, 200, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/module/admin/overview', '80.100.210.48'),
(46, 1382303104, 5, 357, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(47, 1382303273, 9, 0, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(48, 1382303559, 8, 747, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(49, 1382303789, 9, 955, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(50, 1382303791, 10, 968, 200, 'http://www.miraptor.nl/raptor/', 'http://www.miraptor.nl/', '80.100.210.48'),
(51, 1382303791, 10, 934, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/raptor/', '80.100.210.48'),
(52, 1382303792, 12, 4765, 200, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(53, 1382303794, 7, 955, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(54, 1382303805, 17, 968, 200, 'http://www.miraptor.nl/raptor/', 'http://www.miraptor.nl/', '80.100.210.48'),
(55, 1382303806, 6, 934, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/raptor/', '80.100.210.48'),
(56, 1382303806, 6, 955, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(57, 1382303891, 14, 1240, 500, 'http://test.miraptor.nl/module/admin/site?id=1&module=block', 'http://test.miraptor.nl/module/admin/site?id=1&module=menu', '80.100.210.48'),
(58, 1382303895, 12, 1458, 500, 'http://test.miraptor.nl/module/admin/', 'http://test.miraptor.nl/module/admin/', '80.100.210.48'),
(59, 1382303895, 15, 955, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(60, 1382303896, 7, 754, 304, 'http://www.miraptor.nl/_font/fontawesome-webfont.woff', 'http://test.miraptor.nl/module/admin/', '80.100.210.48'),
(61, 1382303897, 10, 1094, 500, 'http://www.miraptor.nl/module/admin/site?id=1', 'http://test.miraptor.nl/module/admin/overview', '80.100.210.48'),
(62, 1382303897, 11, 4765, 200, 'http://www.miraptor.nl/module/admin/', 'http://test.miraptor.nl/module/admin/overview', '80.100.210.48'),
(63, 1382303902, 6, 1248, 500, 'http://test.miraptor.nl/module/admin/', NULL, '80.100.210.48'),
(64, 1382303903, 9, 1094, 500, 'http://www.miraptor.nl/module/admin/site?id=1', 'http://test.miraptor.nl/module/admin/overview', '80.100.210.48'),
(65, 1382303903, 10, 4765, 200, 'http://www.miraptor.nl/module/admin/', 'http://test.miraptor.nl/module/admin/overview', '80.100.210.48'),
(66, 1382303905, 12, 1248, 500, 'http://test.miraptor.nl/module/admin/', NULL, '80.100.210.48'),
(67, 1382303907, 6, 1094, 500, 'http://www.miraptor.nl/module/admin/site?id=1', 'http://test.miraptor.nl/module/admin/overview', '80.100.210.48'),
(68, 1382303907, 7, 4765, 200, 'http://www.miraptor.nl/module/admin/', 'http://test.miraptor.nl/module/admin/overview', '80.100.210.48'),
(69, 1382303911, 14, 1309, 500, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(70, 1382303911, 12, 5307, 200, 'http://www.miraptor.nl/module/admin/overview', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(71, 1382304026, 6, 1154, 500, 'http://test.miraptor.nl/module/admin/_media/template/logo.png', 'http://test.miraptor.nl/module/admin/site?id=1&module=block&action=edit&bid=2', '80.100.210.48'),
(72, 1382304029, 6, 986, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(73, 1382304064, 3, 1154, 500, 'http://test.miraptor.nl/module/admin/_media/template/logo.png', 'http://test.miraptor.nl/module/admin/site?id=1&module=block&action=edit&bid=2', '80.100.210.48'),
(74, 1382304476, 15, 1639, 500, 'http://test.miraptor.nl/module/admin/site?id=1&module=template', 'http://test.miraptor.nl/module/admin/site?id=1&module=block&action=edit&bid=2', '80.100.210.48'),
(75, 1382304510, 18, 6599, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=template', 'http://test.miraptor.nl/module/admin/site?id=1&module=block&action=edit&bid=2', '80.100.210.48'),
(76, 1382304510, 6, 754, 304, 'http://www.miraptor.nl/_media/template/logo.png', 'http://test.miraptor.nl/module/admin/', '80.100.210.48'),
(77, 1382304515, 35, 5667, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=template&action=new', 'http://test.miraptor.nl/module/admin/site?id=1&module=template', '80.100.210.48'),
(78, 1382304518, 18, 6599, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=template', 'http://test.miraptor.nl/module/admin/site?id=1&module=block&action=edit&bid=2', '80.100.210.48'),
(79, 1382304521, 16, 6419, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=template&action=edit&tid=2', 'http://test.miraptor.nl/module/admin/site?id=1&module=template', '80.100.210.48'),
(80, 1382311162, 6, 957, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(81, 1382311713, 7, 970, 200, 'http://www.miraptor.nl/raptor/', 'http://www.miraptor.nl/', '80.100.210.48'),
(82, 1382311713, 11, 936, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/raptor/', '80.100.210.48'),
(83, 1382311714, 9, 970, 200, 'http://www.miraptor.nl/raptor/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(84, 1382311714, 6, 957, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/raptor/', '80.100.210.48'),
(85, 1382311739, 10, 970, 200, 'http://www.miraptor.nl/raptor/', 'http://www.miraptor.nl/', '80.100.210.48'),
(86, 1382311739, 6, 936, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/raptor/', '80.100.210.48'),
(87, 1382311740, 7, 970, 200, 'http://www.miraptor.nl/raptor/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(88, 1382311740, 6, 957, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/raptor/', '80.100.210.48'),
(89, 1382311740, 6, 970, 200, 'http://www.miraptor.nl/raptor/', 'http://www.miraptor.nl/', '80.100.210.48'),
(90, 1382311741, 6, 936, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/raptor/', '80.100.210.48'),
(91, 1382311741, 6, 970, 200, 'http://www.miraptor.nl/raptor/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(92, 1382311741, 6, 957, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/raptor/', '80.100.210.48'),
(93, 1382311742, 9, 970, 200, 'http://www.miraptor.nl/raptor/', 'http://www.miraptor.nl/', '80.100.210.48'),
(94, 1382311742, 7, 4767, 200, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/raptor/', '80.100.210.48'),
(95, 1382311743, 5, 936, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/raptor/', '80.100.210.48'),
(96, 1382311744, 6, 957, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(97, 1382312798, 9, 1102, 500, 'http://test.miraptor.nl/module/admin/site?id=1&module=template&action=edit&tid=2', 'http://test.miraptor.nl/module/admin/site?id=1&module=template', '87.210.81.211'),
(98, 1382312798, 6, 4767, 200, 'http://test.miraptor.nl/module/admin/', 'http://test.miraptor.nl/module/admin/site?id=1&module=template', '87.210.81.211'),
(99, 1382312799, 4, 754, 304, 'http://www.miraptor.nl/_media/template/logo.png', 'http://test.miraptor.nl/module/admin/', '87.210.81.211'),
(100, 1382312803, 12, 1319, 500, 'http://test.miraptor.nl/module/admin/', 'http://test.miraptor.nl/module/admin/', '87.210.81.211'),
(101, 1382312803, 12, 5309, 200, 'http://test.miraptor.nl/module/admin/overview', 'http://test.miraptor.nl/module/admin/', '87.210.81.211'),
(102, 1382312803, 6, 754, 304, 'http://www.miraptor.nl/_font/fontawesome-webfont.woff', 'http://test.miraptor.nl/module/admin/', '87.210.81.211'),
(103, 1382312805, 6, 1094, 500, 'http://www.miraptor.nl/module/admin/site?id=1', 'http://test.miraptor.nl/module/admin/overview', '87.210.81.211'),
(104, 1382312805, 7, 4767, 200, 'http://www.miraptor.nl/module/admin/', 'http://test.miraptor.nl/module/admin/overview', '87.210.81.211'),
(105, 1382312811, 7, 1309, 500, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/module/admin/', '87.210.81.211'),
(106, 1382312811, 7, 5309, 200, 'http://www.miraptor.nl/module/admin/overview', 'http://www.miraptor.nl/module/admin/', '87.210.81.211'),
(107, 1382312819, 8, 5574, 200, 'http://test.miraptor.nl/module/admin/site?id=1', NULL, '87.210.81.211'),
(108, 1382312825, 10, 5768, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript', 'http://test.miraptor.nl/module/admin/site?id=1', '87.210.81.211'),
(109, 1382312826, 7, 5874, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript&action=new', 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript', '87.210.81.211'),
(110, 1382312838, 15, 1718, 500, 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript&action=new', 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript&action=new', '87.210.81.211'),
(111, 1382312878, 12, 1548, 500, 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript&action=new', 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript&action=new', '87.210.81.211'),
(112, 1382312884, 8, 5874, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript&action=new', NULL, '87.210.81.211'),
(113, 1382312887, 8, 6063, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript', 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript&action=new', '87.210.81.211'),
(114, 1382312889, 8, 5895, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript&action=edit&sid=1', 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript', '87.210.81.211'),
(115, 1382312894, 15, 5899, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript&action=edit&sid=1', 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript&action=edit&sid=1', '87.210.81.211'),
(116, 1382312897, 12, 5956, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript&action=edit&sid=1', 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript&action=edit&sid=1', '87.210.81.211'),
(117, 1382312899, 15, 6063, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript', 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript&action=edit&sid=1', '87.210.81.211'),
(118, 1382312900, 14, 5899, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript&action=edit&sid=1', 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript', '87.210.81.211'),
(119, 1382312904, 27, 5901, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript&action=edit&sid=1', 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript&action=edit&sid=1', '87.210.81.211'),
(120, 1382312907, 19, 5902, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript&action=edit&sid=1', 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript&action=edit&sid=1', '87.210.81.211'),
(121, 1382312909, 14, 6063, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript', 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript&action=edit&sid=1', '87.210.81.211'),
(122, 1382312910, 18, 5902, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript&action=edit&sid=1', 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript', '87.210.81.211'),
(123, 1382312912, 8, 6063, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript', 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript&action=edit&sid=1', '87.210.81.211'),
(124, 1382312916, 14, 5874, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript&action=new', 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript', '87.210.81.211'),
(125, 1382312929, 28, 1548, 500, 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript&action=new', 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript&action=new', '87.210.81.211'),
(126, 1382313049, 15, 1531, 500, 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript&action=new', 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript&action=new', '87.210.81.211'),
(127, 1382313049, 9, 6663, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript', 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript&action=new', '87.210.81.211'),
(128, 1382313049, 3, 754, 304, 'http://www.miraptor.nl/_media/template/logo.png', 'http://test.miraptor.nl/module/admin/', '87.210.81.211'),
(129, 1382313051, 8, 5853, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript&action=remove&sid=3', 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript', '87.210.81.211'),
(130, 1382313054, 19, 1551, 500, 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript&action=remove&sid=3', 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript&action=remove&sid=3', '87.210.81.211'),
(131, 1382313072, 8, 6363, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript', NULL, '87.210.81.211'),
(132, 1382313074, 8, 5853, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript&action=remove&sid=2', 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript', '87.210.81.211'),
(133, 1382313075, 24, 1534, 500, 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript&action=remove&sid=2', 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript&action=remove&sid=2', '87.210.81.211'),
(134, 1382313075, 9, 6063, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript', 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript&action=remove&sid=2', '87.210.81.211'),
(135, 1382314317, 15, 6324, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=block', 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript', '87.210.81.211'),
(136, 1382314320, 8, 6063, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript', 'http://test.miraptor.nl/module/admin/site?id=1&module=block', '87.210.81.211'),
(137, 1382315708, 16, 6703, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=template', 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript', '87.210.81.211'),
(138, 1382335974, 8, 1094, 500, 'http://www.miraptor.nl/module/admin/site?id=1', NULL, '87.210.81.211'),
(139, 1382335974, 7, 4767, 200, 'http://www.miraptor.nl/module/admin/', NULL, '87.210.81.211'),
(140, 1382335989, 10, 1309, 500, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/module/admin/', '87.210.81.211'),
(141, 1382335989, 7, 5309, 200, 'http://www.miraptor.nl/module/admin/overview', 'http://www.miraptor.nl/module/admin/', '87.210.81.211'),
(142, 1382336002, 8, 1102, 500, 'http://test.miraptor.nl/module/admin/site?id=1', NULL, '87.210.81.211'),
(143, 1382336002, 6, 4767, 200, 'http://test.miraptor.nl/module/admin/', NULL, '87.210.81.211'),
(144, 1382336015, 7, 1319, 500, 'http://test.miraptor.nl/module/admin/', 'http://test.miraptor.nl/module/admin/', '87.210.81.211'),
(145, 1382336015, 7, 5309, 200, 'http://test.miraptor.nl/module/admin/overview', 'http://test.miraptor.nl/module/admin/', '87.210.81.211'),
(146, 1382336024, 8, 5574, 200, 'http://test.miraptor.nl/module/admin/site?id=1', NULL, '87.210.81.211'),
(147, 1382336028, 8, 6063, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript', 'http://test.miraptor.nl/module/admin/site?id=1', '87.210.81.211'),
(148, 1382344106, 5, 700, 400, 'http://www.miraptor.nl/', NULL, '46.174.199.10'),
(149, 1382350783, 8, 1102, 500, 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript', 'http://test.miraptor.nl/module/admin/site?id=1', '87.210.81.211'),
(150, 1382350783, 7, 4767, 200, 'http://test.miraptor.nl/module/admin/', 'http://test.miraptor.nl/module/admin/site?id=1', '87.210.81.211'),
(151, 1382350974, 9, 1319, 500, 'http://test.miraptor.nl/module/admin/', 'http://test.miraptor.nl/module/admin/', '87.210.81.211'),
(152, 1382350974, 10, 5309, 200, 'http://test.miraptor.nl/module/admin/overview', 'http://test.miraptor.nl/module/admin/', '87.210.81.211'),
(153, 1382350985, 8, 1094, 500, 'http://www.miraptor.nl/module/admin/site?id=1', 'http://test.miraptor.nl/module/admin/overview', '87.210.81.211'),
(154, 1382350985, 8, 4767, 200, 'http://www.miraptor.nl/module/admin/', 'http://test.miraptor.nl/module/admin/overview', '87.210.81.211'),
(155, 1382350995, 17, 1309, 500, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/module/admin/', '87.210.81.211'),
(156, 1382350995, 14, 5309, 200, 'http://www.miraptor.nl/module/admin/overview', 'http://www.miraptor.nl/module/admin/', '87.210.81.211'),
(157, 1382351002, 17, 5574, 200, 'http://test.miraptor.nl/module/admin/site?id=1', NULL, '87.210.81.211'),
(158, 1382351010, 19, 6324, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=block', 'http://test.miraptor.nl/module/admin/site?id=1', '87.210.81.211'),
(159, 1382351013, 8, 6063, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript', 'http://test.miraptor.nl/module/admin/site?id=1&module=block', '87.210.81.211'),
(160, 1382354075, 8, 1102, 500, 'http://test.miraptor.nl/module/admin/site?id=1&module=template', 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript', '87.210.81.211'),
(161, 1382354075, 7, 4767, 200, 'http://test.miraptor.nl/module/admin/', 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript', '87.210.81.211'),
(162, 1382354084, 24, 1319, 500, 'http://test.miraptor.nl/module/admin/', 'http://test.miraptor.nl/module/admin/', '87.210.81.211'),
(163, 1382354084, 14, 5309, 200, 'http://test.miraptor.nl/module/admin/overview', 'http://test.miraptor.nl/module/admin/', '87.210.81.211'),
(164, 1382354086, 11, 1094, 500, 'http://www.miraptor.nl/module/admin/site?id=1', 'http://test.miraptor.nl/module/admin/overview', '87.210.81.211'),
(165, 1382354087, 13, 4767, 200, 'http://www.miraptor.nl/module/admin/', 'http://test.miraptor.nl/module/admin/overview', '87.210.81.211'),
(166, 1382354091, 13, 1309, 500, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/module/admin/', '87.210.81.211'),
(167, 1382354091, 14, 5309, 200, 'http://www.miraptor.nl/module/admin/overview', 'http://www.miraptor.nl/module/admin/', '87.210.81.211'),
(168, 1382354501, 22, 5574, 200, 'http://test.miraptor.nl/module/admin/site?id=1', NULL, '87.210.81.211'),
(169, 1382354503, 15, 6703, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=template', 'http://test.miraptor.nl/module/admin/site?id=1', '87.210.81.211'),
(170, 1382354656, 11, 6703, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=template', 'http://test.miraptor.nl/module/admin/site?id=1&module=template', '87.210.81.211'),
(171, 1382354656, 7, 754, 304, 'http://www.miraptor.nl/_media/template/logo.png', 'http://test.miraptor.nl/module/admin/', '87.210.81.211'),
(172, 1382354658, 14, 5771, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=template&action=new', 'http://test.miraptor.nl/module/admin/site?id=1&module=template', '87.210.81.211'),
(173, 1382354688, 20, 1625, 500, 'http://test.miraptor.nl/module/admin/site?id=1&module=template&action=new', 'http://test.miraptor.nl/module/admin/site?id=1&module=template&action=new', '87.210.81.211'),
(174, 1382354688, 17, 7157, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=template', 'http://test.miraptor.nl/module/admin/site?id=1&module=template&action=new', '87.210.81.211'),
(175, 1382354718, 8, 7157, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=template', 'http://test.miraptor.nl/module/admin/site?id=1&module=template&action=new', '87.210.81.211'),
(176, 1382354718, 3, 754, 304, 'http://www.miraptor.nl/_media/template/logo.png', 'http://test.miraptor.nl/module/admin/', '87.210.81.211'),
(177, 1382354720, 8, 5913, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=template&action=edit&tid=3', 'http://test.miraptor.nl/module/admin/site?id=1&module=template', '87.210.81.211'),
(178, 1382354725, 12, 5918, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=template&action=edit&tid=3', 'http://test.miraptor.nl/module/admin/site?id=1&module=template&action=edit&tid=3', '87.210.81.211'),
(179, 1382354729, 9, 7157, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=template', 'http://test.miraptor.nl/module/admin/site?id=1&module=template&action=edit&tid=3', '87.210.81.211'),
(180, 1382354731, 8, 5918, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=template&action=edit&tid=3', 'http://test.miraptor.nl/module/admin/site?id=1&module=template', '87.210.81.211'),
(181, 1382354733, 15, 7157, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=template', 'http://test.miraptor.nl/module/admin/site?id=1&module=template&action=edit&tid=3', '87.210.81.211'),
(182, 1382354734, 13, 5794, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=template&action=remove&tid=3', 'http://test.miraptor.nl/module/admin/site?id=1&module=template', '87.210.81.211'),
(183, 1382354737, 15, 7157, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=template', 'http://test.miraptor.nl/module/admin/site?id=1&module=template&action=remove&tid=3', '87.210.81.211'),
(184, 1382354739, 8, 1394, 500, 'http://test.miraptor.nl/module/admin/site?id=1&module=template&action=rename&tid=3', 'http://test.miraptor.nl/module/admin/site?id=1&module=template', '87.210.81.211'),
(185, 1382354743, 7, 7157, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=template', 'http://test.miraptor.nl/module/admin/site?id=1&module=template&action=remove&tid=3', '87.210.81.211'),
(186, 1382354746, 9, 5918, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=template&action=edit&tid=3', 'http://test.miraptor.nl/module/admin/site?id=1&module=template', '87.210.81.211'),
(187, 1382354800, 9, 6723, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=template', 'http://test.miraptor.nl/module/admin/site?id=1&module=template&action=edit&tid=3', '87.210.81.211'),
(188, 1382354805, 14, 5568, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=menu', 'http://test.miraptor.nl/module/admin/site?id=1&module=template', '87.210.81.211'),
(189, 1382354806, 8, 6723, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=template', 'http://test.miraptor.nl/module/admin/site?id=1&module=menu', '87.210.81.211'),
(190, 1382354807, 8, 6833, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet', 'http://test.miraptor.nl/module/admin/site?id=1&module=template', '87.210.81.211'),
(191, 1382354837, 8, 6515, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet', 'http://test.miraptor.nl/module/admin/site?id=1&module=template', '87.210.81.211'),
(192, 1382354837, 4, 754, 304, 'http://www.miraptor.nl/_media/template/logo.png', 'http://test.miraptor.nl/module/admin/', '87.210.81.211'),
(193, 1382354840, 8, 6063, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript', 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet', '87.210.81.211'),
(194, 1382354880, 16, 6324, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=block', 'http://test.miraptor.nl/module/admin/site?id=1&module=javascript', '87.210.81.211'),
(195, 1382354883, 19, 5881, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=block&action=new', 'http://test.miraptor.nl/module/admin/site?id=1&module=block', '87.210.81.211'),
(196, 1382354886, 8, 6723, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=template', 'http://test.miraptor.nl/module/admin/site?id=1&module=block&action=new', '87.210.81.211'),
(197, 1382354887, 13, 5776, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=template&action=new', 'http://test.miraptor.nl/module/admin/site?id=1&module=template', '87.210.81.211'),
(198, 1382354890, 16, 7019, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=page', 'http://test.miraptor.nl/module/admin/site?id=1&module=template&action=new', '87.210.81.211'),
(199, 1382354897, 12, 6515, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet', 'http://test.miraptor.nl/module/admin/site?id=1&module=page', '87.210.81.211'),
(200, 1382354899, 16, 6723, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=template', 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet', '87.210.81.211'),
(201, 1382354900, 14, 5568, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=menu', 'http://test.miraptor.nl/module/admin/site?id=1&module=template', '87.210.81.211'),
(202, 1382354902, 13, 5574, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=breadcrumb', 'http://test.miraptor.nl/module/admin/site?id=1&module=menu', '87.210.81.211'),
(203, 1382355517, 13, 5574, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=breadcrumb', 'http://test.miraptor.nl/module/admin/site?id=1&module=menu', '87.210.81.211'),
(204, 1382355521, 9, 64046, 200, 'http://test.miraptor.nl/favicon.ico', NULL, '87.210.81.211'),
(205, 1382358406, 11, 1102, 500, 'http://test.miraptor.nl/module/admin/site?id=1&module=media', 'http://test.miraptor.nl/module/admin/site?id=1&module=breadcrumb', '87.210.81.211'),
(206, 1382358406, 12, 4767, 200, 'http://test.miraptor.nl/module/admin/', 'http://test.miraptor.nl/module/admin/site?id=1&module=breadcrumb', '87.210.81.211'),
(207, 1382358411, 10, 1319, 500, 'http://test.miraptor.nl/module/admin/', 'http://test.miraptor.nl/module/admin/', '87.210.81.211'),
(208, 1382358411, 11, 5309, 200, 'http://test.miraptor.nl/module/admin/overview', 'http://test.miraptor.nl/module/admin/', '87.210.81.211'),
(209, 1382358413, 6, 1094, 500, 'http://www.miraptor.nl/module/admin/site?id=1', 'http://test.miraptor.nl/module/admin/overview', '87.210.81.211'),
(210, 1382358413, 8, 4767, 200, 'http://www.miraptor.nl/module/admin/', 'http://test.miraptor.nl/module/admin/overview', '87.210.81.211'),
(211, 1382358413, 4, 64046, 200, 'http://www.miraptor.nl/favicon.ico', NULL, '87.210.81.211'),
(212, 1382358417, 12, 1309, 500, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/module/admin/', '87.210.81.211'),
(213, 1382358417, 7, 5309, 200, 'http://www.miraptor.nl/module/admin/overview', 'http://www.miraptor.nl/module/admin/', '87.210.81.211'),
(214, 1382358423, 7, 5574, 200, 'http://test.miraptor.nl/module/admin/site?id=1', NULL, '87.210.81.211'),
(215, 1382358437, 8, 6515, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet', 'http://test.miraptor.nl/module/admin/site?id=1', '87.210.81.211'),
(216, 1382358439, 14, 9711, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet&action=edit&tid=2', 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet', '87.210.81.211'),
(217, 1382358453, 132, 9711, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet&action=edit&tid=2', 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet&action=edit&tid=2', '87.210.81.211'),
(218, 1382358455, 17, 6521, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet', 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet&action=edit&tid=2', '87.210.81.211'),
(219, 1382358458, 9, 9711, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet&action=edit&tid=2', 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet', '87.210.81.211'),
(220, 1382358461, 11, 6521, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet', 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet&action=edit&tid=2', '87.210.81.211'),
(221, 1382358508, 9, 6521, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet', 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet', '87.210.81.211'),
(222, 1382358510, 15, 9711, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet&action=edit&tid=2', 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet', '87.210.81.211'),
(223, 1382358515, 8, 6521, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet', 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet&action=edit&tid=2', '87.210.81.211'),
(224, 1382358516, 8, 9725, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet&action=edit&tid=1', 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet', '87.210.81.211'),
(225, 1382358518, 15, 6521, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet', 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet&action=edit&tid=1', '87.210.81.211'),
(226, 1382358520, 9, 9711, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet&action=edit&tid=2', 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet', '87.210.81.211'),
(227, 1382358537, 155, 6199, 500, 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet&action=edit&tid=2', 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet&action=edit&tid=2', '87.210.81.211'),
(228, 1382358601, 12, 9711, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet&action=edit&sid=2', NULL, '87.210.81.211'),
(229, 1382358609, 389, 9708, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet&action=edit&sid=2', 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet&action=edit&sid=2', '87.210.81.211'),
(230, 1382358612, 9, 6506, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet', 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet&action=edit&sid=2', '87.210.81.211'),
(231, 1382358615, 13, 9716, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet&action=edit&sid=1', 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet', '87.210.81.211'),
(232, 1382358628, 663, 9708, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet&action=edit&sid=1', 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet&action=edit&sid=1', '87.210.81.211'),
(233, 1382358631, 15, 6506, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet', 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet&action=edit&sid=1', '87.210.81.211'),
(234, 1382358632, 9, 9699, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet&action=edit&sid=2', 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet', '87.210.81.211'),
(235, 1382358910, 8, 7010, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=page', 'http://test.miraptor.nl/module/admin/site?id=1&module=stylesheet&action=edit&sid=2', '87.210.81.211'),
(236, 1382358911, 8, 5559, 200, 'http://test.miraptor.nl/module/admin/site?id=1&module=menu', 'http://test.miraptor.nl/module/admin/site?id=1&module=page', '87.210.81.211'),
(237, 1382362838, 8, 4370, 200, 'http://test.miraptor.nl/', NULL, '87.210.81.211'),
(238, 1382362840, 6, 1102, 500, 'http://test.miraptor.nl/module/admin/site?id=1&module=menu', 'http://test.miraptor.nl/module/admin/site?id=1&module=page', '87.210.81.211'),
(239, 1382362841, 6, 4758, 200, 'http://test.miraptor.nl/module/admin/', 'http://test.miraptor.nl/module/admin/site?id=1&module=page', '87.210.81.211'),
(240, 1382362851, 8, 4349, 200, 'http://www.miraptor.nl/module/', 'http://test.miraptor.nl/', '87.210.81.211'),
(241, 1382375354, 7, 4370, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(242, 1382382075, 17, 4370, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(243, 1382385543, 17, 4370, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/', '80.100.210.48'),
(244, 1382385544, 6, 4383, 200, 'http://www.miraptor.nl/raptor/', 'http://www.miraptor.nl/', '80.100.210.48'),
(245, 1382385544, 7, 4370, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/raptor/', '80.100.210.48'),
(246, 1382392134, 10, 4370, 200, 'http://www.miraptor.nl/', NULL, '108.62.112.146'),
(247, 1382398304, 7, 4370, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(248, 1382438007, 15, 4370, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(249, 1382438838, 16, 4370, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(250, 1382444299, 15, 4370, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(251, 1382447021, 20, 4370, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(252, 1382447021, 8, 64046, 200, 'http://www.miraptor.nl/favicon.ico', 'http://www.miraptor.nl/', '80.100.210.48'),
(253, 1382447235, 8, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(254, 1382447247, 8, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(255, 1382447247, 6, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(256, 1382447248, 8, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(257, 1382447251, 6, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(258, 1382447251, 6, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(259, 1382447269, 12, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(260, 1382447269, 6, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(261, 1382447328, 11, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(262, 1382447329, 11, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(263, 1382447330, 11, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(264, 1382447330, 10, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(265, 1382448098, 11, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(266, 1382448526, 18, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(267, 1382448526, 7, 64046, 200, 'http://www.miraptor.nl/favicon.ico', 'http://www.miraptor.nl/', '80.100.210.48'),
(268, 1382451612, 13, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(269, 1382452221, 7, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(270, 1382452589, 14, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(271, 1382455929, 10, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(272, 1382461611, 7, 1316, 200, 'http://www.miraptor.nl/', NULL, '82.169.10.191'),
(273, 1382461611, 8, 64046, 200, 'http://www.miraptor.nl/favicon.ico', NULL, '82.169.10.191'),
(274, 1382461612, 7, 4758, 200, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/', '82.169.10.191'),
(275, 1382461613, 5, 387129, 200, 'http://www.miraptor.nl/_media/template/logo.png', 'http://www.miraptor.nl/module/admin/', '82.169.10.191'),
(276, 1382461628, 8, 1309, 500, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/module/admin/', '82.169.10.191'),
(277, 1382461628, 7, 5300, 200, 'http://www.miraptor.nl/module/admin/overview', 'http://www.miraptor.nl/module/admin/', '82.169.10.191'),
(278, 1382461628, 4, 43572, 200, 'http://www.miraptor.nl/_font/fontawesome-webfont.woff', 'http://www.miraptor.nl/', '82.169.10.191'),
(279, 1382461630, 10, 4788, 200, 'http://www.miraptor.nl/module/admin/settings', 'http://www.miraptor.nl/module/admin/overview', '82.169.10.191'),
(280, 1382461632, 8, 4925, 200, 'http://www.miraptor.nl/module/admin/settings?edit=mail', 'http://www.miraptor.nl/module/admin/settings', '82.169.10.191'),
(281, 1382461634, 7, 5300, 200, 'http://www.miraptor.nl/module/admin/overview', 'http://www.miraptor.nl/module/admin/settings?edit=mail', '82.169.10.191'),
(282, 1382461639, 6, 1316, 200, 'http://www.miraptor.nl/?id=1&action=domain', 'http://www.miraptor.nl/module/admin/overview', '82.169.10.191'),
(283, 1382461640, 7, 5300, 200, 'http://www.miraptor.nl/module/admin/overview', 'http://www.miraptor.nl/module/admin/settings?edit=mail', '82.169.10.191'),
(284, 1382461643, 10, 5300, 200, 'http://www.miraptor.nl/module/admin/overview', 'http://www.miraptor.nl/module/admin/settings?edit=mail', '82.169.10.191'),
(285, 1382461645, 7, 5300, 200, 'http://www.miraptor.nl/module/admin/overview', 'http://www.miraptor.nl/module/admin/settings?edit=mail', '82.169.10.191'),
(286, 1382462869, 14, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(287, 1382479354, 14, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(288, 1382479373, 14, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(289, 1382487243, 10, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(290, 1382487679, 10, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(291, 1382487683, 9, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(292, 1382487683, 13, 4758, 200, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(293, 1382487683, 7, 387129, 200, 'http://www.miraptor.nl/_media/template/logo.png', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(294, 1382487909, 6, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(295, 1382488044, 4, 328, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(296, 1382488128, 11, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(297, 1382488233, 6, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(298, 1382488277, 9, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(299, 1382488289, 15, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(300, 1382488362, 7, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(301, 1382488435, 15, 4808, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(302, 1382488664, 13, 12155, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(303, 1382488705, 13, 12155, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(304, 1382488889, 14, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(305, 1382488905, 7, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(306, 1382488906, 10, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(307, 1382489010, 14, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(308, 1382489013, 9, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(309, 1382489014, 9, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(310, 1382489031, 11, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(311, 1382489031, 13, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(312, 1382489040, 9, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(313, 1382489041, 7, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(314, 1382489042, 6, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(315, 1382489043, 5, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(316, 1382489044, 7, 4758, 200, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/', '80.100.210.48'),
(317, 1382489045, 10, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(318, 1382489227, 9, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(319, 1382489297, 4, 357, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(320, 1382489316, 4, 357, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(321, 1382489334, 8, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(322, 1382489374, 9, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(323, 1382489375, 6, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(324, 1382489375, 9, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(325, 1382489375, 9, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(326, 1382489529, 17, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(327, 1382489530, 7, 4758, 200, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(328, 1382489532, 5, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(329, 1382489533, 12, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(330, 1382489533, 5, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(331, 1382489701, 6, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(332, 1382489702, 6, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(333, 1382489707, 7, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(334, 1382489708, 7, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(335, 1382489709, 7, 4758, 200, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(336, 1382489726, 6, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(337, 1382489727, 7, 4758, 200, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/', '80.100.210.48'),
(338, 1382489728, 6, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(339, 1382489729, 6, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(340, 1382489729, 6, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(341, 1382489730, 6, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(342, 1382489730, 5, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(343, 1382489730, 6, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(344, 1382489731, 8, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(345, 1382489731, 7, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/', '80.100.210.48'),
(346, 1382489732, 6, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/', '80.100.210.48'),
(347, 1382489733, 5, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/', '80.100.210.48'),
(348, 1382489734, 6, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/', '80.100.210.48'),
(349, 1382489735, 6, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/', '80.100.210.48'),
(350, 1382489735, 11, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(351, 1382489736, 6, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(352, 1382489750, 7, 4758, 200, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/', '80.100.210.48'),
(353, 1382489754, 14, 1309, 500, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(354, 1382489754, 13, 5300, 200, 'http://www.miraptor.nl/module/admin/overview', 'http://www.miraptor.nl/module/admin/', '80.100.210.48');
INSERT INTO `log` (`id`, `time`, `runtime`, `bandwidth`, `statuscode`, `request`, `referal`, `ip`) VALUES
(355, 1382489754, 4, 43572, 200, 'http://www.miraptor.nl/_font/fontawesome-webfont.woff', 'http://www.miraptor.nl/module/admin/overview', '80.100.210.48'),
(356, 1382489756, 12, 4788, 200, 'http://www.miraptor.nl/module/admin/settings', 'http://www.miraptor.nl/module/admin/overview', '80.100.210.48'),
(357, 1382489756, 12, 5300, 200, 'http://www.miraptor.nl/module/admin/overview', 'http://www.miraptor.nl/module/admin/settings', '80.100.210.48'),
(358, 1382489757, 10, 5555, 200, 'http://www.miraptor.nl/module/admin/site?id=1', 'http://www.miraptor.nl/module/admin/overview', '80.100.210.48'),
(359, 1382489758, 9, 6697, 200, 'http://www.miraptor.nl/module/admin/site?id=1&module=template', 'http://www.miraptor.nl/module/admin/site?id=1', '80.100.210.48'),
(360, 1382489759, 15, 6491, 200, 'http://www.miraptor.nl/module/admin/site?id=1&module=stylesheet', 'http://www.miraptor.nl/module/admin/site?id=1&module=template', '80.100.210.48'),
(361, 1382489760, 7, 5300, 200, 'http://www.miraptor.nl/module/admin/overview', 'http://www.miraptor.nl/module/admin/site?id=1&module=stylesheet', '80.100.210.48'),
(362, 1382489904, 19, 5300, 200, 'http://www.miraptor.nl/module/admin/overview', 'http://www.miraptor.nl/module/admin/site?id=1&module=stylesheet', '80.100.210.48'),
(363, 1382489905, 10, 754, 304, 'http://www.miraptor.nl/_media/template/logo.png', 'http://www.miraptor.nl/module/admin/overview', '80.100.210.48'),
(364, 1382489905, 7, 754, 304, 'http://www.miraptor.nl/_font/fontawesome-webfont.woff', 'http://www.miraptor.nl/module/admin/overview', '80.100.210.48'),
(365, 1382489907, 11, 5300, 200, 'http://www.miraptor.nl/module/admin/overview', 'http://www.miraptor.nl/module/admin/overview', '80.100.210.48'),
(366, 1382489907, 8, 4788, 200, 'http://www.miraptor.nl/module/admin/settings', 'http://www.miraptor.nl/module/admin/overview', '80.100.210.48'),
(367, 1382489908, 6, 5300, 200, 'http://www.miraptor.nl/module/admin/overview', 'http://www.miraptor.nl/module/admin/settings', '80.100.210.48'),
(368, 1382489908, 6, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/overview', '80.100.210.48'),
(369, 1382489910, 5, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(370, 1382489910, 5, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(371, 1382489910, 6, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/', '80.100.210.48'),
(372, 1382489911, 10, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/', '80.100.210.48'),
(373, 1382489911, 10, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/', '80.100.210.48'),
(374, 1382489911, 10, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/', '80.100.210.48'),
(375, 1382489911, 16, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/', '80.100.210.48'),
(376, 1382489918, 10, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/', '80.100.210.48'),
(377, 1382489919, 10, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(378, 1382489919, 10, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(379, 1382489920, 12, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(380, 1382489921, 6, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(381, 1382489922, 11, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(382, 1382489945, 6, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(383, 1382489946, 6, 1102, 500, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(384, 1382489946, 7, 5300, 200, 'http://www.miraptor.nl/module/admin/overview', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(385, 1382489947, 7, 4788, 200, 'http://www.miraptor.nl/module/admin/settings', 'http://www.miraptor.nl/module/admin/overview', '80.100.210.48'),
(386, 1382489948, 12, 5300, 200, 'http://www.miraptor.nl/module/admin/overview', 'http://www.miraptor.nl/module/admin/settings', '80.100.210.48'),
(387, 1382489948, 10, 4788, 200, 'http://www.miraptor.nl/module/admin/settings', 'http://www.miraptor.nl/module/admin/overview', '80.100.210.48'),
(388, 1382489949, 7, 4926, 200, 'http://www.miraptor.nl/module/admin/settings?edit=password', 'http://www.miraptor.nl/module/admin/settings', '80.100.210.48'),
(389, 1382489950, 7, 4788, 200, 'http://www.miraptor.nl/module/admin/settings', 'http://www.miraptor.nl/module/admin/settings?edit=password', '80.100.210.48'),
(390, 1382489951, 12, 4925, 200, 'http://www.miraptor.nl/module/admin/settings?edit=mail', 'http://www.miraptor.nl/module/admin/settings', '80.100.210.48'),
(391, 1382489951, 13, 4788, 200, 'http://www.miraptor.nl/module/admin/settings', 'http://www.miraptor.nl/module/admin/settings?edit=mail', '80.100.210.48'),
(392, 1382489953, 7, 5300, 200, 'http://www.miraptor.nl/module/admin/overview', 'http://www.miraptor.nl/module/admin/settings', '80.100.210.48'),
(393, 1382489954, 10, 1316, 200, 'http://www.miraptor.nl/?id=1&action=rename', 'http://www.miraptor.nl/module/admin/overview', '80.100.210.48'),
(394, 1382489958, 6, 1316, 200, 'http://www.miraptor.nl/?id=1&action=rename', 'http://www.miraptor.nl/module/admin/overview', '80.100.210.48'),
(395, 1382489961, 10, 1316, 200, 'http://www.miraptor.nl/?id=1&action=domain', 'http://www.miraptor.nl/module/admin/overview', '80.100.210.48'),
(396, 1382490010, 9, 5300, 200, 'http://www.miraptor.nl/module/admin/overview', 'http://www.miraptor.nl/module/admin/settings', '80.100.210.48'),
(397, 1382490010, 4, 754, 304, 'http://www.miraptor.nl/_media/template/logo.png', 'http://www.miraptor.nl/module/admin/overview', '80.100.210.48'),
(398, 1382490010, 5, 754, 304, 'http://www.miraptor.nl/_font/fontawesome-webfont.woff', 'http://www.miraptor.nl/module/admin/overview', '80.100.210.48'),
(399, 1382490010, 11, 4788, 200, 'http://www.miraptor.nl/module/admin/settings', 'http://www.miraptor.nl/module/admin/overview', '80.100.210.48'),
(400, 1382490011, 8, 5300, 200, 'http://www.miraptor.nl/module/admin/overview', 'http://www.miraptor.nl/module/admin/settings', '80.100.210.48'),
(401, 1382490012, 5, 1316, 200, 'http://www.miraptor.nl/?id=1&action=active', 'http://www.miraptor.nl/module/admin/overview', '80.100.210.48'),
(402, 1382490016, 5, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/?id=1&action=active', '80.100.210.48'),
(403, 1382490017, 7, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(404, 1382490018, 7, 1102, 500, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(405, 1382490018, 10, 5300, 200, 'http://www.miraptor.nl/module/admin/overview', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(406, 1382490041, 7, 5555, 200, 'http://www.miraptor.nl/module/admin/site?id=1', 'http://www.miraptor.nl/module/admin/overview', '80.100.210.48'),
(407, 1382490043, 8, 5549, 200, 'http://www.miraptor.nl/module/admin/site?id=1&module=menu', 'http://www.miraptor.nl/module/admin/site?id=1', '80.100.210.48'),
(408, 1382490043, 21, 6697, 200, 'http://www.miraptor.nl/module/admin/site?id=1&module=template', 'http://www.miraptor.nl/module/admin/site?id=1&module=menu', '80.100.210.48'),
(409, 1382490044, 16, 6491, 200, 'http://www.miraptor.nl/module/admin/site?id=1&module=stylesheet', 'http://www.miraptor.nl/module/admin/site?id=1&module=template', '80.100.210.48'),
(410, 1382490044, 20, 5549, 200, 'http://www.miraptor.nl/module/admin/site?id=1&module=news', 'http://www.miraptor.nl/module/admin/site?id=1&module=stylesheet', '80.100.210.48'),
(411, 1382490045, 10, 5550, 200, 'http://www.miraptor.nl/module/admin/site?id=1&module=admin', 'http://www.miraptor.nl/module/admin/site?id=1&module=news', '80.100.210.48'),
(412, 1382490045, 9, 5549, 200, 'http://www.miraptor.nl/module/admin/site?id=1&module=news', 'http://www.miraptor.nl/module/admin/site?id=1&module=admin', '80.100.210.48'),
(413, 1382490046, 9, 5550, 200, 'http://www.miraptor.nl/module/admin/site?id=1&module=media', 'http://www.miraptor.nl/module/admin/site?id=1&module=news', '80.100.210.48'),
(414, 1382490046, 8, 6300, 200, 'http://www.miraptor.nl/module/admin/site?id=1&module=block', 'http://www.miraptor.nl/module/admin/site?id=1&module=media', '80.100.210.48'),
(415, 1382490046, 8, 5549, 200, 'http://www.miraptor.nl/module/admin/site?id=1&module=menu', 'http://www.miraptor.nl/module/admin/site?id=1&module=block', '80.100.210.48'),
(416, 1382490047, 9, 6590, 200, 'http://www.miraptor.nl/module/admin/site?id=1&module=page', 'http://www.miraptor.nl/module/admin/site?id=1&module=menu', '80.100.210.48'),
(417, 1382490048, 8, 5550, 200, 'http://www.miraptor.nl/module/admin/site?id=1&module=admin', 'http://www.miraptor.nl/module/admin/site?id=1&module=page', '80.100.210.48'),
(418, 1382490048, 8, 6041, 200, 'http://www.miraptor.nl/module/admin/site?id=1&module=javascript', 'http://www.miraptor.nl/module/admin/site?id=1&module=admin', '80.100.210.48'),
(419, 1382490048, 14, 5549, 200, 'http://www.miraptor.nl/module/admin/site?id=1&module=news', 'http://www.miraptor.nl/module/admin/site?id=1&module=javascript', '80.100.210.48'),
(420, 1382490049, 25, 5550, 200, 'http://www.miraptor.nl/module/admin/site?id=1&module=media', 'http://www.miraptor.nl/module/admin/site?id=1&module=news', '80.100.210.48'),
(421, 1382490107, 11, 5550, 200, 'http://www.miraptor.nl/module/admin/site?id=1&module=media', 'http://www.miraptor.nl/module/admin/site?id=1&module=news', '80.100.210.48'),
(422, 1382490108, 8, 754, 304, 'http://www.miraptor.nl/_media/template/logo.png', 'http://www.miraptor.nl/module/admin/site?id=1&module=media', '80.100.210.48'),
(423, 1382490115, 10, 1412, 500, 'http://www.miraptor.nl/module/admin/logout', 'http://www.miraptor.nl/module/admin/site?id=1&module=media', '80.100.210.48'),
(424, 1382490115, 11, 4758, 200, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/module/admin/site?id=1&module=media', '80.100.210.48'),
(425, 1382490124, 7, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(426, 1382490213, 10, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(427, 1382490214, 14, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(428, 1382490214, 21, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(429, 1382491370, 6, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(430, 1382515577, 12, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(431, 1382515654, 8, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(432, 1382515654, 6, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(433, 1382515657, 5, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/', '80.100.210.48'),
(434, 1382515657, 5, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(435, 1382515658, 6, 4758, 200, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(436, 1382515658, 4, 387129, 200, 'http://www.miraptor.nl/_media/template/logo.png', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(437, 1382515660, 13, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(438, 1382515660, 10, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(439, 1382515667, 7, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(440, 1382515669, 10, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(441, 1382522157, 10, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(442, 1382522569, 14, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(443, 1382525895, 11, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(444, 1382526126, 9, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(445, 1382526563, 10, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(446, 1382559333, 7, 700, 400, 'http://www.miraptor.nl', NULL, '66.68.159.3'),
(447, 1382567400, 11, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(448, 1382572496, 13, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(449, 1382572497, 10, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(450, 1382572497, 11, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(451, 1382572497, 10, 4758, 200, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(452, 1382572497, 6, 387129, 200, 'http://www.miraptor.nl/_media/template/logo.png', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(453, 1382572502, 6, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(454, 1382575312, 12, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(455, 1382575313, 6, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(456, 1382575314, 5, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(457, 1382575314, 6, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(458, 1382575315, 7, 4758, 200, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(459, 1382575315, 10, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(460, 1382575316, 10, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(461, 1382575317, 10, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(462, 1382582263, 9, 1316, 200, 'http://www.miraptor.nl/', NULL, '54.254.171.82'),
(463, 1382598775, 13, 700, 400, 'http://www.miraptor.nl/', NULL, '196.201.211.130'),
(464, 1382602135, 18, 1316, 200, 'http://test.miraptor.nl/', NULL, '80.100.210.48'),
(465, 1382605274, 13, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(466, 1382605274, 11, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(467, 1382605276, 6, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(468, 1382605277, 6, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(469, 1382605332, 7, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(470, 1382605335, 11, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(471, 1382605342, 22, 4758, 200, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/', '80.100.210.48'),
(472, 1382605352, 16, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(473, 1382605400, 12, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(474, 1382605400, 10, 799, 404, 'http://www.miraptor.nl/f', NULL, '80.100.210.48'),
(475, 1382605452, 10, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(476, 1382605452, 10, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(477, 1382625070, 9, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(478, 1382625320, 16, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(479, 1382625322, 11, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(480, 1382625322, 13, 4758, 200, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(481, 1382625326, 14, 1309, 500, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(482, 1382625326, 13, 5300, 200, 'http://www.miraptor.nl/module/admin/overview', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(483, 1382625327, 8, 43572, 200, 'http://www.miraptor.nl/_font/fontawesome-webfont.woff', 'http://www.miraptor.nl/module/admin/overview', '80.100.210.48'),
(484, 1382625328, 14, 5555, 200, 'http://www.miraptor.nl/module/admin/site?id=1', 'http://www.miraptor.nl/module/admin/overview', '80.100.210.48'),
(485, 1382625329, 8, 6491, 200, 'http://www.miraptor.nl/module/admin/site?id=1&module=stylesheet', 'http://www.miraptor.nl/module/admin/site?id=1', '80.100.210.48'),
(486, 1382625329, 7, 6697, 200, 'http://www.miraptor.nl/module/admin/site?id=1&module=template', 'http://www.miraptor.nl/module/admin/site?id=1&module=stylesheet', '80.100.210.48'),
(487, 1382625329, 8, 6590, 200, 'http://www.miraptor.nl/module/admin/site?id=1&module=page', 'http://www.miraptor.nl/module/admin/site?id=1&module=template', '80.100.210.48'),
(488, 1382625331, 13, 5300, 200, 'http://www.miraptor.nl/module/admin/overview', 'http://www.miraptor.nl/module/admin/site?id=1&module=page', '80.100.210.48'),
(489, 1382625331, 10, 1412, 500, 'http://www.miraptor.nl/module/admin/logout', 'http://www.miraptor.nl/module/admin/overview', '80.100.210.48'),
(490, 1382625331, 12, 4758, 200, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/module/admin/overview', '80.100.210.48'),
(491, 1382787318, 7, 1316, 200, 'http://test.miraptor.nl/', NULL, '80.100.210.48'),
(492, 1382788889, 7, 1316, 200, 'http://test.miraptor.nl/', NULL, '80.100.210.48'),
(493, 1382788889, 4, 64046, 200, 'http://test.miraptor.nl/favicon.ico', 'http://test.miraptor.nl/', '80.100.210.48'),
(494, 1382788890, 13, 1316, 200, 'http://test.miraptor.nl/', NULL, '80.100.210.48'),
(495, 1382788890, 7, 64046, 200, 'http://test.miraptor.nl/favicon.ico', 'http://test.miraptor.nl/', '80.100.210.48'),
(496, 1382791123, 17, 1316, 200, 'http://test.miraptor.nl/', NULL, '80.100.210.48'),
(497, 1382791125, 9, 1316, 200, 'http://test.miraptor.nl/', NULL, '80.100.210.48'),
(498, 1382799115, 8, 1316, 200, 'http://test.miraptor.nl/', NULL, '80.100.210.48'),
(499, 1382814594, 8, 1316, 200, 'http://test.miraptor.nl/', NULL, '80.100.210.48'),
(500, 1382960098, 20, 813, 404, 'http://test.miraptor.nl/module/admin', NULL, '87.210.81.211'),
(501, 1382960103, 11, 4758, 200, 'http://test.miraptor.nl/module/admin/', NULL, '87.210.81.211'),
(502, 1382960111, 17, 4758, 200, 'http://test.miraptor.nl/module/admin/', NULL, '87.210.81.211'),
(503, 1382960121, 17, 1319, 500, 'http://test.miraptor.nl/module/admin/', 'http://test.miraptor.nl/module/admin/', '87.210.81.211'),
(504, 1382960121, 11, 5300, 200, 'http://test.miraptor.nl/module/admin/overview', 'http://test.miraptor.nl/module/admin/', '87.210.81.211'),
(505, 1382978697, 10, 1316, 200, 'http://test.miraptor.nl/', NULL, '87.210.81.211'),
(506, 1382978697, 8, 64046, 200, 'http://test.miraptor.nl/favicon.ico', NULL, '87.210.81.211'),
(507, 1382979390, 9, 1316, 200, 'http://test.miraptor.nl/', NULL, '87.210.81.211'),
(508, 1382979399, 7, 985, 404, 'http://test.miraptor.nl/raptor/', NULL, '87.210.81.211'),
(509, 1382979402, 11, 807, 404, 'http://test.miraptor.nl/raptor', NULL, '87.210.81.211'),
(510, 1383129737, 9, 1316, 200, 'http://test.miraptor.nl/', NULL, '80.100.210.48'),
(511, 1383223411, 9, 1316, 200, 'http://test.miraptor.nl/', NULL, '80.100.210.48'),
(512, 1383228628, 14, 1316, 200, 'http://test.miraptor.nl/', NULL, '80.100.210.48'),
(513, 1383239269, 12, 1316, 200, 'http://test.miraptor.nl/', NULL, '80.100.210.48'),
(514, 1383306345, 9, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(515, 1383306347, 5, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(516, 1383306348, 6, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(517, 1383306349, 8, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(518, 1383306350, 4, 543, 404, 'http://www.miraptor.nl//df', NULL, '80.100.210.48'),
(519, 1383306356, 9, 543, 404, 'http://www.miraptor.nl/df', NULL, '80.100.210.48'),
(520, 1383306358, 6, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(521, 1383306379, 6, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(522, 1383306380, 6, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(523, 1383306382, 8, 543, 404, 'http://www.miraptor.nl/df', NULL, '80.100.210.48'),
(524, 1383306383, 6, 543, 404, 'http://www.miraptor.nl/df', NULL, '80.100.210.48'),
(525, 1383306384, 6, 543, 404, 'http://www.miraptor.nl/df', NULL, '80.100.210.48'),
(526, 1383306387, 6, 800, 404, 'http://www.miraptor.nl/df', NULL, '80.100.210.48'),
(527, 1383306394, 12, 800, 404, 'http://www.miraptor.nl/df', NULL, '80.100.210.48'),
(528, 1383306394, 10, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(529, 1383306395, 6, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(530, 1383306397, 5, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(531, 1383306397, 6, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(532, 1383306398, 7, 800, 404, 'http://www.miraptor.nl/df', NULL, '80.100.210.48'),
(533, 1383306403, 6, 800, 404, 'http://www.miraptor.nl/df', NULL, '80.100.210.48'),
(534, 1383306403, 6, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(535, 1383306404, 6, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(536, 1383306405, 5, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(537, 1383306406, 5, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(538, 1383306408, 8, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(539, 1383306408, 13, 4758, 200, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(540, 1383306408, 5, 387129, 200, 'http://www.miraptor.nl/_media/template/logo.png', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(541, 1383306410, 6, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(542, 1383306791, 10, 1316, 200, 'http://test.miraptor.nl/', NULL, '80.100.210.48'),
(543, 1383307147, 5, 1316, 200, 'http://test.miraptor.nl/', NULL, '80.100.210.48'),
(544, 1383307147, 4, 64046, 200, 'http://test.miraptor.nl/favicon.ico', 'http://test.miraptor.nl/', '80.100.210.48'),
(545, 1383307148, 6, 1316, 200, 'http://test.miraptor.nl/', NULL, '80.100.210.48'),
(546, 1383307149, 5, 1316, 200, 'http://test.miraptor.nl/', NULL, '80.100.210.48'),
(547, 1383307150, 6, 1316, 200, 'http://test.miraptor.nl/', NULL, '80.100.210.48'),
(548, 1383307151, 5, 1316, 200, 'http://test.miraptor.nl/', NULL, '80.100.210.48'),
(549, 1383308577, 10, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(550, 1383308578, 8, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(551, 1383308578, 7, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(552, 1383308579, 10, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(553, 1383308579, 10, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(554, 1383308580, 8, 4758, 200, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(555, 1383308581, 11, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(556, 1383308581, 10, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/', '80.100.210.48'),
(557, 1383308582, 7, 4758, 200, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/', '80.100.210.48'),
(558, 1383308582, 5, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(559, 1383308583, 5, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(560, 1383308583, 6, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(561, 1383308584, 6, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(562, 1383308585, 5, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(563, 1383308585, 5, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(564, 1383308586, 7, 4758, 200, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(565, 1383308592, 8, 1309, 500, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(566, 1383308592, 7, 5300, 200, 'http://www.miraptor.nl/module/admin/overview', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(567, 1383308592, 5, 43572, 200, 'http://www.miraptor.nl/_font/fontawesome-webfont.woff', 'http://www.miraptor.nl/module/admin/overview', '80.100.210.48'),
(568, 1383308594, 7, 4788, 200, 'http://www.miraptor.nl/module/admin/settings', 'http://www.miraptor.nl/module/admin/overview', '80.100.210.48'),
(569, 1383308595, 7, 5300, 200, 'http://www.miraptor.nl/module/admin/overview', 'http://www.miraptor.nl/module/admin/settings', '80.100.210.48'),
(570, 1383308596, 6, 1412, 500, 'http://www.miraptor.nl/module/admin/logout', 'http://www.miraptor.nl/module/admin/overview', '80.100.210.48'),
(571, 1383308596, 7, 4758, 200, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/module/admin/overview', '80.100.210.48'),
(572, 1383315626, 8, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(573, 1383316760, 10, 4758, 200, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/module/admin/overview', '80.100.210.48'),
(574, 1383316760, 6, 754, 304, 'http://www.miraptor.nl/_media/template/logo.png', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(575, 1383316762, 8, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(576, 1383317845, 8, 1291, 500, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(577, 1383317914, 7, 1291, 500, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(578, 1383317916, 14, 1291, 500, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(579, 1383317921, 7, 1291, 500, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(580, 1383318264, 18, 1291, 500, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(581, 1383318265, 7, 1291, 500, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(582, 1383318276, 12, 1316, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(583, 1383318277, 11, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(584, 1383318278, 15, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(585, 1383318278, 16, 4758, 200, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/', '80.100.210.48'),
(586, 1383318282, 9, 1309, 500, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(587, 1383318282, 7, 5300, 200, 'http://www.miraptor.nl/module/admin/overview', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(588, 1383318283, 6, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/overview', '80.100.210.48'),
(589, 1383318284, 10, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/', '80.100.210.48'),
(590, 1383321520, 8, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(591, 1383321521, 6, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(592, 1383321522, 9, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(593, 1383321522, 14, 4758, 200, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(594, 1383321524, 5, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(595, 1383321590, 7, 1094, 500, 'http://www.miraptor.nl/module/admin/overview', NULL, '82.169.10.191'),
(596, 1383321590, 7, 4758, 200, 'http://www.miraptor.nl/module/admin/', NULL, '82.169.10.191'),
(597, 1383321591, 4, 387129, 200, 'http://www.miraptor.nl/_media/template/logo.png', 'http://www.miraptor.nl/module/admin/', '82.169.10.191'),
(598, 1383321592, 4, 64046, 200, 'http://www.miraptor.nl/favicon.ico', NULL, '82.169.10.191'),
(599, 1383321597, 14, 4827, 200, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/module/admin/', '82.169.10.191'),
(600, 1383321611, 8, 1309, 500, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/module/admin/', '82.169.10.191'),
(601, 1383321611, 9, 5300, 200, 'http://www.miraptor.nl/module/admin/overview', 'http://www.miraptor.nl/module/admin/', '82.169.10.191'),
(602, 1383321611, 5, 43572, 200, 'http://www.miraptor.nl/_font/fontawesome-webfont.woff', 'http://www.miraptor.nl/module/admin/', '82.169.10.191'),
(603, 1383321613, 8, 5555, 200, 'http://www.miraptor.nl/module/admin/site?id=1', 'http://www.miraptor.nl/module/admin/overview', '82.169.10.191'),
(604, 1383321615, 10, 6491, 200, 'http://www.miraptor.nl/module/admin/site?id=1&module=stylesheet', 'http://www.miraptor.nl/module/admin/site?id=1', '82.169.10.191'),
(605, 1383321616, 8, 6384, 200, 'http://www.miraptor.nl/module/admin/site?id=1&module=template', 'http://www.miraptor.nl/module/admin/site?id=1&module=stylesheet', '82.169.10.191'),
(606, 1383321617, 8, 5549, 200, 'http://www.miraptor.nl/module/admin/site?id=1&module=menu', 'http://www.miraptor.nl/module/admin/site?id=1&module=template', '82.169.10.191'),
(607, 1383321617, 8, 6384, 200, 'http://www.miraptor.nl/module/admin/site?id=1&module=template', 'http://www.miraptor.nl/module/admin/site?id=1&module=menu', '82.169.10.191'),
(608, 1383321619, 7, 5300, 200, 'http://www.miraptor.nl/module/admin/overview', 'http://www.miraptor.nl/module/admin/site?id=1&module=template', '82.169.10.191'),
(609, 1383321621, 6, 4788, 200, 'http://www.miraptor.nl/module/admin/settings', 'http://www.miraptor.nl/module/admin/overview', '82.169.10.191'),
(610, 1383321622, 14, 5300, 200, 'http://www.miraptor.nl/module/admin/overview', 'http://www.miraptor.nl/module/admin/settings', '82.169.10.191'),
(611, 1383321623, 8, 5555, 200, 'http://www.miraptor.nl/module/admin/site?id=2', 'http://www.miraptor.nl/module/admin/overview', '82.169.10.191'),
(612, 1383321625, 8, 5549, 200, 'http://www.miraptor.nl/module/admin/site?id=2&module=menu', 'http://www.miraptor.nl/module/admin/site?id=2', '82.169.10.191'),
(613, 1383321625, 12, 6384, 200, 'http://www.miraptor.nl/module/admin/site?id=2&module=template', 'http://www.miraptor.nl/module/admin/site?id=2&module=menu', '82.169.10.191'),
(614, 1383321627, 7, 5300, 200, 'http://www.miraptor.nl/module/admin/overview', 'http://www.miraptor.nl/module/admin/site?id=2&module=template', '82.169.10.191'),
(615, 1383321628, 9, 5555, 200, 'http://www.miraptor.nl/module/admin/site?id=1', 'http://www.miraptor.nl/module/admin/overview', '82.169.10.191'),
(616, 1383321629, 9, 6384, 200, 'http://www.miraptor.nl/module/admin/site?id=1&module=template', 'http://www.miraptor.nl/module/admin/site?id=1', '82.169.10.191'),
(617, 1383321633, 8, 6503, 200, 'http://www.miraptor.nl/module/admin/site?id=1&module=template&action=edit&tid=2', 'http://www.miraptor.nl/module/admin/site?id=1&module=template', '82.169.10.191'),
(618, 1383321640, 9, 6300, 200, 'http://www.miraptor.nl/module/admin/site?id=1&module=block', 'http://www.miraptor.nl/module/admin/site?id=1&module=template&action=edit&tid=2', '82.169.10.191'),
(619, 1383321644, 8, 5865, 200, 'http://www.miraptor.nl/module/admin/site?id=1&module=block&action=edit&bid=1', 'http://www.miraptor.nl/module/admin/site?id=1&module=block', '82.169.10.191'),
(620, 1383321646, 7, 6300, 200, 'http://www.miraptor.nl/module/admin/site?id=1&module=block', 'http://www.miraptor.nl/module/admin/site?id=1&module=block&action=edit&bid=1', '82.169.10.191'),
(621, 1383321647, 15, 5550, 200, 'http://www.miraptor.nl/module/admin/site?id=1&module=media', 'http://www.miraptor.nl/module/admin/site?id=1&module=block', '82.169.10.191'),
(622, 1383321648, 16, 5549, 200, 'http://www.miraptor.nl/module/admin/site?id=1&module=news', 'http://www.miraptor.nl/module/admin/site?id=1&module=media', '82.169.10.191'),
(623, 1383321648, 16, 5549, 200, 'http://www.miraptor.nl/module/admin/site?id=1&module=news', 'http://www.miraptor.nl/module/admin/site?id=1&module=news', '82.169.10.191'),
(624, 1383321649, 14, 5555, 200, 'http://www.miraptor.nl/module/admin/site?id=1&module=breadcrumb', 'http://www.miraptor.nl/module/admin/site?id=1&module=news', '82.169.10.191'),
(625, 1383321650, 8, 5550, 200, 'http://www.miraptor.nl/module/admin/site?id=1&module=admin', 'http://www.miraptor.nl/module/admin/site?id=1&module=breadcrumb', '82.169.10.191'),
(626, 1383321651, 8, 6035, 200, 'http://www.miraptor.nl/module/admin/site?id=1&module=javascript', 'http://www.miraptor.nl/module/admin/site?id=1&module=admin', '82.169.10.191'),
(627, 1383321652, 9, 5875, 200, 'http://www.miraptor.nl/module/admin/site?id=1&module=javascript&action=edit&sid=1', 'http://www.miraptor.nl/module/admin/site?id=1&module=javascript', '82.169.10.191'),
(628, 1383321657, 10, 1816, 500, 'http://www.miraptor.nl/module/admin/site?id=1&module=page', 'http://www.miraptor.nl/module/admin/site?id=1&module=javascript&action=edit&sid=1', '82.169.10.191'),
(629, 1383321828, 7, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(630, 1383322074, 7, 700, 400, 'http://www.miraptor.nl', NULL, '66.206.59.42'),
(631, 1383322480, 5, 1275, 500, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(632, 1383322481, 5, 1275, 500, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(633, 1383322537, 96, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(634, 1383322541, 9, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(635, 1383322542, 7, 4758, 200, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(636, 1383322543, 8, 1316, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(637, 1383325147, 10, 2285, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(638, 1383325755, 9, 2285, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(639, 1383325780, 16, 2299, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(640, 1383325821, 6, 1330, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(641, 1383325844, 6, 1346, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(642, 1383325858, 6, 1330, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(643, 1383325871, 8, 1330, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(644, 1383325887, 11, 1329, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(645, 1383325887, 7, 1329, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(646, 1383342303, 8, 1314, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(647, 1383342349, 7, 1314, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(648, 1383358101, 7, 1314, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(649, 1383358634, 9, 1314, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(650, 1383358637, 12, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(651, 1383358637, 11, 1314, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(652, 1383358638, 9, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(653, 1383358638, 7, 4758, 200, 'http://www.miraptor.nl/module/admin/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(654, 1383358638, 5, 387129, 200, 'http://www.miraptor.nl/_media/template/logo.png', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(655, 1383358640, 11, 1314, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(656, 1383367636, 7, 700, 400, 'http://www.miraptor.nl', NULL, '50.198.58.77'),
(657, 1383379631, 7, 1314, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/admin/', '80.100.210.48'),
(658, 1383379632, 6, 1295, 200, 'http://www.miraptor.nl/module/', 'http://www.miraptor.nl/', '80.100.210.48'),
(659, 1383379633, 6, 1314, 200, 'http://www.miraptor.nl/', 'http://www.miraptor.nl/module/', '80.100.210.48'),
(660, 1383379708, 16, 1314, 200, 'http://www.miraptor.nl/', NULL, '80.100.210.48'),
(661, 1383379709, 11, 809, 404, 'http://www.miraptor.nl/sitemap.xml', NULL, '80.100.210.48');

-- --------------------------------------------------------

--
-- Table structure for table `module_admin`
--

CREATE TABLE IF NOT EXISTS `module_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_access` int(11) NOT NULL,
  `id_group` int(11) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_access` (`id_access`),
  KEY `id_group` (`id_group`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Dumping data for table `module_admin`
--

INSERT INTO `module_admin` (`id`, `id_access`, `id_group`, `enabled`) VALUES
(1, 1, 2, 1),
(2, 2, 2, 1),
(3, 3, 2, 1),
(4, 4, 2, 1),
(5, 5, 1, 1),
(6, 6, 1, 1),
(7, 7, 1, 1),
(8, 8, 1, 1),
(9, 9, 1, 1),
(10, 10, 1, 1),
(11, 11, 1, 0),
(12, 12, 1, 1),
(13, 13, 1, 1),
(14, 14, 1, 0),
(15, 15, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `module_admin_group`
--

CREATE TABLE IF NOT EXISTS `module_admin_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `module_admin_group`
--

INSERT INTO `module_admin_group` (`id`, `name`) VALUES
(1, 'Editor'),
(2, 'Developer');

-- --------------------------------------------------------

--
-- Table structure for table `module_block`
--

CREATE TABLE IF NOT EXISTS `module_block` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_group` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_group` (`id_group`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `module_block`
--

INSERT INTO `module_block` (`id`, `id_group`, `name`, `content`) VALUES
(1, 1, 'sitename', 'miRaptor'),
(2, 1, 'metadata', '<base href="http://www.miraptor.nl" />\r\n<meta charset="utf-8" />\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `module_javascript`
--

CREATE TABLE IF NOT EXISTS `module_javascript` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_group` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_group` (`id_group`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `module_javascript`
--

INSERT INTO `module_javascript` (`id`, `id_group`, `name`, `content`) VALUES
(1, 1, 'Test', '/* Javascript test */');

-- --------------------------------------------------------

--
-- Table structure for table `module_page`
--

CREATE TABLE IF NOT EXISTS `module_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_router` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_router` (`id_router`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `module_page`
--

INSERT INTO `module_page` (`id`, `id_router`, `description`, `content`) VALUES
(1, 1, 'Description', '<p>This will work now too</p>'),
(2, 2, 'Description', '<p>Modules</p>');

-- --------------------------------------------------------

--
-- Table structure for table `module_stylesheet`
--

CREATE TABLE IF NOT EXISTS `module_stylesheet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `module_stylesheet`
--

INSERT INTO `module_stylesheet` (`id`, `group_id`, `name`, `content`) VALUES
(1, 1, 'Admin main', '@font-face\r\n{\r\n	font-family: ''FontAwesome'';\r\n	font-style: normal;\r\n	font-weight: normal;\r\n	src:	url(''_font/fontawesome-webfont.eot?'') format(''eot''),\r\n		url(''_font/fontawesome-webfont.woff'') format(''woff''),\r\n		url(''_font/fontawesome-webfont.ttf'') format(''truetype''),\r\n		url(''_font/fontawesome-webfont.svg'') format(''svg'');\r\n}\r\n\r\nhtml, body\r\n{\r\n	padding: 0;\r\n	width: 100%;\r\n	height: 100%;\r\n}\r\n\r\nhtml\r\n{\r\n	margin: 25px;\r\n}\r\n\r\nbody\r\n{\r\n	margin: 0;\r\n	font-family: ''Tahoma'', sans-serif;\r\n	font-size: 14px;\r\n	background: white;\r\n}\r\n\r\na\r\n{\r\n	color: #06f;\r\n	text-decoration: none;\r\n}\r\n\r\nh1, h2, h3, h4, h5, h6, h7\r\n{\r\n	margin-top: 0;\r\n	font-weight: normal;\r\n	letter-spacing: 1px;\r\n}\r\n\r\nimg\r\n{\r\n	display: block;\r\n	border: none;\r\n}\r\n\r\np, ul\r\n{\r\n	margin: 0 0 20px;\r\n	line-height: 20px;\r\n}\r\n\r\nul\r\n{\r\n	list-style-type: square;\r\n}\r\n'),
(2, 1, 'Main', '@font-face\r\n{\r\n	font-family: ''FontAwesome'';\r\n	font-style: normal;\r\n	font-weight: normal;\r\n	src:	url(''_font/fontawesome-webfont.eot?'') format(''eot''),\r\n		url(''_font/fontawesome-webfont.woff'') format(''woff''),\r\n		url(''_font/fontawesome-webfont.ttf'') format(''truetype''),\r\n		url(''_font/fontawesome-webfont.svg'') format(''svg'');\r\n}\r\n\r\nhtml, body\r\n{\r\n	margin: 0;\r\n	padding: 0;\r\n	width: 100%;\r\n	height: 100%;\r\n}\r\n\r\nbody\r\n{\r\n	font-family: ''Tahoma'', sans-serif;\r\n	font-size: 14px;\r\n	background: white;\r\n}\r\n\r\na\r\n{\r\n	color: #06f;\r\n	text-decoration: none;\r\n}\r\n\r\nh1, h2, h3, h4, h5, h6, h7\r\n{\r\n	margin-top: 0;\r\n	font-weight: normal;\r\n	letter-spacing: 1px;\r\n}\r\n\r\nimg\r\n{\r\n	display: block;\r\n	border: none;\r\n}\r\n\r\np, ul\r\n{\r\n	margin: 0 0 20px;\r\n	line-height: 20px;\r\n}\r\n\r\nul\r\n{\r\n	list-style-type: square;\r\n}\r\n\r\nnav > ul\r\n{\r\n	margin: 0;\r\n	padding: 0;\r\n}\r\n\r\n#template\r\n{\r\n	width: 100%;\r\n	height: 100%;\r\n}\r\n\r\nheader\r\n{\r\n	position: relative;\r\n	width: 100%;\r\n	height: 100px;\r\n	border-bottom: 1px solid #bcbcbc;\r\n	background-color: #fff;\r\n	z-index: 10;\r\n}\r\n\r\nheader h1\r\n{\r\n	margin: 0;\r\n	padding: 0 0 0 85px;\r\n	height: 100px;\r\n	background: transparent url(''_media/template/logo.png'') no-repeat 0 50%;\r\n	color: #06f;\r\n	font-size: 18px;\r\n	line-height: 100px;\r\n}\r\n\r\nheader h1 span\r\n{\r\n	color: #333;\r\n	font-size: 14px;\r\n}\r\n\r\n#logbox\r\n{\r\n	position: absolute;\r\n	top: 0;\r\n	right: 0;\r\n}\r\n\r\n#logbox ul\r\n{\r\n	list-style-type: none;\r\n}\r\n\r\n#logbox li\r\n{\r\n	float: left;\r\n	border-left: 1px solid #bcbcbc;\r\n	width: 100px;\r\n}\r\n\r\n#logbox a\r\n{\r\n	display: block;\r\n	line-height: 100px;\r\n	width: 100%;\r\n	text-align: center;\r\n}\r\n\r\n#body\r\n{\r\n	position: absolute;\r\n	top: 0;\r\n	width: 100%;\r\n	height: 100%;\r\n}\r\n\r\n#menu\r\n{\r\n	float: left;\r\n	border-right: 1px solid #bcbcbc;\r\n	width: 230px;\r\n	height: 100%;\r\n	background: #e6e6e6;\r\n}\r\n\r\n#menu nav\r\n{\r\n	padding: 120px 30px 20px;\r\n}\r\n\r\n#menu ul\r\n{\r\n	padding-left: 20px;\r\n}\r\n\r\n#content\r\n{\r\n	padding: 120px 30px 20px 260px;\r\n}\r\n\r\n.error\r\n{\r\n	color: #ca3c3c;\r\n}\r\n\r\n.progressbar\r\n{\r\n	position: relative;\r\n	z-index: 2;\r\n	border: 1px solid #666;\r\n	width: 100%;\r\n	height: 16px;\r\n	overflow: hidden;\r\n	color: #333;\r\n	font: normal normal 0.9em Tahoma, sans-serif;\r\n	line-height: 16px;\r\n	text-align: center;\r\n}\r\n\r\n.progress\r\n{\r\n	position: absolute;\r\n	top: 0;\r\n	left: 0;\r\n	z-index: -1;\r\n	background: #cc33cc url(''../graphics/progressbar.png'') repeat-x 0 0;\r\n	height: 100%;\r\n}\r\n\r\nform\r\n{\r\n	margin: 0 -5px;\r\n}\r\n\r\nform > div\r\n{\r\n	margin: 0 0 15px;\r\n}\r\n\r\nform label,\r\nform button,\r\nform input,\r\nform select,\r\nform textarea\r\n{\r\n	margin: 5px;\r\n	border-radius: 2px;\r\n}\r\n\r\nform label\r\n{\r\n	display: block;\r\n}\r\n\r\nform label:after\r\n{\r\n	content: ":";\r\n}\r\n\r\nform button\r\n{\r\n	border: none;\r\n	padding: 5px 20px;\r\n	background: #e6e6e6;\r\n	font-size: 90%;\r\n}\r\n\r\nform button:hover,\r\nform button:active\r\n{\r\n	color: white;\r\n	background: #06f;\r\n}\r\n\r\nform button:active\r\n{\r\n	box-shadow: 0 0 0 1px rgba(0,0,0,.15) inset, 0 0 6px rgba(0,0,0,.2) inset;\r\n}\r\n\r\nform input,\r\nform text-area\r\n{\r\n	display: block;\r\n	border: 1px solid #ccc;\r\n	padding: 4px;\r\n	max-width: 100%;\r\n	box-shadow: rgb(221, 221, 221) 0px 1px 3px 0px inset;\r\n}\r\n\r\nform input[type=text],\r\nform input[type=password]\r\n{\r\n	width: 200px;\r\n}\r\ntable\r\n{\r\n	border: 1px solid #bcbcbc;\r\n	border-collapse: collapse;\r\n}\r\n\r\ntable th,\r\ntable td\r\n{\r\n	border-right: 1px solid #bcbcbc;\r\n	padding: 5px 20px;\r\n	text-align: left;\r\n}\r\n\r\ntable th\r\n{\r\n	background: #e6e6e6;\r\n}\r\n\r\ntable tr:hover\r\n{\r\n	background: #f2f2f2;\r\n}\r\n\r\ntable a\r\n{\r\n	display: inline-block;\r\n}\r\n\r\ntable .rename:before\r\n{\r\n	content: "\\f044";\r\n	font-family: ''FontAwesome'';\r\n}\r\n\r\ntable .domain:before\r\n{\r\n	content: "\\f14e";\r\n	font-family: ''FontAwesome'';\r\n}\r\n\r\ntable .active-0:before,\r\ntable .active-1:before\r\n{\r\n	content: "\\f011";\r\n	font-family: ''FontAwesome'';\r\n}\r\n\r\ntable .active-0:before\r\n{\r\n	color: #ca3c3c;\r\n}\r\n\r\ntable .active-1:before\r\n{\r\n	color: #1cb841;\r\n}\r\n	');

-- --------------------------------------------------------

--
-- Table structure for table `router`
--

CREATE TABLE IF NOT EXISTS `router` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `index` int(11) NOT NULL,
  `root` tinyint(1) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `uri` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_template` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `namespace` (`uri`),
  KEY `id_template` (`id_template`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `router`
--

INSERT INTO `router` (`id`, `pid`, `index`, `root`, `name`, `uri`, `id_template`) VALUES
(1, 0, 0, 1, 'Overview', '/', 1),
(2, 0, 1, 0, 'Module', '/module/', 1),
(3, 2, 0, 0, 'Admin', '/module/admin/', 2);

-- --------------------------------------------------------

--
-- Table structure for table `template`
--

CREATE TABLE IF NOT EXISTS `template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_group` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_group` (`id_group`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `template`
--

INSERT INTO `template` (`id`, `id_group`, `name`, `content`) VALUES
(1, 1, 'Main', '<!doctype>\r\n<html>\r\n	<head>\r\n		<title><!--{block get="sitename"}--> | <!--{page get="title"}--></title>\r\n\r\n<!--{block get="metadata"}-->\r\n\r\n<!--{stylesheet id="1"}-->\r\n	</head>\r\n	<body>\r\n		<div>\r\n			<h1><!--{block get="sitename"}--></h1>\r\n\r\n<!--{menu}-->\r\n\r\n			<h2><!--{page get="title"}--></h2>\r\n\r\n<!--{page get="content"}-->\r\n\r\n		</div>\r\n	</body>\r\n</html>'),
(2, 1, 'Admin', '<!doctype html>\r\n\r\n<html lang="en">\r\n\r\n	<head>\r\n\r\n		<title><!--{block get="sitename"}--></title>\r\n\r\n<!--{block get="metadata"}-->\r\n\r\n<!--{stylesheet id="2"}-->\r\n\r\n	</head>\r\n\r\n	<body>\r\n\r\n		<div id="template">\r\n\r\n			<header>\r\n\r\n				<div id="logo">\r\n\r\n					<h1><a href="/">miRaptor<span> admin</span></a></h1>\r\n\r\n				</div>\r\n\r\n				<nav id="logbox">\r\n\r\n<!--{admin get="logbox"}-->\r\n\r\n				</nav>\r\n\r\n			</header>\r\n\r\n			<div id="body">\r\n\r\n				<div id="menu">\r\n\r\n					<nav>\r\n\r\n<!--{admin get="menu"}-->\r\n\r\n					</nav>\r\n\r\n				</div>\r\n\r\n				<div id="content">\r\n\r\n<!--{admin get="content"}-->\r\n\r\n				</div>\r\n\r\n			</div>\r\n\r\n		</div>\r\n\r\n	</body>\r\n\r\n</html>');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `module_admin`
--
ALTER TABLE `module_admin`
  ADD CONSTRAINT `module_admin_ibfk_1` FOREIGN KEY (`id_access`) REFERENCES `access` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `module_admin_ibfk_2` FOREIGN KEY (`id_group`) REFERENCES `module_admin_group` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `module_block`
--
ALTER TABLE `module_block`
  ADD CONSTRAINT `module_block_ibfk_1` FOREIGN KEY (`id_group`) REFERENCES `group` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `module_javascript`
--
ALTER TABLE `module_javascript`
  ADD CONSTRAINT `module_javascript_ibfk_1` FOREIGN KEY (`id_group`) REFERENCES `group` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `module_page`
--
ALTER TABLE `module_page`
  ADD CONSTRAINT `module_page_ibfk_1` FOREIGN KEY (`id_router`) REFERENCES `router` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `module_stylesheet`
--
ALTER TABLE `module_stylesheet`
  ADD CONSTRAINT `module_stylesheet_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `router`
--
ALTER TABLE `router`
  ADD CONSTRAINT `router_ibfk_1` FOREIGN KEY (`id_template`) REFERENCES `template` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `template`
--
ALTER TABLE `template`
  ADD CONSTRAINT `template_ibfk_1` FOREIGN KEY (`id_group`) REFERENCES `group` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
