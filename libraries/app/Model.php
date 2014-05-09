<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace srv;

use tfc\saf\ErrorNo;
use tfc\saf\Log;

/**
 * Model abstract class file
 * 业务层：模型基类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Model.php 1 2013-05-18 14:58:59Z huan.song $
 * @package srv
 * @since 1.0
 */
abstract class Model
{
	/**
	 * 调用DB的查询类方法
	 * @param srv\library\Db $db
	 * @param string $method
	 * @param array $args
	 * @return array
	 */
	public function callFetchMethod(Db $db, $method, array $args = array())
	{
		$data = call_user_func_array(array($db, $method), $args);
		if ($data === false) {
			$errNo = ErrorNo::ERROR_DB_SELECT;
			$errMsg = Text::_('ERROR_MSG_ERROR_DB_SELECT');
			Log::warning(sprintf(
				'%s callFetchMethod, db "%s", method "%s", args "%s"',
				$errMsg, get_class($db), $method, serialize($args)
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg
			);
		}

		$errNo = ErrorNo::SUCCESS_NUM;

		if (empty($data)) {
			$errMsg = Text::_('ERROR_MSG_ERROR_DB_SELECT_EMPTY');
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'data' => array()
			);
		}

		$errMsg = Text::_('ERROR_MSG_SUCCESS_SELECT');
		return array(
			'err_no' => $errNo,
			'err_msg' => $errMsg,
			'data' => $data
		);
	}

	/**
	 * 调用DB的新增类方法
	 * @param srv\library\Db $db
	 * @param string $method
	 * @param array $params
	 * @param srv\library\FormProcessor $fp
	 * @param boolean $ignore
	 * @return array
	 */
	public function callCreateMethod(Db $db, $method, array $params = array(), FormProcessor $fp, $ignore = false)
	{
		if (!$fp->process($params)) {
			$errNo = ErrorNo::ERROR_ARGS_INSERT;
			$errMsg = Text::_('ERROR_MSG_ERROR_ARGS_INSERT');
			$errors = $fp->getErrors(true);
			Log::warning(sprintf(
				'%s callCreateMethod, params "%s", errors "%s"',
				$errMsg, serialize($params), serialize($errors)
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'errors' => $errors
			);
		}

		$attributes = $fp->getValues();
		if (!$attributes) {
			$errNo = ErrorNo::ERROR_ARGS_INSERT;
			$errMsg = Text::_('ERROR_MSG_ERROR_ARGS_INSERT');
			Log::warning(sprintf(
				'%s callCreateMethod, attributes empty, ignore "%d"', $errMsg, $ignore
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg
			);
		}

		$lastInsertId = call_user_func_array(array($db, $method), array($attributes, $ignore));
		if ($lastInsertId === false || $lastInsertId <= 0) {
			$errNo = ErrorNo::ERROR_DB_INSERT;
			$errMsg = Text::_('ERROR_MSG_ERROR_DB_INSERT');
			Log::warning(sprintf(
				'%s callCreateMethod, db "%s", method "%s", attributes "%s", ignore "%d"',
				get_class($db), $method, serialize($attributes), $ignore
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg
			);
		}

		$errNo = ErrorNo::SUCCESS_NUM;
		$errMsg = Text::_('ERROR_MSG_SUCCESS_INSERT');
		Log::debug(sprintf(
			'%s callCreateMethod, primary key "%d", attributes "%s", ignore "%d"',
			$lastInsertId, serialize($attributes), $ignore
		), $errNo, __METHOD__);

		return array(
			'err_no' => $errNo,
			'err_msg' => $errMsg,
			'id' => $lastInsertId
		);
	}

	/**
	 * 调用DB的编辑类方法
	 * @param srv\library\Db $db
	 * @param string $method
	 * @param integer $id
	 * @param array $params
	 * @param srv\library\FormProcessor $fp
	 * @return array
	 */
	public function callModifyMethod(Db $db, $method, $id, array $params = array(), FormProcessor $fp)
	{
		if (($id = (int) $id) <= 0) {
			$errNo = ErrorNo::ERROR_ARGS_UPDATE;
			$errMsg = Text::_('ERROR_MSG_ERROR_ARGS_UPDATE');
			Log::warning(sprintf(
				'%s callModifyMethod, primary key "%d"', $errMsg, $id
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'id' => $id
			);
		}

		if (!$fp->process($params, $id)) {
			$errNo = ErrorNo::ERROR_ARGS_UPDATE;
			$errMsg = Text::_('ERROR_MSG_ERROR_ARGS_UPDATE');
			$errors = $fp->getErrors(true);
			Log::warning(sprintf(
				'%s callModifyMethod, primary key "%d", params "%s", errors "%s"',
				$errMsg, $id, serialize($params), serialize($errors)
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'id' => $id,
				'errors' => $errors
			);
		}

		$attributes = $fp->getValues();
		if (!$attributes) {
			$errNo = ErrorNo::ERROR_ARGS_UPDATE;
			$errMsg = Text::_('ERROR_MSG_ERROR_ARGS_UPDATE');
			Log::warning(sprintf(
				'%s callModifyMethod, primary key "%d", attributes empty',
				$errMsg, $id, serialize($params), serialize($errors)
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'id' => $id
			);
		}

		$rowCount = call_user_func_array(array($db, $method), array($id, $attributes));
		if ($rowCount === false) {
			$errNo = ErrorNo::ERROR_DB_UPDATE;
			$errMsg = Text::_('ERROR_MSG_ERROR_DB_UPDATE');
			Log::warning(sprintf(
				'%s callModifyMethod, db "%s", method "%s", primary key "%d", attributes "%s"',
				get_class($db), $method, $errMsg, $id, serialize($attributes)
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'id' => $id
			);
		}

		$errNo = ErrorNo::SUCCESS_NUM;
		$errMsg = ($rowCount > 0) ? Text::_('ERROR_MSG_SUCCESS_UPDATE') : Text::_('ERROR_MSG_ERROR_DB_AFFECTS_ZERO');
		Log::warning(sprintf(
			'%s callModifyMethod, primary key "%d", rowCount "%d", attributes "%s"',
			$errMsg, $id, $rowCount, serialize($attributes)
		), $errNo, __METHOD__);

		return array(
			'err_no' => $errNo,
			'err_msg' => $errMsg,
			'id' => $id,
			'row_count' => $rowCount
		);
	}

	/**
	 * 调用DB的删除类方法
	 * @param srv\library\Db $db
	 * @param string $method
	 * @param array $args
	 * @return array
	 */
	public function callRemoveMethod(Db $db, $method, array $args = array())
	{
		$rowCount = call_user_func_array(array($db, $method), $args);
		if ($rowCount === false) {
			$errNo = ErrorNo::ERROR_DB_DELETE;
			$errMsg = Text::_('ERROR_MSG_ERROR_DB_DELETE');
			Log::warning(sprintf(
				'%s callRemoveMethod, db "%s", method "%s", args "%s"',
				$errMsg, get_class($db), $method, serialize($args)
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg
			);
		}

		$errNo = ErrorNo::SUCCESS_NUM;
		$errMsg = ($rowCount > 0) ? Text::_('ERROR_MSG_SUCCESS_DELETE') : Text::_('ERROR_MSG_ERROR_DB_AFFECTS_ZERO');
		return array(
			'err_no' => $errNo,
			'err_msg' => $errMsg,
			'row_count' => $rowCount
		);
	}
}
