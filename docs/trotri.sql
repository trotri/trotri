/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50141
Source Host           : localhost:3306
Source Database       : trotri

Target Server Type    : MYSQL
Target Server Version : 50141
File Encoding         : 65001

Date: 2014-03-31 17:42:58
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='表单字段组表';

-- ----------------------------
-- Records of tr_builder_field_groups
-- ----------------------------
INSERT INTO `tr_builder_field_groups` VALUES ('1', 'main', '主要信息', '0', '1', '默认');
INSERT INTO `tr_builder_field_groups` VALUES ('2', 'act', '行动名', '3', '2', '');
INSERT INTO `tr_builder_field_groups` VALUES ('3', 'system', '系统信息', '3', '3', '');

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
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COMMENT='表单字段验证表';

-- ----------------------------
-- Records of tr_builder_field_validators
-- ----------------------------
INSERT INTO `tr_builder_field_validators` VALUES ('1', 'MinLength', '31', '6', 'integer', '生成代码名长度不能小于%option%个字符.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('2', 'MaxLength', '31', '50', 'integer', '生成代码名长度不能大于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('3', 'AlphaNum', '32', '', 'boolean', '表名只能由英文字母、数字或下划线组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('4', 'MinLength', '32', '2', 'integer', '表名长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('5', 'MaxLength', '32', '30', 'integer', '表名长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('6', 'InArray', '33', '', 'array', '必须选择是否生成扩展表，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('7', 'InArray', '34', '', 'array', '必须选择表引擎，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('8', 'InArray', '35', '', 'array', '必须选择表编码，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('9', 'NotEmpty', '36', '', 'boolean', '必须填写表描述.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('10', 'Alpha', '37', '', 'boolean', '应用名只能由英文字母组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('11', 'MinLength', '37', '2', 'integer', '应用名长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('12', 'MaxLength', '37', '50', 'integer', '应用名长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('13', 'Alpha', '38', '', 'boolean', '模块名只能由英文字母组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('14', 'MinLength', '38', '2', 'integer', '模块名长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('15', 'MaxLength', '38', '50', 'integer', '模块名长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('16', 'Alpha', '39', '', 'boolean', '控制器名只能由英文字母组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('17', 'MinLength', '39', '2', 'integer', '控制器名长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('18', 'MaxLength', '39', '12', 'integer', '控制器名长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('19', 'Alpha', '40', '', 'boolean', '类名只能由英文字母组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('20', 'MinLength', '40', '2', 'integer', '类名长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('21', 'MaxLength', '40', '12', 'integer', '类名长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('22', 'Alpha', '41', '', 'boolean', '数据列表行动名只能由英文字母组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('23', 'MinLength', '41', '2', 'integer', '数据列表行动名长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('24', 'MaxLength', '41', '12', 'integer', '数据列表行动名长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('25', 'Alpha', '42', '', 'boolean', '数据详情行动名只能由英文字母组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('26', 'MinLength', '42', '2', 'integer', '数据详情行动名长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('27', 'MaxLength', '42', '12', 'integer', '数据详情行动名长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('28', 'Alpha', '43', '', 'boolean', '新增数据行动名只能由英文字母组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('29', 'MinLength', '43', '2', 'integer', '新增数据行动名长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('30', 'MaxLength', '43', '12', 'integer', '新增数据行动名长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('31', 'Alpha', '44', '', 'boolean', '编辑数据行动名只能由英文字母组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('32', 'MinLength', '44', '2', 'integer', '编辑数据行动名长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('33', 'MaxLength', '44', '12', 'integer', '编辑数据行动名长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('34', 'Alpha', '45', '', 'boolean', '删除数据行动名只能由英文字母组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('35', 'MinLength', '45', '2', 'integer', '删除数据行动名长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('36', 'MaxLength', '45', '12', 'integer', '删除数据行动名长度不能大于%option%个字符.', '3', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('37', 'InArray', '46', '', 'array', '必须选择列表每行操作按钮，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('38', 'InArray', '52', '', 'array', '必须选择移至回收站，值只能是%s.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('39', 'Mail', '49', '', 'boolean', '邮箱格式不正确.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('40', 'NotEmpty', '48', '', 'boolean', '必须填写作者姓名，代码注释用.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('41', 'AlphaNum', '61', '', 'boolean', '外联其他表的字段名只能由英文字母、数字或下划线组成.', '1', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('42', 'MinLength', '61', '2', 'integer', '外联其他表的字段名长度不能小于%option%个字符.', '2', 'all');
INSERT INTO `tr_builder_field_validators` VALUES ('43', 'MaxLength', '61', '50', 'integer', '外联其他表的字段名长度不能大于%option%个字符.', '3', 'all');

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
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8 COMMENT='表单字段表';

-- ----------------------------
-- Records of tr_builder_fields
-- ----------------------------
INSERT INTO `tr_builder_fields` VALUES ('1', 'builder_id', '5', 'y', 'y', '主键ID', '1', '1', '7', '1', '主键ID', '', 'n', 'n', 'y', '1000', 'n', '1', 'n', '1', 'y', '1');
INSERT INTO `tr_builder_fields` VALUES ('2', 'builder_name', '100', 'n', 'n', '生成代码名', '1', '1', '1', '2', '生成代码名', '', 'y', 'n', 'y', '2', 'y', '2', 'y', '2', 'y', '2');
INSERT INTO `tr_builder_fields` VALUES ('3', 'tbl_name', '100', 'n', 'n', '表名', '1', '1', '1', '3', '表名', '', 'y', 'n', 'y', '3', 'y', '3', 'y', '3', 'y', '3');
INSERT INTO `tr_builder_fields` VALUES ('4', 'tbl_profile', 'y|n', 'n', 'n', '是否生成扩展表', '1', '1', '3', '4', '是否生成扩展表', '', 'n', 'n', 'y', '4', 'y', '4', 'y', '4', 'y', '4');
INSERT INTO `tr_builder_fields` VALUES ('5', 'tbl_engine', 'MyISAM|InnoDB', 'n', 'n', '表引擎', '1', '1', '4', '5', '表引擎', '', 'n', 'n', 'y', '5', 'y', '5', 'y', '5', 'y', '5');
INSERT INTO `tr_builder_fields` VALUES ('6', 'tbl_charset', 'utf8|gbk|gb2312', 'n', 'n', '表编码', '1', '1', '4', '6', '表编码', '', 'n', 'n', 'y', '6', 'y', '6', 'y', '6', 'y', '6');
INSERT INTO `tr_builder_fields` VALUES ('7', 'tbl_comment', '200', 'n', 'n', '表描述', '1', '1', '1', '7', '表描述', '', 'y', 'n', 'y', '7', 'y', '7', 'y', '7', 'y', '7');
INSERT INTO `tr_builder_fields` VALUES ('8', 'app_name', '100', 'n', 'n', '应用名', '1', '1', '1', '8', '应用名', '', 'y', 'n', 'y', '8', 'y', '8', 'y', '8', 'y', '8');
INSERT INTO `tr_builder_fields` VALUES ('9', 'mod_name', '100', 'n', 'n', '模块名', '1', '1', '1', '9', '模块名', '', 'y', 'n', 'y', '9', 'y', '9', 'y', '9', 'y', '9');
INSERT INTO `tr_builder_fields` VALUES ('10', 'ctrl_name', '100', 'n', 'n', '控制器名，默认和省略前缀的表名相同', '1', '1', '1', '10', '控制器名，默认和省略前缀的表名相同', '', 'y', 'n', 'y', '10', 'y', '10', 'y', '10', 'y', '10');
INSERT INTO `tr_builder_fields` VALUES ('11', 'cls_name', '100', 'n', 'n', '类名', '1', '1', '1', '11', '类名', '', 'y', 'n', 'y', '11', 'y', '11', 'y', '11', 'y', '11');
INSERT INTO `tr_builder_fields` VALUES ('12', 'act_index_name', '100', 'n', 'n', '行动名-数据列表', '1', '1', '1', '12', '行动名-数据列表', '', 'y', 'n', 'y', '12', 'y', '12', 'y', '12', 'y', '12');
INSERT INTO `tr_builder_fields` VALUES ('13', 'act_view_name', '100', 'n', 'n', '行动名-数据详情', '1', '1', '1', '13', '行动名-数据详情', '', 'y', 'n', 'y', '13', 'y', '13', 'y', '13', 'y', '13');
INSERT INTO `tr_builder_fields` VALUES ('14', 'act_create_name', '100', 'n', 'n', '行动名-新增数据', '1', '1', '1', '14', '行动名-新增数据', '', 'y', 'n', 'y', '14', 'y', '14', 'y', '14', 'y', '14');
INSERT INTO `tr_builder_fields` VALUES ('15', 'act_modify_name', '100', 'n', 'n', '行动名-编辑数据', '1', '1', '1', '15', '行动名-编辑数据', '', 'y', 'n', 'y', '15', 'y', '15', 'y', '15', 'y', '15');
INSERT INTO `tr_builder_fields` VALUES ('16', 'act_remove_name', '100', 'n', 'n', '行动名-删除数据', '1', '1', '1', '16', '行动名-删除数据', '', 'y', 'n', 'y', '16', 'y', '16', 'y', '16', 'y', '16');
INSERT INTO `tr_builder_fields` VALUES ('17', 'index_row_btns', '100', 'n', 'n', '数据列表每行操作Btn，编辑：pencil、移至回收站：trash、彻底删除：remove', '1', '1', '1', '17', '数据列表每行操作Btn，编辑：pencil、移至回收站：trash、彻底删除：remove', '', 'y', 'n', 'y', '17', 'y', '17', 'y', '17', 'y', '17');
INSERT INTO `tr_builder_fields` VALUES ('18', 'description', '', 'n', 'n', '描述', '1', '1', '1', '18', '描述', '', 'y', 'n', 'y', '18', 'y', '18', 'y', '18', 'y', '18');
INSERT INTO `tr_builder_fields` VALUES ('19', 'author_name', '100', 'n', 'n', '作者姓名，代码注释用', '1', '1', '1', '19', '作者姓名，代码注释用', '', 'y', 'n', 'y', '19', 'y', '19', 'y', '19', 'y', '19');
INSERT INTO `tr_builder_fields` VALUES ('20', 'author_mail', '100', 'n', 'n', '作者邮箱，代码注释用', '1', '1', '1', '20', '作者邮箱，代码注释用', '', 'y', 'n', 'y', '20', 'y', '20', 'y', '20', 'y', '20');
INSERT INTO `tr_builder_fields` VALUES ('21', 'dt_created', '', 'n', 'n', '创建时间', '1', '1', '1', '21', '创建时间', '', 'y', 'n', 'y', '21', 'y', '21', 'y', '21', 'y', '21');
INSERT INTO `tr_builder_fields` VALUES ('22', 'dt_modified', '', 'n', 'n', '上次编辑时间', '1', '1', '1', '22', '上次编辑时间', '', 'y', 'n', 'y', '22', 'y', '22', 'y', '22', 'y', '22');
INSERT INTO `tr_builder_fields` VALUES ('23', 'trash', 'y|n', 'n', 'n', '是否删除', '1', '1', '3', '23', '是否删除', '', 'n', 'n', 'y', '23', 'y', '23', 'y', '23', 'y', '23');
INSERT INTO `tr_builder_fields` VALUES ('24', 'type_id', '5', 'y', 'y', '主键ID', '2', '1', '7', '1', '主键ID', '', 'n', 'n', 'y', '1000', 'n', '1', 'n', '1', 'y', '1');
INSERT INTO `tr_builder_fields` VALUES ('25', 'type_name', '100', 'n', 'n', '类型名，单行文本、多行文本、密码、开关选项卡、提交按钮等', '2', '1', '1', '2', '类型名，单行文本、多行文本、密码、开关选项卡、提交按钮等', '', 'y', 'n', 'y', '2', 'y', '2', 'y', '2', 'y', '2');
INSERT INTO `tr_builder_fields` VALUES ('26', 'form_type', '100', 'n', 'n', '表单类型名，HTML：text、password、button、radio等；用户自定义：ckeditor、datetime等', '2', '1', '1', '3', '表单类型名，HTML：text、password、button、radio等；用户自定义：ckeditor、datetime等', '', 'y', 'n', 'y', '3', 'y', '3', 'y', '3', 'y', '3');
INSERT INTO `tr_builder_fields` VALUES ('27', 'field_type', '100', 'n', 'n', '表字段类型，INT、VARCHAR、CHAR、TEXT等', '2', '1', '1', '4', '表字段类型，INT、VARCHAR、CHAR、TEXT等', '', 'y', 'n', 'y', '4', 'y', '4', 'y', '4', 'y', '4');
INSERT INTO `tr_builder_fields` VALUES ('28', 'category', 'text|option|button', 'n', 'n', '所属分类，text：文本类、option：选项类、button：按钮类', '2', '1', '4', '5', '所属分类，text：文本类、option：选项类、button：按钮类', '', 'n', 'n', 'y', '5', 'y', '5', 'y', '5', 'y', '5');
INSERT INTO `tr_builder_fields` VALUES ('29', 'sort', '5', 'n', 'y', '排序', '2', '1', '1', '6', '排序', '', 'y', 'n', 'y', '6', 'y', '6', 'y', '6', 'y', '6');
INSERT INTO `tr_builder_fields` VALUES ('30', 'builder_id', '5', 'y', 'y', '主键ID', '3', '1', '8', '1', 'ID', '', 'n', 'n', 'y', '1000', 'n', '1', 'n', '1', 'y', '1');
INSERT INTO `tr_builder_fields` VALUES ('31', 'builder_name', '100', 'n', 'n', '生成代码名', '3', '1', '1', '2', '生成代码名', '生成代码名由6~50个字符组成.', 'y', 'n', 'y', '2', 'y', '2', 'y', '2', 'y', '2');
INSERT INTO `tr_builder_fields` VALUES ('32', 'tbl_name', '100', 'n', 'n', '表名', '3', '1', '1', '3', '表名', '表名由2~30个英文字母、数字或下划线组成.', 'y', 'n', 'y', '3', 'y', '3', 'y', '3', 'y', '3');
INSERT INTO `tr_builder_fields` VALUES ('33', 'tbl_profile', 'y|n', 'n', 'n', '是否生成扩展表', '3', '1', '3', '4', '是否生成扩展表', '', 'n', 'n', 'y', '4', 'y', '4', 'y', '4', 'y', '4');
INSERT INTO `tr_builder_fields` VALUES ('34', 'tbl_engine', 'MyISAM|InnoDB', 'n', 'n', '表引擎', '3', '1', '4', '5', '表引擎', '', 'n', 'n', 'y', '5', 'y', '5', 'y', '5', 'y', '5');
INSERT INTO `tr_builder_fields` VALUES ('35', 'tbl_charset', 'utf8|gbk|gb2312', 'n', 'n', '表编码', '3', '1', '4', '6', '表编码', '', 'n', 'n', 'y', '6', 'y', '6', 'y', '6', 'y', '6');
INSERT INTO `tr_builder_fields` VALUES ('36', 'tbl_comment', '200', 'n', 'n', '表描述', '3', '1', '1', '7', '表描述', '', 'y', 'n', 'y', '7', 'y', '7', 'y', '7', 'y', '7');
INSERT INTO `tr_builder_fields` VALUES ('37', 'app_name', '100', 'n', 'n', '应用名', '3', '1', '1', '8', '应用名', '应用名由2~50个英文字母组成.', 'y', 'n', 'y', '8', 'y', '8', 'y', '8', 'y', '8');
INSERT INTO `tr_builder_fields` VALUES ('38', 'mod_name', '100', 'n', 'n', '模块名', '3', '1', '1', '9', '模块名', '模块名由2~50个英文字母组成.', 'y', 'n', 'y', '9', 'y', '9', 'y', '9', 'y', '9');
INSERT INTO `tr_builder_fields` VALUES ('39', 'ctrl_name', '100', 'n', 'n', '控制器名，默认和省略前缀的表名相同', '3', '1', '1', '10', '控制器名', '控制器名由2~12个英文字母组成.', 'y', 'n', 'y', '10', 'y', '10', 'y', '10', 'y', '10');
INSERT INTO `tr_builder_fields` VALUES ('40', 'cls_name', '100', 'n', 'n', '类名', '3', '1', '1', '11', '类名', '类名由2~12个英文字母组成.', 'y', 'n', 'y', '11', 'y', '11', 'y', '11', 'y', '11');
INSERT INTO `tr_builder_fields` VALUES ('41', 'act_index_name', '100', 'n', 'n', '行动名-数据列表', '3', '2', '1', '12', '数据列表行动名', '数据列表行动名由2~12个英文字母组成.', 'y', 'n', 'y', '12', 'y', '12', 'y', '12', 'y', '12');
INSERT INTO `tr_builder_fields` VALUES ('42', 'act_view_name', '100', 'n', 'n', '行动名-数据详情', '3', '2', '1', '13', '数据详情行动名', '数据详情行动名由2~12个英文字母组成.', 'y', 'n', 'y', '13', 'y', '13', 'y', '13', 'y', '13');
INSERT INTO `tr_builder_fields` VALUES ('43', 'act_create_name', '100', 'n', 'n', '行动名-新增数据', '3', '2', '1', '14', '新增数据行动名', '新增数据行动名由2~12个英文字母组成.', 'y', 'n', 'y', '14', 'y', '14', 'y', '14', 'y', '14');
INSERT INTO `tr_builder_fields` VALUES ('44', 'act_modify_name', '100', 'n', 'n', '行动名-编辑数据', '3', '2', '1', '15', '编辑数据行动名', '编辑数据行动名由2~12个英文字母组成.', 'y', 'n', 'y', '15', 'y', '15', 'y', '15', 'y', '15');
INSERT INTO `tr_builder_fields` VALUES ('45', 'act_remove_name', '100', 'n', 'n', '行动名-删除数据', '3', '2', '1', '16', '删除数据行动名', '删除数据行动名由2~12个英文字母组成.', 'y', 'n', 'y', '16', 'y', '16', 'y', '16', 'y', '16');
INSERT INTO `tr_builder_fields` VALUES ('46', 'index_row_btns', 'pencil|trash|remove', 'n', 'n', '数据列表每行操作Btn，编辑：pencil、移至回收站：trash、彻底删除：remove', '3', '1', '1', '17', '列表每行操作按钮', '', 'y', 'n', 'y', '17', 'y', '17', 'y', '17', 'y', '17');
INSERT INTO `tr_builder_fields` VALUES ('47', 'description', '', 'n', 'n', '描述', '3', '1', '9', '18', '描述', '', 'n', 'n', 'y', '18', 'y', '18', 'y', '18', 'y', '18');
INSERT INTO `tr_builder_fields` VALUES ('48', 'author_name', '100', 'n', 'n', '作者姓名，代码注释用', '3', '1', '1', '19', '作者姓名，代码注释用', '作者姓名，代码注释用，由2~50个字符组成.', 'y', 'n', 'y', '19', 'y', '19', 'y', '19', 'y', '19');
INSERT INTO `tr_builder_fields` VALUES ('49', 'author_mail', '100', 'n', 'n', '作者邮箱，代码注释用', '3', '1', '1', '20', '作者邮箱', '作者邮箱，代码注释用，由2~50个字符组成.', 'y', 'n', 'y', '20', 'y', '20', 'y', '20', 'y', '20');
INSERT INTO `tr_builder_fields` VALUES ('50', 'dt_created', '', 'n', 'n', '创建时间', '3', '3', '1', '21', '创建时间', '', 'n', 'y', 'y', '21', 'y', '21', 'y', '21', 'y', '21');
INSERT INTO `tr_builder_fields` VALUES ('51', 'dt_modified', '', 'n', 'n', '上次编辑时间', '3', '3', '1', '22', '上次编辑时间', '', 'n', 'y', 'y', '22', 'y', '22', 'y', '22', 'y', '22');
INSERT INTO `tr_builder_fields` VALUES ('52', 'trash', 'y|n', 'n', 'n', '是否删除', '3', '1', '3', '23', '移至回收站', '', 'n', 'n', 'y', '23', 'n', '23', 'n', '23', 'n', '23');
INSERT INTO `tr_builder_fields` VALUES ('53', 'validator_id', '10', 'y', 'y', '主键ID', '4', '1', '7', '1', '主键ID', '', 'n', 'n', 'y', '1000', 'n', '1', 'n', '1', 'y', '1');
INSERT INTO `tr_builder_fields` VALUES ('54', 'validator_name', '100', 'n', 'n', '验证类名', '4', '1', '1', '2', '验证类名', '', 'y', 'n', 'y', '2', 'y', '2', 'y', '2', 'y', '2');
INSERT INTO `tr_builder_fields` VALUES ('55', 'field_id', '10', 'n', 'y', '表单字段ID', '4', '1', '1', '3', '表单字段ID', '', 'y', 'n', 'y', '3', 'y', '3', 'y', '3', 'y', '3');
INSERT INTO `tr_builder_fields` VALUES ('56', 'options', '100', 'n', 'n', '验证时对比值，可以是布尔类型、整型、字符型、数组序列化', '4', '1', '1', '4', '验证时对比值，可以是布尔类型、整型、字符型、数组序列化', '', 'y', 'n', 'y', '4', 'y', '4', 'y', '4', 'y', '4');
INSERT INTO `tr_builder_fields` VALUES ('57', 'option_category', '0', 'n', 'n', '验证时对比值类型', '4', '1', '4', '5', '验证时对比值类型', '', 'n', 'n', 'y', '5', 'y', '5', 'y', '5', 'y', '5');
INSERT INTO `tr_builder_fields` VALUES ('58', 'message', '100', 'n', 'n', '出错提示消息', '4', '1', '1', '6', '出错提示消息', '', 'y', 'n', 'y', '6', 'y', '6', 'y', '6', 'y', '6');
INSERT INTO `tr_builder_fields` VALUES ('59', 'sort', '5', 'n', 'y', '排序', '4', '1', '1', '7', '排序', '', 'y', 'n', 'y', '7', 'y', '7', 'y', '7', 'y', '7');
INSERT INTO `tr_builder_fields` VALUES ('60', 'when', 'all|create|modify', 'n', 'n', '验证环境，任意时候验证、只在新增数据时验证、只在编辑数据时验证', '4', '1', '4', '8', '验证环境，任意时候验证、只在新增数据时验证、只在编辑数据时验证', '', 'n', 'n', 'y', '8', 'y', '8', 'y', '8', 'y', '8');
INSERT INTO `tr_builder_fields` VALUES ('61', 'fk_column', '100', 'n', 'n', '外联其他表的字段名', '3', '1', '1', '11', '外联其他表的字段名', '外联其他表的字段名由2~50个英文字母、数字或下划线组成.', 'n', 'n', 'n', '0', 'y', '11', 'y', '11', 'n', '0');

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='表单字段类型表';

-- ----------------------------
-- Records of tr_builder_types
-- ----------------------------
INSERT INTO `tr_builder_types` VALUES ('1', '单行文本', 'text', 'VARCHAR', 'text', '1');
INSERT INTO `tr_builder_types` VALUES ('2', '密码', 'password', 'CHAR', 'text', '2');
INSERT INTO `tr_builder_types` VALUES ('3', '开关选项卡', 'switch', 'ENUM', 'option', '3');
INSERT INTO `tr_builder_types` VALUES ('4', '单选', 'radio', 'ENUM', 'option', '4');
INSERT INTO `tr_builder_types` VALUES ('5', '多选', 'checkbox', 'VARCHAR', 'option', '5');
INSERT INTO `tr_builder_types` VALUES ('6', '单选下拉框', 'select', 'INT', 'option', '6');
INSERT INTO `tr_builder_types` VALUES ('7', '隐藏文本框(VARCHAR)', 'hidden', 'VARCHAR', 'text', '7');
INSERT INTO `tr_builder_types` VALUES ('8', '隐藏文本框(INT)', 'hidden', 'INT', 'text', '8');
INSERT INTO `tr_builder_types` VALUES ('9', '多行文本', 'textarea', 'TEXT', 'text', '9');
INSERT INTO `tr_builder_types` VALUES ('10', '上传文件', 'file', 'VARCHAR', 'text', '10');

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
  `cls_name` varchar(100) NOT NULL DEFAULT '' COMMENT '类名',
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
  `fk_column` varchar(100) NOT NULL DEFAULT '' COMMENT '外联其他表的字段名',
  PRIMARY KEY (`builder_id`),
  KEY `builder_name` (`builder_name`),
  KEY `tbl_name` (`tbl_name`),
  KEY `tbl_profile` (`tbl_profile`),
  KEY `tbl_engine` (`tbl_engine`),
  KEY `tbl_charset` (`tbl_charset`),
  KEY `app_mod_ctrl` (`app_name`,`mod_name`,`ctrl_name`),
  KEY `trash` (`trash`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='生成代码表';

-- ----------------------------
-- Records of tr_builders
-- ----------------------------
INSERT INTO `tr_builders` VALUES ('2', '表单字段类型表', 'builder_types', 'n', 'InnoDB', 'utf8', '表单字段类型表', 'undefined', 'undefined', 'types', 'types', 'index', 'view', 'create', 'modify', 'remove', 'pencil,remove', '', '', '', '2014-03-26 13:26:14', '0000-00-00 00:00:00', 'n', '');
INSERT INTO `tr_builders` VALUES ('3', '生成代码', 'builders', 'n', 'InnoDB', 'utf8', '生成代码表', 'administrator', 'builder', 'index', 'builders', 'index', 'view', 'create', 'modify', 'remove', 'pencil,trash,remove', '', '宋欢', 'trotri@yeah.net', '2014-03-26 13:26:31', '2014-03-31 15:29:47', 'n', '');
INSERT INTO `tr_builders` VALUES ('4', '表单字段验证表', 'builder_field_validators', 'n', 'InnoDB', 'utf8', '表单字段验证表', 'undefined', 'undefined', 'validators', 'validators', 'index', 'view', 'create', 'modify', 'remove', 'pencil,remove', '', '', '', '2014-03-27 17:41:20', '0000-00-00 00:00:00', 'n', '');

-- ----------------------------
-- Table structure for `tr_post_categories`
-- ----------------------------
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

-- ----------------------------
-- Records of tr_post_categories
-- ----------------------------

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
  `module_tblname` varchar(50) NOT NULL DEFAULT '' COMMENT '类别表名',
  `forbidden` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否禁用',
  `description` text COMMENT '描述',
  PRIMARY KEY (`module_id`),
  UNIQUE KEY `module_tblname` (`module_tblname`),
  KEY `module_name` (`module_name`),
  KEY `forbidden` (`forbidden`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='文档类别模型表';

-- ----------------------------
-- Records of tr_post_modules
-- ----------------------------
INSERT INTO `tr_post_modules` VALUES ('1', '系统文档', 'posts', 'n', null);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文档扩展表';

-- ----------------------------
-- Records of tr_post_profile
-- ----------------------------

-- ----------------------------
-- Table structure for `tr_posts`
-- ----------------------------
DROP TABLE IF EXISTS `tr_posts`;
CREATE TABLE `tr_posts` (
  `post_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '文档标题',
  `category_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '所属类别ID',
  `content` longtext COMMENT '文档内容',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `keywords` varchar(100) NOT NULL DEFAULT '' COMMENT '内容关键字',
  `description` varchar(500) NOT NULL DEFAULT '' COMMENT '内容摘要',
  `little_picture` varchar(250) NOT NULL DEFAULT '' COMMENT '缩略图地址',
  `is_head` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否头条',
  `is_recommend` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否推荐',
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
  KEY `trash_public_head_sort` (`trash`,`is_public`,`is_head`,`sort`),
  KEY `trash_public_recommend_sort` (`trash`,`is_public`,`is_recommend`,`sort`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统自带的文档管理表，用户可以通过模型添加自己的内容管理表';

-- ----------------------------
-- Records of tr_posts
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
-- Table structure for `tr_system_options`
-- ----------------------------
DROP TABLE IF EXISTS `tr_system_options`;
CREATE TABLE `tr_system_options` (
  `option_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `option_category` varchar(64) NOT NULL DEFAULT '' COMMENT '配置类别',
  `option_key` varchar(64) NOT NULL DEFAULT '' COMMENT '配置Key',
  `option_value` longtext COMMENT '配置Value',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `uk_cat_key` (`option_category`,`option_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='站点配置表';

-- ----------------------------
-- Records of tr_system_options
-- ----------------------------

-- ----------------------------
-- Table structure for `tr_user_amcas`
-- ----------------------------
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户可访问的事件表';

-- ----------------------------
-- Records of tr_user_amcas
-- ----------------------------
INSERT INTO `tr_user_amcas` VALUES ('1', '0', 'administrator', 'administrator', '0', 'app');

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
  UNIQUE KEY `group_name` (`group_name`),
  KEY `group_pid` (`group_pid`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='用户分组表';

-- ----------------------------
-- Records of tr_user_groups
-- ----------------------------
INSERT INTO `tr_user_groups` VALUES ('1', '0', 'Public', '0', '', '公开组，未登录用户拥有该权限');
INSERT INTO `tr_user_groups` VALUES ('2', '1', 'Guest', '1', null, '普通会员');
INSERT INTO `tr_user_groups` VALUES ('3', '1', 'Manager', '2', null, '普通管理员');
INSERT INTO `tr_user_groups` VALUES ('4', '1', 'Registered', '3', null, '记名作者');
INSERT INTO `tr_user_groups` VALUES ('5', '1', 'Super Users', '4', null, '超级会员');
INSERT INTO `tr_user_groups` VALUES ('6', '3', 'Administrator', '1', null, '超级管理员');
INSERT INTO `tr_user_groups` VALUES ('7', '4', 'Author', '1', null, '普通作者');
INSERT INTO `tr_user_groups` VALUES ('8', '7', 'Editor', '1', null, '高级作者');
INSERT INTO `tr_user_groups` VALUES ('9', '8', 'Publisher', '1', null, '出版者');

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
  `group_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '主键ID',
  PRIMARY KEY (`user_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户和用户组关联表';

-- ----------------------------
-- Records of tr_user_usergroups_map
-- ----------------------------
INSERT INTO `tr_user_usergroups_map` VALUES ('1', '1');

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
  UNIQUE KEY `login_name` (`login_name`),
  KEY `login_type` (`login_type`),
  KEY `user_name` (`user_name`),
  KEY `user_mail` (`user_mail`),
  KEY `user_phone` (`user_phone`),
  KEY `valid_mail` (`valid_mail`),
  KEY `valid_phone` (`valid_phone`),
  KEY `forbidden` (`forbidden`),
  KEY `trash` (`trash`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户主表';

-- ----------------------------
-- Records of tr_users
-- ----------------------------
INSERT INTO `tr_users` VALUES ('1', 'admini', 'name', '793c028870eb41b50a45c14249cf011b', 'fRBzx3', '1111233eee', '', '', '2014-02-19 15:15:02', '2014-02-19 15:15:02', '0000-00-00 00:00:00', '0', '0', '0', '1', '0', 'n', 'n', 'n', 'n');
