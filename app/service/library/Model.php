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

use tfc\ap\Singleton;
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
	 * @var 当前操作类型：新增记录
	 */
	const OP_TYPE_INSERT = 'insert';

	/**
	 * @var 当前操作类型：编辑记录
	 */
	const OP_TYPE_UPDATE = 'update';

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
		$rules = $this->getRules($opType);
		$ret = $this->filterInsert($rules, $attributes, $required);
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
		$rules = $this->getRules($opType);
		$ret = $this->filterUpdate($rules, $attributes, $required);
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
		$rules = $this->getRules($opType);
		$ret = $this->filterUpdate($rules, $attributes, $required);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return $ret;
		}

		$attributes = $this->cleanAfterValidator($attributes, $opType);
		$ret = $this->getDOperator()->batchUpdateByPk($values, $attributes);
		return $ret;
	}

	/**
	 * 验证新增数据
	 * @param array $rules
	 * @param array $attributes
	 * @param boolean $required
	 * @return array
	 */
	public function filterInsert(array $rules = array(), array $attributes = array(), $required = true)
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

		if (!empty($rules)) {
			$filter = $this->getFilter();
			if (!$filter->run($rules, $attributes, $required)) {
				$errNo = ErrorNo::ERROR_ARGS_INSERT;
				$errMsg = Text::_('ERROR_MSG_ERROR_ARGS_INSERT');
				$errors = $filter->getErrors();
				Log::warning(sprintf(
					'%s attributes "%s", errors "%s"', $errMsg, serialize($attributes), serialize($errors)
				), $errNo, __METHOD__);
				return array(
					'err_no' => $errNo,
					'err_msg' => $errMsg,
					'errors' => $errors
				);
			}
		}

		return array(
			$errNo = ErrorNo::SUCCESS_NUM,
			$errMsg = Text::_('ERROR_MSG_SUCCESS_ARGS_INSERT')
		);
	}

	/**
	 * 验证编辑数据
	 * @param array $rules
	 * @param array $attributes
	 * @param boolean $required
	 * @return array
	 */
	public function filterUpdate(array $rules = array(), array $attributes = array(), $required = false)
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

		if (!empty($rules)) {
			$filter = $this->getFilter();
			if (!$filter->run($rules, $attributes, $required)) {
				$errNo = ErrorNo::ERROR_ARGS_UPDATE;
				$errMsg = Text::_('ERROR_MSG_ERROR_ARGS_UPDATE');
				$errors = $filter->getErrors();
				Log::warning(sprintf(
					'%s attributes "%s", errors "%s"', $errMsg, serialize($attributes), serialize($errors)
				), $errNo, __METHOD__);
				return array(
					'err_no' => $errNo,
					'err_msg' => $errMsg,
					'errors' => $errors
				);
			}
		}

		return array(
			$errNo = ErrorNo::SUCCESS_NUM,
			$errMsg = Text::_('ERROR_MSG_SUCCESS_ARGS_UPDATE')
		);
	}

	/**
	 * 通过过滤数组，只保留指定的字段名，为INSERT、UPDATE服务
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
	 * 通过过滤数组，删除指定的字段名，为INSERT、UPDATE服务
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
	 * 获取数据验证类
	 * @return instance of tfc\validator\Filter
	 */
	public function getFilter()
	{
		return Singleton::getInstance('tfc\\validator\\Filter');
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
	 * 获取新增数据的验证规则，需要子类重写此方法
	 * @param string $opType
	 * @return array
	 */
	public function getRules($opType = '')
	{
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
}
