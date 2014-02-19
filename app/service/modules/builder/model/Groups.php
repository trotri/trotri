<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\builder\model;

use tfc\ap\Ap;
use tfc\ap\Registry;
use koala\Model;
use library\ErrorNo;
use library\BuilderFactory;

/**
 * Groups class file
 * 业务处理层类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Groups.php 1 2014-01-19 13:18:49Z huan.song $
 * @package modules.builder.model
 * @since 1.0
 */
class Groups extends Model
{
	/**
	 * 构造方法：初始化当前业务类对应的数据库操作类
	 */
	public function __construct()
	{
		$db = BuilderFactory::getDb('Groups');
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
		$builderId = isset($params['builder_id']) ? (int) $params['builder_id'] : 0;

		$attributes = array();
		if ($builderId > 0) {
			$attributes['builder_id'] = $builderId;
		}

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
		unset($params['builder_id']);
		return $this->updateByPk($value, $params);
	}

	/**
	 * (non-PHPdoc)
	 * @see koala.Model::getInsertRules()
	 */
	public function getInsertRules()
	{
		$elements = BuilderFactory::getElements('Groups');
		$type = $elements::TYPE_FILTER;
		$output = array(
			'group_name' => $elements->getGroupName($type),
			'prompt' => $elements->getPrompt($type),
			'builder_id' => $elements->getBuilderId($type),
			'sort' => $elements->getSort($type),
		);

		return $output;
	}

	/**
	 * (non-PHPdoc)
	 * @see koala.Model::getUpdateRules()
	 */
	public function getUpdateRules()
	{
		$elements = BuilderFactory::getElements('Groups');
		$type = $elements::TYPE_FILTER;
		$output = array(
			'group_name' => $elements->getGroupName($type),
			'prompt' => $elements->getPrompt($type),
			'sort' => $elements->getSort($type),
		);

		return $output;
	}

	/**
	 * (non-PHPdoc)
	 * @see koala.Model::getCleanRulesBeforeValidator()
	 */
	public function getCleanRulesBeforeValidator()
	{
		$output = array(
			'group_name' => array($this, 'cleanXss'),
			'prompt' => array($this, 'cleanXss'),
			'description' => array($this, 'cleanXss'),
		);

		return $output;
	}

	/**
	 * 通过group_id获取group_name值
	 * @param integer $value
	 * @return string
	 */
	public function getGroupNameByGroupId($value)
	{
		$value = (int) $value;
		$name = __METHOD__ . '_' . $value;
		if (!Registry::has($name)) {
			$ret = $this->getByPk('group_name', $value);
			$groupName = ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) ? '' : $ret['group_name'];
			Registry::set($name, $groupName);
		}

		return Registry::get($name);
	}

	/**
	 * 通过group_id获取builder_id值
	 * @param integer $value
	 * @return integer
	 */
	public function getBuilderIdByGroupId($value)
	{
		$value = (int) $value;
		$name = __METHOD__ . '_' . $value;
		if (!Registry::has($name)) {
			$ret = $this->getByPk('builder_id', $value);
			$builderId = ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) ? 0 : $ret['builder_id'];
			Registry::set($name, $builderId);
		}

		return Registry::get($name);
	}

	/**
	 * 通过group_id获取builder_name值
	 * @param integer $value
	 * @return string
	 */
	public function getBuilderNameByGroupId($value)
	{
		$builderId = $this->getBuilderIdByGroupId($value);
		$builderName = BuilderFactory::getModel('Builders')->getBuilderNameByBuilderId($builderId);
		return $builderName;
	}

	/**
	 * 获取builder_id值
	 * @return integer
	 */
	public function getBuilderId()
	{
		$builderId = Ap::getRequest()->getInteger('builder_id');
		if ($builderId <= 0) {
			$id = Ap::getRequest()->getInteger('id');
			$builderId = $this->getBuilderIdByGroupId($id);
		}

		return $builderId;
	}

	/**
	 * 通过group_id获取所有Groups
	 * @param integer $value
	 * @param boolean $joinDafault
	 * @return array
	 */
	public function getGroupsByGroupId($value, $joinDafault = false)
	{
		$ret = $this->findPairsByAttributes(array('group_id', 'prompt'), array('builder_id' => $value), 'sort');
		$groups = array();
		if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
			$groups = $ret['data'];
		}

		$default = array();
		if ($joinDafault) {
			$ret = $this->findPairsByAttributes(array('group_id', 'prompt'), array('builder_id' => 0), 'sort');
			if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
				$default = $ret['data'];
			}
		}

		$ret = $default + $groups;
		return $ret;
	}
}
