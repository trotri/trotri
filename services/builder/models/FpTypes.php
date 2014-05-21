<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace builder\models;

use libsrv\FormProcessor;
use libsrv\Clean;
use builder\library\Lang;

use tfc\validator\AlphaValidator;
use tfc\validator\NumericValidator;
use tfc\validator\InArrayValidator;
use tfc\validator\MaxLengthValidator;
use tfc\validator\MinLengthValidator;

/**
 * FpTypes class file
 * 业务层：表单数据处理类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: FpTypes.php 1 2014-04-03 16:16:03Z Code Generator $
 * @package builder.models
 * @since 1.0
 */
class FpTypes extends FormProcessor
{
	/**
	 * (non-PHPdoc)
	 * @see libsrv.FormProcessor::_process()
	 */
	protected function _process(array $params = array())
	{
		if ($this->isInsert()) {
			if (!$this->required($params, 'type_name', 'form_type', 'field_type', 'category', 'sort')) {
				return false;
			}
		}

		$this->isValids($params, 'type_name', 'form_type', 'field_type', 'category', 'sort');
		return !$this->hasError();
	}

	/**
	 * (non-PHPdoc)
	 * @see libsrv.FormProcessor::_cleanPreProcess()
	 */
	protected function _cleanPreProcess(array $params)
	{
		$rules = array(
			'type_name' => 'trim',
			'form_type' => 'trim',
			'field_type' => 'trim',
			'category' => 'trim',
			'sort' => 'intval',
		);

		$ret = $this->clean($rules, $params);
		return $ret;
	}

	/**
	 * 获取“类型名”验证规则
	 * @param string $value
	 * @return array
	 */
	public function getTypeNameRule($value)
	{
		return array(
			'MinLength' => new MinLengthValidator($value, 2, Lang::_('MOD_FILTER_BUILDER_TYPES_TYPE_NAME_MINLENGTH')),
			'MaxLength' => new MaxLengthValidator($value, 50, Lang::_('MOD_FILTER_BUILDER_TYPES_TYPE_NAME_MAXLENGTH'))
		);
	}

	/**
	 * 获取“表单类型名”验证规则
	 * @param string $value
	 * @return array
	 */
	public function getFormTypeRule($value)
	{
		return array(
			'Alpha' => new AlphaValidator($value, true, Lang::_('MOD_FILTER_BUILDER_TYPES_FORM_TYPE_ALPHA')),
			'MinLength' => new MinLengthValidator($value, 2, Lang::_('MOD_FILTER_BUILDER_TYPES_FORM_TYPE_MINLENGTH')),
			'MaxLength' => new MaxLengthValidator($value, 12, Lang::_('MOD_FILTER_BUILDER_TYPES_FORM_TYPE_MAXLENGTH'))
		);
	}

	/**
	 * 获取“表字段类型”验证规则
	 * @param string $value
	 * @return array
	 */
	public function getFieldTypeRule($value)
	{
		return array(
			'Alpha' => new AlphaValidator($value, true, Lang::_('MOD_FILTER_BUILDER_TYPES_FIELD_TYPE_ALPHA')),
			'MinLength' => new MinLengthValidator($value, 2, Lang::_('MOD_FILTER_BUILDER_TYPES_FIELD_TYPE_MINLENGTH')),
			'MaxLength' => new MaxLengthValidator($value, 12, Lang::_('MOD_FILTER_BUILDER_TYPES_FIELD_TYPE_MAXLENGTH'))
		);
	}

	/**
	 * 获取“所属分类”验证规则
	 * @param string $value
	 * @return array
	 */
	public function getCategoryRule($value)
	{
		$enum = DataTypes::getCategoryEnum();
		return array(
			'InArray' => new InArrayValidator($value, array_keys($enum), sprintf(Lang::_('MOD_FILTER_BUILDER_TYPES_CATEGORY_INARRAY'), implode(', ', $enum)))
		);
	}

	/**
	 * 获取“排序”验证规则
	 * @param string $value
	 * @return array
	 */
	public function getSortRule($value)
	{
		return array(
			'Numeric' => new NumericValidator($value, true, Lang::_('MOD_FILTER_BUILDER_TYPES_SORT_NUMERIC'))
		);
	}
}
