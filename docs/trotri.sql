/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50141
Source Host           : localhost:3306
Source Database       : trotri

Target Server Type    : MYSQL
Target Server Version : 50141
File Encoding         : 65001

Date: 2014-05-26 19:39:52
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
INSERT INTO `tr_builder_field_groups` VALUES ('2', 'act', '行动名', '2', '1', '');
INSERT INTO `tr_builder_field_groups` VALUES ('3', 'system', '系统信息', '2', '2', '');

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
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8 COMMENT='表单字段验证表';

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
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COMMENT='表单字段表';

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
INSERT INTO `tr_builder_fields` VALUES ('20', 'fk_column', '100', 'n', 'n', '外联其他表的字段名', '2', '1', '1', '14', '外联其他表的字段名', '外联其他表的字段名由2~50个英文字母、数字或下划线组成.', 'y', 'n', 'n', '14', 'y', '14', 'y', '14', 'y', '14');
INSERT INTO `tr_builder_fields` VALUES ('21', 'act_index_name', '100', 'n', 'n', '行动名-数据列表', '2', '1', '1', '15', '数据列表行动名', '数据列表行动名由2~12个英文字母组成.', 'y', 'n', 'n', '15', 'y', '15', 'y', '15', 'y', '15');
INSERT INTO `tr_builder_fields` VALUES ('22', 'act_view_name', '100', 'n', 'n', '行动名-数据详情', '2', '1', '1', '16', '数据详情行动名', '数据详情行动名由2~12个英文字母组成.', 'y', 'n', 'n', '16', 'y', '16', 'y', '16', 'y', '16');
INSERT INTO `tr_builder_fields` VALUES ('23', 'act_create_name', '100', 'n', 'n', '行动名-新增数据', '2', '1', '1', '17', '新增数据行动名', '新增数据行动名由2~12个英文字母组成.', 'y', 'n', 'n', '17', 'y', '17', 'y', '17', 'y', '17');
INSERT INTO `tr_builder_fields` VALUES ('24', 'act_modify_name', '100', 'n', 'n', '行动名-编辑数据', '2', '1', '1', '18', '编辑数据行动名', '编辑数据行动名由2~12个英文字母组成.', 'y', 'n', 'n', '18', 'y', '18', 'y', '18', 'y', '18');
INSERT INTO `tr_builder_fields` VALUES ('25', 'act_remove_name', '100', 'n', 'n', '行动名-删除数据', '2', '1', '1', '19', '删除数据行动名', '删除数据行动名由2~12个英文字母组成.', 'y', 'n', 'n', '19', 'y', '19', 'y', '19', 'y', '19');
INSERT INTO `tr_builder_fields` VALUES ('26', 'index_row_btns', '100', 'n', 'n', '数据列表每行操作Btn，编辑：pencil、移至回收站：trash、彻底删除：remove', '2', '1', '1', '20', '数据列表每行操作Btn', '', 'y', 'n', 'n', '20', 'y', '20', 'y', '20', 'y', '20');
INSERT INTO `tr_builder_fields` VALUES ('27', 'description', '', 'n', 'n', '描述', '2', '1', '1', '21', '描述', '', 'y', 'n', 'n', '21', 'y', '21', 'y', '21', 'y', '21');
INSERT INTO `tr_builder_fields` VALUES ('28', 'author_name', '100', 'n', 'n', '作者姓名，代码注释用', '2', '1', '1', '22', '作者姓名，代码注释用', '作者姓名，代码注释用由2~50个字符组成.', 'y', 'n', 'n', '22', 'y', '22', 'y', '22', 'y', '22');
INSERT INTO `tr_builder_fields` VALUES ('29', 'author_mail', '100', 'n', 'n', '作者邮箱，代码注释用', '2', '1', '1', '23', '作者邮箱，代码注释用', '作者邮箱，代码注释用由2~50个字符组成.', 'y', 'n', 'n', '23', 'y', '23', 'y', '23', 'y', '23');
INSERT INTO `tr_builder_fields` VALUES ('30', 'dt_created', '', 'n', 'n', '创建时间', '2', '1', '1', '24', '创建时间', '', 'y', 'n', 'n', '24', 'y', '24', 'y', '24', 'y', '24');
INSERT INTO `tr_builder_fields` VALUES ('31', 'dt_modified', '', 'n', 'n', '上次编辑时间', '2', '1', '1', '25', '上次编辑时间', '', 'y', 'n', 'n', '25', 'y', '25', 'y', '25', 'y', '25');
INSERT INTO `tr_builder_fields` VALUES ('32', 'trash', 'y|n', 'n', 'n', '是否删除', '2', '1', '4', '26', '移至回收站', '', 'n', 'n', 'n', '26', 'n', '26', 'n', '26', 'y', '26');
INSERT INTO `tr_builder_fields` VALUES ('33', 'group_id', '5', 'y', 'y', '主键ID', '3', '1', '9', '1', '主键ID', '', 'n', 'n', 'y', '1000', 'n', '1', 'n', '1', 'y', '1');
INSERT INTO `tr_builder_fields` VALUES ('34', 'group_name', '100', 'n', 'n', '组名', '3', '1', '1', '2', '组名', '', 'y', 'n', 'y', '2', 'y', '2', 'y', '2', 'y', '2');
INSERT INTO `tr_builder_fields` VALUES ('35', 'prompt', '100', 'n', 'n', '提示', '3', '1', '1', '3', '提示', '', 'y', 'n', 'y', '3', 'y', '3', 'y', '3', 'y', '3');
INSERT INTO `tr_builder_fields` VALUES ('36', 'builder_id', '5', 'n', 'y', '生成代码ID', '3', '1', '2', '4', '生成代码ID', '', 'y', 'n', 'y', '4', 'y', '4', 'y', '4', 'y', '4');
INSERT INTO `tr_builder_fields` VALUES ('37', 'sort', '5', 'n', 'y', '排序', '3', '1', '2', '5', '排序', '', 'y', 'n', 'y', '5', 'y', '5', 'y', '5', 'y', '5');
INSERT INTO `tr_builder_fields` VALUES ('38', 'description', '', 'n', 'n', '描述', '3', '1', '1', '6', '描述', '', 'y', 'n', 'y', '6', 'y', '6', 'y', '6', 'y', '6');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='生成代码表';

