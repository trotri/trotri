INSERT INTO `#@__builder_types` VALUES (1, '单行文本(VARCHAR)', 'text', 'VARCHAR', 'text', 1);
INSERT INTO `#@__builder_types` VALUES (2, '单行文本(INT)', 'text', 'INT', 'text', 2);
INSERT INTO `#@__builder_types` VALUES (3, '密码', 'password', 'CHAR', 'text', 3);
INSERT INTO `#@__builder_types` VALUES (4, '开关选项卡', 'switch', 'ENUM', 'option', 4);
INSERT INTO `#@__builder_types` VALUES (5, '单选', 'radio', 'ENUM', 'option', 5);
INSERT INTO `#@__builder_types` VALUES (6, '多选', 'checkbox', 'VARCHAR', 'option', 6);
INSERT INTO `#@__builder_types` VALUES (7, '单选下拉框', 'select', 'INT', 'option', 7);
INSERT INTO `#@__builder_types` VALUES (8, '隐藏文本框(VARCHAR)', 'hidden', 'VARCHAR', 'text', 8);
INSERT INTO `#@__builder_types` VALUES (9, '隐藏文本框(INT)', 'hidden', 'INT', 'text', 9);
INSERT INTO `#@__builder_types` VALUES (10, '多行文本', 'textarea', 'TEXT', 'text', 10);
INSERT INTO `#@__builder_types` VALUES (11, '上传文件', 'file', 'VARCHAR', 'text', 11);

INSERT INTO `#@__builder_field_groups` VALUES (1, 'main', '主要信息', 0, 1, '默认');

INSERT INTO `#@__system_options` VALUES ('1', 'site_name', '我的网站');
INSERT INTO `#@__system_options` VALUES ('2', 'site_url', 'http://www.trotri.com');
INSERT INTO `#@__system_options` VALUES ('3', 'meta_title', '我的网站');
INSERT INTO `#@__system_options` VALUES ('4', 'meta_keywords', '我的网站,trotri,tfc,cms');
INSERT INTO `#@__system_options` VALUES ('5', 'meta_description', 'Trotri-PHP开发框架');
INSERT INTO `#@__system_options` VALUES ('6', 'powerby', 'Powered by Trotri! 1.0');
INSERT INTO `#@__system_options` VALUES ('7', 'stat_code', '');
INSERT INTO `#@__system_options` VALUES ('8', 'url_rewrite', 'n');
INSERT INTO `#@__system_options` VALUES ('9', 'close_register', 'n');
INSERT INTO `#@__system_options` VALUES ('10', 'close_register_reason', '冗余字段，暂时用不到。');
INSERT INTO `#@__system_options` VALUES ('11', 'show_register_service_item', 'y');
INSERT INTO `#@__system_options` VALUES ('12', 'register_service_item', '冗余字段，暂时用不到。');
INSERT INTO `#@__system_options` VALUES ('13', 'thumb_width', '1');
INSERT INTO `#@__system_options` VALUES ('14', 'thumb_height', '1');
INSERT INTO `#@__system_options` VALUES ('15', 'water_mark_type', 'none');
INSERT INTO `#@__system_options` VALUES ('16', 'water_mark_imgdir', '冗余字段，暂时用不到。');
INSERT INTO `#@__system_options` VALUES ('17', 'water_mark_text', '冗余字段，暂时用不到。');
INSERT INTO `#@__system_options` VALUES ('18', 'water_mark_position', '9');
INSERT INTO `#@__system_options` VALUES ('19', 'water_mark_pct', '0');
INSERT INTO `#@__system_options` VALUES ('20', 'smtp_host', '');
INSERT INTO `#@__system_options` VALUES ('21', 'smtp_port', '25');
INSERT INTO `#@__system_options` VALUES ('22', 'smtp_username', '');
INSERT INTO `#@__system_options` VALUES ('23', 'smtp_password', '');
INSERT INTO `#@__system_options` VALUES ('24', 'smtp_frommail', '');
INSERT INTO `#@__system_options` VALUES ('25', 'list_rows_posts', '10');
INSERT INTO `#@__system_options` VALUES ('26', 'list_rows_post_comments', '5');
INSERT INTO `#@__system_options` VALUES ('27', 'list_rows_users', '10');

INSERT INTO `#@__menu_types` VALUES ('1', '主导航', 'mainnav', '');

