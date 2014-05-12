<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace app;

use tfc\ap\HttpCookie;
use tfc\mvc\Mvc;
use tfc\saf\Log;
use srv\Model;

/**
 * Service abstract class file
 * 业务层基类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Service.php 1 2013-05-18 14:58:59Z huan.song $
 * @package app
 * @since 1.0
 */
abstract class Service
{
	/**
	 * @var string 存放最后一次访问的列表页链接的Cookie名
	 */
	const COOKIE_NAME_LAST_LIST_URL = 'last_list_url';

	/**
	 * 获取查询列表数据Action名
	 * @return string
	 */
	public abstract function getActList();

	/**
	 * 获取默认最后一次访问的列表页链接
	 * @return string
	 */
	public function getDefaultLastListUrl()
	{
		return Mvc::getView()->getUrlManager()->getUrl($this->getActList(), Mvc::$controller, Mvc::$module);
	}

	/**
	 * 获取最后一次访问的列表页链接
	 * @return string
	 */
	public function getLastListUrl()
	{
		$value = HttpCookie::get(self::COOKIE_NAME_LAST_LIST_URL);
		if ($value !== null && strpos($value, '__') !== false) {
			list($router, $url) = explode('__', $value);
			if ($router === Mvc::$module . '_' . Mvc::$controller . '_' . $this->getActList()) {
				return base64_decode($url);
			}
		}

		return $this->getDefaultLastListUrl();
	}

	/**
	 * 设置最后一次访问的列表页链接
	 * @param array $params
	 * @return void
	 */
	public function setLastListUrl(array $params = array())
	{
		$url = Mvc::getView()->getUrlManager()->getUrl($this->getActList(), Mvc::$controller, Mvc::$module, $params);
		$router = Mvc::$module . '_' . Mvc::$controller . '_' . $this->getActList();
		$value = $router . '__' . str_replace('=', '', base64_encode($url));
		HttpCookie::add(self::COOKIE_NAME_LAST_LIST_URL, $value);
	}

	/**
	 * 调用查询类方法
	 * @param srv\Model $object
	 * @param string $method
	 * @param array $args
	 * @return array
	 */
	public function callFetchMethod(Model $object, $method, array $args = array())
	{
		$data = call_user_func_array(array($object, $method), $args);
		if ($data === false) {
			$errNo = ErrorNo::ERROR_DB_SELECT;
			$errMsg = Lang::_('ERROR_MSG_ERROR_DB_SELECT');
			Log::warning(sprintf(
				'%s callFetchMethod, model "%s", method "%s", args "%s"',
				$errMsg, get_class($object), $method, serialize($args)
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg
			);
		}

		$errNo = ErrorNo::SUCCESS_NUM;

		if (empty($data)) {
			$errMsg = Lang::_('ERROR_MSG_ERROR_DB_SELECT_EMPTY');
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'data' => array()
			);
		}

		$errMsg = Lang::_('ERROR_MSG_SUCCESS_SELECT');
		return array(
			'err_no' => $errNo,
			'err_msg' => $errMsg,
			'data' => $data
		);
	}

