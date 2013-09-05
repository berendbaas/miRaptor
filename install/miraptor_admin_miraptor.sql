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
-- Database: `miraptor_admin_miraptor`
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
  `statuscode` int(11) NOT NULL,
  `request` varchar(2048) NOT NULL,
  `referal` varchar(2048) DEFAULT NULL,
  `ip` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `name`) VALUES
(1, 'page'),
(2, 'menu'),
(3, 'template'),
(4, 'stylesheet'),
(5, 'site'),
(6, 'media'),
(7, 'news'),
(8, 'breadcrumb');

-- --------------------------------------------------------

--
-- Table structure for table `module_page_content`
--

CREATE TABLE IF NOT EXISTS `module_page_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `nid` int(11) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `nid` (`nid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `module_page_content_name`
--

CREATE TABLE IF NOT EXISTS `module_page_content_name` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `module_page_media`
--

CREATE TABLE IF NOT EXISTS `module_page_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `nid` int(11) NOT NULL,
  `url` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `nid` (`nid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `module_page_media_name`
--

CREATE TABLE IF NOT EXISTS `module_page_media_name` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `module_site`
--

CREATE TABLE IF NOT EXISTS `module_site` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `module_site`
--

INSERT INTO `module_site` (`id`, `name`, `content`) VALUES
(1, 'sitename', 'docs.miRaptor'),
(2, 'metadata', '<base href="http://www.miraptor.nl" />\r\n<meta charset="utf-8" />');

-- --------------------------------------------------------

--
-- Table structure for table `module_stylesheet`
--

CREATE TABLE IF NOT EXISTS `module_stylesheet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `module_stylesheet`
--

INSERT INTO `module_stylesheet` (`id`, `name`, `content`) VALUES
(1, 'Main', '@import url(http://fonts.googleapis.com/css?family=Droid+Sans:400,700);\r\n\r\nhtml, body\r\n{\r\n	margin: 10px 15px;\r\n	padding: 0;\r\n}\r\n\r\nbody\r\n{\r\n	font-family: ''Droid Sans'', sans-serif;\r\n}\r\n\r\na\r\n{\r\n	color: #4183c4;\r\n	text-decoration: none;\r\n}\r\n\r\na:hover\r\n{\r\n	text-decoration: underline;\r\n}\r\n\r\nh1, h2, h3, h4, h5, h6, h7\r\n{\r\n	margin-bottom: 0;\r\n}\r\n\r\nh2\r\n{\r\n	color: #325d72;\r\n}\r\n\r\nul\r\n{\r\n	padding-left: 20px;\r\n	list-style-type: square;\r\n}');

-- --------------------------------------------------------

--
-- Table structure for table `module_stylesheet_template`
--

CREATE TABLE IF NOT EXISTS `module_stylesheet_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sid` (`sid`),
  KEY `tid` (`tid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `module_stylesheet_template`
--

INSERT INTO `module_stylesheet_template` (`id`, `sid`, `tid`, `order`) VALUES
(1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `module_template`
--

CREATE TABLE IF NOT EXISTS `module_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `gid` (`gid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `module_template`
--

INSERT INTO `module_template` (`id`, `gid`, `name`, `content`) VALUES
(1, 1, 'Main', '<!doctype>\r\n<html>\r\n	<head>\r\n		<title><!--{site get="sitename"}--> | <!--{page get="title"}--></title>\r\n\r\n<!--{site get="metadata"}-->\r\n\r\n<!--{stylesheet}-->\r\n	</head>\r\n	<body>\r\n		<div>\r\n			<h1><!--{site get="sitename"}--></h1>\r\n\r\n<!--{menu}-->\r\n\r\n			<h2><!--{page get="title"}--></h2>\r\n\r\n<!--{page get="content"}-->\r\n\r\n		</div>\r\n	</body>\r\n</html>');

-- --------------------------------------------------------

--
-- Table structure for table `module_template_group`
--

CREATE TABLE IF NOT EXISTS `module_template_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `module_template_group`
--

INSERT INTO `module_template_group` (`id`, `name`) VALUES
(1, 'miRaptor');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `default` tinyint(1) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `url` varchar(767) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`),
  KEY `tid` (`tid`),
  KEY `mid` (`mid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `pid`, `mid`, `tid`, `order`, `default`, `name`, `description`, `content`, `url`) VALUES
(1, 0, 1, 1, 0, 0, 'Overview', '', '<p>Welcome on the documentation pages of miRaptor.</p>', '/'),
(2, 0, 1, 1, 0, 1, 'Modules', '', '<p>This is the testing page for every module.</p>', '/modules/'),
(3, 2, 1, 1, 0, 0, 'Page', 'Page description', '<h3>&lt;!--{page get="title"}--&gt;</h3>\r\n<p><!--{page get="title"}--></p>\r\n<h3>&lt;!--{page get="description"}--&gt;</h3>\r\n<p><!--{page get="description"}--></p>\r\n<h3>&lt;!--{page get="content"}--&gt;</h3>\r\n<p>If you see this the module is working!</p>', '/modules/page/'),
(4, 2, 1, 1, 1, 0, 'Menu', '', '<h3>&lt;!--{menu}--&gt;</h3>\r\n<!--{menu}-->', '/modules/menu/'),
(5, 2, 1, 1, 2, 0, 'Template', '', '<h3>&lt;!--{template}--&gt;</h3>\r\n<p>If you can see this text the template module is working!</p>', '/modules/template/'),
(6, 2, 1, 1, 3, 0, 'Stylesheet', '', '<h3>&lt;!--{stylesheet}--&gt;</h3>\r\n<p>Check if there is a stylesheet is in the html head tag.</p>', '/modules/stylesheet/'),
(7, 2, 1, 1, 4, 0, 'Site', '', '<h3>&lt;!--{site get="sitename"}--&gt;</h3>\r\n<p><!--{site get="sitename"}--></p>', '/modules/site/'),
(8, 2, 1, 1, 6, 0, 'News', '', '<!--{news}-->', '/modules/news/'),
(9, 2, 1, 1, 7, 0, 'Breadcrumb', '', '<h3>&lt;!--{breadcrumb}--&gt;</h3>\r\n<!--{breadcrumb}-->', '/modules/breadcrumb/');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `module_page_content`
--
ALTER TABLE `module_page_content`
  ADD CONSTRAINT `module_page_content_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `pages` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `module_page_content_ibfk_2` FOREIGN KEY (`nid`) REFERENCES `module_page_content_name` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `module_page_media`
--
ALTER TABLE `module_page_media`
  ADD CONSTRAINT `module_page_media_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `pages` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `module_page_media_ibfk_2` FOREIGN KEY (`nid`) REFERENCES `module_page_media_name` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `module_stylesheet_template`
--
ALTER TABLE `module_stylesheet_template`
  ADD CONSTRAINT `module_stylesheet_template_ibfk_1` FOREIGN KEY (`sid`) REFERENCES `module_stylesheet` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `module_stylesheet_template_ibfk_2` FOREIGN KEY (`tid`) REFERENCES `module_template` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `module_template`
--
ALTER TABLE `module_template`
  ADD CONSTRAINT `module_template_ibfk_1` FOREIGN KEY (`gid`) REFERENCES `module_template_group` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `pages_ibfk_1` FOREIGN KEY (`tid`) REFERENCES `module_template` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `pages_ibfk_2` FOREIGN KEY (`mid`) REFERENCES `modules` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
