-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2017-08-29 11:27:50
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ks`
--

-- --------------------------------------------------------

--
-- 表的结构 `ks_account`
--

CREATE TABLE IF NOT EXISTS `ks_account` (
  `user_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `email` varchar(255) NOT NULL DEFAULT '' COMMENT '邮箱',
  `user_name` varchar(255) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(255) NOT NULL DEFAULT '' COMMENT '密码',
  `question` varchar(255) NOT NULL DEFAULT '' COMMENT '账号问题',
  `answer` varchar(255) NOT NULL DEFAULT '' COMMENT '账号答案',
  `sex` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '年龄',
  `birthday` date NOT NULL DEFAULT '0000-00-00' COMMENT '生日',
  `user_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '账号金额',
  `frozen_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '账号冻结金额',
  `pay_points` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '消费积分',
  `rank_points` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '等级积分',
  `reg_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `last_login` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `last_ip` varchar(15) NOT NULL DEFAULT '' COMMENT '最后登录ip地址',
  `user_rank` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '用户等级',
  `parent_id` mediumint(9) NOT NULL DEFAULT '0' COMMENT '上级经销商id',
  `nick_name` varchar(60) NOT NULL COMMENT '昵称',
  `mobile_phone` varchar(20) NOT NULL COMMENT '手机号',
  `qq` text NOT NULL COMMENT 'qq',
  `is_validated` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否验证',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`),
  KEY `email` (`email`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ks_account_payment`
--

CREATE TABLE IF NOT EXISTS `ks_account_payment` (
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `payment_password` int(11) NOT NULL COMMENT '支付密码',
  `error_frequency` int(11) NOT NULL COMMENT '连续输错次数',
  `last_time` datetime NOT NULL COMMENT '最后输入时间',
  `payment_state` varchar(1) NOT NULL COMMENT 'y:正常；n：锁定'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户支付管理';

-- --------------------------------------------------------

--
-- 表的结构 `ks_betting`
--

CREATE TABLE IF NOT EXISTS `ks_betting` (
  `betting_id` int(11) NOT NULL COMMENT '自增id,投注id',
  `lottery` int(11) NOT NULL COMMENT '彩票ID',
  `betting_series` int(11) NOT NULL COMMENT '期号ID',
  `betting_type` varchar(50) NOT NULL COMMENT '投注类型',
  `betting_number` varchar(50) NOT NULL COMMENT '投注号码',
  `betting_money` decimal(10,2) NOT NULL COMMENT '投注金额',
  `winning_money` decimal(10,2) NOT NULL COMMENT '中奖金额',
  `receive_status` varchar(1) NOT NULL DEFAULT 'y' COMMENT 'y:领取；n:未领取',
  `betting_state` varchar(1) NOT NULL COMMENT '状态（y:中奖，n:未中奖,s:等待开奖）',
  `betting_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '投注时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='投注列表';

-- --------------------------------------------------------

--
-- 表的结构 `ks_card_binding`
--

CREATE TABLE IF NOT EXISTS `ks_card_binding` (
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `account_number` varchar(50) NOT NULL COMMENT '账号',
  `opening_bank` varchar(100) NOT NULL COMMENT '开户行',
  `account_name` varchar(100) NOT NULL COMMENT '开户名',
  `card_type` varchar(10) NOT NULL COMMENT '类型,bank：银行卡；alipay：支付宝',
  `card_state` varchar(1) NOT NULL COMMENT 'y:正常,n：锁定；',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '绑定时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='绑定银行卡或者支付宝';

-- --------------------------------------------------------

--
-- 表的结构 `ks_cash_record`
--

CREATE TABLE IF NOT EXISTS `ks_cash_record` (
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `cash_record_type` varchar(2) NOT NULL DEFAULT '+' COMMENT '增加或减少；+,-',
  `cash_record_cost` int(11) NOT NULL COMMENT '费用或者加减数量',
  `cost_type` varchar(10) NOT NULL COMMENT '费用类型,现金积分（cash）或者用户成长积分（grow）',
  `cash_record_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户积分、现金记录';

-- --------------------------------------------------------

--
-- 表的结构 `ks_lottery`
--

CREATE TABLE IF NOT EXISTS `ks_lottery` (
  `id` int(11) NOT NULL COMMENT '彩票自增id',
  `name` varchar(100) NOT NULL COMMENT '彩票名称',
  `summary` text NOT NULL COMMENT '概述',
  `region` varchar(50) NOT NULL COMMENT '所在地',
  `additional` varchar(1) NOT NULL COMMENT '是否可追号，y:正常，n：不启用',
  `odd_even` varchar(1) NOT NULL COMMENT '单双，y:正常，n：不启用',
  `size` varchar(1) NOT NULL COMMENT '大小，y:正常，n：不启用',
  `age21` varchar(1) NOT NULL COMMENT '同号，y:正常，n：不启用',
  `max_bet` int(11) NOT NULL COMMENT '最大投注（数量，单笔最多不超过好多注）',
  `api` varchar(100) NOT NULL COMMENT 'api接口',
  `start_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '开始时间',
  `end_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '结束时间',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='彩票表';

-- --------------------------------------------------------

--
-- 表的结构 `ks_lottery_period`
--

CREATE TABLE IF NOT EXISTS `ks_lottery_period` (
  `p_id` int(11) NOT NULL COMMENT '期数',
  `lottery` int(11) NOT NULL COMMENT '彩票id',
  `p_number` varchar(100) NOT NULL COMMENT '开奖号码',
  `p_odd_even` varchar(1) NOT NULL DEFAULT 'n' COMMENT '单双;y是；n:不是',
  `p_size` varchar(1) NOT NULL DEFAULT 'n' COMMENT '大小;y是；n:不是',
  `p_age21` varchar(1) NOT NULL DEFAULT 'n' COMMENT '同号;y是；n:不是',
  `p_state` varchar(1) NOT NULL COMMENT '是否开奖y：开奖；n:未开奖',
  `p_start_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '开始时间',
  `p_end_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '结束时间',
  `p_lottery_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '开奖时间',
  `p_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='彩票期数';

-- --------------------------------------------------------

--
-- 表的结构 `ks_operation_record`
--

CREATE TABLE IF NOT EXISTS `ks_operation_record` (
  `users_id` int(11) NOT NULL COMMENT '管理员ID',
  `record` text NOT NULL COMMENT '详情',
  `front` int(11) NOT NULL COMMENT '操作前',
  `behind` int(11) NOT NULL COMMENT '操作后',
  `ip` int(11) NOT NULL COMMENT '访问IP',
  `time` int(11) NOT NULL COMMENT '操作时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='管理员操作记录表';

-- --------------------------------------------------------

--
-- 表的结构 `ks_recharge`
--

CREATE TABLE IF NOT EXISTS `ks_recharge` (
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `recharge_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '充值金额',
  `back_now` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '充值返现',
  `recharge_type` varchar(10) CHARACTER SET utf8 NOT NULL COMMENT 'bank：银行卡，wx:微信支付，alipay：支付宝;qq:qq钱包',
  `recharge_time` datetime NOT NULL COMMENT '充值时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='充值记录';

-- --------------------------------------------------------

--
-- 表的结构 `ks_withdrawals`
--

CREATE TABLE IF NOT EXISTS `ks_withdrawals` (
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `cash` decimal(10,2) NOT NULL COMMENT '提现金额',
  `account_number` varchar(50) CHARACTER SET utf8mb4 NOT NULL COMMENT '账号',
  `opening_bank` varchar(100) CHARACTER SET utf8mb4 NOT NULL COMMENT '开户行',
  `account_name` varchar(100) CHARACTER SET utf8mb4 NOT NULL COMMENT '开户名',
  `card_type` varchar(10) CHARACTER SET utf8mb4 NOT NULL COMMENT '类型,bank：银行卡；alipay：支付宝',
  `withdrawals_state` varchar(1) CHARACTER SET utf8mb4 NOT NULL COMMENT 'y:成功；n：失败；s:已申请',
  `remarks` text CHARACTER SET utf8mb4 NOT NULL COMMENT '提现失败的原因',
  `withdrawal_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '提现申请时间',
  `processing_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '处理时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='提现';

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
