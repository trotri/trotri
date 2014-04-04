<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace smods\builder;

use slib\BaseData;

/**
 * DataTypes class file
 * 业务层：数据管理类，寄存常量、选项、验证规则
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: DataTypes.php 1 2014-04-04 13:49:20Z Code Generator $
 * @package smods.builder
 * @since 1.0
 */
class DataTypes extends BaseData
{
	/**
	 * @var string 所属分类：text
	 */
	const CATEGORY_TEXT = 'text';

	/**
	 * @var string 所属分类：option
	 */
	const CATEGORY_OPTION = 'option';

	/**
	 * @var string 所属分类：button
	 */
	const CATEGORY_BUTTON = 'button';

	/**
	 * 获取“所属分类”所有选项
	 * @return array
	 */
	public function getCategoryEnum()
	{
		return array(
			self::CATEGORY_TEXT => $this->_('MOD_BUILDER_BUILDER_TYPES_ENUM_CATEGORY_TEXT'),
			self::CATEGORY_OPTION => $this->_('MOD_BUILDER_BUILDER_TYPES_ENUM_CATEGORY_OPTION'),
			self::CATEGORY_BUTTON => $this->_('MOD_BUILDER_BUILDER_TYPES_ENUM_CATEGORY_BUTTON'),
		);
	}

	/**
	 * 获取“类型名”验证规则
	 * @return array
	 */
	public function getTypeNameRule()
	{
		return array(
			'MinLength' => array(2, $this->_('MOD_BUILDER_BUILDER_TYPES_TYPE_NAME_MINLENGTH')),
			'MaxLength' => array(50, $this->_('MOD_BUILDER_BUILDER_TYPES_TYPE_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“表单类型名”验证规则
	 * @return array
	 */
	public function getFormTypeRule()
	{
		return array(
			'Alpha' => array(true, $this->_('MOD_BUILDER_BUILDER_TYPES_FORM_TYPE_ALPHA')),
			'MinLength' => array(2, $this->_('MOD_BUILDER_BUILDER_TYPES_FORM_TYPE_MINLENGTH')),
			'MaxLength' => array(12, $this->_('MOD_BUILDER_BUILDER_TYPES_FORM_TYPE_MAXLENGTH')),
		);
	}

	/**
	 * 获取“表字段类型”验证规则
	 * @return array
	 */
	public function getFieldTypeRule()
	{
		return array(
			'Alpha' => array(true, $this->_('MOD_BUILDER_BUILDER_TYPES_FIELD_TYPE_ALPHA')),
			'MinLength' => array(2, $this->_('MOD_BUILDER_BUILDER_TYPES_FIELD_TYPE_MINLENGTH')),
			'MaxLength' => array(12, $this->_('MOD_BUILDER_BUILDER_TYPES_FIELD_TYPE_MAXLENGTH')),
		);
	}

	/**
	 * 获取“所属分类”验证规则
	 * @return array
	 */
	public function getCategoryRule()
	{
		$enum = $this->getCategoryEnum();
		return array(
			'InArray' => array(
				array_keys($enum), 
				sprintf($this->_('MOD_BUILDER_BUILDER_TYPES_CATEGORY_INARRAY'), implode(', ', $enum))
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
			'Numeric' => array(true, $this->_('MOD_BUILDER_BUILDER_TYPES_SORT_NUMERIC')),
		);
	}

}
