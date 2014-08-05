<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace users\services;

use libsrv\AbstractService;
use tfc\saf\Log;
use libsrv\Service;
use users\db\Groups AS DbGroups;

/**
 * Groups class file
 * 业务层：业务处理类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Groups.php 1 2014-05-29 18:56:38Z Code Generator $
 * @package users.services
 * @since 1.0
 */
class Groups extends AbstractService
{
	/**
	 * @var instance of users\db\Groups
	 */
	protected $_dbGroups = null;

	/**
	 * 构造方法：初始化数据库操作类
	 */
	public function __construct()
	{
		parent::__construct();

		$this->_dbGroups = new DbGroups();
	}

	/**
	 * 获取所有的组Id
	 * @return array
	 */
	public function getGroupIds()
	{
		$data = array();

		$rows = $this->_dbGroups->getGroupIds();
		if (is_array($rows)) {
			foreach ($rows as $row) {
				$data[] = (int) $row['group_id'];
			}
		}

		return $data;
	}

	/**
	 * 递归方式获取所有的组，默认用空格填充子类别左边用于和父类别错位（可用于Table列表）
	 * @param integer $groupPid
	 * @param string $padStr
	 * @param string $leftPad
	 * @param string $rightPad
	 * @return array
	 */
	public function findLists($groupPid = 0, $padStr = '|—', $leftPad = '', $rightPad = null)
	{
		$rows = $this->_dbGroups->findAllByGroupPid($groupPid);
		if (!$rows || !is_array($rows)) {
			return array();
		}

		$tmpLeftPad = is_string($leftPad) ? $leftPad . $padStr : null;
		$tmpRightPad = is_string($rightPad) ? $rightPad . $padStr : null;

		$data = array();
		foreach ($rows as $row) {
			$row['group_name'] = $leftPad . $row['group_name'] . $rightPad;
			$data[] = $row;

			$tmpRows = $this->findLists($row['group_id'], $padStr, $tmpLeftPad, $tmpRightPad);
			$data = array_merge($data, $tmpRows);
		}

		return $data;
	}

	/**
	 * 递归方式获取所有的组名，默认用空格填充子类别左边用于和父类别错位
	 * （只返回ID和组名的键值对）（可用于Select表单的Option选项）
	 * @param integer $groupPid
	 * @param string $padStr
	 * @param string $leftPad
	 * @param string $rightPad
	 * @return array
	 */
	public function getOptions($groupPid = 0, $padStr = '&nbsp;&nbsp;&nbsp;&nbsp;', $leftPad = '', $rightPad = null)
	{
		$data = array();

		$rows = $this->findLists($groupPid, $padStr, $leftPad, $rightPad);
		if (is_array($rows)) {
			foreach ($rows as $row) {
				if (!isset($row['group_id']) || !isset($row['group_name'])) {
					continue;
				}

				$groupId = (int) $row['group_id'];
				$data[$groupId] = $row['group_name'];
			}
		}

		return $data;
	}

	/**
	 * 通过主键，获取组名，并依次获取上级组名，用于Breadcrumbs
	 * @param integer $groupId
	 * @return array
	 */
	public function getGroupNames($groupId)
	{
		$data = array();

		$groupId = (int) $groupId;
		while ($groupId > 0) {
			$row = $this->findByPk($groupId);
			if (!$row || !is_array($row) || !isset($row['group_name']) || !isset($row['group_pid'])) {
				return $data;
			}

			$data[$groupId] = $row['group_name'];
			$groupId = (int) $row['group_pid'];
		}

		$data = array_reverse($data, true);
		return $data;
	}

