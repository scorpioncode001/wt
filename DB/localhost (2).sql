-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 29, 2019 at 11:56 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wt_western_trade`
--
CREATE DATABASE IF NOT EXISTS `wt_western_trade` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `wt_western_trade`;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `continent` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `zip` varchar(50) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `last_logged` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `fname`, `lname`, `email`, `phone`, `continent`, `country`, `zip`, `pass`, `image`, `status`, `created`, `updated`, `last_logged`) VALUES
(1, 'Akubue', 'Augustus', 'augustus1.akubue.237434@unn.edu.ng', '08081301064', '', 'NG', '1235', 'e10adc3949ba59abbe56e057f20f883e', 'default.jpg', 1, '2019-06-17 16:05:28', '2019-06-18 14:26:54', '2019-11-07 03:29:10');

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fb` varchar(50) NOT NULL,
  `wa` varchar(50) NOT NULL,
  `tw` varchar(50) NOT NULL,
  `bonus` int(11) NOT NULL,
  `members` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`id`, `user_id`, `fb`, `wa`, `tw`, `bonus`, `members`, `status`, `created`) VALUES
(1, 1, 'Akubue Augustus', '+2348081301064', '@shadowalkerOfficial ', 10, 1, 1, '2019-11-06 22:31:02');

-- --------------------------------------------------------

--
-- Table structure for table `agent_pay`
--

CREATE TABLE `agent_pay` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `payment_type` varchar(50) NOT NULL,
  `amount` int(11) NOT NULL,
  `details` varchar(225) NOT NULL,
  `requested` datetime NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `agent_pay`
--