INSERT INTO `#@__menus` VALUES ('1', '0', '首页', 'index.php', 'mainnav', '', '', '', 'y', 'n', '1', '', '', '', 'blog-nav-item', '', '2014-11-05 13:53:02', '2014-11-05 13:56:31');
INSERT INTO `#@__menus` VALUES ('2', '0', '文档', 'index.php?r=posts/show/index&catid=1', 'mainnav', '', '', '', 'y', 'n', '2', '', '', '', 'blog-nav-item', '', '2014-11-05 13:54:04', '2014-11-05 13:56:37');
INSERT INTO `#@__menus` VALUES ('3', '0', '专题', 'index.php?r=topic/show/index', 'mainnav', '', '', '', 'y', 'n', '3', '_blank', '', '', 'blog-nav-item', '', '2014-11-05 13:54:47', '2014-11-05 14:02:45');

INSERT INTO `#@__user_amcas` VALUES ('1', 'administrator', '0', '后端管理', '0', 'app');
INSERT INTO `#@__user_amcas` VALUES ('2', 'system', '1', '站点管理', '1', 'mod');
INSERT INTO `#@__user_amcas` VALUES ('3', 'users', '1', '管理员管理', '2', 'mod');
INSERT INTO `#@__user_amcas` VALUES ('4', 'builder', '1', '生成代码管理', '3', 'mod');
INSERT INTO `#@__user_amcas` VALUES ('5', 'posts', '1', '文档管理', '4', 'mod');
INSERT INTO `#@__user_amcas` VALUES ('6', 'menus', '1', '菜单管理', '5', 'mod');
INSERT INTO `#@__user_amcas` VALUES ('7', 'topic', '1', '专题管理', '6', 'mod');
INSERT INTO `#@__user_amcas` VALUES ('8', 'advert', '1', '广告管理', '7', 'mod');
INSERT INTO `#@__user_amcas` VALUES ('9', 'options', '2', '站点配置', '0', 'ctrl');
INSERT INTO `#@__user_amcas` VALUES ('10', 'pictures', '2', '图片管理', '1', 'ctrl');
INSERT INTO `#@__user_amcas` VALUES ('11', 'site', '2', '系统管理', '2', 'ctrl');
INSERT INTO `#@__user_amcas` VALUES ('12', 'tools', '2', '工具管理', '3', 'ctrl');
INSERT INTO `#@__user_amcas` VALUES ('13', 'account', '3', '管理员账户管理', '0', 'ctrl');
INSERT INTO `#@__user_amcas` VALUES ('14', 'amcas', '3', '管理员可访问的事件', '1', 'ctrl');
INSERT INTO `#@__user_amcas` VALUES ('15', 'groups', '3', '管理组', '2', 'ctrl');
INSERT INTO `#@__user_amcas` VALUES ('16', 'users', '3', '管理员管理', '3', 'ctrl');
INSERT INTO `#@__user_amcas` VALUES ('17', 'builders', '4', '生成代码', '0', 'ctrl');
INSERT INTO `#@__user_amcas` VALUES ('18', 'fields', '4', '表单字段', '1', 'ctrl');
INSERT INTO `#@__user_amcas` VALUES ('19', 'groups', '4', '字段组', '2', 'ctrl');
INSERT INTO `#@__user_amcas` VALUES ('20', 'tblnames', '4', '数据库表管理', '3', 'ctrl');
INSERT INTO `#@__user_amcas` VALUES ('21', 'types', '4', '表单字段类型', '4', 'ctrl');
INSERT INTO `#@__user_amcas` VALUES ('22', 'validators', '4', '表单字段验证', '5', 'ctrl');
INSERT INTO `#@__user_amcas` VALUES ('23', 'categories', '5', '类别管理', '0', 'ctrl');
INSERT INTO `#@__user_amcas` VALUES ('24', 'comments', '5', '文档评论', '1', 'ctrl');
INSERT INTO `#@__user_amcas` VALUES ('25', 'modules', '5', '模型管理', '2', 'ctrl');
INSERT INTO `#@__user_amcas` VALUES ('26', 'posts', '5', '文档管理', '3', 'ctrl');
INSERT INTO `#@__user_amcas` VALUES ('27', 'menus', '6', '菜单管理', '0', 'ctrl');
INSERT INTO `#@__user_amcas` VALUES ('28', 'types', '6', '菜单类型', '1', 'ctrl');
INSERT INTO `#@__user_amcas` VALUES ('29', 'topic', '7', '专题管理', '0', 'ctrl');
INSERT INTO `#@__user_amcas` VALUES ('30', 'adverts', '8', '广告管理', '0', 'ctrl');
INSERT INTO `#@__user_amcas` VALUES ('31', 'types', '8', '广告位置', '1', 'ctrl');
INSERT INTO `#@__user_amcas` VALUES ('32', 'poll', '1', '投票管理', '8', 'mod');
INSERT INTO `#@__user_amcas` VALUES ('33', 'polloptions', '32', '投票选项', '0', 'ctrl');
INSERT INTO `#@__user_amcas` VALUES ('34', 'polls', '32', '投票管理', '1', 'ctrl');
INSERT INTO `#@__user_amcas` VALUES ('35', 'member', '1', '会员管理', '9', 'mod');
INSERT INTO `#@__user_amcas` VALUES ('36', 'addresses', '35', '会员收货地址', '5', 'ctrl');
INSERT INTO `#@__user_amcas` VALUES ('37', 'members', '35', '会员账户', '3', 'ctrl');
INSERT INTO `#@__user_amcas` VALUES ('38', 'portal', '35', '会员管理', '2', 'ctrl');
INSERT INTO `#@__user_amcas` VALUES ('39', 'ranks', '35', '会员成长度', '1', 'ctrl');
INSERT INTO `#@__user_amcas` VALUES ('40', 'social', '35', '会员详情', '4', 'ctrl');
INSERT INTO `#@__user_amcas` VALUES ('41', 'types', '35', '会员类型', '0', 'ctrl');

