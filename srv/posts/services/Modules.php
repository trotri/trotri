<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace posts\services;

use libsrv\AbstractService;
use posts\db\Modules AS DbModules;

/**
 * Modules class file
 * 业务层：业务处理类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Modules.php 1 2014-09-11 16:41:01Z Code Generator $
 * @package posts.services
 * @since 1.0
 */
class Modules extends AbstractService
{
	/**
	 * @var instance of posts\db\Modules
	 */
	protected $_dbModules = null;

	/**
	 * 构造方法：初始化数据库操作类
	 */
	public function __construct()
	{
		parent::__construct();

		$this->_dbModules = new DbModules();
	}

	/**
	 * 查询多条记录
	 * @param array $attributes
	 * @param string $order
	 * @param integer $limit
	 * @param integer $offset
	 * @return array
	 */
	public function findAllByAttributes(array $attributes = array(), $order = '', $limit = 0, $offset = 0)
	{
		$rows = $this->_dbModules->findAll($limit, $offset);
		return $rows;
	}

	/**
	 * 获取所有的ModuleName
	 * @return array
	 */
	public function getModuleNames()
	{
		$rows = $this->_dbModules->getModuleNames();
		return $rows;
	}

	/**
	 * 通过主键，查询一条记录
	 * @param integer $moduleId
	 * @return array
	 */
	public function findByPk($moduleId)
	{
		$row = $this->_dbModules->findByPk($moduleId);
		return $row;
	}

	/**
	 * 通过主键，获取某个列的值
	 * @param string $columnName
	 * @param integer $moduleId
	 * @return mixed
	 */
	public function getByPk($columnName, $moduleId)
	{
		$value = $this->_dbModules->getByPk($columnName, $moduleId);
		return $value;
	}

	/**
	 * 通过“主键ID”，获取“模型名称”
	 * @param integer $moduleId
	 * @return string
	 */
	public function getModuleNameByModuleId($moduleId)
	{
		$value = $this->getByPk('module_name', $moduleId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“类别表名”
	 * @param integer $moduleId
	 * @return string
	 */
	public function getModuleTblnameByModuleId($moduleId)
	{
		$value = $this->getByPk('module_tblname', $moduleId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“是否禁用”
	 * @param integer $moduleId
	 * @return string
	 */
	public function getForbiddenByModuleId($moduleId)
	{
		$value = $this->getByPk('forbidden', $moduleId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“描述”
	 * @param integer $moduleId
	 * @return string
	 */
	public function getDescriptionByModuleId($moduleId)
	{
		$value = $this->getByPk('description', $moduleId);
		return $value ? $value : '';
	}

}
