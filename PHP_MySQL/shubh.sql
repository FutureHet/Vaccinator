-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2021 at 03:07 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shubh`
--

-- --------------------------------------------------------

--
-- Table structure for table `aadhar_info`
--

CREATE TABLE `aadhar_info` (
  `aadhar_number` bigint(20) NOT NULL,
  `status` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `aadhar_info`
--

INSERT INTO `aadhar_info` (`aadhar_number`, `status`) VALUES
(111111111111, 'o'),
(222222222222, 'f'),
(333333333333, 'f'),
(444444444444, 'f'),
(555555555555, 'f'),
(666666666666, 'f'),
(777777777777, 'f'),
(888888888888, 'f'),
(999999999999, 'f');

-- --------------------------------------------------------

--
-- Table structure for table `vac_center`
--

CREATE TABLE `vac_center` (
  `vac_center_id` int(11) NOT NULL,
  `vac_center_name` varchar(100) NOT NULL,
  `vac_dose` int(11) NOT NULL,
  `vac_center_pincode` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vac_center`
--

INSERT INTO `vac_center` (`vac_center_id`, `vac_center_name`, `vac_dose`, `vac_center_pincode`) VALUES
(1, 'Ahmedabad', 98, 380061),
(2, 'Vadodara', 79, 390061),
(3, 'Gandhinagar', 70, 370061),
(4, 'Dwarka', 20, 312461),
(5, 'Bhavnagar', 0, 341261);

-- --------------------------------------------------------

--
-- Table structure for table `vac_user`
--

CREATE TABLE `vac_user` (
  `id_proof` varchar(20) DEFAULT NULL,
  `id_number` bigint(20) NOT NULL,
  `user_name` varchar(30) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `birth_year` int(11) DEFAULT NULL,
  `ref_id` bigint(20) DEFAULT NULL,
  `sec_code` int(11) DEFAULT NULL,
  `phone_no` bigint(12) DEFAULT NULL,
  `dose_1_taken` varchar(1) NOT NULL DEFAULT 'r',
  `dose_1_center` int(11) DEFAULT NULL,
  `dose_1_date` varchar(25) DEFAULT NULL,
  `dose_2_taken` varchar(1) NOT NULL DEFAULT 'r',
  `dose_2_center` int(11) DEFAULT NULL,
  `dose_2_date` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vac_user`
--

INSERT INTO `vac_user` (`id_proof`, `id_number`, `user_name`, `gender`, `birth_year`, `ref_id`, `sec_code`, `phone_no`, `dose_1_taken`, `dose_1_center`, `dose_1_date`, `dose_2_taken`, `dose_2_center`, `dose_2_date`) VALUES
('Aadhar Card', 111111111111, 'Shivansh', 'male', 2001, 13881634375240, 5240, 919099989065, 't', 1, '20 November 2021', 't', 2, '20 November 2021');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aadhar_info`
--
ALTER TABLE `aadhar_info`
  ADD PRIMARY KEY (`aadhar_number`);

--
-- Indexes for table `vac_center`
--
ALTER TABLE `vac_center`
  ADD PRIMARY KEY (`vac_center_id`);

--
-- Indexes for table `vac_user`
--
ALTER TABLE `vac_user`
  ADD PRIMARY KEY (`id_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `vac_center`
--
ALTER TABLE `vac_center`
  MODIFY `vac_center_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
