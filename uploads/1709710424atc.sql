-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 06 2024 г., 09:08
-- Версия сервера: 8.0.19
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `atc`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admin`
--

CREATE TABLE `admin` (
  `user_id` bigint NOT NULL,
  `branch_id` int DEFAULT NULL,
  `deleted` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `admin`
--

INSERT INTO `admin` (`user_id`, `branch_id`, `deleted`) VALUES
(2, 1, 0),
(15, 1, 0),
(16, 3, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `attend`
--

CREATE TABLE `attend` (
  `id` tinyint NOT NULL,
  `attend` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `attend`
--

INSERT INTO `attend` (`id`, `attend`) VALUES
(0, 'Н'),
(1, 'Б');

-- --------------------------------------------------------

--
-- Структура таблицы `awards`
--

CREATE TABLE `awards` (
  `id` int NOT NULL,
  `user_id` bigint NOT NULL,
  `subject_id` int DEFAULT NULL,
  `award` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `awards`
--

INSERT INTO `awards` (`id`, `user_id`, `subject_id`, `award`) VALUES
(16, 6, 3, '4');

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
(1, 'Филиал 1', '2024-02-01', 0),
(2, 'Филиал 2', '2024-02-02', 0),
(3, 'Филиал 3', '2024-02-03', 0),
(999, 'Для менеджера', '2024-02-04', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `classroom`
--

CREATE TABLE `classroom` (
  `classroom_id` int NOT NULL,
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch` int DEFAULT NULL,
  `active` tinyint NOT NULL,
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
(5, '3/516', 1, 1, 0);

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
  `subject_id` int NOT NULL,
  `grade` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `attend` tinyint DEFAULT NULL,
  `comment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `homework` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `grade_accept`
--

CREATE TABLE `grade_accept` (
  `id` int NOT NULL,
  `user_id` bigint NOT NULL,
  `subject_id` int DEFAULT NULL,
  `grade` int DEFAULT NULL,
  `date` date DEFAULT NULL,
  `attend` tinyint DEFAULT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `homework` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` int NOT NULL,
  `reason` tinyint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `grade_accept`
--

