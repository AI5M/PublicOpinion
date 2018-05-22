-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- 主機: 127.0.0.1
-- 產生時間： 2018-05-15 17:55:05
-- 伺服器版本: 10.1.32-MariaDB
-- PHP 版本： 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `public_opinion`
--

-- --------------------------------------------------------

--
-- 資料表結構 `article_category`
--

CREATE TABLE `article_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `article_category`
--

INSERT INTO `article_category` (`category_id`, `category_name`) VALUES
(1, '娛樂'),
(2, '社會'),
(3, '國際'),
(4, '政治'),
(5, '生活'),
(6, '3C'),
(7, '動物'),
(8, '副刊'),
(9, '體育'),
(10, '財經'),
(11, '地產'),
(12, '論壇'),
(13, '壹週刊'),
(14, '時尚'),
(15, '兩岸'),
(16, '軍事'),
(17, '旅遊'),
(18, '健康'),
(19, '言論'),
(20, '話題'),
(21, '樂時尚'),
(22, '旺車');

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `article_category`
--
ALTER TABLE `article_category`
  ADD PRIMARY KEY (`category_id`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `article_category`
--
ALTER TABLE `article_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
