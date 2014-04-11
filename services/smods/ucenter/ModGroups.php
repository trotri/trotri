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

use tfc\util\Language;
use slib\BaseModel;
use slib\Data;
use slib\ErrorNo;
use smods\ucenter\validator\UserGroupsGroupPidExists;
use smods\ucenter\validator\UserGroupsGroupNameUnique;

/**
 * ModGroups class file
 * 业务层：模型类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: ModGroups.php 1 2014-04-10 17:43:20Z Code Generator $
 * @package smods.ucenter
 * @since 1.0
 */
class ModGroups extends BaseModel
{
	/**
	 * 构造方法：初始化数据库操作类和语言国际化管理类
	 * @param tfc\util\Language $language
	 * @param integer $tableNum 分表数字，如果 >= 0 表示分表操作
	 */
	public function __construct(Language $language, $tableNum = -1)
	{
		$db = new DbGroups($tableNum);
		parent::__construct($db, $language);
	}

	/**
	 * (non-PHPdoc)
	 * @see slib.BaseModel::findByPk()
	 */
	public function findByPk($value)
	{
		$ret = parent::findByPk($value);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return $ret;
		}

		$ret['data']['permission'] = unserialize($ret['data']['permission']);
		if (!is_array($ret['data']['permission'])) {
			$ret['data']['permission'] = array();
		}

		return $ret;
	}

	/**
	 * 通过组名，查询一条记录。
	 * @param string $value
	 * @return array
	 */
	public function findByGroupName($value)
	{
		$ret = parent::findByAttributes(array('group_name' => trim($value)));
		return $ret;
	}

	/**
	 * 获取所有的组名
	 * @return array
	 */
	public function getGroupNames()
	{
		$ret = $this->findPairsByAttributes(array('group_id', 'group_name'), array(), 'sort');
		$data = array();
		if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
			$data = $ret['data'];
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
		$ret = $this->findAllByAttributes(array('group_pid' => (int) $groupPid), 'sort');
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return $ret;
		}

		$groups = $ret['data'];
		$tmpLeftPad = is_string($leftPad) ? $leftPad . $padStr : null;
		$tmpRightPad = is_string($rightPad) ? $rightPad . $padStr : null;

		$data = array();
		foreach ($groups as $row) {
			$row['group_name'] = $leftPad . $row['group_name'] . $rightPad;
			$data[] = $row;

			$ret = $this->findLists($row['group_id'], $padStr, $tmpLeftPad, $tmpRightPad);
			if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
				return $ret;
			}

			$data = array_merge($data, $ret['data']);
		}

		return array(
			'err_no' => ErrorNo::SUCCESS_NUM,
			'err_msg' => $this->_('ERROR_MSG_SUCCESS_SELECT'),
			'data' => $data
		);
	}

	/**
	 * 递归方式获取所有的组，默认用空格填充子类别左边用于和父类别错位（可用于Select表单的Option选项）
	 * @param integer $groupPid
	 * @param string $padStr
	 * @param string $leftPad
	 * @param string $rightPad
	 * @return array
	 */
	public function getOptions($groupPid = 0, $padStr = '&nbsp;&nbsp;&nbsp;&nbsp;', $leftPad = '', $rightPad = null)
	{
		$ret = $this->findPairsByAttributes(array('group_id', 'group_name'), array('group_pid' => (int) $groupPid), 'sort');
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return array();
		}

		$groups = $ret['data'];
		$tmpLeftPad = is_string($leftPad) ? $leftPad . $padStr : null;
		$tmpRightPad = is_string($rightPad) ? $rightPad . $padStr : null;

		$ret = array();
		foreach ($groups as $groupId => $groupName) {
			$ret[$groupId] = $leftPad . $groupName . $rightPad;

			$data = $this->getOptions($groupId, $padStr, $tmpLeftPad, $tmpRightPad);
			$ret = $ret + $data;
		}

		return $ret;
	}

	/**
	 * 通过ID，获取组名
	 * @param integer $value
	 * @return string
	 */
	public function getGroupNameById($value)
	{
		return $this->getColById('group_name', $value);
	}

	/**
	 * 通过主键，获取权限，并递归获取父级权限、父父级权限等
	 * @param integer $groupId
	 * @return array
	 */
	public function getPermissions($groupId)
	{
		$permissions = array();

		// 获取组ID权限、父级权限、父父级权限等
		$groupId = (int) $groupId;
		while ($groupId > 0) {
			$ret = $this->findByPk($groupId);
			if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
				$permissions[] = $ret['data']['permission'];
				$groupId = $ret['data']['group_pid'];
			}
		}

		// 将获取的权限去重
		$data = array();
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
	 * 新增一条记录，不新增“权限设置”字段
	 * @param array $params
	 * @return array
	 */
	public function create(array $params = array())
	{
		if (isset($params['permission'])) { unset($params['permission']); }
		return $this->autoInsert($params);
	}

	/**
	 * 通过主键，编辑一条记录，不编辑“权限设置”字段
	 * @param integer $value
	 * @param array $params
	 * @return array
	 */
	public function modifyByPk($value, array $params)
	{
		UserGroupsGroupNameUnique::$id = $value;

		if (isset($params['permission'])) { unset($params['permission']); }
		return $this->autoUpdateByPk($value, $params);
	}

	/**
	 * 通过主键，删除一条记录，并递归删除所有子记录
	 * @param integer $value
	 * @return array
	 */
	public function deleteByPk($value)
	{
		$groups = $this->getOptions($value);
		$pks = array_keys($groups);
		array_unshift($pks, $value);

		$ret = $this->batchDeleteByPk($pks);
		return $ret;
	}

	/**
	 * (non-PHPdoc)
	 * @see slib.BaseModel::validate()
	 */
	public function validate(array $attributes = array(), $required = false, $opType = '')
	{		
		UserGroupsGroupNameUnique::$object = $this;
		UserGroupsGroupNameUnique::$opType = $opType;

		UserGroupsGroupPidExists::$object = $this;
		UserGroupsGroupPidExists::$opType = $opType;
		UserGroupsGroupPidExists::$pid = isset($attributes['group_pid']) ? $attributes['group_pid'] : -1;

		$data = Data::getInstance($this->_className, $this->_moduleName, $this->getLanguage());
		$rules = $data->getRules(array(
			'group_pid',
			'group_name',
			'sort',
		));

		return $this->filterRun($rules, $attributes, $required);
	}

	/**
	 * (non-PHPdoc)
	 * @see slib.BaseModel::_cleanPreValidator()
	 */
	protected function _cleanPreValidator(array $attributes = array(), $opType = '')
	{
		$rules = array(
			'group_pid' => 'intval',
			'group_name' => 'trim',
			// 'sort' => 'intval',
			'permission' => 'trim',
			'description' => 'trim',
		);

		return $this->_clean($rules, $attributes);
	}

	/**
	 * (non-PHPdoc)
	 * @see slib.BaseModel::_cleanPostValidator()
	 */
	protected function _cleanPostValidator(array $attributes = array(), $opType = '')
	{
		$rules = array(
		);

		return $this->_clean($rules, $attributes);
	}

}
