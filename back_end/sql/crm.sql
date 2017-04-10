-- phpMyAdmin SQL Dump
-- version 3.4.3.2
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2017 年 04 月 10 日 10:56
-- 服务器版本: 5.5.15
-- PHP 版本: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `crm`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `username` char(15) NOT NULL,
  `password` char(40) NOT NULL,
  `token` char(250) DEFAULT NULL,
  `exp` int(10) DEFAULT NULL,
  `power` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='用户信息' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `token`, `exp`, `power`) VALUES
(1, 'root', '63a9f0ea7bb98050796b649e85481845', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJyb290Iiwic3ViIjoiand0IiwiZXhwIjoxNDkxODE4NTM2fQ.OTE0NzI4MGU0NTdjZGU5OTI4ZWMyYzdjN2MxZWM2NjEwNDNiNDhjNGVmZGM0ZTUyNjExNjIwMjE1NjFjZTJhMA', 1491818536, 2),
(2, 'admin', '0444e11e0501438bda1af664f36974de', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhZG1pbiIsInN1YiI6Imp3dCIsImV4cCI6MTQ5MTgwNDAxMX0.NTEwYWJmMmE2YzhiZjI2MTBjZTc4YWVkNDk0MWIwOWI1OTNiMWQ1N2YzZDkwMGUzNjY2MTdjZTM5ZGQ3YjMwOQ', 1491804011, 1),
(3, 'kefu', '0444e11e0501438bda1af664f36974de', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJrZWZ1Iiwic3ViIjoiand0IiwiZXhwIjoxNDkxODA0MDI4fQ.NzQzZDNjMWRjZDNjMWU3NGQyNmVjMDJlOGI2NTY2MTdhZTBlNGRiMWUzMmFhODQ1NzJhNTBjYWVkZTczZWJkNw', 1491804028, 0);

-- --------------------------------------------------------

--
-- 表的结构 `disease`
--

CREATE TABLE IF NOT EXISTS `disease` (
  `id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `name` char(10) NOT NULL,
  `childs` text,
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
-- 表的结构 `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `ip` char(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `des` text COLLATE utf8mb4_unicode_ci,
  `admin` char(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='行为日志' AUTO_INCREMENT=1 ;

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
-- 表的结构 `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `title` char(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` char(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` char(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_menu` char(50) COLLATE utf8mb4_unicode_ci,
  `power` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='菜单' AUTO_INCREMENT=18 ;

--
-- 转存表中的数据 `menu`
--

INSERT INTO `menu` (`id`, `title`, `name`, `url`, `sub_menu`, `power`) VALUES
(1, '仪表盘', '1', 'dashboard\r', '', 0),
(2, '客户池', '2', 'patients', '[3]', 0),
(3, '登记用户', '2-1', 'regsiter', '', 0),
(4, '数据报表', '3', 'data', '[4,5]', 1),
(5, '绩效数据', '3-1', 'effect', '', 1),
(6, '业绩报表', '3-2', 'performance', '', 1),
(7, '信息管理', '4', 'info', '[7,8,9,10]', 1),
(8, '医生管理', '4-1', 'doctor', '', 1),
(9, '病种科室', '4-2', 'disease', '', 1),
(10, '来源渠道', '4-3', 'media', '', 1),
(11, '咨询方式', '4-4', 'way', '', 1),
(12, '系统设置', '5', 'system', '[12,13,14,15,16]', 1),
(13, '菜单管理', '5-1', 'menu', '', 2),
(14, '人员管理', '5-2', 'admin', '', 2),
(15, '行为日志', '5-3', 'log', '', 1),
(16, '通知管理', '5-4', 'notice', '', 1),
(17, '参数设置', '5-5', 'config', '', 2);

-- --------------------------------------------------------

--
-- 表的结构 `patients`
--

CREATE TABLE IF NOT EXISTS `patients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(10) NOT NULL,
  `sex` tinyint(1) DEFAULT '0',
  `age` tinyint(2) DEFAULT NULL,
  `tel` char(15) DEFAULT NULL,
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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
