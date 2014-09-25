/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : builder_data_backup

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2014-09-18 00:03:27
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='生成代码表';

-- ----------------------------
-- Records of tr_builders
-- ----------------------------
INSERT INTO `tr_builders` VALUES ('1', '表单字段类型', 'builder_types', 'n', 'InnoDB', 'utf8', '表单字段类型表', 'dynamic', 'builders', 'programmer', 'builder', 'types', 'types', '', 'index', 'view', 'create', 'modify', 'remove', 'pencil,remove', '', '宋欢', 'trotri@yeah.net', '2014-05-23 13:31:46', '2014-05-26 15:23:37', 'n');
INSERT INTO `tr_builders` VALUES ('2', '生成代码', 'builders', 'n', 'InnoDB', 'utf8', '生成代码表', 'dynamic', 'builders', 'programmer', 'builder', 'builders', 'builders', '', 'index', 'view', 'create', 'modify', 'remove', 'pencil,remove', '', '宋欢', 'trotri@yeah.net', '2014-05-26 15:23:50', '0000-00-00 00:00:00', 'n');
INSERT INTO `tr_builders` VALUES ('3', '字段组', 'builder_field_groups', 'n', 'InnoDB', 'utf8', '表单字段组表', 'dynamic', 'builders', 'programmer', 'builder', 'groups', 'groups', 'builder_id', 'index', 'view', 'create', 'modify', 'remove', '', '', '宋欢', 'trotri@yeah.net', '2014-05-26 15:57:26', '2014-05-27 17:51:04', 'n');
INSERT INTO `tr_builders` VALUES ('4', '表单字段', 'builder_fields', 'n', 'InnoDB', 'utf8', '表单字段表', 'dynamic', 'builders', 'programmer', 'builder', 'fields', 'fields', 'builder_id', 'index', 'view', 'create', 'modify', 'remove', 'pencil,remove', '', '宋欢', 'trotri@yeah.net', '2014-05-27 13:06:21', '0000-00-00 00:00:00', 'n');
INSERT INTO `tr_builders` VALUES ('5', '表单字段验证', 'builder_field_validators', 'n', 'InnoDB', 'utf8', '表单字段验证表', 'dynamic', 'builders', 'programmer', 'builder', 'validators', 'validators', 'field_id', 'index', 'view', 'create', 'modify', 'remove', 'pencil,remove', '', '宋欢', 'trotri@yeah.net', '2014-05-27 13:06:30', '0000-00-00 00:00:00', 'n');
INSERT INTO `tr_builders` VALUES ('6', '用户可访问的事件', 'user_amcas', 'n', 'InnoDB', 'utf8', '用户可访问的事件表', 'normal', 'users', 'passport', 'users', 'amcas', 'amcas', 'amca_pid', 'index', 'view', 'create', 'modify', 'remove', 'pencil,trash,remove', '', '宋欢', 'trotri@yeah.net', '2014-05-28 16:28:14', '2014-05-29 13:30:25', 'n');
INSERT INTO `tr_builders` VALUES ('7', '用户组', 'user_groups', 'n', 'InnoDB', 'utf8', '用户分组表', 'normal', 'users', 'passport', 'users', 'groups', 'groups', 'group_pid', 'index', 'view', 'create', 'modify', 'remove', 'pencil,remove', '', '宋欢', 'trotri@yeah.net', '2014-05-29 17:33:12', '2014-05-29 17:37:54', 'n');
INSERT INTO `tr_builders` VALUES ('8', '用户和用户组关联表', 'user_usergroups_map', 'n', 'InnoDB', 'utf8', '用户和用户组关联表', 'normal', 'users', 'passport', 'users', 'usergroups', 'usergroups', '', 'index', 'view', 'create', 'modify', 'remove', 'pencil,remove', '', '宋欢', 'trotri@yeah.net', '2014-08-06 15:28:31', '2014-08-06 17:51:18', 'n');
INSERT INTO `tr_builders` VALUES ('9', '用户管理', 'users', 'n', 'InnoDB', 'utf8', '用户主表', 'normal', 'users', 'passport', 'users', 'users', 'users', '', 'index', 'view', 'create', 'modify', 'remove', 'pencil,remove', '', '宋欢', 'trotri@yeah.net', '2014-08-06 17:48:57', '2014-08-06 17:50:51', 'n');
INSERT INTO `tr_builders` VALUES ('10', '站点配置', 'system_options', 'n', 'InnoDB', 'utf8', '站点配置表', 'normal', 'system', 'passport', 'system', 'options', 'options', '', 'index', 'view', 'create', 'modify', 'remove', 'pencil', '', '宋欢', 'trotri@yeah.net', '2014-08-14 23:25:14', '2014-08-16 22:34:05', 'n');
INSERT INTO `tr_builders` VALUES ('12', '模型管理', 'post_modules', 'n', 'InnoDB', 'utf8', '文档类别模型表', 'normal', 'posts', 'administrator', 'posts', 'modules', 'modules', '', 'index', 'view', 'create', 'modify', 'remove', 'pencil,remove', '', '宋欢', 'trotri@yeah.net', '2014-09-11 15:28:08', '2014-09-12 13:59:09', 'n');
INSERT INTO `tr_builders` VALUES ('13', '类别管理', 'post_categories', 'n', 'InnoDB', 'utf8', '文档类别表', 'normal', 'posts', 'administrator', 'posts', 'categories', 'categories', '', 'index', 'view', 'create', 'modify', 'remove', 'pencil,remove', '', '宋欢', 'trotri@yeah.net', '2014-09-12 13:59:16', '2014-09-12 15:27:13', 'n');
INSERT INTO `tr_builders` VALUES ('14', '文档管理', 'posts', 'n', 'InnoDB', 'utf8', '系统自带的文档管理表', 'normal', 'posts', 'administrator', 'posts', 'posts', 'posts', '', 'index', 'view', 'create', 'modify', 'remove', 'pencil,trash,remove', '', '宋欢', 'trotri@yeah.net', '2014-09-15 11:13:14', '2014-09-15 11:20:55', 'n');

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
) ENGINE=InnoDB AUTO_INCREMENT=203 DEFAULT CHARSET=utf8 COMMENT='表单字段表';

