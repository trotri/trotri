<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\generator\model;

use tfc\ap\Ap;
use tfc\ap\Registry;
use koala\Model;
use library\ErrorNo;
use library\GeneratorFactory;

/**
 * Groups class file
 * 业务处理层类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Groups.php 1 2013-05-18 14:58:59Z huan.song $
 * @package modules.generator.model
 * @since 1.0
 */
class Groups extends Model
{
	/**
	 * 构造方法：初始化当前业务类对应的数据库操作类
	 */
	public function __construct()
	{
		$db = GeneratorFactory::getDb('Groups');
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
		$generatorId = isset($params['generator_id']) ? (int) $params['generator_id'] : 0;

		$attributes = array();
		if ($generatorId > 0) {
			$attributes['generator_id'] = $generatorId;
		}

		$ret = $this->findIndexByAttributes($attributes, $order, $pageNo);
		return $ret;
	}

	/**
	 * 新增一条记录
	 * @param array $params
	 * @return array
	 */
	public function create(array $params)
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
		unset($params['generator_id']);
		return $this->updateByPk($value, $params);
	}

	/**
	 * 通过generator_id获取所有Groups
	 * @param integer $value
	 * @param boolean $joinDafault
	 * @return array
	 */
	public function getGroupsByGeneratorId($value, $joinDafault = false)
	{
		$ret = $this->findPairsByAttributes(array('group_id', 'prompt'), array('generator_id' => $value), 'sort');
		$groups = array();
		if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
			$groups = $ret['data'];
		}

		$default = array();
		if ($joinDafault) {
			$ret = $this->findPairsByAttributes(array('group_id', 'prompt'), array('generator_id' => 0), 'sort');
			if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
				$default = $ret['data'];
			}
		}

		$ret = $default + $groups;
		return $ret;
	}

	/**
	 * 获取generator_id值
	 * @return integer
	 */
	public function getGeneratorId()
	{
		$generatorId = Ap::getRequest()->getInteger('generator_id');
		if ($generatorId <= 0) {
			$id = Ap::getRequest()->getInteger('id');
			$generatorId = $this->getGeneratorIdByGroupId($id);
		}

		return $generatorId;
	}

	/**
	 * 通过group_id获取generator_name值
	 * @param integer $value
	 * @return string
	 */
	public function getGeneratorNameByGroupId($value)
	{
		$generatorId = $this->getGeneratorIdByGroupId($value);
		$generatorName = GeneratorFactory::getModel('Generators')->getGeneratorNameByGeneratorId($generatorId);
		return $generatorName;
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
	 * 通过group_id获取generator_id值
	 * @param integer $value
	 * @return string
	 */
	public function getGeneratorIdByGroupId($value)
	{
		$value = (int) $value;
		$name = __METHOD__ . '_' . $value;
		if (!Registry::has($name)) {
			$ret = $this->getByPk('generator_id', $value);
			$generatorId = ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) ? 0 : $ret['generator_id'];
			Registry::set($name, $generatorId);
		}

		return Registry::get($name);
	}

	/**
	 * (non-PHPdoc)
	 * @see koala.Model::getInsertRules()
	 */
	public function getInsertRules()
	{
		$elements = GeneratorFactory::getElements('Groups');
		$type = $elements::TYPE_FILTER;

		$output = array(
			'group_name' => $elements->getGroupName($type),
			'prompt' => $elements->getPrompt($type),
			'generator_id' => $elements->getGeneratorId($type),
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
		$elements = GeneratorFactory::getElements('Groups');
		$type = $elements::TYPE_FILTER;

		$output = array(
			'group_name' => $elements->getGroupName($type),
			'prompt' => $elements->getPrompt($type),
			'sort' => $elements->getSort($type),
		);

		return $output;
	}
}
