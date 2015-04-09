-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 01, 2012 at 12:02 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.6-1ubuntu1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `teamcode`
--

-- --------------------------------------------------------

--
-- Table structure for table `contests`
--

CREATE TABLE IF NOT EXISTS `contests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `start` varchar(255) NOT NULL,
  `end` varchar(255) NOT NULL,
  `teacher_id` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `contests`
--

INSERT INTO `contests` (`id`, `title`, `start`, `end`, `teacher_id`) VALUES
(15, 'My first contest', '1351548000', '1351843200', 7);

-- --------------------------------------------------------

--
-- Table structure for table `judge`
--

CREATE TABLE IF NOT EXISTS `judge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `submission_id` int(11) NOT NULL,
  `test` int(9) NOT NULL,
  `result` varchar(255) NOT NULL,
  `time` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=73 ;

--
-- Dumping data for table `judge`
--

INSERT INTO `judge` (`id`, `submission_id`, `test`, `result`, `time`) VALUES
(17, 36, 1, 'Correct', '0.005'),
(18, 36, 2, 'Correct', '0.005'),
(19, 36, 3, 'Correct', '0.006'),
(20, 36, 4, 'Wrong answer', '0.006'),
(21, 35, 1, 'Correct', '0.005'),
(22, 35, 2, 'Correct', '0.003'),
(23, 35, 3, 'Correct', '0.005'),
(24, 35, 4, 'Correct', '0.006'),
(25, 37, 1, 'Correct', '0.003'),
(26, 37, 2, 'Correct', '0.003'),
(27, 37, 3, 'Correct', '0.003'),
(28, 37, 4, 'Wrong answer', '0.003'),
(29, 38, 1, 'No output file', '-159.163'),
(30, 38, 2, 'No output file', '-159.19'),
(31, 39, 1, 'No output file', '0.005'),
(32, 39, 2, 'No output file', '0.005'),
(33, 39, 3, 'No output file', '0.005'),
(34, 39, 4, 'No output file', '0.004'),
(35, 40, 1, 'No output file', '0.002'),
(36, 40, 2, 'No output file', '0.003'),
(37, 40, 3, 'No output file', '0.006'),
(38, 40, 4, 'No output file', '0.006'),
(39, 41, 1, 'No output file', '0.003'),
(40, 41, 2, 'No output file', '0.003'),
(41, 41, 3, 'No output file', '0.005'),
(42, 41, 4, 'No output file', '0.005'),
(57, 42, 1, 'Correct', '0.006'),
(58, 42, 2, 'Correct', '0.005'),
(59, 43, 1, 'No output file', '0.002'),
(60, 43, 2, 'No output file', '0.003'),
(61, 43, 3, 'No output file', '0.005'),
(62, 43, 4, 'No output file', '0.006'),
(63, 44, 1, 'Correct', '0.002'),
(64, 44, 2, 'Correct', '0.005'),
(65, 45, 1, 'No output file', '0.004'),
(66, 45, 2, 'No output file', '0.004'),
(67, 45, 3, 'No output file', '0.002'),
(68, 45, 4, 'No output file', '0.002'),
(69, 46, 1, 'No output file', '0.002'),
(70, 46, 2, 'No output file', '0.003'),
(71, 46, 3, 'No output file', '0.005'),
(72, 46, 4, 'No output file', '0.006');

-- --------------------------------------------------------

--
-- Table structure for table `jury`
--

CREATE TABLE IF NOT EXISTS `jury` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `class` int(11) NOT NULL,
  `active` int(2) NOT NULL,
  `accesskey` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `jury`
--

INSERT INTO `jury` (`id`, `login`, `name`, `surname`, `email`, `pass`, `tel`, `class`, `active`, `accesskey`) VALUES
(7, 'x3medima17', 'Dima', 'Savva', 'namtab@list.ru', 'salapia', '067209090', 1, 1, 'f49d4d81577b146fe4187f15a222cf25'),
(8, 'Gluck', 'Roman', 'Gluck', 'ghicaroman@gmail.com', 'a524', '37369094771', 1, 1, '0d534beb22519da42656951b0cf794f7');

-- --------------------------------------------------------

--
-- Table structure for table `problems`
--

CREATE TABLE IF NOT EXISTS `problems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `timelimit` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `script` int(11) NOT NULL,
  `contest_id` int(7) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `testcases` int(5) NOT NULL,
  `test_info` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;

--
-- Dumping data for table `problems`
--

INSERT INTO `problems` (`id`, `title`, `timelimit`, `text`, `script`, `contest_id`, `teacher_id`, `testcases`, `test_info`) VALUES
(55, 'ab', '0.2', 'Here is 2 numbers given\r\nYou need to calculate the sum.', 0, 15, 7, 4, '{"1":0,"2":40,"3":25,"4":35}'),
(56, 'sum', '1', '', 1, 15, 7, 2, '{"1":0,"2":100}');

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE IF NOT EXISTS `submissions` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `problem_id` int(12) NOT NULL,
  `user_id` int(12) NOT NULL,
  `lang` varchar(10) NOT NULL,
  `contest_id` int(9) NOT NULL,
  `result` text NOT NULL,
  `total` int(5) NOT NULL,
  `time` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

--
-- Dumping data for table `submissions`
--

INSERT INTO `submissions` (`id`, `problem_id`, `user_id`, `lang`, `contest_id`, `result`, `total`, `time`) VALUES
(35, 55, 4, 'pas', 15, 'Correct', 100, '1351722558'),
(36, 55, 4, 'pas', 15, 'Correct', 65, '1351723087'),
(37, 55, 4, 'pas', 15, 'Correct', 65, '1351726384'),
(38, 56, 4, 'pas', 15, 'No output file', 0, '1351726543'),
(39, 55, 4, 'pas', 15, 'No output file', 0, '1351726584'),
(40, 55, 4, 'pas', 15, 'No output file', 0, '1351726633'),
(41, 55, 4, 'pas', 15, 'No output file', 0, '1351726781'),
(42, 56, 4, 'pas', 15, 'Correct', 100, '1351726793'),
(43, 55, 4, 'pas', 15, 'No output file', 0, '1351727422'),
(44, 56, 4, 'pas', 15, 'Correct', 100, '1351727429'),
(45, 55, 4, 'pas', 15, 'No output file', 0, '1351727452'),
(46, 55, 4, 'pas', 15, 'No output file', 0, '1351727463');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `school` varchar(255) NOT NULL,
  `accesskey` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `login`, `pass`, `teacher_id`, `school`, `accesskey`, `email`) VALUES
(4, 'Dima', 'Savva', 'x3medima17', 'salapia', 7, 'Orizont', 'cacacde5bbabf56894c52fbe6456a55b', 'namtab@list.ru');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
