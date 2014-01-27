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
use koala\Model;
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
	 * 查询数据
	 * @param array $params
	 * @param string $order
	 * @param integer $pageNo
	 * @return array
	 */
	public function search(array $params = array(), $order = '', $pageNo = 0)
	{
		$attributes = array();
		//--待开发--
		$ret = $this->findIndexByAttributes($attributes, $order, $pageNo);
		return $ret;
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
		//--待开发--
		return $this->updateByPk($value, $params);
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
			'permission' => $elements->getPermission($type),
		);

		return $output;
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

}
