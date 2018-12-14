-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2018 at 08:21 PM
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
-- Database: `card_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `comment_text` text CHARACTER SET utf8 COLLATE utf8_bin,
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `is_card` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment_text`, `user_id`, `post_id`, `is_card`) VALUES
(1, 'Nice Job!', 1, 5, 1),
(4, 'what?', 4, 5, 1),
(5, 'That\'s a lot of Cyclops!', 4, 5, 0);

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
  `points` int(11) DEFAULT NULL,
  `upvoters` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `downvoters` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='This is a table to store the user created cards.';

--
-- Dumping data for table `custom_cards`
--

INSERT INTO `custom_cards` (`card_id`, `card_name`, `mana_cost`, `type`, `rarity`, `rules`, `power`, `toughness`, `creator_id`, `description`, `card_image`, `points`) VALUES
(1, 'Anchoring', '4WWU', 'Enchantment', 7, 'Other permanents you control cannot leave the battlefield.\r\nIf a creature you control has toughness zero or less, it cannot attack.', 0, 0, 1, 'Have some cards you don\'t want to leave? Now they don\'t have to.', './card_images/Anchoring.png', 0, "", ""),
(2, 'Comet Storm Storm', 'XRRR', 'Sorccery', 7, 'Multikicker {1}\r\nChoose any target, then choose additional targets for each time this spell was kicked. This spell deals X damage to each of them.\r\nStorm', 0, 0, 1, 'Comet Storm Storm', './card_images/Comet Storm Storm.png', 0, "", ""),
(3, 'Cleanse', '2W', 'Instant', 6, 'Exile target nonland permanent you don\'t control\r\nOverload {6}{W}', 0, 0, 1, 'It\'s like cyclonic rift, but meaner', './card_images/Cleanse.png', 1, "", ""),
(4, 'Revenge', '2BB', 'Instant', 6, 'Destroy target creature.\r\nPainstorm', 0, 0, 1, '', './card_images/Revenge.png', 2, "", ""),
(5, 'Snowslide', 'SGW', 'Snow Instant', 5, 'Exile target creature. Its controller adds {C}{C}. Until end of turn, they don\'t lose this mana as steps and phases end.', 0, 0, 1, '', './card_images/Snowslide.png', 3, "", "");

-- --------------------------------------------------------

--
-- Table structure for table `deck_database`
--

CREATE TABLE `deck_database` (
  `deck_id` int(11) NOT NULL,
  `cards` text CHARACTER SET utf8 COLLATE utf8_bin,
  `description` text CHARACTER SET utf8 COLLATE utf8_bin,
  `creator_id` int(11) DEFAULT NULL,
  `title` text CHARACTER SET utf8 COLLATE utf8_bin,
  `points` int(11) DEFAULT NULL,
  `upvoters` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `downvoters` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deck_database`
--

INSERT INTO `deck_database` (`deck_id`, `cards`, `description`, `creator_id`, `title`, `points`) VALUES
(1, './card_images/Anchoring.png https://img.scryfall.com/cards/normal/en/m19/227.jpg https://img.scryfall.com/cards/normal/en/8ed/179.jpg https://img.scryfall.com/cards/normal/front/5/8/58fe058d-7796-4233-8d74-2a12f9bd0023.jpg https://img.scryfall.com/cards/normal/en/ptk/135.jpg ', 'A random collection of cards', 1, 'Random Deck #1', 0, "", ""),
(2, 'https://img.scryfall.com/cards/normal/en/wwk/1.jpg https://img.scryfall.com/cards/normal/en/e01/1.jpg https://img.scryfall.com/cards/normal/en/lrw/51.jpg https://img.scryfall.com/cards/normal/en/avr/212.jpg https://img.scryfall.com/cards/normal/en/bbd/87.jpg https://img.scryfall.com/cards/normal/en/bbd/88.jpg ./card_images/Cleanse.png ', 'A bunch of random angel cards', 1, 'Angelic Randomosity', 0, "", ""),
(5, 'https://img.scryfall.com/cards/normal/en/10e/192.jpg https://img.scryfall.com/cards/normal/en/8ed/179.jpg https://img.scryfall.com/cards/normal/en/m11/131.jpg https://img.scryfall.com/cards/normal/en/jou/92.jpg https://img.scryfall.com/cards/normal/en/bng/90.jpg https://img.scryfall.com/cards/normal/en/m14/135.jpg https://img.scryfall.com/cards/normal/en/mir/171.jpg https://img.scryfall.com/cards/normal/front/c/3/c310df89-d894-40ab-ae34-7d0bfd19a1af.jpg https://img.scryfall.com/cards/normal/en/gtc/164.jpg https://img.scryfall.com/cards/normal/en/jou/99.jpg https://img.scryfall.com/cards/normal/en/8ed/195.jpg https://img.scryfall.com/cards/normal/en/cn2/166.jpg https://img.scryfall.com/cards/normal/en/arb/119.jpg https://img.scryfall.com/cards/normal/en/dds/24.jpg https://img.scryfall.com/cards/normal/front/2/e/2ec7523a-a9c4-4b76-8f9e-b591a88e2e37.jpg https://img.scryfall.com/cards/normal/en/fut/75.jpg https://img.scryfall.com/cards/normal/en/dom/139.jpg ', 'Every Cyclops in MTG', 1, 'Cyclops Collection', 0, "", "");

-- --------------------------------------------------------

--
-- Table structure for table `user_data`
--

CREATE TABLE `user_data` (
  `user_id` int(11) NOT NULL,
  `username` text CHARACTER SET utf8 COLLATE utf8_bin,
  `email` text CHARACTER SET utf8 COLLATE utf8_bin,
  `password` text CHARACTER SET utf8 COLLATE utf8_bin,
  `points` int(11) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='This table will be used to store all user data.';

--
-- Dumping data for table `user_data`
--

INSERT INTO `user_data` (`user_id`, `username`, `email`, `password`, `points`, `is_admin`) VALUES
(1, 'user', 'a@b.com', '1234', 0, 0),
(4, 'admin1', 'a@b.com', 'admin1', 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `custom_cards`
--
ALTER TABLE `custom_cards`
  ADD PRIMARY KEY (`card_id`);

--
-- Indexes for table `deck_database`
--
ALTER TABLE `deck_database`
  ADD PRIMARY KEY (`deck_id`);

--
-- Indexes for table `user_data`
--
ALTER TABLE `user_data`
  ADD PRIMARY KEY (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
