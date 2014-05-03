<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace srv;

use tfc\ap\Singleton;
use tfc\saf\DbProxy;

/**
 * Db abstract class file
 * 业务层：数据库操作基类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Db.php 1 2013-05-18 14:58:59Z huan.song $
 * @package srv
 * @since 1.0
 */
abstract class Db
{
	/**
	 * @var string 数据库配置名
	 */
	protected $_clusterName = null;

	/**
	 * @var instance of tfc\saf\DbProxy
	 */
	protected $_dbProxy = null;

	/**
	 * 获取数据库操作类
	 * @return tfc\saf\DbProxy
	 */
	public function getDbProxy()
	{
		if ($this->_dbProxy === null) {
			$clusterName = $this->getClusterName();
			$className = 'tfc\\saf\\DbProxy::' . $clusterName;
			if (($dbProxy = Singleton::get($className)) === null) {
				$dbProxy = new DbProxy($clusterName);
				Singleton::set($className, $dbProxy);
			}

			$this->_dbProxy = $dbProxy;
		}

		return $this->_dbProxy;
	}

	/**
	 * 获取多个结果集
	 * @param string $sql
	 * @param mixed $params
	 * @param integer $fetchMode
	 * @return array|false
	 */
	public function fetchAll($sql, $params = null, $fetchMode = \PDO::FETCH_ASSOC)
	{
		return $this->getDbProxy()->fetchAll($sql, $params, $fetchMode);
	}

	/**
	 * 获取一条结果集
	 * @param string $sql
	 * @param mixed $params
	 * @param integer $fetchMode
	 * @param integer $cursor
	 * @param integer $offset
	 * @return array|false
	 */
	public function fetch($sql, $params = null, $fetchMode = \PDO::FETCH_ASSOC, $cursor = null, $offset = null)
	{
		return $this->getDbProxy()->fetch($sql, $params, $fetchMode, $cursor, $offset);
	}

	/**
	 * 获取多个结果集中指定列的结果
	 * @param string $sql
	 * @param mixed $params
	 * @param integer $columnNumber
	 * @return array|false
	 */
	public function fetchScalar($sql, $params = null, $columnNumber = 0)
	{
		return $this->getDbProxy()->fetchScalar($sql, $params, $columnNumber);
	}

	/**
	 * 获取一个结果集中指定列的结果
	 * @param string $sql
	 * @param mixed $params
	 * @param integer $columnNumber
	 * @return mixed
	 */
	public function fetchColumn($sql, $params = null, $columnNumber = 0)
	{
		return $this->getDbProxy()->fetchColumn($sql, $params, $columnNumber);
	}

	/**
	 * 获取多个结果集，并且以键值对方式返回
	 * @param string $sql
	 * @param mixed $params
	 * @return mixed
	 */
	public function fetchPairs($sql, $params = null)
	{
		$rows = $this->fetchAll($sql, $params, \PDO::FETCH_COLUMN);
		if ($rows && is_array($rows)) {
			$data = array();
			foreach ($rows as $row) {
				$data[$row[0]] = $row[1];
			}

			return $data;
		}

		return $rows;
	}

	/**
	 * 新增一条记录
	 * @param string $sql
	 * @param mixed $params
	 * @return integer
	 */
	public function insert($sql, $params = null)
	{
		if ($this->query($sql, $params)) {
			return $this->getDbProxy()->getLastInsertId();
		}

		return false;
	}

	/**
	 * 编辑一条记录
	 * @param string $sql
	 * @param mixed $params
	 * @return integer
	 */
	public function update($sql, $params = null)
	{
		if ($this->query($sql, $params)) {
			return $this->getDbProxy()->getRowCount();
		}

		return false;
	}

	/**
	 * 删除一条记录
	 * @param string $sql
	 * @param mixed $params
	 * @return integer
	 */
	public function delete($sql, $params = null)
	{
		if ($this->query($sql, $params)) {
			return $this->getDbProxy()->getRowCount();
		}

		return false;
	}

	/**
	 * 执行数据库操作
	 * @param string $sql
	 * @param mixed $params
	 * @return boolean
	 */
	public function query($sql, $params = null)
	{
		$params = $this->quoteValue($params);
		return $this->getDbProxy()->query($sql, $params);
	}

	/**
	 * 获取最后一次插入记录的ID
	 * @return integer
	 */
	public function getLastInsertId()
	{
		return $this->getDbProxy()->getLastInsertId();
	}

	/**
	 * 获取SQL语句执行后影响的行数
	 * @return integer
	 */
	public function getRowCount()
	{
		return $this->getDbProxy()->getRowCount();
	}

	/**
	 * 防止SQL注入，对字符进行处理，不支持二维数组
	 * @param mixed $params
	 * @return mixed
	 */
	public function quoteValue($params = null)
	{
		if ($params === null) {
			return $params;
		}

		$driver = $this->getDbProxy()->getDriver();
		if (!is_array($params)) {
			return $driver->quoteValue($params);
		}

		$attributes = array();
		foreach ($params as $key => $value) {
			$attributes[$key] = $driver->quoteValue($value);
		}

		return $attributes;
	}

	/**
	 * 获取创建简单的执行命令类
	 * @return tdo\CommandBuilder
	 */
	public function getCommandBuilder()
	{
		return Singleton::getInstance('tdo\\CommandBuilder');
	}

	/**
	 * 获取数据库配置名
	 * @return string
	 */
	public function getClusterName()
	{
		return $this->_clusterName;
	}

}
