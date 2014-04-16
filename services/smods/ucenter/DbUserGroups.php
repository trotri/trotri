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

use slib\BaseDb;

/**
 * DbUserGroups class file
 * 业务层：数据库操作类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: DbUserGroups.php 1 2014-04-16 11:28:21Z Code Generator $
 * @package smods.ucenter
 * @since 1.0
 */
class DbUserGroups extends BaseDb
{
	/**
	 * 构造方法：初始化表名
	 * @param integer $tableNum
	 */
	public function __construct($tableNum = -1)
	{
		parent::__construct('user_usergroups_map', $tableNum);
	}

	/**
	 * 通过用户ID和用户组ID，新增一条记录
	 * @param integer $userId
	 * @param integer $groupId
	 * @return boolean
	 */
	public function create($userId, $groupId)
	{
		$attributes = array('user_id' => $userId, 'group_id' => $groupId);

		$sql = $this->getCommandBuilder()->createInsert($this->getTableSchema()->name, array_keys($attributes));
		$ret = $this->getDbProxy()->query($sql, $attributes);
		return $ret;
	}

	/**
	 * 通过用户ID和用户组ID，新增多条记录
	 * @param integer $userId
	 * @param array $groupIds
	 * @return integer
	 */
	public function batchCreate($userId, $groupIds)
	{
		$rowCount = 0;

		$groupIds = (array) $groupIds;
		foreach ($groupIds as $groupId) {
			if ($this->create($userId, $groupId)) {
				$rowCount++;
			}
		}

		return $rowCount;
	}

	/**
	 * 通过用户ID和用户组ID，删除一条记录
	 * @param integer $userId
	 * @param integer $groupId
	 * @return integer
	 */
	public function remove($userId, $groupId)
	{
		$pks = array('user_id' => $userId, 'group_id' => $groupId);
		$ret = $this->deleteByPk($pks);
		return $ret;
	}

	/**
	 * 通过用户ID和用户组ID，删除多条记录
	 * @param integer $userId
	 * @param array $groupIds
	 * @return integer
	 */
	public function batchRemove($userId, $groupIds)
	{
		$rowCount = 0;

		$groupIds = (array) $groupIds;
		foreach ($groupIds as $groupId) {
			if (($value = $this->remove($userId, $groupId)) !== false) {
				$rowCount += $value;
			}
		}

		return $rowCount;
	}
}
