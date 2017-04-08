-- phpMyAdmin SQL Dump
-- version 3.4.3.2
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2017 年 04 月 08 日 02:33
-- 服务器版本: 5.5.15
-- PHP 版本: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `guahao_spa`
--

-- --------------------------------------------------------

--
-- 表的结构 `disease`
--

CREATE TABLE IF NOT EXISTS `disease` (
  `id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `name` char(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='病种' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `doctors`
--

CREATE TABLE IF NOT EXISTS `doctors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(6) NOT NULL,
  `introduction` text COMMENT '介绍',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='专家' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `media`
--

CREATE TABLE IF NOT EXISTS `media` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `name` char(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='病患来源' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `patients`
--

CREATE TABLE IF NOT EXISTS `patients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(10) NOT NULL,
  `sex` tinyint(1) DEFAULT '0',
  `age` tinyint(2) DEFAULT NULL,
  `tel` int(15) DEFAULT NULL,
  `wechat` char(20) DEFAULT NULL,
  `qq` int(10) DEFAULT NULL,
  `add_time` int(10) NOT NULL COMMENT '登记时间',
  `order_time` int(10) DEFAULT NULL COMMENT '预约时间',
  `reach_time` int(10) DEFAULT NULL COMMENT '到诊时间',
  `disease_id` tinyint(3) DEFAULT NULL COMMENT '病种id',
  `author_id` tinyint(3) NOT NULL COMMENT '经办人id',
  `state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '病患状态',
  `media_from_id` tinyint(1) DEFAULT '0' COMMENT '来源id',
  `doctor_id` tinyint(2) DEFAULT NULL COMMENT '预约专家id',
  `advisory_way` char(10) DEFAULT NULL COMMENT '咨询方式',
  `advisory_content` text COMMENT '咨询内容',
  `area` char(20) DEFAULT NULL COMMENT '地区',
  `remarks` text COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='病患' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `username` char(15) NOT NULL,
  `password` char(20) NOT NULL,
  `token` char(250) DEFAULT NULL,
  `exp` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='用户信息' AUTO_INCREMENT=19 ;

--
-- 转存表中的数据 `users`
--

INSERT INTO admin (`id`, `username`, `password`, `token`, `exp`) VALUES
(13, 'kefu', 'kefu', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJrZWZ1Iiwic3ViIjoibG9naW4iLCJleHAiOjE0OTEzODkyNzR9.YWU1ZjY4NTQxZmVlY2EzMzlmNGNjMGMzZjVkYjEyNmVjZTYxMjIyMTQ4NjNlN2M5OWNlZWJhM2YwMTU3ZDZmYQ', 1491389274),
(14, 'kefu', 'kefu', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJrZWZ1Iiwic3ViIjoibG9naW4iLCJleHAiOjE0OTEzODk3MTF9.YjIzNDdjMDFmYTlhODZiNjQ0N2M0M2UwOGU5ZWEyMWUwNjdkZDk0YzRkOWQ2YTNhNDQ2ZjAxMzQ0MzkzZGU0OA', 1491389711),
(15, 'kefu', 'kefu', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJrZWZ1Iiwic3ViIjoibG9naW4iLCJleHAiOjE0OTEzODk3NjZ9.ODk1YzdlNzNlNzc4MWE3NDk3YTFjYTdlZmRkZjE2ZWVkYTE0NWY2MWYzMDQwMDhlZDBmYjY4OTJmZjAxYTQ3Yw', 1491389766),
(16, 'kefu', 'kefu', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJrZWZ1Iiwic3ViIjoibG9naW4iLCJleHAiOjE0OTEzODk3OTR9.MGI1ZmNlYzE2NjY0MjdiN2UwMGMyZjZjMTc0ZmYxZjYzNzcxMTJmNjU5MDUwNzhmNmUzYTZlZDRlYmIyMTU4ZA', 1491389794),
(17, 'kefu', 'kefu', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJrZWZ1Iiwic3ViIjoibG9naW4iLCJleHAiOjE0OTE0NjQ5MDN9.ZjdkODEwMGI0NGU3NTEwMWI1OWZmNWQyNGM5YjM0OGNhMmE2OGY3MDUxZWVlNzZjNzI4NWRlZjVjYTM3ODU2Yg', 1491464903),
(18, 'kefu', 'kefu', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJrZWZ1Iiwic3ViIjoibG9naW4iLCJleHAiOjE0OTE0NjY5NTN9.MDVhZjc2NGQ4OTUzZDBjMThhZmY4MTI2NTYwY2ZkY2M3YzI1NWU3MWI5YzM4NWQ2M2UwMjZiYThlYTYyM2UwOQ', 1491466953);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