INSERT INTO `agent_pay` (`id`, `user_id`, `payment_type`, `amount`, `details`, `requested`, `status`) VALUES
(2, 1, 'Bank Payment', 0, '\n        Bank Name: Zenith Bank\n        Account Name: Akubue Augustus\n        Account Number: 2120512300\n        ', '2019-11-06 23:10:48', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bonus`
--

CREATE TABLE `bonus` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `inv_id` int(11) NOT NULL,
  `inv_type` varchar(100) NOT NULL,
  `bonus` varchar(100) NOT NULL,
  `main_bonus` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `w_status` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `default_bonus` varchar(100) NOT NULL,
  `kill_status` int(11) NOT NULL,
  `activate` int(11) NOT NULL,
  `cashed_out` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bonus`
--

INSERT INTO `bonus` (`id`, `user_id`, `inv_id`, `inv_type`, `bonus`, `main_bonus`, `status`, `w_status`, `date`, `default_bonus`, `kill_status`, `activate`, `cashed_out`) VALUES
(1, 1, 1, 'Paystack', '0', '0', 0, 0, '2019-11-06 22:04:11', '10', 0, 0, '0'),
(2, 1, 2, 'Bitcoin', '0', '0', 0, 0, '2019-11-06 22:30:03', '10', 0, 0, '0'),
(3, 2, 3, 'Paystack', '0', '0', 0, 0, '2019-11-06 22:46:57', '10', 0, 0, '0');

-- --------------------------------------------------------

--
-- Table structure for table `contact_admins`
--

CREATE TABLE `contact_admins` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` varchar(225) NOT NULL,
  `sender` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `topic` varchar(100) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `contact_response`
--

CREATE TABLE `contact_response` (
  `id` int(11) NOT NULL,
  `contact_admin_msg_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `message` varchar(225) NOT NULL,
  `status` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact_response`
--

INSERT INTO `contact_response` (`id`, `contact_admin_msg_id`, `user_id`, `admin_id`, `message`, `status`, `created`) VALUES
(1, 0, 1, 0, '\n                Account Credit from Paystack transaction <br>\n                Amount: $100 <br>\n                Balance: $100\n                ', 1, '2019-11-07 03:09:54'),
(2, 0, 1, 0, '\n              Account Credit from Bitcoin transaction <br>\n              Amount: $100 <br>\n              Balance: $200\n              ', 1, '2019-11-07 03:31:53'),
(3, 0, 1, 0, '\n                      Account Credit from Agent transaction <br>\n                      Amount: $5 <br>\n                      Agent Balance: $5\n                      ', 1, '2019-11-07 03:49:42'),
(4, 0, 2, 0, '\n                Account Credit from Paystack transaction <br>\n                Amount: $100 <br>\n                Balance: $100\n                ', 1, '2019-11-07 03:47:28'),
(5, 0, 1, 0, '\n          Agent Bonus Payment Completed<br>\n          Amount: $0 <br>\n          Agent Balance: $0\n          ', 1, '2019-11-07 04:12:35'),
(6, 0, 1, 0, '\n        Agent Bonus Payment Completed<br>\n        Amount: $0 <br>\n        Agent Balance: $0\n        ', 1, '2019-11-07 04:16:50'),
(7, 0, 1, 0, '\n        Agent Bonus Payment Completed<br>\n        Amount: $0 <br>\n        Agent Balance: $0\n        ', 1, '2019-11-07 04:17:55'),
(8, 0, 1, 0, '\n        Agent Bonus Payment Completed<br>\n        Amount: $0 <br>\n        Agent Balance: $0\n        ', 1, '2019-11-07 04:28:16'),
(9, 0, 1, 0, '\n        Agent Bonus Payment Completed<br>\n        Amount: $10 <br>\n        Agent Balance: $0\n        ', 1, '2019-11-07 04:25:18'),
(10, 0, 1, 0, '\n        Agent Bonus Payment Completed<br>\n        Amount: $0 <br>\n        Agent Balance: $0\n        ', 1, '2019-11-07 04:28:23'),
(11, 0, 1, 0, '\n        Agent Bonus Payment Completed<br>\n        Amount: $0 <br>\n        Agent Balance: $0\n        ', 1, '2019-11-07 04:28:27');

-- --------------------------------------------------------

--
-- Table structure for table `ecnalab`
--

CREATE TABLE `ecnalab` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ecnalab` varchar(225) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ecnalab`
--

INSERT INTO `ecnalab` (`id`, `user_id`, `ecnalab`, `updated`) VALUES
(1, 1, '200', '2019-11-07 03:30:03'),
(2, 2, '100', '2019-11-07 03:46:58');

-- --------------------------------------------------------

--
-- Table structure for table `invested`
--

CREATE TABLE `invested` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `invest_type` varchar(100) NOT NULL,
  `reference` varchar(100) NOT NULL,
  `paidAt` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `w_status` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `equivalent_btc` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invested`
--

INSERT INTO `invested` (`id`, `user_id`, `full_name`, `email`, `amount`, `invest_type`, `reference`, `paidAt`, `status`, `w_status`, `created`, `equivalent_btc`) VALUES
(1, 1, 'Akubue Augustus', 'augustus.akubue.237434@unn.edu.ng', '100', 'Paystack', 'T670788085711634', '2019-11-07T03:04:08.000Z', 1, 0, '2019-11-07 03:04:11', ''),
(2, 1, 'Akubue Augustus', 'augustus.akubue.237434@unn.edu.ng', '100', 'Bitcoin', '1234567890ac', '2019-11-06 22:26:21', 1, 0, '2019-11-07 03:30:03', '0.0107600969'),
(3, 2, 'Akubue Augustus', 'augustus.akubue.237434@unn.edu.ng', '100', 'Paystack', 'T903392447498574', '2019-11-07T03:46:52.000Z', 1, 0, '2019-11-07 03:46:57', '');

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

CREATE TABLE `links` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `links`
--

INSERT INTO `links` (`id`, `title`, `link`, `status`, `date`) VALUES
(1, 'Paystack Tester Page', 'https://paystack.com/pay/dvrlgb56ra', 0, '2019-10-22 10:54:51'),
(2, 'Testing Link', 'http://www.go.paystack.com/hdsiybdyydhbde', 0, '2019-10-22 11:02:43'),
(3, 'Second paystack page', 'https://www.paystack.com/pay', 1, '2019-10-25 20:43:12');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `payment_type` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `amount_usd` varchar(100) NOT NULL,
  `amount_btc` varchar(100) NOT NULL,
  `requested` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL,
  `tbl_mode` varchar(100) NOT NULL,
  `tbl_id` int(11) NOT NULL,
  `w_type` varchar(100) NOT NULL,
  `bonus_id` int(11) NOT NULL,
  `confirmed` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `bank` varchar(100) NOT NULL,
  `acc_name` varchar(100) NOT NULL,
  `acc_number` varchar(100) NOT NULL,
  `wallet_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `status` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `ref_id` varchar(100) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `address` varchar(225) NOT NULL,
  `country` varchar(50) NOT NULL,
  `continent` varchar(50) NOT NULL,
  `fplan` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `last_logged` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `referal_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ref_id`, `fname`, `lname`, `email`, `phone`, `address`, `country`, `continent`, `fplan`, `pass`, `image`, `status`, `created`, `updated`, `last_logged`, `referal_id`) VALUES
(1, '66508482', 'Akubue', 'Augustus', 'augustus2.akubue.237434@unn.edu.ng', '08081301064', '', 'Nigeria', 'Africa', '', 'e10adc3949ba59abbe56e057f20f883e', 'default.jpg', 1, '2019-11-06 21:37:00', '2019-11-06 21:37:00', '2019-11-08 13:45:00', 0),
(2, '28970652', 'Akubue', 'Augustus', 'augustus.akubue.237434@unn.edu.ng', '08081301064', '', 'Nigeria', 'Africa', '', '61149a8259e2bb4f34a0fe7ad837daa7', 'default.jpg', 1, '2019-11-06 22:42:42', '2019-11-06 22:42:42', '2019-11-07 04:57:23', 1);

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `wallet_id` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wallets`
--

INSERT INTO `wallets` (`id`, `name`, `wallet_id`, `status`, `date`) VALUES
(1, 'Western Trade', '1234567890ac', 1, '2019-10-22 10:54:39');

-- --------------------------------------------------------

--
-- Table structure for table `wt_news`
--

CREATE TABLE `wt_news` (
  `id` int(11) NOT NULL,
  `title` varchar(225) NOT NULL,
  `details` text NOT NULL,
  `picture` varchar(225) NOT NULL,
  `status` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agent_pay`
--
ALTER TABLE `agent_pay`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bonus`
--
ALTER TABLE `bonus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_admins`
--
ALTER TABLE `contact_admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_response`
--
ALTER TABLE `contact_response`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ecnalab`
--
ALTER TABLE `ecnalab`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invested`
--
ALTER TABLE `invested`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `links`
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ref_id` (`ref_id`),
  ADD UNIQUE KEY `ref_id_2` (`ref_id`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wt_news`
--
ALTER TABLE `wt_news`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `agent_pay`
--
ALTER TABLE `agent_pay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bonus`
--
ALTER TABLE `bonus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contact_admins`
--
ALTER TABLE `contact_admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_response`
--
ALTER TABLE `contact_response`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ecnalab`
--
ALTER TABLE `ecnalab`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `invested`
--
ALTER TABLE `invested`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `links`
--
ALTER TABLE `links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wt_news`
--
ALTER TABLE `wt_news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
