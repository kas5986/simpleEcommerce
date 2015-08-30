-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2013 at 10:55 AM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `w-sell`
--
CREATE DATABASE IF NOT EXISTS `w-sell` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `w-sell`;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(20) CHARACTER SET utf8 NOT NULL,
  `email` varchar(80) CHARACTER SET utf8 NOT NULL,
  `address` varchar(80) CHARACTER SET utf8 NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `user_id`, `name`, `email`, `address`, `phone`) VALUES
(1, 1, 'Syed Muhammad Shafiq', 'shafiq_shaheen@hotmail.com', './root', '0345-5222128'),
(2, 1, 'Syed Muhammad Shafiq', 'shafiq_shaheen@hotmail.com', './root', '0345-5222128'),
(3, 1, 'Syed Muhammad Shafiq', 'shafiq_shaheen@hotmail.com', './root', '0345-5222128'),
(4, 1, 'Syed Muhammad Shafiq', 'shafiq_shaheen@hotmail.com', './root', '0345-5222128');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dated` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=received,2=process,3=completed',
  `order_total` int(11) NOT NULL,
  `note` varchar(500) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `dated`, `user_id`, `status`, `order_total`, `note`) VALUES
(1, '2013-12-19 19:38:45', 1, 1, 34, 'f hdfgh dfgh dfgh'),
(2, '2013-12-20 21:54:22', 1, 2, 56, 'sdf asdf asdf as'),
(3, '2013-12-23 20:17:03', 1, 2, 560, 'fgh fgh fdgh gfgh dfgh'),
(4, '2013-12-24 08:40:41', 1, 1, 8631, 'dsgfsdfds');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE IF NOT EXISTS `order_detail` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` float NOT NULL,
  `note` varchar(255) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`order_id`, `product_id`, `quantity`, `price`, `note`) VALUES
(1, 2, 1, 34, ''),
(3, 1, 10, 56, 'anyone'),
(4, 4, 9, 454, 'blue'),
(4, 5, 1, 4545, 'red');

-- --------------------------------------------------------

--
-- Table structure for table `page_data`
--

CREATE TABLE IF NOT EXISTS `page_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_id` int(11) NOT NULL,
  `position` int(3) NOT NULL,
  `page_name` varchar(50) NOT NULL,
  `page_value` text NOT NULL,
  `visible` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `page_data`
--

INSERT INTO `page_data` (`id`, `subject_id`, `position`, `page_name`, `page_value`, `visible`) VALUES
(1, 4, 1, 'simple page', 'd gfdsfg sdfg sdfg sdfg dsf<br>', 1),
(2, 4, 2, 'sadfasd', 'as dfasdf sadf sadf <br>', 1),
(3, 4, 3, 'new product', 'dsfg sdfg sdfg<br>', 1),
(4, 3, 4, 'dfsgdsfgdf', 'sdfgs dfgdsfg dsfgs<br>', 1);

-- --------------------------------------------------------

--
-- Table structure for table `page_subjects`
--

