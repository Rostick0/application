-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 23 2022 г., 22:48
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

--
-- Дамп данных таблицы `authorization`
--

INSERT INTO `authorization` (`authorization_id`, `token`, `created_date`, `info`, `ip`, `user_id`) VALUES
(1, '518bf1cdeee7f55b7bfe0ec56cd22fd4', '2022-11-23 12:58:23', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 YaBrowser/22.11.0.2419 Yowser/2.5 Safari/537.36', '127.0.0.1', 1),
(2, '388ffb62ff3ac52093a3a08cfb516e90', '2022-11-23 12:59:22', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 YaBrowser/22.11.0.2419 Yowser/2.5 Safari/537.36', '127.0.0.1', 1),
(3, 'cfbe7e466dceb6cb45524db234fe8d10', '2022-11-23 13:58:27', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 YaBrowser/22.11.0.2419 Yowser/2.5 Safari/537.36', '127.0.0.1', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address_from` varchar(255) DEFAULT NULL,
  `address_to` varchar(255) DEFAULT NULL,
  `count` float DEFAULT NULL,
  `unit_measurement` varchar(255) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `purchase_price` float DEFAULT NULL,
  `purchase_amount` float DEFAULT NULL,
  `status_delivery` int(11) DEFAULT '1',
  `status_payment` int(11) DEFAULT '1',
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `project`
--

CREATE TABLE `project` (
  `project_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contract` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `inn` varchar(255) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `comment` text,
  `complaint` text,
  `zmo_id` int(11) NOT NULL,
  `is_made_order` tinyint(1) NOT NULL DEFAULT '0',
  `document_scan` tinyint(1) NOT NULL DEFAULT '0',
  `documents` tinyint(1) NOT NULL DEFAULT '0',
  `is_ready` tinyint(1) NOT NULL DEFAULT '0',
  `is_finally` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `project`
--

INSERT INTO `project` (`project_id`, `name`, `contract`, `address`, `inn`, `created_date`, `start_date`, `end_date`, `comment`, `complaint`, `zmo_id`, `is_made_order`, `document_scan`, `documents`, `is_ready`, `is_finally`) VALUES
(3, 'Тест', '4', NULL, '11', '2022-11-23 18:31:44', NULL, NULL, NULL, NULL, 1, 1, 0, 0, 0, 0);

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
(3, 3, '[\"all\"]', 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `project_history_edit`
--

CREATE TABLE `project_history_edit` (
  `project_history_edit_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `old` text,
  `new` text,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` varchar(255) NOT NULL,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `project_history_edit`
--

INSERT INTO `project_history_edit` (`project_history_edit_id`, `name`, `old`, `new`, `created_date`, `type`, `project_id`, `user_id`) VALUES
(1, 'Создал проект 1', 'NULL', 'NULL', '2022-11-23 12:59:40', 'create', 1, 1),
(3, 'Удалил проект 1', 'NULL', 'NULL', '2022-11-23 13:03:06', 'delete', 1, 1),
(4, 'Создал проект 2', 'NULL', 'NULL', '2022-11-23 13:10:28', 'create', 2, 1),
(5, 'Добавил товар Кровать', 'NULL', 'NULL', '2022-11-23 13:10:28', 'add', 2, 1),
(6, 'Удалил проект 2', 'NULL', 'NULL', '2022-11-23 18:31:21', 'delete', 2, 1),
(7, 'Создал проект 3', 'NULL', 'NULL', '2022-11-23 18:31:44', 'create', 3, 1),
(10, 'Добавил товар Тпп', 'NULL', 'NULL', '2022-11-23 18:45:36', 'add', 3, 1),
(12, 'Изменил поле Тпп1234', 'Тпп123', 'Тпп1234', '2022-11-23 19:10:47', 'edit', 3, 1),
(13, 'Изменил поле 1', NULL, '1', '2022-11-23 19:10:47', 'edit', 3, 1),
(14, 'Изменил поле Тпп12345', 'Тпп1234', 'Тпп12345', '2022-11-23 19:11:26', 'edit', 3, 1),
(15, 'Изменил поле 1', NULL, '1', '2022-11-23 19:11:26', 'edit', 3, 1),
(16, 'Изменил поле name', 'Тпп12345', 'Тпп123455', '2022-11-23 19:13:03', 'edit', 3, 1),
(17, 'Изменил поле status_delivery1', NULL, '1', '2022-11-23 19:13:03', 'edit', 3, 1),
(18, 'Изменил поле status_delivery1', NULL, '1', '2022-11-23 19:14:44', 'edit', 3, 1),
(19, 'Изменил поле status_delivery3', NULL, '3', '2022-11-23 19:14:54', 'edit', 3, 1),
(20, 'Изменил поле status_delivery3', NULL, '3', '2022-11-23 19:15:01', 'edit', 3, 1),
(21, 'Изменил поле status_delivery1', NULL, '1', '2022-11-23 19:15:08', 'edit', 3, 1),
(22, 'Изменил поле status_payment2', '1', '2', '2022-11-23 19:15:08', 'edit', 3, 1),
(23, 'Изменил поле status_delivery1', NULL, '1', '2022-11-23 19:19:08', 'edit', 3, 1),
(24, 'Изменил поле status_delivery1', NULL, '1', '2022-11-23 19:19:18', 'edit', 3, 1),
(25, 'Изменил поле status_delivery3', '1', '3', '2022-11-23 19:28:27', 'edit', 3, 1),
(26, 'Изменил поле status_delivery1', NULL, '1', '2022-11-23 19:31:36', 'edit', 3, 1),
(27, 'Изменил поле status_delivery1', NULL, '1', '2022-11-23 19:33:13', 'edit', 3, 1),
(28, 'Изменил поле status_delivery1', NULL, '1', '2022-11-23 19:34:41', 'edit', 3, 1),
(29, 'Изменил поле status_delivery3', NULL, '3', '2022-11-23 19:34:49', 'edit', 3, 1),
(30, 'Изменил поле status_delivery3', NULL, '3', '2022-11-23 19:35:43', 'edit', 3, 1),
(31, 'Изменил поле status_delivery3', NULL, '3', '2022-11-23 19:35:51', 'edit', 3, 1),
(32, 'Изменил поле status_delivery3', NULL, '3', '2022-11-23 19:35:57', 'edit', 3, 1),
(33, 'Изменил поле status_delivery3', NULL, '3', '2022-11-23 19:36:17', 'edit', 3, 1),
(34, 'Удалён товар', NULL, NULL, '2022-11-23 19:46:54', 'delete', 3, 1);

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
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `FCs` varchar(255) DEFAULT NULL,
  `telephone` varchar(15) DEFAULT NULL,
  `about` text,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_online` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role_id` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`user_id`, `email`, `password`, `FCs`, `telephone`, `about`, `created_date`, `last_online`, `role_id`) VALUES
(1, 'rostik057@gmail.com', '$2y$10$3BIotfxQcRmisDAiKiloqe0HyCYj56rPn.MIWUO4QHQRudEA96tAe', 'Ростислав Алекснадрович Волков', '+79999', NULL, '2022-11-23 12:58:23', '2022-11-23 12:58:23', 3),
(2, 'test@gmail.com', '$2y$10$.22seJ2dho7ksLWERLmbM.P/UYxGnBP26et2QP/8EM3EhK3wK034e', 'Ф и О', NULL, NULL, '2022-11-23 13:58:27', '2022-11-23 13:58:27', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `zmo`
--

CREATE TABLE `zmo` (
  `zmo_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `zmo`
--

INSERT INTO `zmo` (`zmo_id`, `name`) VALUES
(1, 'прямой'),
(2, '44-ФЗ');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `authorization`
--
ALTER TABLE `authorization`
  ADD PRIMARY KEY (`authorization_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

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
-- Индексы таблицы `zmo`
--
ALTER TABLE `zmo`
  ADD PRIMARY KEY (`zmo_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `authorization`
--
ALTER TABLE `authorization`
  MODIFY `authorization_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `project`
--
ALTER TABLE `project`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `project_access`
--
ALTER TABLE `project_access`
  MODIFY `project_access_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `zmo`
--
ALTER TABLE `zmo`
  MODIFY `zmo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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