CREATE DATABASE IF NOT EXISTS `trotri`;

USE `trotri`;

DROP TABLE IF EXISTS `tr_post_modules`;
CREATE TABLE `tr_post_modules` (
  `module_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `module_name` varchar(50) NOT NULL DEFAULT '' COMMENT '模型名称',
  `module_tblname` varchar(50) NOT NULL DEFAULT '' COMMENT '类别表名',
  `forbidden` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否禁用',
  `description` text COMMENT '描述',
  PRIMARY KEY (`module_id`),
  UNIQUE KEY `module_tblname` (`module_tblname`),
  KEY `module_name` (`module_name`),
  KEY `forbidden` (`forbidden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文档类别模型表';

INSERT INTO `tr_post_modules` VALUES (1, '系统文档', 'posts', 'n', NULL);

DROP TABLE IF EXISTS `tr_post_categories`;
CREATE TABLE `tr_post_categories` (
  `category_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `category_pid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父类别ID',
  `category_name` varchar(50) NOT NULL DEFAULT '' COMMENT '类别名',
  `module_id` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT '模型ID',
  `meta_title` varchar(100) NOT NULL DEFAULT '' COMMENT 'SEO标题',
  `meta_keywords` varchar(100) NOT NULL DEFAULT '' COMMENT 'SEO关键字',
  `meta_description` varchar(250) NOT NULL DEFAULT '' COMMENT 'SEO描述',
  `is_hide` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '菜单上是否隐藏',
  `menu_sort` mediumint(8) unsigned NOT NULL DEFAULT '15' COMMENT '显示菜单的排序',
  `is_jump` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否跳转',
  `jump_url` varchar(100) NOT NULL DEFAULT '' COMMENT '跳转链接',
  `is_html` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否生成静态页面',
  `html_dir` varchar(100) NOT NULL DEFAULT '' COMMENT '生成静态页面存放目录',
  `tpl_home` varchar(100) NOT NULL DEFAULT '' COMMENT '封页模板名',
  `tpl_list` varchar(100) NOT NULL DEFAULT '' COMMENT '列表模板名',
  `tpl_view` varchar(100) NOT NULL DEFAULT '' COMMENT '文章模板名',
  `rule_list` varchar(100) NOT NULL DEFAULT 'list_{id}.html' COMMENT '列表静态页面链接规则',
  `rule_view` varchar(100) NOT NULL DEFAULT '{y}/{m}/{d}/{id}.html' COMMENT '文档静态页面链接规则',
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `category_name` (`category_name`),
  KEY `category_pid` (`category_pid`),
  KEY `module_id` (`module_id`),
  KEY `is_hide_menu_sort` (`is_hide`,`menu_sort`),
  KEY `is_jump` (`is_jump`),
  KEY `is_html` (`is_html`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文档类别表';

DROP TABLE IF EXISTS `tr_posts`;
CREATE TABLE `tr_posts` (
  `post_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '文档标题',
  `category_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '所属类别ID',
  `content` longtext COMMENT '文档内容',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `keywords` varchar(100) NOT NULL DEFAULT '' COMMENT '内容关键字',
  `description` varchar(500) NOT NULL DEFAULT '' COMMENT '内容摘要',
  `flags` set('h','c','j') NOT NULL DEFAULT '' COMMENT '文档标签，h：头条、c：推荐、j：跳转',
  `little_picture` varchar(100) NOT NULL DEFAULT '' COMMENT '缩略图地址',
  `is_jump` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否跳转',
  `jump_url` varchar(250) NOT NULL DEFAULT '' COMMENT '跳转链接',
  `is_html` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否生成静态页面',
  `html_url` varchar(250) NOT NULL DEFAULT '' COMMENT '生成静态页面链接',
  `allow_comment` enum('y','n') NOT NULL DEFAULT 'y' COMMENT '是否允许评论',
  `is_public` enum('y','n') NOT NULL DEFAULT 'y' COMMENT '是否发表，y：开放浏览、n：草稿或待审核',
  `access_count` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '访问次数',
  `creator_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建人ID',
  `last_modifier_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次编辑人ID',
  `dt_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `dt_last_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '上次编辑时间',
  `ip_created` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建IP',
  `ip_last_modified` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次编辑IP',
  `trash` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否删除',
  PRIMARY KEY (`post_id`),
  KEY `title` (`title`),
  KEY `category_id` (`category_id`),
  KEY `sort` (`sort`),
  KEY `trash_public_cat_sort` (`trash`,`is_public`,`category_id`,`sort`),
  KEY `flags_sort` (`flags`,`sort`),
  KEY `creator_id` (`creator_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统自带的文档管理表，用户可以通过模型添加自己的内容管理表';

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
  `content` text COMMENT '评论内容',
  `author_name` varchar(100) NOT NULL DEFAULT '' COMMENT '评论作者名',
  `author_mail` varchar(100) NOT NULL DEFAULT '' COMMENT '评论作者邮箱',
  `author_url` varchar(250) NOT NULL DEFAULT '' COMMENT '评论作者网址',
  `is_public` enum('y','n') NOT NULL DEFAULT 'y' COMMENT '是否发表，y：开放浏览、n：草稿或待审核',
  `creator_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建人ID',
  `last_modifier_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次编辑人ID',
  `dt_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `dt_last_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '上次编辑时间',
  `ip_created` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建IP',
  `ip_last_modified` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次编辑IP',
  `trash` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否删除',
  PRIMARY KEY (`comment_id`),
  KEY `trash_public_post` (`trash`,`is_public`,`post_id`),
  KEY `trash_public_creator` (`trash`,`is_public`,`creator_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统自带评论表-评论系统文档表中文档';
