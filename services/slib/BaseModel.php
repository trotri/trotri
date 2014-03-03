<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace slib;

use smods\builder\DbBuilders;

use tfc\util\String;
use tfc\saf\Log;

/**
 * BaseModel abstract class file
 * 业务层：模型基类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: BaseModel.php 1 2013-05-18 14:58:59Z huan.song $
 * @package slib
 * @since 1.0
 */
abstract class BaseModel extends BaseService
{
	/**
	 * @var string 操作类型：查询记录
	 */
	const OP_TYPE_SELECT = 'select';

	/**
	 * @var string 操作类型：新增记录
	 */
	const OP_TYPE_INSERT = 'insert';

	/**
	 * @var string 操作类型：编辑记录
	 */
	const OP_TYPE_UPDATE = 'update';

	/**
	 * @var string 操作类型：删除记录
	 */
	const OP_TYPE_DELETE = 'delete';

	/**
	 * @var string 查询选项：记录总行数
	 */
	const QU_OPT_CALC_FOUND_ROWS = SrvQuery::SQL_OPT_CALC_FOUND_ROWS;

	/**
	 * @var instance of slib\SrvFilter
	 */
	protected $_srvFilter = null;

	/**
	 * @var instance of slib\SrvOperator
	 */
	protected $_srvOperator = null;

	/**
	 * @var instance of slib\SrvQuery
	 */
	protected $_srvQuery = null;

	/**
	 * 构造方法：初始化数据库操作类和语言国际化管理类
	 * @param slib\Language $language
	 * @param integer $tableNum 分表数字，如果 >= 0 表示分表操作
	 */
	public function __construct(Language $language, $tableNum = -1)
	{
		$db = new DbBuilders($tableNum);
		parent::__construct($db, $language);
	}

	/**
	 * 运行验证处理类
	 * @param array $rules
	 * @param array $attributes
	 * @param boolean $required
	 * @return array
	 */
	public function filterRun(array $rules, array $attributes, $required = true)
	{
		return $this->getSrvFilter()->run($rules, $attributes, $required);
	}

	/**
	 * 验证参数是否为空
	 * @param array $attributes
	 * @return array
	 */
	public function isEmptyAttributes(array $attributes = array())
	{
		return $this->getSrvFilter()->isEmptyAttributes($attributes);
	}

	/**
	 * 新增一条记录
	 * @param array $attributes
	 * @param boolean $ignore
	 * @return array
	 */
	public function insert(array $attributes = array(), $ignore = false)
	{
		return $this->getSrvOperator()->insert($attributes, $ignore);
	}

	/**
	 * 通过主键，编辑一条记录。不支持联合主键
	 * @param integer $value
	 * @param array $attributes
	 * @param boolean $required
	 * @return array
	 */
	public function updateByPk($value, array $attributes = array())
	{
		return $this->getSrvOperator()->updateByPk($value, $attributes);
	}

	/**
	 * 通过主键，编辑多条记录。不支持联合主键
	 * @param array $values
	 * @param array $attributes
	 * @return array
	 */
	public function batchUpdateByPk(array $values, array $attributes = array())
	{
		return $this->getSrvOperator()->batchUpdateByPk($values, $attributes);
	}

	/**
	 * 通过主键，将一条记录移至回收站。不支持联合主键
	 * @param integer $pk
	 * @param string $columnName
	 * @param string $value
	 * @return array
	 */
	public function trashByPk($pk, $columnName = 'trash', $value = 'y')
	{
		return $this->getSrvOperator()->trashByPk($pk, $columnName, $value);
	}

	/**
	 * 通过主键，将多条记录移至回收站。不支持联合主键
	 * @param array $pks
	 * @param string $columnName
	 * @param string $value
	 * @return array
	 */
	public function batchTrashByPk(array $pks, $columnName = 'trash', $value = 'y')
	{
		return $this->getSrvOperator()->batchTrashByPk($pks, $columnName, $value);
	}

	/**
	 * 通过主键，从回收站还原一条记录。不支持联合主键
	 * @param integer $pk
	 * @param string $columnName
	 * @param string $value
	 * @return array
	 */
	public function restoreByPk($pk, $columnName = 'trash', $value = 'n')
	{
		return $this->getSrvOperator()->restoreByPk($pk, $columnName, $value);
	}

	/**
	 * 通过主键，将多条记录移至回收站。不支持联合主键
	 * @param array $pks
	 * @param string $columnName
	 * @param string $value
	 * @return array
	 */
	public function batchRestoreByPk(array $pks, $columnName = 'trash', $value = 'n')
	{
		return $this->getSrvOperator()->batchRestoreByPk($pks, $columnName, $value);
	}