INSERT INTO `#@__user_groups` VALUES ('1', 'Public', '0', '0', '', '公开组，未登录用户拥有该权限');
INSERT INTO `#@__user_groups` VALUES ('2', 'Guest', '1', '1', null, '普通会员');
INSERT INTO `#@__user_groups` VALUES ('3', 'Manager', '1', '2', null, '普通管理员');
INSERT INTO `#@__user_groups` VALUES ('4', 'Registered', '1', '3', 'YToxOntzOjEzOiJhZG1pbmlzdHJhdG9yIjthOjE6e3M6NToicG9zdHMiO2E6MTp7czo1OiJwb3N0cyI7YTo0OntpOjA7aToxO2k6MTtpOjI7aToyO2k6NDtpOjM7aTo4O319fX0=', '记名作者');
INSERT INTO `#@__user_groups` VALUES ('5', 'Super Users', '1', '4', null, '超级会员');
INSERT INTO `#@__user_groups` VALUES ('6', 'Administrator', '3', '1', 'YToxOntzOjEzOiJhZG1pbmlzdHJhdG9yIjthOjk6e3M6Njoic3lzdGVtIjthOjQ6e3M6Nzoib3B0aW9ucyI7YTo0OntpOjA7aToxO2k6MTtpOjI7aToyO2k6NDtpOjM7aTo4O31zOjg6InBpY3R1cmVzIjthOjQ6e2k6MDtpOjE7aToxO2k6MjtpOjI7aTo0O2k6MztpOjg7fXM6NDoic2l0ZSI7YTo0OntpOjA7aToxO2k6MTtpOjI7aToyO2k6NDtpOjM7aTo4O31zOjU6InRvb2xzIjthOjQ6e2k6MDtpOjE7aToxO2k6MjtpOjI7aTo0O2k6MztpOjg7fX1zOjU6InVzZXJzIjthOjQ6e3M6NzoiYWNjb3VudCI7YTo0OntpOjA7aToxO2k6MTtpOjI7aToyO2k6NDtpOjM7aTo4O31zOjU6ImFtY2FzIjthOjQ6e2k6MDtpOjE7aToxO2k6MjtpOjI7aTo0O2k6MztpOjg7fXM6NjoiZ3JvdXBzIjthOjQ6e2k6MDtpOjE7aToxO2k6MjtpOjI7aTo0O2k6MztpOjg7fXM6NToidXNlcnMiO2E6NDp7aTowO2k6MTtpOjE7aToyO2k6MjtpOjQ7aTozO2k6ODt9fXM6NzoiYnVpbGRlciI7YTo2OntzOjg6ImJ1aWxkZXJzIjthOjQ6e2k6MDtpOjE7aToxO2k6MjtpOjI7aTo0O2k6MztpOjg7fXM6NjoiZmllbGRzIjthOjQ6e2k6MDtpOjE7aToxO2k6MjtpOjI7aTo0O2k6MztpOjg7fXM6NjoiZ3JvdXBzIjthOjQ6e2k6MDtpOjE7aToxO2k6MjtpOjI7aTo0O2k6MztpOjg7fXM6ODoidGJsbmFtZXMiO2E6NDp7aTowO2k6MTtpOjE7aToyO2k6MjtpOjQ7aTozO2k6ODt9czo1OiJ0eXBlcyI7YTo0OntpOjA7aToxO2k6MTtpOjI7aToyO2k6NDtpOjM7aTo4O31zOjEwOiJ2YWxpZGF0b3JzIjthOjQ6e2k6MDtpOjE7aToxO2k6MjtpOjI7aTo0O2k6MztpOjg7fX1zOjU6InBvc3RzIjthOjQ6e3M6MTA6ImNhdGVnb3JpZXMiO2E6NDp7aTowO2k6MTtpOjE7aToyO2k6MjtpOjQ7aTozO2k6ODt9czo4OiJjb21tZW50cyI7YTo0OntpOjA7aToxO2k6MTtpOjI7aToyO2k6NDtpOjM7aTo4O31zOjc6Im1vZHVsZXMiO2E6NDp7aTowO2k6MTtpOjE7aToyO2k6MjtpOjQ7aTozO2k6ODt9czo1OiJwb3N0cyI7YTo0OntpOjA7aToxO2k6MTtpOjI7aToyO2k6NDtpOjM7aTo4O319czo1OiJtZW51cyI7YToyOntzOjU6Im1lbnVzIjthOjQ6e2k6MDtpOjE7aToxO2k6MjtpOjI7aTo0O2k6MztpOjg7fXM6NToidHlwZXMiO2E6NDp7aTowO2k6MTtpOjE7aToyO2k6MjtpOjQ7aTozO2k6ODt9fXM6NToidG9waWMiO2E6MTp7czo1OiJ0b3BpYyI7YTo0OntpOjA7aToxO2k6MTtpOjI7aToyO2k6NDtpOjM7aTo4O319czo2OiJhZHZlcnQiO2E6Mjp7czo3OiJhZHZlcnRzIjthOjQ6e2k6MDtpOjE7aToxO2k6MjtpOjI7aTo0O2k6MztpOjg7fXM6NToidHlwZXMiO2E6NDp7aTowO2k6MTtpOjE7aToyO2k6MjtpOjQ7aTozO2k6ODt9fXM6NDoicG9sbCI7YToyOntzOjExOiJwb2xsb3B0aW9ucyI7YTo0OntpOjA7aToxO2k6MTtpOjI7aToyO2k6NDtpOjM7aTo4O31zOjU6InBvbGxzIjthOjQ6e2k6MDtpOjE7aToxO2k6MjtpOjI7aTo0O2k6MztpOjg7fX1zOjY6Im1lbWJlciI7YTo2OntzOjk6ImFkZHJlc3NlcyI7YTo0OntpOjA7aToxO2k6MTtpOjI7aToyO2k6NDtpOjM7aTo4O31zOjU6InR5cGVzIjthOjQ6e2k6MDtpOjE7aToxO2k6MjtpOjI7aTo0O2k6MztpOjg7fXM6NToicmFua3MiO2E6NDp7aTowO2k6MTtpOjE7aToyO2k6MjtpOjQ7aTozO2k6ODt9czo2OiJwb3J0YWwiO2E6NDp7aTowO2k6MTtpOjE7aToyO2k6MjtpOjQ7aTozO2k6ODt9czo3OiJtZW1iZXJzIjthOjQ6e2k6MDtpOjE7aToxO2k6MjtpOjI7aTo0O2k6MztpOjg7fXM6Njoic29jaWFsIjthOjQ6e2k6MDtpOjE7aToxO2k6MjtpOjI7aTo0O2k6MztpOjg7fX19fQ==', '超级管理员');
INSERT INTO `#@__user_groups` VALUES ('7', 'Author', '4', '1', null, '普通作者');
INSERT INTO `#@__user_groups` VALUES ('8', 'Editor', '7', '1', null, '高级作者');
INSERT INTO `#@__user_groups` VALUES ('9', 'Publisher', '8', '1', null, '出版者');

