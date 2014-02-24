<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\ucenter\model;

use tfc\ap\Ap;
use tfc\ap\Registry;
use tfc\mvc\Mvc;
use tfc\saf\Log;
use koala\Model;
use library\Url;
use library\ErrorNo;
use library\UcenterFactory;

/**
 * Groups class file
 * 业务处理层类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Groups.php 1 2014-01-27 15:15:38Z huan.song $
 * @package modules.ucenter.model
 * @since 1.0
 */
class Groups extends Model
{
	/**
	 * 构造方法：初始化当前业务类对应的数据库操作类
	 */
	public function __construct()
	{
		$db = UcenterFactory::getDb('Groups');
		parent::__construct($db);
	}

	/**
	 * (non-PHPdoc)
	 * @see koala.Model::findByPk()
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
	 * 递归方式获取所有的组，默认用空格填充子类别左边用于和父类别错位（只返回ID和组名的键值对）
	 * @return array
	 */
	public function findPairs()
	{
		$data = array();
		$ret = $this->findLists();
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return $data;
		}

		foreach ($ret['data'] as $row) {
			$data[$row['group_id']] = $row['group_name'];
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
	public function findOptions($groupPid = 0, $padStr = '&nbsp;&nbsp;&nbsp;&nbsp;', $leftPad = '', $rightPad = null)
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

			$data = $this->findOptions($groupId, $padStr, $tmpLeftPad, $tmpRightPad);
			$ret = $ret + $data;
		}

		return $ret;
	}

	/**
	 * 通过主键，获取组名，并依此获取上级组名
	 * @param integer $value
	 * @return array
	 */
	public function getBreadcrumbs($value)
	{
		$breadcrumbs = array();

		$value = (int) $value;
		while ($value > 0) {
			$ret = $this->findByPk($value);
			if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
				$breadcrumbs[] = array(
					'label' => $ret['data']['group_name'],
					'href' => Url::getUrl('amcasmodify', Mvc::$controller, Mvc::$module, array('id' => $ret['data']['group_id']))
				);

				$value = $ret['data']['group_pid'];
			}
		}

		$breadcrumbs = array_reverse($breadcrumbs);
		return $breadcrumbs;
	}

	/**
	 * 通过主键，获取权限，并依此获取上级权限
	 * @param integer $value
	 * @return array
	 */
	public function getPermissions($value)
	{
		$permissions = array();

		$value = (int) $value;
		while ($value > 0) {
			$ret = $this->findByPk($value);
			if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
				$permissions[] = $ret['data']['permission'];
				$value = $ret['data']['group_pid'];
			}
		}

		$data = array();
		foreach ($permissions as $permission) {
			if (is_array($permission)) {
				foreach ($permission as $appName => $mods) {
					if (is_array($mods)) {
						foreach ($mods as $modName => $ctrls) {
							if (is_array($ctrls)) {
								foreach ($ctrls as $ctrlName => $acts) {
									if (is_array($acts)) {
										foreach ($acts as $actName) {
											if (!isset($data[$appName][$modName][$ctrlName])
												|| !in_array($actName, $data[$appName][$modName][$ctrlName])) {
												$data[$appName][$modName][$ctrlName][] = $actName;
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
	 * 新增一条记录
	 * @param array $params
	 * @return array
	 */
	public function create(array $params = array())
	{
		return $this->insert($params);
	}

	/**
	 * 通过主键，编辑一条记录
	 * @param integer $value
	 * @param array $params
	 * @return array
	 */
	public function modifyByPk($value, array $params)
	{
		return $this->updateByPk($value, $params);
	}

	/**
	 * (non-PHPdoc)
	 * @see koala.Model::getCleanRulesBeforeValidator()
	 */
	public function getCleanRulesBeforeValidator()
	{
		$output = array(
			'group_name' => array($this, 'cleanXss'),
			'description' => array($this, 'cleanXss'),
		);

		return $output;
	}

	/**
	 * 通过主键，编辑组的权限
	 * @param integer $value
	 * @param array $params
	 * @return array
	 */
	public function amcasmodifyByPk($value, array $params)
	{
		$amcas = isset($params['amcas']) ? $params['amcas'] : null;
		if (!is_array($amcas)) {
			$errNo = ErrorNo::ERROR_ARGS_UPDATE;
			$errMsg = $this->_('ERROR_MSG_ERROR_ARGS_UPDATE');
			Log::warning(sprintf(
				'%s pk "%d", amcas "%s"', $errMsg, $value, serialize($amcas)
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'id' => $value
			);
		}

		$data = array();
		foreach ($amcas as $appName => $mods) {
			if (is_array($mods)) {
				$appName = strtolower($appName);
				foreach ($mods as $modName => $ctrls) {
					if (is_array($ctrls)) {
						$modName = strtolower($modName);
						foreach ($ctrls as $ctrlName => $acts) {
							if (is_array($acts)) {
								$ctrlName = strtolower($ctrlName);
								foreach ($acts as $actName) {
									$data[$appName][$modName][$ctrlName][] = strtolower($actName);
								}
							}
						}
					}
				}
			}
		}

		return $this->updateByPk($value, array('permission' => serialize($data)));
	}

	/**
	 * 通过主键，删除一条记录，并递归删除所有子记录
	 * @param integer $value
	 * @return array
	 */
	public function removeByPk($value)
	{
		$groups = $this->findOptions($value);
		$pks = array_keys($groups);
		array_unshift($pks, $value);

		$ret = $this->batchDeleteByPk($pks);
		return $ret;
	}

	/**
	 * (non-PHPdoc)
	 * @see koala.Model::getInsertRules()
	 */
	public function getInsertRules()
	{
		$elements = UcenterFactory::getElements('Groups');
		$type = $elements::TYPE_FILTER;
		$output = array(
			'group_pid' => $elements->getGroupPid($type),
			'group_name' => $elements->getGroupName($type),
			'sort' => $elements->getSort($type),
			'description' => $elements->getDescription($type),
		);

		return $output;
	}

	/**
	 * (non-PHPdoc)
	 * @see koala.Model::getUpdateRules()
	 */
	public function getUpdateRules()
	{
		$elements = UcenterFactory::getElements('Groups');
		$type = $elements::TYPE_FILTER;
		$output = array(
			'group_pid' => $elements->getGroupPid($type),
			'group_name' => $elements->getGroupName($type),
			'sort' => $elements->getSort($type),
			'description' => $elements->getDescription($type),
		);

		return $output;
	}

	/**
	 * 通过父ID和事件名统计记录数
	 * @param string $groupName
	 * @return integer
	 */
	public function countByGroupName($groupName)
	{
		$ret = $this->countByAttributes(array(
			'group_name' => $groupName,
		));

		if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
			return $ret['total'];
		}

		return false;
	}

	/**
	 * 通过所有的应用名，获取Tab标签
	 * @return array
	 */
	public function getTabsByAppAmcas()
	{
		$mod = UcenterFactory::getModel('Amcas');
		$ret = $mod->findPairsByAttributes(array('amca_name', 'prompt'), array('category' => 'app'), 'sort');
		$data = array();
		if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
			$data = $ret['data'];
		}

		$ret = array();
		$active = true;
		foreach ($data as $amcaName => $prompt) {
			$ret[$amcaName] = array(
				'tid' => $amcaName,
				'prompt' => $prompt,
				'active' => $active
			);

			$active = false;
		}

		return $ret;
	}

}
