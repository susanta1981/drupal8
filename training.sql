-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2017 at 03:39 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `training`
--

-- --------------------------------------------------------

--
-- Table structure for table `authuser`
--

CREATE TABLE IF NOT EXISTS `authuser` (
`id` int(10) unsigned NOT NULL COMMENT 'Unique record ID.',
  `fname` varchar(60) DEFAULT NULL COMMENT 'First name',
  `lname` varchar(60) DEFAULT NULL COMMENT 'Last name',
  `email` varchar(60) DEFAULT NULL COMMENT 'Email',
  `login` varchar(35) NOT NULL COMMENT 'Login. Should be the users UPS ADID',
  `pw` varchar(30) NOT NULL COMMENT 'Password',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0=new/pending, 1=enabled/approved, 2=disabled/rejected',
  `access` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'User access - a bitmask integer that sums all the access rights given.',
  `created` datetime DEFAULT NULL COMMENT 'Date and Time account created.',
  `lastmod` datetime DEFAULT NULL COMMENT 'Date and time account last modified.',
  `lastip` char(15) DEFAULT NULL COMMENT 'The users last IP used when accessing their account.'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE IF NOT EXISTS `videos` (
`id` int(10) unsigned NOT NULL COMMENT 'Unique record id.',
  `title` varchar(255) NOT NULL COMMENT 'Video Title',
  `url` varchar(45) NOT NULL COMMENT 'Video URL - file name only.',
  `thumbnail` varchar(125) NOT NULL,
  `duration` varchar(255) DEFAULT NULL COMMENT 'Video duration, optional. Length of video in seconds.',
  `keywords1` varchar(255) DEFAULT NULL COMMENT 'System Keywords. Comma separated list. E.g., ngss, next gen',
  `keywords2` varchar(255) DEFAULT NULL COMMENT 'Sub Keywords. Comma separated list. E.g., camera, printer',
  `created` datetime DEFAULT NULL COMMENT 'Date and time Video was added.',
  `lastmod` datetime DEFAULT NULL COMMENT 'Date and time this record was last modified.',
  `hits` int(10) unsigned DEFAULT '0' COMMENT 'The number of times the video link was clicked for viewing.',
  `addedby_uid` int(10) unsigned DEFAULT NULL COMMENT 'The authuser.id of who added this video.',
  `editedby_uid` int(10) unsigned DEFAULT NULL COMMENT 'The authuser.id of who last edited this video.'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id`, `title`, `url`, `thumbnail`, `duration`, `keywords1`, `keywords2`, `created`, `lastmod`, `hits`, `addedby_uid`, `editedby_uid`) VALUES
(1, 'Dummy video 1', 'dummy_1.mp4', 'dummy1.jpg', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(2, 'Dummy video 2', 'dummy_2.mp4', 'dummy2.jpg', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `video_email_log`
--

CREATE TABLE IF NOT EXISTS `video_email_log` (
`id` int(10) unsigned NOT NULL COMMENT 'Unique record ID.',
  `video_id` int(10) unsigned NOT NULL COMMENT 'Video record ID',
  `sentby_uid` int(10) unsigned NOT NULL COMMENT 'The authuser.id of who sent the email.',
  `ts` datetime DEFAULT NULL COMMENT 'The datea and time the email was sent.'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `video_view_log`
--

CREATE TABLE IF NOT EXISTS `video_view_log` (
`id` int(10) unsigned NOT NULL COMMENT 'Unique record id.',
  `video_id` int(10) unsigned NOT NULL COMMENT 'Video id.',
  `ip` char(15) NOT NULL COMMENT 'Client IP - IP of who viewed the video.',
  `ts` datetime DEFAULT NULL COMMENT 'Date and time viewer clicked to view the video.'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authuser`
--
ALTER TABLE `authuser`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `login` (`login`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_email_log`
--
ALTER TABLE `video_email_log`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_view_log`
--
ALTER TABLE `video_view_log`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authuser`
--
ALTER TABLE `authuser`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Unique record ID.';
--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Unique record id.',AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `video_email_log`
--
ALTER TABLE `video_email_log`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Unique record ID.';
--
-- AUTO_INCREMENT for table `video_view_log`
--
ALTER TABLE `video_view_log`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Unique record id.';
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
