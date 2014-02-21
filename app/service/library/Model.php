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

use tfc\util\String;
use tfc\saf\Text;
use tfc\saf\Log;

/**
 * Model abstract class file
 * 业务处理层基类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Model.php 1 2013-05-18 14:58:59Z huan.song $
 * @package library
 * @since 1.0
 */
abstract class Model
{
	/**
	 * @var string 当前操作类型：新增记录
	 */
	const OP_TYPE_INSERT = 'insert';

	/**
	 * @var string 当前操作类型：编辑记录
	 */
	const OP_TYPE_UPDATE = 'update';

	/**
	 * @var string 当前操作类型：查询记录
	 */
	const OP_TYPE_SELECT = 'select';

	/**
	 * @var 当前查询选项：记录总行数
	 */
	const QE_OPT_TOTAL_ROWS = 'SQL_CALC_FOUND_ROWS';

	/**
	 * @var instance of tdo\Db
	 */
	protected $_db = null;

	/**
	 * @var instance of library\DOperator
	 */
	protected $_dOperator = null;

	/**
	 * @var instance of library\DQuery
	 */
	protected $_dQuery = null;

	/**
	 * 构造方法：初始化数据库操作类
	 * @param tdo\Db $db
	 */
	public function __construct(Db $db)
	{
		$this->_db = $db;
	}

	/**
	 * 通过多个字段名和值，获取主键的值，字段之间用简单的AND连接。不支持联合主键
	 * @param array $attributes
	 * @return array
	 */
	public function getPkByAttributes(array $attributes = array())
	{
		return $this->getDQuery()->getPkByAttributes($attributes);
	}

	/**
	 * 通过多个字段名和值，获取某个列的值，字段之间用简单的AND连接，字段之间用简单的AND连接
	 * @param string $columnName
	 * @param array $attributes
	 * @return array
	 */
	public function getByAttributes($columnName, array $attributes = array())
	{
		return $this->getDQuery()->getByAttributes($columnName, $attributes);
	}

	/**
	 * 通过多个字段名和值，查询两个字段记录，字段之间用简单的AND连接，并且以键值对方式返回
	 * @param array $columnNames
	 * @param array $attributes
	 * @param string $order
	 * @param boolean $totalRows
	 * @return array
	 */
	public function findPairsByAttributes(array $columnNames, array $attributes = array(), $order = '', $totalRows = false)
	{
		$ret = $this->getDQuery()->findPairsByAttributes($columnNames, $attributes, $order, Util::getListRows(), Util::getFirstRow(), $totalRows ? self::QE_OPT_TOTAL_ROWS : '');
		if ($totalRows) {
			$ret = $this->applyTotalRows($ret);
		}

		return $ret;
	}

	/**
	 * 通过多个字段名和值，查询多条记录，字段之间用简单的AND连接，只查询指定的字段
	 * @param array $columnNames
	 * @param array $attributes
	 * @param string $order
	 * @param boolean $totalRows
	 * @return array
	 */
	public function findColumnsByAttributes(array $columnNames, array $attributes = array(), $order = '', $totalRows = false)
	{
		$ret = $this->getDQuery()->findColumnsByAttributes(columnNames, $attributes, $order, Util::getListRows(), Util::getFirstRow(), $totalRows ? self::QE_OPT_TOTAL_ROWS : '');
		if ($totalRows) {
			$ret = $this->applyTotalRows($ret);
		}

		return $ret;
	}

	/**
	 * 通过多个字段名和值，查询多条记录，字段之间用简单的AND连接
	 * @param array $attributes
	 * @param string $order
	 * @param boolean $totalRows
	 * @return array
	 */
	public function findAllByAttributes(array $attributes = array(), $order = '', $totalRows = true)
	{
		$ret = $this->getDQuery()->findAllByAttributes($attributes, $order, Util::getListRows(), Util::getFirstRow(), $totalRows ? self::QE_OPT_TOTAL_ROWS : '');
		if ($totalRows) {
			$ret = $this->applyTotalRows($ret);
		}

		return $ret;
	}

	/**
	 * 通过多个字段名和值，统计记录数，字段之间用简单的AND连接
	 * @param array $attributes
	 * @return array
	 */
	public function countByAttributes(array $attributes = array())
	{
		return $this->getDQuery()->countByAttributes($attributes);
	}

