-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 24, 2013 at 12:57 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `perspective`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `categoryID` int(11) NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(100) NOT NULL,
  `categoryNav` varchar(100) NOT NULL,
  PRIMARY KEY (`categoryID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryID`, `categoryName`, `categoryNav`) VALUES
(1, 'Bathroom', 'Bathrooms'),
(2, 'Kitchen', 'Kitchens'),
(3, 'Living Area', 'Living Areas'),
(4, 'Exterior Tiling', 'Exterior Tiling'),
(5, 'Pool', 'Pools'),
(6, 'Flooring', 'Flooring');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `pageID` int(11) NOT NULL AUTO_INCREMENT,
  `pageName` varchar(20) NOT NULL,
  `pageTitle` varchar(100) NOT NULL,
  `pageHeading` varchar(100) NOT NULL,
  `pageDescription` varchar(255) NOT NULL,
  `pageKeywords` varchar(255) NOT NULL,
  `pageContent` text NOT NULL,
  PRIMARY KEY (`pageID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`pageID`, `pageName`, `pageTitle`, `pageHeading`, `pageDescription`, `pageKeywords`, `pageContent`) VALUES
(1, 'home', 'Home || Perspective', 'Welcome to Perspective', 'The Home Page of Perspective Ltd, your tiling company for Wellington and Hawkes Bay', 'tiling, tile, tiler, mosaic, renovation, wellington', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\n    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\n    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\n    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\n    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\n    proident, sunt in culpa qui officia deserunt mollit anim id est laborum. '),
(2, 'projects', 'Project Photos || Perspective', 'Project Photos', 'Project photos of jobs completed by Perspective Ltd', 'tiling, tile, tiler, mosaic, renovation, wellington', ''),
(3, 'about', 'About Us || Perspective', 'About Us', 'About the company of Perspective Ltd and its staff.', 'tiling, tile, tiler, mosaic, renovation, wellington', ''),
(4, 'contact', 'Contact Us || Perspective', 'Contact Us', 'The contact details for the staff at Perspective Ltd.', 'tiling, tile, tiler, mosaic, renovation, wellington', ''),
(5, 'sitemap', 'Sitemap || Perspective', 'Sitemap', 'The sitemap for the Perspective Ltd website.', 'tiling, tile, tiler, mosaic, renovation, wellington', ''),
(6, 'project', '', '', '', 'tiling, tile, tiler, mosaic, renovation, wellington', ''),
(7, 'addProject', 'Add Project || Perspective', 'Add Project', 'ADMIN ONLY : Add a new project to the Perspective Ltd website.', 'tiling, tile, tiler, mosaic, renovation, wellington', ''),
(8, 'editProject', 'Edit Project || Perspective', 'Edit Project', 'ADMIN ONLY : Edit an existing project on the Perspective Ltd website.', 'tiling, tile, tiler, mosaic, renovation, wellington', ''),
(9, 'admin', 'Administrator || Perspective', 'Admin', 'The Administrator page for Perspective.', 'tiling, tile, tiler, mosaic, renovation, wellington', ''),
(10, 'login', 'Login || Perspective', 'Login', 'The Login page for Perspective', 'tiling, tile, tiler, mosaic, renovation, wellington', ''),
(11, 'logout', 'Logged Out || Perspective', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `projectID` int(11) NOT NULL AUTO_INCREMENT,
  `projectHeading` varchar(100) NOT NULL,
  `projectImage` varchar(100) NOT NULL,
  `projectDescription` text NOT NULL,
  `projectCategory` int(11) NOT NULL,
  PRIMARY KEY (`projectID`),
  UNIQUE KEY `projectID` (`projectID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=131 ;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`projectID`, `projectHeading`, `projectImage`, `projectDescription`, `projectCategory`) VALUES