INSERT INTO `#@__user_usergroups_map` VALUES ('1', '6');

INSERT INTO `#@__post_modules` VALUES (1, '文档模型', '_source|文档来源', 'n', '');
INSERT INTO `#@__post_modules` VALUES (2, '图集模型', '_source|图片来源\n_width|图片宽\n_height|图片高', 'n', '');
INSERT INTO `#@__post_modules` VALUES (3, '文件模型', '_os|运行环境\n_type|文件类型|如：.exe、.zip、.rar等\n_size|文件大小|如：3MB、100KB等', 'n', '');

INSERT INTO `#@__post_categories` VALUES ('1', '0', '文档类别', '', '文档', 'trotri,文档', '文档', 'home', 'index', 'view', '1', '');

INSERT INTO `#@__posts` VALUES ('1', '示例一', '', '示例一-内容 ...... 示例一-内容 ...... 示例一-内容 ......', '示例一-关键字', '示例一-描述', '1', '1', '文档类别', '1', '', '###baseurl###/static/images/test/example_200_150.jpg', 'y', 'y', 'n', '', 'y', '2014-11-05 14:23:39', '0000-00-00 00:00:00', 'publish', 'y', '0', '0', '0', '1', 'sys-example', '1', 'sys-example', '2014-11-05 14:24:32', '2014-11-05 14:36:25', '2130706433', '2130706433', 'n');
INSERT INTO `#@__posts` VALUES ('2', '示例二', '', '示例二-内容 ...... 示例二-内容 ...... 示例二-内容 ......', '示例二-关键字', '示例二-描述', '2', '1', '文档类别', '1', '', '###baseurl###/static/images/test/example_200_150.jpg', 'y', 'y', 'n', '', 'y', '2014-11-05 14:24:35', '0000-00-00 00:00:00', 'publish', 'y', '0', '0', '0', '1', 'sys-example', '1', 'sys-example', '2014-11-05 14:24:53', '2014-11-05 14:25:46', '2130706433', '2130706433', 'n');
INSERT INTO `#@__posts` VALUES ('3', '示例三', '', '示例三-内容 ...... 示例三-内容 ...... 示例三-内容 ......', '示例三-关键字', '示例三-描述', '3', '1', '文档类别', '1', '', '###baseurl###/static/images/test/example_200_150.jpg', 'y', 'y', 'n', '', 'y', '2014-11-05 14:24:55', '0000-00-00 00:00:00', 'publish', 'y', '0', '0', '0', '1', 'sys-example', '1', 'sys-example', '2014-11-05 14:25:09', '2014-11-05 14:25:46', '2130706433', '2130706433', 'n');
INSERT INTO `#@__posts` VALUES ('4', '示例四', '', '示例四-内容 ...... 示例四-内容 ...... 示例四-内容 ......', '示例四-关键字', '示例四-描述', '4', '1', '文档类别', '1', '', '###baseurl###/static/images/test/example_200_150.jpg', 'y', 'y', 'n', '', 'y', '2014-11-05 14:25:11', '0000-00-00 00:00:00', 'publish', 'y', '0', '0', '0', '1', 'sys-example', '1', 'sys-example', '2014-11-05 14:25:23', '2014-11-05 14:25:47', '2130706433', '2130706433', 'n');

