-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 08, 2013 at 03:36 PM
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
  `request` varchar(2048) COLLATE utf8_unicode_ci NOT NULL,
  `referal` varchar(2048) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE IF NOT EXISTS `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`id`, `name`, `active`) VALUES
(1, 'block', 1),
(2, 'javascript', 1),
(3, 'stylesheet', 1),
(4, 'template', 1),
(5, 'theme', 0),
(6, 'file', 0),
(7, 'menu', 1),
(8, 'news', 1),
(9, 'page', 1),
(10, 'admin', 1),
(11, 'breadcrumb', 1),
(12, 'mail', 1),
(13, 'sitemap', 0),
(14, 'slider', 1),
(15, 'stats', 0);

-- --------------------------------------------------------

--
-- Table structure for table `module_admin`
--

CREATE TABLE IF NOT EXISTS `module_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_module` int(11) NOT NULL,
  `id_group` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_module` (`id_module`),
  KEY `id_group` (`id_group`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Dumping data for table `module_admin`
--

INSERT INTO `module_admin` (`id`, `id_module`, `id_group`, `active`) VALUES
(1, 1, 2, 1),
(2, 2, 2, 1),
(3, 3, 2, 1),
(4, 4, 2, 1),
(5, 5, 2, 1),
(6, 6, 1, 1),
(7, 7, 1, 0),
(8, 8, 1, 1),
(9, 9, 1, 1),
(10, 10, 3, 0),
(11, 11, 3, 0),
(12, 12, 3, 1),
(13, 13, 3, 1),
(14, 14, 3, 1),
(15, 15, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `module_admin_group`
--

CREATE TABLE IF NOT EXISTS `module_admin_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `module_admin_group`
--

INSERT INTO `module_admin_group` (`id`, `name`) VALUES
(1, 'editor'),
(2, 'theme'),
(3, 'modules');

-- --------------------------------------------------------

--
-- Table structure for table `module_block`
--

CREATE TABLE IF NOT EXISTS `module_block` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_theme` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_theme` (`id_theme`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `module_block`
--

INSERT INTO `module_block` (`id`, `id_theme`, `name`, `content`) VALUES
(1, 1, 'Sitename', 'miRaptor'),
(2, 1, 'Metadata', '<base href="http://www.miraptor.nl" />\r\n<meta charset="utf-8" />\r\n<meta name="viewport" content="initial-scale=1" />'),
(3, 1, 'Menu', '<ul>\r\n<li><a class="icon icon-dashboard" href="/dashboard/">Dashboard</a></li>\r\n<li><a class="icon icon-account" href="/account/">Account</a></li>\r\n<li><a class="icon icon-sign-out" href="/signout/">Sign Out</a></li>\r\n</ul>');

-- --------------------------------------------------------

--
-- Table structure for table `module_javascript`
--

CREATE TABLE IF NOT EXISTS `module_javascript` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_theme` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_theme` (`id_theme`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `module_javascript`
--

INSERT INTO `module_javascript` (`id`, `id_theme`, `name`, `content`) VALUES
(1, 1, 'Javascript', '/* Javascript test */');

-- --------------------------------------------------------

--
-- Table structure for table `module_page`
--

CREATE TABLE IF NOT EXISTS `module_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_router` int(11) NOT NULL,
  `id_template` int(11) NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_router` (`id_router`),
  KEY `id_template` (`id_template`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `module_page`
--

INSERT INTO `module_page` (`id`, `id_router`, `id_template`, `content`) VALUES
(1, 1, 1, '<!--{admin get="signin"  redirect="/dashboard/"}-->'),
(2, 2, 2, '<!--{admin get="signout" redirect="/"}-->'),
(3, 3, 2, '<!--{admin get="account" redirect="/"}-->'),
(4, 4, 2, '<!--{admin get="dashboard" redirect="/" website="/website/"}-->'),
(5, 5, 3, '<!--{admin get="website" redirect="/dashboard/"}-->');

-- --------------------------------------------------------

--
-- Table structure for table `module_stylesheet`
--

CREATE TABLE IF NOT EXISTS `module_stylesheet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_theme` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_theme` (`id_theme`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `module_stylesheet`
--

INSERT INTO `module_stylesheet` (`id`, `id_theme`, `name`, `content`) VALUES
(1, 1, 'Main', '@font-face\r\n{\r\n	font-family: ''FontAwesome'';\r\n	font-style: normal;\r\n	font-weight: normal;\r\n	src:	url(''_font/fontawesome-webfont.eot?'') format(''eot''),\r\n		url(''_font/fontawesome-webfont.woff'') format(''woff''),\r\n		url(''_font/fontawesome-webfont.ttf'') format(''truetype''),\r\n		url(''_font/fontawesome-webfont.svg'') format(''svg'');\r\n}\r\n\r\nhtml, body\r\n{\r\n	margin: 0;\r\n	padding: 0;\r\n	width: 100%;\r\n	height: 100%;\r\n}\r\n\r\nbody\r\n{\r\n	color: #444;\r\n	font-family: ''Helvetica Neue'', Helvetica, Arial, sans-serif;\r\n	font-size: 14px;\r\n	background: white;\r\n}\r\n\r\na\r\n{\r\n	color: #269;\r\n	text-decoration: none;\r\n}\r\n\r\nh1, h2, h3, h4, h5, h6, h7\r\n{\r\n	margin: 0 0 20px;\r\n	font-weight: normal;\r\n}\r\n\r\nimg\r\n{\r\n	display: block;\r\n	border: none;\r\n}\r\n\r\np, ul, table\r\n{\r\n	margin: 0 0 20px;\r\n	line-height: 20px;\r\n}\r\n\r\nul\r\n{\r\n	padding-left: 20px;\r\n	list-style-type: square;\r\n}\r\n\r\n#template\r\n{\r\n	width: 100%;\r\n	height: 100%;\r\n}\r\n\r\nheader\r\n{\r\n	position: relative;\r\n	z-index: 10;\r\n	width: 100%;\r\n	height: 100px;\r\n	border-bottom: 1px solid #ddd;\r\n	background: #fff;\r\n}\r\n\r\nheader h1\r\n{\r\n	margin: 0;\r\n	padding: 0 0 0 85px;\r\n	height: 100px;\r\n	background: transparent url(''_media/template/logo.png'') no-repeat 0 50%;\r\n	font-size: 18px;\r\n	line-height: 100px;\r\n}\r\n\r\nheader h1 span\r\n{\r\n	color: #444;\r\n	font-size: 14px;\r\n}\r\n\r\n#logbox\r\n{\r\n	position: absolute;\r\n	top: 0;\r\n	right: 0;\r\n}\r\n\r\n#logbox ul\r\n{\r\n	margin: 0;\r\n	padding: 0;\r\n	list-style-type: none;\r\n}\r\n\r\n#logbox li\r\n{\r\n	float: left;\r\n	border-left: 1px solid #ddd;\r\n	width: 100px;\r\n}\r\n\r\n#logbox a\r\n{\r\n	display: block;\r\n	line-height: 100px;\r\n	width: 100%;\r\n	text-align: center;\r\n}\r\n\r\n#body\r\n{\r\n	position: absolute;\r\n	top: 100px;\r\n	bottom: 0;\r\n	width: 100%;\r\n}\r\n\r\n#menu, #content\r\n{\r\n	float: left;\r\n}\r\n\r\n#menu nav, #content\r\n{\r\n	padding: 20px 30px;\r\n}\r\n\r\n#menu\r\n{\r\n	border-right: 1px solid #ddd;\r\n	width: 230px;\r\n	height: 100%;\r\n	background: #fafafa;\r\n}\r\n	'),
(2, 1, 'Class', '/* Colors */\r\n.msg-error { color: #c33c3c; }\r\n.msg-succes { color: #3cc33c; }\r\n.msg-warning { color: #c3c33c; }\r\n\r\n/* Icon */\r\na.icon\r\n{\r\n	display: block;\r\n}\r\n\r\n.icon:before\r\n{\r\n	display: inline-block;\r\n	margin-right: 0.3em;\r\n	width: 1em;\r\n	font-family: ''FontAwesome'';\r\n	text-align: center;\r\n}\r\n\r\n/* Icons */\r\n.icon-active-0:before { content: "\\f00d"; color: #c33c3c;}\r\n.icon-active-1:before { content: "\\f00c"; color: #3cc33c;}\r\n.icon-edit:before { content: "\\f044"; }\r\n.icon-new:before { content: "\\f067"; }\r\n.icon-remove:before { content: "\\f014"; }\r\n\r\n/* Icons admin */\r\n.icon-account:before { content: "\\f007" }\r\n.icon-dashboard:before { content: "\\f015"; }\r\n.icon-menu:before { content: "\\f0c9"; }\r\n.icon-settings:before { content: "\\f085"; }\r\n.icon-sign-in:before { content: "\\f023"; }\r\n.icon-sign-out:before { content: "\\f011"; }\r\n\r\n/* Icons group */\r\n.icon-group-editor:before { content: "\\f044"; }\r\n.icon-group-theme:before { content: "\\f03e"; }\r\n.icon-group-modules:before { content: "\\f12e"; }\r\n\r\n/* Icons module */\r\n.icon-module-file:before { content: "\\f07c"; }\r\n.icon-module-news:before { content: "\\f01c"; }\r\n.icon-module-page:before { content: "\\f15c"; }\r\n\r\n.icon-module-block:before { content: "\\f009"; }\r\n.icon-module-javascript:before { content: "\\f121"; }\r\n.icon-module-stylesheet:before { content: "\\f13c"; }\r\n.icon-module-template:before { content: "\\f13b"; }\r\n.icon-module-theme:before { content: "\\f02c"; }\r\n\r\n.icon-module-mail:before { content: "\\f0e0"; }\r\n.icon-module-sitemap:before { content: "\\f0e8"; }\r\n.icon-module-slider:before { content: "\\f061"; }\r\n.icon-module-stats:before { content: "\\f080"; }'),
(3, 1, 'Form', 'form\r\n{\r\n	margin: -5px;\r\n}\r\n\r\nform *[disabled]\r\n{\r\n	cursor: not-allowed;\r\n	background-color: #eee;\r\n}\r\n\r\nform label,\r\nform input,\r\nform select,\r\nform textarea,\r\nform button\r\n{\r\n	margin: 5px;\r\n}\r\n\r\nform label\r\n{\r\n	display: block;\r\n	margin-top: 20px;\r\n	line-height: 20px;\r\n}\r\n\r\nform input,\r\nform select,\r\nform textarea,\r\nform button\r\n{\r\n	border-radius: 4px;\r\n	max-width: 100%;\r\n}\r\n\r\nform input,\r\nform select,\r\nform textarea\r\n{\r\n	display: block;\r\n	border: 1px #ccc solid;\r\n	padding: 6px 10px;\r\n	box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 1px 0px inset;\r\n}\r\n\r\nform input:focus,\r\nform select:focus,\r\nform textarea:focus\r\n{\r\n	border-color: #64afe1;\r\n	outline: 0;\r\n	box-shadow: inset 0 1px 1px rgba(0,0,0,0.05), 0 0 8px rgba(100, 175, 225, 0.6);\r\n}\r\n\r\nform input[type=email],\r\nform input[type=text],\r\nform input[type=password]\r\n{\r\n	width: 170px;\r\n}\r\n\r\nform input[type=checkbox],\r\nform input[type=radio],\r\n{\r\n	padding: 0;\r\n}\r\n\r\nform textarea\r\n{\r\n	width: 400px;\r\n	height: 200px;\r\n}\r\n\r\nform button\r\n{\r\n	margin-top: 15px;\r\n	display: inline-block;\r\n	border: none;\r\n	padding: 6px 20px;\r\n	background: #e5e5e5;\r\n	font-size: 90%;\r\n	cursor: pointer;\r\n}\r\n\r\nform button:hover,\r\nform button:active\r\n{\r\n	color: white;\r\n	background: #269;\r\n}\r\n\r\nform button:active\r\n{\r\n	box-shadow: 0 0 0 1px rgba(0,0,0,.15) inset, 0 0 6px rgba(0,0,0,.2) inset;\r\n}\r\n	'),
(4, 1, 'Table', 'table\r\n{\r\n	border-collapse: collapse;\r\n}\r\n\r\ntable th,\r\ntable td\r\n{\r\n	padding: 10px;\r\n	text-align: center;\r\n}\r\n\r\ntable th:first-child + th,\r\ntable td:first-child + td\r\n{\r\n	padding-right: 20px;\r\n	text-align: left;\r\n}\r\n\r\ntable th\r\n{\r\n	border-bottom: 1px solid #ddd;\r\n}\r\n\r\ntable td\r\n{\r\n	border-top: 1px solid #ddd;\r\n}');

-- --------------------------------------------------------

--
-- Table structure for table `module_template`
--

CREATE TABLE IF NOT EXISTS `module_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_theme` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_theme` (`id_theme`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `module_template`
--

INSERT INTO `module_template` (`id`, `id_theme`, `name`, `content`) VALUES
(1, 1, 'Login', '<!doctype html>\r\n\r\n<html lang="en">\r\n\r\n	<head>\r\n\r\n		<title><!--{block theme="miRaptor" name="sitename"}--></title>\r\n\r\n<!--{block theme="miRaptor" name="metadata"}-->\r\n\r\n<!--{stylesheet theme="miRaptor" name="Main"}-->\r\n<!--{stylesheet theme="miRaptor" name="Class"}-->\r\n<!--{stylesheet theme="miRaptor" name="Form"}-->\r\n<!--{stylesheet theme="miRaptor" name="Table"}-->\r\n\r\n	</head>\r\n\r\n	<body>\r\n\r\n		<div id="template">\r\n\r\n			<header>\r\n\r\n				<div id="logo">\r\n\r\n					<h1><a href="/">miRaptor<span> admin</span></a></h1>\r\n\r\n				</div>\r\n			</header>\r\n\r\n			<div id="body">\r\n\r\n				<div id="menu">\r\n\r\n				</div>\r\n\r\n				<div id="content">\r\n\r\n<!--{page get="content"}-->\r\n\r\n				</div>\r\n\r\n			</div>\r\n\r\n		</div>\r\n\r\n	</body>\r\n\r\n</html>'),
(2, 1, 'Main', '<!doctype html>\r\n\r\n<html lang="en">\r\n\r\n	<head>\r\n\r\n		<title><!--{block theme="miRaptor" name="sitename"}--></title>\r\n\r\n<!--{block theme="miRaptor" name="metadata"}-->\r\n\r\n<!--{stylesheet theme="miRaptor" name="Main"}-->\r\n<!--{stylesheet theme="miRaptor" name="Class"}-->\r\n<!--{stylesheet theme="miRaptor" name="Form"}-->\r\n<!--{stylesheet theme="miRaptor" name="Table"}-->\r\n\r\n	</head>\r\n\r\n	<body>\r\n\r\n		<div id="template">\r\n\r\n			<header>\r\n\r\n				<div id="logo">\r\n\r\n					<h1><a href="/">miRaptor<span> admin</span></a></h1>\r\n\r\n				</div>\r\n\r\n				<nav id="logbox">\r\n\r\n<!--{block theme="miRaptor" name="Menu"}-->\r\n\r\n				</nav>\r\n\r\n			</header>\r\n\r\n			<div id="body">\r\n\r\n				<div id="menu">\r\n\r\n				</div>\r\n\r\n				<div id="content">\r\n\r\n<!--{page get="content"}-->\r\n\r\n				</div>\r\n\r\n			</div>\r\n\r\n		</div>\r\n\r\n	</body>\r\n\r\n</html>'),
(3, 1, 'Website', '<!doctype html>\r\n\r\n<html lang="en">\r\n\r\n	<head>\r\n\r\n		<title><!--{block theme="miRaptor" name="sitename"}--></title>\r\n\r\n<!--{block theme="miRaptor" name="metadata"}-->\r\n\r\n<!--{stylesheet theme="miRaptor" name="Main"}-->\r\n<!--{stylesheet theme="miRaptor" name="Class"}-->\r\n<!--{stylesheet theme="miRaptor" name="Form"}-->\r\n<!--{stylesheet theme="miRaptor" name="Table"}-->\r\n\r\n	</head>\r\n\r\n	<body>\r\n\r\n		<div id="template">\r\n\r\n			<header>\r\n\r\n				<div id="logo">\r\n\r\n					<h1><a href="/">miRaptor<span> admin</span></a></h1>\r\n\r\n				<nav id="logbox">\r\n\r\n<!--{block theme="miRaptor" name="Menu"}-->\r\n\r\n				</nav>\r\n\r\n				</div>\r\n			</header>\r\n\r\n			<div id="body">\r\n\r\n<!--{page get="content"}-->\r\n\r\n			</div>\r\n\r\n		</div>\r\n\r\n	</body>\r\n\r\n</html>');

-- --------------------------------------------------------

--
-- Table structure for table `module_theme`
--

CREATE TABLE IF NOT EXISTS `module_theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `module_theme`
--

INSERT INTO `module_theme` (`id`, `name`) VALUES
(1, 'miRaptor');

-- --------------------------------------------------------

--
-- Table structure for table `router`
--

CREATE TABLE IF NOT EXISTS `router` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) DEFAULT NULL,
  `index` int(11) NOT NULL,
  `root` tinyint(1) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `uri` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uri` (`uri`),
  UNIQUE KEY `pid-index` (`pid`,`index`),
  UNIQUE KEY `pid-name` (`pid`,`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `router`
--

INSERT INTO `router` (`id`, `pid`, `index`, `root`, `name`, `uri`) VALUES
(1, NULL, 0, 1, 'Sign In', '/'),
(2, NULL, 1, 0, 'Sign Out', '/signout/'),
(3, NULL, 2, 0, 'Account', '/account/'),
(4, NULL, 3, 0, 'Dashboard', '/dashboard/'),
(5, NULL, 4, 0, 'Website', '/website/');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `module_admin`
--
ALTER TABLE `module_admin`
  ADD CONSTRAINT `module_admin_ibfk_3` FOREIGN KEY (`id_module`) REFERENCES `module` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `module_admin_ibfk_2` FOREIGN KEY (`id_group`) REFERENCES `module_admin_group` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `module_block`
--
ALTER TABLE `module_block`
  ADD CONSTRAINT `module_block_ibfk_2` FOREIGN KEY (`id_theme`) REFERENCES `module_theme` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `module_javascript`
--
ALTER TABLE `module_javascript`
  ADD CONSTRAINT `module_javascript_ibfk_2` FOREIGN KEY (`id_theme`) REFERENCES `module_theme` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `module_page`
--
ALTER TABLE `module_page`
  ADD CONSTRAINT `module_page_ibfk_2` FOREIGN KEY (`id_template`) REFERENCES `module_template` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `module_page_ibfk_3` FOREIGN KEY (`id_router`) REFERENCES `router` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `module_stylesheet`
--
ALTER TABLE `module_stylesheet`
  ADD CONSTRAINT `module_stylesheet_ibfk_2` FOREIGN KEY (`id_theme`) REFERENCES `module_theme` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `module_template`
--
ALTER TABLE `module_template`
  ADD CONSTRAINT `module_template_ibfk_2` FOREIGN KEY (`id_theme`) REFERENCES `module_theme` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `router`
--
ALTER TABLE `router`
  ADD CONSTRAINT `router_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `router` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
