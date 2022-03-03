-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 03 2022 г., 16:43
-- Версия сервера: 8.0.24
-- Версия PHP: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `abzdb`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cart`
--

CREATE TABLE `cart` (
  `cartid` int NOT NULL COMMENT 'ID',
  `userid` int NOT NULL COMMENT 'User ID',
  `orderstatusid` int NOT NULL DEFAULT '1' COMMENT 'Order status ID',
  `productid` int NOT NULL COMMENT 'Product ID',
  `quantity` decimal(12,3) DEFAULT NULL COMMENT 'Product quantity',
  `price` decimal(10,2) DEFAULT NULL COMMENT 'Product price',
  `sm` decimal(12,2) DEFAULT NULL COMMENT 'Product sum'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Shopping cart';

--
-- Дамп данных таблицы `cart`
--

INSERT INTO `cart` (`cartid`, `userid`, `orderstatusid`, `productid`, `quantity`, `price`, `sm`) VALUES
(5, 5, 2, 4, '2.520', '420.00', '1058.40'),
(11, 5, 2, 4, '2.000', '420.00', '840.00'),
(12, 5, 2, 5, '1.000', '500.00', '500.00'),
(13, 5, 2, 6, '1.000', '234.00', '234.00'),
(14, 5, 2, 5, '1.000', '500.00', '500.00');

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `categoryid` int NOT NULL COMMENT 'ID',
  `categoryname` varchar(150) NOT NULL COMMENT 'Category name',
  `tabindex` int NOT NULL DEFAULT '1' COMMENT 'Tab index',
  `ismark` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Deleted row mark'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Product categories';

-- --------------------------------------------------------

--
-- Структура таблицы `feedback`
--

CREATE TABLE `feedback` (
  `feedbackid` int NOT NULL COMMENT 'ID',
  `feedbacktime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Feedback time',
  `username` varchar(250) NOT NULL COMMENT 'User name',
  `useremail` varchar(250) NOT NULL COMMENT 'User email',
  `usertext` text COMMENT 'Feedback text'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Feedback';

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE `news` (
  `newsid` int NOT NULL,
  `newstitle` text,
  `newsdate` date DEFAULT NULL,
  `newsdetails` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='News list';

-- --------------------------------------------------------

--
-- Структура таблицы `orderdetails`
--

CREATE TABLE `orderdetails` (
  `orderdetailid` int NOT NULL COMMENT 'ID',
  `orderid` int NOT NULL COMMENT 'Order ID',
  `cartid` int DEFAULT NULL COMMENT 'Shopping cart ID',
  `productid` int NOT NULL COMMENT 'Product ID',
  `quantity` decimal(10,0) DEFAULT NULL COMMENT 'Product quantity',
  `price` decimal(10,0) DEFAULT NULL COMMENT 'Product price',
  `sm` decimal(10,0) DEFAULT NULL COMMENT 'Detail sum'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Order details';

--
-- Дамп данных таблицы `orderdetails`
--

INSERT INTO `orderdetails` (`orderdetailid`, `orderid`, `cartid`, `productid`, `quantity`, `price`, `sm`) VALUES
(3, 1, 5, 4, '3', '420', '1058'),
(4, 1, 6, 11, '2', '419', '867'),
(5, 1, 8, 9, '1', '4248', '4248'),
(7, 3, 5, 4, '3', '420', '1058'),
(8, 4, 11, 4, '2', '420', '840'),
(9, 4, 12, 5, '1', '500', '500'),
(11, 5, 13, 6, '1', '234', '234'),
(12, 6, 14, 5, '1', '500', '500');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `orderid` int NOT NULL COMMENT 'ID',
  `userid` int NOT NULL COMMENT 'User ID',
  `orderstatusid` int NOT NULL DEFAULT '2' COMMENT 'Order status ID',
  `customername` varchar(250) NOT NULL COMMENT 'Customer name',
  `customertel` varchar(250) DEFAULT NULL COMMENT 'Customer telephone numbers',
  `customeremail` varchar(250) DEFAULT NULL COMMENT 'Customer emails',
  `contactperson` varchar(250) DEFAULT NULL COMMENT 'Contact person name',
  `isdelivery` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Is delivery',
  `deliveryaddress` text COMMENT 'Delivery address',
  `isonlinepay` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Is on-line pay',
  `inn` varchar(30) DEFAULT NULL COMMENT 'INN',
  `bik` varchar(30) DEFAULT NULL COMMENT 'BIK',
  `rasch` varchar(250) DEFAULT NULL COMMENT 'Raschetniy schet',
  `bank` varchar(250) DEFAULT NULL COMMENT 'Bank name',
  `ordernote` text COMMENT 'Order note',
  `ordertime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Order creation time',
  `ordersum` decimal(12,2) DEFAULT NULL COMMENT 'Order sum',
  `deliverysum` decimal(12,2) DEFAULT NULL COMMENT 'Delivery sum',
  `lastchangestime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Last changes time'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Orders';

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`orderid`, `userid`, `orderstatusid`, `customername`, `customertel`, `customeremail`, `contactperson`, `isdelivery`, `deliveryaddress`, `isonlinepay`, `inn`, `bik`, `rasch`, `bank`, `ordernote`, `ordertime`, `ordersum`, `deliverysum`, `lastchangestime`) VALUES
(1, 5, 9, 'Иван Сергеевич Брыля', '+79037889344', 'v@v.ru', 'Ваня', 1, 'Москва, ул. Новая 8', 0, NULL, NULL, NULL, NULL, 'Просьба доставить до 14-00', '2022-03-03 00:54:08', '6173.21', '233.00', '2022-03-03 02:11:29'),
(3, 5, 6, 'Василий', '+79037889344', 'v@v.ru', 'Ваня', 1, '', 0, NULL, NULL, NULL, NULL, 'Самовывоз, оплата картой', '2022-03-03 01:24:37', '1058.40', '2890.00', '2022-03-03 02:11:46'),
(4, 5, 2, 'Don Joe', '+79037889344', 'v@v.ru', 'Ваня', 1, '', 0, NULL, NULL, NULL, NULL, 'gggggggggggggg', '2022-03-03 12:28:19', '1340.00', NULL, '2022-03-03 12:28:19'),
(5, 5, 2, 'hfghdfgh', '+79037889344', 'v@v.ru', 'Ваня', 1, '', 0, NULL, NULL, NULL, NULL, 'fghf', '2022-03-03 12:31:08', '234.00', NULL, '2022-03-03 12:31:08'),
(6, 5, 2, 'kjhkghjk', '+79037889344', 'v@v.ru', 'Ваня', 0, '', 0, NULL, NULL, NULL, NULL, '', '2022-03-03 12:34:00', '500.00', NULL, '2022-03-03 12:34:00');

-- --------------------------------------------------------

--
-- Структура таблицы `orderstatus`
--

CREATE TABLE `orderstatus` (
  `orderstatusid` int NOT NULL COMMENT 'ID',
  `status` varchar(150) NOT NULL COMMENT 'Order status',
  `ismark` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Delete row mark'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Order statuses';

--
-- Дамп данных таблицы `orderstatus`
--

INSERT INTO `orderstatus` (`orderstatusid`, `status`, `ismark`) VALUES
(1, 'В корзине покупок', 0),
(2, 'Отправлен в обработку', 0),
(3, 'В корзине покупок', 1),
(4, 'Отправлен в обработку', 1),
(5, 'Обрабатывается менеджерами', 0),
(6, 'Выполняется', 0),
(7, 'Доставляется', 0),
(8, 'Выполнен', 0),
(9, 'Отменен', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `productpics`
--

CREATE TABLE `productpics` (
  `productpicid` int NOT NULL COMMENT 'ID',
  `productid` int NOT NULL COMMENT 'Product ID',
  `picname` varchar(250) NOT NULL COMMENT 'Picture file name'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Product pictures';

--
-- Дамп данных таблицы `productpics`
--

INSERT INTO `productpics` (`productpicid`, `productid`, `picname`) VALUES
(10, 5, 'vesy.jpg'),
(11, 6, 'asphalt-ha-5.jpg'),
(12, 6, 'asphalt-ha-6.jpg'),
(13, 6, 'asphalt-ha-7.jpg'),
(14, 6, 'asphalt-ha-9.jpg'),
(15, 6, 'asphalt-ha-14.jpg'),
(16, 7, 'asphalt-ha-1.jpg'),
(17, 7, 'asphalt-ha-2.jpg'),
(18, 7, 'asphalt-ha-3.jpg'),
(19, 7, 'asphalt-ha-4.jpg'),
(20, 7, 'asphalt-ha-15.jpg'),
(21, 8, '1.jpg'),
(22, 8, '35210-ConcreteRoads.jpg'),
(23, 8, 'pd2-1.jpg'),
(24, 9, 'pg1.jpg'),
(25, 9, 'pg1-1.jpg'),
(26, 9, 'Чёрный песок.jpg'),
(27, 10, '26.jpg'),
(28, 10, 'l4-1.jpg'),
(29, 11, 'ha-1.jpg'),
(30, 11, 'Укладка холодного асфальта1.jpg'),
(31, 11, 'ha-2.jpg'),
(32, 11, 'ha-3.jpg'),
(33, 12, '28.jpg'),
(34, 12, 'mb1-1.jpg'),
(35, 12, 'mb1-sert.jpg'),
(36, 13, 'delivery-21-1.jpg'),
(37, 4, 'aspc-1.jpg'),
(38, 4, 'aspc-2.jpg'),
(39, 4, 'aspc-3.jpg'),
(40, 4, 'aspc-4.jpg'),
(41, 4, 'aspc-5.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `productid` int NOT NULL COMMENT 'ID',
  `categoryid` int NOT NULL COMMENT 'Category ID',
  `productname` varchar(250) NOT NULL COMMENT 'Product name',
  `tabindex` int NOT NULL DEFAULT '1' COMMENT 'Tab index',
  `descr` text COMMENT 'Description',
  `unit` varchar(60) DEFAULT NULL COMMENT 'Unit',
  `pricewonds` decimal(10,2) DEFAULT '0.00' COMMENT 'Price without NDS',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT 'Price with NDS',
  `creationtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation time',
  `htmlpagetitle` varchar(250) DEFAULT NULL COMMENT 'Page title in HTML head',
  `htmlmetadescr` varchar(250) DEFAULT NULL COMMENT 'Metatag descr',
  `htmlmetakeywords` varchar(250) DEFAULT NULL COMMENT 'Metatag keywords',
  `ismark` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Deleted row mark'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Products';

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`productid`, `categoryid`, `productname`, `tabindex`, `descr`, `unit`, `pricewonds`, `price`, `creationtime`, `htmlpagetitle`, `htmlmetadescr`, `htmlmetakeywords`, `ismark`) VALUES
(4, 1, '(0-8мм) Асфальтовый гранулят', 1, '<h3>Описание товара</h3>\r\n(0-8мм) Асфальтовый гранулят\r\n\r\n<b>(0-8мм) Асфальтовый гранулят</b> применяется при строительстве и ремонте дорог, пешеходных дорожек, аллей.<hr>\r\n<h3>Информация о доставке</h3>\r\n    Отгрузка самовывозом в грузовой транспорт покупателя. Доставка транспортом ООО \"АБЗ КАПОТНЯ\" оплачивается дополнительно. Время, сроки и стоимость доставки зависит от заказанного объема. Подробнее уточняйте у наших менеджеров.\r\n<hr>\r\nОзнакомтесь с дополнительной информацией о доставке на странице  Доставка продукции', 'тонна', '355.93', '420.00', '2022-02-28 16:18:22', '(0-8мм) Асфальтовый гранулят | Купить, цена, описание', '(0-8мм) Асфальтовый гранулят', '(0-8мм) Асфальтовый гранулят', 0),
(5, 1, 'Взвешивание груз. автомобиля', 2, '<strong>Взвешивание груз. автомобиля</strong>\r\n<hr>\r\n<h3>Информация о доставке</h3>\r\nОтгрузка самовывозом в грузовой транспорт покупателя. Доставка транспортом ООО \"ЛАГОС\" оплачивается дополнительно. Время, сроки и стоимость доставки зависит от заказанного объема. Подробнее уточняйте у наших менеджеров.\r\n \r\n<hr>\r\nОзнакомтесь с дополнительной информацией о доставке на странице  Доставка продукции', 'услуга', '423.73', '500.00', '2022-02-28 16:18:22', 'Взвешивание груз. автомобиля | Купить, цена, описание', 'Взвешивание груз. автомобиля', 'Взвешивание груз. автомобиля', 0),
(6, 1, 'Холодный асфальт (мешок 25 кг)', 3, '<h3>Описание товара</h3>\r\n<strong>Холодный асфальт (мешок 25 кг)</strong><br>\r\n\r\n\r\nХолодный асфальт ХА (мешок 25 кг) используется для локального (ямочного) ремонта дорожных покрытий, устройства дорожек, придомовых площадок.\r\n<hr>\r\n<h3>Информация о доставке</h3>\r\nОтгрузка самовывозом в грузовой транспорт покупателя. Доставка транспортом ООО \"ЛАГОС\" оплачивается дополнительно. Время, сроки и стоимость доставки зависит от заказанного объема. Подробнее уточняйте у наших менеджеров.\r\n <br>\r\n\r\nОзнакомтесь с дополнительной информацией о доставке на странице  <a href=\"/delivery/\" title=\"Доставка продукции клиентам\" role=\"button\">Доставка продукции</a>\r\n\r\n<h3>Документация</h3>\r\nИнструкция по применению Холодного асфальта\r\n\r\nИнструкция по применению Холодного асфальта\r\n\r\n<strong>\r\n                                <a href=\"https://abz-kapotnya.ru/documents/Инструкция по применению ХА.docx\" title=\"Cкачать файл\" rel=\"download\" role=\"button\" download=\"\">\r\n                                    <span class=\"glyphicon glyphicon-download-alt\"></span>&nbsp;&nbsp;Инструкция по применению ХА.docx\r\n                                </a>\r\n                            </strong>', 'шт.', '198.31', '234.00', '2022-02-28 16:18:22', 'Холодный асфальт (мешок 25 кг) | Купить, цена, описание', 'Холодный асфальт (мешок 25 кг)', 'Холодный асфальт (мешок 25 кг)', 0),
(7, 1, 'Холодный асфальт', 4, '<h3>Описание товара</h3>\r\nХолодный асфальт (мешок 25 кг)<br>\r\n\r\nХолодный асфальт ХА (мешок 25 кг) используется для локального (ямочного) ремонта дорожных покрытий, устройства дорожек, придомовых площадок.<br>\r\n<h3>Информация о доставке</h3>\r\nОтгрузка самовывозом в грузовой транспорт покупателя. Доставка транспортом ООО \"АБЗ КАПОТНЯ\" оплачивается дополнительно. Время, сроки и стоимость доставки зависит от заказанного объема. Подробнее уточняйте у наших менеджеров.<br>\r\n \r\n\r\nОзнакомтесь с дополнительной информацией о доставке на странице  Доставка продукции', 'тонна', '7932.20', '9360.00', '2022-02-28 16:18:22', 'Холодный асфальт | Купить, цена, описание', 'Холодный асфальт', 'Холодный асфальт', 0),
(8, 1, 'ПЕСЧАНАЯ А/Б СМЕСЬ ПД-II (АСФАЛЬТ ПД-2)', 5, 'ПЕСЧАНАЯ А/Б СМЕСЬ ПД-II (АСФАЛЬТ ПД-2)<br>\r\n\r\nИспользуется для устройства верхних слоев дорог III категорий, улиц, проездов, площадок, пешеходных зон.\r\nИнформация о доставке<br>\r\nОтгрузка самовывозом в грузовой транспорт покупателя. Доставка транспортом ООО \"АБЗ КАПОТНЯ\" оплачивается дополнительно. Время, сроки и стоимость доставки зависит от заказанного объема. Подробнее уточняйте у наших менеджеров.<br><br>\r\n \r\n\r\nОзнакомтесь с дополнительной информацией о доставке на странице  Доставка продукции', 'тонна', '2788.14', '3290.00', '2022-02-28 16:18:22', 'ПЕСЧАНАЯ А/Б СМЕСЬ ПД-II (АСФАЛЬТ ПД-2) | Купить, цена, описание', 'ПЕСЧАНАЯ А/Б СМЕСЬ ПД-II (АСФАЛЬТ ПД-2)', 'ПЕСЧАНАЯ А/Б СМЕСЬ ПД-II (АСФАЛЬТ ПД-2)', 0),
(9, 1, 'ПЕСЧАНАЯ ТИП Г МАРКИ I (АСФАЛЬТ ПГ-1)', 6, '<h3>Описание товара</h3>\r\n<strong>ПЕСЧАНАЯ ТИП Г МАРКИ I (АСФАЛЬТ ПГ-1)</strong><br>Используется при строительстве и ремонте дорог.', 'тонна', '3600.00', '4248.00', '2022-02-28 16:18:22', 'ПЕСЧАНАЯ ТИП Г МАРКИ I (АСФАЛЬТ ПГ-1) | Купить, цена, описание', 'ПЕСЧАНАЯ ТИП Г МАРКИ I (АСФАЛЬТ ПГ-1)', 'ПЕСЧАНАЯ ТИП Г МАРКИ I (АСФАЛЬТ ПГ-1)', 0),
(10, 1, 'ПЕСЧАНАЯ ТИП Л-IV (АСФАЛЬТ Л-4 ТУ-5718-002-0400063-2006)', 7, '<h3>Описание товара</h3><br>\r\n<strong>ПЕСЧАНАЯ ТИП Л-IV (АСФАЛЬТ Л-4 ТУ-5718-002-0400063-2006)</strong><br>\r\nШироко используется при строительстве и ремонте высокоскоростных магистралей и высокозагруженных дорог общего пользования.', 'тонна', '3345.76', '3948.00', '2022-02-28 16:18:22', 'ПЕСЧАНАЯ ТИП Л-IV (АСФАЛЬТ Л-4 ТУ-5718-002-0400063-2006) | Купить, цена, описание', 'ПЕСЧАНАЯ ТИП Л-IV (АСФАЛЬТ Л-4 ТУ-5718-002-0400063-2006)', 'ПЕСЧАНАЯ ТИП Л-IV (АСФАЛЬТ Л-4 ТУ-5718-002-0400063-2006)', 0),
(11, 1, 'Холодная песчаная а/б смесь типа Гх марки I (холодный асфальт ПГх-1)', 8, 'Холодная песчаная а/б смесь типа Гх марки I (холодный асфальт ПГх-1)', 'мешок 25кг.', '354.87', '418.75', '2022-02-28 16:18:22', 'Холодная песчаная а/б смесь типа Гх марки I (холодный асфальт ПГх-1) | Купить, цена, описание', 'Холодная песчаная а/б смесь типа Гх марки I (холодный асфальт ПГх-1)', 'Холодная песчаная а/б смесь типа Гх марки I (холодный асфальт ПГх-1)', 0),
(12, 1, 'Холодная песчаная а/б смесь типа Гх марки I (холодный асфальт ПГх-1)', 9, 'Холодная песчаная а/б смесь типа Гх марки I (холодный асфальт ПГх-1)', 'тонна', '3313.56', '3910.00', '2022-02-28 16:18:22', 'Холодная песчаная а/б смесь типа Гх марки I (холодный асфальт ПГх-1) | Купить, цена, описание', 'Холодная песчаная а/б смесь типа Гх марки I (холодный асфальт ПГх-1)', 'Холодная песчаная а/б смесь типа Гх марки I (холодный асфальт ПГх-1)', 0),
(13, 1, 'Доставка 1 т. на расстояние до 20 км. Доставка транспортом организации', 10, 'Доставка 1 т. на расстояние до 20 км. Доставка транспортом организации', 'ездка 20км.', '0.00', '0.00', '2022-02-28 16:18:22', 'Доставка 1 т. на расстояние до 20 км. Доставка транспортом организации | Купить, цена, описание', 'Доставка 1 т. на расстояние до 20 км. Доставка транспортом организации', 'Доставка 1 т. на расстояние до 20 км. Доставка транспортом организации', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
  `reviewid` int NOT NULL COMMENT 'ID',
  `userid` int NOT NULL COMMENT 'User ID',
  `reviewtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Review time',
  `reviewtext` text COMMENT 'Review body'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='User reviews';

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `roleid` int NOT NULL COMMENT 'ID',
  `rolename` varchar(150) NOT NULL COMMENT 'Role name'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='User roles';

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`roleid`, `rolename`) VALUES
(1, 'Администратор'),
(2, 'Пользователь');

--
-- Триггеры `roles`
--
DELIMITER $$
CREATE TRIGGER `tDelRole` BEFORE DELETE ON `roles` FOR EACH ROW BEGIN
	IF OLD.roleid = 1 THEN 
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "Adminrole can't delete"; 
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `tmpcart`
--

CREATE TABLE `tmpcart` (
  `tmpcartid` int NOT NULL COMMENT 'ID',
  `tmpuserid` int NOT NULL COMMENT 'Temporary user ID',
  `productid` int NOT NULL COMMENT 'Product ID',
  `quantity` decimal(12,3) DEFAULT NULL COMMENT 'Product quantity'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Temporary cart for non-registered users';

-- --------------------------------------------------------

--
-- Структура таблицы `tmpusers`
--

CREATE TABLE `tmpusers` (
  `tmpuserid` int NOT NULL COMMENT 'ID',
  `creationtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Creation time'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Temporary non-registered users';

-- --------------------------------------------------------

--
-- Структура таблицы `userdetails`
--

CREATE TABLE `userdetails` (
  `userdetailid` int NOT NULL COMMENT 'ID',
  `userid` int NOT NULL COMMENT 'User ID',
  `fullname` varchar(250) DEFAULT NULL COMMENT 'Full name',
  `deliveryaddress` text COMMENT 'Delivery address',
  `tel` varchar(250) DEFAULT NULL COMMENT 'Telephone numbers',
  `contactperson` varchar(250) DEFAULT NULL COMMENT 'Contact person name',
  `email` varchar(250) DEFAULT NULL COMMENT 'E-mails',
  `inn` varchar(30) DEFAULT NULL COMMENT 'INN',
  `bik` varchar(30) DEFAULT NULL COMMENT 'BIK',
  `rasch` varchar(250) DEFAULT NULL COMMENT 'Raschetniy schet',
  `bank` varchar(250) DEFAULT NULL COMMENT 'Bank name'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='User details';

-- --------------------------------------------------------

--
-- Структура таблицы `userroles`
--

CREATE TABLE `userroles` (
  `userid` int NOT NULL COMMENT 'User ID',
  `roleid` int NOT NULL DEFAULT '2' COMMENT 'Role ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Users in roles';

--
-- Дамп данных таблицы `userroles`
--

INSERT INTO `userroles` (`userid`, `roleid`) VALUES
(1, 1),
(5, 2),
(6, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `userid` int NOT NULL COMMENT 'ID',
  `username` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'User name',
  `email` varchar(150) NOT NULL COMMENT 'E-mail',
  `login` varchar(90) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Login',
  `passwd` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Password hash',
  `lastlogintime` datetime DEFAULT NULL COMMENT 'Last login time'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Users';

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`userid`, `username`, `email`, `login`, `passwd`, `lastlogintime`) VALUES
(1, 'Администратор сайта', 'ooolagoc@yandex.ru', 'admin', '$argon2id$v=19$m=65536,t=4,p=1$MnM0LllHeFU3SnVYeWhaSg$tBIx4Dv30s7VItM4AMo1stVmgPwOoY1FJaaYgIgRVnE', '2022-03-03 05:01:01'),
(5, 'Дмитрий Смирнов', 'dimas@mail.ru', 'dimas', '$argon2id$v=19$m=65536,t=4,p=1$bFJTTVZ1bVUwYWp2QllkSw$n6HDY3BHePW3th6HR4K3Hhv7+I8KjNnM8xWQ/e0kF9k', '2022-03-03 15:27:42'),
(6, 'Алексей Берг', 'alex@mail.ru', 'Alex', '$argon2id$v=19$m=65536,t=4,p=1$eWpyeHhqM2V6ZlF3RDVrRw$pOvK6jL4sx9vk2vVd3UFU/frDhGWw9YeCA+0uIMRIlk', '2022-03-02 14:49:49');

--
-- Триггеры `users`
--
DELIMITER $$
CREATE TRIGGER `tDelUser` BEFORE DELETE ON `users` FOR EACH ROW BEGIN
	IF OLD.userid = 1 THEN 
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "Adminuser can't delete"; 
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tInsUser` AFTER INSERT ON `users` FOR EACH ROW BEGIN    
       INSERT INTO userroles (`userid`) VALUES (NEW.`userid`);
     END
$$
DELIMITER ;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cartid`),
  ADD KEY `FK_cart_user` (`userid`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categoryid`);

--
-- Индексы таблицы `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedbackid`);

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`newsid`);

--
-- Индексы таблицы `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`orderdetailid`),
  ADD KEY `FK_detail_order` (`orderid`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderid`),
  ADD KEY `FK_order_user` (`userid`);

--
-- Индексы таблицы `orderstatus`
--
ALTER TABLE `orderstatus`
  ADD PRIMARY KEY (`orderstatusid`);

--
-- Индексы таблицы `productpics`
--
ALTER TABLE `productpics`
  ADD PRIMARY KEY (`productpicid`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productid`);

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`reviewid`),
  ADD KEY `FK_review_user` (`userid`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`roleid`),
  ADD UNIQUE KEY `RoleNameIndx` (`rolename`);

--
-- Индексы таблицы `tmpcart`
--
ALTER TABLE `tmpcart`
  ADD PRIMARY KEY (`tmpcartid`),
  ADD KEY `FK_tmpcart_tmpuser` (`tmpuserid`);

--
-- Индексы таблицы `tmpusers`
--
ALTER TABLE `tmpusers`
  ADD PRIMARY KEY (`tmpuserid`);

--
-- Индексы таблицы `userdetails`
--
ALTER TABLE `userdetails`
  ADD PRIMARY KEY (`userdetailid`),
  ADD UNIQUE KEY `UserIDIndx` (`userid`);

--
-- Индексы таблицы `userroles`
--
ALTER TABLE `userroles`
  ADD UNIQUE KEY `UserRolesIndx` (`userid`,`roleid`),
  ADD KEY `FK_userrole_role` (`roleid`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`),
  ADD UNIQUE KEY `LoginIndx` (`login`,`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cart`
--
ALTER TABLE `cart`
  MODIFY `cartid` int NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `categoryid` int NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT для таблицы `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedbackid` int NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `newsid` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `orderdetailid` int NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `orderid` int NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `orderstatus`
--
ALTER TABLE `orderstatus`
  MODIFY `orderstatusid` int NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `productpics`
--
ALTER TABLE `productpics`
  MODIFY `productpicid` int NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `productid` int NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `reviewid` int NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `roleid` int NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `tmpcart`
--
ALTER TABLE `tmpcart`
  MODIFY `tmpcartid` int NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT для таблицы `tmpusers`
--
ALTER TABLE `tmpusers`
  MODIFY `tmpuserid` int NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT для таблицы `userdetails`
--
ALTER TABLE `userdetails`
  MODIFY `userdetailid` int NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `userid` int NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=7;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `FK_cart_user` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `FK_detail_order` FOREIGN KEY (`orderid`) REFERENCES `orders` (`orderid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `FK_order_user` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `FK_review_user` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tmpcart`
--
ALTER TABLE `tmpcart`
  ADD CONSTRAINT `FK_tmpcart_tmpuser` FOREIGN KEY (`tmpuserid`) REFERENCES `tmpusers` (`tmpuserid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `userdetails`
--
ALTER TABLE `userdetails`
  ADD CONSTRAINT `FK_detail_user` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `userroles`
--
ALTER TABLE `userroles`
  ADD CONSTRAINT `FK_userrole_role` FOREIGN KEY (`roleid`) REFERENCES `roles` (`roleid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_userrole_user` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
