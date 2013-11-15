<?php
/**
 * Trotri Base Classes
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace base;

use tfc\ap\Singleton;
use tfc\saf\Log;

/**
 * Model abstract class file
 * 业务处理层基类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Model.php 1 2013-05-18 14:58:59Z huan.song $
 * @package base
 * @since 1.0
 */
abstract class Model
{
	/**
	 * @var integer 每页默认展示的行数
	 */
	protected $_listRows = 20;

	/**
	 * @var integer 每页默认展示的页码数
	 */
	protected $_listPages = 4;

	/**
	 * @var string 从$_GET或$_POST中获取当前页的键名
	 */
	protected $_pageVar = 'page';

	/**
	 * 通过多个字段名和值，获取主键的值，字段之间用简单的AND连接
	 * @param array $attributes
	 * @return array
	 */
	public function getPkByAttributes(array $attributes = array())
	{
		$condition = $this->getDb()->getCommandBuilder()->createAndCondition(array_keys($attributes));
		return $this->getPkByCondition($condition, $attributes);
	}

	/**
	 * 通过多个字段名和值，获取某个列的值，字段之间用简单的AND连接
	 * @param string $columnName
	 * @param array $attributes
	 * @return array
	 */
	public function getByAttributes($columnName, array $attributes = array())
	{
		$condition = $this->getDb()->getCommandBuilder()->createAndCondition(array_keys($attributes));
		return $this->getByCondition($columnName, $condition, $attributes);
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
		$condition = $this->getDb()->getCommandBuilder()->createAndCondition(array_keys($attributes));
		return $this->findAllByCondition($condition, $attributes, $order, $limit, $offset);
	}

	/**
	 * 通过多个字段名和值，统计记录数，字段之间用简单的AND连接
	 * @param array $attributes
	 * @return array
	 */
	public function countByAttributes(array $attributes = array())
	{
		$condition = $this->getDb()->getCommandBuilder()->createAndCondition(array_keys($attributes));
		return $this->countByCondition($condition, $attributes);
	}