	/**
	 * 调用新增类方法
	 * @param srv\Model $object
	 * @param string $method
	 * @param array $params
	 * @param boolean $ignore
	 * @return array
	 */
	public function callCreateMethod(Model $object, $method, array $params = array(), $ignore = false)
	{
		$lastInsertId = $object->$method($params, $ignore);
		$errors = $object->getErrors();
		if (($lastInsertId === false && $errors === array()) || $lastInsertId === 0 || $lastInsertId < 0) {
			$errNo = ErrorNo::ERROR_DB_INSERT;
			$errMsg = Lang::_('ERROR_MSG_ERROR_DB_INSERT');
			Log::warning(sprintf(
				'%s callCreateMethod, model "%s", method "%s", params "%s", ignore "%d"',
				$errMsg, get_class($object), $method, serialize($params), $ignore
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg
			);
		}

		if ($lastInsertId === false) {
			$errNo = ErrorNo::ERROR_ARGS_INSERT;
			$errMsg = Lang::_('ERROR_MSG_ERROR_ARGS_INSERT');
			Log::warning(sprintf(
				'%s callCreateMethod, model "%s", method "%s", params "%s", ignore "%d", errors "%s"',
				$errMsg, get_class($object), $method, serialize($params), $ignore, serialize($errors)
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'errors' => $errors
			);
		}

		$errNo = ErrorNo::SUCCESS_NUM;
		$errMsg = Lang::_('ERROR_MSG_SUCCESS_INSERT');
		Log::debug(sprintf(
			'%s callCreateMethod, last insert id "%d", params "%s", ignore "%d"',
			$errMsg, $lastInsertId, serialize($params), $ignore
		), $errNo, __METHOD__);

		return array(
			'err_no' => $errNo,
			'err_msg' => $errMsg,
			'id' => $lastInsertId
		);
	}

	/**
	 * 调用编辑类方法
	 * @param srv\Model $object
	 * @param string $method
	 * @param integer $id
	 * @param array $params
	 * @return array
	 */
	public function callModifyMethod(Model $object, $method, $id, array $params = array())
	{
		if (($id = (int) $id) <= 0) {
			$errNo = ErrorNo::ERROR_ARGS_UPDATE;
			$errMsg = Lang::_('ERROR_MSG_ERROR_ARGS_UPDATE');
			Log::warning(sprintf(
				'%s callModifyMethod, model "%s", method "%s", id "%d", params "%s"',
				$errMsg, get_class($object), $method, $id, serialize($params)
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'id' => $id
			);
		}

		$rowCount = $object->$method($id, $params);
		$errors = $object->getErrors();
		if ($rowCount === false) {
			if ($errors === array()) {
				$errNo = ErrorNo::ERROR_DB_UPDATE;
				$errMsg = Lang::_('ERROR_MSG_ERROR_DB_UPDATE');
				Log::warning(sprintf(
					'%s callModifyMethod, model "%s", method "%s", id "%d", params "%s"',
					$errMsg, get_class($object), $method, $id, serialize($params)
				), $errNo, __METHOD__);
				return array(
					'err_no' => $errNo,
					'err_msg' => $errMsg,
					'id' => $id
				);
			}

			$errNo = ErrorNo::ERROR_ARGS_UPDATE;
			$errMsg = Lang::_('ERROR_MSG_ERROR_ARGS_UPDATE');
			Log::warning(sprintf(
				'%s callModifyMethod, model "%s", method "%s", id "%d", params "%s", errors "%s"',
				$errMsg, get_class($object), $method, $id, serialize($params), serialize($errors)
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'id' => $id,
				'errors' => $errors
			);
		}

		$errNo = ErrorNo::SUCCESS_NUM;
		$errMsg = ($rowCount > 0) ? Lang::_('ERROR_MSG_SUCCESS_UPDATE') : Lang::_('ERROR_MSG_ERROR_DB_AFFECTS_ZERO');
		Log::debug(sprintf(
			'%s callModifyMethod, model "%s", method "%s", id "%d", rowCount "%d", params "%s"',
			$errMsg, get_class($object), $method, $id, $rowCount, serialize($params)
		), $errNo, __METHOD__);

		return array(
			'err_no' => $errNo,
			'err_msg' => $errMsg,
			'id' => $id,
			'row_count' => $rowCount
		);
	}

	/**
	 * 调用删除类方法
	 * @param srv\Model $object
	 * @param string $method
	 * @param integer $id
	 * @return array
	 */
	public function callRemoveMethod(Model $object, $method, $id)
	{
		$id = (int) $id;
		$rowCount = $object->$method($id);
		if ($rowCount === false) {
			$errNo = ErrorNo::ERROR_DB_DELETE;
			$errMsg = Lang::_('ERROR_MSG_ERROR_DB_DELETE');
			Log::warning(sprintf(
				'%s callRemoveMethod, model "%s", method "%s", id "%d"',
				$errMsg, get_class($object), $method, $id
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'id' => $id
			);
		}

		$errNo = ErrorNo::SUCCESS_NUM;
		$errMsg = ($rowCount > 0) ? Lang::_('ERROR_MSG_SUCCESS_DELETE') : Lang::_('ERROR_MSG_ERROR_DB_AFFECTS_ZERO');
		Log::debug(sprintf(
			'%s callRemoveMethod, model "%s", method "%s", id "%d", rowCount "%d"',
			$errMsg, get_class($object), $method, $id, $rowCount
		), $errNo, __METHOD__);

		return array(
			'err_no' => $errNo,
			'err_msg' => $errMsg,
			'row_count' => $rowCount
		);
	}
}
