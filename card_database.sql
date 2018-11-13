-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2018 at 03:02 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `magicmaker`
--

-- --------------------------------------------------------

--
-- Table structure for table `custom_cards`
--

CREATE TABLE `custom_cards` (
  `card_id` int(10) NOT NULL,
  `card_name` text CHARACTER SET utf8 COLLATE utf8_bin,
  `mana_cost` int(7) DEFAULT NULL,
  `type` text CHARACTER SET utf8 COLLATE utf8_bin,
  `rarity` int(11) DEFAULT NULL,
  `rules` text CHARACTER SET utf8 COLLATE utf8_bin,
  `power` int(11) DEFAULT NULL,
  `toughness` int(11) DEFAULT NULL,
  `creator_id` int(10) DEFAULT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_bin,
  `card_image` text CHARACTER SET utf8 COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='This is a table to store the user created cards.';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `custom_cards`
--
ALTER TABLE `custom_cards`
  ADD PRIMARY KEY (`card_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