INSERT INTO `#@__advert_types` VALUES ('1', '首页幻灯片广告', 'mainslide', 'navbar', '');
INSERT INTO `#@__advert_types` VALUES ('2', '公告', 'notice', 'notice', '');
INSERT INTO `#@__advert_types` VALUES ('3', '友情链接', 'friendlinks', 'block', '');

INSERT INTO `#@__adverts` VALUES ('1', 'first', 'mainslide', '', 'y', '2014-11-05 14:05:50', '0000-00-00 00:00:00', '1', 'image', '<a target=\"_blank\" href=\"#\"><img src=\"###baseurl###/static/images/test/slide_first.jpg\" alt=\"first\" /></a>', '', '#', '###baseurl###/static/images/test/slide_first.jpg', '', 'first', '0', '0', '', '_blank', '2014-11-05 14:07:00');
INSERT INTO `#@__adverts` VALUES ('2', 'second', 'mainslide', '', 'y', '2014-11-05 14:07:02', '0000-00-00 00:00:00', '2', 'image', '<a target=\"_blank\" href=\"#\"><img src=\"###baseurl###/static/images/test/slide_second.jpg\" alt=\"second\" /></a>', '', '#', '###baseurl###/static/images/test/slide_second.jpg', '', 'second', '0', '0', '', '_blank', '2014-11-05 14:07:30');
INSERT INTO `#@__adverts` VALUES ('3', 'third', 'mainslide', '', 'y', '2014-11-05 14:07:31', '0000-00-00 00:00:00', '3', 'image', '<a target=\"_blank\" href=\"#\"><img src=\"###baseurl###/static/images/test/slide_third.jpg\" alt=\"third\" /></a>', '', '#', '###baseurl###/static/images/test/slide_third.jpg', '', 'third', '0', '0', '', '_blank', '2014-11-05 14:07:54');
INSERT INTO `#@__adverts` VALUES ('4', '网站公告', 'notice', '', 'y', '2014-11-05 14:08:42', '0000-00-00 00:00:00', '1', 'code', '网站公告 ...... 网站公告 ...... 网站公告 ...... 网站公告 ...... 网站公告 ...... 网站公告 ...... ', '', '', '', '', '', '0', '0', '', '_blank', '2014-11-05 14:09:13');
INSERT INTO `#@__adverts` VALUES ('5', 'GitHub', 'friendlinks', '', 'y', '2014-11-05 14:30:11', '0000-00-00 00:00:00', '1', 'text', '<a target=\"_blank\" href=\"http://www.github.com/\">GitHub</a>', 'GitHub', 'http://www.github.com/', '', '', '', '0', '0', '', '_blank', '2014-11-05 14:30:41');
INSERT INTO `#@__adverts` VALUES ('6', 'Bootcss', 'friendlinks', '', 'y', '2014-11-05 14:30:43', '0000-00-00 00:00:00', '2', 'text', '<a target=\"_blank\" href=\"http://www.bootcss.com/\">Bootstrap</a>', 'Bootstrap', 'http://www.bootcss.com/', '', '', '', '0', '0', '', '_blank', '2014-11-05 14:31:14');
INSERT INTO `#@__adverts` VALUES ('7', 'Trotri', 'friendlinks', '', 'y', '2014-11-05 14:31:17', '0000-00-00 00:00:00', '3', 'text', '<a target=\"_blank\" href=\"http://www.trotri.com/\">Trotri</a>', 'Trotri', 'http://www.trotri.com/', '', '', '', '0', '0', '', '_blank', '2014-11-05 14:31:37');

