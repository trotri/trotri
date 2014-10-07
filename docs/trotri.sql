CREATE DATABASE IF NOT EXISTS `trotri2`;

USE `trotri2`;

DROP TABLE IF EXISTS `tr_system_options`;
CREATE TABLE `tr_system_options` (
  `option_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `option_key` varchar(64) NOT NULL DEFAULT '' COMMENT '配置Key',
  `option_value` longtext COMMENT '配置Value',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_key` (`option_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='站点配置表';

DROP TABLE IF EXISTS `tr_system_log_ymd`;
CREATE TABLE `tr_system_log_ymd` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `priority` enum('DB_EMERG','DB_ALERT','DB_CRIT','DB_ERR','DB_WARNING','DB_NOTICE','DB_INFO','DB_DEBUG') NOT NULL DEFAULT 'DB_NOTICE' COMMENT '日志类型',
  `event` text COMMENT '日志内容',
  `dt_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='日志表，按天存Notice、Info等日志';

DROP TABLE IF EXISTS `tr_system_logwf_ym`;
CREATE TABLE `tr_system_logwf_ym` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `priority` enum('DB_EMERG','DB_ALERT','DB_CRIT','DB_ERR','DB_WARNING','DB_NOTICE','DB_INFO','DB_DEBUG') NOT NULL DEFAULT 'DB_WARNING' COMMENT '日志类型',
  `event` text COMMENT '日志内容',
  `dt_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='日志表，按月存Warning、Err等日志';

DROP TABLE IF EXISTS `tr_user_amcas`;
CREATE TABLE `tr_user_amcas` (
  `amca_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `amca_name` varchar(100) NOT NULL DEFAULT '' COMMENT '事件名',
  `amca_pid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `prompt` varchar(100) NOT NULL DEFAULT '' COMMENT '提示',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `category` enum('app','mod','ctrl','act') NOT NULL DEFAULT 'act' COMMENT '类型，app：应用、mod：模块、ctrl：控制器、act：行动',
  PRIMARY KEY (`amca_id`),
  KEY `amca_name` (`amca_name`),
  UNIQUE KEY `pid_name` (`amca_pid`,`amca_name`),
  KEY `sort` (`sort`),
  KEY `category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户可访问的事件表';

INSERT INTO `tr_user_amcas` VALUES ('1', 'administrator', '0', '后端管理', '0', 'app');

DROP TABLE IF EXISTS `tr_user_groups`;
CREATE TABLE `tr_user_groups` (
  `group_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `group_name` varchar(100) NOT NULL DEFAULT '' COMMENT '组名',
  `group_pid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `permission` text COMMENT '权限设置，可访问的事件，由应用-模块-控制器-行动组合',
  `description` text COMMENT '描述',
  PRIMARY KEY (`group_id`),
  KEY `group_pid` (`group_pid`),
  UNIQUE KEY `group_name` (`group_name`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户分组表';

INSERT INTO `tr_user_groups` VALUES ('1', 'Public', '0', '0', '', '公开组，未登录用户拥有该权限');
INSERT INTO `tr_user_groups` VALUES ('2', 'Guest', '1', '1', null, '普通会员');
INSERT INTO `tr_user_groups` VALUES ('3', 'Manager', '1', '2', null, '普通管理员');
INSERT INTO `tr_user_groups` VALUES ('4', 'Registered', '1', '3', null, '记名作者');
INSERT INTO `tr_user_groups` VALUES ('5', 'Super Users', '1', '4', null, '超级会员');
INSERT INTO `tr_user_groups` VALUES ('6', 'Administrator', '3', '1', null, '超级管理员');
INSERT INTO `tr_user_groups` VALUES ('7', 'Author', '4', '1', null, '普通作者');
INSERT INTO `tr_user_groups` VALUES ('8', 'Editor', '7', '1', null, '高级作者');
INSERT INTO `tr_user_groups` VALUES ('9', 'Publisher', '8', '1', null, '出版者');

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

INSERT INTO `tr_users` (`login_name`, `login_type`, `password`, `salt`, `user_name`) VALUES ('administrator', 'name', '6d3f4f0d7f7ef593061de299599dcf17', 'UUeGTJ', 'administrator');

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
  `group_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '用户组ID',
  PRIMARY KEY (`user_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户和用户组关联表';

DROP TABLE IF EXISTS `tr_post_modules`;
CREATE TABLE `tr_post_modules` (
  `module_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `module_name` varchar(50) NOT NULL DEFAULT '' COMMENT '模型名称',
  `module_tblname` varchar(50) NOT NULL DEFAULT '' COMMENT '类别表名',
  `fields` text COMMENT '文档扩展字段',
  `forbidden` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否禁用',
  `description` text COMMENT '描述',
  PRIMARY KEY (`module_id`),
  UNIQUE KEY `module_tblname` (`module_tblname`),
  KEY `module_name` (`module_name`),
  KEY `forbidden` (`forbidden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文档模型表';

INSERT INTO `tr_post_modules` VALUES (1, '系统文档', 'posts', NULL, 'n', NULL);

DROP TABLE IF EXISTS `tr_post_categories`;
CREATE TABLE `tr_post_categories` (
  `category_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `category_pid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父类别ID',
  `category_name` varchar(50) NOT NULL DEFAULT '' COMMENT '类别名',
  `alias` varchar(250) NOT NULL DEFAULT '' COMMENT '别名',
  `meta_title` varchar(100) NOT NULL DEFAULT '' COMMENT 'SEO标题',
  `meta_keywords` varchar(100) NOT NULL DEFAULT '' COMMENT 'SEO关键字',
  `meta_description` varchar(250) NOT NULL DEFAULT '' COMMENT 'SEO描述',
  `tpl_home` varchar(100) NOT NULL DEFAULT '' COMMENT '封页模板名',
  `tpl_list` varchar(100) NOT NULL DEFAULT '' COMMENT '列表模板名',
  `tpl_view` varchar(100) NOT NULL DEFAULT '' COMMENT '文档模板名',
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '15' COMMENT '排序',
  `description` text COMMENT '描述',
  PRIMARY KEY (`category_id`),
  KEY `category_pid` (`category_pid`, `sort`),
  UNIQUE KEY `category_name` (`category_name`),
  KEY `alias` (`alias`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文档类别表';

DROP TABLE IF EXISTS `tr_posts`;
CREATE TABLE `tr_posts` (
  `post_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '文档标题',
  `alias` varchar(250) NOT NULL DEFAULT '' COMMENT '别名',
  `content` longtext COMMENT '文档内容',
  `keywords` varchar(100) NOT NULL DEFAULT '' COMMENT '内容关键字',
  `description` varchar(500) NOT NULL DEFAULT '' COMMENT '内容摘要',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `category_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '所属类别ID',
  `category_name` varchar(50) NOT NULL DEFAULT '' COMMENT '类别名',
  `category_alias` varchar(250) NOT NULL DEFAULT '' COMMENT '类别别名',
  `module_id` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT '模型ID',
  `password` char(20) NOT NULL DEFAULT '' COMMENT '访问密码',
  `picture` varchar(250) NOT NULL DEFAULT '' COMMENT '主图地址',
  `is_head` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否头条',
  `is_recommend` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否推荐',
  `is_jump` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否跳转',
  `jump_url` varchar(250) NOT NULL DEFAULT '' COMMENT '跳转链接',
  `is_public` enum('y','n') NOT NULL DEFAULT 'y' COMMENT '是否发表，y：开放浏览、n：草稿或待审核',
  `dt_public_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '开始发表时间',
  `dt_public_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '结束发表时间',
  `allow_comment` enum('y','n') NOT NULL DEFAULT 'y' COMMENT '是否允许评论',
  `allow_other_modify` enum('y','n') NOT NULL DEFAULT 'y' COMMENT '是否允许其他人编辑',
  `access_count` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '访问次数',
  `creator_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建人ID',
  `creator_name` varchar(100) NOT NULL DEFAULT '' COMMENT '创建人登录名',
  `last_modifier_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次编辑人ID',
  `last_modifier_name` varchar(100) NOT NULL DEFAULT '' COMMENT '上次编辑人登录名',
  `dt_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `dt_last_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '上次编辑时间',
  `ip_created` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建IP',
  `ip_last_modified` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次编辑IP',
  `trash` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否删除',
  PRIMARY KEY (`post_id`),
  KEY `pub_category_dtp` (`trash`,`is_public`,`category_id`,`dt_public_up`,`dt_public_down`,`sort`),
  KEY `pub_creator_dtp` (`trash`,`is_public`,`creator_id`,`dt_public_up`,`dt_public_down`,`sort`),
  KEY `pub_head_dtp` (`trash`,`is_public`,`is_head`,`dt_public_up`,`dt_public_down`,`sort`),
  KEY `pub_recommend_dtp` (`trash`,`is_public`,`is_recommend`,`dt_public_up`,`dt_public_down`,`sort`),
  KEY `title` (`title`),
  KEY `alias` (`alias`),
  KEY `sort` (`sort`),
  KEY `category_id` (`category_id`),
  KEY `module_id` (`module_id`),
  KEY `is_head` (`is_head`),
  KEY `is_recommend` (`is_recommend`),
  KEY `is_public` (`is_public`),
  KEY `dt_public_up` (`dt_public_up`),
  KEY `dt_public_down` (`dt_public_down`),
  KEY `access_count` (`access_count`),
  KEY `creator_id` (`creator_id`),
  KEY `last_modifier_id` (`last_modifier_id`),
  KEY `dt_created` (`dt_created`),
  KEY `dt_last_modified` (`dt_last_modified`),
  KEY `ip_created` (`ip_created`),
  KEY `ip_last_modified` (`ip_last_modified`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文档管理表';

DROP TABLE IF EXISTS `tr_post_profile`;
CREATE TABLE `tr_post_profile` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `profile_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文档ID',
  `profile_key` varchar(255) NOT NULL DEFAULT '' COMMENT '扩展Key',
  `profile_value` longtext COMMENT '扩展Value',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_id_key` (`profile_id`,`profile_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文档扩展表';

DROP TABLE IF EXISTS `tr_post_comments`;
CREATE TABLE `tr_post_comments` (
  `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `comment_pid` int(20) unsigned NOT NULL DEFAULT '0' COMMENT '父评论ID',
  `post_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文档ID',
  `post_title` varchar(100) NOT NULL DEFAULT '' COMMENT '文档标题',
  `post_alias` varchar(250) NOT NULL DEFAULT '' COMMENT '别名',
  `content` text COMMENT '评论内容',
  `author_name` varchar(100) NOT NULL DEFAULT '' COMMENT '评论作者名',
  `author_mail` varchar(100) NOT NULL DEFAULT '' COMMENT '评论作者邮箱',
  `author_url` varchar(250) NOT NULL DEFAULT '' COMMENT '评论作者网址',
  `is_public` enum('y','n') NOT NULL DEFAULT 'y' COMMENT '是否发表，y：开放浏览、n：草稿或待审核',
  `creator_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建人ID',
  `creator_name` varchar(100) NOT NULL DEFAULT '' COMMENT '创建人登录名',
  `last_modifier_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次编辑人ID',
  `last_modifier_name` varchar(100) NOT NULL DEFAULT '' COMMENT '上次编辑人登录名',
  `dt_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `dt_last_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '上次编辑时间',
  `ip_created` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建IP',
  `ip_last_modified` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次编辑IP',
  `trash` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否删除',
  PRIMARY KEY (`comment_id`),
  KEY `post_id` (`post_id`),
  KEY `creator_id` (`creator_id`),
  KEY `ip_created` (`ip_created`),
  KEY `pub_post_dtlm` (`trash`,`is_public`,`post_id`,`dt_last_modified`),
  KEY `pub_creator_dtlm` (`trash`,`is_public`,`creator_id`,`dt_last_modified`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文档评论表';