CREATE TABLE IF NOT EXISTS `page_subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(3) NOT NULL,
  `nav_id` int(11) NOT NULL,
  `position` int(3) NOT NULL,
  `name` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `visible` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `page_subjects`
--

INSERT INTO `page_subjects` (`id`, `parent_id`, `nav_id`, `position`, `name`, `content`, `visible`) VALUES
(1, 0, 2, 1, 'About Company', 'This is about our company ...............<br>', 1),
(2, 0, 2, 2, 'Products', 'great details regarding our all products ..............<br>', 1),
(3, 4, 1, 3, 'liquids', 'All liquids goes here ..................<br>', 1),
(4, 0, 1, 4, 'Mods', 'All mods goes here and this is only detail page for mods ..............<br>', 1),
(5, 4, 1, 5, 'new', 'sadfasdfsadf', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `description` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `price` float NOT NULL,
  `picture` varchar(80) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `page_id`, `subject_id`, `position`, `name`, `description`, `visible`, `price`, `picture`) VALUES
(1, 1, 4, 1, 'sdfg dsfg dsf', 'fgh dfgh fdgh fdgh fdg', 1, 56, 'images/products/27546180ee3f9ea5150f4b47a67933add25f84bd.png'),
(2, 2, 4, 2, 'sa fasdfasdf', 'sad fsadf asdf sadf', 1, 34, 'images/products/24eefe042dff95d7fce488bcbb49e4ac76b0d037.png'),
(4, 3, 4, 3, 'sdfgsdfg dsfg ', 'dsfg sdfg sdfg', 1, 454, 'images/products/27546180ee3f9ea5150f4b47a67933add25f84bd.png'),
(5, 4, 4, 4, 'ds gfg dsfg s', 'sdf gsdfg dsfg sdf', 1, 4545, 'images/products/1ee990fcca5f78b820084d88de3223a1e69da7d3.png');

-- --------------------------------------------------------

--
-- Table structure for table `site_options`
--

CREATE TABLE IF NOT EXISTS `site_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `new_products` int(3) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `welcome` text NOT NULL,
  `logo` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `site_options`
--

INSERT INTO `site_options` (`id`, `link`, `title`, `email`, `new_products`, `description`, `welcome`, `logo`) VALUES
(1, 'http://localhost/w-sell/', 'LongHorn Vapor Co.', 'shafiq_shaheen@hotmail.com', 3, 'This is <strong>database</strong> store description for long horn vapor wholesaleeeee ...', '<h1>Company, intro.</h1>\r\n<p>Longhorn Vapor LLC, American based e-liquid manufacturer located proudly in Grapevine, Texas. From affordable top quality E-liquid, to innovative electronic cigarettes. Wehelp you make the transition from smoking to vaping a fun and enjoyable experience. Enjoy the freedom of fulfilling your cravings anywhere anytime.</p>', '/images/81c27284f77a447375ba39fb2f0005eeaccf28d8.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `username` varchar(65) NOT NULL,
  `name` varchar(255) NOT NULL,
  `hashed_password` varchar(42) NOT NULL,
  `job` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `fax` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `activation` tinyint(1) NOT NULL,
  `user_type` int(3) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `company_website` varchar(255) NOT NULL,
  `company_address` varchar(500) NOT NULL,
  `company_city` varchar(255) NOT NULL,
  `company_state` varchar(255) NOT NULL,
  `company_zip` int(20) NOT NULL,
  `company_country` varchar(255) NOT NULL,
  `company_years` varchar(15) NOT NULL,
  `company_started` varchar(15) NOT NULL,
  `company_tax` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `hashed_password`, `job`, `email`, `phone`, `mobile`, `fax`, `address`, `activation`, `user_type`, `company_name`, `company_website`, `company_address`, `company_city`, `company_state`, `company_zip`, `company_country`, `company_years`, `company_started`, `company_tax`) VALUES
(1, 'admin', 'Syed Muhammad Shafiq', '3c22572a25403d28ba1985edf9e3f84e7cbc7379', 'PHP Developer', 'shafiq_shaheen@hotmail.com', '0345-5222128', '0345-5222128', '0345-5222128', './root', 1, 1, 'ProSocial Professional', 'http://facebook.com/kas5986', './root', 'Islamabad', 'Punjab', 46000, 'Pakistan', '5', '2008', '92-345-5222128'),
(2, 'naveed', 'naveed ', '3bab384da2adfee61f03d23ef6a4c071b50fdba0', 'naveed title', 'naveed@gmail.com', '0345-5221783', '0345-5221783', '0345-5221783', 'abc 123 # street', 0, 2, 'naveed ent', 'http://facebook.com/kas5986', 'abc street # 12 bste ', 'karachi ', 'pakistan', 75010, 'Pakistan', '2', '2008', '45615154');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
