-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 172.16.4.229
-- Generation Time: Jan 03, 2016 at 08:38 PM
-- Server version: 5.0.83-community
-- PHP Version: 5.3.3

-- CONOR WALSH 2016

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
--
--

-- --------------------------------------------------------

--
-- Table structure for table `siteup_settings`
--

CREATE TABLE IF NOT EXISTS `siteup_settings` (
  `id` int(2) NOT NULL auto_increment,
  `dbpass` varchar(50) NOT NULL,
  `site` varchar(50) NOT NULL,
  `toemail` varchar(150) NOT NULL,
  `fromemail` varchar(150) NOT NULL,
  `emailfirstname` varchar(150) NOT NULL,
  `emaillastname` varchar(50) NOT NULL,
  `warningsubject` varchar(150) NOT NULL,
  `notificationsubject` varchar(150) NOT NULL,
  `regardsname` varchar(50) NOT NULL,
  `warningoffline` varchar(300) NOT NULL,
  `warninginvalid` varchar(300) NOT NULL,
  `warningelse` varchar(300) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `siteup_settings`
--

INSERT INTO `siteup_settings` (`id`, `dbpass`, `site`, `warningsubject`, `notificationsubject`, `regardsname`, `warningoffline`, `warninginvalid`, `warningelse`) VALUES
(1, 'siteup', 'http://google.com/', 'SiteUp? Warning', 'SiteUp? Notification', 'SiteUp?', 'The website you are monitoring is offline.', 'The URL was invalid. The system needs to be checked.', 'An unknown error has occurred. The system needs to be checked.');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
