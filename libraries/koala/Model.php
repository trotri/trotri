<?php
/**
 * Trotri Koala
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace koala;

use tfc\ap\Singleton;
use tfc\mvc\Mvc;
use tfc\util\Language;
use tfc\saf\Log;
use tfc\saf\Cfg;

/**
 * Model abstract class file
 * 业务处理层基类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Model.php 1 2013-05-18 14:58:59Z huan.song $
 * @package koala
 * @since 1.0
 */
abstract class Model
{
	/**
	 * @var instance of tfc\util\Language
	 */
	protected $_language = null;

	/**
	 * @var instance of koala\Db
	 */
	protected $_db = null;

	/**
	 * 构造方法：初始化当前业务类对应的数据库操作类
	 * @param koala\Db $db
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
		$condition = $this->getDb()->getCommandBuilder()->createAndCondition(array_keys($attributes));
		return $this->getPkByCondition($condition, $attributes);
	}

	/**
	 * 通过多个字段名和值，获取某个列的值，字段之间用简单的AND连接，字段之间用简单的AND连接
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
		$condition = $this->getDb()->getCommandBuilder()->createAndCondition(array_keys($attributes));
		return $this->findPairsByCondition($columnNames, $condition, $attributes, $order, $limit, $offset, $option);
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
	 * @param string $option
	 * @return array
	 */
	public function findAll($order = '', $limit = 0, $offset = 0, $option = '')
	{
		return $this->findAllByCondition(1, null, $order, $limit, $offset, $option);
	}

	/**
	 * 通过多个字段名和值，查询多条记录，字段之间用简单的AND连接，并且返回分页信息
	 * @param array $attributes
	 * @param string $order
	 * @param integer $pageNo
	 * @return array
	 */
	public function findIndexByAttributes(array $attributes = array(), $order = '', $pageNo = 0)
	{
		$condition = $this->getDb()->getCommandBuilder()->createAndCondition(array_keys($attributes));
		return $this->findIndexByCondition($condition, $attributes, $order, $pageNo);
	}

	/**
	 * 通过条件，查询多条记录，并且返回分页信息
	 * @param string $condition
	 * @param mixed $params
	 * @param string $order
	 * @param integer $pageNo
	 * @return array
	 */
	public function findIndexByCondition($condition, $params = null, $order = '', $pageNo = 0)
	{
		$pageNo = max((int) $pageNo, 1);
		$listRows = (int) Cfg::getApp('list_rows', 'paginator');
		$offset = ($pageNo - 1) * $listRows;
		$ret = $this->findAllByCondition($condition, $params, $order, $listRows, $offset, 'SQL_CALC_FOUND_ROWS');
		$totalRows = 0;
		if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
			$totalRows = $this->getDb()->getFoundRows();
		}

		$ret['paginator'] = array(
			'total_rows' => $totalRows,
			'curr_page' => $pageNo,
			'list_rows' => $listRows,
			'url' => Mvc::getView()->getUrlManager()->getUrl(Mvc::$action, '', '', $params)
		);

		$ret['params'] = array(
			'attributes' => $params,
			'curr_page' => $pageNo,
			'order' => $order,
		);

		return $ret;
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
		$ret = $this->findColumnsByCondition($columnNames, $condition, $params, $order, $limit, $offset, $option);
		if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
			$data = array();
			$columnName0 = $columnNames[0];
			$columnName1 = $columnNames[1];
			foreach ($ret['data'] as $row) {
				$data[$row[$columnName0]] = $row[$columnName1];
			}

