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

use tfc\saf\Log;

/**
 * SrvOperator class file
 * 业务层：创建并执行简单的MySQL操作命令类
 * <pre>
 * 全部 ErrorNo => ErrorMsg
 * SUCCESS_NUM => ERROR_MSG_SUCCESS_INSERT
 * SUCCESS_NUM => ERROR_MSG_SUCCESS_DELETE
 * SUCCESS_NUM => ERROR_MSG_SUCCESS_UPDATE
 * SUCCESS_NUM => ERROR_MSG_ERROR_DB_AFFECTS_ZERO
 * ERROR_ARGS_INSERT => ERROR_MSG_ERROR_ARGS_INSERT
 * ERROR_ARGS_UPDATE => ERROR_MSG_ERROR_ARGS_UPDATE
 * ERROR_ARGS_DELETE => ERROR_MSG_ERROR_ARGS_DELETE
 * ERROR_DB_INSERT => ERROR_MSG_ERROR_DB_INSERT
 * ERROR_DB_UPDATE => ERROR_MSG_ERROR_DB_UPDATE
 * ERROR_DB_DELETE => ERROR_MSG_ERROR_DB_DELETE
 * </pre>
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: SrvOperator.php 1 2013-05-18 14:58:59Z huan.song $
 * @package slib
 * @since 1.0
 */
