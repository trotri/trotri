CREATE DATABASE IF NOT EXISTS `trotri`;

USE `trotri`;

DROP TABLE IF EXISTS `tr_builder_types`;
CREATE TABLE `tr_builder_types` (
  `type_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `type_name` varchar(100) NOT NULL DEFAULT '' COMMENT '类型名，单行文本、多行文本、密码、开关选项卡、提交按钮等',
  `form_type` varchar(100) NOT NULL DEFAULT '' COMMENT '表单类型名，HTML：text、password、button、radio等；用户自定义：ckeditor、datetime等',
  `field_type` varchar(100) NOT NULL DEFAULT '' COMMENT '表字段类型，INT、VARCHAR、CHAR、TEXT等',
  `category` enum('text','option','button') NOT NULL DEFAULT 'text' COMMENT '所属分类，text：文本类、option：选项类、button：按钮类',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`type_id`),
  KEY `type_name` (`type_name`),
  KEY `form_type` (`form_type`),
  KEY `field_type` (`field_type`),
  KEY `category` (`category`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='表单字段类型表';

INSERT INTO `tr_builder_types` VALUES (1, '单行文本(VARCHAR)', 'text', 'VARCHAR', 'text', 1);
INSERT INTO `tr_builder_types` VALUES (2, '单行文本(INT)', 'text', 'INT', 'text', 2);
INSERT INTO `tr_builder_types` VALUES (3, '密码', 'password', 'CHAR', 'text', 3);
INSERT INTO `tr_builder_types` VALUES (4, '开关选项卡', 'switch', 'ENUM', 'option', 4);
INSERT INTO `tr_builder_types` VALUES (5, '单选', 'radio', 'ENUM', 'option', 5);
INSERT INTO `tr_builder_types` VALUES (6, '多选', 'checkbox', 'VARCHAR', 'option', 6);
INSERT INTO `tr_builder_types` VALUES (7, '单选下拉框', 'select', 'INT', 'option', 7);
INSERT INTO `tr_builder_types` VALUES (8, '隐藏文本框(VARCHAR)', 'hidden', 'VARCHAR', 'text', 8);
INSERT INTO `tr_builder_types` VALUES (9, '隐藏文本框(INT)', 'hidden', 'INT', 'text', 9);
INSERT INTO `tr_builder_types` VALUES (10, '多行文本', 'textarea', 'TEXT', 'text', 10);
INSERT INTO `tr_builder_types` VALUES (11, '上传文件', 'file', 'VARCHAR', 'text', 11);

DROP TABLE IF EXISTS `tr_builders`;
CREATE TABLE `tr_builders` (
  `builder_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `builder_name` varchar(100) NOT NULL DEFAULT '' COMMENT '生成代码名',
  `tbl_name` varchar(100) NOT NULL DEFAULT '' COMMENT '表名',
  `tbl_profile` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否生成扩展表',
  `tbl_engine` enum('MyISAM','InnoDB') NOT NULL DEFAULT 'InnoDB' COMMENT '表引擎',
  `tbl_charset` enum('utf8','gbk','gb2312') NOT NULL DEFAULT 'utf8' COMMENT '表编码',
  `tbl_comment` varchar(200) NOT NULL DEFAULT '' COMMENT '表描述',
  `srv_type` enum('dynamic','normal') NOT NULL DEFAULT 'normal' COMMENT '代码类型，自动构建代码和SQL：dynamic、普通：normal',
  `srv_name` varchar(100) NOT NULL DEFAULT '' COMMENT '业务名',
  `app_name` varchar(100) NOT NULL DEFAULT '' COMMENT '应用名',
  `mod_name` varchar(100) NOT NULL DEFAULT '' COMMENT '模块名',
  `cls_name` varchar(100) NOT NULL DEFAULT '' COMMENT '类名',
  `ctrl_name` varchar(100) NOT NULL DEFAULT '' COMMENT '控制器名',
  `fk_column` varchar(100) NOT NULL DEFAULT '' COMMENT '外联其他表的字段名',
  `act_index_name` varchar(100) NOT NULL DEFAULT 'index' COMMENT '行动名-数据列表',
  `act_view_name` varchar(100) NOT NULL DEFAULT 'view' COMMENT '行动名-数据详情',
  `act_create_name` varchar(100) NOT NULL DEFAULT 'create' COMMENT '行动名-新增数据',
  `act_modify_name` varchar(100) NOT NULL DEFAULT 'modify' COMMENT '行动名-编辑数据',
  `act_remove_name` varchar(100) NOT NULL DEFAULT 'remove' COMMENT '行动名-删除数据',
  `index_row_btns` varchar(100) NOT NULL DEFAULT 'pencil|trash' COMMENT '数据列表每行操作Btn，编辑：pencil、移至回收站：trash、彻底删除：remove',
  `description` text COMMENT '描述',
  `author_name` varchar(100) NOT NULL DEFAULT '' COMMENT '作者姓名，代码注释用',
  `author_mail` varchar(100) NOT NULL DEFAULT '' COMMENT '作者邮箱，代码注释用',
  `dt_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `dt_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '上次编辑时间',
  `trash` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否删除',
  PRIMARY KEY (`builder_id`),
  KEY `builder_name` (`builder_name`),
  KEY `tbl_name` (`tbl_name`),
  KEY `tbl_profile` (`tbl_profile`),
  KEY `tbl_engine` (`tbl_engine`),
  KEY `tbl_charset` (`tbl_charset`),
  KEY `srv_type` (`srv_type`),
  KEY `srv_name` (`srv_name`),
  KEY `app_mod_ctrl` (`app_name`,`mod_name`,`ctrl_name`),
  KEY `trash` (`trash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='生成代码表';

DROP TABLE IF EXISTS `tr_builder_field_groups`;
CREATE TABLE `tr_builder_field_groups` (
  `group_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `group_name` varchar(100) NOT NULL DEFAULT '' COMMENT '组名',
  `prompt` varchar(100) NOT NULL DEFAULT '' COMMENT '提示',
  `builder_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '生成代码ID',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `description` text COMMENT '描述',
  PRIMARY KEY (`group_id`),
  KEY `group_name` (`group_name`),
  KEY `builder_id` (`builder_id`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='表单字段组表';

INSERT INTO `tr_builder_field_groups` VALUES (1, 'main', '主要信息', 0, 1, '默认');

DROP TABLE IF EXISTS `tr_builder_fields`;
CREATE TABLE `tr_builder_fields` (
  `field_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `field_name` varchar(100) NOT NULL DEFAULT '' COMMENT '字段名',
  `column_length` varchar(200) NOT NULL DEFAULT '0' COMMENT 'DB字段长度或用|分隔开的Enum值',
  `column_auto_increment` enum('y','n') NOT NULL DEFAULT 'y' COMMENT '是否自动递增',
  `column_unsigned` enum('y','n') NOT NULL DEFAULT 'y' COMMENT '是否无符号',
  `column_comment` varchar(200) NOT NULL DEFAULT '' COMMENT 'DB字段描述',
  `builder_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '生成代码ID',
  `group_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '表单字段组ID',
  `type_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '字段类型ID',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `html_label` varchar(100) NOT NULL DEFAULT '' COMMENT 'HTML：Table和Form显示名',
  `form_prompt` varchar(200) NOT NULL DEFAULT '' COMMENT '表单提示',
  `form_required` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '表单是否必填',
  `form_modifiable` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '编辑表单中允许输入',
  `index_show` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否在列表中展示',
  `index_sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '在列表中排序',
  `form_create_show` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否在新增表单中展示',
  `form_create_sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '在新增表单中排序',
  `form_modify_show` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否在编辑表单中展示',
  `form_modify_sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '在编辑表单中排序',
  `form_search_show` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否在查询表单中展示',
  `form_search_sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '在查询表单中排序',
  PRIMARY KEY (`field_id`),
  KEY `field_name` (`field_name`),
  KEY `builder_id` (`builder_id`),
  KEY `group_id` (`group_id`),
  KEY `type_id` (`type_id`),
  KEY `sort` (`sort`),
  KEY `index_sort` (`index_sort`),
  KEY `form_create_sort` (`form_create_sort`),
  KEY `form_modify_sort` (`form_modify_sort`),
  KEY `form_search_sort` (`form_search_sort`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='表单字段表';

DROP TABLE IF EXISTS `tr_builder_field_validators`;
CREATE TABLE `tr_builder_field_validators` (
  `validator_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `validator_name` varchar(100) NOT NULL DEFAULT '' COMMENT '验证类名',
  `field_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '表单字段ID',
  `options` varchar(100) NOT NULL DEFAULT '' COMMENT '验证时对比值，可以是布尔类型、整型、字符型、数组序列化',
  `option_category` enum('boolean','integer','string','array') NOT NULL DEFAULT 'boolean' COMMENT '验证时对比值类型',
  `message` varchar(100) NOT NULL DEFAULT '' COMMENT '出错提示消息',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `when` enum('all','create','modify') NOT NULL DEFAULT 'all' COMMENT '验证环境，任意时候验证、只在新增数据时验证、只在编辑数据时验证',
  PRIMARY KEY (`validator_id`),
  KEY `validator_name` (`validator_name`),
  KEY `field_id` (`field_id`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='表单字段验证表';

DROP TABLE IF EXISTS `tr_system_logwf_ym`;
CREATE TABLE `tr_system_logwf_ym` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `priority` enum('DB_EMERG','DB_ALERT','DB_CRIT','DB_ERR','DB_WARNING','DB_NOTICE','DB_INFO','DB_DEBUG') NOT NULL DEFAULT 'DB_WARNING' COMMENT '日志类型',
  `event` text COMMENT '日志内容',
  `dt_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='日志表，按月存Warning、Err等日志';

DROP TABLE IF EXISTS `tr_system_log_ymd`;
CREATE TABLE `tr_system_log_ymd` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `priority` enum('DB_EMERG','DB_ALERT','DB_CRIT','DB_ERR','DB_WARNING','DB_NOTICE','DB_INFO','DB_DEBUG') NOT NULL DEFAULT 'DB_NOTICE' COMMENT '日志类型',
  `event` text COMMENT '日志内容',
  `dt_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='日志表，按天存Notice、Info等日志';

DROP TABLE IF EXISTS `tr_system_options`;
CREATE TABLE `tr_system_options` (
  `option_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `option_key` varchar(64) NOT NULL DEFAULT '' COMMENT '配置Key',
  `option_value` longtext COMMENT '配置Value',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `uk_option_key` (`option_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='站点配置表';

DROP TABLE IF EXISTS `tr_menu_types`;
CREATE TABLE `tr_menu_types` (
  `type_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `type_name` varchar(100) NOT NULL DEFAULT '' COMMENT '类型名',
  `type_key` varchar(24) NOT NULL DEFAULT '' COMMENT '类型Key',
  `description` varchar(512) NOT NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`type_id`),
  UNIQUE KEY `uk_type_key` (`type_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='菜单类型表';

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='菜单表';

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户可访问的事件表';

INSERT INTO `tr_user_amcas` VALUES ('1', 'administrator', '0', '后端管理', '0', 'app');

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
  UNIQUE KEY `uk_login_name` (`login_name`),
  KEY `login_type` (`login_type`),
  KEY `user_name` (`user_name`),
  KEY `user_mail` (`user_mail`),
  KEY `user_phone` (`user_phone`),
  KEY `valid_mail` (`valid_mail`),
  KEY `valid_phone` (`valid_phone`),
  KEY `forbidden` (`forbidden`),
  KEY `trash` (`trash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户主表';

INSERT INTO `tr_users` VALUES ('1', 'administrator', 'name', '6d3f4f0d7f7ef593061de299599dcf17', 'UUeGTJ', 'administrator', '', '', now(), now(), '0000-00-00 00:00:00', '0', '0', '0', '0', '0', 'n', 'n', 'n', 'n');
INSERT INTO `tr_users` VALUES ('2', 'trotri@yeah.net', 'mail', '5faafdadd44658ca4af91887711329f1', 'SIKVbP', '宋欢', 'trotri@yeah.net', now(), now(), '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0', '0', '0', '0', 'n', 'n', 'n', 'n');

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
  `fields` text COMMENT '文档扩展字段',
  `forbidden` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否禁用',
  `description` varchar(512) NOT NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`module_id`),
  KEY `module_name` (`module_name`),
  KEY `forbidden` (`forbidden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文档模型表';

INSERT INTO `tr_post_modules` VALUES (1, '文档模型', '_source|文档来源', 'n', '');
INSERT INTO `tr_post_modules` VALUES (2, '图集模型', '_source|图片来源\n_width|图片宽\n_height|图片高', 'n', '');
INSERT INTO `tr_post_modules` VALUES (3, '文件模型', '_os|运行环境\n_type|文件类型|如：.exe、.zip、.rar等\n_size|文件大小|如：3MB、100KB等', 'n', '');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文档类别表';

INSERT INTO `tr_post_categories` VALUES (1, 0, '文档类别', '', '文档', 'trotri,文档', '文档', 'index.php', 'list.php', 'view.php', 1, '');

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

DROP TABLE IF EXISTS `tr_advert_types`;
CREATE TABLE `tr_advert_types` (
  `type_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `type_name` varchar(100) NOT NULL DEFAULT '' COMMENT '位置名',
  `type_key` varchar(24) NOT NULL DEFAULT '' COMMENT '位置Key',
  `picture` varchar(100) NOT NULL DEFAULT '' COMMENT '示例图片',
  `description` varchar(512) NOT NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`type_id`),
  UNIQUE KEY `uk_type_key` (`type_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='广告位置表';

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
  KEY `advert_url` (`advert_url`),
  KEY `advert_src` (`advert_src`),
  KEY `dt_publish_up` (`dt_publish_up`),
  KEY `dt_publish_down` (`dt_publish_down`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='广告表';

DROP TABLE IF EXISTS `tr_topic`;
CREATE TABLE `tr_topic` (
  `topic_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `topic_name` varchar(255) NOT NULL DEFAULT '' COMMENT '专题名',
  `topic_key` varchar(24) NOT NULL DEFAULT '' COMMENT '专题Key',
  `cover` varchar(255) NOT NULL DEFAULT '' COMMENT '封面大图',
  `meta_title` varchar(100) NOT NULL DEFAULT '' COMMENT 'SEO标题',
  `meta_keywords` varchar(100) NOT NULL DEFAULT '' COMMENT 'SEO关键字',
  `meta_description` varchar(255) NOT NULL DEFAULT '' COMMENT 'SEO描述',
  `html_style` longtext COMMENT '页面Style标签中内容',
  `html_script` longtext COMMENT '页面Script标签中内容',
  `html_head` longtext COMMENT '页面Head标签中内容',
  `html_body` longtext COMMENT '页面Body标签中内容',
  `is_published` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否发表，y：开放浏览、n：草稿',
  `use_header` enum('y','n') NOT NULL DEFAULT 'y' COMMENT '使用公共的页头',
  `use_footer` enum('y','n') NOT NULL DEFAULT 'y' COMMENT '使用公共的页脚',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `dt_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`topic_id`),
  UNIQUE KEY `uk_topic_key` (`topic_key`),
  KEY `topic_name` (`topic_name`),
  KEY `pub_sort` (`is_published`,`sort`),
  KEY `dt_created` (`dt_created`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='专题表';

DROP TABLE IF EXISTS `tr_member_types`;
CREATE TABLE `tr_member_types` (
  `type_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `type_name` varchar(100) NOT NULL DEFAULT '' COMMENT '类型名，普通会员、认证会员、达人、专家等',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `description` varchar(512) NOT NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`type_id`),
  UNIQUE KEY `uk_type_name` (`type_name`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员类型表';

INSERT INTO `tr_member_types` VALUES ('1', '普通会员', '1', '');

DROP TABLE IF EXISTS `tr_member_ranks`;
CREATE TABLE `tr_member_ranks` (
  `rank_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `rank_name` varchar(100) NOT NULL DEFAULT '' COMMENT '成长度名，注册会员、铜牌会员、银牌会员、金牌会员、钻石会员等',
  `experience` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '需要成长值',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `description` varchar(512) NOT NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`rank_id`),
  UNIQUE KEY `uk_rank_name` (`rank_name`),
  KEY `experience` (`experience`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员成长度表';

INSERT INTO `tr_member_ranks` VALUES ('1', '注册会员', '0', '1', '');
INSERT INTO `tr_member_ranks` VALUES ('2', '铜牌会员', '1', '2', '');
INSERT INTO `tr_member_ranks` VALUES ('3', '银牌会员', '2000', '3', '');
INSERT INTO `tr_member_ranks` VALUES ('4', '金牌会员', '10000', '4', '');
INSERT INTO `tr_member_ranks` VALUES ('5', '钻石会员', '30000', '5', '');

DROP TABLE IF EXISTS `tr_member_portal`;
CREATE TABLE `tr_member_portal` (
  `member_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `login_name` varchar(100) NOT NULL DEFAULT '' COMMENT '登录名：邮箱|用户名|手机号|第三方OpenID',
  `login_type` enum('mail','name','phone','partner') NOT NULL DEFAULT 'mail' COMMENT '登录方式，mail：邮箱、name：用户名(不能是纯数字、不能包含@符)、phone：手机号(11位数字)、partner：第三方账号',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '登录密码',
  `salt` char(6) NOT NULL DEFAULT '' COMMENT '随机附加混淆码',
  `member_name` varchar(100) NOT NULL DEFAULT '' COMMENT '会员名',
  `member_mail` varchar(100) NOT NULL DEFAULT '' COMMENT '邮箱，可用来找回密码',
  `member_phone` char(11) NOT NULL DEFAULT '' COMMENT '手机号，可用来找回密码',
  `relation_member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联会员ID，用于合并账号',
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
  PRIMARY KEY (`member_id`),
  UNIQUE KEY `uk_login_name` (`login_name`),
  KEY `login_type` (`login_type`),
  KEY `member_name` (`member_name`),
  KEY `member_mail` (`member_mail`),
  KEY `member_phone` (`member_phone`),
  KEY `valid_mail` (`valid_mail`),
  KEY `valid_phone` (`valid_phone`),
  KEY `forbidden` (`forbidden`),
  KEY `trash` (`trash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员登录表';

DROP TABLE IF EXISTS `tr_members`;
CREATE TABLE `tr_members` (
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `login_name` varchar(100) NOT NULL DEFAULT '' COMMENT '登录名：邮箱|用户名|手机号|第三方OpenID',
  `p_password` char(32) NOT NULL DEFAULT '' COMMENT '支付密码',
  `p_salt` char(6) NOT NULL DEFAULT '' COMMENT '支付密码-随机附加混淆码',
  `type_id` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT '会员类型ID',
  `rank_id` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT '会员成长度ID',
  `experience` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '成长值',
  `balance` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '预存款金额',
  `balance_freeze` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '预存款冻结金额',
  `points` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '积分',
  `points_freeze` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '冻结积分',
  `consum` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '消费总额',
  `orders` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单总数',
  `description` varchar(512) NOT NULL DEFAULT '' COMMENT '描述',
  `dt_last_rerank` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '上次更新成长度时间',
  `dt_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`member_id`),
  KEY `login_name` (`login_name`),
  KEY `type_id` (`type_id`),
  KEY `rank_id` (`rank_id`),
  KEY `experience` (`experience`),
  KEY `balance` (`balance`),
  KEY `points` (`points`),
  KEY `consum` (`consum`),
  KEY `orders` (`orders`),
  KEY `dt_created` (`dt_created`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员主表';

DROP TABLE IF EXISTS `tr_member_social`;
CREATE TABLE `tr_member_social` (
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `login_name` varchar(100) NOT NULL DEFAULT '' COMMENT '登录名：邮箱|用户名|手机号|第三方OpenID',
  `realname` varchar(100) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `sex` enum('male','female','unknow') NOT NULL DEFAULT 'unknow' COMMENT '性别，male：男性、female：女性、unknow：保密',
  `birth_ymd` date NOT NULL DEFAULT '0000-00-00' COMMENT '出生日',
  `birth_md` char(4) NOT NULL DEFAULT '0000' COMMENT '生日',
  `anniversary` char(4) NOT NULL DEFAULT '0000' COMMENT '纪念日',
  `head_portrait` varchar(1024) NOT NULL DEFAULT '' COMMENT '头像URL',
  `introduce` varchar(512) NOT NULL DEFAULT '' COMMENT '自我介绍',
  `interests` varchar(1024) NOT NULL DEFAULT '' COMMENT '兴趣爱好，由英文逗号分隔',
  `telephone` varchar(50) NOT NULL DEFAULT '' COMMENT '固定电话',
  `mobiphone` char(11) NOT NULL DEFAULT '' COMMENT '备用手机号',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '备用邮箱',
  `is_pub_birth` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否公开生日，y：是、n：否',
  `is_pub_anniversary` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否公开纪念日，y：是、n：否',
  `is_pub_interests` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否公开兴趣爱好，y：是、n：否',
  `is_pub_mobiphone` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否公开手机号，y：是、n：否',
  `is_pub_email` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否公开邮箱，y：是、n：否',
  `live_country_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '家乡-国家',
  `live_country` varchar(100) NOT NULL DEFAULT '' COMMENT '家乡-国家',
  `live_province_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '家乡-省',
  `live_province` varchar(100) NOT NULL DEFAULT '' COMMENT '家乡-省',
  `live_city_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '家乡-城市',
  `live_city` varchar(100) NOT NULL DEFAULT '' COMMENT '家乡-城市',
  `live_district_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '家乡-区域',
  `live_district` varchar(100) NOT NULL DEFAULT '' COMMENT '家乡-区域',
  `live_street` varchar(255) NOT NULL DEFAULT '' COMMENT '家乡-街道门牌号',
  `live_zipcode` varchar(20) NOT NULL DEFAULT '' COMMENT '家乡-邮编',
  `address_country_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '住址-国家',
  `address_country` varchar(100) NOT NULL DEFAULT '' COMMENT '住址-国家',
  `address_province_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '住址-省',
  `address_province` varchar(100) NOT NULL DEFAULT '' COMMENT '住址-省',
  `address_city_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '住址-城市',
  `address_city` varchar(100) NOT NULL DEFAULT '' COMMENT '住址-城市',
  `address_district_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '住址-区域',
  `address_district` varchar(100) NOT NULL DEFAULT '' COMMENT '住址-区域',
  `address_street` varchar(255) NOT NULL DEFAULT '' COMMENT '住址-街道门牌号',
  `address_zipcode` varchar(20) NOT NULL DEFAULT '' COMMENT '住址-邮编',
  `qq` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'QQ',
  `msn` varchar(100) NOT NULL DEFAULT '' COMMENT 'MSN',
  `skypeid` varchar(100) NOT NULL DEFAULT '' COMMENT 'Skype',
  `wangwang` varchar(100) NOT NULL DEFAULT '' COMMENT '旺旺',
  `weibo` varchar(255) NOT NULL DEFAULT '' COMMENT '微博',
  `blog` varchar(255) NOT NULL DEFAULT '' COMMENT '博客',
  `website` varchar(255) NOT NULL DEFAULT '' COMMENT '网站',
  `fax` varchar(50) NOT NULL DEFAULT '' COMMENT '传真',
  PRIMARY KEY (`member_id`),
  KEY `login_name` (`login_name`),
  KEY `realname` (`realname`),
  KEY `sex` (`sex`),
  KEY `birth_md` (`birth_md`),
  KEY `anniversary` (`anniversary`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员详情表';

DROP TABLE IF EXISTS `tr_member_profile`;
CREATE TABLE `tr_member_profile` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `profile_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `profile_key` varchar(255) NOT NULL DEFAULT '' COMMENT '扩展Key',
  `profile_value` longtext COMMENT '扩展Value',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_id_key` (`profile_id`,`profile_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员扩展表';

DROP TABLE IF EXISTS `tr_member_addresses`;
CREATE TABLE `tr_member_addresses` (
  `address_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `consignee` varchar(100) NOT NULL DEFAULT '' COMMENT '收货人姓名',
  `telephone` varchar(50) NOT NULL DEFAULT '' COMMENT '收货人固定电话',
  `mobiphone` char(11) NOT NULL DEFAULT '' COMMENT '收货人手机号',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '收货人邮箱',
  `addr_country_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '收货地址-国家',
  `addr_country` varchar(100) NOT NULL DEFAULT '' COMMENT '收货地址-国家',
  `addr_province_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '收货地址-省',
  `addr_province` varchar(100) NOT NULL DEFAULT '' COMMENT '收货地址-省',
  `addr_city_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '收货地址-城市',
  `addr_city` varchar(100) NOT NULL DEFAULT '' COMMENT '收货地址-城市',
  `addr_district_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '收货地址-区域',
  `addr_district` varchar(100) NOT NULL DEFAULT '' COMMENT '收货地址-区域',
  `addr_street` varchar(255) NOT NULL DEFAULT '' COMMENT '收货地址-街道门牌号',
  `addr_zipcode` varchar(20) NOT NULL DEFAULT '' COMMENT '收货地址-邮编',
  `when` enum('anyone','workday','weekend','holiday') NOT NULL DEFAULT 'anyone' COMMENT '收货最佳时间，anyone：任意时间、workday：工作日、weekend：双休日、holiday：假日',
  `is_default` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否默认地址',
  `dt_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `dt_last_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '上次编辑时间',
  PRIMARY KEY (`address_id`),
  KEY `member_dtlm` (`member_id`,`dt_last_modified`),
  KEY `member_default_dtlm` (`member_id`,`is_default`,`dt_last_modified`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员地址表';

DROP TABLE IF EXISTS `tr_member_balance_logs`;
CREATE TABLE `tr_member_balance_logs` (
  `log_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `op_type` enum('increase','reduce','reduce_freeze','freeze','unfreeze') NOT NULL DEFAULT 'increase' COMMENT '操作方式，increase：增加、reduce：扣除、reduce_freeze：扣除冻结金额、freeze：冻结、unfreeze：解冻',
  `before_balance` decimal(10,2) unsigned NOT NULL DEFAULT '0' COMMENT '原始预存款金额',
  `after_balance` decimal(10,2) unsigned NOT NULL DEFAULT '0' COMMENT '最终预存款金额',
  `balance` decimal(10,2) unsigned NOT NULL DEFAULT '0' COMMENT '增加或扣除预存款金额',
  `before_freeze_balance` decimal(10,2) unsigned NOT NULL DEFAULT '0' COMMENT '原始冻结预存款金额',
  `after_freeze_balance` decimal(10,2) unsigned NOT NULL DEFAULT '0' COMMENT '最终冻结预存款金额',
  `freeze_balance` decimal(10,2) unsigned NOT NULL DEFAULT '0' COMMENT '增加或扣除的冻结预存款金额',
  `source` char(10) NOT NULL DEFAULT '' COMMENT '来源，adminop：管理员操作、login：登录、signin：每日签到、p_order：提交订单、c_order：取消订单等',
  `remarks` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `creator_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员ID',
  `dt_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`log_id`),
  KEY `member_type_source` (`member_id`,`op_type`,`source`),
  KEY `member_source` (`member_id`,`source`),
  KEY `source` (`source`),
  KEY `creator_id` (`creator_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员预存款日志表';

DROP TABLE IF EXISTS `tr_member_points_logs`;
CREATE TABLE `tr_member_points_logs` (
  `log_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `op_type` enum('increase','reduce','reduce_freeze','freeze','unfreeze') NOT NULL DEFAULT 'increase' COMMENT '操作方式，increase：增加、reduce：扣除、reduce_freeze：扣除冻结积分、freeze：冻结、unfreeze：解冻',
  `before_points` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '原始积分',
  `after_points` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最终积分',
  `points` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '增加或扣除积分',
  `before_freeze_points` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '原始冻结积分',
  `after_freeze_points` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最终冻结积分',
  `freeze_points` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '增加或扣除的冻结积分',
  `source` char(10) NOT NULL DEFAULT '' COMMENT '来源，adminop：管理员操作、login：登录、signin：每日签到、p_order：提交订单、c_order：取消订单等',
  `remarks` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `creator_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员ID',
  `dt_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`log_id`),
  KEY `member_type_source` (`member_id`,`op_type`,`source`),
  KEY `member_source` (`member_id`,`source`),
  KEY `source` (`source`),
  KEY `creator_id` (`creator_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员积分日志表';

DROP TABLE IF EXISTS `tr_member_experience_logs`;
CREATE TABLE `tr_member_experience_logs` (
  `log_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `op_type` enum('increase','reduce') NOT NULL DEFAULT 'increase' COMMENT '操作方式，increase：增加、reduce：扣除',
  `before_experience` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '原始成长值',
  `after_experience` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最终成长值',
  `experience` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '增加或扣除成长值',
  `source` char(10) NOT NULL DEFAULT '' COMMENT '来源，adminop：管理员操作、login：登录、signin：每日签到、p_order：提交订单、c_order：取消订单等',
  `remarks` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `creator_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员ID',
  `dt_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`log_id`),
  KEY `member_type_source` (`member_id`,`op_type`,`source`),
  KEY `member_source` (`member_id`,`source`),
  KEY `source` (`source`),
  KEY `creator_id` (`creator_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员成长值日志表';

DROP TABLE IF EXISTS `tr_verifiers`;
CREATE TABLE `tr_verifiers` (
  `verifier_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `verifier_name` varchar(100) NOT NULL DEFAULT '' COMMENT '验证名',
  `verifier_key` varchar(24) NOT NULL DEFAULT '' COMMENT '验证Key',
  `m_rank_ids` varchar(50) NOT NULL DEFAULT '0' COMMENT '允许参与会员成长度ID，由英文逗号分隔，0：表示游客',
  `join_type` enum('forever','year','month','week','day','hour','interval') NOT NULL DEFAULT 'interval' COMMENT '参与方式，forever：终身只能参与一次、year：每年只能一次、...、interval：间隔几秒可再次参与',
  `interval` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '间隔几秒可再次参与，0：表示无限参与',
  `is_published` enum('y','n') NOT NULL DEFAULT 'y' COMMENT '验证状态，y：有效、n：无效',
  `dt_publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '开始时间',
  `dt_publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '结束时间',
  `description` varchar(512) NOT NULL DEFAULT '' COMMENT '描述',
  `ext_info` text COMMENT '扩展属性',
  `dt_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`verifier_id`),
  UNIQUE KEY `uk_verifier_key` (`verifier_key`),
  KEY `verifier_name` (`verifier_name`),
  KEY `is_published` (`is_published`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='参与验证表';

DROP TABLE IF EXISTS `tr_verifier_joiners`;
CREATE TABLE `tr_verifier_joiners` (
  `joiner_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `verifier_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '验证ID',
  `behavior` varchar(512) NOT NULL DEFAULT '' COMMENT '行为',
  `dt_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `dt_last_join` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '上次参与时间',
  PRIMARY KEY (`joiner_id`),
  UNIQUE KEY `uk_member_verifier` (`member_id`,`verifier_id`),
  KEY `verifier_id` (`verifier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='参与者表，需定期清理过期活动的参与日志';

DROP TABLE IF EXISTS `tr_polls`;
CREATE TABLE `tr_polls` (
  `poll_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `poll_name` varchar(100) NOT NULL DEFAULT '' COMMENT '投票名',
  `is_visible` enum('y','n') NOT NULL DEFAULT 'y' COMMENT '是否展示结果，y：是、n：否',
  `is_multiple` enum('y','n') NOT NULL DEFAULT 'y' COMMENT '是否多选，y：是、n：否',
  `max_choices` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '最多可选数量，0：表示不限制',
  `description` varchar(512) NOT NULL DEFAULT '' COMMENT '描述',
  `dt_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`poll_id`),
  KEY `poll_name` (`poll_name`),
  KEY `dt_created` (`dt_created`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='投票表';

DROP TABLE IF EXISTS `tr_polloptions`;
CREATE TABLE `tr_polloptions` (
  `option_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `option_name` varchar(255) NOT NULL DEFAULT '' COMMENT '选项名',
  `poll_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '投票ID',
  `votes` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '票数',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`option_id`),
  KEY `poll_id` (`poll_id`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='投票选项表';