-- ----------------------------
-- Records of tr_builder_fields
-- ----------------------------
INSERT INTO `tr_builder_fields` VALUES ('1', 'type_id', '5', 'y', 'y', '主键ID', '1', '1', '9', '1', '主键ID', '', 'n', 'n', 'y', '1000', 'n', '1', 'n', '1', 'y', '1');
INSERT INTO `tr_builder_fields` VALUES ('2', 'type_name', '100', 'n', 'n', '类型名', '1', '1', '1', '2', '类型名', '类型名由2~50个字符组成.', 'y', 'n', 'y', '2', 'y', '2', 'y', '2', 'y', '2');
INSERT INTO `tr_builder_fields` VALUES ('3', 'form_type', '100', 'n', 'n', '表单类型名', '1', '1', '1', '3', '表单类型名', '表单类型名由2~12个英文字母组成.', 'y', 'n', 'y', '3', 'y', '3', 'y', '3', 'y', '3');
INSERT INTO `tr_builder_fields` VALUES ('4', 'field_type', '100', 'n', 'n', '表字段类型', '1', '1', '1', '4', '表字段类型', '表字段类型由2~12个英文字母组成.', 'y', 'n', 'y', '4', 'y', '4', 'y', '4', 'y', '4');
INSERT INTO `tr_builder_fields` VALUES ('5', 'category', 'text|option|button', 'n', 'n', '所属分类', '1', '1', '5', '5', '所属分类', '', 'n', 'n', 'y', '5', 'y', '5', 'y', '5', 'y', '5');
INSERT INTO `tr_builder_fields` VALUES ('6', 'sort', '5', 'n', 'y', '排序', '1', '1', '2', '6', '排序', '排序由数字组成且数字越小位置越靠前.', 'y', 'n', 'y', '6', 'y', '6', 'y', '6', 'y', '6');
INSERT INTO `tr_builder_fields` VALUES ('7', 'builder_id', '5', 'y', 'y', '主键ID', '2', '1', '9', '1', 'ID', '', 'n', 'n', 'y', '1000', 'n', '1', 'n', '1', 'y', '1');
INSERT INTO `tr_builder_fields` VALUES ('8', 'builder_name', '100', 'n', 'n', '生成代码名', '2', '1', '1', '2', '生成代码名', '生成代码名由6~50个字符组成.', 'y', 'n', 'y', '2', 'y', '2', 'y', '2', 'y', '2');
INSERT INTO `tr_builder_fields` VALUES ('9', 'tbl_name', '100', 'n', 'n', '表名', '2', '1', '1', '3', '表名', '表名由2~30个英文字母、数字或下划线组成.', 'y', 'n', 'y', '3', 'y', '3', 'y', '3', 'y', '3');
INSERT INTO `tr_builder_fields` VALUES ('10', 'tbl_profile', 'y|n', 'n', 'n', '是否生成扩展表', '2', '1', '4', '4', '是否生成扩展表', '', 'n', 'n', 'y', '4', 'y', '4', 'y', '4', 'y', '4');
INSERT INTO `tr_builder_fields` VALUES ('11', 'tbl_engine', 'MyISAM|InnoDB', 'n', 'n', '表引擎', '2', '1', '5', '5', '表引擎', '', 'n', 'n', 'y', '5', 'y', '5', 'y', '5', 'y', '5');
INSERT INTO `tr_builder_fields` VALUES ('12', 'tbl_charset', 'utf8|gbk|gb2312', 'n', 'n', '表编码', '2', '1', '5', '6', '表编码', '', 'n', 'n', 'y', '6', 'y', '6', 'y', '6', 'y', '6');
INSERT INTO `tr_builder_fields` VALUES ('13', 'tbl_comment', '200', 'n', 'n', '表描述', '2', '1', '1', '7', '表描述', '', 'y', 'n', 'n', '7', 'y', '7', 'y', '7', 'y', '7');
INSERT INTO `tr_builder_fields` VALUES ('14', 'srv_type', 'dynamic|normal', 'n', 'n', '代码类型，自动构建代码和SQL：dynamic、普通：normal', '2', '1', '5', '8', '代码类型', '', 'n', 'n', 'n', '8', 'y', '8', 'y', '8', 'y', '8');
INSERT INTO `tr_builder_fields` VALUES ('15', 'srv_name', '100', 'n', 'n', '业务名', '2', '1', '1', '9', '业务名', '业务名由2~50个英文字母组成.', 'y', 'n', 'n', '9', 'y', '9', 'y', '9', 'y', '9');
INSERT INTO `tr_builder_fields` VALUES ('16', 'app_name', '100', 'n', 'n', '应用名', '2', '1', '1', '10', '应用名', '应用名由2~50个英文字母组成.', 'y', 'n', 'y', '10', 'y', '10', 'y', '10', 'y', '10');
INSERT INTO `tr_builder_fields` VALUES ('17', 'mod_name', '100', 'n', 'n', '模块名', '2', '1', '1', '11', '模块名', '模块名由2~50个英文字母组成.', 'y', 'n', 'y', '11', 'y', '11', 'y', '11', 'y', '11');
INSERT INTO `tr_builder_fields` VALUES ('18', 'cls_name', '100', 'n', 'n', '类名', '2', '1', '1', '12', '类名', '类名由2~12个英文字母组成.', 'y', 'n', 'y', '12', 'y', '12', 'y', '12', 'y', '12');
INSERT INTO `tr_builder_fields` VALUES ('19', 'ctrl_name', '100', 'n', 'n', '控制器名', '2', '1', '1', '13', '控制器名', '控制器名由2~12个英文字母组成.', 'y', 'n', 'y', '13', 'y', '13', 'y', '13', 'y', '13');
INSERT INTO `tr_builder_fields` VALUES ('20', 'fk_column', '100', 'n', 'n', '外联其他表的字段名', '2', '1', '1', '14', '外联其他表的字段名', '外联其他表的字段名由2~50个英文字母、数字或下划线组成.', 'n', 'n', 'n', '14', 'y', '14', 'y', '14', 'y', '14');
INSERT INTO `tr_builder_fields` VALUES ('21', 'act_index_name', '100', 'n', 'n', '行动名-数据列表', '2', '2', '1', '15', '数据列表行动名', '数据列表行动名由2~12个英文字母组成.', 'y', 'n', 'n', '15', 'y', '15', 'y', '15', 'y', '15');
INSERT INTO `tr_builder_fields` VALUES ('22', 'act_view_name', '100', 'n', 'n', '行动名-数据详情', '2', '2', '1', '16', '数据详情行动名', '数据详情行动名由2~12个英文字母组成.', 'y', 'n', 'n', '16', 'y', '16', 'y', '16', 'y', '16');
INSERT INTO `tr_builder_fields` VALUES ('23', 'act_create_name', '100', 'n', 'n', '行动名-新增数据', '2', '2', '1', '17', '新增数据行动名', '新增数据行动名由2~12个英文字母组成.', 'y', 'n', 'n', '17', 'y', '17', 'y', '17', 'y', '17');
INSERT INTO `tr_builder_fields` VALUES ('24', 'act_modify_name', '100', 'n', 'n', '行动名-编辑数据', '2', '2', '1', '18', '编辑数据行动名', '编辑数据行动名由2~12个英文字母组成.', 'y', 'n', 'n', '18', 'y', '18', 'y', '18', 'y', '18');
INSERT INTO `tr_builder_fields` VALUES ('25', 'act_remove_name', '100', 'n', 'n', '行动名-删除数据', '2', '2', '1', '19', '删除数据行动名', '删除数据行动名由2~12个英文字母组成.', 'y', 'n', 'n', '19', 'y', '19', 'y', '19', 'y', '19');
INSERT INTO `tr_builder_fields` VALUES ('26', 'index_row_btns', '100', 'n', 'n', '数据列表每行操作Btn，编辑：pencil、移至回收站：trash、彻底删除：remove', '2', '1', '6', '20', '数据列表每行操作Btn', '', 'n', 'n', 'n', '20', 'y', '20', 'y', '20', 'y', '20');
INSERT INTO `tr_builder_fields` VALUES ('27', 'description', '', 'n', 'n', '描述', '2', '1', '10', '21', '描述', '', 'n', 'n', 'n', '21', 'y', '21', 'y', '21', 'y', '21');
INSERT INTO `tr_builder_fields` VALUES ('28', 'author_name', '100', 'n', 'n', '作者姓名，代码注释用', '2', '1', '1', '22', '作者姓名，代码注释用', '作者姓名，代码注释用由2~50个字符组成.', 'y', 'n', 'n', '22', 'y', '22', 'y', '22', 'y', '22');
INSERT INTO `tr_builder_fields` VALUES ('29', 'author_mail', '100', 'n', 'n', '作者邮箱，代码注释用', '2', '1', '1', '23', '作者邮箱，代码注释用', '作者邮箱，代码注释用由2~50个字符组成.', 'y', 'n', 'n', '23', 'y', '23', 'y', '23', 'y', '23');
INSERT INTO `tr_builder_fields` VALUES ('30', 'dt_created', '', 'n', 'n', '创建时间', '2', '3', '1', '24', '创建时间', '', 'n', 'y', 'n', '24', 'y', '24', 'y', '24', 'y', '24');
INSERT INTO `tr_builder_fields` VALUES ('31', 'dt_modified', '', 'n', 'n', '上次编辑时间', '2', '3', '1', '25', '上次编辑时间', '', 'n', 'y', 'n', '25', 'y', '25', 'y', '25', 'y', '25');
INSERT INTO `tr_builder_fields` VALUES ('32', 'trash', 'y|n', 'n', 'n', '是否删除', '2', '1', '4', '26', '移至回收站', '', 'n', 'n', 'n', '26', 'n', '26', 'n', '26', 'y', '26');
INSERT INTO `tr_builder_fields` VALUES ('33', 'group_id', '5', 'y', 'y', '主键ID', '3', '1', '9', '1', 'ID', '', 'n', 'n', 'y', '1000', 'n', '1', 'n', '1', 'y', '1');
INSERT INTO `tr_builder_fields` VALUES ('34', 'group_name', '100', 'n', 'n', '组名', '3', '1', '1', '2', '组名', '组名由2~12个英文字母组成.', 'y', 'n', 'y', '2', 'y', '2', 'y', '2', 'y', '2');
INSERT INTO `tr_builder_fields` VALUES ('35', 'prompt', '100', 'n', 'n', '提示', '3', '1', '1', '3', '提示', '提示由2~12个字符组成.', 'y', 'n', 'y', '3', 'y', '3', 'y', '3', 'y', '3');
INSERT INTO `tr_builder_fields` VALUES ('36', 'builder_id', '5', 'n', 'y', '生成代码ID', '3', '1', '2', '4', '生成代码ID', '', 'y', 'n', 'y', '4', 'y', '4', 'y', '4', 'y', '4');
INSERT INTO `tr_builder_fields` VALUES ('37', 'sort', '5', 'n', 'y', '排序', '3', '1', '2', '5', '排序', '排序由数字组成且数字越小位置越靠前.', 'y', 'n', 'y', '5', 'y', '5', 'y', '5', 'y', '5');
INSERT INTO `tr_builder_fields` VALUES ('38', 'description', '', 'n', 'n', '描述', '3', '1', '10', '6', '描述', '', 'n', 'n', 'y', '6', 'y', '6', 'y', '6', 'y', '6');
INSERT INTO `tr_builder_fields` VALUES ('39', 'field_id', '10', 'y', 'y', '主键ID', '4', '1', '9', '1', 'ID', '', 'n', 'n', 'y', '1000', 'n', '1', 'n', '1', 'y', '1');
INSERT INTO `tr_builder_fields` VALUES ('40', 'field_name', '100', 'n', 'n', '字段名', '4', '1', '1', '2', '字段名', '字段名由2~50个英文字母、数字或下划线组成.', 'y', 'n', 'y', '2', 'y', '2', 'y', '2', 'y', '2');
INSERT INTO `tr_builder_fields` VALUES ('41', 'column_length', '200', 'n', 'n', 'DB字段长度或用|分隔开的Enum值', '4', '1', '1', '3', 'DB字段长度或用|分隔开的Enum值', '', 'n', 'n', 'n', '3', 'y', '3', 'y', '3', 'y', '3');
INSERT INTO `tr_builder_fields` VALUES ('42', 'column_auto_increment', 'y|n', 'n', 'n', '是否自动递增', '4', '1', '4', '4', '是否自动递增', '', 'n', 'n', 'n', '4', 'y', '4', 'y', '4', 'y', '4');
INSERT INTO `tr_builder_fields` VALUES ('43', 'column_unsigned', 'y|n', 'n', 'n', '是否无符号', '4', '1', '4', '5', '是否无符号', '', 'n', 'n', 'n', '5', 'y', '5', 'y', '5', 'y', '5');
INSERT INTO `tr_builder_fields` VALUES ('44', 'column_comment', '200', 'n', 'n', 'DB字段描述', '4', '1', '1', '6', 'DB字段描述', '', 'y', 'n', 'n', '6', 'y', '6', 'y', '6', 'y', '6');
INSERT INTO `tr_builder_fields` VALUES ('45', 'builder_id', '5', 'n', 'y', '生成代码ID', '4', '1', '9', '7', '生成代码ID', '', 'n', 'n', 'y', '7', 'y', '7', 'y', '7', 'y', '7');
INSERT INTO `tr_builder_fields` VALUES ('46', 'group_id', '10', 'n', 'y', '表单字段组ID', '4', '1', '7', '8', '表单字段组ID', '', 'n', 'n', 'y', '8', 'y', '8', 'y', '8', 'y', '8');
INSERT INTO `tr_builder_fields` VALUES ('47', 'type_id', '5', 'n', 'y', '字段类型ID', '4', '1', '7', '9', '字段类型ID', '', 'n', 'n', 'y', '9', 'y', '9', 'y', '9', 'y', '9');
INSERT INTO `tr_builder_fields` VALUES ('48', 'sort', '5', 'n', 'y', '排序', '4', '1', '2', '10', '排序', '排序由数字组成且数字越小位置越靠前.', 'y', 'n', 'y', '10', 'y', '10', 'y', '10', 'y', '10');
INSERT INTO `tr_builder_fields` VALUES ('49', 'html_label', '100', 'n', 'n', 'HTML：Table和Form显示名', '4', '4', '1', '11', 'Table和Form显示名', '', 'y', 'n', 'y', '11', 'y', '11', 'y', '11', 'y', '11');
INSERT INTO `tr_builder_fields` VALUES ('50', 'form_prompt', '200', 'n', 'n', '表单提示', '4', '4', '1', '12', '表单提示', '', 'y', 'n', 'n', '12', 'y', '12', 'y', '12', 'y', '12');
INSERT INTO `tr_builder_fields` VALUES ('51', 'form_required', 'y|n', 'n', 'n', '表单是否必填', '4', '4', '4', '13', '表单是否必填', '', 'n', 'n', 'n', '13', 'y', '13', 'y', '13', 'y', '13');
INSERT INTO `tr_builder_fields` VALUES ('52', 'form_modifiable', 'y|n', 'n', 'n', '编辑表单中允许输入', '4', '4', '4', '14', '编辑表单是否中允许输入', '', 'n', 'n', 'n', '14', 'y', '14', 'y', '14', 'y', '14');
INSERT INTO `tr_builder_fields` VALUES ('53', 'index_show', 'y|n', 'n', 'n', '是否在列表中展示', '4', '4', '4', '15', '是否在列表中展示', '', 'n', 'n', 'n', '15', 'y', '15', 'y', '15', 'y', '15');
INSERT INTO `tr_builder_fields` VALUES ('54', 'index_sort', '5', 'n', 'y', '在列表中排序', '4', '4', '2', '16', '在列表中排序', '', 'y', 'n', 'n', '16', 'y', '16', 'y', '16', 'y', '16');
INSERT INTO `tr_builder_fields` VALUES ('55', 'form_create_show', 'y|n', 'n', 'n', '是否在新增表单中展示', '4', '4', '4', '17', '是否在新增表单中展示', '', 'n', 'n', 'n', '17', 'y', '17', 'y', '17', 'y', '17');
INSERT INTO `tr_builder_fields` VALUES ('56', 'form_create_sort', '5', 'n', 'y', '在新增表单中排序', '4', '4', '2', '18', '在新增表单中排序', '', 'y', 'n', 'n', '18', 'y', '18', 'y', '18', 'y', '18');
INSERT INTO `tr_builder_fields` VALUES ('57', 'form_modify_show', 'y|n', 'n', 'n', '是否在编辑表单中展示', '4', '4', '4', '19', '是否在编辑表单中展示', '', 'n', 'n', 'n', '19', 'y', '19', 'y', '19', 'y', '19');
INSERT INTO `tr_builder_fields` VALUES ('58', 'form_modify_sort', '5', 'n', 'y', '在编辑表单中排序', '4', '4', '2', '20', '在编辑表单中排序', '', 'y', 'n', 'n', '20', 'y', '20', 'y', '20', 'y', '20');
INSERT INTO `tr_builder_fields` VALUES ('59', 'form_search_show', 'y|n', 'n', 'n', '是否在查询表单中展示', '4', '4', '4', '21', '是否在查询表单中展示', '', 'n', 'n', 'n', '21', 'y', '21', 'y', '21', 'y', '21');
INSERT INTO `tr_builder_fields` VALUES ('60', 'form_search_sort', '5', 'n', 'y', '在查询表单中排序', '4', '4', '2', '22', '在查询表单中排序', '', 'n', 'n', 'y', '22', 'y', '22', 'y', '22', 'y', '22');
INSERT INTO `tr_builder_fields` VALUES ('61', 'validator_id', '10', 'y', 'y', '主键ID', '5', '1', '9', '1', 'ID', '', 'n', 'n', 'y', '1000', 'n', '1', 'n', '1', 'y', '1');
INSERT INTO `tr_builder_fields` VALUES ('62', 'validator_name', '100', 'n', 'n', '验证类名', '5', '1', '7', '2', '验证类名', '验证类名由2~50个字符组成.', 'n', 'n', 'y', '2', 'y', '2', 'y', '2', 'y', '2');
INSERT INTO `tr_builder_fields` VALUES ('63', 'field_id', '10', 'n', 'y', '表单字段ID', '5', '1', '9', '3', '表单字段ID', '', 'n', 'n', 'y', '3', 'y', '3', 'y', '3', 'y', '3');
INSERT INTO `tr_builder_fields` VALUES ('64', 'options', '100', 'n', 'n', '验证时对比值，可以是布尔类型、整型、字符型、数组序列化', '5', '1', '1', '4', '验证时对比值', '', 'n', 'n', 'y', '4', 'y', '4', 'y', '4', 'y', '4');
INSERT INTO `tr_builder_fields` VALUES ('65', 'option_category', 'boolean|integer|string|array', 'n', 'n', '验证时对比值类型', '5', '1', '5', '5', '验证时对比值类型', '', 'n', 'n', 'y', '5', 'y', '5', 'y', '5', 'y', '5');
INSERT INTO `tr_builder_fields` VALUES ('66', 'message', '100', 'n', 'n', '出错提示消息', '5', '1', '1', '6', '出错提示消息', '', 'n', 'n', 'y', '6', 'y', '6', 'y', '6', 'y', '6');
INSERT INTO `tr_builder_fields` VALUES ('67', 'sort', '5', 'n', 'y', '排序', '5', '1', '2', '7', '排序', '排序由数字组成且数字越小位置越靠前.', 'y', 'n', 'y', '7', 'y', '7', 'y', '7', 'y', '7');
INSERT INTO `tr_builder_fields` VALUES ('68', 'when', 'all|create|modify', 'n', 'n', '验证环境，任意时候验证、只在新增数据时验证、只在编辑数据时验证', '5', '1', '5', '8', '验证环境', '', 'n', 'n', 'y', '8', 'y', '8', 'y', '8', 'y', '8');
INSERT INTO `tr_builder_fields` VALUES ('69', 'amca_id', '5', 'y', 'y', '主键ID', '6', '1', '9', '1', 'ID', '', 'n', 'n', 'y', '1000', 'n', '1', 'n', '1', 'y', '1');
INSERT INTO `tr_builder_fields` VALUES ('70', 'amca_pid', '5', 'n', 'y', '父ID', '6', '1', '2', '3', '父ID', '', 'y', 'n', 'y', '2', 'y', '2', 'y', '2', 'y', '2');
INSERT INTO `tr_builder_fields` VALUES ('71', 'amca_name', '100', 'n', 'n', '事件名', '6', '1', '1', '2', '事件名', '事件名由2~16个英文字母组成.', 'y', 'n', 'y', '3', 'y', '3', 'y', '3', 'y', '3');
INSERT INTO `tr_builder_fields` VALUES ('72', 'prompt', '100', 'n', 'n', '提示', '6', '1', '1', '4', '提示', '提示由2~50个字符组成.', 'y', 'n', 'y', '4', 'y', '4', 'y', '4', 'y', '4');
INSERT INTO `tr_builder_fields` VALUES ('73', 'sort', '5', 'n', 'y', '排序', '6', '1', '2', '5', '排序', '排序由数字组成且数字越小位置越靠前.', 'y', 'n', 'y', '5', 'y', '5', 'y', '5', 'y', '5');
INSERT INTO `tr_builder_fields` VALUES ('74', 'category', 'app|mod|ctrl|act', 'n', 'n', '类型，app：应用、mod：模块、ctrl：控制器、act：行动', '6', '1', '5', '6', '类型', '', 'n', 'n', 'y', '6', 'y', '6', 'y', '6', 'y', '6');
INSERT INTO `tr_builder_fields` VALUES ('75', 'group_id', '5', 'y', 'y', '主键ID', '7', '1', '9', '1', 'ID', '', 'n', 'n', 'y', '1000', 'n', '1', 'n', '1', 'y', '1');
INSERT INTO `tr_builder_fields` VALUES ('76', 'group_name', '100', 'n', 'n', '组名', '7', '1', '1', '2', '组名', '组名由2~50个字符组成.', 'y', 'n', 'y', '2', 'y', '2', 'y', '2', 'y', '2');
INSERT INTO `tr_builder_fields` VALUES ('77', 'group_pid', '5', 'n', 'y', '父ID', '7', '1', '9', '3', '父ID', '', 'n', 'n', 'y', '3', 'y', '3', 'y', '3', 'y', '3');
INSERT INTO `tr_builder_fields` VALUES ('78', 'sort', '5', 'n', 'y', '排序', '7', '1', '2', '4', '排序', '排序由数字组成且数字越小位置越靠前.', 'y', 'n', 'y', '4', 'y', '4', 'y', '4', 'y', '4');
INSERT INTO `tr_builder_fields` VALUES ('79', 'permission', '', 'n', 'n', '权限设置，可访问的事件，由应用-模块-控制器-行动组合', '7', '1', '6', '5', '权限设置', '', 'n', 'n', 'y', '5', 'y', '5', 'y', '5', 'y', '5');
INSERT INTO `tr_builder_fields` VALUES ('80', 'description', '', 'n', 'n', '描述', '7', '1', '10', '6', '描述', '', 'n', 'n', 'y', '6', 'y', '6', 'y', '6', 'y', '6');
INSERT INTO `tr_builder_fields` VALUES ('81', 'user_id', '10', 'n', 'y', '用户ID', '8', '1', '9', '1', '用户ID', '', 'n', 'n', 'y', '1000', 'n', '1', 'n', '1', 'y', '1');
INSERT INTO `tr_builder_fields` VALUES ('82', 'group_id', '5', 'n', 'y', '主键ID', '8', '1', '9', '2', '主键ID', '', 'n', 'n', 'y', '1000', 'n', '2', 'n', '2', 'y', '2');
INSERT INTO `tr_builder_fields` VALUES ('83', 'user_id', '10', 'y', 'y', '主键ID', '9', '1', '9', '1', 'ID', '', 'n', 'n', 'y', '1000', 'n', '1', 'n', '1', 'y', '1');
INSERT INTO `tr_builder_fields` VALUES ('84', 'login_name', '100', 'n', 'n', '登录名：邮箱|用户名|手机号', '9', '1', '1', '2', '登录名', '登录名由6~18个字符组成且填写后不能更改.', 'y', 'y', 'y', '2', 'y', '2', 'y', '2', 'y', '2');
INSERT INTO `tr_builder_fields` VALUES ('85', 'login_type', 'mail|name|phone', 'n', 'n', '通过登录名自动识别登录方式，mail：邮箱、name：用户名(不能是纯数字、不能包含@符)、phone：手机号(11位数字)', '9', '1', '5', '3', '登录方式', '', 'n', 'n', 'n', '3', 'n', '3', 'n', '3', 'y', '3');
INSERT INTO `tr_builder_fields` VALUES ('86', 'password', '32', 'n', 'n', '登录密码', '9', '1', '3', '4', '登录密码', '6~20位字符，可使用字母、数字或符号的组合，不建议使用纯数字、纯字母或纯符号.', 'y', 'n', 'n', '4', 'y', '4', 'y', '4', 'n', '4');
INSERT INTO `tr_builder_fields` VALUES ('87', 'salt', '6', 'n', 'n', '随机附加混淆码', '9', '1', '1', '5', '随机附加混淆码', '', 'n', 'n', 'n', '5', 'n', '5', 'n', '5', 'n', '5');
INSERT INTO `tr_builder_fields` VALUES ('88', 'user_name', '100', 'n', 'n', '用户名', '9', '1', '1', '6', '用户名', '用户名由4~50个字符组成.', 'n', 'n', 'y', '6', 'y', '6', 'y', '6', 'y', '6');
INSERT INTO `tr_builder_fields` VALUES ('89', 'user_mail', '100', 'n', 'n', '邮箱，可用来找回密码', '9', '1', '1', '7', '邮箱', '绑定邮箱，可用来找回密码.', 'n', 'n', 'y', '7', 'y', '7', 'y', '7', 'y', '7');
INSERT INTO `tr_builder_fields` VALUES ('90', 'user_phone', '11', 'n', 'n', '手机号，可用来找回密码', '9', '1', '1', '8', '手机号', '绑定手机号，可用来找回密码.', 'n', 'n', 'y', '8', 'y', '8', 'y', '8', 'y', '8');
INSERT INTO `tr_builder_fields` VALUES ('91', 'dt_registered', '', 'n', 'n', '注册时间', '9', '6', '1', '9', '注册时间', '', 'n', 'y', 'y', '17', 'y', '9', 'y', '9', 'n', '9');
INSERT INTO `tr_builder_fields` VALUES ('92', 'dt_last_login', '', 'n', 'n', '上次登录时间', '9', '6', '1', '10', '上次登录时间', '', 'n', 'y', 'n', '10', 'y', '10', 'y', '10', 'n', '10');
INSERT INTO `tr_builder_fields` VALUES ('93', 'dt_last_repwd', '', 'n', 'n', '上次更新密码时间', '9', '6', '1', '11', '上次更新密码时间', '', 'n', 'y', 'n', '11', 'y', '11', 'y', '11', 'n', '11');
INSERT INTO `tr_builder_fields` VALUES ('94', 'ip_registered', '10', 'n', 'y', '注册IP', '9', '6', '2', '12', '注册IP', '', 'n', 'y', 'y', '18', 'y', '12', 'y', '12', 'n', '12');
INSERT INTO `tr_builder_fields` VALUES ('95', 'ip_last_login', '10', 'n', 'y', '上次登录IP', '9', '6', '2', '13', '上次登录IP', '', 'n', 'y', 'n', '13', 'y', '13', 'y', '13', 'n', '13');
INSERT INTO `tr_builder_fields` VALUES ('96', 'ip_last_repwd', '10', 'n', 'y', '上次更新密码IP', '9', '6', '2', '14', '上次更新密码IP', '', 'n', 'y', 'n', '14', 'y', '14', 'y', '14', 'n', '14');
INSERT INTO `tr_builder_fields` VALUES ('97', 'login_count', '8', 'n', 'y', '总登录次数', '9', '6', '2', '15', '总登录次数', '', 'n', 'y', 'n', '15', 'y', '15', 'y', '15', 'n', '15');
INSERT INTO `tr_builder_fields` VALUES ('98', 'repwd_count', '5', 'n', 'y', '总更新密码次数', '9', '6', '2', '16', '总更新密码次数', '', 'n', 'y', 'n', '16', 'y', '16', 'y', '16', 'n', '16');
INSERT INTO `tr_builder_fields` VALUES ('99', 'valid_mail', 'y|n', 'n', 'n', '是否已验证邮箱', '9', '1', '4', '17', '是否已验证邮箱', '', 'n', 'n', 'y', '12', 'y', '17', 'y', '17', 'y', '17');
INSERT INTO `tr_builder_fields` VALUES ('100', 'valid_phone', 'y|n', 'n', 'n', '是否已验证手机号', '9', '1', '4', '18', '是否已验证手机号', '', 'n', 'n', 'y', '13', 'y', '18', 'y', '18', 'y', '18');
INSERT INTO `tr_builder_fields` VALUES ('101', 'forbidden', 'y|n', 'n', 'n', '是否禁用', '9', '1', '4', '19', '是否禁用', '', 'n', 'n', 'y', '19', 'y', '19', 'y', '19', 'y', '19');
INSERT INTO `tr_builder_fields` VALUES ('102', 'trash', 'y|n', 'n', 'n', '是否删除', '9', '1', '4', '20', '是否删除', '', 'n', 'n', 'n', '20', 'n', '20', 'n', '20', 'n', '20');
INSERT INTO `tr_builder_fields` VALUES ('103', 'option_id', '5', 'y', 'y', '配置ID', '10', '1', '9', '1', '配置ID', '', 'n', 'n', 'y', '1000', 'n', '1', 'n', '1', 'y', '1');
INSERT INTO `tr_builder_fields` VALUES ('104', 'site_name', '100', 'n', 'n', '网站名称', '10', '1', '1', '2', '网站名称', '网站名称由2~100个字符组成.', 'y', 'n', 'y', '2', 'y', '2', 'y', '2', 'y', '2');
INSERT INTO `tr_builder_fields` VALUES ('105', 'site_url', '1024', 'n', 'n', '网站URL', '10', '1', '1', '3', '网站URL', '', 'y', 'n', 'y', '3', 'y', '3', 'y', '3', 'y', '3');
INSERT INTO `tr_builder_fields` VALUES ('106', 'tpl_dir', '100', 'n', 'n', '模板名称', '10', '1', '1', '4', '模板名称', '模板名称由2~20个英文字母、数字或下划线组成.', 'y', 'n', 'y', '4', 'y', '4', 'y', '4', 'y', '4');
INSERT INTO `tr_builder_fields` VALUES ('107', 'html_dir', '200', 'n', 'n', '生成静态页面存放目录名称', '10', '1', '1', '5', '生成静态页面存放目录名称', '目录名称由2~20个英文字母、数字或下划线组成.', 'y', 'n', 'y', '5', 'y', '5', 'y', '5', 'y', '5');
INSERT INTO `tr_builder_fields` VALUES ('108', 'meta_title', '100', 'n', 'n', 'SEO Title', '10', '1', '1', '6', 'SEO Title', '网站标题-在html-meta中展示', 'n', 'n', 'y', '6', 'y', '6', 'y', '6', 'y', '6');
INSERT INTO `tr_builder_fields` VALUES ('109', 'meta_keywords', '200', 'n', 'n', 'SEO Keywords', '10', '1', '1', '7', 'SEO Keywords', '网站关键词-在html-meta中展示', 'n', 'n', 'y', '7', 'y', '7', 'y', '7', 'y', '7');
INSERT INTO `tr_builder_fields` VALUES ('110', 'meta_description', '500', 'n', 'n', 'SEO Description', '10', '1', '10', '8', 'SEO Description', '网站关键词-在html-meta中展示', 'n', 'n', 'y', '8', 'y', '8', 'y', '8', 'y', '8');
INSERT INTO `tr_builder_fields` VALUES ('111', 'powerby', '200', 'n', 'n', '网站版权信息', '10', '1', '1', '9', '网站版权信息', '网站版权信息由2~100个英文字母、数字或下划线组成.', 'n', 'n', 'y', '9', 'y', '9', 'y', '9', 'y', '9');
INSERT INTO `tr_builder_fields` VALUES ('112', 'stat_code', '', 'n', 'n', '网站第三方统计代码', '10', '1', '10', '10', '网站第三方统计代码', '', 'n', 'n', 'y', '10', 'y', '10', 'y', '10', 'y', '10');
INSERT INTO `tr_builder_fields` VALUES ('113', 'url_rewrite', 'y|n', 'n', 'n', '是否使用重写模式获取URLS，在Apache上使用前先将文件“htaccess.txt”更名为“.htaccess”', '10', '1', '4', '11', '使用重写模式获取URLS', '在Apache上使用前先将文件“htaccess.txt”更名为“.htaccess”', 'n', 'n', 'y', '11', 'y', '11', 'y', '11', 'y', '11');
INSERT INTO `tr_builder_fields` VALUES ('114', 'close_register', 'y|n', 'n', 'n', '是否关闭新用户注册', '10', '7', '4', '12', '是否关闭新用户注册', '', 'n', 'n', 'y', '12', 'y', '12', 'y', '12', 'y', '12');
INSERT INTO `tr_builder_fields` VALUES ('115', 'close_register_reason', '', 'n', 'n', '关闭注册原因', '10', '7', '10', '13', '关闭注册原因', '', 'n', 'n', 'y', '13', 'y', '13', 'y', '13', 'y', '13');
INSERT INTO `tr_builder_fields` VALUES ('116', 'show_register_service_item', 'y|n', 'n', 'n', '是否显示用户注册协议', '10', '7', '4', '14', '是否显示用户注册协议', '', 'n', 'n', 'y', '14', 'y', '14', 'y', '14', 'y', '14');
INSERT INTO `tr_builder_fields` VALUES ('117', 'register_service_item', '', 'n', 'n', '用户注册协议', '10', '7', '10', '15', '用户注册协议', '', 'n', 'n', 'y', '15', 'y', '15', 'y', '15', 'y', '15');
INSERT INTO `tr_builder_fields` VALUES ('128', 'thumb_width', '5', 'n', 'y', '缩略图宽(单位:px)', '10', '8', '2', '26', '缩略图宽', '单位：px', 'n', 'n', 'y', '26', 'y', '26', 'y', '26', 'y', '26');
INSERT INTO `tr_builder_fields` VALUES ('129', 'thumb_height', '5', 'n', 'y', '缩略图高(单位:px)', '10', '8', '2', '27', '缩略图高', '单位：px', 'n', 'n', 'y', '27', 'y', '27', 'y', '27', 'y', '27');
INSERT INTO `tr_builder_fields` VALUES ('130', 'water_mark_type', 'imgdir|text|none', 'n', 'n', '水印类型，imgdir：只添加图片水印、text：只添加文字水印、none：不添加', '10', '8', '5', '28', '水印类型', '', 'n', 'n', 'y', '28', 'y', '28', 'y', '28', 'y', '28');
INSERT INTO `tr_builder_fields` VALUES ('131', 'water_mark_imgdir', '500', 'n', 'n', '水印图片文件地址', '10', '8', '1', '29', '水印图片文件地址', '', 'n', 'n', 'y', '29', 'y', '29', 'y', '29', 'y', '29');
INSERT INTO `tr_builder_fields` VALUES ('132', 'water_mark_text', '500', 'n', 'n', '水印文字信息', '10', '8', '1', '30', '水印文字信息', '', 'n', 'n', 'y', '30', 'y', '30', 'y', '30', 'y', '30');
INSERT INTO `tr_builder_fields` VALUES ('133', 'water_mark_position', '1|2|3|4|5|6|7|8|9', 'n', 'y', '水印放置位置', '10', '8', '5', '31', '水印放置位置', '', 'n', 'n', 'y', '31', 'y', '31', 'y', '31', 'y', '31');
INSERT INTO `tr_builder_fields` VALUES ('134', 'water_mark_pct', '5', 'n', 'y', '水印融合度', '10', '8', '2', '32', '水印融合度', '取值 0~100，当=0时，水印完全透明，实际上什么都没做；当=100时，水印完全不透明。', 'n', 'n', 'y', '32', 'y', '32', 'y', '32', 'y', '32');
INSERT INTO `tr_builder_fields` VALUES ('135', 'smtp_host', '200', 'n', 'n', 'SMTP服务器', '10', '9', '1', '33', 'SMTP服务器', '', 'n', 'n', 'y', '33', 'y', '33', 'y', '33', 'y', '33');
INSERT INTO `tr_builder_fields` VALUES ('136', 'smtp_port', '5', 'n', 'y', 'SMTP服务器端口', '10', '9', '2', '34', 'SMTP服务器端口', 'SMTP服务器端口由数字组成（默认：25）.', 'n', 'n', 'y', '34', 'y', '34', 'y', '34', 'y', '34');
INSERT INTO `tr_builder_fields` VALUES ('137', 'smtp_username', '100', 'n', 'n', 'SMTP服务器的账号', '10', '9', '1', '35', 'SMTP服务器的账号', '', 'n', 'n', 'y', '35', 'y', '35', 'y', '35', 'y', '35');
INSERT INTO `tr_builder_fields` VALUES ('138', 'smtp_password', '100', 'n', 'n', 'SMTP服务器的密码', '10', '9', '1', '36', 'SMTP服务器的密码', '', 'n', 'n', 'y', '36', 'y', '36', 'y', '36', 'y', '36');
INSERT INTO `tr_builder_fields` VALUES ('139', 'smtp_frommail', '100', 'n', 'n', '管理员邮箱', '10', '9', '1', '37', '管理员邮箱', '', 'n', 'n', 'y', '37', 'y', '37', 'y', '37', 'y', '37');
INSERT INTO `tr_builder_fields` VALUES ('140', 'page_var', '100', 'n', 'n', '从$_GET或$_POST中获取当前页的键名', '10', '10', '1', '38', '从$_GET或$_POST中获取当前页的键名', '', 'n', 'n', 'y', '38', 'y', '38', 'y', '38', 'y', '38');
INSERT INTO `tr_builder_fields` VALUES ('141', 'list_rows_var', '100', 'n', 'n', '从$_GET或$_POST中获取每页展示的行数的键名', '10', '10', '1', '39', '从$_GET或$_POST中获取每页展示的行数的键名', '', 'n', 'n', 'y', '39', 'y', '39', 'y', '39', 'y', '39');
INSERT INTO `tr_builder_fields` VALUES ('142', 'list_rows', '5', 'n', 'y', '每页展示的行数', '10', '10', '2', '41', '每页展示的行数', '', 'n', 'n', 'y', '40', 'y', '40', 'y', '40', 'y', '40');
INSERT INTO `tr_builder_fields` VALUES ('143', 'list_pages', '5', 'n', 'y', '每页展示的页码数', '10', '10', '2', '40', '每页展示的页码数', '', 'n', 'n', 'y', '41', 'y', '41', 'y', '41', 'y', '41');
INSERT INTO `tr_builder_fields` VALUES ('144', 'list_rows_posts', '5', 'n', 'y', '文档列表每页展示条数', '10', '10', '2', '42', '文档列表每页展示条数', '', 'n', 'n', 'y', '42', 'y', '42', 'y', '42', 'y', '42');
INSERT INTO `tr_builder_fields` VALUES ('145', 'list_rows_users', '5', 'n', 'y', '用户列表每页展示条数', '10', '10', '2', '43', '用户列表每页展示条数', '', 'n', 'n', 'y', '43', 'y', '43', 'y', '43', 'y', '43');
INSERT INTO `tr_builder_fields` VALUES ('146', 'module_id', '5', 'y', 'y', '主键ID', '11', '1', '9', '1', '主键ID', '', 'n', 'n', 'y', '1000', 'n', '1', 'n', '1', 'y', '1');
INSERT INTO `tr_builder_fields` VALUES ('147', 'module_name', '50', 'n', 'n', '模型名称', '11', '1', '1', '2', '模型名称', '', 'y', 'n', 'y', '2', 'y', '2', 'y', '2', 'y', '2');
INSERT INTO `tr_builder_fields` VALUES ('148', 'module_tblname', '50', 'n', 'n', '类别表名', '11', '1', '1', '3', '类别表名', '', 'y', 'n', 'y', '3', 'y', '3', 'y', '3', 'y', '3');
INSERT INTO `tr_builder_fields` VALUES ('149', 'forbidden', 'y|n', 'n', 'n', '是否禁用', '11', '1', '4', '4', '是否禁用', '', 'n', 'n', 'y', '4', 'y', '4', 'y', '4', 'y', '4');
INSERT INTO `tr_builder_fields` VALUES ('150', 'description', '', 'n', 'n', '描述', '11', '1', '1', '5', '描述', '', 'y', 'n', 'y', '5', 'y', '5', 'y', '5', 'y', '5');
INSERT INTO `tr_builder_fields` VALUES ('151', 'module_id', '5', 'y', 'y', '主键ID', '12', '1', '9', '1', '主键ID', '', 'n', 'n', 'y', '1000', 'n', '1', 'y', '1', 'y', '1');
INSERT INTO `tr_builder_fields` VALUES ('152', 'module_name', '50', 'n', 'n', '模型名称', '12', '1', '1', '2', '模型名称', '模型名称由2~50个字符组成.', 'y', 'n', 'y', '2', 'y', '2', 'y', '2', 'y', '2');
INSERT INTO `tr_builder_fields` VALUES ('153', 'module_tblname', '50', 'n', 'n', '类别表名', '12', '1', '1', '3', '类别表名', '类别表名由2~30个英文字母、数字或下划线组成.', 'y', 'y', 'y', '3', 'y', '3', 'y', '3', 'y', '3');
INSERT INTO `tr_builder_fields` VALUES ('154', 'forbidden', 'y|n', 'n', 'n', '是否禁用', '12', '1', '4', '4', '是否禁用', '', 'n', 'n', 'y', '4', 'y', '4', 'y', '4', 'y', '4');
INSERT INTO `tr_builder_fields` VALUES ('155', 'description', '', 'n', 'n', '描述', '12', '1', '10', '5', '描述', '', 'y', 'n', 'y', '5', 'y', '5', 'y', '5', 'y', '5');
INSERT INTO `tr_builder_fields` VALUES ('156', 'category_id', '5', 'y', 'y', '主键ID', '13', '1', '9', '1', 'ID', '', 'n', 'n', 'y', '1000', 'n', '1', 'n', '1', 'y', '1');
INSERT INTO `tr_builder_fields` VALUES ('157', 'category_pid', '5', 'n', 'y', '父类别ID', '13', '1', '7', '3', '所属父类别', '', 'y', 'n', 'y', '3', 'y', '3', 'y', '3', 'y', '3');
INSERT INTO `tr_builder_fields` VALUES ('158', 'category_name', '50', 'n', 'n', '类别名', '13', '1', '1', '2', '类别名', '类别名由2~20个字符组成.', 'y', 'n', 'y', '2', 'y', '2', 'y', '2', 'y', '2');
INSERT INTO `tr_builder_fields` VALUES ('159', 'module_id', '5', 'n', 'y', '模型ID', '13', '1', '7', '4', '所属模型', '', 'y', 'n', 'y', '4', 'y', '4', 'y', '4', 'y', '4');
INSERT INTO `tr_builder_fields` VALUES ('160', 'meta_title', '100', 'n', 'n', 'SEO标题', '13', '1', '1', '5', 'SEO标题', 'SEO标题由2~50个字符组成.', 'y', 'n', 'y', '5', 'y', '5', 'y', '5', 'y', '5');
INSERT INTO `tr_builder_fields` VALUES ('161', 'meta_keywords', '100', 'n', 'n', 'SEO关键字', '13', '1', '1', '6', 'SEO关键字', 'SEO关键字由2~50个字符组成.', 'y', 'n', 'y', '6', 'y', '6', 'y', '6', 'y', '6');
INSERT INTO `tr_builder_fields` VALUES ('162', 'meta_description', '250', 'n', 'n', 'SEO描述', '13', '1', '10', '7', 'SEO描述', 'SEO描述由2~120个字符组成.', 'y', 'n', 'y', '7', 'y', '7', 'y', '7', 'y', '7');
INSERT INTO `tr_builder_fields` VALUES ('163', 'is_hide', 'y|n', 'n', 'n', '菜单上是否隐藏', '13', '1', '4', '8', '菜单是否隐藏', '', 'n', 'n', 'y', '8', 'y', '8', 'y', '8', 'y', '8');
INSERT INTO `tr_builder_fields` VALUES ('164', 'menu_sort', '8', 'n', 'y', '显示菜单的排序', '13', '1', '2', '9', '菜单排序', '排序由非负数组成且数字越小位置越靠前.', 'y', 'n', 'y', '9', 'y', '9', 'y', '9', 'y', '9');
INSERT INTO `tr_builder_fields` VALUES ('165', 'is_jump', 'y|n', 'n', 'n', '是否跳转', '13', '1', '4', '10', '是否跳转', '', 'n', 'n', 'y', '10', 'y', '10', 'y', '10', 'y', '10');
INSERT INTO `tr_builder_fields` VALUES ('166', 'jump_url', '100', 'n', 'n', '跳转链接', '13', '1', '1', '11', '跳转链接', '绑定链接，可用来跳转到其他网址.', 'y', 'n', 'y', '11', 'y', '11', 'y', '11', 'y', '11');
INSERT INTO `tr_builder_fields` VALUES ('167', 'is_html', 'y|n', 'n', 'n', '是否生成静态页面', '13', '11', '4', '12', '是否生成静态页面', '', 'n', 'n', 'y', '12', 'y', '12', 'y', '12', 'y', '12');
INSERT INTO `tr_builder_fields` VALUES ('168', 'html_dir', '100', 'n', 'n', '生成静态页面存放目录', '13', '11', '1', '13', '生成静态页面存放目录', '生成静态页面存放目录由1~20个英文字母、数字或下划线组成.', 'y', 'n', 'y', '13', 'y', '13', 'y', '13', 'y', '13');
INSERT INTO `tr_builder_fields` VALUES ('169', 'tpl_home', '100', 'n', 'n', '封页模板名', '13', '11', '1', '14', '封页模板名', '封页模板名由1~50个英文字母、数字或下划线组成.', 'y', 'n', 'y', '14', 'y', '14', 'y', '14', 'y', '14');
INSERT INTO `tr_builder_fields` VALUES ('170', 'tpl_list', '100', 'n', 'n', '列表模板名', '13', '11', '1', '15', '列表模板名', '列表模板名由1~50个英文字母、数字或下划线组成.', 'y', 'n', 'y', '15', 'y', '15', 'y', '15', 'y', '15');
INSERT INTO `tr_builder_fields` VALUES ('171', 'tpl_view', '100', 'n', 'n', '文章模板名', '13', '11', '1', '16', '文档模板名', '文档模板名由1~50个英文字母、数字或下划线组成.', 'y', 'n', 'y', '16', 'y', '16', 'y', '16', 'y', '16');
INSERT INTO `tr_builder_fields` VALUES ('172', 'rule_list', '100', 'n', 'n', '列表静态页面链接规则', '13', '11', '1', '17', '列表静态页面链接规则', '列表静态页面链接规则由1~50个字符组成.', 'y', 'n', 'y', '17', 'y', '17', 'y', '17', 'y', '17');
INSERT INTO `tr_builder_fields` VALUES ('173', 'rule_view', '100', 'n', 'n', '文档静态页面链接规则', '13', '11', '1', '18', '文档静态页面链接规则', '文档静态页面链接规则由1~50个字符组成.', 'y', 'n', 'y', '18', 'y', '18', 'y', '18', 'y', '18');
INSERT INTO `tr_builder_fields` VALUES ('174', 'post_id', '10', 'y', 'y', '主键ID', '14', '1', '9', '1', 'ID', '', 'n', 'n', 'y', '1000', 'n', '1', 'n', '1', 'y', '1');
INSERT INTO `tr_builder_fields` VALUES ('175', 'title', '100', 'n', 'n', '文档标题', '14', '1', '1', '2', '文档标题', '文档标题由1~50个字符组成.', 'y', 'n', 'y', '2', 'y', '2', 'y', '2', 'y', '2');
INSERT INTO `tr_builder_fields` VALUES ('176', 'category_id', '5', 'n', 'y', '所属类别ID', '14', '1', '7', '4', '所属类别', '', 'n', 'n', 'y', '3', 'y', '3', 'y', '3', 'y', '3');
INSERT INTO `tr_builder_fields` VALUES ('177', 'category_name', '50', 'n', 'n', '类别名', '14', '1', '8', '5', '类别名', '', 'n', 'n', 'n', '4', 'n', '4', 'n', '4', 'n', '4');
INSERT INTO `tr_builder_fields` VALUES ('178', 'content', '', 'n', 'n', '文档内容', '14', '1', '10', '6', '内容', '', 'n', 'n', 'n', '5', 'y', '5', 'y', '5', 'n', '5');
INSERT INTO `tr_builder_fields` VALUES ('179', 'sort', '10', 'n', 'y', '排序', '14', '1', '2', '9', '排序', '排序由正整数组成且数字越小位置越靠前.', 'y', 'n', 'y', '6', 'y', '6', 'y', '6', 'y', '6');
INSERT INTO `tr_builder_fields` VALUES ('180', 'keywords', '100', 'n', 'n', '内容关键字', '14', '1', '1', '7', '关键字', '关键字由2~50个字符组成.', 'y', 'n', 'n', '7', 'y', '7', 'y', '7', 'y', '7');
INSERT INTO `tr_builder_fields` VALUES ('181', 'description', '500', 'n', 'n', '内容摘要', '14', '1', '10', '8', '内容摘要', '内容摘要由0~240个字符组成.', 'n', 'n', 'n', '8', 'y', '8', 'y', '8', 'n', '8');
INSERT INTO `tr_builder_fields` VALUES ('182', 'little_picture', '250', 'n', 'n', '缩略图地址', '14', '1', '8', '3', '缩略图地址', '', 'n', 'n', 'n', '9', 'y', '9', 'y', '9', 'n', '9');
INSERT INTO `tr_builder_fields` VALUES ('183', 'is_head', 'y|n', 'n', 'n', '是否头条', '14', '12', '4', '12', '是否头条', '', 'n', 'n', 'y', '10', 'y', '10', 'y', '10', 'y', '10');
INSERT INTO `tr_builder_fields` VALUES ('184', 'is_recommend', 'y|n', 'n', 'n', '是否推荐', '14', '12', '4', '13', '是否推荐', '', 'n', 'n', 'y', '11', 'y', '11', 'y', '11', 'y', '11');
INSERT INTO `tr_builder_fields` VALUES ('185', 'is_jump', 'y|n', 'n', 'n', '是否跳转', '14', '12', '4', '14', '是否跳转', '', 'n', 'n', 'n', '12', 'y', '12', 'y', '12', 'y', '12');
INSERT INTO `tr_builder_fields` VALUES ('186', 'jump_url', '250', 'n', 'n', '跳转链接', '14', '12', '1', '15', '跳转链接', '绑定链接，可用来跳转到其他网址.', 'y', 'n', 'n', '13', 'y', '13', 'y', '13', 'n', '13');
INSERT INTO `tr_builder_fields` VALUES ('187', 'is_html', 'y|n', 'n', 'n', '是否生成静态页面', '14', '12', '4', '16', '生成静态页面', '', 'n', 'n', 'n', '14', 'y', '14', 'y', '14', 'y', '14');
INSERT INTO `tr_builder_fields` VALUES ('188', 'html_url', '250', 'n', 'n', '生成静态页面链接', '14', '12', '8', '17', '生成静态页面链接', '', 'n', 'n', 'n', '15', 'n', '15', 'n', '15', 'n', '15');
INSERT INTO `tr_builder_fields` VALUES ('189', 'allow_comment', 'y|n', 'n', 'n', '是否允许评论', '14', '12', '4', '18', '是否允许评论', '', 'n', 'n', 'y', '16', 'y', '16', 'y', '16', 'y', '16');
INSERT INTO `tr_builder_fields` VALUES ('190', 'is_public', 'y|n', 'n', 'n', '是否发表，y：开放浏览、n：草稿或待审核', '14', '1', '4', '10', '是否发表', '', 'n', 'n', 'y', '17', 'y', '17', 'y', '17', 'y', '17');
INSERT INTO `tr_builder_fields` VALUES ('191', 'access_count', '20', 'n', 'y', '访问次数', '14', '13', '2', '20', '访问次数', '访问次数由非负数组成.', 'y', 'n', 'y', '18', 'y', '18', 'y', '18', 'y', '18');
INSERT INTO `tr_builder_fields` VALUES ('192', 'creator_id', '10', 'n', 'y', '创建人ID', '14', '13', '2', '24', '创建人', '', 'n', 'n', 'n', '19', 'n', '19', 'n', '19', 'n', '19');
INSERT INTO `tr_builder_fields` VALUES ('193', 'creator_name', '100', 'n', 'n', '创建人登录名', '14', '13', '1', '25', '创建人', '', 'n', 'y', 'y', '20', 'y', '20', 'y', '20', 'y', '20');
INSERT INTO `tr_builder_fields` VALUES ('194', 'last_modifier_id', '10', 'n', 'y', '上次编辑人ID', '14', '13', '2', '26', '上次编辑人', '', 'n', 'n', 'n', '21', 'n', '21', 'n', '21', 'n', '21');
INSERT INTO `tr_builder_fields` VALUES ('195', 'last_modifier_name', '100', 'n', 'n', '上次编辑人登录名', '14', '13', '1', '27', '上次编辑人', '', 'n', 'y', 'y', '22', 'y', '22', 'y', '22', 'y', '22');
INSERT INTO `tr_builder_fields` VALUES ('196', 'dt_created', '', 'n', 'n', '创建时间', '14', '13', '1', '21', '创建时间', '', 'y', 'n', 'y', '23', 'y', '23', 'y', '23', 'y', '23');
INSERT INTO `tr_builder_fields` VALUES ('197', 'dt_last_modified', '', 'n', 'n', '上次编辑时间', '14', '13', '1', '23', '上次编辑时间', '', 'y', 'n', 'y', '24', 'y', '24', 'y', '24', 'n', '24');
INSERT INTO `tr_builder_fields` VALUES ('198', 'ip_created', '10', 'n', 'y', '创建IP', '14', '13', '2', '28', '创建IP', '', 'n', 'y', 'y', '25', 'y', '25', 'y', '25', 'y', '25');
INSERT INTO `tr_builder_fields` VALUES ('199', 'ip_last_modified', '10', 'n', 'y', '上次编辑IP', '14', '13', '2', '29', '上次编辑IP', '', 'n', 'y', 'y', '26', 'y', '26', 'y', '26', 'y', '26');
INSERT INTO `tr_builder_fields` VALUES ('200', 'trash', 'y|n', 'n', 'n', '是否删除', '14', '1', '4', '11', '是否删除', '', 'n', 'n', 'y', '27', 'n', '27', 'n', '27', 'y', '27');
INSERT INTO `tr_builder_fields` VALUES ('201', 'dt_public', '', 'n', 'n', '发布时间', '14', '13', '1', '22', '发布时间', '', 'y', 'n', 'y', '23', 'y', '23', 'y', '23', 'y', '23');
INSERT INTO `tr_builder_fields` VALUES ('202', 'allow_other_modify', 'y|n', 'n', 'n', '是否允许其他人编辑', '14', '12', '4', '19', '允许其他人编辑', '', 'y', 'n', 'y', '0', 'y', '0', 'y', '0', 'y', '0');

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='表单字段组表';

