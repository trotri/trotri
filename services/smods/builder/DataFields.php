<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace smods\builder;

use tfc\ap\Registry;
use slib\BaseData;
use slib\Model;

/**
 * DataFields class file
 * 业务层：数据管理类，寄存常量、选项、验证规则
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: DataFields.php 1 2014-01-18 14:19:29Z huan.song $
 * @package smods.builder
 * @since 1.0
 */
class DataFields extends BaseData
{
	/**
	 * @var string 是否自动递增：是
	 */
	const COLUMN_AUTO_INCREMENT_Y = 'y';

	/**
	 * @var string 是否自动递增：否
	 */
	const COLUMN_AUTO_INCREMENT_N = 'n';

	/**
	 * @var string 是否无符号：是
	 */
	const COLUMN_UNSIGNED_Y = 'y';

	/**
	 * @var string 是否无符号：否
	 */
	const COLUMN_UNSIGNED_N = 'n';

	/**
	 * @var string 表单是否必填：是
	 */
	const FORM_REQUIRED_Y = 'y';

	/**
	 * @var string 表单是否必填：否
	 */
	const FORM_REQUIRED_N = 'n';

	/**
	 * @var string 编辑表单中允许输入：是
	 */
	const FORM_MODIFIABLE_Y = 'y';

	/**
	 * @var string 编辑表单中允许输入：否
	 */
	const FORM_MODIFIABLE_N = 'n';

	/**
	 * @var string 是否在列表中展示：是
	 */
	const INDEX_SHOW_Y = 'y';

	/**
	 * @var string 是否在列表中展示：否
	 */
	const INDEX_SHOW_N = 'n';

	/**
	 * @var string 是否在新增表单中展示：是
	 */
	const FORM_CREATE_SHOW_Y = 'y';

	/**
	 * @var string 是否在新增表单中展示：否
	 */
	const FORM_CREATE_SHOW_N = 'n';

	/**
	 * @var string 是否在编辑表单中展示：是
	 */
	const FORM_MODIFY_SHOW_Y = 'y';

	/**
	 * @var string 是否在编辑表单中展示：否
	 */
	const FORM_MODIFY_SHOW_N = 'n';

	/**
	 * @var string 是否在查询表单中展示：是
	 */
	const FORM_SEARCH_SHOW_Y = 'y';

	/**
	 * @var string 是否在查询表单中展示：否
	 */
	const FORM_SEARCH_SHOW_N = 'n';

	/**
	 * 获取“是否自动递增”所有选项
	 * @return array
	 */
	public function getColumnAutoIncrementEnum()
	{
		return array(
			self::COLUMN_AUTO_INCREMENT_Y => $this->_('CFG_SYSTEM_GLOBAL_YES'),
			self::COLUMN_AUTO_INCREMENT_N => $this->_('CFG_SYSTEM_GLOBAL_NO'),
		);
	}

	/**
	 * 获取“是否无符号”所有选项
	 * @return array
	 */
	public function getColumnUnsignedEnum()
	{
		return array(
			self::COLUMN_UNSIGNED_Y => $this->_('CFG_SYSTEM_GLOBAL_YES'),
			self::COLUMN_UNSIGNED_N => $this->_('CFG_SYSTEM_GLOBAL_NO'),
		);
	}

	/**
	 * 获取“表单是否必填”所有选项
	 * @return array
	 */
	public function getFormRequiredEnum()
	{
		return array(
			self::FORM_REQUIRED_Y => $this->_('CFG_SYSTEM_GLOBAL_YES'),
			self::FORM_REQUIRED_N => $this->_('CFG_SYSTEM_GLOBAL_NO'),
		);
	}

	/**
	 * 获取“编辑表单中允许输入”所有选项
	 * @return array
	 */
	public function getFormModifiableEnum()
	{
		return array(
			self::FORM_MODIFIABLE_Y => $this->_('CFG_SYSTEM_GLOBAL_YES'),
			self::FORM_MODIFIABLE_N => $this->_('CFG_SYSTEM_GLOBAL_NO'),
		);
	}

	/**
	 * 获取“是否在列表中展示”所有选项
	 * @return array
	 */
	public function getIndexShowEnum()
	{
		return array(
			self::INDEX_SHOW_Y => $this->_('CFG_SYSTEM_GLOBAL_YES'),
			self::INDEX_SHOW_N => $this->_('CFG_SYSTEM_GLOBAL_NO'),
		);
	}

