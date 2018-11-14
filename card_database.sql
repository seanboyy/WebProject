SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


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
  `card_image` text CHARACTER SET utf8 COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='This is a table to store the user created cards.';

INSERT INTO `custom_cards` (`card_id`, `card_name`, `mana_cost`, `type`, `rarity`, `rules`, `power`, `toughness`, `creator_id`, `description`, `card_image`) VALUES
(1, 'Anchoring', '4WWU', 'Enchantment', 7, 'Other permanents you control cannot leave the battlefield.\r\nIf a creature you control has toughness zero or less, it cannot attack.', 0, 0, -1, 'Have some cards you don\'t want to leave? Now they don\'t have to.', './card_images/Anchoring.png'),
(2, 'Comet Storm Storm', 'XRRR', 'Sorccery', 7, 'Multikicker {1}\r\nChoose any target, then choose additional targets for each time this spell was kicked. This spell deals X damage to each of them.\r\nStorm', 0, 0, -1, 'Comet Storm Storm', './card_images/Comet Storm Storm.png'),
(3, 'Cleanse', '2W', 'Instant', 6, 'Exile target nonland permanent you don\'t control\r\nOverload {6}{W}', 0, 0, -1, 'It\'s like cyclonic rift, but meaner', './card_images/Cleanse.png');


ALTER TABLE `custom_cards`
  ADD PRIMARY KEY (`card_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
