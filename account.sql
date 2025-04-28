-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2025 at 05:48 PM
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
-- Database: `account`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(55) NOT NULL,
  `name` varchar(55) NOT NULL,
  `age` int(3) NOT NULL,
  `time` time NOT NULL,
  `date` date NOT NULL,
  `massage_type` varchar(55) NOT NULL,
  `branch` varchar(55) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` varchar(55) NOT NULL,
  `concern` varchar(55) NOT NULL,
  `suggestion` varchar(55) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `name`, `age`, `time`, `date`, `massage_type`, `branch`, `email`, `status`, `concern`, `suggestion`, `user_id`) VALUES
(24, 'dwadawd', 2131, '21:33:00', '2025-04-09', 'dwdawdaw', 'Cavite', 'shou@gmail.com', 'Accepted', 'adwadawda', 'adwadawdsd', 1),
(28, 'asdwdad', 23, '22:51:00', '2025-04-13', 'dwadsdwad', 'Alabang', 'lledo@gmail.com', '', 'asdawdsadsdw', 'dawdasdwadawd', 9),
(29, 'awdadawd', 2312, '23:06:00', '2025-04-09', 'awdawadwad', 'Pampanga', 'yuan@gmail.com', '', 'asdadawdasdad', 'awdawadawdaw', 8);

-- --------------------------------------------------------

--
-- Table structure for table `useraccount`
--

CREATE TABLE `useraccount` (
  `id` int(55) NOT NULL,
  `email` varchar(55) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `age` int(2) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` varchar(10) NOT NULL,
  `profile_picture` varchar(255) DEFAULT 'IMAGES/default_profile.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `useraccount`
--

INSERT INTO `useraccount` (`id`, `email`, `contact`, `age`, `name`, `password`, `usertype`, `profile_picture`) VALUES
(8, 'yuan@gmail.com', '4356234', 34324, 'asdwdr23', '$2y$10$AaMhD/P9OZqji8NLKS3wUOHSOOFvHDfEuDs4z3D94St6REmhdj0Vq', 'admin', 'IMAGES/default_profile.png'),
(9, 'lledo@gmail.com', '2134124324', 232, 'sadw', '$2y$10$bz1d38axGxceoGpCV5jcHuSwJt3tbjH79Ba6fb2g9BkYRO9v9NVZW', '', 'uploads/680fa27e28d17.jpg'),
(10, 'shou@gmail.com', '', 0, '', '$2y$10$49gI2e26QSrEzg/6bphHUO2gSxjcn6wvOqswdio92sSf/CAOfUX1S', '', 'IMAGES/default_profile.png'),
(11, 'leah@gmail.com', '', 0, '', '$2y$10$HnBHiH8uUcmQIHAgnFtOQ.mnt9eTMAXfCQ1T2yKSRtRWm5Ygw9iyO', '', 'IMAGES/default_profile.png'),
(12, 'mico@gmail.com', '12435234', 17, 'bai', '$2y$10$H241.nzrkzT.tKdsLMPnteSKZogDzMQd48MTLpWzQW7L8Pdpgc01K', '', 'uploads/680fa2e8494af.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `useraccount`
--
ALTER TABLE `useraccount`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(55) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `useraccount`
--
ALTER TABLE `useraccount`
  MODIFY `id` int(55) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
