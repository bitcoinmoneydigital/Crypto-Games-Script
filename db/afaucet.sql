-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2018 at 02:05 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `afaucet`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `base_currency` varchar(250) NOT NULL DEFAULT 'btc',
  `web_title` varchar(250) NOT NULL,
  `web_desc` varchar(250) NOT NULL,
  `solvemedia_priv_api` varchar(250) NOT NULL,
  `solvemedia_pub_api` varchar(350) NOT NULL,
  `solvemedia_hash_api` varchar(250) NOT NULL,
  `faucethub_api` varchar(250) NOT NULL,
  `contact_email` varchar(250) NOT NULL,
  `web_keywords` varchar(250) NOT NULL,
  `iphub_api` varchar(250) NOT NULL,
  `faucet_timer` varchar(250) NOT NULL,
  `roll_timer` varchar(250) NOT NULL,
  `shortlink_api` varchar(250) NOT NULL,
  `prize1` varchar(250) NOT NULL,
  `prize2` varchar(250) NOT NULL,
  `prize3` varchar(250) NOT NULL,
  `prize4` varchar(250) NOT NULL,
  `prize5` varchar(250) NOT NULL,
  `prize6` varchar(250) NOT NULL,
  `min_amount_cointale` varchar(250) NOT NULL,
  `faucet_reward` varchar(250) NOT NULL,
  `contact_facebook` varchar(250) NOT NULL,
  `contact_twitter` varchar(250) NOT NULL,
  `contact_linkedin` varchar(250) NOT NULL,
  `contact_googleplus` varchar(250) NOT NULL,
  `website_url` varchar(250) NOT NULL,
  `referal_percentage` varchar(250) NOT NULL,
  `min_withdraw_amount` varchar(250) NOT NULL,
  `withdraw_status` varchar(250) NOT NULL DEFAULT '0',
  `withdraw_status_r` varchar(250) NOT NULL DEFAULT '0',
  `min_withdraw_amount_r` varchar(250) NOT NULL,
  `min_amount_luckynumber` varchar(250) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `created_at`, `base_currency`, `web_title`, `web_desc`, `solvemedia_priv_api`, `solvemedia_pub_api`, `solvemedia_hash_api`, `faucethub_api`, `contact_email`, `web_keywords`, `iphub_api`, `faucet_timer`, `roll_timer`, `shortlink_api`, `prize1`, `prize2`, `prize3`, `prize4`, `prize5`, `prize6`, `min_amount_cointale`, `faucet_reward`, `contact_facebook`, `contact_twitter`, `contact_linkedin`, `contact_googleplus`, `website_url`, `referal_percentage`, `min_withdraw_amount`, `withdraw_status`, `withdraw_status_r`, `min_withdraw_amount_r`, `min_amount_luckynumber`) VALUES
(1, 'admin', '$2y$10$fGuzBzykPDsjJ3m79Dj.COG4lrBB6owL1xR3Bhw39iutyW1KR7x.K', '2018-09-06 19:52:22', 'doge', 'Ksfaucet - Web Faucet Online', 'Earn online bitcoin', '', '', '', '', 'contact@ksfaucet.com', 'faucet,bitcoin,casino,cointale', '', '250', '678', '', '90', '80', '70', '60', '50', '40', '25', '500', 'facebook.com/ksfaucet', 'twitter.com/ksfaucet', 'linkedin.com/ksfaucet', 'googleplus.com/ksfaucet', 'https://www.ksfaucet.com', '15', '5000', '1', '1', '10000', '20');

-- --------------------------------------------------------

--
-- Table structure for table `banned_users`
--

CREATE TABLE `banned_users` (
  `id` int(11) NOT NULL,
  `username` varchar(250) NOT NULL,
  `reason` varchar(250) NOT NULL,
  `ip` varchar(250) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `username` varchar(250) NOT NULL,
  `amount` varchar(250) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` varchar(250) NOT NULL,
  `status` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `balance` varchar(250) NOT NULL DEFAULT '0',
  `referal` varchar(250) NOT NULL,
  `refearning` varchar(250) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `claims` varchar(250) NOT NULL DEFAULT '0',
  `lastclaim` varchar(250) NOT NULL DEFAULT '0',
  `lastclaim_roll` varchar(250) NOT NULL DEFAULT '0',
  `paid` varchar(250) NOT NULL DEFAULT '0',
  `ip` varchar(250) NOT NULL,
  `pubid` varchar(250) NOT NULL,
  `refnumb` varchar(250) NOT NULL DEFAULT '0',
  `authcode` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `balance`, `referal`, `refearning`, `created_at`, `claims`, `lastclaim`, `lastclaim_roll`, `paid`, `ip`, `pubid`, `refnumb`, `authcode`) VALUES
(1, 'kscoins', 'jhg8787thjg8t87', '0', '', '0', '2018-08-31 02:09:54', '1', '1', '1', '0', '', '', '7', '1254215');

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_transactions`
--

CREATE TABLE `withdraw_transactions` (
  `id` int(250) NOT NULL,
  `username` varchar(250) NOT NULL,
  `amount` varchar(250) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` varchar(250) NOT NULL,
  `status` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `banned_users`
--
ALTER TABLE `banned_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `withdraw_transactions`
--
ALTER TABLE `withdraw_transactions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `banned_users`
--
ALTER TABLE `banned_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `withdraw_transactions`
--
ALTER TABLE `withdraw_transactions`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
