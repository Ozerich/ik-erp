-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Авг 07 2013 г., 21:57
-- Версия сервера: 5.5.31
-- Версия PHP: 5.4.4-14+deb7u2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `ikerp`
--

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` int(11) NOT NULL,
  `date` date NOT NULL,
  `shipping_date` date NOT NULL,
  `division` int(11) NOT NULL,
  `worker` varchar(255) NOT NULL,
  `customer` varchar(255) NOT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `comment` text,
  `need_install` tinyint(1) NOT NULL,
  `install_person` varchar(255) DEFAULT NULL,
  `install_phone` varchar(255) DEFAULT NULL,
  `install_address` varchar(255) DEFAULT NULL,
  `install_comment` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `status`, `date`, `shipping_date`, `division`, `worker`, `customer`, `customer_phone`, `comment`, `need_install`, `install_person`, `install_phone`, `install_address`, `install_comment`) VALUES
(1, 3, '2013-07-10', '2013-07-24', 1, 'Георгий Долидзе', 'Виталий Озерский', '+7 (111) 111-11-11', 'Вот на этом заказе мы заработаем денег и купим по каену и всё будет хорошо :)', 0, '', '', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `order_products`
--

CREATE TABLE IF NOT EXISTS `order_products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `pos` int(10) unsigned NOT NULL,
  `count` int(10) unsigned NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `state_1` tinyint(1) NOT NULL,
  `state_2` tinyint(1) NOT NULL,
  `state_3` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `order_products`
--

INSERT INTO `order_products` (`id`, `order_id`, `product_id`, `pos`, `count`, `comment`, `state_1`, `state_2`, `state_3`) VALUES
(1, 1, 2, 1, 7, 'Вася, где детали? не знаю', 0, 0, 0),
(2, 1, 3, 2, 5, '', 1, 1, 1),
(3, 1, 4, 3, 6, 'ну вот совсем немноженько осталось', 0, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `articul` varchar(15) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `articul`, `name`, `price`) VALUES
(1, '0001', 'Продукт 1', 10000),
(2, '0002', 'Продукт 2', 20000),
(3, '0003', 'Продукт 3', 30000),
(4, '0004', 'Продукт 4', 40000),
(5, '0005', 'Продукт 5', 50000);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `surname`, `last_login`) VALUES
(1, 'ozicoder@gmail.com', 'admin', '', '', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