-- ----------------------------
-- Records of tr_builder_field_groups
-- ----------------------------
INSERT INTO `tr_builder_field_groups` VALUES ('1', 'main', '主要信息', '0', '1', '默认');
INSERT INTO `tr_builder_field_groups` VALUES ('2', 'act', '行动名', '2', '1', '');
INSERT INTO `tr_builder_field_groups` VALUES ('3', 'system', '系统信息', '2', '2', '');
INSERT INTO `tr_builder_field_groups` VALUES ('4', 'view', '展示信息', '4', '1', '');
INSERT INTO `tr_builder_field_groups` VALUES ('5', 'groups', '所属分组', '9', '2', '');
INSERT INTO `tr_builder_field_groups` VALUES ('6', 'system', '系统信息', '9', '3', '');
INSERT INTO `tr_builder_field_groups` VALUES ('7', 'register', '注册设置', '10', '2', '');
INSERT INTO `tr_builder_field_groups` VALUES ('8', 'picture', '图片管理', '10', '3', '');
INSERT INTO `tr_builder_field_groups` VALUES ('9', 'smtp', '邮件设置', '10', '4', '');
INSERT INTO `tr_builder_field_groups` VALUES ('10', 'paginator', '分页配置', '10', '5', '');
INSERT INTO `tr_builder_field_groups` VALUES ('11', 'htmlcache', '模板缓存', '13', '2', '');
INSERT INTO `tr_builder_field_groups` VALUES ('12', 'advanced', '高级参数', '14', '2', '');
INSERT INTO `tr_builder_field_groups` VALUES ('13', 'system', '系统信息', '14', '3', '');

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
) ENGINE=InnoDB AUTO_INCREMENT=196 DEFAULT CHARSET=utf8 COMMENT='表单字段验证表';

