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
use tfc\saf\Log;
use library\ErrorNo;
use library\ErrorMsg;

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
	 * 新增一条记录
	 * @param array $attributes
	 * @param array $rules
	 * @param boolean $ignore
	 * @return array
	 */
	public function insert(array $attributes = array(), array $rules = array(), $ignore = false)
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

		if (!empty($rules)) {
			$filter = Singleton::getInstance('tfc\validator\Filter');
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
	 * 通过主键，编辑一条记录
	 * @param integer $value
	 * @param array $attributes
	 * @param array $rules
	 * @return array
	 */
	public function updateByPk($value, array $attributes = array(), array $rules = array())
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

		if (!empty($rules)) {
			$filter = Singleton::getInstance('tfc\validator\Filter');
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
	 * 通过主键，删除一条记录
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
	 * 获取DB操作类
	 * @return instance of tfc\saf\DbProxy
	 */
	public abstract function getDb();
}
