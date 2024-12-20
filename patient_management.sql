-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2024 at 06:41 AM
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
-- Database: `patient_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `accont_patients`
--

CREATE TABLE `accont_patients` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `billings`
--

CREATE TABLE `billings` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `billing` date DEFAULT NULL,
  `status` enum('paid','unpaid') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `billings`
--

INSERT INTO `billings` (`id`, `patient_id`, `amount`, `billing`, `status`) VALUES
(101, 1001, 2500.00, '2024-12-18', 'paid'),
(102, 1002, 60000.00, '2028-12-08', 'unpaid'),
(103, 1003, 12000.00, '2024-12-25', 'unpaid'),
(104, 1004, 2000.00, '2024-12-18', 'paid'),
(105, 1005, 40000.00, '2025-12-12', 'paid');

-- --------------------------------------------------------

--
-- Table structure for table `medical_records`
--

CREATE TABLE `medical_records` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `diagnosis` varchar(100) DEFAULT NULL,
  `treatment` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medical_records`
--

INSERT INTO `medical_records` (`id`, `patient_id`, `diagnosis`, `treatment`) VALUES
(101, 1001, 'bird flu', 'rest'),
(102, 1002, 'covid-69', 'kiss '),
(103, 1003, 'cancer ', 'operation'),
(104, 1004, 'flu', 'rest'),
(105, 1005, 'depression', 'therapist');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `first_name`, `last_name`, `date_of_birth`, `gender`, `address`) VALUES
(101, 'christian', 'ibanez', '2015-04-26', 'male', 'blk 17'),
(102, 'leandro', 'diolola', '2024-02-20', 'male', 'batumbakal st.'),
(103, 'krenz', 'ocampo', '2024-07-15', 'male', 'san juan st.'),
(104, 'kevin', 'dulay', '2024-08-10', 'male', 'subic'),
(105, 'czarina', 'salem', '2014-12-15', 'female', 'angels valley'),
(107, 'mica ', 'palabrica ', '2014-05-30', 'female', 'davao');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accont_patients`
--
ALTER TABLE `accont_patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `password` (`password`);

--
-- Indexes for table `billings`
--
ALTER TABLE `billings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medical_records`
--
ALTER TABLE `medical_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accont_patients`
--
ALTER TABLE `accont_patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `billings`
--
ALTER TABLE `billings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `medical_records`
--
ALTER TABLE `medical_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