	/**
	 * 通过多个字段名和值，查询一条记录，字段之间用简单的AND连接
	 * @param array $attributes
	 * @return array
	 */
	public function findByAttributes(array $attributes = array())
	{
		return $this->getDQuery()->findByAttributes($attributes);
	}

	/**
	 * 获取表中所有的记录
	 * @param string $order
	 * @param boolean $totalRows
	 * @return array
	 */
	public function findAll($order = '', $totalRows = false)
	{
		$ret = $this->getDQuery()->findAll($order, Util::getListRows(), Util::getFirstRow(), $totalRows ? self::QE_OPT_TOTAL_ROWS : '');
		if ($totalRows) {
			$ret = $this->applyTotalRows($ret);
		}

		return $ret;
	}

	/**
	 * 通过条件，查询两个字段记录，并且以键值对方式返回
	 * @param array $columnNames
	 * @param string $condition
	 * @param mixed $params
	 * @param string $order
	 * @param boolean $totalRows
	 * @return array
	 */
	public function findPairsByCondition(array $columnNames, $condition, $params = null, $order = '', $totalRows = false)
	{
		$ret = $this->getDQuery()->findPairsByCondition($columnNames, $condition, $params, $order, Util::getListRows(), Util::getFirstRow(), $totalRows ? self::QE_OPT_TOTAL_ROWS : '');
		if ($totalRows) {
			$ret = $this->applyTotalRows($ret);
		}

		return $ret;
	}

	/**
	 * 通过条件，查询多条记录，只查询指定的字段
	 * @param array $columnNames
	 * @param string $condition
	 * @param mixed $params
	 * @param string $order
	 * @param boolean $totalRows
	 * @return array
	 */
	public function findColumnsByCondition(array $columnNames, $condition, $params = null, $order = '', $totalRows = false)
	{
		$ret = $this->getDQuery()->findColumnsByCondition($columnNames, $condition, $params, $order, Util::getListRows(), Util::getFirstRow(), $totalRows ? self::QE_OPT_TOTAL_ROWS : '');
		if ($totalRows) {
			$ret = $this->applyTotalRows($ret);
		}

		return $ret;
	}

	/**
	 * 通过条件，查询多条记录
	 * @param string $condition
	 * @param mixed $params
	 * @param string $order
	 * @param boolean $totalRows
	 * @return array
	 */
	public function findAllByCondition($condition, $params = null, $order = '', $totalRows = true)
	{
		$ret = $this->getDQuery()->findAllByCondition($condition, $params, $order, Util::getListRows(), Util::getFirstRow(), $totalRows ? self::QE_OPT_TOTAL_ROWS : '');
		if ($totalRows) {
			$ret = $this->applyTotalRows($ret);
		}

		return $ret;
	}

	/**
	 * 通过条件，统计记录数
	 * @param string $condition
	 * @param mixed $params
	 * @return array
	 */
	public function countByCondition($condition, $params = null)
	{
		return $this->getDQuery()->countByCondition($condition, $params);
	}

	/**
	 * 通过条件，获取主键的值。不支持联合主键
	 * @param string $condition
	 * @param mixed $params
	 * @return array
	 */
	public function getPkByCondition($condition, $params = null)
	{
		return $this->getDQuery()->getPkByCondition($condition, $params);
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
		return $this->getDQuery()->getByCondition($columnName, $condition, $params);
	}

	/**
	 * 通过条件，查询一条记录
	 * @param string $condition
	 * @param mixed $params
	 * @return array
	 */
	public function findByCondition($condition, $params = null)
	{
		return $this->getDQuery()->findByCondition($condition, $params);
	}

	/**
	 * 通过主键，获取某个列的值。不支持联合主键
	 * @param string $columnName
	 * @param integer $value
	 * @return array
	 */
	public function getByPk($columnName, $value)
	{
		return $this->getDQuery()->getByPk($columnName, $value);
	}

	/**
	 * 通过主键，查询一条记录。不支持联合主键
	 * @param integer $value
	 * @return array
	 */
	public function findByPk($value)
	{
		return $this->getDQuery()->findByPk($value);
	}

