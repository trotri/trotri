/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : trotri

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2014-10-31 19:23:10
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tr_adverts`
-- ----------------------------
DROP TABLE IF EXISTS `tr_adverts`;
CREATE TABLE `tr_adverts` (
  `advert_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `advert_name` varchar(255) NOT NULL DEFAULT '' COMMENT '广告名',
  `type_key` varchar(24) NOT NULL DEFAULT '' COMMENT '位置Key',
  `description` varchar(512) NOT NULL DEFAULT '' COMMENT '描述',
  `is_published` enum('y','n') NOT NULL DEFAULT 'y' COMMENT '是否发表，y：开放浏览、n：草稿',
  `dt_publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '开始发表时间',
  `dt_publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '结束发表时间，0000-00-00 00:00:00：永不过期',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `show_type` enum('code','text','image','flash') NOT NULL DEFAULT 'image' COMMENT '展现方式，code：代码、text：文字、image：图片、flash：Flash',
  `show_code` text COMMENT '展现代码',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '文字内容',
  `advert_url` varchar(1024) NOT NULL DEFAULT '' COMMENT '广告链接',
  `advert_src` varchar(255) NOT NULL DEFAULT '' COMMENT '图片|Flash链接',
  `advert_src2` varchar(255) NOT NULL DEFAULT '' COMMENT '辅图链接',
  `attr_alt` varchar(255) NOT NULL DEFAULT '' COMMENT '图片替换文字',
  `attr_width` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '图片|Flash-宽度，单位：px',
  `attr_height` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '图片|Flash-高度，单位：px',
  `attr_fontsize` varchar(100) NOT NULL DEFAULT '' COMMENT '文字大小，单位：pt、px、em',
  `attr_target` varchar(100) NOT NULL DEFAULT '_blank' COMMENT 'Target属性，如：_blank、_self、_parent、_top等',
  `dt_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`advert_id`),
  KEY `key_sort` (`type_key`,`sort`),
  KEY `key_pub_sort` (`type_key`,`is_published`,`sort`),
  KEY `advert_name` (`advert_name`),
  KEY `advert_url` (`advert_url`(255)),
  KEY `advert_src` (`advert_src`),
  KEY `dt_publish_up` (`dt_publish_up`),
  KEY `dt_publish_down` (`dt_publish_down`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='广告表';

-- ----------------------------
-- Records of tr_adverts
-- ----------------------------
INSERT INTO `tr_adverts` VALUES ('1', 'first', 'mainslide', '', 'y', '2014-10-31 18:47:59', '0000-00-00 00:00:00', '1', 'image', '<a target=\"_blank\" href=\"#\"><img src=\"/GitHub/trotri/data/u/adverts/first.jpg\" alt=\"first\" /></a>', '', '#', '/GitHub/trotri/data/u/adverts/first.jpg', '', 'first', '0', '0', '', '_blank', '2014-10-31 18:49:23');
INSERT INTO `tr_adverts` VALUES ('2', 'second', 'mainslide', '', 'y', '2014-10-31 18:49:23', '0000-00-00 00:00:00', '2', 'image', '<a target=\"_blank\" href=\"#\"><img src=\"/GitHub/trotri/data/u/adverts/second.jpg\" alt=\"second\" /></a>', '', '#', '/GitHub/trotri/data/u/adverts/second.jpg', '', 'second', '0', '0', '', '_blank', '2014-10-31 18:49:48');
INSERT INTO `tr_adverts` VALUES ('3', 'third', 'mainslide', '', 'y', '2014-10-31 18:50:03', '0000-00-00 00:00:00', '3', 'image', '<a target=\"_blank\" href=\"#\"><img src=\"/GitHub/trotri/data/u/adverts/third.jpg\" alt=\"third\" /></a>', '', '#', '/GitHub/trotri/data/u/adverts/third.jpg', '', 'third', '0', '0', '', '_blank', '2014-10-31 18:50:42');
INSERT INTO `tr_adverts` VALUES ('4', 'GitHub', 'friendlinks', '', 'y', '2014-10-31 19:02:32', '0000-00-00 00:00:00', '1000', 'text', '<a target=\"_blank\" href=\"http://www.github.com/\">GitHub</a>', 'GitHub', 'http://www.github.com/', '', '', '', '0', '0', '', '_blank', '2014-10-31 19:03:22');
INSERT INTO `tr_adverts` VALUES ('5', 'Bootcss', 'friendlinks', '', 'y', '2014-10-31 19:03:23', '0000-00-00 00:00:00', '1000', 'text', '<a target=\"_blank\" href=\"http://www.bootcss.com/\">Bootstrap</a>', 'Bootstrap', 'http://www.bootcss.com/', '', '', '', '0', '0', '', '_blank', '2014-10-31 19:03:48');
INSERT INTO `tr_adverts` VALUES ('6', 'Trotri', 'friendlinks', '', 'y', '2014-10-31 19:03:49', '0000-00-00 00:00:00', '1000', 'text', '<a target=\"_blank\" href=\"http://www.trotri.com/\">Trotri</a>', 'Trotri', 'http://www.trotri.com/', '', '', '', '0', '0', '', '_blank', '2014-10-31 19:04:13');
INSERT INTO `tr_adverts` VALUES ('7', '公告', 'notice', '', 'y', '2014-10-31 19:05:17', '0000-00-00 00:00:00', '1000', 'code', '网站公告', '', '', '', '', '', '0', '0', '', '_blank', '2014-10-31 19:05:41');

-- ----------------------------
-- Table structure for `tr_advert_types`
-- ----------------------------
DROP TABLE IF EXISTS `tr_advert_types`;
CREATE TABLE `tr_advert_types` (
  `type_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `type_name` varchar(100) NOT NULL DEFAULT '' COMMENT '位置名',
  `type_key` varchar(24) NOT NULL DEFAULT '' COMMENT '位置Key',
  `picture` varchar(100) NOT NULL DEFAULT '' COMMENT '示例图片',
  `description` varchar(512) NOT NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`type_id`),
  UNIQUE KEY `uk_type_key` (`type_key`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='广告位置表';

-- ----------------------------
-- Records of tr_advert_types
-- ----------------------------
INSERT INTO `tr_advert_types` VALUES ('1', '主要幻灯广告', 'mainslide', 'navbar', '');
INSERT INTO `tr_advert_types` VALUES ('2', '友情链接', 'friendlinks', 'block', '');
INSERT INTO `tr_advert_types` VALUES ('3', '公告', 'notice', 'notice', '');

-- ----------------------------
-- Table structure for `tr_menus`
-- ----------------------------
DROP TABLE IF EXISTS `tr_menus`;
CREATE TABLE `tr_menus` (
  `menu_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `menu_pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父菜单ID',
  `menu_name` varchar(255) NOT NULL DEFAULT '' COMMENT '菜单名',
  `menu_url` varchar(1024) NOT NULL DEFAULT '' COMMENT '菜单链接',
  `type_key` varchar(24) NOT NULL DEFAULT '' COMMENT '所属类型Key',
  `picture` varchar(255) NOT NULL DEFAULT '' COMMENT '图片链接',
  `alias` varchar(255) NOT NULL DEFAULT '' COMMENT '别名',
  `description` varchar(512) NOT NULL DEFAULT '' COMMENT '描述',
  `allow_unregistered` enum('y','n') NOT NULL DEFAULT 'y' COMMENT '是否允许非会员访问',
  `is_hide` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否隐藏',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `attr_target` varchar(100) NOT NULL DEFAULT '' COMMENT 'Target属性，如：_blank、_self、_parent、_top等',
  `attr_title` varchar(255) NOT NULL DEFAULT '' COMMENT 'Title属性',
  `attr_rel` varchar(100) NOT NULL DEFAULT '' COMMENT 'Rel属性，如：alternate、stylesheet、start、next、prev等',
  `attr_class` varchar(100) NOT NULL DEFAULT '' COMMENT 'CSS-class名',
  `attr_style` varchar(255) NOT NULL DEFAULT '' COMMENT 'CSS-style属性',
  `dt_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `dt_last_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '上次编辑时间',
  PRIMARY KEY (`menu_id`),
  KEY `key_pid` (`type_key`,`menu_pid`,`sort`),
  KEY `key_pid_allow` (`type_key`,`menu_pid`,`allow_unregistered`,`sort`),
  KEY `menu_name` (`menu_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='菜单表';

-- ----------------------------
-- Records of tr_menus
-- ----------------------------
INSERT INTO `tr_menus` VALUES ('1', '0', '首页', 'index.php', 'mainnav', '', '', '', 'y', 'n', '1', '', '', '', 'blog-nav-item', '', '2014-10-31 18:33:46', '2014-10-31 18:39:14');
INSERT INTO `tr_menus` VALUES ('2', '0', 'About', '#', 'mainnav', '', '', '', 'y', 'n', '1000', '', '', '', 'blog-nav-item', '', '2014-10-31 18:34:08', '2014-10-31 18:39:25');
INSERT INTO `tr_menus` VALUES ('3', '0', '新闻', 'index.php?r=posts/show/index&catid=2', 'mainnav', '', '', '', 'y', 'n', '2', '', '', '', 'blog-nav-item', '', '2014-10-31 18:34:48', '2014-10-31 19:15:17');

-- ----------------------------
-- Table structure for `tr_menu_types`
-- ----------------------------
DROP TABLE IF EXISTS `tr_menu_types`;
CREATE TABLE `tr_menu_types` (
  `type_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `type_name` varchar(100) NOT NULL DEFAULT '' COMMENT '类型名',
  `type_key` varchar(24) NOT NULL DEFAULT '' COMMENT '类型Key',
  `description` varchar(512) NOT NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`type_id`),
  UNIQUE KEY `uk_type_key` (`type_key`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='菜单类型表';

-- ----------------------------
-- Records of tr_menu_types
-- ----------------------------
INSERT INTO `tr_menu_types` VALUES ('1', '主导航', 'mainnav', '');

-- ----------------------------
-- Table structure for `tr_posts`
-- ----------------------------
DROP TABLE IF EXISTS `tr_posts`;
CREATE TABLE `tr_posts` (
  `post_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '文档标题',
  `alias` varchar(255) NOT NULL DEFAULT '' COMMENT '别名',
  `content` longtext COMMENT '文档内容',
  `keywords` varchar(100) NOT NULL DEFAULT '' COMMENT '内容关键字',
  `description` varchar(512) NOT NULL DEFAULT '' COMMENT '内容摘要',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `category_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '类别ID',
  `category_name` varchar(50) NOT NULL DEFAULT '' COMMENT '类别名',
  `module_id` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT '模型ID',
  `password` char(20) NOT NULL DEFAULT '' COMMENT '访问密码',
  `picture` varchar(255) NOT NULL DEFAULT '' COMMENT '主图地址',
  `is_head` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否头条',
  `is_recommend` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否推荐',
  `is_jump` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否跳转',
  `jump_url` varchar(255) NOT NULL DEFAULT '' COMMENT '跳转链接',
  `is_published` enum('y','n') NOT NULL DEFAULT 'y' COMMENT '是否发表，y：开放浏览、n：草稿或待审核',
  `dt_publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '开始发表时间',
  `dt_publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '结束发表时间，0000-00-00 00:00:00：永不过期',
  `comment_status` enum('publish','draft','forbidden') NOT NULL DEFAULT 'publish' COMMENT '评论设置，publish：开放浏览、draft：审核后展示、forbidden：禁止评论',
  `allow_other_modify` enum('y','n') NOT NULL DEFAULT 'y' COMMENT '是否允许其他人编辑',
  `hits` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '访问次数',
  `praise_count` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '赞美次数',
  `comment_count` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '评论次数',
  `creator_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建人ID',
  `creator_name` varchar(100) NOT NULL DEFAULT '' COMMENT '创建人',
  `last_modifier_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次编辑人ID',
  `last_modifier_name` varchar(100) NOT NULL DEFAULT '' COMMENT '上次编辑人',
  `dt_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `dt_last_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '上次编辑时间',
  `ip_created` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建IP',
  `ip_last_modified` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次编辑IP',
  `trash` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否删除',
  PRIMARY KEY (`post_id`),
  KEY `pub_category_sort` (`trash`,`is_published`,`category_id`,`sort`),
  KEY `pub_creator_sort` (`trash`,`is_published`,`creator_id`,`sort`),
  KEY `pub_head_sort` (`trash`,`is_published`,`is_head`,`sort`),
  KEY `pub_recommend_sort` (`trash`,`is_published`,`is_recommend`,`sort`),
  KEY `pub_hits` (`trash`,`is_published`,`hits`),
  KEY `pub_praise` (`trash`,`is_published`,`praise_count`),
  KEY `pub_comment` (`trash`,`is_published`,`comment_count`),
  KEY `title` (`title`),
  KEY `alias` (`alias`),
  KEY `sort` (`sort`),
  KEY `category_id` (`category_id`),
  KEY `module_id` (`module_id`),
  KEY `is_head` (`is_head`),
  KEY `is_recommend` (`is_recommend`),
  KEY `is_published` (`is_published`),
  KEY `dt_publish_up` (`dt_publish_up`),
  KEY `dt_publish_down` (`dt_publish_down`),
  KEY `hits` (`hits`),
  KEY `praise_count` (`praise_count`),
  KEY `comment_count` (`comment_count`),
  KEY `creator_id` (`creator_id`),
  KEY `last_modifier_id` (`last_modifier_id`),
  KEY `dt_created` (`dt_created`),
  KEY `dt_last_modified` (`dt_last_modified`),
  KEY `ip_created` (`ip_created`),
  KEY `ip_last_modified` (`ip_last_modified`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='文档管理表';

-- ----------------------------
-- Records of tr_posts
-- ----------------------------
INSERT INTO `tr_posts` VALUES ('1', '示例一', '', '<p>示例一：内容</p>\r\n', '', '示例一：摘要', '10000', '2', '新闻', '1', '', '/GitHub/trotri/data/u/posts/example.jpg', 'y', 'y', 'n', '', 'y', '2014-10-31 19:05:55', '0000-00-00 00:00:00', 'publish', 'y', '0', '0', '0', '1', 'administrator', '1', 'administrator', '2014-10-31 19:07:15', '2014-10-31 19:14:07', '2130706433', '2130706433', 'n');
INSERT INTO `tr_posts` VALUES ('2', '示例二', '', '<p>示例二：内容</p>', '', '示例二：摘要', '10000', '2', '文档类别', '1', '', '/GitHub/trotri/data/u/posts/example.jpg', 'y', 'y', 'n', '', 'y', '2014-10-31 19:07:43', '0000-00-00 00:00:00', 'publish', 'y', '0', '0', '0', '1', 'administrator', '1', 'administrator', '2014-10-31 19:07:49', '2014-10-31 19:10:45', '2130706433', '2130706433', 'n');
INSERT INTO `tr_posts` VALUES ('3', '示例三', '', '<p>示例三：内容</p>', '', '示例三：摘要', '10000', '2', '文档类别', '1', '', '/GitHub/trotri/data/u/posts/example.jpg', 'y', 'y', 'n', '', 'y', '2014-10-31 19:07:50', '0000-00-00 00:00:00', 'publish', 'y', '0', '0', '0', '1', 'administrator', '1', 'administrator', '2014-10-31 19:07:54', '2014-10-31 19:10:31', '2130706433', '2130706433', 'n');
INSERT INTO `tr_posts` VALUES ('4', '示例四', '', '<p>示例四：内容</p>', '', '示例四：摘要', '10000', '2', '文档类别', '1', '', '/GitHub/trotri/data/u/posts/example.jpg', 'y', 'y', 'n', '', 'y', '2014-10-31 19:07:54', '0000-00-00 00:00:00', 'publish', 'y', '0', '0', '0', '1', 'administrator', '1', 'administrator', '2014-10-31 19:07:59', '2014-10-31 19:10:46', '2130706433', '2130706433', 'n');
INSERT INTO `tr_posts` VALUES ('5', '示例五', '', '<p>示例五：内容</p>', '', '示例五：摘要', '10000', '2', '文档类别', '1', '', '/GitHub/trotri/data/u/posts/example.jpg', 'n', 'n', 'n', '', 'y', '2014-10-31 19:07:59', '0000-00-00 00:00:00', 'publish', 'y', '0', '0', '0', '1', 'administrator', '1', 'administrator', '2014-10-31 19:08:04', '2014-10-31 19:10:47', '2130706433', '2130706433', 'n');
INSERT INTO `tr_posts` VALUES ('6', '示例六', '', '<p>示例六：内容</p>', '', '示例六：摘要', '10000', '2', '文档类别', '1', '', '/GitHub/trotri/data/u/posts/example.jpg', 'n', 'n', 'n', '', 'y', '2014-10-31 19:08:04', '0000-00-00 00:00:00', 'publish', 'y', '0', '0', '0', '1', 'administrator', '1', 'administrator', '2014-10-31 19:08:15', '2014-10-31 19:08:15', '2130706433', '2130706433', 'n');

-- ----------------------------
-- Table structure for `tr_post_categories`
-- ----------------------------
DROP TABLE IF EXISTS `tr_post_categories`;
CREATE TABLE `tr_post_categories` (
  `category_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `category_pid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父类别ID',
  `category_name` varchar(50) NOT NULL DEFAULT '' COMMENT '类别名',
  `alias` varchar(255) NOT NULL DEFAULT '' COMMENT '别名',
  `meta_title` varchar(100) NOT NULL DEFAULT '' COMMENT 'SEO标题',
  `meta_keywords` varchar(100) NOT NULL DEFAULT '' COMMENT 'SEO关键字',
  `meta_description` varchar(255) NOT NULL DEFAULT '' COMMENT 'SEO描述',
  `tpl_home` varchar(100) NOT NULL DEFAULT '' COMMENT '封页模板名',
  `tpl_list` varchar(100) NOT NULL DEFAULT '' COMMENT '列表模板名',
  `tpl_view` varchar(100) NOT NULL DEFAULT '' COMMENT '文档模板名',
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '15' COMMENT '排序',
  `description` varchar(512) NOT NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `uk_pid_name` (`category_pid`,`category_name`),
  KEY `category_pid` (`category_pid`,`sort`),
  KEY `alias` (`alias`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='文档类别表';

-- ----------------------------
-- Records of tr_post_categories
-- ----------------------------
INSERT INTO `tr_post_categories` VALUES ('1', '0', '文档类别', '', '文档', 'trotri,文档', '文档', 'index.php', 'list.php', 'view.php', '1', '');
INSERT INTO `tr_post_categories` VALUES ('2', '1', '新闻', '', '新闻', '我的网站,文档,新闻', '每天最新资讯.', 'home', 'index', 'view', '1', '');

-- ----------------------------
-- Table structure for `tr_post_comments`
-- ----------------------------
DROP TABLE IF EXISTS `tr_post_comments`;
CREATE TABLE `tr_post_comments` (
  `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `comment_pid` int(20) unsigned NOT NULL DEFAULT '0' COMMENT '父评论ID',
  `post_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文档ID',
  `content` text COMMENT '评论内容',
  `author_name` varchar(100) NOT NULL DEFAULT '' COMMENT '评论作者名',
  `author_mail` varchar(100) NOT NULL DEFAULT '' COMMENT '评论作者邮箱',
  `author_url` varchar(255) NOT NULL DEFAULT '' COMMENT '评论作者网址',
  `is_published` enum('y','n') NOT NULL DEFAULT 'y' COMMENT '是否发表，y：开放浏览、n：待审核',
  `good_count` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '好评次数',
  `bad_count` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '差评次数',
  `creator_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建人ID',
  `creator_name` varchar(100) NOT NULL DEFAULT '' COMMENT '创建人登录名',
  `last_modifier_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次编辑人ID',
  `last_modifier_name` varchar(100) NOT NULL DEFAULT '' COMMENT '上次编辑人登录名',
  `dt_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `dt_last_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '上次编辑时间',
  `ip_created` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建IP',
  `ip_last_modified` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次编辑IP',
  PRIMARY KEY (`comment_id`),
  KEY `post_id` (`post_id`),
  KEY `creator_id` (`creator_id`),
  KEY `ip_created` (`ip_created`),
  KEY `good_count` (`good_count`),
  KEY `pub_post_dtlm` (`is_published`,`post_id`,`comment_pid`,`dt_last_modified`),
  KEY `pub_post_good` (`is_published`,`post_id`,`comment_pid`,`good_count`),
  KEY `pub_creator_dtlm` (`is_published`,`creator_id`,`comment_pid`,`dt_last_modified`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文档评论表';

-- ----------------------------
-- Records of tr_post_comments
-- ----------------------------

-- ----------------------------
-- Table structure for `tr_post_modules`
-- ----------------------------
DROP TABLE IF EXISTS `tr_post_modules`;
CREATE TABLE `tr_post_modules` (
  `module_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `module_name` varchar(50) NOT NULL DEFAULT '' COMMENT '模型名称',
  `fields` text COMMENT '文档扩展字段',
  `forbidden` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否禁用',
  `description` varchar(512) NOT NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`module_id`),
  KEY `module_name` (`module_name`),
  KEY `forbidden` (`forbidden`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='文档模型表';

-- ----------------------------
-- Records of tr_post_modules
-- ----------------------------
INSERT INTO `tr_post_modules` VALUES ('1', '文档模型', '_source|文档来源', 'n', '');
INSERT INTO `tr_post_modules` VALUES ('2', '图集模型', '_source|图片来源\n_width|图片宽\n_height|图片高', 'n', '');
INSERT INTO `tr_post_modules` VALUES ('3', '文件模型', '_os|运行环境\n_type|文件类型|如：.exe、.zip、.rar等\n_size|文件大小|如：3MB、100KB等', 'n', '');

-- ----------------------------
-- Table structure for `tr_post_profile`
-- ----------------------------
DROP TABLE IF EXISTS `tr_post_profile`;
CREATE TABLE `tr_post_profile` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `profile_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文档ID',
  `profile_key` varchar(255) NOT NULL DEFAULT '' COMMENT '扩展Key',
  `profile_value` longtext COMMENT '扩展Value',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_id_key` (`profile_id`,`profile_key`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='文档扩展表';

-- ----------------------------
-- Records of tr_post_profile
-- ----------------------------
INSERT INTO `tr_post_profile` VALUES ('1', '1', '_source', '');

-- ----------------------------
-- Table structure for `tr_system_logwf_ym`
-- ----------------------------
DROP TABLE IF EXISTS `tr_system_logwf_ym`;
CREATE TABLE `tr_system_logwf_ym` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `priority` enum('DB_EMERG','DB_ALERT','DB_CRIT','DB_ERR','DB_WARNING','DB_NOTICE','DB_INFO','DB_DEBUG') NOT NULL DEFAULT 'DB_WARNING' COMMENT '日志类型',
  `event` text COMMENT '日志内容',
  `dt_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='日志表，按月存Warning、Err等日志';

-- ----------------------------
-- Records of tr_system_logwf_ym
-- ----------------------------

-- ----------------------------
-- Table structure for `tr_system_log_ymd`
-- ----------------------------
DROP TABLE IF EXISTS `tr_system_log_ymd`;
CREATE TABLE `tr_system_log_ymd` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `priority` enum('DB_EMERG','DB_ALERT','DB_CRIT','DB_ERR','DB_WARNING','DB_NOTICE','DB_INFO','DB_DEBUG') NOT NULL DEFAULT 'DB_NOTICE' COMMENT '日志类型',
  `event` text COMMENT '日志内容',
  `dt_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='日志表，按天存Notice、Info等日志';

-- ----------------------------
-- Records of tr_system_log_ymd
-- ----------------------------

-- ----------------------------
-- Table structure for `tr_system_options`
-- ----------------------------
DROP TABLE IF EXISTS `tr_system_options`;
CREATE TABLE `tr_system_options` (
  `option_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `option_key` varchar(64) NOT NULL DEFAULT '' COMMENT '配置Key',
  `option_value` longtext COMMENT '配置Value',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `uk_option_key` (`option_key`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COMMENT='站点配置表';

-- ----------------------------
-- Records of tr_system_options
-- ----------------------------
INSERT INTO `tr_system_options` VALUES ('1', 'site_name', '我的网站');
INSERT INTO `tr_system_options` VALUES ('2', 'site_url', 'http://www.trotri.com');
INSERT INTO `tr_system_options` VALUES ('3', 'tpl_dir', 'bootstrap');
INSERT INTO `tr_system_options` VALUES ('4', 'html_dir', 'a');
INSERT INTO `tr_system_options` VALUES ('5', 'meta_title', '');
INSERT INTO `tr_system_options` VALUES ('6', 'meta_keywords', '');
INSERT INTO `tr_system_options` VALUES ('7', 'meta_description', '');
INSERT INTO `tr_system_options` VALUES ('8', 'powerby', 'Powered by Trotri! 1.0');
INSERT INTO `tr_system_options` VALUES ('9', 'stat_code', '');
INSERT INTO `tr_system_options` VALUES ('10', 'url_rewrite', 'n');
INSERT INTO `tr_system_options` VALUES ('11', 'close_register', 'n');
INSERT INTO `tr_system_options` VALUES ('12', 'close_register_reason', '');
INSERT INTO `tr_system_options` VALUES ('13', 'show_register_service_item', 'y');
INSERT INTO `tr_system_options` VALUES ('14', 'register_service_item', '');
INSERT INTO `tr_system_options` VALUES ('15', 'thumb_width', '100');
INSERT INTO `tr_system_options` VALUES ('16', 'thumb_height', '100');
INSERT INTO `tr_system_options` VALUES ('17', 'water_mark_type', 'none');
INSERT INTO `tr_system_options` VALUES ('18', 'water_mark_imgdir', '');
INSERT INTO `tr_system_options` VALUES ('19', 'water_mark_text', '');
INSERT INTO `tr_system_options` VALUES ('20', 'water_mark_position', '9');
INSERT INTO `tr_system_options` VALUES ('21', 'water_mark_pct', '0');
INSERT INTO `tr_system_options` VALUES ('22', 'smtp_host', '');
INSERT INTO `tr_system_options` VALUES ('23', 'smtp_port', '25');
INSERT INTO `tr_system_options` VALUES ('24', 'smtp_username', '');
INSERT INTO `tr_system_options` VALUES ('25', 'smtp_password', '');
INSERT INTO `tr_system_options` VALUES ('26', 'smtp_frommail', '');
INSERT INTO `tr_system_options` VALUES ('27', 'page_var', 'paged');
INSERT INTO `tr_system_options` VALUES ('28', 'list_rows_var', 'limit');
INSERT INTO `tr_system_options` VALUES ('29', 'list_pages', '10');
INSERT INTO `tr_system_options` VALUES ('30', 'list_rows', '10');
INSERT INTO `tr_system_options` VALUES ('31', 'list_rows_posts', '10');
INSERT INTO `tr_system_options` VALUES ('32', 'list_rows_users', '10');

-- ----------------------------
-- Table structure for `tr_users`
-- ----------------------------
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
  UNIQUE KEY `uk_login_name` (`login_name`),
  KEY `login_type` (`login_type`),
  KEY `user_name` (`user_name`),
  KEY `user_mail` (`user_mail`),
  KEY `user_phone` (`user_phone`),
  KEY `valid_mail` (`valid_mail`),
  KEY `valid_phone` (`valid_phone`),
  KEY `forbidden` (`forbidden`),
  KEY `trash` (`trash`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='用户主表';

-- ----------------------------
-- Records of tr_users
-- ----------------------------
INSERT INTO `tr_users` VALUES ('1', 'administrator', 'name', '6d3f4f0d7f7ef593061de299599dcf17', 'UUeGTJ', 'administrator', '', '', '2014-10-31 18:23:38', '2014-10-31 18:32:15', '0000-00-00 00:00:00', '0', '0', '0', '1', '0', 'n', 'n', 'n', 'n');
INSERT INTO `tr_users` VALUES ('2', 'trotri@yeah.net', 'mail', '5faafdadd44658ca4af91887711329f1', 'SIKVbP', '宋欢', 'trotri@yeah.net', '2014-10-31', '2014-10-31 18:23:38', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0', '0', '0', '0', 'n', 'n', 'n', 'n');

-- ----------------------------
-- Table structure for `tr_user_amcas`
-- ----------------------------
DROP TABLE IF EXISTS `tr_user_amcas`;
CREATE TABLE `tr_user_amcas` (
  `amca_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `amca_name` varchar(100) NOT NULL DEFAULT '' COMMENT '事件名',
  `amca_pid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `prompt` varchar(100) NOT NULL DEFAULT '' COMMENT '提示',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `category` enum('app','mod','ctrl','act') NOT NULL DEFAULT 'act' COMMENT '类型，app：应用、mod：模块、ctrl：控制器、act：行动',
  PRIMARY KEY (`amca_id`),
  UNIQUE KEY `uk_pid_name` (`amca_pid`,`amca_name`),
  KEY `amca_name` (`amca_name`),
  KEY `sort` (`sort`),
  KEY `category` (`category`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户可访问的事件表';

-- ----------------------------
-- Records of tr_user_amcas
-- ----------------------------
INSERT INTO `tr_user_amcas` VALUES ('1', 'administrator', '0', '后端管理', '0', 'app');

-- ----------------------------
-- Table structure for `tr_user_groups`
-- ----------------------------
DROP TABLE IF EXISTS `tr_user_groups`;
CREATE TABLE `tr_user_groups` (
  `group_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `group_name` varchar(100) NOT NULL DEFAULT '' COMMENT '组名',
  `group_pid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `permission` text COMMENT '权限设置，可访问的事件，由应用-模块-控制器-行动组合',
  `description` varchar(512) NOT NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`group_id`),
  UNIQUE KEY `uk_group_name` (`group_name`),
  KEY `group_pid` (`group_pid`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='用户分组表';

-- ----------------------------
-- Records of tr_user_groups
-- ----------------------------
INSERT INTO `tr_user_groups` VALUES ('1', 'Public', '0', '0', '', '公开组，未登录用户拥有该权限');
INSERT INTO `tr_user_groups` VALUES ('2', 'Guest', '1', '1', null, '普通会员');
INSERT INTO `tr_user_groups` VALUES ('3', 'Manager', '1', '2', null, '普通管理员');
INSERT INTO `tr_user_groups` VALUES ('4', 'Registered', '1', '3', null, '记名作者');
INSERT INTO `tr_user_groups` VALUES ('5', 'Super Users', '1', '4', null, '超级会员');
INSERT INTO `tr_user_groups` VALUES ('6', 'Administrator', '3', '1', null, '超级管理员');
INSERT INTO `tr_user_groups` VALUES ('7', 'Author', '4', '1', null, '普通作者');
INSERT INTO `tr_user_groups` VALUES ('8', 'Editor', '7', '1', null, '高级作者');
INSERT INTO `tr_user_groups` VALUES ('9', 'Publisher', '8', '1', null, '出版者');

-- ----------------------------
-- Table structure for `tr_user_profile`
-- ----------------------------
DROP TABLE IF EXISTS `tr_user_profile`;
CREATE TABLE `tr_user_profile` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `profile_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `profile_key` varchar(255) NOT NULL DEFAULT '' COMMENT '扩展Key',
  `profile_value` longtext COMMENT '扩展Value',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_id_key` (`profile_id`,`profile_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户扩展表';

-- ----------------------------
-- Records of tr_user_profile
-- ----------------------------

-- ----------------------------
-- Table structure for `tr_user_usergroups_map`
-- ----------------------------
DROP TABLE IF EXISTS `tr_user_usergroups_map`;
CREATE TABLE `tr_user_usergroups_map` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `group_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '用户组ID',
  PRIMARY KEY (`user_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户和用户组关联表';

-- ----------------------------
-- Records of tr_user_usergroups_map
-- ----------------------------
