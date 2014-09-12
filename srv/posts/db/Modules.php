<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace posts\db;

use tdo\AbstractDb;
use posts\library\Constant;
use posts\library\TableNames;

/**
 * Modules class file
 * 业务层：数据库操作类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Modules.php 1 2014-09-11 16:41:01Z Code Generator $
 * @package posts.db
 * @since 1.0
 */
class Modules extends AbstractDb
{
	/**
	 * @var string 数据库配置名
	 */
	protected $_clusterName = Constant::DB_CLUSTER;

	/**
	 * 查询多条记录
	 * @param integer $limit
	 * @param integer $offset
	 * @return array
	 */
	public function findAll($limit = 0, $offset = 0)
	{
		$commandBuilder = $this->getCommandBuilder();
		$tableName = $this->getTblprefix() . TableNames::getModules();
		$attributes = array();

		$sql = 'SELECT SQL_CALC_FOUND_ROWS `module_id`, `module_name`, `module_tblname`, `forbidden`, `description` FROM ' . $tableName;
		$sql = $commandBuilder->applyLimit($sql, $limit, $offset);
		$ret = $this->fetchAllNoCache($sql, $attributes);
		if (is_array($ret)) {
			$ret['attributes'] = $attributes;
			$ret['order']      = '';
			$ret['limit']      = $limit;
			$ret['offset']     = $offset;
		}

		return $ret;
	}

	/**
	 * 通过主键，查询一条记录
	 * @param integer $moduleId
	 * @return array
	 */
	public function findByPk($moduleId)
	{
		if (($moduleId = (int) $moduleId) <= 0) {
			return false;
		}

		$tableName = $this->getTblprefix() . TableNames::getModules();
		$sql = 'SELECT `module_id`, `module_name`, `module_tblname`, `forbidden`, `description` FROM ' . $tableName . ' WHERE `module_id` = ?';
		return $this->fetchAssoc($sql, $moduleId);
	}

	/**
	 * 通过主键，获取某个列的值
	 * @param string $columnName
	 * @param integer $moduleId
	 * @return mixed
	 */
	public function getByPk($columnName, $moduleId)
	{
		$row = $this->findByPk($moduleId);
		if ($row && is_array($row) && isset($row[$columnName])) {
			return $row[$columnName];
		}

		return false;
	}

	/**
	 * 新增一条记录
	 * @param array $params
	 * @param boolean $ignore
	 * @return integer
	 */
	public function create(array $params = array(), $ignore = false)
	{
		$moduleName = isset($params['module_name']) ? trim($params['module_name']) : '';
		$moduleTblname = isset($params['module_tblname']) ? trim($params['module_tblname']) : '';
		$forbidden = isset($params['forbidden']) ? trim($params['forbidden']) : '';
		$description = isset($params['description']) ? $params['description'] : '';

		if ($moduleName === '' || $moduleTblname === '' || $forbidden === '') {
			return false;
		}

		$tableName = $this->getTblprefix() . TableNames::getModules();
		$attributes = array(
			'module_name' => $moduleName,
			'module_tblname' => $moduleTblname,
			'forbidden' => $forbidden,
			'description' => $description,
		);

		$sql = $this->getCommandBuilder()->createInsert($tableName, array_keys($attributes), $ignore);
		return $this->insert($sql, $attributes);
	}

	/**
	 * 通过主键，编辑一条记录
	 * @param integer $moduleId
	 * @param array $params
	 * @return integer
	 */
	public function modifyByPk($moduleId, array $params = array())
	{
		if (($moduleId = (int) $moduleId) <= 0) {
			return false;
		}

		$attributes = array();

		if (isset($params['module_name'])) {
			$moduleName = trim($params['module_name']);
			if ($moduleName !== '') {
				$attributes['module_name'] = $moduleName;
			}
			else {
				return false;
			}
		}

		if (isset($params['module_tblname'])) {
			$moduleTblname = trim($params['module_tblname']);
			if ($moduleTblname !== '') {
				$attributes['module_tblname'] = $moduleTblname;
			}
			else {
				return false;
			}
		}

		if (isset($params['forbidden'])) {
			$forbidden = trim($params['forbidden']);
			if ($forbidden !== '') {
				$attributes['forbidden'] = $forbidden;
			}
			else {
				return false;
			}
		}

		if (isset($params['description'])) {
			$attributes['description'] = $params['description'];
		}

		if ($attributes === array()) {
			return false;
		}

		$tableName = $this->getTblprefix() . TableNames::getModules();
		$sql = $this->getCommandBuilder()->createUpdate($tableName, array_keys($attributes), '`module_id` = ?');
		$attributes['module_id'] = $moduleId;
		return $this->update($sql, $attributes);
	}

	/**
	 * 通过主键，删除一条记录
	 * @param integer $moduleId
	 * @return integer
	 */
	public function removeByPk($moduleId)
	{
		if (($moduleId = (int) $moduleId) <= 0) {
			return false;
		}

		$tableName = $this->getTblprefix() . TableNames::getModules();
		$sql = $this->getCommandBuilder()->createDelete($tableName, '`module_id` = ?');
		return $this->delete($sql, $moduleId);
	}
}
