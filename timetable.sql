-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 02, 2023 at 07:11 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `timetable`
--

CREATE TABLE `timetable` (
  `id` int(11) NOT NULL,
  `day` varchar(20) DEFAULT NULL,
  `timeslot` varchar(30) DEFAULT NULL,
  `subject` varchar(60) DEFAULT NULL,
  `teacher` varchar(60) DEFAULT NULL,
  `class` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timetable`
--

INSERT INTO `timetable` (`id`, `day`, `timeslot`, `subject`, `teacher`, `class`) VALUES
(1, 'mon', '1st', 'science', 'iman_2003@teacher.com', '6th'),
(2, 'tue', '3rd', 'computerScience', 'iman_2003@teacher2.com', '9th'),
(4, 'wed', '4th', 'mathematics', 'iman_2003@teacher.com', '10th'),
(5, 'thu', '4th', 'biology', 'iman_2003@teacher.com', '2nd year'),
(6, 'fri', '5th', 'islamiat', 'iman_2003@teacher2.com', '8th'),
(11, 'mon', '3rd', 'urdu', 'iman_2003@teacher.com', '10th'),
(12, 'tue', '1st', 'english', 'iman_2003@teacher2.com', '1st year'),
(13, 'mon', '1st', 'islamiat', 'iman_2003@teacher2.com', '7th');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `timetable`
--
ALTER TABLE `timetable`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_timetable` (`day`,`timeslot`,`class`),
  ADD UNIQUE KEY `unique_teacher_timeslot` (`teacher`,`day`,`timeslot`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `timetable`
--
ALTER TABLE `timetable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