-- ----------------------------
-- Records of tr_builder_field_validators
-- ----------------------------
INSERT INTO `tr_builder_field_validators` VALUES ('1', 'MinLength', '2', '2', 'integer', '类型名长度不能小于%option%个字符.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('2', 'MaxLength', '2', '50', 'integer', '类型名长度不能大于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('3', 'Alpha', '3', '', 'boolean', '表单类型名只能由英文字母组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('4', 'MinLength', '3', '2', 'integer', '表单类型名长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('5', 'MaxLength', '3', '12', 'integer', '表单类型名长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('6', 'Alpha', '4', '', 'boolean', '表字段类型只能由英文字母组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('7', 'MinLength', '4', '2', 'integer', '表字段类型长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('8', 'MaxLength', '4', '12', 'integer', '表字段类型长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('9', 'InArray', '5', '', 'array', '必须选择所属分类，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('10', 'Numeric', '6', '', 'boolean', '排序只能是数字.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('11', 'MinLength', '8', '6', 'integer', '生成代码名长度不能小于%option%个字符.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('12', 'MaxLength', '8', '50', 'integer', '生成代码名长度不能大于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('13', 'AlphaNum', '9', '', 'boolean', '表名只能由英文字母、数字或下划线组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('14', 'MinLength', '9', '2', 'integer', '表名长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('15', 'MaxLength', '9', '30', 'integer', '表名长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('16', 'InArray', '10', '', 'array', '必须选择是否生成扩展表，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('17', 'InArray', '11', '', 'array', '必须选择表引擎，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('18', 'InArray', '12', '', 'array', '必须选择表编码，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('19', 'NotEmpty', '13', '', 'boolean', '必须填写表描述.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('20', 'Alpha', '16', '', 'boolean', '应用名只能由英文字母组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('21', 'MinLength', '16', '2', 'integer', '应用名长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('22', 'MaxLength', '16', '50', 'integer', '应用名长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('23', 'Alpha', '17', '', 'boolean', '模块名只能由英文字母组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('24', 'MinLength', '17', '2', 'integer', '模块名长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('25', 'MaxLength', '17', '50', 'integer', '模块名长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('26', 'Alpha', '19', '', 'boolean', '控制器名只能由英文字母组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('27', 'MinLength', '19', '2', 'integer', '控制器名长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('28', 'MaxLength', '19', '12', 'integer', '控制器名长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('29', 'Alpha', '18', '', 'boolean', '类名只能由英文字母组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('30', 'MinLength', '18', '2', 'integer', '类名长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('31', 'MaxLength', '18', '12', 'integer', '类名长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('32', 'AlphaNum', '20', '', 'boolean', '外联其他表的字段名只能由英文字母、数字或下划线组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('33', 'MinLength', '20', '2', 'integer', '外联其他表的字段名长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('34', 'MaxLength', '20', '50', 'integer', '外联其他表的字段名长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('35', 'Alpha', '21', '', 'boolean', '数据列表行动名只能由英文字母组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('36', 'MinLength', '21', '2', 'integer', '数据列表行动名长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('37', 'MaxLength', '21', '12', 'integer', '数据列表行动名长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('38', 'Alpha', '22', '', 'boolean', '数据详情行动名只能由英文字母组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('39', 'MinLength', '22', '2', 'integer', '数据详情行动名长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('40', 'MaxLength', '22', '12', 'integer', '数据详情行动名长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('41', 'Alpha', '23', '', 'boolean', '新增数据行动名只能由英文字母组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('42', 'MinLength', '23', '2', 'integer', '新增数据行动名长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('43', 'MaxLength', '23', '12', 'integer', '新增数据行动名长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('44', 'Alpha', '24', '', 'boolean', '编辑数据行动名只能由英文字母组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('45', 'MinLength', '24', '2', 'integer', '编辑数据行动名长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('46', 'MaxLength', '24', '12', 'integer', '编辑数据行动名长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('47', 'Alpha', '25', '', 'boolean', '删除数据行动名只能由英文字母组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('48', 'MinLength', '25', '2', 'integer', '删除数据行动名长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('49', 'MaxLength', '25', '12', 'integer', '删除数据行动名长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('50', 'NotEmpty', '28', '', 'boolean', '必须填写作者姓名，代码注释用.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('51', 'Mail', '29', '', 'boolean', '邮箱格式不正确.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('52', 'InArray', '32', '', 'array', '必须选择移至回收站，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('53', 'InArray', '26', '', 'array', '必须选择数据列表每行操作Btn，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('54', 'InArray', '14', '', 'array', '必须选择代码类型，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('55', 'Alpha', '15', '', 'boolean', '业务名只能由英文字母组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('56', 'MinLength', '15', '2', 'integer', '业务名长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('57', 'MaxLength', '15', '50', 'integer', '业务名长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('58', 'Alpha', '34', '', 'boolean', '组名只能由英文字母组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('59', 'MinLength', '34', '2', 'integer', '组名长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('60', 'MaxLength', '34', '12', 'integer', '组名长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('61', 'MinLength', '35', '2', 'integer', '提示长度不能小于%option%个字符.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('62', 'MaxLength', '35', '12', 'integer', '提示长度不能大于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('63', 'Integer', '36', '', 'boolean', '生成代码ID只能是数字并且大于0.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('64', 'Numeric', '37', '', 'boolean', '排序只能是数字.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('65', 'AlphaNum', '40', '', 'boolean', '字段名只能由英文字母、数字或下划线组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('66', 'MinLength', '40', '2', 'integer', '字段名长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('67', 'MaxLength', '40', '50', 'integer', '字段名长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('68', 'InArray', '42', '', 'array', '必须选择是否自动递增，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('69', 'InArray', '43', '', 'array', '必须选择是否无符号，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('70', 'NotEmpty', '44', '', 'boolean', '必须填写DB字段描述.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('71', 'Integer', '45', '', 'boolean', '生成代码ID只能是数字并且大于0.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('72', 'InArray', '46', '', 'array', '您选择的表单字段组不存在或已被删除.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('73', 'InArray', '47', '', 'integer', '您选择的字段类型不存在或已被删除.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('74', 'Numeric', '48', '', 'boolean', '排序只能是数字.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('75', 'NotEmpty', '49', '', 'boolean', '必须填写Table和Form显示名.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('76', 'InArray', '51', '', 'array', '必须选择表单是否必填，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('77', 'InArray', '52', '', 'array', '必须选择编辑表单中是否允许输入，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('78', 'InArray', '53', '', 'array', '必须选择是否在列表中展示，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('79', 'Numeric', '54', '', 'boolean', '在列表中排序只能是数字.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('80', 'InArray', '55', '', 'array', '必须选择是否在新增表单中展示，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('81', 'Numeric', '56', '', 'boolean', '在新增表单中排序只能是数字.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('82', 'InArray', '57', '', 'array', '必须选择是否在编辑表单中展示，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('83', 'Numeric', '58', '', 'boolean', '在编辑表单中排序只能是数字.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('84', 'InArray', '59', '', 'array', '必须选择是否在查询表单中展示，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('85', 'Numeric', '60', '', 'boolean', '在查询表单中排序只能是数字.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('86', 'InArray', '62', '', 'array', '必须选择验证类名，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('87', 'Integer', '63', '', 'boolean', '表单字段ID只能是数字并且大于0.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('88', 'InArray', '65', '', 'array', '必须选择验证时对比值类型，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('89', 'Numeric', '67', '', 'boolean', '排序只能是数字.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('90', 'InArray', '68', '', 'array', '必须选择验证环境，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('91', 'Alpha', '71', '', 'boolean', '事件名只能由英文字母组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('92', 'MinLength', '71', '2', 'integer', '事件名长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('94', 'MaxLength', '71', '16', 'integer', '事件名长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('95', 'MinLength', '72', '2', 'integer', '提示长度不能小于%option%个字符.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('96', 'MaxLength', '72', '50', 'integer', '提示长度不能大于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('97', 'InArray', '74', '', 'array', '必须选择类型，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('98', 'Equal', '74', 'mod', 'string', '只能新增或编辑“模块”类型事件.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('99', 'Numeric', '73', '', 'boolean', '排序只能是数字.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('100', 'MinLength', '76', '2', 'integer', '组名长度不能小于%option%个字符.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('101', 'MaxLength', '76', '50', 'integer', '组名长度不能大于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('102', 'NotEmpty', '77', '', 'boolean', '您选择的父组名不存在或已被删除.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('103', 'Numeric', '78', '', 'boolean', '排序只能是数字.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('104', 'AlphaNum', '84', '', 'boolean', '登录名只能由英文字母、数字或下划线组成并且不能是纯数字.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('105', 'MinLength', '84', '6', 'integer', '登录名长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('106', 'MaxLength', '84', '18', 'integer', '登录名长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('107', 'MinLength', '86', '6', 'integer', '登录密码长度不能小于%option%个字符.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('108', 'MaxLength', '86', '20', 'integer', '登录密码长度不能大于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('109', 'MinLength', '88', '4', 'integer', '用户名长度不能小于%option%个字符.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('110', 'MaxLength', '88', '50', 'integer', '用户名长度不能大于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('111', 'Mail', '89', '', 'boolean', '邮箱格式不正确.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('112', 'InArray', '101', '', 'array', '必须选择是否禁用，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('113', 'InArray', '102', '', 'array', '必须选择是否删除，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('114', 'MinLength', '104', '2', 'integer', '网站名称长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('115', 'MaxLength', '104', '100', 'integer', '网站名称长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('116', 'Url', '105', '', 'boolean', 'URL格式不正确.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('117', 'NotEmpty', '105', '', 'boolean', '必须填写网站URL.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('118', 'InArray', '113', '', 'array', '必须选择使用重写模式获取URLS，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('119', 'InArray', '114', '', 'array', '必须选择是否关闭新用户注册，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('120', 'InArray', '116', '', 'array', '必须选择是否显示用户注册协议，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('121', 'Integer', '128', '', 'boolean', '缩略图宽只能是数字并且大于0.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('122', 'Integer', '129', '', 'boolean', '缩略图高只能是数字并且大于0.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('123', 'InArray', '130', '', 'array', '必须选择水印类型，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('126', 'Min', '134', '0', 'integer', '水印融合度不能小于%option%.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('127', 'Max', '134', '100', 'integer', '水印融合度不能大于%option%.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('128', 'Integer', '136', '', 'boolean', 'SMTP服务器端口只能是数字并且大于0.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('129', 'AlphaNum', '140', '', 'boolean', '从$_GET或$_POST中获取当前页的键名只能由英文字母、数字或下划线组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('130', 'AlphaNum', '141', '', 'boolean', '从$_GET或$_POST中获取每页展示的行数的键名只能由英文字母、数字或下划线组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('131', 'Integer', '143', '', 'boolean', '每页展示的页码数只能是数字并且大于0.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('132', 'Integer', '142', '', 'boolean', '每页展示的行数只能是数字并且大于0.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('133', 'Integer', '144', '', 'boolean', '文档列表每页展示条数只能是数字并且大于0.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('134', 'Integer', '145', '', 'boolean', '用户列表每页展示条数只能是数字并且大于0.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('136', 'Numeric', '134', '', 'boolean', '水印融合度只能是数字.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('137', 'InArray', '133', '', 'array', '必须选择水印放置位置，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('138', 'AlphaNum', '106', '', 'boolean', '模板名称只能由英文字母、数字或下划线组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('139', 'AlphaNum', '107', '', 'boolean', '生成静态页面存放目录名称只能由英文字母、数字或下划线组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('140', 'NotEmpty', '104', '', 'boolean', '必须填写网站名称.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('141', 'MinLength', '158', '2', 'integer', '类别名长度不能小于%option%个字符.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('142', 'MaxLength', '158', '20', 'integer', '类别名长度不能大于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('143', 'MinLength', '160', '2', 'integer', 'SEO标题长度不能小于%option%个字符.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('144', 'MaxLength', '160', '50', 'integer', 'SEO标题长度不能大于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('145', 'MinLength', '161', '2', 'integer', 'SEO关键字长度不能小于%option%个字符.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('146', 'MaxLength', '161', '50', 'integer', 'SEO关键字长度不能大于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('147', 'MinLength', '162', '2', 'integer', 'SEO描述长度不能小于%option%个字符.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('148', 'MaxLength', '162', '120', 'integer', 'SEO描述长度不能大于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('149', 'Numeric', '164', '', 'boolean', '排序只能是数字.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('150', 'InArray', '157', '', 'array', '您选择的父类别不存在或已被删除.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('151', 'InArray', '159', '', 'array', '您选择的模型不存在或已被删除.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('152', 'InArray', '163', '', 'array', '必须选择菜单是否隐藏，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('153', 'InArray', '165', '', 'array', '必须选择是否跳转，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('154', 'Url', '166', '', 'boolean', 'URL格式不正确.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('155', 'InArray', '167', '', 'array', '必须选择是否生成静态页面，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('156', 'MinLength', '168', '1', 'integer', '生成静态页面存放目录长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('157', 'MaxLength', '168', '20', 'integer', '生成静态页面存放目录长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('158', 'MinLength', '169', '1', 'integer', '封页模板名长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('159', 'MaxLength', '169', '50', 'integer', '封页模板名长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('160', 'MinLength', '170', '1', 'integer', '列表模板名长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('161', 'MaxLength', '170', '50', 'integer', '列表模板名长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('162', 'MinLength', '171', '1', 'integer', '文档模板名长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('163', 'MaxLength', '171', '50', 'integer', '文档模板名长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('165', 'MinLength', '172', '1', 'integer', '列表静态页面链接规则长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('166', 'MaxLength', '172', '50', 'integer', '列表静态页面链接规则长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('168', 'MinLength', '173', '1', 'integer', '文档静态页面链接规则长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('169', 'MaxLength', '173', '50', 'integer', '文档静态页面链接规则长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('170', 'AlphaNum', '168', '', 'boolean', '生成静态页面存放目录只能由英文字母、数字或下划线组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('171', 'AlphaNum', '169', '', 'boolean', '封页模板名只能由英文字母、数字或下划线组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('172', 'AlphaNum', '170', '', 'boolean', '列表模板名只能由英文字母、数字或下划线组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('173', 'AlphaNum', '171', '', 'boolean', '文档模板名只能由英文字母、数字或下划线组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('174', 'Integer', '164', '', 'boolean', '排序只能是数字并且大于0.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('175', 'MinLength', '175', '1', 'integer', '文档标题长度不能小于%option%个字符.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('176', 'MaxLength', '175', '50', 'integer', '文档标题长度不能大于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('177', 'MinLength', '180', '2', 'integer', '关键字长度不能小于%option%个字符.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('178', 'MaxLength', '180', '50', 'integer', '关键字长度不能大于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('179', 'MaxLength', '181', '240', 'integer', '内容摘要长度不能大于%option%个字符.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('180', 'Integer', '179', '', 'boolean', '排序只能是数字并且大于0.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('181', 'InArray', '190', '', 'array', '必须选择是否发表，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('182', 'InArray', '200', '', 'array', '必须选择是否删除，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('183', 'InArray', '183', '', 'array', '必须选择是否头条，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('184', 'InArray', '184', '', 'array', '必须选择是否推荐，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('185', 'InArray', '185', '', 'array', '必须选择是否跳转，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('186', 'Url', '186', '', 'boolean', 'URL格式不正确.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('187', 'InArray', '187', '', 'array', '必须选择生成静态页面，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('188', 'InArray', '189', '', 'array', '必须选择是否允许评论，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('191', 'DateTime', '196', '', 'boolean', '日期时间格式不正确.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('192', 'DateTime', '197', '', 'boolean', '日期时间格式不正确.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('193', 'DateTime', '201', '', 'boolean', '日期时间格式不正确.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('194', 'NonNegativeInteger', '191', '', 'boolean', '访问次数只能是非负数.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('195', 'InArray', '202', '', 'array', '必须选择允许其他人编辑，值只能是%s.', '1', 'all');

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
