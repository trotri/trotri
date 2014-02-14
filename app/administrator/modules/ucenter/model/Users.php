<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\ucenter\model;

use tfc\ap\Ap;
use tfc\ap\Singleton;
use tfc\saf\Log;
use koala\Model;
use library\Auth;
use library\ErrorNo;
use library\UcenterFactory;

/**
 * Users class file
 * 业务处理层类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Users.php 1 2014-02-11 15:51:13Z huan.song $
 * @package modules.ucenter.model
 * @since 1.0
 */
class Users extends Model
{
	/**
	 * 构造方法：初始化当前业务类对应的数据库操作类
	 */
	public function __construct()
	{
		$db = UcenterFactory::getDb('Users');
		parent::__construct($db);
	}

	/**
	 * 查询数据
	 * @param array $params
	 * @param string $order
	 * @param integer $pageNo
	 * @return array
	 */
	public function search(array $params = array(), $order = '', $pageNo = 0)
	{
		$attributes = array();
		//--待开发--
		$ret = $this->findIndexByAttributes($attributes, $order, $pageNo);
		return $ret;
	}

	/**
	 * (non-PHPdoc)
	 * @see koala.Model::findByPk()
	 */
	public function findByPk($value)
	{
		$ret = UcenterFactory::getModel('UserGroups')->findGroupIdsByUserId($value);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return $ret;
		}

