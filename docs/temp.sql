CREATE DATABASE IF NOT EXISTS `trotri`;

USE `trotri`;

DROP TABLE IF EXISTS `tr_system_options`;
CREATE TABLE `tr_system_options` (
  `option_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `site_name` varchar(100) NOT NULL DEFAULT '' COMMENT '网站名称',
  `site_url` varchar(1024) NOT NULL DEFAULT '' COMMENT '网站URL',
  `tpl_dir` varchar(100) NOT NULL DEFAULT '' COMMENT '模板名称',
  `html_dir` varchar(200) NOT NULL DEFAULT '' COMMENT '生成静态页面存放目录名称',
  `meta_title` varchar(100) NOT NULL DEFAULT '' COMMENT 'SEO Title',
  `meta_keywords` varchar(200) NOT NULL DEFAULT '' COMMENT 'SEO Keywords',
  `meta_description` varchar(500) NOT NULL DEFAULT '' COMMENT 'SEO Description',
  `powerby` varchar(200) NOT NULL DEFAULT '' COMMENT '网站版权信息',
  `stat_code` text COMMENT '网站第三方统计代码',
  `url_rewrite` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否使用重写模式获取URLS，在Apache上使用前先将文件“htaccess.txt”更名为“.htaccess”',
  `close_register` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否关闭新用户注册',
  `close_register_reason` text COMMENT '关闭注册原因',
  `show_register_service_item` enum('y','n') NOT NULL DEFAULT 'y' COMMENT '是否显示用户注册协议',
  `register_service_item` text COMMENT '用户注册协议',
  `thumb_width` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '缩略图宽(单位:px)',
  `thumb_height` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '缩略图高(单位:px)',
  `water_mark_type` enum('imgdir','text','none') NOT NULL DEFAULT 'none' COMMENT '水印类型，imgdir：只添加图片水印、text：只添加文字水印、none：不添加',
  `water_mark_imgdir` varchar(500) NOT NULL DEFAULT '' COMMENT '水印图片文件地址',
  `water_mark_text` varchar(500) NOT NULL DEFAULT '' COMMENT '水印文字信息',
  `water_mark_position` tinyint(5) unsigned NOT NULL DEFAULT '0' COMMENT '水印放置位置',
  `water_mark_pct` tinyint(5) unsigned NOT NULL DEFAULT '0' COMMENT '水印融合度',
  `smtp_host` varchar(200) NOT NULL DEFAULT '' COMMENT 'SMTP服务器',
  `smtp_port` tinyint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'SMTP服务器端口',
  `smtp_username` varchar(100) NOT NULL DEFAULT '' COMMENT 'SMTP服务器的账号',
  `smtp_password` varchar(100) NOT NULL DEFAULT '' COMMENT 'SMTP服务器的密码',
  `smtp_frommail` varchar(100) NOT NULL DEFAULT '' COMMENT '管理员邮箱',
  `page_var` varchar(100) NOT NULL DEFAULT 'paged' COMMENT '从$_GET或$_POST中获取当前页的键名',
  `list_rows_var` varchar(100) NOT NULL DEFAULT 'limit' COMMENT '从$_GET或$_POST中获取每页展示的行数的键名',
  `list_pages` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '每页展示的页码数',
  `list_rows` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '每页展示的行数',
  `list_rows_posts` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '文档列表每页展示条数',
  `list_rows_users` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '用户列表每页展示条数',
  PRIMARY KEY (`option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='站点配置表';

  `reg_valid_mail` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '注册是否验证邮箱',
  `reg_mail_subject` text COMMENT '邮件提示主题',
  `reg_mail_expiry` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '邮件验证限时(单位:分钟)',
  `reg_valid_phone` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '注册是否验证手机号',
  `reg_phone_subject` text COMMENT '短信提示主题',
  `reg_phone_expiry` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '短信验证限时(单位:分钟)',
  `reg_valid_invite` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '注册是否需要邀请',
  `reg_invite_subject` text COMMENT '邀请提示主题',
  `reg_invite_expiry` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '邀请验证限时(单位:分钟)',
  