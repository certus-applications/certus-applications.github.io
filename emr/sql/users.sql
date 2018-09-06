-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2018 at 01:00 AM
-- Server version: 5.7.19
-- PHP Version: 7.0.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `certus`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(254) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, '127.0.0.1', 'administrator', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', '', 'admin@admin.com', '', NULL, NULL, NULL, 1268889823, 1535638008, 1, 'Admin', 'istrator', 'ADMIN', '0'),
(2, '127.0.0.1', 'jas.lamba@certusapplication.ca', '$2y$08$LJqNblxnGFGW05wNtk9mJu8yMwkJD0SXYjLnvPIIFtAh5YxXDAps2', NULL, 'jas.lamba@certusapplication.ca', NULL, NULL, NULL, NULL, 1535638078, 1536098136, 1, 'Jaskiran', 'Lamba', 'Certus', '6474096157'),
(3, '127.0.0.1', 'sandeep.suri@certusapplication.ca', '$2y$08$q2Y1YdroiS/I/dBNk9tGxOioWrfBHSiCMrCNuee042wKmtlGmE02u', NULL, 'sandeep.suri@certusapplication.ca', NULL, NULL, NULL, NULL, 1535638158, NULL, 1, 'Sandeep', 'Suri', 'Certus', '‭6477840040‬'),
(4, '127.0.0.1', 'sunny.suri@gmail.com', '$2y$08$S5ktQcv2GeqHhvbXqmsSxeKhoAc4055UVkB66hzRsMvlYNKJfp9Zm', NULL, 'sunny.suri@gmail.com', NULL, NULL, NULL, NULL, 1535670538, 1536270045, 1, 'Sunny', 'Suri', 'Certus', '123456'),
(5, '127.0.0.1', 'test@test.ca', '$2y$08$56AjCucwexNqraFyR.Jy9eIj4YMTB97lddC7xsYWe9BrZ.o8N.7ry', NULL, 'test@test.ca', NULL, NULL, NULL, NULL, 1536098199, 1536099459, 1, 'test', 'test', 'test', '123456');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
