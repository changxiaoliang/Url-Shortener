-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2022-01-14 22:03:51
-- 服务器版本： 5.7.34-log
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vatsim_url_short`
--

-- --------------------------------------------------------

--
-- 表的结构 `short_url`
--

CREATE TABLE IF NOT EXISTS `short_url` (
  `id` int(11) NOT NULL,
  `ipaddresscreator` varchar(64) COLLATE utf8_unicode_ci DEFAULT '' COMMENT 'Ip address of the creator',
  `maxclicks` int(11) DEFAULT '0' COMMENT 'Maximum number of clicks allowed, 0=no limits',
  `maxseconds` int(11) DEFAULT '0' COMMENT 'Maximum duration in seconds from the creation, 0=no limits',
  `mobileonly` tinyint(1) DEFAULT '0' COMMENT 'accept only mobile devices',
  `dtcreation` datetime DEFAULT '0000-00-00 00:00:00' COMMENT 'date/time of creation',
  `dtlastclick` datetime DEFAULT '0000-00-00 00:00:00' COMMENT 'date/time of last click',
  `totclicks` int(11) DEFAULT '0' COMMENT 'total number of clicks',
  `shorturl` varchar(64) COLLATE utf8_unicode_ci DEFAULT '' COMMENT 'generated short url',
  `destinationurl` varchar(128) COLLATE utf8_unicode_ci DEFAULT '' COMMENT 'destination long url'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `short_url`
--
ALTER TABLE `short_url`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `short_url`
--
ALTER TABLE `short_url`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
