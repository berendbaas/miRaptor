-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 05, 2013 at 12:14 PM
-- Server version: 5.5.31
-- PHP Version: 5.4.17RC1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `miraptor_cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `host`
--

CREATE TABLE IF NOT EXISTS `host` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wid` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `domain` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `host`
--

INSERT INTO `host` (`id`, `wid`, `path`, `domain`) VALUES
(1, 2, '', 'miraptor.nl');

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
  `request` varchar(2048) NOT NULL,
  `referal` varchar(2048) DEFAULT NULL,
  `ip` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `location`, `username`, `password`, `email`, `name`) VALUES
(1, '/admin', 'admin', 'password', 'info@miraptor.nl', 'miRaptor Admin');

-- --------------------------------------------------------

--
-- Table structure for table `website`
--

CREATE TABLE IF NOT EXISTS `website` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `domain` varchar(255) NOT NULL,
  `db` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `website`
--

INSERT INTO `website` (`id`, `uid`, `name`, `domain`, `db`, `location`, `active`) VALUES
(1, 1, 'miRaptor Admin', 'admin.miraptor.nl', 'miraptor_admin_admin', '/admin', 1),
(2, 1, 'miRaptor', 'www.miraptor.nl', 'miraptor_admin_miraptor', '/miraptor', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
