-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2018 at 12:07 AM
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
  `mana_cost` text CHARACTER SET utf8 COLLATE utf8_bin,
  `type` text CHARACTER SET utf8 COLLATE utf8_bin,
  `rarity` int(11) DEFAULT NULL,
  `rules` text CHARACTER SET utf8 COLLATE utf8_bin,
  `power` int(11) DEFAULT NULL,
  `toughness` int(11) DEFAULT NULL,
  `creator_id` int(10) DEFAULT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_bin,
  `card_image` text CHARACTER SET utf8 COLLATE utf8_bin,
  `points` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='This is a table to store the user created cards.';

--
-- Dumping data for table `custom_cards`
--

INSERT INTO `custom_cards` (`card_id`, `card_name`, `mana_cost`, `type`, `rarity`, `rules`, `power`, `toughness`, `creator_id`, `description`, `card_image`, `points`) VALUES
(1, 'Anchoring', '4WWU', 'Enchantment', 7, 'Other permanents you control cannot leave the battlefield.\r\nIf a creature you control has toughness zero or less, it cannot attack.', 0, 0, -1, 'Have some cards you don\'t want to leave? Now they don\'t have to.', './card_images/Anchoring.png', NULL),
(2, 'Comet Storm Storm', 'XRRR', 'Sorccery', 7, 'Multikicker {1}\r\nChoose any target, then choose additional targets for each time this spell was kicked. This spell deals X damage to each of them.\r\nStorm', 0, 0, -1, 'Comet Storm Storm', './card_images/Comet Storm Storm.png', NULL),
(3, 'Cleanse', '2W', 'Instant', 6, 'Exile target nonland permanent you don\'t control\r\nOverload {6}{W}', 0, 0, -1, 'It\'s like cyclonic rift, but meaner', './card_images/Cleanse.png', NULL),
(4, 'Revenge', '2BB', 'Instant', 6, 'Destroy target creature.\r\nPainstorm', 0, 0, -1, '', './card_images/Revenge.png', NULL),
(5, 'Snowslide', 'SGW', 'Snow Instant', 5, 'Exile target creature. Its controller adds {C}{C}. Until end of turn, they don\'t lose this mana as steps and phases end.', 0, 0, -1, '', './card_images/Snowslide.png', NULL);

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