	/**
	 * 通过主键，删除一条记录。不支持联合主键
	 * @param integer $value
	 * @return array
	 */
	public function deleteByPk($value)
	{
		return $this->getSrvOperator()->deleteByPk($value);
	}

	/**
	 * 通过主键，删除多条记录。不支持联合主键
	 * @param array $values
	 * @return array
	 */
	public function batchDeleteByPk(array $values)
	{
		return $this->getSrvOperator()->batchDeleteByPk($values);
	}

	/**
	 * 通过多个字段名和值，获取主键的值，字段之间用简单的AND连接。不支持联合主键
	 * @param array $attributes
	 * @return array
	 */
	public function getPkByAttributes(array $attributes = array())
	{
		return $this->getSrvQuery()->getPkByAttributes($attributes);
	}

	/**
	 * 通过多个字段名和值，获取某个列的值，字段之间用简单的AND连接，字段之间用简单的AND连接
	 * @param string $columnName
	 * @param array $attributes
	 * @return array
	 */
	public function getByAttributes($columnName, array $attributes = array())
	{
		return $this->getSrvQuery()->getByAttributes($columnName, $attributes);
	}

	/**
	 * 通过多个字段名和值，查询两个字段记录，字段之间用简单的AND连接，并且以键值对方式返回
	 * @param array $columnNames
	 * @param array $attributes
	 * @param string $order
	 * @param integer $limit
	 * @param integer $offset
	 * @param string $option
	 * @return array
	 */
	public function findPairsByAttributes(array $columnNames, array $attributes = array(), $order = '', $limit = 0, $offset = 0, $option = '')
	{
		return $this->getSrvQuery()->findPairsByAttributes($columnNames, $attributes, $order, $limit, $offset, $option);
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
	public function findColumnsByAttributes(array $columnNames, array $attributes = array(), $order = '', $limit = 0, $offset = 0, $option = self::QU_OPT_CALC_FOUND_ROWS)
	{
		return $this->getSrvQuery()->findColumnsByAttributes($columnNames, $attributes, $order, $limit, $offset, $option);
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
	public function findAllByAttributes(array $attributes = array(), $order = '', $limit = 0, $offset = 0, $option = self::QU_OPT_CALC_FOUND_ROWS)
	{
		return $this->getSrvQuery()->findAllByAttributes($attributes, $order, $limit, $offset, $option);
	}

	/**
	 * 通过多个字段名和值，统计记录数，字段之间用简单的AND连接
	 * @param array $attributes
	 * @return array
	 */
	public function countByAttributes(array $attributes = array())
	{
		return $this->getSrvQuery()->countByAttributes($attributes);
	}

	/**
	 * 通过多个字段名和值，查询一条记录，字段之间用简单的AND连接
	 * @param array $attributes
	 * @return array
	 */
	public function findByAttributes(array $attributes = array())
	{
		return $this->getSrvQuery()->findByAttributes($attributes);
	}

	/**
	 * 获取表中所有的记录
	 * @param string $order
	 * @param integer $limit
	 * @param integer $offset
	 * @param string $option
	 * @return array
	 */
	public function findAll($order = '', $limit = 0, $offset = 0, $option = self::QU_OPT_CALC_FOUND_ROWS)
	{
		return $this->getSrvQuery()->findAll($order, $limit, $offset, $option);
	}

	/**
	 * 通过条件，查询两个字段记录，并且以键值对方式返回
	 * @param array $columnNames
	 * @param string $condition
	 * @param mixed $params
	 * @param string $order
	 * @param integer $limit
	 * @param integer $offset
	 * @param string $option
	 * @return array
	 */
	public function findPairsByCondition(array $columnNames, $condition, $params = null, $order = '', $limit = 0, $offset = 0, $option = '')
	{
		return $this->getSrvQuery()->findPairsByCondition($columnNames, $condition, $params, $order, $limit, $offset, $option);
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
	public function findColumnsByCondition(array $columnNames, $condition, $params = null, $order = '', $limit = 0, $offset = 0, $option = self::QU_OPT_CALC_FOUND_ROWS)
	{
		return $this->getSrvQuery()->findColumnsByCondition($columnNames, $condition, $params, $order, $limit, $offset, $option);
	}

	/**
	 * 通过条件，查询多条记录
	 * @param string $condition
	 * @param mixed $params
	 * @param string $order
	 * @param integer $limit
	 * @param integer $offset
	 * @param string $option
	 * @return array
	 */
	public function findAllByCondition($condition, $params = null, $order = '', $limit = 0, $offset = 0, $option = self::QU_OPT_CALC_FOUND_ROWS)
	{
		return $this->getSrvQuery()->findAllByCondition($condition, $params, $order, $limit, $offset, $option);
	}

	/**
	 * 通过条件，统计记录数
	 * @param string $condition
	 * @param mixed $params
	 * @return array
	 */
	public function countByCondition($condition, $params = null)
	{
		return $this->getSrvQuery()->countByCondition($condition, $params);
	}

	/**
	 * 通过条件，获取主键的值。不支持联合主键
	 * @param string $condition
	 * @param mixed $params
	 * @return array
	 */
	public function getPkByCondition($condition, $params = null)
	{
		return $this->getSrvQuery()->getPkByCondition($condition, $params);
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
		return $this->getSrvQuery()->getByCondition($columnName, $condition, $params);
	}

	/**
	 * 通过条件，查询一条记录
	 * @param string $condition
	 * @param mixed $params
	 * @return array
	 */
	public function findByCondition($condition, $params = null)
	{
		return $this->getSrvQuery()->findByCondition($condition, $params);
	}

	/**
	 * 通过主键，获取某个列的值。不支持联合主键
	 * @param string $columnName
	 * @param integer $value
	 * @return array
	 */
	public function getByPk($columnName, $value)
	{
		return $this->getSrvQuery()->getByPk($columnName, $value);
	}

	/**
	 * 通过主键，查询一条记录。不支持联合主键
	 * @param integer $value
	 * @return array
	 */
	public function findByPk($value)
	{
		return $this->getSrvQuery()->findByPk($value);
	}

	/**
	 * 获取业务层：数据验证和清理类
	 * @return instance of slib\SrvFilter
	 */
	public function getSrvFilter()
	{
		if ($this->_srvFilter === null) {
			$this->_srvFilter = new SrvFilter($this->getDb(), $this->getLanguage());
		}

		return $this->_srvFilter;
	}

	/**
	 * 获取业务层：创建并执行简单的MySQL操作命令类
	 * @return slib\SrvOperator
	 */
	public function getSrvOperator()
	{
		if ($this->_srvOperator === null) {
			$this->_srvOperator = new SrvOperator($this->getDb(), $this->getLanguage());
		}

		return $this->_srvOperator;
	}

	/**
	 * 获取业务层：创建并执行简单的MySQL查询命令类
	 * @return slib\SrvQuery
	 */
	public function getSrvQuery()
	{
		if ($this->_srvQuery === null) {
			$this->_srvQuery = new SrvQuery($this->getDb(), $this->getLanguage());
		}

		return $this->_srvQuery;
	}

	/**
	 * 新增一条记录，并且自动验证数据
	 * @param array $attributes
	 * @param boolean $required
	 * @param boolean $ignore
	 * @return array
	 */
	public function autoInsert(array $attributes = array(), $required = true, $ignore = false)
	{
		$opType = self::OP_TYPE_INSERT;

		$this->_filterAttributes($attributes);
		$attributes = $this->_cleanPreValidator($attributes, $opType);
		$ret = $this->validatePreInsert($attributes, $required);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return $ret;
		}

		$attributes = $this->_cleanPostValidator($attributes, $opType);
		$ret = $this->insert($attributes, $ignore);
		return $ret;
	}

	/**
	 * 通过主键，编辑一条记录，并且自动验证数据。不支持联合主键
	 * @param integer $value
	 * @param array $attributes
	 * @param boolean $required
	 * @return array
	 */
	public function autoUpdateByPk($value, array $attributes = array(), $required = false)
	{
		$opType = self::OP_TYPE_UPDATE;

		$this->_filterAttributes($attributes);
		$attributes = $this->_cleanPreValidator($attributes, $opType);
		$ret = $this->validatePreUpdate($attributes, $required);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return $ret;
		}

		$attributes = $this->_cleanPostValidator($attributes, $opType);
		$ret = $this->updateByPk($value, $attributes);
		return $ret;
	}

	/**
	 * 通过主键，编辑多条记录，并且自动验证数据。不支持联合主键
	 * @param array $values
	 * @param array $attributes
	 * @param boolean $required
	 * @return array
	 */
	public function autoBatchUpdateByPk(array $values, array $attributes = array(), $required = false)
	{
		$opType = self::OP_TYPE_UPDATE;

		$this->_filterAttributes($attributes);
		$attributes = $this->_cleanPreValidator($attributes, $opType);
		$ret = $this->validatePreUpdate($attributes, $required);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return $ret;
		}

		$attributes = $this->_cleanPostValidator($attributes, $opType);
		$ret = $this->batchUpdateByPk($values, $attributes);
		return $ret;
	}

