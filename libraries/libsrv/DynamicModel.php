<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace libsrv;

use tfc\ap\ErrorException;
use tfc\saf\Log;
use tdo\DynamicDb;

/**
 * DynamicModel abstract class file
 * 业务层：动态模型基类，自动读取和操作数据
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: DynamicModel.php 1 2013-05-18 14:58:59Z huan.song $
 * @package libsrv
 * @since 1.0
 */
abstract class DynamicModel extends AbstractModel
{
	/**
	 * @var string 缺省的表名与分表数字之间的连接符
	 */
	const DEFAULT_TABLE_NUM_JOIN = '_';

	/**
	 * @var string 表名
	 */
	protected $_tableName = '';

	/**
	 * @var integer 分表数字，如果 >= 0 表示分表操作
	 */
	protected $_tableNum = -1;

	/**
	 * @var string 表名与分表数字之间的连接符
	 */
	protected $_tableNumJoin = self::DEFAULT_TABLE_NUM_JOIN;

	/**
	 * 构造方法：初始化分表数字
	 * @param integer $tableNum 分表数字，如果 >= 0 表示分表操作
	 */
	public function __construct($tableNum = -1)
	{
		parent::__construct();

		$this->_tableNum = (int) $tableNum;
	}

	/**
	 * 通过多个字段名和值，获取主键的值，字段之间用简单的AND连接。不支持联合主键
	 * @param array $attributes
	 * @return mixed
	 */
	public function getPkByAttributes(array $attributes = array())
	{
		$value = $this->getDb()->getPkByAttributes($attributes);
		return $value;
	}

	/**
	 * 通过多个字段名和值，获取某个列的值，字段之间用简单的AND连接，字段之间用简单的AND连接
	 * @param string $columnName
	 * @param array $attributes
	 * @return mixed
	 */
	public function getByAttributes($columnName, array $attributes = array())
	{
		$value = $this->getDb()->getByAttributes($columnName, $attributes);
		return $value;
	}

	/**
	 * 通过多个字段名和值，查询两个字段记录，字段之间用简单的AND连接，并且以键值对方式返回
	 * @param array $columnNames
	 * @param array $attributes
	 * @param string $order
	 * @param integer $limit
	 * @param integer $offset
	 * @return array
	 */
	public function findPairsByAttributes(array $columnNames, array $attributes = array(), $order = '', $limit = 0, $offset = 0)
	{
		$rows = $this->getDb()->findPairsByAttributes($columnNames, $attributes, $order, $limit, $offset);
		return $rows;
	}

	/**
	 * 通过多个字段名和值，查询多条记录，字段之间用简单的AND连接，只查询指定的字段
	 * @param array $columnNames
	 * @param array $attributes
	 * @param string $order
	 * @param integer $limit
	 * @param integer $offset
	 * @param string $option
	 * @return array
	 */
	public function findColumnsByAttributes(array $columnNames, array $attributes = array(), $order = '', $limit = 0, $offset = 0, $option = '')
	{
		$condition = $this->getDb()->getCommandBuilder()->createAndCondition(array_keys($attributes));
		return $this->findColumnsByCondition($columnNames, $condition, $attributes, $order, $limit, $offset, $option);
	}

	/**
	 * 通过多个字段名和值，查询多条记录，字段之间用简单的AND连接
	 * @param array $attributes
	 * @param string $order
	 * @param integer $limit
	 * @param integer $offset
	 * @param string $option
	 * @return array
	 */
	public function findAllByAttributes(array $attributes = array(), $order = '', $limit = 0, $offset = 0, $option = '')
	{
		$condition = $this->getDb()->getCommandBuilder()->createAndCondition(array_keys($attributes));
		return $this->findAllByCondition($condition, $attributes, $order, $limit, $offset, $option);
	}

	/**
	 * 通过多个字段名和值，统计记录数，字段之间用简单的AND连接
	 * @param array $attributes
	 * @return integer
	 */
	public function countByAttributes(array $attributes = array())
	{
		$total = $this->getDb()->countByAttributes($attributes);
		return $total;
	}

	/**
	 * 通过多个字段名和值，查询一条记录，字段之间用简单的AND连接
	 * @param array $attributes
	 * @return array
	 */
	public function findByAttributes(array $attributes = array())
	{
		$row = $this->getDb()->findByAttributes($attributes);
		return $row;
	}

	/**
	 * 获取表中所有的记录
	 * @param string $order
	 * @param integer $limit
	 * @param integer $offset
	 * @param string $option
	 * @return array
	 */
	public function findAll($order = '', $limit = 0, $offset = 0, $option = '')
	{
		return $this->findAllByCondition(1, null, $order, $limit, $offset, $option);
	}

	/**
	 * 通过条件，查询两个字段记录，并且以键值对方式返回
	 * @param array $columnNames
	 * @param string $condition
	 * @param mixed $params
	 * @param string $order
	 * @param integer $limit
	 * @param integer $offset
	 * @return array
	 */
	public function findPairsByCondition(array $columnNames, $condition, $params = null, $order = '', $limit = 0, $offset = 0)
	{
		$rows = $this->getDb()->findPairsByCondition($columnNames, $condition, $params, $order, $limit, $offset);
		return $rows;
	}

