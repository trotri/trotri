<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace users\services;

use tfc\ap\Ap;
use tfc\saf\Log;
use users\library\Lang;

/**
 * Account class file
 * 业务层：业务处理类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Account.php 1 2014-08-07 10:09:58Z huan.song $
 * @package users.services
 * @since 1.0
 */
class Account
{
	/**
	 * @var instance of users\services\Users
	 */
	protected $_users = null;

	/**
	 * 构造方法：初始化数据库操作类
	 */
	public function __construct()
	{
		$this->_users = new Users();
	}

	/**
	 * 用户登录
	 * @param string $loginName
	 * @param string $password
	 * @return array
	 */
	public function login($loginName, $password)
	{
		if (($loginName = trim($loginName)) === '') {
			$errNo = DataAccount::ERROR_LOGIN_NAME_EMPTY;
			$errMsg = Lang::_('SRV_FILTER_ACCOUNT_LOGIN_NAME_EMPTY');
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'login_name' => $loginName
			);
		}

		if (($password = trim($password)) === '') {
			$errNo = DataAccount::ERROR_LOGIN_PASSWORD_EMPTY;
			$errMsg = Lang::_('SRV_FILTER_ACCOUNT_LOGIN_PASSWORD_EMPTY');
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'login_name' => $loginName
			);
		}

		$row = $this->_users->findByLoginName($loginName);
		if (!$row || !is_array($row) || !isset($row['user_id'], $row['login_name'], $row['password'], $row['salt'], $row['trash'], $row['forbidden'], $row['login_count'])) {
			$errNo = DataAccount::ERROR_LOGIN_NAME_UNDEFINED;
			$errMsg = Lang::_('SRV_FILTER_ACCOUNT_LOGIN_NAME_UNDEFINED');
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'login_name' => $loginName
			);
		}

		$loginName = $row['login_name'];
		if ($row['trash'] !== DataUsers::TRASH_N) {
			$errNo = DataAccount::ERROR_LOGIN_USER_TRASH;
			$errMsg = Lang::_('SRV_FILTER_ACCOUNT_LOGIN_USER_TRASH');
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'login_name' => $loginName,
			);
		}

		if ($row['forbidden'] !== DataUsers::FORBIDDEN_N) {
			$errNo = DataAccount::ERROR_LOGIN_USER_FORBIDDEN;
			$errMsg = Lang::_('SRV_FILTER_ACCOUNT_LOGIN_USER_FORBIDDEN');
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'login_name' => $loginName,
			);
		}

		$password = $this->_users->encrypt($password, $row['salt']);
		if ($password !== $row['password']) {
			$errNo = DataAccount::ERROR_LOGIN_PASSWORD_WRONG;
			$errMsg = Lang::_('SRV_FILTER_ACCOUNT_LOGIN_PASSWORD_WRONG');
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'login_name' => $loginName,
			);
		}

		$userId = (int) $row['user_id'];
		$dtLastLogin = date('Y-m-d H:i:s');
		$ipLastLogin = ip2long(Ap::getRequest()->getClientIp());
		$loginCount = (int) $row['login_count'] + 1;
		$params = array(
			'dt_last_login' => $dtLastLogin,
			'ip_last_login' => $ipLastLogin,
			'login_count' => $loginCount,
		);

		$rowCount = $this->_users->modifyByPk($userId, $params);
		if (!$rowCount) {
			Log::warning(sprintf(
				'Users update dt_last_login|ip_last_login|login_count Failed, user_id "%d", login_name "%s"', $userId, $loginName
			), 0,  __METHOD__);
		}

		$loginType = isset($row['login_type']) ? $row['login_type'] : '';
		$salt = $row['salt'];
		$userName = isset($row['user_name']) ? $row['user_name'] : '';
		$userMail = isset($row['user_mail']) ? $row['user_mail'] : '';
		$userPhone = isset($row['user_phone']) ? $row['user_phone'] : '';
		$dtRegistered = isset($row['dt_registered']) ? $row['dt_registered'] : '';
		$dtLastRepwd = isset($row['dt_last_repwd']) ? $row['dt_last_repwd'] : '';
		$ipRegistered = isset($row['ip_registered']) ? (int) $row['ip_registered'] : 0;
		$ipLastRepwd = isset($row['ip_last_repwd']) ? (int) $row['ip_last_repwd'] : 0;
		$repwdCount = isset($row['repwd_count']) ? (int) $row['repwd_count'] : 0;
		$validMail = (isset($row['valid_mail']) && $row['valid_mail'] === DataUsers::VALID_MAIL_Y) ? true : false;
		$validPhone = (isset($row['valid_phone']) && $row['valid_phone'] === DataUsers::VALID_PHONE_Y) ? true : false;

		$data = array(
			'user_id' => $userId,
			'login_name' => $loginName,
			'login_type' => $loginType,
			'password' => $password,
			'salt' => $salt,
			'user_name' => $userName,
			'user_mail' => $userMail,
			'user_phone' => $userPhone,
			'dt_registered' => $dtRegistered,
			'dt_last_login' => $dtLastLogin,
			'dt_last_repwd' => $dtLastRepwd,
			'ip_registered' => $ipRegistered,
			'ip_last_login' => $ipLastLogin,
			'ip_last_repwd' => $ipLastRepwd,
			'login_count' => $loginCount,
			'repwd_count' => $repwdCount,
			'valid_mail' => $validMail,
			'valid_phone' => $validPhone
		);

		$errNo = DataAccount::SUCCESS_LOGIN_NUM;
		$errMsg = Lang::_('SRV_FILTER_ACCOUNT_LOGIN_SUCCESS');
		return array(
			'err_no' => $errNo,
			'err_msg' => $errMsg,
			'data' => $data
		);
	}
}