	/**
	 * 新增数据前验证数据
	 * @param array $attributes
	 * @param boolean $required
	 * @return array
	 */
	public function validatePreInsert(array $attributes = array(), $required = true)
	{
		$ret = $this->isEmptyAttributes($attributes);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return array(
				'err_no' => ErrorNo::ERROR_ARGS_INSERT,
				'err_msg' => $this->_('ERROR_MSG_ERROR_ARGS_INSERT'),
				'errors' => $ret['errors']
			);
		}

		$ret = $this->validate($attributes, $required, self::OP_TYPE_INSERT);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			$errNo = ErrorNo::ERROR_ARGS_INSERT;
			$errMsg = $this->_('ERROR_MSG_ERROR_ARGS_INSERT');
			$errors = isset($ret['errors']) ? $ret['errors'] : array();
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
	public function validatePreUpdate(array $attributes = array(), $required = false)
	{
		$ret = $this->isEmptyAttributes($attributes);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return array(
				'err_no' => ErrorNo::ERROR_ARGS_UPDATE,
				'err_msg' => $this->_('ERROR_MSG_ERROR_ARGS_UPDATE'),
				'errors' => $ret['errors']
			);
		}

		$ret = $this->validate($attributes, $required, self::OP_TYPE_UPDATE);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			$errNo = ErrorNo::ERROR_ARGS_UPDATE;
			$errMsg = $this->_('ERROR_MSG_ERROR_ARGS_UPDATE');
			$errors = isset($ret['errors']) ? $ret['errors'] : array();
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
			$errMsg = $this->_('ERROR_MSG_SUCCESS_VALIDATE')
		);
	}

	/**
	 * 基于配置清理表单提交的数据
	 * @param array $rules
	 * @param array $attributes
	 * @return array
	 */
	protected function _clean(array $rules, array $attributes)
	{
		return $this->getSrvFilter()->clean($rules, $attributes);
	}

	/**
	 * 过滤数组（只保留指定的字段）、清理数据并且清除空数据（空字符，负数）
	 * @param array $attributes
	 * @param array $rules
	 * @return void
	 */
	protected function _filterCleanEmpty(array &$attributes = array(), array $rules = array())
	{
		$this->_filterAttributes($attributes, array_keys($rules));
		$attributes = $this->_clean($rules, $attributes);
		foreach ($rules as $columnName => $funcName) {
			if (!isset($attributes[$columnName])) {
				continue;
			}

			if ($funcName === 'trim' && $attributes[$columnName] === '') {
				unset($attributes[$columnName]);
				continue;
			}

			if ($funcName === 'intval' && $attributes[$columnName] <= 0) {
				unset($attributes[$columnName]);
				continue;
			}
		}
	}

	/**
	 * 通过过滤数组，只保留指定的字段名
	 * 如果没有指定要保留的字段名，则通过表的字段过滤
	 * @param array $attributes
	 * @param mixed $columnNames
	 * @param boolean $autoIncrement
	 * @return void
	 */
	protected function _filterAttributes(array &$attributes = array(), $columnNames = null, $autoIncrement = true)
	{
		return $this->getSrvFilter()->filterAttributes($attributes, $columnNames, $autoIncrement);
	}

	/**
	 * 通过过滤数组，删除指定的字段名
	 * @param array $attributes
	 * @param mixed $columnNames
	 * @return void
	 */
	protected function _removeAttributes(array &$attributes = array(), $columnNames)
	{
		return $this->getSrvFilter()->removeAttributes($attributes, $columnNames);
	}

	/**
	 * 向查询结果中追加总记录数，查询语句必须用SQL_CALC_FOUND_ROWS选项
	 * @param array $ret
	 * @param string $option
	 * @return array
	 */
	protected function _applyFoundRows($ret, $option)
	{
		return $this->getSrvQuery()->applyFoundRows($ret, $option);
	}

	/**
	 * 验证前清理数据，需要子类重写此方法
	 * @param array $attributes
	 * @param string $opType
	 * @return array
	 */
	protected function _cleanPreValidator(array $attributes = array(), $opType = '')
	{
		return $attributes;
	}

	/**
	 * 验证后清理数据，需要子类重写此方法
	 * @param array $attributes
	 * @param string $opType
	 * @return array
	 */
	protected function _cleanPostValidator(array $attributes = array(), $opType = '')
	{
		return $attributes;
	}

	/**
	 * 清理字段，除去左右空格，并且escapeXss
	 * @param string $value
	 * @return string
	 */
	public function cleanXss($value)
	{
		return String::escapeXss(trim($value));
	}

	/**
	 * 将IPv4转成长整型
	 * @param string $value
	 * @return integer
	 */
	public function ip2long($value)
	{
		return ip2long($value);
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
