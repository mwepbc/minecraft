-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Ноя 10 2025 г., 16:01
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `minecraft`
--

-- --------------------------------------------------------

--
-- Структура таблицы `crafts`
--

CREATE TABLE `crafts` (
  `id` int(11) NOT NULL,
  `crafting_item` int(11) NOT NULL,
  `pos_1` int(11) DEFAULT NULL,
  `pos_2` int(11) DEFAULT NULL,
  `pos_3` int(11) DEFAULT NULL,
  `pos_4` int(11) DEFAULT NULL,
  `pos_5` int(11) DEFAULT NULL,
  `pos_6` int(11) DEFAULT NULL,
  `pos_7` int(11) DEFAULT NULL,
  `pos_8` int(11) DEFAULT NULL,
  `pos_9` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `crafts`
--

INSERT INTO `crafts` (`id`, `crafting_item`, `pos_1`, `pos_2`, `pos_3`, `pos_4`, `pos_5`, `pos_6`, `pos_7`, `pos_8`, `pos_9`, `quantity`) VALUES
(1, 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4),
(2, 3, NULL, NULL, NULL, NULL, 2, NULL, NULL, 2, NULL, 4),
(3, 7, 8, 8, 8, 8, 8, 8, 8, 8, 8, NULL),
(4, 9, 7, 7, 7, 7, 7, 7, 7, 7, 7, NULL),
(9, 11, 7, NULL, 7, 7, NULL, 7, 7, 7, 7, NULL),
(10, 10, NULL, NULL, NULL, 7, NULL, 7, 7, 7, 7, NULL),
(12, 27, 2, 2, NULL, 2, 2, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `items`
--

INSERT INTO `items` (`id`, `name`, `image`) VALUES
(1, 'log', 'log.webp'),
(2, 'planks', 'planks.png'),
(3, 'stick', 'stick.webp'),
(5, 'stone pickaxe', 'stone_pickaxe.png'),
(7, 'iron ingot', 'iron_ingot.webp'),
(8, 'iron nugget', 'iron_nugget.webp'),
(9, 'iron block', 'iron_block.webp'),
(10, 'cart', 'cart.webp'),
(11, 'cauldron', 'cauldron.webp'),
(14, 'cobblestone', 'cobblestone.webp'),
(15, 'furnace', 'furnace.webp'),
(21, 'chain', 'chain.webp'),
(22, 'stone axe', 'stone_axe.webp'),
(27, 'crafting table', 'crafting_table.webp'),
(34, 'fdsfdsfds', 'tip.png');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` text NOT NULL,
  `password` text NOT NULL,
  `role` enum('admin','user','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `role`) VALUES
(1, 'admin', 'admin', 'admin'),
(2, 'user', 'user', 'user'),
(3, 'popa', 'popa', 'user'),
(4, 'popka', 'popka', 'user'),
(9, 'fdsfds', 'fdsfsd', 'user'),
(10, 'admin1', 'admin1', 'admin');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `crafts`
--
ALTER TABLE `crafts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `crafts_ibfk_1` (`crafting_item`),
  ADD KEY `pos_1` (`pos_1`),
  ADD KEY `pos_2` (`pos_2`),
  ADD KEY `pos_3` (`pos_3`),
  ADD KEY `pos_4` (`pos_4`),
  ADD KEY `pos_5` (`pos_5`),
  ADD KEY `pos_6` (`pos_6`),
  ADD KEY `pos_7` (`pos_7`),
  ADD KEY `pos_8` (`pos_8`),
  ADD KEY `pos_9` (`pos_9`);

--
-- Индексы таблицы `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `crafts`
--
ALTER TABLE `crafts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `crafts`
--
ALTER TABLE `crafts`
  ADD CONSTRAINT `crafts_ibfk_1` FOREIGN KEY (`crafting_item`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `crafts_ibfk_10` FOREIGN KEY (`pos_9`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `crafts_ibfk_2` FOREIGN KEY (`pos_1`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `crafts_ibfk_3` FOREIGN KEY (`pos_2`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `crafts_ibfk_4` FOREIGN KEY (`pos_3`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `crafts_ibfk_5` FOREIGN KEY (`pos_4`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `crafts_ibfk_6` FOREIGN KEY (`pos_5`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `crafts_ibfk_7` FOREIGN KEY (`pos_6`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `crafts_ibfk_8` FOREIGN KEY (`pos_7`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `crafts_ibfk_9` FOREIGN KEY (`pos_8`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