class SrvOperator extends BaseService
{
	/**
	 * 新增一条记录
	 * @param array $attributes
	 * @param boolean $ignore
	 * @return array
	 */
	public function insert(array $attributes = array(), $ignore = false)
	{
		if (!$attributes) {
			$errNo = ErrorNo::ERROR_ARGS_INSERT;
			$errMsg = $this->_('ERROR_MSG_ERROR_ARGS_INSERT');
			Log::warning(sprintf(
				'%s attributes empty, ignore "%d"', $errMsg, $ignore
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg
			);
		}

		$value = $this->getDb()->insert($attributes, $ignore);
		if ($value === false || $value <= 0) {
			$errNo = ErrorNo::ERROR_DB_INSERT;
			$errMsg = $this->_('ERROR_MSG_ERROR_DB_INSERT');
			Log::warning(sprintf(
				'%s pk "%d", attributes "%s", ignore "%d"', $errMsg, $value, serialize($attributes), $ignore
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg
			);
		}

		$errNo = ErrorNo::SUCCESS_NUM;
		$errMsg = $this->_('ERROR_MSG_SUCCESS_INSERT');
		Log::debug(sprintf(
			'%s pk "%s", attributes "%s", ignore "%d"', $errMsg, $value, serialize($attributes), $ignore
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
	 * @param boolean $required
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

		if (!$attributes) {
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

		$errNo = ErrorNo::SUCCESS_NUM;
		$errMsg = ($rowCount > 0) ? $this->_('ERROR_MSG_SUCCESS_UPDATE') : $this->_('ERROR_MSG_ERROR_DB_AFFECTS_ZERO');
		Log::debug(sprintf(
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
	 * @return array
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

		if (!$attributes) {
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

		$errNo = ErrorNo::SUCCESS_NUM;
		$errMsg = ($rowCount > 0) ? $this->_('ERROR_MSG_SUCCESS_UPDATE') : $this->_('ERROR_MSG_ERROR_DB_AFFECTS_ZERO');
		Log::debug(sprintf(
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
	 * @param integer $pk
	 * @param string $columnName
	 * @param string $value
	 * @return array
	 */
	public function trashByPk($pk, $columnName = 'trash', $value = 'y')
	{
		$pk = (int) $pk;
		if ($pk <= 0) {
			$errNo = ErrorNo::ERROR_ARGS_DELETE;
			$errMsg = $this->_('ERROR_MSG_ERROR_ARGS_DELETE');
			Log::warning(sprintf(
				'%s pk "%d"', $errMsg, $pk
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'id' => $pk
			);
		}

		$rowCount = $this->getDb()->updateByPk($pk, array($columnName => $value));
		if ($rowCount === false) {
			$errNo = ErrorNo::ERROR_DB_DELETE;
			$errMsg = $this->_('ERROR_MSG_ERROR_DB_DELETE');
			Log::warning(sprintf(
				'%s pk "%d", columnName "%s", value "%s"', $errMsg, $pk, $columnName, $value
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'id' => $pk
			);
		}

		$errNo = ErrorNo::SUCCESS_NUM;
		$errMsg = ($rowCount > 0) ? $this->_('ERROR_MSG_SUCCESS_DELETE') : $this->_('ERROR_MSG_ERROR_DB_AFFECTS_ZERO');
		Log::debug(sprintf(
			'%s pk "%d", rowCount "%d", columnName "%s", value "%s"', $errMsg, $pk, $rowCount, $columnName, $value
		), __METHOD__);

		return array(
			'err_no' => $errNo,
			'err_msg' => $errMsg,
			'row_count' => $rowCount,
			'id' => $pk
		);
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
		$pks = array_map('intval', $pks);
		$pk = implode(',', $pks);
		foreach ($pks as $_) {
			if ($_ <= 0) {
				$errNo = ErrorNo::ERROR_ARGS_DELETE;
				$errMsg = $this->_('ERROR_MSG_ERROR_ARGS_DELETE');
				Log::warning(sprintf(
					'%s pks "%s"', $errMsg, $pk
				), $errNo, __METHOD__);
				return array(
					'err_no' => $errNo,
					'err_msg' => $errMsg,
					'ids' => $pk
				);
			}
		}

		$rowCount = $this->getDb()->batchUpdateByPk($pk, array($columnName => $value));
		if ($rowCount === false) {
			$errNo = ErrorNo::ERROR_DB_DELETE;
			$errMsg = $this->_('ERROR_MSG_ERROR_DB_DELETE');
			Log::warning(sprintf(
				'%s pks "%s", columnName "%s", value "%s"', $errMsg, $pk, $columnName, $value
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'ids' => $pk
			);
		}

		$errNo = ErrorNo::SUCCESS_NUM;
		$errMsg = ($rowCount > 0) ? $this->_('ERROR_MSG_SUCCESS_DELETE') : $this->_('ERROR_MSG_ERROR_DB_AFFECTS_ZERO');
		Log::debug(sprintf(
			'%s pks "%s", rowCount "%d", columnName "%s", value "%s"', $errMsg, $pk, $rowCount, $columnName, $value
		), __METHOD__);

		return array(
			'err_no' => $errNo,
			'err_msg' => $errMsg,
			'row_count' => $rowCount,
			'ids' => $pk
		);
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
		$pk = (int) $pk;
		if ($pk <= 0) {
			$errNo = ErrorNo::ERROR_ARGS_RESTORE;
			$errMsg = $this->_('ERROR_MSG_ERROR_ARGS_RESTORE');
			Log::warning(sprintf(
				'%s pk "%d"', $errMsg, $pk
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'id' => $pk
			);
		}

		$rowCount = $this->getDb()->updateByPk($pk, array($columnName => $value));
		if ($rowCount === false) {
			$errNo = ErrorNo::ERROR_DB_RESTORE;
			$errMsg = $this->_('ERROR_MSG_ERROR_DB_RESTORE');
			Log::warning(sprintf(
				'%s pk "%d", columnName "%s", value "%s"', $errMsg, $pk, $columnName, $value
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'id' => $pk
			);
		}

		$errNo = ErrorNo::SUCCESS_NUM;
		$errMsg = ($rowCount > 0) ? $this->_('ERROR_MSG_SUCCESS_RESTORE') : $this->_('ERROR_MSG_ERROR_DB_AFFECTS_ZERO');
		Log::debug(sprintf(
			'%s pk "%d", rowCount "%d", columnName "%s", value "%s"', $errMsg, $pk, $rowCount, $columnName, $value
		), __METHOD__);

		return array(
			'err_no' => $errNo,
			'err_msg' => $errMsg,
			'row_count' => $rowCount,
			'id' => $pk
		);
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
		$pks = array_map('intval', $pks);
		$pk = implode(',', $pks);
		foreach ($pks as $_) {
			if ($_ <= 0) {
				$errNo = ErrorNo::ERROR_ARGS_RESTORE;
				$errMsg = $this->_('ERROR_MSG_ERROR_ARGS_RESTORE');
				Log::warning(sprintf(
					'%s pks "%s"', $errMsg, $pk
				), $errNo, __METHOD__);
				return array(
					'err_no' => $errNo,
					'err_msg' => $errMsg,
					'ids' => $pk
				);
			}
		}

		$rowCount = $this->getDb()->batchUpdateByPk($pk, array($columnName => $value));
		if ($rowCount === false) {
			$errNo = ErrorNo::ERROR_DB_RESTORE;
			$errMsg = $this->_('ERROR_MSG_ERROR_DB_RESTORE');
			Log::warning(sprintf(
				'%s pks "%s", columnName "%s", value "%s"', $errMsg, $pk, $columnName, $value
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'ids' => $pk
			);
		}

		$errNo = ErrorNo::SUCCESS_NUM;
		$errMsg = ($rowCount > 0) ? $this->_('ERROR_MSG_SUCCESS_RESTORE') : $this->_('ERROR_MSG_ERROR_DB_AFFECTS_ZERO');
		Log::debug(sprintf(
			'%s pks "%s", rowCount "%d", columnName "%s", value "%s"', $errMsg, $pk, $rowCount, $columnName, $value
		), __METHOD__);

		return array(
			'err_no' => $errNo,
			'err_msg' => $errMsg,
			'row_count' => $rowCount,
			'ids' => $pk
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

		$errNo = ErrorNo::SUCCESS_NUM;
		$errMsg = ($rowCount > 0) ? $this->_('ERROR_MSG_SUCCESS_DELETE') : $this->_('ERROR_MSG_ERROR_DB_AFFECTS_ZERO');
		Log::debug(sprintf(
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
	 * @return array
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

		$errNo = ErrorNo::SUCCESS_NUM;
		$errMsg = ($rowCount > 0) ? $this->_('ERROR_MSG_SUCCESS_DELETE') : $this->_('ERROR_MSG_ERROR_DB_AFFECTS_ZERO');
		Log::debug(sprintf(
			'%s pks "%s", rowCount "%d"', $errMsg, $value, $rowCount
		), __METHOD__);

		return array(
			'err_no' => $errNo,
			'err_msg' => $errMsg,
			'row_count' => $rowCount,
			'ids' => $value
		);
	}
}