INSERT INTO `#@__topic` VALUES ('1', '示例', 'example', '###baseurl###/static/images/test/example_728_318.jpg', '示例', '示例,专题', '示例专题', '', '', '', '<div class=\"container\">\r\n  <div class=\"blog-header\"></div>\r\n  <div class=\"row\">\r\n示例专题 ...... 示例专题 ...... 示例专题 ...... 示例专题 ...... 示例专题 ...... 示例专题 ......\r\n  </div><!-- /.row -->\r\n</div><!-- /.container -->', 'y', 'y', 'y', '1', '2014-11-05 14:17:44');

INSERT INTO `#@__polls` VALUES ('1', '您是从哪里了解到我们网站的？', 'knowmysite', 'n', '', 'forever', '0', 'y', '2014-12-26 16:58:30', '0000-00-00 00:00:00', 'y', 'n', '0', '', '', '2014-12-18 17:59:17');
INSERT INTO `#@__polloptions` VALUES ('1', '搜索引擎', '1', '8', '1');
INSERT INTO `#@__polloptions` VALUES ('2', '朋友介绍', '1', '4', '2');
INSERT INTO `#@__polloptions` VALUES ('3', '代码托管网站', '1', '5', '3');
INSERT INTO `#@__polloptions` VALUES ('4', '其他', '1', '6', '4');

INSERT INTO `#@__member_types` VALUES ('1', '普通会员', '1', '');
INSERT INTO `#@__member_types` VALUES ('2', '专家达人', '2', '');

INSERT INTO `#@__member_ranks` VALUES ('1', '注册会员', '0', '1', '');
INSERT INTO `#@__member_ranks` VALUES ('2', '铜牌会员', '1', '2', '');
INSERT INTO `#@__member_ranks` VALUES ('3', '银牌会员', '2000', '3', '');
INSERT INTO `#@__member_ranks` VALUES ('4', '金牌会员', '10000', '4', '');
INSERT INTO `#@__member_ranks` VALUES ('5', '钻石会员', '30000', '5', '');
