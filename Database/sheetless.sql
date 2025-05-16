-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2025 at 02:30 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sheetless`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `productID` varchar(30) NOT NULL,
  `productName` varchar(100) DEFAULT NULL,
  `serialNum` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sheetlesslogin`
--

CREATE TABLE `sheetlesslogin` (
  `accountID` int(11) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `userPassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sheetlesslogin`
--

INSERT INTO `sheetlesslogin` (`accountID`, `userName`, `userPassword`) VALUES
(1, 'admin', '$2y$10$yMs.7PlHx6wBm0ZAWPFLieypNR8vBoy0DsV94/i.dXdIPtQSq0ZgW'),
(2, 'user', '$2y$10$M5IYGS532NqAgFnAtK/Pq.q7msNYkfbDP4H5uxg2Ioxu6PpU/X3mW');

-- --------------------------------------------------------

--
-- Table structure for table `traveler_data`
--

CREATE TABLE `traveler_data` (
  `id` int(11) NOT NULL,
  `date_submitted` timestamp NOT NULL DEFAULT current_timestamp(),
  `step_1` varchar(255) DEFAULT NULL,
  `step_2` varchar(255) DEFAULT NULL,
  `step_3` varchar(255) DEFAULT NULL,
  `step_4` varchar(255) DEFAULT NULL,
  `step_5` varchar(255) DEFAULT NULL,
  `step_6` varchar(255) DEFAULT NULL,
  `step_7` varchar(255) DEFAULT NULL,
  `step_8` varchar(255) DEFAULT NULL,
  `step_9` varchar(255) DEFAULT NULL,
  `step_10` varchar(255) DEFAULT NULL,
  `step_11` varchar(255) DEFAULT NULL,
  `step_12` varchar(255) DEFAULT NULL,
  `step_13` varchar(255) DEFAULT NULL,
  `step_14` varchar(255) DEFAULT NULL,
  `step_15` varchar(255) DEFAULT NULL,
  `step_16` varchar(255) DEFAULT NULL,
  `step_17` varchar(255) DEFAULT NULL,
  `step_18` varchar(255) DEFAULT NULL,
  `step_19` varchar(255) DEFAULT NULL,
  `step_20` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `traveler_data2`
--

CREATE TABLE `traveler_data2` (
  `id` int(11) NOT NULL,
  `date_submitted` datetime DEFAULT NULL,
  `step_21` text DEFAULT NULL,
  `step_22` text DEFAULT NULL,
  `step_23` text DEFAULT NULL,
  `step_24` text DEFAULT NULL,
  `step_25` text DEFAULT NULL,
  `step_26` text DEFAULT NULL,
  `step_27` text DEFAULT NULL,
  `step_28` text DEFAULT NULL,
  `step_29` text DEFAULT NULL,
  `step_30` text DEFAULT NULL,
  `step_31` text DEFAULT NULL,
  `step_32` text DEFAULT NULL,
  `step_33` text DEFAULT NULL,
  `step_34` text DEFAULT NULL,
  `step_35` text DEFAULT NULL,
  `step_36` text DEFAULT NULL,
  `step_37` text DEFAULT NULL,
  `step_38` text DEFAULT NULL,
  `step_39` text DEFAULT NULL,
  `step_40` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD UNIQUE KEY `productID` (`productID`);

--
-- Indexes for table `sheetlesslogin`
--
ALTER TABLE `sheetlesslogin`
  ADD PRIMARY KEY (`accountID`),
  ADD UNIQUE KEY `userName` (`userName`);

--
-- Indexes for table `traveler_data`
--
ALTER TABLE `traveler_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `traveler_data2`
--
ALTER TABLE `traveler_data2`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sheetlesslogin`
--
ALTER TABLE `sheetlesslogin`
  MODIFY `accountID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `traveler_data`
--
ALTER TABLE `traveler_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `traveler_data2`
--
ALTER TABLE `traveler_data2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
