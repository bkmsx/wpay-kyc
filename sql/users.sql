-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 14, 2018 at 04:57 AM
-- Server version: 10.1.33-MariaDB
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wpay`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `date_birth` varchar(45) DEFAULT NULL,
  `citizenship` varchar(45) DEFAULT NULL,
  `country` varchar(40) DEFAULT NULL,
  `passport_location` varchar(45) DEFAULT NULL,
  `date` datetime NOT NULL,
  `status` varchar(45) NOT NULL,
  `row_number` int(11) NOT NULL,
  `wallet_address` varchar(255) NOT NULL,
  `token_number` int(11) NOT NULL DEFAULT '0',
  `utm_source` varchar(50) NOT NULL,
  `click_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `first_name`, `last_name`, `date_birth`, `citizenship`, `country`, `passport_location`, `date`, `status`, `row_number`, `wallet_address`, `token_number`, `utm_source`, `click_id`) VALUES
(396, 'tien@novum.capital', '$2y$10$XzrlFmeP9B6KfFMU43IkHe6gcOV/vC6DjOBgLCr4vUqf2sB.5OvZC', 'trung', 'tien', '02/12/1990', 'ABKHAZIAN', 'ABKHAZIA', 'files/1531495485.png', '2018-07-13 22:07:43', 'CLEARED', 2, '0xFAF31560d94E7dDE9098dC99B3419b927b87bC5F', 4280, '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=397;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
