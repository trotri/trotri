<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\generator\helper;

use library\Constant;

/**
 * Generators class file
 * 业务辅助层类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Generators.php 1 2013-05-18 14:58:59Z huan.song $
 * @package modules.generator.helper
 * @since 1.0
 */
class Generators
{
	/**
	 * @var string 数据库表引擎：InnoDB类型
	 */
	const TBL_ENGINE_INNODB = 'InnoDB';

	/**
	 * @var string 数据库表引擎：MyISAM类型
	 */
	const TBL_ENGINE_MYISAM = 'MyISAM';

	/**
	 * @var string 数据库表编码方式：utf8
	 */
	const TBL_CHARSET_UTF8 = 'utf8';

	/**
	 * @var string 数据库表编码方式：gbk
	 */
	const TBL_CHARSET_GBK = 'gbk';

	/**
	 * @var string 数据库表编码方式：gb2312
	 */
	const TBL_CHARSET_GB2312 = 'gb2312';

	/**
	 * @var string 是否生成扩展表：是
	 */
	const TBL_PROFILE_Y = 'y';

	/**
	 * @var string 是否生成扩展表：否
	 */
	const TBL_PROFILE_N = 'n';

	/**
	 * @var string 选择是否删除：是
	 */
	const TRASH_Y = 'y';

	/**
	 * @var string 选择是否删除：否
	 */
	const TRASH_N = 'n';

	/**
	 * @var string 数据列表每行操作Btn：更新
	 */
	const INDEX_ROW_BTNS_PENCIL = 'pencil';

	/**
	 * @var string 数据列表每行操作Btn：放入回收站
	 */
	const INDEX_ROW_BTNS_TRASH = 'trash';

	/**
	 * @var string 数据列表每行操作Btn：彻底删除
	 */
	const INDEX_ROW_BTNS_REMOVE = 'remove';

	/**
	 * @var array 数据库表引擎
	 */
	public static $tblEngines = array(
		self::TBL_ENGINE_INNODB => self::TBL_ENGINE_INNODB,
		self::TBL_ENGINE_MYISAM => self::TBL_ENGINE_MYISAM
	);

	/**
	 * @var array 数据库表编码方式
	 */
	public static $tblCharsets = array(
		self::TBL_CHARSET_UTF8 => self::TBL_CHARSET_UTF8,
		self::TBL_CHARSET_GBK => self::TBL_CHARSET_GBK,
		self::TBL_CHARSET_GB2312 => self::TBL_CHARSET_GB2312
	);

	/**
	 * @var array 数据列表每行操作Btn
	 */
	public static $indexRowBtns = array(
		self::INDEX_ROW_BTNS_PENCIL => '编辑',
		self::INDEX_ROW_BTNS_TRASH => '放入回收站',
		self::INDEX_ROW_BTNS_REMOVE => '彻底删除'
	);

	/**
	 * @var array 是否生成扩展表
	 */
	public static $tblProfiles = array(
		self::TBL_PROFILE_Y => '是',
		self::TBL_PROFILE_N => '否'
	);

	/**
	 * @var array 是否删除
	 */
	public static $trashs = array(
		self::TRASH_Y => '是',
		self::TRASH_N => '否'
	);

	/**
	 * @var array Input表单元素分类标签
	 */
	public static $tabs = array(
		'act' => array('tid' => 'act', 'prompt' => '行动名'),
		'system' => array('tid' => 'system', 'prompt' => '系统信息')
	);