	/**
	 * 通过条件，查询多条记录，只查询指定的字段
	 * @param string $condition
	 * @param mixed $params
	 * @param string $order
	 * @param integer $limit
	 * @param integer $offset
	 * @param string $option
	 * @return array
	 */
	public function findColumnsByCondition(array $columnNames, $condition, $params = null, $order = '', $limit = 0, $offset = 0, $option = '')
	{
		$db = $this->getDb();
		$isCached = $db->isCached; // 记录原始数据
		if ($option === 'SQL_CALC_FOUND_ROWS' && $db->isCached) {
			$db->isCached = false; // 不记缓存
		}

		$rows = $db->findColumnsByCondition($columnNames, $condition, $params, $order, $limit, $offset, $option);
		if ($rows && $option === 'SQL_CALC_FOUND_ROWS') {
			$total = $db->getFoundRows();
			$rows = array(
				'rows' => $rows,
				'total' => $total,
				'attributes' => $params,
				'order' => $order,
				'limit' => $limit,
				'offset' => $offset,
			);
		}

		$db->isCached = $isCached; // 还原原始数据
		return $rows;
	}

	/**
	 * 通过条件，查询多条记录，如果$option=SQL_CALC_FOUND_ROWS，则不记录缓存，并返回总记录行数
	 * @param string $condition
	 * @param mixed $params
	 * @param string $order
	 * @param integer $limit
	 * @param integer $offset
	 * @param string $option
	 * @return array
	 */
	public function findAllByCondition($condition, $params = null, $order = '', $limit = 0, $offset = 0, $option = '')
	{
		$db = $this->getDb();
		$isCached = $db->isCached; // 记录原始数据
		if ($option === 'SQL_CALC_FOUND_ROWS' && $db->isCached) {
			$db->isCached = false; // 不记缓存
		}

		$rows = $db->findAllByCondition($condition, $params, $order, $limit, $offset, $option);
		if ($rows && $option === 'SQL_CALC_FOUND_ROWS') {
			$total = $db->getFoundRows();
			$rows = array(
				'rows' => $rows,
				'total' => $total,
				'attributes' => $params,
				'order' => $order,
				'limit' => $limit,
				'offset' => $offset,
			);
		}

		$db->isCached = $isCached; // 还原原始数据
		return $rows;
	}

	/**
	 * 通过条件，统计记录数
	 * @param string $condition
	 * @param mixed $params
	 * @return integer
	 */
	public function countByCondition($condition, $params = null)
	{
		$total = $this->getDb()->countByCondition($condition, $params);
		return $total;
	}

	/**
	 * 通过条件，获取主键的值。不支持联合主键
	 * @param string $condition
	 * @param mixed $params
	 * @return mixed
	 */
	public function getPkByCondition($condition, $params = null)
	{
		$value = $this->getDb()->getPkByCondition($condition, $params);
		return $value;
	}

	/**
	 * 通过条件，获取某个列的值
	 * @param string $columnName
	 * @param string $condition
	 * @param mixed $params
	 * @return mixed
	 */
	public function getByCondition($columnName, $condition, $params = null)
	{
		$value = $this->getDb()->getByCondition($columnName, $condition, $params);
		return $value;
	}

	/**
	 * 通过条件，查询一条记录
	 * @param string $condition
	 * @param mixed $params
	 * @return array
	 */
	public function findByCondition($condition, $params = null)
	{
		$row = $this->getDb()->findByCondition($condition, $params);
		return $row;
	}

	/**
	 * 通过主键，获取某个列的值。不支持联合主键
	 * @param string $columnName
	 * @param integer $value
	 * @return mixed
	 */
	public function getByPk($columnName, $value)
	{
		if (($value = $this->cleanPositiveInteger($value)) === false) {
			return false;
		}

		$value = $this->getDb()->getByPk($columnName, $value);
		return $value;
	}

	/**
	 * 通过主键，查询一条记录。不支持联合主键
	 * @param integer $value
	 * @return array
	 */
	public function findByPk($value)
	{
		if (($value = $this->cleanPositiveInteger($value)) === false) {
			return false;
		}

		$row = $this->getDb()->findByPk($value);
		return $row;
	}

	/**
	 * 获取"SELECT SQL_CALC_FOUND_ROWS"语句的查询总数
	 * @return integer
	 */
	public function getFoundRows()
	{
		return $this->getDb()->getFoundRows();
	}

	/**
	 * 设置数据库操作类
	 * @param tdo\DynamicDb $db
	 * @return instance of libsrv\DynamicModel
	 * @throws ErrorException 如果DB类不存在，抛出异常
	 * @throws ErrorException 如果获取的实例不是tdo\DynamicDb类的子类，抛出异常
	 */
	public function setDb(DynamicDb $db = null)
	{
		if ($db === null) {
			$className = $this->getSrvName() . '\\db\\' . $this->getClassName();
			if (!class_exists($className)) {
				throw new ErrorException(sprintf(
					'DynamicModel is unable to find the DB class "%s".', $className
				));
			}

			$db = new $className($this->getTableName());
			if (!$db instanceof DynamicDb) {
				throw new ErrorException(sprintf(
					'DynamicModel DB class "%s" is not instanceof tdo\DynamicDb.', $className
				));
			}
		}

		$this->_db = $db;
		return $this;
	}

	/**
	 * 获取表名
	 * @return string
	 */
	public function getTableName()
	{
		static $tableName = null;

		if ($tableName === null) {
			if (($tableName = trim($this->_tableName)) === '') {
				$tableName = $this->getClassName();
			}

			if ($this->_tableNum >= 0) {
				$tableName .= $this->_tableNumJoin . $this->_tableNum;
			}
		}

		return $tableName;
	}
}
