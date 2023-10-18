-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 18, 2023 at 08:28 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cmssystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE `data` (
  `sno` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `image` varchar(355) NOT NULL,
  `location` varchar(1200) NOT NULL,
  `price` int(11) NOT NULL,
  `description` varchar(2566) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data`
--

INSERT INTO `data` (`sno`, `name`, `image`, `location`, `price`, `description`, `status`) VALUES
(84, 'Uma Villa', 'images/house.jpg', 'khordha', 0, 'Constructed in 1902 by the Belgian King, Leopold II, it truly deserves its place in the list of most beautiful houses in the world list. Located at the ever-so-heavenly French Riviera, its beauty is unmatched. The Villa La Leopolda is built on land that was once owned by the Kings. The property has served as a beautiful backdrop in several notable movies, including one film by Hitchcock. The villa is built on sprawling 18 acres of land and offers a breathtaking view overlooking the beautiful verdant valley.', 'InProgress'),
(86, 'S M Villa', 'images/huose5.jpg', 'Anugul', 2147483647, 'Constructed in 1902 by the Belgian King, Leopold II, it truly deserves its place in the list of most beautiful houses in the world list. Located at the ever-so-heavenly French Riviera, its beauty is unmatched. The Villa La Leopolda is built on land that was once owned by the Kings. The property has served as a beautiful backdrop in several notable movies, including one film by Hitchcock. The villa is built on sprawling 18 acres of land and offers a breathtaking view overlooking the beautiful verdant valley.', 'Active'),
(87, 'Chiku Villa', 'images/house2.jpg', 'Bhubaneswar', 2147483647, 'Constructed in 1902 by the Belgian King, Leopold II, it truly deserves its place in the list of most beautiful houses in the world list. Located at the ever-so-heavenly French Riviera, its beauty is unmatched. The Villa La Leopolda is built on land that was once owned by the Kings. The property has served as a beautiful backdrop in several notable movies, including one film by Hitchcock. The villa is built on sprawling 18 acres of land and offers a breathtaking view overlooking the beautiful verdant valley.', '');

-- --------------------------------------------------------

--
-- Table structure for table `pdf_files`
--

CREATE TABLE `pdf_files` (
  `sno` int(11) NOT NULL,
  `file_details` text NOT NULL,
  `file_name` varchar(225) NOT NULL,
  `file_data` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `username`
--

CREATE TABLE `username` (
  `sno` int(9) NOT NULL,
  `user_email` varchar(30) NOT NULL,
  `user_pass` varchar(256) NOT NULL,
  `role` enum('user','admin') NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `username`
--

INSERT INTO `username` (`sno`, `user_email`, `user_pass`, `role`, `timestamp`) VALUES
(23, 'ab@a.com', '$2y$10$Zeok1ILlXWXhugEWPQhBzeTdOubLt5jA7Vl4IbF8ucOG0DZvtjhs6', 'admin', '2023-10-16 23:14:11'),
(24, 'ac@a.com', '$2y$10$ZHrDEBxhejUD/s3hNHXhMe7P3az4WtDUc/qwq5JqBy0NyZ0kFL.Aq', 'user', '2023-10-17 13:23:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `pdf_files`
--
ALTER TABLE `pdf_files`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `username`
--
ALTER TABLE `username`
  ADD PRIMARY KEY (`sno`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data`
--
ALTER TABLE `data`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `pdf_files`
--
ALTER TABLE `pdf_files`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `username`
--
ALTER TABLE `username`
  MODIFY `sno` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
