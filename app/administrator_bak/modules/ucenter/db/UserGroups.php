<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\ucenter\db;

use library\Db;

/**
 * UserGroups class file
 * 数据库操作层类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: UserGroups.php 1 2014-02-11 15:23:39Z huan.song $
 * @package modules.ucenter.db
 * @since 1.0
 */
class UserGroups extends Db
{
	/**
	 * 构造方法：初始化表名
	 */
	public function __construct()
	{
		parent::__construct('user_usergroups_map');
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
