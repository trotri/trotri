/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50141
Source Host           : localhost:3306
Source Database       : trotri

Target Server Type    : MYSQL
Target Server Version : 50141
File Encoding         : 65001

Date: 2014-01-07 19:14:11
*/

SET FOREIGN_KEY_CHECKS=0;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='表单字段组表';

-- ----------------------------
-- Records of tr_builder_field_groups
-- ----------------------------
INSERT INTO `tr_builder_field_groups` VALUES ('1', 'main', '主要信息', '0', '1', '默认');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='表单字段验证表';

-- ----------------------------
-- Records of tr_builder_field_validators
-- ----------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='表单字段表';

-- ----------------------------
-- Records of tr_builder_fields
-- ----------------------------

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='表单字段类型表';

-- ----------------------------
-- Records of tr_builder_types
-- ----------------------------
INSERT INTO `tr_builder_types` VALUES ('1', '单行文本', 'text', 'VARCHAR', 'text', '1');
INSERT INTO `tr_builder_types` VALUES ('2', '密码', 'password', 'CHAR', 'text', '2');
INSERT INTO `tr_builder_types` VALUES ('3', '开关选项卡', 'switch', 'ENUM', 'option', '3');
INSERT INTO `tr_builder_types` VALUES ('4', '单选', 'radio', 'ENUM', 'option', '4');
INSERT INTO `tr_builder_types` VALUES ('5', '多选', 'checkbox', 'VARCHAR', 'option', '5');
INSERT INTO `tr_builder_types` VALUES ('6', '单选下拉框', 'select', 'INT', 'option', '6');
INSERT INTO `tr_builder_types` VALUES ('7', '隐藏文本框', 'hidden', 'VARCHAR', 'text', '7');
INSERT INTO `tr_builder_types` VALUES ('8', '多行文本', 'textarea', 'TEXT', 'text', '8');
INSERT INTO `tr_builder_types` VALUES ('9', '上传文件', 'file', 'VARCHAR', 'text', '9');

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
  `app_name` varchar(100) NOT NULL DEFAULT '' COMMENT '应用名',
  `mod_name` varchar(100) NOT NULL DEFAULT '' COMMENT '模块名',
  `ctrl_name` varchar(100) NOT NULL DEFAULT '' COMMENT '控制器名，默认和省略前缀的表名相同',
  `act_index_name` varchar(100) NOT NULL DEFAULT 'index' COMMENT '行动名-数据列表',
  `act_view_name` varchar(100) NOT NULL DEFAULT 'view' COMMENT '行动名-数据详情',
  `act_create_name` varchar(100) NOT NULL DEFAULT 'create' COMMENT '行动名-新增数据',
  `act_modify_name` varchar(100) NOT NULL DEFAULT 'modify' COMMENT '行动名-编辑数据',
  `act_remove_name` varchar(100) NOT NULL DEFAULT 'remove' COMMENT '行动名-删除数据',
  `index_row_btns` varchar(100) NOT NULL DEFAULT 'pencil|trash' COMMENT '数据列表每行操作Btn，编辑：pencil、放入回收站：trash、彻底删除：remove',
  `description` text COMMENT '描述',
  `dt_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `dt_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '上次编辑时间',
  `trash` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否删除',
  PRIMARY KEY (`builder_id`),
  KEY `builder_name` (`builder_name`),
  KEY `tbl_name` (`tbl_name`),
  KEY `tbl_profile` (`tbl_profile`),
  KEY `tbl_engine` (`tbl_engine`),
  KEY `tbl_charset` (`tbl_charset`),
  KEY `app_mod_ctrl` (`app_name`,`mod_name`,`ctrl_name`),
  KEY `trash` (`trash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='生成代码表';

-- ----------------------------
-- Records of tr_builders
-- ----------------------------

-- ----------------------------
-- Table structure for `tr_generator_field_groups`
-- ----------------------------
DROP TABLE IF EXISTS `tr_generator_field_groups`;
CREATE TABLE `tr_generator_field_groups` (
  `group_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `group_name` varchar(100) NOT NULL DEFAULT '' COMMENT '组名',
  `prompt` varchar(100) NOT NULL DEFAULT '' COMMENT '提示',
  `generator_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '生成代码ID',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `description` text COMMENT '描述',
  PRIMARY KEY (`group_id`),
  KEY `group_name` (`group_name`),
  KEY `generator_id` (`generator_id`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='表单字段组表';

-- ----------------------------
-- Records of tr_generator_field_groups
-- ----------------------------
INSERT INTO `tr_generator_field_groups` VALUES ('1', 'main', '主要信息', '0', '1', '默认');
INSERT INTO `tr_generator_field_groups` VALUES ('2', 'act', '行动名', '2', '1', '');
INSERT INTO `tr_generator_field_groups` VALUES ('3', 'system', '系统信息', '2', '2', '');

-- ----------------------------
-- Table structure for `tr_generator_field_types`
-- ----------------------------
DROP TABLE IF EXISTS `tr_generator_field_types`;
CREATE TABLE `tr_generator_field_types` (
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='表单字段类型表';

-- ----------------------------
-- Records of tr_generator_field_types
-- ----------------------------
INSERT INTO `tr_generator_field_types` VALUES ('1', '单行文本', 'text', 'VARCHAR', 'text', '1');
INSERT INTO `tr_generator_field_types` VALUES ('2', '密码', 'password', 'CHAR', 'text', '2');
INSERT INTO `tr_generator_field_types` VALUES ('3', '开关选项卡', 'switch', 'ENUM', 'option', '3');
INSERT INTO `tr_generator_field_types` VALUES ('4', '单选', 'radio', 'ENUM', 'option', '4');
INSERT INTO `tr_generator_field_types` VALUES ('5', '多选', 'checkbox', 'VARCHAR', 'option', '5');
INSERT INTO `tr_generator_field_types` VALUES ('6', '单选下拉框', 'select', 'INT', 'option', '6');
INSERT INTO `tr_generator_field_types` VALUES ('7', '隐藏文本框', 'hidden', 'VARCHAR', 'text', '7');
INSERT INTO `tr_generator_field_types` VALUES ('8', '多行文本', 'textarea', 'TEXT', 'text', '8');
INSERT INTO `tr_generator_field_types` VALUES ('9', '上传文件', 'file', 'VARCHAR', 'text', '9');

-- ----------------------------
-- Table structure for `tr_generator_field_validators`
-- ----------------------------
DROP TABLE IF EXISTS `tr_generator_field_validators`;
CREATE TABLE `tr_generator_field_validators` (
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='表单字段验证表';

-- ----------------------------
-- Records of tr_generator_field_validators
-- ----------------------------
INSERT INTO `tr_generator_field_validators` VALUES ('1', 'InArray', '2', '', 'array', '', '1', 'all');
INSERT INTO `tr_generator_field_validators` VALUES ('2', 'MinLength', '3', '2', 'integer', '事件名“%value%”长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_generator_field_validators` VALUES ('3', 'MaxLength', '3', '16', 'integer', '事件名“%value%”长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_generator_field_validators` VALUES ('4', 'Alpha', '3', '', 'string', '应用名只能由英文字母组成.', '1', 'all');
INSERT INTO `tr_generator_field_validators` VALUES ('5', 'InArray', '5', '', 'array', '必须选择类型，值只能是%s.', '1', 'all');
INSERT INTO `tr_generator_field_validators` VALUES ('6', 'Numeric', '4', '', 'integer', '排序只能是数字.', '1', 'all');
INSERT INTO `tr_generator_field_validators` VALUES ('9', 'MinLength', '7', '2', 'integer', '类型名“%value%”长度不能小于%option%个字符.', '1', 'all');
INSERT INTO `tr_generator_field_validators` VALUES ('10', 'MaxLength', '7', '50', 'integer', '类型名“%value%”长度不能大于%option%个字符.', '2', 'all');
INSERT INTO `tr_generator_field_validators` VALUES ('11', 'Alpha', '8', '', 'boolean', '数据列表行动名只能由英文字母组成.', '1', 'all');
INSERT INTO `tr_generator_field_validators` VALUES ('12', 'MinLength', '8', '2', 'integer', '表单类型名“%value%”长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_generator_field_validators` VALUES ('13', 'MaxLength', '8', '12', 'integer', '表单类型名“%value%”长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_generator_field_validators` VALUES ('14', 'Alpha', '9', '', 'boolean', '表字段类型只能由英文字母组成.', '1', 'all');
INSERT INTO `tr_generator_field_validators` VALUES ('15', 'MinLength', '9', '2', 'integer', '表字段类型“%value%”长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_generator_field_validators` VALUES ('16', 'MaxLength', '9', '12', 'integer', '表字段类型“%value%”长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_generator_field_validators` VALUES ('17', 'InArray', '10', 'text|option|button', 'array', '必须选择所属分类，值只能是%s.', '1', 'all');
INSERT INTO `tr_generator_field_validators` VALUES ('18', 'Numeric', '11', '', 'boolean', '排序只能是数字.', '1', 'all');

-- ----------------------------
-- Table structure for `tr_generator_fields`
-- ----------------------------
DROP TABLE IF EXISTS `tr_generator_fields`;
CREATE TABLE `tr_generator_fields` (
  `field_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `field_name` varchar(100) NOT NULL DEFAULT '' COMMENT '字段名',
  `column_length` varchar(200) NOT NULL DEFAULT '0' COMMENT 'DB字段长度',
  `column_auto_increment` enum('y','n') NOT NULL DEFAULT 'y' COMMENT '是否自动递增',
  `column_unsigned` enum('y','n') NOT NULL DEFAULT 'y' COMMENT '是否无符号',
  `column_comment` varchar(200) NOT NULL DEFAULT '' COMMENT 'DB字段描述',
  `generator_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '生成代码ID',
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
  KEY `generator_id` (`generator_id`),
  KEY `group_id` (`group_id`),
  KEY `type_id` (`type_id`),
  KEY `sort` (`sort`),
  KEY `index_sort` (`index_sort`),
  KEY `form_create_sort` (`form_create_sort`),
  KEY `form_modify_sort` (`form_modify_sort`),
  KEY `form_search_sort` (`form_search_sort`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COMMENT='表单字段表';

-- ----------------------------
-- Records of tr_generator_fields
-- ----------------------------
INSERT INTO `tr_generator_fields` VALUES ('1', 'amca_id', '5', 'y', 'y', '主键ID', '1', '1', '1', '1', 'ID', '', 'n', 'n', 'y', '0', 'n', '0', 'n', '0', 'n', '0');
INSERT INTO `tr_generator_fields` VALUES ('2', 'amca_pid', '5', 'n', 'y', '父ID', '1', '1', '5', '2', '父事件', '', 'y', 'n', 'y', '0', 'y', '0', 'y', '0', 'n', '0');
INSERT INTO `tr_generator_fields` VALUES ('3', 'amca_name', '100', 'n', 'n', '事件名', '1', '1', '1', '3', '事件名', '事件名由2~16个英文字母组成.', 'y', 'n', 'y', '0', 'y', '0', 'y', '0', 'n', '0');
INSERT INTO `tr_generator_fields` VALUES ('4', 'sort', '5', 'n', 'y', '排序', '1', '1', '1', '4', '排序', '排序只能是数字.', 'n', 'n', 'y', '0', 'y', '0', 'y', '0', 'n', '0');
INSERT INTO `tr_generator_fields` VALUES ('5', 'category', 'app|mod|ctrl|act', 'n', 'n', '类型，app：应用、mod：模块、ctrl：控制器、act：行动', '1', '1', '4', '5', '类型', '', 'n', 'n', 'y', '0', 'y', '0', 'y', '0', 'y', '0');
INSERT INTO `tr_generator_fields` VALUES ('6', 'type_id', '5', 'y', 'y', '主键ID', '3', '1', '1', '1', 'ID', '', 'n', 'n', 'y', '6', 'n', '0', 'n', '0', 'n', '0');
INSERT INTO `tr_generator_fields` VALUES ('7', 'type_name', '100', 'n', 'n', '类型名，单行文本、多行文本、密码、开关选项卡、提交按钮等', '3', '1', '1', '2', '类型名', '类型名由2~50个字符组成.', 'y', 'n', 'y', '1', 'y', '1', 'y', '1', 'n', '0');
INSERT INTO `tr_generator_fields` VALUES ('8', 'form_type', '100', 'n', 'n', '表单类型名，HTML：text、password、button、radio等；用户自定义：ckeditor、datetime等', '3', '1', '1', '3', '表单类型名', '表单类型名由2~12个英文字母组成.', 'y', 'n', 'y', '2', 'y', '2', 'y', '2', 'n', '0');
INSERT INTO `tr_generator_fields` VALUES ('9', 'field_type', '100', 'n', 'n', '表字段类型，INT、VARCHAR、CHAR、TEXT等', '3', '1', '1', '4', '表字段类型', '表字段类型由2~12个英文字母组成.', 'y', 'n', 'y', '3', 'y', '3', 'y', '3', 'n', '0');
INSERT INTO `tr_generator_fields` VALUES ('10', 'category', 'text|option|button', 'n', 'n', '所属分类，text：文本类、option：选项类、button：按钮类', '3', '1', '4', '5', '所属分类', '', 'n', 'n', 'y', '5', 'y', '4', 'y', '4', 'n', '0');
INSERT INTO `tr_generator_fields` VALUES ('11', 'sort', '5', 'n', 'y', '排序', '3', '1', '1', '6', '排序', '排序由数字组成，数字越小位置越靠前.', 'y', 'n', 'y', '6', 'y', '5', 'y', '5', 'n', '0');
INSERT INTO `tr_generator_fields` VALUES ('12', 'builder_id', '5', 'y', 'y', '主键ID', '2', '1', '1', '1', 'ID', '', 'n', 'n', 'y', '12', 'n', '0', 'n', '0', 'n', '0');
INSERT INTO `tr_generator_fields` VALUES ('13', 'builder_name', '100', 'n', 'n', '生成代码名', '2', '1', '1', '2', '生成代码名', '生成代码名由6~50个字符组成.', 'y', 'n', 'y', '1', 'y', '1', 'y', '1', 'n', '0');
INSERT INTO `tr_generator_fields` VALUES ('14', 'tbl_name', '100', 'n', 'n', '表名', '2', '1', '1', '3', '表名', '表名由2~12个英文字母、数字或下划线组成.', 'y', 'n', 'y', '2', 'y', '1', 'y', '1', 'n', '0');
INSERT INTO `tr_generator_fields` VALUES ('15', 'tbl_profile', 'y|n', 'n', 'n', '是否生成扩展表', '2', '1', '3', '4', '是否生成扩展表', '', 'n', 'n', 'y', '3', 'y', '3', 'y', '3', 'n', '0');
INSERT INTO `tr_generator_fields` VALUES ('16', 'tbl_engine', 'MyISAM|InnoDB', 'n', 'n', '表引擎', '2', '1', '4', '5', '表引擎', '', 'n', 'n', 'y', '4', 'y', '4', 'y', '4', 'n', '0');
INSERT INTO `tr_generator_fields` VALUES ('17', 'tbl_charset', 'utf8|gbk|gb2312', 'n', 'n', '表编码', '2', '1', '4', '6', '表编码', '', 'n', 'n', 'y', '5', 'y', '5', 'y', '5', 'y', '0');
INSERT INTO `tr_generator_fields` VALUES ('18', 'tbl_comment', '200', 'n', 'n', '表描述', '2', '1', '1', '7', '表描述', '', 'y', 'n', 'y', '6', 'y', '6', 'y', '6', 'n', '0');
INSERT INTO `tr_generator_fields` VALUES ('19', 'app_name', '100', 'n', 'n', '应用名', '2', '1', '1', '8', '应用名', '应用名由2~50个英文字母组成.', 'y', 'n', 'y', '7', 'y', '7', 'y', '7', 'n', '0');
INSERT INTO `tr_generator_fields` VALUES ('20', 'mod_name', '100', 'n', 'n', '模块名', '2', '1', '1', '9', '模块名', '模块名由2~50个英文字母组成.', 'y', 'n', 'y', '8', 'y', '8', 'y', '8', 'n', '0');
INSERT INTO `tr_generator_fields` VALUES ('21', 'ctrl_name', '100', 'n', 'n', '控制器名，默认和省略前缀的表名相同', '2', '1', '1', '10', '控制器名', '控制器名由2~12个英文字母组成.', 'y', 'n', 'y', '9', 'y', '9', 'y', '9', 'n', '0');
INSERT INTO `tr_generator_fields` VALUES ('22', 'act_index_name', '100', 'n', 'n', '行动名-数据列表', '2', '2', '1', '11', '数据列表', '数据列表行动名由2~12个英文字母组成.', 'y', 'n', 'n', '0', 'y', '1', 'y', '1', 'n', '0');
INSERT INTO `tr_generator_fields` VALUES ('23', 'act_view_name', '100', 'n', 'n', '行动名-数据详情', '2', '2', '1', '12', '数据详情', '数据详情行动名由2~12个英文字母组成.', 'y', 'n', 'n', '0', 'y', '2', 'y', '2', 'n', '0');
INSERT INTO `tr_generator_fields` VALUES ('24', 'act_create_name', '100', 'n', 'n', '行动名-新增数据', '2', '2', '1', '13', '新增数据', '新增数据行动名由2~12个英文字母组成.', 'y', 'n', 'n', '0', 'y', '3', 'y', '3', 'n', '0');
INSERT INTO `tr_generator_fields` VALUES ('25', 'act_modify_name', '100', 'n', 'n', '行动名-编辑数据', '2', '2', '1', '14', '编辑数据', '编辑数据行动名由2~12个英文字母组成.', 'y', 'n', 'n', '0', 'n', '4', 'y', '4', 'y', '0');
INSERT INTO `tr_generator_fields` VALUES ('26', 'act_remove_name', '100', 'n', 'n', '行动名-删除数据', '2', '2', '1', '15', '删除数据', '删除数据行动名由2~12个英文字母组成.', 'y', 'n', 'n', '0', 'y', '5', 'y', '5', 'n', '0');
INSERT INTO `tr_generator_fields` VALUES ('27', 'index_row_btns', '100', 'n', 'n', '数据列表每行操作Btn，编辑：pencil、放入回收站：trash、彻底删除：remove', '2', '1', '1', '16', '列表每行操作按钮', '', 'n', 'n', 'n', '0', 'y', '10', 'y', '10', 'n', '0');
INSERT INTO `tr_generator_fields` VALUES ('28', 'description', '', 'n', 'n', '描述', '2', '1', '8', '17', '描述', '', 'n', 'n', 'n', '0', 'y', '11', 'y', '11', 'n', '0');
INSERT INTO `tr_generator_fields` VALUES ('29', 'dt_created', '', 'n', 'n', '创建时间', '2', '3', '1', '18', '创建时间', '', 'n', 'y', 'n', '0', 'y', '1', 'y', '1', 'n', '0');
INSERT INTO `tr_generator_fields` VALUES ('30', 'dt_modified', '', 'n', 'n', '上次编辑时间', '2', '3', '1', '19', '上次编辑时间', '', 'y', 'n', 'n', '0', 'y', '2', 'y', '2', 'n', '0');
INSERT INTO `tr_generator_fields` VALUES ('31', 'trash', 'y|n', 'n', 'n', '是否删除', '2', '1', '3', '20', '放入回收站', '', 'n', 'n', 'n', '0', 'y', '12', 'y', '12', 'n', '0');

-- ----------------------------
-- Table structure for `tr_generator_types`
-- ----------------------------
DROP TABLE IF EXISTS `tr_generator_types`;
CREATE TABLE `tr_generator_types` (
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='表单字段类型表';

-- ----------------------------
-- Records of tr_generator_types
-- ----------------------------
INSERT INTO `tr_generator_types` VALUES ('1', '单行文本', 'text', 'VARCHAR', 'text', '1');
INSERT INTO `tr_generator_types` VALUES ('2', '密码', 'password', 'CHAR', 'text', '2');
INSERT INTO `tr_generator_types` VALUES ('3', '开关选项卡', 'switch', 'ENUM', 'option', '3');
INSERT INTO `tr_generator_types` VALUES ('4', '单选', 'radio', 'ENUM', 'option', '4');
INSERT INTO `tr_generator_types` VALUES ('5', '多选', 'checkbox', 'VARCHAR', 'option', '5');
INSERT INTO `tr_generator_types` VALUES ('6', '单选下拉框', 'select', 'INT', 'option', '6');
INSERT INTO `tr_generator_types` VALUES ('7', '隐藏文本框', 'hidden', 'VARCHAR', 'text', '7');
INSERT INTO `tr_generator_types` VALUES ('8', '多行文本', 'textarea', 'TEXT', 'text', '8');
INSERT INTO `tr_generator_types` VALUES ('9', '上传文件', 'file', 'VARCHAR', 'text', '9');

-- ----------------------------
-- Table structure for `tr_generators`
-- ----------------------------
DROP TABLE IF EXISTS `tr_generators`;
CREATE TABLE `tr_generators` (
  `generator_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `generator_name` varchar(100) NOT NULL DEFAULT '' COMMENT '生成代码名',
  `tbl_name` varchar(100) NOT NULL DEFAULT '' COMMENT '表名',
  `tbl_profile` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否生成扩展表',
  `tbl_engine` enum('MyISAM','InnoDB') NOT NULL DEFAULT 'InnoDB' COMMENT '表引擎',
  `tbl_charset` enum('utf8','gbk','gb2312') NOT NULL DEFAULT 'utf8' COMMENT '表编码',
  `tbl_comment` varchar(200) NOT NULL DEFAULT '' COMMENT '表描述',
  `app_name` varchar(100) NOT NULL DEFAULT '' COMMENT '应用名',
  `mod_name` varchar(100) NOT NULL DEFAULT '' COMMENT '模块名',
  `ctrl_name` varchar(100) NOT NULL DEFAULT '' COMMENT '控制器名，默认和省略前缀的表名相同',
  `act_index_name` varchar(100) NOT NULL DEFAULT 'index' COMMENT '行动名-数据列表',
  `act_view_name` varchar(100) NOT NULL DEFAULT 'view' COMMENT '行动名-数据详情',
  `act_create_name` varchar(100) NOT NULL DEFAULT 'create' COMMENT '行动名-新增数据',
  `act_modify_name` varchar(100) NOT NULL DEFAULT 'modify' COMMENT '行动名-编辑数据',
  `act_remove_name` varchar(100) NOT NULL DEFAULT 'remove' COMMENT '行动名-删除数据',
  `index_row_btns` varchar(100) NOT NULL DEFAULT 'pencil|trash' COMMENT '数据列表每行操作Btn，编辑：pencil、放入回收站：trash、彻底删除：remove',
  `description` text COMMENT '描述',
  `dt_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `dt_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '上次编辑时间',
  `trash` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否删除',
  PRIMARY KEY (`generator_id`),
  KEY `generator_name` (`generator_name`),
  KEY `tbl_name` (`tbl_name`),
  KEY `tbl_profile` (`tbl_profile`),
  KEY `tbl_engine` (`tbl_engine`),
  KEY `tbl_charset` (`tbl_charset`),
  KEY `app_mod_ctrl` (`app_name`,`mod_name`,`ctrl_name`),
  KEY `trash` (`trash`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='生成代码表';

-- ----------------------------
-- Records of tr_generators
-- ----------------------------
INSERT INTO `tr_generators` VALUES ('1', '用户可访问的事件', 'user_amcas', 'n', 'InnoDB', 'utf8', '用户可访问的事件表', 'administrator', 'ucenter', 'amcas', 'index', 'view', 'create', 'modify', 'remove', 'pencil,trash,remove', '', '2013-12-19 14:19:33', '2013-12-25 17:00:00', 'n');
INSERT INTO `tr_generators` VALUES ('2', '生成代码', 'builders', 'n', 'InnoDB', 'utf8', '生成代码表', 'administrator', 'builder', 'index', 'index', 'view', 'create', 'modify', 'remove', 'pencil,trash', '', '2014-01-07 14:49:15', '2014-01-07 18:37:19', 'n');
INSERT INTO `tr_generators` VALUES ('3', '表单字段类型', 'builder_types', 'n', 'InnoDB', 'utf8', '表单字段类型表', 'administrator', 'builder', 'types', 'index', 'view', 'create', 'modify', 'remove', 'pencil,remove', '', '2014-01-07 15:04:35', '2014-01-07 16:10:46', 'n');

-- ----------------------------
-- Table structure for `tr_user_amcas`
-- ----------------------------
DROP TABLE IF EXISTS `tr_user_amcas`;
CREATE TABLE `tr_user_amcas` (
  `amca_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `amca_pid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `amca_name` varchar(100) NOT NULL DEFAULT '' COMMENT '事件名',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `category` enum('app','mod','ctrl','act') NOT NULL DEFAULT 'act' COMMENT '类型，app：应用、mod：模块、ctrl：控制器、act：行动',
  PRIMARY KEY (`amca_id`),
  KEY `amca_pid` (`amca_pid`),
  KEY `amca_name` (`amca_name`),
  KEY `sort` (`sort`),
  KEY `category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户可访问的事件表';

-- ----------------------------
-- Records of tr_user_amcas
-- ----------------------------

-- ----------------------------
-- Table structure for `tr_user_groups`
-- ----------------------------
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

-- ----------------------------
-- Records of tr_user_groups
-- ----------------------------

-- ----------------------------
-- Table structure for `tr_user_profile`
-- ----------------------------
DROP TABLE IF EXISTS `tr_user_profile`;
CREATE TABLE `tr_user_profile` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `profile_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
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
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `group_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '主键ID',
  PRIMARY KEY (`user_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户和用户组关联表';

-- ----------------------------
-- Records of tr_user_usergroups_map
-- ----------------------------

-- ----------------------------
-- Table structure for `tr_users`
-- ----------------------------
DROP TABLE IF EXISTS `tr_users`;
CREATE TABLE `tr_users` (
  `user_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `login_mail` varchar(100) NOT NULL DEFAULT '' COMMENT '登录邮箱',
  `login_name` varchar(100) NOT NULL DEFAULT '' COMMENT '登录名',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '登录密码',
  `salt` char(6) NOT NULL DEFAULT '' COMMENT '随机附加混淆码',
  `user_name` varchar(100) NOT NULL DEFAULT '' COMMENT '用户名',
  `dt_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '注册时间',
  `dt_last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '上次登录时间',
  `dt_last_repwd` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '上次更新密码时间',
  `ip_registered` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册IP',
  `ip_last_login` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次登录IP',
  `ip_last_repwd` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次更新密码IP',
  `login_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '总登录次数',
  `repwd_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '总更新密码次数',
  `valid_mail` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否验证邮箱',
  `forbidden` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否禁用',
  `trash` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否删除',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `login_mail` (`login_mail`),
  UNIQUE KEY `login_name` (`login_name`),
  KEY `user_name` (`user_name`),
  KEY `valid_mail` (`valid_mail`),
  KEY `forbidden` (`forbidden`),
  KEY `trash` (`trash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户主表';

-- ----------------------------
-- Records of tr_users
-- ----------------------------