(1, 'Bathroom 01', 'bthrm01.jpg', 'This is Bathroom 1.', 1),
(2, 'Bathroom 02', 'bthrm02.jpg', 'This is Bathroom 2.', 1),
(3, 'Bathroom 03', 'bthrm03.jpg', 'This is Bathroom 3.', 1),
(4, 'Bathroom 04', 'bthrm04.jpg', 'This is Bathroom 4.', 1),
(5, 'Bathroom 05', 'bthrm05.jpg', 'This is Bathroom 5.', 1),
(6, 'Bathroom 06', 'bthrm06.jpg', 'This is Bathroom 6.', 1),
(7, 'Bathroom 07', 'bthrm07.jpg', 'This is Bathroom 7.', 1),
(8, 'Bathroom 08', 'bthrm08.jpg', 'This is Bathroom 8.', 1),
(9, 'Bathroom 09', 'bthrm09.jpg', 'This is Bathroom 9.', 1),
(10, 'Bathroom 10', 'bthrm10.jpg', 'This is Bathroom 10.', 1),
(11, 'Bathroom 11', 'bthrm11.jpg', 'This is Bathroom 11.', 1),
(12, 'Bathroom 12', 'bthrm12.jpg', 'This is Bathroom 12.', 1),
(13, 'Bathroom 13', 'bthrm13.jpg', 'This is Bathroom 13.', 1),
(14, 'Bathroom 14', 'bthrm14.jpg', 'This is Bathroom 14.', 1),
(15, 'Bathroom 15', 'bthrm15.jpg', 'This is Bathroom 15.', 1),
(16, 'Bathroom 16', 'bthrm16.jpg', 'This is Bathroom 16.', 1),
(17, 'Bathroom 17', 'bthrm17.jpg', 'This is Bathroom 17.', 1),
(18, 'Bathroom 18', 'bthrm18.png', 'This is Bathroom 18.', 1),
(19, 'Bathroom 19', 'bthrm19.jpg', 'This is Bathroom 19.', 1),
(20, 'Bathroom 20', 'bthrm20.jpg', 'This is Bathroom 20.', 1),
(21, 'Exterior Tiling 01', 'exterior01.jpg', 'This is Exterior Tiling 1.', 4),
(22, 'Exterior Tiling 02', 'exterior02.png', 'This is Exterior Tiling 2.', 4),
(23, 'Exterior Tiling 03', 'exterior03.jpg', 'This is Exterior Tiling 3.', 4),
(24, 'Exterior Tiling 04', 'exterior04.jpg', 'This is Exterior Tiling 4.', 4),
(25, 'Exterior Tiling 05', 'exterior05.jpg', 'This is Exterior Tiling 5.', 4),
(26, 'Exterior Tiling 06', 'exterior06.jpg', 'This is Exterior Tiling 6.', 4),
(27, 'Exterior Tiling 07', 'exterior07.jpg', 'This is Exterior Tiling 7.', 4),
(28, 'Exterior Tiling 08', 'exterior08.png', 'This is Exterior Tiling 8.', 4),
(29, 'Exterior Tiling 09', 'exterior09.jpg', 'This is Exterior Tiling 9.', 4),
(30, 'Exterior Tiling 10', 'exterior10.jpg', 'This is Exterior Tiling 10.', 4),
(31, 'Exterior Tiling 11', 'exterior11.jpg', 'This is Exterior Tiling 11.', 4),
(32, 'Exterior Tiling 12', 'exterior12.png', 'This is Exterior Tiling 12.', 4),
(33, 'Exterior Tiling 13', 'exterior13.jpg', 'This is Exterior Tiling 13.', 4),
(34, 'Exterior Tiling 14', 'exterior14.png', 'This is Exterior Tiling 14.', 4),
(35, 'Exterior Tiling 15', 'exterior15.jpg', 'This is Exterior Tiling 15.', 4),
(36, 'Exterior Tiling 16', 'exterior16.jpg', 'This is Exterior Tiling 16.', 4),
(37, 'Exterior Tiling 17', 'exterior17.jpg', 'This is Exterior Tiling 17.', 4),
(38, 'Exterior Tiling 18', 'exterior18.jpg', 'This is Exterior Tiling 18.', 4),
(39, 'Exterior Tiling 19', 'exterior19.jpg', 'This is Exterior Tiling 19.', 4),
(40, 'Exterior Tiling 20', 'exterior20.png', 'This is Exterior Tiling 20.', 4),
(41, 'Floor 01', 'flrs01.jpg', 'This is Floor 1.', 6),
(42, 'Floor 02', 'flrs02.jpg', 'This is Floor 2.', 6),
(43, 'Floor 03', 'flrs03.jpg', 'This is Floor 3.', 6),
(44, 'Floor 04', 'flrs04.gif', 'This is Floor 4.', 6),
(45, 'Floor 05', 'flrs05.jpg', 'This is Floor 5.', 6),
(46, 'Floor 06', 'flrs06.jpg', 'This is Floor 6.', 6),
(47, 'Floor 07', 'flrs07.jpg', 'This is Floor 7.', 6),
(48, 'Floor 08', 'flrs08.jpg', 'This is Floor 8.', 6),
(49, 'Floor 09', 'flrs09.jpg', 'This is Floor 9.', 6),
(50, 'Floor 10', 'flrs10.jpg', 'This is Floor 10.', 6),
(51, 'Floor 11', 'flrs11.jpg', 'This is Floor 11.', 6),
(52, 'Floor 12', 'flrs12.jpg', 'This is Floor 12.', 6),
(53, 'Floor 13', 'flrs13.jpg', 'This is Floor 13.', 6),
(54, 'Floor 14', 'flrs14.jpg', 'This is Floor 14.', 6),
(55, 'Floor 15', 'flrs15.jpg', 'This is Floor 15.', 6),
(56, 'Floor 16', 'flrs16.jpg', 'This is Floor 16.', 6),
(57, 'Floor 17', 'flrs17.jpg', 'This is Floor 17.', 6),
(58, 'Floor 18', 'flrs18.jpg', 'This is Floor 18.', 6),
(59, 'Floor 19', 'flrs19.jpg', 'This is Floor 19.', 6),
(60, 'Floor 20', 'flrs20.jpg', 'This is Floor 20.', 6),
(61, 'Kitchen 01', 'ktchn01.jpg', 'This is Kitchen 1.', 2),
(62, 'Kitchen 02', 'ktchn02.jpg', 'This is Kitchen 2.', 2),
(63, 'Kitchen 03', 'ktchn03.jpg', 'This is Kitchen 3.', 2),
(64, 'Kitchen 04', 'ktchn04.jpg', 'This is Kitchen 4.', 2),
(65, 'Kitchen 05', 'ktchn05.jpg', 'This is Kitchen 5.', 2),
(66, 'Kitchen 06', 'ktchn06.jpg', 'This is Kitchen 6.', 2),
(67, 'Kitchen 07', 'ktchn07.jpg', 'This is Kitchen 7.', 2),
(68, 'Kitchen 08', 'ktchn08.jpg', 'This is Kitchen 8.', 2),
(69, 'Kitchen 09', 'ktchn09.jpg', 'This is Kitchen 9.', 2),
(70, 'Kitchen 10', 'ktchn10.jpg', 'This is Kitchen 10.', 2),
(71, 'Kitchen 11', 'ktchn11.jpg', 'This is Kitchen 11.', 2),
(72, 'Kitchen 12', 'ktchn12.jpg', 'This is Kitchen 12.', 2),
(73, 'Kitchen 13', 'ktchn13.jpg', 'This is Kitchen 13.', 2),
(74, 'Kitchen 14', 'ktchn14.jpg', 'This is Kitchen 14.', 2),
(75, 'Kitchen 15', 'ktchn15.jpg', 'This is Kitchen 15.', 2),
(76, 'Kitchen 16', 'ktchn16.jpg', 'This is Kitchen 16.', 2),
(77, 'Kitchen 17', 'ktchn17.jpg', 'This is Kitchen 17.', 2),
(78, 'Kitchen 18', 'ktchn18.jpg', 'This is Kitchen 18.', 2),
(79, 'Kitchen 19', 'ktchn19.jpg', 'This is Kitchen 19.', 2),
(80, 'Kitchen 20', 'ktchn20.png', 'This is Kitchen 20.', 2),
(81, 'Living Area 01', 'lvng01.jpg', 'This is Living Area 1.', 3),
(82, 'Living Area 02', 'lvng02.gif', 'This is Living Area 2.', 3),
(83, 'Living Area 03', 'lvng03.jpg', 'This is Living Area 3.', 3),
(84, 'Living Area 04', 'lvng04.jpg', 'This is Living Area 4.', 3),
(85, 'Living Area 05', 'lvng05.jpg', 'This is Living Area 5.', 3),
(86, 'Living Area 06', 'lvng06.jpg', 'This is Living Area 6.', 3),
(87, 'Living Area 07', 'lvng07.jpg', 'This is Living Area 7.', 3),
(88, 'Living Area 08', 'lvng08.jpg', 'This is Living Area 8.', 3),
(89, 'Living Area 09', 'lvng09.jpg', 'This is Living Area 9.', 3),
(90, 'Living Area 10', 'lvng10.jpg', 'This is Living Area 10.', 3),
(91, 'Living Area 11', 'lvng11.jpg', 'This is Living Area 11.', 3),
(92, 'Living Area 12', 'lvng12.jpg', 'This is Living Area 12.', 3),
(93, 'Living Area 13', 'lvng13.jpg', 'This is Living Area 13.', 3),
(94, 'Living Area 14', 'lvng14.jpg', 'This is Living Area 14.', 3),
(95, 'Living Area 15', 'lvng15.jpg', 'This is Living Area 15.', 3),
(96, 'Living Area 16', 'lvng16.jpg', 'This is Living Area 16.', 3),
(97, 'Living Area 17', 'lvng17.jpg', 'This is Living Area 17.', 3),
(98, 'Living Area 18', 'lvng18.jpg', 'This is Living Area 18.', 3),
(99, 'Living Area 19', 'lvng19.jpg', 'This is Living Area 19.', 3),
(100, 'Living Area 20', 'lvng20.jpg', 'This is Living Area 20.', 3),
(101, 'Pool 01', 'pool01.jpg', 'This is Pool 1.', 5),
(102, 'Pool 02', 'pool02.jpg', 'This is Pool 2.', 5),
(103, 'Pool 03', 'pool03.jpg', 'This is Pool 3.', 5),
(104, 'Pool 04', 'pool04.jpg', 'This is Pool 4.', 5),
(105, 'Pool 05', 'pool05.jpg', 'This is Pool 5.', 5),
(106, 'Pool 06', 'pool06.jpg', 'This is Pool 6.', 5),
(107, 'Pool 07', 'pool07.jpg', 'This is Pool 7.', 5),
(108, 'Pool 08', 'pool08.jpg', 'This is Pool 8.', 5),
(109, 'Pool 09', 'pool09.jpg', 'This is Pool 9.', 5),
(110, 'Pool 10', 'pool10.jpg', 'This is Pool 10.', 5),
(111, 'Pool 11', 'pool11.jpg', 'This is Pool 11.', 5),
(112, 'Pool 12', 'pool12.jpg', 'This is Pool 12.', 5),
(113, 'Pool 13', 'pool13.jpg', 'This is Pool 13.', 5),
(114, 'Pool 14', 'pool14.jpg', 'This is Pool 14.', 5),
(115, 'Pool 15', 'pool15.png', 'This is Pool 15.', 5),
(116, 'Pool 16', 'pool16.jpg', 'This is Pool 16.', 5),
(117, 'Pool 17', 'pool17.jpg', 'This is Pool 17.', 5),
(118, 'Pool 18', 'pool18.jpg', 'This is Pool 18.', 5),
(119, 'Pool 19', 'pool19.png', 'This is Pool 19.', 5),
(120, 'Pool 20', 'pool20.jpg', 'This is Pool 20.', 5),
(125, 'gsrgrg', '', 'sdgr s rdg srdgsr gdr gdsrdsd r', 5),
(129, 'dfgdfsgsfdg', 'Face In A Muffin.jpg', 'fdsgf  sgfdsdf sfdg ', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(30) NOT NULL,
  `userPassword` varchar(40) NOT NULL,
  `userAccess` enum('admin','user') NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `userName`, `userPassword`, `userAccess`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