	/**
	 * 获取“生成代码名”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getGeneratorName($type)
	{
		$output = array();

		$name = 'generator_name';
		$label = '生成代码名';

		if ($type === Constant::M_H_TYPE_TABLE) {
			$output = array(
				'label' => $label,
			);
		}
		elseif ($type === Constant::M_H_TYPE_FORM) {
			$output = array(
				'type' => 'text',
				'label' => $label,
				'hint' => $label . '由6~12个字符组成',
				'required' => true
			);
		}
		elseif ($type === Constant::M_H_TYPE_RULE) {
			$output = array(
				'MinLength' => array(6, $label . '长度%value%不能小于%option%个字符.'),
				'MaxLength' => array(12, $label . '长度%value%不能大于%option%个字符.')
			);
		}

		return $output;
	}

	/**
	 * 获取“表名”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getTblName($type)
	{
		$output = array();

		$name = 'tbl_name';
		$label = '表名';

		if ($type === Constant::M_H_TYPE_TABLE) {
			$output = array(
				'label' => $label,
			);
		}
		elseif ($type === Constant::M_H_TYPE_FORM) {
			$output = array(
				'type' => 'text',
				'label' => $label,
				'hint' => $label . '由2~12个英文字母、数字或下划线组成',
				'required' => true
			);
		}
		elseif ($type === Constant::M_H_TYPE_RULE) {
			$output = array(
				'AlphaNum' => array(true, $label . '只能由英文字母、数字或下划线组成.'),
				'MinLength' => array(2, $label . '长度%value%不能小于%option%个字符.'),
				'MaxLength' => array(12, $label. '长度%value%不能大于%option%个字符.')
			);
		}

		return $output;
	}

	/**
	 * 获取“是否生成扩展表”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getTblProfile($type)
	{
		$output = array();

		$name = 'tbl_profile';
		$label = '是否生成扩展表';

		if ($type === Constant::M_H_TYPE_TABLE) {
			$output = array(
				'label' => $label,
			);
		}
		elseif ($type === Constant::M_H_TYPE_FORM) {
			$output = array(
				'type' => 'switch',
				'label' => $label,
			);
		}
		elseif ($type === Constant::M_H_TYPE_RULE) {
			$output = array(
				'InArray' => array(
					array_keys(self::$tblProfiles),
					'必须选择' . $label . '，值只能是' . implode('、', self::$tblProfiles) . '.'
				)
			);
		}

		return $output;
	}

	/**
	 * 获取“表引擎”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getTblEngine($type)
	{
		$output = array();
		
		$name = 'tbl_engine';
		$label = '表引擎';
		
		if ($type === Constant::M_H_TYPE_TABLE) {
			$output = array(
				'label' => $label,
			);
		}
		elseif ($type === Constant::M_H_TYPE_FORM) {
			$output = array(
				'type' => 'radio',
				'label' => $label,
				'options' => self::$tblEngines
			);
		}
		elseif ($type === Constant::M_H_TYPE_RULE) {
			$output = array(
				'InArray' => array(
					array_keys(self::$tblEngines),
					'必须选择' . $label . '，值只能是' . implode('、', self::$tblEngines) . '.'
				)
			);
		}

		return $output;
	}

	/**
	 * 获取“表编码”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getTblCharset($type)
	{
		$output = array();

		$name = 'tbl_charset';
		$label = '表编码';

		if ($type === Constant::M_H_TYPE_TABLE) {
			$output = array(
				'label' => $label,
			);
		}
		elseif ($type === Constant::M_H_TYPE_FORM) {
			$output = array(
				'type' => 'radio',
				'label' => $label,
				'options' => self::$tblCharsets
			);
		}
		elseif ($type === Constant::M_H_TYPE_RULE) {
			$output = array(
				'InArray' => array(
					array_keys(self::$tblCharsets),
					'必须选择' . $label . '，值只能是' . implode('、', self::$tblCharsets) . '.'
				)
			);
		}

		return $output;
	}

	/**
	 * 获取“表描述”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getTblComment($type)
	{
		$output = array();
		
		$name = 'tbl_comment';
		$label = '表描述';

		if ($type === Constant::M_H_TYPE_TABLE) {
			$output = array(
				'label' => $label,
			);
		}
		elseif ($type === Constant::M_H_TYPE_FORM) {
			$output = array(
				'type' => 'text',
				'label' => $label,
				'required' => true
			);
		}
		elseif ($type === Constant::M_H_TYPE_RULE) {
			$output = array(
				'NotEmpty' => array(true, '必须填写' . $label . '.')
			);
		}

		return $output;
	}

	/**
	 * 获取“应用名”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getAppName($type)
	{
		$output = array();

		$name = 'app_name';
		$label = '应用名';

		if ($type === Constant::M_H_TYPE_TABLE) {
			$output = array(
				'label' => $label,
			);
		}
		elseif ($type === Constant::M_H_TYPE_FORM) {
			$output = array(
				'type' => 'text',
				'label' => $label,
				'hint' => $label . '由2~12个英文字母组成',
				'required' => true
			);
		}
		elseif ($type === Constant::M_H_TYPE_RULE) {
			$output = array(
				'Alpha' => array(true, $label . '只能由英文字母组成.'),
				'MinLength' => array(2, $label . '长度%value%不能小于%option%个字符.'),
				'MaxLength' => array(12, $label . '长度%value%不能大于%option%个字符.')
			);
		}

		return $output;
	}

	/**
	 * 获取“模块名”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getModName($type)
	{
		$output = array();

		$name = 'mod_name';
		$label = '模块名';

		if ($type === Constant::M_H_TYPE_TABLE) {
			$output = array(
				'label' => $label,
			);
		}
		elseif ($type === Constant::M_H_TYPE_FORM) {
			$output = array(
				'type' => 'text',
				'label' => $label,
				'hint' => $label . '由2~12个英文字母组成',
				'required' => true
			);
		}
		elseif ($type === Constant::M_H_TYPE_RULE) {
			$output = array(
				'Alpha' => array(true, $label . '只能由英文字母组成.'),
				'MinLength' => array(2, $label . '长度%value%不能小于%option%个字符.'),
				'MaxLength' => array(12, $label . '长度%value%不能大于%option%个字符.')
			);
		}

		return $output;
	}

	/**
	 * 获取“控制器名”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getCtrlName($type)
	{
		$output = array();

		$name = 'ctrl_name';
		$label = '控制器名';

		if ($type === Constant::M_H_TYPE_TABLE) {
			$output = array(
				'label' => $label,
			);
		}
		elseif ($type === Constant::M_H_TYPE_FORM) {
			$output = array(
				'type' => 'text',
				'label' => $label,
				'hint' => $label . '由2~12个英文字母组成',
				'required' => true
			);
		}
		elseif ($type === Constant::M_H_TYPE_RULE) {
			$output = array(
				'Alpha' => array(true, $label . '只能由英文字母组成.'),
				'MinLength' => array(2, $label . '长度%value%不能小于%option%个字符.'),
				'MaxLength' => array(12, $label . '长度%value%不能大于%option%个字符.')
			);
		}

		return $output;
	}

	/**
	 * 获取“列表每行操作按钮”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getIndexRowBtns($type)
	{
		$output = array();

		$name = 'index_row_btns';
		$label = '列表每行操作按钮';

		if ($type === Constant::M_H_TYPE_TABLE) {
			$output = array(
				'label' => $label,
			);
		}
		elseif ($type === Constant::M_H_TYPE_FORM) {
			$output = array(
				'type' => 'checkbox',
				'label' => $label,
				'options' => self::$indexRowBtns
			);
		}
		elseif ($type === Constant::M_H_TYPE_RULE) {
			$output = array(
				'InArray' => array(
					array_keys(self::$indexRowBtns),
					'必须选择' . $label . '，值只能是' . implode('、', self::$indexRowBtns) . '.'
				)
			);
		}

		return $output;
	}

	/**
	 * 获取“描述”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getDescription($type)
	{
		$output = array();

		$name = 'description';
		$label = '描述';

		if ($type === Constant::M_H_TYPE_TABLE) {
			$output = array(
				'label' => $label,
			);
		}
		elseif ($type === Constant::M_H_TYPE_FORM) {
			$output = array(
				'type' => 'textarea',
				'label' => $label,
			);
		}

		return $output;
	}

	/**
	 * 获取“放入回收站”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getTrash($type)
	{
		$output = array();

		$name = 'trash';
		$label = '放入回收站';

		if ($type === Constant::M_H_TYPE_TABLE) {
			$output = array(
				'label' => $label,
			);
		}
		elseif ($type === Constant::M_H_TYPE_FORM) {
			$output = array(
				'type' => 'switch',
				'label' => $label,
			);
		}
		elseif ($type === Constant::M_H_TYPE_RULE) {
			$output = array(
				'InArray' => array(
					array_keys(self::$trashs),
					'必须选择是否' . $label . '，值只能是' . implode('、', self::$trashs) . '.'
				)
			);
		}

		return $output;
	}

	/**
	 * 获取“数据列表行动名”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getActIndexName($type)
	{
		$output = array();

		$name = 'act_index_name';
		$label = '数据列表';

		if ($type === Constant::M_H_TYPE_TABLE) {
			$output = array(
				'label' => $label,
			);
		}
		elseif ($type === Constant::M_H_TYPE_FORM) {
			$output = array(
				'__tid__' => 'act',
				'type' => 'text',
				'value' => 'index',
				'label' => $label,
				'hint' => $label . '行动名由2~12个英文字母组成',
				'required' => true
			);
		}
		elseif ($type === Constant::M_H_TYPE_RULE) {
			$output = array(
				'Alpha' => array(true, $label . '行动名只能由英文字母组成.'),
				'MinLength' => array(2, $label . '行动名长度%value%不能小于%option%个字符.'),
				'MaxLength' => array(12, $label . '行动名长度%value%不能大于%option%个字符.')
			);
		}

		return $output;
	}

	/**
	 * 获取“数据详情行动名”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getActViewName($type)
	{
		$output = array();

		$name = 'act_view_name';
		$label = '数据详情';

		if ($type === Constant::M_H_TYPE_TABLE) {
			$output = array(
				'label' => $label,
			);
		}
		elseif ($type === Constant::M_H_TYPE_FORM) {
			$output = array(
				'__tid__' => 'act',
				'type' => 'text',
				'value' => 'view',
				'label' => $label,
				'hint' => $label . '行动名由2~12个英文字母组成',
				'required' => true
			);
		}
		elseif ($type === Constant::M_H_TYPE_RULE) {
			$output = array(
				'Alpha' => array(true, $label . '行动名只能由英文字母组成.'),
				'MinLength' => array(2, $label . '行动名长度%value%不能小于%option%个字符.'),
				'MaxLength' => array(12, $label . '行动名长度%value%不能大于%option%个字符.')
			);
		}

		return $output;
	}

	/**
	 * 获取“新增数据行动名”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getActCreateName($type)
	{
		$output = array();

		$name = 'act_create_name';
		$label = '新增数据';

		if ($type === Constant::M_H_TYPE_TABLE) {
			$output = array(
				'label' => $label,
			);
		}
		elseif ($type === Constant::M_H_TYPE_FORM) {
			$output = array(
				'__tid__' => 'act',
				'type' => 'text',
				'value' => 'create',
				'label' => $label,
				'hint' => $label . '行动名由2~12个英文字母组成',
				'required' => true
			);
		}
		elseif ($type === Constant::M_H_TYPE_RULE) {
			$output = array(
				'Alpha' => array(true, $label . '行动名只能由英文字母组成.'),
				'MinLength' => array(2, $label . '行动名长度%value%不能小于%option%个字符.'),
				'MaxLength' => array(12, $label . '行动名长度%value%不能大于%option%个字符.')
			);
		}

		return $output;
	}

	/**
	 * 获取“编辑数据行动名”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getActModifyName($type)
	{
		$output = array();

		$name = 'act_modify_name';
		$label = '编辑数据';

		if ($type === Constant::M_H_TYPE_TABLE) {
			$output = array(
				'label' => $label,
			);
		}
		elseif ($type === Constant::M_H_TYPE_FORM) {
			$output = array(
				'__tid__' => 'act',
				'type' => 'text',
				'value' => 'modify',
				'label' => $label,
				'hint' => $label . '行动名由2~12个英文字母组成',
				'required' => true
			);
		}
		elseif ($type === Constant::M_H_TYPE_RULE) {
			$output = array(
				'Alpha' => array(true, $label . '行动名只能由英文字母组成.'),
				'MinLength' => array(2, $label . '行动名长度%value%不能小于%option%个字符.'),
				'MaxLength' => array(12, $label . '行动名长度%value%不能大于%option%个字符.')
			);
		}

		return $output;
	}

	/**
	 * 获取“编删除数据行动名”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getActRemoveName($type)
	{
		$output = array();

		$name = 'act_remove_name';
		$label = '删除数据';

		if ($type === Constant::M_H_TYPE_TABLE) {
			$output = array(
				'label' => $label,
			);
		}
		elseif ($type === Constant::M_H_TYPE_FORM) {
			$output = array(
				'__tid__' => 'act',
				'type' => 'text',
				'value' => 'remove',
				'label' => $label,
				'hint' => $label . '行动名由2~12个英文字母组成',
				'required' => true
			);
		}
		elseif ($type === Constant::M_H_TYPE_RULE) {
			$output = array(
				'Alpha' => array(true, $label . '行动名只能由英文字母组成.'),
				'MinLength' => array(2, $label . '行动名长度%value%不能小于%option%个字符.'),
				'MaxLength' => array(12, $label . '行动名长度%value%不能大于%option%个字符.')
			);
		}

		return $output;
	}

	/**
	 * 获取“创建人”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getCreatorId($type)
	{
		$output = array();

		$name = 'creator_id';
		$label = '创建人';

		if ($type === Constant::M_H_TYPE_TABLE) {
			$output = array(
				'label' => $label,
			);
		}
		elseif ($type === Constant::M_H_TYPE_FORM) {
			$output = array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => $label,
				'disabled' => true
			);
		}

		return $output;
	}

	/**
	 * 获取“创建时间”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getDtCreated($type)
	{
		$output = array();

		$name = 'dt_created';
		$label = '创建时间';

		if ($type === Constant::M_H_TYPE_TABLE) {
			$output = array(
				'label' => $label,
			);
		}
		elseif ($type === Constant::M_H_TYPE_FORM) {
			$output = array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => $label,
				'disabled' => true
			);
		}

		return $output;
	}

	/**
	 * 获取“上次更新人”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getModifierId($type)
	{
		$output = array();

		$name = 'modifier_id';
		$label = '上次更新人';

		if ($type === Constant::M_H_TYPE_TABLE) {
			$output = array(
				'label' => $label,
			);
		}
		elseif ($type === Constant::M_H_TYPE_FORM) {
			$output = array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => $label,
				'disabled' => true
			);
		}

		return $output;
	}

	/**
	 * 获取“上次更新时间”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getDtModified($type)
	{
		$output = array();

		$name = 'dt_modified';
		$label = '上次更新时间';

		if ($type === Constant::M_H_TYPE_TABLE) {
			$output = array(
				'label' => $label,
			);
		}
		elseif ($type === Constant::M_H_TYPE_FORM) {
			$output = array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => $label,
				'disabled' => true
			);
		}

		return $output;
	}

	/**
	 * 获取新增数据的验证规则
	 * @return array
	 */
	public function getCreateRules()
	{
		$type = Constant::M_H_TYPE_RULE;

		$output = array(
			'generator_name' => $this->getGeneratorName($type),
			'tbl_name' => $this->getTblName($type),
			'tbl_profile' => $this->getTblProfile($type),
			'tbl_engine' => $this->getTblEngine($type),
			'tbl_charset' => $this->getTblCharset($type),
			'tbl_comment' => $this->getTblComment($type),
			'app_name' => $this->getAppName($type),
			'mod_name' => $this->getModName($type),
			'ctrl_name' => $this->getCtrlName($type),
			'index_row_btns' => $this->getIndexRowBtns($type),
			'trash' => $this->getTrash($type),
			'act_index_name' => $this->getActIndexName($type),
			'act_view_name' => $this->getActViewName($type),
			'act_create_name' => $this->getActCreateName($type),
			'act_modify_name' => $this->getActModifyName($type),
			'act_remove_name' => $this->getActRemoveName($type),
		);

		// 不需要验证的字段：'description', 'creator_id', 'dt_created', 'modifier_id', 'dt_modified',

		return $output;
	}

}
