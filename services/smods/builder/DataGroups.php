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

use slib\BaseData;

/**
 * DataGroups class file
 * 业务层：数据管理类，寄存常量、选项、验证规则
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: DataGroups.php 1 2014-01-18 14:19:29Z huan.song $
 * @package smods.builder
 * @since 1.0
 */
class DataGroups extends BaseData
{
	/**
	 * 获取“组名”验证规则
	 * @return array
	 */
	public function getGroupNameRule()
	{
		return array(
			'Alpha' => array(true, $this->_('MOD_BUILDER_BUILDER_FIELD_GROUPS_GROUP_NAME_ALPHA')),
			'MinLength' => array(2, $this->_('MOD_BUILDER_BUILDER_FIELD_GROUPS_GROUP_NAME_MINLENGTH')),
			'MaxLength' => array(12, $this->_('MOD_BUILDER_BUILDER_FIELD_GROUPS_GROUP_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“提示”验证规则
	 * @return array
	 */
	public function getPromptRule()
	{
		return array(
			'MinLength' => array(2, $this->_('MOD_BUILDER_BUILDER_FIELD_GROUPS_PROMPT_MINLENGTH')),
			'MaxLength' => array(12, $this->_('MOD_BUILDER_BUILDER_FIELD_GROUPS_PROMPT_MAXLENGTH')),
		);
	}

	/**
	 * 获取“生成代码ID”验证规则
	 * @return array
	 */
	public function getBuilderIdRule()
	{
		return array(
			'Integer' => array(true, $this->_('MOD_BUILDER_BUILDER_FIELD_GROUPS_BUILDER_ID_INTEGER')),
		);
	}

	/**
	 * 获取“排序”验证规则
	 * @return array
	 */
	public function getSortRule()
	{
		return array(
			'Numeric' => array(true, $this->_('MOD_BUILDER_BUILDER_FIELD_GROUPS_SORT_NUMERIC')),
		);
	}
}