			$ret['data'] = $data;
		}

		return $ret;
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
		$data = $this->getDb()->findColumnsByCondition($columnNames, $condition, $params, $order, $limit, $offset, $option);
		if ($data === false) {
			$errNo = ErrorNo::ERROR_DB_SELECT;
			$errMsg = $this->_('ERROR_MSG_ERROR_DB_SELECT');
			Log::warning(sprintf(
				'%s columnNames "%s", condition "%s", params "%s", order "%s", limit "%d", offset "%d", option "%s"',
				$errMsg, implode(',', $columnNames), $condition, (is_array($params) ? serialize($params) : $params), $order, $limit, $offset, $option
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg
			);
		}

		return array(
			'err_no' => ErrorNo::SUCCESS_NUM,
			'err_msg' => $this->_('ERROR_MSG_SUCCESS_SELECT'),
			'data' => $data
		);
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
	public function findAllByCondition($condition, $params = null, $order = '', $limit = 0, $offset = 0, $option = '')
	{
		$data = $this->getDb()->findAllByCondition($condition, $params, $order, $limit, $offset, $option);
		if ($data === false) {
			$errNo = ErrorNo::ERROR_DB_SELECT;
			$errMsg = $this->_('ERROR_MSG_ERROR_DB_SELECT');
			Log::warning(sprintf(
				'%s condition "%s", params "%s", order "%s", limit "%d", offset "%d", option "%s"',
				$errMsg, $condition, (is_array($params) ? serialize($params) : $params), $order, $limit, $offset, $option
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg
			);
		}

		return array(
			'err_no' => ErrorNo::SUCCESS_NUM,
			'err_msg' => $this->_('ERROR_MSG_SUCCESS_SELECT'),
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
			$errMsg = $this->_('ERROR_MSG_ERROR_DB_SELECT');
			Log::warning(sprintf(
				'%s condition "%s", params "%s"', $errMsg, $condition, (is_array($params) ? serialize($params) : $params)
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg
			);
		}

		$errNo = ErrorNo::SUCCESS_NUM;
		$errMsg = $this->_('ERROR_MSG_SUCCESS_SELECT');
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
	 * 通过条件，获取主键的值。不支持联合主键
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
			'err_msg' => $this->_('ERROR_MSG_SUCCESS_SELECT'),
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
			$errMsg = $this->_('ERROR_MSG_ERROR_ARGS_SELECT');
			Log::warning(sprintf(
				'%s column_name "%s" not exists, condition "%s", params "%s"',
				$errMsg, $columnName, $condition, (is_array($params) ? serialize($params) : $params)
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg
			);
		}

		return array(
			'err_no' => ErrorNo::SUCCESS_NUM,
			'err_msg' => $this->_('ERROR_MSG_SUCCESS_SELECT'),
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
			$errMsg = $this->_('ERROR_MSG_ERROR_DB_SELECT_EMPTY');
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
		$errMsg = $this->_('ERROR_MSG_SUCCESS_SELECT');
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
			$errMsg = $this->_('ERROR_MSG_ERROR_ARGS_SELECT');
			Log::warning(sprintf(
				'%s column_name "%s" not exists, pk "%d"', $errMsg, $columnName, $value
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg
			);
		}

		return array(
			'err_no' => ErrorNo::SUCCESS_NUM,
			'err_msg' => $this->_('ERROR_MSG_SUCCESS_SELECT'),
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
			$errMsg = $this->_('ERROR_MSG_ERROR_ARGS_SELECT');
			Log::warning(sprintf(
				'%s pk "%d"', $errMsg, $value
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg
			);
		}

		$data = $this->getDb()->findByPk($value);
		if (empty($data)) {
			$errNo = ErrorNo::ERROR_DB_SELECT_EMPTY;
			$errMsg = $this->_('ERROR_MSG_ERROR_DB_SELECT_EMPTY');
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
		$errMsg = $this->_('ERROR_MSG_SUCCESS_SELECT');
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
	 * @param boolean $ignore
	 * @return array
	 */
	public function insert(array $attributes = array(), $ignore = false)
	{
		$this->filterAttributes($attributes);
		if (empty($attributes)) {
			$errNo = ErrorNo::ERROR_ARGS_INSERT;
			$errMsg = $this->_('ERROR_MSG_ERROR_ARGS_INSERT');
			Log::warning(sprintf(
				'%s attributes empty', $errMsg
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg
			);
		}

		$filter = Singleton::getInstance('tfc\\validator\\Filter');
		$rules = $this->getCleanRulesBeforeValidator();
		if (is_array($rules)) {
			$filter->clean($rules, $attributes);
		}

		$rules = $this->getInsertRules();
		if (is_array($rules)) {
			if (!$filter->run($rules, $attributes, true)) {
				$errNo = ErrorNo::ERROR_ARGS_INSERT;
				$errMsg = $this->_('ERROR_MSG_ERROR_ARGS_INSERT');
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

		$rules = $this->getCleanRulesAfterValidator();
		if (is_array($rules)) {
			$filter->clean($rules, $attributes);
		}

		$value = $this->getDb()->insert($attributes);
		if ($value === false || $value <= 0) {
			$errNo = ErrorNo::ERROR_DB_INSERT;
			$errMsg = $this->_('ERROR_MSG_ERROR_DB_INSERT');
			Log::warning(sprintf(
				'%s pk "%d", attributes "%s"', $errMsg, $value, serialize($attributes)
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg
			);
		}

		$errNo = ErrorNo::SUCCESS_NUM;
		$errMsg = $this->_('ERROR_MSG_SUCCESS_INSERT');
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
	 * @return array
	 */
	public function updateByPk($value, array $attributes = array())
	{
		$value = (int) $value;
		if ($value <= 0) {
			$errNo = ErrorNo::ERROR_ARGS_UPDATE;
			$errMsg = $this->_('ERROR_MSG_ERROR_ARGS_UPDATE');
			Log::warning(sprintf(
				'%s pk "%d"', $errMsg, $value
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'id' => $value
			);
		}

		$this->filterAttributes($attributes);
		if (empty($attributes)) {
			$errNo = ErrorNo::ERROR_ARGS_UPDATE;
			$errMsg = $this->_('ERROR_MSG_ERROR_ARGS_UPDATE');
			Log::warning(sprintf(
				'%s pk "%d", attributes empty', $errMsg, $value
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'id' => $value
			);
		}

		$filter = Singleton::getInstance('tfc\\validator\\Filter');
		$rules = $this->getCleanRulesBeforeValidator();
		if (is_array($rules)) {
			$filter->clean($rules, $attributes);
		}

		$rules = $this->getUpdateRules();
		if (is_array($rules)) {
			if (!$filter->run($rules, $attributes, false)) {
				$errNo = ErrorNo::ERROR_ARGS_UPDATE;
				$errMsg = $this->_('ERROR_MSG_ERROR_ARGS_UPDATE');
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

		$rules = $this->getCleanRulesAfterValidator();
		if (is_array($rules)) {
			$filter->clean($rules, $attributes);
		}

		$rowCount = $this->getDb()->updateByPk($value, $attributes);
		if ($rowCount === false) {
			$errNo = ErrorNo::ERROR_DB_UPDATE;
			$errMsg = $this->_('ERROR_MSG_ERROR_DB_UPDATE');
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
			$errMsg = $this->_('ERROR_MSG_ERROR_DB_AFFECTS_ZERO');
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
		$errMsg = $this->_('ERROR_MSG_SUCCESS_UPDATE');
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
	 * 通过主键，编辑多条记录。不支持联合主键
	 * @param array $values
	 * @param array $attributes
	 * @return integer
	 */
	public function batchUpdateByPk(array $values, array $attributes = array())
	{
		$values = array_map('intval', $values);
		$value = implode(',', $values);
		foreach ($values as $_) {
			if ($_ <= 0) {
				$errNo = ErrorNo::ERROR_ARGS_UPDATE;
				$errMsg = $this->_('ERROR_MSG_ERROR_ARGS_UPDATE');
				Log::warning(sprintf(
					'%s pks "%s"', $errMsg, $value
				), $errNo, __METHOD__);
				return array(
					'err_no' => $errNo,
					'err_msg' => $errMsg,
					'ids' => $value
				);
			}
		}

		$this->filterAttributes($attributes);
		if (empty($attributes)) {
			$errNo = ErrorNo::ERROR_ARGS_UPDATE;
			$errMsg = $this->_('ERROR_MSG_ERROR_ARGS_UPDATE');
			Log::warning(sprintf(
				'%s pks "%s", attributes empty', $errMsg, $value
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'ids' => $value
			);
		}

		$filter = Singleton::getInstance('tfc\\validator\\Filter');
		$rules = $this->getCleanRulesBeforeValidator();
		if (is_array($rules)) {
			$filter->clean($rules, $attributes);
		}

		$rules = $this->getUpdateRules();
		if (is_array($rules)) {
			if (!$filter->run($rules, $attributes, false)) {
				$errNo = ErrorNo::ERROR_ARGS_UPDATE;
				$errMsg = $this->_('ERROR_MSG_ERROR_ARGS_UPDATE');
				$errors = $filter->getErrors(true);
				Log::warning(sprintf(
					'%s pks "%s", attributes "%s", errors "%s"', $errMsg, $value, serialize($attributes), serialize($errors)
				), $errNo, __METHOD__);
				return array(
					'err_no' => $errNo,
					'err_msg' => $errMsg,
					'errors' => $errors,
					'ids' => $value
				);
			}
		}

		$rules = $this->getCleanRulesAfterValidator();
		if (is_array($rules)) {
			$filter->clean($rules, $attributes);
		}

		$rowCount = $this->getDb()->batchUpdateByPk($value, $attributes);
		if ($rowCount === false) {
			$errNo = ErrorNo::ERROR_DB_UPDATE;
			$errMsg = $this->_('ERROR_MSG_ERROR_DB_UPDATE');
			Log::warning(sprintf(
				'%s pks "%s", attributes "%s"', $errMsg, $value, serialize($attributes)
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'ids' => $value
			);
		}

		if ($rowCount <= 0) {
			$errNo = ErrorNo::ERROR_DB_AFFECTS_ZERO;
			$errMsg = $this->_('ERROR_MSG_ERROR_DB_AFFECTS_ZERO');
			Log::warning(sprintf(
				'%s pks "%s", rowCount "%d", attributes "%s"', $errMsg, $value, $rowCount, serialize($attributes)
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'ids' => $value
			);
		}

		$errNo = ErrorNo::SUCCESS_NUM;
		$errMsg = $this->_('ERROR_MSG_SUCCESS_UPDATE');
		Log::notice(sprintf(
			'%s pks "%s", rowCount "%d", attributes "%s"', $errMsg, $value, $rowCount, serialize($attributes)
		), __METHOD__);

		return array(
			'err_no' => $errNo,
			'err_msg' => $errMsg,
			'row_count' => $rowCount,
			'ids' => $value
		);
	}

	/**
	 * 通过主键，将一条记录移至回收站。不支持联合主键
	 * @param integer $value
	 * @param string $columnName
	 * @return array
	 */
	public function trashByPk($value, $columnName = 'trash')
	{
		$value = (int) $value;
		if ($value <= 0) {
			$errNo = ErrorNo::ERROR_ARGS_DELETE;
			$errMsg = $this->_('ERROR_MSG_ERROR_ARGS_DELETE');
			Log::warning(sprintf(
				'%s pk "%d"', $errMsg, $value
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'id' => $value
			);
		}

		$attributes = array($columnName => 'y');
		$rowCount = $this->getDb()->updateByPk($value, $attributes);
		if ($rowCount === false) {
			$errNo = ErrorNo::ERROR_DB_DELETE;
			$errMsg = $this->_('ERROR_MSG_ERROR_DB_DELETE');
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
			$errMsg = $this->_('ERROR_MSG_ERROR_DB_AFFECTS_ZERO');
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
		$errMsg = $this->_('ERROR_MSG_SUCCESS_DELETE');
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
	 * 通过主键，将多条记录移至回收站。不支持联合主键
	 * @param array $values
	 * @param string $columnName
	 * @return array
	 */
	public function batchTrashByPk(array $values, $columnName = 'trash')
	{
		$values = array_map('intval', $values);
		$value = implode(',', $values);
		foreach ($values as $_) {
			if ($_ <= 0) {
				$errNo = ErrorNo::ERROR_ARGS_DELETE;
				$errMsg = $this->_('ERROR_MSG_ERROR_ARGS_DELETE');
				Log::warning(sprintf(
					'%s pks "%s"', $errMsg, $value
				), $errNo, __METHOD__);
				return array(
					'err_no' => $errNo,
					'err_msg' => $errMsg,
					'ids' => $value
				);
			}
		}

		$attributes = array($columnName => 'y');
		$rowCount = $this->getDb()->batchUpdateByPk($value, $attributes);
		if ($rowCount === false) {
			$errNo = ErrorNo::ERROR_DB_DELETE;
			$errMsg = $this->_('ERROR_MSG_ERROR_DB_DELETE');
			Log::warning(sprintf(
				'%s pks "%s", attributes "%s"', $errMsg, $value, serialize($attributes)
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'ids' => $value
			);
		}

		if ($rowCount <= 0) {
			$errNo = ErrorNo::ERROR_DB_AFFECTS_ZERO;
			$errMsg = $this->_('ERROR_MSG_ERROR_DB_AFFECTS_ZERO');
			Log::warning(sprintf(
				'%s pks "%s", rowCount "%d", attributes "%s"', $errMsg, $value, $rowCount, serialize($attributes)
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'ids' => $value
			);
		}

		$errNo = ErrorNo::SUCCESS_NUM;
		$errMsg = $this->_('ERROR_MSG_SUCCESS_DELETE');
		Log::notice(sprintf(
			'%s pks "%s", rowCount "%d", attributes "%s"', $errMsg, $value, $rowCount, serialize($attributes)
		), __METHOD__);

		return array(
			'err_no' => $errNo,
			'err_msg' => $errMsg,
			'row_count' => $rowCount,
			'ids' => $value
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
			$errMsg = $this->_('ERROR_MSG_ERROR_ARGS_DELETE');
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
			$errMsg = $this->_('ERROR_MSG_ERROR_DB_DELETE');
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
			$errMsg = $this->_('ERROR_MSG_ERROR_DB_AFFECTS_ZERO');
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
		$errMsg = $this->_('ERROR_MSG_SUCCESS_DELETE');
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
	 * 通过主键，删除多条记录。不支持联合主键
	 * @param array $values
	 * @return integer
	 */
	public function batchDeleteByPk(array $values)
	{
		$values = array_map('intval', $values);
		$value = implode(',', $values);
		foreach ($values as $_) {
			if ($_ <= 0) {
				$errNo = ErrorNo::ERROR_ARGS_DELETE;
				$errMsg = $this->_('ERROR_MSG_ERROR_ARGS_DELETE');
				Log::warning(sprintf(
					'%s pks "%s"', $errMsg, $value
				), $errNo, __METHOD__);
				return array(
					'err_no' => $errNo,
					'err_msg' => $errMsg,
					'ids' => $value
				);
			}
		}

		$rowCount = $this->getDb()->batchDeleteByPk($value);
		if ($rowCount === false) {
			$errNo = ErrorNo::ERROR_DB_DELETE;
			$errMsg = $this->_('ERROR_MSG_ERROR_DB_DELETE');
			Log::warning(sprintf(
				'%s pks "%s"', $errMsg, $value
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'ids' => $value
			);
		}

		if ($rowCount <= 0) {
			$errNo = ErrorNo::ERROR_DB_AFFECTS_ZERO;
			$errMsg = $this->_('ERROR_MSG_ERROR_DB_AFFECTS_ZERO');
			Log::warning(sprintf(
				'%s pks "%s", rowCount "%d"', $errMsg, $value, $rowCount
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'ids' => $value
			);
		}

		$errNo = ErrorNo::SUCCESS_NUM;
		$errMsg = $this->_('ERROR_MSG_SUCCESS_DELETE');
		Log::notice(sprintf(
			'%s pks "%s", rowCount "%d"', $errMsg, $value, $rowCount
		), __METHOD__);

		return array(
			'err_no' => $errNo,
			'err_msg' => $errMsg,
			'row_count' => $rowCount,
			'ids' => $value
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
			$errMsg = $this->_('ERROR_MSG_ERROR_DB_AFFECTS_ZERO');
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
	 * 获取当前业务类对应的数据库操作类
	 * @return instance of koala\Db
	 */
	public function getDb()
	{
		return $this->_db;
	}

	/**
	 * 通过键名获取语言内容
	 * @param string $string
	 * @param boolean $jsSafe
	 * @param boolean $interpretBackSlashes
	 * @return string
	 */
	public function _($string, $jsSafe = false, $interpretBackSlashes = true)
	{
		return $this->getLanguage()->_($string, $jsSafe, $interpretBackSlashes);
	}

	/**
	 * 获取语言国际化管理类
	 * @return tfc\util\Language
	 */
	public function getLanguage()
	{
		if ($this->_language === null) {
			$type = Cfg::getApp('language');
			$baseDir = DIR_LIBRARIES . DS . 'koala' . DS . 'languages';
			$this->_language = Language::getInstance($type, $baseDir);
		}

		return $this->_language;
	}

	/**
	 * 获取新增数据的验证规则，需要子类重写此方法
	 * @return array
	 */
	public function getInsertRules()
	{
	}

	/**
	 * 获取编辑数据的验证规则，需要子类重写此方法
	 * @return array
	 */
	public function getUpdateRules()
	{
	}

	/**
	 * 获取验证数据前的清理规则，需要子类重写此方法
	 * @return array
	 */
	public function getCleanRulesBeforeValidator()
	{
	}

	/**
	 * 获取验证数据后的清理规则，需要子类重写此方法
	 * @return array
	 */
	public function getCleanRulesAfterValidator()
	{
	}
}