	/**
	 * 获取“是否在新增表单中展示”所有选项
	 * @return array
	 */
	public function getFormCreateShowEnum()
	{
		return array(
			self::FORM_CREATE_SHOW_Y => $this->_('CFG_SYSTEM_GLOBAL_YES'),
			self::FORM_CREATE_SHOW_N => $this->_('CFG_SYSTEM_GLOBAL_NO'),
		);
	}

	/**
	 * 获取“是否在编辑表单中展示”所有选项
	 * @return array
	 */
	public function getFormModifyShowEnum()
	{
		return array(
			self::FORM_MODIFY_SHOW_Y => $this->_('CFG_SYSTEM_GLOBAL_YES'),
			self::FORM_MODIFY_SHOW_N => $this->_('CFG_SYSTEM_GLOBAL_NO'),
		);
	}

	/**
	 * 获取“是否在查询表单中展示”所有选项
	 * @return array
	 */
	public function getFormSearchShowEnum()
	{
		return array(
			self::FORM_SEARCH_SHOW_Y => $this->_('CFG_SYSTEM_GLOBAL_YES'),
			self::FORM_SEARCH_SHOW_N => $this->_('CFG_SYSTEM_GLOBAL_NO'),
		);
	}

	/**
	 * 获取“字段类型ID”所有选项
	 * @return array
	 */
	public function getTypeIdEnum()
	{
		$name = __METHOD__;
		if (!Registry::has($name)) {
			$mod = Model::getInstance('Types', 'builder', $this->getLanguage());
			$types = $mod->getTypes();
			Registry::set($name, $types);
		}

		return Registry::get($name);
	}