-- ----------------------------
-- Records of tr_builders
-- ----------------------------
INSERT INTO `tr_builders` VALUES ('1', '表单字段类型', 'builder_types', 'n', 'InnoDB', 'utf8', '表单字段类型表', 'dynamic', 'builders', 'programmer', 'builder', 'types', 'types', '', 'index', 'view', 'create', 'modify', 'remove', 'pencil,remove', '', '宋欢', 'trotri@yeah.net', '2014-05-23 13:31:46', '2014-05-26 15:23:37', 'n');
INSERT INTO `tr_builders` VALUES ('2', '生成代码', 'builders', 'n', 'InnoDB', 'utf8', '生成代码表', 'dynamic', 'builders', 'programmer', 'builder', 'builders', 'builders', '', 'index', 'view', 'create', 'modify', 'remove', 'pencil,remove', '', '宋欢', 'trotri@yeah.net', '2014-05-26 15:23:50', '0000-00-00 00:00:00', 'n');
INSERT INTO `tr_builders` VALUES ('3', '表单字段组', 'builder_field_groups', 'n', 'InnoDB', 'utf8', '表单字段组表', 'dynamic', 'builders', 'programmer', 'builder', 'groups', 'groups', '', 'index', 'view', 'create', 'modify', 'remove', 'pencil,remove', '', '宋欢', 'trotri@yeah.net', '2014-05-26 15:57:26', '0000-00-00 00:00:00', 'n');

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
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8 COMMENT='用户可访问的事件表';

