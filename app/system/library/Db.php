<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace library;

/**
 * Db class file
 * 数据库操作基类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Db.php 1 2013-05-18 14:58:59Z huan.song $
 * @package library
 * @since 1.0
 */
class Db
{
	/**
	 * @var string 填充SQL字符
	 */
	const PLACE_HOLDERS = '?';

	/**
	 * @var instance of tfc\saf\DbProxy
	 */
	protected $_dbProxy = null;

	/**
	 * @var string 表名
	 */
	protected $_tableName = null;

	/**
	 * @var string 表的主键名
	 */
	protected $_primaryKey = '';

	/**
	 * 构造方法：初始化表名
	 */
	public function __construct()
	{
		$this->_dbProxy = Util::getDbProxy(Constant::DB_CLUSTER);

		if ($this->_tableName === null) {
			$this->_tableName = strtolower(get_class($this));
		}

		$this->_tableName = $this->_dbProxy->getConfig('tblprefix') . $this->_tableName;
	}

	/**
	 * 新增一条记录
	 * @param array $attributes
	 * @return integer
	 */
	public function insert(array $attributes = array())
	{
		$command = $this->buildInsertCommand(array_keys($attributes));
		if ($this->getDbProxy()->query($command, $attributes)) {
			return $this->_dbProxy->getLastInsertId();
		}
		return false;
	}

	/**
	 * 通过主键，编辑一条记录
	 * @param mixed $value
	 * @param array $attributes
	 * @return integer
	 */
	public function updateByPk($value, array $attributes = array())
	{
		$condition = $this->getQuotePrimaryKey() . ' = ' . self::PLACE_HOLDERS;
		$command = $this->buildUpdateCommand(array_keys($attributes), $condition);
		array_push($attributes, $value);
		if ($this->getDbProxy()->query($command, $attributes)) {
			return $this->getDbProxy()->getRowCount();
		}
		return false;
	}

	/**
	 * 通过主键，删除一条记录
	 * @param mixed $value
	 * @return integer
	 */
	public function deleteByPk($value)
	{
		$condition = $this->getQuotePrimaryKey() . ' = ' . self::PLACE_HOLDERS;
		$command = $this->buildDeleteCommand($condition);
		if ($this->getDbProxy()->query($command, $value)) {
			return $this->getDbProxy()->getRowCount();
		}
		return false;
	}

	/**
	 * 创建新增数据的命令
	 * @param string $table
	 * @param array $columnNames
	 * @param boolean $ignore
	 * @return string
	 */
	public function buildInsertCommand(array $columnNames = array(), $ignore = false)
	{
		$command = 'INSERT ' . ($ignore ? 'IGNORE INTO ' : 'INTO ') . $this->getQuoteTableName();
		$command .= ' (' . implode(', ', $this->quoteColumnNames($columnNames)) . ') VALUES';
		$command .= ' (' . rtrim(str_repeat(self::PLACE_HOLDERS . ', ', count($columnNames)), ', ') . ')';
		return $command;
	}

	/**
	 * 创建编辑数据的命令
	 * @param array $columnNames
	 * @param string $condition
	 * @return string
	 */
	public function buildUpdateCommand(array $columnNames = array(), $condition = '')
	{
		$command = 'UPDATE ' . $this->getQuoteTableName() . ' SET ';
		$command .= implode(' = ' . self::PLACE_HOLDERS . ', ', $this->quoteColumnNames($columnNames)) . ' = ' . self::PLACE_HOLDERS;
		if ($condition != '') {
			return $command . ' WHERE ' . $condition;
		}
		return $command;
	}

	/**
	 * 创建删除数据的命令
	 * @param string $condition
	 * @return string
	 */
	public function buildDeleteCommand($condition)
	{
		$command = 'DELETE FROM ' . $this->getQuoteTableName();
		if ($condition != '') {
			return $command . ' WHERE ' . $condition;
		}
		return $command;
	}

	/**
	 * 创建添加数据的命令，如果主键或唯一键存在则执行更新命令
	 * @param array $columnNames
	 * @param string $onDup
	 * @param boolean $ignore
	 * @return string
	 */
	public function buildInsertCommandOnDup(array $columnNames = array(), $onDup = '', $ignore = false)
	{
		return $this->buildInsertCommand($columnNames, $ignore) . ' ON DUPLICATE KEY UPDATE ' . $onDup;
	}

	/**
	 * 创建编辑数据的命令，如果数据存在则编辑，如果数据不存在则添加
	 * @param array $columnNames
	 * @return string
	 */
	public function buildReplaceCommand(array $columnNames = array())
	{
		$command = 'REPLACE INTO ' . $this->getQuoteTableName();
		$command .= ' (' . implode(', ', $this->quoteColumnNames($columnNames)) . ') VALUES';
		$command .= ' (' . rtrim(str_repeat(self::PLACE_HOLDERS . ', ', count($columnNames)), ', ') . ')';
		return $command;
	}

	/**
	 * 获取DB操作类
	 * @return instance of tfc\saf\DbProxy
	 */
	public function getDbProxy()
	{
		return $this->_dbProxy;
	}

	/**
	 * 获取被引用的表名可以放在SQL语句中执行
	 * @return string
	 */
	public function getQuoteTableName()
	{
		return $this->quoteTableName($this->getTableName());
	}

	/**
	 * 获取一个被引用的表的主键，可以放在SQL语句中执行
	 * @return string
	 */
	public function getQuotePrimaryKey()
	{
		return $this->quoteColumnName($this->getPrimaryKey());
	}

	/**
	 * 获取表名
	 * @return string
	 */
	public function getTableName()
	{
		return $this->_tableName;
	}

	/**
	 * 获取表的主键
	 * @return string
	 */
	public function getPrimaryKey()
	{
		return $this->_primaryKey;
	}

	/**
	 * 引用一个表名，被引用的表名可以放在SQL语句中执行
	 * @param string $name
	 * @return string
	 */
	public function quoteTableName($name)
	{
		return '`' . $name . '`';
	}

	/**
	 * 引用一个列名，被引用的列名可以放在SQL语句中执行
	 * @param string $name
	 * @return string
	 */
	public function quoteColumnName($name)
	{
		return '`' . $name . '`';
	}

	/**
	 * 引用多个列名，被引用的列名可以放在SQL语句中执行
	 * @param array $names
	 * @return array
	 */
	public function quoteColumnNames(array $names)
	{
		return array_map(array($this, 'quoteColumnName'), $names);
	}
}
