<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\users\model;

use tfc\saf\Cfg;
use tid\Authentication;
use users\library\Lang;
use users\services\DataAccount;
use users\services\Account AS SrvAccount;

/**
 * Account class file
 * 用户账户管理
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Account.php 1 2014-08-08 14:05:27Z Code Generator $
 * @package modules.users.model
 * @since 1.0
 */
class Account
{
	/**
	 * @var srv\srvname\services\classname 业务处理类
	 */
	protected $_service = null;

	/**
	 * 构造方法：初始化数据库操作类
	 */
	public function __construct()
	{
		$this->_service = new SrvAccount();
	}

	/**
	 * 用户登录
	 * @param string $loginName
	 * @param string $password
	 * @param boolean $rememberMe
	 * @return array
	 */
	public function login($loginName, $password, $rememberMe = false)
	{
		$ret = $this->_service->login($loginName, $password);

		$errNo = DataAccount::ERROR_LOGIN_UNKNOWN_WRONG;
		$errMsg = Lang::_('SRV_FILTER_ACCOUNT_LOGIN_UNKNOWN_WRONG');

		if (isset($ret['err_no'])) {
			$errNo = (int) $ret['err_no'];
		}

		if (isset($ret['err_msg'])) {
			$errMsg = $ret['err_msg'];
		}

		if ($errNo !== DataAccount::SUCCESS_LOGIN_NUM) {
			$ret = array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'data' => array(
					'login_name' => $loginName,
					'remember_me' => $rememberMe
				)
			);

			return $ret;
		}

		$data = isset($ret['data']) ? (array) $ret['data'] : array();

		$userId = isset($data['user_id']) ? (int) $data['user_id'] : 0;
		$loginName = isset($data['login_name']) ? $data['login_name'] : '';
		$password = isset($data['password']) ? $data['password'] : '';

		$loginNameExpiry = Cfg::getApp('login_name_expiry', 'login');
		$passwordExpiry = $rememberMe ? Cfg::getApp('password_expiry', 'login') : 0;

		$auth = new Authentication('login');
		$auth->setIdentity($userId, $loginName, $password, $passwordExpiry);
		$auth->getCookie()->add('unick', $loginName, $loginNameExpiry + mktime());

		$ret = array(
			'err_no' => $errNo,
			'err_msg' => $errMsg,
			'data' => array(
				'user_id' => $userId,
				'login_name' => $loginName,
				'remember_me' => $rememberMe
			)
		);

		return $ret;
	}
}