INSERT INTO `grade_accept` (`id`, `user_id`, `subject_id`, `grade`, `date`, `attend`, `comment`, `homework`, `branch_id`, `reason`) VALUES
(286, 18, 5, 0, '2023-12-07', 0, NULL, NULL, 1, 1),
(287, 18, 5, 50, '2023-12-07', 1, NULL, NULL, 1, NULL),
(288, 18, 5, 0, '2023-12-15', 0, NULL, NULL, 1, NULL),
(290, 18, 5, 70, '2023-12-15', 1, NULL, NULL, 1, NULL),
(297, 18, NULL, 60, '2023-12-15', 1, NULL, NULL, 1, NULL),
(299, 18, 5, 50, '2023-12-15', 1, NULL, NULL, 1, NULL),
(301, 8, NULL, 90, '2023-12-15', 1, NULL, NULL, 2, NULL),
(304, 18, 5, 90, '2023-12-23', 1, NULL, NULL, 1, NULL),
(305, 9, NULL, 90, '2023-12-30', 0, NULL, NULL, 1, NULL),
(306, 18, NULL, 50, '2023-12-30', 1, NULL, NULL, 1, NULL),
(308, 9, NULL, 90, '2023-12-30', 0, NULL, NULL, 1, NULL),
(310, 9, NULL, 100, '2023-12-30', 0, NULL, NULL, 1, NULL),
(311, 7, 5, 99, '2024-02-24', 0, 'test1', '1708790972_test.txt', 1, NULL),
(312, 7, 5, 99, '2024-02-24', 0, 'test2', '1708791101_test.txt', 1, NULL),
(313, 7, 3, 0, '2024-03-03', 0, '123', '', 1, 0),
(314, 8, 3, 0, '2024-03-03', 0, '123', '', 1, 0),
(315, 18, 3, 0, '2024-03-03', 0, '123', '', 1, 0),
(316, 18, 3, 0, '2024-03-03', 0, '123', '', 1, 0),
(317, 7, 3, 0, '2024-03-03', 0, '', '', 1, 0),
(318, 8, 3, 0, '2024-03-03', 0, '', '', 1, 0),
(319, 7, 3, 0, '2024-03-03', 0, '', '', 1, 0),
(320, 8, 3, 90, '2024-03-03', 1, '5676', '', 1, NULL),
(321, 7, 3, 55, '2024-03-03', 1, '123', '', 1, NULL),
(322, 8, 3, 100, '2024-03-03', 1, '', '', 1, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `gruppa`
--

CREATE TABLE `gruppa` (
  `gruppa_id` int NOT NULL,
  `name` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `special_id` int NOT NULL,
  `date_begin` date NOT NULL,
  `date_end` date DEFAULT NULL,
  `branch` int DEFAULT NULL,
  `deleted` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `gruppa`
--

INSERT INTO `gruppa` (`gruppa_id`, `name`, `special_id`, `date_begin`, `date_end`, `branch`, `deleted`) VALUES
(1, '7В', 11, '2022-11-06', '2022-11-16', 1, 0),
(2, '7А', 3, '2023-10-01', '2023-10-31', 1, 0),
(3, '8В', 11, '2023-09-01', '2025-06-10', 1, 0),
(4, '7А', 13, '2020-01-31', '2026-10-24', 2, 0),
(5, '9А', 3, '2023-11-01', '2023-11-30', 2, 0),
(7, 'deleted', 11, '2024-03-01', '2024-03-31', 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `homework_parent`
--

CREATE TABLE `homework_parent` (
  `id` bigint NOT NULL,
  `homework_teacher_id` bigint NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `teacher_id` bigint NOT NULL,
  `gruppa_id` int NOT NULL,
  `student_id` bigint NOT NULL,
  `date_begin` date NOT NULL,
  `date_end` date DEFAULT NULL,
  `subject_id` int NOT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_prepared` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `homework_parent`
--

INSERT INTO `homework_parent` (`id`, `homework_teacher_id`, `name`, `teacher_id`, `gruppa_id`, `student_id`, `date_begin`, `date_end`, `subject_id`, `file`, `file_prepared`) VALUES
(7, 13, 'asd', 6, 2, 8, '2023-12-21', '2023-12-31', 5, '1703641302_Оценки_1702869853.xlsx', '1703641317_Оценки_1702869853.xlsx'),
(8, 13, 'asd', 6, 2, 8, '2023-12-21', '2023-12-31', 5, '1703641302_Оценки_1702869853.xlsx', '1703641356_Оценки_1702869853.xlsx');

-- --------------------------------------------------------

--
-- Структура таблицы `homework_teacher`
--

CREATE TABLE `homework_teacher` (
  `id` bigint NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint NOT NULL,
  `gruppa_id` int NOT NULL,
  `date_begin` date NOT NULL,
  `date_end` date DEFAULT NULL,
  `subject_id` int NOT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `homework_teacher`
--

INSERT INTO `homework_teacher` (`id`, `name`, `user_id`, `gruppa_id`, `date_begin`, `date_end`, `subject_id`, `file`) VALUES
(13, 'asd', 6, 2, '2023-12-21', '2023-12-31', 5, '1703641302_Оценки_1702869853.xlsx');

-- --------------------------------------------------------

--
-- Структура таблицы `lesson_num`
--

CREATE TABLE `lesson_num` (
  `lesson_num_id` int NOT NULL,
  `name` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_lesson` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `lesson_num`
--

INSERT INTO `lesson_num` (`lesson_num_id`, `name`, `time_lesson`) VALUES
(1, '1 пара', '08:30:00'),
(2, '2 пара', '10:10:00'),
(3, '3 пара', '12:20:00'),
(4, '4 пара', '14:00:00'),
(5, '5 пара', '15:40:00');

-- --------------------------------------------------------

--
-- Структура таблицы `lesson_plan`
--

CREATE TABLE `lesson_plan` (
  `lesson_plan_id` int NOT NULL,
  `gruppa_id` int NOT NULL,
  `subject_id` int DEFAULT NULL,
  `user_id` bigint NOT NULL,
  `deleted` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `lesson_plan`
--

INSERT INTO `lesson_plan` (`lesson_plan_id`, `gruppa_id`, `subject_id`, `user_id`, `deleted`) VALUES
(1, 1, NULL, 6, 0),
(2, 2, 16, 6, 0);

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
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `deleted` tinyint DEFAULT '0',
  `canceled` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `notice`
--

INSERT INTO `notice` (`id`, `text`, `subject_id`, `user_id`, `child_id`, `subject_count`, `subject_price`, `link`, `date`, `deleted`, `canceled`) VALUES
(23, 'Оплатите до указанного срока по предмету:', 3, 10, 7, 5, 8750, 'https://example.com', '2024-03-04', 1, 0),
(24, 'Оплатите сумму указанную в приложении', 3, 10, 7, 3, 6000, 'https://example.com', '2024-03-04', 1, 0),
(25, 'Оплатите сумму указанную в приложении', 3, 39, 8, 1, 2500, 'https://example.com', '2024-03-04', 0, 0),
(26, 'Оплатите сумму', 3, 10, 7, 2, 2750, 'https://example.com', '2024-03-04', 1, 0),
(27, 'Оплатите сумму указанную в приложении', 3, 10, 7, 123, 92250, 'https://example.com', '2024-03-05', 1, 0),
(30, 'test', 3, 10, 7, 123, 92250, NULL, NULL, 0, 1),
(31, 'asd', 3, 10, 7, 123, 92250, NULL, NULL, 0, 1),
(32, 'asd', 3, 10, 7, 123, 92250, NULL, NULL, 0, 1),
(33, 'Оплатите сумму', 3, 10, 7, 12, 13510, 'https://example.com', '2024-03-05', 0, 0),
(34, 'Оплатите сумму указанную в приложении', 3, 10, 7, 2, 1150, 'https://example.com', '2024-03-05', 1, 0),
(35, 'Оплатите сумму указанную в приложении', 3, 10, 7, 5, 2000, 'https://example.com', '2024-03-05', 0, 0),
(36, 'Оплатите сумму указанную в приложении', 3, 10, 9, 5, 2000, 'https://example.com', '2024-03-05', 0, 0),
(37, 'Оплатите сумму указанную в приложении', 3, 11, 8, 5, 2000, 'https://example.com', '2024-03-05', 0, 0),
(38, 'Оплатите сумму указанную в приложении', 3, 10, 7, 5, 2000, 'https://example.com', '2024-03-05', 0, 0),
(39, 'Оплатите сумму указанную в приложении', 3, 39, NULL, 5, 2000, 'https://example.com', '2024-03-05', 0, 0),
(40, 'Оплатите сумму указанную в приложении', 3, 39, 8, 5, 2000, 'https://example.com', '2024-03-05', 0, 0),
(42, 'Оплатите сумму указанную в приложении', 3, 10, 7, 5, 2000, 'https://example.com', '2024-03-05', 0, 0),
(43, 'Оплатите сумму указанную в приложении', 3, 10, 9, 5, 2000, 'https://example.com', '2024-03-05', 0, 0),
(44, 'Оплатите сумму указанную в приложении', 3, 10, 7, 5, 2000, 'https://example.com', '2024-03-05', 0, 0),
(45, 'Оплатите сумму указанную в приложении', 3, 39, NULL, 5, 2000, 'https://example.com', '2024-03-05', 0, 0),
(46, 'Оплатите сумму указанную в приложении', 3, 39, 8, 5, 2000, 'https://example.com', '2024-03-05', 0, 0),
(48, 'Оплатите сумму указанную в приложении', 3, 10, 7, 5, 2000, 'https://example.com', '2024-03-05', 0, 0),
(49, 'Оплатите сумму указанную в приложении', 3, 10, 9, 5, 2000, 'https://example.com', '2024-03-05', 0, 0),
(50, 'Оплатите сумму указанную в приложении', 3, 10, 7, 5, 2000, 'https://example.com', '2024-03-05', 0, 0),
(51, 'Оплатите сумму указанную в приложении', 3, 39, NULL, 5, 2000, 'https://example.com', '2024-03-05', 0, 0),
(52, 'Оплатите сумму указанную в приложении', 3, 39, 8, 5, 2000, 'https://example.com', '2024-03-05', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `otdel`
--

CREATE TABLE `otdel` (
  `otdel_id` smallint NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint NOT NULL,
  `deleted` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `otdel`
--

INSERT INTO `otdel` (`otdel_id`, `name`, `active`, `deleted`) VALUES
(2, 'Гуманитарный', 1, 0),
(6, 'for delete', 1, 1),
(7, 'Математический', 1, 0),
(8, 'Естественные науки', 1, 0);

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
(9, 10, 7, 0),
(10, 39, NULL, 0),
(11, 39, 8, 0),
(12, 38, 7, 1),
(13, 10, 42, 0),
(17, 10, 18, 0),
(18, 10, 37, 0),
(19, 11, 8, 1),
(21, 10, 18, 0),
(22, 10, 7, 0),
(23, 10, 8, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `payment`
--

CREATE TABLE `payment` (
  `id` int NOT NULL,
  `parent_id` bigint DEFAULT NULL,
  `child_id` bigint DEFAULT NULL,
  `subject_id` int DEFAULT NULL,
  `count` int DEFAULT NULL,
  `tab` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` int DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `payment`
--

INSERT INTO `payment` (`id`, `parent_id`, `child_id`, `subject_id`, `count`, `tab`, `price`, `link`, `deleted`) VALUES
(139, 10, 7, 3, 123, '1709608460тз.docx', 92250, 'https://example.com', 1),
(140, 10, 7, 3, 2, '1709612909тз.docx', 1150, 'https://example.com', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `payment_archive`
--

CREATE TABLE `payment_archive` (
  `id` int NOT NULL,
  `parent_id` bigint NOT NULL,
  `child_id` bigint NOT NULL,
  `subject_id` int DEFAULT NULL,
  `count` int NOT NULL,
  `tab` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` int DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attend` tinyint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `payment_archive`
--

INSERT INTO `payment_archive` (`id`, `parent_id`, `child_id`, `subject_id`, `count`, `tab`, `price`, `link`, `attend`) VALUES
(39, 10, 7, 3, 27, '1699588308ПРОЧИТАЙ!!!!!!!!!!!.txt', 5000, NULL, 1),
(41, 10, 7, 5, -1, '1699588319ПРОЧИТАЙ!!!!!!!!!!!.txt', 5000, NULL, 1),
(78, 10, 9, 5, 8, '1699682118ПРОЧИТАЙ!!!!!!!!!!!.txt', 50000, NULL, 1),
(93, 10, 9, 3, 10, '1700012243ПРОЧИТАЙ!!!!!!!!!!!.txt', 50000, NULL, 1),
(96, 10, 42, 5, 8, '1701246675', 50000, NULL, 1),
(97, 10, 18, 5, 1, '1701912986iqstudy.zip', 50000, NULL, 1),
(98, 10, 18, 3, 10, '1701913128iqstudy.txt', 50000, NULL, 1),
(99, 10, 37, 5, 1, '1702611363iqstudy.txt', 50000, NULL, 1),
(103, 11, 8, 3, 85, '1702612783iqstudy.txt', 450000, NULL, 1);

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
(2, 'admin', 'Администратор', 1),
(3, 'manager', 'Менеджер', 1),
(4, 'teacher', 'Преподаватель', 1),
(5, 'student', 'Студент', 1),
(6, 'procreator', 'Родитель', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `schedule`
--

CREATE TABLE `schedule` (
  `schedule_id` int NOT NULL,
  `lesson_plan_id` int NOT NULL,
  `day_id` tinyint NOT NULL,
  `lesson_num_id` int NOT NULL,
  `classroom_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `schedule`
--

INSERT INTO `schedule` (`schedule_id`, `lesson_plan_id`, `day_id`, `lesson_num_id`, `classroom_id`) VALUES
(1, 1, 2, 1, 1),
(2, 1, 2, 2, 5),
(3, 1, 2, 3, 5),
(4, 2, 1, 3, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `special`
--

CREATE TABLE `special` (
  `special_id` int NOT NULL,
  `name` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `otdel_id` int DEFAULT NULL,
  `active` tinyint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `special`
--

INSERT INTO `special` (`special_id`, `name`, `otdel_id`, `active`) VALUES
(3, 'А', 7, 1),
(10, 'Б', NULL, 1),
(11, 'В', NULL, 1),
(12, 'Г', 2, 1),
(13, 'Д', 2, 1);

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
(9, 3, NULL, '0', 0),
(18, 1, NULL, '0', 0),
(82, 2, NULL, '0', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `subject`
--

CREATE TABLE `subject` (
  `subject_id` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `otdel_id` int DEFAULT NULL,
  `hours` smallint NOT NULL,
  `active` tinyint NOT NULL,
  `deleted` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `subject`
--

INSERT INTO `subject` (`subject_id`, `name`, `otdel_id`, `hours`, `active`, `deleted`) VALUES
(3, 'Литература', 2, 40, 1, 0),
(5, 'География', 8, 50, 1, 0),
(16, 'Математика', 7, 40, 1, 0),
(17, 'Биология', 8, 40, 1, 0),
(18, 'Геометрия', 7, 55, 1, 0),
(19, 'for delete', 8, 5, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `teacher`
--

CREATE TABLE `teacher` (
  `user_id` bigint NOT NULL,
  `otdel_id` int DEFAULT NULL,
  `deleted` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `teacher`
--

INSERT INTO `teacher` (`user_id`, `otdel_id`, `deleted`) VALUES
(6, 2, 0),
(12, 2, 0),
(14, 7, 0),
(17, NULL, 1),
(22, NULL, 1),
(25, NULL, 1),
(48, NULL, 1),
(59, NULL, 1);

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
  `pass` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender_id` tinyint NOT NULL,
  `birthday` date DEFAULT NULL,
  `role_id` tinyint NOT NULL,
  `branch_id` int DEFAULT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'default.png',
  `active` tinyint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`user_id`, `lastname`, `firstname`, `patronymic`, `login`, `pass`, `gender_id`, `birthday`, `role_id`, `branch_id`, `photo`, `active`) VALUES
(2, 'Смит', 'Джон', 'Тимофеевич', 'admin', '$2y$10$kkAc3Z1kd7baFhhpVj98feshP7nhhY8IeT7L04xY9I4PuuhKT3Aii', 1, '2023-11-01', 2, 1, NULL, 1),
(6, 'Ершов', 'Максимилиан', 'Иосифович', 'ershov', '$2y$10$XenEZZklP4BgHomgpZxBgeYT/xOy3KMg3MN8syJI28x8ygg5bJbRO', 1, '2000-03-12', 4, 1, NULL, 1),
(7, 'Носов', 'Клим', 'Алексеевич', 'nosov', '$2y$10$nxM0K958xhTYCpJekKAVzOLLTIkYiZs.R/VbUQ8VcX2dels8mEn5i', 1, '2007-05-25', 5, 1, '1708485498_asd.jpg', 1),
(8, 'Шаров', 'Корней', 'Ростиславович', 'sharov', '$2y$10$hosMfj/tIw48P0tYCaQ1IuBwj6UYV9klgDsaVh/t5SxDcgPjAb7WS', 1, '2023-10-01', 5, 1, '1708791335_wallpaper.png', 1),
(9, 'Антонова', 'Асида', 'Игнатьевна', 'asida', '$2y$10$TE2o./47eSpX8WaCSQ.O2uzlks.vLNjIjE6tv5qtcg7eavAYMqO0q', 2, '2003-02-20', 5, 1, '1708400431_asd.jpg', 1),
(10, 'Беспалов', 'Агафон', 'Даниилович', 'bespalov', '$2y$10$z11Uv1aXozyKpN07XKTNm.VTf9AHH95kfmyOtmOvuVPuoSh4SyGTq', 1, '1980-12-12', 6, 1, NULL, 1),
(11, 'Карпов', 'Антон', 'Онисимович', 'karpov', '$2y$10$yOW62BB4F8KYnC/Zs95xGeI7HnlX2Rxpdu9qkVInJDRV0igjzbZpq', 1, '1980-11-12', 6, 1, NULL, 1),
(12, 'Гришин', 'Мечеслав', 'Христофорович', 'grishin', '$2y$10$HiUHq9eyUODAWKKvKb072eJFP2mmX993WlE2yvSHlx0X6JqMftKEe', 1, '2002-12-20', 4, 2, NULL, 1),
(14, 'Макаров', 'Михаил', 'Робертович', 'makarov', '$2y$10$Bq7MUyKFpI7sW1SfJvFMBOyXj286ZPVsxenSHLHI.omqV5x1QzZe.', 1, '1977-06-05', 4, 1, NULL, 1),
(15, 'Андреев ', 'Венедикт ', 'Святославович', 'admin2', '$2y$10$mFlJsQgNvDQ27XfADrMh8O9OQA47f2gLmqYdwGeg8SpsvdoRUX95S', 1, '1975-08-03', 2, 2, NULL, 1),
(16, 'Лебедев', 'Альфред ', 'Викторович', 'admin3', '$2y$10$mFlJsQgNvDQ27XfADrMh8O9OQA47f2gLmqYdwGeg8SpsvdoRUX95S', 1, '1997-07-12', 2, 3, NULL, 1),
(17, 'Соловьёв', 'Бронислав', 'Федотович', 'soloviev', '$2y$10$hwoeqR.h7cOSrs8mPHnbm.bmDXUd/2i4Xg968skfMTFQ.gQystHdC', 1, '1999-05-14', 4, 2, NULL, 1),
(18, 'Кошелев', 'Эрнест', 'Лаврентьевич', 'koshelev', '$2y$10$mlU3F7DiiEWPXzdfjPiHseYtchL0YITkhg9XOGz72xF.klefiTgnO', 1, '2005-12-15', 5, 1, NULL, 1),
(19, 'Дроздов ', 'Арсений', 'Михайлович', 'manager', '$2y$10$b2rzVJlTsd5hthE.zcAeVuAiFRilDqXrCWGTpn3p6DXxZQNX6v1Di', 1, '1997-07-12', 3, 999, NULL, 1),
(22, 'Гурьев', 'Артур', 'Протасьевич', 'gurevvv', '$2y$10$n8AMg5CxgaCH2ujt2WII1e5UNDR3p4ocRRXiYiu/A6UwmBuvgTD.O', 1, '2023-10-01', 4, 1, '1708318625_asdasd.jpg', 1),
(25, 'Буров', 'Георгий', 'Матвеевич', 'burov', '$2y$10$xKG6mPSXSLVK/6/wWNtbfuE1WA4RLCUe80syL0eTja5J09EMaHh1.', 1, '1999-05-15', 4, 1, NULL, 1),
(38, 'Соловьёва', 'Лея', 'Георгьевна', 'solovieva', '$2y$10$iH5wNehSfohUxfUTwKSNB.F01vhtYuddPbxUNZADQqgf5weDX7is2', 2, '2000-05-18', 6, 1, NULL, 1),
(39, 'Шестаков', 'Бенедикт', 'Русланович', 'shestakov', '$2y$10$sSfncxp1TVq5wkKWWy/F4.6g1XKTimJXz2QfKQmNcGFW.Nkib5guq', 1, '2002-10-02', 6, 2, NULL, 1),
(48, 'test2', 'test2', 'test2', 'test2', '$2y$10$KgMM268dqpwL.oRtnM.o/.opCP9heolbsII0x2tKGHuHQF9FeFijy', 1, '2023-12-21', 4, 2, NULL, 1),
(59, 'test7', 'test7', 'test7', 'test7', '$2y$10$OEUiq/r9i7tBbrfHoL3RR.SgW6zesAnM0dLqb.TzdONAxT4Y0W9Hi', 1, '2024-02-01', 4, 2, 'default.png', 1),
(80, 'test4', 'test4', 'test4', 'test4', '$2y$10$pp976ICBJqxGn.KYKz2b6OhlrFdhjEB8GvsPGG.hBjuXvNU6pn58u', 1, '2024-02-29', 4, 1, 'default.png', 1),
(82, 'deleted', 'deleted', 'deleted', 'deleted', '$2y$10$NIHjHc3c.VDns6IZbzAXweX/kIfWTtsJPHHLIJb708eKVvvN2Rcua', 2, '2024-03-02', 5, 1, 'default.png', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admin`
--
ALTER TABLE `admin`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Индексы таблицы `attend`
--
ALTER TABLE `attend`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `awards`
--
ALTER TABLE `awards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `subject_id` (`subject_id`);

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
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `attend` (`attend`);

--
-- Индексы таблицы `grade_accept`
--
ALTER TABLE `grade_accept`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `attend` (`attend`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Индексы таблицы `gruppa`
--
ALTER TABLE `gruppa`
  ADD PRIMARY KEY (`gruppa_id`),
  ADD KEY `special_id` (`special_id`),
  ADD KEY `branch` (`branch`);

--
-- Индексы таблицы `homework_parent`
--
ALTER TABLE `homework_parent`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gruppa_id` (`gruppa_id`),
  ADD KEY `homework_teacher_id` (`homework_teacher_id`),
  ADD KEY `homework_parent_ibfk_3` (`teacher_id`),
  ADD KEY `homework_parent_ibfk_2` (`student_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Индексы таблицы `homework_teacher`
--
ALTER TABLE `homework_teacher`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `gruppa_id` (`gruppa_id`);

--
-- Индексы таблицы `lesson_num`
--
ALTER TABLE `lesson_num`
  ADD PRIMARY KEY (`lesson_num_id`);

--
-- Индексы таблицы `lesson_plan`
--
ALTER TABLE `lesson_plan`
  ADD PRIMARY KEY (`lesson_plan_id`),
  ADD KEY `gruppa_id` (`gruppa_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `notice`
--
ALTER TABLE `notice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `child_id` (`child_id`);

--
-- Индексы таблицы `otdel`
--
ALTER TABLE `otdel`
  ADD PRIMARY KEY (`otdel_id`);

--
-- Индексы таблицы `parent`
--
ALTER TABLE `parent`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `child_id` (`child_id`);

--
-- Индексы таблицы `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `child_id` (`child_id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Индексы таблицы `payment_archive`
--
ALTER TABLE `payment_archive`
  ADD PRIMARY KEY (`id`),
  ADD KEY `child_id` (`child_id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `subject_id` (`subject_id`);

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
  ADD KEY `day_id` (`day_id`),
  ADD KEY `lesson_plan_id` (`lesson_plan_id`),
  ADD KEY `lesson_plan_num` (`lesson_num_id`);

--
-- Индексы таблицы `special`
--
ALTER TABLE `special`
  ADD PRIMARY KEY (`special_id`),
  ADD KEY `otdel_id` (`otdel_id`);

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
  ADD KEY `otdel_id` (`otdel_id`);

--
-- Индексы таблицы `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `otdel_id` (`otdel_id`);

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
-- AUTO_INCREMENT для таблицы `awards`
--
ALTER TABLE `awards`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `branch`
--
ALTER TABLE `branch`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

--
-- AUTO_INCREMENT для таблицы `classroom`
--
ALTER TABLE `classroom`
  MODIFY `classroom_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `grade_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=343;

--
-- AUTO_INCREMENT для таблицы `grade_accept`
--
ALTER TABLE `grade_accept`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=323;

--
-- AUTO_INCREMENT для таблицы `gruppa`
--
ALTER TABLE `gruppa`
  MODIFY `gruppa_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `homework_parent`
--
ALTER TABLE `homework_parent`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `homework_teacher`
--
ALTER TABLE `homework_teacher`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `lesson_num`
--
ALTER TABLE `lesson_num`
  MODIFY `lesson_num_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `lesson_plan`
--
ALTER TABLE `lesson_plan`
  MODIFY `lesson_plan_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `notice`
--
ALTER TABLE `notice`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT для таблицы `otdel`
--
ALTER TABLE `otdel`
  MODIFY `otdel_id` smallint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `parent`
--
ALTER TABLE `parent`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT для таблицы `payment_archive`
--
ALTER TABLE `payment_archive`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

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
  MODIFY `schedule_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `special`
--
ALTER TABLE `special`
  MODIFY `special_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `user_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `admin_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `awards`
--
ALTER TABLE `awards`
  ADD CONSTRAINT `awards_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `awards_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `classroom`
--
ALTER TABLE `classroom`
  ADD CONSTRAINT `classroom_ibfk_1` FOREIGN KEY (`branch`) REFERENCES `branch` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `student` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `grades_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `grades_ibfk_3` FOREIGN KEY (`attend`) REFERENCES `attend` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `grade_accept`
--
ALTER TABLE `grade_accept`
  ADD CONSTRAINT `grade_accept_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `grade_accept_ibfk_3` FOREIGN KEY (`attend`) REFERENCES `attend` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `grade_accept_ibfk_4` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `gruppa`
--
ALTER TABLE `gruppa`
  ADD CONSTRAINT `gruppa_ibfk_1` FOREIGN KEY (`special_id`) REFERENCES `special` (`special_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `gruppa_ibfk_2` FOREIGN KEY (`branch`) REFERENCES `branch` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `homework_parent`
--
ALTER TABLE `homework_parent`
  ADD CONSTRAINT `homework_parent_ibfk_1` FOREIGN KEY (`gruppa_id`) REFERENCES `gruppa` (`gruppa_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `homework_parent_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `homework_parent_ibfk_3` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `homework_parent_ibfk_4` FOREIGN KEY (`homework_teacher_id`) REFERENCES `homework_teacher` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `homework_parent_ibfk_5` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `homework_teacher`
--
ALTER TABLE `homework_teacher`
  ADD CONSTRAINT `homework_teacher_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `homework_teacher_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `homework_teacher_ibfk_3` FOREIGN KEY (`gruppa_id`) REFERENCES `gruppa` (`gruppa_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `lesson_plan`
--
ALTER TABLE `lesson_plan`
  ADD CONSTRAINT `lesson_plan_ibfk_1` FOREIGN KEY (`gruppa_id`) REFERENCES `gruppa` (`gruppa_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `lesson_plan_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `lesson_plan_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `teacher` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `notice`
--
ALTER TABLE `notice`
  ADD CONSTRAINT `notice_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `notice_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `notice_ibfk_3` FOREIGN KEY (`child_id`) REFERENCES `user` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `parent`
--
ALTER TABLE `parent`
  ADD CONSTRAINT `parent_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_4` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `payment_archive`
--
ALTER TABLE `payment_archive`
  ADD CONSTRAINT `payment_archive_ibfk_3` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `reference`
--
ALTER TABLE `reference`
  ADD CONSTRAINT `reference_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `student` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`classroom_id`) REFERENCES `classroom` (`classroom_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `schedule_ibfk_2` FOREIGN KEY (`day_id`) REFERENCES `day` (`day_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `schedule_ibfk_3` FOREIGN KEY (`lesson_plan_id`) REFERENCES `lesson_plan` (`lesson_plan_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `schedule_ibfk_4` FOREIGN KEY (`lesson_num_id`) REFERENCES `lesson_num` (`lesson_num_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `student_ibfk_2` FOREIGN KEY (`gruppa_id`) REFERENCES `gruppa` (`gruppa_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `teacher_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`gender_id`) REFERENCES `gender` (`gender_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `user_ibfk_3` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
