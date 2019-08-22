-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 22, 2019 at 03:35 PM
-- Server version: 10.1.8-MariaDB
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `highway`
--

-- --------------------------------------------------------

--
-- Table structure for table `highway_activity`
--

CREATE TABLE `highway_activity` (
  `id` int(11) NOT NULL,
  `memberId` varchar(35) DEFAULT NULL,
  `roadId` int(11) DEFAULT NULL,
  `roadType` varchar(100) DEFAULT NULL,
  `time` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `highway_balance`
--

CREATE TABLE `highway_balance` (
  `id` varchar(50) NOT NULL,
  `balance` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `highway_balance`
--

INSERT INTO `highway_balance` (`id`, `balance`) VALUES
('boypanjaitan16', 233000);

-- --------------------------------------------------------

--
-- Table structure for table `highway_member`
--

CREATE TABLE `highway_member` (
  `id` varchar(35) NOT NULL,
  `token` text,
  `name` varchar(50) DEFAULT NULL,
  `password` varchar(35) DEFAULT NULL,
  `phone` varchar(35) DEFAULT NULL,
  `email` varchar(35) DEFAULT NULL,
  `address` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `highway_member`
--

INSERT INTO `highway_member` (`id`, `token`, `name`, `password`, `phone`, `email`, `address`) VALUES
('boypanjaitan16', NULL, 'Boy Panjaitan', 'mypass', '082361697961', 'boypanjaitan16@yahoo.com', NULL),
('habib', NULL, 'Khalid Habib', 'mypass', '082361697961', 'boypanjaitan16@yahoo.com', NULL),
('junaidi', NULL, 'Junaidi', 'mypass', '082361697961', 'boypanjaitan16@yahoo.com', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `highway_outgate`
--

CREATE TABLE `highway_outgate` (
  `id` int(11) NOT NULL,
  `road` int(11) DEFAULT NULL,
  `name` text,
  `distance` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `highway_outgate`
--

INSERT INTO `highway_outgate` (`id`, `road`, `name`, `distance`, `price`) VALUES
(3, 7, 'B-1', 45, 790000),
(4, 7, 'B-8', 78, 90000),
(11, 6, 'A-1', 45, 56000),
(12, 6, 'A-3', 23, 24000);

-- --------------------------------------------------------

--
-- Table structure for table `highway_road`
--

CREATE TABLE `highway_road` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `distance` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `highway_road`
--

INSERT INTO `highway_road` (`id`, `name`, `distance`, `price`) VALUES
(6, 'TOL AZ', NULL, NULL),
(7, 'TOL B', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `highway_topup`
--

CREATE TABLE `highway_topup` (
  `id` int(11) NOT NULL,
  `memberId` varchar(35) DEFAULT NULL,
  `nominal` bigint(20) DEFAULT NULL,
  `time` varchar(11) DEFAULT NULL,
  `status` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `highway_topup`
--

INSERT INTO `highway_topup` (`id`, `memberId`, `nominal`, `time`, `status`) VALUES
(1, 'boypanjaitan16', 60000, '1529634740', 1),
(2, 'boypanjaitan16', 60000, '1529698632', 1),
(3, 'boypanjaitan16', 60000, '1529698632', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `highway_activity`
--
ALTER TABLE `highway_activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `highway_balance`
--
ALTER TABLE `highway_balance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `highway_member`
--
ALTER TABLE `highway_member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `highway_outgate`
--
ALTER TABLE `highway_outgate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `highway_road`
--
ALTER TABLE `highway_road`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `highway_topup`
--
ALTER TABLE `highway_topup`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `highway_activity`
--
ALTER TABLE `highway_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `highway_outgate`
--
ALTER TABLE `highway_outgate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `highway_road`
--
ALTER TABLE `highway_road`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `highway_topup`
--
ALTER TABLE `highway_topup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
