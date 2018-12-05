-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2018 at 04:19 PM
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
-- Table structure for table `deck_database`
--

CREATE TABLE `deck_database` (
  `deck_id` int(11) DEFAULT NULL,
  `cards` text CHARACTER SET utf8 COLLATE utf8_bin,
  `description` text CHARACTER SET utf8 COLLATE utf8_bin,
  `creator_id` int(11) DEFAULT NULL,
  `title` text CHARACTER SET utf8 COLLATE utf8_bin,
  `points` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deck_database`
--

INSERT INTO `deck_database` (`deck_id`, `cards`, `description`, `creator_id`, `title`, `points`) VALUES
(1, './card_images/Anchoring.png https://img.scryfall.com/cards/normal/en/m19/227.jpg https://img.scryfall.com/cards/normal/en/8ed/179.jpg https://img.scryfall.com/cards/normal/front/5/8/58fe058d-7796-4233-8d74-2a12f9bd0023.jpg https://img.scryfall.com/cards/normal/en/ptk/135.jpg ', 'Hey there', -1, 'Deck 1', 0),
(2, 'https://img.scryfall.com/cards/normal/en/wwk/1.jpg https://img.scryfall.com/cards/normal/en/e01/1.jpg https://img.scryfall.com/cards/normal/en/lrw/51.jpg https://img.scryfall.com/cards/normal/en/avr/212.jpg https://img.scryfall.com/cards/normal/en/bbd/87.jpg https://img.scryfall.com/cards/normal/en/bbd/88.jpg ./card_images/Cleanse.png ', 'Angels wut wut', -1, 'Deck 2', 0),
(5, 'https://img.scryfall.com/cards/normal/en/10e/192.jpg https://img.scryfall.com/cards/normal/en/8ed/179.jpg https://img.scryfall.com/cards/normal/en/m11/131.jpg https://img.scryfall.com/cards/normal/en/jou/92.jpg https://img.scryfall.com/cards/normal/en/bng/90.jpg https://img.scryfall.com/cards/normal/en/m14/135.jpg https://img.scryfall.com/cards/normal/en/mir/171.jpg https://img.scryfall.com/cards/normal/front/c/3/c310df89-d894-40ab-ae34-7d0bfd19a1af.jpg https://img.scryfall.com/cards/normal/en/gtc/164.jpg https://img.scryfall.com/cards/normal/en/jou/99.jpg https://img.scryfall.com/cards/normal/en/8ed/195.jpg https://img.scryfall.com/cards/normal/en/cn2/166.jpg https://img.scryfall.com/cards/normal/en/arb/119.jpg https://img.scryfall.com/cards/normal/en/dds/24.jpg https://img.scryfall.com/cards/normal/front/2/e/2ec7523a-a9c4-4b76-8f9e-b591a88e2e37.jpg https://img.scryfall.com/cards/normal/en/fut/75.jpg https://img.scryfall.com/cards/normal/en/dom/139.jpg ', 'Every Cyclops in MTG', 1, 'Cyclops Collection', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
