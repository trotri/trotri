<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace smods\ucenter;

use slib\BaseData;

/**
 * DataGroups class file
 * 业务层：数据管理类，寄存常量、选项、验证规则
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: DataGroups.php 1 2014-04-10 17:43:20Z Code Generator $
 * @package smods.ucenter
 * @since 1.0
 */
class DataGroups extends BaseData
{
	/**
	 * 获取“所属父组名”验证规则
	 * @return array
	 */
	public function getGroupPidRule()
	{
		return array(
			'smods\\ucenter\\validator\\UserGroupsGroupPidExists' => array(true, $this->_('MOD_UCENTER_USER_GROUPS_GROUP_PID_EXISTS')),
		);
	}

	/**
	 * 获取“组名”验证规则
	 * @return array
	 */
	public function getGroupNameRule()
	{
		return array(
			'MinLength' => array(2, $this->_('MOD_UCENTER_USER_GROUPS_GROUP_NAME_MINLENGTH')),
			'MaxLength' => array(50, $this->_('MOD_UCENTER_USER_GROUPS_GROUP_NAME_MAXLENGTH')),
			'smods\\ucenter\\validator\\UserGroupsGroupNameUnique' => array(true, $this->_('MOD_UCENTER_USER_GROUPS_GROUP_NAME_UNIQUE')),
		);
	}

	/**
	 * 获取“排序”验证规则
	 * @return array
	 */
	public function getSortRule()
	{
		return array(
			'Numeric' => array(true, $this->_('MOD_UCENTER_USER_GROUPS_SORT_NUMERIC')),
		);
	}

}
