/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : trotri

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2014-10-27 18:39:43
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tr_builders`
-- ----------------------------
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='生成代码表';

-- ----------------------------
-- Records of tr_builders
-- ----------------------------
INSERT INTO `tr_builders` VALUES ('1', '模型管理', 'post_modules', 'n', 'InnoDB', 'utf8', '文档模型表', 'normal', 'posts', 'administrator', 'posts', 'modules', 'modules', '', 'index', 'view', 'create', 'modify', 'remove', 'pencil,remove', '', '宋欢', 'trotri@yeah.net', '2014-10-12 17:03:09', '2014-10-12 17:10:41', 'n');
INSERT INTO `tr_builders` VALUES ('2', '类别管理', 'post_categories', 'n', 'InnoDB', 'utf8', '文档类别表', 'normal', 'posts', 'administrator', 'posts', 'categories', 'categories', '', 'index', 'view', 'create', 'modify', 'remove', 'pencil,remove', '', '宋欢', 'trotri@yeah.net', '2014-10-13 19:07:10', '2014-10-13 19:08:35', 'n');
INSERT INTO `tr_builders` VALUES ('3', '文档管理', 'posts', 'n', 'InnoDB', 'utf8', '文档管理表', 'normal', 'posts', 'administrator', 'posts', 'posts', 'posts', '', 'index', 'view', 'create', 'modify', 'remove', 'pencil,trash,remove', '', '宋欢', 'trotri@yeah.net', '2014-10-15 16:23:10', '2014-10-15 16:49:40', 'n');
INSERT INTO `tr_builders` VALUES ('4', '菜单类型', 'menu_types', 'n', 'InnoDB', 'utf8', '菜单类型表', 'normal', 'menus', 'administrator', 'menus', 'types', 'types', '', 'index', 'view', 'create', 'modify', 'remove', 'pencil,remove', '', '宋欢', 'trotri@yeah.net', '2014-10-22 08:25:33', '2014-10-22 09:56:22', 'n');
INSERT INTO `tr_builders` VALUES ('5', '菜单管理', 'menus', 'n', 'InnoDB', 'utf8', '菜单表', 'normal', 'menus', 'administrator', 'menus', 'menus', 'menus', 'type_key', 'index', 'view', 'create', 'modify', 'remove', 'pencil,remove', '', '宋欢', 'trotri@yeah.net', '2014-10-22 11:47:06', '2014-10-22 11:49:15', 'n');
INSERT INTO `tr_builders` VALUES ('6', '广告位置', 'advert_types', 'n', 'InnoDB', 'utf8', '广告位置表', 'normal', 'advert', 'administrator', 'advert', 'types', 'types', '', 'index', 'view', 'create', 'modify', 'remove', 'pencil,remove', '', '宋欢', 'trotri@yeah.net', '2014-10-23 19:31:40', '2014-10-23 19:33:23', 'n');
INSERT INTO `tr_builders` VALUES ('7', '广告管理', 'adverts', 'n', 'InnoDB', 'utf8', '广告表', 'normal', 'advert', 'administrator', 'advert', 'adverts', 'adverts', 'type_key', 'index', 'view', 'create', 'modify', 'remove', 'pencil,remove', '', '宋欢', 'trotri@yeah.net', '2014-10-25 10:16:57', '2014-10-26 19:04:12', 'n');

-- ----------------------------
-- Table structure for `tr_builder_fields`
-- ----------------------------
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
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8 COMMENT='表单字段表';

-- ----------------------------
-- Records of tr_builder_fields
-- ----------------------------
INSERT INTO `tr_builder_fields` VALUES ('1', 'module_id', '5', 'y', 'y', '主键ID', '1', '1', '9', '1', '主键ID', '', 'n', 'n', 'y', '1000', 'n', '1', 'n', '1', 'y', '1');
INSERT INTO `tr_builder_fields` VALUES ('2', 'module_name', '50', 'n', 'n', '模型名称', '1', '1', '1', '2', '模型名称', '模型名称由2~50个字符组成.', 'y', 'n', 'y', '2', 'y', '2', 'y', '2', 'y', '2');
INSERT INTO `tr_builder_fields` VALUES ('3', 'fields', '', 'n', 'n', '文档扩展字段', '1', '1', '10', '3', '文档扩展字段', '', 'n', 'n', 'n', '3', 'y', '7', 'y', '7', 'n', '3');
INSERT INTO `tr_builder_fields` VALUES ('4', 'forbidden', 'y|n', 'n', 'n', '是否禁用', '1', '1', '4', '4', '是否禁用', '', 'n', 'n', 'y', '4', 'y', '4', 'y', '4', 'y', '4');
INSERT INTO `tr_builder_fields` VALUES ('5', 'description', '', 'n', 'n', '描述', '1', '1', '10', '5', '描述', '', 'n', 'n', 'y', '5', 'y', '5', 'y', '5', 'n', '5');
INSERT INTO `tr_builder_fields` VALUES ('6', 'category_id', '5', 'y', 'y', '主键ID', '2', '1', '9', '1', 'ID', '', 'n', 'n', 'y', '1000', 'n', '1', 'n', '1', 'y', '1');
INSERT INTO `tr_builder_fields` VALUES ('7', 'category_pid', '5', 'n', 'y', '父类别ID', '2', '1', '7', '3', '所属父类别', '', 'y', 'n', 'y', '3', 'y', '3', 'y', '3', 'y', '3');
INSERT INTO `tr_builder_fields` VALUES ('8', 'category_name', '50', 'n', 'n', '类别名', '2', '1', '1', '2', '类别名', '类别名由2~20个字符组成.', 'y', 'n', 'y', '2', 'y', '2', 'y', '2', 'y', '2');
INSERT INTO `tr_builder_fields` VALUES ('9', 'alias', '250', 'n', 'n', '别名', '2', '1', '10', '4', '别名', '别名由0~120个字符组成.', 'y', 'n', 'y', '4', 'y', '4', 'y', '4', 'y', '4');
INSERT INTO `tr_builder_fields` VALUES ('10', 'meta_title', '100', 'n', 'n', 'SEO标题', '2', '1', '1', '5', 'SEO标题', 'SEO标题由2~50个字符组成.', 'y', 'n', 'y', '5', 'y', '5', 'y', '5', 'y', '5');
INSERT INTO `tr_builder_fields` VALUES ('11', 'meta_keywords', '100', 'n', 'n', 'SEO关键字', '2', '1', '1', '6', 'SEO关键字', 'SEO关键字由2~50个字符组成.', 'y', 'n', 'y', '6', 'y', '6', 'y', '6', 'y', '6');
INSERT INTO `tr_builder_fields` VALUES ('12', 'meta_description', '250', 'n', 'n', 'SEO描述', '2', '1', '10', '7', 'SEO描述', 'SEO描述由2~120个字符组成.', 'y', 'n', 'y', '7', 'y', '7', 'y', '7', 'y', '7');
INSERT INTO `tr_builder_fields` VALUES ('13', 'tpl_home', '100', 'n', 'n', '封页模板名', '2', '1', '1', '8', '封页模板名', '封页模板名由1~50个英文字母、数字或下划线组成.', 'y', 'n', 'y', '8', 'y', '8', 'y', '8', 'y', '8');
INSERT INTO `tr_builder_fields` VALUES ('14', 'tpl_list', '100', 'n', 'n', '列表模板名', '2', '1', '1', '9', '列表模板名', '列表模板名由1~50个英文字母、数字或下划线组成.', 'y', 'n', 'y', '9', 'y', '9', 'y', '9', 'y', '9');
INSERT INTO `tr_builder_fields` VALUES ('15', 'tpl_view', '100', 'n', 'n', '文档模板名', '2', '1', '1', '10', '文档模板名', '文档模板名由1~50个英文字母、数字或下划线组成.', 'y', 'n', 'y', '10', 'y', '10', 'y', '10', 'y', '10');
INSERT INTO `tr_builder_fields` VALUES ('16', 'sort', '8', 'n', 'y', '排序', '2', '1', '2', '11', '排序', '排序由正整数组成且数字越小位置越靠前.', 'y', 'n', 'y', '11', 'y', '11', 'y', '11', 'y', '11');
INSERT INTO `tr_builder_fields` VALUES ('17', 'description', '', 'n', 'n', '描述', '2', '1', '10', '12', '描述', '', 'n', 'n', 'n', '12', 'y', '12', 'y', '12', 'n', '12');
INSERT INTO `tr_builder_fields` VALUES ('18', 'post_id', '10', 'y', 'y', '主键ID', '3', '1', '9', '1', 'ID', '', 'n', 'n', 'y', '1000', 'n', '1', 'n', '1', 'y', '1');
INSERT INTO `tr_builder_fields` VALUES ('19', 'title', '100', 'n', 'n', '文档标题', '3', '1', '1', '2', '文档标题', '文档标题由1~50个字符组成.', 'y', 'n', 'y', '2', 'y', '2', 'y', '2', 'y', '2');
INSERT INTO `tr_builder_fields` VALUES ('20', 'alias', '255', 'n', 'n', '别名', '3', '1', '6', '3', '别名', '别名由0~120个字符组成.', 'y', 'n', 'y', '3', 'y', '3', 'y', '3', 'y', '3');
INSERT INTO `tr_builder_fields` VALUES ('21', 'content', '', 'n', 'n', '文档内容', '3', '1', '10', '4', '内容', '', 'n', 'n', 'n', '4', 'y', '4', 'y', '4', 'n', '4');
INSERT INTO `tr_builder_fields` VALUES ('22', 'keywords', '100', 'n', 'n', '内容关键字', '3', '1', '1', '5', '关键字', '关键字由0~50个字符组成，由英文逗号分隔.', 'n', 'n', 'n', '5', 'y', '5', 'y', '5', 'y', '5');
INSERT INTO `tr_builder_fields` VALUES ('23', 'description', '512', 'n', 'n', '内容摘要', '3', '1', '10', '6', '内容摘要', '内容摘要由0~240个字符组成.', 'n', 'n', 'n', '6', 'y', '6', 'y', '6', 'n', '6');
INSERT INTO `tr_builder_fields` VALUES ('24', 'sort', '10', 'n', 'y', '排序', '3', '2', '2', '7', '排序', '排序由正整数组成且数字越小位置越靠前.', 'y', 'n', 'y', '7', 'y', '7', 'y', '7', 'y', '7');
INSERT INTO `tr_builder_fields` VALUES ('25', 'category_id', '5', 'n', 'y', '所属类别ID', '3', '1', '7', '8', '所属类别', '', 'n', 'n', 'y', '8', 'y', '8', 'y', '8', 'y', '8');
INSERT INTO `tr_builder_fields` VALUES ('26', 'category_name', '50', 'n', 'n', '类别名', '3', '1', '8', '9', '类别名', '', 'n', 'n', 'n', '9', 'n', '9', 'n', '9', 'n', '9');
INSERT INTO `tr_builder_fields` VALUES ('27', 'module_id', '5', 'n', 'y', '模型ID', '3', '3', '7', '10', '所属模型', '', 'n', 'n', 'y', '10', 'y', '10', 'y', '10', 'y', '10');
INSERT INTO `tr_builder_fields` VALUES ('28', 'password', '20', 'n', 'n', '访问密码', '3', '2', '1', '11', '访问密码', '访问密码由0~20个英文字母、数字或下划线组成，置空表示不设置密码.', 'n', 'n', 'n', '11', 'y', '11', 'y', '11', 'n', '11');
INSERT INTO `tr_builder_fields` VALUES ('29', 'picture', '255', 'n', 'n', '主图地址', '3', '1', '8', '12', '主图地址', '', 'n', 'n', 'n', '12', 'y', '12', 'y', '12', 'n', '12');
INSERT INTO `tr_builder_fields` VALUES ('30', 'is_head', 'y|n', 'n', 'n', '是否头条', '3', '2', '4', '13', '是否头条', '', 'n', 'n', 'y', '13', 'y', '13', 'y', '13', 'y', '13');
INSERT INTO `tr_builder_fields` VALUES ('31', 'is_recommend', 'y|n', 'n', 'n', '是否推荐', '3', '2', '4', '14', '是否推荐', '', 'n', 'n', 'y', '14', 'y', '14', 'y', '14', 'y', '14');
INSERT INTO `tr_builder_fields` VALUES ('32', 'is_jump', 'y|n', 'n', 'n', '是否跳转', '3', '2', '4', '15', '是否跳转', '', 'n', 'n', 'n', '15', 'y', '15', 'y', '15', 'y', '15');
INSERT INTO `tr_builder_fields` VALUES ('33', 'jump_url', '255', 'n', 'n', '跳转链接', '3', '2', '1', '16', '跳转链接', '可用来跳转到其他链接.', 'y', 'n', 'n', '16', 'y', '16', 'y', '16', 'n', '16');
INSERT INTO `tr_builder_fields` VALUES ('34', 'is_published', 'y|n', 'n', 'n', '是否发表，y：开放浏览、n：草稿或待审核', '3', '1', '4', '17', '是否发表', '', 'n', 'n', 'y', '17', 'y', '17', 'y', '17', 'y', '17');
INSERT INTO `tr_builder_fields` VALUES ('35', 'dt_publish_up', '', 'n', 'n', '开始发表时间', '3', '2', '1', '18', '开始发表时间', '', 'y', 'n', 'y', '18', 'y', '18', 'y', '18', 'y', '18');
INSERT INTO `tr_builder_fields` VALUES ('36', 'dt_publish_down', '', 'n', 'n', '结束发表时间', '3', '2', '1', '19', '结束发表时间', '', 'y', 'n', 'y', '19', 'y', '19', 'y', '19', 'y', '19');
INSERT INTO `tr_builder_fields` VALUES ('37', 'comment_status', 'publish|draft|forbidden', 'n', 'n', '评论设置，publish：开放浏览、draft：审核后展示、forbidden：禁止评论', '3', '2', '5', '20', '评论设置', '', 'n', 'n', 'n', '20', 'y', '20', 'y', '20', 'n', '20');
INSERT INTO `tr_builder_fields` VALUES ('38', 'allow_other_modify', 'y|n', 'n', 'n', '是否允许其他人编辑', '3', '2', '4', '21', '允许其他人编辑', '', 'n', 'n', 'y', '21', 'y', '21', 'y', '21', 'y', '21');
INSERT INTO `tr_builder_fields` VALUES ('39', 'hits', '20', 'n', 'y', '访问次数', '3', '4', '2', '22', '访问次数', '访问次数由非负数组成.', 'y', 'n', 'y', '22', 'y', '22', 'y', '22', 'y', '22');
INSERT INTO `tr_builder_fields` VALUES ('40', 'creator_id', '10', 'n', 'y', '创建人ID', '3', '4', '9', '23', '创建人ID', '', 'n', 'n', 'n', '23', 'y', '23', 'y', '23', 'y', '23');
INSERT INTO `tr_builder_fields` VALUES ('41', 'creator_name', '100', 'n', 'n', '创建人', '3', '4', '1', '24', '创建人', '', 'n', 'y', 'y', '24', 'y', '24', 'y', '24', 'y', '24');
INSERT INTO `tr_builder_fields` VALUES ('42', 'last_modifier_id', '10', 'n', 'y', '上次编辑人ID', '3', '4', '9', '25', '上次编辑人ID', '', 'n', 'n', 'n', '25', 'y', '25', 'y', '25', 'y', '25');
INSERT INTO `tr_builder_fields` VALUES ('43', 'last_modifier_name', '100', 'n', 'n', '上次编辑人', '3', '4', '1', '26', '上次编辑人', '', 'n', 'y', 'y', '26', 'y', '26', 'y', '26', 'y', '26');
INSERT INTO `tr_builder_fields` VALUES ('44', 'dt_created', '', 'n', 'n', '创建时间', '3', '4', '1', '27', '创建时间', '', 'n', 'y', 'y', '27', 'y', '27', 'y', '27', 'y', '27');
INSERT INTO `tr_builder_fields` VALUES ('45', 'dt_last_modified', '', 'n', 'n', '上次编辑时间', '3', '4', '1', '28', '上次编辑时间', '', 'n', 'y', 'y', '28', 'y', '28', 'y', '28', 'y', '28');
INSERT INTO `tr_builder_fields` VALUES ('46', 'ip_created', '10', 'n', 'y', '创建IP', '3', '4', '1', '29', '创建IP', '', 'n', 'y', 'y', '29', 'y', '29', 'y', '29', 'y', '29');
INSERT INTO `tr_builder_fields` VALUES ('47', 'ip_last_modified', '10', 'n', 'y', '上次编辑IP', '3', '4', '1', '30', '上次编辑IP', '', 'n', 'y', 'y', '30', 'y', '30', 'y', '30', 'y', '30');
INSERT INTO `tr_builder_fields` VALUES ('48', 'trash', 'y|n', 'n', 'n', '是否删除', '3', '1', '4', '31', '是否删除', '', 'n', 'n', 'y', '31', 'n', '31', 'n', '31', 'y', '31');
INSERT INTO `tr_builder_fields` VALUES ('49', 'praise_count', '20', 'n', 'y', '赞美次数', '3', '4', '2', '22', '赞美次数', '赞美次数由非负数组成.', 'y', 'n', 'y', '22', 'y', '22', 'y', '22', 'y', '22');
INSERT INTO `tr_builder_fields` VALUES ('50', 'comment_count', '20', 'n', 'y', '评论次数', '3', '4', '2', '22', '评论次数', '评论次数由非负数组成.', 'y', 'n', 'y', '22', 'y', '22', 'y', '22', 'y', '22');
INSERT INTO `tr_builder_fields` VALUES ('51', 'type_id', '5', 'y', 'y', '主键ID', '4', '1', '9', '1', 'ID', '', 'n', 'n', 'y', '1000', 'n', '1', 'n', '1', 'y', '1');
INSERT INTO `tr_builder_fields` VALUES ('52', 'type_key', '24', 'n', 'n', '类型Key', '4', '1', '1', '3', '类型Key', '类型Key由2~20个英文字母、数字或下划线组成.', 'y', 'n', 'y', '3', 'y', '3', 'y', '3', 'y', '3');
INSERT INTO `tr_builder_fields` VALUES ('53', 'type_name', '100', 'n', 'n', '类型名', '4', '1', '1', '2', '类型名', '类型名由2~50个字符组成.', 'y', 'n', 'y', '2', 'y', '2', 'y', '2', 'y', '2');
INSERT INTO `tr_builder_fields` VALUES ('54', 'description', '512', 'n', 'n', '描述', '4', '1', '10', '4', '描述', '', 'y', 'n', 'y', '4', 'y', '4', 'y', '4', 'y', '4');
INSERT INTO `tr_builder_fields` VALUES ('55', 'menu_id', '10', 'y', 'y', '主键ID', '5', '1', '9', '1', 'ID', '', 'n', 'n', 'y', '1000', 'n', '1', 'n', '1', 'y', '1');
INSERT INTO `tr_builder_fields` VALUES ('56', 'menu_pid', '10', 'n', 'y', '父菜单ID', '5', '1', '7', '3', '父菜单ID', '', 'n', 'n', 'y', '3', 'y', '3', 'y', '3', 'y', '3');
INSERT INTO `tr_builder_fields` VALUES ('57', 'menu_name', '255', 'n', 'n', '菜单名', '5', '1', '1', '2', '菜单名', '菜单名由1~100个字符组成.', 'y', 'n', 'y', '2', 'y', '2', 'y', '2', 'y', '2');
INSERT INTO `tr_builder_fields` VALUES ('58', 'menu_url', '1024', 'n', 'n', '菜单链接', '5', '1', '10', '4', '菜单链接', '', 'y', 'n', 'y', '4', 'y', '4', 'y', '4', 'y', '4');
INSERT INTO `tr_builder_fields` VALUES ('59', 'type_key', '24', 'n', 'n', '所属类型Key', '5', '1', '7', '5', '类型Key', '', 'n', 'n', 'y', '5', 'y', '5', 'y', '5', 'y', '5');
INSERT INTO `tr_builder_fields` VALUES ('60', 'picture', '255', 'n', 'n', '图片链接', '5', '1', '10', '6', '图片链接', '', 'y', 'n', 'y', '6', 'y', '6', 'y', '6', 'y', '6');
INSERT INTO `tr_builder_fields` VALUES ('61', 'alias', '255', 'n', 'n', '别名', '5', '1', '1', '7', '别名', '别名由0~100个字符组成.', 'n', 'n', 'y', '7', 'y', '7', 'y', '7', 'y', '7');
INSERT INTO `tr_builder_fields` VALUES ('62', 'description', '512', 'n', 'n', '描述', '5', '1', '10', '8', '描述', '', 'n', 'n', 'y', '8', 'y', '8', 'y', '8', 'y', '8');
INSERT INTO `tr_builder_fields` VALUES ('63', 'allow_unregistered', 'y|n', 'n', 'n', '是否允许非会员访问', '5', '5', '4', '9', '允许非会员访问', '', 'n', 'n', 'y', '9', 'y', '9', 'y', '9', 'y', '9');
INSERT INTO `tr_builder_fields` VALUES ('64', 'is_hide', 'y|n', 'n', 'n', '是否隐藏', '5', '1', '4', '10', '是否隐藏', '', 'n', 'n', 'y', '10', 'y', '10', 'y', '10', 'y', '10');
INSERT INTO `tr_builder_fields` VALUES ('65', 'sort', '10', 'n', 'y', '排序', '5', '1', '2', '11', '排序', '排序由正整数组成且数字越小位置越靠前.', 'y', 'n', 'y', '11', 'y', '11', 'y', '11', 'y', '11');
INSERT INTO `tr_builder_fields` VALUES ('66', 'attr_target', '255', 'n', 'n', 'Target属性', '5', '5', '1', '12', 'Target属性', '规定在何处打开链接文档，如：_blank、_self、_parent、_top或指定的框架窗口.', 'n', 'n', 'y', '12', 'y', '12', 'y', '12', 'y', '12');
INSERT INTO `tr_builder_fields` VALUES ('67', 'attr_title', '255', 'n', 'n', 'Title属性', '5', '5', '1', '13', 'Title属性', 'A标签的额外信息.', 'n', 'n', 'y', '13', 'y', '13', 'y', '13', 'y', '13');
INSERT INTO `tr_builder_fields` VALUES ('68', 'attr_rel', '255', 'n', 'n', 'Rel属性', '5', '5', '1', '14', 'Rel属性', '当前文档与被链接文档的关系，如：alternate、stylesheet、start、next、prev等.', 'n', 'n', 'y', '14', 'y', '14', 'y', '14', 'y', '14');
INSERT INTO `tr_builder_fields` VALUES ('69', 'attr_class', '255', 'n', 'n', 'CSS-class名', '5', '5', '1', '15', 'Class名', '', 'n', 'n', 'y', '15', 'y', '15', 'y', '15', 'y', '15');
INSERT INTO `tr_builder_fields` VALUES ('70', 'attr_style', '255', 'n', 'n', 'CSS-style属性', '5', '5', '1', '16', 'CSS-style属性', '', 'n', 'n', 'y', '16', 'y', '16', 'y', '16', 'y', '16');
INSERT INTO `tr_builder_fields` VALUES ('71', 'dt_created', '', 'n', 'n', '创建时间', '5', '6', '1', '17', '创建时间', '', 'n', 'y', 'y', '17', 'y', '17', 'y', '17', 'y', '17');
INSERT INTO `tr_builder_fields` VALUES ('72', 'dt_last_modified', '', 'n', 'n', '上次编辑时间', '5', '6', '1', '18', '上次编辑时间', '', 'n', 'y', 'y', '18', 'y', '18', 'y', '18', 'y', '18');
INSERT INTO `tr_builder_fields` VALUES ('73', 'type_id', '5', 'y', 'y', '主键ID', '6', '1', '9', '1', 'ID', '', 'n', 'n', 'y', '1000', 'n', '1', 'n', '1', 'y', '1');
INSERT INTO `tr_builder_fields` VALUES ('74', 'type_name', '100', 'n', 'n', '位置名', '6', '1', '1', '2', '位置名', '位置名由2~50个字符组成.', 'y', 'n', 'y', '2', 'y', '2', 'y', '2', 'y', '2');
INSERT INTO `tr_builder_fields` VALUES ('75', 'type_key', '24', 'n', 'n', '位置Key', '6', '1', '1', '3', '位置Key', '位置Key由2~20个英文字母、数字或下划线组成.', 'y', 'n', 'y', '3', 'y', '3', 'y', '3', 'y', '3');
INSERT INTO `tr_builder_fields` VALUES ('76', 'picture', 'header|footer|banner|banner_higher|navbar|navs|sides|notice|block|block_float|list|list_higher|list_side|views|view_left|view_right|default', 'n', 'n', '示例图片', '6', '1', '5', '4', '示例图片', '', 'y', 'n', 'y', '4', 'y', '4', 'y', '4', 'y', '4');
INSERT INTO `tr_builder_fields` VALUES ('77', 'description', '512', 'n', 'n', '描述', '6', '1', '10', '5', '描述', '', 'y', 'n', 'y', '5', 'y', '5', 'y', '5', 'y', '5');
INSERT INTO `tr_builder_fields` VALUES ('78', 'advert_id', '10', 'y', 'y', '主键ID', '7', '1', '9', '1', 'ID', '', 'n', 'n', 'y', '1000', 'n', '1', 'n', '1', 'y', '1');
INSERT INTO `tr_builder_fields` VALUES ('79', 'advert_name', '255', 'n', 'n', '广告名', '7', '1', '1', '2', '广告名', '广告名由1~100个字符组成.', 'y', 'n', 'y', '2', 'y', '2', 'y', '2', 'y', '2');
INSERT INTO `tr_builder_fields` VALUES ('80', 'type_key', '24', 'n', 'n', '位置Key', '7', '1', '1', '3', '位置Key', '', 'y', 'n', 'y', '3', 'y', '3', 'y', '3', 'y', '3');
INSERT INTO `tr_builder_fields` VALUES ('81', 'description', '512', 'n', 'n', '描述', '7', '1', '10', '4', '描述', '', 'n', 'n', 'y', '4', 'y', '4', 'y', '4', 'y', '4');
INSERT INTO `tr_builder_fields` VALUES ('82', 'is_published', 'y|n', 'n', 'n', '是否发表，y：开放浏览、n：草稿', '7', '1', '4', '5', '是否发表', '', 'n', 'n', 'y', '5', 'y', '5', 'y', '5', 'y', '5');
INSERT INTO `tr_builder_fields` VALUES ('83', 'dt_publish_up', '', 'n', 'n', '开始发表时间', '7', '1', '1', '6', '开始发表时间', '', 'n', 'n', 'y', '6', 'y', '6', 'y', '6', 'y', '6');
INSERT INTO `tr_builder_fields` VALUES ('84', 'dt_publish_down', '', 'n', 'n', '结束发表时间，0000-00-00 00:00:00：永不过期', '7', '1', '1', '7', '结束发表时间', '置空表示永不过期.', 'n', 'n', 'y', '7', 'y', '7', 'y', '7', 'y', '7');
INSERT INTO `tr_builder_fields` VALUES ('85', 'sort', '10', 'n', 'y', '排序', '7', '1', '2', '8', '排序', '排序由正整数组成且数字越小位置越靠前.', 'y', 'n', 'y', '8', 'y', '8', 'y', '8', 'y', '8');
INSERT INTO `tr_builder_fields` VALUES ('86', 'show_type', 'code|text|image|flash', 'n', 'n', '展现方式，code：代码、text：文字、image：图片、flash：Flash', '7', '7', '5', '9', '展现方式', '', 'n', 'n', 'y', '9', 'y', '9', 'y', '9', 'y', '9');
INSERT INTO `tr_builder_fields` VALUES ('87', 'show_code', '', 'n', 'n', '展现代码', '7', '7', '10', '10', '展现代码', '请输入需要展现广告的HTML代码.', 'y', 'n', 'y', '10', 'y', '10', 'y', '10', 'y', '10');
INSERT INTO `tr_builder_fields` VALUES ('88', 'title', '255', 'n', 'n', '文字内容', '7', '7', '1', '11', '文字内容', '请输入文字广告的显示内容.', 'y', 'n', 'y', '11', 'y', '11', 'y', '11', 'y', '11');
INSERT INTO `tr_builder_fields` VALUES ('89', 'advert_url', '1024', 'n', 'n', '广告链接', '7', '7', '10', '12', '广告链接', '广告的URL链接地址，站外的地址必须以http://开头.', 'y', 'n', 'y', '12', 'y', '12', 'y', '12', 'y', '12');
INSERT INTO `tr_builder_fields` VALUES ('90', 'advert_src', '255', 'n', 'n', '图片|Flash链接', '7', '7', '1', '13', '图片|Flash链接', '请输入图片|Flash广告的调用地址.', 'y', 'n', 'y', '13', 'y', '13', 'y', '13', 'y', '13');
INSERT INTO `tr_builder_fields` VALUES ('91', 'advert_src2', '255', 'n', 'n', '辅图链接', '7', '7', '1', '14', '辅图链接', '请输入广告辅图的调用地址.', 'n', 'n', 'y', '14', 'y', '14', 'y', '14', 'y', '14');
INSERT INTO `tr_builder_fields` VALUES ('92', 'attr_alt', '255', 'n', 'n', '图片替换文字', '7', '7', '1', '15', '图片替换文字', '', 'y', 'n', 'y', '15', 'y', '15', 'y', '15', 'y', '15');
INSERT INTO `tr_builder_fields` VALUES ('93', 'attr_width', '5', 'n', 'y', '图片|Flash-宽度，单位：px', '7', '7', '2', '16', '图片|Flash宽度', '单位：px，置0表示不设置宽度.', 'n', 'n', 'y', '16', 'y', '16', 'y', '16', 'y', '16');
INSERT INTO `tr_builder_fields` VALUES ('94', 'attr_height', '5', 'n', 'y', '图片|Flash-高度，单位：px', '7', '7', '2', '17', '图片|Flash高度', '单位：px，置0表示不设置高度.', 'n', 'n', 'y', '17', 'y', '17', 'y', '17', 'y', '17');
INSERT INTO `tr_builder_fields` VALUES ('95', 'attr_fontsize', '100', 'n', 'n', '文字大小，单位：pt、px、em', '7', '7', '1', '18', '文字大小', '单位：pt、px、em', 'n', 'n', 'y', '18', 'y', '18', 'y', '18', 'y', '18');
INSERT INTO `tr_builder_fields` VALUES ('96', 'attr_target', '100', 'n', 'n', 'Target属性，如：_blank、_self、_parent、_top等', '7', '7', '1', '19', 'Target属性', '规定在何处打开链接文档，如：_blank、_self、_parent、_top或指定的框架窗口.', 'n', 'n', 'y', '19', 'y', '19', 'y', '19', 'y', '19');
INSERT INTO `tr_builder_fields` VALUES ('97', 'dt_created', '', 'n', 'n', '创建时间', '7', '8', '1', '20', '创建时间', '', 'n', 'y', 'y', '20', 'y', '20', 'y', '20', 'y', '20');

-- ----------------------------
-- Table structure for `tr_builder_field_groups`
-- ----------------------------
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='表单字段组表';

-- ----------------------------
-- Records of tr_builder_field_groups
-- ----------------------------
INSERT INTO `tr_builder_field_groups` VALUES ('1', 'main', '主要信息', '0', '1', '默认');
INSERT INTO `tr_builder_field_groups` VALUES ('2', 'advanced', '高级参数', '3', '2', '');
INSERT INTO `tr_builder_field_groups` VALUES ('3', 'profile', '扩展信息', '3', '3', '');
INSERT INTO `tr_builder_field_groups` VALUES ('4', 'system', '系统信息', '3', '4', '');
INSERT INTO `tr_builder_field_groups` VALUES ('5', 'advanced', '高级参数', '5', '2', '');
INSERT INTO `tr_builder_field_groups` VALUES ('6', 'system', '系统信息', '5', '3', '');
INSERT INTO `tr_builder_field_groups` VALUES ('7', 'advanced', '高级参数', '7', '2', '');
INSERT INTO `tr_builder_field_groups` VALUES ('8', 'system', '系统信息', '7', '3', '');

-- ----------------------------
-- Table structure for `tr_builder_field_validators`
-- ----------------------------
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
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8 COMMENT='表单字段验证表';

-- ----------------------------
-- Records of tr_builder_field_validators
-- ----------------------------
INSERT INTO `tr_builder_field_validators` VALUES ('1', 'MinLength', '2', '2', 'integer', '模型名称长度不能小于%option%个字符.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('2', 'MaxLength', '2', '50', 'integer', '模型名称长度不能大于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('3', 'InArray', '4', '', 'array', '必须选择是否禁用，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('4', 'InArray', '7', '', 'array', '必须选择所属父类别，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('5', 'MinLength', '8', '2', 'integer', '类别名长度不能小于%option%个字符.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('6', 'MaxLength', '8', '20', 'integer', '类别名长度不能大于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('8', 'MaxLength', '9', '120', 'integer', '别名长度不能大于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('9', 'MinLength', '10', '2', 'integer', 'SEO标题长度不能小于%option%个字符.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('10', 'MaxLength', '10', '50', 'integer', 'SEO标题长度不能大于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('11', 'MinLength', '11', '2', 'integer', 'SEO关键字长度不能小于%option%个字符.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('12', 'MaxLength', '11', '50', 'integer', 'SEO关键字长度不能大于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('13', 'MinLength', '12', '2', 'integer', 'SEO描述长度不能小于%option%个字符.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('14', 'MaxLength', '12', '120', 'integer', 'SEO描述长度不能大于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('15', 'AlphaNum', '13', '', 'boolean', '封页模板名只能由英文字母、数字或下划线组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('16', 'MinLength', '13', '1', 'integer', '封页模板名长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('17', 'MaxLength', '13', '50', 'integer', '封页模板名长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('18', 'AlphaNum', '14', '', 'boolean', '列表模板名只能由英文字母、数字或下划线组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('19', 'MinLength', '14', '1', 'integer', '列表模板名长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('20', 'MaxLength', '14', '50', 'integer', '列表模板名长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('21', 'AlphaNum', '15', '', 'boolean', '文档模板名只能由英文字母、数字或下划线组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('22', 'MinLength', '15', '1', 'integer', '文档模板名长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('23', 'MaxLength', '15', '50', 'integer', '文档模板名长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('25', 'Integer', '16', '', 'boolean', '排序只能是数字并且大于0.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('26', 'MinLength', '19', '1', 'integer', '文档标题长度不能小于%option%个字符.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('27', 'MaxLength', '19', '50', 'integer', '文档标题长度不能大于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('28', 'MaxLength', '20', '120', 'integer', '别名长度不能大于%option%个字符.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('29', 'MaxLength', '22', '50', 'integer', '关键字长度不能大于%option%个字符.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('30', 'MaxLength', '23', '240', 'integer', '内容摘要长度不能大于%option%个字符.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('31', 'Integer', '24', '', 'boolean', '排序只能是数字并且大于0.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('32', 'InArray', '25', '', 'array', '必须选择所属类别，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('33', 'InArray', '27', '', 'array', '必须选择所属模型，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('34', 'MaxLength', '28', '20', 'integer', '访问密码长度不能大于%option%个字符.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('35', 'InArray', '30', '', 'array', '必须选择是否头条，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('36', 'InArray', '31', '', 'array', '必须选择是否推荐，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('37', 'InArray', '32', '', 'array', '必须选择是否跳转，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('38', 'Url', '33', '', 'boolean', 'URL格式不正确.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('39', 'InArray', '34', '', 'array', '必须选择是否发表，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('40', 'DateTime', '35', '', 'boolean', '日期时间格式不正确.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('41', 'DateTime', '36', '', 'boolean', '日期时间格式不正确.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('42', 'InArray', '37', '', 'array', '必须选择评论设置，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('43', 'InArray', '38', '', 'array', '必须选择允许其他人编辑，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('44', 'NonNegativeInteger', '39', '', 'boolean', '访问次数只能是非负数.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('45', 'InArray', '40', '', 'array', '必须选择创建人ID，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('46', 'InArray', '42', '', 'array', '必须选择上次编辑人ID，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('47', 'DateTime', '44', '', 'boolean', '日期时间格式不正确.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('48', 'DateTime', '45', '', 'boolean', '日期时间格式不正确.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('49', 'InArray', '48', '', 'array', '必须选择是否删除，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('50', 'NotEmpty', '33', '', 'boolean', '必须填写跳转链接.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('51', 'NonNegativeInteger', '49', '', 'boolean', '赞美次数只能是非负数.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('52', 'NonNegativeInteger', '50', '', 'boolean', '评论次数只能是非负数.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('53', 'MinLength', '52', '2', 'integer', '类型Key长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('54', 'MaxLength', '52', '20', 'integer', '类型Key长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('55', 'InArray', '52', '', 'array', '必须选择类型Key，值只能是%s.', '4', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('56', 'MinLength', '53', '2', 'integer', '类型名长度不能小于%option%个字符.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('57', 'MaxLength', '53', '50', 'integer', '类型名长度不能大于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('58', 'AlphaNum', '52', '', 'boolean', '类型Key只能由英文字母、数字或下划线组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('59', 'InArray', '56', '', 'array', '必须选择父菜单ID，值只能是%s.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('60', 'MinLength', '57', '1', 'integer', '菜单名长度不能小于%option%个字符.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('61', 'MaxLength', '57', '100', 'integer', '菜单名长度不能大于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('62', 'InArray', '59', '', 'array', '必须选择所属类型Key，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('63', 'MaxLength', '61', '100', 'integer', '别名长度不能大于%option%个字符.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('64', 'InArray', '63', '', 'array', '必须选择允许非会员访问，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('65', 'InArray', '64', '', 'array', '必须选择是否隐藏，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('66', 'Integer', '65', '', 'boolean', '排序只能是数字并且大于0.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('67', 'Equal', '56', '', 'integer', '父菜单ID.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('68', 'NotEmpty', '58', '', 'boolean', '必须填写菜单链接.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('69', 'MinLength', '74', '2', 'integer', '位置名长度不能小于%option%个字符.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('70', 'MaxLength', '74', '50', 'integer', '位置名长度不能大于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('71', 'AlphaNum', '75', '', 'boolean', '位置Key只能由英文字母、数字或下划线组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('72', 'MinLength', '75', '2', 'integer', '位置Key长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('73', 'MaxLength', '75', '20', 'integer', '位置Key长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('74', 'InArray', '75', '', 'array', '必须选择位置Key，值只能是%s.', '4', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('75', 'InArray', '76', '', 'array', '必须选择示例图片，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('76', 'MinLength', '79', '1', 'integer', '广告名长度不能小于%option%个字符.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('77', 'MaxLength', '79', '100', 'integer', '广告名长度不能大于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('78', 'InArray', '80', '', 'array', '必须选择位置Key，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('79', 'InArray', '82', '', 'array', '必须选择是否发表，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('80', 'DateTime', '83', '', 'boolean', '日期时间格式不正确.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('81', 'DateTime', '84', '', 'boolean', '日期时间格式不正确.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('82', 'Integer', '85', '', 'boolean', '排序只能是数字并且大于0.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('83', 'InArray', '86', '', 'array', '必须选择展现方式，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('84', 'NotEmpty', '87', '', 'boolean', '必须填写展现代码.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('85', 'NotEmpty', '88', '', 'boolean', '必须填写文字内容.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('86', 'NotEmpty', '89', '', 'boolean', '必须填写广告链接.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('87', 'NotEmpty', '90', '', 'boolean', '必须填写图片|Flash链接.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('89', 'NotEmpty', '92', '', 'boolean', '必须填写图片替换文字.', '1', 'all');

-- ----------------------------
-- Table structure for `tr_builder_types`
-- ----------------------------
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='表单字段类型表';

-- ----------------------------
-- Records of tr_builder_types
-- ----------------------------
INSERT INTO `tr_builder_types` VALUES ('1', '单行文本(VARCHAR)', 'text', 'VARCHAR', 'text', '1');
INSERT INTO `tr_builder_types` VALUES ('2', '单行文本(INT)', 'text', 'INT', 'text', '2');
INSERT INTO `tr_builder_types` VALUES ('3', '密码', 'password', 'CHAR', 'text', '3');
INSERT INTO `tr_builder_types` VALUES ('4', '开关选项卡', 'switch', 'ENUM', 'option', '4');
INSERT INTO `tr_builder_types` VALUES ('5', '单选', 'radio', 'ENUM', 'option', '5');
INSERT INTO `tr_builder_types` VALUES ('6', '多选', 'checkbox', 'VARCHAR', 'option', '6');
INSERT INTO `tr_builder_types` VALUES ('7', '单选下拉框', 'select', 'INT', 'option', '7');
INSERT INTO `tr_builder_types` VALUES ('8', '隐藏文本框(VARCHAR)', 'hidden', 'VARCHAR', 'text', '8');
INSERT INTO `tr_builder_types` VALUES ('9', '隐藏文本框(INT)', 'hidden', 'INT', 'text', '9');
INSERT INTO `tr_builder_types` VALUES ('10', '多行文本', 'textarea', 'TEXT', 'text', '10');
INSERT INTO `tr_builder_types` VALUES ('11', '上传文件', 'file', 'VARCHAR', 'text', '11');
