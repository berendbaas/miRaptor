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
-- Database: `miraptor_admin_admin`
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

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
(8, 'breadcrumb'),
(9, 'admin');

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
(1, 'sitename', 'miRaptor Admin'),
(2, 'metadata', '<base href="http://admin.miraptor.nl/" />\r\n<meta charset="utf-8" />');

-- --------------------------------------------------------

--
-- Table structure for table `module_stylesheet`
--

CREATE TABLE IF NOT EXISTS `module_stylesheet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `module_stylesheet`
--

INSERT INTO `module_stylesheet` (`id`, `name`, `content`) VALUES
(1, 'Main', 'html, body\r\n{\r\n	margin: 0;\r\n	padding: 0;\r\n	height: 100%;\r\n	background-color: white;\r\n}\r\n\r\ndiv#content\r\n{\r\n	margin: 0 0 0 231px;\r\n	padding: 10px;\r\n}\r\n\r\nbody > div\r\n{\r\n	min-height: 100%;\r\n	height: auto !important;\r\n	margin: 0 0 -31px;\r\n}\r\n\r\nheader\r\n{\r\n	height: 100px;\r\n	border-bottom: 1px solid #bcbcbc;\r\n	background-color: #fff;\r\n}\r\n\r\nheader > div\r\n{\r\n	float: right;\r\n	height: 100px;\r\n	border-left: 1px solid #bcbcbc;\r\n	position: relative;\r\n	width: 100px;\r\n}\r\n\r\nheader > div > a\r\n{\r\n	display: block;\r\n	font: normal normal 0.8em Tahoma, sans-serif;\r\n	color: #06f;\r\n	line-height: 100px;\r\n	width: 100%;\r\n	text-align: center;\r\n}\r\n\r\nheader h1\r\n{\r\n	height: 100px;\r\n	background: transparent url(''_media/template/logo.png'') no-repeat 0 50%;\r\n	padding: 0 0 0 85px;\r\n	font: normal normal 1em Tahoma, sans-serif;\r\n	color: #06f;\r\n	line-height: 100px;\r\n	letter-spacing: 1px;\r\n	margin: 0;\r\n}\r\n\r\nheader > h1 span\r\n{\r\n	font: normal normal 0.8em Tahoma, sans-serif;\r\n	color: #333;\r\n}'),
(2, 'Menu', 'body\r\n{\r\n	background: transparent url(''_media/template/bg.png'') repeat-y 0 0;\r\n}\r\n\r\ndiv#menu\r\n{\r\n	float: left;\r\n	padding: 0 0 25px 0;\r\n	width: 230px;\r\n	height: 100%;\r\n}\r\n\r\ndiv#menu > div\r\n{\r\n	overflow: hidden;\r\n	border-bottom: 1px solid #bcbcbc;\r\n	padding: 10px;\r\n}\r\n\r\ndiv#menu > div > h2\r\n{\r\n	float: left;\r\n	margin: 0 0 0 5px;\r\n	font-size: 1em;\r\n	width: 125px;\r\n	word-wrap: break-word;\r\n}\r\n\r\ndiv#menu > div > a\r\n{\r\n	float: right;\r\n	height: 20px;\r\n	margin: 0 10px 0 0;\r\n}\r\n\r\ndiv#menu > div img\r\n{\r\n	vertical-align: middle;\r\n}\r\n\r\ndiv#menu ul\r\n{\r\n	margin: 0 0 0 25px;\r\n	padding: 0;\r\n	list-style: none;\r\n	font-size: 0.9em;\r\n}\r\n\r\ndiv#menu > ul\r\n{\r\n	margin-top: 10px;\r\n}\r\n\r\ndiv#menu > ul ul\r\n{\r\n	list-style-type: square;\r\n}\r\n\r\ndiv#menu > ul ul li\r\n{\r\n	color: #666;\r\n}\r\n\r\ndiv#menu span.nocolor\r\n{\r\n	color: #333;\r\n}\r\n\r\ndiv#menu > ul ul li:hover\r\n{\r\n	color: #06f;\r\n}\r\n\r\ndiv#menu a\r\n{\r\n	font: normal normal 1em Tahoma, sans-serif;\r\n	color: #06f;\r\n	text-decoration: none;\r\n}\r\n\r\ndiv#menu a:hover\r\n{\r\n	color: #666;\r\n	text-decoration: underline;\r\n}\r\n\r\ndiv#menu li\r\n{\r\n	font: normal normal 1em Tahoma, sans-serif;\r\n	color: #333;\r\n	margin: 5px 0 5px 0;\r\n}\r\n\r\ndiv#menu span.sitename\r\n{\r\n	font-size: 1.1em;\r\n	line-height: 1.1em;\r\n}'),
(3, 'Content', 'abbr\r\n{\r\n	border-bottom: 1px dashed #666;\r\n}\r\n'),
(4, 'Form', 'form\r\n{\r\n	margin: 25px 0 5px 15px;\r\n}\r\n\r\nform > label\r\n{\r\n	width: 350px;\r\n	display: block;\r\n	font: normal normal 1em Tahoma, sans-serif;\r\n	color: #333;\r\n	margin: 15px 0 15px 0;\r\n}\r\n\r\nform > label input\r\n{\r\n	float: right;\r\n	width: 225px;\r\n}\r\n\r\nform > label img\r\n{\r\n	vertical-align: top;\r\n	margin-left: -5px;\r\n	padding: 0 0 0 0;\r\n}\r\n\r\nform > input\r\n{\r\n	margin: 25px 0 0 0;\r\n}'),
(5, 'Progressbar', '.progressbar\r\n{\r\n	position: relative;\r\n	z-index: 2;\r\n	border: 1px solid #666;\r\n	width: 100%;\r\n	height: 16px;\r\n	overflow: hidden;\r\n	color: #333;\r\n	font: normal normal 0.9em Tahoma, sans-serif;\r\n	line-height: 16px;\r\n	text-align: center;\r\n}\r\n\r\n.progress\r\n{\r\n	position: absolute;\r\n	top: 0;\r\n	left: 0;\r\n	z-index: -1;\r\n	background: #cc33cc url(''../graphics/progressbar.png'') repeat-x 0 0;\r\n	height: 100%;\r\n}\r\n\r\n');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `module_stylesheet_template`
--

INSERT INTO `module_stylesheet_template` (`id`, `sid`, `tid`, `order`) VALUES
(1, 1, 1, 0),
(2, 2, 1, 1),
(3, 3, 1, 2),
(4, 4, 1, 3),
(5, 5, 1, 4),
(6, 1, 2, 0),
(7, 2, 2, 1),
(8, 3, 2, 2),
(9, 4, 2, 3),
(10, 5, 2, 4),
(11, 1, 3, 0),
(12, 2, 3, 1),
(13, 3, 3, 2),
(14, 4, 3, 2),
(15, 5, 3, 4);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `module_template`
--

INSERT INTO `module_template` (`id`, `gid`, `name`, `content`) VALUES
(1, 1, 'Login', '<!doctype html>\r\n\r\n<html lang=''en''>\r\n\r\n	<head>\r\n\r\n		<title><!--{site get="sitename"}--> | <!--{page get="title"}--></title>\r\n\r\n<!--{site get="metadata"}-->\r\n\r\n<!--{stylesheet}-->\r\n\r\n	</head>\r\n\r\n	<body>\r\n\r\n		<div>\r\n\r\n			<header>\r\n\r\n				<h1>miRaptor<span>admin</span></h1>\r\n\r\n			</header>\r\n\r\n			<div id=''content''>\r\n\r\n<!--{page get="content"}-->\r\n\r\n			</div>\r\n\r\n		</div>\r\n\r\n	</body>\r\n\r\n</html>\r\n'),
(2, 1, 'Overview', '<!doctype html>\r\n\r\n<html lang=''en''>\r\n\r\n	<head>\r\n\r\n		<title><!--{site get="sitename"}--> | <!--{page get="title"}--></title>\r\n\r\n<!--{site get="metadata"}-->\r\n\r\n<!--{stylesheet}-->\r\n\r\n	</head>\r\n\r\n	<body>\r\n\r\n		<div>\r\n\r\n			<header>\r\n\r\n				<div id=''logbox''>\r\n\r\n					<a href=''/logout/''>Log out</a>\r\n\r\n				</div>\r\n\r\n				<h1>miRaptor<span>admin</span></h1>\r\n\r\n			</header>\r\n\r\n			<div id=''menu''>\r\n\r\n<!--{menu levels="1"}-->\r\n\r\n			</div>\r\n\r\n			<div id=''content''>\r\n\r\n<!--{page get="content"}-->\r\n\r\n			</div>\r\n\r\n		</div>\r\n\r\n	</body>\r\n\r\n</html>'),
(3, 1, 'Website', '<!doctype html>\r\n\r\n<html lang=''en''>\r\n\r\n	<head>\r\n\r\n		<title><!--{site get="sitename"}--> | <!--{page get="title"}--></title>\r\n\r\n<!--{site get="metadata"}-->\r\n\r\n<!--{stylesheet}-->\r\n\r\n	</head>\r\n\r\n	<body>\r\n\r\n		<div>\r\n\r\n			<header>\r\n\r\n				<div id=''logbox''>\r\n\r\n					<a href=''/logout/''>Log out</a>\r\n\r\n				</div>\r\n\r\n				<div id=''logbox''>\r\n					<a href=''/overview/''>Home</a>\r\n				</div>\r\n\r\n				<h1>miRaptor<span>admin</span></h1>\r\n\r\n			</header>\r\n\r\n<!--{page get="content"}-->\r\n\r\n		</div>\r\n\r\n	</body>\r\n\r\n</html>');

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
(1, 'miRaptor Admin');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `pid`, `mid`, `tid`, `order`, `default`, `name`, `description`, `content`, `url`) VALUES
(1, -1, 1, 1, 0, 1, 'Log In', '', '<!--{admin get="login"}-->', '/'),
(2, -1, 1, 1, 0, 0, 'Log out', '', '<!--{admin get="logout"}-->', '/logout/'),
(3, 0, 1, 2, 0, 0, 'Overview', '', '<!--{admin get="overview"}-->', '/overview/'),
(4, 0, 1, 2, 1, 0, 'Websites', '', '<!--{admin get="websites"}-->', '/websites/'),
(5, 0, 1, 2, 2, 0, 'Domains', '', '<!--{admin get="domains"}-->', '/domains/'),
(6, 0, 1, 2, 3, 0, 'Settings', '', '<!--{admin get="settings"}-->', '/settings/'),
(7, 3, 1, 3, 0, 0, 'Website', '', '<!--{admin get="website"}-->', '/website/'),
(8, 3, 1, 2, 0, 0, 'Website', '', '<!--{admin get="renamewebsite"}-->', '/websites/rename/'),
(9, 3, 1, 2, 0, 0, 'Stats', '', '<!--{admin get="websitestats"}-->', '/websites/stats/');

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
  ADD CONSTRAINT `module_stylesheet_template_ibfk_3` FOREIGN KEY (`tid`) REFERENCES `module_template` (`id`) ON UPDATE CASCADE;

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
