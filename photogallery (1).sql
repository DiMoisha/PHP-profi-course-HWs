-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 03 2022 г., 23:06
-- Версия сервера: 8.0.24
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `photogallery`
--

-- --------------------------------------------------------

--
-- Структура таблицы `images`
--

CREATE TABLE `images` (
  `imageid` int NOT NULL,
  `imagename` varchar(100) NOT NULL COMMENT 'Image file name',
  `imagetype` varchar(20) DEFAULT NULL COMMENT 'Image file type',
  `imagelocation` varchar(254) NOT NULL COMMENT 'Image file location on server',
  `imagesize` int NOT NULL DEFAULT '0' COMMENT 'Image file size',
  `viewcount` int DEFAULT '0' COMMENT 'View image counter',
  `datecreate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Datetime file create on DB'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `images`
--

INSERT INTO `images` (`imageid`, `imagename`, `imagetype`, `imagelocation`, `imagesize`, `viewcount`, `datecreate`) VALUES
(10, 'mitsubishi-pajero-4-600x450.jpg', 'jpg', 'images/mitsubishi-pajero-4-600x450.jpg', 25956, 3, '2022-01-02 06:47:06'),
(11, 'pajero 4.png', 'png', 'images/pajero 4.png', 152750, 2, '2022-01-02 06:44:33'),
(12, '9may.png', 'png', 'images/9may.png', 1083322, 0, '2021-12-24 20:51:33'),
(13, 'KAN.jpg', 'jpg', 'images/KAN.jpg', 5905, 5, '2022-01-02 06:43:40'),
(14, 'IMG_5755.jpg', 'jpg', 'images/IMG_5755.jpg', 26149, 5, '2022-01-29 14:30:35'),
(15, 'report.png', 'png', 'images/report.png', 123530, 2, '2021-12-24 21:04:18'),
(16, 'IMG_20210607_105012.jpg', 'jpg', 'images/IMG_20210607_105012.jpg', 1495874, 2, '2022-01-02 06:45:38'),
(17, 'IMG_20210607_105416.jpg', 'jpg', 'images/IMG_20210607_105416.jpg', 1802174, 2, '2022-01-02 06:45:13'),
(18, '17467914.png', 'png', 'images/17467914.png', 354033, 4, '2022-01-02 06:43:05'),
(19, '14332682.jpg', 'jpg', 'images/14332682.jpg', 243632, 2, '2022-01-02 06:44:46'),
(20, '20111123-1.jpg', 'jpg', 'images/20111123-1.jpg', 246639, 2, '2022-01-02 06:45:47'),
(21, '270809001856.jpg', 'jpg', 'images/270809001856.jpg', 398589, 2, '2022-01-02 06:46:02'),
(22, '0_8ff86_7c813df3_L.jpg', 'jpg', 'images/0_8ff86_7c813df3_L.jpg', 41786, 7, '2022-01-02 06:43:32'),
(23, '150206161146.jpeg', 'jpeg', 'images/150206161146.jpeg', 60662, 4, '2022-01-02 06:44:23'),
(24, 'cossacks.jpg', 'jpg', 'images/cossacks.jpg', 295491, 4, '2022-01-02 06:43:43'),
(25, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(26, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(27, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(28, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(29, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(30, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(31, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(32, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(33, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(34, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(35, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(36, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(37, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(38, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(39, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(40, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(41, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(42, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(43, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(44, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(45, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(46, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(47, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(48, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(49, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(50, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(51, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(52, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(53, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(54, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(55, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(56, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(57, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(58, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(59, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(60, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(61, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(62, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(63, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(64, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(65, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(66, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(67, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(68, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(69, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(70, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(71, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(72, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(73, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(74, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(75, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(76, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(77, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(78, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(79, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(80, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(81, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(82, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(83, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(84, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(85, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(86, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(87, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(88, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(89, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(90, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(91, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(92, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(93, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(94, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(95, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(96, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(97, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(98, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(99, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(100, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36'),
(101, '1.jpg', 'jpg', 'images/1.jpg', 46116, 0, '2022-02-03 09:08:36');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`imageid`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `images`
--
ALTER TABLE `images`
  MODIFY `imageid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
