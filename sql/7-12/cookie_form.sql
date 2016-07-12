-- phpMyAdmin SQL Dump
-- version 2.10.2
-- http://www.phpmyadmin.net
-- 
-- 主机: localhost
-- 生成日期: 2016 年 07 月 12 日 03:54
-- 服务器版本: 5.0.45
-- PHP 版本: 5.2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- 数据库: `fore-end`
-- 

-- --------------------------------------------------------

-- 
-- 表的结构 `cookie_form`
-- 

CREATE TABLE `cookie_form` (
  `id` int(11) NOT NULL auto_increment,
  `ttl` varchar(100) NOT NULL,
  `cookie_code` varchar(200) NOT NULL default '0',
  `onlyID` varchar(200) NOT NULL,
  `img` varchar(200) NOT NULL,
  `sort` int(11) default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- 导出表中的数据 `cookie_form`
-- 