	/**
	 * 通过主键，获取权限，并递归获取父级权限、父父级权限等
	 * @param integer $groupId
	 * @return array
	 */
	public function getPermissions($groupId)
	{
		$data = array();

		// 收集所有的权限（当前权限、父级权限、父父级权限等）
		$permissions = array();
		$groupId = (int) $groupId;
		while ($groupId > 0) {
			$row = $this->findByPk($groupId);
			if (!$row || !is_array($row) || !isset($row['permission']) || !isset($row['group_pid'])) {
				return $data;
			}

			$permissions[] = $row['permission'];
			$groupId = (int) $row['group_pid'];
		}

		// 将获取的权限去重
		foreach ($permissions as $permission) {
			if (is_array($permission)) {
				foreach ($permission as $appName => $mods) {
					if (is_array($mods)) {
						foreach ($mods as $modName => $ctrls) {
							if (is_array($ctrls)) {
								foreach ($ctrls as $ctrlName => $powers) {
									if (is_array($powers)) {
										foreach ($powers as $powerName) {
											if (!isset($data[$appName][$modName][$ctrlName])
												|| !in_array($powerName, $data[$appName][$modName][$ctrlName])) {
												$data[$appName][$modName][$ctrlName][] = $powerName;
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}

		return $data;
	}

	/**
	 * 通过主键，查询一条记录
	 * @param integer $groupId
	 * @return array
	 */
	public function findByPk($groupId)
	{
		$row = $this->_dbGroups->findByPk($groupId);
		if (is_array($row) && isset($row['permission'])) {
			$row['permission'] = unserialize(base64_decode($row['permission']));
			if (!is_array($row['permission'])) {
				$row['permission'] = array();
			}
		}

		return $row;
	}

	/**
	 * 通过主键，获取某个列的值
	 * @param string $columnName
	 * @param integer $groupId
	 * @return mixed
	 */
	public function getByPk($columnName, $groupId)
	{
		$value = $this->_dbGroups->getByPk($columnName, $groupId);
		return $value;
	}

	/**
	 * 通过“主键ID”，获取“组名”
	 * @param integer $groupId
	 * @return string
	 */
	public function getGroupNameByGroupId($groupId)
	{
		$value = $this->getByPk('group_name', $groupId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“父ID”
	 * @param integer $groupId
	 * @return integer
	 */
	public function getGroupPidByGroupId($groupId)
	{
		$value = $this->getByPk('group_pid', $groupId);
		return $value ? (int) $value : -1;
	}

	/**
	 * 通过“主键ID”，获取“排序”
	 * @param integer $groupId
	 * @return integer
	 */
	public function getSortByGroupId($groupId)
	{
		$value = $this->getByPk('sort', $groupId);
		return $value ? (int) $value : 0;
	}

	/**
	 * 通过“主键ID”，获取“权限设置”
	 * @param integer $groupId
	 * @return array
	 */
	public function getPermissionByGroupId($groupId)
	{
		$row = $this->findByPk($groupId);
		if (is_array($row) && isset($row['permission'])) {
			return $row['permission'];
		}

		return array();
	}

	/**
	 * 通过“主键ID”，获取“描述”
	 * @param integer $groupId
	 * @return string
	 */
	public function getDescriptionByGroupId($groupId)
	{
		$value = $this->getByPk('description', $groupId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，编辑“权限设置”
	 * @param integer $groupId
	 * @param array $params
	 * @return array
	 */
	public function modifyPermissionByPk($groupId, array $params)
	{
		$amcas = Service::getInstance('Amcas', $this->_srvName)->findAllByRecur();
		$powerEnum = DataGroups::getPowerEnum();

		$data = array();
		foreach ($params as $appName => $mods) {
			if (!isset($amcas[$appName])) {
				Log::warning(sprintf(
					'Groups is unable to find the app name "%s".', $appName
				));

				return false;
			}

			if (!is_array($mods)) {
				continue;
			}

			foreach ($mods as $modName => $ctrls) {
				if (!isset($amcas[$appName]['rows'][$modName])) {
					Log::warning(sprintf(
						'Groups is unable to find the mod name "%s-%s".', $appName, $modName
					));

					return false;
				}

				if (!is_array($ctrls)) {
					continue;
				}

				foreach ($ctrls as $ctrlName => $powers) {
					if (!isset($amcas[$appName]['rows'][$modName]['rows'][$ctrlName])) {
						Log::warning(sprintf(
							'Groups is unable to find the ctrl name "%s-%s-%s".', $appName, $modName, $ctrlName
						));

						return false;
					}

					if (!is_array($powers)) {
						continue;
					}

					foreach ($powers as $power) {
						$power = (int) $power;
						if (!isset($powerEnum[$power])) {
							Log::warning(sprintf(
								'Groups is unable to find the power "%s-%s-%s-%d".', $appName, $modName, $ctrlName, $power
							));

							return false;
						}

						$data[$appName][$modName][$ctrlName][] = $power;
					}
				}
			}
		}

		$data = base64_encode(serialize($data));
		$rowCount = $this->_dbGroups->modifyPermissionByPk($groupId, $data);
		return $rowCount;
	}
}