	/**
	 * 获取“字段名”验证规则
	 * @return array
	 */
	public function getFieldNameRule()
	{
		return array(
			'AlphaNum' => array(true, $this->_('MOD_BUILDER_BUILDER_FIELDS_FIELD_NAME_ALPHANUM')),
			'MinLength' => array(2, $this->_('MOD_BUILDER_BUILDER_FIELDS_FIELD_NAME_MINLENGTH')),
			'MaxLength' => array(50, $this->_('MOD_BUILDER_BUILDER_FIELDS_FIELD_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“是否自动递增”验证规则
	 * @return array
	 */
	public function getColumnAutoIncrementRule()
	{
		$enum = $this->getColumnAutoIncrementEnum();
		return array(
			'InArray' => array(
				array_keys($enum),
				sprintf($this->_('MOD_BUILDER_BUILDER_FIELDS_COLUMN_AUTO_INCREMENT_INARRAY'), implode(', ', $enum))
			),
		);
	}

	/**
	 * 获取“是否无符号”验证规则
	 * @return array
	 */
	public function getColumnUnsignedRule()
	{
		$enum = $this->getColumnUnsignedEnum();
		return array(
			'InArray' => array(
				array_keys($enum),
				sprintf($this->_('MOD_BUILDER_BUILDER_FIELDS_COLUMN_UNSIGNED_INARRAY'), implode(', ', $enum))
			),
		);
	}

	/**
	 * 获取“DB字段描述”验证规则
	 * @return array
	 */
	public function getColumnCommentRule()
	{
		return array(
			'NotEmpty' => array(true, $this->_('MOD_BUILDER_BUILDER_FIELDS_COLUMN_COMMENT_NOTEMPTY')),
		);
	}

	/**
	 * 获取“生成代码ID”验证规则
	 * @return array
	 */
	public function getBuilderIdRule()
	{
		return array(
			'Integer' => array(true, $this->_('MOD_BUILDER_BUILDER_FIELDS_BUILDER_ID_INTEGER')),
		);
	}

	/**
	 * 获取“字段类型ID”验证规则
	 * @return array
	 */
	public function getTypeIdRule()
	{
		$enum = $this->getTypeIdEnum();
		return array(
			'InArray' => array(
				array_keys($enum),
				$this->_('MOD_BUILDER_BUILDER_FIELDS_TYPE_ID_INARRAY')
			),
		);
	}

	/**
	 * 获取“排序”验证规则
	 * @return array
	 */
	public function getSortRule()
	{
		return array(
			'Numeric' => array(true, $this->_('MOD_BUILDER_BUILDER_FIELDS_SORT_NUMERIC')),
		);
	}

	/**
	 * 获取“HTML：Table和Form显示名”验证规则
	 * @return array
	 */
	public function getHtmlLabelRule()
	{
		return array(
			'NotEmpty' => array(true, $this->_('MOD_BUILDER_BUILDER_FIELDS_HTML_LABEL_NOTEMPTY')),
		);
	}

	/**
	 * 获取“表单是否必填”验证规则
	 * @return array
	 */
	public function getFormRequiredRule()
	{
		$enum = $this->getFormRequiredEnum();
		return array(
			'InArray' => array(
				array_keys($enum),
				sprintf($this->_('MOD_BUILDER_BUILDER_FIELDS_FORM_REQUIRED_INARRAY'), implode(', ', $enum))
			),
		);
	}

	/**
	 * 获取“编辑表单中允许输入”验证规则
	 * @return array
	 */
	public function getFormModifiableRule()
	{
		$enum = $this->getFormModifiableEnum();
		return array(
			'InArray' => array(
				array_keys($enum),
				sprintf($this->_('MOD_BUILDER_BUILDER_FIELDS_FORM_MODIFIABLE_INARRAY'), implode(', ', $enum))
			),
		);
	}

	/**
	 * 获取“是否在列表中展示”验证规则
	 * @return array
	 */
	public function getIndexShowRule()
	{
		$enum = $this->getIndexShowEnum();
		return array(
			'InArray' => array(
				array_keys($enum),
				sprintf($this->_('MOD_BUILDER_BUILDER_FIELDS_INDEX_SHOW_INARRAY'), implode(', ', $enum))
			),
		);
	}

	/**
	 * 获取“在列表中排序”验证规则
	 * @return array
	 */
	public function getIndexSortRule()
	{
		return array(
			'Numeric' => array(true, $this->_('MOD_BUILDER_BUILDER_FIELDS_INDEX_SORT_NUMERIC')),
		);
	}

	/**
	 * 获取“是否在新增表单中展示”验证规则
	 * @return array
	 */
	public function getFormCreateShowRule()
	{
		$enum = $this->getFormCreateShowEnum();
		return array(
			'InArray' => array(
				array_keys($enum),
				sprintf($this->_('MOD_BUILDER_BUILDER_FIELDS_FORM_CREATE_SHOW_INARRAY'), implode(', ', $enum))
			),
		);
	}

	/**
	 * 获取“在新增表单中排序”验证规则
	 * @return array
	 */
	public function getFormCreateSortRule()
	{
		return array(
			'Numeric' => array(true, $this->_('MOD_BUILDER_BUILDER_FIELDS_FORM_CREATE_SORT_NUMERIC')),
		);
	}

	/**
	 * 获取“是否在编辑表单中展示”验证规则
	 * @return array
	 */
	public function getFormModifyShowRule()
	{
		$enum = $this->getFormModifyShowEnum();
		return array(
			'InArray' => array(
				array_keys($enum),
				sprintf($this->_('MOD_BUILDER_BUILDER_FIELDS_FORM_MODIFY_SHOW_INARRAY'), implode(', ', $enum))
			),
		);
	}

	/**
	 * 获取“在编辑表单中排序”验证规则
	 * @return array
	 */
	public function getFormModifySortRule()
	{
		return array(
			'Numeric' => array(true, $this->_('MOD_BUILDER_BUILDER_FIELDS_FORM_MODIFY_SORT_NUMERIC')),
		);
	}

	/**
	 * 获取“是否在查询表单中展示”验证规则
	 * @return array
	 */
	public function getFormSearchShowRule()
	{
		$enum = $this->getFormSearchShowEnum();
		return array(
			'InArray' => array(
				array_keys($enum),
				sprintf($this->_('MOD_BUILDER_BUILDER_FIELDS_FORM_SEARCH_SHOW_INARRAY'), implode(', ', $enum))
			),
		);
	}

	/**
	 * 获取“在查询表单中排序”验证规则
	 * @return array
	 */
	public function getFormSearchSortRule()
	{
		return array(
			'Numeric' => array(true, $this->_('MOD_BUILDER_BUILDER_FIELDS_FORM_SEARCH_SORT_NUMERIC')),
		);
	}
}
