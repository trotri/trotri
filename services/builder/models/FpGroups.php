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

use tfc\validator\NumericValidator;

use tfc\validator\IntegerValidator;

use tfc\validator\MaxLengthValidator;

use tfc\validator\MinLengthValidator;

use tfc\validator\AlphaValidator;

use libsrv\FormProcessor;
use libsrv\Clean;
use builder\library\Lang;

/**
 * FpGroups class file
 * 业务层：表单数据处理类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: FpGroups.php 1 2014-04-03 16:16:03Z Code Generator $
 * @package builder.models
 * @since 1.0
 */
class FpGroups extends FormProcessor
{
	/**
	 * (non-PHPdoc)
	 * @see libsrv.FormProcessor::_process()
	 */
	protected function _process(array $params = array())
	{
		if ($this->isInsert()) {
			if (!$this->required($params, 'group_name', 'prompt', 'builder_id', 'sort')) {
				return false;
			}
		}

		$this->isValids($params, 'group_name', 'prompt', 'builder_id', 'sort', 'description');
		return !$this->hasError();
	}

	/**
	 * (non-PHPdoc)
	 * @see libsrv.FormProcessor::_cleanPreProcess()
	 */
	protected function _cleanPreProcess(array $params)
	{
		$rules = array(
			'group_name' => 'trim',
			'prompt' => 'trim',
			'builder_id' => 'intval',
		);

		$ret = $this->clean($rules, $params);
		return $ret;
	}

	/**
	 * 获取“组名”验证规则
	 * @param string $value
	 * @return array
	 */
	public function getGroupNameRule($value)
	{
		return array(
			'Alpha' => new AlphaValidator($value, true, Lang::_('MOD_FILTER_BUILDER_FIELD_GROUPS_GROUP_NAME_ALPHA')),
			'MinLength' => new MinLengthValidator($value, 2, Lang::_('MOD_FILTER_BUILDER_FIELD_GROUPS_GROUP_NAME_MINLENGTH')),
			'MaxLength' => new MaxLengthValidator($value, 12, Lang::_('MOD_FILTER_BUILDER_FIELD_GROUPS_GROUP_NAME_MAXLENGTH'))
		);
	}

	/**
	 * 获取“提示”验证规则
	 * @param string $value
	 * @return array
	 */
	public function getPromptRule($value)
	{
		return array(
			'MinLength' => new MinLengthValidator($value, 2, Lang::_('MOD_FILTER_BUILDER_FIELD_GROUPS_PROMPT_MINLENGTH')),
			'MaxLength' => new MaxLengthValidator($value, 12, Lang::_('MOD_FILTER_BUILDER_FIELD_GROUPS_PROMPT_MAXLENGTH'))
		);
	}

	/**
	 * 获取“生成代码ID”验证规则
	 * @param string $value
	 * @return array
	 */
	public function getBuilderIdRule($value)
	{
		return array(
			'Integer' => new IntegerValidator($value, true, Lang::_('MOD_FILTER_BUILDER_FIELD_GROUPS_BUILDER_ID_INTEGER'))
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
			'Numeric' => new NumericValidator($value, true, Lang::_('MOD_FILTER_BUILDER_FIELD_GROUPS_SORT_NUMERIC'))
		);
	}
}
