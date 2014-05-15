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
	 * @var string 表名
	 */
	protected $_tableName;

	/**
	 * 构造方法：初始化表名
	 * @param string $tableName
	 */
	public function __construct($tableName = '')
	{
		parent::__construct();

		if (($tableName = trim($tableName)) === '') {
			$tableName = $this->getClassName();
		}

		$this->_tableName = $tableName;
	}

	/**
	 * 通过多个字段名和值，获取主键的值，字段之间用简单的AND连接。不支持联合主键
	 * @param array $attributes
	 * @return array
	 */
	public function getPkByAttributes(array $attributes = array())
	{
	}

	/**
	 * 通过多个字段名和值，获取某个列的值，字段之间用简单的AND连接，字段之间用简单的AND连接
	 * @param string $columnName
	 * @param array $attributes
	 * @return array
	 */
	public function getByAttributes($columnName, array $attributes = array())
	{
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
	}

	/**
	 * 通过多个字段名和值，查询多条记录，字段之间用简单的AND连接，只查询指定的字段
	 * @param array $columnNames
	 * @param array $attributes
	 * @param string $order
	 * @param integer $limit
	 * @param integer $offset
	 * @return array
	 */
	public function findColumnsByAttributes(array $columnNames, array $attributes = array(), $order = '', $limit = 0, $offset = 0)
	{
	}

	/**
	 * 通过多个字段名和值，查询多条记录，字段之间用简单的AND连接
	 * @param array $attributes
	 * @param string $order
	 * @param integer $limit
	 * @param integer $offset
	 * @return array
	 */
	public function findAllByAttributes(array $attributes = array(), $order = '', $limit = 0, $offset = 0)
	{
	}

	/**
	 * 通过多个字段名和值，统计记录数，字段之间用简单的AND连接
	 * @param array $attributes
	 * @return array
	 */
	public function countByAttributes(array $attributes = array())
	{
	}

	/**
	 * 通过多个字段名和值，查询一条记录，字段之间用简单的AND连接
	 * @param array $attributes
	 * @return array
	 */
	public function findByAttributes(array $attributes = array())
	{
	}

	/**
	 * 获取表中所有的记录
	 * @param string $order
	 * @param integer $limit
	 * @param integer $offset
	 * @return array
	 */
	public function findAll($order = '', $limit = 0, $offset = 0)
	{
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
	}

	/**
	 * 通过条件，查询多条记录，只查询指定的字段
	 * @param string $condition
	 * @param mixed $params
	 * @param string $order
	 * @param integer $limit
	 * @param integer $offset
	 * @return array
	 */
	public function findColumnsByCondition(array $columnNames, $condition, $params = null, $order = '', $limit = 0, $offset = 0)
	{
	}

	/**
	 * 通过条件，查询多条记录
	 * @param string $condition
	 * @param mixed $params
	 * @param string $order
	 * @param integer $limit
	 * @param integer $offset
	 * @return array
	 */
	public function findAllByCondition($condition, $params = null, $order = '', $limit = 0, $offset = 0)
	{
	}

	/**
	 * 通过条件，统计记录数
	 * @param string $condition
	 * @param mixed $params
	 * @return array
	 */
	public function countByCondition($condition, $params = null)
	{
	}

	/**
	 * 通过条件，获取主键的值。不支持联合主键
	 * @param string $condition
	 * @param mixed $params
	 * @return array
	 */
	public function getPkByCondition($condition, $params = null)
	{
	}

	/**
	 * 通过条件，获取某个列的值
	 * @param string $columnName
	 * @param string $condition
	 * @param mixed $params
	 * @return array
	 */
	public function getByCondition($columnName, $condition, $params = null)
	{
	}

	/**
	 * 通过条件，查询一条记录
	 * @param string $condition
	 * @param mixed $params
	 * @return array
	 */
	public function findByCondition($condition, $params = null)
	{
	}

	/**
	 * 通过主键，获取某个列的值。不支持联合主键
	 * @param string $columnName
	 * @param integer $value
	 * @return array
	 */
	public function getByPk($columnName, $value)
	{
	}

	/**
	 * 通过主键，查询一条记录。不支持联合主键
	 * @param integer $value
	 * @return array
	 */
	public function findByPk($value)
	{
	}

	/**
	 * 新增一条记录
	 * @param array $attributes
	 * @param boolean $ignore
	 * @return integer
	 */
	public function create(array $attributes = array(), $ignore = false)
	{
	}

	/**
	 * 通过主键，编辑一条记录。如果是联合主键，则参数是数组，且数组中值的顺序必须和PRIMARY KEY (pk1, pk2)中的顺序相同
	 * @param array|integer $value
	 * @param array $attributes
	 * @return integer
	 */
	public function modifyByPk($value, array $attributes = array())
	{
	}

	/**
	 * 通过主键，删除一条记录。如果是联合主键，则参数是数组，且数组中值的顺序必须和PRIMARY KEY (pk1, pk2)中的顺序相同
	 * @param array|integer $value
	 * @return integer
	 */
	public function removeByPk($value)
	{
	}

	/**
	 * 通过主键，编辑多条记录。不支持联合主键
	 * @param array $values
	 * @param array $attributes
	 * @return integer
	 */
	public function batchModifyByPk(array $values, array $attributes = array())
	{
	}

	/**
	 * 通过主键，删除多条记录。不支持联合主键
	 * @param array $value
	 * @return integer
	 */
	public function batchRemoveByPk(array $values)
	{
	}

	/**
	 * 通过主键，将一条记录移至回收站。不支持联合主键
	 * @param integer $pk
	 * @param string $columnName
	 * @param string $value
	 * @return integer
	 */
	public function trashByPk($pk, $columnName = 'trash', $value = 'y')
	{
	}

	/**
	 * 通过主键，将多条记录移至回收站。不支持联合主键
	 * @param array $pks
	 * @param string $columnName
	 * @param string $value
	 * @return integer
	 */
	public function batchTrashByPk(array $pks, $columnName = 'trash', $value = 'y')
	{
	}

	/**
	 * 通过主键，从回收站还原一条记录。不支持联合主键
	 * @param integer $pk
	 * @param string $columnName
	 * @param string $value
	 * @return integer
	 */
	public function restoreByPk($pk, $columnName = 'trash', $value = 'n')
	{
	}

	/**
	 * 通过主键，将多条记录移至回收站。不支持联合主键
	 * @param array $pks
	 * @param string $columnName
	 * @param string $value
	 * @return integer
	 */
	public function batchRestoreByPk(array $pks, $columnName = 'trash', $value = 'n')
	{
	}
}