	/**
	 * 向SQL_CALC_FOUND_ROWS语句查询结果中添加总记录数
	 * @return array
	 */
	public function applyTotalRows($ret)
	{
		if ($ret['err_no'] === ErrorNo::ERROR_DB_SELECT) {
			$ret['total'] = $this->getTotalRows();
		}

		return $ret;
	}

	/**
	 * 通过SQL_CALC_FOUND_ROWS查询语句，获取总记录数
	 * @return integer
	 */
	public function getTotalRows()
	{
		$totalRows = $this->getDb()->getFoundRows();
		return $totalRows;
	}

	/**
	 * 新增一条记录
	 * @param array $attributes
	 * @param $required $ignore
	 * @param boolean $ignore
	 * @return array
	 */
	public function insert(array $attributes = array(), $required = true, $ignore = false)
	{
		$opType = self::OP_TYPE_INSERT;

		$this->filterAttributes($attributes);
		$attributes = $this->cleanBeforeValidator($attributes, $opType);
		$ret = $this->validateBeforeInsert($attributes, $required);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return $ret;
		}

		$attributes = $this->cleanAfterValidator($attributes, $opType);
		$ret = $this->getDOperator()->insert($attributes, $ignore);
		return $ret;
	}

	/**
	 * 通过主键，编辑一条记录。不支持联合主键
	 * @param integer $value
	 * @param array $attributes
	 * @param boolean $required
	 * @return array
	 */
	public function updateByPk($value, array $attributes = array(), $required = false)
	{
		$opType = self::OP_TYPE_UPDATE;

		$this->filterAttributes($attributes);
		$attributes = $this->cleanBeforeValidator($attributes, $opType);
		$ret = $this->validateBeforeUpdate($attributes, $required);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return $ret;
		}

		$attributes = $this->cleanAfterValidator($attributes, $opType);
		$ret = $this->getDOperator()->updateByPk($value, $attributes);
		return $ret;
	}

	/**
	 * 通过主键，编辑多条记录。不支持联合主键
	 * @param array $values
	 * @param array $attributes
	 * @param boolean $required
	 * @return integer
	 */
	public function batchUpdateByPk(array $values, array $attributes = array(), $required = false)
	{
		$opType = self::OP_TYPE_UPDATE;

		$this->filterAttributes($attributes);
		$attributes = $this->cleanBeforeValidator($attributes, $opType);
		$ret = $this->validateBeforeUpdate($attributes, $required);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return $ret;
		}

		$attributes = $this->cleanAfterValidator($attributes, $opType);
		$ret = $this->getDOperator()->batchUpdateByPk($values, $attributes);
		return $ret;
	}

	/**
	 * 通过主键，将一条记录移至回收站。不支持联合主键
	 * @param integer $value
	 * @param string $columnName
	 * @return array
	 */
	public function trashByPk($value, $columnName = 'trash')
	{
		return $this->getDOperator()->trashByPk($value, $columnName);
	}

	/**
	 * 通过主键，将多条记录移至回收站。不支持联合主键
	 * @param array $values
	 * @param string $columnName
	 * @return array
	 */
	public function batchTrashByPk(array $values, $columnName = 'trash')
	{
		return $this->getDOperator()->batchTrashByPk($values, $columnName);
	}

	/**
	 * 通过主键，从回收站还原一条记录。不支持联合主键
	 * @param integer $value
	 * @param string $columnName
	 * @return array
	 */
	public function restoreByPk($value, $columnName = 'trash')
	{
		return $this->getDOperator()->restoreByPk($value, $columnName);
	}

	/**
	 * 通过主键，从回收站还原多条记录。不支持联合主键
	 * @param array $values
	 * @param string $columnName
	 * @return array
	 */
	public function batchRestoreByPk(array $values, $columnName = 'trash')
	{
		return $this->getDOperator()->batchRestoreByPk($values, $columnName);
	}

	/**
	 * 通过主键，删除一条记录。不支持联合主键
	 * @param integer $value
	 * @return array
	 */
	public function deleteByPk($value)
	{
		return $this->getDOperator()->deleteByPk($value);
	}

	/**
	 * 通过主键，删除多条记录。不支持联合主键
	 * @param array $values
	 * @return integer
	 */
	public function batchDeleteByPk(array $values)
	{
		return $this->getDOperator()->batchDeleteByPk($values);
	}

	/**
	 * 通过过滤数组，只保留指定的字段，清理数据，并清除空数据（空字符，负数）
	 * @param array $rules
	 * @param array $attributes
	 * @return array
	 */
	public function filterCleanEmpty(array $rules = array(), array $attributes = array())
	{
		$attributes = $this->filterAttributes($attributes, array_keys($rules));
		$attributes = $this->runfilterClean($rules, $attributes);
		foreach ($rules as $columnName => $rule) {
			if (!isset($attributes[$columnName])) {
				continue;
			}

			if ($rule === 'trim' && $attributes[$columnName] === '') {
				unset($attributes[$columnName]);
				continue;
			}

			if ($rule === 'intval' && $attributes[$columnName] <= 0) {
				unset($attributes[$columnName]);
				continue;
			}
		}

		return $attributes;
	}

	/**
	 * 通过过滤数组，只保留指定的字段名
	 * 如果没有指定要保留的字段名，则通过表的字段过滤
	 * @param array $attributes
	 * @param mixed $columnNames
	 * @param boolean $autoIncrement
	 * @return void
	 */
	public function filterAttributes(array &$attributes = array(), $columnNames = null, $autoIncrement = true)
	{
		if ($columnNames === null) {
			$this->getDb()->filterAttributes($attributes, $autoIncrement);
		}
		else {
			$columnNames = (array) $columnNames;
			foreach ($attributes as $key => $value) {
				if (!in_array($key, $columnNames)) {
					unset($attributes[$key]);
				}
			}
		}
	}

	/**
	 * 通过过滤数组，删除指定的字段名
	 * @param array $attributes
	 * @param mixed $columnNames
	 * @return void
	 */
	public function removeAttributes(array &$attributes = array(), $columnNames)
	{
		$columnNames = (array) $columnNames;
		foreach ($columnNames as $columnName) {
			if (isset($attributes[$columnName])) {
				unset($attributes[$columnName]);
			}
		}
	}

	/**
	 * 获取创建并执行简单的MySQL操作命令类
	 * @return library\DOperator
	 */
	public function getDOperator()
	{
		if ($this->_dOperator === null) {
			$this->_dOperator = new DOperator($this->getDb());
		}

		return $this->_dOperator;
	}

	/**
	 * 获取创建并执行简单的MySQL查询命令类
	 * @return library\DQuery
	 */
	public function getDQuery()
	{
		if ($this->_dQuery === null) {
			$this->_dQuery = new DQuery($this->getDQuery());
		}

		return $this->_dQuery;
	}

	/**
	 * 获取当前业务类对应的数据库操作类
	 * @return instance of tdo\Db
	 */
	public function getDb()
	{
		return $this->_db;
	}

	/**
	 * 新增数据前验证数据
	 * @param array $attributes
	 * @param boolean $required
	 * @return array
	 */
	public function validateBeforeInsert(array $attributes = array(), $required = true)
	{
		if (empty($attributes)) {
			$errNo = ErrorNo::ERROR_ARGS_INSERT;
			$errMsg = Text::_('ERROR_MSG_ERROR_ARGS_INSERT');
			$errors = array('attributes' => 'is empty');
			Log::warning(sprintf(
				'%s attributes empty, errors "%s"', $errMsg, serialize($errors)
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'errors' => $errors
			);
		}

		$ret = $this->validate($attributes, $required, self::OP_TYPE_INSERT);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			$errNo = ErrorNo::ERROR_ARGS_INSERT;
			$errMsg = Text::_('ERROR_MSG_ERROR_ARGS_INSERT');
			$errors = $ret['errors'];
			Log::warning(sprintf(
				'%s attributes "%s", errors "%s", required "%d"', $errMsg, serialize($attributes), serialize($errors), $required
			), $errNo, __METHOD__);

			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'errors' => $errors
			);
		}

		return $ret;
	}

	/**
	 * 编辑数据前验证数据
	 * @param array $attributes
	 * @param boolean $required
	 * @return array
	 */
	public function validateBeforeUpdate(array $attributes = array(), $required = false)
	{
		if (empty($attributes)) {
			$errNo = ErrorNo::ERROR_ARGS_UPDATE;
			$errMsg = Text::_('ERROR_MSG_ERROR_ARGS_UPDATE');
			$errors = array('attributes' => 'is empty');
			Log::warning(sprintf(
				'%s attributes empty, errors "%s"', $errMsg, serialize($errors)
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'errors' => $errors
			);
		}

		$ret = $this->validate($attributes, $required, self::OP_TYPE_UPDATE);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			$errNo = ErrorNo::ERROR_ARGS_UPDATE;
			$errMsg = Text::_('ERROR_MSG_ERROR_ARGS_UPDATE');
			$errors = $ret['errors'];
			Log::warning(sprintf(
				'%s attributes "%s", errors "%s", required "%d"', $errMsg, serialize($attributes), serialize($errors), $required
			), $errNo, __METHOD__);

			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'errors' => $errors
			);
		}

		return $ret;
	}

	/**
	 * 验证数据，需要子类重写此方法
	 * @param array $attributes
	 * @param boolean $required
	 * @param string $opType
	 * @return array
	 */
	public function validate(array $attributes = array(), $required = false, $opType = '')
	{
		return array(
			$errNo = ErrorNo::SUCCESS_NUM,
			$errMsg = Text::_('ERROR_MSG_SUCCESS_VALIDATE')
		);
	}

	/**
	 * 验证数据前的清理数据，需要子类重写此方法
	 * @param array $attributes
	 * @param string $opType
	 * @return array
	 */
	public function cleanBeforeValidator(array $attributes = array(), $opType = '')
	{
		return $attributes;
	}

	/**
	 * 验证数据后的清理数据，需要子类重写此方法
	 * @param array $attributes
	 * @param string $opType
	 * @return array
	 */
	public function cleanAfterValidator(array $attributes = array(), $opType = '')
	{
		return $attributes;
	}

	/**
     * 基于配置清理表单提交的数据
     * @param array $rules
     * @param array $attributes
     * @return array
     */
	public function runfilterClean(array $rules, array $attributes)
	{
		return Factory::getFilter()->clean($rules, $attributes);
	}

	/**
	 * 运行验证处理类
	 * @param array $rules
	 * @param array $attributes
	 * @param boolean $required
	 * @return array
	 */
	public function runfilterValidate(array $rules, array $attributes, $required = true)
	{
		$filter = Factory::getFilter();
		$ret = $filter->run($rules, $attributes, $required);
		if ($ret) {
			return array(
				$errNo = ErrorNo::SUCCESS_NUM,
				$errMsg = Text::_('ERROR_MSG_SUCCESS_VALIDATE')
			);
		}

		$errors = $filter->getErrors(true);
		return array(
			$errNo = ErrorNo::ERROR_VALIDATE,
			$errMsg = Text::_('ERROR_MSG_ERROR_VALIDATE'),
			'errors' => $errors
		);
	}

	/**
	 * 清理字段，除去左右空格，并且escapeXss
	 * @param string $value
	 * @return string
	 */
	public function cleanXss($value)
	{
		$ret = String::escapeXss(trim($value));
		return $ret;
	}

	/**
	 * 将IPv4转成长整型
	 * @param string $value
	 * @return integer
	 */
	public function ip2long($value)
	{
		$ret = ip2long($value);
		return $ret;
	}

	/**
	 * 用','拼接字符串
	 * @param array $value
	 * @return string
	 */
	public function join($value)
	{
		if (is_array($value)) {
			$value = implode(',', $value);
		}

		return $value;
	}

	/**
	 * trim一维数组中每个元素，如果不是数组，转换为数组
	 * @param array $value
	 * @return array
	 */
	public function trims($value)
	{
		$value = (array) $value;
		$value = array_map('trim', $value);
		return $value;
	}

	/**
	 * int一维数组中每个元素，如果不是数组，转换为数组
	 * @param array $value
	 * @return array
	 */
	public function intvals($value)
	{
		$value = (array) $value;
		$value = array_map('intval', $value);
		return $value;
	}
}