-- ----------------------------
-- Records of tr_user_amcas
-- ----------------------------
INSERT INTO `tr_user_amcas` VALUES ('1', '0', 'administrator', 'administrator', '0', 'app');
INSERT INTO `tr_user_amcas` VALUES ('2', '1', 'system', '系统管理', '1', 'mod');
INSERT INTO `tr_user_amcas` VALUES ('4', '1', 'ucenter', '用户中心', '4', 'mod');
INSERT INTO `tr_user_amcas` VALUES ('5', '2', 'site', '系统管理', '0', 'ctrl');
INSERT INTO `tr_user_amcas` VALUES ('6', '2', 'tools', '系统工具', '1', 'ctrl');
INSERT INTO `tr_user_amcas` VALUES ('13', '4', 'amcas', '用户可访问的事件', '0', 'ctrl');
INSERT INTO `tr_user_amcas` VALUES ('14', '4', 'groups', '用户组', '1', 'ctrl');
INSERT INTO `tr_user_amcas` VALUES ('15', '0', 'test', '测试', '0', 'app');
INSERT INTO `tr_user_amcas` VALUES ('20', '1', '\'system\'', '\'\'', '0', '');
INSERT INTO `tr_user_amcas` VALUES ('21', '1', '\'systemaaa\'', '\'\'', '0', '');
INSERT INTO `tr_user_amcas` VALUES ('22', '1', '\'syste\'', '\'\'', '0', '');
INSERT INTO `tr_user_amcas` VALUES ('23', '1', '\'aa\'', '\'\'', '0', '');
INSERT INTO `tr_user_amcas` VALUES ('24', '1', '\'aaa\'', '\'\'', '0', '');
INSERT INTO `tr_user_amcas` VALUES ('35', '1', 'aaa', 'aaa', '4', 'mod');
INSERT INTO `tr_user_amcas` VALUES ('36', '1', 'aaab', 'aaa', '4', 'mod');
INSERT INTO `tr_user_amcas` VALUES ('37', '1', 'aaabc', 'aaa', '4', 'mod');
INSERT INTO `tr_user_amcas` VALUES ('38', '1', 'aaaa', 'af', '4', 'mod');
INSERT INTO `tr_user_amcas` VALUES ('40', '15', 'aabb', 'abb', '4', 'mod');
INSERT INTO `tr_user_amcas` VALUES ('44', '15', 'systemab', 'aa', '3', 'mod');
INSERT INTO `tr_user_amcas` VALUES ('45', '0', 'ucenter', '用户中心', '0', 'app');
INSERT INTO `tr_user_amcas` VALUES ('46', '1', 'afad', 'f33', '3', 'mod');
INSERT INTO `tr_user_amcas` VALUES ('47', '45', 'user', '用户管理', '1', 'mod');
INSERT INTO `tr_user_amcas` VALUES ('48', '45', 'system', '系统设置', '2', 'mod');
INSERT INTO `tr_user_amcas` VALUES ('53', '47', 'amcas', '用户可访问的事件', '0', 'ctrl');
INSERT INTO `tr_user_amcas` VALUES ('54', '48', 'site', '系统管理', '0', 'ctrl');

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
INSERT INTO `tr_user_groups` VALUES ('1', '0', 'Public', '0', 'a:2:{s:13:\"administrator\";a:1:{s:7:\"builder\";a:3:{s:6:\"schema\";a:2:{i:0;i:2;i:1;i:4;}s:5:\"types\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}s:10:\"validators\";a:2:{i:0;i:2;i:1;i:4;}}}s:4:\"test\";a:1:{s:6:\"system\";a:1:{s:5:\"index\";a:2:{i:0;i:1;i:1;i:2;}}}}', '公开组，未登录用户拥有该权限');
INSERT INTO `tr_user_groups` VALUES ('2', '1', 'Guest', '1', 'a:1:{s:13:\"administrator\";a:2:{s:6:\"system\";a:2:{s:4:\"site\";a:1:{i:0;i:1;}s:5:\"tools\";a:1:{i:0;i:1;}}s:7:\"builder\";a:3:{s:6:\"fields\";a:1:{i:0;i:2;}s:6:\"groups\";a:1:{i:0;i:2;}s:5:\"index\";a:1:{i:0;i:2;}}}}', '普通会员');
INSERT INTO `tr_user_groups` VALUES ('3', '1', 'Manager', '2', null, '普通管理员');
INSERT INTO `tr_user_groups` VALUES ('4', '1', 'Registered', '3', 'a:2:{s:13:\"administrator\";a:3:{s:6:\"system\";a:2:{s:4:\"site\";a:4:{i:0;i:1;i:1;i:2;i:2;i:4;i:3;i:8;}s:5:\"tools\";a:3:{i:0;i:2;i:1;i:4;i:2;i:8;}}s:7:\"builder\";a:3:{s:6:\"schema\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}s:5:\"types\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}s:10:\"validators\";a:2:{i:0;i:2;i:1;i:4;}}s:7:\"ucenter\";a:2:{s:5:\"amcas\";a:4:{i:0;i:1;i:1;i:2;i:2;i:4;i:3;i:8;}s:6:\"groups\";a:4:{i:0;i:1;i:1;i:2;i:2;i:4;i:3;i:8;}}}s:4:\"test\";a:1:{s:6:\"system\";a:1:{s:5:\"index\";a:2:{i:0;i:1;i:1;i:2;}}}}', '记名作者');
INSERT INTO `tr_user_groups` VALUES ('5', '1', 'Super Users', '4', null, '超级会员');
INSERT INTO `tr_user_groups` VALUES ('6', '3', 'Administrator', '1', null, '超级管理员');
INSERT INTO `tr_user_groups` VALUES ('7', '4', 'Author', '1', 'a:2:{s:13:\"administrator\";a:2:{s:7:\"builder\";a:6:{s:6:\"fields\";a:1:{i:0;i:2;}s:6:\"groups\";a:1:{i:0;i:2;}s:5:\"index\";a:1:{i:0;i:2;}s:6:\"schema\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}s:5:\"types\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}s:10:\"validators\";a:2:{i:0;i:2;i:1;i:4;}}s:7:\"ucenter\";a:2:{s:5:\"amcas\";a:2:{i:0;i:2;i:1;i:4;}s:6:\"groups\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}}s:4:\"test\";a:1:{s:6:\"system\";a:1:{s:5:\"index\";a:1:{i:0;i:2;}}}}', '普通作者');
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='用户主表';

