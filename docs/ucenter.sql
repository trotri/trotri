CREATE DATABASE IF NOT EXISTS `trotri`;

USE `trotri`;

DROP TABLE IF EXISTS `tr_user_amcas`;
CREATE TABLE `tr_user_amcas` (
  `amca_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `amca_pid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `amca_name` varchar(100) NOT NULL DEFAULT '' COMMENT '事件名',
  `prompt` varchar(100) NOT NULL DEFAULT '' COMMENT '提示',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `category` enum('app','mod','ctrl','act') NOT NULL DEFAULT 'act' COMMENT '类型，app：应用、mod：模块、ctrl：控制器、act：行动',
  PRIMARY KEY (`amca_id`),
  UNIQUE KEY `pid_name` (`amca_pid`,`amca_name`),
  KEY `amca_name` (`amca_name`),
  KEY `sort` (`sort`),
  KEY `category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户可访问的事件表';

INSERT INTO `tr_user_amcas` VALUES ('1', '0', 'administrator', 'administrator', '0', 'app');

DROP TABLE IF EXISTS `tr_user_groups`;
CREATE TABLE `tr_user_groups` (
  `group_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `group_pid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `group_name` varchar(100) NOT NULL DEFAULT '' COMMENT '组名',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `permission` text COMMENT '权限设置，可访问的事件，由应用-模块-控制器-行动组合',
  `description` text COMMENT '描述',
  PRIMARY KEY (`group_id`),
  KEY `group_pid` (`group_pid`),
  KEY `group_name` (`group_name`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户分组表';

INSERT INTO `tr_user_groups` VALUES ('1', '0', 'Public', '0', '', '公开组，未登录用户拥有该权限');
INSERT INTO `tr_user_groups` VALUES ('2', '1', 'Guest', '1', null, '普通会员');
INSERT INTO `tr_user_groups` VALUES ('3', '1', 'Manager', '2', null, '普通管理员');
INSERT INTO `tr_user_groups` VALUES ('4', '1', 'Registered', '3', null, '记名作者');
INSERT INTO `tr_user_groups` VALUES ('5', '1', 'Super Users', '4', null, '超级会员');
INSERT INTO `tr_user_groups` VALUES ('6', '3', 'Administrator', '1', null, '超级管理员');
INSERT INTO `tr_user_groups` VALUES ('7', '4', 'Author', '1', null, '普通作者');
INSERT INTO `tr_user_groups` VALUES ('8', '7', 'Editor', '1', null, '高级作者');
INSERT INTO `tr_user_groups` VALUES ('9', '8', 'Publisher', '1', null, '出版者');

DROP TABLE IF EXISTS `tr_users`;
CREATE TABLE `tr_users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `login_name` varchar(100) NOT NULL DEFAULT '' COMMENT '登录名：邮箱|用户名|手机号',
  `login_type` enum('mail','name','phone') NOT NULL DEFAULT 'mail' COMMENT '通过登录名自动识别登录方式，mail：邮箱、name：用户名(不能是纯数字、不能包含@符)、phone：手机号(11位数字)',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '登录密码',
  `salt` char(6) NOT NULL DEFAULT '' COMMENT '随机附加混淆码',
  `user_name` varchar(100) NOT NULL DEFAULT '' COMMENT '用户名',
  `user_mail` varchar(100) NOT NULL DEFAULT '' COMMENT '邮箱，可用来找回密码',
  `user_phone` char(11) NOT NULL DEFAULT '' COMMENT '手机号，可用来找回密码',
  `dt_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '注册时间',
  `dt_last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '上次登录时间',
  `dt_last_repwd` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '上次更新密码时间',
  `ip_registered` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册IP',
  `ip_last_login` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次登录IP',
  `ip_last_repwd` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次更新密码IP',
  `login_count` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '总登录次数',
  `repwd_count` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '总更新密码次数',
  `valid_mail` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否已验证邮箱',
  `valid_phone` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否已验证手机号',
  `forbidden` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否禁用',
  `trash` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否删除',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `login_name` (`login_name`),
  KEY `login_type` (`login_type`),
  KEY `user_name` (`user_name`),
  KEY `user_mail` (`user_mail`),
  KEY `user_phone` (`user_phone`),
  KEY `valid_mail` (`valid_mail`),
  KEY `valid_phone` (`valid_phone`),
  KEY `forbidden` (`forbidden`),
  KEY `trash` (`trash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户主表';

DROP TABLE IF EXISTS `tr_user_profile`;
CREATE TABLE `tr_user_profile` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `profile_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `profile_key` varchar(255) NOT NULL DEFAULT '' COMMENT '扩展Key',
  `profile_value` longtext COMMENT '扩展Value',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_id_key` (`profile_id`,`profile_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户扩展表';

DROP TABLE IF EXISTS `tr_user_usergroups_map`;
CREATE TABLE `tr_user_usergroups_map` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `group_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '主键ID',
  PRIMARY KEY (`user_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户和用户组关联表';
