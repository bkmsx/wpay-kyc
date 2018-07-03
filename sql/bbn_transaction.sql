-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 03, 2018 at 02:10 PM
-- Server version: 5.5.59-cll
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `makeacha_beepbeepnation`
--

-- --------------------------------------------------------

--
-- Table structure for table `bbn_transaction`
--

CREATE TABLE `bbn_transaction` (
  `transaction_id` int(11) NOT NULL,
  `user_email` varchar(45) NOT NULL,
  `currency` varchar(45) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `consentium_amount` float DEFAULT NULL,
  `consentium_bonus` float DEFAULT NULL,
  `conversion_rate` float DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bbn_transaction`
--

INSERT INTO `bbn_transaction` (`transaction_id`, `user_email`, `currency`, `amount`, `address`, `consentium_amount`, `consentium_bonus`, `conversion_rate`, `status`, `date`) VALUES
(117, 'solobis_clara@yahoo.com', 'USD', 250, '0x709Fc0Dd57D287966b21B5300aEdEB6475E46e92', 1000, 50, 0.25, 'Confirmed', '2018-06-26 07:37:27'),
(118, 'irwin@novum.capital', 'ETH', 2.21339, '0x7a18893Af9a7ec7B0b23A5094088bB6279Ee453F', 4000, 200, 0.000553348, 'Confirmed', '2018-06-26 09:30:46'),
(119, 'irwin@novum.capital', 'USD', 1000, '0x7a18893Af9a7ec7B0b23A5094088bB6279Ee453F', 4000, 200, 0.25, 'Canceled', '2018-06-26 09:32:42'),
(120, 'shauntan3@gmail.com', 'USD', 1000, '0xEfC56c90e66Ae35EdAc151dA6cD8393C519bbe67', 4000, 200, 0.25, 'Waiting', '2018-06-26 16:17:50'),
(121, 'inranzx7@gmail.com', 'ETH', 2.3167, '0x3b3346852F61357bca8B596c6A2b89B08CaA742a', 4000, 200, 0.000579174, 'Canceled', '2018-06-27 05:01:51'),
(122, 'gutsulyak_ie@mail.ru', 'USD', 1000, '0xdD5C4Ba7bD2dD68412Bc4067b91538C31B5303ab', 4000, 200, 0.25, 'Waiting', '2018-06-28 12:17:11'),
(123, 'mrsatrio@yahoo.com', 'ETH', 2.39633, '0x7597104F5D2fe7C834954fC5B41Ef54eB67D2591', 4000, 200, 0.000599084, 'Canceled', '2018-06-29 09:53:26'),
(124, 'mrsatrio@yahoo.com', 'ETH', 2.39633, '0x7597104F5D2fe7C834954fC5B41Ef54eB67D2591', 4000, 200, 0.000599084, 'Canceled', '2018-06-29 09:53:53'),
(125, 'x.faith.yah@gmail.com', 'USD', 1000, '0x607cFD00168F5f68E9935F0D1c47600b83C80001', 4000, 200, 0.25, 'Waiting', '2018-07-01 14:53:14'),
(126, 'x.faith.yah@gmail.com', 'USD', 1000, '0x607cFD00168F5f68E9935F0D1c47600b83C80001', 4000, 200, 0.25, 'Waiting', '2018-07-01 15:11:13'),
(127, '6maghor9@gmail.com', 'USD', 6250, '0x012f7dbc78480de85562a2036ca4dd1a82d25ae5', 25000, 1250, 0.25, 'Waiting', '2018-07-03 02:24:04'),
(128, '', '', 0, '', 0, 0, 0, 'Waiting', '2018-07-03 02:24:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bbn_transaction`
--
ALTER TABLE `bbn_transaction`
  ADD PRIMARY KEY (`transaction_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bbn_transaction`
--
ALTER TABLE `bbn_transaction`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