	/**
	 * 通过多个字段名和值，查询一条记录，字段之间用简单的AND连接
	 * @param array $attributes
	 * @return array
	 */
	public function findByAttributes(array $attributes = array())
	{
		$condition = $this->getDb()->getCommandBuilder()->createAndCondition(array_keys($attributes));
		return $this->findByCondition($condition, $attributes);
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
		return $this->findAllByCondition(1, null, $order, $limit, $offset);
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
		$data = $this->getDb()->findAllByCondition($condition, $params, $order, $limit, $offset);
		if ($data === false) {
			$errNo = ErrorNo::ERROR_DB_SELECT;
			$errMsg = ErrorMsg::ERROR_DB_SELECT;
			Log::warning(sprintf(
				'%s condition "%s", params "%s", order "%s", limit "%d", offset "%d"',
				$errMsg, $condition, (is_array($params) ? serialize($params) : $params), $order, $limit, $offset
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg
			);
		}

		return array(
			'err_no' => ErrorNo::SUCCESS_NUM,
			'err_msg' => ErrorMsg::SUCCESS_SELECT,
			'data' => $data
		);
	}

	/**
	 * 通过条件，统计记录数
	 * @param string $condition
	 * @param mixed $params
	 * @return array
	 */
	public function countByCondition($condition, $params = null)
	{
		$total = $this->getDb()->countByCondition($condition, $params);
		if ($total === false) {
			$errNo = ErrorNo::ERROR_DB_SELECT;
			$errMsg = ErrorMsg::ERROR_DB_SELECT;
			Log::warning(sprintf(
				'%s condition "%s", params "%s"', $errMsg, $condition, (is_array($params) ? serialize($params) : $params)
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg
			);
		}

		$errNo = ErrorNo::SUCCESS_NUM;
		$errMsg = ErrorMsg::SUCCESS_SELECT;
		Log::notice(sprintf(
			'%s condition "%s", params "%s", total "%d"',
			$errMsg, $condition, (is_array($params) ? serialize($params) : $params), $total
		), __METHOD__);

		return array(
			'err_no' => $errNo,
			'err_msg' => $errMsg,
			'total' => $total
		);
	}

	/**
	 * 通过条件，获取主键的值
	 * @param string $condition
	 * @param mixed $params
	 * @return array
	 */
	public function getPkByCondition($condition, $params = null)
	{
		$columnName = $this->getDb()->getPrimaryKey();
		$ret = $this->getByCondition($columnName, $condition, $params);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return $ret;
		}

		return array(
			'err_no' => ErrorNo::SUCCESS_NUM,
			'err_msg' => ErrorMsg::SUCCESS_SELECT,
			'id' => $ret[$columnName]
		);
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
		$ret = $this->findByCondition($condition, $params);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return $ret;
		}

		if (!isset($ret['data'][$columnName])) {
			$errNo = ErrorNo::ERROR_ARGS_SELECT;
			$errMsg = ErrorMsg::ERROR_ARGS_SELECT;
			Log::warning(sprintf(
				'%s column_name "%s", condition "%s", params "%s"',
				$errMsg, $columnName, $condition, (is_array($params) ? serialize($params) : $params)
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg
			);
		}

		return array(
			'err_no' => ErrorNo::SUCCESS_NUM,
			'err_msg' => ErrorMsg::SUCCESS_SELECT,
			$columnName => $ret['data'][$columnName]
		);
	}

	/**
	 * 通过条件，查询一条记录
	 * @param string $condition
	 * @param mixed $params
	 * @return array
	 */
	public function findByCondition($condition, $params = null)
	{
		$data = $this->getDb()->findByCondition($condition, $params);
		if ($data === false || empty($data)) {
			$errNo = ErrorNo::ERROR_DB_SELECT_EMPTY;
			$errMsg = ErrorMsg::ERROR_DB_SELECT_EMPTY;
			Log::warning(sprintf(
				'%s condition "%s", params "%s"', $errMsg, $condition, (is_array($params) ? serialize($params) : $params)
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'data' => array()
			);
		}

		$errNo = ErrorNo::SUCCESS_NUM;
		$errMsg = ErrorMsg::SUCCESS_SELECT;
		Log::notice(sprintf(
			'%s condition "%s", params "%s"', $errMsg, $condition, (is_array($params) ? serialize($params) : $params)
		), __METHOD__);
		Log::debug(sprintf(
			'%s condition "%s", params "%s", data "%s"',
			$errMsg, $condition, (is_array($params) ? serialize($params) : $params), serialize($data)
		), __METHOD__);

		return array(
			'err_no' => $errNo,
			'err_msg' => $errMsg,
			'data' => $data
		);
	}

	/**
	 * 通过主键，获取某个列的值。不支持联合主键
	 * @param string $columnName
	 * @param integer $value
	 * @return array
	 */
	public function getByPk($columnName, $value)
	{
		$ret = $this->findByPk($value);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return $ret;
		}

		if (!isset($ret['data'][$columnName])) {
			$errNo = ErrorNo::ERROR_ARGS_SELECT;
			$errMsg = ErrorMsg::ERROR_ARGS_SELECT;
			Log::warning(sprintf(
				'%s column_name "%s", pk "%d"', $errMsg, $columnName, $value
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg
			);
		}

		return array(
			'err_no' => ErrorNo::SUCCESS_NUM,
			'err_msg' => ErrorMsg::SUCCESS_SELECT,
			$columnName => $ret['data'][$columnName]
		);
	}

	/**
	 * 通过主键，查询一条记录。不支持联合主键
	 * @param integer $value
	 * @return array
	 */
	public function findByPk($value)
	{
		$value = (int) $value;
		if ($value <= 0) {
			$errNo = ErrorNo::ERROR_ARGS_SELECT;
			$errMsg = ErrorMsg::ERROR_ARGS_SELECT;
			Log::warning(sprintf(
				'%s pk "%d"', $errMsg, $value
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg
			);
		}

		$data = $this->getDb()->findByPk($value);
		if ($data === false || empty($data)) {
			$errNo = ErrorNo::ERROR_DB_SELECT_EMPTY;
			$errMsg = ErrorMsg::ERROR_DB_SELECT_EMPTY;
			Log::warning(sprintf(
				'%s pk "%d"', $errMsg, $value
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'data' => array()
			);
		}

		$errNo = ErrorNo::SUCCESS_NUM;
		$errMsg = ErrorMsg::SUCCESS_SELECT;
		Log::notice(sprintf(
			'%s pk "%d"', $errMsg, $value
		), __METHOD__);
		Log::debug(sprintf(
			'%s pk "%d", data "%s"', $errMsg, $value, serialize($data)
		), __METHOD__);

		return array(
			'err_no' => $errNo,
			'err_msg' => $errMsg,
			'data' => $data
		);
	}

	/**
	 * 新增一条记录
	 * @param array $attributes
	 * @param Helper $helper
	 * @param boolean $ignore
	 * @return array
	 */
	public function insert(array $attributes = array(), Helper $helper = null, $ignore = false)
	{
		if (empty($attributes)) {
			$errNo = ErrorNo::ERROR_ARGS_INSERT;
			$errMsg = ErrorMsg::ERROR_ARGS_INSERT;
			Log::warning(sprintf(
				'%s attributes empty', $errMsg
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg
			);
		}

		if ($helper !== null) {
			$filter = Singleton::getInstance('tfc\validator\Filter');
			$rules = $helper->getBeforeValidatorCleanRules();
			if (is_array($rules)) {
				$filter->clean($rules, $attributes);
			}

			$rules = $helper->getInsertRules();
			if (is_array($rules)) {
				if (!$filter->run($rules, $attributes, true)) {
					$errNo = ErrorNo::ERROR_ARGS_INSERT;
					$errMsg = ErrorMsg::ERROR_ARGS_INSERT;
					$errors = $filter->getErrors(true);
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

			$rules = $helper->getAfterValidatorCleanRules();
			if (is_array($rules)) {
				$filter->clean($rules, $attributes);
			}
		}

		$value = $this->getDb()->insert($attributes);
		if ($value === false || $value <= 0) {
			$errNo = ErrorNo::ERROR_DB_INSERT;
			$errMsg = ErrorMsg::ERROR_DB_INSERT;
			Log::warning(sprintf(
				'%s pk "%d", attributes "%s"', $errMsg, $value, serialize($attributes)
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg
			);
		}

		$errNo = ErrorNo::SUCCESS_NUM;
		$errMsg = ErrorMsg::SUCCESS_INSERT;
		Log::notice(sprintf(
			'%s pk "%s", attributes "%s"', $errMsg, $value, serialize($attributes)
		), __METHOD__);

		return array(
			'err_no' => $errNo,
			'err_msg' => $errMsg,
			'id' => $value
		);
	}

	/**
	 * 通过主键，编辑一条记录。不支持联合主键
	 * @param integer $value
	 * @param array $attributes
	 * @param Helper $helper
	 * @return array
	 */
	public function updateByPk($value, array $attributes = array(), Helper $helper = null)
	{
		$value = (int) $value;
		if ($value <= 0) {
			$errNo = ErrorNo::ERROR_ARGS_UPDATE;
			$errMsg = ErrorMsg::ERROR_ARGS_UPDATE;
			Log::warning(sprintf(
				'%s pk "%d"', $errMsg, $value
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'id' => $value
			);
		}

		if (empty($attributes)) {
			$errNo = ErrorNo::ERROR_ARGS_UPDATE;
			$errMsg = ErrorMsg::ERROR_ARGS_UPDATE;
			Log::warning(sprintf(
				'%s pk "%d", attributes empty', $errMsg, $value
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'id' => $value
			);
		}

		if ($helper !== null) {
			$filter = Singleton::getInstance('tfc\validator\Filter');
			$rules = $helper->getBeforeValidatorCleanRules();
			if (is_array($rules)) {
				$filter->clean($rules, $attributes);
			}

			$rules = $helper->getUpdateRules();
			if (is_array($rules)) {
				if (!$filter->run($rules, $attributes, false)) {
					$errNo = ErrorNo::ERROR_ARGS_UPDATE;
					$errMsg = ErrorMsg::ERROR_ARGS_UPDATE;
					$errors = $filter->getErrors(true);
					Log::warning(sprintf(
						'%s pk "%d", attributes "%s", errors "%s"', $errMsg, $value, serialize($attributes), serialize($errors)
					), $errNo, __METHOD__);
					return array(
						'err_no' => $errNo,
						'err_msg' => $errMsg,
						'errors' => $errors,
						'id' => $value
					);
				}
			}

			$rules = $helper->getAfterValidatorCleanRules();
			if (is_array($rules)) {
				$filter->clean($rules, $attributes);
			}
		}

		$rowCount = $this->getDb()->updateByPk($value, $attributes);
		if ($rowCount === false) {
			$errNo = ErrorNo::ERROR_DB_UPDATE;
			$errMsg = ErrorMsg::ERROR_DB_UPDATE;
			Log::warning(sprintf(
				'%s pk "%d", attributes "%s"', $errMsg, $value, serialize($attributes)
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'id' => $value
			);
		}

		if ($rowCount <= 0) {
			$errNo = ErrorNo::ERROR_DB_AFFECTS_ZERO;
			$errMsg = ErrorMsg::ERROR_DB_AFFECTS_ZERO;
			Log::warning(sprintf(
				'%s pk "%d", rowCount "%d", attributes "%s"', $errMsg, $value, $rowCount, serialize($attributes)
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'id' => $value
			);
		}

		$errNo = ErrorNo::SUCCESS_NUM;
		$errMsg = ErrorMsg::SUCCESS_UPDATE;
		Log::notice(sprintf(
			'%s pk "%d", rowCount "%d", attributes "%s"', $errMsg, $value, $rowCount, serialize($attributes)
		), __METHOD__);

		return array(
			'err_no' => $errNo,
			'err_msg' => $errMsg,
			'row_count' => $rowCount,
			'id' => $value
		);
	}

	/**
	 * 通过主键，删除一条记录。不支持联合主键
	 * @param integer $value
	 * @return array
	 */
	public function deleteByPk($value)
	{
		$value = (int) $value;
		if ($value <= 0) {
			$errNo = ErrorNo::ERROR_ARGS_DELETE;
			$errMsg = ErrorMsg::ERROR_ARGS_DELETE;
			Log::warning(sprintf(
				'%s pk "%d"', $errMsg, $value
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'id' => $value
			);
		}

		$rowCount = $this->getDb()->deleteByPk($value);
		if ($rowCount === false) {
			$errNo = ErrorNo::ERROR_DB_DELETE;
			$errMsg = ErrorMsg::ERROR_DB_DELETE;
			Log::warning(sprintf(
				'%s pk "%d"', $errMsg, $value
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'id' => $value
			);
		}

		if ($rowCount <= 0) {
			$errNo = ErrorNo::ERROR_DB_AFFECTS_ZERO;
			$errMsg = ErrorMsg::ERROR_DB_AFFECTS_ZERO;
			Log::warning(sprintf(
				'%s pk "%d", rowCount "%d"', $errMsg, $value, $rowCount
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'id' => $value
			);
		}

		$errNo = ErrorNo::SUCCESS_NUM;
		$errMsg = ErrorMsg::SUCCESS_DELETE;
		Log::notice(sprintf(
			'%s pk "%d", rowCount "%d"', $errMsg, $value, $rowCount
		), __METHOD__);

		return array(
			'err_no' => $errNo,
			'err_msg' => $errMsg,
			'row_count' => $rowCount,
			'id' => $value
		);
	}

	/**
	 * 通过主键，删除一条记录，删除前先将原始数据打印到日志中。不支持联合主键
	 * @param integer $value
	 * @return array
	 */
	public function deleteByPkBkLog($value)
	{
		$ret = $this->findByPk($value);
		if ($ret['err_no'] === ErrorNo::ERROR_ARGS_SELECT) {
			$ret['id'] = $value;
			return $ret;
		}

		if ($ret['err_no'] === ErrorNo::ERROR_DB_SELECT_EMPTY) {
			$errNo = ErrorNo::ERROR_DB_AFFECTS_ZERO;
			$errMsg = ErrorMsg::ERROR_DB_AFFECTS_ZERO;
			Log::warning(sprintf(
				'%s pk "%d", rowCount "%d"', $errMsg, $value, 0
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'id' => $value
			);
		}

		Log::notice(sprintf(
			'Backup Before Delete! pk "%d", data "%s"', $value, serialize($ret['data'])
		), __METHOD__);

		return $this->deleteByPk($value);
	}

	/**
	 * 通过过滤数组，只保留指定的字段名，为INSERT、UPDATE服务
	 * @param array $attributes
	 * @param mixed $columnNames
	 * @return void
	 */
	public function filterAttributes(array &$attributes = array(), $columnNames)
	{
		$columnNames = (array) $columnNames;
		foreach ($attributes as $key => $value) {
			if (!in_array($key, $columnNames)) {
				unset($attributes[$key]);
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
	 * 获取当前业务类对应的DB操作类
	 * @return instance of base\Db
	 */
	public function getDb()
	{
		$className = str_replace('model', 'db', get_class($this));
		return Singleton::getInstance($className);
	}

	/**
	 * 获取当前业务类对应的辅助层类
	 * @return instance of base\Generators
	 */
	public function getHelper()
	{
		$className = str_replace('model', 'helper', get_class($this));
		return Singleton::getInstance($className);
	}
}