		$groupIds = $ret['data'];
		$ret = parent::findByPk($value);
		if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
			$ret['data']['group_ids'] = $groupIds;
			unset($ret['data']['password']);
		}

		return $ret;
	}

	/**
	 * 新增一条记录
	 * @param array $params
	 * @return array
	 */
	public function create(array $params = array())
	{
		$attributes = array();

		$attributes['dt_registered'] = $attributes['dt_last_login'] = date('Y-m-d H:i:s');
		$attributes['ip_registered'] = $attributes['ip_last_login'] = ip2long(Ap::getRequest()->getClientIp());
		$attributes['login_count'] = 1;
		$attributes['repwd_count'] = 0;
		$attributes['salt'] = Auth::getSalt();

		$attributes['login_name'] = $loginName = isset($params['login_name']) ? trim($params['login_name']) : '';
		$attributes['login_type'] = $loginType = Auth::getLoginType($loginName);
		$userName = isset($params['user_name']) ? trim($params['user_name']) : '';
		if ($userName !== '') {
			$attributes['user_name'] = $userName;
		}

		$userMail = isset($params['user_mail']) ? trim($params['user_mail']) : '';
		if ($userMail !== '') {
			$attributes['user_mail'] = $userMail;
		}

		$userPhone = isset($params['user_phone']) ? trim($params['user_phone']) : '';
		if ($userPhone !== '') {
			$attributes['user_phone'] = $userPhone;
		}

		$attributes['password'] = isset($params['password']) ? trim($params['password']) : '';
		$attributes['repassword'] = isset($params['repassword']) ? trim($params['repassword']) : '';

		if (isset($params['valid_mail'])) {
			$attributes['valid_mail'] = $params['valid_mail'];
		}

		if (isset($params['valid_phone'])) {
			$attributes['valid_phone'] = $params['valid_phone'];
		}

		if (isset($params['forbidden'])) {
			$attributes['forbidden'] = $params['forbidden'];
		}

		if (isset($params['trash'])) {
			$attributes['trash'] = $params['trash'];
		}

		$filter = Singleton::getInstance('tfc\\validator\\Filter');
		$rules = $this->getInsertRules();
		if (is_array($rules)) {
			if (!$filter->run($rules, $attributes, false)) {
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

		unset($attributes['repassword']);
		$attributes['password'] = Auth::encrypt($attributes['password'], $attributes['salt']);

		if (!isset($attributes['user_mail']) && $loginType === Auth::LOGIN_TYPE_MAIL) {
			$attributes['user_mail'] = $attributes['login_name'];
		}

		if (!isset($attributes['user_phone']) && $loginType === Auth::LOGIN_TYPE_PHONE) {
			$attributes['user_phone'] = $attributes['login_name'];
		}

		$userId = $this->getDb()->insert($attributes);
		if ($userId === false || $userId <= 0) {
			$errNo = ErrorNo::ERROR_DB_INSERT;
			$errMsg = $this->_('ERROR_MSG_ERROR_DB_INSERT');
			Log::warning(sprintf(
				'%s pk "%d", attributes "%s"', $errMsg, $userId, serialize($attributes)
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg
			);
		}

		$groupIds = isset($params['group_ids']) ? (array) $params['group_ids'] : array();
		$ret = UcenterFactory::getModel('UserGroups')->modify($userId, $groupIds);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return $ret;
		}

		$errNo = ErrorNo::SUCCESS_NUM;
		$errMsg = $this->_('ERROR_MSG_SUCCESS_INSERT');
		Log::notice(sprintf(
			'%s pk "%s", attributes "%s"', $errMsg, $userId, serialize($attributes)
		), __METHOD__);

		return array(
			'err_no' => $errNo,
			'err_msg' => $errMsg,
			'id' => $userId
		);
	}

	/**
	 * 通过主键，编辑一条记录
	 * @param integer $value
	 * @param array $params
	 * @return array
	 */
	public function modifyByPk($value, array $params)
	{
		$attributes = array();

		$password = isset($params['password']) ? trim($params['password']) : '';
		if ($password !== '') {
			$attributes['salt'] = Auth::getSalt();
			$attributes['password'] = $password;
			$attributes['repassword'] = isset($params['repassword']) ? trim($params['repassword']) : '';

			$attributes['dt_last_repwd'] = date('Y-m-d H:i:s');
			$attributes['ip_last_repwd'] = ip2long(Ap::getRequest()->getClientIp());

			$ret = $this->getByPk('repwd_count', $value);
			$repwdCount = ($ret['err_no'] === ErrorNo::SUCCESS_NUM) ? $ret['repwd_count'] : 0;
			$attributes['repwd_count'] = ++$repwdCount;
		}

		$userName = isset($params['user_name']) ? trim($params['user_name']) : null;
		if ($userName) {
			$attributes['user_name'] = $userName;
		}

		$userMail = isset($params['user_mail']) ? trim($params['user_mail']) : null;
		if ($userMail) {
			$attributes['user_mail'] = $userMail;
		}

		$userPhone = isset($params['user_phone']) ? trim($params['user_phone']) : null;
		if ($userPhone) {
			$attributes['user_phone'] = $userPhone;
		}

		if (isset($params['valid_mail'])) {
			$attributes['valid_mail'] = $params['valid_mail'];
		}

		if (isset($params['valid_phone'])) {
			$attributes['valid_phone'] = $params['valid_phone'];
		}

		if (isset($params['forbidden'])) {
			$attributes['forbidden'] = $params['forbidden'];
		}

		if (isset($params['trash'])) {
			$attributes['trash'] = $params['trash'];
		}

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

		$filter = Singleton::getInstance('tfc\\validator\\Filter');
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

		if (isset($attributes['password'])) {
			unset($attributes['repassword']);
			$attributes['password'] = Auth::encrypt($attributes['password'], $attributes['salt']);
		}

		if ($userName === '') {
			$attributes['user_name'] = $userName;
		}

		if ($userMail === '') {
			$attributes['user_mail'] = $userMail;
		}

		if ($userPhone === '') {
			$attributes['user_phone'] = $userPhone;
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

		$groupIds = isset($params['group_ids']) ? (array) $params['group_ids'] : array();
		$ret = UcenterFactory::getModel('UserGroups')->modify($value, $groupIds);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return $ret;
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
	 * (non-PHPdoc)
	 * @see koala.Model::getInsertRules()
	 */
	public function getInsertRules()
	{
		$elements = UcenterFactory::getElements('Users');
		$type = $elements::TYPE_FILTER;
		$output = array(
			'login_name' => $elements->getLoginName($type),
			'password' => $elements->getPassword($type),
			'repassword' => $elements->getRepassword($type),
			'user_name' => $elements->getUserName($type),
			'user_mail' => $elements->getUserMail($type),
			'user_phone' => $elements->getUserPhone($type),
			'valid_mail' => $elements->getValidMail($type),
			'valid_phone' => $elements->getValidPhone($type),
			'forbidden' => $elements->getForbidden($type),
			'trash' => $elements->getTrash($type),
		);

		return $output;
	}

	/**
	 * (non-PHPdoc)
	 * @see koala.Model::getUpdateRules()
	 */
	public function getUpdateRules()
	{
		$elements = UcenterFactory::getElements('Users');
		$type = $elements::TYPE_FILTER;
		$output = array(
			'password' => $elements->getPassword($type),
			'repassword' => $elements->getRepassword($type),
			'user_name' => $elements->getUserName($type),
			'user_mail' => $elements->getUserMail($type),
			'user_phone' => $elements->getUserPhone($type),
			'valid_mail' => $elements->getValidMail($type),
			'valid_phone' => $elements->getValidPhone($type),
			'forbidden' => $elements->getForbidden($type),
			'trash' => $elements->getTrash($type),
		);

		return $output;
	}

	/**
	 * 通过登录名统计记录数
	 * @param string $loginName
	 * @return integer
	 */
	public function countByLoginName($loginName)
	{
		$ret = $this->countByAttributes(array(
			'login_name' => $loginName,
		));

		if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
			return $ret['total'];
		}

		return false;
	}

}
