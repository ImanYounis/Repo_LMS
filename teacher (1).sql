-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 02, 2023 at 07:12 PM
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
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `EmailID` varchar(60) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Password` varchar(40) NOT NULL,
  `ContactNo` varchar(30) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `Education` text NOT NULL,
  `Experience` text NOT NULL,
  `Pic` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`EmailID`, `Name`, `Password`, `ContactNo`, `Address`, `Education`, `Experience`, `Pic`) VALUES
('iman_2003@teacher.com', 'iman teacher', 'iman2003', '03123456789', 'test colony, street 2, house no abc', 'bsse', 'askaria intern', 'haxm link.txt'),
('iman_2003@teacher2.com', 'iman teacher2', 'iman2003', '03123456789', '', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`EmailID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