-- ----------------------------
-- Records of tr_users
-- ----------------------------
INSERT INTO `tr_users` VALUES ('1', 'aaaaaaa', 'name', '05a515fba1665791642e3fc92ef33c25', 'n43MsZ', 'aasdff', '', '', '2014-04-15 18:29:39', '2014-04-15 18:29:39', '0000-00-00 00:00:00', '0', '0', '0', '1', '0', 'n', 'n', 'n', 'n');
INSERT INTO `tr_users` VALUES ('2', 'songhuan', 'name', 'ad81d58e6df1858b06ea4aa8925e98d3', 'xewIbR', 'songhuan', '', '', '2014-04-15 18:30:47', '2014-04-15 18:30:47', '0000-00-00 00:00:00', '0', '0', '0', '1', '0', 'n', 'n', 'n', 'n');
INSERT INTO `tr_users` VALUES ('3', '15001329893', 'phone', 'c41507e8279f17f5ac3fe559419d7200', 'Gyn8AL', '', '', '15001329893', '2014-04-15 18:31:16', '2014-04-15 18:31:16', '0000-00-00 00:00:00', '0', '0', '0', '1', '0', 'n', 'n', 'n', 'n');
INSERT INTO `tr_users` VALUES ('4', 'iphper@yeah.net', 'mail', '02dae8851b3360c627622c905a14ecd3', 'bMztzE', '', 'iphper@yeah.net', '', '2014-04-15 18:31:47', '2014-04-15 18:31:47', '0000-00-00 00:00:00', '0', '0', '0', '1', '0', 'n', 'n', 'n', 'n');
INSERT INTO `tr_users` VALUES ('5', 'aaafdsasdf', 'name', '7026d47026290ce5ff8fe0be051f70d6', 'dgWePS', 'asdfsdf', '', '', '2014-04-15 18:32:05', '2014-04-15 18:32:05', '0000-00-00 00:00:00', '0', '0', '0', '1', '0', 'y', 'n', 'n', 'n');
INSERT INTO `tr_users` VALUES ('6', '15001329891', 'phone', 'c1937ba17c6cec73293b273969ca6ec4', '8U7gbA', '', '', '15001329892', '2014-04-15 18:32:33', '2014-04-15 18:32:33', '0000-00-00 00:00:00', '0', '0', '0', '1', '0', 'n', 'n', 'n', 'n');
INSERT INTO `tr_users` VALUES ('7', 'af@adf.com', 'mail', '440bfa5220b7aee6e65d68bcbe76ebd7', 'XQi46M', '', 'aaa@aaa.ccu', '', '2014-04-15 18:32:56', '2014-04-15 18:32:56', '0000-00-00 00:00:00', '0', '0', '0', '1', '0', 'n', 'n', 'n', 'n');
INSERT INTO `tr_users` VALUES ('8', 'adfefee', 'name', 'ff1ae9ee2e1d840c75e7756ec1589390', '9QSiRm', 'aaaaaa', 'aaa@aaa.ccurrr', '15001329892', '2014-04-15 18:33:24', '2014-04-15 18:33:24', '2014-04-15 18:40:35', '0', '0', '0', '1', '2', 'n', 'y', 'n', 'n');
INSERT INTO `tr_users` VALUES ('9', 'aafffeeee', 'name', '12c53bd1a0cd64422ba13ca2d7c4b44f', 'XsLzcc', 'aafffeeeeee', '', '', '2014-04-16 10:50:11', '2014-04-16 10:50:11', '2014-04-16 10:52:49', '0', '0', '0', '1', '3', 'y', 'y', 'n', 'n');
INSERT INTO `tr_users` VALUES ('10', 'attyyy', 'name', 'c37a178a3555313bd60b048e52ca703d', 'SLCaQM', 'attyyy', '', '', '2014-04-16 15:05:52', '2014-04-16 15:05:52', '0000-00-00 00:00:00', '0', '0', '0', '1', '0', 'n', 'n', 'n', 'n');
INSERT INTO `tr_users` VALUES ('11', 'wewewewe', 'name', '1ed58e3d1f6bd604339033c8d2610483', 'YYxSvC', 'wewewewe', '', '', '2014-04-16 15:08:07', '2014-04-16 15:08:07', '0000-00-00 00:00:00', '0', '0', '0', '1', '0', 'n', 'n', 'n', 'n');
INSERT INTO `tr_users` VALUES ('12', 'iiiiiiiiiii', 'name', '670e9fa9a8e29625d58375d3348dda9c', 'IkMMC7', 'iiiiiiiiiii', '', '', '2014-04-16 15:11:35', '2014-04-16 15:11:35', '0000-00-00 00:00:00', '0', '0', '0', '1', '0', 'n', 'n', 'n', 'n');
