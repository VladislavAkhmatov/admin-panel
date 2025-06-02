-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 02 2025 г., 11:51
-- Версия сервера: 8.0.30
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `sch`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admin`
--

CREATE TABLE `admin` (
  `user_id` bigint NOT NULL,
  `branch_id` int NOT NULL,
  `deleted` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `admin`
--

INSERT INTO `admin` (`user_id`, `branch_id`, `deleted`) VALUES
(19, 1, 1),
(93, 3, 1),
(94, 3, 1),
(95, 3, 1),
(97, 1, 1),
(98, 1, 1),
(99, 6, 1),
(101, 2, 1),
(116, 1, 1),
(119, 1, 0),
(121, 1, 0),
(123, 1, 0),
(129, 1, 0),
(134, 1, 0),
(135, 1, 0),
(139, 1, 0),
(140, 1, 0),
(143, 4, 0),
(147, 1, 0),
(150, 1, 0),
(156, 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_tokens`
--

CREATE TABLE `auth_tokens` (
  `id` int NOT NULL,
  `login` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `auth_tokens`
--

INSERT INTO `auth_tokens` (`id`, `login`, `token`, `expires_at`) VALUES
(11, '87081756417', '1bb7ceff7593b0654fbc4f38a05de7b8', '2025-03-29'),
(12, '87081756417', '78c2f8cc47bff3ef72c565e275f29347', '2025-03-29'),
(16, '87081756417', 'f6d144f61efc64ff9065e646f2cd5003', '2025-03-29'),
(23, '87081756417', 'a6fd5ad1332bb8a2b8f2079f318b94bd', '2025-03-29'),
(24, '87081756417', '5dc5635097d02c2e399f7d59d56bb0be', '2025-03-29'),
(25, '87081756417', '564ada83b1f423fd1a7131973419ca84', '2025-03-29'),
(26, '87081756417', 'cded3b760f538a88f3e9b9ac382e63ee', '2025-03-29'),
(43, '87081756417', 'ecdbc2b49c4a5ca6d0ffaaa1f3300348', '2025-03-31'),
(44, '87081756417', '88d5eecfac45138e0bfea03aa862fda2', '2025-03-31'),
(45, '87081756417', 'f1d5f610a05dc7b47c5435961b9e4633', '2025-03-31'),
(47, '87081756417', 'e524209406120b91a7c8d9038b9ecf0b', '2025-03-31'),
(52, '87081756417', '7074101d43fe8abde0931f78ac5a08bb', '2025-03-31'),
(53, '87081756417', '737da6c7dd9b5a14d6ffaa43fa1ad220', '2025-03-31'),
(54, '87771111111', 'b3c26f99eea590f2cc5501d5d9321ca8', '2025-03-31'),
(55, '87081756417', 'c3524b0d709e861e3461c2786bef9c1c', '2025-03-31'),
(56, '87081756417', '2501ef57fdc1b9836583024e81adbc51', '2025-03-31'),
(57, '87081756417', '8df0c8ab68d5e2e636255fa3282d5e6d', '2025-03-31'),
(58, '87081756417', '710b3cad91b10f7e74b9d6803301c547', '2025-03-31'),
(59, '87771111111', 'e3e0bc571354ad5780633fc1bf810eaf', '2025-03-31'),
(60, '87081756417', 'c84043f2e7cf8b44bc662857e662a566', '2025-03-31'),
(61, '87081756417', '4a0babb9705b458fe15ef4bc828e0089', '2025-03-31'),
(63, '87081756417', '57fe2dd80a3ef5c76b3f2973ff48b8d5', '2025-03-31'),
(65, '87081756417', 'cf91308ee61167d3d63a6cb31fd4f7c2', '2025-03-31'),
(66, '87081756417', 'd0981c0da80fef7715fdf2fee2ace0d4', '2025-03-31'),
(71, '87081756417', 'bc8e4b4554cedc55277c867584b38c32', '2025-04-01'),
(72, '87081756417', '97f364470e2a114327503339a55c65b8', '2025-04-18'),
(73, '87081756417', 'ac9151177a4daba09a9dbfa1073f4890', '2025-04-18'),
(75, '87771111111', '0fb5da2613a39dd39363a16c905734f4', '2025-04-18'),
(76, '87771111111', 'dac1786bec56d73538ac194f7f5d5218', '2025-04-18'),
(77, '87081756417', '66cd6e4d4e82e3ab2eb38e484723b1b1', '2025-04-18');

-- --------------------------------------------------------

--
-- Структура таблицы `balance`
--

CREATE TABLE `balance` (
  `id` int NOT NULL,
  `user_id` bigint NOT NULL,
  `subject_id` int NOT NULL,
  `count` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Дамп данных таблицы `balance`
--

INSERT INTO `balance` (`id`, `user_id`, `subject_id`, `count`) VALUES
(1, 9, 3, 41),
(7, 18, 3, 10),
(8, 83, 3, 4),
(9, 9, 16, 0),
(10, 18, 16, -1),
(11, 83, 16, -1),
(12, 7, 3, 1),
(13, 8, 3, -1),
(14, 82, 3, -1),
(15, 128, 3, -1),
(16, 136, 3, -1),
(17, 141, 3, 8),
(18, 145, 45, 4),
(19, 145, 46, 10),
(20, 154, 3, 2),
(21, 7, 5, 0),
(22, 8, 5, 0),
(23, 9, 5, 9),
(24, 82, 5, 0),
(25, 128, 5, 0),
(26, 136, 5, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `branch`
--

CREATE TABLE `branch` (
  `id` int NOT NULL,
  `branch` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_founding` date DEFAULT NULL,
  `deleted` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `branch`
--

INSERT INTO `branch` (`id`, `branch`, `date_founding`, `deleted`) VALUES
(1, 'Шұғыла', '2024-02-01', 0),
(2, 'Премьера', '2024-02-02', 0),
(3, 'Саялы\r\n', '2024-02-03', 0),
(4, 'Дарабоз', '2024-03-01', 0),
(5, 'Саина', '2024-03-01', 0),
(6, 'АЛМА СИТИ', '2024-03-01', 0),
(999, 'Для администратора', '2024-02-04', 0),
(1001, 'test', '2024-03-17', 1),
(1002, 'test2', '2025-03-14', 1),
(1003, 'Шұғыла2', '2025-03-27', 1),
(1004, 'testss', '2025-03-27', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `classroom`
--

CREATE TABLE `classroom` (
  `classroom_id` int NOT NULL,
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch` int DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `deleted` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `classroom`
--

INSERT INTO `classroom` (`classroom_id`, `name`, `branch`, `active`, `deleted`) VALUES
(1, '3/515', 1, 1, 0),
(2, '3/515', 2, 1, 0),
(3, '3/520', 2, 1, 0),
(4, '3/519', 2, 1, 0),
(5, '3/516', 1, 1, 0),
(6, 'test', 1, 1, 1),
(7, 'a453', 4, 1, 1),
(8, 'A223', 4, 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `day`
--

CREATE TABLE `day` (
  `day_id` tinyint NOT NULL,
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `day`
--

INSERT INTO `day` (`day_id`, `name`) VALUES
(1, 'Понедельник'),
(2, 'Вторник'),
(3, 'Среда'),
(4, 'Четверг'),
(5, 'Пятница'),
(6, 'Суббота');

-- --------------------------------------------------------

--
-- Структура таблицы `gender`
--

CREATE TABLE `gender` (
  `gender_id` tinyint NOT NULL,
  `name` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `gender`
--

INSERT INTO `gender` (`gender_id`, `name`) VALUES
(1, 'Мужской'),
(2, 'Женский');

-- --------------------------------------------------------

--
-- Структура таблицы `grades`
--

CREATE TABLE `grades` (
  `grade_id` int NOT NULL,
  `user_id` bigint NOT NULL,
  `schedule_id` int NOT NULL,
  `activity` tinyint DEFAULT NULL,
  `attend` tinyint DEFAULT '0',
  `homework` tinyint DEFAULT NULL,
  `date` date DEFAULT NULL,
  `branch_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `grades`
--

INSERT INTO `grades` (`grade_id`, `user_id`, `schedule_id`, `activity`, `attend`, `homework`, `date`, `branch_id`) VALUES
(442, 9, 72, 22, 1, 11, '2025-03-24', 1),
(443, 18, 72, 22, 1, 22, '2025-03-24', 1),
(444, 83, 72, NULL, 0, NULL, '2025-03-24', 1),
(445, 9, 81, 22, 1, 33, '2025-03-24', 1),
(446, 18, 81, NULL, 0, NULL, '2025-03-24', 1),
(447, 83, 81, NULL, 0, NULL, '2025-03-24', 1),
(448, 9, 73, 11, 0, 33, '2025-03-24', 1),
(449, 18, 73, NULL, 0, NULL, '2025-03-24', 1),
(450, 83, 73, NULL, 0, NULL, '2025-03-24', 1),
(451, 7, 83, 75, 1, 80, '2025-03-27', 1),
(452, 8, 83, 80, 1, 80, '2025-03-27', 1),
(453, 9, 83, 90, 1, 90, '2025-03-27', 1),
(454, 82, 83, NULL, 0, NULL, '2025-03-27', 1),
(455, 128, 83, NULL, 0, NULL, '2025-03-27', 1),
(456, 136, 83, NULL, 0, NULL, '2025-03-27', 1),
(457, 145, 86, 50, 0, 80, '2025-03-27', 4),
(458, 18, 87, 80, 1, 87, '2025-03-29', 1),
(459, 83, 87, 80, 1, 75, '2025-03-29', 1),
(460, 141, 87, NULL, 0, NULL, '2025-03-29', 1),
(461, 154, 87, NULL, 0, NULL, '2025-03-29', 1),
(462, 18, 89, 95, 1, 75, '2025-03-31', 1),
(463, 83, 89, NULL, 0, NULL, '2025-03-31', 1),
(464, 141, 89, NULL, 0, NULL, '2025-03-31', 1),
(465, 154, 89, NULL, 0, NULL, '2025-03-31', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `gruppa`
--

CREATE TABLE `gruppa` (
  `gruppa_id` int NOT NULL,
  `name` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_begin` date NOT NULL,
  `date_end` date DEFAULT NULL,
  `branch` int DEFAULT NULL,
  `deleted` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `gruppa`
--

INSERT INTO `gruppa` (`gruppa_id`, `name`, `date_begin`, `date_end`, `branch`, `deleted`) VALUES
(1, '7В', '2022-11-06', '2022-11-16', 1, 0),
(2, '7А', '2023-10-01', '2023-10-31', 1, 0),
(3, '8В', '2023-09-01', '2025-06-10', 1, 0),
(4, '7А', '2020-01-31', '2026-10-24', 2, 0),
(5, '9А', '2023-11-01', '2023-11-30', 2, 0),
(8, 'asd', '2024-04-10', '2024-04-17', 1, 1),
(9, '7T', '2024-04-17', '2024-04-20', 1, 0),
(11, 'A45', '2025-03-27', '2025-03-31', 4, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `notice`
--

CREATE TABLE `notice` (
  `id` int NOT NULL,
  `text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_id` int DEFAULT NULL,
  `user_id` bigint NOT NULL,
  `child_id` bigint DEFAULT NULL,
  `subject_count` int DEFAULT NULL,
  `subject_price` int DEFAULT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `deleted` tinyint DEFAULT '0',
  `canceled` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `notice`
--

INSERT INTO `notice` (`id`, `text`, `subject_id`, `user_id`, `child_id`, `subject_count`, `subject_price`, `link`, `date`, `deleted`, `canceled`) VALUES
(2200, 'Оплатите сумму указанную в приложении', 16, 10, 7, 8, 15000, 'https://example.com', '2024-04-01', 1, 0),
(2201, 'Оплатите сумму указанную в приложении', 5, 10, 7, 12, 15000, 'https://example.com', '2024-04-01', 1, 0),
(2202, 'Оплатите сумму указанную в приложении', 20, 10, 7, 8, 12000, 'https://example.com', '2024-04-01', 1, 0),
(2203, 'Оплатите сумму указанную в приложении', 20, 10, 8, 8, 12000, 'https://example.com', '2024-04-01', 1, 0),
(2204, 'Оплатите сумму указанную в приложении', 3, 10, 9, 20, 30000, 'https://example.com', '2024-04-01', 1, 0),
(2205, 'Оплатите сумму указанную в приложении', 22, 10, 18, 8, 15000, 'https://example.com', '2024-04-01', 1, 0),
(2206, 'Оплатите сумму указанную в приложении', 21, 10, 18, 8, 15000, 'https://example.com', '2024-04-01', 1, 0),
(2207, 'Оплатите сумму указанную в приложении', 35, 85, 86, 12, 12000, 'https://example.com', '2024-04-01', 1, 0),
(2208, 'Оплатите сумму указанную в приложении', 16, 10, 7, 8, 15000, 'https://example.com', '2024-05-01', 1, 0),
(2209, 'Оплатите сумму указанную в приложении', 5, 10, 7, 12, 15000, 'https://example.com', '2024-05-01', 1, 0),
(2210, 'Оплатите сумму указанную в приложении', 20, 10, 7, 8, 12000, 'https://example.com', '2024-05-01', 1, 0),
(2211, 'Оплатите сумму указанную в приложении', 3, 10, 9, 20, 30000, 'https://example.com', '2024-05-01', 1, 0),
(2212, 'Оплатите сумму указанную в приложении', 22, 10, 18, 8, 15000, 'https://example.com', '2024-05-01', 1, 0),
(2213, 'Оплатите сумму указанную в приложении', 21, 10, 18, 8, 15000, 'https://example.com', '2024-05-01', 1, 0),
(2214, 'Оплатите сумму указанную в приложении', 20, 10, 8, 8, 12000, 'https://example.com', '2024-05-01', 1, 0),
(2215, 'Оплатите сумму указанную в приложении', 35, 85, 86, 12, 12000, 'https://example.com', '2024-05-01', 0, 0),
(2216, 'Оплатите сумму указанную в приложении', 3, 106, 9, 20, 30000, 'https://example.com', '2024-05-01', 0, 0),
(2217, 'Оплатите сумму указанную в приложении', 18, 10, 9, 12, 12000, 'https://example.com', '2024-05-01', 1, 0),
(2218, 'Оплатите сумму указанную в приложении', 18, 106, 9, 12, 12000, 'https://example.com', '2024-05-01', 0, 0),
(2219, 'Оплатите сумму указанную в приложении', 3, 10, 7, 12, 11900, 'https://pay.kaspi.kz/pay/wndzlf4x', '2024-04-17', 1, 0),
(2220, 'Оплатите сумму указанную в приложении', 3, 10, 7, 10, 7000, 'https://pay.kaspi.kz/pay/wndzlf4x', '2024-04-17', 1, 0),
(2228, 'Оплатите сумму указанную в приложении', 3, 10, 7, 1, 7500, 'https://pay.kaspi.kz/pay/wndzlf4x', '2024-04-17', 1, 0),
(2229, 'Оплатите сумму указанную в приложении', 3, 10, 7, 1, 7500, 'https://pay.kaspi.kz/pay/wndzlf4x', '2024-04-17', 1, 0),
(2230, 'Оплатите сумму указанную в приложении', 3, 10, 7, 1, 7500, 'https://pay.kaspi.kz/pay/wndzlf4x', '2024-04-18', 1, 0),
(2231, 'Оплатите сумму указанную в приложении', 16, 10, 7, 5, 5000, 'https://pay.kaspi.kz/pay/wndzlf4x', '2024-04-17', 1, 0),
(2232, 'Оплатите сумму указанную в приложении', 16, 10, 8, 5, 50000, 'https://pay.kaspi.kz/pay/wndzlf4x', '2024-04-25', 1, 0),
(2233, 'Оплатите сумму указанную в приложении', 18, 10, 9, 10, 10750, 'https://pay.kaspi.kz/pay/wndzlf4x', '2024-04-18', 1, 0),
(2234, 'Оплатите сумму указанную в приложении', 17, 10, 7, 12, 11900, 'https://pay.kaspi.kz/pay/wndzlf4x', '2024-05-01', 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `owner`
--

CREATE TABLE `owner` (
  `user_id` bigint NOT NULL,
  `branch_id` int DEFAULT NULL,
  `deleted` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `owner`
--

INSERT INTO `owner` (`user_id`, `branch_id`, `deleted`) VALUES
(2, 1, 0),
(15, 1, 0),
(16, 3, 0),
(87, 2, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `parent`
--

CREATE TABLE `parent` (
  `id` bigint NOT NULL,
  `user_id` bigint NOT NULL,
  `child_id` bigint DEFAULT NULL,
  `deleted` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `parent`
--

INSERT INTO `parent` (`id`, `user_id`, `child_id`, `deleted`) VALUES
(1, 10, 7, 0),
(2, 10, 9, 0),
(4, 38, 9, 1),
(12, 38, 7, 1),
(17, 10, 18, 0),
(19, 11, 8, 1),
(23, 10, 8, 0),
(25, 85, NULL, 0),
(26, 85, 86, 0),
(27, 10, 8, 0),
(29, 106, NULL, 0),
(30, 106, 9, 0),
(31, 106, 105, 0),
(33, 114, NULL, 0),
(35, 115, NULL, 1),
(37, 125, NULL, 0),
(40, 125, 126, 0),
(41, 138, NULL, 0),
(44, 142, NULL, 0),
(45, 142, 7, 0),
(46, 10, 9, 0),
(47, 142, 9, 0),
(48, 146, NULL, 0),
(49, 146, 145, 0),
(51, 155, NULL, 0),
(52, 10, 9, 0),
(53, 155, 9, 0),
(54, 155, 8, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `reference`
--

CREATE TABLE `reference` (
  `id` bigint NOT NULL,
  `user_id` bigint NOT NULL,
  `reference` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `reference`
--

INSERT INTO `reference` (`id`, `user_id`, `reference`) VALUES
(2, 7, '1708491921тз.docx'),
(3, 9, '1708492025_тз.docx'),
(4, 9, '1708492075_тз.docx'),
(5, 9, '1708492131_тз.docx'),
(7, 9, '1708492322_тз.docx'),
(8, 7, '1708492433_тз.docx'),
(9, 7, '1708492580_тз.docx'),
(10, 9, '1708494107_asdsadasd.txt'),
(11, 8, '1708791390_test.txt');

-- --------------------------------------------------------

--
-- Структура таблицы `role`
--

CREATE TABLE `role` (
  `role_id` tinyint NOT NULL,
  `sys_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `role`
--

INSERT INTO `role` (`role_id`, `sys_name`, `name`, `active`) VALUES
(2, 'owner', 'Владелец', 1),
(3, 'admin', 'Администратор', 1),
(4, 'teacher', 'Преподаватель', 1),
(5, 'student', 'Студент', 1),
(6, 'procreator', 'Родитель', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `schedule`
--

CREATE TABLE `schedule` (
  `schedule_id` int NOT NULL,
  `group_id` int NOT NULL,
  `subject_id` int NOT NULL,
  `teacher_id` bigint NOT NULL,
  `date` date NOT NULL,
  `time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `classroom_id` int DEFAULT NULL,
  `deleted` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `schedule`
--

INSERT INTO `schedule` (`schedule_id`, `group_id`, `subject_id`, `teacher_id`, `date`, `time`, `classroom_id`, `deleted`) VALUES
(72, 1, 3, 6, '2025-03-03', '11:30', 1, 0),
(73, 1, 3, 6, '2025-03-03', '10:31', 1, 0),
(74, 2, 3, 6, '2025-03-03', '10:37', 1, 0),
(75, 1, 3, 6, '2025-03-04', '10:38', 1, 0),
(76, 1, 3, 6, '2025-03-04', '11:40', 1, 0),
(77, 1, 3, 14, '2025-03-03', '11:40', 1, 0),
(79, 1, 3, 6, '2025-03-05', '10:20', 1, 0),
(80, 1, 3, 6, '2025-03-26', '15:40', 1, 0),
(81, 1, 16, 6, '2025-03-03', '10:40', 1, 0),
(82, 1, 3, 6, '2025-03-06', '12:36', 1, 0),
(83, 2, 3, 6, '2025-03-27', '09:40', 1, 0),
(84, 1, 21, 124, '2025-03-03', '10:40', 1, 0),
(85, 11, 45, 144, '2025-03-03', '00:00', 8, 0),
(86, 11, 45, 144, '2025-03-27', '12:40', 8, 0),
(87, 1, 3, 6, '2025-03-29', '18:00', 1, 0),
(88, 1, 3, 6, '2025-03-07', '02:23', 1, 0),
(89, 1, 3, 6, '2025-03-31', '10:40', 1, 0),
(90, 2, 5, 14, '2025-03-03', '09:00', 5, 0),
(91, 2, 3, 14, '2025-03-03', '13:30', 5, 0),
(92, 3, 16, 6, '2025-04-01', '18:10', 1, 0),
(93, 1, 3, 6, '2025-03-11', '16:00', 1, 0),
(94, 1, 3, 14, '2025-04-01', '14:11', 5, 0),
(95, 2, 3, 6, '2025-04-01', '14:12', 1, 0),
(96, 1, 3, 6, '2025-04-01', '15:45', 1, 0),
(97, 1, 3, 6, '2025-05-07', '18:28', 1, 0),
(98, 1, 3, 6, '2025-05-08', '09:39', 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `student`
--

CREATE TABLE `student` (
  `user_id` bigint NOT NULL,
  `gruppa_id` int NOT NULL,
  `reference` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `num_zach` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `student`
--

INSERT INTO `student` (`user_id`, `gruppa_id`, `reference`, `num_zach`, `deleted`) VALUES
(7, 2, '123', '0', 0),
(8, 2, NULL, '0', 0),
(9, 2, NULL, '0', 0),
(18, 1, NULL, '0', 0),
(82, 2, NULL, '0', 1),
(83, 1, NULL, '0', 1),
(84, 3, NULL, '0', 1),
(86, 4, NULL, '0', 0),
(103, 4, NULL, '0', 0),
(105, 9, NULL, '0', 0),
(122, 3, NULL, '0', 0),
(126, 3, NULL, '0', 0),
(128, 2, NULL, '0', 0),
(136, 2, NULL, '0', 0),
(141, 1, NULL, '0', 0),
(145, 11, NULL, '0', 0),
(154, 1, NULL, '0', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `subject`
--

CREATE TABLE `subject` (
  `subject_id` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch` int DEFAULT NULL,
  `deleted` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `subject`
--

INSERT INTO `subject` (`subject_id`, `name`, `branch`, `deleted`) VALUES
(3, 'МАД', 1, 0),
(5, 'Ағылшын', 1, 0),
(16, 'Математика', 1, 0),
(17, 'Изо ', 1, 0),
(18, 'Хореография', 1, 0),
(20, 'Домбыра ', 1, 0),
(21, 'Фортепиано ', 1, 0),
(22, 'Вокал', 1, 0),
(23, 'Шахмат', 1, 0),
(24, 'МАД', 2, 0),
(25, 'Математика ', 2, 0),
(26, 'Ағылшын ', 2, 0),
(27, 'Изо ', 2, 0),
(28, 'Хореография ', 2, 0),
(29, 'Домбыра ', 2, 0),
(30, 'Фортепиано ', 2, 0),
(31, 'Вокал ', 2, 0),
(32, 'Шахмат ', 2, 0),
(33, 'Тхэквандо ', 2, 0),
(34, 'Дзюдо ', 2, 0),
(35, 'Еркін күрес', 2, 0),
(36, 'Хореография', 3, 0),
(37, 'Домбыра ', 3, 0),
(38, 'Вокал ', 3, 0),
(39, 'Фортепиано ', 3, 0),
(40, 'ИЗО ', 3, 0),
(41, 'Шахмат ', 3, 0),
(42, 'Тхэквондо ', 3, 0),
(43, 'Дзюдо ', 3, 0),
(44, 'Ағылшын ', 3, 0),
(45, 'МАД ', 4, 0),
(46, 'Ағылшын ', 4, 0),
(47, 'Домбыра', 4, 0),
(48, 'Хореография ', 4, 0),
(49, 'Шахмат ', 4, 0),
(50, 'Изо', 4, 0),
(51, 'Вокал ', 4, 0),
(52, 'Фортепиано ', 4, 1),
(53, 'Хореография ', 5, 0),
(54, 'Домбыра ', 5, 0),
(55, 'Вокал ', 5, 0),
(56, 'Фортепиано', 5, 0),
(57, 'Изо', 5, 0),
(58, 'Шахмат ', 5, 0),
(59, 'Тхэквондо ', 5, 0),
(60, 'Дзюдо ', 5, 0),
(61, 'Бокс ', 5, 0),
(62, 'МАД', 6, 0),
(63, 'Продленка ', 6, 0),
(64, 'Математика ', 6, 0),
(65, 'Ағылшын ', 6, 0),
(66, 'Изо ', 6, 0),
(67, 'Хореография ', 6, 0),
(68, 'Домбыра ', 6, 0),
(69, 'Фортепиано ', 6, 0),
(70, 'Вокал ', 6, 0),
(71, 'Шахмат ', 6, 0),
(72, 'Тхэквандо ', 6, 0),
(73, 'Дзюдо ', 6, 0),
(74, 'Еркін күрес', 6, 0),
(76, 'assd', 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `teacher`
--

CREATE TABLE `teacher` (
  `user_id` bigint NOT NULL,
  `deleted` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `teacher`
--

INSERT INTO `teacher` (`user_id`, `deleted`) VALUES
(6, 0),
(12, 0),
(14, 0),
(17, 1),
(22, 1),
(25, 1),
(48, 1),
(59, 1),
(100, 0),
(102, 0),
(104, 0),
(107, 0),
(108, 1),
(110, 1),
(111, 1),
(113, 1),
(117, 0),
(118, 0),
(124, 0),
(130, 1),
(137, 0),
(144, 0),
(148, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `user_id` bigint NOT NULL,
  `lastname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `patronymic` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `login` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `additional_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pass` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender_id` tinyint NOT NULL,
  `birthday` date DEFAULT NULL,
  `role_id` tinyint NOT NULL,
  `branch_id` int DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`user_id`, `lastname`, `firstname`, `patronymic`, `login`, `additional_number`, `pass`, `gender_id`, `birthday`, `role_id`, `branch_id`, `active`) VALUES
(2, 'Смит', 'Джон', 'Тимофеевич', '777', NULL, '$2y$10$kkAc3Z1kd7baFhhpVj98feshP7nhhY8IeT7L04xY9I4PuuhKT3Aii', 1, '2023-11-01', 2, 1, 1),
(6, 'Ершов', 'Максимилиан', 'Иосифович', '87771111111', NULL, '', 1, '2025-03-29', 4, 1, 0),
(7, 'Носов', 'Клим', 'Алексеевич', '6655', NULL, '$2y$10$Ot4eagPH8bNa0o1cMZDMh.XAD306m0/95KPIv3uSVX5TJZWApQAoa', 1, '2025-03-19', 5, 1, 0),
(8, 'Шаров', 'Корней', 'Ростиславович', 'sharov', NULL, '$2y$10$hosMfj/tIw48P0tYCaQ1IuBwj6UYV9klgDsaVh/t5SxDcgPjAb7WS', 1, '2023-10-01', 5, 1, 1),
(9, 'Антонова', 'Асида', 'Игнатьевна', '87774444444', NULL, '', 2, '2025-03-29', 5, 1, 1),
(10, 'Беспалов', 'Агафон', 'Даниилович', '666', NULL, '$2y$10$47vF9GTOsEkic8hFpkfeJuyR9KaVNX9ve.nvZ/W94/jOh2NIsDsKe', 1, '2025-03-20', 6, 1, 0),
(11, 'Карпов', 'Антон', 'Онисимович', 'karpov', NULL, '$2y$10$yOW62BB4F8KYnC/Zs95xGeI7HnlX2Rxpdu9qkVInJDRV0igjzbZpq', 1, '1980-11-12', 6, 1, 1),
(12, 'Гришин', 'Мечеслав', 'Христофорович', 'grishin', NULL, '$2y$10$HiUHq9eyUODAWKKvKb072eJFP2mmX993WlE2yvSHlx0X6JqMftKEe', 1, '2002-12-20', 4, 2, 1),
(14, 'Макаров', 'Михаил', 'Робертович', 'makarov', NULL, '$2y$10$Bq7MUyKFpI7sW1SfJvFMBOyXj286ZPVsxenSHLHI.omqV5x1QzZe.', 1, '1977-06-05', 4, 1, 1),
(15, 'Андреев ', 'Венедикт ', 'Святославович', 'owner2', NULL, '$2y$10$mFlJsQgNvDQ27XfADrMh8O9OQA47f2gLmqYdwGeg8SpsvdoRUX95S', 1, '1975-08-03', 2, 2, 1),
(16, 'Лебедев', 'Альфред ', 'Викторович', 'owner3', NULL, '$2y$10$mFlJsQgNvDQ27XfADrMh8O9OQA47f2gLmqYdwGeg8SpsvdoRUX95S', 1, '1997-07-12', 2, 3, 1),
(17, 'Соловьёв', 'Бронислав', 'Федотович', 'soloviev', NULL, '$2y$10$hwoeqR.h7cOSrs8mPHnbm.bmDXUd/2i4Xg968skfMTFQ.gQystHdC', 1, '1999-05-14', 4, 2, 1),
(18, 'Кошелев', 'Эрнест', 'Лаврентьевич', 'koshelev', NULL, '$2y$10$mlU3F7DiiEWPXzdfjPiHseYtchL0YITkhg9XOGz72xF.klefiTgnO', 1, '2005-12-15', 5, 1, 1),
(19, 'Дроздов', 'Арсений', 'Михайлович', 'admin@local.kz', NULL, '$2y$10$/7oNN.YXdskRMpeRJAPqZuRHJqsrsUV.XHVnJia9/JzthZqhYL4Sq', 1, '1997-07-12', 3, 1, 0),
(22, 'Гурьев', 'Артур', 'Протасьевич', 'gurevvv', NULL, '$2y$10$n8AMg5CxgaCH2ujt2WII1e5UNDR3p4ocRRXiYiu/A6UwmBuvgTD.O', 1, '2023-10-01', 4, 1, 1),
(25, 'Буров', 'Георгий', 'Матвеевич', 'burov', NULL, '$2y$10$xKG6mPSXSLVK/6/wWNtbfuE1WA4RLCUe80syL0eTja5J09EMaHh1.', 1, '1999-05-15', 4, 1, 1),
(38, 'Соловьёва', 'Лея', 'Георгьевна', 'solovieva', NULL, '$2y$10$iH5wNehSfohUxfUTwKSNB.F01vhtYuddPbxUNZADQqgf5weDX7is2', 2, '2000-05-18', 6, 1, 1),
(39, 'Шестаков', 'Бенедикт', 'Русланович', 'shestakov', NULL, '$2y$10$sSfncxp1TVq5wkKWWy/F4.6g1XKTimJXz2QfKQmNcGFW.Nkib5guq', 1, '2002-10-02', 6, 2, 1),
(48, 'test2', 'test2', 'test2', 'test2', NULL, '$2y$10$KgMM268dqpwL.oRtnM.o/.opCP9heolbsII0x2tKGHuHQF9FeFijy', 1, '2023-12-21', 4, 2, 1),
(59, 'test7', 'test7', 'test7', 'test7', NULL, '$2y$10$OEUiq/r9i7tBbrfHoL3RR.SgW6zesAnM0dLqb.TzdONAxT4Y0W9Hi', 1, '2024-02-01', 4, 2, 1),
(80, 'test4', 'test4', 'test4', 'test4', NULL, '$2y$10$pp976ICBJqxGn.KYKz2b6OhlrFdhjEB8GvsPGG.hBjuXvNU6pn58u', 1, '2024-02-29', 4, 1, 1),
(82, 'deleted', 'deleted', 'deleted', 'deleted', NULL, '$2y$10$NIHjHc3c.VDns6IZbzAXweX/kIfWTtsJPHHLIJb708eKVvvN2Rcua', 2, '2024-03-02', 5, 1, 1),
(83, 'testPage', 'testPage', 'testPage', 'testPage', NULL, '$2y$10$h3EC2CNW/zuL4nfGn5m3GeO7labLNebLi2sZuC5Neblur6JVhNBq.', 1, '2024-03-01', 5, 1, 1),
(84, 'testPage2', 'testPage2', 'testPage2', 'testPage2', NULL, '$2y$10$skY0FxghP6Mc6cTmFrDOPeF44ezYeRYx/ZqfAODmf8JgeObsXMYRG', 1, '2024-03-01', 5, 1, 1),
(85, 'forAutoNotice', 'forAutoNotice', 'forAutoNotice', 'forAutoNotice', NULL, '$2y$10$MuGlpXEloMN9nDBfHTS9qeYQrFjxt/yREHxvWa9utCsSq24o5uV3O', 1, '2024-03-11', 6, 2, 1),
(86, 'forAutoNoticeStudent', 'forAutoNoticeStudent', 'forAutoNoticeStudent', 'forAutoNoticeStudent', NULL, '$2y$10$0hsI3ae3OI/4AN01oPLnXuF3Qx8HgWVtaGiGpC1.6PZOXQlmYPmE.', 1, '2024-03-01', 5, 2, 1),
(87, 'testadmin', 'testadmin', 'testadmin', 'testadmin', NULL, '$2y$10$pVe5MlrjJMVoOzwj53pCjeUnrVen51.eV10YQhHM5j/.TH90CNfCi', 1, '2024-03-13', 2, 2, 1),
(88, 'testadmin', 'testadmin', 'testadmin', 'testadmin', NULL, '$2y$10$Dblc3.ukFjNTiXEJmJllLelJLz/ITCSOEbpF6UkB7kLteLJDVQPJu', 1, '2024-03-13', 2, 2, 1),
(89, 'testadmin', 'testadmin', 'testadmin', 'testadmin', NULL, '$2y$10$6nVpUA0Wn.TVr9e1KGOhguTcLn/B.BdKwGg8sP3xzULEUKe2/pa6i', 1, '2024-03-13', 2, 2, 1),
(90, 'testadmin', 'testadmin', 'testadmin', 'testadmin', NULL, '$2y$10$Ck2AmHtSXWMgYBWf.36gMeu4Xdix19939LR9jR5KYtO/29biEd/by', 1, '2024-03-13', 2, 2, 1),
(91, 'testadmin', 'testadmin', 'testadmin', 'testadmin', NULL, '$2y$10$Vo8jGIlFKDlgl8BaWSU2beCIR5ZDutDcdVnqWbsDP8Nezh8T3szBK', 1, '2024-03-13', 3, 4, 1),
(92, 'testadmin', 'testadmin', 'testadmin', 'testadmin', NULL, '$2y$10$ImOJ7xUrI3Rf83OHt39WNumLxsZUWZTI.28bCq7hzw3hu/ETAN/dO', 1, '2024-03-13', 3, 2, 1),
(93, 'test5', 'test5', 'test5', 'test5', NULL, '$2y$10$hOLufC3QkTe/8uoIQGId6uEX4iA9/5I2uAGV4IIEp5/wApd3PnEhq', 1, '2024-03-13', 3, 2, 1),
(94, 'admin2', 'admin2', 'admin2', 'admin2', NULL, '$2y$10$9SOKQ9pYXJB0HBNOdG.n8uTpF9ysi/qUFxiUoHauJUrxGcr1C9Ade', 1, '2024-03-14', 3, 6, 1),
(95, 'admin3', 'admin3', 'admin3', 'admin3', NULL, '$2y$10$PrdGxvEKAeNsUTilWv/gHOcbwO37X.tlZvw0AR591jY.s2VJMfSqy', 1, '2024-03-14', 3, 1, 1),
(96, 'admin4', 'admin4', 'admin4', 'admin4', NULL, '$2y$10$nj8RCuRcLpir8ce4yMV1g.esDBVZ6C4e/eo7isXy5dSOhD2Cx3wRu', 1, '2024-03-14', 3, 1, 1),
(97, 'admin4', 'admin4', 'admin4', 'admin4', NULL, '$2y$10$kiTdMnElxyshOc9hzD69GOs3cgonYhT04eQpgEI464wOAHamEkx7a', 1, '2024-03-14', 3, 1, 1),
(98, 'admin5', 'admin5', 'admin5', 'admin5', NULL, '$2y$10$C.EzbynIs3UcrwMBvFNFTuSJ3t.XMLeGfH/nRKold2e.sB7nNouAu', 1, '2024-03-14', 3, 1, 1),
(99, 'admin6', 'admin6', 'admin6', 'admin6', NULL, '$2y$10$4a8oRnU6SMCkZzidKT7r6OuEftc9Mmxc0Q3RWs/48wpMXXo27GN5K', 1, '2024-03-14', 3, 6, 1),
(100, 'prepodAlma', 'prepodAlma', 'prepodAlma', 'prepodAlma', NULL, '$2y$10$owiL9AnguFWdQBsHPqWr..bo2yCtst4q.PNQyO/6663n.VhfPZfaq', 1, '2024-03-14', 4, 6, 1),
(101, 'admin7', 'admin7', 'admin7', 'admin7', NULL, '$2y$10$0RsV9Zz6s/3WWFJxb1ZEu.fGRHbfk5LIHk4nuJ5RUW0aToZDrrkXO', 1, '2024-03-14', 3, 2, 1),
(102, 'testTeacher2', 'testTeacher2', 'testTeacher2', 'testTeacher2', NULL, '$2y$10$FGx5IGBtsUmWHKYubJPJyOVG5D3RYIPvxy1X1jBpvLBmZlfseLh4G', 1, '2024-03-14', 4, 2, 1),
(103, 'testBranch2', 'testBranch2', 'testBranch2', 'testBranch2', NULL, '$2y$10$RslJe6gGJMog..z/1JrauOi5Z4LE0Lcoc3J3IIatMJ1f.fLopmzWG', 1, '2024-03-10', 5, 2, 1),
(104, 'testTest', 'testTest', 'testTest', 'testTest', NULL, '$2y$10$HgWytxz7hqd.Sf5q0Fq25e8T3jfYU7icOHLUkvDivmaVkClfS6wLW', 1, '2024-03-17', 4, 1001, 1),
(105, 'testForParent', 'testForParent', 'testForParent', 'testForParent@mail.ru', NULL, '$2y$10$TMCYMjQESbQdgyyi1swx7OOoiwPQhNQBEUbO7JseElLnyXu6tPpte', 1, '2024-03-18', 5, 1, 1),
(106, 'testParent', 'testParent', 'testParent', 'testParent', NULL, '$2y$10$nLRpiucgxHoMzpCy/HFxkOBwHK8GVvxClg.2THndRavqK1khyPAKq', 1, '2024-03-18', 6, 1, 1),
(107, 'testTeacher3', 'testTeacher3', 'testTeacher3', 'testTeacher3@local.kz', NULL, '$2y$10$1OuBcnykWI.vUZ5eeEZaauGRaUL5ahI2aBb.7n8qwyxndn5VMebxq', 1, '2024-03-22', 4, 1, 1),
(108, 'test44', 'test44', 'test44', 'asdasdasd@mail.ru', NULL, '$2y$10$5dpIwy0a5P.NcYrRNMYFPOT9P4c81t9dknYK4p1606wHhPmpPtW1e', 2, '2024-04-02', 4, 1, 1),
(110, 'фывфыв', 'фывфывфы', 'вфывфывфывфы', 'asdasd@mail.ru', NULL, '$2y$10$x0/Ld8Zfg2w9X0COurGJIuFa21WNXsqL9E.n2oW4AOTjErRMABeHe', 2, '2024-04-18', 4, 1, 0),
(111, 'asdasd', 'asdasd', 'asdasd', 'asdas@mail.ru', NULL, '$2y$10$dS5gefxKH.91gaCWTTdvL.Q.NOHfN8esKmk7HmyWls6pWPnPh.PA2', 1, '2024-04-16', 4, 1, 0),
(113, 'uchitel', 'uchitel', 'uchitel', 'uchitel', NULL, '$2y$10$OQ28T5QSPNGV8XLVfgu/o.Cq/g27GI07Tc8wIlO/dqjDNCHOB1PyC', 1, '2024-04-19', 4, 1, 0),
(114, 'roditel', 'roditel', 'roditel', 'roditel@local.kz', NULL, '$2y$10$KxGRrohmIa8g96AuImC97.aA0Q6eMt080oTDyqxZ/cB7mn9Q0Wcpy', 1, '2024-04-18', 6, 1, 0),
(115, 'sadaljshdnas', 'fkgjdegklfdngh', 'lkjdfgklfdng', 'test@mail.ru', NULL, '$2y$10$q.uzAAxtTZQBrDJ.v5gWveGgpXJXMDgiAtvh39Ih.UFHmSZhaR.4O', 1, '2024-04-01', 6, 1, 0),
(116, 'admin12345', 'admin12345', 'admin12345', 'admin12345@mail.ru', NULL, '$2y$10$ZmD9D6bjU0uTk.ys/zCs5.SPh5C2J/KDYMw47e.9IyvxNYRd5tqiS', 1, '2024-05-01', 3, 1, 0),
(117, 'uchitel', 'uchitel', 'uchitel', 'uchitel@local.ru', NULL, '$2y$10$LOsSTvoRhCg3Z35wOEHdEu0gAGE5ITKWGo3uoMW1I3aoauGbL504m', 1, '2024-05-01', 4, 1, 0),
(118, 'uchitel', 'uchitel', 'uchitel', 'uchitel@local.kz', NULL, '$2y$10$UqIBrXGgSAWK5rbILrzGyO2pRyXqV4.OOa/ZIZmI9eqPEJ.09jvwG', 1, '2024-04-01', 4, 1, 0),
(119, 'TestAdmin', 'TestAdmin', 'TestAdmin', '123323123', NULL, '$2y$10$.oBzEWq3p0C.58HbUlqkJerpsOPj18Pu3JHdxhXF5ccrRl.bHilfO', 1, '2025-03-25', 3, 1, 0),
(120, 'asdasd', 'asdasd', 'asdasd', '123123', NULL, '123', 1, '2222-02-11', 3, 1, 1),
(121, 'asdsadasd', 'asdasdsadas', 'asdsadasdasd', '123123123', NULL, '$2y$10$DG.6WlIjCmhWzt2X0uIf3.SUDhp8G1q3yJPEcjRHW5vmZ7TphR5/2', 1, '2025-03-27', 3, 1, 1),
(122, 'asdsadsad', 'asdasd', 'asdasdasd', '123123123', NULL, '$2y$10$3F/h3i6tU5BZQhq.liIc3uIVz5F2d/LV5i/7AR/TROpBZcnsT5rJG', 1, '2025-02-24', 5, 1, 1),
(123, 'ТЕСТ', 'ДЛЯ', 'ПОКАЗА', '999', NULL, '$2y$10$W0kthoseijxJABtHTf9rn.tRJsAlV7SJH1WRyeq5AiBO9srVroLse', 1, '2025-03-15', 3, 1, 1),
(124, 'ТЕСТ', 'ДЛЯ', 'ПОКАЗА (УЧИТЕЛь)', '888', NULL, '$2y$10$Ww2tGeD2LWLzsgAFYOsL6eiZXKuDizWHiRnZu7lh8QAxH2tffQTdC', 1, '2025-03-16', 4, 1, 1),
(125, 'ТЕСТ', 'ДЛЯ', 'ПОКАЗА (РОДИТЕЛЬ)', '666', NULL, '$2y$10$jHcZ0fCbaIKJrIEwNCAHOeCgGCsm5rxyAFN1nNyrqLbH2pm1/nXJm', 1, '2025-03-14', 6, 1, 1),
(126, 'ТЕСТ', 'ДЛЯ', 'ПОКАЗА (УЧЕНИК)', '555', NULL, '$2y$10$XzpjUcoDFpBqy4UmlGJvyuvnRd7GQR8KKPCCucEYbkxn6naid6cLq', 1, '2025-02-23', 5, 1, 1),
(127, '11111', '11111', '11111', '1111111', NULL, '$2y$10$SM2aqFCl73GcR7EewDiEeuzUZRU938dLVfyrvQHcOym6/Qc1DKwQm', 1, '2025-03-13', 3, 1, 1),
(128, 'asdasd', 'asdasd', 'asdasd', '12312321', NULL, '$2y$10$XZOSbCM9YgF9ihvTtRIiKucvfad5MJ.clxz8dpX.HeiTyQyL/yRBy', 1, '2025-03-15', 5, 1, 1),
(129, 'asdasdasd', 'asdasdsad', 'asdasdasd', '123123123', NULL, '$2y$10$nP7U5hhaLUepk.koYPvOAOFjpu/cw.FsT4ZSpWc4S6whkisIQY0EC', 1, '2025-03-15', 3, 1, 1),
(130, 'Тест расписания', 'И', 'Оценок', '322', NULL, '$2y$10$ii33HEi79F.UIr5ZiMR4m.ATYWkXJrK.sn4NzIu0eOeOdp88QGTdu', 1, '2025-03-04', 4, 4, 1),
(131, 'тест расписания', 'и', 'оценок (Ученик)', '3222', NULL, '$2y$10$qwVDgFEYMClwd.DeZmVVu.ueCQyAtC6WCfeNlyjGxr5gV1rMhI/hq', 1, '2025-03-11', 5, 4, 1),
(134, 'hjfdnbjfd', 'jdsnvjsdnv', 'djvndfjnv', '777899', NULL, '$2y$10$igR0TNovY4UNwI33dqW04eexEfXff9RJkfC5LOLpUddD7qa.3XReu', 1, '2025-03-11', 3, 1, 1),
(135, 'kdfvjfdnb', 'dnsvjkdnfv', 'lnjjvndfv', '1234321', NULL, '$2y$10$X/n2SIfIQnkU6aolVuleYOFKgComGwJkjf6fFCys6Thj.QrXAdaha', 1, '2025-03-04', 3, 1, 1),
(136, 'studenttest', 'studenttest', 'studenttest', '7770099', NULL, '$2y$10$R2IIefOghUtPxjj5yne1weG3m4eiAQOxCYSakZNgCjPq6Tq3G/Zhi', 1, '2025-03-03', 5, 1, 1),
(137, 'testteacher', 'testteacher', 'testteacher', '77700987', NULL, '$2y$10$MM8MSWnKXuU.BHcp4f1k7u11Irc6BMg2eOgGi73zIqfPZ4EM.FdXO', 1, '2025-03-01', 4, 1, 1),
(138, 'testparent', 'testparent', 'testparent', '7775543', NULL, '$2y$10$nsdaA2aUWudu9u6qsef5neOEygahuvVxXlmWuoCbxB3K0MH2Ujieq', 1, '2025-03-01', 6, 1, 1),
(139, 'Администратор', 'Первого', 'Филиала', '333', NULL, '$2y$10$yFFu55Z2aWSTYInURGUy1.0W5JeGYcOvknst2afUNrTJIKj4gIhni', 1, '2025-03-01', 3, 1, 1),
(140, 'test', 'test', 'test', '111222', NULL, '$2y$10$I4UdiSH0qnNG5O8jOhi0V.QHPY2nUK94grX.u.h08BGAgzdfaxVES', 1, '2025-03-03', 3, 1, 1),
(141, 'Ученик', 'Ученик', 'Ученик', '7713', NULL, '$2y$10$bSzqDrqyj1yrla31/OpuZe6gIHxJN1Ck9Aj6tql5Cr5yQUafNYVzi', 1, '2025-03-10', 5, 1, 1),
(142, 'Родитель', 'Родитель', 'Родитель', '6613', NULL, '$2y$10$0GXJzXYLlkeC2QgmmYZTEu9gXOyioA7kt3EmIypcxNtwftt5RzJNG', 1, '2025-03-01', 6, 1, 1),
(143, 'Администратор', 'Филиала', 'Дарабоз', '7777', NULL, '$2y$10$4oTrsAHhrNWact/RX/ulQ.nSsLcKVGqbJRMuoEePBtxvkWXdMgzuG', 1, '2025-03-27', 3, 4, 1),
(144, 'Тест', 'Филиала', 'Дарабоз', '001', NULL, '$2y$10$gsYQdxXVict314fcv3QhLegfjhCuGQq0mkr2qWxUBu1FAT1y3p4Be', 1, '2025-03-02', 4, 4, 1),
(145, 'Учение', 'Филиала', 'Дарабоз', '002', NULL, '$2y$10$72cay1pYD238tb.Hf0SCqej.E1pP1yzbkP3Bq1oXNT4Ybv2s.srh.', 1, '2025-03-03', 5, 4, 1),
(146, 'Родитель', 'Филиала', 'Дарабоз', '003', NULL, '$2y$10$CkUappIXHvRhLC8I1WhkguFqbYCnETSZocYsK4aIt/7084Sds9X6e', 1, '2025-03-02', 6, 4, 1),
(147, 'Ахматов', 'Владислав', 'Витальевич', '7081756417', NULL, '$2y$10$3GkXbakqzBMaZgGL3NalkuW8Ezd/qcQk6ptu28f4k/fr0cwNF3Jwy', 1, '2025-03-03', 3, 1, 1),
(148, 'Бондарчик', 'Николай', 'Александрович', '7024369260', NULL, '$2y$10$K2ZUNJe5kHYOkObOpn9oi.xfOjmuhzwjQFRpHaY9GNP4uSkOLb1Ge', 1, '2002-01-16', 4, 1, 1),
(150, 'Бондарчик', 'Николай', 'Александрович', '87024369260', NULL, '$2y$10$wnTv1Scijcdoo09puR/d6.MG/SZ9EN.rLyvCI9BwPTfHue7jfljUe', 1, '2025-03-03', 3, 1, 1),
(154, 'Тест', 'Без', 'Пароля', '87772221111', NULL, '', 1, '2025-03-01', 5, 1, 1),
(155, 'Ахматов', 'Владислав', 'Витальевич', '87081756417', NULL, '', 1, '2025-03-02', 6, 1, 1),
(156, 'test', 'test', 'test', '87770009911', '87770009933', '$2y$10$F2mKEROm9dgbv4KtGIwhYuMEFeKJ13Yk/fESnz3h1Vusu0/BivicG', 1, '2025-06-01', 3, 1, 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Индексы таблицы `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `balance`
--
ALTER TABLE `balance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `balance_ibfk_1` (`user_id`);

--
-- Индексы таблицы `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `classroom`
--
ALTER TABLE `classroom`
  ADD PRIMARY KEY (`classroom_id`),
  ADD KEY `branch` (`branch`);

--
-- Индексы таблицы `day`
--
ALTER TABLE `day`
  ADD PRIMARY KEY (`day_id`);

--
-- Индексы таблицы `gender`
--
ALTER TABLE `gender`
  ADD PRIMARY KEY (`gender_id`);

--
-- Индексы таблицы `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`grade_id`),
  ADD KEY `student_id` (`user_id`),
  ADD KEY `attend` (`attend`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `schedule_id` (`schedule_id`);

--
-- Индексы таблицы `gruppa`
--
ALTER TABLE `gruppa`
  ADD PRIMARY KEY (`gruppa_id`),
  ADD KEY `branch` (`branch`);

--
-- Индексы таблицы `notice`
--
ALTER TABLE `notice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `child_id` (`child_id`);

--
-- Индексы таблицы `owner`
--
ALTER TABLE `owner`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `parent`
--
ALTER TABLE `parent`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `child_id` (`child_id`);

--
-- Индексы таблицы `reference`
--
ALTER TABLE `reference`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Индексы таблицы `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `classroom_id` (`classroom_id`),
  ADD KEY `day_id` (`date`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Индексы таблицы `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `gruppa_id` (`gruppa_id`);

--
-- Индексы таблицы `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subject_id`),
  ADD KEY `branch` (`branch`);

--
-- Индексы таблицы `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`user_id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_ibfk_1` (`gender_id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `auth_tokens`
--
ALTER TABLE `auth_tokens`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT для таблицы `balance`
--
ALTER TABLE `balance`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT для таблицы `branch`
--
ALTER TABLE `branch`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1005;

--
-- AUTO_INCREMENT для таблицы `classroom`
--
ALTER TABLE `classroom`
  MODIFY `classroom_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `day`
--
ALTER TABLE `day`
  MODIFY `day_id` tinyint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `gender`
--
ALTER TABLE `gender`
  MODIFY `gender_id` tinyint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `grades`
--
ALTER TABLE `grades`
  MODIFY `grade_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=466;

--
-- AUTO_INCREMENT для таблицы `gruppa`
--
ALTER TABLE `gruppa`
  MODIFY `gruppa_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `notice`
--
ALTER TABLE `notice`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2235;

--
-- AUTO_INCREMENT для таблицы `parent`
--
ALTER TABLE `parent`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT для таблицы `reference`
--
ALTER TABLE `reference`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `role`
--
ALTER TABLE `role`
  MODIFY `role_id` tinyint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `schedule`
--
ALTER TABLE `schedule`
  MODIFY `schedule_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT для таблицы `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `user_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `admin_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`);

--
-- Ограничения внешнего ключа таблицы `balance`
--
ALTER TABLE `balance`
  ADD CONSTRAINT `balance_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `student` (`user_id`),
  ADD CONSTRAINT `balance_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`);

--
-- Ограничения внешнего ключа таблицы `classroom`
--
ALTER TABLE `classroom`
  ADD CONSTRAINT `classroom_ibfk_1` FOREIGN KEY (`branch`) REFERENCES `branch` (`id`);

--
-- Ограничения внешнего ключа таблицы `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `student` (`user_id`),
  ADD CONSTRAINT `grades_ibfk_4` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  ADD CONSTRAINT `grades_ibfk_5` FOREIGN KEY (`schedule_id`) REFERENCES `schedule` (`schedule_id`);

--
-- Ограничения внешнего ключа таблицы `gruppa`
--
ALTER TABLE `gruppa`
  ADD CONSTRAINT `gruppa_ibfk_2` FOREIGN KEY (`branch`) REFERENCES `branch` (`id`);

--
-- Ограничения внешнего ключа таблицы `notice`
--
ALTER TABLE `notice`
  ADD CONSTRAINT `notice_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `notice_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`),
  ADD CONSTRAINT `notice_ibfk_3` FOREIGN KEY (`child_id`) REFERENCES `user` (`user_id`);

--
-- Ограничения внешнего ключа таблицы `owner`
--
ALTER TABLE `owner`
  ADD CONSTRAINT `owner_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Ограничения внешнего ключа таблицы `parent`
--
ALTER TABLE `parent`
  ADD CONSTRAINT `parent_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `parent_ibfk_2` FOREIGN KEY (`child_id`) REFERENCES `user` (`user_id`);

--
-- Ограничения внешнего ключа таблицы `reference`
--
ALTER TABLE `reference`
  ADD CONSTRAINT `reference_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `student` (`user_id`);

--
-- Ограничения внешнего ключа таблицы `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`classroom_id`) REFERENCES `classroom` (`classroom_id`),
  ADD CONSTRAINT `schedule_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `gruppa` (`gruppa_id`),
  ADD CONSTRAINT `schedule_ibfk_3` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`),
  ADD CONSTRAINT `schedule_ibfk_4` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`user_id`);

--
-- Ограничения внешнего ключа таблицы `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `student_ibfk_2` FOREIGN KEY (`gruppa_id`) REFERENCES `gruppa` (`gruppa_id`);

--
-- Ограничения внешнего ключа таблицы `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `teacher_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
