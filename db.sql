-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 21 2022 г., 17:10
-- Версия сервера: 5.7.38
-- Версия PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `application`
--

-- --------------------------------------------------------

--
-- Структура таблицы `authorization`
--

CREATE TABLE `authorization` (
  `authorization_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `info` text,
  `ip` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `project`
--

CREATE TABLE `project` (
  `project_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `inn` varchar(255) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `count_defective` int(11) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `price_commission` float DEFAULT NULL,
  `comment` text,
  `complaint` text,
  `is_ready` tinyint(1) NOT NULL DEFAULT '0',
  `is_finally` tinyint(1) NOT NULL DEFAULT '0',
  `status_payment_id` int(11) NOT NULL DEFAULT '1',
  `status_delivery_id` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `project_access`
--

CREATE TABLE `project_access` (
  `project_access_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `name` json NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT '1',
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `project_access`
--

INSERT INTO `project_access` (`project_access_id`, `project_id`, `name`, `role_id`, `user_id`) VALUES
(1, 3, '[\"address\", \"count\"]', 2, 1),
(2, 2, '[\"all\"]', 2, 1),
(3, 2, '[\"address\"]', 1, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `project_history_edit`
--

CREATE TABLE `project_history_edit` (
  `project_history_edit_id` int(11) NOT NULL,
  `action` json NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `power` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `role`
--

INSERT INTO `role` (`role_id`, `name`, `power`) VALUES
(1, 'logistician', 1),
(2, 'manager', 10),
(3, 'director', 25);

-- --------------------------------------------------------

--
-- Структура таблицы `status_delivery`
--

CREATE TABLE `status_delivery` (
  `status_delivery_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `status_delivery`
--

INSERT INTO `status_delivery` (`status_delivery_id`, `name`) VALUES
(1, 'Товар упаковывается'),
(2, 'Товар доставляется'),
(3, 'Товар доставлен');

-- --------------------------------------------------------

--
-- Структура таблицы `status_payment`
--

CREATE TABLE `status_payment` (
  `status_payment_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `status_payment`
--

INSERT INTO `status_payment` (`status_payment_id`, `name`) VALUES
(1, 'Не оплачен'),
(2, 'Оплачен');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `about` text,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_online` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role_id` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `authorization`
--
ALTER TABLE `authorization`
  ADD PRIMARY KEY (`authorization_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`project_id`);

--
-- Индексы таблицы `project_access`
--
ALTER TABLE `project_access`
  ADD PRIMARY KEY (`project_access_id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Индексы таблицы `project_history_edit`
--
ALTER TABLE `project_history_edit`
  ADD PRIMARY KEY (`project_history_edit_id`);

--
-- Индексы таблицы `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Индексы таблицы `status_delivery`
--
ALTER TABLE `status_delivery`
  ADD PRIMARY KEY (`status_delivery_id`);

--
-- Индексы таблицы `status_payment`
--
ALTER TABLE `status_payment`
  ADD PRIMARY KEY (`status_payment_id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `authorization`
--
ALTER TABLE `authorization`
  MODIFY `authorization_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `project`
--
ALTER TABLE `project`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `project_access`
--
ALTER TABLE `project_access`
  MODIFY `project_access_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `project_history_edit`
--
ALTER TABLE `project_history_edit`
  MODIFY `project_history_edit_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `status_delivery`
--
ALTER TABLE `status_delivery`
  MODIFY `status_delivery_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `status_payment`
--
ALTER TABLE `status_payment`
  MODIFY `status_payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `authorization`
--
ALTER TABLE `authorization`
  ADD CONSTRAINT `authorization_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Ограничения внешнего ключа таблицы `project_access`
--
ALTER TABLE `project_access`
  ADD CONSTRAINT `project_access_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`),
  ADD CONSTRAINT `project_access_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `project_access_ibfk_3` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`);

--
-- Ограничения внешнего ключа таблицы `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
