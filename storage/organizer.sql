-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Час створення: Бер 16 2018 р., 21:42
-- Версія сервера: 5.7.19
-- Версія PHP: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `organizer`
--

-- --------------------------------------------------------

--
-- Структура таблиці `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп даних таблиці `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '1', 1521222811),
('author', '2', 1521222811),
('author', '3', 1521222811),
('author', '4', 1521222811),
('author', '5', 1521222811);

-- --------------------------------------------------------

--
-- Структура таблиці `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп даних таблиці `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, 'Admin', NULL, NULL, 1521222811, 1521222811),
('author', 1, 'Author', NULL, NULL, 1521222811, 1521222811),
('createTask', 2, 'Create a task', NULL, NULL, 1521222810, 1521222810),
('updateOwnTask', 2, 'Update own task', 'isAuthor', NULL, 1521222811, 1521222811),
('updateTask', 2, 'Update task', NULL, NULL, 1521222811, 1521222811);

-- --------------------------------------------------------

--
-- Структура таблиці `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп даних таблиці `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('admin', 'author'),
('admin', 'createTask'),
('author', 'updateOwnTask'),
('updateOwnTask', 'updateTask');

-- --------------------------------------------------------

--
-- Структура таблиці `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп даних таблиці `auth_rule`
--

INSERT INTO `auth_rule` (`name`, `data`, `created_at`, `updated_at`) VALUES
('isAuthor', 0x4f3a32313a226170705c6d6f64656c735c417574686f7252756c65223a333a7b733a343a226e616d65223b733a383a226973417574686f72223b733a393a22637265617465644174223b693a313532313232323831313b733a393a22757064617465644174223b693a313532313232323831313b7d, 1521222811, 1521222811);

-- --------------------------------------------------------

--
-- Структура таблиці `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1521144126),
('m140506_102106_rbac_init', 1521144239),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1521144239),
('m180313_103653_create_task_table', 1521195938),
('m180315_140828_create_user_table', 1521196083);

-- --------------------------------------------------------

--
-- Структура таблиці `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL DEFAULT '1',
  `priority` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `task`
--

INSERT INTO `task` (`id`, `name`, `created`, `user_id`, `priority`, `status`, `photo`) VALUES
(1, 'task 1', '2018-03-16 12:54:24', 2, 0, 0, 'BIMO.jpeg'),
(2, 'task 2', '2018-03-16 13:13:02', 5, 1, 1, 'BMO.jpg'),
(3, 'task 3', '2018-03-16 15:15:37', 3, 0, 2, 'algebraic.png'),
(4, 'task 3', '2018-03-16 15:19:18', 5, 0, 0, 'fin2.jpeg');

-- --------------------------------------------------------

--
-- Структура таблиці `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`) VALUES
(1, 'webmaster', 'b9dS1aerq_uTQ2s_qTkTByVAAFiza4Ed', '$2y$13$hLUXse8FRDuYhR2vtbL2U.nVF4X.kdKAbzkDFqVpEtyFLJfC95uRW'),
(2, 'User 1', 'sZOMZfN2dgLKenG5ilHdYVr614PqpYe9', '$2y$13$z81g8gdsTVZB0y0CItOpweQ3bpPqPEqtNfiTbJyuLVKnevrdcG0ee'),
(3, 'User 2', 'zpFnUTt7LeNMuJdgdqNCp31GPoAlOX5e', '$2y$13$ZG3RHqoyiDv.VHETwH4.SuzE9SFI6hW.7S/7QDIfenb3NaHV7Qxpe'),
(4, 'User 3', 'lke5EQ9sgPQjkrMERnEkiIvfnxLCOMTI', '$2y$13$B18giXkKvkDysX8vZpccg.qPBriKspCPwfN8BRU.O4d03kTfH205m'),
(5, 'User 4', 'TAsxebVI73OBFhAAaoNUYrl2y0Ysx-Zv', '$2y$13$SQYcb20te7lqKgr1cObz3OV7QnFqGnd0wvAlqnnL2WjOlnDF39H3y');

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `auth_assignment_user_id_idx` (`user_id`);

--
-- Індекси таблиці `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Індекси таблиці `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Індекси таблиці `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Індекси таблиці `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Індекси таблиці `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Індекси таблиці `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблиці `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
