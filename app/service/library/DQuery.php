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

use tfc\saf\Text;
use tfc\saf\Log;

/**
 * DQuery class file
 * 创建并执行简单的MySQL查询命令类
 * <pre>
 * 全部 ErrorNo => ErrorMsg
 * SUCCESS_NUM => ERROR_MSG_SUCCESS_SELECT
 * ERROR_ARGS_SELECT => ERROR_MSG_ERROR_ARGS_SELECT
 * ERROR_DB_SELECT_EMPTY => ERROR_MSG_ERROR_DB_SELECT_EMPTY
 * ERROR_DB_SELECT => ERROR_MSG_ERROR_DB_SELECT
 * </pre>
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: DQuery.php 1 2013-05-18 14:58:59Z huan.song $
 * @package library
 * @since 1.0
 */
class DQuery
{
	/**
	 * @var instance of tdo\Db
	 */
	protected $_db = null;

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
			$errMsg = Text::_('ERROR_MSG_ERROR_DB_SELECT');
			Log::warning(sprintf(
				'%s columnNames "%s", condition "%s", params "%s", order "%s", limit "%d", offset "%d", option "%s"',
				$errMsg, implode(',', $columnNames), $condition, (is_array($params) ? serialize($params) : $params), $order, $limit, $offset, $option
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg
			);
		}

		$errNo = ErrorNo::SUCCESS_NUM;
		$errMsg = Text::_('ERROR_MSG_SUCCESS_SELECT');
		Log::debug(sprintf(
			'%s columnNames "%s", condition "%s", params "%s", order "%s", limit "%d", offset "%d", option "%s"',
			$errMsg, implode(',', $columnNames), $condition, (is_array($params) ? serialize($params) : $params), $order, $limit, $offset, $option
		), __METHOD__);

		return array(
			'err_no' => $errNo,
			'err_msg' => $errMsg,
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
			$errMsg = Text::_('ERROR_MSG_ERROR_DB_SELECT');
			Log::warning(sprintf(
				'%s condition "%s", params "%s", order "%s", limit "%d", offset "%d", option "%s"',
				$errMsg, $condition, (is_array($params) ? serialize($params) : $params), $order, $limit, $offset, $option
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg
			);
		}

		$errNo = ErrorNo::SUCCESS_NUM;
		$errMsg = Text::_('ERROR_MSG_SUCCESS_SELECT');
		Log::debug(sprintf(
			'%s condition "%s", params "%s", order "%s", limit "%d", offset "%d", option "%s"',
			$errMsg, $condition, (is_array($params) ? serialize($params) : $params), $order, $limit, $offset, $option
		), __METHOD__);

		return array(
			'err_no' => $errNo,
			'err_msg' => $errMsg,
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
			$errMsg = Text::_('ERROR_MSG_ERROR_DB_SELECT');
			Log::warning(sprintf(
				'%s condition "%s", params "%s"', $errMsg, $condition, (is_array($params) ? serialize($params) : $params)
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg
			);
		}

		$errNo = ErrorNo::SUCCESS_NUM;
		$errMsg = Text::_('ERROR_MSG_SUCCESS_SELECT');
		Log::debug(sprintf(
			'%s condition "%s", params "%s", total "%d"',
			$errMsg, $condition, (is_array($params) ? serialize($params) : $params), $total
		), __METHOD__);

		return array(
			'err_no' => $errNo,
			'err_msg' => $errMsg,
			'total' => (int) $total
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
			'err_msg' => Text::_('ERROR_MSG_SUCCESS_SELECT'),
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
			$errMsg = Text::_('ERROR_MSG_ERROR_ARGS_SELECT');
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
			'err_msg' => Text::_('ERROR_MSG_SUCCESS_SELECT'),
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
		if (empty($data)) {
			$errNo = ErrorNo::ERROR_DB_SELECT_EMPTY;
			$errMsg = Text::_('ERROR_MSG_ERROR_DB_SELECT_EMPTY');
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
		$errMsg = Text::_('ERROR_MSG_SUCCESS_SELECT');
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
			$errMsg = Text::_('ERROR_MSG_ERROR_ARGS_SELECT');
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
			'err_msg' => Text::_('ERROR_MSG_SUCCESS_SELECT'),
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
			$errMsg = Text::_('ERROR_MSG_ERROR_ARGS_SELECT');
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
			$errMsg = Text::_('ERROR_MSG_ERROR_DB_SELECT_EMPTY');
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
		$errMsg = Text::_('ERROR_MSG_SUCCESS_SELECT');
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
	 * 获取当前业务类对应的数据库操作类
	 * @return instance of tdo\Db
	 */
	public function getDb()
	{
		return $this->_db;
	}
}
