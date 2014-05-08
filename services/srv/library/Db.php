<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace srv\library;

use tfc\ap\Singleton;
use tfc\saf\DbProxy;

/**
 * Db abstract class file
 * 业务层：数据库操作基类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Db.php 1 2013-05-18 14:58:59Z huan.song $
 * @package srv.library
 * @since 1.0
 */
abstract class Db
{
	/**
	 * @var string 数据库配置名
	 */
	protected $_clusterName = null;

	/**
	 * @var string 表前缀
	 */
	protected $_tblPrefix = null;

	/**
	 * @var instance of tfc\saf\DbProxy
	 */
	protected $_dbProxy = null;

	/**
	 * @var array 用于缓存查询的结果
	 */
	protected $_caches = array();

	/**
	 * 获取多个结果集
	 * @param string $sql
	 * @param mixed $params
	 * @param integer $fetchMode
	 * @return array|false
	 */
	public function fetchAll($sql, $params = null, $fetchMode = \PDO::FETCH_ASSOC)
	{
		$name = sprintf(
			'fetchAll -- S:%s; P:%s; F:%d', $sql, md5(json_encode((array) $params)), $fetchMode
		);

		if ($this->hasCache($name)) {
			return $this->getCache($name);
		}

		$value = $this->getDbProxy()->fetchAll($sql, $params, $fetchMode);
		if ($value !== false) {
			$this->setCache($name, $value);
		}

		return $value;
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
		$name = sprintf(
			'fetch -- S:%s; P:%s; F:%d; C:%d; O:%d', $sql, md5(json_encode((array) $params)), $fetchMode, $cursor, $offset
		);

		if ($this->hasCache($name)) {
			return $this->getCache($name);
		}

		$value = $this->getDbProxy()->fetch($sql, $params, $fetchMode, $cursor, $offset);
		if ($value !== false) {
			$this->setCache($name, $value);
		}

		return $value;
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
		$name = sprintf(
			'fetchScalar -- S:%s; P:%s; C:%d', $sql, md5(json_encode((array) $params)), $columnNumber
		);

		if ($this->hasCache($name)) {
			return $this->getCache($name);
		}

		$value = $this->getDbProxy()->fetchScalar($sql, $params, $columnNumber);
		if ($value !== false) {
			$this->setCache($name, $value);
		}

		return $value;
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
		$name = sprintf(
			'fetchColumn -- S:%s; P:%s; C:%d', $sql, md5(json_encode((array) $params)), $columnNumber
		);

		if ($this->hasCache($name)) {
			return $this->getCache($name);
		}

		$value = $this->getDbProxy()->fetchColumn($sql, $params, $columnNumber);
		if ($value !== false) {
			$this->setCache($name, $value);
		}

		return $value;
	}

	/**
	 * 获取多个结果集，并且以键值对方式返回
	 * @param string $sql
	 * @param mixed $params
	 * @return array|false
	 */
	public function fetchPairs($sql, $params = null)
	{
		$name = sprintf(
			'fetchPairs -- S:%s; P:%s', $sql, md5(json_encode((array) $params))
		);

		if ($this->hasCache($name)) {
			return $this->getCache($name);
		}

		$rows = $this->fetchAll($sql, $params, \PDO::FETCH_NUM);
		if ($rows && is_array($rows)) {
			$data = array();
			foreach ($rows as $row) {
				if (isset($row[0]) && isset($row[1])) {
					$data[$row[0]] = $row[1];
				}
			}

			$this->setCache($name, $data);
			return $data;
		}

		return $rows;
	}

	/**
	 * 新增记录
	 * @param string $sql
	 * @param mixed $params
	 * @return integer|false
	 */
	public function insert($sql, $params = null)
	{
		$ret = $this->query($sql, $params);
		if ($ret) {
			$ret = $this->getDbProxy()->getLastInsertId();
			$this->clearCaches();
		}

		return false;
	}

	/**
	 * 编辑记录
	 * @param string $sql
	 * @param mixed $params
	 * @return integer|false
	 */
	public function update($sql, $params = null)
	{
		$ret = $this->query($sql, $params);
		if ($ret) {
			$ret = $this->getDbProxy()->getRowCount();
			$this->clearCaches();
		}

		return $ret;
	}

	/**
	 * 删除记录
	 * @param string $sql
	 * @param mixed $params
	 * @return integer|false
	 */
	public function delete($sql, $params = null)
	{
		$ret = $this->query($sql, $params);
		if ($ret) {
			$ret = $this->getDbProxy()->getRowCount();
			$this->clearCaches();
		}

		return $ret;
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
	 * 获取表前缀
	 * @return string
	 */
	public function getTblprefix()
	{
		if ($this->_tblPrefix === null) {
			$this->_tblPrefix = $this->getDbProxy()->getTblprefix();
		}

		return $this->_tblPrefix;
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

	/**
	 * 通过名称获取缓存数据
	 * @param string $name
	 * @return mixed
	 */
	public function getCache($name)
	{
		if ($this->hasCache($name)) {
			return $this->_caches[$name];
		}

		return null;
	}

	/**
	 * 设置缓存名称和缓存数据
	 * @param string $name
	 * @param mixed
	 * @return void
	 */
	public function setCache($name, $value)
	{
		$this->_caches[$name] = $value;
	}

	/**
	 * 通过缓存名称删除缓存数据
	 * @param string $name
	 * @return void
	 */
	public function removeCache($name)
	{
		if ($this->hasCache($name)) {
			unset($this->_caches[$name]);
		}
	}

	/**
	 * 获取所有的缓存数据
	 * @return array
	 */
	public function getCaches()
	{
		return $this->_caches;
	}

	/**
	 * 清除所有的缓存数据
	 * @return void
	 */
	public function clearCaches()
	{
		$this->_caches = array();
	}

	/**
	 * 通过数据名称判断数据数据是否已经存在
	 * @param string $name
	 * @return boolean
	 */
	public function hasCache($name)
	{
		return isset($this->_caches[$name]);
	}

}
